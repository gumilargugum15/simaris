-- MySQL dump 10.16  Distrib 10.3.9-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: simaris
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aktorvalidasi`
--

DROP TABLE IF EXISTS `aktorvalidasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aktorvalidasi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aktorvalidasi`
--

LOCK TABLES `aktorvalidasi` WRITE;
/*!40000 ALTER TABLE `aktorvalidasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `aktorvalidasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dampak`
--

DROP TABLE IF EXISTS `dampak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dampak` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dampak`
--

LOCK TABLES `dampak` WRITE;
/*!40000 ALTER TABLE `dampak` DISABLE KEYS */;
INSERT INTO `dampak` VALUES (1,'1','Tidak Signifikan',NULL,NULL,'2019-04-09 18:36:59','2019-04-09 18:36:59'),(2,'2','Kecil',NULL,NULL,'2019-04-09 18:36:59','2019-04-09 18:36:59'),(3,'3','Sedang',NULL,NULL,'2019-04-09 18:36:59','2019-04-09 18:36:59'),(4,'4','Besar',NULL,NULL,'2019-04-09 18:36:59','2019-04-09 18:36:59'),(5,'5','Sangat Besar',NULL,NULL,'2019-04-09 18:36:59','2019-04-09 18:36:59');
/*!40000 ALTER TABLE `dampak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategori` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'sdfsdf','sdfsdf','',NULL,NULL),(2,'xxx','xxx','',NULL,NULL);
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klasifikasi`
--

DROP TABLE IF EXISTS `klasifikasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `klasifikasi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klasifikasi`
--

LOCK TABLES `klasifikasi` WRITE;
/*!40000 ALTER TABLE `klasifikasi` DISABLE KEYS */;
INSERT INTO `klasifikasi` VALUES (1,'Strategis',NULL,NULL,'2019-04-22 21:01:11','2019-04-22 21:01:11'),(2,'Operasional',NULL,NULL,'2019-04-22 21:01:11','2019-04-22 21:01:11'),(3,'Keuangan',NULL,NULL,'2019-04-22 21:01:11','2019-04-22 21:01:11'),(4,'Kepatuhan',NULL,NULL,'2019-04-22 21:01:11','2019-04-22 21:01:11');
/*!40000 ALTER TABLE `klasifikasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kpi`
--

DROP TABLE IF EXISTS `kpi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kpi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `tahun` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kpi`
--

LOCK TABLES `kpi` WRITE;
/*!40000 ALTER TABLE `kpi` DISABLE KEYS */;
INSERT INTO `kpi` VALUES (1,'A00001','IMPLEMENTASI MBCFPE / KPKU',1,'2019','1','','2019-04-01 19:56:35','2019-04-01 19:56:35'),(2,'A00002','CURRENT RATIO',1,'2019','1','','2019-04-01 19:56:35','2019-04-01 19:56:35'),(3,'A00003','KETERSEDIAAN PEMBIAYAAN OPERASI',1,'2019','1','','2019-04-01 19:56:35','2019-04-01 19:56:35'),(4,'A00004','EBITDA / INTEREST',1,'2019','1','','2019-04-01 19:56:35','2019-04-01 19:56:35'),(5,'A00005','MENGIMPLEMENTASIKAN  SISTEM  INFORMASI SECARA EFEKTIF',1,'2019','1','','2019-04-01 19:56:35','2019-04-01 19:56:35'),(6,'A00006','DEBT TO EQUITY RATIO',1,'2019','1','','2019-04-01 19:56:36','2019-04-01 19:56:36'),(7,'A00007','PROSES VERIFIKASI  DOKUMEN PEMBAYARAN SESUAI  PROSEDUR YANG BERLAKU DAN TEPAT WAKTU',1,'2019','1','','2019-04-01 19:56:36','2019-04-01 19:56:36'),(8,'A00008','MONITORING BIAYA PRODUKSI, BIAYA PERAWATAN DAN BIAYA OVERHEAD',1,'2019','1','','2019-04-01 19:56:36','2019-04-01 19:56:36'),(9,'A00009','KETAATAN TERHADAP KETENTUAN PERPAJAKAN & KEBIJAKAN AKUNTANSI',1,'2019','1','','2019-04-01 19:56:36','2019-04-01 19:56:36'),(10,'A00010','KETEPATAN WAKTU PENERBITAN LAPORAN KEUANGAN, LAPORAN MANAJEMEN DAN RKAP',1,'2019','1','','2019-04-01 19:56:36','2019-04-01 19:56:36');
/*!40000 ALTER TABLE `kpi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kriteria`
--

DROP TABLE IF EXISTS `kriteria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kriteria` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dampak_id` int(10) unsigned NOT NULL,
  `kategori_id` int(10) unsigned NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kriteria`
--

LOCK TABLES `kriteria` WRITE;
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
INSERT INTO `kriteria` VALUES (1,'sdfsd','sdfsd',1,1,'','',NULL,NULL),(2,'xxx','xxx',2,2,'','',NULL,NULL);
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_03_22_030236_create_simaris_tables',1),(4,'2019_04_22_024020_create_permission_tables',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (5,'App\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peluang`
--

