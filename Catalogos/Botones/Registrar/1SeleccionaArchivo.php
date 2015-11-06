<?php 
session_start();
	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");
	require_once("Funciones_Clases/funciones_xjx.php");
	include("../../../inc/php/conexiones/SCA.php");

	$l = SCA::getConexion(); 

	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
$xajax->configure('decodeUTF8Input',true);
	$xajax->register(XAJAX_FUNCTION,"formulario_manual");
	$xajax->register(XAJAX_FUNCTION,"formulario_archivo");
	$xajax->register(XAJAX_FUNCTION,"registra_boton");


	$xajax->processRequest();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro de  Botones</title>
<link href="../../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
 <?php
   $xajax->printJavascript("../../../Clases/xajax/");
 ?>
</head>

<body>
<table width="200" border="1" class="formulario">
  <tr>
    <td class="BGTitulo"><div id="div_titulo">
      <div id="titulo_seccion"><img src="../../../Imagenes/Encabezados/botones.gif" width="16" height="16" />Registrar Botones</div></div></td>
  </tr>
  <tr>
    <td>
    <table style="width:100%" border="1">
  <tr>
    <td colspan="3" class="detalle"><span class="boton" onclick="xajax_formulario_manual()">[REGISTRO MANUAL]</span>&nbsp;<span class="boton" onclick="xajax_formulario_archivo()">[REGISTRO POR ARCHIVO]</span></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><DIV id="div_contenido"></DIV></td>
    </tr>
</table>

    </td>
  </tr>
</table>
<script src="../../../Clases/Js/ValidaFormulario.js"></script>
</body>
</html>