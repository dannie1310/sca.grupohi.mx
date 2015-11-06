<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script src="../../../Clases/Js/Cajas.js"></script>
<script src="../../../Clases/Js/Genericas.js"></script>


<script>
function ValidaFecha(fecha2,fecha1) 
	{	//fecha2 es la vigencia; 
		//fecha1 es hoy
		
		//alert('validafecha("'+fecha1+'"'+fecha2+'")');
		
		var ano1= parseInt(String(fecha1.substring(fecha1.lastIndexOf("-")+1,fecha1.length)),10);
		var resto=new String(fecha1.substring(0,fecha1.lastIndexOf("-")));
		var mes1= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia1= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		

		
		var ano3= parseInt(String(fecha2.substring(fecha2.lastIndexOf("-")+1,fecha2.length)),10);
		var resto=new String(fecha2.substring(0,fecha2.lastIndexOf("-")));
		var mes3= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia3= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);		
	if(fecha2!="00-00-0000"&&fecha2!="")
	{
		
		if(ano3>ano1)
			ok=1;
		else
		{
			if(ano3==ano1)
				{
					if(mes3>mes1)
					{
						ok=1;
					}
					else
					{
						if(mes3==mes1)
						{
							if(dia3>dia1)
								ok=1;
							else
							{
								if(dia3==dia1)
									{ok=1;}
								else
									ok=0;
							}
						}
						else
							ok=0;				
					}
				}
			else
				ok=0;
		}
		
		

		if(!ok)
		{
			alert('ERROR: La Fecha de Vigencia no Puede ser Menor a la Fecha Actual');
			var regresa1=fecha1;
			return regresa1;
		}
		else{
			var regresa=fecha2;
			return regresa;
			}
		
	}
	return fecha2;	
	}
	
function valida()
{
	if(document.frm.nombre.value=='')
	{
		alert("INDIQUE EL  NOMBRE DEL OPERADOR");
		document.frm.nombre.focus();
		return false;
	}
	else
	if(document.frm.direccion.value=='')
	{
		alert("INDIQUE LA DIRECCIÓN DEL OPERADOR");
		document.frm.direccion.focus();
		return false;
	}
	else
	return true;
}
</script>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Member.gif" width="16" height="16" />&nbsp;SCA.- Registro de Operadores</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<form action="2Valida.php" method="post" name="frm">
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8" class="Subtitulo">POR FAVOR INDIQUE LOS DATOS DEL OPERADOR </td>
  </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
    <tr>
    <td width="103">&nbsp;</td>
    <td width="152">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="148" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="159" colspan="2"><?PHP echo date("d-m-Y"); ?>
    <input type="hidden" name="fecha" value="<?PHP echo date("Y-m-d"); ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
 
</table>

<table width="600" border="0" align="center">
  
  <tr>
    <td width="115" class="Concepto">NOMBRE:</td>
    <td colspan="3"><input name="nombre" type="text" class="text"  style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" size="80"  /></td>
  </tr>
  <tr>
    <td  class="ConceptoTop" valign="top">DIRECCI&Oacute;N:</td>
    <td colspan="3"><textarea name="direccion" cols="60"  style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" ></textarea></td>
  </tr>
  <tr>
    <td class="Concepto">No. LICENCIA: </td>
    <td width="154"><input name="licencia" type="text" class="text"  style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')"  /></td>
    <td width="86" class="Concepto">VIGENCIA:</td>
    <td width="227"><span class="Datos2">
      <input name="vigencia" type="text" class="text" id="vigencia" value="00-00-0000" size="13" maxlength="10" onchange="this.value=ValidaFecha(this.value,'<?php echo date("d-m-Y"); ?>');" />
    </span><span class="Datos2"><img src="../../../Imgs/calendarp.gif" name="boton" width="19" height="21" id="boton" style="cursor:hand" /></span></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="107">&nbsp;</td>
    <td width="175">&nbsp;</td>
    <td width="174"><div align="right">
      <input name="Submit" type="reset" class="boton" value="Limpiar" />
    </div></td>
    <td width="116"><div align="right">
      <input name="Submit2" type="button" class="boton" onclick="if(valida())this.form.submit()" value="Registrar" />
    </div></td>
  </tr>
</table>
<script type="text/javascript">
			function catcalc(cal) {
		
			}
			Calendar.setup({
				inputField     :    "vigencia",			
				button		   :	"boton",
				ifFormat       :    "%d-%m-%Y ",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
		</script>
</form>
</body>
</html>
