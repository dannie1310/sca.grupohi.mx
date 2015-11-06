<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
</head>

<body onkeydown="backspace();">
<?php
	//Incluimos los Archivos a Usar
		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");

	//Obtenemos los Totales a Trabajar
		$TotalViajesCompletos=RegresaTotalViajesCompletosCargados($_SESSION['Proyecto']);
		$TotalViajesIncompletos=RegresaTotalViajesIncompletosCargados($_SESSION['Proyecto']);
		$TotalViajesManuales=RegresaTotalViajesManualesCargados($_SESSION['Proyecto']);

?>
<table width="845" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td class="Concepto">Usted Cuenta con los Siguientes Viajes Pendietes de Revisar: </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>  </tr>
</table>
<table width="415" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td width="53">&nbsp;</td>
    <td width="123">&nbsp;</td>
  </tr>
  <tr>
		<form name="frm" method="post" action="2VerificaVC.php">
		<td width="34"><img src="../../Imgs/16-PuntaVerde.gif" width="24" height="24" /></td>
		<td width="205" class="Item1">Viajes Con Orígen:</td>
		<td class="Item1"><?php echo $TotalViajesCompletos; ?></td>
		<td class="Item1"><input name="Validar" type="submit" class="boton" id="Validar" value="Validar" /></td>
	</form>
  </tr>
  <tr>
  	<form name="frm" method="post" action="2VerificaVI.php">
		<td><img src="../../Imgs/16-PuntaVerde.gif" width="24" height="24" /></td>
		<td class="Item1">Viajes Sin Orígen:</td>
	  <td class="Item1"><?php echo $TotalViajesIncompletos; ?></td>
	  <td class="Item1"><input name="Validar" type="submit" class="boton" id="Validar" value="Validar" />	</td>
	</form>
  </tr>
  <tr>
  	<form name="frm" method="post" action="2VerificaVM.php">
		<td><img src="../../Imgs/16-PuntaVerde.gif" width="24" height="24" /></td>
		<td class="Item1">Viajes Cargados Manualmente:</td>
	  <td class="Item1"><?php echo $TotalViajesManuales; ?></td>
	  <td class="Item1"><input name="Validar" type="submit" class="boton" id="Validar" value="Validar" />	</td>
	</form>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
