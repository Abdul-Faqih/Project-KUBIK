<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        /* ============================================================
           AUTO ID PREFIX + PADDING
           ============================================================ */

        DB::unprepared("
    CREATE TRIGGER trg_admins_autoid
    BEFORE INSERT ON admins
    FOR EACH ROW
    BEGIN
        DECLARE new_id BIGINT;
        DECLARE is_exist INT DEFAULT 1;
        
        WHILE is_exist > 0 DO
            SET new_id = FLOOR(1000000000 + RAND() * 9000000000); -- 10-digit random
            SELECT COUNT(*) INTO is_exist FROM admins WHERE id_admin = new_id;
        END WHILE;

        SET NEW.id_admin = new_id;
    END
");

        DB::unprepared("
    CREATE TRIGGER trg_users_autoid
    BEFORE INSERT ON users
    FOR EACH ROW
    BEGIN
        DECLARE new_id BIGINT;
        DECLARE is_exist INT DEFAULT 1;
        
        WHILE is_exist > 0 DO
            SET new_id = FLOOR(1000000000 + RAND() * 9000000000); -- 10-digit random
            SELECT COUNT(*) INTO is_exist FROM users WHERE id_user = new_id;
        END WHILE;

        SET NEW.id_user = new_id;
    END
");

        DB::unprepared("
    CREATE TRIGGER trg_user_notif_autoid
    BEFORE INSERT ON user_notifications
    FOR EACH ROW
    BEGIN
        DECLARE new_id BIGINT;
        DECLARE is_exist INT DEFAULT 1;
        
        WHILE is_exist > 0 DO
            SET new_id = FLOOR(1000000000 + RAND() * 9000000000); -- 10-digit random
            SELECT COUNT(*) INTO is_exist FROM user_notifications WHERE id_notification = new_id;
        END WHILE;

        SET NEW.id_notification = new_id;
    END
");

        DB::unprepared("
    CREATE TRIGGER trg_admin_notif_autoid
    BEFORE INSERT ON admin_notifications
    FOR EACH ROW
    BEGIN
        DECLARE new_id BIGINT;
        DECLARE is_exist INT DEFAULT 1;
        
        WHILE is_exist > 0 DO
            SET new_id = FLOOR(1000000000 + RAND() * 9000000000); -- 10-digit random
            SELECT COUNT(*) INTO is_exist FROM admin_notifications WHERE id_notification = new_id;
        END WHILE;

        SET NEW.id_notification = new_id;
    END
");

        DB::unprepared("
            CREATE TRIGGER trg_categories_autoid
            BEFORE INSERT ON categories
            FOR EACH ROW
            BEGIN
                SET NEW.id_category = CONCAT('CAT-', LPAD((SELECT IFNULL(MAX(SUBSTRING(id_category,5)),0)+1 FROM categories),6,'0'));
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_types_autoid
            BEFORE INSERT ON types
            FOR EACH ROW
            BEGIN
                SET NEW.id_type = CONCAT('TYP-', LPAD((SELECT IFNULL(MAX(SUBSTRING(id_type,5)),0)+1 FROM types),6,'0'));
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_asset_masters_autoid
            BEFORE INSERT ON asset_masters
            FOR EACH ROW
            BEGIN
                SET NEW.id_master = CONCAT('AMT-', LPAD((SELECT IFNULL(MAX(SUBSTRING(id_master,5)),0)+1 FROM asset_masters),6,'0'));
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_assets_autoid
            BEFORE INSERT ON assets
            FOR EACH ROW
            BEGIN
                SET NEW.id_asset = CONCAT('AST-', LPAD((SELECT IFNULL(MAX(SUBSTRING(id_asset,5)),0)+1 FROM assets),6,'0'));
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_bookings_autoid
            BEFORE INSERT ON bookings
            FOR EACH ROW
            BEGIN
                SET NEW.id_booking = CONCAT('PMT-', LPAD((SELECT IFNULL(MAX(SUBSTRING(id_booking,5)),0)+1 FROM bookings),6,'0'));
            END
        ");

        /* ============================================================
           AUTO-GENERATE UNIT ASSET
           ============================================================ */
        DB::unprepared("
            CREATE TRIGGER trg_asset_master_after_insert
            AFTER INSERT ON asset_masters
            FOR EACH ROW
            BEGIN
                DECLARE i INT DEFAULT 1;
                WHILE i <= NEW.stock_total DO
                    INSERT INTO assets (id_master, status, `condition`, updated_at)
                    VALUES (NEW.id_master, 'Available', 'Good', NOW());
                    SET i = i + 1;
                END WHILE;
            END
        ");

        /* ============================================================
           AUTO UPDATE STOK & STATUS
           ============================================================ */
        DB::unprepared("
            CREATE TRIGGER trg_booking_assets_after_insert
            AFTER INSERT ON booking_assets
            FOR EACH ROW
            BEGIN
                UPDATE assets SET status='Borrowed' WHERE id_asset=NEW.id_asset;
                UPDATE asset_masters SET stock_available = stock_available - 1
                WHERE id_master=(SELECT id_master FROM assets WHERE id_asset=NEW.id_asset);
            END
        ");

        DB::unprepared("
            CREATE TRIGGER trg_bookings_after_update
            AFTER UPDATE ON bookings
            FOR EACH ROW
            BEGIN
                IF NEW.status='Completed' THEN
                    UPDATE assets AS a
                    JOIN booking_assets AS b ON a.id_asset=b.id_asset
                    SET a.status='Available'
                    WHERE b.id_booking=NEW.id_booking;
                    UPDATE asset_masters AS m
                    JOIN assets AS a ON m.id_master=a.id_master
                    JOIN booking_assets AS b ON a.id_asset=b.id_asset
                    SET m.stock_available = m.stock_available + 1
                    WHERE b.id_booking=NEW.id_booking;
                END IF;
            END
        ");

        /* ============================================================
           AUTO ISI return_at + HITUNG keterlambatan
           ============================================================ */
        DB::unprepared("
            CREATE TRIGGER trg_bookings_before_update
            BEFORE UPDATE ON bookings
            FOR EACH ROW
            BEGIN
                IF NEW.status='Pending' AND NEW.return_at IS NULL THEN
                    SET NEW.return_at = NOW();
                    SET NEW.late_return = GREATEST(TIMESTAMPDIFF(HOUR, NEW.end_time, NEW.return_at),0);
                END IF;
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("
            DROP TRIGGER IF EXISTS trg_categories_autoid;
            DROP TRIGGER IF EXISTS trg_types_autoid;
            DROP TRIGGER IF EXISTS trg_asset_masters_autoid;
            DROP TRIGGER IF EXISTS trg_assets_autoid;
            DROP TRIGGER IF EXISTS trg_bookings_autoid;
            DROP TRIGGER IF EXISTS trg_asset_master_after_insert;
            DROP TRIGGER IF EXISTS trg_booking_assets_after_insert;
            DROP TRIGGER IF EXISTS trg_bookings_after_update;
            DROP TRIGGER IF EXISTS trg_bookings_before_update;
            DROP TRIGGER IF EXISTS trg_booking_after_insert_notif;
            DROP TRIGGER IF EXISTS trg_booking_after_update_notif;
            DROP TRIGGER IF EXISTS trg_admins_autoid;
            DROP TRIGGER IF EXISTS trg_users_autoid;            
        ");
    }
};
