<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");
$SCA=SCA::getConexion();

$eliminar_detalle = "DELETE FROM conciliacion_rutas WHERE idconciliacion=".$_REQUEST['id']."";
$result_eliminar_detalle=$SCA->consultar($eliminar_detalle);

$eliminar_detalle = "DELETE FROM conciliacion_detalle WHERE idconciliacion=".$_REQUEST['id']."";
$result_eliminar_detalle=$SCA->consultar($eliminar_detalle);

$eliminar_conciliacion = "DELETE FROM conciliacion WHERE idconciliacion=".$_REQUEST['id']."";
$result_eliminar_conciliacion=$SCA->consultar($eliminar_conciliacion);
?>
<div style="color:#333; font-size:16px;" align="center">
	<span>Se elimin&oacute; satisfactoriamente la conciliaci&oacute;n</span><br>
	<input type="button" value="Aceptar" class="boton" onclick='javascript:location.href="index.php"'/>
</div>
