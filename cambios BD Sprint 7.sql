CREATE TABLE serviciosgenerales.tipo_cambio (
    Id int(11) auto_increment NOT NULL,
    ToCLP int(11) NOT NULL,
    TipoMonedaId int(11) NOT NULL,
    ConsolidadoId int(11) NOT NULL
    CONSTRAINT Tipo_Cambio_pk PRIMARY KEY (Id),
    CONSTRAINT Tipo_Cambio_Tipo_Cambio_FK FOREIGN KEY (TipoMonedaId) REFERENCES serviciosgenerales.tipo_cambio(Id) ON DELETE RESTRICT ON UPDATE RESTRICT,
    CONSTRAINT tipo_cambio_consolidado_mes_FK FOREIGN KEY (ConsolidadoId) REFERENCES serviciosgenerales.consolidado_mes(Id) ON DELETE RESTRICT ON UPDATE RESTRICT
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci;

ALTER TABLE serviciosgenerales.solicitud ADD TipoMonedaId int(11) NULL;
ALTER TABLE serviciosgenerales.solicitud MODIFY COLUMN CostoSolicitud BIGINT NOT NULL;
ALTER TABLE serviciosgenerales.solicitud ADD CONSTRAINT solicitud_FK FOREIGN KEY (TipoMonedaId) REFERENCES serviciosgenerales.tipo_moneda(Id) ON DELETE RESTRICT ON UPDATE CASCADE;

INSERT INTO serviciosgenerales.estado_consolidado
(Id, Nombre, created_at, updated_at)
VALUES(0, 'Cerrado',NULL, NULL);

INSERT INTO serviciosgenerales.privilegio
(Id, Nombre, Descripcion, Enabled, created_at, updated_at)
VALUES(13, 'Consolidados', 'Permisos para el modulo', 1, '2024-02-06 13:23:10.000', NULL);