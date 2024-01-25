-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: serviciosgenerales
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `area`
--

DROP TABLE IF EXISTS `area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `area` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_AREA_Nombre` (`Nombre`),
  UNIQUE KEY `uc_AREA_Rut` (`Descripcion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'area 1','área de rrhh',1,'2024-01-02 22:19:46','2024-01-25 00:26:03'),(2,'area 2','area de finanzas',1,'2024-01-02 22:37:01','2024-01-25 00:25:56'),(3,'area 3','contabilidad',1,'2024-01-02 22:37:18','2024-01-25 00:25:41'),(4,'area 4','area de informática',1,'2024-01-02 22:37:46','2024-01-25 00:25:48'),(5,'area 5','area 2',0,'2024-01-20 19:21:18','2024-01-25 00:25:32');
/*!40000 ALTER TABLE `area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atributo`
--

DROP TABLE IF EXISTS `atributo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `atributo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Caracteristica` varchar(255) DEFAULT NULL,
  `ValorReferencia` int(11) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_ATRIBUTO_Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributo`
--

LOCK TABLES `atributo` WRITE;
/*!40000 ALTER TABLE `atributo` DISABLE KEYS */;
INSERT INTO `atributo` VALUES (1,'vehículo','caracteristica 1',50000,1,'2024-01-02 22:47:59','2024-01-02 22:47:59'),(2,'persona','caracteristica',65000,1,'2024-01-02 22:48:15','2024-01-02 22:48:15'),(3,'pasaje','caracteristica',100000,1,'2024-01-02 22:48:36','2024-01-02 22:48:36'),(4,'equipaje bodega','caracteristica',65000,1,'2024-01-02 22:48:53','2024-01-02 22:48:53'),(5,'hotel','caracteristica',500000,0,'2024-01-02 22:49:16','2024-01-02 22:49:57'),(6,'traslado','caracteristica',20000,0,'2024-01-02 22:49:50','2024-01-02 22:49:54'),(7,'alojamiento','caracteristica',123456,1,'2024-01-09 10:10:35','2024-01-10 14:32:00'),(8,'atributo uno',NULL,70000,1,'2024-01-17 16:55:29','2024-01-17 16:55:29'),(9,'atributo dos',NULL,34000,1,'2024-01-17 16:55:43','2024-01-17 16:56:00');
/*!40000 ALTER TABLE `atributo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centro_de_costo`
--

DROP TABLE IF EXISTS `centro_de_costo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `centro_de_costo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `EmpresaId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_CENTRO_DE_COSTO_EmpresaId` (`EmpresaId`),
  CONSTRAINT `fk_CENTRO_DE_COSTO_EmpresaId` FOREIGN KEY (`EmpresaId`) REFERENCES `empresa` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_de_costo`
--

LOCK TABLES `centro_de_costo` WRITE;
/*!40000 ALTER TABLE `centro_de_costo` DISABLE KEYS */;
INSERT INTO `centro_de_costo` VALUES (1,'administrativos',0,'2024-01-02 21:13:50','2024-01-02 21:14:15',1),(2,'pesquero',1,'2024-01-02 21:14:11','2024-01-02 21:14:11',1),(3,'finanzas',1,'2024-01-02 21:15:20','2024-01-02 21:15:20',2),(4,'contabilidad',1,'2024-01-02 21:15:38','2024-01-02 21:15:38',2),(5,'contabilidad',1,'2024-01-02 21:15:45','2024-01-02 21:15:45',3),(6,'contabilidad',1,'2024-01-02 21:15:49','2024-01-02 21:15:49',1),(7,'administrativos',1,'2024-01-02 21:15:57','2024-01-02 21:15:57',2),(8,'administrativos',1,'2024-01-02 21:16:01','2024-01-02 21:16:01',3),(9,'centro de costo 4',0,'2024-01-24 19:06:48','2024-01-24 19:07:00',1);
/*!40000 ALTER TABLE `centro_de_costo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compuesta`
--

DROP TABLE IF EXISTS `compuesta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compuesta` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MovimientoAtributoId` int(11) NOT NULL,
  `CostoReal` int(11) NOT NULL,
  `Caracteristica` varchar(255) NOT NULL,
  `SolicitudId` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_COMPUESTA_MovimientoAtributoId` (`MovimientoAtributoId`),
  KEY `fk_COMPUESTA_SolicitudId` (`SolicitudId`),
  CONSTRAINT `fk_COMPUESTA_MovimientoAtributoId` FOREIGN KEY (`MovimientoAtributoId`) REFERENCES `movimiento_atributo` (`Id`),
  CONSTRAINT `fk_COMPUESTA_SolicitudId` FOREIGN KEY (`SolicitudId`) REFERENCES `solicitud` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compuesta`
--

LOCK TABLES `compuesta` WRITE;
/*!40000 ALTER TABLE `compuesta` DISABLE KEYS */;
INSERT INTO `compuesta` VALUES (113,1,50000,'caracteristica 1',70,'2024-01-25 00:56:48','2024-01-25 00:56:48'),(114,2,65000,'caracteristica',70,'2024-01-25 00:56:48','2024-01-25 00:56:48'),(115,10,70000,'null',71,'2024-01-25 00:58:27','2024-01-25 00:58:27'),(116,8,123456,'caracteristica',72,'2024-01-25 01:00:44','2024-01-25 01:00:44'),(117,9,34000,'null',72,'2024-01-25 01:00:44','2024-01-25 01:00:44'),(118,6,34000,'null',73,'2024-01-25 01:02:07','2024-01-25 01:02:07'),(119,5,123456,'caracteristica',73,'2024-01-25 01:02:07','2024-01-25 01:02:07'),(120,4,65000,'caracteristica',73,'2024-01-25 01:02:07','2024-01-25 01:02:07'),(121,8,123456,'caracteristica',74,'2024-01-25 01:02:31','2024-01-25 01:02:31'),(122,9,34000,'null',74,'2024-01-25 01:02:31','2024-01-25 01:02:31'),(123,11,34000,'null',75,'2024-01-25 01:03:12','2024-01-25 01:03:12'),(124,11,34000,'null',76,'2024-01-25 01:04:06','2024-01-25 01:04:06'),(125,10,70000,'null',76,'2024-01-25 01:04:06','2024-01-25 01:04:06'),(126,5,123456,'caracteristica',77,'2024-01-25 01:05:05','2024-01-25 01:05:05'),(127,4,65000,'caracteristica',77,'2024-01-25 01:05:05','2024-01-25 01:05:05'),(128,3,100000,'caracteristica',78,'2024-01-25 01:05:39','2024-01-25 01:05:39'),(129,2,65000,'caracteristica',78,'2024-01-25 01:05:39','2024-01-25 01:05:39');
/*!40000 ALTER TABLE `compuesta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consolidado_mes`
--

DROP TABLE IF EXISTS `consolidado_mes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consolidado_mes` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `FechaTermino` datetime DEFAULT NULL,
  `EstadoConsolidadoId` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_CONSOLIDADO_MES_EstadoConsolidadoId` (`EstadoConsolidadoId`),
  CONSTRAINT `fk_CONSOLIDADO_MES_EstadoConsolidadoId` FOREIGN KEY (`EstadoConsolidadoId`) REFERENCES `estado_consolidado` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consolidado_mes`
--

LOCK TABLES `consolidado_mes` WRITE;
/*!40000 ALTER TABLE `consolidado_mes` DISABLE KEYS */;
INSERT INTO `consolidado_mes` VALUES (1,'2024-01-14 02:04:04',NULL,1,NULL);
/*!40000 ALTER TABLE `consolidado_mes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empresa`
--

DROP TABLE IF EXISTS `empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empresa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Rut` varchar(13) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_EMPRESA_Nombre` (`Nombre`),
  UNIQUE KEY `uc_EMPRESA_Rut` (`Rut`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'epi','54234954-9','contacto@epi.cl',1,'2024-01-02 21:09:48','2024-01-24 19:04:17'),(2,'iti','34233233-1','contacto@iti.cl',1,'2024-01-02 21:10:15','2024-01-24 19:04:46'),(3,'pesqueras unidas','17460605-6','contacto@pesqunida.cl',0,'2024-01-02 21:10:51','2024-01-02 21:16:29');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_consolidado`
--

DROP TABLE IF EXISTS `estado_consolidado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_consolidado` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_consolidado`
--

LOCK TABLES `estado_consolidado` WRITE;
/*!40000 ALTER TABLE `estado_consolidado` DISABLE KEYS */;
INSERT INTO `estado_consolidado` VALUES (1,'Abierto','2024-01-14 02:02:29',NULL),(2,'Cerrado','2024-01-14 02:03:16',NULL);
/*!40000 ALTER TABLE `estado_consolidado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_etapa`
--

DROP TABLE IF EXISTS `estado_etapa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_etapa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_etapa`
--

LOCK TABLES `estado_etapa` WRITE;
/*!40000 ALTER TABLE `estado_etapa` DISABLE KEYS */;
INSERT INTO `estado_etapa` VALUES (1,'Aprobada'),(2,'Rechazada'),(3,'Pendiente');
/*!40000 ALTER TABLE `estado_etapa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_flujo`
--

DROP TABLE IF EXISTS `estado_flujo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_flujo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_ESTADO_SOLICITUD_Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_flujo`
--

LOCK TABLES `estado_flujo` WRITE;
/*!40000 ALTER TABLE `estado_flujo` DISABLE KEYS */;
INSERT INTO `estado_flujo` VALUES (1,'rechazado',0,'2023-12-25 14:17:47','2024-01-20 21:30:39'),(2,'etapa 1',1,'2023-12-25 14:19:02','2024-01-24 19:08:39'),(3,'verificación',0,'2023-12-25 14:19:13','2023-12-25 14:19:45'),(4,'step 1',1,'2023-12-25 14:19:22','2023-12-25 14:19:22'),(5,'en impresion',0,'2024-01-03 02:58:51','2024-01-20 19:53:28'),(6,'etapa 2',1,'2024-01-03 02:58:51','2024-01-20 21:30:37'),(8,'step 2',1,'2024-01-03 04:02:14',NULL),(9,'step 3',1,'2024-01-03 05:27:04',NULL),(10,'etapa 3',1,'2024-01-03 05:27:25','2024-01-20 21:29:51'),(11,'etapa 4',1,'2024-01-24 19:10:54','2024-01-24 19:10:57');
/*!40000 ALTER TABLE `estado_flujo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_solicitud`
--

DROP TABLE IF EXISTS `estado_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_solicitud` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_solicitud`
--

LOCK TABLES `estado_solicitud` WRITE;
/*!40000 ALTER TABLE `estado_solicitud` DISABLE KEYS */;
INSERT INTO `estado_solicitud` VALUES (1,'Iniciado'),(2,'En Curso'),(3,'Terminado');
/*!40000 ALTER TABLE `estado_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flujo`
--

DROP TABLE IF EXISTS `flujo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flujo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `AreaId` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_FLUJO_AreaId` (`AreaId`),
  KEY `fk_FLUJO_GrupoId` (`GrupoId`),
  CONSTRAINT `fk_FLUJO_AreaId` FOREIGN KEY (`AreaId`) REFERENCES `area` (`Id`),
  CONSTRAINT `fk_FLUJO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flujo`
--

LOCK TABLES `flujo` WRITE;
/*!40000 ALTER TABLE `flujo` DISABLE KEYS */;
INSERT INTO `flujo` VALUES (1,'flujo 1 g5',1,'2024-01-23 17:38:20','2024-01-23 17:38:20',2,5),(2,'flujo 2 g2',1,'2024-01-23 17:38:50','2024-01-23 17:38:50',3,2),(3,'flujo 3 g5g2g5',1,'2024-01-23 17:39:35','2024-01-23 17:39:35',4,5),(4,'flujo 4 g2g5g7',1,'2024-01-25 00:51:58','2024-01-25 00:51:58',3,5);
/*!40000 ALTER TABLE `flujo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_GRUPO_Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` VALUES (1,'grupo 1','Grupo 1',0,'2023-12-25 18:16:51','2024-01-24 19:21:38'),(2,'grupo 2','Grupo 2',1,'2023-12-25 18:16:51','2024-01-22 19:17:31'),(5,'grupo 5','administrado',1,'2023-12-26 01:48:12','2024-01-23 17:50:36'),(6,'grupo 6','grupo 3 de personas',0,'2024-01-02 22:52:27','2024-01-25 00:48:58'),(7,'grupo 7','hola',1,'2024-01-08 10:32:45','2024-01-25 00:48:50');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_operacion`
--

DROP TABLE IF EXISTS `grupo_operacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo_operacion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `GrupoId` int(11) NOT NULL,
  `PrivilegioId` int(11) NOT NULL,
  `Enabled` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `fk_GRUPO_RECURSO_GrupoId` (`GrupoId`),
  KEY `fk_GRUPO_RECURSO_PrivilegioId` (`PrivilegioId`),
  CONSTRAINT `fk_GRUPO_RECURSO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`),
  CONSTRAINT `fk_GRUPO_RECURSO_PrivilegioId` FOREIGN KEY (`PrivilegioId`) REFERENCES `operacion` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_operacion`
--

LOCK TABLES `grupo_operacion` WRITE;
/*!40000 ALTER TABLE `grupo_operacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_operacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_privilegio`
--

DROP TABLE IF EXISTS `grupo_privilegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo_privilegio` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `GrupoId` int(11) NOT NULL,
  `PrivilegioId` int(11) NOT NULL,
  `Ver` tinyint(1) NOT NULL DEFAULT 0,
  `Registrar` tinyint(1) NOT NULL DEFAULT 0,
  `Editar` tinyint(1) NOT NULL DEFAULT 0,
  `Eliminar` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`),
  KEY `fk_GRUPO_PRIVILEGIO_GrupoId` (`GrupoId`),
  KEY `fk_GRUPO_PRIVILEGIO_PrivilegioId` (`PrivilegioId`),
  CONSTRAINT `fk_GRUPO_PRIVILEGIO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`),
  CONSTRAINT `fk_GRUPO_PRIVILEGIO_PrivilegioId` FOREIGN KEY (`PrivilegioId`) REFERENCES `privilegio` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_privilegio`
--

LOCK TABLES `grupo_privilegio` WRITE;
/*!40000 ALTER TABLE `grupo_privilegio` DISABLE KEYS */;
INSERT INTO `grupo_privilegio` VALUES (7,'2023-12-26 01:48:12','2024-01-24 19:11:26',5,1,1,1,1,1),(8,'2023-12-26 01:48:12','2024-01-24 17:10:17',5,2,1,1,1,1),(9,'2023-12-26 01:48:12','2024-01-24 19:11:26',5,3,1,1,1,1),(10,'2023-12-26 01:48:12','2024-01-24 19:11:26',5,4,1,1,1,1),(11,'2023-12-26 01:48:12','2024-01-24 18:31:04',5,5,1,1,1,1),(12,'2023-12-26 01:48:12','2024-01-24 18:31:04',5,6,1,1,1,1),(13,'2023-12-26 01:48:12','2024-01-24 18:30:47',5,7,1,1,1,1),(14,'2023-12-26 01:48:12','2024-01-24 18:31:04',5,8,1,1,1,1),(15,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,1,1,0,1,1),(16,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,2,1,0,1,1),(18,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,3,1,0,1,1),(19,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,4,1,0,1,1),(20,'2023-12-26 05:06:49','2024-01-24 19:21:45',1,5,1,1,1,1),(21,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,6,1,0,1,1),(22,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,7,1,0,1,1),(23,'2023-12-26 05:06:49','2024-01-19 18:42:23',1,8,1,0,1,1),(24,'2023-12-26 05:07:43','2024-01-22 19:14:55',2,1,1,1,1,1),(25,'2023-12-26 05:07:43','2024-01-22 19:14:55',2,2,1,1,1,1),(26,'2023-12-26 05:07:43','2024-01-22 11:57:56',2,3,1,1,1,1),(27,'2023-12-26 05:07:43','2024-01-22 19:14:56',2,4,1,1,1,1),(28,'2023-12-26 05:07:43','2024-01-22 19:14:56',2,5,1,1,1,1),(29,'2023-12-26 05:07:43','2024-01-22 19:14:56',2,6,1,1,1,1),(30,'2023-12-26 05:07:43','2024-01-22 19:14:56',2,7,1,1,1,1),(31,'2023-12-26 05:07:43','2024-01-22 19:14:56',2,8,1,1,1,1),(32,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,1,1,0,0,1),(33,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,2,1,0,0,1),(34,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,3,1,0,0,1),(35,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,4,1,0,0,1),(36,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,5,1,0,0,1),(37,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,6,1,0,0,1),(38,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,7,1,0,0,1),(39,'2024-01-02 22:52:27','2024-01-02 23:09:54',6,8,1,0,0,1),(40,'2024-01-08 10:34:42','2024-01-08 10:34:42',7,1,1,0,0,0),(41,'2024-01-08 10:34:42','2024-01-25 00:48:28',7,2,1,0,0,0),(42,'2024-01-08 10:34:42','2024-01-08 10:34:42',7,3,0,0,0,0),(43,'2024-01-08 10:34:42','2024-01-08 10:34:42',7,4,0,0,0,0),(44,'2024-01-08 10:34:42','2024-01-08 10:34:42',7,5,0,0,0,0),(45,'2024-01-08 10:34:42','2024-01-08 10:34:42',7,6,0,0,0,0),(46,'2024-01-08 10:34:42','2024-01-08 10:34:42',7,7,0,0,0,0),(47,'2024-01-08 10:34:42','2024-01-25 00:48:28',7,8,0,0,0,0),(48,'2024-01-08 10:36:58','2024-01-08 10:36:58',7,10,0,0,0,0),(50,'2024-01-11 00:25:50','2024-01-19 18:42:23',1,10,1,0,1,1),(52,'2024-01-19 17:14:27','2024-01-24 18:30:14',5,10,1,1,1,1),(54,'2024-01-20 21:16:36','2024-01-23 17:52:58',5,12,1,0,1,1),(55,'2024-01-22 11:57:00','2024-01-22 19:14:56',2,10,1,1,1,1),(56,'2024-01-22 11:57:00','2024-01-23 18:00:21',2,12,1,0,1,1),(57,'2024-01-24 17:03:00','2024-01-24 17:03:00',1,12,0,0,0,0),(58,'2024-01-25 00:48:14','2024-01-25 00:48:14',7,12,1,0,0,0),(59,'2024-01-25 00:48:58','2024-01-25 00:48:58',6,10,0,0,0,0),(60,'2024-01-25 00:48:58','2024-01-25 00:48:58',6,12,0,0,0,0);
/*!40000 ALTER TABLE `grupo_privilegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_solicitud`
--

DROP TABLE IF EXISTS `historial_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_solicitud` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EstadoFlujoId` int(11) NOT NULL,
  `EstadoEtapaFlujoId` int(11) NOT NULL DEFAULT 3,
  `SolicitudId` int(11) NOT NULL,
  `EstadoSolicitudId` int(11) NOT NULL,
  `UsuarioId` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_HISTORIAL_SOLICITUD_UsuarioId` (`UsuarioId`),
  KEY `fk_HISTORIAL_SOLICITUD_EstadoSolicitudId` (`EstadoSolicitudId`),
  KEY `fk_HISTORIAL_SOLICITUD_SolicitudId` (`SolicitudId`),
  KEY `historial_solicitud_estado_flujo_FK` (`EstadoFlujoId`),
  KEY `historial_solicitud_estado_etapa_FK` (`EstadoEtapaFlujoId`),
  CONSTRAINT `fk_HISTORIAL_SOLICITUD_SolicitudId` FOREIGN KEY (`SolicitudId`) REFERENCES `solicitud` (`Id`),
  CONSTRAINT `fk_HISTORIAL_SOLICITUD_UsuarioId` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`),
  CONSTRAINT `historial_solicitud_estado_etapa_FK` FOREIGN KEY (`EstadoEtapaFlujoId`) REFERENCES `estado_etapa` (`Id`),
  CONSTRAINT `historial_solicitud_estado_flujo_FK` FOREIGN KEY (`EstadoFlujoId`) REFERENCES `estado_flujo` (`Id`),
  CONSTRAINT `historial_solicitud_estado_solicitud_FK` FOREIGN KEY (`EstadoSolicitudId`) REFERENCES `estado_solicitud` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_solicitud`
--

LOCK TABLES `historial_solicitud` WRITE;
/*!40000 ALTER TABLE `historial_solicitud` DISABLE KEYS */;
INSERT INTO `historial_solicitud` VALUES (135,8,1,70,1,2,'2024-01-25 00:56:48','2024-01-25 00:57:15'),(136,4,1,70,2,2,'2024-01-25 00:57:15','2024-01-25 00:57:48'),(137,10,1,70,3,2,'2024-01-25 00:57:48','2024-01-25 00:57:59'),(138,2,1,71,1,101,'2024-01-25 00:58:27','2024-01-25 00:58:55'),(139,6,2,71,3,2,'2024-01-25 00:58:55','2024-01-25 00:59:59'),(140,4,1,72,1,2,'2024-01-25 01:00:44','2024-01-25 01:01:34'),(141,6,3,72,2,NULL,'2024-01-25 01:01:34','2024-01-25 01:01:34'),(142,2,3,73,1,101,'2024-01-25 01:02:07','2024-01-25 01:02:07'),(143,4,3,74,1,101,'2024-01-25 01:02:31','2024-01-25 01:02:31'),(144,2,1,75,1,101,'2024-01-25 01:03:12','2024-01-25 01:03:45'),(145,6,1,75,2,102,'2024-01-25 01:03:45','2024-01-25 01:04:13'),(146,2,3,76,1,102,'2024-01-25 01:04:06','2024-01-25 01:04:06'),(147,9,3,75,2,NULL,'2024-01-25 01:04:13','2024-01-25 01:04:13'),(148,2,1,77,1,101,'2024-01-25 01:05:05','2024-01-25 01:05:16'),(149,6,3,77,2,NULL,'2024-01-25 01:05:16','2024-01-25 01:05:16'),(150,8,3,78,1,2,'2024-01-25 01:05:39','2024-01-25 01:05:39');
/*!40000 ALTER TABLE `historial_solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interno`
--

DROP TABLE IF EXISTS `interno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interno` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CostoCC` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `CentroCostoId` int(11) NOT NULL,
  `ConsolidadoMesId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_INTERNO_CentroCostoId` (`CentroCostoId`),
  KEY `fk_INTERNO_ConsolidadoMesId` (`ConsolidadoMesId`),
  CONSTRAINT `fk_INTERNO_CentroCostoId` FOREIGN KEY (`CentroCostoId`) REFERENCES `centro_de_costo` (`Id`),
  CONSTRAINT `fk_INTERNO_ConsolidadoMesId` FOREIGN KEY (`ConsolidadoMesId`) REFERENCES `consolidado_mes` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interno`
--

LOCK TABLES `interno` WRITE;
/*!40000 ALTER TABLE `interno` DISABLE KEYS */;
/*!40000 ALTER TABLE `interno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `logs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nivel` varchar(20) NOT NULL,
  `Mensaje` varchar(255) NOT NULL,
  `Contexto` varchar(2000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2140 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (2020,'INFO','Ingreso vista usuario','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuario\",\"URI\":\"usuario\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:44:31','2024-01-25 03:44:31'),(2021,'INFO','Acceso vista Persona','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/persona\",\"URI\":\"persona\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:45:00','2024-01-25 03:45:00'),(2022,'INFO','Acceso vista Grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\",\"URI\":\"grupo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:45:16','2024-01-25 03:45:16'),(2023,'INFO','Ingreso vista usuario','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuario\",\"URI\":\"usuario\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:45:20','2024-01-25 03:45:20'),(2024,'INFO','Acceso vista Grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\",\"URI\":\"grupo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:45:34','2024-01-25 03:45:34'),(2025,'INFO','Nuevo usuario','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuario\\/registrar\",\"URI\":\"usuario\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:46:36','2024-01-25 03:46:36'),(2026,'INFO','Nuevo usuario','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuario\\/registrar\",\"URI\":\"usuario\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:47:38','2024-01-25 03:47:38'),(2027,'INFO','Cambio de estado de grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/cambiarestado\",\"URI\":\"grupo\\/cambiarestado\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:00','2024-01-25 03:48:00'),(2028,'INFO','Ver información del grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/veredit\",\"URI\":\"grupo\\/veredit\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:05','2024-01-25 03:48:05'),(2029,'INFO','Privilegios del grupo actualizados','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/editargrupoprivilegio\",\"URI\":\"grupo\\/editargrupoprivilegio\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:14','2024-01-25 03:48:14'),(2030,'INFO','Acceso vista Grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\",\"URI\":\"grupo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:48:15','2024-01-25 03:48:15'),(2031,'INFO','Ver información del grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/veredit\",\"URI\":\"grupo\\/veredit\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:19','2024-01-25 03:48:19'),(2032,'INFO','Privilegios del grupo actualizados','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/editargrupoprivilegio\",\"URI\":\"grupo\\/editargrupoprivilegio\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:28','2024-01-25 03:48:28'),(2033,'INFO','Acceso vista Grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\",\"URI\":\"grupo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:48:29','2024-01-25 03:48:29'),(2034,'INFO','Ver información del grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/veredit\",\"URI\":\"grupo\\/veredit\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:44','2024-01-25 03:48:44'),(2035,'INFO','Privilegios del grupo actualizados','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/editargrupoprivilegio\",\"URI\":\"grupo\\/editargrupoprivilegio\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:50','2024-01-25 03:48:50'),(2036,'INFO','Acceso vista Grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\",\"URI\":\"grupo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:48:51','2024-01-25 03:48:51'),(2037,'INFO','Ver información del grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/veredit\",\"URI\":\"grupo\\/veredit\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:53','2024-01-25 03:48:53'),(2038,'INFO','Privilegios del grupo actualizados','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\\/editargrupoprivilegio\",\"URI\":\"grupo\\/editargrupoprivilegio\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:48:58','2024-01-25 03:48:58'),(2039,'INFO','Acceso vista Grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/grupo\",\"URI\":\"grupo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:48:59','2024-01-25 03:48:59'),(2040,'INFO','Usuario  asignado a grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuariogrupo\\/registrar\",\"URI\":\"usuariogrupo\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:49:07','2024-01-25 03:49:07'),(2041,'INFO','Usuario  asignado a grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuariogrupo\\/registrar\",\"URI\":\"usuariogrupo\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:49:34','2024-01-25 03:49:34'),(2042,'INFO','Ingreso vista movimiento-atributo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\",\"URI\":\"movimientoatributo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:50:21','2024-01-25 03:50:21'),(2043,'INFO','Ingreso vista flujo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/flujo\",\"URI\":\"flujo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:50:38','2024-01-25 03:50:38'),(2044,'INFO','Ingreso vista movimiento-atributo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\",\"URI\":\"movimientoatributo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:50:39','2024-01-25 03:50:39'),(2045,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:50:49','2024-01-25 03:50:49'),(2046,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:50:53','2024-01-25 03:50:53'),(2047,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:50:57','2024-01-25 03:50:57'),(2048,'INFO','Ingreso vista flujo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/flujo\",\"URI\":\"flujo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:51:01','2024-01-25 03:51:01'),(2049,'INFO','Ingreso vista movimiento-atributo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\",\"URI\":\"movimientoatributo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:51:03','2024-01-25 03:51:03'),(2050,'INFO','Ingreso vista flujo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/flujo\",\"URI\":\"flujo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:51:04','2024-01-25 03:51:04'),(2051,'INFO','Nuevo Flujo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/flujo\\/registrar\",\"URI\":\"flujo\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:51:58','2024-01-25 03:51:58'),(2052,'INFO','Ingreso vista flujo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/flujo\",\"URI\":\"flujo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:52:00','2024-01-25 03:52:00'),(2053,'INFO','Ingreso vista movimiento-atributo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\",\"URI\":\"movimientoatributo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:52:03','2024-01-25 03:52:03'),(2054,'INFO','Nuevo movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/registrar\",\"URI\":\"movimiento\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:52:20','2024-01-25 03:52:20'),(2055,'INFO','Ver información del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/ver\",\"URI\":\"movimiento\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:52:25','2024-01-25 03:52:25'),(2056,'INFO','Ver información del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/ver\",\"URI\":\"movimiento\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:52:29','2024-01-25 03:52:29'),(2057,'INFO','Ver información del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/ver\",\"URI\":\"movimiento\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:52:31','2024-01-25 03:52:31'),(2058,'ERROR','Error al modificar movimiento','{\"0\":\"El Nombre ya est\\u00e1 en uso.\",\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/editar\",\"URI\":\"movimiento\\/editar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:52:43','2024-01-25 03:52:43'),(2059,'INFO','Ingreso vista movimiento-atributo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\",\"URI\":\"movimientoatributo\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:54:04','2024-01-25 03:54:04'),(2060,'INFO','Ver información del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/ver\",\"URI\":\"movimiento\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:54:08','2024-01-25 03:54:08'),(2061,'ERROR','Error al modificar movimiento','{\"0\":\"El Nombre ya est\\u00e1 en uso.\",\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimiento\\/editar\",\"URI\":\"movimiento\\/editar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:54:15','2024-01-25 03:54:15'),(2062,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:54:22','2024-01-25 03:54:22'),(2063,'INFO','Se asignaron atributos al movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/registrar\",\"URI\":\"movimientoatributo\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:54:36','2024-01-25 03:54:36'),(2064,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:54:43','2024-01-25 03:54:43'),(2065,'INFO','Ingreso vista usuario','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuario\",\"URI\":\"usuario\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:55:08','2024-01-25 03:55:08'),(2066,'INFO','Usuario nicolas.vasquez ha iniciado sesión por el método tradicional.','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/login\\/camanchaca\",\"URI\":\"login\\/camanchaca\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:55:33','2024-01-25 03:55:33'),(2067,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:55:34','2024-01-25 03:55:34'),(2068,'INFO','Usuario jorge.gatica ha iniciado sesión por el método tradicional.','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/login\\/camanchaca\",\"URI\":\"login\\/camanchaca\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:55:59','2024-01-25 03:55:59'),(2069,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:56:01','2024-01-25 03:56:01'),(2070,'INFO','Ver atributos del movimiento','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:56:40','2024-01-25 03:56:40'),(2071,'INFO','Solicitud generada','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:56:48','2024-01-25 03:56:48'),(2072,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:56:57','2024-01-25 03:56:57'),(2073,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:57:00','2024-01-25 03:57:00'),(2074,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:57:03','2024-01-25 03:57:03'),(2075,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:57:15','2024-01-25 03:57:15'),(2076,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:57:41','2024-01-25 03:57:41'),(2077,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:57:48','2024-01-25 03:57:48'),(2078,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:57:52','2024-01-25 03:57:52'),(2079,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:57:55','2024-01-25 03:57:55'),(2080,'INFO','Solicitud aprobada y terminada.','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:57:59','2024-01-25 03:57:59'),(2081,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:58:03','2024-01-25 03:58:03'),(2082,'INFO','Ingreso vista solicitudes terminadas','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/verterminadas?_token=4KF7FpXXZ1trzGKlY98sgPTKt3ihUfdmOOt5GQkR\",\"URI\":\"solicitud\\/verterminadas\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:58:05','2024-01-25 03:58:05'),(2083,'INFO','Ingreso vista solicitudes activas','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/veractivas?_token=4KF7FpXXZ1trzGKlY98sgPTKt3ihUfdmOOt5GQkR\",\"URI\":\"solicitud\\/veractivas\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:58:09','2024-01-25 03:58:09'),(2084,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:58:22','2024-01-25 03:58:22'),(2085,'INFO','Solicitud generada','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:58:27','2024-01-25 03:58:27'),(2086,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:58:33','2024-01-25 03:58:33'),(2087,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:58:36','2024-01-25 03:58:36'),(2088,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:58:46','2024-01-25 03:58:46'),(2089,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:58:55','2024-01-25 03:58:55'),(2090,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:59:10','2024-01-25 03:59:10'),(2091,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 03:59:15','2024-01-25 03:59:15'),(2092,'INFO','Solicitud rechazada y terminada.','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/rechazar\",\"URI\":\"solicitud\\/rechazar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 03:59:59','2024-01-25 03:59:59'),(2093,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:03','2024-01-25 04:00:03'),(2094,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:05','2024-01-25 04:00:05'),(2095,'INFO','Ingreso vista solicitudes terminadas','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/verterminadas?_token=ExstlZXo9gBc0IPRNFZApUCy1OnJwXqJAyLKLkpA\",\"URI\":\"solicitud\\/verterminadas\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:06','2024-01-25 04:00:06'),(2096,'INFO','Ingreso vista solicitudes terminadas','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/verterminadas?_token=4KF7FpXXZ1trzGKlY98sgPTKt3ihUfdmOOt5GQkR\",\"URI\":\"solicitud\\/verterminadas\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:09','2024-01-25 04:00:09'),(2097,'INFO','Ingreso vista solicitudes activas','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/veractivas?_token=4KF7FpXXZ1trzGKlY98sgPTKt3ihUfdmOOt5GQkR\",\"URI\":\"solicitud\\/veractivas\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:14','2024-01-25 04:00:14'),(2098,'INFO','Ingreso vista solicitudes activas','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/veractivas?_token=ExstlZXo9gBc0IPRNFZApUCy1OnJwXqJAyLKLkpA\",\"URI\":\"solicitud\\/veractivas\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:16','2024-01-25 04:00:16'),(2099,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:00:39','2024-01-25 04:00:39'),(2100,'INFO','Solicitud generada','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:00:44','2024-01-25 04:00:44'),(2101,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:49','2024-01-25 04:00:49'),(2102,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:52','2024-01-25 04:00:52'),(2103,'INFO','Ingreso vista usuario','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuario\",\"URI\":\"usuario\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:00:57','2024-01-25 04:00:57'),(2104,'INFO','Usuario  asignado a grupo','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/usuariogrupo\\/registrar\",\"URI\":\"usuariogrupo\\/registrar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:01:08','2024-01-25 04:01:08'),(2105,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:01:12','2024-01-25 04:01:12'),(2106,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:01:13','2024-01-25 04:01:13'),(2107,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:01:28','2024-01-25 04:01:28'),(2108,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:01:34','2024-01-25 04:01:34'),(2109,'ERROR','Error en el avance de la solicitud','{\"0\":\"Etapa ya gestionada, recargue la pagina\",\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:01:39','2024-01-25 04:01:39'),(2110,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:01:42','2024-01-25 04:01:42'),(2111,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:01:52','2024-01-25 04:01:52'),(2112,'INFO','Ver atributos del movimiento','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:02:02','2024-01-25 04:02:02'),(2113,'INFO','Solicitud generada','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:02:07','2024-01-25 04:02:07'),(2114,'INFO','Ver atributos del movimiento','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:02:25','2024-01-25 04:02:25'),(2115,'INFO','Solicitud generada','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:02:31','2024-01-25 04:02:31'),(2116,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:02:47','2024-01-25 04:02:47'),(2117,'INFO','Ver atributos del movimiento','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:03:05','2024-01-25 04:03:05'),(2118,'INFO','Solicitud generada','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:03:12','2024-01-25 04:03:12'),(2119,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:03:18','2024-01-25 04:03:18'),(2120,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:03:32','2024-01-25 04:03:32'),(2121,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:03:34','2024-01-25 04:03:34'),(2122,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:03:45','2024-01-25 04:03:45'),(2123,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:03:49','2024-01-25 04:03:49'),(2124,'INFO','Ver atributos del movimiento','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:04:01','2024-01-25 04:04:01'),(2125,'INFO','Solicitud generada','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:04:06','2024-01-25 04:04:06'),(2126,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:04:13','2024-01-25 04:04:13'),(2127,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:04:15','2024-01-25 04:04:15'),(2128,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:04:29','2024-01-25 04:04:29'),(2129,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:04:49','2024-01-25 04:04:49'),(2130,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:04:58','2024-01-25 04:04:58'),(2131,'INFO','Solicitud generada','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:05:05','2024-01-25 04:05:05'),(2132,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:05:12','2024-01-25 04:05:12'),(2133,'INFO','Solicitud avanzó de etapa.','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/aprobar\",\"URI\":\"solicitud\\/aprobar\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:05:16','2024-01-25 04:05:16'),(2134,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:05:20','2024-01-25 04:05:20'),(2135,'INFO','Ver atributos del movimiento','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/movimientoatributo\\/ver\",\"URI\":\"movimientoatributo\\/ver\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:05:32','2024-01-25 04:05:32'),(2136,'INFO','Solicitud generada','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\\/RealizarSolicitud\",\"URI\":\"solicitud\\/RealizarSolicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"POST\"]}}','2024-01-25 04:05:39','2024-01-25 04:05:39'),(2137,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":2,\"Usuario\":\"raul.munoz\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\\/solicitud\",\"URI\":\"solicitud\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:05:41','2024-01-25 04:05:41'),(2138,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":101,\"Usuario\":\"nicolas.vasquez\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:05:43','2024-01-25 04:05:43'),(2139,'INFO','Ingreso vista Solicitud','{\"UsuarioId\":102,\"Usuario\":\"jorge.gatica\",\"IP\":\"127.0.0.1\",\"Ruta\":{\"URL\":\"http:\\/\\/127.0.0.1\\/sistemasolicitudes\\/public\",\"URI\":\"\\/\",\"UserAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/120.0.0.0 Safari\\/537.36 Edg\\/120.0.0.0\",\"Metodo\":[\"GET\",\"HEAD\"]}}','2024-01-25 04:05:45','2024-01-25 04:05:45');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento`
--

DROP TABLE IF EXISTS `movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimiento` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `FlujoId` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_MOVIMIENTO_Nombre` (`Nombre`),
  KEY `fk_MOVIMIENTO_FlujoId` (`FlujoId`),
  KEY `fk_MOVIMIENTO_GrupoId` (`GrupoId`),
  CONSTRAINT `fk_MOVIMIENTO_FlujoId` FOREIGN KEY (`FlujoId`) REFERENCES `flujo` (`Id`),
  CONSTRAINT `fk_MOVIMIENTO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
INSERT INTO `movimiento` VALUES (1,'mov 1 f1',1,2,1,'2024-01-23 17:40:10','2024-01-23 17:40:10'),(2,'mov 2 f2',2,2,1,'2024-01-23 17:41:00','2024-01-23 17:41:00'),(3,'mov 3 f3',3,2,1,'2024-01-23 17:41:47','2024-01-23 17:41:47'),(4,'mov 4 f4',4,2,1,'2024-01-25 00:52:20','2024-01-25 00:52:20');
/*!40000 ALTER TABLE `movimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movimiento_atributo`
--

DROP TABLE IF EXISTS `movimiento_atributo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movimiento_atributo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MovimientoId` int(11) NOT NULL,
  `AtributoId` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_MOVIMIENTO_ATRIBUTO_MovimientoId` (`MovimientoId`),
  KEY `fk_MOVIMIENTO_ATRIBUTO_AtributoId` (`AtributoId`),
  CONSTRAINT `fk_MOVIMIENTO_ATRIBUTO_AtributoId` FOREIGN KEY (`AtributoId`) REFERENCES `atributo` (`Id`),
  CONSTRAINT `fk_MOVIMIENTO_ATRIBUTO_MovimientoId` FOREIGN KEY (`MovimientoId`) REFERENCES `movimiento` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento_atributo`
--

LOCK TABLES `movimiento_atributo` WRITE;
/*!40000 ALTER TABLE `movimiento_atributo` DISABLE KEYS */;
INSERT INTO `movimiento_atributo` VALUES (1,1,1,'2024-01-23 17:40:26','2024-01-23 17:40:26'),(2,1,2,'2024-01-23 17:40:26','2024-01-23 17:40:26'),(3,1,3,'2024-01-23 17:40:26','2024-01-23 17:40:26'),(4,2,4,'2024-01-23 17:41:22','2024-01-23 17:41:22'),(5,2,7,'2024-01-23 17:41:22','2024-01-23 17:41:22'),(6,2,9,'2024-01-23 17:41:22','2024-01-23 17:41:22'),(7,3,3,'2024-01-23 17:42:09','2024-01-23 17:42:09'),(8,3,7,'2024-01-23 17:42:09','2024-01-23 17:42:09'),(9,3,9,'2024-01-23 17:42:09','2024-01-23 17:42:09'),(10,4,8,'2024-01-25 00:54:36','2024-01-25 00:54:36'),(11,4,9,'2024-01-25 00:54:36','2024-01-25 00:54:36');
/*!40000 ALTER TABLE `movimiento_atributo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operacion`
--

DROP TABLE IF EXISTS `operacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `operacion` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `MovimientoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_RECURSO_Nombre` (`Nombre`),
  KEY `operacion_movimiento_FK` (`MovimientoId`),
  CONSTRAINT `operacion_movimiento_FK` FOREIGN KEY (`MovimientoId`) REFERENCES `movimiento` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operacion`
--

LOCK TABLES `operacion` WRITE;
/*!40000 ALTER TABLE `operacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `operacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden_de_compra`
--

DROP TABLE IF EXISTS `orden_de_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orden_de_compra` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CostoMes` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `ConsolidadoMesId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_ORDEN_DE_COMPRA_ConsolidadoMesId` (`ConsolidadoMesId`),
  CONSTRAINT `fk_ORDEN_DE_COMPRA_ConsolidadoMesId` FOREIGN KEY (`ConsolidadoMesId`) REFERENCES `consolidado_mes` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_de_compra`
--

LOCK TABLES `orden_de_compra` WRITE;
/*!40000 ALTER TABLE `orden_de_compra` DISABLE KEYS */;
/*!40000 ALTER TABLE `orden_de_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orden_flujo`
--

DROP TABLE IF EXISTS `orden_flujo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orden_flujo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nivel` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `EstadoFlujoId` int(11) NOT NULL,
  `GrupoId` int(11) DEFAULT NULL,
  `Pivot` int(11) NOT NULL,
  `FlujoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_ORDEN_FLUJO_EstadoSolicitudId` (`EstadoFlujoId`),
  KEY `fk_ORDEN_FLUJO_GrupoId` (`GrupoId`),
  KEY `orden_flujo_flujo_FK` (`FlujoId`),
  CONSTRAINT `fk_ORDEN_FLUJO_EstadoSolicitudId` FOREIGN KEY (`EstadoFlujoId`) REFERENCES `estado_flujo` (`Id`),
  CONSTRAINT `fk_ORDEN_FLUJO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`),
  CONSTRAINT `orden_flujo_flujo_FK` FOREIGN KEY (`FlujoId`) REFERENCES `flujo` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_flujo`
--

LOCK TABLES `orden_flujo` WRITE;
/*!40000 ALTER TABLE `orden_flujo` DISABLE KEYS */;
INSERT INTO `orden_flujo` VALUES (1,0,'2024-01-23 17:38:20','2024-01-23 17:38:20',8,5,0,1),(2,1,'2024-01-23 17:38:20','2024-01-23 17:38:20',4,5,1,1),(3,2,'2024-01-23 17:38:20','2024-01-23 17:38:20',10,5,2,1),(4,0,'2024-01-23 17:38:50','2024-01-23 17:38:50',2,2,0,2),(5,1,'2024-01-23 17:38:50','2024-01-23 17:38:50',6,2,1,2),(6,2,'2024-01-23 17:38:50','2024-01-23 17:38:50',10,2,2,2),(7,0,'2024-01-23 17:39:35','2024-01-23 17:39:35',4,5,0,3),(8,1,'2024-01-23 17:39:35','2024-01-23 17:39:35',6,2,1,3),(9,2,'2024-01-23 17:39:35','2024-01-23 17:39:35',10,5,2,3),(10,0,'2024-01-25 00:51:58','2024-01-25 00:51:58',2,2,0,4),(11,1,'2024-01-25 00:51:58','2024-01-25 00:51:58',6,5,1,4),(12,2,'2024-01-25 00:51:58','2024-01-25 00:51:58',9,7,2,4);
/*!40000 ALTER TABLE `orden_flujo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `persona`
--

DROP TABLE IF EXISTS `persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `persona` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Rut` varchar(13) NOT NULL,
  `Enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `CentroCostoId` int(11) NOT NULL,
  `UsuarioId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_PERSONA_Rut` (`Rut`),
  KEY `fk_PERSONA_CentroCostoId` (`CentroCostoId`),
  KEY `fk_PERSONA_UsuarioId` (`UsuarioId`),
  CONSTRAINT `fk_PERSONA_CentroCostoId` FOREIGN KEY (`CentroCostoId`) REFERENCES `centro_de_costo` (`Id`),
  CONSTRAINT `fk_PERSONA_UsuarioId` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2113 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (2011,'valentin','salgado','19333813-5',1,'2024-01-02 21:31:56','2024-01-02 21:31:56',2,1),(2012,'raul','muñoz','17460605-6',1,'2024-01-02 21:39:13','2024-01-02 21:39:13',4,2),(2013,'patrick','montgomery','14414624-7',1,'2024-01-02 21:43:38','2024-01-02 21:43:38',8,3),(2014,'keely','luna','3582170-8',0,'2024-01-02 21:43:38','2024-01-02 21:43:38',6,4),(2015,'gray','rodriquez','8399160-7',1,'2024-01-02 21:43:38','2024-01-02 21:43:38',4,5),(2016,'gareth','york','38336727-1',1,'2024-01-02 21:43:38','2024-01-02 21:43:38',5,6),(2017,'elmo','reilly','47151840-9',0,'2024-01-02 21:43:39','2024-01-02 21:43:39',4,7),(2018,'ralph','solis','47873754-8',0,'2024-01-02 21:43:39','2024-01-02 21:43:39',7,8),(2019,'abel','campbell','7858484-k',1,'2024-01-02 21:43:39','2024-01-02 21:43:39',8,9),(2020,'charles','goodwin','46222525-3',1,'2024-01-02 21:43:39','2024-01-02 21:43:39',7,10),(2021,'levi','douglas','43729693-6',0,'2024-01-02 21:43:39','2024-01-02 21:43:39',3,11),(2022,'shelley','townsend','26236160-8',0,'2024-01-02 21:43:40','2024-01-02 21:43:40',7,12),(2023,'ingrid','flynn','32672509-9',0,'2024-01-02 21:43:40','2024-01-02 21:43:40',1,13),(2024,'melinda','knowles','36917429-0',1,'2024-01-02 21:43:40','2024-01-02 21:43:40',5,14),(2025,'berk','barr','42495836-0',1,'2024-01-02 21:43:40','2024-01-02 21:43:40',2,15),(2026,'lionel','blankenship','44717294-1',0,'2024-01-02 21:43:40','2024-01-02 21:43:40',6,16),(2027,'colleen','kerr','36782854-4',0,'2024-01-02 21:43:40','2024-01-02 21:43:40',1,17),(2028,'ahmed','rowe','668617-6',1,'2024-01-02 21:43:41','2024-01-02 21:43:41',6,18),(2029,'philip','macdonald','32841135-0',0,'2024-01-02 21:43:41','2024-01-02 21:43:41',5,19),(2030,'quail','wilkerson','39360200-7',1,'2024-01-02 21:43:41','2024-01-02 21:43:41',4,20),(2031,'aaron','pate','33371323-3',0,'2024-01-02 21:43:41','2024-01-24 19:07:14',8,21),(2032,'elton','dodson','37982953-8',1,'2024-01-02 21:43:41','2024-01-02 21:43:41',4,22),(2033,'drake','crawford','33392678-4',0,'2024-01-02 21:43:42','2024-01-02 21:43:42',4,23),(2034,'ella','alston','2735810-1',1,'2024-01-02 21:43:42','2024-01-02 21:43:42',4,24),(2035,'iris','holt','18545206-9',1,'2024-01-02 21:43:42','2024-01-02 21:43:42',5,25),(2036,'stone','vinson','34716342-2',1,'2024-01-02 21:43:42','2024-01-02 21:43:42',1,26),(2037,'otto','day','3478907-k',0,'2024-01-02 21:43:42','2024-01-02 21:43:42',6,27),(2038,'kato','sanchez','17103689-5',0,'2024-01-02 21:43:43','2024-01-02 21:43:43',4,28),(2039,'norman','barrera','2282571-2',0,'2024-01-02 21:43:43','2024-01-02 21:43:43',1,29),(2040,'chester','buckner','29363575-7',1,'2024-01-02 21:43:43','2024-01-02 21:43:43',1,30),(2041,'jerome','britt','47113156-3',1,'2024-01-02 21:43:43','2024-01-02 21:43:43',5,31),(2042,'julie','chen','27289775-1',0,'2024-01-02 21:43:43','2024-01-02 21:43:43',4,32),(2043,'carlos','guthrie','25110509-k',1,'2024-01-02 21:43:44','2024-01-02 21:43:44',6,33),(2044,'gil','dunn','1959262-6',1,'2024-01-02 21:43:44','2024-01-02 21:43:44',8,34),(2045,'forrest','phillips','8411816-8',1,'2024-01-02 21:43:44','2024-01-02 21:43:44',7,35),(2046,'armand','mcgowan','30740642-k',0,'2024-01-02 21:43:44','2024-01-02 21:43:44',6,36),(2047,'connor','combs','31108434-8',0,'2024-01-02 21:43:44','2024-01-02 21:43:44',4,37),(2048,'uma','simmons','3653032-4',1,'2024-01-02 21:43:44','2024-01-02 21:43:44',1,38),(2049,'illiana','allen','17709609-1',0,'2024-01-02 21:43:45','2024-01-02 21:43:45',5,39),(2050,'igor','stokes','16205509-7',1,'2024-01-02 21:43:45','2024-01-02 21:43:45',1,40),(2051,'lareina','rosa','32222498-2',0,'2024-01-02 21:43:45','2024-01-02 21:43:45',4,41),(2052,'cody','stein','13121126-0',1,'2024-01-02 21:43:45','2024-01-02 21:43:45',7,42),(2053,'george','kirkland','20229613-0',0,'2024-01-02 21:43:45','2024-01-02 21:43:45',6,43),(2054,'rigel','spears','31893169-0',0,'2024-01-02 21:43:46','2024-01-02 21:43:46',3,44),(2055,'maggie','parks','31218992-5',0,'2024-01-02 21:43:46','2024-01-02 21:43:46',4,45),(2056,'cherokee','owens','16504761-3',1,'2024-01-02 21:43:46','2024-01-02 21:43:46',3,46),(2057,'constance','santana','1541710-2',0,'2024-01-02 21:43:46','2024-01-02 21:43:46',5,47),(2058,'castor','cervantes','25172457-1',1,'2024-01-02 21:43:46','2024-01-02 21:43:46',5,48),(2059,'alexa','oneil','47797913-0',0,'2024-01-02 21:43:47','2024-01-02 21:43:47',2,49),(2060,'erich','mcgee','42227159-7',0,'2024-01-02 21:43:47','2024-01-02 21:43:47',2,50),(2061,'roanna','mooney','63156-6',1,'2024-01-02 21:43:47','2024-01-02 21:43:47',3,51),(2062,'brett','espinoza','11627221-0',0,'2024-01-02 21:43:47','2024-01-02 21:43:47',3,52),(2063,'tatyana','jackson','15622305-0',1,'2024-01-02 21:43:47','2024-01-02 21:43:47',4,53),(2064,'charles','duncan','19595432-1',1,'2024-01-02 21:43:48','2024-01-02 21:43:48',3,54),(2065,'victoria','vincent','45978469-1',1,'2024-01-02 21:43:48','2024-01-02 21:43:48',5,55),(2066,'lacey','bowers','26298610-1',0,'2024-01-02 21:43:48','2024-01-02 21:43:48',4,56),(2067,'wing','davenport','29137972-9',0,'2024-01-02 21:43:48','2024-01-02 21:43:48',6,57),(2068,'channing','hart','21624801-5',0,'2024-01-02 21:43:48','2024-01-02 21:43:48',7,58),(2069,'ross','warren','1668224-1',0,'2024-01-02 21:43:48','2024-01-02 21:43:48',7,59),(2070,'timon','winters','13203391-9',1,'2024-01-02 21:43:49','2024-01-02 21:43:49',1,60),(2071,'branden','stein','9437192-9',0,'2024-01-02 21:43:49','2024-01-02 21:43:49',8,61),(2072,'nell','durham','7822781-8',1,'2024-01-02 21:43:49','2024-01-02 21:43:49',1,62),(2073,'maya','gray','17319617-2',1,'2024-01-02 21:43:49','2024-01-02 21:43:49',8,63),(2074,'gay','mendez','41557108-9',0,'2024-01-02 21:43:49','2024-01-02 21:43:49',8,64),(2075,'vincent','tyson','46824600-7',1,'2024-01-02 21:43:50','2024-01-02 21:43:50',3,65),(2076,'rigel','floyd','18217723-7',1,'2024-01-02 21:43:50','2024-01-02 21:43:50',8,66),(2077,'kiona','carver','12809256-0',0,'2024-01-02 21:43:50','2024-01-02 21:43:50',5,67),(2078,'hayden','reyes','34290605-2',0,'2024-01-02 21:43:50','2024-01-02 21:43:50',2,68),(2079,'lavinia','merrill','10352-7',1,'2024-01-02 21:43:50','2024-01-02 21:43:50',1,69),(2080,'inez','downs','17913675-9',1,'2024-01-02 21:43:51','2024-01-02 21:43:51',2,70),(2081,'wesley','foreman','867539-2',0,'2024-01-02 21:43:51','2024-01-02 21:43:51',6,71),(2082,'tallulah','jennings','24642361-k',0,'2024-01-02 21:43:51','2024-01-02 21:43:51',5,72),(2083,'alan','leach','42686125-9',0,'2024-01-02 21:43:51','2024-01-02 21:43:51',6,73),(2084,'bertha','gregory','3115298-4',0,'2024-01-02 21:43:51','2024-01-02 21:43:51',4,74),(2085,'walker','gamble','29788697-5',1,'2024-01-02 21:43:52','2024-01-02 21:43:52',4,75),(2086,'athena','nelson','35984852-8',1,'2024-01-02 21:43:52','2024-01-02 21:43:52',3,76),(2087,'megan','johnson','38360249-1',0,'2024-01-02 21:43:52','2024-01-02 21:43:52',1,77),(2088,'brendan','russo','39770644-3',1,'2024-01-02 21:43:52','2024-01-02 21:43:52',3,78),(2089,'cairo','grimes','37307663-5',0,'2024-01-02 21:43:52','2024-01-02 21:43:52',7,79),(2090,'nell','bray','26798594-4',1,'2024-01-02 21:43:53','2024-01-02 21:43:53',7,80),(2091,'riley','jackson','2020952-6',0,'2024-01-02 21:43:53','2024-01-02 21:43:53',3,81),(2092,'april','strong','27264921-9',0,'2024-01-02 21:43:53','2024-01-02 21:43:53',6,82),(2093,'maite','joyner','13396142-9',1,'2024-01-02 21:43:53','2024-01-02 21:43:53',7,83),(2094,'dillon','simpson','29733933-8',1,'2024-01-02 21:43:53','2024-01-02 21:43:53',4,84),(2095,'hadley','west','2467203-4',0,'2024-01-02 21:43:53','2024-01-02 21:43:53',1,85),(2096,'hammett','jennings','4694658-8',1,'2024-01-02 21:43:54','2024-01-02 21:43:54',6,86),(2097,'lilah','henson','8805321-4',1,'2024-01-02 21:43:54','2024-01-02 21:43:54',8,87),(2098,'yasir','pratt','43931269-6',0,'2024-01-02 21:43:54','2024-01-02 21:43:54',1,88),(2099,'quintessa','joyce','7448121-3',1,'2024-01-02 21:43:54','2024-01-02 21:43:54',4,89),(2100,'josephine','bolton','2187543-0',1,'2024-01-02 21:43:54','2024-01-02 21:43:54',2,90),(2101,'graham','vargas','11689896-9',1,'2024-01-02 21:43:55','2024-01-02 21:43:55',3,91),(2102,'elijah','wilkinson','2235199-0',1,'2024-01-02 21:43:55','2024-01-02 21:43:55',6,92),(2103,'guinevere','berg','47296931-5',0,'2024-01-02 21:43:55','2024-01-02 21:43:55',2,93),(2104,'xena','delgado','40474674-k',1,'2024-01-02 21:43:55','2024-01-02 21:43:55',8,94),(2105,'ryan','kramer','30746700-3',1,'2024-01-02 21:43:55','2024-01-02 21:43:55',2,95),(2106,'cecilia','campos','40473102-5',0,'2024-01-02 21:43:56','2024-01-02 21:43:56',6,96),(2107,'mackensie','sampson','7738852-4',0,'2024-01-02 21:43:56','2024-01-02 21:43:56',7,97),(2108,'yeo','lindsay','3192272-0',0,'2024-01-02 21:43:56','2024-01-02 21:43:56',6,98),(2109,'kimberly','walls','20760830-0',1,'2024-01-02 21:43:56','2024-01-02 21:43:56',8,99),(2110,'megan','gibson','25778544-0',0,'2024-01-02 21:43:56','2024-01-02 21:43:56',5,100),(2111,'nicolas','vasquez','22234323-2',1,'2024-01-25 00:46:36','2024-01-25 00:46:36',7,101),(2112,'jorge','gatica','13182324-k',1,'2024-01-25 00:47:38','2024-01-25 00:47:38',4,102);
/*!40000 ALTER TABLE `persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privilegio`
--

DROP TABLE IF EXISTS `privilegio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `privilegio` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_PRIVILEGIO_Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilegio`
--

LOCK TABLES `privilegio` WRITE;
/*!40000 ALTER TABLE `privilegio` DISABLE KEYS */;
INSERT INTO `privilegio` VALUES (1,'Usuario','Permisos para el mantenedor',1,'2023-12-25 18:01:40',NULL),(2,'Grupo','Permisos para el mantenedor',1,'2023-12-25 18:01:57',NULL),(3,'Empresa','Permisos para el mantenedor',1,'2023-12-25 18:02:17',NULL),(4,'Centro de Costo','Permisos para el mantenedor',1,'2023-12-25 18:02:17',NULL),(5,'Persona','Permisos para el mantenedor',1,'2023-12-25 18:02:51',NULL),(6,'Area','Permisos para el mantenedor',1,'2023-12-25 18:02:51',NULL),(7,'Flujo','Permisos para el mantenedor',1,'2023-12-25 18:02:51',NULL),(8,'Estado Flujo','Permisos para el mantenedor',1,'2023-12-25 18:02:51',NULL),(10,'Movimiento y Atributo','Permisos para el mantenedor',1,'2024-01-03 02:06:30',NULL),(12,'Solicitudes','Permisos para solicitudes',1,'2024-01-21 00:07:59',NULL);
/*!40000 ALTER TABLE `privilegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PersonaId` int(11) NOT NULL,
  `CentroCostoId` int(11) NOT NULL,
  `CostoSolicitud` int(11) NOT NULL,
  `FechaDesde` datetime NOT NULL,
  `FechaHasta` datetime NOT NULL,
  `UsuarioSolicitanteId` int(11) NOT NULL DEFAULT 1,
  `ConsolidadoMesId` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_SOLICITUD_PersonaId` (`PersonaId`),
  KEY `fk_SOLICITUD_CentroCostoId` (`CentroCostoId`),
  KEY `fk_SOLICITUD_ConsolidadoMesId` (`ConsolidadoMesId`),
  KEY `solicitud_usuario_FK` (`UsuarioSolicitanteId`),
  CONSTRAINT `fk_SOLICITUD_CentroCostoId` FOREIGN KEY (`CentroCostoId`) REFERENCES `centro_de_costo` (`Id`),
  CONSTRAINT `fk_SOLICITUD_ConsolidadoMesId` FOREIGN KEY (`ConsolidadoMesId`) REFERENCES `consolidado_mes` (`Id`),
  CONSTRAINT `fk_SOLICITUD_PersonaId` FOREIGN KEY (`PersonaId`) REFERENCES `persona` (`Id`),
  CONSTRAINT `solicitud_usuario_FK` FOREIGN KEY (`UsuarioSolicitanteId`) REFERENCES `usuario` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud`
--

LOCK TABLES `solicitud` WRITE;
/*!40000 ALTER TABLE `solicitud` DISABLE KEYS */;
INSERT INTO `solicitud` VALUES (70,2111,7,115000,'2024-01-25 00:00:00','2024-02-03 00:00:00',101,1,'2024-01-25 00:56:48','2024-01-25 00:56:48'),(71,2111,7,70000,'2024-01-25 00:00:00','2024-02-03 00:00:00',2,1,'2024-01-25 00:58:27','2024-01-25 00:58:27'),(72,2112,4,157456,'2024-01-25 00:00:00','2024-02-02 00:00:00',2,1,'2024-01-25 01:00:44','2024-01-25 01:00:44'),(73,2043,4,222456,'2024-01-25 00:00:00','2024-02-08 00:00:00',101,1,'2024-01-25 01:02:07','2024-01-25 01:02:07'),(74,2034,3,157456,'2024-01-31 00:00:00','2024-02-10 00:00:00',101,1,'2024-01-25 01:02:31','2024-01-25 01:02:31'),(75,2020,2,34000,'2024-01-25 00:00:00','2024-01-25 00:00:00',102,1,'2024-01-25 01:03:12','2024-01-25 01:03:12'),(76,2064,3,104000,'2024-02-08 00:00:00','2024-02-09 00:00:00',102,1,'2024-01-25 01:04:06','2024-01-25 01:04:06'),(77,2025,3,188456,'2024-02-15 00:00:00','2024-03-09 00:00:00',2,1,'2024-01-25 01:05:05','2024-01-25 01:05:05'),(78,2015,8,165000,'2024-02-21 00:00:00','2024-03-09 00:00:00',2,1,'2024-01-25 01:05:39','2024-01-25 01:05:39');
/*!40000 ALTER TABLE `solicitud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Email` varchar(50) NOT NULL,
  `GoogleId` int(11) DEFAULT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_USUARIO_Username` (`Username`),
  UNIQUE KEY `uc_USUARIO_Email` (`Email`),
  UNIQUE KEY `uc_USUARIO_GoogleId` (`GoogleId`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'valentin.salgado','$2y$12$26oLi3HmJKBG5OEZFeuS4ukMGnEVsXNCZgmWChh1ywgrjj7a5wyxC','valentin.salgado@virginiogomez.cl',NULL,1,'2024-01-02 21:31:56','2024-01-02 22:18:52'),(2,'raul.munoz','$2y$12$ujK.zk1FfIw7XbDMQmEvPuK0D7nBvSKNDHXE6dH6KT/EJ1whfFive','raul.munoz@virginiogomez.cl',NULL,1,'2024-01-02 21:39:13','2024-01-02 21:40:27'),(3,'patrick.montgomery','$2y$12$FPDP38vni6bpxglC7P6z0u8yZtUGe3C6YWtRCHj9Th2EroEOv0Lhu','p.montgomery3688@camanchaca.cl',NULL,1,'2024-01-02 21:43:38','2024-01-02 21:43:38'),(4,'keely.luna','$2y$12$UQ5UL5kHapL/s4LtLJVluuNpxV9Xhrzkup.lMrVj7gnLiQkdPo3vW','k-luna@camanchaca.cl',NULL,0,'2024-01-02 21:43:38','2024-01-02 21:43:38'),(5,'gray.rodriquez','$2y$12$caQgH7MdWhgbBfdfqFT2COvrg/nTHnX99bMMousY/uVG/H4PL6WAC','r_gray282@camanchaca.cl',NULL,1,'2024-01-02 21:43:38','2024-01-02 21:43:38'),(6,'gareth.york','$2y$12$nOI0RgioZtU9A9H6G3PzIOQIuShZ4yQpOdxEHUmJNb9cTR.CEf/cK','y-gareth@camanchaca.cl',NULL,1,'2024-01-02 21:43:38','2024-01-02 21:43:38'),(7,'elmo.reilly','$2y$12$Tzzth6/8VEj/CYKbJUJECO7Y7mnAV/NhcpvZH04iW6Hf9E9V50LUy','e_reilly2796@camanchaca.cl',NULL,0,'2024-01-02 21:43:39','2024-01-02 21:43:39'),(8,'ralph.solis','$2y$12$wCXOrcRd4v/7LJytbPxKle6nATI1j75xi0SkOLSm3aHpDiAVA5Vcy','solisralph@camanchaca.cl',NULL,0,'2024-01-02 21:43:39','2024-01-02 21:43:39'),(9,'abel.campbell','$2y$12$zbZMJIkuOxeVjvvVeGpAAehaStSn.fxTvC6Casy9c8PdhpPAd3FrG','abel-campbell8763@camanchaca.cl',NULL,1,'2024-01-02 21:43:39','2024-01-02 21:43:39'),(10,'charles.goodwin','$2y$12$IVlxKFB5qY1a3mZhRuTdfeiSQn8m2hr9PUgXKk4.NNBHUYf85Bgqu','c-goodwin2415@camanchaca.cl',NULL,1,'2024-01-02 21:43:39','2024-01-02 21:43:39'),(11,'levi.douglas','$2y$12$9JVIYFesSOj.wNKHlKIkYOgkOn/bQRdMrl7jeIXF18WVZPD8w/3Dm','levi.douglas2350@camanchaca.cl',NULL,0,'2024-01-02 21:43:39','2024-01-02 21:43:39'),(12,'shelley.townsend','$2y$12$nFY.2jiyvvxpST2TqH7sjOZBi4FwRS5OfzAw/LjN8aQi1g7g6b/Fy','townsendshelley@camanchaca.cl',NULL,0,'2024-01-02 21:43:40','2024-01-02 21:43:40'),(13,'ingrid.flynn','$2y$12$V.1/XcxWXL3r7.PsOmqE6u8hKs2iUZyRgcE7DcE3DdcLaea5u24au','i_flynn@camanchaca.cl',NULL,0,'2024-01-02 21:43:40','2024-01-02 21:43:40'),(14,'melinda.knowles','$2y$12$iPKTk0Xq2/OZJfyQDxjf/eKCu7url9y82UuEVNFz/yYLMTcIJgkOK','knowles_melinda896@camanchaca.cl',NULL,1,'2024-01-02 21:43:40','2024-01-02 21:43:40'),(15,'berk.barr','$2y$12$8.760UsS4q5C.kq.J5EehujMHVVVj/6MudscCC8yejnVMNgZJUQvS','barrberk9157@camanchaca.cl',NULL,1,'2024-01-02 21:43:40','2024-01-02 21:43:40'),(16,'lionel.blankenship','$2y$12$Tg9Wc9jJoaXcqy6JBd2Ck.dZ08aBvbeMQWw4WqfVKNbOE4ZmhS/Oi','blankenshiplionel@camanchaca.cl',NULL,0,'2024-01-02 21:43:40','2024-01-02 21:43:40'),(17,'colleen.kerr','$2y$12$W.g8ArXv8XAmYgWV3Fd6qezfMmXH.FIo3HeYGJzYDWmVwgOev5vOG','kerr-colleen@camanchaca.cl',NULL,0,'2024-01-02 21:43:40','2024-01-02 21:43:40'),(18,'ahmed.rowe','$2y$12$WZb1phA3I.of.UcLHp1zGueIGxF//87jo2bsFFnaYEfRrVwTgwKCe','rowe.ahmed@camanchaca.cl',NULL,1,'2024-01-02 21:43:41','2024-01-02 21:43:41'),(19,'philip.macdonald','$2y$12$Ai4HTFHRLfatvCzV8eBiGunGlQr5439//3vrjMlLGzn/AJ5yqw9H6','macdonaldphilip1861@camanchaca.cl',NULL,0,'2024-01-02 21:43:41','2024-01-02 21:43:41'),(20,'quail.wilkerson','$2y$12$DtIotfH9kP48ryIXswKjbu4Apn53MD0gKcVztJltosOgQLRG8VO0G','q.wilkerson6333@camanchaca.cl',NULL,1,'2024-01-02 21:43:41','2024-01-02 21:43:41'),(21,'aaron.pate','$2y$12$bBvZNMlg/6spbCvqvtilDeruK8Ak/9AWb3j.5CJr54S9vEOwRbOAO','aaron.pate@camanchaca.cl',NULL,1,'2024-01-02 21:43:41','2024-01-03 00:56:04'),(22,'elton.dodson','$2y$12$CIHDpmWWx3xkA4iU7TeZ6OJ3eVywYFTjeAIGr/sQxCnHVjJTsMZJ6','e.dodson1935@camanchaca.cl',NULL,1,'2024-01-02 21:43:41','2024-01-02 21:43:41'),(23,'drake.crawford','$2y$12$JzEJ1fr4CZWk7stXi0LAIuX6UKKOiNA4uLoGDo0JWZlXwGVtxKF0C','drake-crawford@camanchaca.cl',NULL,0,'2024-01-02 21:43:42','2024-01-02 21:43:42'),(24,'ella.alston','$2y$12$M97x0fWpx6H9J1O0iYEIVOzZkY9bjwOD9UsSwoXaJ9Eteflja6DtK','alstonella7627@camanchaca.cl',NULL,1,'2024-01-02 21:43:42','2024-01-02 21:43:42'),(25,'iris.holt','$2y$12$JPGWSeil3WKS87qSTWjYduzylF80vcquEu64dxzjW9uU303znD6XC','hiris7451@camanchaca.cl',NULL,1,'2024-01-02 21:43:42','2024-01-02 21:43:42'),(26,'stone.vinson','$2y$12$do1U1lgii46UHAEZCspxcequ/qNlXHDU8iA0n2.jrJX8aE1GsIXeG','vinson_stone8784@camanchaca.cl',NULL,1,'2024-01-02 21:43:42','2024-01-02 21:43:42'),(27,'otto.day','$2y$12$PUvZw.9isYiOi22S.RbGqev0bAHZgqacFWOOX7Rlz3DKPmAZNQZSm','o.day9623@camanchaca.cl',NULL,0,'2024-01-02 21:43:42','2024-01-02 21:43:42'),(28,'kato.sanchez','$2y$12$JQN7P1Ks0qPwviaZrEzj9uwu3iEMb69Y1iEfmz8xoTPTsxTUl13iG','k-sanchez@camanchaca.cl',NULL,0,'2024-01-02 21:43:43','2024-01-02 21:43:43'),(29,'norman.barrera','$2y$12$h5sJRpbM/WJB/xS10Itm2utBeAfe7UusetKcO.XCTtoZk85JDxUZ2','barrera_norman1211@camanchaca.cl',NULL,0,'2024-01-02 21:43:43','2024-01-02 21:43:43'),(30,'chester.buckner','$2y$12$T1WEpT8xeD9idpnGHat6SuxIG2fbHgBycsOej7ptc7Ep3eERXsO2K','buckner.chester@camanchaca.cl',NULL,1,'2024-01-02 21:43:43','2024-01-02 21:43:43'),(31,'jerome.britt','$2y$12$5qS98PdGUwBUyZaohW5.xu7Vyg1.VQhAx4YIG4Dd2vl0Mc6uqGghC','b.jerome5790@camanchaca.cl',NULL,1,'2024-01-02 21:43:43','2024-01-02 21:43:43'),(32,'julie.chen','$2y$12$p6K1tLPoUnF5yLahsjkmm.vrmYppRmW6.dnQ3zjJu1tVMRvzLBcWy','c_julie1600@camanchaca.cl',NULL,0,'2024-01-02 21:43:43','2024-01-02 21:43:43'),(33,'carlos.guthrie','$2y$12$e5QAC3TZ.WdqoJ/jL97Ce..nuu/RV7k9QYZju0d1dIz0mWDrefutO','gcarlos@camanchaca.cl',NULL,1,'2024-01-02 21:43:44','2024-01-02 21:43:44'),(34,'gil.dunn','$2y$12$lIQWSj0vZQ.JKI3576DhLeC7wWtdzpW420RZlvezlvFLmx2lWdiT.','dunn_gil2185@camanchaca.cl',NULL,1,'2024-01-02 21:43:44','2024-01-02 21:43:44'),(35,'forrest.phillips','$2y$12$rjiY9o0/txVzhOvXhhByMe.ZmkEmeXowjO2be23UZe/OdV6JFARb6','fphillips8878@camanchaca.cl',NULL,1,'2024-01-02 21:43:44','2024-01-02 21:43:44'),(36,'armand.mcgowan','$2y$12$cM1lvqf91PXucrGgDQDOEeZc7XQfff3FCFvUjrswIP7ddkcSv0cXu','mcgowanarmand3662@camanchaca.cl',NULL,0,'2024-01-02 21:43:44','2024-01-02 21:43:44'),(37,'connor.combs','$2y$12$AsExGiFo4YokC1npA1LLZumKVjmqT.HB192AOTQnwguTF0y/wynZK','c.combs3025@camanchaca.cl',NULL,0,'2024-01-02 21:43:44','2024-01-02 21:43:44'),(38,'uma.simmons','$2y$12$hO0HTvxHoIIAK.N575ybxuoaxHLieduO1sgQOaw0k9.ySqY/VOXKe','umasimmons2769@camanchaca.cl',NULL,1,'2024-01-02 21:43:44','2024-01-02 21:43:44'),(39,'illiana.allen','$2y$12$wYoW/CM6WpDgDvKQy7voxOXG3ZNXfQNHNUC3yN0X.tpwBbyEPNm/y','allen_illiana@camanchaca.cl',NULL,0,'2024-01-02 21:43:45','2024-01-02 21:43:45'),(40,'igor.stokes','$2y$12$2Z50NhZhpbnF88bRZt3AF.6zwFnXTbIgL9T2OjXZuPxPdvAt2fZB.','stokes_igor5122@camanchaca.cl',NULL,1,'2024-01-02 21:43:45','2024-01-02 21:43:45'),(41,'lareina.rosa','$2y$12$9q4H1aMZdvyMhP8feec/XuXWkLmv6T4Tyy7yBy08o75RXQ4KUF/oO','rlareina@camanchaca.cl',NULL,0,'2024-01-02 21:43:45','2024-01-02 21:43:45'),(42,'cody.stein','$2y$12$.TGgHxHmd5jW3P3suuIVS.9lOSeChuHzjezK.35D1rMq4.CYFtI0i','cstein@camanchaca.cl',NULL,1,'2024-01-02 21:43:45','2024-01-02 21:43:45'),(43,'george.kirkland','$2y$12$RzQFANGWOF4/NrpilIhSdutl.w2T/URIcFvipnUUetaW4yFgDHdou','g-kirkland@camanchaca.cl',NULL,0,'2024-01-02 21:43:45','2024-01-02 21:43:45'),(44,'rigel.spears','$2y$12$FDa.OvALFhoy467WJJnRdeDXqzAyiQ2ap44jiWeECfuweJ4.vDFmu','s_rigel@camanchaca.cl',NULL,0,'2024-01-02 21:43:46','2024-01-02 21:43:46'),(45,'maggie.parks','$2y$12$J0LYgKVvZ9634WVouLtYc.RBRIZ6zzXbGFNToud7ZdNGHopCpZZda','parks.maggie@camanchaca.cl',NULL,0,'2024-01-02 21:43:46','2024-01-02 21:43:46'),(46,'cherokee.owens','$2y$12$KXCP05vLH9EqtfWLcrhqD.SVBa.bBr6HrvCeANr05hgsWGxCaCP4a','o-cherokee9296@camanchaca.cl',NULL,1,'2024-01-02 21:43:46','2024-01-02 21:43:46'),(47,'constance.santana','$2y$12$/VVyYvkwbnE8wuUW/RpCueqwDrSOm/sVgXA4YiqIWIhk.S8X5I/8W','santana.constance4188@camanchaca.cl',NULL,0,'2024-01-02 21:43:46','2024-01-02 21:43:46'),(48,'castor.cervantes','$2y$12$k9clhkKHRpZES2mPocSl9eeorbVvz1m1xKgjgkjnNV5JD1spzZwG6','cervantes.castor@camanchaca.cl',NULL,1,'2024-01-02 21:43:46','2024-01-02 21:43:46'),(49,'alexa.oneil','$2y$12$tNqJTaWSjV7IvCno8Yxm.ehh9cUZpW2GvaHsul80hLvwcF6Rizy9a','aoneil4432@camanchaca.cl',NULL,0,'2024-01-02 21:43:47','2024-01-02 21:43:47'),(50,'erich.mcgee','$2y$12$i/uhM7DRzzJifm0U9oJkM.tVZlulkELOA4q75tvqLh8CyoY6OkFZ6','m.erich@camanchaca.cl',NULL,0,'2024-01-02 21:43:47','2024-01-02 21:43:47'),(51,'roanna.mooney','$2y$12$CLNZZMfN98kqJ5QdswtH0eBAOdCTSy9z60ZQVx1.C6R3CUEpsk0Vu','roannamooney@camanchaca.cl',NULL,1,'2024-01-02 21:43:47','2024-01-02 21:43:47'),(52,'brett.espinoza','$2y$12$kQjWn7TUrlQ30oAnHyhdDubf0HMhPBFKqpnwNyuINX7qpgb/T7UvC','brett_espinoza@camanchaca.cl',NULL,0,'2024-01-02 21:43:47','2024-01-02 21:43:47'),(53,'tatyana.jackson','$2y$12$VZaMgTHg.5SIGliEqk/y8OCrcEJ9GXrWjamCE38uAym79mi5EXYku','t.jackson3667@camanchaca.cl',NULL,1,'2024-01-02 21:43:47','2024-01-02 21:43:47'),(54,'charles.duncan','$2y$12$CQEPdIKhkjsFdozvAnlyTu6BsC5qoVHUzC7FMBKcMXhC6kXSHkO6y','charles.duncan@camanchaca.cl',NULL,1,'2024-01-02 21:43:48','2024-01-02 21:43:48'),(55,'victoria.vincent','$2y$12$0fZ3FVwWB9yyW8GwsegK8OZIHBofZwYy44bgZqSzFb3VUiN64EHvK','v.vincent@camanchaca.cl',NULL,1,'2024-01-02 21:43:48','2024-01-02 21:43:48'),(56,'lacey.bowers','$2y$12$DyxGM..Nw/i/JJt/CWUnNuw8P8ggRwcJFPcv7yyTMZ2f8GhJ1Gxcu','l-bowers@camanchaca.cl',NULL,0,'2024-01-02 21:43:48','2024-01-02 21:43:48'),(57,'wing.davenport','$2y$12$8kr75macPDxc./xjEFuMyOnLwM1slpHS4q35MGfdWoLuEfoHxKumG','wdavenport7874@camanchaca.cl',NULL,0,'2024-01-02 21:43:48','2024-01-02 21:43:48'),(58,'channing.hart','$2y$12$1n/9vfwK54euTD9JZo9sD.huoSvDf8S3KCM6DpjELLTdnTD/CxSA2','hart.channing@camanchaca.cl',NULL,0,'2024-01-02 21:43:48','2024-01-02 21:43:48'),(59,'ross.warren','$2y$12$jU5hLC39CUYuIJZOtEsgrO52Faqm6HaI7Gmv4zjz2Opj8CK/N23n6','rwarren@camanchaca.cl',NULL,0,'2024-01-02 21:43:48','2024-01-02 21:43:48'),(60,'timon.winters','$2y$12$sPKFkgBZLX0TzJ6wtQD4o.J3Iz/oWyjPmHw.Eo1hyi8spRtJJq3d.','timon-winters@camanchaca.cl',NULL,1,'2024-01-02 21:43:49','2024-01-02 21:43:49'),(61,'branden.stein','$2y$12$9UugCRGmx4dKAOhqI5/iMOtht1PyQxPFhVH8gk/tZv0T8uadM9o0.','b_stein@camanchaca.cl',NULL,0,'2024-01-02 21:43:49','2024-01-02 21:43:49'),(62,'nell.durham','$2y$12$OwkPqS.Wa/6l34zIv4Fo.uuqSwggIwxJ3sFaNT3jgjYMXr2mrQbOW','nell_durham@camanchaca.cl',NULL,1,'2024-01-02 21:43:49','2024-01-02 21:43:49'),(63,'maya.gray','$2y$12$2lMYzhdiFKybJ730.XVsEuy9GYr/wlfi7fJNqHEmVV12z06MvN44m','gray-maya@camanchaca.cl',NULL,1,'2024-01-02 21:43:49','2024-01-02 21:43:49'),(64,'gay.mendez','$2y$12$Ula9cgXxWfeCLfies21mHu2tAuEnfXv/wH8vrmcXf9looYVT/rUvO','g.mendez8298@camanchaca.cl',NULL,0,'2024-01-02 21:43:49','2024-01-02 21:43:49'),(65,'vincent.tyson','$2y$12$pUgMDCUVpNgi2tOHgGdsZ.QeEePEZQ.1W47l7xfl3DVLVi.DD9.Em','tyson.vincent890@camanchaca.cl',NULL,1,'2024-01-02 21:43:50','2024-01-02 21:43:50'),(66,'rigel.floyd','$2y$12$Izidwfu5mU4Rbdlv4nsYmuT0qSPkVCH8aQAKj.inentDBB.iv7fHe','r.floyd@camanchaca.cl',NULL,1,'2024-01-02 21:43:50','2024-01-02 21:43:50'),(67,'kiona.carver','$2y$12$3DTydkxd8Ggmd06aaF6lfeSGDZ402IgXhqDrrL4KRVjnhG8EXBbB6','carverkiona@camanchaca.cl',NULL,0,'2024-01-02 21:43:50','2024-01-02 21:43:50'),(68,'hayden.reyes','$2y$12$2SyQStfhAeLz.AWxlAEqF.tZaEK2NPPp8LKJOE7eZxUQmt5WTy.5K','r_hayden8201@camanchaca.cl',NULL,0,'2024-01-02 21:43:50','2024-01-02 21:43:50'),(69,'lavinia.merrill','$2y$12$nWgPIGVNvbhhmtJk5Z7Ho.Do4cKOHBR8udFLjLu2z/C1jV.8Oxu8u','l.merrill4573@camanchaca.cl',NULL,1,'2024-01-02 21:43:50','2024-01-02 21:43:50'),(70,'inez.downs','$2y$12$fJK8mUhYvFVkUmmmi0RiuOna1oySr0eznmu9FilgddNEcsB6DJBPC','i.downs4942@camanchaca.cl',NULL,1,'2024-01-02 21:43:51','2024-01-02 21:43:51'),(71,'wesley.foreman','$2y$12$B3CrceNhxv..VDPVcrXNp.o0WvhS2jWbgk48nb.F/C5g50vzxGSFO','wesley.foreman@camanchaca.cl',NULL,0,'2024-01-02 21:43:51','2024-01-02 21:43:51'),(72,'tallulah.jennings','$2y$12$OiPdLPdT0Fbxj5UO5YkXxOUTOk07siPa.79zV34WJlueFqX1I7iVi','tjennings@camanchaca.cl',NULL,0,'2024-01-02 21:43:51','2024-01-02 21:43:51'),(73,'alan.leach','$2y$12$IXl1TAcEzOmvfEsy1GOVmepEZldJNWsjNxSSBwtU0lunvPcEOhpMm','leachalan@camanchaca.cl',NULL,0,'2024-01-02 21:43:51','2024-01-02 21:43:51'),(74,'bertha.gregory','$2y$12$aOY4Dgg/sRK2exXcHNbFb.vkJu8rwkKP4093EGhb2hSu0M6hAW7im','bertha.gregory@camanchaca.cl',NULL,0,'2024-01-02 21:43:51','2024-01-02 21:43:51'),(75,'walker.gamble','$2y$12$4KE9Y94CAi9p9GLq0.4aYebgkO1Zkh6Z9ZZs2VzczaUnDTY0Y//lG','g_walker@camanchaca.cl',NULL,1,'2024-01-02 21:43:52','2024-01-02 21:43:52'),(76,'athena.nelson','$2y$12$gIK/9m4mECxmfK3vmAoeIOAzcDohVKS/eCh2Mb5BSHxMMTr4KReKi','nelson-athena@camanchaca.cl',NULL,1,'2024-01-02 21:43:52','2024-01-02 21:43:52'),(77,'megan.johnson','$2y$12$LHIdMPfAyceAyeAQulG1Ku05HqSOJGDqxFN1kBfz5Hbu09qw4Rof6','johnson_megan2096@camanchaca.cl',NULL,0,'2024-01-02 21:43:52','2024-01-02 21:43:52'),(78,'brendan.russo','$2y$12$NWZUdcaq2hag8y6bLA7tKO.Z2lAK/dr9B5RZ4qQsmt6.d8vlWa8bi','russo.brendan3172@camanchaca.cl',NULL,1,'2024-01-02 21:43:52','2024-01-02 21:43:52'),(79,'cairo.grimes','$2y$12$kBKwQ10LK6EEpcfDhSLVe.BaCjgzQjCiCdgbQmRtiBC03y.Ksqjau','cgrimes@camanchaca.cl',NULL,0,'2024-01-02 21:43:52','2024-01-02 21:43:52'),(80,'nell.bray','$2y$12$LApzX6ReMPTl/dZmsRxaRecY.CKs6L.HYDt0K921WrxjQ9YK8YFAy','n.bray@camanchaca.cl',NULL,1,'2024-01-02 21:43:53','2024-01-02 21:43:53'),(81,'riley.jackson','$2y$12$clgKKLZRvnK1Z8G6PWWDV.RvjVaRDm91k5OwXW7eDn07bSfQyE4na','riley.jackson@camanchaca.cl',NULL,0,'2024-01-02 21:43:53','2024-01-02 21:43:53'),(82,'april.strong','$2y$12$b1Itt3VhSnEZiIvj0hztFeimCFBBivILdSOXR0HVrkjPy4uL9ydDa','strong.april@camanchaca.cl',NULL,0,'2024-01-02 21:43:53','2024-01-02 21:43:53'),(83,'maite.joyner','$2y$12$eQCdnjNd39yfQZw0WtmcPeuy4ZP0RmGl2etm3.EwDljWfQEa6vHD.','mjoyner@camanchaca.cl',NULL,1,'2024-01-02 21:43:53','2024-01-02 21:43:53'),(84,'dillon.simpson','$2y$12$3B5Yh04cajdq8UNNcK6/I.5K4fGEj4ebkqJRTfG72ugAOl.0IMMCm','s_dillon584@camanchaca.cl',NULL,1,'2024-01-02 21:43:53','2024-01-02 21:43:53'),(85,'hadley.west','$2y$12$jqNl65SsBPMv.7AhJz6AFeXUJRsmQptuuWOFeCnGBAADEFWPQCnr6','w-hadley7275@camanchaca.cl',NULL,0,'2024-01-02 21:43:53','2024-01-02 21:43:53'),(86,'hammett.jennings','$2y$12$eKNSAlVfVJr/bSGwIxXZ8e.U0lFFyhpNudb9NiG5HlK3doxdJmBUi','jenningshammett2909@camanchaca.cl',NULL,1,'2024-01-02 21:43:54','2024-01-02 21:43:54'),(87,'lilah.henson','$2y$12$HPd8kaK7WSIjnyWHx/mX1.ky6yfl853j.fvaPD5LWxSF4YsbErn16','hensonlilah2839@camanchaca.cl',NULL,1,'2024-01-02 21:43:54','2024-01-02 21:43:54'),(88,'yasir.pratt','$2y$12$/XIJL2/LZe4tTvHJW6m5f.x8hdorz1rob8QzbhWcGqUd/9f0xcaKy','ypratt@camanchaca.cl',NULL,0,'2024-01-02 21:43:54','2024-01-02 21:43:54'),(89,'quintessa.joyce','$2y$12$0FT1lUqX03zop2Zg41adSulZLKn8HU/geOrHgiJHx8jH2vhsj8xoe','joyce-quintessa@camanchaca.cl',NULL,1,'2024-01-02 21:43:54','2024-01-02 21:43:54'),(90,'josephine.bolton','$2y$12$CJh./WvzijVgYuNgeyFaY.xl4jpqw4PfEXASbrtLEzbepUPlZV.jq','bolton.josephine1938@camanchaca.cl',NULL,1,'2024-01-02 21:43:54','2024-01-02 21:43:54'),(91,'graham.vargas','$2y$12$ybPZsqmEafZBu1mQBcP3AOgzbXR9/ZlL/Ml20mAPuMqYOoQfLMopm','v-graham@camanchaca.cl',NULL,1,'2024-01-02 21:43:55','2024-01-02 21:43:55'),(92,'elijah.wilkinson','$2y$12$e5PKVg/oiErQw9Ip4pfm..7U/Jk.Wfgh9Dnz58zWnQdbHS0sd9Ju6','wilkinsonelijah9929@camanchaca.cl',NULL,1,'2024-01-02 21:43:55','2024-01-02 21:43:55'),(93,'guinevere.berg','$2y$12$gquspQGmK347hBdNdUZ6y.gwywB2SW6CRx1UTjFPiqaaHoPL.wzFi','guinevereberg8096@camanchaca.cl',NULL,0,'2024-01-02 21:43:55','2024-01-02 21:43:55'),(94,'xena.delgado','$2y$12$sln6/IudT6zNGKZvRpW6IO75m20wReM7euGkBOqZZepnJ6jWhhdv2','dxena@camanchaca.cl',NULL,1,'2024-01-02 21:43:55','2024-01-02 21:43:55'),(95,'ryan.kramer','$2y$12$ro/oNx8xMZBK1mw.Td631.9d3RpMV/wvB0AgKz3VYSgl39THXmxOm','kramer.ryan@camanchaca.cl',NULL,1,'2024-01-02 21:43:55','2024-01-02 21:43:55'),(96,'cecilia.campos','$2y$12$E/C5x1GKXbP.jP3nn3QWler9qX8X1Ip4vRZGk2hcaOqAPtJC7EGmm','c-cecilia@camanchaca.cl',NULL,0,'2024-01-02 21:43:56','2024-01-02 21:43:56'),(97,'mackensie.sampson','$2y$12$IDC58j/Jsj88PNhCpcmDK.4mrXgECrfiDugdmvGr81Nq6hpX1mDKi','s_mackensie2031@camanchaca.cl',NULL,0,'2024-01-02 21:43:56','2024-01-02 21:43:56'),(98,'yeo.lindsay','$2y$12$/PW.CMizyJYL6cGuTBoTYeFAn.Z/LQAHdcNQctGHiyJMgnCTDDRr.','ylindsay1332@camanchaca.cl',NULL,0,'2024-01-02 21:43:56','2024-01-02 21:43:56'),(99,'kimberly.walls','$2y$12$H8aN/PwQ.a3k6iGX8hHYuebGGfSgapudsanZUf4WQs2Ufa32.1Wr2','w-kimberly@camanchaca.cl',NULL,1,'2024-01-02 21:43:56','2024-01-02 21:43:56'),(100,'megan.gibson','$2y$12$pgp66Io.Zj2cf.OoIcCR/uJvAfCWfdp6h4FoiylUvNgqHYJ//06z2','gibsonmegan3068@camanchaca.cl',NULL,0,'2024-01-02 21:43:56','2024-01-02 21:43:56'),(101,'nicolas.vasquez','$2y$12$iPyJhFx.ZZVG.BVng7nl4.17Rwu8QSoNjBjOWQmibRRZt2RHteMJS','nicolas.vasquez@camanchaca.cl',NULL,1,'2024-01-25 00:46:36','2024-01-25 00:46:36'),(102,'jorge.gatica','$2y$12$c3wiiWaDMY3srcrgTBMyM.H4JxMrUn1xcP8PZFT/kEoCfQIPKkPoS','jorge.gatica@camanchaca.cl',NULL,1,'2024-01-25 00:47:38','2024-01-25 00:47:38');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_grupo`
--

DROP TABLE IF EXISTS `usuario_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario_grupo` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `UsuarioId` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_USUARIO_GRUPO_UsuarioId` (`UsuarioId`),
  KEY `fk_USUARIO_GRUPO_GrupoId` (`GrupoId`),
  CONSTRAINT `fk_USUARIO_GRUPO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`),
  CONSTRAINT `fk_USUARIO_GRUPO_UsuarioId` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_grupo`
--

LOCK TABLES `usuario_grupo` WRITE;
/*!40000 ALTER TABLE `usuario_grupo` DISABLE KEYS */;
INSERT INTO `usuario_grupo` VALUES (6,1,'2024-01-02 22:13:49','2024-01-02 22:13:49',2,5),(7,0,'2024-01-02 22:14:08','2024-01-23 17:23:30',1,5),(8,1,'2024-01-02 22:15:20','2024-01-02 22:15:20',21,2),(19,1,'2024-01-19 17:14:41','2024-01-19 17:14:41',2,1),(20,1,'2024-01-19 17:14:45','2024-01-19 17:14:45',2,7),(22,1,'2024-01-22 11:56:09','2024-01-22 11:56:09',1,2),(25,1,'2024-01-24 19:20:24','2024-01-24 19:20:24',21,5),(27,1,'2024-01-25 00:49:07','2024-01-25 00:49:07',102,7),(28,1,'2024-01-25 00:49:34','2024-01-25 00:49:34',101,2),(29,1,'2024-01-25 01:01:08','2024-01-25 01:01:08',102,5);
/*!40000 ALTER TABLE `usuario_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'serviciosgenerales'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-25  1:06:14
