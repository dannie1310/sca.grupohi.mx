<?php
session_start();
$_SESSION["IdUsuarioAc"];
require_once("../../../inc/php/conexiones/SCA.php");
include("../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();

$fecha = formato_fecha_ingles($_REQUEST['fecha']);

$sql = "INSERT INTO topografias(IdBloque,Fecha,Parcial,Cota,Registra,IdMaterial) VALUES ('".$_REQUEST['bloque']."','".$fecha."','".str_replace(",","",$_REQUEST['parcial'])."','".str_replace(",","",$_REQUEST['cota'])."','".$_SESSION["IdUsuarioAc"]."','".$_REQUEST['materiales']."')";
$rsql = $SCA->consultar($sql);
$insertado = $SCA->affected();
if($insertado>0){
?>
{"kind":"green","msg":"La topografia fue guardada correctamente"}
<?php
}else{
	?>
    {"kind":"red","msg":"La topografia no pudo ser guardada"}
    <?php
	}
	?>