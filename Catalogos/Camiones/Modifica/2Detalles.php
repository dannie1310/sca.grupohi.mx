<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
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
function cambiaNuevo(id)
{
	//alert(id);
 if (!document.getElementById) return false;
  elemento = document.getElementById(id);
 if(document.frm.BotonesN.value=="A99")
      elemento.style.display = "none"; //ocultar fila 
 else if(document.frm.BotonesN.value!="A99")
    elemento.style.display = ""; //mostrar fila 
  
}
function envia()
{ 
fila = document.getElementById('estatusn');
	if(fila.style.display != "none")
	{	
		
		if(document.frm.estatusnb[0].checked==false&&document.frm.estatusnb[1].checked==false&&document.frm.estatusnb[2].checked==false)
		{
			nuevo=document.frm.botona.value;
			alert("INDIQUE EL ESTATUS NUEVO PARA EL BOTON ACTUAL "+nuevo);
		}
		else
		document.frm.submit();
	}
	else
	{
		document.frm.submit();
	}
	
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
		
}


envia();



}

function ValidaFecha(fecha2,fecha1) 
	{	//fecha2 es la vigencia; 
		//fecha1 es hoy
		
		
		
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
		alert("relse");
			var regresa=fecha2;
			return regresa;
			}
		
	}
		else
		{
		
		regresa="00-00-0000";
		return regresa;	
		}
	}
	
</script>

</script>

</head>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();" onload="cambiaNuevo('estatusn')">
<table align="center" width="600" border="0">
  <tr>
    <td width="595" class="EncabezadoPagina"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Camiones</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form action="3Valida.php" method="post" name="frm">
<?php 
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");
$camion=$_REQUEST[camion];
$sql="select * from camiones where IdProyecto=$IdProyecto and idcamion=$camion";
$link=SCA::getConexion();
$r=$link->consultar($sql);
$v=mysql_fetch_array($r);
?>
<table width="600" border="0" align="center">
  <tr>
    <td width="71">&nbsp;</td>
    <td width="120">&nbsp;</td>
    <td width="130" ><input type="hidden" name="camion" value="<?php echo $camion; ?>" /></td>
    <td width="140" class="Concepto">FECHA DE REGISTRO: </td>
    <td width="117" colspan="2"><?PHP echo fecha($v[FechaAlta]); ?>
    <input type="hidden" name="fecha" value="<?PHP echo date("Y-m-d"); ?>" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="120" class="Concepto" >SINDICATO: </td>
    <td colspan="6"><?php comboSelected(sindicatos,NombreCorto,IdSindicato,$v[IdSindicato]) ?>
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
    <td colspan="4"><input name="propietario"  type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php echo $v[Propietario]; ?>" size="50" maxlength="30" /></td>
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
    <td width="470" ><?php comboSelectedProyecto(operadores,Nombre,IdOperador,$v[IdOperador],$IdProyecto) ?></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="257">&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Concepto">NO. ECON&Oacute;MICO: </td>
    <td><input name="economico" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php echo $v[Economico] ?>" /></td>
    <td class="Concepto">PLACAS:</td>
    <td colspan="2"><input name="placas" type="text" class="text" style="text-transform:uppercase" onkeypress="withoutSpaces(event,'decOK')" value="<?php echo $v[Placas] ?>" /></td>
  </tr>
  <tr>
    <td width="5">&nbsp;</td>
    <td width="113">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td width="139">&nbsp;</td>
    <td width="7">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="Concepto">MARCA:</td>
    <td><?php comboSelected(marcas,Descripcion,IdMarca,$v[IdMarca]); ?></td>
    <td width="53" class="Concepto">MODELO:</td>
    <td colspan="2"><input name="modelo" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php echo $v[Modelo] ?>" /></td>
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
    <td width="470" colspan="3"><input name="aseguradora" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php echo $v[Aseguradora] ?>" size="50" maxlength="30" /></td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td width="132" class="Concepto" >POLIZA DE SEGURO: </td>
    <td width="153" ><input name="poliza" type="text" class="text" style="text-transform:uppercase" onKeyPress="withoutSpaces(event,'decOK')" value="<?php echo $v[PolizaSeguro] ?>" /></td>
    <td width="10">&nbsp;</td>
    <td width="124" class="Concepto" >VIGENCIA POLIZA: </td>
    <td width="159" ><span class="Datos2">
      <input value="<?php echo fecha($v[VigenciaPolizaSeguro]) ?>" name="vigencia" type="text" class="text" id="vigencia"  size="10" maxlength="10" onchange="this.value=ValidaFecha(this.value,'<?php echo date("d-m-Y"); ?>');" />
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
    <td width="46" class="Concepto">ANCHO:</td>
    <td width="90"><input name="ancho"  type="text" style="text-align:right " class="text"   onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[Ancho],2,".",",") ?>" size="5" />
      m</td>
    <td width="55" class="Concepto" >LARGO:</td>
    <td width="91" ><input name="largo" type="text" class="text" style="text-align:right " onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[Largo],2,".",",") ?>" size="5" />
      m</td>
    <td width="40" class="Concepto">ALTO:</td>
    <td width="90"><input name="alto" type="text" class="text" style="text-align:right "  onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[Alto],2,".",",") ?>" size="5" />
      m</td>
    <td width="64" class="Concepto" >EXTENSI&Oacute;N:</td>
    <td width="90" ><input name="extension" type="text" class="text" style="text-align:right" onKeyPress="onlyDigits(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[AlturaExtension],2,".",",") ?>" size="5" />
      m</td>
  </tr>
