-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: wbs_db
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `barangay` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'San Aquilino'),(2,'Victoria'),(3,'San Miguel'),(4,'Libertad'),(5,'Little Tanauan'),(6,'San Mariano'),(7,'Mabuhay'),(8,'San Rafael'),(9,'San Vicente'),(10,'Happy Valley'),(11,'Cantil'),(12,'Dangay'),(13,'Bagumbayan'),(14,'Paclasan'),(15,'Odiong'),(16,'Uyao'),(17,'Dalahican'),(18,'Libtong'),(19,'San Isidro'),(20,'San Vicente'),(21,'San Jose'),(22,'Maraska');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `billing_data`
--

DROP TABLE IF EXISTS `billing_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `billing_id` varchar(50) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `meter_number` varchar(50) NOT NULL,
  `prev_reading` decimal(7,2) NOT NULL DEFAULT 0.00,
  `curr_reading` decimal(7,2) NOT NULL DEFAULT 0.00,
  `reading_type` varchar(20) DEFAULT NULL,
  `consumption` decimal(7,2) NOT NULL DEFAULT 0.00,
  `rates` decimal(7,2) NOT NULL DEFAULT 0.00,
  `billing_amount` decimal(7,2) NOT NULL DEFAULT 0.00,
  `billing_status` enum('paid','unpaid') DEFAULT NULL,
  `billing_type` enum('initial','actual','late') NOT NULL DEFAULT 'initial',
  `billing_month` varchar(20) NOT NULL,
  `due_date` date DEFAULT NULL,
  `disconnection_date` date DEFAULT NULL,
  `period_to` date DEFAULT NULL,
  `period_from` date DEFAULT NULL,
  `encoder` varchar(20) NOT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_data`
--

