<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

</head>
<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	session_start();
	$flag=$_REQUEST[flag];
	if($flag==1)
	{
		$padre=$_REQUEST[padre];
		$descripcion=$_REQUEST[descripcion];
	}
	
	 $link=SCA::getConexion();
  $obtiene="select IdCentroCosto, Nivel,  length(Nivel) as niv,concat(repeat('&nbsp;&nbsp;&nbsp;',(length(Nivel)/4)),'=> ',Descripcion)as Descripcion FROM centroscosto WHERE length(Nivel)=4 and IdProyecto= ".$_SESSION[Proyecto]." ORDER BY Nivel";
  $r=$link->consultar($obtiene);
  $no=$link->affected();
  
?>
<script src="../../../Clases/Js/Genericas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<script>
function val(norow)
{
  caja="descripcion"+norow;
  bot="envia"+norow;

  if (!document.getElementById) return false;
  benv = document.getElementById(bot);
  caj = document.getElementById(caja);
  if(caj.value!='')
  benv.disabled=0;
  else
   benv.disabled=1;


}
function cambiaB(names)
{
if (!document.getElementById) return false;
  botons = document.getElementById(names);
	if(botons.value=="Agregar")
	botons.value="Cancelar";
	else
	botons.value="Agregar";
}
function cambio(idf,boton)
{
if (!document.getElementById) return false;
  	fx=document.getElementById(idf);
	bot=document.getElementById(boton);
	bot.value='';
	 fx.style.display="none";
}
function cierra(id,no)
{ no=parseInt(no)+1;
//alert(no);
	for(i=0;i<no;i++)
	{	b="b"+i;
		bc="bc"+i;
		idf="r"+i;
		idp="r"+i;
		bo=document.getElementById(b);
		bco=document.getElementById(bc);
		cdescripcion="descripcion"+i;
		cestatus="estatus"+i;
		filp=document.getElementById(idp);
		if(filp.style.display=="none")
		filp.style.display="";
		if(id==idf)
		{	
			c=document.getElementById(cdescripcion);
			
			c.disabled=0;
		}
		if(id!=idf)
		{
			
			fil=document.getElementById(idf);
			c=document.getElementById(cdescripcion);
			c.disbled=1;
			c.value='';
			fil.style.display="none";
			bco.style.display="none";
			bo.style.display="";
		}
		
	
	}
}
</script>
<body>
<form action="2Valida.php" method="post" name="frm">
<?php $pr=0; ?>
<table width="400" border="0" align="center">
<tr>
  <td class="textoG" align="center"> REGISTRAR CENTRO DE COSTO NIVEL 0 </td>
  <td class="textoG" align="center">
  <input name="Submit" id="b0" type="button" <?php if($padre==0&&$padre!=''){?>style="display:none " <?php } ?> onClick="cambiarDisplay('r0');cambiarDisplay('bc0');cambiarDisplay('b0');document.frm.descripcion0.disabled=0;cierra('r<?php echo $pr;?>','<?php echo $no;?>')" class="boton" value="Agregar">
    <input name="Submit" id="bc0" type="button" <?php if($padre!=0||$padre==''){?>style="display:none " <?php } ?> onClick="document.frm.descripcion0.value='';document.frm.descripcion0.disabled=1;cambiarDisplay('r0');cambiarDisplay('bc0');cambiarDisplay('b0')" class="boton" value="Cancelar">

  </td>

</tr>
<tr id="r0" <?php if($padre!=0||$padre==''){?>style="display:none " <?php } ?>>
  <td><input name="descripcion0" <?php if($padre==0){?>value="<?php echo $descripcion; ?>"<?php }?> type="text" class="texto" size="50" maxlength="50" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" onKeyUp="val(<?php echo $pr;?>)"></td>
  <td align="center">
  	<input name="envia<?php echo $pr;?>" type="button" onClick="document.frm.descripcion.value=document.frm.descripcion<?php echo $pr; ?>.value;document.frm.padre.value='0';this.form.submit()" class="boton" value="Registrar" disabled>
  </td>
