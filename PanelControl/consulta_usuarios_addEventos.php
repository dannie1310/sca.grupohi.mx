<?php
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/adminusers.php");



new validar_usuario();
$users=new adminusers();
echo $users->all_users_intranet($_POST[evento],$_POST[tipo],$_POST[proyecto]);
/*proyecto:('#nproyecto :selected').val(),
                                    evento:('#nevento :selected').val(),
                                    tipo:1*/
?>