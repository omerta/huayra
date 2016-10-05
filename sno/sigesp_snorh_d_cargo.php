<?php
    session_start();
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	if(!array_key_exists("la_logusr",$_SESSION))
	{
		print "<script language=JavaScript>";
		print "location.href='../sigesp_inicio_sesion.php'";
		print "</script>";
	}
	$ls_logusr=$_SESSION["la_logusr"];
	require_once("class_folder/class_funciones_nomina.php");
	$io_fun_nomina=new class_funciones_nomina();
	$io_fun_nomina->uf_load_seguridad("SNR","sigesp_snorh_d_cargo.php",$ls_permisos,$la_seguridad,$la_permisos);
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////

   //--------------------------------------------------------------
   function uf_limpiarvariables()
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_limpiarvariables
		//		   Access: private
		//	  Description: Funci�n que limpia todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 14/02/2008 								Fecha �ltima Modificaci�n :
		//////////////////////////////////////////////////////////////////////////////
   		global $ls_codcar,$ls_descar,$ls_operacion,$ls_existe,$io_fun_nomina,$ls_codnom;

		$ls_codcar="";
		$ls_descar="";
		$ls_codnom="";
		$ls_operacion=$io_fun_nomina->uf_obteneroperacion();
		$ls_existe=$io_fun_nomina->uf_obtenerexiste();
   }
   //--------------------------------------------------------------

   //--------------------------------------------------------------
   function uf_load_variables()
   {
		//////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_load_variables
		//		   Access: private
		//	  Description: Funci�n que carga todas las variables necesarias en la p�gina
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaci�n: 14/02/2008								Fecha �ltima Modificaci�n :
		//////////////////////////////////////////////////////////////////////////////
   		global $ls_codcar, $ls_descar, $ls_codnom, $io_fun_nomina;

		$ls_codcar=$_POST["txtcodcar"];
		$ls_descar=$_POST["txtdescar"];
		$ls_codnom=$io_fun_nomina->uf_asignarvalor("cmbnomina",$_POST["txtcodnom"]);
   }
   //--------------------------------------------------------------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<!--<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>-->
<script language="javascript">
	if(document.all)
	{ //ie
		document.onkeydown = function(){
		if(window.event && (window.event.keyCode == 122 || window.event.keyCode == 116 || window.event.ctrlKey)){
		window.event.keyCode = 505;
		}
		if(window.event.keyCode == 505){
		return false;
		}
		}
	}
</script>
<title>Definici&oacute;n de Cargo</title>
<meta http-equiv="imagetoolbar" content="no">

<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/funcion_nomina.js"></script>
<!-- Separar el código JavaScript -->
<script type="text/javascript" src="js/sigesp_snorh_d_cargo.js"></script>
<!-- Estilo de bootstrap -->
<link href="../shared/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/nomina.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
	require_once("sigesp_snorh_c_cargo.php");
	$io_cargo=new sigesp_snorh_c_cargo();
	uf_limpiarvariables();
	switch ($ls_operacion)
	{
		case "GUARDAR":
			uf_load_variables();
			$lb_valido=$io_cargo->uf_guardar($ls_existe,$ls_codcar,$ls_descar,$ls_codnom,$la_seguridad);
			if($lb_valido)
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
			}
			break;

		case "ELIMINAR":
			uf_load_variables();
			$lb_valido=$io_cargo->uf_delete_cargo($ls_codcar,$ls_codnom,$la_seguridad);
			if($lb_valido)
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
			}
			break;
	}
?>
<div class="container">
  <header>
    <div>
      <img class="img-responsive center-block" src="../shared/imagebank/header.jpg" alt="">
    </div>

    <div class="seccion">
      <div class="descripcion-sistema">
        <div>
          <font color="#6699CC" size="3">Sistema de N&oacute;mina</font>
        </div>
        <div>
          <?php print date("j/n/Y")." - ".date("h:i a");?>
        </div>
        <div>
          <?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?> <i>en</i> <?php print $_SESSION["ls_database"];?>
        </div>
      </div>

      <div class="conteiner-botonera">
        <script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script>
      </div>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <ul class="nav navbar-nav">
            <li>
              <a href="javascript: ue_nuevo();">
                <span>Nuevo</span>
                <img src="../shared/imagebank/tools20/nuevo.gif" title="Nuevo" alt="Nuevo" width="20" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_guardar();">
                <span>Guardar</span>
                <img src="../shared/imagebank/tools20/grabar.gif" title="Guardar" alt="Grabar" width="20" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_buscar();">
                <span>Buscar</span>
                <img src="../shared/imagebank/tools20/buscar.gif" title="Buscar" alt="Buscar" width="20" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_eliminar();">
                <span>Eliminar</span>
                <img src="../shared/imagebank/tools20/eliminar.gif" title="Eliminar" alt="Eliminar" width="20" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="javascript: ue_cerrar();">
                <span>Cerrar</span>
                <img src="../shared/imagebank/tools20/salir.gif" title="Salir" alt="Salir" width="20" height="20" border="0">
              </a>
            </li>
            <li>
              <a href="../ayuda" target="_blank">
                <span>Ayuda</span>
                <img src="../shared/imagebank/tools20/ayuda.gif" title="Ayuda" alt="Ayuda" width="20" height="20"></div>
              </a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

<div class="container">
  <h1 class="titulo">Definici&oacute;n de Cargo</h1>
    <div class="formato-blanco">
      <form name="form1" method="post" action="" class="form-horizontal">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$io_fun_nomina->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($io_fun_nomina);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>
        <div class="form-group">
          <label for="" class="control-label col-md-4">C&oacute;digo</label>
          <div class="col-md-8">
            <input class="form-control" name="txtcodcar" type="text" id="txtcodcar" size="15" maxlength="15" value="<?php print $ls_codcar;?>">
          </div>
        </div>
        <div class="form-group">
          <label for="" class="control-label col-md-4">Descripci&oacute;n</label>
          <div class="col-md-8">
            <input class="form-control" name="txtdescar" type="text" id="txtdescar" size="60" maxlength="100" value="<?php print $ls_descar;?>" onKeyUp="ue_validarcomillas(this);">
          </div>
        </div>
        <div class="form-group">
          <label for="" class="control-label col-md-4">N&oacute;mina</label>
          <div class="col-md-8">
            <?php $io_cargo->uf_cargarnomina($ls_codnom); ?>
          </div>
        </div>
        <input name="operacion" type="hidden" id="operacion">
        <input name="existe" type="hidden" id="existe" value="<?php print $ls_existe;?>"></td>
      </form>
    </div>
</div>
<?php
	$io_cargo->uf_destructor();
	unset($io_cargo);
?>
</body>
</html>
