<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script>
function cubicacion()
{
	ancho=parseFloat(quitacomas(document.frm.ancho.value));
	largo=parseFloat(quitacomas(document.frm.largo.value));
	alto=parseFloat(quitacomas(document.frm.alto.value));
	extension=parseFloat(quitacomas(document.frm.extension.value));
	gato=parseFloat(quitacomas(document.frm.gato.value));
	cubicacionr=ancho*largo*(alto+extension)-gato;
	//a=redondear(cubicacionr);
	
	document.frm.creal.value=formateando(String(redondear(cubicacionr,2)));
	document.frm.cpago.value=formateando(String(redondear(cubicacionr,0)));
}
function valida()
{
if(document.frm.sindicatos.value=="A99")
{
	alert("POR FAVOR INDIQUE EL SINDICATO AL QUE PERTENECE EL VEHÍCULO");
	document.frm.sindicatos.focus();
	return false;
}
else
if(document.frm.propietario.value=="")
{
	alert("POR FAVOR INDIQUE EL PROPIETARIO DEL VEHÍCULO");
	document.frm.propietario.focus();
	return false;
}
else
if(document.frm.operadores.value=="A99")
{
	alert("POR FAVOR INDIQUE EL OPERADOR DEL VEHÍCULO");
	document.frm.operadores.focus();
	return false;
}
else
if(document.frm.economico.value=="")
{
	alert("POR FAVOR INDIQUE EL NÚMERO ECONÓMICO DEL VEHÍCULO");
	document.frm.economico.focus();
	return false;
}
else
if(document.frm.placas.value=="")
{
	alert("POR FAVOR INDIQUE LAS PLACAS DEL VEHÍCULO");
	document.frm.placas.focus();
	return false;
}else
if(document.frm.marcas.value=="A99")
{
	alert("POR FAVOR INDIQUE LA MARCA DEL VEHÍCULO");
	document.frm.marcas.focus();
	return false;
}


else

if(document.frm.modelo.value=="")
{
	alert("POR FAVOR INDIQUE EL MODELO DEL VEHÍCULO");
	document.frm.modelo.focus();
	return false;
}
else

if(document.frm.ancho)
{	
	if((document.frm.ancho.value!=".")&&(document.frm.ancho.value!=""))
		{
			an=document.frm.ancho.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE EL ANCHO DEL VEHÍCULO");
				document.frm.ancho.focus();
				return false;
			}
		}
		else
		if((document.frm.ancho.value==".")||(document.frm.ancho.value==""))
		{
				alert("POR FAVOR INDIQUE EL ANCHO DEL VEHÍCULO");
				document.frm.ancho.focus();
				return false;
		}
		
}
if(document.frm.largo)
{ 
	if((document.frm.largo.value!=".")&&(document.frm.largo.value!=""))
		{
			an=document.frm.largo.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE EL LARGO DEL VEHÍCULO");
				document.frm.largo.focus();
				return false;
			}
		}
		else
		if((document.frm.largo.value==".")||(document.frm.largo.value==""))
		{
				alert("POR FAVOR INDIQUE EL LARGO DEL VEHÍCULO");
				document.frm.largo.focus();
				return false;
		}
}
if(document.frm.alto)
{
	if((document.frm.alto.value!=".")&&(document.frm.alto.value!=""))
		{
			an=document.frm.alto.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE EL ALTO DEL VEHÍCULO");
				document.frm.alto.focus();
				return false;
			}
		}
		else
		if((document.frm.alto.value==".")||(document.frm.alto.value==""))
		{
				alert("POR FAVOR INDIQUE EL ALTO DEL VEHÍCULO");
				document.frm.alto.focus();
				return false;
		}
}
if(document.frm.creal)
{
	if((document.frm.creal.value!=".")&&(document.frm.creal.value!=""))
		{
			an=document.frm.creal.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE LA CUBICACIÓN REAL DEL VEHÍCULO");
				document.frm.creal.focus();
				return false;
			}
		}
		else
		if((document.frm.creal.value==".")||(document.frm.creal.value==""))
		{
				alert("POR FAVOR INDIQUE LA CUBICACIÓN REAL DEL VEHÍCULO");
				document.frm.creal.focus();
				return false;
		}
}

if(document.frm.cpago)
{
	if((document.frm.cpago.value!=".")&&(document.frm.cpago.value!=""))
		{
			an=document.frm.cpago.value;
			ancho=parseFloat(an);
			//alert(ancho);
			if(ancho<=0)
			{
				alert("POR FAVOR INDIQUE LA CUBICACIÓN PARA PAGO DEL VEHÍCULO");
				document.frm.cpago.focus();
				return false;
			}
		}
		else
		if((document.frm.cpago.value==".")||(document.frm.cpago.value==""))
		{
				alert("POR FAVOR INDIQUE LA CUBICACIÓN PARA PAGO DEL VEHÍCULO");
				document.frm.cpago.focus();
				return false;
		}
}

