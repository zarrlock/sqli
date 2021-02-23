-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 30, 2020 at 03:56 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `vat` int(11) NOT NULL,
  `price_vat` float NOT NULL,
  `price_total` float NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`pk`, `name`, `price`, `vat`, `price_vat`, `price_total`, `quantity`) VALUES
(1, 'Super Smash Bros Ultimate', 42, 21, 0, 42, 8),
(2, 'Tekken 4', 20, 6, 1.2, 21.2, 12),
(3, 'The Witcher 3', 100, 10, 10, 110, 2),
(4, 'World Of Warcraft', 50, 0, 0, 50, 21),
(5, 'Warcraft 3', 0, 0, 0, 0, 9),
(6, 'Farm Simulator', 0, 0, 0, 0, 2);

--
-- Triggers `products`
--
DROP TRIGGER IF EXISTS `prod_vat`;
DELIMITER $$
CREATE TRIGGER `prod_vat` BEFORE UPDATE ON `products` FOR EACH ROW BEGIN
DECLARE compute_vat float;
IF new.price != 0 AND new.price IS NOT NULL THEN
	SET compute_vat = new.vat/100;
    SET new.price_vat = new.price * compute_vat;
    SET new.price_total = new.price * compute_vat + new.price;
ELSE 
	SET new.price_vat = 0;
    SET new.price_total = 0;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pk`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`pk`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'johndoe', '12345678', '2020-03-12 17:40:36', '2020-03-12 17:40:36'),
(2, 'admin', 'password123', '2020-03-11 20:30:47', '2020-03-11 20:30:47'),
(4, 'ramon', '123456', '2020-03-12 17:16:40', '2020-03-12 17:16:40');

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `log_crea_users`;
DELIMITER $$
CREATE TRIGGER `log_crea_users` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO log (action, ts) VALUES (new.username, NOW())
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_updateTS`;
DELIMITER $$
CREATE TRIGGER `trig_updateTS` BEFORE UPDATE ON `users` FOR EACH ROW SET NEW.updated_at = NOW()
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
