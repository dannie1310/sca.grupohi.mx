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
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script src="../../../Clases/Js/Cajas.js" >
</script>
<script>
function valida()
{

	if(document.frm.razonSocial.value=="")
	{
		alert("INDIQUE LA DESCRIPCIÓN DE LA EMPRESA");
		document.frm.razonSocial.focus();
		return false;
	}
	else
	if(document.frm.RFC.value=="")
	{
		alert("INDIQUE EL RFC DE LA EMPRESA");
		document.frm.RFC.focus();
		return false;
	}
	return true;
}
</script>
<?php
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$empresa=$_REQUEST[empresa];

$link=SCA::getConexion();

 ?>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="600" class="EncabezadoPagina"><img src="../../../Imgs/16-Sindicatos.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Empresas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form action="3Valida.php" method="post" name="frm">
<table width="845" align="center" border="0">
  <tr >
    <td class="Subtitulo">DATOS DE LA EMPRESA SELECCIONADO </td>
  </tr>
</table>

<table width="580" border="0" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="EncabezadoTabla">#</td>
    <td width="260" class="EncabezadoTabla">Raz&oacute;n Social </td>
    <td width="135" class="EncabezadoTabla">RFC </td>
    <td width="82" class="EncabezadoTabla">Estatus</td>
  </tr>
  <?php
 $sql="SELECT * FROM empresas where Idempresa=".$empresa." ;";

	//echo $sql;
  $result=$link->consultar($sql);
 $row=mysql_fetch_array($result);
  
  
   ?>
  <tr>
    <td colspan="2"> <div align="center" class="texto"><?php echo $row[idEmpresa];   ?></div></td>
    <td width="260"><input name="razonSocial" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  value="<?php echo $row[razonSocial]; ?>" size="50" maxlength="50"></td>
    <td width="135"><input name="RFC" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  value="<?php echo $row[RFC]; ?>" size="25" maxlength="25"></td>
    <td width="82"><div align="center">
      <select name="estatus">
            <option value="0" <?PHP if($row[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
            <option value="1" <?PHP if($row[Estatus]==1) echo "selected"; ?>>ACTIVO</option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td width="61">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right">
        <input name="Submit2" type="button" class="boton" onClick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
      <input type="hidden" name="empresa" value="<?php echo $empresa; ?>">
      <input name="Submit" type="button" class="boton" onClick="if(valida())document.frm.submit()" value="Modificar">
    </div></td>
  </tr>
</table>
</form>

</body>
</html>
