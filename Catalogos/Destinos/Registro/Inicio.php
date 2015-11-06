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
<script src="../../../Clases/Js/Genericas.js"></script>

<script language="javascript">

function valida()
{
	if(document.frm.descripcion.value=='')
	{
		alert('INDIQUE LA DESCRIPCION DEL NUEVO DESTINO');
		document.frm.descripcion.focus();
		return false;
	}
	
	else
	return true;
}
function valida1()
{
	if(document.frm1.descripcion.value=='')
	{
		alert('INDIQUE LA DESCRIPCION DEL NUEVO DESTINO');
		document.frm1.descripcion.focus();
		return false;
	}
	
	else
	return true;
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

<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Destinos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table  border="0" align="center" style="display:none ">
  <tr>
<?php
	include("../../../inc/php/conexiones/SCA.php");

	$flag=$_REQUEST[flag];
	if($flag==1)
	{
		$descripcion=$_REQUEST[descripcion];
		$tipo=$_REQUEST[tipo];
	}
	//echo $flag;
	#SE INICIA LA CONEXION Y SE EJECUTA LA CONSULTA PARA OBTENER LA DESCRIPCION DE TODOS LOS REGISTROS DE LA TABLA ORIGENES
	$link=SCA::getConexion();
	$sql="SELECT distinct substr( descripcion, 1, 1 ) AS Inicial FROM tiros where IdProyecto=".$IdProyecto." ORDER BY Inicial;";
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
<form action="2Valida.php" method="post" name="frm1">
<table width="612" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onClick="cambiarDisplay('agrega1')"><img src="../../../Imgs/16-square-red-add.gif" onMouseOver="this.src='../../../Imgs/16-square-blue-add.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16"> Agregar </td>
    
  </tr>
</table>
	<table width="617" id="agrega1" align="center"  <?php if($flag=='') { ?> style="display:none"  <?php } ?> >
		<tr>
		<td width="23">&nbsp;		</td>
		
			<td width="95" class="Concepto">
		  DESCRIPCI&Oacute;N:</td>
			
		    <td width="332"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50"></td>
		    <td width="147"><input type="button" class="boton" onClick="if(valida1())this.form.submit()" value="Registrar"></td>
		</tr>
  </table>
</form>

<table width="449" border="0" align="center">
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="58" class="EncabezadoTabla">CLAVE</td>
    <td width="312" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="65" class="EncabezadoTabla">ESTATUS</td>
  </tr>
 
  <?php
  $sql="select Clave, IdTiro, Descripcion, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate FROM tiros WHERE IdProyecto=".$IdProyecto.";";
	//echo $sql;
  $result=$link->consultar($sql);
  $pr=1;
  while($row=mysql_fetch_array($result))
  {
  
   ?>
    <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
  <td width="58">
    <div align="center"><?php echo $row[Clave].$row[IdTiro];   ?></div></td>
    <td width="312"><?php echo $row[Descripcion]; ?></td>
    <td>
      <div align="center"><?php echo $row[Estate]; ?></div></td>
  </tr>
  <?php $pr++; }?>
</table>
<form action="2Valida.php" method="post" name="frm">
<table width="612" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onClick="cambiarDisplay('agrega')"><img src="../../../Imgs/16-square-red-add.gif" onMouseOver="this.src='../../../Imgs/16-square-blue-add.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16"> Agregar </td>
    
  </tr>
  </table>
  <table width="617" id="agrega" align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?>  >
		<tr>
		<td width="23">&nbsp;		</td>
		
			<td width="95" class="Concepto">
		  DESCRIPCI&Oacute;N:</td>
			
		    <td width="332"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="50"></td>
		    <td width="147"><input type="button" class="boton" onClick="if(valida())this.form.submit()" value="Registrar"></td>
		</tr>
  </table>

</form>
</body>
</html>

