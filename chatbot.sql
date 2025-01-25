-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jan 2025 pada 13.25
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
-- Database: `chatbot`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('127.0.0.1', 'i:13;', 1737162799),
('127.0.0.1:timer', 'i:1737162799;', 1737162799),
('192.168.56.1', 'i:6;', 1737774824),
('192.168.56.1:timer', 'i:1737774824;', 1737774824);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `chatbot_providers`
--

CREATE TABLE `chatbot_providers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `api_key` text NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `config` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`config`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `chatbot_providers`
--

INSERT INTO `chatbot_providers` (`id`, `name`, `api_key`, `endpoint`, `config`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Gemini-Flash Dude', 'eyJpdiI6ImYrT0EvVFNJbnRqRGh3cmg1endoakE9PSIsInZhbHVlIjoiMTB6Z2VRR2VQSmxGNTEvbFpud1VrUT09IiwibWFjIjoiZGRlYWE2ZWY4MGJhYzllODU1YWMxNDRlOWNhYWE5MDE3N2UwYzUxY2EwNjU0OWRjNzM5NjY3YjA1MzhkMWUzMCIsInRhZyI6IiJ9', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent', '\"\\\"\\\\\\\"\\\\\\\\\\\\\\\"[]\\\\\\\\\\\\\\\"\\\\\\\"\\\"\"', 0, '2025-01-17 05:07:55', '2025-01-25 05:23:05', '2025-01-25 05:23:05'),
(7, 'Gemini', 'eyJpdiI6Ijg5QTcxeGtGWjBXZGl3RVlhZWdlZVE9PSIsInZhbHVlIjoiTmU3Ukl4QmYvNitzUHpZMlV6OHoxTllaTHFKYks5K2tjbU5LMkQwWG5rTWNFWm5ObGdUNVF6SlE0cms5Q1M5OCIsIm1hYyI6IjNlMTdlYjU0OWJjYmRmZjAyZmE0ZmZhNzgxYmEyZmE5YTk0NDIyNzljN2M3NTg3MjhhNGYwN2JlODUxMjE0ZDYiLCJ0YWciOiIifQ==', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', '\"[]\"', 1, '2025-01-24 06:31:15', '2025-01-24 07:16:45', NULL),
(8, 'admin', 'eyJpdiI6ImJIc0QyT0JTdXczMHUzbDQwVitNNXc9PSIsInZhbHVlIjoiOWVMWjIzQnMyOTBTd2RpTHFrWGlBaTlGRytyQ1JOQnNzVGtUaGRtV0NZSDRyb3VFbjhUd1VmakUzU3owN1RBUiIsIm1hYyI6ImQ4NTBiYzE3ODU2MDM3ZDgyYjUzYTVjMzY2Y2U1ZjhhNjM3ZTFmODYwN2JmMmFhYjY3NzQ5NWM2YjlhYjNlZDQiLCJ0YWciOiIifQ==', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent', '\"\\\"[]\\\"\"', 0, '2025-01-24 07:15:08', '2025-01-24 18:55:13', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `provider_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `response` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `provider_id`, `message`, `response`, `created_at`, `updated_at`) VALUES
(10, 1, 7, 'tess', '\"Tess\" could refer to several things, most notably:\n\n* **Tess of the d\'Urbervilles:** Thomas Hardy\'s famous novel.  This is probably the most common association with the name.\n* **A person named Tess:**  It\'s a relatively common name.\n\nTo understand what you mean by \"Tess,\" I need more context.  Are you thinking of the book, a person, something else entirely?\n', '2025-01-24 06:31:29', '2025-01-24 06:31:29'),
(14, 1, 7, 'sss', '\"sss\" doesn\'t have a meaning on its own.  It could be:\n\n* **An abbreviation or acronym:**  Without more context, it\'s impossible to say what it stands for.\n* **A sound:**  It represents the sound of a hissing \'s\'.\n* **A typo:**  Perhaps the user meant to type something else.\n* **Part of a larger text:**  If you provide more context, I might be able to understand its meaning.\n\nPlease provide more information!\n', '2025-01-24 07:17:04', '2025-01-24 07:17:04'),
(21, 1, 7, 'tess', '\"Tess\" could refer to a few things, most notably:\n\n* **Tess of the d\'Urbervilles:**  Thomas Hardy\'s famous novel.  This is likely the most common association with the name.\n* **A person named Tess:**  A common female name.  Without more context, this is also a possibility.\n\nTo understand what you mean by \"Tess,\" please provide more context.\n', '2025-01-25 05:22:47', '2025-01-25 05:22:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_04_024316_create_chatbot_providers_table', 1),
(5, '2025_01_04_025016_create_chats_table', 1),
(6, '2025_01_10_123951_create_personal_access_tokens_table', 1),
(7, '2025_01_17_112117_create_topics_table', 1),
(8, '2025_01_04_032027_add_role_to_users_table', 2),
(9, '2025_01_04_092923_modify_api_key_column_in_chatbot_providers', 2),
(10, '2025_01_24_124051_addsoft', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 1, 'auth_token', '29c5c6cabf78bd03600a32f24d48a30319bd195ea42a98f950a41cf3805d3401', '[\"*\"]', NULL, NULL, '2025-01-17 08:07:33', '2025-01-17 08:07:33'),
(4, 'App\\Models\\User', 1, 'auth_token', '7b2a111c2b5c79f15996e07501dcf7192c65b9c0b11dffff02fcf75b9257b7f3', '[\"*\"]', NULL, NULL, '2025-01-17 10:39:34', '2025-01-17 10:39:34'),
(7, 'App\\Models\\User', 1, 'auth_token', '7a264d073fdf0ed898d82d3baf0b6ee084ff35e10cbc9fc01ce54102da1d611a', '[\"*\"]', NULL, NULL, '2025-01-17 10:49:24', '2025-01-17 10:49:24'),
(8, 'App\\Models\\User', 2, 'auth_token', 'a69ce19b79ad2fa177a13930f93840fcc97b88110661dd6461de1e8488b66189', '[\"*\"]', NULL, NULL, '2025-01-17 10:50:00', '2025-01-17 10:50:00'),
(9, 'App\\Models\\User', 1, 'auth_token', '6f9907549e7ee98bb346a002963670639dd6331f65a334ed87653693ffecb5e1', '[\"*\"]', NULL, NULL, '2025-01-17 11:02:15', '2025-01-17 11:02:15'),
(11, 'App\\Models\\User', 1, 'auth_token', 'a944e7203b10228bc93dbb0c1081650f928faa58f09d96c7a341520dc771629f', '[\"*\"]', NULL, NULL, '2025-01-17 17:43:33', '2025-01-17 17:43:33'),
(12, 'App\\Models\\User', 1, 'auth_token', 'f187b154069640eb07d41ebb0e80a5c2844314f77157487f7cd39569747fbd3c', '[\"*\"]', NULL, NULL, '2025-01-17 17:50:32', '2025-01-17 17:50:32'),
(13, 'App\\Models\\User', 1, 'auth_token', 'efcc4cd8336e141434ba5ef13ab8cf796175da2a49bd0734a0bfee1216b4f761', '[\"*\"]', '2025-01-17 17:55:46', NULL, '2025-01-17 17:51:58', '2025-01-17 17:55:46'),
(14, 'App\\Models\\User', 1, 'auth_token', '8eb07217719dfb617563300ebbd218f4702886d791ebb986dd790100dd70845f', '[\"*\"]', '2025-01-17 18:00:53', NULL, '2025-01-17 17:56:07', '2025-01-17 18:00:53'),
(15, 'App\\Models\\User', 1, 'auth_token', '3886993580852b2a5094dadadb9078bcb7cc7e75ad84306115350315c3963269', '[\"*\"]', '2025-01-17 18:04:08', NULL, '2025-01-17 18:01:10', '2025-01-17 18:04:08'),
(16, 'App\\Models\\User', 1, 'auth_token', 'eef7c3669c96bb7bb60c2590e15196ce2fa2095ab6bd675013beec79255e96e1', '[\"*\"]', '2025-01-17 18:08:42', NULL, '2025-01-17 18:04:38', '2025-01-17 18:08:42'),
(17, 'App\\Models\\User', 1, 'auth_token', '9b3f40dc2281a7ea51240c333e88fea0789cf52110f2f83a53c53c1f4a09a3a4', '[\"*\"]', '2025-01-17 18:12:21', NULL, '2025-01-17 18:08:56', '2025-01-17 18:12:21'),
(18, 'App\\Models\\User', 1, 'auth_token', 'a72cb52b587d9f63d3dd8bbe27cf7e76df25ef4c4d7fdb51d92cc6073b5b49ec', '[\"*\"]', '2025-01-17 18:16:08', NULL, '2025-01-17 18:12:36', '2025-01-17 18:16:08'),
(19, 'App\\Models\\User', 1, 'auth_token', 'a83e276f61c6cbbfaec71cfbea2fa0888bea890b5ab886e6a36b24d540aeaafd', '[\"*\"]', '2025-01-17 18:31:31', NULL, '2025-01-17 18:16:18', '2025-01-17 18:31:31'),
(20, 'App\\Models\\User', 1, 'auth_token', '94083da170f2b2464760c04cced518b1b79882c1417cbb80b255e0ce39fcb240', '[\"*\"]', '2025-01-17 18:37:33', NULL, '2025-01-17 18:33:52', '2025-01-17 18:37:33'),
(21, 'App\\Models\\User', 1, 'auth_token', 'b0ecd3dd65e724f9a1b55a009071b3489a8ee232bc62a7d652dac78a1bd6fd71', '[\"*\"]', '2025-01-17 18:45:27', NULL, '2025-01-17 18:38:06', '2025-01-17 18:45:27'),
(22, 'App\\Models\\User', 1, 'auth_token', 'deeff994b9947032a41692fa9ffa2f7f4c7a3a50a0426a6bfba436c618c132cf', '[\"*\"]', '2025-01-17 18:49:48', NULL, '2025-01-17 18:45:43', '2025-01-17 18:49:48'),
(23, 'App\\Models\\User', 1, 'auth_token', 'f2828472a81c214d6f63e842196b323609bd46fdb5ed0b246cc99f25807d9b9e', '[\"*\"]', '2025-01-17 18:52:46', NULL, '2025-01-17 18:50:01', '2025-01-17 18:52:46'),
(24, 'App\\Models\\User', 1, 'auth_token', '6ed6d3203831e5eb00d935abcb5c9b26d260b3ea0f4dc686279e6c54947a16a6', '[\"*\"]', '2025-01-17 18:58:42', NULL, '2025-01-17 18:53:05', '2025-01-17 18:58:42'),
(25, 'App\\Models\\User', 1, 'auth_token', 'f3942c82441ebb0b4e8adfc8ded7c9bf47d2c12812726d9a3c48ccfaafa745a2', '[\"*\"]', '2025-01-17 19:00:58', NULL, '2025-01-17 18:58:53', '2025-01-17 19:00:58'),
(26, 'App\\Models\\User', 1, 'auth_token', 'a9e39a13b7234ea182f248c5803ffaed31b15cb6cc2f441ce29cfe167e4d9259', '[\"*\"]', '2025-01-17 19:05:36', NULL, '2025-01-17 19:01:14', '2025-01-17 19:05:36'),
(27, 'App\\Models\\User', 1, 'auth_token', 'a923825d9a0fa32ce762100a064d0cd0ff8838710c9c0940f34ad8c3a96fca1d', '[\"*\"]', '2025-01-17 19:07:30', NULL, '2025-01-17 19:05:47', '2025-01-17 19:07:30'),
(28, 'App\\Models\\User', 1, 'auth_token', '33a6cf6b169b5767c8d373718d9302a2ffd89e13af3da263b83d5961d0ccf3cb', '[\"*\"]', '2025-01-17 19:09:35', NULL, '2025-01-17 19:07:50', '2025-01-17 19:09:35'),
(29, 'App\\Models\\User', 1, 'auth_token', '9eae8578ed353042729310a596e7389bab762d26d4f9ba75bbb8c17510e6b716', '[\"*\"]', '2025-01-17 19:11:57', NULL, '2025-01-17 19:09:48', '2025-01-17 19:11:57'),
(30, 'App\\Models\\User', 1, 'auth_token', 'bd8f957f648f962972bec8703e655ddd3b39ca6000b0629a1ceb3e299d47b744', '[\"*\"]', '2025-01-17 19:16:07', NULL, '2025-01-17 19:12:09', '2025-01-17 19:16:07'),
(31, 'App\\Models\\User', 1, 'auth_token', '1ec4b901e60c90c6300cef67843878f31c401a181e90c163ea5fed246b5caf0f', '[\"*\"]', '2025-01-17 19:19:06', NULL, '2025-01-17 19:16:18', '2025-01-17 19:19:06'),
(32, 'App\\Models\\User', 1, 'auth_token', '454ee87ddd24aec6a2ebade7463232be45a92cbc855fb02a9dcc29c7e00d4c4e', '[\"*\"]', '2025-01-17 19:20:31', NULL, '2025-01-17 19:19:33', '2025-01-17 19:20:31'),
(33, 'App\\Models\\User', 1, 'auth_token', 'e9ead2216363074318d62369753be586700c15ea6e34bfef2059ac40718f364d', '[\"*\"]', '2025-01-17 19:32:34', NULL, '2025-01-17 19:26:53', '2025-01-17 19:32:34'),
(34, 'App\\Models\\User', 1, 'auth_token', '7df9c4a363b2780349fd5a8fa4c86e83e1cbad232a6ac2251be95de5dd091054', '[\"*\"]', '2025-01-24 04:18:06', NULL, '2025-01-24 03:56:21', '2025-01-24 04:18:06'),
(35, 'App\\Models\\User', 1, 'auth_token', '520afc0f4571658e97ca6118af14be277cb565b359396059e45eb2ebc507b3c9', '[\"*\"]', '2025-01-24 04:23:50', NULL, '2025-01-24 04:23:37', '2025-01-24 04:23:50'),
(36, 'App\\Models\\User', 1, 'auth_token', '84d3c4e70cb12b88b36c31b55f1aee42f818208c78b5a77034bbb50c2528d094', '[\"*\"]', '2025-01-24 04:26:27', NULL, '2025-01-24 04:25:15', '2025-01-24 04:26:27'),
(37, 'App\\Models\\User', 1, 'auth_token', 'dac47f934f382f6fe8d723fb796e90de8c00e7f1405fdcf7e5cb1492466e52fe', '[\"*\"]', '2025-01-24 04:31:16', NULL, '2025-01-24 04:31:14', '2025-01-24 04:31:16'),
(38, 'App\\Models\\User', 1, 'auth_token', 'ca8d4542cafa5e352ebd3362b363555d0e18a1cc7392ea411e194c11dc55b663', '[\"*\"]', '2025-01-24 04:44:32', NULL, '2025-01-24 04:43:59', '2025-01-24 04:44:32'),
(39, 'App\\Models\\User', 1, 'auth_token', '199dd07b9c6a6f65c8e4f50812ac578f53b8a3d6a286b17527703188cfa0963b', '[\"*\"]', '2025-01-24 05:06:19', NULL, '2025-01-24 04:46:42', '2025-01-24 05:06:19'),
(40, 'App\\Models\\User', 1, 'auth_token', 'db09281edccbbfddceb8eabe0069f3c62b0fbfe7b3368ca572d29c8e23868374', '[\"*\"]', '2025-01-24 05:24:39', NULL, '2025-01-24 05:22:42', '2025-01-24 05:24:39'),
(41, 'App\\Models\\User', 1, 'auth_token', '3299bc8225447d154f35dce345de720771cf8d6afb9fe09240c56a885650ee3f', '[\"*\"]', '2025-01-24 05:46:21', NULL, '2025-01-24 05:33:26', '2025-01-24 05:46:21'),
(42, 'App\\Models\\User', 1, 'auth_token', 'dddc7d302f0206d1c80b1a156ae0da7284da6bddfa338b1d0178c003b77d140b', '[\"*\"]', '2025-01-24 05:57:13', NULL, '2025-01-24 05:57:12', '2025-01-24 05:57:13'),
(43, 'App\\Models\\User', 1, 'auth_token', '4be40ca75353ff73cb8cd3b40bbfb20730b65c005f6ea0ef7edbe99896cfa08d', '[\"*\"]', '2025-01-24 06:06:46', NULL, '2025-01-24 06:03:26', '2025-01-24 06:06:46'),
(44, 'App\\Models\\User', 1, 'auth_token', '7f3452c47e544a05863695e20bd2325a94e59116c6524e3103ffe29db96e14b0', '[\"*\"]', '2025-01-24 06:08:36', NULL, '2025-01-24 06:08:35', '2025-01-24 06:08:36'),
(45, 'App\\Models\\User', 1, 'auth_token', '7f564eda5bcb00736907c84b1e0cb9fad14e9ab650697337f229498fd2eda8de', '[\"*\"]', '2025-01-24 06:11:31', NULL, '2025-01-24 06:10:13', '2025-01-24 06:11:31'),
(46, 'App\\Models\\User', 1, 'auth_token', '0955b579c256834ae6a5674d0c98eccd8f22aa582b4d3a1e547da07c3c736740', '[\"*\"]', '2025-01-24 06:20:22', NULL, '2025-01-24 06:17:57', '2025-01-24 06:20:22'),
(47, 'App\\Models\\User', 1, 'auth_token', '7bbdaf258e1ede8622f6e2c3e5a627395866ec93b495995caf1f1ca06d72cb9a', '[\"*\"]', '2025-01-24 06:41:22', NULL, '2025-01-24 06:22:58', '2025-01-24 06:41:22'),
(48, 'App\\Models\\User', 1, 'auth_token', '46fe87314c994ec391e22d24e14ab9d8a959cd8f1099f85cfaadcd8d323069ab', '[\"*\"]', '2025-01-24 06:46:01', NULL, '2025-01-24 06:45:49', '2025-01-24 06:46:01'),
(49, 'App\\Models\\User', 1, 'auth_token', '66e4e16bfbaa7d9499cbee2ca81bb86076d159adaa0eeabedfb572b8d6a52e13', '[\"*\"]', '2025-01-24 06:56:27', NULL, '2025-01-24 06:51:11', '2025-01-24 06:56:27'),
(50, 'App\\Models\\User', 1, 'auth_token', '1052ddf6ecada32f329d1a8dda06d2cc7cd901152ffde2889a3a4735bbe6997c', '[\"*\"]', '2025-01-24 06:59:16', NULL, '2025-01-24 06:59:15', '2025-01-24 06:59:16'),
(51, 'App\\Models\\User', 1, 'auth_token', 'edd165d0bd9e8b9fbf8bcee7762859c45bc86902a21be4d31fb15407e4ed3b07', '[\"*\"]', '2025-01-24 07:02:37', NULL, '2025-01-24 07:02:36', '2025-01-24 07:02:37'),
(52, 'App\\Models\\User', 1, 'auth_token', '029d79f3a21053f16653426f0627151065fa20ae674728d600e207834deee4f0', '[\"*\"]', '2025-01-24 07:03:53', NULL, '2025-01-24 07:03:52', '2025-01-24 07:03:53'),
(53, 'App\\Models\\User', 1, 'auth_token', '4dfe64387eb3e962470706759d5ccbf060f3b75be481273215b1f396806a37aa', '[\"*\"]', '2025-01-24 07:04:43', NULL, '2025-01-24 07:04:42', '2025-01-24 07:04:43'),
(54, 'App\\Models\\User', 1, 'auth_token', '2027452104f342c856d90dee70fb148635d1739546debb6e3ac14cc0efd3f405', '[\"*\"]', '2025-01-24 07:06:15', NULL, '2025-01-24 07:06:13', '2025-01-24 07:06:15'),
(55, 'App\\Models\\User', 1, 'auth_token', '338bc79ae4e061b64b09f585c3e65a124a870f1130618bf031b137a0d1a853e8', '[\"*\"]', '2025-01-24 07:08:05', NULL, '2025-01-24 07:08:03', '2025-01-24 07:08:05'),
(56, 'App\\Models\\User', 1, 'auth_token', 'd3d1b08f5fe8c3259e9f015ef660c3637a906adcec122af5f76a7d24198eed79', '[\"*\"]', '2025-01-24 07:11:44', NULL, '2025-01-24 07:10:09', '2025-01-24 07:11:44'),
(57, 'App\\Models\\User', 1, 'auth_token', '843ee896fabcb1457661fada0880d9216c7824e80ce0db202c3ce2f7afda775e', '[\"*\"]', '2025-01-24 07:18:13', NULL, '2025-01-24 07:13:05', '2025-01-24 07:18:13'),
(58, 'App\\Models\\User', 1, 'auth_token', '6b76c47a55e6f1726a1f122107ccc9713530af0a07e92d727b24543e49e08a85', '[\"*\"]', '2025-01-24 07:20:05', NULL, '2025-01-24 07:19:47', '2025-01-24 07:20:05'),
(59, 'App\\Models\\User', 1, 'auth_token', '18f88bd07a800ad45f739b702380050b392f16de29da518a42c3a8fa91981c1d', '[\"*\"]', '2025-01-24 19:07:24', NULL, '2025-01-24 18:54:25', '2025-01-24 19:07:24'),
(60, 'App\\Models\\User', 1, 'auth_token', '14b5e3127a6938a097c90e9f1c4afe6ae1b997f02e3bd25914788ece1d8f5277', '[\"*\"]', '2025-01-24 19:10:45', NULL, '2025-01-24 19:07:34', '2025-01-24 19:10:45'),
(62, 'App\\Models\\User', 1, 'auth_token', '4ea2cc86839ea37e792aa402673673b16954ea1dec518ffaa39807f00b9cdb7f', '[\"*\"]', '2025-01-24 20:06:46', NULL, '2025-01-24 20:06:40', '2025-01-24 20:06:46'),
(63, 'App\\Models\\User', 1, 'auth_token', '4f475b81efba3b612e00ab668668a4514fecbaf75511d162a8d4a21d00606825', '[\"*\"]', '2025-01-24 20:11:36', NULL, '2025-01-24 20:11:30', '2025-01-24 20:11:36'),
(64, 'App\\Models\\User', 1, 'auth_token', '5fdee468d06aa774b3b1d71df93fc7963339f7b6f2e2e4c52a062ab6522ea583', '[\"*\"]', '2025-01-24 20:12:58', NULL, '2025-01-24 20:12:45', '2025-01-24 20:12:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `topics`
--

CREATE TABLE `topics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Admin User', 'admin@admin.com', '2025-01-17 05:07:55', '$2y$12$oSvgfCs7Gc/BAzcpwzap7eLmOqmJ9XH0rMldxz4FghQgvZzi61lra', NULL, '2025-01-17 05:07:55', '2025-01-17 05:07:55', 'admin'),
(2, 'Regular User', 'user@user.com', '2025-01-17 05:07:55', '$2y$12$5R7R6nblECk/OKG/zsKot.Y55gD.6SRIvZEaEM0R4.QIooKgh.fRe', NULL, '2025-01-17 05:07:55', '2025-01-17 05:07:55', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `chatbot_providers`
--
ALTER TABLE `chatbot_providers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_user_id_foreign` (`user_id`),
  ADD KEY `chats_provider_id_foreign` (`provider_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `chatbot_providers`
--
ALTER TABLE `chatbot_providers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT untuk tabel `topics`
--
ALTER TABLE `topics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_provider_id_foreign` FOREIGN KEY (`provider_id`) REFERENCES `chatbot_providers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
