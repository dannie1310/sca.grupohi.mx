<?php
	session_start();
        if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<link rel="stylesheet" type="text/css" media="all" href="../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<title>.::GLN.-Sistema de Control de Acarreos::.</title></head>

<body onkeydown="backspace();">
<?php
	//Incluimos los Archivos a Usar

		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/Catalogos/Genericas.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");

	//Obtenemos los Totales a Trabajar
		$TotalViajesCompletos=RegresaTotalViajesCompletosCargados($_SESSION['Proyecto']);
		$TotalViajesIncompletos=RegresaTotalViajesIncompletosCargados($_SESSION['Proyecto']);
		$TotalViajesManuales=RegresaTotalViajesManualesCargados($_SESSION['Proyecto']);

?>

<table width="845" border="0" cellpadding="0" cellspacing="0" align="center">
  
  <tr> </tr>
</table>
<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/Logos/Gral/24-tag-manager.png" alt="" width="24" height="24" align="absbottom" />SCA.- Modificaci&oacute;n de Viajes      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoMenu">Usted tiene los siguientes viajes disponibles a modificar.</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> </tr>
</table>
<table width="415" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="53">&nbsp;</td>
    <td width="123">&nbsp;</td>
  </tr>

  <tr>
    <td width="51">&nbsp;</td>
    <td width="160" class="Concepto"> &nbsp;Fecha Inicial:</td>
    <td width="160" align="right">
      <span class="FondoSeriesUno">
        <img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" />
        <input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php echo date("d-m-Y"); ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/>
      </span>
    </td>
  
    <td width="28">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="Concepto">&nbsp;Fecha Final: </td>
    <td align="right">
      <span class="FondoSeriesUno" align=center>
        <img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" />
        <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" value="<?php echo date("d-m-Y"); ?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/>
      </span>
    </td>
  </tr>

  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="53">&nbsp;</td>
    <td width="123">&nbsp;</td>
  </tr>

  <tr>
      <!--<input name="tipo" type="hidden" value="0" />-->
      <td width="34"><img src="../../Imgs/16-PuntaVerde.gif" width="24" height="24" /></td>
      <td width="205" class="Item1">Viajes Con Or&iacute;gen:</td>
      <td class="Item1"><?php echo $TotalViajesCompletos; ?></td>
      <td class="Item1"><input name="vista_previa" type="button" class="boton vista_previa" value="Modificar" idvalor="0">
  </tr>
  <tr>
      <!--<input name="tipo" type="hidden" value="10" />-->
      <td><img src="../../Imgs/16-PuntaVerde.gif" width="24" height="24" /></td>
      <td class="Item1">Viajes Sin Or&iacute;gen:</td>
      <td class="Item1"><?php echo $TotalViajesIncompletos; ?></td>
      <td class="Item1"><input name="vista_previa" type="button" class="boton vista_previa" value="Modificar" idvalor="10">
      </td>
  </tr>
  <tr>
      <!--<input name="tipo" type="hidden" value="20" />-->
      <td><img src="../../Imgs/16-PuntaVerde.gif" width="24" height="24" /></td>
      <td class="Item1">Viajes Cargados Manualmente:</td>
      <td class="Item1"><?php echo $TotalViajesManuales; ?></td>
      <td class="Item1"><input name="vista_previa" type="button" class="boton vista_previa" value="Modificar" idvalor="20">
      <!--<td class="Item1"><input name="Validar" type="submit" class="boton" id="Validar" value="Modificar" />-->
      </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript" src="../../inc/js/jquery-1.4.4.js"></script>
<script>
$(document).ready(function() {
    $(".vista_previa").click(function(){
      //$("form").submit();
      
      tipo = $(this).attr('idvalor');
      fechainicial = $("#FechaInicial").val();
      fechafinal = $("#FechaFinal").val();
     document.location.href='2MuestraDatos.php?v=0&inicial='+fechainicial+'&final='+fechafinal+'&tipo='+tipo;
      });
  });
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