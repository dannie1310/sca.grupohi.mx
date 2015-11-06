<?php 
session_start();
include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/FuncionesViajesManuales.php");
require_once("../../../Clases/xajax/xajax_core/xajax.inc.php");
require_once("../../../inc/generales.php");
$sca=SCA::getConexion();
	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
$xajax->configure('decodeUTF8Input',true);
	function cubicacion($idcamion,$i)
	{
		$rpt=new xajaxResponse();
		$sca=$GLOBALS["sca"];
		$SQLs="select CubicacionParaPago from camiones where IdCamion=".$idcamion;
		$r=$sca->consultar($SQLs);
		$v=$sca->fetch($r);
		$cub= $v["CubicacionParaPago"];
		$rpt->assign("cubicacion".$i,"value",$cub);
		
		return $rpt;
	}
	function tarifa($idmaterial,$i)
	{
		$rpt=new xajaxResponse();
		$sca=$GLOBALS["sca"];
		$SQLs="select PrimerKM,KMSubsecuente,KMAdicional from tarifas where IdMaterial=".$idmaterial;
		$r=$sca->consultar($SQLs);
		$v=$sca->fetch($r);
		$PrimerKM= $v["PrimerKM"];
		$KMSubsecuente= $v["KMSubsecuente"];
		$KMAdicional= $v["KMAdicional"];
		$rpt->assign("primerkm".$i,"value",$PrimerKM);
		$rpt->assign("kmsubsecuentes".$i,"value",$KMSubsecuente);
		$rpt->assign("kmadicionales".$i,"value",$KMAdicional);
		//$rpt->alert($PrimerKM.$KMSubsecuente.$KMAdicional);
		return $rpt;
	}
	function devuelve_ruta($i,$o,$t)
	{
		$rpt=new xajaxResponse();
		$sca=$GLOBALS["sca"];
		$SQLs="select IdRuta from rutas where IdOrigen=".$o." and IdTiro=".$t;
		$r=$sca->consultar($SQLs);
		
		$afe=$sca->affected();
		if($afe==1)
		{
			$v=$sca->fetch($r);
			$rut= "R-".$v["IdRuta"];
			$rpt->assign("druta".$i,"innerHTML",'<select name="ruta[]",id="ruta'.$i.'" class="ruta"><option value="'.$v["IdRuta"].'">'.$rut.'</option></select>');
		}
		else
		if($afe>1)
		{
			$select='<select name="ruta[]",id="ruta'.$i.'" class="ruta">';
			while($v=$sca->fetch($r))
			{
				$rut= "R-".$v["IdRuta"];
				$select.='<option value="'.$v["IdRuta"].'">'.$rut.'</option>';
			}
			$select.='</select>';
			$rpt->assign("druta".$i,"innerHTML",$select);	
		}
		if($afe<1)
		{
			$rpt->assign("druta".$i,"innerHTML",'<select name="ruta[]",id="ruta'.$i.'" class="ruta"><option value="A99">- - -</option></select>');	
		}
		
		return $rpt;
	}
	function regresa_tabla($no)
	{
		$rpt=new xajaxResponse();
		$sca=$GLOBALS["sca"];
		$salida.='
		<table class="resultados">
<thead>
  <tr>
    <th rowspan="2">#</th>
    <th rowspan="2" style="width:116px">Fecha</th>
    <th rowspan="2">Cami&oacute;n</th>
    <th rowspan="2">Cubicaci&oacute;n</th>
    <th rowspan="2">Origen</th>
    <th rowspan="2">Tiro</th>
    <th rowspan="2">Ruta</th>
    <th rowspan="2">Material</th>
    <th colspan="3">Tarifas</th>
    <th rowspan="2">Turno</th>
	 <th rowspan="2">Observaciones</th>
  </tr>
  <tr>
    <th>1er Km</th>
    <th>Km Subs.</th>
    <th>Km Adc.</th>
  </tr>
  </thead>
  <tbody>';
  for($i=0;$i<$no;$i++) {
	  $salida.='
  <tr>
    <td><label>
      <input type="text" name="noviajes[]" id="noviajes'.$i.'" class="monetario" />
    </label></td>
    <td><label>
      <input type="text" name="fecha[]" id="fecha'.$i.'" class="text fecha" value="'.date("d-m-Y").'" />
      <img src="../../../Imagenes/calendario.jpg" width="16" height="16" class="boton bfecha" contador="'.$i.'" id="b_fecha'.$i.'" /> 
	      </label></td>
    <td>'.$sca->regresaSelectBasicoRet("camiones","IdCamion","Economico","Estatus=1","asc","1","","camion[]","camion".$i."",'class="camiones" contador="'.$i.'"').'</td>
    <td><label>
      <input type="text" name="cubicacion[]" id="cubicacion'.$i.'" class="monetario" />
    </label></td>
    <td>'.$sca->regresaSelectBasicoRet("origenes","IdOrigen","Descripcion","Estatus=1","asc","1","","origen[]","origen".$i."",'class="calcula_ruta" contador="'.$i.'"').'</td>
	<td>'.$sca->regresaSelectBasicoRet("tiros","IdTiro","Descripcion","Estatus=1","asc","1","","tiro[]","tiro".$i."",'class="calcula_ruta" contador="'.$i.'"').'</td>
  
    <td><div id="druta'.$i.'"><select name="ruta[]",id="ruta'.$i.'" class="ruta"><option>- - -</option></select></div></td>
    <td>'.$sca->regresaSelectBasicoRet("materiales","IdMaterial","Descripcion","Estatus=1","asc","1","","material[]","material".$i."",'class="devuelve_tarifa" contador="'.$i.'"').'</td>
    <td><input type="text" name="primerkm[]" id="primerkm'.$i.'" class="monetario" /></td>
    <td><input type="text" name="kmsubsecuentes[]" id="kmsubsecuentes'.$i.'" class="monetario" /></td>
    <td><input type="text" name="kmadicionales[]" id="kmadicionales'.$i.'" class="monetario" /></td>
    <td><input name="turno'.$i.'" type="radio" value="M" checked="checked"  />M<input name="turno'.$i.'" type="radio" value="V"  />V</td>
	 <td>
      <textarea name="observaciones[]" id="observaciones'.$i.'" cols="45" rows="2"></textarea>
    </td>
	';
   $salida.='</tr>';
  }
  $salida.='
    <tr class="bot"><td colspan="13"><img src="../../../Imagenes/guardar_big.gif" width="24" height="24" class="boton" id="guardar" /></td></tr>

  </tbody>
</table>
		';
	$rpt->assign("tab","innerHTML",$salida);	
	return $rpt;
	}
	function registra_viajes($frm)
	{
		$rpt=new xajaxResponse();
		$i = sizeof($frm["fecha"]);
		$sca=$GLOBALS["sca"];
		for($x=0;$x<$i;$x++)
		{
			//$rpt->alert(fechasql($frm["fecha"][$x]).$frm["noviajes"][$x].$frm["camion"][$x].$frm["cubicacion"][$x].$frm["origen"][$x].$frm["tiro"][$x].$frm["ruta"][$x].$frm["material"][$x].$frm["primerkm"][$x].$frm["kmsubsecuentes"][$x].$frm["kmadicionales"][$x].$frm["turno".$x].$frm["observaciones"][$x]);
			for($xx=0;$xx<$frm["noviajes"][$x];$xx++)
			{
				$SQLs="call registra_viajes_netos_viajes(".$_SESSION["Proyecto"].",'".fechasql($frm["fecha"][$x])."',".$frm["camion"][$x].",".$frm["cubicacion"][$x].",".$frm["origen"][$x].",".$frm["tiro"][$x].",".$frm["ruta"][$x].",".$frm["material"][$x].",".$frm["primerkm"][$x].",".$frm["kmsubsecuentes"][$x].",".$frm["kmadicionales"][$x].",'".$frm["turno".$x]."','".$frm["observaciones"][$x]."',".$_SESSION["IdUsuario"].",@OK)";
				$r=$sca->consultar($SQLs);
				$r2=$sca->consultar("select @OK");
				$v=$sca->fetch($r2);
				$registrados+=$v["@OK"];
				//$rpt->alert($SQLs);
				//$rpt->assign("tab","innerHTML",$SQLs);
			}
		}
		if($registrados>0)
		{
			$rpt->script("xajax_regresa_tabla(".$i.")");
			$rpt->alert("Se han registrado: ".$registrados." viajes");	
		}
		else
		{
			$rpt->alert("Hubo un error en el registro de los viajes, verifique que el material tenga factor de abundamiento registrado.");	
		}
		
		/*$sca=$GLOBALS["sca"];
		$SQLs="select IdRuta from rutas where IdOrigen=".$o." and IdTiro=".$t;
		$r=$sca->consultar($SQLs);}*/
		
		return $rpt;
	}
