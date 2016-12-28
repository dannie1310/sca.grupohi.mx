<?php
function registra_viaje($i,$Accion,$IdViaje,$IdMaquinaria,$Horas,$IdOrigen,$TipoTarifa)
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		$SQLs = "call `scalerma`.`sca_sp_registra_viaje` (".$Accion.",".$IdViaje.",".$IdMaquinaria.",".$Horas.",".$IdOrigen.",".$_SESSION["IdUsuarioAc"].",'".$TipoTarifa."',@a);";
		
		$r=$l->consultar($SQLs);
		$r2=$l->consultar("select @a");
		$v2=$l->fetch($r2);
		
		if($Accion==1)
			{$desAccion2="Aprobado";
			$desAccion="Aprobar";}			
			else
			if($Accion==0)
			{$desAccion2="Rechazado";
			$desAccion="Rechazar";}
		if($v2["@a"]=='ok')
		{
			//$respuesta->alert($SQLs.' '.$v2["@a"]);
			if($Accion==1)
				$regresa_imagen='<img src="../../Imagenes/aprobado.gif" width="16px" heigth="16x" title="El viaje fue '.$desAccion2.' exitosamente"/>';
			else
			if($Accion==0)
				$regresa_imagen='<img src="../../Imagenes/rechazado.gif" width="16px" heigth="16x" title="El viaje fue '.$desAccion2.' exitosamente"/>';
				
			$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"   disabled />';
			$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  disabled />';
		}
		else
		if($v2["@a"]=='ko')
		{
			//$respuesta->alert($SQLs.' '.$v2["@a"]);
			$regresa_imagen='<img src="../../Imagenes/error.gif" width="16px" heigth="16x" title="Hubo un error al '.$desAccion.' el viaje"/>';	
		}
		
		
		$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
		$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);	
		$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);	
		
		$l->cerrar();
		return $respuesta;
	}
	
	function calculos_x_tipo_tarifa($tt,$m,$i,$o,$t,$c,$ch)
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		//$respuesta->alert('tt '.$tt.' m '.$m.' i '.$i.' o '.$o.' t '.$t.' c '.$c);

	if($tt=='r')	
	{
		$SQLs = "
SELECT 
concat('R-',r.IdRuta) as ruta,
r.IdRuta as idruta,
r.TotalKM as distancia,
tr.IdTarifaTipoRuta as tarifa_ruta,
tr.PrimerKM as tarifa_ruta_pk,
tr.KMSubsecuente as tarifa_ruta_ks,
tr.KMAdicional as tarifa_ruta_ka,
if(r.TotalKM>=30,4.40,tr.PrimerKM*1) as ImportePK_R,
if(r.TotalKM>=30,2.10*r.KmSubsecuentes,tr.KMSubsecuente*r.KmSubsecuentes) as ImporteKS_R,
tr.KMAdicional*r.KmAdicionales as ImporteKA_R,
if(if(r.TotalKM>=30,((4.40)+(2.10*r.KmSubsecuentes)+(tr.KMAdicional*r.KmAdicionales)),((tr.PrimerKM*1)+(tr.KMSubsecuente*r.KmSubsecuentes)+(tr.KMAdicional*r.KmAdicionales))) is null,'- - -',if(r.TotalKM>=30,((4.40)+(2.10*r.KmSubsecuentes)+(tr.KMAdicional*r.KmAdicionales)),((tr.PrimerKM*1)+(tr.KMSubsecuente*r.KmSubsecuentes)+(tr.KMAdicional*r.KmAdicionales)))) as importe,
c.CubicacionParaPago*1 as VolumenPK,
c.CubicacionParaPago*r.KmSubsecuentes as VolumenKS,
c.CubicacionParaPago*r.KmAdicionales as VolumenKA,
if(((c.CubicacionParaPago*1)+(c.CubicacionParaPago*r.KmSubsecuentes)+(c.CubicacionParaPago*r.KmAdicionales)) is null,'- - -',((c.CubicacionParaPago*1)+(c.CubicacionParaPago*r.KmSubsecuentes)+(c.CubicacionParaPago*r.KmAdicionales))) as VolumenTotal
from
camiones as c,
origenes as o  join
tiros as t  join
 rutas as r on(o.IdOrigen=r.IdOrigen AND t.IdTiro=r.IdTiro AND r.Estatus=1) left join
tarifas_tipo_ruta as  tr on(tr.IdTipoRuta=r.IdTipoRuta AND tr.Estatus=1)
WHERE 
c.IdCamion = ".$c." AND
t.IdTiro = ".$t." AND
o.IdOrigen=".$o."
";
		$r=$l->consultar($SQLs);
		$v=$l->fetch($r);
		$regresa=$v["importe"];
		
		$regresa_rut=$v["ruta"].'<input name="ruta'.$i.'" id="ruta'.$i.'" type="hidden" value="'.$v["idruta"].'" />';
		$regresa_dis=$v["distancia"].'<input name="distancia'.$i.'" id="distancia'.$i.'" type="hidden" value="'.$v["distancia"].'" />';
		$respuesta->assign('imp'.$i,'innerHTML',$regresa);
		$respuesta->assign('rut'.$i,'innerHTML',$regresa_rut);
		$respuesta->assign('dis'.$i,'innerHTML',$regresa_dis);

	}else
	{

		$SQLs = "SELECT
		concat('R-',r.IdRuta) as ruta,
		r.IdRuta as idruta,
		r.TotalKM as distancia,
		tm.IdTarifa as tarifa_material,
		tm.PrimerKM as tarifa_material_pk,
		tm.KMSubsecuente as tarifa_material_ks,
		tm.KMAdicional as tarifa_material_ka,
		tm.PrimerKM*1 as ImportePK_R,
		tm.KMSubsecuente*r.KmSubsecuentes as ImporteKS_M,
		tm.KMAdicional*r.KmAdicionales as ImporteKA_M,
		if(((tm.PrimerKM*1)+(tm.KMSubsecuente*r.KmSubsecuentes)+(tm.KMAdicional*r.KmAdicionales)) is null,'- - -',((tm.PrimerKM*1)+(tm.KMSubsecuente*r.KmSubsecuentes)+(tm.KMAdicional*r.KmAdicionales))) as ImporteTotal_M,
		if(((tm.PrimerKM*1)+(tm.KMSubsecuente*r.KmSubsecuentes)+(tm.KMAdicional*r.KmAdicionales)) is null,'- - -', ((tm.PrimerKM*1)+(tm.KMSubsecuente*r.KmSubsecuentes)+(tm.KMAdicional*r.KmAdicionales))) as importe,
		c.CubicacionParaPago*1 as VolumenPK,
		c.CubicacionParaPago*r.KmSubsecuentes as VolumenKS,
		c.CubicacionParaPago*r.KmAdicionales as VolumenKA,
		if(((c.CubicacionParaPago*1)+(c.CubicacionParaPago*r.KmSubsecuentes)+(c.CubicacionParaPago*r.KmAdicionales)) is null,'- - -',((c.CubicacionParaPago*1)+(c.CubicacionParaPago*r.KmSubsecuentes)+(c.CubicacionParaPago*r.KmAdicionales))) as VolumenTotal
		from
		camiones as c,
		origenes as o  join
		tiros as t  join
		 rutas as r on(o.IdOrigen=r.IdOrigen AND t.IdTiro=r.IdTiro AND r.Estatus=1),
		 materiales as m left join
		tarifas as  tm on(tm.IdMaterial=m.IdMaterial and tm.Estatus=1)
		where 
		c.IdCamion = ".$c." AND
		t.IdTiro = ".$t." AND
		o.IdOrigen=".$o." AND 
		m.IdMaterial=".$m."";
		
		$r=$l->consultar($SQLs);
		$v=$l->fetch($r);
		$regresa=$v["ImporteTotal_M"];
		$regresa_rut=$v["ruta"].'<input name="ruta'.$i.'" id="ruta'.$i.'" type="hidden" value="'.$v["idruta"].'" />';
		$regresa_dis=$v["distancia"].'<input name="distancia'.$i.'" id="distancia'.$i.'" type="hidden" value="'.$v["distancia"].'" />';
		$respuesta->assign('imp'.$i,'innerHTML',$regresa);
		$respuesta->assign('rut'.$i,'innerHTML',$regresa_rut);
		$respuesta->assign('dis'.$i,'innerHTML',$regresa_dis);

	}
		
			if($v["ruta"]!=''&&$v["importe"]!='- - -')
			{
				$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"  onclick="clic(\'r'.$i.'\')" checked style="cursor:pointer" />';
				$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  onclick="clic(\'a'.$i.'\')" style="cursor:pointer" />';
				$regresa_imagen='<img src="../../Imagenes/bgreen.gif" width="16px" heigth="16x"/>';
				$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
				$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);	
				$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);	
			}
			else
			{
				if($v["ruta"]=='')
				{
					$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque no existe una ruta entre su origen y destino"/>';
				}
				else
				{
					if($v["importe"]=='- - -')
					{
						$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque no hay una tarifa definida"/>';
					}
				}
				$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"  onclick="clic(\'r'.$i.'\')" disabled />';
				$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  onclick="clic(\'a'.$i.'\')" checked/>';
				$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
				$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);
				$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);	
			}
		
		
		$l->cerrar();
		return $respuesta;
	}

?>