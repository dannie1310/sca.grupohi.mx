<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
$descripcion=addslashes($_REQUEST["centrocosto"]);
$SQL = "UPDATE centroscosto SET Descripcion='".$descripcion."',Cuenta='".$_REQUEST["cuenta"]."' WHERE IdCentroCosto = '".$_REQUEST["IdCentroCosto"]."'";
$RSQL = $sca->consultar($SQL);
$VSQL = $sca->fetch($RSQL);
?>
{"kind":"green","msg":"Modificación Exitosa"}