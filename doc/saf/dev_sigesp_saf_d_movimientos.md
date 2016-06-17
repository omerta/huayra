# Manual del Desarrollador #

## Formulario: Definición de Causas de Movimiento ##

[*ver manual del desarrollador*](sigesp_saf_d_movimientos.md)

## Archivos ##

* sigesp_saf_d_movimientos.php
* js/sigesp_saf_d_movimientos.js
* templates/sigesp_saf_template_movimientos.html
* sigesp_saf_puente_movimiento.php
* sigesp_saf_c_movimientos.php
* sigesp_saf_cat_causas.php

|        | HTML | d | c | DB |
|--------|------|---|---|----|
| Código | txtcodigo | $ls_codigo | $as_codigo | codcau |
| Denominación |txtdenominacion | $ls_denominacion | $as_denominacion | dencau |
| Explicación | txtexplicacion | $ls_explicacion | $as_explicacion | expcau |
| Tipo | (I)ncorporación, (D)esincorporación, (R)easignación, (M)odificación| $ls_radiotipo | $as_tipo | tipcau |
| Estatus de afectación contable | chkcontable | $li_contable | $ai_contable | estafecon |
| Estatus de afectación presupuestaria | chkpresupuestaria | $li_presupuestaria | $ai_presupuestaria | estafepre |
