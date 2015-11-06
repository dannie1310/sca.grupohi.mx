<?php 
session_start();
	//include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Configuracion.php");
	include("../../inc/php/conexiones/SCA.php");
	require_once("../../Clases/xajax/xajax_core/xajax.inc.php");
	require_once("funciones_xjx.php");	
	
	function horas($dec) {
		$hours = $dec/60;
		$var = explode(".",$hours);
		$hours = $var[0];
		$mins = (($var[1]*60)/10);
		if(strlen($hours)>1){
			$hours=$hours;
			}else{
				$hours='0'.$hours;
				}
		if(strlen($mins)>1){
			$mins=substr($mins,0,2);
			}else{
				$mins='0'.$mins;
				}
		$hora =  $hours.":".$mins;
		
		return $hora;
		
	}
	
	$l = SCA::getConexion(); 
	$xajax = new xajax(); 	
	//print_r($_SESSION);
	  $SQLs = "SELECT  DATE_FORMAT(viajesnetos.FechaLlegada,'%d-%m-%Y') as Fecha, viajesnetos.FechaLlegada as FechaO, COUNT(viajesnetos.IdViajeNeto) AS Total FROM viajesnetos WHERE (viajesnetos.Estatus = 0 OR viajesnetos.Estatus = 10 OR viajesnetos.Estatus = 20 )AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY viajesnetos.FechaLlegada;";
	
	$r=$l->consultar($SQLs);
	$condicion="";	
	
	$xajax->register(XAJAX_FUNCTION,"calculos_x_tipo_tarifa");
	$xajax->register(XAJAX_FUNCTION,"registra_viaje");
	$xajax->processRequest();
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <?php
   $xajax->printJavascript("../../Clases/xajax/");
 ?>
<title>Validaci&oacute;n de Viajes</title>
<link href="../../Estilos/Principal.css" rel="stylesheet" type="text/css" />

<style type="text/css">
<!--
body {
	background-color: #EEE;
}
#layout{ margin:0px}
-->
</style>
<?php nftcb($_SERVER['PHP_SELF']);?>
<script language="javascript" type="text/javascript">
$(function() {
    
	$('.tipo_tarifa').live("change",function(){
											 	i = $(this).attr("contador");
												xajax_calculos_x_tipo_tarifa($(this).attr("value"),xajax.$("material"+i).value,i,xajax.$('origen'+i).value,xajax.$('tiro'+i).value,xajax.$('camion'+i).value,xajax.$("idviaje"+i).value,xajax.$("tara"+i).value,xajax.$("bruto"+i).value);
													});
	$('.tipo_tarifa_p').live("keyup",function(){
											 	i = $(this).attr("contador");
												if(xajax.$("tarifa"+i).value=="p")
												xajax_calculos_x_tipo_tarifa(xajax.$("tarifa"+i).value,xajax.$("material"+i).value,i,xajax.$('origen'+i).value,xajax.$('tiro'+i).value,xajax.$('camion'+i).value,xajax.$("idviaje"+i).value,xajax.$("tara"+i).value,xajax.$("bruto"+i).value);
													});
	
  });
</script>
</head>

<body >
<div id="layout">
<div id="encabezado_pagina" style="width:100%;"><img src="../../Imagenes/aprobacion.gif" width="47" height="46" />Validaci&oacute;n de Viajes</div>
<div class="detalle" id="tipos" style="width:100%;margin-top:20px;display:none"><span class="boton" onclick="xajax_muestra_viajes('v.Estatus=10')"><img src="../../Imagenes/reload_24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Viajes Completos</span>&nbsp;&nbsp;<span class="boton" onclick="xajax_muestra_viajes('v.Estatus=10')"><img src="../../Imagenes/incompleto_24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Viajes Incompletos</span>&nbsp;&nbsp;<span class="boton" onclick="xajax_muestra_viajes('v.Estatus=10')"><img src="../../Imagenes/manules.gif" width="33" height="32" align="absbottom" />&nbsp;Viajes Manuales</span>
  
</div>
<div id="contenido" style="margin-top:15px">
<table style="width:100%;"border="0" cellspacing="0" cellpadding="2">
<?php 

