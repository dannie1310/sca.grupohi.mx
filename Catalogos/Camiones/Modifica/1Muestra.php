<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center" width="845" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Camiones</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="845" border="0" align="center">
  <tr>
    <td colspan="6"><div align="center" class="Titulo">CAMIONES REGISTRADOS </div></td>
  </tr>
<script>
function manda(id)
{
	/*if (!document.getElementById) return false;
	  	formulario = document.getElementById(id);
		formulario.submit();*/
		this.location.href='../modifica.php?camion='+id;
		//alert(id);
}
</script>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td onclick="manda()">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <form name="frm" action="2Detalles.php" method="post"> <td onclick="manda()"><?php echo $v[Economico]; ?></td>
    </form>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="EncabezadoTabla">CUBICACI&Oacute;N</td>
    <td class="EncabezadoTabla">CUBICACI&Oacute;N</td>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td width="98" class="EncabezadoTabla">ECONOMICO</td>
    <td width="246" class="EncabezadoTabla">PROPIETARIO</td>
    <td width="196" class="EncabezadoTabla">OPERADOR</td>
    <td width="99" class="EncabezadoTabla">REAL</td>
    <td width="99" class="EncabezadoTabla">PARA PAGO</td>
    <td width="81" class="EncabezadoTabla">ESTATUS</td>
  </tr>
    <?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$sql="
SELECT ca.IdCamion, 
    ca.Propietario, 
    ca.CubicacionReal, 
    ca.CubicacionParaPago, 
    ca.Estatus, 
    ca.Economico,
    IFNULL(op.Nombre,'---') as Nombre
FROM camiones as ca
LEFT JOIN operadores as op on ca.IdOperador = op.IdOperador
WHERE ca.IdProyecto= ". $IdProyecto ."
ORDER BY ca.Economico";
//$sql="select * from camiones where IdProyecto=$IdProyecto order by Economico";
//echo $sql;
$link=SCA::getConexion();
$r=$link->consultar($sql);
$pr=1;
while($v=mysql_fetch_array($r))
{
if($v[Estatus]==0)
  $Estatus="INACTIVO";
  else 
  if($v[Estatus]==1)
  $Estatus="ACTIVO";
?> <form name="frm" action="../modifica.php" id="<?php echo $v[IdCamion]; ?>" method="post"> 
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
  <td valign="bottom" style="cursor:hand" onclick="manda(<?php echo $v[IdCamion]; ?>)">
    <div align="center">
	<?php echo $v[Economico]; ?>
      <input type="hidden" name="camion" value="<?php echo $v[IdCamion]; ?>" />
    </div></td>
    <td valign="bottom"><?php echo $v[Propietario]; ?></td>
    <td valign="bottom"><?php echo $v[Nombre]; ?></td>
    <td>
		<table width="98">
		  <tr>
			  <td width="72" valign="bottom">
			  	<div align="right"><?php echo number_format($v[CubicacionReal],2,".",","); ?>
  	        </div></td>
			  <td width="14">m<sup>3</sup>			  </td>
		  </tr>
		 </table>
	  </td>
    <td><table width="98">
		  <tr>
			  <td width="72" valign="bottom">
		  	<div align="right"><?php echo number_format($v[CubicacionParaPago],2,".",","); ?> </div></td>
			  <td width="14">m<sup>3</sup>			  </td>
		  </tr>
		 </table></td>
    <td valign="bottom">
      <div align="center"><?php echo $Estatus; ?></div></td>
  </tr></form>
  <?php $pr++;} ?>
</table>
</body>
</html>
