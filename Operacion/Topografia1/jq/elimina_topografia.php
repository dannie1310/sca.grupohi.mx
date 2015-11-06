<?php
session_start();
require_once("../../../inc/php/conexiones/SCA.php");
include("../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();
$sql = "DELETE FROM topografias WHERE IdTopografia = '".$_REQUEST['IdTopografia']."'";
$rsql = $SCA->consultar($sql);
$af = $SCA->affected();
if($af>0){
?>
{"kind":"green","msg":"La topografia se elimino correctamente"}
<?php
}else{
	?>
    {"kind":"red","msg":"La topografia no pudo eliminarse"}
    <?php
	}
?>