$xajax->register(XAJAX_FUNCTION,"cubicacion");
$xajax->register(XAJAX_FUNCTION,"tarifa");
$xajax->register(XAJAX_FUNCTION,"devuelve_ruta");
$xajax->register(XAJAX_FUNCTION,"regresa_tabla");
$xajax->register(XAJAX_FUNCTION,"registra_viajes");
$xajax->processRequest();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
 <?php
   $xajax->printJavascript("../../../Clases/xajax/");
 ?>
 <script src="../../../inc/js/jquery-1.4.4.js"></script>
  <script src="../../../inc/generales.js"></script>
 <link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
 <style>
	table.resultados{ color:#090; border-collapse:collapse; border:#aaa 1px solid; margin:20px auto 0px auto; font-size:1em}
	table.resultados th, table.resultados td { padding:3px;border-left:#aaa 1px solid;text-align:center;}
	table.resultados th{ background-color:#eee; border-bottom:#aaa 1px solid;}
	table.resultados tbody tr:hover { background: url(imagenes/bg_5.png);}
	table.resultados tbody{ color:#666;}
	table.resultados tbody tr { border:#aaa 1px solid; cursor:pointer }
	table.resultados caption{ color:#444; text-align:left; font-weight:bold; font-size:1.4em; margin:0.2em 0em; }
 table.resultados td { vertical-align:top;}
 table.resultados tr.bot{ border:none;}
  table.resultados tr.bot td { vertical-align:top; text-align:right; border:none;}
table.resultados th{  color:#666; }
table.resultados thead td{ text-align:center; background-color:#eee; border:#aaa 1px solid; font-weight:bold; font-size:12px }
table.resultados thead td.left{text-align:left; }
table.resultados tbody tr.lugar{ text-align:left; font-size:13px; color:#666; background-color:#eee; font-weight:bold}
input.text,input.monetario,input.numerico{ width:100px;border:#06C 1px solid; color:#666;}
textarea{ width:150px;border:#06C 1px solid; color:#666;}
input.monetario,input.numerico{ width:30px;}
select{ width:114px;}
select.camiones,select.ruta{ width:50px;}
div#filtros div{ color:#06C; display:inline; margin-left:5px}
div#filtros label{ font-size:13px; margin:0 5px;}
input.fecha{ width:50px}


</style>
<link href="../../../inc/js/JSCal/css/steel/steel.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/js/JSCal/css/jscal2.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/js/JSCal/css/border-radius.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../inc/js/JSCal/js/jscal2.js"></script>
<script type="text/javascript" src="../../../inc/js/JSCal/js/lang/es.js"></script>
<script language="javascript" type="text/javascript">
$(function() {
		   $('img#guardar').live("click",function(){
												if(confirm("Está seguro de registrar los viajes ingresados?"))
												{
													xajax_registra_viajes(xajax.getFormValues('frm'));
												}
										   
										   });
    $('.bfecha').live("mouseover",function(){
												  i=$(this).attr("contador");
										   		new Calendar({inputField:"fecha"+i, date: Calendar.intToDate("<?php echo date("Ymd"); ?>"), dateFormat: "%d-%m-%Y", animation:false, trigger: "b_fecha"+i, weekNumbers: true, bottomBar: true, onSelect: function()  {this.hide();}});
										   
										   });	   
	$('.camiones').live("change",function(){  i=$(this).attr("contador");  c=$(this).attr("value"); 
																						  //alert(i+" "+c);
																						  xajax_cubicacion(c,i);
																						  });
	$('.calcula_ruta').live("change",function(){
									   i=$(this).attr("contador");
									 	vorigen=xajax.$('origen'+i).value;
										vtiro=xajax.$('tiro'+i).value;
										if(vorigen!="A99"&&vtiro!="A99")
											xajax_devuelve_ruta(i,vorigen,vtiro);
											  });
	$('.devuelve_tarifa').live("change",function(){
												 	i=$(this).attr("contador");
													vmaterial=$(this).attr("value");
													//alert(vmaterial+" "+i);
													xajax_tarifa(vmaterial,i);
												 });
  });
</script>
</head>

<body>
<form id="frm">
<div id="filtros">
  <div id="dfecha">
    <label for="fecha">No de Camiones:</label>
    <input name="nocamiones" type="text" class="numerico" id="nocamiones" value="1" size="2" maxlength="2" />
            	
    </div>
           		 
                    <div id="botones"><img src="../../../Imgs/16-PuntaVerde.gif" width="24" height="24" class="boton" onclick="xajax_regresa_tabla(xajax.$('nocamiones').value)" /></div>
</div>
<hr />
<div id="tab">
<table class="resultados">
<thead>
  <tr>
    <th rowspan="2">#</th>
    <th rowspan="2" style="width:116px">Fecha</th>
    <th rowspan="2">Cami&oacute;n</th>
    <th rowspan="2">Cubicaci&oacute;n</th>
    <th rowspan="2">Origen</th>
    <th rowspan="2">Tiro</th>
    <th rowspan="2">Ruta</th>
    <th rowspan="2">Material</th>
    <th colspan="3">Tarifas</th>
    <th rowspan="2">Turno</th>
    <th rowspan="2">Observaciones</th>
  </tr>
  <tr>
    <th>1er Km</th>
    <th>Km Subs.</th>
    <th>Km Adc.</th>
  </tr>
  </thead>
  <tbody>
  <?php for($i=0;$i<1;$i++) {?>
  <tr>
    <td><label>
      <input type="text" name="noviajes[]" id="noviajes<?php echo $i; ?>" class="monetario" />
    </label></td>
    <td><label>
      <input type="text" name="fecha[]" id="fecha<?php echo $i; ?>" class="text fecha" value="<?php echo date("d-m-Y");?>" />
      <img src="../../../Imagenes/calendario.jpg" width="16" height="16" class="boton bfecha" contador="<?php echo $i; ?>" id="b_fecha<?php echo $i;?>" />    </label></td>
    <td><?php echo $sca->regresaSelectBasicoRet("camiones","IdCamion","Economico","Estatus=1","asc","1","","camion[]","camion".$i."",'class="camiones" contador="'.$i.'"') ?></td>
    <td><label>
      <input type="text" name="cubicacion[]" id="cubicacion<?php echo $i; ?>" class="monetario" />
    </label></td>
    <td><?php echo $sca->regresaSelectBasicoRet("origenes","IdOrigen","Descripcion","Estatus=1","asc","1","","origen[]","origen".$i."",'class="calcula_ruta" contador="'.$i.'"') ?></td>
    <td><?php echo $sca->regresaSelectBasicoRet("tiros","IdTiro","Descripcion","Estatus=1","asc","1","","tiro[]","tiro".$i."",'class="calcula_ruta"  contador="'.$i.'"') ?></td>
    <td><div id="druta<?php echo $i; ?>"><select name="ruta[]",id="ruta<?php echo $i; ?>" class="ruta"><option>- - -</option></select></div></td>
    <td><?php echo $sca->regresaSelectBasicoRet("materiales","IdMaterial","Descripcion","Estatus=1","asc","1","","material[]","material".$i."",'class="devuelve_tarifa" contador="'.$i.'"') ?></td>
    <td><input type="text" name="primerkm[]" id="primerkm<?php echo $i; ?>" class="monetario" /></td>
    <td><input type="text" name="kmsubsecuentes[]" id="kmsubsecuentes<?php echo $i; ?>" class="monetario" /></td>
    <td><input type="text" name="kmadicionales[]" id="kmadicionales<?php echo $i; ?>" class="monetario" /></td>
    <td><input name="turno<?php echo $i; ?>" type="radio" value="M" checked="checked"  />M<input name="turno<?php echo $i; ?>" type="radio" value="V"  />V</td>
    <td>
      <textarea name="observaciones[]" id="observaciones<?php echo $i; ?>" cols="45" rows="2"></textarea>
    </td>
  </tr>
  <?php }?>
  <tr class="bot"><td colspan="13"><img src="../../../Imagenes/guardar_big.gif" width="24" height="24" class="boton" id="guardar" /></td></tr>
  </tbody>
</table>
</div>
</form>
</body>
</html>