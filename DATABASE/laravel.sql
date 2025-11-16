-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 23, 2025 at 09:30 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `absences`
--

CREATE TABLE `absences` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `reason` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `absences`
--

INSERT INTO `absences` (`id`, `teacher_id`, `date`, `reason`, `created_at`, `updated_at`) VALUES
(38, 18, '2025-10-24', 'VACATION LEAVE', '2025-10-22 16:56:17', '2025-10-22 16:56:17'),
(39, 20, '2025-10-23', 'VACATION LEAVE', '2025-10-22 17:11:04', '2025-10-22 17:11:04'),
(40, 20, '2025-10-24', 'VACATION LEAVE', '2025-10-22 17:11:04', '2025-10-22 17:11:04'),
(42, 36, '2025-10-27', 'SICK LEAVE', '2025-10-22 18:09:10', '2025-10-22 18:09:10');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'HUMSS 1', 'HUMSS 1, RM 14-04 (GRND FLR 611- BLG)', '2025-10-02 20:54:22', '2025-10-19 21:31:47'),
(2, 'HUMSS 2', 'HUMSS 2, RM 14-05 (2ND FLR 611- BLG)', '2025-10-19 17:25:34', '2025-10-19 21:31:55'),
(3, 'HUMSS 3', 'HUMSS 3, RM 14-06 (2ND FLR 611- BLG)', '2025-10-19 17:27:11', '2025-10-19 21:32:06'),
(4, 'HUMSS 4', 'HUMSS 4, RM 14-07 (2ND FLR 611- BLG)', '2025-10-19 17:27:29', '2025-10-19 21:32:14'),
(5, 'HUMSS 5', 'HUMSS 5, RM 14-08 (2ND FLR 611- BLG)', '2025-10-19 17:27:47', '2025-10-19 21:32:21'),
(6, 'HUMSS 6', 'HUMSS 6, RM 14-09 (3RD FLR 611- BLG)', '2025-10-19 17:28:07', '2025-10-19 21:32:29'),
(7, 'HUMSS 7', 'HUMSS 7, RM 14-10 (3RD FLR 611- BLG)', '2025-10-19 17:28:18', '2025-10-19 21:32:36'),
(8, 'HUMSS 8', 'HUMSS 8, RM 14-11 (3RD FLR 611- BLG)', '2025-10-19 17:28:31', '2025-10-19 21:32:45'),
(9, 'HUMSS 9', 'HUMSS 9, RM 14-12 (3RD FLR 611- BLG)', '2025-10-19 17:28:43', '2025-10-19 21:32:51'),
(10, 'HUMSS 10', 'HUMSS 10, RM 14-13 (4TH FLR 611- BLG)', '2025-10-19 17:28:54', '2025-10-19 21:32:59'),
(11, 'COMPUTER LAB', 'COM LAB, RM 14-14 (4TH FLR 611- BLG)', '2025-10-19 17:29:09', '2025-10-19 21:33:11'),
(12, 'STEM 1', 'STEM 1, RM 14-15 (4TH FLR 611- BLG)', '2025-10-19 17:30:22', '2025-10-19 21:33:21'),
(13, 'STEM 2', 'STEM 2, RM 14-16 (4TH FLR 611- BLG)', '2025-10-19 17:30:36', '2025-10-19 21:33:28'),
(14, 'MASTER TEACHERS OFFICE', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '2025-10-19 17:31:00', '2025-10-19 21:33:40'),
(15, 'SHS SUPPLY OFFICE', 'SUPP, RM 17-02 (GRND FLR G12 -BLG)', '2025-10-19 17:31:18', '2025-10-19 21:33:48'),
(16, 'SNED ROOM', 'SNED RM, RM 17-03 (GRND FLR G -12 BLG)', '2025-10-19 17:31:31', '2025-10-19 21:34:00'),
(17, 'ABM 1', 'ABM 1, RM 17-04 (2ND FLR G -12 BLG)', '2025-10-19 17:32:01', '2025-10-19 21:34:07'),
(18, 'ABM 2', 'ABM 2, RM 17-05 (2ND FLR G -12 BLG)', '2025-10-19 17:32:29', '2025-10-19 21:34:14'),
(19, 'ABM 3', 'ABM 3, RM 17-06 (2ND FLR G -12 BLG)', '2025-10-19 17:32:44', '2025-10-19 21:34:21'),
(20, 'HE 1', 'HE 1, RM 17-07 (3RD FLR G -12 BLG)', '2025-10-19 17:33:10', '2025-10-19 21:34:28'),
(21, 'HE 2', 'HE 2, RM 17-08 (3RD FLR G -12 BLG)', '2025-10-19 17:33:22', '2025-10-19 21:34:35'),
(22, 'ABM 4', 'ABM 4, RM 17-09 (3RD FLR G -12 BLG)', '2025-10-19 17:33:37', '2025-10-19 21:34:44'),
(23, 'ICT 1', 'ICT 1, RM 17-10 (4TH FLR G -12 BLG)', '2025-10-19 17:33:50', '2025-10-19 21:34:50'),
(24, 'ICT 2', 'ICT 2, RM 17-11 (4TH FLR G -12 BLG)', '2025-10-19 17:34:05', '2025-10-19 21:34:57'),
(25, 'HUMSS 11', 'HUMSS 11, RM 17-12 (4TH FLR G -12 BLG)', '2025-10-19 17:34:24', '2025-10-19 21:35:05');

