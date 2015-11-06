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
<form name="frm_boton_manual" id="frm_boton_manual">
<table width="508" border="1" style="width:auto">
  <tr>
    <td class="detalle"><div id="div_estado"><img src="../../../Imagenes/alert-16.gif" width="16" height="16" />Ingrese los datos que se solicitan a continuaci&oacute;n</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="300" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr class="Item1">
        <td width="199" align="center"><strong>Identificador</strong></td>
        <td width="361" align="center"><strong>Tipo de Bot&oacute;n</strong></td>
      </tr>
      
      <tr class="Item">
        <td align="center"><label>
          <input name="identificador" type="text" class="texto" id="identificador" />
          </label></td>
        <td align="center"><?php $l->regresaSelectBasico("tiposbotones","IdTipoBoton","Descripcion","Estatus=1","desc",true); ?></td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right"><input type="button" class="boton" value="Registrar" onclick="if(valida(this.form.id,'&iquest; Est&aacute; seguro de Registrar el Bot&oacute;n ?')){xajax_registra_boton(xajax.getFormValues('frm_boton_manual'))}"/></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
