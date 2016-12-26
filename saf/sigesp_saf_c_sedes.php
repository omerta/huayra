<?php
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/class_funciones.php");
require_once("../shared/class_folder/class_datastore.php");
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/sigesp_include.php");
require_once("../shared/class_folder/sigesp_c_seguridad.php");

/**
 * Clase
 */
class sigesp_saf_c_sedes
{
	var $obj="";
	var $io_sql;
	var $siginc;
	var $con;

	/**
	 * Función constructora
	 */
	function sigesp_saf_c_sedes()
	{
		$this->io_msg=new class_mensajes();
        $this->ls_codemp=$_SESSION["la_empresa"]["codemp"];
		$in=new sigesp_include();
		$this->con=$in->uf_conectar();
		$this->io_sql=new class_sql($this->con);
		$this->seguridad= new sigesp_c_seguridad();
		$this->io_funcion = new class_funciones();
	}

	/**
	 * uf_saf_select_sedes
	 * Funcion que busca una rotulacion en la tabla saf_sedes
	 * @access public
	 * @param $as_codigo 
	 * @return Retorna un Booleano
	 * @todo Esta función no es usada se debe determinar la posible eliminación
	 */
	function uf_saf_select_sedes($as_codigo)
	{
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_sedes  ".
				  " WHERE codrot='".$as_codigo."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->rotulacion MÉTODO->uf_saf_select_sedes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
			}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin uf_saf_select_sedes


