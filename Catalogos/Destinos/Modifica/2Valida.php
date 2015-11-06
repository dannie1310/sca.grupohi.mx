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

	if(document.frm.descripcion.value=="")
	{
		alert("INDIQUE LA DESCRIPCIÓN DEL TIRO");
		document.frm.descripcion.focus();
		return false;
	}
	return true;
}
</script>
<?php
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$tiro=$_REQUEST[tiro];

$link=SCA::getConexion();

 ?>
<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Destinos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form action="3Valida.php" method="post" name="frm">
<table width="845" align="center" border="0">
  <tr >
    <td class="Subtitulo">DATOS DEL TIRO SELECCIONADO </td>
  </tr>
</table>

<table width="420" border="0" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="EncabezadoTabla">CLAVE </td>
    <td width="261" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="125" class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?php
 $sql="SELECT * FROM tiros where IdProyecto=".$IdProyecto." and IdTiro=".$tiro.";";

	//echo $sql;
  $result=$link->consultar($sql);
 $row=mysql_fetch_array($result);
  
  
   ?>
  <tr>
    <td colspan="2"> <div align="center" class="texto"><?php echo $row[Clave].$row[IdTiro];   ?></div></td>
    <td width="261"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  value="<?php echo $row[Descripcion]; ?>" size="50" maxlength="50"></td>
    <td width="125"><div align="center">
      <select name="estatus">
            <option value="0" <?PHP if($row[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
            <option value="1" <?PHP if($row[Estatus]==1) echo "selected"; ?>>ACTIVO</option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td width="56">&nbsp;</td>
    <td width="139">&nbsp;</td>
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
        <input type="hidden" name="tiro" value="<?php echo $tiro; ?>">
        <input name="Submit" type="button" class="boton" onClick="if(valida())document.frm.submit()" value="Modificar">
    </div></td>
  </tr>
</table>
</form>

</body>
</html>
