-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2025 at 07:51 PM
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
-- Database: `secure_examination`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password`) VALUES
('admin1111', 'ADMIN', 'admin@gmail.com', 'admin1111');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_code` varchar(20) NOT NULL,
  `exam_name` varchar(100) NOT NULL,
  `exam_date` date NOT NULL,
  `exam_time` time NOT NULL,
  `duration` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_code`, `exam_name`, `exam_date`, `exam_time`, `duration`) VALUES
('MPU3333', 'PENGAJIAN ISLAM 3', '2025-05-08', '10:00:00', '60'),
('NWC2314', 'COMPUTER SCIENCE', '2025-04-24', '18:00:00', '60'),
('TST12', 'TEST EXAM', '2025-05-07', '08:00:00', '35');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `lecturer_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ic_number` varchar(20) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `room_number` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lecturer_id`, `name`, `email`, `password`, `ic_number`, `phone_number`, `dob`, `room_number`) VALUES
('KL3455', 'nur nazihah', 'kl2304013455@student.uptm.edu.my', '$2y$10$IL504lo2EQY.cstP.wG64u75a/jU/dO.xDqqPfIHgVPLMEt7WCdxO', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `exam_code` varchar(20) DEFAULT NULL,
  `question_text` text NOT NULL,
  `option_a` text NOT NULL,
  `option_b` text NOT NULL,
  `option_c` text NOT NULL,
  `option_d` text NOT NULL,
  `correct_answer` enum('A','B','C','D') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `exam_code`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 'NWC2314', 'What does CPU stand for?', 'Central Processing Unit', 'Central Programming Unit', 'Control Processing Unit', 'Central Performance Unit', 'A'),
(2, 'NWC2314', 'Which data structure uses FIFO (First In First Out)?', 'Stack', 'Queue', 'Array', 'Tree', 'B'),
(3, 'NWC2314', 'Which of the following is NOT an operating system?', 'Linux', 'Windows', 'Oracle', 'macOS', 'C'),
(4, 'NWC2314', 'What is the primary purpose of a firewall in a computer network?', 'To enhance the display quality', 'To provide power backup', 'To monitor network speed', 'To prevent unauthorized access', 'D'),
(5, 'NWC2314', 'Which language is primarily used for web development?', 'Python', 'C++', 'HTML', 'Java', 'C'),
(6, 'NWC2314', 'What is the correct file extension for a Python file?', '.py', '.pt', '.pyt', '.p', 'A'),
(7, 'NWC2314', 'What is the binary equivalent of decimal number 10?', '1010', '1001', '1100', '1110', 'A'),
(8, 'NWC2314', 'In object-oriented programming, what does \'inheritance\' mean?', 'Copying code from another class', 'Creating a new variable', 'A class acquiring properties from another class', 'Deleting a class', 'C'),
(9, 'NWC2314', 'Which device connects multiple networks together?', 'Switch', 'Modem', 'Router', 'Hub', 'C'),
(10, 'NWC2314', 'What is the full form of URL?', 'Uniform Resource Locator', 'Universal Reference Link', 'Unique Resource Label', 'Uniform Readable Link', 'A'),
(11, 'NWC2314', 'Which of the following is a NoSQL database?', 'MySQL', 'PostgreSQL', 'MongoDB', 'Oracle', 'C'),
(12, 'NWC2314', 'Which HTML tag is used to create a hyperlink?', '<link>', '<href>', '<a>', '<url>', 'C'),
(13, 'NWC2314', 'Which logic gate returns true only if both inputs are true?', 'OR', 'NOT', 'AND', 'XOR', 'C'),
(14, 'NWC2314', 'What does IP stand for in IP address?', 'Internet Provider', 'Internal Protocol', 'Internet Protocol', 'Internal Provider', 'C'),
(15, 'NWC2314', 'Which one of the following is a programming language?', 'HTTP', 'SQL', 'Java', 'XML', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ic_number` varchar(20) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `programme_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `email`, `password`, `ic_number`, `phone`, `dob`, `address`, `programme_code`) VALUES
('AM2304013455', 'NURULFATINI IZZATI BINTI MOHAMAD KAMIL', 'fatiniizzatikamil@gmail.com', '$2y$10$GdDGZUsuOCUgUiWH4swaNOXQ9c7QKpn50k/dIDlQkQoiF/R.rBQku', '010813081098', NULL, NULL, NULL, 'CT206'),
('AM2304013678', 'MUHAMMAD BIN ABDULLAH', 'kl2304013678@student.uptm.edu.my', '$2y$10$r6ThXvPsRJcawuearu7L8e8vhoRMwfFsOC1T.cSCE5ww/LbYayNxO', '012345678901', NULL, NULL, NULL, 'CM101');

-- --------------------------------------------------------

--
-- Table structure for table `student_answers`
--

CREATE TABLE `student_answers` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `exam_code` varchar(20) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_answer` enum('A','B','C','D') NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_answers`
--

INSERT INTO `student_answers` (`id`, `student_id`, `exam_code`, `question_id`, `selected_answer`, `is_correct`, `submitted_at`) VALUES
(1, 'AM2304013455', 'NWC2314', 1, 'A', 1, '2025-04-23 15:37:19'),
(2, 'AM2304013455', 'NWC2314', 2, 'B', 1, '2025-04-23 15:37:19'),
(3, 'AM2304013455', 'NWC2314', 3, 'C', 1, '2025-04-23 15:37:19'),
(4, 'AM2304013455', 'NWC2314', 4, 'C', 0, '2025-04-23 15:37:19'),
(5, 'AM2304013455', 'NWC2314', 5, 'C', 1, '2025-04-23 15:37:19'),
(6, 'AM2304013455', 'NWC2314', 6, 'A', 1, '2025-04-23 15:37:19'),
(7, 'AM2304013455', 'NWC2314', 7, 'A', 1, '2025-04-23 15:37:19'),
(8, 'AM2304013455', 'NWC2314', 8, 'B', 0, '2025-04-23 15:37:19'),
(9, 'AM2304013455', 'NWC2314', 9, 'C', 1, '2025-04-23 15:37:19'),
(10, 'AM2304013455', 'NWC2314', 10, 'A', 1, '2025-04-23 15:37:19'),
(11, 'AM2304013455', 'NWC2314', 11, 'C', 1, '2025-04-23 15:37:19'),
(12, 'AM2304013455', 'NWC2314', 12, 'C', 1, '2025-04-23 15:37:19'),
(13, 'AM2304013455', 'NWC2314', 13, 'C', 1, '2025-04-23 15:37:19'),
(14, 'AM2304013455', 'NWC2314', 14, 'C', 1, '2025-04-23 15:37:19'),
(15, 'AM2304013455', 'NWC2314', 15, 'C', 1, '2025-04-23 15:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `setting_id` int(11) NOT NULL,
  `setting_name` varchar(50) NOT NULL,
  `setting_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`setting_id`, `setting_name`, `setting_value`) VALUES
(1, 'exam_duration', '60'),
(2, 'auto_submit', 'enabled'),
(3, 'randomize_questions', 'enabled'),
(4, 'one_time_attempt', 'enabled');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_code`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`lecturer_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `exam_code` (`exam_code`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `exam_code` (`exam_code`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `setting_name` (`setting_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `student_answers`
--
ALTER TABLE `student_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_code`) REFERENCES `exams` (`exam_code`) ON DELETE CASCADE;

--
-- Constraints for table `student_answers`
--
ALTER TABLE `student_answers`
  ADD CONSTRAINT `student_answers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_answers_ibfk_2` FOREIGN KEY (`exam_code`) REFERENCES `exams` (`exam_code`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_answers_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
