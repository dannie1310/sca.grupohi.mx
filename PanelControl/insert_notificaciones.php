<?php
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/notificaciones.php");

new validar_usuario();
$notificaciones=new notificaciones();
echo $notificaciones->insertar_user_notificacion($_POST[user], $_POST[evento],$_POST[tipo], $_POST[proyecto]);
?>