LOCK TABLES `billing_data` WRITE;
/*!40000 ALTER TABLE `billing_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `billing_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER billing_data_after_insert
AFTER INSERT ON billing_data
FOR EACH ROW
BEGIN
    INSERT INTO log_changes (table_name, action) VALUES ('billing_data', 'INSERT');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER billing_data_after_update
AFTER UPDATE ON billing_data
FOR EACH ROW
BEGIN
    INSERT INTO log_changes (table_name, action) VALUES ('billing_data', 'UPDATE');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `client_application`
--

DROP TABLE IF EXISTS `client_application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meter_number` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `name_suffix` varchar(20) DEFAULT NULL,
  `full_name` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `birthdate` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `property_type` varchar(15) NOT NULL,
  `street` text NOT NULL,
  `brgy` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `province` varchar(20) NOT NULL,
  `region` varchar(50) NOT NULL,
  `full_address` text NOT NULL,
  `valid_id` varchar(10) NOT NULL,
  `proof_of_ownership` varchar(10) NOT NULL,
  `deed_of_sale` varchar(10) NOT NULL,
  `affidavit` varchar(10) NOT NULL,
  `status` varchar(20) NOT NULL,
  `billing_status` enum('paid','unpaid') NOT NULL,
  `application_id` varchar(50) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`,`first_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_application`
--

LOCK TABLES `client_application` WRITE;
/*!40000 ALTER TABLE `client_application` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_application` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER client_application_after_insert
AFTER INSERT ON client_application
FOR EACH ROW
BEGIN
    INSERT INTO log_changes (table_name, action) VALUES ('client_application', 'INSERT');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER client_application_after_update
AFTER UPDATE ON client_application
FOR EACH ROW
BEGIN
    INSERT INTO log_changes (table_name, action) VALUES ('client_application', 'UPDATE');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `client_application_fees`
--

DROP TABLE IF EXISTS `client_application_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_application_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_fee` decimal(7,2) NOT NULL,
  `inspection_fee` decimal(7,2) NOT NULL,
  `registration_fee` decimal(7,2) NOT NULL,
  `connection_fee` decimal(7,2) NOT NULL,
  `installation_fee` decimal(7,2) NOT NULL,
  `reference_id` varchar(20) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_application_fees`
--

LOCK TABLES `client_application_fees` WRITE;
/*!40000 ALTER TABLE `client_application_fees` DISABLE KEYS */;
INSERT INTO `client_application_fees` VALUES (1,55.00,55.00,55.00,55.00,5.00,'ADMIN_01','00:19:03','2023-10-30','2023-10-29 16:19:03'),(2,45.50,4.00,4.00,4.00,4.00,'ADMIN_01','00:21:27','2023-10-30','2023-10-29 16:21:27'),(3,45.89,4.00,4.00,4.00,4.00,'ADMIN_01','00:21:42','2023-10-30','2023-10-29 16:21:42');
/*!40000 ALTER TABLE `client_application_fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_data`
--

DROP TABLE IF EXISTS `client_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(20) NOT NULL,
  `reg_id` varchar(50) NOT NULL,
  `meter_number` varchar(20) NOT NULL,
  `full_name` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `birthdate` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `property_type` varchar(15) NOT NULL,
  `street` text NOT NULL,
  `brgy` varchar(20) NOT NULL,
  `full_address` text NOT NULL,
  `status` varchar(20) NOT NULL,
  `reading_status` varchar(20) NOT NULL,
  `application_id` varchar(50) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_data`
--

LOCK TABLES `client_data` WRITE;
/*!40000 ALTER TABLE `client_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_data` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER client_data_after_insert
AFTER INSERT ON client_data
FOR EACH ROW
BEGIN
    INSERT INTO log_changes (table_name, action) VALUES ('client_data', 'INSERT');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER client_data_after_update
AFTER UPDATE ON client_data
FOR EACH ROW
BEGIN
    INSERT INTO log_changes (table_name, action) VALUES ('client_data', 'UPDATE');
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `client_secondary_data`
--

DROP TABLE IF EXISTS `client_secondary_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_secondary_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `name_suffix` varchar(20) NOT NULL,
  `property_type` varchar(50) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `street` varchar(50) NOT NULL,
  `brgy` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `valid_id` varchar(20) NOT NULL,
  `proof_of_ownership` varchar(20) NOT NULL,
  `deed_of_sale` varchar(20) NOT NULL,
  `affidavit` varchar(20) NOT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_secondary_data`
--

LOCK TABLES `client_secondary_data` WRITE;
/*!40000 ALTER TABLE `client_secondary_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `client_secondary_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients_archive`
--

DROP TABLE IF EXISTS `clients_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients_archive` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `prev_reading` int(55) DEFAULT NULL,
  `current_reading` int(55) DEFAULT NULL,
  `amount_due` int(55) DEFAULT NULL,
  `address` varchar(50) NOT NULL,
  `property_type` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1674 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients_archive`
--

LOCK TABLES `clients_archive` WRITE;
/*!40000 ALTER TABLE `clients_archive` DISABLE KEYS */;
INSERT INTO `clients_archive` VALUES (1448,'WBS01448','Louiella L. Delos Reyes',0,NULL,0,'Little Tanauan','Commercial','louiella.reyes7271@gmail.com','662-834-7438','2023-09-17 16:58:42'),(1527,'WBS01527','Jose W. James',0,NULL,0,'San Miguel','Residential','jose.james6498@hotmail.com','338-999-2544','2023-09-17 16:58:42'),(1532,'WBS01532','Lei B. Mayo',0,NULL,0,'San Vicente','Commercial','lei.mayo6816@hotmail.com','882-349-3600','2023-09-17 16:58:42'),(1534,'WBS01534','Jay J. Garcia',0,NULL,0,'Dangay','Residential','jay.garcia9507@yahoo.com','133-169-4792','2023-09-17 16:58:42'),(1537,'WBS01537','Leni Robredo',0,NULL,0,'Little Tanauan','Commercial','lei.robredo7549@hotmail.com','264-382-2066','2023-09-17 16:58:42'),(1538,'WBS01538','Jose E. Robles',0,NULL,0,'San Isidro','Commercial','jose.robles5700@yahoo.com','440-790-5861','2023-09-17 16:58:42'),(1540,'WBS01540','James C. Catapang',0,NULL,0,'Cantil','Residential','james.catapang3978@outlook.com','650-719-5844','2023-09-17 16:58:42'),(1541,'WBS01541','Jennifer I. Curry',0,NULL,0,'Libertad','Residential','jennifer.curry9561@gmail.com','903-234-2211','2023-09-17 16:58:42'),(1542,'WBS01542','James B. Richards',0,NULL,0,'San Vicente','Residential','james.richards5397@gmail.com','241-147-6028','2023-09-17 16:58:42'),(1544,'WBS01544','Louiella F. Dayanghirang',0,NULL,0,'Mabuhay','Commercial','louiella.dayanghirang8855@outlook.com','911-808-9691','2023-09-17 16:58:42'),(1545,'WBS01545','Lei H. Morales',0,NULL,0,'San Vicente','Residential','lei.morales9418@yahoo.com','902-592-4636','2023-09-17 16:58:42'),(1546,'WBS01546','Jep R. Paner',0,NULL,0,'Libtong','Commercial','jep.paner4335@gmail.com','707-213-5737','2023-09-17 16:58:42'),(1547,'WBS01547','Jep C. Dela Cruz',0,NULL,0,'San Rafael','Commercial','jep.cruz7466@yahoo.com','800-143-5042','2023-09-17 16:58:42'),(1549,'WBS01549','Nick W. Dayanghirang',0,NULL,0,'Dangay','Residential','nick.dayanghirang2077@yahoo.com','896-465-7490','2023-09-17 16:58:42'),(1550,'WBS01550','Juanita R. Catapang',0,NULL,0,'San Jose','Residential','juanita.catapang8924@hotmail.com','707-143-3490','2023-09-17 16:58:42'),(1551,'WBS01551','Jose Paolo X. Mayo',0,NULL,0,'Little Tanauan','Residential','jose.mayo9436@gmail.com','648-875-9373','2023-09-17 16:58:42'),(1552,'WBS01552','Ann C. Wade',0,NULL,0,'San Mariano','Commercial','ann.wade1695@hotmail.com','367-750-7212','2023-09-17 16:58:42'),(1553,'WBS01553','PJ F. Mayo',0,NULL,0,'Dangay','Residential','pj.mayo5319@gmail.com','129-198-3954','2023-09-17 16:58:42'),(1554,'WBS01554','Lebron L. Dayanghirang',0,NULL,0,'Maraska','Commercial','lebron.dayanghirang7197@outlook.com','252-709-7961','2023-09-17 16:58:42'),(1555,'WBS01555','Joy X. Garcia',0,NULL,0,'Victoria','Residential','joy.garcia1343@gmail.com','151-603-9179','2023-09-17 16:58:42'),(1556,'WBS01556','James W. Delos Reyes',0,NULL,0,'San Miguel','Residential','james.reyes7605@hotmail.com','876-602-8243','2023-09-17 16:58:42'),(1557,'WBS01557','Patricia W. Mayo',0,NULL,0,'Bagumbayan','Residential','patricia.mayo8840@outlook.com','691-768-8184','2023-09-17 16:58:42'),(1558,'WBS01558','Jeffry B. Delos Reyes',0,NULL,0,'Paclasan','Residential','jeffry.reyes5732@gmail.com','586-185-3336','2023-09-17 16:58:42'),(1559,'WBS01559','Jasper J. Robles',0,NULL,0,'San Mariano','Commercial','jasper.robles1766@gmail.com','795-246-8301','2023-09-17 16:58:42'),(1560,'WBS01560','Rogene V. Morales',0,NULL,0,'San Vicente','Residential','rogene.morales2756@hotmail.com','574-715-4896','2023-09-17 16:58:42'),(1561,'WBS01561','Nick J. Uvas',0,NULL,0,'San Jose','Residential','nick.uvas6276@hotmail.com','932-311-3253','2023-09-17 16:58:42'),(1562,'WBS01562','Patrick P. Jordan',0,NULL,0,'San Rafael','Residential','patrick.jordan7710@outlook.com','993-973-9079','2023-09-17 16:58:42'),(1563,'WBS01563','Jennifer T. Bryant',0,NULL,0,'Maraska','Commercial','jennifer.bryant1310@outlook.com','572-994-2561','2023-09-17 16:58:42'),(1564,'WBS01564','Nicpar C. Wade',0,NULL,0,'Uyao','Commercial','nicpar.wade6273@hotmail.com','172-560-7617','2023-09-17 16:58:42'),(1565,'WBS01565','Hannah I. Richards',0,NULL,0,'Victoria','Commercial','hannah.richards4992@yahoo.com','115-137-8757','2023-09-17 16:58:42'),(1566,'WBS01566','Jose Paolo T. Jordan',0,NULL,0,'Happy Valley','Commercial','jose.jordan2295@gmail.com','291-340-4637','2023-09-17 16:58:42'),(1567,'WBS01567','Ann L. Yap',0,NULL,0,'Little Tanauan','Residential','ann.yap3330@yahoo.com','130-380-5613','2023-09-17 16:58:42'),(1568,'WBS01568','Carl S. Garcia',0,NULL,0,'Uyao','Residential','carl.garcia8138@yahoo.com','931-879-9491','2023-09-17 16:58:42'),(1569,'WBS01569','Louiella I. Curry',0,NULL,0,'Maraska','Commercial','louiella.curry3337@hotmail.com','223-439-5835','2023-09-17 16:58:42'),(1570,'WBS01570','Joy A. Mayo',0,NULL,0,'Happy Valley','Residential','joy.mayo9268@yahoo.com','929-195-6579','2023-09-17 16:58:42'),(1571,'WBS01571','Hannah O. Dela Cruz',0,NULL,0,'San Aquilino','Residential','hannah.cruz1530@outlook.com','133-539-7749','2023-09-17 16:58:42'),(1572,'WBS01572','Kim V. Richards',0,NULL,0,'Mabuhay','Commercial','kim.richards2417@hotmail.com','140-153-9011','2023-09-17 16:58:42'),(1573,'WBS01573','Jay U. James',0,NULL,0,'Paclasan','Residential','jay.james5565@gmail.com','881-199-9298','2023-09-17 16:58:42'),(1574,'WBS01574','Joy T. Curry',0,NULL,0,'San Isidro','Residential','joy.curry5169@outlook.com','752-826-3130','2023-09-17 16:58:42'),(1575,'WBS01575','Cristel K. Racar',0,NULL,0,'San Aquilino','Residential','cristel.ortiz4403@outlook.com','142-405-8487','2023-09-17 16:58:42'),(1576,'WBS01576','Kim L. Mayo',0,NULL,0,'Maraska','Residential','kim.mayo6374@outlook.com','758-246-4901','2023-09-17 16:58:42'),(1577,'WBS01577','Patricia G. Robles',0,NULL,0,'Bagumbayan','Commercial','patricia.robles7686@hotmail.com','404-270-5146','2023-09-17 16:58:42'),(1578,'WBS01578','Jay Y. Catapang',0,NULL,0,'Paclasan','Commercial','jay.catapang9464@outlook.com','929-313-2068','2023-09-17 16:58:42'),(1579,'WBS01579','Jose Paolo C. Mayo',0,NULL,0,'Happy Valley','Commercial','jose.mayo5823@hotmail.com','569-978-3385','2023-09-17 16:58:42'),(1580,'WBS01580','Roderick N. Bryant',0,NULL,0,'San Miguel','Commercial','roderick.bryant5788@yahoo.com','803-266-9049','2023-09-17 16:58:42'),(1581,'WBS01581','Jennifer F. Catapang',0,NULL,0,'Libertad','Residential','jennifer.catapang7004@outlook.com','563-734-7630','2023-09-17 16:58:42'),(1582,'WBS01582','James Z. Robles',0,NULL,0,'Mabuhay','Commercial','james.robles6816@hotmail.com','315-947-7967','2023-09-17 16:58:42'),(1583,'WBS01583','Jose M. Castillo',0,NULL,0,'Paclasan','Commercial','jose.castillo4023@outlook.com','657-320-7634','2023-09-17 16:58:42'),(1584,'WBS01584','Hannah T. Lee',0,NULL,0,'Bagumbayan','Residential','hannah.lee1704@gmail.com','784-927-6592','2023-09-17 16:58:42'),(1585,'WBS01585','Rogene R. Garcia',0,NULL,0,'Dangay','Residential','rogene.garcia4779@yahoo.com','951-103-9247','2023-09-17 16:58:42'),(1586,'WBS01586','Jay A. Bryant',0,NULL,0,'San Aquilino','Commercial','jay.bryant7937@hotmail.com','474-314-5505','2023-09-17 16:58:42'),(1587,'WBS01587','PJ T. Garcia',0,NULL,0,'Bagumbayan','Residential','pj.garcia7535@yahoo.com','295-846-1983','2023-09-17 16:58:42'),(1588,'WBS01588','Jasper D. Dayanghirang',0,NULL,0,'San Jose','Commercial','jasper.dayanghirang2975@hotmail.com','239-445-9850','2023-09-17 16:58:42'),(1589,'WBS01589','Juanita L. Jordan',0,NULL,0,'San Rafael','Commercial','juanita.jordan5114@outlook.com','679-434-2015','2023-09-17 16:58:42'),(1590,'WBS01590','Patrick C. Dayanghirang',0,NULL,0,'Libertad','Commercial','patrick.dayanghirang2788@yahoo.com','826-815-5765','2023-09-17 16:58:42'),(1591,'WBS01591','Nick O. Robles',0,NULL,0,'Cantil','Commercial','nick.robles9316@gmail.com','792-240-3135','2023-09-17 16:58:42'),(1592,'WBS01592','Nick Y. Catapang',0,NULL,0,'San Aquilino','Residential','nick.catapang6946@yahoo.com','337-653-9211','2023-09-17 16:58:42'),(1593,'WBS01593','Kim U. Bryant',0,NULL,0,'San Mariano','Residential','kim.bryant9773@outlook.com','531-762-6201','2023-09-17 16:58:42'),(1594,'WBS01594','Joy S. Richards',0,NULL,0,'Little Tanauan','Commercial','joy.richards9472@yahoo.com','858-885-1672','2023-09-17 16:58:42'),(1595,'WBS01595','Nicpar O. James',0,NULL,0,'Maraska','Commercial','nicpar.james6465@hotmail.com','172-357-2206','2023-09-17 16:58:42'),(1596,'WBS01596','Hannah U. Yap',0,NULL,0,'San Mariano','Residential','hannah.yap2205@gmail.com','654-407-8288','2023-09-17 16:58:42'),(1597,'WBS01597','Jennifer K. Robles',0,NULL,0,'San Vicente','Residential','jennifer.robles1258@outlook.com','932-928-9603','2023-09-17 16:58:42'),(1598,'WBS01598','Lebron K. Festin',0,NULL,0,'Odiong','Commercial','lebron.festin1575@gmail.com','209-733-5319','2023-09-17 16:58:42'),(1599,'WBS01599','Jose Paolo K. Robles',0,NULL,0,'Uyao','Residential','jose.robles1109@hotmail.com','303-477-2651','2023-09-17 16:58:42'),(1600,'WBS01600','Hannah V. Wade',0,NULL,0,'Happy Valley','Commercial','hannah.wade5140@outlook.com','903-713-5843','2023-09-17 16:58:42'),(1602,'WBS01602','Jeffry T. Wade',0,NULL,0,'Odiong','Residential','jeffry.wade4157@outlook.com','865-271-3800','2023-09-17 16:58:42'),(1603,'WBS01603','Louiella C. Richards',0,NULL,0,'San Aquilino','Residential','louiella.richards6095@hotmail.com','845-838-2167','2023-09-17 16:58:42'),(1604,'WBS01604','Patrick I. Delos Reyes',0,NULL,0,'San Aquilino','Residential','patrick.reyes5602@outlook.com','979-346-9813','2023-09-17 16:58:42'),(1605,'WBS01605','Jose X. Jordan',0,NULL,0,'San Aquilino','Residential','jose.jordan3338@outlook.com','227-126-9411','2023-09-17 16:58:42'),(1606,'WBS01606','Hannah I. Bryant',0,NULL,0,'Uyao','Residential','hannah.bryant9232@outlook.com','240-454-8081','2023-09-17 16:58:42'),(1607,'WBS01607','Jasper M. Robles',0,NULL,0,'Cantil','Residential','jasper.robles1243@yahoo.com','419-242-5379','2023-09-17 16:58:42'),(1608,'WBS01608','Roderick A. James',0,NULL,0,'Victoria','Residential','roderick.james6557@yahoo.com','823-214-1817','2023-09-17 16:58:42'),(1610,'WBS01610','Mark C. Paner',0,NULL,0,'San Jose','Commercial','mark.paner8781@gmail.com','993-320-3061','2023-09-17 16:58:42'),(1611,'WBS01611','Jose Paolo S. Jordan',0,NULL,0,'Libertad','Commercial','jose.jordan5083@outlook.com','452-798-7327','2023-09-17 16:58:42'),(1614,'WBS01614','Roderick Q. Lee',0,NULL,0,'San Miguel','Commercial','roderick.lee8010@hotmail.com','473-560-9452','2023-09-17 16:58:42'),(1615,'WBS01615','Cristel F. James',0,NULL,0,'Little Tanauan','Commercial','cristel.james4341@gmail.com','830-269-1118','2023-09-17 16:58:42'),(1616,'WBS01616','Mark M. Festin',0,NULL,0,'Dangay','Commercial','mark.festin5031@hotmail.com','797-918-6814','2023-09-17 16:58:42'),(1617,'WBS01617','James F. Uvas',0,NULL,0,'Libertad','Residential','james.uvas3235@hotmail.com','357-649-4792','2023-09-17 16:58:42'),(1618,'WBS01618','Jose H. Morales',0,NULL,0,'Mabuhay','Commercial','jose.morales1255@gmail.com','345-242-4617','2023-09-17 16:58:42'),(1620,'WBS01620','Carl O. Wade',0,NULL,0,'Paclasan','Residential','carl.wade8543@gmail.com','639-754-8229','2023-09-17 16:58:42'),(1621,'WBS01621','Justine F. Morales',0,NULL,0,'Mabuhay','Commercial','justine.morales6565@hotmail.com','547-108-6775','2023-09-17 16:58:42'),(1622,'WBS01622','Hannah R. Paner',0,NULL,0,'Happy Valley','Commercial','hannah.paner7232@outlook.com','632-709-7889','2023-09-17 16:58:42'),(1625,'WBS01625','Jep H. Curry',0,NULL,0,'Libertad','Residential','jep.curry1512@outlook.com','801-715-8724','2023-09-17 16:58:42'),(1628,'WBS01628','Hannah U. Catapang',0,NULL,0,'Uyao','Commercial','hannah.catapang7800@hotmail.com','649-502-6350','2023-09-17 16:58:42'),(1629,'WBS01629','Jasper M. Paner',0,NULL,0,'Mabuhay','Residential','jasper.paner1667@yahoo.com','758-780-4169','2023-09-17 16:58:42'),(1631,'WBS01631','Carl V. Lee',0,NULL,0,'Little Tanauan','Residential','carl.lee5851@gmail.com','867-696-7264','2023-09-17 16:58:42'),(1673,'WBS01674','',NULL,NULL,NULL,'','Commercial','','','2023-09-22 00:59:46');
/*!40000 ALTER TABLE `clients_archive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_changes`
--

DROP TABLE IF EXISTS `log_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_changes`
--

LOCK TABLES `log_changes` WRITE;
/*!40000 ALTER TABLE `log_changes` DISABLE KEYS */;
INSERT INTO `log_changes` VALUES (1,'client_data','INSERT','2023-10-30 06:00:03'),(2,'client_application','UPDATE','2023-10-30 06:00:03'),(3,'billing_data','INSERT','2023-10-30 06:00:03');
/*!40000 ALTER TABLE `log_changes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(55) NOT NULL AUTO_INCREMENT,
  `log_id` varchar(50) NOT NULL,
  `user_role` varchar(55) NOT NULL,
  `user_name` varchar(55) NOT NULL,
  `user_activity` text NOT NULL,
  `client_id` int(50) NOT NULL,
  `description` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'SOAJJP20231030064355','Admin','Jeffry James Paner','Sign out',0,'Jeffry James Paner has been signed out.','2023-10-30','13:43:55','2023-10-30 13:43:55'),(2,'SICC20231030064401','Cashier','CASHIER','Sign in',0,'CASHIER has been signed in.','2023-10-30','13:44:01','2023-10-30 13:44:01'),(3,'SOCC20231030064501','Cashier','CASHIER','Sign out',0,'CASHIER has been signed out.','2023-10-30','13:45:01','2023-10-30 13:45:01'),(4,'SIAJJP20231030064505','Admin','Jeffry James Paner','Sign in',0,'Jeffry James Paner has been signed in.','2023-10-30','13:45:05','2023-10-30 13:45:05');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` enum('payment_confirmation','new_message','other') NOT NULL,
  `reference_id` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `read_at` datetime DEFAULT NULL,
  `status` enum('read','unread') DEFAULT 'unread',
  PRIMARY KEY (`id`),
  KEY `admin_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penalty_fees`
--

DROP TABLE IF EXISTS `penalty_fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penalty_fees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `late_payment_fee` decimal(7,2) NOT NULL,
  `disconnection_fee` decimal(7,2) NOT NULL,
  `reference_id` varchar(20) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penalty_fees`
--

LOCK TABLES `penalty_fees` WRITE;
/*!40000 ALTER TABLE `penalty_fees` DISABLE KEYS */;
INSERT INTO `penalty_fees` VALUES (1,2.00,2.00,'ADMIN_01','00:29:18','2023-10-30','2023-10-29 16:29:18');
/*!40000 ALTER TABLE `penalty_fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_type` varchar(50) NOT NULL,
  `rates` varchar(20) NOT NULL,
  `billing_month` varchar(20) NOT NULL,
  `reference_id` varchar(20) NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates`
--

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
INSERT INTO `rates` VALUES (1,'Commercial','2','October 2023','ADMIN_01','00:49:13','2023-10-30','2023-10-29 16:49:13'),(2,'Commercial','50','October 2023','ADMIN_01','00:50:12','2023-10-30','2023-10-29 16:50:12'),(3,'Residential','27','October 2023','ADMIN_01','00:50:34','2023-10-30','2023-10-29 16:50:34'),(4,'Residential','34','October 2023','ADMIN_01','00:52:02','2023-10-30','2023-10-29 16:52:02');
/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` varchar(255) NOT NULL,
  `reference_id` varchar(255) NOT NULL,
  `tansaction_type` enum('application_payment','bill_payment') NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_id`
--

DROP TABLE IF EXISTS `user_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_id` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_id`
--

LOCK TABLES `user_id` WRITE;
/*!40000 ALTER TABLE `user_id` DISABLE KEYS */;
INSERT INTO `user_id` VALUES (1),(2),(3),(4),(5),(6),(7);
/*!40000 ALTER TABLE `user_id` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='This is a table for users who use the system.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'ADMIN_01','Jeffry James Paner','Admin','jeffrypaner@gmail.com','jeffry123'),(2,'ADMIN_02','Rogene Vito','Meter Reader','meterreader@gmail.com','meterreader'),(3,'ADMIN_03','test','Admin','test','test'),(4,'ADMIN_04','Anthony Galang','Cashier','anthonygalang@gmail.com','anthony'),(5,'ADMIN_05','CASHIER','Cashier','cashier@gmail.com','cashier123'),(6,'ADMIN_06','rogene','Admin','rogene','rogene'),(7,'ADMIN_07','anthony','Admin','anthony','anthony');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `users` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
	INSERT INTO user_id VALUES (NULL);
    SET NEW.user_id = CONCAT("ADMIN_",
LPAD(LAST_INSERT_ID(), 2, "0"));
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-30 14:05:05
