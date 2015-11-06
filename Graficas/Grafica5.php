<?php
session_start();
require("../inc/php/conexiones/SCA.php");
$link=SCA::getConexion();
$anio = 2013;
$sql = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)<=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
						
$rsql=$link->consultar($sql);
$porcentaje = 0;
$suma = 0;
$otros = 0;
$otros2= 0;
while($r = mysql_fetch_assoc($rsql)){
	$ImpTotal = $r['VolTotal'];
	$Descripcion = $r['Descripcion'];
	$suma = $suma + $ImpTotal;
	}
	$porcentaje = ($suma * 5)/(100);
	
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8859-1">
		<title>Gráfica Volumenes Totales por Material .- SCA</title>
		<link href="../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
		
		<!-- 1. Add these JavaScript inclusions in the head of your page -->
		<script type="text/javascript" src="../inc/js/jquery-1.4.4.js"></script>
		<script type="text/javascript" src="highcharts.js"></script>
		
		<!-- 1a) Optional: add a theme file -->
		<!--
			<script type="text/javascript" src="../js/themes/gray.js"></script>
		-->
		
		<!-- 1b) Optional: the exporting module 
		<script type="text/javascript" src="exporting.js"></script>-->
		
		
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
						text: 'Volumen Total <?php echo number_format($suma); ?>(m3)'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: [<?php
									 $qmaterial = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)<=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
									$rqmaterial = $link->consultar($qmaterial);
									while($r3 = mysql_fetch_assoc($rqmaterial)){
										$Descripcion3 = $r3['Descripcion'];
										$ImpTotal3 = $r3['VolTotal'];
										
										if($ImpTotal3>$porcentaje){
											?>
											'<?php echo $Descripcion3 ?>',
											<?php
											}
										
										};
									 ?>'Otros'],
						title: {
							text: null
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Importe',
							align: 'high'
						}
					},
					tooltip: {
						formatter: function() {
                            return  '<strong>'+this.series.name +': </strong>' +Highcharts.numberFormat((this.y), 2);
                        },
					},
					plotOptions: {
						bar: {
							dataLabels: {
								enabled: true,
								formatter: function() {
                            return Highcharts.numberFormat((this.y), 2);
                        },
							}
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: 0,
						y: 100,
						floating: true,
						borderWidth: 1,
						backgroundColor: '#FFFFFF',
						shadow: true
					},
					credits: {
						enabled: false
					},
				        series: [{
						name: 'Volumen Total(m3)',
						data: [<?php
							   $sql4 = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)<=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
								$rsql4 = $link->consultar($sql4);
								$nsql4 = mysql_num_rows($rsql4);
								while($r4 = mysql_fetch_assoc($rsql4)){
								$ImpTotal4 = $r4['VolTotal'];
								$Descripcion4 = $r4['Descripcion'];
									if($ImpTotal4>$porcentaje){
										$fImpTotal4 = number_format($ImpTotal4, 2, '.', '');
											echo $fImpTotal4.',';
										
									}else{
								/*echo 'Es menor al 10%';*/
										$otros2 = $otros2 + $ImpTotal4;
										}
								}
								echo number_format($otros2,2,'.','');
							   ?>]
					}]
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
                	Gráfica Volumenes Acumulados Por Material (Miles)
                </td>
            </tr>
            <tr>
            	<td>&nbsp;
                	
                </td>
            </tr>
        </table>
		<div id="container" style="width: 650px; height: 600px; display:inline-block;"></div>
        <div id="tabla" style="width:300px; height:700px; display:inline-block; margin-left:50px; vertical-align:top;">
        	<table>
                <tr>
                	<td colspan="2" class="header" align="center">&nbsp;
                    Volumenes Acumulados
                    </td>
                </tr>
                <tr>
                	<td class="header" align="center">
                    	MATERIAL
                    </td>
                    <td class="header" align="center">
                    	VOLUMEN TOTAL(m3)
                    </td>
                </tr>
                <?php
				$sql = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)<=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
				$rsql = $link->consultar($sql);
				$Sumatoria = 0;
				while($r = mysql_fetch_assoc($rsql)){
					$VolumenTotal = $r['VolTotal'];
					$Material = $r['Descripcion'];
					
					$Sumatoria = $Sumatoria+$VolumenTotal;
				?>
                <tr>
                	<td align="left" class="content">
                    	<?php echo $Material ?>
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
                    	<?php $fsumatoria = number_format($Sumatoria);
								echo $fsumatoria; ?>
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