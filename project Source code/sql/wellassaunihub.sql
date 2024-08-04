-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 11:39 AM
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
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` varchar(10) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `product_id` varchar(12) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `category` text NOT NULL,
  `providerid` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `name`, `price`, `description`, `category`, `providerid`, `image_path`, `image_name`) VALUES
('6698a33b473e7', 'camping tent', 500, 'Description:\nEnjoy a perfect family getaway with our spacious and comfortable family camping tents. Designed to accommodate up to 6 people, this tent provides ample room for everyone. The tent features multiple rooms and a central living area, making it ideal for families or groups of friends.\n\nFeatures:\n\nCapacity: Up to 6 people\nDimensions: 16 x 12 feet\nRooms: 3 separate rooms for privacy\nMaterial: Waterproof and UV-resistant polyester\nVentilation: Mesh windows and roof for excellent airflow\nSetup: Easy-to-assemble with color-coded poles\nAdditional: Electrical cord access port, internal storage pockets, and a carrying bag\nRental Price: LKR 500 per night', 'camping', '123', 'uploads/camping.jpg', 'camping.jpg'),
('6698cb2fd2dcd', 'chocolate ', 1500, 'We offer chocolate gifts with arrangements sweetheart on any grand occasion like a birthday, anniversary, New Year, or Valentine’s Day. (Assorted chocolates as per availability', 'gift', '343434', 'uploads/birth.jpg', 'birth.jpg'),
('66ab276a0fac0', 'wallter', 500, 'leather wallet', 'other', 'asd123', 'uploads/wallet.jpg', 'wallet.jpg');

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
  `auth_key` varchar(255) DEFAULT NULL,
  `auth_key_expires` datetime DEFAULT NULL,
  `status` enum('active','disabled') DEFAULT NULL,
  `description` text DEFAULT NULL,
  `amount_per` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `email`, `contact_number`, `user_type`, `password`, `joined_date`, `profile_photo`, `business_name`, `nic_number`, `whatsapp_number`, `service_address`, `auth_key`, `auth_key_expires`, `status`, `description`, `amount_per`) VALUES
('Admin-Main', 'Wellassa', 'UniHub', 'wellassaunihub@gmail.com', '0774953014', 'admin', '$2y$10$B78rX7q6dpsG.1CJbOHpT.03j0TkNwDf7XGM9kD00Rg3lJSmyjM.S', '2024-07-25', NULL, NULL, NULL, NULL, NULL, '134405e5d0a198fc1776bebc344ad0ab', '2024-08-24 19:16:40', NULL, NULL, NULL),
('CUS-0001', 'Mohammed', 'SajithAli', 'saj@gmail.com', '0780784565', 'customer', '$2y$10$wKihgSmOD1EvALzsSoaoW.SSFkx0YtW8pXBAOkhyditzJf1EdftyK', '2024-08-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL),
('SP-001', 'Mohammed', 'Sajith', 'sajith@gmail.com', '0760784568', 'sp_freelance', '$2y$10$F0UwafG3u388LFydq4mf9.9Nf/5IigTVxYTztaMrtpKYd30ggxAYm', '2024-08-03', '/assets/img/profile_photo/SP-001.jpg', 'Bayers', '200023202970', '0760784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', NULL),
('SP-002', 'Mohammed', 'SajithAli', 'sajithali@gmail.com', '0750784568', 'sp_freelance', '$2y$10$qpYRZYSLUjx8S6ZLSw6AcezWy33ml2UAYsVb3T1NfXaRyY40l6wNy', '2024-08-03', '/assets/img/profile_photo/SP-002.jpg', 'Techers', '200023202974', '0750784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable.', NULL),
('SP-003', 'Mohammed', 'SajithAli', 'sajitha@gmail.com', '0770784568', 'sp_freelance', '$2y$10$lahmslvy8zzyQ1r.H2y8SeCPP7vb9Y3NRSiMmaNotHmLc7skQ7ZJu', '2024-08-03', '/assets/img/profile_photo/SP-003.jpg', 'Hechers', '200023202975', '0770784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', NULL),
('SP-004', 'Mohammed', 'SajithAli', 'sajit@gmail.com', '0770784569', 'sp_freelance', '$2y$10$bcqC76et2wi9OD23DQOXHOsJtRHeYt7DDZ6cvapX.Mbu4g9mthWXy', '2024-08-03', '/assets/img/profile_photo/SP-004.jpg', 'Rechers', '200023202985', '0770784569', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.\nI am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', NULL),
('SP-005', 'Mohammed', 'SajithAli', 'saji@gmail.com', '0770784565', 'sp_freelance', '$2y$10$FnLUPX2JK.V57ITbQtQvPOc8ewyfE/SRfjoE4XQJ.IzsFdJ8DzcBS', '2024-08-03', '/assets/img/profile_photo/SP-005.jpg', 'Slechers', '200023202984', '0770784565', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `timeslot_id` (`timeslot_id`);

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
