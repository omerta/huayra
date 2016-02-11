function ue_nuevo()
{
	$.post("sigesp_saf_puente_marca.php", 
			{newstatus:"NEW"})
	.done(function(data)
	{
		if (data == false)
		{
			/* es posible que esten 'show' alguno de los blques de error */
			$("#delete_error_block").hide( "slow" );
			$("#delete_success_block").hide( "slow" );
			$("#save_success_block").hide( "slow" );
			$("#save_error_block").hide( "slow" );
			$("#new_error_block").hide( "slow" );
			/* mostramos el error correspondiente */
			$("#new_error_block").show( "slow" );
		}else if(data != "")
		{
			$("#delete_error_block").hide( "slow" );
			$("#delete_success_block").hide( "slow" );
			$("#save_success_block").hide( "slow" );
			$("#save_error_block").hide( "slow" );
			$("#new_error_block").hide( "slow" );
			$("#codmarcaid").val(data); // bandera que indica una modificación del formulario
			$("#denominacioncomercialid").val('');
			$("#nombrefabricanteid").val('');
			$("#hidstatus").val(''); // bandera que indica una modificación del formulario
		}
	});
}

function ue_guardar()
{
	f=document.form1;
	li_codmarcaid=f.codmarcaid.value;
	li_denominacioncomercialid=f.denominacioncomercialid.value;
	li_nombrefabricanteid= f.nombrefabricanteid.value;
	/* insert/update */
	li_hidstatus=f.hidstatus.value;
	if((li_codmarcaid!="")&&(li_hidstatus=="")&&(li_denominacioncomercialid!="")&&(li_nombrefabricanteid!=""))
	{
			$.post("sigesp_saf_puente_marca.php", 
					{codmarca:li_codmarcaid,denominacion:li_denominacioncomercialid,
					 fabricante:li_nombrefabricanteid,status:li_hidstatus})
			.done(function(data)
			{
				if (data == false)
				{
					/* */
					$("#delete_error_block").hide( "slow" );
					$("#delete_success_block").hide( "slow" );
					$("#save_success_block").hide( "slow" );
					$("#save_error_block").hide( "slow" );
					$("#new_error_block").hide( "slow" );
					/* */
					$("#save_error_block").show( "slow" );
				}else if(data == true)
				{
					$("#delete_error_block").hide( "slow" );
					$("#delete_success_block").hide( "slow" );
					$("#save_success_block").show( "slow" );
					$("#save_error_block").hide( "slow" );
					$("#hidstatus").val('G'); // bandera que indica una modificación del formulario
				}
			});
	} // G indica que es un modificación del formulario
	else if ((li_codmarcaid!="")&&li_hidstatus=="G"&&(li_denominacioncomercialid!="")&&(li_nombrefabricanteid!="")){
			$.post("sigesp_saf_puente_marca.php", 
					{codmarca:li_codmarcaid,denominacion:li_denominacioncomercialid,
					 fabricante:li_nombrefabricanteid,status:li_hidstatus})
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
	else
   	{
 		alert("Hay algunos campos en blanco");
   	}
}

function ue_buscar()
{
	f=document.form1;
	li_leer=f.leer.value;
	if (li_leer==1)
   	{
		window.open("sigesp_saf_cat_marca.php","catalogo","menubar=no,toolbar=no,scrollbars=yes,width=570,height=400,left=50,top=50,location=no,resizable=yes");
   	}
	else
   	{
 		alert("No tiene permiso para realizar esta operacion");
   	}
}

function ue_eliminar()
{
	f=document.form1;
	li_codmarcaid=f.codmarcaid.value;
	if(confirm("\u00bfUsted esta seguro que desea eliminar este registro?"))
		{
		if(li_codmarcaid!="")
			{
				$.post("sigesp_saf_puente_marca.php", {codmarca:li_codmarcaid,status:"DELETE"})
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
						// quizas se pueda hacer con un ciclo for
						$("#denominacioncomercialid").val('');
						$("#nombrefabricanteid").val('');
						$("#codmarcaid").val('');
					}
				});
			}
			else
		   	{
		 		alert("Hay algunos campos en blanco");
		   	}
		}
	
}

function ue_cerrar()
{
	window.location.href="sigespwindow_blank.php";
}

function ue_ayuda()
{
	window.open("/doc/saf/sigesp_saf_d_marca.md","fullscreen=yes,menubar=no,toolbar=no,scrollbars=yes");
}