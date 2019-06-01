-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: latest
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
  `acc_status` enum('Active','Deactivated') NOT NULL,
  `acc_type` enum('Admin','Faculty','Student','Parent','Treasurer') NOT NULL,
  `acc_details` enum('New','Old') NOT NULL DEFAULT 'New',
  `timestamp_acc` datetime NOT NULL,
  PRIMARY KEY (`acc_id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `accounts`
--

LOCK TABLES `accounts` WRITE;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'benjieulep69','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Admin','New','0000-00-00 00:00:00'),(2,'chariparayno01','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(3,'kennethmarzan33','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Student','New','0000-00-00 00:00:00'),(4,'julinagaddi12','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Parent','New','0000-00-00 00:00:00'),(5,'DFNime5','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Treasurer','New','0000-00-00 00:00:00'),(6,'markcantero','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Student','New','0000-00-00 00:00:00'),(7,'denrichvillanos','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(8,'jkmaruku','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(9,'puritamanok','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(10,'amoxdrug','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(11,'pusoydos','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(12,'dubidap','$2y$10$OJsocyOeEr8YtDSPMtlT2eJ.Eq.qvrtABuTJwH2EG9fmr9qbrm17W','Active','Faculty','New','0000-00-00 00:00:00'),(13,'Mark KennethPagarMarzan13','$2y$10$d1v1PKAA7JwqTsc56x8OtOujhYbNh6muuLYgii0rGTA7kF6JW2Bw.','Active','Faculty','New','0000-00-00 00:00:00'),(14,'jujubeat','$2y$10$d1v1PKAA7JwqTsc56x8OtOujhYbNh6muuLYgii0rGTA7kF6JW2Bw.','Active','Faculty','New','0000-00-00 00:00:00'),(15,'marzanjohndoe','$2y$10$d1v1PKAA7JwqTsc56x8OtOujhYbNh6muuLYgii0rGTA7kF6JW2Bw.','Active','Student','New','0000-00-00 00:00:00'),(16,'JMDou','$2y$10$m4eIT5AcTh1Lv5riGB/6QefxlpRAa9y/xYleVBdfjcJxT7/4PaFFa','Active','Parent','New','0000-00-00 00:00:00'),(17,'aaasd17','$2y$10$0K6iKmT3R.AUe2d.aEzTrORhhcKovw27sTvxu8JXzpJY3Dx0Va2mi','Active','Student','New','0000-00-00 00:00:00'),(18,'aaasdasdfasdfasdf18','$2y$10$q6ug3bAO6CBqZU.WmdyHJurc06vjGmuFXGsOKR0sNtPwfaWp.d12W','Active','Parent','New','0000-00-00 00:00:00'),(19,'aaasd19','$2y$10$He0enf9syi9pbBDDb2Hb8uHad76nj1nyvAK8GSb6JTNzB7AlQuxo2','Active','Student','New','0000-00-00 00:00:00'),(20,'asd20','$2y$10$4JS.A3zZ9SCFwlP5.yZkzeipUmT5CWKs7G7qTM.cBhC0kDOlwhpjK','Deactivated','Parent','New','0000-00-00 00:00:00'),(21,'asasd21','$2y$10$zj6.w06P4zCKDqxzTUWkK.DQNsNKxCp0f/Om5stwzj2j5HBV0ee/q','Active','Student','New','0000-00-00 00:00:00'),(22,'asd22','$2y$10$IQOEletNjrjllIKdzYZcMuRV0PRy73IJ9iNEVgYNvO4B5Ws3gF1de','Deactivated','Parent','New','0000-00-00 00:00:00'),(23,'aaasd23','$2y$10$H/39KQkUqSny2ua40dLxVe8tVyoKhH9Wkx6tdkWu/Jrbxjc1L1jpy','Active','Student','New','0000-00-00 00:00:00'),(24,'qdasd24','$2y$10$zFBP5Sknj80hXLvYT/dNi.hbqJ7kYJl6tUJEscsG0aVBkt0N2ty6q','Active','Parent','New','0000-00-00 00:00:00'),(25,'qaasd25','$2y$10$DfqIpPgZvSiQR1d8WdXgHuC1OfGWYMtD7o0AIhXj7JHsadVtV1MJ.','Active','Student','New','0000-00-00 00:00:00'),(26,'qdasd26','$2y$10$gyi/HAECHbVborwki8N92OfU0bzCdGps2UUPDIWdw1wnH7BNNT17K','Active','Parent','New','0000-00-00 00:00:00'),(27,'qaasd27','$2y$10$br99ELLkulbjLYjohEgNpesBfhOQTTQg07uHuWVgSikTGlW7OE/MW','Active','Student','New','0000-00-00 00:00:00'),(28,'qdasd28','$2y$10$IN/ivrg.7ca4CiV0HOodJOiPyKJ3t4tidqylsfDWA0AzgrBPfqM8q','Active','Parent','New','0000-00-00 00:00:00'),(29,'qaasd29','$2y$10$Pm3UKlunFyhH8wZ7Yq3hXuyHRRjxApmQ.sdCPfEec4kOVN4F0OESe','Active','Student','New','0000-00-00 00:00:00'),(30,'WROmgee','$2y$10$zh6ZdQkYS0SQgPiepAB.leKlt9CH.h1rGdsBDg.7YwOH32PTH89Mm','Active','Parent','New','0000-00-00 00:00:00'),(31,'PNRandom31','$2y$10$VALIRWNHUVipR6Cb1bzbUuW.xr.zIg2jEawEPrXQM7YbXBKST.3.e','Active','Student','New','0000-00-00 00:00:00'),(32,'aaasdads32','$2y$10$rJAAVNIhG0eKBYCucKj/U.pbTQOTMvr1PRXDCiTRXpnaJOqpY3MQ.','Active','Student','New','0000-00-00 00:00:00'),(33,'aaasdads33','$2y$10$8CjQwrMVgt0/LmoHAl8/MO.l6wYGktvutjxNiuh19LSa634824R.6','Active','Student','New','0000-00-00 00:00:00'),(34,'NIAnak34','$2y$10$4kb2aUJdUKoYraXLnBfr8.Vh/LeZ8X57IFA8TCjF0ViYqLzyuGPpO','Active','Student','New','0000-00-00 00:00:00'),(35,'MVGalatcha','$2y$10$JeWFaN9IxEOVcwl5/U388edcSKQTf.GpYMl.VJKkCDejk7J8S56.y','Active','Faculty','New','2019-04-16 08:05:23'),(36,'aaasd','$2y$10$uw8dL548RAaSxGRlqCxiN.2uiKukenzieJyILttXLXSa2Rf.mGnAa','Active','Faculty','New','2019-04-16 08:06:18'),(38,'SSSamp38','$2y$10$qJu83jQtkZxke2tmIE3pNO2Sc1bmAA.0r8jkHdnh7lezJYDqzKgB2','Active','Faculty','New','2019-04-16 09:06:27'),(39,'aaamp','$2y$10$ZtMNdRsoO7hiOFmw5LAKI.d3AXJOaYR0CZkcfzGjXeHjokhFLZvoe','Active','Faculty','New','2019-04-16 09:08:42'),(42,'sssa','$2y$10$mAXZQ7ORo7nazuUHw3J2sOqY821DXow1C1dyJ83myVgjZYuyrDuR2','Active','Faculty','New','2019-04-16 09:19:49'),(44,'AAApple44','$2y$10$/e6UVPakTQrTsZgTcoGNvez25ifN1R7rcIjgU70XimeB8Kw2JH1Ca','Active','Faculty','New','2019-04-16 09:24:01'),(48,'aaasdf','$2y$10$eD/xzF8dYWZ4Qn/JQjXUy.YcEjgYnfMKSWtkLWtRK1ltVNX2Q4HUS','Active','Faculty','New','2019-04-16 09:29:38'),(50,'rrr','$2y$10$24DOcJ.2s0bocKClzCYKQeseDyH2kx40j4XN.nAAn0vphcygTzeHi','Active','Faculty','New','2019-04-16 09:35:30'),(51,'sss51','$2y$10$uVCxvMzUKGlAA0deB32X1ezkNFjeZkrHVK5FYLmTSNWSlQAH.j1Vm','Active','Faculty','New','2019-04-16 09:37:24'),(52,'ddd','$2y$10$lhHqZKc77ShYmpEwXn8sZeOrixeu57CPLnNJjBG6ZAqfzUALh1Eau','Active','Faculty','New','2019-04-16 09:39:46'),(55,'ggg','$2y$10$dOTcq3udvp0lO1x6.Vt1Wedl/7ngg//i6BpSBDjs38RFoCcXAgslG','Active','Faculty','New','2019-04-16 09:42:36'),(61,'aaapp61','$2y$10$iw.7BY79T/tHiMYCQKdCUuNT1OkAvx0HVetY3GQ6Xa3xabG0VDoxu','Active','Faculty','New','2019-04-16 09:58:17'),(64,'ssssss64','$2y$10$UAQwG2OmerODcJoVam.kzO1O04SES1FZkS3guPmh8OcwtgU6PCnmi','Active','Faculty','New','2019-04-16 10:05:51'),(65,'ssssss65','$2y$10$.y9cVvSzMW6x6L/aWb5vbODYwHLMdjxHsf3gYId7yxhLYwZoEaTqS','Active','Faculty','New','2019-04-16 10:06:01'),(67,'bbb67','$2y$10$g9e5I7Lfe9.PiWvhSuRbIOPHSNzWvlNWHZO9NHzBY8gs4lcHu14QW','Active','Faculty','New','2019-04-16 10:11:54'),(68,'Arambulo68','$2y$10$tGDOUZa0YAWQRDrVT3G5uerN7u8JzMf/aZvW.eGSVIauiwRVaOFz.','Active','Parent','New','0000-00-00 00:00:00'),(69,'PSArambulo69','$2y$10$KcZFM9Uw1hrU/Lnjxb0GnOq.xgQ7pmHD3FzcYFxM54JB.P/5PRp9C','Active','Student','New','0000-00-00 00:00:00'),(70,'Beautiful70','$2y$10$4XDj8MWtTZlR6.COyDDDFu27xW96S.vvjoH1GVTpI5dU/jHl.PiAy','Active','Parent','New','0000-00-00 00:00:00'),(71,'HIRapisura71','$2y$10$AGuSG3pFKejgpnCphMcs1OSgSoMNshMN5MsMxQ4mW6RnIqj9xGoEG','Active','Student','New','0000-00-00 00:00:00'),(72,'AKConcepcion72','$2y$10$hxd0GV6G0hgGuROz1O59r.fqCD2z.qAgT/.ijjZTMdxaYqkMZgbBO','Active','Student','New','0000-00-00 00:00:00'),(73,'JPClave73','$2y$10$nFnh5zmXmur8/tZeNh9sfuo6IH7ESWm1MKQkw2lYIQZeQmVvJ8yBm','Active','Student','New','0000-00-00 00:00:00'),(74,'dddapat74','$2y$10$q6o0BeDc2EPZfzDmND.UK.lhmyVxtCOLopICH9ffajN9u71yjadN.','Active','Treasurer','New','2019-04-16 16:54:01'),(76,'AAApple76','$2y$10$nC2hy8mzX4PYxf5P0ABx4.gGm1n3XbxulPWH7EnNWX4WTZgOtOE0a','Active','Faculty','New','2019-04-16 16:58:31'),(77,'SSSe77','$2y$10$63EEPyHptXj8Sa8.xdVn1.3BGgCiiThM6m6Jh.BzN/MCA4L1Jq4ay','Active','Faculty','New','2019-04-16 16:59:18'),(78,'SSSe78','$2y$10$drUfJuz5fiGR6gT0fPOH3uGkhy3Qn4F3MpseMAwtX3.4d/c2ax8.u','Active','Faculty','New','2019-04-16 17:00:11'),(79,'aaae79','$2y$10$BOXVWTdQXo1qWKlA/1hGDeJtrOrF1JlBZ19PqMTW6jKf4ZP8HPRSa','Active','Faculty','New','2019-04-16 17:00:26'),(80,'SSSD80','$2y$10$6LEw.Vd/42JnjQlm/P4lDOZgr7Vayd8qLLP6eKruBLNtIEhZWG122','Active','Faculty','New','2019-04-16 17:01:16'),(81,'NNNGO81','$2y$10$N1R/cVsmxsnZmZDUKKmdaudmuutCKRfrXh/W5uktYR5CxCfyn3Wna','Active','Faculty','New','2019-04-16 17:02:04'),(82,'hhhindi82','$2y$10$cf5Hx5B3fEQXd.r/Zgt7g.nQk4x4NfRfimPPLn7CrTb/hPnf/eTpu','Active','Treasurer','New','2019-04-16 17:04:10'),(83,'FMLastname','$2y$10$JdDZLRICX6SHm55XwfuFxeEb6fGekLHVjQPuii4pRppU5DZNQzXGS','Active','Student','New','0000-00-00 00:00:00'),(84,'FMAnother84','$2y$10$WIewB297hcq/OeIkVQYW5Oor86/Y8vl36FkPG06uVM7QmFASvlJkC','Active','Student','New','0000-00-00 00:00:00'),(85,'MYKa85','$2y$10$vhu9nyvTK8U3bywnRpJKB.X9bW5OHNcGMMhFHNfRyvfG6l3va771y','Active','Student','New','0000-00-00 00:00:00'),(86,'BAGalatcha86','password','Active','Parent','New','0000-00-00 00:00:00'),(87,'JASiYaJr.87','$2y$10$OauD2f/PHRRxMQ/Wj902VuHObNw8snKyvFTf7vzdol/t49y6/4n3.','Deactivated','Student','New','0000-00-00 00:00:00'),(88,'MSApelyido88','$2y$10$6fWbyskF5M6cSWO1dKWyX.mmsjbZJlNjfs8n2h903Ku/Il514vszC','Active','Faculty','New','2019-04-18 07:52:08'),(89,'BBBenjie89','$2y$10$cUNryodDiYA85Kx1a8HAK.IHjztc4oMuSlXrBDvzfNlNfTHEyy/aO','Active','Faculty','New','2019-04-19 04:19:01'),(91,'LLMarzan91','$2y$10$K5BwOcs/AGvt2yyWt81bjOuzeGrJhZd/GhteU.InTKDY.5MpI7D4q','Active','Faculty','New','2019-04-21 06:25:40'),(95,'LLMarzan95','$2y$10$LF4ocdTOYuH7eN6FUXk1rOFASeUTvkeE65neNH6w7giiFG.AZ8oDi','Active','Faculty','New','2019-04-21 06:31:45'),(99,'LLMarzan99','$2y$10$lsBsmk3idLshVSFgV.GJeeMGXU1pAmZERlFtPumGbHDbl7CS9DQKC','Active','Faculty','New','2019-04-21 07:06:01'),(102,'domnimes23','$2y$10$l4zetrUR3sBWKDQHGa2hHOudSqQqM.5B9vBwJkF9QR.GQgoPR2qrO','Active','Parent','New','2019-04-21 07:19:59'),(121,'JMDoe121','$2y$10$igzVsSKPneHQ79s7bBEf9uyi6U79OX6KgGCC37Q5O.PVRLChN5EAy','Active','Faculty','New','2019-04-22 13:49:11'),(122,'JMDoe122','$2y$10$IREqFWb.LUu.8vxrtmvx.urvh0E/PiC9CjcGOagIYvO2Y8D857ltW','Active','Faculty','New','2019-04-22 13:49:59'),(123,' hsdk fhkajsdhfash kfhsadhf kadf hasdfkh aksd','$2y$10$YWqyt8VR5WzNUiaGH2PyWeChCJod0ojVB6eBppvHgnpSIb.0TNZRa','Active','Treasurer','New','2019-04-23 20:14:11');
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
  CONSTRAINT `annn_id` FOREIGN KEY (`annn_id`) REFERENCES `announcements` (`ann_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admann`
--

LOCK TABLES `admann` WRITE;
/*!40000 ALTER TABLE `admann` DISABLE KEYS */;
INSERT INTO `admann` VALUES (1,1);
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
  CONSTRAINT `acc_admid` FOREIGN KEY (`acc_admid`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `title` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `date_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `date_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post` varchar(5000) COLLATE utf8_bin DEFAULT NULL,
  `view_lim` set('0','1','2','3','4') COLLATE utf8_bin NOT NULL,
  `attachment` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `timestamp_ann` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `post_adminid` int(13) DEFAULT NULL,
  `post_facid` int(13) DEFAULT NULL,
  `gr_sec` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`ann_id`),
  KEY `post_adminid` (`post_adminid`),
  KEY `post_facid` (`post_facid`),
  CONSTRAINT `post_adminid` FOREIGN KEY (`post_adminid`) REFERENCES `admin` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_facid` FOREIGN KEY (`post_facid`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Christmas Day','2019-04-24 00:00:00','2019-04-20 00:00:00','Merry Christmas Everyone!','0','attachment_1.pdf','2019-04-23 16:31:49',1,NULL,''),(2,'Notes','2019-07-18 08:30:20','2019-07-26 08:30:00','Notes for discussionssssssss','2','organisational-alignment.docx','2019-04-22 09:48:45',NULL,1,''),(4,'Quiz','2019-08-09 11:30:12','2019-08-09 11:30:00','Quiz tomorrow! Please be reminded! Study Chapters 1 to 2 of your Book.','2','organisational-alignment.docx','2019-04-17 12:06:33',NULL,3,''),(67,'Holy Week','2019-01-04 00:00:00','2019-02-04 00:00:00','No Classes','0','attachment_67.docx','2019-04-23 16:39:07',1,NULL,NULL),(90,'Quiz','2019-08-09 11:30:12','2019-08-09 11:30:00','No classes tomorrow.','3',NULL,'2019-04-21 06:41:32',NULL,7,'7'),(95,'1123','1970-01-01 00:00:00','1970-01-01 00:00:00','Sample Announcements','3',NULL,'2019-04-23 11:42:12',NULL,1,'1'),(96,'s','1970-01-01 00:00:00','1970-01-01 00:00:00','TEsting Sample Announcement Again','3',NULL,'2019-04-23 17:07:16',NULL,1,'1'),(118,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','asd','3',NULL,'2019-04-23 17:17:35',NULL,1,'6'),(127,NULL,'0123-03-12 00:00:00','2312-02-13 00:00:00',NULL,'1',NULL,'2019-04-23 17:52:02',1,NULL,NULL),(128,NULL,'0123-03-12 00:00:00','2312-02-13 00:00:00',NULL,'1',NULL,'2019-04-23 17:52:45',1,NULL,NULL),(129,'ev','1970-01-02 00:00:00','1970-01-09 00:00:00',NULL,'2,4',NULL,'2019-04-23 17:54:23',1,NULL,NULL),(133,NULL,'1970-01-09 00:00:00','1970-01-09 00:00:00','Anns','2,3,4','attachment_133.torrent','2019-04-23 18:26:07',1,NULL,NULL);
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
  `stud_ida` int(12) NOT NULL,
  `fac_idb` int(13) NOT NULL,
  `subjatt_id` int(12) NOT NULL,
  PRIMARY KEY (`att_id`),
  KEY `fac_idb` (`fac_idb`),
  KEY `subjatt_id` (`subjatt_id`),
  KEY `stud_ida` (`stud_ida`),
  CONSTRAINT `fac_idb` FOREIGN KEY (`fac_idb`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stud_ida` FOREIGN KEY (`stud_ida`) REFERENCES `student` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subjatt_id` FOREIGN KEY (`subjatt_id`) REFERENCES `subject` (`subj_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
