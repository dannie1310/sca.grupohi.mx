<?php 

	function tarifa_material()
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		
		$SQLs = "select * from(
		select
		case m.Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate,
		m.descripcion as material,
		m.IdMaterial as idmaterial,
		if(t.PrimerKM is null,'0.00',t.primerKM)as p,
		if(t.KMSubsecuente is null,'0.00',t.KMSubsecuente) as s,
		if(t.KMAdicional is null,'0.00',t.KMAdicional) as a
		from
		materiales as m left join tarifas as t on (m.IdMaterial=t.IdMaterial and t.Estatus=1)) as m group by idmaterial order by material";
		$r=$l->consultar($SQLs);
			$tabla.='<table style="margin-left:5%;width:90%" border="0" cellspacing="0" cellpadding="2">
			<caption>Tarifa por Material</caption>
		  <tr class="encabezado">
			<td style="width:300px;">Material</td>
			<td >Tarifa 1er. KM</td>
			<td >Tarifa KM Subsecuente</td>
			<td >Tarifa KM Adicionales</td>
			<td >Estatdo</td>
			<td >&nbsp;</td>
		  </tr>';
		while($v=$l->fetch($r))
		{
			/*$tabla.='<form id="frm'.$v["idmaterial"].'" name="frm'.$v["idmaterial"].'" >
			
			<input type="hidden" name="IdMaterial" id="IdMaterial" value="'.$v["idmaterial"].'"/>
		  <tr class="detalle">
			<td align="left">-'.$v["material"].'</td>
			<td align="center"><label>
			  $
			  <input name="tpkm" type="text" class="monetario" id="tpkm" size="2" maxlength="5" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["p"].'"/>
			</label></td>
			<td align="center">$
			  <input name="tks" type="text" class="monetario" id="tks" size="2" maxlength="5" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["s"].'"/></td>
			<td align="center">$
			  <input name="tka" type="text" class="monetario" id="tka" size="2" maxlength="5" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["a"].'"/></td>
			<td align="center">'.$v["Estate"].'</td>
			<td align="center"><img src="../../../Imagenes/Guardar_inc.gif" width="16" height="16" class="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="if(valida(\'frm'.$v["idmaterial"].'\',\'&iquest; Est&aacute; seguro de registrar la tarifa para el material: '.$v["material"].'?\')){xajax_registra_tarifa_material(xajax.getFormValues(\'frm'.$v["idmaterial"].'\'))}"/></td>
		  </tr>
		  </form>';*/
		  $tabla .='<tr>
						<td colspan="5">
						<table>
							<tr class="detalle">
							<td>
							<form id="frm'.$v["idmaterial"].'" name="frm'.$v["idmaterial"].'">
							<input type="hidden" name="IdMaterial" id="IdMaterial" value="'.$v["idmaterial"].'"/>
							<div style="width:350px; float:left;"><label>-'.$v["material"].'</label></div>							
							<label>$<input name="tpkm" type="text" class="monetario" id="tpkm" size="10" maxlength="12" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["p"].'"/></label>
							<label>$<input name="tks" type="text" class="monetario" id="tks" size="10" maxlength="12" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["s"].'"/></label>
							<label>$<input name="tka" type="text" class="monetario" id="tka" size="10" maxlength="12" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["a"].'"/></label>
							<div style="width:100px; float:left;"></div>
							'.$v["Estate"].'
							<img src="../../../Imagenes/Guardar_inc.gif" width="16" height="16" class="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="if(valida(\'frm'.$v["idmaterial"].'\',\'&iquest; Est&aacute; seguro de registrar la tarifa para el material: '.$v["material"].'?\')){xajax_registra_tarifa_material(xajax.getFormValues(\'frm'.$v["idmaterial"].'\'))}"/>
							
							</form>
							</td>
							</tr>
						</table>
						</td>
					</tr>';
		}
	  
	 $respuesta->assign('contenido','innerHTML',$tabla);
	return $respuesta;	
	}
	
	function tarifa_ruta()
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		
		$SQLs = "select * from(
					select
					case tr.Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate,
					tr.descripcion as tiporuta,
					tr.IdTipoRuta as idtiporuta,
					t.PrimerKM as p,
					t.KMSubsecuente as s,
					t.KMAdicional as a
					from
					tipo_ruta as tr left join tarifas_tipo_ruta as t on (tr.IdTipoRuta=t.IdTipoRuta and t.Estatus=1)
				) as m  group by idtiporuta order by tiporuta";
		$r=$l->consultar($SQLs);
			$tabla.='<table style="border="0" cellspacing="0" cellpadding="2">
			<caption>Tarifa por Ruta</caption>
		  <tr >
			<th >Tipo de Ruta</th>
			<th >Tarifa 1er. KM</th>
			<th >Tarifa KM Subsecuente</th>
			<th >Tarifa KM Adicionales</th>
			<th >Estado</th>
			<th >&nbsp;</th>
		  </tr>';
		while($v=$l->fetch($r))
		{
			$tabla.='<tr class="detalle"> <td colspan="5">
			<form id="frm'.$v["idtiporuta"].'" name="frm'.$v["idtiporuta"].'" >
			<table>
			<tr>			
			<input type="hidden" name="IdTipoRuta" id="IdTipoRuta" value="'.$v["idtiporuta"].'"/>
		  
			<td align="left">-'.$v["tiporuta"].'</td>
			<td align="center"><label>
			  $
			  <input name="tpkm" type="text" class="monetario" id="tpkm" size="13" maxlength="13" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["p"].'"/>
			</label></td>
			<td align="center">$
			  <input name="tks" type="text" class="monetario" id="tks" size="13" maxlength="13" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["s"].'"/></td>
			<td align="center">$
			  <input name="tka" type="text" class="monetario" id="tka" size="13" maxlength="13" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["a"].'"/></td>
			<td align="center">'.$v["Estate"].'</td>
			<td align="center"><img src="../../../Imagenes/Guardar_inc.gif" width="16" height="16" class="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="if(valida(\'frm'.$v["idtiporuta"].'\',\'&iquest; Est&aacute; seguro de registrar la tarifa para el tipo de ruta: '.$v["tiporuta"].'?\')){xajax_registra_tarifa_tipo_ruta(xajax.getFormValues(\'frm'.$v["idtiporuta"].'\'))}"/></td>
		  </tr>
		  </table></form></td></tr>';
		}
	  
	 	$respuesta->assign('contenido','innerHTML',$tabla);
		return $respuesta;	
	}
	
	function tarifa_peso()
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		
		$SQLs = "select * from(
		select
		case m.Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate,
		m.descripcion as material,
		m.IdMaterial as idmaterial,
		t.PrimerKM as p,
		t.KMSubsecuente as s,
		t.KMAdicional as a
		from
		materiales as m left join tarifas_peso as t on (m.IdMaterial=t.IdMaterial and t.Estatus=1)) as m group by idmaterial order by material";
		$r=$l->consultar($SQLs);
			$tabla.='<table  border="0" cellspacing="0" cellpadding="2">
			<caption>Tarifa por Peso</caption>
		  <tr>
			<th>Material</th>
			<th>Tarifa 1er. KM</th>
			<th>Tarifa KM Subsecuente</th>
			<th>Tarifa KM Adicionales</th>
			<th>Estatdo</th>
			<th>&nbsp;</th>
		  </tr>';
		while($v=$l->fetch($r))
		{
			$tabla.=' <tr class="detalle"> <td colspan="5">
			<form id="frm'.$v["idmaterial"].'" name="frm'.$v["idmaterial"].'" >			
			<input type="hidden" name="IdMaterial" id="IdMaterial" value="'.$v["idmaterial"].'"/>
		 	<table>
		 	<tr>
			<td align="left">-'.$v["material"].'</td>
			<td align="center"><label>
			  $
			  <input name="tpkm" type="text" class="monetario" id="tpkm" size="12" maxlength="13" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["p"].'"/>
			</label></td>
			<td align="center">$
			  <input name="tks" type="text" class="monetario" id="tks" size="12" maxlength="13" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["s"].'"/></td>
			<td align="center">$
			  <input name="tka" type="text" class="monetario" id="tka" size="12" maxlength="13" onKeyPress="onlyDigits(event,\'decOK\')" value="'.$v["a"].'"/></td>
			<td align="center">'.$v["Estate"].'</td>
			<td align="center"><img src="../../../Imagenes/Guardar_inc.gif" width="16" height="16" class="boton" onmouseover="this.src=\'../../../Imagenes/Guardar.gif\'" onmouseout="this.src=\'../../../Imagenes/Guardar_inc.gif\'" onclick="if(valida(\'frm'.$v["idmaterial"].'\',\'&iquest; Est&aacute; seguro de registrar la tarifa por peso para el material: '.$v["material"].'?\')){xajax_registra_tarifa_peso(xajax.getFormValues(\'frm'.$v["idmaterial"].'\'))}"/></td>
		  
		  <tr></table></form>
		  </td></tr>';
		}
	  
	 $respuesta->assign('contenido','innerHTML',$tabla);
	return $respuesta;	
	}
	
	function registra_tarifa_material($frm)
	{
		$respuesta=new xajaxResponse();
		echo "antes";
		print_r($frm);
		if($frm["tka"]=='')
		$frm["tka"]=0.00;
		$sql="call sca_registra_tarifa_material(".$frm["IdMaterial"].",".$frm["tpkm"].",".$frm["tks"].",".$frm["tka"].",".$_SESSION["IdUsuarioAc"].",@Respuesta)";
		//$respuesta->alert($sql);
		$l = SCA::getConexion();
		$r=$l->consultar($sql);
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
			
				$respuesta->assign("div_estado","innerHTML",$estado);
		}
		return $respuesta;	
	}
	
	function registra_tarifa_tipo_ruta($frm)
	{
		$respuesta=new xajaxResponse();
		if($frm["tka"]=='')
		$frm["tka"]=0.00;
		echo $sql="call sca_registra_tarifa_tipo_ruta(".$frm["IdTipoRuta"].",".$frm["tpkm"].",".$frm["tks"].",".$frm["tka"].",".$_SESSION["IdUsuarioAc"].",@Respuesta)";
		//$respuesta->alert($sql);
		$l = SCA::getConexion();
		$r=$l->consultar($sql);
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
			$respuesta->assign("div_estado","innerHTML",$estado);
		}
		return $respuesta;	
	}
	
	function registra_tarifa_peso($frm)
	{
		$respuesta=new xajaxResponse();
		if($frm["tka"]=='')
		$frm["tka"]=0.00;
		$sql="call sca_registra_tarifa_peso(".$frm["IdMaterial"].",".$frm["tpkm"].",".$frm["tks"].",".$frm["tka"].",".$_SESSION["IdUsuarioAc"].",@Respuesta)";
		//$respuesta->alert($sql);
		$l = SCA::getConexion();
		$r=$l->consultar($sql);
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
			
				$respuesta->assign("div_estado","innerHTML",$estado);
		}
		return $respuesta;	
	}

?>