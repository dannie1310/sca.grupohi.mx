<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;SCA.- Registro de Camiones</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");

$sindicatos=$_REQUEST[sindicatos];
$propietario=strtoupper($_REQUEST[propietario]);
$operadores=$_REQUEST[operadores];
$botones=$_REQUEST[botones];
$placas=strtoupper($_REQUEST[placas]);
$economico=strtoupper($_REQUEST[economico]);
$marcas=$_REQUEST[marcas];
$modelo=strtoupper($_REQUEST[modelo]);
$poliza=strtoupper($_REQUEST[poliza]);
$vigencia=$_REQUEST[vigencia];
$aseguradora=strtoupper($_REQUEST[aseguradora]);
$ancho=$_REQUEST[ancho];
$largo=$_REQUEST[largo];
$alto=$_REQUEST[alto];
$extension=$_REQUEST[extension];
$gato=$_REQUEST[gato];
$creal=$_REQUEST[creal];
$cpago=$_REQUEST[cpago];
$fecha=$_REQUEST[fecha];
$link=SCA::getConexion();
$busca="select  * from camiones where IdProyecto=$IdProyecto and Placas='$placas' or Economico='$economico'";
//echo $busca;
$ro=$link->consultar($busca);
$v=mysql_fetch_array($ro);
$afe=$link->affected();

