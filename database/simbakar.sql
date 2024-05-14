-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 14, 2024 at 01:08 AM
-- Server version: 5.7.39
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simbakar`
--

-- --------------------------------------------------------

--
-- Table structure for table `bbm_prices`
--

CREATE TABLE `bbm_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `bbm_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bbm_prices`
--

INSERT INTO `bbm_prices` (`id`, `uuid`, `start_date`, `bbm_type`, `price`, `created_at`, `updated_at`) VALUES
(1, 'ccdb3a2b-7cd5-4164-a166-99619c1d60c6', '2024-05-07', 'Solar / HSD', 1500000, '2024-05-07 00:53:38', '2024-05-07 00:53:38'),
(3, '44323c67-e2ed-44b9-b8e9-c7dbdb344f7d', '2024-05-07', 'Solar / HSD', 300000, '2024-05-07 02:30:15', '2024-05-07 02:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `bbm_transport_prices`
--

CREATE TABLE `bbm_transport_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bunkers`
--

CREATE TABLE `bunkers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bunker_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bunkers`
--

INSERT INTO `bunkers` (`id`, `uuid`, `bunker_type`, `name`, `capacity`, `created_at`, `updated_at`) VALUES
(1, 'a7a823d9-d1fd-44ee-b260-8f3b7a433e15', 'hsd-solar', 'test', '1200', '2024-05-13 16:01:17', '2024-05-13 16:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `bunker_soundings`
--

CREATE TABLE `bunker_soundings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bunker_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centimeter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `milimeter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volume` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bunker_soundings`
--

INSERT INTO `bunker_soundings` (`id`, `uuid`, `bunker_uuid`, `meter`, `centimeter`, `milimeter`, `volume`, `created_at`, `updated_at`) VALUES
(1, 'dc012aca-9937-4c5e-b778-d1fea3546037', 'a7a823d9-d1fd-44ee-b260-8f3b7a433e15', '300', '300', '300', '300', '2024-05-13 16:01:32', '2024-05-13 16:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `docks`
--

CREATE TABLE `docks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `length` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `width` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `docks`
--

INSERT INTO `docks` (`id`, `uuid`, `name`, `length`, `width`, `draft`, `created_at`, `updated_at`) VALUES
(1, '291e8893-bc9a-4128-b15d-77b952dd4411', 'Pelabuhan Nera', '300', '300', '300', '2024-05-05 06:18:25', '2024-05-05 06:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `dock_equipment`
--

CREATE TABLE `dock_equipment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dock_equipment_lists`
--

CREATE TABLE `dock_equipment_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dock_equipment_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dock_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dock_inspection_parameters`
--

CREATE TABLE `dock_inspection_parameters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dock_inspection_parameter_lists`
--

CREATE TABLE `dock_inspection_parameter_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `dock_inspection_parameter_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dock_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electric_kwh_prices`
--

CREATE TABLE `electric_kwh_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `electric_prices`
--

CREATE TABLE `electric_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `harbors`
--

CREATE TABLE `harbors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `harbor_service_prices`
--

CREATE TABLE `harbor_service_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heavy_equipment`
--

CREATE TABLE `heavy_equipment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `heavy_equipment_type_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heavy_equipment_types`
--

CREATE TABLE `heavy_equipment_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loading_companies`
--

CREATE TABLE `loading_companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `load_types`
--

CREATE TABLE `load_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `load_types`
--

INSERT INTO `load_types` (`id`, `uuid`, `name`, `created_at`, `updated_at`) VALUES
(1, 'fbaf6cb8-6e9c-4d2a-887c-222348a7a1bb', 'Test', '2024-05-05 06:18:04', '2024-05-05 06:18:04');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 1),
(16, '2024_05_03_032137_create_type_ships_table', 1),
(17, '2024_05_03_080958_create_permission_tables', 2),
(18, '2024_05_05_023327_create_ships_table', 3),
(19, '2024_05_05_023702_create_load_types_table', 3),
(20, '2024_05_05_031406_create_docks_table', 3),
(21, '2024_05_05_040518_create_type_ship_dock_availabilities_table', 3),
(22, '2024_05_06_103512_create_electric_prices_table', 4),
(23, '2024_05_06_103523_create_bbm_prices_table', 4),
(24, '2024_05_06_103534_create_harbor_service_prices_table', 4),
(25, '2024_05_06_103547_create_bbm_transport_prices_table', 4),
(26, '2024_05_06_103557_create_price_area_taxes_table', 4),
(27, '2024_05_06_103603_create_price_kso_taxes_table', 4),
(28, '2024_05_06_103637_create_electric_kwh_prices_table', 4),
(29, '2024_05_06_103657_create_ship_unloader_prices_table', 4),
(30, '2024_05_09_051745_create_suppliers_table', 5),
(31, '2024_05_09_061413_create_ship_agents_table', 5),
(32, '2024_05_09_064416_create_loading_companies_table', 5),
(33, '2024_05_09_070320_create_transporters_table', 5),
(34, '2024_05_09_071819_create_harbors_table', 5),
(35, '2024_05_09_134120_create_surveyors_table', 5),
(36, '2024_05_11_025133_create_person_in_charges_table', 5),
(37, '2024_05_12_111739_create_heavy_equipment_types_table', 5),
(38, '2024_05_12_111810_create_heavy_equipment_table', 5),
(39, '2024_05_12_115734_create_units_table', 5),
(40, '2024_05_12_122834_create_bunkers_table', 5),
(41, '2024_05_12_124854_create_bunker_soundings_table', 5),
(42, '2024_05_12_140640_create_dock_inspection_parameters_table', 5),
(43, '2024_05_12_141201_create_dock_equipment_table', 5),
(44, '2024_05_12_144620_create_dock_equipment_lists_table', 5),
(45, '2024_05_12_145349_create_dock_inspection_parameter_lists_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'administration-user', 'web', '2024-05-13 03:25:57', '2024-05-13 03:25:57'),
(2, 'administration-approval', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(3, 'administration-log', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(4, 'administration-role', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(5, 'inisiasi-setting-pbb', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(6, 'inisiasi-produksi-listrik', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(7, 'inisiasi-data-awal-tahun', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(8, 'inisiasi-penerimaan-batu-bara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(9, 'inisiasi-pemakaian', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(10, 'inisiasi-pemakaian-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(11, 'kontrak-batu-bara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(12, 'kontrak-pemesanan-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(13, 'kontrak-transfer-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(14, 'data-kapal', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(15, 'data-pemasok', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(16, 'data-agen-kapal', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(17, 'data-bongkar-muat', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(18, 'data-transportir', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(19, 'data-pelabuhan-muat', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(20, 'data-surveyor', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(21, 'data-pic', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(22, 'data-dermaga', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(23, 'data-alat', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(24, 'data-bunker-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(25, 'data-unit', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(26, 'data-muatan', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(27, 'inputan-analisa', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(28, 'inputan-pembongkaran-batu-bara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(29, 'inputan-penerimaan-batu-bara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(30, 'inputan-pemakaian-batu-bara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(31, 'inputan-penerimaan-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(32, 'inputan-stock-opname', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(33, 'inputan-tug', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(34, 'inputan-jadwal-kapal', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(35, 'inputan-pencatatan-counter', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(36, 'inputan-pemantauan-kapal', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(37, 'inputan-data-bongkar', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(38, 'laporan-executive-summary', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(39, 'laporan-kontrak', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(40, 'laporan-persediaan', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(41, 'laporan-penerimaan', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(42, 'laporan-transportir', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(43, 'laporan-kualitas-batu-bara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(44, 'laporan-pembongkaran', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(45, 'laporan-alat-besar', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(46, 'laporan-denda', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(47, 'laporan-berita-acara', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(48, 'laporan-performance', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(49, 'laporan-bw', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(50, 'laporan-pemantauan-kapal', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(51, 'batu-bara-pembongkaran', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(52, 'batu-bara-penerimaan', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(53, 'batu-bara-pemakaian', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(54, 'bbm-penerimaan', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(55, 'bbm-pemakaian', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(56, 'kapal-jadwal', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(57, 'kapal-pemantauan', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(58, 'pengaturan-ubah-password', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(59, 'variabel-harga-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(60, 'variabel-jasa-dermaga', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(61, 'variabel-angkut-bbm', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(62, 'variabel-pajak-daerah', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(63, 'variabel-pajak-kso', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(64, 'variabel-tarif-listrik', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(65, 'variabel-tarif-kwh', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(66, 'variabel-tarif-ship', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31');

-- --------------------------------------------------------

--
-- Table structure for table `person_in_charges`
--

CREATE TABLE `person_in_charges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `structural_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_position` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `functional_role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_area_taxes`
--

CREATE TABLE `price_area_taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `percentage` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `price_area_taxes`
--

INSERT INTO `price_area_taxes` (`id`, `uuid`, `start_date`, `percentage`, `created_at`, `updated_at`) VALUES
(2, '0897b003-ebbf-43a8-bc96-1cbdf5695c7b', '2024-05-07', 12, '2024-05-07 03:11:17', '2024-05-07 03:11:17'),
(3, '9bc7bcd6-746d-43df-9b4c-28824c63b5b8', '2024-05-09', 10.1, '2024-05-07 03:43:45', '2024-05-07 03:43:45');

-- --------------------------------------------------------

--
-- Table structure for table `price_kso_taxes`
--

CREATE TABLE `price_kso_taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `percentage` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2024-05-13 03:26:31', '2024-05-13 03:26:31'),
(2, 'Operator', 'web', '2024-05-13 06:09:01', '2024-05-13 06:09:01');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(58, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ships`
--

CREATE TABLE `ships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_ship_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `load_type_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_created` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dwt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `loa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ships`
--

INSERT INTO `ships` (`id`, `uuid`, `type_ship_uuid`, `load_type_uuid`, `name`, `year_created`, `flag`, `grt`, `dwt`, `loa`, `status`, `created_at`, `updated_at`) VALUES
(1, '4299136d-be5b-436e-89bd-27df59f97e17', '39a47cfd-ef18-47bd-8002-ebb9f869cf9e', 'fbaf6cb8-6e9c-4d2a-887c-222348a7a1bb', 'Kapal Flying Dutchman', '2024', 'King Indo', '1', '1', '1', 1, '2024-05-05 06:20:20', '2024-05-05 06:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `ship_agents`
--

CREATE TABLE `ship_agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `load_type_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ship_unloader_prices`
--

CREATE TABLE `ship_unloader_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ship_unloader_prices`
--

INSERT INTO `ship_unloader_prices` (`id`, `uuid`, `start_date`, `price`, `created_at`, `updated_at`) VALUES
(1, 'fb988852-8c39-46c7-b2ed-63794a08a53a', '2024-05-05', 1223123, '2024-05-07 06:46:30', '2024-05-07 06:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `load_type_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mining_authorization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mine_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mine_location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `producer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `surveyors`
--

CREATE TABLE `surveyors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transporters`
--

CREATE TABLE `transporters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_ships`
--

CREATE TABLE `type_ships` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_ships`
--

INSERT INTO `type_ships` (`id`, `uuid`, `name`, `created_at`, `updated_at`) VALUES
(1, '39a47cfd-ef18-47bd-8002-ebb9f869cf9e', 'Pesiar', '2024-05-05 06:19:36', '2024-05-05 06:19:36');

-- --------------------------------------------------------

--
-- Table structure for table `type_ship_dock_availabilities`
--

CREATE TABLE `type_ship_dock_availabilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_ship_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dock_uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type_ship_dock_availabilities`
--

INSERT INTO `type_ship_dock_availabilities` (`id`, `uuid`, `type_ship_uuid`, `dock_uuid`, `created_at`, `updated_at`) VALUES
(1, 'a09ef9ba-6c88-4dfa-8ebe-513f046c9243', '39a47cfd-ef18-47bd-8002-ebb9f869cf9e', '291e8893-bc9a-4128-b15d-77b952dd4411', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `role_id`, `name`, `username`, `nid`, `email`, `access_token`, `password`, `status`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 'a2757e1f-3611-47a5-9f54-609a1d863f8a', 1, 'Administrator', 'admin', '123333', 'admin@admin.com', '42ad9064-2c6a-4487-b47d-8d95d68e4d74', '$2y$10$42GCT6TwcqVxSg.4UAF19.91wBFiWfTiBUYVV8TK21/XPSpFsUaAu', 1, NULL, '2024-05-04 00:58:20', '2024-05-13 03:35:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bbm_prices`
--
ALTER TABLE `bbm_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bbm_transport_prices`
--
ALTER TABLE `bbm_transport_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bunkers`
--
ALTER TABLE `bunkers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bunkers_uuid_unique` (`uuid`);

--
-- Indexes for table `bunker_soundings`
--
ALTER TABLE `bunker_soundings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bunker_soundings_uuid_unique` (`uuid`);

--
-- Indexes for table `docks`
--
ALTER TABLE `docks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `docks_uuid_unique` (`uuid`);

--
-- Indexes for table `dock_equipment`
--
ALTER TABLE `dock_equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dock_equipment_uuid_unique` (`uuid`);

--
-- Indexes for table `dock_equipment_lists`
--
ALTER TABLE `dock_equipment_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dock_inspection_parameters`
--
ALTER TABLE `dock_inspection_parameters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dock_inspection_parameters_uuid_unique` (`uuid`);

--
-- Indexes for table `dock_inspection_parameter_lists`
--
ALTER TABLE `dock_inspection_parameter_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electric_kwh_prices`
--
ALTER TABLE `electric_kwh_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `electric_prices`
--
ALTER TABLE `electric_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harbors`
--
ALTER TABLE `harbors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `harbors_uuid_unique` (`uuid`);

--
-- Indexes for table `harbor_service_prices`
--
ALTER TABLE `harbor_service_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heavy_equipment`
--
ALTER TABLE `heavy_equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `heavy_equipment_uuid_unique` (`uuid`);

--
-- Indexes for table `heavy_equipment_types`
--
ALTER TABLE `heavy_equipment_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `heavy_equipment_types_uuid_unique` (`uuid`);

--
-- Indexes for table `loading_companies`
--
ALTER TABLE `loading_companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `loading_companies_uuid_unique` (`uuid`);

--
-- Indexes for table `load_types`
--
ALTER TABLE `load_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `load_types_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `person_in_charges`
--
ALTER TABLE `person_in_charges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `person_in_charges_uuid_unique` (`uuid`);

--
-- Indexes for table `price_area_taxes`
--
ALTER TABLE `price_area_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_kso_taxes`
--
ALTER TABLE `price_kso_taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `ships`
--
ALTER TABLE `ships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ships_uuid_unique` (`uuid`);

--
-- Indexes for table `ship_agents`
--
ALTER TABLE `ship_agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ship_agents_uuid_unique` (`uuid`);

--
-- Indexes for table `ship_unloader_prices`
--
ALTER TABLE `ship_unloader_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_uuid_unique` (`uuid`);

--
-- Indexes for table `surveyors`
--
ALTER TABLE `surveyors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `surveyors_uuid_unique` (`uuid`);

--
-- Indexes for table `transporters`
--
ALTER TABLE `transporters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transporters_uuid_unique` (`uuid`);

--
-- Indexes for table `type_ships`
--
ALTER TABLE `type_ships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_ships_uuid_unique` (`uuid`);

--
-- Indexes for table `type_ship_dock_availabilities`
--
ALTER TABLE `type_ship_dock_availabilities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_ship_dock_availabilities_uuid_unique` (`uuid`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_uuid_unique` (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bbm_prices`
--
ALTER TABLE `bbm_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bbm_transport_prices`
--
ALTER TABLE `bbm_transport_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bunkers`
--
ALTER TABLE `bunkers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bunker_soundings`
--
ALTER TABLE `bunker_soundings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `docks`
--
ALTER TABLE `docks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dock_equipment`
--
ALTER TABLE `dock_equipment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dock_equipment_lists`
--
ALTER TABLE `dock_equipment_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dock_inspection_parameters`
--
ALTER TABLE `dock_inspection_parameters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dock_inspection_parameter_lists`
--
ALTER TABLE `dock_inspection_parameter_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electric_kwh_prices`
--
ALTER TABLE `electric_kwh_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `electric_prices`
--
ALTER TABLE `electric_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harbors`
--
ALTER TABLE `harbors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harbor_service_prices`
--
ALTER TABLE `harbor_service_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `heavy_equipment`
--
ALTER TABLE `heavy_equipment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `heavy_equipment_types`
--
ALTER TABLE `heavy_equipment_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loading_companies`
--
ALTER TABLE `loading_companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `load_types`
--
ALTER TABLE `load_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `person_in_charges`
--
ALTER TABLE `person_in_charges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `price_area_taxes`
--
ALTER TABLE `price_area_taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `price_kso_taxes`
--
ALTER TABLE `price_kso_taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ships`
--
ALTER TABLE `ships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ship_agents`
--
ALTER TABLE `ship_agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ship_unloader_prices`
--
ALTER TABLE `ship_unloader_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surveyors`
--
ALTER TABLE `surveyors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transporters`
--
ALTER TABLE `transporters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_ships`
--
ALTER TABLE `type_ships`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `type_ship_dock_availabilities`
--
ALTER TABLE `type_ship_dock_availabilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
