<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />SCA.- Asignaci&oacute;n de Materiales por Bot&oacute;n</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];;
	$boton=$_REQUEST[botones];
	$material=$_REQUEST[materiales];
	$up=$_REQUEST[tipoup];
	
	$link=SCA::getConexion();
	$sqla="Lock Tables materialesxboton, botones Write;";
	$link->consultar($sqla);

	$sqlact="update botones set Estatus=2 where IdBoton=".$boton.";";
	$link->consultar($sqlact);
	$exitact=$link->affected();
	if($exitact==1||$exitact==0)
	{
		if($up=='')
		{
			$sqlmxb="insert into materialesxboton(IdMaterial,IdBoton) values(".$material.",".$boton.")";
			$link->consultar($sqlmxb);
			$exitomxb=$link->affected();
		}
		else
		if($up==1)
		{
			$sqlmxb="update materialesxboton set IdMaterial=".$material." where IdBoton=".$boton.";";
			$link->consultar($sqlmxb);
			$exitomxb=$link->affected();
		}
		
	}
	
	$sqlc="Unlock tables;";
	$link->consultar($sqlc);
	//$link->cerrar();
	
	if($exitomxb!=1&&$exitact!=1&&$exitact!=0){	
?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">LA ASIGNACIÓN DE MATERIAL NO PUDO SER REALIZADA, INTENTELO NUEVAMENTE </td>
  </tr>
</table>

<?php } 
else{
?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo" >LA ASIGNACI&Oacute;N HA SIDO REALIZADO EXITOSAMENTE </td>
  </tr>
  
  <tr>
    <td width="4934" colspan="3" >&nbsp;</td>
  </tr>
</table>
<table width="450" border="0" align="center">
  
  <tr>
    <th width="183" class="EncabezadoTabla" scope="col">BOT&Oacute;N</th>
    <th width="251" colspan="2" class="EncabezadoTabla" scope="col">MATERIAL</th>
  </tr>
  <tr class="Item1">
    <td><?php  regresa(botones,Identificador,IdBoton,$boton);  ?></td>
    <td colspan="2"><?php regresa(materiales,Descripcion,IdMaterial,$material);  ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="399" >&nbsp;</td>
	
	<form action="1Inicio.php" method="post" name="frm">
    <td width="191" ><input name="Submit" type="submit" class="boton" value="Asignar Otros Botones" /></td>
	</form>
  </tr>
</table>
<?php } 
?>

</body>
</html>
