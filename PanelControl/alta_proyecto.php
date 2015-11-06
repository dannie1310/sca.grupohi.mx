<?php
//print_r($_POST);
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
//include("class/adminusers.php");

new validar_usuario();
$proyecto=new proyectos();
echo $proyecto->alta_proyecto($_POST[nombre],$_POST[nombre_corto],$_POST[database]);
                            /*($name,$name_corto,$database){*/
?>
