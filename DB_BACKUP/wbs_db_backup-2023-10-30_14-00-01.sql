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
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_application`
--

LOCK TABLES `client_application` WRITE;
/*!40000 ALTER TABLE `client_application` DISABLE KEYS */;
INSERT INTO `client_application` VALUES (1,'W-64334','Lisa','John','Powers','MBA','Lisa J. Powers MBA','jonathan54@example.org','096755844420','11/09/1942',81,'Female','Residential','Citrine Road','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Citrine Road, Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','paid','AqXMSCTOljxRfc','03:47:09','2003-07-11','2023-10-30 05:42:23'),(2,'W-37035','Patrick','Jeffrey','Brown','','Patrick J. Brown','ashley88@example.net','091073788833','08/06/1984',39,'Female','Residential','Makiling Drive','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Makiling Drive, Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AaOqnVnNBLvfow','00:09:17','2002-03-03','2023-10-30 05:42:31'),(3,'W-12522','Sandra','Henry','Sparks','Sr.','Sandra H. Sparks Sr.','sberry@example.org','098540359698','11/09/1935',88,'Male','Residential','Smith Street','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Smith Street, Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','paid','AOSyKRpctdpFgI','04:34:32','1986-10-23','2023-10-30 05:42:38'),(4,'W-78295','William','Billy','Martin','Jr.','William B. Martin Jr.','jason60@example.net','091529233591','07/15/1972',51,'Male','Commercial','Lopez Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Lopez Road, Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','ARLDMbRSDbEEQN','02:47:27','1983-11-24','2023-10-30 05:42:52'),(5,'W-69702','Marc','Brandi','Vazquez','M.D.','Marc B. Vazquez M.D.','clifford10@example.org','097564360661','08/19/1985',38,'Female','Residential','Jasmine Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Jasmine Road, Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','paid','ARoRJRBLETDNHu','11:20:39','1987-09-11','2023-10-30 05:43:00'),(6,'W-36336','Dennis','Amber','Becker','III','Dennis A. Becker III','achang@example.org','097242764761','07/02/1950',73,'Male','Residential','Caraballo Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Caraballo Street, Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AMBTuMKOFvsFoB','18:08:47','1986-07-05','2023-10-30 05:43:27'),(7,'W-61927','Richard','Anthony','Sherman','','Richard A. Sherman','sherry69@example.org','093530973956','02/11/1945',78,'Male','Commercial','Amethyst Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Amethyst Street, Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AvjKHfKEYhoyWH','18:52:13','1986-04-22','2023-10-30 05:43:35'),(8,'W-55851','Bobby','Edward','Franco','Jr.','Bobby E. Franco Jr.','kristen03@example.org','097449126786','01/07/2013',10,'Female','Residential','Kaimito Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Kaimito Street, San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AXzBJGRYRnxAbb','19:55:38','1985-07-23','2023-10-30 05:43:43'),(9,'W-89520','Anita','Adam','Buckley','Sr.','Anita A. Buckley Sr.','matthew51@example.net','091005005977','01/09/1974',49,'Female','Commercial','Johnson Avenue','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Johnson Avenue, San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AOeFXLDaLRjMxl','23:36:18','2006-07-27','2023-10-30 05:43:50'),(10,'W-40043','James','Jacob','Bryant','CPA','James Jacob Bryant CPA','richardholden@example.net','097319316614','06/03/1937',86,'Female','Commercial','21st Drive','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AMHEWyzhOgHjrV','08:01:47','2015-06-23','2023-10-30 05:42:09'),(11,'W-55901','Eric','Patricia','Hansen','III','Eric Patricia Hansen III','ugomez@example.com','095570424704','11/08/2013',10,'Female','Residential','Antares Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AHgzMLqjdGikBI','07:41:58','1985-12-20','2023-10-30 05:42:09'),(12,'W-59805','Paul','Hunter','Young','Sr.','Paul Hunter Young Sr.','michael36@example.net','094676880280','08/15/1915',108,'Female','Commercial','Venus Drive','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AYoRfpYKcuKUkp','13:31:38','2022-02-11','2023-10-30 05:42:09'),(13,'W-96778','Jill','Robert','Carroll','II','Jill Robert Carroll II','alexandriaalexander@example.org','099551206076','09/19/1984',39,'Male','Commercial','Kalachuchi Drive','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AAtCmSwXPaJXSN','10:42:43','1972-12-25','2023-10-30 05:42:09'),(14,'W-89596','Thomas','Sherry','Roy','III','Thomas Sherry Roy III','richard51@example.net','092150456878','12/04/1998',25,'Male','Residential','Mays Drive','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AGESaiRkNmWgQZ','04:57:28','2004-10-07','2023-10-30 05:42:09'),(15,'W-55729','Michael','Amber','Sims','','Michael Amber Sims ','andersonvictoria@example.org','092885712708','12/28/2021',2,'Male','Residential','Garcia Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','ApuaNrJknGDhlg','23:20:08','2008-06-05','2023-10-30 05:42:09'),(16,'W-44366','Gregory','Jaclyn','Cochran','III','Gregory Jaclyn Cochran III','jeffrey90@example.net','097947901814','07/01/1935',88,'Male','Commercial','Galaxy Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','APZncpIbfdwAuB','22:09:56','1995-02-24','2023-10-30 05:42:09'),(17,'W-36809','Destiny','Craig','Johnson','Sr.','Destiny Craig Johnson Sr.','biancashannon@example.com','095619863192','07/03/1994',29,'Female','Residential','Barber Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AvQVydHsrvXfIn','08:48:50','1972-05-01','2023-10-30 05:42:09'),(18,'W-52207','Christopher','Tommy','Watson','PhD','Christopher Tommy Watson PhD','ldixon@example.net','092274348413','02/12/1943',80,'Female','Residential','10th Avenue','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','ACEPtJVShXpdUz','15:23:39','2000-11-27','2023-10-30 05:42:09'),(19,'W-99831','Christy','Brian','Romero','CPA','Christy Brian Romero CPA','caseymorris@example.net','092623591707','11/15/1982',41,'Female','Residential','Brandt Street','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ALCISHUGGTrfhd','06:53:27','1982-12-05','2023-10-30 05:42:09'),(20,'W-99599','Samantha','Jennifer','Chandler','MBA','Samantha Jennifer Chandler MBA','sarah33@example.com','097677024079','07/02/2001',22,'Female','Commercial','Lapis Lazuli Drive','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','ADBtchhYiizLlW','13:15:50','1998-11-21','2023-10-30 05:42:09'),(21,'W-72608','Tracy','Ashley','Hernandez','PhD','Tracy Ashley Hernandez PhD','cesar08@example.com','091841969027','06/22/2007',16,'Male','Residential','Asteroid Extension','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AOrWtOWdaCImKA','02:25:44','2013-06-08','2023-10-30 05:42:09'),(22,'W-17862','Sara','Jennifer','Jackson','Jr.','Sara Jennifer Jackson Jr.','allisonjason@example.com','097496694906','08/05/1959',64,'Male','Commercial','Apo Road','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AxPAglTwKgVqZL','19:40:14','1972-12-30','2023-10-30 05:42:09'),(23,'W-11711','Roy','Kenneth','Rodgers','II','Roy Kenneth Rodgers II','pamelabailey@example.org','097068747723','08/14/1952',71,'Male','Residential','Ipil Road','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ACIuHRnpwTbQMI','19:15:49','2009-06-29','2023-10-30 05:42:09'),(24,'W-99567','Alexandria','Kimberly','Villarreal','MBA','Alexandria Kimberly Villarreal MBA','chennatalie@example.org','091901245649','03/01/1969',54,'Male','Residential','Palanan Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AYHZThsFygrruy','02:35:20','1982-10-21','2023-10-30 05:42:09'),(25,'W-36322','Marc','Nicholas','Hill','III','Marc Nicholas Hill III','benjamin78@example.com','091715988499','04/22/1953',70,'Male','Commercial','Sapphire Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AeOvSkTawVlRgL','11:28:28','2006-06-11','2023-10-30 05:42:09'),(26,'W-50322','Allison','Michael','Kim','IV','Allison Michael Kim IV','duane02@example.net','098297462584','02/14/1988',35,'Male','Residential','Balete Street','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AfVSBnGHGcozOT','00:15:33','2023-01-03','2023-10-30 05:42:09'),(27,'W-81810','Richard','Jodi','Flowers','M.D.','Richard Jodi Flowers M.D.','zjuarez@example.org','095729029005','08/06/1959',64,'Male','Commercial','26th Street','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AiZLxgIniZbfXG','23:33:08','1988-09-23','2023-10-30 05:42:09'),(28,'W-82993','Ashley','Barry','Hendricks','PhD','Ashley Barry Hendricks PhD','johnflores@example.com','099456603977','04/29/1931',92,'Female','Residential','Juno Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AvQiDMgLOTKwnB','13:08:58','2009-07-07','2023-10-30 05:42:09'),(29,'W-50177','Nathan','Jessica','Rodriguez','Jr.','Nathan Jessica Rodriguez Jr.','nancy23@example.org','098318297199','03/03/1925',98,'Female','Residential','Magnolia Street','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AwpKKnEQmBbweN','08:27:51','2020-07-08','2023-10-30 05:42:09'),(30,'W-44161','James','Alexander','Harmon','CPA','James Alexander Harmon CPA','annesullivan@example.net','094634383716','03/20/1967',56,'Female','Residential','Sardonyx Road Extension','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AVXptBpNCWWfQI','11:44:31','1978-10-07','2023-10-30 05:42:09'),(31,'W-18482','Jessica','Steven','Montgomery','Sr.','Jessica Steven Montgomery Sr.','john07@example.org','091859365211','09/10/1969',54,'Male','Commercial','Delgado Road','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AtVpDXOpGNIiTf','20:27:03','2005-11-26','2023-10-30 05:42:09'),(32,'W-20776','Chad','David','Jones','Sr.','Chad David Jones Sr.','natalie78@example.com','096271302063','08/25/1935',88,'Male','Residential','Aquarius Drive','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AXHoqJttqSKdhA','15:28:34','2001-11-24','2023-10-30 05:42:09'),(33,'W-38649','Randy','Christopher','Harris','MBA','Randy Christopher Harris MBA','lmeyers@example.com','092879431397','01/10/1961',62,'Female','Residential','54th Avenue','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AaVbLAeMmEzzda','00:34:49','1984-01-09','2023-10-30 05:42:09'),(34,'W-32170','Kelly','Caitlin','Hill','PhD','Kelly Caitlin Hill PhD','david68@example.net','097164867154','08/04/1940',83,'Male','Residential','Hibok-Hibok Road','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AEferOfJpvggaI','08:26:42','2018-10-29','2023-10-30 05:42:09'),(35,'W-76988','Cynthia','Karen','Howe','Jr.','Cynthia Karen Howe Jr.','santiagoanthony@example.com','092114527530','08/08/1916',107,'Female','Commercial','9th Expressway','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AkahXFgVWZKNZJ','13:35:30','2022-09-05','2023-10-30 05:42:09'),(36,'W-95660','Robert','Nathan','Henry','Sr.','Robert Nathan Henry Sr.','iwolfe@example.net','098234414710','07/06/1966',57,'Female','Commercial','Samat Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ARsGxenDJQNVAa','11:56:24','2012-07-20','2023-10-30 05:42:09'),(37,'W-77922','Megan','Zachary','Gordon','PhD','Megan Zachary Gordon PhD','laura47@example.com','095896767063','09/19/1911',112,'Male','Residential','Hubbard Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AorBRYNEJrVmnr','09:13:41','2020-10-02','2023-10-30 05:42:09'),(38,'W-48706','Ernest','Julie','Johnson','III','Ernest Julie Johnson III','nkelly@example.net','093556145341','08/01/1924',99,'Female','Residential','Sunstone Avenue','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AaHuBnZjyHSQwL','19:56:42','2007-07-25','2023-10-30 05:42:09'),(39,'W-45813','Gregory','Lindsey','Brown','','Gregory Lindsey Brown ','wwilliams@example.com','094150165418','12/17/1968',55,'Male','Residential','Lawson Road','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AOYATTqYuYqeUl','10:52:38','2006-11-17','2023-10-30 05:42:09'),(40,'W-54134','Nicole','Joy','Shannon','IV','Nicole Joy Shannon IV','brian10@example.org','095568352934','10/04/1913',110,'Male','Residential','Pao Road Extension','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AFKodWqZoUMaba','13:03:32','2017-05-04','2023-10-30 05:42:09'),(41,'W-51637','Erik','Jamie','Padilla','Ph.D.','Erik Jamie Padilla Ph.D.','ephillips@example.net','093716130635','11/02/1937',86,'Male','Residential','Makiling Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ACNqKlhnDtUyGM','22:43:18','2010-11-18','2023-10-30 05:42:09'),(42,'W-30132','Rhonda','Michael','George','CPA','Rhonda Michael George CPA','fernandezdavid@example.com','098567224174','06/17/1914',109,'Female','Residential','Macopa Road','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AfJwlFUhrmGRqw','21:25:26','1994-01-06','2023-10-30 05:42:09'),(43,'W-27927','Bethany','Lance','Hale','','Bethany Lance Hale ','russellchristopher@example.com','092088371924','07/10/1970',53,'Male','Commercial','39th Road','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AHQwqdmmStQitz','09:11:40','1988-10-30','2023-10-30 05:42:09'),(44,'W-16724','Courtney','Sara','Taylor','IV','Courtney Sara Taylor IV','lanejennifer@example.com','091707122967','05/24/1911',112,'Female','Commercial','Campanilla Extension','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AKwjlFqhHOuHKd','16:45:22','1985-05-16','2023-10-30 05:42:09'),(45,'W-50003','Alex','Elizabeth','Nixon','II','Alex Elizabeth Nixon II','lori12@example.com','097649401182','01/19/1955',68,'Male','Residential','Garnet Extension','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AjUFWiontDyUdn','16:54:13','2018-06-01','2023-10-30 05:42:09'),(46,'W-32402','Kristie','Janice','Lane','','Kristie Janice Lane ','audrey19@example.org','095282391115','09/11/1924',99,'Female','Residential','Bauhinia Road','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AFqFRXJUvySfOX','20:42:30','2021-12-11','2023-10-30 05:42:09'),(47,'W-27183','Joel','Christopher','Perez','IV','Joel Christopher Perez IV','margaretdean@example.org','097814375344','07/19/1934',89,'Female','Residential','Jasper Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AEtCJyjByHxrLu','13:27:40','1971-01-11','2023-10-30 05:42:09'),(48,'W-21663','Daniel','Brooke','Hernandez','Jr.','Daniel Brooke Hernandez Jr.','cherylmorgan@example.net','092707257830','06/24/2022',1,'Female','Residential','Cancer Drive','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AWIcefvZTyxMCa','18:17:05','1983-04-11','2023-10-30 05:42:09'),(49,'W-28192','Donna','Michele','Murray','Sr.','Donna Michele Murray Sr.','hcastro@example.net','097798252745','07/04/1942',81,'Female','Residential','16th Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AfQrnTKtzVayvQ','08:41:46','1976-02-05','2023-10-30 05:42:09'),(50,'W-96018','Timothy','Elizabeth','Richard','MBA','Timothy Elizabeth Richard MBA','frank04@example.org','091362013711','11/20/1925',98,'Male','Residential','Alexander Drive','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AFlbaXyBCqdkNL','19:03:15','1987-11-16','2023-10-30 05:42:09'),(51,'W-67746','James','Michael','Davis','PhD','James Michael Davis PhD','nicolebridges@example.net','095779970067','01/01/1946',77,'Male','Residential','Samat Street','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AIamuvnDBFNIpq','02:07:27','1998-09-13','2023-10-30 05:42:09'),(52,'W-86643','Julie','Dennis','Griffin','Jr.','Julie Dennis Griffin Jr.','bryan58@example.org','092640123633','03/27/2012',11,'Male','Residential','Sicaba Boulevard','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','ArXaXxlkhxbSpn','09:00:33','1972-05-19','2023-10-30 05:42:09'),(53,'W-55718','Jessica','Thomas','Rice','CPA','Jessica Thomas Rice CPA','amanda46@example.net','092776032175','05/06/1962',61,'Male','Commercial','Palanan Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AxXCVLCsrgNDMV','20:15:18','2016-04-19','2023-10-30 05:42:09'),(54,'W-90456','Nicole','Lauren','Hall','Jr.','Nicole Lauren Hall Jr.','jlandry@example.org','097715931844','06/20/1953',70,'Female','Residential','Scorpio Road','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AIRUpApBYQZvhW','11:53:20','2006-06-19','2023-10-30 05:42:09'),(55,'W-83615','Zachary','Anthony','Erickson','','Zachary Anthony Erickson ','michaelrose@example.net','099170234942','12/05/1962',61,'Male','Residential','Aranga Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AiNgUQHZQjBLtx','17:51:20','1972-09-04','2023-10-30 05:42:09'),(56,'W-77442','Jessica','Michael','Robbins','MBA','Jessica Michael Robbins MBA','amandahinton@example.org','094487011570','10/08/1997',26,'Male','Commercial','Cox Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ARmzOhgsTzstRE','22:55:54','2016-01-15','2023-10-30 05:42:09'),(57,'W-61095','Angela','Maria','Hunt','Jr.','Angela Maria Hunt Jr.','johnbowman@example.com','097634219911','09/26/1987',36,'Female','Commercial','Chandler Drive','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AsAJKDgGOsdEwh','12:08:47','1989-10-29','2023-10-30 05:42:09'),(58,'W-49042','Arthur','Terri','Harmon','MBA','Arthur Terri Harmon MBA','lewisangela@example.com','092699654990','11/24/1927',96,'Female','Commercial','Zodiac Road','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AYndzvZkpxGfNJ','21:39:36','1971-02-06','2023-10-30 05:42:09'),(59,'W-72680','Matthew','Dawn','Brown','CPA','Matthew Dawn Brown CPA','ericksonherbert@example.org','091260903339','08/23/1951',72,'Female','Residential','Sierra Madre Avenue','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AoiIFCtsfRvBYu','17:24:05','1989-12-29','2023-10-30 05:42:09'),(60,'W-39885','Richard','Donald','Clark','M.D.','Richard Donald Clark M.D.','vlove@example.com','098163663489','11/05/1920',103,'Male','Residential','Spencer Drive','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AbURMCyhaJrVEo','10:59:16','2021-04-06','2023-10-30 05:42:09'),(61,'W-96327','Jeffrey','Michael','Mccoy','Ph.D.','Jeffrey Michael Mccoy Ph.D.','myersjohn@example.org','097591054027','07/09/1960',63,'Male','Commercial','Hibok-Hibok Road Extension','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AZGXjxICyckOUW','04:23:52','2003-03-04','2023-10-30 05:42:09'),(62,'W-59509','James','Laura','Matthews','Sr.','James Laura Matthews Sr.','avilasarah@example.net','098572344918','01/14/2006',17,'Male','Residential','Sapphire Drive','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AmUWTIxNZBdBrU','08:27:26','1999-05-14','2023-10-30 05:42:09'),(63,'W-93789','Gary','Erin','Howard','II','Gary Erin Howard II','wberry@example.org','092414274166','04/26/1937',86,'Female','Commercial','Cancer Avenue','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ACNCqMVnEyWSPX','17:11:04','1996-07-23','2023-10-30 05:42:09'),(64,'W-29435','Daniel','Christopher','Austin','Ph.D.','Daniel Christopher Austin Ph.D.','matthew56@example.com','098467063995','06/10/1974',49,'Female','Residential','Clark Drive','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AxiBwLTRfzlLIN','01:58:50','1975-07-21','2023-10-30 05:42:09'),(65,'W-73796','Ivan','Timothy','Mays','III','Ivan Timothy Mays III','qcooke@example.org','097876276237','04/24/1988',35,'Male','Residential','89th Drive','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AKzDuPJVGmAbJV','17:44:21','1975-09-12','2023-10-30 05:42:09'),(66,'W-66945','Michael','Elizabeth','Johnson','','Michael Elizabeth Johnson ','mary57@example.net','095551913518','08/28/1966',57,'Male','Residential','51st Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','ANgRHXMjISFmYj','20:28:40','2020-04-03','2023-10-30 05:42:09'),(67,'W-12263','Alan','Jennifer','Colon','CPA','Alan Jennifer Colon CPA','uandersen@example.org','096010137886','11/03/2021',2,'Female','Commercial','Garnet Drive Extension','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AxGcgCtFqqAdzH','15:25:39','1984-01-05','2023-10-30 05:42:09'),(68,'W-28485','Christopher','Maria','Foster','Ph.D.','Christopher Maria Foster Ph.D.','brianna15@example.com','095522560248','08/01/2004',19,'Female','Residential','Jasper Street','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AlIvdDGjeIGdqT','01:05:31','2017-08-29','2023-10-30 05:42:09'),(69,'W-39172','Jonathan','Andrew','Sanchez','Jr.','Jonathan Andrew Sanchez Jr.','staylor@example.com','092658238558','10/08/1930',93,'Female','Residential','Johnson Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AyuMqVuvKNZrNK','07:12:55','1998-11-25','2023-10-30 05:42:09'),(70,'W-33498','Monica','Brittney','Meza','MBA','Monica Brittney Meza MBA','michael73@example.com','098916616982','02/28/1908',115,'Male','Residential','Leo Street','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AZtLLfutYKcWpP','21:23:03','1970-01-28','2023-10-30 05:42:09'),(71,'W-50085','Eric','Elizabeth','Cherry','IV','Eric Elizabeth Cherry IV','tony87@example.org','099236634177','07/10/1957',66,'Male','Commercial','Taurus Street','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AJXbemEUOmAZsa','18:24:32','1970-03-19','2023-10-30 05:42:09'),(72,'W-84489','Haley','Laurie','Cole','II','Haley Laurie Cole II','perezmichelle@example.net','095622757339','05/20/1999',24,'Male','Commercial','Perez Road','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AcSdXiFuhacdaW','06:12:16','1977-09-29','2023-10-30 05:42:09'),(73,'W-68228','Ethan','Jeffrey','Lynn','CPA','Ethan Jeffrey Lynn CPA','kevin25@example.net','094150871625','04/26/2016',7,'Female','Residential','Diamond Road','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AbxTEHsazvINsM','03:57:00','2010-12-13','2023-10-30 05:42:09'),(74,'W-44969','Antonio','Alicia','Greer','','Antonio Alicia Greer ','ellismichelle@example.org','091017366871','01/28/1987',36,'Male','Residential','Jade Avenue','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','ATqxGVuxeEEeZo','20:10:32','1980-02-14','2023-10-30 05:42:09'),(75,'W-90748','Michael','Maria','Bean','M.D.','Michael Maria Bean M.D.','landrymary@example.com','097212988665','08/20/1947',76,'Male','Commercial','Jasper Drive','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ANIHfmLHYNkMKr','01:03:43','1982-03-30','2023-10-30 05:42:09'),(76,'W-76142','Kent','Christine','Tran','III','Kent Christine Tran III','ijohnson@example.com','095596781735','10/08/1977',46,'Female','Commercial','Lawaan Road','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AlNtDObGHbNCzZ','06:14:17','1976-01-17','2023-10-30 05:42:09'),(77,'W-49855','Parker','Kim','Palmer','III','Parker Kim Palmer III','margaret57@example.org','092914667878','02/25/1983',40,'Male','Commercial','Malugay Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AaZKZOHBTfHbRc','08:09:20','1977-07-11','2023-10-30 05:42:09'),(78,'W-45354','Lisa','Robert','Rodriguez','M.D.','Lisa Robert Rodriguez M.D.','ellismark@example.org','095000337426','11/05/1911',112,'Female','Commercial','Jade Street','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','ApljiaJXXvtKtD','23:56:57','1977-06-10','2023-10-30 05:42:09'),(79,'W-18473','David','Sherry','Adams','Sr.','David Sherry Adams Sr.','fpatterson@example.com','094474177299','07/12/1933',90,'Male','Commercial','Venus Street','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AfSTbcKozpWWrs','14:55:07','2003-11-11','2023-10-30 05:42:09'),(80,'W-45280','Jennifer','Steven','Flores','IV','Jennifer Steven Flores IV','englishrichard@example.com','096003117021','01/28/1930',93,'Female','Residential','Acacia Avenue','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ApJtuZfoWgUiIv','10:45:40','1989-07-13','2023-10-30 05:42:09'),(81,'W-33233','Elizabeth','Christina','Cisneros','M.D.','Elizabeth Christina Cisneros M.D.','cynthia84@example.org','098210522368','10/09/1999',24,'Male','Commercial','Makiling Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AdnsTVvqlRjRwS','16:06:29','2002-04-10','2023-10-30 05:42:09'),(82,'W-67407','Andre','Carmen','Freeman','Sr.','Andre Carmen Freeman Sr.','dawnmontoya@example.net','093923493858','09/09/1920',103,'Male','Residential','Arayat Avenue','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AroxTUuVvjmPdJ','16:59:41','2002-10-23','2023-10-30 05:42:09'),(83,'W-47095','Luis','Ashley','Joyce','','Luis Ashley Joyce ','michelle68@example.net','095429601491','08/31/2000',23,'Male','Residential','Jade Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AHQMZlcxhfDRTE','00:12:44','2007-05-15','2023-10-30 05:42:09'),(84,'W-28752','Megan','Andrew','Williams','PhD','Megan Andrew Williams PhD','victoriadoyle@example.org','098478513696','02/07/1943',80,'Male','Commercial','Mustard Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AOubycbLscmhTC','17:57:08','2019-02-14','2023-10-30 05:42:09'),(85,'W-58857','Dana','Roger','Johnson','III','Dana Roger Johnson III','cray@example.org','093001610868','01/19/1925',98,'Female','Residential','15th Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','APhxwfTVjkAtGU','14:05:15','1981-05-20','2023-10-30 05:42:09'),(86,'W-26850','Amy','Ronald','Munoz','CPA','Amy Ronald Munoz CPA','newmanphilip@example.com','096953676519','08/18/1911',112,'Female','Commercial','76th Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AelNyXowGNAaAK','22:28:56','2002-05-05','2023-10-30 05:42:09'),(87,'W-39793','Kayla','Rachel','Hamilton','','Kayla Rachel Hamilton ','froberts@example.net','098076132600','01/20/1996',27,'Female','Commercial','39th Road Extension','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AlvLPfGUUFIzYd','11:17:11','2010-04-27','2023-10-30 05:42:09'),(88,'W-83286','Denise','Anthony','Singh','CPA','Denise Anthony Singh CPA','michael35@example.com','096762518145','05/14/1975',48,'Female','Residential','Sierra Madre Extension','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AajHAgKlouQnyb','23:19:18','2014-01-17','2023-10-30 05:42:09'),(89,'W-14448','Angelica','Frank','Thomas','','Angelica Frank Thomas ','nicholasrobles@example.org','092214127550','12/15/2022',1,'Female','Commercial','Neptune Highway','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ACbThIBlDmOzgU','12:12:05','1987-09-16','2023-10-30 05:42:09'),(90,'W-57486','Susan','Aaron','Stewart','IV','Susan Aaron Stewart IV','ravenroth@example.com','097318264711','09/02/1952',71,'Female','Residential','57th Drive','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AqTeGHqQycYvHd','11:50:17','2021-11-02','2023-10-30 05:42:09'),(91,'W-73531','Christopher','Kara','Green','IV','Christopher Kara Green IV','ruben10@example.net','097674711110','11/09/1951',72,'Female','Residential','Arayat Avenue','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','ArfwyebbcRZBxK','20:43:16','1976-11-28','2023-10-30 05:42:09'),(92,'W-51251','Katie','Kimberly','Hamilton','Sr.','Katie Kimberly Hamilton Sr.','bobbyromero@example.net','099278382304','04/21/1940',83,'Female','Residential','Lawrence Drive','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AcCpEoDXOgAcrN','10:39:21','1994-03-24','2023-10-30 05:42:09'),(93,'W-14417','Paul','Jacqueline','Miller','CPA','Paul Jacqueline Miller CPA','chasedebra@example.com','099073155437','07/11/1997',26,'Male','Residential','Anonas Extension','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AqzHqAUQTLTwlQ','03:06:55','2017-08-25','2023-10-30 05:42:09'),(94,'W-11394','Curtis','Joseph','Olsen','MBA','Curtis Joseph Olsen MBA','victoria38@example.net','093452344884','09/04/2023',0,'Male','Residential','Mcguire Road Extension','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AwWFSdccRrUUlk','00:04:49','2018-09-13','2023-10-30 05:42:09'),(95,'W-98740','Cynthia','Jacqueline','Flores','III','Cynthia Jacqueline Flores III','averyalicia@example.net','099902445184','01/01/1913',110,'Male','Residential','Hibok-Hibok Road','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AxUkegYHLEuZKY','12:16:46','1982-03-18','2023-10-30 05:42:09'),(96,'W-22080','Christopher','Timothy','Ferrell','Ph.D.','Christopher Timothy Ferrell Ph.D.','butlerjustin@example.net','097391185053','07/14/1998',25,'Female','Commercial','Palali Avenue','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AQNFHSHmgjnoBm','03:09:02','1989-05-16','2023-10-30 05:42:09'),(97,'W-86671','Cameron','Jared','Moyer','CPA','Cameron Jared Moyer CPA','kanthony@example.org','091232576114','10/22/1965',58,'Female','Commercial','Wheeler Road','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AVzRriElIMFRso','01:17:05','2018-06-22','2023-10-30 05:42:09'),(98,'W-29971','Seth','Robert','Simon','PhD','Seth Robert Simon PhD','jessica07@example.net','096477985842','07/03/1962',61,'Female','Residential','Scorpio Avenue','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AgUIOpwdkfJWYV','20:32:45','1979-12-17','2023-10-30 05:42:09'),(99,'W-56953','Rebecca','Linda','Sampson','PhD','Rebecca Linda Sampson PhD','jose29@example.net','092976251722','04/19/1925',98,'Male','Residential','Sunstone Drive','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AqTIgkpchhbbkw','17:45:30','1997-08-22','2023-10-30 05:42:09'),(100,'W-88611','Gina','William','Villegas','PhD','Gina William Villegas PhD','davidburke@example.org','093618470703','11/21/1967',56,'Male','Residential','Medina Street','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AxdPfhKneSKgvv','02:23:20','2006-02-06','2023-10-30 05:42:09'),(101,'W-90990','Susan','Randy','Griffin','III','Susan Randy Griffin III','ipitts@example.org','092727383872','12/25/2009',14,'Male','Residential','21st Street','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AgpXQFYyXJoeAa','20:53:25','1976-08-03','2023-10-30 05:42:09'),(102,'W-31172','Erica','Sandra','Turner','Ph.D.','Erica Sandra Turner Ph.D.','robertfitzpatrick@example.net','096001919461','04/18/1962',61,'Male','Commercial','Gemini Drive','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AuHpZygocyhgJJ','18:42:30','2013-10-28','2023-10-30 05:42:09'),(103,'W-79476','Lisa','Jacqueline','Moran','M.D.','Lisa Jacqueline Moran M.D.','zoesmith@example.org','099834846789','05/05/1958',65,'Female','Commercial','Watson Avenue','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ATftIvvpyZPoPd','00:09:18','1978-07-14','2023-10-30 05:42:09'),(104,'W-53300','Alicia','Justin','Valdez','Ph.D.','Alicia Justin Valdez Ph.D.','alicia63@example.net','096295806911','09/14/2002',21,'Male','Commercial','Opal Drive Extension','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AafeKKrovItsMd','14:27:42','1989-06-10','2023-10-30 05:42:09'),(105,'W-26186','Brandi','Heidi','Steele','Jr.','Brandi Heidi Steele Jr.','waltonmatthew@example.org','091160956445','08/10/1992',31,'Female','Residential','Palanan Drive','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AIGwZOFbfUqiHa','09:25:29','1982-04-04','2023-10-30 05:42:09'),(106,'W-31963','Allen','Raven','Morris','Jr.','Allen Raven Morris Jr.','mcdonaldcaitlyn@example.com','094545953850','07/19/1934',89,'Male','Residential','Vazquez Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AWqrPtcowUrJIR','09:55:32','2012-06-27','2023-10-30 05:42:09'),(107,'W-25804','Henry','Kevin','Berry','','Henry Kevin Berry ','ann89@example.org','095539072519','10/01/2001',22,'Female','Residential','Virgo Boulevard','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AOscsUFtBttsSv','01:24:45','1976-05-19','2023-10-30 05:42:09'),(108,'W-86385','Joan','Dale','Fisher','Sr.','Joan Dale Fisher Sr.','paul47@example.net','096541087549','02/10/1962',61,'Female','Residential','68th Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ARaPnGxJKqlxyk','04:45:59','1990-09-19','2023-10-30 05:42:09'),(109,'W-90291','Mark','Elizabeth','Mckinney','Jr.','Mark Elizabeth Mckinney Jr.','timothy69@example.org','094467387649','02/12/1915',108,'Male','Commercial','Bishop Street','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AkAByHaWcwuADW','10:22:44','1993-07-04','2023-10-30 05:42:09'),(110,'W-27633','Jeffrey','Amy','Mullins','Ph.D.','Jeffrey Amy Mullins Ph.D.','scottmonica@example.com','094494126980','01/16/1965',58,'Male','Commercial','Topaz Drive','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ABdjmatGoAOAPs','11:50:39','2003-09-16','2023-10-30 05:42:09'),(111,'W-55781','Cynthia','Dawn','Bautista','PhD','Cynthia Dawn Bautista PhD','janice12@example.org','095667654331','11/19/1919',104,'Male','Commercial','Narra Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AsvrruQgHRFSKT','03:35:14','1977-05-04','2023-10-30 05:42:09'),(112,'W-41319','Benjamin','Leah','Boyd','MBA','Benjamin Leah Boyd MBA','kenneth72@example.com','098859881367','11/17/1982',41,'Female','Residential','Patton Drive','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AEPWsXWHYeJYPV','16:59:18','2009-04-20','2023-10-30 05:42:09'),(113,'W-46258','Kelly','Nicole','Garcia','III','Kelly Nicole Garcia III','francisco30@example.com','094209840895','03/15/1986',37,'Male','Residential','66th Road Extension','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ADsCKNXEyhDuzo','18:33:27','1975-06-30','2023-10-30 05:42:09'),(114,'W-60266','William','Shelby','Prince','Sr.','William Shelby Prince Sr.','hbaldwin@example.net','098556010594','07/26/1917',106,'Female','Residential','Banyan Road','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AyFsLUHrwObKtE','04:57:20','2017-05-28','2023-10-30 05:42:09'),(115,'W-87416','Stephen','Isaiah','Jordan','','Stephen Isaiah Jordan ','hunterbrianna@example.com','093784450205','08/20/2001',22,'Male','Residential','57th Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ArbiWINwOCXpet','05:59:46','1995-06-06','2023-10-30 05:42:09'),(116,'W-26102','Jade','Eric','Steele','IV','Jade Eric Steele IV','amywhite@example.com','093618075714','05/07/1995',28,'Female','Commercial','Ward Avenue','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AIXIzGyrdQQkcP','08:41:10','1983-07-12','2023-10-30 05:42:09'),(117,'W-17829','Mario','Lisa','Taylor','III','Mario Lisa Taylor III','charles71@example.net','095356424323','11/08/2005',18,'Male','Commercial','Samat Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','ATmiYrdmwupXHY','21:37:26','2023-09-20','2023-10-30 05:42:09'),(118,'W-51652','Robert','Kevin','Gonzalez','CPA','Robert Kevin Gonzalez CPA','langerik@example.net','099435304243','10/13/1999',24,'Female','Commercial','Malinao Street','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AmXdTrRvEehwNY','07:45:43','1986-12-16','2023-10-30 05:42:09'),(119,'W-77223','Todd','Rebecca','Houston','PhD','Todd Rebecca Houston PhD','aprillowery@example.org','093676819004','01/27/1918',105,'Male','Residential','Perry Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AhVkLxigFVKvEF','10:11:20','2018-08-04','2023-10-30 05:42:09'),(120,'W-91497','Wendy','Paul','Perez','CPA','Wendy Paul Perez CPA','williamschristopher@example.net','097949621752','09/24/1947',76,'Male','Residential','Kamagong Drive','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AXZlcrVGgoXoGk','23:15:42','1976-01-23','2023-10-30 05:42:09'),(121,'W-16510','Lori','Blake','Shea','Ph.D.','Lori Blake Shea Ph.D.','erinturner@example.net','099004004795','07/02/2005',18,'Male','Residential','Intsia Drive','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AhwqIslNRVmyua','21:03:33','2016-10-14','2023-10-30 05:42:09'),(122,'W-55514','Matthew','Ronald','Fisher','Ph.D.','Matthew Ronald Fisher Ph.D.','stephanie96@example.org','093619277519','09/11/1971',52,'Female','Commercial','Sanders Road','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','APOvdEsgmVkcml','18:50:00','1992-05-03','2023-10-30 05:42:09'),(123,'W-38078','Alexander','Scott','Calderon','IV','Alexander Scott Calderon IV','watsonvictor@example.net','096404025400','01/07/2001',22,'Female','Commercial','15th Street','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AEzSqDJBeLuYxi','16:30:24','1986-04-22','2023-10-30 05:42:09'),(124,'W-33756','Anna','Phillip','Webb','Ph.D.','Anna Phillip Webb Ph.D.','emilyyoung@example.net','097362872186','12/04/1930',93,'Male','Commercial','Mariveles Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AqLPPIHsUBhZsQ','04:37:57','2002-07-13','2023-10-30 05:42:09'),(125,'W-57432','Travis','Nicole','Adams','Ph.D.','Travis Nicole Adams Ph.D.','cstout@example.org','092105879632','02/06/1999',24,'Male','Commercial','Aquarius Avenue Extension','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AkFHUbWxwqnZFw','11:17:22','1999-11-06','2023-10-30 05:42:09'),(126,'W-22022','Ruth','Sara','Orr','Ph.D.','Ruth Sara Orr Ph.D.','moorephilip@example.com','098611165684','07/12/1963',60,'Female','Residential','Taurus Road','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','ASjjfQmejKQDot','02:08:24','2001-02-11','2023-10-30 05:42:09'),(127,'W-84837','Matthew','Vanessa','Burns','MBA','Matthew Vanessa Burns MBA','ghernandez@example.org','099316986180','08/16/1963',60,'Female','Commercial','Onyx Service Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AbjfyyKjottjxy','10:48:55','2011-07-24','2023-10-30 05:42:09'),(128,'W-13548','Nichole','Monica','Green','Ph.D.','Nichole Monica Green Ph.D.','brocktracy@example.org','093448147368','12/16/1993',30,'Male','Commercial','Chang Street','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AiMYepxosDcnvh','01:36:37','2019-04-27','2023-10-30 05:42:09'),(129,'W-15937','Cody','Travis','Osborne','Ph.D.','Cody Travis Osborne Ph.D.','suttonkathy@example.com','095127978381','06/03/1945',78,'Male','Residential','Moonstone Street','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AIjImxynQDprKl','18:26:45','1973-11-13','2023-10-30 05:42:09'),(130,'W-94907','Steven','Maria','Morris','','Steven Maria Morris ','david28@example.com','096354742607','01/24/1939',84,'Female','Residential','Akle Road','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AtvybyVBqxlFWK','18:58:35','1984-04-20','2023-10-30 05:42:09'),(131,'W-12229','David','Andrew','Tran','PhD','David Andrew Tran PhD','wrightchristina@example.org','097686361607','10/15/1948',75,'Female','Residential','Cordillera Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AAnpKQXwFKJlzp','17:34:27','2014-07-31','2023-10-30 05:42:09'),(132,'W-24403','Andrea','Walter','Harris','','Andrea Walter Harris ','longmarcus@example.com','098852882765','07/01/1929',94,'Male','Commercial','Iriga Street','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AxTPARJZXwCNJx','13:13:51','1992-02-25','2023-10-30 05:42:09'),(133,'W-28620','Joseph','Jeffrey','Tran','PhD','Joseph Jeffrey Tran PhD','ramirezderek@example.net','095069884306','07/11/1909',114,'Female','Commercial','Talisay Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AcQhOTxuqstSzJ','06:35:03','2008-04-04','2023-10-30 05:42:09'),(134,'W-39125','Alex','Ryan','Lee','','Alex Ryan Lee ','gloriamcdaniel@example.org','095169502882','10/13/1939',84,'Female','Commercial','89th Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','APhPCyHVwaPTFy','16:25:09','2020-11-03','2023-10-30 05:42:09'),(135,'W-72092','Stacey','Danny','Middleton','','Stacey Danny Middleton ','john86@example.net','097845847665','04/10/2011',12,'Male','Residential','46th Avenue','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AlxzQwjYzKDRmw','15:04:27','2022-04-25','2023-10-30 05:42:09'),(136,'W-87779','Meghan','Autumn','Swanson','Sr.','Meghan Autumn Swanson Sr.','rhondawilkinson@example.com','091859408219','02/21/1912',111,'Female','Commercial','Halcon Road Extension','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AmTcMUZQnEsMKf','20:52:40','1986-03-01','2023-10-30 05:42:09'),(137,'W-55283','Victoria','Sarah','Cooke','','Victoria Sarah Cooke ','gary76@example.com','099284156271','07/01/1908',115,'Male','Commercial','Agate Drive','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ABYqBGeZhVsFDv','21:58:43','1976-04-26','2023-10-30 05:42:09'),(138,'W-83811','Lisa','Chelsea','Harris','','Lisa Chelsea Harris ','james06@example.org','091277249512','04/06/1988',35,'Male','Commercial','Venus Boulevard Extension','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AodwHHEAmyWPFt','11:20:14','1978-04-02','2023-10-30 05:42:09'),(139,'W-73516','Maria','Justin','Scott','II','Maria Justin Scott II','sandra53@example.net','091485292508','06/25/1989',34,'Female','Residential','Champaca Road','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AaPfhoWAvznigO','05:27:14','1972-09-24','2023-10-30 05:42:09'),(140,'W-77151','Colton','Matthew','Mccoy','II','Colton Matthew Mccoy II','alec06@example.com','091875579311','03/04/1996',27,'Female','Residential','Gemini Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','ANRyxDxLlVFMuf','10:24:39','2007-08-25','2023-10-30 05:42:09'),(141,'W-58110','Laura','Joseph','Clay','Ph.D.','Laura Joseph Clay Ph.D.','taylordavid@example.com','099640697569','09/13/1961',62,'Male','Residential','Young Boulevard','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AQFzDVYdcKsfYA','20:34:25','1991-05-25','2023-10-30 05:42:09'),(142,'W-21869','David','Donald','Mcgrath','Sr.','David Donald Mcgrath Sr.','kelly60@example.net','099985133874','06/07/1987',36,'Male','Residential','Jupiter Road','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AyRPPZrIXSvcMJ','06:50:45','2020-04-25','2023-10-30 05:42:09'),(143,'W-85736','Cathy','Derrick','Padilla','','Cathy Derrick Padilla ','janice01@example.com','095976272001','08/13/1912',111,'Male','Commercial','Emerald Expressway','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AJCqnqaMFChNyq','07:10:56','1977-04-12','2023-10-30 05:42:09'),(144,'W-24029','Julian','Wayne','Jackson','II','Julian Wayne Jackson II','sierra87@example.org','095521781682','04/11/1956',67,'Female','Residential','Sagittarius Avenue','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ArZnvyMUqLcetP','13:42:58','2022-01-31','2023-10-30 05:42:09'),(145,'W-62596','Margaret','Matthew','Valdez','II','Margaret Matthew Valdez II','jasonhowell@example.com','099091901329','05/18/2002',21,'Male','Residential','Taurus Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','APmbZrJUTWLXEr','03:32:21','1980-07-07','2023-10-30 05:42:09'),(146,'W-76462','Whitney','Elizabeth','Morris','','Whitney Elizabeth Morris ','scottserrano@example.net','097502738998','10/28/1916',107,'Male','Residential','Halcon Street','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AwzLGMgOEQxTfv','01:33:54','1991-12-28','2023-10-30 05:42:09'),(147,'W-76696','Tracey','Christopher','Davis','MBA','Tracey Christopher Davis MBA','bethallen@example.org','099215890674','04/30/1924',99,'Female','Commercial','Sardonyx Avenue','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AnGcLdimGZHvkK','21:39:37','1979-10-02','2023-10-30 05:42:09'),(148,'W-58326','Samuel','Edgar','Huber','CPA','Samuel Edgar Huber CPA','wongrobert@example.com','092054345536','05/09/1929',94,'Male','Residential','Price Highway','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','ALUhpldnWdJVhl','10:43:46','2010-12-17','2023-10-30 05:42:09'),(149,'W-37119','Denise','Olivia','Lynn','PhD','Denise Olivia Lynn PhD','zdominguez@example.net','094454300616','05/02/1996',27,'Male','Commercial','10th Road Extension','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','ARwcMYsFLjJmbh','12:33:14','2005-06-07','2023-10-30 05:42:09'),(150,'W-40766','Brianna','Steve','Brown','','Brianna Steve Brown ','harrisonmaria@example.org','097639727230','04/25/1983',40,'Female','Residential','4th Street','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ApBJsOpaIIdyiY','16:55:37','1991-01-03','2023-10-30 05:42:09'),(151,'W-38568','Travis','Brittany','Graves','II','Travis Brittany Graves II','john40@example.com','096643059467','05/17/1956',67,'Female','Residential','Moran Road','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AvUPqBedfajUeb','06:15:27','1991-08-24','2023-10-30 05:42:09'),(152,'W-53002','Greg','Eric','Nguyen','','Greg Eric Nguyen ','ericgonzales@example.net','094222963575','02/25/1932',91,'Male','Residential','15th Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AwSzqxlkaijAtv','12:23:25','1972-03-09','2023-10-30 05:42:09'),(153,'W-43031','Anthony','Jade','English','IV','Anthony Jade English IV','johnleonard@example.net','099617134203','07/18/1971',52,'Male','Commercial','Orchid Avenue','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AuocVMULHeUzYS','10:38:18','1975-11-24','2023-10-30 05:42:09'),(154,'W-83556','Jill','Molly','Mejia','Jr.','Jill Molly Mejia Jr.','gabrielledavis@example.com','098790933364','03/03/2005',18,'Female','Commercial','Patton Drive','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AGBJIjvzNvcuii','12:46:04','2001-05-18','2023-10-30 05:42:09'),(155,'W-68091','Stephen','Jennifer','Miller','M.D.','Stephen Jennifer Miller M.D.','rileylaura@example.com','094222200058','04/11/2008',15,'Female','Commercial','35th Drive Extension','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AHRNEssBNAjFmX','13:39:49','2014-01-25','2023-10-30 05:42:09'),(156,'W-11393','Kathleen','Shannon','Martinez','MBA','Kathleen Shannon Martinez MBA','shirleythomas@example.net','091343218418','04/13/1958',65,'Male','Commercial','Camia Drive','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','ADBSzetqouGLFC','10:35:06','1993-10-01','2023-10-30 05:42:09'),(157,'W-55165','Zachary','Christine','Adkins','IV','Zachary Christine Adkins IV','alexanderpark@example.net','097979403254','07/21/1929',94,'Male','Commercial','Wilson Road','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AsrkIZTjPMxROo','22:08:38','2018-09-06','2023-10-30 05:42:09'),(158,'W-88293','Nathan','Elizabeth','Frederick','II','Nathan Elizabeth Frederick II','rfleming@example.net','092135599218','05/13/1936',87,'Male','Commercial','Caraballo Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AtzaksKTaSWrVN','03:39:07','1981-09-24','2023-10-30 05:42:09'),(159,'W-91708','Aimee','William','Parker','IV','Aimee William Parker IV','kwilson@example.net','092410543252','06/25/1973',50,'Female','Residential','Arayat Boulevard','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AwoNtdiLVSCMBR','05:03:10','1994-06-02','2023-10-30 05:42:09'),(160,'W-85188','Cory','Barry','Sweeney','Jr.','Cory Barry Sweeney Jr.','zacharyperez@example.net','093274842867','01/30/1954',69,'Male','Commercial','Atok Street','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','ATYynIPvQPZtoF','21:23:48','1993-08-22','2023-10-30 05:42:09'),(161,'W-86229','Kristen','Molly','Booth','IV','Kristen Molly Booth IV','samuelstewart@example.net','098387500131','02/09/1947',76,'Female','Commercial','Dapdap Drive','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AFLHurvljseAxb','06:37:34','2009-03-23','2023-10-30 05:42:09'),(162,'W-53298','Samuel','Tiffany','Ward','Ph.D.','Samuel Tiffany Ward Ph.D.','wheelerlindsey@example.net','093649511283','11/21/1909',114,'Female','Commercial','Tabayoc Road','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AfKfjcQnBNNMEw','00:19:35','2003-10-21','2023-10-30 05:42:09'),(163,'W-46438','Bernard','Douglas','Moore','PhD','Bernard Douglas Moore PhD','shannonclark@example.org','092672475958','05/18/1911',112,'Female','Commercial','Galaxy Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ARyzWNAghuSLNZ','01:16:12','1977-01-28','2023-10-30 05:42:09'),(164,'W-74595','Nancy','Brian','Mason','PhD','Nancy Brian Mason PhD','hmack@example.net','092344718610','11/17/1969',54,'Male','Commercial','Makiling Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AOrVqAtaMLYuIS','01:33:38','2004-06-09','2023-10-30 05:42:09'),(165,'W-65300','Russell','Mark','Sullivan','CPA','Russell Mark Sullivan CPA','daniel30@example.net','098074035498','11/18/1964',59,'Female','Commercial','Antares Road','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AaWHHfeuhdbUxY','03:43:21','1998-10-08','2023-10-30 05:42:09'),(166,'W-56377','Caroline','Elizabeth','Sloan','IV','Caroline Elizabeth Sloan IV','joshuaharris@example.com','098300393076','11/02/1942',81,'Female','Commercial','Cattleya Extension','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AQHnnNqqOqpNgK','16:38:19','2003-10-21','2023-10-30 05:42:09'),(167,'W-12660','Pamela','Brian','Chambers','Sr.','Pamela Brian Chambers Sr.','donaldwhitaker@example.org','091007141561','09/04/1996',27,'Male','Residential','Banahaw Street','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AoyIaudxueJHlU','15:30:48','1980-12-19','2023-10-30 05:42:09'),(168,'W-83970','Christopher','Mary','Johnson','Jr.','Christopher Mary Johnson Jr.','vincentchoi@example.org','094201098533','05/13/1995',28,'Female','Residential','Thomas Road','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AQasslChkUFiPi','14:06:40','2015-01-03','2023-10-30 05:42:09'),(169,'W-84644','Jessica','Renee','Schneider','MBA','Jessica Renee Schneider MBA','riosrobert@example.net','094441700123','06/22/1919',104,'Female','Commercial','69th Road','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AUifwVAGmgNrZK','01:47:27','2021-04-06','2023-10-30 05:42:09'),(170,'W-86695','Jeffrey','Jennifer','Li','Sr.','Jeffrey Jennifer Li Sr.','ifoster@example.net','091103477849','02/20/1990',33,'Male','Commercial','Zircon Street','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AiclbwFDAaGMXY','05:11:44','2020-02-25','2023-10-30 05:42:09'),(171,'W-24642','Gina','Jennifer','Olson','M.D.','Gina Jennifer Olson M.D.','stephanie01@example.org','099973965677','02/19/1973',50,'Female','Commercial','Canopus Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','ADFOekhJGsoToL','21:42:29','1996-11-05','2023-10-30 05:42:09'),(172,'W-15380','Gary','Donald','Moreno','III','Gary Donald Moreno III','johnrodriguez@example.net','094692490345','07/23/1970',53,'Female','Commercial','Bennett Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','APHadZAnBGNPTW','16:32:53','2011-12-07','2023-10-30 05:42:09'),(173,'W-19477','Jennifer','Victoria','Shepard','II','Jennifer Victoria Shepard II','ajones@example.net','097420290976','05/08/1953',70,'Male','Residential','Capricorn Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AoZpJozIVGJoza','21:41:11','2010-03-26','2023-10-30 05:42:09'),(174,'W-31440','Tammy','Brad','Rodriguez','Jr.','Tammy Brad Rodriguez Jr.','sawyermichael@example.com','091500447464','09/06/2017',6,'Male','Residential','Cresta Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','ASIPUBGmPmrQHU','22:54:07','1998-02-11','2023-10-30 05:42:09'),(175,'W-19012','Jennifer','Mark','Thompson','IV','Jennifer Mark Thompson IV','julieturner@example.org','097116887575','07/26/1942',81,'Male','Commercial','Taurus Road','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AjooCRCjGfFRTE','00:41:32','1993-10-20','2023-10-30 05:42:09'),(176,'W-12454','Jared','Christian','Peters','PhD','Jared Christian Peters PhD','zacharymarquez@example.com','095862352459','06/22/2004',19,'Male','Commercial','Halcon Street','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AtzWplqoaanqQe','17:46:21','1972-05-13','2023-10-30 05:42:09'),(177,'W-39485','Kristina','Dawn','Boyd','CPA','Kristina Dawn Boyd CPA','nguyenshari@example.org','097918749049','04/17/1989',34,'Male','Residential','Diamond Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AlMeuYrmSrhIGt','16:58:00','1974-01-12','2023-10-30 05:42:09'),(178,'W-37588','Jacob','Joy','Franklin','Sr.','Jacob Joy Franklin Sr.','vcollier@example.com','095434509102','12/12/1987',36,'Male','Commercial','96th Road','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AgYrqoVnkjHyiH','15:07:38','1995-10-07','2023-10-30 05:42:09'),(179,'W-19940','Monica','Cody','Thompson','Sr.','Monica Cody Thompson Sr.','gregory54@example.com','093855153245','02/18/1956',67,'Male','Commercial','Jasper Drive','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','ANavcGESboFKZZ','10:10:04','2008-06-19','2023-10-30 05:42:09'),(180,'W-72222','Daniel','Rick','Kim','Sr.','Daniel Rick Kim Sr.','hawkinsjames@example.net','094908279153','01/25/1912',111,'Male','Commercial','Amber Road Extension','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AiykUsnKaxheEh','13:02:30','1987-01-12','2023-10-30 05:42:09'),(181,'W-65948','Shannon','Jamie','Stark','PhD','Shannon Jamie Stark PhD','moodyyvonne@example.com','096198000731','05/04/1994',29,'Male','Residential','Tabayoc Avenue','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AsveBjVaeutVFl','09:12:05','1999-05-13','2023-10-30 05:42:09'),(182,'W-81162','Elizabeth','Rebecca','Cook','Sr.','Elizabeth Rebecca Cook Sr.','peter89@example.net','097498398096','10/18/1946',77,'Male','Residential','Williams Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AwEAoyfVLEYlwn','00:01:48','2006-05-29','2023-10-30 05:42:09'),(183,'W-28201','Sydney','Elizabeth','Ray','CPA','Sydney Elizabeth Ray CPA','shannon06@example.com','097779039350','04/02/1968',55,'Female','Residential','Melon Highway','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AULwVvQyRuYMzo','14:19:31','1977-12-03','2023-10-30 05:42:09'),(184,'W-96840','Matthew','Kristen','Brewer','III','Matthew Kristen Brewer III','fieldsolivia@example.net','094992291284','10/07/1973',50,'Male','Commercial','Canopus Street','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AcXCplvtxZxVwM','02:36:04','2005-02-28','2023-10-30 05:42:09'),(185,'W-19154','Meghan','Cameron','Rivera','M.D.','Meghan Cameron Rivera M.D.','peckalexis@example.net','093832014362','09/03/2009',14,'Male','Commercial','Tamarind Service Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AAnuanjlOGtHRT','09:49:43','2016-02-11','2023-10-30 05:42:09'),(186,'W-22146','Michelle','Christopher','Lewis','MBA','Michelle Christopher Lewis MBA','ramirezchristopher@example.com','098617040942','07/22/1962',61,'Female','Residential','Leo Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AaCdcSQVBGJnLc','22:01:32','2000-10-03','2023-10-30 05:42:09'),(187,'W-98410','William','Jeff','Green','II','William Jeff Green II','kimberly13@example.com','097328082159','02/21/1971',52,'Female','Commercial','Lanzones Extension','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','ApdSQYaNcOWlxR','11:00:36','1995-03-20','2023-10-30 05:42:09'),(188,'W-57336','John','Amy','Bush','II','John Amy Bush II','ryan59@example.org','098215604285','05/19/1990',33,'Male','Commercial','Milky Way Road Extension','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','ApVLnluOzXdDQt','14:44:25','1983-03-28','2023-10-30 05:42:09'),(189,'W-39357','Mary','Sandra','Williams','IV','Mary Sandra Williams IV','dawsonmaria@example.com','094521953623','05/31/1973',50,'Female','Commercial','18th Street','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AJXTbtXbRveADr','08:25:13','1995-06-18','2023-10-30 05:42:09'),(190,'W-72921','Matthew','Joshua','Riley','IV','Matthew Joshua Riley IV','ychase@example.com','098322929440','10/26/1991',32,'Female','Commercial','Agate Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AJieAXXKkEBScL','07:27:31','1989-05-18','2023-10-30 05:42:09'),(191,'W-66488','James','Cheryl','Jenkins','PhD','James Cheryl Jenkins PhD','john47@example.com','092869259715','04/05/1971',52,'Male','Residential','Aries Drive','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AQMAWXoUfzxHyX','04:48:44','2003-01-01','2023-10-30 05:42:09'),(192,'W-61650','Trevor','Shannon','Shannon','PhD','Trevor Shannon Shannon PhD','johnny16@example.net','096918089488','09/20/1996',27,'Female','Commercial','Palali Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AgTyklqTdwNVRR','15:43:22','2023-01-06','2023-10-30 05:42:09'),(193,'W-22432','Michelle','Jessica','Reed','CPA','Michelle Jessica Reed CPA','seth26@example.org','096582532435','09/08/2022',1,'Male','Residential','Milflower Avenue','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AoKkeqomTKJeli','15:31:52','1973-05-26','2023-10-30 05:42:09'),(194,'W-61330','Jennifer','Jessica','Krause','PhD','Jennifer Jessica Krause PhD','megan92@example.net','095877023505','03/25/1959',64,'Female','Residential','Mars Street','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AkzCnUnvFnAhbZ','18:14:34','2000-03-29','2023-10-30 05:42:09'),(195,'W-71191','Lisa','Brittany','Martinez','II','Lisa Brittany Martinez II','jakephillips@example.org','092036799189','09/24/2021',2,'Male','Commercial','Palali Service Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AjxETBYtaihwMF','08:04:19','1973-05-25','2023-10-30 05:42:09'),(196,'W-51014','Thomas','Christopher','Scott','III','Thomas Christopher Scott III','sgonzalez@example.org','093214477808','10/25/1941',82,'Female','Residential','Galaxy Street','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','ApDgizwMTcocyS','02:58:59','2001-01-07','2023-10-30 05:42:09'),(197,'W-11705','Lori','Kayla','Clark','Jr.','Lori Kayla Clark Jr.','jennifer75@example.net','093981000980','07/03/1960',63,'Male','Commercial','68th Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AUfMtRkwRQNYMm','08:17:49','2001-06-08','2023-10-30 05:42:09'),(198,'W-25528','Hannah','Amy','Hammond','M.D.','Hannah Amy Hammond M.D.','taylormichael@example.com','098079317154','08/25/1924',99,'Male','Residential','Gemini Street','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AeBMGRyxAUHIiM','17:17:48','1976-06-21','2023-10-30 05:42:09'),(199,'W-22427','Michael','Patrick','Figueroa','Ph.D.','Michael Patrick Figueroa Ph.D.','trevinomichael@example.org','097798073109','12/06/1974',49,'Female','Residential','Zircon Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ApVkrrMDxuBAOz','05:20:55','1998-07-18','2023-10-30 05:42:09'),(200,'W-43600','Manuel','Eric','Harper','PhD','Manuel Eric Harper PhD','serranoangelica@example.org','099383881232','11/03/1973',50,'Male','Residential','Kalamansi Drive','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','ASCdqHdhFIVvmO','07:27:39','2022-03-18','2023-10-30 05:42:09');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_data`
--

