<?php
// print_r($_POST);
// print_r($_SESSION);
class Condicion {
	//propiedades

	//metodos
	function __construct()
	{
		session_start();
		/**
		 * SEGURIDAD
		 * @la_logusr nombre de usuario
		 */
		if(!array_key_exists("la_logusr",$_SESSION))
		{
			print "<script language=JavaScript>";
			print "location.href='../sigesp_inicio_sesion.php'";
			print "</script>";
		}
		$ls_logusr=$_SESSION["la_logusr"];

		/**
		  * Consultamos los permisos del usuario sobre la ventana del sistema.
		  * $la_permiso regresa por referencia un array con: leer, incluir,
		  *				cambiar,eliminar,imprimir,anular y ejecutar.
		  * $la_seguridad regresa por referencia un array con: empresa, logusr,
		  *				sistema y ventanas.
		  */
		require_once("class_funciones_activos.php");
		$io_fun_activo=new class_funciones_activos();
		$io_fun_activo->uf_load_seguridad("SAF","sigesp_saf_d_condicion.php",$ls_permisos,$la_seguridad,$la_permisos);
		//file_put_contents('/tmp/sugau_saf.log', print_r($la_seguridad,TRUE), FILE_APPEND);

		/**
		  * @todo determinar la funci�n de este segmento de c�digo.
		  * sigesp_config
		  *	$ls_rbtipocat
		  */
		require_once("../shared/class_folder/class_mensajes.php");
		$io_mensaje= new class_mensajes();

		require_once("sigesp_saf_c_activo.php");
		$ls_codemp = $_SESSION["la_empresa"]["codemp"];
		$io_saf_tipcat= new sigesp_saf_c_activo();
		$ls_rbtipocat=$io_saf_tipcat->uf_select_valor_config($ls_codemp);
		if ($ls_rbtipocat == 0)
		{
			$io_mensaje->message("No se puede registrar ningun marca, sin definir la configuraci�n!!!");
			print "<script language=JavaScript>";
			print "location.href='sigespwindow_blank.php'";
			print "</script>";
		}
		/** SEGURIDAD */

		/* varibles cabecera */
		$fecha = date("j/n/Y")." - ".date("h:i a");
		$la_nomusu = $_SESSION["la_nomusu"];
		$la_apeusu = $_SESSION["la_apeusu"];
		$ls_database = $_SESSION["ls_database"];

		/* twig */
		require_once 'vendor/autoload.php';
		$loader = new Twig_Loader_Filesystem('templates');
		$twig = new Twig_Environment($loader, array('debug' => true,'charset' => "iso-8859-8",));

		$var_template = array(	'fecha' => $fecha,
							 	'usuario' => $la_nomusu,
								'usuario_apellido' => $la_apeusu,
								'db_name' => $ls_database,
								'rbtipocat' => $ls_rbtipocat,
								'loguser' => $ls_logusr,
								'ls_permisos' => $ls_permisos,
								'la_permisos' => $la_permisos,
								'la_permisos_leer' => $la_permisos[leer],
								'la_permisos_incluir' => $la_permisos[incluir],
								'la_permisos_cambiar' => $la_permisos[cambiar],
								'la_permisos_eliminar' => $la_permisos[eliminar],
								'la_permisos_imprimir' => $la_permisos[imprimir],
								'la_permisos_anular' => $la_permisos[anular],
								'la_permisos_ejecutar' => $la_permisos[ejecutar],
								'la_seguridad_empresa' => $la_seguridad[empresa],
								'la_seguridad_logusr' => $la_seguridad[logusr],
								'la_seguridad_sistema' => $la_seguridad[sistema],
								'la_seguridad_ventanas' => $la_seguridad[ventanas],
								'debug' => '1');

		/**
		 * Si se tiene permiso (true) se carga el template y al mismo tiempo
		 * se pasan las variables.
		 * Si no tiene permiso (false) se redirige a la presentaci�n del modulo.
		 */
		if($ls_permisos == true || $ls_logusr == "PSEGIS")
		{
			echo $twig->render('sigesp_saf_template_condicion.html',$var_template);
		}elseif ($ls_permisos == false){
			echo $twig->render('sigesp_saf_template_noaccess.html');
		}
	}

}

$condicion = new Condicion();
?>
