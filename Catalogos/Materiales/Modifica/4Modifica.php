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
<?php if($_SESSION[IdUsuario]!=2){?>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php }?><script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Materiales </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/FactorAbundamiento.php");

	$descripcion=$_REQUEST[descripcion];
	$fda=$_REQUEST[fda];
	$estatus=$_REQUEST[estatus];
	$corto=$_REQUEST[corto];
	$material=$_REQUEST[material];
	$fda_actual=regresa_factor($material);
	//echo '<br>fda: '.$fda_actual.'-'.$fda;
	$sql="update materiales set  Descripcion='".$descripcion."', Estatus=".$estatus." where IdMaterial=".$material." ; ";
	if(($fda!=$fda_actual)&&$fda!=0)
	{
		registra_factor($material,$fda,$_SESSION[Descripcion]);	
	}
	//echo $sql;
	$link=SCA::getConexion();
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL MATERIAL FUE MODIFICADO EXITOSAMENTE </td>
  </tr>
</table>

 <table width="350" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td class="EncabezadoTabla">FdA</td>
    <td colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
  <td align="center" class="Item1"><?php echo $descripcion; ?></td>
  <td align="center" class="Item1"><?php echo $fda; ?></td>
    <td colspan="2" align="center" class="Item1">
	
      <?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td width="169">&nbsp;</td>
      <td width="54">&nbsp;</td>
      <td width="63">&nbsp;</td>
      <td width="46">&nbsp;</td>
    </tr>
</table>
<table width="796" align="ce">
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <form action="1Inicio.php" method="post"> <td width="533" align="right">&nbsp;</td>
    <td width="177" align="right"><input name="Submit" type="submit" class="boton" value="Modificar Otros Materiales" /></td>
</form></tr></table>
<?php } else {?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL MATERIAL NO PUDO SER MODIFCADO, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
