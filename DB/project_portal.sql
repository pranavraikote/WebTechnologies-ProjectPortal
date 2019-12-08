-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2019 at 02:20 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `loginform`
--

CREATE TABLE `loginform` (
  `ID` varchar(5) NOT NULL,
  `User` varchar(10) DEFAULT NULL,
  `Pass` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `loginform`
--

INSERT INTO `loginform` (`ID`, `User`, `Pass`) VALUES
('101', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(45) NOT NULL,
  `subject_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `subject_code`) VALUES
(1001, 'Professional Elective Management System', '15CS71'),
(1002, 'Timetable Management System', '15CS71'),
(1003, 'Laboratory Management System', '15CS71'),
(1005, 'Placement Management System', '15CS71'),
(1006, 'Parents teachers Management System', '15CS71'),
(1007, 'Entrepreneur Information Mgmt System', '15CS71'),
(1008, 'Higher Education Management System', '15CS71'),
(1016, 'Result Analysis Management System', '15CS71'),
(1017, 'Open Course Management System', '15CS71'),
(1018, 'Diploma Students Management System', '15CS71'),
(1022, 'Research Information Management System', '15CS71'),
(1023, 'Open Elective Management System', '15CS71'),
(1024, 'Project Portal Management System', '15CS71'),
(1027, 'Budget Management System', '15CS71'),
(1043, 'Course File Generater Management System', '15CS71'),
(1044, 'SC/ST Cell Management System', '15CS71'),
(1045, 'Activity Points Management System', '15CS71');

-- --------------------------------------------------------

--
-- Table structure for table `sloginform`
--

CREATE TABLE `sloginform` (
  `ID` varchar(5) NOT NULL,
  `User` varchar(10) DEFAULT NULL,
  `Pass` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sloginform`
--

INSERT INTO `sloginform` (`ID`, `User`, `Pass`) VALUES
('101', 'student', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `usn` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `email` text DEFAULT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`usn`, `name`, `email`, `password`) VALUES
('1BY15CS115', 'Harshit Gupta', 'gupta@gmail.com', 'student'),
('1BY16CS006', 'Akshay Padesur', 'akshay@gmail.com', 'student'),
('1BY16CS062', 'Pranav Raikote', 'pranavraikote@gmail.com', 'student'),
('1By16cs079', 'Shwetha', 'shwetha@gmail.in', 'student'),
('1By16cs083', 'Spooorthy', 'spoorthy@bmsit.in', 'domlur'),
('1BY16CS084', 'Sudarshan Venkatesh', 'sudarshanravi13@gmail.com', 'student'),
('1BY16CS085', 'Suman', 'suman@gmail.com', 'student'),
('1BY16CS086', 'Sumanth NCC', 'sumanthnc@gmail.com', 'student'),
('1BY16CS111', 'Manoj Kumar', 'manoj@bdmsit.in', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `works_on`
--

CREATE TABLE `works_on` (
  `usn` varchar(10) NOT NULL,
  `project_id` int(11) NOT NULL,
  `request` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `works_on`
--

INSERT INTO `works_on` (`usn`, `project_id`, `request`) VALUES
('1BY16CS062', 1024, 'NO'),
('1BY15CS115', 1024, 'NO'),
('1BY16CS006', 1007, 'NO'),
('1BY16CS111', 1007, 'NO'),
('1By16cs083', 1017, 'NO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `loginform`
--
ALTER TABLE `loginform`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `User` (`User`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`usn`),
  ADD UNIQUE KEY `email` (`email`) USING HASH;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
