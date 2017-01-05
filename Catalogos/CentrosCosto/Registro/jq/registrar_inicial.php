<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();

$SQL2 = "SELECT * FROM centroscosto WHERE IdPadre = 0 ORDER BY Nivel DESC";
$RSQL2 = $sca->consultar($SQL2);
$NSQL2 = mysql_num_rows($RSQL2);
if($NSQL2>0){
	$VSQL2 = $sca->fetch($RSQL2);
	$LastLevel = $VSQL2["Nivel"];
	$rest = substr($LastLevel, -2, 1);
	$LastNumber = (int)$rest+1;
	if(strlen($campo)>2){
			$nvo = '0'.$LastNumber.'.';
		}else{
			$nvo = '00'.$LastNumber.'.';
			}
	}else{
		$nvo = '001.';
		}
		
$descripcion=addslashes($_REQUEST["centrocosto"]);
$idcc = ($_REQUEST["IdCentroCosto"] == "")?"0":$_REQUEST["IdCentroCosto"];
$insert = "INSERT INTO centroscosto (IdProyecto,Nivel,Descripcion,IdPadre,Cuenta) VALUES (1,'".$nvo."','".$descripcion."','".$idcc."','".$_REQUEST["cuenta"]."')";
$rinsert = $sca->consultar($insert);
?>
{"kind":"green","msg":"Registro Exitoso"}