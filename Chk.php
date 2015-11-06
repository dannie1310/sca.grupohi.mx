<?php
session_start();

include("inc/php/conexiones/SCA_config.php");

$Usr=$_POST['usr'];
$Pwd=$_POST['pwd'];
$clave_md5=md5($Pwd);
$sca_config = SCA_config::getConexion();


 $SQL="SELECT * FROM igh.users where Usuario='$Usr' and Clave='$clave_md5' ;";

$result = $sca_config->consultar($SQL);
while ($Row = $sca_config->fetch($result)){
	$_SESSION['IdUsuario']=$Row["IdUsuario"];
	$_SESSION['Usuario']=$Row["Usuario"];
	$_SESSION['Descripcion']=$Row["Descripcion"];
	$_SESSION['Departamento']=$Row["Departamento"];
	$_SESSION['IdDepartamento']=$Row["IdDepartamento"];
	$_SESSION['Ubicacion']=$Row["Ubicacion"];
	$_SESSION['IdCentroCosto']=$Row["IdCentroCosto"];
	$_SESSION['Extension']=$Row["Extension"];
	$_SESSION['usuariocadeco']=$Row["UsuarioCADECO"];
	$_SESSION['IdUbicacion']=$Row["IdUbicacion"];
	$_SESSION['Genero']=$Row["Genero"];
	$_SESSION["NombreUsuario"] = md5($Row["Usuario"]);
	$_SESSION["ContraseniaUsuario"] = md5($Pwd);
	$_SESSION["UsuarioCADECO"] = $Row["UsuarioCADECO"];
	$_SESSION["SerieActual"]["IdSerie"] = 61;
}


if(!empty($_SESSION['IdUsuario'])) {
	header('Location: Index.php');

}else{
header('Location: Login.php');

}
?>
