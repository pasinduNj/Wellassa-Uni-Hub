-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 11, 2024 at 09:16 AM
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
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `ad_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `until_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advertisements`
--

INSERT INTO `advertisements` (`ad_id`, `title`, `description`, `image_path`, `upload_date`, `until_date`) VALUES
(11, 'Tent', 'jhhhdi', '/assets/img/advertisements/66e13019d4667.jpg', '2024-09-11 05:52:25', '2024-09-26'),
(12, 'Acer', 'fef', '/assets/img/advertisements/66e13527119b3.jpg', '2024-09-11 06:13:59', '2024-10-03'),
(13, 'Ad', 'fef', '/assets/img/advertisements/66e1354251f70.jpg', '2024-09-11 06:14:26', '2024-09-26');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `image_id` varchar(10) NOT NULL,
  `user_id` varchar(10) DEFAULT NULL,
  `product_id` varchar(12) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_name` varchar(32) NOT NULL,
  `modified_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  `category` text NOT NULL,
  `provider_id` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `name`, `price`, `quantity`, `description`, `category`, `provider_id`, `image_path`) VALUES
(1, 'Rice', 200, 3, 'Red Rice', 'others', 'SP-006', '/assets/img/products/prod_img_ROG.jpeg'),
(2, 'Acer', 1235689, 5, 'ROG', 'electronics', 'SP-006', '/assets/img/products/prod_img_ROG.jpeg'),
(3, 'camping tent', 1200, 2, 'good quality', 'camping', 'SP-006', '/assets/img/products/prod_img_tent.jpg'),
(4, 'Test Product', 254, 5, 'Testing', 'camping', 'SP-006', '/assets/img/products/prod_img_acer.jpg');

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
('RES-0013', 'CUS-001', 'TS-00007', 'pending', '2024-07-16'),
('RES-0014', 'CUS-001', 'TS-00043', 'pending', '2024-08-04'),
('RES-0015', 'CUS-001', 'TS-00002', 'pending', '2024-08-05');

-- --------------------------------------------------------

--
-- Table structure for table `review_table`
--

CREATE TABLE `review_table` (
  `review_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `review_table`
--

