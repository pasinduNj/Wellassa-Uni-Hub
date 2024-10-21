-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2024 at 09:18 AM
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
(14, 'Add 1', 'Description 1', '/assets/img/advertisements/66f96b146739c.jpeg', '2024-09-29 14:58:28', '2024-10-29'),
(15, 'Add 2', 'Description 2', '/assets/img/advertisements/66f96b322074a.jpeg', '2024-09-29 14:58:58', '2024-10-29'),
(16, 'Burger', 'Chicken Burger', '/assets/img/advertisements/67128e1039cc8.jpeg', '2024-10-18 16:34:24', '2024-10-30'),
(17, 'Ad 4', 'Contact for more detail', '/assets/img/advertisements/6715e823b0b13.jpeg', '2024-10-21 05:35:31', '2024-10-23'),
(18, 'ad 5', 'Contac for more details', '/assets/img/advertisements/6715eb0c7044c.jpeg', '2024-10-21 05:47:56', '2024-10-23');

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
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_id` varchar(12) NOT NULL,
  `provider_id` varchar(12) NOT NULL,
  `product_id` varchar(12) NOT NULL,
  `reservation_id` varchar(12) NOT NULL,
  `timeslot_id` varchar(24) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` double NOT NULL,
  `date_time` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('paid','pending','','') NOT NULL,
  `process_status` enum('pending','shipped','delivered','finished','reserved') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `provider_id`, `product_id`, `reservation_id`, `timeslot_id`, `price`, `quantity`, `total`, `date_time`, `status`, `process_status`) VALUES
