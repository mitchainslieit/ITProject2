-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bnhs
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.31-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `acc_id` int(13) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(100) NOT NULL,
  `acc_status` enum('Active','Deactivated','Denied') NOT NULL,
  `acc_type` enum('Admin','Faculty','Student','Parent','Treasurer') NOT NULL,
  `timestamp_acc` datetime NOT NULL,
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'benjieulep69','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Admin','0000-00-00 00:00:00'),(2,'chariparayno01','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(3,'kennethmarzan33','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Student','0000-00-00 00:00:00'),(4,'julinagaddi12','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Parent','0000-00-00 00:00:00'),(5,'domnimes23','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Treasurer','0000-00-00 00:00:00'),(6,'markcantero','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Student','0000-00-00 00:00:00'),(7,'denrichvillanos','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(8,'jkmaruku','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(9,'puritamanok','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(10,'amoxdrug','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(11,'pusoydos','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(12,'dubidap','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','0000-00-00 00:00:00'),(13,'Mark KennethPagarMarzan13','$2y$10$d1v1PKAA7JwqTsc56x8OtOujhYbNh6muuLYgii0rGTA7kF6JW2Bw.','Active','Faculty','0000-00-00 00:00:00'),(14,'jujubeat','$2y$10$d1v1PKAA7JwqTsc56x8OtOujhYbNh6muuLYgii0rGTA7kF6JW2Bw.','Active','Faculty','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admann`
--

DROP TABLE IF EXISTS `admann`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admann` (
  `adminn_id` int(11) NOT NULL,
  `annn_id` int(13) NOT NULL,
  PRIMARY KEY (`adminn_id`,`annn_id`),
  KEY `annn_id_idx` (`annn_id`),
  CONSTRAINT `adminn_id` FOREIGN KEY (`adminn_id`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `annn_id` FOREIGN KEY (`annn_id`) REFERENCES `announcements` (`ann_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admann`
--

LOCK TABLES `admann` WRITE;
/*!40000 ALTER TABLE `admann` DISABLE KEYS */;
INSERT INTO `admann` VALUES (1,1),(1,3);
/*!40000 ALTER TABLE `admann` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `adm_fname` varchar(45) NOT NULL,
  `adm_lname` varchar(45) NOT NULL,
  `adm_midname` varchar(45) NOT NULL,
  `acc_admid` int(13) NOT NULL,
  PRIMARY KEY (`admin_id`),
  KEY `acc_admid` (`acc_admid`),
  CONSTRAINT `acc_admid` FOREIGN KEY (`acc_admid`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Benjie','Ulep','Alonzo',1);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `ann_id` int(13) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) COLLATE utf8_bin NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `post` varchar(5000) COLLATE utf8_bin NOT NULL,
  `view_lim` enum('0','1','2','3') COLLATE utf8_bin NOT NULL,
  `attachment` varchar(100) COLLATE utf8_bin NOT NULL,
  `timestamp_ann` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_adminid` int(13) DEFAULT NULL,
  `post_facid` int(13) DEFAULT NULL,
  PRIMARY KEY (`ann_id`),
  KEY `post_adminid` (`post_adminid`),
  KEY `post_facid` (`post_facid`),
  CONSTRAINT `post_adminid` FOREIGN KEY (`post_adminid`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_facid` FOREIGN KEY (`post_facid`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Christmas Day','2019-12-25 12:00:00','2019-12-25 11:59:00','Merry Christmas Everyone!','0','','2019-06-25 02:30:15',1,NULL),(2,'Notes','2019-07-18 08:30:20','2019-07-26 08:30:00','Notes for discussion','2','','2019-07-18 00:30:20',NULL,1),(3,'No Classes','2019-08-01 12:00:00','2019-08-03 12:00:00','No Classes due to heavy storm. Please be updated.','0','','2019-08-01 03:30:12',1,NULL),(4,'Quiz','2019-08-09 11:30:12','2019-08-09 11:30:00','Quiz tomorrow! Please be reminded! Study Chapters 1 to 2 of your Book.','2','','2019-08-09 04:00:00',NULL,3);
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendance` (
  `att_id` int(13) NOT NULL AUTO_INCREMENT,
  `att_date` date NOT NULL,
  `remarks` enum('Late','Absent') COLLATE utf8_bin NOT NULL,
  `timestamp_att` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `stud_ida` int(13) NOT NULL,
  `fac_idb` int(13) NOT NULL,
  `subjatt_id` int(12) NOT NULL,
  PRIMARY KEY (`att_id`),
  KEY `fac_idb` (`fac_idb`),
  KEY `subjatt_id` (`subjatt_id`),
  KEY `stud_ida` (`stud_ida`),
  CONSTRAINT `fac_idb` FOREIGN KEY (`fac_idb`) REFERENCES `faculty` (`fac_id`) ON UPDATE CASCADE,
  CONSTRAINT `stud_ida` FOREIGN KEY (`stud_ida`) REFERENCES `student` (`stud_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `subjatt_id` FOREIGN KEY (`subjatt_id`) REFERENCES `subject` (`subj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'2019-09-12','Late','2019-09-12 03:10:00',1,1,34),(2,'2019-10-21','Absent','2019-10-20 16:00:00',1,4,9);
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balance` (
  `bal_id` int(13) NOT NULL AUTO_INCREMENT,
  `misc_fee` double NOT NULL,
  `bal_amt` double NOT NULL,
  `bal_status` enum('Cleared','Not Cleared') COLLATE utf8_bin NOT NULL,
  `stud_idb` int(13) NOT NULL,
  PRIMARY KEY (`bal_id`),
  KEY `stud_idb` (`stud_idb`),
  CONSTRAINT `stud_idb` FOREIGN KEY (`stud_idb`) REFERENCES `student` (`stud_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance`
--

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
INSERT INTO `balance` VALUES (1,1350,150,'Not Cleared',1),(2,1350,350,'Not Cleared',2);
/*!40000 ALTER TABLE `balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balpay`
--

DROP TABLE IF EXISTS `balpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `balpay` (
  `bal_ida` int(13) NOT NULL,
  `pay_ida` int(13) NOT NULL,
  PRIMARY KEY (`bal_ida`,`pay_ida`),
  KEY `pay_ida_idx` (`pay_ida`),
  CONSTRAINT `bal_ida` FOREIGN KEY (`bal_ida`) REFERENCES `balance` (`bal_id`) ON UPDATE CASCADE,
  CONSTRAINT `pay_ida` FOREIGN KEY (`pay_ida`) REFERENCES `payment` (`pay_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balpay`
--

LOCK TABLES `balpay` WRITE;
/*!40000 ALTER TABLE `balpay` DISABLE KEYS */;
INSERT INTO `balpay` VALUES (1,1),(1,2),(1,6),(1,7),(1,9),(1,10),(1,11),(1,15),(2,3),(2,4),(2,5),(2,8),(2,12),(2,13),(2,14),(2,16);
/*!40000 ALTER TABLE `balpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget_info`
--

DROP TABLE IF EXISTS `budget_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budget_info` (
  `budget_id` int(13) NOT NULL AUTO_INCREMENT,
  `budget_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `total_amount` double NOT NULL,
  `acc_amount` double NOT NULL,
  `timestamp_binfo` datetime NOT NULL,
  PRIMARY KEY (`budget_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget_info`
--

LOCK TABLES `budget_info` WRITE;
/*!40000 ALTER TABLE `budget_info` DISABLE KEYS */;
INSERT INTO `budget_info` VALUES (1,'PTA Fund',300,500,'2019-06-20 10:00:54'),(2,'Utility',300,475,'2019-06-20 10:01:02'),(3,'Internet for Students',250,450,'2019-06-20 10:02:54'),(4,'School Paper',150,300,'2019-06-20 10:03:54'),(5,'Organizations Fee',150,175,'2019-06-20 10:04:24'),(6,'TLE Fee',75,100,'2019-06-20 10:04:54'),(7,'SSG Fee',75,100,'2019-06-20 10:05:54'),(8,'Science Fee',50,100,'2019-06-20 10:06:54');
/*!40000 ALTER TABLE `budget_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facann`
--

DROP TABLE IF EXISTS `facann`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facann` (
  `fac_idb` int(13) NOT NULL,
  `ann_ida` int(13) NOT NULL,
  PRIMARY KEY (`fac_idb`,`ann_ida`),
  KEY `ann_ida_idx` (`ann_ida`),
  CONSTRAINT `ann_ida` FOREIGN KEY (`ann_ida`) REFERENCES `announcements` (`ann_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fa_idb` FOREIGN KEY (`fac_idb`) REFERENCES `faculty` (`fac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facann`
--

LOCK TABLES `facann` WRITE;
/*!40000 ALTER TABLE `facann` DISABLE KEYS */;
INSERT INTO `facann` VALUES (1,2);
/*!40000 ALTER TABLE `facann` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facsec`
--

DROP TABLE IF EXISTS `facsec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facsec` (
  `fac_idy` int(13) NOT NULL,
  `sec_idy` int(12) NOT NULL,
  PRIMARY KEY (`fac_idy`,`sec_idy`),
  KEY `sec_idy` (`sec_idy`),
  KEY `facc_idy` (`fac_idy`),
  CONSTRAINT `fac_idy` FOREIGN KEY (`fac_idy`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sec_idy` FOREIGN KEY (`sec_idy`) REFERENCES `section` (`sec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facsec`
--

LOCK TABLES `facsec` WRITE;
/*!40000 ALTER TABLE `facsec` DISABLE KEYS */;
INSERT INTO `facsec` VALUES (1,6),(1,7),(2,6),(2,7),(3,6),(3,7),(4,6),(4,7),(5,6),(5,7),(6,6),(6,7),(7,6),(7,7),(8,6),(8,7),(9,6),(9,7);
/*!40000 ALTER TABLE `facsec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty` (
  `fac_id` int(13) NOT NULL AUTO_INCREMENT,
  `fac_no` varchar(15) COLLATE utf8_bin NOT NULL,
  `fac_fname` varchar(45) COLLATE utf8_bin NOT NULL,
  `fac_lname` varchar(45) COLLATE utf8_bin NOT NULL,
  `fac_midname` varchar(45) COLLATE utf8_bin NOT NULL,
  `fac_dept` enum('Filipino','Math','MAPEH','Science','AP','English','TLE','Values') COLLATE utf8_bin NOT NULL,
  `fac_adviser` enum('Yes','No') COLLATE utf8_bin NOT NULL DEFAULT 'No',
  `timestamp_fac` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acc_idz` int(13) NOT NULL,
  PRIMARY KEY (`fac_id`),
  UNIQUE KEY `fac_no_UNIQUE` (`fac_no`),
  KEY `acc_idz` (`acc_idz`),
  CONSTRAINT `acc_idz` FOREIGN KEY (`acc_idz`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES (1,'1','Chari Anne','Parayno','B','Math','Yes','0000-00-00 00:00:00',2),(2,'2','Denden','Villanos','G','English','Yes','0000-00-00 00:00:00',7),(3,'3','John Kenneth','Maruku','A','Science','Yes','0000-00-00 00:00:00',8),(4,'4','Purita','Manok','G','Filipino','Yes','0000-00-00 00:00:00',9),(5,'5','Amoxcillin','Drug','N','AP','Yes','0000-00-00 00:00:00',10),(6,'6','Pusoy','Dos','T','TLE','Yes','0000-00-00 00:00:00',11),(7,'7','Dubi','Dapdap','N','Values','Yes','0000-00-00 00:00:00',12),(8,'8','Mark Kenneth','Marzan','Pagar','AP','Yes','0000-00-00 00:00:00',13),(9,'9','Juju','Beath','Onthe','MAPEH','Yes','2019-03-29 16:59:58',14);
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grades` (
  `grade_id` int(12) NOT NULL AUTO_INCREMENT,
  `grade` varchar(45) COLLATE utf8_bin NOT NULL,
  `grading` enum('1st','2nd','3rd','4th') COLLATE utf8_bin NOT NULL,
  `remarks` enum('Passed','Failed') COLLATE utf8_bin NOT NULL,
  `timestamp_grades` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `studd_id` int(12) NOT NULL,
  `facd_id` int(12) NOT NULL,
  `secd_id` int(12) NOT NULL,
  `subj_ide` int(12) NOT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `facd_id` (`facd_id`),
  KEY `subj_ide` (`subj_ide`),
  KEY `secd_id` (`secd_id`),
  KEY `studd_id` (`studd_id`),
  CONSTRAINT `facd_id` FOREIGN KEY (`facd_id`) REFERENCES `facsec` (`fac_idy`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `secd_id` FOREIGN KEY (`secd_id`) REFERENCES `section` (`sec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `studd_id` FOREIGN KEY (`studd_id`) REFERENCES `student` (`stud_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `subj_ide` FOREIGN KEY (`subj_ide`) REFERENCES `subject` (`subj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,'90','1st','Passed','0000-00-00 00:00:00',1,7,7,34),(2,'87','1st','Passed','0000-00-00 00:00:00',1,4,7,9),(3,'86','1st','Passed','0000-00-00 00:00:00',2,6,6,29),(4,'81','1st','Passed','0000-00-00 00:00:00',2,1,6,3),(5,'84','1st','Passed','0000-00-00 00:00:00',1,2,7,17),(6,'88','1st','Passed','0000-00-00 00:00:00',2,3,6,12),(7,'86','1st','Passed','2019-03-30 02:54:35',2,9,6,20);
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent` (
  `pr_id` int(11) NOT NULL AUTO_INCREMENT,
  `pr_fname` varchar(45) COLLATE utf8_bin NOT NULL,
  `pr_lname` varchar(45) COLLATE utf8_bin NOT NULL,
  `pr_midname` varchar(45) COLLATE utf8_bin NOT NULL,
  `pr_address` varchar(100) COLLATE utf8_bin NOT NULL,
  `timestamp_pr` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acc_idx` int(13) NOT NULL,
  `stude_id` int(13) NOT NULL,
  PRIMARY KEY (`pr_id`),
  KEY `acc_idx` (`acc_idx`),
  KEY `stude_id` (`stude_id`),
  CONSTRAINT `acc_idx` FOREIGN KEY (`acc_idx`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE,
  CONSTRAINT `stude_id` FOREIGN KEY (`stude_id`) REFERENCES `student` (`stud_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent`
--

LOCK TABLES `parent` WRITE;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
INSERT INTO `parent` VALUES (1,'Gaddi','Julina May','Jugo','Asin Baguio City ','0000-00-00 00:00:00',4,1),(2,'Nimes','Dom Christian Jay','Fernandez','Dagsian Baguio City','0000-00-00 00:00:00',5,2);
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `pay_id` int(12) NOT NULL AUTO_INCREMENT,
  `pay_amt` double NOT NULL,
  `remain_bal` double NOT NULL,
  `pay_date` datetime NOT NULL,
  `orno` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp_pm` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `balb_id` int(12) NOT NULL,
  `budg_ida` int(12) NOT NULL,
  PRIMARY KEY (`pay_id`),
  KEY `budg_ida` (`budg_ida`),
  KEY `balb_id` (`balb_id`),
  CONSTRAINT `balb_id` FOREIGN KEY (`balb_id`) REFERENCES `balance` (`bal_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `budg_ida` FOREIGN KEY (`budg_ida`) REFERENCES `budget_info` (`budget_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,300,1050,'2019-03-15 11:30:45','ABC1234','2019-03-15 03:30:45',1,1),(2,300,750,'2019-03-15 11:30:45','ABC1234','2019-03-15 03:30:45',1,2),(3,175,1175,'2019-03-25 01:23:15','DEF3456','2019-03-24 17:23:15',2,2),(4,75,1100,'2019-03-25 01:23:15','DEF3456','2019-03-24 17:23:15',2,5),(5,75,1025,'2019-03-25 01:23:15','DEF3456','2019-03-24 17:23:15',2,6),(6,250,500,'2019-06-23 09:30:10','TUG4928','2019-06-23 01:30:10',1,3),(7,100,400,'2019-06-23 09:30:10','TUG4928','2019-06-23 01:30:10',1,5),(8,200,825,'2019-06-24 10:30:15','JDI2348','2019-06-24 02:30:15',2,1),(9,50,350,'2019-07-15 11:00:12','UIA2306','2019-07-15 03:00:12',1,8),(10,25,325,'2019-07-15 11:00:12','UIA2306','2019-07-15 03:00:12',1,6),(11,25,300,'2019-07-15 11:00:12','UIA2306','2019-07-15 03:00:12',1,7),(12,200,625,'2019-07-25 03:30:00','MVK0921','2019-07-24 19:30:00',2,3),(13,150,475,'2019-07-25 03:30:00','MVK0921','2019-07-24 19:30:00',2,4),(14,50,425,'2019-07-25 03:30:00','MVK0921','2019-07-24 19:30:00',2,8),(15,150,150,'2019-08-07 09:10:24','QWE9781','2019-08-07 01:10:24',1,4),(16,75,350,'2019-08-11 01:30:11','NGH8472','2019-08-10 17:30:11',2,7);
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rank`
--

DROP TABLE IF EXISTS `rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rank` (
  `rank_id` int(12) NOT NULL AUTO_INCREMENT,
  `average` float NOT NULL,
  `rank` varchar(45) NOT NULL,
  `gr_level` enum('7','8','9','10') NOT NULL,
  `stud_idf` int(13) NOT NULL,
  PRIMARY KEY (`rank_id`),
  KEY `stud_idf_idx` (`stud_idf`),
  CONSTRAINT `stud_idf` FOREIGN KEY (`stud_idf`) REFERENCES `student` (`stud_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rank`
--

LOCK TABLES `rank` WRITE;
/*!40000 ALTER TABLE `rank` DISABLE KEYS */;
/*!40000 ALTER TABLE `rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedsubj`
--

DROP TABLE IF EXISTS `schedsubj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedsubj` (
  `schedsubja_id` int(12) NOT NULL,
  `schedsubjb_id` int(12) NOT NULL,
  `day` set('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `fw_id` int(12) NOT NULL,
  `sw_id` int(12) NOT NULL,
  `timestamp_ss` datetime NOT NULL,
  PRIMARY KEY (`schedsubja_id`,`schedsubjb_id`),
  KEY `schedsubjb_id_idx` (`schedsubjb_id`),
  KEY `fw_id` (`fw_id`),
  KEY `sw_id` (`sw_id`),
  KEY `schedsubja_id` (`schedsubja_id`),
  KEY `schedsubjb_id` (`schedsubjb_id`),
  CONSTRAINT `fw_id` FOREIGN KEY (`fw_id`) REFERENCES `facsec` (`fac_idy`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `schedsubja_id` FOREIGN KEY (`schedsubja_id`) REFERENCES `schedule` (`sched_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `schedsubjb_id` FOREIGN KEY (`schedsubjb_id`) REFERENCES `subject` (`subj_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sw_id` FOREIGN KEY (`sw_id`) REFERENCES `facsec` (`sec_idy`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedsubj`
--

LOCK TABLES `schedsubj` WRITE;
/*!40000 ALTER TABLE `schedsubj` DISABLE KEYS */;
INSERT INTO `schedsubj` VALUES (3,3,'Monday,Tuesday,Wednesday,Thursday,Friday','08:40:00','09:40:00',1,6,'0000-00-00 00:00:00'),(3,8,'Monday,Tuesday,Wednesday,Thursday,Friday','10:00:00','11:00:00',4,6,'0000-00-00 00:00:00'),(3,12,'Monday,Tuesday,Wednesday,Thursday,Friday','01:00:00','02:00:00',3,6,'0000-00-00 00:00:00'),(3,16,'Monday,Tuesday,Wednesday,Thursday,Friday','11:00:00','12:00:00',2,6,'0000-00-00 00:00:00'),(3,20,'Monday,Tuesday,Wednesday,Thursday,Friday','02:00:00','03:00:00',9,6,'0000-00-00 00:00:00'),(3,24,'Monday,Tuesday,Wednesday,Thursday,Friday','03:00:00','04:00:00',8,6,'0000-00-00 00:00:00'),(3,29,'Monday,Tuesday,Wednesday,Thursday,Friday','07:40:00','08:40:00',6,6,'0000-00-00 00:00:00'),(3,33,'Monday,Tuesday,Wednesday,Thursday,Friday','04:00:00','05:00:00',7,6,'0000-00-00 00:00:00'),(4,4,'Monday,Tuesday,Wednesday,Thursday,Friday','02:00:00','03:00:00',1,7,'0000-00-00 00:00:00'),(4,9,'Monday,Tuesday,Wednesday,Thursday,Friday','08:40:00','09:40:00',4,7,'0000-00-00 00:00:00'),(4,13,'Monday,Tuesday,Wednesday,Thursday,Friday','10:00:00','11:00:00',3,7,'0000-00-00 00:00:00'),(4,17,'Monday,Tuesday,Wednesday,Thursday,Friday','01:00:00','02:00:00',2,7,'0000-00-00 00:00:00'),(4,21,'Monday,Tuesday,Wednesday,Thursday,Friday','03:00:00','04:00:00',9,7,'0000-00-00 00:00:00'),(4,26,'Monday,Tuesday,Wednesday,Thursday,Friday','11:00:00','12:00:00',5,7,'0000-00-00 00:00:00'),(4,30,'Monday,Tuesday,Wednesday,Thursday,Friday','04:00:00','05:00:00',6,7,'0000-00-00 00:00:00'),(4,34,'Monday,Tuesday,Wednesday,Thursday,Friday','07:40:00','08:40:00',7,7,'0000-00-00 00:00:00');
/*!40000 ALTER TABLE `schedsubj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedule` (
  `sched_id` int(12) NOT NULL AUTO_INCREMENT,
  `sched_yrlevel` enum('7','8','9','10') COLLATE utf8_bin NOT NULL,
  `timestamp_sched` datetime NOT NULL,
  PRIMARY KEY (`sched_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
INSERT INTO `schedule` VALUES (1,'7','0000-00-00 00:00:00'),(2,'8','0000-00-00 00:00:00'),(3,'9','0000-00-00 00:00:00'),(4,'10','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `section` (
  `sec_id` int(12) NOT NULL AUTO_INCREMENT,
  `sec_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `sec_type` enum('A','B') COLLATE utf8_bin NOT NULL,
  `grade_lvl` enum('7','8','9','10') COLLATE utf8_bin NOT NULL,
  `timestamp_sec` datetime NOT NULL,
  `fac_idv` int(12) DEFAULT NULL,
  PRIMARY KEY (`sec_id`),
  KEY `fac_idv` (`fac_idv`),
  CONSTRAINT `fac_idv` FOREIGN KEY (`fac_idv`) REFERENCES `faculty` (`fac_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (1,'Hope','A','7','2019-03-29 07:27:30',1),(2,'Excellence','B','7','2019-03-29 07:28:30',2),(3,'Altruism','A','8','2019-03-29 07:28:55',3),(4,'Wisdom','B','8','2019-03-29 07:29:30',4),(5,'Dignity ','A','9','2019-03-29 07:30:30',5),(6,'Righteousness','B','9','2019-03-29 07:30:58',6),(7,'Freedom','A','10','2019-03-29 07:31:30',7),(8,'Independence','B','10','2019-03-29 07:32:30',8);
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `stud_id` int(12) NOT NULL AUTO_INCREMENT,
  `stud_lrno` bigint(13) NOT NULL,
  `last_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `first_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `middle_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `gender` enum('Male','Female') COLLATE utf8_bin NOT NULL,
  `year_level` enum('7','8','9','10') COLLATE utf8_bin NOT NULL,
  `school_year` year(4) NOT NULL,
  `guar_mobno` varchar(11) COLLATE utf8_bin DEFAULT NULL,
  `stud_address` varchar(100) COLLATE utf8_bin NOT NULL,
  `stud_bday` date NOT NULL,
  `guar_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `guar_telno` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `nationality` varchar(45) COLLATE utf8_bin NOT NULL,
  `ethnicity` varchar(45) COLLATE utf8_bin NOT NULL,
  `blood_type` enum('O','A','B','AB') COLLATE utf8_bin NOT NULL,
  `medical_stat` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `stud_status` enum('Officially Enrolled','Temporarily Enrolled','Not Enrolled','Graduated','Transferred') COLLATE utf8_bin NOT NULL,
  `curr_stat` enum('Old','New') COLLATE utf8_bin NOT NULL,
  `accc_id` int(13) NOT NULL,
  `secc_id` int(12) NOT NULL,
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `lr_no_UNIQUE` (`stud_lrno`),
  KEY `accc_id` (`accc_id`),
  KEY `secc_id` (`secc_id`),
  CONSTRAINT `accc_id` FOREIGN KEY (`accc_id`) REFERENCES `accounts` (`acc_id`) ON UPDATE CASCADE,
  CONSTRAINT `secc_id` FOREIGN KEY (`secc_id`) REFERENCES `section` (`sec_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,2019087065345,'Marzan','Mark Kenneth ','Pagar','Male','10',2019,NULL,'Queen of Peace Baguio City','1999-10-22',NULL,NULL,'Filipino','Tagalog','O','With Asthma, Skin Allergy','Officially Enrolled','Old',3,7),(2,2019087065675,'Cantero','Mark Israel','A','Male','9',2019,NULL,'Bakakeng Sur Baguio City','0000-00-00',NULL,NULL,'Filipino','Tagalog','O','None','Officially Enrolled','New',6,6);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subject` (
  `subj_id` int(12) NOT NULL AUTO_INCREMENT,
  `subjcode` varchar(45) COLLATE utf8_bin NOT NULL,
  `subj_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp_subj` datetime NOT NULL,
  PRIMARY KEY (`subj_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'MATH07','Algebra 1','0000-00-00 00:00:00'),(2,'MATH08','Algebra 2','0000-00-00 00:00:00'),(3,'MATH09','Geometry','0000-00-00 00:00:00'),(4,'MATH10 ','Calculus','0000-00-00 00:00:00'),(5,'MATH10','Trigonometry','0000-00-00 00:00:00'),(6,'FIL07','Filipino 1','0000-00-00 00:00:00'),(7,'FIL08','Filipino 2','0000-00-00 00:00:00'),(8,'FIL09','Filipino 3','0000-00-00 00:00:00'),(9,'FIL10','Filipino 4','0000-00-00 00:00:00'),(10,'SCI07','Integrated Science','0000-00-00 00:00:00'),(11,'SCI08','Biology','0000-00-00 00:00:00'),(12,'SCI09','Chemistry','0000-00-00 00:00:00'),(13,'SCI10','Physics','0000-00-00 00:00:00'),(14,'ENG07','English 1','0000-00-00 00:00:00'),(15,'ENG08','English 2','0000-00-00 00:00:00'),(16,'ENG09','English 3','0000-00-00 00:00:00'),(17,'ENG10','English 4','0000-00-00 00:00:00'),(18,'MAPEH07','MAPEH 1','0000-00-00 00:00:00'),(19,'MAPEH08','MAPEH 2','0000-00-00 00:00:00'),(20,'MAPEH09','MAPEH 3','0000-00-00 00:00:00'),(21,'MAPEH10','MAPEH 4','0000-00-00 00:00:00'),(22,'AP07','Phillipine History','0000-00-00 00:00:00'),(23,'AP08','Asian History','0000-00-00 00:00:00'),(24,'AP09','World History','0000-00-00 00:00:00'),(25,'AP09','Geography','0000-00-00 00:00:00'),(26,'AP10','Economics ','0000-00-00 00:00:00'),(27,'TLE07','TLE 1','0000-00-00 00:00:00'),(28,'TLE08','TLE 2','0000-00-00 00:00:00'),(29,'TLE09','TLE 3','0000-00-00 00:00:00'),(30,'TLE10','TLE 4','0000-00-00 00:00:00'),(31,'VAL07','Values 1','0000-00-00 00:00:00'),(32,'VAL08','Values 2','0000-00-00 00:00:00'),(33,'VAL09','Values 3','0000-00-00 00:00:00'),(34,'VAL10','Values 4','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-03-30 11:27:43
