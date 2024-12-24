-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: client_payroll
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(55) NOT NULL,
  `usertype` varchar(255) DEFAULT NULL,
  `updationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','d00f5d5217896fb7fd601412cb890830','Dogoy','admin@mail.com','Admin','2024-03-31 10:04:09'),(5,'test','827ccb0eea8a706c4c34a16891f84e7b','test','test@test.com','Admin','2024-03-31 10:04:09'),(7,'dd','827ccb0eea8a706c4c34a16891f84e7b','dd','dd@gmail.com','SuperVisor','2024-03-31 10:13:41'),(8,'rajeshhts','d00f5d5217896fb7fd601412cb890830','RAJESH ROSHAN','kumar.rishav92@gmail.com','SuperVisor','2024-03-31 10:28:29'),(9,'Viswajeet','f4d86f43bee27644b0422cd84fffd633','VISWAJEET ','kumar.rishav92@gmail.com','SuperVisor','2024-03-31 10:59:55');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `employee_id` int NOT NULL,
  `daysWorked` int NOT NULL,
  `overTime` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `tblemployees` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comissionData`
--

DROP TABLE IF EXISTS `comissionData`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comissionData` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payrollMonth` varchar(50) DEFAULT NULL,
  `totalDaysWorkedSkilled` varchar(200) DEFAULT NULL,
  `totalDaysWorkedUnskilled` varchar(200) DEFAULT NULL,
  `rateSkilled` varchar(200) DEFAULT NULL,
  `rateUnskilled` varchar(200) DEFAULT NULL,
  `totalAmountSkilled` varchar(200) DEFAULT NULL,
  `totalAmountUnskilled` varchar(200) DEFAULT NULL,
  `supplierPersonalAmountCredited` varchar(200) DEFAULT NULL,
  `supplierPersonalGroupCosting` varchar(200) DEFAULT NULL,
  `netAmount` varchar(200) DEFAULT NULL,
  `totalSkilledEmployees` varchar(200) DEFAULT NULL,
  `totalUnskilledEmployees` varchar(200) DEFAULT NULL,
  `supplierName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comissionData`
--