(1, 'SP-009', 'SP-006', '', 'RES-0016', '', 100, 1, 100, '2024-10-20 11:15:07', 'paid', 'pending'),
(12, 'SP-009', 'SP-006', '1', '', '', 200, 1, 200, '2024-10-20 18:29:31', 'paid', 'pending'),
(13, 'SP-009', 'SP-006', '', 'RES-0019', '', 100, 1, 100, '2024-10-20 18:36:07', 'paid', 'pending'),
(14, 'SP-006', 'SP-009', '7', '', '', 650, 1, 650, '2024-10-20 22:35:20', 'paid', 'shipped'),
(15, 'SP-006', 'SP-009', '7', '', '', 650, 1, 650, '2024-10-20 22:35:27', 'paid', 'pending'),
(16, 'SP-006', 'SP-009', '7', '', '', 650, 1, 650, '2024-10-20 22:35:32', 'paid', 'pending'),
(17, 'SP-006', 'SP-009', '7', '', '', 650, 1, 650, '2024-10-20 22:47:23', 'paid', 'pending'),
(18, 'CUS-0001', 'SP-006', '', 'RES-0020', '', 100, 1, 100, '2024-10-21 02:01:09', 'paid', 'pending'),
(19, 'CUS-0001', 'SP-006', '2', '', '', 1235690, 1, 1235689, '2024-10-21 05:36:26', 'paid', 'delivered'),
(20, 'CUS-0001', 'SP-006', '', 'RES-0023', 'TS-00029', 100, 1, 100, '2024-10-21 03:03:22', 'paid', 'reserved'),
(21, 'CUS-0001', 'SP-009', '7', '', '', 650, 1, 650, '2024-10-21 07:29:29', 'paid', 'pending'),
(22, 'CUS-0001', 'SP-009', '7', '', '', 650, 1, 650, '2024-10-21 07:29:33', 'paid', 'pending'),
(23, 'CUS-0001', 'SP-006', '', 'RES-0024', 'TS-00030', 100, 1, 100, '2024-10-21 05:33:55', 'paid', 'reserved'),
(24, 'CUS-0001', 'SP-001', '', '', '', 200, 1, 200, '2024-10-21 10:56:16', 'paid', 'pending'),
(25, 'CUS-0001', 'SP-001', '', '', '', 200, 1, 200, '2024-10-21 10:56:20', 'paid', 'pending'),
(26, 'CUS-0001', 'SP-001', '', '', '', 200, 1, 200, '2024-10-21 10:58:07', 'paid', 'pending'),
(27, 'CUS-0001', 'SP-006', '', 'RES-0025', 'TS-00031', 100, 1, 100, '2024-10-21 07:28:35', 'paid', 'pending'),
(28, 'CUS-0001', 'SP-001', '', '', '', 200, 1, 200, '2024-10-21 11:34:25', 'paid', 'pending'),
(29, 'CUS-0001', 'SP-006', '', 'RES-0026', 'TS-00032', 100, 1, 100, '2024-10-21 08:04:56', 'paid', 'pending'),
(30, 'CUS-0001', 'SP-006', '', 'RES-0028', 'TS-00033', 100, 1, 100, '2024-10-21 08:13:43', 'paid', 'reserved');

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
(1, 'Rice', 200, 2, 'Red Rice', 'others', 'SP-006', '/assets/img/products/prod_img_ROG.jpeg'),
(2, 'Acer', 1235689, 4, 'ROG', 'electronics', 'SP-006', '/assets/img/products/prod_img_ROG.jpeg'),
(3, 'camping tent', 1200, 2, 'good quality', 'camping', 'SP-006', '/assets/img/products/prod_img_tent.jpg'),
(4, 'Test Product', 254, 5, 'Testing', 'camping', 'SP-006', '/assets/img/products/prod_img_acer.jpg'),
(7, 'Burger', 650, 9, 'Chicken Burger', 'others', 'SP-009', '/assets/img/products/prod_img_add3.jpeg');

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
('RES-0015', 'CUS-001', 'TS-00002', 'pending', '2024-08-05'),
('RES-0016', 'SP-009', 'TS-00023', 'paid', '2024-10-20'),
('RES-0017', 'SP-009', 'TS-00024', 'pending', '2024-10-20'),
('RES-0018', 'SP-009', 'TS-00025', 'pending', '2024-10-20'),
('RES-0019', 'SP-009', 'TS-00022', 'paid', '2024-10-20'),
('RES-0020', 'CUS-0001', 'TS-00026', 'paid', '2024-10-21'),
('RES-0021', 'CUS-0001', 'TS-00027', 'pending', '2024-10-21'),
('RES-0022', 'CUS-0001', 'TS-00028', 'pending', '2024-10-21'),
('RES-0023', 'CUS-0001', 'TS-00029', 'paid', '2024-10-21'),
('RES-0024', 'CUS-0001', 'TS-00030', 'paid', '2024-10-21'),
('RES-0025', 'CUS-0001', 'TS-00031', 'paid', '2024-10-21'),
('RES-0026', 'CUS-0001', 'TS-00032', 'paid', '2024-10-21'),
('RES-0027', 'CUS-0001', 'TS-00033', 'pending', '2024-10-21'),
('RES-0028', 'CUS-0001', 'TS-00033', 'paid', '2024-10-21');

-- --------------------------------------------------------

--
-- Table structure for table `review_table`
--

