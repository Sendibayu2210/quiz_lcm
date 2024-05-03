-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2024 at 06:08 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gethouseofenglish`
--

-- --------------------------------------------------------

--
-- Table structure for table `answered_users`
--

CREATE TABLE `answered_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_answered` varchar(11) DEFAULT NULL,
  `id_multiple_choice` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `answered_users`
--

INSERT INTO `answered_users` (`id`, `id_user`, `id_question`, `id_answered`, `id_multiple_choice`, `created_at`, `updated_at`) VALUES
(249, 8, 720, '51', '53,50,51,52', '2024-04-26 10:39:19', '2024-04-26 10:39:29'),
(250, 8, 74, '83', '84,83,85', '2024-04-26 10:39:19', '2024-04-26 10:39:32'),
(251, 8, 921, '18', '19,18,20', '2024-04-26 10:39:19', '2024-04-26 10:39:35'),
(252, 8, 445, NULL, '65,62,63,64', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(253, 8, 241, NULL, '45,42,43,44', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(254, 8, 737, NULL, '59,58,61', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(255, 8, 91, NULL, '49,46,47,48', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(256, 8, 661, NULL, '41,38,39,40', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(257, 8, 959, NULL, '33,30,31,32', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(258, 8, 247, NULL, '57,54,55,56', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(259, 8, 815, NULL, '69,66,67,68', '2024-04-26 10:39:19', '2024-04-26 10:39:19'),
(260, 8, 117, NULL, '37,34,35,36', '2024-04-26 10:39:19', '2024-04-26 10:39:19');

-- --------------------------------------------------------

--
-- Table structure for table `multiple_choice`
--

CREATE TABLE `multiple_choice` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_question` int(11) NOT NULL,
  `choice_text` varchar(255) NOT NULL,
  `is_correct` enum('true','false') NOT NULL DEFAULT 'false',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `multiple_choice`
--

