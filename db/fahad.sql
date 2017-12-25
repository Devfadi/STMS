-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2017 at 04:42 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imad`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE `assignment` (
  `AID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `COURSEID` int(11) NOT NULL,
  `ADDEDDATE` varchar(20) NOT NULL,
  `ADDEDBY` int(11) NOT NULL,
  `DUEDATE` varchar(20) NOT NULL,
  `VISIBILITY` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assignment`
--

INSERT INTO `assignment` (`AID`, `TITLE`, `DESCRIPTION`, `FILE`, `COURSEID`, `ADDEDDATE`, `ADDEDBY`, `DUEDATE`, `VISIBILITY`) VALUES
(1, 'Assig', 'Assignment testing', '09.14.2017-15.44.06-685200.pdf', 9, '2017-09-14 20:44:06', 6, '2017-09-16', 'DELETED'),
(2, 'Assig', 'Assignment testing', '09.14.2017-15.46.51-615700.pdf', 9, '2017-09-14 20:46:51', 6, '2017-09-15', 'ACTIVE'),
(3, 'Assignment', 'Testing ', '09.15.2017-05.38.46-721100.', 8, '2017-09-15 10:38:46', 6, '2017-09-16', 'ACTIVE'),
(4, 'Test', 'Test', '09.29.2017-10.50.38-021700.docx', 9, '2017-09-29 15:50:38', 6, '2017-09-30', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `AID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `ADATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `STATUS` varchar(20) NOT NULL,
  `ADDEDBY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`AID`, `USERID`, `CID`, `ADATE`, `STATUS`, `ADDEDBY`) VALUES
(1, 5, 8, '2017-11-27 10:29:15', 'P', 6),
(2, 8, 8, '2017-09-26 19:00:00', 'P', 6),
(3, 5, 8, '2017-09-27 19:00:00', 'P', 6),
(4, 8, 8, '2017-09-27 19:00:00', 'A', 6),
(5, 5, 8, '2017-10-01 19:00:00', 'P', 6),
(6, 8, 8, '2017-10-01 19:00:00', 'P', 6),
(7, 9, 8, '2017-10-01 19:00:00', 'P', 6),
(8, 5, 9, '2017-11-27 10:28:03', 'P', 6),
(9, 5, 9, '2017-11-02 10:52:56', 'p', 6),
(10, 11, 9, '2017-10-09 07:21:36', 'A', 6),
(11, 10, 9, '2017-10-08 19:00:00', 'P', 6),
(12, 5, 8, '2017-11-21 05:18:14', 'P', 6),
(13, 8, 8, '2017-11-21 05:17:41', '', 6),
(14, 9, 8, '2017-11-21 05:17:03', '', 6),
(15, 11, 8, '2017-10-08 19:00:00', 'P', 6),
(16, 10, 8, '2017-10-08 19:00:00', 'P', 6),
(17, 8, 8, '2017-10-22 19:00:00', 'P', 6),
(18, 9, 8, '2017-10-22 19:00:00', 'P', 6),
(19, 11, 8, '2017-10-22 19:00:00', 'A', 6),
(20, 10, 8, '2017-10-22 19:00:00', 'P', 6),
(21, 5, 8, '2017-10-22 19:00:00', 'P', 6),
(22, 5, 9, '2017-10-27 19:00:00', 'P', 6),
(23, 11, 9, '2017-10-28 09:50:52', 'A', 6),
(24, 10, 9, '2017-10-27 19:00:00', 'P', 6),
(25, 5, 9, '2017-11-27 10:28:34', 'P', 6),
(26, 11, 9, '2017-10-28 19:00:00', 'P', 6),
(27, 10, 9, '2017-10-28 19:00:00', 'P', 6),
(28, 5, 13, '2017-10-28 19:00:00', 'E', 13),
(29, 5, 13, '2017-10-29 19:00:00', 'P', 13),
(30, 5, 9, '2017-10-29 19:00:00', 'P', 6),
(31, 11, 9, '2017-10-29 19:00:00', 'A', 6),
(32, 10, 9, '2017-10-29 19:00:00', 'P', 6),
(33, 5, 9, '2017-10-30 19:00:00', 'P', 6),
(34, 11, 9, '2017-10-30 19:00:00', 'A', 6),
(35, 10, 9, '2017-10-30 19:00:00', 'P', 6),
(36, 5, 9, '2017-11-09 19:00:00', 'P', 6),
(37, 11, 9, '2017-11-09 19:00:00', 'P', 6),
(38, 10, 9, '2017-11-09 19:00:00', 'P', 6),
(39, 5, 9, '2017-11-10 19:00:00', 'P', 6),
(40, 11, 9, '2017-11-10 19:00:00', 'A', 6),
(41, 10, 9, '2017-11-10 19:00:00', 'P', 6),
(42, 8, 8, '2017-11-10 19:00:00', 'P', 6),
(43, 9, 8, '2017-11-10 19:00:00', 'P', 6),
(44, 11, 8, '2017-11-10 19:00:00', 'A', 6),
(45, 10, 8, '2017-11-10 19:00:00', 'P', 6),
(46, 5, 8, '2017-11-10 19:00:00', 'P', 6),
(47, 5, 9, '2017-11-20 19:00:00', 'P', 6),
(48, 11, 9, '2017-11-20 19:00:00', 'A', 6),
(49, 10, 9, '2017-11-20 19:00:00', 'P', 6),
(50, 11, 12, '2017-11-20 19:00:00', 'P', 6),
(51, 10, 12, '2017-11-20 19:00:00', 'P', 6),
(52, 15, 12, '2017-11-21 10:13:19', 'P', 6);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `COURSEID` int(11) NOT NULL,
  `NAME` varchar(50) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `ADDEDBY` int(11) NOT NULL,
  `ADDEDDATE` varchar(20) NOT NULL,
  `VISIBILITY` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`COURSEID`, `NAME`, `DESCRIPTION`, `ADDEDBY`, `ADDEDDATE`, `VISIBILITY`) VALUES
