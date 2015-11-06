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
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	$tolerancia=$_REQUEST[tolerancia];
	$minimo=$_REQUEST[minimo];
	$ruta=$_REQUEST[ruta];
?>
<body>
<table align="center" width="845" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Registro de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="511" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo">VERIFIQUE QUE LOS DATOS A REGISTRAR SEAN CORRECTOS </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">RUTA    </td>
    <td class="EncabezadoTabla">TIEMPO M&Iacute;NIMO    </td>
    <td class="EncabezadoTabla">TOLERANCIA    </td>
  </tr>
 
  <tr class="Item1">
    <td width="148"><div align="center">R<?php echo $ruta;?></div></td>
    <td width="178"> <div align="center"><?php echo $minimo; ?> min.</div></td>
    <td width="171"><div align="center"><?php echo $tolerancia; ?> min.</div></td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
    <td>&nbsp;</td>
    <form action="1Inicio.php" method="post" name="frmr">
	<td><div align="right">
	 <input type="hidden" name="ruta" value="<?php echo $ruta;?>" />
      <input type="hidden" name="minimo" value="<?php echo $minimo;?>"/>
      <input type="hidden" name="tolerancia" value="<?php echo $tolerancia;?>" />
      <input name="Submit" type="submit" class="boton" value="Modificar" />
    </div></td>
	</form>
	
    <form action="3Registra.php" method="post" name="frm"><td><div align="right">
      <input type="hidden" name="ruta" value="<?php echo $ruta;?>" />
      <input type="hidden" name="minimo" value="<?php echo $minimo;?>"/>
      <input type="hidden" name="tolerancia" value="<?php echo $tolerancia;?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar" />
    </div></td></form>
  </tr>
</table>

</body>
</html>
