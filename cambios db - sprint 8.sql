RENAME TABLE serviciosgenerales.grupo_operacion TO serviciosgenerales.grupo_movimiento;
ALTER TABLE serviciosgenerales.grupo_movimiento DROP FOREIGN KEY fk_GRUPO_RECURSO_PrivilegioId;
ALTER TABLE serviciosgenerales.grupo_movimiento CHANGE PrivilegioId MovimientoId int(11) NOT NULL;
ALTER TABLE serviciosgenerales.grupo_movimiento ADD CONSTRAINT grupo_movimiento_movimiento_FK FOREIGN KEY (MovimientoId) REFERENCES serviciosgenerales.movimiento(Id);
ALTER TABLE serviciosgenerales.grupo_movimiento MODIFY COLUMN Enabled tinyint(1) DEFAULT 0 NOT NULL;

CREATE TABLE serviciosgenerales.grupo_solicitud (
	Id int(11) PRIMARY KEY,
	GrupoAutorizadoId int(11) NOT NULL,
	GrupoAccedidoId int(11) NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime NULL,
	CONSTRAINT grupo_solicitud_pk PRIMARY KEY (Id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_general_ci
AUTO_INCREMENT=1;

ALTER TABLE serviciosgenerales.grupo_solicitud MODIFY COLUMN created_at datetime DEFAULT current_timestamp() NOT NULL;
ALTER TABLE serviciosgenerales.grupo_solicitud ADD CONSTRAINT grupo_solicitud_grupo_autorizado_FK FOREIGN KEY (GrupoAutorizadoId) REFERENCES serviciosgenerales.grupo(Id) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE serviciosgenerales.grupo_solicitud ADD CONSTRAINT grupo_solicitud_grupo_accedido_FK FOREIGN KEY (GrupoAccedidoId) REFERENCES serviciosgenerales.grupo(Id) ON DELETE RESTRICT ON UPDATE RESTRICT;

