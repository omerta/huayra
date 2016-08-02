function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
 	{
		window.open("sigesp_saf_cat_rotulacion.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
 	}
	else
 	{
 		alert("No tiene permiso para realizar esta operacion");
 	}
}

function ue_cata()
{
	window.open("sigesp_catdinamic_empresas.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
}

function ue_nuevo()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{
		$.post("sigesp_saf_puente_rotulacion.php",
						{newstatus:"NEW"},null,"json")
				.done(function(data)
				{
					if (data[0] == false)
					{
						/* es posible que esten 'show' alguno de los bloques de error */
						/* id de las etiquetas html */
						$("#delete_error_block").hide( "slow" );
						$("#delete_success_block").hide( "slow" );
						$("#save_success_block").hide( "slow" );
						$("#save_error_block").hide( "slow" );
						$("#new_error_block").hide( "slow" );
						$("#new_error_block_detail").hide( "slow" );
						/* mostramos el error correspondiente */
						$("#new_error_block").show( "slow" );
						$("#new_error_block_detail").show( "slow" );
						//$("#new_error_block_detail").children('div').append('<strong>' + data[1] + '</strong> ');
						$("#new_error_block_detail").children('div').html('<strong>' + data[1] + '</strong> ');
						$("#txtnombre").val('')
					}else if(data[0] == true)
					{
						$("#delete_error_block").hide( "slow" );
						$("#delete_success_block").hide( "slow" );
						$("#save_success_block").hide( "slow" );
						$("#save_error_block").hide( "slow" );
						$("#new_error_block").hide( "slow" );
						$("#new_error_block_detail").hide( "slow" );
						$("#required_error_block").hide("slow");
						$("#warning_success_block").hide("slow");
						$("#txtnombre").val(data[1]);
						$("#txtdenrot").val('');
						$("#txtempleo").val('');
						$("#operacion").val(''); // bandera que indica una modificación del formulario
					}
				});
		   	}
			else
		   	{
		 		alert("No tiene permiso para realizar esta operacion");
		   	}
}

function ue_check_fields()
{
	var ToReturn;
	var fields = $("#form1").find("select, textarea, input").filter('[required]:visible').serializeArray();
	$.each(fields, function(i, field) {
		if (!field.value)
	  	{
			console.log(field.name);
			var label = $('#' + field.name).parent().prev("label").html();
			$("#required_error_block").children('div.sub_required_error_block').append('<strong>"' + label + '"</strong> ');
			ToReturn = true;
		}
	});
	return ToReturn;
}

