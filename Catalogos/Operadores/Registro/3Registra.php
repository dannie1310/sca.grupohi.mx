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
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Member.gif" width="16" height="16" />&nbsp;SCA.- Registro de Operadores</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
session_start();
$IdProyecto=$_SESSION['Proyecto'];
$nombre=$_REQUEST[nombre];
$direccion=$_REQUEST[direccion];
$licencia=$_REQUEST[licencia];

$vigencia=str_replace(" ","",$_REQUEST[vigencia]);
$vigenciasql=fechasql(str_replace(" ","",$_REQUEST[vigencia]));
$hoy=date("Y-m-d");
$link=SCA::getConexion();
$sqla="Lock Tables operadores Write;";
$link->consultar($sqla);
$sql="Insert Into operadores (IdProyecto,Nombre,Direccion,NoLicencia,VigenciaLicencia,FechaAlta)
values($IdProyecto,'$nombre','$direccion','$licencia','$vigenciasql','$hoy')";
//echo $sql;
$link->consultar($sql);
$how=$link->affected();

$sqlc="Unlock tables;";
$link->consultar($sqlc);
$link->cerrar();
if($how==1)
{
?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="4" class="Subtitulo">EL OPERADOR HA SIDO REGISTRADO EXITOSAMENTE</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
    <tr>
    <td width="371">&nbsp;</td>
    <td width="143" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="72" colspan="2" class="Item1"><?PHP echo date("d-m-Y"); ?>
    <input type="hidden" name="fecha" value="<?PHP echo date("Y-m-d"); ?>" /></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>

<table width="600" border="0" align="center">
  
  <tr>
    <td width="112" class="Concepto">NOMBRE:</td>
    <td colspan="3" class="Item1"><?php echo $nombre; ?>&nbsp;
    <input type="hidden" name="nombre" value="<?PHP echo $nombre; ?>" /></td>
  </tr>
  <tr>
    <td class="ConceptoTop">DIRECCI&Oacute;N:</td>
    <td colspan="3" class="Item1"><?php echo $direccion; ?>&nbsp;
    <input type="hidden" name="direccion" value="<?PHP echo $direccion; ?>" /></td>
  </tr>
  <tr>
    <td class="ConceptoTop">No. LICENCIA: </td>
    <td width="174" class="Item1"><?php if ($licencia=='') echo " - - - - - - - - - - "; else echo $licencia; ?>&nbsp;
    <input type="hidden" name="licencia" value="<?PHP echo $licencia; ?>" /></td>
    <td width="71" class="Concepto">VIGENCIA:</td>
    <td width="225" class="Item1"><?php echo $vigencia; ?>&nbsp;
    <input type="hidden" name="vigencia" value="<?PHP echo $vigencia; ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="107">&nbsp;</td>
    <td width="175">&nbsp;</td>
    <td width="174">&nbsp;</td><form name="frm" action="1Inicio.php" method="post">
    <td width="116"><div align="right">
      <input name="Submit2" type="submit" class="boton" value="Registrar Otros Operadores"  />
    </div></td></form>
  </tr>
</table>


<?php } else{?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">EL OPERADOR NO PUDO SER REGISTRADO, INT&Eacute;NTELO NUEVAMENTE </td>
  </tr>
</table>

<?php } ?>
</body>
</html>
