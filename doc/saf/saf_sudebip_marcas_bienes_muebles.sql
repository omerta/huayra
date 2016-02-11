CREATE TABLE saf_sudebip_marcas_bienes_muebles (
	codemp VARCHAR(4),
	id_marca serial unique, -- Código interno de la marca asignado por el órgano o ente
	denominacion_marca VARCHAR(100), -- Denominación comercial de la marca según el fabricante
	nombre_fabricante VARCHAR(100), -- Nombre del Fabricante que respalda la marca
	PRIMARY KEY (id_marca) -- Llave primaria
);
