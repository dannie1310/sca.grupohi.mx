<?php
/**
 * Sistema de Control de Acarreos
 *
 * 2015 (c) Grupo Hermes Infraestructura
 */
include("../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
$IdEstatus = $_REQUEST["IdEstatus"];
$IdOrigen = $_REQUEST["IdOrigen"];
$IdUsuario = $_REQUEST["IdUsuario"];
IF(in_array($IdEstatus, array(1,2))){
    $SQL = "SELECT COUNT(*) as tiene_asignado FROM origen_x_usuario WHERE idusuario_intranet = $IdUsuario AND idorigen = $IdOrigen";
    $RSQL = $sca->consultar($SQL);
    $VSQL = $sca->fetch($RSQL);

    if($VSQL["tiene_asignado"] == 1){
        $SQL = "DELETE FROM origen_x_usuario WHERE idusuario_intranet = $IdUsuario AND idorigen = $IdOrigen";
        $RSQL = $sca->consultar($SQL);
    }ELSE{
        $SQL = "
           INSERT INTO `origen_x_usuario`
        (`idusuario_intranet`,
        `idproyecto`,
        `idorigen`
        )
        VALUES
        ($IdUsuario,
            1,
        $IdOrigen);
";
        $RSQL = $sca->consultar($SQL);
    }
}


?>
{"kind":"green", "msg":""}