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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
INSERT INTO `area` VALUES (1,'area 1','descripcion area 1',1,'2023-12-24 14:09:24','2023-12-24 14:39:15'),(2,'area 2','Descripcion Area 2',0,'2023-12-24 14:09:44','2023-12-24 14:39:09'),(3,'area 3','Descripcion Area 3',1,'2023-12-24 14:24:33','2023-12-24 14:39:28');
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
  `ValorReferencia` int(11) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_ATRIBUTO_Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atributo`
--

LOCK TABLES `atributo` WRITE;
/*!40000 ALTER TABLE `atributo` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_de_costo`
--

LOCK TABLES `centro_de_costo` WRITE;
/*!40000 ALTER TABLE `centro_de_costo` DISABLE KEYS */;
INSERT INTO `centro_de_costo` VALUES (1,'Centro de Costo 1',0,'2023-12-24 17:14:17',NULL,1),(3,'Centro de Costo 2',0,'2023-12-24 17:14:41','2023-12-24 18:12:49',1),(4,'centro de costo 3',1,'2023-12-24 18:04:44','2023-12-24 18:04:44',1),(5,'centro de costo 4',1,'2023-12-24 18:05:25','2023-12-24 18:05:25',2),(6,'centro de costo 7',1,'2023-12-24 18:14:24','2023-12-24 18:14:24',9);
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
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `MovimientoAtributoId` int(11) NOT NULL,
  `SolicitudId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_COMPUESTA_MovimientoAtributoId` (`MovimientoAtributoId`),
  KEY `fk_COMPUESTA_SolicitudId` (`SolicitudId`),
  CONSTRAINT `fk_COMPUESTA_MovimientoAtributoId` FOREIGN KEY (`MovimientoAtributoId`) REFERENCES `movimiento_atributo` (`Id`),
  CONSTRAINT `fk_COMPUESTA_SolicitudId` FOREIGN KEY (`SolicitudId`) REFERENCES `solicitud` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compuesta`
--

LOCK TABLES `compuesta` WRITE;
/*!40000 ALTER TABLE `compuesta` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consolidado_mes`
--

