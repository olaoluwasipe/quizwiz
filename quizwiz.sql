-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 04:27 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizwiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `questionbank`
--

CREATE TABLE `questionbank` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `dateCreated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questionbank`
--

INSERT INTO `questionbank` (`id`, `user_id`, `name`, `description`, `dateCreated`) VALUES
(10, 5, 'This is a test', 'This is great', '1681485231'),
(11, 5, 'Mathematics', 'This is the new mathematics', '1681489522');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quizCode` varchar(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `duration` int(20) NOT NULL,
  `noOfQuestions` int(20) NOT NULL,
  `scorePerQuestions` int(20) NOT NULL,
  `dateScheduled` varchar(30) NOT NULL,
  `dateEnd` varchar(30) NOT NULL,
  `questionBank` int(11) NOT NULL,
  `isRandom` varchar(5) NOT NULL,
  `showAnswers` varchar(5) NOT NULL,
  `dateCreated` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `user_id`, `quizCode`, `title`, `description`, `duration`, `noOfQuestions`, `scorePerQuestions`, `dateScheduled`, `dateEnd`, `questionBank`, `isRandom`, `showAnswers`, `dateCreated`) VALUES
(1, 5, 'a98340cc125', 'This is a new quiz', 'This is a test quiz, this is a test update', 10, 10, 5, '2023-04-15T13:26', '2023-04-29T13:26', 11, 'yes', 'yes', '1681561652'),
(2, 5, 'c22e5126ba3', 'Mathematics', 'This is a mathematics quiz', 9, 5, 10, '2023-04-16T17:31', '2023-05-06T17:31', 11, 'yes', 'yes', '1681662693'),
(3, 5, 'c7cbdbca281', 'This is a test quiz', 'This is just to test if the form works on all pages', 10, 8, 6, '2023-04-14T23:54', '2023-04-17T00:30', 11, 'yes', 'yes', '1681685693');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_enrolls`
--

CREATE TABLE `quiz_enrolls` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dateEnrolled` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_enrolls`
--

INSERT INTO `quiz_enrolls` (`id`, `quiz_id`, `user_id`, `dateEnrolled`) VALUES
(1, 1, 1, '1681616818'),
(2, 2, 1, '1681663364'),
(3, 1, 6, '1681668399'),
(4, 2, 6, '1681670162'),
(5, 3, 6, '1681686131');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `options` text NOT NULL,
  `answer` varchar(255) NOT NULL,
  `dateCreated` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `user_id`, `bank_id`, `question`, `options`, `answer`, `dateCreated`) VALUES
