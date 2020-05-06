-- MySQL dump 10.13  Distrib 8.0.18, for macos10.14 (x86_64)
--
-- Host: localhost    Database: tgnwmsdb
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cartons`
--

LOCK TABLES `cartons` WRITE;
/*!40000 ALTER TABLE `cartons` DISABLE KEYS */;
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
  `controller_action` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `markdown_document` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `controller_action_UNIQUE` (`controller_action`),
  KEY `tgn-UQ` (`controller_action`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help`
--

LOCK TABLES `help` WRITE;
/*!40000 ALTER TABLE `help` DISABLE KEYS */;
INSERT INTO `help` VALUES (1,'Pallets::palletPrint','PALLET_PRINT.md'),(2,'Shipments::addShipment','ADD_APP.md'),(3,'Shipments::index','DISPATCH_INDEX.md'),(4,'Help::index','HELP_INDEX.md'),(6,'Pages::display','HOME.md'),(7,'Settings::index','SETTINGS.md'),(8,'Menus::index','MENUS.md');
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
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `allow_bulk_status_change` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_statuses`
--

LOCK TABLES `inventory_statuses` WRITE;
/*!40000 ALTER TABLE `inventory_statuses` DISABLE KEYS */;
INSERT INTO `inventory_statuses` VALUES (1,13,'WAIT','Stops shipment and allows time for QA processes',1),(2,13,'HOLD','Status applied if QA finds a problem or needs to delay shipment',NULL),(3,12,'RETIPPED','Product produced but not useable, To be recycled or sent to waste',NULL);
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
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trade_unit` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pack_size_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `consumer_unit` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variant` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_net_contents` int(11) DEFAULT NULL,
  `unit_of_measure` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `days_life` int(11) DEFAULT NULL,
  `min_days_life` int(3) NOT NULL,
  `item_comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `pallet_template_id` int(11) NOT NULL,
  `carton_template_id` int(11) NOT NULL,
  `pallet_label_copies` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `item_wait_hrs` int(3) DEFAULT NULL COMMENT 'Wait hours is set at product type level but can be set to individual time per item or disabled with item_wait_hrs 0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
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
  `location` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pallet_capacity` int(11) NOT NULL,
  `is_hidden` tinyint(1) NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `product_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
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
  `admin_menu` tinyint(1) NOT NULL,
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `bs_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_args` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (9,1,0,0,'Labels','Label Printing',NULL,'',NULL,13,26,'2016-08-31 19:41:20','2015-03-25 23:12:20','',''),(10,1,0,0,'Warehouse','Top Level Menu for Warehous',NULL,'',NULL,27,44,'2015-04-03 14:43:49','2015-03-25 23:12:39','',''),(12,1,0,0,'Reporting','Reporting top level menu',NULL,'',NULL,1,4,'2016-08-31 18:48:30','2015-03-25 23:12:58','',''),(13,1,0,0,'Items','Item data view',NULL,'',100,6,7,'2019-10-15 18:19:06','2015-03-25 23:13:26','Items::index',''),(14,1,0,0,'Locations','Locations view',NULL,'',36,62,63,'2019-10-15 18:03:22','2015-03-25 23:14:23','Locations::index',''),(15,1,0,0,'Inventory Statuses','List Inventory Statuses',NULL,'List Inventory Statuses',36,58,59,'2019-10-15 18:05:00','2015-03-25 23:15:07','InventoryStatuses::index',''),(25,1,0,0,'Reprint','',NULL,'Reprint Pallet Label',9,20,21,'2020-04-02 04:51:35','2015-03-26 06:16:27','Pallets::lookup',''),(28,1,0,0,'View Stock','',NULL,'',10,30,31,'2020-04-03 21:49:00','2015-03-26 06:18:24','Pallets::onhand',''),(29,1,0,0,'Put-away','',NULL,'',10,28,29,'2019-12-09 16:53:47','2015-03-26 06:18:45','Pallets::unassignedPallets',''),(30,1,0,0,'List','',NULL,'View/Edit Shipments and Print Shippers',119,48,49,'2016-09-01 09:36:33','2015-03-26 06:19:14','Shipments::index',''),(36,1,0,1,'Admin','Admin Menu',NULL,'Admin Menu',NULL,55,84,'2018-09-05 12:55:10','2015-03-27 16:40:55','',''),(38,1,0,0,'Pallet Track','',NULL,'Track a pallet',10,38,39,'2020-04-03 02:34:46','2015-03-27 16:55:25','Pallets::lookup',''),(39,1,0,0,'Settings','View Settings',NULL,'View and change configuration settings',36,76,77,'2018-09-05 13:06:22','2015-03-27 19:46:28','Settings::index',''),(46,1,0,0,'Menus','List Menus',NULL,'',36,78,79,'2018-09-05 13:02:04','2015-03-28 23:08:36','Menus::index',''),(57,0,0,0,'Shipments','',NULL,'',119,46,47,'2016-09-01 09:36:23','2015-03-29 21:34:45','',''),(96,0,0,0,'Pallet Labels','Print Pallet Labels',NULL,'Pallet Labels',9,14,15,'2016-08-31 20:18:44','2015-10-21 09:57:23','',''),(99,0,0,0,'Custom Labels','Print a range of custom labels',NULL,'Print custom labels - for short or sample runs',9,16,17,'2015-10-21 10:04:51','2015-10-21 10:04:51','',''),(100,1,0,0,'Data','Data Menu',NULL,'Item Data etc',NULL,5,12,'2016-04-18 20:47:59','2016-04-18 20:47:59','',''),(101,1,0,0,'Day of Year','Day of Year Calculator',NULL,'Day of Year Number Calculator',100,10,11,'2020-04-02 03:34:22','2016-04-18 20:52:01','PrintLabels::dayOfYear','dayofyear'),(108,1,0,0,'Users','List Users',NULL,'',36,56,57,'2018-09-05 13:04:23','2016-08-31 14:21:28','Users::index',''),(112,0,1,0,'Tracing','',NULL,'',10,36,37,'2016-08-31 22:15:49','2016-08-31 22:15:28','',''),(119,1,0,0,'Dispatch','Dispatch Menu',NULL,'Dispatch Menu',NULL,45,54,'2016-09-01 09:32:59','2016-09-01 09:32:47','',''),(121,0,1,0,'Utilities','Utilities',NULL,'Utilities',100,8,9,'2016-09-01 10:12:02','2016-09-01 10:10:48','',''),(129,1,0,0,'Edit QA Status','Edit QA Status',NULL,'',10,42,43,'2020-04-04 11:39:13','2016-12-05 17:09:10','Pallets::bulkStatusRemove','3'),(130,0,1,0,'QA','QA',NULL,'',10,40,41,'2016-12-05 17:24:32','2016-12-05 17:24:32','',''),(135,1,0,0,'Shift Report','Shift Report',NULL,'',12,2,3,'2019-12-13 11:41:10','2017-04-07 22:22:10','Pallets::shiftReport',''),(141,1,0,0,'Product Types','Product Types',NULL,'',36,60,61,'2018-09-05 12:59:46','2018-09-05 12:59:46','ProductTypes::index',''),(142,1,0,1,'Shifts','Shifts',NULL,'',36,64,65,'2018-09-05 13:00:42','2018-09-05 13:00:42','Shifts::index',''),(143,1,0,0,'Print Templates','Print Templates',NULL,'',36,72,73,'2018-09-05 13:01:24','2018-09-05 13:01:24','PrintTemplates::index',''),(144,1,1,0,'Label Chooser','Label Chooser',NULL,'Label Chooser',9,24,25,'2020-04-02 22:20:50','2018-10-23 11:40:52','PrintLog::labelChooser',''),(145,0,1,0,'Custom Label Printing','Chooser',NULL,'',9,22,23,'2019-06-18 22:27:35','2018-11-05 12:07:21','',''),(146,1,0,0,'Location Usage','Location Usage',NULL,'Marg Location Usage',10,34,35,'2020-04-04 22:24:29','2018-12-10 10:24:45','Pallets::locationSpaceUsage',''),(147,1,0,0,'Pick Stock','Pick Stock',NULL,'Pick Stock',119,52,53,'2018-12-14 23:36:49','2018-12-14 23:36:49','Shipments::pickStock',''),(148,0,0,0,'Pick','Pick',NULL,'',119,50,51,'2018-12-15 00:51:57','2018-12-15 00:50:35','',''),(150,1,0,0,'Pack Sizes','Pack Sizes',NULL,'Pack Sizes',36,66,67,'2019-10-15 17:35:22','2019-10-12 20:04:35','PackSizes::index',''),(152,1,0,0,'Print SSCC','Pallet Print','','Pallet Print',9,18,19,'2020-04-05 20:29:23','2019-10-12 21:41:15','Pallets::palletPrint','1'),(153,1,0,0,'Printers','',NULL,'',36,70,71,'2019-10-15 17:34:35','2019-10-13 08:45:45','Printers::index',''),(155,1,0,0,'Production Lines','',NULL,'',36,74,75,'2019-10-15 17:34:15','2019-10-13 08:50:06','ProductionLines::index',''),(157,1,1,1,'Help','Help System','','',36,80,81,'2020-04-15 00:30:27','2019-10-20 16:42:43','Help::index',''),(158,1,0,1,'Items','Admin Menu Items',NULL,'Items',36,68,69,'2019-10-23 12:13:08','2019-10-23 12:13:08','Items::index',''),(159,0,1,1,'Help','Help',NULL,'Help',36,82,83,'2019-10-23 12:15:26','2019-10-23 12:15:26','',''),(160,1,0,0,'Mixed date / part pallets','','','View pallets with mixed carton dates or not full',10,32,33,'2020-04-08 23:47:02','2019-12-13 11:35:50','Pallets::viewPartPalletsCartons','');
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
  `pack_size` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pack_sizes`
