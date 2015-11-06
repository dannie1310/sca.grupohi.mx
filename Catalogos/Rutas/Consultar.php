<?php 
session_start();
require_once("../../inc/php/conexiones/SCA.php");
require_once("../../inc/php/Usuario.php");
require_once("../../inc/generales.php");
require_once("../../inc/php/xajax/xajax_core/xajax.inc.php");

$xajax = new xajax(); 
$xajax->setCharEncoding('ISO-8859-1');
$xajax->configure('decodeUTF8Input',true);

$SCA=SCA::getConexion();
function inicializa_formulario()
{
	$rpt=new xajaxResponse();
	$SCA = $GLOBALS["SCA"];
	$salida='
						<div id="tabla" style="width:730px">
                   <fieldset >
                        <legend ><img src="../../Imagenes/mixing_16x16.png" width="16" height="16" />Información Básica</legend>
                      <div id="fila"></div>
                        <div id="fila" >
                        
                          <div id="label" style="width:100px">
                            Origen:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("origenes","IdOrigen","Descripcion","Estatus = 1","asc",1).'
                            </div>
                            
                          <div id="label" style="width:100px;padding-left:15px">
                            Tiro:</div>
                            <div id="caja" >'.$SCA->regresaSelectBasicoRet("tiros","IdTiro","Descripcion","Estatus = 1","asc",1).'
                            </div>
                          
                            
                        </div>
                        <div id="fila">
                        <div id="label" style="width:100px;">
                            Tipo Ruta:</div>
                            <div id="caja" style="width:230px"><label><input name="tipo_ruta" type="radio" value="1" checked />Terracería</label><label> <input name="tipo_ruta" type="radio" value="2"  /> Pavimento</label>
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Croquis:</div>
                            <div id="caja"> <input name="croquis" id="croquis" type="file" class="text file" />
                            </div>
                            
                        </div>
                      </fieldset>
                       <fieldset >
                        <legend ><img src="../../Imagenes/16-Distancia.gif" width="16" height="16" />&nbsp;Kilometraje</legend>
                        <div id="fila"></div>
                       
                          <div id="fila" >
                            <div id="label" style="width:90px;">Primer KM:</div><div id="caja" style="width:60px"><input name="pkm" id="pkm" type="text" class="monetario calcula_kmtotal" style="width:45px"  readonly="readonly" value="1"/>&nbsp;</div>
                            <div id="label" style="width:140px;">KM Subsecuentes:</div><div id="caja" style="width:60px"><input name="kms" id="kms" type="text" class="monetario calcula_kmtotal" style="width:45px" />&nbsp;</div>
                            <div id="label" style="width:140px;">KM Adicionales:</div><div id="caja" style="width:60px"><input name="kma" id="kma" type="text" class="monetario calcula_kmtotal" style="width:45px" />
                            &nbsp;</div>
                          <div id="label" style="width:80px;">Total:</div><div id="caja"><input name="total" id="total" type="text" class="monetario" style="width:45px" readonly="readonly" value="1" />
                          &nbsp;</div>
                        </div>
                   </fieldset>
                      <fieldset >
                        <legend ><img src="../../Imagenes/Cronometrias.gif" width="16" height="16" />&nbsp;Conometria</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:150px">
                            Tiempo Mínimo:</div>
                            <div id="caja" style="width:200px">
                            <input name="minimo" id="minimo" type="text" class="text" value="" style="width:45px" />&nbsp;min.
                            </div>
                            <div id="label" style="width:140px;">
           		        Tolerancia:</div>
                            	<div id="caja">
                                	 <input name="tolerancia" id="tolerancia" type="text" class="text" value="" style="width:45px" />&nbsp;min.</div>
                              
                        </div>
                   </fieldset>
                   
          				 <div id="fila"><div id="botones20" style="float:right">&nbsp;</div></div>
                        <div id="fila"><div id="botones20" style="float:right"><div class="sboton refresh" ></div><div class="sboton guardar" ></div></div></div>
          			</div>

                        
                        ';
	
	$rpt->assign('frm_ctg','innerHTML',$salida);
	return $rpt;
	
}
$xajax->register(XAJAX_FUNCTION,"inicializa_formulario");
$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SCA.-Registro de Camiones</title>
<link href="../../css/botones.css" rel="stylesheet" type="text/css" />
<link href="../../css/formulario.css" rel="stylesheet" type="text/css" />
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
<link href="../../css/tabla_formulario.css" rel="stylesheet" type="text/css" />
<link href="../../css/advertencias.css" rel="stylesheet" type="text/css" />
<style>
body{background:#FFF;}

label{ font-size:1em; font-weight:normal}
</style>
 <?php
   $xajax->printJavascript("../../inc/php/xajax/");
 ?>
 <link href="../../inc/js/JSCal/css/steel/steel.css" rel="stylesheet" type="text/css" />
<link href="../../inc/js/JSCal/css/jscal2.css" rel="stylesheet" type="text/css" />
<link href="../../inc/js/JSCal/css/border-radius.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../inc/js/JSCal/js/jscal2.js"></script>
<script type="text/javascript" src="../../inc/js/JSCal/js/lang/es.js"></script>
<script src="../../inc/js/jquery-1.4.4.js"></script>
<script src="../../inc/generales.js"></script>
<script>
function calcula()
{
	vpkm=parseFloat(quitacomas(xajax.$("pkm").value));
														vkms=parseFloat(quitacomas(xajax.$("kms").value));
														vkma=parseFloat(quitacomas(xajax.$("kma").value));
														vtotal=vpkm+vkms+vkma;
														return vtotal;
}
$(function() {
    
	
	
		
							
	
    $('img.vin').live("click",function()
										   {
											   ruta=$(this).attr("ruta");
											   rutaf='<?php echo ROOT; ?>'+ruta;
											// alert($(this).attr("ruta"));
											 // alert('<?php echo ROOT; ?>'+ruta);
											 window.open(rutaf,'','width=650,height=320,top=190,left=250,scrollbars=yes,resizable=yes')
										  }
							);

	
 
	
  });




</script>
<style>
table#tabla_rutas{ font-size:1.2em}
tr.encabezado{ text-align:center; background-color:#06C; color:#FFF; font-weight:bold;}
img.vin{ cursor:pointer}
</style>
</head>

<body>
<div id="layout">
<div id="cuerpo">
<div id="contenido" style="margin:0px">
                <div id="opc_ctg">CONSULTA DE RUTAS</div>
                    <hr />
                    <table style="margin-left:2.5%;width:95%"  cellspacing="0" cellpadding="2" id="tabla_rutas">
		  
		  <tr ><form id="excel" action="Consulta/XLS/1Muestra.php">
		    <td colspan="12" class="detalle"><span class="boton" onclick="document.getElementById('excel').submit()"><img src="../../Imagenes/look.gif"/> Ver Rutas en Excel</span></td>
			</form>
      </tr>
	   <tr >
		    <td   colspan="12">&nbsp;</td>
      </tr>
	  <tr class="encabezado">
		    <td   colspan="9" style="border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Ruta</td> <td   colspan="3" style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; ">Cronometr&iacute;a Activa</td>
      </tr>
		  <tr class="encabezado">
		  	<td style="border:#D4D4D4 solid 1px">Ruta</td>
            <td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">&nbsp;</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Origen</td>
			
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiro</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tipo de Ruta</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> 1er. KM</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />Subsecuentes</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px"> KM<br />Adicionales</td>
			<td style="width:70px;border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">KM<br />Total</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>Minimo</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Tiempo<br/>Tolerancia</td>
			<td style="border-right:#D4D4D4 solid 1px; border-top:#D4D4D4 solid 1px; border-bottom:#D4D4D4 solid 1px">Fecha/Hora<br/>Registro</td>
		  </tr>
		  <tbody>
          <?php 
		   $SQLs = "SELECT fn_regresa_ruta_pfd(r.IdRuta) as Ruta,concat(r.Clave,r.IdRuta) as ruta,r.*,  t.Descripcion as tiro, tr.Descripcion as tipo_ruta, if(c.TiempoMinimo is null,'- - - ',c.TiempoMinimo) as minimo, o.Descripcion as origen,
if(c.Tolerancia is null,'- - - ',c.Tolerancia) as tolerancia,
if(c.FechaAlta is null,'- - - ',Concat(date_format(c.FechaAlta,'%d-%m-%Y'),' / ',c.HoraAlta)) as fecha_hora from cronometrias as c right join rutas as r on(c.IdRuta=r.IdRuta and c.Estatus=1) join origenes as o on(r.IdOrigen=o.IdOrigen) join tiros as t on(t.IdTiro=r.IdTiro) left join tipo_ruta as tr on(tr.IdTipoRuta=r.IdTipoRuta)
left join rutas_archivos as ar on(ar.IdRuta=r.IdRuta)
where r.Estatus=1 order by IdRuta";
//echo $SQLs;
		  $r=$SCA->consultar($SQLs);
		  while($v=$SCA->fetch($r))
		  {
			  $pdf=($v["Ruta"]!="")?'<img src="../../Imagenes/pdf.gif" width="16" height="16" class="vin" ruta="../'.$v["Ruta"].'" />':"";
			  echo '<tr class="detalle">
		  	<td style="text-align:center;border-bottom:#D4D4D4 solid 1px; border-left:#D4D4D4 solid 1px; border-right:#D4D4D4 solid 1px">'.$v["ruta"].'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$pdf.'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["origen"].'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["tiro"].'</td>
			<td style="text-align:left;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["tipo_ruta"].'</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["PrimerKm"].' km</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["KmSubsecuentes"].' km</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["KmAdicionales"].' km</td>
			<td style="text-align:right;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["TotalKM"].' km</td>
			<td style="text-align:center;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["minimo"].'</td>
			<td style="text-align:center;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["tolerancia"].'</td>
			<td style="text-align:center;border-bottom:#D4D4D4 solid 1px;border-right:#D4D4D4 solid 1px">'.$v["fecha_hora"].'</td>
		  </tr>';
		}
		  ?>
          </tbody></table>
                <iframe name="ifr" id="ifr" width="1" height="1"></iframe>
    </div>
             </div>
             </div>
</body>
</html>