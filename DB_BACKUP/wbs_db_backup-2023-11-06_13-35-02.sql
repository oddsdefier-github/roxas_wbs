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
  `brgy` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'San Aquilino'),(2,'Victoria'),(3,'San Miguel'),(4,'Libertad'),(5,'Little Tanauan'),(6,'San Mariano'),(7,'Mabuhay'),(8,'San Rafael'),(9,'San Vicente'),(10,'Happy Valley'),(11,'Cantil'),(12,'Dangay'),(13,'Bagumbayan'),(14,'Paclasan'),(15,'Odiong'),(16,'Uyao'),(17,'Dalahican'),(18,'Libtong'),(19,'San Isidro'),(21,'San Jose'),(22,'Maraska');
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
  `billing_type` enum('initial','unverified','verified','billed','paid','disputed','canceled','overdue') NOT NULL DEFAULT 'initial',
  `penalty` decimal(7,2) NOT NULL DEFAULT 0.00,
  `billing_month` varchar(20) NOT NULL,
  `due_date` date DEFAULT NULL,
  `disconnection_date` date DEFAULT NULL,
  `period_to` date DEFAULT NULL,
  `period_from` date DEFAULT NULL,
  `encoder` varchar(20) NOT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `billing_id` (`billing_id`),
  KEY `meter_number` (`meter_number`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_data`
--

LOCK TABLES `billing_data` WRITE;
/*!40000 ALTER TABLE `billing_data` DISABLE KEYS */;
INSERT INTO `billing_data` VALUES (1,'B-W-97315-1699196059','WBS-SKV-001110523','W-97315',0.00,0.00,'current',0.00,0.00,0.00,NULL,'initial',0.00,'November 2023',NULL,NULL,'2023-11-05','2023-11-05','ADMIN_01','22:54:19','2023-11-05','2023-11-05 14:54:19'),(2,'B-W-37553-1699196068','WBS-DSM-002110523','W-37553',0.00,0.00,'previous',0.00,0.00,0.00,NULL,'initial',0.00,'November 2023',NULL,NULL,'2023-11-05','2023-11-05','ADMIN_01','22:54:28','2023-11-05','2023-11-05 14:54:28'),(3,'B-W-13909-1699196141','WBS-KJH-003110523','W-13909',0.00,0.00,'previous',0.00,0.00,0.00,NULL,'initial',0.00,'November 2023',NULL,NULL,'2023-11-05','2023-11-05','ADMIN_01','22:55:41','2023-11-05','2023-11-05 14:55:41'),(4,'B-W-57599-1699196485','WBS-JDN-004110523','W-57599',0.00,0.00,'previous',0.00,0.00,0.00,NULL,'initial',0.00,'November 2023',NULL,NULL,'2023-11-05','2023-11-05','ADMIN_01','23:01:25','2023-11-05','2023-11-05 15:01:25'),(5,'B-W-57599-1699196683','WBS-JDN-004110523','W-57599',0.00,60.00,'current',60.00,346.00,20760.00,'paid','',0.00,'November 2023','2023-11-20','2023-12-20','2023-11-30','2023-11-06','Rogene Vito','23:04:43','2023-11-05','2023-11-05 15:04:43'),(6,'B-W-12323-1699203386','WBS-JMP-005110523','W-12323',0.00,0.00,'previous',0.00,0.00,0.00,NULL,'initial',0.00,'November 2023',NULL,NULL,'2023-11-05','2023-11-05','ADMIN_01','00:56:26','2023-11-06','2023-11-05 16:56:26'),(7,'B-W-85825-1699204349','WBS-MFS-006110523','W-85825',0.00,0.00,'previous',0.00,0.00,0.00,NULL,'initial',0.00,'November 2023',NULL,NULL,'2023-11-05','2023-11-05','ADMIN_01','01:12:29','2023-11-06','2023-11-05 17:12:29'),(11,'B-W-85825-1699244193','WBS-MFS-006110523','W-85825',0.00,1.00,'previous',1.00,346.00,346.00,'unpaid','initial',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-11-06','Rogene Vito','12:16:33','2023-11-06','2023-11-06 04:16:33'),(12,'B-W-85825-1699244876','WBS-MFS-006110523','W-85825',1.00,2.00,'previous',1.00,346.00,346.00,'unpaid','initial',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-12-01','Rogene Vito','12:27:56','2023-11-06','2023-11-06 04:27:56'),(13,'B-W-12323-1699245405','WBS-JMP-005110523','W-12323',0.00,2.00,'current',2.00,56.00,112.00,'unpaid','',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-11-06','Rogene Vito','12:36:45','2023-11-06','2023-11-06 04:36:45'),(14,'B-W-85825-1699245442','WBS-MFS-006110523','W-85825',2.00,3.00,'current',1.00,346.00,346.00,'unpaid','',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-12-01','Rogene Vito','12:37:22','2023-11-06','2023-11-06 04:37:22'),(15,'B-W-85825-1699245442','WBS-MFS-006110523','W-85825',2.00,3.00,'current',1.00,346.00,346.00,'unpaid','initial',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-12-01','Rogene Vito','12:37:22','2023-11-06','2023-11-06 04:37:22'),(16,'B-W-13909-1699245702','WBS-KJH-003110523','W-13909',0.00,2.00,'previous',2.00,346.00,692.00,'unpaid','',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-11-06','Rogene Vito','12:41:42','2023-11-06','2023-11-06 04:41:42'),(17,'B-W-13909-1699248896','WBS-KJH-003110523','W-13909',2.00,3.00,'current',1.00,346.00,346.00,'unpaid','unverified',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-12-01','Rogene Vito','13:34:56','2023-11-06','2023-11-06 05:34:56'),(18,'B-W-37553-1699248901','WBS-DSM-002110523','W-37553',0.00,5.00,'current',5.00,56.00,280.00,'unpaid','unverified',0.00,'November 2023','2023-11-21','2023-12-21','2023-11-30','2023-11-06','Rogene Vito','13:35:01','2023-11-06','2023-11-06 05:35:01');
/*!40000 ALTER TABLE `billing_data` ENABLE KEYS */;
UNLOCK TABLES;
