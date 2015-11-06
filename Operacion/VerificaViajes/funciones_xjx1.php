<?php
function registra_viaje($i,$Accion,$IdViaje,$IdMaquinaria,$Horas,$IdOrigen,$TipoTarifa)
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		$SQLs = "call `sca_sp_registra_viaje` (".$Accion.",".$IdViaje.",".$IdMaquinaria.",".$Horas.",".$IdOrigen.",".$_SESSION["IdUsuarioAc"].",'".$TipoTarifa."',@a);";
		
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

			if($TipoTarifa=='m')
			{
				$regresa_tr="<span class=\'detalle\'>Material</span>";
			}
			else
			if($TipoTarifa=='r')
			{
				$regresa_tr="<span class=\'detalle\'>Ruta</span>";
			}
			$respuesta->assign('dtarifa'.$i,'innerHTML',$regresa_tr);
		}
		else
		if($v2["@a"]=='ko')
		{
			//$respuesta->alert($SQLs.' '.$v2["@a"]);
			$regresa_imagen='<img src="../../Imagenes/error.gif" width="16px" heigth="16x" title="Hubo un error al '.$desAccion.' el viaje"/>';	
			$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"   />';
			$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  />';

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
if($o!='A99')
	{
	if($tt=='r')	
	{
		$SQLs = "
SELECT 
concat('R-',r.IdRuta) as ruta,
r.IdRuta as idruta,
r.TotalKM as distancia,
tr.IdTarifaTipoRuta as tarifa_ruta,
if(r.TotalKM>=30,4.40,if(tr.PrimerKM is null,'- - -',tr.PrimerKM))  as tarifa_ruta_pk,
if(r.TotalKM>=30,2.10,if(tr.KMSubsecuente is null,'- - -',tr.KMSubsecuente))  as tarifa_ruta_ks,
if(r.TotalKM>=30,0.00,if(tr.KMAdicional is null,'- - -',tr.KMAdicional))  as tarifa_ruta_ka,

if(r.TotalKM>=30,4.40*c.CubicacionParaPago,tr.PrimerKM*1*c.CubicacionParaPago) as ImportePK_R,
if(r.TotalKM>=30,2.10*r.KmSubsecuentes*c.CubicacionParaPago,tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago) as ImporteKS_R,
if(r.TotalKM>=30,2.10*r.KmAdicionales*c.CubicacionParaPago,tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago) as ImporteKA_R,
if(if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(0*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) is null,'- - -',if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(0.00*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)))) as importe,c.CubicacionParaPago*1 as VolumenPK,

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

		$respuesta->assign('dpk'.$i,'innerHTML',$v["tarifa_ruta_pk"]);
		$respuesta->assign('dks'.$i,'innerHTML',$v["tarifa_ruta_ks"]);
		$respuesta->assign('dka'.$i,'innerHTML',$v["tarifa_ruta_ka"]);

	}else
	{

		$SQLs = "SELECT
		concat('R-',r.IdRuta) as ruta,
		r.IdRuta as idruta,
		r.TotalKM as distancia,
		tm.IdTarifa as tarifa_material,

if(tm.PrimerKM is null,'- - -',tm.PrimerKM)  as tarifa_material_pk,
if(tm.KMSubsecuente is null,'- - -',tm.KMSubsecuente)  as tarifa_material_ks,
if(tm.KMAdicional is null,'- - -',tm.KMAdicional)  as tarifa_material_ka,

		tm.PrimerKM*1*c.CubicacionParaPago as ImportePK_R,
		tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago as ImporteKS_M,
		tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago as ImporteKA_M,
		if(((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)) is null,'- - -',((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) as ImporteTotal_M,
		if(((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)) is null,'- - -', ((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) as importe,		

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

				$respuesta->assign('dpk'.$i,'innerHTML',$v["tarifa_material_pk"]);
				$respuesta->assign('dks'.$i,'innerHTML',$v["tarifa_material_ks"]);
				$respuesta->assign('dka'.$i,'innerHTML',$v["tarifa_material_ka"]);

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
		
		}
		else
		{
			$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque debe seleccionar primero el origen del viaje"/>';
			$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"  onclick="clic(\'r'.$i.'\')" disabled />';
			$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  onclick="clic(\'a'.$i.'\')" checked/>';
			$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
			$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);
			$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);

			$respuesta->assign('dpk'.$i,'innerHTML','- - -');
			$respuesta->assign('dks'.$i,'innerHTML','- - -');
			$respuesta->assign('dka'.$i,'innerHTML','- - -');
			$respuesta->assign('imp'.$i,'innerHTML','- - -');

		}
		$l->cerrar();
		return $respuesta;
	}

?>