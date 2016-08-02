function ue_generar_disk()
{
    data="reportes/sigesp_saf_rpp_activo_simple.php";
    var object = "<object height='1250px' width='100%' type='application/pdf' data='\{FileName}\'>";
       object += "No se puede mostrar el archivo.";
       object += "</object>";
       object = object.replace(/{FileName}/g, data);
    $('#PDF').html(object);
    $( "#myModal" ).modal('show');
}

function ue_ayuda()
{
    window.open("/doc/saf/sigesp_saf_r_activo_simple.md","fullscreen=yes,menubar=no,toolbar=no,scrollbars=yes");
}
