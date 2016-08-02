# Ejemplo 5. Reescribir Definición: Formulario de Definición de Mótodos de Rotulación

## Lo que tenemos

* saf/sigesp_saf_d_rotulacion.php
* saf/sigesp_saf_c_rotulacion.php
* saf/sigesp_saf_cat_rotulacion.php

## Lo que tendremos

* saf/sigesp_saf_d_rotulacion.php
* saf/sigesp_saf_c_rotulacion.php
* saf/js/sigesp_saf_d_rotulacion.js
* saf/templates/sigesp_saf_template_rotulacion.html
* saf/sigesp_saf_puente_rotulacion.php
* saf/sigesp_saf_cat_rotulacion.php

Lo primero que haremos es separar el código JavaScript del archivo
*sigesp_saf_d_rotulacion.php*, copiandolo en un nuevo archivo. Sin olvidar enlazar
el archivo *php* con el nuevo archivo *js* mediante la etiqueta HTML `<script>`. De esta manera tendremos
[JavaScript no obstructivo](https://es.wikipedia.org/wiki/JavaScript_no_obstructivo).

El nuevo archivo *sigesp_saf_d_rotulacion.js* tabien debe ser reescrito.
Podemos usar el archivo *sigesp_saf_d_default.js* como modelo para la reescritura.

El segundo proceso es reescribir el codigo HTML basado en tablas por `<div>`. Además,
estos `<div>` heredaran clases de bootstrap.

Tomaremos, por ejemplo, la etiqueta `<input>` y la envolvemos con HTML y bootstrap.
Pero antes borramos el atributo `value` de la etiqueta que contien código *php*.
Tambien borramos los atributos `size` y `maxlength`.

Algunas etiquetas tiene código JavaScript asociado, este código cumple funciones de
validación. Cuando no encontremos con estos atributos, por ejemplo `onKeyUp="javascript: ue_validarcomillas(this);"`,
debemos eliminarlo. Nosotros hemos reemplazado la validación via JavaScript por una
validación via bootstrap.

Comenzaremos con un código como este:
```
<tr class="formato-blanco">
  <td height="29"><div align="right">C&oacute;digo</div></td>
  <td height="22"><input name="txtcodrot" type="text" id="txtnombre" value="<?php print $ls_codigo ?>" size="8" maxlength="5" style="text-align:center " readonly>
    <input name="hidstatus" type="hidden" id="hidstatus"></td>
</tr>
```
Y tendremos un código como el que sigue:
```
<div class="form-group">
  <label for="codigo" class="control-label col-md-10">Código</label>
  <div class="col-md-2">
    <input name="txtcodrot" type="text" id="txtnombre" style="text-align:center" class="form-control" readonly>
  </div>
</div>`
```

Todo el nuevo código lo colocaremos en el archivo *sigesp_saf_template_rotulacion.html*.
El archivo *sigesp_saf_template_default.html* es una platilla que se puede copiar
con el proposito de que funcione como base para el nuevo archivo HTML con bootstrap.
Cuando terminemos de reescribir el código HTML podemos borrarlo del archivo *php*.

El siguiente paso es reescribir el sistema de interruptores, código PHP, del archivo
*sigesp_saf_d_rotulacion.php*, hemos
avanzado un poco despojandolo del código JavaScript y del código HTML. Hasta este
momente tenemos dos nuevo archivos uno con código JavaScript y otro con código HTML.

El archivo *sigesp_saf_d_rotulacion.php* posee un sistema de interruptores que
permite decidir sobre la ejecución de una entre cuatro funciones:

* uf_saf_update_rotulacion()
* uf_saf_insert_rotulacion()
* uf_saf_delete_rotulacion()
* uf_generar_numero_nuevo()

Estas cuatro funciones tambien serán separadas y colocadas en un nuevo archivo,
se trata del archivo *Puente* este archivo tendra el siguiente nombre: *sigesp_saf_puente_rotulacion.php*.
En este caso usaremos la plantilla *sigesp_saf_puente_default.php*.

La función *uf_generar_numero_nuevo()* será reemplazada por *uf_generar_codigo_serial()*,
pero será necesario un trabajo previo en la base de datos.

Finalmente el archivo *sigesp_saf_d_rotulacion.php* sufrirá los ultimos cambios.
Tomaremos el archivo *sigesp_saf_d_default.php* como plantilla para la reescritura.

Las funciones que se encuentran en *sigesp_saf_c_rotulacion.php* tambien sufren
cambios. El manejo de errores debe ser reescrito, por ejemplo, mostramos un segmento
del código abajo pero solo como referencias debe remitirse al archivo:

```php
...
$li_row=$this->io_sql->execute($ls_sql);
if($li_row===false)
{
  $this->io_msg->message("CLASE->rotulacion MÉTODO->uf_saf_insert_rotulacion ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
  $lb_valido=false;
  $this->io_sql->rollback();
}
```
Por:
```php
...
$li_row=$this->io_sql->execute($ls_sql);
if($li_row===false)
{
  $lb_valido[0]=false;
  $lb_valido[1]=$this->io_sql->message;
  $this->io_sql->rollback();
}
```

El archivo de *Busqueda* tambien debe ser ajustado *sigesp_saf_cat_rotulacion.php*
