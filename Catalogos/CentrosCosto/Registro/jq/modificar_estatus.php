<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
if($_REQUEST["Estatus"]=='activo'){
	$new_state = 0;
	$leyenda = "no visible";
	}else{
		$new_state = 1;
		$leyenda = "visible";
		}
$SQL = "UPDATE centroscosto SET Estatus='".$new_state."' WHERE IdCentroCosto = '".$_REQUEST["IdCentroCosto"]."'";
$RSQL = $sca->consultar($SQL);
$VSQL = $sca->fetch($RSQL);
?>
{"kind":"green","msg":"El Centro de Costo ahora ser&aacute; <?php echo $leyenda; ?>"}