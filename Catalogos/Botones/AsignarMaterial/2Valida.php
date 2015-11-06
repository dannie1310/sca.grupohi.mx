<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
	
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
	$boton=$_REQUEST[botones];
	$material=$_REQUEST[materiales];
	
	$link=SCA::getConexion();
	$vali="
	select
			b.Identificador as Boton,
			m.Descripcion as Material,
			case b.Estatus
			when 0 then 'INACTIVO'
			when 1 then 'ACTIVO'
			when 2 then 'ASIGNADO'
			when 3 then 'EXTRAVIADO'
			end Estate
		from
			materialesxboton as mxb,
			botones as b,
			materiales as m
		where
			b.IdBoton=".$boton." and
			b.IdProyecto=".$IdProyecto." and
			mxb.IdBoton=b.IdBoton and
			mxb.IdMaterial=m.IdMaterial
	";
	$t=$link->consultar($vali);
	$v=mysql_fetch_array($t);
	$pre=$link->affected();
	?>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />SCA.- Asignaci&oacute;n de Materiales por Bot&oacute;n</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?PHP if($pre>0){ ?>


<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo" >EL BOT&Oacute;N <?PHP echo $v[Identificador]; ?> ACTUALMENTE TIENE ASIGNADO EL SIGUIENTE MATERIAL:</td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="4934" colspan="3" >&nbsp;</td>
  </tr>
</table>
<table width="449" border="0" align="center">
  <tr>
    <th colspan="3" class="textoG" scope="col">ASIGNACI&Oacute;N ACTUAL DEL BOT&Oacute;N </th>
  </tr>
  <tr>
    <th width="188" class="EncabezadoTabla" scope="col">BOT&Oacute;N</th>
    <th width="251" colspan="2" class="EncabezadoTabla" scope="col">MATERIAL</th>
  </tr>
  <tr class="Item1">
    <td><?php  regresa(botones,Identificador,IdBoton,$boton);  ?></td>
    <td colspan="2"><?php echo $v[Material];  ?></td>
  </tr>
</table>
<table width="449" border="0" align="center">
  <tr>
    <th colspan="3" class="textoG" scope="col">&nbsp;</th>
  </tr>
  <tr>
    <th colspan="3" class="textoG" scope="col">NUEVA ASIGNACI&Oacute;N </th>
  </tr>
  <tr>
    <th width="188" class="EncabezadoTabla" scope="col">BOT&Oacute;N</th>
    <th width="251" colspan="2" class="EncabezadoTabla" scope="col">MATERIAL</th>
  </tr>
  <tr class="Item1">
    <td><?php  regresa(botones,Identificador,IdBoton,$boton);  ?></td>
    <td colspan="2"><?php regresa(materiales,Descripcion,IdMaterial,$material);  ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="Subtitulo" >SI DESEA CONTINUAR CON LA NUEVA ASIGNACI&Oacute;N, OPRIMA &quot;ASIGNAR&quot;, EN CASO CONTRARIO OPRIMA &quot;MODIFICAR&quot; </td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="4934" colspan="3" >&nbsp;</td>
  </tr>
</table>

<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="352" >&nbsp;</td>
	<form action="1Inicio.php" method="post" name="regresa">
    <td width="133" ><input name="Submit2" type="submit" class="boton" value="Modificar" />
    <input type="hidden" name="flag" value="1" />
    <input type="hidden" name="botones"  value="<?php echo $boton; ?>" />
    <input type="hidden" name="materiales" value="<?php echo $material; ?>" /></td>
	</form>
	<form action="3Asigna.php" method="post" name="frm">
    <td width="101" ><input name="Submit" type="submit" class="boton" value="Asignar" />
    <input type="hidden" name="botones"  value="<?php echo $boton; ?>" />
	 <input type="hidden" name="tipoup"  value="1" />
    <input type="hidden" name="materiales" value="<?php echo $material; ?>" /></td>
	</form>
  </tr>
</table>

<?PHP } else{ ?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" class="Subtitulo" >VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTAR SEA CORRECTA </td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="4934" colspan="3" >&nbsp;</td>
  </tr>
</table>
<table width="449" border="0" align="center">
  
  <tr>
    <th width="188" class="EncabezadoTabla" scope="col">BOT&Oacute;N</th>
    <th width="251" colspan="2" class="EncabezadoTabla" scope="col">MATERIAL</th>
  </tr>
  <tr class="Item1">
    <td><?php  regresa(botones,Identificador,IdBoton,$boton);  ?></td>
    <td colspan="2"><?php regresa(materiales,Descripcion,IdMaterial,$material);  ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td width="352" >&nbsp;</td>
	<form action="1Inicio.php" method="post" name="regresa">
    <td width="133" ><input name="Submit2" type="submit" class="boton" value="Modificar" />
    <input type="hidden" name="flag" value="1" />
    <input type="hidden" name="botones"  value="<?php echo $boton; ?>" />
    <input type="hidden" name="materiales" value="<?php echo $material; ?>" /></td>
	</form>
	<form action="3Asigna.php" method="post" name="frm">
    <td width="101" ><input name="Submit" type="submit" class="boton" value="Asignar" />
    <input type="hidden" name="botones"  value="<?php echo $boton; ?>" />
    <input type="hidden" name="materiales" value="<?php echo $material; ?>" /></td>
	</form>
  </tr>
</table>
<?PHP } ?>
</body>
</html>
