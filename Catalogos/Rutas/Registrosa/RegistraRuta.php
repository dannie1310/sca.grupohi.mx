<?php 

	session_start();
	include("../../../inc/php/conexiones/SCA.php");
	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");
	require_once("funciones_xajax.php");

	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	$l = SCA::getConexion();

	
	$xajax->register(XAJAX_FUNCTION,"registra_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_registro_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_consulta_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_modifica_ruta");
	$xajax->register(XAJAX_FUNCTION,"tarifa_ruta");




	$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administraci&oacute;n de Rutas</title>
<link href="../../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
 <?php
   $xajax->printJavascript("../../../Clases/xajax/");
 ?>
<style type="text/css">
<!--
body {
	background-color: #EEE;
}
-->
</style></head>
<?php 

?>

<body>
<div id="layout">
<div id="encabezado_pagina" style="width:100%;"><img src="../../../Imagenes/reload_48x48.gif" width="48" height="48" />Administraci&oacute;n de Rutas</div>
<div class="detalle" id="tipos" style="width:100%;margin-top:20px;"><span class="boton" onclick="xajax_muestra_registro_ruta()"><img src="../../../Imagenes/add.gif" width="24" height="24" align="absbottom" />&nbsp;Registro</span>&nbsp;&nbsp;<span class="boton" onclick="xajax_tarifa_ruta()"><img src="../../../Imagenes/Edit_24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Modificaci&oacute;n</span>&nbsp;&nbsp;<span class="boton" onclick="xajax_muestra_consulta_ruta()"><img src="../../../Imagenes/search.gif" width="24" height="24" align="absbottom" />&nbsp;Consulta</span>
  
</div>
<div id="contenido" style="margin-top:15px">
<table  border="0" cellspacing="0" cellpadding="2" style="margin-left:20%;width:60%">
  <tr class="encabezado">
		    <td colspan="8" align="center" style="border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Ruta</td><td colspan="2" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Cronometr&iacute;a Activa</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">&nbsp;</td>
      </tr>
		  <tr class="encabezado">
			<td style="border:#D4D4D4 solid 1px">Ruta</td>
            <td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Origen</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiro</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tipo de Ruta</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> 1er. KM</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />Subsecuentes</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />Adicionales</td>
			<td style="width:70px;border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">KM<br />Total</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>M&iacute;nimo</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tolerancia</td>
			<td style="border-right:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">&nbsp;</td>
		  </tr>
          <tbody id="body_rutas">
          <?php 
		  $SQLs = "SELECT
		  if(r.KmAdicionales='',0,r.KmAdicionales) as KmAdicionales_v,
count(v.IdViaje) as NoViajes,
concat(r.Clave,r.IdRuta) as ruta,r.*, o.Descripcion as origen, t.Descripcion as tiro,
tr.Descripcion as tipo_ruta,
if(c.TiempoMinimo is null,'',
c.TiempoMinimo) as minimo,
if(c.Tolerancia is null,'',c.Tolerancia) as tolerancia,
if(c.FechaAlta is null,'',Concat(date_format(c.FechaAlta,'%d-%m-%Y'),' / ',c.HoraAlta)) as fecha_hora
from
cronometrias as c right join
rutas as r on(c.IdRuta=r.IdRuta and c.Estatus=1) join
origenes as o on(r.IdOrigen=o.IdOrigen) join
tiros as t on(t.IdTiro=r.IdTiro) join tipo_ruta as tr on(tr.IdTipoRuta=r.IdTipoRuta) left join viajes as v on(r.IdRuta=v.IdRuta)
where
r.Estatus=1 group by r.IdRuta";
$r=$l->consultar($SQLs);
$i=0;
		  while($v=$l->fetch($r))
		  {
			  if($v["NoViajes"]>0)
			  {
			  $iks=$v["KmSubsecuentes"].' km';
			  $ika=$v["KmAdicionales_v"].' km <input name="tk'.$i.'" id="tk'.$i.'" type="hidden" value="" />';
			  $boton_eliminar='';
			  }
			  else
			  {
			$iks='<input name="ks'.$i.'" id="ks'.$i.'" type="text" size="3"   class="monetario" onkeyup="agrega('.$i.')"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega('.$i.')" value="'.$v["KmSubsecuentes"].'"/>';
			  $ika='<input name="ka'.$i.'" id="ka'.$i.'" type="text" size="3"  class="monetario" onkeyup="agrega('.$i.')"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega('.$i.')" value="'.$v["KmAdicionales_v"].'" /> <input name="tk'.$i.'" id="tk'.$i.'" type="hidden" value="" />';
			$boton_eliminar='<input name="eliminar<?php echo $i; ?>" id="eliminar<?php echo $i; ?>" type="image" src="../../../Imagenes/eliminar_inc.gif" onmouseover="this.src=\'../../../Imagenes/eliminar.gif\'" onmouseout="this.src=\'../../../Imagenes/eliminar_inc.gif\'" onclick="valida_elimina('.$i.',\''.$v["IdRuta"].'\',\''.$v["ruta"].'\')" />';
			
			}
			$tm='<input name="tm'.$i.'" id="tm'.$i.'" type="text" size="3" value="'.$v["minimo"].'"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />';
			  $tol='<input name="tol'.$i.'" id="tol'.$i.'" type="text" size="3" value="'.$v["tolerancia"].'"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />';
			  
			  $lista_tipo_rutas=$l->regresaSelect_evt("tipo_ruta","Descripcion, IdTipoRuta","tipo_ruta","Estatus=1","IdTipoRuta","Descripcion","desc","150px","1","0","1","",$v["IdTipoRuta"],"r");
			  
		
		  ?>
  <tr id="fila_<?php echo $i; ?>" class="detalle">
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px; border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px"><?php echo $v["ruta"]?></td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px"><?php echo $v["origen"]?></td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px"><?php echo $v["tiro"]?></td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px"><?php echo $lista_tipo_rutas; ?></td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px">1 km<input name="pk<?php echo $i; ?>" id="pk<?php echo $i; ?>" type="hidden" value="1" /></td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" ><?php echo $iks; ?></td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px"><?php echo $ika; ?></td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" id="cell_tk<?php echo $i; ?>"><?php echo $v["TotalKM"]?>&nbsp;km</td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px"><?php echo $tm; ?></td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px"><?php echo $tol; ?></td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px;text-align:left"><input name="guardar<?php echo $i; ?>" id="guardar<?php echo $i; ?>" type="image" src="../../../Imagenes/Guardar_inc.gif" onmouseover="this.src='../../../Imagenes/Guardar.gif'" onmouseout="this.src='../../../Imagenes/Guardar_inc.gif'" onclick="" />&nbsp;<?php echo $boton_eliminar ?></td>
  </tr>
  <?php 
  $i++;
  }
  ?>
  </tbody>
</table>

</div>
</div>
</body>
<script>

</script>
<script type="text/javascript" src="funciones_js.js"></script>

<script type="text/javascript" src="../../../Clases/Js/NoClieck.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/ValidaFormulario.js"></script>
<script type="text/javascript" src="../../../Clases/Js/MuestraLoad.js"></script>

</html>