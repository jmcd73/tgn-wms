-- MySQL dump 10.13  Distrib 8.0.18, for macos10.14 (x86_64)
--
-- Host: localhost    Database: palletsUpgrade
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `help`
--

LOCK TABLES `help` WRITE;
/*!40000 ALTER TABLE `help` DISABLE KEYS */;
INSERT INTO `help` VALUES (1,'PalletsController::palletPrint','PALLET_PRINT.md'),(2,'ShipmentsController::addApp','ADD_APP.md'),(3,'ShipmentsController::index','DISPATCH_INDEX.md'),(4,'HelpController::index','HELP_INDEX.md'),(6,'PagesController::display','HOME.md'),(7,'SettingsController::index','SETTINGS.md'),(8,'MenusController::index','MENUS.md'),(9,'CartonsController::editPalletCartons','CARTONS.md');
/*!40000 ALTER TABLE `help` ENABLE KEYS */;
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
  `name` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `options` varchar(254) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
INSERT INTO `menus` VALUES (9,1,0,0,0,'Labels','Label Printing','#','','',NULL,15,28,'2016-08-31 19:41:20','2015-03-25 23:12:20','',''),(10,1,0,0,0,'Warehouse','Top Level Menu for Warehous','#','','',NULL,29,48,'2015-04-03 14:43:49','2015-03-25 23:12:39','',''),(12,1,0,0,0,'Reporting','Reporting top level menu','','','',NULL,1,6,'2016-08-31 18:48:30','2015-03-25 23:12:58','',''),(13,1,0,0,0,'Items','Item data view','array(\'controller\' => \'items\', \'action\' => \'index\')','','',100,8,9,'2019-10-15 18:19:06','2015-03-25 23:13:26','Items::index',''),(14,1,0,0,0,'Locations','Locations view','array(\'controller\' => \'locations\')','','',36,66,67,'2019-10-15 18:03:22','2015-03-25 23:14:23','Locations::index',''),(15,1,0,0,0,'Inventory Statuses','List Inventory Statuses','array(\'controller\' => \'inventoryStatuses\')','','List Inventory Statuses',36,62,63,'2019-10-15 18:05:00','2015-03-25 23:15:07','InventoryStatuses::index',''),(25,1,0,0,0,'Reprint','','array(\'controller\' => \'labels\', \'action\' => \'lookup\')','','Reprint Pallet Label',9,22,23,'2019-11-27 23:18:43','2015-03-26 06:16:27','Pallets::lookup',''),(28,1,0,0,0,'View Stock','','array(\'controller\' => \'labels\', \'action\' => \'onhand\')','','',10,32,33,'2019-11-27 22:07:18','2015-03-26 06:18:24','Pallets::onhand',''),(29,0,0,0,0,'Put-away','','','','',10,30,31,'2019-12-05 11:22:21','2015-03-26 06:18:45','Pallets::unassignedPallets',''),(30,1,0,0,0,'List','','array(\'controller\' => \'shipments\', \'action\' => \'index\')','array(\'title\' => \"View/Edit Shipments and Print Shippers\") ','View/Edit Shipments and Print Shippers',119,52,53,'2016-09-01 09:36:33','2015-03-26 06:19:14','Shipments::index',''),(36,1,0,0,1,'Admin','Admin Menu','#','','Admin Menu',NULL,59,88,'2018-09-05 12:55:10','2015-03-27 16:40:55','',''),(38,1,0,0,0,'Pallet Track','','array(\'controller\'=>\'labels\' , \'action\'=> \'lookup\')','array(\'title\' => \"Track a pallet\") ','Track a pallet',10,38,39,'2019-11-28 08:46:02','2015-03-27 16:55:25','Pallets::lookup',''),(39,1,0,0,0,'Settings','View Settings','array(\'controller\' => \'settings\')','','View and change configuration settings',36,80,81,'2018-09-05 13:06:22','2015-03-27 19:46:28','Settings::index',''),(46,1,0,0,0,'Menus','List Menus','array(\'controller\'=>\'menus\', \'action\'=>\'index\')','','',36,82,83,'2018-09-05 13:02:04','2015-03-28 23:08:36','Menus::index',''),(57,1,0,1,0,'Shipments','','#','','',119,50,51,'2016-09-01 09:36:23','2015-03-29 21:34:45','',''),(96,1,0,1,0,'Pallet Labels','Print Pallet Labels','#','array(\'title\'=> \"Pallet Labels\")','Pallet Labels',9,16,17,'2016-08-31 20:18:44','2015-10-21 09:57:23','',''),(99,1,0,0,0,'Custom Labels','Print a range of custom labels','#','array(\'title\'=> \"Print custom labels - for short or sample runs\")','Print custom labels - for short or sample runs',9,18,19,'2015-10-21 10:04:51','2015-10-21 10:04:51','',''),(100,1,0,0,0,'Data','Data Menu','#','array(\'title\'=> \"Item Data etc\");','Item Data etc',NULL,7,14,'2016-04-18 20:47:59','2016-04-18 20:47:59','',''),(101,1,0,0,0,'Day of Year','Check batch numbers','','','',100,12,13,'2019-12-04 19:42:17','2016-04-18 20:52:01','PrintLabels::dayOfYear',''),(108,1,0,0,0,'Users','List Users','array(\'controller\' => \'users\', \'action\' => \'index\')','','',36,60,61,'2018-09-05 13:04:23','2016-08-31 14:21:28','Users::index',''),(112,1,1,1,0,'Tracing','','','','',10,36,37,'2016-08-31 22:15:49','2016-08-31 22:15:28','',''),(119,1,0,0,0,'Dispatch','Dispatch Menu','','','Dispatch Menu',NULL,49,58,'2016-09-01 09:32:59','2016-09-01 09:32:47','',''),(121,1,1,1,0,'Utilities','Utilities','','','Utilities',100,10,11,'2016-09-01 10:12:02','2016-09-01 10:10:48','',''),(129,1,0,0,0,'Edit QA Status','Edit QA Status',NULL,'','',10,42,43,'2016-12-05 17:24:51','2016-12-05 17:09:10','Labels::bulkStatusRemove','3'),(130,1,1,1,0,'QA','QA',NULL,'','',10,40,41,'2016-12-05 17:24:32','2016-12-05 17:24:32','',''),(135,0,0,0,0,'Shift Report','Shift Report','','','',12,2,3,'2019-12-04 16:29:00','2017-04-07 22:22:10','Pallets::formatReport',''),(141,1,0,0,0,'Product Types','Product Types',NULL,'','',36,64,65,'2018-09-05 12:59:46','2018-09-05 12:59:46','ProductTypes::index',''),(142,1,0,0,1,'Shifts','Shifts',NULL,'','',36,68,69,'2018-09-05 13:00:42','2018-09-05 13:00:42','Shifts::index',''),(143,1,0,0,0,'Print Templates','Print Templates',NULL,'','',36,76,77,'2018-09-05 13:01:24','2018-09-05 13:01:24','PrintTemplates::index',''),(144,1,0,0,0,'Label Chooser','Label Chooser',NULL,'','Label Chooser',9,26,27,'2018-10-23 11:40:52','2018-10-23 11:40:52','PrintLabels::labelChooser',''),(145,1,1,1,0,'Custom Label Printing','Chooser',NULL,'','',9,24,25,'2019-06-18 22:27:35','2018-11-05 12:07:21','',''),(146,1,0,0,0,'Usage','View location utilization','','','Marg Location Usage',10,46,47,'2019-12-04 21:15:57','2018-12-10 10:24:45','Pallets::locationSpaceUsage',''),(147,0,0,0,0,'Pick Stock','Pick Stock','','','Pick Stock',119,56,57,'2019-11-28 08:45:00','2018-12-14 23:36:49','Shipments::pickStock',''),(148,0,1,1,0,'Pick','Pick','','','',119,54,55,'2019-11-28 08:44:39','2018-12-15 00:50:35','',''),(150,1,0,0,0,'Pack Sizes','Pack Sizes',NULL,'','Pack Sizes',36,70,71,'2019-10-15 17:35:22','2019-10-12 20:04:35','PackSizes::index',''),(152,1,0,0,0,'Print','Print Pallet Labels','','','Pallet Print',9,20,21,'2020-01-15 00:33:32','2019-10-12 21:41:15','Pallets::palletPrint','1'),(153,1,0,0,0,'Printers','',NULL,'','',36,74,75,'2019-10-15 17:34:35','2019-10-13 08:45:45','Printers::index',''),(155,1,0,0,0,'Production Lines','',NULL,'','',36,78,79,'2019-10-15 17:34:15','2019-10-13 08:50:06','ProductionLines::index',''),(157,1,0,0,1,'Help','Help System',NULL,'','',36,86,87,'2019-10-20 16:43:02','2019-10-20 16:42:43','Help::index',''),(158,1,0,0,1,'Items','Admin Menu Items',NULL,'','Items',36,72,73,'2019-10-23 12:13:08','2019-10-23 12:13:08','Items::index',''),(159,1,1,1,1,'Help','Help',NULL,'','Help',36,84,85,'2019-10-23 12:15:26','2019-10-23 12:15:26','',''),(161,1,0,0,0,'View Part-pallets and Cartons','View part pallets and multi-date pallets','','','',10,34,35,'2019-12-05 11:22:57','2019-11-30 15:02:47','Pallets::viewPartPalletsCartons',''),(162,1,0,0,0,'Shift Report','Shift Report with part pallets','','','',12,4,5,'2019-12-04 16:29:22','2019-12-02 16:59:44','Pallets::shiftReport',''),(163,1,1,1,0,'Locations','Locations','#','','',10,44,45,'2019-12-04 21:14:38','2019-12-04 21:14:38','','');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
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
  `is_file_template` int(1) DEFAULT '0',
  `print_action` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `example_image` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_template_size` int(11) DEFAULT NULL,
  `example_image_size` int(11) DEFAULT NULL,
  `example_image_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_in_label_chooser` tinyint(1) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `replace_tokens` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_templates`
