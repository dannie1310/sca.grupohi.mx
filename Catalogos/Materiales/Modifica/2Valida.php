<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>
<?php if($_SESSION[IdUsuario]!=2){?>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php }?><script src="../../../Clases/Js/Cajas.js" >
</script>
<script>
function valida()
{

	if(document.frm.descripcion.value=="")
	{
		alert("INDIQUE LA DESCRIPCIÓN DEL MATERIAL");
		document.frm.descripcion.focus();
		return false;
	}else
	return true;
}
</script>
<?php
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
include("../../../Clases/Funciones/FactorAbundamiento.php");

$material=$_REQUEST[material];

$link=SCA::getConexion();

 ?>
<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Materiales </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<form action="3Valida.php" method="post" name="frm">
<table width="845" align="center" border="0">
  <tr >
    <td class="Subtitulo">DATOS DEL MATERIAL SELECCIONADO </td>
  </tr>
</table>

<table width="350" border="0" align="center">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td class="EncabezadoTabla">FdA</td>
    <td width="102" class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?php
 $sql="SELECT * FROM materiales where IdMaterial=".$material." ;";

	//echo $sql;
  $result=$link->consultar($sql);
 $row=mysql_fetch_array($result);
  
  
   ?>
  <tr>
    <td> <div align="center" class="texto">  <input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  value="<?php echo $row[Descripcion]; ?>" size="30" maxlength="50"></div></td>
    <td align="center"><label>
      <input name="fda" type="text" class="text" id="textfield" size="5" maxlength="5" value="<?php echo regresa_factor($row[IdMaterial]); ?>" onkeypress="withoutSpaces(event,'decOK'), onlyDigits(event,'decOK')">
    </label></td>
    <td width="102"><div align="center">
      <select name="estatus">
        <option value="0" <?PHP if($row[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
        <option value="1" <?PHP if($row[Estatus]==1) echo "selected"; ?>>ACTIVO</option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><div align="left">
      <input name="Submit2" type="button" class="boton" onClick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
      <input type="hidden" name="material" value="<?php echo $material; ?>">
      <input name="Submit" type="button" class="boton" onClick="if(valida())document.frm.submit()" value="Modificar">
    </div></td>
  </tr>
</table>
</form>

</body>
</html>
