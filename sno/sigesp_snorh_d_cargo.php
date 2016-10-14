<?php

class Cargo {
  //variables
  public $io_fun_nomina;
  public $ls_codcar;
  public $ls_descar;
  public $ls_operacion;
  public $ls_existe;
  public $ls_codnom;

  function __construct()
  {
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
  	$this->io_fun_nomina=new class_funciones_nomina();
  	$this->io_fun_nomina->uf_load_seguridad("SNR","sigesp_snorh_d_cargo.php",$ls_permisos,$la_seguridad,$la_permisos);

    /**
     * CRUD
     */
  	require_once("sigesp_snorh_c_cargo.php");
  	$io_cargo=new sigesp_snorh_c_cargo();
  	$this->uf_limpiarvariables();

  	switch ($this->ls_operacion)
  	{
  		case "GUARDAR":
  			$this->uf_load_variables();
        $lb_valido=$io_cargo->uf_guardar($this->ls_existe,$this->ls_codcar,$this->ls_descar,$this->ls_codnom,$la_seguridad);
  			if($lb_valido)
  			{
  				$this->uf_limpiarvariables();
  				$ls_existe="FALSE";
  			}
  			break;

  		case "ELIMINAR":
  			$this->uf_load_variables();
  			$lb_valido=$io_cargo->uf_delete_cargo($this->ls_codcar,$this->ls_codnom,$la_seguridad);
  			if($lb_valido)
  			{
  				$this->uf_limpiarvariables();
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
    require_once '../shared/vendor/autoload.php';
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
                'existe' => $this->ls_existe,
                'operacion' => $this->ls_operacion,
                'debug' => '0');

      if($ls_permisos == true || $ls_logusr == "PSEGIS")
      {
        echo $twig->render('sigesp_snorh_template_cargo.html',$var_template);
      }elseif ($ls_permisos == false){
        echo $twig->render('sigesp_saf_template_noaccess.html');
      }

      $io_cargo->uf_destructor();
      unset($io_cargo);
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
    $this->ls_codcar="";
    $this->ls_descar="";
    $this->ls_codnom="";
    $this->ls_operacion=$this->io_fun_nomina->uf_obteneroperacion();
    $this->ls_existe=$this->io_fun_nomina->uf_obtenerexiste();
  }

  /**
   * uf_load_variables
   *
   * Función que carga todas las variables necesarias en la página.
   *
   * @author Yesenia Moreno (2008), SUGAU OPSU (2016)
   */
  function uf_load_variables()
  {
    $this->ls_codcar=$_POST["txtcodcar"];
    $this->ls_descar=$_POST["txtdescar"];
    $this->ls_codnom=$this->io_fun_nomina->uf_asignarvalor("cmbnomina",$_POST["txtcodnom"]);
  }

}

$cargo = new Cargo();
?>
