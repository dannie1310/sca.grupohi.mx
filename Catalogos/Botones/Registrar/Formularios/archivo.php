<?php 
	include("../../../../inc/php/conexiones/SCA.php");
$l = SCA::getConexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="frm_boton_archivo" id="frm_boton_archivo"  method="post" enctype="multipart/form-data" action="procesa_archivo.php">
<table width="508" border="1" style="width:auto" class="formulario">
  <tr>
    <td class="detalle"><div id="div_estado"><img src="../../../../Imagenes/alert-16.gif" width="16" height="16" />Indique la ruta del archivo del cual se tomar&aacute;n los datos de los botones</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table style="width:100%" border="0" align="center" cellpadding="0" cellspacing="0">
      
      <tr>
        <td colspan="2" align="center"><input name="archivo_botones" type="file" class="texto" id="archivo_botones" /></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td width="199" align="center">&nbsp;</td>
        <td width="361" align="right"><button class="boton" onclick="this.form.submit()"><img src="../../../../Imagenes/upload.gif" width="16" height="16" />Registrar</button></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
