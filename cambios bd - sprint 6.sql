CREATE TABLE tipo_moneda (
  Id int(11) NOT NULL AUTO_INCREMENT,
  Nombre varchar(255) NOT NULL,
  Simbolo varchar(10) NOT NULL,
  PRIMARY KEY (Id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO serviciosgenerales.tipo_moneda
(Id, Nombre, Simbolo)
VALUES(1, 'Peso Chileno', 'CLP$');
INSERT INTO serviciosgenerales.tipo_moneda
(Id, Nombre, Simbolo)
VALUES(2, 'Dólar', 'USD$');
INSERT INTO serviciosgenerales.tipo_moneda
(Id, Nombre, Simbolo)
VALUES(3, 'Unidad de Fomento', 'UF ');

ALTER TABLE sistemasgenerales.compuesta ADD TipoMonedaId int DEFAULT 1 NOT NULL;

ALTER TABLE sistemasgenerales.compuesta ADD CONSTRAINT compuesta_FK FOREIGN KEY (TipoMonedaId) REFERENCES sistemasgenerales.tipo_moneda(Id) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE sistemasgenerales.compuesta MODIFY COLUMN Caracteristica varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