</table>
<table width="600" border="0" align="center">
  
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="124" >&nbsp;</td>
    <td width="71">&nbsp;</td>
    <td colspan="2" >&nbsp;</td>
  </tr>
  <tr>
    <td width="52" class="Concepto">GATO:</td>
    <td width="85"><input name="gato" type="text" class="text"  onKeyPress="onlyDigits(event,'decOK')" style="text-align:right " onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[Gato],2,".",",") ?>" size="5" />
    m</td>
    <td class="Concepto" >CUBICACI&Oacute;N REAL:</td>
    <td><input name="creal" type="text" class="text"  onKeyPress="onlyDigits(event,'decOK')" style="text-align:right " onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[CubicacionReal],2,".",",") ?>" size="5" readonly="1" />
    m<sup>3</sup></td>
    <td width="175" class="Concepto" >CUBICACI&Oacute;N PARA PAGO:</td>
    <td width="67" ><input name="cpago" type="text" class="text" style="text-align:right "  onKeyPress="onlyDigitsPunto(event,'decOK')" onKeyUp="this.value=formateando(this.value);cubicacion()" value="<?php echo number_format($v[CubicacionParaPago],2,".",",") ?>" size="5" readonly="1" />
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
    <tr>
    <td width="200" class="Concepto" >DISPOSITIVO ELECTRONICO</td>
    <td width="190"><span class="textoG">ACTUAL:</span>&nbsp;<?php regresa(botones,Identificador,IdBoton,$v[IdBoton]); ?> <input name="botonv" type="hidden" value="<?php echo $v[IdBoton]; ?>" /><input type="hidden" name="botona" value="<?php regresa(botones,Identificador,IdBoton,$v[IdBoton]); ?>" /></td>
    <td width="80" class="Concepto" >DISPONIBLES:  </td>
    <td width="147" >
	
	
		 <select name="BotonesN" onchange="cambiaNuevo('estatusn')">
			  <option value="A99">- SELECCIONE -</option>
			  <?PHP 
			  $ls=SCA::getConexion();
			  $sql="select * from botones where TipoBoton=2 and Estatus=1 order by Identificador asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			  $ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option   value="<?php echo $row[IdBoton]; ?>"><?php echo $row[Identificador]; ?></option>
			   <?php 
			   }
			   ?>
	    </select>
	
	
	</td>
  </tr>
  </tr>
</table>
<table width="600" border="0" align="center" id="estatusn" style="display:none " >
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>POR FAVOR INDIQUE EL NUEVO ESTATUS PARA EL BOT&Oacute;N: 
      <?php regresa(botones,Identificador,IdBoton,$v[IdBoton]); ?></td>
  </tr>
  <tr>
    <td><input name="estatusnb" type="radio" value="0" />
      INACTIVO
        <input name="estatusnb" type="radio" value="1" />
        ACTIVO
        <input name="estatusnb" type="radio" value="3" />
        PERDIDO</td>
  </tr>
</table><table width="600" border="0" align="center">
  <tr>
    <td width="72">&nbsp;</td>
    <td width="518">&nbsp;</td>
  </tr>
  <tr>
    <td class="Concepto">ESTATUS:</td>
    <td><select name="estatus">
	  <option value="0" <?PHP if($v[Estatus]==0) echo "selected"; ?>>INACTIVO</option>
	  <option value="1" <?PHP if($v[Estatus]==1) echo "selected"; ?>>ACTIVO</option>
      </select>   </td>
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
<table width="600" border="0" align="center">
  <tr>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <form action="1Muestra.php" name="frm2" method="post"> 
      <td >
        <div align="left">
          <input name="Submit" type="submit" class="boton" onClick="history.go(-1)" value="Regresar" />
        </div></td></form>
    <td width="190">&nbsp;</td>
    <td width="137" ><input name="Submit2" type="reset" class="boton" value="Limpiar" /></td>
    <td width="90" > <input name="Submit2" type="submit" class="boton" onclick="valida();" value="Modificar" /></td>
  </tr>
</table>

</body>
</html>