INSERT INTO `review_table` (`review_id`, `user_name`, `user_rating`, `user_review`, `datetime`) VALUES
(6, 'Lorem Ipsum', 4, 'The camera quality is phenomenal, especially in low light conditions.', 1621935691),
(7, 'Jane Doe', 5, 'Battery life lasts me all day, even with heavy usage. Impressive!', 1621939888),
(8, 'John Doe', 5, 'Love the sleek design and lightning-fast performance of this iphone!', 1621940010);

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
('TS-00001', 'SP-006', '2024-08-06', '09:00:00', '09:30:00', 'free'),
('TS-00002', 'SP-006', '2024-08-06', '09:30:00', '10:00:00', 'booked'),
('TS-00003', 'SP-006', '2024-08-06', '10:00:00', '10:30:00', 'free'),
('TS-00004', 'SP-006', '2024-08-06', '10:30:00', '11:00:00', 'free'),
('TS-00005', 'SP-006', '2024-08-07', '10:00:00', '10:30:00', 'free'),
('TS-00006', 'SP-006', '2024-08-07', '10:30:00', '11:00:00', 'free'),
('TS-00007', 'SP-006', '2024-08-07', '11:00:00', '11:30:00', 'free'),
('TS-00008', 'SP-006', '2024-08-07', '11:30:00', '12:00:00', 'free');

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
('Admin-Main', 'Wellassa', 'UniHub', 'wellassaunihub@gmail.com', '0774953014', 'admin', '$2y$10$HnZhhNcS5I1ACkKJU4ol5eg6ZxcTnP5aQJ4CYsh51wGjrxdT4QOkm', '2024-07-25', NULL, NULL, NULL, NULL, NULL, '134405e5d0a198fc1776bebc344ad0ab', '2024-08-24 19:16:40', 'active', NULL, NULL),
('CUS-0001', 'Saajith', 'Ali', 'saj@gmail.com', '0780784565', 'customer', '$2y$10$wKihgSmOD1EvALzsSoaoW.SSFkx0YtW8pXBAOkhyditzJf1EdftyK', '2024-08-03', NULL, NULL, NULL, NULL, NULL, 'e5abcfbb8873e74e9fc22afafe201496', '2024-09-04 05:26:05', 'active', NULL, NULL),
('SP-001', 'Mohammed', 'Sajith', 'sajith@gmail.com', '0760784568', 'sp_freelance', '$2y$10$F0UwafG3u388LFydq4mf9.9Nf/5IigTVxYTztaMrtpKYd30ggxAYm', '2024-08-03', '/assets/img/profile_photo/SP-001.jpg', 'Bayers', '200023202970', '0760784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', NULL),
('SP-002', 'Mohammed', 'SajithAli', 'sajithali@gmail.com', '0750784568', 'sp_freelance', '$2y$10$qpYRZYSLUjx8S6ZLSw6AcezWy33ml2UAYsVb3T1NfXaRyY40l6wNy', '2024-08-03', '/assets/img/profile_photo/SP-002.jpg', 'Techers', '200023202974', '0750784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable.', NULL),
('SP-003', 'Mohammed', 'SajithAli', 'sajitha@gmail.com', '0770784568', 'sp_freelance', '$2y$10$lahmslvy8zzyQ1r.H2y8SeCPP7vb9Y3NRSiMmaNotHmLc7skQ7ZJu', '2024-08-03', '/assets/img/profile_photo/SP-003.jpg', 'Hechers', '200023202975', '0770784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', NULL),
('SP-004', 'Mohammed', 'SajithAli', 'sajit@gmail.com', '0770784569', 'sp_freelance', '$2y$10$bcqC76et2wi9OD23DQOXHOsJtRHeYt7DDZ6cvapX.Mbu4g9mthWXy', '2024-08-03', '/assets/img/profile_photo/SP-004.jpg', 'Rechers', '200023202985', '0770784569', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.\nI am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', NULL),
('SP-005', NULL, NULL, 'saji@gmail.com', '0770784565', 'sp_freelance', '$2y$10$FnLUPX2JK.V57ITbQtQvPOc8ewyfE/SRfjoE4XQJ.IzsFdJ8DzcBS', '2024-08-03', '/assets/img/profile_photo/SP-005.jpg', 'Slechers', '200023202984', '0770784565', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', NULL, NULL),
('SP-006', 'Geeth', 'hashan', 'ghashan54@gmail.com', '0704416022', 'sp_reservation', '$2y$10$MDh5Pqz/4X19J4laeQ3NGu6NJDv6ALM6.YBQF.j5ILmgNbHLPrdAC', '2024-08-04', '/assets/img/profile_photo/SP-002.jpg', 'A2Z Saloon', '200119602896', '0704416022', 'F107 Amara Niwasa, Ranawana, Dewalegama', 'c404061103e812a8b4880849eb8f7164', '2024-09-04 09:00:38', 'active', 'Reserve me and get all the services you need!', 200),
('SP-007', 'Tharushi', 'sewwandi', 'tharusew@gmail.com', '0775645345', 'sp_reservation', '$2y$10$1p/ZoX4sU3sOFhiWrqUtAubcOJFm8x0ge4EI95RJUs7hNaplZozfG', '2024-08-04', '/assets/img/profile_photo/SP-003.jpg', 'Repeat Exam Sign', '199919602898', '0789657345', 'Admin Building', NULL, NULL, 'active', NULL, 100),
('SP-008', 'Sarath', 'Kumar', 'sarak@gmail.com', '0887867456', 'sp_reservation', '$2y$10$mhJ3.UO.3fCSlbgghnDmye731aG917MMZ83OpUMosuwmheC1kXXIi', '2024-08-04', '/assets/img/profile_photo/sarath.jpg', 'Bpot', '200019602896', '0789657340', '2nd post mile', NULL, NULL, 'active', NULL, 500);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `cus_id` (`cus_id`),
  ADD KEY `timeslot_id` (`timeslot_id`);

--
-- Indexes for table `review_table`
--
ALTER TABLE `review_table`
  ADD PRIMARY KEY (`review_id`);

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

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `review_table`
--
ALTER TABLE `review_table`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
