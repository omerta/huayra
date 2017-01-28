<?php
session_start();
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
if(!array_key_exists("la_logusr",$_SESSION))
{
	print "<script language=JavaScript>";
	print "location.href='../sigesp_inicio_sesion.php'";
	print "</script>";
}
$ls_logusr=$_SESSION["la_logusr"];
require_once("class_funciones_activos.php");
$io_fun_activo=new class_funciones_activos();
// @TODO
//$io_fun_activo->uf_load_seguridad("SAF","sigesp_saf_p_incorporaciones.php",$ls_permisos,$la_seguridad,$la_permisos);
$io_fun_activo->uf_load_seguridad("SAF","sigesp_saf_d_aseguradoras.php",$ls_permisos,$la_seguridad,$la_permisos);
require_once("sigesp_saf_c_activo.php");
$ls_codemp = $_SESSION["la_empresa"]["codemp"];
$io_saf_tipcat= new sigesp_saf_c_activo();
$ls_rbtipocat=$io_saf_tipcat->uf_select_valor_config($ls_codemp);
//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
   function uf_obtenervalor($as_valor, $as_valordefecto)
   {
	//////////////////////////////////////////////////////////////////////////////
	//	Function:  uf_obtenervalor
	//	Access:    public
	//	Arguments:
    // 				as_valor         //  nombre de la variable que desamos obtener
    // 				as_valordefecto  //  contenido de la variable
    // Description: Funci? que obtiene el valor de una variable si viene de un submit
	//////////////////////////////////////////////////////////////////////////////
		if(array_key_exists($as_valor,$_POST))
		{
			$valor=$_POST[$as_valor];
		}
		else
		{
			$valor=$as_valordefecto;
		}
   		return $valor;
   }
   //--------------------------------------------------------------
   function uf_limpiarvariables()
   {
		//////////////////////////////////////////////////////////////////////////////////
		//	Function:  uf_limpiarvariables
		//	Description: Funci? que limpia todas las variables necesarias en la p?ina
		/////////////////////////////////////////////////////////////////////////////////
   		global $ls_cmpmov,$ls_codres,$ls_codresnew,$ls_nomres,$ls_nomresnew,$ls_descmp,$ld_feccmp, $ls_codcau,$ls_dencau,$ls_codubicfisica;
   		global $ls_estpromov,$ls_status,$ls_titletable,$li_widthtable,$ls_nametable,$lo_title,$li_totrows,$ls_codrespri,$ls_numcmp;
		global $ls_denrespri,$ls_codresuso,$ls_denresuso,$ls_tiprespri,$ls_tipresuso,$ls_coduniadm,$ls_denuniadm,$ls_ubigeo;
        global $ls_fecent;

		$ls_cmpmov=$ls_numcmp="";
		$ls_codres="";
		$ls_codresnew="";
		$ls_nomres="";
		$ls_nomresnew="";
		$ls_descmp="";
		$ls_codcau="";
		$ls_dencau="";
		$ls_estpromov="";
		$ld_feccmp= date("d/m/Y");
		$ls_status="";
		$ls_titletable="Activos";
		$li_widthtable=750;
		$ls_nametable="grid";
		$lo_title[1]="Activo";
		$lo_title[2]="N&uacute;mero Chapa";
		$lo_title[3]="Descripci&oacute;n del Movimiento";
		$lo_title[4]="Monto Activo";
		$lo_title[5]="";
		$li_totrows=1;
		$ls_codrespri="";
		$ls_denrespri="";
		$ls_codresuso="";
		$ls_denresuso="";
		$ls_tiprespri=uf_obtenervalor("cmbtiprespri","-");
		$ls_tipresuso=uf_obtenervalor("cmbtipresuso","-");
		$ls_coduniadm="";
		$ls_denuniadm="";
    	$ls_codubifisrespri=""; //AGREGADA POR JOSE LUIS AGUILERA OPSU - CTSI C?igo de ubicaci? fisica del Responsable Primario
		$ls_desubifisrespri=""; //AGREGADA POR JOSE LUIS AGUILERA OPSU - CTSI Denominaci? de ubicaci? fisica del Responsable Primario
		$ls_codubifisresuso=""; //AGREGADA POR JOSE LUIS AGUILERA OPSU - CTSI C?igo de ubicaci? fisica del Responsable de Uso
		$ls_desubifisresuso=""; //AGREGADA POR JOSE LUIS AGUILERA OPSU - CTSI Denominaci? de ubicaci? fisica del Responsable de Uso
		$ls_ubigeo="";
		$ls_fecent="";

   }

   function uf_agregarlineablanca(&$aa_object,$ai_totrows)
   {
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_agregarlineablanca
		//         Access: private
		//      Argumento: $aa_object // arreglo de titulos
		//				   $ai_totrows // ultima fila pintada en el grid
		//	      Returns:
		//    Description: Funcion que agrega una linea en blanco al final del grid
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci?: 23/03/2006 								Fecha ?tima Modificaci? : 23/03/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		$aa_object[$ai_totrows][1]="<input name=txtdenact".$ai_totrows." type=text   id=txtdenact".$ai_totrows." class=sin-borde size=25 maxlength=150 readonly>".
								   "<input name=txtcodact".$ai_totrows." type=hidden id=txtcodact".$ai_totrows." class=sin-borde size=17 maxlength=15 readonly>";
		$aa_object[$ai_totrows][2]="<input name=txtidact".$ai_totrows."  type=text   id=txtidact".$ai_totrows."  class=sin-borde size=17 maxlength=15 readonly>";
		$aa_object[$ai_totrows][3]="<input name=txtdesmov".$ai_totrows." type=text   id=txtdesmov".$ai_totrows." class=sin-borde size=45 readonly>";
		$aa_object[$ai_totrows][4]="<input name=txtmonact".$ai_totrows." type=text   id=txtmonact".$ai_totrows." class=sin-borde size=15 readonly  style=text-align:right>";
		$aa_object[$ai_totrows][5]="<a href=javascript:uf_delete_dt(".$ai_totrows.");><img src=../shared/imagebank/tools15/eliminar.gif alt=Aceptar width=15 height=15 border=0></a>";

   }

   function uf_pintardetalle(&$lo_object,$ai_totrows)
	{
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//	     Function: uf_pintardetalle
		//         Access: private
		//      Argumento: $aa_object // arreglo de objetos
		//				   $ai_totrows // ultima fila pintada en el grid
		//	      Returns:
		//    Description: Funcion que se encarga de repintar el detalle existente en el grid.
		//	   Creado Por: Ing. Luis Anibal Lang
		// Fecha Creaci?: 11/04/2006 								Fecha ?tima Modificaci? : 11/04/2006
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		for($li_i=1;$li_i<$ai_totrows;$li_i++)
		{
			$ls_codact= $_POST["txtcodact".$li_i];
			$ls_denact= $_POST["txtdenact".$li_i];
			$ls_idact=  $_POST["txtidact".$li_i];
			$ls_desmov= $_POST["txtdesmov".$li_i];
			$li_monact= $_POST["txtmonact".$li_i];

			$lo_object[$li_i][1]="<input name=txtdenact".$li_i." type=text   id=txtdenact".$li_i." class=sin-borde size=25 maxlength=150 value='".$ls_denact."' readonly>".
								 "<input name=txtcodact".$li_i." type=hidden id=txtcodact".$li_i." class=sin-borde size=17 maxlength=15 value='".$ls_codact."' readonly>";
			$lo_object[$li_i][2]="<input name=txtidact".$li_i."  type=text   id=txtidact".$li_i."  class=sin-borde size=17 maxlength=15 value='".$ls_idact."'  readonly>";
			$lo_object[$li_i][3]="<input name=txtdesmov".$li_i." type=text   id=txtdesmov".$li_i." class=sin-borde size=52 value='".$ls_desmov."' readonly>";
			$lo_object[$li_i][4]="<input name=txtmonact".$li_i." type=text   id=txtmonact".$li_i." class=sin-borde size=15 value='".$li_monact."' readonly style=text-align:right>";
			$lo_object[$li_i][5]="<a href=javascript:uf_delete_dt(".$li_i.");><img src=../shared/imagebank/tools15/eliminar.gif alt=Aceptar width=15 height=15 border=0></a>";
		}
		uf_agregarlineablanca($lo_object,$ai_totrows);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<!--<script type="text/javascript" language="JavaScript1.2" src="../shared/js/disabled_keys.js"></script>-->
		<title>Incorporaciones</title>
		<meta http-equiv="imagetoolbar" content="no">
		<script type="text/javascript" language="JavaScript1.2" src="js/stm31.js"></script>
		<script type="text/javascript" language="JavaScript1.2" src="js/funciones.js"></script>
		<link href="../shared/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="../shared/datepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		<link href="../shared/css/cabecera.css" rel="stylesheet" type="text/css">
		<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
		<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
		<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
		<!-- <link href="../shared/js/css_intra/datepickercontrol.css" rel="stylesheet" type="text/css"> -->
	</head>

	<body>
		<div class="container">
			<header>
				<div>
					<img class="img-responsive center-block" src="../shared/imagebank/header.jpg" alt="">
				</div>

				<div class="seccion">
					<div class="descripcion_sistema">
						<div>
							<font color="#6699CC" size="2">Sistema de Activos Fijos</font>
						</div>
						<div>
							<?PHP print date("j/n/Y")." - ".date("h:i a");?>
						</div>
						<div>
							<?php print $_SESSION["la_nomusu"]." ".$_SESSION["la_apeusu"];?> <i>en</i> <?php print $_SESSION["ls_database"];?>
						</div>
					</div>

					<div class="conteiner-botonera">
						<?php if ($ls_rbtipocat == 1){ ?>
						<div class="">
							<script type="text/javascript" language="JavaScript1.2" src="js/menu_csc.js"></script>
						</div>
							<?php }elseif ($ls_rbtipocat == 2){	?>
						<div class="">
							<script type="text/javascript" language="JavaScript1.2" src="js/menu_cgr.js"></script>
						</div>
							<?php }else{ ?>
						<div class="">
							<script type="text/javascript" language="JavaScript1.2" src="js/menu.js"></script>
						</div>
							<?php	}	?>
					</div>

          <nav class="navbar navbar-default barranavegacion">
            <div class="container-fluid">
              <ul class="nav navbar-nav">
								<li>
									<a href="javascript: ue_nuevo();"><span>Nuevo</span>
										<img src="../shared/imagebank/pngb64/new.png" alt="Nuevo" width="20" title="Nuevo" height="20" border="0">
									</a>
								</li>
								<li>
									<a href="javascript: ue_guardar();"><span>Guardar</span>
										<img src="../shared/imagebank/pngb64/save.png" alt="Grabar"  width="20" title="Guardar" height="20" border="0">
									</a>
								</li>
								<li>
									<a href="javascript: ue_buscar();"><span>Buscar</span>
										<img src="../shared/imagebank/pngb64/search.png" alt="Buscar" width="20"  height="20" title="Buscar" border="0">
									</a>
								</li>
						    <li>
					    		<a href="javascript: ue_imprimir();"><span>Imprimir</span>
						    		<img src="../shared/imagebank/pngb64/print.png" alt="Imprimir" title="Imprimir" width="20" height="20" border="0">
						    	</a>
								</li>
								<li>
									<a href="javascript: ue_cerrar();"><span>Cerrar</span>
										<img src="../shared/imagebank/pngb64/logout.png" alt="Salir" width="20" height="20" title="Salir" border="0">
									</a>
								</li>
								<li>
									<a href="javascript: ue_ayuda();"><span>Ayuda</span>
										<img src="../shared/imagebank/pngb64/help.png" alt="Ayuda" title="Ayuda" width="20" height="20">
									</a>
								</li>
							</ul>
						</div>
					</nav>
			</div>
		</header>
	</div>

<?php
	require_once("../shared/class_folder/sigesp_include.php");
	$in=     new sigesp_include();
	$con= $in->uf_conectar();
	require_once("../shared/class_folder/class_sql.php");
	$io_sql=  new class_sql($con);
	require_once("../shared/class_folder/class_mensajes.php");
	$io_msg= new class_mensajes();
	require_once("../shared/class_folder/class_funciones_db.php");
	$io_fundb= new class_funciones_db($con);
	require_once("../shared/class_folder/class_funciones.php");
	$io_fun= new class_funciones();
	require_once("../shared/class_folder/class_fecha.php");
	$io_fec= new class_fecha();
	require_once("sigesp_saf_c_movimiento.php");
	$io_saf= new sigesp_saf_c_movimiento();
	require_once("../shared/class_folder/grid_param.php");
	$in_grid= new grid_param();
	require_once("sigesp_saf_c_activo.php");
	$io_saf_dta= new sigesp_saf_c_activo();
	/* Unidad Física de Activos Fijos */
	require_once("sigesp_saf_c_unidadfisica.php");
	$io_unidadfisica = new sigesp_saf_c_unidadfisica();

	$arre=$_SESSION["la_empresa"];
	$ls_codemp=$arre["codemp"];
	$li_totrows = uf_obtenervalor("totalfilas",1);
	if (array_key_exists("operacion",$_POST))
	{
		$ls_operacion=$_POST["operacion"];
	}
	else
	{
		$ls_operacion="";
		uf_limpiarvariables();
		uf_agregarlineablanca($lo_object,$li_totrows);
		$ls_readonly="readonly";
	}

	switch ($ls_operacion)
	{
		case "NUEVO":
			uf_limpiarvariables();
			$ls_readonly="";
			$ls_tiprespri="-";
	    $ls_tipresuso="-";
			$ls_emp="";
			$ls_codemp="";
			$ls_tabla="saf_movimiento";
			$ls_columna="cmpmov";
			$ls_cmpmov = $io_fundb->uf_generar_codigo($ls_emp,$ls_codemp,$ls_tabla,$ls_columna);
			$ls_numcmp = $io_fundb->uf_generar_codigo_movimiento_saf("IN");//N?mero de Comprobante Independiente para cada tipo de movimiento.
			uf_agregarlineablanca($lo_object,$li_totrows);
		break;

		case "AGREGARDETALLE":
			uf_limpiarvariables();
			$li_totrows = uf_obtenervalor("totalfilas",1);
			$li_totrows = $li_totrows+1;
			$ls_cmpmov = $_POST["txtcmpmov"];
			$ls_numcmp = $_POST["txtnumcmp"];
			$ls_codcau = $_POST["txtcodcau"];
			$ls_dencau = $_POST["txtdencau"];
			$ld_feccmp = $_POST["txtfeccmp"];
			$ls_descmp = $_POST["txtdescmp"];
			$ls_status = $_POST["hidstatus"];
			$ls_codrespri = $_POST["txtcodrespri"];
			$ls_denrespri = $_POST["txtdenrespri"];
			$ls_codresuso = $_POST["txtcodresuso"];
			$ls_denresuso = $_POST["txtdenresuso"];
			$ls_codubifisresuso = $_POST["txtcoduni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_desubifisresuso = $_POST["txtdenuni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_coduniadm = $_POST["txtcoduniadm"];
			$ls_denuniadm = $_POST["txtdenuniadm"];
			$ls_ubigeo = $_POST["txtubigeo"];
			$ls_fecent=$_POST["txtfecent"];
			for($li_i=1;$li_i<$li_totrows;$li_i++)
			{
				$ls_codact= $_POST["txtcodact".$li_i];
				$ls_denact= $_POST["txtdenact".$li_i];
				$ls_idact=  $_POST["txtidact".$li_i];
				$ls_desmov= $_POST["txtdesmov".$li_i];
				$li_monact= $_POST["txtmonact".$li_i];

				$lo_object[$li_i][1]="<input name=txtdenact".$li_i." type=text   id=txtdenact".$li_i." class=sin-borde size=25 maxlength=150 value='".$ls_denact."' readonly>".
									 "<input name=txtcodact".$li_i." type=hidden id=txtcodact".$li_i." class=sin-borde size=17 maxlength=15 value='".$ls_codact."' readonly>";
				$lo_object[$li_i][2]="<input name=txtidact".$li_i."  type=text id=txtidact".$li_i."    class=sin-borde size=17 maxlength=15 value='". $ls_idact ."' readonly>";
				$lo_object[$li_i][3]="<input name=txtdesmov".$li_i." type=text id=txtdesmov".$li_i."   class=sin-borde size=52 value='". $ls_desmov ."' readonly>";
				$lo_object[$li_i][4]="<input name=txtmonact".$li_i." type=text id=txtmonact".$li_i."   class=sin-borde size=15 value='". $li_monact ."' readonly style=text-align:right>";
				$lo_object[$li_i][5]="<a href=javascript:uf_delete_dt(".$li_i.");><img src=../shared/imagebank/tools15/eliminar.gif alt=Aceptar width=15 height=15 border=0></a>";

			}
			uf_agregarlineablanca($lo_object,$li_totrows);

		break;
		case "GUARDAR":
			uf_limpiarvariables();
			$li_totrows = uf_obtenervalor("totalfilas",1);
			$ls_codusureg = $_SESSION["la_logusr"];
			$ls_cmpmov = $_POST["txtcmpmov"];
			$ls_numcmp = $_POST["txtnumcmp"];
			$ls_codcau = $_POST["txtcodcau"];
			$ls_dencau = $_POST["txtdencau"];
			$ld_feccmp = $_POST["txtfeccmp"];
			$ls_descmp = $_POST["txtdescmp"];
			$ls_status = $_POST["hidstatus"];
			$ls_codrespri = $_POST["txtcodrespri"];
			$ls_codresuso = $_POST["txtcodresuso"];
			$ls_coduniadm = $_POST["txtcoduniadm"];
			$ls_codubifisresuso = $_POST["txtcoduni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_desubifisresuso = $_POST["txtdenuni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_denuniadm = $_POST["txtdenuniadm"];
			$ls_ubigeo = $_POST["txtubigeo"];
			$ls_tiprespri = $_POST["cmbtiprespri"];
			$ls_tipresuso = $_POST["cmbtipresuso"];
			$ldt_fecent=$_POST["txtfecent"];
			$ls_fecent=$_POST["txtfecent"];
			$ld_date = date("Y-m-d");
			$lb_valido = $io_fec->uf_valida_fecha_mes($ls_codemp,$ld_date);

			if($lb_valido)
			{
				if(($ls_cmpmov!="")&&($ls_codcau!="")&&($li_totrows>=1)&&(!empty($ls_numcmp))) //modifique $li_totrows>1
				{
					$ls_estpromov="0";
					$ls_codpro="----------";
					$ls_cedbene="----------";
					$ls_codtipdoc="";
					$ld_feccmpbd=$io_fun->uf_convertirdatetobd($ld_feccmp);
					$ldt_fecent=$io_fun->uf_convertirdatetobd($ldt_fecent);

					/*  */
					$lb_existe=$io_saf->uf_saf_select_movimiento($ls_codemp,$ls_cmpmov,$ls_codcau,$ld_feccmpbd);
					if($lb_existe)
					{
						$li_totrows=1;
						uf_limpiarvariables();
						uf_agregarlineablanca($lo_object,1);
						$io_msg->message("El numero de comprobante ya existe");
						$lb_valido=false;
					}
					else
					{ // Se inserta la Incorporaci? en la tabla saf_movimiento
						$io_sql->begin_transaction();
						/*  */
						$lb_valido=$io_saf->uf_saf_insert_movimento($ls_codemp,$ls_cmpmov,$ls_codcau,$ld_feccmpbd,$ls_descmp,
						                                            $ls_codpro,$ls_cedbene,$ls_codtipdoc,$ls_codusureg,
																	$ls_estpromov,$la_seguridad,$ls_codrespri,$ls_codresuso,
																	$ls_coduniadm,$ls_ubigeo,$ls_tiprespri,$ls_tipresuso,
																	$ldt_fecent,"IN",$ls_numcmp,$ls_codubifisresuso);

						if($lb_valido)
						{
							for($li_i=1;$li_i<$li_totrows;$li_i++)
							{
								$ls_codact= $_POST["txtcodact".$li_i];
								$ls_denact= $_POST["txtdenact".$li_i];
								$ls_idact=  $_POST["txtidact".$li_i];
								$ls_desmov= $_POST["txtdesmov".$li_i];
								$li_monact= $_POST["txtmonact".$li_i];
								$li_monact= str_replace(".","",$li_monact);
								$li_monact= str_replace(",",".",$li_monact);
								$ls_estsoc=0;
								$ls_estmov="";

								$lb_valido=$io_saf->uf_saf_insert_dt_movimiento($ls_codemp,$ls_cmpmov,$ls_codcau,$ld_feccmpbd,$ls_codact,$ls_idact,$ls_desmov,$li_monact,$ls_estsoc,$ls_estmov,$la_seguridad,$ls_codubifisresuso);

								if($lb_valido)
								{
									$ls_estact="I";

									$lb_valido=$io_saf->uf_saf_insert_dtaincorporacion($ls_codemp,$ls_codact,$ls_idact,$ls_estact,$ld_feccmpbd,
																																		 $ls_coduniadm,$ls_codrespri,$ls_codresuso,$ls_codubifisresuso,
																																	 	 $la_seguridad);

								}

								$lo_object[$li_i][1]="<input name=txtdenact".$li_i." type=text   id=txtdenact".$li_i." class=sin-borde size=25 maxlength=150 value='".$ls_denact."' readonly>".
													 "<input name=txtcodact".$li_i." type=hidden id=txtcodact".$li_i." class=sin-borde size=17 maxlength=15 value='".$ls_codact."' readonly>";
								$lo_object[$li_i][2]="<input name=txtidact".$li_i."  type=text   id=txtidact".$li_i."  class=sin-borde size=17 maxlength=15 value='". $ls_idact ."' readonly>";
								$lo_object[$li_i][3]="<input name=txtdesmov".$li_i." type=text   id=txtdesmov".$li_i." class=sin-borde size=52 value='". $ls_desmov ."' readonly>";
								$lo_object[$li_i][4]="<input name=txtmonact".$li_i." type=text   id=txtmonact".$li_i." class=sin-borde size=15 value='". $li_monact ."' readonly style=text-align:right>";
								$lo_object[$li_i][5]="<a href=javascript:uf_delete_dt(".$li_i.");><img src=../shared/imagebank/tools15/eliminar.gif alt=Aceptar width=15 height=15 border=0></a>";
							}
						}

						if($lb_valido)
						{
							$io_sql->commit();
							$io_msg->message("El registro fue incluido con exito");
							$ls_estpromov=0;
							uf_pintardetalle($lo_object,$li_totrows);
							uf_agregarlineablanca($lo_object,$li_totrows);
							$ls_status="C";
							//$li_totrows=1;
						}
						else
						{
							$io_sql->rollback();
							$io_msg->message("No se pudo incluir el registro");
							uf_pintardetalle($lo_object,$li_totrows);
						}
					}
				}
				else
				{
					if($li_totrows<=1)
					{
						$io_msg->message("El registro debe tener al menos 1 detalle");
						uf_agregarlineablanca($lo_object,1);
					}
					else
					{
						$io_msg->message("Debe completar los datos.");
						uf_pintardetalle($lo_object,$li_totrows);
					}
				}
			}
			else
			{
				$io_msg->message("El mes no esta abierto");
				$li_totrows=1;
				uf_agregarlineablanca($lo_object,$li_totrows);
				uf_limpiarvariables();
			}
		break;

		case "ELIMINARDETALLE":
			uf_limpiarvariables();
			$li_totrows = uf_obtenervalor("totalfilas",1);
			$ls_cmpmov = $_POST["txtcmpmov"];
			$ls_numcmp = $_POST["txtnumcmp"];
			$ls_codcau=$_POST["txtcodcau"];
			$ls_dencau=$_POST["txtdencau"];
			$ld_feccmp=$_POST["txtfeccmp"];
			$ls_descmp=$_POST["txtdescmp"];
			$ls_status=$_POST["hidstatus"];
			$ls_codrespri = $_POST["txtcodrespri"];
			$ls_denrespri = $_POST["txtdenrespri"];
			$ls_codresuso = $_POST["txtcodresuso"];
			$ls_denresuso = $_POST["txtdenresuso"];
			$ls_codubifisresuso = $_POST["txtcoduni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_desubifisresuso = $_POST["txtdenuni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_coduniadm = $_POST["txtcoduniadm"];
			$ls_denuniadm = $_POST["txtdenuniadm"];
			$ls_ubigeo = $_POST["txtubigeo"];
			$ls_tiprespri = $_POST["cmbtiprespri"];
			$ls_tipresuso = $_POST["cmbtipresuso"];
			$ldt_fecent=$_POST["txtfecent"];
			$li_totrows=$li_totrows-1;
			$li_rowdelete=$_POST["filadelete"];
			$li_temp=0;
			for($li_i=1;$li_i<=$li_totrows;$li_i++)
			{
				if($li_i!=$li_rowdelete)
				{
					$li_temp=$li_temp+1;
					$ls_codact= $_POST["txtcodact".$li_i];
					$ls_denact= $_POST["txtdenact".$li_i];
					$ls_idact=  $_POST["txtidact".$li_i];
					$ls_desmov= $_POST["txtdesmov".$li_i];
					$li_monact= $_POST["txtmonact".$li_i];

					$lo_object[$li_temp][1]="<input name=txtdenact".$li_temp." type=text   id=txtdenact".$li_temp." class=sin-borde size=25 maxlength=150 value='".$ls_denact."' readonly>".
										 	"<input name=txtcodact".$li_temp." type=hidden id=txtcodact".$li_temp." class=sin-borde size=17 maxlength=15 value='".$ls_codact."' readonly>";
					$lo_object[$li_temp][2]="<input name=txtidact".$li_temp."  type=text   id=txtidact".$li_temp."  class=sin-borde size=17 maxlength=15 value='". $ls_idact ."' readonly>";
					$lo_object[$li_temp][3]="<input name=txtdesmov".$li_temp." type=text   id=txtdesmov".$li_temp." class=sin-borde size=52 value='". $ls_desmov ."' readonly>";
					$lo_object[$li_temp][4]="<input name=txtmonact".$li_temp." type=text   id=txtmonact".$li_temp." class=sin-borde size=15 value='". $li_monact ."' readonly style=text-align:right>";
					$lo_object[$li_temp][5]="<a href=javascript:uf_delete_dt(".$li_temp.");><img src=../shared/imagebank/tools15/eliminar.gif alt=Aceptar width=15 height=15 border=0></a>";
				}
				else
				{
					$li_rowdelete= 0;
				}
			}
			if ($li_temp==0)
			{
				$li_totrows=1;
				uf_agregarlineablanca($lo_object,$li_totrows);
			}
			else
			{
				uf_agregarlineablanca($lo_object,$li_totrows);
			}
		break;

		case "BUSCARDETALLE":
			uf_limpiarvariables();
			$ls_cmpmov = $_POST["txtcmpmov"];
			$ls_numcmp = $_POST["txtnumcmp"];
			$ls_codcau = $_POST["txtcodcau"];
			$ls_dencau = $_POST["txtdencau"];
			$ld_feccmp = $_POST["txtfeccmp"];
			$ls_descmp = $_POST["txtdescmp"];
			$ls_estpromov = $_POST["hidestpromov"];
			$ls_status = $_POST["hidstatus"];
			$ls_codrespri = $_POST["txtcodrespri"];
			$ls_denrespri = $_POST["txtdenrespri"];
			$ls_codubifisresuso = $_POST["txtcoduni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_desubifisresuso = $_POST["txtdenuni"]; //VARIABLE AGREGADA PARA LA UBICACI? FISICA DEL ACTIVO
			$ls_codresuso = $_POST["txtcodresuso"];
			$ls_denresuso = $_POST["txtdenresuso"];
			$ls_coduniadm = $_POST["txtcoduniadm"];
			$ls_denuniadm = $_POST["txtdenuniadm"];
			$ls_ubigeo = $_POST["txtubigeo"];
			$ls_fecent=$_POST["txtfecent"];
			$ld_feccmpbd=$io_fun->uf_convertirdatetobd($ld_feccmp);
			$li_montot="";

			$lb_valido=$io_saf->uf_siv_load_dt_movimiento($ls_codemp,$ls_cmpmov,$ld_feccmpbd,$li_totrows,$lo_object,$li_montot);
		break;
	}
?>

<div class="container">
	<h1 class="titulo">Incorporaciones</h1>
	<div class="formato-blanco">
		<form id="sigesp_saf_p_incorporaciones.php" name="form1" method="post" action="" class="form-horizontal">
			<?php
			//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
			$io_fun_activo->uf_print_permisos($ls_permisos,$la_permisos,$ls_logusr,"location.href='sigespwindow_blank.php'");
			unset($io_fun_activo);
			//////////////////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////
			?>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-9" for="">Fecha</label>
				<div class="col-md-3">
					<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
						<input name="txtfeccmp" type="" id="txtfeccmp" style="text-align:center" class="form-control" value="<?php print $ld_feccmp ?>">
						<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-9" for="">Comprobante</label>
				<div class="col-md-3">
					<input name="txtnumcmp" type="text" id="txtnumcmp" class="form-control" style="text-align:center" value="<?php print $ls_numcmp ?>" readonly>
				</div>
			</div>
			<input name="hidstatus" type="hidden" id="hidstatus" value="<?php print $ls_status ?>">
			<input name="txtcmpmov" type="hidden"   id="txtcmpmov" value="<?php print $ls_cmpmov ?>" size="20" maxlength="15" onBlur="javascript: ue_rellenarcampo(this,'15')" style="text-align:center " readonly>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Causa de Movimiento</label>
				<div class="col-md-9">
					<!-- <input name="txtcodcau" type="text" id="txtcodcau" value="<?php print $ls_codcau ?>" size="10" style="text-align:center " readonly> -->
					<select name="txtcodcau" id="txtcodcau" class="form-control">
						<?php echo $io_saf->uf_select_causa_movimiento_incorporacion($ls_codcau); ?>
					</select>
				</div>
			</div>
			<!-- <input name="txtdencau" type="text" class="sin-borde" id="txtdencau" value="<?php print $ls_dencau ?>" size="50" readonly> -->


			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Responsable Primario/Administrativo</label>
				<div class="col-md-3">
					<select name="cmbtiprespri" id="cmbtiprespri" class="form-control" onChange="javascript: ue_catalogo_responsable_primario();">
						<option value="-" selected>Seleccione</option>
						<option value="P" <?php if($ls_tiprespri=="P"){ print "selected";} ?>>PERSONAL</option>
						<option value="B" <?php if($ls_tiprespri=="B"){ print "selected";} ?>>BENEFICIARIO</option>
					</select>
				</div>
				<div class="col-md-3">
					<input name="txtcodrespri" type="text" class="form-control" style="text-align:center" id="txtcodrespri" value="<?php print $ls_codrespri; ?>" readonly>
				</div>
				<div class="col-md-3">
					<input name="txtdenrespri" type="text" class="form-control" style="text-align:center" id="txtdenrespri" value="<?php print $ls_denrespri; ?>" readonly>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Responsable de Uso</label>
				<div class="col-md-3">
					<select name="cmbtipresuso" id="cmbtipresuso" class="form-control" onChange="javascript: ue_catalogo_responsable_uso();">
						<option value="-" selected>Seleccione</option>
						<option value="P" <?php if($ls_tipresuso=="P"){ print "selected";} ?>>PERSONAL</option>
						<option value="B" <?php if($ls_tipresuso=="B"){ print "selected";} ?>>BENEFICIARIO</option>
					</select>
				</div>
				<div class="col-md-3">
					<input name="txtcodresuso" type="text" class="form-control" style="text-align:center" id="txtcodresuso" value="<?php print $ls_codresuso; ?>" readonly>
				</div>
				<div class="col-md-3">
					<input name="txtdenresuso" type="text" class="form-control" style="text-align:center"  id="txtdenresuso" value="<?php print $ls_denresuso; ?>" readonly></td>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Ubicaci&oacute;n F&iacute;sica</label>
				<div class="col-md-9">
					<!-- <input name="txtcoduni" type="text" id="txtcoduni" value="<?php print $ls_codubifisresuso; ?>" size="12" maxlength="15"> -->
					<select name="txtcoduni" id="txtcoduni" class="form-control">
						<?php echo $io_unidadfisica->uf_list_unidadAdministrativa($ls_codubifisresuso); ?>
					</select>
				</div>
			</div>
			<!-- <input name="txtdenuni" type="text" id="txtdenuni" value="<?php print $ls_desubifisresuso; ?>" size="57" maxlength="60"> -->

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Ubicacion Organizacional</label>
				<div class="col-md-9">
					<!-- <input name="txtcoduniadm" type="text" id="txtcoduniadm" class="form-control" value="<?php print $ls_coduniadm; ?>" readonly> -->
					<select class="form-control" id="txtcoduniadmid" name="txtcoduniadm" aria-describedby="helpUbiOrg">
						<?php echo $io_saf_dta->uf_list_catalogo_unidad_ejecutora($ls_coduniadm); ?>
					</select>
					<span id="helpUbiOrg" class="help-block">Cat&aacute;logo de Unidad Ejecutora.</span>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Fecha de la Entrega</label>
				<div class="col-md-3">
					<div class="input-group date form_date" data-date="" data-date-format="dd/mm/yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
						<input name="txtfecent" type="" id="txtfecent" class="form-control" value="<?php print $ls_fecent; ?>">
						<span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Ubicacion Geogr&aacute;fica</label>
				<div class="col-md-9">
					<textarea name="txtubigeo" id="txtubigeo" class="form-control" onKeyUp="javascript: ue_validarcomillas(this)" onBlur="javascript: ue_validarcomillas(this)"><?php print $ls_ubigeo; ?></textarea>
				</div>
			</div>

			<div class="form-group form-group-sm">
				<label class="control-label col-md-3" for="">Observaciones</label>
				<div class="col-md-9">
					<textarea name="txtdescmp" id="txtdescmp" class="form-control" onKeyUp="javascript: ue_validarcomillas(this)" onBlur="javascript: ue_validarcomillas(this)"><?php print $ls_descmp ?></textarea>
				</div>
			</div>
			<input name="hidestpromov" type="hidden" id="hidestpromov" value="<?php print $ls_estpromov ?>">

			<a href="javascript: ue_agregardetalle();">
				<img src="../shared/imagebank/tools/nuevo.gif" width="20" height="20" class="sin-borde">
				<span class="h5">Agregar Activo</span>
			</a>

			<?php echo $in_grid->makegrid2($li_totrows,$lo_title,$lo_object,$li_widthtable,$ls_titletable,$ls_nametable);  ?>

			<input name="operacion"  type="hidden" id="operacion">
			<input name="totalfilas" type="hidden" id="totalfilas" value="<?php print $li_totrows;?>">
			<input name="filadelete" type="hidden" id="filadelete">
		</form>
	</div>
</div>


</body>

	<!-- <script language="javascript" src="../shared/js/js_intra/datepickercontrol.js"></script> -->
	<script type="text/javascript" src="../shared/js/jquery-2.1.4.min.js" charset="UTF-8"></script>
	<script type="text/javascript" src="../shared/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../shared/datepicker/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="js/sigesp_saf_p_incorporaciones.js"></script>
</html>
