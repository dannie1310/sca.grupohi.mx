<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link rel="stylesheet" type="text/css" media="all" href="../../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../../../Clases/js/CP.js"></script>
<script type="text/javascript" src="../../../../Clases/Js/NoClick.js"></script>

<?php
$seg=$_REQUEST["seg"];
$fini2=$_REQUEST["inicial"];
$ffin2=$_REQUEST["final"];
 ?>

<body >

<table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="Titulo">SCA.- Reporte de Viajes Netos</td>
  </tr>
  <tr>
    <td class="Subtitulo">&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">&nbsp;</td>
  </tr>
</table>
<form name="frm" action="2Muestra.php?v=1" method="post">
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
        <img src="../../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" />
        <input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $fini2; ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/>
        <input name="horaInicial"  type="time" id="horaInicial" class="text" value="00:00:00" step="1" />
      </span>
    </td>
  
    <td width="28">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="Concepto">&nbsp;Fecha y Hora Final: </td>
    <td>
      <span class="FondoSeriesUno">
        <img src="../../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" />
        <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" style="heigth:54" value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $ffin2; ?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/>
        <input name="horaFinal"  type="time" id="horaFinal" class="text" value="23:59:00" step="1" />
      </span>
    </td>

    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
      <td class="Concepto">
        Seleccionar estatus
      </td>
      <td align="center">
        <span>
          <select name="estatus" id="estatus">
            <option value=2>Todos</option>
            <option value=0>S&iacute;n Validar</option>
            <option value=1>Validado</option>
          </select>
        </span>
      </td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><div align="center">
      <input name="Submit" type="submit" class="Boton" value="Consultar Excel">
	  <input name="vista_previa" type="button" class="Boton vista_previa" value="Vista Previa">
      <input type="hidden" name="usr" value="<?php echo $usr;?>">
    </div></td>
  </tr>
</table>
</form>
<script type="text/javascript" src="../../../../inc/js/jquery-1.4.4.js"></script>
<script>
$(document).ready(function() {
	  $(".vista_previa").click(function(){
		  //$("form").submit();
		  fechainicial = $("#FechaInicial").val();
		  fechafinal = $("#FechaFinal").val();
      horaInicial = $("#horaInicial").val();
      horaFinal = $("#horaFinal").val();
      estatus =  $("#estatus").val();
		  document.location.href='2Muestra.php?v=0&inicial='+fechainicial+'&final='+fechafinal+'&horaInicial='+horaInicial+'&horaFinal='+horaFinal+'&estatus='+estatus;
		  });
	});
</script>
<script type="text/javascript">
	function catcalc(cal) 
	{
	}
		Calendar.setup({
		inputField     :    "FechaInicial",			
		button		   :	"boton",
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
				button		   :	"boton2",
				ifFormat       :    "%d-%m-%Y",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
</script>
</body>
</html>
