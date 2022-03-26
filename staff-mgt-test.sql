-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2022 at 12:41 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `staff-mgt-test`
--

-- --------------------------------------------------------

--
-- Table structure for table `salary_log`
--

CREATE TABLE `salary_log` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `salary_amount` int(11) NOT NULL,
  `admin_bal` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `app_name` varchar(255) NOT NULL,
  `app_domain` varchar(255) NOT NULL,
  `app_tagline` varchar(255) NOT NULL,
  `app_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `app_domain`, `app_tagline`, `app_email`) VALUES
(1, 'Staffa', 'http://localhost:8000/', 'Staff Management Portal', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pin` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `wallet` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `address`, `phone`, `password`, `pin`, `role`, `wallet`, `status`, `create_date`) VALUES
(1, 'Demo', 'Admin', 'demoadmin@staffa.com', '', '09034787969', '$2y$10$e0fBMouATCZ8v9NPd7mQ/ec7iidNDHlBTlrHcxEL3Us3RhccT6QBO', 2468, 1, 1000000, 1, '2022-03-26 12:41:38'),
(2, 'Demo', 'Staff', 'demostaff@staffa.com', '', '09034787969', '$2y$10$yAm4V2mrzWWtK/NpK.DRIeIKstUL6I71GwD52Sh0NhYzSDMVSCd.G', 1234, 2, 0, 1, '2022-03-26 12:41:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `salary_log`
--
ALTER TABLE `salary_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `salary_log`
--
ALTER TABLE `salary_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
