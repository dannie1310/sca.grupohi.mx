<?php

$numero=$_REQUEST['n'];
$base="dev_sca_pruebas";
$tabla="viajesnetos";
$conexion = mysql_connect("localhost", "sca", "w6FCR56sLT") or die ("ERROR AL CONECTAR"); 

mysql_select_db ($base, $conexion);
    $sacar = "SELECT * FROM ".$tabla." WHERE (IdViajeNeto=$numero)" ;
    $resultado = mysql_query($sacar,$conexion);
while ($registro = mysql_fetch_array($resultado)){
             //$tipo_foto=$registro['formato'];
             header("Content-type: jpeg");
			 $file = base64_decode($registro['Imagen01']);
             echo $file;
}
mysql_close();
?>