<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../../Clases/Js/NoClick.js"></script>
<script src="../../../Clases/Js/Genericas.js"></script>
<script>
function valida(id)
{
 if (!document.getElementById) return false;
  
  formulario = document.getElementById(id);
  if(formulario.botones.value=='A99')
  {
	  alert("INDIQUE EL BOTÓN AL QUE ASIGNARA EL MATERIAL");
	  formulario.botones.focus();
	  return false;
  }
  else
  if (!document.getElementById) return false;
  
  formulario = document.getElementById(id);
  if(formulario.materiales.value=='A99')
  {
	  alert("INDIQUE EL MATERIAL QUE SE ASIGNARÁ");
	  formulario.materiales.focus();
	  return false;
  }
  else
  return true;

}
</script>
<body>
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" />SCA.- Asignaci&oacute;n de Materiales por Bot&oacute;n</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	
	
	$IdProyecto=$_SESSION['Proyecto'];

	$flag=$_REQUEST[flag];
	$boton=$_REQUEST[botones];
	$material=$_REQUEST[materiales];
	
	$link=SCA::getConexion();
	$sql="
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
			b.IdProyecto=".$IdProyecto." and
			mxb.IdBoton=b.IdBoton and
			mxb.IdMaterial=m.IdMaterial
	";
	//echo $sql;
$r=$link->consultar($sql);
?>
<form action="2Valida.php" method="post" name="frm1" id="frm1">

  <table width="600" border="0" align="center">
    <tr>
      <td width="103">&nbsp;</td>
      <td width="572">&nbsp;</td>
      <td width="75">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega1')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'"
 align="absmiddle" width="16" height="16" /> Agregar </td>
    </tr>
  </table>
  <table width="580" id="agrega1"  align="center"   <?php if($flag=='') { ?> style="display:none"  <?php } ?> >
    <tr>
      <td width="14">&nbsp;</td>
      <td width="50" class="Concepto"> BOTÓN:        </td>
      <td width="107">
	
	   <select name="botones">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP 
			  $ls=SCA::getConexion();
			  $sql="select * from botones where TipoBoton=1 and IdProyecto=".$IdProyecto." and Estatus not in (0,3) order by Identificador asc";
			  //echo $sql;
			  $result=$ls->consultar($sql);
			  $h=$ls->affected();
			  //$ls->cerrar();
			
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option  <?php if($boton==$row[IdBoton]) echo "selected"; ?>  value="<?php echo $row[IdBoton]; ?>"><?php echo $row[Identificador]; ?></option>
			   <?php 
			   }
			   ?>
	    </select>
	  <?php //comboBotonMaterialesSelected(botones,Identificador,IdBoton,$IdProyecto,$boton);?></td>
      <td width="76" class="Concepto">&nbsp;MATERIAL:&nbsp; </td>
      <td width="114"><?php comboSelected(materiales,Descripcion,IdMaterial,$material); ?></td>
      <td width="191"><input name="button" type="button" class="boton" onclick="if(valida('frm1'))this.form.submit()" value="Registrar" /></td>
    </tr>
  </table>
</form>
<table width="447" border="0" align="center">
  <tr>
    <th width="170" class="EncabezadoTabla" scope="col">BOT&Oacute;N</th>
    <th width="323" class="EncabezadoTabla" scope="col">MATERIAL</th>
    <th width="93" class="EncabezadoTabla" scope="col">ESTATUS</th>
  </tr>
  <?php $pr=1;
  while($v=mysql_fetch_array($r)){ ?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td>
    <div align="center"><?php echo $v[Boton];  ?></div></td>
    <td><?php echo $v[Material];  ?></td>
    <td>
    <div align="center"><?php echo $v[Estate];  ?></div></td>
  </tr>
   <?php $pr++; }?>
</table>

<form action="2Valida.php" method="post" name="frm" id="frm">
  <table width="600" border="0" align="center">
    <tr>
      <td width="103">&nbsp;</td>
      <td width="572">&nbsp;</td>
      <td width="75">&nbsp;</td>
      <td width="77">&nbsp;</td>
    </tr>
    <tr>
      <td height="27" class="texto" style="cursor:hand" onclick="cambiarDisplay('agrega')"><img src="../../../Imgs/16-square-red-add.gif" onmouseover="this.src='../../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../../Imgs/16-square-red-add.gif'"
 align="absmiddle" width="16" height="16" /> Agregar </td>
    </tr>
  </table>
  <table width="580" id="agrega"  align="center"  <?php if($flag=='') { ?> style="display:none"  <?php } ?>  >
    <tr>
      <td width="14">&nbsp;</td>
      <td width="50" class="Concepto"> BOTÓN:        </td>
      <td width="107">
	  
	   <select name="botones">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP 
			  $ls=SCA::getConexion();
			  $sql="select * from botones where TipoBoton=1 and IdProyecto=".$IdProyecto." and Estatus not in (0,3) order by Identificador asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  $h=$ls->affected();
			 
			
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option  <?php if($boton==$row[IdBoton]) echo "selected"; ?>  value="<?php echo $row[IdBoton]; ?>"><?php echo $row[Identificador]; ?></option>
			   <?php 
			   }
			   ?>
		  </select>
	  
	  </td>
      <td width="76" class="Concepto">&nbsp;MATERIAL:&nbsp; </td>
      <td width="114"><?php comboSelected(materiales,Descripcion,IdMaterial,$material); ?></td>
      <td width="191"><input name="button" type="button" class="boton" onclick="if(valida('frm'))this.form.submit()" value="Registrar" /></td>
    </tr>
  </table>
</form>
</body>
</html>
