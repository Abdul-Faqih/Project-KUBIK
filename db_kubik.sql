-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Des 2025 pada 15.28
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kubik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` varchar(64) DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` varchar(64) DEFAULT NULL,
  `properties` longtext DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'asset', 'updated', 'App\\Models\\Asset', 'updated', 'AST-000001', NULL, NULL, '{\"attributes\":{\"condition\":\"Minor Damage\"},\"old\":{\"condition\":\"Good\"}}', NULL, '2025-12-19 00:18:30', '2025-12-19 00:18:30'),
(2, 'asset', 'updated', 'App\\Models\\Asset', 'updated', 'AST-000001', NULL, NULL, '{\"attributes\":{\"condition\":\"Good\"},\"old\":{\"condition\":\"Minor Damage\"}}', NULL, '2025-12-19 00:18:57', '2025-12-19 00:18:57'),
(3, 'master', 'updated', 'App\\Models\\AssetMaster', 'updated', 'AMT-000001', NULL, NULL, '{\"attributes\":{\"description\":\"Layout Table: Circle \\/ O\\r\\nTable: 15\\r\\nChair: 29\\r\\nSmart Television : 1\"},\"old\":{\"description\":\"Layout Table: Circle \\/ O\\nTable: 15\\nChair: 30\\nSmart Television : 1\"}}', NULL, '2025-12-19 00:52:28', '2025-12-19 00:52:28'),
(4, 'asset', 'updated', 'App\\Models\\Asset', 'updated', 'AST-000001', NULL, NULL, '{\"attributes\":{\"condition\":\"Minor Damage\"},\"old\":{\"condition\":\"Good\"}}', NULL, '2025-12-19 01:11:03', '2025-12-19 01:11:03'),
(5, 'asset', 'updated', 'App\\Models\\Asset', 'updated', 'AST-000001', NULL, NULL, '{\"attributes\":{\"condition\":\"Good\"},\"old\":{\"condition\":\"Minor Damage\"}}', NULL, '2025-12-19 01:11:24', '2025-12-19 01:11:24'),
(6, 'category', 'updated', 'App\\Models\\Category', 'updated', 'CAT-000008', NULL, NULL, '{\"attributes\":{\"name\":\"Seat\"},\"old\":{\"name\":\"Chair\"}}', NULL, '2025-12-19 01:18:11', '2025-12-19 01:18:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Super-Admin','Admin','','') NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id_admin`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1486027187, 'Heru', 'heru@pradita.ac.id', '$2y$12$L6yUiPnGOzTZWrl5aTnsT.zIfMIvBi72bHajpJgCK9U4fIzxYYLsO', 'Admin', '2025-11-08 06:30:22', '2025-11-08 06:30:22'),
(5616969161, 'Joko', 'joko@pradita.ac.id', '$2y$12$L6yUiPnGOzTZWrl5aTnsT.zIfMIvBi72bHajpJgCK9U4fIzxYYLsO', 'Super-Admin', '2025-12-15 11:52:35', '2025-12-15 11:52:35');

--
-- Trigger `admins`
--
DELIMITER $$
CREATE TRIGGER `trg_admins_autoid` BEFORE INSERT ON `admins` FOR EACH ROW BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM admins WHERE id_admin = new_id;
                END WHILE;

                SET NEW.id_admin = new_id;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id_notification` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin_notifications`
--

INSERT INTO `admin_notifications` (`id_notification`, `id_admin`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(2576120216, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000090</b>.', 0, '2025-12-17 20:44:40', '2025-12-17 20:44:40'),
(2589219705, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000088</b>.', 1, '2025-12-17 06:44:57', '2025-12-17 06:44:58'),
(3200365883, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 1, '2025-12-17 20:55:09', '2025-12-17 20:55:21'),
(3326902220, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000090</b>.', 1, '2025-12-17 21:00:47', '2025-12-17 21:00:50'),
(3931237028, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000088</b>.', 1, '2025-12-17 20:42:55', '2025-12-17 21:24:18'),
(3963683049, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000087</b>.', 1, '2025-12-17 06:42:42', '2025-12-17 21:24:01'),
(4241707056, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000090</b>.', 1, '2025-12-17 20:44:40', '2025-12-17 20:44:41'),
(4698408964, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000087</b>.', 1, '2025-12-17 06:42:42', '2025-12-17 06:44:29'),
(4736120538, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 1, '2025-12-17 22:10:00', '2025-12-17 22:10:04'),
(5023589718, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000090</b>.', 0, '2025-12-17 21:00:47', '2025-12-17 21:00:47'),
(5378216206, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 1, '2025-12-17 06:45:55', '2025-12-17 21:24:11'),
(5399098653, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000086</b>.', 1, '2025-12-17 06:33:34', '2025-12-17 06:44:19'),
(5703476872, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 1, '2025-12-17 20:43:45', '2025-12-17 20:43:46'),
(7288916323, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000088</b>.', 1, '2025-12-17 20:42:55', '2025-12-17 20:42:56'),
(7583146773, 5616969161, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 1, '2025-12-17 06:45:55', '2025-12-17 06:45:58'),
(7625223366, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 0, '2025-12-17 22:10:00', '2025-12-17 22:10:00'),
(8391714867, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000086</b>.', 1, '2025-12-17 06:33:34', '2025-12-17 21:23:57'),
(9106308935, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000088</b>.', 1, '2025-12-17 06:44:57', '2025-12-17 21:24:06'),
(9157702767, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 0, '2025-12-17 20:55:09', '2025-12-17 20:55:09'),
(9891238679, 1486027187, 'User <b>Siti Aisyah</b> has submitted a Permission with ID: <b class=\'text-[#F26E21]\'>PMT-000089</b>.', 1, '2025-12-17 20:43:45', '2025-12-17 21:24:23');

--
-- Trigger `admin_notifications`
--
DELIMITER $$
CREATE TRIGGER `trg_admin_notifications_autoid` BEFORE INSERT ON `admin_notifications` FOR EACH ROW BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM admin_notifications WHERE id_notification = new_id;
                END WHILE;

                SET NEW.id_notification = new_id;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `assets`
--

CREATE TABLE `assets` (
  `id_asset` varchar(10) NOT NULL,
  `id_master` varchar(10) NOT NULL,
  `status` enum('Available','Borrowed','Maintenance') NOT NULL DEFAULT 'Available',
  `condition` enum('Good','Minor Damage','Damaged','Lost') NOT NULL DEFAULT 'Good',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `assets`
--

INSERT INTO `assets` (`id_asset`, `id_master`, `status`, `condition`, `updated_at`) VALUES
('AST-000001', 'AMT-000001', 'Available', 'Good', '2025-12-04 05:26:28'),
('AST-000002', 'AMT-000002', 'Available', 'Good', '2025-12-04 05:29:57'),
('AST-000003', 'AMT-000003', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000004', 'AMT-000004', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000005', 'AMT-000005', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000006', 'AMT-000006', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000009', 'AMT-000009', 'Available', 'Good', '2025-11-26 07:28:36'),
('AST-000010', 'AMT-000010', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000011', 'AMT-000011', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000017', 'AMT-000017', 'Borrowed', 'Good', '2025-11-08 13:30:25'),
('AST-000018', 'AMT-000017', 'Available', 'Good', '2025-11-28 12:23:44'),
('AST-000019', 'AMT-000017', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000020', 'AMT-000017', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000021', 'AMT-000017', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000022', 'AMT-000017', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000023', 'AMT-000017', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000024', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000025', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000026', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000027', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000028', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000029', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000030', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000031', 'AMT-000018', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000032', 'AMT-000019', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000033', 'AMT-000019', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000034', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000035', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000036', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000037', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000038', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000039', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000040', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000041', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000042', 'AMT-000020', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000043', 'AMT-000021', 'Available', 'Good', '2025-11-28 12:23:44'),
('AST-000044', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000045', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000046', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000047', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000048', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000049', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000050', 'AMT-000021', 'Available', 'Good', '2025-11-08 13:30:24'),
('AST-000051', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000052', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000053', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000054', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000055', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000056', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000057', 'AMT-000022', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000058', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000059', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000060', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000061', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000062', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000063', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000064', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000065', 'AMT-000023', 'Available', 'Good', '2025-11-28 12:23:44'),
('AST-000066', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000067', 'AMT-000023', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000068', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000069', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000070', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000071', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000072', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000073', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000074', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000075', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000076', 'AMT-000024', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000077', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000078', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000079', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000080', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000081', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000082', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000083', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000084', 'AMT-000025', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000085', 'AMT-000026', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000086', 'AMT-000026', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000087', 'AMT-000026', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000088', 'AMT-000026', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000089', 'AMT-000026', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000090', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000091', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000092', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000093', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000094', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000095', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000096', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000097', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000098', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000099', 'AMT-000027', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000100', 'AMT-000028', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000101', 'AMT-000028', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000102', 'AMT-000028', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000103', 'AMT-000028', 'Available', 'Good', '2025-11-26 07:28:36'),
('AST-000104', 'AMT-000029', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000105', 'AMT-000029', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000106', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000107', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000108', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000109', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000110', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000111', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000112', 'AMT-000030', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000113', 'AMT-000031', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000114', 'AMT-000031', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000115', 'AMT-000031', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000116', 'AMT-000032', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000117', 'AMT-000032', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000118', 'AMT-000032', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000119', 'AMT-000032', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000137', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000138', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000139', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000140', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000141', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000142', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000143', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000144', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000145', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000146', 'AMT-000035', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000159', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000160', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000161', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000162', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000163', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000164', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000165', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000166', 'AMT-000038', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000251', 'AMT-000053', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000252', 'AMT-000053', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000253', 'AMT-000053', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000254', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000255', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000256', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000257', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000258', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000259', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000260', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000261', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000262', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000263', 'AMT-000054', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000264', 'AMT-000055', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000265', 'AMT-000055', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000266', 'AMT-000056', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000267', 'AMT-000056', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000268', 'AMT-000056', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000269', 'AMT-000056', 'Available', 'Good', '2025-11-08 13:30:25'),
('AST-000270', 'AMT-000056', 'Available', 'Good', '2025-12-11 03:37:13'),
('AST-000271', 'AMT-000019', 'Available', 'Good', '2025-12-11 07:36:09'),
('AST-000272', 'AMT-000019', 'Available', 'Good', '2025-12-11 07:36:09'),
('AST-000273', 'AMT-000019', 'Available', 'Good', '2025-12-11 07:36:09'),
('AST-000274', 'AMT-000017', 'Available', 'Good', '2025-12-16 07:29:26'),
('AST-000275', 'AMT-000017', 'Available', 'Good', '2025-12-16 07:29:26');

--
-- Trigger `assets`
--
DELIMITER $$
CREATE TRIGGER `trg_assets_autoid` BEFORE INSERT ON `assets` FOR EACH ROW BEGIN
                SET NEW.id_asset = CONCAT('AST-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_asset, 5) AS UNSIGNED)), 0) + 1 FROM assets),
                    6, '0'
                ));
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `asset_masters`
--

CREATE TABLE `asset_masters` (
  `id_master` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_asset` varchar(255) DEFAULT NULL,
  `id_category` varchar(10) NOT NULL,
  `id_type` varchar(10) NOT NULL,
  `stock_total` int(11) NOT NULL,
  `stock_available` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `asset_masters`
