<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCA.-Registro de Maquinaria</title>

<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script>
function valida(f)
{
	form=document.getElementById(f);
	vacios=0;
	completos=0;
	for(m=0;m<form.length-1;m++)
	{
		if(form[m].value==''||form[m].value=='A99')
		{
			
			form[m].style.borderColor="#F00";
			form[m].style.backgroundColor="#FCC";
			vacios++;
		}
		else
		{
			form[m].style.borderColor="#090";
			form[m].style.backgroundColor="#DFFFDF";
		}
		//alert(form[m].value);	
	}
	//alert(vacios);	
	if(vacios>0)
	{
		return false;
	}
	else
	{
		if (confirm("¿REALMENTE DESEA REGISTRAR EL EQUIPO?"))
		{
		return true;
		}
		else
		{
		return false;
		}
	}
}
</script>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="frm" id="frm" method="post" action="2Registra.php" onSubmit="return valida(this.id)">
<table width="500" border="0">
  <tr>
    <td align="center" class="Concepto">Arrendador</td>
    <td colspan="2" align="center" class="Concepto">Tipo de Equipo</td>
    <td align="center" class="Concepto">Origen</td>
  </tr>
  
  <tr class="Item1">
    <td align="center" ><?php combo("maquinaria_arrendadores","NombreCorto","IdArrendador")?></td>
    <td colspan="2" align="center" ><?php combo("maquinaria_tipos","Descripcion","IdTipo")?></td>
    <td align="center" ><?php combo("maquinaria_relacion","Descripcion","IdRelacion")?></td>
  </tr>
   <tr class="Concepto" >
     <td align="center" >Marca</td>
     <td colspan="2" align="center" >Modelo</td>
     <td align="center" >Serie</td>
   </tr>
   <tr class="Item1" >
     <td align="center" ><input name="marca" type="text" class="Casillas_small" id="marca" size="15" maxlength="50"></td>
     <td colspan="2" align="center" ><input name="modelo" type="text" class="Casillas_small" id="modelo" size="18" maxlength="50"></td>
     <td align="center" ><input name="serie" type="text" class="Casillas_small" id="serie" size="18" maxlength="50"></td>
   </tr>
   <tr class="Concepto" >
     <td align="center" >Marca Motor</td>
     <td colspan="2" align="center" >Modelo Motor</td>
     <td align="center" >Serie Motor</td>
   </tr>
   <tr class="Item1" >
     <td align="center" ><input name="marca_motor" type="text" class="Casillas_small" id="economico2" size="15" maxlength="20"></td>
     <td colspan="2" align="center" ><input name="modelo_motor" type="text" class="Casillas_small" id="economico3" size="18" maxlength="20"></td>
     <td align="center" ><input name="serie_motor" type="text" class="Casillas_small" id="economico4" size="18" maxlength="20"></td>
   </tr>
   <tr class="Concepto" >
    <td align="center" >Económico</td>
    <td align="center" >Estado Equipo</td>
    <td align="center">Fecha Llegada</td>
    <td align="center" >Fecha Salida</td>
  </tr>
  
  
  <tr class="Item1">
    <td align="center" >
      <input name="economico" type="text" class="Casillas_small" id="economico" size="10" maxlength="20" >
    </td>
    <td align="center" ><?php combo("maquinaria_estatus","NombreCorto","IdEstatus")?></td>
    <td align="center" class="Item1"><input name="f_llegada" type="text" class="Casillas_small" id="f_llegada" size="8" maxlength="10">
    <img src="../../../Imgs/calendarp.gif" width="19" height="21" id="bf_llegada" style="cursor:hand"></td>
    <td align="center" ><input name="f_salida" type="text" class="Casillas_small" id="f_salida" size="8" maxlength="10">
    <img src="../../../Imgs/calendarp.gif" width="19" height="21" id="bf_salida" style="cursor:hand"></td>
  </tr>
  <tr>
     <td colspan="4" align="right"><label>
       <input name="button" type="submit" class="boton" id="button" value="Registrar">
     </label></td>
  </tr>
</table>
</form>
</body>
<script type="text/javascript">
			function catcalc(cal) {
		
			}
			Calendar.setup({
				inputField     :    "f_salida",			
				button		   :	"bf_salida",
				ifFormat       :    "%d-%m-%Y",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
			
			function catcalc(cal) {
		
			}
			Calendar.setup({
				inputField     :    "f_llegada",			
				button		   :	"bf_llegada",
				ifFormat       :    "%d-%m-%Y",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
		</script>
</html>