-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2021 at 11:37 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spend_it`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `emailid` varchar(30) NOT NULL,
  `admin_name` varchar(30) DEFAULT NULL,
  `admin_mob` varchar(10) DEFAULT NULL,
  `password` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` bigint(20) NOT NULL,
  `categories_name` text NOT NULL,
  `u_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `categories_name`, `u_id`) VALUES
(1, 'Petrol', 1),
(2, 'Food', 1),
(3, 'Money', 1),
(4, 'Tickets', 1),
(5, 'Shopping', 1),
(6, 'Movies', 1),
(7, 'Petrol', 3),
(8, 'Total', 3),
(9, 'by', 1),
(10, 'guuf', 1),
(11, 'budy', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category_set_amount`
--

CREATE TABLE `category_set_amount` (
  `set_amount_id` bigint(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `amount_set` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category_set_amount`
--

INSERT INTO `category_set_amount` (`set_amount_id`, `category_id`, `amount_set`, `user_id`, `created_at`) VALUES
(1, 2, 10000, 1, '2021-03-13 05:37:39'),
(2, 1, 1000, 1, '2021-03-13 07:13:34'),
(3, 4, 500, 1, '2021-03-13 07:58:38'),
(4, 3, 100, 1, '2021-03-13 07:58:53'),
(5, 5, 1500, 1, '2021-03-13 08:00:27'),
(6, 6, 1000, 1, '2021-03-16 11:07:11'),
(7, 7, 700, 3, '2021-03-16 11:09:19'),
(8, 8, 100, 3, '2021-03-16 11:13:27'),
(9, 11, 10, 1, '2021-03-23 04:50:40');

-- --------------------------------------------------------

--
-- Table structure for table `manage_category`
--

CREATE TABLE `manage_category` (
  `Category_id` int(30) DEFAULT NULL,
  `Category_name` varchar(30) DEFAULT NULL,
  `Category_details` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `manage_query`
--

CREATE TABLE `manage_query` (
  `Q_id` int(11) NOT NULL,
  `U_ID` int(11) NOT NULL,
  `U_email` varchar(50) DEFAULT NULL,
  `Q_Details` varchar(200) DEFAULT NULL,
  `Q_Post_Date` date DEFAULT NULL,
  `Query_Responce` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `set_amount`
--

CREATE TABLE `set_amount` (
  `amount_id` bigint(20) NOT NULL,
  `amount` int(5) DEFAULT NULL,
  `category_id` bigint(20) NOT NULL,
  `set_amount_id` int(5) NOT NULL,
  `u_id` bigint(20) NOT NULL,
  `amt_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `set_amount`
--

INSERT INTO `set_amount` (`amount_id`, `amount`, `category_id`, `set_amount_id`, `u_id`, `amt_date`) VALUES
(1, 150, 1, 2, 1, '2021-03-23'),
(2, 280, 4, 3, 1, '2021-03-23'),
(3, 200, 4, 3, 1, '2021-03-23'),
(4, 55, 4, 3, 1, '2021-03-23'),
(5, 150, 1, 2, 1, '2021-03-23'),
(6, 150, 1, 2, 1, '2021-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `useful_tips`
--

CREATE TABLE `useful_tips` (
  `Tip_id` int(11) NOT NULL,
  `Tips_Name` varchar(50) DEFAULT NULL,
  `Tips_Category` varchar(50) DEFAULT NULL,
  `Tips_Details` varchar(50) DEFAULT NULL,
  `Tips_Up_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_registration`
--

CREATE TABLE `user_registration` (
  `u_id` bigint(20) NOT NULL,
  `u_name` varchar(30) DEFAULT NULL,
  `u_email` varchar(30) DEFAULT NULL,
  `u_password` varchar(20) DEFAULT NULL,
  `u_mob` bigint(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_registration`
--

INSERT INTO `user_registration` (`u_id`, `u_name`, `u_email`, `u_password`, `u_mob`) VALUES
(1, 'Alok Rathava', 'alokrathava@gmail.com', 'admin123', 9512334819),
(2, 'Alok Rathava', 'alokrathava@gmail.com', 'admin', 951233819),
(3, 'Hit Patel', 'hit@gmail.com', '12345678', 9696969699),
(4, '1', '1', '1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `category_set_amount`
--
ALTER TABLE `category_set_amount`
  ADD PRIMARY KEY (`set_amount_id`);

--
-- Indexes for table `manage_query`
--
ALTER TABLE `manage_query`
  ADD PRIMARY KEY (`Q_id`);

--
-- Indexes for table `set_amount`
--
ALTER TABLE `set_amount`
  ADD PRIMARY KEY (`amount_id`);

--
-- Indexes for table `useful_tips`
--
ALTER TABLE `useful_tips`
  ADD PRIMARY KEY (`Tip_id`);

--
-- Indexes for table `user_registration`
--
ALTER TABLE `user_registration`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `category_set_amount`
--
ALTER TABLE `category_set_amount`
  MODIFY `set_amount_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `set_amount`
--
ALTER TABLE `set_amount`
  MODIFY `amount_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_registration`
--
ALTER TABLE `user_registration`
  MODIFY `u_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
