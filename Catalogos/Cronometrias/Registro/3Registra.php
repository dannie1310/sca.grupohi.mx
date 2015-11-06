<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="845" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Registro de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	$tolerancia=$_REQUEST[tolerancia];
	$minimo=$_REQUEST[minimo];
	$ruta=$_REQUEST[ruta];
	$registro=date("Y-m-d");
	$hora=date("H:i:s");
	$link=SCA::getConexion();
	$sqla="Lock Tables cronometrias,Rutas Write;";
	$link->consultar($sqla);
	$sql="insert into cronometrias (HoraAlta,FechaAlta,IdRuta,TiempoMinimo,Tolerancia) values('$hora','$registro',$ruta,$minimo,$tolerancia)";
	$link->consultar($sql);
	$ex=$link->affected();
	$sqlc="Unlock tables;";
	$link->consultar($sqlc);
	$link->cerrar();

if($ex==1)
{
?>
<form action="1Inicio.php" method="post" name="frm">
<table width="511" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo">LA CRONOMETRIA HA SIDO REGISTRADA &Eacute;XITOSAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="148" class="EncabezadoTabla">RUTA    </td>
    <td width="168" class="EncabezadoTabla">TIEMPO M&Iacute;NIMO    </td>
    <td width="181" class="EncabezadoTabla">TOLERANCIA    </td>
  </tr>
  <tr class="Item1">
    <td width="148"><div align="center">R<?php echo $ruta;?></div></td>
    <td width="168"><div align="center"><?php echo $minimo; ?> min.</div></td>
    <td width="181"><div align="center"><?php echo $tolerancia; ?> min.</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right">
        <input name="Submit2" type="submit" class="boton" value="Registrar Otras Cronometrias" />
    </div></td>
    </tr>
</table>
</form>
<?php } else { ?>
<table width="561" border="0" align="center">
  <tr>
    <td>LA CRONOMETRIA NO PUDO SER REGISTRADA, INTENTELO NUEVAMENTE </td>
  </tr>
</table>

<?php }?>

</body>
</html>
