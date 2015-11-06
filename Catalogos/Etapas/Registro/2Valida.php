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
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Etapas.gif" width="16" height="16" />SCA.- Registro de Etapas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>

<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");

$descripcion=strtoupper(trim($_REQUEST[descripcion]));
$link=SCA::getConexion();
//echo $descripcion;
$partesdes=explode(" ",$descripcion);
$how=sizeof($partesdes);
//echo $how;
$equal="Select * from etapasproyectos where Descripcion='".$descripcion."'  ";
	
	$link->consultar($equal);
	$eq=$link->affected();
	//echo $eq;
if($eq>0)
{
?>


<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">YA EXISTE UNA ETAPA CON ESA DESCRIPCIÓN </td>
  </tr>
</table>

 <table width="333" border="0" align="center">
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="78" colspan="2" class="EncabezadoTabla">ESTATUS</td>
   </tr>
 
  <?php
 

	//echo $sql;
  
  
  if($estatus==0)
  $Estatus="INACTIVO";
  else 
  if($estatus==1)
  $Estatus="ACTIVO";
   ?>
    <tr class="Item1">
  <td colspan="3" align="center"><?php echo $descripcion; ?></td>
    <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td width="21">&nbsp;</td>
      <td width="133">&nbsp;</td>
      <td width="83">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
<table width="333" align="center">

<tr>
      <td width="140">&nbsp;</td>
      <td width="140">&nbsp;</td>
      <td width="116">&nbsp;</td>
      <td width="98" align="right">&nbsp;</td>
      <td width="181" align="right"><input name="Submit22" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
  </tr>
</table>
<?php } else {


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

 $sql="SELECT *,case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate FROM etapasproyectos where  $like;";
  // echo $sql;
$ro=$link->consultar($sql);
$cuantos=$link->affected();
if($cuantos>0) {
 ?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE LA ETAPA QUE DESEA REGISTRAR NO HAYA SIDO REGISTRADO CON ANTERIORIDAD </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="333" border="0" align="center">
  <tr>
    <th width="241" class="EncabezadoTabla" scope="col">ETAPA</th>
    <th width="76" class="EncabezadoTabla" scope="col">ESTATUS</th>
  </tr>
  <?php 
  $pr=1;
  while($v=mysql_fetch_array($ro))
  {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td height="22"><?php echo $v[Descripcion]; ?></td>
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
    <td class="Subtitulo">SI LA ETAPA QUE DESEA REGISTRAR NO COINCIDE CON ALGUNA DE LAS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="242" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">ETAPA</th>
  </tr>
 
  <tr>
    <td height="22" class="Item1"><?php echo $descripcion; ?></td>
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
      <input type="hidden" name="flag" value="1" />
      <input name="Submit" type="submit" class="boton" value="Modificar" />
    </div></td></form>
	
	<form action="3Registra.php" name="frm" method="post">
    <td width="107"><div align="right">
	 <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
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
    <th class="EncabezadoTabla" scope="col">ETAPA</th>
  </tr>
 
  <tr>
    <td height="22" class="Item1"><?php echo $descripcion; ?></td>
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
      <input type="hidden" name="flag" value="1" />
      <input name="Submit" type="submit" class="boton" value="Modificar" />
    </div></td></form>
	
	<form action="3Registra.php" name="frm" method="post">
    <td width="106"><div align="right">
      <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
      <input name="Submit2" type="submit" class="boton" value="Registrar" />
    </div></td></form>
  </tr>
</table>
<?php
} }?>
</body>
</html>
