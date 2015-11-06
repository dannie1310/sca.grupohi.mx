<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="500" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Marcas.gif" width="16" height="16" />&nbsp;SCA.- Registro de Marcas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");

$descripcion=$_REQUEST[descripcion]; 
$link=SCA::getConexion();
$sqla="Lock Tables marcas Write;";
$link->consultar($sqla);
$sql="insert into marcas(Descripcion) values ('$descripcion');";
$link->consultar($sql);
$exito=$link->affected();
$sqlc="Unlock tables;";
$link->consultar($sqlc);
$link->cerrar();
if($exito==1)
{
?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">LA MARCA HA SIDO REGISTRADA EXITOSAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="242" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">MARCA</th>
  </tr>
  <tr>
    <td height="22" class="Item1"><?php echo $descripcion; ?></td>
  </tr>
</table>
<table width="427" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="107">&nbsp;</td>
    <td width="175">&nbsp;</td>
    <td width="174">&nbsp;</td>
    <form action="1Inicio.php" method="post" name="frm" id="frm">
      <td width="116"><div align="right">
        <input name="Submit2" type="submit" class="boton" value="Registrar Otras Marcas">
      </div></td>
    </form>
  </tr>
</table>
<?php } else { ?><table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">HUBO UN ERROR AL REGISTRAR LA MARCA, INTENTELO NUEVAMENTE </td>
  </tr>
  
</table>

<?php } ?>
</body>
</html>