LOCK TABLES `comissionData` WRITE;
/*!40000 ALTER TABLE `comissionData` DISABLE KEYS */;
/*!40000 ALTER TABLE `comissionData` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_counter`
--

DROP TABLE IF EXISTS `group_counter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group_counter` (
  `supplier_id` int NOT NULL,
  `counter` int DEFAULT '0',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_counter`
--

LOCK TABLES `group_counter` WRITE;
/*!40000 ALTER TABLE `group_counter` DISABLE KEYS */;
INSERT INTO `group_counter` VALUES (1,2),(2,1),(3,1);
/*!40000 ALTER TABLE `group_counter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payroll`
--

DROP TABLE IF EXISTS `payroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payroll` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payroll`
--

LOCK TABLES `payroll` WRITE;
/*!40000 ALTER TABLE `payroll` DISABLE KEYS */;
INSERT INTO `payroll` VALUES (1,'PAYROLL_65E53F3F','2023-01-01','2023-01-30','2024-03-04 03:25:51','2024-03-04 03:25:51'),(2,'PAYROLL_6606E571','2024-03-01','2024-03-31','2024-03-29 15:59:45','2024-03-29 15:59:45');
/*!40000 ALTER TABLE `payroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payslip`
--

DROP TABLE IF EXISTS `payslip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payslip` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siteSelect` varchar(255) DEFAULT NULL,
  `employeeSelect` varchar(255) DEFAULT NULL,
  `rateDisplay` varchar(200) DEFAULT NULL,
  `daysWorked` decimal(10,0) DEFAULT NULL,
  `overTime` varchar(200) DEFAULT NULL,
  `totalAmountDisplay` varchar(200) DEFAULT NULL,
  `advance_in_site` decimal(10,2) DEFAULT NULL,
  `advance_in_home` decimal(10,2) DEFAULT NULL,
  `mess` decimal(10,2) DEFAULT NULL,
  `sunday_expenditure` decimal(10,2) DEFAULT NULL,
  `penalty` varchar(200) DEFAULT NULL,
  `net_pay` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payrollID` int DEFAULT NULL,
  `payrollMonth` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_payroll` (`payrollID`),
  CONSTRAINT `fk_payroll` FOREIGN KEY (`payrollID`) REFERENCES `payroll` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payslip`
--

LOCK TABLES `payslip` WRITE;
/*!40000 ALTER TABLE `payslip` DISABLE KEYS */;
INSERT INTO `payslip` VALUES (1,'2','1','600',23,'8','13800',5000.00,3000.00,2400.00,1200.00,'0','2600','2024-03-04 03:28:58',1,'January 2023'),(2,'2','4','',30,'0','',5000.00,2000.00,1200.00,2400.00,'0','-10600','2024-03-04 03:34:11',1,'January 2023'),(3,'3','5','700',-10,'2','7000',211.00,21.00,21.00,12.00,'0','6851.666666666667','2024-03-14 09:24:39',1,'January 2023'),(4,'4','2','800',30,'8','24000',1000.00,4000.00,2400.00,1200.00,'0','15933.333333333332','2024-03-14 10:21:53',1,'January 2023'),(5,'3','3','700',30,'8','21000',1000.00,1000.00,3200.00,1200.00,'2500','12566.666666666668','2024-03-14 10:30:15',1,'January 2023'),(8,'2','8','600 ',25,'6','15000.00',1000.00,7000.00,1200.00,1000.00,'10','5090.00','2024-03-20 16:58:35',1,'January 2023'),(13,'2','7','123',20,'2','2460',2.00,2.00,2.00,2.00,'0','2472.5','2024-03-24 12:39:58',1,'January 2023'),(14,'2','1','600  ',15,'10','9000',1200.00,0.00,2400.00,1200.00,'0','4700','2024-03-29 16:04:49',2,'March 2024'),(15,'2','9','500',30,'0','15000',3000.00,4000.00,1400.00,1200.00,'0','5400','2024-03-29 16:15:56',2,'March 2024'),(16,'2','10','500',25,'12','12500',1000.00,2000.00,2400.00,2000.00,'0','5600','2024-03-29 16:16:29',2,'March 2024'),(17,'2','11','500',12,'0','6000',2000.00,7000.00,2400.00,2000.00,'3500','-10900','2024-03-29 16:17:08',2,'March 2024'),(18,'2','12','600',28,'0','16800',1400.00,3000.00,2400.00,1200.00,'0','8800','2024-03-29 16:17:53',2,'March 2024'),(19,'2','13','600',23,'0','13800',1000.00,2000.00,0.00,1200.00,'0','9600','2024-03-29 16:18:24',2,'March 2024'),(20,'2','14','500',26,'0','13000',2000.00,1200.00,2400.00,1200.00,'2400','3800','2024-03-29 16:18:56',2,'March 2024'),(21,'2','15','550',30,'20','16500',4000.00,4000.00,2400.00,1200.00,'0','5816.666666666668','2024-03-29 16:19:23',2,'March 2024');
/*!40000 ALTER TABLE `payslip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbldesignation`
--

DROP TABLE IF EXISTS `tbldesignation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbldesignation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbldesignation`
--

LOCK TABLES `tbldesignation` WRITE;
/*!40000 ALTER TABLE `tbldesignation` DISABLE KEYS */;
INSERT INTO `tbldesignation` VALUES (1,'MASON','skilled','2024-03-04 03:05:35'),(2,'MASON HELPER','unskilled','2024-03-04 03:05:46'),(3,'CHIPPER','skilled','2024-03-04 03:05:57'),(4,'SUPERVISOR','skilled','2024-03-04 03:06:09'),(5,'SENIOR SUPERVISOR','skilled','2024-03-04 03:06:20'),(6,'FITTER','skilled','2024-03-04 03:06:58'),(7,'FITTER HELPER','unskilled','2024-03-04 03:07:07');
/*!40000 ALTER TABLE `tbldesignation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblemployees`
--

DROP TABLE IF EXISTS `tblemployees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblemployees` (
  `id` int NOT NULL AUTO_INCREMENT,
  `EmpId` varchar(100) NOT NULL,
  `FirstName` varchar(150) NOT NULL,
  `LastName` varchar(150) NOT NULL,
  `Gender` varchar(100) NOT NULL,
  `Dob` varchar(100) NOT NULL,
  `doj` varchar(200) NOT NULL,
  `govID` varchar(200) NOT NULL,
  `rate` varchar(200) NOT NULL,
  `Status` int NOT NULL,
  `Site` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `group_id` int DEFAULT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `designation` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Site` (`Site`),
  KEY `fk_supplier` (`supplier_id`),
  KEY `fk_group` (`group_id`),
  KEY `fk_designation` (`designation`),
  CONSTRAINT `fk_designation` FOREIGN KEY (`designation`) REFERENCES `tbldesignation` (`id`),
  CONSTRAINT `fk_group` FOREIGN KEY (`group_id`) REFERENCES `tblgroup` (`id`),
  CONSTRAINT `FK_Site` FOREIGN KEY (`Site`) REFERENCES `tblsite` (`id`),
  CONSTRAINT `fk_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `tblsupplier` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblemployees`
--

LOCK TABLES `tblemployees` WRITE;
/*!40000 ALTER TABLE `tblemployees` DISABLE KEYS */;
INSERT INTO `tblemployees` VALUES (1,'202403001','SHIV SHANKAR ','MANJHI','Male','1983-01-01','2023-01-01','1234567890','600',0,2,1,1,'2024-03-29 16:04:32',1),(2,'202403002','NEPAL ','MAHTO','Male','1983-01-01','2023-01-01','2345678901','800',1,4,1,1,'2024-03-04 03:14:07',3),(3,'202403003','BANSHI ','MAHTO','Male','1983-01-01','2023-01-01','3456789012','700',0,3,1,1,'2024-03-14 10:29:50',6),(4,'202403004','ROBIN ','MANDAL','Male','1992-01-01','2023-01-01','4567890123','',0,2,1,1,'2024-03-04 03:34:06',2),(5,'202403005','KALI ','TUDU','Male','1993-01-01','2023-01-01','5678801234','700',1,3,1,1,'2024-03-04 03:23:41',1),(6,'202403006','Rishav','kumar','Male','1996-01-03','2023-01-01','20346797660','1000',1,4,1,1,'2024-03-20 15:53:14',5),(7,'202403007','nassour ','h','Male','2023-12-01','2024-03-20','1234','123',1,2,1,1,'2024-03-20 16:53:45',1),(8,'202403008','RAJESH ','ROSHAN','Male','1996-01-01','2023-01-01','0987890123123','600',1,2,1,1,'2024-03-20 16:58:00',4),(9,'202403009','SOM ','MARANDI','Male','','2024-03-29','721587226082','500',1,2,1,2,'2024-03-29 15:48:48',2),(10,'202403010','LUKHIN ','MARANDI','Male','','2024-03-29','615407026301','500',1,2,1,2,'2024-03-29 16:16:26',2),(11,'202403011','DHARMENDRA ','HEMBROM','Male','','2024-03-29','748177758568','500',0,2,1,2,'2024-03-29 16:16:57',2),(12,'202403012','VIJAY ','MARANDI','Male','','2024-03-29','556518980579','600',1,2,1,2,'2024-03-29 15:53:13',1),(13,'202403013','SHIVDHAN ','BASKI','Male','','2024-03-29','286468655412','600',1,2,1,2,'2024-03-29 15:53:56',1),(14,'202403014','SURESH','SOREN','Male','','2024-03-29','978707738137','500',0,2,1,2,'2024-03-29 16:18:46',2),(15,'202403015','DEVENDRA ','MARIK','Male','','2024-03-29','547894578678','550',1,2,1,2,'2024-03-29 15:55:35',3),(16,'202403016','ANARJIT ','KAPRI','Male','','2023-01-01','380830755736','600',1,2,1,1,'2024-03-29 17:29:35',1),(17,'202403017','ANIL','PUJHAR','Male','','2023-12-01','650010970186','500',1,2,1,1,'2024-03-29 17:40:26',2),(18,'202403018','ARVIND ','RAY','Male','','2023-12-01','533523121339','600',1,2,1,1,'2024-03-29 17:51:06',1),(19,'202403019','AVIDHAN MURMU','MURMU','Male','','2024-01-01','911709703571','566',1,2,1,1,'2024-03-29 17:51:55',3),(20,'202403020','BABLOO ','PUJHAR','Male','','2024-01-05','732060393228','600',1,2,1,1,'2024-03-29 17:52:58',1),(21,'202403021','BABLOO','MURMU','','','2023-01-01','812606571409','600',1,2,1,1,'2024-03-29 17:55:15',1),(22,'202403022','BAJO','SAH','Male','','2023-12-01','573219011969','500',1,2,1,1,'2024-03-29 17:55:54',2),(23,'202403023','BHIM','GIRI','Male','','2023-12-12','854340152179','500',1,2,1,1,'2024-03-29 17:56:52',2),(24,'202403024','BHIM PRAKASH','RAY','','','2023-12-01','708493545464','600',1,2,1,1,'2024-03-29 17:57:37',1),(25,'202403025','BHUTKA','RAY','Male','','2023-12-01','606150569151','500',1,2,1,1,'2024-03-29 17:59:35',2),(26,'202403026','BIKRAM PRASAD ','RAY','Male','','2023-12-11','525522512630','600',1,2,1,1,'2024-03-29 18:03:08',1),(27,'202403027','BINOD','HANSDA','Male','','2023-12-01','378965133120','500',1,2,1,1,'2024-03-29 18:04:09',2),(28,'202403028','BULESH','BAIDYA','Male','','2023-12-01','514452450840','600',1,2,1,1,'2024-03-29 18:05:08',1),(29,'202403029','DASHRATH ','MAL','Male','','2023-12-01','824797313598','600',1,2,1,1,'2024-03-29 18:06:05',1),(30,'202403030','DEVEN','MARANDI','Male','','2023-12-01','221181248840','500',1,2,1,1,'2024-03-29 18:06:55',2),(31,'202403031','DIPAK KUMAR ','MAHTO','Male','','2023-12-01','698807445548','600',1,2,1,1,'2024-03-29 18:08:44',4),(32,'202403032','DUKHU','RAY','Male','','2023-11-01','634474319976','600',1,2,1,1,'2024-03-29 18:09:42',1),(33,'202403033','GANESH ','KISKU','Male','','2023-12-01','349570272210','500',1,2,1,1,'2024-03-29 18:10:34',2),(34,'202403034','GHANGHARU','RAY','Male','','2023-12-01','758252449315','600',1,2,1,1,'2024-03-29 18:11:28',1),(35,'202403035','GOPAL','RAY','Male','','2023-12-01','963836737445','600',1,2,1,1,'2024-03-29 18:12:06',1),(36,'202403036','JAYNATH','MARIK','Male','','2023-12-01','219727277540','500',1,2,1,1,'2024-03-29 18:20:00',2),(37,'202403037','KALIPAD','RAY','Male','','2023-12-01','435653897268','600',1,2,1,1,'2024-03-29 18:22:32',1),(38,'202403038','KAMAL','GORAI','Male','','2023-12-11','279428859494','500',1,2,1,1,'2024-03-29 18:23:29',2),(39,'202403039','LAKHAN ','RAY','Male','','2023-12-11','627586871144','500',1,2,1,1,'2024-03-29 18:25:42',1),(40,'202403040','LAXMAN','HANSDA','Male','','2023-12-11','840284339163','600',1,2,1,1,'2024-03-29 18:26:28',1),(41,'202403041','MAHABIR ','MANJHI','Male','','2023-12-01','428882422942','500',1,2,1,1,'2024-03-31 03:38:59',2),(42,'202403042','MANGAL','MARANDI','Male','','2023-12-01','734885934187','500',1,2,1,1,'2024-03-31 03:40:23',2),(43,'202403043','MANOJ ','SOREN','Male','','2023-12-12','683405769435','',1,2,1,1,'2024-03-31 03:41:41',1),(44,'202403044','MISTREE','MURMU','Male','','20233-12-01','373567683753','600',1,2,1,1,'2024-03-31 03:42:31',1),(45,'202403045','MOHAN KUMAR ','MANJHI','Male','','2023-11-12','418972777560','600',1,2,1,1,'2024-03-31 03:43:27',1),(46,'202403046','MOTILAL','SOREN','Male','','2023-09-12','529056927561','600',1,2,1,1,'2024-03-31 03:44:20',1),(47,'202403047','MUKESH','MURMU','Male','','2023-05-12','229433410641','600',1,2,1,1,'2024-03-31 03:45:21',1),(48,'202403048','PANDESHWAR','MANJHI','Male','','2023-12-12','420767272035','533',1,2,1,1,'2024-03-31 03:47:32',3),(49,'202403049','PARMESHWAR ','MIRDHA','Male','','2023-12-11','924528138361','500',1,2,1,1,'2024-03-31 03:48:34',2),(50,'202403050','PERU','PUJHAR','Male','','2023-02-12','712872604666','600',1,2,1,1,'2024-03-31 03:49:29',1),(51,'202403051','PARDESHI ','MIRDHA','Male','','2023-11-12','557918770074','533',1,2,1,1,'2024-03-31 03:50:44',3),(52,'202403052','RAJENDRA ','TUDU','Male','','2023-11-12','920869962387','600',1,2,1,1,'2024-03-31 03:58:48',1),(53,'202403053','RAMJIT ','SOREN','Male','','2023-11-11','892594579706','600',1,2,1,1,'2024-03-31 03:59:30',1),(54,'202403054','RAMNATH','RAI','Male','','2023-02-11','631536373423','600',1,2,1,1,'2024-03-31 04:00:47',1),(55,'202403055','RAMU','PUJHAR','Male','','2023-02-11','508391933174','500',1,2,1,1,'2024-03-31 04:53:52',2),(56,'202403056','RANJIT','TUDU','Male','','2023-11-12','545140510939','533',1,2,1,1,'2024-03-31 04:54:32',3),(57,'202403057','RABI','LAYAK','Male','','2023-09-15','446120364709','600',1,2,1,1,'2024-03-31 04:55:28',1),(58,'202403058','RABINDRA','HEMBRAM','Male','','2023-11-09','424032174156','533',1,2,1,1,'2024-03-31 04:56:39',3),(59,'202403059','ROHIT ','BASKI','Male','','2023-12-11','847735732727','500',1,2,1,1,'2024-03-31 04:57:40',2),(60,'202403060','ROHIT ','MAHTO','Male','','2023-12-11','263915501198','600',1,2,1,1,'2024-03-31 04:58:32',4),(61,'202403061','SAGAR','DAS','Male','','2023-02-11','592508134558','600',1,2,1,1,'2024-03-31 04:59:32',1),(62,'202403062','SAROJ ','PODDAR','Male','','2023-02-11','684220094192','500',1,2,1,1,'2024-03-31 05:00:23',2),(63,'202403063','SEVA','PUJHAR','Male','','2023-12-11','9864460398892','500',1,2,1,1,'2024-03-31 05:01:18',2),(64,'202403064','SHIVDHAN ','TUDU','Male','','2023-12-11','392274520828','500',1,2,1,1,'2024-03-31 05:02:42',2),(65,'202403065','SHIVDHAN ','MURMU','Male','','2023-11-12','836948990485','533',1,2,1,1,'2024-03-31 05:03:52',3),(66,'202403066','SOM','SOREN','Male','','2023-12-11','786341232478','600',1,2,1,1,'2024-03-31 05:04:32',1),(67,'202403067','SOMAY','SOREN','Male','','2023-12-11','271685215151','600',1,2,1,1,'2024-03-31 05:05:45',1),(68,'202403068','SUNIL','MARANDI','Male','','2023-12-11','869658656569','500',1,2,1,1,'2024-03-31 05:07:15',2),(69,'202403069','SUNIL ','MIRDHA','Male','','2023-12-11','947194472075','500',1,2,1,1,'2024-03-31 05:08:39',2),(70,'202403070','SUNIRAM ','TUDU','Male','','2023-12-11','309572823725','500',1,2,1,1,'2024-03-31 05:09:23',2),(71,'202403071','SURESH','RAY','Male','','2023-12-11','616071889900','500',1,2,1,1,'2024-03-31 05:10:43',2),(72,'202403072','UGAN ','PUJHAR','Male','','2023-12-11','998325871958','533',1,2,1,1,'2024-03-31 05:11:58',3),(73,'202403073','VIKASH ','KUMAR','Male','','2023-12-11','394743635657','500',1,2,1,1,'2024-03-31 05:12:47',2),(74,'202403074','BINOD','MAHTO','Male','','2023-12-12','947790301906','500',1,2,1,1,'2024-03-31 05:13:42',2),(75,'202403075','JOSHA','MARANDI','Male','','2024-02-05','645832776280','600',1,1,2,4,'2024-03-31 10:44:10',1),(76,'202403076','BHOMBHA ','NAYAK','Male','','2024-02-05','855883271519','600',1,1,2,4,'2024-03-31 10:47:19',1),(77,'202403077','RAJU ','MURMU','Male','','2024-02-05','322721326219','600',1,1,2,4,'2024-03-31 10:48:24',1),(78,'202403078','PRAMESHWAR ','PRAMESHWAR MURMU','Male','','2024-02-03','285630601831','600',1,1,2,4,'2024-03-31 10:49:30',1),(79,'202403079','ANIL ','TUDU','Male','','2024-02-02','591358829102','600',1,1,2,4,'2024-03-31 10:50:32',1),(80,'202403080','SUNIL','MARANDI','Male','','2024-02-05','331228929862','500',1,1,2,4,'2024-03-31 10:52:49',2),(81,'202403081','JHOPAR','TUDU','Male','','2024-02-05','795312313720','500',1,1,2,4,'2024-03-31 10:53:39',2),(82,'202403082','MUNSHI ','MURMU','Male','','2024-02-05','202383651717','500',1,1,2,4,'2024-03-31 10:54:40',2),(83,'202403083','RAASIKLAL ','MARANDI','Male','','2024-02-05','718435848105','500',1,1,2,4,'2024-03-31 10:55:33',2),(84,'202403084','SOMARA ','MURMU','Male','','2024-02-05','850644776801','500',1,1,2,4,'2024-03-31 10:56:19',2),(85,'202403085','MUNNA ','NAYAK','Male','','2024-02-05','867362785955','500',1,1,2,4,'2024-03-31 10:57:07',2),(86,'202403086','LAKHAN ','KISKU','Male','','2024-02-05','550598513657','500',1,1,2,4,'2024-03-31 10:57:52',2);
/*!40000 ALTER TABLE `tblemployees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblgroup`
--

DROP TABLE IF EXISTS `tblgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblgroup` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `totalHomeAdvance` decimal(10,2) DEFAULT NULL,
  `trainAllowance` decimal(10,2) DEFAULT NULL,
  `travelCost` decimal(10,2) DEFAULT NULL,
  `fooding` decimal(10,2) DEFAULT NULL,
  `trainTicketCost` decimal(10,2) DEFAULT NULL,
  `personalCosting` decimal(10,2) DEFAULT NULL,
  `others` decimal(10,2) DEFAULT NULL,
  `totalCreditedAmount` varchar(200) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblgroup`
--

LOCK TABLES `tblgroup` WRITE;
/*!40000 ALTER TABLE `tblgroup` DISABLE KEYS */;
INSERT INTO `tblgroup` VALUES (1,'DILIP_MAHTO_Group_0001',1,41800.00,7000.00,8000.00,4000.00,9060.00,7000.00,7000.00,'135000','2024-03-04 03:01:37'),(2,'DILIP_MAHTO_Group_0002',1,0.00,0.00,0.00,0.00,4550.00,0.00,0.00,'41000','2024-03-28 17:25:03'),(3,'CHANDAN_SINGH_Group_0001',3,10.00,10.00,10.00,10.00,10.00,10.00,10.00,'10','2024-03-31 08:45:20'),(4,'MANTU_SINGH_Group_0001',2,10.00,10.00,10.00,10.00,10.00,10.00,10.00,'10','2024-03-31 08:45:58');
/*!40000 ALTER TABLE `tblgroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblleaves`
--

DROP TABLE IF EXISTS `tblleaves`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblleaves` (
  `id` int NOT NULL AUTO_INCREMENT,
  `LeaveType` varchar(110) NOT NULL,
  `ToDate` varchar(120) NOT NULL,
  `FromDate` varchar(120) NOT NULL,
  `Description` mediumtext NOT NULL,
  `PostingDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `AdminRemark` mediumtext,
  `AdminRemarkDate` varchar(120) DEFAULT NULL,
  `Status` int NOT NULL,
  `IsRead` int NOT NULL,
  `empid` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `UserEmail` (`empid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblleaves`
--

LOCK TABLES `tblleaves` WRITE;
/*!40000 ALTER TABLE `tblleaves` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblleaves` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblleavetype`
--

DROP TABLE IF EXISTS `tblleavetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblleavetype` (
  `id` int NOT NULL AUTO_INCREMENT,
  `LeaveType` varchar(200) DEFAULT NULL,
  `Description` mediumtext,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblleavetype`
--

LOCK TABLES `tblleavetype` WRITE;
/*!40000 ALTER TABLE `tblleavetype` DISABLE KEYS */;
/*!40000 ALTER TABLE `tblleavetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsite`
--

DROP TABLE IF EXISTS `tblsite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblsite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(150) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `CreationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsite`
--

LOCK TABLES `tblsite` WRITE;
/*!40000 ALTER TABLE `tblsite` DISABLE KEYS */;
INSERT INTO `tblsite` VALUES (1,'CMRL ECV03','CHENNAI','2024-03-04 03:09:35'),(2,'HTS','Koodumkulam ','2024-03-04 03:09:46'),(3,'MAIN PLANT','Koodumkulam ','2024-03-04 03:09:58'),(4,'CMRL ECV02','CHENNAI','2024-03-04 03:10:45');
/*!40000 ALTER TABLE `tblsite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tblsupplier`
--

DROP TABLE IF EXISTS `tblsupplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tblsupplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tblsupplier`
--

LOCK TABLES `tblsupplier` WRITE;
/*!40000 ALTER TABLE `tblsupplier` DISABLE KEYS */;
INSERT INTO `tblsupplier` VALUES (1,'DILIP MAHTO','2024-03-04 02:57:33'),(2,'MANTU SINGH','2024-03-04 02:57:43'),(3,'CHANDAN SINGH','2024-03-31 08:42:24');
/*!40000 ALTER TABLE `tblsupplier` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-24  9:55:57
