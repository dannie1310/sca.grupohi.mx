<?php
  include("../../../Clases/Conexiones/Conexion.php");
	include("../../../inc/funciones/formato_fecha_ingles.php");

session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

  $fi_fi=formato_fecha_ingles($_POST["fi"]);
	$ff_fi=formato_fecha_ingles($_POST["ff"]);
	$crono_base = $_POST["cronb"];
	
	$link = conectar();
	$SQL = "select * from vw_cronentvia where fecha BETWEEN '".$fi_fi."' AND '".$ff_fi."'  order by fecha, destino,camion,llegada;";
	$result = mysql_query($SQL, $link);
	
	$contador_viajes=0;
	
	while($row = mysql_fetch_array($result))
	{
	  $contador_viajes = $contador_viajes + 1;
		$viajes[1] 	[$contador_viajes] 		= $row[idviaje];
		$viajes[2] 	[$contador_viajes] 		= $row[fecha];	
		$viajes[3] 	[$contador_viajes] 		= $row[destino];	
		$viajes[4] 	[$contador_viajes] 		= $row[origen];	
		$viajes[5] 	[$contador_viajes] 		= $row[material];	
		$viajes[6] 	[$contador_viajes] 		= $row[camion];	
		$viajes[7] 	[$contador_viajes] 		= $row[llegada];
		$viajes[8] 	[$contador_viajes+1] 	= $row[llegada];
		$viajes[9] 	[$contador_viajes] 		= $row[secllegada];
		$viajes[10] [$contador_viajes+1] 	= $row[secllegada];
		
		IF(
			 ($viajes[3][$contador_viajes] == $viajes[3][$contador_viajes-1]) &&
			 ($viajes[6][$contador_viajes] == $viajes[6][$contador_viajes-1])
			)
		  $viajes[12] [$contador_viajes] = (($viajes[9][$contador_viajes] - $viajes[10][$contador_viajes])/60);
		ELSE
		  $viajes[12] [$contador_viajes] 		= 0; 
		
		$viajes[13] [$contador_viajes] 		= $row[tipoviaje];	
	}
	
	mysql_close($link);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCA.- Consulta de Tiempos entre Viajes</title>
<link href="../../../Clases/Styles/RepSeg.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="0" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td colspan="9" class="tituloreporte"><span class="titulo">Consulta de Lapsos entre Viajes por Destino y Camión</span></td>
  </tr>
  <tr>
    <td colspan="9" class="nombresistema">(Sistema de Control de Recursos)</td>
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
  </tr>
  <tr>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">Hora</td>
    <td class="EncabezadoTabla">Lapso Viaje</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">Lapso Mínimo</td>
    <td class="EncabezadoTabla">&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">Destino</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Material</td>
    <td class="EncabezadoTabla">Camion</td>
    <td class="EncabezadoTabla">Llegada</td>
    <td class="EncabezadoTabla">Actual - Anterior</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">Entre Viajes</td>
    <td class="EncabezadoTabla">Viaje</td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">(H:M:S)</td>
    <td class="EncabezadoTabla">(Minutos)</td>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">(Minutos)</td>
    <td class="EncabezadoTabla">&nbsp;</td>
  </tr>
  <?php
	  for($a=1;$a<=$contador_viajes;$a++)
		{
	?>
  <tr 
	    <?php 
			  IF($a % 2)
				 echo 'class="celdagris1"'; 
				ELSE
				 echo 'class="celdagris2"';  
				
		  ?> 
  >
    <td align="center">
			<?php 
				/*Destino*/ 
					IF($viajes[3][$a] != $viajes[3][$a-1])
					  echo $viajes	[3]	[$a];
					ELSE 
					  echo '" "';	
			?>
    </td>
    <td align="center">
      <?php 
				/*Destino*/ 
					IF($viajes[4][$a] != $viajes[4][$a-1])
					  echo $viajes[4][$a];
					ELSE 
					  echo '" "';	
			?>
    </td>
    <td align="center">
      <?php 
				/*Destino*/ 
					IF($viajes[5][$a] != $viajes[5][$a-1])
					  echo $viajes[5][$a];
					ELSE 
					  echo '" "';	
			?>
    </td>
    <td align="center">
      <?php 
				/*Destino*/ 
					IF($viajes[6][$a] != $viajes[6][$a-1])
					  echo $viajes[6][$a];
					ELSE 
					  echo '" "'; 		
			?>
    </td>
    <td><?php /*Destino*/ echo $viajes	[7]	[$a]; ?></td>
    <td align="center"><?php echo number_format($viajes	[12]	[$a], 2, '.', ','); ?></td>
    <td align="center">
      <?php
			  IF($viajes[12][$a] < $crono_base)
				  echo '<img src="../../../Imgs/flag_red.png" border=0>';
				ELSE
				  echo '<img src="../../../Imgs/flag_green.png" border=0>';
			?>
    </td>
    <td align="center"><?php echo $crono_base; ?></td>
    <td><?php echo $viajes	[13]	[$a]; ?></td>
  </tr
  ><?php
	  }
	?>
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
  </tr>
</table>
</body>
</html>