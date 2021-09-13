
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";

--
-- Database: `brave_database`
--

CREATE DATABASE IF NOT EXISTS `brave_database` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `brave_database`;

-- --------------------------------------------------------

--
-- User: `brave`
--

CREATE USER 'brave'@'%' IDENTIFIED BY '0000';
GRANT ALL PRIVILEGES ON *.* TO 'brave'@'%' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON `brave_database`.* TO 'brave'@'%';

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_no` int(5) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `class_name` varchar(40) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `dateposted` datetime NOT NULL,
  `dateupdated` datetime DEFAULT NULL,
  `postedby` int(5) NOT NULL DEFAULT '0',
  `editedby` int(5) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `host` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_no`, `class_name`, `status`, `dateposted`, `dateupdated`, `postedby`, `editedby`, `ip`, `host`) VALUES
(1, 'Arts', 2, '2021-09-12 15:55:48', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(2, 'Sciences', 2, '2021-09-12 15:55:59', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(3, 'Commercials', 2, '2021-09-12 16:02:13', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_no` int(5) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `studentID` varchar(12) NOT NULL,
  `class_no` int(5) NOT NULL DEFAULT '0',
  `year` int(4) NOT NULL DEFAULT '2021',
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `contact_phone` varchar(14) NOT NULL,
  `address` text NOT NULL,
  `full_name` varchar(40) NOT NULL,
  `dateposted` datetime NOT NULL,
  `dateupdated` datetime DEFAULT NULL,
  `postedby` int(5) NOT NULL DEFAULT '0',
  `editedby` int(5) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `host` varchar(60) DEFAULT NULL,
  `photo` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_no`, `studentID`, `class_no`, `year`, `first_name`, `last_name`, `birth_date`, `contact_phone`, `address`, `full_name`, `dateposted`, `dateupdated`, `postedby`, `editedby`, `ip`, `host`, `photo`) VALUES
(1, 'RKDC83680944', 2, 2020, 'Maxine', 'Omotesho', '2011-01-04', '+2348102112212', '#3a, Aneke Crescent, Greenville Estate, Utako', 'Femi Omotesho', '2021-09-12 16:09:56', '2021-09-12 16:24:58', 1, 1, '::1', 'Windows NT 10.0; Win64; x64', '1-school_girl_2.jpg'),
(2, 'TBJP27986507', 3, 2022, 'Xander', 'Omotesho', '2014-04-16', '+2348102112212', '#3a, Aneke Crescent, Greenville Estate, Utako', 'Femi Omotesho', '2021-09-12 16:14:21', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64', '2-school_boy_3.jpg'),
(3, 'HUEK78299479', 1, 2021, 'Tommy', 'Aruwayo-Obe', '2013-07-09', '+2348023517464', 'House 8, Serene Courts, Osapa London District, Katampe', 'Gbemisola Aruwayo-obe', '2021-09-12 16:18:10', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64', '3-schoo_girl_1.jpg'),
(4, 'AUEK40743521', 3, 2019, 'Tammy', 'Aruwayo-obe', '2010-11-10', '+2348023517464', 'House 8, Serene Courts, Osapa London District, Katampe', 'Gbemisola Aruwayo-obe', '2021-09-12 16:21:05', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64', '4-school_girl_3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_no` int(5) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `subjectID` varchar(10) UNIQUE KEY NOT NULL,
  `title` varchar(40) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `dateposted` datetime NOT NULL,
  `dateupdated` datetime DEFAULT NULL,
  `postedby` int(5) NOT NULL DEFAULT '0',
  `editedby` int(5) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `host` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_no`, `subjectID`, `title`, `status`, `dateposted`, `dateupdated`, `postedby`, `editedby`, `ip`, `host`) VALUES
(1, 'GJ28123245', 'English Language', 2, '2021-09-12 15:50:43', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(2, 'RY79791434', 'Yoruba Language', 2, '2021-09-12 15:51:45', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(3, 'HA40725603', 'Geography', 2, '2021-09-12 15:52:01', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(4, 'WK96763068', 'Economics', 2, '2021-09-12 15:52:14', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(5, 'VS81333695', 'Mathematics', 2, '2021-09-12 15:52:24', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(6, 'YF43286783', 'Physics', 2, '2021-09-12 15:52:35', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(7, 'MZ63668770', 'Chemistry', 2, '2021-09-12 15:52:44', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(8, 'WY40187362', 'Biology', 2, '2021-09-12 15:52:53', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(9, 'GC46355666', 'Agricultural Science', 2, '2021-09-12 15:53:07', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(10, 'DV67836096', 'Commerce', 2, '2021-09-12 15:53:18', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(11, 'SH83589719', 'Literature', 2, '2021-09-12 15:53:27', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(12, 'PN69255274', 'Further Mathematics', 2, '2021-09-12 15:53:41', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(13, 'LG89833016', 'Civil Studies', 2, '2021-09-12 15:53:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(14, 'DX78561574', 'Government', 2, '2021-09-12 15:54:07', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(15, 'SG55194898', 'Fine Arts', 2, '2021-09-12 15:54:22', '2021-09-12 15:57:28', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(16, 'LZ48825643', 'Technical Drawing', 2, '2021-09-12 15:54:35', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(17, 'KX12815771', 'Creative Arts', 2, '2021-09-12 15:54:57', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(18, 'RD90758509', 'Theatre Arts', 2, '2021-09-12 15:55:09', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(19, 'UN19491332', 'Finance', 2, '2021-09-12 15:55:34', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64');

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `ss_no` int(5) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `student_no` int(5) NOT NULL DEFAULT '0',
  `subject_no` int(5) NOT NULL DEFAULT '0',
  `score` int(2) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `dateposted` datetime NOT NULL,
  `dateupdated` datetime DEFAULT NULL,
  `postedby` int(5) NOT NULL DEFAULT '1',
  `editedby` int(1) DEFAULT NULL,
  `ip` varchar(30) NOT NULL,
  `host` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`ss_no`, `student_no`, `subject_no`, `score`, `status`, `dateposted`, `dateupdated`, `postedby`, `editedby`, `ip`, `host`) VALUES
(1, 1, 1, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(2, 1, 5, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(3, 1, 6, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(4, 1, 7, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(5, 1, 8, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(6, 1, 12, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(7, 1, 16, NULL, 2, '2021-09-12 16:09:56', NULL, 1, NULL, '::1', 'Windows NT 10.0; Win64; x64'),
(8, 2, 1, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(9, 2, 2, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(10, 2, 5, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(11, 2, 9, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(12, 2, 10, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(13, 2, 13, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(14, 2, 14, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(15, 2, 19, NULL, 2, '2021-09-12 16:14:21', '2021-09-12 16:31:27', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(16, 3, 1, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(17, 3, 2, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(18, 3, 3, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(19, 3, 11, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(20, 3, 13, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(21, 3, 15, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(22, 3, 17, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(23, 3, 18, NULL, 2, '2021-09-12 16:18:10', '2021-09-12 16:26:35', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(24, 4, 1, 90, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(25, 4, 2, 95, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(26, 4, 3, 45, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(27, 4, 4, 75, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(28, 4, 5, 65, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(29, 4, 9, 35, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(30, 4, 10, 85, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(31, 4, 13, 90, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(32, 4, 14, 95, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64'),
(33, 4, 19, 95, 2, '2021-09-12 16:21:05', '2021-09-12 16:31:48', 1, 1, '::1', 'Windows NT 10.0; Win64; x64');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_no` int(5) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `job_title` varchar(50) DEFAULT NULL,
  `phone` varchar(14) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(250) DEFAULT NULL,
  `dateposted` datetime NOT NULL,
  `dateupdated` datetime DEFAULT NULL,
  `dateended` datetime DEFAULT NULL,
  `postedby` int(5) NOT NULL DEFAULT '0',
  `editedby` int(5) DEFAULT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `host` varchar(60) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `photo` text,
  `online` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_no`, `first_name`, `last_name`, `job_title`, `phone`, `email`, `password`, `dateposted`, `dateupdated`, `dateended`, `postedby`, `editedby`, `ip`, `host`, `status`, `photo`, `online`) VALUES
(1, 'Onyeche', 'Douglas', 'Program Manager', '+2348183887566', 'oagbiti-douglas@boi.ng', '4a7d1ed414474e4033ac29ccb8653d9b', '2021-09-09 15:27:21', '2021-09-11 18:56:58', NULL, 1, 1, '127.0.0.1', 'Windows NT 10.0; Win64; x64', 2, 'Onyeche_Elisabeth_Douglas_Profile_Photo.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `act_no` bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `user_no` int(10) NOT NULL DEFAULT '0',
  `ip` text NOT NULL,
  `host` text NOT NULL,
  `dateposted` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `log_no` int(10) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_no` int(10) NOT NULL,
  `lastlogin_time` datetime NOT NULL,
  `login_count` bigint(30) NOT NULL,
  `Ip` varchar(30) DEFAULT NULL,
  `host` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_logintimes`
--

CREATE TABLE `user_logintimes` (
  `logs_no` bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `user_no` int(10) NOT NULL,
  `login_time` datetime NOT NULL,
  `ip` varchar(30) DEFAULT NULL,
  `host` varchar(60) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--

ALTER TABLE `users`
  ADD UNIQUE KEY `phone` (`phone`,`email`);

--
-- Indexes for table `user_login`
--

ALTER TABLE `user_login`
  ADD UNIQUE KEY `user_login` (`user_no`,`lastlogin_time`);


COMMIT;