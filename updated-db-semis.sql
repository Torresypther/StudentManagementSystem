-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2025 at 02:30 PM
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
-- Database: `user_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_table`
--

CREATE TABLE `product_table` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_table`
--

INSERT INTO `product_table` (`product_id`, `product_name`) VALUES
(4, 'Atay'),
(6, 'Kidney'),
(8, 'Atay'),
(9, 'Atay'),
(10, 'Atay'),
(12, 'Atay'),
(13, 'Atay'),
(14, 'Atay'),
(15, 'Atay'),
(16, ''),
(17, 'trial'),
(18, 'sas'),
(19, ''),
(20, ''),
(21, ''),
(22, ''),
(23, ''),
(24, ''),
(25, ''),
(26, ''),
(27, ''),
(28, ''),
(29, ''),
(30, ''),
(31, ''),
(32, ''),
(33, ''),
(34, ''),
(35, ''),
(36, ''),
(37, ''),
(38, ''),
(39, ''),
(40, ''),
(41, ''),
(42, ''),
(43, ''),
(44, ''),
(45, ''),
(46, ''),
(47, '');

-- --------------------------------------------------------

--
-- Table structure for table `student_data`
--

CREATE TABLE `student_data` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `course` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `profile` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_data`
--

INSERT INTO `student_data` (`student_id`, `first_name`, `last_name`, `email`, `gender`, `course`, `address`, `birthdate`, `profile`, `date_created`) VALUES
(1, 'Sypther', 'Torres', 'admin@gmail.com', 'Male', 'BSCS', 'San Vicente St.', '2003-09-28', 'profiles/1741855077_CRMC LOGO.png', '2025-03-13 08:37:57'),
(2, 'Chloe', 'Malait', 'user@gmail.com', 'Female', 'BSIT', 'Giaran, Bogo', '2003-06-16', 'profiles/1741858919_CCS LOGO.png', '2025-03-13 09:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `task_name` varchar(75) NOT NULL,
  `task_desc` varchar(200) NOT NULL,
  `task_deadline` date NOT NULL,
  `task_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `task_name`, `task_desc`, `task_deadline`, `task_status`) VALUES
(1, 'IR Sensor Application', 'Create a hardware device that uses ir sensor.', '2025-05-03', 'pending'),
(2, 'Reflection Paper : Romeo and Juliet', 'Read and Create a reflection paper about remoe and juliet.', '2025-04-30', 'pending'),
(4, 'asa', 'sasa', '2025-05-02', 'pending'),
(5, 'trial', 'rqrgq', '2025-05-09', 'pending'),
(6, 'trial2', 'ghgh', '2025-05-23', 'pending'),
(7, 'trial', 'jds', '2025-05-24', 'pending'),
(8, 'trial 8 edit', 'thsi a trial8', '2025-05-20', 'pending'),
(9, 'trial', 'gsdh', '2025-05-16', 'pending'),
(10, 'edit trial7', 'cvcvcv', '2025-05-21', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `task_assignments`
--

CREATE TABLE `task_assignments` (
  `assignment_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `assigned_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_on` datetime DEFAULT NULL,
  `submission_type` varchar(10) NOT NULL,
  `submitted_file` varchar(200) NOT NULL,
  `submission_status` varchar(10) NOT NULL DEFAULT 'missing',
  `task_status` varchar(25) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_assignments`
--

INSERT INTO `task_assignments` (`assignment_id`, `task_id`, `student_id`, `assigned_at`, `completed_on`, `submission_type`, `submitted_file`, `submission_status`, `task_status`) VALUES
(6, 4, 15, '2025-04-29 14:06:07', '2025-05-01 18:45:20', '', 'std-submissions/1746096320_TORRES.Lab Environment Setup.pdf', '', 'completed'),
(10, 7, 15, '2025-05-01 10:37:21', '2025-05-01 18:45:54', '', 'www.gogol.com', '', 'completed'),
(12, 9, 9, '2025-05-06 03:01:02', NULL, '', '', '', 'pending'),
(13, 9, 15, '2025-05-06 03:01:02', '2025-05-06 11:03:05', '', 'std-submissions/1746500585_Related Materials.docx', '', 'completed'),
(22, 10, 15, '2025-05-08 14:30:41', NULL, '', '', '', 'pending'),
(23, 10, 9, '2025-05-08 14:30:41', NULL, '', '', '', 'pending'),
(24, 8, 15, '2025-05-08 14:31:21', '2025-05-08 22:44:42', 'file', 'std-submissions/1746715482_Related Materials.docx', 'submitted', 'approved'),
(25, 8, 9, '2025-05-08 14:31:21', NULL, '', '', '', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `course` varchar(100) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `birthdate` date NOT NULL,
  `user_profile` varchar(255) NOT NULL,
  `verification_code` int(11) NOT NULL,
  `is_verified` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `first_name`, `last_name`, `email`, `password`, `address`, `gender`, `course`, `phone_number`, `birthdate`, `user_profile`, `verification_code`, `is_verified`) VALUES
(9, 'Sypther ', 'Torres', 'torresypther@gmail.com', '$2y$10$WJLs53jXprblndykPEse5u8znJCj4OEaTABEfry9uz.M0rLlweRSK', 'San Vicente Street', 'Male', 'BSCS', '123456', '2003-09-28', 'ChatGPT Image Apr 24, 2025, 04_36_07 PM (1).jpg', 0, 1),
(15, 'Student', 'Here', 'studenthere@gmail.com', '$2y$10$xwAiBH6AklHYdy1g6kM4huIU6X/Uk1hLxLiPa5MY6m2XcqlZHJt1O', 'san purok', 'Male', 'BSIT', '8', '2025-04-01', 'CCS LOGO.png', 0, 1),
(17, 'Kaye', 'Malait', 'kayemalait@yahoo.com', '$2y$10$dSqySUnq9QA/f/lrDijkSO0kS5NY6Cb2EolEHLw5FXguJsMCCq.DO', 'Somewhere down the road', 'Female', 'BSIT', '12345', '2003-06-16', 'profiles/1746714786_water-logo-design-concept_761413-7077.avif', 0, 1),
(18, 'Danemhark', 'Lepiten', 'dane@gmail.com', '$2y$10$SM9LJZ89CFVWt/tcc1zE7.DCF0/seedCFJTBv2QjUXETDHhZp8HNi', 'San Vicente Street', 'Male', 'BSA', '123', '2003-11-19', 'profiles/1746714861_pexels-njeromin-15352968.jpg', 0, 1),
(19, 'Alexis', 'Sevilleno', 'alexis@example.com', '$2y$10$WqMZiIAwoFmHf2JJ8BgCNuhsEVZSr/N64FAQr2ode4gxzoxQIYXbC', 'San Vicente Street', 'Male', 'BSIT', '123456', '2004-04-08', 'profiles/1746714931_Untitled design.jpg', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_table`
--
ALTER TABLE `product_table`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `student_data`
--
ALTER TABLE `student_data`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`);

--
-- Indexes for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD KEY `task_id` (`task_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_table`
--
ALTER TABLE `product_table`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `student_data`
--
ALTER TABLE `student_data`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `task_assignments`
--
ALTER TABLE `task_assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_assignments`
--
ALTER TABLE `task_assignments`
  ADD CONSTRAINT `task_assignments_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`task_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `task_assignments_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `user_table` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
