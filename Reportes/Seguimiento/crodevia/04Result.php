<?php
  //include("../../../Clases/Conexiones/Conexion.php");

session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}
	include("../../../inc/funciones/formato_fecha_ingles.php");
	include("../../../inc/php/conexiones/SCA.php");
	
$ruta = $_POST['ruta'];
if($ruta==0){
	?>
    	<br /><br /><br />
			<table align="center">
				<tr>
					<td align="center" class="avisos">
					Seleccione una ruta
					</td>
				</tr>
			</table>
    <?php
	}else{
		$fecha = formato_fecha_ingles($_POST['fecha']);

//echo $ruta;
//echo $fecha;
  	//$fi_fi=formato_fecha_ingles($_POST["fi"]);
	//$ff_fi=formato_fecha_ingles($_POST["ff"]);
	
	//echo $fi_fi;
	//echo $ff_fi;
	//$crono_base = $_POST["cronb"];
	//$ruta = $_POST["combo"];
	
	//echo $ruta;
	$link=SCA::getConexion();
	$qruta = "SELECT IdRuta,IdTiro,IdOrigen FROM rutas WHERE IdRuta = $ruta";
	$rqruta=$link->consultar($qruta);
	while($r = mysql_fetch_assoc($rqruta)){
		$IdRuta = $r['IdRuta'];
		$IdTiro = $r['IdTiro'];
		$IdOrigen = $r['IdOrigen'];
		}
		/*echo $IdRuta;
		echo $IdOrigen;
		echo $IdTiro;*/
	//$SQL = "select * from vw_cronentvia where fecha BETWEEN '".$fi_fi."' AND '".$ff_fi."'  order by fecha, destino,camion,llegada;";
	
	$SQL = "SELECT v.IdViaje,v.fecha,v.destino,v.origen,v.material,v.camion,v.llegada,v.secllegada,v.tipoviaje,t.IdTiro,t.Descripcion,o.IdOrigen,o.Descripcion
FROM vw_cronentvia AS v
LEFT JOIN tiros AS t ON t.Descripcion = v.destino
LEFT JOIN origenes AS o ON o.Descripcion = v.origen
WHERE o.IdOrigen = $IdOrigen AND t.IdTiro = $IdTiro AND v.fecha = '".$fecha."' order by v.fecha, v.destino,v.camion,v.llegada ";
//echo $SQL;
	$result=$link->consultar($SQL);
	
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
	//echo $contador_viajes;
	//mysql_close($link);
		if($contador_viajes==0){
			?>
            <br /><br /><br />
			<table align="center">
				<tr>
					<td align="center" class="avisos">
					No existen resultados
					</td>
				</tr>
			</table>
            <?php
			}else{
				?>
                <table  border="0" align="center">
	  <!--<tr>
		<td colspan="9" class="tituloreporte"><span class="titulo">Consulta de Lapsos entre Viajes por Destino y Camión</span></td>
	  </tr>
	  <tr>
		<td colspan="9" class="nombresistema">(Sistema de Control de Recursos)</td>
	  </tr>-->
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
		  			$qcrono = "SELECT TiempoMinimo FROM cronometrias WHERE IdRuta = $IdRuta";
					echo $crono;
					$rqcrono=$link->consultar($qcrono);
					while($cr = mysql_fetch_assoc($rqcrono)){
						$cronometria = $cr['TiempoMinimo'];
						}
				  IF($viajes[12][$a] < $cronometria)
					  echo '<img src="../../../Imagenes/busy16.png" border=0>';
					ELSE
					  echo '<img src="../../../Imagenes/online16.png" border=0>';
				?>
		</td>
		<td align="center"><?php
							echo $cronometria;
					
						  	?></td>
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
                <?php
				}
		}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCA.- Consulta de Tiempos entre Viajes</title>
<link href="../../../Clases/Styles/RepSeg.css" rel="stylesheet" type="text/css" />
</head>
<style>
	.avisos{
		background-color:#E2E2E2;
		color:#D40000;
		font-size:14px;
		font-weight:bold;
		padding:10px;}
</style>
<body>

</body>
</html>