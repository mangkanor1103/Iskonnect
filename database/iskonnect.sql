-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2025 at 06:02 AM
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
-- Database: `iskonnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `role`) VALUES
(13, 'testuser', '$2y$10$0hzg9Ic2UdJSTPr.UksbHOKcgqBTCK23Q1dZvpfca7iqW3evV1Uxe', '2025-05-09 12:08:05', 'admin'),
(35, 'admin', '$2y$10$2mV4/lOlrPrSo2epeKqSueORyk.Jq.UvWtyKwmuBMkh.64YP2/g6O', '2025-05-09 12:46:03', 'staff'),
(49, 'Rhea Melchor', '$2y$10$poEsXpUQCp5DuXOfBWjECOP2sYqjmr7k2Vj3inbibi9ULruFBZsGq', '2025-05-09 12:55:15', 'staff'),
(54, 'Rica Melchor', '$2y$10$uRCWnSSTW2vciEOkasoWJuhTh04BRRE5OINRqsPMl/XWaTsZOiBpK', '2025-05-09 12:58:16', 'staff'),
(95, 'rheamelchor@gmail.com', '$2y$10$.ZINmaoGxNox8fUDhL6ByODjIwxrDuPjgl7Yo9caFkaLJrVpil8pG', '2025-05-09 13:15:37', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=164;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
