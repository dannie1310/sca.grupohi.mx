<?php 

	session_start();
	include("../../../Clases/Funciones/Configuracion.php");
	include("../../../inc/php/conexiones/SCA.php");
	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");

	$SCA = SCA::getConexion(); 


	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	
	function registra_fad($id_material, $fad)
	{
		$rpt=new xajaxResponse();
		$SCA = $GLOBALS["SCA"];
		$SQLs = "call sca_administra_fad_material(".$id_material.",".$fad.",".$_SESSION["IdUsuarioAc"].",@resultado)";
		$SCA->consultar($SQLs);
		$r = $SCA->consultar("select @resultado");
		$v = $SCA->fetch($r);
		$respuesta = $v["@resultado"];
		$rex = explode("-",$respuesta);
		$rpt->assign("OK","style.display","none");
		$rpt->assign("KO","style.display","none");
		$rpt->assign($rex[0],"innerHTML",utf8_decode($rex[1]));
		if($rex[1]!=""){
		$rpt->assign($rex[0],"style.display","block");
		}
		return $rpt;
	}
	
	$xajax->register(XAJAX_FUNCTION,"registra_fad");


	$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Factor de Abundamiento</title>
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
<?php  nftcb($_SERVER['PHP_SELF']);?>
</head>
<?php 

?>

<body>
<div id="layout">
<div id="encabezado_pagina" style="width:100%;"><img src="../../../Imagenes/Encabezados/kgoldrunner.gif" width="48" height="48" />Factor de Abundamiento</div>
<div class="detalle" id="tipos" style="width:100%;margin-top:20px;">

<div id="menu_principal"><ul>
      <li  ><a href="x_material.php">Por Material</a></li>
      <li class="activa"><a href="x_banco_material.php">Por Banco y Material</a></li></ul>
</div>
</div>

<div id="menu">
    <ul>
      <li class="activa"><a href="/registrar.php">Registrar</a></li>
        <li><a href="xBanco_Material/administrar.php">Administrar</a></li>
    </ul>
</div>

<div id="contenido" style="margin-top:15px;float:left;position:relative">
<div id="OK"></div>
<div id="KO"></div>
<form id="usuario" name="usuario" style="width:350px;background-color:#f7f9fb">

<div class="fila_registro">
	<div style="width:60%" class="encabezado">Material</div>
	<div style="width:40%" class="encabezado">Fda</div>
</div>
<?php 
$SQLs = "select m.IdMaterial, m.Descripcion as Material,if(fad.FactorAbundamiento is null, 0.00,fad.FactorAbundamiento) as FactorAbundamiento  from materiales as m left join
factorabundamiento as fad  on(fad.IdMaterial= m.IdMaterial and fad.Estatus = 1) where m.Estatus = 1";
$r = $SCA->consultar($SQLs);
while($v=$SCA->fetch($r))
{
?>
<div class="fila_registro">
	<div style="width:60%" ><?php echo $v["Material"] ?></div>
	<div style="width:40%;text-align:center" ><input name="fad<?php echo $v["IdMaterial"] ?>" id="<?php echo $v["IdMaterial"] ?>" type="text" class="texto" size="5" maxlength="8" value="<?php echo $v["FactorAbundamiento"] ?>" onkeypress="onlyDigits(event,'decOK')" />
	  <img src="../../../Imagenes/Guardar.gif" width="16" height="16" class="boton" title="Registrar/Guardar Cambio" onclick="if(xajax.$('fad<?php echo $v["IdMaterial"] ?>').value==''){xajax.$('fad<?php echo $v["IdMaterial"] ?>').value='0.00';}xajax_registra_fad(<?php echo $v["IdMaterial"] ?>,xajax.$('fad<?php echo $v["IdMaterial"] ?>').value)" /></div>
</div>
<?php } ?>
</form>
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