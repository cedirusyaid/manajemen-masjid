/*M!999999\- enable the sandbox mode */ 
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

-- Dump completed on 2026-09-14  9:40:05
/*M!999999\- enable the sandbox mode */ 
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
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-14  9:40:05
