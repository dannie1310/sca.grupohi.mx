<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>

<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;SCA.- Consulta de Destinos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<form name="frm" method="post" action="../../../Catalogos/Destinos/Consulta/XLS/1Muestra.php" target="_blank">
<table border="1" align="center" bordercolor="#FFFFFF">
  <tr>
    <td>Haz Click en la Imagen para Ver El Reporte en EXCEL </td>
  </tr>
  <tr>
    <td align="center"><img src="../../../Imgs/ExcelIcon.jpg" width="128" height="128" onclick="document.frm.submit()" style="cursor:hand"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
