-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table dggroup.dg_article
CREATE TABLE IF NOT EXISTS `dg_article` (
  `id_dg_article` int(11) NOT NULL AUTO_INCREMENT,
  `judul_article` varchar(100) DEFAULT NULL,
  `id_author` int(11) DEFAULT NULL,
  `banner_utama` text,
  `isi_article_pembuka` text,
  `quotes` varchar(350) DEFAULT NULL,
  `author_quotes` varchar(150) DEFAULT NULL,
  `banner1` text,
  `banner2` text,
  `isi_article` text,
  `view_count` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_article`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_article_category
CREATE TABLE IF NOT EXISTS `dg_article_category` (
  `id_dg_article_category` int(11) NOT NULL AUTO_INCREMENT,
  `nama_category` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `id_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_article_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_article_category_m
CREATE TABLE IF NOT EXISTS `dg_article_category_m` (
  `id_dg_article_category_m` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_article` int(11) DEFAULT NULL,
  `id_dg_article_category` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_article_category_m`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_article_tags
CREATE TABLE IF NOT EXISTS `dg_article_tags` (
  `id_dg_article_tags` int(11) NOT NULL AUTO_INCREMENT,
  `nama_tags` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `id_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_article_tags`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_article_tags_m
CREATE TABLE IF NOT EXISTS `dg_article_tags_m` (
  `id_dg_article_tags_m` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_article` int(11) DEFAULT NULL,
  `id_dg_article_tags` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_article_tags_m`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_chat
CREATE TABLE IF NOT EXISTS `dg_chat` (
  `id_dg_chat` int(11) DEFAULT NULL,
  `id_user1` int(11) DEFAULT NULL,
  `id_user2` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_chat_ai
CREATE TABLE IF NOT EXISTS `dg_chat_ai` (
  `id_dg_chat_ai` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_chat_ai_title` int(11) DEFAULT NULL,
  `status_chat` int(2) DEFAULT NULL,
  `chat_detail` longtext,
  `date_created` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_chat_ai`)
) ENGINE=InnoDB AUTO_INCREMENT=936 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_chat_ai_title
CREATE TABLE IF NOT EXISTS `dg_chat_ai_title` (
  `id_dg_chat_ai_title` int(11) NOT NULL AUTO_INCREMENT,
  `title_chat` varchar(150) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_chat_ai_title`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=337 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client
CREATE TABLE IF NOT EXISTS `dg_client` (
  `id_dg_client` int(11) NOT NULL AUTO_INCREMENT,
  `nama_client` varchar(150) DEFAULT NULL,
  `alamat_client` varchar(150) DEFAULT NULL,
  `about_client` text,
  `email` varchar(150) DEFAULT NULL,
  `kategori_bisnis` varchar(100) DEFAULT NULL,
  `no_client` varchar(15) DEFAULT NULL,
  `status_client` int(2) DEFAULT NULL,
  `background_image` text,
  `logo_client` text,
  `link_name` varchar(20) DEFAULT NULL,
  `slogan_client` varchar(50) DEFAULT NULL,
  `pavicon` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_client`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_links
CREATE TABLE IF NOT EXISTS `dg_client_links` (
  `id_dg_client_links` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client` int(11) DEFAULT NULL,
  `name_link` varchar(50) DEFAULT NULL,
  `dg_link` text,
  `view` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `bobot_link` int(11) DEFAULT '1',
  PRIMARY KEY (`id_dg_client_links`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_pixel
CREATE TABLE IF NOT EXISTS `dg_client_pixel` (
  `id_dg_client_pixel` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client` int(11) DEFAULT NULL,
  `pixel_code` text,
  `pixel_name` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_pixel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_product
CREATE TABLE IF NOT EXISTS `dg_client_product` (
  `id_dg_client_product` int(11) DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `deskripsi_singkat` varchar(150) DEFAULT NULL,
  `deskripsi_produk` text,
  `harga_produk` double DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `group_produk` varchar(150) DEFAULT NULL,
  `foto_produk` text,
  `view_produk` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_produk_detail
CREATE TABLE IF NOT EXISTS `dg_client_produk_detail` (
  `id_dg_client_produk_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_produk` int(11) DEFAULT NULL,
  `detail_name` varchar(50) DEFAULT NULL,
  `detail_image` text,
  `variant` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_produk_detail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_produk_links
CREATE TABLE IF NOT EXISTS `dg_client_produk_links` (
  `id_dg_client_produk_links` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_produk` int(11) DEFAULT NULL,
  `name_link_produk` varchar(50) DEFAULT NULL,
  `link_produk` time DEFAULT NULL,
  `icon_link` text,
  `created_by` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_produk_links`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project
CREATE TABLE IF NOT EXISTS `dg_client_project` (
  `id_dg_client_project` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client` int(11) DEFAULT NULL,
  `id_dg_client_project_jenis` int(11) DEFAULT NULL,
  `nama_project` varchar(250) DEFAULT NULL,
  `division` int(11) DEFAULT NULL,
  `notes_project` longtext,
  `id_marketing` int(11) DEFAULT NULL,
  `tipe_invoice` varchar(150) DEFAULT NULL,
  `total_value_project` double DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `pph` int(11) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_active` int(2) DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_breakdown
CREATE TABLE IF NOT EXISTS `dg_client_project_breakdown` (
  `id_dg_client_project_breakdown` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `id_dg_user_job` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  `nama_komponen` varchar(150) DEFAULT NULL,
  `jumlah_komponen` int(11) DEFAULT NULL,
  `harga_modal` double DEFAULT NULL,
  `harga_jual` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `status_breakdown` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_breakdown`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_breakdown_rab
CREATE TABLE IF NOT EXISTS `dg_client_project_breakdown_rab` (
  `id_dg_client_project_breakdown_rab` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project_breakdown` int(11) DEFAULT NULL,
  `id_dg_rab_detail` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_breakdown_rab`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_filter_user_sprint
CREATE TABLE IF NOT EXISTS `dg_client_project_filter_user_sprint` (
  `id_dg_user` int(11) DEFAULT NULL,
  `id_dg_client_project_sprint` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_jenis
CREATE TABLE IF NOT EXISTS `dg_client_project_jenis` (
  `id_dg_client_project_jenis` int(11) NOT NULL AUTO_INCREMENT,
  `nama_jenis_project` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_links
CREATE TABLE IF NOT EXISTS `dg_client_project_links` (
  `id_dg_client_project_links` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `nama_link` varchar(150) DEFAULT NULL,
  `link_project` text,
  PRIMARY KEY (`id_dg_client_project_links`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_sprint
CREATE TABLE IF NOT EXISTS `dg_client_project_sprint` (
  `id_dg_client_project_sprint` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `nama_sprint` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_sprint`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_status
CREATE TABLE IF NOT EXISTS `dg_client_project_status` (
  `id_dg_client_project_status` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) NOT NULL DEFAULT '0',
  `id_dg_client_project_jenis` int(11) NOT NULL DEFAULT '0',
  `nama_status` varchar(20) DEFAULT NULL,
  `warna_status` varchar(15) DEFAULT NULL,
  `urutan_status` int(11) DEFAULT NULL,
  `is_deadline_active` int(2) DEFAULT NULL,
  `is_finish` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_status_assign
CREATE TABLE IF NOT EXISTS `dg_client_project_status_assign` (
  `id_dg_client_project_task` int(11) DEFAULT NULL,
  `id_dg_client_project_status` int(11) DEFAULT NULL,
  `id_dg_user_assign` int(11) DEFAULT NULL,
  `deadline_status` date DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_status_user
CREATE TABLE IF NOT EXISTS `dg_client_project_status_user` (
  `id_dg_client_project_status` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  `urutan_view` int(5) DEFAULT NULL,
  `is_active` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_task
CREATE TABLE IF NOT EXISTS `dg_client_project_task` (
  `id_dg_client_project_task` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `id_sprint` int(11) DEFAULT NULL,
  `id_type` int(11) DEFAULT NULL,
  `id_status` int(11) DEFAULT NULL,
  `nama_task` varchar(50) DEFAULT NULL,
  `priority` int(5) DEFAULT NULL,
  `detail_project` longtext,
  `urutan_task` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_task`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_task_status_history
CREATE TABLE IF NOT EXISTS `dg_client_project_task_status_history` (
  `id_dg_client_project_task` int(11) DEFAULT NULL,
  `id_dg_client_project_status` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_team
CREATE TABLE IF NOT EXISTS `dg_client_project_team` (
  `id_dg_client_project_team` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  `id_dg_job` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_team`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_project_type
CREATE TABLE IF NOT EXISTS `dg_client_project_type` (
  `id_dg_client_project_type` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_client_project` int(11) NOT NULL DEFAULT '0',
  `id_dg_client_project_jenis` int(11) NOT NULL DEFAULT '0',
  `nama_type` varchar(50) DEFAULT NULL,
  `detail_project_tamplate` longtext,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_project_type`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_client_user
CREATE TABLE IF NOT EXISTS `dg_client_user` (
  `id_dg_client_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user` int(11) DEFAULT NULL,
  `id_dg_client` int(11) DEFAULT NULL,
  `id_dg_roles` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_client_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_default_variables
CREATE TABLE IF NOT EXISTS `dg_default_variables` (
  `id_dg_default_variables` int(11) NOT NULL AUTO_INCREMENT,
  `diperiksa_oleh` int(11) DEFAULT NULL,
  `diketahui_oleh` int(11) DEFAULT NULL,
  `disetujui_oleh` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_default_variables`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_division
CREATE TABLE IF NOT EXISTS `dg_division` (
  `id_dg_division` int(11) NOT NULL AUTO_INCREMENT,
  `division_name` varchar(150) DEFAULT NULL,
  `division_notes` varchar(350) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_division`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_event
CREATE TABLE IF NOT EXISTS `dg_event` (
  `id_dg_event` int(11) NOT NULL AUTO_INCREMENT,
  `nama_event` varchar(150) DEFAULT NULL,
  `id_dg_user_group` int(11) DEFAULT NULL,
  `pesan_default` text,
  `type_event` varchar(50) DEFAULT NULL,
  `background_color` varchar(50) DEFAULT NULL,
  `tanggal` int(11) DEFAULT NULL,
  `bulan` int(11) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `finish_year` int(11) DEFAULT NULL,
  `start_month` int(11) DEFAULT NULL,
  `finish_month` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `weekly_dow` varchar(50) DEFAULT NULL,
  `start_time` varchar(10) DEFAULT NULL,
  `finish_time` varchar(10) DEFAULT NULL,
  `fee_offline` int(11) DEFAULT NULL,
  `fee_online` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_event`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_event_detail
CREATE TABLE IF NOT EXISTS `dg_event_detail` (
  `id_dg_event_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_event` int(11) DEFAULT NULL,
  `dg_event_tanggal` date DEFAULT NULL,
  `dg_event_tanggal_berubah` date DEFAULT NULL,
  `notes_mom` longtext,
  PRIMARY KEY (`id_dg_event_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_event_detail_attendance
CREATE TABLE IF NOT EXISTS `dg_event_detail_attendance` (
  `id_dg_event_detail_attendance` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_event_detail` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  `status_absen` int(4) DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT '0',
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_event_detail_attendance`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_event_detail_task
CREATE TABLE IF NOT EXISTS `dg_event_detail_task` (
  `id_dg_event_detail_task` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_event_detail` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  `isi_task` varchar(50) DEFAULT NULL,
  `deadline_task` date DEFAULT NULL,
  `status_task` int(4) DEFAULT '0',
  `date_ongoing` date DEFAULT NULL,
  `date_done` date DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_event_detail_task`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_event_hari_libur
CREATE TABLE IF NOT EXISTS `dg_event_hari_libur` (
  `id_dg_event_hari_libur` int(11) NOT NULL AUTO_INCREMENT,
  `nama_hari_libur` varchar(150) DEFAULT NULL,
  `awal_tanggal_libur` date DEFAULT NULL,
  `akhir_tanggal_libur` date DEFAULT NULL,
  `keterangan` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_event_hari_libur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_event_user_tambahan
CREATE TABLE IF NOT EXISTS `dg_event_user_tambahan` (
  `id_dg_event_user_tambahan` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_event` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  `tambahan_fee_offline` int(11) DEFAULT '0',
  `tambahan_fee_online` int(11) DEFAULT '0',
  PRIMARY KEY (`id_dg_event_user_tambahan`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_home_page
CREATE TABLE IF NOT EXISTS `dg_home_page` (
  `version` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_job
CREATE TABLE IF NOT EXISTS `dg_job` (
  `id_dg_job` int(11) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(150) DEFAULT NULL,
  `job_description` text,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_job`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_rab
CREATE TABLE IF NOT EXISTS `dg_rab` (
  `id_dg_rab` int(11) NOT NULL AUTO_INCREMENT,
  `date_rab` date DEFAULT NULL,
  `diperiksa_oleh` int(11) DEFAULT NULL,
  `status_periksa` int(1) DEFAULT NULL,
  `diketahui_oleh` int(11) DEFAULT NULL,
  `status_diketahui` int(1) DEFAULT NULL,
  `disetujui_oleh` int(11) DEFAULT NULL,
  `status_disetujui` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_rab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_rab_detail
CREATE TABLE IF NOT EXISTS `dg_rab_detail` (
  `id_dg_rab_detail` int(11) NOT NULL AUTO_INCREMENT,
  `date_rab` date DEFAULT NULL,
  `id_dg_division` int(11) DEFAULT NULL,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `project_name` varchar(500) DEFAULT NULL,
  `deskripsi_rab` varchar(500) DEFAULT NULL,
  `nama_rekening` varchar(150) DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `check_rab` int(1) DEFAULT NULL,
  `status_rab` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_rab_detail`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_rab_detail_crown
CREATE TABLE IF NOT EXISTS `dg_rab_detail_crown` (
  `id_dg_rab_detail_crown` int(11) NOT NULL AUTO_INCREMENT,
  `date_rab_start` date DEFAULT NULL,
  `date_rab_finish` date DEFAULT NULL,
  `id_dg_division` int(11) DEFAULT NULL,
  `id_dg_client_project` int(11) DEFAULT NULL,
  `project_name` varchar(500) DEFAULT NULL,
  `deskripsi_rab` varchar(500) DEFAULT NULL,
  `nama_rekening` varchar(150) DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `check_rab` int(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_rab_detail_crown`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_roles
CREATE TABLE IF NOT EXISTS `dg_roles` (
  `id_dg_roles` int(11) NOT NULL,
  `nama_roles` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_dg_roles`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_task
CREATE TABLE IF NOT EXISTS `dg_task` (
  `id_dg_task` int(11) NOT NULL AUTO_INCREMENT,
  `id_client` int(11) DEFAULT NULL,
  `nama_task` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `deadline` date DEFAULT NULL,
  `owner_task` int(11) DEFAULT NULL,
  `status_task` int(2) DEFAULT NULL,
  `craeted_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_task`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_task_detail
CREATE TABLE IF NOT EXISTS `dg_task_detail` (
  `id_dg_task_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_task` int(11) DEFAULT NULL,
  `nama_task_detail` varchar(50) DEFAULT NULL,
  `deskripsi_task_detail` text,
  `deadline` date DEFAULT NULL,
  `support` int(11) DEFAULT NULL,
  `note` text,
  `status_detail` int(2) DEFAULT NULL,
  `craeted_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL,
  PRIMARY KEY (`id_dg_task_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user
CREATE TABLE IF NOT EXISTS `dg_user` (
  `id_dg_user` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user_organization` int(11) DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password_dg` text,
  `nama` varchar(150) DEFAULT NULL,
  `nama_panggilan` varchar(150) DEFAULT NULL,
  `jenis_kelamin` varchar(3) DEFAULT NULL,
  `ulang_tahun` date DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `email_dg` varchar(150) DEFAULT NULL,
  `nomor_hp` varchar(50) DEFAULT NULL,
  `nomor_rekening` varchar(20) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `jabatan` varchar(150) DEFAULT NULL,
  `mbti` varchar(50) DEFAULT NULL,
  `quotes` varchar(350) DEFAULT NULL,
  `status` int(2) DEFAULT '1',
  `status_login` int(2) NOT NULL DEFAULT '1',
  `photo` text,
  `link_team` varchar(150) DEFAULT NULL,
  `i_do` varchar(1350) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id_dg_user`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_group
CREATE TABLE IF NOT EXISTS `dg_user_group` (
  `id_dg_user_group` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_division` int(11) NOT NULL DEFAULT '0',
  `nama_group` varchar(50) DEFAULT NULL,
  `deskripsi_group` varchar(350) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_group`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_group_detail
CREATE TABLE IF NOT EXISTS `dg_user_group_detail` (
  `id_dg_user_group_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user_group` int(11) DEFAULT NULL,
  `id_dg_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_group_detail`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_job
CREATE TABLE IF NOT EXISTS `dg_user_job` (
  `id_dg_user_job` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user` int(11) DEFAULT NULL,
  `id_dg_job` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_job`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_organization
CREATE TABLE IF NOT EXISTS `dg_user_organization` (
  `id_dg_user_organization` int(11) NOT NULL AUTO_INCREMENT,
  `total_token` int(15) NOT NULL DEFAULT '0',
  `organization_name` varchar(50) DEFAULT NULL,
  `organization_slug` varchar(50) DEFAULT NULL,
  `organization_jenis_usaha` varchar(50) DEFAULT NULL,
  `organization_tanggal_beridri` date DEFAULT NULL,
  `organization_email` varchar(50) DEFAULT NULL,
  `organization_telp` varchar(50) DEFAULT NULL,
  `organization_npwp` varchar(50) DEFAULT NULL,
  `organization_nib` varchar(50) DEFAULT NULL,
  `organization_logo` text,
  `organization_nomor_rekening` varchar(12) DEFAULT NULL,
  `organization_nama_bank` varchar(12) DEFAULT NULL,
  `organization_country` varchar(100) DEFAULT NULL,
  `organization_province` varchar(100) DEFAULT NULL,
  `organization_city` varchar(100) DEFAULT NULL,
  `organization_district` varchar(100) DEFAULT NULL,
  `organization_village` varchar(100) DEFAULT NULL,
  `organization_alamat` varchar(200) DEFAULT NULL,
  `organization_zip_code` varchar(10) DEFAULT NULL,
  `organization_user_dafault_password` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_organization`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_organization_paket
CREATE TABLE IF NOT EXISTS `dg_user_organization_paket` (
  `id_dg_user_organization_paket` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(50) DEFAULT NULL,
  `detail_paket` varchar(250) DEFAULT NULL,
  `token_paket` int(11) DEFAULT NULL,
  `status_paket` int(2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(2) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(2) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(2) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_organization_paket`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_role
CREATE TABLE IF NOT EXISTS `dg_user_role` (
  `id_dg_user_role` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user_organization` int(11) DEFAULT NULL,
  `roles_name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_role`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_role_permission
CREATE TABLE IF NOT EXISTS `dg_user_role_permission` (
  `id_dg_user_role_permission` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user_role` int(11) DEFAULT NULL,
  `page_name` varchar(50) DEFAULT NULL,
  `can_create` int(1) DEFAULT NULL,
  `can_read` int(1) DEFAULT NULL,
  `can_update` int(1) DEFAULT NULL,
  `can_delete` int(1) DEFAULT NULL,
  `can_other` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_role_permission`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table dggroup.dg_user_skills
CREATE TABLE IF NOT EXISTS `dg_user_skills` (
  `id_dg_user_skills` int(11) NOT NULL AUTO_INCREMENT,
  `id_dg_user` int(11) DEFAULT NULL,
  `skill_name` char(150) DEFAULT NULL,
  `percent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_dg_user_skills`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
