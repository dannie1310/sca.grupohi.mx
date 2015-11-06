<?php
include("../../../inc/php/conexiones/SCA.php"); 
session_start();
$user_active = $_SESSION['Descripcion'];
//echo $user_active;

$link=SCA::getConexion();
$qdes = "SELECT Usuario FROM usuarios WHERE descripcion = '".$user_active."' ";
//echo $qdes;
$rqdes=$link->consultar($qdes);
while($row=mysql_fetch_array($rqdes)){
		$usr=$row["Usuario"];
		}

//Valido que venga con valores
$user = $_POST['user'];
if($user == $usr){
	if (($_POST['claveant']!='')&&($_POST['password']!='')){
		
		$claveant = md5($_POST['claveant']);
		$newpassword = $_POST['password'];
		
			$quser="SELECT IdUsuario,Usuario,Clave,Descripcion FROM usuarios WHERE Usuario='".$user."' and Clave ='".$claveant."'  and Estatus=1 ";
			$result=$link->consultar($quser);
			//Valido que exista el registro
			if(mysql_num_rows($result) ==1){
				//echo 'Hay registro';
				while($row=mysql_fetch_array($result))
					{
					$IdUsuario=$row["IdUsuario"];
					$Usuario=$row["Usuario"];
					$Clave=$row["Clave"];
					$Descripcion=$row["Descripcion"];
					
					$crypt = md5($newpassword);
					
					
					$updpass = "UPDATE usuarios SET Clave = '".$crypt."' WHERE Usuario = '".$user."' ";
					$rupdpass=$link->consultar($updpass);
					?>
					<table align="center">
						<tr>
							<td>
								<span class="style4">La contraseña ha sido cambiada exitosamente</span>
							</td>
						</tr>
					   
					</table>
					
					<?php
				}
			
			}else{
					?>
					<table align="center">
						<tr>
							<td>
								<span class="style4">El usuario y/o contraseña no coinciden, favor de verificar</span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;
								
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
			
		}
	}else{
		?>
					<table align="center">
						<tr>
							<td>
								<span class="style4">No tienes permisos</span>
                                
							</td>
						</tr>
						<tr>
							<td>&nbsp;
								
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<!--<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>-->
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