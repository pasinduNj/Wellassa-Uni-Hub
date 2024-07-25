-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 25, 2024 at 01:28 PM
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
-- Database: `wellassaunihub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `joined_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `email`, `password`, `contact_number`, `joined_date`) VALUES
('Admin-1', 'unihub@gmail.com', '$2y$10$iPmKyUmej56ZAGekzKWM8uoEb0EMC4TRtr0H9Pp0X2N8/wjT.VxfS', '0777542066', '2024-07-15'),
('Admin-2', 'raees@gmail.com', '$2y$10$kOR8boZBJX7rlEen1MT3PO0O5enY1w.DueUN3/sUSMnqjk2Sv4y8i', '0713987619', '2024-07-15'),
('Admin-3', 'pasindu@gmail.com', '$2y$10$FxzcNYlZ9Sq7ipyQgpA1JeQ1fPLieD1UEPmD6at7buonMcHX8sMN.', '0745423014', '2024-07-15'),
('Admin-4', 'kasun@gmail.com', '$2y$10$DFhYcnNlB1.xTFGrh0iP9.rJw4EMmxXUvbsMqFwtgXUDAuJ00wLf2', '0745632145', '2024-07-15'),
('Admin-5', 'sdsds@gmail.com', '$2y$10$xwIISBIxZDyXON7HCT5t1unrebRF7BbgOPp3Af2lvrK6nNM0aFD/i', '0123456789', '2024-07-15');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cus_id` varchar(8) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joined_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cus_id`, `first_name`, `last_name`, `email`, `contact_number`, `password`, `joined_date`) VALUES
('CUS-0001', 'sarath', 'Kumar', 'sarath@gmail.com', '0773987619', '$2y$10$TvGgrhBd/r4D2kZ5psr9y.Eg1/TTA7d78b9k9c6lfRd5VXM18rer6', '2024-07-14'),
('CUS-0002', 'Sajith', 'Ali', 'sajith@gmail.com', '0705853014', '$2y$10$FD1hA68hSwFXdrygDARXk.sTNiOjZvQya2GD5LyKeFwmIrOeHZlgG', '2024-07-15'),
('CUS-0003', 'kasun', 'chamika', 'kasun@gmail.com', 'adasdasd', '$2y$10$Tx44MRpwGSjpZdpnqo/zp.TY4AL2qi1n6E.3CYu4kE1buuAd0I/0q', '2024-07-18'),
('CUS-0004', 'Geeth', 'Hashan', 'geeth@gmail.com', '076495301', '$2y$10$LujPtM/oXuKWEil/A8a/6.7f3RchPtrY8wIwSvXu9cTRsDSay1X3K', '2024-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` varchar(10) NOT NULL,
  `cus_id` varchar(8) NOT NULL,
  `timeslot_id` varchar(10) NOT NULL,
  `payment_status` varchar(10) NOT NULL DEFAULT 'pending',
  `reservation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `cus_id`, `timeslot_id`, `payment_status`, `reservation_date`) VALUES
('RES-0001', 'CUS001', 'TS-00001', 'pending', '2024-07-16'),
('RES-0002', 'CUS001', 'TS-00009', 'pending', '2024-07-16'),
('RES-0003', 'CUS001', 'TS-00009', 'pending', '2024-07-16'),
('RES-0004', 'CUS001', 'TS-00013', 'pending', '2024-07-16'),
('RES-0005', 'CUS001', 'TS-00009', 'pending', '2024-07-16'),
('RES-0006', 'CUS001', 'TS-00017', 'pending', '2024-07-16'),
('RES-0007', 'CUS-001', 'TS-00002', 'pending', '2024-07-16'),
('RES-0008', 'CUS-001', 'TS-00002', 'pending', '2024-07-16'),
('RES-0009', 'CUS-001', 'TS-00003', 'pending', '2024-07-16'),
('RES-0010', 'CUS-001', 'TS-00004', 'pending', '2024-07-16'),
('RES-0011', 'CUS-001', 'TS-00005', 'pending', '2024-07-16'),
('RES-0012', 'CUS-001', 'TS-00006', 'pending', '2024-07-16'),
('RES-0013', 'CUS-001', 'TS-00007', 'pending', '2024-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `service_providers`
--

CREATE TABLE `service_providers` (
  `sp_id` varchar(6) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `nic_number` varchar(20) NOT NULL,
  `whatsapp_number` varchar(15) NOT NULL,
  `service_address` varchar(255) NOT NULL,
  `service_type` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `joined_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_providers`
--

INSERT INTO `service_providers` (`sp_id`, `first_name`, `last_name`, `email`, `contact_number`, `business_name`, `nic_number`, `whatsapp_number`, `service_address`, `service_type`, `password`, `joined_date`) VALUES
('SP-001', 'Raees', 'Ahamed', 'raees@gmail.com', '0764953014', 'Saloon Rais', '200126001722', '0764953014', '135,Passra Road,Badulla', 'Reservation Provider', '$2y$10$OuzOQgHzVtSOyeGtzZbreuhafLZAuPWHMZdg4ezqZXJibQ8tMaqe2', '2024-07-12'),
('SP-002', 'Kasun', 'Janith', 'janith@gmail.com', '0743562014', 'Kanja', '200225001486', '0745632015', 'Badulla', 'Freelancer', '$2y$10$dCET/2oImtZvH4FylWHk9uK.izvtJOlARKpW.IUuNDb9KIFedst/e', '2024-07-15'),
('SP-003', 'Ahmedh', 'Raees', 'ahmedh@gmail.com', '0754953014', 'Gem', '200156001722', '0754953014', 'Badulla', 'Product Seller', '$2y$10$VTfDUhRsI9gFsAe8V/4uTuHFx2U0LhtUbgWxrMMxZsNK0Dx4dLeMK', '2024-07-18');

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
('TS-00002', 'SP001', '2024-07-17', '13:00:00', '13:30:00', 'booked'),
('TS-00003', 'SP001', '2024-07-17', '13:30:00', '14:00:00', 'booked'),
('TS-00004', 'SP001', '2024-07-17', '14:00:00', '14:30:00', 'booked'),
('TS-00005', 'SP001', '2024-07-17', '14:30:00', '15:00:00', 'booked'),
('TS-00006', 'SP001', '2024-07-17', '15:00:00', '15:30:00', 'booked'),
('TS-00007', 'SP001', '2024-07-17', '15:30:00', '16:00:00', 'booked'),
('TS-00008', 'SP001', '2024-07-17', '16:00:00', '16:30:00', 'free'),
('TS-00009', 'SP001', '2024-07-17', '16:30:00', '17:00:00', 'booked'),
('TS-00010', 'SP001', '2024-07-18', '08:00:00', '08:30:00', 'free'),
('TS-00011', 'SP001', '2024-07-18', '08:30:00', '09:00:00', 'free'),
('TS-00012', 'SP001', '2024-07-18', '09:00:00', '09:30:00', 'free'),
('TS-00013', 'SP001', '2024-07-18', '09:30:00', '10:00:00', 'booked'),
('TS-00014', 'SP001', '2024-07-20', '10:00:00', '11:00:00', 'free'),
('TS-00015', 'SP001', '2024-07-20', '11:00:00', '12:00:00', 'free'),
('TS-00016', 'SP001', '2024-07-20', '12:00:00', '13:00:00', 'free'),
('TS-00017', 'SP001', '2024-07-20', '13:00:00', '14:00:00', 'booked'),
('TS-00018', 'SP-001', '2024-07-18', '08:00:00', '08:30:00', 'free'),
('TS-00019', 'SP-001', '2024-07-18', '08:30:00', '09:00:00', 'free'),
('TS-00020', 'SP-001', '2024-07-18', '09:00:00', '09:30:00', 'free'),
('TS-00021', 'SP-001', '2024-07-18', '09:30:00', '10:00:00', 'free'),
('TS-00022', 'SP-001', '2024-07-18', '10:00:00', '10:30:00', 'free'),
('TS-00023', 'SP-001', '2024-07-18', '10:30:00', '11:00:00', 'free'),
('TS-00024', 'SP-001', '2024-07-18', '11:00:00', '11:30:00', 'free'),
('TS-00025', 'SP-001', '2024-07-18', '11:30:00', '12:00:00', 'free'),
('TS-00026', 'SP-001', '2024-07-18', '12:00:00', '12:30:00', 'free'),
('TS-00027', 'SP-001', '2024-07-18', '12:30:00', '13:00:00', 'free'),
('TS-00028', 'SP-001', '2024-07-18', '13:00:00', '13:30:00', 'free'),
('TS-00029', 'SP-001', '2024-07-18', '13:30:00', '14:00:00', 'free'),
('TS-00030', 'SP-001', '2024-07-18', '14:00:00', '14:30:00', 'free'),
('TS-00031', 'SP-001', '2024-07-18', '14:30:00', '15:00:00', 'free'),
('TS-00032', 'SP-001', '2024-07-18', '15:00:00', '15:30:00', 'free'),
('TS-00033', 'SP-001', '2024-07-18', '15:30:00', '16:00:00', 'free'),
('TS-00034', 'SP-001', '2024-07-18', '16:00:00', '16:30:00', 'free'),
('TS-00035', 'SP-001', '2024-07-18', '16:30:00', '17:00:00', 'free'),
('TS-00036', 'SP-001', '2024-07-18', '17:00:00', '17:30:00', 'free'),
('TS-00037', 'SP-001', '2024-07-18', '17:30:00', '18:00:00', 'free'),
('TS-00038', 'SP-001', '2024-07-18', '18:00:00', '18:30:00', 'free'),
('TS-00039', 'SP-001', '2024-07-18', '18:30:00', '19:00:00', 'free'),
('TS-00040', 'SP-001', '2024-07-18', '19:00:00', '19:30:00', 'free'),
('TS-00041', 'SP-001', '2024-07-18', '19:30:00', '20:00:00', 'free');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` varchar(10) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `user_type` enum('customer','admin','sp_products','sp_reservation','sp_freelance') NOT NULL,
  `password` varchar(255) NOT NULL,
  `joined_date` date NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `business_name` varchar(100) DEFAULT NULL,
  `nic_number` varchar(16) DEFAULT NULL,
  `whatsapp_number` varchar(15) DEFAULT NULL,
  `service_address` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `auth_key_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `contact_number`, `user_type`, `password`, `joined_date`, `profile_photo`, `business_name`, `nic_number`, `whatsapp_number`, `service_address`, `description`, `auth_key`, `auth_key_expires`) VALUES
('Admin-Main', 'Wellassa', 'UniHub', 'wellassaunihub@gmail.com', '0774953014', 'admin', '$2y$10$B78rX7q6dpsG.1CJbOHpT.03j0TkNwDf7XGM9kD00Rg3lJSmyjM.S', '2024-07-25', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact_number` (`contact_number`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cus_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact_number` (`contact_number`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `timeslot_id` (`timeslot_id`);

--
-- Indexes for table `service_providers`
--
ALTER TABLE `service_providers`
  ADD PRIMARY KEY (`sp_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact_number` (`contact_number`),
  ADD UNIQUE KEY `nic_number` (`nic_number`),
  ADD UNIQUE KEY `whatsapp_number` (`whatsapp_number`);

--
-- Indexes for table `timeslots`
--
ALTER TABLE `timeslots`
  ADD PRIMARY KEY (`timeslot_id`),
  ADD KEY `sp_id` (`sp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `contact_number` (`contact_number`),
  ADD UNIQUE KEY `nic` (`nic_number`),
  ADD UNIQUE KEY `whatsapp_number` (`whatsapp_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
