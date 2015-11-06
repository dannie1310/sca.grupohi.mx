<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();

$select = "SELECT * FROM conciliacion_detalle 
WHERE idviaje=".$_REQUEST["idviaje"]." and idconciliacion=".$_REQUEST["idconciliacion"]."";
$result=$SCA->consultar($select);
$n= mysql_num_rows($result);
if($n==0){
	$insert = "INSERT INTO conciliacion_detalle (
						idconciliacion,
						idviaje,
						estado
						) VALUES (
						".$_REQUEST["idconciliacion"].",
						".$_REQUEST["idviaje"].",
						1
						)";

$result_insert=$SCA->consultar($insert);
	?>
    {"kind":"green","msg":"OK"}
    <?php
	}else{
		$delete = "DELETE FROM conciliacion_detalle WHERE idconciliacion = ".$_REQUEST["idconciliacion"]." AND
						idviaje=".$_REQUEST["idviaje"]."";
		$result_delete=$SCA->consultar($delete);
		?>
		{"kind":"white","msg":"OK"}
        <?php
		}
?>
