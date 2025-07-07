-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2025 at 09:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyassess`
--
CREATE DATABASE IF NOT EXISTS `easyassess` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `easyassess`;

-- --------------------------------------------------------

--
-- Table structure for table `clearance_requirements`
--

CREATE TABLE `clearance_requirements` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `department_id` varchar(100) DEFAULT NULL,
  `attachment` varchar(1000) NOT NULL DEFAULT 'No Requirements',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clearance_requirements`
--

INSERT INTO `clearance_requirements` (`id`, `student_id`, `department_id`, `attachment`, `description`) VALUES
(18, '2301000555', 'LIB2025', 'No Attachment', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clearance_status`
--

CREATE TABLE `clearance_status` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `department_id` varchar(255) DEFAULT NULL,
  `status` enum('pending','needs_submission','approved') DEFAULT 'needs_submission',
  `remarks` text DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clearance_status`
--

INSERT INTO `clearance_status` (`id`, `student_id`, `department_id`, `status`, `remarks`, `updated_at`) VALUES
(7, '2301000555', 'LIB2025', 'pending', NULL, '2025-06-26 14:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`) VALUES
('ACC2025', 'Accounting'),
('DEAN2025', 'Dean'),
('OSA-F2025', 'Foundation'),
('LIB2025', 'Library'),
('OSA2025', 'Office Of Student Affairs'),
('OSA-PDO2025', 'Prefect of Discipline'),
('OSA-PT2025', 'Psychology Test'),
('REG2025', 'Registrar');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `semester` varchar(20) DEFAULT NULL,
  `school_year` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `evaluations`
--

CREATE TABLE `evaluations` (
  `id` int(11) NOT NULL,
  `enrollment_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `title` varchar(50) NOT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, '2301000555', 'Account Activated', 'You\'re account has been activated', 1, '2025-06-21 16:32:34'),
(3, '2301000555', 'Book Return', 'Please return Science Book', 1, '2025-06-21 17:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`user_id`, `employee_id`, `first_name`, `middle_name`, `last_name`, `department`, `position`) VALUES
(0, '2301000512', 'John Gregg', 'Virina', 'Felicisimo', 'LIB2025', 'Employee');

-- --------------------------------------------------------

--
-- Table structure for table `program_department`
--

CREATE TABLE `program_department` (
  `id` varchar(20) NOT NULL,
  `department_name` int(11) NOT NULL,
  `dean_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `course` varchar(100) DEFAULT NULL,
  `year_level` int(11) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `prog_department_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `student_id`, `first_name`, `middle_name`, `last_name`, `course`, `year_level`, `section`, `prog_department_id`) VALUES
(2025068662, '2301000555', 'Mark Jovan', 'A', 'Cananca', 'BSIT', 2, 'A', 'SBAT');

-- --------------------------------------------------------

--
-- Table structure for table `student_submissions`
--

CREATE TABLE `student_submissions` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `requirement_id` int(11) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `units` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `user_type` enum('student','professor','admin') NOT NULL DEFAULT 'student',
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(1000) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(45) DEFAULT 'Pending',
  `verification_code` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_type`, `email`, `password`, `profile_image`, `created_at`, `status`, `verification_code`) VALUES
('2301000512', 'professor', 'felicisimojv@gmail.com', '$2y$12$zunEZhdP5T5iS2T2MZEoh.HqBTs0EwFivAsHNqs19CFxAA4E3Q9XK', 'assets/Users/2301-000512/6857f1a84a16c.png', '2025-06-22 12:06:00', 'Active', NULL),
('2301000555', 'student', 'markjovan@gmail.com', '$2y$12$tlzuy9ziuXJbxZOiJJjLeuTd0bm6RHQDo8bQ/u2nUEmDXQhPu1WZG', 'assets/Users/2301-000555/6852e74e1a525.png', '2025-06-18 16:20:30', 'Active', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clearance_requirements`
--
ALTER TABLE `clearance_requirements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `fk_clearance_req_student_id` (`student_id`);

--
-- Indexes for table `clearance_status`
--
ALTER TABLE `clearance_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollment_id` (`enrollment_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD KEY `fk_department_id` (`department`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `student_submissions`
--
ALTER TABLE `student_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `requirement_id` (`requirement_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

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
-- AUTO_INCREMENT for table `clearance_requirements`
--
ALTER TABLE `clearance_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `clearance_status`
--
ALTER TABLE `clearance_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_submissions`
--
ALTER TABLE `student_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clearance_requirements`
--
ALTER TABLE `clearance_requirements`
  ADD CONSTRAINT `fk_clearance_req_dep_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_clearance_req_student_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clearance_status`
--
ALTER TABLE `clearance_status`
  ADD CONSTRAINT `fk_clearance_status_dep_id` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_clearance_student_id` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `evaluations_ibfk_1` FOREIGN KEY (`enrollment_id`) REFERENCES `enrollments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `professors`
--
ALTER TABLE `professors`
  ADD CONSTRAINT `fk_department_id` FOREIGN KEY (`department`) REFERENCES `departments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_professor_user_id` FOREIGN KEY (`employee_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_course_id` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student_submissions`
--
ALTER TABLE `student_submissions`
  ADD CONSTRAINT `student_submissions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`user_id`),
  ADD CONSTRAINT `student_submissions_ibfk_2` FOREIGN KEY (`requirement_id`) REFERENCES `clearance_requirements` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
