<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<script language="javascript" src="../../../Clases/Js/NoClick.js"></script>
<script>

function valida(id)
{
 if (!document.getElementById) return false;
  
  formulario = document.getElementById(id);
  if(formulario.descripcion.value=='')
  {
	  alert("INDIQUE LA DESCRIPCIÓN DEL ARRENDADOR");
	  formulario.descripcion.focus();
	  return false;
  }
  else
   if(formulario.corto.value=='')
  {
	  alert("INDIQUE EL NOMBRE CORTO DEL ARRENDADOR");
	  formulario.corto.focus();
	  return false;
  }
  else
  return true;

}
</script>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-sindicatos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Arrendadores </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php


	session_start();
	$IdProyecto=$_SESSION['Proyecto'];

	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	//////////////////////////
	$flag=$_REQUEST[flag];
	$descripcion=$_REQUEST[descripcion];
	$corto=$_REQUEST[corto];
	$link=SCA::getConexion();
	$sql="Select *, case Estatus
	when 0 then 'INACTIVO'
	when 1 then 'ACTIVO'
	end Estate From maquinaria_arrendadores";
	$ro=$link->consultar($sql);
	
	?>
<form action="2Valida.php" method="post" name="frm1" id="frm1">
  <table width="600" border="0" align="center">
    <tr>
      <td width="103">&nbsp;</td>
      <td width="572">&nbsp;</td>
      <td width="75">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega1')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" /> Agregar </td>
    </tr>
  </table>
  <table width="600" id="agrega1"  align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?>  >
    <tr>
      <td width="21">&nbsp;</td>
      <td width="136" class="Concepto"> DESCRIPCI&Oacute;N:
      &nbsp;&nbsp;</td>
      <td width="427"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50" maxlength="50" /></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="Concepto">NOMBRE CORTO:</td>
      <td><input name="corto" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $corto; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><div align="right">
        <input name="button2" type="button" class="boton" onclick="if(valida('frm1'))this.form.submit()" value="Registrar" />
      </div></td>
    </tr>
  </table>
</form>
<table width="600" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">DESCRIPCI&Oacute;N</th>
    <th class="EncabezadoTabla" scope="col">NOMBRE CORTO </th>
    <th class="EncabezadoTabla" scope="col">ESTATUS</th>
  </tr>
   <?php 
   $pr=1;
   while($v=mysql_fetch_array($ro))
  {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[Descripcion]; ?></td>
    <td><?php echo $v[NombreCorto]; ?></td>
    <td>
    <div align="center"><?php echo $v[Estate]; ?></div></td>
  </tr>
  <?php $pr++;}?>
</table>
<form action="2Valida.php" method="post" name="frm" id="frm">
  <table width="600" border="0" align="center">
    <tr>
      <td width="103">&nbsp;</td>
      <td width="572">&nbsp;</td>
      <td width="75">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" /> Agregar </td>
    </tr>
  </table>
  <table width="600" id="agrega"  align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?>  >
   <tr>
      <td width="22">&nbsp;</td>
      <td width="135" class="Concepto"> DESCRIPCI&Oacute;N:
      &nbsp;&nbsp;</td>
      <td width="427"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50" maxlength="50" /></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="Concepto">NOMBRE CORTO: </td>
      <td><input name="corto" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $corto; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><div align="right">
        <input name="button2" type="button" class="boton" onclick="if(valida('frm'))this.form.submit()" value="Registrar" />
      </div></td>
    </tr>
  </table>
</form>
</body>
</html>