--

LOCK TABLES `print_templates` WRITE;
/*!40000 ALTER TABLE `print_templates` DISABLE KEYS */;
INSERT INTO `print_templates` VALUES (2,'Default SSCC Pallet Label Template','150x200 label. Use this template if the qty is 2 digits','m m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 9,107,0,GS1-128,40,0.5;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'palletPrint','2017-07-24 13:24:42','2020-01-14 22:39:08','42fced7e-49c6-406f-bc39-3e491e32993c.jpeg',NULL,NULL,50138,'image/jpeg',0,63,28,29,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(3,'SSCC Template 3 Digit Qty','150x200 For any products with a 3 digit qty','m m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 12.5,107,0,GS1-128,40,0.45;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'palletPrint','2017-07-24 13:26:40','2020-01-14 22:39:21',NULL,NULL,NULL,NULL,NULL,0,63,30,31,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(4,'50060 4 Copies','150x200 Print 4 labels instead of the default 2','M l BMP;TOGGEN\r\n; TOGGEN is the name of the bitmap \r\n; loaded to the printer e.g. TOGGEN.BMP\r\nm m\r\n; measurement in mm\r\nJ 150 x 200 pallet label 4 copies marg\r\n; pallet label\r\nH 100\r\n; heat speed and printing method\r\nS l1;0,0,200,203,150\r\n; label size\r\nO R\r\n; print options\r\n; T 15,7,0,596,pt26;The Toggen Partnership\r\n; title heading\r\n;I:name;]x,y,r[,mx,my,GOODBADn][,a];name CR\r\n; Image \r\nI:LOGO;13,0,0,1,1,a;TOGGEN\r\n;G 3,10,0;L:144,.3\r\n; graphic line\r\n;T[:name;]x,y,r,font,size[,effects];text CR\r\nT 5,20,0,596,pt18;CODE\r\nT 20,32,0,596,pt70;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,52,0,596,pt72;*REF*\r\nT 5,62,0,596,pt18;SSCC\r\nT 23,62,0,596,pt24;*SSCC*\r\nT 5,71,0,3,pt24;*DESC*\r\nT 5,78,0,596,pt18;ITEM\r\nT 5,86,0,596,pt24;*GTIN14*\r\nT 110,78,0,596,pt18;QUANTITY\r\nT 125,86,0,596,pt24;*QTY*\r\nT 5,94,0,596,pt18;BEST BEFORE\r\nT 5,102,0,596,pt24;*BB_HR*\r\nT 120,94,0,596,pt18;BATCH\r\nT 110,102,0,596,pt24;*BATCH*\r\nG 3,104,0;L:144,.3\r\nB 9,107,0,GS1-128,40,0.5;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA 1',NULL,1,0,'palletPrint','2018-10-08 10:56:20','2020-01-14 22:39:29',NULL,NULL,NULL,NULL,NULL,0,63,32,33,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(5,'Carton Label','100x50 CAB Carton Label','m m\r\nJ 100 x 50 carton label\r\nH 100\r\nS l1;0,0,50,53,100\r\nO R\r\nT 6,4,0,596,pt16;*DESC*\r\nG 3,6,0;L:94,0.3\r\nB 8,8,0,GS1-128,38,0.56;(01)*GTIN14*\r\nA *NUM_LABELS*\r\n',NULL,1,0,'cartonPrint','2018-12-16 16:11:25','2020-01-13 16:32:17','100x50carton.png',NULL,NULL,12522,'image/png',1,66,16,17,'{ \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*NUM_LABELS*\": \"numLabels\" }'),(6,'Big Numbers','100x200 Big Number Zebra Printer Only','^XA\r\n^MD6.0\r\n\r\n^FXBig Number Shipping Label^FS\r\n^PON\r\n^FT0030,0080^A0N,065,070^FD*COMPANY_NAME*^FS\r\n^FO0030,0100^GB750,5,4^FS\r\n\r\n^FT*OFFSET*,1000^A0N,1000,500^FD*NUMBER*^FS\r\n\r\n^PQ*NUM_LABELS*,0,1,Y^XZ\r\n',NULL,1,0,'bigNumber','2018-12-16 16:12:20','2020-01-12 22:41:57','100x200-big_numbers-example.png',NULL,NULL,7389,'image/png',1,65,24,25,'{ \"*COMPANY_NAME*\": \"companyName\", \"*OFFSET*\": \"offset\", \"*NUMBER*\": \"number\", \"*NUM_LABELS*\": \"quantity\" }'),(52,'Assorted Custom Labels','100x50 50025, Keep Refrigerated Label','','100x50custom-1.glabels',1,1,'customPrint','2019-06-18 16:34:22','2019-12-07 19:24:02','harvest-award.png','application/octet-stream',16529,40520,'image/png',1,66,14,15,NULL),(53,'Sample Labels','100x50 Product Sample Labels','','100x50sample.glabels',1,1,'sampleLabels','2019-06-18 16:45:46','2019-12-04 14:35:12','100x50-100pbc-sample.png','application/octet-stream',11601,29950,'image/png',1,66,18,19,NULL),(54,'Shipping Labels','150x200 Shipping Labels','','150x200-shipping-labels-1.glabels',1,1,'shippingLabels','2019-06-18 17:01:44','2019-12-07 19:09:30','150x200-100pbc-shipping-label.png','application/octet-stream',6864,12993,'image/png',1,64,2,3,NULL),(55,'Shipping Labels Generic','150x200 Generic Shipping Labels','','150x200-shipping-labels-generic.glabels',1,1,'shippingLabelsGeneric','2019-06-18 17:23:34','2019-12-04 14:32:28','150x200-shipping-label-generic.png','application/octet-stream',795,14639,'image/png',1,64,4,5,NULL),(56,'gLabels 200x150 Garlic Blend Label','200x150 Garlic Blend Label','','200x150GarlicButterBlend-1.glabels',1,1,'glabelSampleLabels','2019-06-18 17:41:25','2019-12-07 19:12:45','200x150-100pbc-garlc-butter.png','application/octet-stream',932,89581,'image/png',1,64,6,7,NULL),(57,'Crossdock Labels','150x200 Crossdock Label','','150x200-crossdock-labels.glabels',1,1,'crossdockLabels','2019-06-18 17:51:26','2019-12-04 14:34:19','150x200-100pbc-crossdock-label.png','application/octet-stream',1073,77214,'image/png',1,64,8,9,NULL),(58,'Keep Refrigerated','100x50 Keep Refrigerated Label','','100x50custom2-1.glabels',1,0,'keepRefrigerated','2019-07-01 17:40:11','2019-12-04 14:35:26','100x50custom2-1.png','application/octet-stream',16255,16756,'image/png',1,66,20,21,NULL),(61,'150x200 SSCC Glabels','150x200 SSCC Glabels Template','','150x200-SSCC.glabels',1,0,'','2019-10-20 15:55:17','2019-12-03 08:49:17','150x200-SSCC-glabels.png','application/octet-stream',1117,93732,'image/png',1,64,10,11,NULL),(63,'150x200 CAB PCL Label Templates','150x200 CAB PCL Label Templates','',NULL,1,0,'','2019-10-21 13:19:02','2019-10-21 13:20:26',NULL,NULL,NULL,NULL,NULL,0,NULL,27,34,NULL),(64,'150x200 gLabels Custom Templates','150x200 gLabels Custom Templates','',NULL,1,0,'','2019-10-21 13:21:12','2019-10-21 14:26:16',NULL,NULL,NULL,NULL,NULL,1,NULL,1,12,NULL),(65,'Zebra Templates','Zebra Command Language Templates','',NULL,1,0,'','2019-10-21 13:23:21','2019-10-21 14:58:47',NULL,NULL,NULL,NULL,NULL,1,NULL,23,26,NULL),(66,'100x50 Labels','Assorted 100x50 Labels','',NULL,1,0,'','2019-10-21 14:46:36','2019-10-21 14:46:36',NULL,NULL,NULL,NULL,NULL,1,NULL,13,22,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` VALUES (1,1,'PDF Printer','','PDF','PalletsController::palletReprint\nPrintLabelsController::printCartonLabels\nPrintLabelsController::cartonPrint\nPrintLabelsController::crossdockLabels\nPrintLabelsController::shippingLabels\nPrintLabelsController::shippingLabelsGeneric\nPrintLabelsController::keepRefrigerated\nPrintLabelsController::glabelSampleLabels\nPrintLabelsController::bigNumber\nPrintLabelsController::customPrint\nPrintLabelsController::sampleLabels'),(2,1,'CAB Bottling','-o raw','cab-bottling',NULL),(3,1,'PDF-mailto Printer','','PDF-mailto',NULL);
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
  `active` tinyint(1) DEFAULT NULL,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_prefix` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_temperature` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int(11) DEFAULT NULL,
  `code_regex` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_regex_description` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `next_serial_number` int(11) DEFAULT NULL,
  `serial_number_format` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `enable_pick_app` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (1,NULL,1,'Oil','6','Chilled',449,'/^6\\d{4}$/','This code must start with a 6 and be 5 digits long',114111,'B%07d',0),(2,3,0,'Margarine','5','Chilled',NULL,'/^5\\d{4}$/','This code must start with a 5 and be 5 digits long',267401,'%08d',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_lines`
--

LOCK TABLES `production_lines` WRITE;
/*!40000 ALTER TABLE `production_lines` DISABLE KEYS */;
INSERT INTO `production_lines` VALUES (1,NULL,1,'Bottling',1),(2,NULL,1,'Mini Oil',1),(3,NULL,1,'Drumming',1),(4,NULL,1,'Bulk',2),(5,NULL,1,'Line 1',2),(6,NULL,1,'Line 2',2);
/*!40000 ALTER TABLE `production_lines` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-19 19:39:41
