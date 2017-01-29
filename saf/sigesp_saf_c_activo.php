<?php
require_once("../shared/class_folder/class_sql.php");
require_once("../shared/class_folder/class_datastore.php");
require_once("../shared/class_folder/class_mensajes.php");
require_once("../shared/class_folder/sigesp_include.php");
require_once("../shared/class_folder/sigesp_c_seguridad_26042016.php");
require_once("../shared/class_folder/class_funciones.php");


class sigesp_saf_c_activo
{
	var $obj="";
	var $io_sql;
	var $siginc;
	var $con;

	function sigesp_saf_c_activo()
	{
		$this->io_msg=new class_mensajes();
		$this->dat_emp=$_SESSION["la_empresa"];
		$in=new sigesp_include();
		$this->con=$in->uf_conectar();
		$this->io_sql=new class_sql($this->con);
		$this->seguridad= new sigesp_c_seguridad();
		$this->io_funcion = new class_funciones();

	}//fin de la function sigesp_saf_c_metodos()

	function uf_saf_select_activo($as_codemp,$as_codact)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_activo
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica si existe un determinado activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_activo  ".
				  "WHERE codemp='".$as_codemp."' ".
				  "AND codact='".$as_codact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_select_activo ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_movimientos()

	/**
	 * $as_formadqui Forma de adquisicion
	 */
	function  uf_saf_insert_activo($as_codemp,$ad_fecregact,$as_codact,$as_denact,$as_maract,$as_modact,$ad_feccmpact,$ai_cosact,
								   $as_codconbie,$as_codpai,$as_codest,$as_codmun,$as_radiotipo,$as_obsact,$as_catalogo,$as_numordcom,
								   $as_codpro,$as_denpro,$ai_monord,$as_foto,$as_spgcuenta,$as_codfuefin,$as_codsitcon,$as_codconcom,
								   $ad_fecordcom,$as_numsolpag,$ad_fecemisol,$ls_estdepact,$aa_seguridad,$as_codgru,
								   $as_codsubgru,$as_codsec,$as_codite,$as_clasif,$as_formadqui,$as_usoactualbien,$as_serial,$as_numerochapa)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_insert_activo
		//         Access: public (sigesp_siv_d_activo)
		//     Argumentos: $as_codemp    // codigo de empresa                 $as_codmun    // codigo de municipio
		//				   $as_codact    // codigo de activo          	      $as_radiotipo // tipo de bien
		//			       $as_denact    // denominacion del activo           $as_obsact    // observaciones
		//				   $ad_fecregact // fecha de registro del activo	  $as_catalogo  // codigo del catalogo SIGECOF
		//				   $as_maract    // marca del activo  				  $as_numordcom // numero de la orden de compra
		//				   $as_modact    // modelo del activo			      $as_codpro    // codigo de proveedor
		//				   $ad_feccmpact // fecha de compra del activo	      $as_denpro    // denominacion del proveedor
		//				   $ai_cosact    // costo del activo   				  $ai_monord    // monto de la orden de compra
		//				   $as_codconbie // codigo de condicion del bien      $as_foto      // foto del activo
		//				   $as_codpai    // codigo de pais				  	  $as_spgcuenta // codigo de cuenta presupuestaria
		//				   $as_codest    // codigo de estado			      $as_numsolpag // numero de la solicitud de pago
		//                 $ad_fecemisol // fecha de emision de la solicitud  $aa_seguridad // arreglo de registro de seguridad
		//                 $as_codgru    // codigo del grupo                  $as_codsubgru // codigo del subgrupo
		//                 $as_codsec    //  codsec							  $as_codite    // codigo del item
		//
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que inserta los datos basicos de un activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Modificado Por: Ing. Yozelin Barragan
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 21/05/2007
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$this->io_sql->begin_transaction();
		if($ad_fecemisol=="")
		{
			$ad_fecemisol="1900-01-01";
		}
		if($as_codgru=="")
		{
		   $as_codgru="---";
		}
		if($as_codsubgru=="")
		{
		   $as_codsubgru="---";
		}
		if($as_codsec=="")
		{
		   $as_codsec="---";
		}
		if($as_codite=="")
		{
		   $as_codite="---";
		}
		if (empty($as_codconbie) || strlen($as_codconbie)<>2)
		   {
		     $as_codconbie = '02';
		   }
		$ls_sql = "INSERT INTO saf_activo (codemp,codact,denact,maract,modact,fecregact,feccmpact,codconbie,spg_cuenta_act,esttipinm,".
				  "                        catalogo,costo,estdepact,obsact,fotact,codpai,codest,codmun,cod_pro,nompro,numordcom,monordcom,codfuefin,".
				  "                        numsolpag,fecemisol,codsitcon,codconcom,codgru,codsubgru,codsec,codite,tipinm,cod_aquisicion,estatus_uso,".
				  "						   serial,numero_chapa) ".
				  "VALUES( '".$as_codemp."','".$as_codact."','".$as_denact."','".$as_maract."','".$as_modact."','".$ad_fecregact."',".
				  "        '".$ad_feccmpact."','".$as_codconbie."','".$as_spgcuenta."','".$as_radiotipo."','".$as_catalogo."',".$ai_cosact.",".
				  "        '".$ls_estdepact."','".$as_obsact."','".$as_foto."','".$as_codpai."','".$as_codest."','".$as_codmun."','".$as_codpro."',".
				  "        '".$as_denpro."','".$as_numordcom."',".$ai_monord.",'".$as_codfuefin."','".$as_numsolpag."','".$ad_fecemisol."',".
				  "        '".$as_codsitcon."','".$as_codconcom."','".$as_codgru."','".$as_codsubgru."','".$as_codsec."',".
				  "        '".$as_codite."','".$as_clasif."','".$as_formadqui."','".$as_usoactualbien."','".$as_serial."','".$as_numerochapa."')";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			print ($this->io_sql->message);
			$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_insert_activo ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
				$lb_valido=true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="INSERT";
				$ls_descripcion ="Insertó el Activo ".$as_codact." de la Empresa ".$as_codemp;
				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
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
	}//fin de la uf_saf_insert_activos

	function  uf_saf_update_activo($as_codemp,$ad_fecregact,$as_codact,$as_denact,$as_maract,
								   $as_modact,$ad_feccmpact,$ai_cosact,$as_codconbie,$as_codpai,
								   $as_codest,$as_codmun,$as_radiotipo,$as_obsact,$as_catalogo,
								   $as_numordcom,$as_codpro,$as_denpro,$ai_monord,$as_foto,
								   $as_spgcuenta,$as_codfuefin,$as_codsitcon,$as_codconcom,$ad_fecordcom,
								   $as_numsolpag,$ad_fecemisol,$ls_estdepact,$aa_seguridad,$as_codgru,
								   $as_codsubgru,$as_codsec,$as_codite,$as_clasif,$as_formadqui,
								   $as_usoactualbien,$as_serial,$as_numerochapa)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_activo
		//         Access: public (sigesp_siv_d_activo)
		//     Argumentos: $as_codemp    // codigo de empresa                 $as_codmun    // codigo de municipio
		//				   $as_codact    // codigo de activo          	      $as_radiotipo // tipo de bien
		//			       $as_denact    // denominacion del activo           $as_obsact    // observaciones
		//				   $ad_fecregact // fecha de registro del activo	  $as_catalogo  // codigo del catalogo SIGECOF
		//				   $as_maract    // marca del activo  				  $as_numordcom // numero de la orden de compra
		//				   $as_modact    // modelo del activo			      $as_codpro    // codigo de proveedor
		//				   $ad_feccmpact // fecha de compra del activo	      $as_denpro    // denominacion del proveedor
		//				   $ai_cosact    // costo del activo   				  $ai_monord    // monto de la orden de compra
		//				   $as_codconbie // codigo de condicion del bien      $as_foto      // foto del activo
		//				   $as_codpai    // codigo de pais				  	  $as_spgcuenta // codigo de cuenta presupuestaria
		//				   $as_codest    // codigo de estado			      $as_numsolpag // numero de la solicitud de pago
		//                 $ad_fecemisol // fecha de emision de la solicitud  $aa_seguridad // arreglo de registro de seguridad
		//                 $as_codgru    // codigo del grupo                  $as_codsubgru // codigo del subgrupo
		//                 $as_codsec    //  codsec							  $as_codite    // codigo del item
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los datos basicos de un activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Modificado Por: Ing. Yozelin Barragan
		// Fecha Creaciï¿½n: 01/01/2006 				Fecha ï¿½ltima Modificaciï¿½n : 05/06/2006 -- 21/05/2007
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//file_put_contents('/tmp/sugau_saf.log',"uf_saf_update_activo", FILE_APPEND);
		//$array = func_get_args();
		//file_put_contents('/tmp/sugau_saf.log',print_r($array), FILE_APPEND);
		$lb_valido=true;
		$this->io_sql->begin_transaction();
		if($ad_fecemisol=="")
		{
			$ad_fecemisol="1900-01-01";
		}

		if($as_codgru=="")
		{
		   $as_codgru="---";
		}
		if($as_codsubgru=="")
		{
		   $as_codsubgru="---";
		}
		if($as_codsec=="")
		{
		   $as_codsec="---";
		}
		if($as_codite=="")
		{
		   $as_codite="---";
		}

		$ls_sql="UPDATE saf_activo".
				"   SET denact='".$as_denact."',maract='".$as_maract."',modact='".$as_modact."',fecregact='".$ad_fecregact."',".
				" 		esttipinm='".$as_radiotipo."',feccmpact='".$ad_feccmpact."',codconbie='".$as_codconbie."',".
   				" 		spg_cuenta_act='".$as_spgcuenta."',catalogo='".$as_catalogo."',costo='".$ai_cosact ."',".
				" 		estdepact='".$ls_estdepact."',obsact='".$as_obsact."',fotact='".$as_foto."',codpai='".$as_codpai."',".
				" 		codest='".$as_codest."',codmun='".$as_codmun ."',cod_pro='".$as_codpro."',nompro='".$as_denpro."',".
				" 		numordcom='".$as_numordcom."',monordcom='". $ai_monord."',codfuefin='".$as_codfuefin."',".
				"       numsolpag='".$as_numsolpag."',fecemisol='".$ad_fecemisol."',codsitcon='".$as_codsitcon."',codconcom='".$as_codconcom."',".
				" 		codgru='".$as_codgru."',codsubgru='".$as_codsubgru."',codsec='".$as_codsec."',codite='".$as_codite."', ".
				"       tipinm='".$as_clasif."',cod_aquisicion='".$as_formadqui."',estatus_uso='".$as_usoactualbien."', ".
				"		serial='".$as_serial."',numero_chapa='".$as_numerochapa."'".
				" WHERE codemp =  '".$as_codemp ."'".
				"   AND codact =  '".$as_codact ."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activo METODO->uf_saf_update_activo ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_msg->message("SQL: ".$ls_sql);
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizo el Activo ".$as_codact." de la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],$aa_seguridad["sistema"],
																		  $ls_evento,$aa_seguridad["logusr"],$aa_seguridad["ventanas"],$ls_descripcion);
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
	}// fin de la function uf_sss_update_movimientos

	//JR
	function  uf_saf_update_activosoc($ls_codemp,$ls_numordcom,$ls_itemnumord,$ls_estcondat)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_activosoc
		//         Access: public (sigesp_siv_d_activo)
		//     Argumentos: $as_codemp    // codigo de empresa                 $as_codmun    // codigo de municipio
		//				   $as_codart    // codigo de activo          	      $as_radiotipo // tipo de bien
		//			       $as_codord    // denominacion del activo           $as_obsact    // observaciones
		//    Description: Funcion que actualiza los datos basicos de un activo en la tabla soc_dt_servicio para decir que el
		//				items fue marcado como activo
		//	   Creado Por: Ing. Johan Rujano
		//
		// Fecha Creación: 05/11/2013
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$this->io_sql->begin_transaction();


		if ($ls_estcondat=="S"){
			$ls_sql="UPDATE soc_dt_servicio SET actfijo=1  WHERE codemp =  '".$ls_codemp ."'".
					" AND numordcom ='".$ls_numordcom."' AND codser='".$ls_itemnumord."' ".
			        " AND estcondat='".$ls_estcondat."'";
		}else{
			$ls_sql="UPDATE soc_dt_bienes SET actfijo=1  WHERE codemp =  '".$ls_codemp ."'".
					" AND numordcom ='".$ls_numordcom."' AND codart='".$ls_itemnumord."' ".
			        " AND estcondat='".$ls_estcondat."'";

		}

		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activo METODO->uf_saf_update_activosoc ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizo el Activo ".$as_codact." En la Orden de Compra de la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
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
	}// fin de la function uf_sss_update_movimientos


	function uf_saf_delete_activo($as_codemp,$as_codact,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_delete_activo
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que elimina un determinado activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$this->io_sql->begin_transaction();
		$lb_encontrado=$this->uf_saf_select_dta($as_codemp,$as_codact);
		if ($lb_encontrado)
		   {
			 $this->io_msg->message("El Activo tiene seriales asociados");
		   }
		else
		   {
			 $lb_tiene = $this->uf_saf_select_dtedificios($as_codemp,$as_codact);
			 if ($lb_tiene)
			    {
				  $this->io_msg->message("El Activo tiene Edificios asociados !!!");
				}
			 else
			    {
				  $lb_encontrado=$this->uf_saf_select_movimiento($as_codemp,$as_codact);
				  if ($lb_encontrado)
				     {
					   $this->io_msg->message("El Activo tiene movimientos asociados");
				     }
			 	  else
				     {
					   $ls_sql = "DELETE FROM saf_activo WHERE codemp= '".$as_codemp. "' AND codact = '".$as_codact."'";
					   $li_exec=$this->io_sql->execute($ls_sql);
					   if ($li_exec===false)
						  {
						    $this->io_msg->message("CLASE->activo MÉTODO->uf_saf_delete_activo ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
							$this->io_sql->rollback();
						  }
					   else
						  {
						    $lb_valido=true;
							/////////////////////////////////         SEGURIDAD               /////////////////////////////
							$ls_evento="DELETE";
							$ls_descripcion ="Eliminó el Activo ".$as_codact." de la Empresa ".$as_codemp;
							$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
															$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
															$aa_seguridad["ventanas"],$ls_descripcion);
							/////////////////////////////////         SEGURIDAD               /////////////////////////////
							$this->io_sql->commit();
						  }
				     }
				}
		   }
		return $lb_valido;
	} //fin de uf_saf_delete_movimientos

	function uf_saf_select_dta($as_codemp,$as_codact)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_dta
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica si un activo tiene seriales asociados
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT codemp FROM saf_dta  ".
				  "WHERE codemp='".$as_codemp."' ".
				  "AND codact='".$as_codact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_dta ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_dta

	function uf_saf_select_dtedificios($as_codemp,$as_codact)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_dtedificios
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica si un activo tiene seriales asociados
		//	   Creado Por: Ing. Nï¿½stor Falcï¿½n.
		// Fecha Creaciï¿½n: 06/01/2009 								Fecha ï¿½ltima Modificaciï¿½n : 06/01/2009
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql  = "SELECT codemp FROM saf_edificios WHERE codemp='".$as_codemp."' AND codact='".$as_codact."'";
		$rs_data = $this->io_sql->select($ls_sql);
		if ($rs_data===false)
		   {
		     $this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_dtedificios;ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		     echo $this->io_sql->message;
		   }
		else
		   {
		     if ($row=$this->io_sql->fetch_row($rs_data))
			    {
				  $lb_valido = true;
				}
		   }
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_dtedificios.

	function uf_saf_select_movimiento($as_codemp,$as_codact)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_movimiento
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica si un activo tiene seriales asociados
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_dt_movimiento  ".
				  "WHERE codemp='".$as_codemp."' ".
				  "AND codact='".$as_codact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_movimiento ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_movimiento

	function  uf_saf_update_depreciacion($as_codemp,$as_codact,$as_metodo,$ai_vidautil,$as_valres,$as_ctadep,$as_ctacon,
										 $as_codestpro1,$as_codestpro2,$as_codestpro3,$as_codestpro4,$as_codestpro5,$as_estcla,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_depreciacion
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp    //codigo de empresa
		//				   $as_codact    //codigo de activo
		//				   $as_metodo    // codigo del metodo de depreciacion
		//				   $ai_vidautil  // vida util del activo
		//				   $as_valres    // valor de rescate del activo
		//				   $as_ctadep    // codigo cuenta de la depreciacion
		//				   $as_ctacon    // codigo cuenta asociada al activo
		//				   $as_codestpro1 // codigo de estructura programatica nivel 1
		//				   $as_codestpro2 // codigo de estructura programatica nivel 2
		//				   $as_codestpro3 // codigo de estructura programatica nivel 3
		//				   $as_codestpro4 // codigo de estructura programatica nivel 4
		//				   $as_codestpro5 // codigo de estructura programatica nivel 5
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los datos de la depreciacion de un activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		 $lb_valido=true;
		 $as_codestpro1=str_pad($as_codestpro1,25,"0",0);
		 $as_codestpro2=str_pad($as_codestpro2,25,"0",0);
		 $as_codestpro3=str_pad($as_codestpro3,25,"0",0);
		 $as_codestpro4=str_pad($as_codestpro4,25,"0",0);
		 $as_codestpro5=str_pad($as_codestpro5,25,"0",0);
		 $this->uf_load_config("SAF","DEPRECIACION","AFECTACION_DEPRECIACION",$ls_tipafedep);//Tipo de Afectacion de la Depreciaciï¿½n.
		 if ($ls_tipafedep=='C')
		    {
			  $as_estcla = '-';
			  $as_codestpro1 = $as_codestpro2 = $as_codestpro3 = $as_codestpro4 = $as_codestpro5 = str_pad('',25,'-',0);
			}
		 $ls_sql =  "UPDATE saf_activo
		 			    SET codmetdep = '".$as_metodo ."',
					        vidautil = '".$ai_vidautil ."',
							cossal   = '".$as_valres ."',
							spg_cuenta_dep = '".$as_ctadep ."',
							sc_cuenta = '".$as_ctacon."',
							codestpro1 = '".$as_codestpro1 ."',
					        codestpro2 = '".$as_codestpro2 ."',
					        codestpro3 = '".$as_codestpro3 ."',
							codestpro4 = '".$as_codestpro4 ."',
					        codestpro5 = '".$as_codestpro5 ."',
					        estcla = '".$as_estcla."'
					  WHERE codemp =  '".$as_codemp."'
					    AND codact =  '".$as_codact."'";
		$this->io_sql->begin_transaction();
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_update_depreciacion ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualización la depreciación del Activo ".$as_codact." de la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
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
	}// fin de la function uf_saf_update_depreciacion

	function uf_saf_load_seriales($as_codemp,$as_codact,&$ao_object,&$ai_totrows)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_load_seriales
		//         Access: public
		//      Argumento: $as_codemp  //codigo de empresa
		//				   $as_codact  //codigo de activo
		//				   $ao_object  // arreglo de objetos de la grid
		//				   $ai_totrows // total de filas
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que carga los seriales asociados a un activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 07/06/2006 								Fecha ï¿½ltima Modificaciï¿½n : 07/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_gestor = $_SESSION["ls_gestor"];
		$ls_sql_int = "";
		if (strtoupper($ls_gestor) == "MYSQLT")
		{
		 $ls_sql_int = " CONCAT(c.nomper,' ',c.apeper) as nomres_per, CONCAT(d.nombene,' ',d.apebene) as nomres_ben,
                         CONCAT(e.nomper,' ',e.apeper) as nomrespri_per, CONCAT(f.nombene,' ',f.apebene) as nomrespri_ben";
		}
		else
		{
		 $ls_sql_int = " c.nomper||' '||c.apeper as nomres_per, d.nombene||' '||d.apebene as nomres_ben,
                         e.nomper||' '||e.apeper as nomrespri_per, f.nombene||' '||f.apebene as nomrespri_ben ";
		}

		$ls_sql = "SELECT a.*, b.denuniadm, ".$ls_sql_int." ".
		          "   FROM saf_dta a ".
                  " LEFT OUTER JOIN spg_unidadadministrativa b ON b.coduniadm = a.coduniadm ".
                  " LEFT OUTER JOIN sno_personal c on c.codper = a.codres ".
                  " LEFT OUTER JOIN rpc_beneficiario d on d.ced_bene = a.codres  ".
                  " LEFT OUTER JOIN sno_personal e on e.codper = a.codrespri ".
                  " LEFT OUTER JOIN rpc_beneficiario f on f.ced_bene = a.codrespri".
				  " WHERE a.codemp='".$as_codemp."'".
				  " AND a.codact='".$as_codact."'";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_load_seriales ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			while($row=$this->io_sql->fetch_row($rs_data))
			{
				$ls_nomresuso = "";
				$ls_nomrespri = "";
				$ls_codact=$row["codact"];
				$ls_seract=$row["seract"];
				$ls_chaact=$row["idchapa"];
				$ls_unidad=$row["coduniadm"];
				$ls_denunidad=$row["denuniadm"];
				$ls_nomrespri_per=$row["nomrespri_per"];
				$ls_nomrespri_ben=$row["nomrespri_ben"];
				$ls_nomresuso_per=$row["nomres_per"];
				$ls_nomresuso_ben=$row["nomres_ben"];
				$ls_responsable=$row["codrespri"];
				$ls_responsableuso=$row["codres"];
				$ls_observacion=$row["obsideact"];
				$ls_idactivo=$row["ideact"];

				if ($ls_nomrespri_per == "" && $ls_nomrespri_ben == "" )
				{
				 $ls_nomrespri = "POR DEFINIR";
				}
				elseif($ls_nomrespri_per != "")
				{
				 $ls_nomrespri = $ls_nomrespri_per;
				}
				else
				{
				 $ls_nomrespri = $ls_nomrespri_ben;
				}

				if ($ls_nomresuso_per == "" && $ls_nomresuso_ben == "" )
				{
				 $ls_nomresuso = "POR DEFINIR";
				}
				elseif($ls_nomresuso_per != "")
				{
				 $ls_nomresuso = $ls_nomresuso_per;
				}
				else
				{
				 $ls_nomresuso = $ls_nomresuso_ben;
				}

				$ao_object[$ai_totrows][1]="<input name=txtcodactd".$ai_totrows." type=text id=txtcodactd".$ai_totrows." class=sin-borde size=18 maxlength=15 value='".$ls_codact."' onKeyUp='javascript: ue_validarnumero(this);'>";
				$ao_object[$ai_totrows][2]="<input name=txtseractd".$ai_totrows." type=text id=txtseractd".$ai_totrows." class=sin-borde size=22 maxlength=20 value='".$ls_seract."' onKeyPress='return keyrestrictgrid(event)' onBlur='ue_rellenarcampo(this,15)'>";
				$ao_object[$ai_totrows][3]="<input name=txtchaactd".$ai_totrows." type=text id=txtchaactd".$ai_totrows." class=sin-borde size=18 maxlength=15 value='".$ls_chaact."' onKeyUp='javascript: ue_validarnumero(this);' onBlur='ue_rellenarcampo(this,15)'>";
				$ao_object[$ai_totrows][4]="<input name=txtdenunidadd".$ai_totrows." type=text id=txtdenunidadd".$ai_totrows." class=sin-borde size=50 maxlength=50 value='".$ls_denunidad."' onKeyUp='javascript: ue_validarcomillas(this);' readonly>".
				                           "<input name=txtunidadd".$ai_totrows." type=hidden id=txtunidadd".$ai_totrows." class=sin-borde size=18 maxlength=100 value='".$ls_unidad."' onKeyUp='javascript: ue_validarnumero(this);' onBlur='ue_rellenarcampo(this,10)'>";
				$ao_object[$ai_totrows][5]="<input name=txtnomrespri".$ai_totrows." type=text id=txtnomrespri".$ai_totrows." class=sin-borde size=50 maxlength=50 value='".$ls_nomrespri."' onKeyUp='javascript: ue_validarcomillas(this);'  readonly>".
				                           "<input name=txtresponsabled".$ai_totrows." type=hidden id=txtresponsabled".$ai_totrows." class=sin-borde size=12 maxlength=10 value='".$ls_responsable."' onKeyUp='javascript: ue_validarnumero(this);' onBlur='ue_rellenarcampo(this,10)'>";
				$ao_object[$ai_totrows][6]="<input name=txtnomres".$ai_totrows." type=text id=txtnomres".$ai_totrows." class=sin-borde size=50 maxlength=50 value='".$ls_nomresuso."' onKeyUp='javascript: ue_validarcomillas(this);'  readonly>".
				                           "<input name=txtcodres".$ai_totrows." type=hidden id=txtcodres".$ai_totrows." class=sin-borde size=12 maxlength=10 value='".$ls_responsableuso."' readonly>";
				$ao_object[$ai_totrows][7]="<input name=txtobserd".$ai_totrows." type=text id=txtobserd".$ai_totrows." class=sin-borde size=18 maxlength=100 value='".$ls_observacion."' onKeyUp='javascript: ue_validarcomillas(this);' >";
				$ao_object[$ai_totrows][8]="<input name=txtidactivod".$ai_totrows." type=text id=txtidactivod".$ai_totrows." class=sin-borde size=18 maxlength=15 value='".$ls_idactivo."' onKeyUp='javascript: ue_validarnumero(this);'>";
				$ao_object[$ai_totrows][9]="<a href=javascript:uf_agregarpartes(".$ai_totrows.");><img src=../shared/imagebank/tools/nuevo.gif alt='Agregar partes' width=15 height=15 border=0></a>";
				$ao_object[$ai_totrows][10]="<a href=javascript:uf_delete_dt(".$ai_totrows.");><img src=../shared/imagebank/tools15/eliminar.gif alt=Aceptar width=15 height=15 border=0></a>";

				$ai_totrows=$ai_totrows + 1;
			}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}// fin uf_saf_load_seriales
	function uf_saf_select_seriales($as_codemp,$as_codact,$as_idact)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_seriales
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//				   $as_idact    // id de activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica la existencia de un activo en la tabla saf_dta
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_dta  ".
				  "WHERE codemp='".$as_codemp."'".
				  " AND codact='".$as_codact."'".
				  " AND ideact='".$as_idact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_seriales ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_seriales

	function uf_saf_select_unidad($as_codemp,$as_coduniadm)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_unidad
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_coduniadm // codigo de unidad administrativa
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica la existencia de una unidad administrativa en la tabla spg_unidadadministrativa
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql="SELECT coduniadm".
				"  FROM saf_unidadadministrativa".
				" WHERE codemp='".$as_codemp."'".
				"   AND coduniadm='".$as_coduniadm."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo METODO->uf_saf_select_unidad ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_unidad()

	function uf_saf_select_responsable($as_codemp,$as_codres)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_responsable
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codres // codigo de personal (responsable)
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica la existencia de un personal en la tabla sno_personal
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT * FROM sno_personal  ".
				  " WHERE codemp='".$as_codemp."'".
				  " AND codper='".$as_codres."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_responsable ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_responsable

	function  uf_saf_insert_seriales($as_codemp,$as_codact,$as_idact,$as_seract,$as_idchapa,$as_coduniadm,$as_codrespri,$as_obsideact,
									$as_estact,$as_logusr,$as_codres,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_insert_seriales
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp    //codigo de empresa
		//				   $as_codact    // codigo de activo
		//				   $as_idact     // id de activo
		//				   $as_idchapa   // numero de chapa en el activo
		//				   $as_coduniadm // codigo de unidad adminisrativa
		//				   $as_codrespri // codigo de personal (responsable primario)
		//				   $as_obsideact // observaciones en el registro de seriales
		//				   $as_estact    // estado de activo
		//				   $as_logusr    // usuario que esta registrando el serial
		//				   $as_codres    // codigo de personal (responsable por uso)
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que inserta los seriales y otros datos importantes de los activos relacionados a un activo en particular
		//					en la tabla saf_dta
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 12/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$ls_sql = "INSERT INTO saf_dta (codemp,codact,ideact,seract,idchapa,coduniadm,codrespri,obsideact,estact,".
			          "                     codusureg,codres)".
					  " VALUES( '".$as_codemp."','".$as_codact."','".$as_idact."','".$as_seract."','".$as_idchapa."',".
					  "         '".$as_coduniadm."','".$as_codrespri."','".$as_obsideact."','".$as_estact."','".$as_logusr."',".
					  "         '".$as_codres."') ";
		$this->io_sql->begin_transaction();
		$li_row=$this->io_sql->execute($ls_sql);
	    if($li_row===false)
	    {
		 $this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_insert_seriales ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		 $lb_valido=false;
		 $this->io_sql->rollback();
		}
		else
		{
		 $lb_valido=true;
		 /////////////////////////////////         SEGURIDAD               /////////////////////////////
		 $ls_evento="INSERT";
		 $ls_descripcion ="Insertï¿½ Serial".$as_seract."con Id".$as_idact." asociado al Activo ".$as_codact." de la Empresa ".$as_codemp;
		 $ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
										 $aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
										 $aa_seguridad["ventanas"],$ls_descripcion);
		 /////////////////////////////////         SEGURIDAD               /////////////////////////////
		 $this->io_sql->commit();
	   }
		return $lb_valido;
	}//fin de la uf_saf_insert_seriales

	function  uf_saf_update_seriales($as_codemp,$as_codact,$as_idact,$as_seract,$as_idchapa,$as_coduniadm,$as_codrespri,$as_obsideact,
									$as_estact,$as_codres,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_seriales
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp    //codigo de empresa
		//				   $as_codact    // codigo de activo
		//				   $as_idact     // id de activo
		//				   $as_idchapa   // numero de chapa en el activo
		//				   $as_coduniadm // codigo de unidad adminisrativa
		//				   $as_codrespri // codigo de personal (responsable primario)
		//				   $as_obsideact // observaciones en el registro de seriales
		//				   $as_estact    // estado de activo
		//				   $as_codres    // codigo de personal (responsable por uso)
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los seriales y otros datos importantes de los activos relacionados a un activo en
		//				   particular en la tabla saf_dta
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
			 $ls_sql =  "UPDATE saf_dta ".
			 			"   SET seract='". $as_seract ."',".
			 			"       idchapa='". $as_idchapa ."',".
						"       coduniadm='". $as_coduniadm ."', ".
						"       codrespri='". $as_codrespri ."',".
						"       obsideact='". $as_obsideact ."',".
						"       codres='". $as_codres ."'".
						" WHERE codemp =  '". $as_codemp ."'".
						"   AND codact =  '". $as_codact ."'".
						"   AND ideact =  '". $as_idact ."'";
			$this->io_sql->begin_transaction();
			$li_row = $this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_update_seriales ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
				$this->io_sql->rollback();
			}
			else
			{
				$lb_valido=true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="UPDATE";
				$ls_descripcion ="Actualizï¿½ Serial".$as_seract."con Id".$as_idact." asociado al Activo ".$as_codact." de la Empresa ".$as_codemp;
				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$this->io_sql->commit();
			}

	  return $lb_valido;
	}// fin de la function uf_saf_update_seriales

	function uf_saf_delete_seriales($as_codemp,$as_seract,$as_codact,$as_idact,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_delete_seriales
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact // codigo de activo
		//				   $as_idact  // id de activo
		//				   $aa_seguridad   // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que elimina un serial y otros datos de los activos relacionados a un activo en
		//				   particular en la tabla saf_dta
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$lb_encontrado=$this->uf_saf_select_dt_movimiento($as_codemp,$as_codact,$as_idact);
		if(!$lb_encontrado)
		{
			$lb_encontrado=$this->uf_saf_select_partes($as_codemp,$as_codact,$as_idact,'%%');
		}
		if(!$lb_encontrado)
		{
			$ls_sql = " DELETE FROM saf_dta".
					  " WHERE codemp= '".$as_codemp. "'".
					  " AND codact= '".$as_codact. "'".
					  " AND ideact= '".$as_idact. "'";
			$this->io_sql->begin_transaction();
			$li_row=$this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_delete_seriales ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
				$this->io_sql->rollback();
			}
			else
			{
				$lb_valido=true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="DELETE";
				$ls_descripcion ="Eliminï¿½ Serial".$as_seract."con Id".$as_idact." asociado al Activo ".$as_codact." de la Empresa ".$as_codemp;
				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$this->io_sql->commit();
			}
		}
		else
		{
			$this->io_msg->message("El Activo tiene movimientos y/o partes asociados");
		}
		return $lb_valido;
	} //fin de uf_saf_delete_seriales

	function uf_saf_select_dt_movimiento($as_codemp,$as_codact,$as_idact)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_movimiento
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact // codigo de activo
		//				   $as_idact  // identificador del activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica si un activo ha tenido movimientos
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;

