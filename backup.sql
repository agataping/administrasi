-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: administrasi
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bargings`
--

DROP TABLE IF EXISTS `bargings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bargings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bargings`
--

LOCK TABLES `bargings` WRITE;
/*!40000 ALTER TABLE `bargings` DISABLE KEYS */;
INSERT INTO `bargings` VALUES (1,'10-11 Nov 2024','TB. TMH 16 / BG ELECTRA 10','PT. CARSURIN','JETTY JTN','GARONGKONG','PT.INDOCEMENT TUNGGAL PRAKARSA','2024-11-12','2024-11-18',55623575.00,'2024-12-29 01:15:08','2024-12-29 02:06:36','STAFF1234567','STAFF1234567',NULL),(2,'21 Nov 2024','TB. MITRA CATUR 6 / BG. MANDIRI 273','PT. CARSURIN','JETTY JTN','MV. Best Unity','PT. RLK ASIA DEVELOPMENT','2024-11-23','2024-12-25',5110048.00,'2024-12-29 01:17:17','2024-12-29 01:17:17','STAFF1234567',NULL,NULL);
/*!40000 ALTER TABLE `bargings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `c_s_mothnly_productions`
--

DROP TABLE IF EXISTS `c_s_mothnly_productions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `c_s_mothnly_productions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `deleted_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `c_s_mothnly_productions`
--

LOCK TABLES `c_s_mothnly_productions` WRITE;
/*!40000 ALTER TABLE `c_s_mothnly_productions` DISABLE KEYS */;
INSERT INTO `c_s_mothnly_productions` VALUES (1,'2024-11-24',13229599.00,13229599.00,NULL,1319995.00,1319995.00,NULL,11043280.00,11042380.00,NULL,254440.00,78396.00,NULL,12344568.00,'2024-12-29 02:23:15','2024-12-29 06:23:35','STAFF1234567','STAFF1234567',NULL),(2,'2024-11-24',11300990.00,11300990.00,NULL,2217600.00,2217600.00,NULL,5222100.00,5522100.00,NULL,1009520.00,1009520.00,NULL,1067362.00,'2024-12-29 02:24:55','2024-12-29 02:24:55','STAFF1234567',NULL,NULL),(3,'2024-10-24',NULL,NULL,NULL,NULL,NULL,NULL,1422000.00,NULL,NULL,NULL,NULL,NULL,550170.00,'2024-12-29 02:25:41','2024-12-29 06:21:40','STAFF1234567','STAFF1234567',NULL);
/*!40000 ALTER TABLE `c_s_mothnly_productions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cs_mining_readinesses`
--

DROP TABLE IF EXISTS `cs_mining_readinesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cs_mining_readinesses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `filling` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cs_mining_readinesses`
--

LOCK TABLES `cs_mining_readinesses` WRITE;
/*!40000 ALTER TABLE `cs_mining_readinesses` DISABLE KEYS */;
INSERT INTO `cs_mining_readinesses` VALUES (1,'1','1','1','2024-12-17','1','1','2a','2024-12-29 07:15:15','2024-12-29 07:15:15','Penjualan','STAFF1234567',NULL,NULL,NULL),(2,'1','1','1','2024-12-03','1','1','2a','2024-12-29 07:15:31','2024-12-29 07:15:31','Penjualan','STAFF1234567',NULL,NULL,NULL),(3,'1','1','1','2024-12-17','1','1','2a','2024-12-29 07:15:42','2024-12-29 07:15:42','Penjualan','STAFF1234567',NULL,NULL,NULL),(4,'1','1','1','2020-12-12','1','1','2a','2024-12-29 07:16:11','2024-12-29 07:16:11','Penjualan','STAFF1234567',NULL,NULL,NULL),(5,'1','1','1','2024-12-12','1','1','3a','2024-12-29 07:17:21','2024-12-29 07:17:21','Penjualan','STAFF1234567',NULL,NULL,NULL),(6,'SPT Tahunan','503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015','On Progres','2025-12-12','sekarang','60','4a','2024-12-29 07:37:23','2024-12-29 07:46:58','Legalitas','STAFF1234567','STAFF1234567',NULL,'office'),(7,'SPT Tahunan','503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015','On Progres','2024-12-12','sekarang','60','4a','2024-12-29 07:40:13','2024-12-29 07:40:13','Keuangan','STAFF1234567',NULL,NULL,'officw'),(8,'SPT Tahunan','503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015','On Progres','2024-12-12','sekarang','60','4a','2024-12-29 07:41:00','2024-12-29 07:47:48','Legalitas','STAFF1234567','STAFF1234567',NULL,'office'),(9,'SPT Tahunan','503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015','On Progres','2024-02-14','sekarang','60','4a','2024-12-29 07:41:20','2024-12-29 07:48:43','Lingkungan','STAFF1234567','STAFF1234567',NULL,'office');
/*!40000 ALTER TABLE `cs_mining_readinesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deadline_compensation`
--

DROP TABLE IF EXISTS `deadline_compensation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deadline_compensation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Keterangan` varchar(255) NOT NULL,
  `MasaSewa` varchar(255) NOT NULL,
  `Nominalsewa` varchar(255) NOT NULL,
  `ProgresTahun` varchar(255) NOT NULL,
  `JatuhTempo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deadline_compensation`
--

LOCK TABLES `deadline_compensation` WRITE;
/*!40000 ALTER TABLE `deadline_compensation` DISABLE KEYS */;
INSERT INTO `deadline_compensation` VALUES (1,'Pembayaran Sewa Jalan Hauling','pertahun','5.000/m','Telah dibayarkan Juni 2024-Juni 2025','Juni 2025','2024-12-27 07:11:52','2024-12-29 07:04:20','STAFF1234567','STAFF1234567',NULL);
/*!40000 ALTER TABLE `deadline_compensation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deadline_compentsation_cs`
--

DROP TABLE IF EXISTS `deadline_compentsation_cs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deadline_compentsation_cs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Keterangan` varchar(255) NOT NULL,
  `MasaSewa` varchar(255) NOT NULL,
  `Nominalsewa` varchar(255) NOT NULL,
  `ProgresTahun` varchar(255) NOT NULL,
  `JatuhTempo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deadline_compentsation_cs`
--

LOCK TABLES `deadline_compentsation_cs` WRITE;
/*!40000 ALTER TABLE `deadline_compentsation_cs` DISABLE KEYS */;
INSERT INTO `deadline_compentsation_cs` VALUES (1,'Pembayaran Sewa Jalan Hauling','pertahun','5.000/m','Telah dibayarkan Juni 2024-Juni 2025','Juni 2026','2024-12-29 06:58:55','2024-12-29 07:03:35','STAFF1234567','STAFF1234567',NULL);
/*!40000 ALTER TABLE `deadline_compentsation_cs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `harga_poko_penjualans`
--