function ue_guardar()
{
	$("#required_error_block").hide( "slow" );
	$("#required_error_block").children('div.sub_required_error_block').html("");

	f=document.form1;
	li_incluir=f.incluir.value;
	li_cambiar=f.cambiar.value;
	lb_status=f.operacion.value;

	if(((lb_status=="G")&&(li_cambiar==1))||(lb_status=="")&&(li_incluir==1))
	{
		/* atrinuto name de la etiqueta input */
		li_txtcodrot=f.txtcodrot.value;
		li_txtdenrot=f.txtdenrot.value;
		li_txtempleo= f.txtempleo.value;
		/* insert/update */
		if(!ue_check_fields())
		{
			if(lb_status=="")
			{
					$.post("sigesp_saf_puente_rotulacion.php",
							{codigo:li_txtcodrot,denominacion:li_txtdenrot,
							 empleo:li_txtempleo,status:lb_status},null,"json")
					.done(function(data)
					{
						if (data[0] == false)
						{
							/* */
							$("#delete_error_block").hide( "slow" );
							$("#delete_success_block").hide( "slow" );
							$("#save_success_block").hide( "slow" );
							$("#save_error_block").hide( "slow" );
							$("#new_error_block").hide( "slow" );
							/* */
							$("#save_error_block").show( "slow" );
							$("#new_error_block_detail").show( "slow" );
							//$("#new_error_block_detail").children('div').append('<strong>' + data[1] + '</strong> ');
							$("#new_error_block_detail").children('div').html('<strong>' + data[1] + '</strong> ');
						}else if(data[0] == true)
						{
							$("#delete_error_block").hide( "slow" );
							$("#delete_success_block").hide( "slow" );
							$("#save_success_block").show( "slow" );
							$("#new_error_block_detail").hide( "slow" );
							$("#save_error_block").hide( "slow" );
							$("#operacion").val('G'); // bandera que indica una modificación del formulario
							if(data[1] != "")
							{
								$("#warning_success_block").show( "slow" );
								//$("#new_error_block_detail").children('div').append('<strong>' + data[1] + '</strong> ');
								$("#warning_success_block").children('div').html('<strong>' + data[1] + '</strong> ');
							}
						}
					});
			} // G indica que es un modificación del formulario
			else if(lb_status=="G")
			{
					$.post("sigesp_saf_puente_rotulacion.php",
							{codigo:li_txtcodrot,denominacion:li_txtdenrot,
							 empleo:li_txtempleo,status:lb_status})
					.done(function(data)
					{
						if (data == false)
						{
							$("#delete_error_block").hide( "slow" );
							$("#delete_success_block").hide( "slow" );
							$("#save_success_block").hide( "slow" );
							$("#save_error_block").hide( "slow" );
							$("#new_error_block").hide( "slow" );
							/**/
							$("#error_block").show( "slow" );
						}else if(data == true)
						{
							$("#delete_error_block").hide( "slow" );
							$("#delete_success_block").hide( "slow" );
							$("#save_error_block").hide( "slow" );
							$("#save_success_block").hide( "slow" );
							$("#new_error_block").hide( "slow" );
							/**/
							$("#save_success_block").show( "slow" );
						}
					});
			}
		}else
			{
			$("#required_error_block").show( "slow" );
			}
		}
	else
		{
		alert("No tiene permiso para realizar esta operacion");
		}
}

function ue_eliminar()
{
	f=document.form1;
	li_eliminar=f.eliminar.value;
	if(li_eliminar==1)
	{
		li_txtcodrot=f.txtcodrot.value;
		if(li_txtcodrot!="")
			{
				$.post("sigesp_saf_puente_rotulacion.php", {codigo:li_txtcodrot,status:"DELETE"})
				.done(function(data)
				{
					if (data == false)
					{
						// ocultamos los bloques que pueden haber
						// quedado de operaciones anteriores
						$("#save_success_block").hide( "slow" );
						$("#save_error_block").hide( "slow" );
						$("#delete_error_block").hide( "slow" );
						$("#new_error_block").hide( "slow" );
						//$("#error_block").after( data );
						$("#delete_error_block").show( "slow" );
					}else if(data == true)
					{
						// ocultamos los bloques que pueden haber
						// quedado de operaciones anteriores
						$("#save_success_block").hide( "slow" );
						$("#save_error_block").hide( "slow" );
						// ocular el bloque de error si existe
						$("#delete_error_block").hide( "slow" );
						$("#new_error_block").hide( "slow" );
						// mostramos el bloque de exito
						$("#delete_success_block").show( "slow" );
						// colocamos todos los campos en blanco
						// quizas se pueda hacer con un for
						$("#txtnombre").val('');
						$("#txtdenrot").val('');
						$("#txtempleo").val('');
						$("#operacion").val('');
					}
				});
			}
			else
		   	{
		 		alert("Hay algunos campos en blanco");
		   	}
	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_cerrar()
{
	window.location.href="sigespwindow_blank.php";
}

function hiddenOn()
{
	var hiddenStatus = document.getElementById("operacion").value;
	if(hiddenStatus == "")
	{
		document.getElementById("valuehidden").innerHTML = "VACIO";
	}
	if(hiddenStatus == "G")
	{
		document.getElementById("valuehidden").innerHTML = "G";
	}
}

function ue_ayuda()
	{
		window.open("/doc/saf/sigesp_saf_d_rotulacion.md","fullscreen=yes,menubar=no,toolbar=no,scrollbars=yes");
	}
