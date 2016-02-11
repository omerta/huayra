<?php
//print_r($_POST);
session_start();
require_once("class_funciones_activos.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Datos de las Marcas de los Bienes Muebles</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../shared/css/ventanas.css" rel="stylesheet" type="text/css">
<link href="../shared/css/general.css" rel="stylesheet" type="text/css">
<link href="../shared/css/tablas.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="bootstrap-3.3.4/css/bootstrap.min.css">

</head>

<body>
<h1 class="titulo-celda">Datos de las Marcas de los Bienes Muebles</h1>

<form name="form1" id="list_marcas" method="post" action="" class="form-horizontal">
    <div class="form-group">
        <label class="col-md-6 control-label" for="">Código de la marca</label>
		<div class="col-md-6">
			<input type="text" class="form-control input-sm" name="codigomarca"  id="codigomarcaid">
		</div>
    </div>        
    <div class="pull-right">
    	<button type="submit" id="btnbuscar" class="btn btn-primary">Buscar</button>
	</div>
	<br>
	<br>
</form>

<?php
require_once("../shared/class_folder/sigesp_include.php");
$in=new sigesp_include();
$con=$in->uf_conectar();

require_once("../shared/class_folder/class_sql.php");
$io_sql= new class_sql($con);

require_once("../shared/class_folder/class_mensajes.php");
$io_msg= new class_mensajes();

$ls_codmarca = $_POST["codigomarca"];

print "<table width=550 border=0 cellpadding=1 cellspacing=1 class=fondo-tabla align=center>";
print "<tr class=titulo-celda>";
print "<td width='50'>Codigo</td>";
print "<td width='100'>Denominacion Marca</td>";
print "<td width='100'>Nombre Fabricante</td>";
print "</tr>";

if($ls_codmarca!="")
{
	/* DB */ 
	$ls_sql="SELECT id_marca,denominacion_marca,nombre_fabricante FROM saf_sudebip_marcas_bienes_muebles WHERE id_marca = '".$ls_codmarca."'";
	$rs_cta=$io_sql->select($ls_sql);
} 
else 
{
	$ls_sql="SELECT id_marca,denominacion_marca,nombre_fabricante FROM saf_sudebip_marcas_bienes_muebles ORDER BY id_marca ASC LIMIT 12";
	$rs_cta=$io_sql->select($ls_sql);	
}

	$li_numrows = $io_sql->num_rows($rs_cta);
	if($li_numrows>0)
	{
		while($row=$io_sql->fetch_row($rs_cta))
		{
			print "<tr class=celdas-blancas>";
			$ls_codmarca = $row["id_marca"];
			$ls_denmarca = $row["denominacion_marca"];
			$ls_nomfabricante = $row["nombre_fabricante"];
			print "<td><a href=\"javascript: aceptar('$ls_codmarca','$ls_denmarca','$ls_nomfabricante');\">".$ls_codmarca."</a></td>";
			print "<td>".$ls_denmarca."</td>";
			print "<td>".$ls_nomfabricante."</td>";
			print "</tr>";			
		}
	}
	else
	{
		$io_msg->message("No se encontraron registros");
	}
print "</table>";
?>
</body>

<script language="JavaScript">
  function aceptar(ls_codmarca,ls_denmarca,ls_nomfabricante)
  {
	f=document.form1;
	opener.document.form1.codmarcaid.value=ls_codmarca;
    opener.document.form1.denominacioncomercialid.value = ls_denmarca;
    opener.document.form1.nombrefabricanteid.value = ls_nomfabricante;
    opener.document.form1.hidstatus.value="G";
    /* @TODO opener.getElementById('othersomenid').style.display = "none";  */
    /* http://www.webdeveloper.com/forum/showthread.php?138803-RESOLVED-window-opener-document-quot-nameForm-quot-getElementById%28-quot-someid-quot-%29-value-doesnt-work */
	successblock=opener.document.getElementById("save_success_block");
	successblock.style.display = "none";
    errorblock=opener.document.getElementById("save_error_block");
    errorblock.style.display = "none";
    deletesuccessblock=opener.document.getElementById("delete_success_block");
    deletesuccessblock.style.display = "none";
    deleteerrorblock=opener.document.getElementById("delete_error_block");
    deleteerrorblock.style.display = "none";
    deleteerrorblock=opener.document.getElementById("new_error_block");
    deleteerrorblock.style.display = "none";
	close();
  }
  
  function validateEmpty(id)
  {
  	if($("#"+id).val() == null || $("#"+id).val() == "")
  	{
  		var div = $("#"+id).closest("div");
  		div.addClass("has-error");
  		return false;
  	}
  	else
  	{
  		var div = $("#"+id).closest("div");
  		div.removeClass("has-error");
  		return true;
  	}
  }

  $(document).ready(
  	function()
  	{
  		$("#btnbuscar").click(function()
  			{
  				if(!validateEmpty("codigomarcaid"))
  				{
  					return false;
  				}
  				$("form#list_marcas").submit;
  			});
  	});
</script>

</html>
