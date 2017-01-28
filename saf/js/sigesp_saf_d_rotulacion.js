// @TODO reescribir todas las funciones al estito jQuery
// $("#btEliminar").click(function(){
// 	var accion:
// 	$.post("phpFile.php",function(data){
//		if(data===true){...}
//		else{..}
//		});
//	});

/* mensaje de espera */
$(document).ajaxStart(function () {
	$('#mensaje_espera_texto').show();
	$(document.body).css({'cursor' : 'wait'});
}).ajaxStop(function () {
	$('#mensaje_espera_texto').hide();
	$(document.body).css({'cursor' : 'default'});
});

/* eliminar el contenido del modal al cerrarlo */
$(document).ready(function() {
  $(".modal").on("hidden.bs.modal", function() {
		$('#table_catalogo_rotulacion > tbody').html('');
  });
});

function ue_buscar()
{
	$('#table_catalogo_rotulacion > tbody').html('');
	var codrot = $('#txtcodigo').val();
	var denrot = $('#txtdenominacion').val();
	$.post("sigesp_saf_puente_rotulacion.php",
				 {status:"CATALOGO",codrot:codrot,denrot:denrot},null,"json")
				 .done(function(data)
				 {
					 if(data != null){
						 $.each(data, function(i, val) {
								$('#table_catalogo_rotulacion > tbody:last-child').append('<tr class="celdas-blancas"></tr>');
								var aceptar = ("'"+val['codrot']+"','"+val['denrot']+"','"+val['emprot']+"'");
							 $.each(val, function(j, val) {
								 if(j == 'codrot')
								 {
									 $('#table_catalogo_rotulacion > tbody > tr:last-child').append('<td><a href=\"javascript: aceptar('+ aceptar +');\">'+ val +'</td>');
								 }else{
									 $('#table_catalogo_rotulacion > tbody > tr:last-child').append('<td>'+ val +'</td>');
								 }
							 });
						 });
					 }else{
						 $('#table_catalogo_rotulacion > tbody').append('<tr><td colspan="3" class="alert alert-warning">Upps!, no hay datos que mostrar</tr></td>');
					 }
					 $('#txtcodigo').val('');
					 $('#txtdenominacion').val('');
					 $('#catalogo_rotulacion').modal('show');
				 })
				 .fail(function(data) {
					 alert("Error con Ajax al buscar en la tabla los métodos de rotulacion.");
					 console.log(data);
				 })
}

function aceptar(prov,d,v,n,hidstatus)
{
	$('#txtcodrot').val(prov);
	$('#txtdenrot').val(d);
	$('#txtempleo').val(v);
	$('#operacion').val('G');
	$("#mensajes").hide('slow');
	$("#mensajes_detalles").hide('slow');
	$('#catalogo_rotulacion').modal('hide');
}

function ue_cata()
{
	window.open("sigesp_catdinamic_empresas.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
}

function ue_nuevo()
{
	/* */
	$("#mensajes").hide('slow');
	$("#mensajes_detalles").hide('slow');
	$("#required_error_block").hide('slow');

	/* */
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
						$("#txtcodrot").val(data[1]);
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