LOCK TABLES `consolidado_mes` WRITE;
/*!40000 ALTER TABLE `consolidado_mes` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` VALUES (1,'empresa 1','54234954-9','empresa@empresa.cl',1,'2023-12-24 14:50:45','2023-12-24 16:37:58'),(2,'empresa 2','34233233-1','empresa2@empresa.cl',0,'2023-12-24 14:51:08','2023-12-24 18:05:38'),(9,'empresa 3','17460605-6','sdfsd@dsada.cl',1,'2023-12-24 16:14:40','2023-12-24 16:14:40'),(10,'empresa 4','17460602-1','dsadsa@dsdas.cl',0,'2023-12-24 16:15:31','2023-12-24 16:15:31');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_consolidado`
--

LOCK TABLES `estado_consolidado` WRITE;
/*!40000 ALTER TABLE `estado_consolidado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado_consolidado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado_solicitud`
--

DROP TABLE IF EXISTS `estado_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estado_solicitud` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_ESTADO_SOLICITUD_Nombre` (`Nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_solicitud`
--

LOCK TABLES `estado_solicitud` WRITE;
/*!40000 ALTER TABLE `estado_solicitud` DISABLE KEYS */;
INSERT INTO `estado_solicitud` VALUES (1,'solicitado',1,'2023-12-25 14:17:47','2023-12-25 14:17:47'),(2,'en tramite',1,'2023-12-25 14:19:02','2023-12-25 14:19:40'),(3,'aceptado',0,'2023-12-25 14:19:13','2023-12-25 14:19:45'),(4,'rechazado',1,'2023-12-25 14:19:22','2023-12-25 14:19:22');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flujo`
--

LOCK TABLES `flujo` WRITE;
/*!40000 ALTER TABLE `flujo` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` VALUES (1,'grupo 1','Grupo 1',0,'2023-12-25 18:16:51','2023-12-26 16:59:20'),(2,'grupo 2','Grupo 2',1,'2023-12-25 18:16:51','2023-12-26 15:19:45'),(5,'administrador','administrado',1,'2023-12-26 01:48:12','2023-12-26 01:48:12');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_privilegio`
--

LOCK TABLES `grupo_privilegio` WRITE;
/*!40000 ALTER TABLE `grupo_privilegio` DISABLE KEYS */;
INSERT INTO `grupo_privilegio` VALUES (7,'2023-12-26 01:48:12','2023-12-26 05:00:09',5,1,0,0,0,1),(8,'2023-12-26 01:48:12','2023-12-26 04:51:17',5,2,0,1,1,1),(9,'2023-12-26 01:48:12','2023-12-26 04:54:03',5,3,0,0,0,0),(10,'2023-12-26 01:48:12','2023-12-26 04:54:03',5,4,1,1,0,0),(11,'2023-12-26 01:48:12','2023-12-26 04:50:48',5,5,0,0,0,1),(12,'2023-12-26 01:48:12','2023-12-26 04:54:11',5,6,1,1,1,1),(13,'2023-12-26 01:48:12','2023-12-26 04:50:48',5,7,0,0,0,1),(14,'2023-12-26 01:48:12','2023-12-26 04:51:17',5,8,1,1,1,1),(15,'2023-12-26 05:06:49','2023-12-26 16:59:30',1,1,1,1,0,0),(16,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,2,0,1,0,0),(18,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,3,0,0,1,1),(19,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,4,0,0,1,0),(20,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,5,0,1,0,0),(21,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,6,1,0,0,0),(22,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,7,0,1,0,0),(23,'2023-12-26 05:06:49','2023-12-26 05:08:00',1,8,0,0,1,0),(24,'2023-12-26 05:07:43','2023-12-26 14:57:38',2,1,0,1,1,0),(25,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,2,0,1,0,0),(26,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,3,0,0,1,0),(27,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,4,0,1,0,0),(28,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,5,0,0,0,1),(29,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,6,0,0,0,1),(30,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,7,1,0,0,0),(31,'2023-12-26 05:07:43','2023-12-26 05:08:17',2,8,0,1,1,0);
/*!40000 ALTER TABLE `grupo_privilegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `grupo_recurso`
--

DROP TABLE IF EXISTS `grupo_recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `grupo_recurso` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `GrupoId` int(11) NOT NULL,
  `PrivilegioId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_GRUPO_RECURSO_GrupoId` (`GrupoId`),
  KEY `fk_GRUPO_RECURSO_PrivilegioId` (`PrivilegioId`),
  CONSTRAINT `fk_GRUPO_RECURSO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`),
  CONSTRAINT `fk_GRUPO_RECURSO_PrivilegioId` FOREIGN KEY (`PrivilegioId`) REFERENCES `recurso` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_recurso`
--

