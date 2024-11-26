-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 26, 2024 at 10:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sports_event_calendar`
--
CREATE DATABASE IF NOT EXISTS `sports_event_calendar` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sports_event_calendar`;

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

CREATE TABLE `Events` (
  `id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `venue_id` int(11) DEFAULT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`id`, `sport_id`, `description`, `venue_id`, `date_time`) VALUES
(1, 1, 'Salzburg - vs - Sturm', 1, '2019-07-18 18:30:00'),
(2, 2, 'KAC - vs - Capitals', 2, '2019-10-23 09:45:00'),
(18, 2, 'Capitals - vs - TWK Innsbruck', 2, '2024-11-28 14:00:00'),
(19, 3, 'UBSC Graz - vs - Flyers Wels', 2, '2024-11-30 15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `Event_Teams`
--

CREATE TABLE `Event_Teams` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Event_Teams`
--

INSERT INTO `Event_Teams` (`id`, `event_id`, `team_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(7, 18, 4),
(8, 18, 5),
(9, 19, 6),
(10, 19, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Sports`
--

CREATE TABLE `Sports` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Sports`
--

INSERT INTO `Sports` (`id`, `name`) VALUES
(1, 'Football'),
(2, 'Ice Hockey'),
(3, 'Basketball');

-- --------------------------------------------------------

--
-- Table structure for table `Teams`
--

CREATE TABLE `Teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Teams`
--

INSERT INTO `Teams` (`id`, `name`) VALUES
(1, 'Salzburg'),
(2, 'Sturm'),
(3, 'KAC'),
(4, 'Capitals'),
(5, 'TWK Innsbruck'),
(6, 'UBSC Graz'),
(7, 'Flyers Wels');

-- --------------------------------------------------------

--
-- Table structure for table `Venues`
--

CREATE TABLE `Venues` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Venues`
--

INSERT INTO `Venues` (`id`, `name`, `address`) VALUES
(1, 'Stadium Salzburg', 'Salzburg, Austria'),
(2, 'Stadium Graz', 'Graz, Austria');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sport_id` (`sport_id`),
  ADD KEY `venue_id` (`venue_id`);

--
-- Indexes for table `Event_Teams`
--
ALTER TABLE `Event_Teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `Sports`
--
ALTER TABLE `Sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Teams`
--
ALTER TABLE `Teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Venues`
--
ALTER TABLE `Venues`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Event_Teams`
--
ALTER TABLE `Event_Teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `Sports`
--
ALTER TABLE `Sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Teams`
--
ALTER TABLE `Teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Venues`
--
ALTER TABLE `Venues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Events`
--
ALTER TABLE `Events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`sport_id`) REFERENCES `Sports` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`venue_id`) REFERENCES `Venues` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `Event_Teams`
--
ALTER TABLE `Event_Teams`
  ADD CONSTRAINT `event_teams_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `Events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `event_teams_ibfk_2` FOREIGN KEY (`team_id`) REFERENCES `Teams` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
