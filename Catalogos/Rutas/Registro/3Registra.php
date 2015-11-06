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
<script src="../../../Clases/Js/NoClick.js">
</script>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="845" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16" />&nbsp;SCA.- Registro de Rutas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	
	$origen=$_REQUEST[origen];
	$tiro=$_REQUEST[tiro];
	$primer=$_REQUEST[primer];
	$subsecuentes=$_REQUEST[subsecuentes];
	$adicionales=$_REQUEST[adicionales];
	//echo $adicionales;
	$total=$_REQUEST[total];
		$registro=date("Y-m-d");
	$hora=date("H:i:s");
	$link=SCA::getConexion();
	$sql="insert into rutas(HoraAlta,FechaAlta,IdProyecto,IdOrigen, IdTiro, PrimerKm, KmSubsecuentes, KmAdicionales,TotalKM)
	values('$hora','$registro',$IdProyecto,$origen,$tiro,$primer,$subsecuentes,$adicionales,$total)";
	//echo $sql;
	$r=$link->consultar($sql);
	$h=$link->affected();
	if($h==1)
	{?>
	<form action="1Inicio.php" method="post" name="frm">
	<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">LA RUTA FUE REGISTRADA CON &Eacute;XITO </td>
  </tr>
</table>
	<table width="845" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="193">&nbsp;</td>
    <td width="121">&nbsp;</td>
    <td colspan="4" class="EncabezadoTabla">DISTANCIA</td>
  </tr>
  <tr>
    <td width="193">&nbsp;</td>
    <td width="121">&nbsp;</td>
    <td width="69" class="EncabezadoTabla">&nbsp;</td>
    <td width="155" class="EncabezadoTabla">KM'S </td>
    <td width="130" class="EncabezadoTabla">KM'S </td>
    <td width="151" class="EncabezadoTabla">&nbsp;</td>
  </tr>
  <tr>
    <td width="193" class="EncabezadoTabla">ORIGEN</td>
    <td width="121" class="EncabezadoTabla">TI
        
      RO
        <input type="text" name="subtotal2" style="display:none" />
    </td>
    <td width="69" class="EncabezadoTabla">1er KM. </td>
    <td width="155" class="EncabezadoTabla">SUBSECUENTES </td>
    <td class="EncabezadoTabla">ADICIONALES </td>
    <td width="151" class="EncabezadoTabla">TOTAL</td>
  </tr>
 
  <tr class="Item1">
    <td><div align="center"><?php echo regresa(origenes,Descripcion,IdOrigen,$origen); ?>
      <input type="hidden" name="origen" value="<?php echo $origen; ?>" />
    </div></td>
    <td><div align="center">
      <?php echo regresa(tiros,Descripcion,IdTiro,$tiro); ?>
      <input type="hidden" name="tiro" value="<?php echo $tiro; ?>"  />
    </div></td>
    <td><div align="center">
     <?php echo $primer; ?>
     <input type="hidden" name="primer" value="<?php echo $primer; ?>"  />
    </div></td>
    <td><div align="center">
     <?php echo number_format($subsecuentes,0,".",","); ?>
     <input type="hidden" name="subsecuentes" value="<?php echo $subsecuentes; ?>"  />
    </div></td>
    <td><div align="center">
     <?php echo number_format($adicionales,0,".",","); ?>
     <input type="hidden" name="adicionales" value="<?php echo $adicionales; ?>"  />
    </div></td>
    <td><div align="center">
      <?php echo number_format($total,0,".",","); ?>
      <input type="hidden" name="total" value="<?php echo $total; ?>"  />
    </div></td>
  </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="right"></div></td>
    <td><div align="right">
      <input name="Submit" type="submit" class="boton" value="Registrar Otras Rutas" />
    </div></td>
  </tr>
</table>
</form>
	<?php } else {?>
	<table width="845" border="0" align="center">
  <tr>
    <td><div align="center" class="Subtitulo">LA RUTA NO PUDO SER REGISTRADA, INTENTELO NUEVAMENTE </div></td>
    </tr>
</table>

	<?php }?>
</body>
</html>
