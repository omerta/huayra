function ue_cargarcamposmetodo()
{
	f=document.form1;
	f.operacion.value="CARGARMETODO";
	f.action="sigesp_snorh_d_metodobanco.php";
	f.submit();
}

function ue_nuevo()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{
		f.operacion.value="NUEVO";
		f.existe.value="FALSE";
		f.action="sigesp_snorh_d_metodobanco.php";
		f.submit();
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operaci\u00F3n");
   	}
}

function ue_guardar()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_existe=f.existe.value;
	if(((lb_existe=="TRUE")&&(li_cambiar==1))||(lb_existe=="FALSE")&&(li_incluir==1))
	{
		codmet = ue_validarvacio(f.txtcodmet.value);
		desmet = ue_validarvacio(f.txtdesmet.value);
		//tipmet = ue_validarvacio(f.txttipmet.value);
		tipmet = ue_validarvacio(f.radiotipmet.value);
		if ((codmet!="")&&(desmet!="")&&(tipmet!=""))
		{
			f.operacion.value="GUARDAR";
			f.action="sigesp_snorh_d_metodobanco.php";
			f.submit();
		}
		else
		{
			alert("Debe llenar todos los datos.");
		}
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operaci\u00F3n");
   	}
}

function ue_eliminar()
{
	f=document.form1;
	li_eliminar=f.eliminar.value;
	if(li_eliminar==1)
	{
		codmet = ue_validarvacio(f.txtcodmet.value);
		tipmet = ue_validarvacio(f.cmbtipmet.value);
		if ((codmet!="")&&(tipmet!=""))
		{
			if(confirm("\u00BFDesea eliminar el Registro actual?"))
			{
				f.operacion.value="ELIMINAR";
				f.action="sigesp_snorh_d_metodobanco.php";
				f.submit();
			}
		}
		else
		{
			alert("Debe buscar el registro a eliminar.");
		}
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operaci\u00F3n");
   	}
}

function ue_cerrar()
{
	location.href = "sigespwindow_blank.php";
}

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
   	{
		window.open("sigesp_snorh_cat_metodobanco.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=530,height=400,left=50,top=50,location=no,resizable=no");
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operaci\u00F3n");
   	}
}

function ue_ayuda()
{
	window.open("/doc/sno/sigesp_snorh_d_metodobanco.md","fullscreen=yes,menubar=no,toolbar=no,scrollbars=yes");
}

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($(this).attr("value")=="0"){
            $(".box").not(".nomina").hide();
            $(".nomina").show();//nomina
        }
        if($(this).attr("value")=="1"){
            $(".box").not(".politica").hide();
            $(".politica").show();//politica
        }
        if($(this).attr("value")=="2"){
            $(".box").not(".prestaciones").hide();
            $(".prestaciones").show();//prestaciones
        }
    });
});
