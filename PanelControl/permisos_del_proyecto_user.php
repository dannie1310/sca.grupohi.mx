<?php
include("../inc/php/conexiones/SCA_IGH.php");
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/permisos.php");


new validar_usuario();
$admin_permisos=new permisos();
echo  $admin_permisos->alta_permiso_proyec_user($_POST);
?>