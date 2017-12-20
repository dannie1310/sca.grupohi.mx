<?php
session_start();

if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

if(isset($_REQUEST["value"]) && ($_REQUEST["value"]==1)){
	header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition:  filename=Tiempo de Recorrido Por Viaje y Camion'.date("d-m-Y").'_'.date("H.i.s",time()).'.xls');
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCA.- Consulta de Tiempos entre Viajes</title>
</head>

<body>
<?php
  //include("../../../Clases/Conexiones/Conexion.php");
	include("../../../inc/funciones/formato_fecha_ingles.php");
	include("../../../inc/php/conexiones/SCA.php");
	
$ruta = $_REQUEST['ruta'];
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
		$fecha = formato_fecha_ingles($_REQUEST['fecha']);

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
	
	/*$SQL = "SELECT v.IdViaje,v.FechaLlegada as fecha,v.IdTiro,v.IOrigen,v.IdMaterial,v.IdCamion,v.llegada,v.tipoviaje,t.IdTiro,t.Descripcion,o.IdOrigen,o.Descripcion
FROM vw_cronentvia AS v
LEFT JOIN tiros AS t ON t.Descripcion = v.destino
LEFT JOIN origenes AS o ON o.Descripcion = v.origen
WHERE o.IdOrigen = $IdOrigen AND t.IdTiro = $IdTiro AND v.fecha = '".$fecha."' order by v.fecha, v.destino,v.camion,v.llegada ";*/
$SQL = "select 
v.IdViaje,
v.FechaLlegada as fecha,
v.HoraLLegada as horallegada,
v.HoraSalida as horasalida,
t.Descripcion as destino,
o.Descripcion as origen,
m.Descripcion as material,
c.Economico as camion,
ev.estatus as viaje,
IFNULL(TIMESTAMPDIFF(MINUTE,concat(FechaSalida,' ',HoraSalida),concat(FechaLlegada,' ',HoraLlegada)),0) as recorrido 
from viajes v left join camiones c using (IdCamion)
left join materiales m using (IdMaterial)
left join origenes o using (IdOrigen)
left join tiros t using (IdTiro)
left join cat_estatus_viajes as ev on ev.IdEstatus = v.Estatus
where v.fechallegada = '".$fecha."' 
and o.IdOrigen = $IdOrigen AND t.IdTiro = $IdTiro
order by c.Economico, v.HoraLlegada";
//echo $SQL;
	$result=$link->consultar($SQL);
	
	$contador_viajes=0;
	
	while($row = mysql_fetch_array($result))
	{
	  $contador_viajes = $contador_viajes + 1;
		$viajes[1] 	[$contador_viajes] 		= $row["idviaje"];
		$viajes[2] 	[$contador_viajes] 		= $row["fecha"];	
		$viajes[3] 	[$contador_viajes] 		= $row["destino"];	
		$viajes[4] 	[$contador_viajes] 		= $row["origen"];	
		$viajes[5] 	[$contador_viajes] 		= $row["material"];	
		$viajes[6] 	[$contador_viajes] 		= $row["camion"];	
		$viajes[7] 	[$contador_viajes] 		= $row["horallegada"];
		$viajes[8] 	[$contador_viajes] 	    = $row["horasalida"];
		$viajes[9]	[$contador_viajes]		= $row["recorrido"];
		$viajes[10] 	[$contador_viajes] 		= $row["viaje"];
		/*$viajes[10] [$contador_viajes+1] 	= $row[secllegada];*/
		
		
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
       <table  border="0" align="center" style="border-collapse:collapse; color:#000;">
	  <!--<tr>
		<td colspan="9" class="tituloreporte"><span class="titulo">Consulta de Lapsos entre Viajes por Destino y Camión</span></td>
	  </tr>
	  <tr>
		<td colspan="9" class="nombresistema">(Sistema de Control de Recursos)</td>
	  </tr>-->
      <tr>
        	<td colspan="2" style="height:80px;"><img src="http://gln.com.mx:82/test/Imgs/sca_login.jpg" width="106" height="67"></td>
            <td colspan="3">&nbsp;</td>
            <td valign="top" colspan="4"><strong>TIEMPO DE RECORRIDO POR VIAJE Y CAMION</strong></td>
      </tr>
      <tr>
      	<td style="background-color:#7ac142; color:#FFF;">Proyecto</td>
        <td style="background-color:#ddd;" colspan="3"><?php echo $link->regresaDatos2('proyectos','Descripcion','Estatus', 1)?></td>
        <td colspan="5">&nbsp;</td>
        <td style="background-color:#7ac142; color:#FFF;">Fecha de Consulta</td>
        <td style="background-color:#ddd;"><?php echo date("d-m-Y");?></td>
      </tr>
      <tr>
      	<td style="background-color:#7ac142; color:#FFF;">Periodo</td>
        <td style="background-color:#ddd;" colspan="3"><?php echo $_REQUEST['fecha']; ?></td>
      </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td style="background-color:#333; color:#FFF;" colspan="2" align="center">Destino</td>
		<td style="background-color:#333; color:#FFF;" colspan="2" align="center">Origen</td>
		<td style="background-color:#333; color:#FFF;" colspan="2" align="center">Material</td>
		<td style="background-color:#333; color:#FFF;" align="center">Camion</td>
		<td style="background-color:#333; color:#FFF;" align="center">Hora Salida</td>
		<td style="background-color:#333; color:#FFF;" align="center">Hora Llegada</td>
		<td style="background-color:#333; color:#FFF;" align="center">Tiempo de Recorrido (Min)</td>
		<td style="background-color:#333; color:#FFF;" align="center">Viaje</td>
	  </tr>
	  <?php
		  for($a=1;$a<=$contador_viajes;$a++)
			{
		?>
	   
			<?php 
				  IF($a % 2)
					 $clase= 'style="background-color:#ddd";'; 
					ELSE
					 $clase= '';  
					
			  ?> 
	  <tr>
		<td colspan="2" align="center" <?php echo $clase;?>>
				<?php 
					/*Destino*/ 
						IF($viajes[3][$a] != $viajes[3][$a-1])
						  echo $viajes	[3]	[$a];
						ELSE 
						  echo '" "';	
				?>
		</td>
		<td colspan="2" align="center" <?php echo $clase;?>>
		  <?php 
					/*Destino*/ 
						IF($viajes[4][$a] != $viajes[4][$a-1])
						  echo $viajes[4][$a];
						ELSE 
						  echo '" "';	
				?>
		</td>
		<td colspan="2" align="center" <?php echo $clase;?>>
		  <?php 
					/*Destino*/ 
						IF($viajes[5][$a] != $viajes[5][$a-1])
						  echo $viajes[5][$a];
						ELSE 
						  echo '" "';	
				?>
		</td>
		<td align="center" <?php echo $clase;?>>
		  <?php 
					/*Destino*/ 
						IF($viajes[6][$a] != $viajes[6][$a-1])
						  echo $viajes[6][$a];
						ELSE 
						  echo '" "'; 		
				?>
		</td>
		<td align="center" <?php echo $clase;?>>
		 <?php 
					/*Destino*/ 
						IF($viajes[8][$a] != $viajes[8][$a-1])
						  echo $viajes[8][$a];
						ELSE 
						  echo '" "'; 		
				?>
        </td>
		<td align="center" <?php echo $clase;?>>
		 <?php 
					/*Destino*/ 
						IF($viajes[7][$a] != $viajes[7][$a-1])
						  echo $viajes[7][$a];
						ELSE 
						  echo '" "'; 		
				?>
        </td>
        <td align="center" <?php echo $clase;?>>
        	<?php 
					/*Destino*/ 
						IF($viajes[9][$a] != $viajes[9][$a-1])
							  echo $viajes[9][$a];
						ELSE 
						  echo '" "'; 		
				?>
        </td>
        <td <?php echo $clase;?>>
        	<?php 
					/*Destino*/ 
						IF($viajes[10][$a] != $viajes[10][$a-1])
						  echo $viajes[10][$a];
						ELSE 
						  echo '" "'; 		
				?>
        </td>
	  </tr
	  ><?php
		  }
		?>
	</table>
                <?php
				}
		}


?>

</body>
</html>