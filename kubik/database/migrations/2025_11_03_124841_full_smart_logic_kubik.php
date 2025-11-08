<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        /* ============================================================
           AUTO PREFIX ID TRIGGER (CATEGORIES, TYPES, ASSET MASTERS, ASSETS, BOOKINGS)
        ============================================================ */

        // === Categories ===
        DB::unprepared("
            CREATE TRIGGER trg_categories_autoid
            BEFORE INSERT ON categories
            FOR EACH ROW
            BEGIN
                SET NEW.id_category = CONCAT('CAT-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_category, 5) AS UNSIGNED)), 0) + 1 FROM categories),
                    6, '0'
                ));
            END
        ");

        // === Types ===
        DB::unprepared("
            CREATE TRIGGER trg_types_autoid
            BEFORE INSERT ON types
            FOR EACH ROW
            BEGIN
                SET NEW.id_type = CONCAT('TYP-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_type, 5) AS UNSIGNED)), 0) + 1 FROM types),
                    6, '0'
                ));
            END
        ");

        // === Asset Masters ===
        DB::unprepared("
            CREATE TRIGGER trg_asset_masters_autoid
            BEFORE INSERT ON asset_masters
            FOR EACH ROW
            BEGIN
                SET NEW.id_master = CONCAT('AMT-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_master, 5) AS UNSIGNED)), 0) + 1 FROM asset_masters),
                    6, '0'
                ));
            END
        ");

        // === Assets ===
        DB::unprepared("
            CREATE TRIGGER trg_assets_autoid
            BEFORE INSERT ON assets
            FOR EACH ROW
            BEGIN
                SET NEW.id_asset = CONCAT('AST-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_asset, 5) AS UNSIGNED)), 0) + 1 FROM assets),
                    6, '0'
                ));
            END
        ");

        // === Bookings ===
        DB::unprepared("
            CREATE TRIGGER trg_bookings_autoid
            BEFORE INSERT ON bookings
            FOR EACH ROW
            BEGIN
                SET NEW.id_booking = CONCAT('PMT-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_booking, 5) AS UNSIGNED)), 0) + 1 FROM bookings),
                    6, '0'
                ));
            END
        ");

        /* ============================================================
           AUTO RANDOM 10-DIGIT ID (ADMINS, USERS, NOTIFICATIONS)
        ============================================================ */
        // --- Admins ---
        DB::unprepared("
            CREATE TRIGGER trg_admins_autoid
            BEFORE INSERT ON admins
            FOR EACH ROW
            BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM admins WHERE id_admin = new_id;
                END WHILE;

                SET NEW.id_admin = new_id;
            END
        ");

        // --- Users ---
        DB::unprepared("
            CREATE TRIGGER trg_users_autoid
            BEFORE INSERT ON users
            FOR EACH ROW
            BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM users WHERE id_user = new_id;
                END WHILE;

                SET NEW.id_user = new_id;
            END
        ");

        // User Notifications
        DB::unprepared("
            CREATE TRIGGER trg_user_notifications_autoid
            BEFORE INSERT ON user_notifications
            FOR EACH ROW
            BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM user_notifications WHERE id_notification = new_id;
                END WHILE;

                SET NEW.id_notification = new_id;
            END
        ");

        // Admin Notifications
        DB::unprepared("
            CREATE TRIGGER trg_admin_notifications_autoid
            BEFORE INSERT ON admin_notifications
            FOR EACH ROW
            BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM admin_notifications WHERE id_notification = new_id;
                END WHILE;

                SET NEW.id_notification = new_id;
            END
        ");

        /* ============================================================
           AUTO GENERATE ASSETS DARI STOCK_TOTAL
        ============================================================ */
        DB::unprepared("
            CREATE TRIGGER trg_asset_masters_generate_assets
            AFTER INSERT ON asset_masters
            FOR EACH ROW
            BEGIN
                DECLARE counter INT DEFAULT 1;
                WHILE counter <= NEW.stock_total DO
                    INSERT INTO assets (id_master, status, `condition`, updated_at)
                    VALUES (NEW.id_master, 'Available', 'Good', NOW());
                    SET counter = counter + 1;
                END WHILE;
            END
        ");

        /* ============================================================
        PERBAIKAN LOGIC STATUS ASET SAAT BOOKING DIBUAT & DIUBAH
        ============================================================ */
        // Saat booking dibuat
        DB::unprepared("
    CREATE TRIGGER trg_booking_assets_update_status
    AFTER INSERT ON booking_assets
    FOR EACH ROW
    BEGIN
        DECLARE booking_status VARCHAR(20);

        -- Ambil status booking terkait
        SELECT status INTO booking_status FROM bookings WHERE id_booking = NEW.id_booking;

        -- Jika booking masih aktif → aset dipinjam
        IF booking_status IN ('Pending', 'Approved') THEN
            UPDATE assets
            SET status = 'Borrowed', updated_at = NOW()
            WHERE id_asset = NEW.id_asset;

        -- Jika booking sudah selesai atau ditolak → aset tetap tersedia
        ELSEIF booking_status IN ('Completed', 'Rejected') THEN
            UPDATE assets
            SET status = 'Available', updated_at = NOW()
            WHERE id_asset = NEW.id_asset;
        END IF;
    END
");

        // Saat booking diupdate (Completed / Rejected)
        DB::unprepared("
    CREATE TRIGGER trg_booking_assets_return_status
    AFTER UPDATE ON bookings
    FOR EACH ROW
    BEGIN
        -- Kalau booking selesai (Completed) atau ditolak (Rejected)
        IF NEW.status IN ('Completed', 'Rejected') THEN
            UPDATE assets
            SET status = 'Available', updated_at = NOW()
            WHERE id_asset IN (
                SELECT id_asset FROM booking_assets WHERE id_booking = NEW.id_booking
            );
        END IF;
    END
");


        /* ============================================================
           AUTO RETURN & LATE RETURN FIELD
        ============================================================ */
        DB::unprepared("
            CREATE TRIGGER trg_booking_auto_return
            BEFORE UPDATE ON bookings
            FOR EACH ROW
            BEGIN
                IF NEW.status = 'Completed' AND NEW.return_at IS NULL THEN
                    SET NEW.return_at = NOW();
                    SET NEW.late_return = TIMESTAMPDIFF(HOUR, NEW.end_time, NEW.return_at);
                END IF;
            END
        ");

        /* ============================================================
           AUTO NOTIFIKASI USER & ADMIN (BOOKING & RETURN)
        ============================================================ */

        DB::unprepared("
            CREATE TRIGGER trg_booking_after_insert_notif
            AFTER INSERT ON bookings
            FOR EACH ROW
            BEGIN
                -- User notif: booking dibuat
                INSERT INTO user_notifications(id_user, message, is_read, created_at, updated_at)
                VALUES(NEW.id_user, CONCAT('Your booking request ', NEW.id_booking, ' has been created.'), FALSE, NOW(), NOW());

                -- Admin notif: booking baru masuk
                INSERT INTO admin_notifications(id_admin, message, is_read, created_at, updated_at)
                SELECT id_admin, CONCAT('New booking request received: ', NEW.id_booking), FALSE, NOW(), NOW()
                FROM admins LIMIT 1;
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_booking_after_update_notif
            AFTER UPDATE ON bookings
            FOR EACH ROW
            BEGIN
                -- Booking disetujui
                IF NEW.status = 'Approved' THEN
                    INSERT INTO user_notifications(id_user, message, is_read, created_at, updated_at)
                    VALUES(NEW.id_user, CONCAT('Your booking ', NEW.id_booking, ' has been approved.'), FALSE, NOW(), NOW());
                -- Booking ditolak
                ELSEIF NEW.status = 'Rejected' THEN
                    INSERT INTO user_notifications(id_user, message, is_read, created_at, updated_at)
                    VALUES(NEW.id_user, CONCAT('Your booking ', NEW.id_booking, ' has been rejected.'), FALSE, NOW(), NOW());
                -- User ajukan pengembalian
                ELSEIF NEW.status = 'Pending' AND NEW.return_at IS NOT NULL THEN
                    INSERT INTO user_notifications(id_user, message, is_read, created_at, updated_at)
                    VALUES(NEW.id_user, CONCAT('Your return request for booking ', NEW.id_booking, ' has been submitted.'), FALSE, NOW(), NOW());

                    INSERT INTO admin_notifications(id_admin, message, is_read, created_at, updated_at)
                    VALUES(OLD.id_admin, CONCAT('User ', NEW.id_user, ' has requested return for ', NEW.id_booking, '.'), FALSE, NOW(), NOW());
                -- Pengembalian disetujui
                ELSEIF NEW.status = 'Completed' THEN
                    INSERT INTO user_notifications(id_user, message, is_read, created_at, updated_at)
                    VALUES(NEW.id_user, CONCAT('Your return for booking ', NEW.id_booking, ' has been approved.'), FALSE, NOW(), NOW());

                    INSERT INTO admin_notifications(id_admin, message, is_read, created_at, updated_at)
                    VALUES(OLD.id_admin, CONCAT('User ', NEW.id_user, ' has returned all assets for booking ', NEW.id_booking, '.'), FALSE, NOW(), NOW());
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS trg_categories_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_types_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_asset_masters_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_assets_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_bookings_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_admins_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_users_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_user_notifications_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_admin_notifications_autoid");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_asset_masters_generate_assets");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_booking_assets_update_status");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_booking_assets_return_status");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_booking_auto_return");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_booking_after_insert_notif");
        DB::unprepared("DROP TRIGGER IF EXISTS trg_booking_after_update_notif");
    }
};
