<?php 
function elimina_ruta($IdFila,$IdRuta)
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	
	$SQLs = "call sca_sp_elimina_ruta(".$IdRuta.",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	//$respuesta->alert($SQLs);
	$r=$l->consultar($SQLs);
	$v=$l->fetch($r);
		
	$r2=$l->consultar("select @respuesta");
	$v2=$l->fetch($r2);
		
	if($v2["@respuesta"]=='ok')
	{
		$respuesta->script("quita_fila(".$IdFila.")");
	}
	else
	{
		$respuesta->script("reestablece_fila(".$IdFila.")");
	}
	
	$l->cerrar();
	return $respuesta;
}
function registra_cambio_ruta($IdRuta,$var_tipo_ruta,$var_ks,$var_ka,$var_tm,$var_tol)
{
	$modificados=0;
	$necesarios=3;
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	
	$l->consultar("start transaction");
	
	$SQLs = "call sca_registra_cambios_rutas(".$IdRuta.",1,".$var_tipo_ruta.",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	$l->consultar($SQLs);
	$r1=$l->consultar("select @respuesta");
	$v1=$l->fetch($r1);
	$modificados+=$v1["@respuesta"];
	//$respuesta->alert($modificados.'=='.$necesarios);
	$SQLs = "call sca_registra_cambios_rutas(".$IdRuta.",2,".$var_ks.",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	$l->consultar($SQLs);
	$r1=$l->consultar("select @respuesta");
	$v1=$l->fetch($r1);
	$modificados+=$v1["@respuesta"];
	//$respuesta->alert($modificados.'=='.$necesarios);
	$SQLs = "call sca_registra_cambios_rutas(".$IdRuta.",3,".$var_ka.",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	$l->consultar($SQLs);
	$r1=$l->consultar("select @respuesta");
	$v1=$l->fetch($r1);
	$modificados+=$v1["@respuesta"];
	//$respuesta->alert($modificados.'=='.$necesarios);
	if(($var_tm!=0&&$var_tm!='')&&($var_tol!=0&&$var_tol!=''))
	{ $necesarios++;
				
		$SQLs = "call sca_sp_registra_cronometria(".$IdRuta.",$var_tm,$var_tol,".$_SESSION["IdUsuarioAc"].",@respuesta2)";
		//$respuesta->alert($SQLs);
		$r2=$l->consultar($SQLs);
					
		$r3=$l->consultar("select @respuesta2");
		$v3=$l->fetch($r3);
		$mensaje2=$v3["@respuesta2"];
		//$respuesta->alert($mensaje2);
		$mensaje2=explode("-",$mensaje2);
		if($mensaje2[0]=='ok')
		{
			$modificados++;
			
		}
	}
	//$respuesta->alert($modificados.'=='.$necesarios);
	if($modificados==$necesarios)
	{
		$respuesta->alert("La ruta ha sido modificada");
		$l->consultar("commit");
	}
	else
	{
		$respuesta->alert("Hubo un error durante el registro de las modificaciones");
		$l->consultar("rollback");
	}
	
	$l->cerrar();
	return $respuesta;
}
function muestra_modifica_ruta()
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	$tabla.='<table  border="0" cellspacing="0" cellpadding="2" style="margin-left:10%;width:80%">
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
          <tbody id="body_rutas">';
		  
		  		  $SQLs = "SELECT
		  if(r.KmAdicionales='',0,r.KmAdicionales) as KmAdicionales_v,
