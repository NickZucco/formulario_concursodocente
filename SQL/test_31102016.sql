CREATE DATABASE  IF NOT EXISTS `concursodocente_20161` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `concursodocente_20161`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: concursodocente_20161
-- ------------------------------------------------------
-- Server version	5.1.50-community

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
-- Table structure for table `areas_interes`
--

DROP TABLE IF EXISTS `areas_interes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `areas_interes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area` varchar(100) DEFAULT NULL,
  `posible_director` varchar(100) DEFAULT NULL,
  `fuente_financiacion` varchar(200) DEFAULT NULL,
  `comentarios` varchar(500) DEFAULT NULL,
  `aspirantes_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`aspirantes_id`),
  KEY `fk_areas_interes_aspirantes1_idx` (`aspirantes_id`),
  CONSTRAINT `fk_areas_interes_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `areas_interes`
--

LOCK TABLES `areas_interes` WRITE;
/*!40000 ALTER TABLE `areas_interes` DISABLE KEYS */;
/*!40000 ALTER TABLE `areas_interes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aspirantes`
--

DROP TABLE IF EXISTS `aspirantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aspirantes` (
  `id` int(11) NOT NULL,
  `programa_id` int(11) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `documento` varchar(45) DEFAULT NULL,
  `tipo_documento_id` int(11) DEFAULT NULL,
  `ciudad_expedicion_documento` varchar(130) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `pais_nacimiento` int(11) DEFAULT NULL,
  `estado_civil` varchar(45) DEFAULT NULL,
  `direccion_residencia` varchar(200) DEFAULT NULL,
  `telefonos` varchar(45) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `estados_civil_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aspirante_tipo_documento1_idx` (`tipo_documento_id`),
  KEY `fk_aspirantes_paises1_idx` (`pais_nacimiento`),
  KEY `fk_aspirantes_programas1_idx` (`programa_id`),
  KEY `fk_aspirantes_estados_civil1_idx` (`estados_civil_id`),
  CONSTRAINT `fk_aspirante_tipo_documento1` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipos_documento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aspirantes_paises1` FOREIGN KEY (`pais_nacimiento`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aspirantes_programas1` FOREIGN KEY (`programa_id`) REFERENCES `programas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aspirantes_estados_civil1` FOREIGN KEY (`estados_civil_id`) REFERENCES `estados_civil` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aspirantes`
--

LOCK TABLES `aspirantes` WRITE;
/*!40000 ALTER TABLE `aspirantes` DISABLE KEYS */;
INSERT INTO `aspirantes` VALUES (0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(1,NULL,'test','Hola test','1022959482',1,'Bogotá D.C.','2016-10-24',241,NULL,'KR 10 # 76-21','3057087907','flramirezs@unal.edu.co','2016-10-24 21:06:48','2016-10-24 21:06:48',2);
/*!40000 ALTER TABLE `aspirantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aspirantes_perfiles`
--

DROP TABLE IF EXISTS `aspirantes_perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aspirantes_perfiles` (
  `aspirantes_id` int(11) NOT NULL,
  `perfiles_id` int(11) NOT NULL,
  KEY `fk_aspirantes_perfiles_aspirantes1_idx` (`aspirantes_id`),
  KEY `fk_aspirantes_perfiles_perfiles1_idx` (`perfiles_id`),
  CONSTRAINT `fk_aspirantes_perfiles_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_aspirantes_perfiles_perfiles1` FOREIGN KEY (`perfiles_id`) REFERENCES `perfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aspirantes_perfiles`
--

LOCK TABLES `aspirantes_perfiles` WRITE;
/*!40000 ALTER TABLE `aspirantes_perfiles` DISABLE KEYS */;
INSERT INTO `aspirantes_perfiles` VALUES (1,16),(1,18),(1,19),(1,16),(1,18),(1,19),(1,2),(1,4);
/*!40000 ALTER TABLE `aspirantes_perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `configuraciones`
--

DROP TABLE IF EXISTS `configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuraciones` (
  `id` int(11) NOT NULL,
  `llave` varchar(32) DEFAULT NULL,
  `valor` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `configuraciones`
--

LOCK TABLES `configuraciones` WRITE;
/*!40000 ALTER TABLE `configuraciones` DISABLE KEYS */;
INSERT INTO `configuraciones` VALUES (1,'limit_date','2016-10-30');
/*!40000 ALTER TABLE `configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `distinciones_academica`
--

DROP TABLE IF EXISTS `distinciones_academica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `distinciones_academica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `institucion` varchar(200) DEFAULT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `aspirantes_id` int(11) DEFAULT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_distinciones_academicas_aspirantes1_idx` (`aspirantes_id`),
  CONSTRAINT `fk_distinciones_academicas_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `distinciones_academica`
--

LOCK TABLES `distinciones_academica` WRITE;
/*!40000 ALTER TABLE `distinciones_academica` DISABLE KEYS */;
/*!40000 ALTER TABLE `distinciones_academica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estados_civil`
--

DROP TABLE IF EXISTS `estados_civil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estados_civil` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estados_civil`
--

LOCK TABLES `estados_civil` WRITE;
/*!40000 ALTER TABLE `estados_civil` DISABLE KEYS */;
INSERT INTO `estados_civil` VALUES (1,'Sotero/a'),(2,'Casado/a'),(3,'Viudo/a'),(4,'Unión libre');
/*!40000 ALTER TABLE `estados_civil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudios`
--

DROP TABLE IF EXISTS `estudios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) DEFAULT NULL COMMENT '	',
  `institucion` varchar(250) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_finalizacion` date DEFAULT NULL,
  `en_curso` int(11) DEFAULT NULL,
  `promedio` float DEFAULT NULL,
  `minimo_aprobatorio` float DEFAULT NULL,
  `maximo_escala` float DEFAULT NULL,
  `aspirantes_id` int(11) DEFAULT NULL,
  `paises_id` int(11) NOT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_estudios_aspirantes1_idx` (`aspirantes_id`),
  KEY `fk_estudios_paises1_idx` (`paises_id`),
  CONSTRAINT `fk_estudios_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_estudios_paises1` FOREIGN KEY (`paises_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudios`
--

LOCK TABLES `estudios` WRITE;
/*!40000 ALTER TABLE `estudios` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencias_docente`
--

DROP TABLE IF EXISTS `experiencias_docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiencias_docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_institucion` varchar(200) DEFAULT NULL,
  `dedicacion` int(11) NOT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `area_trabajo` varchar(500) DEFAULT NULL,
  `nombre_asignaturas` varchar(200) DEFAULT NULL,
  `programa_academico` varchar(100) DEFAULT NULL,
  `niveles_id` int(11) NOT NULL,
  `aspirantes_id` int(11) DEFAULT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_experiencias_docente_tipos_vinculacion_docente1_idx` (`dedicacion`),
  KEY `fk_experiencias_docente_niveles1_idx` (`niveles_id`),
  KEY `fk_experiencias_docente_aspirantes1_idx` (`aspirantes_id`),
  CONSTRAINT `fk_experiencias_docente_tipos_vinculacion_docente1` FOREIGN KEY (`dedicacion`) REFERENCES `tipos_vinculacion_docente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_experiencias_docente_niveles1` FOREIGN KEY (`niveles_id`) REFERENCES `niveles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_experiencias_docente_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencias_docente`
--

LOCK TABLES `experiencias_docente` WRITE;
/*!40000 ALTER TABLE `experiencias_docente` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencias_docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencias_investigativa`
--

DROP TABLE IF EXISTS `experiencias_investigativa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiencias_investigativa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_proyecto` varchar(200) DEFAULT NULL,
  `area_proyecto` varchar(100) DEFAULT NULL,
  `funcion_principal` varchar(200) DEFAULT NULL,
  `entidad_financiadora` varchar(100) DEFAULT NULL,
  `estado_proyecto` varchar(10) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `paises_id` int(11) NOT NULL,
  `aspirantes_id` int(11) NOT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_experiencias_investigativa_paises1_idx` (`paises_id`),
  KEY `fk_experiencias_investigativa_aspirantes1_idx` (`aspirantes_id`),
  CONSTRAINT `fk_experiencias_investigativa_paises1` FOREIGN KEY (`paises_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_experiencias_investigativa_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencias_investigativa`
--

LOCK TABLES `experiencias_investigativa` WRITE;
/*!40000 ALTER TABLE `experiencias_investigativa` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencias_investigativa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiencias_laboral`
--

DROP TABLE IF EXISTS `experiencias_laboral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `experiencias_laboral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_institucion` varchar(200) DEFAULT NULL,
  `desde` date DEFAULT NULL,
  `hasta` date DEFAULT NULL,
  `nombre_cargo` varchar(100) DEFAULT NULL,
  `funcion_principal` varchar(500) DEFAULT NULL,
  `tipos_vinculacion_laboral_id` int(11) NOT NULL,
  `aspirantes_id` int(11) NOT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_experiencias_tipos_vinculacion_laboral1_idx` (`tipos_vinculacion_laboral_id`),
  KEY `fk_experiencias_laboral_aspirantes1_idx` (`aspirantes_id`),
  CONSTRAINT `fk_experiencias_tipos_vinculacion_laboral1` FOREIGN KEY (`tipos_vinculacion_laboral_id`) REFERENCES `tipos_vinculacion_laboral` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_experiencias_laboral_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiencias_laboral`
--

LOCK TABLES `experiencias_laboral` WRITE;
/*!40000 ALTER TABLE `experiencias_laboral` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiencias_laboral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idiomas`
--

DROP TABLE IF EXISTS `idiomas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idiomas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idiomas`
--

LOCK TABLES `idiomas` WRITE;
/*!40000 ALTER TABLE `idiomas` DISABLE KEYS */;
INSERT INTO `idiomas` VALUES (1,'Español'),(2,'Ingles'),(3,'Portugues'),(4,'Frances'),(5,'Alemán'),(6,'Ruso'),(7,'Japones'),(8,'Árabe'),(9,'Chino Mandarín'),(10,'Italiano');
/*!40000 ALTER TABLE `idiomas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idiomas_certificado`
--

DROP TABLE IF EXISTS `idiomas_certificado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idiomas_certificado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_certificado` varchar(45) DEFAULT NULL,
  `aspirantes_id` int(11) NOT NULL,
  `idiomas_id` int(11) NOT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_idiomas_certificado_aspirantes1_idx` (`aspirantes_id`),
  KEY `fk_idiomas_certificado_idiomas1_idx` (`idiomas_id`),
  CONSTRAINT `fk_idiomas_certificado_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_idiomas_certificado_idiomas1` FOREIGN KEY (`idiomas_id`) REFERENCES `idiomas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idiomas_certificado`
--

LOCK TABLES `idiomas_certificado` WRITE;
/*!40000 ALTER TABLE `idiomas_certificado` DISABLE KEYS */;
/*!40000 ALTER TABLE `idiomas_certificado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `niveles`
--

DROP TABLE IF EXISTS `niveles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `niveles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `tiponiveles_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_niveles_tiponiveles1_idx` (`tiponiveles_id`),
  CONSTRAINT `fk_niveles_tiponiveles1` FOREIGN KEY (`tiponiveles_id`) REFERENCES `tiponiveles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveles`
--

LOCK TABLES `niveles` WRITE;
/*!40000 ALTER TABLE `niveles` DISABLE KEYS */;
INSERT INTO `niveles` VALUES (1,'PREGRADO',1),(2,'ESPECIALIZACIÓN',2),(3,'MAESTRÍA',2),(4,'DOCTORADO',2);
/*!40000 ALTER TABLE `niveles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1,'Afghanistan'),(2,'Albania'),(3,'Algeria'),(4,'American Samoa'),(5,'Andorra'),(6,'Angola'),(7,'Anguilla'),(8,'Antarctica'),(9,'Antigua and Barbuda'),(10,'Argentina'),(11,'Armenia'),(12,'Aruba'),(13,'Australia'),(14,'Austria'),(15,'Azerbaijan'),(16,'Bahamas'),(17,'Bahrain'),(18,'Bangladesh'),(19,'Barbados'),(20,'Belarus'),(21,'Belgium'),(22,'Belize'),(23,'Benin'),(24,'Bermuda'),(25,'Bhutan'),(26,'Bolivia'),(27,'Bosnia and Herzegovina'),(28,'Botswana'),(29,'Bouvet Island'),(30,'Brazil'),(31,'British Indian Ocean Territory'),(32,'Brunei Darussalam'),(33,'Bulgaria'),(34,'Burkina Faso'),(35,'Burundi'),(36,'Cambodia'),(37,'Cameroon'),(38,'Canada'),(39,'Cape Verde'),(40,'Cayman Islands'),(41,'Central African Republic'),(42,'Chad'),(43,'Chile'),(44,'China'),(45,'Christmas Island'),(46,'Cocos (Keeling) Islands'),(48,'Comoros'),(49,'Congo'),(50,'Congo, The Democratic Republic Of The'),(51,'Cook Islands'),(52,'Costa Rica'),(53,'Croatia'),(54,'Cuba'),(55,'Cyprus'),(56,'Czech Republic'),(57,'CÃ´te d Ivoire'),(58,'Denmark'),(59,'Djibouti'),(60,'Dominica'),(61,'Dominican Republic'),(62,'Ecuador'),(63,'Egypt'),(64,'El Salvador'),(65,'Equatorial Guinea'),(66,'Eritrea'),(67,'Estonia'),(68,'Ethiopia'),(69,'Falkland Islands (Malvinas)'),(70,'Faroe Islands'),(71,'Fiji'),(72,'Finland'),(73,'France'),(74,'French Guiana'),(75,'French Polynesia'),(76,'French Southern Territories'),(77,'Gabon'),(78,'Gambia'),(79,'Georgia'),(80,'Germany'),(81,'Ghana'),(82,'Gibraltar'),(83,'Greece'),(84,'Greenland'),(85,'Grenada'),(86,'Guadeloupe'),(87,'Guam'),(88,'Guatemala'),(89,'Guinea'),(90,'Guinea-Bissau'),(91,'Guyana'),(92,'Haiti'),(93,'Heard Island and McDonald Islands'),(94,'Holy See (Vatican City State)'),(95,'Honduras'),(96,'Hong Kong'),(97,'Hungary'),(98,'Iceland'),(99,'India'),(100,'Indonesia'),(101,'Iran, Islamic Republic Of'),(102,'Iraq'),(103,'Ireland'),(104,'Israel'),(105,'Italy'),(106,'Jamaica'),(107,'Japan'),(108,'Jordan'),(109,'Kazakhstan'),(110,'Kenya'),(111,'Kiribati'),(112,'Korea, Democratic Peoples Republic Of'),(113,'Korea, Republic Of'),(114,'Kuwait'),(115,'Kyrgyzstan'),(116,'Lao People s Democratic Republic'),(117,'Latvia'),(118,'Lebanon'),(119,'Lesotho'),(120,'Liberia'),(121,'Libyan Arab Jamahiriya'),(122,'Liechtenstein'),(123,'Lithuania'),(124,'Luxembourg'),(125,'Macao'),(126,'Macedonia, The Former Yugoslav Republic Of'),(127,'Madagascar'),(128,'Malawi'),(129,'Malaysia'),(130,'Maldives'),(131,'Mali'),(132,'Malta'),(133,'Marshall Islands'),(134,'Martinique'),(135,'Mauritania'),(136,'Mauritius'),(137,'Mayotte'),(138,'Mexico'),(139,'Micronesia, Federated States Of'),(140,'Moldova, Republic Of'),(141,'Monaco'),(142,'Mongolia'),(143,'Montserrat'),(144,'Morocco'),(145,'Mozambique'),(146,'Myanmar'),(147,'Namibia'),(148,'Nauru'),(149,'Nepal'),(150,'Netherlands'),(151,'Netherlands Antilles'),(152,'New Caledonia'),(153,'New Zealand'),(154,'Nicaragua'),(155,'Niger'),(156,'Nigeria'),(157,'Niue'),(158,'Norfolk Island'),(159,'Northern Mariana Islands'),(160,'Norway'),(161,'Oman'),(162,'Pakistan'),(163,'Palau'),(164,'Palestinian Territory, Occupied'),(165,'Panama'),(166,'Papua New Guinea'),(167,'Paraguay'),(168,'Peru'),(169,'Philippines'),(170,'Pitcairn'),(171,'Poland'),(172,'Portugal'),(173,'Puerto Rico'),(174,'Qatar'),(175,'Reunion'),(176,'Romania'),(177,'Russian Federation'),(178,'Rwanda'),(179,'Saint Helena'),(180,'Saint Kitts and Nevis'),(181,'Saint Lucia'),(182,'Saint Pierre and Miquelon'),(183,'Saint Vincent and the Grenadines'),(184,'Samoa'),(185,'San Marino'),(186,'Sao Tome and Principe'),(187,'Saudi Arabia'),(188,'Senegal'),(189,'Serbia and Montenegro'),(190,'Seychelles'),(191,'Sierra Leone'),(192,'Singapore'),(193,'Slovakia'),(194,'Slovenia'),(195,'Solomon Islands'),(196,'Somalia'),(197,'South Africa'),(198,'South Georgia and the South Sandwich Islands'),(199,'Spain'),(200,'Sri Lanka'),(201,'Sudan'),(202,'Suriname'),(203,'Svalbard and Jan Mayen'),(204,'Swaziland'),(205,'Sweden'),(206,'Switzerland'),(207,'Syrian Arab Republic'),(208,'Taiwan, Province of China'),(209,'Tajikistan'),(210,'Tanzania, United Republic Of'),(211,'Thailand'),(212,'Timor-Leste'),(213,'Togo'),(214,'Tokelau'),(215,'Tonga'),(216,'Trinidad and Tobago'),(217,'Tunisia'),(218,'Turkey'),(219,'Turkmenistan'),(220,'Turks and Caicos Islands'),(221,'Tuvalu'),(222,'Uganda'),(223,'Ukraine'),(224,'United Arab Emirates'),(225,'United Kingdom'),(226,'United States'),(227,'United States Minor Outlying Islands'),(228,'Uruguay'),(229,'Uzbekistan'),(230,'Vanuatu'),(231,'Venezuela'),(232,'Viet Nam'),(233,'Virgin Islands, British'),(234,'Virgin Islands, U.S.'),(235,'Wallis and Futuna'),(236,'Western Sahara'),(237,'Yemen'),(238,'Zambia'),(239,'Zimbabwe'),(240,'Ã…land Islands'),(241,'Colombia');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles`
--

DROP TABLE IF EXISTS `perfiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfiles` (
  `id` int(11) NOT NULL,
  `identificador` varchar(4) DEFAULT NULL,
  `dedicacion` varchar(45) DEFAULT NULL,
  `cargos` int(11) DEFAULT NULL,
  `area_desempeno` varchar(45) DEFAULT NULL,
  `requisitos_posgrado` varchar(5000) DEFAULT NULL,
  `requisitos_experiencia` varchar(5000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles`
--

LOCK TABLES `perfiles` WRITE;
/*!40000 ALTER TABLE `perfiles` DISABLE KEYS */;
INSERT INTO `perfiles` VALUES (1,'C21','Cátedra 0.2',1,'Seguridad vial o infraestructura o tránsito o','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño','Mínimo dos (2) años en el área de desempeño. Si tiene doctorado no es necesario acreditar experiencia.'),(2,'C22','Cátedra 0.2',1,'Acueductos -  alcantarillados -  saneamiento','Ingeniero civil o ingeniero sanitario o ingeniero ambiental o ingeniero químico.','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(3,'C23','Cátedra 0.2',1,'Geotecnia - Modelación numérica en geotecnia','Ingeniero Civil o Geólogo o Ingeniero Geólogo','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(4,'C24','Cátedra 0.2',1,'Estructuras o construcción','Ingeniero agrícola o ingeniero civil','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(5,'C31','Cátedra 0.3',1,'Estructuras hidráulicas','Ingeniero civil o ingeniero agrícola o ingeniero de construcción','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(6,'C32','Cátedra 0.3',3,'Acueductos o alcantarillados o saneamiento','Ingeniero civil o ingeniero sanitario o ingeniero ambiental o ingeniero químico.','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(7,'C33','Cátedra 0.3',1,'Saneamiento o salud pública','Ingeniero civil o ingeniero sanitario o ingeniero ambiental o ingeniero químico.','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(8,'C34','Cátedra 0.3',1,'Geología o Geotecnia','Geólogo o Ingeniero geólogo o Ingeniero de minas','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(9,'C35','Cátedra 0.3',1,'Topografía o Geomática','Ingeniero catastral o ingeniero geodesta o ingeniero civil o ingeniero topográfico o ingeniero de transporte y vías o ingeniero agrícola','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(10,'C41','Cátedra 0.4',1,'Diseño sismo resistente o ingeniería sísmica','Ingeniero civil','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(11,'TC1','Tiempo completo',1,'Estructuras o construcción','Ingeniero agrícola o ingeniero civil','Maestría o doctorado en Ingeniería o Maestría o doctorado en el área de desempeño'),(12,'D1','Dedicación exclusiva',1,'Modelación matemática en hidráulica o modelac','Ingeniero civil o ingeniero agrícola o ingeniero de recursos hídricos o ingeniero ambiental','Doctorado en Ingeniería o Doctorado en el área de desempeño.'),(13,'D2','Dedicación exclusiva',1,'Acueductos o alcantarillados o saneamiento o ','Ingeniero civil o ingeniero agrícola o ingeniero de recursos hídricos o ingeniero ambiental o ingeniero sanitario','Doctorado en Ingeniería o Doctorado en el área de desempeño.'),(14,'C36','Cátedra 0.3',1,'Control y Gestión de Calidad','Ingeniería industrial','Maestría o Doctorado en Ingeniería o Maestría o Doctorado en el área de desempeño'),(15,'C37','Cátedra 0.3',1,'Modelos Computacionales para Ingeniería Indus','Ingeniería Industrial','Maestría o Doctorado en Ingeniería o Maestría o Doctorado en el área de desempeño'),(16,'C25','Cátedra 0.2',1,'Materiales o Procesos Industriales','Ingeniería','Maestría o Doctorado en Ingeniería o Maestría o Doctorado en el área de desempeño'),(17,'C42','Cátedra 0.4',1,'Dibujo Técnico o Expresión Gráfica o Geometrí','Ingeniero Mecánico o ingeniero mecatrónico o ingeniero electromecánico o ingeniero civil o ingeniero agrícola','Maestría en Ingeniería.'),(18,'TC2','Tiempo Completo',1,'Dinámica de maquinaria y vibraciones  o Diseñ','Ingeniero Mecánico o Ingeniero Mecatrónico o Ingeniero Electromecánico o Ingeniero Aeronáutico o Ingeniero Naval','Doctorado en Ingeniería o Doctorado en el área de desempeño'),(19,'D3','Dedicación Exclusiva',1,'Conformación volumétrica de materiales o Sínt','Ingeniero Mecánico o Ingeniero Mecatrónico o ingeniero de Materiales o ingeniero Metalúrgico o físico o químico o ingeniero físico o ingeniero químico','Doctorado en Ingeniería o Doctorado en el área de desempeño');
/*!40000 ALTER TABLE `perfiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perfiles_programas_pregrado`
--

DROP TABLE IF EXISTS `perfiles_programas_pregrado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfiles_programas_pregrado` (
  `perfiles_id` int(11) NOT NULL,
  `programas_pregrado_id` int(11) NOT NULL,
  KEY `fk_perfiles_has_programas_pregrado_programas_pregrado1_idx` (`programas_pregrado_id`),
  KEY `fk_perfiles_has_programas_pregrado_perfiles1_idx` (`perfiles_id`),
  CONSTRAINT `fk_perfiles_has_programas_pregrado_perfiles1` FOREIGN KEY (`perfiles_id`) REFERENCES `perfiles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_perfiles_has_programas_pregrado_programas_pregrado1` FOREIGN KEY (`programas_pregrado_id`) REFERENCES `programas_pregrado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfiles_programas_pregrado`
--

LOCK TABLES `perfiles_programas_pregrado` WRITE;
/*!40000 ALTER TABLE `perfiles_programas_pregrado` DISABLE KEYS */;
INSERT INTO `perfiles_programas_pregrado` VALUES (3,2),(8,2),(9,1),(19,3),(18,4),(16,4),(4,5),(5,5),(9,5),(11,5),(12,5),(13,5),(16,5),(17,5),(16,6),(13,6),(2,6),(6,6),(7,6),(12,6),(9,7),(16,7),(1,8),(2,8),(3,8),(4,8),(5,8),(6,8),(7,8),(9,8),(10,8),(11,8),(12,8),(13,8),(16,8),(17,8),(5,8),(16,8),(5,9),(16,9),(16,10),(19,10),(16,11),(19,11),(8,12),(16,12),(12,13),(13,13),(16,13),(1,14),(9,14),(16,14),(16,15),(17,15),(18,15),(16,16),(19,16),(9,17),(16,17),(3,18),(8,18),(16,18),(14,19),(15,19),(16,19),(16,20),(17,20),(18,20),(19,20),(16,21),(17,21),(18,21),(19,21),(16,22),(18,22),(2,23),(6,23),(7,23),(16,23),(19,23),(2,23),(6,23),(7,23),(16,23),(19,23),(2,24),(6,24),(7,24),(13,24),(16,24),(9,25),(16,25);
/*!40000 ALTER TABLE `perfiles_programas_pregrado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produccion_intelectual`
--

DROP TABLE IF EXISTS `produccion_intelectual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produccion_intelectual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(500) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `publicacion_titulo` varchar(200) DEFAULT NULL,
  `publicacion_autor` varchar(100) DEFAULT NULL,
  `paginas` int(11) DEFAULT NULL,
  `año` int(11) DEFAULT NULL,
  `ISSN` varchar(45) DEFAULT NULL,
  `nombre_editorial` varchar(45) DEFAULT NULL,
  `nombre_libro` varchar(45) DEFAULT NULL,
  `numero_patente` int(11) DEFAULT NULL,
  `entidad_patente` varchar(100) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `volumen` int(11) DEFAULT NULL,
  `idiomas_id` int(11) DEFAULT NULL,
  `paises_id` int(11) DEFAULT NULL,
  `tipo_patente` varchar(10) DEFAULT NULL,
  `ISBN` varchar(45) DEFAULT NULL,
  `aspirantes_id` int(11) DEFAULT NULL,
  `tipos_produccion_intelectual_id` int(11) NOT NULL,
  `evento` varchar(200) DEFAULT NULL,
  `ruta_adjunto` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_produccion_intelectual_aspirantes1_idx` (`aspirantes_id`),
  KEY `fk_produccion_intelectual_paises1_idx` (`paises_id`),
  KEY `fk_produccion_intelectual_idiomas1_idx` (`idiomas_id`),
  KEY `fk_produccion_intelectual_tipos_produccion_intelectual1_idx` (`tipos_produccion_intelectual_id`),
  CONSTRAINT `fk_produccion_intelectual_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produccion_intelectual_paises1` FOREIGN KEY (`paises_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produccion_intelectual_idiomas1` FOREIGN KEY (`idiomas_id`) REFERENCES `idiomas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_produccion_intelectual_tipos_produccion_intelectual1` FOREIGN KEY (`tipos_produccion_intelectual_id`) REFERENCES `tipos_produccion_intelectual` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produccion_intelectual`
--

LOCK TABLES `produccion_intelectual` WRITE;
/*!40000 ALTER TABLE `produccion_intelectual` DISABLE KEYS */;
/*!40000 ALTER TABLE `produccion_intelectual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programas`
--

DROP TABLE IF EXISTS `programas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `niveles_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`niveles_id`),
  KEY `fk_programas_niveles_idx` (`niveles_id`),
  CONSTRAINT `fk_programas_niveles` FOREIGN KEY (`niveles_id`) REFERENCES `niveles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programas`
--

LOCK TABLES `programas` WRITE;
/*!40000 ALTER TABLE `programas` DISABLE KEYS */;
INSERT INTO `programas` VALUES (2541,'INGENIERÍA AGRÍCOLA',1),(2542,'INGENIERÍA CIVIL',1),(2544,'INGENIERÍA ELÉCTRICA',1),(2545,'INGENIERÍA ELECTRÓNICA',1),(2546,'INGENIERÍA INDUSTRIAL',1),(2547,'INGENIERÍA MECÁNICA',1),(2548,'INGENIERIA MECATRÓNICA',1),(2549,'INGENIERÍA QUÍMICA',1),(2562,'MAESTRIA EN INGENIERIA - INGENIERIA AMBIENTAL',3),(2682,'DOCTORADO EN INGENIERIA - CIENCIA Y TECNOLOGÍA DE MATERIALES',4),(2683,'DOCTORADO EN INGENIERIA - GEOTECNIA',4),(2684,'DOCTORADO EN INGENIERIA - SISTEMAS Y COMPUTACION',4),(2685,'DOCTORADO EN INGENIERIA - INGENIERIA ELECTRICA',4),(2686,'DOCTORADO EN INGENIERIA - INGENIERIA QUIMICA',4),(2689,'ESPECIALIZACION EN ESTRUCTURAS',2),(2691,'ESPECIALIZACION EN ILUMINACION PUBLICA Y PRIVADA',2),(2696,'ESPECIALIZACION EN TRANSITO, DISEÑO Y SEGURIDAD VIAL',2),(2698,'MAESTRIA EN INGENIERIA - AUTOMATIZACION INDUSTRIAL',3),(2699,'MAESTRIA EN INGENIERIA - ESTRUCTURAS',3),(2700,'MAESTRIA EN INGENIERIA - GEOTECNIA',3),(2701,'MAESTRIA EN INGENIERIA - INGENIERIA AGRICOLA',3),(2702,'MAESTRIA EN INGENIERIA - INGENIERIA DE SISTEMAS Y COMPUTACIÓN',3),(2703,'MAESTRIA EN INGENIERIA - INGENIERIA ELECTRICA',3),(2704,'MAESTRIA EN INGENIERIA - INGENIERIA QUIMICA',3),(2705,'MAESTRIA EN INGENIERIA - RECURSOS HIDRAULICOS',3),(2706,'MAESTRIA EN INGENIERIA - TRANSPORTE',3),(2707,'MAESTRIA EN INGENIERIA - TELECOMUNICACIONES',3),(2708,'MAESTRIA EN INGENIERIA - INGENIERIA INDUSTRIAL',3),(2709,'MAESTRIA EN INGENIERIA - INGENIERIA MECANICA',3),(2710,'MAESTRIA EN MATERIALES Y PROCESOS',3),(2838,'DOCTORADO EN INGENIERÍA - INDUSTRIA Y ORGANIZACIONES',4),(2839,'DOCTORADO EN INGENIERIA - INGENIERIA MECANICA Y MECATRONICA',4),(2856,'MAESTRIA EN INGENIERIA - INGENIERIA DE SISTEMAS Y COMPUTACIÓN - CONV UPC',3),(2865,'MAESTRÍA EN INGENIERÍA - INGENIERÍA ELECTRÓNICA',3),(2879,'INGENIERÍA DE SISTEMAS Y COMPUTACIÓN',1),(2882,'MAESTRÍA EN BIOINFORMÁTICA',3),(2886,'ESPECIALIZACION EN ESTRUCTURAS',3),(2887,'DOCTORADO EN INGENIERIA - INGENIERIA CIVIL',3),(2896,'ESPECIALIZACIÖN EN GOBIERNO ELECTRÓNICO',2);
/*!40000 ALTER TABLE `programas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programas_pregrado`
--

DROP TABLE IF EXISTS `programas_pregrado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programas_pregrado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programas_pregrado`
--

LOCK TABLES `programas_pregrado` WRITE;
/*!40000 ALTER TABLE `programas_pregrado` DISABLE KEYS */;
INSERT INTO `programas_pregrado` VALUES (1,'Física'),(2,'Geología'),(3,'Ingeniería aeronáutica'),(4,'Ingeniería Agrícola'),(5,'Ingeniería Ambiental'),(6,'Ingeniería Catastral'),(7,'Ingeniería Civil'),(8,'Ingeniería de Construcción'),(9,'Ingeniería de Construcción'),(10,'Ingeniería de Materiales'),(11,'Ingeniería de Metalurgia'),(12,'Ingeniería de Minas'),(13,'Ingeniería de Recursos Hídricos'),(14,'Ingeniería de transportes y vías'),(15,'Ingeniería electromecánica'),(16,'Ingeniería física'),(17,'Ingeniería Geodesta'),(18,'Ingeniería Geológica'),(19,'Ingeniería Industrial'),(20,'Ingeniería Mecánica'),(21,'Ingeniería Mecatrónica'),(22,'Ingeniería naval'),(23,'Ingeniería Química'),(24,'Ingeniería Sanitaria'),(25,'Ingeniería Topográfica');
/*!40000 ALTER TABLE `programas_pregrado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiponiveles`
--

DROP TABLE IF EXISTS `tiponiveles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiponiveles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiponiveles`
--

LOCK TABLES `tiponiveles` WRITE;
/*!40000 ALTER TABLE `tiponiveles` DISABLE KEYS */;
INSERT INTO `tiponiveles` VALUES (1,'PREGRADO'),(2,'POSGRADO');
/*!40000 ALTER TABLE `tiponiveles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_documento`
--

DROP TABLE IF EXISTS `tipos_documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_documento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `sigla` varchar(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_documento`
--

LOCK TABLES `tipos_documento` WRITE;
/*!40000 ALTER TABLE `tipos_documento` DISABLE KEYS */;
INSERT INTO `tipos_documento` VALUES (1,'Cédula de ciudadania','CC'),(2,'Cédula de extranjería','CE');
/*!40000 ALTER TABLE `tipos_documento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_produccion_intelectual`
--

DROP TABLE IF EXISTS `tipos_produccion_intelectual`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_produccion_intelectual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_produccion_intelectual`
--

LOCK TABLES `tipos_produccion_intelectual` WRITE;
/*!40000 ALTER TABLE `tipos_produccion_intelectual` DISABLE KEYS */;
INSERT INTO `tipos_produccion_intelectual` VALUES (1,'Artículo cientifico'),(2,'Libro'),(3,'Capitulo de libro'),(4,'Patente'),(5,'Ponencia');
/*!40000 ALTER TABLE `tipos_produccion_intelectual` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_vinculacion_docente`
--

DROP TABLE IF EXISTS `tipos_vinculacion_docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_vinculacion_docente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_vinculacion_docente`
--

LOCK TABLES `tipos_vinculacion_docente` WRITE;
/*!40000 ALTER TABLE `tipos_vinculacion_docente` DISABLE KEYS */;
INSERT INTO `tipos_vinculacion_docente` VALUES (1,'Tiempo completo'),(2,'Medio tiempo'),(3,'Cátedra');
/*!40000 ALTER TABLE `tipos_vinculacion_docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipos_vinculacion_laboral`
--

DROP TABLE IF EXISTS `tipos_vinculacion_laboral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipos_vinculacion_laboral` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipos_vinculacion_laboral`
--

LOCK TABLES `tipos_vinculacion_laboral` WRITE;
/*!40000 ALTER TABLE `tipos_vinculacion_laboral` DISABLE KEYS */;
INSERT INTO `tipos_vinculacion_laboral` VALUES (1,'Tiempo completo'),(2,'Medio tiempo'),(3,'Tiempo parcial');
/*!40000 ALTER TABLE `tipos_vinculacion_laboral` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `isadmin` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Fabian Leonardo Ramirez Sandino','flramirezs@unal.edu.co','$2y$10$HLu5gy95DnXaM7/QIEXxn.cLa9Bm6PIyuW4ukdg6ucK6QAcmYKJ/W','dV2keVP2G7umDoXyhX9YcSBnKFvOrpCxbn5robYMZzF9bBq537jN3lNuLsjG','2016-10-05 22:37:05','2016-10-25 21:56:02',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vinculaciones`
--

DROP TABLE IF EXISTS `vinculaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vinculaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aspirantes_id` int(11) DEFAULT NULL,
  `nombre_institucion` varchar(256) DEFAULT NULL,
  `fecha_vinculacion` date DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `paises_id` int(11) NOT NULL,
  `perfil_laboral` varchar(500) DEFAULT NULL,
  `tipo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vinculacion_actual_paises1_idx` (`paises_id`),
  KEY `fk_vinculacion_actual_aspirantes1_idx` (`aspirantes_id`),
  CONSTRAINT `fk_vinculacion_actual_paises1` FOREIGN KEY (`paises_id`) REFERENCES `paises` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_vinculacion_actual_aspirantes1` FOREIGN KEY (`aspirantes_id`) REFERENCES `aspirantes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vinculaciones`
--

LOCK TABLES `vinculaciones` WRITE;
/*!40000 ALTER TABLE `vinculaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `vinculaciones` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-10-31 15:29:17
