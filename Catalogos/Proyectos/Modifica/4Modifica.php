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
<table align="center" width="700" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><img src="../../../Imgs/16-Proyectos.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Proyectos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$descripcion=$_REQUEST[descripcion];
	$estatus=$_REQUEST[estatus];
	$corto=$_REQUEST[corto];
	$proyecto=$_REQUEST[proyecto];
	
	$sql="update proyectos set  Descripcion='".$descripcion."', NombreCorto='".$corto."', Estatus=".$estatus." where IdProyecto=".$proyecto." ; ";
	
	//echo $sql;
	$link=SCA::getConexion();
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL PROYECTO FUE MODIFICADO EXITOSAMENTE </td>
  </tr>
</table>

 <table width="600" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="46" class="EncabezadoTabla">#</td>
    <td class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td class="EncabezadoTabla">NOMBRE CORTO </td>
    <td width="82" class="EncabezadoTabla">ESTATUS</td>
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
  <td width="46" class="Item1" align="center"><?php echo $proyecto;?></td>
    <td class="Item1"><?php echo $descripcion; ?></td>
    <td class="Item1"><?php echo $corto; ?></td>
    <td class="Item1" align="center">
	
     <?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="282">&nbsp;</td>
      <td width="172">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
<table width="722" align="ce">
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <form action="1Inicio.php" method="post"> <td width="533" align="right">&nbsp;</td>
    <td width="177" align="right"><input name="Submit" type="submit" class="boton" value="Modificar Otros Proyectos" /></td>
</form></tr></table>
<?php } else {?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL PROYECTO NO PUDO SER MODIFCADO, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } ?>
</body>
</html>
