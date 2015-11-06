<?php 

	session_start();
	include("../../Clases/Funciones/Configuracion.php");

	include("../../inc/php/conexiones/SCA.php");
	require_once("../../Clases/xajax/xajax_core/xajax.inc.php");

	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	

	$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factor de Abundamiento</title>
<link href="../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
 <?php
   $xajax->printJavascript("../../Clases/xajax/");
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
<div id="encabezado_pagina" style="width:100%;"><img src="../../Imagenes/Encabezados/kgoldrunner.gif" width="48" height="48" />Factor de Abundamiento</div>
<div class="detalle" id="tipos" style="width:100%;margin-top:20px;">

<div id="menu_principal"><ul>
      <li  ><a href="x_material.php">Por Material</a></li>
      <li ><a href="x_banco_material.php">Por Banco y Material</a></li></ul></div>
</div>

</div>
<div id="contenido" style="margin-top:15px">

</div>
</div>
</body>
<script>

</script>

<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<script type="text/javascript" src="../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../Clases/Js/ValidaFormulario.js"></script>
<script type="text/javascript" src="../../Clases/Js/MuestraLoad.js"></script>

</html>