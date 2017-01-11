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

$camion=$_REQUEST["camion"];
$sql="select c.*,date_format(c.VigenciaPolizaSeguro,'%d-%m-%Y') as vp from camiones as c where IdProyecto=".$_SESSION["Proyecto"]." and idcamion=".$camion."";
//echo $sql;

$r=$SCA->consultar($sql);
$vc=mysql_fetch_array($r);
function sac()
{
	$rpt=new xajaxResponse();
	$rpt->alert("mm");
	return $rpt;
}
function inicializa_formulario($camion)
{
	$rpt=new xajaxResponse();
	$SCA = $GLOBALS["SCA"];
	
	$sql="select c.*,date_format(c.VigenciaPolizaSeguro,'%d-%m-%Y') as vp from camiones as c where IdProyecto=".$_SESSION["Proyecto"]." and idcamion=".$camion."";
//echo $sql;
//$rpt->alert($sql);
$r=$SCA->consultar($sql);
$vc=mysql_fetch_array($r);
	
	$salida='					<div id="tabla" style="width:730px">
                    <fieldset >
                        <legend ><img src="../../Imagenes/Camiones.gif" width="16" height="16" />&nbsp;Información Básica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                        
                            <div id="label" style="width:115px">
                            Sindicato:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("sindicatos","IdSindicato","Descripcion","Estatus = 1","asc",1,$vc["IdSindicato"]).'
                            </div>

                            <div id="label" style="width:100px;padding-left:15px">
                            Empresa:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("empresas","IdEmpresa","razonSocial","Estatus = 1","asc",1,$vc["IdEmpresa"]).'
                            </div>
                            
                        </div>
                        <div id="fila" >

                            <div id="label" style="width:115px">
                            Propietario:</div>
                            <div id="caja" ><input name="propietario" id="propietario" type="text" class="text" value="'.$vc["Propietario"].'" />
                            </div>

                        </div>

                          <div id="fila" >

                            <div id="label" style="width:115px">
                              Operador:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("operadores","IdOperador","Nombre","Estatus = 1","asc",1,$vc["IdOperador"]).'
                            </div>                            
                          <div id="label" style="width:100px; padding-left:15px">
                            Eco:</div>
                            <div id="caja"><input name="eco" id="eco" type="text" class="text"  style="width:75px" value="'.$vc["Economico"].'" />
                       	  </div>

                        </div>

                        <div id="fila" >  
                            
                          <div id="label" style="width:115px">
                            Placas Camión:</div>
                          <div id="caja"><input name="placas" id="placas" type="text" class="text" value="'.$vc["Placas"].'" style="width:75px"/>
                          </div>

                          <div id="label" style="width:100px;padding:0 0 0 68px">
                            Placas Caja:</div>
                          <div id="caja"><input name="placas_caja" id="placas_caja" type="text" class="text" value="'.$vc["PlacasCaja"].'" style="width:75px"/>
                          </div>

                        </div>

                         <div id="fila" >
                            <div id="label" style="width:115px">
                            Marca:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("marcas","IdMarca","Descripcion","Estatus = 1","asc",1,$vc["IdMarca"]).'
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Modelo:</div>
                            <div id="caja"><input name="modelo" id="modelo" type="text" class="text" value="'.$vc["Modelo"].'" style="width:100px" />
                            </div>
                            
                             <div id="label" style="width:100px;padding-left:15px">
                        Dispositivo:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("botones","IdBoton","Identificador","(Estatus = 1 and TipoBoton=2) or(IdBoton=".$vc["IdBoton"].")","asc",1,$vc["IdBoton"]).'
                            </div>
                        </div>
						
						 <div id="fila" >
                            <div id="label" style="width:115px">Estatus:</div>
                            <div id="caja">'.$SCA->regresaSelectBasicoRet("ctg_estatus","IdEstatus","Estatus","1=1","asc",1,$vc["Estatus"]).'</div>
                        </div>
						
                      </fieldset>
                       <fieldset >
                        <legend ><img src="../../Imagenes/image.gif" width="16" height="16" />&nbsp;Información Fotográfica</legend>
                        <div id="fila"></div>
                        <div id="fila"><div id="caja"><div id="i_f"><img src="muestra_imagen.php?im='.$camion.'f" width="330" height="200" /></div></div><div id="caja" style="padding-left:15px"><div id="i_d"><img src="muestra_imagen.php?im='.$camion.'d" width="330" height="200" /></div></div></div>
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
                            
                            <div id="fila"><div id="caja"><div id="i_t"><img src="muestra_imagen.php?im='.$camion.'t" width="330" height="200" /></div></div><div id="caja" style="padding-left:15px"><div id="i_i"><img src="muestra_imagen.php?im='.$camion.'i" width="330" height="200" /></div></div></div>
                            
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
                            <input name="aseguradora" id="aseguradora" type="text" class="text" value="'.$vc["Aseguradora"].'" style="width:130px" />
                            </div>
                            <div id="label" style="width:90px;padding-left:15px">
           		        Póliza:</div>
                            	<div id="caja">
                                	 <input name="poliza" id="poliza" type="text" class="text" value="'.$vc["PolizaSeguro"].'" style="width:100px" />  </div>
                              <div id="label" style="width:100px;padding-left:15px">
                    Vigencia:</div>
                          <div id="caja">
                           <input name="vigencia" id="vigencia" type="text" class="text" value="'.$vc["vp"].'" style="width:100px" /> 
                            <img src="../../Imagenes/calendario.jpg" width="16" height="16" class="boton" id="b_vigencia" onMouseOver=\'new Calendar({inputField:"vigencia", dateFormat: "%d-%m-%Y", animation:false, trigger: "b_vigencia", weekNumbers: true,fdow:1, bottomBar: true, onSelect: function(){ this.hide();}});\'  /></div>
                        </div>
                   </fieldset>
                   <fieldset >
                        <legend ><img src="../../Imgs/16-Cubicacion.gif" width="16" height="16" alt="cubicacion" />&nbsp;Información de Cubicación</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:60px;">Ancho:</div><div id="caja"><input name="ancho" id="ancho" type="text" class="monetario calcula_cubicacion" style="width:45px" value="'.$vc["Ancho"].'" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Largo:</div><div id="caja"><input name="largo" id="largo" type="text" class="monetario calcula_cubicacion" style="width:45px" value="'.$vc["Largo"].'" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Alto:</div><div id="caja"><input name="alto" id="alto" type="text" class="monetario calcula_cubicacion" style="width:45px" value="'.$vc["Alto"].'" />&nbsp;m</div>
                          <div id="label" style="width:50px;padding-left:15px">Gato:</div><div id="caja"><input name="gato" id="gato" type="text" class="monetario calcula_cubicacion" style="width:45px" value="'.$vc["EspacioDeGato"].'" />&nbsp;m</div>
                          <div id="label" style="width:80px;padding-left:15px">Extensión:</div><div id="caja"><input name="extension" id="extension" type="text" class="monetario calcula_cubicacion" style="width:45px" value="'.$vc["AlturaExtension"].'" />&nbsp;m</div>
                        </div>
                        
                        
                <div id="fila" >
                  <div id="label" style="width:100px">Disminuci&oacute;n:</div><div id="caja"><input name="disminucion" id="disminucion" type="text" class="monetario calcula_cubicacion" style="width:45px" value="'.$vc["disminucion"].'" />&nbsp;m<sup>3</sup></div>
                  <b>
                    <div id="label" style="width:130px;padding-left:15px">Cubicaci&oacute;n. Real:</div><div id="caja"><input name="real" id="real" type="text" class="text" style="width:48px" readonly="readonly" value="'.$vc["CubicacionReal"].'" />&nbsp;m<sup>3</sup></div>
                    <div id="label" style="width:165px;padding-left:15px">Cubicaci&oacute;n para Pago:</div><div id="caja"><input name="pago" id="pago" type="text" class="text" style="width:48px" readonly="readonly" value="'.$vc["CubicacionParaPago"].'" />&nbsp;m<sup>3</sup></div>
                  </b>
                </div>
                        
                        
                        
                                                                  
             </fieldset>
          				 <div id="fila"><div id="botones20" style="float:right">&nbsp;</div></div>
                        <div id="fila"><div id="botones20" style="float:right"><div class="sboton refresh" IdCamion="'.$camion.'"></div><div class="sboton guardar" ></div></div></div>
          			</div>
                        
                        ';
	//$rpt->alert("s");
	$rpt->assign('frm_ctg','innerHTML',$salida);
	$rpt->script("actualiza_imagen()");
	return $rpt;

	
}
function actualiza_imagenes($idcamion)
{
		$rpt=new xajaxResponse();
		$f = carga_imagen($idcamion);
		$d = carga_imagen($idcamion);
		$t = carga_imagen($idcamion);
		$i = carga_imagen($idcamion);
		$rpt->assign('i_f','innerHTML',$f);
		$rpt->assign('i_d','innerHTML',$d);
		$rpt->assign('i_t','innerHTML',$t);
		$rpt->assign('i_i','innerHTML',$i);
	return $rpt;
}
function carga_imagen($idcamion,$tipo)
{
	/*if(file_exists("../../SourcesFiles/imagenes_camiones/".$idcamion.$tipo.".jpg"))
		return '<img id="ii_'.$tipo.'" src="../../SourcesFiles/imagenes_camiones/'.$idcamion.$tipo.'.jpg" width="330" height="200" />';	
	else
		return '<img id="ii_'.$tipo.'" src="../../SourcesFiles/imagenes_camiones/empty.jpg" width="330" height="200" />';	*/
		return '<img id="ii_'.$tipo.'" src="muestra_imagen.php?im='.$camion.$tipo.'" width="330" height="200" />';
}
$xajax->register(XAJAX_FUNCTION,"sac");
$xajax->register(XAJAX_FUNCTION,"actualiza_imagenes");
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
select#marcas,select#ctg_estatus{ width:130px}
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
											  // alert($(this).attr("IdCamion"));
											  // xajax_sac();
											 xajax_inicializa_formulario($(this).attr("IdCamion"));
											 // alert("dos");
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
													  if(confirm('¿Está seguro de actualizar los datos del camión?'))
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


