<?php
function registra_viaje($i,$Accion,$IdViaje,$IdMaquinaria,$Horas,$IdOrigen,$TipoTarifa,$TipoFda,$Tara=0.00,$Bruto=0.00)
	{
		$respuesta=new xajaxResponse();
		//$l = SCA::getConexion();
		$l = $GLOBALS["l"];
		$SQLs = "call `sca_sp_registra_viaje_fda` (".$Accion.",".$IdViaje.",".$IdMaquinaria.",".$Horas.",".$IdOrigen.",".$_SESSION["IdUsuarioAc"].",'".$TipoTarifa."','".$TipoFda."','".$Tara."','".$Bruto."',@a);";
	//	$respuesta->alert($SQLs);
		
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
			if($TipoTarifa=='p')
			{
				$regresa_tr="<span class=\'detalle\'>Peso</span>";
				
				
			}
			else
			if($TipoTarifa=='r')
			{
				$regresa_tr="<span class=\'detalle\'>Ruta</span>";
			}
			$respuesta->assign('dtarifa'.$i,'innerHTML',$regresa_tr);
			
			if($TipoFda=='m')
			{
				$regresa_fda="<span class=\'detalle\'>Material</span>";
			}
			else
			if($TipoFda=='bm')
			{
				$regresa_fda="<span class=\'detalle\'>Ban-Mat</span>";
			}
			$respuesta->assign('dtara'.$i,'innerHTML',$Tara);
			$respuesta->assign('dbruto'.$i,'innerHTML',$Bruto);
			$respuesta->assign('dfda'.$i,'innerHTML',$regresa_fda);
		}
		else
		if($v2["@a"]=='ko')
		{
			//$respuesta->alert($SQLs.' '.$v2["@a"]);
			$regresa_imagen='<img src="../../Imagenes/error.gif" width="16px" heigth="16x" title="Hubo un error al '.$desAccion.' el viaje"/>';	
			$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"   />';
			$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  />';

		}
		
		//$regresa_imagen.= $SQLs;
		$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
		$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);	
		$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);	
		
		$l->cerrar();
		return $respuesta;
	}
	
	function calculos_x_tipo_tarifa($tt,$m,$i,$o,$t,$c,$id_viaje,$tara=0,$bruto=0)
	{
		$respuesta=new xajaxResponse();
		 $neto = abs($tara-$bruto)/1000;
		 //echo $neto.'-->';
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
				$regresa= $v["importe"]!='- - -'? number_format($v["importe"],2) : $v["importe"];
				
				$regresa_rut=$v["ruta"].'<input name="ruta'.$i.'" id="ruta'.$i.'" type="hidden" value="'.$v["idruta"].'" />';
				$regresa_dis=$v["distancia"].'<input name="distancia'.$i.'" id="distancia'.$i.'" type="hidden" value="'.$v["distancia"].'" />';
				$respuesta->assign('imp'.$i,'innerHTML',$regresa);
				$respuesta->assign('rut'.$i,'innerHTML',$regresa_rut);
				$respuesta->assign('dis'.$i,'innerHTML',$regresa_dis);
		
				$respuesta->assign('dpk'.$i,'innerHTML', $v["tarifa_ruta_pk"]!='- - -'? number_format($v["tarifa_ruta_pk"],2):$v["tarifa_ruta_pk"]);
				$respuesta->assign('dks'.$i,'innerHTML',$v["tarifa_ruta_ks"]!='- - -'? number_format($v["tarifa_ruta_ks"],2):$v["tarifa_ruta_ks"]);
				$respuesta->assign('dka'.$i,'innerHTML',$v["tarifa_ruta_ka"]!='- - -'? number_format($v["tarifa_ruta_ka"],2):$v["tarifa_ruta_ka"]);
		
			}else if($tt=='m')
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
				$regresa= number_format($v["ImporteTotal_M"],2);
				$regresa_rut=$v["ruta"].'<input name="ruta'.$i.'" id="ruta'.$i.'" type="hidden" value="'.$v["idruta"].'" />';
				$regresa_dis=$v["distancia"].'<input name="distancia'.$i.'" id="distancia'.$i.'" type="hidden" value="'.$v["distancia"].'" />';
				$respuesta->assign('imp'.$i,'innerHTML',$regresa);
				$respuesta->assign('rut'.$i,'innerHTML',$regresa_rut);
				$respuesta->assign('dis'.$i,'innerHTML',$regresa_dis);
		
				$respuesta->assign('dpk'.$i,'innerHTML',number_format($v["tarifa_material_pk"],2));
				$respuesta->assign('dks'.$i,'innerHTML',number_format($v["tarifa_material_ks"],2));
				$respuesta->assign('dka'.$i,'innerHTML',number_format($v["tarifa_material_ka"],2));
		
			}
			else if($tt=="p")
			{
				if($tara>0&&$bruto>0)
				{
				 $SQLs = "SELECT
				concat('R-',r.IdRuta) as ruta,
				r.IdRuta as idruta,
				r.TotalKM as distancia,
				tm.IdTarifa as tarifa_material,
		
		if(tm.PrimerKM is null,'- - -',tm.PrimerKM)  as tarifa_material_pk,
		if(tm.KMSubsecuente is null,'- - -',tm.KMSubsecuente)  as tarifa_material_ks,
		if(tm.KMAdicional is null,'- - -',tm.KMAdicional)  as tarifa_material_ka,
		
				tm.PrimerKM*1*".$neto." as ImportePK_R,
					tm.KMSubsecuente*r.KmSubsecuentes*".$neto." as ImporteKS_M,
					tm.KMAdicional*r.KmAdicionales*".$neto." as ImporteKA_M,
					if(((tm.PrimerKM*1*".$neto.")+(tm.KMSubsecuente*r.KmSubsecuentes*".$neto.")+(tm.KMAdicional*r.KmAdicionales*".$neto.")) is null,'- - -',((tm.PrimerKM*1*".$neto.")+(tm.KMSubsecuente*r.KmSubsecuentes*".$neto.")+(tm.KMAdicional*r.KmAdicionales*".$neto."))) as ImporteTotal_M,
					if(((tm.PrimerKM*1*".$neto.")+(tm.KMSubsecuente*r.KmSubsecuentes*".$neto.")+(tm.KMAdicional*r.KmAdicionales*".$neto.")) is null,'- - -', ((tm.PrimerKM*1*".$neto.")+(tm.KMSubsecuente*r.KmSubsecuentes*".$neto.")+(tm.KMAdicional*r.KmAdicionales*".$neto."))) as importe,		
			
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
					tarifas_peso as  tm on(tm.IdMaterial=m.IdMaterial and tm.Estatus=1)
					where 
					c.IdCamion = ".$c." AND
					t.IdTiro = ".$t." AND
					o.IdOrigen=".$o." AND 
					m.IdMaterial=".$m."";
					
					$r=$l->consultar($SQLs);
					$v=$l->fetch($r);
					$regresa=number_format($v["ImporteTotal_M"],2);
					$regresa_rut=$v["ruta"].'<input name="ruta'.$i.'" id="ruta'.$i.'" type="hidden" value="'.$v["idruta"].'" />';
					$regresa_dis=$v["distancia"].'<input name="distancia'.$i.'" id="distancia'.$i.'" type="hidden" value="'.$v["distancia"].'" />';
					$respuesta->assign('imp'.$i,'innerHTML',$regresa);
					$respuesta->assign('rut'.$i,'innerHTML',$regresa_rut);
					$respuesta->assign('dis'.$i,'innerHTML',$regresa_dis);
			
					$respuesta->assign('dpk'.$i,'innerHTML',number_format($v["tarifa_material_pk"],2));
					$respuesta->assign('dks'.$i,'innerHTML',number_format($v["tarifa_material_ks"],2));
					$respuesta->assign('dka'.$i,'innerHTML',number_format($v["tarifa_material_ka"],2));
				}
				else
				{
					$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque el peso tara o peso bruto es igual a cero"/>';
					$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"  onclick="clic(\'r'.$i.'\')" disabled />';
					$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  onclick="clic(\'a'.$i.'\')" checked/>';
					$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
					$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);
					$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);
					
					$respuesta->assign('dpk'.$i,'innerHTML','- - -');
					$respuesta->assign('dks'.$i,'innerHTML','- - -');
					$respuesta->assign('dka'.$i,'innerHTML','- - -');
					$respuesta->assign('imp'.$i,'innerHTML','- - -');

					return $respuesta;
					exit();
				}
			}
			$SQLs = "
			select 
				v.Estatus,
				ROUND((HOUR(TIMEDIFF(v.HoraLlegada,v.HoraSalida))*60)+(MINUTE(TIMEDIFF(v.HoraLlegada,v.HoraSalida)))+(SECOND(TIMEDIFF(v.HoraLlegada,v.HoraSalida))/60),2) AS tiempo,
				if(cn.TiempoMinimo-cn.Tolerancia is null,0.0,cn.TiempoMinimo-cn.Tolerancia) as cronometria,
				cn.TiempoMinimo
			from 
				viajesnetos as v left join
	 rutas as r on(v.IdOrigen=r.IdOrigen AND v.IdTiro=r.IdTiro AND r.Estatus=1) left join cronometrias as cn on (cn.IdRuta=r.IdRuta AND cn.Estatus=1)
			where 
				IdViajeNeto = ".$id_viaje;
				//$respuesta->alert($SQLs);
				$rv=$l->consultar($SQLs);
				$v_viajes=$l->fetch($rv);
				
				if($v["ruta"]==''||$v["importe"]=='- - -'||($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))) 
				{
					if($v["ruta"]=='')
					{
						$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque no existe una ruta entre su origen y destino"/>';
					}
					if($v["importe"]=='- - -')
					{
						$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque no hay una tarifa definida"/>';
					}
					if($v_viajes["Estatus"]==0&&($v_viajes["tiempo"]==0||($v_viajes["tiempo"]<$v_viajes["cronometria"])))
					{
						$regresa_imagen='<img src="../../Imagenes/bred.gif" width="16px" heigth="16px" title="El viaje no puede ser registrado porque no cumple con los tiempos de cronometria de la ruta"/>';
					}
					$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"  onclick="clic(\'r'.$i.'\')" disabled />';
					$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  onclick="clic(\'a'.$i.'\')" checked/>';
					$respuesta->assign('ch'.$i,'innerHTML',$regresa_ch);		
					$respuesta->assign('nch'.$i,'innerHTML',$regresa_nch);
					$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);
					
					

				}
				else
				{
					$regresa_ch='<input type="checkbox" name="a'.$i.'" id="a'.$i.'"  onclick="clic(\'r'.$i.'\')" checked style="cursor:pointer" />';
					$regresa_nch='<input type="checkbox" name="r'.$i.'" id="r'.$i.'"  onclick="clic(\'a'.$i.'\')" style="cursor:pointer" />';
					$regresa_imagen='<img src="../../Imagenes/bgreen.gif" width="16px" heigth="16x"/>';
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
