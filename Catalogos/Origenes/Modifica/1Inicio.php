<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript">

function valida()
{	//alert("fsd");
document.frm.envia.disabled=true;

		//b=document.frm.elements.length;
		//alert (b);
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
<table align="center" width="845" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><p><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Origenes </p>
    </td>
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
	//////////////////////////
	///VARIABLES TEMPORALES///
	//////////////////////////
	
	$flag=$_REQUEST[flag];
	if($flag==1)
	{
		$descripcion=$_REQUEST[descripcion];
		$tipo=$_REQUEST[tipo];
	}
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

<table width="601" border="0" align="center">
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="EncabezadoTabla">CLAVE</td>
    <td width="158" class="EncabezadoTabla">TIPO</td>
    <td width="270" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="65" class="EncabezadoTabla">ESTATUS</td>
    </tr>
 
  <?php
  $sql="select Clave,IdOrigen,IdTipoOrigen,Descripcion,Estatus FROM origenes where IdProyecto=".$IdProyecto.";";
	//echo $sql;
	$pr=1;
  $result=$link->consultar($sql);
  while($row=mysql_fetch_array($result))
  {
  if($row[Estatus]==0)
  $Estatus="INACTIVO";
  else 
  if($row[Estatus]==1)
  $Estatus="ACTIVO";
   ?>
    <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
  <td width="28"><input name="radiobutton" type="radio" value="radiobutton" onClick="document.frm.origen.value=<?php echo $row[IdOrigen]; ?>;valida();"></td>
    <td width="58">
      <div align="center"><?php echo $row[Clave].$row[IdOrigen];   ?></div></td>
    <td width="158"><?php regresa(tiposorigenes,Descripcion,IdTipoOrigen,$row[IdTipoOrigen]); ?></td>
    <td width="270"><?php echo $row[Descripcion]; ?></td>
    <td>
      <div align="center"><?php echo $Estatus; ?></div></td>
    </tr>
  <?php $pr++; }?>
</table>
<table width="845" border="0" align="center">
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
<td width="722"><div align="right">
  <input type="hidden" name="origen">
  <input name="envia" type="submit" disabled="disabled" class="boton" value="Modificar">
</div></td>
<td width="113">&nbsp;</td>
</tr>
</table>
</form>
</body>
</html>

