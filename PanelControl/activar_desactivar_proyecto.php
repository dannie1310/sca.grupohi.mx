<?php
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");

new validar_usuario();
$proyecto=new proyectos();
$proyecto->activar_desactivar_proyecto($_POST[id_proyect], $_POST[status]);
//echo $_POST[id_proyect];
?>