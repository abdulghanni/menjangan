-- --------------------------------------------------------
-- Host:                         192.168.100.101
-- Server version:               5.5.46-0ubuntu0.14.04.2 - (Ubuntu)
-- Server OS:                    debian-linux-gnu
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table examples.api
CREATE TABLE IF NOT EXISTS `api` (
  `id_api` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id_api`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table examples.api: ~2 rows (approximately)
DELETE FROM `api`;
/*!40000 ALTER TABLE `api` DISABLE KEYS */;
INSERT INTO `api` (`id_api`, `name`, `email`) VALUES
	(8, 'Jhon', 'jhon@gmail.com'),
	(10, 'Joko', 'joko@gmail.com');
/*!40000 ALTER TABLE `api` ENABLE KEYS */;


-- Dumping structure for table examples.book
CREATE TABLE IF NOT EXISTS `book` (
  `id_book` int(11) NOT NULL AUTO_INCREMENT,
  `book_name` varchar(150) NOT NULL,
  `rating` enum('1','2','3','4','5') NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id_book`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table examples.book: ~2 rows (approximately)
DELETE FROM `book`;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` (`id_book`, `book_name`, `rating`, `content`) VALUES
	(1, 'Design', '5', '<p>Content</p>\r\n'),
	(2, 'PHP', '3', '<p>PHP Code</p>\r\n');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;


-- Dumping structure for table examples.groups
CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table examples.groups: ~2 rows (approximately)
DELETE FROM `groups`;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
	(1, 'admin', 'Administrator'),
	(2, 'members', 'General User');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;


-- Dumping structure for table examples.groups_menu
CREATE TABLE IF NOT EXISTS `groups_menu` (
  `id_groups` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table examples.groups_menu: ~22 rows (approximately)
DELETE FROM `groups_menu`;
/*!40000 ALTER TABLE `groups_menu` DISABLE KEYS */;
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
	(2, 30);
/*!40000 ALTER TABLE `groups_menu` ENABLE KEYS */;


-- Dumping structure for table examples.login_attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table examples.login_attempts: ~0 rows (approximately)
DELETE FROM `login_attempts`;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;


-- Dumping structure for table examples.menu
CREATE TABLE IF NOT EXISTS `menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) NOT NULL DEFAULT '99',
  `level` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `icon` varchar(125) NOT NULL,
  `label` varchar(25) NOT NULL,
  `link` varchar(125) NOT NULL,
  `id` varchar(25) NOT NULL DEFAULT '#',
  `id_menu_type` int(11) NOT NULL,
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- Dumping data for table examples.menu: ~16 rows (approximately)
DELETE FROM `menu`;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
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
	(34, 3, 2, 1, '', 'Database Manager', 'myigniter/database', '', 1),
	(33, 3, 1, 0, '', 'Get Started', 'documentation', '', 2);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Dumping structure for table examples.menu_type
CREATE TABLE IF NOT EXISTS `menu_type` (
  `id_menu_type` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(125) NOT NULL,
  PRIMARY KEY (`id_menu_type`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table examples.menu_type: ~2 rows (approximately)
DELETE FROM `menu_type`;
/*!40000 ALTER TABLE `menu_type` DISABLE KEYS */;
INSERT INTO `menu_type` (`id_menu_type`, `type`) VALUES
	(1, 'Side menu'),
	(2, 'Top menu');
/*!40000 ALTER TABLE `menu_type` ENABLE KEYS */;


-- Dumping structure for table examples.page
CREATE TABLE IF NOT EXISTS `page` (
  `id_page` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `template` varchar(125) NOT NULL,
  `breadcrumb` text NOT NULL,
  `content` text NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `view` varchar(150) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id_page`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table examples.page: ~3 rows (approximately)
DELETE FROM `page`;
/*!40000 ALTER TABLE `page` DISABLE KEYS */;
INSERT INTO `page` (`id_page`, `title`, `featured_image`, `slug`, `template`, `breadcrumb`, `content`, `keyword`, `description`, `view`) VALUES
	(1, 'About', '', 'about', 'frontend', '[{"label":"About","link":""}]', '<p>Lorem ipsum Aliquip exercitation incididunt in ex eiusmod velit et aliqua minim dolore dolore dolor amet eu occaecat in anim et ea voluptate proident Ut Duis fugiat do minim Ut qui cupidatat in laborum consequat Ut do adipisicing in in. asdasd</p>\r\n', '', '', 'default'),
	(2, 'Home', '', 'home', 'frontend', '[{"label":"Home","link":""}]', '<p>this is custom page can be found in <span class="marker">view/page</span></p>\r\n', 'myIgniter', 'myIgniter is custom framework based Codeigniter 3 with combine Grocery CRUD, AdminLTE, Ion auth, Gulp, and Bower. myIgniter for web developer who want to speed up their projects.', 'home'),
	(3, 'Simple Backend', '', 'simple-backend', 'backend', '[{"label":"Simple Backend","link":""}]', '<p>This is simple example Page Builder for backend.</p>\r\n', '', '', 'callout');
/*!40000 ALTER TABLE `page` ENABLE KEYS */;


-- Dumping structure for table examples.table
CREATE TABLE IF NOT EXISTS `table` (
  `id_table` int(11) NOT NULL AUTO_INCREMENT,
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
  `table_config` text NOT NULL,
  PRIMARY KEY (`id_table`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table examples.table: ~1 rows (approximately)
DELETE FROM `table`;
/*!40000 ALTER TABLE `table` DISABLE KEYS */;
INSERT INTO `table` (`id_table`, `table_name`, `subject`, `title`, `required`, `columns`, `field`, `uploads`, `relation_1`, `action`, `breadcrumb`) VALUES
	(1, 'book', 'Book', 'Book', '["book_name","rating"]', '["book_name","rating"]', '', '', 'null', '["Action","Create","Read","Update","Delete"]', '[{"label":"Book","link":""}]');
/*!40000 ALTER TABLE `table` ENABLE KEYS */;


-- Dumping structure for table examples.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `additional` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table examples.users: ~3 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `full_name`, `photo`, `additional`) VALUES
	(1, '127.0.0.1', 'admin', '$2y$08$0mQjC9osSWK/7TxNskCoZu/x4mxBOyxVFeAT5lqCGFwVPKAVmW8gO', NULL, 'admin@admin.com', NULL, NULL, NULL, 'gOqL46/.mhzfuNC0pSFzY.', 1268889823, 1466391792, 1, 'Administrator', 'b9d76-avatar04.png', NULL),
	(2, '127.0.0.1', 'member', '$2y$08$0wId8k6W86c1vfsiTuQlaOWhlMCeWdUEsPEa4VFNYGy9bNxTIn0qW', NULL, 'member@member.com', NULL, NULL, NULL, NULL, 1441451078, 1442838976, 1, 'Member', '', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table examples.users_groups
CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- Dumping data for table examples.users_groups: ~4 rows (approximately)
DELETE FROM `users_groups`;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
	(54, 2, 2),
	(55, 2, 1),
	(61, 1, 1);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