LOCK TABLES `grupo_recurso` WRITE;
/*!40000 ALTER TABLE `grupo_recurso` DISABLE KEYS */;
/*!40000 ALTER TABLE `grupo_recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial_solicitud`
--

DROP TABLE IF EXISTS `historial_solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial_solicitud` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `UsuarioId` int(11) NOT NULL,
  `EstadoSolicitudId` int(11) NOT NULL,
  `SolicitudId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_HISTORIAL_SOLICITUD_UsuarioId` (`UsuarioId`),
  KEY `fk_HISTORIAL_SOLICITUD_EstadoSolicitudId` (`EstadoSolicitudId`),
  KEY `fk_HISTORIAL_SOLICITUD_SolicitudId` (`SolicitudId`),
  CONSTRAINT `fk_HISTORIAL_SOLICITUD_EstadoSolicitudId` FOREIGN KEY (`EstadoSolicitudId`) REFERENCES `estado_solicitud` (`Id`),
  CONSTRAINT `fk_HISTORIAL_SOLICITUD_SolicitudId` FOREIGN KEY (`SolicitudId`) REFERENCES `solicitud` (`Id`),
  CONSTRAINT `fk_HISTORIAL_SOLICITUD_UsuarioId` FOREIGN KEY (`UsuarioId`) REFERENCES `usuario` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial_solicitud`
--

LOCK TABLES `historial_solicitud` WRITE;
/*!40000 ALTER TABLE `historial_solicitud` DISABLE KEYS */;
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
  `Contexto` varchar(255) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
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
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `FlujoId` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_MOVIMIENTO_Nombre` (`Nombre`),
  KEY `fk_MOVIMIENTO_FlujoId` (`FlujoId`),
  KEY `fk_MOVIMIENTO_GrupoId` (`GrupoId`),
  CONSTRAINT `fk_MOVIMIENTO_FlujoId` FOREIGN KEY (`FlujoId`) REFERENCES `flujo` (`Id`),
  CONSTRAINT `fk_MOVIMIENTO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento`
--

LOCK TABLES `movimiento` WRITE;
/*!40000 ALTER TABLE `movimiento` DISABLE KEYS */;
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
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `MovimientoId` int(11) NOT NULL,
  `AtributoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_MOVIMIENTO_ATRIBUTO_MovimientoId` (`MovimientoId`),
  KEY `fk_MOVIMIENTO_ATRIBUTO_AtributoId` (`AtributoId`),
  CONSTRAINT `fk_MOVIMIENTO_ATRIBUTO_AtributoId` FOREIGN KEY (`AtributoId`) REFERENCES `atributo` (`Id`),
  CONSTRAINT `fk_MOVIMIENTO_ATRIBUTO_MovimientoId` FOREIGN KEY (`MovimientoId`) REFERENCES `movimiento` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movimiento_atributo`
--

LOCK TABLES `movimiento_atributo` WRITE;
/*!40000 ALTER TABLE `movimiento_atributo` DISABLE KEYS */;
/*!40000 ALTER TABLE `movimiento_atributo` ENABLE KEYS */;
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
  `AtrasId` int(11) DEFAULT NULL,
  `FlujoId` int(11) NOT NULL,
  `EstadoSolicitudId` int(11) NOT NULL,
  `GrupoId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_ORDEN_FLUJO_AtrasId` (`AtrasId`),
  KEY `fk_ORDEN_FLUJO_FlujoId` (`FlujoId`),
  KEY `fk_ORDEN_FLUJO_EstadoSolicitudId` (`EstadoSolicitudId`),
  KEY `fk_ORDEN_FLUJO_GrupoId` (`GrupoId`),
  CONSTRAINT `fk_ORDEN_FLUJO_AtrasId` FOREIGN KEY (`AtrasId`) REFERENCES `orden_flujo` (`Id`),
  CONSTRAINT `fk_ORDEN_FLUJO_EstadoSolicitudId` FOREIGN KEY (`EstadoSolicitudId`) REFERENCES `estado_solicitud` (`Id`),
  CONSTRAINT `fk_ORDEN_FLUJO_FlujoId` FOREIGN KEY (`FlujoId`) REFERENCES `flujo` (`Id`),
  CONSTRAINT `fk_ORDEN_FLUJO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orden_flujo`
--

