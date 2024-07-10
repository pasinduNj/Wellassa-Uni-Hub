-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 01, 2024 at 11:33 PM
-- Server version: 8.3.0
-- PHP Version: 8.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `User_reg`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `Email` varchar(300) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`Email`, `user_name`, `password`, `reg_date`) VALUES
('', '', '$2y$10$i23TvIPU83HwIsHzlKiA.ede94LmmXpSVqBEtppHSwQ36ChEU.7Ai', '2024-07-02 04:53:39'),
('ascc@gmail.com', 'sdsd', '$2y$10$jpwsmGEtuUs0zMyJSyDJ4eF9/FWyjVFqkPy6ZHyeY0dRZFiGE5ujS', '2024-07-02 04:23:37'),
('pasindunaveen87@gmail.com', 'pasindujay', '$2y$10$j62tgnzR5b5ZaK9TV8fLIOzxWIKmiHrg10E/5f388rm2gTnVrJPDO', '2024-07-02 04:33:14'),
('pasindunaveenjay@gmail.com', 'pscasc', '$2y$10$asyyZdqRCc9fstc5KynWyeEdP6/G6wo7w/gkx/TEQHWyLmRdXmz.O', '2024-07-02 04:26:06'),
('raessfuck@gmial', 'raess', '$2y$10$WG8JcZVtkuiIG8.LDRekmeL2fV/KYNSCAKwZtRe2vI7khxiZF7u..', '2024-07-02 04:57:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`Email`),
  ADD UNIQUE KEY `user_name` (`user_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
