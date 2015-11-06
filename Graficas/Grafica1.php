<?php
session_start();
/*$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("sca_atlacomulco_xii", $conexion);*/
require("../inc/php/conexiones/SCA.php");
$link=SCA::getConexion();
//$anio = $_POST['anio'];
$anio = 2012;
$sql1 = "SELECT SUM(Volumen) AS Volumen,MONTH(FechaLlegada) AS Mes FROM viajes WHERE YEAR(FechaLlegada)=$anio  GROUP BY MONTH(FechaLlegada)";
				$rsql1=$link->consultar($sql1);
				$Sumatoria1 = 0;
				while($r1 = mysql_fetch_assoc($rsql1)){
					$VolumenTotal1 = $r1['Volumen'];
					
					
					$Sumatoria1 = $Sumatoria1+$VolumenTotal1;
				}
				$fsumatoria1 = number_format($Sumatoria1);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8859-1">
<title>Gráfica Volumen de Materiales Por Mes .- SCA</title>
<link href="../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<!-- 1. Add these JavaScript inclusions in the head of your page -->
<script type="text/javascript" src="../inc/js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="highcharts.js"></script>
<!-- 1a) Optional: add a theme file -->
<!--<script type="text/javascript" src="../js/themes/gray.js"></script>-->
<!-- 1b) Optional: the exporting module
<script type="text/javascript" src="exporting.js"></script> -->
<!-- 2. Add the JavaScript to initialize the chart on document ready -->
<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						defaultSeriesType: 'bar'
					},
					title: {
						text: 'Volumen Total <?php echo $fsumatoria1; ?>(m3)'
					},
					xAxis: {
						categories: [<?php
									 $mes = "SELECT MONTH(FechaLlegada)AS Mes FROM viajes WHERE YEAR(FechaLlegada)=$anio GROUP BY Mes";
											$rmes = $link->consultar($mes);
											$n=mysql_num_rows($rmes);
											//echo $n;
											$i=0;
											while($m = mysql_fetch_array($rmes)){
											$Mes[$i] = $m['Mes'];
											if($i<$n-1){
												?>'<?php
												if($Mes[$i]==1){
												echo 'Enero'; 
												}
												if($Mes[$i]==2){
												echo 'Febrero'; 
												}
												if($Mes[$i]==3){
												echo 'Marzo'; 
												}
												if($Mes[$i]==4){
												echo 'Abril'; 
												}
												if($Mes[$i]==5){
												echo 'Mayo'; 
												}
												if($Mes[$i]==6){
												echo 'Junio'; 
												}
												if($Mes[$i]==7){
												echo 'Julio'; 
												}
												if($Mes[$i]==8){
												echo 'Agosto'; 
												}
												if($Mes[$i]==9){
												echo 'Septiembre'; 
												}
												if($Mes[$i]==10){
												echo 'Octubre'; 
												}
												if($Mes[$i]==11){
												echo 'Noviembre'; 
												}
												if($Mes[$i]==12){
												echo 'diciembre'; 
												}
												?>',
												<?php
												}else{
													?>
													'<?php
													if($Mes[$i]==1){
												echo 'Enero'; 
												}
												if($Mes[$i]==2){
												echo 'Febrero'; 
												}
												if($Mes[$i]==3){
												echo 'Marzo'; 
												}
												if($Mes[$i]==4){
												echo 'Abril'; 
												}
												if($Mes[$i]==5){
												echo 'Mayo'; 
												}
												if($Mes[$i]==6){
												echo 'Junio'; 
												}
												if($Mes[$i]==7){
												echo 'Julio'; 
												}
												if($Mes[$i]==8){
												echo 'Agosto'; 
												}
												if($Mes[$i]==9){
												echo 'Septiembre'; 
												}
												if($Mes[$i]==10){
												echo 'Octubre'; 
												}
												if($Mes[$i]==11){
												echo 'Noviembre'; 
												}
												if($Mes[$i]==12){
												echo 'diciembre'; 
												}
													?>'
													<?php
													}
											$i++;
											}
									 ?>]
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Total de Volumen de  Material por Mes'
						}
					},
					legend: {
						backgroundColor: '#FFFFFF',
						reversed: true
					},
					tooltip: {
						formatter: function() {
							return ''+
								 this.series.name +': '+ this.y +'';
						}
					},
					plotOptions: {
						series: {
							stacking: 'normal'
						}
					},
				        series: [{ 
								 <?php 
												$quno = "SELECT v.IdMaterial,m.Descripcion AS Descripcion,m.IdMaterial FROM viajes AS v
LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial GROUP BY v.IdMaterial";
												$rquno = $link->consultar($quno);
												$m = mysql_num_rows($rquno);
												$j=0;
												while($a = mysql_fetch_array($rquno)){
												$IdMaterial = $a['IdMaterial'];
												$Material = $a['Descripcion'];
												$j++;
														if($j<$m){
															?>
															name : '<?php echo $Material; ?>',
															data:[<?php
																  for($w=$Mes[0];$w<=$Mes[$n-1];$w++){
																	$qdos = "SELECT SUM(Volumen) AS Volumen FROM viajes WHERE IdMaterial = $IdMaterial AND MONTH(FechaLlegada)=$w AND YEAR(FechaLlegada)=$anio ";
																	//echo $qdos;
																	$rqdos = $link->consultar($qdos);
																	$cuenta = mysql_num_rows($rqdos);
																	while($b = mysql_fetch_array($rqdos)){
																		$Volumen = $b['Volumen'];
																		if($Volumen ==''){
																			if($w==12){
																				echo '0';
																				}else{
																					echo '0,';
																					}
																			}else{
																				if($w==12){
																					echo $Volumen;
																					}else{
																						echo $Volumen.',';
																						}
																				
																				}
																		}
																	}
																  ?>]
															},{
															<?php
															}else{
																?>
																name : '<?php echo $Material; ?>',
																data:[<?php
																  for($w=$Mes[0];$w<=$Mes[$n-1];$w++){
																	$qdos = "SELECT SUM(Volumen) AS Volumen FROM viajes WHERE IdMaterial = $IdMaterial AND MONTH(FechaLlegada)=$w AND YEAR(FechaLlegada)=$anio ";
																	//echo $qdos;
																	$rqdos = $link->consultar($qdos);
																	$cuenta = mysql_num_rows($rqdos);
																	while($b = mysql_fetch_array($rqdos)){
																		$Volumen = $b['Volumen'];
																		if($Volumen ==''){
																			if($w==12){
																				echo '0';
																				}else{
																					echo '0,';
																					}
																			}else{
																				if($w==12){
																					echo $Volumen;
																					}else{
																						echo $Volumen.',';
																						}
																				
																				}
																		}
																	}
																  ?>]
																}
																<?php
																}
														}
								 ?>
						]
				});
				
				
			});
				
		</script>
		
	</head>
    <style>
	.header{
		background-color:#4572A7;
		color:#FFFBF0;
		font-family:Verdana, Geneva, sans-serif;
		font-weight:300;
		font-size:12px;
		font-style:italic;
		padding:5px;
		font-weight:bold;
		}
	.content{
		background-color:#eee;
		font-family:Verdana, Geneva, sans-serif;
		font-size:12px;
		color:#666;
		padding:5px;
		}
	.EncabezadoPagina1 
{
  font-size: 17px;
  
  text-align: left;
  color:#3E576F;
}
	</style>
	<body>
		
		<!-- 3. Add the container -->
		<div id="main" align="center">	
		<!-- 3. Add the container -->
        	<table width="1000px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td background="../Imgs/banner.jpg" style="width:1000px; height:60px;"><br />
        <br />
            </tr>
    <tr bgcolor="#000;">
      <td  class="Bienvenida"><div id="bienvenida"><?php echo "BIENVENIDO: ".$_SESSION['Descripcion'].", PROYECTO: ".$_SESSION["DescripcionProyecto"]; ?></div>
        </td>
    </tr>
  </table><br />
		<table>
        	<tr>
            	<td class="EncabezadoPagina1">
                	Gráfica Volumen de Materiales Por Mes del <?php echo $anio; ?>
                </td>
            </tr>
            <tr>
            	<td>&nbsp;
                
                </td>
            </tr>
        </table>
		
		<div id="container" style="width: 700px; height: 700px; display:inline-block;">
        </div>
        <div id="tabla" style="width:300px; height:700px; display:inline-block; margin-left:50px; vertical-align:top;">
        	<table>
                <tr>
                	<td colspan="2" class="header" align="center">&nbsp;
                    Datos del <?php echo $anio; ?>
                    </td>
                </tr>
                <tr>
                	<td class="header" align="center">
                    	MES
                    </td>
                    <td class="header" align="center">
                    	VOLUMEN TOTAL(m3)
                    </td>
                </tr>
                <?php
				$sql = "SELECT SUM(Volumen) AS Volumen,MONTH(FechaLlegada) AS Mes FROM viajes WHERE YEAR(FechaLlegada)=$anio  GROUP BY MONTH(FechaLlegada)";
				$rsql = $link->consultar($sql);
				
				while($r = mysql_fetch_assoc($rsql)){
					$VolumenTotal = $r['Volumen'];
					$Mes = $r['Mes'];
					
					
				?>
                <tr>
                	<td align="left" class="content">
                    	<?php
						switch ($Mes) {
												case 1:
													$Mes = 'Enero';
													break;
												case 2:
													$Mes = 'Febrero';
													break;
												case 3:
													$Mes = 'Marzo';
													break;
												case 4:
													$Mes = 'Abril';
													break;
												case 5:
													$Mes = 'Mayo';
													break;
												case 6:
													$Mes = 'Junio';
													break;
												case 7:
													$Mes = 'Julio';
													break;
												case 8:
													$Mes = 'Agosto';
													break;
												case 9:
													$Mes = 'Septiembre';
													break;
												case 10:
													$Mes = 'Octubre';
													break;
												case 11:
													$Mes = 'Noviembre';
													break;
												case 12:
													$Mes = 'Diciembre';
													break;
											}
						echo $Mes; ?>
                    </td>
                    <td align="right" class="content">
                    	<?php $numero = number_format($VolumenTotal);
						echo $numero; ?>
                    </td>
                </tr>
                <?php
					}
				?>
                 <tr>
                	<td>&nbsp;
                    	
                    </td>
                    <td align="right" class="header">
                    	<?php
								echo $fsumatoria1; ?>
                    </td>
                </tr>
            </table>
            <table align="center">
            <tr>
            	<td>&nbsp;
                	
                </td>
            </tr>
    </table>
        </div>
	</div>		
				
	</body>
</html>
