// @TODO reescribir todas las funciones al estito jQuery
// $("#btEliminar").click(function(){
// 	var accion:
// 	$.post("phpFile.php",function(data){
//		if(data===true){...}
//		else{..}
//		});
//	});

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
		$.post("sigesp_saf_puente_rotulacion.php",
						{newstatus:"NEW"},null,"json")
				.done(function(data)
				{
					if (data[0] == false)
					{
						/* es posible que esten 'show' alguno de los bloques de error */
						$("#mensajes").hide("slow");
						$("#mensajes_detalles").hide("slow");
						/* mostramos el error correspondiente */
						$("#mensajes").removeClass('alert alert-success')
													.addClass('alert alert-danger')
													.html('<strong>Error!</strong> Al asignar un <i>C&oacute;digo</i> al formulario de registro.');
						$("#mensajes").show('slow');
						/* detalles del error */
						$("#mensajes_detalles").addClass('alert alert-warning')
																	 .html('<strong>' + data[1] + '</strong> ');
						$("#mensajes_detalles").show('slow');
						/* reset the form */
						$("#form1")[0].reset();
					}else if(data[0] == true)
					{
						/* */
						$("#mensajes").hide("slow");
						$("#mensajes_detalles").hide("slow");
						/* */
						$("#operacion").val(''); // bandera que indica una modificación del formulario
						$("#form1")[0].reset();
						$("#txtnombre").val(data[1]);
					}
				});
}

function ue_check_fields()
{
	var ToReturn;
	var fields = $("#form1").find("select, textarea, input").filter('[required]:visible').serializeArray();
	$.each(fields, function(i, field) {
		if (!field.value)
	  	{
			// console.log(field.name);
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
	//li_incluir=f.incluir.value;
	//li_cambiar=f.cambiar.value;

		/* atributo name de la etiqueta input */
		lb_status=f.operacion.value;
		li_txtcodrot=f.txtcodrot.value;
		li_txtdenrot=f.txtdenrot.value;
		li_txtempleo= f.txtempleo.value;
		/* insert/update */
		if(!ue_check_fields())
		{
			if(lb_status === "")
			{
					$.post("sigesp_saf_puente_rotulacion.php",
							{codigo:li_txtcodrot,denominacion:li_txtdenrot,
							 empleo:li_txtempleo,status:lb_status},null,"json")
					.done(function(data)
					{
						if (data[0] === false)
						{
							/* mensaje de error */
							$("#mensajes").removeClass('alert alert-success')
														.addClass('alert alert-danger')
														.html('<strong>Error!</strong> El formunario no pudo ser guardado.');
							$("#mensajes").show('slow');
							/* detalles del error */
							$("#mensajes_detalles").addClass('alert alert-warning')
																		 .html('<strong>' + data[1] + '</strong> ');
							$("#mensajes_detalles").show('slow');
						}else if(data[0] === true)
						{
							$("#mensajes_detalles").hide('slow');
							/* mesaje de error */
							$("#mensajes").removeClass('alert alert-danger')
													 	.addClass('alert alert-success')
													 	.html('<strong>&Eacute;xito!</strong> El formulario fue guardado.');
 							$("#mensajes").show('slow');
							$("#operacion").val('G'); // bandera que indica una modificación del formulario
						}
					});
			} // G indica que es un modificación del formulario
			else if(lb_status == "G")
			{
					$.post("sigesp_saf_puente_rotulacion.php",
								{codigo:li_txtcodrot,denominacion:li_txtdenrot,
							 	empleo:li_txtempleo,status:lb_status},null,"json")
					.done(function(data)
					{
						if (data[0] === false)
						{
							/* */
							$("#mensajes_detalles").hide('slow');
							$("#mensajes").removeClass('alert alert-success')
														.addClass('alert alert-danger')
														.html('<strong>Error!</strong> El formunario no pudo ser actualizado.');
							$("#mensajes").show('slow');
							/* detalles del error */
							$("#mensajes_detalles").addClass('alert alert-warning')
																		 .html('<strong>' + data[1] + '</strong> ');
							$("#mensajes_detalles").show('slow');
						}else if(data[0] === true)
						{
							/* mesaje de error */
							$("#mensajes_detalles").hide('slow');
							$("#mensajes").removeClass('alert alert-danger')
														.addClass('alert alert-success')
														.html('<strong>&Eacute;xito!</strong> El formulario fue actualizado.');
							$("#mensajes").show('slow');
							$("#operacion").val('G'); // bandera que indica una modificación del formulario
						}
					});
			}
		} else {
			$("#required_error_block").show( "slow" );
		}
}

function ue_eliminar()
{
		f=document.form1;
		li_txtcodrot=f.txtcodrot.value;
		if(li_txtcodrot !== "")
			{
				$.post("sigesp_saf_puente_rotulacion.php",
							 {codigo:li_txtcodrot,status:"DELETE"},
						 	 null,"json")
				.done(function(data)
				{
					if (data[0] === false)
					{
						$("#mensajes_detalles").hide('slow');
						$("#mensajes").removeClass('alert alert-success')
													.addClass('alert alert-danger')
													.html('<strong>Error!</strong> El objeto no pudo ser borrado.');
						$("#mensajes").show('slow');
						/* detalles del error */
						$("#mensajes_detalles").addClass('alert alert-warning')
																	 .html('<strong>' + data[1] + '</strong> ');
						$("#mensajes_detalles").show('slow');
					}else if(data[0] === true)
					{
						// ocultamos los bloques que pueden haber
						// quedado de operaciones anteriores
						$("#mensajes_detalles").hide('slow');
						$("#mensajes").removeClass('alert alert-danger')
													.addClass('alert alert-success')
													.html('<strong>&Eacute;xito!</strong> El objeto fue borrado.');
						$("#mensajes").show('slow');
						$("#form1")[0].reset();
						$("#operacion").val(''); // bandera que indica una modificación del formulario
					}
				});
			}else{
		 		alert("Hay algunos campos en blanco");
	   	}
}

function ue_cerrar()
{
	window.location.href="sigespwindow_blank.php";
}

function hiddenOn()
{
	var hiddenStatus = document.getElementById("operacion").value;
	if(hiddenStatus === "")
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