(8, 'Php', 'Testing course', 6, '2017-09-14 20:42:16', 'ACTIVE'),
(9, 'C++', 'This is testing', 6, '2017-09-14 20:42:31', 'ACTIVE'),
(10, '', '', 6, '2017-09-15 10:36:18', 'DELETED'),
(11, 'c#', ' This is c# course', 6, '2017-09-15 10:36:37', 'DELETED'),
(12, 'Zurb foundation', 'This is the bootstrap framework', 6, '2017-10-04 20:55:20', 'ACTIVE'),
(13, 'oop php', 'This is the simple oop php course', 13, '2017-10-29 19:13:57', 'ACTIVE'),
(14, 'abc', 'checking', 6, '2017-11-15 21:51:51', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `EID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `COURSEID` int(11) NOT NULL,
  `ADDEDDATE` varchar(20) NOT NULL,
  `VISIBILITY` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  `STATUS` varchar(20) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`EID`, `USERID`, `COURSEID`, `ADDEDDATE`, `VISIBILITY`, `STATUS`) VALUES
(12, 5, 9, '2017-09-14 20:44:39', 'ACTIVE', 'APPROVED'),
(13, 5, 8, '2017-09-14 20:44:43', 'DELETED', 'APPROVED'),
(14, 5, 11, '2017-09-19 10:46:42', 'ACTIVE', 'APPROVED'),
(15, 8, 8, '2017-09-27 16:28:02', 'ACTIVE', 'APPROVED'),
(16, 9, 8, '2017-10-02 08:45:55', 'ACTIVE', 'APPROVED'),
(17, 11, 12, '2017-10-08 21:51:47', 'ACTIVE', 'APPROVED'),
(18, 11, 9, '2017-10-08 21:51:49', 'ACTIVE', 'APPROVED'),
(19, 11, 8, '2017-10-08 21:51:53', 'ACTIVE', 'APPROVED'),
(20, 10, 12, '2017-10-08 21:52:14', 'ACTIVE', 'APPROVED'),
(21, 10, 9, '2017-10-08 21:52:17', 'ACTIVE', 'APPROVED'),
(22, 10, 8, '2017-10-08 21:52:20', 'ACTIVE', 'APPROVED'),
(23, 5, 8, '2017-10-13 11:56:22', 'ACTIVE', 'APPROVED'),
(24, 5, 13, '2017-10-29 19:14:27', 'ACTIVE', 'APPROVED'),
(25, 5, 14, '2017-11-15 21:53:36', 'ACTIVE', 'APPROVED'),
(26, 14, 14, '2017-11-17 10:22:39', 'ACTIVE', 'APPROVED'),
(27, 15, 12, '2017-11-21 14:07:27', 'ACTIVE', 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `lecture`
--

CREATE TABLE `lecture` (
  `LID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `COURSEID` int(11) NOT NULL,
  `ADDEDDATE` varchar(20) NOT NULL,
  `ADDEDBY` int(11) NOT NULL,
  `VISIBILITY` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`LID`, `TITLE`, `DESCRIPTION`, `FILE`, `COURSEID`, `ADDEDDATE`, `ADDEDBY`, `VISIBILITY`) VALUES
