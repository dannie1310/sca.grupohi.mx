<?php 
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
		    <td colspan="10" align="right" class="detalle" ><span class="boton" onclick="agrega_ruta(\'tabla_rutas\',\'body_rutas\',\'fila_clone\')">[+ Agregar Ruta]</span></td>
      </tr>
		  <tr >
		    <td colspan="10" >&nbsp;</td>
      </tr>
	  <tr class="encabezado">
		    <td colspan="7" align="center" style="border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Ruta</td><td colspan="2" align="center" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Cronometr&iacute;a</td>
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
			<td style="border-right:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">&nbsp;</td>
		  </tr><tbody id="body_rutas">
           <tr id="fila_clone" style="display:none">
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
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="ka" id="ka" type="text" size="3" value="0"  class="monetario"   onkeypress="onlyDigitsPunto(event,\'decOK\')" /><input name="tk" id="tk" type="hidden" value="" /></td>
		    <td align="center" class="detalle" id="cell_tk" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">1 Km</td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="tm" id="tm" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" /></td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="tol" id="tol" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" /></td>
		    <td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="guardar" id="guardar" type="image" src="../../../Imagenes/Guardar_inc.gif" lass="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'"  /></td>
      </tr>
	  <tr >
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
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="ka1" id="ka1" type="text" size="3" value="0"  class="monetario" onkeyup="agrega(1)"  onkeypress="onlyDigitsPunto(event,\'decOK\')" onclick="this.value=\'\';agrega(1)" /><input name="tk1" id="tk1" type="hidden" value="" /></td>
		    <td align="center" class="detalle" id="cell_tk1" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">1 Km</td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">
			<input name="tm1" id="tm1" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />
			</td>
			<td align="center"  style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">
			<input name="tol1" id="tol1" type="text" size="3" value="0"  class="texto"  onkeypress="onlyDigits(event,\'decOK\')" onclick="this.value=\'\'" />
			</td>
			<td align="center" style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px"><input name="guardar1" id="guardar1" type="image" src="../../../Imagenes/Guardar_inc.gif" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="valida_registra_tarifa_material(1)" /></td>
      </tr>
      </tbody>
          </table>';
			

		  
		  $respuesta->assign('contenido','innerHTML',$tabla);
	
	return $respuesta;
}
function registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,$var_tk,$tiempo,$tolerancia)
{
	$respuesta=new xajaxResponse();
	$l = SCA::getConexion();
	$l->consultar("start transaction");
	$SQLs = "call sca_sp_registra_ruta($var_origen,$var_tiro,$var_tipo_ruta,$var_pk,$var_ks,$var_ka,$var_tk,".$_SESSION["Proyecto"].",".$_SESSION["IdUsuarioAc"].",@respuesta)";
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
					$respuesta->alert($SQLs);
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