-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 07, 2024 at 01:25 PM
-- Server version: 10.6.16-MariaDB-cll-lve
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1609520_gethouseofenglish`
--

-- --------------------------------------------------------

--
-- Table structure for table `answered_users`
--

CREATE TABLE `answered_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_question` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `id_answered` varchar(11) DEFAULT NULL,
  `id_multiple_choice` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `answered_users`
--

INSERT INTO `answered_users` (`id`, `id_user`, `id_question`, `id_periode`, `id_answered`, `id_multiple_choice`, `created_at`, `updated_at`) VALUES
(408, 10, 970, 10, '202', '203,204,201,202', '2024-05-04 12:57:10', '2024-05-04 12:57:19'),
(409, 10, 967, 10, '191', '192,193,190,191', '2024-05-04 12:57:10', '2024-05-04 12:58:00'),
(410, 10, 966, 10, '188', '188,189,186,187', '2024-05-04 12:57:10', '2024-05-04 12:58:04'),
(411, 10, 962, 10, '171', '172,173,170,171', '2024-05-04 12:57:10', '2024-05-04 12:58:10'),
(412, 10, 963, 10, NULL, '176,177,174,175', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(413, 10, 969, 10, NULL, '199,200,197,198', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(414, 10, 960, 10, NULL, '164,163,165', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(415, 10, 964, 10, NULL, '180,181,178,179', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(416, 10, 968, 10, NULL, '195,194,196', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(417, 10, 961, 10, NULL, '168,169,166,167', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(418, 10, 965, 10, NULL, '184,185,182,183', '2024-05-04 12:57:10', '2024-05-04 12:57:10'),
(419, 10, 955, 12, '205', '206,205', '2024-05-04 13:00:09', '2024-05-04 13:00:12');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `multiple_choice`
--

INSERT INTO `multiple_choice` (`id`, `id_question`, `choice_text`, `is_correct`, `created_at`, `updated_at`) VALUES
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
(46, 91, 'South Korea', 'false', '2024-04-08 12:28:49', '2024-05-03 19:46:35'),
(47, 91, 'India', 'false', '2024-04-08 12:28:49', '2024-05-03 19:46:35'),
(48, 91, 'Japan', 'true', '2024-04-08 12:28:49', '2024-05-03 19:46:35'),
(49, 91, 'China', 'false', '2024-04-08 12:28:49', '2024-05-03 19:46:35'),
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
(83, 74, 'She is cooking dinner right now.', 'false', '2024-04-20 22:18:48', '2024-05-04 12:54:24'),
(84, 74, 'They will go to the beach tomorrow.', 'true', '2024-04-20 22:18:48', '2024-05-04 12:54:24'),
(85, 74, 'work on my project every day.', 'false', '2024-04-20 22:18:48', '2024-05-04 12:54:24'),
(103, 148, 'test', 'false', '2024-05-04 01:06:09', '2024-05-04 01:06:09'),
(104, 148, 'etrw432', 'false', '2024-05-04 01:06:09', '2024-05-04 01:06:09'),
(105, 148, '2432', 'true', '2024-05-04 01:06:09', '2024-05-04 01:06:09'),
(106, 148, '243242r', 'false', '2024-05-04 01:06:09', '2024-05-04 01:06:09'),
(107, 94, 'afdaf', 'true', '2024-05-04 01:06:17', '2024-05-04 01:06:17'),
(108, 94, 'afdsfs', 'false', '2024-05-04 01:06:17', '2024-05-04 01:06:17'),
(163, 960, 'She is cooking dinner right now.', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(164, 960, 'They will go to the beach tomorrow.', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(165, 960, 'work on my project every day.', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(166, 961, 'South Korea', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(167, 961, 'India', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(168, 961, 'Japan', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(169, 961, 'China', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(170, 962, 'Earth', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(171, 962, 'Mars', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(172, 962, 'Jupiter', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(173, 962, 'Saturn', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(174, 963, 'Hippopotamus', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(175, 963, 'Giraffe', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(176, 963, 'Blue whale', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(177, 963, 'Elephant', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(178, 964, 'Dollar', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(179, 964, 'Euro', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(180, 964, 'Yuan', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(181, 964, 'Yen', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(182, 965, 'Pacific Ocean', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(183, 965, 'Arctic Ocean', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(184, 965, 'Atlantic Ocean', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(185, 965, 'Indian Ocean', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(186, 966, 'William Shakespeare', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(187, 966, 'Jane Austen', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(188, 966, 'Charles Dickens', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(189, 966, 'Mark Twain', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(190, 967, 'Michelangelo', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(191, 967, 'Leonardo da Vinci', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(192, 967, 'Pablo Picasso', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(193, 967, 'Vincent van Gogh', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(194, 968, 'Blue', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(195, 968, 'Green', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(196, 968, 'Pink', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(197, 969, 'John Adams', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(198, 969, 'Thomas Jefferson', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(199, 969, 'George Washington', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(200, 969, 'Abraham Lincoln', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(201, 970, ' London', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(202, 970, 'Paris', 'true', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(203, 970, 'Rome', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(204, 970, 'Berlin', 'false', '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(205, 955, 'iya boleh', 'true', '2024-05-04 12:59:55', '2024-05-04 12:59:55'),
(206, 955, 'tidak', 'false', '2024-05-04 12:59:55', '2024-05-04 12:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id` int(11) NOT NULL,
  `periode` varchar(50) NOT NULL,
  `status` enum('active','nonactive') NOT NULL DEFAULT 'nonactive',
  `quiz_timer` int(5) DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id`, `periode`, `status`, `quiz_timer`, `created_at`, `updated_at`) VALUES
(1, 'Tahun 2021/2022', 'active', 60, '2024-05-03 08:53:41', '2024-05-07 13:22:05'),
(10, 'Tahun 2024', 'active', 30, '2024-05-04 10:13:36', '2024-05-07 13:20:57'),
(12, 'Tahun 2024/2025', 'active', 75, '2024-05-04 12:34:32', '2024-05-07 12:06:04');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) UNSIGNED NOT NULL,
  `question` text NOT NULL,
  `status` enum('active','nonactive') NOT NULL DEFAULT 'active',
  `id_periode` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `status`, `id_periode`, `created_at`, `updated_at`) VALUES
(74, 'Choose the sentence that correctly uses the present continuous tense', 'active', 1, '2024-04-07 21:16:53', '2024-05-04 12:54:24'),
(91, 'Which country is known as the \"Land of the Rising Sun\"?', 'active', 1, '2024-04-08 12:28:49', '2024-05-03 19:46:35'),
(117, 'Which planet is known as the Red Planet?', 'active', 1, '2024-04-08 12:26:53', '2024-05-03 13:52:27'),
(241, 'What is the largest mammal in the world?', 'active', 1, '2024-04-08 12:28:04', '2024-05-03 13:52:27'),
(247, 'What is the currency of Japan?', 'active', 1, '2024-04-08 12:29:56', '2024-05-03 13:52:27'),
(445, 'What is the largest ocean on Earth?', 'active', 1, '2024-04-08 12:31:04', '2024-05-03 13:52:27'),
(661, 'Who wrote the play \"Romeo and Juliet\"?', 'active', 1, '2024-04-08 12:27:30', '2024-05-03 13:52:27'),
(720, 'Who painted the Mona Lisa?', 'active', 1, '2024-04-08 12:29:26', '2024-05-03 13:52:27'),
(737, 'Which of the following is a primary color?', 'active', 1, '2024-04-08 12:30:31', '2024-05-03 13:52:27'),
(815, 'Who was the first President of the United States?', 'active', 1, '2024-04-08 12:31:36', '2024-05-03 13:52:27'),
(955, 'coba test ya', 'active', 12, '2024-05-04 12:59:55', '2024-05-04 12:59:55'),
(959, 'What is the capital of France?', 'active', 1, '2024-04-08 12:26:17', '2024-05-03 13:52:27'),
(960, 'Choose the sentence that correctly uses the present continuous tense', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(961, 'Which country is known as the \"Land of the Rising Sun\"?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(962, 'Which planet is known as the Red Planet?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(963, 'What is the largest mammal in the world?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(964, 'What is the currency of Japan?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(965, 'What is the largest ocean on Earth?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(966, 'Who wrote the play \"Romeo and Juliet\"?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(967, 'Who painted the Mona Lisa?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(968, 'Which of the following is a primary color?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(969, 'Who was the first President of the United States?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46'),
(970, 'What is the capital of France?', 'active', 10, '2024-05-04 10:13:46', '2024-05-04 10:13:46');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

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
  `id_periode` int(11) NOT NULL,
  `level` varchar(50) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `time_limit_minutes` int(11) DEFAULT 60,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `user_quizzes`
--

INSERT INTO `user_quizzes` (`id`, `user_id`, `id_periode`, `level`, `start_time`, `end_time`, `time_limit_minutes`, `created_at`, `updated_at`) VALUES
(73, 10, 10, 'HICE 3', '2024-05-04 12:57:10', '2024-05-04 13:57:10', 60, '2024-05-04 12:56:21', '2024-05-06 12:15:55'),
(74, 10, 12, '', '2024-05-04 13:00:09', '2024-05-04 14:00:09', 60, '2024-05-04 12:59:05', '2024-05-06 12:15:55');

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
-- Indexes for table `periode`
--
ALTER TABLE `periode`
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
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `multiple_choice`
--
ALTER TABLE `multiple_choice`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=971;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_quizzes`
--
ALTER TABLE `user_quizzes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
