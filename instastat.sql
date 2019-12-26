-- MySQL dump 10.17  Distrib 10.3.20-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: instastat
-- ------------------------------------------------------
-- Server version	10.3.20-MariaDB-0ubuntu0.19.04.1

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
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_users_name_uindex` (`name`),
  UNIQUE KEY `app_users_email_uindex` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (9,'иван','$2y$10$IWDFhgkacC76uBpHiNGtaeGjv2Z2/i.fQ6rXwniKfy7iu63zhAyFC','ivan701@mail.ru'),(12,'иван1','$2y$10$cagDaWjN4a6pu2TQEuhSPOLUCE6AceKR9Vg78Z8lcWq2j0BoZxnJi','ivan7011@mail.ru');
/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile_link`
--

DROP TABLE IF EXISTS `profile_link`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile_link` (
  `user_id` int(255) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  UNIQUE KEY `profile_link_user_id_name_link_uindex` (`user_id`,`account_name`),
  CONSTRAINT `profile_link_app_users_id_fk` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile_link`
--

LOCK TABLES `profile_link` WRITE;
/*!40000 ALTER TABLE `profile_link` DISABLE KEYS */;
INSERT INTO `profile_link` VALUES (NULL,'https://www.instagram.com/hatch95/',NULL),(NULL,'https://www.instagram.com/hatch95/',NULL),(NULL,'Array',NULL),(NULL,'/hatch95/',NULL),(NULL,'/hatch95/',NULL),(NULL,'/hatch95/',NULL),(NULL,'/hatch95/',NULL),(NULL,'/hatch95/',NULL),(NULL,'p/BmOTKmJHJnk',NULL);
/*!40000 ALTER TABLE `profile_link` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `settings` mediumblob DEFAULT NULL,
  `cookies` mediumblob DEFAULT NULL,
  `last_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sessions`
--

LOCK TABLES `user_sessions` WRITE;
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` VALUES (1,'ivanacadem92','{\"devicestring\":\"23\\/6.0.1; 640dpi; 1440x2560; samsung; SM-G930F; herolte; samsungexynos8890\",\"device_id\":\"android-95dbc697adbbc9f3\",\"phone_id\":\"41cc65f4-0a89-4ef6-bfda-53b4fcf0775d\",\"uuid\":\"1e9fd5f5-b80a-4598-97a7-9efb3469898f\",\"advertising_id\":\"0e7efc64-e7a8-4291-a14a-8d55dd3dd36e\",\"session_id\":\"fbf90d8f-0cfe-45ba-a21a-a343e1353613\",\"experiments\":\"J[]\",\"fbns_auth\":\"\",\"fbns_token\":\"\",\"last_fbns_token\":\"\",\"last_login\":\"1577363707\",\"last_experiments\":\"1577361474\",\"datacenter\":\"\",\"presence_disabled\":\"\",\"zr_token\":\"\",\"zr_expires\":\"1577433474\",\"zr_rules\":\"J[]\",\"account_id\":\"26782283295\"}','[{\"Name\":\"mid\",\"Value\":\"XgSgPAABAAGOSUJ65KceyA0mBWPR\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"315360000\",\"Expires\":1892721468,\"Secure\":true,\"Discard\":false,\"HttpOnly\":false},{\"Name\":\"ds_user\",\"Value\":\"ivanacadem92\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"7776000\",\"Expires\":1585137472,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true},{\"Name\":\"sessionid\",\"Value\":\"26782283295%3ANAlrgvZsHhoZDE%3A9\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"31536000\",\"Expires\":1608897472,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true},{\"Name\":\"rur\",\"Value\":\"FTW\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":null,\"Expires\":null,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true},{\"Name\":\"igfl\",\"Value\":\"ivanacadem92\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"86400\",\"Expires\":1577447875,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true},{\"Name\":\"is_starred_enabled\",\"Value\":\"yes\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"315360000\",\"Expires\":1892723702,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true},{\"Name\":\"ig_direct_region_hint\",\"Value\":\"ATN\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"604800\",\"Expires\":1577968506,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true},{\"Name\":\"csrftoken\",\"Value\":\"NKl0T8ipDcgusY9vKpFLgoRXCe8bDZf1\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"31449600\",\"Expires\":1608814307,\"Secure\":true,\"Discard\":false,\"HttpOnly\":false},{\"Name\":\"ds_user_id\",\"Value\":\"26782283295\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":\"7776000\",\"Expires\":1585140707,\"Secure\":true,\"Discard\":false,\"HttpOnly\":false},{\"Name\":\"urlgen\",\"Value\":\"\\\"{\\\\\\\"80.89.203.165\\\\\\\": 34757}:1ikScF:67xHiYX95fsnAYadwChXGVSgjKA\\\"\",\"Domain\":\".instagram.com\",\"Path\":\"\\/\",\"Max-Age\":null,\"Expires\":null,\"Secure\":true,\"Discard\":false,\"HttpOnly\":true}]','2019-12-26 12:59:28');
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-26 20:07:55
