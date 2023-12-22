-- Exported from QuickDBD: https://www.quickdatabasediagrams.com/
-- Link to schema: https://app.quickdatabasediagrams.com/#/d/bwTnST
-- NOTE! If you have used non-SQL datatypes in your design, you will have to change these here.


CREATE TABLE `PRIVILEGIO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Descripcion` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_PRIVILEGIO_Nombre` UNIQUE (
        `Nombre`
    )
);

CREATE TABLE `RECURSO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Descripcion` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_RECURSO_Nombre` UNIQUE (
        `Nombre`
    )
);

CREATE TABLE `GRUPO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Descripcion` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_GRUPO_Nombre` UNIQUE (
        `Nombre`
    )
);

CREATE TABLE `GRUPO_PRIVILEGIO` (
    `Id` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `GrupoId` int  NOT NULL ,
    `PrivilegioId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `GRUPO_RECURSO` (
    `Id` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `GrupoId` int  NOT NULL ,
    `PrivilegioId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `EMPRESA` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Rut` varchar(13)  NOT NULL ,
    `Email` varchar(50)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_EMPRESA_Nombre` UNIQUE (
        `Nombre`
    ),
    CONSTRAINT `uc_EMPRESA_Rut` UNIQUE (
        `Rut`
    )
);

-- Nombre del centro de costo sin valor único
-- dos empresas pueden tener centros de costos
-- con el mismo nombre
CREATE TABLE `CENTRO_DE_COSTO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `EmpresaId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `PERSONA` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Apellido` varchar(255)  NOT NULL ,
    `Rut` varchar(13)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `CentroCostoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_PERSONA_Rut` UNIQUE (
        `Rut`
    )
);

CREATE TABLE `USUARIO` (
    `Id` int  NOT NULL ,
    `Username` varchar(255)  NOT NULL ,
    `Password` varchar(255)  NULL ,
    `Email` varchar(50)  NOT NULL ,
    `GoogleId` int  NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `PersonaId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_USUARIO_Username` UNIQUE (
        `Username`
    ),
    CONSTRAINT `uc_USUARIO_Email` UNIQUE (
        `Email`
    ),
    CONSTRAINT `uc_USUARIO_GoogleId` UNIQUE (
        `GoogleId`
    )
);

