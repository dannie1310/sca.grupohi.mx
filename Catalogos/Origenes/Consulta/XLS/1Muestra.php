<?php
	session_start();
	
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Relación de Origenes al Día '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<body>
<table width="700" border="1" align="center">
   <tr>
     <td colspan="6"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:16px;text-align:center">RELACI&Oacute;N DE ORIGENES REGISTRADOS </font></div></td>
   </tr>
   <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">FECHA DE </font></div></td>
     <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">HORA DE</font> </div></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
  <tr>
    <td width="58"><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">CLAVE</font></div></td>
    <td width="68"><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">ALTA</font></div></td>
    <td width="65"><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">ALTA</font></div></td>
    <td width="136"><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">TIPO</font></div></td>
    <td width="254"><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">DESCRIPCI&Oacute;N</font></div></td>
    <td width="79"><div align="center"><font face="Trebuchet MS" style="font-weight:bold;font-size:14px">ESTATUS</font></div></td>
  </tr>
<?php
	include("../../../../inc/php/conexiones/SCA.php");
	include("../../../../Clases/Funciones/Catalogos/Genericas.php");
	$sql="select Clave,FechaAlta,HoraAlta,IdOrigen,IdTipoOrigen,Descripcion, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate from origenes where IdProyecto=".$_SESSION['Proyecto'].";";
	
	$link=SCA::getConexion();
	$r=$link->consultar($sql);
	while($v=mysql_fetch_array($r))
	{
		?>
		
		 <tr>
    <td width="58"><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?PHP echo $v["Clave"].$v["IdOrigen"]; ?></font></div></td>
    <td width="68"><div align="center"><font face="Trebuchet MS" style="font-size:12px">
      <?PHP echo fecha($v["FechaAlta"]); ?>
    </font></div></td>
    <td width="65"><div align="center"><font face="Trebuchet MS" style="font-size:12px">
      <?PHP echo $v["HoraAlta"]; ?>
    </font></div></td>
    <td width="136"><font face="Trebuchet MS" style="font-size:12px">
      <?PHP regresa(tiposorigenes,Descripcion,IdTipoOrigen,$v["IdTipoOrigen"]); ?>
    </font></td>
    <td width="254"><font face="Trebuchet MS" style="font-size:12px"><?PHP echo $v["Descripcion"]; ?></font></td>
    <td width="79"><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?PHP echo $v["Estate"]; ?></font></div></td>
  </tr>
		<?PHP
	}
	
?>
</table>
</body>
</html>
