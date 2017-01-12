<?php
/**
*  Clase sigesp_c_seguridad
*  @author SIGESP
*  @package SUGAU
*  @version 1.0
*  @filesource
*/
	class sigesp_c_seguridad
	{
		function sigesp_c_seguridad()
		{
			ini_set('max_execution_time ','0');
			ini_set('memory_limit','32M');
			require_once("class_sql.php");
			require_once("sigesp_include.php");
			require_once("class_mensajes.php");
			require_once("class_funciones_db.php");
			require_once("class_funciones.php");
			$in=new sigesp_include();
			$this->con=$in->uf_conectar();
			$this->io_msg=     new class_mensajes();
			$this->io_funcion= new class_funciones();
			$this->io_sql=     new class_sql($this->con);
			$this->io_fun=     new class_funciones_db($this->con);
		}

		function uf_sss_select_eventos($as_evento,$ls_descripcion)
		{
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//	     Function: uf_sss_select_eventos
			//         Access: public
			//      Argumento: $as_evento        // codigo de evento
			//                 $ls_descripcion   // descripcion  de evento
			//	      Returns: Retorna un Booleano
			//    Description: Funcion que verifica la existencia de un evento en la tabla sss_eventos
			//	   Creado Por: Ing. Luis Anibal Lang
			// Fecha Creaci�n: 01/11/2005 								Fecha �ltima Modificaci�n :
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$lb_valido=true;
			$ls_sql="";
			$ls_enabled= 1;
			$ls_sql="SELECT * FROM sss_eventos".
					" WHERE evento='".$as_evento."' ";
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_msg->message("CLASE->seguridad M�TODO->uf_sss_select_eventos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
			}
			else
			{
				if($row=$this->io_sql->fetch_row($rs_data))
				{
					$ls_descripcion=$row["deseve"];
					$lb_valido=true;
				}
				else
				{
					$ls_descripcion="";
					$lb_valido=false;
				}
				$this->io_sql->free_result($rs_data);
			}
			return $lb_valido;
		} // end function uf_sss_select_eventos


		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_sss_insert_eventos_ventana
		//         Access: public
		//      Argumento: $as_empresa      // codigo de empresa
		//                 $as_sistema      // codigo de sistema
		//                 $as_evento       // codigo de evento
		//                 $as_usuario      // codigo de usuario
		//                 $as_ventana      // codigo de ventana
		//                 $as_descripcion  // descripcion  de evento
		//	      Returns: Retorna un Booleano
		//    Description: Funcion que inserta un evento que se origina en alguna operaci�n  de INSERT, UPDATE � DELETE
		//				   dentro del Sistema y lo inserta en la tabla sss_registro_eventos
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci�n: 01/11/2005 								Fecha �ltima Modificaci�n :
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function uf_sss_insert_eventos_ventana($as_empresa,$as_sistema,$as_evento,$as_usuario,$as_ventana,$as_descripcion)
		{
			if($as_usuario!="PSEGIS")
			{
				//$lb_valido=true;
				$ls_sql="";

				$ld_fecha = date("Y-m-d H:i:s");
				$ls_ip=$this->getip();
				$ls_descripcion="";
				$ls_tabla="sss_registro_eventos";
				$ls_columna="numeve";
				$ls_codintper="---------------------------------";
				$li_numeve=$this->io_fun->uf_generar_codigo("","",$ls_tabla,$ls_columna);
				$ls_sisope="N/D";
				$as_ventana= $this->obtenerCodigoMenu($as_sistema,$as_ventana,$campo);
				$ls_sql= "INSERT INTO sss_registro_eventos (codemp, numeve, codusu, codsis, evento, $campo, codintper, fecevetra, equevetra,".
						 		 " 									desevetra, ususisoper)".
						 		 " VALUES ('".$as_empresa."','".$li_numeve."','".$as_usuario."','".$as_sistema."','".$as_evento."',".
						 		 " 		   '".$as_ventana."','".$ls_codintper."','".$ld_fecha."','".$ls_ip."','".$as_descripcion."','".$ls_sisope."')" ;
				$li_row=$this->io_sql->execute($ls_sql);
				//$li_row=false;
				//file_put_contents('/tmp/sugau_saf.log',"LI_ROW".$li_row."LI_ROW", FILE_APPEND);
				if($li_row===false)
				{
					//$this->io_msg->message("CLASE->seguridad M�TODO->uf_sss_insert_eventos_ventana ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
					//$this->io_msg->message("SQL: ".$ls_sql);
					$lb_valido[0]=false;
					// $lb_valido[1]=utf8_encode("CLASE->seguridad METODO->uf_sss_insert_eventos_ventana ERROR->".$this->io_sql->message);
					$lb_valido[1]="CLASE->seguridad METODO->uf_sss_insert_eventos_ventana ERROR->".$this->io_sql->message;
				}
				else
				{
					$lb_valido[0]=true;
				}
			}
			else
			{
				$lb_valido[0]=true;
			}
		  	return $lb_valido;
		} // end  function uf_sss_insert_eventos_ventana

		function uf_sss_select_permisos($as_empresa,$as_usuario,$as_sistema,$as_ventana)
		{
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//	     Function: uf_sss_select_permisos
			//         Access: public
			//      Argumento: $as_empresa      // codigo de empresa
			//                 $as_usuario      // codigo de usuario
			//                 $as_sistema      // codigo de sistema
			//                 $as_ventana      // codigo de ventana
			//	      Returns: Retorna un Booleano
			//    Description: Funcion que verifica si un usuario tiene permiso en determinada pantalla o no comparando que el campo
			//				   "enabled" sea igual a 1 para "permiso otorgado". En la tabla sss_derechos_usuarios
			//	   Creado Por: Ing. Luis Anibal Lang
			// Fecha Creaci�n: 01/11/2005 								Fecha �ltima Modificaci�n :
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$lb_valido=true;
			$ls_sql="";
			$ls_enabled= 1;
			$as_ventana= $this->obtenerCodigoMenu($as_sistema,$as_ventana,$campo);

			$ls_sql="SELECT * FROM sss_derechos_usuarios".
					" WHERE codemp='".$as_empresa."'".
					"   AND codusu='".$as_usuario."'".
					"   AND codsis='".$as_sistema."'".
					"   AND $campo='".$as_ventana."'".
					"   AND enabled=".$ls_enabled." ";
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_msg->message("CLASE->seguridad M�TODO->uf_sss_select_permisos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
			}
			else
			{
				if($row=$this->io_sql->fetch_row($rs_data))
				{
					$lb_valido=true;
				}
				else
				{
					$this->io_msg->message("NO TIENE PERMISO");
					$lb_valido=false;
				}
				$this->io_sql->free_result($rs_data);
			}
			return $lb_valido;
		} // end  function uf_sss_select_permisos


		function uf_sss_load_permisos($as_empresa,$as_usuario,$as_sistema,$as_ventana,&$aa_permisos)
		{
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//	     Function: uf_sss_select_permisos
			//         Access: public
			//      Argumento: $as_empresa       // codigo de empresa
			//                 $as_usuario       // codigo de usuario
			//                 $as_sistema       // codigo de sistema
			//                 $as_ventana       // codigo de ventana
			//                 $aa_permisos      // arreglo que contiene los permisos de la barra de herramienta
			//	      Returns: Retorna un Booleano
			//    Description: Funcion que verifica si un usuario tiene permiso en determinada pantalla o no comparando que el campo
			//				   "enabled" sea igual a 1 para "permiso otorgado" y carga en un arreglo todos los permisos de la barra
			//				   de herramientas En la tabla sss_derechos_usuarios
			//	   Creado Por: Ing. Luis Anibal Lang
			// Fecha Creaci�n: 01/11/2005 								Fecha �ltima Modificaci�n : 19/03/2007
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$lb_valido=true;
			$aa_permisos = array();
			$ls_sql="";
			$ls_enabled= 1;
			$as_ventana= $this->obtenerCodigoMenu($as_sistema,$as_ventana,$campo);
			$ls_sql="SELECT * FROM sss_derechos_usuarios".
					" WHERE codemp='".$as_empresa."'".
					"   AND codusu='".$as_usuario."'".
					"   AND codsis='".$as_sistema."'".
					"   AND $campo='".$as_ventana."'".
					"   AND enabled=".$ls_enabled." ";


			//echo $ls_sql;
			//die();
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_msg->message("CLASE->seguridad M�TODO->uf_sss_select_permisos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
			}
			else
			{
				if($row=$this->io_sql->fetch_row($rs_data))
				{
					$lb_valido=true;
					$aa_permisos["enabled"]=  $row["enabled"];
					$aa_permisos["leer"]=     $row["leer"];
					$aa_permisos["incluir"]=  $row["incluir"];
					$aa_permisos["cambiar"]=  $row["cambiar"];
					$aa_permisos["eliminar"]= $row["eliminar"];
					$aa_permisos["imprimir"]= $row["imprimir"];
					$aa_permisos["anular"]=   $row["anular"];
					$aa_permisos["ejecutar"]= $row["ejecutar"];
					$aa_permisos["administrador"]= $row["administrativo"];
				}
				else
				{
					$this->io_msg->message("NO TIENE PERMISO");
					$lb_valido=false;
				}
				$this->io_sql->free_result($rs_data);
			}
			return $lb_valido;
		} // end  function uf_sss_select_permisos




		function uf_sss_load_permisos2($as_empresa,$as_usuario,$as_sistema,$as_ventana,&$aa_permisos)
		{
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//	     Function: uf_sss_select_permisos
			//         Access: public
			//      Argumento: $as_empresa       // codigo de empresa
			//                 $as_usuario       // codigo de usuario
			//                 $as_sistema       // codigo de sistema
			//                 $as_ventana       // codigo de ventana
			//                 $aa_permisos      // arreglo que contiene los permisos de la barra de herramienta
			//	      Returns: Retorna un Booleano
			//    Description: Funcion que verifica si un usuario tiene permiso en determinada pantalla o no comparando que el campo
			//				   "enabled" sea igual a 1 para "permiso otorgado" y carga en un arreglo todos los permisos de la barra
			//				   de herramientas En la tabla sss_derechos_usuarios
			//	   Creado Por: Ing. Luis Anibal Lang
			// Fecha Creaci�n: 01/11/2005 								Fecha �ltima Modificaci�n : 19/03/2007
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$lb_valido=true;
			$aa_permisos = array();
			$ls_sql="";
			$ls_enabled= 1;
			$as_ventana= $this->obtenerCodigoMenu($as_sistema,$as_ventana,$campo);
			$ls_sql="SELECT * FROM sss_derechos_usuarios".
					" WHERE codemp='".$as_empresa."'".
					"   AND codusu='".$as_usuario."'".
					"   AND codsis='".$as_sistema."'".
					"   AND $campo='".$as_ventana."'".
					"   AND enabled=".$ls_enabled." ";


			//echo $ls_sql;
			//die();
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_msg->message("CLASE->seguridad M�TODO->uf_sss_select_permisos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
			}
			else
			{
				if($row=$this->io_sql->fetch_row($rs_data))
				{
					$lb_valido=true;
					$aa_permisos["enabled"]=  $row["enabled"];
					$aa_permisos["leer"]=     $row["leer"];
					$aa_permisos["incluir"]=  $row["incluir"];
					$aa_permisos["cambiar"]=  $row["cambiar"];
					$aa_permisos["eliminar"]= $row["eliminar"];
					$aa_permisos["imprimir"]= $row["imprimir"];
					$aa_permisos["anular"]=   $row["anular"];
					$aa_permisos["ejecutar"]= $row["ejecutar"];
					$aa_permisos["administrador"]= $row["administrativo"];
				}
				else
				{
					$aa_permisos="";
					$lb_valido=false;
				}
				$this->io_sql->free_result($rs_data);
			}
			return $lb_valido;
		} // end  function uf_sss_select_permisos








		function uf_sss_load_permisosinternos($as_empresa,$as_usuario,$as_sistema,$as_ventana,$as_codintper,&$aa_permisos)
		{
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//	     Function: uf_sss_load_permisosinternos
			//         Access: public
			//      Argumento: $as_empresa       // codigo de empresa
			//                 $as_usuario       // codigo de usuario
			//                 $as_sistema       // codigo de sistema
			//                 $as_ventana       // codigo de ventana
			//                 $as_codintper     // codigo interno de permisologia
			//                 $aa_permisos      // arreglo que contiene los permisos de la barra de herramienta
			//	      Returns: Retorna un Booleano
			//    Description: Funcion que verifica si un usuario tiene permiso en determinada pantalla o no comparando que el campo
			//				   "enabled" sea igual a 1 para "permiso otorgado" y carga en un arreglo todos los permisos de la barra
			//				   de herramientas En la tabla sss_derechos_usuarios, en los casos de SNO y SPG verificando igualmente
			//				   el codigo interno de permisologia
			//	   Creado Por: Ing. Luis Anibal Lang
			// Fecha Creaci�n: 26/10/2006 								Fecha �ltima Modificaci�n : 19/03/2007
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$lb_valido=true;
			$ls_sql="";
			$ls_enabled= 1;
			$as_ventana= $this->obtenerCodigoMenu($as_sistema,$as_ventana,$campo);
			$ls_sql="SELECT * FROM sss_derechos_usuarios".
					" WHERE codemp='".$as_empresa."'".
					"   AND codusu='".$as_usuario."'".
					"   AND codsis='".$as_sistema."'".
					"   AND $campo='".$as_ventana."'".
					"   AND enabled=".$ls_enabled." ".
					"   AND codintper='".$as_codintper."' ";
			$rs_data=$this->io_sql->select($ls_sql);
			if($rs_data===false)
			{
				$this->io_msg->message("CLASE->seguridad M�TODO->uf_sss_load_permisosinternos ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
				$lb_valido=false;
			}
			else
			{
				if($row=$this->io_sql->fetch_row($rs_data))
				{
					$lb_valido=true;
					$aa_permisos["leer"]=     $row["leer"];
					$aa_permisos["incluir"]=  $row["incluir"];
					$aa_permisos["cambiar"]=  $row["cambiar"];
					$aa_permisos["eliminar"]= $row["eliminar"];
					$aa_permisos["imprimir"]= $row["imprimir"];
					$aa_permisos["anular"]=   $row["anular"];
					$aa_permisos["ejecutar"]= $row["ejecutar"];
					$aa_permisos["administrador"]= $row["administrativo"];
				}
				else
				{
					$this->io_msg->message("NO TIENE PERMISO");
					$lb_valido=false;
				}
				$this->io_sql->free_result($rs_data);
			}
			return $lb_valido;
		} // end  function uf_sss_load_permisosinternos


		function uf_sss_load_permisossigesp()
		{
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//	     Function: uf_sss_load_permisossigesp
			//         Access: public
			//      Argumento: $aa_permisos      // arreglo que contiene los permisos de la barra de herramienta
			//	      Returns: Retorna un Booleano
			//    Description: Funcion que otorga todos los permisos al usuario SIGESP
			//	   Creado Por: Ing. Luis Anibal Lang
			// Fecha Creaci�n: 01/11/2005 								Fecha �ltima Modificaci�n : 19/03/2007
			/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			$aa_permisos["leer"]=1;
			$aa_permisos["incluir"]=1;
			$aa_permisos["cambiar"]=1;
			$aa_permisos["eliminar"]=1;
			$aa_permisos["imprimir"]=1;
			$aa_permisos["anular"]=1;
			$aa_permisos["ejecutar"]=1;
			$aa_permisos["administrador"]= 1;
			return $aa_permisos;
		} // end  function uf_sss_select_permisossigesp

		function getip()
		{
		   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown"))
				   $ip = getenv("HTTP_CLIENT_IP");
		   else if (getenv("HTTP_X_FORWARDED_FOR ") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR "), "unknown"))
				   $ip = getenv("HTTP_X_FORWARDED_FOR ");
		   else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
				   $ip = getenv("REMOTE_ADDR");
		   else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
				   $ip = $_SERVER['REMOTE_ADDR'];
		   else
				   $ip = "unknown";

		   return($ip);
		}

		/***********************************************************************************
		* @Funci�n que busca el c�digo del sistema ventana
		* @parametros:
		* @retorno:
		* @fecha de creaci�n: 09/10/2008
		* @autor: Ing. Yesenia Moreno de Lang
		************************************************************************************
		* @fecha modificaci�n:
		* @descripci�n:
		* @autor:
		***********************************************************************************/
			function obtenerCodigoMenu($codsis,$nomfisico,&$campo)
			{
				/*global $conexionbd;
				if (array_key_exists('session_activa',$_SESSION))
				{
					$codmenu=0;
					$_SESSION['session_activa'] = time();
					$consulta = "SELECT codmenu ".
								"  FROM sss_sistemas_ventanas ".
								" WHERE codsis = '$codsis' ".
								"	AND nomfisico ='$nomfisico' ";
					$result = $this->io_sql->Execute($consulta);
					if($result === false)
					{
						$this->valido  = false;
					}
					else
					{
						if(!$result->EOF)
						{
							$codmenu=$result->fields["codmenu"];
						}
						$result->Close();
					}
					$campo= "codmenu";
				}
				else
				{*/
					$codmenu = $nomfisico;
					$campo= "nomven";
				//}
				return $codmenu;
			}

			function uf_sss_registro_eventos_last($sistema)
			{
				$ls_sql = "SELECT numeve,codusu,evento,desevetra,fecevetra";
				$ls_sql.= " FROM sss_registro_eventos";
				$ls_sql.= " WHERE codsis = '".$sistema."'";
				$ls_sql.= " ORDER BY fecevetra DESC";
				$ls_sql.= " LIMIT 20";

				$rs_data=$this->io_sql->select($ls_sql);
				if($rs_data===false)
				{
					$this->io_msg->message("CLASE->seguridad METODO->uf_sss_registro_eventos_last ERROR->".$this->io_funcion->uf_convertirmsg($this->io_sql->message));
					$lb_valido=false;
					return $rs_data;
				}else{
					$rs_data = $this->io_sql->obtener_asso($rs_data);
					return $rs_data;
				}
			}

		}//  end class sigesp_c_seguridad
?>
