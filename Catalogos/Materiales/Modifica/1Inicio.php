
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<?php if($_SESSION[IdUsuario]!=2){?>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<?php }?>
<script language="javascript">

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
var isIE = document.all?true:false;
var isNS = document.layers?true:false;
function withoutSpaces(e,decReq) {
var key = (isIE) ? window.event.keyCode : e.which;
var obj = (isIE) ? event.srcElement : e.target;
var isNum = (key!=32&&key!=34&&key!=39&&key!=47&&key!=60&&key!=62) ? true:false;
var dotOK = (key==32 && decReq=='decOK' && (obj.value.length>0)) ? true:false;
window.event.keyCode = (!isNum && !dotOK && isIE) ? 0:key;
e.which = (!isNum && !dotOK && isNS) ? 0:key;
return (isNum || dotOK);
}
</script>
</head>

<body onLoad="valida()">
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Materiales </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm" method="post" action="2Valida.php">
<table  border="0" align="center" style="display:none ">
  <tr>
<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/FactorAbundamiento.php");

	
	
	//echo $flag;
	#SE INICIA LA CONEXION Y SE EJECUTA LA CONSULTA PARA OBTENER LA DESCRIPCION DE TODOS LOS REGISTROS DE LA TABLA ORIGENES
	$link=SCA::getConexion();
	$sql="SELECT distinct substr( descripcion, 1, 1 ) AS Inicial FROM origenes where IdProyecto=".$IdProyecto." ORDER BY Inicial;";
	$result=$link->consultar($sql);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
		$inicial[$i]=$row[Inicial];
		
		?>
		
    <td><?php echo $inicial[$i]; ?></td>
    
 
		<?php 
		$i++;
	}
	
 ?>
 </tr>
</table>

<table width="333" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="34" class="EncabezadoTabla">&nbsp;</td>
    <td width="270" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="271" class="EncabezadoTabla">FdA</td>
    <td width="89" class="EncabezadoTabla">ESTATUS</td>
    </tr>
 
  <?php
  $sql="select Descripcion,IdMaterial,case Estatus
  when 0 then 'INACTIVO'
  when 1 then 'ACTIVO'
  end Estate FROM materiales ;";
	//echo $sql;
	$pr=1;
  $result=$link->consultar($sql);
  while($row=mysql_fetch_array($result))
  {
 
   ?>
    <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
  <td><input name="radiobutton" type="radio" value="radiobutton" onClick="document.frm.material.value=<?php echo $row[IdMaterial]; ?>;valida();">      </td>
    <td><?php echo $row[Descripcion]; ?></td>
    <td align="right"><?php echo regresa_factor($row[IdMaterial]); ?></td>
    <td align="center">
      <?php echo $row[Estate]; ?></td>
    </tr>
  <?php $pr++; }?>
</table>
<table width="425" border="0" align="center">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
<td width="773"><div align="right">
  <input type="hidden" name="material">
  <input name="envia" type="submit" disabled="disabled" class="boton" value="Modificar">
</div></td>
<td width="62">&nbsp;</td>
</tr>
</table>
</form>
</body>
</html>

