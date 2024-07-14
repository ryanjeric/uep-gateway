-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2015 at 03:50 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gateway`
--

-- --------------------------------------------------------

--
-- Table structure for table `changegrade`
--

CREATE TABLE IF NOT EXISTS `changegrade` (
  `changegradeid` int(11) NOT NULL AUTO_INCREMENT,
  `OR` text NOT NULL,
  `reason` text NOT NULL,
  `datechange` text NOT NULL,
  `sem` int(11) NOT NULL,
  `coursecode` text NOT NULL,
  PRIMARY KEY (`changegradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `coursetbl`
--

CREATE TABLE IF NOT EXISTS `coursetbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coursecode` text NOT NULL,
  `coursedesc` text NOT NULL,
  `section` text NOT NULL,
  `nolec` int(11) NOT NULL,
  `nolab` int(11) NOT NULL,
  `labtype` text NOT NULL,
  `slots` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `finalgrade`
--

CREATE TABLE IF NOT EXISTS `finalgrade` (
  `finalgradeid` int(11) NOT NULL AUTO_INCREMENT,
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q_equivalent` int(11) DEFAULT NULL,
  `r` int(11) DEFAULT NULL,
  `r_equivalent` int(11) DEFAULT NULL,
  `pw` int(11) DEFAULT NULL,
  `pw_equivalent` int(11) DEFAULT NULL,
  `exam_lec` int(11) DEFAULT NULL,
  `exam_lec_equivalent` int(11) DEFAULT NULL,
  `grade_lec` decimal(5,2) DEFAULT NULL,
  `lw1` int(11) DEFAULT NULL,
  `lw2` int(11) DEFAULT NULL,
  `lw3` int(11) DEFAULT NULL,
  `lw_equivalent` int(11) DEFAULT NULL,
  `cs` int(11) DEFAULT NULL,
  `cs_equivalent` int(11) DEFAULT NULL,
  `exam_lab` int(11) DEFAULT NULL,
  `exam_lab_equivalent` int(11) DEFAULT NULL,
  `grade_lab` decimal(5,2) DEFAULT NULL,
  `grade_final` int(11) DEFAULT NULL,
  PRIMARY KEY (`finalgradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE IF NOT EXISTS `gradesheet` (
  `gradesheetid` int(11) NOT NULL AUTO_INCREMENT,
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentid` bigint(20) NOT NULL,
  `grade` enum('5.00','3.00','2.75','2.50','2.25','2.00','1.75','1.50','1.25','1.00','OD','UD','NFE','INC','Normal') NOT NULL,
  PRIMARY KEY (`gradesheetid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `grading_overscore`
--

CREATE TABLE IF NOT EXISTS `grading_overscore` (
  `overscoreid` int(11) NOT NULL AUTO_INCREMENT,
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `grading` enum('PRELIM','MIDTERM','PREFINAL','FINAL') NOT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q_total` int(11) DEFAULT NULL,
  `r` int(11) DEFAULT NULL,
  `pw` int(11) DEFAULT NULL,
  `exam_lec` int(11) DEFAULT NULL,
  `lw1` int(11) DEFAULT NULL,
  `lw2` int(11) DEFAULT NULL,
  `lw3` int(11) DEFAULT NULL,
  `lw_total` int(11) DEFAULT NULL,
  `cs` int(11) DEFAULT NULL,
  `exam_lab` int(11) DEFAULT NULL,
  `finalposting` enum('F','T') NOT NULL,
  PRIMARY KEY (`overscoreid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `midtermgrade`
--

CREATE TABLE IF NOT EXISTS `midtermgrade` (
  `midtermgradeid` int(11) NOT NULL AUTO_INCREMENT,
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q_equivalent` int(11) DEFAULT NULL,
  `r` int(11) DEFAULT NULL,
  `r_equivalent` int(11) DEFAULT NULL,
  `pw` int(11) DEFAULT NULL,
  `pw_equivalent` int(11) DEFAULT NULL,
  `exam_lec` int(11) DEFAULT NULL,
  `exam_lec_equivalent` int(11) DEFAULT NULL,
  `grade_lec` decimal(5,2) DEFAULT NULL,
  `lw1` int(11) DEFAULT NULL,
  `lw2` int(11) DEFAULT NULL,
  `lw3` int(11) DEFAULT NULL,
  `lw_equivalent` int(11) DEFAULT NULL,
  `cs` int(11) DEFAULT NULL,
  `cs_equivalent` int(11) DEFAULT NULL,
  `exam_lab` int(11) DEFAULT NULL,
  `exam_lab_equivalent` int(11) DEFAULT NULL,
  `grade_lab` decimal(5,2) DEFAULT NULL,
  `grade_midterm` int(11) DEFAULT NULL,
  PRIMARY KEY (`midtermgradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ozekimessagein`
--

CREATE TABLE IF NOT EXISTS `ozekimessagein` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL,
  `msg` varchar(160) DEFAULT NULL,
  `senttime` varchar(100) DEFAULT NULL,
  `receivedtime` varchar(100) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  `msgtype` varchar(160) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `replied` enum('No','Yes') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ozekimessageout`
--

CREATE TABLE IF NOT EXISTS `ozekimessageout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(30) DEFAULT NULL,
  `receiver` varchar(30) DEFAULT NULL,
  `msg` varchar(160) DEFAULT NULL,
  `senttime` varchar(100) DEFAULT NULL,
  `receivedtime` varchar(100) DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `msgtype` varchar(160) DEFAULT NULL,
  `operator` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `prefinalgrade`
--

CREATE TABLE IF NOT EXISTS `prefinalgrade` (
  `prefinalgradeid` int(11) NOT NULL AUTO_INCREMENT,
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q_equivalent` int(11) DEFAULT NULL,
  `r` int(11) DEFAULT NULL,
  `r_equivalent` int(11) DEFAULT NULL,
  `pw` int(11) DEFAULT NULL,
  `pw_equivalent` int(11) DEFAULT NULL,
  `exam_lec` int(11) DEFAULT NULL,
  `exam_lec_equivalent` int(11) DEFAULT NULL,
  `grade_lec` decimal(5,2) DEFAULT NULL,
  `lw1` int(11) DEFAULT NULL,
  `lw2` int(11) DEFAULT NULL,
  `lw3` int(11) DEFAULT NULL,
  `lw_equivalent` int(11) DEFAULT NULL,
  `cs` int(11) DEFAULT NULL,
  `cs_equivalent` int(11) DEFAULT NULL,
  `exam_lab` int(11) DEFAULT NULL,
  `exam_lab_equivalent` int(11) DEFAULT NULL,
  `grade_lab` decimal(5,2) DEFAULT NULL,
  `grade_prefinal` int(11) DEFAULT NULL,
  PRIMARY KEY (`prefinalgradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `prelimgrade`
--

CREATE TABLE IF NOT EXISTS `prelimgrade` (
  `prelimgradeid` int(11) NOT NULL AUTO_INCREMENT,
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `q1` int(11) DEFAULT NULL,
  `q2` int(11) DEFAULT NULL,
  `q_equivalent` int(11) DEFAULT NULL,
  `r` int(11) DEFAULT NULL,
  `r_equivalent` int(11) DEFAULT NULL,
  `pw` int(11) DEFAULT NULL,
  `pw_equivalent` int(11) DEFAULT NULL,
  `exam_lec` int(11) DEFAULT NULL,
  `exam_lec_equivalent` int(11) DEFAULT NULL,
  `grade_lec` decimal(5,2) DEFAULT NULL,
  `lw1` int(11) DEFAULT NULL,
  `lw2` int(11) DEFAULT NULL,
  `lw3` int(11) DEFAULT NULL,
  `lw_equivalent` int(11) DEFAULT NULL,
  `cs` int(11) DEFAULT NULL,
  `cs_equivalent` int(11) DEFAULT NULL,
  `exam_lab` int(11) DEFAULT NULL,
  `exam_lab_equivalent` int(11) DEFAULT NULL,
  `grade_lab` decimal(5,2) DEFAULT NULL,
  `grade_prelim` int(11) DEFAULT NULL,
  `complied` enum('No','Yes') NOT NULL,
  PRIMARY KEY (`prelimgradeid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE IF NOT EXISTS `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `programdesc` text NOT NULL,
  `abbreviation` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `registrar`
--

CREATE TABLE IF NOT EXISTS `registrar` (
  `ctr` int(11) NOT NULL AUTO_INCREMENT,
  `empid` text NOT NULL,
  `lname` text NOT NULL,
  `gname` text NOT NULL,
  `designation` text NOT NULL,
  `password` text NOT NULL,
  `status` text NOT NULL,
  `datehired` text NOT NULL,
  PRIMARY KEY (`ctr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `registrar`
--

INSERT INTO `registrar` (`ctr`, `empid`, `lname`, `gname`, `designation`, `password`, `status`, `datehired`) VALUES
(2, '201504003', 'Calugay', 'Deborah', 'REGISTRAR', 'password101', 'ACTIVATE', '04/08/2015');

-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE IF NOT EXISTS `reply` (
  `id` int(11) DEFAULT NULL,
  `receiver` text NOT NULL,
  `msg` text NOT NULL,
  `senttime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roomstbl`
--

CREATE TABLE IF NOT EXISTS `roomstbl` (
  `ctr` int(11) NOT NULL AUTO_INCREMENT,
  `roomname` text NOT NULL,
  `roomdesc` text NOT NULL,
  `type` text NOT NULL,
  `typeothers` text NOT NULL,
  `ventilation` text NOT NULL,
  `seatcap` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `postedby` text NOT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`ctr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `roomstbl`
--

INSERT INTO `roomstbl` (`ctr`, `roomname`, `roomdesc`, `type`, `typeothers`, `ventilation`, `seatcap`, `area`, `postedby`, `remarks`) VALUES
(3, 'RM102', 'GROUND FLOOR LECTURE ROOM', 'Lecture Room', '', 'Without AirCon', 40, 10, 'Valena', ''),
(2, 'RM101', 'GROUND FLOOR LECTURE ROOM ', 'Lecture Room', '', 'Without AirCon', 40, 40, 'Valena', ''),
(4, 'COMPLAB201', '2ND FLOOR COMPUTER LABORATORY ROOM', 'Lab Room', '', 'With AirCon', 40, 15, 'Valena', '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `courseid` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `m` int(11) NOT NULL,
  `t` int(11) NOT NULL,
  `w` int(11) NOT NULL,
  `th` int(11) NOT NULL,
  `f` int(11) NOT NULL,
  `s` int(11) NOT NULL,
  `starthr` int(11) NOT NULL,
  `startmin` int(11) NOT NULL,
  `starttypeday` text NOT NULL,
  `endhr` int(11) NOT NULL,
  `endmin` int(11) NOT NULL,
  `endtypeday` text NOT NULL,
  `room` int(11) NOT NULL,
  `instructor` int(11) NOT NULL,
  `classtype` text NOT NULL,
  `remarks` text NOT NULL,
  `mynumber` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `semtbl`
--

CREATE TABLE IF NOT EXISTS `semtbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `syear` text NOT NULL,
  `sem` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `semtbl`
--

INSERT INTO `semtbl` (`id`, `syear`, `sem`) VALUES
(1, '2015-2016', '1st'),
(2, '2015-2016', '2nd');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `ctr` int(11) NOT NULL AUTO_INCREMENT,
  `empid` text NOT NULL,
  `lname` text NOT NULL,
  `gname` text NOT NULL,
  `designation` text NOT NULL,
  `department` text NOT NULL,
  `datehired` text NOT NULL,
  `status` text NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`ctr`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`ctr`, `empid`, `lname`, `gname`, `designation`, `department`, `datehired`, `status`, `password`) VALUES
(2, '201206001', 'Valena', 'Jonald Ramos', 'ASSISTANT PROFESSOR 1', 'BUSINESS', '06/02/2012', 'ACTIVATE', 'password1010'),
(3, '201406004', 'Tarape', 'Bonifacio Valencia', 'ASSISTANT PROFESSOR 1', 'ACCOUNTANCY', '06/02/2013', 'ACTIVATE', 'password101'),
(4, '201406005', 'Sarmiento', 'Leo Cruz', 'ASSISTANT PROFESSOR 1', 'COMPUTER STUDIES', '06/01/2014', 'ACTIVATE', 'password101');

-- --------------------------------------------------------

--
-- Table structure for table `studentssubjtbl`
--

CREATE TABLE IF NOT EXISTS `studentssubjtbl` (
  `term` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `studentstbl`
--

CREATE TABLE IF NOT EXISTS `studentstbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idno` text NOT NULL,
  `lname` text NOT NULL,
  `gname` text NOT NULL,
  `sex` text NOT NULL,
  `civilstat` text NOT NULL,
  `citizenship` text NOT NULL,
  `occupation` text NOT NULL,
  `bdate` text NOT NULL,
  `bplace` text NOT NULL,
  `mobile` text NOT NULL,
  `email` text NOT NULL,
  `program` int(11) NOT NULL,
  `admissiontype` text NOT NULL,
  `yearofadmission` text NOT NULL,
  `admissionterm` text NOT NULL,
  `highschool` text NOT NULL,
  `address` text NOT NULL,
  `country` text NOT NULL,
  `awards` text NOT NULL,
  `inclusiveyears` text NOT NULL,
  `verifiedby` text NOT NULL,
  `recordcreatedon` text NOT NULL,
  `password` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE IF NOT EXISTS `superadmin` (
  `superadmin_ID` int(11) NOT NULL AUTO_INCREMENT,
  `superadmin_fname` text NOT NULL,
  `superadmin_mname` text NOT NULL,
  `superadmin_lname` text NOT NULL,
  `superadmin_empid` text NOT NULL,
  `superadmin_password` text NOT NULL,
  PRIMARY KEY (`superadmin_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`superadmin_ID`, `superadmin_fname`, `superadmin_mname`, `superadmin_lname`, `superadmin_empid`, `superadmin_password`) VALUES
(1, 'Super Admin', 'Super Admin', 'Super Admin', '201504002', 'password101');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` text NOT NULL,
  `mname` text NOT NULL,
  `lname` text NOT NULL,
  `empid` bigint(20) NOT NULL,
  `password` text NOT NULL,
  `department` text NOT NULL,
  `position` text NOT NULL,
  `datehired` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `mname`, `lname`, `empid`, `password`, `department`, `position`, `datehired`, `status`) VALUES
(3, 'Bonifacio', 'Valencia', 'Tarape', 201406004, 'password', 'ACCOUNTANCY', 'DEAN', '06/01/2014', 'ACTIVATED'),
(2, 'Jonald', 'Mones', 'Valena', 201206001, 'password', 'BUSINESS', 'DEAN', '06/01/2012', 'ACTIVATED'),
(4, 'Leo', 'Cruz', 'Sarmiento', 201406005, 'password', 'COMPUTER STUDIES', 'DEAN', '06/01/2014', 'ACTIVATED');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
