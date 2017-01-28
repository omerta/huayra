<?php
/**
 * Comprobante de Incorporación
 */
session_start();
header("Pragma: public");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
if(!array_key_exists("la_logusr",$_SESSION))
{
    print "<script language=JavaScript>";
    print "close();";
    print "</script>";
}

//-----------------------------------------------------  Instancia de las clases  ------------------------------------------------
// require_once("../../shared/ezpdf/class.ezpdf.php");
require_once '../../shared/vendor/autoload.php';

require_once("../../shared/class_folder/class_funciones.php");
$io_funciones=new class_funciones();
require_once("../class_funciones_activos.php");
$io_fun_activos=new class_funciones_activos();
require_once("sigesp_saf_class_report.php");
$io_report=new sigesp_saf_class_report();
//----------------------------------------------------  Parametros del encabezado  -----------------------------------------------
$ls_fecrec=$io_fun_activos->uf_obtenervalor_get("fecrec","");
$ls_titulo="<b>Comprobante de Incorporación</b>";
$ls_fecha=$ls_fecrec;
//--------------------------------------------------  Parametros para Filtar el Reporte  -----------------------------------------
$arre=$_SESSION["la_empresa"];
$ls_codemp=$arre["codemp"];
$ls_nomemp=$arre["nombre"];
$ls_cmpmov=$io_fun_activos->uf_obtenervalor_get("cmpmov","");

    //--------------------------------------------------------------------------------------------------------------------------------
    $lb_valido=$io_report->uf_saf_load_movimiento($ls_codemp,$ls_cmpmov,"","","I","","",""); // Cargar el DS con los datos de la cabecera del reporte
    if($lb_valido==false) // Existe alg�n error � no hay registros
    {
        print("<script language=JavaScript>");
        print(" alert('No hay nada que Reportar');");
        print(" close();");
        print("</script>");
    }	else {
        error_reporting(E_ALL);
        set_time_limit(1800);
        $io_pdf=new Cezpdf('LETTER','portrait'); // Instancia de la clase PDF (612x792)
        $io_pdf->selectFont('../../shared/ezpdf/fonts/Helvetica.afm'); // Seleccionamos el tipo de letra
        $io_pdf->ezSetCmMargins(4,4,3,3); // Configuracion de los margenes en centimetros
        $io_pdf->ezStartPageNumbers(550,25,8,'','',1);
        $ld_fecha=$io_report->ds->data["feccmp"][1];
        $ld_fecha=$io_funciones->uf_convertirfecmostrar($ld_fecha);

        uf_print_encabezado_pagina($ls_titulo,$ls_cmpmov,$ld_fecha,$io_pdf); // Imprimimos el encabezado de la p�gina

        $li_totrow=$io_report->ds->getRowCount("cmpmov");
        for($li_i=1;$li_i<=$li_totrow;$li_i++)
        {
            // $io_pdf->transaction('start'); // Iniciamos la transacci�n
            $li_numpag=$io_pdf->ezPageCount; // N�mero de p�gina
            $li_totprenom=0;
            $li_totant=0;

            /* */
            $ls_codcau=$io_report->ds->data["codcau"][$li_i];
            $ls_dencau=$io_report->ds->data["dencau"][$li_i];
            $ls_descmp=$io_report->ds->data["descmp"][$li_i];
            $ls_codresuso=$io_report->ds->data["codresuso"][$li_i];
            $ls_denresuso=$io_report->ds->data["nomper"][$li_i];
            $ls_codResPrimario=$io_report->ds->data["codrespri"][$li_i];
            $ls_nomResPrimario=$io_report->ds->data["nomrespri"][$li_i]." ".$io_report->ds->data["aperespri"][$li_i];
            $ls_denresuso=$ls_denresuso." ".$io_report->ds->data["apeper"][$li_i];
            $ls_codubifisresusp=$io_report->ds->data["codubifis"][$li_i];
            $ls_desubifisresuso=$io_report->ds->data["desubifis"][$li_i];
            uf_print_cabecera($ls_codemp,$ls_nomemp,$ls_codcau,$ls_dencau,$ls_descmp,
                $io_pdf,$ls_codresuso,$ls_denresuso,$ls_codubifisresusp,
                $ls_desubifisresuso,$ls_codResPrimario,$ls_nomResPrimario); // Imprimimos la cabecera del registro

        /* */
            $lb_valido=$io_report->uf_saf_load_dt_movimiento($ls_codemp,$ls_cmpmov,$ls_codcau); // Obtenemos el detalle del reporte
            if($lb_valido)
            {
                $li_montot=0;
                $li_totrow_det=$io_report->ds_detalle->getRowCount("codact");

                /* crea un arreglo con todos los datos de la tabla */
                for($li_s=1;$li_s<=$li_totrow_det;$li_s++)
                {
                    $ls_codart= $io_report->ds_detalle->data["codact"][$li_s];
                    $ls_denart= $io_report->ds_detalle->data["denact"][$li_s];
                    $li_ideact= $io_report->ds_detalle->data["ideact"][$li_s];
                    $ls_desmov= $io_report->ds_detalle->data["desmov"][$li_s];
                    $li_monact= $io_report->ds_detalle->data["monact"][$li_s];
                    $li_montot=$li_montot+$li_monact;
                    $li_monact=$io_fun_activos->uf_formatonumerico($li_monact);
                    $la_data[$li_s]=array('codact'=>$ls_codart,'denact'=>$ls_denart,'ideact'=>$li_ideact,'desmov'=>$ls_desmov,
                        'monact'=>$li_monact);
                }

                $li_montot=$io_fun_activos->uf_formatonumerico($li_montot);
                /* encabezado de la tabla */
                uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle
                $la_datat[1]=array('total'=>"Total",'monact'=>$li_montot);
                /* */
                uf_print_totales($la_datat,$io_pdf);
                uf_print_firmas($io_pdf);
				// if ($io_pdf->ezPageCount==$li_numpag)
				// {// Hacemos el commit de los registros que se desean imprimir
				// 	$io_pdf->transaction('commit');
				// } else {// Hacemos un rollback de los registros, agregamos una nueva p�gina y volvemos a imprimir
				// 	$io_pdf->transaction('rewind');
				// 	if($li_numpag!=1)
				// 	{
				// 		$io_pdf->ezNewPage(); // Insertar una nueva p�gina
				// 	}
				// 	uf_print_cabecera($ls_codemp,$ls_nomemp,$ls_codcau,$ls_dencau,$ls_descmp,$io_pdf);  // Imprimimos la cabecera del registro
				// 	uf_print_detalle($la_data,$io_pdf); // Imprimimos el detalle
				// 	uf_print_totales($la_datat,$io_pdf);
				// }
            }
            unset($la_data);
        }
        if ($lb_valido) {
        // $io_pdf->ezStopPageNumbers(1,1);
        $io_pdf->ezStream();
        }
		    unset($io_pdf);
    }

