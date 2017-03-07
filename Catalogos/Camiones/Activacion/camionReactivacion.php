<?php 
session_start();
require_once("../../../inc/php/conexiones/SCA.php");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SCA.-Reactivaci&oacute; de Camiones</title>
<link href="../../../css/botones.css" rel="stylesheet" type="text/css" />
<link href="../../../css/formulario.css" rel="stylesheet" type="text/css" />
<link href="../../../css/principal.css" rel="stylesheet" type="text/css" />
<link href="../../../css/botones.css" rel="stylesheet" type="text/css" />
<link href="../../../css/advertencias.css" rel="stylesheet" type="text/css" />
<style>
	body{background:#FFF;}
	select#marcas,select#ctg_estatus{ width:130px}
	select#botones{ width:114px}

	@charset "utf-8";
	div#tabla{ margin:20px auto 0 auto; width:300px;}
	div#tabla div#fila{ clear:both; min-height:24px; overflow:hidden; margin-bottom:5px;}
	/*div#tabla div#label, div#tabla div#caja{ float:left; font-size:1.4em; overflow:hidden;}*/
	div#tabla
	div#titulo{  border:none; color: #090; display:block; max-width:600px; font-weight:bold;  font-size:1.4em; text-align:center;}
	div#label{ float:left; font-size:1.4em; overflow:hidden; color:#090;  font-weight: bold;}
	div#caja1{color:#666; font-size:1.4em; text-align: center }
	div#caja2{color:#06c; font-size:1.4em; text-align: center;  font-weight: bold;}


</style>

</head>

<body >


----------------------


 <script src="../../../css/slider/js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="../../../css/slider/js/jssor.slider-22.2.11.mini.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
        	var jssor_2_options = {
              $AutoPlay: true,
              $SlideDuration: 1000,
              $SlideEasing: $Jease$.$OutQuint,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_2_options);

            var jssor_1_options = {
              $AutoPlay: true,
              $SlideDuration: 1000,
              $SlideEasing: $Jease$.$OutQuint,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*responsive code begin*/
            /*you can remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1920);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            function ScaleSlider2() {
                var refSize = jssor_2_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1920);
                    jssor_2_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            ScaleSlider2();
            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            /*responsive code end*/
        });
    </script>
    <style>
        /* jssor slider loading skin oval css */

        .jssorl-oval img {
            animation-name: jssorl-oval;
            animation-duration: 1.2s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-oval {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
        .jssorb05 {
            position: absolute;
        }
        .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
            position: absolute;
            /* size of bullet elment */
            width: 16px;
            height: 16px;
            background: url('../../../css/slider/img/b05.png') no-repeat;
            overflow: hidden;
            cursor: pointer;
        }
        .jssorb05 div { background-position: -7px -7px; }
        .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
        .jssorb05 .av { background-position: -67px -7px; }
        .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }

        .jssora22l, .jssora22r {
            display: block;
            position: absolute;
            /* size of arrow element */
            width: 40px;
            height: 58px;
            cursor: pointer;
            background: url('../../../css/slider/img/a22.png') center center no-repeat;
            overflow: hidden;
        }
        .jssora22l { background-position: -10px -31px; }
        .jssora22r { background-position: -70px -31px; }
        .jssora22l:hover { background-position: -130px -31px; }
        .jssora22r:hover { background-position: -190px -31px; }
        .jssora22l.jssora22ldn { background-position: -250px -31px; }
        .jssora22r.jssora22rdn { background-position: -310px -31px; }
        .jssora22l.jssora22lds { background-position: -10px -31px; opacity: .3; pointer-events: none; }
        .jssora22r.jssora22rds { background-position: -70px -31px; opacity: .3; pointer-events: none; }
    </style>



---------------



