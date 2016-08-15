<?php

//namespace Saf;

class Materiales {

	function __construct()
	{
		session_start();
		if(!array_key_exists("la_logusr",$_SESSION))
		{
			print "<script language=JavaScript>";
			print "location.href='../sigesp_inicio_sesion.php'";
			print "</script>";
		}
		$ls_logusr=$_SESSION["la_logusr"];

		require_once("class_funciones_activos.php");
		$io_fun_activo=new class_funciones_activos();
		$io_fun_activo->uf_load_seguridad("SAF","sigesp_saf_d_materiales.php",$ls_permisos,$la_seguridad,$la_permisos);

		require_once("sigesp_saf_c_activo.php");
		$ls_codemp = $_SESSION["la_empresa"]["codemp"];

		$io_saf_tipcat= new sigesp_saf_c_activo();
		$ls_rbtipocat=$io_saf_tipcat->uf_select_valor_config($ls_codemp);

		if($ls_rbtipocat == 0)
		{
			require_once("../shared/class_folder/class_mensajes.php");
			$io_mensaje= new class_mensajes();
			$io_mensaje->message("No se puede registrar sin definir la configuraci&ocuten!");
			print "<script language=JavaScript>";
			print "location.href='sigespwindow_blank.php'";
			print "</script>";
		}

		/* varibles cabecera */
		$fecha = date("j/n/Y")." - ".date("h:i a");
		$la_nomusu = $_SESSION["la_nomusu"];
		$la_apeusu = $_SESSION["la_apeusu"];
		$ls_database = $_SESSION["ls_database"];

		/* twig */
		require_once 'vendor/autoload.php';
		$loader = new Twig_Loader_Filesystem('templates');
		$twig = new Twig_Environment($loader);

		$var_template = array(
								'title' => 'Definici&oacute;n de Estructuras Predominantes de los Inmuebles',
								'fecha' => $fecha,
								'usuario' => $la_nomusu,
								'usuario_apellido' => $la_apeusu,
								'db_name' => $ls_database,
								'rbtipocat' => $ls_rbtipocat,
								'loguser' => $ls_logusr,
								'ls_permisos' => $ls_permisos,
								'la_permisos_leer' => $la_permisos['leer'],
								'la_permisos_incluir' => $la_permisos['incluir'],
								'la_permisos_cambiar' => $la_permisos['cambiar'],
								'la_permisos_eliminar' => $la_permisos['eliminar'],
								'la_permisos_imprimir' => $la_permisos['imprimir'],
								'la_permisos_anular' => $la_permisos['anular'],
								'la_permisos_ejecutar' => $la_permisos['ejecutar'],
								'la_seguridad_empresa' => $la_seguridad['empresa'],
								'la_seguridad_logusr' => $la_seguridad['logusr'],
								'la_seguridad_sistema' => $la_seguridad['sistema'],
								'la_seguridad_ventanas' => $la_seguridad['ventanas'],
								'debug' => '0');

				/**
				 * Si se tiene permiso (true) se carga el template y al mismo tiempo
				 * se pasan las variables.
				 * Si no tiene permiso (false) se redirige a la presentaci�n del modulo.
				 */
				if($ls_permisos == true || $ls_logusr == "PSEGIS")
				{
					echo $twig->render('sigesp_saf_template_materiales.html',$var_template);
				}elseif ($ls_permisos == false){
					echo $twig->render('sigesp_saf_template_noaccess.html');
				}
		}
}

$materiales = new Materiales();

/*
<?php
  require_once("class_funciones_activos.php");
	$io_fac= new class_funciones_activos("../");

	require_once("../shared/class_folder/class_mensajes.php");
	$io_msg= new class_mensajes();

	require_once("sigesp_saf_c_materiales.php");
	$io_material= new sigesp_saf_c_materiales();

	require_once("../shared/class_folder/sigesp_include.php");
	$in=     new sigesp_include();
	$con= 	 $in->uf_conectar();
	require_once("../shared/class_folder/class_funciones_db.php");
	$io_fun= new class_funciones_db($con);
	$arre=$_SESSION["la_empresa"];
	$ls_empresa=$arre["codemp"];
*/

?>
