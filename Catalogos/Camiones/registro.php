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
	$salida='<div id="tabla" style="width:730px">
                    <fieldset >
                        <legend ><img src="../../Imagenes/Camiones.gif" width="16" height="16" />&nbsp;Información Básica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                        
                            <div id="label" style="width:100px">
                            Sindicato:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("sindicatos","IdSindicato","Descripcion","Estatus = 1","asc",1).'
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Propietario:</div>
                            <div id="caja" ><input name="propietario" id="propietario" type="text" class="text" value="" />
                            </div>
                        </div>
                  <div id="fila" >
                            <div id="label" style="width:100px">
                          Operador:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("operadores","IdOperador","Nombre","Estatus = 1","asc",1).'
                            </div>
                            
              <div id="label" style="width:100px; padding-left:15px">
                            Eco:</div>
                            <div id="caja"><input name="eco" id="eco" type="text" class="text" value="" style="width:75px" />
                       	  </div>
                            
                            
                      </div>
                      <div id="fila" >    
                            <div id="label" style="width:115px">
                            Placas Camión:</div>
                            <div id="caja"><input name="placas" id="placas" type="text" class="text" value="" style="width:100px"/>
                            </div>
                            <div id="label" style="width:100px;padding:0 0 0 145px">
                              Placas Caja:</div>
                            <div id="caja"><input name="placas_caja" id="placas_caja" type="text" class="text" value="" style="width:100px"/>
                            </div>
                    </div>
                         <div id="fila" >
                            <div id="label" style="width:100px">
                            Marca:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("marcas","IdMarca","Descripcion","Estatus = 1","asc",1).'
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Modelo:</div>
                            <div id="caja"><input name="modelo" id="modelo" type="text" class="text" value="" style="width:100px" />
                            </div>
                            
                             <div id="label" style="width:100px;padding-left:15px">
                        Dispositivo:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("botones","IdBoton","Identificador","Estatus = 1 and TipoBoton=2","asc",1).'
                            </div>
                        </div>
                      </fieldset>
                       <fieldset >
                        <legend ><img src="../../Imagenes/image.gif" width="16" height="16" />&nbsp;Información Fotográfica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                            Frente:</div>
                            <div id="caja">
                            <input name="frente" id="frente" type="file" class="text" />
                            </div>
                            <div id="label" style="width:100px;padding-left:15px">
           		        Derecha:</div>
                            	<div id="caja">
                                	 <input name="derecha" id="derecha" type="file" class="text" />  </div>
                            </div>
                            <div id="fila">
                              <div id="label" style="width:100px;">
                    Atras:</div>
                          <div id="caja">
                             <input name="atras" id="atras" type="file" class="text" /> </div>
                        
                        <div id="label" style="width:100px;padding-left:15px">
           		        Izquierda:</div>
                            	<div id="caja">
                                	 <input name="izquierda" id="izquierda" type="file" class="text" />  </div>
                        </div>
                   </fieldset>
                      <fieldset >
                        <legend ><img src="../../Imgs/MenuIcons/CerrarSesion.gif" width="16" height="16" />&nbsp;Información de Seguro</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                            Aseguradora:</div>
                            <div id="caja">
                            <input name="aseguradora" id="aseguradora" type="text" class="text" value="" style="width:130px" />
                            </div>
                            <div id="label" style="width:90px;padding-left:15px">
           		        Póliza:</div>
                            	<div id="caja">
                                	 <input name="poliza" id="poliza" type="text" class="text" value="" style="width:100px" />  </div>
                              <div id="label" style="width:100px;padding-left:15px">
                    Vigencia:</div>
                          <div id="caja">
                            <input name="vigencia" id="vigencia" type="text" class="text" value="" style="width:100px" /> 
                            <img src="../../Imagenes/calendario.jpg" width="16" height="16" class="boton" id="b_vigencia"  onMouseOver=\'new Calendar({inputField:"vigencia", dateFormat: "%d-%m-%Y", animation:false, trigger: "b_vigencia", weekNumbers: true,fdow:1, bottomBar: true, onSelect: function(){ this.hide();}});\' /></div>
                        </div>
                   </fieldset>
                   <fieldset >
                        <legend ><img src="../../Imgs/16-Cubicacion.gif" width="16" height="16" alt="cubicacion" />&nbsp;Información de Cubicación</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:60px;">Ancho:</div><div id="caja"><input name="ancho" id="ancho" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Largo:</div><div id="caja"><input name="largo" id="largo" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Alto:</div><div id="caja"><input name="alto" id="alto" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                          <div id="label" style="width:50px;padding-left:15px">Gato:</div><div id="caja"><input name="gato" id="gato" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m<sup>3</sup></div>
                          <div id="label" style="width:80px;padding-left:15px">Extensión:</div><div id="caja"><input name="extension" id="extension" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                        </div>
                        
                        
                <div id="fila" >
                    <div id="label" style="width:100px">Disminuci&oacute;n:</div><div id="caja"><input name="disminucion" id="disminucion" type="text" class="monetario calcula_cubicacion" style="width:50px" />&nbsp;m<sup>3</sup></div>
                    <b>
                      <div id="label" style="width:130px;;padding-left:15px">Cubicaci&oacute;n. Real:</div><div id="caja"><input name="real" id="real" type="text" class="text" style="width:48px" readonly="readonly" />&nbsp;m<sup>3</sup></div>
                      <div id="label" style="width:165px;padding-left:15px">Cubicaci&oacute;n para Pago:</div><div id="caja"><input name="pago" id="pago" type="text" class="text" style="width:48px" readonly="readonly" />&nbsp;m<sup>3</sup></div>
                    </b>
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
select#marcas{ width:130px}
select#botones{ width:114px}
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
$(function() {
    
	$('.calcula_cubicacion').live("keyup",function(){
														ancho=parseFloat(quitacomas(xajax.$("ancho").value));
														largo=parseFloat(quitacomas(xajax.$("largo").value));
														alto=parseFloat(quitacomas(xajax.$("alto").value));
														extension=parseFloat(quitacomas(xajax.$("extension").value));
														gato=parseFloat(quitacomas(xajax.$("gato").value));
                            disminucion=parseFloat(quitacomas(xajax.$("disminucion").value));
														cubicacionr=ancho*largo*(alto+extension)-gato-disminucion;
														//a=redondear(cubicacionr);
														xajax.$("real").value = formateando(String(redondear(cubicacionr,2)));
														xajax.$("pago").value = formateando(String(redondear(cubicacionr,0)));
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
												  var obligatorios = ["sindicatos","propietario","operadores","eco","placas","marcas","modelo","ancho","largo","alto","real","pago"];
												  var form =$("#frm");
												  var ok = true;
												  form.find(":input").each(function(){
																						for(i=0;i<obligatorios.length;i++)
																						{
																							if(obligatorios[i]==$(this).attr("id"))	
																							{
																								if(($(this).attr("class")=="text"&&$(this).attr("value")=='')||$(this).attr("value")=='A99'||($(this).attr("class")=="monetario calcula_cubicacion"&&!($(this).attr("value")>0)))
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
													  if(confirm('¿Está seguro de registrar el camión?'))
													  {
														 xajax.$('frm').submit();
														 //xajax_registra_cambio($(this).attr("id"),xajax.$('descripcion'+$(this).attr("id")).value);
													  }
												  }
												  else
												  {
													  llena_mensaje('<div id="mnsj" class="red np"> Debe ingresar obligatoriamente los datos de Información Básica y de Cubicación</div>');
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
                <div id="opc_ctg">REGISTRO DE CAMIONES</div>
                    <hr />
                   <div id="mnsj" class="instrucciones" style="min-width:95%;font-size:1.2em">Ingrese los datos del camión que se solicitan a continuación </div>
                <form id="frm" method="post" enctype="multipart/form-data" action="registra_camion.php" target="ifr"> 
                        <div id="frm_ctg">
 							                        	
					<div id="tabla" style="width:730px">
                    <fieldset >
                        <legend ><img src="../../Imagenes/Camiones.gif" width="16" height="16" />&nbsp;Información Básica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                        
                            <div id="label" style="width:115px">
                            Sindicato:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("sindicatos","IdSindicato","Descripcion","Estatus = 1","asc",1)?>
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Propietario:</div>
                            <div id="caja" ><input name="propietario" id="propietario" type="text" class="text" value="" />
                            </div>
                        </div>
                  <div id="fila" >
                            <div id="label" style="width:115px">
                          Operador:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("operadores","IdOperador","Nombre","Estatus = 1","asc",1)?>
                            </div>
                            
                            <div id="label" style="width:100px; padding-left:15px">
                              Eco:</div>
                            <div id="caja"><input name="eco" id="eco" type="text" class="text" value="" style="width:75px" />
                       	    </div>
                    </div>
                    <div id="fila" >    
                            <div id="label" style="width:115px">
                            Placas Camión:</div>
                            <div id="caja"><input name="placas" id="placas" type="text" class="text" value="" style="width:100px"/>
                            </div>
                            <div id="label" style="width:100px;padding:0 0 0 145px">
                              Placas Caja:</div>
                            <div id="caja"><input name="placas_caja" id="placas_caja" type="text" class="text" value="" style="width:100px"/>
                            </div>
                    </div>
                         <div id="fila" >
                            <div id="label" style="width:115px">
                            Marca:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("marcas","IdMarca","Descripcion","Estatus = 1","asc",1)?>
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Modelo:</div>
                            <div id="caja"><input name="modelo" id="modelo" type="text" class="text" value="" style="width:100px" />
                            </div>
                            
                             <div id="label" style="width:100px;padding-left:15px">
                            Dispositivo:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("botones","IdBoton","Identificador","Estatus = 1 and TipoBoton=2","asc",1)?>
                            </div>
                        </div>
                      </fieldset>
                       <fieldset >
                        <legend ><img src="../../Imagenes/image.gif" width="16" height="16" />&nbsp;Información Fotográfica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                            Frente:</div>
                            <div id="caja">
                            <input name="frente" id="frente" type="file" class="text" />
                            </div>
                            <div id="label" style="width:100px;padding-left:15px">
           		        Derecha:</div>
                            	<div id="caja">
                                	 <input name="derecha" id="derecha" type="file" class="text" />  </div>
                            </div>
                            <div id="fila">
                              <div id="label" style="width:100px;">
                    Atras:</div>
                          <div id="caja">
                             <input name="atras" id="atras" type="file" class="text" /> </div>
                        
                        <div id="label" style="width:100px;padding-left:15px">
           		        Izquierda:</div>
                            	<div id="caja">
                                	 <input name="izquierda" id="izquierda" type="file" class="text" />  </div>
                        </div>
                   </fieldset>
                      <fieldset >
                        <legend ><img src="../../Imgs/MenuIcons/CerrarSesion.gif" width="16" height="16" />&nbsp;Información de Seguro</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                            Aseguradora:</div>
                            <div id="caja">
                            <input name="aseguradora" id="aseguradora" type="text" class="text" value="" style="width:130px" />
                            </div>
                            <div id="label" style="width:90px;padding-left:15px">
           		        Póliza:</div>
                            	<div id="caja">
                                	 <input name="poliza" id="poliza" type="text" class="text" value="" style="width:100px" />  </div>
                              <div id="label" style="width:100px;padding-left:15px">
                    Vigencia:</div>
                          <div id="caja">
                            <input name="vigencia" id="vigencia" type="text" class="text" value="" style="width:100px" /> 
                            <img src="../../Imagenes/calendario.jpg" width="16" height="16" class="boton" id="b_vigencia" onMouseOver='new Calendar({inputField:"vigencia", dateFormat: "%d-%m-%Y", animation:false, trigger: "b_vigencia", weekNumbers: true,fdow:1, bottomBar: true, onSelect: function(){ this.hide();}});'  /></div>
                        </div>
                   </fieldset>
                   <fieldset >
                        <legend ><img src="../../Imgs/16-Cubicacion.gif" width="16" height="16" alt="cubicacion" />&nbsp;Información de Cubicación</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:60px;">Ancho:</div><div id="caja"><input name="ancho" id="ancho" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Largo:</div><div id="caja"><input name="largo" id="largo" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Alto:</div><div id="caja"><input name="alto" id="alto" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>
                          <div id="label" style="width:50px;padding-left:15px">Gato:</div><div id="caja"><input name="gato" id="gato" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m<sup>3</sup></div>
                          <div id="label" style="width:80px;padding-left:15px">Extensión:</div><div id="caja"><input name="extension" id="extension" type="text" class="monetario calcula_cubicacion" style="width:45px" />&nbsp;m</div>                          
                        </div>
                        <div id="fila">
                            
                            
                        </div>
                        
                        
                <div id="fila" >
                    <div id="label" style="width:100px">Disminuci&oacute;n:</div><div id="caja"><input name="disminucion" id="disminucion" type="text" class="monetario calcula_cubicacion" style="width:50px" />&nbsp;m<sup>3</sup></div>
                    <b>
                      <div id="label" style="width:130px;;padding-left:15px">Cubicaci&oacute;n. Real:</div><div id="caja"><input name="real" id="real" type="text" class="text" style="width:48px" readonly="readonly" />&nbsp;m<sup>3</sup></div>
                      <div id="label" style="width:165px;padding-left:15px">Cubicaci&oacute;n para Pago:</div><div id="caja"><input name="pago" id="pago" type="text" class="text" style="width:48px" readonly="readonly" />&nbsp;m<sup>3</sup></div>
                    </b>
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