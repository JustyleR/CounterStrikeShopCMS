-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2018 at 11:44 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `flags`
--

CREATE TABLE `flags` (
  `flag_id` int(11) NOT NULL,
  `flag` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `flagDesc` text COLLATE utf8_unicode_ci NOT NULL,
  `price` float(11,2) NOT NULL,
  `server` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flag_history`
--

CREATE TABLE `flag_history` (
  `flag_id` int(11) NOT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `flag` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `dateBought` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `dateExpire` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `server` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `log_id` int(11) NOT NULL,
  `user` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `log` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `link_name` varchar(50) NOT NULL,
  `link_page` varchar(50) NOT NULL,
  `logged` int(11) DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_keys`
--

CREATE TABLE `password_keys` (
  `key_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_key` varchar(200) NOT NULL,
  `expireDate` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `servers`
--

CREATE TABLE `servers` (
  `server_id` int(11) NOT NULL,
  `csbans_id` int(11) NOT NULL,
  `shortname` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_codes`
--

CREATE TABLE `sms_codes` (
  `sms_code_id` int(11) NOT NULL,
  `code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `balance` float(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_text`
--

CREATE TABLE `sms_text` (
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `home` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nicknamePass` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `lang` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'en',
  `balance` float(11,2) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `ipAdress` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `registerDate` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flags`
--
ALTER TABLE `flags`
  ADD PRIMARY KEY (`flag_id`);

--
-- Indexes for table `flag_history`
--
ALTER TABLE `flag_history`
  ADD PRIMARY KEY (`flag_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `password_keys`
--
ALTER TABLE `password_keys`
  ADD PRIMARY KEY (`key_id`);

--
-- Indexes for table `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`server_id`);

--
-- Indexes for table `sms_codes`
--
ALTER TABLE `sms_codes`
  ADD PRIMARY KEY (`sms_code_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flags`
--
ALTER TABLE `flags`
  MODIFY `flag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `flag_history`
--
ALTER TABLE `flag_history`
  MODIFY `flag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `password_keys`
--
ALTER TABLE `password_keys`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `servers`
--
ALTER TABLE `servers`
  MODIFY `server_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_codes`
--
ALTER TABLE `sms_codes`
  MODIFY `sms_code_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
