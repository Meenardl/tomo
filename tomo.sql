-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2024 at 01:33 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tomo`
--

-- --------------------------------------------------------

--
-- Table structure for table `journal`
--

CREATE TABLE `journal` (
  `journal_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `answer_one` text NOT NULL,
  `answer_two` text NOT NULL,
  `answer_three` text NOT NULL,
  `answer_four` text NOT NULL,
  `answer_five` text NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `journal`
--

INSERT INTO `journal` (`journal_id`, `month`, `day`, `answer_one`, `answer_two`, `answer_three`, `answer_four`, `answer_five`, `user_id`) VALUES
(35, 2, 1, 'a', 'b', 'c', 'd', 'e', 21),
(36, 2, 3, 'a', 'b', 'c', 'd', 'e', 21),
(37, 2, 5, 'a', 'b', 'c', 'd', 'e', 21),
(38, 2, 7, 'a', 'b', 'c', 'd', 'e', 21),
(39, 2, 9, 'a', 'b', 'c', 'd', 'e', 21),
(40, 2, 11, 'a', 'b', 'c', 'd', 'e', 21),
(41, 2, 13, 'a', 'b', 'c', 'e', 'd', 21),
(42, 2, 15, 'a', 'b', 'd', 'e', 's', 21),
(43, 2, 17, 'a', 's', 'd', 'a', 's', 21),
(44, 2, 23, 'a', 's', 'd', 'd', 's', 21),
(45, 2, 21, 'a', 's', 'd', 'e', 'g', 21),
(46, 2, 19, 'a', 's', 'e', 'r', 'f', 21),
(47, 2, 25, 'a', 's', 'f', 'g', 'r', 21),
(48, 2, 27, 'a', 's', 'd', 'r', 'g', 21),
(49, 2, 20, 'a', 's', 'd', 's', 'e', 21),
(50, 2, 10, 'a', 's', 'd', 'e', 'g', 21),
(51, 2, 22, 'e', 's', 'a', 's', 'f', 21),
(52, 2, 12, 'r', 'g', 'd', 's', 'a', 21),
(53, 2, 8, 's', 'd', 'w', 'e', 'r', 21),
(54, 2, 24, 's', 'd', 'w', 'e', 't', 21),
(55, 4, 30, 'good', 'no', 'no', 'thanks', 'okay', 22),
(56, 2, 9, 'good', 'no', 'no', 'thanks', 'okay', 22);

-- --------------------------------------------------------

--
-- Table structure for table `mood_tracker`
--

CREATE TABLE `mood_tracker` (
  `mood_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `mood` varchar(25) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_tracker`
--

INSERT INTO `mood_tracker` (`mood_id`, `month`, `mood`, `user_id`) VALUES
(32, 2, 'tired', 21),
(33, 2, 'tired', 21),
(34, 2, 'tired', 21),
(35, 2, 'tired', 21),
(36, 2, 'tired', 21),
(37, 2, 'tired', 21),
(38, 2, 'tired', 21),
(39, 2, 'tired', 21),
(40, 2, 'tired', 21),
(41, 2, 'tired', 21),
(42, 2, 'tired', 21),
(43, 2, 'tired', 21),
(44, 2, 'tired', 21),
(45, 2, 'tired', 21),
(46, 2, 'sad', 21),
(47, 2, 'sad', 21),
(48, 2, 'happy', 21),
(49, 2, 'sad', 21),
(50, 2, 'happy', 21),
(51, 2, 'angry', 21),
(52, 4, 'tired', 22),
(53, 2, 'tired', 22);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `email`) VALUES
(21, 'admin', 'tomo', 'tomo@gmail.com'),
(22, 'tes', 'tes', 'tes@gmail.com'),
(23, 'tes', 'set', 'tes@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `journal`
--
ALTER TABLE `journal`
  ADD PRIMARY KEY (`journal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mood_tracker`
--
ALTER TABLE `mood_tracker`
  ADD PRIMARY KEY (`mood_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `journal`
--
ALTER TABLE `journal`
  MODIFY `journal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `mood_tracker`
--
ALTER TABLE `mood_tracker`
  MODIFY `mood_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journal`
--
ALTER TABLE `journal`
  ADD CONSTRAINT `journal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `mood_tracker`
--
ALTER TABLE `mood_tracker`
  ADD CONSTRAINT `mood_tracker_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
