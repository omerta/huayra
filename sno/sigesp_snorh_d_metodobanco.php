<?php
  session_start();
  //print_r($_POST);
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
	$io_fun_nomina->uf_load_seguridad("SNR","sigesp_snorh_d_metodobanco.php",$ls_permisos,$la_seguridad,$la_permisos);
	//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////

   //--------------------------------------------------------------
   function uf_limpiarvariables()
   {
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	Function:  uf_limpiarvariables
		//	Description: Funci�n que limpia todas las variables necesarias en la p�gina
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
   	global $ls_codmet,$ls_desmet,$ls_tipmet,$ls_codempnom,$ls_tipcuecrenom,$ls_tipcuedebnom,$ls_numplalph;
		global $ls_numconlph,$ls_suclph,$ls_cuelph,$ls_grulph,$ls_subgrulph,$ls_conlph,$ls_numactlph,$ls_numofifps;
		global $ls_numfonfps,$ls_confps,$ls_nroplafps,$ls_nomtipmet,$ls_existe,$ls_operacion,$io_fun_nomina;
		global $ls_codofinom,$ls_debcuelph,$ls_codagelph,$ls_apaposlph,$ls_numconnom, $ls_pagtaqnom,$lb_ref;

		$ls_codmet="";
		$ls_desmet="";
		$ls_tipmet="";
		$ls_codempnom="";
		$ls_codofinom="";
		$ls_tipcuecrenom="";
		$ls_tipcuedebnom="";
		$ls_numplalph="";
		$ls_numconlph="";
		$ls_suclph="";
		$ls_cuelph="";
		$ls_grulph="";
		$ls_subgrulph="";
		$ls_conlph="";
		$ls_numactlph="";
		$ls_numofifps="";
		$ls_numfonfps="";
		$ls_confps="";
		$ls_nroplafps="";
		$ls_confps="";
		$ls_nroplafps="";
		$ls_nomtipmet="";
		$ls_debcuelph="";
		$ls_codagelph="";
		$ls_apaposlph="";
		$ls_numconnom="";
		$ls_pagtaqnom="";
		$lb_ref="";
		$ls_existe=$io_fun_nomina->uf_obtenerexiste();
		$ls_operacion=$io_fun_nomina->uf_obteneroperacion();
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
		// Fecha Creaci�n: 18/03/2006 								Fecha �ltima Modificaci�n :
		//////////////////////////////////////////////////////////////////////////////
   	global $ls_codmet,$ls_desmet,$ls_tipmet,$ls_nomtipmet,$ls_codempnom,$ls_tipcuecrenom;
		global $ls_tipcuedebnom,$ls_numplalph,$ls_numconlph,$ls_suclph,$ls_cuelph,$ls_grulph,$ls_subgrulph,$ls_conlph;
		global $ls_numactlph,$ls_numofifps,$ls_numfonfps,$ls_confps,$ls_nroplafps,$io_fun_nomina,$ls_codofinom,$ls_debcuelph;
		global $ls_codagelph,$ls_apaposlph,$ls_numconnom,$ls_pagtaqnom,$lb_ref;

		$ls_codmet=$_POST["txtcodmet"];
		$ls_desmet=$_POST["txtdesmet"];
		//$ls_tipmet=$_POST["txttipmet"];
		//$ls_nomtipmet=$_POST["txtnomtipmet"];
    $ls_tipmet=$_POST["radiotipmet"];

    /* nomina */
    if($ls_tipmet=='0')
    {
  		$ls_codempnom=$io_fun_nomina->uf_obtenervalor("txtcodempnom","");
      $ls_numconnom=$io_fun_nomina->uf_obtenervalor("txtnumconnom","");
  		$ls_codofinom=$io_fun_nomina->uf_obtenervalor("txtcodofinom","");
  		$ls_tipcuecrenom=$io_fun_nomina->uf_obtenervalor("txttipcuecrenom","");
  		$ls_tipcuedebnom=$io_fun_nomina->uf_obtenervalor("txttipcuedebnom","");
      $ls_pagtaqnom=$io_fun_nomina->uf_obtenervalor("chkpagtaqnom","0");
      $lb_ref=$io_fun_nomina->uf_obtenervalor("checkref","0");
    }
    /* ley de politica */
    if($ls_tipmet=='1')
    {
      $ls_codagelph=$io_fun_nomina->uf_obtenervalor("txtcodagelph","");
  		$ls_apaposlph=$io_fun_nomina->uf_obtenervalor("txtapaposlph","");
  		$ls_debcuelph=$io_fun_nomina->uf_obtenervalor("chkdebcuelph","0");
  		$ls_numplalph=$io_fun_nomina->uf_obtenervalor("txtnumplalph","");
  		$ls_numconlph=$io_fun_nomina->uf_obtenervalor("txtnumconlph","");
  		$ls_suclph=$io_fun_nomina->uf_obtenervalor("txtsuclph","");
  		$ls_cuelph=$io_fun_nomina->uf_obtenervalor("txtcuelph","");
  		$ls_grulph=$io_fun_nomina->uf_obtenervalor("txtgrulph","");
  		$ls_subgrulph=$io_fun_nomina->uf_obtenervalor("txtsubgrulph","");
  		$ls_conlph=$io_fun_nomina->uf_obtenervalor("txtconlph","");
  		$ls_numactlph=$io_fun_nomina->uf_obtenervalor("txtnumactlph","");
    }
    /* prestaciones sociales */
    if($ls_tipmet=='2')
    {
      $ls_numofifps=$io_fun_nomina->uf_obtenervalor("txtnumofifps","");
  		$ls_numfonfps=$io_fun_nomina->uf_obtenervalor("txtnumfonfps","");
  		$ls_confps=$io_fun_nomina->uf_obtenervalor("txtconfps","");
  		$ls_nroplafps=$io_fun_nomina->uf_obtenervalor("txtnroplafps","");
    }
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
<title >Definici&oacute;n de M&eacute;todo a Banco</title>
<meta http-equiv="imagetoolbar" content="no">

<script type="text/javascript" src="../shared/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../shared/bootstrap-3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../shared/bootstrap-3.3.5/css/bootstrap.min.css">

<script type="text/javascript" src="js/sigesp_snorh_d_metodobanco.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="js/funcion_nomina.js"></script>
<link href="css/nomina.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">


<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->



</script>

</head>
<body>
<?php
	require_once("sigesp_snorh_c_metodobanco.php");
	$io_metodobanco=new sigesp_snorh_c_metodobanco();
	uf_limpiarvariables();
	switch ($ls_operacion)
	{
		case "GUARDAR":
			uf_load_variables();
			$lb_valido=$io_metodobanco->uf_guardar($ls_existe,$ls_codmet,$ls_desmet,$ls_tipmet,$ls_codempnom,$ls_codofinom,
												   $ls_tipcuecrenom,$ls_tipcuedebnom,$ls_numplalph,$ls_numconlph,$ls_suclph,
												   $ls_cuelph,$ls_grulph,$ls_subgrulph,$ls_conlph,$ls_numactlph,$ls_numofifps,
												   $ls_numfonfps,$ls_confps,$ls_nroplafps,$ls_debcuelph,$ls_codagelph,
												   $ls_apaposlph,$ls_numconnom,$ls_pagtaqnom,$lb_ref,$la_seguridad);
			if($lb_valido)
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
			}
			break;

		case "ELIMINAR":
			uf_load_variables();
			$lb_valido=$io_metodobanco->uf_delete($ls_codmet,$ls_tipmet,$la_seguridad);
			if($lb_valido)
			{
				uf_limpiarvariables();
				$ls_existe="FALSE";
			}
			break;

		case "BUSCAR":
			uf_load_variables();
			$lb_valido=$io_metodobanco->uf_load_metodobanco($ls_existe,$ls_codmet,$ls_desmet,$ls_tipmet,$ls_codempnom,$ls_codofinom,
														    $ls_tipcuecrenom,$ls_tipcuedebnom,$ls_numplalph,$ls_numconlph,
															$ls_suclph,$ls_cuelph,$ls_grulph,$ls_subgrulph,$ls_conlph,$ls_numactlph,
															$ls_numofifps,$ls_numfonfps,$ls_confps,$ls_nroplafps,$ls_debcuelph,
															$ls_codagelph,$ls_apaposlph,$ls_numconnom,$ls_pagtaqnom,$lb_ref);
			$io_fun_nomina->uf_seleccionarcombo("1-2-3",$ls_tipmet,$la_tipmet,3);
			if($ls_debcuelph=="1")
			{
				$ls_debcuelph="checked";
			}
			else
			{
				$ls_debcuelph="";
			}
			break;

		case "CARGARMETODO":
			uf_load_variables();
			break;
	}
	$io_metodobanco->uf_destructor();
	unset($io_metodobanco);
