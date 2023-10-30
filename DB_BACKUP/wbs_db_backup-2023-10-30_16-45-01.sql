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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing_data`
--

LOCK TABLES `billing_data` WRITE;
/*!40000 ALTER TABLE `billing_data` DISABLE KEYS */;
INSERT INTO `billing_data` VALUES (1,'B-W-30458-1698649960','WBS-APK-001103023','',0.00,0.00,'current',0.00,0.00,0.00,NULL,'initial','October 2023',NULL,NULL,'2023-10-30','2023-10-30','Jeffry James Paner','15:12:40','2023-10-30','2023-10-30 07:12:40'),(2,'B-W-88722-1698649980','WBS-ERR-002103023','',0.00,0.00,'current',0.00,0.00,0.00,NULL,'initial','October 2023',NULL,NULL,'2023-10-30','2023-10-30','Jeffry James Paner','15:13:00','2023-10-30','2023-10-30 07:13:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=209 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_application`
--

LOCK TABLES `client_application` WRITE;
/*!40000 ALTER TABLE `client_application` DISABLE KEYS */;
INSERT INTO `client_application` VALUES (1,'W-30458','Angela','Patrick','Kelly','','Angela P. Kelly','wagnercraig@example.net','094041455314','01/19/1944',79,'Male','Residential','Supa Street','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Supa Street, San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AUYXhpPXaRcWFt','01:05:07','1988-04-05','2023-10-30 07:10:50'),(2,'W-88722','Emily','Robert','Robinson','','Emily R. Robinson','ortizsarah@example.org','098725011010','11/27/1917',106,'Male','Residential','13th Boulevard Extension','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','13th Boulevard Extension, Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','approved','paid','AHJVcJiynGEAAZ','23:27:29','1979-01-06','2023-10-30 07:10:58'),(3,'W-55445','Maria','James','Wilson','Ph.D.','Maria J. Wilson Ph.D.','warrenmorrison@example.org','094670254250','10/06/1958',65,'Male','Residential','Jade Extension','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Jade Extension, Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','paid','AgLAQkxyLiEngK','18:07:34','1980-11-04','2023-10-30 07:11:05'),(4,'W-46778','Marissa','Wendy','Holmes','IV','Marissa W. Holmes IV','hilldaniel@example.net','098103922000','05/22/1993',30,'Male','Commercial','Atis Road','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Atis Road, San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','paid','AaHgwaCReYESTQ','11:30:15','1993-08-29','2023-10-30 07:11:11'),(5,'W-37058','Laura','Barbara','Malone','Jr.','Laura B. Malone Jr.','eboyd@example.net','094173268294','09/25/1934',89,'Female','Commercial','Sapphire Avenue','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Sapphire Avenue, Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','paid','AwuKNKRJpDveKO','00:17:38','2012-05-18','2023-10-30 07:11:19'),(6,'W-18634','Stephanie','Mia','Hartman','MBA','Stephanie M. Hartman MBA','nancy15@example.org','092284148837','01/23/1980',43,'Male','Residential','Lawaan Service Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Lawaan Service Road, Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','confirmed','unpaid','AlPmOcFqIDPiLG','11:54:36','2004-07-08','2023-10-30 07:12:52'),(7,'W-86744','Charles','Amanda','Green','','Charles Amanda Green ','brandonbryant@example.net','098849230008','12/05/1911',112,'Male','Commercial','Batino Extension','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','ASmDJHuZyLdfqD','00:35:45','1993-06-15','2023-10-30 07:10:39'),(8,'W-52593','Stephen','William','Wood','Sr.','Stephen William Wood Sr.','kenneth12@example.org','094615358189','04/24/1915',108,'Female','Residential','Makiling Highway','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AasySmNITjWcKs','06:09:01','1986-09-18','2023-10-30 07:10:39'),(9,'W-48381','Richard','Mark','Garner','IV','Richard Mark Garner IV','lfry@example.com','094099034975','02/22/2022',1,'Female','Commercial','96th Road','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AiOswbwCbXqvJf','19:55:47','1983-07-08','2023-10-30 07:10:39'),(10,'W-94660','Theresa','Matthew','Liu','PhD','Theresa Matthew Liu PhD','madison02@example.com','091776579387','01/06/1975',48,'Male','Commercial','Franco Avenue','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AkvVdWWhUXCNlm','04:07:26','1991-10-07','2023-10-30 07:10:39'),(11,'W-21465','Catherine','Carolyn','Mendoza','CPA','Catherine Carolyn Mendoza CPA','kevin00@example.org','091921420415','09/09/2021',2,'Female','Residential','Chapman Road','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AnhZQBWdomylFt','00:39:43','1971-04-14','2023-10-30 07:10:39'),(12,'W-89129','Stephanie','Jeffrey','Rodriguez','CPA','Stephanie Jeffrey Rodriguez CPA','kylepadilla@example.org','098874354346','07/20/2019',4,'Male','Commercial','Young Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AhJhrIAzPSsWCT','16:24:52','1989-01-27','2023-10-30 07:10:39'),(13,'W-73932','Chase','Vanessa','Morrison','Ph.D.','Chase Vanessa Morrison Ph.D.','smithscott@example.com','092885389223','08/31/1986',37,'Female','Residential','Calantas Drive','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AgwWeGGgfnbGSG','20:32:23','2002-01-14','2023-10-30 07:10:39'),(14,'W-85702','Daniel','Adam','Davis','II','Daniel Adam Davis II','travis39@example.org','099833059968','06/09/1928',95,'Male','Residential','92nd Road','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AvPJLEUHRaIYRu','23:27:13','1994-01-13','2023-10-30 07:10:39'),(15,'W-96225','Jasmine','Benjamin','Jones','Jr.','Jasmine Benjamin Jones Jr.','kelly11@example.com','094856020043','05/07/2016',7,'Female','Residential','Bouganvilla Road','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AKBwxNGuSKyPnl','21:25:35','2005-06-07','2023-10-30 07:10:39'),(16,'W-73213','Alicia','Patrick','Smith','IV','Alicia Patrick Smith IV','msantana@example.org','098389663893','02/19/1962',61,'Male','Residential','Sapphire Street','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AboGellmALTjke','19:31:48','1973-11-11','2023-10-30 07:10:39'),(17,'W-40591','Shawna','Michael','Clark','CPA','Shawna Michael Clark CPA','solomonjohn@example.org','098781558175','05/25/1957',66,'Male','Commercial','Polaris Street','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AhGqnPuEWLcRmM','16:14:43','1970-07-14','2023-10-30 07:10:39'),(18,'W-55016','Laura','Kevin','Buck','','Laura Kevin Buck ','keith71@example.net','092399400943','01/30/1979',44,'Male','Commercial','Neptune Drive Extension','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AAZUEgeBMWYWDa','23:06:48','1993-06-04','2023-10-30 07:10:39'),(19,'W-27783','Susan','Lisa','Nelson','','Susan Lisa Nelson ','georgemccall@example.com','099051606908','03/10/1966',57,'Female','Residential','Cordillera Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AHAAyYlaZFLbgf','05:00:47','2022-08-02','2023-10-30 07:10:39'),(20,'W-29773','Angela','William','Hawkins','','Angela William Hawkins ','moralesbrian@example.net','097239443285','06/12/1948',75,'Female','Residential','17th Drive Extension','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AiPmJAAGctgRCw','10:31:13','2006-06-15','2023-10-30 07:10:39'),(21,'W-14343','Wanda','Dennis','Marshall','Jr.','Wanda Dennis Marshall Jr.','jacqueline66@example.net','092063799048','10/21/1956',67,'Male','Commercial','Jasper Drive Extension','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AzSKyDwRKZMfcK','09:51:16','1994-10-25','2023-10-30 07:10:39'),(22,'W-64550','Karen','Brent','Parks','IV','Karen Brent Parks IV','hamptonjanice@example.com','092202150683','12/01/2022',1,'Male','Commercial','Arayat Drive Extension','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AnBnQKZEIjQRfB','07:40:29','2007-10-14','2023-10-30 07:10:39'),(23,'W-93131','Lisa','Colleen','Martin','Sr.','Lisa Colleen Martin Sr.','jacqueline38@example.net','096094634470','03/12/1947',76,'Male','Commercial','15th Avenue','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','ASzYdIRoSFWtQG','04:18:02','2011-06-13','2023-10-30 07:10:39'),(24,'W-85492','Kristen','Mary','Jenkins','IV','Kristen Mary Jenkins IV','deborah92@example.net','097619002642','07/15/1975',48,'Male','Residential','Ortiz Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AfrJLINzDLxYFR','03:25:42','2012-02-19','2023-10-30 07:10:39'),(25,'W-87829','Kenneth','Lee','White','IV','Kenneth Lee White IV','matthewgray@example.com','093237068003','05/13/1934',89,'Female','Residential','Zircon Road','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AeoBmxgJArqXUQ','22:03:16','1998-05-22','2023-10-30 07:10:39'),(26,'W-15403','Ronnie','John','Thompson','IV','Ronnie John Thompson IV','sarah11@example.net','094542729264','04/18/1998',25,'Male','Residential','Lapis Lazuli Avenue Extension','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AXkjnExfYfcztJ','10:57:39','2010-08-29','2023-10-30 07:10:39'),(27,'W-50123','Matthew','Erik','Howard','','Matthew Erik Howard ','evanslisa@example.com','096844899440','03/25/1948',75,'Female','Residential','Atok Expressway','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AKtOTwCJiheSYf','15:50:32','1997-10-29','2023-10-30 07:10:39'),(28,'W-60366','Emily','Janet','Ramsey','IV','Emily Janet Ramsey IV','andreasmith@example.org','098889398542','06/28/1942',81,'Male','Commercial','Aquamarine Highway','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AjVQkEyFKdsPYo','21:32:10','1993-10-20','2023-10-30 07:10:39'),(29,'W-15203','William','Timothy','Garcia','Sr.','William Timothy Garcia Sr.','jeffrey56@example.com','091483890028','06/16/1936',87,'Male','Commercial','Halcon Road','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AFPgtsBJkYQeOc','04:13:04','2022-11-10','2023-10-30 07:10:39'),(30,'W-10924','Meredith','Adrian','Rivera','M.D.','Meredith Adrian Rivera M.D.','madams@example.org','096333208733','01/30/2009',14,'Female','Residential','Gonzales Expressway','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AMjrVgJOAMIBsB','03:09:21','1975-05-03','2023-10-30 07:10:39'),(31,'W-86451','Amy','Richard','Johnson','','Amy Richard Johnson ','laura13@example.org','096075211446','03/27/1911',112,'Male','Residential','Arias Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AFXtGkLyFKTcxV','08:42:56','1997-02-23','2023-10-30 07:10:39'),(32,'W-49745','Diana','Cameron','Mckenzie','II','Diana Cameron Mckenzie II','timothy08@example.org','092344374575','04/13/1949',74,'Male','Residential','47th Drive','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AaJxhunSXSxwrA','03:10:35','1987-04-22','2023-10-30 07:10:39'),(33,'W-31751','Kimberly','Eric','Hall','MBA','Kimberly Eric Hall MBA','whitestefanie@example.org','093111823058','11/15/1981',42,'Female','Residential','Pisces Road','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AddUtYwzuuiCio','15:56:28','1988-09-12','2023-10-30 07:10:39'),(34,'W-22892','John','Kaylee','Newton','Jr.','John Kaylee Newton Jr.','joseph51@example.com','099879320347','05/17/1924',99,'Male','Residential','Mcdonald Drive','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AJXwCFoTeJUCVz','09:13:42','2021-07-16','2023-10-30 07:10:39'),(35,'W-88044','Richard','Ashley','Brown','Sr.','Richard Ashley Brown Sr.','turnerkathleen@example.org','097814778205','05/10/1912',111,'Male','Residential','92nd Street','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','ASOzSdNtFUhrKd','10:43:06','1972-05-26','2023-10-30 07:10:39'),(36,'W-91435','Michelle','Miguel','Baker','Jr.','Michelle Miguel Baker Jr.','danielryan@example.org','095519942434','02/11/1978',45,'Female','Commercial','Orion Road','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AhKjkXpMKBNRKz','18:45:29','1976-10-25','2023-10-30 07:10:39'),(37,'W-35237','Isaac','Teresa','Martinez','CPA','Isaac Teresa Martinez CPA','greg16@example.org','094536559022','09/03/2003',20,'Male','Commercial','Pinatubo Street','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AlobMoAYtPzQxz','12:30:47','2011-01-28','2023-10-30 07:10:39'),(38,'W-52870','Elizabeth','Katherine','Gonzalez','CPA','Elizabeth Katherine Gonzalez CPA','ybrooks@example.com','094581704092','10/16/1937',86,'Male','Commercial','Iriga Road Extension','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AXxVjuAMcdvCJc','09:17:53','2009-09-19','2023-10-30 07:10:39'),(39,'W-53794','Deborah','Lawrence','Williams','PhD','Deborah Lawrence Williams PhD','bishoprandall@example.com','093397897107','09/03/2004',19,'Male','Residential','Turquoise Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AzxECWVpmfZIEJ','10:12:37','2023-10-02','2023-10-30 07:10:39'),(40,'W-30336','Dennis','James','Jackson','M.D.','Dennis James Jackson M.D.','michellegarcia@example.com','096034216572','06/25/1993',30,'Male','Residential','Capricorn Street','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','ArmDgBHhdFkNRd','22:14:41','1998-07-13','2023-10-30 07:10:39'),(41,'W-27563','Bethany','Stacey','Grimes','CPA','Bethany Stacey Grimes CPA','mendozadiana@example.org','091005923561','07/24/1931',92,'Male','Commercial','Caldwell Drive','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AgmmZBcVRjxkru','19:09:07','1973-06-19','2023-10-30 07:10:39'),(42,'W-79427','Stanley','Katherine','Miller','IV','Stanley Katherine Miller IV','jfrazier@example.org','091990278660','04/15/1988',35,'Female','Commercial','Aquamarine Service Road','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AXZIWScQySZMHo','01:42:19','2012-04-14','2023-10-30 07:10:39'),(43,'W-21055','Lisa','Tonya','Smith','PhD','Lisa Tonya Smith PhD','crawfordmarc@example.org','097557333013','06/28/1932',91,'Female','Residential','Scorpio Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AgJcVfshjmuiUR','15:35:38','2023-07-22','2023-10-30 07:10:39'),(44,'W-11913','Peggy','Kathryn','Brown','II','Peggy Kathryn Brown II','michelle88@example.org','092837176753','09/08/1953',70,'Male','Commercial','Myers Drive','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AbZEjXMHjqwiCm','02:14:04','2007-03-15','2023-10-30 07:10:39'),(45,'W-47770','Michael','Michelle','Potts','MBA','Michael Michelle Potts MBA','oshaw@example.org','097832427114','12/16/1928',95,'Male','Commercial','Banahaw Avenue','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AFNJNJlPvwRNme','23:35:39','2011-12-10','2023-10-30 07:10:39'),(46,'W-35684','James','Margaret','Morrison','Jr.','James Margaret Morrison Jr.','juanherrera@example.net','095950696816','10/19/1922',101,'Male','Residential','Pinatubo Road','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AouqiQVPaFNcGI','05:10:29','1971-04-27','2023-10-30 07:10:39'),(47,'W-86826','Scott','Matthew','Green','PhD','Scott Matthew Green PhD','williamspamela@example.org','098090325345','05/02/2013',10,'Male','Residential','Hopkins Drive','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AUkVBdIvlNgZNJ','02:29:54','1975-08-20','2023-10-30 07:10:39'),(48,'W-13099','Lauren','Gabrielle','Gonzales','IV','Lauren Gabrielle Gonzales IV','nicolegarcia@example.net','091231647618','08/28/2023',0,'Female','Residential','Aquamarine Extension','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AcDGVZLQXnwtsr','13:47:16','1977-06-30','2023-10-30 07:10:39'),(49,'W-45917','Vincent','Colleen','Ryan','IV','Vincent Colleen Ryan IV','swhitaker@example.com','094918172999','08/17/2016',7,'Female','Residential','Coconut Road','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AwFGQoSJmcFStN','00:10:10','1975-05-02','2023-10-30 07:10:39'),(50,'W-86794','Gloria','Caleb','Smith','II','Gloria Caleb Smith II','william34@example.com','091829258312','11/20/2021',2,'Female','Commercial','Montgomery Avenue','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AfMfUTEocgfOzH','09:28:37','1976-02-16','2023-10-30 07:10:39'),(51,'W-61510','Hailey','Brandi','Buckley','Jr.','Hailey Brandi Buckley Jr.','berrytodd@example.net','099774479726','12/18/2010',13,'Male','Commercial','Pluto Drive','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AxSFHoRYdxlCfe','07:13:22','1982-02-01','2023-10-30 07:10:39'),(52,'W-30204','William','Julie','Wiley','CPA','William Julie Wiley CPA','josemurray@example.org','094309081096','09/11/1920',103,'Female','Commercial','Pao Street','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ALwoETbUOGWuTS','08:39:24','2003-04-23','2023-10-30 07:10:39'),(53,'W-53569','Kristen','Sandra','Martinez','PhD','Kristen Sandra Martinez PhD','nathan79@example.org','099453780842','10/15/1981',42,'Male','Residential','Palanan Road','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AINaQLLKLzhMRz','06:20:40','2022-10-27','2023-10-30 07:10:39'),(54,'W-41866','Regina','Lindsey','Dalton','MBA','Regina Lindsey Dalton MBA','mhenderson@example.com','096336020654','10/19/1953',70,'Female','Residential','Tindalo Road','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','ASsmEcQOIYCJXQ','15:38:57','2019-08-17','2023-10-30 07:10:39'),(55,'W-36596','Taylor','Mark','Lewis','III','Taylor Mark Lewis III','acostaamber@example.com','097798722345','09/27/1942',81,'Male','Commercial','Milky Way Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AWhwSTBVZsRqRY','11:32:29','1990-10-03','2023-10-30 07:10:39'),(56,'W-23393','Donald','Deborah','Wyatt','Jr.','Donald Deborah Wyatt Jr.','soconnor@example.net','094873127581','08/30/1927',96,'Male','Commercial','Moonstone Street','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AutJPjmyLmlkAZ','16:01:34','2010-08-06','2023-10-30 07:10:39'),(57,'W-32795','Michael','John','Stokes','PhD','Michael John Stokes PhD','speterson@example.com','097487748054','05/28/2021',2,'Female','Residential','Carter Road Extension','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AxTCHhCGbmiHlN','23:35:26','1990-10-11','2023-10-30 07:10:39'),(58,'W-50532','Alvin','James','Suarez','Ph.D.','Alvin James Suarez Ph.D.','mblack@example.com','095904711114','08/01/2013',10,'Female','Residential','Libra Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AHTmypUQpAEJHr','20:52:41','2022-03-08','2023-10-30 07:10:39'),(59,'W-60559','Ashley','Sherry','Hernandez','III','Ashley Sherry Hernandez III','rebeccafields@example.com','098841657804','09/24/1998',25,'Male','Commercial','Libra Extension','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AjuVGicOaJOzxm','15:19:02','1991-10-31','2023-10-30 07:10:39'),(60,'W-29320','Christina','Joshua','Fleming','Ph.D.','Christina Joshua Fleming Ph.D.','todd84@example.com','095643492926','10/05/2020',3,'Female','Commercial','Andromeda Boulevard','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AnpXoEKyzgPLyy','05:22:32','1980-11-01','2023-10-30 07:10:39'),(61,'W-18023','Bryan','John','Thomas','IV','Bryan John Thomas IV','rebeccasmith@example.org','091377896305','08/19/1999',24,'Male','Commercial','Sanchez Street','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AyJcGQeWfPyIKY','17:41:42','2018-09-16','2023-10-30 07:10:39'),(62,'W-79827','Samuel','Greg','Mcclain','MBA','Samuel Greg Mcclain MBA','ybarker@example.net','099479113250','01/24/1912',111,'Female','Commercial','Barron Street','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AYDYFWjhWBvTfo','07:47:50','1973-08-09','2023-10-30 07:10:39'),(63,'W-55676','Christine','Frank','Rice','II','Christine Frank Rice II','hernandezjean@example.com','098796103295','03/16/1981',42,'Female','Commercial','Cresta Road','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','ATePNWyiVdxDcg','17:37:17','1986-05-02','2023-10-30 07:10:39'),(64,'W-37389','Bridget','Christy','Miller','PhD','Bridget Christy Miller PhD','courtney70@example.org','092120704447','05/19/2010',13,'Male','Commercial','72nd Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AdsVuqbGgjsXPS','22:05:46','2016-12-26','2023-10-30 07:10:39'),(65,'W-43925','Tony','Dana','Stevens','II','Tony Dana Stevens II','adamssteven@example.net','094891280103','04/09/1928',95,'Female','Residential','Canopus Service Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AojxfBjdtMibEk','15:05:14','1981-05-20','2023-10-30 07:10:39'),(66,'W-94537','Tamara','Nathaniel','Thompson','Sr.','Tamara Nathaniel Thompson Sr.','camachotimothy@example.net','094086675753','08/17/2018',5,'Male','Commercial','Sagittarius Avenue','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AjDNIdTXgQZUbM','19:08:31','1971-08-29','2023-10-30 07:10:39'),(67,'W-63568','Daniel','Christine','Smith','III','Daniel Christine Smith III','ryansmith@example.org','094700337741','03/16/1979',44,'Male','Commercial','Aquarius Road','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','ArHbNrlgBLjgus','20:14:31','2014-11-23','2023-10-30 07:10:39'),(68,'W-79916','Rhonda','David','Krause','PhD','Rhonda David Krause PhD','bonniemorales@example.net','092118146044','10/14/1924',99,'Female','Residential','Saturn Drive Extension','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AwHJKjiYSazTay','00:07:40','2013-08-04','2023-10-30 07:10:39'),(69,'W-95840','Maria','Chad','Anderson','III','Maria Chad Anderson III','edodson@example.com','098489913549','04/30/1917',106,'Male','Residential','Dungon Road','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AjEjbRFNCxtCme','12:39:10','2000-08-08','2023-10-30 07:10:39'),(70,'W-15393','Jennifer','Clarence','Taylor','','Jennifer Clarence Taylor ','guerrerolaura@example.com','091909814804','01/15/1959',64,'Male','Residential','Dodson Extension','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AhBAMQMVNRTroh','17:16:11','1982-12-16','2023-10-30 07:10:39'),(71,'W-89026','Mark','Sandra','Weaver','III','Mark Sandra Weaver III','craig94@example.net','096499568282','06/19/1911',112,'Female','Commercial','Foster Avenue','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AOtYJfPgUForMF','11:55:53','1975-03-10','2023-10-30 07:10:39'),(72,'W-23656','Ashley','Corey','Casey','Jr.','Ashley Corey Casey Jr.','cynthia18@example.org','097013155740','03/30/2009',14,'Female','Commercial','40th Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AHpBDHlIfXMBpB','00:48:55','2001-10-07','2023-10-30 07:10:39'),(73,'W-25486','Annette','Sheri','Jones','IV','Annette Sheri Jones IV','wendy98@example.com','099517281780','11/06/1913',110,'Male','Residential','61st Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AHGIrvpXeDADQQ','00:35:58','2010-03-07','2023-10-30 07:10:39'),(74,'W-28213','David','Ashley','Meyers','PhD','David Ashley Meyers PhD','wallacetimothy@example.org','099934404112','08/16/1974',49,'Male','Commercial','Jade Road','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AqZdCijDhPSKAO','21:28:02','2018-09-24','2023-10-30 07:10:39'),(75,'W-47303','Sierra','Amy','Miller','M.D.','Sierra Amy Miller M.D.','markstewart@example.com','091914404076','06/04/1993',30,'Female','Commercial','Melon Road','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AiUzpVOWgxGpDA','05:51:56','2017-01-10','2023-10-30 07:10:39'),(76,'W-82528','James','Anthony','Cole','CPA','James Anthony Cole CPA','tyler95@example.com','097122708137','06/08/1923',100,'Female','Residential','Acacia Road Extension','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ACOxRWjueBIAUr','09:37:14','2016-01-17','2023-10-30 07:10:39'),(77,'W-72694','David','Melissa','Smith','CPA','David Melissa Smith CPA','gbrown@example.org','096597273869','07/27/1969',54,'Female','Commercial','Sardonyx Road Extension','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AaxkMMcDhgFXiq','08:49:46','2013-08-13','2023-10-30 07:10:39'),(78,'W-33770','Trevor','Kristin','Taylor','Jr.','Trevor Kristin Taylor Jr.','bphillips@example.org','099608013448','02/17/1933',90,'Female','Commercial','Sagittarius Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ArFLrGhJvOnHQq','05:14:19','2008-03-27','2023-10-30 07:10:39'),(79,'W-59254','Alison','Eric','Hansen','III','Alison Eric Hansen III','selenajohnson@example.net','098506270787','07/27/2010',13,'Male','Commercial','Tamarind Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AJoHMickCerOOE','20:51:33','2016-02-08','2023-10-30 07:10:39'),(80,'W-21576','Kristopher','Brandon','Garcia','III','Kristopher Brandon Garcia III','tuckermichael@example.org','095436764589','01/05/1922',101,'Female','Commercial','Makiling Extension','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','APkuOniQgBXMUu','08:44:27','2002-11-12','2023-10-30 07:10:39'),(81,'W-93631','Benjamin','Brian','Stokes','II','Benjamin Brian Stokes II','kristendunn@example.org','094111039746','02/02/1945',78,'Female','Residential','Malinao Road','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AbtisvVNnrfUkv','16:26:10','1971-10-24','2023-10-30 07:10:39'),(82,'W-87205','Paul','Jessica','Taylor','III','Paul Jessica Taylor III','alexalee@example.net','093917145424','07/29/2022',1,'Male','Commercial','Onyx Road','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','ATvBRuBtzOOdmw','03:36:48','2015-12-18','2023-10-30 07:10:39'),(83,'W-30508','Joshua','Mark','Hart','PhD','Joshua Mark Hart PhD','edwardsdavid@example.com','094342553870','10/15/2006',17,'Male','Commercial','Scorpio Extension','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AFDSsmERXUhuAv','04:37:05','1984-05-09','2023-10-30 07:10:39'),(84,'W-96934','Bonnie','Brendan','Shaw','Sr.','Bonnie Brendan Shaw Sr.','iaguilar@example.net','098063303142','10/13/1996',27,'Male','Residential','44th Road Extension','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','ABnXXrSMmniSUu','04:34:42','1978-04-19','2023-10-30 07:10:39'),(85,'W-27206','John','Zachary','Perkins','CPA','John Zachary Perkins CPA','walkeramy@example.com','099325405705','10/05/1937',86,'Female','Commercial','Intsia Road','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AObmGrRKldByyp','09:18:36','2003-01-02','2023-10-30 07:10:39'),(86,'W-40563','Stacy','Karen','Todd','Jr.','Stacy Karen Todd Jr.','ihuerta@example.org','092594546567','09/21/1992',31,'Female','Commercial','59th Street','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AKgNcAJHDSrGNt','13:32:40','2008-01-05','2023-10-30 07:10:39'),(87,'W-13758','Cynthia','Austin','Avila','Sr.','Cynthia Austin Avila Sr.','odonnellelizabeth@example.org','094606100246','09/21/2021',2,'Female','Commercial','Calantas Boulevard Extension','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AExOsmNzcBbpId','13:11:49','2012-04-21','2023-10-30 07:10:39'),(88,'W-85148','Tammy','Austin','Fuller','Ph.D.','Tammy Austin Fuller Ph.D.','lopezanna@example.org','097628325501','12/19/1940',83,'Female','Residential','Benson Street','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ACgdClMVrxWnHP','22:32:10','1974-02-10','2023-10-30 07:10:39'),(89,'W-42877','Shirley','Christine','Rodriguez','Ph.D.','Shirley Christine Rodriguez Ph.D.','jamesmcguire@example.org','095852637769','04/08/1948',75,'Male','Commercial','Acacia Road','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ACOpEtFGalrjEL','21:51:39','1988-05-04','2023-10-30 07:10:39'),(90,'W-37409','Deanna','Troy','Baxter','CPA','Deanna Troy Baxter CPA','jenniferbean@example.org','091877581360','06/24/1934',89,'Female','Residential','19th Boulevard','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AdCeNmYcpZWXTt','04:25:42','2001-02-08','2023-10-30 07:10:39'),(91,'W-89105','James','Amy','Gonzalez','III','James Amy Gonzalez III','martha22@example.net','092125335366','02/17/1985',38,'Female','Residential','Taurus Avenue Extension','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AXqsmvAgwBWOek','23:17:32','1985-12-31','2023-10-30 07:10:39'),(92,'W-72751','Michael','Melanie','Rodriguez','Sr.','Michael Melanie Rodriguez Sr.','ethan68@example.org','093881440994','06/02/1988',35,'Male','Commercial','77th Drive','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AKNKznJBfzwLyF','09:47:25','2001-06-17','2023-10-30 07:10:39'),(93,'W-90634','Haley','Katrina','Jones','PhD','Haley Katrina Jones PhD','stricklandtammy@example.org','099254121299','02/24/1992',31,'Male','Commercial','Jenkins Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ArQNAXxJgvfwkH','05:09:02','1983-08-09','2023-10-30 07:10:39'),(94,'W-64435','Robert','Jacob','Day','PhD','Robert Jacob Day PhD','bdavis@example.com','092031020260','11/13/2019',4,'Male','Commercial','Malinao Road','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AcNszDMLukHclD','00:58:18','1987-04-12','2023-10-30 07:10:39'),(95,'W-88051','Brittany','Bonnie','Green','M.D.','Brittany Bonnie Green M.D.','markgibson@example.net','095881876000','07/12/1945',78,'Male','Residential','7th Drive','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','ANLxGbnQADkdTU','01:37:40','1997-08-19','2023-10-30 07:10:39'),(96,'W-95202','Kimberly','Donna','Thomas','MBA','Kimberly Donna Thomas MBA','christine48@example.org','093390344833','12/25/1931',92,'Female','Residential','Melon Avenue','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AjlkfYouDMtVSX','07:32:58','2014-05-28','2023-10-30 07:10:39'),(97,'W-78307','Lori','Laura','Rodriguez','CPA','Lori Laura Rodriguez CPA','hramos@example.net','092435284876','09/28/1953',70,'Female','Commercial','Butler Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AnoNVfBGNtHLQi','13:42:35','2007-10-04','2023-10-30 07:10:39'),(98,'W-60603','Robert','Jonathan','Lewis','','Robert Jonathan Lewis ','michael10@example.net','097712868138','05/13/1964',59,'Male','Commercial','Scorpio Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','ApspTatOHPcDeK','22:01:18','2003-01-18','2023-10-30 07:10:39'),(99,'W-43019','Dylan','Dawn','Ward','MBA','Dylan Dawn Ward MBA','ythompson@example.org','093669606576','07/02/1980',43,'Female','Commercial','Martin Boulevard','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','ADhQunTyVGKpLD','15:13:02','2009-11-04','2023-10-30 07:10:39'),(100,'W-30656','Holly','Michael','Brown','IV','Holly Michael Brown IV','kimberlynewman@example.com','095006063411','11/19/1996',27,'Male','Residential','Camia Road','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AFiRINmDwEPklN','17:45:44','1982-04-07','2023-10-30 07:10:39'),(101,'W-45866','Karen','Renee','Rodgers','Ph.D.','Karen Renee Rodgers Ph.D.','jessica56@example.org','094411070816','07/15/1936',87,'Male','Commercial','Bulusan Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','APNfrwYoTQHicP','18:49:21','2018-08-29','2023-10-30 07:10:39'),(102,'W-44149','Sara','Cynthia','Watson','','Sara Cynthia Watson ','browndonald@example.com','093039714513','07/23/1955',68,'Male','Commercial','Owens Boulevard','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AcqnTRdcHsbqyt','06:01:28','1994-09-04','2023-10-30 07:10:39'),(103,'W-18409','Monica','Bradley','Kirby','III','Monica Bradley Kirby III','christinamcgee@example.com','097191532850','02/11/2010',13,'Female','Commercial','Andromeda Drive','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AxosuErSnchDHW','14:37:01','1979-03-26','2023-10-30 07:10:39'),(104,'W-52018','Robert','Emma','Knight','Ph.D.','Robert Emma Knight Ph.D.','peter09@example.net','098646083520','05/22/1994',29,'Male','Residential','11th Street','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','AJKoopEtGaNQvY','22:16:09','1999-12-11','2023-10-30 07:10:39'),(105,'W-38075','Eric','Roger','Kent','CPA','Eric Roger Kent CPA','wharrison@example.com','099968179756','12/27/2009',14,'Female','Commercial','Sapphire Road','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AlvkislyNRKkbK','05:53:28','2014-02-23','2023-10-30 07:10:39'),(106,'W-35237','Sheila','Tonya','House','MBA','Sheila Tonya House MBA','tim08@example.com','091149376749','03/24/1962',61,'Female','Residential','Tulip Street','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ArvPRQhGPcfWGA','06:18:33','2017-09-07','2023-10-30 07:10:39'),(107,'W-11895','Cynthia','Rebecca','Bullock','CPA','Cynthia Rebecca Bullock CPA','dannystark@example.org','092790912962','12/01/1991',32,'Female','Residential','6th Drive','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AVcgRrHsdyChLt','01:05:41','1971-10-13','2023-10-30 07:10:39'),(108,'W-36856','Leslie','Victor','Lowe','IV','Leslie Victor Lowe IV','aguilarmichael@example.net','098011204581','02/12/1946',77,'Male','Commercial','Cabbage Street','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ASxYKKfnsdfWHN','04:26:35','1975-02-07','2023-10-30 07:10:39'),(109,'W-61273','Tiffany','Randy','Blackwell','Ph.D.','Tiffany Randy Blackwell Ph.D.','michael03@example.com','094471978897','09/03/1974',49,'Male','Residential','Samat Boulevard','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AMxJdJQLaPqRUu','16:31:47','1974-10-03','2023-10-30 07:10:39'),(110,'W-50624','Samantha','Roger','Hill','II','Samantha Roger Hill II','grose@example.org','097949632880','11/25/2017',6,'Male','Residential','8th Extension','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AauuCMaRgdwNKs','07:05:20','2020-04-14','2023-10-30 07:10:39'),(111,'W-89363','Danny','Kenneth','Knight','II','Danny Kenneth Knight II','scottthomas@example.net','092605459097','04/26/1986',37,'Male','Commercial','Turquoise Road','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AFHgIIXPEmJMfd','01:18:12','2002-11-17','2023-10-30 07:10:39'),(112,'W-56372','Dominique','Erin','Anthony','M.D.','Dominique Erin Anthony M.D.','xbaker@example.com','094266348464','12/16/2001',22,'Female','Residential','Garnet Road','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ADIiDGKbvsNqNb','05:52:32','2015-01-28','2023-10-30 07:10:39'),(113,'W-45477','Lisa','Pamela','Hughes','Jr.','Lisa Pamela Hughes Jr.','kristine28@example.net','096513435804','10/17/1988',35,'Male','Commercial','93rd Avenue','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ArfwvlbEUhQfoo','01:28:54','2022-08-06','2023-10-30 07:10:39'),(114,'W-26754','Audrey','Cynthia','Roach','Jr.','Audrey Cynthia Roach Jr.','qharris@example.com','092912604998','10/25/2019',4,'Female','Commercial','Sicaba Road','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AvSgGvAQUuxQbC','03:28:51','2023-07-18','2023-10-30 07:10:39'),(115,'W-67200','Erika','Brittany','Jones','III','Erika Brittany Jones III','stephen72@example.net','092233882014','09/10/1945',78,'Male','Residential','Cancer Drive','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AjJrDJZofIesVy','02:51:31','1987-06-06','2023-10-30 07:10:39'),(116,'W-24101','Elizabeth','Kimberly','Bird','Ph.D.','Elizabeth Kimberly Bird Ph.D.','batesbrenda@example.org','099386018852','03/19/1968',55,'Female','Residential','Mars Extension','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AzhQNKIbKEgUQI','22:09:46','1983-04-23','2023-10-30 07:10:39'),(117,'W-74487','Julie','Laura','Lee','PhD','Julie Laura Lee PhD','trujilloapril@example.com','091170417130','04/07/1909',114,'Male','Residential','Samat Road','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','APJPzjomnDovth','05:54:14','2008-11-19','2023-10-30 07:10:39'),(118,'W-88703','Jessica','Michael','Watson','CPA','Jessica Michael Watson CPA','christopherhunt@example.com','093868706293','02/10/1930',93,'Male','Commercial','Virgo Drive','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ATjZRyfUvsmwrB','20:28:14','1973-12-21','2023-10-30 07:10:39'),(119,'W-79768','Jamie','Joseph','Carter','MBA','Jamie Joseph Carter MBA','davidjohnson@example.com','097970456763','06/28/1978',45,'Female','Residential','Diamond Road','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','ATHgjkVkeKgwWS','15:33:56','2023-08-03','2023-10-30 07:10:39'),(120,'W-31030','Jennifer','Kelsey','Taylor','PhD','Jennifer Kelsey Taylor PhD','jonesmichael@example.com','093200945603','08/25/2009',14,'Female','Residential','Pao Drive','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AbYfNqTdQCGOOU','17:45:51','2009-07-15','2023-10-30 07:10:39'),(121,'W-12811','Emily','Erin','Vega','III','Emily Erin Vega III','bryce49@example.net','091606346684','11/30/1977',46,'Female','Commercial','Cordillera Street','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AKKAkrNjlcmaIv','17:56:39','1975-04-29','2023-10-30 07:10:39'),(122,'W-60075','Alexandra','Catherine','Hughes','II','Alexandra Catherine Hughes II','ryanpotter@example.com','092595367624','02/07/1916',107,'Female','Residential','72nd Service Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AMAMTzMfpMupUQ','07:00:04','1998-09-18','2023-10-30 07:10:39'),(123,'W-45369','Maria','Aaron','Morgan','Ph.D.','Maria Aaron Morgan Ph.D.','amanda86@example.com','095269078589','09/03/1961',62,'Female','Commercial','Contreras Street','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ASiHHXYwKmPnFm','09:18:53','2005-07-22','2023-10-30 07:10:39'),(124,'W-70840','Stephanie','Madison','Barber','','Stephanie Madison Barber ','princelarry@example.net','096872762348','05/03/1935',88,'Male','Residential','Malinao Boulevard','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AEoREQcOkEMSjV','07:59:50','2021-08-24','2023-10-30 07:10:39'),(125,'W-70311','Raymond','Joshua','Flores','CPA','Raymond Joshua Flores CPA','michellerodriguez@example.com','092663975324','11/03/1932',91,'Female','Residential','Maldonado Boulevard','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AXxvVjJKAbQkqV','04:56:26','1999-05-04','2023-10-30 07:10:39'),(126,'W-63654','Mary','Joshua','Hickman','II','Mary Joshua Hickman II','timothy16@example.org','094758346571','08/18/1997',26,'Female','Commercial','Mustard Road','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AmNznGNtkasOeC','03:28:18','1996-07-29','2023-10-30 07:10:39'),(127,'W-82005','Robert','James','Reynolds','IV','Robert James Reynolds IV','tvance@example.com','093306035281','02/17/1969',54,'Female','Commercial','Mcgrath Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AXbsAzIerzOmgU','08:06:52','2007-11-17','2023-10-30 07:10:39'),(128,'W-15730','Tricia','Leslie','Warner','','Tricia Leslie Warner ','timothywong@example.com','095739452016','09/24/2005',18,'Male','Commercial','Guijo Road','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','ADLaRXtuhxIFTx','14:57:10','1998-11-21','2023-10-30 07:10:39'),(129,'W-44808','Edward','Cheyenne','Ashley','PhD','Edward Cheyenne Ashley PhD','tina56@example.net','092646126337','08/23/1936',87,'Female','Commercial','24th Avenue','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AoZutzwNbRuCAC','14:18:58','1988-05-05','2023-10-30 07:10:39'),(130,'W-30927','Luis','John','Williams','Sr.','Luis John Williams Sr.','mercadostephanie@example.com','092812047793','08/04/1967',56,'Female','Residential','76th Road','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AFJhbhUXAcTfru','06:29:44','1977-06-14','2023-10-30 07:10:39'),(131,'W-89615','Linda','Julia','Frank','III','Linda Julia Frank III','jenniferanthony@example.com','095904289799','12/19/1997',26,'Female','Commercial','Citrine Street','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AfeScPZEYkLOAU','02:05:00','1977-04-12','2023-10-30 07:10:39'),(132,'W-58538','Alan','Brianna','Rivera','M.D.','Alan Brianna Rivera M.D.','bethany83@example.net','099439888242','01/16/1968',55,'Male','Commercial','Tabayoc Road','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AUeZVTgLQEFfRb','04:52:53','2002-01-27','2023-10-30 07:10:39'),(133,'W-38317','Laura','Lori','Wagner','Jr.','Laura Lori Wagner Jr.','shannonduncan@example.org','098362428478','10/22/2016',7,'Female','Commercial','Bulusan Boulevard','Bagumbayan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','ALZQeYXZaQpSGd','07:06:27','2012-06-02','2023-10-30 07:10:39'),(134,'W-13818','Sabrina','Gina','Weiss','Ph.D.','Sabrina Gina Weiss Ph.D.','joseph04@example.com','092910836084','02/16/1977',46,'Female','Residential','Morgan Road','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AaAZkmeHWyounh','06:20:46','1975-01-16','2023-10-30 07:10:39'),(135,'W-57941','Timothy','Walter','Patel','IV','Timothy Walter Patel IV','zblackwell@example.net','091354590247','12/21/1910',113,'Male','Residential','Asteroid Street','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ALfIGuZdIiXMJo','07:19:24','2001-05-27','2023-10-30 07:10:39'),(136,'W-44305','Matthew','Thomas','Walker','IV','Matthew Thomas Walker IV','beanjared@example.com','092296667588','08/25/1925',98,'Female','Commercial','Mariveles Road Extension','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AqCWJTdGCMdoib','18:11:12','1979-03-26','2023-10-30 07:10:39'),(137,'W-40070','Scott','Charles','Jones','IV','Scott Charles Jones IV','qfreeman@example.net','095527911337','08/09/1908',115,'Female','Residential','Palali Road','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AVmhsaXEoDhPqb','00:42:01','1972-01-17','2023-10-30 07:10:39'),(138,'W-77726','Kelly','James','Hughes','M.D.','Kelly James Hughes M.D.','adam22@example.net','094624170119','07/20/1932',91,'Male','Residential','Avocado Road Extension','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AfYgiSlvGBMYLm','16:31:08','2018-06-23','2023-10-30 07:10:39'),(139,'W-44601','Eric','Courtney','Armstrong','Jr.','Eric Courtney Armstrong Jr.','annahenson@example.com','098856532471','01/24/1939',84,'Female','Commercial','Uranus Avenue','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AyurQIovxywjWB','05:49:31','2014-08-07','2023-10-30 07:10:39'),(140,'W-71803','Dennis','Katie','Scott','IV','Dennis Katie Scott IV','kevin11@example.org','094007406712','08/28/1921',102,'Female','Commercial','53rd Avenue Extension','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AqBsFGdIzyMKxa','13:33:17','2014-02-21','2023-10-30 07:10:39'),(141,'W-76845','Nicole','Alejandra','Gutierrez','II','Nicole Alejandra Gutierrez II','michaelcampbell@example.org','091439261379','03/10/1969',54,'Male','Residential','Matumtum Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','unconfirmed','unpaid','ApqqGFFNrXHHdM','20:39:31','2000-08-18','2023-10-30 07:10:39'),(142,'W-38011','Trevor','Curtis','Klein','II','Trevor Curtis Klein II','davisjeffrey@example.com','099949215758','09/22/1993',30,'Female','Commercial','Opal Street','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AKGCAKuhTVKwRg','19:34:15','1990-08-24','2023-10-30 07:10:39'),(143,'W-42575','Jason','Suzanne','Zimmerman','Jr.','Jason Suzanne Zimmerman Jr.','aconley@example.net','091756463799','03/31/1998',25,'Female','Residential','78th Street','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','ABZZlwzedfrhpL','09:56:41','2017-07-17','2023-10-30 07:10:39'),(144,'W-19232','Christopher','Darrell','Davies','MBA','Christopher Darrell Davies MBA','diane65@example.net','098907893324','03/05/1958',65,'Male','Commercial','Taurus Expressway','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AzZqYLjrIFxOwE','19:37:57','2017-11-04','2023-10-30 07:10:39'),(145,'W-72559','Christopher','Paul','Mckay','MBA','Christopher Paul Mckay MBA','kochoa@example.org','094585481288','10/13/1961',62,'Male','Residential','Mushroom Avenue Extension','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AhptSPrrIeZIcB','09:44:11','1993-04-29','2023-10-30 07:10:39'),(146,'W-13997','Jessica','Mallory','Parker','PhD','Jessica Mallory Parker PhD','jimmy21@example.com','091983795149','09/06/1919',104,'Male','Commercial','74th Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','No','unconfirmed','unpaid','AMgEujaPtqSCdW','18:37:52','2013-04-11','2023-10-30 07:10:39'),(147,'W-64404','Nathaniel','Samuel','Sandoval','PhD','Nathaniel Samuel Sandoval PhD','shannon83@example.org','093230794039','01/22/1918',105,'Male','Commercial','Polaris Drive Extension','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','ArqQtlcUhicnQh','10:12:56','2013-05-17','2023-10-30 07:10:39'),(148,'W-94091','Julie','Kevin','Drake','IV','Julie Kevin Drake IV','chad72@example.net','095756679860','02/05/2013',10,'Female','Commercial','Allen Extension','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','Yes','unconfirmed','unpaid','AmkOxBrguyWKMT','07:02:29','2011-03-17','2023-10-30 07:10:39'),(149,'W-82527','Debra','Paul','Ruiz','II','Debra Paul Ruiz II','rosedana@example.com','097590887220','01/07/1989',34,'Female','Residential','Mcdonald Drive','Libertad','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ArjPgXGeomcLna','18:09:49','1983-10-18','2023-10-30 07:10:39'),(150,'W-74872','William','Robert','Johnson','Ph.D.','William Robert Johnson Ph.D.','yorkjeremy@example.org','095012828527','01/14/1967',56,'Male','Residential','Peridot Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AMoNWVnXXECRGf','03:04:35','1973-02-28','2023-10-30 07:10:39'),(151,'W-44593','Alexis','Misty','Velasquez','MBA','Alexis Misty Velasquez MBA','victoria98@example.com','093476336692','07/24/2022',1,'Female','Residential','Sapphire Boulevard','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AuxAygIpqKXZBl','23:07:21','1993-05-03','2023-10-30 07:10:39'),(152,'W-29149','Gregory','Danielle','Obrien','III','Gregory Danielle Obrien III','marcjohnson@example.org','095448801254','03/27/1915',108,'Male','Residential','82nd Street','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AZyyhpyvxBrHvu','09:34:05','2017-04-03','2023-10-30 07:10:39'),(153,'W-39972','Tony','Marie','Brooks','Sr.','Tony Marie Brooks Sr.','hward@example.org','094722421101','09/12/1951',72,'Female','Residential','Pisces Boulevard Extension','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AOsjUbxSrxipBL','19:50:12','2020-09-21','2023-10-30 07:10:39'),(154,'W-73823','Andre','Ashley','Ross','Jr.','Andre Ashley Ross Jr.','bassmichael@example.org','097169039710','06/06/1984',39,'Female','Residential','Diamond Drive','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','ARvdYUIwzPRVHM','12:11:58','2021-01-07','2023-10-30 07:10:39'),(155,'W-84947','Alyssa','Yolanda','Allen','M.D.','Alyssa Yolanda Allen M.D.','adrian30@example.net','098894860767','02/09/1917',106,'Female','Commercial','29th Boulevard Extension','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AKoeIJzntQgJcQ','21:28:16','1980-01-31','2023-10-30 07:10:39'),(156,'W-91843','Eugene','Michelle','Delacruz','II','Eugene Michelle Delacruz II','sadams@example.net','095105439416','11/06/1954',69,'Female','Commercial','Hernandez Street','San Isidro','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AomKXEzYGRNllb','13:26:12','1983-10-16','2023-10-30 07:10:39'),(157,'W-16311','Scott','Christina','Richardson','','Scott Christina Richardson ','shawnkim@example.net','098792024662','07/30/1943',80,'Female','Residential','Citrine Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AyqqnMYFbcpLbn','22:19:22','1986-03-25','2023-10-30 07:10:39'),(158,'W-65833','Kenneth','Thomas','Garcia','III','Kenneth Thomas Garcia III','moorekristen@example.com','094159670011','11/28/2002',21,'Female','Residential','Aries Highway','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','ATkujSeqYpmVug','12:30:54','1998-10-31','2023-10-30 07:10:39'),(159,'W-82562','Norma','Jeremy','Daniels','II','Norma Jeremy Daniels II','kristyedwards@example.net','099483140502','01/18/2015',8,'Female','Commercial','Apo Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','ABmTOKuKHgChlP','14:13:27','1988-07-15','2023-10-30 07:10:39'),(160,'W-25172','Daniel','Nicole','George','MBA','Daniel Nicole George MBA','taylormatthew@example.org','098122494885','09/12/2017',6,'Female','Commercial','Banahaw Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','AcaIzydhIIhBfM','11:35:23','1982-05-20','2023-10-30 07:10:39'),(161,'W-52444','Lauren','Alec','Gutierrez','Sr.','Lauren Alec Gutierrez Sr.','rjohnson@example.net','094767190660','11/05/1987',36,'Female','Residential','Pisces Road','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AUnAgZtYTvdtJF','00:19:40','1977-12-24','2023-10-30 07:10:39'),(162,'W-40261','Felicia','Abigail','Rodriguez','MBA','Felicia Abigail Rodriguez MBA','stevensangela@example.com','091231553303','09/21/1912',111,'Male','Commercial','3rd Street','Victoria','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AwLsilhPuLNuje','10:24:39','2007-10-26','2023-10-30 07:10:39'),(163,'W-12702','Nicholas','Jennifer','Parker','III','Nicholas Jennifer Parker III','gallegosashley@example.net','099736387465','07/24/1984',39,'Male','Residential','Polaris Street','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','Yes','unconfirmed','unpaid','AFgdzRcEzZCyvu','22:27:15','2003-04-04','2023-10-30 07:10:39'),(164,'W-79324','Andrew','David','Chavez','Sr.','Andrew David Chavez Sr.','susan16@example.com','092930342571','10/16/1926',97,'Female','Commercial','Akle Avenue','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AyUDsSMTQqAZmU','14:41:13','1977-05-01','2023-10-30 07:10:39'),(165,'W-20904','Joseph','Christine','Duran','III','Joseph Christine Duran III','rebecca19@example.org','093372618710','05/13/1972',51,'Female','Commercial','Williams Avenue','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AhHaCOoucQGpVZ','00:11:22','1996-10-08','2023-10-30 07:10:39'),(166,'W-99180','Andrea','James','Crosby','III','Andrea James Crosby III','reevesjennifer@example.org','098152762573','01/26/1977',46,'Male','Commercial','Hanna Boulevard','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AevBfPOrVPlgRo','21:23:09','2004-12-29','2023-10-30 07:10:39'),(167,'W-19345','Brian','Crystal','Henderson','III','Brian Crystal Henderson III','nathanlewis@example.com','092666924641','02/13/2016',7,'Male','Residential','Turquoise Drive','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AKleXkhTjzlXzg','01:43:23','2014-03-06','2023-10-30 07:10:39'),(168,'W-19062','Robert','Daniel','Ellis','IV','Robert Daniel Ellis IV','stevenmiller@example.com','091227633662','08/23/1930',93,'Female','Commercial','91st Drive Extension','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AiiCSXaSgXBonv','07:54:27','1979-09-17','2023-10-30 07:10:39'),(169,'W-89217','Laura','Daisy','Orozco','M.D.','Laura Daisy Orozco M.D.','yarmstrong@example.net','097876393294','08/10/1951',72,'Male','Commercial','Kemp Extension','Libtong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AYxAhZSXKoYVLU','05:33:56','2004-08-05','2023-10-30 07:10:39'),(170,'W-75666','Anthony','Sonya','Campbell','PhD','Anthony Sonya Campbell PhD','maycody@example.org','099801959735','10/24/1951',72,'Female','Residential','Halcon Street','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AoHuXpZYbPfnyB','23:58:58','1978-05-25','2023-10-30 07:10:39'),(171,'W-61714','Jennifer','Scott','Burns','MBA','Jennifer Scott Burns MBA','donna20@example.org','094384478352','05/08/1939',84,'Male','Commercial','Halcon Highway','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','AGGHPTbVRyHskd','09:36:47','1979-11-10','2023-10-30 07:10:39'),(172,'W-34955','Carla','Karen','Church','III','Carla Karen Church III','rickyfischer@example.org','093042695630','04/30/2012',11,'Male','Residential','Azucena Street','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AUQTxWDJdbHDgB','02:25:23','2012-11-05','2023-10-30 07:10:39'),(173,'W-59547','Mary','Lisa','Ferguson','Ph.D.','Mary Lisa Ferguson Ph.D.','bfrey@example.net','093348949894','01/12/1939',84,'Female','Residential','Hydra Road','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AWPuswgzoXZeub','06:16:35','2015-09-23','2023-10-30 07:10:39'),(174,'W-31682','Nancy','Ashley','Daniels','IV','Nancy Ashley Daniels IV','zroberts@example.com','096902304346','06/04/2011',12,'Male','Commercial','Cancer Avenue','Uyao','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','No','unconfirmed','unpaid','AKOJaCoyZIdKwz','01:20:47','1992-07-25','2023-10-30 07:10:39'),(175,'W-11554','Monique','Taylor','Ball','IV','Monique Taylor Ball IV','phillipgonzalez@example.com','096904188883','05/13/1908',115,'Female','Residential','Hercules Street','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AnQBRvuLRXyWkp','16:14:54','2011-02-19','2023-10-30 07:10:39'),(176,'W-71994','Sarah','Matthew','Bolton','CPA','Sarah Matthew Bolton CPA','zcombs@example.net','091499491737','01/19/1963',60,'Male','Commercial','Kanlaon Street','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AXKJDjPqsWaOWS','17:21:21','1973-01-22','2023-10-30 07:10:39'),(177,'W-59368','Cathy','Austin','Wilson','M.D.','Cathy Austin Wilson M.D.','kingjessica@example.org','095164202022','08/10/1984',39,'Male','Residential','Grant Boulevard','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AhBwPHRdKbJIvm','08:10:34','2002-06-29','2023-10-30 07:10:39'),(178,'W-47188','Lindsey','Jessica','Marks','II','Lindsey Jessica Marks II','balldavid@example.com','094993477013','10/09/1913',110,'Male','Commercial','Constellation Street','Happy Valley','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','Yes','No','unconfirmed','unpaid','ATQfJlCwEbGsVh','13:15:10','1993-01-03','2023-10-30 07:10:39'),(179,'W-95175','Karen','Michele','Roberts','III','Karen Michele Roberts III','awhite@example.com','098959940497','08/08/2022',1,'Female','Commercial','Sapphire Avenue','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AZGsaPgCreDilB','01:15:40','1979-07-11','2023-10-30 07:10:39'),(180,'W-44138','Cindy','Melinda','Morris','M.D.','Cindy Melinda Morris M.D.','kevingarza@example.org','094795799725','12/02/1915',108,'Male','Residential','Opal Avenue','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','AcHVFjDXXWTBBS','12:21:39','1976-08-20','2023-10-30 07:10:39'),(181,'W-51452','Rebecca','William','Saunders','Ph.D.','Rebecca William Saunders Ph.D.','richard09@example.org','094098407328','07/09/2003',20,'Female','Commercial','Banahaw Street','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AKGBWYJRVzOyGd','18:12:57','2021-04-06','2023-10-30 07:10:39'),(182,'W-87090','Stephen','Elizabeth','Murphy','PhD','Stephen Elizabeth Murphy PhD','robertberry@example.org','098128376721','09/28/1954',69,'Female','Residential','Jupiter Boulevard','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','ACRHWSNJzUrlbs','16:14:50','2017-02-09','2023-10-30 07:10:39'),(183,'W-38982','Stacy','Shawn','Brown','','Stacy Shawn Brown ','ibaker@example.net','092209433416','02/03/1997',26,'Male','Residential','Amethyst Street','Little Tanauan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AyyzAyWGhzsgWh','02:49:24','2022-03-25','2023-10-30 07:10:39'),(184,'W-80936','Bradley','Ian','Cannon','CPA','Bradley Ian Cannon CPA','griffithmichael@example.com','092883424094','05/06/1947',76,'Female','Residential','Aquarius Street','Paclasan','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','Yes','unconfirmed','unpaid','AQTxDeUMOBrDtG','19:40:51','1973-08-24','2023-10-30 07:10:39'),(185,'W-97571','Erika','Alan','Rodriguez','IV','Erika Alan Rodriguez IV','waynecruz@example.net','099207671981','02/26/1942',81,'Male','Commercial','Jasper Street','Odiong','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','ApAMPAMTQgnVaj','14:50:26','2002-10-11','2023-10-30 07:10:39'),(186,'W-85947','Allison','Karen','Hicks','II','Allison Karen Hicks II','hunteralexander@example.net','098060239764','06/24/1973',50,'Male','Residential','Rodriguez Highway','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','ApWYqSymAzffXk','06:37:39','2022-10-02','2023-10-30 07:10:39'),(187,'W-67808','Danielle','Nicholas','Proctor','Ph.D.','Danielle Nicholas Proctor Ph.D.','lindsay66@example.org','097840487350','05/13/1965',58,'Female','Commercial','Peridot Road','San Rafael','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AWslutMdIzeIuP','20:07:22','2004-02-01','2023-10-30 07:10:39'),(188,'W-91209','Donald','Julia','Sawyer','Sr.','Donald Julia Sawyer Sr.','andreerickson@example.com','094631599604','07/24/1969',54,'Male','Residential','Duhat Road','San Miguel','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','ABVllllcXucsWd','21:32:11','2014-10-11','2023-10-30 07:10:39'),(189,'W-99434','Cole','Mary','Miller','','Cole Mary Miller ','joannesmith@example.com','093724433231','12/04/1992',31,'Female','Residential','Palanan Service Road','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AwncBRwBOdetIf','12:39:44','2018-02-19','2023-10-30 07:10:39'),(190,'W-65238','Jessica','Derek','Barrera','III','Jessica Derek Barrera III','burkedebbie@example.org','098462621657','03/03/1916',107,'Female','Residential','Scorpio Road','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','Yes','No','unconfirmed','unpaid','AsNoTOssyUXPrt','18:50:39','2003-08-30','2023-10-30 07:10:39'),(191,'W-61168','Alyssa','Phillip','Curtis','CPA','Alyssa Phillip Curtis CPA','melissa77@example.com','092860467041','10/21/1984',39,'Male','Commercial','Halcon Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','No','unconfirmed','unpaid','AdVBgdnLPAVlRA','06:05:27','1976-10-03','2023-10-30 07:10:39'),(192,'W-17096','Erin','Jessica','Gray','II','Erin Jessica Gray II','brian95@example.org','099615175889','12/04/1925',98,'Female','Residential','7th Drive Extension','Maraska','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','No','No','unconfirmed','unpaid','ApXTaYBKWWYMRc','08:09:54','2004-09-22','2023-10-30 07:10:39'),(193,'W-84156','Ian','Steven','Watson','III','Ian Steven Watson III','wesleyyang@example.net','094452529381','11/15/1964',59,'Female','Commercial','Halcon Highway','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','Yes','Yes','unconfirmed','unpaid','AdHLoWdKNBufuh','14:20:05','1974-05-13','2023-10-30 07:10:39'),(194,'W-74699','Ronnie','Deborah','Rodriguez','Ph.D.','Ronnie Deborah Rodriguez Ph.D.','wbray@example.net','099078572622','07/04/2003',20,'Female','Commercial','Martinez Street','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','AeHsdvFVCTZKVl','08:15:27','2020-10-17','2023-10-30 07:10:39'),(195,'W-50943','Joseph','Michelle','Clay','Jr.','Joseph Michelle Clay Jr.','malonejeffrey@example.org','097251136768','04/03/1940',83,'Female','Residential','Sunstone Street','Cantil','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','Yes','unconfirmed','unpaid','ASWpwRhpRaPUDH','15:07:28','2010-01-24','2023-10-30 07:10:39'),(196,'W-92336','Danielle','Jacob','Farley','MBA','Danielle Jacob Farley MBA','gphillips@example.com','092185666477','07/24/1981',42,'Female','Commercial','Anubing Avenue Extension','San Vicente','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','Yes','Yes','No','unconfirmed','unpaid','AqMaFGSWvueIPq','22:53:32','1988-08-04','2023-10-30 07:10:39'),(197,'W-40586','Leroy','Roger','Rivers','Sr.','Leroy Roger Rivers Sr.','wlee@example.com','098424670969','07/15/2008',15,'Female','Commercial','Sineguelas Drive','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','Yes','No','No','unconfirmed','unpaid','AwyWlgWLIiNXrI','22:26:51','2019-05-30','2023-10-30 07:10:39'),(198,'W-49967','John','Heather','Robbins','','John Heather Robbins ','rbailey@example.org','095524393418','01/01/1975',48,'Male','Commercial','Samat Road','Dalahican','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','Yes','No','No','Yes','unconfirmed','unpaid','ALTvXLJloAECDT','19:03:12','2020-06-21','2023-10-30 07:10:39'),(199,'W-43862','Steven','Amanda','Swanson','III','Steven Amanda Swanson III','luis33@example.net','093017273002','07/15/1957',66,'Female','Commercial','Garza Boulevard','San Jose','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','AOcIJznGLJCvVC','12:31:02','1997-04-30','2023-10-30 07:10:39'),(200,'W-35628','Bryan','William','Lewis','PhD','Bryan William Lewis PhD','gliu@example.com','094269494565','08/25/1935',88,'Female','Residential','Atis Street','Mabuhay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)','No','No','No','Yes','unconfirmed','unpaid','ApmeCYoNKaONLP','00:10:13','2007-06-30','2023-10-30 07:10:39'),(201,'W-11111','Jeffry','James','Morales','','Jeffry J. Morales','jeffrypaner22@gmail.com','09752950518','01/09/2002',21,'Male','Residential','Amihan 2','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Amihan 2, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','unconfirmed','unpaid','A20231030092511','16:25:11','2023-10-30','2023-10-30 08:25:11'),(204,'W-11111','Monkey','Reid','Paner','','Monkey R. Paner','jeffrypaner222@gmail.com','09383834342','',0,'Male','Residential','Singko','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Singko, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','unconfirmed','unpaid','A20231030092655','16:26:55','2023-10-30','2023-10-30 08:26:55'),(206,'W-11132','Monkey','Reid','Paners','','Monkey R. Paners','jeffrypaner222w@gmail.com','09383834342','01/09/2002',21,'Male','Commercial','Singko','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Singko, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','unconfirmed','unpaid','A20231030093325','16:33:25','2023-10-30','2023-10-30 08:33:25'),(207,'W-11188','Monkeys','Reidss','Paners','','Monkeys R. Paners','jeffrypaner222sw@gmail.com','09383834342','01/09/2002',21,'Male','Residential','Singko','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Singko, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','unconfirmed','unpaid','A20231030093720','16:37:20','2023-10-30','2023-10-30 08:37:20'),(208,'W-57634','Bernardo','Ayanokoji','Paner','','Bernardo A. Paner','monkeydluffy@gmail.com','09383834342','06/19/1966',57,'Male','Residential','Amihan 2','San Aquilino','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Amihan 2, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','Yes','Yes','Yes','Yes','unconfirmed','unpaid','A20231030094040','16:40:40','2023-10-30','2023-10-30 08:40:40');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_data`
--

LOCK TABLES `client_data` WRITE;
/*!40000 ALTER TABLE `client_data` DISABLE KEYS */;
INSERT INTO `client_data` VALUES (1,'WBS-APK-001103023','R20231030081240','W-30458','Angela P. Kelly','wagnercraig@example.net','094041455314','01/19/1944',79,'Residential','Supa Street','San Mariano','Supa Street, San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AUYXhpPXaRcWFt','15:12:40','2023-10-30','2023-10-30 07:12:40'),(2,'WBS-ERR-002103023','R20231030081300','W-88722','Emily R. Robinson','ortizsarah@example.org','098725011010','11/27/1917',106,'Residential','13th Boulevard Extension','Dangay','13th Boulevard Extension, Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines','active','pending','AHJVcJiynGEAAZ','15:13:00','2023-10-30','2023-10-30 07:13:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_secondary_data`
--

