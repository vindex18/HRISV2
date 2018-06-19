-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2018 at 12:26 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hris`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `datetime` datetime DEFAULT NULL,
  `emp_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `type_id`, `datetime`, `emp_id`, `created_at`, `updated_at`) VALUES
(8, 1, '2018-06-06 09:00:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(9, 2, '2018-06-06 10:00:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(10, 3, '2018-06-06 10:15:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(11, 2, '2018-06-07 12:00:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(12, 3, '2018-06-08 13:00:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(13, 2, '2018-06-09 15:00:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(14, 3, '2018-06-09 15:15:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(15, 4, '2018-06-18 18:00:00', 1, '2018-06-19 14:32:30', '2018-06-19 14:32:30'),
(16, 1, '2018-06-19 09:00:00', 1, '2018-06-19 14:32:30', '2018-06-19 14:32:30'),
(17, 2, '2018-06-19 10:00:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(18, 4, '2018-06-19 18:00:00', 1, '2018-06-19 14:32:30', '2018-06-19 14:32:30'),
(19, 3, '2018-06-19 10:15:00', 1, '2018-06-11 00:00:00', '2018-06-11 00:00:00'),
(21, 1, '2018-06-20 09:00:00', 1, '2018-06-19 14:32:30', '2018-06-19 14:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `attendancetype`
--

CREATE TABLE `attendancetype` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendancetype`
--

INSERT INTO `attendancetype` (`id`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, 'TI', 'Time In', '2018-06-09 00:00:00', '2018-06-18 00:00:00'),
(2, 'BO', 'Break Out', '2018-06-18 00:00:00', '2018-06-18 00:00:00'),
(3, 'BI', 'Break In', '2018-06-18 00:00:00', '2018-06-18 00:00:00'),
(4, 'TO', 'Time Out', '2018-06-18 00:00:00', '2018-06-18 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pos_title` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `first_name`, `middle_name`, `last_name`, `phone`, `email`, `address`, `pos_title`, `password`, `is_admin`, `created_at`, `updated_at`, `is_active`) VALUES
(1, 'Neil Daryl', 'Reyes', 'Sulit', '0945-362-7267', 'neil@invento.io', '667 Sucat, Muntinlupa City', 'Junior Web Developer', '$2y$10$Ry6TpxJLv9Re4swyS.9FDO.NWy3ettYe4JPhg3F5UqDT3T6XKwhS6', 0, '2018-06-10 11:05:19', '2018-06-10 11:05:19', 1),
(2, 'Ivan Roir', '', 'Bruselas', '0945-362-7267', 'ivan@invento.io', 'Las Piñas', 'Junior Web Developer', '$2y$10$dA6.0kpb6W.qUuo2XSI/1.xDDzrJBPX2bfJJWizoso6G7c25KjZsu', 0, '2018-06-19 16:02:55', '2018-06-19 16:02:55', 1),
(3, 'Jan Myckel', 'Labayog', 'Perez', '0929-208-6707', 'jan@invento.io', 'Las Piñas City', 'Junior Web Developer', '$2y$10$vNMFaglzTx1TMvmIBWmGweMSpXtmiWTaqXJ7lxXZQJDPAaA9aW0me', 0, '2018-06-13 10:46:02', '2018-06-13 10:46:02', 1),
(4, 'Camille Franchesca', '', 'Cuisa', '0912-345-6789', 'camille@invento.io', 'Las Piñas', 'Web Designer', '$2y$10$lrCXwl1J1gTVWi7lgOBuNehG6cLkdCHPkdG1i9UyYKrrB0UFoumha', 0, '2018-06-19 15:20:42', '2018-06-19 15:20:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `revoked_tokens`
--

CREATE TABLE `revoked_tokens` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `iss` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `token_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `attendancetype`
--
ALTER TABLE `attendancetype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revoked_tokens`
--
ALTER TABLE `revoked_tokens`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `attendancetype`
--
ALTER TABLE `attendancetype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `revoked_tokens`
--
ALTER TABLE `revoked_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `attendancetype` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
