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
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
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
$propietario=$_REQUEST[propietario];
$operadores=$_REQUEST[operadores];
$botones=$_REQUEST[botones];
$placas=$_REQUEST[placas];
$economico=$_REQUEST[economico];
$marcas=$_REQUEST[marcas];
$modelo=$_REQUEST[modelo];
$poliza=$_REQUEST[poliza];
$vigencia=$_REQUEST[vigencia];
$aseguradora=$_REQUEST[aseguradora];
$ancho=$_REQUEST[ancho];
$largo=$_REQUEST[largo];
$alto=$_REQUEST[alto];
$extension=$_REQUEST[extension];
$gato=$_REQUEST[gato];
$creal=$_REQUEST[creal];
$cpago=$_REQUEST[cpago];
$fecha=$_REQUEST[fecha];
$registro=date("Y-m-d");
$hora=date("H:i:s");
###SE QUITAN COMAS

$anchoc=str_replace(",","",$ancho);
$largoc=str_replace(",","",$largo);
$altoc=str_replace(",","",$alto);
$extensionc=str_replace(",","",$extension);
$gatoc=str_replace(",","",$gato);
$crealc=str_replace(",","",$creal);
$cpagoc=str_replace(",","",$cpago);





//$fecha2=fechasql($fecha);
$vigencia2=fechasql($vigencia);
$link=SCA::getConexion();
$sqla="Lock Tables camiones Write;";
$link->consultar($sqla);
$sql="insert into camiones(IdProyecto,HoraAlta,IdSindicato, Propietario, IdOperador, IdBoton, Placas, Economico, IdMarca, Modelo, PolizaSeguro, VigenciaPolizaSeguro, Aseguradora, Ancho, Largo, Alto, AlturaExtension, EspacioDeGato, CubicacionReal, CubicacionParaPago, FechaAlta) values ($IdProyecto,'$hora',$sindicatos, '$propietario', $operadores, $botones, '$placas', '$economico', $marcas, '$modelo','$poliza','$vigencia2','$aseguradora',$anchoc,$largoc,$altoc, $extensionc,$gatoc,$crealc,$cpagoc,'$fecha')";
//echo $sql;
$link->consultar($sql);
$exito=$link->affected();
//echo $exito;
$sqlc="Unlock tables;";
$link->consultar($sqlc);
$link->cerrar();
		if($exito!=1){	
?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Titulo">EL CAMI&Oacute;N NO PUDO SER REGISTRADO, INTENTELO NUEVAMENTE </td>
  </tr>
</table>

<?php }
else
{
$link=SCA::getConexion();
$sboton="update botones set Estatus=2 where  IdBoton=$botones";
$link->consultar($sboton);
$link->cerrar();
?>
<form action="Inicio.php" method="post">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo">EL CAMI&Oacute;N CON N&Uacute;MERO ECON&Oacute;MICO <?php echo $economico; ?> HA SIDO REGISTRADO &Eacute;XITOSAMENTE</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="77">&nbsp;</td>
    <td width="150">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="140" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="195" colspan="2"><?PHP echo fecha($fecha); ?>
    <input type="hidden" name="fecha" value="<?PHP echo $fecha; ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO: </td>
    <td colspan="6"><?php  regresa(sindicatos,NombreCorto,IdSindicato,$sindicatos) ?>&nbsp;
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
    <td colspan="4"><?php echo $propietario; ?><input name="propietario" type="hidden" value="<?php echo $propietario; ?>"></td>
    <td width="10" colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="127" >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto" >OPERADOR:</td>
    <td width="463" ><?php regresa(operadores,Nombre,IdOperador,$operadores) ?>
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
    <td>&nbsp;<?php echo $economico; ?>
      <input type="hidden" value="<?php echo $economico; ?>" name="economico"></td>
    <td class="Concepto">PLACAS:</td>
    <td colspan="2"><?php echo $placas; ?>
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
    <td><?php regresa(marcas,Descripcion,IdMarca,$marcas); ?> <input type="hidden" value="<?php echo $marcas; ?>" name="marcas"></td>
    <td width="53" class="Concepto">MODELO:</td>
    <td colspan="2"><?php echo $modelo; ?>
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
    <td width="470" colspan="3"><?php echo $aseguradora; ?>
      <input type="hidden" value="<?php echo $aseguradora; ?>" name="aseguradora"></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="138" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="147" ><?php echo $poliza; ?>
      <input type="hidden" value="<?php echo $poliza; ?>" name="poliza"></td>
    <td width="51">&nbsp;</td>
    <td width="134" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="108" ><?php echo $vigencia; ?>
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
    <td width="90"><?php echo $ancho; ?> m 
      <input type="hidden" value="<?php echo $ancho; ?>" name="ancho"></td>
    <td width="55" class="Concepto" >LARGO:</td>
    <td width="91" ><?php echo $largo; ?>
      m
      <input type="hidden" value="<?php echo $largo; ?>" name="largo"></td>
    <td width="40" class="Concepto">ALTO:</td>
    <td width="90"><?php echo $alto; ?>
m      
  <input type="hidden" value="<?php echo $alto; ?>" name="alto"></td>
    <td width="64" class="Concepto" >EXTENSI&Oacute;N:</td>
    <td width="90" ><?php echo $extension; ?>
m      
  <input type="hidden" value="<?php echo $extension; ?>" name="extension"></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="123" >&nbsp;</td>
    <td width="66">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="86"><?php echo $gato; ?>
      m
      <input type="hidden" value="<?php echo $gato; ?>" name="gato"></td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td><?php echo $creal; ?>
m<sup>3</sup>      
<input type="hidden" value="<?php echo $creal; ?>" name="creal"></td>
    <td width="162" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="85" ><?php echo $cpago; ?>
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
    <td width="178" class="Concepto" >DISPOSITIVO ELECTRONICO:</td>
    <td width="177"><?php regresa(botones,Identificador,IdBoton,$botones); ?>
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
    <td width="145" >&nbsp;</td>
    <td width="82" ><input name="Submit2" type="submit" class="boton" value="Registrar Otro Cami\F3n"  /></td>
  </tr>
</table>
</form>
<?php }

?>
</body>
</html>
