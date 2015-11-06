<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script src="../../../Clases/Js/Cajas.js" >
</script>
<script>
function valida()
{

	if(document.frm.tiposorigenes.value=="A99")
	{
		alert("INDIQUE EL TIPO DE ORIGEN");
		document.frm.TiposOrigenes.focus();
		return false;
	}
	else
	if(document.frm.descripcion.value=="")
	{
		alert("INDIQUE LA DESCRIPCIÓN DEL ORIGEN");
		document.frm.descripcion.focus();
		return false;
	}
	return true;
}
</script>
<?php
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$origen=$_REQUEST[origen];

$link=SCA::getConexion();

 ?>
<body>
<table align="center" width="845" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><p><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Origenes </p>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<form action="3Valida.php" method="post" name="frm">
<table width="845" align="center" border="0">
  <tr >
    <td class="Subtitulo">DATOS DEL ORIGEN SELECCIONADO </td>
  </tr>
</table>

<table width="599" border="0" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="56" class="EncabezadoTabla">CLAVE </td>
    <td width="139" class="EncabezadoTabla">TIPO</td>
    <td width="261" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="125" class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?php
 $sql="SELECT * FROM origenes where IdProyecto=".$IdProyecto." and IdOrigen=".$origen.";";

	//echo $sql;
  $result=$link->consultar($sql);
 $row=mysql_fetch_array($result);
  
  if($row[Estatus]==0)
  $Estatus="Inactivo";
  else 
  if($row[Estatus]==1)
  $Estatus="Activo";
   ?>
  <tr>
    <td width="56"> <div align="center" class="texto"><?php echo $row[Clave].$row[IdOrigen];   ?></div></td>
    <td width="139"><?php comboSelected(tiposorigenes,Descripcion,IdTipoOrigen,$row[IdTipoOrigen]);  ?></td>
    <td width="261"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  value="<?php echo $row[Descripcion]; ?>" size="50" maxlength="50"></td>
    <td width="125"><div align="center">
      <select name="estatus">
            <option value="0" <?PHP if($row[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
            <option value="1" <?PHP if($row[Estatus]==1) echo "selected"; ?>>ACTIVO</option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right">
        <input name="Submit2" type="button" class="boton" onClick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
        <input type="hidden" name="origen" value="<?php echo $origen; ?>">
        <input name="Submit" type="button" class="boton" onClick="if(valida())document.frm.submit()" value="Modificar">
    </div></td>
    
  </tr>
</table>
</form>

</body>
</html>
