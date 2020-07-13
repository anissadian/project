-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 13, 2020 at 05:41 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project00`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `sender_id`, `receiver_id`) VALUES
(1, 9, 12);

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id_messages` int(11) NOT NULL,
  `id_chat` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `chat_text` text NOT NULL,
  `chat_status` char(1) NOT NULL,
  `chat_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id_messages`, `id_chat`, `sender_id`, `receiver_id`, `chat_text`, `chat_status`, `chat_datetime`) VALUES
(1, 1, 9, 12, 'test', '0', '2020-07-12 14:09:54'),
(2, 1, 9, 12, 'test2', '0', '2020-07-12 14:09:54'),
(3, 1, 12, 9, 'reply', '0', '2020-07-12 11:00:00'),
(8, 1, 9, 12, 'kirim', '0', '2020-07-12 12:50:22'),
(9, 1, 9, 12, 'kirim lagi', '0', '2020-07-12 12:51:08'),
(10, 1, 9, 12, 'test lagi', '0', '2020-07-12 12:52:41'),
(11, 1, 9, 12, 'last one', '0', '2020-07-12 12:53:18'),
(12, 1, 9, 12, 'submit', '0', '2020-07-12 12:56:18'),
(13, 1, 9, 12, 'okey', '0', '2020-07-12 12:56:30'),
(18, 1, 9, 12, 'cek cek 123', '0', '2020-07-12 15:02:40'),
(20, 1, 9, 12, 'test', '0', '2020-07-12 15:23:54'),
(21, 1, 12, 9, 'dorr', '0', '2020-07-12 15:24:30'),
(22, 1, 9, 12, 'der', '0', '2020-07-12 15:25:06'),
(23, 1, 9, 12, 'asdasd', '0', '2020-07-12 15:29:47'),
(24, 1, 9, 12, 'qwerty', '0', '2020-07-12 15:30:32'),
(25, 1, 9, 12, 'test', '0', '2020-07-12 21:21:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `oauth_provider` varchar(50) DEFAULT NULL,
  `oauth_id` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `locale` varchar(10) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `link` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `device_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `oauth_provider`, `oauth_id`, `first_name`, `last_name`, `email`, `password`, `gender`, `locale`, `picture`, `link`, `create_time`, `update_time`, `device_token`) VALUES
(9, NULL, '102316251807660073139', 'Muhammad Fakhrul', 'Arifin', 'mfakhrularifin@gmail.com', NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a-/AOh14GiI-1EGJjBgMZ8CErnwx7EseS57jmL-c_C7Yie0Yg', '', '2020-07-11 11:23:30', '2020-07-12 06:20:08', 'fhC9kdLPdq4XOWLI9TLfv1:APA91bHg9a7ZcJcafS3zrxqDVHaI5g3a-LLCQqrWKtTnLurXsbNeFmcpTJWxunm-v_0LCwwdB2Tz7GIItw60-wKaepbEEZaG3txbf-POX8lmMd68qOoqvYMtkvIfe6e168Fte8-F3NFX'),
(12, NULL, '107734210756787877817', 'Calico', 'Cat', 'arifin.fakhrul44@gmail.com', NULL, NULL, NULL, 'https://lh3.googleusercontent.com/a-/AOh14Ghe3J2ZR2gv2qCgLOBEpprOEI5ujddkrWV-4uYT', '', '2020-07-12 05:43:55', '2020-07-12 13:49:52', 'daFG-gpdO_J5XVh9l7WqiT:APA91bERkoAwkslxD6orsYnuTzxZVMiLwNWmFxxo_GakxDM4tgg6WwJUQBMk0Gk_iDMh8GZpAuVK5zJTQ1bPMjfhNZRvCHdTzyi3NDofKQZqRQokkxJdZjw0XkNKVDLBk6Cv_5egYWcF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD UNIQUE KEY `id_messages_2` (`id_messages`),
  ADD KEY `id_messages` (`id_messages`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id_messages` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
