<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;SCA.- Consulta de Camiones</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

 <?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$camion=$_REQUEST[camion];
$sql="select * from camiones where IdProyecto=$IdProyecto and idcamion=$camion";
$link=SCA::getConexion();
$r=$link->consultar($sql);
$v=mysql_fetch_array($r);
?>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="23">&nbsp;</td>
    <td width="72">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="151" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="94" colspan="2"><?PHP echo fecha($v[FechaAlta]); ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO: </td>
    <td colspan="6"><?php regresa(sindicatos,NombreCorto,IdSindicato,$v[IdSindicato]) ?>
      &nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto">PROPIETARIO:</td>
    <td colspan="4"><?php echo $v[Propietario]; ?></td>
    <td width="10" colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="120" >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto" >OPERADOR:</td>
    <td width="470" ><?php regresa(operadores,Nombre,IdOperador,$v[IdOperador]) ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="257">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Concepto">NO. ECON&Oacute;MICO: </td>
    <td>&nbsp;<?php echo $v[Economico]; ?></td>
    <td class="Concepto">PLACAS:</td>
    <td colspan="2"><?php echo $v[Placas]; ?></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td width="113">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="139">&nbsp;</td>
    <td width="7">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Concepto">MARCA:</td>
    <td><?php regresa(marcas,Descripcion,IdMarca,$v[IdMarca]); ?></td>
    <td width="53" class="Concepto">MODELO:</td>
    <td colspan="2"><?php echo $v[Modelo]; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="120" class="Concepto" >ASEGURADORA:</td>
    <td width="470" colspan="3"><?php echo $v[Aseguradora]; ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="129" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="156" ><?php echo $v[PolizaSeguro]; ?></td>
    <td width="24">&nbsp;</td>
    <td width="130" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="139" ><?php echo fecha($v[VigenciaPolizaSeguro]); ?></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8"><div align="center" class="Subtitulo">INFORMACI&Oacute;N ADICIONAL DEL CAMI&Oacute;N </div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="46" class="Concepto">ANCHO:</td>
    <td width="90"><?php echo $v[Ancho]; ?> m </td>
    <td width="55" class="Concepto" >LARGO:</td>
    <td width="91" ><?php echo $v[Largo]; ?> m </td>
    <td width="40" class="Concepto">ALTO:</td>
    <td width="90"><?php echo $v[Alto]; ?> m </td>
    <td width="64" class="Concepto" >EXTENSI&Oacute;N:</td>
    <td width="90" ><?php echo $v[AlturaExtension]; ?> m </td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="124" >&nbsp;</td>
    <td width="60">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="86"><?php echo $v[EspacioDeGato]; ?> m</td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td><?php echo $v[CubicacionReal]; ?> m<sup>3</sup></td>
    <td width="163" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="89" ><?php echo $v[CubicacionParaPago]; ?> m<sup>3</sup></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="184" class="Concepto" >DISPOSITIVO ELECTRONICO:</td>
    <td width="171"><?php regresa(botones,Identificador,IdBoton,$v[IdBoton]); ?></td>
    <td width="137" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="137" >&nbsp;</td>
    <td width="90" ><input name="Submit" type="button" class="boton" onClick="history.go(-1)" value="Regresar" /></td>
  </tr>
</table>
</body>
</html>
