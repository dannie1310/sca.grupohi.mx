<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
$SQL = "SELECT * FROM centroscosto WHERE IdCentroCosto = '".$_REQUEST["IdCentroCosto"]."'";
$RSQL = $sca->consultar($SQL);
$VSQL = $sca->fetch($RSQL);

$SQL2 = "SELECT * FROM centroscosto WHERE IdPadre = '".$VSQL["IdCentroCosto"]."' ORDER BY Nivel DESC LIMIT 1";
$RSQL2 = $sca->consultar($SQL2);
$NSQL2 = mysql_num_rows($RSQL2);
if($NSQL2>0){
	$VSQL2 = $sca->fetch($RSQL2);
	$LastLevel = $VSQL2["Nivel"];
	$rest = substr($LastLevel, -2, 1);
	$LastNumber = (int)$rest+1;
	if(strlen($campo)>2){
			$nvo = $VSQL["Nivel"].'0'.$LastNumber.'.';
		}else{
			$nvo = $VSQL["Nivel"].'00'.$LastNumber.'.';
			}
	}else{
		$nvo = $VSQL["Nivel"].'001.';
		}

$SQL3 = "SELECT * FROM centroscosto WHERE IdPadre = '".$VSQL["IdCentroCosto"]."' AND Descripcion = '".$_REQUEST["centrocosto"]."'";
$RSQL3 = $sca->consultar($SQL3);
$NSQL3 = mysql_num_rows($RSQL3);
if($NSQL3>0){
	?>
    {"kind":"red","msg":"Ya existe un centro de costo con ese nombre en este nivel"}
    <?php
	}else{
		$descripcion=addslashes($_REQUEST["centrocosto"]);
		$insert = "INSERT INTO centroscosto (IdProyecto,Nivel,Descripcion,IdPadre,Cuenta) VALUES (1,'".$nvo."','".$descripcion."','".$_REQUEST["IdCentroCosto"]."','".$_REQUEST[	"cuenta"]."')";
		echo $insert;
                $rinsert = $sca->consultar($insert);
		
                ?>
		{"kind":"green","msg":"Registro Exitoso:<?PHP ECHO $insert;?>"}
        <?php
		}
?>
