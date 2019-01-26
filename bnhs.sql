-- MySQL dump 10.13  Distrib 8.0.13, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bnhs
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.37-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8 ;
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
 SET character_set_client = utf8mb4 ;
CREATE TABLE `accounts` (
  `acc_id` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `acc_status` varchar(45) DEFAULT NULL,
  `acc_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `announcements` (
  `ann_id` int(11) NOT NULL,
  `post` varchar(45) DEFAULT NULL,
  `post_date` varchar(45) DEFAULT NULL,
  `view_lim` varchar(45) DEFAULT NULL,
  `event_type` varchar(45) DEFAULT NULL,
  `attachment` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ann_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `attendance` (
  `att_id` int(11) NOT NULL,
  `att_date` varchar(45) DEFAULT NULL,
  `remarks` varchar(45) DEFAULT NULL,
  `stud_id` varchar(45) DEFAULT NULL,
  `fac_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`att_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balance`
--

DROP TABLE IF EXISTS `balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `balance` (
  `bal_id` int(11) NOT NULL,
  `bal_amt` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `bal_status` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `stud_id` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`bal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance`
--

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `balance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `balpay`
--

DROP TABLE IF EXISTS `balpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `balpay` (
  `bal_id` int(11) NOT NULL,
  `pay_id` varchar(45) DEFAULT NULL,
  `pr_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`bal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balpay`
--

LOCK TABLES `balpay` WRITE;
/*!40000 ALTER TABLE `balpay` DISABLE KEYS */;
/*!40000 ALTER TABLE `balpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget_info`
--

DROP TABLE IF EXISTS `budget_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `budget_info` (
  `budget_id` int(11) NOT NULL,
  `budget_name` varchar(45) DEFAULT NULL,
  `acc_amount` varchar(45) DEFAULT NULL,
  `bal_id` varchar(45) DEFAULT NULL,
  `pay_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`budget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget_info`
--

LOCK TABLES `budget_info` WRITE;
/*!40000 ALTER TABLE `budget_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `budget_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facsec`
--

DROP TABLE IF EXISTS `facsec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `facsec` (
  `fac_id` int(11) NOT NULL,
  `sec_id` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`fac_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facsec`
--

LOCK TABLES `facsec` WRITE;
/*!40000 ALTER TABLE `facsec` DISABLE KEYS */;
/*!40000 ALTER TABLE `facsec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faculty`
--

DROP TABLE IF EXISTS `faculty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `faculty` (
  `fac_id` int(11) NOT NULL,
  `fac_no` varchar(45) DEFAULT NULL,
  `fac_name` varchar(45) DEFAULT NULL,
  `fac_major` varchar(45) DEFAULT NULL,
  `fac_dept` varchar(45) DEFAULT NULL,
  `fac_adviser` varchar(45) DEFAULT NULL,
  `fac_pos` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`fac_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
/*!40000 ALTER TABLE `faculty` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `form` (
  `form_id` int(11) NOT NULL,
  `lr_no` varchar(45) DEFAULT NULL,
  `school_year` varchar(45) DEFAULT NULL,
  `stud_bday` varchar(45) DEFAULT NULL,
  `stud_sex` varchar(45) DEFAULT NULL,
  `stud_address` varchar(45) DEFAULT NULL,
  `stud_father` varchar(45) DEFAULT NULL,
  `stud_mother` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form`
--

LOCK TABLES `form` WRITE;
/*!40000 ALTER TABLE `form` DISABLE KEYS */;
/*!40000 ALTER TABLE `form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `grade` (
  `grade_id` int(11) NOT NULL,
  `grade` varchar(45) DEFAULT NULL,
  `grading` varchar(45) DEFAULT NULL,
  `remarks` varchar(45) DEFAULT NULL,
  `rec_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grade`
--

LOCK TABLES `grade` WRITE;
/*!40000 ALTER TABLE `grade` DISABLE KEYS */;
/*!40000 ALTER TABLE `grade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guardinfo`
--

DROP TABLE IF EXISTS `guardinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `guardinfo` (
  `form_id` int(11) NOT NULL,
  `guar_name` varchar(45) DEFAULT NULL,
  `guar_mobno` varchar(45) DEFAULT NULL,
  `guar_address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guardinfo`
--

LOCK TABLES `guardinfo` WRITE;
/*!40000 ALTER TABLE `guardinfo` DISABLE KEYS */;
/*!40000 ALTER TABLE `guardinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent`
--

DROP TABLE IF EXISTS `parent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `parent` (
  `pr_id` int(11) NOT NULL,
  `pr_name` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `school_year` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `pr_username` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `pr_password` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `pr_acctype` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `stud_id` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`pr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent`
--

LOCK TABLES `parent` WRITE;
/*!40000 ALTER TABLE `parent` DISABLE KEYS */;
/*!40000 ALTER TABLE `parent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `payment` (
  `pay_id` int(11) NOT NULL,
  `pay_amt` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `pay_date` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `orno` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `bal_id` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `record`
--

DROP TABLE IF EXISTS `record`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `record` (
  `rec_id` int(11) NOT NULL,
  `r_score` varchar(45) DEFAULT NULL,
  `total_item` varchar(45) DEFAULT NULL,
  `rec_type` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `record`
--

LOCK TABLES `record` WRITE;
/*!40000 ALTER TABLE `record` DISABLE KEYS */;
/*!40000 ALTER TABLE `record` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedsubj`
--

DROP TABLE IF EXISTS `schedsubj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `schedsubj` (
  `sched_id` int(11) NOT NULL,
  `subj_id` varchar(45) DEFAULT NULL,
  `day` varchar(45) DEFAULT NULL,
  `time` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sched_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedsubj`
--

LOCK TABLES `schedsubj` WRITE;
/*!40000 ALTER TABLE `schedsubj` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedsubj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `schedule` (
  `sched_id` int(11) NOT NULL,
  `sched_yrlevel` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sched_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedule`
--

LOCK TABLES `schedule` WRITE;
/*!40000 ALTER TABLE `schedule` DISABLE KEYS */;
/*!40000 ALTER TABLE `schedule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `section` (
  `sec_id` int(11) NOT NULL,
  `sec_name` varchar(45) DEFAULT NULL,
  `sec_num` varchar(45) DEFAULT NULL,
  `grade_lvl` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `student` (
  `sud_id` int(11) NOT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `year_level` varchar(45) DEFAULT NULL,
  `school_year` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `sec_id` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sud_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `subject` (
  `subj_id` int(11) NOT NULL,
  `subj` varchar(45) DEFAULT NULL,
  `code` varchar(45) DEFAULT NULL,
  `subj_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`subj_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
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

-- Dump completed on 2019-01-26 13:13:31