--

LOCK TABLES `pack_sizes` WRITE;
/*!40000 ALTER TABLE `pack_sizes` DISABLE KEYS */;
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
  `item` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `best_before` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bb_date` date NOT NULL,
  `gtin14` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_user_id` int(11) NOT NULL,
  `qty` int(5) NOT NULL,
  `qty_previous` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty_modified` datetime NOT NULL,
  `pl_ref` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sscc` varchar(18) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `printer` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `printer_id` int(11) DEFAULT NULL,
  `print_date` datetime NOT NULL,
  `cooldown_date` datetime DEFAULT NULL,
  `min_days_life` int(11) NOT NULL,
  `production_line` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  `location_id` int(11) NOT NULL,
  `shipment_id` int(11) NOT NULL,
  `inventory_status_id` int(11) NOT NULL,
  `inventory_status_note` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pallets`
--

LOCK TABLES `pallets` WRITE;
/*!40000 ALTER TABLE `pallets` DISABLE KEYS */;
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
  `print_data` text COLLATE utf8mb4_unicode_ci,
  `controller_action` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_log`
--

LOCK TABLES `print_log` WRITE;
/*!40000 ALTER TABLE `print_log` DISABLE KEYS */;
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
  `name` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_template` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `is_file_template` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `example_image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template_size` int(11) DEFAULT NULL,
  `example_image_size` int(11) DEFAULT NULL,
  `example_image_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_in_label_chooser` tinyint(1) DEFAULT NULL,
  `controller_action` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `replace_tokens` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_templates`
