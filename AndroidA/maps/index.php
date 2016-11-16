<?php 
session_start();
include("../../inc/php/conexiones/SCA_config.php");
if(!empty($_SESSION['IdUsuario'])) {

}else{
     //echo  "<b><Font color=red>Ha caducado la sesión, favor de regresarse a la intranet gracias.</Font></b>";
     header('Location: ../../Login.php');
   //exit();
}
?>
<!DOCTYPE html>
<html  lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>maps</title>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_Nz3NicjL3h2q5ytAwoZ4_Wvju6i7H_o&callback=initMap"  type="text/javascript"></script>
	<script type="text/javascript" src="js/markerwithlabel.js"></script>

	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	
	<!--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>-->
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  	<script src="js/jquery.ui.datepicker-es.js"></script>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div id="mostrarMapa" > </div>
	<div id="opciones" >
		<h4>Opciones</h4>		
		<table>
			<tr class="title">
				<th colspan="2" class="center">
					Eventos
				</th>
			</tr>
			<tr >
				<td colspan="2" class="listevento"> 					
				
				</td>
			</tr>
			<tr class="title">
				<th>Fecha inicial (yy-mm-dd)</th>
				<th>Fecha final (yy-mm-dd)</th>
			</tr>
			<tr >
				<td class="center" >
					<input type="text" value="" id="fechainicial">
				</td>
				<td class="center">
					<input type="text" value="" id="fechafinal">
				</td>
			</tr>
			<tr>
				<td colspan="2" class="buttonsubmit">
					<input type="button" value="Refrescar">
				</td>
			</tr>
			<tr>
				<td colspan="2" class="periodo"></td>
			</tr>

			<tr class="title">
				<th colspan="2" class="center">
					Equipos (Tel&eacute;fonos)
				</th>
			</tr>
			<tr>
				<td colspan="2" class="listIMEI">
				</td>
			</tr>
			
		</table>
	</div>
    
 </body>
<script src="js/index.js"></script>
</html>