DROP TABLE IF EXISTS `peluang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peluang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kriteria` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peluang`
--

LOCK TABLES `peluang` WRITE;
/*!40000 ALTER TABLE `peluang` DISABLE KEYS */;
INSERT INTO `peluang` VALUES (1,'1','Sangat Kecil','Peristiwa kemungkinan terjadi pada beberapa sebagian kecil kondisi <30%',NULL,NULL,'2019-04-09 07:41:58','2019-04-09 07:41:58'),(2,'2','Kecil','Peristiwa kemungkinan terjadi pada beberapa kondisi (Prosentase > 20%-50%)',NULL,NULL,'2019-04-09 07:41:58','2019-04-09 07:41:58'),(3,'3','Sedang','Peristiwa kemungkinan terjadi pada sebagian besar kondisi (Prosentase > 50%-70%)',NULL,NULL,'2019-04-09 07:41:58','2019-04-09 07:41:58'),(4,'4','Besar','Peristiwa kemungkinan terjadi pada hampir semua kondisi (Prosentase > 70%-80%)',NULL,NULL,'2019-04-09 07:41:58','2019-04-09 07:41:58'),(5,'5','Sangat Besar','Peristiwa kemungkinan terjadi pada semua kondisi (Prosentase > 90%)',NULL,NULL,'2019-04-09 07:41:58','2019-04-09 07:41:58');
/*!40000 ALTER TABLE `peluang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perioderisikobisnis`
--

DROP TABLE IF EXISTS `perioderisikobisnis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perioderisikobisnis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `aktif` int(11) NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perioderisikobisnis`
--

LOCK TABLES `perioderisikobisnis` WRITE;
/*!40000 ALTER TABLE `perioderisikobisnis` DISABLE KEYS */;
INSERT INTO `perioderisikobisnis` VALUES (1,'Kwartal I 2019','2019-01-01','2019-03-31',1,'admin','','2019-04-22 20:32:27','2019-04-22 20:32:27'),(2,'Kwartal II 2019','2019-04-01','2019-06-30',0,'admin','','2019-04-22 20:32:27','2019-04-22 20:32:27');
/*!40000 ALTER TABLE `perioderisikobisnis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'edit risiko','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(2,'delete risiko','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(3,'add risiko','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(4,'validasi risiko','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(5,'kaidah risiko','web','2019-04-21 20:32:32','2019-04-21 20:32:32');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risikobisnis`
--

DROP TABLE IF EXISTS `risikobisnis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risikobisnis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `periode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `statusrisiko_id` int(10) unsigned NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risikobisnis`
--

LOCK TABLES `risikobisnis` WRITE;
/*!40000 ALTER TABLE `risikobisnis` DISABLE KEYS */;
INSERT INTO `risikobisnis` VALUES (1,'Kwartal I','2019',1,1,'1','','2019-04-01 19:20:28','2019-04-01 19:20:28');
/*!40000 ALTER TABLE `risikobisnis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risikobisnisdetail`
--

DROP TABLE IF EXISTS `risikobisnisdetail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risikobisnisdetail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `risikobisnis_id` int(10) unsigned NOT NULL,
  `kpi_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `risiko` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `akibat` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `klasifikasi_id` int(10) unsigned NOT NULL,
  `peluang_id` int(10) unsigned NOT NULL,
  `dampak_id` int(10) unsigned NOT NULL,
  `warna` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `indikator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilaiambang` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kaidah` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tglkaidah` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risikobisnisdetail`
--

LOCK TABLES `risikobisnisdetail` WRITE;
/*!40000 ALTER TABLE `risikobisnisdetail` DISABLE KEYS */;
INSERT INTO `risikobisnisdetail` VALUES (1,1,'1','Risiko1','',1,1,1,'Hijau','1','10',NULL,NULL,NULL,NULL,'2019-04-09 19:35:10','2019-04-09 19:35:10'),(2,1,'2','Risiko2','',2,2,2,'Biru','2','20',NULL,NULL,NULL,NULL,'2019-04-09 19:35:10','2019-04-09 19:35:10'),(3,1,'3','Risiko3','',3,3,3,'Kuning','3','30',NULL,NULL,NULL,NULL,'2019-04-09 19:35:10','2019-04-09 19:35:10');
/*!40000 ALTER TABLE `risikobisnisdetail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(1,5),(2,1),(2,5),(3,1),(3,5),(4,1),(4,2),(4,3),(4,4),(4,5),(5,2),(5,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'keyperson','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(2,'verifikatur','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(3,'pimpinanunit','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(4,'managergcg','web','2019-04-21 20:32:32','2019-04-21 20:32:32'),(5,'superadmin','web','2019-04-21 20:32:32','2019-04-21 20:32:32');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statusrisiko`
--

DROP TABLE IF EXISTS `statusrisiko`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statusrisiko` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statusrisiko`
--

LOCK TABLES `statusrisiko` WRITE;
/*!40000 ALTER TABLE `statusrisiko` DISABLE KEYS */;
INSERT INTO `statusrisiko` VALUES (1,'Validasi Verifikatur','2019-04-01 02:11:44','2019-04-01 02:11:44'),(2,'Validasi Atasan','2019-04-01 02:11:44','2019-04-01 02:11:44'),(3,'Validasi GCG RM','2019-04-01 02:11:44','2019-04-01 02:11:44'),(4,'Selesai','2019-04-01 02:11:44','2019-04-01 02:11:44');
/*!40000 ALTER TABLE `statusrisiko` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `statusvalidasi`
--

DROP TABLE IF EXISTS `statusvalidasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statusvalidasi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `statusvalidasi`
--

LOCK TABLES `statusvalidasi` WRITE;
/*!40000 ALTER TABLE `statusvalidasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `statusvalidasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sumberrisiko`
--

DROP TABLE IF EXISTS `sumberrisiko`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sumberrisiko` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `risikobisnisdetail_id` int(10) unsigned NOT NULL,
  `namasumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mitigasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `statussumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sumberrisiko`
--

LOCK TABLES `sumberrisiko` WRITE;
/*!40000 ALTER TABLE `sumberrisiko` DISABLE KEYS */;
INSERT INTO `sumberrisiko` VALUES (1,1,'Nama sumber 1','mitigasi 1','1000','2019-04-01','2019-04-07','Afgan','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(2,1,'Nama sumber 2','mitigasi 2','2000','2019-04-07','2019-04-10','Beni','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(3,1,'Nama sumber 3','mitigasi 3','3000','2019-04-10','2019-04-13','Furqon','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(4,2,'Nama sumber 4','mitigasi 4','4000','2019-04-13','2019-04-15','Kurob','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(5,2,'Nama sumber 5','mitigasi 5','5000','2019-04-15','2019-04-17','Arga','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(6,2,'Nama sumber 6','mitigasi 6','6000','2019-04-17','2019-04-20','Sumi','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(7,3,'Nama sumber 7','mitigasi 7','7000','2019-04-20','2019-04-23','Fahru','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(8,3,'Nama sumber 8','mitigasi 8','8000','2019-04-23','2019-04-25','Feri','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46'),(9,3,'Nama sumber 9','mitigasi 9','9000','2019-04-25','2019-04-27','Rendi','ok',NULL,NULL,'2019-04-10 00:39:46','2019-04-10 00:39:46');
/*!40000 ALTER TABLE `sumberrisiko` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unitkerja`
--

DROP TABLE IF EXISTS `unitkerja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unitkerja` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kodecc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `namacc` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `creator` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modifier` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unitkerja`
--

LOCK TABLES `unitkerja` WRITE;
/*!40000 ALTER TABLE `unitkerja` DISABLE KEYS */;
INSERT INTO `unitkerja` VALUES (1,'zxcz','zxc','zzxcz','','','',NULL,NULL),(2,'zxcz','zxc','zxcz','','','',NULL,NULL),(3,'yyyy','yyy','yyy','','','',NULL,NULL);
/*!40000 ALTER TABLE `unitkerja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin Simaris','admin@simaris.com','$2y$10$2bxTd22UzsDHpaLwDGG0OeJXOHvRJShbsxCYIQ7guTiY7eR5JMWsi',NULL,'2019-03-31 19:22:59','2019-03-31 19:22:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `validasibisnis`
--

DROP TABLE IF EXISTS `validasibisnis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `validasibisnis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `risikobisnis_id` int(10) unsigned NOT NULL,
  `nik` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktorvalidasi_id` int(10) unsigned NOT NULL,
  `statusvalidasi_id` int(10) unsigned NOT NULL,
  `tglvalidasi` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `validasibisnis`
--

LOCK TABLES `validasibisnis` WRITE;
/*!40000 ALTER TABLE `validasibisnis` DISABLE KEYS */;
/*!40000 ALTER TABLE `validasibisnis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'simaris'
--
