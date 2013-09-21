-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.12-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.0.0.4452
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- Dumping data for table nada.mp_category: 9 rows
/*!40000 ALTER TABLE `mp_category` DISABLE KEYS */;
REPLACE INTO `mp_category` (`id`, `name`, `description`, `icon`, `sort`, `image`) VALUES
	(1, 'Fashion', '', 'icon-truck', 0, 'images/category/fashion_cat.jpg'),
	(2, 'Mobile & Tablet', '', 'icon-tablet', 0, 'images/category/tablet_cat.jpg'),
	(3, 'Desktop & Latop', '', 'icon-laptop', 0, 'images/category/desktop_cat.jpg'),
	(4, 'Camera & Electrical Devices', '', 'icon-cogs', 0, 'images/category/camera_cat.jpg'),
	(5, 'Handmade & Art', '', 'icon-camera', 0, 'images/category/handmade_cat.jpg'),
	(6, 'Services', '', 'icon-glass', 0, 'images/category/service_cat.jpg'),
	(7, 'Real Estate', '', 'icon-home', 0, 'images/category/realestate_cat.jpg'),
	(8, 'Car & Motobike', '', 'icon-suitcase', 0, 'images/category/car_cat.jpg'),
	(9, 'Others', '', 'icon-female', 0, 'images/category/others_cat.jpg');
/*!40000 ALTER TABLE `mp_category` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
