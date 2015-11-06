<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Camiones</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");

$sindicatos=$_REQUEST[sindicatos];
$propietario=strtoupper($_REQUEST[propietario]);
$operadores=$_REQUEST[operadores];

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
$camion=$_REQUEST[camion];
$estatus=$_REQUEST[estatus];

 if($estatus==0)
  $Estatus="INACTIVO";
  else 
  if($estatus==1)
  $Estatus="ACTIVO";

$b=$_REQUEST[BotonesN];
$bv=$_REQUEST[botonv];
if($b!='A99')
{
	$bv=$_REQUEST[botonv];
	$e=$_REQUEST[estatusnb];
	if($e==0)
	$estatusb="INACTIVO";
	else
	if($e==1)
	$estatusb="ACTIVO";
	else
	if($e==3)
	$estatusb="PERDIDO";
	
}

$link=SCA::getConexion();
$busca="
select 
	* 
from 
	camiones 
where 
	IdCamion not in($camion) and
	(IdProyecto=$IdProyecto and 
	Placas='$placas' or Economico='$economico')";
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
    <td width="94" colspan="2"><?PHP echo fecha($v[FechaAlta]); ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO AFILIADO: </td>
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
    <td width="119" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="166" ><?php echo $v[PolizaSeguro]; ?></td>
    <td width="51">&nbsp;</td>
    <td width="103" class="Concepto" >VIGENCIA POLIZA: </td>
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
    <td width="106" >&nbsp;</td>
    <td width="105">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="46" class="Concepto">GATO:</td>
    <td width="90" class="texto"><?php echo $v[EspacioDeGato]; ?> m </td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td class="texto"><?php echo $v[CubicacionReal]; ?>&nbsp;m<sup>3</sup></td>
    <td width="137" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="90" class="texto" ><?php echo $v[CubicacionParaPago]; ?>&nbsp;m<sup>3</sup></td>
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
    <td class="Concepto" >DISPOSITIVO ELECTRONICO:</td>
    <td width="190"><?php regresa(botones,Identificador,IdBoton,$v[IdBoton]); ?></td>
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
<form name="frm" action="4Modifica.php" method="post">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo">VERIFIQUE QUE LOS DATOS A REGISTRAR SEAN CORRECTOS </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><input type="hidden" name="camion" value="<?php echo $camion; ?>" /></td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="33">&nbsp;</td>
    <td width="101">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="151" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="132" colspan="2"><?PHP echo fecha($fecha); ?>
    <input type="hidden" name="fecha" value="<?PHP echo $fecha; ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="131" class="Concepto" >SINDICATO: </td>
    <td width="459" ><?php  regresa(sindicatos,NombreCorto,IdSindicato,$sindicatos) ?>&nbsp;
      <input type="hidden" value="<?php echo $sindicatos; ?>" name="sindicatos"></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td width="65" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="123" class="Concepto">PROPIETARIO:</td>
    <td width="262" ><input name="propietario" type="hidden" value="<?php echo $propietario; ?>">
      <?php echo $propietario; ?></td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="131" >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto" >OPERADOR:</td>
    <td width="459" ><?php regresa(operadores,Nombre,IdOperador,$operadores) ?>
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
    <td width="131" class="Concepto" >ASEGURADORA:</td>
    <td width="459" colspan="3"><?php echo $aseguradora; ?>
      <input type="hidden" value="<?php echo $aseguradora; ?>" name="aseguradora"></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="131" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="154" ><?php echo $poliza; ?>
      <input type="hidden" value="<?php echo $poliza; ?>" name="poliza"></td>
    <td width="34">&nbsp;</td>
    <td width="130" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="129" ><?php echo $vigencia; ?>
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
    <td width="131" >&nbsp;</td>
    <td width="72">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="86" class="texto"><?php echo $gato; ?> m<sup>3</sup>
      <input type="hidden" value="<?php echo $gato; ?>" name="gato"></td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td class="texto"><?php echo $creal; ?> m<sup>3</sup>
      <input type="hidden" value="<?php echo $creal; ?>" name="creal"></td>
    <td width="163" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="70" class="texto" ><?php echo $cpago; ?> m<sup>3</sup>
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
  
  
	<?php if($b=="A99") { ?>
	<tr>
    <td width="179" class="Concepto" >DISPOSITIVO ELECTRONICO</td>
    <td width="198" class="texto"><?php regresa(botones,Identificador,IdBoton,$bv); ?>
      <input type="hidden" value="<?php echo $bv; ?>" name="botones"></td>
    <td width="141" >&nbsp;</td>
    <td width="64" >&nbsp;</td>
	</tr>
	<?php }
	else {
	?>
	<tr>
    <td width="179" class="Concepto" >DISPOSITIVO ELECTRONICO</td>
	 <td width="198" class="textoG">ACTUAL: <?php regresa(botones,Identificador,IdBoton,$bv); 	echo '&nbsp;('.$estatusb.')';?>
      <input type="hidden" value="<?php echo $bv; ?>" name="botones"></td>
    <td width="141" colspan="2" class="textoG" >NUEVO: <?php regresa(botones,Identificador,IdBoton,$b); ?></td>
	</tr>
    <?php }
	
	?>
  
</table>
<table width="600" border="0" align="center">
  <tr>
    <td width="60">&nbsp;</td>
    <td width="530">&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto">ESTATUS:</td>
    <td>
        <?php echo $Estatus; ?>
        <input type="hidden" name="estatus" value="<?php echo $estatus; ?>"> 
           </td>
  </tr>
  <input name="botonv" type="hidden" value="<?php echo $bv; ?>" />
        <input name="BotonesN" type="hidden" value="<?php echo $b; ?>" />
        <input name="estatusnb" type="hidden" value="<?php echo $e; ?>" /> 
</table>
</form>
<table width="600" border="0" align="center">
  <tr>
    <td width="165" >&nbsp;
    </td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="190">&nbsp;</td>
   <form action="2Detalles.php">
    <input type="hidden" name="camion" value="<?php echo $camion; ?>" />
	<td width="145" ><input name="Submit3" type="submit" class="boton" value="Regresar" />
	</td>
	</form>
    <td width="82" ><input name="Submit2" type="button" class="boton" onClick="frm.submit()" value="Modificar"  /></td>
  </tr>
</table>

<?php } ?>
</body>
</html>