LOCK TABLES `client_secondary_data` WRITE;
/*!40000 ALTER TABLE `client_secondary_data` DISABLE KEYS */;
INSERT INTO `client_secondary_data` VALUES (1,'WBS-APK-001103023','Angela','Patrick','Kelly','','Residential','Male','Supa Street','San Mariano','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','15:12:40','2023-10-30','2023-10-30 07:12:40'),(2,'WBS-ERR-002103023','Emily','Robert','Robinson','','Residential','Male','13th Boulevard Extension','Dangay','Roxas','Oriental Mindoro','REGION IV-B (MIMAROPA)','Yes','Yes','Yes','Yes','15:13:00','2023-10-30','2023-10-30 07:13:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_changes`
--

LOCK TABLES `log_changes` WRITE;
/*!40000 ALTER TABLE `log_changes` DISABLE KEYS */;
INSERT INTO `log_changes` VALUES (1,'client_application','INSERT','2023-10-30 08:40:40');
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'SOAJJP20231030064355','Admin','Jeffry James Paner','Sign out',0,'Jeffry James Paner has been signed out.','2023-10-30','13:43:55','2023-10-30 13:43:55'),(2,'SICC20231030064401','Cashier','CASHIER','Sign in',0,'CASHIER has been signed in.','2023-10-30','13:44:01','2023-10-30 13:44:01'),(3,'SOCC20231030064501','Cashier','CASHIER','Sign out',0,'CASHIER has been signed out.','2023-10-30','13:45:01','2023-10-30 13:45:01'),(4,'SIAJJP20231030064505','Admin','Jeffry James Paner','Sign in',0,'Jeffry James Paner has been signed in.','2023-10-30','13:45:05','2023-10-30 13:45:05'),(5,'SOAJJP20231030080923','Admin','Jeffry James Paner','Sign out',0,'Jeffry James Paner has been signed out.','2023-10-30','15:09:23','2023-10-30 15:09:23'),(6,'SICC20231030080930','Cashier','CASHIER','Sign in',0,'CASHIER has been signed in.','2023-10-30','15:09:30','2023-10-30 15:09:30'),(7,'SOCC20231030080941','Cashier','CASHIER','Sign out',0,'CASHIER has been signed out.','2023-10-30','15:09:41','2023-10-30 15:09:41'),(8,'SIAJJP20231030081004','Admin','Jeffry James Paner','Sign in',0,'Jeffry James Paner has been signed in.','2023-10-30','15:10:04','2023-10-30 15:10:04'),(9,'SOAJJP20231030081154','Admin','Jeffry James Paner','Sign out',0,'Jeffry James Paner has been signed out.','2023-10-30','15:11:54','2023-10-30 15:11:54'),(10,'SICC20231030081158','Cashier','CASHIER','Sign in',0,'CASHIER has been signed in.','2023-10-30','15:11:58','2023-10-30 15:11:58'),(11,'SOCC20231030081222','Cashier','CASHIER','Sign out',0,'CASHIER has been signed out.','2023-10-30','15:12:22','2023-10-30 15:12:22'),(12,'SIAJJP20231030081228','Admin','Jeffry James Paner','Sign in',0,'Jeffry James Paner has been signed in.','2023-10-30','15:12:28','2023-10-30 15:12:28'),(13,'SIAJJP20231030090727','Admin','Jeffry James Paner','Sign in',0,'Jeffry James Paner has been signed in.','2023-10-30','16:07:27','2023-10-30 16:07:27'),(14,'SIAJJP20231030092134','Admin','Jeffry James Paner','Sign in',0,'Jeffry James Paner has been signed in.','2023-10-30','16:21:34','2023-10-30 16:21:34');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'ADMIN_05','Payment confirmed for application ID: 5','payment_confirmation','5','2023-10-30 15:12:08',NULL,'unread'),(2,'ADMIN_05','Payment confirmed for application ID: 4','payment_confirmation','4','2023-10-30 15:12:11',NULL,'unread'),(3,'ADMIN_05','Payment confirmed for application ID: 3','payment_confirmation','3','2023-10-30 15:12:14',NULL,'unread'),(4,'ADMIN_05','Payment confirmed for application ID: 2','payment_confirmation','2','2023-10-30 15:12:16',NULL,'read'),(5,'ADMIN_05','Payment confirmed for application ID: 1','payment_confirmation','1','2023-10-30 15:12:18',NULL,'read');
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

-- Dump completed on 2023-10-30 16:45:01
