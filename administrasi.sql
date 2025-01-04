-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2025 at 11:58 AM
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
  `laycan` varchar(255) NOT NULL,
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
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bargings`
--

INSERT INTO `bargings` (`id`, `laycan`, `namebarge`, `surveyor`, `portloading`, `portdishcharging`, `notifyaddres`, `initialsurvei`, `finalsurvey`, `quantity`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, '10-11 Nov 2024', 'TB. TMH 16 / BG ELECTRA 10', 'PT. CARSURIN', 'JETTY JTN', 'GARONGKONG', 'PT.INDOCEMENT TUNGGAL PRAKARSA', '2024-11-12', '2024-11-18', 55623575.00, '2024-12-29 01:15:08', '2024-12-29 02:06:36', 'STAFF1234567', 'STAFF1234567', NULL),
(2, '21 Nov 2024', 'TB. MITRA CATUR 6 / BG. MANDIRI 273', 'PT. CARSURIN', 'JETTY JTN', 'MV. Best Unity', 'PT. RLK ASIA DEVELOPMENT', '2024-11-23', '2024-12-25', 5110048.00, '2024-12-29 01:17:17', '2024-12-29 01:17:17', 'STAFF1234567', NULL, NULL);

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
-- Table structure for table `harga_poko_penjualans`
--

CREATE TABLE `harga_poko_penjualans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `rencana` varchar(255) DEFAULT NULL,
  `uraian` varchar(255) NOT NULL,
  `realisai` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `infrastructure_readinesses`
--