--

LOCK TABLES `print_templates` WRITE;
/*!40000 ALTER TABLE `print_templates` DISABLE KEYS */;
INSERT INTO `print_templates` VALUES (2,'Default SSCC Pallet Label Template','150x200 label. Use this template if the qty is 2 digits','m m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 9,107,0,GS1-128,40,0.5;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'2017-07-24 13:24:42','2020-02-07 12:40:14','150x200-SSCC-example.png',NULL,NULL,184411,'image/png',0,NULL,63,28,29,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(3,'SSCC Template 3 Digit Qty','150x200 For any products with a 3 digit qty','m m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 12.5,107,0,GS1-128,40,0.45;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'2017-07-24 13:26:40','2020-02-07 12:40:20',NULL,NULL,NULL,NULL,NULL,0,NULL,63,30,31,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(5,'Carton Label','100x50 CAB Carton Label','m m\r\nJ 100 x 50 carton label\r\nH 100\r\nS l1;0,0,50,53,100\r\nO R\r\nT 6,4,0,596,pt16;*DESC*\r\nG 3,6,0;L:94,0.3\r\nB 8,8,0,GS1-128,38,0.56;(01)*GTIN14*\r\nA *NUM_LABELS*\r\n','',1,0,'2018-12-16 16:11:25','2020-04-17 14:55:28','100x50carton.png',NULL,NULL,12522,'image/png',1,'PrintLog::cartonPrint',66,2,3,'{ \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*NUM_LABELS*\": \"numLabels\" }'),(6,'Big Numbers','100x200 Big Number Zebra Printer Only','^XA\r\n^MD6.0\r\n\r\n^FXBig Number Shipping Label^FS\r\n^PON\r\n^FT0030,0080^A0N,065,070^FD*COMPANY_NAME*^FS\r\n^FO0030,0100^GB750,5,4^FS\r\n\r\n^FT*OFFSET*,1000^A0N,1000,500^FD*NUMBER*^FS\r\n\r\n^PQ*NUM_LABELS*,0,1,Y^XZ\r\n','',1,0,'2018-12-16 16:12:20','2020-04-17 15:03:46','100x200-big_numbers-example.png',NULL,NULL,7389,'image/png',1,'PrintLog::bigNumber',65,24,25,'{ \"*COMPANY_NAME*\": \"companyName\", \"*OFFSET*\": \"offset\", \"*NUMBER*\": \"number\", \"*NUM_LABELS*\": \"quantity\" }'),(53,'Sample Labels','100x50 Product Sample Labels','','100x50sample-1.glabels',1,1,'2019-06-18 16:45:46','2020-04-17 14:55:48','sample_label.png','application/octet-stream',11601,71644,'image/png',1,'PrintLog::sampleLabels',66,6,7,''),(54,'Shipping Labels','150x200 Shipping Labels','','150x200-shipping-labels.glabels',1,1,'2019-06-18 17:01:44','2020-04-17 14:56:42','150x200-shipping-label.png','application/octet-stream',6864,71992,'image/png',1,'PrintLog::shippingLabels',64,12,13,''),(55,'Shipping Labels Generic','150x200 Generic Shipping Labels','','150x200-shipping-labels-generic.glabels',1,1,'2019-06-18 17:23:34','2020-04-17 14:57:23','20180419184037-shipping-label-generic180w.png','application/octet-stream',795,14639,'image/png',1,'PrintLog::shippingLabelsGeneric',64,14,15,''),(56,'gLabels 200x150 Label Sample','200x150 gLabels Label Sample','','200x150-glabels-sample.glabels',1,1,'2019-06-18 17:41:25','2020-04-17 15:03:23','200x150glabels-sample-1.png','application/octet-stream',2592,59486,'image/png',1,'PrintLog::glabelSampleLabels',64,20,21,''),(57,'Crossdock Labels','150x200 Crossdock Label','','150x200-crossdock-labels.glabels',1,1,'2019-06-18 17:51:26','2020-04-17 14:57:39','crossdock_label.png','application/octet-stream',1073,112047,'image/png',1,'PrintLog::crossdockLabels',64,16,17,''),(58,'Keep Refrigerated','100x50 Keep Refrigerated Label','','100x50custom2-1.glabels',1,0,'2019-07-01 17:40:11','2020-04-17 14:56:05','100x50custom2-1.png','application/octet-stream',16255,16756,'image/png',1,'PrintLog::keepRefrigerated',66,8,9,''),(59,'Future Harvest 10KG','100x50 FUTURE HARVEST','\"FUTURE  REWARD 80%\",\"\",\"Vegetable Oil (80%), Water, Salt, Milk Solids,\",\"Emulsifiers (Soy 322,471), Preservative (202),\",\"Food Acid (330), Natural Colour (β-Carotene), Flavour.\",\"CONTAINS MILK & SOY PRODUCTS, AUSTRALIAN MADE.\",\"Made by The Toggen Partnership\",\"Website: http://toggen.com.au\",\"10KG\"','100x50-custom-print-0.glabels',1,1,'2019-10-15 11:49:43','2020-04-17 21:32:42','toggen-custom-print-0.png','application/octet-stream',23224,77248,'image/png',1,'PrintLog::customPrint',66,4,5,''),(61,'150x200 SSCC Glabels','150x200 SSCC Glabels Template','','150x200-SSCC.glabels',1,0,'2019-10-20 15:55:17','2020-04-17 15:30:48','150x200-SSCC-example-2.png','application/octet-stream',1117,184411,'image/png',1,'Pallets::lookup',64,18,19,''),(63,'150x200 CAB PCL Label Templates','150x200 CAB PCL Label Templates','',NULL,1,0,'2019-10-21 13:19:02','2019-10-21 13:20:26',NULL,NULL,NULL,NULL,NULL,0,NULL,NULL,27,32,NULL),(64,'150x200 gLabels Custom Templates','150x200 gLabels Custom Templates','',NULL,1,0,'2019-10-21 13:21:12','2019-10-21 14:26:16',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,11,22,NULL),(65,'Zebra Templates','Zebra Command Language Templates','',NULL,1,0,'2019-10-21 13:23:21','2019-10-21 14:58:47',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,23,26,NULL),(66,'100x50 Labels','Assorted 100x50 Labels','',NULL,1,0,'2019-10-21 14:46:36','2019-10-21 14:46:36',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,1,10,NULL);
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
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `queue_name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `set_as_default_on_these_actions` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` VALUES (4,1,'PDF Printer','','PDF','Pallets::palletPrint\nPallets::palletReprint\nPrintLog::printCartonLabels\nPrintLog::cartonPrint\nPrintLog::crossdockLabels\nPrintLog::shippingLabels\nPrintLog::shippingLabelsGeneric\nPrintLog::keepRefrigerated\nPrintLog::glabelSampleLabels\nPrintLog::bigNumber\nPrintLog::customPrint\nPrintLog::customPrint\nPrintLog::sampleLabels\nPrintLog::ssccLabel');
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
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_temperature` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_regex` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_regex_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `next_serial_number` int(11) DEFAULT NULL,
  `serial_number_format` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable_pick_app` tinyint(1) DEFAULT NULL,
  `wait_hrs` int(3) DEFAULT NULL COMMENT 'Time in hours to wait before allowing shipment',
  `enable_wait_hrs` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (1,NULL,1,'Ambient','Ambient','/^(10\\d{3})|(90\\d{3})$/','This code must start with a 10 and be 5 digits long',1,309,'A-%06d',0,NULL,NULL),(2,1,NULL,'Chilled','Chilled','/^20\\d{3}$/','This chilled product code must start with a 20 and be 5 digits long',1,148,'C-%06d',1,NULL,NULL);
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
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_lines`
--

LOCK TABLES `production_lines` WRITE;
/*!40000 ALTER TABLE `production_lines` DISABLE KEYS */;
INSERT INTO `production_lines` VALUES (1,1,4,'Ambient Line 1',1),(2,1,4,'Chilled Line 1',2),(3,1,4,'Ambient Line 2',1);
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
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (3,'sscc_ref','480','SSCC Reference number '),(4,'sscc_extension_digit','2','SSCC extension digit'),(5,'sscc_company_prefix','93529380','Added a bogus prefix'),(10,'companyName','The Toggen Partnership','This is used for the title attribute of pages and for anywhere the company name is needed (label headings)'),(13,'cooldown','48','Cooldown time in hours'),(24,'min_days_life','210','Specifies how many days life need to still be on the product before it is considered unshippable to customers'),(26,'shipping_label_total','70','This is for the total number of labels to appear in the drop down selects in the shipping_label view/action'),(29,'MaxShippingLabels','70',''),(30,'TEMPLATE_ROOT','files/templates',''),(35,'cabLabelTokens','Setting in comment','{\r\n    \"*COMPANY_NAME*\": \"companyName\",\r\n    \"*INT_CODE*\": \"internalProductCode\",\r\n    \"*REF*\": \"reference\",\r\n    \"*SSCC*\": \"sscc\",\r\n    \"*DESC*\": \"description\",\r\n    \"*GTIN14*\": \"gtin14\",\r\n    \"*QTY*\": \"quantity\",\r\n    \"*BB_HR*\": \"bestBeforeHr\",\r\n    \"*BB_BC*\": \"bestBeforeBc\",\r\n    \"*BATCH*\": \"batch\",\r\n    \"*NUM_LABELS*\": \"numLabels\"\r\n}'),(36,'cabCartonTemplateTokens','Setting in comment','{\r\n    \"*DESC*\": \"description\",\r\n    \"*GTIN14*\": \"gtin14\",\r\n    \"*NUM_LABELS*\": \"numLabels\"\r\n}'),(37,'PROXY_HOST','remote.toggen.com.au',''),(41,'bigNumberTemplateTokens','Setting in comment','{\r\n    \"*COMPANY_NAME*\": \"companyName\",\r\n    \"*OFFSET*\": \"offset\",\r\n    \"*NUMBER*\": \"number\",\r\n    \"*NUM_LABELS*\": \"quantity\"\r\n}'),(58,'plRefMaxLength','8','Maximum length for a Pallet Reference'),(61,'DOCUMENTATION_ROOT','/docs/help',''),(62,'sscc_default_label_copies','2','Global default for SSCC Pallet Label Copies'),(65,'3','116','');
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
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_minutes` int(11) NOT NULL,
  `comment` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `for_prod_dt` tinyint(1) NOT NULL,
  `start_time` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stop_time` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
  `shipper` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `con_note` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipment_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `destination` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipments`
--

LOCK TABLES `shipments` WRITE;
/*!40000 ALTER TABLE `shipments` DISABLE KEYS */;
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
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `full_name` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_superuser` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'admin@example.com','$2y$10$m4tV683xGq93gRRj4ZK7HOAcqybyM5qJrsxrAyVQj9ibXuZ9Ji2Iy','admin','2016-08-31 14:20:04','2020-04-17 22:51:31','Admin User','Australia/Melbourne',1),(4,1,'user@example.com','$2y$10$kidEyDQcpYaN3Qu28/ggeObF6hmi2F/Yio/u5gT96iDVe2r6A9JD.','user','2020-04-14 17:19:44','2020-04-17 22:51:52','User Role','Australia/Melbourne',NULL);
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

-- Dump completed on 2020-04-17 22:52:54
