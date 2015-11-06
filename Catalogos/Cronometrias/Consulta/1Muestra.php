<?php
	session_start();
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
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Consulta de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$ruta=$_REQUEST[ruta];
$opc=$_REQUEST[opc];

?>


<table width="601" border="0" align="center">
  <tr>
    <td colspan="6" class="Subtitulo">CRONOMETR&Iacute;AS ASOCIADAS A LAS RUTA: R<?php echo  $ruta;?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="106">&nbsp;</td>
    <td width="149">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>

    <td width="49" align="center" class="EncabezadoTabla"> &nbsp;RUTA</td>
    <td width="109" align="center" class="EncabezadoTabla"> &nbsp;ORIGEN</td>
    <td width="106" align="center" class="EncabezadoTabla"> &nbsp;TIRO</td>
    <td width="149" align="center" class="EncabezadoTabla">TIEMPO M&Iacute;NIMO</td>
    <td width="71" align="center" class="EncabezadoTabla">TOLERANCIA</td>
    <td width="91" align="center" class="EncabezadoTabla">ESTATUS</td>
  </tr>
  <?php
  $link=SCA::getConexion();
  $sql="select rutas.*, cronometrias.TiempoMinimo as minimo, cronometrias.Tolerancia as tolerancia from cronometrias,rutas where IdProyecto=".$_SESSION["Proyecto"]." and rutas.IdRuta=".$ruta." and rutas.IdRuta=cronometrias.IdRuta order by IdCronometria;";
  //echo $sql;
  $r=$link->consultar($sql);
  while($v=mysql_fetch_array($r))
  {
   if($v[Estatus]==0)
   $Estatus="INACTIVO";
   else
    if($v[Estatus]==1)
   $Estatus="ACTIVO";
  ?>
  <tr>
    <td align="center" class="Item1"><?php echo $v[Clave].$v[IdRuta]; ?></td>
    <td align="center" class="Item1"><?php echo regresa(origenes,Descripcion,IdOrigen,$v[IdOrigen]); ?></td>
    <td align="center" class="Item1"><?php echo regresa(tiros,Descripcion,IdTiro,$v[IdTiro]); ?></td>
    <td align="center" class="Item1"><?php echo $v[minimo]; ?></td>
    <td align="center" class="Item1"><?php echo  $v[tolerancia];?></td>
    <td align="center" class="Item1"><?php echo  $Estatus;?></td>
    <form action="../../Cronometrias/Consulta/1Muestra.php" method="post" name="frm" id="frm">
    </form>
  </tr>
  <?PHP }?>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	 <td>&nbsp;</td>
	<form name="frm" method="post" action="../../Rutas/Consulta/1Muestra.php">
    <td align="center">
      <input type="hidden" value="<?php echo $opc; ?>" name="opc" />
      <input class="boton" type="submit" name="Submit" value="Regresar" />
    </td>
   
	</form>
  </tr>
</table>
</body>
</html>
