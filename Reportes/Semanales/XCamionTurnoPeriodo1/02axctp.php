<?php
  /*include("../../../Clases/Conexiones/Conexion.php");
	include("../../../inc/funciones/formato_fecha_ingles.php");*/
	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	
  $fi    = $_REQUEST["fi"];
	$ff    = $_REQUEST["ff"];
	
  $fi_fi = fechasql($_REQUEST["fi"]);
	$ff_fi = fechasql($_REQUEST["ff"]);
	
	//$link = conectar();
	$SCA = SCA::getConexion();
	$SQL = " CREATE TEMPORARY TABLE viajes_reporte
	         (
						SELECT
							1 as turno,
							economico,
							DATE_FORMAT(fechallegada, '%e/%m/%Y') as fechalleg,
							cubicacion,
							COUNT(idviaje) as viajes,
							material,
							idorigen,
							origen,
							idtiro,
							destino,
							distancia as distancia,
							SUM(volumenprimerkm) as volumenprimerkm,
							SUM(volumenkmsubsecuentes) as volumenkmsubsecuentes,
							SUM(volumenkmadicionales) as volumenkmadicionales,
							SUM(volumen) as volumen,
							SUM(importeprimerkm) as importeprimerkm,
							SUM(importekmsubsecuentes) as importekmsubsecuentes,
							SUM(importekmadicionales) as importekmadicionales,
							SUM(importe) as importe
						FROM
							vw_viajes
						WHERE
							fechallegada BETWEEN '".$fi_fi."' AND '".$ff_fi."'
							AND horallegada BETWEEN '07:00:01' AND '18:00:00'
						GROUP BY
							turno,
							economico,
							fechallegada,
							cubicacion,
							material,
							idorigen,
							origen,
							idtiro,
							destino
						ORDER BY
						turno,
							economico,
							fechallegada,
							cubicacion,
							material,
							origen,
							destino,
							distancia
						)
						UNION ALL
						(
						SELECT
							2 as turno,
							economico,
							DATE_FORMAT(fechallegada, '%e/%m/%Y') as fechalleg,
							cubicacion,
							COUNT(idviaje) as viajes,
							material,
							idorigen,
							origen,
							idtiro,
							destino,
							distancia  as distancia,
							SUM(volumenprimerkm) as volumenprimerkm,
							SUM(volumenkmsubsecuentes) as volumenkmsubsecuentes,
							SUM(volumenkmadicionales) as volumenkmadicionales,
							SUM(volumen) as volumen,
							SUM(importeprimerkm) as importeprimerkm,
							SUM(importekmsubsecuentes) as importekmsubsecuentes,
							SUM(importekmadicionales) as importekmadicionales,
							SUM(importe) as importe
						FROM
							vw_viajes
						WHERE
							(fechallegada BETWEEN '".$fi_fi."' AND '".$ff_fi."'
							AND horallegada BETWEEN '18:00:01' AND '23:59:59')
							OR
							(fechallegada BETWEEN DATE_ADD('".$fi_fi."', INTERVAL 1 DAY) AND DATE_ADD('".$ff_fi."', INTERVAL 1 DAY)
							AND horallegada BETWEEN '00:00:00' AND '07:00:00')
						GROUP BY
							turno,
							economico,
							fechallegada,
							cubicacion,
							material,
							idorigen,
							origen,
							idtiro,
							destino
						ORDER BY
						  turno,
							economico,
							fechallegada,
							cubicacion,
							material,
							origen,
							destino,
							distancia
						)
						ORDER BY
						  turno,
							economico,
							fechalleg,
							cubicacion,
							material,
							origen,
							destino,
							distancia
	";
	//echo $SQL;
	//$result = mysql_query($SQL, $link);
	$result = $SCA->consultar($SQL);
	/*$contador_viajes = 0;
	
	while($row = mysql_fetch_array($result))
	{
		$contador_viajes = $contador_viajes +1;
		$viajes[1][$contador_viajes] = $row["turno"];
		$viajes[2][$contador_viajes] = $row["economico"];
		$viajes[3][$contador_viajes] = $row["fechalleg"];
		$viajes[4][$contador_viajes] = $row["cubicacion"];
		$viajes[5][$contador_viajes] = $row["viajes"];
		$viajes[6][$contador_viajes] = $row["material"];
		$viajes[7][$contador_viajes] = $row["idorigen"];
		$viajes[8][$contador_viajes] = $row["origen"];
		$viajes[9][$contador_viajes] = $row["idtiro"];
		$viajes[10][$contador_viajes] = $row["destino"];
		$viajes[11][$contador_viajes] = $row["distancia"];
		$viajes[12][$contador_viajes] = $row["volumenprimerkm"];
		$viajes[13][$contador_viajes] = $row["volumenkmsubsecuentes"];
		$viajes[14][$contador_viajes] = $row["volumenkmadicionales"];
		$viajes[15][$contador_viajes] = $row["volumen"];
		$viajes[16][$contador_viajes] = $row["importeprimerkm"];
		$viajes[17][$contador_viajes] = $row["importekmsubsecuentes"];
		$viajes[18][$contador_viajes] = $row["importekmadicionales"];
		$viajes[19][$contador_viajes] = $row["importe"];
		
		//Totales
		$total_viajes 			= $total_viajes 			+ $row["viajes"];
		
		$total_vol_primerkm = $total_vol_primerkm + $row["volumenprimerkm"];
		$total_vol_kmsub 	= $total_vol_kmsub 		+ $row["volumenkmsubsecuentes"];
		$total_vol_kmadic 	= $total_vol_kmadic 	+ $row["volumenkmadicionales"];
		$total_volumen			= $total_volumen			+ $row["volumen"];
		
		$total_imp_primerkm = $total_imp_primerkm + $row["importeprimerkm"];
		$total_imp_kmsub 		= $total_imp_kmsub 		+ $row["importekmsubsecuentes"];
		$total_imp_kmadic 	= $total_imp_kmadic 	+ $row["importekmadicionales"];
		$total_importe			= $total_importe			+ $row["importe"];
		
	}*/

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
  <!--
    .Estilo1 { color: #FF0000; }
    .Estilo2 { font-size: 1px; color: #FFFFFF; }
    .Estilo4 { font-size: 1px; color: #cccccc; }
body,td,th {
	font-family: Lucida Sans, Calibri, Trebuchet MS;
	font-size: 10px;
	color: #000;
    padding:1px 3px;
}
  -->
</style>
</head>

<body>
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td colspan="18"><font style="font-family:'Lucida Sans', Calibri, 'Trebuchet MS'; font-weight:bold; font-size:14px;">Acarreos Ejecutados por Cami&oacute;n y Turno del <?php echo $fi; ?> al <?php echo $ff; ?></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td colspan="18" align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:12px;"><?php echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
   
    <td colspan="3" align="center" bgcolor="#000000" style="color:#FFF"><strong>Volumen</strong></td>
    <td colspan="3" align="center" bgcolor="#000000" style="color:#FFF"><strong>Importe</strong></td>
    <td>&nbsp;</td>
    <td colspan="2" align="center" bgcolor="#000000" style="color:#FFF"><strong>Total</strong></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Turno</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Económico</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Fecha</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Cuicación</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Viajes</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Material</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Origen</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Destino</strong></td>
    <td align="center" bgcolor="#000000" style="color:#FFF"><strong>Distancia</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>1er. KM</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>KM Subs.</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>KM Adc.</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>1er. KM</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>KM Subs.</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>KM Adc.</strong></td>
    <td align="center">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>Volumen</strong></td>
    <td align="center" bgcolor="#333333" style="color:#FFF"><strong>Importe</strong></td>
  </tr>
  <?php
  $SQLs = "select distinct(turno) from viajes_reporte";
  $rturno = $SCA->consultar($SQLs);
 
  while($vturno=$SCA->fetch($rturno))
	{
		$SQLsC = "select distinct(economico) from viajes_reporte where turno = ".$vturno["turno"];
		$rcamion = $SCA->consultar($SQLsC);
		$turno = array();
		while($vcamion=$SCA->fetch($rcamion))
		{
			$SQLsF = "select distinct(fechalleg) from viajes_reporte where turno = ".$vturno["turno"]." and economico = '".$vcamion["economico"]."'";
			$rfecha = $SCA->consultar($SQLsF);
			
			$camion = array();
			while($vfecha=$SCA->fetch($rfecha))
			{
				$SQLs = "select * from viajes_reporte where turno =".$vturno["turno"]." and economico = '".$vcamion["economico"]."' and fechalleg = '".$vfecha["fechalleg"]."'";
				$r=$SCA->consultar($SQLs);
				$fecha=array();
				while($v=$SCA->fetch($r))
				{
	?>
    <td><?php echo $v["turno"]; ?></td>
    <td><?php echo $v["economico"]; ?></td>
    <td><?php echo $v["fechalleg"]; ?></td>
    <td align="right"><?php echo $v["cubicacion"]; ?></td>
    <td align="right"><?php echo $v["viajes"]; ?></td>
    <td><?php echo $v["material"]; ?></td>
    <td><?php echo $v["origen"]; ?></td>
    <td><?php echo $v["destino"]; ?></td>
    <td align="right"><?php echo $v["distancia"]; ?></td>
    <td align="right"><?php echo $v["volumenprimerkm"]; ?></td>
    <td align="right"><?php echo $v["volumenkmsubsecuentes"]; ?></td>
    <td align="right"><?php echo $v["volumenkmadicionales"]; ?></td>
    <td align="right"><?php echo number_format($v["importeprimerkm"],2,".",","); ?></td>
    <td align="right"><?php echo number_format($v["importekmsubsecuentes"],2,".",","); ?></td>
    <td align="right"><?php echo number_format($v["importekmadicionales"],2,".",","); ?></td>
    <td>&nbsp;</td>
     <td align="right"><?php echo $v["volumen"]; ?></td>
      <td align="right"><?php echo number_format($v["importe"],2,".",","); ?></td>
  </tr>
    <?php
	$totales["viajes"]+=$v["viajes"];
	$totales["vpk"]+=$v["volumenprimerkm"];
	$totales["vks"]+=$v["volumenkmsubsecuentes"];
	$totales["vka"]+=$v["volumenkmadicionales"];
	$totales["ipk"]+=$v["importeprimerkm"];
	$totales["iks"]+=$v["importekmsubsecuentes"];
	$totales["ika"]+=$v["importekmadicionales"];
	$totales["tv"]+=$v["volumen"];
	$totales["ti"]+=$v["importe"];
	
	
	$turno["viajes"]+=$v["viajes"];
	$turno["vpk"]+=$v["volumenprimerkm"];
	$turno["vks"]+=$v["volumenkmsubsecuentes"];
	$turno["vka"]+=$v["volumenkmadicionales"];
	$turno["ipk"]+=$v["importeprimerkm"];
	$turno["iks"]+=$v["importekmsubsecuentes"];
	$turno["ika"]+=$v["importekmadicionales"];
	$turno["tv"]+=$v["volumen"];
	$turno["ti"]+=$v["importe"];
	
	$camion["viajes"]+=$v["viajes"];
	$camion["vpk"]+=$v["volumenprimerkm"];
	$camion["vks"]+=$v["volumenkmsubsecuentes"];
	$camion["vka"]+=$v["volumenkmadicionales"];
	$camion["ipk"]+=$v["importeprimerkm"];
	$camion["iks"]+=$v["importekmsubsecuentes"];
	$camion["ika"]+=$v["importekmadicionales"];
	$camion["tv"]+=$v["volumen"];
	$camion["ti"]+=$v["importe"];
	
	$fecha["viajes"]+=$v["viajes"];
	$fecha["vpk"]+=$v["volumenprimerkm"];
	$fecha["vks"]+=$v["volumenkmsubsecuentes"];
	$fecha["vka"]+=$v["volumenkmadicionales"];
	$fecha["ipk"]+=$v["importeprimerkm"];
	$fecha["iks"]+=$v["importekmsubsecuentes"];
	$fecha["ika"]+=$v["importekmadicionales"];
	$fecha["tv"]+=$v["volumen"];
	$fecha["ti"]+=$v["importe"];
	
	  }?>
       <tr>
    <td align="center" ></td>
    <td align="center" >&nbsp;</td>
    <td align="center" bgcolor="#999999" style="color:#000">&nbsp;</td>
    <td align="center" bgcolor="#999999" style="color:#000">&nbsp;</td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo $fecha["viajes"]; ?>&nbsp;</td>
    <td align="center" bgcolor="#999999" style="color:#000">&nbsp;</td>
    <td align="center" bgcolor="#999999" style="color:#000">&nbsp;</td>
    <td align="center" bgcolor="#999999" style="color:#000">&nbsp;</td>
    <td align="center" bgcolor="#999999" style="color:#000">&nbsp;</td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo $fecha["vpk"]; ?></td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo $fecha["vks"]; ?></td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo $fecha["vka"]; ?></td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo number_format($fecha["ipk"],2,".",","); ?></td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo number_format($fecha["iks"],2,".",","); ?></td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo number_format($fecha["ika"],2,".",","); ?></td>
    <td align="center">&nbsp;</td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo number_format($fecha["tv"],2,".",","); ?></td>
    <td align="right" bgcolor="#999999" style="color:#000"><?php echo number_format($fecha["ti"],2,".",","); ?></td>
  </tr>
      <?php 
		}
	  ?>
	   <tr>
    <td align="center" >&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo $camion["viajes"]; ?>&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#666666" style="color:#FFF">&nbsp;</td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo $camion["vpk"]; ?></td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo $camion["vks"]; ?></td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo $camion["vka"]; ?></td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo number_format($camion["ipk"],2,".",","); ?></td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo number_format($camion["iks"],2,".",","); ?></td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo number_format($camion["ika"],2,".",","); ?></td>
    <td align="center">&nbsp;</td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo number_format($camion["tv"],2,".",","); ?></td>
    <td align="right" bgcolor="#666666" style="color:#FFF"><?php echo number_format($camion["ti"],2,".",","); ?></td>
  </tr>
		<?php }
	  ?>
      <tr>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo $turno["viajes"]; ?>&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#333333" style="color:#FFF">&nbsp;</td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo $turno["vpk"]; ?></td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo $turno["vks"]; ?></td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo $turno["vka"]; ?></td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo number_format($turno["ipk"],2,".",","); ?></td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo number_format($turno["iks"],2,".",","); ?></td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo number_format($turno["ika"],2,".",","); ?></td>
    <td align="center">&nbsp;</td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo number_format($turno["tv"],2,".",","); ?></td>
    <td align="right" bgcolor="#333333" style="color:#FFF"><?php echo number_format($turno["ti"],2,".",","); ?></td>
  </tr>
      <?php
	}
	?>
 <tr>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo $totales["viajes"]; ?>&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="center" bgcolor="#000000" style="color:#FFF">&nbsp;</td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo $totales["vpk"]; ?></td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo $totales["vks"]; ?></td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo $totales["vka"]; ?></td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo number_format($totales["ipk"],2,".",","); ?></td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo number_format($totales["iks"],2,".",","); ?></td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo number_format($totales["ika"],2,".",","); ?></td>
    <td align="center">&nbsp;</td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo number_format($totales["tv"],2,".",","); ?></td>
    <td align="right" bgcolor="#000000" style="color:#FFF"><?php echo number_format($totales["ti"],2,".",","); ?></td>
  </tr>
</table>
</body>
</html>