INSERT INTO `attendance` VALUES (1,'2019-09-12','Late','2019-09-12 03:10:00',1,1,34),(2,'2019-10-21','Absent','2019-10-20 16:00:00',2,4,9);
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
  `stud_idb` int(12) NOT NULL,
  PRIMARY KEY (`bal_id`),
  KEY `stud_idb` (`stud_idb`),
  CONSTRAINT `stud_idb` FOREIGN KEY (`stud_idb`) REFERENCES `student` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balance`
--

LOCK TABLES `balance` WRITE;
/*!40000 ALTER TABLE `balance` DISABLE KEYS */;
INSERT INTO `balance` VALUES (1,1350,0,'Cleared',1),(2,1350,0,'Cleared',2),(3,1350,0,'Cleared',3),(4,1350,0,'Cleared',4),(5,1350,1350,'Not Cleared',5),(6,1350,1330,'Not Cleared',6),(7,1350,1350,'Not Cleared',7),(8,1350,1350,'Not Cleared',8),(9,1350,1350,'Not Cleared',9),(10,1350,0,'Cleared',10),(11,1350,0,'Cleared',11),(12,1350,0,'Cleared',12),(13,1350,0,'Cleared',13),(15,1350,0,'Cleared',14),(16,1350,0,'Cleared',15),(17,1350,0,'Cleared',16),(18,1350,0,'Cleared',17),(19,1350,1050,'Not Cleared',18),(20,1350,1350,'Not Cleared',19);
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
  CONSTRAINT `pay_ida` FOREIGN KEY (`pay_ida`) REFERENCES `payment` (`pay_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `balpay`
--

