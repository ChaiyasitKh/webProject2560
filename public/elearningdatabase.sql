-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2017 at 05:08 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearningdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `practices`
--

CREATE TABLE `practices` (
  `sub_id` char(7) NOT NULL,
  `pract_id` int(5) NOT NULL,
  `pract_name` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `send_late` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `practices`
--

INSERT INTO `practices` (`sub_id`, `pract_id`, `pract_name`, `created_at`, `updated_at`, `send_late`) VALUES
('1101111', 1, 'work1', '2017-05-23 12:21:17', '2017-05-23 12:21:17', '2017-05-24 05:00:00'),
('1101111', 2, 'work2', '2017-05-23 12:28:52', '2017-05-23 15:02:02', '2017-05-24 06:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `sub_id` char(7) NOT NULL,
  `pract_id` int(5) NOT NULL,
  `id` int(10) NOT NULL,
  `score` float(5,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`sub_id`, `pract_id`, `id`, `score`, `created_at`, `updated_at`) VALUES
('1101111', 1, 9, 7.00, '2017-05-23 12:37:41', '2017-05-23 12:37:41'),
('1101111', 1, 12, 9.00, '2017-05-23 14:44:13', '2017-05-23 14:44:13'),
('1101111', 1, 16, 9.00, '2017-05-23 13:55:05', '2017-05-23 13:55:05'),
('1101111', 2, 9, 6.00, '2017-05-23 12:48:09', '2017-05-23 12:48:09'),
('1101111', 2, 10, 10.00, '2017-05-23 13:57:11', '2017-05-23 13:57:11'),
('1101111', 2, 16, 8.50, '2017-05-23 14:11:34', '2017-05-23 14:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(10) NOT NULL,
  `sub_id` char(7) NOT NULL,
  `sub_name` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `sub_id`, `sub_name`, `created_at`, `updated_at`) VALUES
(8, '1101111', 'ความรู้ทั่วไป', '2017-05-23 12:19:19', '2017-05-23 12:19:19'),
(9, '1101111', 'ความรู้ทั่วไป', '2017-05-23 12:34:57', '2017-05-23 12:34:57'),
(10, '1101111', 'ความรู้ทั่วไป', '2017-05-23 12:51:35', '2017-05-23 12:51:35'),
(11, '1101111', 'ความรู้ทั่วไป', '2017-05-23 13:00:08', '2017-05-23 13:00:08'),
(12, '1101111', 'ความรู้ทั่วไป', '2017-05-23 13:00:55', '2017-05-23 13:00:55'),
(13, '1101111', 'ความรู้ทั่วไป', '2017-05-23 13:01:34', '2017-05-23 13:01:34'),
(14, '1101111', 'ความรู้ทั่วไป', '2017-05-23 13:02:15', '2017-05-23 13:02:15'),
(15, '1101111', 'ความรู้ทั่วไป', '2017-05-23 13:02:54', '2017-05-23 13:02:54'),
(16, '1101111', 'ความรู้ทั่วไป', '2017-05-23 13:03:41', '2017-05-23 13:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `student_id` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `student_id`, `name`, `email`, `password`, `status`, `gender`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, NULL, 'อ.ขาม นามสมมุติ', 'kham@ubu.com', '$2y$10$DGUnA5ffb9IkiIUVWCP9ee4zON4ccfWrg91HR.B5Qjg8dci1x2fJW', 'Teacher', 'Male', 'Xo6J2wybrT0iSJ4oNiKO7CoIoxhVOsMzW9aZETAiVIVpHSALu9d4uaLohtV2', '2017-05-23 12:18:24', '2017-05-23 12:18:24'),
(9, '5711403148', 'นายกิตติพงษ์ สุดชา', 'kittipong@ubu.com', '$2y$10$GbIEFQVUeYW2bLWQH.8qxeXoMtzpnuHgYbrA0jwN2OhOKStKgDHUa', 'Student', 'Male', 'nmlPpj8blKh0nKNSSyj4N0jlPC3EiBxVRnFGuz642U3fJz4Ff9ZdmdrtTi4f', '2017-05-23 12:34:38', '2017-05-23 12:34:38'),
(10, '5711403157', 'นางสาวเกวลี เดโชชัยพร', 'kawalee@ubu.com', '$2y$10$jL6Uns2od2UqiqbGuBaAFuqISxCdgLEmB/5uzBKXq0iiQAG0IsYbi', 'Student', 'Female', 'GCtgnZJtfIr2IJVJM0K4GsVlrgats6nTGNNSNVb3FhikjPOHLMLyfHjiaroN', '2017-05-23 12:51:27', '2017-05-23 12:51:27'),
(11, '5711403171', 'นางสาวจีรนันท์ ล้ำจุมจัง', 'geeranan@ubu.com', '$2y$10$EIoh7NbbHj8lbL0MESJW9eoLexJn4JvPc/Rj77K7/PaGMMH1123kG', 'Student', 'Female', 'UClQoJnbKZqznKozuY6ogY9myrsE4n0PEN6ANzxr0wDxTuoI1OeH985vujJC', '2017-05-23 13:00:02', '2017-05-23 13:00:02'),
(12, '5711403229', 'นายณัฐพล มารุตะพันธ์', 'nuttapon@ubu.com', '$2y$10$6h96IxiaQpkLNmeCyX24y.dYFIhtYiB11ogL14.VB0eezbR5R/Uqm', 'Student', 'Male', 'gUwSXQ06TnE0DCODzGGmQxGfGiOh6jQgpNTrDK2CdmUXPajUBlQPX8Js4AH2', '2017-05-23 13:00:48', '2017-05-23 13:00:48'),
(13, '5711403241', 'นายทรงศักดิ์ วันทา', 'songsak@ubu.com', '$2y$10$Ag9yA1gNEvdU3P/tTPvZvOu4kxc.ywNHy03v.xLisU7oW9NZJKsIa', 'Student', 'Male', 'QeoxG5vy7hSehL7UVql6jTiLVjDfi6Lt9AyzcDZa8Mjmqy8oXyxHIinC7nl5', '2017-05-23 13:01:28', '2017-05-23 13:01:28'),
(14, '5711403296', 'นายเผด็จ คำวงษ์', 'paded@ubu.com', '$2y$10$Vo160PPTRMz6Ja2wobzn7uk9O7CqTKye//zEOUPrQouwsOyBOmVCK', 'Student', 'Male', 'ZF4sHyJGwsDyXaXnDQdtPbs6joFIo1yjDQhHXoczBOTX7Fzji9VtjJNdUgwx', '2017-05-23 13:02:10', '2017-05-23 13:02:10'),
(15, '5711403498', 'นายอลงกรณ์ ดวงชัย', 'alongkorn@ubu.com', '$2y$10$ZeVMaPdEYIiIbsZCY48YauB4BSSD44E1TcGaD504Osz1mJwhnAN6K', 'Student', 'Male', 'tBggPv7iuVOtF045TndrhKxM0ThEkBNKzxOJqaIaCzObejP3FTC8zVru9zK2', '2017-05-23 13:02:50', '2017-05-23 13:02:50'),
(16, '5711403346', 'นางสาวภาวิณี ปุราชะนัย', 'pawinee@ubu.com', '$2y$10$21.T.0M/wCpCUuuEcoE0BOUgdwph0FdITy.Zt.45DN3ui9jeHkFUC', 'Student', 'Female', '6xlFV9VhDdoPzvohuaRy2eVPDtO99duFit6EtMBCTVjtK7EYh91KtFNcYne7', '2017-05-23 13:03:29', '2017-05-23 13:03:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `practices`
--
ALTER TABLE `practices`
  ADD PRIMARY KEY (`sub_id`,`pract_id`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD PRIMARY KEY (`sub_id`,`pract_id`,`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`,`sub_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