-- --------------------------------------------------------

--
-- Table structure for table `class_models`
--

CREATE TABLE `class_models` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_30_062910_create_teachers_table', 1),
(5, '2025_09_30_062920_create_absences_table', 1),
(6, '2025_09_30_062920_create_classes_table', 1),
(7, '2025_09_30_062920_create_substitutions_table', 1),
(8, '2025_10_02_005401_create_schedules_table', 1),
(9, '2025_10_02_021137_add_day_to_schedules_table', 1),
(10, '2025_10_02_035658_add_name_to_class_models_table', 1),
(11, '2025_10_02_052843_add_description_to_class_models_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `class_id` bigint DEFAULT NULL,
  `time_slot` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `day` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Monday',
  `is_vacant` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `teacher_id`, `class_id`, `time_slot`, `day`, `is_vacant`, `created_at`, `updated_at`) VALUES
(409, 51, NULL, '6:00-7:00', 'Monday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(410, 51, NULL, '7:00-8:00', 'Monday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(411, 51, NULL, '8:15-9:15', 'Monday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(412, 51, NULL, '9:15-10:15', 'Monday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(413, 51, NULL, '10:15-11:15', 'Monday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(414, 51, NULL, '11:15-12:15', 'Monday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(415, 51, NULL, '6:00-7:00', 'Tuesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(416, 51, NULL, '7:00-8:00', 'Tuesday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(417, 51, NULL, '8:15-9:15', 'Tuesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(418, 51, NULL, '9:15-10:15', 'Tuesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(419, 51, NULL, '10:15-11:15', 'Tuesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(420, 51, NULL, '11:15-12:15', 'Tuesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(421, 51, NULL, '6:00-7:00', 'Wednesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(422, 51, NULL, '7:00-8:00', 'Wednesday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(423, 51, NULL, '8:15-9:15', 'Wednesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(424, 51, NULL, '9:15-10:15', 'Wednesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(425, 51, NULL, '10:15-11:15', 'Wednesday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(426, 51, NULL, '11:15-12:15', 'Wednesday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(427, 51, NULL, '6:00-7:00', 'Thursday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(428, 51, NULL, '7:00-8:00', 'Thursday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(429, 51, NULL, '8:15-9:15', 'Thursday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(430, 51, NULL, '9:15-10:15', 'Thursday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(431, 51, NULL, '10:15-11:15', 'Thursday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(432, 51, NULL, '11:15-12:15', 'Thursday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(433, 51, NULL, '6:00-7:00', 'Friday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(434, 51, NULL, '7:00-8:00', 'Friday', 1, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(435, 51, NULL, '8:15-9:15', 'Friday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(436, 51, NULL, '9:15-10:15', 'Friday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(437, 51, NULL, '10:15-11:15', 'Friday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(438, 51, NULL, '11:15-12:15', 'Friday', 0, '2025-10-22 23:39:06', '2025-10-22 23:39:06'),
(439, 17, NULL, '6:00-7:00', 'Monday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(440, 17, NULL, '7:00-8:00', 'Monday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(441, 17, NULL, '8:15-9:15', 'Monday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(442, 17, NULL, '9:15-10:15', 'Monday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(443, 17, NULL, '10:15-11:15', 'Monday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(444, 17, NULL, '11:15-12:15', 'Monday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(445, 17, NULL, '6:00-7:00', 'Tuesday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(446, 17, NULL, '7:00-8:00', 'Tuesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(447, 17, NULL, '8:15-9:15', 'Tuesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(448, 17, NULL, '9:15-10:15', 'Tuesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(449, 17, NULL, '10:15-11:15', 'Tuesday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(450, 17, NULL, '11:15-12:15', 'Tuesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(451, 17, NULL, '6:00-7:00', 'Wednesday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(452, 17, NULL, '7:00-8:00', 'Wednesday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(453, 17, NULL, '8:15-9:15', 'Wednesday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(454, 17, NULL, '9:15-10:15', 'Wednesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(455, 17, NULL, '10:15-11:15', 'Wednesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(456, 17, NULL, '11:15-12:15', 'Wednesday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(457, 17, NULL, '6:00-7:00', 'Thursday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(458, 17, NULL, '7:00-8:00', 'Thursday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(459, 17, NULL, '8:15-9:15', 'Thursday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(460, 17, NULL, '9:15-10:15', 'Thursday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(461, 17, NULL, '10:15-11:15', 'Thursday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(462, 17, NULL, '11:15-12:15', 'Thursday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(463, 17, NULL, '6:00-7:00', 'Friday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(464, 17, NULL, '7:00-8:00', 'Friday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(465, 17, NULL, '8:15-9:15', 'Friday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(466, 17, NULL, '9:15-10:15', 'Friday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(467, 17, NULL, '10:15-11:15', 'Friday', 0, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(468, 17, NULL, '11:15-12:15', 'Friday', 1, '2025-10-22 23:47:34', '2025-10-22 23:47:34'),
(469, 18, NULL, '6:00-7:00', 'Monday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(470, 18, NULL, '7:00-8:00', 'Monday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(471, 18, NULL, '8:15-9:15', 'Monday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(472, 18, NULL, '9:15-10:15', 'Monday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(473, 18, NULL, '10:15-11:15', 'Monday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(474, 18, NULL, '11:15-12:15', 'Monday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(475, 18, NULL, '6:00-7:00', 'Tuesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(476, 18, NULL, '7:00-8:00', 'Tuesday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(477, 18, NULL, '8:15-9:15', 'Tuesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(478, 18, NULL, '9:15-10:15', 'Tuesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(479, 18, NULL, '10:15-11:15', 'Tuesday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(480, 18, NULL, '11:15-12:15', 'Tuesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(481, 18, NULL, '6:00-7:00', 'Wednesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(482, 18, NULL, '7:00-8:00', 'Wednesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(483, 18, NULL, '8:15-9:15', 'Wednesday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(484, 18, NULL, '9:15-10:15', 'Wednesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(485, 18, NULL, '10:15-11:15', 'Wednesday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(486, 18, NULL, '11:15-12:15', 'Wednesday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(487, 18, NULL, '6:00-7:00', 'Thursday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(488, 18, NULL, '7:00-8:00', 'Thursday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(489, 18, NULL, '8:15-9:15', 'Thursday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(490, 18, NULL, '9:15-10:15', 'Thursday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(491, 18, NULL, '10:15-11:15', 'Thursday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(492, 18, NULL, '11:15-12:15', 'Thursday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(493, 18, NULL, '6:00-7:00', 'Friday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(494, 18, NULL, '7:00-8:00', 'Friday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(495, 18, NULL, '8:15-9:15', 'Friday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(496, 18, NULL, '9:15-10:15', 'Friday', 0, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(497, 18, NULL, '10:15-11:15', 'Friday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(498, 18, NULL, '11:15-12:15', 'Friday', 1, '2025-10-23 00:00:40', '2025-10-23 00:00:40'),
(499, 19, NULL, '6:00-7:00', 'Monday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(500, 19, NULL, '7:00-8:00', 'Monday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(501, 19, NULL, '8:15-9:15', 'Monday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(502, 19, NULL, '9:15-10:15', 'Monday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(503, 19, NULL, '10:15-11:15', 'Monday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(504, 19, NULL, '11:15-12:15', 'Monday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(505, 19, NULL, '6:00-7:00', 'Tuesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(506, 19, NULL, '7:00-8:00', 'Tuesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(507, 19, NULL, '8:15-9:15', 'Tuesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(508, 19, NULL, '9:15-10:15', 'Tuesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(509, 19, NULL, '10:15-11:15', 'Tuesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(510, 19, NULL, '11:15-12:15', 'Tuesday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(511, 19, NULL, '6:00-7:00', 'Wednesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(512, 19, NULL, '7:00-8:00', 'Wednesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(513, 19, NULL, '8:15-9:15', 'Wednesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(514, 19, NULL, '9:15-10:15', 'Wednesday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(515, 19, NULL, '10:15-11:15', 'Wednesday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(516, 19, NULL, '11:15-12:15', 'Wednesday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(517, 19, NULL, '6:00-7:00', 'Thursday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(518, 19, NULL, '7:00-8:00', 'Thursday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(519, 19, NULL, '8:15-9:15', 'Thursday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(520, 19, NULL, '9:15-10:15', 'Thursday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(521, 19, NULL, '10:15-11:15', 'Thursday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(522, 19, NULL, '11:15-12:15', 'Thursday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(523, 19, NULL, '6:00-7:00', 'Friday', 1, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(524, 19, NULL, '7:00-8:00', 'Friday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(525, 19, NULL, '8:15-9:15', 'Friday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(526, 19, NULL, '9:15-10:15', 'Friday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(527, 19, NULL, '10:15-11:15', 'Friday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(528, 19, NULL, '11:15-12:15', 'Friday', 0, '2025-10-23 00:03:59', '2025-10-23 00:03:59'),
(529, 20, NULL, '6:00-7:00', 'Monday', 1, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(530, 20, NULL, '7:00-8:00', 'Monday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(531, 20, NULL, '8:15-9:15', 'Monday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(532, 20, NULL, '9:15-10:15', 'Monday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(533, 20, NULL, '10:15-11:15', 'Monday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(534, 20, NULL, '11:15-12:15', 'Monday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(535, 20, NULL, '6:00-7:00', 'Tuesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(536, 20, NULL, '7:00-8:00', 'Tuesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(537, 20, NULL, '8:15-9:15', 'Tuesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(538, 20, NULL, '9:15-10:15', 'Tuesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(539, 20, NULL, '10:15-11:15', 'Tuesday', 1, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(540, 20, NULL, '11:15-12:15', 'Tuesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(541, 20, NULL, '6:00-7:00', 'Wednesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(542, 20, NULL, '7:00-8:00', 'Wednesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(543, 20, NULL, '8:15-9:15', 'Wednesday', 1, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(544, 20, NULL, '9:15-10:15', 'Wednesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(545, 20, NULL, '10:15-11:15', 'Wednesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(546, 20, NULL, '11:15-12:15', 'Wednesday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(547, 20, NULL, '6:00-7:00', 'Thursday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(548, 20, NULL, '7:00-8:00', 'Thursday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(549, 20, NULL, '8:15-9:15', 'Thursday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(550, 20, NULL, '9:15-10:15', 'Thursday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(551, 20, NULL, '10:15-11:15', 'Thursday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(552, 20, NULL, '11:15-12:15', 'Thursday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(553, 20, NULL, '6:00-7:00', 'Friday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(554, 20, NULL, '7:00-8:00', 'Friday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(555, 20, NULL, '8:15-9:15', 'Friday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(556, 20, NULL, '9:15-10:15', 'Friday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(557, 20, NULL, '10:15-11:15', 'Friday', 0, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(558, 20, NULL, '11:15-12:15', 'Friday', 1, '2025-10-23 01:24:25', '2025-10-23 01:24:25'),
(559, 21, NULL, '6:00-7:00', 'Monday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(560, 21, NULL, '7:00-8:00', 'Monday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(561, 21, NULL, '8:15-9:15', 'Monday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(562, 21, NULL, '9:15-10:15', 'Monday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(563, 21, NULL, '10:15-11:15', 'Monday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(564, 21, NULL, '11:15-12:15', 'Monday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(565, 21, NULL, '6:00-7:00', 'Tuesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(566, 21, NULL, '7:00-8:00', 'Tuesday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(567, 21, NULL, '8:15-9:15', 'Tuesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(568, 21, NULL, '9:15-10:15', 'Tuesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(569, 21, NULL, '10:15-11:15', 'Tuesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(570, 21, NULL, '11:15-12:15', 'Tuesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(571, 21, NULL, '6:00-7:00', 'Wednesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(572, 21, NULL, '7:00-8:00', 'Wednesday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(573, 21, NULL, '8:15-9:15', 'Wednesday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(574, 21, NULL, '9:15-10:15', 'Wednesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(575, 21, NULL, '10:15-11:15', 'Wednesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(576, 21, NULL, '11:15-12:15', 'Wednesday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(577, 21, NULL, '6:00-7:00', 'Thursday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(578, 21, NULL, '7:00-8:00', 'Thursday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(579, 21, NULL, '8:15-9:15', 'Thursday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(580, 21, NULL, '9:15-10:15', 'Thursday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(581, 21, NULL, '10:15-11:15', 'Thursday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(582, 21, NULL, '11:15-12:15', 'Thursday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(583, 21, NULL, '6:00-7:00', 'Friday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(584, 21, NULL, '7:00-8:00', 'Friday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(585, 21, NULL, '8:15-9:15', 'Friday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(586, 21, NULL, '9:15-10:15', 'Friday', 1, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(587, 21, NULL, '10:15-11:15', 'Friday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36'),
(588, 21, NULL, '11:15-12:15', 'Friday', 0, '2025-10-23 01:26:36', '2025-10-23 01:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('TCMpBwNNjPPvmt9M2YEqM5DO4QYnYcHLd9iiQ7t0', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT0tzSnFyeHJmbU1qU1Bma3pZa094Z3JNRlRpMlhwVTlaYnA1MmlSdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zY2hlZHVsZXMvY3JlYXRlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1761211723);

-- --------------------------------------------------------

--
-- Table structure for table `substitutions`
--

CREATE TABLE `substitutions` (
  `id` bigint UNSIGNED NOT NULL,
  `class_id` bigint UNSIGNED DEFAULT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `substitute_id` bigint UNSIGNED NOT NULL,
  `time_slot` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_absent` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_available` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `department`, `is_absent`, `is_available`, `created_at`, `updated_at`) VALUES
(17, 'MAYFLOR CASTILLO', 'mayflor@gmail.com', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '0', '1', '2025-10-20 18:29:20', '2025-10-20 18:29:20'),
(18, 'JOANNA MAE MAMALIS', 'joanna@gmail.com', 'HUMSS 8, RM 14-11 (3RD FLR 611- BLG)', '1', '0', '2025-10-20 18:29:47', '2025-10-22 16:56:17'),
(19, 'NEIL PATRICK BANGKAS', 'patrick@gmail.com', 'COM LAB, RM 14-14 (4TH FLR 611- BLG)', '0', '1', '2025-10-20 18:30:17', '2025-10-20 18:30:17'),
(20, 'ANGEL MAY G. MAYNOPAS', 'angel@gmail.com', 'STEM 1, RM 14-15 (4TH FLR 611- BLG)', '1', '0', '2025-10-20 18:30:51', '2025-10-22 17:11:04'),
(21, 'JEZZEL CORADOR', 'jezzel@gmail.com', 'HUMSS 3, RM 14-06 (2ND FLR 611- BLG)', '0', '1', '2025-10-20 18:31:16', '2025-10-20 18:31:16'),
(22, 'ANDRIAN B. SEMBLANTE', 'andrian@gmail.com', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '0', '1', '2025-10-20 18:31:39', '2025-10-20 18:34:16'),
(23, 'CHRIS HEAVENLY CEÑIA', 'chris@gmail.com', 'HUMSS 1, RM 14-04 (GRND FLR 611- BLG)', '0', '1', '2025-10-20 18:31:54', '2025-10-20 18:45:53'),
(24, 'EFREN AGUATANI JR', 'efrenaguatani@gmail.com', 'ICT 1, RM 17-10 (4TH FLR G -12 BLG)', '0', '1', '2025-10-20 18:32:08', '2025-10-20 18:32:08'),
(25, 'STACY CLAIRE L. PRICE', 'stacy@gmail.com', 'HUMSS 2, RM 14-05 (2ND FLR 611- BLG)', '0', '1', '2025-10-20 18:32:40', '2025-10-20 18:32:40'),
(26, 'RALPH CORONADO', 'ralph@gmail.com', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '0', '1', '2025-10-20 18:33:01', '2025-10-20 18:33:01'),
(27, 'GLACY LYN A. ILANDAG', 'glacy@gmail.com', 'HUMSS 7, RM 14-10 (3RD FLR 611- BLG)', '0', '1', '2025-10-20 18:33:17', '2025-10-20 18:33:17'),
(28, 'NORLEY L. FLORES', 'norly@gmail.com', 'ICT 2, RM 17-11 (4TH FLR G -12 BLG)', '0', '1', '2025-10-20 18:33:35', '2025-10-20 18:33:35'),
(29, 'MEIDY H. ALIBANGO', 'meidy@gmail.com', 'HE 1, RM 17-07 (3RD FLR G -12 BLG)', '0', '1', '2025-10-20 18:33:53', '2025-10-20 18:33:53'),
(30, 'MECY GRACE TAPERLA', 'mecy@gmail.com', 'STEM 1, RM 14-15 (4TH FLR 611- BLG)', '0', '1', '2025-10-20 18:34:32', '2025-10-20 18:34:32'),
(31, 'REGINE M. ENARIO', 'regine@gmail.com', 'HUMSS 11, RM 17-12 (4TH FLR G -12 BLG)', '0', '1', '2025-10-20 18:34:57', '2025-10-20 18:34:57'),
(33, 'GLYDEL B. DAGATAN', 'glydel@gmail.com', 'STEM 2, RM 14-16 (4TH FLR 611- BLG)', '0', '1', '2025-10-20 18:35:44', '2025-10-20 18:35:44'),
(34, 'JESTONE T. MAPAYO', 'jestone@gmail.com', 'HUMSS 5, RM 14-08 (2ND FLR 611- BLG)', '0', '1', '2025-10-20 18:35:59', '2025-10-20 18:35:59'),
(35, 'MARLITA B. NIERE', 'marlits@gmail.com', 'ABM 1, RM 17-04 (2ND FLR G -12 BLG)', '0', '1', '2025-10-20 18:36:14', '2025-10-20 18:36:14'),
(36, 'ALBERT A. FUENTES', 'albert@gmail.com', 'HUMSS 9, RM 14-12 (3RD FLR 611- BLG)', '1', '0', '2025-10-20 18:36:26', '2025-10-22 18:09:10'),
(37, 'TISA A SOLLANO', 'tisa@gmail.com', 'ABM 4, RM 17-09 (3RD FLR G -12 BLG)', '0', '1', '2025-10-20 18:36:39', '2025-10-20 18:36:39'),
(38, 'ELMER D. SUAREZ', 'elmer@gmail.com', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '0', '1', '2025-10-20 18:37:09', '2025-10-20 18:37:09'),
(39, 'MARSHA LIZA D. GERONIMO', 'marsha@gmail.com', 'HUMSS 4, RM 14-07 (2ND FLR 611- BLG)', '0', '1', '2025-10-20 18:37:24', '2025-10-20 18:37:24'),
(40, 'AMYLYN D. LABASANO', 'amy@gmail.com', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '0', '1', '2025-10-20 18:37:53', '2025-10-20 18:37:53'),
(41, 'JOHNAVIEVE PATALINGHUG', 'jecky@gmail.com', 'ABM 2, RM 17-05 (2ND FLR G -12 BLG)', '0', '1', '2025-10-20 18:38:24', '2025-10-20 18:38:24'),
(42, 'JOLIVER S. ANZAL', 'joliver@gmail.com', 'HUMSS 6, RM 14-09 (3RD FLR 611- BLG)', '0', '1', '2025-10-20 18:38:45', '2025-10-20 18:38:45'),
(43, 'ROGELIO B. SUDLAY', 'roger@gmail.com', 'COM LAB, RM 14-14 (4TH FLR 611- BLG)', '0', '1', '2025-10-20 18:39:11', '2025-10-20 18:39:11'),
(44, 'CAREN B. ABELLANA', 'caren@gmail.com', 'MT OFFICE, RM 17-01 (GRND FLR G 12 -BLG)', '0', '1', '2025-10-20 18:39:30', '2025-10-20 18:39:30'),
(45, 'DEBBIE BUSIA', 'debbie@gmail.com', 'HUMSS 10, RM 14-13 (4TH FLR 611- BLG)', '0', '1', '2025-10-20 18:39:46', '2025-10-20 18:39:46'),
(51, 'JOHN DEERE GALLEGO', 'johndeeregallego@gmail.com', 'HUMSS 8, RM 14-11 (3RD FLR 611- BLG)', '0', '1', '2025-10-22 22:14:09', '2025-10-22 22:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Admin', 'admin@gmail.com', NULL, '$2y$12$KFX.i79fytWXdfG1MM2xReo2GXzosjzL3cmkFaAvku7DdJZV3oQwy', NULL, '2025-10-21 17:49:14', '2025-10-21 17:49:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`),
  ADD KEY `absences_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `classes_name_unique` (`name`);

--
-- Indexes for table `class_models`
--
ALTER TABLE `class_models`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `class_models_name_unique` (`name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `substitutions`
--
ALTER TABLE `substitutions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `substitutions_class_id_foreign` (`class_id`),
  ADD KEY `substitutions_teacher_id_foreign` (`teacher_id`),
  ADD KEY `substitutions_substitute_id_foreign` (`substitute_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `class_models`
--
ALTER TABLE `class_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;

--
-- AUTO_INCREMENT for table `substitutions`
--
ALTER TABLE `substitutions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absences`
--
ALTER TABLE `absences`
  ADD CONSTRAINT `absences_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `substitutions`
--
ALTER TABLE `substitutions`
  ADD CONSTRAINT `substitutions_class_id_foreign` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `substitutions_substitute_id_foreign` FOREIGN KEY (`substitute_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `substitutions_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
