<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CostoViaje.gif" width="16" height="16" />&nbsp;SCA.- Registro de Tarifas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	$idmaterial=$_REQUEST[idmaterial];
	$material=$_REQUEST[material];
	$p=$_REQUEST[p];
	$e=$_REQUEST[e];
	$s=$_REQUEST[s];
	$a=$_REQUEST[a];
	$registro=date("Y-m-d");
	$hora=date("H:i:s");
	$link=SCA::getConexion();
	$sqla="Lock Tables tarifas,materiales Write;";
	$link->consultar($sqla);
	$valida="select * from tarifas where IdMaterial=".$idmaterial."";
	
	$link->consultar($valida);
	$previa=$link->affected();
	if($previa==0)
	$sql="insert into tarifas (IdMaterial,PrimerKM,KMSubsecuente,KMAdicional) values('".$idmaterial."','".$p."','".$s."','".$a."')";
	else
	if($previa>0)
	$sql="update  tarifas set PrimerKM='".$p."', KMSubsecuente='".$s."', KMAdicional='".$a."' where IdMaterial='".$idmaterial."'";
	//echo $sql;
	$link->consultar($sql);
	$ex=$link->affected();
	$sqlc="Unlock tables;";
	$link->consultar($sqlc);
	$link->cerrar();

if($ex>0)
{
?>
<form action="1Inicio.php" method="post" name="frm">
<table width="511" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo">LA TARIFA HA SIDO REGISTRADA EXITOSAMENTE </td>
  </tr>
  <tr>
    <td width="148">&nbsp;</td>
    <td width="168">&nbsp;</td>
    <td width="181">&nbsp;</td>
  </tr>
</table>
<table width="500" align="center" border="0">
  <tr>
    <td class="EncabezadoTabla">MATERIAL</td>
    <td width="65" class="EncabezadoTabla">1ER. KM </td>
    <td width="75" class="EncabezadoTabla">KM. SUBS. </td>
    <td width="76" class="EncabezadoTabla">KM. ADIC. </td>
    <td width="90" class="EncabezadoTabla">ESTATUS M. </td>
  </tr>
  <tr class="Item1">
    <td  align="center" ><?php echo $material; ?>        </td>
    <td width="65"  align="right"  >$ <?php echo $p; ?>        </td>
    <td width="75"  align="right"  >$ <?php echo $s; ?>        </td>
    <td width="76"   align="right" >$ <?php echo $a; ?>        </td>
    <td width="90"  align="center"><?php echo $e; ?>        </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td  align="center">&nbsp;</td>
    <td  align="center">&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"  align="center"><input name="Submit" type="submit" class="boton" value="Registrar Otras Tarifas" /></td>
    </tr>
</table>
</form>
<?php } else { ?>
<table width="561" border="0" align="center">
  <tr>
    <td class="Subtitulo">LA TARIFA NO PUDO SER REGISTRADA, INTENTELO NUEVAMENTE </td>
  </tr>
</table>

<?php }?>

</body>
</html>