?>
<table width="762" border="0" align="center" cellpadding="0" cellspacing="0" class="contorno">
  <tr>
    <td width="780" height="30" colspan="11" class="cd-logo"><img src="../shared/imagebank/header.jpg" width="778" height="40"></td>
  </tr>
  <tr>
    <td width="432" height="20" colspan="11" bgcolor="#E7E7E7">
		<table width="762" border="0" align="center" cellpadding="0" cellspacing="0">
			<td width="432" height="20" bgcolor="#E7E7E7" class="descripcion_sistema">Sistema de N&oacute;mina</td>
			<td width="346" bgcolor="#E7E7E7" class="letras-pequenas"><div align="right"><b><?php print date("j/n/Y")." - ".date("h:i a");?></b></div></td>
	  	    <tr>
	  	      <td height="20" bgcolor="#E7E7E7" class="descripcion_sistema">&nbsp;</td>
	  	      <td bgcolor="#E7E7E7" class="letras-pequenas"><div align="right"><b><?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?></b></div></td></tr>
        </table>
	 </td>
  </tr>
  <tr>
    <td height="20" colspan="11" bgcolor="#E7E7E7" class="cd-menu"><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></td>
  </tr>
  <tr>
    <td width="780" height="13" colspan="11" class="toolbar"></td>
  </tr>
  <tr>
    <td class="toolbar" width="25">
      <div align="center">
        <a href="javascript: ue_nuevo();">
          <img src="../shared/imagebank/tools20/nuevo.gif" title="Nuevo" alt="Nuevo" width="20" height="20" border="0">
        </a>
      </div>
    </td>
    <td class="toolbar" width="25">
      <div align="center">
        <a href="javascript: ue_guardar();">
          <img src="../shared/imagebank/tools20/grabar.gif" title="Guardar" alt="Grabar" width="20" height="20" border="0">
        </a>
      </div>
    </td>
    <td class="toolbar" width="25">
      <div align="center">
        <a href="javascript: ue_buscar();">
          <img src="../shared/imagebank/tools20/buscar.gif" title="Buscar" alt="Buscar" width="20" height="20" border="0">
        </a>
      </div>
    </td>
    <td class="toolbar" width="25">
      <div align="center">
        <a href="javascript: ue_cerrar();">
          <img src="../shared/imagebank/tools20/salir.gif" title="Salir" alt="Salir" width="20" height="20" border="0">
        </a>
      </div>
    </td>
    <td class="toolbar" width="25">
      <div align="center">
        <a href="javascript: ue_ayuda();">
          <img src="../shared/imagebank/tools20/ayuda.gif" title="Ayuda" alt="Ayuda" width="20" height="20" border="0">
        </a>
      </div>
    </td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="25"><div align="center"></div></td>
    <td class="toolbar" width="530">&nbsp;</td>
  </tr>
