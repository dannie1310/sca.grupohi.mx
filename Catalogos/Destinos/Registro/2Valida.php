<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php
include("../../../inc/php/conexiones/SCA.php");

$descripcion=strtoupper(trim($_REQUEST[descripcion]));

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

 $sql="SELECT * FROM tiros where IdProyecto=".$IdProyecto." and ".$like.";";
$link=SCA::getConexion();
$link->consultar($sql);
//echo $sql;
$cantidad=$link->affected();
//echo $cantidad;
 ?>
<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Destinos </td>
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

 <table width="464" border="0" align="center">
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="56" class="EncabezadoTabla">CLAVE</td>
    <td width="487" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="70" class="EncabezadoTabla">ESTATUS</td>
   </tr>
 
  <?php
 $sql="SELECT * FROM tiros where IdProyecto=$IdProyecto and $like;";

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
  <td width="56">
    <div align="center"><?php echo $row[Clave].$row[IdTiro];   ?></div></td>
    <td width="487"><?php echo $row[Descripcion]; ?></td>
    <td>
      <div align="center"><?php echo $Estatus; ?></div></td>
   </tr>
  <?php $pr++; }?>
</table>
 <table width="845" border="0" align="center">
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
<table width="573" border="0" align="center">
  <tr>
    <td width="102">&nbsp;</td>
    <td width="276">&nbsp;</td>
    <td width="101">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto">DESCRIPCI&Oacute;N:</td>
    <td class="Item1">&nbsp;<?PHP echo $descripcion; ?></td>
    
    <form action="Inicio.php" method="post"><input name="descripcion" type="hidden" value="<?php echo $descripcion; ?>"><td width="101"><input name="flag" type="hidden" value="1"><input name="Submit" type="submit" class="boton" value="Modificar"></td></form>
   <form action="3Registra.php" method="post"><input name="descripcion" type="hidden" value="<?php echo $descripcion; ?>"><td width="76"><input name="Submit2" type="submit" class="boton" value="Registrar"></td></form>
  </tr>
</table>
</body>
</html>
