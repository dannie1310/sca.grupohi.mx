<?php 

	session_start();
	include("../../../inc/php/conexiones/SCA.php");
	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");
	//require_once("funciones_xajax.php");

	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	$l = SCA::getConexion();
function muestra_consulta_ruta()
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	
	$tabla.='<table style="margin-left:20%;width:60%"  cellspacing="0" cellpadding="2" id="tabla_rutas">
		  
		  <tr ><form id="excel" action="muestra_excel.php">
		    <td colspan="9" class="detalle"><span class="boton" onclick="document.getElementById(\'excel\').submit()"><img src="../../../Imagenes/look.gif"/> Ver Rutas en Excel</span></td>
			</form>
      </tr>
	   <tr >
		    <td   colspan="11">&nbsp;</td>
      </tr>
	  <tr class="encabezado">
		    <td   colspan="8" style="border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Ruta</td> <td   colspan="3" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Cronometr&iacute;a Activa</td>
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
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>Minimo</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>Tolerancia</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Fecha/Hora<br/>Registro</td>
		  </tr>
		  <tbody>';
		  $SQLs = "SELECT concat(r.Clave,r.IdRuta) as ruta,r.*, o.Descripcion as origen, t.Descripcion as tiro, tr.Descripcion as tipo_ruta, if(c.TiempoMinimo is null,'- - - ',c.TiempoMinimo) as minimo,