if($afe>=1)
{

?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo"><?PHP if(($placas==$v[Placas])&&($economico!=$v[Economico])) {?>LAS PLACAS QUE DESEA REGISTRAR YA EXISTEN EN EL SIGUIENTE REGISTRO. <?PHP } else if(($placas!=$v[Placas])&&($economico==$v[Economico])){?> EL N&Uacute;MERO ECON&Oacute;MICO QUE DESEA REGISTRAR YA EXISTE EN EL SIGUIENTE REGISTRO. <?PHP } else if(($placas==$v[Placas])&&($economico==$v[Economico])){ ?>EL N&Uacute;MERO ECON&Oacute;MICO Y LAS PLACAS QUE DESEA REGISTRAR, YA EXISTEN EN EL SIGUIENTE REGISTRO.<?PHP }?> </td>
  </tr>
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
    <td width="94" colspan="2" class="texto"><?PHP echo fecha($v[FechaAlta]); ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO: </td>
    <td colspan="6" class="texto"><?php regresa(sindicatos,NombreCorto,IdSindicato,$v[IdSindicato]) ?>
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
    <td colspan="4" class="texto"><?php echo $v[Propietario]; ?></td>
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
    <td width="470" class="texto" ><?php regresa(operadores,Nombre,IdOperador,$v[IdOperador]) ?></td>
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
    <td class="texto">&nbsp;<?php echo $v[Economico]; ?></td>
    <td class="Concepto">PLACAS:</td>
    <td colspan="2" class="texto"><?php echo $v[Placas]; ?></td>
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
    <td class="texto"><?php regresa(marcas,Descripcion,IdMarca,$v[IdMarca]); ?></td>
    <td width="53" class="Concepto">MODELO:</td>
    <td colspan="2" class="texto"><?php echo $v[Modelo]; ?></td>
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
    <td width="470" colspan="3" class="texto"><?php echo $v[Aseguradora]; ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="132" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="153" class="texto" ><?php echo $v[PolizaSeguro]; ?></td>
    <td width="23">&nbsp;</td>
    <td width="121" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="149" class="texto" ><?php echo fecha($v[VigenciaPolizaSeguro]); ?></td>
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
    <td width="90" class="texto"><?php echo $v[Ancho]; ?> m </td>
    <td width="55" class="Concepto" >LARGO:</td>
    <td width="91" class="texto" ><?php echo $v[Largo]; ?> m </td>
    <td width="40" class="Concepto">ALTO:</td>
    <td width="90" class="texto"><?php echo $v[Alto]; ?> m </td>
    <td width="64" class="Concepto" >EXTENSI&Oacute;N:</td>
    <td width="90" class="texto" ><?php echo $v[AlturaExtension]; ?> m </td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="135" >&nbsp;</td>
    <td width="72">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="64" class="texto"><?php echo $v[EspacioDeGato]; ?> m </td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td class="texto"><?php echo $v[CubicacionReal]; ?> m<sup>3</sup></td>
    <td width="166" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="85" class="texto" ><?php echo $v[CubicacionParaPago]; ?> m<sup>3</sup></td>
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
    <td width="180" class="Concepto" >DISPOSITIVO ELECTRONICO:</td>
    <td width="175" class="texto"><?php regresa(botones,Identificador,IdBoton,$v[IdBoton]); ?></td>
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
    <td width="90" ><input name="Submit" type="button" class="boton" onClick="history.go(-1)" value="Modificar" /></td>
  </tr>
</table>
<?php } else{?>
<form name="frm" action="3Registra.php" method="post">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo">VERIFIQUE QUE LOS DATOS A REGISTRAR SEAN CORRECTOS </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="33">&nbsp;</td>
    <td width="101">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="151" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="132" colspan="2" class="texto"><?PHP echo fecha($fecha); ?>
    <input type="hidden" name="fecha" value="<?PHP echo $fecha; ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO: </td>
    <td colspan="6" class="texto"><?php  regresa(sindicatos,NombreCorto,IdSindicato,$sindicatos) ?>&nbsp;
      <input type="hidden" value="<?php echo $sindicatos; ?>" name="sindicatos"></td>
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
    <td colspan="4" class="texto"><?php echo $propietario; ?>
      <input name="propietario" type="hidden" value="<?php echo $propietario; ?>"></td>
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
    <td width="470" class="texto" ><?php regresa(operadores,Nombre,IdOperador,$operadores) ?>
      <input type="hidden" value="<?php echo $operadores; ?>" name="operadores"></td>
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
    <td class="texto">&nbsp;<?php echo $economico; ?>
      <input type="hidden" value="<?php echo $economico; ?>" name="economico"></td>
    <td class="Concepto">PLACAS:</td>
    <td colspan="2" class="texto"><?php echo $placas; ?>
      <input type="hidden" value="<?php echo $placas; ?>" name="placas"></td>
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
    <td class="texto"><?php regresa(marcas,Descripcion,IdMarca,$marcas); ?> <input type="hidden" value="<?php echo $marcas; ?>" name="marcas"></td>
    <td width="53" class="Concepto">MODELO:</td>
    <td colspan="2" class="texto"><?php echo $modelo; ?>
      <input type="hidden" value="<?php echo $modelo; ?>" name="modelo"></td>
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
    <td width="470" colspan="3" class="texto"><?php echo $aseguradora; ?>
      <input type="hidden" value="<?php echo $aseguradora; ?>" name="aseguradora"></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="129" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="156" class="texto" ><?php echo $poliza; ?>
      <input type="hidden" value="<?php echo $poliza; ?>" name="poliza"></td>
    <td width="38">&nbsp;</td>
    <td width="116" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="139" class="texto" ><?php echo $vigencia; ?>
      <input type="hidden" value="<?php echo $vigencia; ?>" name="vigencia"></td>
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
    <td width="90" class="texto"><?php echo $ancho; ?>
m      
  <input type="hidden" value="<?php echo $ancho; ?>" name="ancho"></td>
    <td width="55" class="Concepto" >LARGO:</td>
    <td width="91" class="texto" ><?php echo $largo; ?>
m      
  <input type="hidden" value="<?php echo $largo; ?>" name="largo"></td>
    <td width="40" class="Concepto">ALTO:</td>
    <td width="90" class="texto"><?php echo $alto; ?>
m      
  <input type="hidden" value="<?php echo $alto; ?>" name="alto"></td>
    <td width="64" class="Concepto" >EXTENSI&Oacute;N:</td>
    <td width="90" class="texto" ><?php echo $extension; ?>
m      
  <input type="hidden" value="<?php echo $extension; ?>" name="extension"></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="124" >&nbsp;</td>
    <td width="64">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="86" class="texto"><?php echo $gato; ?>
      m
      <input type="hidden" value="<?php echo $gato; ?>" name="gato"></td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td class="texto"><?php echo $creal; ?>
m<sup>3</sup>      
<input type="hidden" value="<?php echo $creal; ?>" name="creal"></td>
    <td width="159" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="89" class="texto" ><?php echo $cpago; ?>
m<sup>3</sup>      
<input type="hidden" value="<?php echo $cpago; ?>" name="cpago"></td>
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
    <td width="171" class="texto"><?php regresa(botones,Identificador,IdBoton,$botones); ?>
      <input type="hidden" value="<?php echo $botones; ?>" name="botones"></td>
    <td width="137" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td width="165" >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="145" ><input name="Submit3" type="button" class="boton" onClick="history.go(-1)" value="Modificar" /></td>
    <td width="82" ><input name="Submit2" type="submit" class="boton" value="Registrar"  /></td>
  </tr>
</table>
</form>
<?php } ?>
</body>
</html>
