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

<link href="../../inc/js/GreyBox_v5_54/GreyBox_v5_54/greybox/gb_styles.css" rel="stylesheet" type="text/css" media="all" />

<style>
body{background:#FFF;}
select#marcas{ width:130px}
select#botones{ width:114px}
div#i_f,div#i_i,div#i_d,div#i_t{ border:2px #06C solid; }
</style>

 
 
<script src="../../inc/js/jquery-1.4.4.js"></script>
<script src="../../inc/generales.js"></script>

 <script type="text/javascript">
        var GB_ROOT_DIR = "../../inc/js/GreyBox_v5_54/GreyBox_v5_54/greybox/";
    </script>
	<script type="text/javascript" src="../../inc/js/GreyBox_v5_54/GreyBox_v5_54/greybox/AJS.js"></script> 
    <script type="text/javascript" src="../../inc/js/GreyBox_v5_54/GreyBox_v5_54/greybox/AJS.js"></script> 
    <script type="text/javascript" src="../../inc/js/GreyBox_v5_54/GreyBox_v5_54/greybox/AJS_fx.js"></script>
    <script type="text/javascript" src="../../inc/js/GreyBox_v5_54/GreyBox_v5_54/greybox/gb_scripts.js"></script>

<script type="text/javascript">
var image_set_camiones = [
				 {'caption': 'Frente', 'url': '<?php echo ROOT; ?>Catalogos/Camiones/muestra_imagen.php?im=<?php echo $camion; ?>f'},
				 {'caption': 'Derecha', 'url': '<?php echo ROOT; ?>Catalogos/Camiones/muestra_imagen.php?im=<?php echo $camion; ?>d'},
				 {'caption': 'Atras', 'url': '<?php echo ROOT; ?>Catalogos/Camiones/muestra_imagen.php?im=<?php echo $camion; ?>t'},
                 {'caption': 'Izquierda', 'url': '<?php echo ROOT; ?>Catalogos/Camiones/muestra_imagen.php?im=<?php echo $camion; ?>f'}
				];
</script>



</head>

<body >
<div id="layout">
<div id="cuerpo">
<div id="contenido" style="margin:0px">
	
                <div id="opc_ctg">CONSULTA DE CAMIONES</div>
                    <hr />
                  
                <form id="frm" method="post" enctype="multipart/form-data" action="actualiza_camion.php" target="ifr"> 
               
                
                        <div id="frm_ctg">
 							                        	
					<div id="tabla" style="width:730px">
                    <fieldset >
                        <legend ><img src="../../Imagenes/Camiones.gif" width="16" height="16" />&nbsp;Información Básica</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                        
                            <div id="label" style="width:115px">
                              Sindicato:</div>
                            <div id="caja" style="width:230px"><?php echo $SCA->regresaDatos2("sindicatos","Descripcion","IdSindicato",$vc["IdSindicato"])?>
                            </div>

                            <div id="label" style="width:100px;padding-left:15px">
                              Empresa:</div>
                            <div id="caja" style="width:230px"><?php echo $SCA->regresaDatos2("empresas","razonSocial","IdEmpresa",$vc["IdEmpresa"])?>
                            </div>
                        </div>

                        <div id="fila" >    
                            <div id="label" style="width:115px">
                            Propietario:</div>
                            <div id="caja" ><?php echo $vc["Propietario"] ?>      </div>
                        </div>
                  <div id="fila" >
                            <div id="label" style="width:115px">
                          Operador:</div>
                            <div id="caja" style="width:230px"><?php echo $SCA->regresaDatos2("operadores","Nombre","IdOperador",$vc["IdOperador"] )?>
                            </div>
                            
                        <div id="label" style="width:100px; padding-left:15px">
                            Eco:</div>
                            <div id="caja"><?php echo $vc["Economico"] ?>
                       	  </div>
                  </div>
                    <div id="fila">
                        
                        <div id="label" style="width:115px;">
                            Placas Camión:</div>
                        <div id="caja" style="width:230px"><?php echo $vc["Placas"] ?>
                        </div>
                        <div id="label" style="width:100px; padding-left:15px">
                            Placas Caja:</div>
                        <div id="caja"><?php echo $vc["PlacasCaja"] ?>
                        </div>
                    </div>
                         <div id="fila" >
                            <div id="label" style="width:115px">
                            Marca:</div>
                            <div id="caja" style="width:130px"><?php echo $SCA->regresaDatos2("marcas","Descripcion","IdMarca",$vc["IdMarca"])?>
                            </div>
                            
                            <div id="label" style="width:100px;padding-left:15px">
                            Modelo:</div>
                            <div id="caja"><?php echo $vc["Modelo"] ?>
                            </div>
                            
                             <div id="label" style="width:100px;padding-left:15px">
                        Dispositivo:</div>
                            <div id="caja"><?php echo $SCA->regresaDatos2("botones","Identificador","IdBoton",$vc["IdBoton"])?>
                            </div>
                        </div>
                      </fieldset>
                       <fieldset >
                        <legend ><img src="../../Imagenes/image.gif" width="16" height="16" />&nbsp;Información Fotográfica</legend>
                        <div id="fila"></div>
                        <div id="fila"><div id="caja"><div id="i_f" onclick="return GB_showImageSet(image_set_camiones, 1)"><img src="muestra_imagen.php?im=<?php echo $camion; ?>f" width="330" height="200" /></div></div><div id="caja" style="padding-left:15px"><div id="i_d" onclick="return GB_showImageSet(image_set_camiones, 2)"><img src="muestra_imagen.php?im=<?php echo $camion; ?>d" width="330" height="200" /></div></div></div>
                        <div id="fila" >
                            <div id="label" style="width:334px; text-align:center; background-color:#06C;color:#fff;">
                            Frente</div>
                            <div id="caja">
                            
                            </div>
                            <div id="label" style="width:334px;margin-left:15px; text-align:center;background-color:#06C;color:#fff;">
           		        Derecha</div>
                            	<div id="caja">
                                	 </div>
                         </div>
                            
                            <div id="fila"><div id="caja"><div id="i_t" onclick="return GB_showImageSet(image_set_camiones, 3)"><img src="muestra_imagen.php?im=<?php echo $camion; ?>t" width="330" height="200" /></div></div><div id="caja" style="padding-left:15px"><div id="i_i" onclick="return GB_showImageSet(image_set_camiones, 4)"><img src="muestra_imagen.php?im=<?php echo $camion; ?>i" width="330" height="200" /></div></div></div>
                            
                            <div id="fila">
                              <div id="label" style="width:334px; text-align:center;background-color:#06C;color:#fff;">
                    Atras</div>
                          <div id="caja">
                            </div>
                        
                        <div id="label" style="width:334px;margin-left:15px;; text-align:center;background-color:#06C;color:#fff;">
           		        Izquierda</div>
                            	<div id="caja">
                                	  </div>
                        </div>
                   </fieldset>
                      <fieldset >
                        <legend ><img src="../../Imgs/MenuIcons/CerrarSesion.gif" width="16" height="16" />&nbsp;Información de Seguro</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:100px">
                            Aseguradora:</div>
                            <div id="caja" style="width:130px">
                            <?php echo $vc["Aseguradora"] ?>&nbsp;
                            </div>
                            <div id="label" style="width:100px;padding-left:15px">
           		        Póliza:</div>
                            	<div id="caja" style="width:130px">
                                	<?php echo $vc["PolizaSeguro"] ?> &nbsp; </div>
                              <div id="label" style="width:100px;padding-left:15px">
                    Vigencia:</div>
                          <div id="caja">
                           <?php echo $vc["vp"] ?> 
                            </div>
                        </div>
                   </fieldset>
                   <fieldset >
                        <legend ><img src="../../Imgs/16-Cubicacion.gif" width="16" height="16" alt="cubicacion" />&nbsp;Información de Cubicación</legend>
                        <div id="fila"></div>
                        <div id="fila" >
                            <div id="label" style="width:60px;">Ancho:</div><div id="caja" style="width:55px"><?php echo $vc["Ancho"] ?>&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Largo:</div><div id="caja" style="width:55px"><?php echo $vc["Largo"] ?>&nbsp;m</div>
                            <div id="label" style="width:50px;padding-left:15px">Alto:</div><div id="caja" style="width:55px"><?php echo $vc["Alto"] ?>&nbsp;m</div>
                          <div id="label" style="width:50px;padding-left:15px">Gato:</div><div id="caja" style="width:55px"><?php echo $vc["EspacioDeGato"] ?>&nbsp;m<sup>3</sup></div>
                          <div id="label" style="width:80px;padding-left:15px">Extensión:</div><div id="caja" style="width:55px"><?php echo $vc["AlturaExtension"] ?>&nbsp;m</div>
                        </div>
                        
                        
                <div id="fila" >
                  <div id="label" style="width:100px">Disminuci&oacute;n:</div><div id="caja" style="width:55px"><?php echo $vc["disminucion"] ?>&nbsp;m<sup>3</sup></div>
                  <b>
                    <div id="label" style="width:130px;padding-left:15px">Cubicaci&oacute;n. Real:</div><div id="caja"><?php echo $vc["CubicacionReal"] ?>&nbsp;m<sup>3</sup></div>
                    <div id="label" style="width:165px;padding-left:15px">Cubicaci&oacute;n para Pago:</div><div id="caja"><?php echo $vc["CubicacionParaPago"] ?>&nbsp;m<sup>3</sup></div>
                  </b>
                </div>
                        
                        
                        
                                                                  
             </fieldset>
          				 <div id="fila"><div id="botones20" style="float:right" >&nbsp;</div></div>
                       
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