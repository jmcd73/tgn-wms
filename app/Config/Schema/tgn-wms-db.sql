-- MySQL dump 10.13  Distrib 8.0.18, for macos10.14 (x86_64)
--
-- Host: localhost    Database: tgnwdb
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cartons`
--

DROP TABLE IF EXISTS `cartons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cartons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pallet_id` int(11) DEFAULT NULL,
  `count` int(3) DEFAULT NULL,
  `best_before` date DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL COMMENT 'This is for future use if we decide to go with mixed pallets',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `date_label_id` (`pallet_id`,`best_before`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cartons`
--

LOCK TABLES `cartons` WRITE;
/*!40000 ALTER TABLE `cartons` DISABLE KEYS */;
INSERT INTO `cartons` VALUES (1,63,100,'2020-05-20','2019-12-10',NULL,'2019-12-10 07:57:28','2019-12-10 07:57:28',NULL),(2,64,100,'2020-05-20','2019-12-10',NULL,'2019-12-10 08:27:08','2019-12-10 08:27:08',NULL),(3,65,48,'2020-12-09','2019-12-10',NULL,'2019-12-10 08:48:06','2019-12-10 08:48:06',NULL),(4,66,48,'2020-12-09','2019-12-10',NULL,'2019-12-10 09:45:38','2019-12-10 09:45:38',NULL);
/*!40000 ALTER TABLE `cartons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `help`
--

DROP TABLE IF EXISTS `help`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `help` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `controller_action` varchar(60) NOT NULL,
  `markdown_document` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller_action_UNIQUE` (`controller_action`),
  KEY `tgn-UQ` (`controller_action`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help`
--

LOCK TABLES `help` WRITE;
/*!40000 ALTER TABLE `help` DISABLE KEYS */;
INSERT INTO `help` VALUES (1,'LabelsController::pallet_print','PALLET_PRINT.md'),(2,'ShipmentsController::addApp','ADD_APP.md'),(3,'ShipmentsController::index','DISPATCH_INDEX.md'),(4,'HelpController::index','HELP_INDEX.md'),(6,'PagesController::display','HOME.md'),(7,'SettingsController::index','SETTINGS.md'),(8,'MenusController::index','MENUS.md');
/*!40000 ALTER TABLE `help` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_statuses`
--

DROP TABLE IF EXISTS `inventory_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inventory_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perms` int(11) NOT NULL,
  `name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `comment` varchar(255) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_statuses`
--

LOCK TABLES `inventory_statuses` WRITE;
/*!40000 ALTER TABLE `inventory_statuses` DISABLE KEYS */;
INSERT INTO `inventory_statuses` VALUES (1,13,'WAIT','Stops shipment and allows time for QA processes'),(2,13,'HOLD','Status applied if QA finds a problem or needs to delay shipment'),(3,12,'RETIPPED','Product produced but not useable, To be recycled or sent to waste');
/*!40000 ALTER TABLE `inventory_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL,
  `trade_unit` varchar(14) DEFAULT NULL,
  `pack_size_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `consumer_unit` varchar(14) DEFAULT NULL,
  `brand` varchar(32) DEFAULT NULL,
  `variant` varchar(32) DEFAULT NULL,
  `unit_net_contents` int(11) DEFAULT NULL,
  `unit_of_measure` varchar(4) DEFAULT NULL,
  `days_life` int(11) DEFAULT NULL,
  `min_days_life` int(3) NOT NULL,
  `item_comment` text NOT NULL,
  `print_template_id` int(11) NOT NULL,
  `carton_label_id` int(11) NOT NULL,
  `pallet_label_copies` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` VALUES (1,1,'10345','Ambient Product 1',100,'1234567890123',1,1,'12345678901234','Brand 1','Variant 1',1000,'G',162,90,'Set 90 days min life and 162 days life',3,5,4,NULL,NULL),(2,1,'20123','Desc Chilled 1',48,'1234567890123',1,2,'12345678901234','Brand 1','Chilled Cabbage',250,'g',365,0,'',2,5,NULL,NULL,NULL),(3,1,'10000','Desc Chilled 1',48,'1234567890123',1,1,'12345678901234','Brand 1','Variant 1',500,'g',365,0,'Comment 1',2,5,NULL,'2019-12-10 08:47:53','2019-12-10 08:47:53');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(20) CHARACTER SET latin1 NOT NULL,
  `pallet_capacity` int(11) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `description` varchar(50) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `product_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'A-DEFAULT',999999,0,'Ambient Storage','2019-10-22 22:28:45','2019-10-22 22:28:45',1),(2,'C-A0101',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(3,'C-A0102',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(4,'C-A0103',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(5,'C-A0104',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(6,'C-A0201',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(7,'C-A0202',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(8,'C-A0203',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(9,'C-A0204',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(10,'C-A0301',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(11,'C-A0302',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(12,'C-A0303',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(13,'C-A0304',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(14,'C-A0401',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(15,'C-A0402',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(16,'C-A0403',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(17,'C-A0404',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(18,'C-A0501',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(19,'C-A0502',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(20,'C-A0503',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(21,'C-A0504',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(22,'C-B0101',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(23,'C-B0102',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(24,'C-B0103',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(25,'C-B0104',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(26,'C-B0201',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(27,'C-B0202',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(28,'C-B0203',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(29,'C-B0204',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(30,'C-B0301',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(31,'C-B0302',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(32,'C-B0303',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(33,'C-B0304',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(34,'C-B0401',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(35,'C-B0402',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(36,'C-B0403',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(37,'C-B0404',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(38,'C-B0501',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(39,'C-B0502',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(40,'C-B0503',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(41,'C-B0504',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(42,'C-C0101',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(43,'C-C0102',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(44,'C-C0103',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(45,'C-C0104',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(46,'C-C0201',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(47,'C-C0202',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(48,'C-C0203',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(49,'C-C0204',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(50,'C-C0301',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(51,'C-C0302',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(52,'C-C0303',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(53,'C-C0304',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(54,'C-C0401',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(55,'C-C0402',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(56,'C-C0403',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(57,'C-C0404',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(58,'C-C0501',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(59,'C-C0502',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(60,'C-C0503',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(61,'C-C0504',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(62,'C-D0101',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(63,'C-D0102',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(64,'C-D0103',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(65,'C-D0104',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(66,'C-D0201',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(67,'C-D0202',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(68,'C-D0203',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(69,'C-D0204',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(70,'C-D0301',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(71,'C-D0302',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(72,'C-D0303',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(73,'C-D0304',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(74,'C-D0401',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(75,'C-D0402',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(76,'C-D0403',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(77,'C-D0404',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(78,'C-D0501',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(79,'C-D0502',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(80,'C-D0503',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(81,'C-D0504',2,0,'Coolroom location','2019-10-22 22:28:45','2019-10-22 22:28:45',2),(82,'C-Floor',2,0,'Coolroom overflow','2019-10-22 22:28:45','2019-10-25 20:27:40',2);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `divider` tinyint(1) NOT NULL,
  `header` tinyint(1) NOT NULL,
  `admin_menu` tinyint(1) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `url` varchar(254) DEFAULT NULL,
  `options` varchar(254) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `bs_url` varchar(255) NOT NULL,
  `extra_args` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (9,1,0,0,0,'Labels','Label Printing','#','','',NULL,13,26,'2016-08-31 19:41:20','2015-03-25 23:12:20','',''),(10,1,0,0,0,'Warehouse','Top Level Menu for Warehous','#','','',NULL,27,42,'2015-04-03 14:43:49','2015-03-25 23:12:39','',''),(12,1,0,0,0,'Reporting','Reporting top level menu','','','',NULL,1,4,'2016-08-31 18:48:30','2015-03-25 23:12:58','',''),(13,1,0,0,0,'Items','Item data view','array(\'controller\' => \'items\', \'action\' => \'index\')','','',100,6,7,'2019-10-15 18:19:06','2015-03-25 23:13:26','Items::index',''),(14,1,0,0,0,'Locations','Locations view','array(\'controller\' => \'locations\')','','',36,60,61,'2019-10-15 18:03:22','2015-03-25 23:14:23','Locations::index',''),(15,1,0,0,0,'Inventory Statuses','List Inventory Statuses','array(\'controller\' => \'inventoryStatuses\')','','List Inventory Statuses',36,56,57,'2019-10-15 18:05:00','2015-03-25 23:15:07','InventoryStatuses::index',''),(25,1,0,0,0,'Reprint','','array(\'controller\' => \'labels\', \'action\' => \'lookup\')','','Reprint Pallet Label',9,20,21,'2016-09-01 11:36:05','2015-03-26 06:16:27','Labels::lookup',''),(28,1,0,0,0,'View Stock','','array(\'controller\' => \'labels\', \'action\' => \'onhand\')','','',10,30,31,'2016-08-31 19:39:44','2015-03-26 06:18:24','Labels::onhand',''),(29,1,0,0,0,'Put-away','','','','',10,28,29,'2019-12-09 16:53:47','2015-03-26 06:18:45','Pallets::unassignedPallets',''),(30,1,0,0,0,'List','','array(\'controller\' => \'shipments\', \'action\' => \'index\')','array(\'title\' => \"View/Edit Shipments and Print Shippers\") ','View/Edit Shipments and Print Shippers',119,46,47,'2016-09-01 09:36:33','2015-03-26 06:19:14','Shipments::index',''),(36,1,0,0,1,'Admin','Admin Menu','#','','Admin Menu',NULL,53,82,'2018-09-05 12:55:10','2015-03-27 16:40:55','',''),(38,1,0,0,0,'Pallet Track','','array(\'controller\'=>\'labels\' , \'action\'=> \'lookup\')','array(\'title\' => \"Track a pallet\") ','Track a pallet',10,36,37,'2016-08-31 22:14:50','2015-03-27 16:55:25','Labels::lookup',''),(39,1,0,0,0,'Settings','View Settings','array(\'controller\' => \'settings\')','','View and change configuration settings',36,74,75,'2018-09-05 13:06:22','2015-03-27 19:46:28','Settings::index',''),(46,1,0,0,0,'Menus','List Menus','array(\'controller\'=>\'menus\', \'action\'=>\'index\')','','',36,76,77,'2018-09-05 13:02:04','2015-03-28 23:08:36','Menus::index',''),(57,1,0,1,0,'Shipments','','#','','',119,44,45,'2016-09-01 09:36:23','2015-03-29 21:34:45','',''),(96,1,0,1,0,'Pallet Labels','Print Pallet Labels','#','array(\'title\'=> \"Pallet Labels\")','Pallet Labels',9,14,15,'2016-08-31 20:18:44','2015-10-21 09:57:23','',''),(99,1,0,0,0,'Custom Labels','Print a range of custom labels','#','array(\'title\'=> \"Print custom labels - for short or sample runs\")','Print custom labels - for short or sample runs',9,16,17,'2015-10-21 10:04:51','2015-10-21 10:04:51','',''),(100,1,0,0,0,'Data','Data Menu','#','array(\'title\'=> \"Item Data etc\");','Item Data etc',NULL,5,12,'2016-04-18 20:47:59','2016-04-18 20:47:59','',''),(101,1,0,0,0,'Day of Year','Day of Year Calculator','array(\'controller\'=>\'pages\', \'action\'=>\'display\', \'dayofyear\')','array(\'title\'=>\"Day of Year Number Calculator\")','Day of Year Number Calculator',100,10,11,'2017-01-28 18:54:23','2016-04-18 20:52:01','PrintLabels::dayofyear','dayofyear'),(108,1,0,0,0,'Users','List Users','array(\'controller\' => \'users\', \'action\' => \'index\')','','',36,54,55,'2018-09-05 13:04:23','2016-08-31 14:21:28','Users::index',''),(112,1,1,1,0,'Tracing','','','','',10,34,35,'2016-08-31 22:15:49','2016-08-31 22:15:28','',''),(119,1,0,0,0,'Dispatch','Dispatch Menu','','','Dispatch Menu',NULL,43,52,'2016-09-01 09:32:59','2016-09-01 09:32:47','',''),(121,1,1,1,0,'Utilities','Utilities','','','Utilities',100,8,9,'2016-09-01 10:12:02','2016-09-01 10:10:48','',''),(129,1,0,0,0,'Edit QA Status','Edit QA Status',NULL,'','',10,40,41,'2016-12-05 17:24:51','2016-12-05 17:09:10','Labels::bulkStatusRemove','3'),(130,1,1,1,0,'QA','QA',NULL,'','',10,38,39,'2016-12-05 17:24:32','2016-12-05 17:24:32','',''),(135,1,0,0,0,'Shift Report','Shift Report',NULL,'','',12,2,3,'2017-04-07 22:22:10','2017-04-07 22:22:10','Labels::formatReport',''),(141,1,0,0,0,'Product Types','Product Types',NULL,'','',36,58,59,'2018-09-05 12:59:46','2018-09-05 12:59:46','ProductTypes::index',''),(142,1,0,0,1,'Shifts','Shifts',NULL,'','',36,62,63,'2018-09-05 13:00:42','2018-09-05 13:00:42','Shifts::index',''),(143,1,0,0,0,'Print Templates','Print Templates',NULL,'','',36,70,71,'2018-09-05 13:01:24','2018-09-05 13:01:24','PrintTemplates::index',''),(144,1,0,0,0,'Label Chooser','Label Chooser',NULL,'','Label Chooser',9,24,25,'2018-10-23 11:40:52','2018-10-23 11:40:52','PrintLabels::labelChooser',''),(145,1,1,1,0,'Custom Label Printing','Chooser',NULL,'','',9,22,23,'2019-06-18 22:27:35','2018-11-05 12:07:21','',''),(146,1,0,0,0,'Location Usage','Location Usage',NULL,'','Marg Location Usage',10,32,33,'2019-10-15 12:26:24','2018-12-10 10:24:45','Labels::locationSpaceUsage',''),(147,1,0,0,0,'Pick Stock','Pick Stock',NULL,'','Pick Stock',119,50,51,'2018-12-14 23:36:49','2018-12-14 23:36:49','Shipments::pickStock',''),(148,1,1,1,0,'Pick','Pick',NULL,'','',119,48,49,'2018-12-15 00:51:57','2018-12-15 00:50:35','',''),(150,1,0,0,0,'Pack Sizes','Pack Sizes',NULL,'','Pack Sizes',36,64,65,'2019-10-15 17:35:22','2019-10-12 20:04:35','PackSizes::index',''),(152,1,0,0,0,'Print SSCC','Pallet Print',NULL,'','Pallet Print',9,18,19,'2019-10-17 19:32:29','2019-10-12 21:41:15','Labels::selectPalletPrintType',''),(153,1,0,0,0,'Printers','',NULL,'','',36,68,69,'2019-10-15 17:34:35','2019-10-13 08:45:45','Printers::index',''),(155,1,0,0,0,'Production Lines','',NULL,'','',36,72,73,'2019-10-15 17:34:15','2019-10-13 08:50:06','ProductionLines::index',''),(157,1,0,0,1,'Help','Help System',NULL,'','',36,80,81,'2019-10-20 16:43:02','2019-10-20 16:42:43','Help::index',''),(158,1,0,0,1,'Items','Admin Menu Items',NULL,'','Items',36,66,67,'2019-10-23 12:13:08','2019-10-23 12:13:08','Items::index',''),(159,1,1,1,1,'Help','Help',NULL,'','Help',36,78,79,'2019-10-23 12:15:26','2019-10-23 12:15:26','','');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pack_sizes`
--

DROP TABLE IF EXISTS `pack_sizes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pack_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pack_size` varchar(30) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pack_sizes`
--

LOCK TABLES `pack_sizes` WRITE;
/*!40000 ALTER TABLE `pack_sizes` DISABLE KEYS */;
INSERT INTO `pack_sizes` VALUES (1,'PackSize1','Sample pack size define logical product groups as needed','2019-10-23 14:02:15','2019-10-23 14:02:15');
/*!40000 ALTER TABLE `pack_sizes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pallets`
--

DROP TABLE IF EXISTS `pallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pallets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `production_line_id` int(11) DEFAULT NULL,
  `item` varchar(10) CHARACTER SET latin1 NOT NULL,
  `description` varchar(50) CHARACTER SET latin1 NOT NULL,
  `item_id` int(11) NOT NULL,
  `best_before` varchar(10) CHARACTER SET latin1 NOT NULL,
  `bb_date` date NOT NULL,
  `gtin14` varchar(14) CHARACTER SET latin1 NOT NULL,
  `qty_user_id` int(11) NOT NULL,
  `qty` int(5) NOT NULL,
  `qty_previous` varchar(255) CHARACTER SET latin1 NOT NULL,
  `qty_modified` datetime NOT NULL,
  `pl_ref` varchar(10) CHARACTER SET latin1 NOT NULL,
  `sscc` varchar(18) CHARACTER SET latin1 NOT NULL,
  `batch` varchar(6) CHARACTER SET latin1 NOT NULL,
  `printer` varchar(50) CHARACTER SET latin1 NOT NULL,
  `printer_id` int(11) DEFAULT NULL,
  `print_date` datetime NOT NULL,
  `cooldown_date` datetime DEFAULT NULL,
  `min_days_life` int(11) NOT NULL,
  `production_line` varchar(45) CHARACTER SET latin1 NOT NULL,
  `location_id` int(11) NOT NULL,
  `shipment_id` int(11) NOT NULL,
  `inventory_status_id` int(11) NOT NULL,
  `inventory_status_note` varchar(100) NOT NULL,
  `inventory_status_datetime` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `ship_low_date` tinyint(1) NOT NULL,
  `picked` tinyint(1) NOT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pl_ref` (`pl_ref`),
  UNIQUE KEY `sscc` (`sscc`),
  KEY `item` (`item`),
  KEY `item_id` (`item_id`),
  KEY `description` (`description`),
  KEY `print_date` (`print_date`,`bb_date`),
  KEY `bb_date` (`bb_date`),
  KEY `batch` (`batch`),
  KEY `qty` (`qty`),
  KEY `item_id_desc` (`item_id`),
  KEY `print_date_desc` (`print_date`),
  KEY `qty_desc` (`qty`),
  KEY `bb_date_desc` (`bb_date`),
  KEY `location_id` (`location_id`),
  KEY `location_id_desc` (`location_id`),
  KEY `shipment_id` (`shipment_id`),
  KEY `shipment_id_desc` (`shipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pallets`
--

LOCK TABLES `pallets` WRITE;
/*!40000 ALTER TABLE `pallets` DISABLE KEYS */;
INSERT INTO `pallets` VALUES (1,1,'10345','Ambient Product 1',1,'','2020-04-02','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000002','099999990000000232','929601','',1,'2019-10-23 14:06:24','2019-10-23 14:06:24',90,'Ambient Li',1,8,0,'','0000-00-00 00:00:00','2019-10-23 14:06:24','2019-12-10 11:42:50',0,0,1),(2,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000003','099999990000000249','929802','',1,'2019-10-25 18:20:23','2019-10-25 18:20:23',90,'Ambient Li',1,8,0,'','0000-00-00 00:00:00','2019-10-25 18:20:23','2019-12-10 11:42:50',0,0,1),(3,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000004','099999990000000256','929802','',1,'2019-10-25 18:20:28','2019-10-25 18:20:28',90,'Ambient Li',1,8,0,'','0000-00-00 00:00:00','2019-10-25 18:20:28','2019-12-10 11:42:50',0,0,1),(4,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000005','099999990000000263','929802','',1,'2019-10-25 18:20:30','2019-10-25 18:20:30',90,'Ambient Li',1,0,1,'','2019-10-25 21:27:17','2019-10-25 18:20:31','2019-10-25 21:27:17',0,0,1),(5,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000006','099999990000000270','929803','',2,'2019-10-25 18:21:06','2019-10-25 18:21:06',90,'Ambient Li',1,0,1,'','2019-10-25 21:27:17','2019-10-25 18:21:06','2019-10-25 21:27:17',0,0,1),(6,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000007','099999990000000287','929803','',2,'2019-10-25 18:21:09','2019-10-25 18:21:09',90,'Ambient Li',1,0,1,'','2019-10-25 21:27:17','2019-10-25 18:21:09','2019-10-25 21:27:17',0,0,1),(7,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000008','099999990000000294','929803','',2,'2019-10-25 18:21:11','2019-10-25 18:21:11',90,'Ambient Li',1,0,1,'','2019-10-25 21:27:17','2019-10-25 18:21:11','2019-10-25 21:27:17',0,0,1),(8,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000002','099999990000000300','929806','',1,'2019-10-25 20:47:54','2019-10-25 20:47:54',210,'Chilled Li',2,7,0,'','0000-00-00 00:00:00','2019-10-25 20:47:54','2019-12-10 11:41:57',0,0,2),(9,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000003','099999990000000317','929805','',1,'2019-10-25 20:48:05','2019-10-25 20:48:05',210,'Chilled Li',2,7,0,'','0000-00-00 00:00:00','2019-10-25 20:48:05','2019-12-10 11:41:57',0,0,2),(10,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000004','099999990000000324','929805','',1,'2019-10-25 20:48:09','2019-10-25 20:48:09',210,'Chilled Li',3,7,0,'','0000-00-00 00:00:00','2019-10-25 20:48:09','2019-12-10 11:41:57',0,0,2),(11,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000005','099999990000000331','929806','',1,'2019-10-25 20:48:17','2019-10-25 20:48:17',210,'Chilled Li',3,7,0,'','0000-00-00 00:00:00','2019-10-25 20:48:17','2019-12-10 11:41:57',0,0,2),(12,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000006','099999990000000348','929805','',1,'2019-10-25 20:48:21','2019-10-25 20:48:21',210,'Chilled Li',4,10,0,'','0000-00-00 00:00:00','2019-10-25 20:48:21','2019-12-10 11:43:49',0,0,2),(13,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000007','099999990000000355','929806','',1,'2019-10-25 20:48:25','2019-10-25 20:48:25',210,'Chilled Li',4,11,0,'','0000-00-00 00:00:00','2019-10-25 20:48:25','2019-12-10 11:44:21',0,0,2),(14,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000008','099999990000000362','929805','',1,'2019-10-25 20:48:29','2019-10-25 20:48:29',210,'Chilled Li',5,11,0,'','0000-00-00 00:00:00','2019-10-25 20:48:29','2019-12-10 11:44:21',0,0,2),(15,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000009','099999990000000379','929806','',1,'2019-10-25 20:53:04','2019-10-25 20:53:04',210,'Chilled Li',5,11,0,'','0000-00-00 00:00:00','2019-10-25 20:53:04','2019-12-10 11:44:21',0,0,2),(16,2,'20123','Desc Chilled 1',2,'24/10/20','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000010','099999990000000386','929805','',1,'2019-10-25 20:53:07','2019-10-25 20:53:07',210,'Chilled Li',6,12,0,'','0000-00-00 00:00:00','2019-10-25 20:53:07','2019-12-10 11:44:45',0,0,2),(17,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000011','099999990000000393','929806','',1,'2019-10-25 20:53:11','2019-10-25 20:53:11',210,'Chilled Li',6,12,0,'','0000-00-00 00:00:00','2019-10-25 20:53:11','2019-12-10 11:44:45',0,0,2),(18,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000012','099999990000000409','929805','',1,'2019-10-25 20:53:14','2019-10-25 20:53:14',210,'Chilled Li',7,0,0,'','0000-00-00 00:00:00','2019-10-25 20:53:14','2019-10-25 21:18:02',0,0,2),(19,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000013','099999990000000416','929806','',1,'2019-10-25 20:53:53','2019-10-25 20:53:53',210,'Chilled Li',7,0,0,'','0000-00-00 00:00:00','2019-10-25 20:53:53','2019-10-25 21:18:02',0,0,2),(20,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000014','099999990000000423','929806','',1,'2019-10-25 21:15:29','2019-10-25 21:15:29',210,'Chilled Li',8,0,0,'','0000-00-00 00:00:00','2019-10-25 21:15:29','2019-10-25 21:18:02',0,0,2),(21,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000015','099999990000000430','929805','',1,'2019-10-25 21:15:33','2019-10-25 21:15:33',210,'Chilled Li',8,0,0,'','0000-00-00 00:00:00','2019-10-25 21:15:33','2019-10-25 21:18:02',0,0,2),(22,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000016','099999990000000447','929805','',1,'2019-10-25 21:15:48','2019-10-25 21:15:48',210,'Chilled Li',9,0,0,'','0000-00-00 00:00:00','2019-10-25 21:15:48','2019-10-27 08:20:01',0,0,2),(23,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000017','099999990000000454','929806','',1,'2019-10-25 21:15:51','2019-10-25 21:15:51',210,'Chilled Li',9,0,0,'','0000-00-00 00:00:00','2019-10-25 21:15:51','2019-10-25 21:18:02',0,0,2),(24,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000009','099999990000000461','929802','',2,'2019-10-25 21:16:35','2019-10-25 21:16:35',90,'Ambient Li',1,9,0,'','0000-00-00 00:00:00','2019-10-25 21:16:35','2019-12-10 11:43:17',0,0,1),(25,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000010','099999990000000478','929802','',1,'2019-10-25 21:16:41','2019-10-25 21:16:41',90,'Ambient Li',1,9,0,'','0000-00-00 00:00:00','2019-10-25 21:16:41','2019-12-10 11:43:17',0,0,1),(26,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000011','099999990000000485','929801','',2,'2019-10-25 21:17:27','2019-10-25 21:17:27',90,'Ambient Li',1,9,0,'','0000-00-00 00:00:00','2019-10-25 21:17:27','2019-12-10 11:43:17',0,0,1),(27,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000012','099999990000000492','929802','',1,'2019-10-25 21:17:33','2019-10-25 21:17:33',90,'Ambient Li',1,9,0,'','0000-00-00 00:00:00','2019-10-25 21:17:33','2019-12-10 11:43:17',0,0,1),(28,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000013','099999990000000508','929802','',1,'2019-10-25 21:33:41','2019-10-25 21:33:41',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 21:33:41','2019-10-25 22:30:04',0,0,1),(29,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000014','099999990000000515','929801','',2,'2019-10-25 21:33:45','2019-10-25 21:33:45',90,'Ambient Li',1,6,0,'','0000-00-00 00:00:00','2019-10-25 21:33:45','2019-12-10 11:40:47',0,0,1),(30,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000015','099999990000000522','929802','',1,'2019-10-25 21:33:50','2019-10-25 21:33:50',90,'Ambient Li',1,6,0,'','0000-00-00 00:00:00','2019-10-25 21:33:50','2019-12-10 11:40:47',0,0,1),(31,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000016','099999990000000539','929802','',1,'2019-10-25 21:34:02','2019-10-25 21:34:02',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 21:34:02','2019-10-25 21:34:02',0,0,1),(32,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000017','099999990000000546','929802','',1,'2019-10-25 22:46:31','2019-10-25 22:46:31',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 22:46:31','2019-10-25 22:46:31',0,0,1),(33,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000018','099999990000000553','929802','',1,'2019-10-25 22:46:44','2019-10-25 22:46:44',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 22:46:45','2019-10-25 22:46:45',0,0,1),(34,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000019','099999990000000560','929802','',1,'2019-10-25 22:47:15','2019-10-25 22:47:15',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 22:47:15','2019-10-25 22:47:15',0,0,1),(35,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000020','099999990000000577','929802','',1,'2019-10-25 22:53:02','2019-10-25 22:53:02',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 22:53:02','2019-10-25 22:53:02',0,0,1),(36,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000021','099999990000000584','929802','',1,'2019-10-25 22:53:09','2019-10-25 22:53:09',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 22:53:09','2019-10-25 22:53:09',0,0,1),(37,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000022','099999990000000591','929802','',2,'2019-10-25 22:53:47','2019-10-25 22:53:47',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 22:53:47','2019-10-25 22:53:47',0,0,1),(38,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000023','099999990000000607','929801','',2,'2019-10-25 23:01:08','2019-10-25 23:01:08',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:01:08','2019-10-25 23:01:08',0,0,1),(39,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000024','099999990000000614','929802','',2,'2019-10-25 23:01:41','2019-10-25 23:01:41',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:01:41','2019-10-25 23:01:41',0,0,1),(40,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000025','099999990000000621','929802','',4,'2019-10-25 23:19:08','2019-10-25 23:19:08',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:19:08','2019-10-25 23:19:08',0,0,1),(41,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000026','099999990000000638','929801','',4,'2019-10-25 23:19:14','2019-10-25 23:19:14',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:19:14','2019-10-25 23:19:14',0,0,1),(42,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000027','099999990000000645','929802','',4,'2019-10-25 23:21:16','2019-10-25 23:21:16',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:21:16','2019-10-25 23:21:16',0,0,1),(43,3,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000028','099999990000000652','929802','',4,'2019-10-25 23:23:41','2019-10-25 23:23:41',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:23:41','2019-10-25 23:23:41',0,0,1),(44,1,'10345','Ambient Product 1',1,'','2020-04-04','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000029','099999990000000669','929801','',4,'2019-10-25 23:23:44','2019-10-25 23:23:44',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-25 23:23:44','2019-10-25 23:23:44',0,0,1),(45,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000018','099999990000000676','929806','',5,'2019-10-25 23:23:57','2019-10-25 23:23:57',210,'Chilled Li',2,0,1,'','0000-00-00 00:00:00','2019-10-25 23:23:57','2019-10-25 23:25:01',0,0,2),(46,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000019','099999990000000683','929805','',5,'2019-10-25 23:24:01','2019-10-25 23:24:01',210,'Chilled Li',2,0,1,'','0000-00-00 00:00:00','2019-10-25 23:24:01','2019-10-25 23:25:07',0,0,2),(47,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000020','099999990000000690','929806','',5,'2019-10-25 23:24:05','2019-10-25 23:24:05',210,'Chilled Li',3,0,1,'','0000-00-00 00:00:00','2019-10-25 23:24:05','2019-10-25 23:25:12',0,0,2),(48,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000021','099999990000000706','929805','',5,'2019-10-25 23:24:08','2019-10-25 23:24:08',210,'Chilled Li',5,0,1,'','0000-00-00 00:00:00','2019-10-25 23:24:08','2019-10-25 23:25:18',0,0,2),(49,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000022','099999990000000713','929805','',5,'2019-10-25 23:24:38','2019-10-25 23:24:38',210,'Chilled Li',6,0,1,'','0000-00-00 00:00:00','2019-10-25 23:24:38','2019-10-25 23:25:23',0,0,2),(50,2,'20123','Desc Chilled 1',2,'','2020-10-24','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000023','099999990000000720','929806','',5,'2019-10-25 23:24:41','2019-10-25 23:24:41',210,'Chilled Li',10,0,1,'','0000-00-00 00:00:00','2019-10-25 23:24:41','2019-10-25 23:25:28',0,0,2),(51,1,'10345','Ambient Product 1',1,'','2020-04-05','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000030','099999990000000737','929902','',4,'2019-10-26 08:20:23','2019-10-26 08:20:23',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-26 08:20:23','2019-10-26 08:20:23',0,0,1),(52,1,'10345','Ambient Product 1',1,'','2020-04-05','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000031','099999990000000744','929902','',4,'2019-10-26 08:21:03','2019-10-26 08:21:03',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-26 08:21:03','2019-10-26 08:21:03',0,0,1),(53,1,'10345','Ambient Product 1',1,'','2020-04-05','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000032','099999990000000751','929902','',4,'2019-10-26 09:55:23','2019-10-26 09:55:23',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-26 09:55:23','2019-10-26 09:55:23',0,0,1),(54,1,'10345','Ambient Product 1',1,'','2020-04-05','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000033','099999990000000768','929902','',4,'2019-10-26 09:55:59','2019-10-26 09:55:59',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-26 09:55:59','2019-10-26 09:55:59',0,0,1),(55,1,'10345','Ambient Product 1',1,'','2020-04-05','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000034','099999990000000775','929902','',4,'2019-10-26 09:57:09','2019-10-26 09:57:09',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-10-26 09:57:09','2019-10-26 09:57:09',0,0,1),(56,2,'20123','Desc Chilled 1',2,'','2020-10-25','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000024','099999990000000782','929902','',5,'2019-10-26 10:12:09','2019-10-26 10:12:09',210,'Chilled Li',0,0,1,'','0000-00-00 00:00:00','2019-10-26 10:12:09','2019-10-26 10:12:09',0,0,2),(57,2,'20123','Desc Chilled 1',2,'','2020-10-25','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000025','099999990000000799','929902','',5,'2019-10-26 10:12:32','2019-10-26 10:12:32',210,'Chilled Li',0,0,1,'','0000-00-00 00:00:00','2019-10-26 10:12:32','2019-10-26 10:12:32',0,0,2),(58,2,'20123','Desc Chilled 1',2,'','2020-10-25','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000026','099999990000000805','929902','',5,'2019-10-26 10:14:59','2019-10-26 10:14:59',210,'Chilled Li',0,0,1,'','0000-00-00 00:00:00','2019-10-26 10:14:59','2019-10-26 10:14:59',0,0,2),(59,2,'20123','Desc Chilled 1',2,'','2020-10-26','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000027','099999990000000812','930003','',5,'2019-10-27 08:20:36','2019-10-27 08:20:36',210,'Chilled Li',0,0,1,'','0000-00-00 00:00:00','2019-10-27 08:20:36','2019-10-27 08:20:36',0,0,2),(60,2,'20123','Desc Chilled 1',2,'','2020-10-26','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000028','099999990000000829','930003','',5,'2019-10-27 08:20:43','2019-10-27 08:20:43',210,'Chilled Li',0,0,1,'','0000-00-00 00:00:00','2019-10-27 08:20:43','2019-10-27 08:20:43',0,0,2),(61,2,'20123','Desc Chilled 1',2,'','2020-10-26','1234567890123',0,48,'0','0000-00-00 00:00:00','C-000029','099999990000000836','930003','',5,'2019-10-27 08:23:40','2019-10-27 08:23:40',210,'Chilled Li',0,0,1,'','0000-00-00 00:00:00','2019-10-27 08:23:40','2019-10-27 08:23:40',0,0,2),(62,3,'10345','Ambient Product 1',1,'','2020-05-07','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000035','099999990000000843','933102','',4,'2019-11-27 20:56:27','2019-11-27 20:56:27',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-11-27 20:56:27','2019-11-27 20:56:27',0,0,1),(63,1,'10345','Ambient Product 1',1,'','2020-05-20','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000036','099999990000000850','934499','PDF Printer',4,'2019-12-10 07:57:28','2019-12-10 07:57:28',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-12-10 07:57:28','2019-12-10 07:57:28',0,0,1),(64,1,'10345','Ambient Product 1',1,'','2020-05-20','1234567890123',0,100,'0','0000-00-00 00:00:00','A-000037','099999990000000867','934499','PDF Printer',4,'2019-12-10 08:27:08','2019-12-10 08:27:08',90,'Ambient Li',1,0,0,'','0000-00-00 00:00:00','2019-12-10 08:27:08','2019-12-10 08:27:08',0,0,1),(65,1,'10000','Desc Chilled 1',3,'','2020-12-09','1234567890123',0,48,'0','0000-00-00 00:00:00','A-000038','099999990000000874','934499','PDF Printer',4,'2019-12-10 08:48:06','2019-12-10 08:48:06',210,'Ambient Line 1',1,6,0,'','0000-00-00 00:00:00','2019-12-10 08:48:06','2019-12-10 11:40:47',0,0,1),(66,1,'10000','Desc Chilled 1',3,'','2020-12-09','1234567890123',0,48,'0','0000-00-00 00:00:00','A-000039','099999990000000881','934499','PDF Printer',4,'2019-12-10 09:45:38','2019-12-10 09:45:38',210,'123456789012345678901234567890123456789012345',1,6,0,'','0000-00-00 00:00:00','2019-12-10 09:45:38','2019-12-10 11:40:47',0,0,1);
/*!40000 ALTER TABLE `pallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print_log`
--

DROP TABLE IF EXISTS `print_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `print_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `print_data` text,
  `print_action` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_log`
--

LOCK TABLES `print_log` WRITE;
/*!40000 ALTER TABLE `print_log` DISABLE KEYS */;
INSERT INTO `print_log` VALUES (1,'{\"barcode\":\"1234567890123\",\"print_action\":\"carton_print\",\"description\":\"Desc Chilled 1\",\"count\":\"1\",\"printer_id\":\"1\",\"printer_friendly_name\":\"PDF Printer\"}','carton_print','2019-10-25 22:24:36','2019-10-25 22:24:36'),(2,'{\"barcode\":\"1234567890123\",\"print_action\":\"carton_print\",\"description\":\"Desc Chilled 1\",\"count\":\"1\",\"printer_id\":\"4\",\"printer_friendly_name\":\"PDF Printer\"}','carton_print','2019-10-25 22:26:52','2019-10-25 22:26:52'),(3,'{\"barcode\":\"1234567890123\",\"print_action\":\"carton_print\",\"description\":\"Desc Chilled 1\",\"count\":\"1\",\"printer_id\":\"5\",\"printer_friendly_name\":\"Virtual PDF\"}','carton_print','2019-10-26 09:25:27','2019-10-26 09:25:27');
/*!40000 ALTER TABLE `print_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print_templates`
--

DROP TABLE IF EXISTS `print_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `print_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `text_template` mediumblob,
  `file_template` varchar(200) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `is_file_template` int(1) DEFAULT '0',
  `print_action` varchar(50) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `example_image` varchar(200) DEFAULT NULL,
  `file_template_type` varchar(200) DEFAULT NULL,
  `file_template_size` int(11) DEFAULT NULL,
  `example_image_size` int(11) DEFAULT NULL,
  `example_image_type` varchar(200) DEFAULT NULL,
  `show_in_label_chooser` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_templates`
--

LOCK TABLES `print_templates` WRITE;
/*!40000 ALTER TABLE `print_templates` DISABLE KEYS */;
INSERT INTO `print_templates` VALUES (2,'Default SSCC Pallet Label Template','150x200 label. Use this template if the qty is 2 digits',_binary 'm m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 9,107,0,GS1-128,40,0.5;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'palletPrint','2017-07-24 13:24:42','2019-12-09 16:56:59','150x200-SSCC-example.png',NULL,NULL,184411,'image/png',0,63,28,29),(3,'SSCC Template 3 Digit Qty','150x200 For any products with a 3 digit qty',_binary 'm m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 12.5,107,0,GS1-128,40,0.45;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'palletPrint','2017-07-24 13:26:40','2019-12-09 16:57:13',NULL,NULL,NULL,NULL,NULL,0,63,30,31),(5,'Carton Label','100x50 CAB Carton Label',_binary 'm m\r\nJ 100 x 50 carton label\r\nH 100\r\nS l1;0,0,50,53,100\r\nO R\r\nT 6,4,0,596,pt16;*DESC*\r\nG 3,6,0;L:94,0.3\r\nB 8,8,0,GS1-128,38,0.56;(01)*GTIN14*\r\nA *NUM_LABELS*\r\n',NULL,1,0,'cartonPrint','2018-12-16 16:11:25','2019-12-09 16:54:52','100x50carton.png',NULL,NULL,12522,'image/png',1,66,4,5),(6,'Big Numbers','100x200 Big Number Zebra Printer Only',_binary '^XA\r\n^MD6.0\r\n\r\n^FXBig Number Shipping Label^FS\r\n^PON\r\n^FT0030,0080^A0N,065,070^FD*COMPANY_NAME*^FS\r\n^FO0030,0100^GB750,5,4^FS\r\n\r\n^FT*OFFSET*,1000^A0N,1000,500^FD*NUMBER*^FS\r\n\r\n^PQ*NUM_LABELS*,0,1,Y^XZ\r\n',NULL,1,0,'bigNumber','2018-12-16 16:12:20','2019-12-09 16:56:44','100x200-big_numbers-example.png',NULL,NULL,7389,'image/png',1,65,24,25),(52,'Assorted Custom Labels','100x50 50025, Keep Refrigerated Label','','100x50custom.glabels',1,1,'customPrint','2019-06-18 16:34:22','2019-12-09 16:54:23','toggen-custom-print0-1.png','application/octet-stream',16529,77248,'image/png',1,66,2,3),(53,'Sample Labels','100x50 Product Sample Labels','','100x50sample-1.glabels',1,1,'sampleLabels','2019-06-18 16:45:46','2019-12-09 16:55:25','sample_label.png','application/octet-stream',11601,71644,'image/png',1,66,8,9),(54,'Shipping Labels','150x200 Shipping Labels','','150x200-shipping-labels.glabels',1,1,'shippingLabels','2019-06-18 17:01:44','2019-12-09 16:55:43','150x200-shipping-label.png','application/octet-stream',6864,71992,'image/png',1,64,12,13),(55,'Shipping Labels Generic','150x200 Generic Shipping Labels','','150x200-shipping-labels-generic.glabels',1,1,'shippingLabelsGeneric','2019-06-18 17:23:34','2019-12-09 16:55:58','20180419184037-shipping-label-generic180w.png','application/octet-stream',795,14639,'image/png',1,64,14,15),(56,'gLabels 200x150 Label Sample','200x150 gLabels Label Sample','','200x150GarlicButterBlend.glabels',1,1,'glabelSampleLabels','2019-06-18 17:41:25','2019-12-09 16:56:27','200x150glabels-sample-1.png','application/octet-stream',932,59486,'image/png',1,64,20,21),(57,'Crossdock Labels','150x200 Crossdock Label','','150x200-crossdock-labels.glabels',1,1,'crossdockLabels','2019-06-18 17:51:26','2019-12-09 16:56:11','crossdock_label.png','application/octet-stream',1073,112047,'image/png',1,64,16,17),(58,'Keep Refrigerated','100x50 Keep Refrigerated Label','','100x50custom2-1.glabels',1,0,'keepRefrigerated','2019-07-01 17:40:11','2019-12-09 16:54:37','100x50custom2-1.png','application/octet-stream',16255,16756,'image/png',1,NULL,33,34),(59,'Custom Print 0','100x50 FUTURE HARVEST','','100x50custom-1.glabels',1,0,'customPrint','2019-10-15 11:49:43','2019-12-09 16:55:08','toggen-custom-print0.png','application/octet-stream',28211,77248,'image/png',1,66,6,7),(61,'150x200 SSCC Glabels','150x200 SSCC Glabels Template - not used','','150x200-SSCC.glabels',1,0,'','2019-10-20 15:55:17','2019-10-26 09:25:01','150x200-SSCC-example-2.png','application/octet-stream',1117,184411,'image/png',1,64,18,19),(63,'150x200 CAB PCL Label Templates','150x200 CAB PCL Label Templates','',NULL,1,0,'','2019-10-21 13:19:02','2019-10-21 13:20:26',NULL,NULL,NULL,NULL,NULL,0,NULL,27,32),(64,'150x200 gLabels Custom Templates','150x200 gLabels Custom Templates','',NULL,1,0,'','2019-10-21 13:21:12','2019-10-21 14:26:16',NULL,NULL,NULL,NULL,NULL,1,NULL,11,22),(65,'Zebra Templates','Zebra Command Language Templates','',NULL,1,0,'','2019-10-21 13:23:21','2019-10-21 14:58:47',NULL,NULL,NULL,NULL,NULL,1,NULL,23,26),(66,'100x50 Labels','Assorted 100x50 Labels','',NULL,1,0,'','2019-10-21 14:46:36','2019-10-21 14:46:36',NULL,NULL,NULL,NULL,NULL,1,NULL,1,10);
/*!40000 ALTER TABLE `print_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `options` varchar(100) DEFAULT NULL,
  `queue_name` varchar(45) DEFAULT NULL,
  `set_as_default_on_these_actions` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` VALUES (4,1,'PDF Printer','','PDF','LabelsController::pallet_print\nLabelsController::reprint'),(5,1,'Virtual PDF','','VPDF','PrintLabelsController::printCartonLabels\nPrintLabelsController::cartonPrint\nPrintLabelsController::crossdockLabels\nPrintLabelsController::shippingLabels\nPrintLabelsController::shippingLabelsGeneric\nPrintLabelsController::keepRefrigerated\nPrintLabelsController::glabelSampleLabels\nPrintLabelsController::bigNumber\nPrintLabelsController::customPrint\nPrintLabelsController::sampleLabels');
/*!40000 ALTER TABLE `printers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_status_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `code_prefix` varchar(20) NOT NULL,
  `storage_temperature` varchar(20) NOT NULL,
  `code_regex` varchar(45) NOT NULL,
  `code_regex_description` varchar(100) NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `next_serial_number` int(11) DEFAULT NULL,
  `serial_number_format` varchar(45) DEFAULT NULL,
  `enable_pick_app` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (1,NULL,1,'Ambient','','Ambient','/^10\\d{3}$/','This code must start with a 10 and be 5 digits long',1,39,'A-%06d',0),(2,1,NULL,'Chilled','','Chilled','/^20\\d{3}$/','This chilled product code must start with a 20 and be 5 digits long',1,29,'C-%06d',1);
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_lines`
--

DROP TABLE IF EXISTS `production_lines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `production_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT NULL,
  `printer_id` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_lines`
--

LOCK TABLES `production_lines` WRITE;
/*!40000 ALTER TABLE `production_lines` DISABLE KEYS */;
INSERT INTO `production_lines` VALUES (1,NULL,4,'Ambient Line 1',1),(2,NULL,5,'Chilled Line 1',2),(3,NULL,4,'Ambient Line 2',1);
/*!40000 ALTER TABLE `production_lines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `setting` varchar(50) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (3,'sscc_ref','88','SSCC Reference number '),(4,'sscc_extension_digit','0','SSCC extension digit'),(5,'sscc_company_prefix','9999999','Added a bogus prefix'),(10,'companyName','The Toggen Partnership','This is used for the title attribute of pages and for anywhere the company name is needed (label headings)'),(13,'cooldown','48','Cooldown time in hours'),(24,'min_days_life','210','Specifies how many days life need to still be on the product before it is considered unshippable to customers'),(26,'shipping_label_total','70','This is for the total number of labels to appear in the drop down selects in the shipping_label view/action'),(29,'MaxShippingLabels','70',''),(30,'GLABELS_ROOT','files/templates',''),(35,'cabLabelTokens','Setting in comment','{\r\n    \"*COMPANY_NAME*\": \"companyName\",\r\n    \"*INT_CODE*\": \"internalProductCode\",\r\n    \"*REF*\": \"reference\",\r\n    \"*SSCC*\": \"sscc\",\r\n    \"*DESC*\": \"description\",\r\n    \"*GTIN14*\": \"gtin14\",\r\n    \"*QTY*\": \"quantity\",\r\n    \"*BB_HR*\": \"bestBeforeHr\",\r\n    \"*BB_BC*\": \"bestBeforeBc\",\r\n    \"*BATCH*\": \"batch\",\r\n    \"*NUM_LABELS*\": \"numLabels\"\r\n}'),(36,'cabCartonTemplateTokens','Setting in comment','{\r\n    \"*DESC*\": \"description\",\r\n    \"*GTIN14*\": \"gtin14\",\r\n    \"*NUM_LABELS*\": \"numLabels\"\r\n}'),(37,'PROXY_HOST','remote.toggen.com.au',''),(41,'bigNumberTemplateTokens','Setting in comment','{\r\n    \"*COMPANY_NAME*\": \"companyName\",\r\n    \"*OFFSET*\": \"offset\",\r\n    \"*NUMBER*\": \"number\",\r\n    \"*NUM_LABELS*\": \"quantity\"\r\n}'),(44,'custom_print_1','Setting in comment','{ \"code\": \"CUSTOM1\",\r\n  \"printer\": { \r\n    \"name\": \"PDF Printer\", \r\n    \"queue\":  \"PDF\" \r\n  },\r\n    \"image\": \"/files/templates/100x50custom2-1.png\",\r\n    \"description\": \"100x50 KEEP REFRIGERATED label\",\r\n    \"template\": \"files/templates/100x50custom2-1.glabels\"\r\n}'),(57,'custom_print_0','Setting in comment','{ \"code\": \"10000\",\r\n  \"printer\": { \r\n    \"name\": \"PDF Printer\", \r\n    \"queue\":  \"PDF\" ,\r\n   \"sample\": \"TEST\"\r\n  },\r\n    \"image\": \"/files/templates/toggen-custom-print0.png\",\r\n    \"description\": \"100x50 HARVEST AWARD 80% 10KG label\",\r\n    \"template\": \"files/templates/100x50custom-1.glabels\",\r\n    \"csv\": [\r\n        \"FUTURE  REWARD 80%\",\r\n        \"\",\r\n        \"Vegetable Oil (80%), Water, Salt, Milk Solids,\",\r\n        \"Emulsifiers (Soy 322,471), Preservative (202),\",\r\n        \"Food Acid (330), Natural Colour (β-Carotene), Flavour.\",\r\n        \"CONTAINS MILK & SOY PRODUCTS, AUSTRALIAN MADE.\",\r\n        \"Made by The Toggen Partnership\",\r\n        \"Website: http://toggen.com.au\",\r\n        \"10KG\"\r\n    ]\r\n}'),(58,'plRefMaxLength','8','Maximum length for a Pallet Reference'),(61,'DOCUMENTATION_ROOT','/docs/help',''),(62,'sscc_default_label_copies','2','Global default for SSCC Pallet Label Copies');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `shift_minutes` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `for_prod_dt` tinyint(1) NOT NULL,
  `start_time` time NOT NULL,
  `stop_time` time NOT NULL,
  `product_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
INSERT INTO `shifts` VALUES (1,'Ambient Day Shift',480,'Ambient Day Shift','2019-10-23 13:59:58','2019-10-23 13:59:58',1,0,'06:00:00','14:00:00',1),(2,'Ambient Afternoon Shift',480,'Ambient Afternoon Shift','2019-10-23 14:00:22','2019-10-23 14:00:22',1,0,'14:00:00','23:00:00',1),(3,'Ambient Night Shift',480,'Ambient Night Shift','2019-10-23 14:00:41','2019-10-23 14:00:41',1,0,'23:00:00','06:00:00',1),(4,'Chilled Day Shift',720,'Chilled Day Shift','2019-10-23 14:01:03','2019-10-23 14:01:03',1,0,'06:00:00','18:00:00',2),(5,'Chilled Night Shift',720,'Chilled Night Shift','2019-10-23 14:01:34','2019-10-23 14:01:34',1,0,'18:00:00','06:00:00',2);
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipments`
--

DROP TABLE IF EXISTS `shipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operator_id` int(11) NOT NULL,
  `truck_registration_id` int(11) NOT NULL,
  `shipper` varchar(30) NOT NULL,
  `con_note` varchar(50) NOT NULL,
  `shipment_type` varchar(20) NOT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `destination` varchar(250) NOT NULL,
  `pallet_count` int(11) NOT NULL,
  `shipped` tinyint(1) NOT NULL,
  `time_start` datetime DEFAULT NULL,
  `time_finish` datetime DEFAULT NULL,
  `time_total` int(11) DEFAULT NULL,
  `truck_temp` int(4) DEFAULT NULL,
  `dock_temp` int(4) DEFAULT NULL,
  `product_temp` int(4) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
INSERT INTO `shipments` VALUES (6,0,0,'AMBSHIPMENT1','','',1,'Bowral NSW Australia',4,1,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:40:47','2019-12-10 11:40:47'),(7,0,0,'CHILLEDSHIPMENT1','','',2,'Ringwood East, VIC',4,1,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:41:57','2019-12-10 11:41:57'),(8,0,0,'AMB2','','',1,'Fairfield Sydney, NSW, Australia',3,1,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:42:50','2019-12-10 11:42:50'),(9,0,0,'SHIP3','','',1,'Annandale Sydney, NSW',4,0,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:43:17','2019-12-10 11:43:17'),(10,0,0,'CHILLSHIP1','','',2,'Balmain Sydney, NSW Australia',1,0,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:43:49','2019-12-10 11:43:49'),(11,0,0,'ChillShip02','','',2,'Leichardt NSW Australia',3,0,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:44:21','2019-12-10 11:44:21'),(12,0,0,'Chill2','','',2,'Singleton NSW Australia',2,0,NULL,NULL,NULL,NULL,NULL,NULL,'2019-12-10 11:44:45','2019-12-10 11:44:45');
/*!40000 ALTER TABLE `shipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `full_name` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin','$2a$10$I4MNzMpU2AXM3uTIWRA4.e1qYhHGlTyiUlKUNWWcjplFCpXfxg9eK','admin','2016-08-31 14:20:04','2019-10-23 13:28:51','Admin User');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-10 13:33:16