$i_general=1;
$i_padre=1;
while($v=$l->fetch($r)) { ?>
  <tr>
    <td class="detalle"><img src="../../Imagenes/16-square-add.gif" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/16-square-blue-add.gif'" onmouseout="this.src='../../Imagenes/16-square-add.gif'" onclick="cambiarDisplay('<?php echo $v["FechaO"]?>');cambiarDisplay('a<?php echo $v["FechaO"]?>');cambiarDisplay('r<?php echo $v["FechaO"]?>')" id="a<?php echo $v["FechaO"]?>" /><img src="../../Imagenes/16-square-remove.gif" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/16-square-blue-remove.gif'" onmouseout="this.src='../../Imagenes/16-square-remove.gif'" onclick="cambiarDisplay('<?php echo $v["FechaO"]?>');cambiarDisplay('a<?php echo $v["FechaO"]?>');cambiarDisplay('r<?php echo $v["FechaO"]?>')" id="r<?php echo $v["FechaO"]?>" style="display:none" /><img src="../../Imagenes/calendario.jpg" width="16" height="18" align="absbottom"  />&nbsp;<?php echo $v["Fecha"] ?>&nbsp;=>&nbsp;<?php echo $v["Total"] ?> viajes</td>
  </tr>
  <tr  style="display:none" id="<?php echo $v["FechaO"]?>">
    <td><table style="width:97.5%;margin-left:2.5%"border="0" cellspacing="0" cellpadding="2">
    <?php
	$SQLs = "SELECT  t.IdTiro,t.Descripcion as Tiro,COUNT(v.IdTiro) AS Total FROM viajesnetos as v join tiros as t using (IdTiro) WHERE  v.FechaLlegada='".$v["FechaO"]."' AND (v.Estatus = 0 OR v.Estatus = 10 OR v.Estatus = 20 OR v.Estatus = 30 )AND v.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY  t.IdTiro;";
	//echo $SQLs;
	
	
	$r_tiros=$l->consultar($SQLs);
	
	while($v_tiros=$l->fetch($r_tiros)) { 
	?>
      <tr>
        <td class="detalle">
        <img src="../../Imagenes/16-square-add.gif" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/16-square-blue-add.gif'" onmouseout="this.src='../../Imagenes/16-square-add.gif'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>')" id="a<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>" /><img src="../../Imagenes/16-square-remove.gif" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/16-square-blue-remove.gif'" onmouseout="this.src='../../Imagenes/16-square-remove.gif'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>')" id="r<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>" style="display:none" /><img src="../../Imagenes/16-Destinos.gif" alt="c" width="16" height="16" align="absbottom" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>')"/>&nbsp;<?php echo $v_tiros["Tiro"] ?>&nbsp;=>&nbsp;<?php echo $v_tiros["Total"] ?> viajes</td>
      </tr>
      <tr style="display:none" id="<?php echo $v["FechaO"].$v_tiros["IdTiro"]?>">
        <td><table style="width:97.5%;margin-left:2.5%"border="0" cellspacing="0" cellpadding="2">
        <?php 
		$SQLs = "SELECT  c.IdCamion as IdCamion,c.Economico as Camion, COUNT(v.IdViajeNeto) AS Total FROM viajesnetos as v join camiones as c using (IdCamion) WHERE  v.FechaLlegada='".$v["FechaO"]."' AND v.IdTiro=".$v_tiros["IdTiro"]." AND (v.Estatus = 0 OR v.Estatus = 10 OR v.Estatus = 20 OR v.Estatus = 30 ) AND v.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY v.IdCamion;";

	
	$r_camiones=$l->consultar($SQLs);
	
	while($v_camiones=$l->fetch($r_camiones)) { 
	
	
		?>
        <script>
        var Arreglo_<?php echo $i_padre ?>=new Array();
		var Arreglo_Procesar_<?php echo $i_padre ?>=new Array();
        </script>
          <tr>
            <td class="detalle">            
            <img src="../../Imagenes/16-square-add.gif" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/16-square-blue-add.gif'" onmouseout="this.src='../../Imagenes/16-square-add.gif'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>')" id="a<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>" /><img src="../../Imagenes/16-square-remove.gif" width="16" height="16" class="boton" onmouseover="this.src='../../Imagenes/16-square-blue-remove.gif'" onmouseout="this.src='../../Imagenes/16-square-remove.gif'" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>');cambiarDisplay('a<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>');cambiarDisplay('r<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>')" id="r<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>" style="display:none" />
            
            <img src="../../Imagenes/Camiones.gif" alt="c" width="16" height="16" align="absbottom" onclick="cambiarDisplay('<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>')" />&nbsp;<?php echo $v_camiones["Camion"] ?>&nbsp;=>&nbsp;<?php echo $v_camiones["Total"] ?> viajes</td>
          </tr>
          <tr style="display:none" id="<?php echo $v["FechaO"].$v_tiros["IdTiro"].$v_camiones["Camion"]?>">
            <td><table border="0" cellpadding="2" cellspacing="0" class="formulario"  style="width:100%">
              <!--<tr>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center"><img src="../../Imagenes/material.gif" width="16" height="16" /></td>
                <td align="center"><img src="../../Imagenes/16-Origenes.gif" width="16" height="16" /></td>
                <td align="center"><img src="../../Imagenes/Materiales.gif" width="16" height="16" /></td>
                <td align="center"><img src="../../Imagenes/Cronometrias.gif" width="16" height="16" /></td>
                <td align="center"><img src="../../Imagenes/ruta24x24.gif" width="16" height="16" /></td>
                <td align="center"><img src="../../Imagenes/16-Distancia.gif" width="16" height="16" /></td>
                <td colspan="2" align="center">&nbsp;</td>
                <td colspan="3" align="center"><img src="../../Imagenes/Tarifassm.gif" width="16" height="16" /></td>
                
                <td align="center"><img src="../../Imagenes/AsignarCosto.gif" width="16" height="16" /></td>
                <td align="center">&nbsp;</td>
                <td align="center">&nbsp;</td>
                <td align="center" style="display:none">&nbsp;</td>
                <td align="center" style="display:none">&nbsp;</td>
              </tr>-->
              <tr class="Item">
                <td rowspan="2" align="center">#</td>
                <td rowspan="2" align="center">?</td>
                <td rowspan="2" align="center">Hora</td>
                <td rowspan="2" align="center"><img src="../../Imagenes/ok.gif" alt="" width="16" height="16" /></td>
                <td rowspan="2" align="center"><img src="../../Imagenes/ko.gif" alt="" width="16" height="16" /></td>
                <td rowspan="2" align="center">Cub<br />(m<sup>3</sup>)</td>
                <td rowspan="2" align="center">Or&iacute;gen<br />
				<?php $lista_origenes_padre=$l->regresaSelect_evt("origen_padre".$i_padre,"distinct(origenes.IdOrigen), concat(origenes.Clave,'-',origenes.IdOrigen) AS Clave, origenes.Descripcion","origenes join rutas on (rutas.IdOrigen=origenes.IdOrigen AND rutas.Estatus=1 AND rutas.IdTiro=".$v_tiros["IdTiro"].") ","origenes.IdProyecto = ".$_SESSION["Proyecto"]." AND origenes.Estatus = 1","IdOrigen","Descripcion","desc","100px","1","0","1"," onChange='cambia_origen_child(Arreglo_".$i_padre.",\"".$i_padre."\")'","","r");  echo $lista_origenes_padre;?></td>
                <td rowspan="2" align="center">Material</td>
                <td rowspan="2" align="center">Tiempo</td>
                <td rowspan="2" align="center">Ruta</td>
                <td rowspan="2" align="center">Distancia (Km)</td>
                <td colspan="2" align="center">Peso (Kg)</td>
		  <td colspan="3" align="center">Tarifa</td>
		  
		  <td rowspan="2" align="center">Importe</td>
                <td rowspan="2" align="center">Tipo de<br />Tarifa</td>
                <td rowspan="2" align="center">Tipo de<br />Fda</td>
                <td rowspan="2" align="center" style="display:none">Horas Efectivas</td>
                <td rowspan="2" align="center" style="display:none">Cargador</td>
                </tr>
		<tr class="Item">
		  <td align="center">Tara</td>
		  <td align="center">Bruto</td>
        <td align="center">Primer KM</td>
                
                <td align="center">KM Subsec.</td>
                <td align="center">KM Adic.</td>
              </tr>
                <?php 
				$SQLs = "
				select
				v.IdViajeNeto as IdViaje,
				v.Estatus,
				v.HoraLlegada as Hora,
				if(fa.FactorAbundamiento is null,0.00,fa.FactorAbundamiento) as FactorAbundamiento,
c.CubicacionParaPago as cubicacion,
o.Descripcion as origen,
o.IdOrigen as idorigen,
m.Descripcion as material,
m.IdMaterial as idmaterial,
TIMEDIFF(
        (CONCAT(FechaLlegada,' ',HoraLlegada)),
        (CONCAT(FechaSalida,' ',HoraSalida))
        ) as tiempo_mostrar,
ROUND((HOUR(TIMEDIFF(v.HoraLlegada,v.HoraSalida))*60)+(MINUTE(TIMEDIFF(v.HoraLlegada,v.HoraSalida)))+(SECOND(TIMEDIFF(v.HoraLlegada,v.HoraSalida))/60),2) AS tiempo,
concat('R-',r.IdRuta) as ruta,
r.TotalKM as distancia,
r.IdRuta as idruta,
tm.IdTarifa as tarifa_material,
tm.PrimerKM as tarifa_material_pk,
tm.KMSubsecuente as tarifa_material_ks,
tm.KMAdicional as tarifa_material_ka,
tr.IdTarifaTipoRuta as tarifa_ruta,
if(r.TotalKM>=30,4.40,if(tr.PrimerKM is null,'- - -',tr.PrimerKM))  as tarifa_ruta_pk,
if(r.TotalKM>=30,2.10,if(tr.KMSubsecuente is null,'- - -',tr.KMSubsecuente))  as tarifa_ruta_ks,
if(r.TotalKM>=30,0.00,if(tr.KMAdicional is null,'- - -',tr.KMAdicional))  as tarifa_ruta_ka,
cn.IdCronometria,
cn.TiempoMinimo,
cn.Tolerancia,
if(cn.TiempoMinimo-cn.Tolerancia is null,0.0,cn.TiempoMinimo-cn.Tolerancia) as cronometria,
if(r.TotalKM>=30,4.40*c.CubicacionParaPago,tr.PrimerKM*1*c.CubicacionParaPago) as ImportePK_R,
if(r.TotalKM>=30,2.10*r.KmSubsecuentes*c.CubicacionParaPago,tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago) as ImporteKS_R,
if(r.TotalKM>=30,0.00*r.KmAdicionales*c.CubicacionParaPago,tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago) as ImporteKA_R,

if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) as ImporteTotal_Rs,
if(if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) is null, '- - -',if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)))) as ImporteTotal_R,
tm.PrimerKM*1*c.CubicacionParaPago as ImportePK_M,
tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago as ImporteKS_M,
tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago as ImporteKA_M,
((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)) as ImporteTotal_M
from
viajesnetos as v join
camiones as c using(IdCamion) left join
origenes as o using(IdOrigen) join
materiales as m using(IdMaterial) left join tarifas as tm on(tm.IdMaterial=m.IdMaterial AND tm.Estatus=1) left join
factorabundamiento as fa on (m.IdMaterial=fa.IdMaterial and fa.Estatus=1) left join
 rutas as r on(v.IdOrigen=r.IdOrigen AND v.IdTiro=r.IdTiro AND r.Estatus=1) left join
