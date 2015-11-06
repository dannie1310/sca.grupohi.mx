<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>


<body onload="valida()">
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CostoViaje.gif" width="16" height="16" />&nbsp;SCA.- Registro de Tarifas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<script>
function valida()
{	
document.frm.envia.disabled=true;

		
	 for (i=0;i<document.frm.elements.length;i++) 
	 {
	 	 if((document.frm.elements[i].type == "radio")) 
	  	{   
			if(document.frm.elements[i].checked==1)
			{
				document.frm.envia.disabled=false;
								
			}
			
		}
		
		
		
	}

	return false;
}
 function caja(val)
 {
 	cuadro=document.getElementById(val);
	id=cuadro.value;
	if(cuadro.checked==1)
		{
			alert(id); 
		}
	
 
 }
</script>
<form name="frm" action="2Valida.php" method="post">
<table width="476" align="center" border="0">
  
  <tr>
    <td colspan="2" class="EncabezadoTabla">MATERIAL</td>
    <td width="69" class="EncabezadoTabla">1ER. KM </td>
    <td width="78" class="EncabezadoTabla">KM. SUBS. </td>
    <td width="84" class="EncabezadoTabla">KM. ADIC. </td>
    <td width="92" class="EncabezadoTabla">ESTATUS M. </td>
  </tr>

  <?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	$tolerancia=$_REQUEST[tolerancia];
	$minimo=$_REQUEST[minimo];
	$ruta=$_REQUEST[ruta];
	$link=SCA::getConexion();

	$sql="select
case m.Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate,
m.descripcion as material,
m.IdMaterial as idmaterial,
t.PrimerKM as p,
t.KMSubsecuente as s,
t.KMAdicional as a
from
materiales as m left join tarifas as t on m.IdMaterial=t.IdMaterial

	;";
	
	//echo $sql;
		
		
		$row=$link->consultar($sql);
		$pr=1;
		while($v=mysql_fetch_array($row))
		{
?>


  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td width="37" >
		
      	<input type="radio" name="radio" value="<?php echo $v[idmaterial] ?>" onclick="document.frm.e.value='<?php echo $v[Estate]; ?>';document.frm.material.value='<?php echo $v[material]; ?>';document.frm.idmaterial.value='<?php echo $v[idmaterial]; ?>';document.frm.p.value='<?php echo $v[p]; ?>';document.frm.s.value='<?php echo $v[s]; ?>';document.frm.a.value='<?php echo $v[a]; ?>';valida()"  />
   </td>
    <td width="90" ><?php echo $v[material] ?></td>
    <td width="69" align="right" ><?php echo $v[p]; ?></td>
    <td width="78" align="right" ><?php echo $v[s]; ?></td>
    <td width="84"  align="right"><?php echo $v[a]; ?></td>
    <td width="92"  align="center"><?php echo $v[Estate]; ?></td>
  </tr>
 <?PHP $pr++; } ?>
   <tr >
     <td colspan="2">&nbsp;</td>
     <td >&nbsp;</td>
     <td>&nbsp;</td>
     <td  align="center">&nbsp;</td>
     <td  align="center">&nbsp;</td>
   </tr>
   <tr >
    <td colspan="2">&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td  align="center"><input name="p" type="hidden" value="" />
		<input name="s" type="hidden" value="" />
		<input name="a" type="hidden" value="" />
		<input name="e" type="hidden" value="" />
		<input name="idmaterial" type="hidden" value="" />
		<input name="material" type="hidden" value="" />
	  </td>
    <td  align="center"><input type="submit" class="boton" name="envia" disabled  value="Continuar"  /></td>
  </tr>
 </table>
</form>
</body>
</html>
