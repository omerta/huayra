<?php
session_start();
if(array_key_exists("destino",$_GET))
{
    $ls_destino=$_GET["destino"];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Cat&aacute;logo de Sedes </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="">
  <p align="center">
    <input name="operacion" type="hidden" id="operacion">
    <input name="txtempresa" type="hidden" id="txtempresa">
    <input name="hidstatus" type="hidden" id="hidstatus">
    <input name="txtnombrevie" type="hidden" id="txtnombrevie">
</p>
  <table width="650" border="0" align="center" cellpadding="1" cellspacing="1">
    <tr>
      <td width="496" colspan="2" class="titulo-celda">Cat&aacute;logo de Sedes</td>
    </tr>
  </table>
<br>
    <table width="650" border="0" cellpadding="0" cellspacing="0" class="formato-blanco" align="center">
      <!-- C�digo  -->
      <tr>
        <td width="67">
        	<div align="right">C&oacute;digo</div>
        </td>
        <td width="431" height="22">
        	<div align="left">
          	<input name="txtcodigo" type="text" id="txtnombre2">
        </div>
        </td>
      </tr>
      <!-- Denominaci�n  -->
      <tr>
        <td><div align="right">Denominaci&oacute;n</div></td>
        <td height="22"><div align="left">
                <input id="txtdenominacion" name="txtdenominacion" type="text" >
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="right"><a href="javascript:ue_search();"><img src="../shared/imagebank/tools15/buscar.gif" alt="Buscar" width="15" height="15" border="0">Buscar</a></div></td>
      </tr>
    </table>
  <br>

<?php
//print_r($_POST);
require_once("../shared/class_folder/sigesp_include.php");
$in=new sigesp_include();
$con=$in->uf_conectar();
require_once("../shared/class_folder/class_mensajes.php");
$io_msg=new class_mensajes();
require_once("../shared/class_folder/class_datastore.php");
$ds=new class_datastore();
require_once("../shared/class_folder/class_sql.php");
$io_sql=new class_sql($con);

$arr=$_SESSION["la_empresa"];

if(array_key_exists("operacion",$_POST))
{
	$ls_operacion=$_POST["operacion"];
	$ls_codigo="%".$_POST["txtcodigo"]."%";
	$ls_denominacion="%".$_POST["txtdenominacion"]."%";
	$ls_status="%".$_POST["hidstatus"]."%";
}
else
{
	$ls_operacion="BUSCAR";
	$ls_codigo="%%";
	$ls_denominacion="%%";
	$ls_status="%%";
}
print "<table width=500 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
print "<tr class=titulo-celda>";
//print "<td>Empresa </td>";
print "<td>C�digo</td>";
print "<td>Denominaci�n</td>";
print "</tr>";
/**
 * $totrow	n�mero de registros
 * $totcol	n�mero de columnas
 * $arrcols	nombre de las columnas en la tabla
 */
if($ls_operacion=="BUSCAR" || $ls_operacion=="")
{
	$ls_sql="SELECT * FROM sudebip_sedes_similares".
			" WHERE codigo_sede ilike '".$ls_codigo."'".
			"   AND descripcion ilike '".$ls_denominacion."'".
			" ORDER BY codigo_sede";
    $rs_cta=$io_sql->select($ls_sql);
    $data=$rs_cta;
	if($row=$io_sql->fetch_row($rs_cta))
	{
		$data=$io_sql->obtener_datos($rs_cta);
		$arrcols=array_keys($data);
		$totcol=count($arrcols);
		$ds->data=$data;

		$totrow=$ds->getRowCount("codigo_sede");
		for($z=1;$z<=$totrow;$z++)
		{
			print "<tr class=celdas-blancas>";
            $ls_codemp=$data["codemp"][$z];
			$ls_codigo=$data["codigo_sede"][$z];
			$ls_denominacion=$data["descripcion"][$z];
			$ls_tipsede=$data["codigo_tipo_sede"][$z];
			$ls_localizacion=$data["localizacion_sede"][$z];
			$ls_codpais=$data["codigo_pais"][$z];
			$ls_codestado=$data["codigo_estado"][$z];
			$ls_codmunicipio=$data["codigo_municipio"][$z];
			$ls_ciudad=$data["codigo_ciudad"][$z];
			$ls_codparroquia=$data["codigo_parroquia"][$z];
			$ls_urbanizacion=$data["urbanizacion"][$z];
			$ls_casa=$data["casa"][$z];
			$ls_calle=$data["calle"][$z];
            $ls_piso=$data["piso"][$z];
			print "<td><a href=\"javascript:aceptar('$ls_codemp','$ls_codigo','$ls_denominacion','$ls_tipsede','$ls_localizacion',
													'$ls_codpais','$ls_codestado','$ls_codmunicipio','$ls_ciudad','$ls_codparroquia',
													'$ls_urbanizacion','$ls_casa','$ls_calle','$ls_piso','$ls_destino');\">".$ls_codigo."</a></td>";
			//print "<td>".$data["NomGru"][$z]."</td>";
			print "<td>".$data["descripcion"][$z]."</td>";
			print "</tr>";
		}
	}
}
print "</table>";
?>
</div>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
<script language="JavaScript">
  function aceptar(codemp,codsede,denominacion,tipsede,localizacion,codpais,codestado,codmunicipio,codciudad,codparroquia,urbanizacion,casa,calle,piso,destino)
  {
      if (destino=="sede"){
		opener.document.formulario.txtcodsede.value=codsede;
		opener.document.formulario.txtdenrot.value=denominacion;
		opener.document.formulario.cmbtiposede.value=tipsede;
		opener.document.formulario.hidtiposede.value=tipsede;
        opener.document.formulario.cmbtipolocalizacion.value=localizacion;
        opener.document.formulario.cmbpais.value=codpais;
        opener.document.formulario.hidpais.value=codpais;
        opener.document.formulario.cmbestado.value=codestado;
        opener.document.formulario.hidestado.value=codestado;
        opener.document.formulario.cmbmunicipio.value=codmunicipio;
        opener.document.formulario.hidmunicipio.value=codmunicipio;
        opener.document.formulario.cmbciudad.value=codciudad;
        opener.document.formulario.hidciudad.value=codciudad;
        opener.document.formulario.cmbparroquia.value=codparroquia;
        opener.document.formulario.hidparroquia.value=codparroquia;
        opener.document.formulario.txturbanizacion.value=urbanizacion;
        opener.document.formulario.txtcalle.value=casa;
        opener.document.formulario.txtcasa.value=calle;
        opener.document.formulario.txtpiso.value=piso;
        opener.document.formulario.hidstatus.value="C";
        //window.opener.formulario.submit();
    }else{
        opener.document.formulario.txtcodsede.value=codsede;
        opener.document.formulario.txtdenrot.value=denominacion;
    }
    close();
  }
  function ue_search()
  {
  f=document.form1;
  f.operacion.value="BUSCAR";
  f.action="sigesp_saf_cat_sedes.php";
  f.submit();
  }

</script>
</html>