</table>

<p>&nbsp;</p>

<form class="form-horizontal" name="form1" method="post" action="">
<div class="container">
<?php
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
	$io_fun_nomina->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
	unset($io_fun_nomina);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
?>

    <h4 class="titulo-ventana">Definici&oacute;n de M&eacute;todo a Banco</h4>

    <div class="form-group">
      <label class="control-label col-md-2">C&oacute;digo</label>
      <div class="col-md-4">
        <input class="form-control" name="txtcodmet" type="text" id="txtcodmet" value="<?php print $ls_codmet;?>" onKeyUp="javascript: ue_validarnumero(this);" onBlur="javascript: ue_rellenarcampo(this,4);">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-md-2">Descripci&oacute;n</label>
      <div class="col-md-4">
        <input class="form-control" name="txtdesmet" type="text" id="txtdesmet" value="<?php print $ls_desmet;?>" onKeyUp="javascript: ue_validarcomillas(this);">
      </div>
    </div>

            <!--    <input name="txtnomtipmet" type="text" id="txtnomtipmet" value="<?php print $ls_nomtipmet;?>" size="50" maxlength="100">-->
            <!--    <input name="txttipmet" type="hidden" id="txttipmet" value="<?php print $ls_tipmet;?>">-->

    <div class="form-group">
      <label class="control-label col-md-2" for="">Tipo</label>
      <div class="col-md-10">
        <div class="radio-inline">
          <input name="radiotipmet" type="radio" value="0">N&oacute;mina
        </div>
        <div class="radio-inline">
          <input name="radiotipmet" type="radio" value="1">Ley de Pol&iacute;tica
        </div>
        <div class="radio-inline">
          <input name="radiotipmet" type="radio" value="2">Prestaciones Sociales
        </div>
      </div>
    </div>

    <div id="nomina" class="nomina box" style="display:none">
        <h3 class="titulo-ventana">N&oacute;mina</h3>

        <div class="form-group">
          <label for="" class="control-label col-md-2">C&oacute;digo de Empresa</label>
          <div class="col-md-4">
            <input class="form-control" name="txtcodempnom" type="text" id="txtcodempnom" maxlength="10" value="<?php print $ls_codempnom;?>" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Nro. Convenio/C&oacute;d. Banco</label>
          <div class="col-md-4">
            <input class="form-control" name="txtnumconnom" type="text" id="txtnumconnom" maxlength="8" value="<?php print $ls_numconnom;?>" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">C&oacute;digo de Oficina</label>
          <div class="col-md-4">
            <input class="form-control" name="txtcodofinom" type="text" id="txtcodofinom" maxlength="5" value="<?php print $ls_codofinom;?>" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Tipo de Cuenta Cr&eacute;dito</label>
          <div class="col-md-4">
            <input class="form-control" name="txttipcuecrenom" type="text" id="txttipcuecrenom" maxlength="2" value="<?php print $ls_tipcuecrenom;?>" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Tipo de Cuenta D&eacute;bito</label>
          <div class="col-md-4">
            <input class="form-control" name="txttipcuedebnom" type="text" id="txttipcuedebnom" maxlength="2" value="<?php print $ls_tipcuedebnom;?>" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Pago por Taquilla</label>
          <div class="col-md-4">
              <input class="form-control" name="chkpagtaqnom" type="checkbox" class="sin-borde" id="chkpagtaqnom" value="1" <?php if($ls_pagtaqnom=="1"){print "checked"; }?>>
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Autoincrementar Nro de Ref.</label>
          <div class="col-md-4">
              <input class="form-control" type="checkbox" name="checkref" id="checkref" value="1" <?php if($lb_ref=="1"){print "checked";};?>>
          </div>
        </div>
    </div>

    <div id="politica" class="politica box" style="display:none">
          <h3 class="titulo-ventana">Ley de Pol&iacute;tica</h3>

          <div class="form-group">
            <label for="" class="control-label col-md-2">C&oacute;digo de Agencia</label>
            <div class="col-md-4">
              <input class="form-control" name="txtcodagelph" type="text" id="txtcodagelph" value="<?php print $ls_codagelph;?>" size="18" maxlength="3" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Apartado Postal</label>
            <div class="col-md-4">
              <input class="form-control" name="txtapaposlph" type="text" id="txtapaposlph" value="<?php print $ls_apaposlph;?>" size="18" maxlength="8" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Debito a Cuenta</label>
            <div class="col-md-4">
                <input class="form-control" name="chkdebcuelph" type="checkbox" class="sin-borde" id="chkdebcuelph" value="1" <?php print $ls_debcuelph;?>>
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Nro de Planilla</label>
            <div class="col-md-4">
              <input class="form-control" name="txtnumplalph" type="text" id="txtnumplalph" value="<?php print $ls_numplalph;?>" size="18" maxlength="15" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Nro de Contrato</label>
            <div class="col-md-4">
              <input class="form-control" name="txtnumconlph" type="text" id="txtnumconlph" value="<?php print $ls_numconlph;?>" size="13" maxlength="10" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Sucursal</label>
            <div class="col-md-4">
              <input class="form-control" name="txtsuclph" type="text" id="txtsuclph" value="<?php print $ls_suclph;?>" size="8" maxlength="5" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Cuenta</label>
            <div class="col-md-4">
              <input class="form-control" name="txtcuelph" type="text" id="txtcuelph" value="<?php print $ls_cuelph;?>" size="28" maxlength="25" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Grupo</label>
            <div class="col-md-4">
              <input class="form-control" name="txtgrulph" type="text" id="txtgrulph" value="<?php print $ls_grulph;?>" size="13" maxlength="10" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Subgrupo</label>
            <div class="col-md-4">
              <input class="form-control" name="txtsubgrulph" type="text" id="txtsubgrulph" value="<?php print $ls_subgrulph;?>" size="8" maxlength="5" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Contrato</label>
            <div class="col-md-4">
              <input class="form-control" name="txtconlph" type="text" id="txtconlph" value="<?php print $ls_conlph;?>" size="18" maxlength="15" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>

          <div class="form-group">
            <label for="" class="control-label col-md-2">Nro de Archivo</label>
            <div class="col-md-4">
              <input class="form-control" name="txtnumactlph" type="text" id="txtnumactlph" value="<?php print $ls_numactlph;?>" size="13" maxlength="10" onKeyUp="javascript: ue_validarcomillas(this);">
            </div>
          </div>
    </div>

    <div id="prestaciones" class="prestaciones box" style="display:none">
        <h3 class="titulo-ventana">Prestaciones Sociales</h3>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Nro de Oficina</label>
          <div class="col-md-4">
            <input class="form-control" name="txtnumofifps" type="text" id="txtnumofifps" value="<?php print $ls_numofifps;?>" size="8" maxlength="3" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Nro de Fondo</label>
          <div class="col-md-4">
            <input class="form-control" name="txtnumfonfps" type="text" id="txtnumfonfps" value="<?php print $ls_numfonfps;?>" size="13" maxlength="6" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Contrato</label>
          <div class="col-md-4">
            <input class="form-control" name="txtconfps" type="text" id="txtconfps" value="<?php print $ls_confps;?>" size="13" maxlength="6" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>

        <div class="form-group">
          <label for="" class="control-label col-md-2">Nro Plan</label>
          <div class="col-md-4">
            <input class="form-control" name="txtnroplafps" type="text" id="txtnroplafps" value="<?php print $ls_nroplafps;?>" size="13" maxlength="10" onKeyUp="javascript: ue_validarcomillas(this);">
          </div>
        </div>
    </div>

      <input name="operacion" type="hidden" id="operacion">
      <input name="existe" type="hidden" id="existe" value="<?php print $ls_existe;?>"></td>

</body>
</html>
