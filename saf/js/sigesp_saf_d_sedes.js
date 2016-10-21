/**
 * la variable $ls_operacion es colocada en NUEVO
 * la pagina es cargada
 */
function ue_nuevo()
{
    f = document.formulario;
    li_incluir = f.incluir.value;
    document.getElementById("hidstatus").value="";
    if (li_incluir == 1)
    {
        f.operacion.value = "NUEVO";
        f.action = "sigesp_saf_d_sedes.php";
        f.submit();
    }
    else
    {
        alert("No tiene permiso para realizar esta operacion");
    }
}

function ue_buscar()
{
    f = document.formulario;
    li_leer = f.leer.value;
    if (li_leer == 1)
    {
        window.open("sigesp_saf_cat_sedes.php?destino=sede", "catalogo", "menubar=no,toolbar=no,scrollbars=yes,width=750,height=400,left=250,top=350,location=no,resizable=yes");
    }
    else
    {
        alert("No tiene permiso para realizar esta operacion");
    }
}

function ue_cerrar()
{
    window.location.href = "sigespwindow_blank.php";
}

function ue_guardar()
{
    f = document.formulario;
    li_incluir = f.incluir.value;
    li_cambiar = f.cambiar.value;
    lb_status = f.hidstatus.value;
    if (((lb_status == "C") && (li_cambiar == 1)) || (lb_status == "") && (li_incluir == 1))
    {
        f.operacion.value = "GUARDAR";
        f.action = "sigesp_saf_d_sedes.php";
        f.submit();
    }
    else
    {
        alert("No tiene permiso para realizar esta operacion");
    }
}

function ue_eliminar()
{
    f = document.formulario;
    li_eliminar = f.eliminar.value;
    var li_codsede = f.txtcodsede.value;
    if (li_codsede == "")
    	{
    	alert("No hay nada que eliminar");
    	}
    else {
    	if (li_eliminar == 1)
        {
            if (confirm("\xBFSeguro desea eliminar el Registro?"))
            {
                f.operacion.value = "ELIMINAR";
                f.action = "sigesp_saf_d_sedes.php";
                f.submit();
            }
        }
        else
        {
            alert("No tiene permiso para realizar esta operacion");
        }
    }
}

function uf_cambiopais()
{
    var f = document.formulario;
    f.action = "sigesp_saf_d_sedes.php";
    f.operacion.value = "pais";
    f.submit();
}

function uf_exportestado()
{
    var f = document.formulario;
    f.action = "sigesp_saf_d_sedes.php";
//    var test = f.hidestado.value=f.cmbestado.value //debug
//    alert(test);
    f.hidestado.value=f.cmbestado.value
    f.operacion.value = "estado";
    f.submit();
}

function uf_exportmunicipio()
{
     var f = document.formulario;
     f.action = "sigesp_saf_d_sedes.php";
     f.hidestado.value=f.cmbestado.value
     f.hidmunicipio.value=f.cmbmunicipio.value
     f.operacion.value = "municipio";
     f.submit();
}

function uf_exportciudad()
{
	var f = document.formulario;
	f.action = "sigesp_saf_d_sedes.php";
	f.hidciudad.value=f.cmbciudad.value
	f.operacion.value = "ciudad";
	f.submit();
}

function uf_exportparroquia()
{
	var f = document.formulario;
	f.action = "sigesp_saf_d_sedes.php";
	f.hidparroquia.value=f.cmbparroquia.value
	f.operacion.value = "parroquia";
	f.submit();
}
