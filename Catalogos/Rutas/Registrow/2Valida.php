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
<body>
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
	$origen=$_REQUEST[origenes];
	$tiro=$_REQUEST[tiros];
	$primer=$_REQUEST[primerkm];
	$subsecuentes=$_REQUEST[subsecuentes];
	$adicionales=$_REQUEST[adicionales];
	
	
	$total= str_replace(",","",$_REQUEST[total]);
	//echo $total;
	$link=SCA::getConexion();
	$sql="select * from rutas where IdProyecto=$IdProyecto and IdOrigen=$origen and IdTiro=$tiro and PrimerKm=$primer and KmSubsecuentes=$subsecuentes and KmAdicionales=$adicionales and TotalKm=$total";
	//echo $sql;
	$r=$link->consultar($sql);
	$h=$link->affected();
	if($h>=1)
	{?>
	
	<table width="845" border="0" align="center">
      <tr>
        <td class="Subtitulo">ACTUALMENTE EXISTEN RUTAS REGISTRADAS CON LOS DATOS QUE DESEA </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	<table width="845" border="0" align="center">
      <tr>
        <td width="95">&nbsp;</td>
        <td width="96">&nbsp;</td>
        <td width="121">&nbsp;</td>
        <td colspan="4" class="EncabezadoTabla" rowspan="2">DISTANCIA</td>
      </tr>
      <tr>
        <td width="95" rowspan="2">&nbsp;</td>
        <td width="96" rowspan="2">&nbsp;</td>
        <td width="121" rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td width="69" class="EncabezadoTabla">&nbsp;</td>
        <td width="155" class="EncabezadoTabla">KM'S </td>
        <td width="130" class="EncabezadoTabla">KM'S </td>
        <td width="151" class="EncabezadoTabla">&nbsp;</td>
      </tr>
      <tr>
        <td width="95" class="EncabezadoTabla">RUTA</td>
        <td width="96" class="EncabezadoTabla">ORIGEN</td>
        <td width="121" class="EncabezadoTabla">TI
          
          RO
          <input type="text" name="subtotal" style="display:none" />
        </td>
        <td width="69" class="EncabezadoTabla">1er KM. </td>
        <td width="155" class="EncabezadoTabla">SUBSECUENTES </td>
        <td class="EncabezadoTabla">ADICIONALES </td>
        <td width="151" class="EncabezadoTabla">TOTAL</td>
      </tr>
	  <?php
	  $pr=1;
	while($var=mysql_fetch_array($r))
	{
	
?>
      <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
        
        <td><div align="center"><?php echo $var[Clave].$var[IdRuta]; ?></div></td>
		<td><div align="center">
            <?php regresa(origenes,Descripcion,IdOrigen,$var[IdOrigen]); ?>
        </div></td>
        <td><div align="center">
            <?php regresa(tiros,Descripcion,IdTiro,$var[IdTiro]); ?>
        </div></td>
        <td><div align="center">
		<?php echo $var[PrimerKm]; ?>
            
        </div></td>
        <td><div align="center">
           <?php echo number_format($var[KmSubsecuentes],0,".",","); ?>
        </div></td>
        <td><div align="center">
            <?php echo number_format($var[KmAdicionales],0,".",","); ?>
        </div></td>
        <td><div align="center">
             <?php echo number_format($var[TotalKM],0,".",","); ?>
        </div></td>
      </tr>
	  <?PHP $pr++;}?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
	<table width="845" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">SI DESEA CONTINUAR, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm" action="3Registra.php" method="post">

<table width="845" border="0" align="center">
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
    <td width="130" class="EncabezadoTabla">KM'S  </td>
    <td width="151" class="EncabezadoTabla">&nbsp;</td>
  </tr>
  <tr>
    <td width="193" class="EncabezadoTabla">ORIGEN</td>
    <td width="121" class="EncabezadoTabla">TIRO
        <input type="text" name="subtotal2" style="display:none" />
    </td>
    <td width="69" class="EncabezadoTabla">1er KM. </td>
    <td class="EncabezadoTabla">SUBSECUENTES </td>
    <td width="130" class="EncabezadoTabla">ADICIONALES</td>
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
    <td><div align="right">
      <input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
      <input name="Submit" type="submit" class="boton" value="Registrar" />
    </div></td>
  </tr>
</table>
</form>
<?php } else { ?>
<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm" action="3Registra.php" method="post">

<table width="845" border="0" align="center">
  <tr>
    <td width="193"><div align="center"></div></td>
    <td width="121"><div align="center"></div></td>
    <td colspan="4" class="EncabezadoTabla">DISTANCIA</td>
  </tr>
  <tr>
    <td width="193">&nbsp;</td>
    <td width="121">&nbsp;</td>
    <td width="69" class="EncabezadoTabla">&nbsp;</td>
    <td width="155" class="EncabezadoTabla">KM'S  </td>
    <td width="130" class="EncabezadoTabla">KM'S </td>
    <td width="151" class="EncabezadoTabla">&nbsp;</td>
  </tr>
  <tr>
    <td width="193" class="EncabezadoTabla">ORIGEN</td>
    <td width="121" class="EncabezadoTabla">TIRO </td>
    <td width="69" class="EncabezadoTabla">1er KM. </td>
    <td width="155" class="EncabezadoTabla">SUBSECUENTES</td>
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
    <td><div align="right">
      <input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" />
    </div></td>
    <td><div align="right">
      <input name="Submit" type="submit" class="boton" value="Registrar" />
    </div></td>
  </tr>
</table>
</form>
<?php } ?>
</body>
</html>
