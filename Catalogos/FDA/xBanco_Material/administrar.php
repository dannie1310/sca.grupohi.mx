<?php 

	session_start();
	include("../../../Clases/Funciones/Configuracion.php");

	include("../../../inc/php/conexiones/SCA.php");

	require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");

	$SCA = SCA::getConexion(); 


	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	
	function registra_fad($id_material, $banco, $fad)
	{
		$rpt=new xajaxResponse();
		//$rpt->alert($id_material.$banco.$fad);
		$SCA = $GLOBALS["SCA"];
		$SQLs = "call sca_administra_fad_material_banco(".$id_material.",".$banco.",".$fad.",".$_SESSION["IdUsuarioAc"].",@resultado)";
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
		$rpt->script("xajax_muestra_fad()");

		return $rpt;
	}
		function actualiza_fad($id_material, $banco, $fad)
	{
		$rpt=new xajaxResponse();
		//$rpt->alert($id_material.$banco.$fad);
		$SCA = $GLOBALS["SCA"];
		$SQLs = "call sca_administra_fad_material_banco(".$id_material.",".$banco.",".$fad.",".$_SESSION["IdUsuarioAc"].",@resultado)";
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
	function muestra_fad()
	{
		$rpt=new xajaxResponse();
		//$rpt->alert($id_material.$banco.$fad);
		$SCA = $GLOBALS["SCA"];
		$salida='
		<table width="100%" border="0" cellspacing="0" cellpadding="2">
		  <tr class="encabezado2">
			<th scope="col" style="width:200px">Banco</th>
			<th scope="col" style="width:200px">Material</th>
			<th scope="col">Fda</th>
		  </tr>
		';
		$SQLs = "select m.IdMaterial, b.Descripcion as Banco, b.IdOrigen as IdBanco, m.Descripcion as Material,if(fad.FactorAbundamiento is null, 0.00,fad.FactorAbundamiento) as FactorAbundamiento  from materiales as m  join
factorabundamiento_material as fad  on(fad.IdMaterial= m.IdMaterial ) join origenes as b on(b.IdOrigen = fad.IdBanco) where m.Estatus = 1";
$r = $SCA->consultar($SQLs);
		while($v=$SCA->fetch($r))
		{
			$salida.='
			<tr>
		<td><input name="banco'.$v["IdMaterial"].'_'.$v["IdBanco"].'" type="hidden" id="banco'.$v["IdMaterial"].'_'.$v["IdBanco"].'" value="'.$v["IdBanco"].'" />'.$v["Banco"].'</td>
		<td><input name="material'.$v["IdMaterial"].'_'.$v["IdBanco"].'" id="material'.$v["IdMaterial"].'_'.$v["IdBanco"].'" type="hidden" value="'.$v["IdMaterial"].'" />'.$v["Material"].'</td>
	
		<td align="center">
		  <input name="fad'.$v["IdMaterial"].'_'.$v["IdBanco"].'" id="fad'.$v["IdMaterial"].'_'.$v["IdBanco"].'" type="text" class="texto" size="5" maxlength="8" value="'.$v["FactorAbundamiento"].'" onkeypress="onlyDigits(event,\'decOK\')" />&nbsp;<img src="../../../Imagenes/Guardar.gif" width="16" height="16" class="boton" title="Registrar/Guardar Cambio" onclick="if(xajax.$(\'fad'.$v["IdMaterial"].'_'.$v["IdBanco"].'\').value==\'\'){xajax.$(\'fad'.$v["IdMaterial"].'_'.$v["IdBanco"].'\').value=\'0.00\';}xajax_actualiza_fad(xajax.$(\'material'.$v["IdMaterial"].'_'.$v["IdBanco"].'\').value,xajax.$(\'banco'.$v["IdMaterial"].'_'.$v["IdBanco"].'\').value,xajax.$(\'fad'.$v["IdMaterial"].'_'.$v["IdBanco"].'\').value)" />
		</td>
	  </tr>
			';
		}
		$salida.='</table>';
		$rpt->assign("encontrados","innerHTML",$salida);
		return $rpt;
	}
	
	$xajax->register(XAJAX_FUNCTION,"registra_fad");
	$xajax->register(XAJAX_FUNCTION,"muestra_fad");
	$xajax->register(XAJAX_FUNCTION,"actualiza_fad");



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
      <li  ><a href="../x_material.php">Por Material</a></li>
      <li class="activa"><a href="../x_banco_material.php">Por Banco y Material</a></li></ul>
</div>
</div>

<div id="menu">
    <ul>
      <li ><a href="registrar.php">Registrar</a></li>
        <li class="activa"><a href="administrar.php">Administrar</a></li>
    </ul>
</div>

<div id="contenido" style="margin-top:15px;float:left;position:relative">
<div id="OK"></div>
<div id="KO"></div>
<form style="width:500px;background-color:#f7f9fb">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr class="encabezado2">
    <th scope="col">Banco</th>
    <th scope="col">Material</th>
    <th scope="col">Fda</th>
  </tr>
  <tr>

    <td><?php echo $SCA->regresaSelect_mult_order_ret("banco","IdOrigen,Descripcion","origenes","Estatus = 1","IdOrigen","Descripcion","Descripcion",1,"","","","200px","") ?></td>
        <td><?php echo $SCA->regresaSelect_mult_order_ret("material","IdMaterial,Descripcion","materiales","Estatus = 1","IdMaterial","Descripcion","Descripcion",1,"","","","200px","") ?></td>
    <td><span style="width:20%;text-align:center">
      <input name="fad" id="fad" type="text" class="texto" size="5" maxlength="8" value="" onkeypress="onlyDigits(event,'decOK')" />&nbsp;<img src="../../../Imagenes/Guardar.gif" width="16" height="16" class="boton" title="Registrar/Guardar Cambio" onclick="if(xajax.$('fad').value==''){xajax.$('fad').value='0.00';}xajax_registra_fad(xajax.$('material').value,xajax.$('banco').value,xajax.$('fad').value)" />
    </span></td>
  </tr>
</table>
</form>
<form style="width:500px;background-color:#f7f9fb">
<div id="encontrados">
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr class="encabezado2">
    <th scope="col" style="width:200px">Banco</th>
    <th scope="col" style="width:200px">Material</th>
    <th scope="col">Fda</th>
  </tr>
  <?php 
$SQLs = "select m.IdMaterial, b.Descripcion as Banco, b.IdOrigen as IdBanco, m.Descripcion as Material,if(fad.FactorAbundamiento is null, 0.00,fad.FactorAbundamiento) as FactorAbundamiento  from materiales as m  join
factorabundamiento_material as fad  on(fad.IdMaterial= m.IdMaterial ) join origenes as b on(b.IdOrigen = fad.IdBanco) where m.Estatus = 1";
$r = $SCA->consultar($SQLs);
while($v=$SCA->fetch($r))
{
?>
  <tr>
    <td><input name="banco<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>" type="hidden" id="banco<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>" value="<?php echo $v["IdBanco"];  ?>" /><?php echo $v["Banco"];  ?></td>
    <td><input name="material<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>" id="material<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>" type="hidden" value="<?php echo $v["IdMaterial"];  ?>" /><?php echo $v["Material"];  ?></td>

    <td align="center">
      <input name="fad<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>" id="fad<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>" type="text" class="texto" size="5" maxlength="8" value="<?php echo $v["FactorAbundamiento"] ?>" onkeypress="onlyDigits(event,'decOK')" />&nbsp;<img src="../../../Imagenes/Guardar.gif" width="16" height="16" class="boton" title="Registrar/Guardar Cambio" onclick="if(xajax.$('fad<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>').value==''){xajax.$('fad<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>').value='0.00';}xajax_actualiza_fad(xajax.$('material<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>').value,xajax.$('banco<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>').value,xajax.$('fad<?php echo $v["IdMaterial"].'_'.$v["IdBanco"];  ?>').value)" />
    </td>
  </tr>
  <?php } ?>
</table>
</div>
</form>
</div>
</div>
</body>
<script>

</script>
<script type="text/javascript" src="funciones_js.js"></script>

<script type="text/javascript" src="../../../Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Js/ValidaFormulario.js"></script>
<script type="text/javascript" src="../../../Clases/Js/MuestraLoad.js"></script>

</html>