<?php
session_start();
require_once("../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();

$insert ="INSERT INTO bloques (descripcion) VALUES ('".$_REQUEST['nombre_bloque']."')";
$rinsert = $SCA->consultar($insert);
$insertado = $SCA->affected();
if($insertado>0){
?>
{"kind":"green","msg":"El bloque <?php echo $_REQUEST["nombre_bloque"];?> fue guardado correctamente"}
<?php
}else{
	?>
    {"kind":"red","msg":"El bloque <?php echo $_REQUEST["nombre_bloque"];?> no pudo ser guardado"}
    <?php
	}