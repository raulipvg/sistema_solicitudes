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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `area`
--

LOCK TABLES `area` WRITE;
/*!40000 ALTER TABLE `area` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_de_costo`
--

LOCK TABLES `centro_de_costo` WRITE;
/*!40000 ALTER TABLE `centro_de_costo` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empresa`
--

LOCK TABLES `empresa` WRITE;
/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado_solicitud`
--

LOCK TABLES `estado_solicitud` WRITE;
/*!40000 ALTER TABLE `estado_solicitud` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo`
--

LOCK TABLES `grupo` WRITE;
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
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
  PRIMARY KEY (`Id`),
  KEY `fk_GRUPO_PRIVILEGIO_GrupoId` (`GrupoId`),
  KEY `fk_GRUPO_PRIVILEGIO_PrivilegioId` (`PrivilegioId`),
  CONSTRAINT `fk_GRUPO_PRIVILEGIO_GrupoId` FOREIGN KEY (`GrupoId`) REFERENCES `grupo` (`Id`),
  CONSTRAINT `fk_GRUPO_PRIVILEGIO_PrivilegioId` FOREIGN KEY (`PrivilegioId`) REFERENCES `privilegio` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `grupo_privilegio`
--

LOCK TABLES `grupo_privilegio` WRITE;
/*!40000 ALTER TABLE `grupo_privilegio` DISABLE KEYS */;
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
  `Enabled` int(1) NOT NULL DEFAULT 0,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persona`
--

LOCK TABLES `persona` WRITE;
/*!40000 ALTER TABLE `persona` DISABLE KEYS */;
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
  `Enabled` int(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT utc_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `uc_PRIVILEGIO_Nombre` (`Nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privilegio`
--

LOCK TABLES `privilegio` WRITE;
/*!40000 ALTER TABLE `privilegio` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_grupo`
--

LOCK TABLES `usuario_grupo` WRITE;
/*!40000 ALTER TABLE `usuario_grupo` DISABLE KEYS */;
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

-- Dump completed on 2023-12-24 11:02:28
