-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2013 at 05:02 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nada`
--

-- --------------------------------------------------------

--
-- Table structure for table `mp_city`
--

CREATE TABLE IF NOT EXISTS `mp_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `latitude` float NOT NULL,
  `longitude` float NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `mp_city`
--

INSERT INTO `mp_city` (`id`, `name`, `latitude`, `longitude`, `country`) VALUES
(1, 'Ha Noi', 21.023, 105.832, 1),
(2, 'Ho Chi Minh', 10.7716, 106.698, 1),
(3, 'Da Nang', 16.0515, 108.215, 1),
(4, 'Singapore', 1.3315, 103.855, 2),
(5, 'Bangkok', 13.75, 100.483, 3),
(6, 'Nonthaburi', 13.8611, 100.513, 3),
(7, 'Pattaya', 12.9363, 100.887, 3),
(8, 'Brussels', 50.8411, 4.3564, 4),
(9, 'Antwerp', 51.525, 4.4021, 4),
(10, 'London', 51.5171, -0.118318, 5),
(11, 'Manchester', 53.4795, -2.2447, 5),
(12, 'Liverpool', 53.4167, -3, 5),
(13, 'New York', 42.3482, -75.189, 6),
(14, 'Los Angeles', 34.0522, -118.243, 6),
(15, 'Chicago', 41.85, -87.65, 6),
(16, 'Houston', 29.7631, -95.3631, 6),
(17, 'Philadelphia', 39.9761, -75.1642, 6),
(18, 'Phoenix', 33.4979, -112.075, 6),
(19, 'San Antonio', 29.4384, -98.5009, 6),
(20, 'San Diego', 32.7573, -117.15, 6),
(21, 'Dallas', 32.8115, -96.8035, 6),
(22, 'San Jose', 37.3448, -121.897, 6);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mp_city`
--
ALTER TABLE `mp_city`
  ADD CONSTRAINT `mp_city_ibfk_1` FOREIGN KEY (`country`) REFERENCES `mp_country` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
