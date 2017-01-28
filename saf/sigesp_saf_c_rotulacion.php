<?php
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/sigesp_include.php");
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/sigesp_c_seguridad_26042016.php");
require_once("../shared/class_folder/class_funciones.php");
require_once("../shared/class_folder/class_datastore.php");

/**
 * @author Comunidad SIGESP y adaptadores 2017.
 */
class sigesp_saf_c_rotulacion
{
	var $obj="";
	var $io_sql;
	var $siginc;
	var $con;

	/**
	 * Constructor.
	 */
	function sigesp_saf_c_rotulacion()
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
	 * Funcion que busca una rotulacion en la tabla saf_rotulacion
	 *
	 * @param $as_codigo
	 * @return $lb_valido boole
	 *
	 * @author Luis Anibal Lang 2006
	 */
	function uf_saf_select_rotulacion($as_codigo = null,$denrot = null)
	{
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_rotulacion";
		$ls_sql.= " WHERE denrot ilike '%".$denrot."%'";
		!empty($as_codigo) ? $ls_sql.= " AND codrot='".$as_codigo."'" : false;
		$ls_sql.= " ORDER BY codrot";

		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->rotulacion METODO->uf_saf_select_rotulacion ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			$data=$this->io_sql->obtener_asso($rs_data);
		}
		$this->io_sql->free_result($rs_data);
		// return json_encode($data);
		return json_encode($data);
		// return $data;
	}//fin uf_saf_select_rotulacion

	/**
 	* Funcion que inserta un tipo rotulacion en la tabla saf_rotulacion.
 	*
 	* @param $as_codigo       codigo de rotulacion
 	* @param $as_denominacion denominacion de la rotulacion
 	* @param $as_empleo       empleo de la rotulacion
 	* @param $aa_seguridad    arreglo de registro de seguridad
	* @return $lb_valido boole
 	*
 	* @author Luis Anibal Lang 2006
 	*/
	function uf_saf_insert_rotulacion($as_codigo,$as_denominacion,$as_empleo,$aa_seguridad)
	{
		/* @TODO estas variables deben pasarse a la función */
		$aa_seguridad["empresa"] = $_SESSION["la_empresa"]["codemp"];
		$aa_seguridad["logusr"] = $_SESSION["la_logusr"];
		$aa_seguridad["sistema"] = "SAF";
		$aa_seguridad["ventanas"] = "sigesp_saf_d_rotulacion.php";

		$checkSeguridad = new sigesp_c_seguridad();
		/* $aa_permisos es un Arreglo con los permisos del usuario */
		$permisos = $checkSeguridad->uf_sss_load_permisos($_SESSION["la_empresa"]["codemp"],
																											$_SESSION["la_logusr"],
																											"SAF",
																											"sigesp_saf_d_rotulacion.php",
																											$aa_permisos);

		if(true == $aa_permisos["incluir"])
		{
	    $this->io_sql->begin_transaction();
			$ls_sql = "INSERT INTO saf_rotulacion (codrot, denrot, emprot)";
		  $ls_sql.= " VALUES('".$as_codigo."','".$as_denominacion."','".$as_empleo."')";
			$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$lb_valido[0]=false;
				$lb_valido[1]=$this->io_sql->message;
				$this->io_sql->rollback();
			}	else {
					$lb_valido[0]=true;
					/////////////////////////////////         SEGURIDAD               /////////////////////////////
					$ls_evento="INSERT";
					$ls_descripcion ="Inserto el Metodo ".$as_codigo;
					$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
													$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
													$aa_seguridad["ventanas"],$ls_descripcion);
					if($ls_variable[0] == false)
					{
						$lb_valido[0]=false;
						$lb_valido[1]=$ls_variable[1];
					} else {
						$this->io_sql->commit();
					}
					/////////////////////////////////         SEGURIDAD               /////////////////////////////
			}
			return json_encode($lb_valido);
		} else {
			$lb_valido[0] = false;
			$lb_valido[1] = "No tiene permisos para Insertar.";
			return json_encode($lb_valido);
		}
	}//fin uf_saf_insert_rotulacion

	/**
	 * Funcion que modifica un tipo rotulacion en la tabla saf_rotulacion
	 *
	 * @param $as_codigo       codigo de rotulacion
	 * @param $as_denominacion denominacion de la rotulacion
	 * @param $as_empleo       empleo de la rotulacion
	 * @param $aa_seguridad    arreglo de registro de seguridad
	 * @return $lb_valido json
	 *
	 * @author Luis Anibal Lang 2006
	 */
	function uf_saf_update_rotulacion($as_codigo,$as_denominacion,$as_empleo,$aa_seguridad)
	{
		$aa_seguridad["empresa"] = $_SESSION["la_empresa"]["codemp"];
		$aa_seguridad["logusr"] = $_SESSION["la_logusr"];
		$aa_seguridad["sistema"] = "SAF";
		$aa_seguridad["ventanas"] = "sigesp_saf_d_rotulacion.php";

		$checkSeguridad = new sigesp_c_seguridad();
		/* $aa_permisos es un Arreglo con los permisos del usuario */
		$permisos = $checkSeguridad->uf_sss_load_permisos($_SESSION["la_empresa"]["codemp"],
																											$_SESSION["la_logusr"],
																											"SAF",
																											"sigesp_saf_d_rotulacion.php",
																											$aa_permisos);

		if(true == $aa_permisos["cambiar"])
		{
			$ls_sql = "UPDATE saf_rotulacion";
			$ls_sql.= " SET denrot='".$as_denominacion."',emprot='".$as_empleo."'";
			$ls_sql.= " WHERE codrot='".$as_codigo."'";
			$this->io_sql->begin_transaction();
			$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				// $this->io_msg->message("CLASE->rotulacion METODO->uf_saf_update_rotulacion ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido[0] = false;
				$lb_valido[1] = $this->io_sql->message;
				$this->io_sql->rollback();
			} else {
				$lb_valido[0] = true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="UPDATE";
				$ls_descripcion ="Actualizo el Metodo ".$as_codigo;
				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				if($ls_variable[0] ==  false)
				{
					$lb_valido[0] = false;
					$lb_valido[1] = $ls_variable[1];
				} else {
					$this->io_sql->commit();
				}
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
			}
			return json_encode($lb_valido);
		} else {
			$lb_valido[0] = false;
			$lb_valido[1] = "No tiene permiso para Modificar.";
			return json_encode($lb_valido);
		}
	}// fin uf_saf_update_rotulacion

	/**
	 * Funcion que elimina un tipo rotulacion en la tabla saf_rotulacion
	 *
	 * @param $as_codigo    codigo de rotulacion
	 * @param $aa_seguridad arreglo de registro de seguridad
	 * @return $lb_valido json
	 *
	 * @author Luis Anibal Lang 2006
	 */
	function uf_saf_delete_rotulacion($as_codigo,$aa_seguridad)
	{
		$aa_seguridad["empresa"] = $_SESSION["la_empresa"]["codemp"];
		$aa_seguridad["logusr"] = $_SESSION["la_logusr"];
		$aa_seguridad["sistema"] = "SAF";
		$aa_seguridad["ventanas"] = "sigesp_saf_d_rotulacion.php";

		$checkSeguridad = new sigesp_c_seguridad();
		$permisos = $checkSeguridad->uf_sss_load_permisos($_SESSION["la_empresa"]["codemp"],
																											$_SESSION["la_logusr"],
																											"SAF",
																											"sigesp_saf_d_rotulacion.php",
																											$aa_permisos);

		if(true == $aa_permisos["eliminar"])
		{
			// $lb_valido=false;
			$lb_existe=$this->uf_saf_select_activos($as_codigo);

			if($lb_existe)
			{
				// $this->io_msg->message("El registro tiene bienes asociados");
				$lb_valido[0] = false;
				$lb_valido[1] = "El registro tiene bienes asociados.";
			}else{
				$ls_sql = "DELETE FROM saf_rotulacion";
			  $ls_sql.= " WHERE codrot = '".$as_codigo."'";
				$this->io_sql->begin_transaction();
				$li_row=$this->io_sql->execute($ls_sql);
				if($li_row===false)
				{
					// $this->io_msg->message("CLASE->rotulacion METODO->uf_saf_delete_rotulacion ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
					$lb_valido[0]=false;
					$lb_valido[1]=$this->io_sql->message;
					$this->io_sql->rollback();
				}else{
					$lb_valido[0] = true;
					/////////////////////////////////         SEGURIDAD               /////////////////////////////
					$ls_evento="DELETE";
					$ls_descripcion ="Elimino el Metodo ".$as_codigo;
					$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
													$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
													$aa_seguridad["ventanas"],$ls_descripcion);

					if($ls_variable[0] == false)
					{
						$lb_valido[0] = false;
						$lb_valido[1] = $ls_variable[1];
					}else{
						$this->io_sql->commit();
					}
					/////////////////////////////////         SEGURIDAD               /////////////////////////////
				}
			}
			return json_encode($lb_valido);
		}else{
			$lb_valido[0] = false;
			$lb_valido[1] = "No tiene permiso para Eliminar.";
			return json_encode($lb_valido);
		}
	} //fin de uf_saf_delete_rotulacion

	/**
	 * Esta funcion verifica si hay activos asociados al renglon de la rotulacion
	 *
	 * @param $as_codrot string Código de rotulacion
	 * @return $lb_valido bool
	 *
	 * @author Luis Anibal Lang 2006
	 */
	function uf_saf_select_activos($as_codrot)
	{
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_activo";
		$ls_sql.= " WHERE codemp='".$this->ls_codemp."'";
		$ls_sql.= " AND codrot='".$as_codrot."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->rotulacion METODO->uf_saf_select_activos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}else{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
			}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin uf_saf_select_activos

}//fin de la class sigesp_saf_c_metodos
?>
