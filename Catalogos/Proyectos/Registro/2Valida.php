<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Proyectos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Proyectos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
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
				$like=$like."descripcion like '%$partesdes[$i]%' or";
			}
	}
}

for($i=0;$i<$howc;$i++)
{	
	if($partescor[$i]!="")
	{
	
		if($i<($howc-1))
			{
				$like=$like." NombreCorto like '%$partescor[$i]%' or ";
			}
		else
			{
				$like=$like." NombreCorto like '%$partescor[$i]%'";
			}
	}
}


 $sql="SELECT * FROM proyectos where IdProyecto=$IdProyecto and $like;";
 //echo $sql;
$link=SCA::getConexion();
$link->consultar($sql);
//echo $sql;
$cantidad=$link->affected();
//echo $cantidad;
if($cantidad>0)
{
?>


<table width="600" border="0" align="center">
  <tr>
    <td><div align="center" class="Subtitulo">EXISTEN PROYECTOS QUE COINCIDEN CON EL QUE DESEA REGISTRAR </div></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="96" class="EncabezadoTabla">ID PROYECTO </td>
    <td width="249" class="EncabezadoTabla">DESCRIPCI&Oacute;N </td>
    <td class="EncabezadoTabla">NOMBRE CORTO </td>
    <td class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?PHP 
  $sql="
  	SELECT *, 
  		case Estatus 
			when 0 then 'INACTIVO'
			when 1 then 'ACTIVO'
			end Estate
   FROM 
   		proyectos 
	where 
		IdProyecto=$IdProyecto and $like;";

$r=$link->consultar($sql);
$pr=1;
while($v=mysql_fetch_array($r))
  {
   
  
  ?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td>
    <div align="center"><?PHP 
   echo $v[IdProyecto];?></div></td>
    <td><?PHP 
   echo $v[Descripcion];?></td>
    <td><?PHP 
   echo $v[NombreCorto];?>    </td>
    <td>
    <div align="center"><?PHP 
   echo $v[Estate];?></div></td>
  </tr>
  <?PHP $pr++;}?>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="171">&nbsp;</td>
    <td width="66">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="center" class="Subtitulo">SI DESEA CONTINUAR VERIFIQUE SI SON CORRECTOS LOS DATOS A REGISTRAR </div></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="322" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td colspan="2" class="EncabezadoTabla">NOMBRE CORTO </td>
  </tr>
 
  <tr class="Item1">
    <td>      <?PHP 
   echo $descripcion;?>    </td>
    <td colspan="2">      <?PHP 
   echo $corto;?>    </td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<form action="1Inicio.php" method="post" >
    <td width="152"><div align="right">
      <input type="hidden" value=" <?PHP  echo $descripcion;?>" name="descripcion" />
      <input type="hidden" value=" <?PHP  echo $corto;?>" name="corto" />
	    <input type="hidden" value="1" name="flag" />
      <input name="Submit2" type="submit" class="boton" value="Modificar" />
    </div></td>
	</form>
	<form method="post" action="3Registra.php">
    <td width="112"><div align="right">
	 <input type="hidden" value=" <?PHP  echo $descripcion;?>" name="descripcion" />
      <input type="hidden" value=" <?PHP  echo $corto;?>" name="corto" />
      <input name="Submit" type="submit" class="boton" value="Registrar" />
    </div></td>
	</form>
  </tr>
</table>
<?php } else {?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="center" class="Subtitulo">VERIFIQUE SI SON CORRECTOS LOS DATOS A REGISTRAR </div></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="322" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td colspan="2" class="EncabezadoTabla">NOMBRE CORTO </td>
  </tr>
 
  <tr class="Item1">
    <td>      <?PHP 
   echo $descripcion;?>    </td>
    <td colspan="2">      <?PHP 
   echo $corto;?>    </td>
  </tr>
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
	<form action="1Inicio.php" method="post" >
    <td width="152"><div align="right">
      <input type="hidden" value=" <?PHP  echo $descripcion;?>" name="descripcion" />
      <input type="hidden" value=" <?PHP  echo $corto;?>" name="corto" />
	    <input type="hidden" value="1" name="flag" />
      <input name="Submit2" type="submit" class="boton" value="Modificar" />
    </div></td>
	</form>
	<form method="post" action="3Registra.php">
    <td width="112"><div align="right">
	 <input type="hidden" value=" <?PHP  echo $descripcion;?>" name="descripcion" />
      <input type="hidden" value=" <?PHP  echo $corto;?>" name="corto" />
      <input name="Submit" type="submit" class="boton" value="Registrar" />
    </div></td>
	</form>
  </tr>
</table>
<?php } ?>
</body>
</html>
