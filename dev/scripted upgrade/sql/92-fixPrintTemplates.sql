-- MySQL dump 10.13  Distrib 8.0.18, for macos10.14 (x86_64)
--
-- Host: localhost    Database: palletsScriptedUpgradeTest
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
  `print_controller` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print_templates`
--

LOCK TABLES `print_templates` WRITE;
/*!40000 ALTER TABLE `print_templates` DISABLE KEYS */;
INSERT INTO `print_templates` VALUES (2,'Default SSCC Pallet Label Template','150x200 label. Use this template if the qty is 2 digits','m m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 9,107,0,GS1-128,40,0.5;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'','','2017-07-24 13:24:42','2020-01-20 17:09:29','42fced7e-49c6-406f-bc39-3e491e32993c.jpeg',NULL,NULL,50138,'image/jpeg',0,63,28,29,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(3,'SSCC Template 3 Digit Qty','150x200 For any products with a 3 digit qty','m m\r\nJ 150 x 200 pallet label\r\nH 100\r\nS l1;0,0,200,203,150\r\nO R\r\nT 15,7,0,596,pt26;*COMPANY_NAME*\r\nG 3,10,0;L:144,.3\r\nT 5,20,0,596,pt18;CODE\r\nT 20,30,0,596,pt72;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,50,0,596,pt72;*REF*\r\nT 5,60,0,596,pt18;SSCC\r\nT 23,60,0,596,pt24;*SSCC*\r\nT 5,69,0,3,pt24;*DESC*\r\nT 5,76,0,596,pt18;ITEM\r\nT 5,84,0,596,pt24;*GTIN14*\r\nT 110,76,0,596,pt18;QUANTITY\r\nT 125,84,0,596,pt24;*QTY*\r\nT 5,92,0,596,pt18;BEST BEFORE\r\nT 5,100,0,596,pt24;*BB_HR*\r\nT 120,92,0,596,pt18;BATCH\r\nT 110,100,0,596,pt24;*BATCH*\r\nG 3,103,0;L:144,.3\r\nB 12.5,107,0,GS1-128,40,0.45;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA *NUM_LABELS*',NULL,1,0,'','','2017-07-24 13:26:40','2020-01-20 17:09:47',NULL,NULL,NULL,NULL,NULL,0,63,30,31,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(4,'50060 4 Copies','150x200 Print 4 labels instead of the default 2','M l BMP;TOGGEN\r\n; TOGGEN is the name of the bitmap \r\n; loaded to the printer e.g. TOGGEN.BMP\r\nm m\r\n; measurement in mm\r\nJ 150 x 200 pallet label 4 copies marg\r\n; pallet label\r\nH 100\r\n; heat speed and printing method\r\nS l1;0,0,200,203,150\r\n; label size\r\nO R\r\n; print options\r\n; T 15,7,0,596,pt26;The Toggen Partnership\r\n; title heading\r\n;I:name;]x,y,r[,mx,my,GOODBADn][,a];name CR\r\n; Image \r\nI:LOGO;13,0,0,1,1,a;TOGGEN\r\n;G 3,10,0;L:144,.3\r\n; graphic line\r\n;T[:name;]x,y,r,font,size[,effects];text CR\r\nT 5,20,0,596,pt18;CODE\r\nT 20,32,0,596,pt70;*INT_CODE*\r\nT 5,40,0,596,pt18;REF\r\nT 20,52,0,596,pt72;*REF*\r\nT 5,62,0,596,pt18;SSCC\r\nT 23,62,0,596,pt24;*SSCC*\r\nT 5,71,0,3,pt24;*DESC*\r\nT 5,78,0,596,pt18;ITEM\r\nT 5,86,0,596,pt24;*GTIN14*\r\nT 110,78,0,596,pt18;QUANTITY\r\nT 125,86,0,596,pt24;*QTY*\r\nT 5,94,0,596,pt18;BEST BEFORE\r\nT 5,102,0,596,pt24;*BB_HR*\r\nT 120,94,0,596,pt18;BATCH\r\nT 110,102,0,596,pt24;*BATCH*\r\nG 3,104,0;L:144,.3\r\nB 9,107,0,GS1-128,40,0.5;(02)*GTIN14*(15)*BB_BC*(10)*BATCH*(37)*QTY*\r\nB 35,152,0,GS1-128,40,0.5;(00)*SSCC*\r\nA 1',NULL,1,0,'','','2018-10-08 10:56:20','2020-01-21 14:55:58',NULL,NULL,NULL,NULL,NULL,0,63,32,33,'{ \"*COMPANY_NAME*\": \"companyName\", \"*INT_CODE*\": \"internalProductCode\", \"*REF*\": \"reference\", \"*SSCC*\": \"sscc\", \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*QTY*\": \"quantity\", \"*BB_HR*\": \"bestBeforeHr\", \"*BB_BC*\": \"bestBeforeBc\", \"*BATCH*\": \"batch\", \"*NUM_LABELS*\": \"numLabels\" }'),(5,'Carton Label','100x50 CAB Carton Label','m m\r\nJ 100 x 50 carton label\r\nH 100\r\nS l1;0,0,50,53,100\r\nO R\r\nT 6,4,0,596,pt16;*DESC*\r\nG 3,6,0;L:94,0.3\r\nB 8,8,0,GS1-128,38,0.56;(01)*GTIN14*\r\nA *NUM_LABELS*\r\n',NULL,1,0,'cartonPrint','PrintLabels','2018-12-16 16:11:25','2020-01-13 16:32:17','100x50carton.png',NULL,NULL,12522,'image/png',1,66,8,9,'{ \"*DESC*\": \"description\", \"*GTIN14*\": \"gtin14\", \"*NUM_LABELS*\": \"numLabels\" }'),(6,'Big Numbers','100x200 Big Number Zebra Printer Only','^XA\r\n^MD6.0\r\n\r\n^FXBig Number Shipping Label^FS\r\n^PON\r\n^FT0030,0080^A0N,065,070^FD*COMPANY_NAME*^FS\r\n^FO0030,0100^GB750,5,4^FS\r\n\r\n^FT*OFFSET*,1000^A0N,1000,500^FD*NUMBER*^FS\r\n\r\n^PQ*NUM_LABELS*,0,1,Y^XZ\r\n',NULL,1,0,'bigNumber','PrintLabels','2018-12-16 16:12:20','2020-01-12 22:41:57','100x200-big_numbers-example.png',NULL,NULL,7389,'image/png',1,65,24,25,'{ \"*COMPANY_NAME*\": \"companyName\", \"*OFFSET*\": \"offset\", \"*NUMBER*\": \"number\", \"*NUM_LABELS*\": \"quantity\" }'),(52,'Assorted Custom Labels','100x50 50025, Keep Refrigerated Label','','100x50custom-1.glabels',1,1,'customPrint','PrintLabels','2019-06-18 16:34:22','2020-01-22 22:06:11','harvest-award.png','application/octet-stream',16529,40520,'image/png',1,66,2,3,''),(53,'Sample Labels','100x50 Product Sample Labels','','100x50sample.glabels',1,1,'sampleLabels','PrintLabels','2019-06-18 16:45:46','2019-12-04 14:35:12','100x50-100pbc-sample.png','application/octet-stream',11601,29950,'image/png',1,66,4,5,NULL),(54,'Shipping Labels','150x200 Shipping Labels','','150x200-shipping-labels-1.glabels',1,1,'shippingLabels','PrintLabels','2019-06-18 17:01:44','2019-12-07 19:09:30','150x200-100pbc-shipping-label.png','application/octet-stream',6864,12993,'image/png',1,64,12,13,NULL),(55,'Shipping Labels Generic','150x200 Generic Shipping Labels','','150x200-shipping-labels-generic.glabels',1,1,'shippingLabelsGeneric','PrintLabels','2019-06-18 17:23:34','2019-12-04 14:32:28','150x200-shipping-label-generic.png','application/octet-stream',795,14639,'image/png',1,64,14,15,NULL),(56,'gLabels 200x150 Garlic Blend Label','200x150 Garlic Blend Label','','200x150GarlicButterBlend-1.glabels',1,1,'glabelSampleLabels','PrintLabels','2019-06-18 17:41:25','2019-12-07 19:12:45','200x150-100pbc-garlc-butter.png','application/octet-stream',932,89581,'image/png',1,64,16,17,NULL),(57,'Crossdock Labels','150x200 Crossdock Label','','150x200-crossdock-labels.glabels',1,1,'crossdockLabels','PrintLabels','2019-06-18 17:51:26','2019-12-04 14:34:19','150x200-100pbc-crossdock-label.png','application/octet-stream',1073,77214,'image/png',1,64,18,19,NULL),(58,'Keep Refrigerated','100x50 Keep Refrigerated Label','','100x50custom2-1.glabels',1,0,'keepRefrigerated','PrintLabels','2019-07-01 17:40:11','2019-12-04 14:35:26','100x50custom2-1.png','application/octet-stream',16255,16756,'image/png',1,66,6,7,NULL),(61,'150x200 SSCC Glabels','150x200 SSCC Glabels Template','','150x200-SSCC.glabels',1,0,'lookup','Pallets','2019-10-20 15:55:17','2020-01-23 16:11:38','150x200-SSCC-glabels.png','application/octet-stream',1117,93732,'image/png',1,64,20,21,''),(63,'150x200 CAB PCL Label Templates','150x200 CAB PCL Label Templates','',NULL,1,0,'','','2019-10-21 13:19:02','2019-10-21 13:20:26',NULL,NULL,NULL,NULL,NULL,0,NULL,27,34,NULL),(64,'150x200 gLabels Custom Templates','150x200 gLabels Custom Templates','',NULL,1,0,'','','2019-10-21 13:21:12','2019-10-21 14:26:16',NULL,NULL,NULL,NULL,NULL,1,NULL,11,22,NULL),(65,'Zebra Templates','Zebra Command Language Templates','',NULL,1,0,'','','2019-10-21 13:23:21','2020-01-22 22:07:13',NULL,NULL,NULL,NULL,NULL,1,NULL,23,26,''),(66,'100x50 Labels','Assorted 100x50 Labels','',NULL,1,0,'','','2019-10-21 14:46:36','2019-10-21 14:46:36',NULL,NULL,NULL,NULL,NULL,1,NULL,1,10,NULL);
/*!40000 ALTER TABLE `print_templates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-23 20:04:19