LOCK TABLES `orden_flujo` WRITE;
/*!40000 ALTER TABLE `orden_flujo` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
INSERT INTO `persona` VALUES (1,'nombres','apellidos','17460605-6',1,'2023-12-24 18:46:51','2023-12-25 17:24:35',5,4),(2,'nombe nombre','apellido apellido','21213234-9',0,'2023-12-24 18:47:21','2023-12-24 19:13:55',6,NULL),(5,'nombre tres','apellido tres','12323234-8',1,'2023-12-24 18:48:33','2023-12-24 19:14:18',5,1),(6,'nombre cuatro','apellido4','17460602-1',0,'2023-12-24 19:02:53','2023-12-24 19:15:42',4,NULL),(7,'name','lastname','17460607-2',1,'2023-12-25 15:27:36','2023-12-25 17:50:25',4,5),(8,'prueba','prueba','18434943-4',1,'2023-12-25 15:35:24','2023-12-25 17:19:12',3,6),(9,'nombre','apellido','18323432-3',0,'2023-12-25 15:42:27','2023-12-25 15:42:27',5,7);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilegio`
--

LOCK TABLES `privilegio` WRITE;
/*!40000 ALTER TABLE `privilegio` DISABLE KEYS */;
INSERT INTO `privilegio` VALUES (1,'Privilegio 1','Privilegio 1',1,'2023-12-25 18:01:40',NULL),(2,'Privilegio 2','Privilegio 2',1,'2023-12-25 18:01:57',NULL),(3,'Privilegio 3','Privilegio 3',1,'2023-12-25 18:02:17',NULL),(4,'Privilegio 4','Privilegio 4',1,'2023-12-25 18:02:17',NULL),(5,'Privilegio 5','Privilegio 5',1,'2023-12-25 18:02:51',NULL),(6,'Privilegio 6','Privilegio 6',1,'2023-12-25 18:02:51',NULL),(7,'Privilegio 7','Privilegio 7',1,'2023-12-25 18:02:51',NULL),(8,'Privilegio 8','Privilegio 9',1,'2023-12-25 18:02:51',NULL);
/*!40000 ALTER TABLE `privilegio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurso`
--

DROP TABLE IF EXISTS `recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recurso` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Descripcion` varchar(255) NOT NULL,
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_RECURSO_Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurso`
--

LOCK TABLES `recurso` WRITE;
/*!40000 ALTER TABLE `recurso` DISABLE KEYS */;
/*!40000 ALTER TABLE `recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solicitud`
--

DROP TABLE IF EXISTS `solicitud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solicitud` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CostoSolicitud` int(11) NOT NULL,
  `PersonaId` int(11) NOT NULL,
  `CentroCostoId` int(11) NOT NULL,
  `ConsolidadoMesId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_SOLICITUD_PersonaId` (`PersonaId`),
  KEY `fk_SOLICITUD_CentroCostoId` (`CentroCostoId`),
  KEY `fk_SOLICITUD_ConsolidadoMesId` (`ConsolidadoMesId`),
  CONSTRAINT `fk_SOLICITUD_CentroCostoId` FOREIGN KEY (`CentroCostoId`) REFERENCES `centro_de_costo` (`Id`),
  CONSTRAINT `fk_SOLICITUD_ConsolidadoMesId` FOREIGN KEY (`ConsolidadoMesId`) REFERENCES `consolidado_mes` (`Id`),
  CONSTRAINT `fk_SOLICITUD_PersonaId` FOREIGN KEY (`PersonaId`) REFERENCES `persona` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solicitud`
--

LOCK TABLES `solicitud` WRITE;
/*!40000 ALTER TABLE `solicitud` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'usuario','2321312','mail@mail.cl',NULL,1,'2023-12-24 18:48:57','2023-12-25 17:24:55'),(4,'usuario1','23123213','usuario@mail.cl',NULL,1,'2023-12-24 19:30:22','2023-12-25 17:25:05'),(5,'usuario4','********','mail4@mail.cl',NULL,1,'2023-12-25 15:27:31','2023-12-25 17:54:21'),(6,'prueba','********','mail2@mail.cl',NULL,1,'2023-12-25 15:35:21','2023-12-25 17:19:28'),(7,'asdasd',NULL,'mail3@mail.cl',NULL,0,'2023-12-25 15:42:24','2023-12-25 15:42:24');
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_grupo`
--

LOCK TABLES `usuario_grupo` WRITE;
/*!40000 ALTER TABLE `usuario_grupo` DISABLE KEYS */;
INSERT INTO `usuario_grupo` VALUES (1,1,'2023-12-25 18:26:45',NULL,1,1),(4,1,'2023-12-25 18:27:01',NULL,4,1),(5,1,'2023-12-25 18:37:23',NULL,5,2),(6,1,'2023-12-26 16:39:36','2023-12-26 16:39:36',1,5),(7,1,'2023-12-26 16:40:07','2023-12-26 16:40:07',7,2),(8,0,'2023-12-26 16:41:58','2023-12-26 16:42:58',1,2),(9,0,'2023-12-26 17:05:16','2023-12-26 17:05:50',1,2);
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

-- Dump completed on 2023-12-26 14:17:19
