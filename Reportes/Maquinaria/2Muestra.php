<?php 	
	session_start();
    if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
        exit();
    }

	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Acarreos Ejecutados por Maquina '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Rangos.php");

	$fi=$_REQUEST["inicial"];
	$ff=$_REQUEST["final"];
	$rango=rango($fi,$ff,1);
	$lon_fechas=sizeof($rango);
	$link=SCA::getConexion();
	$sql="select distinct v.IdTiro as IdTiro, t.Descripcion as Tiro from viajes as v, tiros as t where v.FechaLlegada between '".fechasql($fi)."' and '".fechasql($ff)."' and v.IdTiro=t.IdTiro and v.IdMaquinaria!=0 order by t.Descripcion";
	//echo $sql;
	$r_tiro_f=$link->consultar($sql);
	$mm=0;
	while($v_tiro_f=mysql_fetch_array($r_tiro_f))
	{
		$tiros[$mm]=$v_tiro_f["IdTiro"];
			for($i=0;$i<$lon_fechas;$i++)
			{
		
			$sql="select distinct v.IdMaquinaria as IdMaquinaria, t.Economico as Maquinaria from viajes as v, maquinaria as t where v.FechaLlegada ='".fechasql($rango[$i])."' and v.IdMaquinaria=t.IdMaquinaria and v.IdMaquinaria!=0 and v.IdTiro=".$v_tiro_f["IdTiro"]." order by t.Economico";
			//echo $sql;
			$r_maq=$link->consultar($sql);
			$j=0;
				while($v_maq=mysql_fetch_array($r_maq))
				{
					$Maquinaria[$v_tiro_f["IdTiro"]][$rango[$i]][$j]=$v_maq["Maquinaria"];
					$IdMaquinaria[$v_tiro_f["IdTiro"]][$rango[$i]][$j]=$v_maq["IdMaquinaria"];
					
					//echo $v_tiro_f["IdTiro"].'-'.$rango[$i].'-'.$j.'-'.$v_maq["Maquinaria"].'<br>';
					$j++;
		
				}
			}
		$mm++;
	}
	
	/*for($i=0;$i<$lon_fechas;$i++)
	{

	$sql="select distinct v.IdMaquinaria as IdMaquinaria, t.Economico as Maquinaria from viajes as v, maquinaria as t where v.FechaLlegada ='".fechasql($rango[$i])."' and v.IdMaquinaria=t.IdMaquinaria and v.IdMaquinaria!=0 order by t.Economico";
	//echo $sql;
	$r_maq=$link->consultar($sql);
	$j=0;
		while($v_maq=mysql_fetch_array($r_maq))
		{
			$Maquinaria[$rango[$i]][$j]=$v_maq["Maquinaria"];
			//$fecha["Maquinaria"][$i]=$v_maq["Maquinaria"];
			//echo $rango[$i].'<br>';
			$j++;

		}
	}*/
	//$ancho_tiro=0;
	for($i=0;$i<sizeof($tiros);$i++)
	{
		$ancho_tiro[$tiros[$i]]=0;
		for($q=0;$q<sizeof($rango);$q++)
		{
			//echo "$q<br>";
			//echo 'sss: '.$tiros[$i].'-'.$rango[$q].'-'.sizeof($Maquinaria[$tiros[$i]][$rango[$q]]).'<br>';
			if(sizeof($Maquinaria[$tiros[$i]][$rango[$q]])==0)
			{
				$ancho_tiro[$tiros[$i]]=$ancho_tiro[$tiros[$i]]+1;
			}
			else
			$ancho_tiro[$tiros[$i]]=$ancho_tiro[$tiros[$i]]+sizeof($Maquinaria[$tiros[$i]][$rango[$q]]);
		
		}
		//echo $Maquinaria[$rango[$i]][$q].sizeof($Maquinaria[$rango[$i]][$q]).'<br>';
		/*if(sizeof($Maquinaria[$rango[$i]])==0)
		$suma=1;
		else
		$suma=sizeof($Maquinaria[$rango[$i]]);
		$ancho_fechas=$ancho_fechas+$suma;*/
		//echo $i.'-'.$Maquinaria[$rango[$i]];
		/*for($m=0;$m<sizeof($Maquinaria[$rango[$i]]);$m++)
		{
			//echo $rango[$i].'-'.$Maquinaria[$rango[$i]][$m].'<br>';
			echo $rango[$i].'-'.sizeof($Maquinaria[$rango[$i]]).'-'.$Maquinaria[$rango[$i]][$m].'<br>';
		}*/
	}
	
