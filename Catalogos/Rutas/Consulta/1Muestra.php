<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
session_start();
	$IdProyecto=$_SESSION['Proyecto'];
 ?>
 <script src="../../../Clases/Js/NoClick.js">
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center" width="845" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16" />&nbsp;SCA.- Consulta de Rutas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
?>
<table width="845" border="0" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="119">&nbsp;</td>
    <td colspan="4" align="center" class="EncabezadoTabla">DISTANCIA</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="119">&nbsp;</td>
    <td width="32" align="center" class="EncabezadoTabla">1er</td>
    <td width="89" align="center" class="EncabezadoTabla">KM'S</td>
    <td width="74" align="center" class="EncabezadoTabla">KM'S</td>
    <td width="106" class="EncabezadoTabla">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <?PHP 
  $opc=$_REQUEST[opc];
  if($opc=="")
  {$opc=0;}
 
  switch($opc)
  {
	  case 0:
		$or="rutas.IdRuta asc";
	  break;
	  case 1:
		$or="rutas.IdRuta desc";
	  break;
	  
	   case 2:
		$or="origenes.Descripcion asc";
	  break;
	  case 3:
		$or="origenes.Descripcion desc";
	  break;
	  
	   case 4:
		$or="tiros.Descripcion asc";
	  break;
	  case 5:
		$or="tiros.Descripcion desc";
	  break;
	  
	   case 6:
		$or="rutas.TotalKM asc";
	  break;
	  case 7:
		$or="rutas.TotalKM desc";
	  break;
	  
	   case 8:
		$or="rutas.Estatus asc";
	  break;
	  case 9:
		$or="rutas.Estatus desc";
	  break;
	  
  }?>
    <td width="37" align="center" class="EncabezadoTabla"><a href="1Muestra.php?opc=<?php if ($opc==0) echo "1"; ?>">
      
      &nbsp;RUTA </a></td>
    <td width="118" align="center" class="EncabezadoTabla"><a href="1Muestra.php?opc=<?php if ($opc==2) echo "3"; else echo "2"; ?>" >
      
      &nbsp;ORIGEN </a></td>
    <td width="119" align="center" class="EncabezadoTabla"><a href="1Muestra.php?opc=<?php if ($opc==4) echo "5"; else echo "4"; ?>">
      
      &nbsp;TIRO </a></td>
    <td width="32" align="center" class="EncabezadoTabla">KM.</td>
    <td align="center" class="EncabezadoTabla">SUBSECUENTES</td>
    <td width="74" align="center" class="EncabezadoTabla">ADICIONALES</td>
    <td width="106" align="center" class="EncabezadoTabla"><a href="1Muestra.php?opc=<?php if ($opc==6) echo "7"; else echo "6"; ?>">&nbsp;TOTAL </a></td>
    <td width="107" align="center"class="EncabezadoTabla"><a href="1Muestra.php?opc=<?php if ($opc==8) echo "9"; else echo "8"; ?>">&nbsp;ESTATUS </a></td>
    <td width="125"class="EncabezadoTabla">CRONOMETR&Iacute;A</td>
  </tr>
  

  <?php
  $link=SCA::getConexion();
  $sql="
  select 
  	* 
 from 
 	
  	origenes,
	tiros,
	rutas 
  
  where rutas.IdProyecto=$IdProyecto and 
  	rutas.IdOrigen=origenes.IdOrigen and
	rutas.IdTiro=tiros.IdTiro 
 	order by $or;";
 // echo $sql;
  $r=$link->consultar($sql);
   $link->cerrar();
  while($v=mysql_fetch_array($r))
  {
   if($v[Estatus]==0)
   $Estatus="INACTIVO";
   else
    if($v[Estatus]==1)
   $Estatus="ACTIVO";
  ?>
 
  <tr>
    <td align="center" class="Item1"><?php echo $v[Clave].$v[IdRuta]; ?></div></td>
    <td align="center" class="Item1"><?php echo regresa(origenes,Descripcion,IdOrigen,$v[IdOrigen]); ?></div></td>
    <td align="center" class="Item1"><?php echo regresa(tiros,Descripcion,IdTiro,$v[IdTiro]); ?></div></td>
    <td align="center" class="Item1"><?php echo $v[PrimerKm]; ?></div></td>
    <td align="center" class="Item1"><?php echo  $v[KmSubsecuentes];?></div></td>
    <td align="center" class="Item1"><?php echo  $v[KmAdicionales]; ?></div></td>
    <td align="center" class="Item1"><?php echo  $v[TotalKM]; ?></div></td>
    <td align="center" class="Item1"><?php echo  $Estatus; ?></div></td>
	<?php 
	 $linkc=SCA::getConexion();
	$sqlc="select * from cronometrias where  idruta=$v[IdRuta]";
	$linkc->consultar($sqlc);
	$c=$linkc->affected();
	 $linkc->cerrar();
	?>
    <form action="../../Cronometrias/Consulta/1Muestra.php" name="frm" method="post">
	<td class="Item1" align="center"><input name="Submit" type="submit" class="boton" value="Consultar" <?php if($c==0)echo "disabled"; ?> />
    <input type="hidden" name="ruta" value="<?php echo $v[IdRuta]; ?>" />
	 <input type="hidden" name="opc" value="<?php echo $opc; ?>" /></td>
	</form>
  </tr>
   <?PHP }?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>