count(v.IdViaje) as NoViajes,
concat(r.Clave,r.IdRuta) as ruta,r.*, o.Descripcion as origen, t.Descripcion as tiro,
tr.Descripcion as tipo_ruta,
if(c.TiempoMinimo is null,'',
c.TiempoMinimo) as minimo,
if(c.Tolerancia is null,'',c.Tolerancia) as tolerancia,
if(c.Tolerancia is null,0,1) as pide_cronometria,
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
			  $iks=$v["KmSubsecuentes"].' km <input name="ks'.$i.'" id="ks'.$i.'" type="hidden" value="'.$v["KmSubsecuentes"].'" />';
			  $ika=$v["KmAdicionales_v"].' km <input name="ka'.$i.'" id="ka'.$i.'" type="hidden" value="'.$v["KmAdicionales_v"].'" /><input name="tk'.$i.'" id="tk'.$i.'" type="hidden" value="1" />';
			  $boton_eliminar='';
			  }
			  else
			  {
			$iks='<input name="ks'.$i.'" id="ks'.$i.'" type="text" size="3"   class="monetario" onkeyup="agrega('.$i.')"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega('.$i.')" value="'.$v["KmSubsecuentes"].'"/>';
			  $ika='<input name="ka'.$i.'" id="ka'.$i.'" type="text" size="3"  class="monetario" onkeyup="agrega('.$i.')"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega('.$i.')" value="'.$v["KmAdicionales_v"].'" /> <input name="tk'.$i.'" id="tk'.$i.'" type="hidden" value="1" />';
			$boton_eliminar='<input name="eliminar'.$i.'" id="eliminar'.$i.'" type="image" src="../../../Imagenes/eliminar_inc.gif" onmouseover="this.src=\'../../../Imagenes/eliminar.gif\'" onmouseout="this.src=\'../../../Imagenes/eliminar_inc.gif\'" onclick="valida_elimina('.$i.',\''.$v["IdRuta"].'\',\''.$v["ruta"].'\')" />';
			
			}
			$tm='<input name="tm'.$i.'" id="tm'.$i.'" type="text" size="3" value="'.$v["minimo"].'"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />';
			  $tol='<input name="tol'.$i.'" id="tol'.$i.'" type="text" size="3" value="'.$v["tolerancia"].'"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />';
			  
			  $lista_tipo_rutas=$l->regresaSelect_evt("tr".$i,"Descripcion, IdTipoRuta","tipo_ruta","Estatus=1","IdTipoRuta","Descripcion","desc","150px","1","0","1","",$v["IdTipoRuta"],"r");
			  $tabla.=' <tr id="fila_'.$i.'" >
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px; border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px" class="detalle">'.$v["ruta"].'<input name="pide_cronometria'.$i.'" id="pide_cronometria'.$i.'" type="hidden" value="'.$v["pide_cronometria"].'" />
    <input name="id_ruta'.$i.'" id="id_ruta'.$i.'" type="hidden" value="'.$v["IdRuta"].'" /></td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" class="detalle">'.$v["origen"].'</td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" class="detalle">'.$v["tiro"].'</td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px">'.$lista_tipo_rutas.'</td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" class="detalle">1 km<input name="pk'.$i.'" id="pk'.$i.'" type="hidden" value="1" /></td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" >'.$iks.'</td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px">'.$ika.'</td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px" id="cell_tk'.$i.'" class="detalle">'.$v["TotalKM"].'&nbsp;km</td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px">'.$tm.'</td>
    <td  style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px">'.$tol.'</td>
    <td style="text-align:center;border-bottom:#D4D4D4 solid 1px;  border-right:#D4D4D4 solid 1px;text-align:left"><input name="guardar'.$i.'" id="guardar'.$i.'" type="image" src="../../../Imagenes/Guardar_inc.gif" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="prepara_cambios_ruta('.$i.')" />&nbsp;'.$boton_eliminar.'</td>
  </tr>';
			  
			  /*
			 
			  
			  */
			  $i++;
		  }
		  $tabla.='</tbody></table>';
		  
		  		   $respuesta->assign('contenido','innerHTML',$tabla);
	$l->cerrar();
	return $respuesta;
}
function muestra_consulta_ruta()
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	
	$tabla.='<table style="margin-left:10%;width:80%"  cellspacing="0" cellpadding="2" id="tabla_rutas">
		  
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
	$l->cerrar();
	return $respuesta;
}
function muestra_registro_ruta()
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	
	$tabla.='<table style="width:100%" border="0" cellspacing="0" cellpadding="2" id="tabla_rutas">
		  <tr>
		    <td colspan="11" align="right" class="detalle" ><span class="boton" onclick="agrega_ruta(\'tabla_rutas\',\'body_rutas\',\'fila_clone\')">[+ Agregar Ruta]</span></td>
      </tr>
		  <tr >
		    <td colspan="11" >&nbsp;</td>
      </tr>
	  <tr class="encabezado">
		    <td colspan="7" align="center" style="border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Ruta</td><td colspan="2" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Cronometr&iacute;a</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">&nbsp;</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">&nbsp;</td>
      </tr>
		  <tr class="encabezado">
			<td style="border:#D4D4D4 solid 1px">Origen</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiro</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tipo de Ruta</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> 1er. KM</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />Subsecuentes</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />Adicionales</td>
			<td style="width:70px;border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">KM<br />Total</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>M&iacute;nimo</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tolerancia</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Archivo</td>
			<td style="border-right:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">&nbsp;</td>
		  </tr>
		  <tbody id="body_rutas">
           <tr id="fila_clone" style="display:none" >
		   <form id="fr" name="fr" method="post" enctype="multipart/form-data" action="SubRegistraRuta.php" target="ifr">
		    <input name="counter" id="counter" type="hidden" value="" />
		    <td align="center" style="text-align:center;border-bottom:#D4D4D4 solid 1px; border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px" >';
			$lista_origenes=$l->regresaSelect_evt("origen","Descripcion, IdOrigen","origenes","Estatus=1","IdOrigen","Descripcion","desc","150px","1","0","1","","","r");
			
			$tabla.=$lista_origenes.'</td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">';
			
			$lista_tiros=$l->regresaSelect_evt("tiro","Descripcion, IdTiro","tiros","Estatus=1","IdTiro","Descripcion","desc","150px","1","0","1","","","r");
		  $tabla.=$lista_tiros.'</td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">';
			$lista_tipo_rutas=$l->regresaSelect_evt("tipo_ruta","Descripcion, IdTipoRuta","tipo_ruta","Estatus=1","IdTipoRuta","Descripcion","desc","150px","1","0","1","","","r");
			$tabla.=$lista_tipo_rutas.'</td>
		    <td align="center" class="detalle" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px" >1<input name="pk" id="pk" type="hidden" value="1" /></td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="ks" id="ks" type="text" size="3" value="0"  class="monetario"   onkeypress="onlyDigitsPunto(event,\'decOK\')" /></td>
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="ka" id="ka" type="text" size="3" value="0"  class="monetario"   onkeypress="onlyDigitsPunto(event,\'decOK\')" /><input name="tk" id="tk" type="hidden" value="1" /></td>
		    <td align="center" class="detalle" id="cell_tk" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="total" id="total" type="text" size="2" value="1"  class="monetario"   readonly="readonly"/></td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="tm" id="tm" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" /></td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="tol" id="tol" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" /></td>
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="archivo" id="archivo" type="file" class="text" style="width:100px" /></td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="guardar" id="guardar" type="image" src="../../../Imagenes/Guardar_inc.gif" lass="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'"  /></td>
			</form>
      </tr>
	  <tr >
	  <form method="post" enctype="multipart/form-data" action="SubRegistraRuta.php" target="ifr">
	  <input name="counter" id="counter" type="hidden" value="1" />
		    <td align="center" style="text-align:center;border-bottom:#D4D4D4 solid 1px; border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px">';
			
			$lista_origenes=$l->regresaSelect_evt("origen1","Descripcion, IdOrigen","origenes","Estatus=1","IdOrigen","Descripcion","desc","150px","1","0","1","","","r");
			$tabla.=$lista_origenes.'</td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px" >';
			
			$lista_tiros=$l->regresaSelect_evt("tiro1","Descripcion, IdTiro","tiros","Estatus=1","IdTiro","Descripcion","desc","150px","1","0","1","","","r");
			$tabla.=$lista_tiros.'</td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">';
			
			$lista_tipo_rutas=$l->regresaSelect_evt("tipo_ruta1","Descripcion, IdTipoRuta","tipo_ruta","Estatus=1","IdTipoRuta","Descripcion","desc","150px","1","0","1","","","r");
			
			$tabla.=$lista_tipo_rutas.'</td>
		    <td align="center" class="detalle" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px" >1<input name="pk1" id="pk1" type="hidden" value="1" /></td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="ks1" id="ks1" type="text" size="3" value="0"  class="monetario" onkeyup="agrega(1)"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega(1)" /></td>
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="ka1" id="ka1" type="text" size="3" value="0"  class="monetario" onkeyup="agrega(1)"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega(1)" /><input name="tk1" id="tk1" type="hidden" value="1" /></td>
		    <td align="center" class="detalle" id="cell_tk1" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="total1" id="total1" type="text" size="2" value="1"  class="monetario"   readonly="readonly"/></td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">
			<input name="tm1" id="tm1" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />
			</td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">
			<input name="tol1" id="tol1" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />
			</td>
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="archivo1" id="archivo1" type="file" class="text" style="width:100px" /></td>
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="guardar1" id="guardar1" type="image" src="../../../Imagenes/Guardar_inc.gif" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="valida_registra_tarifa_material(1)" /></td>
			</form>
      </tr>
      </tbody>
          </table>
		   <iframe name="ifr" id="ifr" width="600" height="700"></iframe>
		  ';
			

		  
		  $respuesta->assign('contenido','innerHTML',$tabla);
	
	return $respuesta;
}
function registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,$var_tk,$tiempo,$tolerancia)
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	$l->consultar("start transaction");
	$SQLs = "call sca_sp_registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,".$var_tk.",".$_SESSION["Proyecto"].",".$_SESSION["IdUsuarioAc"].",@respuesta)";
	//$respuesta->alert($SQLs);
	$r=$l->consultar($SQLs);
		$v=$l->fetch($r);
		
		$r2=$l->consultar("select @respuesta");
		$v2=$l->fetch($r2);
		
		if($v2["@respuesta"]!='')
		{
			$mensaje=$v2["@respuesta"];
			$mensaje=explode("-",$mensaje);
			$estado='<img src="../../../Imagenes/'.$mensaje[0].'.gif" width="16" height="16" />'.($mensaje[1]);
			
			if($mensaje[0]=='ok')
			{
				if(($tiempo!=0&&$tiempo!='')&&($tolerancia!=0&&$tolerancia!=''))
				{
				
					$SQLs = "call sca_sp_registra_cronometria(".$mensaje[2].",$tiempo,$tolerancia,".$_SESSION["IdUsuarioAc"].",@respuesta2)";
					//$respuesta->alert($SQLs);
					$r2=$l->consultar($SQLs);
					
					$r3=$l->consultar("select @respuesta2");
					$v3=$l->fetch($r3);
					$mensaje2=$v3["@respuesta2"];
					$mensaje2=explode("-",$mensaje2);
					if($mensaje2[0]=='ok')
					{
						$respuesta->alert(utf8_decode($mensaje[1]));
						$l->consultar("commit");
					}
					else
					{
						$respuesta->alert("Hubo un error durante el registro, intentelo nuevamente1");	
						$l->consultar("rollback");
					}
				}
				else
				{
					$respuesta->alert(utf8_decode($mensaje[1]));
					$l->consultar("commit");
				}
				//$respuesta->alert($mensaje[2]);
				
			}
			else
			{
				$respuesta->alert($mensaje[1]);
				$l->consultar("rollback");
			}
		}
		else
		{
			$estado='<img src="../../../Imagenes/ko.gif" width="16" height="16" />Hubo un error durante el registro, intentelo nuevamente';
			$respuesta->alert("Hubo un error durante el registro, intentelo nuevamente2");
			$l->consultar("rollback");
			//$respuesta->assign("div_estado","innerHTML",$estado);
		}
	return $respuesta;	
}
?>