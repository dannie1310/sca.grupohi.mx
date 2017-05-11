<?php
	session_start();
        if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }
	
	//onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'"

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#frm1 #agrega1 tr .Concepto {
	text-align: center;
}
#frm #agrega2 tr .Concepto {
	text-align: center;
}
#frm #agrega {
	text-align: center;
}
-->
</style>
</head>
<?php if($_SESSION[IdUsuario]!=2){?>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php }?>
<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;SCA.- Registro de Materiales </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<script>
function valida(id)
{
 if (!document.getElementById) return false;
  
  formulario = document.getElementById(id);
  if(formulario.descripcion.value=='')
  {
	  alert("INDIQUE LA DESCRIPCIÓN DEL MATERIAL");
	  formulario.descripcion.focus();
	  return false;
  }
  else
  if(formulario.fda.value=='')
  {
	  alert("INDIQUE EL FACTOR DE ABUNDAMIENTO");
	  formulario.fda.focus();
	  return false;
  }
  else
  return true;

}
</script>
<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/FactorAbundamiento.php");
	//////////////////////////
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
	
	$flag=$_REQUEST[flag];
	$descripcion=$_REQUEST[descripcion];
	$fda=$_REQUEST[fda];
	$link=SCA::getConexion();
	$sql="Select *, case Estatus
	when 0 then 'INACTIVO'
	when 1 then 'ACTIVO'
	end Estate From materiales";
	$ro=$link->consultar($sql);
	
	?>
<form action="2Valida.php" method="post" name="frm1" id="frm1">
  <table width="500" border="0" align="center">
    <tr>
      <td width="103">&nbsp;</td>
      <td width="572">&nbsp;</td>
      <td width="75">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega1')"><span class="texto"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'"  align="absmiddle" width="16" height="16" /></span> Agregar </td>
    </tr>
  </table>
  <table width="400" id="agrega1"  align="center"  <?php if($flag=='') { ?> style="display:none"  <?php } ?> >
    <tr>
      <td>&nbsp;</td>
      <td align="center" class="Concepto">DESCRIPCI&Oacute;N</td>
      <td align="center" class="Concepto">FdA</td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td width="16">&nbsp;</td>
      <td width="260"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50" /></td>
      <td width="178" align="center"><label>
        <input name="fda" type="text" class="text" id="textfield" size="5" maxlength="5" value="<?php if($flag==1) echo $fda; ?>" onkeypress="withoutSpaces(event,'decOK'), onlyDigits(event,'decOK')" />
      </label></td>
      <td width="26">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><input name="button" type="button" class="boton" onclick="if(valida('frm1'))this.form.submit()" value="Registrar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<table width="320" border="0" align="center">
 <tr>
    <th width="177" class="EncabezadoTabla" scope="col">MATERIAL</th>
    <th width="40" class="EncabezadoTabla" scope="col">FdA </th>
    <th width="89" class="EncabezadoTabla" scope="col">ESTATUS</th>
 </tr>
  <?php 
  $pr=1;
  while($v=mysql_fetch_array($ro))
  {?>

  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[Descripcion]; ?></td>
    <td align="right"><?php echo regresa_factor($v[IdMaterial]); ?></td>
    <td>
    <div align="center"><?php echo $v[Estate]; ?></div></td>
  </tr>
  <?php $pr++; } ?>
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
      <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega')"><span class="texto"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16" /></span> Agregar </td>
    </tr>
  </table>
  <table width="400" id="agrega"  align="center"  <?php if($flag=='') { ?> style="display:none"   <?php } ?> >
    <tr>
      <td>&nbsp;</td>
      <td align="center" class="Concepto"><div align="center">DESCRIPCI&Oacute;N</div></td>
      <td align="center" class="Concepto"><div align="center">FdA</div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="11">&nbsp;</td>
      <td width="266"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50" /></td>
      <td width="90" align="center"><label>
        <input name="fda" type="text" class="text" id="textfield2" size="5" maxlength="5" value="<?php if($flag==1) echo $fda; ?>" />
      </label></td>
      <td width="13">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><input name="button2" type="button" class="boton" onclick="if(valida('frm'))this.form.submit()" value="Registrar" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
