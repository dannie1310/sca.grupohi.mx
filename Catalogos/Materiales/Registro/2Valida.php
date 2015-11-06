<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>

<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;SCA.- Registro de Materiales </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/FactorAbundamiento.php");

$link=SCA::getConexion();
$descripcion=strtoupper(trim($_REQUEST[descripcion]));
$fda=$_REQUEST[fda];

$equal="select * from materiales  where Descripcion='".$descripcion."'";

$reseq=$link->consultar($equal);
$afeq=$link->affected();
//echo $afeq;
if($afeq>0)
{?>
<table width="600" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">EL MATERIAL QUE DESEA REGISTRAR YA EXISTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="242" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">MATERIAL</th>
  </tr>
  <tr>
    <td height="22" class="Item1" align="center"><?php echo $descripcion; ?></td>
  </tr>
</table>
<table width="398" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <form action="1Inicio.php" method="post" name="regresa" id="regresa">
      <td><div align="right">
        <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
        <input type="hidden" name="flag" value="1" />
        <input name="Submit" type="submit" class="boton" value="Modificar" />
      </div></td>
    </form>
    <form action="3Registra.php" method="post" name="frm" id="frm">
    </form>
  </tr>
</table>



<?php
}
else
{
$partesdes=explode(" ",$descripcion);
$how=sizeof($partesdes);
//echo $how;
$like="";
for($i=0;$i<$how;$i++)
{	
	if($partesdes[$i]!=" ")
	{
	
		if($i<($how-1))
			{
				$like=$like."descripcion like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."descripcion like '%$partesdes[$i]%'";
			}
	}
}

 $sql="SELECT *,case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate FROM materiales where  $like;";
  // echo $sql;
$ro=$link->consultar($sql);
$cuantos=$link->affected();
if($cuantos>0) {
 ?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE EL MATERIAL QUE DESEA REGISTRAR NO HAYA SIDO REGISTRADO CON ANTERIORIDAD </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="333" border="0" align="center">
  <tr>
    <th width="241" class="EncabezadoTabla" scope="col">MATERIAL</th>
    <th width="76" class="EncabezadoTabla" scope="col">ESTATUS</th>
  </tr>
  <?php 
  $pr=1;
  while($v=mysql_fetch_array($ro))
  {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td height="22" align="center"><?php echo $v[Descripcion]; ?></td>
    <td>
    <div align="center"><?php echo $v[Estate]; ?></div></td>
  </tr>
  <?php $pr++; } ?>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">SI EL MATERIAL QUE DESEA REGISTRAR NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="242" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">MATERIAL</th>
    <th class="EncabezadoTabla" scope="col">FdA</th>
  </tr>
 
  <tr>
    <td height="22" align="center" class="Item1"><?php echo $descripcion; ?></td>
    <td height="22" align="center" class="Item1"><?php echo $fda; ?>&nbsp;</td>
  </tr>
 
</table>
<table width="398" border="0" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
  <form action="1Inicio.php" method="post" name="regresa">
    <td width="297"><div align="right">
      <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="fda" value="<?php echo $fda; ?>" />
      <input type="hidden" name="flag" value="1" />
      <input name="Submit" type="submit" class="boton" value="Modificar" />
    </div></td></form>
	
	<form action="3Registra.php" name="frm" method="post">
    <td width="107"><div align="right">
	 <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />      
     <input type="hidden" name="fda" value="<?php echo $fda; ?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar" />
    </div></td></form>
  </tr>
</table>
<?php } else
{
?>
<table width="600" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="242" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">MATERIAL</th>
    <th class="EncabezadoTabla" scope="col">FdA</th>
  </tr>
 
  <tr>
    <td height="22" align="center" class="Item1"><?php echo $descripcion; ?></td>
    <td height="22" align="center" class="Item1"><?php echo $fda; ?></td>
  </tr>
 
</table>
<table width="398" border="0" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  <tr>
  <form action="1Inicio.php" method="post" name="regresa">
    <td width="282"><div align="right">
      <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="fda" value="<?php echo $fda; ?>" />
      <input type="hidden" name="flag" value="1" />
      <input name="Submit" type="submit" class="boton" value="Modificar" />
    </div></td></form>
	
	<form action="3Registra.php" name="frm" method="post">
    <td width="106"><div align="right">
      <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="fda" value="<?php echo $fda; ?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar" />
    </div></td></form>
  </tr>
</table>
<?php
} 
}?>
</body>
</html>
