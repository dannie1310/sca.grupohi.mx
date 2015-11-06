<?php
//

include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/notificaciones.php");



new validar_usuario();
$notificaciones=new notificaciones();
echo $notificaciones->consulta_notif($_POST[evento],$_POST[tipo],$_POST[proyecto]);
/*proyecto:('#nproyecto :selected').val(),
                                    evento:('#nevento :selected').val(),
                                    tipo:1*/
?>
