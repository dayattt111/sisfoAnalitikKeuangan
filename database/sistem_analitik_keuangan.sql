-- ============================================
-- Database Schema: Sistem Analitik Keuangan
-- ============================================

-- Drop tables if exists
DROP TABLE IF EXISTS `downloads`;
DROP TABLE IF EXISTS `transactions`;
DROP TABLE IF EXISTS `financial_reports`;
DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

-- ============================================
-- Table: users
-- ============================================
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','staff') NOT NULL DEFAULT 'staff',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: password_reset_tokens
-- ============================================
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: sessions
-- ============================================
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: cache
-- ============================================
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: cache_locks
-- ============================================
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: jobs
-- ============================================
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: job_batches
-- ============================================
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: failed_jobs
-- ============================================
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL UNIQUE,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: activity_logs
-- ============================================
CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: financial_reports
-- ============================================
CREATE TABLE `financial_reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `staff_id` bigint(20) UNSIGNED DEFAULT NULL,
  `validated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `validated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `financial_reports_staff_id_foreign` (`staff_id`),
  KEY `financial_reports_validated_by_foreign` (`validated_by`),
  CONSTRAINT `financial_reports_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `financial_reports_validated_by_foreign` FOREIGN KEY (`validated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: transactions
-- ============================================
CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `financial_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jenis` varchar(255) NOT NULL COMMENT 'pemasukan atau pengeluaran',
  `jumlah` decimal(15,2) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `transactions_financial_report_id_foreign` (`financial_report_id`),
  KEY `transactions_user_id_foreign` (`user_id`),
  CONSTRAINT `transactions_financial_report_id_foreign` FOREIGN KEY (`financial_report_id`) REFERENCES `financial_reports` (`id`) ON DELETE SET NULL,
  CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Table: downloads
-- ============================================
CREATE TABLE `downloads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `financial_report_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `downloaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `downloads_financial_report_id_foreign` (`financial_report_id`),
  KEY `downloads_user_id_foreign` (`user_id`),
  CONSTRAINT `downloads_financial_report_id_foreign` FOREIGN KEY (`financial_report_id`) REFERENCES `financial_reports` (`id`) ON DELETE SET NULL,
  CONSTRAINT `downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SEED DATA
-- ============================================

-- Insert Admin User (password: admin123)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@analitik.com', NOW(), '$2y$12$LQv3c1yycGZxYVa3hWWlve3qXx.Ld1qXZvxPXH.O3UJqRNpS1rqli', 'admin', NOW(), NOW());

-- Insert Sample Manager (password: manager123)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `created_at`, `updated_at`) VALUES
(2, 'Manager Keuangan', 'manager@analitik.com', NOW(), '$2y$12$8vXqNW0ZJqbF3lK6Ym0yge5tJZ8YN9mKp0sD4xH5vQwWzNpT3rLxO', 'manager', NOW(), NOW());

-- Insert Sample Staff (password: staff123)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `created_at`, `updated_at`) VALUES
(3, 'Staff Operasional', 'staff@analitik.com', NOW(), '$2y$12$fM3N6vPqXz2Ly5Kw0Zm8te7rYN1mMp9sE6xF4yH3wRxWaNqT2sKmi', 'staff', NOW(), NOW()),
(4, 'Staff Lapangan', 'staff2@analitik.com', NOW(), '$2y$12$fM3N6vPqXz2Ly5Kw0Zm8te7rYN1mMp9sE6xF4yH3wRxWaNqT2sKmi', 'staff', NOW(), NOW());

-- Insert Sample Activity Logs
INSERT INTO `activity_logs` (`user_id`, `activity`, `created_at`) VALUES
(1, 'Admin pertama kali dibuat pada sistem', NOW()),
(2, 'Manager keuangan ditambahkan ke sistem', NOW()),
(3, 'Staff operasional ditambahkan ke sistem', NOW()),
(4, 'Staff lapangan ditambahkan ke sistem', NOW());

-- Insert Sample Financial Reports
INSERT INTO `financial_reports` (`id`, `staff_id`, `validated_by`, `status`, `validated_at`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, 'pending', NULL, NOW(), NOW()),
(2, 4, 1, 'approved', NOW(), DATE_SUB(NOW(), INTERVAL 2 DAY), NOW()),
(3, 3, 1, 'rejected', NOW(), DATE_SUB(NOW(), INTERVAL 5 DAY), NOW());

-- Insert Sample Transactions
INSERT INTO `transactions` (`financial_report_id`, `user_id`, `jenis`, `jumlah`, `keterangan`, `tanggal`, `created_at`) VALUES
(1, 3, 'pemasukan', 5000000.00, 'Penjualan produk bulan ini', CURDATE(), NOW()),
(1, 3, 'pengeluaran', 1500000.00, 'Pembelian bahan baku', CURDATE(), NOW()),
(2, 4, 'pemasukan', 7500000.00, 'Pendapatan jasa konsultasi', DATE_SUB(CURDATE(), INTERVAL 2 DAY), NOW()),
(2, 4, 'pengeluaran', 2000000.00, 'Biaya operasional', DATE_SUB(CURDATE(), INTERVAL 2 DAY), NOW()),
(3, 3, 'pemasukan', 3000000.00, 'Penjualan minggu lalu', DATE_SUB(CURDATE(), INTERVAL 5 DAY), NOW()),
(3, 3, 'pengeluaran', 500000.00, 'Biaya transport', DATE_SUB(CURDATE(), INTERVAL 5 DAY), NOW());

-- ============================================
-- CREDENTIAL INFO
-- ============================================
-- Admin:
--   Email: admin@analitik.com
--   Password: admin123
--
-- Manager:
--   Email: manager@analitik.com
--   Password: manager123
--
-- Staff:
--   Email: staff@analitik.com
--   Password: staff123
--   
--   Email: staff2@analitik.com
--   Password: staff123
-- ============================================