for($i=0;$i<sizeof($tiros);$i++)
	{
		//echo $i;
		$arreglo_anchos[$i]=$ancho_tiro[$tiros[$i]];
		//echo $arreglo_anchos[$i].'<br>';
	}
	asort($arreglo_anchos);
	//echo $arreglo_anchos[0];

$sql="select distinct v.IdTiro as IdTiro, t.Descripcion as Tiro from viajes as v, tiros as t where v.FechaLlegada between '".fechasql($fi)."' and '".fechasql($ff)."' and v.IdTiro=t.IdTiro and v.IdMaquinaria!=0 order by t.Descripcion";
	//echo $sql;
	$r_tiro=$link->consultar($sql);
	$existe=$link->affected();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
Body
{
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;		
}
#Tiro {
	color: #FFF;
	font-weight:bold;
	font-size:13px;
	background-color:#000;
}
#Camion {
	color: #000;
	font-weight:bold;
	font-size:12px;
	background-color:#CCC;
}
#Totales {
	color: #FFF;
	font-weight:bold;
	font-size:12px;
	background-color:#666;
}
#Maquina {
	color: #000;
	font-weight:bold;
	font-size:11px;
	background-color:#FFF;
}
#Subtotal
{
	color: #000;
	font-weight:bold;
	font-size:11px;
	background-color:#666;
}
#Total
{
	color: #FFF;
	font-weight:bold;
	font-size:11px;
	background-color:#000;
}
-->
</style>
</head>

