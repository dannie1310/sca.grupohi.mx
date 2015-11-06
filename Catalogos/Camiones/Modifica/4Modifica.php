<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
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
$propietario=$_REQUEST[propietario];
$operadores=$_REQUEST[operadores];

$placas=$_REQUEST[placas];
$economico=$_REQUEST[economico];
$marcas=$_REQUEST[marcas];
$modelo=$_REQUEST[modelo];
$poliza=$_REQUEST[poliza];
$vigencia=fechasql($_REQUEST[vigencia]);
$aseguradora=$_REQUEST[aseguradora];
$ancho=$_REQUEST[ancho];
$largo=$_REQUEST[largo];
$alto=$_REQUEST[alto];
$extension=$_REQUEST[extension];
$gato=$_REQUEST[gato];
$creal=$_REQUEST[creal];
$cpago=$_REQUEST[cpago];
$camion=$_REQUEST[camion];
$estatus=$_REQUEST[estatus];
###SE QUITAN COMAS

$anchoc=str_replace(",","",$ancho);
$largoc=str_replace(",","",$largo);
$altoc=str_replace(",","",$alto);
$extensionc=str_replace(",","",$extension);
$gatoc=str_replace(",","",$gato);
$crealc=str_replace(",","",$creal);
$cpagoc=str_replace(",","",$cpago);
$bot="";
$link=SCA::getConexion();
$sqla="Lock Tables camiones, botones Write;";
$link->consultar($sqla);

$b=$_REQUEST[BotonesN];
$bv=$_REQUEST[botonv];
if($b!='A99')
{	$link2=SCA::getConexion();
	$bv=$_REQUEST[botonv];
	$e=$_REQUEST[estatusnb];
	$bot=", IdBoton=$b";
	$sqlnb="update botones set Estatus=2 where IdBoton=$b";
	$sqlvb="update botones set Estatus=$e where IdBoton=$bv";
//echo $sqlnb.'<br />';
//echo $sqlvb.'<br />';

	$link2->consultar($sqlnb);
	$afenb=$link2->affected();
	
	$link2->consultar($sqlvb);
	$afevb=$link2->affected();
	//echo $sqlnb.'<br>'.$afenb;
	//echo $sqlvb.'<br>'.$afevb;
	$link2->cerrar();
	if($e==0)
	$estatusb="INACTIVO";
	else
	if($e==1)
	$estatusb="ACTIVO";
	else
	if($e==3)
	$estatusb="PERDIDO";
	
}
if($estatus==0){$bot=", IdBoton = 0";}
$link=SCA::getConexion();
$update="
update 
	camiones
set
	IdSindicato=$sindicatos,
	Propietario='$propietario',
	IdOperador=$operadores,
	Placas='$placas',
	Economico='$economico',
	IdMarca=$marcas,
	Modelo='$modelo',
	PolizaSeguro='$poliza',
	VigenciaPolizaSeguro='$vigencia',
	Aseguradora='$aseguradora',
	Ancho=$anchoc,
	Largo=$largoc,
	Alto=$altoc,
	AlturaExtension=$extensionc,
	EspacioDeGato=$gatoc,
	CubicacionReal=$crealc,
	Estatus=$estatus,
	CubicacionParaPago=$cpagoc
	$bot
where
IdCamion=$camion

";
//echo $update;
$link->consultar($update);
$afe=$link->affected();


$sqlc="Unlock tables;";
$link->consultar($sqlc);

if($afe>=0)
{
$busca="
select *, case Estatus
when 0 then 'INACTIVO'
when 1 then 'ACTIVO'
end Estate from camiones 
where
IdCamion=$camion ";
$ro=$link->($busca);
$v=mysql_fetch_array($ro);
$link->cerrar();
?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo">LOS DATOS DEL CAMI&Oacute;N HAN SIDO MODIFICADOS EXITOSAMENTE </td>
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
    <td width="129" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="156" class="texto" ><?php echo $v[PolizaSeguro]; ?></td>
    <td width="35">&nbsp;</td>
    <td width="119" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="139" class="texto" ><?php echo fecha($v[VigenciaPolizaSeguro]); ?></td>
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
    <td width="123" >&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="86" class="texto"><?php echo $v[EspacioDeGato]; ?> m </td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td class="texto"><?php echo $v[CubicacionReal]; ?>&nbsp;m<sup>3</sup></td>
    <td width="162" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="89" class="texto" ><?php echo $v[CubicacionParaPago]; ?>&nbsp;m<sup>3</sup></td>
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
    <td width="60">&nbsp;</td>
    <td width="530">&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto">ESTATUS:</td>
    <td><?php echo $v[Estate]; ?>
    </td>
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
    <form action="1Muestra.php" method="post" name="regresa">
	<td width="90" ><input name="Submit" type="submit" class="boton" value="Modificar Otros Camiones" /></td>
	</form>
  </tr>
</table>
<?php } else{?>

<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo">HUBO UN ERROR AL ACTUALIZAR LOS DATOS DEL CAMI&Oacute;N, POR FAVOR VUELVA A INTENTARLO</td>
  </tr>
  <tr>
    <td width="10">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="351">&nbsp;</td>
    <td width="163" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
	 <form action="1Muestra.php" method="post" name="regresa">
	<td  ><div align="right">
	  <input name="Submit" type="submit" class="boton" value="Continuar" />
	  </div></td>
	</form>
   
  </tr>
  <tr>
</table>
    

<?php } ?>
</body>
</html>
