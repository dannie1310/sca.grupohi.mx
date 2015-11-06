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
</head>
<script src="../../../Clases/Js/NoClick.js">
</script>
<script src="../../../Clases/Js/Cajas.js">
</script>
<script>
function agrega()
{	a=0.00;
//alert(a);

		//b=document.frm.elements.length;
		//alert (b);
	 for (i=0;i<document.frm.elements.length;i++) 
	 {
	 	 if((document.frm.elements[i].type == "text")&&(document.frm.elements[i].value!="")&&(document.frm.elements[i].name!="total")) 
	  	{   
			//a=document.frm.elements[i].value; 
			//alert(a);
	a = a + parseInt(document.frm.elements[i].value);
 //alert(a);

			
		}
		
		resultado = parseInt(a).toFixed(2).toString();
		resultado = resultado.split(".");
		var cadena = ""; cont = 1
		for(m=resultado[0].length-1; m>=0; m--)
			{
				cadena = resultado[0].charAt(m) + cadena
				cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
				cont== 3 ? cont = 1 :cont++
			}
	
		document.frm.total.value=cadena +" ";
	

		
		//document.frm.suma.value=a;
	}

	return false;
}

function valida()
{ 
	if(document.frm.subsecuentes.value=="")
		document.frm.subsecuentes.value=0;
		if(document.frm.adicionales.value=="")
		document.frm.adicionales.value=0;
	if(document.frm.origenes.value=="A99")
		{
		alert("POR FAVOR INDIQUE EL ORIGEN DE LA RUTA");
		document.frm.origenes.focus();
		return false;
		
		}
	else
	if(document.frm.tiros.value=="A99")
		{
		alert("POR FAVOR INDIQUE EL TIRO DE LA RUTA");
		document.frm.tiros.focus();
		return false;
		}
		
		
		
		else return true;
		
}
</script>
<body onload="agrega()">
<table align="center" width="845" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16" />&nbsp;SCA.- Registro de Rutas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm" method="post" action="2Valida.php">
<?php 
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");

?>
<table width="845" border="0" align="center">
 
  <tr>
    <td width="193">&nbsp;</td>
    <td width="121">&nbsp;</td>
    <td colspan="4" align="center" class="EncabezadoTabla">DISTANCIA</td>
  </tr>
  
   <tr>
     <td width="193">&nbsp;</td>
     <td width="121">&nbsp;</td>
     <td width="69" class="EncabezadoTabla">&nbsp;</td>
    <td width="155" align="center" class="EncabezadoTabla">KM'S</td>
    <td width="130" align="center" class="EncabezadoTabla">KM'S</td>
    <td width="151" class="EncabezadoTabla">&nbsp;</td>
  </tr>
   <tr>
     <td width="193" align="center" class="EncabezadoTabla">ORIGEN</td>
     <td width="121" align="center" class="EncabezadoTabla">TIRO</td>
     <td width="69" align="center" class="EncabezadoTabla">1er KM.</td>
     <td align="center" class="EncabezadoTabla">SUBSECUENTES</td>
     <td width="130" align="center" class="EncabezadoTabla">ADICIONALES</td>
     <td width="151" align="center" class="EncabezadoTabla">TOTAL</td>
   </tr>
   
  
   <tr>
  <td align="center">
    <?php combo(origenes,Descripcion,IdOrigen); ?>  </td>
  <td align="center">
    <?php combo(tiros,Descripcion,IdTiro); ?>
  </td>
  <td align="center">
    <input name="primerkm"  class="text"  type="text" readonly="1" value="1" size="1" style="text-align:right"/>
  </td>
  <td align="center">
    <input name="subsecuentes" type="text" size="5" value="0" onkeyup="agrega()" class="text"   onKeyPress="onlyDigitsPunto(event,'decOK')" style="text-align:right"/>
  </td>
  <td align="center">
    <input name="adicionales" type="text" size="5" value="0" onkeyup="agrega()" class="text" onKeyPress="onlyDigitsPunto(event,'decOK')"  style="text-align:right"/>
  </td>
  <td align="center">
    <input name="total" type="text" size="5" value="0" readonly="1" class="text" onkeyup="agrega()" onKeyPress="onlyDigitsPunto(event,'decOK')"  style="text-align:right"/>
  </td>
  </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td align="right">
       <input type="button" name="Bot&oacute;n" class="boton" onclick="if(valida())this.form.submit();" value="Registrar" />
     </td>
   </tr>
</table>
</form>
</body>
</html>
