-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2019 at 08:48 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `menjangan_go`
--

-- --------------------------------------------------------

--
-- Table structure for table `api`
--

CREATE TABLE `api` (
  `id_api` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `api`
--

INSERT INTO `api` (`id_api`, `name`, `email`) VALUES
(8, 'Jhon', 'jhon@gmail.com'),
(10, 'Joko', 'joko@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `id_book` int(11) NOT NULL,
  `book_name` varchar(150) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id_book`, `book_name`, `rating`, `content`) VALUES
(1, 'Design', '5', '<p>Content</p>\r\n'),
(2, 'PHP', '3', '<p>PHP Code</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `groups_menu`
--

CREATE TABLE `groups_menu` (
  `id_groups` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_menu`
--

INSERT INTO `groups_menu` (`id_groups`, `id_menu`) VALUES
(1, 1),
(2, 1),
(1, 4),
(2, 4),
(1, 21),
(2, 21),
(1, 5),
(2, 5),
(1, 6),
(2, 6),
(1, 7),
(2, 7),
(1, 8),
(2, 8),
(1, 10),
(2, 10),
(1, 28),
(2, 28),
(1, 3),
(2, 3),
(1, 30),
(1, 34),
(2, 30),
(2, 35),
(1, 35);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kepemilikan` varchar(100) NOT NULL,
  `barang` varchar(1000) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kios_klontongan`
--

CREATE TABLE `kios_klontongan` (
  `id_klotongan` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kepemilikan` varchar(100) NOT NULL,
  `izin` varchar(1000) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kios_pupuk`
--

CREATE TABLE `kios_pupuk` (
  `id_kios_pupuk` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kepemilikan` varchar(100) NOT NULL,
  `izin` varchar(1000) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `action` varchar(125) NOT NULL,
  `logs` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `action`, `logs`, `createdAt`) VALUES
(1, 'login', '{\"status\":true,\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-14 06:25:52'),
(2, 'logout', '{\"status\":true,\"id\":\"1\",\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-14 08:45:54'),
(3, 'login', '{\"status\":true,\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:54:13'),
(4, 'logout', '{\"status\":true,\"id\":\"1\",\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:57:00'),
(5, 'login', '{\"status\":true,\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:57:08'),
(6, 'logout', '{\"status\":true,\"id\":\"1\",\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:57:28'),
(7, 'login', '{\"status\":true,\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:57:35'),
(8, 'logout', '{\"status\":true,\"id\":\"1\",\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:57:52'),
(9, 'login', '{\"status\":true,\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 04:57:58'),
(10, 'logout', '{\"status\":true,\"id\":\"1\",\"identity\":\"admin@admin.com\",\"ip\":\"::1\"}', '2019-08-15 06:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '99',
  `level` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(125) NOT NULL,
  `label` varchar(25) NOT NULL,
  `link` varchar(125) NOT NULL,
  `id` varchar(25) NOT NULL DEFAULT '#',
  `id_menu_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `sort`, `level`, `parent_id`, `icon`, `label`, `link`, `id`, `id_menu_type`) VALUES
(1, 0, 1, 0, '', 'MAIN NAVIGATION', '', '#', 1),
(3, 1, 2, 1, 'dashboard', 'Dashboard', 'myigniter/dashboard', '#', 1),
(4, 2, 2, 1, 'table', 'CRUD Builder', 'myigniter/crud_builder', '', 1),
(5, 5, 2, 1, 'user', 'Users', '#', '', 1),
(6, 6, 3, 5, 'circle-o', 'Users', 'myigniter/users', '#', 1),
(7, 7, 3, 5, 'circle-o', 'Groups', 'myigniter/groups', '#', 1),
(8, 8, 2, 1, 'bars', 'Menu', 'myigniter/menu/side-menu', 'navMenu', 1),
(10, 10, 2, 1, 'cloud', 'API', 'api/user', '#', 1),
(19, 0, 1, 0, '', 'Home', '', '', 2),
(20, 1, 1, 0, '', 'About', 'page/about', '', 2),
(21, 3, 2, 1, 'file-o', 'Page Builder', 'myigniter/page_builder', '', 1),
(28, 4, 2, 1, 'th', 'Module Extensions', 'myigniter/modules', 'module', 1),
(29, 4, 1, 0, '', 'Dashboard', 'myigniter/dashboard', '', 2),
(30, 9, 2, 1, 'book', 'Documentation', 'documentation/welcome', '', 1),
(31, 2, 1, 0, '', 'Hello World', 'example', '', 2),
(33, 3, 1, 0, '', 'Get Started', 'documentation', '', 2),
(34, 3, 2, 1, '', 'Database Manager', 'myigniter/database', '', 1),
(35, 5, 1, 0, '', 'Pasar', 'pasar', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu_type`
--

CREATE TABLE `menu_type` (
  `id_menu_type` int(11) NOT NULL,
  `type` varchar(125) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_type`
--

INSERT INTO `menu_type` (`id_menu_type`, `type`) VALUES
(1, 'Side menu'),
(2, 'Top menu');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id_page` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `template` varchar(125) NOT NULL,
  `breadcrumb` text NOT NULL,
  `content` text NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `view` varchar(150) NOT NULL DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id_page`, `title`, `featured_image`, `slug`, `template`, `breadcrumb`, `content`, `keyword`, `description`, `view`) VALUES
(1, 'About', '', 'about', 'frontend', '[{\"label\":\"About\",\"link\":\"\"}]', '<p>Lorem ipsum Aliquip exercitation incididunt in ex eiusmod velit et aliqua minim dolore dolore dolor amet eu occaecat in anim et ea voluptate proident Ut Duis fugiat do minim Ut qui cupidatat in laborum consequat Ut do adipisicing in in. asdasd</p>\r\n', '', '', 'default'),
(2, 'Home', '', 'home', 'frontend', '[{\"label\":\"Home\",\"link\":\"\"}]', '<p>this is custom page can be found in <span class=\"marker\">view/page</span></p>\r\n', 'myIgniter', 'myIgniter is custom framework based Codeigniter 3 with combine Grocery CRUD, AdminLTE, Ion auth, Gulp, and Bower. myIgniter for web developer who want to speed up their projects.', 'home'),
(3, 'Simple Backend', '', 'simple-backend', 'backend', '[{\"label\":\"Simple Backend\",\"link\":\"\"}]', '<p>This is simple example Page Builder for backend.</p>\r\n', '', '', 'callout'),
(4, 'Pasar', '53d98-15-banjarbaru-kontainer-surat-suara.png', 'pasar', 'frontend', '[{\"label\":\"pasar\",\"link\":\"\"}]', 'tes halaman pasar &nbsp;\r\n', 'pasar', 'ini adalah halaman pasar ', 'utama');

-- --------------------------------------------------------

--
-- Table structure for table `pangkalan`
--

CREATE TABLE `pangkalan` (
  `id_pangkalan` int(11) NOT NULL,
  `nama_pangkalan` varchar(100) NOT NULL,
  `nama_agen` text NOT NULL,
  `kepemilikan` varchar(100) NOT NULL,
  `alamat` varchar(1000) NOT NULL,
  `kuota_perbulan` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pasar_rakyat`
--

CREATE TABLE `pasar_rakyat` (
  `id_pasar` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `luas_lahan` varchar(100) NOT NULL,
  `luas_bangunan` varchar(1000) NOT NULL,
  `jumlah_kios` varchar(100) NOT NULL,
  `jumlah_los` varchar(100) NOT NULL,
  `pengeloaan` enum('PD Pasar','Desa','Koperasi') NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasar_rakyat`
--

INSERT INTO `pasar_rakyat` (`id_pasar`, `nama`, `alamat`, `luas_lahan`, `luas_bangunan`, `jumlah_kios`, `jumlah_los`, `pengeloaan`, `latitude`, `longitude`, `foto`, `keterangan`) VALUES
(1, 'pengaron', '', '', '', '', '', '', '', '', '', ''),
(2, 'sungai sipai', '', '', '', '', '', '', '', '', '', ''),
(3, 'martapura', '', '', '', '', '', '', '', '', '', ''),
(4, 'banjar', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `id_table` int(11) NOT NULL,
  `table_name` varchar(150) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `required` text NOT NULL,
  `columns` text NOT NULL,
  `field` text NOT NULL,
  `uploads` text NOT NULL,
  `relation_1` text NOT NULL,
  `action` text NOT NULL,
  `breadcrumb` text NOT NULL,
  `table_config` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`id_table`, `table_name`, `subject`, `title`, `required`, `columns`, `field`, `uploads`, `relation_1`, `action`, `breadcrumb`, `table_config`) VALUES
(4, 'book', 'book', 'book', '', '', '', '', '', '[\"Action\",\"Create\",\"Read\",\"Update\",\"Delete\"]', 'null', '{\"id_book\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"book_name\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"rating\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"enum\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"content\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}'),
(6, 'gudang', 'Gudang', 'Gudang', '', '', '', '', '', '[\"Action\",\"Create\",\"Read\",\"Update\",\"Delete\"]', '[{\"label\":\"gudang\",\"link\":\"gudang\"}]', '{\"id_gudang\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"alamat\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"kepemilikan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"barang\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"latitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"longitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"foto\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"file\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"keterangan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}'),
(7, 'toko_modern', 'Toko Modern', 'Toko Modern', '', '', '', '', '', '[\"Action\",\"Create\",\"Read\",\"Update\",\"Delete\"]', '[{\"label\":\"Toko Modern\",\"link\":\"toko_modern\"}]', '{\"id_toko\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"alamat\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"kepemilikan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"izin\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"latitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"longitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"foto\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"file\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"keterangan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}'),
(8, 'pasar_rakyat', 'Pasar', 'Pasar', '', '', '', '', '', '[\"Action\",\"Create\",\"Read\",\"Update\",\"Delete\"]', '[{\"label\":\"Pasar\",\"link\":\"pasar\"}]', '{\"id_pasar\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"alamat\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"luas_lahan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"luas_bangunan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"jumlah_kios\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"jumlah_los\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"pengeloaan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"enum\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"latitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"longitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"foto\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"file\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"keterangan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}'),
(9, 'kios_pupuk', 'Kios Pupuk', 'Kios Pupuk', '', '', '', '', '', '[\"Action\",\"Create\",\"Read\",\"Update\",\"Delete\"]', 'null', '{\"id_kios_pupuk\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"alamat\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"kepemilikan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"izin\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"latitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"longitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"foto\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"file\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"keterangan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}'),
(10, 'pangkalan', 'Pangkalan', 'Pangkalan', '', '', '', '', '', '[\"\"]', 'null', '{\"id_kios_pupuk\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"alamat\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"kepemilikan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"izin\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"latitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"longitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"foto\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"file\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"keterangan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"id_pangkalan\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama_pangkalan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama_agen\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"kuota_perbulan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}'),
(11, 'kios_klontongan', 'Kios Klontongan', 'Kios Klontongan', '', '', '', '', '', '[\"Action\",\"Create\",\"Read\",\"Update\",\"Delete\"]', 'null', '{\"id_klotongan\":{\"actions\":{\"column\":0,\"add\":0,\"edit\":0,\"details\":1},\"type\":\"number\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"nama\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"alamat\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"kepemilikan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"izin\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"latitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"longitude\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"input\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"foto\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"file\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]},\"keterangan\":{\"actions\":{\"column\":1,\"add\":1,\"edit\":1,\"details\":1},\"type\":\"text\",\"selectData\":{},\"selectMultipleData\":{},\"validation\":[]}}');

-- --------------------------------------------------------

--
-- Table structure for table `toko_modern`
--

CREATE TABLE `toko_modern` (
  `id_toko` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kepemilikan` varchar(100) NOT NULL,
  `izin` varchar(1000) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL,
  `foto` varchar(1000) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko_modern`
--

INSERT INTO `toko_modern` (`id_toko`, `nama`, `alamat`, `kepemilikan`, `izin`, `latitude`, `longitude`, `foto`, `keterangan`) VALUES
(1, 'TOKO 1', '', '', '', '', '', '', ''),
(2, 'TOKO2', '', '', '', '', '', '', ''),
(3, 'TOK 3', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `additional` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `full_name`, `photo`, `additional`) VALUES
(1, '127.0.0.1', 'admin', '$2y$08$0mQjC9osSWK/7TxNskCoZu/x4mxBOyxVFeAT5lqCGFwVPKAVmW8gO', NULL, 'admin@admin.com', NULL, NULL, NULL, 'gOqL46/.mhzfuNC0pSFzY.', 1268889823, 1565845078, 1, 'Administrator', 'b9d76-avatar04.png', NULL),
(2, '127.0.0.1', 'member', '$2y$08$0wId8k6W86c1vfsiTuQlaOWhlMCeWdUEsPEa4VFNYGy9bNxTIn0qW', NULL, 'member@member.com', NULL, NULL, NULL, NULL, 1441451078, 1442838976, 1, 'Member', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(54, 2, 2),
(55, 2, 1),
(61, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id_api`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_book`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `kios_klontongan`
--
ALTER TABLE `kios_klontongan`
  ADD PRIMARY KEY (`id_klotongan`) USING BTREE;

--
-- Indexes for table `kios_pupuk`
--
ALTER TABLE `kios_pupuk`
  ADD PRIMARY KEY (`id_kios_pupuk`) USING BTREE;

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `menu_type`
--
ALTER TABLE `menu_type`
  ADD PRIMARY KEY (`id_menu_type`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id_page`);

--
-- Indexes for table `pangkalan`
--
ALTER TABLE `pangkalan`
  ADD PRIMARY KEY (`id_pangkalan`) USING BTREE;

--
-- Indexes for table `pasar_rakyat`
--
ALTER TABLE `pasar_rakyat`
  ADD PRIMARY KEY (`id_pasar`) USING BTREE;

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`id_table`);

--
-- Indexes for table `toko_modern`
--
ALTER TABLE `toko_modern`
  ADD PRIMARY KEY (`id_toko`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id_api` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kios_klontongan`
--
ALTER TABLE `kios_klontongan`
  MODIFY `id_klotongan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kios_pupuk`
--
ALTER TABLE `kios_pupuk`
  MODIFY `id_kios_pupuk` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `menu_type`
--
ALTER TABLE `menu_type`
  MODIFY `id_menu_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id_page` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pangkalan`
--
ALTER TABLE `pangkalan`
  MODIFY `id_pangkalan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pasar_rakyat`
--
ALTER TABLE `pasar_rakyat`
  MODIFY `id_pasar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `id_table` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `toko_modern`
--
ALTER TABLE `toko_modern`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
