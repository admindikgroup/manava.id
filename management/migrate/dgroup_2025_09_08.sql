-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 12:44 PM
-- Server version: 8.4.3
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dggroup`
--

-- --------------------------------------------------------

--
-- Table structure for table `dg_article`
--

CREATE TABLE `dg_article` (
  `id_dg_article` int NOT NULL,
  `judul_article` varchar(100) DEFAULT NULL,
  `id_author` int DEFAULT NULL,
  `banner_utama` text,
  `isi_article_pembuka` text,
  `quotes` varchar(350) DEFAULT NULL,
  `author_quotes` varchar(150) DEFAULT NULL,
  `banner1` text,
  `banner2` text,
  `isi_article` text,
  `view_count` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_article_category`
--

CREATE TABLE `dg_article_category` (
  `id_dg_article_category` int NOT NULL,
  `nama_category` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `id_created` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_article_category_m`
--

CREATE TABLE `dg_article_category_m` (
  `id_dg_article_category_m` int NOT NULL,
  `id_dg_article` int DEFAULT NULL,
  `id_dg_article_category` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_article_tags`
--

CREATE TABLE `dg_article_tags` (
  `id_dg_article_tags` int NOT NULL,
  `nama_tags` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `id_created` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_article_tags_m`
--

CREATE TABLE `dg_article_tags_m` (
  `id_dg_article_tags_m` int NOT NULL,
  `id_dg_article` int DEFAULT NULL,
  `id_dg_article_tags` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_chat`
--

CREATE TABLE `dg_chat` (
  `id_dg_chat` int DEFAULT NULL,
  `id_user1` int DEFAULT NULL,
  `id_user2` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_chat_ai`
--

CREATE TABLE `dg_chat_ai` (
  `id_dg_chat_ai` int NOT NULL,
  `id_dg_chat_ai_title` int DEFAULT NULL,
  `status_chat` int DEFAULT NULL,
  `chat_detail` longtext,
  `date_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dg_chat_ai`
--

INSERT INTO `dg_chat_ai` (`id_dg_chat_ai`, `id_dg_chat_ai_title`, `status_chat`, `chat_detail`, `date_created`) VALUES
(936, 337, 1, 'asd', '2025-08-16 20:17:11'),
(937, 337, 2, 'Error : No valid response from AI.', '2025-08-16 20:17:11');

-- --------------------------------------------------------

--
-- Table structure for table `dg_chat_ai_title`
--

CREATE TABLE `dg_chat_ai_title` (
  `id_dg_chat_ai_title` int NOT NULL,
  `title_chat` varchar(150) DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dg_chat_ai_title`
--

INSERT INTO `dg_chat_ai_title` (`id_dg_chat_ai_title`, `title_chat`, `id_dg_user`) VALUES
(337, 'New Chat 1', 49);

-- --------------------------------------------------------

--
-- Table structure for table `dg_client`
--

CREATE TABLE `dg_client` (
  `id_dg_client` int NOT NULL,
  `nama_client` varchar(150) DEFAULT NULL,
  `alamat_client` varchar(150) DEFAULT NULL,
  `about_client` text,
  `email` varchar(150) DEFAULT NULL,
  `kategori_bisnis` varchar(100) DEFAULT NULL,
  `no_client` varchar(15) DEFAULT NULL,
  `status_client` int DEFAULT NULL,
  `background_image` text,
  `logo_client` text,
  `link_name` varchar(20) DEFAULT NULL,
  `slogan_client` varchar(50) DEFAULT NULL,
  `pavicon` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_links`
--

CREATE TABLE `dg_client_links` (
  `id_dg_client_links` int NOT NULL,
  `id_dg_client` int DEFAULT NULL,
  `name_link` varchar(50) DEFAULT NULL,
  `dg_link` text,
  `view` int DEFAULT '0',
  `created_by` int DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `bobot_link` int DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_pixel`
--

CREATE TABLE `dg_client_pixel` (
  `id_dg_client_pixel` int NOT NULL,
  `id_dg_client` int DEFAULT NULL,
  `pixel_code` text,
  `pixel_name` varchar(100) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_product`
--

CREATE TABLE `dg_client_product` (
  `id_dg_client_product` int DEFAULT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `deskripsi_singkat` varchar(150) DEFAULT NULL,
  `deskripsi_produk` text,
  `harga_produk` double DEFAULT NULL,
  `diskon` double DEFAULT NULL,
  `group_produk` varchar(150) DEFAULT NULL,
  `foto_produk` text,
  `view_produk` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_produk_detail`
--

CREATE TABLE `dg_client_produk_detail` (
  `id_dg_client_produk_detail` int NOT NULL,
  `id_dg_client_produk` int DEFAULT NULL,
  `detail_name` varchar(50) DEFAULT NULL,
  `detail_image` text,
  `variant` varchar(100) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_produk_links`
--

CREATE TABLE `dg_client_produk_links` (
  `id_dg_client_produk_links` int NOT NULL,
  `id_dg_client_produk` int DEFAULT NULL,
  `name_link_produk` varchar(50) DEFAULT NULL,
  `link_produk` time DEFAULT NULL,
  `icon_link` text,
  `created_by` int DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project`
--

CREATE TABLE `dg_client_project` (
  `id_dg_client_project` int NOT NULL,
  `id_dg_client` int DEFAULT NULL,
  `id_dg_client_project_jenis` int DEFAULT NULL,
  `nama_project` varchar(250) DEFAULT NULL,
  `division` int DEFAULT NULL,
  `notes_project` longtext,
  `id_marketing` int DEFAULT NULL,
  `tipe_invoice` varchar(150) DEFAULT NULL,
  `total_value_project` double DEFAULT NULL,
  `ppn` int DEFAULT NULL,
  `pph` int DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_active` int DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_breakdown`
--

CREATE TABLE `dg_client_project_breakdown` (
  `id_dg_client_project_breakdown` int NOT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `id_dg_user_job` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL,
  `nama_komponen` varchar(150) DEFAULT NULL,
  `jumlah_komponen` int DEFAULT NULL,
  `harga_modal` double DEFAULT NULL,
  `harga_jual` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `status_breakdown` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_breakdown_rab`
--

CREATE TABLE `dg_client_project_breakdown_rab` (
  `id_dg_client_project_breakdown_rab` int NOT NULL,
  `id_dg_client_project_breakdown` int DEFAULT NULL,
  `id_dg_rab_detail` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_filter_user_sprint`
--

CREATE TABLE `dg_client_project_filter_user_sprint` (
  `id_dg_user` int DEFAULT NULL,
  `id_dg_client_project_sprint` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_jenis`
--

CREATE TABLE `dg_client_project_jenis` (
  `id_dg_client_project_jenis` int NOT NULL,
  `nama_jenis_project` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_links`
--

CREATE TABLE `dg_client_project_links` (
  `id_dg_client_project_links` int NOT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `nama_link` varchar(150) DEFAULT NULL,
  `link_project` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_sprint`
--

CREATE TABLE `dg_client_project_sprint` (
  `id_dg_client_project_sprint` int NOT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `nama_sprint` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_status`
--

CREATE TABLE `dg_client_project_status` (
  `id_dg_client_project_status` int NOT NULL,
  `id_dg_client_project` int NOT NULL DEFAULT '0',
  `id_dg_client_project_jenis` int NOT NULL DEFAULT '0',
  `nama_status` varchar(20) DEFAULT NULL,
  `warna_status` varchar(15) DEFAULT NULL,
  `urutan_status` int DEFAULT NULL,
  `is_deadline_active` int DEFAULT NULL,
  `is_finish` int DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_status_assign`
--

CREATE TABLE `dg_client_project_status_assign` (
  `id_dg_client_project_task` int DEFAULT NULL,
  `id_dg_client_project_status` int DEFAULT NULL,
  `id_dg_user_assign` int DEFAULT NULL,
  `deadline_status` date DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_status_user`
--

CREATE TABLE `dg_client_project_status_user` (
  `id_dg_client_project_status` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL,
  `urutan_view` int DEFAULT NULL,
  `is_active` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_task`
--

CREATE TABLE `dg_client_project_task` (
  `id_dg_client_project_task` int NOT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `id_sprint` int DEFAULT NULL,
  `id_type` int DEFAULT NULL,
  `id_status` int DEFAULT NULL,
  `nama_task` varchar(50) DEFAULT NULL,
  `priority` int DEFAULT NULL,
  `detail_project` longtext,
  `urutan_task` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_task_status_history`
--

CREATE TABLE `dg_client_project_task_status_history` (
  `id_dg_client_project_task` int DEFAULT NULL,
  `id_dg_client_project_status` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_team`
--

CREATE TABLE `dg_client_project_team` (
  `id_dg_client_project_team` int NOT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL,
  `id_dg_job` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_project_type`
--

CREATE TABLE `dg_client_project_type` (
  `id_dg_client_project_type` int NOT NULL,
  `id_dg_client_project` int NOT NULL DEFAULT '0',
  `id_dg_client_project_jenis` int NOT NULL DEFAULT '0',
  `nama_type` varchar(50) DEFAULT NULL,
  `detail_project_tamplate` longtext,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_client_user`
--

CREATE TABLE `dg_client_user` (
  `id_dg_client_user` int NOT NULL,
  `id_dg_user` int DEFAULT NULL,
  `id_dg_client` int DEFAULT NULL,
  `id_dg_roles` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_default_variables`
--

CREATE TABLE `dg_default_variables` (
  `id_dg_default_variables` int NOT NULL,
  `diperiksa_oleh` int DEFAULT NULL,
  `diketahui_oleh` int DEFAULT NULL,
  `disetujui_oleh` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_division`
--

CREATE TABLE `dg_division` (
  `id_dg_division` int NOT NULL,
  `division_name` varchar(150) DEFAULT NULL,
  `division_notes` varchar(350) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_event`
--

CREATE TABLE `dg_event` (
  `id_dg_event` int NOT NULL,
  `nama_event` varchar(150) DEFAULT NULL,
  `id_dg_user_group` int DEFAULT NULL,
  `pesan_default` text,
  `type_event` varchar(50) DEFAULT NULL,
  `background_color` varchar(50) DEFAULT NULL,
  `tanggal` int DEFAULT NULL,
  `bulan` int DEFAULT NULL,
  `start_year` int DEFAULT NULL,
  `finish_year` int DEFAULT NULL,
  `start_month` int DEFAULT NULL,
  `finish_month` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `finish_date` date DEFAULT NULL,
  `weekly_dow` varchar(50) DEFAULT NULL,
  `start_time` varchar(10) DEFAULT NULL,
  `finish_time` varchar(10) DEFAULT NULL,
  `fee_offline` int DEFAULT NULL,
  `fee_online` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_event_detail`
--

CREATE TABLE `dg_event_detail` (
  `id_dg_event_detail` int NOT NULL,
  `id_dg_event` int DEFAULT NULL,
  `dg_event_tanggal` date DEFAULT NULL,
  `dg_event_tanggal_berubah` date DEFAULT NULL,
  `notes_mom` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_event_detail_attendance`
--

CREATE TABLE `dg_event_detail_attendance` (
  `id_dg_event_detail_attendance` int NOT NULL,
  `id_dg_event_detail` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL,
  `status_absen` int DEFAULT NULL,
  `pengeluaran` int DEFAULT '0',
  `updated_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_event_detail_task`
--

CREATE TABLE `dg_event_detail_task` (
  `id_dg_event_detail_task` int NOT NULL,
  `id_dg_event_detail` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL,
  `isi_task` varchar(50) DEFAULT NULL,
  `deadline_task` date DEFAULT NULL,
  `status_task` int DEFAULT '0',
  `date_ongoing` date DEFAULT NULL,
  `date_done` date DEFAULT NULL,
  `keterangan` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_event_hari_libur`
--

CREATE TABLE `dg_event_hari_libur` (
  `id_dg_event_hari_libur` int NOT NULL,
  `nama_hari_libur` varchar(150) DEFAULT NULL,
  `awal_tanggal_libur` date DEFAULT NULL,
  `akhir_tanggal_libur` date DEFAULT NULL,
  `keterangan` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_event_user_tambahan`
--

CREATE TABLE `dg_event_user_tambahan` (
  `id_dg_event_user_tambahan` int NOT NULL,
  `id_dg_event` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL,
  `tambahan_fee_offline` int DEFAULT '0',
  `tambahan_fee_online` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_home_page`
--

CREATE TABLE `dg_home_page` (
  `version` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_job`
--

CREATE TABLE `dg_job` (
  `id_dg_job` int NOT NULL,
  `job_name` varchar(150) DEFAULT NULL,
  `job_description` text,
  `created_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dg_job`
--

INSERT INTO `dg_job` (`id_dg_job`, `job_name`, `job_description`, `created_by`, `created_at`, `edited_by`, `edited_at`, `deleted_by`, `deleted_at`) VALUES
(19, '1', '12', 49, '2025-08-16 20:12:57', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dg_password_resets`
--

CREATE TABLE `dg_password_resets` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_rab`
--

CREATE TABLE `dg_rab` (
  `id_dg_rab` int NOT NULL,
  `date_rab` date DEFAULT NULL,
  `diperiksa_oleh` int DEFAULT NULL,
  `status_periksa` int DEFAULT NULL,
  `diketahui_oleh` int DEFAULT NULL,
  `status_diketahui` int DEFAULT NULL,
  `disetujui_oleh` int DEFAULT NULL,
  `status_disetujui` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_rab_detail`
--

CREATE TABLE `dg_rab_detail` (
  `id_dg_rab_detail` int NOT NULL,
  `date_rab` date DEFAULT NULL,
  `id_dg_division` int DEFAULT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `project_name` varchar(500) DEFAULT NULL,
  `deskripsi_rab` varchar(500) DEFAULT NULL,
  `nama_rekening` varchar(150) DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `check_rab` int DEFAULT NULL,
  `status_rab` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_rab_detail_crown`
--

CREATE TABLE `dg_rab_detail_crown` (
  `id_dg_rab_detail_crown` int NOT NULL,
  `date_rab_start` date DEFAULT NULL,
  `date_rab_finish` date DEFAULT NULL,
  `id_dg_division` int DEFAULT NULL,
  `id_dg_client_project` int DEFAULT NULL,
  `project_name` varchar(500) DEFAULT NULL,
  `deskripsi_rab` varchar(500) DEFAULT NULL,
  `nama_rekening` varchar(150) DEFAULT NULL,
  `no_rekening` varchar(50) DEFAULT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `check_rab` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_roles`
--

CREATE TABLE `dg_roles` (
  `id_dg_roles` int NOT NULL,
  `nama_roles` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_task`
--

CREATE TABLE `dg_task` (
  `id_dg_task` int NOT NULL,
  `id_client` int DEFAULT NULL,
  `nama_task` varchar(50) DEFAULT NULL,
  `deskripsi` text,
  `deadline` date DEFAULT NULL,
  `owner_task` int DEFAULT NULL,
  `status_task` int DEFAULT NULL,
  `craeted_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_task_detail`
--

CREATE TABLE `dg_task_detail` (
  `id_dg_task_detail` int NOT NULL,
  `id_dg_task` int DEFAULT NULL,
  `nama_task_detail` varchar(50) DEFAULT NULL,
  `deskripsi_task_detail` text,
  `deadline` date DEFAULT NULL,
  `support` int DEFAULT NULL,
  `note` text,
  `status_detail` int DEFAULT NULL,
  `craeted_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user`
--

CREATE TABLE `dg_user` (
  `id_dg_user` int NOT NULL,
  `id_dg_user_organization` int DEFAULT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password_dg` text,
  `otp_code` varchar(6) DEFAULT NULL,
  `otp_expired` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
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
  `status` int DEFAULT '1',
  `status_login` int NOT NULL DEFAULT '1',
  `photo` text,
  `link_team` varchar(150) DEFAULT NULL,
  `i_do` varchar(1350) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `deleted_by` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dg_user`
--

INSERT INTO `dg_user` (`id_dg_user`, `id_dg_user_organization`, `username`, `password_dg`, `otp_code`, `otp_expired`, `is_verified`, `nama`, `nama_panggilan`, `jenis_kelamin`, `ulang_tahun`, `email`, `email_dg`, `nomor_hp`, `nomor_rekening`, `bank`, `alamat`, `jabatan`, `mbti`, `quotes`, `status`, `status_login`, `photo`, `link_team`, `i_do`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`, `last_login`) VALUES
(81, 2, 'winniee14', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 1, NULL, NULL, NULL, NULL, 'stokidannnstore44@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-02 05:57:37', NULL, NULL, NULL),
(83, NULL, 'yeremiasagungaldyansa', NULL, NULL, NULL, 1, 'Yeremias Agung Aldyansa', NULL, NULL, NULL, 'yeremiasagungaldyansa@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-08 11:19:20', NULL, NULL, NULL),
(84, NULL, 'yeremiasagung14', NULL, NULL, NULL, 1, 'yeremias agung', NULL, NULL, NULL, 'yeremiasagung14@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-08 17:42:42', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_group`
--

CREATE TABLE `dg_user_group` (
  `id_dg_user_group` int NOT NULL,
  `id_dg_division` int NOT NULL DEFAULT '0',
  `nama_group` varchar(50) DEFAULT NULL,
  `deskripsi_group` varchar(350) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_group_detail`
--

CREATE TABLE `dg_user_group_detail` (
  `id_dg_user_group_detail` int NOT NULL,
  `id_dg_user_group` int DEFAULT NULL,
  `id_dg_user` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_job`
--

CREATE TABLE `dg_user_job` (
  `id_dg_user_job` int NOT NULL,
  `id_dg_user` int DEFAULT NULL,
  `id_dg_job` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_organization`
--

CREATE TABLE `dg_user_organization` (
  `id_dg_user_organization` int NOT NULL,
  `total_token` int NOT NULL DEFAULT '0',
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
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dg_user_organization`
--

INSERT INTO `dg_user_organization` (`id_dg_user_organization`, `total_token`, `organization_name`, `organization_slug`, `organization_jenis_usaha`, `organization_tanggal_beridri`, `organization_email`, `organization_telp`, `organization_npwp`, `organization_nib`, `organization_logo`, `organization_nomor_rekening`, `organization_nama_bank`, `organization_country`, `organization_province`, `organization_city`, `organization_district`, `organization_village`, `organization_alamat`, `organization_zip_code`, `organization_user_dafault_password`, `created_at`, `created_by`, `edited_at`, `edited_by`, `deleted_at`, `deleted_by`) VALUES
(2, 0, 'ayeses', 'uye', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 0, 'kurto', 'kurtogans', 'retail', '2025-08-16', 'awd@gmail.com', '085156127130', '', '', 't0.jpg', '', '', '', '', '', '', '', 'Margaasih, Jalan sakura blok s1 no 9-10', '40215', NULL, NULL, 49, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_organization_paket`
--

CREATE TABLE `dg_user_organization_paket` (
  `id_dg_user_organization_paket` int NOT NULL,
  `nama_paket` varchar(50) DEFAULT NULL,
  `detail_paket` varchar(250) DEFAULT NULL,
  `token_paket` int DEFAULT NULL,
  `status_paket` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_orgz_request`
--

CREATE TABLE `dg_user_orgz_request` (
  `id` int NOT NULL,
  `id_dg_user` int NOT NULL,
  `id_dg_user_organization` int NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dg_user_orgz_request`
--

INSERT INTO `dg_user_orgz_request` (`id`, `id_dg_user`, `id_dg_user_organization`, `status`, `created_at`) VALUES
(1, 50, 2, 'approved', '2025-08-16 10:07:11'),
(2, 52, 2, 'approved', '2025-08-16 12:31:48'),
(3, 81, 2, 'approved', '2025-09-08 07:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_role`
--

CREATE TABLE `dg_user_role` (
  `id_dg_user_role` int NOT NULL,
  `id_dg_user_organization` int DEFAULT NULL,
  `roles_name` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `edited_at` datetime DEFAULT NULL,
  `edited_by` int DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_role_permission`
--

CREATE TABLE `dg_user_role_permission` (
  `id_dg_user_role_permission` int NOT NULL,
  `id_dg_user_role` int DEFAULT NULL,
  `page_name` varchar(50) DEFAULT NULL,
  `can_create` int DEFAULT NULL,
  `can_read` int DEFAULT NULL,
  `can_update` int DEFAULT NULL,
  `can_delete` int DEFAULT NULL,
  `can_other` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_skills`
--

CREATE TABLE `dg_user_skills` (
  `id_dg_user_skills` int NOT NULL,
  `id_dg_user` int DEFAULT NULL,
  `skill_name` char(150) DEFAULT NULL,
  `percent` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dg_article`
--
ALTER TABLE `dg_article`
  ADD PRIMARY KEY (`id_dg_article`);

--
-- Indexes for table `dg_article_category`
--
ALTER TABLE `dg_article_category`
  ADD PRIMARY KEY (`id_dg_article_category`);

--
-- Indexes for table `dg_article_category_m`
--
ALTER TABLE `dg_article_category_m`
  ADD PRIMARY KEY (`id_dg_article_category_m`);

--
-- Indexes for table `dg_article_tags`
--
ALTER TABLE `dg_article_tags`
  ADD PRIMARY KEY (`id_dg_article_tags`);

--
-- Indexes for table `dg_article_tags_m`
--
ALTER TABLE `dg_article_tags_m`
  ADD PRIMARY KEY (`id_dg_article_tags_m`);

--
-- Indexes for table `dg_chat_ai`
--
ALTER TABLE `dg_chat_ai`
  ADD PRIMARY KEY (`id_dg_chat_ai`);

--
-- Indexes for table `dg_chat_ai_title`
--
ALTER TABLE `dg_chat_ai_title`
  ADD PRIMARY KEY (`id_dg_chat_ai_title`) USING BTREE;

--
-- Indexes for table `dg_client`
--
ALTER TABLE `dg_client`
  ADD PRIMARY KEY (`id_dg_client`);

--
-- Indexes for table `dg_client_links`
--
ALTER TABLE `dg_client_links`
  ADD PRIMARY KEY (`id_dg_client_links`);

--
-- Indexes for table `dg_client_pixel`
--
ALTER TABLE `dg_client_pixel`
  ADD PRIMARY KEY (`id_dg_client_pixel`);

--
-- Indexes for table `dg_client_produk_detail`
--
ALTER TABLE `dg_client_produk_detail`
  ADD PRIMARY KEY (`id_dg_client_produk_detail`);

--
-- Indexes for table `dg_client_produk_links`
--
ALTER TABLE `dg_client_produk_links`
  ADD PRIMARY KEY (`id_dg_client_produk_links`);

--
-- Indexes for table `dg_client_project`
--
ALTER TABLE `dg_client_project`
  ADD PRIMARY KEY (`id_dg_client_project`);

--
-- Indexes for table `dg_client_project_breakdown`
--
ALTER TABLE `dg_client_project_breakdown`
  ADD PRIMARY KEY (`id_dg_client_project_breakdown`);

--
-- Indexes for table `dg_client_project_breakdown_rab`
--
ALTER TABLE `dg_client_project_breakdown_rab`
  ADD PRIMARY KEY (`id_dg_client_project_breakdown_rab`) USING BTREE;

--
-- Indexes for table `dg_client_project_jenis`
--
ALTER TABLE `dg_client_project_jenis`
  ADD PRIMARY KEY (`id_dg_client_project_jenis`);

--
-- Indexes for table `dg_client_project_links`
--
ALTER TABLE `dg_client_project_links`
  ADD PRIMARY KEY (`id_dg_client_project_links`);

--
-- Indexes for table `dg_client_project_sprint`
--
ALTER TABLE `dg_client_project_sprint`
  ADD PRIMARY KEY (`id_dg_client_project_sprint`);

--
-- Indexes for table `dg_client_project_status`
--
ALTER TABLE `dg_client_project_status`
  ADD PRIMARY KEY (`id_dg_client_project_status`) USING BTREE;

--
-- Indexes for table `dg_client_project_task`
--
ALTER TABLE `dg_client_project_task`
  ADD PRIMARY KEY (`id_dg_client_project_task`);

--
-- Indexes for table `dg_client_project_team`
--
ALTER TABLE `dg_client_project_team`
  ADD PRIMARY KEY (`id_dg_client_project_team`);

--
-- Indexes for table `dg_client_project_type`
--
ALTER TABLE `dg_client_project_type`
  ADD PRIMARY KEY (`id_dg_client_project_type`);

--
-- Indexes for table `dg_client_user`
--
ALTER TABLE `dg_client_user`
  ADD PRIMARY KEY (`id_dg_client_user`);

--
-- Indexes for table `dg_default_variables`
--
ALTER TABLE `dg_default_variables`
  ADD PRIMARY KEY (`id_dg_default_variables`);

--
-- Indexes for table `dg_division`
--
ALTER TABLE `dg_division`
  ADD PRIMARY KEY (`id_dg_division`);

--
-- Indexes for table `dg_event`
--
ALTER TABLE `dg_event`
  ADD PRIMARY KEY (`id_dg_event`);

--
-- Indexes for table `dg_event_detail`
--
ALTER TABLE `dg_event_detail`
  ADD PRIMARY KEY (`id_dg_event_detail`);

--
-- Indexes for table `dg_event_detail_attendance`
--
ALTER TABLE `dg_event_detail_attendance`
  ADD PRIMARY KEY (`id_dg_event_detail_attendance`);

--
-- Indexes for table `dg_event_detail_task`
--
ALTER TABLE `dg_event_detail_task`
  ADD PRIMARY KEY (`id_dg_event_detail_task`);

--
-- Indexes for table `dg_event_hari_libur`
--
ALTER TABLE `dg_event_hari_libur`
  ADD PRIMARY KEY (`id_dg_event_hari_libur`);

--
-- Indexes for table `dg_event_user_tambahan`
--
ALTER TABLE `dg_event_user_tambahan`
  ADD PRIMARY KEY (`id_dg_event_user_tambahan`);

--
-- Indexes for table `dg_job`
--
ALTER TABLE `dg_job`
  ADD PRIMARY KEY (`id_dg_job`);

--
-- Indexes for table `dg_password_resets`
--
ALTER TABLE `dg_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dg_rab`
--
ALTER TABLE `dg_rab`
  ADD PRIMARY KEY (`id_dg_rab`);

--
-- Indexes for table `dg_rab_detail`
--
ALTER TABLE `dg_rab_detail`
  ADD PRIMARY KEY (`id_dg_rab_detail`) USING BTREE;

--
-- Indexes for table `dg_rab_detail_crown`
--
ALTER TABLE `dg_rab_detail_crown`
  ADD PRIMARY KEY (`id_dg_rab_detail_crown`) USING BTREE;

--
-- Indexes for table `dg_roles`
--
ALTER TABLE `dg_roles`
  ADD PRIMARY KEY (`id_dg_roles`);

--
-- Indexes for table `dg_task`
--
ALTER TABLE `dg_task`
  ADD PRIMARY KEY (`id_dg_task`);

--
-- Indexes for table `dg_task_detail`
--
ALTER TABLE `dg_task_detail`
  ADD PRIMARY KEY (`id_dg_task_detail`);

--
-- Indexes for table `dg_user`
--
ALTER TABLE `dg_user`
  ADD PRIMARY KEY (`id_dg_user`);

--
-- Indexes for table `dg_user_group`
--
ALTER TABLE `dg_user_group`
  ADD PRIMARY KEY (`id_dg_user_group`);

--
-- Indexes for table `dg_user_group_detail`
--
ALTER TABLE `dg_user_group_detail`
  ADD PRIMARY KEY (`id_dg_user_group_detail`);

--
-- Indexes for table `dg_user_job`
--
ALTER TABLE `dg_user_job`
  ADD PRIMARY KEY (`id_dg_user_job`);

--
-- Indexes for table `dg_user_organization`
--
ALTER TABLE `dg_user_organization`
  ADD PRIMARY KEY (`id_dg_user_organization`);

--
-- Indexes for table `dg_user_organization_paket`
--
ALTER TABLE `dg_user_organization_paket`
  ADD PRIMARY KEY (`id_dg_user_organization_paket`);

--
-- Indexes for table `dg_user_orgz_request`
--
ALTER TABLE `dg_user_orgz_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dg_user_role`
--
ALTER TABLE `dg_user_role`
  ADD PRIMARY KEY (`id_dg_user_role`) USING BTREE;

--
-- Indexes for table `dg_user_role_permission`
--
ALTER TABLE `dg_user_role_permission`
  ADD PRIMARY KEY (`id_dg_user_role_permission`);

--
-- Indexes for table `dg_user_skills`
--
ALTER TABLE `dg_user_skills`
  ADD PRIMARY KEY (`id_dg_user_skills`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dg_article`
--
ALTER TABLE `dg_article`
  MODIFY `id_dg_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dg_article_category`
--
ALTER TABLE `dg_article_category`
  MODIFY `id_dg_article_category` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dg_article_category_m`
--
ALTER TABLE `dg_article_category_m`
  MODIFY `id_dg_article_category_m` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `dg_article_tags`
--
ALTER TABLE `dg_article_tags`
  MODIFY `id_dg_article_tags` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dg_article_tags_m`
--
ALTER TABLE `dg_article_tags_m`
  MODIFY `id_dg_article_tags_m` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `dg_chat_ai`
--
ALTER TABLE `dg_chat_ai`
  MODIFY `id_dg_chat_ai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=938;

--
-- AUTO_INCREMENT for table `dg_chat_ai_title`
--
ALTER TABLE `dg_chat_ai_title`
  MODIFY `id_dg_chat_ai_title` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `dg_client`
--
ALTER TABLE `dg_client`
  MODIFY `id_dg_client` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `dg_client_links`
--
ALTER TABLE `dg_client_links`
  MODIFY `id_dg_client_links` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dg_client_pixel`
--
ALTER TABLE `dg_client_pixel`
  MODIFY `id_dg_client_pixel` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_client_produk_detail`
--
ALTER TABLE `dg_client_produk_detail`
  MODIFY `id_dg_client_produk_detail` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_client_produk_links`
--
ALTER TABLE `dg_client_produk_links`
  MODIFY `id_dg_client_produk_links` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_client_project`
--
ALTER TABLE `dg_client_project`
  MODIFY `id_dg_client_project` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dg_client_project_breakdown`
--
ALTER TABLE `dg_client_project_breakdown`
  MODIFY `id_dg_client_project_breakdown` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dg_client_project_breakdown_rab`
--
ALTER TABLE `dg_client_project_breakdown_rab`
  MODIFY `id_dg_client_project_breakdown_rab` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `dg_client_project_jenis`
--
ALTER TABLE `dg_client_project_jenis`
  MODIFY `id_dg_client_project_jenis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dg_client_project_links`
--
ALTER TABLE `dg_client_project_links`
  MODIFY `id_dg_client_project_links` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `dg_client_project_sprint`
--
ALTER TABLE `dg_client_project_sprint`
  MODIFY `id_dg_client_project_sprint` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `dg_client_project_status`
--
ALTER TABLE `dg_client_project_status`
  MODIFY `id_dg_client_project_status` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `dg_client_project_task`
--
ALTER TABLE `dg_client_project_task`
  MODIFY `id_dg_client_project_task` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;

--
-- AUTO_INCREMENT for table `dg_client_project_team`
--
ALTER TABLE `dg_client_project_team`
  MODIFY `id_dg_client_project_team` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `dg_client_project_type`
--
ALTER TABLE `dg_client_project_type`
  MODIFY `id_dg_client_project_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `dg_client_user`
--
ALTER TABLE `dg_client_user`
  MODIFY `id_dg_client_user` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_default_variables`
--
ALTER TABLE `dg_default_variables`
  MODIFY `id_dg_default_variables` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dg_division`
--
ALTER TABLE `dg_division`
  MODIFY `id_dg_division` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dg_event`
--
ALTER TABLE `dg_event`
  MODIFY `id_dg_event` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dg_event_detail`
--
ALTER TABLE `dg_event_detail`
  MODIFY `id_dg_event_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `dg_event_detail_attendance`
--
ALTER TABLE `dg_event_detail_attendance`
  MODIFY `id_dg_event_detail_attendance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `dg_event_detail_task`
--
ALTER TABLE `dg_event_detail_task`
  MODIFY `id_dg_event_detail_task` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `dg_event_hari_libur`
--
ALTER TABLE `dg_event_hari_libur`
  MODIFY `id_dg_event_hari_libur` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dg_event_user_tambahan`
--
ALTER TABLE `dg_event_user_tambahan`
  MODIFY `id_dg_event_user_tambahan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dg_job`
--
ALTER TABLE `dg_job`
  MODIFY `id_dg_job` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `dg_password_resets`
--
ALTER TABLE `dg_password_resets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `dg_rab`
--
ALTER TABLE `dg_rab`
  MODIFY `id_dg_rab` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_rab_detail`
--
ALTER TABLE `dg_rab_detail`
  MODIFY `id_dg_rab_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `dg_rab_detail_crown`
--
ALTER TABLE `dg_rab_detail_crown`
  MODIFY `id_dg_rab_detail_crown` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_task`
--
ALTER TABLE `dg_task`
  MODIFY `id_dg_task` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `dg_task_detail`
--
ALTER TABLE `dg_task_detail`
  MODIFY `id_dg_task_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `dg_user`
--
ALTER TABLE `dg_user`
  MODIFY `id_dg_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `dg_user_group`
--
ALTER TABLE `dg_user_group`
  MODIFY `id_dg_user_group` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `dg_user_group_detail`
--
ALTER TABLE `dg_user_group_detail`
  MODIFY `id_dg_user_group_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `dg_user_job`
--
ALTER TABLE `dg_user_job`
  MODIFY `id_dg_user_job` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dg_user_organization`
--
ALTER TABLE `dg_user_organization`
  MODIFY `id_dg_user_organization` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dg_user_organization_paket`
--
ALTER TABLE `dg_user_organization_paket`
  MODIFY `id_dg_user_organization_paket` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_user_orgz_request`
--
ALTER TABLE `dg_user_orgz_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dg_user_role`
--
ALTER TABLE `dg_user_role`
  MODIFY `id_dg_user_role` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_user_role_permission`
--
ALTER TABLE `dg_user_role_permission`
  MODIFY `id_dg_user_role_permission` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dg_user_skills`
--
ALTER TABLE `dg_user_skills`
  MODIFY `id_dg_user_skills` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
