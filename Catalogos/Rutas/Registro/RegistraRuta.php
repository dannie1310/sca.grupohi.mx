<?php 

	session_start();
	include("../../../Clases/Funciones/Configuracion.php");

	include("../../../inc/php/conexiones/SCA.php");
	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");
	require_once("funciones_xajax.php");

	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	$l = SCA::getConexion();

	
	$xajax->register(XAJAX_FUNCTION,"registra_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_registro_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_consulta_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_modifica_ruta");
	$xajax->register(XAJAX_FUNCTION,"registra_cambio_ruta");
	$xajax->register(XAJAX_FUNCTION,"elimina_ruta");
	$xajax->register(XAJAX_FUNCTION,"muestra_modifica_ruta");

	$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Administraci&oacute;n de Rutas</title>
<link href="../../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
 <?php
   $xajax->printJavascript("../../../Clases/xajax/");
 ?>
<style type="text/css">
<!--
body {
	background-color: #EEE;
}
div#layout{ margin:10px auto;}
-->
</style>
<?php nftcb($_SERVER['PHP_SELF']);?>
</head>
<?php 

?>

<body>
<div id="layout">
<div id="encabezado_pagina" style="width:100%;"><img src="../../../Imagenes/mixing_48x48.gif" width="48" height="48" />Administraci&oacute;n de Rutas</div>
<div class="detalle" id="tipos" style="width:100%;margin-top:20px;"><span class="boton" onclick="xajax_muestra_registro_ruta()"><img src="../../../Imagenes/add.gif" width="24" height="24" align="absbottom" />&nbsp;Registro</span>&nbsp;&nbsp;<span class="boton" onclick="xajax_muestra_modifica_ruta()"><img src="../../../Imagenes/Edit_24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Modificaci&oacute;n</span>&nbsp;&nbsp;<span class="boton" onclick="xajax_muestra_consulta_ruta()"><img src="../../../Imagenes/search.gif" width="24" height="24" align="absbottom" />&nbsp;Consulta</span>
  
</div>
<div id="contenido" style="margin-top:15px">

</div>
</div>
</body>
<script>

</script>
<script type="text/javascript" src="funciones_js.js"></script>

<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/ValidaFormulario.js"></script>
<script type="text/javascript" src="../../../Clases/Js/MuestraLoad.js"></script>

</html>