(14, 'Lecture 1', 'This is lecture', '09.14.2017-15.43.27-211000.pdf', 9, '2017-09-14 20:43:27', 6, 'ACTIVE'),
(15, 'Lecture 1', 'This testing', '09.15.2017-05.37.30-095400.docx', 11, '2017-09-15 10:37:30', 6, 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `QID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `COURSEID` int(11) NOT NULL,
  `ADDEDDATE` varchar(20) NOT NULL,
  `ADDEDBY` int(11) NOT NULL,
  `DUEDATE` varchar(20) NOT NULL,
  `VISIBILITY` varchar(10) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`QID`, `TITLE`, `DESCRIPTION`, `FILE`, `COURSEID`, `ADDEDDATE`, `ADDEDBY`, `DUEDATE`, `VISIBILITY`) VALUES
(1, 'Test', 'Test', '10.09.2017-04.09.08-162200.', 9, '2017-10-09 09:09:08', 6, '2017-10-10', 'ACTIVE'),
(2, 'gpa', 'This is gpa', '10.23.2017-08.45.06-058900.', 8, '2017-10-23 13:45:06', 6, '1970-01-01', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `studentmarks`
--

CREATE TABLE `studentmarks` (
  `SMID` int(11) NOT NULL,
  `STUDENTID` int(11) NOT NULL,
  `CID` int(11) NOT NULL,
  `QUIZ` int(11) NOT NULL DEFAULT '0',
  `ASSIGNMENT` int(11) NOT NULL DEFAULT '0',
  `ATTENDANCE` int(11) NOT NULL DEFAULT '0',
  `MID` int(11) NOT NULL DEFAULT '0',
  `FINAL` int(11) NOT NULL DEFAULT '0',
  `OBTAINED` int(11) NOT NULL DEFAULT '0',
  `TOTAL` int(11) NOT NULL DEFAULT '0',
  `GPA` float NOT NULL DEFAULT '0',
  `ADDEDBY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentmarks`
--

INSERT INTO `studentmarks` (`SMID`, `STUDENTID`, `CID`, `QUIZ`, `ASSIGNMENT`, `ATTENDANCE`, `MID`, `FINAL`, `OBTAINED`, `TOTAL`, `GPA`, `ADDEDBY`) VALUES
(10, 5, 9, 33, 3, 7, 15, 55, 75, 100, 3.52, 6),
(11, 11, 9, 3, 3, 4, 16, 44, 0, 100, 3, 6),
(12, 10, 9, 4, 3, 7, 15, 55, 0, 100, 3.52, 6),
(13, 8, 8, 3, 4, 7, 15, 55, 84, 100, 0, 6),
(14, 9, 8, 0, 0, 0, 0, 0, 0, 0, 0, 6),
(15, 11, 8, 0, 0, 0, 0, 0, 0, 0, 0, 6),
(16, 10, 8, 0, 0, 0, 0, 0, 0, 0, 0, 6),
(17, 5, 8, 0, 0, 0, 0, 0, 0, 0, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `student_assignments`
--

CREATE TABLE `student_assignments` (
  `SAID` int(11) NOT NULL,
  `AID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `SUBMITTIONDATE` varchar(20) NOT NULL,
  `MARKS` varchar(10) NOT NULL,
  `REMARKS` text NOT NULL,
  `NOTIFICATION` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_assignments`
--

INSERT INTO `student_assignments` (`SAID`, `AID`, `USERID`, `TITLE`, `DESCRIPTION`, `FILE`, `SUBMITTIONDATE`, `MARKS`, `REMARKS`, `NOTIFICATION`) VALUES
(2, 2, 5, 'Assig', 'Testing', '09.15.2017-04.05.04-315500.docx', '2017-09-15 09:05:04', '0', '10', 'SUBMITTED'),
(3, 3, 5, '', '', '', '', '', '', 'ACTIVE'),
(4, 4, 5, '', '', '', '', '8', '10', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `student_quizes`
--

CREATE TABLE `student_quizes` (
  `SQID` int(11) NOT NULL,
  `QID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `FILE` varchar(255) NOT NULL,
  `SUBMITTIONDATE` varchar(20) NOT NULL,
  `MARKS` varchar(10) NOT NULL,
  `REMARKS` text NOT NULL,
  `NOTIFICATION` varchar(20) NOT NULL DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_quizes`
--

INSERT INTO `student_quizes` (`SQID`, `QID`, `USERID`, `TITLE`, `DESCRIPTION`, `FILE`, `SUBMITTIONDATE`, `MARKS`, `REMARKS`, `NOTIFICATION`) VALUES
(1, 1, 5, '', '', '', '', '', '', 'ACTIVE'),
(2, 1, 11, '', '', '', '', '', '', 'ACTIVE'),
(3, 1, 10, '', '', '', '', '', '', 'ACTIVE'),
(4, 2, 8, '', '', '', '', '', '', 'ACTIVE'),
(5, 2, 9, '', '', '', '', '', '', 'ACTIVE'),
(6, 2, 11, '', '', '', '', '', '', 'ACTIVE'),
(7, 2, 10, '', '', '', '', '', '', 'ACTIVE'),
(8, 2, 5, '', '', '', '', '', '', 'ACTIVE');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `USERID` int(11) NOT NULL,
  `FIRSTNAME` varchar(50) NOT NULL,
  `LASTNAME` varchar(50) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `CONTACTNO` varchar(20) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `TEMPASSWORD` varchar(255) NOT NULL,
  `ACCOUNT` varchar(10) NOT NULL,
  `ADDEDDATE` varchar(20) NOT NULL,
  `VISIBILITY` varchar(10) NOT NULL DEFAULT 'ACTIVE',
  `EDUCATION` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`USERID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `CONTACTNO`, `PASSWORD`, `TEMPASSWORD`, `ACCOUNT`, `ADDEDDATE`, `VISIBILITY`, `EDUCATION`) VALUES
