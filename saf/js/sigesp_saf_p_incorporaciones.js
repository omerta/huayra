//Funciones de operaciones
$(document).ajaxStart(function () {
	$('#mensaje_espera_texto').show();
	$(document.body).css({'cursor' : 'wait'});
}).ajaxStop(function () {
	$('#mensaje_espera_texto').hide();
	$(document.body).css({'cursor' : 'default'});
});

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
   	{
		window.open("sigesp_saf_cat_incorporaciones.php?tipo=incorporacion","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_catalogo_responsable_primario()
{
	f=document.form1;
	tipresuso=f.cmbtiprespri.value;
	if(tipresuso=='P')
	{
		window.open("sigesp_saf_cat_personal.php?destino=repasignadospri","_blank","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
    }
	else if(tipresuso=='B')
	{
		window.open("sigesp_saf_cat_beneficiario.php","_blank","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
	}
}

function ue_catalogo_responsable_uso()
{
	f=document.form1;
	tipresuso=f.cmbtipresuso.value;
	if(tipresuso=='P')
	{
		window.open("sigesp_saf_cat_personal.php?destino=repasignadosuso","_blank","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
    }
	else if(tipresuso=='B')
	{
		window.open("sigesp_saf_cat_beneficiario.php?destino=responsableuso","_blank","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
	}
}

function ue_catalogo_unidad_administrativa()
{
	f=document.form1;
	window.open("sigesp_saf_cat_unidadejecutora.php?destino=activo","_blank","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
    //f.txtubigeo.disabled=true;
}

function ue_catalogo_ubicacion_fisica()
{
	f=document.form1;
	window.open("sigesp_saf_cat_unidadejecutora.php?destino=activo","_blank","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
    //f.txtubigeo.disabled=true;
}




function ue_agregardetalle()
{
	f=document.form1;
	ls_cmpmov=f.txtcmpmov.value;
	if(ls_cmpmov === "")
	{
		alert("Debe existir un numero de comprobante");
	}
	else
	{
		// li_totrow=f.totalfilas.value;
		// window.open("sigesp_saf_pdt_activo.php?totrow="+ li_totrow +"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=260,left=50,top=50,location=no,resizable=yes");
		ls_estact="RD";
		window.open("sigesp_saf_cat_codactivo.php?estact="+ls_estact+"","_blank","menubar=no,toolbar=no,scrollbars=yes,width=790,height=400,left=50,top=50,location=no,resizable=yes");

	}
}

function ue_catacausas()
{
	tipo="I";
	window.open("sigesp_saf_cat_causasmovimiento.php?tipo="+tipo+"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
}

function ue_nuevo()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{
		f.operacion.value="NUEVO";
		f.action="sigesp_saf_p_incorporaciones.php";
		f.submit();
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_guardar()
{
	f=document.form1;
	ls_status=f.hidstatus.value;
	li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	li_respri=f.txtcodrespri.value; // AGREGADA POR JOSE LUIS AGUILERA
	li_ressuso=f.txtcodresuso.value; // AGREGADA POR JOSE LUIS AGUILERA
	li_unidadadministrativa=f.txtcoduniadm.value; // AGREGADA POR JOSE LUIS AGUILERA
	// MODIFICACIÓN: JOSE LUIS AGUILERA OPSU - CTSI
	if (li_respri=='' && li_ressuso=='' && li_unidadadministrativa=='')
	{
		alert("Debe especificar al menos un Responsable del activo o la Ubicacion Organizacional");
	}
	else //1
	{
		if(li_ressuso=='')
		{
			alert("El campo RESPONSABLE DE USO NO puede estar vacio");
		}
		else //2
		{

			if(((ls_status=="C")&&(li_cambiar==1))||(ls_status=="")&&(li_incluir==1))
			{
				if(ls_status!="C")
				{
					f.operacion.value="GUARDAR";
					f.action="sigesp_saf_p_incorporaciones.php";
					f.submit();
				}
				else
				{alert("Este documento no debe ser modificado");}
			}
			else
		   	{
		 		alert("No tiene permiso para realizar esta operacion");
		   	}
		} //end else 2
	}// end else 1
}// end funtion ue_guardar()

/*function ue_procesar()
{
	f=document.form1;
	li_ejecutar=f.ejecutar.value;
	if(li_ejecutar==1)
	{
		f.operacion.value="PROCESAR";
		f.action="sigesp_saf_p_incorporaciones.php";
		f.submit();
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_reversar()
{
	f=document.form1;
	li_ejecutar=f.ejecutar.value;
	if(li_ejecutar==1)
	{
		f.operacion.value="REVERSAR";
		f.action="sigesp_saf_p_incorporaciones.php";
		f.submit();
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}*/

function uf_delete_dt(li_row)
{
	f=document.form1;
	li_fila=f.totalfilas.value;
	if(li_fila!=li_row)
	{
		if(confirm("�Desea eliminar el Registro actual?"))
		{
			f.filadelete.value=li_row;
			f.operacion.value="ELIMINARDETALLE"
			f.action="sigesp_saf_p_incorporaciones.php";
			f.submit();
		}
	}
}


function ue_eliminar()
{
	f=document.form1;
	li_eliminar=f.eliminar.value;
	if(li_eliminar==1)
	{
		if(confirm("�Seguro desea eliminar el Registro?"))
		{
			f=document.form1;
			f.operacion.value="ELIMINAR";
			f.action="sigesp_saf_p_incorporaciones.php";
			f.submit();
		}
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_imprimir()
{
	f = document.form1;
	ls_status = f.hidstatus.value;
	ls_cmpmov = f.txtcmpmov.value;
	li_imprimir = f.imprimir.value;
	if(ls_status=="C")
	{
		if (li_imprimir==1)
		{
			window.open("reportes/sigesp_saf_rfs_incorporacion.php?cmpmov="+ls_cmpmov,"catalogo","menubar=no,toolbar=no,scrollbars=yes,width=800,height=600,left=0,top=0,location=no,resizable=yes");
		}
		else
		{
			alert("No tiene permiso para realizar esta operacion");
		}
	}
	else
	{
		alert("Seleccione un documento a imprimir");
	}
}

function ue_cerrar()
{
	window.location.href="sigespwindow_blank.php";
}

//--------------------------------------------------------
//	Funci�n que coloca los separadores (/) de las fechas
//--------------------------------------------------------
var patron = new Array(2,2,4)
var patron2 = new Array(1,3,3,3,3)
function ue_separadores(d,sep,pat,nums)
{
	if(d.valant != d.value)
	{
		val = d.value
		largo = val.length
		val = val.split(sep)
		val2 = ''
		for(r=0;r<val.length;r++){
			val2 += val[r]
		}
		if(nums){
			for(z=0;z<val2.length;z++){
				if(isNaN(val2.charAt(z))){
					letra = new RegExp(val2.charAt(z),"g")
					val2 = val2.replace(letra,"")
				}
			}
		}
		val = ''
		val3 = new Array()
		for(s=0; s<pat.length; s++){
			val3[s] = val2.substring(0,pat[s])
			val2 = val2.substr(pat[s])
		}
		for(q=0;q<val3.length; q++){
			if(q ==0){
				val = val3[q]
			}
			else{
				if(val3[q] != ""){
					val += sep + val3[q]
					}
			}
		}
	d.value = val
	d.valant = val
	}
}
function ue_validarcomillas(valor)
{
	val = valor.value;
	longitud = val.length;
	texto = "";
	textocompleto = "";
	for(r=0;r<=longitud;r++)
	{
		texto = valor.value.substring(r,r+1);
		if((texto != "'")&&(texto != '"'))
		{
			textocompleto += texto;
		}
	}
	valor.value=textocompleto;
}
function uf_unidad()
{
	ls_destino="activo";
	window.open("sigesp_saf_cat_unidadfisica.php?destino="+ ls_destino +"","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=580,height=400,left=120,top=70,location=no,resizable=yes");
}

function ue_ayuda()
{
	window.open("/doc/saf/sigesp_saf_p_incorporaciones.md","fullscreen=yes,menubar=no,toobar=no,scrollbars=yes");
}

$( document ).ready(function() {
  $('.form_date').datetimepicker({
      language:  'fr',
      weekStart: 1,
      todayBtn:  1,
  autoclose: 1,
  todayHighlight: 1,
  startView: 2,
  minView: 2,
  forceParse: 0
  });
});
