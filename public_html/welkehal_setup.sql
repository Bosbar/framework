-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2024 at 08:36 PM
-- Server version: 10.3.24-MariaDB-1:10.3.24+maria~bionic
-- PHP Version: 7.2.34-39+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `welkehal`
--

-- --------------------------------------------------------

--
-- Table structure for table `halls`
--

CREATE TABLE `halls` (
  `id` tinyint(4) NOT NULL,
  `hall_name` varchar(50) COLLATE utf8mb4_bin DEFAULT '',
  `image` varchar(50) COLLATE utf8mb4_bin DEFAULT NULL,
  `address` varchar(100) COLLATE utf8mb4_bin DEFAULT NULL,
  `maps_link` varchar(250) COLLATE utf8mb4_bin DEFAULT NULL,
  `waze_link` varchar(200) COLLATE utf8mb4_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `halls`
--

INSERT INTO `halls` (`id`, `hall_name`, `image`, `address`, `maps_link`, `waze_link`) VALUES
(1, 'kunsthof', '/welkehal/images/kunsthof.png', 'Rooseveltstraat 49 E, 2321 BL Leiden', 'https://www.google.com/maps?hl=nl&gl=nl&um=1&ie=UTF-8&fb=1&sa=X&ftid=0x47c5c65eb318472b:0x71a8c01fe3ca9e20', 'https://ul.waze.com/ul?preview_venue_id=2949641.29365342.8956274&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location'),
(2, 'krachtstof', '/welkehal/images/krachtstof.png', 'Admiraal Banckertweg 2, 2315 SR Leiden', 'https://www.google.com/maps/place/Boulderhal+Krachtstof/@52.1585585,4.5093736,17z/data=!3m1!4b1!4m6!3m5!1s0x47c5c762d790ad23:0xf75a59ba0bdbd294!8m2!3d52.1585552!4d4.5119485!16s%2Fg%2F11ss74_wdm?hl=nl&entry=ttu', 'https://ul.waze.com/ul?place=ChIJI62Q12LHxUcRlNLbC7pZWvc&ll=52.15855520%2C4.51194850&navigate=yes&utm_campaign=default&utm_source=waze_website&utm_medium=lm_share_location');

-- --------------------------------------------------------

--
-- Table structure for table `halls_history`
--

CREATE TABLE `halls_history` (
  `id` int(11) NOT NULL,
  `hall_id` tinyint(4) DEFAULT NULL,
  `hall_visits` smallint(6) DEFAULT NULL,
  `confirmed_for_today` date DEFAULT NULL,
  `last_visit_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `halls_history`
--

INSERT INTO `halls_history` (`id`, `hall_id`, `hall_visits`, `confirmed_for_today`, `last_visit_date`) VALUES
(1, 1, 4, NULL, '2024-06-04'),
(2, 2, 1, NULL, '2024-06-09');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `id` int(11) NOT NULL,
  `hall_id` tinyint(4) NOT NULL,
  `visit_date` date NOT NULL,
  `overruled` tinyint(1) NOT NULL DEFAULT 0,
  `details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visits`
--

INSERT INTO `visits` (`id`, `hall_id`, `visit_date`, `overruled`, `details`) VALUES
(1, 1, '2024-06-04', 0, NULL),
(2, 1, '2024-06-09', 0, NULL),
(3, 2, '2024-06-11', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `halls`
--
ALTER TABLE `halls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `halls_history`
--
ALTER TABLE `halls_history`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `halls`
--
ALTER TABLE `halls`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `halls_history`
--
ALTER TABLE `halls_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