<body>
<?php 
if($existe>0)
{
?>
<table  border="1" bordercolor="#FFFFFF">
<tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">REPORTE POR PERIODO DE MOVIMIENTO DE TIERRAS POR TIRO DEL <?PHP echo $fi; ?> AL <?PHP echo $ff; ?></font></td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"  align="center"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo utf8_encode($_SESSION[DescripcionProyecto]); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"  align="center">&nbsp;</td>
  </tr>
  </table>
  
<?php while($v_tiro=mysql_fetch_array($r_tiro)){?>
 <table border="1" bordercolor="#FFF" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="<?php echo $ancho_tiro[$v_tiro["IdTiro"]]+4 ?>"  id="Tiro"><?php echo $v_tiro["Tiro"]; ?>&nbsp;</td>
    
  </tr>
   <tr>
    <td colspan="2"  id="Camion">PERIODO</td>
   <?php for($i=0;$i<$lon_fechas;$i++){?>
     <td align="center" id="Camion" colspan="<?php echo sizeof($Maquinaria[$v_tiro["IdTiro"]][$rango[$i]]) ?>" ><?php echo $rango[$i] ?></td>
    <?php }?>
     <td colspan="2" rowspan="2"  id="Camion">TOTAL PERIODO</td>
  </tr>
  <tr>
    <td colspan="2"  id="Camion">DATOS DE CAMIÓN</td>
  
     <td align="center" id="Camion" colspan="<?php echo $ancho_tiro[$v_tiro["IdTiro"]] ?>">EQUIPOS DE CARGA</td>
   
    
  </tr>
     <tr>
    <td align="center"  id="Camion">ECO.</td>
    <td align="center"  id="Camion">CAP.</td>
   <?php for($i=0;$i<$lon_fechas;$i++){?>
   	<?php
	if(sizeof($Maquinaria[$v_tiro["IdTiro"]][$rango[$i]])==0)
	{?>
	   <td align="center" id="Camion" >- - -</td>
	<?php }
	else
		for($m=0;$m<sizeof($Maquinaria[$v_tiro["IdTiro"]][$rango[$i]]);$m++)
		{
			
		?>
     <td align="center" id="Camion" ><?php echo $Maquinaria[$v_tiro["IdTiro"]][$rango[$i]][$m] ?></td>
    <?php }?>
    <?php }?>
     <td align="center"  id="Camion">m<sup>3</sup></td>
     <td align="center"   id="Camion">IMPORTE</td>
   </tr>
   <?php 
   $sql_camiones="select distinct v.IdCamion as IdCamion, t.CubicacionParaPago as Capacidad, t.Economico as Camion from viajes as v, camiones as t where v.FechaLlegada between '".fechasql($fi)."' and '".fechasql($ff)."' and v.IdTiro=".$v_tiro["IdTiro"]." and v.IdCamion=t.IdCamion and v.IdMaquinaria!=0 order by t.Economico";
   //echo $sql_camiones;
   $r_camiones=$link->consultar($sql_camiones);
   while($v_camiones=mysql_fetch_array($r_camiones)){
   ?>
   <tr>
   <td id="Maquina"><?php echo $v_camiones["Camion"] ?></td>
   <td id="Maquina"><?php echo $v_camiones["Capacidad"] ?></td>
   <?php 
   for($m2=0;$m2<sizeof($rango);$m2++)
		{
			if(sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]])>0)
			{
				for($m3=0;$m3<sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]]);$m3++)
				{
	   $sql_camiones_volumen="select sum(v.Volumen) as Volumen from viajes as v where v.FechaLlegada='".fechasql($rango[$m2])."' and v.IdTiro=".$v_tiro["IdTiro"]." and v.IdCamion=".$v_camiones["IdCamion"]." and v.IdMaquinaria=".$IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]][$m3]." ";
	  // echo $sql_camiones_volumen;
	   $r_camiones_volumen=$link->consultar($sql_camiones_volumen);
				   while($v_camiones_volumen=mysql_fetch_array($r_camiones_volumen))
				   {?>
     <td id="Maquina">
					   <?php echo number_format($v_camiones_volumen["Volumen"],2,".",",") ?>
					   </td>
				   <?php 
				   }
				}
			}
			else
			{?>
				<td align="center">- - -</td>
			<?php 
			}
			
		}
		
		$sql_total="select sum(Volumen) as Volumen, sum(Importe) as Importe from viajes where IdTiro=".$v_tiro["IdTiro"]." and IdCamion=".$v_camiones["IdCamion"]." and IdMaquinaria!=0";
		//echo $sql_total;
		$r_total=$link->consultar($sql_total);
		$v_total=mysql_fetch_array($r_total);
		
		?>
     <td id="Maquina"><?php echo number_format($v_total["Volumen"],2,".",",") ?>&nbsp;</td>
        <td id="Maquina"><?php echo number_format($v_total["Importe"],2,".",",") ?></td>
        
        
   </tr>
   <?php 
   } ?>
   
   
   
      <tr>
   <td colspan="2" align="right" id="Subtotal">Subtotal:</td>
   <?php 
   for($m2=0;$m2<sizeof($rango);$m2++)
		{
			if(sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]])>0)
			{
				for($m3=0;$m3<sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]]);$m3++)
				{
	   $sql_camiones_volumen="select sum(v.Volumen) as Volumen from viajes as v where v.FechaLlegada='".fechasql($rango[$m2])."' and v.IdTiro=".$v_tiro["IdTiro"]."  and v.IdMaquinaria=".$IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]][$m3]." ";
	  // echo $sql_camiones_volumen;
	   $r_camiones_volumen=$link->consultar($sql_camiones_volumen);
				   while($v_camiones_volumen=mysql_fetch_array($r_camiones_volumen))
				   {?>
     <td id="Subtotal">
					   <?php echo number_format($v_camiones_volumen["Volumen"],2,".",",") ?>
	    </td>
				   <?php 
				   }
				}
			}
			else
			{?>
				<td align="center" id="Subtotal">- - -</td>
			<?php 
			}
			
		}
		
		$sql_total="select sum(Volumen) as Volumen, sum(Importe) as Importe from viajes where IdTiro=".$v_tiro["IdTiro"]."  and IdMaquinaria!=0";
		//echo $sql_total;
		$r_total=$link->consultar($sql_total);
		$v_total=mysql_fetch_array($r_total);
		
		?>
     <td id="Total"><?php echo number_format($v_total["Volumen"],2,".",",") ?>&nbsp;</td>
        <td id="Total"><?php echo number_format($v_total["Importe"],2,".",",") ?></td>
        
        
   </tr>
   
    <tr>
   <td colspan="2" align="right" id="Subtotal">Horas Efectivas:</td>
   <?php 
   for($m2=0;$m2<sizeof($rango);$m2++)
		{
			if(sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]])>0)
			{
				for($m3=0;$m3<sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]]);$m3++)
				{
	   $sql_camiones_volumen="select sum(v.HorasEfectivas) as HorasEfectivas from viajes as v where v.FechaLlegada='".fechasql($rango[$m2])."' and v.IdTiro=".$v_tiro["IdTiro"]."  and v.IdMaquinaria=".$IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]][$m3]." ";
	  // echo $sql_camiones_volumen;
	   $r_camiones_volumen=$link->consultar($sql_camiones_volumen);
				   while($v_camiones_volumen=mysql_fetch_array($r_camiones_volumen))
				   {?>
     <td id="Subtotal">
					   <?php echo number_format($v_camiones_volumen["HorasEfectivas"],2,".",",") ?>
	    </td>
				   <?php 
				   }
				}
			}
			else
			{?>
				<td align="center" id="Subtotal">- - -</td>
			<?php 
			}
			
		}
		
		$sql_total="select sum(HorasEfectivas) as HorasEfectivas from viajes where IdTiro=".$v_tiro["IdTiro"]."  and IdMaquinaria!=0";
		//echo $sql_total;
		$r_total=$link->consultar($sql_total);
		$v_total=mysql_fetch_array($r_total);
		
		?>
     <td id="Total"><?php echo number_format($v_total["HorasEfectivas"],2,".",",") ?>&nbsp;</td>
        <td id="Maquina" bordercolor="#FFFFFF">&nbsp;</td>
        
        
   </tr>
   
    <tr>
   <td colspan="2" align="right" id="Total">Rendimiento:</td>
   <?php 
   for($m2=0;$m2<sizeof($rango);$m2++)
		{
			if(sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]])>0)
			{
				for($m3=0;$m3<sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]]);$m3++)
				{
	   $sql_camiones_volumen="select sum(v.Volumen) as Volumen, sum(v.HorasEfectivas) as HorasEfectivas from viajes as v where v.FechaLlegada='".fechasql($rango[$m2])."' and v.IdTiro=".$v_tiro["IdTiro"]."  and v.IdMaquinaria=".$IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]][$m3]." ";
	  // echo $sql_camiones_volumen;
	   $r_camiones_volumen=$link->consultar($sql_camiones_volumen);
				   while($v_camiones_volumen=mysql_fetch_array($r_camiones_volumen))
				   {?>
     <td id="Total">
					   <?php echo number_format($v_camiones_volumen["Volumen"]/$v_camiones_volumen["HorasEfectivas"],2,".",",") ?>
	    </td>
				   <?php 
				   }
				}
			}
			else
			{?>
				<td align="center" id="Total">- - -</td>
			<?php 
			}
			
		}
		
		$sql_total="select sum(HorasEfectivas) as HorasEfectivas, sum(Volumen) as Volumen from viajes where IdTiro=".$v_tiro["IdTiro"]."  and IdMaquinaria!=0";
		//echo $sql_total;
		$r_total=$link->consultar($sql_total);
		$v_total=mysql_fetch_array($r_total);
		
		?>
     <td id="Total"><?php echo number_format($v_total["Volumen"]/$v_total["HorasEfectivas"],2,".",",") ?>&nbsp;</td>
        <td id="Maquina" bordercolor="#FFFFFF">&nbsp;</td>
        
        
   </tr>
   
       <tr>
   <td colspan="2" align="right" id="Maquinaria" bordercolor="#FFFFFF">&nbsp;</td>
   <?php 
   for($m2=0;$m2<sizeof($rango);$m2++)
		{
			if(sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]])>0)
			{
				for($m3=0;$m3<sizeof($IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]]);$m3++)
				{
	   $sql_camiones_volumen="select sum(v.Volumen) as Volumen, sum(v.HorasEfectivas) as HorasEfectivas from viajes as v where v.FechaLlegada='".fechasql($rango[$m2])."' and v.IdTiro=".$v_tiro["IdTiro"]."  and v.IdMaquinaria=".$IdMaquinaria[$v_tiro["IdTiro"]][$rango[$m2]][$m3]." ";
	  // echo $sql_camiones_volumen;
	   $r_camiones_volumen=$link->consultar($sql_camiones_volumen);
				   while($v_camiones_volumen=mysql_fetch_array($r_camiones_volumen))
				   {?>
     <td id="Maquinaria" bordercolor="#FFFFFF">&nbsp;</td>
				   <?php 
				   }
				}
			}
			else
			{?>
				<td align="center" id="Maquinaria" bordercolor="#FFFFFF">&nbsp;</td>
			<?php 
			}
			
		}
		
		$sql_total="select sum(HorasEfectivas) as HorasEfectivas, sum(Volumen) as Volumen from viajes where IdTiro=".$v_tiro["IdTiro"]."  and IdMaquinaria!=0";
		//echo $sql_total;
		$r_total=$link->consultar($sql_total);
		$v_total=mysql_fetch_array($r_total);
		
		?>
     <td id="Maquinaria" bordercolor="#FFFFFF">&nbsp;</td>
        <td id="Maquina" bordercolor="#FFFFFF">&nbsp;</td>
        
        
   </tr>
   
    </table>
  <?php }
} else {?>
	
	<table  border="1" bordercolor="#FFFFFF">
<tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">NO HAY DATOS QUE MOSTRAR, VERIFIQUE QUE LOS VIAJES TENGAN EQUIPO DE CARGA ASIGNADO</font></td>
  </tr>
  <tr>
    <td colspan="<?php echo 4+$arreglo_anchos[0] ?>"  align="center">&nbsp;</td>
  </tr>
  </table>
	<?php }?>
</body>
</html>