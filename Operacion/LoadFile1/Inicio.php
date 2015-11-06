<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/LoadFile.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/LoadingPage.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../Clases/js/CP.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<style type="text/css">
<!--
.Estilo1 {
	color: #006699;
	font-weight: bold;
	font-style: italic;
	font-size: 14px;
}
-->
</style>
</head>

<body onkeydown="backspace();">
<table width="845" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
		<form name="frm" method="post" enctype="multipart/form-data" action="VerViajesBase.php" >

			<table width="536" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="186" rowspan="8"><img src="../../Imgs/CargarArchivo.jpg" width="178" height="157" /></td>
				<td width="350">&nbsp;</td>
			  </tr>
			  <tr>
				<td><span class="Estilo1">Seleccione el Archivo a Cargar al Sistema </span></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td align="center"><input name="archivo" class="text" type="file" /></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center"><input name="Submit" type="submit" class="boton" value="Cargar Archivo" /></td>
		      </tr>
			  <tr>
			    <td>&nbsp;</td>
		      </tr>
			</table>
		</form>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
