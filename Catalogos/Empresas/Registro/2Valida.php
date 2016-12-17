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
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Sindicatos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Empresas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
session_start();
	$IdProyecto=$_SESSION['Proyecto'];
include("../../../inc/php/conexiones/SCA.php");
$RFC=strtoupper(trim($_REQUEST[RFC]));

$razonSocial=strtoupper(trim($_REQUEST[razonSocial]));
$link=SCA::getConexion();

$partesdes=explode(" ",$razonSocial);
$partescor=explode(" ",$RFC);
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
				$like=$like."razonSocial like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."razonSocial like '%$partesdes[$i]%' or ";
			}
	}
}

for($i=0;$i<$howc;$i++)
{	
	if($partescor[$i]!="")
	{
	
		if($i<($howc-1))
			{
				$like=$like."RFC like '%$partescor[$i]%' or ";
			}
		else
			{
				$like=$like."RFC like '%$partescor[$i]%'";
			}
	}
}


 $sql="SELECT *
 FROM empresas where $like;";
 //echo $sql;
 $ro=$link->consultar($sql);
 $exis=$link->affected();
 if($exis>0)
 {
 ?>
 <table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE LA EMPRESA QUE DESEA REGISTRAR, NO HAYA SIDO REGISTRADO PREVIAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">DESCRIPCI&Oacute;N</th>
    <th class="EncabezadoTabla" scope="col">RFC </th>
    <th class="EncabezadoTabla" scope="col">ESTATUS</th>
  </tr>
  <?php 
  $pr=1;
  while($v=mysql_fetch_array($ro))
  {?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[razonSocial]; ?></td>
    <td><?php echo $v[RFC]; ?></td>
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
     <td class="Subtitulo">SI LA EMPRESA QUE DESEA REGISTRAR, NO COINCIDE CON ALGUNA DE LAS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
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
     <th width="272" class="EncabezadoTabla" scope="col">RFC </th>
   </tr>
  
   <tr>
     <td class="Item1"><?php echo $razonSocial; ?></td>
     <td class="Item1"><?php echo $RFC; ?></td>
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
       <input type="hidden" name="razonSocial" value="<?php echo $razonSocial; ?>" />
      <input type="hidden" name="RFC" value="<?php echo $RFC; ?>" />
      <input name="Submit" type="submit" class="boton" value="Modificar"  />
    </div></td></form>
	<form action="3Registra.php" method="post" name="frm">
    <td width="128"><div align="right">
      <input type="hidden" name="razonSocial" value="<?php echo $razonSocial; ?>" />
      <input type="hidden" name="RFC" value="<?php echo $RFC; ?>" />
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
     <th width="272" class="EncabezadoTabla" scope="col">RFC </th>
   </tr>
  
   <tr class="Item1">
     <td><?php echo $razonSocial; ?></td>
     <td><?php echo $RFC; ?></td>
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
       <input type="hidden" name="razonSocial" value="<?php echo $razonSocial; ?>" />
      <input type="hidden" name="RFC" value="<?php echo $RFC; ?>" />
      <input name="Submit" type="submit" class="boton" value="Modificar"  />
    </div></td></form>
	<form action="3Registra.php" method="post" name="frm">
    <td width="128"><div align="right">
      <input type="hidden" name="razonSocial" value="<?php echo $razonSocial; ?>" />
      <input type="hidden" name="RFC" value="<?php echo $RFC; ?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar"  />
    </div></td></form>
  </tr>
</table>
</form>
<?php } ?>
</body>
</html>