INSERT INTO `infrastructure_readinesses` (`id`, `ProjectName`, `Preparation`, `Construction`, `Commissiong`, `KelayakanBangunan`, `Kelengakapan`, `Kebersihan`, `total`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Kantor', NULL, NULL, '90', 90, 85, 90, '88%', '2024-12-26 08:39:11', '2024-12-28 04:06:37', 'STAFF1234567', 'STAFF1234567', NULL);

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
-- Table structure for table `kategori_laba_rugis`
--

CREATE TABLE `kategori_laba_rugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `DescriptionName` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub` varchar(50) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_laba_rugis`
--

INSERT INTO `kategori_laba_rugis` (`id`, `DescriptionName`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `sub`, `parent_id`) VALUES
(3, 'Revenue', 'STAFF1234567', NULL, NULL, '2024-12-30 00:09:43', '2024-12-30 00:09:43', NULL, NULL),
(4, 'Penjualan Batu Bara', 'STAFF1234567', NULL, NULL, '2024-12-30 00:09:43', '2024-12-30 00:09:43', NULL, 3),
(5, 'Penjualan Batu Bara (doc)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:09:43', '2024-12-30 00:09:43', NULL, 3),
(6, 'Cost of Goods Sold (COGS)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, NULL),
(7, 'Over Burden', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(8, 'Coal Getting', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(9, 'Rental Heavy Equipment', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(10, 'Hauling', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(11, 'Drilling', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(12, 'Loading', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(13, 'Land Depletion', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(14, 'Etc', 'STAFF1234567', NULL, NULL, '2024-12-30 00:14:05', '2024-12-30 00:14:05', NULL, 6),
(15, 'Shipping', 'STAFF1234567', NULL, NULL, '2024-12-30 00:16:34', '2024-12-30 00:16:34', NULL, NULL),
(16, 'Surveyor Cost', 'STAFF1234567', NULL, NULL, '2024-12-30 00:16:34', '2024-12-30 00:16:34', NULL, 15),
(17, 'Demurrage Cost', 'STAFF1234567', NULL, NULL, '2024-12-30 00:16:34', '2024-12-30 00:16:34', NULL, 15),
(18, 'Ship Agency (Doc.)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:16:34', '2024-12-30 00:16:34', NULL, 15),
(19, 'Security (PAM)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:16:34', '2024-12-30 00:16:34', NULL, 15),
(20, 'Etc', 'STAFF1234567', NULL, NULL, '2024-12-30 00:16:34', '2024-12-30 00:16:34', NULL, 15),
(22, 'Royalti', 'STAFF1234567', NULL, NULL, '2024-12-30 00:21:11', '2024-12-30 00:21:11', NULL, NULL),
(23, 'General & Administration', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, NULL),
(24, 'Salary', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(25, 'Director', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(26, 'Management', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(27, 'Site Employee', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(28, 'Allowance', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(29, 'Inssurance (Health & Employment)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(30, 'Etc', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:13', '2024-12-30 00:23:13', NULL, 23),
(31, 'Legal & Licenses', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:35', '2024-12-30 00:23:35', NULL, NULL),
(32, 'Operational Cost (Office & Site)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:23:44', '2024-12-30 00:23:44', NULL, NULL),
(33, 'ocial & CSR', 'STAFF1234567', NULL, NULL, '2024-12-30 00:24:36', '2024-12-30 00:24:36', NULL, NULL),
(34, 'Coporate Social Responsibility (CSR)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:24:36', '2024-12-30 00:24:36', NULL, 33),
(35, 'Compensation', 'STAFF1234567', NULL, NULL, '2024-12-30 00:24:36', '2024-12-30 00:24:36', NULL, 33),
(36, 'Donation', 'STAFF1234567', NULL, NULL, '2024-12-30 00:24:36', '2024-12-30 00:24:36', NULL, 33),
(37, 'Rent (General Affair)', 'STAFF1234567', NULL, NULL, '2024-12-30 00:25:25', '2024-12-30 00:25:25', NULL, NULL),
(38, 'Building', 'STAFF1234567', NULL, NULL, '2024-12-30 00:25:25', '2024-12-30 00:25:25', NULL, 37),
(39, 'Vehicle', 'STAFF1234567', NULL, NULL, '2024-12-30 00:25:25', '2024-12-30 00:25:25', NULL, 37),
(40, 'Sevice & Maintenance Assets', 'STAFF1234567', NULL, NULL, '2024-12-30 00:25:46', '2024-12-30 00:25:46', NULL, NULL),
(41, 'Office Supplys & Equipments', 'STAFF1234567', NULL, NULL, '2024-12-30 00:25:57', '2024-12-30 00:25:57', NULL, NULL),
(42, 'Tax Fines', 'STAFF1234567', NULL, NULL, '2024-12-30 00:26:10', '2024-12-30 00:26:10', NULL, NULL),
(43, 'Loan Interest Expense', 'STAFF1234567', NULL, NULL, '2024-12-30 00:26:24', '2024-12-30 00:26:24', NULL, NULL),
(44, 'Etc', 'STAFF1234567', NULL, NULL, '2024-12-30 00:30:12', '2024-12-30 00:30:12', NULL, NULL),
(46, 'Others Income & Expanses', 'STAFF1234567', NULL, NULL, '2024-12-30 00:31:47', '2024-12-30 00:31:47', NULL, NULL),
(47, 'Interest Income', 'STAFF1234567', NULL, NULL, '2024-12-30 00:31:47', '2024-12-30 00:31:47', NULL, 46),
(48, 'Interest  Ekspense', 'STAFF1234567', NULL, NULL, '2024-12-30 00:31:47', '2024-12-30 00:31:47', NULL, 46),
(49, 'Total Others Income & Expanses', 'STAFF1234567', NULL, NULL, '2024-12-30 00:31:59', '2024-12-30 00:31:59', NULL, NULL),
(50, 'Net Profit Before Tax', 'STAFF1234567', NULL, NULL, '2024-12-30 00:32:24', '2024-12-30 00:32:24', NULL, NULL),
(51, 'Corporate Tax', 'STAFF1234567', NULL, NULL, '2024-12-30 00:32:38', '2024-12-30 00:32:38', NULL, NULL);

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
(4, 'Penjualan', '2024-12-26 10:29:03', '2024-12-26 10:29:03', NULL, NULL, NULL);

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
-- Table structure for table `laba_rugis`
--

CREATE TABLE `laba_rugis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Description` varchar(255) NOT NULL,
  `PlaYtd` decimal(20,2) DEFAULT NULL,
  `VerticalAnalisys1` varchar(50) DEFAULT NULL,
  `VerticalAnalisys` varchar(11) DEFAULT NULL,
  `Actualytd` decimal(20,2) DEFAULT NULL,
  `Deviation` decimal(20,2) DEFAULT NULL,
  `Percentage` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laba_rugis`
--

INSERT INTO `laba_rugis` (`id`, `Description`, `PlaYtd`, `VerticalAnalisys1`, `VerticalAnalisys`, `Actualytd`, `Deviation`, `Percentage`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(104, '3', 51805400843.00, '100.00%', NULL, 3.00, 51805400840.00, '100%', '2025-01-03 08:45:28', '2025-01-04 02:17:26', 'STAFF1234567', 'STAFF1234567', NULL),
(105, '4', NULL, NULL, NULL, 1.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:16:24', 'STAFF1234567', 'STAFF1234567', NULL),
(106, '5', NULL, NULL, NULL, 2.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:16:24', 'STAFF1234567', 'STAFF1234567', NULL),
(107, '6', 68798548396.00, '132.80%', NULL, 12312.00, 68798536084.00, '100%', '2025-01-03 08:45:28', '2025-01-04 02:17:26', 'STAFF1234567', 'STAFF1234567', NULL),
(108, '7', NULL, NULL, NULL, 13212.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(109, '8', NULL, NULL, NULL, 12312.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(110, '9', NULL, NULL, NULL, 12312.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(111, '10', NULL, NULL, NULL, 213123.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(112, '11', NULL, NULL, NULL, 12312.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(113, '12', NULL, NULL, NULL, 12312.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(114, '13', NULL, NULL, NULL, 2131.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(115, '14', NULL, NULL, NULL, 12312.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(116, '15', 51805400843.00, '100.00%', NULL, 234234.00, 51805166609.00, '100%', '2025-01-03 08:45:28', '2025-01-04 02:17:26', 'STAFF1234567', 'STAFF1234567', NULL),
(117, '16', NULL, NULL, NULL, 2342.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(118, '17', NULL, NULL, NULL, 23423.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(119, '18', NULL, NULL, NULL, 342342.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(120, '19', NULL, NULL, NULL, 234234234.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL),
(121, '20', NULL, NULL, NULL, 234234.00, NULL, NULL, '2025-01-03 08:45:28', '2025-01-04 02:03:26', 'STAFF1234567', 'STAFF1234567', NULL);

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
(51, '2024_12_30_044741_add_updated_at_to_kategori_laba_rugis', 7);

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
(4, 'q', NULL, 'qq', NULL, 'q', '10%', '2024-12-26 11:46:47', '2024-12-26 11:46:47', 'q', 'Keuangan', 'STAFF1234567', NULL, NULL, 'qq');

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
  `deleted_by` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembebasan_lahans`
--

INSERT INTO `pembebasan_lahans` (`id`, `NamaPemilik`, `LuasLahan`, `KebutuhanLahan`, `Progress`, `Status`, `Achievement`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(3, 'pardi', 4.368, '0.89', 'On progress', NULL, '60%', '2024-12-26 09:32:04', '2024-12-28 05:53:22', 'STAFF1234567', 'STAFF1234567', NULL);

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
  `deleted_by` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `people_readinesses`
--

INSERT INTO `people_readinesses` (`id`, `posisi`, `Fullfillment_plan`, `pou_pou_plan`, `HSE_plan`, `Leadership_plan`, `Improvement_plan`, `Quality_plan`, `Quantity_plan`, `created_at`, `updated_at`, `pou_pou_actual`, `HSE_actual`, `Leadership_actual`, `Improvement_actual`, `Fullfillment_actual`, `created_by`, `updated_by`, `deleted_by`) VALUES
(2, 'Direktur / KTT', 1, 2, 1, 1, 1, '88%', '100%', '2024-12-25 07:22:01', '2024-12-26 06:56:40', 1, 1, 1, 1, 1, 'STAFF1234567', 'STAFF1234567', NULL),
(3, 'Manager / Division Head', 4, 4, 4, 4, 4, '50%', '50%', '2024-12-25 09:18:08', '2024-12-25 09:18:08', 2, 2, 2, 2, 2, 'STAFF1234567', NULL, NULL),
(4, 'supervaisor', 6, 6, 6, 6, 6, '54%', '83%', '2024-12-25 10:46:53', '2024-12-25 10:46:53', 2, 1, 5, 5, 5, 'STAFF1234567', NULL, NULL),
(5, 'Staff HO', 4, 1, 1, 4, 4, '44%', '100%', '2024-12-25 10:48:11', '2024-12-25 10:48:11', 0, 0, 3, 4, 4, 'STAFF1234567', NULL, NULL),
(6, 'Staff Site', 12, 1, 1, 1, 6, '75%', '83%', '2024-12-25 10:48:55', '2024-12-25 10:48:55', 0, 1, 1, 6, 10, 'STAFF1234567', NULL, NULL);

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
('jkc9JoDhyLGNys6Z6ImVuVx45xVvdL85ymCh9eVg', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWUxNMnZmck5xMkxrOURwOUYwRjc4TG1KSG5FVHJIYjdrbURlWjBlViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmRleD95ZWFyPTIwMjUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1735987757);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `harga_poko_penjualans`
--
ALTER TABLE `harga_poko_penjualans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `infrastructure_readinesses`
--
ALTER TABLE `infrastructure_readinesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_cs_minings`
--
ALTER TABLE `kategori_cs_minings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_laba_rugis`
--
ALTER TABLE `kategori_laba_rugis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_mini_r_s`
--
ALTER TABLE `kategori_mini_r_s`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategory_neracas`
--
ALTER TABLE `kategory_neracas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laba_rugis`
--
ALTER TABLE `laba_rugis`
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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `harga_poko_penjualans`
--
ALTER TABLE `harga_poko_penjualans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `infrastructure_readinesses`
--
ALTER TABLE `infrastructure_readinesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori_cs_minings`
--
ALTER TABLE `kategori_cs_minings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori_laba_rugis`
--
ALTER TABLE `kategori_laba_rugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `kategori_mini_r_s`
--
ALTER TABLE `kategori_mini_r_s`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategory_neracas`
--
ALTER TABLE `kategory_neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laba_rugis`
--
ALTER TABLE `laba_rugis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `mining_readinesses`
--
ALTER TABLE `mining_readinesses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `neracas`
--
ALTER TABLE `neracas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembebasan_lahans`
--
ALTER TABLE `pembebasan_lahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produksis`
--
ALTER TABLE `produksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `neracas`
--
ALTER TABLE `neracas`
  ADD CONSTRAINT `neracas_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `kategory_neracas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `produksis`
--
ALTER TABLE `produksis`
  ADD CONSTRAINT `produksis_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