if(document.frm.botones.value=="A99")
{
	alert("POR FAVOR INDIQUE EL DISPOSITIVO ELECTRÓNICO");
	document.frm.botones.focus();
	return false;
}
else
{
return true;
}
}

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
	
</script>

</script>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

<body>
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;SCA.- Registro de Camiones</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form action="2Verifica.php" method="post" name="frm">
<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
?>
<table width="600" border="0" align="center">
  <tr>
    <td width="31">&nbsp;</td>
    <td width="80">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
    <td width="140" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="102" colspan="2"><?PHP echo date("d-m-Y"); ?>
    <input type="hidden" name="fecha" value="<?PHP echo date("Y-m-d"); ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO: </td>
    <td colspan="6"><?php combo(sindicatos,NombreCorto,IdSindicato) ?>
      &nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td>&nbsp;</td>
    <td colspan="4">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto">PROPIETARIO:</td>
    <td colspan="4"><input name="propietario"  type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" size="50" maxlength="30" /></td>
    <td width="10" colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="120" >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto" >OPERADOR:</td>
    <td width="470" ><?php comboProyecto(operadores,Nombre,IdOperador,$IdProyecto); ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="212">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Concepto">NO. ECON&Oacute;MICO: </td>
    <td><input name="economico" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" /></td>
    <td class="Concepto">PLACAS:</td>
    <td colspan="2"><input name="placas" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" /></td>
  </tr>
  <tr>
    <td width="11">&nbsp;</td>
    <td width="108">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="160">&nbsp;</td>
    <td width="16">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Concepto">MARCA:</td>
    <td><?php combo(marcas,Descripcion,IdMarca); ?></td>
    <td width="67" class="Concepto">MODELO:</td>
    <td colspan="2"><input name="modelo" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="120" class="Concepto" >ASEGURADORA:</td>
    <td width="470" colspan="3"><input name="aseguradora" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" size="50" maxlength="30" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="130" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="169" ><input name="poliza" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" /></td>
    <td width="17">&nbsp;</td>
    <td width="137" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="125" ><span class="Datos2">
      <input name="vigencia" type="text" class="text" id="vigencia" value="00-00-0000" size="10" maxlength="10" onchange="this.value=ValidaFecha(this.value,'<?php echo date("d-m-Y"); ?>');" />
    <img src="../../../Imgs/calendarp.gif" name="boton" width="19" height="21" id="boton" style="cursor:hand" /></span></td>
  </tr>
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="8"><div align="center" class="Titulo">INFORMACI&Oacute;N ADICIONAL DEL CAMI&Oacute;N </div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" class="Subtitulo">INGRESE LOS DATOS QUE SE SOLICITAN A CONTINUACI&Oacute;N EN METROS (m) </td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="55" class="Concepto">ANCHO:</td>
    <td width="74"><input name="ancho" type="text" class="text"  style="text-align:right"  onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0.00" size="5" />
      m</td>
    <td width="67" class="Concepto" >LARGO:</td>
    <td width="82" ><input name="largo" type="text" class="text" style="text-align:right"  onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0.00" size="5" />
      m</td>
    <td width="47" class="Concepto">ALTO:</td>
    <td width="81"><input name="alto" type="text" class="text" style="text-align:right" onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0.00" size="5" />
      m</td>
    <td width="77" class="Concepto" >EXTENSI&Oacute;N:</td>
    <td width="83" ><input name="extension" type="text" class="text" style="text-align:right"  onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0.00" size="5" />
      m</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="122" >&nbsp;</td>
    <td width="72">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="77"><input name="gato" type="text" class="text" style="text-align:right"  onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0.00" size="5" />
    m</td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td><input name="creal" type="text" class="text" style="text-align:right" onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0.00" size="5" readonly="1" />
    m<sup>3</sup></td>
    <td width="177" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="74" ><input name="cpago" type="text" class="text" style="text-align:right"  onKeyPress="onlyDigitsPunto(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="0" size="5" readonly="1" />
    m<sup>3</sup></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td width="192" class="Concepto" >DISPOSITIVO ELECTRONICO:</td>
    <td width="163"><?php comboBoton(botones,Identificador,IdBoton); ?></td>
    <td width="137" >&nbsp;</td>
    <td width="90" >&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  <tr>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td >&nbsp;</td>
    <td width="190">&nbsp;</td>
    <td width="137" ><input name="Submit2" type="reset" class="boton" value="Limpiar" /></td>
    <td width="90" ><input name="Submit" type="button" class="boton" onclick="if(valida())this.form.submit()" value="Registrar" /></td>
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
