<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");
$SCA=SCA::getConexion();

$aprobar = "UPDATE conciliacion SET estado=2 WHERE idconciliacion=".$_REQUEST['id']."";
$result_aprobar=$SCA->consultar($aprobar);
$n = mysql_affected_rows();
if($n==0){
	?>
    <div style="color:#333; font-size:16px;" align="center">
    <span>Ocurri&oacute; un error durante la aprobacion, intente nuevamente</span>
    </div>
    <?php
	}
	else{
		?>
        <div style="color:#333; font-size:16px;" align="center">
        <span>Se aprob&oacute; satisfactoriamente la conciliaci&oacute;n</span><br>
        <input type="button" value="Aceptar" class="boton" onclick='javascript:location.href="index.php"'/>
        </div>
        <?php
		}
?>