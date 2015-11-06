<?php 	session_start();?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link rel="stylesheet" type="text/css" media="all" href="../../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../../../Clases/Js/NoClick.js"></script>
<script type="text/javascript" src="../../../../Clases/js/CP.js"></script>
<script>
function cambia(id)
{
	if (!document.getElementById) return false;
  fila = document.getElementById(id);
  if(document.frm.camion.value=="T")
  fila.style.display="";
  else
   if(document.frm.camion.value!="T")
     fila.style.display="none";

}
</script>
<?php
include("../../../../inc/php/conexiones/SCA.php");
include("../../../../Clases/Funciones/Catalogos/Genericas.php");
$seg=$_REQUEST["seg"];
$fini2=$_REQUEST["inicial"];
$ffin2=$_REQUEST["final"];
$estatus=$_REQUEST[estatus];
$camion=$_REQUEST[camion];
 ?>

<body onLoad="cambia('radios')" >

<table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="Titulo">SCA.- Reporte de Viajes Manuales Por Cami&oacute;n</td>
  </tr>
  <tr>
    <td class="Subtitulo">&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">&nbsp;</td>
  </tr>
</table>
<form name="frm" action="2Muestra.php" method="post">
<table width="330" border="0" align="center" >
  <tr>
    <td width="20" rowspan="5">&nbsp;</td>
    <td colspan="6" class="Subtitulo">Seleccione el Rango de Fechas a Consultar:</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="30">&nbsp;</td>
    <td colspan="2" class="Concepto"> &nbsp;Fecha&nbsp;Inicial:</td>
    <td width="63"><input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $fini2; ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/></td>
    <td width="34"><img src="../../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" /></td>
    <td width="24">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="Concepto">&nbsp;Fecha&nbsp;Final: </td>
    <td><span class="FondoSeriesUno">
      <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $ffin2; ?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/>
    </span></td>
    <td><span class="FondoSeriesUno"><img src="../../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" /></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<table width="400" border="0" align="center" >
  <tr>
    <td width="195"  valign="top"><fieldset class="textoG" title="Consultas por Camión">
      
      <legend><label style="cursor:hand" onClick="if(document.getElementById('camion').value=='T') document.getElementById('radios').style.display=''; else document.getElementById('radios').style.display='none';document.getElementById('camion').disabled=false;document.getElementById('sindicato').disabled=true"><input name="tipo_consulta" type="radio" value="camion" checked id="consulta_camion">Consulta por Camión</label></legend>
      
      <?php 
	  $IdProyecto=$_SESSION['Proyecto'];
	$sql="Select Economico, IdCamion from camiones where IdProyecto=".$IdProyecto." and IdCamion in (Select IdCamion from viajes) order by Economico";
	$sql="Select distinct(Economico), IdCamion from camiones join
viajes using(IdCamion)
 where viajes.IdProyecto=".$IdProyecto."";
	$link=SCA::getConexion();
	$r=$link->consultar($sql);
	
	?>
      <table align="center" width="100%">
        <tr>
          <td class="separacion">-gln-</td>
          </tr>
        <tr>
          <td align="center"><select name="camion" onChange="if(document.getElementById('consulta_camion').checked==true)cambia('radios')" id="camion">
            <option value="T" <?php if($camion=="T"){ ?> selected="selected" <?php }?>>- Todos -</option>
            <?php while($v=mysql_fetch_array($r))
		{?>
            <option value="<?php echo $v[IdCamion]; ?>" <?php if($camion==$v[IdCamion]) {?> selected="selected" <?php }?>><?php echo $v[Economico]; ?></option>
            <?php }?>
            </select></td>
          </tr>
        <tr>
          <td class="separacion">-gln-</td></tr></table>
      </fieldset></td>
    <td width="195" align="center" class="texto" valign="top"><fieldset class="textoG" title="Consulta por Sindicato">
      <legend><label style="cursor:hand"><input name="tipo_consulta" type="radio" value="sindicato" onClick="document.getElementById('radios').style.display='';document.getElementById('camion').disabled=true;document.getElementById('sindicato').disabled=false">Consulta por Sindicato</label></legend>
      <?php 
	  $sql="select distinct(IdSindicato),Sindicato from (Select c.Economico, c.IdCamion, c.IdSindicato as IdSindicato, s.NombreCorto as Sindicato from camiones as c, sindicatos as s where c.IdProyecto=".$IdProyecto." and c.IdCamion in (Select IdCamion from viajes) and s.IdSindicato=c.IdSindicato order by Sindicato) as tabla";
	  //echo $sql;
	   $sql="select distinct(s.IdSindicato), s.NombreCorto as Sindicato
from viajes as v join camiones as c using(IdCamion) join
sindicatos as s using(IdSindicato) where v.IdProyecto=".$IdProyecto."";
	$r=$link->consultar($sql);
	$size=$link->affected();
	if($size>5)
	$size=5;
	  ?>
      <table>
        <tr>
          <td class="separacion">-gln-</td>
          </tr>
        <tr>
          <td><select name="sindicato[]" id="sindicato" >
            <?php while($v=mysql_fetch_array($r))
		{?>
            <option value="<?php echo $v[IdSindicato] ?>" selected><?php echo $v[Sindicato] ?></option>
            <?php } ?>
            </select></td>
          </tr>
        <tr>
          <td class="separacion">-gln-</td>
          </tr>
        </table>
      </fieldset></td>
  </tr>
  </table>
  <table width="330" border="0" align="center" >
  <tr>
    <td width="19">&nbsp;</td>
    <td align="center" class="texto">&nbsp;</td>
    <td class="texto" align="center">&nbsp;</td>
  </tr>
  <tr id="radios">
    <td width="19">&nbsp;</td>
    <td align="center" class="texto"><label style="cursor:hand"><input name="estatus" type="radio" value="1" <?php if ($seg!=1||$estatus==1) { ?> checked <?php }?>>
      Cam. Activos</label>
      <label style="cursor:hand">
        <input name="estatus" type="radio" value="0" <?php if ($seg==1&&$estatus==0) { ?> checked <?php }?>>
        Cam. Inactivos </label>
      <label style="cursor:hand">
        <input name="estatus" type="radio" value="3" <?php if ($seg==1&&$estatus==3) { ?> checked <?php }?>>
        Ambos</label></td>
    <td class="texto" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="19">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="19">&nbsp;</td>
    <td><div align="center">
        <input name="Submit" type="submit" class="Boton" value="Consultar Reporte">
        <input type="hidden" name="usr" value="<?php echo $usr;?>">
    </div></td>
    <td>&nbsp;</td>
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
