-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 03, 2020 at 10:40 AM
-- Server version: 5.7.24
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `oop`
--

-- --------------------------------------------------------

--
-- Table structure for table `child`
--

CREATE TABLE `child` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  `name` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL,
  `roll_no` int(11) NOT NULL DEFAULT '1',
  `address` varchar(250) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `child`
--

INSERT INTO `child` (`id`, `parent_id`, `is_active`, `name`, `email`, `roll_no`, `address`, `created_at`) VALUES
(1, 1, 1, 'Mahmudul', 'mahmudul@gmail.com', 1, 'ayubpur', '2020-12-02 14:08:52'),
(2, 2, 1, 'Saiful Islam', 'saifulislam@gmail.com', 2, 'Ayubpur, Shibpur, Narsingdi', '2020-12-02 14:08:52'),
(3, 1, 1, 'Mohammod Ali', 'mohammodali@gmail.com', 4, NULL, '2020-12-02 15:55:46'),
(4, 3, 1, 'Khalid Saifullah', 'khalidsaifullah@gmail.com', 4, NULL, '2020-12-02 18:04:40'),
(5, 3, 1, 'Changed update', 'test@gmail.com', 7, NULL, '2020-12-03 01:06:20'),
(6, 1, 1, 'test two', 'tow@gmail.com', 6, NULL, '2020-12-03 01:08:14'),
(7, 3, 1, 'Md. Selim', 'selim@gmail.com', 8, NULL, '2020-12-03 01:38:41');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL,
  `roll` int(11) DEFAULT NULL,
  `balance` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`id`, `name`, `email`, `roll`, `balance`, `created_at`) VALUES
(1, 'Abdul Mannan Khan', 'abdulmannankhan@gmail.com', NULL, 212154778, '2020-12-03 04:19:21'),
(2, 'Mohammadullah', 'mohammadullah@gmail.com', NULL, 1587, '2020-12-03 04:20:13'),
(3, 'Abdullah', 'abdullah@gmail.com', NULL, 3587, '2020-12-03 04:20:57'),
(4, 'Saifullah', 'saifullah@gmail.com', NULL, 2943, '2020-12-03 04:21:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `child`
--
ALTER TABLE `child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `child`
--
ALTER TABLE `child`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
