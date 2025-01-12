-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2025 at 11:54 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `administrasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `bargings`
--

CREATE TABLE `bargings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laycan` varchar(255) DEFAULT NULL,
  `namebarge` varchar(255) NOT NULL,
  `surveyor` varchar(255) NOT NULL,
  `portloading` varchar(255) NOT NULL,
  `portdishcharging` varchar(255) NOT NULL,
  `notifyaddres` varchar(255) NOT NULL,
  `initialsurvei` date NOT NULL,
  `finalsurvey` date NOT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bargings`
--

INSERT INTO `bargings` (`id`, `laycan`, `namebarge`, `surveyor`, `portloading`, `portdishcharging`, `notifyaddres`, `initialsurvei`, `finalsurvey`, `quantity`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`, `tanggal`, `plan_id`) VALUES
(1, '10-11 Nov 2024', 'TB. TMH 16 / BG ELECTRA 10', 'PT. CARSURIN', 'JETTY JTN', 'GARONGKONG', 'PT.INDOCEMENT TUNGGAL PRAKARSA', '2024-11-12', '2024-11-18', 55623575.00, '2024-12-29 01:15:08', '2025-01-12 02:07:43', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-09', 1),
(2, '21 Nov 2024', 'TB. MITRA CATUR 6 / BG. MANDIRI 273', 'PT. CARSURIN', 'JETTY JTN', 'MV. Best Unity', 'PT. RLK ASIA DEVELOPMENT', '2024-11-23', '2024-12-25', 5110048.00, '2024-12-29 01:17:17', '2025-01-12 02:07:53', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-13', 1),
(3, '1', '11', '1', '1', '1', '1', '2025-01-01', '2025-01-06', 1.00, '2025-01-12 01:01:35', '2025-01-12 02:07:58', 'STAFF1234567', 'STAFF1234567', NULL, '2023-12-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_labarugis`
--

CREATE TABLE `category_labarugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namecategory` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_labarugis`
--

INSERT INTO `category_labarugis` (`id`, `namecategory`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `jenis_id`) VALUES
(1, 'Revenue', 'STAFF1234567', NULL, NULL, '2025-01-08 11:06:48', '2025-01-08 11:06:48', 1),
(2, 'Cost of Goods Sold (COGS)', 'STAFF1234567', NULL, NULL, '2025-01-08 11:07:11', '2025-01-08 11:07:11', 1),
(4, 'Shipping', 'STAFF1234567', NULL, NULL, '2025-01-08 11:08:54', '2025-01-08 11:08:54', 1),
(5, 'Royalti', 'STAFF1234567', NULL, NULL, '2025-01-08 11:09:02', '2025-01-08 11:09:02', 1),
(6, 'test', 'STAFF1234567', NULL, NULL, '2025-01-09 03:48:51', '2025-01-09 03:48:51', 2),
(7, 'Revenue', 'STAFF1234567', NULL, NULL, '2025-01-10 03:53:32', '2025-01-10 03:53:32', 1),
(8, 'Mandiri 421', 'STAFF1234567', NULL, NULL, '2025-01-10 10:14:35', '2025-01-10 10:14:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `category_neracas`
--

CREATE TABLE `category_neracas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namecategory` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_neracas`
--

INSERT INTO `category_neracas` (`id`, `namecategory`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `jenis_id`) VALUES
(6, 'CURRENT ASSETS', 'STAFF1234567', NULL, NULL, '2025-01-09 13:19:12', '2025-01-09 13:19:12', 0),
(7, 'FIX ASSETS', 'STAFF1234567', NULL, NULL, '2025-01-10 00:17:04', '2025-01-10 00:17:04', 0),
(8, 'LIABILITIES', 'STAFF1234567', NULL, NULL, '2025-01-10 00:17:17', '2025-01-10 00:17:17', 0),
(9, 'EQUITY', 'STAFF1234567', NULL, NULL, '2025-01-10 00:17:28', '2025-01-10 00:17:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cs_mining_readinesses`
--

CREATE TABLE `cs_mining_readinesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Description` varchar(255) NOT NULL,
  `NomerLegalitas` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `berlaku` varchar(255) DEFAULT NULL,
  `Achievement` varchar(11) DEFAULT NULL,
  `nomor` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `KatgoriDescription` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `filling` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cs_mining_readinesses`
--

INSERT INTO `cs_mining_readinesses` (`id`, `Description`, `NomerLegalitas`, `status`, `tanggal`, `berlaku`, `Achievement`, `nomor`, `created_at`, `updated_at`, `KatgoriDescription`, `created_by`, `updated_by`, `deleted_by`, `filling`) VALUES
(1, '1', '1', '1', '2024-12-17', '1', '1', '2a', '2024-12-29 07:15:15', '2024-12-29 07:15:15', 'Penjualan', 'STAFF1234567', NULL, NULL, NULL),
(2, '1', '1', '1', '2024-12-03', '1', '1', '2a', '2024-12-29 07:15:31', '2024-12-29 07:15:31', 'Penjualan', 'STAFF1234567', NULL, NULL, NULL),
(3, '1', '1', '1', '2024-12-17', '1', '1', '2a', '2024-12-29 07:15:42', '2024-12-29 07:15:42', 'Penjualan', 'STAFF1234567', NULL, NULL, NULL),
(4, '1', '1', '1', '2020-12-12', '1', '1', '2a', '2024-12-29 07:16:11', '2024-12-29 07:16:11', 'Penjualan', 'STAFF1234567', NULL, NULL, NULL),
(5, '1', '1', '1', '2024-12-12', '1', '1', '3a', '2024-12-29 07:17:21', '2024-12-29 07:17:21', 'Penjualan', 'STAFF1234567', NULL, NULL, NULL),
(6, 'SPT Tahunan', '503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015', 'On Progres', '2025-12-12', 'sekarang', '60', '4a', '2024-12-29 07:37:23', '2024-12-29 07:46:58', 'Legalitas', 'STAFF1234567', 'STAFF1234567', NULL, 'office'),
(7, 'SPT Tahunan', '503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015', 'On Progres', '2024-12-12', 'sekarang', '60', '4a', '2024-12-29 07:40:13', '2024-12-29 07:40:13', 'Keuangan', 'STAFF1234567', NULL, NULL, 'officw'),
(8, 'SPT Tahunan', '503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015', 'On Progres', '2024-12-12', 'sekarang', '60', '4a', '2024-12-29 07:41:00', '2024-12-29 07:47:48', 'Legalitas', 'STAFF1234567', 'STAFF1234567', NULL, 'office'),
(9, 'SPT Tahunan', '503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015', 'On Progres', '2024-02-14', 'sekarang', '60', '4a', '2024-12-29 07:41:20', '2024-12-29 07:48:43', 'Lingkungan', 'STAFF1234567', 'STAFF1234567', NULL, 'office');

-- --------------------------------------------------------

--
-- Table structure for table `c_s_mothnly_productions`
--

CREATE TABLE `c_s_mothnly_productions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `dbcm_ob` decimal(15,2) DEFAULT NULL,
  `mbcm_ob` decimal(15,2) DEFAULT NULL,
  `ybcm_ob` decimal(15,2) DEFAULT NULL,
  `dcoal_ton` decimal(15,2) DEFAULT NULL,
  `mcoal_ton` decimal(15,2) DEFAULT NULL,
  `ycoal_ton` decimal(15,2) DEFAULT NULL,
  `dactual` decimal(15,2) DEFAULT NULL,
  `mactual` decimal(15,2) DEFAULT NULL,
  `yactual` decimal(15,2) DEFAULT NULL,
  `dcoal` decimal(15,2) DEFAULT NULL,
  `mcoal` decimal(15,2) DEFAULT NULL,
  `ycoal` decimal(15,2) DEFAULT NULL,
  `bargings` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `c_s_mothnly_productions`
--

INSERT INTO `c_s_mothnly_productions` (`id`, `date`, `dbcm_ob`, `mbcm_ob`, `ybcm_ob`, `dcoal_ton`, `mcoal_ton`, `ycoal_ton`, `dactual`, `mactual`, `yactual`, `dcoal`, `mcoal`, `ycoal`, `bargings`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '2024-11-24', 13229599.00, 13229599.00, NULL, 1319995.00, 1319995.00, NULL, 11043280.00, 11042380.00, NULL, 254440.00, 78396.00, NULL, 12344568.00, '2024-12-29 02:23:15', '2024-12-29 06:23:35', 'STAFF1234567', 'STAFF1234567', NULL),
(2, '2024-11-24', 11300990.00, 11300990.00, NULL, 2217600.00, 2217600.00, NULL, 5222100.00, 5522100.00, NULL, 1009520.00, 1009520.00, NULL, 1067362.00, '2024-12-29 02:24:55', '2024-12-29 02:24:55', 'STAFF1234567', NULL, NULL),
(3, '2024-10-24', NULL, NULL, NULL, NULL, NULL, NULL, 1422000.00, NULL, NULL, NULL, NULL, NULL, 550170.00, '2024-12-29 02:25:41', '2024-12-29 06:21:40', 'STAFF1234567', 'STAFF1234567', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deadline_compensation`
--

CREATE TABLE `deadline_compensation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  `MasaSewa` varchar(255) NOT NULL,
  `Nominalsewa` varchar(255) NOT NULL,
  `ProgresTahun` varchar(255) NOT NULL,
  `JatuhTempo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deadline_compensation`
--

INSERT INTO `deadline_compensation` (`id`, `Keterangan`, `MasaSewa`, `Nominalsewa`, `ProgresTahun`, `JatuhTempo`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Pembayaran Sewa Jalan Hauling', 'pertahun', '5.000/m', 'Telah dibayarkan Juni 2024-Juni 2025', 'Juni 2025', '2024-12-27 07:11:52', '2024-12-29 07:04:20', 'STAFF1234567', 'STAFF1234567', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `deadline_compentsation_cs`
--

CREATE TABLE `deadline_compentsation_cs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Keterangan` varchar(255) NOT NULL,
  `MasaSewa` varchar(255) NOT NULL,
  `Nominalsewa` varchar(255) NOT NULL,
  `ProgresTahun` varchar(255) NOT NULL,
  `JatuhTempo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deadline_compentsation_cs`
--

INSERT INTO `deadline_compentsation_cs` (`id`, `Keterangan`, `MasaSewa`, `Nominalsewa`, `ProgresTahun`, `JatuhTempo`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Pembayaran Sewa Jalan Hauling', 'pertahun', '5.000/m', 'Telah dibayarkan Juni 2024-Juni 2025', 'Juni 2026', '2024-12-29 06:58:55', '2024-12-29 07:03:35', 'STAFF1234567', 'STAFF1234567', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detailabarugis`
--

CREATE TABLE `detailabarugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `nominalactual` decimal(20,2) DEFAULT NULL,
  `nominalplan` decimal(20,2) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `desc` varchar(255) NOT NULL,
  `sub_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detailabarugis`
--

INSERT INTO `detailabarugis` (`id`, `created_by`, `updated_by`, `deleted_by`, `nominalactual`, `nominalplan`, `tanggal`, `desc`, `sub_id`, `created_at`, `updated_at`) VALUES
(1, 'STAFF1234567', NULL, NULL, NULL, 5180540084342.00, '2024-12-12', 'abcd', 1, '2025-01-08 11:44:22', '2025-01-08 11:44:22'),
(2, 'STAFF1234567', NULL, NULL, 5180540084342.00, NULL, '0023-02-12', 'abcd', 3, '2025-01-08 12:15:03', '2025-01-08 12:15:03'),
(3, 'STAFF1234567', NULL, NULL, NULL, 2000.00, '2025-01-16', 'test 1234', 4, '2025-01-09 03:50:31', '2025-01-09 03:50:31'),
(4, 'STAFF1234567', NULL, NULL, NULL, 3000.00, '2025-01-02', 'test12345', 4, '2025-01-09 03:51:44', '2025-01-09 03:51:44'),
(5, 'STAFF1234567', NULL, NULL, NULL, 2000.00, '2025-01-30', 'erwe', 3, '2025-01-10 03:16:30', '2025-01-10 03:16:30'),
(6, 'STAFF1234567', NULL, NULL, NULL, 2000.00, '2025-01-09', 'QQQ', 3, '2025-01-10 03:28:24', '2025-01-10 03:28:24'),
(7, 'STAFF1234567', NULL, NULL, NULL, 2000.00, '2025-01-01', 'QQQ', 8, '2025-01-10 03:54:04', '2025-01-10 03:54:04'),
(8, 'STAFF1234567', NULL, NULL, NULL, 2000.00, '2025-01-07', 'QQQ', 8, '2025-01-10 03:55:12', '2025-01-10 03:55:12'),
(9, 'STAFF1234567', NULL, NULL, 5180540084342.00, NULL, '2025-01-21', 'QQQ', 2, '2025-01-10 04:16:18', '2025-01-10 04:16:18'),
(10, 'STAFF1234567', NULL, NULL, NULL, 2000.00, '2025-01-11', 'QQQ', 4, '2025-01-10 14:24:42', '2025-01-10 14:24:42');

-- --------------------------------------------------------

--
-- Table structure for table `detail_neracas`
--

CREATE TABLE `detail_neracas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(20,2) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `sub_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_neracas`
--

INSERT INTO `detail_neracas` (`id`, `tanggal`, `nominal`, `created_by`, `updated_by`, `deleted_by`, `sub_id`, `created_at`, `updated_at`, `name`) VALUES
(9, '2025-01-10', 84923727.80, 'STAFF1234567', NULL, NULL, 7, '2025-01-09 13:50:57', '2025-01-09 13:50:57', 'Mandiri 721'),
(10, '2025-01-09', 5781299239.00, 'STAFF1234567', NULL, NULL, 7, '2025-01-09 13:52:06', '2025-01-09 13:52:06', 'Mandiri 421'),
(11, '2025-01-22', 2000.00, 'STAFF1234567', NULL, NULL, 9, '2025-01-10 00:18:41', '2025-01-10 00:18:41', 'Account Payable'),
(12, '2025-01-23', 2000.00, 'STAFF1234567', NULL, NULL, 10, '2025-01-10 00:20:55', '2025-01-10 00:20:55', 'Account Payable'),
(13, '2023-12-12', 2000.00, 'STAFF1234567', NULL, NULL, 9, '2025-01-10 00:25:22', '2025-01-10 00:25:22', 'Account Payable');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `gambars`
--

CREATE TABLE `gambars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gambars`
--

INSERT INTO `gambars` (`id`, `path`, `created_at`, `updated_at`) VALUES
(3, 'gambar/lZRwwseX3KMfgskelJwOFFtp1HSe4pSTNZUwL4hF.jpg', '2025-01-11 12:12:42', '2025-01-11 12:12:42');

-- --------------------------------------------------------

--
-- Table structure for table `harga_poko_penjualans`
--

CREATE TABLE `harga_poko_penjualans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(50) NOT NULL,
  `rencana` bigint(20) DEFAULT NULL,
  `subcategory` varchar(255) NOT NULL,
  `realisasi` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `item` varchar(50) DEFAULT NULL,
  `planSub` bigint(20) DEFAULT NULL,
  `realissasiSub` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `harga_poko_penjualans`
--

INSERT INTO `harga_poko_penjualans` (`id`, `category`, `rencana`, `subcategory`, `realisasi`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`, `item`, `planSub`, `realissasiSub`) VALUES
(1, 'Contraktor Cost', 4848646905, 'over burden', NULL, '2025-01-04 07:52:56', '2025-01-04 07:52:56', 'STAFF1234567', NULL, NULL, 'Subcontraktor a', NULL, NULL),
(2, 'Contraktor Cost', 0, 'over burden', NULL, '2025-01-04 07:52:56', '2025-01-04 07:52:56', 'STAFF1234567', NULL, NULL, 'Subcontraktor B', NULL, NULL),
(3, 'Contraktor Cost', 0, 'over burden', NULL, '2025-01-04 07:52:56', '2025-01-04 07:52:56', 'STAFF1234567', NULL, NULL, 'Subcontraktor C', NULL, NULL),
(4, 'Contraktor Cost', 0, 'Coal Getting', NULL, '2025-01-04 08:30:35', '2025-01-04 08:30:35', 'STAFF1234567', NULL, NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hses`
--

CREATE TABLE `hses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nameindikator` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `nilai` varchar(255) NOT NULL,
  `indikator` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `deleted_by` varchar(50) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hses`
--

INSERT INTO `hses` (`id`, `nameindikator`, `target`, `nilai`, `indikator`, `keterangan`, `date`, `created_by`, `updated_by`, `deleted_by`, `kategori_id`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '1', '1', '1', '0024-02-12', 'STAFF1234567', NULL, NULL, 2, '2025-01-07 10:09:38', '2025-01-07 10:09:38'),
(2, '1', '1', '1', '1', '1', '2024-02-12', 'STAFF1234567', NULL, NULL, 3, '2025-01-07 10:09:53', '2025-01-07 10:09:53'),
(3, '4', '1', '1', '1', '1', '2024-03-12', 'STAFF1234567', 'STAFF1234567', NULL, 4, '2025-01-07 10:10:15', '2025-01-07 10:20:03');

-- --------------------------------------------------------

--
-- Table structure for table `infrastructure_readinesses`
--

CREATE TABLE `infrastructure_readinesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ProjectName` varchar(255) NOT NULL,
  `Preparation` varchar(11) DEFAULT NULL,
  `Construction` varchar(11) DEFAULT NULL,
  `Commissiong` varchar(11) DEFAULT NULL,
  `KelayakanBangunan` int(11) NOT NULL,
  `Kelengakapan` int(11) NOT NULL,
  `Kebersihan` int(11) NOT NULL,
  `total` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `note` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `infrastructure_readinesses`
--

INSERT INTO `infrastructure_readinesses` (`id`, `ProjectName`, `Preparation`, `Construction`, `Commissiong`, `KelayakanBangunan`, `Kelengakapan`, `Kebersihan`, `total`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`, `note`) VALUES
(1, 'Kantor', NULL, NULL, '90', 90, 85, 90, '88%', '2024-12-26 08:39:11', '2024-12-28 04:06:37', 'STAFF1234567', 'STAFF1234567', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_labarugis`
--

CREATE TABLE `jenis_labarugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_labarugis`
--

INSERT INTO `jenis_labarugis` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Laba Kotor', NULL, NULL),
(2, 'Laba Operasional', NULL, NULL),
(3, 'Laba Bersih', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_cs_minings`
--

CREATE TABLE `kategori_cs_minings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_cs_minings`
--

INSERT INTO `kategori_cs_minings` (`id`, `kategori`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(2, 'Legalitas', '2024-12-29 07:14:00', '2024-12-29 07:14:00', NULL, NULL, NULL),
(3, 'Penjualan', '2024-12-29 07:14:00', '2024-12-29 07:14:00', NULL, NULL, NULL),
(4, 'Keuangan', '2024-12-29 07:39:45', '2024-12-29 07:39:45', NULL, NULL, NULL),
(5, 'Lingkungan', '2024-12-29 07:40:00', '2024-12-29 07:40:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_hses`
--

CREATE TABLE `kategori_hses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_hses`
--

INSERT INTO `kategori_hses` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(2, 'Leading Indicator', NULL, NULL, NULL, '2025-01-07 09:48:51', '2025-01-07 09:48:51'),
(3, 'Lagging Indicator', NULL, NULL, NULL, '2025-01-07 09:49:04', '2025-01-07 09:49:04'),
(4, 'Umum', NULL, NULL, NULL, '2025-01-07 09:49:11', '2025-01-07 09:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_mini_r_s`
--

CREATE TABLE `kategori_mini_r_s` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_mini_r_s`
--

INSERT INTO `kategori_mini_r_s` (`id`, `kategori`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Keuangan', '2024-12-26 09:34:06', '2024-12-26 09:34:06', NULL, NULL, NULL),
(2, 'Lingkungan', '2024-12-26 09:34:27', '2024-12-26 09:34:27', NULL, NULL, NULL),
(3, 'Legalitas', '2024-12-26 10:28:44', '2024-12-26 10:28:44', NULL, NULL, NULL),
(4, 'Penjualan', '2024-12-26 10:29:03', '2024-12-26 10:29:03', NULL, NULL, NULL),
(7, '2', '2025-01-07 13:52:58', '2025-01-07 13:52:58', NULL, NULL, NULL),
(8, '1', '2025-01-07 13:56:15', '2025-01-07 13:56:15', NULL, NULL, NULL),
(9, 'test', '2025-01-08 01:13:25', '2025-01-08 01:13:25', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_overcoals`
--

CREATE TABLE `kategori_overcoals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_overcoals`
--

INSERT INTO `kategori_overcoals` (`id`, `name`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'Over Burden', 'STAFF1234567', NULL, NULL, '2025-01-08 06:46:29', '2025-01-08 06:46:29'),
(2, 'Coal Getting', 'STAFF1234567', NULL, NULL, '2025-01-08 06:48:22', '2025-01-08 06:48:22');

-- --------------------------------------------------------

--
-- Table structure for table `kategory_neracas`
--

CREATE TABLE `kategory_neracas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_01_02_093828_create_sessions_table', 1),
(7, '2024_01_02_154551_add_role_to_users_table', 1),
(8, '2024_12_17_190823_create_people_readinesses_table', 1),
(9, '2024_12_17_192114_create_infrastructure_readinesses_table', 1),
(10, '2024_12_17_192605_create_mining_readinesses_table', 1),
(11, '2024_12_17_193021_create_pembebasan_lahans_table', 1),
(12, '2024_12_17_193316_create_deadline_compensation_table', 1),
(13, '2024_12_17_200817_create_laba_rugis_table', 1),
(14, '2024_12_17_221259_add__h_s_eactual__to_people_readinesses_table', 1),
(15, '2024_12_17_221646_add__fullfillment_actual__to_people_readinesses_table', 1),
(16, '2024_12_18_131911_create_kategori_laba_rugis_table', 1),
(17, '2024_12_18_133354_add_year_laba_rugis_table', 1),
(18, '2024_12_18_154838_create_kategori_mini_r_s_table', 1),
(19, '2024_12_18_155101_add_nomor_mining_readinesses_table', 1),
(20, '2024_12_18_163723_add__kategori_description_mining_readinesses_table', 1),
(21, '2024_12_18_211146_create_bargings_table', 1),
(22, '2024_12_19_144715_create_cs_mining_readinesses_table', 1),
(23, '2024_12_19_145048_add__kategori_description_cs_mining_readinesses_table', 1),
(24, '2024_12_19_151212_create_kategori_cs_minings_table', 1),
(25, '2024_12_19_152825_create_deadline_compentsation_cs_table', 1),
(26, '2024_12_21_122844_create_kategory_neracas_table', 1),
(27, '2024_12_21_161846_create_harga_poko_penjualans_table', 1),
(28, '2024_12_21_184200_add_parent_id_to_kategory_neracas', 1),
(29, '2024_12_21_190856_neracas', 1),
(30, '2024_12_21_224416_create_units_table', 1),
(31, '2024_12_21_224435_create_produksis_table', 1),
(32, '2024_12_22_095602_create_c_s_mothnly_productions_table', 1),
(33, '2024_12_22_123711_add_parent_t_hm_produksis_table', 1),
(34, '2024_12_22_151416_create_perusahaans_table', 1),
(35, '2024_12_22_154839_add_induk_perusahaans_table', 1),
(36, '2024_12_25_151333_add_audit_columns_to_people_readiness_table', 2),
(37, '2024_12_25_194900_add_audit_columns_to_bargings_table', 3),
(38, '2024_12_25_195534_add_audit_columns_to_cs_mining_readinesses_table', 4),
(39, '2024_12_25_195812_add_audit_columns_to_deadline_compensation_table', 4),
(40, '2024_12_25_200023_add_audit_columns_to_harga_poko_penjualans_table', 5),
(41, '2024_12_25_200047_add_audit_columns_to_infrastructure_readinesses_table', 5),
(42, '2024_12_25_200118_add_audit_columns_to_kategori_cs_minings_table', 5),
(43, '2024_12_25_200144_add_audit_columns_to_kategori_laba_rugistable', 5),
(44, '2024_12_25_200214_add_audit_columns_to_kategori_mini_r_s', 5),
(45, '2024_12_25_200242_add_audit_columns_to_kategory_neracas_table', 5),
(46, '2024_12_25_200309_add_audit_columns_to_neracas_table', 5),
(47, '2024_12_25_200336_add_audit_columns_to_produksis_table', 5),
(48, '2024_12_25_200418_add_audit_columns_to_perusahaans_table', 5),
(49, '2024_12_25_200440_add_audit_columns_to_units_table', 5),
(50, '2024_12_29_155337_create_pembebasan_lahan_cs_table', 6),
(51, '2024_12_30_044741_add_updated_at_to_kategori_laba_rugis', 7),
(52, '2025_01_06_163709_create_pica_people_table', 8),
(53, '2025_01_06_174506_create_picainfrastrukturs_table', 9),
(54, '2025_01_06_181035_create_picai_dealines_table', 10),
(55, '2025_01_07_095540_create_pica_hses_table', 11),
(56, '2025_01_07_095557_create_pica_minings_table', 11),
(57, '2025_01_07_095634_create_pica_pa_uas_table', 11),
(58, '2025_01_07_095704_create_pica_over_coal_table', 11),
(59, '2025_01_07_165634_create_kategori_hses_table', 12),
(60, '2025_01_07_165651_create_hses_table', 12),
(61, '2025_01_07_183149_create_pica_bargings_table', 13),
(62, '2025_01_08_115502_create_pica_pls_table', 14),
(63, '2025_01_08_124001_create_kategori_overcoals_table', 15),
(64, '2025_01_08_181027_create_category_labarugis_table', 16),
(65, '2025_01_08_181204_create_sub_labarugis_table', 16),
(66, '2025_01_08_181445_create_detailabarugis_table', 16),
(67, '2025_01_08_181717_create_picalaba_rugis_table', 16),
(68, '2025_01_08_204704_create_stock_jts_table', 17),
(69, '2025_01_08_204731_create_picastockjts_table', 17),
(70, '2025_01_09_172053_create_category_neracas_table', 18),
(71, '2025_01_09_172125_create_sub_neracas_table', 18),
(72, '2025_01_09_172142_create_detail_neracas_table', 18),
(73, '2025_01_10_175809_create_jenis_labarugis_table', 19),
(74, '2025_01_10_175833_add_audit_columns_to_category_neracas_table', 20),
(75, '2025_01_10_180815_add_audit_columns_to_category_labarugis_table', 21),
(76, '2025_01_11_192156_create_gambars_table', 21),
(77, '2025_01_12_085303_add_audit_columns_to__bargings_table', 22),
(78, '2025_01_12_094434_create_plan_bargings_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `mining_readinesses`
--

CREATE TABLE `mining_readinesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Description` varchar(255) NOT NULL,
  `NomerLegalitas` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `berlaku` varchar(255) DEFAULT NULL,
  `Achievement` varchar(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nomor` varchar(255) NOT NULL,
  `KatgoriDescription` varchar(255) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `filling` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mining_readinesses`
--

INSERT INTO `mining_readinesses` (`id`, `Description`, `NomerLegalitas`, `status`, `tanggal`, `berlaku`, `Achievement`, `created_at`, `updated_at`, `nomor`, `KatgoriDescription`, `created_by`, `updated_by`, `deleted_by`, `filling`) VALUES
(2, 'IUP', '503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015', 'Operasional', '2015-10-02', 'sekarang', '100', '2024-12-26 10:16:59', '2024-12-28 04:54:03', '1a', 'Lingkungan', 'STAFF1234567', 'STAFF1234567', NULL, 'office'),
(3, 'SPT Tahunan', NULL, NULL, NULL, NULL, '70%', '2024-12-26 11:42:42', '2024-12-28 04:56:45', '4a', 'Keuangan', 'STAFF1234567', 'STAFF1234567', NULL, NULL),
(4, 'q', NULL, 'qq', NULL, 'q', '10%', '2024-12-26 11:46:47', '2024-12-26 11:46:47', 'q', 'Keuangan', 'STAFF1234567', NULL, NULL, 'qq'),
(5, '1', '1', 'On Progres', '2024-12-12', '1', '40', '2025-01-07 13:16:06', '2025-01-07 13:16:06', '4a', 'Penjualan', 'STAFF1234567', NULL, NULL, 'office'),
(6, '1', '1', 'On Progres', NULL, '1', '40', '2025-01-07 13:16:20', '2025-01-07 13:16:20', '4a', 'Penjualan', 'STAFF1234567', NULL, NULL, 'office'),
(7, '1', '1', 'On Progres', NULL, '1', '40', '2025-01-07 13:53:06', '2025-01-07 13:53:06', '4a', '2', 'STAFF1234567', NULL, NULL, 'office'),
(8, '1', '1', 'On Progres', NULL, '1', '90', '2025-01-07 13:53:35', '2025-01-07 13:53:35', '4a', '2', 'STAFF1234567', NULL, NULL, 'office'),
(9, '1', '1', 'On Progres', NULL, '1', '90', '2025-01-07 13:54:45', '2025-01-07 13:54:45', '4a', '2', 'STAFF1234567', NULL, NULL, 'office'),
(10, '1', '1', 'On Progres', NULL, '1', '90', '2025-01-07 13:55:05', '2025-01-07 13:55:05', '4a', '2', 'STAFF1234567', NULL, NULL, 'office'),
(11, '1', '1', 'On Progres', NULL, '1', '100', '2025-01-08 01:13:38', '2025-01-08 01:13:38', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office'),
(12, '1', '1', 'On Progres', NULL, '1', '60%', '2025-01-08 01:14:19', '2025-01-08 01:14:19', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office'),
(13, '1', '1', 'On Progres', NULL, '1', '60%', '2025-01-08 01:15:06', '2025-01-08 01:15:06', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office'),
(14, '1', '1', 'On Progres', NULL, '1', '60%', '2025-01-08 01:15:23', '2025-01-08 01:15:23', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office'),
(15, '1', '1', 'On Progres', NULL, '1', '60%', '2025-01-08 01:15:30', '2025-01-08 01:15:30', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office'),
(16, '1', '1', 'On Progres', NULL, '1', '60%', '2025-01-08 01:15:36', '2025-01-08 01:15:36', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office'),
(17, '1', '1', 'On Progres', NULL, '1', '60%', '2025-01-08 01:15:43', '2025-01-08 01:15:43', '4a', 'test', 'STAFF1234567', NULL, NULL, 'office');

-- --------------------------------------------------------

--
-- Table structure for table `neracas`
--

CREATE TABLE `neracas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `overberden_coal`
--

CREATE TABLE `overberden_coal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nominalactual` decimal(15,2) DEFAULT NULL,
  `nominalplan` decimal(15,2) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `desc` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `overberden_coal`
--

INSERT INTO `overberden_coal` (`id`, `kategori_id`, `nominalactual`, `nominalplan`, `tanggal`, `desc`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 1, 51805400843.00, NULL, '2025-02-12', 'PLAN FR coal', 'STAFF1234567', NULL, NULL, '2025-01-08 08:09:58', '2025-01-08 08:09:58'),
(2, 1, 2555000000.00, NULL, '2024-02-20', 'actual FR coal', 'STAFF1234567', NULL, NULL, '2025-01-08 08:16:48', '2025-01-08 08:16:48'),
(3, 1, 2000.00, NULL, '2025-01-09', 'kpopkk', 'STAFF1234567', NULL, NULL, '2025-01-09 04:31:23', '2025-01-09 04:31:23'),
(4, 2, NULL, 2000.00, '2025-01-23', '786860', 'STAFF1234567', NULL, NULL, '2025-01-09 04:38:49', '2025-01-09 04:38:49'),
(5, 2, 2111.00, NULL, '2025-01-10', 'assx', 'STAFF1234567', NULL, NULL, '2025-01-09 04:39:29', '2025-01-09 04:39:29'),
(6, 2, 222.00, NULL, '2025-01-11', 'wd', 'STAFF1234567', NULL, NULL, '2025-01-09 04:40:32', '2025-01-09 04:40:32'),
(7, 2, NULL, 2000.00, '2025-02-01', 'a', 'STAFF1234567', NULL, NULL, '2025-01-09 04:43:59', '2025-01-09 04:43:59');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembebasan_lahans`
--

CREATE TABLE `pembebasan_lahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `NamaPemilik` varchar(255) NOT NULL,
  `LuasLahan` double NOT NULL,
  `KebutuhanLahan` varchar(255) NOT NULL,
  `Progress` varchar(255) NOT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Achievement` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  `targetselesai` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembebasan_lahans`
--

INSERT INTO `pembebasan_lahans` (`id`, `NamaPemilik`, `LuasLahan`, `KebutuhanLahan`, `Progress`, `Status`, `Achievement`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`, `targetselesai`) VALUES
(3, 'pardi', 4.368, '0.89', 'On progress', NULL, '60%', '2024-12-26 09:32:04', '2024-12-28 05:53:22', 'STAFF1234567', 'STAFF1234567', NULL, NULL),
(4, 'pardi', 4.36, '0.89', 'On progress', '1', '90', '2025-01-08 03:41:09', '2025-01-08 03:41:09', 'STAFF1234567', NULL, NULL, 'besok'),
(5, 'pardi', 4.36, '0.89', 'On progress', '1', '90%', '2025-01-08 03:45:50', '2025-01-08 03:45:50', 'STAFF1234567', NULL, NULL, 'besok'),
(6, 'pardi', 4.36, '0.89', 'On progress', '1', '60%', '2025-01-08 03:46:00', '2025-01-08 03:46:00', 'STAFF1234567', NULL, NULL, 'besok');

-- --------------------------------------------------------

--
-- Table structure for table `pembebasan_lahan_cs`
--

CREATE TABLE `pembebasan_lahan_cs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `NamaPemilik` varchar(255) NOT NULL,
  `LuasLahan` double NOT NULL,
  `KebutuhanLahan` varchar(255) NOT NULL,
  `Progress` varchar(255) NOT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Achievement` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembebasan_lahan_cs`
--

INSERT INTO `pembebasan_lahan_cs` (`id`, `NamaPemilik`, `LuasLahan`, `KebutuhanLahan`, `Progress`, `Status`, `Achievement`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'pardi', 4.36, '0.89', 'On progress', '1', '60%', 'STAFF1234567', NULL, NULL, '2024-12-29 08:08:35', '2024-12-29 08:08:35');

-- --------------------------------------------------------

--
-- Table structure for table `people_readinesses`
--

CREATE TABLE `people_readinesses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `Fullfillment_plan` int(11) NOT NULL,
  `pou_pou_plan` int(11) NOT NULL,
  `HSE_plan` int(11) NOT NULL,
  `Leadership_plan` int(11) NOT NULL,
  `Improvement_plan` int(11) NOT NULL,
  `Quality_plan` varchar(255) NOT NULL,
  `Quantity_plan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pou_pou_actual` int(11) NOT NULL,
  `HSE_actual` int(11) NOT NULL,
  `Leadership_actual` int(11) NOT NULL,
  `Improvement_actual` int(11) NOT NULL,
  `Fullfillment_actual` int(11) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `note` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `people_readinesses`
--

INSERT INTO `people_readinesses` (`id`, `posisi`, `Fullfillment_plan`, `pou_pou_plan`, `HSE_plan`, `Leadership_plan`, `Improvement_plan`, `Quality_plan`, `Quantity_plan`, `created_at`, `updated_at`, `pou_pou_actual`, `HSE_actual`, `Leadership_actual`, `Improvement_actual`, `Fullfillment_actual`, `created_by`, `updated_by`, `deleted_by`, `note`) VALUES
(2, 'Direktur / KTT', 1, 2, 1, 1, 1, '88%', '100%', '2024-12-25 07:22:01', '2024-12-26 06:56:40', 1, 1, 1, 1, 1, 'STAFF1234567', 'STAFF1234567', NULL, NULL),
(3, 'Manager / Division Head', 4, 4, 4, 4, 4, '50%', '50%', '2024-12-25 09:18:08', '2024-12-25 09:18:08', 2, 2, 2, 2, 2, 'STAFF1234567', NULL, NULL, NULL),
(4, 'supervaisor', 6, 6, 6, 6, 6, '54%', '83%', '2024-12-25 10:46:53', '2024-12-25 10:46:53', 2, 1, 5, 5, 5, 'STAFF1234567', NULL, NULL, NULL),
(5, 'Staff HO', 4, 1, 1, 4, 4, '44%', '100%', '2024-12-25 10:48:11', '2024-12-25 10:48:11', 0, 0, 3, 4, 4, 'STAFF1234567', NULL, NULL, NULL),
(6, 'Staff Site', 12, 1, 1, 1, 6, '75%', '83%', '2024-12-25 10:48:55', '2024-12-25 10:48:55', 0, 1, 1, 6, 10, 'STAFF1234567', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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

-- --------------------------------------------------------

--
-- Table structure for table `perusahaans`
--

CREATE TABLE `perusahaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `induk` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `perusahaans`
--

INSERT INTO `perusahaans` (`id`, `nama`, `created_at`, `updated_at`, `induk`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Pt. A', '2025-01-05 07:45:26', '2025-01-05 07:45:26', 'IUP', NULL, NULL, NULL),
(2, 'Pt. A', '2025-01-05 07:45:33', '2025-01-05 07:45:33', 'Kontraktor', NULL, NULL, NULL),
(3, 'Pt. A', '2025-01-05 07:45:39', '2025-01-05 07:45:39', 'Non Energi', NULL, NULL, NULL),
(4, 'Kontraktor A', '2025-01-05 08:57:50', '2025-01-05 08:57:50', 'Kontraktor', NULL, NULL, NULL),
(5, 'Kontraktor B', '2025-01-05 08:58:28', '2025-01-05 08:58:28', 'Kontraktor', NULL, NULL, NULL),
(6, 'IUP A', '2025-01-05 08:58:40', '2025-01-05 08:58:40', 'IUP', NULL, NULL, NULL),
(7, 'IUP B', '2025-01-05 08:58:46', '2025-01-05 08:58:46', 'IUP', NULL, NULL, NULL),
(8, 'Non Energi A', '2025-01-05 08:58:55', '2025-01-05 08:58:55', 'Non Energi', NULL, NULL, NULL),
(9, 'Non Energi C', '2025-01-05 08:59:01', '2025-01-05 08:59:01', 'Non Energi', NULL, NULL, NULL),
(10, 'Kontraktor C', '2025-01-05 08:59:22', '2025-01-05 08:59:22', 'Kontraktor', NULL, NULL, NULL),
(11, 'Mineral A', '2025-01-05 09:02:48', '2025-01-05 09:02:48', 'Mineral', NULL, NULL, NULL),
(12, 'Mineral B', '2025-01-05 09:02:54', '2025-01-05 09:02:54', 'Mineral', NULL, NULL, NULL),
(13, 'Mineral C', '2025-01-05 09:03:01', '2025-01-05 09:03:01', 'Mineral', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `picainfrastrukturs`
--

CREATE TABLE `picainfrastrukturs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(200) NOT NULL,
  `corectiveaction` varchar(255) DEFAULT NULL,
  `duedate` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `remerks` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `picainfrastrukturs`
--

INSERT INTO `picainfrastrukturs` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'rgds', '11', '1', '1', '2', '11', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-06 10:00:59', '2025-01-06 10:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `picai_dealines`
--

CREATE TABLE `picai_dealines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `picai_dealines`
--

INSERT INTO `picai_dealines` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'e', '1', '2', '22', '1', '2', '2', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-06 10:24:50', '2025-01-06 10:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `picalaba_rugis`
--

CREATE TABLE `picalaba_rugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `picalaba_rugis`
--

INSERT INTO `picalaba_rugis` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'r', '6777', 't', 'y', 'u', 'o', 'i', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-08 12:27:56', '2025-01-08 12:28:08');

-- --------------------------------------------------------

--
-- Table structure for table `picastockjts`
--

CREATE TABLE `picastockjts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `picastockjts`
--

INSERT INTO `picastockjts` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 'iiopioi', '1', 'g', 'gg', 'gg', 'gg', 'g', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-08 14:43:44', '2025-01-08 14:43:53');

-- --------------------------------------------------------

--
-- Table structure for table `pica_bargings`
--

CREATE TABLE `pica_bargings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_bargings`
--

INSERT INTO `pica_bargings` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '1', '5', '1', '1', '1', '1', '1', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-07 10:40:44', '2025-01-07 10:43:17'),
(2, '2', '1', '2', '1', '11', 'gg', '2', 'STAFF1234567', NULL, NULL, '2025-01-09 04:45:31', '2025-01-09 04:45:31');

-- --------------------------------------------------------

--
-- Table structure for table `pica_hses`
--

CREATE TABLE `pica_hses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_hses`
--

INSERT INTO `pica_hses` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '2', '7a', '6', '22', '22', '2', '2', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-07 10:28:24', '2025-01-08 04:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `pica_minings`
--

CREATE TABLE `pica_minings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_minings`
--

INSERT INTO `pica_minings` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '2', '5', '4', '22', '2', '2', '22', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-07 02:37:27', '2025-01-07 02:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `pica_over_coal`
--

CREATE TABLE `pica_over_coal` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_over_coal`
--

INSERT INTO `pica_over_coal` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '1', '09', '11', '11', '1', '1', '1', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-08 09:33:59', '2025-01-08 09:34:13');

-- --------------------------------------------------------

--
-- Table structure for table `pica_pa_uas`
--

CREATE TABLE `pica_pa_uas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_pa_uas`
--

INSERT INTO `pica_pa_uas` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '1', '5', '1', '1', '11', '1', '1', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-07 02:28:03', '2025-01-07 02:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `pica_people`
--

CREATE TABLE `pica_people` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` bigint(20) NOT NULL,
  `corectiveaction` varchar(255) DEFAULT NULL,
  `duedate` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `remerks` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_people`
--

INSERT INTO `pica_people` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, '1', '1', '1', '1', '1', 'STAFF1234567', NULL, NULL, '2025-01-06 09:24:41', '2025-01-06 09:24:41'),
(2, '1', 2, '1', '1', '2', '1', '1', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-06 09:35:27', '2025-01-06 09:36:38'),
(3, '1', 1, '11', '1', '1', '2', '11', 'STAFF1234567', NULL, NULL, '2025-01-06 09:59:23', '2025-01-06 09:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `pica_pls`
--

CREATE TABLE `pica_pls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cause` varchar(255) NOT NULL,
  `problem` varchar(255) NOT NULL,
  `corectiveaction` varchar(255) NOT NULL,
  `duedate` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `remerks` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pica_pls`
--

INSERT INTO `pica_pls` (`id`, `cause`, `problem`, `corectiveaction`, `duedate`, `pic`, `remerks`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, '2a', '1', '2', '22', '22', '2', '2', 'STAFF1234567', 'STAFF1234567', NULL, '2025-01-08 04:07:18', '2025-01-08 04:17:44');

-- --------------------------------------------------------

--
-- Table structure for table `plan_bargings`
--

CREATE TABLE `plan_bargings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nominal` decimal(20,2) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plan_bargings`
--

INSERT INTO `plan_bargings` (`id`, `nominal`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`) VALUES
(1, 300000.00, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produksis`
--

CREATE TABLE `produksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ob_bcm` decimal(10,2) DEFAULT NULL,
  `ob_wh` decimal(10,2) DEFAULT NULL,
  `ob_pty` decimal(10,2) DEFAULT NULL,
  `ob_distance` decimal(10,2) DEFAULT NULL,
  `coal_mt` decimal(10,2) DEFAULT NULL,
  `coal_wh` decimal(10,2) DEFAULT NULL,
  `coal_pty` decimal(10,2) DEFAULT NULL,
  `coal_distance` decimal(10,2) DEFAULT NULL,
  `general_hours` decimal(10,2) DEFAULT NULL,
  `stby_hours` decimal(10,2) DEFAULT NULL,
  `bd_hours` decimal(10,2) DEFAULT NULL,
  `rental_hours` decimal(10,2) DEFAULT NULL,
  `pa` decimal(10,2) DEFAULT NULL,
  `mohh` decimal(10,2) DEFAULT NULL,
  `ua` decimal(10,2) DEFAULT NULL,
  `ltr_total` decimal(10,2) DEFAULT NULL,
  `ltr_wh` decimal(10,2) DEFAULT NULL,
  `ltr` decimal(10,2) DEFAULT NULL,
  `ltr_coal` decimal(10,2) DEFAULT NULL,
  `l_hm` decimal(10,2) DEFAULT NULL,
  `l_bcm` decimal(10,2) DEFAULT NULL,
  `l_mt` decimal(10,2) DEFAULT NULL,
  `tot_pa` varchar(255) DEFAULT NULL,
  `tot_ua` varchar(255) DEFAULT NULL,
  `tot_ma` varchar(255) DEFAULT NULL,
  `eu` varchar(255) DEFAULT NULL,
  `pa_plan` varchar(255) DEFAULT NULL,
  `ua_plan` varchar(255) DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `t_hm` decimal(10,2) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produksis`
--

INSERT INTO `produksis` (`id`, `ob_bcm`, `ob_wh`, `ob_pty`, `ob_distance`, `coal_mt`, `coal_wh`, `coal_pty`, `coal_distance`, `general_hours`, `stby_hours`, `bd_hours`, `rental_hours`, `pa`, `mohh`, `ua`, `ltr_total`, `ltr_wh`, `ltr`, `ltr_coal`, `l_hm`, `l_bcm`, `l_mt`, `tot_pa`, `tot_ua`, `tot_ma`, `eu`, `pa_plan`, `ua_plan`, `unit_id`, `created_at`, `updated_at`, `t_hm`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 1111.00, 1.00, 1.00, 1.00, 11.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 11.00, 20.00, 1.00, NULL, 1.00, '11', '1', '11', '1', '1', '19999', 2, '2024-12-28 06:38:07', '2024-12-28 07:35:53', 1.00, 'STAFF1234567', 'STAFF1234567', NULL),
(2, 2.00, 2.00, 2.00, 2.00, 22.00, 2.00, 2.00, 22.00, 2.00, 2.00, 2.00, 22.00, 2.00, 22.00, 22.00, 22.00, 22.00, 2.00, 2.00, 2.00, 22.00, 22.00, '2', '2', '2', '2', '2', '2', 2, '2024-12-28 07:02:42', '2024-12-28 07:02:42', 22.00, 'STAFF1234567', NULL, NULL),
(3, 3.00, 3.00, 33.00, 3.00, 3.00, 3.00, 3.00, 3.00, 33.00, 33.00, 3.00, 3.00, 33.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 3.00, 33.00, '3', '3', '3', '3', '3', '3', 3, '2024-12-28 07:12:35', '2024-12-28 07:12:35', 3.00, 'STAFF1234567', NULL, NULL),
(4, 1111.00, 1.00, 1.00, 1.00, 11.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 1.00, 11.00, 20.00, 1.00, NULL, 1.00, '123234234', '1', '11', '18888', '1', '1', 3, '2024-12-28 07:30:08', '2024-12-28 07:36:14', 1.00, 'STAFF1234567', 'STAFF1234567', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Quw8P50iz1Yi2nsYM4TmJue4B0DFFN4oNzpMUVid', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWJzZjN1bHlrenJBMnBZUXdlcWlDeWJXTnpzMjNQZ01QZ0l1cnBxayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmRleGJhcmdpbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1736679244);

-- --------------------------------------------------------

--
-- Table structure for table `stock_jts`
--

CREATE TABLE `stock_jts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `date` varchar(255) NOT NULL,
  `sotckawal` varchar(255) DEFAULT NULL,
  `shifpertama` varchar(255) DEFAULT NULL,
  `shifkedua` varchar(255) DEFAULT NULL,
  `totalhauling` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_jts`
--

INSERT INTO `stock_jts` (`id`, `created_by`, `updated_by`, `deleted_by`, `date`, `sotckawal`, `shifpertama`, `shifkedua`, `totalhauling`, `created_at`, `updated_at`) VALUES
(6, 'STAFF1234567', NULL, NULL, '2023-12-12', '129022', '1', '1', '2', '2025-01-09 14:34:23', '2025-01-09 14:34:23'),
(7, 'STAFF1234567', NULL, NULL, '2023-02-12', NULL, '2', '-4', '-2', '2025-01-09 14:34:52', '2025-01-09 14:34:52'),
(8, 'STAFF1234567', NULL, NULL, '3333-03-12', '123', '1', '1', '2', '2025-01-09 14:36:22', '2025-01-09 14:36:22');

-- --------------------------------------------------------

--
-- Table structure for table `subkategori_labarugis`
--

CREATE TABLE `subkategori_labarugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `sub` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sub_labarugis`
--

CREATE TABLE `sub_labarugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namesub` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_labarugis`
--

INSERT INTO `sub_labarugis` (`id`, `namesub`, `created_by`, `updated_by`, `deleted_by`, `kategori_id`, `created_at`, `updated_at`) VALUES
(1, 'Penjualan Batu Bara', 'STAFF1234567', NULL, NULL, 1, '2025-01-08 11:11:28', '2025-01-08 11:11:28'),
(2, 'Penjualan Batu Bara', 'STAFF1234567', NULL, NULL, 1, '2025-01-08 11:35:27', '2025-01-08 11:35:27'),
(3, 'Over Burden', 'STAFF1234567', NULL, NULL, 2, '2025-01-08 12:14:20', '2025-01-08 12:14:20'),
(4, 'test 1', 'STAFF1234567', NULL, NULL, 6, '2025-01-09 03:49:23', '2025-01-09 03:49:23'),
(5, 'Mandiri 421', 'STAFF1234567', NULL, NULL, 1, '2025-01-09 11:27:20', '2025-01-09 11:27:20'),
(6, 'Mandiri 421', 'STAFF1234567', NULL, NULL, 1, '2025-01-09 11:29:42', '2025-01-09 11:29:42'),
(7, 'Mandiri 421', 'STAFF1234567', NULL, NULL, 1, '2025-01-09 11:32:24', '2025-01-09 11:32:24'),
(8, '4567', 'STAFF1234567', NULL, NULL, 1, '2025-01-10 03:53:45', '2025-01-10 03:53:45');

-- --------------------------------------------------------

--
-- Table structure for table `sub_neracas`
--

CREATE TABLE `sub_neracas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `namesub` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_jenis` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_neracas`
--

INSERT INTO `sub_neracas` (`id`, `namesub`, `created_by`, `updated_by`, `deleted_by`, `kategori_id`, `created_at`, `updated_at`, `id_jenis`) VALUES
(7, 'Cash & Cash Equivalents', 'STAFF1234567', NULL, NULL, 6, '2025-01-09 13:19:26', '2025-01-09 13:19:26', 0),
(8, 'Land', 'STAFF1234567', NULL, NULL, 7, '2025-01-10 00:17:57', '2025-01-10 00:17:57', 0),
(9, '123', 'STAFF1234567', NULL, NULL, 9, '2025-01-10 00:18:04', '2025-01-10 00:18:04', 0),
(10, '4567', 'STAFF1234567', NULL, NULL, 8, '2025-01-10 00:18:14', '2025-01-10 00:18:14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code_number` varchar(20) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `code_number`, `unit`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'DTXC116', 'UNIT HAULER', '2024-12-28 06:06:14', '2024-12-28 06:06:14', 'STAFF1234567', NULL, NULL),
(2, 'ZE21085', 'UNIT LOADER', '2024-12-28 06:10:49', '2024-12-28 06:10:49', 'STAFF1234567', NULL, NULL),
(3, 'ZD22148', 'UNIT SUPORT', '2024-12-28 06:12:39', '2024-12-28 06:12:39', 'STAFF1234567', NULL, NULL),
(4, 'ZE37223', 'UNIT HAULER', '2024-12-28 06:48:51', '2024-12-28 06:48:51', 'STAFF1234567', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('staff','direksi','pimpinan') NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `role`, `username`) VALUES
(1, 'anak perusahaan b', '$2y$12$VbA3aCqGMIlfjsPiNkiZ9.8JBpIBG34kSsIZJ3L8rlCvpHSSxL4Me', NULL, NULL, NULL, NULL, '2024-12-25 06:48:32', '2024-12-25 06:48:32', 'staff', 'STAFF1234567');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bargings`
--
ALTER TABLE `bargings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_labarugis`
--
ALTER TABLE `category_labarugis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_neracas`
--
ALTER TABLE `category_neracas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cs_mining_readinesses`
--
ALTER TABLE `cs_mining_readinesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `c_s_mothnly_productions`
--
ALTER TABLE `c_s_mothnly_productions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deadline_compensation`
--
ALTER TABLE `deadline_compensation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deadline_compentsation_cs`
--
ALTER TABLE `deadline_compentsation_cs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detailabarugis`
--
ALTER TABLE `detailabarugis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detailabarugis_sub_id_foreign` (`sub_id`);

--
-- Indexes for table `detail_neracas`
--
ALTER TABLE `detail_neracas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_neracas_sub_id_foreign` (`sub_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gambars`
--
ALTER TABLE `gambars`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_poko_penjualans`
--
ALTER TABLE `harga_poko_penjualans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hses`
--
ALTER TABLE `hses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hses_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `infrastructure_readinesses`
--
ALTER TABLE `infrastructure_readinesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_labarugis`
--
ALTER TABLE `jenis_labarugis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_cs_minings`
--
ALTER TABLE `kategori_cs_minings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_hses`
--
ALTER TABLE `kategori_hses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_mini_r_s`
--
ALTER TABLE `kategori_mini_r_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_overcoals`
--
ALTER TABLE `kategori_overcoals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategory_neracas`
--
ALTER TABLE `kategory_neracas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mining_readinesses`
--
ALTER TABLE `mining_readinesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `neracas`
--
ALTER TABLE `neracas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `neracas_category_id_foreign` (`category_id`);

--
-- Indexes for table `overberden_coal`
--
ALTER TABLE `overberden_coal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembebasan_lahans`
--
ALTER TABLE `pembebasan_lahans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembebasan_lahan_cs`
--
ALTER TABLE `pembebasan_lahan_cs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people_readinesses`
--
ALTER TABLE `people_readinesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `perusahaans`
--
ALTER TABLE `perusahaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picainfrastrukturs`
--
ALTER TABLE `picainfrastrukturs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picai_dealines`
--
ALTER TABLE `picai_dealines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picalaba_rugis`
--
ALTER TABLE `picalaba_rugis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `picastockjts`
--
ALTER TABLE `picastockjts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_bargings`
--
ALTER TABLE `pica_bargings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_hses`
--
ALTER TABLE `pica_hses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_minings`
--
ALTER TABLE `pica_minings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_over_coal`
--
ALTER TABLE `pica_over_coal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_pa_uas`
--
ALTER TABLE `pica_pa_uas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_people`
--
ALTER TABLE `pica_people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pica_pls`
--
ALTER TABLE `pica_pls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_bargings`
--
ALTER TABLE `plan_bargings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produksis`
--
ALTER TABLE `produksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produksis_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_jts`
--
ALTER TABLE `stock_jts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subkategori_labarugis`
--
ALTER TABLE `subkategori_labarugis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_labarugis`
--
ALTER TABLE `sub_labarugis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_labarugis_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `sub_neracas`
--
ALTER TABLE `sub_neracas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sub_neracas_kategori_id_foreign` (`kategori_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bargings`
--
ALTER TABLE `bargings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `category_labarugis`
--
ALTER TABLE `category_labarugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category_neracas`
--
ALTER TABLE `category_neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cs_mining_readinesses`
--
ALTER TABLE `cs_mining_readinesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `c_s_mothnly_productions`
--
ALTER TABLE `c_s_mothnly_productions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `deadline_compensation`
--
ALTER TABLE `deadline_compensation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `deadline_compentsation_cs`
--
ALTER TABLE `deadline_compentsation_cs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detailabarugis`
--
ALTER TABLE `detailabarugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `detail_neracas`
--
ALTER TABLE `detail_neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambars`
--
ALTER TABLE `gambars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `harga_poko_penjualans`
--
ALTER TABLE `harga_poko_penjualans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `hses`
--
ALTER TABLE `hses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `infrastructure_readinesses`
--
ALTER TABLE `infrastructure_readinesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_labarugis`
--
ALTER TABLE `jenis_labarugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori_cs_minings`
--
ALTER TABLE `kategori_cs_minings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori_hses`
--
ALTER TABLE `kategori_hses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kategori_mini_r_s`
--
ALTER TABLE `kategori_mini_r_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kategori_overcoals`
--
ALTER TABLE `kategori_overcoals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategory_neracas`
--
ALTER TABLE `kategory_neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `mining_readinesses`
--
ALTER TABLE `mining_readinesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `neracas`
--
ALTER TABLE `neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `overberden_coal`
--
ALTER TABLE `overberden_coal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembebasan_lahans`
--
ALTER TABLE `pembebasan_lahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pembebasan_lahan_cs`
--
ALTER TABLE `pembebasan_lahan_cs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `people_readinesses`
--
ALTER TABLE `people_readinesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perusahaans`
--
ALTER TABLE `perusahaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `picainfrastrukturs`
--
ALTER TABLE `picainfrastrukturs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `picai_dealines`
--
ALTER TABLE `picai_dealines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `picalaba_rugis`
--
ALTER TABLE `picalaba_rugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `picastockjts`
--
ALTER TABLE `picastockjts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pica_bargings`
--
ALTER TABLE `pica_bargings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pica_hses`
--
ALTER TABLE `pica_hses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pica_minings`
--
ALTER TABLE `pica_minings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pica_over_coal`
--
ALTER TABLE `pica_over_coal`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pica_pa_uas`
--
ALTER TABLE `pica_pa_uas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pica_people`
--
ALTER TABLE `pica_people`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pica_pls`
--
ALTER TABLE `pica_pls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `plan_bargings`
--
ALTER TABLE `plan_bargings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produksis`
--
ALTER TABLE `produksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock_jts`
--
ALTER TABLE `stock_jts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subkategori_labarugis`
--
ALTER TABLE `subkategori_labarugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sub_labarugis`
--
ALTER TABLE `sub_labarugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_neracas`
--
ALTER TABLE `sub_neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailabarugis`
--
ALTER TABLE `detailabarugis`
  ADD CONSTRAINT `detailabarugis_sub_id_foreign` FOREIGN KEY (`sub_id`) REFERENCES `sub_labarugis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_neracas`
--
ALTER TABLE `detail_neracas`
  ADD CONSTRAINT `detail_neracas_sub_id_foreign` FOREIGN KEY (`sub_id`) REFERENCES `sub_neracas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hses`
--
ALTER TABLE `hses`
  ADD CONSTRAINT `hses_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_hses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `neracas`
--
ALTER TABLE `neracas`
  ADD CONSTRAINT `neracas_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `kategory_neracas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produksis`
--
ALTER TABLE `produksis`
  ADD CONSTRAINT `produksis_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_labarugis`
--
ALTER TABLE `sub_labarugis`
  ADD CONSTRAINT `sub_labarugis_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `category_labarugis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_neracas`
--
ALTER TABLE `sub_neracas`
  ADD CONSTRAINT `sub_neracas_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `category_neracas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
