-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2023 at 07:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wbs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `id` int(5) NOT NULL,
  `barangay` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`id`, `barangay`) VALUES
(1, 'San Aquilino'),
(2, 'Victoria'),
(3, 'San Miguel'),
(4, 'Libertad'),
(5, 'Little Tanauan'),
(6, 'San Mariano'),
(7, 'Mabuhay'),
(8, 'San Rafael'),
(9, 'San Vicente'),
(10, 'Happy Valley'),
(11, 'Cantil'),
(12, 'Dangay'),
(13, 'Bagumbayan'),
(14, 'Paclasan'),
(15, 'Odiong'),
(16, 'Uyao'),
(17, 'Dalahican'),
(18, 'Libtong'),
(19, 'San Isidro'),
(20, 'San Vicente'),
(21, 'San Jose'),
(22, 'Maraska');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(50) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admin_id`, `admin_name`, `designation`, `email`, `password`) VALUES
(1, 'ADMIN_01', 'Jeffry James Paner', 'Admin', 'jeffrypaner@gmail.com', 'jeffry123'),
(2, 'ADMIN_02', 'Rogene Vito', 'Meter Reader', 'meterreader@gmail.com', 'meterreader'),
(3, 'ADMIN_03', 'test', 'Admin', 'test', 'test'),
(4, 'ADMIN_04', 'Anthony Galang', 'Cashier', 'anthonygalang@gmail.com', 'anthony'),
(5, 'ADMIN_05', 'CASHIER', 'Cashier', 'cashier@gmail.com', 'cashier123'),
(6, 'ADMIN_06', 'rogene', 'Admin', 'rogene', 'rogene'),
(7, 'ADMIN_07', 'anthony', 'Admin', 'anthony', 'anthony');

--
-- Triggers `admin`
--
DELIMITER $$
CREATE TRIGGER `admin` BEFORE INSERT ON `admin` FOR EACH ROW BEGIN
	INSERT INTO admin_id VALUES (NULL);
    SET NEW.admin_id = CONCAT("ADMIN_",
LPAD(LAST_INSERT_ID(), 2, "0"));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_id`
--

CREATE TABLE `admin_id` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_id`
--

INSERT INTO `admin_id` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7);

-- --------------------------------------------------------

--
-- Table structure for table `billing_data`
--

CREATE TABLE `billing_data` (
  `id` int(11) NOT NULL,
  `billing_id` varchar(50) NOT NULL,
  `client_id` varchar(20) NOT NULL,
  `prev_reading` varchar(50) DEFAULT NULL,
  `curr_reading` varchar(20) DEFAULT NULL,
  `reading_type` varchar(20) DEFAULT NULL,
  `consumption` varchar(20) DEFAULT NULL,
  `rates` varchar(20) DEFAULT NULL,
  `billing_amount` varchar(20) DEFAULT NULL,
  `billing_status` enum('paid','unpaid') DEFAULT NULL,
  `billing_month` varchar(20) NOT NULL,
  `due_date` date DEFAULT NULL,
  `disconnection_date` date DEFAULT NULL,
  `period_to` date DEFAULT NULL,
  `period_from` date DEFAULT NULL,
  `encoder` varchar(20) NOT NULL,
  `time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing_data`
--

INSERT INTO `billing_data` (`id`, `billing_id`, `client_id`, `prev_reading`, `curr_reading`, `reading_type`, `consumption`, `rates`, `billing_amount`, `billing_status`, `billing_month`, `due_date`, `disconnection_date`, `period_to`, `period_from`, `encoder`, `time`, `date`, `timestamp`) VALUES
(1, 'B-W-71754-1698468637', 'WBS-JJL-009102823', '0', '0', 'current', NULL, NULL, '0', NULL, 'October 2023', NULL, NULL, '2023-10-28', '2023-10-28', 'Jeffry James Paner', '12:50:37', '2023-10-28', '2023-10-28 04:50:37'),
(2, 'B-W-54340-1698468822', 'WBS-MLB-010102823', '0', '0', 'current', NULL, NULL, '0', NULL, 'October 2023', NULL, NULL, '2023-10-28', '2023-10-28', 'Jeffry James Paner', '12:53:42', '2023-10-28', '2023-10-28 04:53:42'),
(3, 'B-W-48253-1698468960', 'WBS-JRC-011102823', '0', '0', 'current', NULL, NULL, '0', NULL, 'October 2023', NULL, NULL, '2023-10-28', '2023-10-28', 'Jeffry James Paner', '12:56:00', '2023-10-28', '2023-10-28 04:56:00'),
(4, 'B-W-19989-1698469429', 'WBS-JMP-012102823', '0', '0', 'current', NULL, NULL, '0', NULL, 'October 2023', NULL, NULL, '2023-10-28', '2023-10-28', 'Jeffry James Paner', '13:03:49', '2023-10-28', '2023-10-28 05:03:49'),
(5, 'B-W-11111-1698469740', 'WBS-JJP-001102823', '0', '0', 'current', NULL, NULL, '0', NULL, 'October 2023', NULL, NULL, '2023-10-28', '2023-10-28', 'Jeffry James Paner', '13:09:00', '2023-10-28', '2023-10-28 05:09:00'),
(6, 'B-W-27786-1698469920', 'WBS-JVJ-002102823', '0', '0', 'current', NULL, NULL, '0', NULL, 'October 2023', NULL, NULL, '2023-10-28', '2023-10-28', 'Jeffry James Paner', '13:12:00', '2023-10-28', '2023-10-28 05:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `clients_archive`
--

CREATE TABLE `clients_archive` (
  `id` int(20) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `prev_reading` int(55) DEFAULT NULL,
  `current_reading` int(55) DEFAULT NULL,
  `amount_due` int(55) DEFAULT NULL,
  `address` varchar(50) NOT NULL,
  `property_type` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients_archive`
--

