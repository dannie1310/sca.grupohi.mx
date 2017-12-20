<?php
  header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition:  filename=Produccion por Origen del '.$_REQUEST["fi"].' al '.$_REQUEST["fi"].'_'.date("d-m-Y").'_'.date("H.i.s",time()).'.xls;');
  	include("../../../inc/php/conexiones/SCA.php");
  include("../../../inc/funciones/formato_fecha_ingles.php");

if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

  $fi    = $_POST["fi"];
	$ff    = $_POST["ff"];
  $fi_fi = formato_fecha_ingles($_POST["fi"]);
	$ff_fi = formato_fecha_ingles($_POST["ff"]);
	
	$SCA = SCA::getConexion();
	$SQL = "SELECT
  tipoorigen,
  origen,
  material,
  COUNT(idviaje) as viajes,
  SUM(volumen) as volumen,
  SUM(volcompac) as volumencompactado,
  SUM(importe) as importe
FROM
  vw_viajes
WHERE fechallegada BETWEEN '".$fi_fi."' AND '".$ff_fi."'	
GROUP BY
  tipoorigen,
  origen,
  material
ORDER BY
  tipoorigen,
  origen,
  material
;";

	
	$result = $SCA->consultar($SQL);
	$contador_viajes = 0;
	
	while($row =$SCA->fetch($result))
	{
		$contador_viajes = $contador_viajes +1;
		$viajes[1][$contador_viajes] = $row["tipoorigen"];
		$viajes[2][$contador_viajes] = $row["origen"];
		$viajes[3][$contador_viajes] = $row["material"];
		$viajes[4][$contador_viajes] = $row["viajes"];
		$viajes[5][$contador_viajes] = $row["volumen"];
		$viajes[6][$contador_viajes] = $row["volumencompactado"];
		$viajes[7][$contador_viajes] = $row["importe"];
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCA.- Reporte de Producción por Origen</title>
<style type="text/css">
  <!--
    .Estilo1 { color: #FF0000; }
    .Estilo2 { font-size: 1px; color: #FFFFFF; }
    .Estilo4 { font-size: 1px; color: #cccccc; }
body,td,th {
	font-family: Lucida Sans, Calibri, Trebuchet MS;
	font-size: 10px;
	color: #000;
}
  -->
</style>
</head>

<body>
<table width="0" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="7"  align="center"><font style="font-family:'Lucida Sans', Calibri, 'Trebuchet MS'; font-weight:bold; font-size:14px;">Reporte de Producción por Origen</font></td>
  </tr>
  <tr>
    <td colspan="7"  align="center"><font style="font-family:'Lucida Sans', Calibri, 'Trebuchet MS'; font-weight:bold; font-size:14px;">(del <?php echo $fi; ?> al <?php echo $ff; ?>)</font></td>
  </tr>
  <tr>
    <td colspan="7"  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"  align="center">Sistema de Control de Acarreos</td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td colspan="7"align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:12px;"><?php echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></td>
  </tr>
  <tr>
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
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="center" bgcolor="#999999"><strong>Volumen</strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="150" align="center" bgcolor="#999999"><strong>Tipo Origen</strong></td>
    <td width="200" align="center" bgcolor="#999999"><strong>Origen</strong></td>
    <td width="150" align="center" bgcolor="#999999"><strong>Material</strong></td>
    <td width="80" align="center" bgcolor="#999999"><strong>Viajes</strong></td>
    <td width="80" align="center" bgcolor="#CCCCCC"><strong>Suelto</strong></td>
    <td width="80" align="center" bgcolor="#CCCCCC"><strong>Compactado</strong></td>
    <td width="80" align="center" bgcolor="#999999"><strong>Importe</strong></td>
  </tr>
  <?php
	  for($i=1; $i <= count($viajes[1]); $i++)
		{
	?>
  <tr>
    <td align="left"><?php echo $viajes[1][$i]; ?>
    <td align="left"><?php echo $viajes[2][$i]; ?></td>
    <td align="left"><?php echo $viajes[3][$i]; ?></td>
    <td align="right"><?php echo number_format($viajes[4][$i], 0, '.', ','); ?></td>
    <td align="right"><?php echo number_format($viajes[5][$i], 2, '.', ','); ?></td>
    <td align="right"><?php echo number_format($viajes[6][$i], 2, '.', ','); ?></td>
    <td align="right"><?php echo number_format($viajes[7][$i], 2, '.', ','); ?></td>
  </tr>
  <?php
	  $total_viajes = $total_viajes + $viajes[4][$i];
		$total_volumen_suelto = $total_volumen_suelto + $viajes[5][$i];
		$total_volumen_compactado = $total_volumen_compactado + $viajes[6][$i];
		$total_importe = $total_importe + $viajes[7][$i];
		
		if(($viajes [2][$i] != $viajes [2][$i+1]))
		{
			$subtotal_origen_viajes			= 0;
			$subtotal_origen_vol_suelto	= 0;
			$subtotal_origen_vol_compac	= 0;
			$subtotal_origen_importe		= 0;
			
			for($a=0; $a<=count($viajes[1]); $a++)
			{
				if($viajes[2][$a] == $viajes[2][$i])
				{
					$subtotal_origen_viajes = $subtotal_origen_viajes + $viajes[4][$a];
					$subtotal_origen_vol_suelto = $subtotal_origen_vol_suelto + $viajes[5][$a];
					$subtotal_origen_vol_compac = $subtotal_origen_vol_compac + $viajes[6][$a];
					$subtotal_origen_importe = $subtotal_origen_importe + $viajes[7][$a];
				}
			}													 
	?>
  <tr>
    <td>&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC">&nbsp;</td>
    <td bgcolor="#CCCCCC" align="right"><strong><?php echo number_format($subtotal_origen_viajes, 0, '.', ','); ?></strong></td>
    <td bgcolor="#CCCCCC" align="right"><strong><?php echo number_format($subtotal_origen_vol_suelto, 2, '.', ','); ?></strong></td>
    <td bgcolor="#CCCCCC" align="right"><strong><?php echo number_format($subtotal_origen_vol_compac, 2, '.', ','); ?></strong></td>
    <td bgcolor="#CCCCCC" align="right"><strong><?php echo number_format($subtotal_origen_importe, 2, '.', ','); ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
		}//Cierra el If del subtotal por origen
		
		if(($viajes [1][$i] != $viajes [1][$i+1]))
		{
			
			$subtotal_tipo_origen_viajes			= 0;
			$subtotal_tipo_origen_vol_suelto	= 0;
			$subtotal_tipo_origen_vol_compac	= 0;
			$subtotal_tipo_origen_importe		= 0;
			
			for($a=0; $a<=count($viajes[1]); $a++)
			{
				if($viajes[1][$a] == $viajes[1][$i])
				{
					$subtotal_tipo_origen_viajes 			= $subtotal_tipo_origen_viajes + $viajes[4][$a];
					$subtotal_tipo_origen_vol_suelto 	= $subtotal_tipo_origen_vol_suelto + $viajes[5][$a];
					$subtotal_tipo_origen_vol_compac 	= $subtotal_tipo_origen_vol_compac + $viajes[6][$a];
					$subtotal_tipo_origen_importe 		= $subtotal_tipo_origen_importe + $viajes[7][$a];
				}
			}	
	?>
  <tr>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999">&nbsp;</td>
    <td bgcolor="#999999" align="right"><strong><?php echo number_format($subtotal_tipo_origen_viajes, 0, '.', ','); ?></strong></td>
    <td bgcolor="#999999" align="right"><strong><?php echo number_format($subtotal_tipo_origen_vol_suelto, 2, '.', ','); ?></strong></td>
    <td bgcolor="#999999" align="right"><strong><?php echo number_format($subtotal_tipo_origen_vol_compac, 2, '.', ','); ?></strong></td>
    <td bgcolor="#999999" align="right"><strong><?php echo number_format($subtotal_tipo_origen_importe, 2, '.', ','); ?></strong></td>
  </tr>
  <tr>
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
  </tr>
  <?php
		}//Cierra el if del subtotal por tipo de origen
		}
	?>
  <tr>
    <td bgcolor="#000000">&nbsp;</td>
    <td bgcolor="#000000">&nbsp;</td>
    <td bgcolor="#000000">&nbsp;</td>
    <td bgcolor="#000000" align="right" style="color:#FFF; font-weight:bold"><?php echo number_format($total_viajes, 0, '.', ','); ?></td>
    <td bgcolor="#000000" align="right" style="color:#FFF; font-weight:bold"><?php echo number_format($total_volumen_suelto, 2, '.', ','); ?></td>
    <td bgcolor="#000000" align="right" style="color:#FFF; font-weight:bold"><?php echo number_format($total_volumen_compactado, 2, '.', ','); ?></td>
    <td bgcolor="#000000" align="right" style="color:#FFF; font-weight:bold"><?php echo number_format($total_importe, 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>