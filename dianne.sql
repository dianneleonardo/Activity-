-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2025 at 09:50 PM
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
-- Database: `dianne`
--

-- --------------------------------------------------------

--
-- Table structure for table `login_attempt`
--

CREATE TABLE `login_attempt` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attempt` enum('success','failed') NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_attempt`
--

INSERT INTO `login_attempt` (`id`, `user_id`, `attempt`, `timestamp`) VALUES
(47, 13, 'success', '2025-05-01 22:13:01'),
(48, 11, 'success', '2025-05-01 23:14:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(9, 'dada@gmail.com', '$2y$10$wnq/ZB9/gV3QtjmG9ghbiuun4PTGT10.7kHaMHNzRJSaGF7PP184O'),
(10, 'dianne@gmail.com', '$2y$10$dXBSXRaafcuaQv8qY52rm.bpm0bm17j3g8G5wyy6TO2kdlclUofDG'),
(11, 'qqqq@gmail.com', '$2y$10$UuP1EUa14NUHIE/U2Cx62.XCfu7cnrqs5B0GyXTIB24FD6ozsPcoG'),
(12, 'dianne1111@gmail.com', '$2y$10$SZSM0jMAKgU0538DSHONveEmCXPtPmSz1y9YQ2WgmSq2GeYY67Ccu'),
(13, 'dianne111@gmail.com', '$2y$10$cbA06ZPkLSy/4.amGiw0mOn887qX0AL0ZO0Zs0cNYf9VH9sWbtDea'),
(14, 'qqqqq@gmail.com', '$2y$10$P2CjOjp0mAE4WC7b0tjZeOo1JtCNdP5hDjyLmXC0sm/lQKuIEiRtG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_attempt`
--
ALTER TABLE `login_attempt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempt`
--
ALTER TABLE `login_attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_attempt`
--
ALTER TABLE `login_attempt`
  ADD CONSTRAINT `login_attempt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
