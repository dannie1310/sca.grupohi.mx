<?php 
session_start();    
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">




<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link rel="stylesheet" type="text/css" media="all" href="../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript" src="../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../Clases/js/CP.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>


       
</head>

<body >
<form  name="frm" enctype="multipart/form-data" class="formulariofile" method="post" action="ValidaViajes.php">
<table width="530" border="0" align="center" >
  <tr>
    <td width="21" rowspan="6">&nbsp;</td>
    <td colspan="5" class="Subtitulo">Seleccione el Rango de Fechas a Consultar:</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="51">&nbsp;</td>
    <td width="160" class="Concepto"> &nbsp;Fecha y Hora Inicial:</td>
    <td width="160">
      <span class="FondoSeriesUno">
        <img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" />
        <input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php echo date("d-m-Y"); ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/>
      </span>
    </td>
  
    <td width="28">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="Concepto">&nbsp;Fecha y Hora Final: </td>
    <td>
      <span class="FondoSeriesUno">
        <img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" />
        <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" value="<?php echo date("d-m-Y"); ?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/>
      </span>
    </td>

    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><div align="center">
    <!--          <input id="buscar" type="button" class="Boton vista_previa" value="Buscar">   -->
        <input id="buscar" type="submit" class="Boton vista_previa" value="Buscar"> 
    </div></td>
  </tr>
</table>
</form>
<div id="tabla">
</div>

</body>


</html>
<script type="text/javascript" src="../../inc/js/jquery-1.4.4.js"></script>
<script>
/*
var datosG;
datosG = $("form").serialize();
$.post("ValidaViajes.php",datosG,function(data){
    $("#tabla").html(data);
});

$("#buscar").click(function(){
    datosG = $("form").serialize();
    $.post("ValidaViajes.php",datosG,function(data){
        $("#tabla").html(data);
    });

});
*/


</script>
<script type="text/javascript">
    function catcalc(cal) 
    {
    }
        Calendar.setup({
        inputField     :    "FechaInicial",         
        button         :    "boton",
        ifFormat       :    "%d-%m-%Y",       
        showsTime      :    false,
        timeFormat     :    "24",
        onUpdate       :    catcalc
            });
</script>
<script type="text/javascript">
    function catcalc(cal) {
            }
            Calendar.setup({

                inputField     :    "FechaFinal",           
                button         :    "boton2",
                ifFormat       :    "%d-%m-%Y",       
                showsTime      :    false,
                timeFormat     :    "24",
                onUpdate       :    catcalc
            });
</script>