/**
 * Función que imprime los encabezados por página
 *
 * @since 26042006
 * @author Luis Anibal Lang
 *
 * @param string $as_titulo Títuto del reporte.
 * @param string $as_cmpmov Número de comprobante de movimiento.
 * @param string $ad_fecha Fecha actual.
 * @param object $io_pdf Instancia del objeto pdf.
 *
 * @return void.
 */
function uf_print_encabezado_pagina($as_titulo,$as_cmpmov,$ad_fecha,&$io_pdf)
{
    /* Start an independent object. This will return an object handle, and all
    * further writes to a page will actually go into this object, until a
    * closeObject call is made, */
    $io_encabezado=$io_pdf->openObject();
    $io_pdf->setStrokeColor(0,0,0);
    $io_pdf->addText(510,760+10,8,date("d/m/Y")); // Agregar la Fecha
    $io_pdf->addText(516,753+10,7,date("h:i a")); // Agregar la Hora
    $io_pdf->addJpegFromFile('../../shared/imagebank/'.$_SESSION["ls_logo"],50,735-5,700-200,40-10); // Agregar Logo
    $li_tm=$io_pdf->getTextWidth(11,$as_titulo);
    $tm=280-($li_tm/2);
    $io_pdf->addText($tm,730-25,11,$as_titulo); // Agregar el t�tulo
    $io_pdf->rectangle(420,710-25,130,40);
    $io_pdf->line(420,730-25,550,730-25);
    $io_pdf->addText(424,735-25,11,"No.:");      // Agregar texto
    $io_pdf->addText(456,735-25,11,$as_cmpmov); // Agregar Numero de la solicitud
    $io_pdf->addText(424,715-25,10,"Fecha:"); // Agregar texto
    $io_pdf->addText(456,715-25,10,$ad_fecha); // Agregar la Fecha
    $io_pdf->closeObject();
    /* Add the object specified by id to the current page (default). If a string
    * 'all' is supplied in options add to every page from the current one on. */
    $io_pdf->addObject($io_encabezado,'all');
	}// end function uf_print_encabezadopagina

	/**
	 * Función que imprime la cabecera de cada página.
	 *
	 * @since 21042006
	 * @author Yesenia Moreno
	 *
	 * @param string $ls_codemp Codigo de la empresa.
	 * @param string $ls_nomemp Nombre de la empresa.
	 * @param string $ls_codcau Código de causa.
	 * @param string $ls_dencau Denominación de causa.
	 * @param string $ls_descmp El número total de registro que tendrá el reporte.
	 * @param string $ls_codResPrimario Número de cédula/Código del responsable primario/administrativo
	 * @param string $ls_nomResPrimario Nombre del responsable primario/administrativo.
	 *
	 * @return void.
	 */
	function uf_print_cabecera($ls_codemp,$ls_nomemp,$ls_codcau,$ls_dencau,$ls_descmp,&$io_pdf,$ls_codresuso,$ls_denresuso,$ls_codubifisresuso,$ls_desubifisresuso,
														 $ls_codResPrimario,$ls_nomResPrimario)
	{
		// $io_pdf->ezSetDy(-10);
		$la_data=array(array('name'=>'<b>Institucion:</b>         '.$ls_codemp." - ".$ls_nomemp.''),
					   array ('name'=>'<b>Causa:</b>                 '.$ls_codcau." - ".$ls_dencau.''),
						 array ('name'=>'<b>Responsable Administrativo:</b> '.$ls_codResPrimario." - ".$ls_nomResPrimario.''),
					   array ('name'=>'<b>Responsable de Uso:</b>  '.$ls_codresuso." - ".$ls_denresuso.''),
					   array ('name'=>'<b>Ubicacion del Responsable de Uso:</b>  '.$ls_codubifisresuso." - ".$ls_desubifisresuso.''),
					   array ('name'=>'<b>Observaciones:</b>  '.$ls_descmp.''));

		$la_columna=array('name'=>'');
		$la_config=array('showHeadings'=>0, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'lineCol'=>array(0.9,0.9,0.9), // Mostrar L�neas
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>2	, // Sombra entre l�neas
						 'shadeCol'=>array(0.9,0.9,0.9), // Color de la sombra
						 'shadeCol2'=>array(0.9,0.9,0.9), // Color de la sombra
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500); // Ancho M�ximo de la tabla
		/* */
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}

	/**
	 * Función que imprime el detalle.
	 *
	 * @since 21042006
	 * @author Yesenia Moreno
	 *
	 * @param array $la_data Arreglo de información.
	 * @param object $io_pdf Objeto pdf.
	 *
	 * @return void.
	 */
	function uf_print_detalle($la_data,&$io_pdf)
	{
		$io_pdf->ezSetDy(-10);
		$la_columna=array('codact'=>'<b>Codigo</b>',
						  'denact'=>'<b>Activo</b>',
						  'ideact'=>'<b>No. de Bienes Nacionales</b>', // Modificado por Jos� Luis Aguilera OPSU - CTSI 22/05/2012
						  'desmov'=>'<b>Descripcion del Movimiento</b>',
						  'monact'=>'<b>Monto Bs.</b>');
		$la_config=array('showHeadings'=>1, // Mostrar encabezados
						 'fontSize' => 8, // Tama�o de Letras
						 'titleFontSize' => 8,  // Tama�o de Letras de los t�tulos
						 'showLines'=>1, // Mostrar L�neas
						 'shaded'=>0, // Sombra entre l�neas
						 'width'=>500, // Ancho de la tabla
						 'maxWidth'=>500, // Ancho M�ximo de la tabla
						 'xOrientation'=>'center', // Orientaci�n de la tabla
						 'cols'=>array('codact'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'denact'=>array('justification'=>'center','width'=>110), // Justificaci�n y ancho de la columna
						 			   'ideact'=>array('justification'=>'center','width'=>80), // Justificaci�n y ancho de la columna
						 			   'desmov'=>array('justification'=>'center','width'=>155), // Justificaci�n y ancho de la columna
						 			   'monact'=>array('justification'=>'right','width'=>75))); // Justificaci�n y ancho de la columna
		$io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_detalle

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//       Function: uf_print_totales
//		   Access: private
//	    Arguments: la_data // arreglo de informaci�n
//	   			   io_pdf // Instancia de objeto pdf
//    Description: funci�n que imprime el detalle por personal
//	   Creado Por: Ing. Yesenia Moreno
// Fecha Creaci�n: 06/07/2006
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function uf_print_totales($la_data,&$io_pdf)
{
    $la_columna=array(
        'total'=>'',
        'monact'=>''
    );
    $la_config=array(
        'showHeadings'=>0, // Mostrar encabezados
        'fontSize' => 8, // Tama�o de Letras
        'titleFontSize' => 11,  // Tama�o de Letras de los t�tulos
        'showLines'=>1, // Mostrar L�neas
        'shaded'=>0, // Sombra entre l�neas
        'width'=>500, // Ancho de la tabla
        'maxWidth'=>500, // Ancho M�ximo de la tabla
        'xOrientation'=>'center', // Orientaci�n de la tabla
        'cols'=>array(
            'total'=>array('justification'=>'right','width'=>425), // Justificaci�n y ancho de la columna
            'monact'=>array('justification'=>'right','width'=>75)
        )
    ); // Justificaci�n y ancho de la columna
    $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
    $la_data=array(array('name'=>''));
    $la_columna=array('name'=>'');
    $la_config=array(
        'showHeadings'=>0, // Mostrar encabezados
        'showLines'=>0, // Mostrar L�neas
        'shaded'=>0, // Sombra entre l�neas
        'width'=>500, // Ancho M�ximo de la tabla
        'xOrientation'=>'center'
    ); // Orientaci�n de la tabla
    $io_pdf->ezTable($la_data,$la_columna,'',$la_config);
	}// end function uf_print_totales
	//--------------------------------------------------------------------------------------------------------------------------------

function uf_print_firmas(&$io_pdf)
{
    $io_pdf->setStrokeColor(0,0,0);
    // cuadro inferior
    // Rectangulo
    $io_pdf->Rectangle(50,40+80,500,70);
    // Lineas Horizontales
    $io_pdf->line(50,53+80,550,53+80);
    $io_pdf->line(50,97+80,550,97+80);
    // Lineas Verticales
    $io_pdf->line(216,40+80,216,110+80);
    $io_pdf->line(383,40+80,383,110+80);
    // Titulos y Rotulos del cuadro
    // Cuadro 1: Elaborado por
    $io_pdf->addText(115,102+80,7,"ELABORADO"); // Agregar el t�tulo
    //$io_pdf->addText(55,85,7,"Nombre de Usuario"); // Agrega el Nombre de usuario que hace el registro por sistema
    $io_pdf->addText(55,65+80,7,"Firma:");  // agrega firma
    $io_pdf->addText(55,45+80,7,"Fecha: ".$ad_fecha); // agrega la fecha de emisici�n de la incorporaci�n
    // Cuadro 2: Revisado por Supervisor de Bienes Nacionales/Públicos
    $io_pdf->addText(235,102+80,7,"SUPERVISOR DE BIENES PUBLICOS"); // Agregar el t�tulo
    $io_pdf->addText(220,85+80,7,"Nombre y Apellido:"); // Agrega el Nombre de usuario que hace el registro
    $io_pdf->addText(220,65+80,7,"Firma / Sello:"); // agrega firma para colocar en Autorizaci�n
    $io_pdf->addText(220,44+80,7,"Fecha: _________/_________/__________"); // agrega la fecha para colocar la fecha de Autorizaci�n
    // Cuadro 3: Jefe de la Unidad Administrativa
    $io_pdf->addText(405,102+80,7,"JEFE DE LA UNIDAD ADMINISTRATIVA"); // Agregar el t�tulo
    $io_pdf->addText(390,85+80,7,"Nombre y Apellido:"); // Agrega el Nombre de usuario que hace el registro
    $io_pdf->addText(390,65+80,7,"Firma / Sello:"); // agrega firma para colocar en Atorizaci�n
    $io_pdf->addText(390,44+80,7,"Fecha: _________/_________/__________"); // agrega la fecha para colocar la fecha de Autorizaci�n
    /* */
    $io_pdf->Rectangle(50,40,500-167,70);
    // Lineas Horizontales
    $io_pdf->line(50,53,550-167,53);
    $io_pdf->line(50,97,550-167,97);
    // Lineas Verticales
    $io_pdf->line(216,40,216,110);
    //
    $io_pdf->addText(115-35,102,7,"RESPONSABLE ADMINISTRATIVO");
    $io_pdf->addText(55,85,7,"Nombre y Apellido:");
    $io_pdf->addText(55,65,7,"Firma / Sello:");
    $io_pdf->addText(55,44,7,"Fecha: _________/_________/__________");
    //
    $io_pdf->addText(235+25,102,7,"RESPONSABLE DE USO");
    $io_pdf->addText(220,85,7,"Nombre y Apellido:");
    $io_pdf->addText(220,65,7,"Firma / Sello:");
    $io_pdf->addText(220,44,7,"Fecha: _________/_________/__________");
}

unset($io_report);
unset($io_funciones);
unset($io_fun_nomina);
?>
