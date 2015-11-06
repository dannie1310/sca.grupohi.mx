<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

</head>
<script>
function valida(id)
{
 if (!document.getElementById) return false;
  
  formulario = document.getElementById(id);
  if(formulario.descripcion.value=='')
  {
	  alert("INDIQUE LA DESCRIPCIÓN DE LA ETAPA");
	  formulario.descripcion.focus();
	  return false;
  }
  else
  return true;

}
</script>

<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	session_start();
	$flag=$_REQUEST[flag];
	$descripcion=$_REQUEST[descripcion];
?>
<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Etapas.gif" width="16" height="16" />SCA.- Registro de Etapas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>
<form action="2Valida.php" method="post" name="frm1" id="frm1">
<table width="500" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega1')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16" /> Agregar </td>
  </tr>
</table>
<table width="500" id="agrega1"  align="center"  <?php if($flag=='') { ?> style="display:none"  <?php } ?> >
    <tr>
      <td width="21">&nbsp;</td>
      <td width="85" class="Concepto"> DESCRIPCIÓN:</td>
      <td width="258"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50" /></td>
      <td width="116"><input name="button" type="button" class="boton" onclick="if(valida('frm1'))this.form.submit()" value="Registrar" /></td>
    </tr>
  </table>
</form>
<table width="300" border="0" align="center">
  <tr>
    <td class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?PHP
  $link=SCA::getConexion();
  $obtiene="select *, case Estatus
	when 0 then 'INACTIVO'
	when 1 then 'ACTIVO'
	end Estate FROM etapasproyectos WHERE IdProyecto= ".$_SESSION[Proyecto]." ORDER BY Nivel";
  $r=$link->consultar($obtiene);
  $pr=1;
  while($v=mysql_fetch_array($r))
  {
   ?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[Descripcion]; ?></td>
    <td align="center"><?php echo $v[Estate]; ?></td>
  </tr>
  <?php $pr++; }?>
</table>

<form action="2Valida.php" method="post" name="frm" id="frm">
<table width="500" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16" /> Agregar </td>
  </tr>
</table>
  <table width="500" id="agrega"  align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?>  >
    <tr>
      <td width="17">&nbsp;</td>
      <td width="89" class="Concepto"> DESCRIPCIÓN:        </td>
      <td width="258"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50" /></td>
      <td width="116"><input name="button2" type="button" class="boton" onclick="if(valida('frm'))this.form.submit()" value="Registrar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
