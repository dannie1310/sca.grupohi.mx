<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>

<body>
<table align="center" width="845" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;SCA.- Registro de Cronometrias </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<script>
function botons(id)
{
if (!document.getElementById) return false;
  
  boton = document.getElementById(id);

  if(boton.value=="Agregar")
  boton.value="Cancelar";
  else
  if(boton.value=="Cancelar")
  boton.value="Agregar";
}
function valida(id)
{
if (!document.getElementById) return false;
  formulario = document.getElementById(id);
 
  if(formulario.tolerancia)
{	
	if((formulario.tolerancia.value==".")||(formulario.tolerancia.value==""))
	formulario.tolerancia.value="0.00";
	
}
  if(formulario.minimo)
{	
	if((formulario.minimo.value!=".")&&(formulario.minimo.value!=""))
		{ 
			an=formulario.minimo.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE EL TIEMPO MÍNIMO");
				formulario.minimo.focus();
				return false;
			}
			else
		{ 
		   return true;
		}
		}
		else
		if((formulario.minimo.value==".")||(formulario.minimo.value==""))
		{
				alert("POR FAVOR INDIQUE EL TIEMPO MÍNIMO");
				formulario.minimo.focus();
				return false;
		}
		else
		{ 
		   return true;
		}
		
}
 } 
</script>
<table width="656" align="center" border="0">
  
  <tr>
    <td width="139" class="EncabezadoTabla">RUTA</td>
    <td width="176" class="EncabezadoTabla">ORIGEN</td>
    <td width="174" class="EncabezadoTabla">DESTINO</td>
    <td width="149" class="EncabezadoTabla">&nbsp;</td>
  </tr>
</table>
  <?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	$tolerancia=$_REQUEST[tolerancia];
	$minimo=$_REQUEST[minimo];
	$ruta=$_REQUEST[ruta];
	$link=SCA::getConexion();
	$svalida="select * from cronometrias";
	$link->consultar($svalida);
	$exi=$link->affected();
	
	if($exi==0)
	{ $vali='';
	$vali2='';
	}
	else
	if($exi>0)
	{$vali='and r.IdRuta not in(select IdRuta from cronometrias as c where c.Estatus=1)';
	$vali2=', 
	cronometrias as c ';}
	
	$sql="select distinct (r.IdRuta) as IdRuta, r.IdOrigen, r.IdTiro, r.Clave from rutas as r ".$vali2." where r.Estatus=1 and IdProyecto=".$_SESSION["Proyecto"]." ".$vali.";";
		//echo $sql;
		
		$row=$link->consultar($sql);
		while($v=mysql_fetch_array($row))
		{
?>
 <table width="656" align="center" border="0">
  <tr class="Item1">
    <td width="140" class="Item1">
    <div align="center"><?php echo $v[Clave].$v[IdRuta] ?></div></td>
    <td width="178" class="Item1"><?php echo regresa(origenes,Descripcion,IdOrigen,$v[IdOrigen]); ?></td>
    <td width="175" class="Item1"><?php echo regresa(tiros,Descripcion,IdTiro,$v[IdTiro]); ?></td>
    <td width="145"  align="center">
      <input type="button" class="boton" name="Submit" id="b<?php echo $v[IdRuta];?>" value="Agregar" onclick="cambiarDisplay('t<?php echo $v[IdRuta]; ?>');botons('b<?php echo $v[IdRuta];?>');" />    
    </td>
  </tr>
   
 </table>

 

	<table width="656"  align="center"  <?php if($ruta!=$v[IdRuta]) {?> style="display:none" <?php } ?>   id="t<?php echo $v[IdRuta];?>">
	 <form action="2Valida.php" method="post" name="frm<?php echo $v[IdRuta];?>" id="<?php echo $v[IdRuta];?>">
			<tr>
			  <td colspan="5" class="Subtitulo" >&nbsp;</td>
	   </tr>
			<tr>
			<td colspan="5" class="Subtitulo" >Por favor Indique el Tiempo M&iacute;nimo y Tolerancia en Minutos </td>
		  </tr>
		<tr>
			  <td colspan="5" class="Subtitulo" >&nbsp;</td>
	   </tr>
	    <tr>
		  <td width="138" class="Concepto">Tiempo M&iacute;nimo: 
	      <input type="hidden" name="ruta" value="<?php echo $v[IdRuta];?>" /></td>
		  <td width="129"><input name="minimo" type="text" class="text" onKeyPress="onlyDigits(event,'decOK')" value="<?php if($ruta==$v[IdRuta]) { echo $minimo; } ?>" size="10" maxlength="10" /></td>
			<td width="101" class="Concepto">Tolerancia:</td>
		  <td width="119"><input name="tolerancia" type="text" class="text"  onKeyPress="onlyDigits(event,'decOK')" value="<?php if($ruta==$v[IdRuta]) { echo $tolerancia; } ?>" size="10" maxlength="10" /></td>
		  <td width="145">			  <div align="center">
		    <input name="Submit2" type="button" class="boton" onClick="if(valida(<?php echo $v[IdRuta];?>))this.form.submit();" value="Registrar" />		  
	      </div></td>
	   </tr> </form>
	   <tr>
			  <td colspan="5" class="Subtitulo" >&nbsp;</td>
	   </tr>
	</table>



 <?PHP } ?>

</body>
</html>
