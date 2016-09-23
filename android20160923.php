<?php
ini_set("display_errors", "on");
include("inc/php/conexiones/SCA_config.php");
include("inc/php/conexiones/SCA.php");
include "Android20160923/clases/Usuario.php"; 

$Usuarios = new Usuario();

if (isset($_REQUEST[metodo])){
	$Usuarios->$_REQUEST['metodo']($_REQUEST['usr'],$_REQUEST['pass']);       
}else
	$Usuarios->getData($_REQUEST[usr],$_REQUEST[pass]);   
   
   
?>
