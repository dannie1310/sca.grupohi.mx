<?php
session_start();
include("../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../../css/advertencias.css" rel="stylesheet" type="text/css" />
<script src="../../../inc/js/jquery-1.4.4.js"></script>
<script src="../../../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
var ADV = {
			setAdv: function(data,del){
									del_i=3000;
									if(del==undefined||del==0||del==''){del = del_i;}
									$("div#mensajes div#mnsj.np").detach();
									$("div#mensajes div#mnsj.p").detach();
                					$("#mensajes").append("<div id='mnsj' class='" + data.kind + " np'>" + data.msg + "</div>");
                					$("div#mensajes div#mnsj.np").fadeIn("slow").delay(del).fadeOut("slow");
									$("div#mensajes div#mnsj.p").fadeIn("slow");
								  },
			setAdvBig: function(div,data){
									$(div).html("<div id='mnsj_big' class='" + data.kind + " np'>" + data.msg + "</div>");
								  }
								  
	   	  }
		  
$("img.agregar_inicial").live("click",function(){
									   $.post("jq/form_registrar_inicial.php",function(data){
																$("div#dialog").html(data);
																$("#dialog").dialog('open');
																
																														  
																});
									   });

$("img.agregar").live("click",function(){
									   IdCentroCosto=$(this).attr("IdCentroCosto");
									   //alert(IdCentroCosto);
									   datos="IdCentroCosto="+IdCentroCosto
									   $.post("jq/form_registrar.php",datos,function(data){
																$("div#dialog").html(data);
																$("#dialog").dialog('open');
																
																														  
																});
									   });

$("img.registrar_inicial").live("click",function(){
										$("#dialog").dialog('close');
										datos=$("form#frm").serialize();
										//alert(datos);
										$.getJSON("jq/registrar_inicial.php",datos,function(data){
																					ADV.setAdv(data);
																					if(data.kind=="green"){
																						$.post("jq/form.php",datos,function(data){
																																	$("div#tabla").html(data);  
																																	  });
																						}
																				 }); 
										 });


$("img.registrar").live("click",function(){
										$("#dialog").dialog('close');
										datos=$("form#frm").serialize();
										//alert(datos);
										$.getJSON("jq/registrar.php",datos,function(data){
																					ADV.setAdv(data);
																					if(data.kind=="green"){
																						$.post("jq/form.php",datos,function(data){
																																	$("div#tabla").html(data);  
																																	  });
																						}
																				 }); 
										 });

$("img.eliminar").live("click",function(){
									   IdCentroCosto=$(this).attr("IdCentroCosto");
									   //alert(IdCentroCosto);
									   datos="IdCentroCosto="+IdCentroCosto
									   $.getJSON("jq/eliminar.php",datos,function(data){
																ADV.setAdv(data);
																if(data.kind=="green"){
																						$.post("jq/form.php",datos,function(data){
																																	$("div#tabla").html(data);  
																																	  });
																						}
																														  
																});
									   });

$("img.modificar").live("click",function(){
									   IdCentroCosto=$(this).attr("IdCentroCosto");
									   //alert(IdCentroCosto);
									   datos="IdCentroCosto="+IdCentroCosto
									   $.post("jq/form_modificar.php",datos,function(data){
																$("div#dialog").html(data);
																$("#dialog").dialog('open');
																
																														  
																});
									   });

$("img.guardar_modificacion").live("click",function(){
										$("#dialog").dialog('close');
										datos=$("form#frm").serialize();
										//alert(datos);
										$.getJSON("jq/modificar.php",datos,function(data){
																					ADV.setAdv(data);
																					if(data.kind=="green"){
																						$.post("jq/form.php",datos,function(data){
																																	$("div#tabla").html(data);  
																																	  });
																						}
																				 }); 
										 });

$("img.cambiar_estatus").live("click",function(){
											   if(confirm('La visibilidad cambiará, ¿desea continuar?')){
												   Estatus = $(this).attr("Estatus");
												   IdCentroCosto = $(this).attr("IdCentroCosto");
												   datos = "Estatus="+Estatus+"&IdCentroCosto="+IdCentroCosto;
												   //alert(datos);
												   $.getJSON("jq/modificar_estatus.php",datos,function(data){
																					ADV.setAdv(data);
																					if(data.kind=="green"){
																						$.post("jq/form.php",datos,function(data){
																																	$("div#tabla").html(data);  
																																	  });
																						}
																				 }); 
												   }
											   })


$(function(){
		   		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$('#dialog').dialog({
					modal: true,
					autoOpen: false,
					width: 500,
					buttons: 
					{
							"Cerrar": function() { 
							$(this).dialog("close"); 
						} 
					}
				});

  });
</script>
<style>
.reporte{border:#ccc solid 1px; color:#333;}
table.reporte thead th, table.reporte tfoot td{ background-image:url(../../../Imgs/bg_black.png); background-color:#CCC; color:#FFF; font-weight:bold;}
table.reporte.cuenta_bancaria thead th, table.reporte.cuenta_bancaria tfoot td{ background-image:url(../../../Imgs/bg_gris.png); background-color:#CCC; color:#000; font-weight:bold;}
table.reporte caption{ text-align:left; font-size:14px; color:#333; font-weight:bold; cursor:pointer; }
div.contenedor_reportes table.reporte caption{ display:none};
table.reporte td, table.reporte th{ padding:2px; color:#333;}
table.reporte td{ border-bottom:1px #CCC dotted;}
table.reporte td.concepto, table.reporte th.concepto{ }
table.reporte td.importe,table.reporte th.importe{ width:70px;}
table.reporte th.fecha,table.reporte td.fecha{ width:60px; text-align:center;}
table.reporte tr.agrupador:hover{ background-color:#CCC}
table.reporte td.monetario{ text-align:right;}
table.reporte td.contenedora{ padding:0px;}
table.reporte td.contenedora table.reporte { border:none}
table.reporte tr:hover,table.cuenta_bancaria tr:hover, tr.ingresos:hover, tr.egresos:hover{ background: url(../../../Imgs/bg_5.png);}
tr.ingresos:hover, tr.egresos:hover{ cursor:pointer;}
</style>
<title>Centros de Costo</title>
</head>
<body>
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Administracion de Centros de Costo</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<div id="tabla">
    <table style="width:600px;" align="center" class="reporte">
    	<thead class="header">
        	<tr>
            	<td colspan="3" align="right"><img src="../../../Imgs/add.gif" class="agregar_inicial"/></td>
            </tr>
            <tr>
                <th align="left" style="width:400px;">Centro de Costo</th>
                <th align="left" style="width:100px;">Cuenta</th>
                <th align="left" style="width:100px;">Opciones</th>
            </tr>
        </thead>
        <tbody>
        	<?php
			$SQL = "SELECT IdCentroCosto,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Concepto,Nivel,Cuenta,if(Estatus=1,'activo','inactivo') as Estatus FROM centroscosto ORDER BY Nivel";
			$RSQL = $sca->consultar($SQL);
			while($VSQL = $sca->fetch($RSQL)){
				?>
                <tr>
                	<td><?php echo utf8_decode($VSQL["Concepto"]);?></td>
                    <td><?php echo $VSQL["Cuenta"];?></td>
                    <td align="left">
                    	<img src="../../../Imgs/editar.gif"  title="Modificar" class="modificar" Nivel="<?php echo $VSQL["Nivel"]; ?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                        <img src="../../../Imgs/add.gif"  title="Agregar" class="agregar" Nivel="<?php echo $VSQL["Nivel"]; ?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                        <img src="../../../Imgs/eliminar.gif"  title="Eliminar" class="eliminar" Nivel="<?php echo $VSQL["Nivel"]; ?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                        <img src="../../../Imgs/<?php echo $VSQL["Estatus"]?>.gif" title="<?php echo $VSQL["Estatus"]?>" class="cambiar_estatus" Estatus="<?php echo $VSQL["Estatus"]?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                    </td>
                </tr>
                <?php
				}
			?>
        </tbody>
    </table>
    
</div>
<div id="dialog"></div>
<div id="mensajes"></div>
</body>
</html>