INSERT INTO `clients_archive` (`id`, `client_id`, `client_name`, `prev_reading`, `current_reading`, `amount_due`, `address`, `property_type`, `email`, `phone_number`, `reg_date`) VALUES
(1448, 'WBS01448', 'Louiella L. Delos Reyes', 0, NULL, 0, 'Little Tanauan', 'Commercial', 'louiella.reyes7271@gmail.com', '662-834-7438', '2023-09-17 16:58:42'),
(1527, 'WBS01527', 'Jose W. James', 0, NULL, 0, 'San Miguel', 'Residential', 'jose.james6498@hotmail.com', '338-999-2544', '2023-09-17 16:58:42'),
(1532, 'WBS01532', 'Lei B. Mayo', 0, NULL, 0, 'San Vicente', 'Commercial', 'lei.mayo6816@hotmail.com', '882-349-3600', '2023-09-17 16:58:42'),
(1534, 'WBS01534', 'Jay J. Garcia', 0, NULL, 0, 'Dangay', 'Residential', 'jay.garcia9507@yahoo.com', '133-169-4792', '2023-09-17 16:58:42'),
(1537, 'WBS01537', 'Leni Robredo', 0, NULL, 0, 'Little Tanauan', 'Commercial', 'lei.robredo7549@hotmail.com', '264-382-2066', '2023-09-17 16:58:42'),
(1538, 'WBS01538', 'Jose E. Robles', 0, NULL, 0, 'San Isidro', 'Commercial', 'jose.robles5700@yahoo.com', '440-790-5861', '2023-09-17 16:58:42'),
(1540, 'WBS01540', 'James C. Catapang', 0, NULL, 0, 'Cantil', 'Residential', 'james.catapang3978@outlook.com', '650-719-5844', '2023-09-17 16:58:42'),
(1541, 'WBS01541', 'Jennifer I. Curry', 0, NULL, 0, 'Libertad', 'Residential', 'jennifer.curry9561@gmail.com', '903-234-2211', '2023-09-17 16:58:42'),
(1542, 'WBS01542', 'James B. Richards', 0, NULL, 0, 'San Vicente', 'Residential', 'james.richards5397@gmail.com', '241-147-6028', '2023-09-17 16:58:42'),
(1544, 'WBS01544', 'Louiella F. Dayanghirang', 0, NULL, 0, 'Mabuhay', 'Commercial', 'louiella.dayanghirang8855@outlook.com', '911-808-9691', '2023-09-17 16:58:42'),
(1545, 'WBS01545', 'Lei H. Morales', 0, NULL, 0, 'San Vicente', 'Residential', 'lei.morales9418@yahoo.com', '902-592-4636', '2023-09-17 16:58:42'),
(1546, 'WBS01546', 'Jep R. Paner', 0, NULL, 0, 'Libtong', 'Commercial', 'jep.paner4335@gmail.com', '707-213-5737', '2023-09-17 16:58:42'),
(1547, 'WBS01547', 'Jep C. Dela Cruz', 0, NULL, 0, 'San Rafael', 'Commercial', 'jep.cruz7466@yahoo.com', '800-143-5042', '2023-09-17 16:58:42'),
(1549, 'WBS01549', 'Nick W. Dayanghirang', 0, NULL, 0, 'Dangay', 'Residential', 'nick.dayanghirang2077@yahoo.com', '896-465-7490', '2023-09-17 16:58:42'),
(1550, 'WBS01550', 'Juanita R. Catapang', 0, NULL, 0, 'San Jose', 'Residential', 'juanita.catapang8924@hotmail.com', '707-143-3490', '2023-09-17 16:58:42'),
(1551, 'WBS01551', 'Jose Paolo X. Mayo', 0, NULL, 0, 'Little Tanauan', 'Residential', 'jose.mayo9436@gmail.com', '648-875-9373', '2023-09-17 16:58:42'),
(1552, 'WBS01552', 'Ann C. Wade', 0, NULL, 0, 'San Mariano', 'Commercial', 'ann.wade1695@hotmail.com', '367-750-7212', '2023-09-17 16:58:42'),
(1553, 'WBS01553', 'PJ F. Mayo', 0, NULL, 0, 'Dangay', 'Residential', 'pj.mayo5319@gmail.com', '129-198-3954', '2023-09-17 16:58:42'),
(1554, 'WBS01554', 'Lebron L. Dayanghirang', 0, NULL, 0, 'Maraska', 'Commercial', 'lebron.dayanghirang7197@outlook.com', '252-709-7961', '2023-09-17 16:58:42'),
(1555, 'WBS01555', 'Joy X. Garcia', 0, NULL, 0, 'Victoria', 'Residential', 'joy.garcia1343@gmail.com', '151-603-9179', '2023-09-17 16:58:42'),
(1556, 'WBS01556', 'James W. Delos Reyes', 0, NULL, 0, 'San Miguel', 'Residential', 'james.reyes7605@hotmail.com', '876-602-8243', '2023-09-17 16:58:42'),
(1557, 'WBS01557', 'Patricia W. Mayo', 0, NULL, 0, 'Bagumbayan', 'Residential', 'patricia.mayo8840@outlook.com', '691-768-8184', '2023-09-17 16:58:42'),
(1558, 'WBS01558', 'Jeffry B. Delos Reyes', 0, NULL, 0, 'Paclasan', 'Residential', 'jeffry.reyes5732@gmail.com', '586-185-3336', '2023-09-17 16:58:42'),
(1559, 'WBS01559', 'Jasper J. Robles', 0, NULL, 0, 'San Mariano', 'Commercial', 'jasper.robles1766@gmail.com', '795-246-8301', '2023-09-17 16:58:42'),
(1560, 'WBS01560', 'Rogene V. Morales', 0, NULL, 0, 'San Vicente', 'Residential', 'rogene.morales2756@hotmail.com', '574-715-4896', '2023-09-17 16:58:42'),
(1561, 'WBS01561', 'Nick J. Uvas', 0, NULL, 0, 'San Jose', 'Residential', 'nick.uvas6276@hotmail.com', '932-311-3253', '2023-09-17 16:58:42'),
(1562, 'WBS01562', 'Patrick P. Jordan', 0, NULL, 0, 'San Rafael', 'Residential', 'patrick.jordan7710@outlook.com', '993-973-9079', '2023-09-17 16:58:42'),
(1563, 'WBS01563', 'Jennifer T. Bryant', 0, NULL, 0, 'Maraska', 'Commercial', 'jennifer.bryant1310@outlook.com', '572-994-2561', '2023-09-17 16:58:42'),
(1564, 'WBS01564', 'Nicpar C. Wade', 0, NULL, 0, 'Uyao', 'Commercial', 'nicpar.wade6273@hotmail.com', '172-560-7617', '2023-09-17 16:58:42'),
(1565, 'WBS01565', 'Hannah I. Richards', 0, NULL, 0, 'Victoria', 'Commercial', 'hannah.richards4992@yahoo.com', '115-137-8757', '2023-09-17 16:58:42'),
(1566, 'WBS01566', 'Jose Paolo T. Jordan', 0, NULL, 0, 'Happy Valley', 'Commercial', 'jose.jordan2295@gmail.com', '291-340-4637', '2023-09-17 16:58:42'),
(1567, 'WBS01567', 'Ann L. Yap', 0, NULL, 0, 'Little Tanauan', 'Residential', 'ann.yap3330@yahoo.com', '130-380-5613', '2023-09-17 16:58:42'),
(1568, 'WBS01568', 'Carl S. Garcia', 0, NULL, 0, 'Uyao', 'Residential', 'carl.garcia8138@yahoo.com', '931-879-9491', '2023-09-17 16:58:42'),
(1569, 'WBS01569', 'Louiella I. Curry', 0, NULL, 0, 'Maraska', 'Commercial', 'louiella.curry3337@hotmail.com', '223-439-5835', '2023-09-17 16:58:42'),
(1570, 'WBS01570', 'Joy A. Mayo', 0, NULL, 0, 'Happy Valley', 'Residential', 'joy.mayo9268@yahoo.com', '929-195-6579', '2023-09-17 16:58:42'),
(1571, 'WBS01571', 'Hannah O. Dela Cruz', 0, NULL, 0, 'San Aquilino', 'Residential', 'hannah.cruz1530@outlook.com', '133-539-7749', '2023-09-17 16:58:42'),
(1572, 'WBS01572', 'Kim V. Richards', 0, NULL, 0, 'Mabuhay', 'Commercial', 'kim.richards2417@hotmail.com', '140-153-9011', '2023-09-17 16:58:42'),
(1573, 'WBS01573', 'Jay U. James', 0, NULL, 0, 'Paclasan', 'Residential', 'jay.james5565@gmail.com', '881-199-9298', '2023-09-17 16:58:42'),
(1574, 'WBS01574', 'Joy T. Curry', 0, NULL, 0, 'San Isidro', 'Residential', 'joy.curry5169@outlook.com', '752-826-3130', '2023-09-17 16:58:42'),
(1575, 'WBS01575', 'Cristel K. Racar', 0, NULL, 0, 'San Aquilino', 'Residential', 'cristel.ortiz4403@outlook.com', '142-405-8487', '2023-09-17 16:58:42'),
(1576, 'WBS01576', 'Kim L. Mayo', 0, NULL, 0, 'Maraska', 'Residential', 'kim.mayo6374@outlook.com', '758-246-4901', '2023-09-17 16:58:42'),
(1577, 'WBS01577', 'Patricia G. Robles', 0, NULL, 0, 'Bagumbayan', 'Commercial', 'patricia.robles7686@hotmail.com', '404-270-5146', '2023-09-17 16:58:42'),
(1578, 'WBS01578', 'Jay Y. Catapang', 0, NULL, 0, 'Paclasan', 'Commercial', 'jay.catapang9464@outlook.com', '929-313-2068', '2023-09-17 16:58:42'),
(1579, 'WBS01579', 'Jose Paolo C. Mayo', 0, NULL, 0, 'Happy Valley', 'Commercial', 'jose.mayo5823@hotmail.com', '569-978-3385', '2023-09-17 16:58:42'),
(1580, 'WBS01580', 'Roderick N. Bryant', 0, NULL, 0, 'San Miguel', 'Commercial', 'roderick.bryant5788@yahoo.com', '803-266-9049', '2023-09-17 16:58:42'),
(1581, 'WBS01581', 'Jennifer F. Catapang', 0, NULL, 0, 'Libertad', 'Residential', 'jennifer.catapang7004@outlook.com', '563-734-7630', '2023-09-17 16:58:42'),
(1582, 'WBS01582', 'James Z. Robles', 0, NULL, 0, 'Mabuhay', 'Commercial', 'james.robles6816@hotmail.com', '315-947-7967', '2023-09-17 16:58:42'),
(1583, 'WBS01583', 'Jose M. Castillo', 0, NULL, 0, 'Paclasan', 'Commercial', 'jose.castillo4023@outlook.com', '657-320-7634', '2023-09-17 16:58:42'),
(1584, 'WBS01584', 'Hannah T. Lee', 0, NULL, 0, 'Bagumbayan', 'Residential', 'hannah.lee1704@gmail.com', '784-927-6592', '2023-09-17 16:58:42'),
(1585, 'WBS01585', 'Rogene R. Garcia', 0, NULL, 0, 'Dangay', 'Residential', 'rogene.garcia4779@yahoo.com', '951-103-9247', '2023-09-17 16:58:42'),
(1586, 'WBS01586', 'Jay A. Bryant', 0, NULL, 0, 'San Aquilino', 'Commercial', 'jay.bryant7937@hotmail.com', '474-314-5505', '2023-09-17 16:58:42'),
(1587, 'WBS01587', 'PJ T. Garcia', 0, NULL, 0, 'Bagumbayan', 'Residential', 'pj.garcia7535@yahoo.com', '295-846-1983', '2023-09-17 16:58:42'),
(1588, 'WBS01588', 'Jasper D. Dayanghirang', 0, NULL, 0, 'San Jose', 'Commercial', 'jasper.dayanghirang2975@hotmail.com', '239-445-9850', '2023-09-17 16:58:42'),
(1589, 'WBS01589', 'Juanita L. Jordan', 0, NULL, 0, 'San Rafael', 'Commercial', 'juanita.jordan5114@outlook.com', '679-434-2015', '2023-09-17 16:58:42'),
(1590, 'WBS01590', 'Patrick C. Dayanghirang', 0, NULL, 0, 'Libertad', 'Commercial', 'patrick.dayanghirang2788@yahoo.com', '826-815-5765', '2023-09-17 16:58:42'),
(1591, 'WBS01591', 'Nick O. Robles', 0, NULL, 0, 'Cantil', 'Commercial', 'nick.robles9316@gmail.com', '792-240-3135', '2023-09-17 16:58:42'),
(1592, 'WBS01592', 'Nick Y. Catapang', 0, NULL, 0, 'San Aquilino', 'Residential', 'nick.catapang6946@yahoo.com', '337-653-9211', '2023-09-17 16:58:42'),
(1593, 'WBS01593', 'Kim U. Bryant', 0, NULL, 0, 'San Mariano', 'Residential', 'kim.bryant9773@outlook.com', '531-762-6201', '2023-09-17 16:58:42'),
(1594, 'WBS01594', 'Joy S. Richards', 0, NULL, 0, 'Little Tanauan', 'Commercial', 'joy.richards9472@yahoo.com', '858-885-1672', '2023-09-17 16:58:42'),
(1595, 'WBS01595', 'Nicpar O. James', 0, NULL, 0, 'Maraska', 'Commercial', 'nicpar.james6465@hotmail.com', '172-357-2206', '2023-09-17 16:58:42'),
(1596, 'WBS01596', 'Hannah U. Yap', 0, NULL, 0, 'San Mariano', 'Residential', 'hannah.yap2205@gmail.com', '654-407-8288', '2023-09-17 16:58:42'),
(1597, 'WBS01597', 'Jennifer K. Robles', 0, NULL, 0, 'San Vicente', 'Residential', 'jennifer.robles1258@outlook.com', '932-928-9603', '2023-09-17 16:58:42'),
(1598, 'WBS01598', 'Lebron K. Festin', 0, NULL, 0, 'Odiong', 'Commercial', 'lebron.festin1575@gmail.com', '209-733-5319', '2023-09-17 16:58:42'),
(1599, 'WBS01599', 'Jose Paolo K. Robles', 0, NULL, 0, 'Uyao', 'Residential', 'jose.robles1109@hotmail.com', '303-477-2651', '2023-09-17 16:58:42'),
(1600, 'WBS01600', 'Hannah V. Wade', 0, NULL, 0, 'Happy Valley', 'Commercial', 'hannah.wade5140@outlook.com', '903-713-5843', '2023-09-17 16:58:42'),
(1602, 'WBS01602', 'Jeffry T. Wade', 0, NULL, 0, 'Odiong', 'Residential', 'jeffry.wade4157@outlook.com', '865-271-3800', '2023-09-17 16:58:42'),
(1603, 'WBS01603', 'Louiella C. Richards', 0, NULL, 0, 'San Aquilino', 'Residential', 'louiella.richards6095@hotmail.com', '845-838-2167', '2023-09-17 16:58:42'),
(1604, 'WBS01604', 'Patrick I. Delos Reyes', 0, NULL, 0, 'San Aquilino', 'Residential', 'patrick.reyes5602@outlook.com', '979-346-9813', '2023-09-17 16:58:42'),
(1605, 'WBS01605', 'Jose X. Jordan', 0, NULL, 0, 'San Aquilino', 'Residential', 'jose.jordan3338@outlook.com', '227-126-9411', '2023-09-17 16:58:42'),
(1606, 'WBS01606', 'Hannah I. Bryant', 0, NULL, 0, 'Uyao', 'Residential', 'hannah.bryant9232@outlook.com', '240-454-8081', '2023-09-17 16:58:42'),
(1607, 'WBS01607', 'Jasper M. Robles', 0, NULL, 0, 'Cantil', 'Residential', 'jasper.robles1243@yahoo.com', '419-242-5379', '2023-09-17 16:58:42'),
(1608, 'WBS01608', 'Roderick A. James', 0, NULL, 0, 'Victoria', 'Residential', 'roderick.james6557@yahoo.com', '823-214-1817', '2023-09-17 16:58:42'),
(1610, 'WBS01610', 'Mark C. Paner', 0, NULL, 0, 'San Jose', 'Commercial', 'mark.paner8781@gmail.com', '993-320-3061', '2023-09-17 16:58:42'),
(1611, 'WBS01611', 'Jose Paolo S. Jordan', 0, NULL, 0, 'Libertad', 'Commercial', 'jose.jordan5083@outlook.com', '452-798-7327', '2023-09-17 16:58:42'),
(1614, 'WBS01614', 'Roderick Q. Lee', 0, NULL, 0, 'San Miguel', 'Commercial', 'roderick.lee8010@hotmail.com', '473-560-9452', '2023-09-17 16:58:42'),
(1615, 'WBS01615', 'Cristel F. James', 0, NULL, 0, 'Little Tanauan', 'Commercial', 'cristel.james4341@gmail.com', '830-269-1118', '2023-09-17 16:58:42'),
(1616, 'WBS01616', 'Mark M. Festin', 0, NULL, 0, 'Dangay', 'Commercial', 'mark.festin5031@hotmail.com', '797-918-6814', '2023-09-17 16:58:42'),
(1617, 'WBS01617', 'James F. Uvas', 0, NULL, 0, 'Libertad', 'Residential', 'james.uvas3235@hotmail.com', '357-649-4792', '2023-09-17 16:58:42'),
(1618, 'WBS01618', 'Jose H. Morales', 0, NULL, 0, 'Mabuhay', 'Commercial', 'jose.morales1255@gmail.com', '345-242-4617', '2023-09-17 16:58:42'),
(1620, 'WBS01620', 'Carl O. Wade', 0, NULL, 0, 'Paclasan', 'Residential', 'carl.wade8543@gmail.com', '639-754-8229', '2023-09-17 16:58:42'),
(1621, 'WBS01621', 'Justine F. Morales', 0, NULL, 0, 'Mabuhay', 'Commercial', 'justine.morales6565@hotmail.com', '547-108-6775', '2023-09-17 16:58:42'),
(1622, 'WBS01622', 'Hannah R. Paner', 0, NULL, 0, 'Happy Valley', 'Commercial', 'hannah.paner7232@outlook.com', '632-709-7889', '2023-09-17 16:58:42'),
(1625, 'WBS01625', 'Jep H. Curry', 0, NULL, 0, 'Libertad', 'Residential', 'jep.curry1512@outlook.com', '801-715-8724', '2023-09-17 16:58:42'),
(1628, 'WBS01628', 'Hannah U. Catapang', 0, NULL, 0, 'Uyao', 'Commercial', 'hannah.catapang7800@hotmail.com', '649-502-6350', '2023-09-17 16:58:42'),
(1629, 'WBS01629', 'Jasper M. Paner', 0, NULL, 0, 'Mabuhay', 'Residential', 'jasper.paner1667@yahoo.com', '758-780-4169', '2023-09-17 16:58:42'),
(1631, 'WBS01631', 'Carl V. Lee', 0, NULL, 0, 'Little Tanauan', 'Residential', 'carl.lee5851@gmail.com', '867-696-7264', '2023-09-17 16:58:42'),
(1673, 'WBS01674', '', NULL, NULL, NULL, '', 'Commercial', '', '', '2023-09-22 00:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `client_application`
--

CREATE TABLE `client_application` (
  `id` int(11) NOT NULL,
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
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_application`
--

INSERT INTO `client_application` (`id`, `meter_number`, `first_name`, `middle_name`, `last_name`, `name_suffix`, `full_name`, `email`, `phone_number`, `birthdate`, `age`, `gender`, `property_type`, `street`, `brgy`, `municipality`, `province`, `region`, `full_address`, `valid_id`, `proof_of_ownership`, `deed_of_sale`, `affidavit`, `status`, `billing_status`, `application_id`, `time`, `date`, `timestamp`) VALUES
(1, 'W-13322', 'Paul', 'Kevin', 'Sawyer', 'Sr.', 'Paul Kevin Sawyer Sr.', 'hensonjasmine@example.net', '094662882684', '05/11/1919', 104, 'Female', 'Residential', 'Pandan Street', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'confirmed', 'unpaid', 'ANPjrNymjYKomj', '23:01:16', '1996-02-19', '2023-10-26 04:35:55'),
(2, 'W-90801', 'Rebecca', 'Shane', 'Smith', 'CPA', 'Rebecca Shane Smith CPA', 'acrawford@example.org', '092539284029', '06/13/1923', 100, 'Male', 'Commercial', '62nd Street', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'No', 'confirmed', 'unpaid', 'AVYujWXuvuGYOa', '06:56:05', '1981-02-03', '2023-10-26 04:35:55'),
(3, 'W-74697', 'Kyle', 'Michaela', 'Elliott', '', 'Kyle Michaela Elliott ', 'ambervang@example.com', '098642446086', '06/04/1997', 26, 'Male', 'Commercial', 'Shepard Street', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', '', '', '', '', 'confirmed', 'unpaid', 'AmRfkDUfsoFdQS', '04:19:43', '2021-09-15', '2023-10-26 04:35:55'),
(4, 'W-93731', 'Laura', 'Kenneth', 'Johnston', 'Ph.D.', 'Laura Kenneth Johnston Ph.D.', 'karenramos@example.com', '098584000342', '12/26/2013', 10, 'Male', 'Commercial', 'Zinia Road', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', '', '', '', '', 'confirmed', 'unpaid', 'AAqecBDpxRvtwu', '10:09:35', '2006-12-21', '2023-10-26 04:35:55'),
(5, 'W-52221', 'Andrea', 'Angela', 'Cardenas', 'Ph.D.', 'Andrea Angela Cardenas Ph.D.', 'lestermeghan@example.org', '097453127950', '09/06/1956', 67, 'Male', 'Residential', 'Amethyst Drive', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'confirmed', 'unpaid', 'AHyLvCpEeqjVrl', '16:27:32', '2015-12-27', '2023-10-26 04:35:55'),
(6, 'W-93961', 'Tara', 'Thomas', 'Torres', 'CPA', 'Tara Thomas Torres CPA', 'frostkatie@example.com', '091642661290', '02/25/1924', 99, 'Female', 'Commercial', 'Orion Road', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'confirmed', 'unpaid', 'AlRZqSDrevAZMo', '05:53:20', '1988-02-24', '2023-10-26 05:59:39'),
(7, 'W-96691', 'Karla', 'Tina', 'Mcguire', 'M.D.', 'Karla Tina Mcguire M.D.', 'hannah52@example.org', '099957362870', '01/24/1937', 86, 'Male', 'Residential', 'Tate Road Extension', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'confirmed', 'unpaid', 'AdnJiHAyJzPSBS', '07:19:52', '1981-10-02', '2023-10-26 06:01:17'),
(8, 'W-85754', 'Robert', 'Thomas', 'Weeks', '', 'Robert Thomas Weeks ', 'linda52@example.org', '093236456183', '02/09/1978', 45, 'Female', 'Commercial', 'Kamias Street', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'confirmed', 'unpaid', 'AbVqZRIbxyCHeU', '10:28:00', '1983-03-05', '2023-10-26 06:02:53'),
(10, 'W-48253', 'Jeremiah', 'Rebecca', 'Chan', 'MBA', 'Jeremiah R. Chan MBA', 'randallgordon@example.com', '093263237356', '10/04/1944', 79, 'Male', 'Commercial', '3rd Boulevard', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', '3rd Boulevard, Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AioSVRguhxlQXu', '14:07:37', '1989-02-16', '2023-10-26 11:45:15'),
(11, 'W-27786', 'James', 'Vincentss', 'James', 'Sr.', 'James V. James Sr.', 'tanderson@example.net', '096121127612', '05/03/1991', 32, 'Female', 'Commercial', '88th Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', '88th Road, San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AQrHKJLCetdDDp', '14:07:24', '1999-02-07', '2023-10-26 11:46:17'),
(12, 'W-44049', 'Marie', 'Cynthia', 'Owens', 'MBA', 'Marie C. Owens MBA', 'thomasholden@example.org', '097603593472', '11/28/1992', 31, 'Male', 'Commercial', 'Norton Avenue', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Norton Avenue, Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'ASoKVKzMfFUsXv', '19:25:38', '1997-01-31', '2023-10-26 11:46:52'),
(13, 'W-54340', 'Michelle', 'Lawrence', 'Brown', '', 'Michelle L. Brown', 'christinawyatt@example.net', '094832588560', '03/24/1959', 64, 'Female', 'Commercial', 'Tabayoc Drive', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Tabayoc Drive, San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AOaLluQvCELLSe', '05:42:19', '1976-04-17', '2023-10-26 11:47:22'),
(14, 'W-71754', 'Jason', 'Jimmy', 'Lyons', 'III', 'Jason J. Lyons III', 'jason01@example.com', '091291387757', '05/24/1981', 42, 'Male', 'Commercial', 'Saturn Extension', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Saturn Extension, San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'ArttUpplXcOVCa', '00:13:49', '2000-02-02', '2023-10-26 11:47:58'),
(16, 'W-23256', 'Alexis', 'Matthew', 'Williams', 'II', 'Alexis M. Williams II', 'amyjohnson@example.com', '097220891514', '07/19/1933', 90, 'Female', 'Commercial', 'Planet Highway', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Planet Highway, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AmtekWWUUUzwlA', '10:18:41', '2019-12-20', '2023-10-26 11:57:53'),
(17, 'W-23015', 'Michael', 'Brandon', 'Tyler', 'IV', 'Michael B. Tyler IV', 'tdominguez@example.net', '092784809984', '02/11/1970', 53, 'Female', 'Residential', 'Amihan 2', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Amihan 2, Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AmhzrawyxaHmqL', '00:34:26', '2017-11-10', '2023-10-26 12:06:34'),
(19, 'W-24479', 'Carolyn', 'Nancy', 'Panner', '', 'Carolyn N. Panner', 'sullivanchad@example.net', '098959567366', '09/30/1995', 28, 'Female', 'Residential', 'Collins Drive', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Collins Drive, Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AUqzlHrnMLoQbW', '08:59:28', '1999-03-17', '2023-10-26 14:13:40'),
(20, 'W-31557', 'Ruth', 'Kelly', 'Olson', 'IV', 'Ruth Kelly Olson IV', 'cartermichael@example.org', '093782790661', '11/17/1987', 36, 'Male', 'Residential', 'Asteroid Street', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AUEqKyLBBXhJRS', '04:18:37', '2004-11-10', '2023-10-26 04:35:55'),
(21, 'W-18788', 'Jesse', 'Todd', 'Combs', 'IV', 'Jesse Todd Combs IV', 'ocollins@example.org', '097472521890', '07/06/1994', 29, 'Female', 'Commercial', 'Camia Avenue', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AbisgviZqOZlCY', '11:28:17', '2010-09-01', '2023-10-26 04:35:55'),
(22, 'W-23346', 'Ryan', 'Brandi', 'Phillips', 'Ph.D.', 'Ryan Brandi Phillips Ph.D.', 'stephengray@example.com', '098976244155', '02/06/2012', 11, 'Female', 'Commercial', 'Pluto Street', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AoSPlLenpCERiB', '11:24:57', '2009-06-27', '2023-10-26 04:35:55'),
(23, 'W-25843', 'Samantha', 'Seth', 'Lewis', 'CPA', 'Samantha Seth Lewis CPA', 'brandi89@example.net', '095558490350', '03/24/1969', 54, 'Female', 'Residential', 'Samat Road', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'ADRofyPaimnkhh', '22:57:01', '2002-04-10', '2023-10-26 04:35:55'),
(24, 'W-56156', 'Wayne', 'Tonya', 'Santiago', '', 'Wayne Tonya Santiago ', 'dstrickland@example.org', '092439031349', '10/04/1980', 43, 'Female', 'Commercial', 'Adams Street', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AWQnMxFkhtfLls', '23:44:23', '1992-03-20', '2023-10-26 04:35:55'),
(25, 'W-93407', 'Lucas', 'Nicole', 'Stevenson', 'Ph.D.', 'Lucas Nicole Stevenson Ph.D.', 'bondkatherine@example.org', '091219355984', '01/10/1991', 32, 'Female', 'Residential', 'Bulusan Street', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AzBDJtvtanQuSd', '15:45:35', '2023-03-06', '2023-10-26 04:35:55'),
(26, 'W-19797', 'Christine', 'Christina', 'Larson', 'CPA', 'Christine Christina Larson CPA', 'smithdana@example.com', '093165908249', '06/21/1909', 114, 'Female', 'Commercial', 'Smith Road', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AcmULQsdKXbFCG', '08:16:15', '1978-01-03', '2023-10-26 04:35:55'),
(27, 'W-40315', 'Ashley', 'David', 'Shelton', 'IV', 'Ashley David Shelton IV', 'cruzkylie@example.com', '096413466205', '02/18/1915', 108, 'Female', 'Commercial', 'Cordillera Drive', 'San Mariano', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AqNBFpvvBBSiGD', '09:01:16', '2001-12-18', '2023-10-26 04:35:55'),
(28, 'W-85326', 'Brenda', 'Douglas', 'Powell', 'M.D.', 'Brenda Douglas Powell M.D.', 'perezsara@example.net', '097476890496', '08/29/1995', 28, 'Male', 'Residential', 'Zodiac Drive', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AGQALIvMELdbYf', '23:25:36', '1996-08-29', '2023-10-26 04:35:55'),
(29, 'W-14548', 'Ann', 'William', 'Sims', 'MBA', 'Ann William Sims MBA', 'rebecca95@example.net', '099323022590', '06/27/2012', 11, 'Female', 'Residential', 'Earth Road', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AIdnJIicbQLNyk', '10:57:15', '1978-06-18', '2023-10-26 04:35:55'),
(30, 'W-45181', 'Shelley', 'Elizabeth', 'Berry', 'IV', 'Shelley Elizabeth Berry IV', 'qwagner@example.org', '094522761453', '08/28/1969', 54, 'Male', 'Commercial', 'Bulusan Avenue', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AnZDcMKfzXOWuF', '13:38:25', '1981-11-22', '2023-10-26 04:35:55'),
(31, 'W-18982', 'Gregory', 'Christopher', 'Wilkinson', 'M.D.', 'Gregory Christopher Wilkinson M.D.', 'jbennett@example.net', '092712793193', '03/04/1990', 33, 'Female', 'Commercial', '41st Road', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ArYyMXqSxIHAkm', '00:32:04', '1974-03-11', '2023-10-26 04:35:55'),
(32, 'W-28072', 'Andrew', 'Donna', 'Peck', 'Sr.', 'Andrew Donna Peck Sr.', 'lnorton@example.org', '092178156864', '11/24/2018', 5, 'Female', 'Residential', '5th Extension', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AeMfNPoYXZQToi', '04:05:47', '1989-01-28', '2023-10-26 04:35:55'),
(33, 'W-56760', 'William', 'Joel', 'Robertson', 'II', 'William Joel Robertson II', 'jennifer79@example.net', '095107533304', '02/13/1992', 31, 'Male', 'Residential', 'Oliva Road', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AQjYdDLMOwgzza', '13:33:09', '2006-02-02', '2023-10-26 04:35:55'),
(34, 'W-27804', 'Sarah', 'Vanessa', 'Carey', 'PhD', 'Sarah Vanessa Carey PhD', 'donna25@example.com', '092785459735', '12/24/1931', 92, 'Female', 'Residential', 'Weaver Street', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ALiQblOgsgqPWN', '16:45:23', '2018-01-03', '2023-10-26 04:35:55'),
(35, 'W-78896', 'Anthony', 'Kevin', 'Thompson', '', 'Anthony Kevin Thompson ', 'anna08@example.com', '094399942183', '06/10/1986', 37, 'Female', 'Commercial', 'Wilson Street', 'Libertad', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AKrgZbYDdXPlcE', '07:42:44', '1976-01-08', '2023-10-26 04:35:55'),
(36, 'W-61160', 'Jennifer', 'Stephen', 'Morales', 'PhD', 'Jennifer Stephen Morales PhD', 'jpatel@example.net', '097606267451', '02/07/2020', 3, 'Male', 'Residential', 'Lily Road', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AjCokKZBMmWisC', '21:44:09', '2016-10-12', '2023-10-26 04:35:55'),
(37, 'W-77493', 'Brooke', 'David', 'Armstrong', 'CPA', 'Brooke David Armstrong CPA', 'kimberly05@example.com', '092265709553', '06/19/1957', 66, 'Male', 'Residential', 'Sagittarius Street', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ATMvLIgNRAEVMU', '02:12:31', '2003-12-10', '2023-10-26 04:35:55'),
(38, 'W-71757', 'Jeffrey', 'Travis', 'Dean', 'Jr.', 'Jeffrey Travis Dean Jr.', 'turnermason@example.com', '094045010943', '02/19/1935', 88, 'Female', 'Commercial', 'Onyx Road', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AjsuVWxJJfHeLX', '02:34:23', '1988-08-06', '2023-10-26 04:35:55'),
(39, 'W-25107', 'Joanne', 'David', 'Frank', 'III', 'Joanne David Frank III', 'cynthia38@example.net', '095132191183', '11/05/1920', 103, 'Female', 'Residential', 'Underwood Street', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AAxEnomiBKXNoM', '01:19:22', '1986-07-08', '2023-10-26 04:35:55'),
(40, 'W-26639', 'John', 'Mark', 'Glover', 'PhD', 'John Mark Glover PhD', 'joykim@example.org', '092700335470', '10/05/2001', 22, 'Male', 'Commercial', 'Sierra Madre Drive', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ARwUeGZOyZJXir', '01:16:05', '2015-09-18', '2023-10-26 04:35:55'),
(41, 'W-16166', 'Bradley', 'Matthew', 'Schaefer', 'IV', 'Bradley Matthew Schaefer IV', 'emilysullivan@example.com', '095683235479', '02/01/1915', 108, 'Female', 'Commercial', 'Lawaan Avenue', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AfthdlAOvplxom', '13:08:50', '2003-02-01', '2023-10-26 04:35:55'),
(42, 'W-91844', 'Brian', 'Lori', 'Phillips', 'III', 'Brian Lori Phillips III', 'kim35@example.org', '098206135286', '01/11/1926', 97, 'Female', 'Residential', 'Long Street', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AKSgIcvkZZCFpi', '08:22:34', '2005-05-12', '2023-10-26 04:35:55'),
(43, 'W-74599', 'Melissa', 'John', 'Davila', 'MBA', 'Melissa John Davila MBA', 'annamunoz@example.com', '096167691496', '05/02/1922', 101, 'Male', 'Commercial', 'Richards Drive', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'APOXICnAYejafr', '17:05:01', '1980-02-05', '2023-10-26 04:35:55'),
(44, 'W-23057', 'Karen', 'Christina', 'Camacho', 'MBA', 'Karen Christina Camacho MBA', 'griffithjill@example.org', '091270981461', '01/23/2002', 21, 'Male', 'Residential', 'Gladiola Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AQiTRaTPtZqSAy', '16:13:00', '1981-12-20', '2023-10-26 04:35:55'),
(45, 'W-39591', 'Vanessa', 'Matthew', 'Blevins', 'M.D.', 'Vanessa Matthew Blevins M.D.', 'bbailey@example.org', '093212873469', '06/17/1970', 53, 'Male', 'Residential', 'Santan Avenue', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AaxQQHrkkfiKDx', '01:51:15', '2016-07-15', '2023-10-26 04:35:55'),
(46, 'W-42828', 'Carrie', 'Jason', 'Mercado', 'Ph.D.', 'Carrie Jason Mercado Ph.D.', 'pcolon@example.org', '094046243908', '03/03/1951', 72, 'Female', 'Residential', '75th Boulevard', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AxrbAbrMxkMXJb', '21:16:25', '1987-04-01', '2023-10-26 04:35:55'),
(47, 'W-80707', 'Mary', 'Alicia', 'Zuniga', 'Jr.', 'Mary Alicia Zuniga Jr.', 'jwalker@example.com', '093229299262', '03/20/2015', 8, 'Female', 'Residential', 'Amethyst Avenue', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AgQsKWvEMvnbhB', '09:35:07', '1993-03-26', '2023-10-26 04:35:55'),
(48, 'W-92812', 'Melvin', 'Samuel', 'Murphy', 'IV', 'Melvin Samuel Murphy IV', 'courtney27@example.net', '092067631458', '08/11/1951', 72, 'Male', 'Commercial', 'Alexander Extension', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AcUrqCrHxWlHGP', '04:42:04', '1997-05-05', '2023-10-26 04:35:55'),
(49, 'W-27442', 'Mario', 'Claudia', 'Taylor', 'II', 'Mario Claudia Taylor II', 'greencolleen@example.org', '096875152515', '12/02/1925', 98, 'Female', 'Residential', 'Amber Avenue', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AhTZPsVCrkaPli', '04:52:02', '2023-10-01', '2023-10-26 04:35:55'),
(50, 'W-59880', 'Patricia', 'David', 'Jenkins', 'IV', 'Patricia David Jenkins IV', 'castromichael@example.net', '091920058275', '11/11/2013', 10, 'Female', 'Commercial', 'Pao Avenue', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AKFJXhbTcExZsr', '12:29:43', '2017-10-13', '2023-10-26 04:35:55'),
(51, 'W-81698', 'Amanda', 'Lauren', 'Lopez', 'CPA', 'Amanda Lauren Lopez CPA', 'isaachancock@example.org', '098132287605', '05/10/2000', 23, 'Female', 'Residential', '65th Avenue', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AestOtbUXtejTw', '09:57:28', '1985-08-22', '2023-10-26 04:35:55'),
(52, 'W-26675', 'Ashley', 'Ryan', 'Morgan', 'MBA', 'Ashley Ryan Morgan MBA', 'katherinechristian@example.org', '095934196483', '08/15/1992', 31, 'Male', 'Residential', 'Amethyst Drive', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AcNESwwUGmeIJA', '19:06:29', '2020-01-06', '2023-10-26 04:35:55'),
(53, 'W-76674', 'Ronnie', 'John', 'Howe', 'II', 'Ronnie John Howe II', 'eric72@example.com', '098151439876', '04/04/1967', 56, 'Female', 'Commercial', 'Gomez Road', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AhHlrmZwISjfHH', '04:48:27', '1978-11-14', '2023-10-26 04:35:55'),
(54, 'W-52809', 'Gary', 'Katie', 'Wagner', '', 'Gary Katie Wagner ', 'william38@example.net', '092362253506', '05/09/1916', 107, 'Female', 'Commercial', 'Galaxy Street', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AhIjRkzsXlKKtV', '23:42:27', '1976-08-08', '2023-10-26 04:35:55'),
(55, 'W-16777', 'Michelle', 'Scott', 'Parrish', 'III', 'Michelle Scott Parrish III', 'gbrooks@example.org', '094220256524', '09/06/1988', 35, 'Male', 'Commercial', 'Narra Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'ApKvwPdxPBgAIg', '01:31:33', '1974-08-29', '2023-10-26 04:35:55'),
(56, 'W-24442', 'Dana', 'Janet', 'Gross', 'Jr.', 'Dana Janet Gross Jr.', 'janiceguzman@example.net', '093618888753', '04/22/1965', 58, 'Female', 'Residential', 'Cordillera Drive Extension', 'Libertad', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AzgOgIfOaziVSv', '22:57:57', '1983-06-12', '2023-10-26 04:35:55'),
(57, 'W-35292', 'Jacqueline', 'Jonathan', 'Ryan', 'MBA', 'Jacqueline Jonathan Ryan MBA', 'antonio34@example.com', '092669824925', '10/13/1930', 93, 'Female', 'Residential', 'Tabayoc Street', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AzHDuevGglCzIL', '14:37:13', '2008-09-08', '2023-10-26 04:35:55'),
(58, 'W-13754', 'Cody', 'Shawn', 'Kelly', 'Jr.', 'Cody Shawn Kelly Jr.', 'wcallahan@example.org', '093453155781', '12/24/2019', 4, 'Female', 'Residential', 'Caraballo Avenue', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AYlsyzSSYUmxnU', '06:19:28', '2013-10-27', '2023-10-26 04:35:55'),
(59, 'W-69874', 'John', 'Michael', 'Goodwin', 'PhD', 'John Michael Goodwin PhD', 'patelmatthew@example.org', '097988383176', '04/29/1978', 45, 'Female', 'Commercial', 'Jasper Extension', 'San Mariano', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AbTqkdqUDjAGKF', '17:27:06', '2008-04-08', '2023-10-26 04:35:55'),
(60, 'W-92783', 'Michael', 'Andrea', 'Byrd', 'II', 'Michael Andrea Byrd II', 'alexandrabryan@example.org', '091914119577', '10/14/1970', 53, 'Female', 'Residential', 'Taylor Road', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'APUcROYWpHooUG', '21:12:19', '1990-08-07', '2023-10-26 04:35:55'),
(61, 'W-68887', 'Evelyn', 'Jamie', 'Sullivan', 'MBA', 'Evelyn Jamie Sullivan MBA', 'duncangarrett@example.org', '092816429185', '01/23/2005', 18, 'Male', 'Commercial', 'Calantas Drive', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AwxYJsCCVtDUap', '08:15:16', '1999-05-19', '2023-10-26 04:35:55'),
(62, 'W-43440', 'Michael', 'Matthew', 'Schroeder', 'Ph.D.', 'Michael Matthew Schroeder Ph.D.', 'graycynthia@example.com', '092596154174', '03/15/2023', 0, 'Male', 'Residential', 'Capricorn Street', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AJBSruuvMzUxtC', '07:05:48', '1971-12-16', '2023-10-26 04:35:55'),
(63, 'W-33081', 'Jill', 'Michelle', 'Brown', 'Sr.', 'Jill Michelle Brown Sr.', 'zrice@example.org', '094346949157', '07/06/1931', 92, 'Male', 'Residential', 'Matumtum Street', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AvLNYhKwfKKfXH', '23:31:47', '1989-10-30', '2023-10-26 04:35:55'),
(64, 'W-24307', 'Margaret', 'Jennifer', 'Swanson', 'Sr.', 'Margaret Jennifer Swanson Sr.', 'mwilson@example.net', '095711732838', '04/18/1968', 55, 'Female', 'Residential', 'Thompson Street', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AKGdanPDwFAjZb', '10:37:21', '2011-03-03', '2023-10-26 04:35:55'),
(65, 'W-71168', 'John', 'Madison', 'Santos', 'CPA', 'John Madison Santos CPA', 'gwelch@example.org', '094563104219', '05/21/1964', 59, 'Female', 'Commercial', 'Topaz Extension', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AkKoDgqxWnnWxr', '13:32:54', '2004-06-21', '2023-10-26 04:35:55'),
(66, 'W-72118', 'Lisa', 'Elizabeth', 'Stewart', 'Ph.D.', 'Lisa Elizabeth Stewart Ph.D.', 'pchambers@example.com', '097643206766', '12/05/1940', 83, 'Male', 'Commercial', 'Sardonyx Avenue', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ABtsEepWIFFJyJ', '15:23:53', '1998-12-18', '2023-10-26 04:35:55'),
(67, 'W-48082', 'Samantha', 'William', 'Gomez', 'M.D.', 'Samantha William Gomez M.D.', 'isantos@example.org', '096817889177', '11/08/1967', 56, 'Male', 'Residential', 'Calantas Road', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AatDUKtvLzGVeb', '00:33:04', '2015-12-20', '2023-10-26 04:35:55'),
(68, 'W-42117', 'Benjamin', 'Yolanda', 'Myers', 'PhD', 'Benjamin Yolanda Myers PhD', 'tgonzales@example.net', '094485301903', '07/16/2023', 0, 'Male', 'Residential', 'Sierra Madre Street', 'Uyao', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AwklVhllnKIaix', '02:18:35', '1991-12-25', '2023-10-26 04:35:55'),
(69, 'W-24433', 'Ashley', 'Erika', 'Alexander', 'III', 'Ashley Erika Alexander III', 'ann80@example.net', '092093510726', '09/30/1951', 72, 'Male', 'Commercial', 'Dita Highway', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'ABmxxoUTXHNgNy', '13:43:51', '2000-08-07', '2023-10-26 04:35:55'),
(70, 'W-93890', 'Daniel', 'Kimberly', 'Collins', 'II', 'Daniel Kimberly Collins II', 'james12@example.net', '093724879440', '05/03/1955', 68, 'Male', 'Commercial', '98th Drive', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AfTByOmQlZOrei', '19:19:26', '2009-04-01', '2023-10-26 04:35:55'),
(71, 'W-32012', 'Sylvia', 'Robert', 'Hardy', 'Sr.', 'Sylvia Robert Hardy Sr.', 'fisherchristopher@example.org', '094470932873', '06/10/1932', 91, 'Female', 'Residential', 'Peridot Drive Extension', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AwOrUOnRtAqtJc', '00:03:11', '2022-12-24', '2023-10-26 04:35:55'),
(72, 'W-13576', 'Christopher', 'James', 'Baker', 'Sr.', 'Christopher James Baker Sr.', 'wmahoney@example.org', '091434784275', '12/17/1962', 61, 'Female', 'Residential', 'Halcon Road', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ADMFsVdqyZRNoh', '10:48:02', '2018-06-19', '2023-10-26 04:35:55'),
(73, 'W-76853', 'David', 'Amanda', 'Campbell', 'CPA', 'David Amanda Campbell CPA', 'kathryn56@example.net', '093032755076', '04/12/1980', 43, 'Male', 'Residential', '70th Road Extension', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AjZjPmfSGdlljB', '22:26:22', '2019-09-10', '2023-10-26 04:35:55'),
(74, 'W-82744', 'Andrew', 'Katie', 'Bradley', 'IV', 'Andrew Katie Bradley IV', 'carriebrooks@example.com', '093197583030', '08/27/2000', 23, 'Female', 'Commercial', 'Milky Way Avenue', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AZOEGCvwxUEDUe', '16:04:07', '1995-01-18', '2023-10-26 04:35:55'),
(75, 'W-15886', 'Christine', 'Jessica', 'Bruce', 'PhD', 'Christine Jessica Bruce PhD', 'johngrimes@example.com', '099135890180', '10/26/2005', 18, 'Female', 'Commercial', 'Galaxy Avenue', 'San Mariano', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'ADMOUiTyStyIRV', '04:58:14', '1977-03-27', '2023-10-26 04:35:55'),
(76, 'W-77675', 'Monica', 'Michael', 'Hoffman', '', 'Monica Michael Hoffman ', 'davissamuel@example.net', '095687589766', '10/19/1976', 47, 'Female', 'Commercial', 'Venus Road', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AqzOxwKFJzjxMG', '10:59:36', '1999-11-23', '2023-10-26 04:35:55'),
(77, 'W-31196', 'Tiffany', 'Caleb', 'Taylor', 'III', 'Tiffany Caleb Taylor III', 'julie64@example.com', '098249428553', '10/10/1973', 50, 'Female', 'Residential', 'Ruby Road', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AJRBkuWQCDcCeR', '21:02:39', '2015-02-09', '2023-10-26 04:35:55'),
(78, 'W-69047', 'Cynthia', 'Mark', 'Diaz', 'Jr.', 'Cynthia Mark Diaz Jr.', 'kpollard@example.com', '095277589727', '04/03/1952', 71, 'Female', 'Commercial', 'Hydra Street', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AZfcQTTvkjTtSD', '21:24:18', '1979-02-21', '2023-10-26 04:35:55'),
(79, 'W-67179', 'Andrea', 'Deanna', 'Thornton', 'II', 'Andrea D. Thornton II', 'kleinjane@example.org', '096215735968', '09/20/1981', 42, 'Female', 'Residential', 'Mars Street', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mars Street, Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'AEVVROGOoTRtUQ', '17:26:45', '2001-04-01', '2023-10-26 14:41:33'),
(80, 'W-19481', 'Thomas', 'Kristi', 'King', 'PhD', 'Thomas Kristi King PhD', 'caitlin86@example.com', '093824187886', '03/09/1957', 66, 'Female', 'Residential', '2nd Drive', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ApITcZzfkeUifR', '13:00:26', '1978-07-30', '2023-10-26 04:35:55'),
(81, 'W-75207', 'William', 'Heather', 'Ray', 'M.D.', 'William Heather Ray M.D.', 'gardnercarlos@example.net', '091205937975', '01/07/1947', 76, 'Male', 'Commercial', 'Makiling Drive', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'ALxlqRqxRYwYne', '15:25:17', '1981-11-29', '2023-10-26 04:35:55'),
(82, 'W-90455', 'Brenda', 'Paul', 'Robinson', 'II', 'Brenda Paul Robinson II', 'williamlopez@example.net', '099657551513', '08/27/1987', 36, 'Female', 'Residential', '67th Road Extension', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'APYlSWREcTpvIO', '23:35:09', '2018-12-28', '2023-10-26 04:35:55'),
(83, 'W-66937', 'Kimberly', 'Michael', 'Allen', 'Ph.D.', 'Kimberly Michael Allen Ph.D.', 'maciaskimberly@example.net', '099998581781', '06/16/1954', 69, 'Male', 'Commercial', 'Jupiter Drive Extension', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AxAziSwNsfRUvd', '12:37:41', '2018-11-26', '2023-10-26 04:35:55'),
(84, 'W-93955', 'Misty', 'Samantha', 'Anderson', 'Jr.', 'Misty Samantha Anderson Jr.', 'brian35@example.com', '093878707382', '08/25/1933', 90, 'Female', 'Commercial', 'Sicaba Street', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AzUFRJwepvNGnC', '20:42:02', '1978-08-21', '2023-10-26 04:35:55'),
(85, 'W-10199', 'Katherine', 'Juan', 'Conrad', 'PhD', 'Katherine Juan Conrad PhD', 'anthony59@example.org', '092157634135', '12/13/1907', 116, 'Male', 'Commercial', '46th Road Extension', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AduOgaMYrBxAwT', '21:11:17', '2002-06-10', '2023-10-26 04:35:55'),
(86, 'W-38869', 'Clayton', 'Lisa', 'Baker', 'Ph.D.', 'Clayton Lisa Baker Ph.D.', 'chanamanda@example.net', '093627077394', '08/29/1959', 64, 'Female', 'Residential', 'Jacaranda Avenue', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AKDJZEouXoqErt', '00:42:12', '1978-09-24', '2023-10-26 04:35:55'),
(87, 'W-41434', 'James', 'Lisa', 'Lopez', 'CPA', 'James Lisa Lopez CPA', 'taylorbarbara@example.org', '091029665271', '07/30/1975', 48, 'Female', 'Commercial', 'Aquamarine Avenue', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AOvJaUvkLcfuIH', '08:30:42', '2023-06-05', '2023-10-26 04:35:55'),
(88, 'W-10900', 'Logan', 'Brianna', 'Hines', '', 'Logan Brianna Hines ', 'katie76@example.com', '092113519775', '11/17/1943', 80, 'Male', 'Commercial', 'Andromeda Road', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AigehOtvXfXWbt', '18:04:35', '2001-11-14', '2023-10-26 04:35:55'),
(89, 'W-45867', 'Daniel', 'Renee', 'Green', 'PhD', 'Daniel Renee Green PhD', 'joshua67@example.net', '095829225916', '06/17/1961', 62, 'Female', 'Commercial', 'Caraballo Avenue', 'Uyao', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AgundmjFiZxUsf', '08:54:20', '1970-05-26', '2023-10-26 04:35:55'),
(90, 'W-76830', 'Robert', 'Christopher', 'Mercer', 'PhD', 'Robert Christopher Mercer PhD', 'vperez@example.com', '092509507740', '12/20/1942', 81, 'Female', 'Residential', 'Neptune Road', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AqsWtjAYJFICHu', '05:30:29', '2000-05-05', '2023-10-26 04:35:55'),
(91, 'W-31629', 'Tracy', 'Sylvia', 'Mccann', 'II', 'Tracy Sylvia Mccann II', 'hughesjoshua@example.net', '092606323306', '04/06/1935', 88, 'Male', 'Residential', 'Caraballo Road Extension', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AivfJivDVpbLAE', '22:27:01', '2018-07-22', '2023-10-26 04:35:55'),
(92, 'W-33961', 'Bryan', 'Henry', 'Moore', '', 'Bryan Henry Moore ', 'browncrystal@example.net', '094501430902', '08/28/2002', 21, 'Female', 'Commercial', 'Libra Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AudwTerXqWPHGN', '15:34:24', '2004-10-21', '2023-10-26 04:35:55'),
(93, 'W-47836', 'Aaron', 'Derek', 'Benjamin', 'IV', 'Aaron Derek Benjamin IV', 'bullockmary@example.org', '097532231195', '09/01/1926', 97, 'Female', 'Commercial', '87th Street', 'Uyao', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AwGPmmhyKrdEVg', '11:56:47', '1978-11-29', '2023-10-26 04:35:55'),
(94, 'W-13595', 'Natalie', 'Matthew', 'Palmer', 'PhD', 'Natalie Matthew Palmer PhD', 'anthony07@example.net', '095805980952', '07/12/1940', 83, 'Male', 'Residential', 'Caraballo Road', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AFDorcoezcwRXX', '13:37:02', '1970-07-24', '2023-10-26 04:35:55'),
(95, 'W-95905', 'John', 'Peggy', 'Lee', 'PhD', 'John Peggy Lee PhD', 'davisanne@example.org', '099965501543', '08/10/1921', 102, 'Male', 'Commercial', 'Aries Extension', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AEsvgfeZttnYAq', '00:10:24', '2000-04-18', '2023-10-26 04:35:55'),
(96, 'W-88009', 'Angela', 'Andre', 'Vasquez', 'M.D.', 'Angela Andre Vasquez M.D.', 'banksedward@example.net', '098509857310', '02/16/1999', 24, 'Female', 'Commercial', '25th Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AzwAMvTfERneBC', '02:42:40', '1987-01-19', '2023-10-26 04:35:55'),
(97, 'W-68779', 'Jason', 'Debra', 'Murphy', 'CPA', 'Jason Debra Murphy CPA', 'mfranco@example.net', '099106054512', '04/16/1917', 106, 'Male', 'Residential', 'Mercury Street', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AKGMuBeYsZLAhd', '11:07:48', '2012-11-29', '2023-10-26 04:35:55'),
(98, 'W-10721', 'Jason', 'Sarah', 'Jackson', 'Jr.', 'Jason Sarah Jackson Jr.', 'brittany85@example.com', '098889824461', '12/22/2009', 14, 'Female', 'Commercial', 'Anonas Road', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AYoNVgcyiySdkc', '14:02:17', '2023-06-27', '2023-10-26 04:35:55'),
(99, 'W-46132', 'Darlene', 'Brian', 'Morris', 'Jr.', 'Darlene Brian Morris Jr.', 'anthonynorris@example.net', '097588465540', '11/09/1968', 55, 'Female', 'Commercial', 'Planet Road Extension', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ALJiTtvcOqvKyr', '04:39:41', '1998-11-23', '2023-10-26 04:35:55'),
(100, 'W-21505', 'Gary', 'Linda', 'Stewart', 'Sr.', 'Gary Linda Stewart Sr.', 'dpalmer@example.com', '098645807652', '10/13/1936', 87, 'Male', 'Residential', 'Kanlaon Street', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ALwRdiCinoPgAM', '23:24:13', '1971-08-16', '2023-10-26 04:35:55'),
(101, 'W-91547', 'Lori', 'Nicole', 'Miller', 'III', 'Lori Nicole Miller III', 'sarawilliamson@example.net', '098311936450', '04/11/1982', 41, 'Female', 'Residential', '45th Street', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AZWaWUawgJezSv', '19:41:00', '1979-10-20', '2023-10-26 04:35:55'),
(102, 'W-78070', 'Deanna', 'Jared', 'Holmes', 'Sr.', 'Deanna Jared Holmes Sr.', 'jenniferbarnett@example.com', '099805020384', '08/08/1955', 68, 'Male', 'Residential', 'Apo Road', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AoPWrlzgYhnIFp', '01:50:22', '2004-04-25', '2023-10-26 04:35:55'),
(103, 'W-88164', 'Dennis', 'Jeremy', 'Lopez', 'M.D.', 'Dennis Jeremy Lopez M.D.', 'jennifer10@example.com', '093110212777', '11/02/1980', 43, 'Female', 'Commercial', 'Mars Boulevard', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AnHLlXHPbSmDon', '08:24:57', '2013-02-22', '2023-10-26 04:35:55'),
(104, 'W-29272', 'David', 'Michelle', 'Jefferson', 'III', 'David Michelle Jefferson III', 'elizabethhoffman@example.net', '099791520580', '12/12/2019', 4, 'Female', 'Commercial', 'Campanilla Boulevard', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AvihxValJNbrhJ', '13:58:29', '2021-02-08', '2023-10-26 04:35:55'),
(105, 'W-24614', 'Anna', 'Susan', 'Fernandez', 'M.D.', 'Anna Susan Fernandez M.D.', 'jesseolson@example.com', '099091679775', '07/10/1951', 72, 'Female', 'Commercial', '43rd Drive', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AKRWWrhBsXdKKE', '01:28:53', '2004-03-16', '2023-10-26 04:35:55'),
(106, 'W-35381', 'Ronald', 'Jason', 'Arias', 'Jr.', 'Ronald Jason Arias Jr.', 'tony82@example.org', '091563864903', '02/11/1973', 50, 'Female', 'Residential', '47th Drive', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AqDdkYVSaIZmyu', '20:32:13', '1977-07-01', '2023-10-26 04:35:55'),
(107, 'W-70936', 'Michael', 'Sara', 'Allen', 'PhD', 'Michael Sara Allen PhD', 'jesus91@example.net', '091370165537', '04/06/2019', 4, 'Male', 'Residential', 'Ruby Avenue', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'APDTRVlKkkxcZV', '12:43:35', '2000-06-22', '2023-10-26 04:35:55'),
(108, 'W-29757', 'Mark', 'Jennifer', 'Diaz', 'Jr.', 'Mark Jennifer Diaz Jr.', 'morgan31@example.com', '096954895945', '03/20/1919', 104, 'Female', 'Commercial', 'Opal Street', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AjvprXKftDoTCV', '23:02:32', '1972-10-31', '2023-10-26 04:35:55'),
(109, 'W-48913', 'Shelby', 'Kenneth', 'Brown', '', 'Shelby Kenneth Brown ', 'jessica41@example.com', '096133218305', '09/14/1930', 93, 'Female', 'Commercial', 'Harris Road Extension', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AhLMzJgNRXiXhf', '22:06:49', '1990-10-30', '2023-10-26 04:35:55'),
(110, 'W-72138', 'Curtis', 'Nicole', 'Robbins', 'III', 'Curtis Nicole Robbins III', 'nicole46@example.net', '097770086792', '12/24/2022', 1, 'Male', 'Commercial', 'Hester Drive', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ACqOZvTCVbTdRb', '15:26:53', '1972-07-02', '2023-10-26 04:35:55'),
(111, 'W-70107', 'Brian', 'Michelle', 'Miller', 'Jr.', 'Brian Michelle Miller Jr.', 'connorjones@example.org', '096765825718', '11/15/1987', 36, 'Female', 'Commercial', 'Gemini Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AQJTOYOSIYdZOp', '08:39:40', '1970-05-06', '2023-10-26 04:35:55'),
(112, 'W-81577', 'John', 'Keith', 'Phelps', '', 'John Keith Phelps ', 'xavier00@example.org', '093591887919', '04/05/1971', 52, 'Female', 'Residential', 'Peterson Street', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AbUESIjqgLwmyB', '02:15:13', '1997-02-20', '2023-10-26 04:35:55'),
(113, 'W-67873', 'Linda', 'Sarah', 'Cardenas', 'III', 'Linda Sarah Cardenas III', 'jvalencia@example.org', '095222266834', '01/22/1917', 106, 'Male', 'Residential', '92nd Road', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AwdVBqyyzpVrdF', '03:59:16', '1990-10-19', '2023-10-26 04:35:55'),
(114, 'W-29556', 'Cassandra', 'Christopher', 'Vega', 'PhD', 'Cassandra Christopher Vega PhD', 'jeremy70@example.org', '094613819911', '05/13/2017', 6, 'Female', 'Residential', 'Ruby Drive Extension', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AkPDHTIRZqZzem', '20:32:11', '2007-09-07', '2023-10-26 04:35:55'),
(115, 'W-62135', 'Robert', 'Rachel', 'Baker', 'Ph.D.', 'Robert Rachel Baker Ph.D.', 'ericahoffman@example.net', '098539992459', '01/27/1933', 90, 'Female', 'Commercial', 'Reynolds Street', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AQHhqPaelMQmBq', '08:58:39', '2007-08-30', '2023-10-26 04:35:55'),
(116, 'W-22073', 'Michael', 'Trevor', 'Garcia', 'M.D.', 'Michael Trevor Garcia M.D.', 'erinmerritt@example.org', '092523001927', '06/07/1999', 24, 'Female', 'Residential', 'Atok Road', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AMqjRpfntIhAzb', '22:03:34', '2019-11-20', '2023-10-26 04:35:55'),
(117, 'W-20801', 'Joseph', 'Lacey', 'Reynolds', 'IV', 'Joseph Lacey Reynolds IV', 'tracygates@example.com', '092314663441', '03/07/1913', 110, 'Female', 'Residential', 'Sampaloc Road', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ADgEOXphkyBfcz', '11:16:50', '1992-01-27', '2023-10-26 04:35:55'),
(118, 'W-86002', 'Oscar', 'Jose', 'Marshall', 'MBA', 'Oscar Jose Marshall MBA', 'jennifermcbride@example.net', '096995897869', '08/07/1944', 79, 'Female', 'Commercial', 'Lawaan Avenue', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AQhxjhzWyLFMCV', '13:51:29', '1975-10-05', '2023-10-26 04:35:55');
INSERT INTO `client_application` (`id`, `meter_number`, `first_name`, `middle_name`, `last_name`, `name_suffix`, `full_name`, `email`, `phone_number`, `birthdate`, `age`, `gender`, `property_type`, `street`, `brgy`, `municipality`, `province`, `region`, `full_address`, `valid_id`, `proof_of_ownership`, `deed_of_sale`, `affidavit`, `status`, `billing_status`, `application_id`, `time`, `date`, `timestamp`) VALUES
(119, 'W-98253', 'Dylan', 'Karina', 'Rhodes', 'M.D.', 'Dylan Karina Rhodes M.D.', 'lindsey43@example.net', '093779203957', '10/19/1985', 38, 'Female', 'Commercial', 'Pao Street', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AdSSvGqLBRPKcU', '22:21:58', '2000-12-31', '2023-10-26 04:35:55'),
(120, 'W-80527', 'David', 'Adam', 'Flores', 'II', 'David Adam Flores II', 'alexandra84@example.com', '091427073697', '05/20/1908', 115, 'Female', 'Residential', 'Halcon Road', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AoJcBRQfwjronR', '20:59:52', '2004-10-29', '2023-10-26 04:35:55'),
(121, 'W-29118', 'Patricia', 'Bobby', 'Perez', 'IV', 'Patricia Bobby Perez IV', 'michelle80@example.org', '091977289846', '11/07/1931', 92, 'Female', 'Commercial', 'Hydra Street', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AomjxxQOZgsGzp', '16:21:03', '2020-08-20', '2023-10-26 04:35:55'),
(122, 'W-13750', 'Joyce', 'Matthew', 'Tucker', 'II', 'Joyce Matthew Tucker II', 'jessicafisher@example.org', '093475609490', '01/27/1948', 75, 'Male', 'Residential', '56th Street', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AiNfABiHSHQhcA', '18:21:08', '2006-06-06', '2023-10-26 04:35:55'),
(123, 'W-31185', 'Charles', 'Leon', 'Allen', 'Ph.D.', 'Charles Leon Allen Ph.D.', 'johnfreeman@example.net', '098730566044', '06/08/1998', 25, 'Male', 'Commercial', 'Sicaba Drive', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AsPquuaAtzUBvc', '08:27:03', '1987-08-20', '2023-10-26 04:35:55'),
(124, 'W-35877', 'Samuel', 'Jennifer', 'Davis', 'CPA', 'Samuel Jennifer Davis CPA', 'mary27@example.net', '092577327841', '11/12/1912', 111, 'Male', 'Commercial', '33rd Extension', 'San Mariano', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AatTdliadHihHe', '03:26:18', '1994-11-03', '2023-10-26 04:35:55'),
(125, 'W-50552', 'James', 'Kenneth', 'Stevens', 'M.D.', 'James Kenneth Stevens M.D.', 'parkerallen@example.net', '094608258739', '01/30/1990', 33, 'Male', 'Residential', 'Pluto Road', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'APNzkmWIihzCFw', '01:13:54', '1996-07-13', '2023-10-26 04:35:55'),
(126, 'W-87314', 'Benjamin', 'Sherry', 'Adkins', 'MBA', 'Benjamin Sherry Adkins MBA', 'pwu@example.org', '093029289102', '07/08/2009', 14, 'Female', 'Residential', 'Balete Street', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AMDyuDCOfegdHE', '23:01:09', '1983-02-09', '2023-10-26 04:35:55'),
(127, 'W-55617', 'Michelle', 'Wayne', 'Mcmillan', 'CPA', 'Michelle Wayne Mcmillan CPA', 'lmoore@example.org', '099886446080', '04/23/1927', 96, 'Female', 'Commercial', 'Catmon Drive Extension', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'ArmOHtNuouuqQP', '12:05:37', '1973-12-24', '2023-10-26 04:35:55'),
(128, 'W-76501', 'James', 'Alicia', 'Grant', 'MBA', 'James Alicia Grant MBA', 'nicholas95@example.net', '092096073909', '01/08/2013', 10, 'Female', 'Commercial', 'Howard Extension', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AHPNgqLvZxvEgq', '15:32:20', '1985-11-17', '2023-10-26 04:35:55'),
(129, 'W-88786', 'Joshua', 'Christopher', 'Campbell', 'M.D.', 'Joshua Christopher Campbell M.D.', 'jwalters@example.com', '093890236313', '07/25/1930', 93, 'Male', 'Residential', 'Samat Drive', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AkTBErTsHGsRHL', '17:14:06', '1992-03-04', '2023-10-26 04:35:55'),
(130, 'W-75081', 'Mark', 'Joseph', 'Rodriguez', 'IV', 'Mark Joseph Rodriguez IV', 'brandon68@example.org', '091193048181', '08/26/2019', 4, 'Male', 'Commercial', 'Turquoise Street', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AFZwdsMfWFEHAn', '04:39:21', '2007-09-25', '2023-10-26 04:35:55'),
(131, 'W-20093', 'James', 'Keith', 'Evans', 'M.D.', 'James Keith Evans M.D.', 'masonallen@example.com', '095267770017', '10/08/1925', 98, 'Female', 'Commercial', 'Acacia Drive', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AElTyKvwdtaGar', '16:54:38', '2005-01-01', '2023-10-26 04:35:55'),
(132, 'W-61888', 'Barbara', 'David', 'Anderson', 'CPA', 'Barbara David Anderson CPA', 'michaelaguilar@example.net', '094691023232', '10/08/1923', 100, 'Male', 'Commercial', 'Holloway Extension', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ANfehyVqQALuzw', '22:22:45', '2005-10-14', '2023-10-26 04:35:55'),
(133, 'W-95980', 'Barbara', 'Daniel', 'Jordan', '', 'Barbara Daniel Jordan ', 'parkergrace@example.com', '098176962932', '01/20/2017', 6, 'Male', 'Commercial', 'Makiling Street', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AzfPGfHvjqFSyf', '12:38:16', '2002-04-01', '2023-10-26 04:35:55'),
(134, 'W-36554', 'Taylor', 'Deanna', 'George', 'M.D.', 'Taylor Deanna George M.D.', 'collinjones@example.org', '099571160654', '12/24/1963', 60, 'Female', 'Commercial', 'Sapphire Boulevard', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AkaoVeEGHlCvse', '17:27:12', '2006-03-30', '2023-10-26 04:35:55'),
(135, 'W-83318', 'Jessica', 'Diana', 'Haley', 'CPA', 'Jessica Diana Haley CPA', 'twilson@example.net', '098722512926', '10/20/1921', 102, 'Male', 'Commercial', 'Amethyst Avenue', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AlsawDxzbXijpL', '01:22:58', '1980-06-07', '2023-10-26 04:35:55'),
(136, 'W-64327', 'Jessica', 'Jackie', 'Foster', 'Sr.', 'Jessica Jackie Foster Sr.', 'terrijackson@example.net', '097900792630', '04/15/1990', 33, 'Male', 'Commercial', 'Dao Street', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AamPBqbjlBTzow', '11:54:06', '1976-09-21', '2023-10-26 04:35:55'),
(137, 'W-76636', 'Pamela', 'Raymond', 'Pham', 'II', 'Pamela Raymond Pham II', 'gallowayjoshua@example.org', '094603186001', '08/23/1961', 62, 'Female', 'Residential', 'Cancer Road', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AeRgvxwiWLajru', '06:21:40', '1992-05-28', '2023-10-26 04:35:55'),
(138, 'W-81499', 'Tracey', 'Amy', 'Ramirez', 'MBA', 'Tracey Amy Ramirez MBA', 'williamsthomas@example.net', '099227766417', '11/03/1958', 65, 'Male', 'Residential', 'Moonstone Drive', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AvxBjcurosEkLx', '22:32:36', '1998-09-13', '2023-10-26 04:35:55'),
(139, 'W-64248', 'Carl', 'Daniel', 'Brennan', 'CPA', 'Carl Daniel Brennan CPA', 'birdlaura@example.org', '095546085767', '12/16/2002', 21, 'Female', 'Residential', 'Orion Drive', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'APcsHWlrkPvpay', '07:21:52', '1979-02-04', '2023-10-26 04:35:55'),
(140, 'W-75897', 'Elizabeth', 'Lisa', 'Owens', 'CPA', 'Elizabeth Lisa Owens CPA', 'hallfaith@example.net', '092841962065', '12/31/1969', 54, 'Female', 'Residential', 'Nipa Boulevard', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AeAhwzrNYjbLxX', '01:48:13', '1996-02-08', '2023-10-26 04:35:55'),
(141, 'W-80016', 'Anthony', 'Robert', 'Wilson', 'Ph.D.', 'Anthony Robert Wilson Ph.D.', 'fparker@example.com', '091390613942', '11/21/1985', 38, 'Male', 'Commercial', 'Palanan Drive', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AgYvuHSfScrRbH', '09:42:59', '1979-06-11', '2023-10-26 04:35:55'),
(142, 'W-68375', 'Randy', 'Dawn', 'Lopez', 'CPA', 'Randy Dawn Lopez CPA', 'yanderson@example.com', '099371265125', '09/27/1913', 110, 'Female', 'Commercial', 'Mariveles Street', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'ARiioGhdveOWyB', '07:58:37', '1983-07-05', '2023-10-26 04:35:55'),
(143, 'W-11017', 'Richard', 'Jason', 'Morris', 'III', 'Richard Jason Morris III', 'bwyatt@example.com', '092399264514', '11/09/1919', 104, 'Male', 'Residential', 'Jade Street', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AnWzizOBXYFbLZ', '18:16:50', '2005-05-06', '2023-10-26 04:35:55'),
(144, 'W-91309', 'Anita', 'Jerry', 'Craig', 'IV', 'Anita Jerry Craig IV', 'lynn06@example.net', '094584713590', '05/08/2017', 6, 'Female', 'Commercial', 'Wilkerson Extension', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ACmmCmwUzInadd', '04:44:43', '2008-09-03', '2023-10-26 04:35:55'),
(145, 'W-98722', 'Albert', 'Patrick', 'Mcbride', 'II', 'Albert Patrick Mcbride II', 'zjohnson@example.org', '092186911166', '09/25/1984', 39, 'Male', 'Residential', 'Ruby Drive', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AZKxnxIUJcZxJy', '06:48:43', '2003-06-12', '2023-10-26 04:35:55'),
(146, 'W-76609', 'Regina', 'Thomas', 'Butler', 'Jr.', 'Regina Thomas Butler Jr.', 'prestonjessica@example.org', '095662376019', '12/10/1977', 46, 'Male', 'Commercial', 'Libra Street', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AuSmNRZWzRscyY', '01:04:40', '2006-01-29', '2023-10-26 04:35:55'),
(147, 'W-53124', 'Melissa', 'Christine', 'Sims', '', 'Melissa Christine Sims ', 'miguel57@example.net', '093679875569', '11/09/2000', 23, 'Female', 'Commercial', 'Constellation Drive', 'Odiong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Odiong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AyKKnRVySKRUcs', '06:27:18', '1990-11-19', '2023-10-26 04:35:55'),
(148, 'W-59547', 'Brian', 'Kevin', 'Yu', 'Sr.', 'Brian Kevin Yu Sr.', 'philip23@example.org', '098951284912', '11/25/1975', 48, 'Male', 'Residential', 'Davis Road', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Rafael, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AnmflIDxAJIOSL', '04:28:54', '1990-01-13', '2023-10-26 04:35:55'),
(149, 'W-82339', 'Joseph', 'Alice', 'Wells', 'Sr.', 'Joseph Alice Wells Sr.', 'ebonyramirez@example.org', '093351309719', '09/05/2013', 10, 'Female', 'Residential', 'Peridot Extension', 'San Mariano', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AlgevjUcOTQrQe', '22:34:53', '1980-12-26', '2023-10-26 04:35:55'),
(150, 'W-11233', 'Dustin', 'Tony', 'Reynolds', 'Ph.D.', 'Dustin Tony Reynolds Ph.D.', 'tracyho@example.org', '095751998084', '03/22/1953', 70, 'Female', 'Commercial', 'Arayat Street', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AwaYRxvSjnmFfA', '18:38:52', '1993-10-11', '2023-10-26 04:35:55'),
(151, 'W-36318', 'Reginald', 'Cheryl', 'Patterson', 'Ph.D.', 'Reginald Cheryl Patterson Ph.D.', 'vmorris@example.net', '098961574225', '03/18/1991', 32, 'Female', 'Residential', 'Aquarius Drive', 'Uyao', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AAsGzOBWAJySST', '02:01:49', '2007-11-16', '2023-10-26 04:35:55'),
(152, 'W-35796', 'James', 'Calvin', 'Anderson', 'PhD', 'James Calvin Anderson PhD', 'nguyenandrea@example.org', '095483561085', '02/06/2015', 8, 'Female', 'Residential', 'Diamond Street', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AWzZgGDWaFFYuE', '19:24:15', '2019-11-08', '2023-10-26 04:35:55'),
(153, 'W-52410', 'Elizabeth', 'Kristin', 'Gonzalez', 'Jr.', 'Elizabeth Kristin Gonzalez Jr.', 'nicole33@example.net', '094615246507', '04/25/1962', 61, 'Female', 'Residential', 'Matumtum Street', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'APmJWxhWGGeFlC', '07:44:36', '1971-01-16', '2023-10-26 04:35:55'),
(154, 'W-43872', 'Amanda', 'Connie', 'Mccormick', 'Ph.D.', 'Amanda Connie Mccormick Ph.D.', 'feliciaphillips@example.org', '095976184876', '04/21/1930', 93, 'Male', 'Residential', 'Dickerson Boulevard', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AEsVOOAxPZgzod', '20:06:40', '2012-03-29', '2023-10-26 04:35:55'),
(155, 'W-21825', 'Johnny', 'Olivia', 'Sanchez', 'PhD', 'Johnny Olivia Sanchez PhD', 'hunterjones@example.org', '097472160920', '02/17/2022', 1, 'Female', 'Residential', 'Cresta Street', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AuvUPgpYHGRNXu', '13:45:40', '1980-11-19', '2023-10-26 04:35:55'),
(156, 'W-34975', 'Brian', 'Brady', 'Fletcher', 'PhD', 'Brian Brady Fletcher PhD', 'twilliamson@example.net', '098933374681', '01/19/1981', 42, 'Male', 'Residential', 'Woodard Street', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ALjaUVUsltYbju', '20:06:38', '2001-05-19', '2023-10-26 04:35:55'),
(157, 'W-80477', 'Michael', 'Catherine', 'Baker', 'II', 'Michael Catherine Baker II', 'christinacook@example.net', '094681268183', '11/16/1911', 112, 'Female', 'Residential', 'Apo Street', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AsxuHORKwWRQiA', '06:03:22', '2018-06-10', '2023-10-26 04:35:55'),
(158, 'W-29900', 'Lisa', 'Elizabeth', 'Gilmore', 'Jr.', 'Lisa Elizabeth Gilmore Jr.', 'lauriejensen@example.com', '092908503004', '11/10/1936', 87, 'Female', 'Commercial', 'Halcon Avenue', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AxztJHPKSSZsiO', '04:58:13', '1981-04-22', '2023-10-26 04:35:55'),
(159, 'W-93007', 'Aaron', 'Vernon', 'Randall', 'IV', 'Aaron Vernon Randall IV', 'michaelsmith@example.org', '099107597402', '12/31/1985', 38, 'Female', 'Commercial', 'Herman Road', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ASNFDlACKEaTCs', '09:42:32', '1995-01-05', '2023-10-26 04:35:55'),
(160, 'W-22592', 'Robert', 'Rebecca', 'Lopez', 'Jr.', 'Robert Rebecca Lopez Jr.', 'michael58@example.org', '095960310442', '10/15/1996', 27, 'Female', 'Residential', 'Malinao Road', 'Uyao', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Uyao, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ACjuXQJRonHeKt', '06:42:23', '2016-02-02', '2023-10-26 04:35:55'),
(161, 'W-75375', 'April', 'Lauren', 'Barry', 'M.D.', 'April Lauren Barry M.D.', 'breannamorgan@example.net', '093460655756', '03/30/1980', 43, 'Male', 'Commercial', 'Neptune Street', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AMohrGbjtMsWDH', '00:00:30', '2010-02-11', '2023-10-26 04:35:55'),
(162, 'W-47558', 'Samuel', 'Lisa', 'Nelson', 'Jr.', 'Samuel Lisa Nelson Jr.', 'oconnoramanda@example.com', '093532020871', '06/08/2011', 12, 'Female', 'Commercial', 'Gemini Street', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AXclZmiCZhzvPU', '12:27:32', '2023-09-23', '2023-10-26 04:35:55'),
(163, 'W-71819', 'Cheryl', 'Matthew', 'Smith', 'MBA', 'Cheryl Matthew Smith MBA', 'alvarezrobert@example.com', '092260799535', '10/29/2012', 11, 'Female', 'Residential', 'Orchid Street', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ANPkQHShjbHeyz', '04:48:49', '2008-08-10', '2023-10-26 04:35:55'),
(164, 'W-37257', 'Michael', 'Scott', 'Pace', 'M.D.', 'Michael Scott Pace M.D.', 'carolelliott@example.org', '094347036749', '05/12/1945', 78, 'Female', 'Commercial', 'Bulusan Street', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AaOZZlCKUDjNdz', '23:37:11', '1999-04-06', '2023-10-26 04:35:55'),
(165, 'W-82820', 'Gregory', 'Bryan', 'Torres', 'CPA', 'Gregory Bryan Torres CPA', 'kelly28@example.com', '091074108009', '11/29/1914', 109, 'Male', 'Residential', 'Lang Road Extension', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AbpIerTyKmNCOz', '02:37:36', '1981-12-11', '2023-10-26 04:35:55'),
(166, 'W-35821', 'Andrew', 'Kimberly', 'Manning', '', 'Andrew Kimberly Manning ', 'adrianabaker@example.com', '096312032830', '05/03/1987', 36, 'Male', 'Commercial', '49th Avenue Extension', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AKhqhgdItoydIg', '09:22:13', '2009-05-08', '2023-10-26 04:35:55'),
(167, 'W-29224', 'Omar', 'Mary', 'Rodriguez', '', 'Omar Mary Rodriguez ', 'michaelperkins@example.com', '093262291112', '05/31/1967', 56, 'Female', 'Commercial', 'Duhat Road', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ABqMZPbseSlcSJ', '21:24:19', '1990-08-28', '2023-10-26 04:35:55'),
(168, 'W-38520', 'John', 'Gary', 'Beasley', 'Jr.', 'John Gary Beasley Jr.', 'jacqueline39@example.net', '094883791843', '03/10/2000', 23, 'Female', 'Residential', 'Sardonyx Drive', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AahWWCdzEcRHQd', '22:42:28', '2021-10-17', '2023-10-26 04:35:55'),
(169, 'W-99208', 'Christopher', 'Christopher', 'Webb', 'MBA', 'Christopher Christopher Webb MBA', 'williamsemily@example.org', '097302220848', '11/11/1955', 68, 'Female', 'Residential', '88th Boulevard', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AmlqhdEnumRKuo', '07:09:06', '1973-05-29', '2023-10-26 04:35:55'),
(170, 'W-71400', 'Kenneth', 'Bradley', 'Walker', 'CPA', 'Kenneth Bradley Walker CPA', 'kimberly47@example.com', '096258841329', '06/14/1990', 33, 'Male', 'Commercial', 'Zircon Road', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Cantil, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AbhgxGnqCyDwCm', '03:41:16', '1976-12-08', '2023-10-26 04:35:55'),
(171, 'W-51832', 'Jaclyn', 'David', 'Garcia', 'MBA', 'Jaclyn David Garcia MBA', 'samanthaosborne@example.com', '097235470684', '04/02/1909', 114, 'Male', 'Commercial', 'Arayat Street', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AoUFvMVClAWeCn', '18:12:38', '1972-02-15', '2023-10-26 04:35:55'),
(172, 'W-22372', 'Steven', 'Joseph', 'Miller', 'M.D.', 'Steven Joseph Miller M.D.', 'xnguyen@example.net', '095771667217', '01/12/2013', 10, 'Male', 'Commercial', 'Capricorn Drive Extension', 'Libertad', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libertad, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AuAOxyUQiaMmxi', '04:40:35', '2001-02-26', '2023-10-26 04:35:55'),
(173, 'W-48060', 'Andrew', 'Adrienne', 'Phillips', 'Jr.', 'Andrew Adrienne Phillips Jr.', 'brandiquinn@example.com', '091928084465', '05/13/1972', 51, 'Male', 'Commercial', 'Sierra Madre Road', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AjJkbJgfHrWQxr', '18:15:35', '2015-04-23', '2023-10-26 04:35:55'),
(174, 'W-49160', 'Johnny', 'Brandon', 'Jones', 'IV', 'Johnny Brandon Jones IV', 'tapiabrenda@example.net', '095722912680', '11/26/1955', 68, 'Female', 'Residential', '22nd Street', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AwcALSoIDmmqyO', '00:19:35', '1972-04-14', '2023-10-26 04:35:55'),
(175, 'W-54412', 'Erik', 'Douglas', 'Turner', 'CPA', 'Erik Douglas Turner CPA', 'olsensarah@example.net', '094368524948', '07/01/1971', 52, 'Male', 'Commercial', '32nd Street', 'Paclasan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Paclasan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AWuKEbYPQIBnUi', '19:22:50', '1983-01-04', '2023-10-26 04:35:55'),
(176, 'W-17999', 'Juan', 'Kimberly', 'Griffith', 'Ph.D.', 'Juan Kimberly Griffith Ph.D.', 'laurenmartinez@example.net', '099694799028', '03/26/1917', 106, 'Male', 'Commercial', 'Polaris Drive', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AaOLQFjNXjPlem', '10:33:49', '2023-10-20', '2023-10-26 04:35:55'),
(177, 'W-63339', 'Madeline', 'Stephanie', 'Camacho', 'MBA', 'Madeline Stephanie Camacho MBA', 'robinsonphilip@example.net', '099567161547', '04/19/2021', 2, 'Female', 'Commercial', 'Sierra Madre Street', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AfpeTQVTYelHLC', '18:08:11', '2019-05-05', '2023-10-26 04:35:55'),
(178, 'W-83045', 'Michael', 'Debbie', 'Khan', 'PhD', 'Michael Debbie Khan PhD', 'thomasvalerie@example.org', '093439372732', '06/09/1974', 49, 'Female', 'Residential', '80th Street', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AtXhVcFpnMOFHo', '07:11:17', '1987-07-11', '2023-10-26 04:35:55'),
(179, 'W-98133', 'Linda', 'Steven', 'Smith', 'II', 'Linda Steven Smith II', 'apalmer@example.net', '091818015495', '07/28/1921', 102, 'Male', 'Residential', '85th Road', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AOKIerRDKxSEvh', '14:42:23', '2018-03-30', '2023-10-26 04:35:55'),
(180, 'W-19892', 'Peggy', 'Dennis', 'Moon', 'CPA', 'Peggy Dennis Moon CPA', 'lisa14@example.org', '095765189694', '05/24/2001', 22, 'Female', 'Residential', 'Halcon Road', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Happy Valley, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'ApBMGsBcPcucOD', '02:12:35', '1992-02-13', '2023-10-26 04:35:55'),
(181, 'W-44604', 'Jane', 'Tiffany', 'Campos', 'MBA', 'Jane Tiffany Campos MBA', 'butlerkimberly@example.org', '092898100007', '12/16/1938', 85, 'Female', 'Residential', 'Akle Street', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AWNNFGOZceoBHR', '16:57:32', '1991-05-13', '2023-10-26 04:35:55'),
(182, 'W-41696', 'Kathryn', 'Marc', 'Hoover', 'MBA', 'Kathryn Marc Hoover MBA', 'davidvillanueva@example.com', '097259128256', '08/08/2010', 13, 'Male', 'Residential', 'Sapphire Road', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AfRqhYCaCnopZN', '20:34:28', '1981-05-27', '2023-10-26 04:35:55'),
(183, 'W-11320', 'Amanda', 'James', 'Snyder', 'CPA', 'Amanda James Snyder CPA', 'vasquezlaura@example.org', '094115037681', '01/01/1969', 54, 'Female', 'Residential', 'Celery Street', 'San Mariano', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Mariano, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AusfBMkmGygKUh', '02:33:13', '1971-12-19', '2023-10-26 04:35:55'),
(184, 'W-36893', 'Christine', 'Jeffrey', 'Anderson', 'M.D.', 'Christine Jeffrey Anderson M.D.', 'nvance@example.com', '094236540883', '11/20/2001', 22, 'Male', 'Residential', '99th Road', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'APvnNiYHAnYkVN', '05:06:42', '2015-10-14', '2023-10-26 04:35:55'),
(185, 'W-62736', 'Anna', 'Laura', 'Trujillo', 'IV', 'Anna Laura Trujillo IV', 'meghanhudson@example.com', '099137614800', '02/12/1912', 111, 'Female', 'Commercial', 'Nelson Road', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AGvbjujcgeEiFN', '11:09:01', '2007-09-24', '2023-10-26 04:35:55'),
(186, 'W-82537', 'Stacy', 'Susan', 'Burnett', 'PhD', 'Stacy Susan Burnett PhD', 'vstanley@example.com', '098637325931', '11/11/1983', 40, 'Male', 'Residential', '55th Drive', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AlELXLnjgZofNc', '00:52:55', '1982-01-31', '2023-10-26 04:35:55'),
(187, 'W-41031', 'Carla', 'Christopher', 'Bowen', 'III', 'Carla Christopher Bowen III', 'michaelbowen@example.com', '097071510895', '09/08/1993', 30, 'Female', 'Residential', 'Mars Street', 'Victoria', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Victoria, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AhqCiScJGMDiyk', '22:36:20', '1990-06-09', '2023-10-26 04:35:55'),
(188, 'W-39918', 'Brenda', 'Denise', 'Sherman', 'II', 'Brenda Denise Sherman II', 'ehunter@example.net', '094871203697', '02/20/1929', 94, 'Female', 'Commercial', 'Gemini Road Extension', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dangay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ADxmUoIoOsGQCd', '05:26:56', '1988-02-25', '2023-10-26 04:35:55'),
(189, 'W-37440', 'Jonathan', 'Dennis', 'Crawford', 'II', 'Jonathan Dennis Crawford II', 'gilldiana@example.org', '099286877208', '07/24/2008', 15, 'Female', 'Residential', 'Citrine Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AVLvXAByoJfBti', '08:49:58', '1984-08-15', '2023-10-26 04:35:55'),
(190, 'W-49811', 'Michael', 'Kayla', 'Massey', 'Ph.D.', 'Michael Kayla Massey Ph.D.', 'williambaker@example.net', '094766216121', '07/09/2011', 12, 'Female', 'Commercial', 'Sunstone Street', 'San Isidro', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Isidro, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AkaaBrTqFddzrp', '14:01:17', '1990-09-09', '2023-10-26 04:35:55'),
(191, 'W-68782', 'Timothy', 'Victor', 'Johnson', 'Ph.D.', 'Timothy Victor Johnson Ph.D.', 'danderson@example.com', '095967660247', '11/23/1961', 62, 'Female', 'Commercial', 'Murray Drive', 'San Jose', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Jose, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AxXRUkuJfsgkdC', '21:15:47', '1983-11-09', '2023-10-26 04:35:55'),
(192, 'W-50538', 'Michael', 'Christopher', 'Mcdonald', 'II', 'Michael Christopher Mcdonald II', 'phillipcross@example.org', '098202066759', '11/04/1986', 37, 'Female', 'Residential', 'Intsia Road', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AYXAafOixwlPBx', '23:26:51', '1978-07-06', '2023-10-26 04:35:55'),
(193, 'W-82589', 'Deborah', 'Alexander', 'Payne', 'IV', 'Deborah Alexander Payne IV', 'vclark@example.net', '097821348110', '04/08/1989', 34, 'Female', 'Residential', 'Pinatubo Drive', 'Libtong', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Libtong, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'Yes', 'No', 'Yes', 'unconfirmed', 'unpaid', 'AlmjzpvZZuVNru', '17:53:31', '1994-09-12', '2023-10-26 04:35:55'),
(194, 'W-14949', 'Karen', 'Charlotte', 'Garcia', 'CPA', 'Karen Charlotte Garcia CPA', 'onorris@example.net', '096359504558', '10/01/1984', 39, 'Male', 'Residential', 'Onyx Drive', 'Little Tanauan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Little Tanauan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'No', 'Yes', 'unconfirmed', 'unpaid', 'ADHVInwrxhIDeP', '10:03:03', '2018-05-01', '2023-10-26 04:35:55'),
(195, 'W-79686', 'Michelle', 'Wendy', 'Cooper', 'M.D.', 'Michelle Wendy Cooper M.D.', 'raynichole@example.net', '099940080014', '03/25/1940', 83, 'Female', 'Residential', 'Sapphire Street', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AmCiWjyKeooBMG', '07:30:10', '2020-09-04', '2023-10-26 04:35:55'),
(196, 'W-66012', 'Deborah', 'Erin', 'Pruitt', 'PhD', 'Deborah Erin Pruitt PhD', 'sharper@example.net', '096582801225', '03/05/1952', 71, 'Female', 'Commercial', '74th Avenue', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'No', 'No', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AxUZRAXNojfoyk', '22:17:40', '2021-09-27', '2023-10-26 04:35:55'),
(197, 'W-33957', 'Lori', 'Patty', 'Pittman', '', 'Lori Patty Pittman ', 'brianflores@example.org', '098370556255', '03/12/2017', 6, 'Female', 'Commercial', 'Taurus Street', 'Maraska', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Maraska, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'No', 'unconfirmed', 'unpaid', 'AkTesycKwdpFyb', '09:53:59', '2016-05-29', '2023-10-26 04:35:55'),
(198, 'W-20393', 'Jacqueline', 'Kenneth', 'Harvey', 'II', 'Jacqueline Kenneth Harvey II', 'joseph97@example.com', '097603101685', '09/16/1938', 85, 'Male', 'Commercial', 'Topaz Street', 'Dalahican', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Dalahican, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'No', 'No', 'No', 'unconfirmed', 'unpaid', 'AXInNDyAXZmsHf', '04:20:09', '1984-06-17', '2023-10-26 04:35:55'),
(199, 'W-85559', 'Tiffany', 'Erin', 'Richardson', 'M.D.', 'Tiffany Erin Richardson M.D.', 'jaredtaylor@example.com', '096554290033', '04/15/1932', 91, 'Female', 'Commercial', 'Wang Avenue', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'San Miguel, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', 'unconfirmed', 'unpaid', 'AnvnWJYpFzrAEp', '02:35:55', '1999-03-11', '2023-10-26 04:35:55'),
(200, 'W-69433', 'Destiny', 'Paige', 'Lopez', 'Ph.D.', 'Destiny Paige Lopez Ph.D.', 'deborah26@example.net', '099893741345', '06/22/1946', 77, 'Male', 'Residential', 'Hydra Boulevard', 'Mabuhay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Mabuhay, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'No', 'No', 'unconfirmed', 'unpaid', 'AVflNosEgtSggJ', '04:49:28', '1997-01-14', '2023-10-26 04:35:55'),
(201, 'W-11111', 'Jeffry James', 'James', 'Paner', '', 'Jeffry James J. Paner', 'jeffrypaner@gmail.com', '09752950518', '01/09/2002', 21, 'Male', 'Commercial', 'Amihan 2', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Amihan 2, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'A20231026153158', '21:31:58', '2023-10-26', '2023-10-26 14:36:59'),
(202, 'W-22222', 'Rogene ', 'Garcia', 'Vito', '', 'Rogene  G. Vito', 'rogenevito@gmail.com', '09898989838', '01/01/1995', 28, 'Male', 'Residential', 'Sa May Paresan', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Sa May Paresan, Bagumbayan, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'A20231026155251', '21:52:51', '2023-10-26', '2023-10-28 02:53:06'),
(203, 'W-79797', 'Nicpar', 'Santiago', 'Paner', 'Jr.', 'Nicpar S. Paner Jr.', 'nicparsantiagop@gmail.com', '09073070146', '06/19/1966', 57, 'Male', 'Residential', 'Gawad Kalinga, Amihan 2', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Gawad Kalinga, Amihan 2, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'A20231026155713', '21:57:13', '2023-10-26', '2023-10-26 14:24:03'),
(205, 'W-23456', 'Joy', 'Forjes', 'Morales', '', 'Joy F. Morales', 'joyforjes@gmail.com', '09383373737', '06/19/1966', 57, 'Female', 'Residential', 'Amihan 2', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Amihan 2, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'A20231026160650', '22:06:50', '2023-10-26', '2023-10-26 14:09:26'),
(206, 'W-19989', 'Jeffry James', 'Morales', 'Paner', 'Sr.', 'Jeffry James M. Paner Sr.', 'jeffrypaner22@gmail.com', '09898733636', '01/09/2002', 21, 'Male', 'Residential', 'Amihan 1', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Amihan 1, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'Yes', 'Yes', 'Yes', 'Yes', 'approved', 'paid', 'A20231028070226', '13:02:26', '2023-10-28', '2023-10-28 05:03:28');

-- --------------------------------------------------------

--
-- Table structure for table `client_data`
--

CREATE TABLE `client_data` (
  `id` int(11) NOT NULL,
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
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_data`
--

INSERT INTO `client_data` (`id`, `client_id`, `reg_id`, `meter_number`, `full_name`, `email`, `phone_number`, `birthdate`, `age`, `property_type`, `street`, `brgy`, `full_address`, `status`, `reading_status`, `application_id`, `time`, `date`, `timestamp`) VALUES
(48, 'WBS-JJP-001102823', 'R20231028070900', 'W-11111', 'Jeffry James J. Paner', 'jeffrypaner@gmail.com', '09752950518', '01/09/2002', 21, 'Commercial', 'Amihan 2', 'San Aquilino', 'Amihan 2, San Aquilino, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'active', 'pending', 'A20231026153158', '13:09:00', '2023-10-28', '2023-10-28 05:09:00'),
(49, 'WBS-JVJ-002102823', 'R20231028071200', 'W-27786', 'James V. James Sr.', 'tanderson@example.net', '096121127612', '05/03/1991', 32, 'Commercial', '88th Road', 'San Vicente', '88th Road, San Vicente, Roxas, Oriental Mindoro, REGION IV-B (MIMAROPA), Philippines', 'active', 'pending', 'AQrHKJLCetdDDp', '13:12:00', '2023-10-28', '2023-10-28 05:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `client_secondary_data`
--

CREATE TABLE `client_secondary_data` (
  `id` int(11) NOT NULL,
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
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_secondary_data`
--

INSERT INTO `client_secondary_data` (`id`, `client_id`, `first_name`, `middle_name`, `last_name`, `name_suffix`, `property_type`, `gender`, `street`, `brgy`, `municipality`, `province`, `region`, `valid_id`, `proof_of_ownership`, `deed_of_sale`, `affidavit`, `time`, `date`, `timestamp`) VALUES
(1, 'WBS-CNP-002102623', 'Carolyn', 'Nancy', 'Panner', '', 'Residential', 'Female', 'Collins Drive', 'Dangay', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '22:16:44', '2023-10-26', '2023-10-26 14:16:44'),
(2, 'WBS-RGV-003102823', 'Rogene ', 'Garcia', 'Vito', '', 'Residential', 'Male', 'Sa May Paresan', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '11:13:08', '2023-10-28', '2023-10-28 03:13:08'),
(3, 'WBS-ADT-003102823', 'Andrea', 'Deanna', 'Thornton', 'II', 'Residential', 'Female', 'Mars Street', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '11:15:11', '2023-10-28', '2023-10-28 03:15:11'),
(4, 'WBS-NSP-004102823', 'Nicpar', 'Santiago', 'Paner', 'Jr.', 'Residential', 'Male', 'Gawad Kalinga, Amihan 2', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '11:18:18', '2023-10-28', '2023-10-28 03:18:18'),
(5, 'WBS-MBT-005102823', 'Michael', 'Brandon', 'Tyler', 'IV', 'Residential', 'Female', 'Amihan 2', 'Happy Valley', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '11:27:50', '2023-10-28', '2023-10-28 03:27:50'),
(6, 'WBS-MCO-006102823', 'Marie', 'Cynthia', 'Owens', 'MBA', 'Commercial', 'Male', 'Norton Avenue', 'Cantil', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '11:32:55', '2023-10-28', '2023-10-28 03:32:55'),
(7, 'WBS-JFM-007102823', 'Joy', 'Forjes', 'Morales', '', 'Residential', 'Female', 'Amihan 2', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '11:39:58', '2023-10-28', '2023-10-28 03:39:58'),
(8, 'WBS-AMW-008102823', 'Alexis', 'Matthew', 'Williams', 'II', 'Commercial', 'Female', 'Planet Highway', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '12:44:01', '2023-10-28', '2023-10-28 04:44:01'),
(9, 'WBS-JJL-009102823', 'Jason', 'Jimmy', 'Lyons', 'III', 'Commercial', 'Male', 'Saturn Extension', 'San Miguel', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '12:50:37', '2023-10-28', '2023-10-28 04:50:37'),
(10, 'WBS-MLB-010102823', 'Michelle', 'Lawrence', 'Brown', '', 'Commercial', 'Female', 'Tabayoc Drive', 'San Rafael', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '12:53:42', '2023-10-28', '2023-10-28 04:53:42'),
(11, 'WBS-JRC-011102823', 'Jeremiah', 'Rebecca', 'Chan', 'MBA', 'Commercial', 'Male', '3rd Boulevard', 'Bagumbayan', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '12:56:00', '2023-10-28', '2023-10-28 04:56:00'),
(12, 'WBS-JMP-012102823', 'Jeffry James', 'Morales', 'Paner', 'Sr.', 'Residential', 'Male', 'Amihan 1', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '13:03:49', '2023-10-28', '2023-10-28 05:03:49'),
(13, 'WBS-JJP-001102823', 'Jeffry James', 'James', 'Paner', '', 'Commercial', 'Male', 'Amihan 2', 'San Aquilino', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '13:09:00', '2023-10-28', '2023-10-28 05:09:00'),
(14, 'WBS-JVJ-002102823', 'James', 'Vincentss', 'James', 'Sr.', 'Commercial', 'Female', '88th Road', 'San Vicente', 'Roxas', 'Oriental Mindoro', 'REGION IV-B (MIMAROPA)', 'Yes', 'Yes', 'Yes', 'Yes', '13:12:00', '2023-10-28', '2023-10-28 05:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(55) NOT NULL,
  `log_id` varchar(50) NOT NULL,
  `user_role` varchar(55) NOT NULL,
  `user_name` varchar(55) NOT NULL,
  `user_activity` text NOT NULL,
  `client_id` int(50) NOT NULL,
  `description` text NOT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `log_id`, `user_role`, `user_name`, `user_activity`, `client_id`, `description`, `date`, `time`, `datetime`) VALUES
(248, 'UAT20230918171925', 'Admin', 'test', 'Update', 1624, 'Updated address: San Jose to Paclasan', '2023-09-18', '23:19:25', '2023-09-18 23:19:25'),
(249, 'UAT20230918171930', 'Admin', 'test', 'Update', 1544, 'Updated address: San Rafael to Odiong', '2023-09-18', '23:19:30', '2023-09-18 23:19:30'),
(250, 'DAT20230918172150', 'Admin', 'test', 'Delete', 1543, 'Rogene L. Bryant has been deleted.', '2023-09-18', '23:21:50', '2023-09-18 23:21:50'),
(251, 'UAT20230918172959', 'Admin', 'test', 'Update', 1548, 'Updated address: San Jose to Uyao', '2023-09-18', '23:29:59', '2023-09-18 23:29:59'),
(252, 'SOAT20230918173025', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-18', '23:30:25', '2023-09-18 23:30:25'),
(253, 'SIAT20230918173042', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-18', '23:30:42', '2023-09-18 23:30:42'),
(254, 'SIAT20230918173653', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-18', '23:36:53', '2023-09-18 23:36:53'),
(255, 'DAT20230918173735', 'Admin', 'test', 'Delete', 1548, 'Hannah J. Robles has been deleted.', '2023-09-18', '23:37:35', '2023-09-18 23:37:35'),
(256, 'UAT20230918173855', 'Admin', 'test', 'Update', 1537, 'Updated name: Lei N. Robles to Leni N. Robredo, address: San Vicente to San Aquilino', '2023-09-18', '23:38:55', '2023-09-18 23:38:55'),
(257, 'SOAT20230918174146', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-18', '23:41:46', '2023-09-18 23:41:46'),
(258, 'SIAT20230918174152', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-18', '23:41:52', '2023-09-18 23:41:52'),
(259, 'SOAT20230918183033', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:30:33', '2023-09-19 00:30:33'),
(260, 'SIAT20230918183040', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:30:40', '2023-09-19 00:30:40'),
(261, 'SOAT20230918183613', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:36:13', '2023-09-19 00:36:13'),
(262, 'SIAT20230918183620', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:36:20', '2023-09-19 00:36:20'),
(263, 'UAT20230918183715', 'Admin', 'test', 'Update', 1537, 'Updated address: San Aquilino to Mabuhay', '2023-09-19', '00:37:15', '2023-09-19 00:37:15'),
(264, 'SOAT20230918183902', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:39:02', '2023-09-19 00:39:02'),
(265, 'SIAT20230918183913', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:39:13', '2023-09-19 00:39:13'),
(266, 'SOAT20230918184807', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:48:07', '2023-09-19 00:48:07'),
(267, 'SIAT20230918184814', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:48:14', '2023-09-19 00:48:14'),
(268, 'UAT20230918184939', 'Admin', 'test', 'Update', 1544, 'Updated address: Odiong to Mabuhay', '2023-09-19', '00:49:39', '2023-09-19 00:49:39'),
(269, 'SOAT20230918185055', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:50:55', '2023-09-19 00:50:55'),
(270, 'SIAT20230918185119', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:51:19', '2023-09-19 00:51:19'),
(271, 'SOAT20230918185323', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:53:23', '2023-09-19 00:53:23'),
(272, 'SIAT20230918185332', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:53:32', '2023-09-19 00:53:32'),
(273, 'SOAT20230918185623', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '00:56:23', '2023-09-19 00:56:23'),
(274, 'SIAT20230918185629', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '00:56:29', '2023-09-19 00:56:29'),
(275, 'UAT20230918190543', 'Admin', 'test', 'Update', 1560, 'Updated address: San Jose to San Vicente', '2023-09-19', '01:05:43', '2023-09-19 01:05:43'),
(276, 'SOAT20230918192727', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '01:27:27', '2023-09-19 01:27:27'),
(277, 'SOAA20230918192930', 'Admin', 'ADMIN_NO_LOGIN', 'Sign out', 0, 'ADMIN_NO_LOGIN has been signed out.', '2023-09-19', '01:29:30', '2023-09-19 01:29:30'),
(278, 'SIAJJP20230918192945', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-19', '01:29:45', '2023-09-19 01:29:45'),
(279, 'SOAJJP20230918194256', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-19', '01:42:56', '2023-09-19 01:42:56'),
(280, 'SIAT20230918194302', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '01:43:02', '2023-09-19 01:43:02'),
(281, 'UAT20230918194515', 'Admin', 'test', 'Update', 1537, 'Updated name: Leni N. Robredo to Leni Robredo, address: Mabuhay to Happy Valley, email: lei.robles7549@hotmail.com to lei.robredo7549@hotmail.com', '2023-09-19', '01:45:15', '2023-09-19 01:45:15'),
(282, 'SOAT20230918201514', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '02:15:14', '2023-09-19 02:15:14'),
(283, 'SIAT20230918201841', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '02:18:41', '2023-09-19 02:18:41'),
(284, 'UAT20230918202115', 'Admin', 'test', 'Update', 1537, 'Updated address: Happy Valley to San Rafael', '2023-09-19', '02:21:15', '2023-09-19 02:21:15'),
(285, 'UAT20230918202122', 'Admin', 'test', 'Update', 1537, 'Updated address: San Rafael to Uyao', '2023-09-19', '02:21:22', '2023-09-19 02:21:22'),
(286, 'UAT20230918202130', 'Admin', 'test', 'Update', 1537, 'Updated address: Uyao to San Rafael', '2023-09-19', '02:21:30', '2023-09-19 02:21:30'),
(287, 'UAT20230918202130', 'Admin', 'test', 'Update', 1546, 'Updated address: Odiong to Libtong', '2023-09-19', '02:21:30', '2023-09-19 02:21:30'),
(288, 'UAT20230918202130', 'Admin', 'test', 'Update', 1537, 'Updated address: San Rafael to Uyao', '2023-09-19', '02:21:30', '2023-09-19 02:21:30'),
(289, 'SOAT20230918202157', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '02:21:57', '2023-09-19 02:21:57'),
(290, 'SIAT20230919090704', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '15:07:04', '2023-09-19 15:07:04'),
(291, 'SOAT20230919090745', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '15:07:45', '2023-09-19 15:07:45'),
(292, 'SIMRV20230919090917', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:09:17', '2023-09-19 15:09:17'),
(293, 'SIAT20230919090939', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '15:09:39', '2023-09-19 15:09:39'),
(294, 'SO20230919091122', '', '', 'Sign out', 0, ' has been signed out.', '2023-09-19', '15:11:22', '2023-09-19 15:11:22'),
(295, 'SIMRV20230919091213', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:12:13', '2023-09-19 15:12:13'),
(296, 'SIAT20230919091235', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '15:12:35', '2023-09-19 15:12:35'),
(297, 'SOAT20230919091429', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '15:14:29', '2023-09-19 15:14:29'),
(298, 'SIMRV20230919092508', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:25:08', '2023-09-19 15:25:08'),
(299, 'SOMRV20230919092702', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '15:27:02', '2023-09-19 15:27:02'),
(300, 'SIMRV20230919093616', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:36:16', '2023-09-19 15:36:16'),
(301, 'SOMRV20230919093759', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '15:37:59', '2023-09-19 15:37:59'),
(302, 'SIMRV20230919093805', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:38:05', '2023-09-19 15:38:05'),
(303, 'SOMRV20230919093930', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '15:39:30', '2023-09-19 15:39:30'),
(304, 'SIMRV20230919094003', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:40:03', '2023-09-19 15:40:03'),
(305, 'SOMRV20230919094204', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '15:42:04', '2023-09-19 15:42:04'),
(306, 'SIMRV20230919094212', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:42:12', '2023-09-19 15:42:12'),
(307, 'SOMRV20230919094711', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '15:47:11', '2023-09-19 15:47:11'),
(308, 'SIMRV20230919094748', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '15:47:48', '2023-09-19 15:47:48'),
(309, 'SOMRV20230919095900', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '15:59:00', '2023-09-19 15:59:00'),
(310, 'SIAT20230919095925', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '15:59:25', '2023-09-19 15:59:25'),
(311, 'SOAT20230919100001', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '16:00:01', '2023-09-19 16:00:01'),
(312, 'SIMRV20230919100008', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:00:08', '2023-09-19 16:00:08'),
(313, 'SOMRV20230919100319', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:03:19', '2023-09-19 16:03:19'),
(314, 'SIMRV20230919100502', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:05:02', '2023-09-19 16:05:02'),
(315, 'SOMRV20230919100506', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:05:06', '2023-09-19 16:05:06'),
(316, 'SIMRV20230919100728', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:07:28', '2023-09-19 16:07:28'),
(317, 'SOMRV20230919101638', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:16:38', '2023-09-19 16:16:38'),
(318, 'SIMRV20230919101658', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:16:58', '2023-09-19 16:16:58'),
(319, 'SOMRV20230919102425', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:24:25', '2023-09-19 16:24:25'),
(320, 'SIAT20230919102434', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '16:24:34', '2023-09-19 16:24:34'),
(321, 'SOAT20230919102440', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '16:24:40', '2023-09-19 16:24:40'),
(322, 'SIMRV20230919102446', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:24:46', '2023-09-19 16:24:46'),
(323, 'SOMRV20230919103457', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:34:57', '2023-09-19 16:34:57'),
(324, 'SIMRV20230919103511', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:35:11', '2023-09-19 16:35:11'),
(325, 'SOMRV20230919103613', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:36:13', '2023-09-19 16:36:13'),
(326, 'SIMRV20230919103624', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:36:24', '2023-09-19 16:36:24'),
(327, 'SIMRV20230919103754', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:37:54', '2023-09-19 16:37:54'),
(328, 'SOMRV20230919104154', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:41:54', '2023-09-19 16:41:54'),
(329, 'SIMRV20230919104200', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:42:00', '2023-09-19 16:42:00'),
(330, 'SOMRV20230919104338', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:43:38', '2023-09-19 16:43:38'),
(331, 'SIMRV20230919104346', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:43:46', '2023-09-19 16:43:46'),
(332, 'SOMRV20230919105747', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '16:57:47', '2023-09-19 16:57:47'),
(333, 'SIMRV20230919105756', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '16:57:56', '2023-09-19 16:57:56'),
(334, 'SOMRV20230919130033', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '19:00:33', '2023-09-19 19:00:33'),
(335, 'SIAT20230919130048', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '19:00:48', '2023-09-19 19:00:48'),
(336, 'SOAT20230919130308', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '19:03:08', '2023-09-19 19:03:08'),
(337, 'SIMRV20230919130316', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '19:03:16', '2023-09-19 19:03:16'),
(338, 'SOMRV20230919135531', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '19:55:31', '2023-09-19 19:55:31'),
(339, 'SIMRV20230919135614', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '19:56:14', '2023-09-19 19:56:14'),
(340, 'SOMRV20230919155720', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '21:57:20', '2023-09-19 21:57:20'),
(341, 'SIMRV20230919155726', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '21:57:26', '2023-09-19 21:57:26'),
(342, 'SOMRV20230919155822', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '21:58:22', '2023-09-19 21:58:22'),
(343, 'SIMRV20230919155833', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '21:58:33', '2023-09-19 21:58:33'),
(344, 'SOMRV20230919160025', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '22:00:25', '2023-09-19 22:00:25'),
(345, 'SIMRV20230919160032', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '22:00:32', '2023-09-19 22:00:32'),
(346, 'SOMRV20230919160036', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '22:00:36', '2023-09-19 22:00:36'),
(347, 'SIAT20230919160100', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '22:01:00', '2023-09-19 22:01:00'),
(348, 'SOAT20230919160301', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '22:03:01', '2023-09-19 22:03:01'),
(349, 'SIAJJP20230919160317', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-19', '22:03:17', '2023-09-19 22:03:17'),
(350, 'SOAJJP20230919161240', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-19', '22:12:40', '2023-09-19 22:12:40'),
(351, 'SIMRV20230919161246', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '22:12:46', '2023-09-19 22:12:46'),
(352, 'SOMRV20230919161300', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '22:13:00', '2023-09-19 22:13:00'),
(353, 'SIMRV20230919161306', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '22:13:06', '2023-09-19 22:13:06'),
(354, 'SOMRV20230919161721', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '22:17:21', '2023-09-19 22:17:21'),
(355, 'SIAT20230919161732', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '22:17:32', '2023-09-19 22:17:32'),
(356, 'UAT20230919162104', 'Admin', 'test', 'Update', 1541, 'Updated address: San Isidro to Libertad', '2023-09-19', '22:21:04', '2023-09-19 22:21:04'),
(357, 'SIAT20230919162715', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '22:27:15', '2023-09-19 22:27:15'),
(358, 'SOAT20230919163059', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '22:30:59', '2023-09-19 22:30:59'),
(359, 'SIAT20230919163116', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '22:31:16', '2023-09-19 22:31:16'),
(360, 'SOAT20230919164147', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '22:41:47', '2023-09-19 22:41:47'),
(361, 'SIMRV20230919164155', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '22:41:55', '2023-09-19 22:41:55'),
(362, 'SOMRV20230919164404', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '22:44:04', '2023-09-19 22:44:04'),
(363, 'SIMRV20230919164412', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '22:44:12', '2023-09-19 22:44:12'),
(364, 'SOMRV20230919165128', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '22:51:28', '2023-09-19 22:51:28'),
(365, 'SIAT20230919165140', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '22:51:40', '2023-09-19 22:51:40'),
(366, 'SOAT20230919165615', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '22:56:15', '2023-09-19 22:56:15'),
(367, 'SIMRV20230919165915', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '22:59:15', '2023-09-19 22:59:15'),
(368, 'SOMRV20230919170033', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '23:00:33', '2023-09-19 23:00:33'),
(369, 'SIAT20230919170044', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '23:00:44', '2023-09-19 23:00:44'),
(370, 'UAT20230919170250', 'Admin', 'test', 'Update', 1537, 'Updated address: Uyao to Little Tanauan', '2023-09-19', '23:02:50', '2023-09-19 23:02:50'),
(371, 'SOAT20230919170742', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '23:07:42', '2023-09-19 23:07:42'),
(372, 'SIMRV20230919170810', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-19', '23:08:10', '2023-09-19 23:08:10'),
(373, 'SOMRV20230919170827', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-19', '23:08:27', '2023-09-19 23:08:27'),
(374, 'SIAT20230919170847', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '23:08:47', '2023-09-19 23:08:47'),
(375, 'SIAT20230919172135', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '23:21:35', '2023-09-19 23:21:35'),
(376, 'SOAT20230919172348', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-19', '23:23:48', '2023-09-19 23:23:48'),
(377, 'SIAT20230919172403', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '23:24:03', '2023-09-19 23:24:03'),
(378, 'SIAT20230919173017', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-19', '23:30:17', '2023-09-19 23:30:17'),
(379, 'DAT20230919174518', 'Admin', 'test', 'Delete', 1537, 'Leni Robredo has been deleted.', '2023-09-19', '23:45:18', '2023-09-19 23:45:18'),
(380, 'DAT20230919174643', 'Admin', 'test', 'Delete', 1538, 'Jose E. Robles has been deleted.', '2023-09-19', '23:46:43', '2023-09-19 23:46:43'),
(381, 'DAT20230919174729', 'Admin', 'test', 'Delete', 1540, 'James C. Catapang has been deleted.', '2023-09-19', '23:47:29', '2023-09-19 23:47:29'),
(382, 'DAT20230919174858', 'Admin', 'test', 'Delete', 1541, 'Jennifer I. Curry has been deleted.', '2023-09-19', '23:48:58', '2023-09-19 23:48:58'),
(383, 'DAT20230919175059', 'Admin', 'test', 'Delete', 1542, 'James B. Richards has been deleted.', '2023-09-19', '23:50:59', '2023-09-19 23:50:59'),
(384, 'DAT20230919175148', 'Admin', 'test', 'Delete', 1547, 'Jep C. Dela Cruz has been deleted.', '2023-09-19', '23:51:48', '2023-09-19 23:51:48'),
(385, 'DAT20230919175202', 'Admin', 'test', 'Delete', 1544, 'Louiella F. Dayanghirang has been deleted.', '2023-09-19', '23:52:02', '2023-09-19 23:52:02'),
(386, 'DAT20230919175340', 'Admin', 'test', 'Delete', 1545, 'Lei H. Morales has been deleted.', '2023-09-19', '23:53:40', '2023-09-19 23:53:40'),
(387, 'DAT20230919175346', 'Admin', 'test', 'Delete', 1549, 'Nick W. Dayanghirang has been deleted.', '2023-09-19', '23:53:46', '2023-09-19 23:53:46'),
(388, 'DAT20230919175416', 'Admin', 'test', 'Delete', 1546, 'Jep R. Paner has been deleted.', '2023-09-19', '23:54:16', '2023-09-19 23:54:16'),
(389, 'DAT20230919175459', 'Admin', 'test', 'Delete', 1550, 'Juanita R. Catapang has been deleted.', '2023-09-19', '23:54:59', '2023-09-19 23:54:59'),
(390, 'DAT20230919175723', 'Admin', 'test', 'Delete', 1551, 'Jose Paolo X. Mayo has been deleted.', '2023-09-19', '23:57:23', '2023-09-19 23:57:23'),
(391, 'DAT20230919175745', 'Admin', 'test', 'Delete', 1559, 'Jasper J. Robles has been deleted.', '2023-09-19', '23:57:45', '2023-09-19 23:57:45'),
(392, 'DAT20230919175809', 'Admin', 'test', 'Delete', 1557, 'Patricia W. Mayo has been deleted.', '2023-09-19', '23:58:09', '2023-09-19 23:58:09'),
(393, 'DAT20230919175837', 'Admin', 'test', 'Delete', 1552, 'Ann C. Wade has been deleted.', '2023-09-19', '23:58:37', '2023-09-19 23:58:37'),
(394, 'DAT20230919175852', 'Admin', 'test', 'Delete', 1553, 'PJ F. Mayo has been deleted.', '2023-09-19', '23:58:52', '2023-09-19 23:58:52'),
(395, 'DAT20230919175902', 'Admin', 'test', 'Delete', 1554, 'Lebron L. Dayanghirang has been deleted.', '2023-09-19', '23:59:02', '2023-09-19 23:59:02'),
(396, 'DAT20230919175919', 'Admin', 'test', 'Delete', 1560, 'Rogene V. Morales has been deleted.', '2023-09-19', '23:59:19', '2023-09-19 23:59:19'),
(397, 'DAT20230919175933', 'Admin', 'test', 'Delete', 1556, 'James W. Delos Reyes has been deleted.', '2023-09-19', '23:59:33', '2023-09-19 23:59:33'),
(398, 'DAT20230919180330', 'Admin', 'test', 'Delete', 1555, 'Joy X. Garcia has been deleted.', '2023-09-20', '00:03:30', '2023-09-20 00:03:30'),
(399, 'DAT20230919180334', 'Admin', 'test', 'Delete', 1565, 'Hannah I. Richards has been deleted.', '2023-09-20', '00:03:34', '2023-09-20 00:03:34'),
(400, 'DAT20230919180436', 'Admin', 'test', 'Delete', 1558, 'Jeffry B. Delos Reyes has been deleted.', '2023-09-20', '00:04:36', '2023-09-20 00:04:36'),
(401, 'DAT20230919180457', 'Admin', 'test', 'Delete', 1566, 'Jose Paolo T. Jordan has been deleted.', '2023-09-20', '00:04:57', '2023-09-20 00:04:57'),
(402, 'DAT20230919180717', 'Admin', 'test', 'Delete', 1564, 'Nicpar C. Wade has been deleted.', '2023-09-20', '00:07:17', '2023-09-20 00:07:17'),
(403, 'DAT20230919180734', 'Admin', 'test', 'Delete', 1567, 'Ann L. Yap has been deleted.', '2023-09-20', '00:07:34', '2023-09-20 00:07:34'),
(404, 'DAT20230919180739', 'Admin', 'test', 'Delete', 1571, 'Hannah O. Dela Cruz has been deleted.', '2023-09-20', '00:07:39', '2023-09-20 00:07:39'),
(405, 'DAT20230919180802', 'Admin', 'test', 'Delete', 1568, 'Carl S. Garcia has been deleted.', '2023-09-20', '00:08:02', '2023-09-20 00:08:02'),
(406, 'DAT20230919181012', 'Admin', 'test', 'Delete', 1561, 'Nick J. Uvas has been deleted.', '2023-09-20', '00:10:12', '2023-09-20 00:10:12'),
(407, 'DAT20230919181016', 'Admin', 'test', 'Delete', 1570, 'Joy A. Mayo has been deleted.', '2023-09-20', '00:10:16', '2023-09-20 00:10:16'),
(408, 'DAT20230919181021', 'Admin', 'test', 'Delete', 1578, 'Jay Y. Catapang has been deleted.', '2023-09-20', '00:10:21', '2023-09-20 00:10:21'),
(409, 'DAT20230919181027', 'Admin', 'test', 'Delete', 1579, 'Jose Paolo C. Mayo has been deleted.', '2023-09-20', '00:10:27', '2023-09-20 00:10:27'),
(410, 'DAT20230919181031', 'Admin', 'test', 'Delete', 1572, 'Kim V. Richards has been deleted.', '2023-09-20', '00:10:31', '2023-09-20 00:10:31'),
(411, 'DAT20230919181044', 'Admin', 'test', 'Delete', 1581, 'Jennifer F. Catapang has been deleted.', '2023-09-20', '00:10:44', '2023-09-20 00:10:44'),
(412, 'DAT20230919181241', 'Admin', 'test', 'Delete', 1582, 'James Z. Robles has been deleted.', '2023-09-20', '00:12:41', '2023-09-20 00:12:41'),
(413, 'DAT20230919181246', 'Admin', 'test', 'Delete', 1583, 'Jose M. Castillo has been deleted.', '2023-09-20', '00:12:46', '2023-09-20 00:12:46'),
(414, 'DAT20230919181328', 'Admin', 'test', 'Delete', 1562, 'Patrick P. Jordan has been deleted.', '2023-09-20', '00:13:28', '2023-09-20 00:13:28'),
(415, 'DAT20230919181347', 'Admin', 'test', 'Delete', 1569, 'Louiella I. Curry has been deleted.', '2023-09-20', '00:13:47', '2023-09-20 00:13:47'),
(416, 'DAT20230919181400', 'Admin', 'test', 'Delete', 1576, 'Kim L. Mayo has been deleted.', '2023-09-20', '00:14:00', '2023-09-20 00:14:00'),
(417, 'DAT20230919181421', 'Admin', 'test', 'Delete', 1580, 'Roderick N. Bryant has been deleted.', '2023-09-20', '00:14:21', '2023-09-20 00:14:21'),
(418, 'DAT20230919181450', 'Admin', 'test', 'Delete', 1563, 'Jennifer T. Bryant has been deleted.', '2023-09-20', '00:14:50', '2023-09-20 00:14:50'),
(419, 'DAT20230919181509', 'Admin', 'test', 'Delete', 1573, 'Jay U. James has been deleted.', '2023-09-20', '00:15:09', '2023-09-20 00:15:09'),
(420, 'DAT20230919181641', 'Admin', 'test', 'Delete', 1577, 'Patricia G. Robles has been deleted.', '2023-09-20', '00:16:41', '2023-09-20 00:16:41'),
(421, 'DAT20230919181646', 'Admin', 'test', 'Delete', 1591, 'Nick O. Robles has been deleted.', '2023-09-20', '00:16:46', '2023-09-20 00:16:46'),
(422, 'DAT20230919181655', 'Admin', 'test', 'Delete', 1588, 'Jasper D. Dayanghirang has been deleted.', '2023-09-20', '00:16:55', '2023-09-20 00:16:55'),
(423, 'DAT20230919181906', 'Admin', 'test', 'Delete', 1574, 'Joy T. Curry has been deleted.', '2023-09-20', '00:19:06', '2023-09-20 00:19:06'),
(424, 'DAT20230919181912', 'Admin', 'test', 'Delete', 1589, 'Juanita L. Jordan has been deleted.', '2023-09-20', '00:19:12', '2023-09-20 00:19:12'),
(425, 'DAT20230919181918', 'Admin', 'test', 'Delete', 1595, 'Nicpar O. James has been deleted.', '2023-09-20', '00:19:18', '2023-09-20 00:19:18'),
(426, 'DAT20230919182433', 'Admin', 'test', 'Delete', 1575, 'Cristel K. Racar has been deleted.', '2023-09-20', '00:24:33', '2023-09-20 00:24:33'),
(427, 'SOAT20230919182622', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '00:26:22', '2023-09-20 00:26:22'),
(428, 'SIMRV20230919182629', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-20', '00:26:29', '2023-09-20 00:26:29'),
(429, 'SOMRV20230919182649', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-20', '00:26:49', '2023-09-20 00:26:49'),
(430, 'SIAT20230919182709', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '00:27:09', '2023-09-20 00:27:09'),
(431, 'DAT20230919183154', 'Admin', 'test', 'Delete', 1585, 'Rogene R. Garcia has been deleted.', '2023-09-20', '00:31:54', '2023-09-20 00:31:54'),
(432, 'DAT20230919183517', 'Admin', 'test', 'Delete', 1598, 'Lebron K. Festin has been deleted.', '2023-09-20', '00:35:17', '2023-09-20 00:35:17'),
(433, 'DAT20230919183733', 'Admin', 'test', 'Delete', 1587, 'PJ T. Garcia has been deleted.', '2023-09-20', '00:37:33', '2023-09-20 00:37:33'),
(434, 'DAT20230919183744', 'Admin', 'test', 'Delete', 1584, 'Hannah T. Lee has been deleted.', '2023-09-20', '00:37:44', '2023-09-20 00:37:44'),
(435, 'DAT20230919184036', 'Admin', 'test', 'Delete', 1586, 'Jay A. Bryant has been deleted.', '2023-09-20', '00:40:36', '2023-09-20 00:40:36'),
(436, 'DAT20230919184049', 'Admin', 'test', 'Delete', 1592, 'Nick Y. Catapang has been deleted.', '2023-09-20', '00:40:49', '2023-09-20 00:40:49'),
(437, 'DAT20230919184137', 'Admin', 'test', 'Delete', 1590, 'Patrick C. Dayanghirang has been deleted.', '2023-09-20', '00:41:37', '2023-09-20 00:41:37'),
(438, 'UAT20230919184438', 'Admin', 'test', 'Update', 1593, 'Updated address: San Miguel to Victoria', '2023-09-20', '00:44:38', '2023-09-20 00:44:38'),
(439, 'UAT20230919184618', 'Admin', 'test', 'Update', 1594, 'Updated address: Mabuhay to Victoria', '2023-09-20', '00:46:18', '2023-09-20 00:46:18'),
(440, 'SOAT20230919184731', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '00:47:31', '2023-09-20 00:47:31'),
(441, 'SIMRV20230919184737', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-20', '00:47:37', '2023-09-20 00:47:37'),
(442, 'UAT20230919193935', 'Admin', 'test', 'Update', 1593, 'Updated name: Kim Z. Bryant to Kim U. Bryant', '2023-09-20', '01:39:35', '2023-09-20 01:39:35'),
(443, 'SOAT20230919193948', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '01:39:48', '2023-09-20 01:39:48'),
(444, 'SIAT20230920055830', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '11:58:30', '2023-09-20 11:58:30'),
(445, 'SIAT20230920065241', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '12:52:41', '2023-09-20 12:52:41'),
(446, 'UAT20230920065330', 'Admin', 'test', 'Update', 1593, 'Updated address: Victoria to San Mariano', '2023-09-20', '12:53:30', '2023-09-20 12:53:30'),
(447, 'SOAT20230920070438', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '13:04:38', '2023-09-20 13:04:38'),
(448, 'SIAT20230920070444', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '13:04:44', '2023-09-20 13:04:44'),
(449, 'DAT20230920070703', 'Admin', 'test', 'Delete', 1534, 'Jay J. Garcia has been deleted.', '2023-09-20', '13:07:03', '2023-09-20 13:07:03'),
(450, 'DAT20230920070711', 'Admin', 'test', 'Delete', 1527, 'Jose W. James has been deleted.', '2023-09-20', '13:07:11', '2023-09-20 13:07:11'),
(451, 'SOAT20230920071017', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '13:10:17', '2023-09-20 13:10:17'),
(452, 'SIAT20230920071032', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '13:10:32', '2023-09-20 13:10:32'),
(453, 'SOAT20230920071130', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '13:11:30', '2023-09-20 13:11:30'),
(454, 'SIAT20230920071150', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '13:11:50', '2023-09-20 13:11:50'),
(455, 'SOAT20230920071523', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '13:15:23', '2023-09-20 13:15:23'),
(456, 'SIAJJP20230920071552', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-20', '13:15:52', '2023-09-20 13:15:52'),
(457, 'SIAJJP20230920072207', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-20', '13:22:07', '2023-09-20 13:22:07'),
(458, 'SO20230920093625', '', '', 'Sign out', 0, ' has been signed out.', '2023-09-20', '15:36:25', '2023-09-20 15:36:25'),
(459, 'SIAT20230920093640', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '15:36:40', '2023-09-20 15:36:40'),
(460, 'SOAT20230920141805', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '20:18:05', '2023-09-20 20:18:05'),
(461, 'SIAT20230920141832', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '20:18:32', '2023-09-20 20:18:32'),
(462, 'DAJJP20230920142145', 'Admin', 'Jeffry James Paner', 'Delete', 1671, ' has been deleted.', '2023-09-20', '20:21:45', '2023-09-20 20:21:45'),
(463, 'SOAJJP20230920143003', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-20', '20:30:03', '2023-09-20 20:30:03'),
(464, 'SIAT20230920143016', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '20:30:16', '2023-09-20 20:30:16'),
(465, 'SOAT20230920143706', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '20:37:06', '2023-09-20 20:37:06'),
(466, 'SIAT20230920143716', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '20:37:16', '2023-09-20 20:37:16'),
(467, 'SOAT20230920174613', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-20', '23:46:13', '2023-09-20 23:46:13'),
(468, 'SIAT20230920174623', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-20', '23:46:23', '2023-09-20 23:46:23'),
(469, 'SOAT20230920183911', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-21', '00:39:11', '2023-09-21 00:39:11'),
(470, 'SIAT20230920183917', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-21', '00:39:17', '2023-09-21 00:39:17'),
(471, 'SOAT20230920184822', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-21', '00:48:22', '2023-09-21 00:48:22'),
(472, 'SIAT20230920184840', 'Admin', 'test', 'Sign in', 0, 'test has been signed in.', '2023-09-21', '00:48:40', '2023-09-21 00:48:40'),
(473, 'DAT20230920184852', 'Admin', 'test', 'Delete', 1596, 'Hannah U. Yap has been deleted.', '2023-09-21', '00:48:52', '2023-09-21 00:48:52'),
(474, 'DAT20230920184900', 'Admin', 'test', 'Delete', 1616, 'Mark M. Festin has been deleted.', '2023-09-21', '00:49:00', '2023-09-21 00:49:00'),
(475, 'SOAT20230920185022', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-21', '00:50:22', '2023-09-21 00:50:22'),
(476, 'SICAG20230920185050', 'Cashier', 'Anthony Galang', 'Sign in', 0, 'Anthony Galang has been signed in.', '2023-09-21', '00:50:50', '2023-09-21 00:50:50'),
(477, 'SICAG20230920185520', 'Cashier', 'Anthony Galang', 'Sign in', 0, 'Anthony Galang has been signed in.', '2023-09-21', '00:55:20', '2023-09-21 00:55:20'),
(478, 'SIAJJP20230920185529', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '00:55:29', '2023-09-21 00:55:29'),
(479, 'SOAJJP20230920185921', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '00:59:21', '2023-09-21 00:59:21'),
(480, 'SIMRV20230920190015', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-21', '01:00:15', '2023-09-21 01:00:15'),
(481, 'SOMRV20230920190030', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-21', '01:00:30', '2023-09-21 01:00:30'),
(482, 'SIAJJP20230920190037', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '01:00:37', '2023-09-21 01:00:37'),
(483, 'SOAJJP20230920190305', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '01:03:05', '2023-09-21 01:03:05'),
(484, 'SICAG20230920190311', 'Cashier', 'Anthony Galang', 'Sign in', 0, 'Anthony Galang has been signed in.', '2023-09-21', '01:03:11', '2023-09-21 01:03:11'),
(485, 'SIAJJP20230920190321', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '01:03:21', '2023-09-21 01:03:21'),
(486, 'SOAJJP20230920190526', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '01:05:26', '2023-09-21 01:05:26'),
(487, 'SICAG20230920190531', 'Cashier', 'Anthony Galang', 'Sign in', 0, 'Anthony Galang has been signed in.', '2023-09-21', '01:05:31', '2023-09-21 01:05:31'),
(488, 'SIAJJP20230920190534', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '01:05:34', '2023-09-21 01:05:34'),
(489, 'DAJJP20230920190654', 'Admin', 'Jeffry James Paner', 'Delete', 1603, 'Louiella C. Richards has been deleted.', '2023-09-21', '01:06:54', '2023-09-21 01:06:54'),
(490, 'DAJJP20230920190657', 'Admin', 'Jeffry James Paner', 'Delete', 1606, 'Hannah I. Bryant has been deleted.', '2023-09-21', '01:06:57', '2023-09-21 01:06:57'),
(491, 'DAJJP20230920190702', 'Admin', 'Jeffry James Paner', 'Delete', 1618, 'Jose H. Morales has been deleted.', '2023-09-21', '01:07:02', '2023-09-21 01:07:02'),
(492, 'DAJJP20230920190709', 'Admin', 'Jeffry James Paner', 'Delete', 1620, 'Carl O. Wade has been deleted.', '2023-09-21', '01:07:09', '2023-09-21 01:07:09'),
(493, 'DAJJP20230920190715', 'Admin', 'Jeffry James Paner', 'Delete', 1631, 'Carl V. Lee has been deleted.', '2023-09-21', '01:07:15', '2023-09-21 01:07:15'),
(494, 'SOAJJP20230920190751', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '01:07:51', '2023-09-21 01:07:51'),
(495, 'DAT20230921061338', 'Admin', 'test', 'Delete', 1607, 'Jasper M. Robles has been deleted.', '2023-09-21', '12:13:38', '2023-09-21 12:13:38'),
(496, 'SIAJJP20230921063151', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '12:31:51', '2023-09-21 12:31:51'),
(497, 'SOAT20230921063432', 'Admin', 'test', 'Sign out', 0, 'test has been signed out.', '2023-09-21', '12:34:32', '2023-09-21 12:34:32'),
(498, 'SIAJJP20230921063440', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '12:34:40', '2023-09-21 12:34:40'),
(499, 'DAJJP20230921064655', 'Admin', 'Jeffry James Paner', 'Delete', 1593, 'Kim U. Bryant has been deleted.', '2023-09-21', '12:46:55', '2023-09-21 12:46:55'),
(500, 'UAJJP20230921070216', 'Admin', 'Jeffry James Paner', 'Update', 1594, 'Updated address: Victoria to San Aquilino', '2023-09-21', '13:02:16', '2023-09-21 13:02:16'),
(501, 'UAJJP20230921071130', 'Admin', 'Jeffry James Paner', 'Update', 1594, 'Updated address: San Aquilino to Libertad', '2023-09-21', '13:11:30', '2023-09-21 13:11:30'),
(502, 'UAJJP20230921071137', 'Admin', 'Jeffry James Paner', 'Update', 1597, 'Updated address: San Rafael to San Vicente', '2023-09-21', '13:11:37', '2023-09-21 13:11:37'),
(503, 'SOAJJP20230921071145', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '13:11:45', '2023-09-21 13:11:45'),
(504, 'SIAJJP20230921071151', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '13:11:51', '2023-09-21 13:11:51'),
(505, 'UAJJP20230921071521', 'Admin', 'Jeffry James Paner', 'Update', 1594, 'Updated property type: Commercial to Residential', '2023-09-21', '13:15:21', '2023-09-21 13:15:21'),
(506, 'UAJJP20230921082456', 'Admin', 'Jeffry James Paner', 'Update', 1594, 'Updated property type: Residential to Commercial', '2023-09-21', '14:24:56', '2023-09-21 14:24:56'),
(507, 'DAJJP20230921092217', 'Admin', 'Jeffry James Paner', 'Delete', 1610, 'Mark C. Paner has been deleted.', '2023-09-21', '15:22:17', '2023-09-21 15:22:17'),
(508, 'SOAJJP20230921092442', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '15:24:42', '2023-09-21 15:24:42'),
(509, 'SIAJJP20230921092448', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '15:24:48', '2023-09-21 15:24:48'),
(510, 'SOAJJP20230921094939', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '15:49:39', '2023-09-21 15:49:39'),
(511, 'SIAJJP20230921094944', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '15:49:44', '2023-09-21 15:49:44'),
(512, 'UAJJP20230921095405', 'Admin', 'Jeffry James Paner', 'Update', 1594, 'Updated address: Libertad to Little Tanauan', '2023-09-21', '15:54:05', '2023-09-21 15:54:05'),
(513, 'DAJJP20230921100238', 'Admin', 'Jeffry James Paner', 'Delete', 1594, 'Joy S. Richards has been deleted.', '2023-09-21', '16:02:38', '2023-09-21 16:02:38'),
(514, 'SOAJJP20230921101136', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '16:11:36', '2023-09-21 16:11:36'),
(515, 'SICAG20230921101152', 'Cashier', 'Anthony Galang', 'Sign in', 0, 'Anthony Galang has been signed in.', '2023-09-21', '16:11:52', '2023-09-21 16:11:52'),
(516, 'SIAJJP20230921101157', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '16:11:57', '2023-09-21 16:11:57'),
(517, 'SOAJJP20230921110539', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '17:05:39', '2023-09-21 17:05:39'),
(518, 'SIAJJP20230921110726', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '17:07:26', '2023-09-21 17:07:26'),
(519, 'SOAJJP20230921111248', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '17:12:48', '2023-09-21 17:12:48'),
(520, 'SIAJJP20230921111253', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '17:12:53', '2023-09-21 17:12:53'),
(521, 'SOAJJP20230921112755', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '17:27:55', '2023-09-21 17:27:55'),
(522, 'SIMRV20230921112803', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-21', '17:28:03', '2023-09-21 17:28:03'),
(523, 'SOMRV20230921112813', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-21', '17:28:13', '2023-09-21 17:28:13'),
(524, 'SIAJJP20230921112819', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '17:28:19', '2023-09-21 17:28:19'),
(525, 'SOAJJP20230921112859', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '17:28:59', '2023-09-21 17:28:59'),
(526, 'SIAJJP20230921153733', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '21:37:33', '2023-09-21 21:37:33'),
(527, 'DAJJP20230921155539', 'Admin', 'Jeffry James Paner', 'Delete', 1604, 'Patrick I. Delos Reyes has been deleted.', '2023-09-21', '21:55:39', '2023-09-21 21:55:39'),
(528, 'SOAJJP20230921165728', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '22:57:28', '2023-09-21 22:57:28'),
(529, 'SIAJJP20230921165735', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '22:57:35', '2023-09-21 22:57:35'),
(530, 'SIAJJP20230921165816', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '22:58:16', '2023-09-21 22:58:16'),
(531, 'SOAJJP20230921173226', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '23:32:26', '2023-09-21 23:32:26'),
(532, 'SIAJJP20230921173232', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '23:32:32', '2023-09-21 23:32:32'),
(533, 'SOAJJP20230921174507', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '23:45:07', '2023-09-21 23:45:07'),
(534, 'SIAJJP20230921174512', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '23:45:12', '2023-09-21 23:45:12'),
(535, 'SOAJJP20230921175434', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '23:54:34', '2023-09-21 23:54:34'),
(536, 'SIAJJP20230921175440', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '23:54:40', '2023-09-21 23:54:40'),
(537, 'SOAJJP20230921175856', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '23:58:56', '2023-09-21 23:58:56'),
(538, 'SIAJJP20230921175900', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '23:59:00', '2023-09-21 23:59:00'),
(539, 'SOAJJP20230921175905', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-21', '23:59:05', '2023-09-21 23:59:05'),
(540, 'SIAJJP20230921175912', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-21', '23:59:12', '2023-09-21 23:59:12'),
(541, 'SOAJJP20230921180516', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-22', '00:05:16', '2023-09-22 00:05:16'),
(542, 'SIMRV20230921180522', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-09-22', '00:05:22', '2023-09-22 00:05:22'),
(543, 'SOMRV20230921180539', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-09-22', '00:05:39', '2023-09-22 00:05:39'),
(544, 'SIAJJP20230921180546', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-22', '00:05:46', '2023-09-22 00:05:46'),
(545, 'DAJJP20230921190321', 'Admin', 'Jeffry James Paner', 'Delete', 1673, ' has been deleted.', '2023-09-22', '01:03:21', '2023-09-22 01:03:21'),
(546, 'DAJJP20230921191856', 'Admin', 'Jeffry James Paner', 'Delete', 1448, 'Louiella L. Delos Reyes has been deleted.', '2023-09-22', '01:18:56', '2023-09-22 01:18:56'),
(547, 'SOAJJP20230921193849', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-22', '01:38:49', '2023-09-22 01:38:49'),
(548, 'SIAJJP20230921193855', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-22', '01:38:55', '2023-09-22 01:38:55'),
(549, 'DAJJP20230921194012', 'Admin', 'Jeffry James Paner', 'Delete', 1611, 'Jose Paolo S. Jordan has been deleted.', '2023-09-22', '01:40:12', '2023-09-22 01:40:12'),
(550, 'SOAJJP20230921194051', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-22', '01:40:51', '2023-09-22 01:40:51'),
(551, 'SIAJJP20230922115838', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-22', '17:58:38', '2023-09-22 17:58:38'),
(552, 'SOAJJP20230922131635', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-09-22', '19:16:35', '2023-09-22 19:16:35'),
(553, 'SIAJJP20230922131640', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-22', '19:16:40', '2023-09-22 19:16:40'),
(554, 'SIAJJP20230922131734', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-09-22', '19:17:34', '2023-09-22 19:17:34'),
(555, 'DAJJP20230922140801', 'Admin', 'Jeffry James Paner', 'Delete', 1532, 'Lei B. Mayo has been deleted.', '2023-09-22', '20:08:01', '2023-09-22 20:08:01'),
(556, 'SIAJJP20231001190432', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-02', '01:04:32', '2023-10-02 01:04:32'),
(557, 'SIAJJP20231001191136', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-02', '01:11:36', '2023-10-02 01:11:36'),
(558, 'SIAJJP20231001191344', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-02', '01:13:44', '2023-10-02 01:13:44'),
(559, 'DAJJP20231001191756', 'Admin', 'Jeffry James Paner', 'Delete', 1597, 'Jennifer K. Robles has been deleted.', '2023-10-02', '01:17:56', '2023-10-02 01:17:56'),
(560, 'DAJJP20231001191803', 'Admin', 'Jeffry James Paner', 'Delete', 1628, 'Hannah U. Catapang has been deleted.', '2023-10-02', '01:18:03', '2023-10-02 01:18:03'),
(561, 'SIAJJP20231001192837', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-02', '01:28:37', '2023-10-02 01:28:37'),
(562, 'SIAJJP20231002101434', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-02', '16:14:34', '2023-10-02 16:14:34'),
(563, 'DAJJP20231002105931', 'Admin', 'Jeffry James Paner', 'Delete', 1617, 'James F. Uvas has been deleted.', '2023-10-02', '16:59:31', '2023-10-02 16:59:31'),
(564, 'SIAJJP20231003085200', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '14:52:00', '2023-10-03 14:52:00'),
(565, 'DAJJP20231003085233', 'Admin', 'Jeffry James Paner', 'Delete', 1615, 'Cristel F. James has been deleted.', '2023-10-03', '14:52:33', '2023-10-03 14:52:33'),
(566, 'DAJJP20231003085239', 'Admin', 'Jeffry James Paner', 'Delete', 1614, 'Roderick Q. Lee has been deleted.', '2023-10-03', '14:52:39', '2023-10-03 14:52:39'),
(567, 'DAJJP20231003085242', 'Admin', 'Jeffry James Paner', 'Delete', 1621, 'Justine F. Morales has been deleted.', '2023-10-03', '14:52:42', '2023-10-03 14:52:42'),
(568, 'DAJJP20231003085244', 'Admin', 'Jeffry James Paner', 'Delete', 1605, 'Jose X. Jordan has been deleted.', '2023-10-03', '14:52:44', '2023-10-03 14:52:44'),
(569, 'SIAJJP20231003085305', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '14:53:05', '2023-10-03 14:53:05'),
(570, 'SIAJJP20231003103521', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '16:35:21', '2023-10-03 16:35:21'),
(571, 'SIAJJP20231003104435', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '16:44:35', '2023-10-03 16:44:35'),
(572, 'SIAJJP20231003113005', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '17:30:05', '2023-10-03 17:30:05'),
(573, 'SIAJJP20231003120506', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '18:05:06', '2023-10-03 18:05:06'),
(574, 'SIAJJP20231003130032', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '19:00:32', '2023-10-03 19:00:32');
INSERT INTO `logs` (`id`, `log_id`, `user_role`, `user_name`, `user_activity`, `client_id`, `description`, `date`, `time`, `datetime`) VALUES
(575, 'SIAJJP20231003135118', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '19:51:18', '2023-10-03 19:51:18'),
(576, 'DAJJP20231003135213', 'Admin', 'Jeffry James Paner', 'Delete', 1608, 'Roderick A. James has been deleted.', '2023-10-03', '19:52:13', '2023-10-03 19:52:13'),
(577, 'SIAJJP20231003151755', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '21:17:55', '2023-10-03 21:17:55'),
(578, 'SOAJJP20231003160316', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-03', '22:03:16', '2023-10-03 22:03:16'),
(579, 'SIAJJP20231003163914', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-03', '22:39:14', '2023-10-03 22:39:14'),
(580, 'SIAJJP20231003181532', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '00:15:32', '2023-10-04 00:15:32'),
(581, 'SIAJJP20231003181918', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '00:19:18', '2023-10-04 00:19:18'),
(582, 'SIAJJP20231003183046', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '00:30:46', '2023-10-04 00:30:46'),
(583, 'SIAJJP20231003183509', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '00:35:09', '2023-10-04 00:35:09'),
(584, 'SOAJJP20231003183938', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-04', '00:39:38', '2023-10-04 00:39:38'),
(585, 'SIAJJP20231003183948', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '00:39:48', '2023-10-04 00:39:48'),
(586, 'SIAJJP20231003201311', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '02:13:11', '2023-10-04 02:13:11'),
(587, 'SOAJJP20231003201731', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-04', '02:17:31', '2023-10-04 02:17:31'),
(588, 'SIAJJP20231004083427', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '14:34:27', '2023-10-04 14:34:27'),
(589, 'SIAJJP20231004092416', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '15:24:16', '2023-10-04 15:24:16'),
(590, 'SIAJJP20231004094107', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '15:41:07', '2023-10-04 15:41:07'),
(591, 'SIAJJP20231004095502', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '15:55:02', '2023-10-04 15:55:02'),
(592, 'DAJJP20231004104926', 'Admin', 'Jeffry James Paner', 'Delete', 1599, 'Jose Paolo K. Robles has been deleted.', '2023-10-04', '16:49:26', '2023-10-04 16:49:26'),
(593, 'DAJJP20231004104930', 'Admin', 'Jeffry James Paner', 'Delete', 1600, 'Hannah V. Wade has been deleted.', '2023-10-04', '16:49:30', '2023-10-04 16:49:30'),
(594, 'DAJJP20231004104932', 'Admin', 'Jeffry James Paner', 'Delete', 1602, 'Jeffry T. Wade has been deleted.', '2023-10-04', '16:49:32', '2023-10-04 16:49:32'),
(595, 'DAJJP20231004104935', 'Admin', 'Jeffry James Paner', 'Delete', 1622, 'Hannah R. Paner has been deleted.', '2023-10-04', '16:49:35', '2023-10-04 16:49:35'),
(596, 'DAJJP20231004104938', 'Admin', 'Jeffry James Paner', 'Delete', 1625, 'Jep H. Curry has been deleted.', '2023-10-04', '16:49:38', '2023-10-04 16:49:38'),
(597, 'DAJJP20231004104941', 'Admin', 'Jeffry James Paner', 'Delete', 1629, 'Jasper M. Paner has been deleted.', '2023-10-04', '16:49:41', '2023-10-04 16:49:41'),
(598, 'SOAJJP20231004105257', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-04', '16:52:57', '2023-10-04 16:52:57'),
(599, 'SIAJJP20231004105307', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '16:53:07', '2023-10-04 16:53:07'),
(600, 'SOAJJP20231004133615', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-04', '19:36:15', '2023-10-04 19:36:15'),
(601, 'SIAJJP20231004133623', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '19:36:23', '2023-10-04 19:36:23'),
(602, 'SIAJJP20231004164534', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-04', '22:45:34', '2023-10-04 22:45:34'),
(603, 'SIAJJP20231005041504', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-05', '10:15:04', '2023-10-05 10:15:04'),
(604, 'SICC20231026035442', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '09:54:42', '2023-10-26 09:54:42'),
(605, 'SOCC20231026035457', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '09:54:57', '2023-10-26 09:54:57'),
(606, 'SIAJJP20231026035705', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '09:57:05', '2023-10-26 09:57:05'),
(607, 'SICC20231026041227', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '10:12:27', '2023-10-26 10:12:27'),
(608, 'SOCC20231026041233', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '10:12:33', '2023-10-26 10:12:33'),
(609, 'SIAJJP20231026041244', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '10:12:44', '2023-10-26 10:12:44'),
(610, 'SIAJJP20231026042844', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '10:28:44', '2023-10-26 10:28:44'),
(611, 'SIAJJP20231026043510', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '10:35:10', '2023-10-26 10:35:10'),
(612, 'SIAJJP20231026062548', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '12:25:48', '2023-10-26 12:25:48'),
(613, 'SIAJJP20231026064747', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '12:47:47', '2023-10-26 12:47:47'),
(614, 'SIAJJP20231026065007', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '12:50:07', '2023-10-26 12:50:07'),
(615, 'SIAJJP20231026065151', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '12:51:51', '2023-10-26 12:51:51'),
(616, 'SIAJJP20231026070449', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '13:04:49', '2023-10-26 13:04:49'),
(617, 'SOAJJP20231026070711', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-26', '13:07:11', '2023-10-26 13:07:11'),
(618, 'SICC20231026070716', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '13:07:16', '2023-10-26 13:07:16'),
(619, 'SOCC20231026070734', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '13:07:34', '2023-10-26 13:07:34'),
(620, 'SIMRV20231026070946', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-10-26', '13:09:46', '2023-10-26 13:09:46'),
(621, 'SOMRV20231026071024', 'Meter Reader', 'Rogene Vito', 'Sign out', 0, 'Rogene Vito has been signed out.', '2023-10-26', '13:10:24', '2023-10-26 13:10:24'),
(622, 'SIAJJP20231026071512', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '13:15:12', '2023-10-26 13:15:12'),
(623, 'SIAJJP20231026074810', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '13:48:10', '2023-10-26 13:48:10'),
(624, 'SIAJJP20231026075452', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '13:54:52', '2023-10-26 13:54:52'),
(625, 'SIAJJP20231026123040', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '18:30:40', '2023-10-26 18:30:40'),
(626, 'SOAJJP20231026135106', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-26', '19:51:06', '2023-10-26 19:51:06'),
(627, 'SICC20231026135111', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '19:51:11', '2023-10-26 19:51:11'),
(628, 'SOCC20231026135422', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '19:54:22', '2023-10-26 19:54:22'),
(629, 'SIAJJP20231026135428', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '19:54:28', '2023-10-26 19:54:28'),
(630, 'SIAJJP20231026152805', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:28:05', '2023-10-26 21:28:05'),
(631, 'SIAJJP20231026152921', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:29:21', '2023-10-26 21:29:21'),
(632, 'SIAJJP20231026153030', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:30:30', '2023-10-26 21:30:30'),
(633, 'SIAJJP20231026153311', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:33:11', '2023-10-26 21:33:11'),
(634, 'SIAJJP20231026153613', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:36:13', '2023-10-26 21:36:13'),
(635, 'SIAJJP20231026153642', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:36:42', '2023-10-26 21:36:42'),
(636, 'SIAJJP20231026153712', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:37:12', '2023-10-26 21:37:12'),
(637, 'SIAJJP20231026153735', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:37:35', '2023-10-26 21:37:35'),
(638, 'SICC20231026154151', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '21:41:51', '2023-10-26 21:41:51'),
(639, 'SOCC20231026154235', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '21:42:35', '2023-10-26 21:42:35'),
(640, 'SIAJJP20231026154239', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:42:39', '2023-10-26 21:42:39'),
(641, 'SIAJJP20231026154400', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:44:00', '2023-10-26 21:44:00'),
(642, 'SIAJJP20231026154849', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:48:49', '2023-10-26 21:48:49'),
(643, 'SIAJJP20231026155735', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '21:57:35', '2023-10-26 21:57:35'),
(644, 'SIAJJP20231026160040', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '22:00:40', '2023-10-26 22:00:40'),
(645, 'SIAJJP20231026161256', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '22:12:56', '2023-10-26 22:12:56'),
(646, 'SICC20231026162053', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '22:20:53', '2023-10-26 22:20:53'),
(647, 'SOCC20231026162104', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '22:21:04', '2023-10-26 22:21:04'),
(648, 'SIAJJP20231026162108', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '22:21:08', '2023-10-26 22:21:08'),
(649, 'SIAJJP20231026162522', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '22:25:22', '2023-10-26 22:25:22'),
(650, 'SICC20231026163426', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '22:34:26', '2023-10-26 22:34:26'),
(651, 'SOCC20231026163432', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '22:34:32', '2023-10-26 22:34:32'),
(652, 'SIAJJP20231026163443', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '22:34:43', '2023-10-26 22:34:43'),
(653, 'SIAJJP20231026164428', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-26', '22:44:28', '2023-10-26 22:44:28'),
(654, 'SOAJJP20231026164807', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-26', '22:48:07', '2023-10-26 22:48:07'),
(655, 'SICC20231026164811', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '22:48:11', '2023-10-26 22:48:11'),
(656, 'SOCC20231026165008', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '22:50:08', '2023-10-26 22:50:08'),
(657, 'SIMRV20231026165012', 'Meter Reader', 'Rogene Vito', 'Sign in', 0, 'Rogene Vito has been signed in.', '2023-10-26', '22:50:12', '2023-10-26 22:50:12'),
(658, 'SICC20231026165355', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-26', '22:53:55', '2023-10-26 22:53:55'),
(659, 'SOCC20231026165413', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-26', '22:54:13', '2023-10-26 22:54:13'),
(660, 'SIAJJP20231028045243', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-28', '10:52:43', '2023-10-28 10:52:43'),
(661, 'SICC20231028051025', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-28', '11:10:25', '2023-10-28 11:10:25'),
(662, 'SOCC20231028051129', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-28', '11:11:29', '2023-10-28 11:11:29'),
(663, 'SIAJJP20231028051139', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-28', '11:11:39', '2023-10-28 11:11:39'),
(664, 'SIAJJP20231028064334', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-28', '12:43:34', '2023-10-28 12:43:34'),
(665, 'SOAJJP20231028070511', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-28', '13:05:11', '2023-10-28 13:05:11'),
(666, 'SICC20231028070515', 'Cashier', 'CASHIER', 'Sign in', 0, 'CASHIER has been signed in.', '2023-10-28', '13:05:15', '2023-10-28 13:05:15'),
(667, 'SOCC20231028070804', 'Cashier', 'CASHIER', 'Sign out', 0, 'CASHIER has been signed out.', '2023-10-28', '13:08:04', '2023-10-28 13:08:04'),
(668, 'SIAJJP20231028070818', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-28', '13:08:18', '2023-10-28 13:08:18'),
(669, 'SIAJJP20231028071031', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-28', '13:10:31', '2023-10-28 13:10:31'),
(670, 'SOAJJP20231028072114', 'Admin', 'Jeffry James Paner', 'Sign out', 0, 'Jeffry James Paner has been signed out.', '2023-10-28', '13:21:14', '2023-10-28 13:21:14'),
(671, 'SIAJJP20231028072722', 'Admin', 'Jeffry James Paner', 'Sign in', 0, 'Jeffry James Paner has been signed in.', '2023-10-28', '13:27:22', '2023-10-28 13:27:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`,`email`);

--
-- Indexes for table `admin_id`
--
ALTER TABLE `admin_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_data`
--
ALTER TABLE `billing_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id` (`client_id`);

--
-- Indexes for table `clients_archive`
--
ALTER TABLE `clients_archive`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `client_application`
--
ALTER TABLE `client_application`
  ADD PRIMARY KEY (`id`,`first_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `client_data`
--
ALTER TABLE `client_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_secondary_data`
--
ALTER TABLE `client_secondary_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_id`
--
ALTER TABLE `admin_id`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `billing_data`
--
ALTER TABLE `billing_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `clients_archive`
--
ALTER TABLE `clients_archive`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1674;

--
-- AUTO_INCREMENT for table `client_application`
--
ALTER TABLE `client_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;

--
-- AUTO_INCREMENT for table `client_data`
--
ALTER TABLE `client_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `client_secondary_data`
--
ALTER TABLE `client_secondary_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=672;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
