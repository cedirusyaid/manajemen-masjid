-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: masjidagung_db
-- ------------------------------------------------------
-- Server version	10.11.14-MariaDB-0ubuntu0.24.04.1

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
-- Table structure for table `log_activities`
--

DROP TABLE IF EXISTS `log_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_activities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` char(36) DEFAULT NULL,
  `action` varchar(50) NOT NULL,
  `table_name` varchar(50) NOT NULL,
  `record_id` char(36) NOT NULL,
  `before_data` longtext DEFAULT NULL,
  `after_data` longtext DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_log_activities_user` (`user_id`),
  KEY `idx_log_activities_created` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_activities`
--

LOCK TABLES `log_activities` WRITE;
/*!40000 ALTER TABLE `log_activities` DISABLE KEYS */;
INSERT INTO `log_activities` VALUES
(1,NULL,'REGISTER_OAUTH','sys_users','56214dac-0b25-4f73-9ebf-56898fb1cacf',NULL,'{\"username\":\"uttibatu\",\"email\":\"uttibatu@gmail.com\",\"google_id\":\"115602050499397318502\",\"avatar\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocIaRWkI_pdC1XTRz4z2_1FmcdhsvLS4XN_6KkepmSEGsGeM_xp70g=s96-c\",\"role_id\":5,\"status\":\"active\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 10:57:03'),
(2,'56214dac-0b25-4f73-9ebf-56898fb1cacf','LOGIN','sys_users','56214dac-0b25-4f73-9ebf-56898fb1cacf',NULL,'{\"email\":\"uttibatu@gmail.com\",\"method\":\"google\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 10:57:03'),
(3,'56214dac-0b25-4f73-9ebf-56898fb1cacf','LOGOUT','sys_users','56214dac-0b25-4f73-9ebf-56898fb1cacf',NULL,'{\"username\":\"uttibatu\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 11:07:20'),
(4,'56214dac-0b25-4f73-9ebf-56898fb1cacf','LOGIN','sys_users','56214dac-0b25-4f73-9ebf-56898fb1cacf',NULL,'{\"email\":\"uttibatu@gmail.com\",\"method\":\"google\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 11:07:23'),
(5,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','mst_kegiatan','c4c4ada1-9498-4563-a69b-b61ea2c106cb',NULL,'{\"nama_kegiatan\":\"Panitia Pembangunan Masjid \",\"tanggal_mulai\":\"2026-02-27\",\"tanggal_selesai\":\"2030-02-27\",\"deskripsi\":\"\",\"status\":\"berjalan\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 11:41:23'),
(6,'56214dac-0b25-4f73-9ebf-56898fb1cacf','LOGIN','sys_users','56214dac-0b25-4f73-9ebf-56898fb1cacf',NULL,'{\"email\":\"uttibatu@gmail.com\",\"method\":\"google\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 15:44:47'),
(7,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','mst_periode_pengurus','10a8b50b-3bff-4e37-b402-424696afb24a',NULL,'{\"nama_periode\":\"Periode 2026-2030\",\"tahun_mulai\":\"2026\",\"tahun_selesai\":\"2030\",\"status\":\"aktif\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:02:40'),
(8,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_pengurus','ecf72b38-f043-4051-bc62-0833a5e0805e',NULL,'{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"personil_id\":\"e1c316fc-f674-11ea-adc1-0242ac120002\",\"parent_id\":null,\"jabatan\":\"Pembina\",\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:03:04'),
(9,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_pengurus','610b057d-5127-4cb0-b89c-137b4bf1bf18',NULL,'{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"personil_id\":\"e1c315e4-f674-11ea-adc1-0242ac120002\",\"parent_id\":null,\"jabatan\":\"Ketua\",\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:03:21'),
(10,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_pengurus','c3628b31-f2a7-4939-bc81-61dd57f0b967',NULL,'{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"personil_id\":\"e1c312d8-f674-11ea-adc1-0242ac120002\",\"parent_id\":\"610b057d-5127-4cb0-b89c-137b4bf1bf18\",\"jabatan\":\"Bidang Pembinaan\",\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:03:45'),
(11,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_panitia','abbb4f4a-1cca-4798-a22c-d35398029861',NULL,'{\"kegiatan_id\":\"c4c4ada1-9498-4563-a69b-b61ea2c106cb\",\"personil_id\":\"e1c315e4-f674-11ea-adc1-0242ac120002\",\"parent_id\":null,\"jabatan\":\"Ketua PAnitia\",\"tugas\":\"\",\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:10:19'),
(12,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_panitia','e0b00d48-28bf-46c5-ab1c-719d74bd509d',NULL,'{\"kegiatan_id\":\"c4c4ada1-9498-4563-a69b-b61ea2c106cb\",\"personil_id\":\"e1c316fc-f674-11ea-adc1-0242ac120002\",\"parent_id\":null,\"jabatan\":\"Wakil Ketua\",\"tugas\":\"\",\"urutan\":2}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:11:01'),
(13,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_jabatan_periode','a515fc22-2e97-4609-b736-23eafac4663e',NULL,'{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"nama_jabatan\":\"Pembina\",\"parent_id\":null,\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:21:17'),
(14,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_jabatan_periode','dbaee0a9-22c7-4f30-a844-1e14733f20b8',NULL,'{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"nama_jabatan\":\"Ketua\",\"parent_id\":null,\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:21:27'),
(15,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_jabatan_periode','837ce890-fbda-45e4-af62-c623e171f57f',NULL,'{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"nama_jabatan\":\"Sekertaris\",\"parent_id\":null,\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:21:38'),
(16,'56214dac-0b25-4f73-9ebf-56898fb1cacf','INSERT','trn_pengurus','a70132f6-aa2f-4d50-b29b-fedbca01f961',NULL,'{\"jabatan_periode_id\":\"dbaee0a9-22c7-4f30-a844-1e14733f20b8\",\"personil_id\":\"e1c316fc-f674-11ea-adc1-0242ac120002\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:35:56'),
(17,'56214dac-0b25-4f73-9ebf-56898fb1cacf','UPDATE','trn_jabatan_periode','837ce890-fbda-45e4-af62-c623e171f57f','{\"id\":\"837ce890-fbda-45e4-af62-c623e171f57f\",\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"nama_jabatan\":\"Sekertaris\",\"parent_id\":null,\"urutan\":\"1\",\"created_at\":\"2026-06-19 16:21:38\",\"updated_at\":\"2026-06-19 16:21:38\",\"deleted_at\":null}','{\"periode_id\":\"10a8b50b-3bff-4e37-b402-424696afb24a\",\"nama_jabatan\":\"Sekertaris\",\"parent_id\":\"dbaee0a9-22c7-4f30-a844-1e14733f20b8\",\"urutan\":1}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 16:40:02'),
(18,'56214dac-0b25-4f73-9ebf-56898fb1cacf','LOGIN','sys_users','56214dac-0b25-4f73-9ebf-56898fb1cacf',NULL,'{\"email\":\"uttibatu@gmail.com\",\"method\":\"google\"}','::1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','2026-06-19 22:38:57');
/*!40000 ALTER TABLE `log_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_telegram`
--

DROP TABLE IF EXISTS `log_telegram`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_telegram` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bot_action` varchar(100) NOT NULL,
  `request_data` text DEFAULT NULL,
  `response_data` text DEFAULT NULL,
  `status` enum('success','failed') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_telegram`
--

LOCK TABLES `log_telegram` WRITE;
/*!40000 ALTER TABLE `log_telegram` DISABLE KEYS */;
/*!40000 ALTER TABLE `log_telegram` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_agenda`
--

DROP TABLE IF EXISTS `mst_agenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_agenda` (
  `id` char(36) NOT NULL,
  `kegiatan_id` char(36) DEFAULT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `lokasi` varchar(255) DEFAULT 'Masjid Agung Sinjai',
  `narasumber_id` char(36) DEFAULT NULL,
  `narasumber` varchar(150) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_mst_agenda_tanggal` (`tanggal`),
  KEY `fk_agenda_narasumber` (`narasumber_id`),
  KEY `fk_agenda_kegiatan` (`kegiatan_id`),
  CONSTRAINT `fk_agenda_kegiatan` FOREIGN KEY (`kegiatan_id`) REFERENCES `mst_kegiatan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_agenda_narasumber` FOREIGN KEY (`narasumber_id`) REFERENCES `mst_personil` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_agenda`
--

LOCK TABLES `mst_agenda` WRITE;
/*!40000 ALTER TABLE `mst_agenda` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_agenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_berita`
--

DROP TABLE IF EXISTS `mst_berita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_berita` (
  `id` char(36) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `konten` longtext NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_by` char(36) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_mst_berita_slug` (`slug`),
  KEY `idx_mst_berita_status` (`status`),
  KEY `fk_mst_berita_creator` (`created_by`),
  CONSTRAINT `fk_mst_berita_creator` FOREIGN KEY (`created_by`) REFERENCES `sys_users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_berita`
--

LOCK TABLES `mst_berita` WRITE;
/*!40000 ALTER TABLE `mst_berita` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_berita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_imam_khatib`
--

DROP TABLE IF EXISTS `mst_imam_khatib`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_imam_khatib` (
  `id` char(36) NOT NULL,
  `personil_id` char(36) NOT NULL,
  `jabatan` enum('imam','khatib','muadzin','imam_khatib') NOT NULL,
  `bio` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_imam_personil` (`personil_id`),
  CONSTRAINT `fk_imam_personil` FOREIGN KEY (`personil_id`) REFERENCES `mst_personil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_imam_khatib`
--

LOCK TABLES `mst_imam_khatib` WRITE;
/*!40000 ALTER TABLE `mst_imam_khatib` DISABLE KEYS */;
INSERT INTO `mst_imam_khatib` VALUES
('e1c312d8-f674-11ea-adc1-0242ac120002','e1c312d8-f674-11ea-adc1-0242ac120002','imam_khatib','Dosen Agama Islam dan Penulis Buku Tafsir','2026-06-19 14:11:52',NULL,NULL),
('e1c314cc-f674-11ea-adc1-0242ac120002','e1c314cc-f674-11ea-adc1-0242ac120002','khatib','Pimpinan Pondok Pesantren di Sinjai','2026-06-19 14:11:52',NULL,NULL),
('e1c315e4-f674-11ea-adc1-0242ac120002','e1c315e4-f674-11ea-adc1-0242ac120002','imam','Hafidz 30 Juz Al-Qur\'an','2026-06-19 14:11:52',NULL,NULL),
('e1c316fc-f674-11ea-adc1-0242ac120002','e1c316fc-f674-11ea-adc1-0242ac120002','muadzin','Muadzin Tetap Masjid Agung Sinjai','2026-06-19 14:11:52',NULL,NULL);
/*!40000 ALTER TABLE `mst_imam_khatib` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_kegiatan`
--

DROP TABLE IF EXISTS `mst_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_kegiatan` (
  `id` char(36) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('rencana','berjalan','selesai','dibatalkan') DEFAULT 'rencana',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_mst_kegiatan_tanggal` (`tanggal_mulai`),
  KEY `idx_mst_kegiatan_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_kegiatan`
--

LOCK TABLES `mst_kegiatan` WRITE;
/*!40000 ALTER TABLE `mst_kegiatan` DISABLE KEYS */;
INSERT INTO `mst_kegiatan` VALUES
('c4c4ada1-9498-4563-a69b-b61ea2c106cb','Panitia Pembangunan Masjid ','2026-02-27','2030-02-27','','berjalan','2026-06-19 11:41:23','2026-06-19 11:41:23',NULL);
/*!40000 ALTER TABLE `mst_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_kelompok_kegiatan`
--

DROP TABLE IF EXISTS `mst_kelompok_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_kelompok_kegiatan` (
  `id` char(36) NOT NULL,
  `kegiatan_id` char(36) NOT NULL,
  `nama_kelompok` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kegiatan_id_idx` (`kegiatan_id`),
  CONSTRAINT `fk_kelompok_kegiatan` FOREIGN KEY (`kegiatan_id`) REFERENCES `mst_kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_kelompok_kegiatan`
--

LOCK TABLES `mst_kelompok_kegiatan` WRITE;
/*!40000 ALTER TABLE `mst_kelompok_kegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `mst_kelompok_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_periode_pengurus`
--

DROP TABLE IF EXISTS `mst_periode_pengurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_periode_pengurus` (
  `id` char(36) NOT NULL,
  `nama_periode` varchar(100) NOT NULL,
  `tahun_mulai` int(11) NOT NULL,
  `tahun_selesai` int(11) NOT NULL,
  `status` enum('aktif','tidak_aktif') DEFAULT 'tidak_aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_mst_periode_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_periode_pengurus`
--

LOCK TABLES `mst_periode_pengurus` WRITE;
/*!40000 ALTER TABLE `mst_periode_pengurus` DISABLE KEYS */;
INSERT INTO `mst_periode_pengurus` VALUES
('10a8b50b-3bff-4e37-b402-424696afb24a','Periode 2026-2030',2026,2030,'aktif','2026-06-19 16:02:40','2026-06-19 16:02:40',NULL);
/*!40000 ALTER TABLE `mst_periode_pengurus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_personil`
--

DROP TABLE IF EXISTS `mst_personil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_personil` (
  `id` char(36) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT 'L',
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tipe_default` set('jamaah','pengurus','panitia','ustadz','petugas') DEFAULT 'jamaah',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_personil_nama` (`nama`),
  KEY `idx_personil_no_hp` (`no_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_personil`
--

LOCK TABLES `mst_personil` WRITE;
/*!40000 ALTER TABLE `mst_personil` DISABLE KEYS */;
INSERT INTO `mst_personil` VALUES
('e1c312d8-f674-11ea-adc1-0242ac120002','Ustadz DR. H. Muh. Yahya, M.A.',NULL,'081234567890',NULL,'L',NULL,NULL,'ustadz,petugas','2026-06-19 17:45:06',NULL,NULL),
('e1c314cc-f674-11ea-adc1-0242ac120002','KH. Rasyid Bakri',NULL,'081234567891',NULL,'L',NULL,NULL,'ustadz,petugas','2026-06-19 17:45:06',NULL,NULL),
('e1c315e4-f674-11ea-adc1-0242ac120002','Ustadz Ahmad Fauzi, S.Pd.I',NULL,'081234567892',NULL,'L',NULL,NULL,'ustadz,petugas','2026-06-19 17:45:06',NULL,NULL),
('e1c316fc-f674-11ea-adc1-0242ac120002','Muh. Bilal',NULL,'081234567893',NULL,'L',NULL,NULL,'ustadz,petugas','2026-06-19 17:45:06',NULL,NULL);
/*!40000 ALTER TABLE `mst_personil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_rekening`
--

DROP TABLE IF EXISTS `mst_rekening`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `mst_rekening` (
  `id` char(36) NOT NULL,
  `nama_bank` varchar(100) NOT NULL,
  `nomor_rekening` varchar(50) DEFAULT NULL,
  `atas_nama` varchar(150) DEFAULT NULL,
  `jenis` enum('transfer','qris') NOT NULL DEFAULT 'transfer',
  `logo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_rekening`
--

LOCK TABLES `mst_rekening` WRITE;
/*!40000 ALTER TABLE `mst_rekening` DISABLE KEYS */;
INSERT INTO `mst_rekening` VALUES
('e8b0933e-ce8a-4933-911b-7a3c79a94111','BSI','7078909876','Kas Masjid','transfer',NULL,'active','2026-06-19 23:38:12','2026-06-19 23:38:12',NULL),
('e8b0933e-ce8a-4933-911b-7a3c79a94112','Bank Sulselbar','0602010000123','Panitia Pembangunan Masjid','transfer',NULL,'active','2026-06-19 23:38:12','2026-06-19 23:38:12',NULL),
('e8b0933e-ce8a-4933-911b-7a3c79a94113','QRIS','MasjidAgungSinjaiInfaqDigital','Infaq Digital Masjid','qris',NULL,'active','2026-06-19 23:38:12','2026-06-19 23:38:12',NULL);
/*!40000 ALTER TABLE `mst_rekening` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_roles`
--

DROP TABLE IF EXISTS `sys_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_roles`
--

LOCK TABLES `sys_roles` WRITE;
/*!40000 ALTER TABLE `sys_roles` DISABLE KEYS */;
INSERT INTO `sys_roles` VALUES
(1,'Super Admin','Akses penuh terhadap sistem dan pengaturan website'),
(2,'Admin Keuangan','Akses khusus untuk pencatatan keuangan dan konfirmasi ZIS'),
(3,'Admin TPA','Akses pengolahan santri dan pendaftaran TPA'),
(4,'Admin Layanan','Akses validasi pengajuan acara dan layanan jenazah'),
(5,'Jemaah','Pengguna umum / jemaah dengan akses fitur layanan publik');
/*!40000 ALTER TABLE `sys_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_settings`
--

DROP TABLE IF EXISTS `sys_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_settings` (
  `key` varchar(50) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(50) DEFAULT 'general',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_settings`
--

LOCK TABLES `sys_settings` WRITE;
/*!40000 ALTER TABLE `sys_settings` DISABLE KEYS */;
INSERT INTO `sys_settings` VALUES
('active_theme','default','general','2026-06-19 23:27:02','2026-06-19 23:27:02'),
('contact_email','info@masjidagungnujumulittihad.or.id','contact','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('contact_phone','(0482) 21009','contact','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('donation_bsi_holder','Kas Masjid','donation','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('donation_bsi_number','7078909876','donation','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('donation_sulselbar_holder','Panitia Pembangunan Masjid','donation','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('donation_sulselbar_number','0602010000123','donation','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('qris_data','MasjidAgungSinjaiInfaqDigital','donation','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('sholat_kota_id','2616','general','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('site_address','Jl. Persatuan Raya No.109, Balangnipa, Kec. Sinjai Utara, Kabupaten Sinjai, Sulawesi Selatan 92611','general','2026-06-19 23:20:12','2026-06-19 23:20:12'),
('site_name','Masjid Agung Nujumul Ittihad Sinjai','general','2026-06-19 23:20:12','2026-06-19 23:20:12');
/*!40000 ALTER TABLE `sys_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_users`
--

DROP TABLE IF EXISTS `sys_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sys_users` (
  `id` char(36) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `personil_id` char(36) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_sys_users_username` (`username`),
  UNIQUE KEY `idx_sys_users_email` (`email`),
  KEY `idx_sys_users_role` (`role_id`),
  KEY `idx_sys_users_google` (`google_id`),
  KEY `fk_sys_users_personil` (`personil_id`),
  CONSTRAINT `fk_sys_users_personil` FOREIGN KEY (`personil_id`) REFERENCES `mst_personil` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_sys_users_role` FOREIGN KEY (`role_id`) REFERENCES `sys_roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_users`
--

LOCK TABLES `sys_users` WRITE;
/*!40000 ALTER TABLE `sys_users` DISABLE KEYS */;
INSERT INTO `sys_users` VALUES
('56214dac-0b25-4f73-9ebf-56898fb1cacf','uttibatu',NULL,'uttibatu@gmail.com','115602050499397318502','https://lh3.googleusercontent.com/a/ACg8ocIaRWkI_pdC1XTRz4z2_1FmcdhsvLS4XN_6KkepmSEGsGeM_xp70g=s96-c',NULL,1,'active','2026-06-19 10:57:03','2026-06-19 19:07:11',NULL),
('a0f074d2-f674-11ea-adc1-0242ac120002','admin','$2y$10$vO/qJ7YgE0bJkG.m9g.mLeI55oH8i.QhR2B5G.Z1C3U.j0o8lF20i','admin@masjidagung.or.id',NULL,NULL,NULL,1,'active','2026-06-19 14:01:28',NULL,NULL);
/*!40000 ALTER TABLE `sys_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_anggota_kelompok`
--

DROP TABLE IF EXISTS `trn_anggota_kelompok`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_anggota_kelompok` (
  `id` char(36) NOT NULL,
  `kelompok_id` char(36) NOT NULL,
  `personil_id` char(36) NOT NULL,
  `peran` varchar(100) DEFAULT 'Anggota',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kelompok_id_idx` (`kelompok_id`),
  KEY `personil_id_idx` (`personil_id`),
  CONSTRAINT `fk_anggota_kelompok` FOREIGN KEY (`kelompok_id`) REFERENCES `mst_kelompok_kegiatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_anggota_personil` FOREIGN KEY (`personil_id`) REFERENCES `mst_personil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_anggota_kelompok`
--

LOCK TABLES `trn_anggota_kelompok` WRITE;
/*!40000 ALTER TABLE `trn_anggota_kelompok` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_anggota_kelompok` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_jabatan_kegiatan`
--

DROP TABLE IF EXISTS `trn_jabatan_kegiatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_jabatan_kegiatan` (
  `id` char(36) NOT NULL,
  `kegiatan_id` char(36) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `tugas` text DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jabatan_kegiatan_ref` (`kegiatan_id`),
  KEY `fk_jabatan_kegiatan_parent` (`parent_id`),
  CONSTRAINT `fk_jabatan_kegiatan_parent` FOREIGN KEY (`parent_id`) REFERENCES `trn_jabatan_kegiatan` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_jabatan_kegiatan_ref` FOREIGN KEY (`kegiatan_id`) REFERENCES `mst_kegiatan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_jabatan_kegiatan`
--

LOCK TABLES `trn_jabatan_kegiatan` WRITE;
/*!40000 ALTER TABLE `trn_jabatan_kegiatan` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_jabatan_kegiatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_jabatan_periode`
--

DROP TABLE IF EXISTS `trn_jabatan_periode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_jabatan_periode` (
  `id` char(36) NOT NULL,
  `periode_id` char(36) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `parent_id` char(36) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_jabatan_periode_ref` (`periode_id`),
  KEY `fk_jabatan_periode_parent` (`parent_id`),
  CONSTRAINT `fk_jabatan_periode_parent` FOREIGN KEY (`parent_id`) REFERENCES `trn_jabatan_periode` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_jabatan_periode_ref` FOREIGN KEY (`periode_id`) REFERENCES `mst_periode_pengurus` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_jabatan_periode`
--

LOCK TABLES `trn_jabatan_periode` WRITE;
/*!40000 ALTER TABLE `trn_jabatan_periode` DISABLE KEYS */;
INSERT INTO `trn_jabatan_periode` VALUES
('837ce890-fbda-45e4-af62-c623e171f57f','10a8b50b-3bff-4e37-b402-424696afb24a','Sekertaris','dbaee0a9-22c7-4f30-a844-1e14733f20b8',1,'2026-06-19 16:21:38','2026-06-19 16:40:02',NULL),
('a515fc22-2e97-4609-b736-23eafac4663e','10a8b50b-3bff-4e37-b402-424696afb24a','Pembina',NULL,1,'2026-06-19 16:21:17','2026-06-19 16:21:17',NULL),
('dbaee0a9-22c7-4f30-a844-1e14733f20b8','10a8b50b-3bff-4e37-b402-424696afb24a','Ketua',NULL,1,'2026-06-19 16:21:27','2026-06-19 16:21:27',NULL);
/*!40000 ALTER TABLE `trn_jabatan_periode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_jadwal_jumat`
--

DROP TABLE IF EXISTS `trn_jadwal_jumat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_jadwal_jumat` (
  `id` char(36) NOT NULL,
  `tanggal` date NOT NULL,
  `khatib_id` char(36) NOT NULL,
  `imam_id` char(36) NOT NULL,
  `muadzin_id` char(36) NOT NULL,
  `judul_khotbah` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_trn_jumat_tanggal` (`tanggal`),
  KEY `fk_trn_jumat_imam` (`imam_id`),
  KEY `fk_trn_jumat_khatib` (`khatib_id`),
  KEY `fk_trn_jumat_muadzin` (`muadzin_id`),
  CONSTRAINT `fk_jumat_imam` FOREIGN KEY (`imam_id`) REFERENCES `mst_imam_khatib` (`id`),
  CONSTRAINT `fk_jumat_khatib` FOREIGN KEY (`khatib_id`) REFERENCES `mst_imam_khatib` (`id`),
  CONSTRAINT `fk_jumat_muadzin` FOREIGN KEY (`muadzin_id`) REFERENCES `mst_imam_khatib` (`id`),
  CONSTRAINT `fk_trn_jumat_imam` FOREIGN KEY (`imam_id`) REFERENCES `mst_imam_khatib` (`id`),
  CONSTRAINT `fk_trn_jumat_khatib` FOREIGN KEY (`khatib_id`) REFERENCES `mst_imam_khatib` (`id`),
  CONSTRAINT `fk_trn_jumat_muadzin` FOREIGN KEY (`muadzin_id`) REFERENCES `mst_imam_khatib` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_jadwal_jumat`
--

LOCK TABLES `trn_jadwal_jumat` WRITE;
/*!40000 ALTER TABLE `trn_jadwal_jumat` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_jadwal_jumat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_keuangan`
--

DROP TABLE IF EXISTS `trn_keuangan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_keuangan` (
  `id` char(36) NOT NULL,
  `kegiatan_id` char(36) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `kategori` enum('operasional','pembangunan','zis','sosial') NOT NULL,
  `tipe` enum('masuk','keluar') NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `penanggung_jawab` varchar(100) DEFAULT NULL,
  `bukti_transaksi` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_trn_keuangan_tanggal` (`tanggal`),
  KEY `idx_trn_keuangan_tipe` (`tipe`),
  KEY `fk_keuangan_kegiatan` (`kegiatan_id`),
  CONSTRAINT `fk_keuangan_kegiatan` FOREIGN KEY (`kegiatan_id`) REFERENCES `mst_kegiatan` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_keuangan`
--

LOCK TABLES `trn_keuangan` WRITE;
/*!40000 ALTER TABLE `trn_keuangan` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_keuangan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_panitia`
--

DROP TABLE IF EXISTS `trn_panitia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_panitia` (
  `id` char(36) NOT NULL,
  `jabatan_kegiatan_id` char(36) NOT NULL,
  `personil_id` char(36) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_panitia_jabatan` (`jabatan_kegiatan_id`),
  KEY `fk_panitia_personil` (`personil_id`),
  CONSTRAINT `fk_panitia_jabatan` FOREIGN KEY (`jabatan_kegiatan_id`) REFERENCES `trn_jabatan_kegiatan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_panitia_personil` FOREIGN KEY (`personil_id`) REFERENCES `mst_personil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_panitia`
--

LOCK TABLES `trn_panitia` WRITE;
/*!40000 ALTER TABLE `trn_panitia` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_panitia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_pendaftaran_tpa`
--

DROP TABLE IF EXISTS `trn_pendaftaran_tpa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_pendaftaran_tpa` (
  `id` char(36) NOT NULL,
  `nama_santri` varchar(150) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `nama_wali` varchar(150) NOT NULL,
  `no_hp_wali` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `status_pendaftaran` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_trn_tpa_status` (`status_pendaftaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_pendaftaran_tpa`
--

LOCK TABLES `trn_pendaftaran_tpa` WRITE;
/*!40000 ALTER TABLE `trn_pendaftaran_tpa` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_pendaftaran_tpa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_pengajuan_acara`
--

DROP TABLE IF EXISTS `trn_pengajuan_acara`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_pengajuan_acara` (
  `id` char(36) NOT NULL,
  `nama_pemohon` varchar(150) NOT NULL,
  `instansi` varchar(150) DEFAULT NULL,
  `nama_acara` varchar(255) NOT NULL,
  `tanggal_acara` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `surat_permohonan` varchar(255) DEFAULT NULL,
  `status_persetujuan` enum('pending','disetujui','ditolak') DEFAULT 'pending',
  `catatan_admin` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_trn_acara_tanggal` (`tanggal_acara`),
  KEY `idx_trn_acara_status` (`status_persetujuan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_pengajuan_acara`
--

LOCK TABLES `trn_pengajuan_acara` WRITE;
/*!40000 ALTER TABLE `trn_pengajuan_acara` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_pengajuan_acara` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_pengurus`
--

DROP TABLE IF EXISTS `trn_pengurus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_pengurus` (
  `id` char(36) NOT NULL,
  `jabatan_periode_id` char(36) NOT NULL,
  `personil_id` char(36) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pengurus_jabatan` (`jabatan_periode_id`),
  KEY `fk_pengurus_personil` (`personil_id`),
  CONSTRAINT `fk_pengurus_jabatan` FOREIGN KEY (`jabatan_periode_id`) REFERENCES `trn_jabatan_periode` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_pengurus_personil` FOREIGN KEY (`personil_id`) REFERENCES `mst_personil` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_pengurus`
--

LOCK TABLES `trn_pengurus` WRITE;
/*!40000 ALTER TABLE `trn_pengurus` DISABLE KEYS */;
INSERT INTO `trn_pengurus` VALUES
('a70132f6-aa2f-4d50-b29b-fedbca01f961','dbaee0a9-22c7-4f30-a844-1e14733f20b8','e1c316fc-f674-11ea-adc1-0242ac120002','2026-06-19 16:35:56','2026-06-19 16:35:56',NULL);
/*!40000 ALTER TABLE `trn_pengurus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_zis`
--

DROP TABLE IF EXISTS `trn_zis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `trn_zis` (
  `id` char(36) NOT NULL,
  `nama_donatur` varchar(150) DEFAULT 'Hamba Allah',
  `nominal` decimal(15,2) NOT NULL,
  `jenis` enum('zakat_fitrah','zakat_maal','infaq','sedekah','wakaf') NOT NULL,
  `metode_pembayaran` enum('qris','transfer_bank','tunai') NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') DEFAULT 'pending',
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_trn_zis_status` (`status_verifikasi`),
  KEY `idx_trn_zis_jenis` (`jenis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_zis`
--

LOCK TABLES `trn_zis` WRITE;
/*!40000 ALTER TABLE `trn_zis` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_zis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'masjidagung_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-14  9:40:02
