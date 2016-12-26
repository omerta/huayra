<?php
session_start();
  //////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
  if (!array_key_exists("la_logusr", $_SESSION)) {
      print "<script language=JavaScript>";
      print "location.href='../sigesp_inicio_sesion.php'";
      print "</script>";
  }
  $ls_logusr = $_SESSION["la_logusr"];
  require_once("class_funciones_activos.php");
  $io_fun_activo = new class_funciones_activos();
  $io_fun_activo->uf_load_seguridad("SAF", "sigesp_saf_d_sedes.php", $ls_permisos, $la_seguridad, $la_permisos);
  require_once("sigesp_saf_c_activo.php");
  $ls_codemp = $_SESSION["la_empresa"]["codemp"];
  $io_saf_tipcat = new sigesp_saf_c_activo();
  $ls_rbtipocat = $io_saf_tipcat->uf_select_valor_config($ls_codemp);

  //////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////

  /**
   * Function:  uf_limpiarvariables
   * Description: Función que limpia todas las variables necesarias en la página
   */
  function uf_limpiarvariables()
  {
      global $ls_codigo, $ls_denominacion,$ls_empleo,$ls_tiposede, $ls_codpais,$ls_codestado,$ls_codmunicipio,$ls_codciudad,
      	   $ls_codparroquia,$ls_urbanizacion,$ls_piso,$ls_calle,$ls_casa;

      $ls_codigo = "";
      $ls_denominacion = "";
      $ls_empleo = "";
      $ls_tiposede= "";
      $ls_codpais= "";
      $ls_codestado= "";
      $ls_codmunicipio = "";
      $ls_codciudad = "";
      $ls_codparroquia= "";
      $ls_urbanizacion= "";
      $ls_piso= "";
      $ls_calle= "";
      $ls_casa= "";
      $ls_status = "";
  }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
    <!--<script type="text/javascript" src="../shared/js/disabled_keys.js"></script>-->
    <script type="text/javascript" src="../shared/js/jquery-2.1.4.min.js"></script>
    <!--<script type="text/javascript" src="../shared/js/jquery.qtip.js"></script>-->
    <script type="text/javascript" src="js/sigesp_saf_d_sedes.js"></script>

    <title>Definici&oacute;n de Sedes</title>
    <link href="../shared/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <meta http-equiv="imagetoolbar" content="no">
    <script type="text/javascript" src="js/stm31.js"></script>
    <script type="text/javascript" src="js/funciones.js"></script>
    <link href="../shared/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
    <link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
    <link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
    <link href="../shared/css/general.css" rel="stylesheet" type="text/css">
  </head>

