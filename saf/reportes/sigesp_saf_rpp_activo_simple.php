<?php

	session_start();

	/*
	 * $_SESSION["ls_logo"] -> logo.jpg
	 * $_SESSION["ls_width"] -> 70
	 * $_SESSION["ls_height"] -> 70
	 */
	require_once("../../shared/ezpdf/class.ezpdf.php");

	require_once("../../shared/class_folder/class_funciones.php");
	$io_funciones=new class_funciones();

	require_once("sigesp_saf_class_report.php");
	$io_report=new sigesp_saf_class_report();

	require_once("../class_funciones_activos.php");
	$io_fun_activos=new class_funciones_activos();

	$arre=$_SESSION["la_empresa"];
	$ls_codemp=$arre["codemp"];

	$lb_valido=$io_report->uf_saf_load_activos_simple($ls_codemp);

	//$ls_titulo="Reporte Simple de Activos";
	$ls_titulo="<b>REPORTE SIMPLE DE ACTIVOS<b>";
	$ld_subtitulo="Todos los Activos por <i>Codigo Activo</i>";

	if($lb_valido==false) // Existe algún error ó no hay registros
	{
		print("<script language=JavaScript>");
		print(" alert('No hay nada que Reportar');");
		print(" close();");
		print("</script>");
	}
	else // Imprimimos el reporte
	{
		/////////////////////////////////         SEGURIDAD               ////////////////////////////////////////////////////
		$ls_desc_event="Se genera un reporte de Activo Simple.";
		$io_fun_activos->uf_load_seguridad_reporte("SAF","sigesp_saf_r_activo.php",$ls_desc_event);
		////////////////////////////////         SEGURIDAD               /////////////////////////////////////////////////////

		error_reporting(E_ALL);
		set_time_limit(1800);
		$io_pdf=new Cezpdf('LETTER','landscape'); // Instancia de la clase PDF
		$io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
		$io_pdf->ezSetCmMargins(3.5,3,3,3); // Configuraci�n de los margenes en cent�metros
		$io_pdf->ezStartPageNumbers(720,47,8,'','',1); // Insertar el n�mero de p�gina

		uf_print_encabezado_pagina($ls_titulo,"",$ld_subtitulo,$io_pdf); // Imprimimos el encabezado de la p�gina
		$li_totrow=$io_report->ds->getRowCount("codact");

		$i=0;
		for($li_i=1;$li_i<=$li_totrow;$li_i++)
		{
      $io_pdf->transaction('start'); // Iniciamos la transacción
			$li_numpag=$io_pdf->ezPageCount; // Número de página
			$ls_codact=$io_report->ds->data["codact"][$li_i];
			$ls_denact=$io_report->ds->data["denact"][$li_i];
			$ls_maract=$io_report->ds->data["maract"][$li_i];
			$ls_modact=$io_report->ds->data["modact"][$li_i];
			$ld_fecmpact=$io_report->ds->data["feccmpact"][$li_i];
			$ld_fecmpactaux=$io_funciones->uf_convertirfecmostrar($ld_fecmpact);
			$ls_serial=$io_report->ds->data["serial"][$li_i];
			$ls_numero_chapa=$io_report->ds->data["numero_chapa"][$li_i];
			$li_costo=$io_report->ds->data["costo"][$li_i];
			$li_costo=$io_fun_activos->uf_formatonumerico($li_costo);
			$la_data[$li_i]=array('codact'=>$ls_codact,
									'denact'=>$ls_denact,
									'maract'=>$ls_maract,
									'modact'=>$ls_modact,
									'feccmpact'=>$ld_fecmpact,
									'serial'=>$ls_serial,
									'numero_chapa'=>$ls_numero_chapa,
									'costo'=>$li_costo);
		}

		if($la_data!="")
		{
			uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle
		}
			$hoy = date("dmY_His");
			$name = "reporte_activo_simple_".$hoy.".pdf";
			$io_pdf->ezStream(array('Content-Disposition'=>utf8_decode($name)));
		}

		function uf_print_encabezado_pagina($as_titulo,$as_cmpmov,$ad_subtitulo,&$io_pdf)
		{
			$io_encabezado=$io_pdf->openObject();
			$io_pdf->saveState();
			$io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],30,550,700,40); // Agregar Logo
			$li_tm=$io_pdf->getTextWidth(11,$as_titulo);
			$tm=396-($li_tm/2);
			$io_pdf->addText($tm,535,11,$as_titulo); // Agregar el t�tulo
			$li_tm=$io_pdf->getTextWidth(11,$ad_subtitulo);
			$tm=410-($li_tm/2);
			$io_pdf->addText($tm,522,9,$ad_subtitulo); // Agregar la fecha
			$io_pdf->addText(690,540,7,date("d/m/Y")); // Agregar la Fecha
			$io_pdf->addText(690,535,6,date("h:i a")); // Agregar la Hora
			$io_pdf->restoreState();
			$io_pdf->closeObject();
			$io_pdf->addObject($io_encabezado,'all');
		}

		function uf_print_detalle($la_data,&$io_pdf)
		{
			$io_pdf->ezSetDy(-5);

			$la_columna[1]=array('codact'=>'<b>Codigo</b>',
								'denact'=>'<b>Denominacion</b>',
								'maract'=>'<b>Marca</b>',
								'modact'=>'<b>Modelo</b>',
								'feccmpact'=>'<b>Fecha Compra</b>',
								'serial'=>'<b>Serial</b>',
								'numero_chapa'=>'<b>Chapa</b>',
								'costo'=>'<b>Costo</b>');

			$la_columnas=array('codact'=>'',
								'denact'=>'',
								'maract'=>'',
								'modact'=>'',
								'feccmpact'=>'',
								'serial'=>'',
								'numero_chapa'=>'',
								'costo'=>'');

			$la_config_encabezado=array('showHeadings'=>0, // Mostrar encabezados 1
							 'fontSize' => 8, // Tama�o de Letras
							 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos 8
							 'showLines'=>1, // Mostrar L�neas 2
							 'shaded'=>2, // Sombra entre l�neas 0
							 'width'=>680, // Ancho de la tabla 900
							 'maxWidth'=>680, // Ancho M�ximo de la tabla 900
							 'xOrientation'=>'center', // Orientaci�n de la tabla
							 'outerLineThickness'=>0.5,
							 'innerLineThickness' =>0.5,
							 'cols'=>array('codact'=>array('justification'=>'left','width'=>80),
											'denact'=>array('justification'=>'left','width'=>140),
											'maract'=>array('justification'=>'left','width'=>60),
											'modact'=>array('justification'=>'left','width'=>60),
											'feccmpact'=>array('justification'=>'left','width'=>60),
											'serial'=>array('justification'=>'left','width'=>120),
											'numero_chapa'=>array('justification'=>'left','width'=>100),
											'costo'=>array('justification'=>'left','width'=>60)));
			/* sombrear el encabezado */
			$io_pdf->ezTable($la_columna,$la_columnas,'',$la_config_encabezado);

			$la_config=array('showHeadings'=>0, // Mostrar encabezados 1
							 'fontSize' => 8, // Tama�o de Letras
							 'titleFontSize' => 10,  // Tama�o de Letras de los t�tulos 8
							 'showLines'=>1, // Mostrar L�neas 2
							 'shaded'=>0, // Sombra entre l�neas 0
							 'width'=>680, // Ancho de la tabla 900
							 'maxWidth'=>680, // Ancho M�ximo de la tabla 900
							 'xOrientation'=>'center', // Orientaci�n de la tabla
							 'cols'=>array('codact'=>array('justification'=>'left','width'=>80),
											'denact'=>array('justification'=>'left','width'=>140),
											'maract'=>array('justification'=>'left','width'=>60),
											'modact'=>array('justification'=>'left','width'=>60),
											'feccmpact'=>array('justification'=>'left','width'=>60),
											'serial'=>array('justification'=>'left','width'=>120),
											'numero_chapa'=>array('justification'=>'left','width'=>100),
											'costo'=>array('justification'=>'left','width'=>60)));

			$io_pdf->ezTable($la_data,$la_columnas,'',$la_config);
		}
?>