// ----------------   MODIFICACIÃ“N   -------------------------------------------------

		if($as_idact!="")
		{
			$ls_sqlint="   AND ideact='".$as_idact.";";
		}
		else
		{
			$ls_sqlint=";";
		}
		$ls_sql = "SELECT codact,ideact FROM saf_dt_movimiento  ".
				  " WHERE codemp='".$as_codemp."'".
				  "   AND codact='".$as_codact."'" .$ls_sqlint="";
		$rs_data=$this->io_sql->select($ls_sql);
		$li_numrows=$this->io_sql->num_rows($rs_data); //para saber	el numero de filas del select en la tabla saf_dt_movimiento

		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_movimiento ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}

		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
		return $li_numrows;


/*	-----------	ORIGINAL ----------------------------
				$ls_sql = "SELECT codact,ideact FROM saf_dt_movimiento  ".
				  " WHERE codemp='".$as_codemp."'".
				  "   AND codact='".$as_codact."'" .
				  "   AND ideact='".$as_idact."'" ;
				$rs_data=$this->io_sql->select($ls_sql);
				if($rs_data===false)
				{
					$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_movimiento ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				}
				else
				{
					if($row=$this->io_sql->fetch_row($rs_data))
					{$lb_valido=true;}
				}
				$this->io_sql->free_result($rs_data);
			 $rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_movimiento ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			}
			else
			{
				if($row=$this->io_sql->fetch_row($rs_data))
				{$lb_valido=true;}
			}
			$this->io_sql->free_result($rs_data);
			return $lb_valido;*/
	}//fin de la function uf_saf_select_movimiento

	function uf_saf_select_partes($as_codemp,$as_codact,$as_idact,$as_codpar)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_partes
		//         Access: public
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact // codigo de activo
		//				   $as_idact  // id de activo
		//				   $as_codpar // codigo de parte asociada al activo
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica la existencia de una parte asociada a un activo en la tabla saf_partes
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_partes  ".
				  "WHERE codemp='".$as_codemp."'".
				  " AND codact='".$as_codact."'".
				  " AND ideact='".$as_idact."'".
				  " AND codpar like '".$as_codpar."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_partes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;

	}//fin de la function uf_saf_select_partes()

	function  uf_saf_insert_partes($as_codemp,$as_codact,$as_idact,$as_codpar,$as_denpar,$as_estpar,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_insert_partes
		//         Access: public
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact // codigo de activo
		//				   $as_idact  // id de activo
		//				   $as_codpar // codigo de parte
		//				   $as_denpar // denominacion de la parte
		//				   $as_estpar // estado en que se encuentra la parte
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que inserta una parte asociada a un activo en la tabla saf_partes
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
        $this->io_sql->begin_transaction();
		$ls_sql = "INSERT INTO saf_partes (codemp, codact, ideact, codpar, denpar, estpar, cmpmov)".
				  " VALUES( '".$as_codemp."','".$as_codact."','".$as_idact."','".$as_codpar."', '".$as_denpar."','".$as_estpar."','000000000000000')";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_insert_partes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="INSERT";
			$ls_descripcion ="Insertï¿½ el codigo de parte ".$as_codpar." con Id ".$as_idact." asociado al Activo ".$as_codact." de la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$this->io_sql->commit();
		}
		return $lb_valido;
	}//fin de uf_saf_insert_partes

	function  uf_saf_update_partes($as_codemp,$as_codact,$as_idact,$as_codpar,$as_denpar,$as_estpar,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_partes
		//         Access: public
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact // codigo de activo
		//				   $as_idact  // id de activo
		//				   $as_codpar // codigo de parte
		//				   $as_denpar // denominacion de la parte
		//				   $as_estpar // estado en que se encuentra la parte
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza una parte asociada a un activo en la tabla saf_partes
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	 $lb_valido=true;
	 $ls_sql = "UPDATE saf_partes SET   denpar='". $as_denpar ."', estpar='". $as_estpar ."'".
			   " WHERE codemp =  '". $as_codemp ."'".
			   " AND codact =  '". $as_codact ."'".
			   " AND ideact =  '". $as_idact ."'".
			   " AND codpar =  '". $as_codpar ."'";
        $this->io_sql->begin_transaction();
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_update_partes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizï¿½ el codigo de parte ".$as_codpar." con Id ".$as_idact." asociado al Activo ".$as_codact." de la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$this->io_sql->commit();
		}
	  return $lb_valido;
	}// fin de la function uf_sss_update_partes

	function uf_saf_delete_partes($as_codemp,$as_codact,$as_idact,$as_codpar,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_partes
		//         Access: public
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact // codigo de activo
		//				   $as_idact  // id de activo
		//				   $as_codpar // codigo de parte
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que elimina una parte asociada a un activo en la tabla saf_partes
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 01/01/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$ls_sql =  " DELETE FROM saf_partes".
				   " WHERE codemp =  '". $as_codemp ."'".
				   " AND codact =  '". $as_codact ."'".
				   " AND ideact =  '". $as_idact ."'".
				   " AND codpar =  '". $as_codpar ."'";
		$this->io_sql->begin_transaction();
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_delete_partes ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
			$this->io_sql->rollback();

		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="DELETE";
			$ls_descripcion ="Eliminï¿½ el codigo de parte ".$as_codpar." con Id ".$as_idact." asociado al Activo ".$as_codact." de la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$this->io_sql->commit();
		}
		return $lb_valido;
	} //fin de uf_saf_delete_partes

	function uf_saf_select_cuentaspg($as_codemp,&$as_cuenta)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_articulo
		//         Access: public (sigesp_siv_d_articulo)
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_cuenta //numero de cuenta presupuestaria
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que verifica si existe una determinada cuenta presupuestaria
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaciï¿½n: 28/03/2006 								Fecha ï¿½ltima Modificaciï¿½n : 28/03/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//file_put_contents('/tmp/sugau_saf.log', print_r(func_get_args(), TRUE), FILE_APPEND);
		$lb_valido=false;
		$ls_spgcuenta=substr($as_cuenta,0,3);
		if($ls_spgcuenta=='404')
		{$lb_valido=true;}
		else
		{return false;}
		$ls_sql="SELECT spg_cuenta".
				"  FROM spg_cuentas  ".
				" WHERE codemp='".$as_codemp."'".
				"   AND spg_cuenta LIKE '".trim($as_cuenta)."%'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_select_cuentaspg ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
				$this->io_sql->free_result($rs_data);
				$as_cuenta=$row["spg_cuenta"];
			}
			else
			{
				$lb_valido=false;
			}
		}
		return $lb_valido;
	}// end function uf_siv_select_articulo

	/**
	*
	* Function: uf_upload
	* Access: public (sigesp_snorh_d_personal)
	* as_nomfot  // Nombre Foto
	* as_tipfot  // Tipo Foto
	* as_tamfot  // Tamaï¿½o Foto
	* as_nomtemfot  // Nombre Temporal
	* Returns: Retorna un booleano
	* Description: Funcion que sube una foto al servidor
	* Creado Por: Ing. Yesenia Moreno
	* 01/01/2006
	*/
	function uf_upload($as_nomfot,$as_tipfot,$as_tamfot,$as_nomtemfot)
	{
		$lb_valido=true;
		if ($as_nomfot!="" && $as_tipfot!="")
		{
			if (!((strpos($as_tipfot, "gif") || strpos($as_tipfot, "jpeg") || strpos($as_tipfot, "png")) && ($as_tamfot < 100000)))
			{
				$lb_valido=false;
				$as_nomfot="";
				$this->io_msg->message("El archivo de la foto no es valido.");
			}
			else
			{
				if (!((move_uploaded_file($as_nomtemfot, "fotosactivos/".$as_nomfot))))
				{
					$lb_valido=false;
					$as_nomfot="";
		        	$this->io_msg->message("CLASE->articulo METODO->uf_upload ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
				}
			}
		}
		return $lb_valido;
    }
  //----------------------------------------------------------------------------------------------------------------------------------

  //-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_config($as_codemp)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_config
		//		   Access: public
		//	    Arguments:
		//	      Returns: $ls_resultado variable buscado
		//	  Description: Funciï¿½n que obtiene una variable de la tabla config
		// Modificado por: Ing. Yozelin Barragan
		// Fecha Creaciï¿½n: 01/01/2006 	 Fecha ï¿½ltima Modificaciï¿½n : 21/05/2007
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    $lb_valido=false;
		$ls_sql="SELECT * ".
	   		    "  FROM sigesp_config ".
			    " WHERE codemp='".$as_codemp."' ".
			    "   AND codsis='SAF' ".
			    "   AND seccion='CATEGORIA' ".
			    "   AND entry='TIPO-CATEGORIA-CSG-CGR' ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_mensajes->message("CLASE->articulo ->uf_select_config ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
			}
		}
		return rtrim($lb_valido);
	}// end function uf_select_config
   //----------------------------------------------------------------------------------------------------------------------------------

   //-----------------------------------------------------------------------------------------------------------------------------------
	function uf_insert_config($as_codemp,$as_sistema, $as_seccion, $as_variable, $as_valor, $as_tipo)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_insert_config
		//		   Access: public
		//	    Arguments: as_sistema  // Sistema al que pertenece la variable
		//				   as_seccion  // Secciï¿½n a la que pertenece la variable
		//				   as_variable  // Variable nombre de la variable a buscar
		//				   as_valor  // valor por defecto que debe tener la variable
		//				   as_tipo  // tipo de la variable
		//	      Returns: $lb_valido True si se ejecuto el insert ï¿½ False si hubo error en el insert
		//	  Description: Funciï¿½n que inserta la variable de configuraciï¿½n
		//	   Creado Por: Ing. Yesenia Moreno
		// Fecha Creaciï¿½n: 01/01/2006 				Fecha ï¿½ltima Modificaciï¿½n :
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=true;
		$this->io_sql->begin_transaction();
		$ls_sql="INSERT INTO sigesp_config(codemp, codsis, seccion, entry, value, type)VALUES ".
				"('".$as_codemp."','".$as_sistema."','".$as_seccion."','".$as_variable."','".$as_valor."','".$as_tipo."')";
		$li_row=$this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$lb_valido=false;
			$this->io_mensajes->message("CLASE->articulo ->uf_insert_config ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
		}
		else
		{
			$this->io_sql->commit();
		}
		return $lb_valido;
	}// end function uf_insert_config
	//-----------------------------------------------------------------------------------------------------------------------------------

   //-----------------------------------------------------------------------------------------------------------------------------------
	function uf_saf_guardar_configuracion($as_codemp,$as_sistema,$as_seccion,$as_variable,$as_valor,$as_tipo)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_guardar_configuracion
		//		   Access: public
		//	    Arguments: as_sistema  // Sistema al que pertenece la variable
		//				   as_seccion  // Secciï¿½n a la que pertenece la variable
		//				   as_variable  // Variable nombre de la variable a buscar
		//				   as_valor  // valor por defecto que debe tener la variable
		//				   as_tipo  // tipo de la variable
		//	      Returns: $lb_valido True si se ejecuto el insert ï¿½ False si hubo error en el insert
		//	  Description: Funciï¿½n que inserta la variable de configuraciï¿½n
		//	   Creado Por: Ing. Yozelin Barragan
		// Fecha Creaciï¿½n: 21/05/2007				Fecha ï¿½ltima Modificaciï¿½n :
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    $lb_valido = true;
		$lb_existe = $this->uf_select_config($as_codemp);
		if (!$lb_existe)
		   {
		     $lb_valido = $this->uf_insert_config($as_codemp,$as_sistema, $as_seccion, $as_variable, $as_valor, $as_tipo);
		   }
		/*else
		{
		   $this->io_msg->message("La configuracion ya existe.");
		   $lb_valido=false;
		}*/
	    return  $lb_valido;
	}// end function uf_saf_guardar_configuracion
	//-----------------------------------------------------------------------------------------------------------------------------------

   //-----------------------------------------------------------------------------------------------------------------------------------
	function uf_select_valor_config($as_codemp)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_select_valor_config
		//		   Access: public
		//	    Arguments:
		//	      Returns: $ls_resultado variable buscado
		//	  Description: Funciï¿½n que obtiene una variable de la tabla config
		// Modificado por: Ing. Yozelin Barragan
		// Fecha Creaciï¿½n: 21/05/2007 	 Fecha ï¿½ltima Modificaciï¿½n :
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	    $lb_valido=false;
		$ls_sql="SELECT * ".
	   		    "  FROM sigesp_config ".
			    " WHERE codemp='".$as_codemp."' ".
			    "   AND codsis='SAF' ".
			    "   AND seccion='CATEGORIA' ".
			    "   AND entry='TIPO-CATEGORIA-CSG-CGR' ";
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->articulo ->uf_select_config ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
			$lb_valido=false;
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$li_valor=trim($row["value"]);
				$lb_valido=true;
			}
			else
			{
				$li_valor="0";
			}
		}
		return $li_valor;
	}// end function uf_select_config



	/**
	 *
	 */
	function uf_saf_select_forma_adquisicion()
	{
		$lb_valido=false;
		$ls_sql = "SELECT cod_for_adq,des_for_adq FROM saf_sudebip_forma_adquisicion;";
		$result_set=$this->io_sql->select($ls_sql);
		$rs_data=$this->io_sql->obtener_datos($result_set);
		if($result_set===false)
		{
			$this->io_msg->message("CLASE->activo METODO->uf_saf_select_activo ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
// 			if($row=$this->io_sql->fetch_row($rs_data))
// 			{
// 				$lb_valido=true;
// 			}
			$lb_valido=true;
		}
		//$this->io_sql->free_result($rs_data);
		return array($lb_valido,$rs_data);
	}


   //----------------------------------------------------------------------------------------------------------------------------------
function  uf_saf_update_res_uniadm_seriales($as_codemp,$as_codact,$as_idact,$as_coduniadm,$as_codrespri,
					                             $as_codres,$aa_seguridad,$as_codubifisresuso)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_res_uniadm_seriales
		//         Access: public (sigesp_siv_d_activos)
		//      Argumento: $as_codemp    //codigo de empresa
		//				   $as_codact    // codigo de activo
		//				   $as_idact     // id de activo
		//				   $as_coduniadm // codigo de unidad adminisrativa
		//				   $as_codrespri // codigo de personal (responsable primario)
		//				   $as_codres    // codigo de personal (responsable por uso)
		//				   $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los seriales y otros datos importantes de los activos relacionados a un activo en
		//				   particular en la tabla saf_dta
		//	   Creado Por: Ing. Arnaldo Suï¿½rez
		// Fecha Creaciï¿½n: 20/02/2006 								Fecha ï¿½ltima Modificaciï¿½n : 01/01/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//MODIFICADO PARA ACTUALIZAR LA UBICACIÃ“N FISICA DE LOS ACTIVOS
		$lb_valido=false;
		$ls_sql =  "UPDATE saf_dta SET ".
				   "       coduniadm='". $as_coduniadm ."', ".
				   "       codrespri='". $as_codrespri ."',".
				   "       codres='". $as_codres ."',".
				   "       codubifis='". $as_codubifisresuso ."'".
				   " WHERE codemp =  '". $as_codemp ."'".
				   "   AND codact =  '". $as_codact ."'".
				   "   AND ideact =  '". $as_idact ."'";
			$this->io_sql->begin_transaction();
			$li_row = $this->io_sql->execute($ls_sql);
			if($li_row===false)
			{
				$this->io_msg->message("CLASE->activo Mï¿½TODO->uf_saf_update_res_uniadm_seriales ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
				$this->io_sql->rollback();
			}
			else
			{
				$lb_valido=true;
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$ls_evento="UPDATE";
				$ls_descripcion ="Actualizï¿½ detalle de Activo ".$as_codact."con Id".$as_idact." de la Empresa ".$as_codemp;
				$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
												$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
												$aa_seguridad["ventanas"],$ls_descripcion);
				/////////////////////////////////         SEGURIDAD               /////////////////////////////
				$this->io_sql->commit();
			}

	  return $lb_valido;
	}// fin de la function uf_saf_update_seriales

  function uf_load_config($as_codsis,$as_seccion,$as_entry,&$ls_value)
  {
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//	     Function: uf_load_config
	//		   Access: public
	//	    Arguments:
	//	      Returns: $lb_existe = Variable booleana que retornarï¿½ true en caso de ser encontrado, caso contrario false.
	//	  Description: Determina si el registro ya existe dentro de la Tabla sigesp_config.
	// Modificado por: Ing. Nï¿½stor Falcï¿½n.
	// Fecha Creaciï¿½n: 09/07/2009 	 Fecha ï¿½ltima Modificaciï¿½n : 09/07/2009
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$lb_existe = false;
	$ls_sql = "SELECT value
	             FROM sigesp_config
	            WHERE codemp = '".$_SESSION["la_empresa"]["codemp"]."'
				  AND codsis = '".$as_codsis."'
				  AND seccion = '".$as_seccion."'
				  AND entry = '".$as_entry."'";
	$rs_data = $this->io_sql->select($ls_sql);
	if ($rs_data===false)
	   {
		 $this->io_msg->message("CLASE->sigesp_saf_c_activo.php->uf_load_config;ERROR->".$this->io_funciones->uf_convertirmsg($this->io_sql->message));
	     $lb_valido = false;
	   }
	else
	   {
	     if ($row=$this->io_sql->fetch_row($rs_data))
			{
			  $ls_value = $row["value"];
			  $lb_existe = true;
			}
	   }
    return $lb_existe;
  }

  function uf_saf_select_catalogo_general()
  {
  	$lb_valido=false;
  	$ls_sql = "SELECT * FROM saf_catalogo_general";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function uf_saf_select_catalogo_general_assoc()
  {
  	$lb_valido=false;
  	$ls_sql = "SELECT * FROM saf_catalogo_general";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_asso($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowCatalogoGeneral($ls_categoriageneral)
  {
  	$array = $this->uf_saf_select_catalogo_general();
  	$cod_array = $array[codigo_general];
  	$longitud = count($cod_array);
  	$des_array = $array[descripcion];
  	$catalogo = '<option value="">Seleccione</option>';
  	//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo, TRUE), FILE_APPEND);
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if ($cod_array[$i] == $ls_categoriageneral)
  		{
  			$catalogo .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else
  		{
  			$catalogo .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  		}
  	}
  	//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo, TRUE), FILE_APPEND);
  	return $catalogo;
  }

  function uf_saf_select_catalogo_categoria($id)
  {
  	$lb_valido=false;
  	//$ls_sql = "SELECT * FROM saf_catalogo_categoria";
  	$ls_sql = "SELECT * FROM saf_catalogo_categoria WHERE codigo_general = '$id'";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowCategoria($id)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_catalogo_categoria($id);
  	$cod_array = $array[codigo_subcategoria];
  	$longitud = count($cod_array);
  	$des_array = $array[descripcion];
  	$catalogo2 = '<option value="">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

  function uf_saf_select_catalogo_especifica($sub_categoria)
  {
  	$lb_valido=false;
  	//$ls_sql = "SELECT * FROM saf_catalogo_epecifica";
  	$ls_sql = "SELECT * FROM saf_catalogo_epecifica WHERE codigo_subcategoria = '$sub_categoria'";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowCategoriaEspecifica($sub_categoria)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_catalogo_especifica($sub_categoria);
  	$cod_array = $array[codigo_especifico];
  	$longitud = count($cod_array);
  	$des_array = $array[descripcion];
  	$catalogo3 = '<option value="">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		$catalogo3 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
	return $catalogo3;
  }

  function ShowCodigoPresupuestario($idespecifico)
  {
  	$lb_valido=false;
  	//$ls_sql = "SELECT * FROM saf_catalogo_epecifica";
  	$ls_sql = "SELECT dencat,spg_cuenta FROM saf_catalogo WHERE catalogo = '$idespecifico'";
  	$result_set=$this->io_sql->select($ls_sql);
  	//$rs_data=$this->io_sql->obtener_datos($result_set);
  	$rs_data=$this->io_sql->obtener_asso($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	//$cod_array = $rs_data[spg_cuenta][1];
  	$codigo = $rs_data[0][spg_cuenta];
  	$denominacion = $rs_data[0][dencat];
  	$array = array("spg_cuenta"=> $codigo, "dencat"=> $denominacion);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($array, TRUE), FILE_APPEND);
  	return $array;
  }

  /** sudebip_seguro_aseguradoras */
  function uf_saf_select_sudebip_seguro_aseguradoras()
  {
  	$lb_valido=false;
  	//$ls_sql = "SELECT * FROM saf_catalogo_categoria";
  	$ls_sql = "SELECT * FROM saf_sudebip_seguro_aseguradoras WHERE codigo_aseguradora != '54'";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowSudebipSeguroAseguradoras($companiaase)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_sudebip_seguro_aseguradoras();
  	$cod_array = $array[codigo_aseguradora];
  	$longitud = count($cod_array);
  	$des_array = $array[descripcion];
  	//$otro_array = $array[otro];
  	$catalogo2 = '<option value="0">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if ($cod_array[$i] == $companiaase)
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  		}
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

  /** sudebip_seguro_monedas */
  function uf_saf_select_sudebip_seguro_monedas()
  {
  	$lb_valido=false;
  	//$ls_sql = "SELECT * FROM saf_catalogo_categoria";
  	$ls_sql = "SELECT * FROM saf_sudebip_seguro_monedas WHERE codigo_moneda != '4'";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowSudebipSeguroMonedas($monedase)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_sudebip_seguro_monedas();
  	$cod_array = $array[codigo_moneda];
  	$longitud = count($cod_array);
  	$des_array = $array[descripcion];
  	//$otro_array = $array[otro];
  	$catalogo2 = '<option value="0">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if($cod_array[$i] == $monedase)
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  		}

  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

  /** sudebip_tipo_cobertura */
  function uf_saf_select_sudebip_tipo_cobertura()
  {
  	$lb_valido=false;
  	//$ls_sql = "SELECT * FROM saf_catalogo_categoria";
  	$ls_sql = "SELECT * FROM saf_sudebip_tipo_cobertura WHERE codigo_cobertura != '3'";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowSudebipTipoCobertura($tipocobase)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_sudebip_tipo_cobertura();
  	$cod_array = $array[codigo_cobertura];
  	$longitud = count($cod_array);
  	$des_array = $array[descripcion];
  	//$otro_array = $array[otro];
  	$catalogo2 = '<option value="0">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if ($cod_array[$i] == $tipocobase)
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
		}
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

	/**
	 *	     Function: uf_saf_select_activo
	 *         Access: public (sigesp_siv_d_activos)
	 *      Argumento: $as_codemp //codigo de empresa
	 *				   $as_codact //codigo de activo
	 *	      Returns: Retorna un Booleano
	 *    Description: Funcion que verifica si existe un determinado activo en la tabla saf_activo_seguro
	 **/
	function uf_saf_select_activo_seguro($as_codemp,$as_codact)
	{
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_activo_seguro  ".
				  "WHERE codemp='".$as_codemp."' ".
				  "AND codact='".$as_codact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_select_activo_seguro ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{$lb_valido=true;}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}

  function uf_saf_insert_activo_seguro($ls_codemp,$ls_codact,$companiaase,$numpolase,$tipopolaseid,
  										$montocobase,$monedase,$fechainiase,
  										$fechafinase,$rescivase,$tipocobase,$descobase,$aa_seguridad)
  {
	$lb_valido=true;
    $this->io_sql->begin_transaction();

	$ls_sql = "INSERT INTO saf_activo_seguro (codemp,codact,companiaase,numpolase,tipopolase,montocobase,monedaase,".
			  "                               fechainiase,fechafinase,respcivase,tipocobase,descobase)".
			  " VALUES( '".$ls_codemp."','".$ls_codact."','".$companiaase."','".$numpolase."','".$tipopolaseid."',".
			  "	        '".$montocobase."','".$monedase."','".$fechainiase."','".$fechafinase."',".
			  "         '".$rescivase."','".$tipocobase."','".$descobase."')";

	$li_row=$this->io_sql->execute($ls_sql);

	if($li_row===false)
	{
		$this->io_msg->message("CLASE->activo MÉTODO->uf_saf_insert_activo_seguro ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		$lb_valido=false;
		$this->io_sql->rollback();
	}
	else
	{
		$lb_valido=true;
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		$ls_evento="INSERT";
		$ls_descripcion ="Insertó el número de poliza ".$numpolase." para el activo ".$ls_codact;
		$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
										$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
										$aa_seguridad["ventanas"],$ls_descripcion);
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		$this->io_sql->commit();
	}
	return $lb_valido;
  }

  function uf_saf_update_activo_seguro($as_codemp,$as_codact,$companiaase,$numpolase,$tipopolaseid,
  										$montocobase,$monedase,$fechainiase,
  										$fechafinase,$rescivase,$tipocobase,$descobase,$aa_seguridad)
  {
  	$lb_valido=true;
  	$this->io_sql->begin_transaction();

	$ls_sql = "UPDATE saf_activo_seguro".
			  " SET companiaase='".$companiaase."',numpolase='".$numpolase."',tipopolase='".$tipopolaseid."',".
			  "     montocobase='".$montocobase."',monedaase='".$monedase."',".
			  "     fechainiase='".$fechainiase."',fechafinase='".$fechafinase."',respcivase='".$rescivase."',".
			  "     tipocobase='".$tipocobase."',descobase='".$descobase."'".
			  " WHERE codemp =  '".$as_codemp ."'".
			  "   AND codact =  '".$as_codact ."'";

	$li_row = $this->io_sql->execute($ls_sql);
	if($li_row===false)
	{
		$this->io_msg->message("CLASE->activo METODO->uf_saf_update_activo_seguro ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		$lb_valido=false;
		$this->io_sql->rollback();
	}
	else
	{
		$lb_valido=true;
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		$ls_evento="UPDATE";
		$ls_descripcion ="Actualizó el número de poliza ".$numpolase." para el activo ".$as_codact;
		$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
										$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
										$aa_seguridad["ventanas"],$ls_descripcion);
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

  function uf_saf_delete_activo_seguro($as_codemp,$as_codact,$aa_seguridad)
  {
	$lb_valido=false;
	$this->io_sql->begin_transaction();

	$ls_sql = "DELETE FROM saf_activo_seguro WHERE codemp= '".$as_codemp. "' AND codact = '".$as_codact."'";
    $li_exec=$this->io_sql->execute($ls_sql);
    if ($li_exec===false)
	  {
	    $this->io_msg->message("CLASE->activo MÉTODO->uf_saf_delete_activo_seguro ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		$this->io_sql->rollback();
	  }
    else
	  {
	    $lb_valido=true;
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		$ls_evento="DELETE";
		$ls_descripcion ="Eliminó los datos de póliza de la empresa ".$as_codemp." para el activo ".$as_codact;
		$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
										$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
										$aa_seguridad["ventanas"],$ls_descripcion);
		/////////////////////////////////         SEGURIDAD               /////////////////////////////
		$this->io_sql->commit();
	  }
  }

  /**
   * @TODO Validar que la tabla exista
   */
  function uf_saf_select_marcas_assoc()
  {
  	$lb_valido=false;
  	$ls_sql = "SELECT * FROM saf_sudebip_marcas_bienes_muebles";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_asso($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  /**
   * fuente de financinanciamiento
   */
  function uf_saf_select_fuente_financiamiento()
  {
  	$lb_valido=false;
  	$ls_sql = "SELECT * FROM sigesp_fuentefinanciamiento";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowFuenteFinanciamiento($ls_codfuefin)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_fuente_financiamiento();
  	$cod_array = $array[codfuefin];
  	$longitud = count($cod_array);
  	$des_array = $array[denfuefin];
  	//$otro_array = $array[otro];
  	$catalogo2 = '<option value="">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if ($cod_array[$i] == $ls_codfuefin)
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
		}
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

  /**
   * código de situación contable
   */
  function uf_saf_select_situacion_contable()
  {
  	$lb_valido=false;
  	$ls_sql = "SELECT codsitcon,densitcon FROM saf_situacioncontable";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowSituacionContable($ls_codsitcon)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_situacion_contable();
  	$cod_array = $array[codsitcon];
  	$longitud = count($cod_array);
  	$des_array = $array[densitcon];
  	//$otro_array = $array[otro];
  	$catalogo2 = '<option value="">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if ($cod_array[$i] == $ls_codsitcon)
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
		}
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

  /**
   * condición de compra
   */
  function uf_saf_select_condicion_compra()
  {
  	$lb_valido=false;
  	$ls_sql = "SELECT codconcom,denconcom FROM saf_condicioncompra";
  	$result_set=$this->io_sql->select($ls_sql);
  	$rs_data=$this->io_sql->obtener_datos($result_set);
  	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
  	return $rs_data;
  }

  function ShowCondicionCompra($ls_codconcom)
  {
  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
  	$array = $this->uf_saf_select_condicion_compra();
  	$cod_array = $array[codconcom];
  	$longitud = count($cod_array);
  	$des_array = $array[denconcom];
  	//$otro_array = $array[otro];
  	$catalogo2 = '<option value="">Seleccione</option>';
  	for($i=1;$i<=$longitud;$i++)
  	{
  		if ($cod_array[$i] == $ls_codconcom)
  		{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
  		}else{
  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
		}
  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
  	}
  	return $catalogo2;
  }

  	/**
   	* estado de conservación
   	*/
    function uf_saf_select_estado_conservacion()
    {
    	$lb_valido=false;
    	$ls_sql = "SELECT codconbie,denconbie FROM saf_conservacionbien";
    	$result_set=$this->io_sql->select($ls_sql);
    	$rs_data=$this->io_sql->obtener_datos($result_set);
    	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
    	return $rs_data;
    }

    function ShowEstadoConsevacion($ls_codconbie)
    {
    	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
    	$array = $this->uf_saf_select_estado_conservacion();
    	$cod_array = $array[codconbie];
    	$longitud = count($cod_array);
    	$des_array = $array[denconbie];
    	//$otro_array = $array[otro];
    	$catalogo2 = '<option value="0">Seleccione</option>';
    	for($i=1;$i<=$longitud;$i++)
    	{
    		if ($cod_array[$i] == $ls_codconbie)
    		{
    			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
    		}else{
    			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  		}
    			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
    	}
    	return $catalogo2;
    }

  	/**
   	* Estatus de uso del bien
   	*/
    function uf_saf_select_estatus_uso()
    {
    	$lb_valido=false;
    	$ls_sql = "SELECT id_estatus,descripcion FROM saf_sudebip_estatus_uso;";
    	$result_set=$this->io_sql->select($ls_sql);
    	$rs_data=$this->io_sql->obtener_datos($result_set);
    	//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
    	return $rs_data;
    }

    function ShowUsoActual($ls_usoactual)
    {
    	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
    	$array = $this->uf_saf_select_estatus_uso();
    	$cod_array = $array[id_estatus];
    	$longitud = count($cod_array);
    	$des_array = $array[descripcion];
    	//$otro_array = $array[otro];
    	$catalogo2 = '<option value="">Seleccione</option>';
    	for($i=1;$i<=$longitud;$i++)
    	{
    		if ($cod_array[$i] == $ls_usoactual)
    		{
    			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
    		}else{
    			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
  		}
    			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
    	}
    	return $catalogo2;
    }

	/**
     * uf_saf_select_pais
     * @access public
     * @return boolean
     */

    function uf_saf_select_pais() {
        $lb_valido = false;
        /** lista de paises segun sudebip */
        /* $ls_sql = "SELECT codigo_pais,descripcion FROM sudebip_paises WHERE codigo_pais != '239'"; */
        /** lista de paises segun sugau */
        $ls_sql = "SELECT codpai,despai FROM sigesp_pais";
        $result_set=$this->io_sql->select($ls_sql);
        $rs_data=$this->io_sql->obtener_datos($result_set);
        //print_r($rs_data);
		//file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);
        if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_pais ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}

        return $rs_data;
    }//fin uf_saf_select_tiposede

      function ShowPaises($ls_codpai)
      {
      	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
      	$array = $this->uf_saf_select_pais();
      	//$cod_array = $array[codigo_pais];
      	//$longitud = count($cod_array);
      	//$des_array = $array[descripcion];
      	$cod_array = $array[codpai];
      	$longitud = count($cod_array);
      	$des_array = $array[despai];
      	//$otro_array = $array[otro];
      	//$catalogo2 = '<option value="0">Seleccione</option>';
      	for($i=1;$i<=$longitud;$i++)
      	{
      		if ($cod_array[$i] == $ls_codpai)
      		{
      			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
      		}else{
      			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
    		}
      			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
      	}
      	return $catalogo2;
      }

    /**
     * uf_saf_select_estados
     */
    function uf_saf_select_estados($ls_codest) {
    	$lb_valido = false;
    	/** lista de estados segun sudebip */
    	//$ls_sql = "SELECT codigo_estado,descripcion FROM sudebip_estados";
    	/** lista de estados segun sugau */
    	$ls_sql = "SELECT codest,desest FROM sigesp_estados WHERE codpai = '".$ls_codest."'";
    	$result_set=$this->io_sql->select($ls_sql);
    	$rs_data=$this->io_sql->obtener_datos($result_set);
    	//print_r($rs_data);
    	if($rs_data===false)
    	{
    		$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_estados ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
    	}

    	return $rs_data;
    }//fin uf_saf_select_estados

      function ShowEstados($ls_codest)
      {
      	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
      	$array = $this->uf_saf_select_estados($ls_codest);
      	//$cod_array = $array[codigo_estado];
      	//$longitud = count($cod_array);
      	//$des_array = $array[descripcion];
      	$cod_array = $array[codest];
      	$longitud = count($cod_array);
      	$des_array = $array[desest];
      	//$otro_array = $array[otro];
      	//$catalogo2 = '<option value="0">Seleccione</option>';
      	for($i=1;$i<=$longitud;$i++)
      	{
      		if ($cod_array[$i] == $ls_codest)
      		{
      			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
      		}else{
      			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
    		}
      	}
      	return $catalogo2;
      }

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

		//$ls_sql = "SELECT codigo_municipio,descripcion FROM sudebip_municipios WHERE codigo_estado = '".$ls_codestado."'";
		$ls_sql = "SELECT codmun,denmun FROM sigesp_municipio WHERE codest = '".$ls_codestado."'";
	    $result_set=$this->io_sql->select($ls_sql);
    	$rs_data=$this->io_sql->obtener_datos($result_set);

	    //print_r($rs_data);
	    if($rs_data===false)
		{
			$this->io_msg->message("CLASE->sedes MÉTODO->uf_saf_select_municipio ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
	    return $rs_data;
	}//fin uf_saf_select_municipio

	  function ShowMunicipios($ls_codestado)
	  {
	  	//file_put_contents('/tmp/sugau_saf.log', print_r(ShowCategoria, TRUE), FILE_APPEND);
	  	$array = $this->uf_saf_select_municipio($ls_codestado);
	  	//$cod_array = $array[codigo_municipio];
	  	//$longitud = count($cod_array);
	  	//$des_array = $array[descripcion];
	  	$cod_array = $array[codmun];
	  	$longitud = count($cod_array);
	  	$des_array = $array[denmun];
	  	//$otro_array = $array[otro];
	  	//$catalogo2 = '<option value="0">Seleccione</option>';
	  	for($i=1;$i<=$longitud;$i++)
	  	{
	  		if ($cod_array[$i] == $ls_codmun)
	  		{
	  			$catalogo2 .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
	  		}else{
	  			$catalogo2 .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
			}
	  			//file_put_contents('/tmp/sugau_saf.log', print_r($catalogo2, TRUE), FILE_APPEND);
	  	}
	  	return $catalogo2;
	  }

	/**
	 * Poliza
	 */
	function uf_saf_select_activopoliza($as_codemp,$as_codact,&$as_rifase,&$as_numpolase,&$as_percobase,&$ai_moncobase,&$ad_fecvigase)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_activopoliza
		//         Access: public
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//				   $as_rifase //R.I.F. de la aseguradora
		//				   $as_numpolase //numero de la poliza de seguro
		//				   $as_percobase //periodo de cobertura de la poliza
		//				   $ai_moncobase //monto de cobertura de la poliza
		//				   $ad_fecvigase //fecha de vigencia de la poliza
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que obtiene los datos del activo que se refieren a la poliza de seguros
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creación: 06/06/2006 								Fecha Última Modificación : 06/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT * FROM saf_activo".
				  " WHERE codemp='".$as_codemp."' ".
				  "   AND codact='".$as_codact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activoanexo MÉTODO->uf_saf_select_activopoliza ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
				$as_rifase=$row["rifase"];
				$as_numpolase=$row["numpolase"];
				$as_percobase=$row["percobase"];
				$ai_moncobase=$row["moncobase"];
				$ad_fecvigase=$this->io_funcion->uf_formatovalidofecha($row["fecvigase"]);
			}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_activopoliza

	function  uf_saf_update_activopoliza($as_codemp,$as_codact,$as_rifase,$as_numpolase,$as_percobase,$ai_moncobase,$ad_fecvigase,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_activopoliza
		//         Access: public
		//     Argumentos: $as_codemp    // codigo de empresa
		//				   $as_codact    // codigo de activo
		//				   $as_rifase    //R.I.F. de la aseguradora
		//				   $as_numpolase //numero de la poliza de seguro
		//				   $as_percobase //periodo de cobertura de la poliza
		//				   $ai_moncobase //monto de cobertura de la poliza
		//				   $ad_fecvigase //fecha de vigencia de la poliza
		//                 $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los datos del activo que se refieren a la poliza del activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creación: 06/06/2006 								Fecha Última Modificación : 06/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$this->io_sql->begin_transaction();
		$ls_sql = "UPDATE saf_activo".
				  "   SET rifase='". $as_rifase ."',".
				  "       numpolase='". $as_numpolase ."',".
				  "       percobase='". $as_percobase ."',".
				  "       moncobase='". $ai_moncobase ."',".
				  "       fecvigase='". $ad_fecvigase ."'".
				  " WHERE codemp =  '". $as_codemp ."'".
				  "   AND codact =  '". $as_codact ."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activoanexos METODO->uf_saf_update_activopoliza ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_msg->message($this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizó los datos de la póliza del Activo ".$as_codact." acociado a la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
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
	}// fin de la function uf_saf_update_activopoliza

	/**
	 * Mantenimiento
	 */
	function uf_saf_select_activomantenimiento($as_codemp,$as_codact,&$as_numconman,&$as_codproman,&$as_denproman,&$ad_feciniman,&$ad_fecfinman)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_select_activomantenimiento
		//         Access: public
		//      Argumento: $as_codemp //codigo de empresa
		//				   $as_codact //codigo de activo
		//				   $as_numconman //numero de contrato de mantenimiento
		//				   $as_codproman //codigo del proveedor de mantenimiento
		//				   $as_denproman //denominacion del proveedor de mantenimiento
		//				   $ad_feciniman //fecha de inicio del contrato
		//				   $ad_fecfinman //fecha de cierre del contrato
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que obtiene los datos del activo que se refieren a los datos de mantenimiento del activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creación: 06/06/2006 								Fecha Última Modificación : 06/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$ls_sql = "SELECT saf_activo.*,".
				  "       (SELECT nompro".
				  "          FROM rpc_proveedor".
				  "         WHERE codemp='".$as_codemp."'".
				  "           AND rpc_proveedor.cod_pro=saf_activo.codproman) AS denproman".
				  "  FROM saf_activo  ".
				  " WHERE codemp='".$as_codemp."' ".
				  "   AND codact='".$as_codact."'" ;
		$rs_data=$this->io_sql->select($ls_sql);
		if($rs_data===false)
		{
			$this->io_msg->message("CLASE->activoanexo MÉTODO->uf_saf_select_activomantenimiento ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
		}
		else
		{
			if($row=$this->io_sql->fetch_row($rs_data))
			{
				$lb_valido=true;
				$as_numconman=$row["numconman"];
				$as_codproman=$row["codproman"];
				$as_denproman=$row["denproman"];
				$ad_feciniman=$this->io_funcion->uf_formatovalidofecha($row["feciniman"]);
				$ad_fecfinman=$this->io_funcion->uf_formatovalidofecha($row["fecfinman"]);
			}
		}
		$this->io_sql->free_result($rs_data);
		return $lb_valido;
	}//fin de la function uf_saf_select_activomantenimiento

	function  uf_saf_update_activomantenimiento($as_codemp,$as_codact,$as_numconman,$as_codproman,$ad_feciniman,$ad_fecfinman,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_activomantenimiento
		//         Access: public
		//     Argumentos: $as_codemp    // codigo de empresa
		//				   $as_codact    // codigo de activo
		//				   $as_numconman //numero de contrato de mantenimiento
		//				   $as_codproman //codigo del proveedor de mantenimiento
		//				   $ad_feciniman //fecha de inicio del contrato
		//				   $ad_fecfinman //fecha de cierre del contrato
		//                 $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los datos del activo que se refieren al contrato de manteniento en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creación: 06/06/2006 								Fecha Última Modificación : 06/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$this->io_sql->begin_transaction();
		$ls_sql = "UPDATE saf_activo".
				  "   SET numconman='". $as_numconman ."',".
				  "       codproman='". $as_codproman ."',".
				  "       feciniman='". $ad_feciniman ."',".
				  "       fecfinman='". $ad_fecfinman ."'".
				  " WHERE codemp =  '". $as_codemp ."'".
				  "   AND codact =  '". $as_codact ."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activoanexos MÉTODO->uf_saf_update_activomantenimiento ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizó los datos del contrato de mantenimiento del Activo ".$as_codact." acociado a la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$this->io_sql->commit();
		}
	    return $lb_valido;
	}// fin de la function uf_saf_update_activomantenimiento

	function  uf_saf_update_activobanco($as_codemp,$as_codact,$as_codban,$as_ctaban,$as_codtipcta,$as_tippag,$as_numregpag,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_activo
		//         Access: public (sigesp_siv_d_activo)
		//     Argumentos: $as_codemp    // codigo de empresa
		//				   $as_codact    // codigo de activo
		//			       $as_codban    // codigo del banco
		//				   $as_ctaban    // codigo de cuenta de la empresa
		//				   $as_codtipcta // tipo de cuenta
		//				   $as_tippag    // tipo de pago
		//				   $as_numregpag // numero de registro del pago
		//                 $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los datos del activo que se refieren al banco y la cuenta en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creación: 06/06/2006 								Fecha Última Modificación : 06/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$this->io_sql->begin_transaction();
		$ls_sql = "UPDATE saf_activo".
				  "   SET codban='". $as_codban ."',".
				  "       ctaban='". $as_ctaban ."',".
				  "       codtipcta='". $as_codtipcta ."',".
				  "       tippag='". $as_tippag ."',".
				  "       numregpag='". $as_numregpag ."'".
				  " WHERE codemp =  '". $as_codemp ."'".
				  " AND codact =  '". $as_codact ."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activoanexos MÉTODO->uf_saf_update_activobanco ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizó los datos de banco del Activo ".$as_codact." acociado a la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$this->io_sql->commit();
		}
	    return $lb_valido;
	}

	function  uf_saf_update_activorotulacion($as_codemp,$as_codact,$as_codrot,$as_codprorot,$ad_fecrot,$aa_seguridad)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_saf_update_activorotulacion
		//         Access: public
		//     Argumentos: $as_codemp    // codigo de empresa
		//				   $as_codact    // codigo de activo
		//				   $as_codrot    //codigo de rotulacion
		//				   $as_codprorot //codigo del proveedor del servicio de rotulacion
		//				   $ad_fecrot    //fecha de la rotulacion
		//                 $aa_seguridad // arreglo de registro de seguridad
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que actualiza los datos del activo que se refieren a la poliza del activo en la tabla saf_activo
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creación: 06/06/2006 								Fecha Última Modificación : 06/06/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$lb_valido=false;
		$this->io_sql->begin_transaction();
		$ls_sql = "UPDATE saf_activo".
				  "   SET codrot='". $as_codrot ."',".
				  "       codprorot='". $as_codprorot ."',".
				  "       fecrot='". $ad_fecrot ."'".
				  " WHERE codemp =  '". $as_codemp ."'".
				  "   AND codact =  '". $as_codact ."'";
		$li_row = $this->io_sql->execute($ls_sql);
		if($li_row===false)
		{
			$this->io_msg->message("CLASE->activoanexos MÉTODO->uf_saf_update_activorotulacion ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
			$this->io_sql->rollback();
		}
		else
		{
			$lb_valido=true;
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$ls_evento="UPDATE";
			$ls_descripcion ="Actualizó los datos de la rotulación del Activo ".$as_codact." acociado a la Empresa ".$as_codemp;
			$ls_variable= $this->seguridad->uf_sss_insert_eventos_ventana($aa_seguridad["empresa"],
											$aa_seguridad["sistema"],$ls_evento,$aa_seguridad["logusr"],
											$aa_seguridad["ventanas"],$ls_descripcion);
			/////////////////////////////////         SEGURIDAD               /////////////////////////////
			$this->io_sql->commit();
		}
	    return $lb_valido;
	}

	/**
	 * @param la_metodo arreglo de valores que puede tomar el combo.
	 * Description:  Esta funcion carga el arreglo del combo de metodo de depreciacion.
	 */
	function uf_saf_select_metodo_depreciacion()
	{
		$lb_valido = false;
		$ls_sql="SELECT * FROM saf_metodo";
		$result_set=$this->io_sql->select($ls_sql);
		$rs_data=$this->io_sql->obtener_datos($result_set);
		return $rs_data;
	}
	/**
	 * @param la_metodo arreglo de valores que puede tomar el combo.
	 * @param ls_metodo item seleccionado.
	 * Description:  Esta funcion carga el combo de metodo de depreciacion manteniendo la seleccion.
	 */
	function ShowDepreciacionMetodo($ls_cmbmetodos)
	{
		$array = $this->uf_saf_select_metodo_depreciacion();
		$cod_array = $array["codmetdep"];
		$longitud = count($cod_array);
		$des_array = $array["denmetdep"];

		$catalago = '<option value="0">Seleccione</option>';
		for($i=1;$i<=$longitud;$i++)
		{
			if($cod_array[$i] == $ls_cmbmetodos)
			{
				$catalogo .= '<option value="'.$cod_array[$i].'" selected>'.$des_array[$i].'</option>';
			}else {
				$catalogo .= '<option value="'.$cod_array[$i].'">'.$des_array[$i].'</option>';
			}
		}
		return $catalogo;
	}

	function uf_saf_load_activos_reporte_simple($as_codemp)
	{
	    $lb_valido = false;
	    $ls_sql = "SELECT saf_activo.codact,saf_activo.denact,saf_activo.maract,saf_activo.modact," .
	              "       saf_activo.feccmpact,saf_activo.serial,saf_activo.numero_chapa,saf_activo.costo" .
	              " FROM saf_activo" .
	              " WHERE saf_activo.codemp='" . $as_codemp . "'" .
	              " ORDER BY saf_activo.codact DESC LIMIT 15";

	    $result_set=$this->io_sql->select($ls_sql);
	    $rs_data=$this->io_sql->obtener_asso($result_set);
	    //file_put_contents('/tmp/sugau_saf.log', print_r($rs_data, TRUE), FILE_APPEND);

	    return $rs_data;
	}

	/**
	 * Lista el *Catálogo de Unidad Ejecutora*
	 *
	 * @param string $ls_coduniadm Código de la *Unidad Organizacional* actual.
	 *
	 * @return string $unidadesEjecutoras Las <option> del <select>.
	 */
	 function uf_list_catalogo_unidad_ejecutora($ls_coduniadm)
	 {
		 $sql = "SELECT spg_unidadadministrativa.coduniadm, ";
		 $sql .= "max(spg_unidadadministrativa.denuniadm) as denuniadm";
		 $sql .= " FROM spg_unidadadministrativa, spg_dt_unidadadministrativa, spg_ep5";
		 $sql .= " WHERE spg_unidadadministrativa.codemp='".$this->ls_codemp."'";
		 $sql .= " AND spg_unidadadministrativa.coduniadm <>'----------' ";
		 $sql .= " AND spg_unidadadministrativa.codemp=spg_dt_unidadadministrativa.codemp";
		 $sql .= " AND spg_unidadadministrativa.coduniadm=spg_dt_unidadadministrativa.coduniadm";
		 $sql .= " AND spg_dt_unidadadministrativa.estcla=spg_ep5.estcla";
		 $sql .= " AND spg_dt_unidadadministrativa.codestpro1=spg_ep5.codestpro1";
		 $sql .= " AND spg_dt_unidadadministrativa.codestpro2=spg_ep5.codestpro2";
		 $sql .= " AND spg_dt_unidadadministrativa.codestpro3=spg_ep5.codestpro3";
		 $sql .= " AND spg_dt_unidadadministrativa.codestpro4=spg_ep5.codestpro4";
		 $sql .= " AND spg_dt_unidadadministrativa.codestpro5=spg_ep5.codestpro5";
		 $sql .= " GROUP BY spg_unidadadministrativa.codemp, spg_unidadadministrativa.coduniadm";
		 $sql .= " ORDER BY coduniadm ASC ";

		 $result_set = $this->io_sql->select($sql);
		 $rs_data = $this->io_sql->obtener_datos($result_set);
		 $coduniadm_array = $rs_data["coduniadm"];
		 $longitud = count($coduniadm_array);
		 $denuniadm_array = $rs_data["denuniadm"];

		 $unidadesEjecutoras = '<option value="0">Seleccione</option>';
		 for($i=1;$i<=$longitud;$i++)
		 {
			 if($coduniadm_array[$i] == $ls_coduniadm)
			 {
				 $unidadesEjecutoras .= '<option value="'.$coduniadm_array[$i].'" selected>'.$denuniadm_array[$i].'</option>';
			 }else {
				 $unidadesEjecutoras .= '<option value="'.$coduniadm_array[$i].'">'.$denuniadm_array[$i].'</option>';
			 }
		 }
		 return $unidadesEjecutoras;
	 }

}
?>