	/**
 	 * Function: uf_saf_insert_sedes
	 * Funcion que inserta una sede en la tabla sudebip_sedes_similares
	 * @access public
	 * @param $as_codigo codigo de rotulacion
	 * @param $as_denominacion denominacion de la rotulacion
	 * @param $as_empleo empleo de la rotulacion
	 * @param $aa_seguridad arreglo de registro de seguridad
	 * @return Retorna un Booleano
	 * @todo separar el segmento de seguridad de la operación principal sobre la base de datos
	 * se ha determina que al fallar la ejecución del código relacionado con la seguridad
	 * no se ejecuta la operación principal sobre la base de datos, a pesar de esto el mensaje
	 * regresado es de un operación exitosa cunado en realidad no se ha ejecutado el INSERT/UPDATE/etc
	 * sobre la base de datos.
	 */
	function  uf_saf_insert_sedes($as_codemp,$as_codigo,$as_denominacion,$as_tiposede,$as_tipolocalizacion,$as_codpais,
								  $as_codestado,$as_codmunicipio,$as_codciudad,$as_codparroquia,$as_urbanizacion,
								  $as_calle,$as_casa,$as_piso,$aa_seguridad)
	{
		$lb_valido=false;
        $this->io_sql->begin_transaction();
		$ls_sql = "INSERT INTO sudebip_sedes_similares (codemp,codigo_sede,descripcion,codigo_tipo_sede,localizacion_sede,codigo_pais,
													   codigo_estado,codigo_municipio,codigo_ciudad,codigo_parroquia,urbanizacion,
													   calle,casa,piso) ".
                  "VALUES ('".$as_codemp."','".$as_codigo."','".$as_denominacion."','".$as_tiposede."','".$as_tipolocalizacion."',
                  		   '".$as_codpais."','".$as_codestado."','".$as_codmunicipio."','".$as_codciudad."','".$as_codparroquia."',
                  		   '".$as_urbanizacion."','".$as_calle."','".$as_casa."','".$as_piso."')";

		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->rotulacion MÉTODO->uf_saf_insert_sedes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();

		}
		else
		{
				$lb_valido=true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////		
				$ls_evento="INSERT";
				$ls_descripcion ="Insertó la Sede ".$as_codigo;
				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				//file_put_contents('/tmp/sugau_saf.log', print_r($ls_variable, TRUE), FILE_APPEND);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////		
				$this->io_sql->commit();
		}
		return $lb_valido;
	}//fin uf_saf_insert_sedes

	/**
 	 * uf_saf_update_sedes
 	 * Funcion que modifica una sede en la tabla sudebip_sedes_similares
 	 * @access public
 	 * @return array
 	 */
	function uf_saf_update_sedes($as_codemp,$as_codigo,$as_denominacion,$as_tiposede,$as_tipolocalizacion,$as_codpais,
								  $as_codestado,$as_codmunicipio,$as_codciudad,$as_codparroquia,$as_urbanizacion,
								  $as_calle,$as_casa,$as_piso,$aa_seguridad)
                                       
	{
		$lb_valido=true;
        $ls_sql = "UPDATE sudebip_sedes_similares SET ".
        		  "descripcion='".$as_denominacion."',localizacion_sede='".$as_tipolocalizacion."',".
                  "codigo_pais='".$as_codpais."',codigo_estado='".$as_codestado."',codigo_municipio='".$as_codmunicipio."',codigo_ciudad='".$as_codciudad."',".
                  "codigo_parroquia='".$as_codparroquia."',urbanizacion='".$as_urbanizacion."',calle='".$as_calle."',casa='".$as_casa."',piso='".$as_piso."' WHERE codigo_sede = '".$as_codigo."'";
		//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND); 
		$this->io_sql->begin_transaction();
		$li_row=$this->io_sql->execute($ls_sql);
		//file_put_contents('/tmp/sugau_saf.log', print_r($li_row, TRUE), FILE_APPEND);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->rotulacion MÉTODO->uf_saf_update_sedes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			$this->io_sql->commit();
		}
		
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		/** $ls_variable es igual a 1 si es exitoso */
		try{
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizó la Sede ".$as_codigo;
			$ls_variable = $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
					$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
					$aa_seguridad["ventanas"],$ls_descripcion);
			//file_put_contents('/tmp/sugau_saf.log',"LS_VARIABLE: ".$ls_variable."\n", FILE_APPEND);
			if(!$ls_variable)
				throw new Exception("No se puede escribir en la tabla uf_sss_insert_eventos_ventana, no se puede escribir en la bitacora.",1);
		} catch (Exception $e) {
			$msg = 'Error '.$e->getCode().': '.$e->getMessage();
			$msg .= '\nArchivo('.$e->getFile().'), Linea(';
			$msg .= $e->getLine().')';
		}
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		
	  return array ($lb_valido,$msg);
	}// fin uf_saf_update_sedes
	
	/**
	 * uf_saf_delete_sedes
	 * Funcion que elimina una sede en la tabla sudebip_sedes_similares.
	 * @access public
	 * @param $as_codemp 
	 * @param $as_codigo codigo de sede
	 * @param $aa_seguridad arreglo de registro de seguridad
	 * @return boolean
	 */
	function uf_saf_delete_sedes($as_codemp,$as_codigo,$aa_seguridad)
	{
		$lb_valido=false;
		$lb_existe=$this->uf_saf_select_activos($as_codigo);
		$ls_sql = "DELETE FROM sudebip_sedes_similares".
				  " WHERE codemp='".$as_codemp."' AND codigo_sede= '".$as_codigo. "'"; 
		$this->io_sql->begin_transaction();	
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->rotulacion MÉTODO->uf_saf_delete_sedes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			$this->io_sql->commit();
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="DELETE";
			$ls_descripcion ="Eliminó la Sede ".$as_codigo;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////			
			}
		//}
		return $lb_valido;
	} //fin de uf_saf_delete_sedes
	
	/**
	 * uf_saf_select_activos
	 * Esta funcion verifica si hay activos asociados al renglon de la rotulacion
	 * @access public
	 * @param $as_codrot codigo de rotulacion
	 * @todo Función
	 * @return boolean
	 */
	function uf_saf_select_activos($as_codrot)
	{
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_activo  ".
				  " WHERE codemp='".$this->ls_codemp."'".
				  " AND codrot='".$as_codrot."'" ;
				 
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->rotulacion MÉTODO->uf_saf_select_activos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
				
			}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin uf_saf_select_activos
        
	/**
	 * Function: uf_saf_select_tiposede
	 * Access: public
	 * Fecha Creación: 13/11/2014 								
	 * Fecha Última Modificación :
	 */
    function uf_saf_select_tiposede() {
        $lb_valido = false;
        $ls_sql = "SELECT * FROM sudebip_lugares_ubicacion" ;
        $rs_data=$this->io_sql->select($ls_sql);
		//print_r($rs_data);
        //file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_tiposede ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}	
        return $rs_data;
    }//fin uf_saf_select_tiposede
    
    /**
     * uf_saf_select_pais
     * @access public
     * @return boolean 
     */
	
    function uf_saf_select_pais() {        
        $lb_valido = false;
        $ls_sql = "SELECT * FROM sudebip_paises";
        
        $rs_data=$this->io_sql->select($ls_sql);
        //print_r($rs_data);
		//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_pais ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
			
        return $rs_data;
    }//fin uf_saf_select_tiposede
    
    /**
     * uf_saf_select_estados
     */
    function uf_saf_select_estados() {
    	$lb_valido = false;
    	$ls_sql = "SELECT * FROM sudebip_estados";
    	$rs_data=$this->io_sql->select($ls_sql);
    	//print_r($rs_data);
    	if($rs_data===false)
    	{
    		$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_estados ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
    	}

    	return $rs_data;
    }//fin uf_saf_select_estados
    
    /**
     * uf_saf_select_ciudades
     * @param $ls_codmunicipio
     */
    function uf_saf_select_ciudades($ls_codmunicipio) {
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //	     Function: uf_saf_select_estados
        //         Access: public 
        // Fecha Creación: 13/11/2014
        //  Johan Rujano 								Fecha Última Modificación :  
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $lb_valido = false;        
        //$ls_sql = "SELECT * FROM sudebip_ciudades";
        
        if($ls_codmunicipio != "")
        {
        	$ls_sql= "SELECT * FROM sudebip_ciudades WHERE codigo_municipio = '".$ls_codmunicipio."'";
        } else {
        	$ls_sql= "SELECT * FROM sudebip_ciudades";
        }
        $rs_data=$this->io_sql->select($ls_sql);
        //print_r($rs_data);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_ciudades ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		
        return $rs_data;
    }//fin uf_saf_select_ciudades
    
    /**
     * uf_saf_select_municipio
     * @param $ls_codestado
     */
    function uf_saf_select_municipio($ls_codestado) {
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //	     Function: uf_saf_select_municipio
        //         Access: public 
        // Fecha Creación: 13/11/2014
        //  Johan Rujano 								Fecha Última Modificación :  
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $lb_valido = false;
        if($ls_codestado != "" && $ls_codestado != "---")
        {
        	$ls_sql = "SELECT * FROM sudebip_municipios WHERE codigo_estado = '".$ls_codestado."'";
        } else {
        	$ls_sql = "SELECT * FROM sudebip_municipios";
        }
        $rs_data=$this->io_sql->select($ls_sql);
        //print_r($rs_data);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_municipio ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
        return $rs_data;
    }//fin uf_saf_select_municipio
    
    /**
     * uf_saf_select_parroquia
     * @param $ls_codmunicipio
     */
    function uf_saf_select_parroquia($ls_codmunicipio) {
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //	     Function: uf_saf_select_parroquia
        //         Access: public 
        // Fecha Creación: 13/11/2014
        //  Johan Rujano 								Fecha Última Modificación :  
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $lb_valido = false;
        
        /**
         * else es util para cuando se busca un registro  
         */
        if($ls_codmunicipio != ""){
        	$ls_sql = "SELECT * FROM sudebip_parroquias WHERE codigo_municipio='".$ls_codmunicipio."' ";
        } else {
        	$ls_sql = "SELECT * FROM sudebip_parroquias";
        }
                
        $rs_data=$this->io_sql->select($ls_sql);
        //print_r($rs_data);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_parroquia ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
			
        return $rs_data;
    }//fin uf_saf_select_parroquia
    
    /**
     * uf_saf_select_ciudades_localidaes
     * @param $as_codmunicipio
     * @todo función que no se usa, podría borrarse en el futuro 
     */
     function uf_saf_select_ciudades_localidades($as_codmunicipio) {
        $lb_valido = false;
        $ls_sql = "SELECT * FROM saf_ciudades_localidades  where cod_municipio='".$as_codmunicipio."'";
        $rs_data=$this->io_sql->select($ls_sql);
        //print_r($rs_data);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_ciudades_localidades ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		
        return $rs_data;
    }//fin uf_saf_select_parroquia
    
}//fin de la class uf_saf_select_ciudades_localidades
?>
