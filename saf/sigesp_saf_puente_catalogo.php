<?php
	session_start();
	file_put_contents('/tmp/sugau_saf.log', print_r($_POST, TRUE), FILE_APPEND);
	//file_put_contents('/tmp/sugau_saf.log', print_r($_SESSION, TRUE), FILE_APPEND);
  require_once("sigesp_saf_c_catalogo.php");

	$ls_catalogo = $_POST['catalogo'];
	$ls_denominacion = $_POST['denominacion'];
	$ls_denominacion = utf8_decode($ls_denominacion);
	$ls_cuenta = $_POST['cuenta'];
	$status = $_POST['status'];

	/* registro de sucesos */
	$la_seguridad["empresa"]= $_POST['log_empresa'];
	$la_seguridad["sistema"]= $_POST['log_sistema'];
	$la_seguridad["logusr"]= $_POST['log_logusr'];
	$la_seguridad["ventanas"]= $_POST['log_ventanas'];

	if ($status == "" || $status == "G")
  {
  	Guardar($ls_catalogo,$ls_denominacion,$ls_cuenta,$status,$la_seguridad);
  }elseif ($status == "DELETE") {
  	Eliminar($ls_catalogo,$la_seguridad);
  }

	function Guardar($ls_catalogo,$ls_denominacion,$ls_cuenta,$status,$la_seguridad)
	{
		//$args = func_get_args();
		//file_put_contents('/tmp/sugau_saf.log', print_r($args, TRUE), FILE_APPEND);
		$io_saf= new sigesp_saf_c_catalogo();

		$ls_codemp = $_SESSION["la_empresa"]["codemp"];

		if($status=="")
		{
			//$lb_valido=$io_saf->uf_saf_insert_$1($ls_codigo,$denominacion,$descripcion,$la_seguridad);
			$lb_valido=$io_saf->uf_saf_insert_catalogo($ls_catalogo,$ls_denominacion,$ls_cuenta,$la_seguridad);
		}elseif($status=="G")
		{
			//$lb_valido=$io_saf->uf_saf_update_$1($ls_codigo,$denominacion,$descripcion,$la_seguridad);
			$lb_valido=$io_saf->uf_saf_update_catalogo($ls_catalogo,$ls_denominacion,$ls_cuenta,$la_seguridad);
		}
      //file_put_contents('/tmp/sugau_saf.log', print_r($lb_valido, TRUE), FILE_APPEND);
      echo $lb_valido;
	}

	function Eliminar($ls_catalogo,$la_seguridad)
	{
		$io_saf= new sigesp_saf_c_catalogo();

		//$lb_valido=$io_saf->uf_saf_delete_$1($ls_codigo,$la_seguridad);
		$lb_valido=$io_saf->uf_saf_delete_catalogo($ls_catalogo,$la_seguridad);

		echo $lb_valido;
	}

?>
