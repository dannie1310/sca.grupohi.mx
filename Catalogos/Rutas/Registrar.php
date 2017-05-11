<?php 
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }
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
    
	$('.calcula_kmtotal').live("keyup",function(){
														
														
														vtotal=calcula();
														xajax.$("total").value = formateando(String(redondear(vtotal,2)));
														
													});
	$('.calcula_kmtotal').live("dblclick",function(){
														
														
														vtotal=calcula();
														xajax.$("total").value = formateando(String(redondear(vtotal,2)));
														
													});
	
		
	$('div.refresh').live("click",function()
										   {
											  xajax_inicializa_formulario();
										  }
							);										
	
    $('div.guardar').live("click",function()
										   {
											  if($(this).attr("id")!="guardar_nvo")
											  {
												  var obligatorios = ["origenes","tiros","minimo","tolerancia"];
												  var form =$("#frm");
												  var ok = true;
												  form.find(":input").each(function(){
																						for(i=0;i<obligatorios.length;i++)
																						{
																							if(obligatorios[i]==$(this).attr("id"))	
																							{
																								if(($(this).attr("class")=="text"&&$(this).attr("value")=='')||$(this).attr("value")=='A99'||(($(this).attr("class")=="monetario calcula_kmtotal"||$(this).attr("class")=="monetario")&&!($(this).attr("value")>0)))
																								{
																									$(this).css("background-color","#FCC");
																									ok=false;
																								}
																								else
																								{
																									$(this).css("background-color","#FFF");
																								}
																							}
																							
																						}
																					});
												 
												  if(ok){
													  if(confirm('¿Está seguro de registrar la ruta?'))
													  {
														 xajax.$('frm').submit();
														 //xajax_registra_cambio($(this).attr("id"),xajax.$('descripcion'+$(this).attr("id")).value);
													  }
												  }
												  else
												  {
													  llena_mensaje('<div id="mnsj" class="red np"> Debe ingresar obligatoriamente los datos marcados en rojo</div>');
													  presenta_mensaje(5000);
												  }
												  
											  }
										  }
							);

	
 
	
  });




</script>
</head>

<body>
<div id="layout">
<div id="cuerpo">
<div id="contenido" style="margin:0px">
                <div id="opc_ctg">REGISTRO DE RUTAS</div>
                    <hr />
                   <div id="mnsj" class="instrucciones" style="min-width:95%;font-size:1.2em">Ingrese los datos del las ruta que se solicitan a continuaci&oacute;n</div>
                <form id="frm" method="post" enctype="multipart/form-data" action="RegistrarRuta.php" target="ifr"> 
                        <div id="frm_ctg">
 							                        	
					<div id="tabla" style="width:730px">
                    <fieldset >
                        <legend ><img src="../../Imagenes/mixing_16x16.png" width="16" height="16" />Información Básica</legend>
                      <div id="fila"></div>
                        <div id="fila" >
                        
                          <div id="label" style="width:100px">
                            Origen:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("origenes","IdOrigen","Descripcion","Estatus = 1","asc",1)?>
                            </div>
                            
                          <div id="label" style="width:100px;padding-left:15px">
                            Tiro:</div>
                            <div id="caja" ><?php echo $SCA->regresaSelectBasicoRet("tiros","IdTiro","Descripcion","Estatus = 1","asc",1)?>
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
                            <input name="minimo" id="minimo" type="text" class="monetario" value="" style="width:45px" />&nbsp;min.
                            </div>
                            <div id="label" style="width:140px;">
           		        Tolerancia:</div>
                            	<div id="caja">
                                	 <input name="tolerancia" id="tolerancia" type="text" class="monetario" value="" style="width:45px" />&nbsp;min.</div>
                              
                        </div>
                   </fieldset>
                   
   				    <div id="fila"><div id="botones20" style="float:right">&nbsp;</div></div>
                        <div id="fila"><div id="botones20" style="float:right"><div class="sboton refresh" ></div><div class="sboton guardar" ></div></div></div>
          			</div>
                        
                        </div>
                        
                        <div id="mensajes">
                        </div>
					</form>
                <iframe name="ifr" id="ifr" width="1" height="1"></iframe>
             </div>
             </div>
             </div>
</body>
</html>