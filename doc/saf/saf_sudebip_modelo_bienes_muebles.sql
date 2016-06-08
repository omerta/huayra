CREATE TABLE saf_sudebip_modelo_bienes_muebles (
	codemp VARCHAR(4),
	id_modelo serial, -- Códígo interno del modelo asigando por el órgano o ente
	denominacion_modelo VARCHAR(100), -- Denominación del modelo según el fabricante
	id_marca integer references saf_sudebip_marcas_bienes_muebles(id_marca), -- Código interno de la marca asignado por el órgano o ente
	codigo_especifico varchar references saf_catalogo_epecifica(codigo_especifico), -- Categoría específica del bien mueble (tercer nivel), distinto de "Semovientes"
	PRIMARY KEY (id_modelo) -- Llave primaria
);
