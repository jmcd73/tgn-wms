
-- Delete record first

DELETE FROM `settings` WHERE `name` = 'custom_print_0';


-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: host.docker.internal    Database: pallets1
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `settings`
--
-- WHERE:  name='custom_print_0'

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (22,'custom_print_0','This setting uses the comments section','{ \"code\": \"50025\",\r\n  \"printer\": { \r\n    \"name\": \"CAB Bottling\", \r\n    \"queue\":  \"cab-bottling\" \r\n  },\r\n    \"image\": \"/files/templates/harvest-award.png\",\r\n    \"description\": \"100x50 HARVEST AWARD 80% 10KG label\",\r\n    \"template\": \"/files/templates/100x50custom-1.glabels\",\r\n    \"csv\": [\r\n        \"HARVEST AWARD 80%\",\r\n        \"\",\r\n        \"Vegetable Oil (80%), Water, Salt, Milk Solids,\",\r\n        \"Emulsifiers (Soy 322,471), Preservative (202),\",\r\n        \"Food Acid (330), Natural Colour (β-Carotene), Flavour.\",\r\n        \"CONTAINS MILK & SOY PRODUCTS, AUSTRALIAN MADE.\",\r\n        \"Made by 100% Bottling Company\",\r\n        \"Website: http://www.100pbc.com.au\",\r\n        \"10KG\"\r\n    ]\r\n}');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-27  3:51:55