INSERT INTO `multiple_choice` (`id`, `id_question`, `choice_text`, `is_correct`, `created_at`, `updated_at`) VALUES
(18, 921, 'compliment acceptance', 'true', '2024-04-07 20:27:56', '2024-04-08 12:13:52'),
(19, 921, 'compliment deflection', 'false', '2024-04-07 20:27:56', '2024-04-08 12:13:52'),
(20, 921, 'compliment rejection', 'false', '2024-04-07 20:27:56', '2024-04-08 12:13:52'),
(30, 959, ' London', 'false', '2024-04-08 12:26:17', '2024-04-08 12:26:17'),
(31, 959, 'Paris', 'true', '2024-04-08 12:26:17', '2024-04-08 12:26:17'),
(32, 959, 'Rome', 'false', '2024-04-08 12:26:17', '2024-04-08 12:26:17'),
(33, 959, 'Berlin', 'false', '2024-04-08 12:26:17', '2024-04-08 12:26:17'),
(34, 117, 'Earth', 'false', '2024-04-08 12:26:53', '2024-04-08 12:26:53'),
(35, 117, 'Mars', 'true', '2024-04-08 12:26:53', '2024-04-08 12:26:53'),
(36, 117, 'Jupiter', 'false', '2024-04-08 12:26:53', '2024-04-08 12:26:53'),
(37, 117, 'Saturn', 'false', '2024-04-08 12:26:53', '2024-04-08 12:26:53'),
(38, 661, 'William Shakespeare', 'true', '2024-04-08 12:27:31', '2024-04-08 12:27:31'),
(39, 661, 'Jane Austen', 'false', '2024-04-08 12:27:31', '2024-04-08 12:27:31'),
(40, 661, 'Charles Dickens', 'false', '2024-04-08 12:27:31', '2024-04-08 12:27:31'),
(41, 661, 'Mark Twain', 'false', '2024-04-08 12:27:31', '2024-04-08 12:27:31'),
(42, 241, 'Hippopotamus', 'false', '2024-04-08 12:28:05', '2024-04-08 12:28:05'),
(43, 241, 'Giraffe', 'false', '2024-04-08 12:28:05', '2024-04-08 12:28:05'),
(44, 241, 'Blue whale', 'true', '2024-04-08 12:28:05', '2024-04-08 12:28:05'),
(45, 241, 'Elephant', 'false', '2024-04-08 12:28:05', '2024-04-08 12:28:05'),
(46, 91, 'South Korea', 'false', '2024-04-08 12:28:49', '2024-04-08 12:28:49'),
(47, 91, 'India', 'false', '2024-04-08 12:28:49', '2024-04-08 12:28:49'),
(48, 91, 'Japan', 'true', '2024-04-08 12:28:49', '2024-04-08 12:28:49'),
(49, 91, 'China', 'false', '2024-04-08 12:28:49', '2024-04-08 12:28:49'),
(50, 720, 'Michelangelo', 'false', '2024-04-08 12:29:27', '2024-04-08 12:29:27'),
(51, 720, 'Leonardo da Vinci', 'true', '2024-04-08 12:29:27', '2024-04-08 12:29:27'),
(52, 720, 'Pablo Picasso', 'false', '2024-04-08 12:29:27', '2024-04-08 12:29:27'),
(53, 720, 'Vincent van Gogh', 'false', '2024-04-08 12:29:27', '2024-04-08 12:29:27'),
(54, 247, 'Dollar', 'false', '2024-04-08 12:29:56', '2024-04-08 12:29:56'),
(55, 247, 'Euro', 'false', '2024-04-08 12:29:56', '2024-04-08 12:29:56'),
(56, 247, 'Yuan', 'false', '2024-04-08 12:29:56', '2024-04-08 12:29:56'),
(57, 247, 'Yen', 'true', '2024-04-08 12:29:56', '2024-04-08 12:29:56'),
(58, 737, 'Blue', 'true', '2024-04-08 12:30:31', '2024-04-08 12:30:31'),
(59, 737, 'Green', 'false', '2024-04-08 12:30:31', '2024-04-08 12:30:31'),
(61, 737, 'Pink', 'false', '2024-04-08 12:30:31', '2024-04-08 12:30:31'),
(62, 445, 'Pacific Ocean', 'true', '2024-04-08 12:31:04', '2024-04-08 12:31:04'),
(63, 445, 'Arctic Ocean', 'false', '2024-04-08 12:31:04', '2024-04-08 12:31:04'),
(64, 445, 'Atlantic Ocean', 'false', '2024-04-08 12:31:04', '2024-04-08 12:31:04'),
(65, 445, 'Indian Ocean', 'false', '2024-04-08 12:31:04', '2024-04-08 12:31:04'),
(66, 815, 'John Adams', 'false', '2024-04-08 12:31:37', '2024-04-08 12:31:37'),
(67, 815, 'Thomas Jefferson', 'false', '2024-04-08 12:31:37', '2024-04-08 12:31:37'),
(68, 815, 'George Washington', 'true', '2024-04-08 12:31:37', '2024-04-08 12:31:37'),
(69, 815, 'Abraham Lincoln', 'false', '2024-04-08 12:31:37', '2024-04-08 12:31:37'),
(83, 74, 'She is cooking dinner right now.', 'false', '2024-04-20 22:18:48', '2024-04-20 22:24:37'),
(84, 74, 'They will go to the beach tomorrow.', 'true', '2024-04-20 22:18:48', '2024-04-20 22:24:37'),
(85, 74, 'work on my project every day.', 'false', '2024-04-20 22:18:48', '2024-04-20 22:24:37');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `status` enum('active','nonactive') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `status`, `created_at`, `updated_at`) VALUES
(74, 'Choose the sentence that correctly uses the present continuous tense', 'active', '2024-04-07 21:16:53', '2024-04-20 22:24:36'),
(91, 'Which country is known as the \"Land of the Rising Sun\"?', 'active', '2024-04-08 12:28:49', '2024-04-08 12:28:49'),
(117, 'Which planet is known as the Red Planet?', 'active', '2024-04-08 12:26:53', '2024-04-08 12:26:53'),
(241, 'What is the largest mammal in the world?', 'active', '2024-04-08 12:28:04', '2024-04-08 12:28:04'),
(247, 'What is the currency of Japan?', 'active', '2024-04-08 12:29:56', '2024-04-08 12:29:56'),
(445, 'What is the largest ocean on Earth?', 'active', '2024-04-08 12:31:04', '2024-04-08 12:31:04'),
(661, 'Who wrote the play \"Romeo and Juliet\"?', 'active', '2024-04-08 12:27:30', '2024-04-08 12:27:30'),
(720, 'Who painted the Mona Lisa?', 'active', '2024-04-08 12:29:26', '2024-04-08 12:29:26'),
(737, 'Which of the following is a primary color?', 'active', '2024-04-08 12:30:31', '2024-04-08 12:30:31'),
(815, 'Who was the first President of the United States?', 'active', '2024-04-08 12:31:36', '2024-04-08 12:31:36'),
(921, 'Lisa: “Wow, you look stunning today!”\r\n\r\nRora: “Thank you! By the way, I love your new haircut.”\r\n\r\nIn this dialogue, Rora’s response is an example of _____', 'active', '2024-04-07 20:27:56', '2024-04-08 12:13:52'),
(959, 'What is the capital of France?', 'active', '2024-04-08 12:26:17', '2024-04-08 12:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` varchar(50) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `birthday`, `address`, `role`, `status`, `foto`, `created_at`, `updated_at`) VALUES
(6, 'Admin Get House', 'admin', 'admingethouse@gmail.com', '$2y$10$gyxzzNCEJXMghWxrzagOMe7d8jhT/GASWfL5mfWQZvIxTvqu1vXJ2', '2005-01-01', 'Kuningan', 'admin', 'active', '1713627648_ac5523fcc730c8b2e796.jpg', '2024-04-06 14:49:46', '2024-04-20 22:40:48'),
(8, 'Orang Satu', 'orangsatu', 'orangsatu@gmail.com', '$2y$10$oJ4V.IlYiA.c9TnWwSj92exQjQyJ.3qGNvsHf1o6GOTHz/jc5w0AG', '2024-02-01', 'Jakarta', 'user', 'active', '1713276851_f209bcc922f09412b5d2.png', '2024-04-16 14:54:21', '2024-04-16 21:14:11'),
(9, 'Orang Dua', 'orangdua', 'orangdua@gmail.com', '$2y$10$m1Jxo2WUQE9/y9ms7WRkS.NO6nu7NfkYGUiqUhwau.vwrsYP9BBPi', '2024-01-01', 'Bandung', 'user', 'active', NULL, '2024-04-16 14:54:58', '2024-04-16 14:54:58'),
(10, 'Orang Tiga', 'orangtiga', 'orangtiga@gmail.com', '$2y$10$bvAXB06OdC/7mD33390axO/Wlvlsx.o06p9on9MlqpMTKd/Wyjfja', '2017-01-01', 'Kuningan', 'user', 'active', '1713627622_da6b72f251d4d713a570.png', '2024-04-16 14:56:31', '2024-04-20 22:42:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_quizzes`
--

CREATE TABLE `user_quizzes` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `time_limit_minutes` int(11) DEFAULT 60,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_quizzes`
--

INSERT INTO `user_quizzes` (`id`, `user_id`, `level`, `start_time`, `end_time`, `time_limit_minutes`, `created_at`, `updated_at`) VALUES
(40, 8, '', '2024-04-26 10:39:19', '0000-00-00 00:00:00', 60, '2024-04-26 10:39:03', '2024-04-26 10:39:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answered_users`
--
ALTER TABLE `answered_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `multiple_choice`
--
ALTER TABLE `multiple_choice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_quizzes`
--
ALTER TABLE `user_quizzes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answered_users`
--
ALTER TABLE `answered_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `multiple_choice`
--
ALTER TABLE `multiple_choice`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=960;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_quizzes`
--
ALTER TABLE `user_quizzes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