function actualiza_imagen()
{
	
	document.getElementById('i_f').contentDocument.location.reload(true);
	document.getElementById('i_d').contentDocument.location.reload(true);
	document.getElementById('i_t').contentDocument.location.reload(true);
	document.getElementById('i_i').contentDocument.location.reload(true);
	//alert("z");
}

</script>



<?
$imgs = "
    SELECT TipoC, id, imagen 
    FROM camiones_imagenes 
    WHERE IdCamion = ".$camion." 
      AND TipoC <> ''
      AND id in (SELECT MAX(id) FROM camiones_imagenes 
          WHERE IdCamion = ".$camion."  AND TipoC <> '' GROUP BY TipoC)";

$img=$SCA->consultar($imgs);
while($v_img=mysql_fetch_array($img))
{
  switch ($v_img['TipoC']) {
    case 'f':
        $frente =  $v_img['imagen'];
      break;

    case 'd':
        $derecha =  $v_img['imagen'];
      break;

    case 't':
        $atras =  $v_img['imagen'];
      break;

    case 'i':
        $izquierda =  $v_img['imagen'];
      break;
  }
}



?>


</head>

<body >
<div id="layout">
<div id="cuerpo">
<div id="contenido" style="margin:0px">
	<iframe name="i_f" id="i_f" width="1px" height="1px" frameborder="0" src="muestra_imagen.php?im=<?php echo $camion; ?>f"></iframe>
    <iframe name="i_d" id="i_d" width="1px" height="1px" frameborder="0" src="muestra_imagen.php?im=<?php echo $camion; ?>d"></iframe>
    <iframe name="i_t" id="i_t" width="1px" height="1px" frameborder="0" src="muestra_imagen.php?im=<?php echo $camion; ?>t"></iframe>
    <iframe name="i_i" id="i_i" width="1px" height="1px" frameborder="0" src="muestra_imagen.php?im=<?php echo $camion; ?>i"></iframe>
                <div id="opc_ctg">MODIFICACI&Oacute;N DE CAMIONES</div>
                    <hr />
                   <div id="mnsj" class="instrucciones" style="min-width:95%;font-size:1.2em">Ingrese los datos del camión que se solicitan a continuación </div>
                <form id="frm" method="post" enctype="multipart/form-data" action="actualiza_camion.php" target="ifr"> 
               
                <input name="idcamion" id="idcamion" type="hidden" value="<?php echo $camion;?>" />
                        <div id="frm_ctg">
 							                        	
					<div id="tabla" style="width:730px">
                    <fieldset >
                        <legend ><img src="../../Imagenes/Camiones.gif" width="16" height="16" />&nbsp;Información Básica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                        
                          <div id="label" style="width:115px">
                            Sindicato:</div>
                          <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("sindicatos","IdSindicato","Descripcion","Estatus = 1","asc",1,$vc["IdSindicato"])?>
                          </div>
                          <div id="label" style="width:100px; padding-left:15px">
                            Empresa:</div>
                          <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("empresas","IdEmpresa","razonSocial","Estatus = 1","asc",1,$vc["IdEmpresa"])?>
                          </div>

                        </div>
                        <div id="fila" >    

                            <div id="label" style="width:115px">
                              Propietario:</div>
                            <div id="caja" ><input name="propietario" id="propietario" type="text" class="text" value="<?php echo $vc["Propietario"] ?>" />
                            </div>

                        </div>
                    <div id="fila" >
                            <div id="label" style="width:115px">
                          Operador:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("operadores","IdOperador","Nombre","Estatus = 1","asc",1,$vc["IdOperador"] )?>
                            </div>
                            
                        <div id="label" style="width:100px; padding-left:15px">
                            Eco:</div>
                            <div id="caja"><input name="eco" id="eco" type="text" class="text"  style="width:75px" value="<?php echo $vc["Economico"] ?>" />
                       	 </div>
                    </div>
                    <div id="fila" >   
                        <div id="label" style="width:115px;">
                        Placas Camión:</div>
                        <div id="caja"><input name="placas" id="placas" type="text" class="text" value="<?php echo $vc["Placas"] ?>" style="width:75px"/>
                        </div>
                        <div id="label" style="width:100px;padding:0 0 0 68px">
                        Placas Caja:</div>
                        <div id="caja"><input name="placas_caja" id="placas_caja" type="text" class="text" value="<?php echo $vc["PlacasCaja"] ?>" style="width:75px"/>
                        </div>
                    </div>
                         <div id="fila" >
                            <div id="label" style="width:115px">
                            Marca:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("marcas","IdMarca","Descripcion","Estatus = 1","asc",1,$vc["IdMarca"])?>
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Modelo:</div>
                            <div id="caja"><input name="modelo" id="modelo" type="text" class="text" value="<?php echo $vc["Modelo"] ?>" style="width:100px" />
                            </div>
                            
                             <div id="label" style="width:100px;padding-left:15px">
                        Dispositivo:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("botones","IdBoton","Identificador","(Estatus = 1 and TipoBoton=2) or(IdBoton=".$vc["IdBoton"].")","asc",1,$vc["IdBoton"])?>
                            </div>
                        </div>
                         <div id="fila" >
                            <div id="label" style="width:115px">Estatus:</div>
                            <div id="caja"><?php echo $SCA->regresaSelectBasicoRet("ctg_estatus","IdEstatus","Estatus","1=1","asc",1,$vc["Estatus"])?></div>
                        </div>
                      </fieldset>
                      
   
                      
                       <fieldset >
                        <legend ><img src="../../Imagenes/image.gif" width="16" height="16" />&nbsp;Información Fotográfica</legend>
                        <div id="fila"></div>
                        <div id="fila">
                            <div id="caja">
                                <div id="i_f">
                                    <img src="<?if(strlen($frente) == 0){ echo 'muestra_imagen.php?im=' . $camion . 'f';}else{ echo'data:image/png;base64,' . $frente;} ?>" width="330" height="200" />
                                    
                                </div>
                            </div>

                            <div id="caja" style="padding-left:15px">
                                <div id="i_d">
                                    <img src="<?if(strlen($derecha) == 0){ echo 'muestra_imagen.php?im=' . $camion . 'd';}else{ echo'data:image/png;base64,' . $derecha;} ?>" width="330" height="200" />
                                </div>
                            </div>
                        </div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                                Frente:
                            </div>
                            <div id="caja">
                                <input name="frente" id="frente" type="file" class="text" />
                            </div>
                            <div id="label" style="width:100px;padding-left:15px">
           		                   Derecha:
                            </div>
                            <div id="caja">
                                <input name="derecha" id="derecha" type="file" class="text" />  
                            </div>
                        </div>
                            
                        <div id="fila">
                            <div id="caja">
                                <div id="i_t">
                                    <img src="<?if(strlen($atras) == 0){ echo 'muestra_imagen.php?im=' . $camion . 't';}else{ echo'data:image/png;base64,' . $atras;} ?>" width="330" height="200" />
                                </div>
                            </div>
                            <div id="caja" style="padding-left:15px">
                                <div id="i_i">
                                    <img src="<?if(strlen($izquierda) == 0){ echo 'muestra_imagen.php?im=' . $camion . 'i';}else{ echo'data:image/png;base64,' . $izquierda;} ?>" width="330" height="200" />
                                </div>
                            </div>
                        </div>
                            
                        <div id="fila">
                            <div id="label" style="width:100px;">
                                Atras:
                            </div>
                            <div id="caja">
                                <input name="atras" id="atras" type="file" class="text" /> 
                            </div>
                        
                            <div id="label" style="width:100px;padding-left:15px">
           		                   Izquierda:
                            </div>
                            <div id="caja">
                                	<input name="izquierda" id="izquierda" type="file" class="text" />  
                            </div>
                        </div>
                   </fieldset>
                      <fieldset >
                        <legend ><img src="../../Imgs/MenuIcons/CerrarSesion.gif" width="16" height="16" />&nbsp;Información de Seguro</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                            Aseguradora:</div>
                            <div id="caja">
                            <input name="aseguradora" id="aseguradora" type="text" class="text" value="<?php echo $vc["Aseguradora"] ?>" style="width:130px" />
                            </div>
                            <div id="label" style="width:90px;padding-left:15px">
           		        Póliza:</div>
                            	<div id="caja">
                                	 <input name="poliza" id="poliza" type="text" class="text" value="<?php echo $vc["PolizaSeguro"] ?>" style="width:100px" />  </div>
                              <div id="label" style="width:100px;padding-left:15px">
                    Vigencia:</div>
                          <div id="caja">
                           <input name="vigencia" id="vigencia" type="text" class="text" value="<?php echo $vc["vp"] ?>" style="width:100px" /> 
                            <img src="../../Imagenes/calendario.jpg" width="16" height="16" class="boton" id="b_vigencia" onMouseOver='new Calendar({inputField:"vigencia", dateFormat: "%d-%m-%Y", animation:false, trigger: "b_vigencia", weekNumbers: true,fdow:1, bottomBar: true, onSelect: function(){ this.hide();}});'  /></div>
                        </div>
                   </fieldset>
                   <fieldset >
                        <legend ><img src="../../Imgs/16-Cubicacion.gif" width="16" height="16" alt="cubicacion" />&nbsp;Información de Cubicación</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:60px;">Ancho:</div><div id="caja"><input name="ancho" id="ancho" type="text" class="monetario calcula_cubicacion" style="width:45px" value="<?php echo $vc["Ancho"] ?>" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Largo:</div><div id="caja"><input name="largo" id="largo" type="text" class="monetario calcula_cubicacion" style="width:45px" value="<?php echo $vc["Largo"] ?>" />&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Alto:</div><div id="caja"><input name="alto" id="alto" type="text" class="monetario calcula_cubicacion" style="width:45px" value="<?php echo $vc["Alto"] ?>" />&nbsp;m</div>
                          <div id="label" style="width:50px;padding-left:15px">Gato:</div><div id="caja"><input name="gato" id="gato" type="text" class="monetario calcula_cubicacion" style="width:45px" value="<?php echo $vc["EspacioDeGato"] ?>" />&nbsp;m<sup>3</sup></div>
                          <div id="label" style="width:80px;padding-left:15px">Extensión:</div><div id="caja"><input name="extension" id="extension" type="text" class="monetario calcula_cubicacion" style="width:45px" value="<?php echo $vc["AlturaExtension"] ?>" />&nbsp;m</div>
                        </div>
                        
                        
                    <div id="fila" >
                        <div id="label" style="width:100px">Disminuci&oacute;n:</div><div id="caja"><input name="disminucion" id="disminucion" type="text" class="monetario calcula_cubicacion" style="width:45px" value="<?php echo $vc["disminucion"] ?>" />&nbsp;m<sup>3</sup></div>
                        <b>
                          <div id="label" style="width:130px;padding-left:15px">Cubicaci&oacute;n. Real:</div><div id="caja"><input name="real" id="real" type="text" class="text" style="width:48px" readonly="readonly" value="<?php echo $vc["CubicacionReal"] ?>" />&nbsp;m<sup>3</sup></div>
                          <div id="label" style="width:165px;padding-left:20px">Cubicaci&oacute;n para Pago:</div><div id="caja"><input name="pago" id="pago" type="text" class="text" style="width:48px" readonly="readonly" value="<?php echo $vc["CubicacionParaPago"] ?>" />&nbsp;m<sup>3</sup></div>
                        </b>
                    </div>
                        
                        
                        
                                                                  
             </fieldset>
             
          				 <div id="fila"><div id="botones20" style="float:right" >&nbsp;</div></div>
                        <div id="fila"><div id="botones20" style="float:right"><div class="sboton refresh" IdCamion="<?php echo $camion ?>"></div><div class="sboton guardar" ></div></div></div>
          			</div>
                        
                        </div>
                        
                        <div id="mensajes">
                        </div>
					</form>
                <iframe name="ifr" id="ifr" width="1px" height="1px"></iframe>
             </div>
             </div>
             </div>
</body>
</html>