LOCK TABLES `balpay` WRITE;
/*!40000 ALTER TABLE `balpay` DISABLE KEYS */;
INSERT INTO `balpay` VALUES (1,1),(1,2),(1,6),(1,7),(1,9),(1,10),(1,11),(1,15),(1,17),(1,21),(1,45),(1,46),(1,47),(2,3),(2,4),(2,5),(2,8),(2,12),(2,13),(2,14),(2,16),(2,48),(2,49),(2,50),(2,51),(2,52),(2,53),(3,18),(3,19),(3,55),(3,85),(3,86),(3,153),(3,154),(3,155),(3,156),(3,157),(3,158),(3,159),(4,20),(4,135),(4,136),(4,137),(4,138),(4,139),(4,140),(4,141),(4,142),(4,143),(6,22),(6,23),(10,170),(10,171),(10,172),(10,173),(10,174),(10,175),(10,176),(10,177),(11,43),(11,126),(11,127),(11,128),(11,129),(11,130),(11,131),(11,132),(11,133),(11,134),(12,42),(12,108),(12,109),(12,110),(12,111),(12,112),(12,113),(12,114),(12,115),(12,116),(13,35),(13,41),(13,83),(13,84),(13,87),(13,88),(13,89),(13,90),(13,91),(13,92),(13,93),(13,94),(13,95),(13,98),(13,99),(15,33),(15,38),(15,39),(15,40),(15,96),(15,97),(15,100),(15,101),(15,102),(15,103),(15,104),(15,105),(15,106),(15,107),(16,36),(16,117),(16,118),(16,119),(16,120),(16,121),(16,122),(16,123),(16,124),(16,125),(17,144),(17,145),(17,146),(17,147),(17,148),(17,149),(17,150),(17,151),(17,152),(18,160),(18,161),(18,162),(18,163),(18,164),(18,165),(18,166),(18,167),(18,168),(18,169),(19,178),(19,179),(19,180);
/*!40000 ALTER TABLE `balpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `behavior`
--

DROP TABLE IF EXISTS `behavior`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `behavior` (
  `bhv_id` int(12) NOT NULL AUTO_INCREMENT,
  `bhv_grading` enum('1st','2nd','3rd','4th') NOT NULL,
  `bhv_remarks` enum('AO','SO','RO','NO') NOT NULL,
  `timestamp_behavior` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `core_values` int(12) NOT NULL,
  `stud_idy` int(12) NOT NULL,
  `fac_idx` int(12) NOT NULL,
  `sec_idx` int(12) NOT NULL,
  PRIMARY KEY (`bhv_id`),
  KEY `stud_idy` (`stud_idy`),
  KEY `sec_idx` (`sec_idx`),
  KEY `fac_idx` (`fac_idx`),
  KEY `core_values_idx` (`core_values`),
  CONSTRAINT `core_values` FOREIGN KEY (`core_values`) REFERENCES `core_values` (`cv_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fac_idx` FOREIGN KEY (`fac_idx`) REFERENCES `facsec` (`fac_idy`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sec_idx` FOREIGN KEY (`sec_idx`) REFERENCES `facsec` (`sec_idy`) ON UPDATE CASCADE,
  CONSTRAINT `stud_idy` FOREIGN KEY (`stud_idy`) REFERENCES `student` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `behavior`
--

LOCK TABLES `behavior` WRITE;
/*!40000 ALTER TABLE `behavior` DISABLE KEYS */;
INSERT INTO `behavior` VALUES (1,'1st','AO','2019-04-24 05:44:27',1,1,7,7),(2,'1st','AO','2019-04-24 05:44:27',1,3,6,6),(3,'1st','SO','2019-04-24 05:44:27',2,1,7,7),(4,'1st','AO','2019-04-24 05:44:27',3,1,7,7),(5,'1st','RO','2019-04-24 05:44:27',4,1,7,7);
/*!40000 ALTER TABLE `behavior` ENABLE KEYS */;
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
  `total_amount` double NOT NULL DEFAULT '0',
  `acc_amount` double NOT NULL DEFAULT '0',
  `timestamp_binfo` datetime NOT NULL,
  PRIMARY KEY (`budget_id`),
  UNIQUE KEY `budget_name_UNIQUE` (`budget_name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget_info`
--

LOCK TABLES `budget_info` WRITE;
/*!40000 ALTER TABLE `budget_info` DISABLE KEYS */;
INSERT INTO `budget_info` VALUES (1,'PTA Fund',300,3760,'2019-06-20 10:00:54'),(2,'Utility',300,3710,'2019-06-20 10:01:02'),(3,'Internet for Students',250,3000,'2019-06-20 10:02:54'),(4,'School Paper',150,1800,'2019-06-20 10:03:54'),(5,'Organizations Fee',150,1800,'2019-06-20 10:04:24'),(6,'TLE Fee',75,890,'2019-06-20 10:04:54'),(7,'SSG Fee',75,900,'2019-06-20 10:05:54'),(8,'Science Fee',50,650,'2019-06-20 10:06:54');
/*!40000 ALTER TABLE `budget_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `core_values`
--

DROP TABLE IF EXISTS `core_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `core_values` (
  `cv_id` int(12) NOT NULL AUTO_INCREMENT,
  `cv_name` enum('Makatao','Makadiyos','Makakalikasan','Makabansa') NOT NULL,
  `timestamp_cv` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cv_id`),
  UNIQUE KEY `cv_name_UNIQUE` (`cv_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `core_values`
--

LOCK TABLES `core_values` WRITE;
/*!40000 ALTER TABLE `core_values` DISABLE KEYS */;
INSERT INTO `core_values` VALUES (1,'Makatao','2019-04-24 05:43:55'),(2,'Makadiyos','2019-04-24 05:43:55'),(3,'Makakalikasan','2019-04-24 05:43:55'),(4,'Makabansa','2019-04-24 05:43:55');
/*!40000 ALTER TABLE `core_values` ENABLE KEYS */;
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
  CONSTRAINT `ann_ida` FOREIGN KEY (`ann_ida`) REFERENCES `announcements` (`ann_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fa_idb` FOREIGN KEY (`fac_idb`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `fac_idy` int(12) NOT NULL,
  `sec_idy` int(12) NOT NULL,
  PRIMARY KEY (`fac_idy`,`sec_idy`),
  KEY `facc_idy` (`fac_idy`),
  KEY `sec_idy_idx` (`sec_idy`),
  CONSTRAINT `fac_idy` FOREIGN KEY (`fac_idy`) REFERENCES `schedsubj` (`fw_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sec_idy` FOREIGN KEY (`sec_idy`) REFERENCES `schedsubj` (`sw_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facsec`
--

LOCK TABLES `facsec` WRITE;
/*!40000 ALTER TABLE `facsec` DISABLE KEYS */;
INSERT INTO `facsec` VALUES (1,1),(1,5),(1,6),(1,7),(2,6),(2,7),(3,6),(3,7),(4,6),(4,7),(5,5),(5,6),(5,7),(6,6),(6,7),(7,6),(7,7),(8,6),(9,6),(9,7),(16,1),(20,1);
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
  `sec_privilege` enum('Yes','No') COLLATE utf8_bin NOT NULL DEFAULT 'No',
  `acc_idz` int(13) NOT NULL,
  PRIMARY KEY (`fac_id`),
  UNIQUE KEY `fac_no_UNIQUE` (`fac_no`),
  KEY `acc_idz` (`acc_idz`),
  CONSTRAINT `acc_idz` FOREIGN KEY (`acc_idz`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faculty`
--

LOCK TABLES `faculty` WRITE;
/*!40000 ALTER TABLE `faculty` DISABLE KEYS */;
INSERT INTO `faculty` VALUES (1,'1','Chari Anne','Parayno','B','Math','Yes','2019-04-21 05:22:27','Yes',2),(2,'2','Denden','Villanos','G','English','Yes','2019-04-17 08:47:51','No',7),(3,'3','John Kenneth','Maruku','A','Science','Yes','2019-04-20 02:09:59','No',8),(4,'4','Purita','Manok','G','Filipino','No','2019-04-08 17:48:16','No',9),(5,'5','Amoxcillin','Drug','N','AP','No','2019-04-08 17:48:16','No',10),(6,'6','Pusoy','Dos','T','TLE','Yes','2019-04-18 08:55:17','No',11),(7,'7','Dubi','Dapdap','N','Values','Yes','0000-00-00 00:00:00','No',12),(8,'8','Mark Kenneth','Marzan','Pagar','AP','No','2019-04-08 17:48:16','No',13),(9,'9','Juju','Beath','Onthe','MAPEH','No','2019-04-08 17:48:16','No',14),(10,'app','appleapp','app','app','Filipino','Yes','2019-04-16 01:59:49','No',61),(12,'ss','ss','ssss','sss','Math','Yes','2019-04-16 14:14:52','No',64),(14,'s','s','s','s','MAPEH','No','2019-04-16 14:14:52','No',51),(15,'b','b','b','b','Math','No','2019-04-16 14:14:52','No',67),(16,'12312','Apple','Apple','Apple','AP','Yes','2019-04-21 05:33:12','No',44),(18,'Se','Se','Se','Se','Math','Yes','2019-04-16 08:59:18','No',77),(20,'ae','ae','ae','ae','MAPEH','Yes','2019-04-16 09:00:26','No',79),(21,'SD','SD','SD','SD','Filipino','Yes','2019-04-16 09:01:16','No',80),(22,'89','NGO','NGO','NGO','Science','Yes','2019-04-16 09:02:04','No',81),(23,'161827368`','Marzan','Apelyido','Sample','MAPEH','Yes','2019-04-18 06:31:47','No',88),(24,'12681','Benjie','Benjie','Benjie','Math','Yes','2019-04-20 06:58:07','No',89),(27,'79','John ','Doe','Mid','Filipino','Yes','2019-04-22 05:49:59','No',122);
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
  `grade` int(11) DEFAULT NULL,
  `grading` enum('1st','2nd','3rd','4th') COLLATE utf8_bin NOT NULL,
  `remarks` varchar(100) COLLATE utf8_bin NOT NULL,
  `timestamp_grades` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `studd_id` int(12) NOT NULL,
  `facd_id` int(12) NOT NULL,
  `secd_id` int(12) NOT NULL,
  `subj_ide` int(12) NOT NULL,
  PRIMARY KEY (`grade_id`),
  KEY `facd_id` (`facd_id`),
  KEY `subj_ide` (`subj_ide`),
  KEY `studd_id` (`studd_id`),
  KEY `secd_id_idx` (`secd_id`),
  CONSTRAINT `facd_id` FOREIGN KEY (`facd_id`) REFERENCES `facsec` (`fac_idy`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `secd_id` FOREIGN KEY (`secd_id`) REFERENCES `facsec` (`sec_idy`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `studd_id` FOREIGN KEY (`studd_id`) REFERENCES `student` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `subj_ide` FOREIGN KEY (`subj_ide`) REFERENCES `subject` (`subj_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grades`
--

LOCK TABLES `grades` WRITE;
/*!40000 ALTER TABLE `grades` DISABLE KEYS */;
INSERT INTO `grades` VALUES (1,90,'1st','Passed','0000-00-00 00:00:00',1,7,7,34),(2,87,'1st','Passed','0000-00-00 00:00:00',1,4,7,9),(3,86,'1st','Passed','0000-00-00 00:00:00',2,6,6,29),(5,84,'1st','Passed','0000-00-00 00:00:00',1,2,7,17),(6,88,'1st','Passed','0000-00-00 00:00:00',2,3,6,12),(7,86,'1st','Passed','2019-03-30 02:54:35',2,9,6,20),(8,87,'1st','Passed','2019-03-30 02:54:35',3,6,6,29),(9,90,'1st','Passed','2019-03-30 02:54:35',3,3,6,12),(10,89,'2nd','Passed','0000-00-00 00:00:00',1,7,7,34),(11,87,'3rd','Passed','0000-00-00 00:00:00',1,7,7,34),(12,87,'4th','Passed','0000-00-00 00:00:00',1,7,7,34),(13,65,'2nd','Failed','0000-00-00 00:00:00',1,4,7,9),(14,65,'3rd','Failed','0000-00-00 00:00:00',1,4,7,9),(15,65,'2nd','Failed','0000-00-00 00:00:00',1,2,7,17),(16,65,'3rd','Failed','0000-00-00 00:00:00',1,2,7,17),(17,65,'4th','Failed','0000-00-00 00:00:00',1,2,7,17);
/*!40000 ALTER TABLE `grades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guardian`
--

DROP TABLE IF EXISTS `guardian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guardian` (
  `guar_id` int(11) NOT NULL AUTO_INCREMENT,
  `guar_fname` varchar(45) COLLATE utf8_bin NOT NULL,
  `guar_lname` varchar(45) COLLATE utf8_bin NOT NULL,
  `guar_midname` varchar(45) COLLATE utf8_bin NOT NULL,
  `guar_address` varchar(100) COLLATE utf8_bin NOT NULL,
  `guar_mobno` varchar(11) COLLATE utf8_bin NOT NULL,
  `guar_telno` varchar(11) COLLATE utf8_bin DEFAULT NULL,
  `timestamp_guar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `acc_idx` int(13) NOT NULL,
  PRIMARY KEY (`guar_id`),
  KEY `acc_idx` (`acc_idx`),
  CONSTRAINT `acc_idx` FOREIGN KEY (`acc_idx`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guardian`
--

LOCK TABLES `guardian` WRITE;
/*!40000 ALTER TABLE `guardian` DISABLE KEYS */;
INSERT INTO `guardian` VALUES (1,'Julina May','Gaddi','Jugo','Asin Baguio City ','00000000000',NULL,'2019-04-10 05:31:17',4),(2,'Dom Christian Jay','Nime','Fernandez','Dagsian Baguio City','00000000000','123','2019-04-21 05:42:47',102),(3,'John','Dou','Maria','asd, asd, asd 2222','00000000000','','2019-04-17 06:56:07',16),(4,'asdfasdfasdf','asdasdfasdfasdf','asd','asd, asd, asd asd','22222222222','','2019-04-21 10:12:12',18),(5,'asd','asd','asd','asd, asd, asd 2222','11111111111','','2019-04-13 08:10:04',20),(6,'asd','asd','asd','asd, asd, asd11 2222','22232323232','','2019-04-13 08:11:52',22),(7,'asdads','qdasd','ads','asdads, adsd, asd 2222','22222222222','','2019-04-13 08:17:42',24),(8,'asdads','qdasd','ads','asdads, adsd, asd 2222','22222222222','','2019-04-13 08:18:09',26),(9,'asdads','qdasd','ads','asdads, adsd, asd 2222','22222222222','','2019-04-13 08:20:37',28),(10,'Wowie','Omgee','Really','Sparta, Omg, Wow 2222','30303030303','','2019-04-17 06:59:02',30),(11,'Samp','Samp','Samp','Samp Address','',NULL,'2019-04-16 07:33:33',38),(12,'CJ','Arambulo','Rambo','Hindekoalam, Domincan, Baguio City 2600','00000000000','','2019-04-16 13:25:15',68),(13,'She','Beautiful','Is','I wish, I know, Baguio City 2600','21123132213','','2019-04-16 13:28:15',70),(14,'dapat','dapat','dapat','dapat','',NULL,'2019-04-16 14:54:03',74),(15,'hindi','hindi','hindi','hindi address','',NULL,'2019-04-16 15:04:12',82),(16,'Berna','Galatcha','A','Street, Barangay, City 2600','11223213321','','2019-04-17 07:45:32',86);
/*!40000 ALTER TABLE `guardian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `log_id` int(12) NOT NULL AUTO_INCREMENT,
  `log_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `log_event` enum('Insert','Update','Delete','Reset') NOT NULL,
  `log_desc` varchar(300) NOT NULL,
  `user_id` int(13) NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=447 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (180,'2019-04-21 14:00:50','Insert','Added Fee Type Boy/Girl Scout with amount of &#8369;200.00',1),(181,'2019-04-21 14:01:10','Update','Updated Fee Type Scout Fee with amount of &#8369;200.00',1),(182,'2019-04-21 14:01:21','Update','Updated Fee Type Internet for Students with amount of &#8369;250.00',1),(183,'2019-04-21 14:40:39','Update','Updated account status of  to ',1),(184,'2019-04-21 14:40:40','Update','Updated account status of pta pta pta to Deactivated',1),(185,'2019-04-21 14:41:14','Update','Updated account status of asd asd asd to Active',1),(186,'2019-04-21 14:41:14','Update','Updated account status of  to ',1),(187,'2019-04-21 14:43:04','Update','Updated account status of asd asd asd to Deactivated',1),(188,'2019-04-21 14:43:04','Update','Updated account status of  to ',1),(189,'2019-04-21 14:43:45','Update','Updated account status of asd asd asd to Active',1),(190,'2019-04-21 14:43:45','Update','Updated account status of  to ',1),(191,'2019-04-21 14:45:21','Update','Updated account status of asd asd asd to Deactivated',1),(192,'2019-04-21 14:49:50','Update','Updated account status of Jonel Abugbug Si Ya Jr. to Deactivated',1),(193,'2019-04-21 14:56:10','Insert','Added announcement with a Title: Marzan, Description',1),(194,'2019-04-21 15:09:59','Update','Updated announcement with the following details(Title: 1234123, Description: adsssdssdsda, Date Start: , Date End: , Attachment: Array',1),(195,'2019-04-21 15:10:54','Update','Updated announcement with the following details(Title: 1234123, Description: adsssdssdsda, Date Start: 0000-00-00 00:00:00, Date End: 0000-00-00 00:00',1),(196,'2019-04-21 15:11:55','Update','Updated announcement with the following details(Title: 1234123, Description: adsssdssdsda, Date Start: , Date End: , Attachment: Array',1),(197,'2019-04-21 15:13:44','Update','Updated announcement with the following details(Title: 123412313, Description: adsssdssdsda, Date Start: 0000-00-00 00:00:00, Date End: 0000-00-00 00:',1),(198,'2019-04-21 15:14:51','Update','Updated announcement with the following details(Title: 123412313, Description: mmk\r\n, Date Start: 0000-00-00 00:00:00, Date End: 0000-00-00 00:00:00, ',1),(199,'2019-04-21 15:15:19','Update','Updated announcement with the following details(Title: 123412313, Description: mmk\r\n, Date Start: 0000-00-00 00:00:00, Date End: 0000-00-00 00:00:00, ',1),(200,'2019-04-21 15:16:00','Update','Updated announcement with the following details(Title: 123412313, Description: mmk\r\nk\r\n, Date Start: 0000-00-00 00:00:00, Date End: 0000-00-00 00:00:00, Attachment: attachment_91.docx',1),(201,'2019-04-21 15:17:09','Update','Updated announcement with the following details(Title: a, Description: , Date Start: 1231-03-12 00:00:00, Date End: 1229-03-12 00:00:00, Attachment: attachment_89.torrent',1),(202,'2019-04-21 15:19:42','Delete','Deleted announcement , Description: ',1),(203,'2019-04-21 15:20:31','Delete','Deleted announcement , Description: ',1),(204,'2019-04-21 15:22:35','Delete','Deleted announcement , Description: ',1),(205,'2019-04-21 15:22:47','Delete','Deleted announcement , Description: ',1),(206,'2019-04-21 15:23:27','Delete','Deleted announcement , Description: ',1),(207,'2019-04-21 15:23:35','Delete','Deleted announcement , Description: ',1),(208,'2019-04-21 15:23:35','Delete','Deleted announcement , Description: ',1),(209,'2019-04-21 15:24:05','Delete','Deleted announcement , Description: ',1),(210,'2019-04-21 15:24:11','Delete','Deleted announcement Julina, Description: ',1),(211,'2019-04-21 15:25:35','Insert','Added Fee Type fee type with amount of &#8369;50.00',1),(212,'2019-04-21 15:25:53','Delete','Deleted Fee Type fee type',1),(213,'2019-04-21 15:26:08','Delete','Deleted Fee Type Scout Fee',1),(214,'2019-04-21 15:28:42','Insert','Added Fee Type AAAAAAA with amount of &#8369;50.00',1),(215,'2019-04-21 15:39:55','Insert','Added Section Sample Sa Alert ni Marzan',1),(216,'2019-04-21 09:42:22','Update','Enrolled an old student.',2),(217,'2019-04-21 15:45:07','Insert','Added ae ae ae as an adviser in Grade: 9, Section: Sample Sa Alert ni Marzan',1),(218,'2019-04-21 15:52:17','Insert','Added Section Sample Sa Alert ni Marzan',1),(219,'2019-04-21 15:52:26','Insert','Added ae ae ae as an adviser in Grade: 7, Section: Sample Sa Alert ni Marzan',1),(220,'2019-04-21 15:57:11','Insert','Added Section alert section',1),(221,'2019-04-21 15:57:26','Insert','Added ae ae ae as an adviser in Grade: 7, Section: alert section',1),(222,'2019-04-21 15:58:31','Update','Updated SD SD SD as an adviser in Grade: 7, Section: alert section',1),(223,'2019-04-21 16:01:08','Delete','Deleted Section alert section',1),(224,'2019-04-21 16:01:32','Insert','Added Section alert alert',1),(225,'2019-04-21 16:01:54','Insert','Added Section s',1),(226,'2019-04-21 16:04:03','Delete','Deleted Section alert alert',1),(227,'2019-04-21 16:04:08','Delete','Deleted Section s',1),(228,'2019-04-21 16:04:18','Insert','Added Section a',1),(229,'2019-04-21 16:06:03','Delete','Deleted Section a',1),(230,'2019-04-21 16:06:19','Insert','Added Section a',1),(231,'2019-04-21 16:07:24','Delete','Deleted Section a',1),(232,'2019-04-21 16:07:43','Insert','Added Section a',1),(233,'2019-04-21 16:08:07','Delete','Deleted Section a',1),(234,'2019-04-21 16:08:13','Insert','Added Section a',1),(235,'2019-04-21 16:08:54','Delete','Deleted Section a',1),(236,'2019-04-21 16:09:00','Insert','Added Section a',1),(237,'2019-04-21 16:09:45','Delete','Deleted Section a',1),(238,'2019-04-21 16:09:53','Insert','Added Section a',1),(239,'2019-04-21 16:12:09','Insert','Added Section a',1),(240,'2019-04-21 16:12:25','Insert','Added Section a',1),(241,'2019-04-21 16:12:50','Insert','Added Section a',1),(242,'2019-04-21 16:14:05','Delete','Deleted Section a',1),(243,'2019-04-21 16:14:11','Delete','Deleted Section a',1),(244,'2019-04-21 16:14:18','Delete','Deleted Section a',1),(245,'2019-04-21 16:14:22','Delete','Deleted Section a',1),(246,'2019-04-21 16:14:49','Insert','Added Section a',1),(247,'2019-04-21 16:29:09','Delete','Deleted Fee Type AAAAAAA',1),(248,'2019-04-21 16:31:37','Update','Updated Section a to ba',1),(249,'2019-04-21 16:31:44','Delete','Deleted Section ba',1),(250,'2019-04-21 16:36:36','Insert','Added Section a',1),(251,'2019-04-21 16:36:48','Insert','Added Benjie Benjie Benjie as an adviser in Grade: 7, Section: a',1),(252,'2019-04-21 16:37:43','Delete','Deleted Section a',1),(253,'2019-04-21 16:42:25','Insert','Added Subject a',1),(254,'2019-04-21 16:44:25','Insert','Added Fee Type FEE TYPE with amount of &#8369;100.00',1),(255,'2019-04-21 16:45:50','Delete','Deleted Fee Type FEE TYPE',1),(256,'2019-04-21 16:48:58','Insert','Added Fee Type FEE with amount of &#8369;200.00',1),(257,'2019-04-21 16:49:08','Update','Updated Fee Type FEE with amount of &#8369;100.00',1),(258,'2019-04-21 16:58:04','Update','Updated account status of Chari Anne B Parayno to Deactivated',1),(259,'2019-04-21 16:59:59','Update','Updated account status of Chari Anne B Parayno to Deactivated',1),(260,'2019-04-21 17:07:24','Delete','Deleted Fee Type FEE',1),(261,'2019-04-21 17:08:22','Insert','Added Fee Type FEE with amount of &#8369;100.00',1),(262,'2019-04-21 17:08:30','Delete','Deleted Fee Type FEE',1),(263,'2019-04-21 21:58:49','Insert','Added a schedule.',2),(264,'2019-04-22 09:30:47','','Deleted the account of pta pta pta',1),(265,'2019-04-22 09:38:03','Update','Updated account status of asd asd asd to Deactivated',1),(266,'2019-04-22 09:48:45','Update','Updated announcement with the following details(Title: Notes, Description: Notes for discussionssssssss, Date Start: 2019-07-18 08:30:20, Date End: 2019-07-26 08:30:00, Attachment: organisational-alignment.docx',1),(267,'2019-04-22 10:05:56','Insert','Added announcement with a Title: julina, Description: ',1),(268,'2019-04-22 10:06:18','Insert','Added announcement with a Title: julina, Description: ',1),(269,'2019-04-22 10:06:39','Delete','Deleted announcement julina, Description: ',1),(270,'2019-04-22 10:07:45','Delete','Deleted announcement , Description: ',1),(271,'2019-04-22 10:54:29','Insert','Added Section a',1),(272,'2019-04-22 10:55:33','Delete','Deleted Section a',1),(273,'2019-04-22 10:55:45','Insert','Added Section a',1),(274,'2019-04-22 10:56:15','Delete','Deleted Section a',1),(275,'2019-04-22 11:03:44','Insert','Added Section a',1),(276,'2019-04-22 11:04:04','Delete','Deleted Section a',1),(277,'2019-04-22 11:04:10','Insert','Added Section a',1),(278,'2019-04-22 11:04:48','Delete','Deleted Section a',1),(279,'2019-04-22 11:04:55','Insert','Added Section a',1),(280,'2019-04-22 11:06:53','Delete','Deleted Section a',1),(281,'2019-04-22 11:07:00','Insert','Added Section a',1),(282,'2019-04-22 11:07:22','Delete','Deleted Section a',1),(283,'2019-04-22 11:07:29','Insert','Added Section a',1),(284,'2019-04-22 11:41:53','Delete','Deleted Section a',1),(285,'2019-04-22 11:42:23','Insert','Added Section a',1),(286,'2019-04-22 11:43:17','Insert','Added an account of faculty member John Mid Doe',1),(287,'2019-04-22 11:49:24','Delete','Deleted the account of John Mid Doe',1),(288,'2019-04-22 11:50:02','Insert','Added an account of faculty member John  Mid Doe',1),(289,'2019-04-22 13:04:16','Update','Updated announcement with the following details(Title: Marzan, Description: , Date Start: March 23, 1121, Date End: march 26, 0231, Attachment: ',1),(290,'2019-04-22 13:04:43','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: April 16, 2019, Date End: April 20, 2019, Attachment: ',1),(291,'2019-04-22 13:15:32','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: 2019-04-24, Date End: 2019-04-27, Attachment: ',1),(292,'2019-04-22 13:19:08','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: April 25, 2019, Date End: April 27, 2019, Attachment: ',1),(293,'2019-04-22 07:22:03','Update','Updated the details of Jonel Abugbug Si Ya Jr.',2),(294,'2019-04-22 07:22:32','Update','Updated the details of Jonel Abugbug Si Ya Jr.',2),(295,'2019-04-22 13:22:36','Update','Updated announcement with the following details(Title: Christmas Day, Description: Merry Christmas Everyone!, Date Start: 2019-04-24, Date End: 2019-04-20, Attachment: organisational-alignment.docx',1),(296,'2019-04-22 07:24:08','Update','Updated the details of Jonel Abugbug Si Ya Jr.',2),(297,'2019-04-22 07:24:42','Update','Updated the details of Jonel Abugbug Si Ya Jr.',2),(298,'2019-04-22 07:25:19','Update','Updated the details of Alezzandra Khyra Concepcion',2),(299,'2019-04-22 07:45:05','Insert','Added a schedule.',2),(300,'2019-04-22 13:53:21','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: 1970-01-07, Date End: 1970-01-01, Attachment: ',1),(301,'2019-04-22 13:55:00','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: 2019-01-04, Date End: 2019-02-04, Attachment: ',1),(302,'2019-04-22 15:27:47','Insert','Added Section Samp',1),(303,'2019-04-22 15:27:54','Delete','Deleted Section a',1),(304,'2019-04-22 16:24:37','Insert','Added announcement with a Title: Revision, Description: ',1),(305,'2019-04-22 16:25:25','Update','Updated announcement with the following details(Title: 1123, Description: Sample Announcements, Date Start: 1970-01-01, Date End: 1970-01-01, Attachment: ',1),(306,'2019-04-22 16:26:39','Update','Updated announcement with the following details(Title: s, Description: Sample Announcement Again, Date Start: 1970-01-01, Date End: 1970-01-01, Attachment: ',1),(307,'2019-04-22 16:26:55','Insert','Added announcement with a Title: s, Description: ',1),(308,'2019-04-23 12:38:22','Insert','Added announcement with a Title: Samp, Description: ',1),(309,'2019-04-23 13:41:05','Insert','Added Subject aaaa',1),(310,'2019-04-23 13:41:35','Insert','Added Subject bbb',1),(311,'2019-04-23 13:42:39','Update','Updated Subject bbb to cccc',1),(312,'2019-04-23 13:51:17','Insert','Added announcement with a Title: , Description: Pakidownload',1),(313,'2019-04-23 14:00:57','Insert','Added announcement with a Title: , Description: Walang file',1),(314,'2019-04-23 15:33:18','Insert','Added announcement with a Title: , Description: For announcements',1),(315,'2019-04-23 09:33:42','Insert','Delete an announcement',2),(316,'2019-04-23 09:34:18','Insert','Delete an announcement',2),(317,'2019-04-23 09:34:28','Insert','Delete an announcement',2),(318,'2019-04-23 09:56:30','Delete','Delete an announcement',2),(319,'2019-04-23 09:56:58','Delete','Delete an announcement',2),(320,'2019-04-23 10:00:45','Delete','Delete an announcement',2),(321,'2019-04-23 16:30:45','Update','Updated announcement with the following details(Title: Christmas Day, Description: Merry Christmas Everyone!, Date Start: 2019-04-24, Date End: 2019-04-20, Attachment: ',1),(322,'2019-04-23 16:30:52','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: 2019-01-04, Date End: 2019-02-04, Attachment: ',1),(323,'2019-04-23 16:31:21','Update','Updated announcement with the following details(Title: Christmas Day, Description: Merry Christmas Everyone!, Date Start: 2019-04-24, Date End: 2019-04-20, Attachment: ',1),(324,'2019-04-23 16:31:49','Update','Updated announcement with the following details(Title: Christmas Day, Description: Merry Christmas Everyone!, Date Start: 2019-04-24, Date End: 2019-04-20, Attachment: attachment_1.pdf',1),(325,'2019-04-23 16:33:38','Update','Updated announcement with the following details(Title: Christmas Day, Description: Merry Christmas Everyone!, Date Start: 2019-04-24, Date End: 2019-04-20, Attachment: attachment_1.pdf',1),(326,'2019-04-23 16:38:25','Update','Updated announcement with the following details(Title: Christmas Day, Description: Merry Christmas Everyone!, Date Start: 2019-04-24, Date End: 2019-04-20, Attachment: attachment_1.pdf',1),(327,'2019-04-23 16:39:07','Update','Updated announcement with the following details(Title: Holy Week, Description: No Classes, Date Start: 2019-01-04, Date End: 2019-02-04, Attachment: attachment_67.docx',1),(328,'2019-04-23 16:46:12','Insert','Added announcement with a Title: , Description:  FHASDKFK ASDKF ASDKFHJK ADSHJFKH AKHDFKASHD KJHASDKFH JADSKHF SDJAFK HASDJFKH KASDJFHKJ AHSDJKFH KASJDHFJK HASDKFH ASKDLFHKASHFDJK ASHDKJHASKJFH KASDDFH HASDKF HKASHD KASDHFH ASKDHFHASDKFHKS D HFKAH ASDF',1),(329,'2019-04-23 11:07:03','Update','Update an announcement',2),(330,'2019-04-23 11:07:16','Update','Update an announcement',2),(331,'2019-04-23 11:08:19','Update','Update an announcement',2),(332,'2019-04-23 11:12:32','Update','Transferred a student.',2),(333,'2019-04-23 11:13:05','Insert','Added a schedule.',2),(334,'2019-04-23 11:14:37','Insert','Posted a new announcement for students',2),(335,'2019-04-23 11:15:49','Update','Update an announcement',2),(336,'2019-04-23 11:16:33','Update','Update an announcement',2),(337,'2019-04-23 11:17:24','Update','Update an announcement',2),(338,'2019-04-23 11:17:36','Update','Update an announcement',2),(339,'2019-04-23 17:21:29','Insert','Added announcement with a Title: SampEvent, Description: ',1),(340,'2019-04-23 17:22:07','Delete','Deleted announcement SampEvent, Description: ',1),(341,'2019-04-23 17:22:23','Insert','Added announcement with a Title: Samp Event, Description: ',1),(342,'2019-04-23 17:22:45','Delete','Deleted announcement Samp Event, Description: ',1),(343,'2019-04-23 17:22:57','Insert','Added announcement with a Title: Samp Event, Description: ',1),(344,'2019-04-23 17:23:47','Insert','Added announcement with a Title: Samp Event, Description: ',1),(345,'2019-04-23 17:23:55','Delete','Deleted announcement Samp Event, Description: ',1),(346,'2019-04-23 17:24:03','Delete','Deleted announcement Samp Event, Description: ',1),(347,'2019-04-23 17:24:03','Delete','Deleted announcement , Description: ',1),(348,'2019-04-23 17:24:40','Insert','Added announcement with a Title: Samp , Description: ',1),(349,'2019-04-23 17:26:58','Delete','Deleted announcement Samp , Description: ',1),(350,'2019-04-23 17:27:10','Insert','Added announcement with a Title: Samp, Description: ',1),(351,'2019-04-23 17:30:59','Delete','Deleted announcement Samp, Description: ',1),(352,'2019-04-23 17:32:18','Insert','Added announcement with a Title: Samp, Description: ',1),(353,'2019-04-23 17:32:48','Insert','Added announcement with a Title: Samp',1),(354,'2019-04-23 17:32:54','Delete','Deleted announcement Samp, Description: ',1),(355,'2019-04-23 17:43:24','Update','Updated announcement with the following details(Title: Samps, Date Start: 1970-01-01, Date End: 1970-01-01',1),(356,'2019-04-23 17:43:31','Update','Updated announcement with the following details(Title: Samps, Date Start: 1970-01-01, Date End: 1970-01-01',1),(357,'2019-04-23 17:52:03','Insert','Added announcement with a Title: ',1),(358,'2019-04-23 17:52:45','Insert','Added announcement with a Title: ',1),(359,'2019-04-23 17:53:04','Delete','Deleted announcement Samps, Description: ',1),(360,'2019-04-23 17:53:20','Insert','Added announcement with a Title: ev',1),(361,'2019-04-23 17:53:47','Update','Updated announcement with the following details(Title: ev, Date Start: 1970-01-01, Date End: 1970-01-01',1),(362,'2019-04-23 17:53:55','Update','Updated announcement with the following details(Title: ev, Date Start: 1970-01-02, Date End: 1970-01-01',1),(363,'2019-04-23 17:54:23','Update','Updated announcement with the following details(Title: ev, Date Start: 1970-01-02, Date End: 1970-01-09',1),(364,'2019-04-23 17:58:42','Insert','Added announcement with a Title: , Description: Ann',1),(365,'2019-04-23 17:59:30','Insert','Added announcement with a Announcement: Ann',1),(366,'2019-04-23 17:59:42','Insert','Added announcement with a Announcement: Ann',1),(367,'2019-04-23 18:02:22','Insert','Added announcement with a Announcement: Ann',1),(368,'2019-04-23 18:05:28','Update','Updated announcement with the following details(Title: , Description: Anns, Date Start: 1970-01-02, Date End: 1970-01-09, Attachment: attachment_133.pdf',1),(369,'2019-04-23 18:06:23','Update','Updated announcement with the following details( Announcement: Anns, Date Start: 1970-01-02, Date End: 1970-01-09, Attachment: attachment_133.pdf',1),(370,'2019-04-23 18:06:48','Update','Updated announcement with the following details(Title: , Description: Anns, Date Start: 1970-01-02, Date End: 3123-12-09, Attachment: attachment_133.torrent',1),(371,'2019-04-23 18:07:16','Update','Updated announcement with the following details(Announcement: Anns, Date Start: 1970-01-02, Date End: 3123-12-09, Attachment: attachment_133.torrent',1),(372,'2019-04-23 18:07:23','Update','Updated announcement with the following details( Announcement: Anns, Date Start: 1970-01-02, Date End: 1970-01-09, Attachment: attachment_133.torrent',1),(373,'2019-04-23 18:14:23','Insert','Added an account of treasurer member asdasdasdfasdf asdfasdf DF ASDF SDA ASDF ASDFASD FADSFSAD ADSF SADF ASDFSDF SAD SDDF',1),(374,'2019-04-23 18:16:47','','Deleted the account of asdasdasdfasdf asdfasdf DF ASDF SDA ASDF ASDFASD FADSFSAD ADSF SADF ASDFSDF SAD SDDF',1),(375,'2019-04-23 18:26:07','Update','Updated announcement with the following details( Announcement: Anns, Date Start: 1970-01-09, Date End: 1970-01-09, Attachment: attachment_133.torrent',1),(376,'2019-04-23 18:34:23','Insert','Added announcement with a Announcement: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sollicitudin varius ante eget elementum. Etiam ac massa semper, scelerisque tortor id, iaculis velit. Pellentesque ac orci nisl. Pellentesque at ante id ipsum efficitur commodo ac vel nisi. Integer',1),(377,'2019-04-23 18:46:55','Delete','Deleted announcement , Description: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sollicitudin varius ante eget elementum. Etiam ac massa semper, scelerisque tortor id, iaculis velit. Pellentesque ac orci nisl. Pellentesque at ante id ipsum efficitur commodo ac vel nisi. Integer a i',1),(378,'2019-04-23 18:47:36','Delete','Deleted announcement , Description: ',1),(379,'2019-04-23 19:37:37','Insert','Posted a new announcement for students',2),(380,'2019-04-23 19:38:03','Delete','Delete an announcement',2),(397,'2019-04-23 16:00:00','','Added payment for Hazel Rapisura',5),(398,'2019-04-23 16:00:00','','Added payment for John Marzan',5),(399,'2019-04-23 16:00:00','','Added payment for Hazel Rapisura',5),(400,'2019-04-24 16:00:00','Insert','Added payment for Hazel Rapisura',5),(401,'2019-04-24 16:00:00','Insert','Added payment for Hazel Rapisura',5),(402,'2019-04-24 16:00:00','Insert','Added payment for Alezzandra Concepcion',5),(403,'2019-04-24 16:00:00','Insert','Added payment for Hazel Rapisura',5),(404,'2019-04-24 16:00:00','Insert','Added payment for Hazel Rapisura',5),(405,'2019-04-24 16:00:00','Insert','Added payment for Alezzandra Concepcion',5),(406,'2019-04-24 16:00:00','Insert','Added payment for Alezzandra Concepcion',5),(407,'2019-04-24 16:00:00','Insert','Added payment for Alezzandra Concepcion',5),(408,'2019-04-24 16:00:00','Insert','Added payment for Princess Arambulo',5),(409,'2019-04-24 16:00:00','Insert','Added payment for Princess Arambulo',5),(410,'2019-04-24 16:00:00','Insert','Added payment for Jellian Clave',5),(411,'2019-04-24 16:00:00','Insert','Added payment for Jellian Clave',5),(412,'2019-04-24 16:00:00','Insert','Added payment for Geraldine Blackburn',5),(413,'2019-04-24 16:00:00','Insert','Added payment for Geraldine Blackburn',5),(414,'2019-04-24 16:00:00','Insert','Added payment for Adriana Uria',5),(415,'2019-04-24 16:00:00','Insert','Added payment for Adriana Uria',5),(416,'2019-04-24 16:00:00','Insert','Added payment for Firstname Lastname',5),(417,'2019-04-24 16:00:00','Insert','Added payment for Firstname Lastname',5),(418,'2019-04-24 16:00:00','Insert','Added payment for John Marzan',5),(419,'2019-04-24 16:00:00','Insert','Added payment for John Marzan',5),(420,'2019-04-24 16:00:00','Insert','Added payment for First Another',5),(421,'2019-04-24 16:00:00','Insert','Added payment for First Another',5),(422,'2019-04-24 16:00:00','Insert','Added payment for First Another',5),(423,'2019-04-24 16:00:00','Insert','Added payment for Enrico Hubble',5),(424,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(425,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(426,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(427,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(428,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(429,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(430,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(431,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(432,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(433,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(434,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(435,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(436,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(437,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(438,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(439,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(440,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(441,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(442,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(443,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(444,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(445,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5),(446,'2019-04-24 16:00:00','Insert','Added payment for Mimi Ka',5);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `notif_id` int(12) NOT NULL,
  `post` varchar(100) NOT NULL,
  `from` varchar(45) NOT NULL,
  `towhom` int(13) NOT NULL,
  `status` enum('TRUE','FALSE') NOT NULL DEFAULT 'TRUE',
  `timestamp_notif` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`notif_id`),
  KEY `towhom_idx` (`towhom`),
  CONSTRAINT `towhom` FOREIGN KEY (`towhom`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
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
  CONSTRAINT `balb_id` FOREIGN KEY (`balb_id`) REFERENCES `balance` (`bal_id`) ON UPDATE CASCADE,
  CONSTRAINT `budg_ida` FOREIGN KEY (`budg_ida`) REFERENCES `budget_info` (`budget_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` VALUES (1,300,1050,'2018-03-15 11:30:45','ABC1234','2018-04-02 07:01:59',1,1),(2,300,750,'2019-03-15 11:30:45','ABC1234','2019-03-15 03:30:45',1,2),(3,175,1175,'2019-03-25 01:23:15','DEF3456','2019-03-24 17:23:15',2,2),(4,75,1100,'2019-03-25 01:23:15','DEF3456','2019-03-24 17:23:15',2,5),(5,75,1025,'2019-03-25 01:23:15','DEF3456','2019-03-24 17:23:15',2,6),(6,250,500,'2019-06-23 09:30:10','TUG4928','2019-06-23 01:30:10',1,3),(7,100,400,'2019-06-23 09:30:10','TUG4928','2019-06-23 01:30:10',1,5),(8,200,825,'2019-06-24 10:30:15','JDI2348','2019-06-24 02:30:15',2,1),(9,50,350,'2019-07-15 11:00:12','UIA2306','2019-07-15 03:00:12',1,8),(10,25,325,'2019-07-15 11:00:12','UIA2306','2019-07-15 03:00:12',1,6),(11,25,300,'2019-07-15 11:00:12','UIA2306','2019-07-15 03:00:12',1,7),(12,200,625,'2019-07-25 03:30:00','MVK0921','2019-07-24 19:30:00',2,3),(13,150,475,'2019-07-25 03:30:00','MVK0921','2019-07-24 19:30:00',2,4),(14,50,425,'2019-07-25 03:30:00','MVK0921','2019-07-24 19:30:00',2,8),(15,150,150,'2019-08-07 09:10:24','QWE9781','2019-08-07 01:10:24',1,4),(16,75,350,'2019-08-11 01:30:11','AHS192','2019-04-19 15:55:59',2,7),(17,10,140,'2019-08-13 01:30:11','NGH8472','2019-04-17 08:21:39',1,5),(18,50,1300,'2019-08-20 01:30:11','ZXC456','2019-04-17 08:21:40',3,4),(19,150,1150,'2019-08-21 01:30:11','VBN785','2019-04-17 08:21:41',3,5),(20,100,1250,'2019-08-21 09:30:10','JDS9201','2019-04-17 08:21:41',4,1),(21,10,130,'2019-08-13 01:30:11','NGH8472','2019-04-17 08:21:39',1,6),(22,10,1340,'2019-08-18 01:30:11','XZVBNM7561','2019-08-17 17:30:11',6,1),(23,10,1330,'2019-08-19 01:30:11','XZVBNM7561','2019-08-18 17:30:11',6,2),(33,10,1340,'2020-04-10 00:00:00','AKA9210','2019-04-20 16:37:47',15,1),(35,10,1340,'2020-05-01 00:00:00','JKSA0381','2019-04-21 03:40:26',13,1),(36,10,1340,'2020-05-01 00:00:00','OSP01938','2019-04-21 03:40:26',16,4),(38,10,1330,'2020-07-04 00:00:00','OWP1290','2019-04-21 08:58:23',15,1),(39,10,1320,'2020-08-14 00:00:00','KASJ1209','2019-04-21 09:04:22',15,1),(40,10,1310,'2020-08-14 00:00:00','KASJ1209','2019-04-21 09:04:22',15,2),(41,10,1330,'2020-07-03 00:00:00','OEW03290','2019-04-21 16:43:18',13,1),(42,10,1340,'2019-07-27 00:00:00','VMC4390','2019-04-21 16:45:05',12,1),(43,10,1340,'2019-10-12 00:00:00','OEP2301','2019-04-21 16:55:31',11,1),(45,40,90,'2019-09-06 00:00:00','DFOS2302','2019-04-22 18:18:36',1,5),(46,40,50,'2020-03-06 00:00:00','DSF3209','2019-04-22 18:19:21',1,6),(47,50,0,'2020-03-06 00:00:00','DSF3209','2019-04-22 18:19:21',1,7),(48,100,250,'2019-10-12 00:00:00','DKFS3209','2019-04-22 18:22:36',2,1),(49,125,125,'2019-10-12 00:00:00','DKFS3209','2019-04-22 18:22:36',2,2),(50,50,75,'2019-10-12 00:00:00','DKFS3209','2019-04-22 18:22:37',2,3),(51,70,5,'2019-10-12 00:00:00','DKFS3209','2019-04-22 18:22:37',2,5),(52,1,4,'2019-12-06 00:00:00','EOW902','2019-04-22 18:30:58',2,5),(53,4,0,'2020-01-02 00:00:00','HSDI29021','2019-04-22 18:31:20',2,5),(55,50,1100,'2019-09-05 00:00:00','XCNJ390','2019-04-23 18:41:51',3,8),(83,20,1310,'2020-08-07 00:00:00','CNH94590','2019-04-24 08:41:34',13,1),(84,10,1300,'2020-08-07 00:00:00','CNH94590','2019-04-24 08:41:34',13,2),(85,50,1050,'2019-10-11 00:00:00','OOPA920','2019-04-24 08:52:34',3,1),(86,50,1000,'2019-10-11 00:00:00','OOPA920','2019-04-24 08:52:34',3,2),(87,260,1040,'2020-09-05 00:00:00','DSNFS382','2019-04-24 08:56:40',13,1),(88,50,990,'2020-09-05 00:00:00','DSNFS382','2019-04-24 08:56:40',13,8),(89,290,700,'2020-10-02 00:00:00','ZXCK9438','2019-04-25 06:39:48',13,2),(90,250,450,'2020-10-02 00:00:00','ZXCK9438','2019-04-25 06:39:49',13,3),(91,150,300,'2020-10-02 00:00:00','ZXCK9438','2019-04-25 06:39:49',13,4),(92,150,150,'2020-10-02 00:00:00','ZXCK9438','2019-04-25 06:39:49',13,5),(93,75,75,'2020-10-02 00:00:00','ZXCK9438','2019-04-25 06:39:49',13,6),(94,65,10,'2020-10-02 00:00:00','ZXCK9438','2019-04-25 06:39:49',13,7),(95,5,5,'2020-10-17 00:00:00','CBE503','2019-04-25 06:46:21',13,7),(96,70,1240,'2020-09-04 00:00:00','JHU3189','2019-04-25 07:06:48',15,1),(97,50,1190,'2020-09-04 00:00:00','JHU3189','2019-04-25 07:06:49',15,8),(98,3,2,'2020-11-05 00:00:00','OKQ359','2019-04-25 07:22:57',13,7),(99,2,0,'2020-12-25 00:00:00','OPD4382','2019-04-25 07:24:19',13,7),(100,200,990,'2020-10-10 00:00:00','ATOY40328','2019-04-25 07:27:17',15,1),(101,290,700,'2020-10-10 00:00:00','ATOY40328','2019-04-25 07:27:17',15,2),(102,250,450,'2020-10-10 00:00:00','ATOY40328','2019-04-25 07:27:17',15,3),(103,150,300,'2020-10-10 00:00:00','ATOY40328','2019-04-25 07:27:18',15,4),(104,150,150,'2020-10-10 00:00:00','ATOY40328','2019-04-25 07:27:18',15,5),(105,75,75,'2020-10-10 00:00:00','ATOY40328','2019-04-25 07:27:18',15,6),(106,70,5,'2020-11-13 00:00:00','JFDK48939','2019-04-25 07:30:36',15,7),(107,5,0,'2020-11-27 00:00:00','MNB3589','2019-04-25 07:31:17',15,7),(108,290,1050,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:15',12,1),(109,300,750,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,2),(110,250,500,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,3),(111,150,350,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,4),(112,150,200,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,5),(113,75,125,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,6),(114,75,50,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,7),(115,30,20,'2019-08-08 00:00:00','FDHG5849','2019-04-25 07:44:16',12,8),(116,20,0,'2019-09-14 00:00:00','LOP4829','2019-04-25 07:44:32',12,8),(117,300,1040,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:57',16,1),(118,300,740,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:57',16,2),(119,250,490,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:57',16,3),(120,140,350,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:57',16,4),(121,150,200,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:57',16,5),(122,75,125,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:57',16,6),(123,75,50,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:58',16,7),(124,30,20,'2020-07-03 00:00:00','PMK738','2019-04-25 07:51:58',16,8),(125,20,0,'2020-08-07 00:00:00','RIEI0248','2019-04-25 07:53:43',16,8),(126,290,1050,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:32',11,1),(127,300,750,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:32',11,2),(128,250,500,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:32',11,3),(129,150,350,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:32',11,4),(130,150,200,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:32',11,5),(131,75,125,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:33',11,6),(132,75,50,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:33',11,7),(133,20,30,'2019-10-19 00:00:00','JDHF4897','2019-04-25 07:57:33',11,8),(134,30,0,'2019-11-16 00:00:00','POR58849','2019-04-25 08:00:11',11,8),(135,200,1050,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,1),(136,300,750,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,2),(137,250,500,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,3),(138,150,350,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,4),(139,150,200,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,5),(140,75,125,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,6),(141,75,50,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:04',4,7),(142,20,30,'2019-08-31 00:00:00','ASF49358','2019-04-25 08:02:05',4,8),(143,30,0,'2019-09-27 00:00:00','QWZFD','2019-04-25 08:02:36',4,8),(144,300,1050,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:54',17,1),(145,300,750,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:54',17,2),(146,250,500,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:55',17,3),(147,150,350,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:55',17,4),(148,150,200,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:55',17,5),(149,75,125,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:55',17,6),(150,75,50,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:55',17,7),(151,30,20,'2019-04-26 00:00:00','JGSK4597','2019-04-25 08:05:55',17,8),(152,20,0,'2019-06-15 00:00:00','POJ088','2019-04-25 08:06:37',17,8),(153,250,750,'2019-11-08 00:00:00','SFLJ5849','2019-04-25 10:40:33',3,1),(154,250,500,'2019-11-08 00:00:00','SFLJ5849','2019-04-25 10:40:33',3,2),(155,250,250,'2019-11-08 00:00:00','SFLJ5849','2019-04-25 10:40:33',3,3),(156,100,150,'2019-11-08 00:00:00','SFLJ5849','2019-04-25 10:40:33',3,4),(157,75,75,'2019-11-08 00:00:00','SFLJ5849','2019-04-25 10:40:33',3,6),(158,70,5,'2019-11-08 00:00:00','SFLJ5849','2019-04-25 10:40:33',3,7),(159,5,0,'2019-10-18 00:00:00','SJFD53894','2019-04-25 10:41:02',3,7),(160,300,1050,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:26',18,1),(161,300,750,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,2),(162,250,500,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,3),(163,150,350,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,4),(164,150,200,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,5),(165,75,125,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,6),(166,75,50,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,7),(167,40,10,'2019-04-30 00:00:00','JSDF48935','2019-04-25 11:26:27',18,8),(168,5,5,'2019-08-09 00:00:00','CVE3829','2019-04-25 11:26:56',18,8),(169,5,0,'2019-09-13 00:00:00','GJ437','2019-04-25 11:27:25',18,8),(170,300,1050,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:19',10,1),(171,300,750,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:20',10,2),(172,250,500,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:20',10,3),(173,150,350,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:20',10,4),(174,150,200,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:20',10,5),(175,75,125,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:20',10,6),(176,75,50,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:20',10,7),(177,50,0,'2019-08-22 00:00:00','QEOP4839','2019-04-25 11:29:21',10,8),(178,150,1200,'2019-05-17 00:00:00','DEKF4893','2019-04-25 13:12:01',19,1),(179,50,1150,'2019-05-17 00:00:00','DEKF4893','2019-04-25 13:12:01',19,8),(180,100,1050,'2019-12-25 00:00:00','TNN222','2019-04-25 15:50:44',19,2);
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
  `stud_idf` int(12) NOT NULL,
  PRIMARY KEY (`rank_id`),
  KEY `stud_idf` (`stud_idf`),
  CONSTRAINT `stud_idf` FOREIGN KEY (`stud_idf`) REFERENCES `student` (`stud_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `timestamp_ss` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`schedsubja_id`,`schedsubjb_id`,`fw_id`,`sw_id`),
  KEY `schedsubjb_id_idx` (`schedsubjb_id`),
  KEY `schedsubja_id` (`schedsubja_id`),
  KEY `schedsubjb_id` (`schedsubjb_id`),
  KEY `fw_id_idx` (`fw_id`),
  KEY `sw_id_idx` (`sw_id`),
  CONSTRAINT `fw_id` FOREIGN KEY (`fw_id`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `schedsubja_id` FOREIGN KEY (`schedsubja_id`) REFERENCES `schedule` (`sched_id`) ON UPDATE CASCADE,
  CONSTRAINT `schedsubjb_id` FOREIGN KEY (`schedsubjb_id`) REFERENCES `subject` (`subj_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `sw_id` FOREIGN KEY (`sw_id`) REFERENCES `section` (`sec_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `schedsubj`
--

LOCK TABLES `schedsubj` WRITE;
/*!40000 ALTER TABLE `schedsubj` DISABLE KEYS */;
INSERT INTO `schedsubj` VALUES (1,1,'Monday,Tuesday,Wednesday,Thursday,Friday','10:00:00','11:00:00',1,1,'2019-04-22 13:45:04'),(1,18,'Monday,Tuesday,Wednesday,Thursday,Friday','08:40:00','09:40:00',20,1,'2019-04-22 03:58:49'),(1,22,'Monday,Tuesday,Wednesday,Thursday,Friday','07:40:00','08:40:00',16,1,'2019-04-23 17:13:05'),(3,3,'Monday,Tuesday,Wednesday,Thursday,Friday','07:40:00','08:40:00',1,5,'2019-04-21 15:38:26'),(3,3,'Monday,Tuesday,Wednesday,Thursday,Friday','08:40:00','09:40:00',1,6,'0000-00-00 00:00:00'),(3,8,'Monday,Tuesday,Wednesday,Thursday,Friday','10:00:00','11:00:00',4,6,'0000-00-00 00:00:00'),(3,12,'Monday,Tuesday,Wednesday,Thursday,Friday','13:00:00','14:00:00',3,6,'0000-00-00 00:00:00'),(3,16,'Monday,Tuesday,Wednesday,Thursday,Friday','11:00:00','12:00:00',2,6,'0000-00-00 00:00:00'),(3,20,'Monday,Tuesday,Wednesday,Thursday,Friday','14:00:00','15:00:00',9,6,'0000-00-00 00:00:00'),(3,24,'Monday,Tuesday,Wednesday,Thursday,Friday','10:00:00','11:00:00',5,5,'2019-04-21 15:39:06'),(3,24,'Monday,Tuesday,Wednesday,Thursday,Friday','15:00:00','16:00:00',8,6,'0000-00-00 00:00:00'),(3,29,'Monday,Tuesday,Wednesday,Thursday,Friday','07:40:00','08:40:00',6,6,'0000-00-00 00:00:00'),(3,33,'Monday,Tuesday,Wednesday,Thursday,Friday','16:00:00','17:00:00',7,6,'0000-00-00 00:00:00'),(4,4,'Monday,Tuesday,Wednesday,Thursday,Friday','14:00:00','15:00:00',1,7,'0000-00-00 00:00:00'),(4,9,'Monday,Tuesday,Wednesday,Thursday,Friday','07:40:00','08:40:00',4,7,'2019-04-21 14:55:54'),(4,13,'Monday,Tuesday,Wednesday,Thursday,Friday','10:00:00','11:00:00',3,7,'0000-00-00 00:00:00'),(4,17,'Monday,Tuesday,Wednesday,Thursday,Friday','13:00:00','14:00:00',2,7,'0000-00-00 00:00:00'),(4,21,'Monday,Tuesday,Wednesday,Thursday,Friday','15:00:00','16:00:00',9,7,'0000-00-00 00:00:00'),(4,26,'Monday,Tuesday,Wednesday,Thursday,Friday','11:00:00','12:00:00',5,7,'0000-00-00 00:00:00'),(4,30,'Monday,Tuesday,Wednesday,Thursday,Friday','16:00:00','17:00:00',6,7,'0000-00-00 00:00:00'),(4,34,'Monday,Tuesday,Wednesday,Thursday,Friday','08:40:00','09:40:00',7,7,'2019-04-21 14:56:03');
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
  `grade_lvl` enum('7','8','9','10') COLLATE utf8_bin NOT NULL,
  `timestamp_sec` datetime NOT NULL,
  `fac_idv` int(12) DEFAULT NULL,
  PRIMARY KEY (`sec_id`),
  UNIQUE KEY `sec_name_UNIQUE` (`sec_name`),
  KEY `fac_idv` (`fac_idv`),
  CONSTRAINT `fac_idv` FOREIGN KEY (`fac_idv`) REFERENCES `faculty` (`fac_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
INSERT INTO `section` VALUES (1,'Hope','7','2019-03-29 07:27:30',1),(2,'Excellence','7','2019-03-29 07:28:30',2),(3,'Altruism','8','2019-03-29 07:28:55',22),(4,'Wisdom','8','2019-03-29 07:29:30',4),(5,'Dignity ','9','2019-03-29 07:30:30',5),(6,'Righteousness','9','2019-03-29 07:30:58',6),(7,'Freedom','10','2019-03-29 07:31:30',7),(8,'Independence','10','2019-03-29 07:32:30',8),(33,'SampTitle6','9','2019-04-21 05:09:16',NULL),(34,'MarzanLogs','9','2019-04-21 05:35:23',18),(35,'MarzanLogs2','8','2019-04-21 05:40:58',23),(45,'Samp','7','2019-04-22 17:27:47',NULL);
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
  `stud_address` varchar(100) COLLATE utf8_bin NOT NULL,
  `stud_bday` date NOT NULL,
  `mother_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `father_name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `nationality` varchar(45) COLLATE utf8_bin NOT NULL,
  `ethnicity` varchar(45) COLLATE utf8_bin NOT NULL,
  `year_in` year(4) NOT NULL,
  `year_out` year(4) DEFAULT NULL,
  `blood_type` enum('O','A','B','AB') COLLATE utf8_bin NOT NULL,
  `medical_stat` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `stud_status` enum('Officially Enrolled','Temporarily Enrolled','Not Enrolled','Graduated','Transferred') COLLATE utf8_bin NOT NULL,
  `curr_stat` enum('Old','New') COLLATE utf8_bin NOT NULL,
  `sec_stat` enum('Temporary','Permanent') COLLATE utf8_bin NOT NULL DEFAULT 'Permanent',
  `timestamp_stud` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `accc_id` int(13) NOT NULL,
  `secc_id` int(12) NOT NULL,
  `guar_id` int(11) NOT NULL,
  PRIMARY KEY (`stud_id`),
  UNIQUE KEY `lr_no_UNIQUE` (`stud_lrno`),
  KEY `accc_id` (`accc_id`),
  KEY `secc_id` (`secc_id`),
  KEY `guar_id_idx` (`guar_id`),
  CONSTRAINT `accc_id` FOREIGN KEY (`accc_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `guar_id` FOREIGN KEY (`guar_id`) REFERENCES `guardian` (`guar_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `secc_id` FOREIGN KEY (`secc_id`) REFERENCES `section` (`sec_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,2019087065345,'Marzan','Mark Kenneth','Pagar   ','Male','10',2019,'Queen of Peace Baguio City','1999-10-22','Julina Gaddi','Jonel Gaddi','Filipino','Igorot',2015,NULL,'O','Skin Allergy','Officially Enrolled','Old','Permanent','2019-04-20 04:55:58',3,7,1),(2,2019087065675,'Cantero','Mark Israel ','Asuncion','Male','9',2019,'Bakakeng Sur Baguio City','0000-00-00','Mimi Nimes','Dom Nimes','Filipino','Tagalog',2016,NULL,'AB','None','Officially Enrolled','New','Permanent','2019-04-09 08:46:31',6,6,2),(3,2019038272638,'Marzan','John','Thanos','Male','9',2019,'Irisan Baguio City','1998-05-21','Julina Gaddi','Jonel Gaddi','Filipino','Igorot',2016,NULL,'O','None','Temporarily Enrolled','New','Permanent','2019-04-22 13:43:44',15,6,1),(4,1231123123132,'Uria','Adriana','Barton','Female','7',2019,'asd, asd, asd 2222','2019-04-03',NULL,NULL,'asd','asd',2019,NULL,'O','asd','Officially Enrolled','Old','Permanent','2019-04-17 15:16:44',17,1,3),(5,3122311322131,'Einstein','Albert','Lucid','Male','8',2019,'asd, asd, asd asd','2019-04-23',NULL,NULL,'asd','asd',2019,NULL,'O',NULL,'Officially Enrolled','Old','Temporary','2019-04-21 15:42:22',19,35,4),(6,2222221111111,'Pascal','Blaise','Jackson','Male','10',2019,'asd, asd, asd 2222','2019-04-23',NULL,NULL,'asd','asd',2019,NULL,'O','asd','Officially Enrolled','Old','Temporary','2019-04-17 07:36:35',21,8,5),(7,2222222231313,'Herschel','Dorothy','Rutherford','Male','7',2019,'asd, asd, asd11 2222','2019-04-24',NULL,NULL,'asd','asd',2019,NULL,'O',NULL,'Officially Enrolled','New','Permanent','2019-04-17 08:06:03',23,1,6),(8,1123121233212,'Wu','Edmond','Newton','Male','7',2019,'asdads, adsd, asd 2222','2019-04-17',NULL,NULL,'asd','asd',2019,NULL,'O',NULL,'Transferred','New','Temporary','2019-04-22 11:45:19',29,2,9),(9,2222919291111,'Hally','Edwin','Bohr','Male','7',2019,'Sparta, Omg, Wow 2222','2019-04-03',NULL,NULL,'This','Is',2019,NULL,'O',NULL,'Officially Enrolled','New','Permanent','2019-04-17 08:36:39',31,1,10),(10,2131231231212,'Hubble','Enrico','Faraday','Male','7',2019,'asdasdasdasd, asddasasd, asddas 1233','2019-04-17','Julina Gaddi','Jonel Gaddi','asd','asd',2019,NULL,'O',NULL,'Officially Enrolled','New','Temporary','2019-04-24 04:01:03',33,2,1),(11,1223123123123,'Blackburn','Geraldine','Planck','Male','8',2019,'Wow, Wie, Oops 2131','2019-04-18','Julina Gaddi','Jonel Gaddi','SampleSample','Dont',2019,NULL,'O',NULL,'Temporarily Enrolled','Old','','2019-04-16 09:48:18',34,3,1),(12,1123121332132,'Arambulo','Princess','Salud','Female','7',2019,'Hindekoalam, Domincan, Baguio City 2600','2019-04-23',NULL,NULL,'Filipino','Tagalog',2019,NULL,'O',NULL,'Officially Enrolled','New','Temporary','2019-04-22 12:05:51',69,1,12),(13,1111123312222,'Rapisura','Hazel','Idontknow','Female','7',2019,'I wish, I know, Baguio City 2600','2019-04-17',NULL,NULL,'Filipino','Spanish',2019,NULL,'O',NULL,'Officially Enrolled','New','Temporary','2019-04-24 01:32:26',71,1,13),(14,1111231327898,'Concepcion','Alezzandra','Khyra','Female','7',2019,'I really, Wish I know, Baguio City 2600','2019-04-24','','','Filipino','Tagalog',2019,NULL,'O','','Officially Enrolled','New','Temporary','2019-04-22 13:25:19',72,1,13),(15,1212123121123,'Clave','Jellian','Philip','Female','7',2019,'Testing, Sample, Baguio City 2600','2019-04-05',NULL,NULL,'Filipino','Tagalog',2019,NULL,'O',NULL,'Officially Enrolled','New','Temporary','2019-04-21 06:55:01',73,1,3),(16,1231231231232,'Lastname','Firstname','Middlename','Male','7',2019,'Sample Street, Sample Barangay, Baguio City 2600','2019-04-24',NULL,NULL,'Filipino','Tagalog',2019,NULL,'O',NULL,'Officially Enrolled','New','Permanent','2019-04-17 03:57:51',83,1,3),(17,2131212312321,'Another','First','Middle','Male','7',2019,'Sample, One, Nice 2600','2019-04-04','Mimi Nimes','Dom Nimes','Nationality','Tagalog',2019,NULL,'O',NULL,'Officially Enrolled','New','Permanent','2019-04-17 09:38:44',84,1,2),(18,2162752216271,'Ka','Mimi','Yu','Female','7',2019,'Street, Barangay, City 2600','2019-04-18','Julina Gaddi','Jonel Gaddi','Filipino','Korean',2019,NULL,'O',NULL,'Officially Enrolled','New','Permanent','2019-04-17 09:36:11',85,1,1),(19,1123321123133,'Si Ya Jr.','Jonel','Abugbug','Male','7',2019,'Street, Barangay, City 2600','2019-04-05','','','Filipino','European',2019,NULL,'O','','Graduated','New','Temporary','2019-04-22 13:24:42',87,1,16);
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
  `subj_level` enum('7','8','9','10') COLLATE utf8_bin NOT NULL,
  `subj_dept` enum('Filipino','Math','MAPEH','Science','AP','English','TLE','Values') COLLATE utf8_bin NOT NULL,
  `subj_name` varchar(45) COLLATE utf8_bin NOT NULL,
  `timestamp_subj` datetime NOT NULL,
  PRIMARY KEY (`subj_id`),
  UNIQUE KEY `subj_name_UNIQUE` (`subj_name`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subject`
--

LOCK TABLES `subject` WRITE;
/*!40000 ALTER TABLE `subject` DISABLE KEYS */;
INSERT INTO `subject` VALUES (1,'7','Math','Algebra 1','0000-00-00 00:00:00'),(2,'8','Math','Algebra 2','0000-00-00 00:00:00'),(3,'9','Math','Geometry','0000-00-00 00:00:00'),(4,'10','Math','Calculus','0000-00-00 00:00:00'),(5,'7','Math','Trigonometry','0000-00-00 00:00:00'),(6,'7','Filipino','Filipino 1','0000-00-00 00:00:00'),(7,'8','Filipino','Filipino 2','0000-00-00 00:00:00'),(8,'9','Filipino','Filipino 3','0000-00-00 00:00:00'),(9,'10','Filipino','Filipino 4','0000-00-00 00:00:00'),(10,'7','Science','Integrated Science','0000-00-00 00:00:00'),(11,'8','Science','Biology','0000-00-00 00:00:00'),(12,'9','Science','Chemistry','0000-00-00 00:00:00'),(13,'10','Science','Physics','0000-00-00 00:00:00'),(14,'7','English','English 1','0000-00-00 00:00:00'),(15,'8','English','English 2','0000-00-00 00:00:00'),(16,'9','English','English 3','0000-00-00 00:00:00'),(17,'10','English','English 4','0000-00-00 00:00:00'),(18,'7','MAPEH','MAPEH 1','0000-00-00 00:00:00'),(19,'8','MAPEH','MAPEH 2','0000-00-00 00:00:00'),(20,'9','MAPEH','MAPEH 3','0000-00-00 00:00:00'),(21,'10','MAPEH','MAPEH 4','0000-00-00 00:00:00'),(22,'7','AP','Phillipine History','0000-00-00 00:00:00'),(23,'8','AP','Asian History','0000-00-00 00:00:00'),(24,'9','AP','World History','0000-00-00 00:00:00'),(25,'10','AP','Geography','0000-00-00 00:00:00'),(26,'10','AP','Economics ','0000-00-00 00:00:00'),(27,'7','TLE','TLE 1','0000-00-00 00:00:00'),(28,'8','TLE','TLE 2','0000-00-00 00:00:00'),(29,'9','TLE','TLE 3','0000-00-00 00:00:00'),(30,'10','TLE','TLE 4','0000-00-00 00:00:00'),(31,'7','Values','Values 1','0000-00-00 00:00:00'),(32,'8','Values','Values 2','0000-00-00 00:00:00'),(33,'9','Values','Values 3','0000-00-00 00:00:00'),(34,'10','Values','Values 4','0000-00-00 00:00:00'),(35,'9','TLE','Sample Ni Marzan','2019-04-19 04:54:19'),(37,'8','Science','a','2019-04-21 18:42:22'),(39,'7','Filipino','aaaa','2019-04-23 15:41:04'),(40,'7','Filipino','cccc','2019-04-23 15:41:33');
/*!40000 ALTER TABLE `subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `treasurer`
--

DROP TABLE IF EXISTS `treasurer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `treasurer` (
  `tr_id` int(12) NOT NULL AUTO_INCREMENT,
  `tr_fname` varchar(45) NOT NULL,
  `tr_midname` varchar(45) NOT NULL,
  `tr_lname` varchar(45) NOT NULL,
  `tr_sy` year(4) NOT NULL,
  `acc_trid` int(13) NOT NULL,
  PRIMARY KEY (`tr_id`),
  KEY `tr_acc_idx` (`acc_trid`),
  CONSTRAINT `tr_acc` FOREIGN KEY (`acc_trid`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `treasurer`
--

LOCK TABLES `treasurer` WRITE;
/*!40000 ALTER TABLE `treasurer` DISABLE KEYS */;
INSERT INTO `treasurer` VALUES (1,'Dom Christian Jay','Fernandez','Nimes',2019,5);
/*!40000 ALTER TABLE `treasurer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-04-26  0:36:13
