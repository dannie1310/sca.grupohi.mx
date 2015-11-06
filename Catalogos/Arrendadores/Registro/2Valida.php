<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script language="javascript" src="../../../Clases/Js/NoClick.js"></script>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Sindicatos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Arrendadores </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
session_start();
	$IdProyecto=$_SESSION['Proyecto'];
include("../../../inc/php/conexiones/SCA.php");
$corto=strtoupper(trim($_REQUEST[corto]));

$descripcion=strtoupper(trim($_REQUEST[descripcion]));
$link=SCA::getConexion();

$partesdes=explode(" ",$descripcion);
$partescor=explode(" ",$corto);
$how=sizeof($partesdes);
$howc=sizeof($partescor);
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
				$like=$like."descripcion like '%$partesdes[$i]%' or ";
			}
	}
}

for($i=0;$i<$howc;$i++)
{	
	if($partescor[$i]!="")
	{
	
		if($i<($howc-1))
			{
				$like=$like."NombreCorto like '%$partescor[$i]%' or ";
			}
		else
			{
				$like=$like."NombreCorto like '%$partescor[$i]%'";
			}
	}
}


 $sql="SELECT *, case Estatus
 when 0 then 'INACTIVO'
 when 1 then 'ACTIVO'
 end Estate
 FROM maquinaria_arrendadores where $like;";
 //echo $sql;
 $ro=$link->consultar($sql);
 $exis=$link->affected();
 if($exis>0)
 {
 ?>
 <table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE EL ARRENDADOR QUE DESEA REGISTRAR, NO HAYA SIDO REGISTRADO PREVIAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
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
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[Descripcion]; ?></td>
    <td><?php echo $v[NombreCorto]; ?></td>
    <td>
    <div align="center"><?php echo $v[Estate]; ?></div></td>
  </tr>
  <?php $pr++;}?>
</table>
 <table width="600" border="0" align="center">
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td class="Subtitulo">SI EL ARRENDADOR QUE DESEA REGISTRAR NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
 </table>
 <table width="600" border="0" align="center">
   <tr>
     <th width="312" class="EncabezadoTabla" scope="col">DESCRIPCI&Oacute;N</th>
     <th width="272" class="EncabezadoTabla" scope="col">NOMBRE CORTO </th>
   </tr>
  
   <tr>
     <td class="Item1"><?php echo $descripcion; ?></td>
     <td class="Item1"><?php echo $corto; ?></td>
   </tr>
   
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="108">&nbsp;</td>
    <td width="178">&nbsp;</td>
   <form action="1Inicio.php" name="regresa" method="post"> <td width="168"><div align="right">
      <input type="hidden" name="flag" value="1" />
       <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="corto" value="<?php echo $corto; ?>" />
      <input name="Submit" type="submit" class="boton" value="Modificar"  />
    </div></td></form>
	<form action="3Registra.php" method="post" name="frm">
    <td width="128"><div align="right">
      <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="corto" value="<?php echo $corto; ?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar"  />
    </div></td></form>
  </tr>
</table>
</form>
 <?php } else { ?>
 <table width="600" border="0" align="center">
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td class="Subtitulo">VERIFIQUE QUE LOS DATOS A REGISTRAR SEAN CORRECTOS </td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
   </tr>
 </table>
 <table width="600" border="0" align="center">
   <tr>
     <th width="312" class="EncabezadoTabla" scope="col">DESCRIPCI&Oacute;N</th>
     <th width="272" class="EncabezadoTabla" scope="col">NOMBRE CORTO </th>
   </tr>
  
   <tr class="Item1">
     <td><?php echo $descripcion; ?></td>
     <td><?php echo $corto; ?></td>
   </tr>
   
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="108">&nbsp;</td>
    <td width="178">&nbsp;</td>
   <form action="1Inicio.php" name="regresa" method="post"> <td width="168"><div align="right">
      <input type="hidden" name="flag" value="1" />
       <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="corto" value="<?php echo $corto; ?>" />
      <input name="Submit" type="submit" class="boton" value="Modificar"  />
    </div></td></form>
	<form action="3Registra.php" method="post" name="frm">
    <td width="128"><div align="right">
      <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input type="hidden" name="corto" value="<?php echo $corto; ?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar"  />
    </div></td></form>
  </tr>
</table>
</form>
<?php } ?>
</body>
</html>
