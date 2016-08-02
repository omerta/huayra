<?php
		session_start();
		//file_put_contents('/tmp/sugau_saf.log', print_r($_POST, TRUE), FILE_APPEND);
		//file_put_contents('/tmp/sugau_saf.log', print_r($_SESSION, TRUE), FILE_APPEND);
    require_once("sigesp_saf_c_condicion.php");

    $ls_codigo = $_POST['codigo'];
    $denominacion = $_POST['denominacion'];
    $denominacion = utf8_decode($denominacion);
    $descripcion = $_POST['descripcion'];
    $descripcion = utf8_decode($descripcion);
    $status = $_POST['status'];
    $newstatus = $_POST['newstatus'];

		/* registro de sucesos */
		$la_seguridad["empresa"]= $_POST['log_empresa'];
		$la_seguridad["sistema"]= $_POST['log_sistema'];
		$la_seguridad["logusr"]= $_POST['log_logusr'];
		$la_seguridad["ventanas"]= $_POST['log_ventanas'];


    if ($newstatus == 'NEW')
    {
    	Nuevo();
    }
    elseif ($status == "" || $status == "G")
    {
    	Guardar($ls_codigo,$denominacion,$descripcion,$status,$la_seguridad);
    }elseif ($status == "DELETE") {
    	Eliminar($ls_codigo,$la_seguridad);
    }

    function Nuevo()
    {
    	require_once("../shared/class_folder/sigesp_include.php");
    	$in= new sigesp_include();
    	$con= $in->uf_conectar();
    	/* Establecida la conexión, cargamos la clase con los metodos generales
    	   de consulta sobre la base de datos */
    	require_once("../shared/class_folder/class_funciones_db_26042016.php");
    	$io_fundb= new class_funciones_db($con);
    	/* Se invoca el metodo que determina la llave primaria siguiente disponible,
    	   se trata de un número que identifica univocamente un objeto del sistema
    	   generalmente se denomina 'Código' en los formularios. */
    	$ls_tabla="saf_conservacionbien";
    	$ls_columna="codconbie";
    	$ls_codmarca=$io_fundb->uf_generar_codigo_serial($ls_tabla,$ls_columna);
    	echo $ls_codmarca;
    }

    /**
     *
     * @TODO Parece existir una diferencia en la manera que la función
     * 	     uf_generar_codigo determina la siguiente llave primaria
     *		 y la forma en que lo hace el insert. La función puede
     *		 regresar el valor de '3' pero se inserta '73', por ejemplo.
     */
	function Guardar($ls_codigo,$denominacion,$descripcion,$status,$la_seguridad)
	{
		//$args = func_get_args();
		//file_put_contents('/tmp/sugau_saf.log', print_r($args, TRUE), FILE_APPEND);
    $io_saf= new sigesp_saf_c_condicion();

		$ls_codemp = $_SESSION["la_empresa"]["codemp"];

		if($status=="")
		{
			$lb_valido=$io_saf->uf_saf_insert_condicion($ls_codigo,$denominacion,$descripcion,$la_seguridad);
		}elseif($status=="G")
		{
			$lb_valido=$io_saf->uf_saf_update_condicion($ls_codigo,$denominacion,$descripcion,$la_seguridad);
		}
    //file_put_contents('/tmp/sugau_saf.log', print_r($lb_valido, TRUE), FILE_APPEND);
    echo $lb_valido;
	}

	function Eliminar($ls_codigo,$la_seguridad)
	{
    $io_saf= new sigesp_saf_c_condicion();

		$lb_valido=$io_saf->uf_saf_delete_condicion($ls_codigo,$la_seguridad);

		echo $lb_valido;
	}

?>
