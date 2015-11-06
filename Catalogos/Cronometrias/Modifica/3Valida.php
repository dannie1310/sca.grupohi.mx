<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<body>
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$minimo=$_REQUEST[minimo];
	$tolerancia=$_REQUEST[tolerancia];
	$estatus=$_REQUEST[estatus];
	$cronometria=$_REQUEST[cronometria];
	$ruta=$_REQUEST[ruta];
	$proyecto=$_REQUEST[proyecto];
	$link=SCA::getConexion();
	$valida="select *, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate from cronometrias where IdRuta=$ruta and Estatus=1 and IdCronometria!=$cronometria";
	$r=$link->consultar($valida);
	$v=mysql_fetch_array($r);
	$ho=$link->affected();
	if($ho>0)
	{
	?>
						
							<table width="845" align="center" border="0">
							  <tr>
								<td class="Subtitulo">YA EXISTE UNA CRONOMETRIA ACTIVA ASOCIADA A LA RUTA <?PHP echo $ruta; ?></td>
							  </tr>
							</table>
							
							 <table width="400" border="0" align="center">
							   <tr>
								<td colspan="5">&nbsp;</td>
							  </tr>
							  <tr>
								<td width="60" class="EncabezadoTabla">ID RUTA </td>
								<td class="EncabezadoTabla">TIEMPO M&Iacute;NIMO </td>
								<td class="EncabezadoTabla">TOLERANCIA</td>
								<td width="71" colspan="2" class="EncabezadoTabla">ESTATUS</td>
							   </tr>
							 
							  <?php
							 
							
								//echo $sql;
							  
							  
							
							   ?>
								<tr class="Item1">
							  <td width="67" align="center"><?php echo $v[IdRuta];   ?></td>
								<td align="right"><?php echo  $v[TiempoMinimo];?></td>
								<td align="right"><?php echo $v[Tolerancia]; ?></td>
								<td colspan="2" align="center"><?php echo $v[Estate]; ?></td>
							   </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td width="118">&nbsp;</td>
								  <td width="126">&nbsp;</td>
								  <td colspan="2">&nbsp;</td>
								</tr>
</table>
							<table width="400" align="center">
							
							<tr>
								  <td width="111">&nbsp;</td>
								  <td width="111">&nbsp;</td>
								  <td width="93">&nbsp;</td>
								  <td width="118" align="right">&nbsp;</td>
								  <form action="4Modifica.php" method="post" name="frm">
								  <td width="143" align="right"><input name="Submit22" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
								 </form>
							  </tr>
</table>
			
<?php }  else {?>

						
							<table width="845" align="center" border="0">
							  <tr>
								<td class="Subtitulo">VERIFIQUE SI SON CORRECTOS LOS DATOS A REGISTRAR </td>
							  </tr>
							</table>
							
							 <table width="400" border="0" align="center">
							   <tr>
								<td colspan="5">&nbsp;</td>
							  </tr>
							  <tr>
								<td width="60" class="EncabezadoTabla">ID RUTA </td>
								<td class="EncabezadoTabla">TIEMPO M&Iacute;NIMO </td>
								<td class="EncabezadoTabla">TOLERANCIA</td>
								<td width="71" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
							  <td width="67" align="center"><?php echo $ruta;   ?></td>
								<td align="right"><?php echo $minimo; ?></td>
								<td align="right"><?php echo $tolerancia; ?></td>
								<td colspan="2" align="center"><?php echo $Estatus; ?></td>
							   </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td width="118">&nbsp;</td>
								  <td width="126">&nbsp;</td>
								  <td colspan="2">&nbsp;</td>
								</tr>
</table>
							<table width="400" align="center">
							
							<tr>
								  <td width="111">&nbsp;</td>
								  <td width="111">&nbsp;</td>
								  <td width="93">&nbsp;</td>
								  <td width="118" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
								 <form action="4Modifica.php" method="post" name="frm">
								  <td width="143" align="right">
								  	  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
									  <input type="hidden" name="cronometria" value="<?php echo $cronometria; ?>" />
									  <input type="hidden" name="ruta" value="<?php echo $ruta; ?>" />
								      <input type="hidden" name="minimo" value="<?php echo $minimo; ?>" />
									  <input type="hidden" name="tolerancia" value="<?php echo $tolerancia; ?>" />
									  <input name="Submit" type="submit" class="boton" value="Modificar">
								  </td>
									
								 </form>
							  </tr>
							
</table>
<?php }  ?>
</body>
</html>
