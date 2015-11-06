<?php 
session_start();
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition:  filename=Relacion_de_Rutas_'.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	$IdProyecto=$_SESSION['Proyecto'];
	include("../../../inc/php/conexiones/SCA.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style type="text/css">
.encabezado
{
	color: #0070B3;
	background-color: #F2F2F2;
	font-weight: bold;
	font-size: 12px;
	border: 1px #a4a4a4 solid;
	text-align:center;
	font-family:Calibri,Trebuchet,Arial;
	color: #069;
	margin:0px;
}
.detalle
{
	color: #0070B3;
	font-size: 12px;
	font-family:Calibri,Trebuchet,Arial;
	color: #069;
	margin:0px;
}
body
{
	font-family:Calibri,Trebuchet,Arial;
	color: #069;
	margin:0px;
	font-family:Calibri,Trebuchet,Arial;
	color: #069;
	margin:0px;
}
</style>
</head>

<body>
<table  style="margin-left:20%;width:60%"  cellspacing="0" cellpadding="2">
<tr  >
		    <td  class="encabezado" colspan="8" align="center" style="border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Ruta</td> <td class="encabezado"  colspan="3" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Cronometr&iacute;a Activa</td>
      </tr>
  <tr >
    <td class="encabezado" align="center" style="border:#D4D4D4 solid 1px">Ruta</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Origen</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiro</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tipo de Ruta</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> 1er. KM</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />
    Subsecuentes</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />
    Adicionales</td>
			<td class="encabezado" align="center" style="width:70px;border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">KM<br />
    Total</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>
    Minimo</td>
			<td class="encabezado" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>
    Tolerancia</td>
	<td align="center" class="encabezado" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Fecha/Hora<br/>
    Registro</td>
  </tr>
  <?php 
  $l = SCA::getConexion();
  $SQLs = "SELECT concat(r.Clave,r.IdRuta) as ruta,r.*, o.Descripcion as origen, t.Descripcion as tiro, tr.Descripcion as tipo_ruta, if(c.TiempoMinimo is null,'- - - ',c.TiempoMinimo) as minimo,
if(c.Tolerancia is null,'- - - ',c.Tolerancia) as tolerancia,
if(c.FechaAlta is null,'- - - ',Concat(date_format(c.FechaAlta,'%d-%m-%Y'),' / ',c.HoraAlta)) as fecha_hora from cronometrias as c right join rutas as r on(c.IdRuta=r.IdRuta and c.Estatus=1) join origenes as o on(r.IdOrigen=o.IdOrigen) join tiros as t on(t.IdTiro=r.IdTiro) join tipo_ruta as tr on(tr.IdTipoRuta=r.IdTipoRuta) where r.IdProyecto=".$IdProyecto." and r.Estatus=1";
		  $r=$l->consultar($SQLs);
		  while($v=$l->fetch($r))
		  {
  $filas.='<tr class="detalle">
		  	<td style="text-align:center;border-bottom:#D4D4D4 solid 1px; border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px">'.$v["ruta"].'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["origen"].'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["tiro"].'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["tipo_ruta"].'</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["PrimerKm"].' km</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["KmSubsecuentes"].' km</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["KmAdicionales"].' km</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["TotalKM"].' km</td>
			<td style="text-align:center;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["minimo"].'</td>
			<td style="text-align:center;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["tolerancia"].'</td>
			<td style="text-align:center;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["fecha_hora"].'</td>
		  </tr>';
 } echo $filas;?>
</table>
</body>
</html>