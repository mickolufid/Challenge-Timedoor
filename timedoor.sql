-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Nov 2019 pada 10.53
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timedoor`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activations`
--

CREATE TABLE `activations` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_account` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `activations`
--

INSERT INTO `activations` (`id`, `id_account`, `created_at`, `updated_at`) VALUES
('13hggg02loog000', 12, '2019-10-24 01:55:17', '2019-10-24 01:55:17'),
('1p80sg02lp40000', 19, '2019-10-30 02:53:49', '2019-10-30 02:53:49'),
('rg36002lp40000', 17, '2019-10-30 00:52:35', '2019-10-30 00:52:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_account` int(11) DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `id_account`, `name`, `title`, `body`, `image`, `password`, `created_at`, `updated_at`, `deleted_at`) VALUES
(28, NULL, 'test', 'this is just a test', 'this is just a test', '', '$2y$10$T15VIgtskwQCSK.dDs7j7eXafNiBkUZRTgFD0QR07qtpF99AcxSBy', '2019-10-24 00:51:18', '2019-11-01 02:07:50', NULL),
(29, NULL, 'test', 'this is just a test', 'this is just a test', '', '$2y$10$J/4euU/.Ryk3wi/0OH17rOGvmIv2CsA5PpBOq56lFyhbJyVv/BUPG', '2019-10-24 00:51:33', '2019-11-01 02:07:45', NULL),
(30, NULL, 'test', 'this is just a test', 'this is just a test', '', '$2y$10$ohGkIwwO5/Xm6m6iELu2kuv4JWJ3i75Y.fqMQdEi9acxSx.XOXaFS', '2019-10-24 00:51:48', '2019-11-01 02:07:40', NULL),
(31, NULL, 'test', 'this is just a test', 'this is just a test', '', '$2y$10$sZEPj5.Lrkur60.sJC1nueV6T7qfqdQaF79GcEIFoSWsN18dv/kZa', '2019-10-24 00:52:04', '2019-11-01 02:07:35', NULL),
(32, NULL, 'test', 'this is just a test', 'this is just a test', '', '$2y$10$kyDpdz7GkWHYqCKygOSo0.Vrq50.E9sJGhTGLVUiBqQSfWERe3fZO', '2019-10-24 00:52:15', '2019-11-01 02:07:30', NULL),
(33, NULL, 'test', 'this is just a test', 'this is just a test', '', '$2y$10$xGBMpslemz/iHH5OKam.beJ61FzenmITVg76jKIGa83LS27LHIM0q', '2019-10-24 00:52:29', '2019-11-01 02:07:26', NULL),
(34, 12, 'alwan hilmy', 'alwan hilmy', 'alwan hilmy', '', '', '2019-10-24 01:56:43', '2019-11-01 02:07:19', NULL),
(35, 12, 'alwan hilmy', 'alwan hilmy', 'alwan hilmy', '', '', '2019-10-24 23:57:30', '2019-11-01 02:07:15', NULL),
(36, NULL, '', 'alwan hilmy', 'alwan hilmy', '', '$2y$10$Y.VKDhPEERADRMqdmiF0SeegOE3C1wmCXLMjT7LtL9qBhoGC9G3aO', '2019-10-25 05:10:29', '2019-11-01 02:07:11', NULL),
(40, 19, 'User', 'coba aja dulu', 'coba aja dulu', '', '', '2019-10-30 02:55:19', '2019-11-01 02:07:06', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(3, '2019_10_09_133134_create_activations_table', 1),
(4, '2019_10_10_001733_create_messages_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unverified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `level`, `status`, `created_at`, `updated_at`) VALUES
(5, 'admin', 'admin@gmail.com', '$2y$10$QflF5vveeIJPUKZAO5j2tuhCTe6YgBLNOabwxzmK9CvmGFUjELC2q', 'admin', 'verified', '2019-10-16 02:27:12', '2019-10-16 02:27:23'),
(12, 'alwan hilmy', 'hudzaifah.hilmy@gmail.com', '$2y$10$4WiMN3QrR7MhpF.4wyH1Sek8mlu1Qi0UTMzb3V40nzruVryFyak6i', 'user', 'verified', '2019-10-24 01:55:17', '2019-10-24 01:56:26'),
(17, 'administrator', 'admin01@gmail.com', '$2y$10$dH8T17vs/UAUBV4qsnVh.e05DRaGtYvTd5twzAprxSaq91dLLg8Ka', 'admin', 'verified', '2019-10-30 00:52:35', '2019-10-30 00:53:27'),
(19, 'User', 'user@gmail.com', '$2y$10$bURlEpz/5qlJQclc0HBsreX4uJU89Jxq4zMrhZ4aVS2uZEybbRERa', 'user', 'verified', '2019-10-30 02:53:48', '2019-10-30 02:54:10');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activations`
--
ALTER TABLE `activations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activations_id_akun_foreign` (`id_account`);

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activations`
--
ALTER TABLE `activations`
  ADD CONSTRAINT `activations_id_akun_foreign` FOREIGN KEY (`id_account`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
