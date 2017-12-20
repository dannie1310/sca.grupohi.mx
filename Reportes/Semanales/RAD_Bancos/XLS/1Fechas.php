<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}
?>
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
	include ("../../../../inc/php/conexiones/SCA.php");
 ?>

<body >

<form name="frm" action="2Muestra.php" method="post">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="Titulo">SCA.- Reporte de Avance Diario Detallado por Tipo de Origen y Material</td>
    </tr>
    <tr>
      <td class="Subtitulo">(R.A.D.)</td>
    </tr>
    <tr>
      <td class="Subtitulo">&nbsp;</td>
    </tr>
  </table>
  <table width="350" border="0" align="center" >
  <tr>
    <td width="21" rowspan="7">&nbsp;</td>
    <td colspan="5" class="Subtitulo">Seleccione el Rango de Fechas a Consultar:</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="51">&nbsp;</td>
    <td width="115" class="Concepto"> &nbsp;Fecha Inicial:</td>
    <td width="59"><input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $fini2; ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/></td>
    <td width="30"><img src="../../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" /></td>
    <td width="28">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="Concepto">&nbsp;Fecha Final: </td>
    <td><span class="FondoSeriesUno">
      <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $ffin2; ?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/>
    </span></td>
    <td><span class="FondoSeriesUno"><img src="../../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" /></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="Subtitulo">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5" class="Subtitulo">Seleccione el tipo de origen que se desglosar&aacute;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" class="texto"><?php $link=SCA::getConexion();
$sql="select * from tiposorigenes where Estatus=1";
$row=$link->consultar($sql);

while($v=mysql_fetch_array($row)){  ?><label style="cursor:hand"><input name="<?php echo $v[IdTipoOrigen] ?>" type="checkbox" value="1"><?php echo $v[Descripcion] ?></label>&nbsp;<?php }?></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center">
      <input name="Submit" type="submit" class="boton" value="Consultar Reporte">
      <input type="hidden" name="usr" value="<?php echo $usr;?>">
    </td>
  </tr>
</table>
</form>

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