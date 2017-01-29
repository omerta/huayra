<?php
session_start();
if(!array_key_exists("la_logusr",$_SESSION))
{
	print "<script language=JavaScript>";
	print "location.href='../sigesp_inicio_sesion.php'";
	print "</script>";
}
require_once("sigesp_saf_c_activo.php");
$ls_codemp = $_SESSION["la_empresa"]["codemp"];
$io_saf_tipcat= new sigesp_saf_c_activo();
$ls_rbtipocat=$io_saf_tipcat->uf_select_valor_config($ls_codemp);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Sistema de Activos Fijos</title>
	<meta http-equiv="imagetoolbar" content="no">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<script type="text/javascript" src="../shared/js/jquery/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../shared/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
	<link href="../shared/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
	<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
	<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
	<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php

	// validaci�n de los release necesarios poara que funcione el sistema de n�mina
	require_once("../shared/class_folder/sigesp_release.php");
  $io_release= new sigesp_release();
	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_activo','codestpro1');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_movimiento','codrespri');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 3.32");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_dt_movimiento','estcat');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 3.33");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_item');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_1_04");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
    }
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_activo','codite');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_1_05");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('siv_articulo','codact');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2001_1_06");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('siv_dt_recepcion','estregact');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2001_1_07");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('siv_dt_despacho','estincact');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2001_1_08");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_cambioresponsable','codact');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2001_1_09");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}

	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_movimiento','ubigeoact');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2.27 ");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
   $li_tamano=$io_release->io_function_db->uf_tamano_type_columna('saf_conservacionbien','codconbie');
   if ($li_tamano=="1")
   {
	$io_release->io_msg->message(utf8_encode(" Debe Procesar Instala/Procesos/Mantenimiento/Release Version 2008_3_03 "));
	print "<script language=JavaScript>";
	print "location.href='../index_modules.php'";
	print "</script>";
   }
   $lb_valido=true;
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_activo','tipinm');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_3_38");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_edificios');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_3_39");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_tipoestructura');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_3_40");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_componente');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_3_41");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
	if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_edificiotipest');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release SIGESP BD 2008_3_42");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
	if($lb_valido)
	{
		$tamano1=$io_release->io_function_db->uf_tamano_type_columna('saf_activo','codrot');
		if ($tamano1=="1")
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_3_60");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_autsalida');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_07");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_dt_autsalida');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_07");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_entrega');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_08");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}

	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_dt_entrega');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_09");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_prestamo');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_10");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
    $lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_table('saf_dt_prestamo');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_10");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
	$lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_dta','estactpre');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_11");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
    $lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_dta','codunipre');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_12");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
    $lb_valido=true;
    if ($lb_valido)
	   {
		 $lb_existe = $io_release->io_function_db->uf_select_constraint('saf_activo','fk_saf_activo__saf_item');
		 if ($lb_existe)
	 	    {
			  $io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2008_4_27");
			  print "<script language=JavaScript>";
			  print "location.href='../index_modules.php'";
			  print "</script>";
		    }
	   }
    /*$lb_valido=true;
    if ($lb_valido)
	   {
		 $lb_existe = $io_release->uf_select_config('SAF','RELEASE','4_33');
		 if (!$lb_existe)
	 	    {
			  $io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2009_4_33");
			  print "<script language=JavaScript>";
			  print "location.href='../index_modules.php'";
			  print "</script>";
		    }
	   }*/
    $lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_movimiento','tipcmp');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2009_7_01");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
    $lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_movimiento','numcmp');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2009_7_02");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
    $lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_movimiento','estmov');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2009_7_03");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
	}
    $lb_valido=true;
    if($lb_valido)
	{
		$lb_valido=$io_release->io_function_db->uf_select_column('saf_autsalida','ced_bene');
		if($lb_valido==false)
		{
			$io_release->io_msg->message("Debe Procesar Instala/Procesos/Mantenimiento/Release 2010_5_01");
			print "<script language=JavaScript>";
			print "location.href='../index_modules.php'";
			print "</script>";
		}
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
				<?php if ($ls_rbtipocat == 1) { ?>
					<div class=""><script type="text/javascript" language="JavaScript1.2" src="js/menu_csc.js"></script></div>
				<?php }	elseif ($ls_rbtipocat == 2)	{ ?>
					<div class=""><script type="text/javascript" language="JavaScript1.2" src="js/menu_cgr.js"></script></div>
				<?php }	else { ?>
					<div class=""><script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script></div>
				<?php } ?>
		 </div>

<?php
	print "<div class='container'>";
	print "<h1 class='titulo'>Actividad Reciente</h1>";
	print "<table class='table table-condensed table-striped'>";
	print "<thead>";
	print "<tr class='titulo-celda'>";
	print "<th width=40>Evento</th>";
	print "<th width=40>Usuario</th>";
	print "<th width=40>Tipo Evento</th>";
	print "<th width=500>Descripci&oacute;n</th>";
	print "<th width=110>Fecha</th>";
	print "</tr>";
	print "</thead>";
	print "<tbody>";
	$eventos = $io_saf_tipcat->seguridad->uf_sss_registro_eventos_last("SAF");
	foreach($eventos as &$registro)
	{
		print "<tr class='celdas-blancas'>";
		print "<td align='center'>".$registro["numeve"]."</td>";
		print "<td align='center'>".$registro["codusu"]."</td>";
		print "<td align='center'>".$registro["evento"]."</td>";
		print "<td align='center'>".$registro["desevetra"]."</td>";
		print "<td align='center'>".$registro["fecevetra"]."</td>";
	}
	print "</tbody>";
	print "</table>";
	print "</div>";
?>
</body>
</html>
