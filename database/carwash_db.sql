-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2025 at 03:43 PM
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
-- Database: `carwash_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `service_type` enum('Basic Package','Standard Package','Premium Package','Ultimate Package') NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('Pending','Confirmed','Completed','Cancelled') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `phone`, `created_at`) VALUES
(1, 'juan dela guardia', 'juan@gmail.com', '12345', 'customer', '09171234567', '2025-10-04 01:53:30'),
(2, 'eivan casto', 'fake@gmail.com', '12345', 'customer', '09171234567', '2025-10-04 01:59:33'),
(3, 'paul vincent balolong', 'fake12@gmail.com', '123344', 'customer', '09171234567', '2025-10-04 02:27:15'),
(4, 'verlance garcia', 'verlance@gmail.com', '1224253', 'customer', '09171234567', '2025-10-04 02:27:53'),
(7, 'hello', 'haha@gmaio.com', '$2y$10$Vee6Xs7KhCCyWfAh.durBuzOUR7VtewQOjYS4NrLyiFhB2nwmq73S', 'customer', '123', '2025-10-09 02:05:30'),
(9, 'Admin', 'admin@gmail.com', '$2y$10$jX5CwYiCrgEhRC1sCVC9Vugb6/Uo0aF6RMrjtOk1.jJAqdUckeu0e', 'admin', '', '2025-10-11 03:27:37'),
(10, 'Eivan Castro', 'eivancastro0801@gmail.com', '$2y$10$vApBriMY1XlgejRB21uGr.BoXQcVPsS1MqaEY.yCyVkAavKIUVQ8q', 'customer', '09156048301', '2025-10-11 03:40:33'),
(11, 'Test User', 'testuser@gmail.com', '$2y$10$Ig7PF3bA2OtzJ0FwYv/SZOHAaEJPdu6OBTzA8cQBM5WozhKpWMt0G', 'customer', '123', '2025-10-12 08:18:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `INDEX` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