tarifas_tipo_ruta as  tr on(tr.IdTipoRuta=r.IdTipoRuta AND tr.Estatus=1) left join cronometrias as cn on (cn.IdRuta=r.IdRuta AND cn.Estatus=1)
WHERE 
(v.Estatus = 0 OR v.Estatus = 10 OR v.Estatus = 20 ) AND
v.IdProyecto = ".$_SESSION['Proyecto']." AND
v.IdCamion = ".$v_camiones["IdCamion"]." AND
v.FechaLlegada = '".$v["FechaO"]."' AND
v.IdTiro = ".$v_tiros["IdTiro"]." group by idviaje";
//echo $SQLs;

				$r_viajes=$l->consultar($SQLs);
	$i=1;
	while($v_viajes=$l->fetch($r_viajes)) { 
	
				?>
                <script>
        Arreglo_Procesar_<?php echo $i_padre ?>.push('<?php echo $i_general; ?>');
        </script>
        <input name="tiro<?php echo $i_general; ?>" id="tiro<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_tiros["IdTiro"]; ?>" />
<input name="camion<?php echo $i_general; ?>" id="camion<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_camiones["IdCamion"]; ?>" />
        
<input name="idviaje<?php echo $i_general; ?>" id="idviaje<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_viajes["IdViaje"]; ?>" />
             <tr>
                <td class="detalle"><?php echo $i ?>&nbsp;</td>
                <td><div id="imagen<?php echo $i_general; ?>"><img src="../../Imagenes/<?php if($v_viajes["idmaterial"]==''||$v_viajes["tarifa_material"]==''||$v_viajes["Estatus"]==10||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))) echo "bred"; else echo "bgreen"; ?>.gif" <?php
				if($v_viajes["tiempo"]==0&&$v_viajes["Estatus"]==0){ echo "title='El viaje no puede ser registrado porque el tiempo del viaje es  0.00 min.'";}else
				if($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"]))) {echo "title='El viaje no puede ser registrado porque no cumple con los tiempos de cronometr&iacute;a de la ruta'";} 
				else
				if($v_viajes["idruta"]==''&&$v_viajes["Estatus"]==0) { echo "title='El viaje no puede ser registrado porque no existe una ruta entre su origen y destino'"; } 
				else if($v_viajes["tarifa_material"]==''&&$v_viajes["idmaterial"]!='') echo "title='El viaje no puede ser registrado porque no hay una tarifa registrada para su material'";
				else if($v_viajes["Estatus"]==10) echo "title='El viaje no puede ser registrado porque debe seleccionar primero su origen'";
				
				?> width="16" height="16" /></div></td>
                <td><?php echo $v_viajes["Hora"];?></td>
                <td align="center"><div id="ch<?php echo $i_general ?>">
                  <input type="checkbox" name="a<?php echo $i_general; ?>" id="a<?php echo $i_general; ?>"  
                  onclick="clic('r<?php echo $i_general; ?>')" <?php if($v_viajes["idmaterial"]==''||$v_viajes["tarifa_material"]==''||$v_viajes["Estatus"]==10||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))) echo "disabled"; else echo "checked"; ?> style="cursor:pointer"/>
               </div></td>
                <td align="center"><div id="nch<?php echo $i_general ?>">
                  <input type="checkbox" name="r<?php echo $i_general; ?>" id="r<?php echo $i_general; ?>"  <?php if($v_viajes["idmaterial"]==''||$v_viajes["tarifa_material"]==''||$v_viajes["Estatus"]==10||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))){ echo "checked"; }?> onclick="clic('a<?php echo $i_general; ?>')" style="cursor:pointer"/>
                </div></td>
                <td align="right" class="detalle"><?php echo $v_viajes["cubicacion"] ?></td>
                <td align="center"><?php if($v_viajes["origen"]!='') {?>
                <span class="detalle" title="<?php echo $v_viajes["origen"];?>"><?php echo substr($v_viajes["origen"], 0, 10) ; ?>
                <input name="<?php echo "origen".$i_general;?>" id="<?php echo "origen".$i_general;?>" type="hidden" value="<?php echo $v_viajes["idorigen"]; ?>" /></span><?php }else {
				
				$lista_origenes=$l->regresaSelect_evt("origen".$i_general,"distinct(origenes.IdOrigen), concat(origenes.Clave,'-',origenes.IdOrigen) AS Clave, origenes.Descripcion","origenes join rutas on (rutas.IdOrigen=origenes.IdOrigen AND rutas.Estatus=1 AND rutas.IdTiro=".$v_tiros["IdTiro"].") ","origenes.IdProyecto = ".$_SESSION["Proyecto"]." AND origenes.Estatus = 1","IdOrigen","Descripcion","desc","100px","1","0","1"," onChange='xajax_calculos_x_tipo_tarifa(document.getElementById(\"tarifa".$i_general."\").value,\"".$v_viajes["idmaterial"]."\",\"".$i_general."\",document.getElementById(\"origen".$i_general."\").value,document.getElementById(\"tiro".$i_general."\").value,document.getElementById(\"camion".$i_general."\").value,1)'","","r");  echo $lista_origenes;?>
                <script>
        Arreglo_<?php echo $i_padre ?>.push('<?php echo $i_general; ?>');
        </script><?php
	}
				?></td>
                <td align="center"><span class="detalle">
                   <input name="material<?php echo $i_general; ?>" id="material<?php echo $i_general; ?>" type="hidden" value="<?php echo $v_viajes["idmaterial"] ?>" />
                  <?php echo $v_viajes["material"] ?></span></td>
                <td align="center"><span class="detalle"><?php echo substr($v_viajes["tiempo_mostrar"],0,5); ?></span></td>
                <td align="center"><span class="detalle"><div id="rut<?php echo $i_general; ?>">
                 <?php echo $v_viajes["ruta"] ?></div></span></td>
                <td align="center"><span class="detalle"><div id="dis<?php echo $i_general; ?>">
                  <?php echo $v_viajes["distancia"] ?></div></span></td>
                  <td align="center" class="detalle">
                  <div id="dtara<?php echo $i_general; ?>">
                    <input name="tara<?php echo $i_general; ?>" type="text" class="monetario tipo_tarifa_p" id="tara<?php echo $i_general; ?>" style="width:45px" value="0.00" contador="<?php echo $i_general; ?>" /></div>
                  </td>
                  <td align="center" class="detalle">
                  <div id="dbruto<?php echo $i_general; ?>">
                  <input name="bruto<?php echo $i_general; ?>" type="text" class="monetario tipo_tarifa_p" id="bruto<?php echo $i_general; ?>" style="width:45px" value="0.00" contador="<?php echo $i_general; ?>" /></div></td>
 				<td align="center" class="detalle"><div id="dpk<?php echo $i_general; ?>"> <?php echo number_format($v_viajes["tarifa_material_pk"],2) ?></div></td>
 			    <td align="center" class="detalle"><div id="dks<?php echo $i_general; ?>"> <?php echo number_format($v_viajes["tarifa_material_ks"],2) ?></div></td>
                <td align="center" class="detalle"><div id="dka<?php echo $i_general; ?>"> <?php echo number_format($v_viajes["tarifa_material_ka"],2) ?></div></td>
                <td align="center"><span class="detalle"><div id="imp<?php echo $i_general; ?>"><?php echo number_format($v_viajes["ImporteTotal_M"],2) ?>
                
                </div>
                    
                </span>
                
                </td>
                <td align="center"><div id="dtarifa<?php echo $i_general; ?>"><select name="tarifa<?php echo $i_general; ?>" id="tarifa<?php echo $i_general; ?>"  class="tipo_tarifa" contador="<?php echo $i_general; ?>">
                 <option value="m">Material</option>
                <option value="r">Ruta</option>
                   
                    
                    <option value="p">Peso</option>
                  </select></div>
                </td>
                
                <td align="center">
                	<div id="dfda<?php echo $i_general; ?>">
                        <select name="fda<?php echo $i_general; ?>" id="fda<?php echo $i_general; ?>" >
	                        <option value="m">Material</option>
                            <option value="bm">Ban-Mat</option>
                        </select>
                	</div>
                </td>
                
                <td align="center" style="display:none"><span class="Item1">
                  <input name="hef<?php echo $i_general; ?>" id="hef<?php echo $i_general; ?>" type="text" class="texto" onkeypress="onlyDigits(event,'decOK')"  size="2" maxlength="7"  />
                </span></td>
                <td align="center" style="display:none"><?php 
				$lista_tipo_rutas=$l->regresaSelect_evt("cr".$i_general,"IdMaquinaria, Economico","maquinaria","Estatus=1","IdMaquinaria","Economico","desc","70px","1","0","1","","","r");  echo $lista_tipo_rutas;?></td>
                </tr>
              <?php $i_general++; $i++;}?>
                     <tr>
                       <td colspan="20" align="right">&nbsp;</td>
                       </tr>
                     <tr>
                  <td colspan="20" align="right"><input name="button" type="submit" class="boton" id="button" value="Validar Viajes" onclick="prepara_registra_viajes(Arreglo_Procesar_<?php echo $i_padre ?>)"/></td>
                  </tr>           </table></td>
          </tr>
          <?php $i_padre++; } ?>
        </table></td>
      </tr>
      <?php  } ?>
    </table></td>
  </tr>
  <?php }  ?>