<body>
  <div class="container">
    <header>
      <div>
        <img class="img-responsive center-block" src="../shared/imagebank/header.jpg" alt="">
      </div>

      <div class="seccion">
        <div class="descripcion-sistema">
          <div>
            <font color="#6699CC" size="3">Sistema de Activos Fijos</font>
          </div>
          <div>
            <?php print date("j/n/Y")." - ".date("h:i a");?>
          </div>
          <div>
            <?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?> <i>en</i> <?php print $_SESSION["ls_database"];?>
          </div>
        </div>


      <div class="conteiner-botonera">
          <?php
          if ($ls_rbtipocat == 1) {
          ?>
              <script type="text/javascript" src="js/menu_csc.js"></script>
          <?php
          } elseif ($ls_rbtipocat == 2) {
          ?>
              <script type="text/javascript" src="js/menu_cgr.js"></script></td>
          <?php
          } else {
          ?>
              <script type="text/javascript" src="js/menu.js"></script></td>
          <?php
          }
          ?>
      </div>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <ul class="nav navbar-nav">
            <li>
              <a href="javascript: ue_nuevo();"><span>Nuevo</span>
                <img src="../shared/imagebank/tools20/nuevo.gif" alt="Nuevo" width="20" title="Nuevo" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_guardar();"><span>Guardar</span>
                <img src="../shared/imagebank/tools20/grabar.gif" alt="Grabar"  width="20" title="Guardar" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_buscar();"><span>Buscar</span>
                <img src="../shared/imagebank/tools20/buscar.gif" alt="Buscar" width="20"  height="20" title="Buscar" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_eliminar();"><span>Eliminar</span>
                <img src="../shared/imagebank/tools20/eliminar.gif" alt="Eliminar" width="20" height="20" title="Eliminar" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_cerrar();">
                <img src="../shared/imagebank/tools20/salir.gif" alt="Salir" width="20" height="20" title="Salir" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_ayuda();">
                <img src="../shared/imagebank/tools20/ayuda.gif" alt="Ayuda" title="Ayuda" width="20" height="20">
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>
</div>

        <?php
        //print_r($_POST);
        require_once("../shared/class_folder/class_mensajes.php");
        $io_msg = new class_mensajes();
        require_once("sigesp_saf_c_sedes.php");
        $io_saf = new sigesp_saf_c_sedes();
        require_once("../shared/class_folder/sigesp_include.php");
        $in = new sigesp_include();
        $con = $in->uf_conectar();
        require_once("../shared/class_folder/class_funciones_db.php");
        $io_fun = new class_funciones_db($con);
        $arre = $_SESSION["la_empresa"];

        require_once("../shared/class_folder/class_datastore.php");
        require_once("../shared/class_folder/class_sql.php");
        require_once("../shared/class_folder/class_funciones.php");
        $io_conect = new sigesp_include(); //Instanciando la Sigesp_Include.
        $conn = $io_conect->uf_conectar(); //Asignacion de valor a la variable $conn a traves del metodo uf_conectar de la clase sigesp_include.
        $io_sql = new class_sql($conn); //Instanciando la Clase Class Sql.

		/**
		 * Revisa el array $_POST en busca de un posible valor insertado por
		 * los los JavaScript dispobibles.
		 * $ls_operacion
		 */
        $ls_empresa = $arre["codemp"];
        if (array_key_exists("operacion", $_POST)) {
            $ls_operacion = $_POST["operacion"];
        } else {
            $ls_operacion = "";
            uf_limpiarvariables();
        }

        if (array_key_exists("txtcodsede", $_POST)) {
            $ls_codigo = $_POST["txtcodsede"];
        } else {
            $ls_codigo = "";
            uf_limpiarvariables();
        }
        /** Descripci�n */
        if (array_key_exists("txtdenrot", $_POST)) {
            $ls_denominacion = $_POST["txtdenrot"];
            $lr_datos["denominacion"] = $ls_denominacion;
        } else {
            $ls_denominacion = "";
            $lr_datos["denominacion"] = $ls_denominacion;
        }
        /** C�digo tipo sede - cmbtiposede */
        if (array_key_exists("cmbtiposede", $_POST)) {
            $ls_tiposede = $_POST["cmbtiposede"];
            $lr_datos["tiposede"] = $ls_codpais;
        } else {
            $ls_tiposede = "";
            $lr_datos["tiposede"] = $ls_tiposede;
        }
        /** Tipo localizaci�n - cmbtipolocalizacion */
        if (array_key_exists("cmbtipolocalizacion", $_POST)) {
        	$ls_tipolocalizacion = $_POST["cmbtipolocalizacion"];
        	$lr_tipolocalizacion["tipolocalizacion"] = $ls_tipolocalizacion;
        } else {
        	$ls_tipolocalizacion = "";
        	$lr_datos["tipolocalizacion"] = $ls_tipolocalizacion;
        }
        /** Pais - cmdpais */
        if (array_key_exists("cmbpais", $_POST)) {
            $ls_codpais = $_POST["cmbpais"];
            $lr_datos["pais"] = $ls_codpais;
        } else {
            $ls_codpais = "---";
            $lr_datos["pais"] = $ls_codpais;
        }
		    /** Estado - cmbestado */
        if (array_key_exists("cmbestado", $_POST)) {
            $ls_codestado = $_POST["cmbestado"];
            $lr_datos["estado"] = $ls_codestado;
        } else {
            $ls_codestado = "";
            $lr_datos["estado"] = $ls_codestado;
        }
        /** Municipio - hidmunicipio */
        if (array_key_exists("hidmunicipio", $_POST)) {
            $ls_codmunicipio = $_POST["hidmunicipio"];
            $lr_datos["municipio"] = $ls_codmunicipio;
        } else {
            $ls_codmunicipio = "";
            $lr_datos["municipio"] = $ls_codmunicipio;
        }
        /** Ciudad - cmbciudad */
        if (array_key_exists("cmbciudad", $_POST)) {
        	$ls_codciudad = $_POST["cmbciudad"];
          $lr_datos["ciudad"] = $ls_codciudad;
        } else {
            $ls_codciudad = "";
            $lr_datos["ciudad"] = $ls_codciudad;
        }
        /** Parroquia - cmbparroquia */
        if (array_key_exists("cmbparroquia", $_POST)) {
        	$ls_codparroquia = $_POST["cmbparroquia"];
          $lr_datos["parroquia"] = $ls_codparroquia;
        } else {
            $ls_codparroquia = "";
            $lr_datos["parroquia"] = $ls_codparroquia;
        }
        /** Urbanizaci�n - $ls_urbanizacion */
        if (array_key_exists("txturbanizacion", $_POST)) {
            $ls_urbanizacion = $_POST["txturbanizacion"];
            $lr_datos["urbanizacion"] = $ls_codparroquia;
        } else {
            $ls_urbanizacion = "";
            $lr_datos["urbanizacion"] = $ls_urbanizacion;
        }
        /** Calle - txtcalle */
        if (array_key_exists("txtcalle", $_POST)) {
            $ls_calle = $_POST["txtcalle"];
            $lr_datos["calle"] = $ls_calle;
        } else {
            $ls_calle = "";
            $lr_datos["calle"] = $ls_calle;
        }
        /** Casa - txtcasa */
        if (array_key_exists("txtcasa", $_POST)) {
            $ls_casa = $_POST["txtcasa"];
            $lr_datos["casa"] = $ls_casa;
        } else {
            $ls_casa = "";
            $lr_datos["casa"] = $ls_casa;
        }
        /** Piso - txtpiso */
         if (array_key_exists("txtpiso", $_POST)) {
            $ls_piso = $_POST["txtpiso"];
            $lr_datos["piso"] = $ls_piso;
        } else {
            $ls_piso = "";
            $lr_datos["piso"] = $ls_piso;
        }

        /**
         * Las funciones JavaScript, ue_nuevo(), actualizan una etiqueta <input>
         * que tiene como nombre operacion, luego hace un submit() de manera que la pagina es recargada
         * totalmente y al mismo tiempo el arrray $_POST contiene una posici�n
         * $_POST[operacion] que es usada por PHP para ejecutar tal cosa o tal otra.
         */
        $ls_status = $_POST["hidstatus"];
        if ($ls_operacion == "GUARDAR") {
            $ls_valido = false;
            $ls_codigo = $_POST["txtcodsede"];
            $ls_denominacion = $_POST["txtdenrot"];
            $ls_empleo = $_POST["txtempleo"];
            $ls_status = $_POST["hidstatus"];

            if (($ls_codigo == "") || ($ls_denominacion == "") || ($ls_tiposede == "") || ($ls_codpais == "")|| ($ls_codestado == "") ||
            		($ls_codciudad == "") || ($ls_codparroquia == "") || ($ls_codmunicipio == "")) {
                $io_msg->message("Debe completar los campos Obligatorios ");
            } else {
                if ($ls_status == "C") {
                	list ($lb_valido,$msg) = $io_saf->uf_saf_update_sedes($ls_codemp,$ls_codigo,$ls_denominacion,$ls_tiposede,$ls_tipolocalizacion,
															  $ls_codpais,$ls_codestado,$ls_codmunicipio,$ls_codciudad,$ls_codparroquia,
															  $ls_urbanizacion,$ls_calle,$ls_casa,$ls_piso,$la_seguridad);
                    if ($lb_valido) {
                        $io_msg->message("El registro ".$ls_codigo." fue actualizado.");
                        uf_limpiarvariables();
                    } else {
                        $io_msg->message("El registro ".$ls_codemp." no pudo ser actualizado");
                        uf_limpiarvariables();
                    }
                    if($msg!=""){
                    	$io_msg->message($msg);
                    }
                } else
                {
                	$lb_valido = $io_saf->uf_saf_insert_sedes($ls_codemp,$ls_codigo,$ls_denominacion,$ls_tiposede,$ls_tipolocalizacion,
															  $ls_codpais,$ls_codestado,$ls_codmunicipio,$ls_codciudad,$ls_codparroquia,
															  $ls_urbanizacion,$ls_calle,$ls_casa,$ls_piso,$la_seguridad);
                    if ($lb_valido) {
                        $io_msg->message("El registro fue grabado.");
                        uf_limpiarvariables();
                    } else {
                        $io_msg->message("No se pudo incluir el registro");
                        uf_limpiarvariables();
                    }
                }
            }
        } elseif ($ls_operacion == "ELIMINAR") {
            $ls_codigo = $_POST["txtcodsede"];
			      $lb_valido = $io_saf->uf_saf_delete_sedes($ls_codemp,$ls_codigo, $la_seguridad);
            if ($lb_valido) {
                $io_msg->message("El registro fue eliminado");
                uf_limpiarvariables();
            } else {
                $io_msg->message("No se pudo eliminar el registro");
                uf_limpiarvariables();
            }
        } elseif ($ls_operacion == "NUEVO") {
            uf_limpiarvariables();
            require_once("../shared/class_folder/sigesp_c_generar_consecutivo.php");
            $io_keygen = new sigesp_c_generar_consecutivo();
            $ls_codigo = $io_keygen->uf_generar_numero_nuevo("SAF", "sudebip_sedes_similares", "codigo_sede", "SAFROT", 4, "", "", "");
            if ($ls_codigo === false) {
                print "<script language=JavaScript>";
                print "location.href='sigespwindow_blank.php'";
                print "</script>";
            }
            unset($io_keygen);
        }
        ?>


        <div class="container">
          <h1  class="titulo">Definici&oacute;n de	Sedes</h1>
          <div class="formato-blanco">
            <form id="formulario" name="formulario" method="post" action="" class="form-horizontal">

              <?php
              //////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
              $io_fun_activo->uf_print_permisos($ls_permisos, $la_permisos, $ls_logusr, "location.href='sigespwindow_blank.php'");
              unset($io_fun_activo);
              //////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
              ?>

              <input name="txtempresa" type="hidden" id="txtempresa" value="<?php print $ls_empresa ?>">
              <input name="txtnombrevie" type="hidden" id="txtnombrevie2">
              <input name="hidstatus" id="hidstatus" type="hidden" id="hidstatus" value="<?php print $ls_status ?>">
              <input name="operacion" type="hidden" id="operacion">

              <!-- -->
              <div class="form-group">
                <label for="" class="control-label col-md-10">C&oacute;digo</label>
                <div class="col-md-2">
                  <input class="form-control" name="txtcodsede" type="text" id="txtcodsede" value="<?php print $ls_codigo ?>" size="8" maxlength="5" style="text-align: center" readonly>
                </div>
              </div>

              <!-- -->
              <div class="form-group">
                <label for="" class="control-label col-md-3">*Denominaci&oacute;n</label>
                <div class="col-md-9">
                  <input class="form-control" name="txtdenrot" type="text" id="txtdenrot" onKeyUp="javascript:ue_validarcomillas(this);" onBlur="javascript:ue_validarcomillas(this)" value="<?php print $ls_denominacion ?>" size="50" maxlength="100" title="Indique la descripción o denominación de la Sede del Órgano o Ente" required>
                </div>
              </div>

              <!-- -->
              <div class="form-group">
                <label for="" class="control-label col-md-3">*Tipo Sede</label>
                <div class="col-md-9">
                  <select class="form-control" name="cmbtiposede" id="cmbtiposede" >
                    <option value="---">---seleccione---</option>
                        <?php
                        $rs_data = $io_saf->uf_saf_select_tiposede();
                        while ($row = $io_sql->fetch_row($rs_data)) {
                          $la_tiposede = $row["codigo"];
                          $ls_dentiposede = $row["descripcion"];
                            if ($la_tiposede == $ls_tiposede) {
                                print "<option value='$la_tiposede' selected>$ls_dentiposede</option>";
                            } else {
                                print "<option value='$la_tiposede'>$ls_dentiposede</option>";
                            }
                        }
                        ?>
                  </select>
                </div>
              </div>
              <input name="hidtiposede" type="hidden" id="hidtiposede" value="<?php print $ls_tiposede ?>">

              <!-- Localización -->
              <div class="form-group">
                <label for="" class="control-label col-md-3">*Localización</label>
                <div class="col-md-9">
                  <select class="form-control" name="cmbtipolocalizacion" id="cmbtipolocalizacion">
                    <option value="N">Nacional</option>
                    <option value="I">Internacional</option>
                  </select>
                </div>
              </div>

              <!-- Pais -->
              <div class="form-group">
                <label for="" class="control-label col-md-3">*Pais</label>
                <div class="col-md-9">
                  <select class="form-control" name="cmbpais" id="cmbpais">
                    <option value="---">---seleccione---</option>
                      <?php
                      /**
                       * ls_codipais es llenada m�s arriba por "---" o por el valor
                       * del array $_POST[cmbpais].
                       */
                      $rs_data = $io_saf->uf_saf_select_pais();
                      while ($row = $io_sql->fetch_row($rs_data)) {
                          $la_codpais = $row["codigo_pais"];
                          $ls_denpais = $row["descripcion"];
                          if ($ls_codpais == $la_codpais) {
                              print "<option value='$la_codpais' selected>$ls_denpais</option>";
                          } elseif($la_codpais == "230" && empty($ls_pais))
                          {
                            print "<option value='$la_codpais' selected>".$ls_denpais."</option>";
                          } else
                          {
                              print "<option value='$la_codpais'>$ls_denpais</option>";
                          }
                      }
                      ?>
                </select>
              </div>
            </div>
            <input name="hidpais" type="hidden" id="hidpais" value="<?php print $ls_codpais ?>">

            <!-- Estados -->
            <div class="form-group">
                <label for="" class="control-label col-md-3">*Estado</label>
                <div class="col-md-9">
                  <select class="form-control" name="cmbestado" id="cmbestado" onChange="javascript:uf_exportestado();">
                    <option value="---">---seleccione---</option>
                      <?php
                      $rs_data = $io_saf->uf_saf_select_estados();
                      while ($row = $io_sql->fetch_row($rs_data)) {
                        $la_codestado = $row["codigo_estado"];
                        $ls_denestado = $row["descripcion"];
                          if ($la_codestado == $ls_codestado) {
                              print "<option value='$la_codestado' selected>$ls_denestado</option>";
                          } else {
                              print "<option value='$la_codestado'>$ls_denestado</option>";
                          }
                      }
                      ?>
                </select>
              </div>
            </div>
            <input name="hidestado" type="hidden" id="hidestado" value="<?php print $ls_codestado ?>">

            <!-- Municipio -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">*Municipio</label>
              <div class="col-md-9">
                <select class="form-control" name="cmbmunicipio" id="cmbmunicipio" onChange="javascript:uf_exportmunicipio();">
                    <option value="---">---seleccione---</option>
                        <?php
                        $rs_data = $io_saf->uf_saf_select_municipio($ls_codestado);
                        //print_r($rs_data);
                        while ($row = $io_sql->fetch_row($rs_data)) {
                            $la_codmunicipio = $row["codigo_municipio"];
                            $ls_denmunicipio = $row["descripcion"];
                            if ($la_codmunicipio == $ls_codmunicipio) {
                                print "<option value='$la_codmunicipio' selected>$ls_denmunicipio</option>";
                            } else {
                                print "<option value='$la_codmunicipio'>$ls_denmunicipio</option>";
                            }
                        }
                        ?>
                </select>
              </div>
            </div>
            <input name="hidmunicipio" type="hidden" id="hidmunicipio"	value="<?php print $ls_codmunicipio ?>">

            <!-- Ciudad -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">*Ciudad</label>
              <div class="col-md-9">
                <select class="form-control" name="cmbciudad" id="cmbciudad" onChange="javascript:uf_exportciudad();">
                    <option value="---">---seleccione---</option>
                      <?php
                      $rs_data = $io_saf->uf_saf_select_ciudades($ls_codmunicipio);
                      //print_r($rs_data);
                      while ($row = $io_sql->fetch_row($rs_data)) {
                          $la_codciudad = $row["codigo_ciudad"];
                          $ls_denciudad = $row["descripcion"];
                          if ($la_codciudad == $ls_codciudad) {
                              print "<option value='$la_codciudad' selected>$ls_denciudad</option>";
                          } else {
                              print "<option value='$la_codciudad'>$ls_denciudad</option>";
                          }
                      }
                      ?>
                </select>
              </div>
            </div>
            <input name="hidciudad" type="hidden" id="hidciudad" value="<?php print $ls_codciudad ?>">

            <!-- Parroquia -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">*Parroquia</label>
              <div class="col-md-9">
                <select class="form-control" name="cmbparroquia" id="cmbparroquia" onChange="javascript:uf_exportparroquia();">
                  <option value="---">---seleccione---</option>
                    <?php
                    $rs_data = $io_saf->uf_saf_select_parroquia($ls_codmunicipio);
                    //print_r($rs_data);
                    while ($row = $io_sql->fetch_row($rs_data)) {
                        $la_codparroquia = $row["codigo_parroquia"];
                        $ls_denparroquia = $row["descripcion"];
                        if ($la_codparroquia == $ls_codparroquia) {
                            print "<option value='$la_codparroquia' selected>$ls_denparroquia</option>";
                        } else {
                            print "<option value='$la_codparroquia'>$ls_denparroquia</option>";
                        }
                    }
                    ?>
                </select>
              </div>
            </div>
            <input name="hidparroquia" type="hidden" id="hidparroquia" value="<?php print $ls_codparroquia ?>">

            <!-- Urbanización -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">Urbanizaci&oacute;n</label>
              <div class="col-md-9">
                <input class="form-control" name="txturbanizacion" type="text" id="txturbanizacion" value="<?php print $ls_urbanizacion ?>" size="50" maxlength="50" style="text-align: center">
              </div>
            </div>

            <!-- Calle -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">Calle</label>
              <div class="col-md-9">
                <input class="form-control" name="txtcalle" type="text" id="txtcalle" value="<?php print $ls_calle ?>" size="50" maxlength="50" style="text-align: center">
              </div>
            </div>

            <!-- Casa -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">Casa</label>
              <div class="col-md-9">
                <input class="form-control" name="txtcasa" type="txtcasa" id="txtcasa" value="<?php print $ls_casa ?>" size="50" maxlength="50" style="text-align: center">
              </div>
            </div>

            <!-- Piso -->
            <div class="form-group">
              <label for="" class="control-label col-md-3">Piso</label>
              <div class="col-md-9">
                <input class="form-control" name="txtpiso" type="text" id="txtpiso" value="<?php print $ls_piso ?>" size="50" maxlength="50" style="text-align: center">
              </div>
            </div>

            </form>
          </div>
        </div>
</body>
</html>
