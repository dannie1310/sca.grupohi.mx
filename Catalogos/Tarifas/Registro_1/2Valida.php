<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript">
function valida()
{
if(document.frm.p.value=='')
{
	alert("POR FAVOR INDIQUE LA TARIFA PARA EL PRIMER KILOMETRO");
	document.frm.p.focus();
	return false;
}
else
if(document.frm.p.value=='')
{
	alert("POR FAVOR INDIQUE LA TARIFA PARA LOS KILOMETROS SUBSECUENTES");
	document.frm.s.focus();
	return false;
}
else
if(document.frm.p.value=='')
{
	alert("POR FAVOR INDIQUE LA TARIFA PARA LOS KILOMETROS ADICIONALES");
	document.frm.a.focus();
	return false;
}
else
return true;
}
</script>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	$idmaterial=$_REQUEST[idmaterial];
	$material=$_REQUEST[material];
	$p=$_REQUEST[p];
	$e=$_REQUEST[e];
	$s=$_REQUEST[s];
	$a=$_REQUEST[a];
	//echo 'das'.$material;
?>
<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CostoViaje.gif" width="16" height="16" />&nbsp;SCA.- Registro de Tarifas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="500" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo">DATOS DE TARIFA</td>
  </tr>
  <tr>
    <td width="148">&nbsp;</td>
    <td width="178">&nbsp;</td>
    <td width="171">&nbsp;</td>
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
    <td  align="center" >     <?php echo $material; ?>
     
</td>
    <td width="65" align="right" >$ 
    <input name="p" type="text" class="text" style="text-align:right " onkeyup="document.frm.p.value=this.value"  onKeyPress="onlyDigits(event,'decOK')"  value="<?php echo $p; ?>" size="5" maxlength="5" /></td>
    <td width="75"  align="right"  >$ 
    <input name="s" type="text" class="text" style="text-align:right "  onkeyup="document.frm.s.value=this.value" onKeyPress="onlyDigits(event,'decOK')"  value="<?php echo $s; ?>" size="5" maxlength="5"/></td>
    <td width="76"   align="right" >$ 
    <input name="a" type="text" class="text" style="text-align:right "  onkeyup="document.frm.a.value=this.value" onKeyPress="onlyDigits(event,'decOK')"  value="<?php echo $a; ?>" size="5" maxlength="5" /></td>
    <td width="90"  align="center"><?php echo $e; ?>
     </td>
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
	 <form action="2Valida.php" method="post" name="frmr">
	  <input type="hidden" name="p" value="<?php echo $p; ?>" />
	<input type="hidden" name="s" value="<?php echo $s; ?>" />
	<input type="hidden" name="a" value="<?php echo $a; ?>" />
	<input type="hidden" name="e" value="<?php echo $e; ?>" />
    <input type="hidden" name="material" value="<?php echo $material; ?>" />
    <input type="hidden" name="idmaterial" value="<?php echo $idmaterial; ?>" />
    <td  align="center"><input name="Submit" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
   </form>

   <form action="3Valida.php" method="post" name="frm">
    <input type="hidden" name="p" value="" />
	<input type="hidden" name="s" value="" />
	<input type="hidden" name="a" value="" />
	<input type="hidden" name="e" value="<?php echo $e; ?>" />
    <input type="hidden" name="material" value="<?php echo $material; ?>" />
    <input type="hidden" name="idmaterial" value="<?php echo $idmaterial; ?>" />
    <td  align="center"><input name="Submit" type="button" class="boton" onclick="if(valida())this.form.submit()" value="Registrar" /></td>
 </form>
  </tr>
</table>

</body>
</html>