CREATE TABLE `review_table` (
  `review_id` int(11) NOT NULL,
  `customer_id` varchar(10) NOT NULL,
  `product_id` varchar(10) NOT NULL,
  `provider_id` varchar(10) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_rating` int(1) NOT NULL,
  `user_review` text NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `review_table`
--

INSERT INTO `review_table` (`review_id`, `customer_id`, `product_id`, `provider_id`, `user_name`, `user_rating`, `user_review`, `datetime`) VALUES
(13, 'SP-006', '', 'SP-001', 'Geeth', 3, 'Good Service', '2024-10-09 22:12:53'),
(15, 'SP-006', '', 'SP-003', 'Geeth', 4, 'best', '2024-10-09 22:18:07'),
(16, 'SP-006', '', 'SP-005', 'Geeth', 3, 'Good', '2024-10-09 22:28:30'),
(20, 'SP-006', '', 'SP-002', 'Geeth', 5, 'best', '2024-10-10 10:43:46'),
(22, 'SP-006', '4', '', 'Geeth', 5, 'very good Product', '2024-10-10 10:51:56'),
(23, 'SP-006', '3', '', 'Geeth', 4, 'Good camping hut', '2024-10-10 10:52:42'),
(24, 'SP-006', '2', '', 'Geeth', 4, 'Good Product', '2024-10-10 10:55:18'),
(25, 'SP-006', '1', '', 'Geeth', 4, 'Good Rice', '2024-10-10 10:56:26'),
(28, 'SP-006', '', 'SP-008', 'Geeth', 4, 'Wow supereb', '2024-10-10 19:09:04'),
(29, 'SP-009', '', 'SP-001', 'Raees', 3, 'nice', '2024-10-20 05:00:49'),
(30, 'SP-009', '', 'SP-007', 'Raees', 3, 'nice', '2024-10-20 18:31:19'),
(31, 'CUS-0001', '', 'SP-002', 'Saajith', 3, 'good service', '2024-10-20 18:55:22'),
(32, 'CUS-0001', '', 'SP-007', 'Saajith', 3, 'Good', '2024-10-20 18:59:12'),
(33, 'CUS-0001', '2', '', 'Saajith', 3, 'Good Product', '2024-10-20 19:14:49'),
(34, 'CUS-0001', '', 'SP-005', 'Saajith', 3, 'nice', '2024-10-21 08:31:42');

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
('TS-00008', 'SP-006', '2024-08-07', '11:30:00', '12:00:00', 'free'),
('TS-00009', 'SP-006', '2024-10-01', '11:00:00', '11:30:00', 'free'),
('TS-00010', 'SP-006', '2024-10-01', '11:30:00', '12:00:00', 'free'),
('TS-00011', 'SP-006', '2024-10-01', '12:00:00', '12:30:00', 'free'),
('TS-00012', 'SP-006', '2024-10-18', '09:00:00', '09:30:00', 'free'),
('TS-00013', 'SP-006', '2024-10-18', '09:30:00', '10:00:00', 'free'),
('TS-00014', 'SP-006', '2024-10-18', '10:00:00', '10:30:00', 'free'),
('TS-00015', 'SP-006', '2024-10-18', '10:30:00', '11:00:00', 'free'),
('TS-00016', 'SP-006', '2024-10-18', '11:00:00', '11:30:00', 'free'),
('TS-00017', 'SP-006', '2024-10-18', '09:00:00', '09:30:00', 'free'),
('TS-00018', 'SP-006', '2024-10-18', '09:30:00', '10:00:00', 'free'),
('TS-00019', 'SP-006', '2024-10-18', '10:00:00', '10:30:00', 'free'),
('TS-00020', 'SP-006', '2024-10-18', '10:30:00', '11:00:00', 'free'),
('TS-00021', 'SP-006', '2024-10-18', '11:00:00', '11:30:00', 'free'),
('TS-00022', 'SP-006', '2024-10-21', '08:00:00', '08:30:00', 'booked'),
('TS-00023', 'SP-006', '2024-10-21', '08:30:00', '09:00:00', 'booked'),
('TS-00024', 'SP-006', '2024-10-21', '09:00:00', '09:30:00', 'booked'),
('TS-00025', 'SP-006', '2024-10-21', '09:30:00', '10:00:00', 'booked'),
('TS-00026', 'SP-006', '2024-10-21', '10:00:00', '10:30:00', 'booked'),
('TS-00027', 'SP-006', '2024-10-21', '10:30:00', '11:00:00', 'booked'),
('TS-00028', 'SP-006', '2024-10-23', '09:00:00', '09:30:00', 'booked'),
('TS-00029', 'SP-006', '2024-10-23', '09:30:00', '10:00:00', 'booked'),
('TS-00030', 'SP-006', '2024-10-23', '10:00:00', '10:30:00', 'booked'),
('TS-00031', 'SP-006', '2024-10-23', '10:30:00', '11:00:00', 'booked'),
('TS-00032', 'SP-006', '2024-10-23', '11:00:00', '11:30:00', 'booked'),
('TS-00033', 'SP-006', '2024-10-23', '11:30:00', '12:00:00', 'booked');

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
('CUS-0001', 'Raees', 'Ahmedh', 'raeesahmedh116@gmail.com', '0780784565', 'customer', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-03', '/assets/img/profile_photo/CUS-0001_1729491548_Screenshot 2024-10-21 114824.png', NULL, NULL, NULL, NULL, 'e5abcfbb8873e74e9fc22afafe201496', '2024-09-04 05:26:05', 'active', NULL, NULL),
('SP-001', 'Mohammed', 'Sajith', 'sajithali2000@gmail.com', '0760784568', 'sp_freelance', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-03', '/assets/img/profile_photo/SP-001_1729494567_1934823-e1540532501723.jpg', 'Graphic Designer', '200023202970', '0760784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', 500),
('SP-002', 'Lasitha', 'Prasad', 'sajithali@gmail.com', '0750784568', 'sp_freelance', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-03', '/assets/img/profile_photo/lasitha.jpg', 'ICT With Lasitha', '200023202974', '0750784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable.', 600),
('SP-003', 'Thilina', 'Adikari', 'sajitha@gmail.com', '0770784568', 'sp_freelance', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-03', '/assets/img/profile_photo/pencil.jpg', 'Pencil Art', '200023202975', '0770784568', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', 250),
('SP-004', 'Kasun', 'Chamika', 'sajit@gmail.com', '0770784569', 'sp_freelance', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-03', '/assets/img/profile_photo/WebDev.jpg', 'Web Devoloper', '200023202985', '0770784569', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', 'I am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.\nI am a very passionate person with my work and with everything that I propose, that is why I am sure that working with your team we will be able to carry out any project, I am responsible, reliable, punctual and I work and learn quickly.', 50),
('SP-005', 'Amila', 'Prabashwara', 'amila@gmail.com', '0770784565', 'sp_freelance', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-03', '/assets/img/profile_photo/tshirt.jpg', 'T Shirt designer', '200023202984', '0770784565', 'No.335/3 Aliyar Road, Kalmunaikudy - 12, Kalmunai', NULL, NULL, 'active', NULL, 50),
('SP-006', 'Sadun', 'hashan', 'ghashan54@gmail.com', '0704416022', 'sp_reservation', '$2y$10$jetqBoWLvTRCJfqsJNDa3OhpwEIHjqZ8qsYa5PlbnpDg2VW8m1IMi', '2024-08-04', '/assets/img/profile_photo/SP-002.jpg', 'Sadun saloon', '200119602896', '0704416022', 'F107 Amara Niwasa, Ranawana, Dewalegama', 'c404061103e812a8b4880849eb8f7164', '2024-09-04 09:00:38', 'active', 'Reserve me and get all the services you need!', 200),
('SP-007', 'Tharusdhi', 'sewwandi', 'tharusew@gmail.com', '0775645345', 'sp_reservation', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-04', '/assets/img/profile_photo/exam.jpg', 'Repeat Exam Sign', '199919602898', '0789657345', 'Admin Building', NULL, NULL, 'active', NULL, 100),
('SP-008', 'Dr. Peter', 'Kumar', 'sarak@gmail.com', '0887867456', 'sp_reservation', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-08-04', '/assets/img/profile_photo/research.jpg', 'Research Consultant', '200019602896', '0789657340', '2nd post mile', NULL, NULL, 'active', NULL, 500),
('SP-009', 'Raees', 'Ahamed', 'raeesahmd120@gmail.com', '0764953014', 'sp_products', '$2y$10$SkrSRW8wAYHWX4CAoQEGdObDaOECAZB6J33TI1mTMYFRuVzNuQEk6', '2024-10-17', '/assets/img/profile_photo/SP-009_1729376785_acer.jpg', 'Raees Shop', '200126001722', '0764953014', 'Badulla', NULL, NULL, 'active', 'Computer Shop', 50);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `token` varchar(100) NOT NULL,
  `user_id` varchar(10) NOT NULL,
  `password` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verify`
--

INSERT INTO `verify` (`token`, `user_id`, `password`, `created_at`, `expires_at`) VALUES
('4d1c18ad27eb71293a81f50a77d96d166e86c9f5f0cb5568a3d5c77cd6e6d29ff18de31a65f65a4b5fc6ed670f292937cdc8', 'SP-006', '$2y$10$jetqBoWLvTRCJfqsJNDa3OhpwEIHjqZ8qsYa5PlbnpDg2VW8m1IMi', '2024-10-17 20:26:59', '2024-10-17 20:36:59');

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

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
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `review_table`
--
ALTER TABLE `review_table`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