CREATE TABLE `USUARIO_GRUPO` (
    `Id` int  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `UsuarioId` int  NOT NULL ,
    `GrupoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `AREA` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Rut` varchar(13)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_AREA_Nombre` UNIQUE (
        `Nombre`
    ),
    CONSTRAINT `uc_AREA_Rut` UNIQUE (
        `Rut`
    )
);

CREATE TABLE `FLUJO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `AreaId` int  NOT NULL ,
    `GrupoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

-- Nivel es tipo entero para admitir valores
-- 1, 2 y 3 según Inicio, Intermedia, Final
CREATE TABLE `ORDEN_FLUJO` (
    `Id` int  NOT NULL ,
    `Nivel` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `AtrasId` int  NULL ,
    `FlujoId` int  NOT NULL ,
    `EstadoSolicitudId` int  NOT NULL ,
    `GrupoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `ESTADO_SOLICITUD` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_ESTADO_SOLICITUD_Nombre` UNIQUE (
        `Nombre`
    )
);

CREATE TABLE `ATRIBUTO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `ValorReferencia` int  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_ATRIBUTO_Nombre` UNIQUE (
        `Nombre`
    )
);

CREATE TABLE `MOVIMIENTO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `Enabled` int  NOT NULL DEFAULT 1,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `FlujoId` int  NOT NULL ,
    `GrupoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    ),
    CONSTRAINT `uc_MOVIMIENTO_Nombre` UNIQUE (
        `Nombre`
    )
);

CREATE TABLE `MOVIMIENTO_ATRIBUTO` (
    `Id` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `MovimientoId` int  NOT NULL ,
    `AtributoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `ESTADO_CONSOLIDADO` (
    `Id` int  NOT NULL ,
    `Nombre` varchar(255)  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `CONSOLIDADO_MES` (
    `Id` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `FechaTermino` dateTime  NULL ,
    `EstadoConsolidadoId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `INTERNO` (
    `Id` int  NOT NULL ,
    `CostoCC` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `CentroCostoId` int  NOT NULL ,
    `ConsolidadoMesId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `ORDEN_DE_COMPRA` (
    `Id` int  NOT NULL ,
    `CostoMes` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `ConsolidadoMesId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `SOLICITUD` (
    `Id` int  NOT NULL ,
    `CostoSolicitud` int  NOT NULL ,
    `PersonaId` int  NOT NULL ,
    `CentroCostoId` int  NOT NULL ,
    `ConsolidadoMesId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `COMPUESTA` (
    `Id` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `MovimientoAtributoId` int  NOT NULL ,
    `SolicitudId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `HISTORIAL_SOLICITUD` (
    `Id` int  NOT NULL ,
    `created_at` dateTime  NOT NULL DEFAULT utc_timestamp(),
    `updated_at` dateTime  NULL ,
    `UsuarioId` int  NOT NULL ,
    `EstadoSolicitudId` int  NOT NULL ,
    `SolicitudId` int  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

CREATE TABLE `LOGS` (
    `Id` int  NOT NULL ,
    `Nivel` varchar(20)  NOT NULL ,
    `Mensaje` varchar(255)  NOT NULL ,
    `Contexto` varchar(255)  NOT NULL ,
    PRIMARY KEY (
        `Id`
    )
);

ALTER TABLE `GRUPO_PRIVILEGIO` ADD CONSTRAINT `fk_GRUPO_PRIVILEGIO_GrupoId` FOREIGN KEY(`GrupoId`)
REFERENCES `GRUPO` (`Id`);

ALTER TABLE `GRUPO_PRIVILEGIO` ADD CONSTRAINT `fk_GRUPO_PRIVILEGIO_PrivilegioId` FOREIGN KEY(`PrivilegioId`)
REFERENCES `PRIVILEGIO` (`Id`);

ALTER TABLE `GRUPO_RECURSO` ADD CONSTRAINT `fk_GRUPO_RECURSO_GrupoId` FOREIGN KEY(`GrupoId`)
REFERENCES `GRUPO` (`Id`);

ALTER TABLE `GRUPO_RECURSO` ADD CONSTRAINT `fk_GRUPO_RECURSO_PrivilegioId` FOREIGN KEY(`PrivilegioId`)
REFERENCES `RECURSO` (`Id`);

ALTER TABLE `CENTRO_DE_COSTO` ADD CONSTRAINT `fk_CENTRO_DE_COSTO_EmpresaId` FOREIGN KEY(`EmpresaId`)
REFERENCES `EMPRESA` (`Id`);

ALTER TABLE `PERSONA` ADD CONSTRAINT `fk_PERSONA_CentroCostoId` FOREIGN KEY(`CentroCostoId`)
REFERENCES `CENTRO_DE_COSTO` (`Id`);

ALTER TABLE `USUARIO` ADD CONSTRAINT `fk_USUARIO_PersonaId` FOREIGN KEY(`PersonaId`)
REFERENCES `PERSONA` (`Id`);

ALTER TABLE `USUARIO_GRUPO` ADD CONSTRAINT `fk_USUARIO_GRUPO_UsuarioId` FOREIGN KEY(`UsuarioId`)
REFERENCES `USUARIO` (`Id`);

ALTER TABLE `USUARIO_GRUPO` ADD CONSTRAINT `fk_USUARIO_GRUPO_GrupoId` FOREIGN KEY(`GrupoId`)
REFERENCES `GRUPO` (`Id`);

ALTER TABLE `FLUJO` ADD CONSTRAINT `fk_FLUJO_AreaId` FOREIGN KEY(`AreaId`)
REFERENCES `AREA` (`Id`);

ALTER TABLE `FLUJO` ADD CONSTRAINT `fk_FLUJO_GrupoId` FOREIGN KEY(`GrupoId`)
REFERENCES `GRUPO` (`Id`);

ALTER TABLE `ORDEN_FLUJO` ADD CONSTRAINT `fk_ORDEN_FLUJO_AtrasId` FOREIGN KEY(`AtrasId`)
REFERENCES `ORDEN_FLUJO` (`Id`);

ALTER TABLE `ORDEN_FLUJO` ADD CONSTRAINT `fk_ORDEN_FLUJO_FlujoId` FOREIGN KEY(`FlujoId`)
REFERENCES `FLUJO` (`Id`);

ALTER TABLE `ORDEN_FLUJO` ADD CONSTRAINT `fk_ORDEN_FLUJO_EstadoSolicitudId` FOREIGN KEY(`EstadoSolicitudId`)
REFERENCES `ESTADO_SOLICITUD` (`Id`);

ALTER TABLE `ORDEN_FLUJO` ADD CONSTRAINT `fk_ORDEN_FLUJO_GrupoId` FOREIGN KEY(`GrupoId`)
REFERENCES `GRUPO` (`Id`);

ALTER TABLE `MOVIMIENTO` ADD CONSTRAINT `fk_MOVIMIENTO_FlujoId` FOREIGN KEY(`FlujoId`)
REFERENCES `FLUJO` (`Id`);

ALTER TABLE `MOVIMIENTO` ADD CONSTRAINT `fk_MOVIMIENTO_GrupoId` FOREIGN KEY(`GrupoId`)
REFERENCES `GRUPO` (`Id`);

ALTER TABLE `MOVIMIENTO_ATRIBUTO` ADD CONSTRAINT `fk_MOVIMIENTO_ATRIBUTO_MovimientoId` FOREIGN KEY(`MovimientoId`)
REFERENCES `MOVIMIENTO` (`Id`);

ALTER TABLE `MOVIMIENTO_ATRIBUTO` ADD CONSTRAINT `fk_MOVIMIENTO_ATRIBUTO_AtributoId` FOREIGN KEY(`AtributoId`)
REFERENCES `ATRIBUTO` (`Id`);

ALTER TABLE `CONSOLIDADO_MES` ADD CONSTRAINT `fk_CONSOLIDADO_MES_EstadoConsolidadoId` FOREIGN KEY(`EstadoConsolidadoId`)
REFERENCES `ESTADO_CONSOLIDADO` (`Id`);

ALTER TABLE `INTERNO` ADD CONSTRAINT `fk_INTERNO_CentroCostoId` FOREIGN KEY(`CentroCostoId`)
REFERENCES `CENTRO_DE_COSTO` (`Id`);

ALTER TABLE `INTERNO` ADD CONSTRAINT `fk_INTERNO_ConsolidadoMesId` FOREIGN KEY(`ConsolidadoMesId`)
REFERENCES `CONSOLIDADO_MES` (`Id`);

ALTER TABLE `ORDEN_DE_COMPRA` ADD CONSTRAINT `fk_ORDEN_DE_COMPRA_ConsolidadoMesId` FOREIGN KEY(`ConsolidadoMesId`)
REFERENCES `CONSOLIDADO_MES` (`Id`);

ALTER TABLE `SOLICITUD` ADD CONSTRAINT `fk_SOLICITUD_PersonaId` FOREIGN KEY(`PersonaId`)
REFERENCES `PERSONA` (`Id`);

ALTER TABLE `SOLICITUD` ADD CONSTRAINT `fk_SOLICITUD_CentroCostoId` FOREIGN KEY(`CentroCostoId`)
REFERENCES `CENTRO_DE_COSTO` (`Id`);

ALTER TABLE `SOLICITUD` ADD CONSTRAINT `fk_SOLICITUD_ConsolidadoMesId` FOREIGN KEY(`ConsolidadoMesId`)
REFERENCES `CONSOLIDADO_MES` (`Id`);

ALTER TABLE `COMPUESTA` ADD CONSTRAINT `fk_COMPUESTA_MovimientoAtributoId` FOREIGN KEY(`MovimientoAtributoId`)
REFERENCES `MOVIMIENTO_ATRIBUTO` (`Id`);

ALTER TABLE `COMPUESTA` ADD CONSTRAINT `fk_COMPUESTA_SolicitudId` FOREIGN KEY(`SolicitudId`)
REFERENCES `SOLICITUD` (`Id`);

ALTER TABLE `HISTORIAL_SOLICITUD` ADD CONSTRAINT `fk_HISTORIAL_SOLICITUD_UsuarioId` FOREIGN KEY(`UsuarioId`)
REFERENCES `USUARIO` (`Id`);

ALTER TABLE `HISTORIAL_SOLICITUD` ADD CONSTRAINT `fk_HISTORIAL_SOLICITUD_EstadoSolicitudId` FOREIGN KEY(`EstadoSolicitudId`)
REFERENCES `ESTADO_SOLICITUD` (`Id`);

ALTER TABLE `HISTORIAL_SOLICITUD` ADD CONSTRAINT `fk_HISTORIAL_SOLICITUD_SolicitudId` FOREIGN KEY(`SolicitudId`)
REFERENCES `SOLICITUD` (`Id`);

