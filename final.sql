-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for esm
CREATE DATABASE IF NOT EXISTS `esm` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `esm`;

-- Dumping structure for table esm.class_point
CREATE TABLE IF NOT EXISTS `class_point` (
  `std_id` varchar(10) DEFAULT NULL,
  `std_year` varchar(4) DEFAULT NULL,
  `std_term` varchar(1) DEFAULT NULL,
  `s_code` varchar(10) DEFAULT NULL,
  `point` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.class_point: ~4 rows (approximately)
/*!40000 ALTER TABLE `class_point` DISABLE KEYS */;
INSERT INTO `class_point` (`std_id`, `std_year`, `std_term`, `s_code`, `point`) VALUES
	('6339010001', '2563', '1', '1001-1002', 50),
	('6339010005', '2563', '1', '1001-1002', 66),
	('6339010001', '2563', '2', '1001-1010', 80),
	('6339010005', '2563', '2', '1001-1010', 0);
/*!40000 ALTER TABLE `class_point` ENABLE KEYS */;

-- Dumping structure for table esm.class_schedule
CREATE TABLE IF NOT EXISTS `class_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `std_year` varchar(4) DEFAULT NULL,
  `std_term` int(1) DEFAULT NULL,
  `std_department` varchar(2) DEFAULT NULL,
  `std_room` varchar(2) DEFAULT NULL,
  `s_code` varchar(10) DEFAULT NULL,
  `class_start` time DEFAULT NULL,
  `class_end` time DEFAULT NULL,
  `day` varchar(10) DEFAULT NULL,
  `teacher` varchar(13) DEFAULT NULL,
  `std_level` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.class_schedule: ~2 rows (approximately)
/*!40000 ALTER TABLE `class_schedule` DISABLE KEYS */;
INSERT INTO `class_schedule` (`id`, `std_year`, `std_term`, `std_department`, `std_room`, `s_code`, `class_start`, `class_end`, `day`, `teacher`, `std_level`) VALUES
	(13, '2563', 1, '9', '01', '1001-1002', '18:53:00', '19:53:00', '6', '1000000000006', '3'),
	(14, '2563', 1, '9', '02', '1001-1002', '18:53:00', '20:53:00', '1', '1000000000006', '3'),
	(15, '2563', 2, '9', '01', '1001-1010', '19:39:00', '21:39:00', '1', '1000000000006', '3');
/*!40000 ALTER TABLE `class_schedule` ENABLE KEYS */;

-- Dumping structure for table esm.department
CREATE TABLE IF NOT EXISTS `department` (
  `std_department` varchar(2) NOT NULL DEFAULT '',
  `de_name` varchar(50) DEFAULT NULL,
  KEY `std_department` (`std_department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.department: ~3 rows (approximately)
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` (`std_department`, `de_name`) VALUES
	('9', 'เทคโนโลยีสารสนเทศ'),
	('2', 'คอมพิวเตอร์ธุรกิจ'),
	('1', 'ช่างกลโรงงาน');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;

-- Dumping structure for table esm.personal_info
CREATE TABLE IF NOT EXISTS `personal_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idcard` varchar(13) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birth` date DEFAULT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `nationality` varchar(30) DEFAULT NULL,
  `race` varchar(30) DEFAULT NULL,
  `religion` varchar(30) DEFAULT NULL,
  `weight` int(3) DEFAULT NULL,
  `height` int(3) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.personal_info: ~5 rows (approximately)
/*!40000 ALTER TABLE `personal_info` DISABLE KEYS */;
INSERT INTO `personal_info` (`id`, `idcard`, `gender`, `birth`, `blood_type`, `nationality`, `race`, `religion`, `weight`, `height`, `phone`) VALUES
	(31, '1000000000001', 'ชาย', '1999-09-09', 'O', 'ไทย', 'ไทย', 'พุทธ', 70, 180, '0123456789'),
	(32, '1000000000002', 'ชาย', '2000-10-10', 'A', 'ไทย', 'ไทย', 'พุทธ', 60, 175, '0123456789'),
	(33, '1000000000006', 'ชาย', '1999-09-09', 'AB', 'ไทย', 'ไทย', 'พุทธ', 50, 170, '0987654321'),
	(34, '1000000000008', 'ชาย', '1999-09-09', 'O', 'ไทย', 'ไทย', 'พุทธ', 80, 188, '0123456788'),
	(35, '1000000000010', 'ชาย', '2000-10-10', 'B', 'ไทย', 'ไทย', 'อิสลาม', 80, 180, '0123654852');
/*!40000 ALTER TABLE `personal_info` ENABLE KEYS */;

-- Dumping structure for table esm.student_info
CREATE TABLE IF NOT EXISTS `student_info` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idcard` varchar(13) NOT NULL,
  `std_id` varchar(10) NOT NULL,
  `std_year` varchar(4) NOT NULL DEFAULT '',
  `std_level` varchar(1) NOT NULL DEFAULT '',
  `std_department` varchar(2) NOT NULL DEFAULT '',
  `std_room` varchar(2) NOT NULL DEFAULT '',
  `std_number` varchar(4) NOT NULL DEFAULT '',
  `std_term` int(1) NOT NULL,
  `gpa_all` int(4) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'กำลังศึกษาอยู่',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.student_info: ~3 rows (approximately)
/*!40000 ALTER TABLE `student_info` DISABLE KEYS */;
INSERT INTO `student_info` (`id`, `idcard`, `std_id`, `std_year`, `std_level`, `std_department`, `std_room`, `std_number`, `std_term`, `gpa_all`, `status`) VALUES
	(31, '1000000000002', '6339010001', '2563', '3', '9', '01', '0001', 2, 0, 'กำลังศึกษาอยู่'),
	(32, '1000000000010', '6339010005', '2563', '3', '9', '01', '0005', 2, 0, 'กำลังศึกษาอยู่');
/*!40000 ALTER TABLE `student_info` ENABLE KEYS */;

-- Dumping structure for table esm.subject
CREATE TABLE IF NOT EXISTS `subject` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(50) NOT NULL,
  `s_code` varchar(10) NOT NULL,
  `credit` int(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.subject: ~5 rows (approximately)
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` (`id`, `s_name`, `s_code`, `credit`) VALUES
	(2, 'Java', '1001-1002', 2),
	(3, 'C, C++, C#', '1001-1001', 4),
	(5, 'Python', '1001-1003', 3),
	(6, 'Math', '1001-1004', 3),
	(8, 'Sci', '1001-1010', 3);
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;

-- Dumping structure for table esm.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `idcard` varchar(13) NOT NULL,
  `title` varchar(10) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `group_type` varchar(12) NOT NULL DEFAULT 'นักศึกษา',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table esm.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `idcard`, `title`, `firstname`, `lastname`, `group_type`) VALUES
	(36, '1000000000002', 'นาย', 'เอ', 'เอ', 'นักศึกษา'),
	(37, '1000000000006', 'นางสาว', 'ซี', 'ซี', 'ครู'),
	(38, '1000000000008', 'นาย', 'จี', 'จี', 'เจ้าหน้าที่'),
	(39, '1000000000010', 'นาย', 'ดี', 'ดี', 'นักศึกษา');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
