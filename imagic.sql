-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2016 at 09:36 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imagic`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `size` int(20) DEFAULT NULL,
  `upload_time` int(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_id` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(10000) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(10000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `size`, `upload_time`, `user_id`, `file_id`, `tags`, `title`) VALUES
(1, 12, 1465151680, 3, '1', 'profile watermelon superhot', 'wow I look good in this'),
(2, 0, 0, 3, 'f7288e30cf51fb74948ef60a56e21db8', 'uml work', 'some uml'),
(3, 0, 0, 3, '9ef71661c9092240e49556198c348d0c', 'uml work', 'some uml'),
(4, 0, 0, 3, 'efa770424a63fd64c73f8b119c6a7ec8', 'uml work', 'some uml'),
(6, 238352, 238352, 3, 'b7ea96fc1b52be06b7d716a431834589', 'pr&auml;misse yay', 'df'),
(7, 238352, 238352, 11, '9c110512057481a4a71e2d7b249cea65', 'pr&auml;misse deutsch', 'Pr&auml;missen'),
(8, 97359, 97359, 11, '2ee6672c1e642e52709e36141869bc30', 'brain on', 'ssdf');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test` varchar(2) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`test`) VALUES
('ok');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `signup_time` int(20) NOT NULL,
  `profile_image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `permission_level` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `pass`, `signup_time`, `profile_image`, `permission_level`) VALUES
(3, 'admin', 'schaer.marius@gmail.com', '$2a$12$DYydcauzW49InRb86ges.OXVuZE6qDURuSpf61rcXMy2OCFK15fPy', 1456185600, '1', 0),
(4, 'testuser', '2@2.ch', '$2a$12$Pkoq9yLZlt1Fbuunt3hIrOYzyxGtikXlqzGZNVraxbsEyclLV4G0a', 1465075690, '2', 1),
(11, 's&auml;ndr&auml;', 'sandra@com.com', '$2y$15$GywaQJs4kWxQqZPj12DcbOr29Cswhai05hxeJloUl5.FUW8nWKDFe', 1465282963, '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uri` (`file_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
