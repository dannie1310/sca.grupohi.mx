<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();

$SQL1 = "SELECT * FROM centroscosto WHERE IdPadre='".$_REQUEST["IdCentroCosto"]."'";
$RSQL1 = $sca->consultar($SQL1);
$NSQL1 = mysql_num_rows($RSQL1);
if($NSQL1>0){
	?>
	{"kind":"red","msg":"Este centro de costo tiene subcuentas"}
    <?php
	}else{
		$SQL2 = "SELECT * FROM costos WHERE IdCentroCosto = '".$_REQUEST["IdCentroCosto"]."'";
		$RSQ2 = $sca->consultar($SQL2);
		$NSQL2 = mysql_num_rows($RSQL2);
		if($NSQL2>0){
			?>
            {"kind":"red","msg":"Este centro de costo tiene un costo asignado"}
            <?php
			}else{
				$SQL = "DELETE FROM centroscosto WHERE IdCentroCosto = '".$_REQUEST["IdCentroCosto"]."'";
				$RSQL = $sca->consultar($SQL);
				$VSQL = $sca->fetch($RSQL);
				?>
				{"kind":"green","msg":"Centro de Costo Eliminado"}
        		<?php
				}
		}