if(c.Tolerancia is null,'- - - ',c.Tolerancia) as tolerancia,
if(c.FechaAlta is null,'- - - ',Concat(date_format(c.FechaAlta,'%d-%m-%Y'),' / ',c.HoraAlta)) as fecha_hora from cronometrias as c right join rutas as r on(c.IdRuta=r.IdRuta and c.Estatus=1) join origenes as o on(r.IdOrigen=o.IdOrigen) join tiros as t on(t.IdTiro=r.IdTiro) join tipo_ruta as tr on(tr.IdTipoRuta=r.IdTipoRuta) where r.Estatus=1";
		  $r=$l->consultar($SQLs);
		  while($v=$l->fetch($r))
		  {
			  $tabla.='<tr class="detalle">
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
		}
		  $tabla.='</tbody></table>';
		  
		   $respuesta->assign('contenido','innerHTML',$tabla);
	
	return $respuesta;
}
function muestra_registro_ruta()
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	
	$tabla.='<table style="margin-left:20%;width:60%" border="0" cellspacing="0" cellpadding="2" id="tabla_rutas">
		  <tr>
		    <td colspan="8" align="right" class="detalle" ><span class="boton" onclick="agrega_ruta(\'tabla_rutas\',\'body_rutas\',\'fila_clone\')">[+ Agregar Ruta]</span></td>
      </tr>
		  <tr >
		    <td colspan="8" >&nbsp;</td>
      </tr>
		  <tr class="encabezado">
			<td >Origen</td>
			<td >Tiro</td>
			<td >Tipo de Ruta</td>
			<td > 1er. KM</td>
			<td > KM<br />Subsecuentes</td>
			<td > KM<br />Adicionales</td>
			<td style="width:70px">KM<br />Total</td>
			<td >&nbsp;</td>
		  </tr><tbody id="body_rutas">
           <tr id="fila_clone" style="display:none">
		    <td align="center" >';
			$lista_origenes=$l->regresaSelect_evt("origen","Descripcion, IdOrigen","origenes","Estatus=1","IdOrigen","Descripcion","desc","150px","1","0","1","","r");
			
			$tabla.=$lista_origenes.'</td>
		    <td align="center" >';
			
			$lista_tiros=$l->regresaSelect_evt("tiro","Descripcion, IdTiro","tiros","Estatus=1","IdTiro","Descripcion","desc","150px","1","0","1","","r");
		  $tabla.=$lista_tiros.'</td>
		    <td align="center" >';
			$lista_tipo_rutas=$l->regresaSelect_evt("tipo_ruta","Descripcion, IdTipoRuta","tipo_ruta","Estatus=1","IdTipoRuta","Descripcion","desc","150px","1","0","1","","r");
			$tabla.=$lista_tipo_rutas.'</td>
		    <td align="center" class="detalle" >1<input name="pk" id="pk" type="hidden" value="1" /></td>
		    <td align="center" ><input name="ks" id="ks" type="text" size="3" value="0"  class="monetario"   onkeypress="onlyDigitsPunto(event,\'decOK\')" /></td><td align="center" ><input name="ka" id="ka" type="text" size="3" value="0"  class="monetario"   onkeypress="onlyDigitsPunto(event,\'decOK\')" /><input name="tk" id="tk" type="hidden" value="" /></td>
		    <td align="center" class="detalle" id="cell_tk">1 Km</td>
		    <td align="center" ><input name="guardar" id="guardar" type="image" src="../../../Imagenes/Guardar_inc.gif" lass="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'"  /></td>
      </tr>
	  <tr >
		    <td align="center" >';
			
			$lista_origenes=$l->regresaSelect_evt("origen1","Descripcion, IdOrigen","origenes","Estatus=1","IdOrigen","Descripcion","desc","150px","1","0","1","","r");
			$tabla.=$lista_origenes.'</td>
		    <td align="center" >';
			
			$lista_tiros=$l->regresaSelect_evt("tiro1","Descripcion, IdTiro","tiros","Estatus=1","IdTiro","Descripcion","desc","150px","1","0","1","","r");
			$tabla.=$lista_tiros.'</td>
		    <td align="center" >';
			
			$lista_tipo_rutas=$l->regresaSelect_evt("tipo_ruta1","Descripcion, IdTipoRuta","tipo_ruta","Estatus=1","IdTipoRuta","Descripcion","desc","150px","1","0","1","","r");
			
			$tabla.=$lista_tipo_rutas.'</td>
		    <td align="center" class="detalle" >1<input name="pk1" id="pk1" type="hidden" value="1" /></td>
		    <td align="center" ><input name="ks1" id="ks1" type="text" size="3" value="0"  class="monetario" onkeyup="agrega(1)"  onkeypress="onlyDigitsPunto(event,\'decOK\')" /></td><td align="center" ><input name="ka1" id="ka1" type="text" size="3" value="0"  class="monetario" onkeyup="agrega(1)"  onkeypress="onlyDigitsPunto(event,\'decOK\')" /><input name="tk1" id="tk1" type="hidden" value="" /></td>
		    <td align="center" class="detalle" id="cell_tk1">1 Km</td><td align="center" ><input name="guardar1" id="guardar1" type="image" src="../../../Imagenes/Guardar_inc.gif" lass="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="valida_registra_tarifa_material(1)" /></td>
      </tr>
      </tbody>
          </table>';
			

		  
		  $respuesta->assign('contenido','innerHTML',$tabla);
	
	return $respuesta;
}
function registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,$var_tk)
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	$SQLs = "call sca_sp_registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,$var_tk,".$_SESSION["Proyecto"].",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	//$respuesta->alert($SQLs);
	$r=$l->consultar($SQLs);
		$v=$l->fetch($r);
		
		$r2=$l->consultar("select @Respuesta");
		$v2=$l->fetch($r2);
		
		if($v2["@Respuesta"]!='')
		{
			$mensaje=$v2["@Respuesta"];
			$mensaje=explode("-",$mensaje);
			$estado='<img src="../../../Imagenes/'.$mensaje[0].'.gif" width="16" height="16" />'.($mensaje[1]);
			$respuesta->alert($mensaje[1]);
		}
		else
		{
			$estado='<img src="../../../Imagenes/ko.gif" width="16" height="16" />Hubo un error durante el registro, intentelo nuevamente';
			$respuesta->alert("Hubo un error durante el registro, intentelo nuevamente");
			//$respuesta->assign("div_estado","innerHTML",$estado);
		}
	return $respuesta;	
}
	
	$xajax->register(XAJAX_FUNCTION,"registra_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_registro_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_consulta_ruta");
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

