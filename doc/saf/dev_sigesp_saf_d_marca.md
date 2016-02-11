# Manual del Desarrollador #

## Formulario: Registro de Marca ##

[*ver manual de usuario*](sigesp_saf_d_marca.md)

## Archivos ## 

* sigesp_sad_d_marca.php
* templates/sigesp_saf_template_marca.html (extend base_saf.html)
* templates/sigesp_saf_template_noaccess.html
* js/sigesp_saf_d_marca.js
* sigesp_saf_puente_marca.php
* sigesp_saf_c_marca.php
* sigesp_saf_cat_marca.php

## Tablas ##

* saf_sudebip_marcas_bienes_muebles

## Definiciones > Definición Marcas Bienes ##

| Campos							| HTML			    	  | puente        | c_marca	         | DB		          |
|-----------------------------------|-------------------------|---------------|------------------|--------------------|
| Código de la Marca                | codmarcaid			  | $cod_marca	  | $as_codmarca	 | id_marca 		  |
| Denominación Comercial de la Marca| denominacioncomercialid |	$denominacion | $as_denominacion | denominacion_marca |
| Nombre del Fabricante             | nombrefabricanteid	  | $fabricante	  | $as_fabricante	 | nombre_fabricante  |
