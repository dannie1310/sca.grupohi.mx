<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$minimo=$_REQUEST[minimo];
	$tolerancia=$_REQUEST[tolerancia];
	$estatus=$_REQUEST[estatus];
	$cronometria=$_REQUEST[cronometria];
	$ruta=$_REQUEST[ruta];
	
	$sql="update cronometrias set  TiempoMinimo='".$minimo."', Tolerancia='".$tolerancia."', Estatus=".$estatus." where IdCronometria=".$cronometria." ; ";
	
	//echo $sql;
	$link=SCA::getConexion();
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
	
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">LA CRONOMETR&Iacute;A FUE MODIFICADA &Eacute;XITOSAMENTE </td>
  </tr>
</table>

 <table width="400" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="58" class="EncabezadoTabla">ID RUTA </td>
    <td class="EncabezadoTabla">TIEMPO M&Iacute;NIMO </td>
    <td class="EncabezadoTabla">TOLERANCIA</td>
    <td width="66" class="EncabezadoTabla">ESTATUS</td>
   </tr>
 
  <?php
 

	//echo $sql;
  
  
  if($estatus==0)
  $Estatus="INACTIVO";
  else 
  if($estatus==1)
  $Estatus="ACTIVO";
   ?>
    <tr>
  <td width="58" class="Item1" align="center"><?php echo $ruta;?></td>
    <td class="Item1" align="right"><?php echo $minimo; ?> min.</td>
    <td class="Item1" align="right"><?php echo $tolerancia; ?> min.</td>
    <td class="Item1" align="center">
	
     <?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="141">&nbsp;</td>
      <td width="117">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
<table width="683" align="ce">
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <form action="1Inicio.php" method="post"> <td width="533" align="right">&nbsp;</td>
    <td width="177" align="right"><input name="Submit" type="submit" class="boton" value="Modificar Otras Cronometrias" /></td>
</form></tr></table>
<?php } else {?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">LA CRONOMETRIA NO PUDO SER MODIFICADA, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
