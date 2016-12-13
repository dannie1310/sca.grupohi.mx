<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<script language="javascript" src="../../../Clases/Js/NoClick.js"></script>

<body onkeydown="backspace();">
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Sindicatos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Empresa </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
include("../../../inc/php/conexiones/SCA.php");
$RFC=$_REQUEST[RFC];

$razonSocial=$_REQUEST[razonSocial];

$link=SCA::getConexion();
$sqla="Lock Tables Empresas Write;";
$link->consultar($sqla);
$sql="insert into empresas(razonSocial,RFC) values('$razonSocial', '$RFC') ";
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
    <td class="Subtitulo">LA EMPRESA HA SIDO REGISTRADO EXITOSAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <th width="312" class="EncabezadoTabla" scope="col">DESCRIPCI&Oacute;N</th>
    <th width="272" class="EncabezadoTabla" scope="col">RFC </th>
  </tr>
  <tr class="Item1">
    <td><?php echo $razonSocial; ?></td>
    <td><?php echo $RFC; ?></td>
  </tr>
</table>
<table width="599" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="78">&nbsp;</td>
    <td width="127">&nbsp;</td>
    <td width="138">&nbsp;</td>
    <form action="1Inicio.php" method="post" name="frm" id="frm">
      <td width="238"><div align="right">
        <input name="Submit2" type="submit" class="boton" value="Registrar Otros Sindicatos" />
      </div></td>
    </form>
  </tr>
</table>
<?php } else {?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">HUBO UN ERROR AL REGISTRAR LA EMPRESA, INTENTELO NUEVAMENTE </td>
  </tr>
</table>
<?php }?>
</body>
</html>
