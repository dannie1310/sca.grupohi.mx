<?php
session_start();
require_once("../../../../inc/php/conexiones/SCA.php");
include("../../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();

$fecha = formato_fecha_ingles($_REQUEST['fecha']);

$sql = "UPDATE topografias SET 
								IdBloque='".$_REQUEST['bloques']."',
								IdMaterial='".$_REQUEST['materiales']."',
								Fecha='".$fecha."',
								Parcial='".str_replace(",","",$_REQUEST['parcial'])."',
								Cota='".str_replace(",","",$_REQUEST['cota'])."'
								WHERE IdTopografia='".$_REQUEST['IdTopografia']."'
								";
$rsql = $SCA->consultar($sql);
$af = $SCA->affected();
if($af>0){
	?>
    {"kind":"green","msg":"Modificacion exitosa"}
    <?php
	}else{
		?>
        {"kind":"red","msg":"Hubo un error en la modificacion"}
        <?php
		}
?>