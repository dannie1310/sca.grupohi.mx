<?php
include("../../../inc/php/conexiones/SCA.php"); 
$link=SCA::getConexion();
if (($_POST['user']!='')&&($_POST['password']!='')){
$user = $_POST['user'];
$password = $_POST['password'];
$descripcion = $_POST['descripcion'];
$proyecto = $_POST['proyecto'];
$crypt = md5($password);
	$con = "SELECT Usuario,Clave FROM usuarios WHERE Usuario = '$user' AND Clave = '$crypt' ";
	$rcon=$link->consultar($con);
	$cuenta = mysql_num_rows($rcon);
	//echo $cuenta;
	if($cuenta == 0){
		?>
		<table align="center">
        	<tr>
            	<td class="style4">
                El Usuario se dio de alta satisfactoriamente
                </td>
            </tr>
            <tr>
							<td align="center">
								<input type="button" value="Registrar Nuevo Usuario" name="nuevo" id="nuevo" class="boton" onclick='javascript:location.href="1Inicio.php"'/>
							</td>
						</tr>
        </table>
        <?php
		$ins = "INSERT INTO usuarios (Usuario,Clave,Descripcion,Estatus) VALUES ('".$user."','".$crypt."','".$descripcion."',1)";
		$rins=$link->consultar($ins);
		$id = mysql_insert_id();
	
		$uxp = "INSERT INTO usuariosxproyecto (IdProyecto,IdUsuario,Estatus) VALUES ('".$proyecto."','".$id."',1)";
		$ruxp=$link->consultar($uxp);
		}else{
			?>
            <table align="center">
                <tr>
                    <td class="style4">
                    El Usuario y/o Contraseña ya existen
                    </td>
                </tr>
                <tr>
							<td align="center">
								<input type="button" value="Intentar de Nuevo" name="intenta" id="intenta" class="boton" onclick='javascript:location.href="1Inicio.php"'/>
							</td>
						</tr>
            </table>
        <?php
			}
	}else{
		echo 'Viene vacio';
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<title>Untitled Document</title>
</head>
<style>
.style4 {
	color: #006699;
	font-size: 14px;
	font-weight: bold;
	font-style: italic;
}
</style>
<body>
</body>
</html>