(4, 'Fahad', 'Z', '', '', 'd41d8cd98f00b204e9800998ecf8427e', '', 'TEACHER', '2017-09-14 17:40:22', 'ACTIVE', ''),
(5, 'Fahad', 'Zaman', 'fahadzaman249@gmail.com', '03145756501', 'e10adc3949ba59abbe56e057f20f883e', 'ddc66f90ea0ed53ac1481d3dd7a7b619', 'STUDENT', '2017-09-14 17:41:01', 'ACTIVE', ''),
(6, 'Imad', 'khan', 'imaduddin0198@gmail.com', '03145756501', 'e10adc3949ba59abbe56e057f20f883e', '', 'TEACHER', '2017-09-14 17:41:39', 'ACTIVE', ''),
(7, 'Ali', 'Khan', 'ali@gmail.com', '03145756501', 'fcea920f7412b5da7be0cf42b8c93759', '', 'STUDENT', '2017-09-27 13:21:23', 'ACTIVE', ''),
(8, 'Fahad', 'Khan', 'fahad5578@yahoo.com', '03145756501', '25d55ad283aa400af464c76d713c07ad', '', 'STUDENT', '2017-09-27 13:22:01', 'ACTIVE', ''),
(9, 'Shayan', 'Khan', 'iffi4002@gmail.com', '03109415571', '827ccb0eea8a706c4c34a16891f84e7b', '', 'STUDENT', '2017-10-02 05:45:12', 'ACTIVE', ''),
(10, 'Yaseen', 'Khan', 'yaseenkhan55782@gmail.com', '03105455524', 'e10adc3949ba59abbe56e057f20f883e', '', 'STUDENT', '2017-10-08 18:50:18', 'ACTIVE', ''),
(11, 'Shayan', 'Khan', 'fahadzaman5578@gmail.com', '03109415571', 'e10adc3949ba59abbe56e057f20f883e', '', 'STUDENT', '2017-10-08 18:51:16', 'ACTIVE', ''),
(12, 'hfhh', 'hfhdsjhf', 'fsdjfhdj@FSDSF.DSFDS', 'fjsdhfkj', '6d87a19f011653459575ceb722db3b69', '', 'STUDENT', '2017-10-24 20:17:30', 'ACTIVE', ''),
(13, 'hamad', 'khan', 'hamaad.khan81@gmail.com', '334324234', 'e10adc3949ba59abbe56e057f20f883e', '', 'TEACHER', '2017-10-29 16:13:12', 'ACTIVE', ''),
(14, 'Khan', 'Jan', 'khan@gmail.com', '0434882134', '827ccb0eea8a706c4c34a16891f84e7b', '', 'STUDENT', '2017-11-17 07:22:08', 'ACTIVE', ''),
(15, 'nomi', 'khan', 'nomi@live.com', '12323432', '3b712de48137572f3849aabd5666a4e3', '', 'STUDENT', '2017-11-21 11:04:59', 'ACTIVE', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignment`
--
ALTER TABLE `assignment`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`AID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`COURSEID`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`EID`);

--
-- Indexes for table `lecture`
--
ALTER TABLE `lecture`
  ADD PRIMARY KEY (`LID`);

--
-- Indexes for table `quiz`
--
ALTER TABLE `quiz`
  ADD PRIMARY KEY (`QID`);

--
-- Indexes for table `studentmarks`
--
ALTER TABLE `studentmarks`
  ADD PRIMARY KEY (`SMID`);

--
-- Indexes for table `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD PRIMARY KEY (`SAID`);

--
-- Indexes for table `student_quizes`
--
ALTER TABLE `student_quizes`
  ADD PRIMARY KEY (`SQID`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignment`
--
ALTER TABLE `assignment`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `COURSEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `EID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `lecture`
--
ALTER TABLE `lecture`
  MODIFY `LID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `quiz`
--
ALTER TABLE `quiz`
  MODIFY `QID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `studentmarks`
--
ALTER TABLE `studentmarks`
  MODIFY `SMID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `student_assignments`
--
ALTER TABLE `student_assignments`
  MODIFY `SAID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `student_quizes`
--
ALTER TABLE `student_quizes`
  MODIFY `SQID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
