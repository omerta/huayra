<?php
  session_start();

  /**
   * Seguridad
   */
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

  /**
   * CRUD
   */
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

  /* varibles cabecera */
  $fecha = date("j/n/Y")." - ".date("h:i a");
  $la_nomusu = $_SESSION["la_nomusu"];
  $la_apeusu = $_SESSION["la_apeusu"];
  $ls_database = $_SESSION["ls_database"];

  /* poblar select Nómina */
  $nominas = $io_cargo->uf_cargarnomina($ls_codnom);

  /* twig */
  require_once '../shared/vendor/autoload.php'; //1.18.2
  $loader = new Twig_Loader_Filesystem('templates');
  $twig = new Twig_Environment($loader, array('debug' => true));
  //$twig->addExtension(new Twig_Extension_Debug());

  $var_template = array(
              'title' => 'Definicion de Catalogo',
              'fecha' => $fecha,
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
              'nominas' => $nominas,
              'existe' => $ls_existe,
              'operacion' => $operacion,
              'debug' => '0');

    if($ls_permisos == true || $ls_logusr == "PSEGIS")
    {
      echo $twig->render('sigesp_snorh_template_cargo.html',$var_template);
    }elseif ($ls_permisos == false){
      echo $twig->render('sigesp_saf_template_noaccess.html');
    }

  /**
   * uf_limpiarvariables
   *
   * Función que limpia todas las variables necesarias en la página.
   *
   * @author Yesenia Moreno (2008), SUGAU OPSU (2016)
   */
  function uf_limpiarvariables()
  {
    global $ls_codcar,$ls_descar,$ls_operacion,$ls_existe,$io_fun_nomina,$ls_codnom;

    $ls_codcar="";
    $ls_descar="";
    $ls_codnom="";
    $ls_operacion=$io_fun_nomina->uf_obteneroperacion();
    $ls_existe=$io_fun_nomina->uf_obtenerexiste();
  }

  /**
   * uf_load_variables
   *
   * Función que carga todas las variables necesarias en la página.
   *
   * @author Yesenia Moreno (2008),
   */
  function uf_load_variables()
  {
    global $ls_codcar, $ls_descar, $ls_codnom, $io_fun_nomina;

    $ls_codcar=$_POST["txtcodcar"];
    $ls_descar=$_POST["txtdescar"];
    $ls_codnom=$io_fun_nomina->uf_asignarvalor("cmbnomina",$_POST["txtcodnom"]);
  }

	$io_cargo->uf_destructor();
	unset($io_cargo);
?>
