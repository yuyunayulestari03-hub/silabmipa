-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 23 Feb 2026 pada 22.05
-- Versi server: 9.1.0
-- Versi PHP: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `silabmipa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventaris`
--

DROP TABLE IF EXISTS `inventaris`;
CREATE TABLE IF NOT EXISTS `inventaris` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` enum('alat','bahan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_total` int NOT NULL,
  `jumlah_tersedia` int NOT NULL,
  `satuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kondisi` enum('baik','rusak','habis') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'baik',
  `lokasi` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `inventaris_kode_barang_unique` (`kode_barang`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `inventaris`
--

INSERT INTO `inventaris` (`id`, `kode_barang`, `nama_barang`, `kategori`, `jumlah_total`, `jumlah_tersedia`, `satuan`, `kondisi`, `lokasi`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, '1', 'Beaker', 'alat', 6, 5, 'pcs', 'baik', 'rak b', NULL, '2026-02-04 02:44:25', '2026-02-15 02:44:22'),
(3, '4', 'Erlenmeyer', 'alat', 3, 3, 'pcs', 'baik', 'rak b', NULL, '2026-02-10 01:31:54', '2026-02-15 02:34:16'),
(4, '5', 'mikroskop', 'alat', 7, 7, 'pcs', 'baik', 'rak b', NULL, '2026-02-10 01:38:16', '2026-02-20 00:41:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pratikums`
--

DROP TABLE IF EXISTS `jadwal_pratikums`;
CREATE TABLE IF NOT EXISTS `jadwal_pratikums` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `kegiatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_dosen` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_pratikums_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_pratikums`
--

INSERT INTO `jadwal_pratikums` (`id`, `kegiatan`, `nama_dosen`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(1, 'praktikum', '', '2026-02-05', '09:00:00', '10:00:00', 'approved', '2026-02-04 03:06:45', '2026-02-04 03:07:51', 3),
(2, 'penelitian', '', '2026-02-06', '14:22:00', '16:23:00', 'rejected', '2026-02-04 03:23:05', '2026-02-07 02:08:58', 4),
(3, 'penelitian', '', '2026-02-05', '09:00:00', '10:00:00', 'pending', '2026-02-04 21:50:29', '2026-02-04 21:50:29', 5),
(4, 'penelitian', 'dr.yuyun', '2026-02-09', '09:00:00', '10:00:00', 'approved', '2026-02-07 02:08:26', '2026-02-07 02:09:11', 5),
(5, 'belajar', 'dr.yuyun', '2026-02-10', '11:41:00', '12:41:00', 'approved', '2026-02-09 05:41:35', '2026-02-09 05:41:35', 2),
(6, 'kuliah', 'dr ija', '2026-02-11', '13:00:00', '15:00:00', 'approved', '2026-02-10 00:10:19', '2026-02-10 00:10:19', 2),
(7, 'belajar', 'dr.yuyun', '2026-02-11', '12:16:00', '14:15:00', 'approved', '2026-02-10 00:15:23', '2026-02-10 00:15:23', 2),
(8, 'penelitian', 'dr ija', '2026-02-14', '12:11:00', '13:11:00', 'approved', '2026-02-10 00:18:11', '2026-02-18 16:34:25', 2),
(10, 'experiance', 'polmentra, m.kom', '2026-02-13', '07:00:00', '08:00:00', 'approved', '2026-02-10 03:55:26', '2026-02-18 16:27:44', 6),
(11, 'Praktikum Biologi', 'Suraida, M.Si', '2026-02-12', '07:30:00', '10:00:00', 'approved', '2026-02-11 00:13:28', '2026-02-11 00:13:28', 2),
(12, 'belajar', 'Suraida, M.Si', '2026-02-23', '08:35:00', '09:35:00', 'pending', '2026-02-20 01:36:05', '2026-02-20 01:36:05', 5),
(13, 'penelitian', 'dr.yuyun', '2026-02-24', '10:39:00', '11:39:00', 'pending', '2026-02-20 01:39:27', '2026-02-20 01:39:27', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_09_051241_add_role_to_users_table', 1),
(5, '2026_01_18_050750_create_peminjaman_table', 2),
(6, '2026_01_18_053959_add_status_to_peminjaman_table', 3),
(7, '2026_02_03_090420_create_jadwal_pratikums_table', 4),
(8, '2026_02_03_091126_add_status_and_user_id_to_jadwal_pratikums_table', 4),
(9, '2026_02_03_113241_create_inventaris_table', 4),
(10, '2026_02_04_050149_create_settings_table', 4),
(11, '2026_02_04_102333_create_peminjaman_inventaris_table', 5),
(12, '2026_02_07_080658_add_nama_dosen_to_jadwal_praktikums_table', 6),
(13, '2026_02_07_083551_add_nama_dosen_fix_to_jadwal_pratikum_table', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE IF NOT EXISTS `peminjaman` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_peminjam` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman_inventaris`
--

DROP TABLE IF EXISTS `peminjaman_inventaris`;
CREATE TABLE IF NOT EXISTS `peminjaman_inventaris` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `inventaris_id` bigint UNSIGNED NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('pending','approved','rejected','returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `peminjaman_inventaris_user_id_foreign` (`user_id`),
  KEY `peminjaman_inventaris_inventaris_id_foreign` (`inventaris_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `peminjaman_inventaris`
--

INSERT INTO `peminjaman_inventaris` (`id`, `user_id`, `inventaris_id`, `jumlah`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 3, '2026-02-07', '2026-02-07', 'returned', 'penelitian', '2026-02-07 07:26:11', '2026-02-07 07:28:01'),
(2, 5, 1, 2, '2026-02-07', '2026-02-07', 'returned', 'belajar', '2026-02-07 07:30:47', '2026-02-07 08:06:11'),
(3, 5, 1, 1, '2026-02-07', '2026-02-08', 'returned', NULL, '2026-02-07 09:28:57', '2026-02-08 01:22:55'),
(4, 5, 2, 3, '2026-02-08', '2026-02-18', 'approved', NULL, '2026-02-08 00:48:10', '2026-02-08 00:48:36'),
(5, 6, 5, 2, '2026-02-10', '2026-02-11', 'pending', 'belajar', '2026-02-10 04:07:45', '2026-02-10 04:07:45'),
(6, 6, 5, 1, '2026-02-10', '2026-02-12', 'pending', 'www', '2026-02-10 04:13:45', '2026-02-10 04:13:45'),
(7, 6, 5, 1, '2026-02-10', '2026-02-17', 'pending', NULL, '2026-02-10 04:16:43', '2026-02-10 04:16:43'),
(8, 6, 5, 1, '2026-02-10', NULL, 'rejected', 'a', '2026-02-10 04:17:48', '2026-02-15 02:15:12'),
(9, 5, 4, 2, '2026-02-15', '2026-02-17', 'rejected', NULL, '2026-02-15 02:16:32', '2026-02-15 02:34:01'),
(10, 5, 3, 1, '2026-02-15', '2026-02-18', 'rejected', NULL, '2026-02-15 02:16:46', '2026-02-20 00:34:01'),
(11, 7, 4, 1, '2026-02-15', '2026-02-15', 'returned', NULL, '2026-02-15 02:18:55', '2026-02-15 02:43:49'),
(12, 7, 1, 2, '2026-02-15', '2026-02-15', 'returned', NULL, '2026-02-15 02:19:17', '2026-02-15 02:44:22'),
(13, 6, 3, 1, '2026-02-15', '2026-02-15', 'returned', NULL, '2026-02-15 02:19:45', '2026-02-15 02:34:16'),
(14, 5, 4, 2, '2026-02-17', '2026-02-20', 'returned', 'belajar', '2026-02-17 00:26:14', '2026-02-20 00:41:24'),
(15, 5, 4, 1, '2026-02-20', '2026-02-23', 'pending', 'belajar', '2026-02-20 01:57:27', '2026-02-20 01:57:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dQVVb9yg0Gi2TEJvahUebe1jnB84KPZSHPHCEKJc', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU1VSOWRsOTB3MDJlTzRhWWpEUVkwTHlhaDhjMms3aE5LSXBKSUtZWiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9maWxlL3NldHRpbmdzIjtzOjU6InJvdXRlIjtzOjE2OiJwcm9maWxlLnNldHRpbmdzIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1771578070),
('cueRFLYpxTQPB0gJkyjWcmAIrNBFLhsNlZugrVSu', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ1UzMU5zaWUySE5VSHA2Q0h0OVg3UDVhU21ZbmxoYXBsMHl1MFhFWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW1pbmphbWFuLWludmVudGFyaXMiO3M6NToicm91dGUiO3M6Mjc6InBlbWluamFtYW4taW52ZW50YXJpcy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1771662863);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'SILAB MIPA', '2026-02-06 23:47:38', '2026-02-07 00:43:28'),
(2, 'app_logo', '/storage/settings/ADsSPw5slHhiqYdNQ3CxaITXV9fP9JTtTf9ASQEv.png', '2026-02-06 23:47:39', '2026-02-14 23:20:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'santri',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Yuyun Ayu Lestari', 'yuyunayuuu08@gmail.com', NULL, '$2y$12$ONhVuyfjBzDiRNPImA6.AeiND9KUCutWEbgbLmL42Y/coG8eGDahu', 'user', NULL, '2026-02-04 05:31:34', '2026-02-17 00:01:47'),
(2, 'Administrator', 'admin@silabmipa.com', '2026-02-04 02:36:36', '$2y$12$GHWV1ivs9rOSMoXaK4VCEeuAfZO8XEgsf3Teh8FpZVyv97ZJwThwW', 'admin', 'vJMWWIMvd62kBqLfJlDdfYvYdJCvyT5zKBdEHBm7slG7qk305NpyLBNDcSzA', '2026-01-14 21:30:54', '2026-02-04 02:36:36'),
(7, 'Nurzatul  Dihniah', 'nia@gmail.com', NULL, '$2y$12$uXu8C4XddP59RZKqH96mTuZm6xkhCRLOqYgKST7/aXCtjiZo.bTjW', 'user', NULL, '2026-02-15 02:18:24', '2026-02-15 02:18:24'),
(6, 'Prisca Olivia', 'ochaaja@gmail.com', NULL, '$2y$12$DvMXXX1yDO3lwAqbBvLMW.hzuwz2MoeDiPZogL/r1Sumk.EZB6wuC', 'user', NULL, '2026-02-10 02:16:42', '2026-02-10 02:16:42');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
