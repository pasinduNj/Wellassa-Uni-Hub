-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 16, 2024 at 07:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `timeslots`
--

CREATE TABLE `timeslots` (
  `timeslot_id` varchar(10) NOT NULL,
  `sp_id` varchar(6) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'free'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeslots`
--

INSERT INTO `timeslots` (`timeslot_id`, `sp_id`, `date`, `start_time`, `end_time`, `status`) VALUES
('TS-00001', 'SP001', '2024-07-17', '10:30:00', '11:00:00', 'booked'),
('TS-00002', 'SP001', '2024-07-17', '13:00:00', '13:30:00', 'free'),
('TS-00003', 'SP001', '2024-07-17', '13:30:00', '14:00:00', 'free'),
('TS-00004', 'SP001', '2024-07-17', '14:00:00', '14:30:00', 'free'),
('TS-00005', 'SP001', '2024-07-17', '14:30:00', '15:00:00', 'free'),
('TS-00006', 'SP001', '2024-07-17', '15:00:00', '15:30:00', 'free'),
('TS-00007', 'SP001', '2024-07-17', '15:30:00', '16:00:00', 'free'),
('TS-00008', 'SP001', '2024-07-17', '16:00:00', '16:30:00', 'free'),
('TS-00009', 'SP001', '2024-07-17', '16:30:00', '17:00:00', 'booked'),
('TS-00010', 'SP001', '2024-07-18', '08:00:00', '08:30:00', 'free'),
('TS-00011', 'SP001', '2024-07-18', '08:30:00', '09:00:00', 'free'),
('TS-00012', 'SP001', '2024-07-18', '09:00:00', '09:30:00', 'free'),
('TS-00013', 'SP001', '2024-07-18', '09:30:00', '10:00:00', 'booked'),
('TS-00014', 'SP001', '2024-07-20', '10:00:00', '11:00:00', 'free'),
('TS-00015', 'SP001', '2024-07-20', '11:00:00', '12:00:00', 'free'),
('TS-00016', 'SP001', '2024-07-20', '12:00:00', '13:00:00', 'free'),
('TS-00017', 'SP001', '2024-07-20', '13:00:00', '14:00:00', 'booked');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`timeslot_id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD CONSTRAINT `timeslots_ibfk_1` FOREIGN KEY (`sp_id`) REFERENCES `service_providers` (`sp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
