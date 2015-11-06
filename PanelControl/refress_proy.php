<?php
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/adminusers.php");

new validar_usuario();
$admin_users=new adminusers();
echo $admin_users->en_listar_proyectos(); ?>


