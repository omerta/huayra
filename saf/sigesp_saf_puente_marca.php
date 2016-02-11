<?php
	//file_put_contents('/tmp/sugau_saf.log', print_r($_POST, TRUE), FILE_APPEND);
	session_start();
	require_once 'sigesp_saf_c_marca.php';

    $cod_marca = $_POST['codmarca'];
    $denominacion = $_POST['denominacion'];
    $denominacion = utf8_decode($denominacion);
    $fabricante = $_POST['fabricante'];
    $fabricante = utf8_decode($fabricante);
    $status = $_POST['status'];    
    $newstatus = $_POST['newstatus'];

    if ($newstatus == 'NEW')
    {
    	Nuevo();
    }
    elseif ($status == "" || $status == "G")
    {
    	Guardar($cod_marca,$denominacion,$fabricante,$status);
    }elseif ($status == "DELETE") {
    	Eliminar($cod_marca);
    }
    
    function Nuevo()
    {
    	require_once("../shared/class_folder/sigesp_include.php");
    	$in= new sigesp_include();
    	$con= $in->uf_conectar();
    	/* Establecida la conexión, cargamos la clase con los metodos generales
    	   de consulta sobre la base de datos */
    	require_once("../shared/class_folder/class_funciones_db.php");
    	$io_fundb= new class_funciones_db($con);
    	/* Se invoca el metodo que determina la llave primaria siguiente disponible,
    	   se trata de un número que identifica univocamente un objeto del sistema
    	   generalmente se denomina 'Código' en los formularios. */
    	$ls_tabla="saf_sudebip_marcas_bienes_muebles";
    	$ls_columna="id_marca";
    	$ls_codmarca=$io_fundb->uf_generar_codigo_serial($ls_tabla,$ls_columna);
    	echo $ls_codmarca;
    }

    /**
     *
     *
     */
	function Guardar($cod_marca,$denominacion,$fabricante,$status)
	{
		//$args = func_get_args();
		//file_put_contents('/tmp/sugau_saf.log', print_r($args, TRUE), FILE_APPEND);
		$io_saf= new sigesp_saf_c_marca();

		$ls_codemp = $_SESSION["la_empresa"]["codemp"];

		if($status=="")
		{
			$lb_valido=$io_saf->uf_saf_insert_marca($ls_codemp,$cod_marca,$denominacion,$fabricante);
		}elseif($status=="G")
		{
			$lb_valido=$io_saf->uf_saf_update_marca($ls_codemp,$cod_marca,$denominacion,$fabricante);
		}

		if($lb_valido == false)
		{
			echo false;
		}elseif ($lb_valido == true) {
			echo true;
		}
	}

	function Eliminar($cod_marca)
	{
		$io_saf= new sigesp_saf_c_marca();
		$ls_codemp = $_SESSION["la_empresa"]["codemp"];
		$lb_valido=$io_saf->uf_saf_delete_marca($ls_codemp,$cod_marca);
		if($lb_valido == false)
		{
			echo false;
		}elseif ($lb_valido == true) {
			echo true;
		}
	}
    
?>
