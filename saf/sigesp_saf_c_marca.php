<?php
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/class_datastore.php");
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/sigesp_include.php");
require_once("../shared/class_folder/sigesp_c_seguridad.php");
require_once("../shared/class_folder/class_funciones.php");

/**
 * file_put_contents('/tmp/sugau_saf.log', print_r($lb_valido, TRUE), FILE_APPEND);
 */
class sigesp_saf_c_marca
{
	var $obj="";
	var $io_sql;
	var $siginc;
	var $con;

	function sigesp_saf_c_marca()
	{
		$this->io_msg=new class_mensajes();

		$this->dat_emp=$_SESSION["la_empresa"];

		$in=new sigesp_include();
		$this->con=$in->uf_conectar();
		$this->io_sql=new class_sql($this->con);
		$this->seguridad= new sigesp_c_seguridad();
		$this->io_funcion = new class_funciones();	
	}
	
	/**
	 * $as_formadqui
	 * @TODO no se esta registrando en la tabla de seguridad
	 * @TODO recuperar el detalle del mensaje de error y mostrarlo al usuario
	 */
	function uf_saf_insert_marca($as_codemp,$as_codmarca,$as_denominacion,$as_fabricante)
	{
		$lb_valido=true;
		$this->io_sql->begin_transaction();	
		$ls_sql = "INSERT INTO saf_sudebip_marcas_bienes_muebles (codemp,id_marca,denominacion_marca,nombre_fabricante)". 
				  "VALUES( '".$as_codemp."','".$as_codmarca."','".$as_denominacion."','".$as_fabricante."')";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			//print ($this->io_sql->message);
			//$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_insert_marca ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			//echo json_encode(array('errorMsg'=>'Some errors occured.'));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
				$lb_valido=true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////		
// 				$ls_evento="INSERT";
// 				$ls_descripcion ="Se inserto una nueva marca: ".$as_codmarca." ".$as_denominacioncomercial." ".$as_nombrefabricante." de la Empresa ".$as_codemp;
// 				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
// 												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
// 												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////		
				
				if($lb_valido)
				{
				    $this->io_sql->commit();
				}
				else
				{
					$this->io_sql->rollback();
				}
		}
		return $lb_valido;
	}

	function  uf_saf_update_marca($as_codemp,$as_codmarca,$as_denominacion,$as_fabricante)
	{	
		$lb_valido=true;
		$this->io_sql->begin_transaction();			
		$ls_sql="UPDATE saf_sudebip_marcas_bienes_muebles".
				"   SET denominacion_marca='".$as_denominacion."',nombre_fabricante='".$as_fabricante."'".
				" WHERE codemp =  '".$as_codemp."'". 
				"   AND id_marca =  '".$as_codmarca."'";  
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			//$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_update_marca ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
// 			$ls_evento="UPDATE";
// 			$ls_descripcion ="Actualizï¿½ el Activo ".$as_codact." de la Empresa ".$as_codemp;
// 			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
// 											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
// 											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////		
			
			if($lb_valido)
			{
				$this->io_sql->commit();
			}
			else
			{
				$this->io_sql->rollback();
			}
		}
	    return $lb_valido;
	}
	
	function uf_saf_delete_marca($as_codemp,$as_codmarca)
	{
		$lb_valido=false;
		$this->io_sql->begin_transaction();	
		$ls_sql = "DELETE FROM saf_sudebip_marcas_bienes_muebles WHERE codemp= '".$as_codemp. "' AND id_marca = '".$as_codmarca."'";
	   	$li_exec=$this->io_sql->execute($ls_sql);
	   	//file_put_contents('/tmp/sugau_saf.log', print_r($li_exec, TRUE), FILE_APPEND);
	   	if ($li_exec===false)
	  	{
			//$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_delete_marca ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
	  	}
	   	else
		{
		    $lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
// 			$ls_evento="DELETE";
// 			$ls_descripcion ="Eliminï¿½ el Activo ".$as_codact." de la Empresa ".$as_codemp;
// 			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
// 											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
// 											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////			
			$this->io_sql->commit();
		}
		return $lb_valido;
	}

}

?>