</div>
</div>
</body>
<script type="text/javascript" src="../../../Clases/Js/NoClieck.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/ValidaFormulario.js"></script>
<script>
no_docto=1;
function agrega_ruta(itabla,ibody,ifila)
{
	 no_docto++;
	 tr=document.getElementById(ifila);
	 tabla=document.getElementById(itabla);
	 b=document.getElementById(ibody);
	 

	 tr_clonada=tr.cloneNode(true);
	 tr_clonada.style.display='block';

	 tr_clonada.cells[6].id="cell_tk"+no_docto;
	 existentes=document.getElementsByName('origen').length;
	  b.appendChild(tr_clonada);

	document.getElementsByName('origen')[existentes].id="origen"+no_docto;
	document.getElementsByName('tiro')[existentes].id="tiro"+no_docto;
	document.getElementsByName('tipo_ruta')[existentes].id="tipo_ruta"+no_docto;
	document.getElementsByName('pk')[existentes].id="pk"+no_docto;
	document.getElementsByName('ks')[existentes].id="ks"+no_docto;
	document.getElementsByName('ka')[existentes].id="ka"+no_docto;
	document.getElementsByName('tk')[existentes].id="tk"+no_docto;
	document.getElementsByName('guardar')[existentes].id="guardar"+no_docto;
	document.getElementById('ks'+no_docto).onkeyup=function(){agrega(no_docto)};
	document.getElementById('ka'+no_docto).onkeyup=function(){agrega(no_docto)};
	document.getElementById('guardar'+no_docto).onclick=function(){valida_registra_tarifa_material(no_docto)};
}
function valida_registra_tarifa_material(i)
{
	invalidos=0;
	
	var_origen=0;
	var_tiro=0;
	var_tipo_ruta=0;
	var_pk=1;
	var_ks=0;
	var_ka=document.getElementById('ka'+i).value;
	var_tk=document.getElementById('tk'+i).value;
	if(document.getElementById('origen'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('origen'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('origen'+i).style.background="#CFC";
		var_origen=document.getElementById('origen'+i).value;
	}
	if(document.getElementById('tiro'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('tiro'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('tiro'+i).style.background="#CFC";
		var_tiro=document.getElementById('tiro'+i).value;
	}
	if(document.getElementById('tipo_ruta'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('tipo_ruta'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('tipo_ruta'+i).style.background="#CFC";
		var_tipo_ruta=document.getElementById('tipo_ruta'+i).value;
	}
	
	
	if(parseFloat(document.getElementById('ks'+i).value)==0)
	{
		invalidos++;
		document.getElementById('ks'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('ks'+i).style.background="#CFC";
		var_ks=document.getElementById('ks'+i).value;
	}
	if(invalidos>0) return false;
	else
	{
		if(confirm('&iquest;Est&aacute; seguro de registrar la ruta ?'))
		{
			xajax_registra_ruta(var_origen,var_tiro,var_tipo_ruta,var_pk,var_ks, var_ka, var_tk);	
		}
	}
	
}
function agrega(i)
{	

  a=0.00;
	vpk=parseFloat((document.getElementById('pk'+i).value=='')?"0.00":document.getElementById('pk'+i).value);
	vks=parseFloat((document.getElementById('ks'+i).value=='')?"0.00":document.getElementById('ks'+i).value);
	vka=parseFloat((document.getElementById('ka'+i).value=='')?"0.00":document.getElementById('ka'+i).value);
	
	(document.getElementById('pk'+i).value=='')?document.getElementById('pk'+i).value="0":document.getElementById('pk'+i).value=document.getElementById('pk'+i).value;
	(document.getElementById('ks'+i).value=='')?document.getElementById('ks'+i).value="0":document.getElementById('ks'+i).value=document.getElementById('ks'+i).value;
	(document.getElementById('ka'+i).value=='')?document.getElementById('ka'+i).value="0":document.getElementById('ka'+i).value=document.getElementById('ka'+i).value;

	document.getElementById('tk'+i).value=vpk+vks+vka;
	document.getElementById('cell_tk'+i).innerHTML=vpk+vks+vka+" Km";
	a=pk+ks+ka;
	
	return false;
}

</script>
</html>