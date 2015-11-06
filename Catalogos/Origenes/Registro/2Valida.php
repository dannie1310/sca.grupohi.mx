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
<?php
include("../../../inc/php/conexiones/SCA.php");


$descripcion=strtoupper(trim($_REQUEST[descripcion]));
$tipo=$_REQUEST[tiposorigenes];
//echo $descripcion;
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

 $sql="SELECT * FROM origenes where IdProyecto=$IdProyecto and $like;";
$link=SCA::getConexion();
$link->consultar($sql);
//echo $sql;
$cantidad=$link->affected();
//echo $cantidad;
 ?>
<body>
<table align="center" width="845" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;SCA.- Registro de Origenes </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
if($cantidad>=1){
 ?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE EL ORIGEN QUE DESEA REGISTRAR NO HAYA SIDO REGISTRADO PREVIAMENTE: </td>
  </tr>
</table>

 <table width="492" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="65" class="EncabezadoTabla">CLAVE</td>
    <td width="332" class="EncabezadoTabla">DESCRIPCION</td>
    <td width="81" class="EncabezadoTabla">ESTATUS</td>
   
  </tr>
 
  <?php
 $sql="SELECT * FROM origenes where IdProyecto=$IdProyecto and $like;";

	//echo $sql;
  $result=$link->consultar($sql);
  $pr=1;
  while($row=mysql_fetch_array($result))
  {
  
  if($row[Estatus]==0)
  $Estatus="INACTIVO";
  else 
  if($row[Estatus]==1)
  $Estatus="ACTIVO";
   ?>
    <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
  <td width="65">
    <div align="center"><?php echo $row[Clave].$row[IdOrigen];   ?></div></td>
    <td width="332"><?php echo $row[Descripcion]; ?></td>
    <td width="81">
      <div align="center"><?php echo $Estatus; ?></div></td>
   
  </tr>
  <?php $pr++;}?>
</table><table width="845" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="Subtitulo">SI EL ORIGEN QUE DESEA REGISTRAR, NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA. </td>
  </tr>
</table>
<?php
}
if($cantidad<1)
{
 ?>
<table width="845" border="0" align="center">
<tr>
    <td class="Subtitulo" >VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA. </td>
  </tr>
</table>
<?php
}

 ?>
<table width="700" border="0" align="center">
  <tr>
    <td width="90">&nbsp;</td>
    <td width="198">&nbsp;</td>
    <td width="41">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto">DESCRIPCION:</td>
    <td class="Item1">&nbsp;<?PHP echo $descripcion; ?></td>
    <td class="Concepto">TIPO:</td>
    <td width="166" class="Item1"><?PHP 
	 $sql="select descripcion from tiposorigenes where  IdTipoOrigen=$tipo";
	$result=$link->consultar($sql);
	$var=mysql_fetch_array($result);
	$destipo=$var[descripcion];
	echo $destipo; ?></td>
    <form action="1Inicio.php" method="post"><input name="descripcion" type="hidden" value="<?php echo $descripcion; ?>"><input name="tipo" type="hidden" value="<?php echo $tipo; ?>"><td width="101"><input name="flag" type="hidden" value="1"><input name="Submit" type="submit" class="boton" value="Modificar"></td></form>
   <form action="3Registra.php" method="post"><input name="descripcion" type="hidden" value="<?php echo $descripcion; ?>"><input name="tipo" type="hidden" value="<?php echo $tipo; ?>"><td width="78"><input name="Submit2" type="submit" class="boton" value="Registrar"></td></form>
  </tr>
</table>
</body>
</html>