</tr>
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<?php if($no>=1){?>
  <tr>
    <td width="312" class="EncabezadoTabla"><input type="hidden" name="descripcion">
	<input type="hidden" name="padre">
      DESCRIPCI&Oacute;N</td>
    <td width="78" class="EncabezadoTabla">&nbsp;</td>
  </tr>
  <?PHP
 }
  $pr=1;
 
  while($v=mysql_fetch_array($r))
  {
   ?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[Descripcion]; ?></td>
    <td align="center"><input  id="b<?php echo $pr;?>"  type="button" class="boton" value="Agregar" <?php if($v[IdCentroCosto]==$padre){?>style="display:none " <?php } ?> onClick="cambiarDisplay('bc<?php echo $pr;?>');cambiarDisplay('b<?php echo $pr;?>');cierra('r<?php echo $pr;?>','<?php echo $no;?>');">
	<input  id="bc<?php echo $pr;?>" type="button" <?php if($v[IdCentroCosto]!=$padre){?>style="display:none " <?php } ?> class="boton" value="Cancelar" onClick="cambiarDisplay('bc<?php echo $pr;?>');cambiarDisplay('b<?php echo $pr;?>');cambio('r<?php echo $pr;?>','descripcion<?php echo $pr; ?>');"></td>
  </tr>
 
  <tr <?php if($v[IdCentroCosto]!=$padre){?>style="display:none " <?php } ?> id="r<?php echo $pr;?>" class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><input <?php if($v[IdCentroCosto]==$padre){?>value="<?php echo $descripcion; ?>"<?php }?> <?php if($v[IdCentroCosto]!=$padre){?>disabled<?php } ?>  id="descripcion<?php echo $pr; ?>"; name="descripcion<?php echo $pr; ?>" type="text"  style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" onKeyUp="val(<?php echo $pr;?>)"class="texto" size="50" maxlength="50">
      <span class="EncabezadoTabla">
      <input type="hidden" name="padre<?php echo $pr; ?>" value="<?php echo $v[IdCentroCosto]; ?>">
      </span> </td>
    <td>
	<input name="envia<?php echo $pr;?>" type="button" onClick="document.frm.descripcion.value=document.frm.descripcion<?php echo $pr; ?>.value;document.frm.padre.value=document.frm.padre<?php echo $pr; ?>.value;this.form.submit()" class="boton" value="Registrar" disabled>
	
	</td>
  </tr>
   <tr  id="r<?php echo $pr;?>" class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td colspan="2"><table width="382" border="0">
	
	
	<?php  ?>
        <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><?php echo $v[Descripcion]; ?></td>
    <td align="center"><input  id="b<?php echo $pr;?>"  type="button" class="boton" value="Agregar" <?php if($v[IdCentroCosto]==$padre){?>style="display:none " <?php } ?> onClick="cambiarDisplay('bc<?php echo $pr;?>');cambiarDisplay('b<?php echo $pr;?>');cierra('r<?php echo $pr;?>','<?php echo $no;?>');">
	<input  id="bc<?php echo $pr;?>" type="button" <?php if($v[IdCentroCosto]!=$padre){?>style="display:none " <?php } ?> class="boton" value="Cancelar" onClick="cambiarDisplay('bc<?php echo $pr;?>');cambiarDisplay('b<?php echo $pr;?>');cambio('r<?php echo $pr;?>','descripcion<?php echo $pr; ?>');"></td>
  </tr>
 
  <tr <?php if($v[IdCentroCosto]!=$padre){?>style="display:none " <?php } ?> id="r<?php echo $pr;?>" class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td><input <?php if($v[IdCentroCosto]==$padre){?>value="<?php echo $descripcion; ?>"<?php }?> <?php if($v[IdCentroCosto]!=$padre){?>disabled<?php } ?>  id="descripcion<?php echo $pr; ?>"; name="descripcion<?php echo $pr; ?>" type="text"  style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" onKeyUp="val(<?php echo $pr;?>)"class="texto" size="50" maxlength="50">
      <span class="EncabezadoTabla">
      <input type="hidden" name="padre<?php echo $pr; ?>" value="<?php echo $v[IdCentroCosto]; ?>">
      </span> </td>
    <td>
	<input name="envia<?php echo $pr;?>" type="button" onClick="document.frm.descripcion.value=document.frm.descripcion<?php echo $pr; ?>.value;document.frm.padre.value=document.frm.padre<?php echo $pr; ?>.value;this.form.submit()" class="boton" value="Registrar" disabled>
	
	</td>
  </tr>
  <?php }?>
  
  
      </table></td>
    </tr>
  <?php $pr++; }?>
</table>
</form>

</body>
</html>
