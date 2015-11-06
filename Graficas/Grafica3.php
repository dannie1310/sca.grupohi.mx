<?php
$conexion = mysql_connect("localhost", "root", "");
mysql_select_db("sca_atlacomulco_xii", $conexion);
//$anio = $_POST['anio'];
$anio = 2011;
$sql1 = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
				$rsql1 = mysql_query($sql1,$conexion);
				$Sumatoria1 = 0;
				while($r1 = mysql_fetch_assoc($rsql1)){
					$VolumenTotal1 = $r1['VolTotal'];
					$Material1 = $r1['Descripcion'];
					
					$Sumatoria1 = $Sumatoria1+$VolumenTotal1;
				}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8859-1">
		<title>Grafica</title>
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
						text: 'Volumen total <?php echo number_format($Sumatoria1); ?>(m3)'
					},
					subtitle: {
						text: ''
					},
					xAxis: {
						categories: [<?php $material = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
											$rmaterial = mysql_query($material,$conexion);
											$num = mysql_num_rows($rmaterial);
											$i=0;
											while($m = mysql_fetch_array($rmaterial)){
											$VolTotal = $m['VolTotal'];
											$Descripcion = $m['Descripcion'];
											$i++;
											if($i<$num){
											?>
											'<?php echo $Descripcion; ?>',
											
											<?php
											}else{
												?>
												'<?php echo $Descripcion; ?>'
											<?php
												}
										}
									?>],
						title: {
							text: null
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: 'Volumen',
							align: 'high'
						}
					},
					tooltip: {
						formatter: function() {
							return ''+
								 this.series.name +': '+ this.y ;
						}
					},
					plotOptions: {
						bar: {
							dataLabels: {
								enabled: true
							}
						}
					},
					legend: {
						layout: 'vertical',
						align: 'right',
						verticalAlign: 'top',
						x: -100,
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
						name: 'Volumen Total',
						data: [<?php $volumen = "SELECT SUM(v.volumen) AS VolTotal,v.IdMaterial,m.Descripcion
														FROM viajes AS v
														LEFT JOIN materiales AS m ON v.IdMaterial = m.IdMaterial
														WHERE YEAR(fechallegada)=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
									 $rvolumen = mysql_query($volumen);
									 $n2 = mysql_num_rows($rvolumen);
									 $j=0;
							   		 while($v = mysql_fetch_array($rvolumen)){
										 $id = $v['VolTotal'];
										 if($j<$n2){
											 $english_format_number = number_format($id, 2, '.', '');
											 echo $english_format_number.',';
											 }else{
												 $english_format_number = number_format($id, 2, '.', '');
												 echo $english_format_number;
												 }
										 }
										 
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
        <table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../Imgs/16-Etapas.png" width="16" height="16" />&nbsp;SCA.- Graficas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table>
        	<tr>
            	<td class="EncabezadoPagina1">
                	Grafica Volumenes Totales Por Material del <?php echo $anio; ?>
                </td>
            </tr>
        </table>
		<div id="container" style="width: 800px; height: 900px; display:inline-block;"></div>
        <div id="tabla" style="width:300px; height:700px; display:inline-block; margin-left:50px; vertical-align:top;">
        	<table>
                <tr>
                	<td colspan="2" class="header" align="center">&nbsp;
                    Datos del <?php echo $anio; ?>
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
														WHERE YEAR(fechallegada)=$anio
														GROUP BY v.IdMaterial ORDER BY VolTotal DESC";
				$rsql = mysql_query($sql,$conexion);
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
	<tr>
    	<td>
        	<input type="button" value="Regresar" onclick='javascript:location.href="1Inicio.php"' class="boton" />
        </td>
    </tr>
    </table>
        </div>
	</div>		
		
				
	</body>
</html>
