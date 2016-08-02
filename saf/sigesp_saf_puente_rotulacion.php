<?php
	file_put_contents('/tmp/sugau_saf.log', print_r($_POST, TRUE), FILE_APPEND);
	//file_put_contents('/tmp/sugau_saf.log', print_r($_SESSION, TRUE), FILE_APPEND);
	session_start();
    require_once("sigesp_saf_c_rotulacion.php");

    $ls_codigo = $_POST['codigo'];
    $denominacion = $_POST['denominacion'];
    $denominacion = utf8_decode($denominacion);
    $empleo = $_POST['empleo'];
    $empleo = utf8_decode($empleo);
    $status = $_POST['status'];
    $newstatus = $_POST['newstatus'];

    if ($newstatus == 'NEW')
    {
    	Nuevo();
    }
    elseif ($status == "" || $status == "G")
    {
    	Guardar($ls_codigo,$denominacion,$empleo,$status);
    }elseif ($status == "DELETE") {
    	Eliminar($ls_codigo);
    }

    function Nuevo()
    {
    	require_once("../shared/class_folder/sigesp_include.php");
    	$in= new sigesp_include();
    	$con= $in->uf_conectar();
    	/* Establecida la conexiĂłn, cargamos la clase con los metodos generales
    	   de consulta sobre la base de datos */
    	require_once("../shared/class_folder/class_funciones_db_26042016.php");
    	$io_fundb= new class_funciones_db($con);
    	/* Se invoca el metodo que determina la llave primaria siguiente disponible,
    	   se trata de un nĂșmero que identifica univocamente un objeto del sistema
    	   generalmente se denomina 'CĂłdigo' en los formularios. */
    	$ls_tabla="saf_rotulacion";
    	$ls_columna="codrot";
    	$ls_codmarca=$io_fundb->uf_generar_codigo_serial($ls_tabla,$ls_columna);
    	echo $ls_codmarca;
    }

	function Guardar($ls_codigo,$denominacion,$empleo,$status)
	{
		//$args = func_get_args();
		//file_put_contents('/tmp/sugau_saf.log', print_r($args, TRUE), FILE_APPEND);
    $io_saf= new sigesp_saf_c_rotulacion();

		$ls_codemp = $_SESSION["la_empresa"]["codemp"];

		if($status=="")
		{
			$lb_valido=$io_saf->uf_saf_insert_rotulacion($ls_codigo,$denominacion,$empleo,$la_seguridad);
		}elseif($status=="G")
		{
			$lb_valido=$io_saf->uf_saf_update_rotulacion($ls_codigo,$denominacion,$empleo,$la_seguridad);
		}
        //file_put_contents('/tmp/sugau_saf.log', print_r($lb_valido, TRUE), FILE_APPEND);
        echo $lb_valido;
	}

	function Eliminar($ls_codigo)
	{
    $io_saf= new sigesp_saf_c_rotulacion();

		$lb_valido=$io_saf->uf_saf_delete_rotulacion($ls_codigo,$la_seguridad);
		if($lb_valido == false)
		{
			echo false;
		}elseif ($lb_valido == true) {
			echo true;
		}
	}

?>
