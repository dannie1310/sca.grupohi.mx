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
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>

<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<script>
	function valida(id)
	{
		if (!document.getElementById) return false;
	  	formulario = document.getElementById(id);
	  	if(formulario.descripcion.value=="")
		{
			alert ("INDIQUE LA DESCRIPCIÓN DEL PROYECTO");
			formulario.descripcion.focus();
			return false;
		}
		else
		if(formulario.corto.value=="")
		{
			alert ("INDIQUE EL NOMBRE CORTO DEL PROYECTO");
			formulario.corto.focus();
			return false;
		}
		else return true;
	}
</script>
<body>
<table align="center" width="700" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Proyectos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Proyectos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table  border="0" align="center" style="display:none " >
  <tr>
<?php 
include("../../../inc/php/conexiones/SCA.php");
$flag=$_REQUEST[flag];
	if($flag==1)
	{
		$descripcion=$_REQUEST[descripcion];
		$corto=$_REQUEST[corto];
	}
$link=SCA::getConexion();
	$sql="
	SELECT 
		distinct substr( descripcion, 1, 1 ) AS Inicial
	FROM 
		`proyectos` 
	
	ORDER BY Inicial
";
	$result=$link->consultar($sql);
	$i=0;
	while($row=mysql_fetch_array($result))
	{
		$inicial[$i]=$row[Inicial];
		
		?>
		
    <td width="26"><?php echo $inicial[$i]; ?></td>
    
 
		<?php 
		$i++;
	}
	
 ?>
 </tr>
</table>
<form action="2Valida.php" method="post" id="frm1" name="frm1">
<table width="700" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onClick="cambiarDisplay('agrega1')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" align="absmiddle" width="16" height="16" alt="AGREGAR PROYECTO" /> Agregar</td>
    
  </tr>
</table>
	<table width="700" align="center"  <?php if($flag=='') { ?> style="display:none"  <?php } ?>    id="agrega1" >
		<tr>
		<td width="22">&nbsp;		</td>
		
			<td width="99" class="Concepto">
			 DESCRIPCI&Oacute;N:			
          </td>
			
		    <td width="177"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="30" maxlength="50" /></td>
		    <td width="136" class="Concepto">&nbsp;NOMBRE CORTO:</td>
		    <td width="142"><input name="corto" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $corto; ?>" size="25" maxlength="25" />	        </td>
		    <td width="96"><input name="button" type="button" class="boton" onclick="if(valida('frm1'))this.form.submit()" value="Registrar" /></td>
		</tr>
  </table>
</form>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="center" class="Subtitulo">PROYECTOS EXISTENTES </div></td>
  </tr>

   <tr>
     <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td width="262" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
     <td width="172" class="EncabezadoTabla">NOMBRE CORTO </td>
     <td width="152" class="EncabezadoTabla">ESTATUS</td>
   </tr>
     <?PHP 
	$sql="select *,
	case Estatus 
	when 0 then 'INACTIVO'
	WHEN 1 then 'ACTIVO'
	end Estate from proyectos"; 
	$r=$link->consultar($sql);
	$pr=1;
	while($v=mysql_fetch_array($r))
	{
	  if($v[Estatus]==0)
	  $Estatus="Inactivo";
	  else 
	  if($v[Estatus]==1)
	  $Estatus="Activo";
  ?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td>      <?PHP 
   echo $v[Descripcion];?>    </td>
    <td>      <?PHP 
   echo $v[NombreCorto];?>    </td>
    <td>
    <div align="center"><?PHP 
   echo $v[Estate];?></div></td>
  </tr>
   <?PHP $pr++;
   }?>
   <tr>
     <td colspan="3">&nbsp;</td>
   </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>

<form action="2Valida.php" method="post" id="frm2" name="frm">
<table width="700" border="0" align="center">
  <tr>
    <td width="103">&nbsp;</td>
    <td width="572">&nbsp;</td>
    <td width="75">&nbsp;</td>
    <td width="77">&nbsp;</td>
  </tr>
  <tr>
    <td height="27" class="texto" style="cursor:hand" onClick="cambiarDisplay('agrega')"><img src="../../../Imgs/16-square-red-add.gif" width="16" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'" height="16" align="absmiddle" alt="AGREGAR PROYECTO" /> Agregar</td>
    
  </tr>
</table>
	<table width="700" align="center" <?php if($flag=='') { ?> style="display:none"  <?php } ?>   id="agrega" >
		<tr>
		<td width="22">&nbsp;		</td>
		
			<td width="99" class="Concepto">
			 DESCRIPCI&Oacute;N:			
          </td>
			
		    <td width="177"><input name="descripcion" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $descripcion; ?>" size="30" maxlength="50" /></td>
		    <td width="136" class="Concepto">&nbsp;NOMBRE CORTO:</td>
		    <td width="142"><input name="corto" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php if($flag==1) echo $corto; ?>" size="25" maxlength="25" />	        </td>
		    <td width="96"><input name="button" type="button" class="boton" onclick="if(valida('frm2'))this.form.submit()" value="Registrar" /></td>
		</tr>
  </table>
</form>

</body>
</html>
