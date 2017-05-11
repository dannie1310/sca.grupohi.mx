<?php 

	session_start();
        if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }
	include("../../../inc/php/conexiones/SCA.php");
	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");
	include("../../../Clases/Funciones/Configuracion.php");

	require_once("funciones_xajax.php");

	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	$l = SCA::getConexion();
	
	

	
	$xajax->register(XAJAX_FUNCTION,"registra_tarifa_material");
	$xajax->register(XAJAX_FUNCTION,"registra_tarifa_peso");
	$xajax->register(XAJAX_FUNCTION,"registra_tarifa_tipo_ruta");
	$xajax->register(XAJAX_FUNCTION,"tarifa_material");
	$xajax->register(XAJAX_FUNCTION,"tarifa_ruta");
	$xajax->register(XAJAX_FUNCTION,"tarifa_peso");




	$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registro de Tarifas</title>
<link href="../../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
 <?php
   $xajax->printJavascript("../../../Clases/xajax/");
 ?>
<style type="text/css">
<!--
body {
	background-color: #EEE;
}
-->
</style>
<?php nftcb($_SERVER['PHP_SELF']);?>
</head>
<?php 

?>

<body>
<div id="layout">
<div id="encabezado_pagina" style="width:100%;"><img src="../../../Imagenes/tarifas.gif" width="48" height="48" />Registro de Tarifas</div>
<div class="detalle" id="tipos" style="width:100%;margin-top:20px;">
<span class="boton" onclick="xajax_tarifa_material()"><img src="../../../Imagenes/materiales_24x24.gif" width="24" height="21" align="absbottom" />&nbsp;Tarifa por Material</span>&nbsp;&nbsp;
<span class="boton" onclick="xajax_tarifa_ruta()"><img src="../../../Imagenes/ruta24x24.gif" width="24" height="24" align="absbottom" />&nbsp;Tarifa por Tipo de Ruta</span>&nbsp;&nbsp;
<span class="boton" onclick="xajax_tarifa_peso()"><img src="../../../Imgs/16-file-archive.gif" width="16" height="16" />&nbsp;Tarifa por Peso</span>
  
</div><div id="contenido" style="margin-top:15px">

</div>
</div>
</body>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="ValidaFormulario.js"></script>
</html>