DROP TABLE IF EXISTS `harga_poko_penjualans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `harga_poko_penjualans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT 0,
  `rencana` varchar(255) DEFAULT NULL,
  `uraian` varchar(255) NOT NULL,
  `realisai` varchar(255) DEFAULT NULL,
  `tahun` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `harga_poko_penjualans`
--

LOCK TABLES `harga_poko_penjualans` WRITE;
/*!40000 ALTER TABLE `harga_poko_penjualans` DISABLE KEYS */;
/*!40000 ALTER TABLE `harga_poko_penjualans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `infrastructure_readinesses`
--

DROP TABLE IF EXISTS `infrastructure_readinesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `infrastructure_readinesses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `infrastructure_readinesses`
--

LOCK TABLES `infrastructure_readinesses` WRITE;
/*!40000 ALTER TABLE `infrastructure_readinesses` DISABLE KEYS */;
INSERT INTO `infrastructure_readinesses` VALUES (1,'Kantor',NULL,NULL,'90',90,85,90,'88%','2024-12-26 08:39:11','2024-12-28 04:06:37','STAFF1234567','STAFF1234567',NULL);
/*!40000 ALTER TABLE `infrastructure_readinesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_cs_minings`
--

DROP TABLE IF EXISTS `kategori_cs_minings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_cs_minings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_cs_minings`
--

LOCK TABLES `kategori_cs_minings` WRITE;
/*!40000 ALTER TABLE `kategori_cs_minings` DISABLE KEYS */;
INSERT INTO `kategori_cs_minings` VALUES (2,'Legalitas','2024-12-29 07:14:00','2024-12-29 07:14:00',NULL,NULL,NULL),(3,'Penjualan','2024-12-29 07:14:00','2024-12-29 07:14:00',NULL,NULL,NULL),(4,'Keuangan','2024-12-29 07:39:45','2024-12-29 07:39:45',NULL,NULL,NULL),(5,'Lingkungan','2024-12-29 07:40:00','2024-12-29 07:40:00',NULL,NULL,NULL);
/*!40000 ALTER TABLE `kategori_cs_minings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_laba_rugis`
--

DROP TABLE IF EXISTS `kategori_laba_rugis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_laba_rugis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `DescriptionName` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub` varchar(50) DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_laba_rugis`
--

LOCK TABLES `kategori_laba_rugis` WRITE;
/*!40000 ALTER TABLE `kategori_laba_rugis` DISABLE KEYS */;
INSERT INTO `kategori_laba_rugis` VALUES (3,'Revenue','STAFF1234567',NULL,NULL,'2024-12-30 00:09:43','2024-12-30 00:09:43',NULL,NULL),(4,'Penjualan Batu Bara','STAFF1234567',NULL,NULL,'2024-12-30 00:09:43','2024-12-30 00:09:43',NULL,3),(5,'Penjualan Batu Bara (doc)','STAFF1234567',NULL,NULL,'2024-12-30 00:09:43','2024-12-30 00:09:43',NULL,3),(6,'Cost of Goods Sold (COGS)','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,NULL),(7,'Over Burden','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(8,'Coal Getting','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(9,'Rental Heavy Equipment','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(10,'Hauling','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(11,'Drilling','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(12,'Loading','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(13,'Land Depletion','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(14,'Etc','STAFF1234567',NULL,NULL,'2024-12-30 00:14:05','2024-12-30 00:14:05',NULL,6),(15,'Shipping','STAFF1234567',NULL,NULL,'2024-12-30 00:16:34','2024-12-30 00:16:34',NULL,NULL),(16,'Surveyor Cost','STAFF1234567',NULL,NULL,'2024-12-30 00:16:34','2024-12-30 00:16:34',NULL,15),(17,'Demurrage Cost','STAFF1234567',NULL,NULL,'2024-12-30 00:16:34','2024-12-30 00:16:34',NULL,15),(18,'Ship Agency (Doc.)','STAFF1234567',NULL,NULL,'2024-12-30 00:16:34','2024-12-30 00:16:34',NULL,15),(19,'Security (PAM)','STAFF1234567',NULL,NULL,'2024-12-30 00:16:34','2024-12-30 00:16:34',NULL,15),(20,'Etc','STAFF1234567',NULL,NULL,'2024-12-30 00:16:34','2024-12-30 00:16:34',NULL,15),(22,'Royalti','STAFF1234567',NULL,NULL,'2024-12-30 00:21:11','2024-12-30 00:21:11',NULL,NULL),(23,'General & Administration','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,NULL),(24,'Salary','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(25,'Director','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(26,'Management','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(27,'Site Employee','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(28,'Allowance','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(29,'Inssurance (Health & Employment)','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(30,'Etc','STAFF1234567',NULL,NULL,'2024-12-30 00:23:13','2024-12-30 00:23:13',NULL,23),(31,'Legal & Licenses','STAFF1234567',NULL,NULL,'2024-12-30 00:23:35','2024-12-30 00:23:35',NULL,NULL),(32,'Operational Cost (Office & Site)','STAFF1234567',NULL,NULL,'2024-12-30 00:23:44','2024-12-30 00:23:44',NULL,NULL),(33,'ocial & CSR','STAFF1234567',NULL,NULL,'2024-12-30 00:24:36','2024-12-30 00:24:36',NULL,NULL),(34,'Coporate Social Responsibility (CSR)','STAFF1234567',NULL,NULL,'2024-12-30 00:24:36','2024-12-30 00:24:36',NULL,33),(35,'Compensation','STAFF1234567',NULL,NULL,'2024-12-30 00:24:36','2024-12-30 00:24:36',NULL,33),(36,'Donation','STAFF1234567',NULL,NULL,'2024-12-30 00:24:36','2024-12-30 00:24:36',NULL,33),(37,'Rent (General Affair)','STAFF1234567',NULL,NULL,'2024-12-30 00:25:25','2024-12-30 00:25:25',NULL,NULL),(38,'Building','STAFF1234567',NULL,NULL,'2024-12-30 00:25:25','2024-12-30 00:25:25',NULL,37),(39,'Vehicle','STAFF1234567',NULL,NULL,'2024-12-30 00:25:25','2024-12-30 00:25:25',NULL,37),(40,'Sevice & Maintenance Assets','STAFF1234567',NULL,NULL,'2024-12-30 00:25:46','2024-12-30 00:25:46',NULL,NULL),(41,'Office Supplys & Equipments','STAFF1234567',NULL,NULL,'2024-12-30 00:25:57','2024-12-30 00:25:57',NULL,NULL),(42,'Tax Fines','STAFF1234567',NULL,NULL,'2024-12-30 00:26:10','2024-12-30 00:26:10',NULL,NULL),(43,'Loan Interest Expense','STAFF1234567',NULL,NULL,'2024-12-30 00:26:24','2024-12-30 00:26:24',NULL,NULL),(44,'Etc','STAFF1234567',NULL,NULL,'2024-12-30 00:30:12','2024-12-30 00:30:12',NULL,NULL),(46,'Others Income & Expanses','STAFF1234567',NULL,NULL,'2024-12-30 00:31:47','2024-12-30 00:31:47',NULL,NULL),(47,'Interest Income','STAFF1234567',NULL,NULL,'2024-12-30 00:31:47','2024-12-30 00:31:47',NULL,46),(48,'Interest  Ekspense','STAFF1234567',NULL,NULL,'2024-12-30 00:31:47','2024-12-30 00:31:47',NULL,46),(49,'Total Others Income & Expanses','STAFF1234567',NULL,NULL,'2024-12-30 00:31:59','2024-12-30 00:31:59',NULL,NULL),(50,'Net Profit Before Tax','STAFF1234567',NULL,NULL,'2024-12-30 00:32:24','2024-12-30 00:32:24',NULL,NULL),(51,'Corporate Tax','STAFF1234567',NULL,NULL,'2024-12-30 00:32:38','2024-12-30 00:32:38',NULL,NULL);
/*!40000 ALTER TABLE `kategori_laba_rugis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori_mini_r_s`
--

DROP TABLE IF EXISTS `kategori_mini_r_s`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori_mini_r_s` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori_mini_r_s`
--

LOCK TABLES `kategori_mini_r_s` WRITE;
/*!40000 ALTER TABLE `kategori_mini_r_s` DISABLE KEYS */;
INSERT INTO `kategori_mini_r_s` VALUES (1,'Keuangan','2024-12-26 09:34:06','2024-12-26 09:34:06',NULL,NULL,NULL),(2,'Lingkungan','2024-12-26 09:34:27','2024-12-26 09:34:27',NULL,NULL,NULL),(3,'Legalitas','2024-12-26 10:28:44','2024-12-26 10:28:44',NULL,NULL,NULL),(4,'Penjualan','2024-12-26 10:29:03','2024-12-26 10:29:03',NULL,NULL,NULL);
/*!40000 ALTER TABLE `kategori_mini_r_s` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategory_neracas`
--

DROP TABLE IF EXISTS `kategory_neracas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategory_neracas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategory_neracas`
--

LOCK TABLES `kategory_neracas` WRITE;
/*!40000 ALTER TABLE `kategory_neracas` DISABLE KEYS */;
/*!40000 ALTER TABLE `kategory_neracas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `laba_rugis`
--

DROP TABLE IF EXISTS `laba_rugis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laba_rugis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Description` varchar(255) NOT NULL,
  `PlaYtd` decimal(20,2) DEFAULT NULL,
  `VerticalAnalisys1` decimal(20,2) DEFAULT NULL,
  `VerticalAnalisys` varchar(11) DEFAULT NULL,
  `Actualytd` decimal(20,2) DEFAULT NULL,
  `Deviation` decimal(20,2) DEFAULT NULL,
  `Percentage` varchar(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `deleted_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `laba_rugis`
--

LOCK TABLES `laba_rugis` WRITE;
/*!40000 ALTER TABLE `laba_rugis` DISABLE KEYS */;
INSERT INTO `laba_rugis` VALUES (1,'3',126647690854.00,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(2,'4',NULL,NULL,NULL,5180540084342.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(3,'5',NULL,NULL,NULL,2555000000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(4,'6',68798548397.00,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(5,'7',NULL,NULL,NULL,22358339384.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(6,'8',NULL,NULL,NULL,1168981534.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(7,'9',NULL,NULL,NULL,196814750.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(8,'10',NULL,NULL,NULL,1274728326.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(9,'11',NULL,NULL,NULL,1580641700.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(10,'12',NULL,NULL,NULL,3431541575.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(11,'13',NULL,NULL,NULL,5182291670.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(12,'14',NULL,NULL,NULL,4147787352.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(13,'15',1899715363.00,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(14,'16',NULL,NULL,NULL,311750537.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(15,'17',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(16,'18',NULL,NULL,NULL,977118279.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(17,'19',NULL,NULL,NULL,658753619.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(18,'20',NULL,NULL,NULL,841550000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(19,'22',10250297868.00,NULL,NULL,5338306478.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(20,'23',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(21,'24',NULL,NULL,NULL,NULL,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(22,'25',NULL,NULL,NULL,1670000000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(23,'26',NULL,NULL,NULL,410000000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(24,'27',NULL,NULL,NULL,NULL,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(25,'28',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(26,'29',NULL,NULL,NULL,83498310.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(27,'30',NULL,NULL,NULL,922487000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(28,'31',NULL,NULL,NULL,1702911524.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(29,'32',NULL,NULL,NULL,1550461300.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(30,'33',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(31,'34',NULL,NULL,NULL,348500000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(32,'35',NULL,NULL,NULL,1181530000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(33,'36',NULL,NULL,NULL,411040000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(34,'37',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(35,'38',NULL,NULL,NULL,48000000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(36,'39',NULL,NULL,NULL,376250000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(37,'40',NULL,NULL,NULL,70717638.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(38,'41',NULL,NULL,NULL,102501370.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(39,'42',NULL,NULL,NULL,800000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(40,'43',NULL,NULL,NULL,131250000.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(41,'44',13931245994.00,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(42,'46',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(43,'47',NULL,NULL,NULL,31237522.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(44,'48',NULL,NULL,NULL,-7667004.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(45,'49',NULL,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(46,'50',25129700490.00,NULL,NULL,-3400717785.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL),(47,'51',5528534108.00,NULL,NULL,0.00,NULL,NULL,'2024-12-30 04:57:37','2024-12-30 04:57:37','STAFF1234567',NULL,NULL);
/*!40000 ALTER TABLE `laba_rugis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_200000_add_two_factor_columns_to_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2024_01_02_093828_create_sessions_table',1),(7,'2024_01_02_154551_add_role_to_users_table',1),(8,'2024_12_17_190823_create_people_readinesses_table',1),(9,'2024_12_17_192114_create_infrastructure_readinesses_table',1),(10,'2024_12_17_192605_create_mining_readinesses_table',1),(11,'2024_12_17_193021_create_pembebasan_lahans_table',1),(12,'2024_12_17_193316_create_deadline_compensation_table',1),(13,'2024_12_17_200817_create_laba_rugis_table',1),(14,'2024_12_17_221259_add__h_s_eactual__to_people_readinesses_table',1),(15,'2024_12_17_221646_add__fullfillment_actual__to_people_readinesses_table',1),(16,'2024_12_18_131911_create_kategori_laba_rugis_table',1),(17,'2024_12_18_133354_add_year_laba_rugis_table',1),(18,'2024_12_18_154838_create_kategori_mini_r_s_table',1),(19,'2024_12_18_155101_add_nomor_mining_readinesses_table',1),(20,'2024_12_18_163723_add__kategori_description_mining_readinesses_table',1),(21,'2024_12_18_211146_create_bargings_table',1),(22,'2024_12_19_144715_create_cs_mining_readinesses_table',1),(23,'2024_12_19_145048_add__kategori_description_cs_mining_readinesses_table',1),(24,'2024_12_19_151212_create_kategori_cs_minings_table',1),(25,'2024_12_19_152825_create_deadline_compentsation_cs_table',1),(26,'2024_12_21_122844_create_kategory_neracas_table',1),(27,'2024_12_21_161846_create_harga_poko_penjualans_table',1),(28,'2024_12_21_184200_add_parent_id_to_kategory_neracas',1),(29,'2024_12_21_190856_neracas',1),(30,'2024_12_21_224416_create_units_table',1),(31,'2024_12_21_224435_create_produksis_table',1),(32,'2024_12_22_095602_create_c_s_mothnly_productions_table',1),(33,'2024_12_22_123711_add_parent_t_hm_produksis_table',1),(34,'2024_12_22_151416_create_perusahaans_table',1),(35,'2024_12_22_154839_add_induk_perusahaans_table',1),(36,'2024_12_25_151333_add_audit_columns_to_people_readiness_table',2),(37,'2024_12_25_194900_add_audit_columns_to_bargings_table',3),(38,'2024_12_25_195534_add_audit_columns_to_cs_mining_readinesses_table',4),(39,'2024_12_25_195812_add_audit_columns_to_deadline_compensation_table',4),(40,'2024_12_25_200023_add_audit_columns_to_harga_poko_penjualans_table',5),(41,'2024_12_25_200047_add_audit_columns_to_infrastructure_readinesses_table',5),(42,'2024_12_25_200118_add_audit_columns_to_kategori_cs_minings_table',5),(43,'2024_12_25_200144_add_audit_columns_to_kategori_laba_rugistable',5),(44,'2024_12_25_200214_add_audit_columns_to_kategori_mini_r_s',5),(45,'2024_12_25_200242_add_audit_columns_to_kategory_neracas_table',5),(46,'2024_12_25_200309_add_audit_columns_to_neracas_table',5),(47,'2024_12_25_200336_add_audit_columns_to_produksis_table',5),(48,'2024_12_25_200418_add_audit_columns_to_perusahaans_table',5),(49,'2024_12_25_200440_add_audit_columns_to_units_table',5),(50,'2024_12_29_155337_create_pembebasan_lahan_cs_table',6),(51,'2024_12_30_044741_add_updated_at_to_kategori_laba_rugis',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mining_readinesses`
--

DROP TABLE IF EXISTS `mining_readinesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mining_readinesses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `filling` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mining_readinesses`
--

LOCK TABLES `mining_readinesses` WRITE;
/*!40000 ALTER TABLE `mining_readinesses` DISABLE KEYS */;
INSERT INTO `mining_readinesses` VALUES (2,'IUP','503/1573/IUP-OP/BPPMD/BPPMD-PTSP/X/2015','Operasional','2015-10-02','sekarang','100','2024-12-26 10:16:59','2024-12-28 04:54:03','1a','Lingkungan','STAFF1234567','STAFF1234567',NULL,'office'),(3,'SPT Tahunan',NULL,NULL,NULL,NULL,'70%','2024-12-26 11:42:42','2024-12-28 04:56:45','4a','Keuangan','STAFF1234567','STAFF1234567',NULL,NULL),(4,'q',NULL,'qq',NULL,'q','10%','2024-12-26 11:46:47','2024-12-26 11:46:47','q','Keuangan','STAFF1234567',NULL,NULL,'qq');
/*!40000 ALTER TABLE `mining_readinesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `neracas`
--

DROP TABLE IF EXISTS `neracas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `neracas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `neracas_category_id_foreign` (`category_id`),
  CONSTRAINT `neracas_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `kategory_neracas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `neracas`
--

LOCK TABLES `neracas` WRITE;
/*!40000 ALTER TABLE `neracas` DISABLE KEYS */;
/*!40000 ALTER TABLE `neracas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembebasan_lahan_cs`
--

DROP TABLE IF EXISTS `pembebasan_lahan_cs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembebasan_lahan_cs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembebasan_lahan_cs`
--

LOCK TABLES `pembebasan_lahan_cs` WRITE;
/*!40000 ALTER TABLE `pembebasan_lahan_cs` DISABLE KEYS */;
INSERT INTO `pembebasan_lahan_cs` VALUES (1,'pardi',4.36,'0.89','On progress','1','60%','STAFF1234567',NULL,NULL,'2024-12-29 08:08:35','2024-12-29 08:08:35');
/*!40000 ALTER TABLE `pembebasan_lahan_cs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembebasan_lahans`
--

DROP TABLE IF EXISTS `pembebasan_lahans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pembebasan_lahans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembebasan_lahans`
--

LOCK TABLES `pembebasan_lahans` WRITE;
/*!40000 ALTER TABLE `pembebasan_lahans` DISABLE KEYS */;
INSERT INTO `pembebasan_lahans` VALUES (3,'pardi',4.368,'0.89','On progress',NULL,'60%','2024-12-26 09:32:04','2024-12-28 05:53:22','STAFF1234567','STAFF1234567',NULL);
/*!40000 ALTER TABLE `pembebasan_lahans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people_readinesses`
--

DROP TABLE IF EXISTS `people_readinesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people_readinesses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people_readinesses`
--

LOCK TABLES `people_readinesses` WRITE;
/*!40000 ALTER TABLE `people_readinesses` DISABLE KEYS */;
INSERT INTO `people_readinesses` VALUES (2,'Direktur / KTT',1,2,1,1,1,'88%','100%','2024-12-25 07:22:01','2024-12-26 06:56:40',1,1,1,1,1,'STAFF1234567','STAFF1234567',NULL),(3,'Manager / Division Head',4,4,4,4,4,'50%','50%','2024-12-25 09:18:08','2024-12-25 09:18:08',2,2,2,2,2,'STAFF1234567',NULL,NULL),(4,'supervaisor',6,6,6,6,6,'54%','83%','2024-12-25 10:46:53','2024-12-25 10:46:53',2,1,5,5,5,'STAFF1234567',NULL,NULL),(5,'Staff HO',4,1,1,4,4,'44%','100%','2024-12-25 10:48:11','2024-12-25 10:48:11',0,0,3,4,4,'STAFF1234567',NULL,NULL),(6,'Staff Site',12,1,1,1,6,'75%','83%','2024-12-25 10:48:55','2024-12-25 10:48:55',0,1,1,6,10,'STAFF1234567',NULL,NULL);
/*!40000 ALTER TABLE `people_readinesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perusahaans`
--

DROP TABLE IF EXISTS `perusahaans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perusahaans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `induk` varchar(255) NOT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perusahaans`
--

LOCK TABLES `perusahaans` WRITE;
/*!40000 ALTER TABLE `perusahaans` DISABLE KEYS */;
/*!40000 ALTER TABLE `perusahaans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produksis`
--

DROP TABLE IF EXISTS `produksis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produksis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
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
  `unit_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `t_hm` decimal(10,2) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produksis_unit_id_foreign` (`unit_id`),
  CONSTRAINT `produksis_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produksis`
--

LOCK TABLES `produksis` WRITE;
/*!40000 ALTER TABLE `produksis` DISABLE KEYS */;
INSERT INTO `produksis` VALUES (1,1111.00,1.00,1.00,1.00,11.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,11.00,20.00,1.00,NULL,1.00,'11','1','11','1','1','19999',2,'2024-12-28 06:38:07','2024-12-28 07:35:53',1.00,'STAFF1234567','STAFF1234567',NULL),(2,2.00,2.00,2.00,2.00,22.00,2.00,2.00,22.00,2.00,2.00,2.00,22.00,2.00,22.00,22.00,22.00,22.00,2.00,2.00,2.00,22.00,22.00,'2','2','2','2','2','2',2,'2024-12-28 07:02:42','2024-12-28 07:02:42',22.00,'STAFF1234567',NULL,NULL),(3,3.00,3.00,33.00,3.00,3.00,3.00,3.00,3.00,33.00,33.00,3.00,3.00,33.00,3.00,3.00,3.00,3.00,3.00,3.00,3.00,3.00,33.00,'3','3','3','3','3','3',3,'2024-12-28 07:12:35','2024-12-28 07:12:35',3.00,'STAFF1234567',NULL,NULL),(4,1111.00,1.00,1.00,1.00,11.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,1.00,11.00,20.00,1.00,NULL,1.00,'123234234','1','11','18888','1','1',3,'2024-12-28 07:30:08','2024-12-28 07:36:14',1.00,'STAFF1234567','STAFF1234567',NULL);
/*!40000 ALTER TABLE `produksis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('tNVieFVH2o1xEY5PQjHjh6knfpA5qjpbQrgpnE8e',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoidWh6NFBqUklkZ0dOSVFqY2oyRll5emExb21CQWlWcG1wcXhLbVRjTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbmRleD95ZWFyPTIwMjQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1735569615);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code_number` varchar(20) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `deleted_by` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'DTXC116','UNIT HAULER','2024-12-28 06:06:14','2024-12-28 06:06:14','STAFF1234567',NULL,NULL),(2,'ZE21085','UNIT LOADER','2024-12-28 06:10:49','2024-12-28 06:10:49','STAFF1234567',NULL,NULL),(3,'ZD22148','UNIT SUPORT','2024-12-28 06:12:39','2024-12-28 06:12:39','STAFF1234567',NULL,NULL),(4,'ZE37223','UNIT HAULER','2024-12-28 06:48:51','2024-12-28 06:48:51','STAFF1234567',NULL,NULL);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('staff','direksi','pimpinan') NOT NULL,
  `username` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'anak perusahaan b','$2y$12$VbA3aCqGMIlfjsPiNkiZ9.8JBpIBG34kSsIZJ3L8rlCvpHSSxL4Me',NULL,NULL,NULL,NULL,'2024-12-25 06:48:32','2024-12-25 06:48:32','staff','STAFF1234567');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-30 22:48:01