--

INSERT INTO `asset_masters` (`id_master`, `name`, `description`, `image_asset`, `id_category`, `id_type`, `stock_total`, `stock_available`, `created_at`, `updated_at`) VALUES
('AMT-000001', 'AG01', 'Layout Table: Circle / O\r\nTable: 15\r\nChair: 29\r\nSmart Television : 1', '1763639411-691f0073e5f95.jpg', 'CAT-000001', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-19 00:52:28'),
('AMT-000002', 'AG02', 'Layout Table: Circle / O\nTable: 15\nChair: 30\nSmart Television : 1', '1765438244-693a732459928.jpg', 'CAT-000001', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-11 00:30:44'),
('AMT-000003', 'AG03', 'Layout Table: Circle / O\nTable: 15\nChair: 30\nSmart Television : 1', '1765438237-693a731dc80a7.jpg', 'CAT-000001', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-11 00:30:37'),
('AMT-000004', 'AG04', 'Layout Table: Circle / O\nTable: 15\nChair: 30\nSmart Television : 1', '1765251629-69379a2d6a111.jpg', 'CAT-000001', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-08 20:40:29'),
('AMT-000005', 'AG05', 'Layout Table: Circle / O\nTable: 15\nChair: 30\nSmart Television : 1', '1765438204-693a72fc6d817.jpg', 'CAT-000001', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-11 00:30:04'),
('AMT-000006', 'AG06', 'Layout Table: Circle / O\nTable: 15\nChair: 30\nSmart Television : 1', '1765437990-693a72262f6b2.jpg', 'CAT-000001', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-11 00:26:30'),
('AMT-000009', 'AUDI 1', NULL, '1765251660-69379a4c9d0a8.jpg', 'CAT-000002', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-08 20:41:00'),
('AMT-000010', 'AUDI 2', NULL, '1765251666-69379a52912e2.jpg', 'CAT-000002', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-08 20:41:06'),
('AMT-000011', 'AUDI 3', NULL, '1765251672-69379a58d900a.jpg', 'CAT-000002', 'TYP-000001', 1, 1, '2025-11-08 06:30:24', '2025-12-08 20:41:12'),
('AMT-000017', 'Panasonic Cable Roll 10m', NULL, '1764397122-692a904228395.webp', 'CAT-000004', 'TYP-000002', 9, 7, '2025-11-08 06:30:24', '2025-12-16 00:29:26'),
('AMT-000018', 'Power Strip 4 Slots', NULL, '1764397178-692a907aa5e79.jpg', 'CAT-000004', 'TYP-000002', 8, 8, '2025-11-08 06:30:24', '2025-11-28 23:19:38'),
('AMT-000019', 'HDMI Cable 10m', NULL, '1764397215-692a909f9e25d.jpg', 'CAT-000004', 'TYP-000002', 5, 2, '2025-11-08 06:30:24', '2025-12-11 00:36:09'),
('AMT-000020', 'Universal Laptop Adapter', NULL, '1764397266-692a90d25a595.webp', 'CAT-000004', 'TYP-000002', 9, 9, '2025-11-08 06:30:24', '2025-11-28 23:21:06'),
('AMT-000021', 'Philips Projector Lamp', 'LED (Light Emitting Diode): Found in newer models, offering longer life (30,000+ hrs), lower power, and eco-friendliness, often with high color temp (6000K).\nPower (Wattage): Ranges from 20W (halogen) to 190W, 200W (UHP), or even higher for high-power LED automotive-style ones.\nLifespan: Varies greatly: 1,000-5,000 hrs for older UHP, up to 10,000+ hrs (eco mode) for UHP, or 30,000+ hrs for LED.\nBrightness (Lumens): Key metric, though often listed as part of projector specs, original Philips lamps aim for 100% lumen output.\nColor Temperature: Measured in Kelvin (K); e.g., 3350K (warm), 6000K (cool white).', '1764397327-692a910f59dea.jpg', 'CAT-000004', 'TYP-000002', 8, 8, '2025-11-08 06:30:24', '2025-11-28 23:22:07'),
('AMT-000022', 'Extension Cord 5m', NULL, '1764397387-692a914b5d866.jpg', 'CAT-000004', 'TYP-000002', 7, 7, '2025-11-08 06:30:25', '2025-11-28 23:23:07'),
('AMT-000023', 'DC Power Supply 12V', 'Input Voltage: Wide range, typically 100-240V AC (50/60Hz).\nOutput Voltage: Stable DC 12V (often with slight regulation, e.g., 11.4V-12.6V).\nOutput Current (Amps): Varies greatly (1A, 2A, 5A, 10A, 30A+) depending on power needs.\nOutput Power (Watts): Calculated as Volts x Amps (e.g., 12V * 10A = 120W).\nProtection: Overload, Short-Circuit (SCP), Over-Voltage (OVP), Thermal Protection.', '1764397453-692a918d806ed.jpg', 'CAT-000004', 'TYP-000002', 10, 10, '2025-11-08 06:30:25', '2025-11-28 23:24:13'),
('AMT-000024', 'Large Electrical Terminal', NULL, '1764397543-692a91e716263.png', 'CAT-000004', 'TYP-000002', 9, 9, '2025-11-08 06:30:25', '2025-11-28 23:25:43'),
('AMT-000025', 'Sanwa Digital Multimeter', 'Display: 3-3/4 digit, 4000 count LCD.\nFunctions: DC/AC Voltage, DC/AC Current, Resistance, Capacitance, Frequency, Duty Cycle, Continuity, Diode Test, Data Hold, Auto-Power Off, Relative Measurement.\nPower: 2x R6P (AA) Batteries.\nSafety: IEC61010-1 CAT.III 600V Max.', '1764429506-692b0ec287658.jpg', 'CAT-000004', 'TYP-000002', 8, 8, '2025-11-08 06:30:25', '2025-11-29 08:18:26'),
('AMT-000026', 'Vention VGA Cable 15 Pin', 'Connector Type: Standard 15-Pin VGA Male to Male (D-Sub/HD15).\nResolution Support: Up to 1920x1080P (Full HD).\nConnector Material: 24K Gold-plated pins for better conductivity.\nShielding: Double ring shielding, aluminum foil, metal braided, or anti-jamming materials for signal integrity.\nFeatures: Ferrite cores/magnetic rings to reduce interference.\nConductor: Varies by model (e.g., CCA+BC, Pure Copper).\nJacket: PVC (Environmental Material).\nAvailable Lengths: Common lengths include 1m, 2m, 3m, 5m, and longer.', '1764429546-692b0eea118bd.jpg', 'CAT-000004', 'TYP-000002', 5, 5, '2025-11-08 06:30:25', '2025-11-29 08:19:06'),
('AMT-000027', 'Polytron Active Speaker', 'Konektivitas: Bluetooth (seringkali dengan Polytron Audio Connect App), USB Player (MP3, MP4, MKV), SD Card/MMC, Aux, Line Input, 2 Mic Input (untuk karaoke).\nAudio: Super Bass Digital, 3-Band Digital Tone Control (Bass, Middle, Treble), Preset EQ (Jazz, Pop, Rock, dll.), 2.0 Channel.\nOutput Daya: Bervariasi, contohnya 2 x 30W RMS, 2 x 80W RMS, 2 x 100W RMS (total bisa 200W RMS atau lebih), tergantung model.\nSpeaker System: Umumnya 2-Way Single Woofer atau 3-Way Double Woofer (dengan XBR Woofer).', '1764429659-692b0f5b1809e.webp', 'CAT-000005', 'TYP-000002', 10, 10, '2025-11-08 06:30:25', '2025-11-29 08:20:59'),
('AMT-000028', 'Yamaha MG10 Sound Mixer', 'Channels: 10-Channel (4 Mono Mic/Line + 3 Stereo Line)\nEQ: 3-Band EQ (High, Mid, Low) on Mono Channels\nEffects (XU Model Only): SPX with 24 Programs\nUSB (XU Model Only): 2in/2out, 24-bit/192kHz (Works with iPad)\nPhantom Power: +48V\nOutputs: XLR Balanced Main Outs, TRS Outs', '1764429701-692b0f859d3e7.jpg', 'CAT-000005', 'TYP-000002', 4, 4, '2025-11-08 06:30:25', '2025-11-29 08:21:41'),
('AMT-000029', 'Shure Wireless Microphone', 'Technology: Analog (BLX) or Digital UHF (SLX-D, Axient).\nOperating Range: ~100m (300 ft).\nBattery: 2x AA (8+ hrs) or rechargeable Li-ion options (SB903).\nChannels: Many available per band (e.g., 32 per 44MHz).\nSetup: Auto-scan, IR sync for easy pairing.\nOutputs: XLR (mic level) & 1/4\" (line level).', '1764429858-692b10221c23d.jpg', 'CAT-000005', 'TYP-000002', 2, 2, '2025-11-08 06:30:25', '2025-11-29 08:24:18'),
('AMT-000030', 'Tripod Mic Stand', NULL, '1764429931-692b106b036b2.jpg', 'CAT-000005', 'TYP-000002', 7, 7, '2025-11-08 06:30:25', '2025-11-29 08:25:31'),
('AMT-000031', 'XLR Cable 10m', 'Model: BBFBL (Black) or BLA (Blue Hi-Fi).\nType: XLR Male to XLR Female (Extension Cable).\nLength: 10 meters (approx. 33 feet).\nConnectors: Nickel-plated (or brass/resin for Hi-Fi model).\nConductor: Tinned Copper or 4N Silver-plated Oxygen-Free Copper (Hi-Fi).\nShielding: Aluminum Foil + Metal Braid (Double Shielded).', '1764429962-692b108a9988f.jpg', 'CAT-000005', 'TYP-000002', 3, 3, '2025-11-08 06:30:25', '2025-11-29 08:26:02'),
('AMT-000032', 'Behringer FBQ3102 Equalizer', 'Outputs: Dedicated Mono Subwoofer Output with adjustable crossover frequency.\nMetering: 12-segment LED input/output level meters and input gain controls.\nConnectors: Servo-balanced XLR (gold-plated) and 1/4\" TRS inputs/outputs.\nPower: \"Planet Earth\" switching power supply (100-240V~).', '1765251918-69379b4eb88ea.jpg', 'CAT-000005', 'TYP-000002', 4, 4, '2025-11-08 06:30:25', '2025-12-08 20:45:18'),
('AMT-000035', 'Wireless Receiver', NULL, '1765251495-693799a7c25fc.jpg', 'CAT-000005', 'TYP-000002', 10, 10, '2025-11-08 06:30:25', '2025-12-08 20:38:15'),
('AMT-000038', 'BenQ MX550 Projector', 'Display: DLP System, XGA (1024x768) Resolution, 30-bit (1.07 Billion Colors)\nBrightness: 3600 ANSI Lumens\nContrast Ratio: 20,000:1 (FOFO)\nLight Source: 200W Lamp\nLamp Life: Up to 15,000 hrs (LampSave mode)\nAspect Ratio: Native 4:3 (5 selectable ratios)\nSpeaker: 2W', '1765251902-69379b3e6cccc.webp', 'CAT-000006', 'TYP-000002', 8, 8, '2025-11-08 06:30:25', '2025-12-08 20:45:02'),
('AMT-000053', 'Snowman Marker Black', NULL, '1765424256-693a3c80e7a6f.webp', 'CAT-000009', 'TYP-000002', 3, 3, '2025-11-08 06:30:25', '2025-12-10 20:37:36'),
('AMT-000054', 'Snowman Marker Green', NULL, '1765424247-693a3c77a3f27.jpg', 'CAT-000009', 'TYP-000002', 10, 10, '2025-11-08 06:30:25', '2025-12-10 20:37:27'),
('AMT-000055', 'Snowman Marker Red', NULL, '1765424239-693a3c6f38f9c.webp', 'CAT-000009', 'TYP-000002', 2, 2, '2025-11-08 06:30:25', '2025-12-10 20:37:19'),
('AMT-000056', 'White Board Eraser', NULL, '1765424233-693a3c69662ee.jpg', 'CAT-000009', 'TYP-000002', 5, 5, '2025-11-08 06:30:25', '2025-12-10 20:37:13');

--
-- Trigger `asset_masters`
--
DELIMITER $$
CREATE TRIGGER `trg_asset_masters_autoid` BEFORE INSERT ON `asset_masters` FOR EACH ROW BEGIN
                SET NEW.id_master = CONCAT('AMT-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_master, 5) AS UNSIGNED)), 0) + 1 FROM asset_masters),
                    6, '0'
                ));
            END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_asset_masters_generate_assets` AFTER INSERT ON `asset_masters` FOR EACH ROW BEGIN
                DECLARE counter INT DEFAULT 1;
                WHILE counter <= NEW.stock_total DO
                    INSERT INTO assets (id_master, status, `condition`, updated_at)
                    VALUES (NEW.id_master, 'Available', 'Good', NOW());
                    SET counter = counter + 1;
                END WHILE;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id_booking` varchar(10) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_admin` bigint(20) UNSIGNED DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `return_at` timestamp NULL DEFAULT NULL,
  `late_return` int(11) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `proof_return` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Completed','Canceled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id_booking`, `id_user`, `id_admin`, `start_time`, `end_time`, `return_at`, `late_return`, `attachment`, `proof_return`, `note`, `status`, `created_at`, `updated_at`) VALUES
('PMT-000001', 9526108735, 1486027187, '2025-05-07 00:00:00', '2025-05-12 00:00:00', '2025-05-12 07:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-05-06 17:00:00', '2025-05-11 17:00:00'),
('PMT-000002', 1909308461, 1486027187, '2025-05-09 00:00:00', '2025-05-13 00:00:00', '2025-05-13 19:00:00', 5, NULL, NULL, NULL, 'Completed', '2025-05-08 17:00:00', '2025-05-12 17:00:00'),
('PMT-000003', 8676948208, 1486027187, '2025-05-26 00:00:00', '2025-05-28 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-25 17:00:00', '2025-05-27 17:00:00'),
('PMT-000004', 3965979187, 1486027187, '2025-05-26 00:00:00', '2025-05-30 00:00:00', '2025-05-31 00:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-05-25 17:00:00', '2025-05-29 17:00:00'),
('PMT-000005', 8673477949, 1486027187, '2025-05-20 00:00:00', '2025-05-24 00:00:00', '2025-05-24 23:00:00', 1, NULL, NULL, NULL, 'Completed', '2025-05-19 17:00:00', '2025-05-23 17:00:00'),
('PMT-000006', 3934766924, 1486027187, '2025-05-06 00:00:00', '2025-05-07 00:00:00', '2025-05-08 02:00:00', 1, NULL, NULL, NULL, 'Completed', '2025-05-05 17:00:00', '2025-05-06 17:00:00'),
('PMT-000007', 9526108735, 1486027187, '2025-05-20 00:00:00', '2025-05-25 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-19 17:00:00', '2025-05-24 17:00:00'),
('PMT-000008', 8673477949, 1486027187, '2025-05-13 00:00:00', '2025-05-18 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-12 17:00:00', '2025-05-17 17:00:00'),
('PMT-000009', 3934766924, 1486027187, '2025-05-21 00:00:00', '2025-05-23 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-20 17:00:00', '2025-05-22 17:00:00'),
('PMT-000010', 1909308461, 1486027187, '2025-05-07 00:00:00', '2025-05-09 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-06 17:00:00', '2025-05-08 17:00:00'),
('PMT-000011', 3934766924, 1486027187, '2025-05-02 00:00:00', '2025-05-03 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-01 17:00:00', '2025-05-02 17:00:00'),
('PMT-000012', 8676948208, 1486027187, '2025-05-22 00:00:00', '2025-05-26 00:00:00', '2025-05-27 02:00:00', 4, NULL, NULL, NULL, 'Completed', '2025-05-21 17:00:00', '2025-05-25 17:00:00'),
('PMT-000013', 4902618571, 1486027187, '2025-05-18 00:00:00', '2025-05-23 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-05-17 17:00:00', '2025-05-22 17:00:00'),
('PMT-000014', 8073413536, 1486027187, '2025-06-24 00:00:00', '2025-06-28 00:00:00', '2025-06-29 04:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-06-23 17:00:00', '2025-06-27 17:00:00'),
('PMT-000015', 8676948208, 1486027187, '2025-06-12 00:00:00', '2025-06-14 00:00:00', '2025-06-14 17:00:00', 5, NULL, NULL, NULL, 'Completed', '2025-06-11 17:00:00', '2025-06-13 17:00:00'),
('PMT-000016', 7025595440, 1486027187, '2025-06-19 00:00:00', '2025-06-20 00:00:00', '2025-06-21 11:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-06-18 17:00:00', '2025-06-19 17:00:00'),
('PMT-000017', 8673477949, 1486027187, '2025-06-22 00:00:00', '2025-06-24 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-06-21 17:00:00', '2025-06-23 17:00:00'),
('PMT-000018', 8673477949, 1486027187, '2025-06-18 00:00:00', '2025-06-21 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-06-17 17:00:00', '2025-06-20 17:00:00'),
('PMT-000019', 8676948208, 1486027187, '2025-06-14 00:00:00', '2025-06-18 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-06-13 17:00:00', '2025-06-17 17:00:00'),
('PMT-000020', 4230039916, 1486027187, '2025-06-15 00:00:00', '2025-06-20 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-06-14 17:00:00', '2025-06-19 17:00:00'),
('PMT-000021', 4230039916, 1486027187, '2025-06-06 00:00:00', '2025-06-08 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-06-05 17:00:00', '2025-06-07 17:00:00'),
('PMT-000022', 8073413536, 1486027187, '2025-06-05 00:00:00', '2025-06-08 00:00:00', '2025-06-09 03:00:00', 5, NULL, NULL, NULL, 'Completed', '2025-06-04 17:00:00', '2025-06-07 17:00:00'),
('PMT-000023', 1909308461, 1486027187, '2025-06-15 00:00:00', '2025-06-18 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-06-14 17:00:00', '2025-06-17 17:00:00'),
('PMT-000024', 4230039916, 1486027187, '2025-06-03 00:00:00', '2025-06-06 00:00:00', '2025-06-06 09:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-06-02 17:00:00', '2025-06-05 17:00:00'),
('PMT-000025', 9526108735, 1486027187, '2025-07-04 00:00:00', '2025-07-07 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-07-03 17:00:00', '2025-07-06 17:00:00'),
('PMT-000026', 8676948208, 1486027187, '2025-07-14 00:00:00', '2025-07-17 00:00:00', '2025-07-17 19:00:00', 4, NULL, NULL, NULL, 'Completed', '2025-07-13 17:00:00', '2025-07-16 17:00:00'),
('PMT-000027', 3965979187, 1486027187, '2025-07-20 00:00:00', '2025-07-21 00:00:00', '2025-07-21 15:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-07-19 17:00:00', '2025-07-20 17:00:00'),
('PMT-000028', 3965979187, 1486027187, '2025-07-02 00:00:00', '2025-07-07 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-07-01 17:00:00', '2025-07-06 17:00:00'),
('PMT-000029', 8073413536, 1486027187, '2025-07-10 00:00:00', '2025-07-15 00:00:00', '2025-07-15 20:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-07-09 17:00:00', '2025-07-14 17:00:00'),
('PMT-000030', 8073413536, 1486027187, '2025-07-02 00:00:00', '2025-07-07 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-07-01 17:00:00', '2025-07-06 17:00:00'),
('PMT-000031', 1909308461, 1486027187, '2025-07-13 00:00:00', '2025-07-15 00:00:00', '2025-07-16 17:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-07-12 17:00:00', '2025-07-14 17:00:00'),
('PMT-000032', 1909308461, 1486027187, '2025-07-17 00:00:00', '2025-07-19 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-07-16 17:00:00', '2025-07-18 17:00:00'),
('PMT-000033', 1909308461, 1486027187, '2025-07-14 00:00:00', '2025-07-16 00:00:00', '2025-07-16 04:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-07-13 17:00:00', '2025-07-15 17:00:00'),
('PMT-000034', 3934766924, 1486027187, '2025-07-26 00:00:00', '2025-07-27 00:00:00', '2025-07-26 22:00:00', 1, NULL, NULL, NULL, 'Completed', '2025-07-25 17:00:00', '2025-07-26 17:00:00'),
('PMT-000035', 8676948208, 1486027187, '2025-07-19 00:00:00', '2025-07-22 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-07-18 17:00:00', '2025-07-21 17:00:00'),
('PMT-000036', 3965979187, 1486027187, '2025-07-14 00:00:00', '2025-07-16 00:00:00', '2025-07-17 12:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-07-13 17:00:00', '2025-07-15 17:00:00'),
('PMT-000037', 8676948208, 1486027187, '2025-07-04 00:00:00', '2025-07-07 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-07-03 17:00:00', '2025-07-06 17:00:00'),
('PMT-000038', 3965979187, 1486027187, '2025-08-22 00:00:00', '2025-08-27 00:00:00', '2025-08-27 07:00:00', 0, NULL, NULL, NULL, 'Completed', '2025-08-21 17:00:00', '2025-08-26 17:00:00'),
('PMT-000039', 4902618571, 1486027187, '2025-08-20 00:00:00', '2025-08-21 00:00:00', '2025-08-22 11:00:00', 5, NULL, NULL, NULL, 'Completed', '2025-08-19 17:00:00', '2025-08-20 17:00:00'),
('PMT-000040', 8073413536, 1486027187, '2025-08-02 00:00:00', '2025-08-03 00:00:00', '2025-08-03 16:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-08-01 17:00:00', '2025-08-02 17:00:00'),
('PMT-000041', 3965979187, 1486027187, '2025-08-09 00:00:00', '2025-08-11 00:00:00', '2025-08-12 04:00:00', 4, NULL, NULL, NULL, 'Completed', '2025-08-08 17:00:00', '2025-08-10 17:00:00'),
('PMT-000042', 4902618571, 1486027187, '2025-08-18 00:00:00', '2025-08-21 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-08-17 17:00:00', '2025-08-20 17:00:00'),
('PMT-000043', 4902618571, 1486027187, '2025-08-18 00:00:00', '2025-08-20 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-08-17 17:00:00', '2025-08-19 17:00:00'),
('PMT-000044', 8676948208, 1486027187, '2025-08-13 00:00:00', '2025-08-14 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-08-12 17:00:00', '2025-08-13 17:00:00'),
('PMT-000045', 8073413536, 1486027187, '2025-08-25 00:00:00', '2025-08-29 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-08-24 17:00:00', '2025-08-28 17:00:00'),
('PMT-000046', 4902618571, 1486027187, '2025-08-21 00:00:00', '2025-08-25 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-08-20 17:00:00', '2025-08-24 17:00:00'),
('PMT-000047', 4902618571, 1486027187, '2025-08-19 00:00:00', '2025-08-23 00:00:00', '2025-08-24 11:00:00', 5, NULL, NULL, NULL, 'Completed', '2025-08-18 17:00:00', '2025-08-22 17:00:00'),
('PMT-000048', 8073413536, 1486027187, '2025-08-19 00:00:00', '2025-08-20 00:00:00', '2025-08-20 22:00:00', 4, NULL, NULL, NULL, 'Completed', '2025-08-18 17:00:00', '2025-08-19 17:00:00'),
('PMT-000049', 1909308461, 1486027187, '2025-09-10 00:00:00', '2025-09-13 00:00:00', '2025-09-13 10:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-09-09 17:00:00', '2025-09-12 17:00:00'),
('PMT-000050', 3965979187, 1486027187, '2025-09-16 00:00:00', '2025-09-21 00:00:00', '2025-09-21 22:00:00', 1, NULL, NULL, NULL, 'Completed', '2025-09-15 17:00:00', '2025-09-20 17:00:00'),
('PMT-000051', 3934766924, 1486027187, '2025-09-20 00:00:00', '2025-09-23 00:00:00', '2025-09-24 06:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-09-19 17:00:00', '2025-09-22 17:00:00'),
('PMT-000052', 3965979187, 1486027187, '2025-09-20 00:00:00', '2025-09-25 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-09-19 17:00:00', '2025-09-24 17:00:00'),
('PMT-000053', 7025595440, 1486027187, '2025-09-22 00:00:00', '2025-09-26 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-09-21 17:00:00', '2025-09-25 17:00:00'),
('PMT-000054', 4902618571, 1486027187, '2025-09-20 00:00:00', '2025-09-25 00:00:00', '2025-09-25 12:00:00', 5, NULL, NULL, NULL, 'Completed', '2025-09-19 17:00:00', '2025-09-24 17:00:00'),
('PMT-000055', 9526108735, 1486027187, '2025-09-21 00:00:00', '2025-11-25 00:00:00', '2025-12-04 08:31:02', 231, NULL, NULL, 'Rejected by ADMIN.', 'Completed', '2025-09-20 17:00:00', '2025-12-04 01:31:02'),
('PMT-000056', 8676948208, 1486027187, '2025-09-20 00:00:00', '2025-09-21 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-09-19 17:00:00', '2025-09-20 17:00:00'),
('PMT-000057', 8673477949, 1486027187, '2025-09-13 00:00:00', '2025-09-15 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-09-12 17:00:00', '2025-09-14 17:00:00'),
('PMT-000058', 8676948208, 1486027187, '2025-09-22 00:00:00', '2025-09-27 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-09-21 17:00:00', '2025-09-26 17:00:00'),
('PMT-000059', 3965979187, 1486027187, '2025-10-20 00:00:00', '2025-10-21 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-10-19 17:00:00', '2025-10-20 17:00:00'),
('PMT-000060', 8073413536, 1486027187, '2025-10-11 00:00:00', '2025-10-13 00:00:00', '2025-10-14 05:00:00', 2, NULL, NULL, NULL, 'Completed', '2025-10-10 17:00:00', '2025-10-12 17:00:00'),
('PMT-000061', 4902618571, 1486027187, '2025-10-10 00:00:00', '2025-11-26 00:00:00', NULL, NULL, NULL, NULL, 'null', 'Rejected', '2025-10-09 17:00:00', '2025-11-26 00:28:36'),
('PMT-000062', 3934766924, 1486027187, '2025-10-05 00:00:00', '2025-10-10 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-10-04 17:00:00', '2025-10-09 17:00:00'),
('PMT-000063', 3965979187, 1486027187, '2025-10-07 00:00:00', '2025-10-11 00:00:00', '2025-10-11 05:00:00', 3, NULL, NULL, NULL, 'Completed', '2025-10-06 17:00:00', '2025-10-10 17:00:00'),
('PMT-000064', 3965979187, 1486027187, '2025-10-06 00:00:00', '2025-10-11 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-10-05 17:00:00', '2025-10-10 17:00:00'),
('PMT-000065', 7025595440, 1486027187, '2025-10-26 00:00:00', '2025-10-29 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-10-25 17:00:00', '2025-10-28 17:00:00'),
('PMT-000066', 7025595440, 1486027187, '2025-10-14 00:00:00', '2025-10-19 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-10-13 17:00:00', '2025-10-18 17:00:00'),
('PMT-000067', 7025595440, 1486027187, '2025-10-03 00:00:00', '2025-10-07 00:00:00', '2025-10-06 20:00:00', 1, NULL, NULL, NULL, 'Completed', '2025-10-02 17:00:00', '2025-10-06 17:00:00'),
('PMT-000068', 8073413536, 1486027187, '2025-10-16 00:00:00', '2025-10-20 00:00:00', NULL, NULL, NULL, NULL, 'Rejected by ADMIN.', 'Rejected', '2025-10-15 17:00:00', '2025-10-19 17:00:00'),
('PMT-000069', 4230039916, 5616969161, '2025-11-25 04:54:15', '2025-11-26 00:00:00', NULL, NULL, NULL, NULL, NULL, 'Rejected', '2025-11-25 04:43:26', '2025-12-16 21:04:20'),
('PMT-000070', 1909308461, 1486027187, '2025-12-04 19:57:00', '2025-12-05 20:00:00', '2025-12-04 13:34:32', -23, 'PMT-000070_1764853004.pdf', '1764855272_PMT-000070_1764832442.png', NULL, 'Completed', '2025-12-04 05:56:44', '2025-12-04 06:34:32'),
('PMT-000071', 1909308461, 1486027187, '2025-12-08 17:59:00', '2025-12-08 18:10:00', '2025-12-08 13:26:21', 2, 'PMT-000071_1765191610.pdf', '1765200381_pngtree-beautiful-abstract-grunge-decorative-navy-blue-dark-stucco-wall-background-art-image_536840.jpg', NULL, 'Completed', '2025-12-08 04:00:10', '2025-12-08 06:26:21'),
('PMT-000072', 3493250116, 1486027187, '2025-12-08 20:10:00', '2025-12-15 20:15:00', '2025-12-09 10:43:05', -146, 'PMT-000072_1765199329.png', NULL, NULL, 'Completed', '2025-12-08 06:08:49', '2025-12-09 03:43:05'),
('PMT-000073', 9630599736, 1486027187, '2025-12-09 11:11:00', '2025-12-09 11:20:00', '2025-12-09 04:16:14', 0, 'PMT-000073_1765253533.pdf', '1765253774_ca.jpeg', NULL, 'Completed', '2025-12-08 21:12:13', '2025-12-08 21:16:14'),
('PMT-000074', 1909308461, 1486027187, '2025-12-12 10:40:00', '2025-12-12 22:40:00', '2025-12-11 11:02:57', -28, 'PMT-000074_1765424416.pdf', '1765450977_projector sony-e.jpeg', NULL, 'Completed', '2025-12-10 20:40:16', '2025-12-11 04:02:57'),
('PMT-000075', 1909308461, NULL, '2025-12-11 18:01:00', '2025-12-12 18:01:00', NULL, NULL, 'PMT-000075_1765450948.jpg', NULL, NULL, 'Canceled', '2025-12-11 04:02:28', '2025-12-11 04:02:41'),
('PMT-000076', 1909308461, 1486027187, '2025-12-11 19:15:00', '2025-12-11 19:16:00', '2025-12-17 04:01:57', 135, 'PMT-000076_1765455347.jpg', '[\"1765944117_69422b35be6e7_WhatsApp Image 2025-12-17 at 10.42.43_e129dafc.jpg\"]', NULL, 'Completed', '2025-12-11 05:15:47', '2025-12-16 21:01:57'),
('PMT-000077', 7411562267, 5616969161, '2025-12-13 09:40:00', '2025-12-14 09:40:00', '2025-12-12 02:41:55', -47, 'PMT-000077_1765507133.pdf', '1765507315_whiteboard.jpg', NULL, 'Completed', '2025-12-11 19:38:53', '2025-12-11 19:41:55'),
('PMT-000078', 7411562267, NULL, '2025-12-12 09:40:00', '2025-12-13 10:41:00', NULL, NULL, 'PMT-000078_1765507285.pdf', NULL, NULL, 'Canceled', '2025-12-11 19:41:25', '2025-12-11 19:41:34'),
('PMT-000079', 7411562267, 5616969161, '2025-12-12 09:44:00', '2025-12-12 09:45:00', '2025-12-17 04:02:41', 121, 'PMT-000079_1765507400.pdf', '[\"1765944161_69422b6125b70_WhatsApp Image 2025-12-17 at 10.42.43_e129dafc.jpg\"]', NULL, 'Completed', '2025-12-11 19:43:20', '2025-12-16 21:02:41'),
('PMT-000080', 7097921567, 5616969161, '2025-12-12 10:00:00', '2025-12-13 10:00:00', '2025-12-12 02:59:57', -24, 'PMT-000080_1765508322.pdf', '1765508397_WhatsApp Image 2025-12-11 at 14.23.08_0ef29495.jpg', NULL, 'Completed', '2025-12-11 19:58:42', '2025-12-11 19:59:57'),
('PMT-000081', 9630599736, 5616969161, '2025-12-16 14:39:00', '2025-12-17 14:39:00', '2025-12-16 07:43:57', -23, 'PMT-000081_1765870807.pdf', '1765871037_WhatsApp Image 2025-03-05 at 19.28.57.jpeg', NULL, 'Completed', '2025-12-16 00:40:07', '2025-12-16 00:43:57'),
('PMT-000082', 1909308461, 5616969161, '2025-12-16 19:48:00', '2025-12-17 19:49:00', NULL, NULL, 'PMT-000082_1765889361.pdf', NULL, NULL, 'Rejected', '2025-12-16 05:49:21', '2025-12-16 05:51:48'),
('PMT-000083', 1909308461, 5616969161, '2025-12-17 07:52:00', '2025-12-17 19:53:00', '2025-12-16 14:19:10', -22, 'PMT-000083_1765889595.pdf', '[\"1765894750_69416a5e04406_whiteboard.jpg\",\"1765894750_69416a5e052b5_Wireless Receiver.jpg\"]', NULL, 'Completed', '2025-12-16 05:53:15', '2025-12-16 07:19:10'),
('PMT-000084', 7411562267, 5616969161, '2025-12-17 11:53:00', '2025-12-18 11:53:00', '2025-12-17 04:55:50', -23, 'PMT-000084_1765947213.pdf', '[\"1765947349_694237d5edbe3_foto4.jpeg\",\"1765947349_694237d5f1ac3_green.jpeg\"]', NULL, 'Completed', '2025-12-16 21:53:33', '2025-12-16 21:55:50'),
('PMT-000085', 1909308461, 5616969161, '2025-12-19 15:38:00', '2025-12-20 15:38:00', '2025-12-17 14:20:48', 0, 'PMT-000085_1765960749.pdf', '[\"1765981248_6942bc40bc79f_WhatsApp Image 2025-12-17 at 10.42.43_e129dafc.jpg\"]', NULL, 'Completed', '2025-12-17 01:39:08', '2025-12-17 07:20:48'),
('PMT-000086', 1909308461, NULL, '2025-12-17 20:32:00', '2025-12-17 20:35:00', NULL, NULL, 'PMT-000086_1765978414.pdf', NULL, NULL, 'Canceled', '2025-12-17 06:33:34', '2025-12-17 06:36:00'),
('PMT-000087', 1909308461, 5616969161, '2025-12-17 20:45:00', '2025-12-17 20:46:00', '2025-12-17 14:22:42', 37, 'PMT-000087_1765978962.pdf', '[\"1765981362_6942bcb203850_WhatsApp Image 2025-12-17 at 10.42.43_e129dafc.jpg\"]', NULL, 'Completed', '2025-12-17 06:42:42', '2025-12-17 07:22:42'),
('PMT-000088', 1909308461, 5616969161, '2025-12-19 10:00:00', '2025-12-19 22:00:00', NULL, NULL, 'PMT-000088_1766029375.pdf', NULL, NULL, 'Pending', '2025-12-17 20:42:55', '2025-12-18 09:15:45');

--
-- Trigger `bookings`
--
DELIMITER $$
CREATE TRIGGER `trg_booking_auto_return` BEFORE UPDATE ON `bookings` FOR EACH ROW BEGIN
    -- Cek jika status berubah jadi Completed dan return_at belum diisi
    IF NEW.status = 'Completed' AND NEW.return_at IS NULL THEN
        
        -- Set waktu pengembalian saat ini
        SET NEW.return_at = NOW();

        -- Hitung selisih detik, lalu bagi 3600 agar jadi jam desimal
        -- GREATEST(0, ...) memastikan tidak ada nilai minus jika kembali lebih cepat
        SET NEW.late_return = GREATEST(0, TIMESTAMPDIFF(SECOND, NEW.end_time, NEW.return_at) / 60);
        
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_bookings_autoid` BEFORE INSERT ON `bookings` FOR EACH ROW BEGIN
                SET NEW.id_booking = CONCAT('PMT-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_booking, 5) AS UNSIGNED)), 0) + 1 FROM bookings),
                    6, '0'
                ));
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking_assets`
--

CREATE TABLE `booking_assets` (
  `id_booking` varchar(10) NOT NULL,
  `id_asset` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `booking_assets`
--

INSERT INTO `booking_assets` (`id_booking`, `id_asset`) VALUES
('PMT-000001', 'AST-000022'),
('PMT-000001', 'AST-000069'),
('PMT-000001', 'AST-000047'),
('PMT-000001', 'AST-000009'),
('PMT-000002', 'AST-000072'),
('PMT-000002', 'AST-000099'),
('PMT-000003', 'AST-000081'),
('PMT-000003', 'AST-000071'),
('PMT-000003', 'AST-000080'),
('PMT-000004', 'AST-000111'),
('PMT-000005', 'AST-000145'),
('PMT-000005', 'AST-000159'),
('PMT-000005', 'AST-000019'),
('PMT-000005', 'AST-000113'),
('PMT-000006', 'AST-000104'),
('PMT-000006', 'AST-000026'),
('PMT-000007', 'AST-000077'),
('PMT-000009', 'AST-000048'),
('PMT-000009', 'AST-000252'),
('PMT-000009', 'AST-000065'),
('PMT-000010', 'AST-000262'),
('PMT-000010', 'AST-000069'),
('PMT-000010', 'AST-000021'),
('PMT-000010', 'AST-000261'),
('PMT-000010', 'AST-000111'),
('PMT-000010', 'AST-000048'),
('PMT-000010', 'AST-000002'),
('PMT-000011', 'AST-000042'),
('PMT-000011', 'AST-000045'),
('PMT-000011', 'AST-000020'),
('PMT-000011', 'AST-000077'),
('PMT-000011', 'AST-000024'),
('PMT-000012', 'AST-000046'),
('PMT-000012', 'AST-000252'),
('PMT-000013', 'AST-000065'),
('PMT-000013', 'AST-000268'),
('PMT-000013', 'AST-000075'),
('PMT-000014', 'AST-000048'),
('PMT-000014', 'AST-000163'),
('PMT-000014', 'AST-000075'),
('PMT-000014', 'AST-000112'),
('PMT-000016', 'AST-000114'),
('PMT-000016', 'AST-000098'),
('PMT-000016', 'AST-000021'),
('PMT-000017', 'AST-000166'),
('PMT-000017', 'AST-000093'),
('PMT-000018', 'AST-000163'),
('PMT-000018', 'AST-000160'),
('PMT-000018', 'AST-000039'),
('PMT-000019', 'AST-000010'),
('PMT-000019', 'AST-000093'),
('PMT-000019', 'AST-000162'),
('PMT-000020', 'AST-000100'),
('PMT-000020', 'AST-000032'),
('PMT-000021', 'AST-000091'),
('PMT-000021', 'AST-000161'),
('PMT-000022', 'AST-000119'),
('PMT-000022', 'AST-000108'),
('PMT-000023', 'AST-000068'),
('PMT-000023', 'AST-000018'),
('PMT-000023', 'AST-000078'),
('PMT-000023', 'AST-000082'),
('PMT-000024', 'AST-000104'),
('PMT-000024', 'AST-000074'),
('PMT-000024', 'AST-000018'),
('PMT-000024', 'AST-000112'),
('PMT-000025', 'AST-000040'),
('PMT-000025', 'AST-000042'),
('PMT-000025', 'AST-000018'),
('PMT-000025', 'AST-000066'),
('PMT-000025', 'AST-000108'),
('PMT-000026', 'AST-000091'),
('PMT-000026', 'AST-000066'),
('PMT-000026', 'AST-000160'),
('PMT-000027', 'AST-000019'),
('PMT-000027', 'AST-000079'),
('PMT-000027', 'AST-000139'),
('PMT-000027', 'AST-000100'),
('PMT-000027', 'AST-000166'),
('PMT-000028', 'AST-000251'),
('PMT-000028', 'AST-000022'),
('PMT-000028', 'AST-000266'),
('PMT-000028', 'AST-000088'),
('PMT-000028', 'AST-000053'),
('PMT-000029', 'AST-000075'),
('PMT-000029', 'AST-000047'),
('PMT-000029', 'AST-000051'),
('PMT-000029', 'AST-000264'),
('PMT-000030', 'AST-000146'),
('PMT-000030', 'AST-000111'),
('PMT-000031', 'AST-000165'),
('PMT-000031', 'AST-000139'),
('PMT-000031', 'AST-000090'),
('PMT-000031', 'AST-000252'),
('PMT-000031', 'AST-000036'),
('PMT-000031', 'AST-000254'),
('PMT-000031', 'AST-000096'),
('PMT-000032', 'AST-000162'),
('PMT-000032', 'AST-000058'),
('PMT-000032', 'AST-000112'),
('PMT-000032', 'AST-000035'),
('PMT-000032', 'AST-000078'),
('PMT-000033', 'AST-000091'),
('PMT-000033', 'AST-000085'),
('PMT-000033', 'AST-000078'),
('PMT-000036', 'AST-000017'),
('PMT-000036', 'AST-000252'),
('PMT-000036', 'AST-000086'),
('PMT-000036', 'AST-000037'),
('PMT-000036', 'AST-000096'),
('PMT-000037', 'AST-000075'),
('PMT-000037', 'AST-000144'),
('PMT-000037', 'AST-000060'),
('PMT-000038', 'AST-000097'),
('PMT-000038', 'AST-000021'),
('PMT-000038', 'AST-000006'),
('PMT-000038', 'AST-000059'),
('PMT-000039', 'AST-000017'),
('PMT-000039', 'AST-000025'),
('PMT-000039', 'AST-000039'),
('PMT-000039', 'AST-000020'),
('PMT-000039', 'AST-000142'),
('PMT-000040', 'AST-000065'),
('PMT-000040', 'AST-000075'),
('PMT-000040', 'AST-000095'),
('PMT-000040', 'AST-000103'),
('PMT-000041', 'AST-000259'),
('PMT-000041', 'AST-000097'),
('PMT-000041', 'AST-000017'),
('PMT-000042', 'AST-000108'),
('PMT-000042', 'AST-000005'),
('PMT-000043', 'AST-000034'),
('PMT-000043', 'AST-000065'),
('PMT-000044', 'AST-000111'),
('PMT-000044', 'AST-000261'),
('PMT-000044', 'AST-000105'),
('PMT-000045', 'AST-000265'),
('PMT-000045', 'AST-000161'),
('PMT-000045', 'AST-000144'),
('PMT-000045', 'AST-000113'),
('PMT-000045', 'AST-000256'),
('PMT-000045', 'AST-000143'),
('PMT-000047', 'AST-000046'),
('PMT-000047', 'AST-000058'),
('PMT-000047', 'AST-000069'),
('PMT-000048', 'AST-000161'),
('PMT-000048', 'AST-000144'),
('PMT-000049', 'AST-000038'),
('PMT-000049', 'AST-000022'),
('PMT-000049', 'AST-000089'),
('PMT-000049', 'AST-000028'),
('PMT-000050', 'AST-000004'),
('PMT-000050', 'AST-000085'),
('PMT-000050', 'AST-000117'),
('PMT-000051', 'AST-000253'),
('PMT-000051', 'AST-000058'),
('PMT-000051', 'AST-000052'),
('PMT-000052', 'AST-000143'),
('PMT-000052', 'AST-000034'),
('PMT-000052', 'AST-000086'),
('PMT-000052', 'AST-000055'),
('PMT-000052', 'AST-000268'),
('PMT-000053', 'AST-000145'),
('PMT-000053', 'AST-000269'),
('PMT-000053', 'AST-000024'),
('PMT-000053', 'AST-000009'),
('PMT-000053', 'AST-000263'),
('PMT-000053', 'AST-000078'),
('PMT-000053', 'AST-000081'),
('PMT-000054', 'AST-000113'),
('PMT-000054', 'AST-000105'),
('PMT-000054', 'AST-000042'),
('PMT-000054', 'AST-000075'),
('PMT-000054', 'AST-000028'),
('PMT-000054', 'AST-000087'),
('PMT-000056', 'AST-000070'),
('PMT-000056', 'AST-000269'),
('PMT-000057', 'AST-000043'),
('PMT-000057', 'AST-000065'),
('PMT-000057', 'AST-000018'),
('PMT-000059', 'AST-000263'),
('PMT-000059', 'AST-000103'),
('PMT-000060', 'AST-000070'),
('PMT-000060', 'AST-000033'),
('PMT-000060', 'AST-000093'),
('PMT-000061', 'AST-000103'),
('PMT-000061', 'AST-000009'),
('PMT-000062', 'AST-000259'),
('PMT-000062', 'AST-000009'),
('PMT-000062', 'AST-000031'),
('PMT-000063', 'AST-000028'),
('PMT-000063', 'AST-000109'),
('PMT-000063', 'AST-000265'),
('PMT-000064', 'AST-000001'),
('PMT-000064', 'AST-000095'),
('PMT-000064', 'AST-000006'),
('PMT-000065', 'AST-000053'),
('PMT-000065', 'AST-000163'),
('PMT-000065', 'AST-000085'),
('PMT-000066', 'AST-000117'),
('PMT-000067', 'AST-000094'),
('PMT-000067', 'AST-000024'),
('PMT-000068', 'AST-000057'),
('PMT-000070', 'AST-000019'),
('PMT-000070', 'AST-000018'),
('PMT-000070', 'AST-000017'),
('PMT-000070', 'AST-000023'),
('PMT-000070', 'AST-000022'),
('PMT-000070', 'AST-000021'),
('PMT-000070', 'AST-000020'),
('PMT-000071', 'AST-000025'),
('PMT-000071', 'AST-000024'),
('PMT-000072', 'AST-000019'),
('PMT-000072', 'AST-000018'),
('PMT-000072', 'AST-000017'),
('PMT-000072', 'AST-000023'),
('PMT-000072', 'AST-000022'),
('PMT-000072', 'AST-000021'),
('PMT-000072', 'AST-000020'),
('PMT-000073', 'AST-000160'),
('PMT-000073', 'AST-000159'),
('PMT-000073', 'AST-000059'),
('PMT-000073', 'AST-000058'),
('PMT-000074', 'AST-000252'),
('PMT-000074', 'AST-000251'),
('PMT-000075', 'AST-000024'),
('PMT-000076', 'AST-000006'),
('PMT-000076', 'AST-000159'),
('PMT-000077', 'AST-000258'),
('PMT-000077', 'AST-000257'),
('PMT-000077', 'AST-000256'),
('PMT-000077', 'AST-000255'),
('PMT-000077', 'AST-000254'),
('PMT-000078', 'AST-000001'),
('PMT-000078', 'AST-000100'),
('PMT-000079', 'AST-000265'),
('PMT-000079', 'AST-000264'),
('PMT-000080', 'AST-000116'),
('PMT-000081', 'AST-000003'),
('PMT-000081', 'AST-000117'),
('PMT-000081', 'AST-000116'),
('PMT-000081', 'AST-000119'),
('PMT-000081', 'AST-000118'),
('PMT-000082', 'AST-000002'),
('PMT-000083', 'AST-000003'),
('PMT-000083', 'AST-000118'),
('PMT-000083', 'AST-000117'),
('PMT-000083', 'AST-000116'),
('PMT-000084', 'AST-000058'),
('PMT-000085', 'AST-000001'),
('PMT-000086', 'AST-000058'),
('PMT-000087', 'AST-000024'),
('PMT-000088', 'AST-000001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_asset` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `carts`
--

INSERT INTO `carts` (`id`, `id_user`, `id_asset`, `created_at`, `updated_at`) VALUES
(85, 7025595440, 'AST-000024', '2025-12-04 01:48:46', '2025-12-04 01:48:46'),
(176, 3493250116, 'AST-000024', '2025-12-08 20:10:06', '2025-12-08 20:10:06'),
(177, 3493250116, 'AST-000025', '2025-12-08 20:10:07', '2025-12-08 20:10:07'),
(178, 3493250116, 'AST-000026', '2025-12-08 20:10:08', '2025-12-08 20:10:08'),
(179, 3493250116, 'AST-000027', '2025-12-08 20:10:09', '2025-12-08 20:10:09'),
(181, 3493250116, 'AST-000001', '2025-12-08 20:21:58', '2025-12-08 20:21:58'),
(281, 9630599736, 'AST-000017', '2025-12-16 08:09:30', '2025-12-16 08:09:30'),
(283, 7411562267, 'AST-000032', '2025-12-16 21:57:42', '2025-12-16 21:57:42'),
(284, 7411562267, 'AST-000033', '2025-12-16 21:57:46', '2025-12-16 21:57:46'),
(285, 7411562267, 'AST-000271', '2025-12-16 21:57:47', '2025-12-16 21:57:47'),
(286, 7411562267, 'AST-000272', '2025-12-16 21:57:48', '2025-12-16 21:57:48'),
(287, 7411562267, 'AST-000273', '2025-12-16 21:57:49', '2025-12-16 21:57:49'),
(309, 1909308461, 'AST-000024', '2025-12-18 09:47:11', '2025-12-18 09:47:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id_category` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id_category`, `name`, `updated_at`) VALUES
('CAT-000001', 'Classroom', '2025-11-08 06:30:24'),
('CAT-000002', 'Auditorium', '2025-11-08 06:30:24'),
('CAT-000003', 'Meeting Room', '2025-11-08 06:30:24'),
('CAT-000004', 'Electrical', '2025-11-08 06:30:24'),
('CAT-000005', 'Sound System', '2025-11-08 06:30:24'),
('CAT-000006', 'Projector', '2025-11-08 06:30:24'),
('CAT-000007', 'Table', '2025-11-08 06:30:24'),
('CAT-000008', 'Seat', '2025-11-08 06:30:24'),
('CAT-000009', 'Stationery', '2025-11-08 06:30:24');

--
-- Trigger `categories`
--
DELIMITER $$
CREATE TRIGGER `trg_categories_autoid` BEFORE INSERT ON `categories` FOR EACH ROW BEGIN
                SET NEW.id_category = CONCAT('CAT-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_category, 5) AS UNSIGNED)), 0) + 1 FROM categories),
                    6, '0'
                ));
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_11_03_073300_create_admins_table', 1),
(2, '2025_11_03_073300_create_categories_table', 1),
(3, '2025_11_03_073300_create_types_table', 1),
(4, '2025_11_03_073300_create_users_table', 1),
(5, '2025_11_03_073301_create_asset_masters_table', 1),
(6, '2025_11_03_073301_create_bookings_table', 1),
(7, '2025_11_03_073302_create_assets_table', 1),
(8, '2025_11_03_073303_create_booking_assets_table', 1),
(9, '2025_11_03_073304_create_admin_notifications_table', 1),
(10, '2025_11_03_073304_create_user_notifications_table', 1),
(12, '2025_12_02_040440_add_profile_fields_to_users_table', 2),
(13, '2025_12_02_041706_drop_old_profile_fields_from_users_table', 3),
(14, '2025_12_03_035049_create_carts', 4),
(15, '2025_11_03_124841_full_smart_logic_kubik', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `types`
--

CREATE TABLE `types` (
  `id_type` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `types`
--

INSERT INTO `types` (`id_type`, `name`, `updated_at`) VALUES
('TYP-000001', 'Rooms', '2025-11-08 06:30:24'),
('TYP-000002', 'Items', '2025-11-08 06:30:24');

--
-- Trigger `types`
--
DELIMITER $$
CREATE TRIGGER `trg_types_autoid` BEFORE INSERT ON `types` FOR EACH ROW BEGIN
                SET NEW.id_type = CONCAT('TYP-', LPAD(
                    (SELECT IFNULL(MAX(CAST(SUBSTRING(id_type, 5) AS UNSIGNED)), 0) + 1 FROM types),
                    6, '0'
                ));
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Student','Lecturer','Staff') DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `nip` varchar(255) DEFAULT NULL,
  `enrollment` varchar(255) DEFAULT NULL,
  `faculty` varchar(255) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `name`, `email`, `phone_number`, `password`, `role`, `nim`, `nip`, `enrollment`, `faculty`, `program`, `unit`, `department`, `created_at`, `updated_at`) VALUES
(1766637765, 'mumtaz', 'mumtaz@student.pradita.ac.id', '0812345678', '$2y$12$3bhWbui7S/yNRJMz26MRhODFCUWyCYHxyZgJlfrS/gXqRLkpR9I3K', 'Student', '123456789', NULL, '2023', NULL, 'Accounting', NULL, NULL, '2025-12-11 05:05:59', '2025-12-11 05:05:59'),
(1909308461, 'Siti Aisyah', 'siti.aisyah@student.pradita.ac.id', '082330358566', '$2y$12$T475XLWHhN9zZT4hDdQz/unQmoGECnJX12tgIQjRoIcDpP5IVwI3C', 'Student', '2410102030', NULL, '2024', NULL, 'Business System Information', NULL, NULL, '2025-11-08 06:30:23', '2025-11-08 06:30:23'),
(3493250116, 'Ahmad Abdul Faqih', 'ahmad@student.pradita.ac.id', '082310951928', '$2y$12$/HqGughiBwW3.5vnmhfwveOaH237IWdaWEp0hLuK1/vjXmPcZRSEe', 'Student', '2410102029', NULL, '2024', NULL, 'Business Information System', NULL, NULL, '2025-12-08 04:19:00', '2025-12-08 04:19:00'),
(3934766924, 'Dewi Lestari', 'dewi.lestari@student.kubik.ac.id', '084587576013', '$2y$12$D7cOM5.mGBWvHwQn4mSEXeWEYjxeQft.7I2YuIzic.SITitscXMBa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:23', '2025-11-08 06:30:23'),
(3965979187, 'Rizki Pratama', 'rizki.pratama@student.kubik.ac.id', '086991778014', '$2y$12$eiYPYFNic54dckQch18wcualRvjWaPaCJaggOEK9exCWzFBv5yTnK', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:23', '2025-11-08 06:30:23'),
(4230039916, 'Agus Kurniawan', 'agus.kurniawan@student.kubik.ac.id', '089282439249', '$2y$12$5lPQCrGrNANKjClTHjeHw.Mc4wKphmuG1pZ0ygufY2Y3MdTEO7h7.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:24', '2025-11-08 06:30:24'),
(4902618571, 'Rina Kartika', 'rina.kartika@student.kubik.ac.id', '088803459639', '$2y$12$RdC0Vj3fBfYOxaUT2MkOSeKqHZ0RtBLdd.sugqul2vMzgxh6fURfe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:23', '2025-11-08 06:30:23'),
(5749967518, 'Ahmad Abdul Faqih', 'abdul2@student.pradita.ac.id', '082310951928', '$2y$12$t.cN/rZxFfjQRyc1NA7rmu5XztHhrvVayA9.QbKQL190T5Oo25i5m', 'Student', '2410102029', NULL, '2024', NULL, 'Business Information System', NULL, NULL, '2025-12-17 22:05:23', '2025-12-17 22:05:23'),
(7025595440, 'Ayu Puspita', 'ayu.puspita@student.kubik.ac.id', '082574246293', '$2y$12$teIASux.u8xw3y1ojmZc9.GAR3E6uMXOtiaNV3Sb.RnCGrBpfub86', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:24', '2025-11-08 06:30:24'),
(7097921567, 'Suprianto', 'suprianto@student.pradita.ac.id', '0812345678', '$2y$12$ZUWyrbnOhakiyBpNEeBCC.i10skVehAPhbsQ/27Wxvnh5MKhHxOQS', 'Student', '2410101928', NULL, '2024', NULL, 'Business Information System', NULL, NULL, '2025-12-11 19:57:22', '2025-12-11 19:57:22'),
(7411562267, 'Efren Azriellie', 'efren@student.pradita.ac.id', '08123456789', '$2y$12$8Pw7UUdMf5o/oRgq0mpWiegLDxt0q0Bx/hWlq94INUsQPcMrQKug6', 'Student', '2110102009', NULL, '2021', NULL, 'Business Information System', NULL, NULL, '2025-12-11 19:36:04', '2025-12-11 19:36:04'),
(8073413536, 'Tono Hidayat', 'tono.hidayat@student.kubik.ac.id', '081169178013', '$2y$12$.W/fE9S3BchtCSLwQvCA0OXl7Vo6XKBLhuIPlbWAI1eFEP6Ez6wy.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:24', '2025-11-08 06:30:24'),
(8222509245, 'Ahmad Abdul Faqih', 'abdul@student.pradita.ac.id', '0812345678', '$2y$12$qqRZ8uHPVq8zJKczzGo8UO12eAfqY.jx5TJcvmKmDs/CL8Lq5jiiG', 'Student', '123456789', NULL, '2022', NULL, 'Business Information System', NULL, NULL, '2025-12-10 09:08:39', '2025-12-10 09:08:39'),
(8673477949, 'Budi Santoso', 'budi.santoso@student.kubik.ac.id', '086068775287', '$2y$12$0MZbm4NqcIljsMGdLaeh2uo01JLXIK0fiOWx64NKcrcwto9EACNZ6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', '2025-11-08 06:30:22'),
(8676948208, 'Wulan Sari', 'wulan.sari@student.kubik.ac.id', '083488033731', '$2y$12$9pbLqh8V85QaclOH7uTvEuRbHoU/zZMlEhldqZfkKuFmKC8ILVvTS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:24', '2025-11-08 06:30:24'),
(9356919466, 'Ahmad Abdul', 'ahmad@student.kubik.ac.id', NULL, '$2y$12$eXolRw9Y/f/bcuPoJKzZRux37OJjBSMeDA1UzKIF5oyjcuRJLYUme', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-12-02 05:00:37', '2025-12-02 05:00:37'),
(9526108735, 'Andi Wijaya', 'andi.wijaya@student.kubik.ac.id', '082568052599', '$2y$12$3quEW1CfyDC3RAKBfWdT8.3XBJjQioPqvUIZp71TrsIb7DPV6ZNUu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-08 06:30:23', '2025-11-08 06:30:23'),
(9630599736, 'Wahyu Trisno', 'wahyu@pradita.ac.id', '081adsadsaa', '$2y$12$nPVk4YgZkU7ywARMfYKbTOotGFi02oUt5EEXkGJypsz8WIkuh92GW', 'Lecturer', NULL, '123456789', NULL, NULL, NULL, NULL, NULL, '2025-12-08 21:05:48', '2025-12-08 21:05:48');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `trg_users_autoid` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM users WHERE id_user = new_id;
                END WHILE;

                SET NEW.id_user = new_id;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id_notification` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `user_notifications`
--

INSERT INTO `user_notifications` (`id_notification`, `id_user`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1117434017, 4230039916, 'Your booking PMT-000069 has been rejected.', 0, '2025-11-25 07:56:02', '2025-11-25 07:56:02'),
(1120961197, 3965979187, 'Your booking request PMT-000064 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1247864175, 8676948208, 'Your booking request PMT-000037 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1253808168, 8676948208, 'Your booking request PMT-000015 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1288411255, 7025595440, 'Your booking request PMT-000065 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1364678116, 8676948208, 'Your booking request PMT-000035 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1763944660, 1909308461, 'Your booking request PMT-000010 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1791340709, 3934766924, 'Your booking request PMT-000062 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(1879327332, 3965979187, 'Your booking request PMT-000028 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(2068136583, 3965979187, 'Your booking request PMT-000041 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(2134461174, 4230039916, 'Your booking request PMT-000070 has been created.', 0, '2025-11-25 03:54:41', '2025-11-25 03:54:41'),
(2293226038, 3934766924, 'Your booking request PMT-000006 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(2464794133, 1909308461, 'Your booking request PMT-000002 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(2477963494, 3965979187, 'Your booking request PMT-000004 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(2478557033, 4902618571, 'Your booking request PMT-000039 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(2616280638, 3965979187, 'Your booking request PMT-000038 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(3065803547, 8073413536, 'Your booking request PMT-000030 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(3127724756, 8676948208, 'Your booking request PMT-000044 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(3163799487, 1909308461, 'Your booking request PMT-000070 has been created.', 0, '2025-12-04 05:26:28', '2025-12-04 05:26:28'),
(3197177650, 8673477949, 'Your booking PMT-000057 has been rejected.', 0, '2025-11-28 12:23:44', '2025-11-28 12:23:44'),
(3370379294, 1909308461, 'Your booking request PMT-000049 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(3372002098, 8073413536, 'Your booking request PMT-000068 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(3586957329, 8676948208, 'Your booking request PMT-000026 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(3770375826, 4902618571, 'Your booking PMT-000061 has been rejected.', 0, '2025-11-26 07:28:36', '2025-11-26 07:28:36'),
(3921027694, 4230039916, 'Your booking PMT-000069 has been approved.', 0, '2025-11-25 07:56:04', '2025-11-25 07:56:04'),
(3996164751, 3965979187, 'Your booking request PMT-000052 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4014670157, 4902618571, 'Your booking request PMT-000054 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4065022706, 3934766924, 'Your booking request PMT-000034 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4223317110, 3965979187, 'Your booking request PMT-000063 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4246706618, 8676948208, 'Your booking request PMT-000012 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4374852951, 3934766924, 'Your booking request PMT-000011 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4471138798, 4230039916, 'Your booking request PMT-000069 has been created.', 0, '2025-11-25 03:54:36', '2025-11-25 03:54:36'),
(4607800465, 4902618571, 'Your booking request PMT-000043 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4832680356, 4230039916, 'Your booking request PMT-000024 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4841039318, 8073413536, 'Your booking request PMT-000029 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(4857955558, 9526108735, 'Your booking PMT-000055 has been approved.', 0, '2025-11-25 07:55:34', '2025-11-25 07:55:34'),
(5237788675, 3934766924, 'Your booking request PMT-000009 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(5313751676, 4902618571, 'Your booking request PMT-000013 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(5326946535, 8073413536, 'Your booking request PMT-000048 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(5391165559, 7025595440, 'Your booking request PMT-000066 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(5465703930, 3934766924, 'Your booking request PMT-000051 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(5546060389, 8073413536, 'Your booking request PMT-000040 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(5680916025, 1909308461, 'Your booking request PMT-000031 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(6521661222, 4230039916, 'Your booking PMT-000069 has been approved.', 0, '2025-11-25 07:55:50', '2025-11-25 07:55:50'),
(6656558968, 9526108735, 'Your booking request PMT-000055 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(6751808552, 1909308461, 'Your booking request PMT-000070 has been created.', 0, '2025-12-04 05:29:57', '2025-12-04 05:29:57'),
(7025284488, 4902618571, 'Your booking request PMT-000046 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7094690268, 3965979187, 'Your booking request PMT-000050 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7242787005, 1909308461, 'Your booking request PMT-000023 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7312462095, 4902618571, 'Your booking request PMT-000061 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7343682354, 3965979187, 'Your booking request PMT-000036 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7380054064, 4902618571, 'Your booking request PMT-000042 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7463842158, 4230039916, 'Your booking request PMT-000020 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7871289707, 4902618571, 'Your booking request PMT-000047 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(7926047105, 8673477949, 'Your booking request PMT-000005 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8154034704, 7025595440, 'Your booking request PMT-000016 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8236873271, 9526108735, 'Your booking request PMT-000007 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8320665363, 8676948208, 'Your booking request PMT-000058 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8345175037, 1909308461, 'Your booking request PMT-000032 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8429575832, 3965979187, 'Your booking request PMT-000027 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8430083976, 1909308461, 'Your booking request PMT-000033 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8635846213, 9526108735, 'Your booking request PMT-000025 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8642388347, 8673477949, 'Your booking request PMT-000017 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8690756220, 3965979187, 'Your booking request PMT-000059 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8735797391, 7025595440, 'Your booking request PMT-000053 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8740924777, 8073413536, 'Your booking request PMT-000014 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8785681097, 4230039916, 'Your booking request PMT-000021 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(8956568674, 8073413536, 'Your booking request PMT-000045 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9164500708, 9526108735, 'Your booking request PMT-000001 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9238382399, 8073413536, 'Your booking request PMT-000060 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9342591475, 8676948208, 'Your booking request PMT-000056 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9350584642, 8676948208, 'Your booking request PMT-000003 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9491681225, 4230039916, 'Your booking PMT-000069 has been rejected.', 0, '2025-11-25 07:56:22', '2025-11-25 07:56:22'),
(9600209797, 8673477949, 'Your booking request PMT-000057 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9753363915, 8073413536, 'Your booking request PMT-000022 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9780813600, 8676948208, 'Your booking request PMT-000019 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9819068749, 8673477949, 'Your booking request PMT-000018 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9836446823, 7025595440, 'Your booking request PMT-000067 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25'),
(9861560296, 8673477949, 'Your booking request PMT-000008 has been created.', 0, '2025-11-08 13:30:25', '2025-11-08 13:30:25');

--
-- Trigger `user_notifications`
--
DELIMITER $$
CREATE TRIGGER `trg_user_notifications_autoid` BEFORE INSERT ON `user_notifications` FOR EACH ROW BEGIN
                DECLARE new_id BIGINT;
                DECLARE exist_count INT DEFAULT 1;

                WHILE exist_count > 0 DO
                    SET new_id = FLOOR(1000000000 + RAND() * 9000000000);
                    SELECT COUNT(*) INTO exist_count FROM user_notifications WHERE id_notification = new_id;
                END WHILE;

                SET NEW.id_notification = new_id;
            END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `log_name` (`log_name`);

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indeks untuk tabel `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `admin_notifications_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id_asset`),
  ADD KEY `assets_id_master_foreign` (`id_master`);

--
-- Indeks untuk tabel `asset_masters`
--
ALTER TABLE `asset_masters`
  ADD PRIMARY KEY (`id_master`),
  ADD KEY `asset_masters_id_category_foreign` (`id_category`),
  ADD KEY `asset_masters_id_type_foreign` (`id_type`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id_booking`),
  ADD KEY `bookings_id_user_foreign` (`id_user`),
  ADD KEY `bookings_id_admin_foreign` (`id_admin`);

--
-- Indeks untuk tabel `booking_assets`
--
ALTER TABLE `booking_assets`
  ADD KEY `booking_assets_id_booking_foreign` (`id_booking`),
  ADD KEY `booking_assets_id_asset_foreign` (`id_asset`);

--
-- Indeks untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_id_user_id_asset_unique` (`id_user`,`id_asset`),
  ADD KEY `carts_id_asset_foreign` (`id_asset`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id_type`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `user_notifications_id_user_foreign` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5616969162;

--
-- AUTO_INCREMENT untuk tabel `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id_notification` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9985488470;

--
-- AUTO_INCREMENT untuk tabel `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=310;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9630599737;

--
-- AUTO_INCREMENT untuk tabel `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id_notification` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9861560297;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `assets`
--
ALTER TABLE `assets`
  ADD CONSTRAINT `assets_id_master_foreign` FOREIGN KEY (`id_master`) REFERENCES `asset_masters` (`id_master`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `asset_masters`
--
ALTER TABLE `asset_masters`
  ADD CONSTRAINT `asset_masters_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id_category`) ON DELETE CASCADE,
  ADD CONSTRAINT `asset_masters_id_type_foreign` FOREIGN KEY (`id_type`) REFERENCES `types` (`id_type`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_id_admin_foreign` FOREIGN KEY (`id_admin`) REFERENCES `admins` (`id_admin`),
  ADD CONSTRAINT `bookings_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `booking_assets`
--
ALTER TABLE `booking_assets`
  ADD CONSTRAINT `booking_assets_id_asset_foreign` FOREIGN KEY (`id_asset`) REFERENCES `assets` (`id_asset`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_assets_id_booking_foreign` FOREIGN KEY (`id_booking`) REFERENCES `bookings` (`id_booking`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_id_asset_foreign` FOREIGN KEY (`id_asset`) REFERENCES `assets` (`id_asset`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
