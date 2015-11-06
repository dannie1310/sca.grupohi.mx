<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Proyectos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Proyectos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
include("../../../inc/php/conexiones/SCA.php");
$link=SCA::getConexion();
$corto=strtoupper(trim($_REQUEST[corto]));
$descripcion=strtoupper(trim($_REQUEST[descripcion]));
$sqla="Lock Tables proyectos Write;";
$link->consultar($sqla);
$sql="insert into proyectos (Descripcion,NombreCorto) values('$descripcion','$corto')";
//echo $sql;
$link->consultar($sql);
$ex=$link->affected();
$sqlc="Unlock tables;";
$link->consultar($sqlc);
$link->cerrar();
if($ex==1)
{
?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="center" class="Subtitulo">EL PROYECTO HA SIDO REGISTRADO CON &Eacute;XITO </div></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="322" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td colspan="2" class="EncabezadoTabla">NOMBRE CORTO </td>
  </tr>
  <tr class="Item1">
    <td>      <?PHP 
   echo $descripcion;?>
    </td>
    <td colspan="2">      <?PHP 
   echo $corto;?>
    </td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
   
      <td width="68">&nbsp;</td>
   
    <form method="post" action="1Inicio.php">
      <td width="196"><div align="right">
        <input name="Submit" type="submit" class="boton" value="Registrar Otro Proyecto" />
      </div></td>
    </form>
  </tr>
</table>
<?php } else {?>
<table width="600" border="0" align="center">
  <tr>
    <td><div align="center" class="Subtitulo">EL PROYECTO NO PUDO SER REGISTRADO, INTENTELO NUEVAMENTE </div></td>
  </tr>
</table>
<?php } ?>

</body>
</html>