</table>
</div>
</div>

</body>
<script src="../../Clases/Js/Cajas.js"></script>
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<script type="text/javascript" src="../../Clases/Js/MuestraLoad.js"></script>
<script>
function crea_arreglo(nombre)
{
	
}
function cambia_origen_child(arreglo,i_padre)
{
	
	for(o=0;o<arreglo.length;o++)
	{
		
		xajax_calculos_x_tipo_tarifa(document.getElementById("tarifa"+arreglo[o]).value,document.getElementById("material"+arreglo[o]).value,arreglo[o],			     	document.getElementById("origen_padre"+i_padre).value,document.getElementById("tiro"+arreglo[o]).value,document.getElementById("camion"+arreglo[o]).value,document.getElementById('idviaje'+arreglo[o]).value,document.getElementById('tara'+arreglo[o]).value,document.getElementById('bruto'+arreglo[o]).value);
		document.getElementById("origen"+arreglo[o]).value=document.getElementById("origen_padre"+i_padre).value;
	}
}
function clic(i)
{
	document.getElementById(i).checked=false;
}
function prepara_registra_viajes(arreglo)
{ 

for(o=0;o<arreglo.length;o++)
	{


		
		/*tiempo_viaje=document.getElementById('tiempo'+arreglo[o]).value;
		ruta=document.getElementById('ruta'+arreglo[o]).value;
		distancia=document.getElementById('distancia'+arreglo[o]).value;
		camion=document.getElementById('camion'+arreglo[o]).value;
		cubicacion=document.getElementById('cubicacion'+arreglo[o]).value;
		tiro=document.getElementById('tiro'+arreglo[o]).value;
		estatus=document.getElementById('estatus'+arreglo[o]).value;
		fa=document.getElementById('fa'+arreglo[o]).value;*/
		try{
			accion=(document.getElementById('a'+arreglo[o]).checked)?1:(document.getElementById('r'+arreglo[o]).checked)?0:'n';
				horas_efectivas=(document.getElementById('hef'+arreglo[o]).value=='')?0.00:document.getElementById('hef'+arreglo[o]).value;
				maquinaria=(document.getElementById('cr'+arreglo[o]).value=='A99')?0:document.getElementById('cr'+arreglo[o]).value;
				origen=(document.getElementById('origen'+arreglo[o]).value=='A99')?0:document.getElementById('origen'+arreglo[o]).value;
				id_viaje_neto=document.getElementById('idviaje'+arreglo[o]).value;
				tarifa=document.getElementById('tarifa'+arreglo[o]).value;
				fda=document.getElementById('fda'+arreglo[o]).value;
				tara=document.getElementById('tara'+arreglo[o]).value;
				bruto=document.getElementById('bruto'+arreglo[o]).value;
				

		}catch(e){accion='n'}
				//alert(id_viaje_neto+''+a+' '+r);
		//alert(accion);
		if(accion!='n')
		xajax_registra_viaje(arreglo[o],accion,id_viaje_neto,maquinaria,horas_efectivas,origen,tarifa,fda,tara,bruto);

	}
	
}
</script>

</html>
