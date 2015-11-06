<?php
session_start();
require_once("../../../inc/php/conexiones/SCA.php");
include("../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();

$fecha = formato_fecha_ingles($_REQUEST['fecha']);

$sql = "SELECT * FROM topografias where IdBloque = '".$_REQUEST['bloque']."' AND Fecha='".$fecha."' AND IdMaterial='".$_REQUEST['materiales']."'";
$rsql = $SCA->consultar($sql);

$n = mysql_num_rows($rsql);

if($n==0){
	?>
    {"kind":"green","msg":"OK"}
    <?php
	}else{
		?>
        {"kind":"red","msg":"KO"}
        <?php
		}

?>