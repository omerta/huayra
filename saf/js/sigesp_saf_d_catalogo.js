function ue_abrircuentas()
{
	window.open("sigesp_saf_cat_ctasspg.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=550,height=400,left=50,top=50,location=no,resizable=yes");
}

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
   	{
		window.open("sigesp_saf_cat_sigecof.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=518,height=400,left=50,top=50,location=no,resizable=yes");
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_nuevo()
{
	f=document.form1;
	li_incluir=f.incluir.value;
	if(li_incluir==1)
	{
		$("#txtcatalogo").val('');
		$("#txtdencat").val('');
		$("#txtcuenta").val('');
		$("#txtdenominacion").val('');
		$("#hidstatus").val(''); // bandera que indica una modificación del formulario

		$("#delete_error_block").hide( "slow" );
		$("#delete_success_block").hide( "slow" );
		$("#save_success_block").hide( "slow" );
		$("#save_error_block").hide( "slow" );
		$("#new_error_block").hide( "slow" );
		$("#new_error_block_detail").hide( "slow" );
		$("#required_error_block").hide("slow");
		$("#warning_success_block").hide("slow");
 	}
	else
 	{
 		alert("No tiene permiso para realizar esta operacion.");
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
	lb_status=f.hidstatus.value;

	/* registro de sucesos */
	log_empresa=f.empresa.value;
	log_sistema=f.sistema.value;
	log_logusr=f.logusr.value;
	log_ventanas=f.ventanas.value;

	if(((lb_status=="G")&&(li_cambiar==1))||(lb_status=="")&&(li_incluir==1))
	{
		catalogo=f.txtcatalogo.value;
		denominacion=f.txtdencat.value;
		cuenta=f.txtcuenta.value;
		/* insert/update */
		if(!ue_check_fields())
		{
			if(lb_status=="")
			{
					$.post("sigesp_saf_puente_catalogo.php",
							{catalogo:catalogo,denominacion:denominacion,
							 cuenta:cuenta,status:lb_status,
							 log_empresa:log_empresa,
						 	 log_sistema:log_sistema,log_logusr:log_logusr,log_ventanas:log_ventanas},
							 null,"json")
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
							$("#hidstatus").val('G'); // bandera que indica una modificación del formulario
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
				$.post("sigesp_saf_puente_catalogo.php",
						{catalogo:catalogo,denominacion:denominacion,
						 cuenta:cuenta,status:lb_status,
						 log_empresa:log_empresa,
						 log_sistema:log_sistema,log_logusr:log_logusr,log_ventanas:log_ventanas},
						 null,"json")
					.done(function(data)
					{
						if (data[0] == false)
						{
							$("#delete_error_block").hide( "slow" );
							$("#delete_success_block").hide( "slow" );
							$("#save_success_block").hide( "slow" );
							$("#save_error_block").hide( "slow" );
							$("#new_error_block").hide( "slow" );
							/**/
							$("#error_block").show( "slow" );
						}else if(data[0] == true)
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

	/* registro de sucesos */
	log_empresa=f.empresa.value;
	log_sistema=f.sistema.value;
	log_logusr=f.logusr.value;
	log_ventanas=f.ventanas.value;

	if(li_eliminar==1)
	{
		catalogo=f.txtcatalogo.value;
		if(catalogo!="")
			{
				$.post("sigesp_saf_puente_catalogo.php",
					{catalogo:catalogo,status:"DELETE",log_empresa:log_empresa,
					log_sistema:log_sistema,log_logusr:log_logusr,log_ventanas:log_ventanas},
					null,"json")
				.done(function(data)
				{
					if (data[0] == false)
					{
						// ocultamos los bloques que pueden haber
						// quedado de operaciones anteriores
						$("#save_success_block").hide( "slow" );
						$("#save_error_block").hide( "slow" );
						$("#delete_error_block").hide( "slow" );
						$("#new_error_block").hide( "slow" );
						$("#required_error_block").hide( "slow" );
						$("#sub_required_error_block").hide( "slow" );
						//$("#error_block").after( data );
						$("#delete_error_block").show( "slow" );
						$("#new_error_block_detail").show( "slow" );
						$("#new_error_block_detail").children('div').html('<strong>' + data[1] + '</strong> ');
					}else if(data[0] == true)
					{
						// ocultamos los bloques que pueden haber
						// quedado de operaciones anteriores
						$("#delete_success_block").hide( "slow" );
						$("#save_success_block").hide( "slow" );
						$("#save_error_block").hide( "slow" );
						$("#required_error_block").hide( "slow" );
						$("#sub_required_error_block").hide( "slow" );
						// ocular el bloque de error si existe
						$("#delete_error_block").hide( "slow" );
						$("#new_error_block").hide( "slow" );
						$("#warning_success_block").hide( "slow" );
						// mostramos el bloque de exito
						$("#delete_success_block").show( "slow" );
						if(data[1] != "")
						{
							$("#warning_success_block").show( "slow" );
							$("#warning_success_block").children('div').html('<strong>' + data[1] + '</strong> ');
						}
						// colocamos todos los campos en blanco
						// quizas se pueda hacer con un for
						$("#txtcatalogo").val('');
						$("#txtdencat").val('');
						$("#txtcuenta").val('');
						$("#txtdenominacion").val('');
						$("#hidstatus").val('');
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

function ue_ayuda()
{
    window.open("/doc/saf/sigesp_saf_d_catalogo.md","fullscreen=yes,menubar=no,toolbar=no,scrollbars=yes");
}

function hiddenOn()
{
	var hiddenStatus = document.getElementById("hidstatus").value;
	if(hiddenStatus == "")
	{
		document.getElementById("valuehidden").innerHTML = "VACIO";
	}
	if(hiddenStatus == "G")
	{
		document.getElementById("valuehidden").innerHTML = "G";
	}
}