(8, 5, 11, 'how many angles are there in a square?', 'a:5:{i:0;s:3:\"120\";i:1;s:3:\"180\";i:2;s:3:\"270\";i:3;s:3:\"360\";i:4;s:3:\"720\";}', '180', '1681489561'),
(9, 5, 11, 'What is 2 + 2', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:2:\"22\";i:4;s:1:\"5\";}', '4', '1681489658'),
(13, 5, 11, '60 Times of 8 Equals to', 'a:4:{i:0;s:3:\"400\";i:1;s:3:\"250\";i:2;s:3:\"480\";i:3;s:3:\"300\";}', '480', '1681559641'),
(14, 5, 11, 'how many angles are there in a square?', 'a:5:{i:0;s:3:\"120\";i:1;s:3:\"180\";i:2;s:3:\"270\";i:3;s:3:\"360\";i:4;s:3:\"720\";}', '180', '1681489561'),
(15, 5, 11, 'What is 2 + 2', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:2:\"22\";i:4;s:1:\"5\";}', '4', '1681489658'),
(16, 5, 11, '60 Times of 8 Equals to', 'a:4:{i:0;s:3:\"400\";i:1;s:3:\"250\";i:2;s:3:\"480\";i:3;s:3:\"300\";}', '480', '1681559641'),
(17, 5, 11, 'how many angles are there in a square?', 'a:5:{i:0;s:3:\"120\";i:1;s:3:\"180\";i:2;s:3:\"270\";i:3;s:3:\"360\";i:4;s:3:\"720\";}', '180', '1681489561'),
(18, 5, 11, 'What is 2 + 2', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:2:\"22\";i:4;s:1:\"5\";}', '4', '1681489658'),
(19, 5, 11, '60 Times of 8 Equals to', 'a:4:{i:0;s:3:\"400\";i:1;s:3:\"250\";i:2;s:3:\"480\";i:3;s:3:\"300\";}', '480', '1681559641'),
(20, 5, 11, 'how many angles are there in a square?', 'a:5:{i:0;s:3:\"120\";i:1;s:3:\"180\";i:2;s:3:\"270\";i:3;s:3:\"360\";i:4;s:3:\"720\";}', '180', '1681489561'),
(21, 5, 11, 'What is 2 + 2', 'a:5:{i:0;s:1:\"2\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:2:\"22\";i:4;s:1:\"5\";}', '4', '1681489658'),
(22, 5, 11, '60 Times of 8 Equals to', 'a:4:{i:0;s:3:\"400\";i:1;s:3:\"250\";i:2;s:3:\"480\";i:3;s:3:\"300\";}', '480', '1681559641');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `percentage` int(11) NOT NULL,
  `result` text NOT NULL,
  `timeFinished` varchar(11) NOT NULL,
  `dateTaken` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quiz_results`
--

INSERT INTO `quiz_results` (`id`, `quiz_id`, `user_id`, `score`, `percentage`, `result`, `timeFinished`, `dateTaken`) VALUES
(1, 1, 1, 10, 0, '', '', ''),
(2, 1, 1, 10, 0, '', '', ''),
(3, 1, 1, 10, 0, '', '', ''),
(4, 1, 1, 10, 0, '', '', ''),
(5, 1, 1, 0, 0, '', '', ''),
(6, 1, 1, 20, 0, '', '', ''),
(7, 1, 1, 20, 0, '', '', ''),
(8, 1, 1, 30, 0, '', '', ''),
(9, 1, 1, 30, 0, '', '', ''),
(10, 1, 1, 100, 0, '', '', ''),
(11, 1, 1, 91, 0, 'a:11:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"4\";i:13;s:3:\"480\";i:15;s:1:\"4\";s:12:\"timeFinished\";s:4:\"3:44\";}', '3:44', '1681590969'),
(12, 1, 1, 91, 0, 'a:11:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"4\";i:13;s:3:\"480\";i:15;s:1:\"4\";s:12:\"timeFinished\";s:4:\"2:54\";}', '2:54', '1681591018'),
(13, 1, 1, 91, 0, 'a:11:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"4\";i:13;s:3:\"480\";i:15;s:1:\"4\";s:12:\"timeFinished\";s:4:\"2:38\";}', '2:38', '1681591038'),
(14, 1, 1, 91, 0, 'a:11:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"4\";i:13;s:3:\"480\";i:15;s:1:\"4\";s:12:\"timeFinished\";s:4:\"2:05\";}', '2:05', '1681591071'),
(15, 1, 1, 82, 0, 'a:11:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";s:12:\"timeFinished\";s:4:\"1:28\";}', '1:28', '1681591110'),
(16, 1, 1, 82, 0, 'a:11:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";s:12:\"timeFinished\";s:4:\"0:05\";}', '0:05', '1681591193'),
(17, 1, 1, 90, 0, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '9:44', '1681591235'),
(18, 1, 1, 90, 0, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '8:09', '1681591332'),
(19, 1, 1, 1, 90, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '8:00', '1681591615'),
(20, 1, 1, 9, 90, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '7:57', '1681591685'),
(21, 1, 1, 9, 90, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '7:54', '1681591746'),
(22, 1, 1, 9, 90, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"480\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:2:\"22\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '0:00', '1681592139'),
(23, 1, 1, 7, 70, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"400\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"2\";i:13;s:3:\"250\";i:15;s:1:\"4\";}', '9:01', '1681592228'),
(24, 1, 1, 45, 90, 'a:10:{i:21;s:1:\"4\";i:20;s:3:\"180\";i:17;s:3:\"180\";i:16;s:3:\"480\";i:19;s:3:\"250\";i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"4\";i:13;s:3:\"480\";i:15;s:1:\"4\";}', '8:41', '1681592429'),
(25, 2, 1, 50, 100, 'a:5:{i:14;s:3:\"180\";i:9;s:1:\"4\";i:15;s:1:\"4\";i:22;s:3:\"480\";i:8;s:3:\"180\";}', '8:37', '1681664275'),
(26, 1, 6, 50, 100, 'a:10:{i:20;s:3:\"180\";i:22;s:3:\"480\";i:14;s:3:\"180\";i:13;s:3:\"480\";i:9;s:1:\"4\";i:15;s:1:\"4\";i:21;s:1:\"4\";i:18;s:1:\"4\";i:16;s:3:\"480\";i:19;s:3:\"480\";}', '9:39', '1681668429'),
(27, 2, 6, 40, 80, 'a:5:{i:20;s:3:\"180\";i:22;s:3:\"480\";i:14;s:3:\"180\";i:13;s:3:\"250\";i:9;s:1:\"4\";}', '9:25', '1681670188'),
(29, 3, 6, 48, 100, 'a:8:{i:8;s:3:\"180\";i:9;s:1:\"4\";i:18;s:1:\"4\";i:19;s:3:\"480\";i:17;s:3:\"180\";i:20;s:3:\"180\";i:14;s:3:\"180\";i:13;s:3:\"480\";}', '9:44', '1681687171');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `userToken` varchar(20) NOT NULL,
  `image` text DEFAULT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(1) NOT NULL,
  `dateCreated` varchar(255) NOT NULL,
  `authCode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userToken`, `image`, `firstName`, `lastName`, `phone`, `email`, `password`, `type`, `dateCreated`, `authCode`) VALUES
(1, 'user_64377539c03ce', '643c2c15cf9326.17504774.jpeg', 'Olaoluwa', 'Sipe', '09038974506', 'olaoluwa@gmail.com', '$2y$10$WPcX1YV8xyHOMJyFCneyTuJXhceWvTrEQlA2gNuu/3E/J6HU0//5q', 0, '2023-04-13', '64377539c03d7'),
(3, 'user_64381eee267fe', '', 'Olaoluwa', 'Sipe', '', 'olaoluwa933@gmail.com', '$2y$10$k4xpz5ep5eKlwSDq8vRRiuX2MkjUFCg00.vTzHWP8jD5N8gBvu7R6', 1, '2023-04-13', ''),
(4, 'user_643849e28b60d', '', 'Gabriel', 'Micharl', '', 'gabrielofficial@gmail.com', '$2y$10$y4s.SfLxDlD0bup8qDs81OzxdUcXJfWJe0lVY8QxADW4.AMVmE2AO', 1, '2023-04-13', ''),
(5, 'user_64384c0641037', '643bab4721bd18.70002262.jpeg', 'Gabriel G.', 'Sipe', '09038974506', 'gabyyy@gmail.com', '$2y$10$4Ui030KutjemwHJIXpPHOuk.ViowA3CK.E9DWTjHPVteVKxTTNrM6', 1, '2023-04-13', ''),
(6, 'user_643c37fb363dd', NULL, 'Nwabuikwu', 'Chizuruoke', '', 'nwachi@gmail.com', '$2y$10$/r3o/.c2NMFs2YW1lX1ONOyVPoMmiTwqgR3WkDfb3WBgwHxEptPwq', 0, '2023-04-16', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questionbank`
--
ALTER TABLE `questionbank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_enrolls`
--
ALTER TABLE `quiz_enrolls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
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
-- AUTO_INCREMENT for table `questionbank`
--
ALTER TABLE `questionbank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_enrolls`
--
ALTER TABLE `quiz_enrolls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
