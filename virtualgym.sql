-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2017 at 05:16 PM
-- Server version: 5.7.17-0ubuntu0.16.04.1
-- PHP Version: 7.0.15-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtualgym`
--

-- --------------------------------------------------------

--
-- Table structure for table `vgym_exercises`
--

CREATE TABLE `vgym_exercises` (
  `ID` bigint(20) NOT NULL,
  `exercise_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vgym_exercises`
--

INSERT INTO `vgym_exercises` (`ID`, `exercise_name`) VALUES
(1, 'Push Ups'),
(2, 'Pull Ups'),
(3, 'Squats'),
(4, 'Lunges'),
(6, 'Lat Pull');

-- --------------------------------------------------------

--
-- Table structure for table `vgym_plans`
--

CREATE TABLE `vgym_plans` (
  `ID` bigint(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vgym_plans`
--

INSERT INTO `vgym_plans` (`ID`, `plan_name`) VALUES
(1, 'Cardio Plan 5'),
(2, 'Full Body Workout'),
(8, '4 Day Workout');

-- --------------------------------------------------------

--
-- Table structure for table `vgym_plan_days`
--

CREATE TABLE `vgym_plan_days` (
  `plan_day_id` bigint(20) NOT NULL,
  `plan_day_name` varchar(50) NOT NULL,
  `plan_id` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vgym_plan_days`
--

INSERT INTO `vgym_plan_days` (`plan_day_id`, `plan_day_name`, `plan_id`) VALUES
(43, 'Day 1', 1),
(44, 'Day 2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vgym_plan_day_exercises`
--

CREATE TABLE `vgym_plan_day_exercises` (
  `day_exercise_id` bigint(20) NOT NULL,
  `plan_day_id` bigint(20) NOT NULL,
  `exercise_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vgym_plan_day_exercises`
--

INSERT INTO `vgym_plan_day_exercises` (`day_exercise_id`, `plan_day_id`, `exercise_id`) VALUES
(2, 43, 1),
(3, 44, 1),
(4, 43, 2);

-- --------------------------------------------------------

--
-- Table structure for table `vgym_users`
--

CREATE TABLE `vgym_users` (
  `ID` bigint(20) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vgym_users`
--

INSERT INTO `vgym_users` (`ID`, `user_firstname`, `user_lastname`, `user_email`) VALUES
(7, 'Bevin', 'Pavithran', 'bevin@gmail.com'),
(11, 'Mathew', 'Hayden', 'hay@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `vgym_user_plan`
--

CREATE TABLE `vgym_user_plan` (
  `user_plan_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `plan_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vgym_user_plan`
--

INSERT INTO `vgym_user_plan` (`user_plan_id`, `user_id`, `plan_id`) VALUES
(7, 7, 2),
(19, 11, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vgym_exercises`
--
ALTER TABLE `vgym_exercises`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vgym_plans`
--
ALTER TABLE `vgym_plans`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vgym_plan_days`
--
ALTER TABLE `vgym_plan_days`
  ADD PRIMARY KEY (`plan_day_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `vgym_plan_day_exercises`
--
ALTER TABLE `vgym_plan_day_exercises`
  ADD PRIMARY KEY (`day_exercise_id`),
  ADD KEY `excercise_id` (`exercise_id`),
  ADD KEY `plan_day_id` (`plan_day_id`);

--
-- Indexes for table `vgym_users`
--
ALTER TABLE `vgym_users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `vgym_user_plan`
--
ALTER TABLE `vgym_user_plan`
  ADD PRIMARY KEY (`user_plan_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vgym_exercises`
--
ALTER TABLE `vgym_exercises`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `vgym_plans`
--
ALTER TABLE `vgym_plans`
  MODIFY `ID` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `vgym_plan_days`
--
ALTER TABLE `vgym_plan_days`
  MODIFY `plan_day_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `vgym_plan_day_exercises`
--
ALTER TABLE `vgym_plan_day_exercises`
  MODIFY `day_exercise_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `vgym_users`
--
ALTER TABLE `vgym_users`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `vgym_user_plan`
--
ALTER TABLE `vgym_user_plan`
  MODIFY `user_plan_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `vgym_plan_days`
--
ALTER TABLE `vgym_plan_days`
  ADD CONSTRAINT `vgym_plan_days_ibfk_1` FOREIGN KEY (`plan_id`) REFERENCES `vgym_plans` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vgym_plan_day_exercises`
--
ALTER TABLE `vgym_plan_day_exercises`
  ADD CONSTRAINT `vgym_plan_day_exercises_ibfk_1` FOREIGN KEY (`plan_day_id`) REFERENCES `vgym_plan_days` (`plan_day_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vgym_plan_day_exercises_ibfk_2` FOREIGN KEY (`exercise_id`) REFERENCES `vgym_exercises` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vgym_user_plan`
--
ALTER TABLE `vgym_user_plan`
  ADD CONSTRAINT `vgym_user_plan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `vgym_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vgym_user_plan_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `vgym_plans` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
