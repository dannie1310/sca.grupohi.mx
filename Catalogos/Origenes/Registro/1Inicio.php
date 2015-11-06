<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript">
function cambiarDisplay(id) {
  if (!document.getElementById) return false;
  fila = document.getElementById(id);
  if (fila.style.display != "none") {
    fila.style.display = "none"; //ocultar fila 

  } else {
    fila.style.display = ""; //mostrar fila 
  }
}
function valida()
{
	
	if(document.frm.tiposorigenes.value=='A99')
	{
		alert('INDIQUE EL TIPO DE ORIGEN');
		document.frm.tiposorigenes.focus();
		return false;
	}
	else
	if(document.frm.descripcion.value=='')
	{
		alert('INDIQUE LA DESCRIPCION DEL NUEVO ORIGEN');
		document.frm.descripcion.focus();
		return false;
	}
	else
	return true;
}
function valida1()
{
	
	if(document.frm1.tiposorigenes.value=='A99')
	{
		alert('INDIQUE EL TIPO DE ORIGEN');
		document.frm1.tiposorigenes.focus();
		return false;
	}
	else
	if(document.frm1.descripcion.value=='')
	{
		alert('INDIQUE LA DESCRIPCION DEL NUEVO ORIGEN');
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
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>

<body>
<table align="center" width="845" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;SCA.- Registro de Origenes </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table  border="0" align="center" style="display:none ">
  <tr>
<?php
	include("../../../inc/php/conexiones/SCA.php");
	//////////////////////////
	///VARIABLES TEMPORALES///
	//////////////////////////
	
	$IdUsuario=1;
	$Descripcion="Omar Aguayo Mendoza";
	$IdProyecto=1;
	$flag=$_REQUEST[flag];
	if($flag==1)
	{
		$descripcion=$_REQUEST[descripcion];
		$tipo=$_REQUEST[tipo];
	}
	//echo $flag;
	#SE INICIA LA CONEXION Y SE EJECUTA LA CONSULTA PARA OBTENER LA DESCRIPCION DE TODOS LOS REGISTROS DE LA TABLA ORIGENES
	$link=SCA::getConexion();
	$sql="SELECT distinct substr(descripcion, 1, 1 ) AS Inicial FROM origenes where IdProyecto=".$IdProyecto." ORDER BY Inicial";
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
<table width="845" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onClick="cambiarDisplay('agrega2')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16">&nbsp;Agregar </td>
    
  </tr>
</table>
	<table width="845" id="agrega2" align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?> >
		<tr>
		<td width="19" >		
	 	  </td>
		<td width="85" class="Concepto">TIPO:</td>
		<td width="171" ><select  name="tiposorigenes"  style="cursor:hand ">
          <option value="A99">- SELECCIONE -</option>
          <?PHP 
			  $sql="select * from tiposorigenes order by descripcion asc";
			  $result=$link->consultar($sql);
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
          <option <?php if($tipo==$row[IdTipoOrigen]) echo "selected"; ?>  value="<?php echo $row[IdTipoOrigen]; ?>"><?php echo $row[Descripcion]; ?></option>
          <?php 
			   }
			   ?>
          </select></td>
			<td width="109" class="Concepto">
		  DESCRIPCI&Oacute;N:	      &nbsp;&nbsp;	</td>
			
		    <td width="183"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="35">	      </td>
		    <td width="250"><input value="Registrar" class="boton" onClick="if(valida1())this.form.submit()" type="button"></td>
		</tr>
  </table>
</form>
<table width="508" border="0" align="center">
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="58" class="EncabezadoTabla">CLAVE</td>
    <td width="479" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="149" class="EncabezadoTabla">ESTATUS</td>
  </tr>
 
  <?php
  $sql="select Clave,IdOrigen, Descripcion, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate FROM origenes WHERE IdProyecto=".$IdProyecto.";";
	//echo $sql;
  $result=$link->consultar($sql);
  $pr=1;
  while($row=mysql_fetch_array($result))
  {
 
   ?>
    <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
  <td width="58"  >
    <div align="center"><?php echo $row[Clave].$row[IdOrigen];   ?></div></td>
    <td width="479" ><?php echo $row[Descripcion]; ?></td>
    <td >
      <div align="center"><?php echo $row[Estate]; ?></div></td>
  </tr>
  <?php $pr++; }?>
</table>
<form action="2Valida.php" method="post" name="frm">
  <table width="845" border="0" align="center">
    <tr>
      <td width="103">&nbsp;</td>
      <td width="572">&nbsp;</td>
      <td width="75">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" class="texto" style="cursor:hand" onClick="cambiarDisplay('agrega')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle"
	   width="16" height="16"> Agregar </td>
    </tr>
  </table>
  <table width="845" id="agrega" align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?>  >
		<tr>
		<td width="19" >&nbsp;		  </td>
		<td width="84" class="Concepto">TIPO:</td>
		<td width="170" ><select  name="tiposorigenes"  style="cursor:hand ">
          <option value="A99" >- SELECCIONE -</option>
          <?PHP 
			  $sql="select * from tiposorigenes order by descripcion asc";
			  $result=$link->consultar($sql);
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
          <option <?php if($tipo==$row[IdTipoOrigen]) echo "selected"; ?>  value="<?php echo $row[IdTipoOrigen]; ?>"><?php echo $row[Descripcion]; ?></option>
          <?php 
			   }
			   ?>
          </select></td>
			<td width="109" class="Concepto">
		  DESCRIPCI&Oacute;N:	      &nbsp;&nbsp;	</td>
			
		    <td width="183"><input class="text" type="text" name="descripcion" size="35" onKeyPress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" style="text-transform:uppercase">	      </td>
		    <td width="244"><input value="Registrar" class="boton" onClick="if(valida())this.form.submit()" type="button"></td>
		</tr>
  </table>
</form>
</body>
</html>