LOCK TABLES `client_data` WRITE;
/*!40000 ALTER TABLE `client_data` DISABLE KEYS */;
INSERT INTO `client_data` VALUES (1,'WBS-RNT-001102923','R20231029181753','W-65227','Rebekah N. Taylor Ph.D.','michaelcampos@example.net','096595520797','07/31/1979',44,'Commercial','Pinatubo Avenue','Victoria','Pinatubo Avenue, Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','read','AfftTQPbkWlmiO','01:17:53','2023-10-30','2023-10-29 17:17:53'),(2,'WBS-JDH-002102923','R20231029181804','W-59968','Justin D. Hansen II','loganlee@example.org','094253662453','03/22/1930',93,'Residential','Planet Drive','San Rafael','Planet Drive, San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AZrjJHfYiaWJGq','01:18:04','2023-10-30','2023-10-29 17:18:04'),(3,'WBS-EJV-003102923','R20231029181812','W-93091','Eric J. Valenzuela IV','kelly42@example.net','095709474673','04/29/1917',106,'Residential','Ramos Street','Bagumbayan','Ramos Street, Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','read','AnPzFyhtprDlNC','01:18:12','2023-10-30','2023-10-29 17:18:12'),(4,'WBS-CJH-004102923','R20231029181821','W-69966','Cody J. Hamilton IV','valerie65@example.org','091904333337','06/15/1962',61,'Residential','Nipa Street','Mabuhay','Nipa Street, Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','read','AKGlFtrSffROpV','01:18:21','2023-10-30','2023-10-29 17:18:21'),(5,'WBS-SCT-005102923','R20231029183054','W-94814','Sarah C. Tucker II','dawnbrown@example.org','096255847685','12/23/1984',39,'Commercial','Garnet Avenue','Happy Valley','Garnet Avenue, Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AfrUexXUExMYCJ','01:30:54','2023-10-30','2023-10-29 17:30:54'),(6,'WBS-SJL-006103023','R20231030063943','W-53176','Sharon J. Larsen IV','garciakevin@example.com','092836101487','12/14/1924',99,'Commercial','83rd Drive Extension','San Aquilino','83rd Drive Extension, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AZBcGvDpyjtcEB','13:39:43','2023-10-30','2023-10-30 05:39:43'),(7,'WBS-AAB-007103023','R20231030064520','W-89520','Anita A. Buckley Sr.','matthew51@example.net','091005005977','01/09/1974',49,'Commercial','Johnson Avenue','San Mariano','Johnson Avenue, San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AOeFXLDaLRjMxl','13:45:20','2023-10-30','2023-10-30 05:45:20'),(8,'WBS-PJB-008103023','R20231030065551','W-37035','Patrick J. Brown','ashley88@example.net','091073788833','08/06/1984',39,'Residential','Makiling Drive','Happy Valley','Makiling Drive, Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AaOqnVnNBLvfow','13:55:51','2023-10-30','2023-10-30 05:55:51'),(9,'WBS-WBM-009103023','R20231030065629','W-78295','William B. Martin Jr.','jason60@example.net','091529233591','07/15/1972',51,'Commercial','Lopez Road','Maraska','Lopez Road, Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','ARLDMbRSDbEEQN','13:56:29','2023-10-30','2023-10-30 05:56:29'),(10,'WBS-DAB-010103023','R20231030065656','W-36336','Dennis A. Becker III','achang@example.org','097242764761','07/02/1950',73,'Residential','Caraballo Street','Victoria','Caraballo Street, Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AMBTuMKOFvsFoB','13:56:56','2023-10-30','2023-10-30 05:56:56'),(11,'WBS-BEF-011103023','R20231030065718','W-55851','Bobby E. Franco Jr.','kristen03@example.org','097449126786','01/07/2013',10,'Residential','Kaimito Street','San Miguel','Kaimito Street, San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AXzBJGRYRnxAbb','13:57:18','2023-10-30','2023-10-30 05:57:18'),(12,'WBS-RAS-012103023','R20231030065844','W-61927','Richard A. Sherman','sherry69@example.org','093530973956','02/11/1945',78,'Commercial','Amethyst Street','Mabuhay','Amethyst Street, Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AvjKHfKEYhoyWH','13:58:44','2023-10-30','2023-10-30 05:58:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_secondary_data`
--

LOCK TABLES `client_secondary_data` WRITE;
/*!40000 ALTER TABLE `client_secondary_data` DISABLE KEYS */;
INSERT INTO `client_secondary_data` VALUES (1,'WBS-AAB-007103023','Anita','Adam','Buckley','Sr.','Commercial','Female','Johnson Avenue','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','13:45:20','2023-10-30','2023-10-30 05:45:20'),(2,'WBS-PJB-008103023','Patrick','Jeffrey','Brown','','Residential','Female','Makiling Drive','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','13:55:51','2023-10-30','2023-10-30 05:55:51'),(3,'WBS-WBM-009103023','William','Billy','Martin','Jr.','Commercial','Male','Lopez Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','13:56:29','2023-10-30','2023-10-30 05:56:29'),(4,'WBS-DAB-010103023','Dennis','Amber','Becker','III','Residential','Male','Caraballo Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','13:56:56','2023-10-30','2023-10-30 05:56:56'),(5,'WBS-BEF-011103023','Bobby','Edward','Franco','Jr.','Residential','Female','Kaimito Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','13:57:19','2023-10-30','2023-10-30 05:57:19'),(6,'WBS-RAS-012103023','Richard','Anthony','Sherman','','Commercial','Male','Amethyst Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','13:58:44','2023-10-30','2023-10-30 05:58:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_changes`
--

LOCK TABLES `log_changes` WRITE;
/*!40000 ALTER TABLE `log_changes` DISABLE KEYS */;
INSERT INTO `log_changes` VALUES (1,'client_data','INSERT','2023-10-30 05:55:51'),(2,'client_application','UPDATE','2023-10-30 05:55:51'),(3,'client_data','INSERT','2023-10-30 05:56:29'),(4,'client_application','UPDATE','2023-10-30 05:56:29'),(5,'client_data','INSERT','2023-10-30 05:56:56'),(6,'client_application','UPDATE','2023-10-30 05:56:56'),(7,'client_data','INSERT','2023-10-30 05:57:18'),(8,'client_application','UPDATE','2023-10-30 05:57:18'),(9,'client_data','INSERT','2023-10-30 05:58:44'),(10,'client_application','UPDATE','2023-10-30 05:58:44');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'ADMIN_05','Payment confirmed for application ID: 9','payment_confirmation','9','2023-10-30 13:44:18',NULL,'read'),(2,'ADMIN_05','Payment confirmed for application ID: 8','payment_confirmation','8','2023-10-30 13:44:22',NULL,'read'),(3,'ADMIN_05','Payment confirmed for application ID: 7','payment_confirmation','7','2023-10-30 13:44:24',NULL,'read'),(4,'ADMIN_05','Payment confirmed for application ID: 6','payment_confirmation','6','2023-10-30 13:44:26',NULL,'read'),(5,'ADMIN_05','Payment confirmed for application ID: 5','payment_confirmation','5','2023-10-30 13:44:29',NULL,'unread'),(6,'ADMIN_05','Payment confirmed for application ID: 4','payment_confirmation','4','2023-10-30 13:44:31',NULL,'read'),(7,'ADMIN_05','Payment confirmed for application ID: 3','payment_confirmation','3','2023-10-30 13:44:34',NULL,'unread'),(8,'ADMIN_05','Payment confirmed for application ID: 2','payment_confirmation','2','2023-10-30 13:44:37',NULL,'read'),(9,'ADMIN_05','Payment confirmed for application ID: 1','payment_confirmation','1','2023-10-30 13:44:39',NULL,'unread');
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

-- Dump completed on 2023-10-30 14:00:02