<div id="layout">
<div id="cuerpo">
<div id="contenido" style="margin:0px">
<div id="opc_ctg">ACTIVACI&Oacute;N DE CAMIONES</div>
<hr/>
<div id="mnsj" class="instrucciones" style="min-width:95%;font-size:1.2em">Revisar datos del cami&oacute;n que se presentan a continuaci&oacute;n </div>
	<form id="frm" method="post" enctype="multipart/form-data" action="actualiza_camion.php">
		<input name="idReactivacion" id="idReactivacion" type="hidden" value="" />
		<div id="tabla" style="width:50%">

            <fieldset  >
                <legend ><img src="../../../Imagenes/Camiones.gif" width="16" height="16" />&nbsp;Informaci&oacute;n</legend> 
<?php
	$idReactivacion=$_GET['idReactivacion'];
	$sql="
				SELECT 
				idSolicitudReactivacion,
				IdCamion,
				s.descripcion as Sindicato,
				e.razonSocial,
				ca.Propietario,
				o.Nombre,
				ca.Licencia,
				ca.VigenciaLicencia,
				ca.Economico,
				ca.Placas,
				ca.PlacasCaja,
				m.Descripcion as marcas,
				ca.Modelo,
				ca.Ancho,
				ca.Largo,
				ca.Alto,
				ca.Gato,
				ca.Extension,
				ca.Disminucion,
				ca.CubicacionReal,
				ca.CubicacionParaPago,
				ca.estatus,
				ca.MotivoRechazo
				FROM solicitud_reactivacion_camion as ca
				LEFT JOIN sindicatos as s ON s.idsindicato = ca. idsindicato
				LEFT JOIN empresas AS e ON e.IdEmpresa = ca.IdEmpresa
				LEFT JOIN operadores AS o ON o.IdOperador = ca.IdOperador
				LEFT JOIN marcas As m ON m.IdMarca = ca.IdMarca
				WHERE idSolicitudReactivacion =".$idReactivacion.";";
		//echo $sql.'<br>';
		$link=SCA::getConexion();
		$r=$link->consultar($sql);

		while($newCamion=mysql_fetch_array($r)){


			$sql="
				SELECT 
				IdCamion,
				s.descripcion as Sindicato,
				e.razonSocial,
				Propietario,
				o.Nombre,
				o.NoLicencia,
				o.VigenciaLicencia,
				ca.Economico,
				ca.Placas,
				ca.PlacasCaja,
				m.Descripcion as marcas,
				ca.Modelo,
				ca.Ancho,
				ca.Largo,
				ca.Alto,
				ca.EspacioDeGato,
				ca.AlturaExtension,
				ca.Disminucion,
				ca.CubicacionReal,
				ca.CubicacionParaPago
				FROM camiones as ca
				LEFT JOIN sindicatos as s ON s.idsindicato = ca. idsindicato
				LEFT JOIN empresas AS e ON e.IdEmpresa = ca.IdEmpresa
				LEFT JOIN operadores AS o ON o.IdOperador = ca.IdOperador
				LEFT JOIN marcas As m ON m.IdMarca = ca.IdMarca
				WHERE IdCamion =".$newCamion['IdCamion'].";";
			//echo $sql.'<br>';
			$r2=$link->consultar($sql);

			while($oldCamion=mysql_fetch_array($r2)){
			$IdCamion = $oldCamion['IdCamion'];

?>
                	<table>
                		<tr>
                			<td></td>
                			<td><div id="titulo">Datos del Cami&oacute;n Actuales</div></td>
                			<td><div id="titulo">Datos en Solicitud</div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Sindicato:</div></td>
                			<td><div id="caja1" ><?php echo $oldCamion['Sindicato'];?></div></td>
                			<td><div id="caja2" ><?php echo $newCamion['Sindicato'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Empresa:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['razonSocial'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['razonSocial'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Propietario:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Propietario'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Propietario'];?></div></td>
                		</tr>
                		<tr>
                			<td><hr></td>
                			<td><hr></td>
                			<td><hr></td>
                		</tr>
                		<tr>
                			<td><div id="label">Operador:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Nombre'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Nombre'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">No Licencia:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['NoLicencia'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Licencia'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Vigecia Licencia:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['VigenciaLicencia'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['VigenciaLicencia'];?></div></td>
                		</tr>
                		<tr>
                			<td><hr></td>
                			<td><hr></td>
                			<td><hr></td>
                		</tr>				                		
                		<tr>
                			<td><div id="label">Eco:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Economico'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Economico'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Placas Cami&oacute;n:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Placas'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Placas'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Placas Caja:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['PlacasCaja'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['PlacasCaja'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Marca:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['marcas'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['marcas'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Modelo:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Modelo'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Modelo'];?></div></td>
                		</tr>
                		<tr>
                			<td><hr></td>
                			<td><hr></td>
                			<td><hr></td>
                		</tr>
                		<tr>
                			<td><div id="label">Ancho:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Ancho'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Ancho'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Largo:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Largo'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Largo'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Alto:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['Alto'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Alto'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Gato:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['EspacioDeGato'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Gato'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Extenci&oacute;n:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['AlturaExtension'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['Extension'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Cubicaci&oacute;n. Real:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['CubicacionReal'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['CubicacionReal'];?></div></td>
                		</tr>
                		<tr>
                			<td><div id="label">Cubicaci&oacute;n. para Pago:</div></td>
                			<td><div id="caja1"><?php echo $oldCamion['CubicacionParaPago'];?></div></td>
                			<td><div id="caja2"><?php echo $newCamion['CubicacionParaPago'];?></div></td>
                		</tr>
                		<tr>
                			<td colspan="3">
  

								<div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:500px;height:270px;overflow:hidden;visibility:hidden;">
							        <!-- Loading Screen -->
							      
							        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:500px;height:300px;overflow:hidden;">
<?php
		$sql3 ="
			SELECT imagen,
			CASE TipoC
			 WHEN 'f' THEN 'Frente Actual '
			 WHEN 'd' THEN 'Derecha Actual'
			 WHEN 'i' THEN 'Izquierda Actual'
			 WHEN 't' THEN 'Atras Actual'
			END AS Tipo
		    FROM camiones_imagenes 
		    WHERE IdCamion = ".$newCamion['IdCamion']." 
		      AND TipoC <> ''
		      AND id in (SELECT MAX(id) FROM camiones_imagenes 
		     WHERE IdCamion = ".$newCamion['IdCamion']."  AND TipoC <> '' 
		     GROUP BY TipoC)
		     Order BY TipoC
		";
		// echo $sql3;
		$r3=$link->consultar($sql3);

			while($oldImagenes=mysql_fetch_array($r3)){
				//echo $newImagenes['Tipo'].'<br> luis';
?>	
						            <div>
						                <img data-u="image" src="<? echo 'data:image/png;base64,' . $oldImagenes['imagen']; ?>" />
						                    <img data-u="image" src="<? echo 'data:image/png;base64,' . $newImagenes['imagen']; ?>" />
							                <div style="position:absolute;top:185px;left:10px;width:210px;height:50px;z-index:0;background-color:rgba(0,0,0,0.5);">
							                    <div style="position:absolute;top:5px;left:15px;width:500px;height:40px;z-index:0;font-size:30px;color:#ffffff;line-height:40px;"><? echo $oldImagenes['Tipo']?></div>
							                </div>
									</div>
<?php
								}
?>
							        </div>
							        <!-- Bullet Navigator -->
							        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
							            <!-- bullet navigator item prototype -->
							            <div data-u="prototype" style="width:16px;height:16px;"></div>
							        </div>
							        <!-- Arrow Navigator -->
							        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>
							        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>
						    	</div>

				    		</td>
				    		</tr>
				    	<tr>
							<td colspan="3">

						    	<div id="jssor_2" style="position:relative;margin:0 auto;top:0px;left:0px;width:500px;height:270px;overflow:hidden;visibility:hidden;">
							        <!-- Loading Screen -->
							      
							        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:500px;height:300px;overflow:hidden;">
<?php
		$sql3 ="
			SELECT imagen,
			CASE TipoC
			 WHEN 'f' THEN 'Frente Nuevo'
			 WHEN 'd' THEN 'Derecha Nueva'
			 WHEN 'i' THEN 'Izquierda Nueva'
			 WHEN 't' THEN 'Atras Nuevo'
			END AS Tipo 
			FROM solicitud_reactivacion_camion_imagenes
			WHERE idSolicitudReactivacion = ".$idReactivacion."
			Order BY TipoC
		";
		// echo $sql3;
		$r3=$link->consultar($sql3);

			while($newImagenes=mysql_fetch_array($r3)){
				//echo $newImagenes['Tipo'].'<br> luis';
	?>	
							            <div>
							                <img data-u="image" src="<? echo 'data:image/png;base64,' . $newImagenes['imagen']; ?>" />
							                	<div style="position:absolute;top:185px;left:10px;width:210px;height:50px;z-index:0;background-color:rgba(0,0,0,0.5);">
							                    <div style="position:absolute;top:5px;left:15px;width:500px;height:40px;z-index:0;font-size:30px;color:#ffffff;line-height:40px;"><? echo $newImagenes['Tipo']?></div>
							                    </div>
							            </div>  
<?php
								}
?>
									</div>

						        <!-- Bullet Navigator -->
						        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
						            <!-- bullet navigator item prototype -->
						            <div data-u="prototype" style="width:16px;height:16px;"></div>
						        </div>
						        <!-- Arrow Navigator -->
						        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>
						        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>
					    	</div>
            			</td>
            		</tr>
            		<tr>
            			<td>
            				<div class="Cancelar">
            					Motivo:
            				</div>
            			</td>
            			<td colspan="2">
            				<div class="Cancelar">
<?
	if($newCamion['estatus']==0)	{
		echo '<textarea  style="width:100% " class="observaciones"></textarea> ';
	}
	else{
		echo '<textarea  style="width:100% " class="observaciones" >'.$newCamion['MotivoRechazo'].'</textarea> ';
	}

?>

            					
            				</div>
            			</td>
            		</tr>
            		<tr>
            			<td colspan="2">
                        	<div id="fila">
	                        	<img data-u="image" src="<../../../../../Imagenes/validaviajes/enter.png"  class="regresar"/>
                        	</div>
            			</td>
<?
	if($newCamion['estatus']==0)	{
		echo '<td colspan="1">';
	}
	else{
		echo '<td colspan="1" hidden="true">';
	}

?>
                        	<div id="fila">
                        		<img data-u="image" src="<../../../../../Imagenes/ko.gif"  class="cancelar"/>
                        		<img data-u="image" src="<../../../../../Imagenes/ok.gif"  class="guardar"/>
                        	</div>
            			</td>
            		</tr>
            	</table>
	<?php
		}
	}
	?>	       
            </fieldset>
    	</div>
	</form>
</div>
</div>
</div>



<script type="text/javascript" src="../../../inc/js/jquery-1.4.4.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.regresar').on('click',function(){
			document.location.href='reactivacion.php?';
		});
	});

	$(document).ready(function() {
		$('.cancelar').on('click',function(){
			obser = $('.observaciones').val();
			idReactivacion = '<? echo  $idReactivacion?>';
			IdCamion = '<? echo  $IdCamion?>';
			if(obser){
				document.location.href='lista_Camiones.php?v=0&accion=cancelar'+'&idReactivacion='+idReactivacion+'&IdCamion='+ IdCamion+'&obser='+ obser;
			}
			else{
				alert('Llenar el campo de Motivo!!');
			}
		});
	});

	$(document).ready(function() {
		$('.guardar').on('click',function(){
			obser = $('.observaciones').val();
			idReactivacion = '<? echo  $idReactivacion?>';
			IdCamion = '<? echo  $IdCamion?>';
				document.location.href='lista_Camiones.php?v=0&accion=guardar'+'&idReactivacion='+idReactivacion+'&IdCamion='+ IdCamion+'&obser='+ obser;
		});
	});



</script>
</body>
</html>