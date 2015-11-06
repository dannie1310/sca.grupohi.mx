<?php
	session_start();
	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/FuncionesViajesManuales.php");
	
	//Obtenemos el Total de los Viajes a Procesar
		$NumVM=$_POST["NumVM"];
		
	//Obtenemos los Datos de cada uno de los Viajes y los Guardamos en un Arreglo	
		for($a=1;$a<=$NumVM;$a++)
		{
			$NVM[$a]=$_POST["NVM".$a];
			$Fecha[$a]=$_POST["Fecha".$a];
			$Origen[$a]=$_POST["Origen".$a];
			$Destino[$a]=$_POST["Destino".$a];
			//echo "<br>".$_POST["Material".$a];
			$Material[$a]=$_POST["Material".$a];
			//echo "<br>de la variable ".$Material[$a];
			$Economico[$a]=$_POST["Economico".$a];
			$Observacion[$a]=$_POST["Observacion".$a];
			$Turno[$a]=$_POST["Turno".$a];
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="840" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td bordercolor="#FFFFFF" class="EncabezadoPagina"><img src="../../../Imgs/16-tool-a.gif" width="16" height="16" /> SCA.- Registro Manual de Viajes</td>
  </tr>
    <tr>
    <td bordercolor="#FFFFFF" class="EncabezadoPagina">&nbsp;</td>
  </tr>
</table>
<table width="435" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  
  <tr>
    <td width="138" rowspan="3" align="right"><img src="../../../Imgs/question.gif" width="128" height="128" /></td>
    <td width="291" class="TituloDeAdvertencia">¿Son Correctos los Datos</td>
  </tr>
  <tr>
    <td class="TituloDeAdvertencia">De los Viajes Manuales </td>
  </tr>
  <tr>
    <td class="TituloDeAdvertencia">A Registrar en el Sistema?</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm" method="post" action="4AVM.php">
<table width="840" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td align="center"><img src="../../../Imgs/calendarp.gif" width="19" height="21" /></td>
    <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" /></td>        
    <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" /></td>
    <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
    <td colspan="2" align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" /></td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla">#</td>
    <td class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Econ&oacute;mico</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Destino</td>
    <td class="EncabezadoTabla">Material</td>
    <td class="EncabezadoTabla">Turno</td>
  </tr>
  <?php
  	for($a=1;$a<=$NumVM;$a++)
	{
  ?>
  <tr class="Item1">
    <td>&nbsp;<?php echo $a; ?>&nbsp;</td>
    <td>&nbsp;<?php echo $NVM[$a]; ?><input type="hidden" name="NVMS<?php echo $a; ?>" id="NVMS<?php echo $a; ?>" value="<?php echo $NVM[$a]; ?>"/>&nbsp;</td>
    <td>&nbsp;<?php echo $Fecha[$a]; ?><input type="hidden" name="Fechas<?php echo $a; ?>" id="Fechas<?php echo $a; ?>" value="<?php $F=FechaEnIngles($Fecha[$a]); echo $F; ?>"/>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave(Economico, IdCamion, $Economico[$a], IdProyecto, $_SESSION["Proyecto"], camiones); ?><input type="hidden" name="Economicos<?php echo $a; ?>" id="Economicos<?php echo $a; ?>" value="<?php  echo $Economico[$a]; ?>"/>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave(Descripcion, IdOrigen, $Origen[$a], IdProyecto, $_SESSION["Proyecto"], origenes); ?><input type="hidden" name="Origenes<?php echo $a; ?>" id="Origenes<?php echo $a; ?>" value="<?php echo $Origen[$a]; ?>"/>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave(Descripcion, IdTiro, $Destino[$a], IdProyecto, $_SESSION["Proyecto"], tiros); ?><input type="hidden" name="Destinos<?php echo $a; ?>" id="Destinos<?php echo $a; ?>" value="<?php echo $Destino[$a]; ?>"/>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave(Descripcion, IdMaterial, $Material[$a], IdProyecto, $_SESSION["Proyecto"], materiales); ?><input type="hidden" name="Materiales<?php echo $a; ?>" id="Materiales<?php echo $a; ?>" value="<?php echo $Material[$a]; ?>"/>&nbsp;</td>
    <td><?php echo $Turno[$a]; ?><input type="hidden" name="Turno<?php echo $a; ?>" id="Turno<?php echo $a; ?>" value="<?php echo $Turno[$a]; ?>"/></td>
  </tr>
   <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="Item2">Observaciones:</td>
    <td colspan="4" class="Item1"><?php echo $Observacion[$a]; ?>&nbsp;<input type="hidden" name="Observacion<?php echo $a; ?>" id="Observacion<?php echo $a; ?>"  value="<?php echo $Observacion[$a]; ?>"/></td>
  </tr>
  <?php
  	}
  ?>
  <tr>
    <td colspan="8" align="center">&nbsp;</td>
  </tr>
  <tr>
     <td colspan="8" align="center"><input type="hidden" name="NumVM" id="NumVM" value="<?php echo $NumVM; ?>"/><input name="Cargar Viajes" type="submit" class="boton" id="Cargar Viajes" value="Registrar Viajes" />
    &nbsp;&nbsp;&nbsp;&nbsp;
       <input name="button" type="button" class="boton" id="button" value="Modificar" onclick="document.regresar.submit();" />
      </td>
    </tr>
</table>
</form>
<form name="regresar" action="2AVM.php" method="post">
<input name="NumVM" type="hidden" value="<?php echo $NumVM; ?>" />
<input name="flag" type="hidden" value="1" />
<?php 
for($a=1;$a<=$NumVM;$a++)
	{?>
	
    <input type="hidden" name="NVMS<?php echo $a; ?>" id="NVMS<?php echo $a; ?>" value="<?php echo $NVM[$a]; ?>"/>
	<input type="hidden" name="Fechas<?php echo $a; ?>" id="Fechas<?php echo $a; ?>" value="<?php $F=FechaEnIngles($Fecha[$a]); echo $F; ?>"/>
	<input type="hidden" name="Economicos<?php echo $a; ?>" id="Economicos<?php echo $a; ?>" value="<?php  echo $Economico[$a]; ?>"/>
	<input type="hidden" name="Origenes<?php echo $a; ?>" id="Origenes<?php echo $a; ?>" value="<?php echo $Origen[$a]; ?>"/>
	<input type="hidden" name="Destinos<?php echo $a; ?>" id="Destinos<?php echo $a; ?>" value="<?php echo $Destino[$a]; ?>"/>
	<input type="hidden" name="Materiales<?php echo $a; ?>" id="Materiales<?php echo $a; ?>" value="<?php echo $Material[$a]; ?>"/>
	<input type="hidden" name="Observacion<?php echo $a; ?>" id="Observacion<?php echo $a; ?>"  value="<?php echo $Observacion[$a]; ?>"/>

    
	<?php }
?>
</form>
</body>
</html>
