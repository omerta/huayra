<?php
// print_r($_POST);
// print_r($_SESSION);
class Rotulacion {
	//propiedades
	const SISTEMA = 'SAF';
	const VENTANA = 'sigesp_saf_d_rotulacion.php';

	//metodos
	function __construct()
	{
		session_start();
		/** SEGURIDAD
		 * @la_logusr nombre de usuario
		 */
		if(!array_key_exists("la_logusr",$_SESSION))
		{
			print "<script language=JavaScript>";
			print "location.href='../sigesp_inicio_sesion.php'";
			print "</script>";
		}
		$ls_logusr=$_SESSION["la_logusr"];

		/* */
		require_once("../shared/class_folder/class_mensajes.php");
		$io_mensaje= new class_mensajes();

		require_once("sigesp_saf_c_activo.php");
		$ls_codemp = $_SESSION["la_empresa"]["codemp"];
		$io_saf_tipcat= new sigesp_saf_c_activo();
		$ls_rbtipocat=$io_saf_tipcat->uf_select_valor_config($ls_codemp);
		if ($ls_rbtipocat == 0)
		{
			$io_mensaje->message("No se puede registrar ningun metodo de rotulacion, sin definir la configuracion!!!");
			print "<script language=JavaScript>";
			print "location.href='sigespwindow_blank.php'";
			print "</script>";
		}
		/** SEGURIDAD */

		/**
		* Consultamos los permisos del usuario sobre la ventana del sistema.
		* $la_permiso regresa por referencia un array con: leer, incluir,
		*				cambiar,eliminar,imprimir,anular y ejecutar.
		* $la_seguridad regresa por referencia un array con: empresa, logusr,
		*				sistema y ventanas.
		*/
		// require_once("class_funciones_activos.php");
		// $io_fun_activo=new class_funciones_activos();
		// $io_fun_activo->uf_load_seguridad("SAF","sigesp_saf_d_rotulacion.php",$ls_permisos,$la_seguridad,$la_permisos);

		// require_once("../shared/class_folder/sigesp_c_seguridad_26042016.php");
		// $checkSeguridad = new sigesp_c_seguridad();
		/* $aa_permisos es un Arreglo con los permisos del usuario */
		// $permisos = $checkSeguridad->uf_sss_load_permisos($_SESSION["la_empresa"]["codemp"],
		$permisos = $io_saf_tipcat->seguridad->uf_sss_load_permisos($_SESSION["la_empresa"]["codemp"],
																											$_SESSION["la_logusr"],
																											self::SISTEMA,
																											self::VENTANA,
																											$aa_permisos);

		/**
			* Si se tiene permiso (true) se carga el template y al mismo tiempo
			* se pasan las variables.
			* Si no tiene permiso (false) se redirige a la presentaci�n del modulo.
			*/
		if($aa_permisos["leer"] == true || $ls_logusr == "PSEGIS")
		{
			/* varibles cabecera */
			$fecha = date("j/n/Y")." - ".date("h:i a");
			$la_nomusu = $_SESSION["la_nomusu"];
			$la_apeusu = $_SESSION["la_apeusu"];
			$ls_database = $_SESSION["ls_database"];

			/* twig */
			require_once '../shared/vendor/autoload.php';
			$loader = new Twig_Loader_Filesystem('templates');
			$twig = new Twig_Environment($loader);

			$var_template = array(
								 	'fecha' => $fecha,
								 	'usuario' => $la_nomusu,
									'usuario_apellido' => $la_apeusu,
									'db_name' => $ls_database,
									'rbtipocat' => $ls_rbtipocat,
									'loguser' => $ls_logusr,
									'debug' => '0');

			echo $twig->render('sigesp_saf_template_rotulacion.html',$var_template);
		}elseif ($aa_permisos["leer"] == false){
			$host  = $_SERVER['HTTP_HOST'];
			header("Location: http://$host/saf/sigespwindow_blank.php");
			// echo $twig->render('sigesp_saf_template_noaccess.html');
		}
	}

}

$default = new Rotulacion();
?>
