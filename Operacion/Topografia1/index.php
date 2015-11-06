<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
?>
<link href="../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../css/advertencias.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../inc/generales.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../inc/js/jquery-1.4.4.js"></script>
<script src="../../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>
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

	$("img.guardar").live("click", function(){
											var datos=$("form#frm").serialize();
											//alert (datos);
											valido=true;
															$("select").each(function(index){
															if($(this).attr("value")=="A99")
															valido=false;
															});
															$("input.valido").each(function(index){
															if($(this).attr("value")=="")
															valido=false;
															});
											if(!valido)
													{
														alert("Ingrese los campos que son obligatorios.");
													}
													else
													{
														$.getJSON("jq/consulta_topografia.php",datos,function(data){
																										  if((data.kind)=="green"){
																											  $.getJSON("jq/alta_topografia.php",datos,function(data){
																														ADV.setAdv(data);
																														if((data.kind)=="green"){
																															$("input.valido").attr("value","");
																															$("select").attr("value","A99");
																															}
																															$.post("jq/form.php",function(data){
																																			$("div#administracion").html(data);			 
																																			  });
																														});
																										  }else{
																											  alert("Ya existe una topografia para el bloque y ese material y fecha")
																											  }
																											  });
													}
											});
	
	$("select.bloque").live("change",function(){
											 valor = $("select.bloque").attr("value");
											 if(valor=="0"){
												 $.post("jq/alta_bloque.php",function(data){
																$("div#dialog").html(data);
																$("#dialog").dialog('open');
																});
											 }
											 });
	
	$("img.guardar_bloque").live("click", function(){
											var datos = $("form#frm_bloque").serialize();
											$.getJSON("jq/guarda_bloque.php",datos,
												   function(data){
													   ADV.setAdv(data);
													   if((data.kind)=="green"){
													  	$("input#nombre_bloque").attr("value","");
														$.post("jq/combo.php",function(data){
																					   $("div#bloque").html(data);
															   })
													   }
													   });
											
											});
	
	$(function(){
		   		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$('#dialog').dialog({
					modal: true,
					autoOpen: false,
					width: 800,
					buttons: 
					{
							"Cerrar": function() { 
							$(this).dialog("close"); 
						} 
					}
				});

  });
	
$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
	});



$("div.material").live("click",function(){
										Material = $(this).attr("Material");
										//alert(Material);
										$("div#bloque"+Material).toggle();
										});

$("div.bloque").live("click",function(){
									  Material = $(this).attr("Material");
									  Bloque = $(this).attr("Bloque");
									  $("div#tablita"+Material+Bloque).toggle();
									  });


$("img.eliminar").live("click", function(){
											var IdTopografia = $(this).attr("IdTopografia");
											if(confirm('Esta seguro de eliminar esta topografia?')){
												//alert(IdTopografia);
												datos="IdTopografia="+IdTopografia
											$.getJSON("jq/elimina_topografia.php",datos,
												   function(data){
													   ADV.setAdv(data);
													   if((data.kind)=="green"){
														$.post("jq/form.php",function(data){
														$("div#administracion").html(data);
															   })
													   }
													   });
											}
											});

$("img.editar").live("click",function(){
									  var IdTopografia = $(this).attr("IdTopografia");
									  datos="IdTopografia="+IdTopografia
									  $.post("jq/edita_topografia.php",datos,function(data){
																$("div#dialog").html(data);
																$("#dialog").dialog('open');
																});
									  });

$("img.guarda_modificacion").live("click",function(){
											var datos=$("form#frm_edita").serialize();
											//alert (datos);
											valido=true;
															
															if($("select#bloques").attr("value")=="A99")
															valido=false;
															if($("select#materiales").attr("value")=="A99")
															valido=false;
															
															$("input.valido edita").each(function(index){
															if($(this).attr("value")=="")
															valido=false;
															});
											if(!valido)
													{
														alert("Ingrese los campos que son obligatorios.");
													}
													else
													{
														$.getJSON("jq/consulta_topografia2.php",datos,function(data){
																											  //alert(datos);
																											  if((data.kind)=="green"){
																												  //alert("Se registra");
																												  $.getJSON("jq/guarda_modificacion.php",datos,function(data){
													   	ADV.setAdv(data);
													   	if((data.kind)=="green"){
														$("#dialog").dialog('close');
														$.post("jq/form.php",function(data){
														$("div#administracion").html(data);
															   })
													   }
													   });
																												  }else{
																													  alert("Ya existe una topografia para el bloque y ese material y fecha");
																													  }
																											  });
														
														}
												   });


</script>
<style>
.reporte{border:#ccc solid 1px; color:#333;}
table.reporte thead th, table.reporte tfoot td{ background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#FFF; font-weight:bold;}
table.reporte.cuenta_bancaria thead th, table.reporte.cuenta_bancaria tfoot td{ background-image:url(../../Imgs/bg_gris.png); background-color:#CCC; color:#000; font-weight:bold;}
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
table.reporte tr:hover,table.cuenta_bancaria tr:hover, tr.ingresos:hover, tr.egresos:hover{ background: url(../../Imgs/bg_5.png);}
tr.ingresos:hover, tr.egresos:hover{ cursor:pointer;}

#tabla{
	margin-left:100px;
	font-weight:bolder;
	border:#ccc solid 1px; color:#333;
	width:804px;
	}

.material{
	width:800px; 
	background-image:url(../../Imgs/bg_black.png); 
	color:#FFF;
	font-size:10px;
	font-weight:700;
	padding:2px;
	border:#FFF solid 1px;
	}
/*.bloque{
	width:700px; 
	color:#333; 
	font-weight:bolder;
	padding:2px;
	}*/
</style>
<br />
<div style="margin-left:50px;">
<div  style="font-size:4em; color: #069; vertical-align:middle;"><img src="../../Imagenes/Edit_48x48.gif"/>Topografia</div><br />
</div>
<br />
<form name="frm" id="frm">
<table align="center" class="reporte">
	<thead>
	<tr>
    	<th>FECHA</th>
        <th>BLOQUE</th>
        <th>MATERIAL</th>
        <th>VOL. PARCIAL</th>
        <th>VOL. COTA</th>
        <th>&nbsp;</th>
    </tr>
    	<td>
        <div class="demo">
        <input id="datepicker" name="fecha" type="text" value="<?php echo date("d-m-Y");?>" style="width:100px;" readonly="readonly">
        </div>
        </td>
        <td>
        <div id="bloque">
        <select name="bloque" class="bloque">
        	<option value="A99">-SELECCIONE-</option>
            <?php
			$sql = "SELECT * FROM bloques";
			$rsql = $SCA->consultar($sql);
			while($vsql = mysql_fetch_assoc($rsql)){
				?>
                <option value="<?php echo $vsql["IdBloque"];?>"><?php echo $vsql["Descripcion"]; ?></option>
                <?php
				}
			?>
        	<option value="0">Registrar Nuevo Bloque</option>
        </select>
        </div>
        </td>
        <td>
		<select name="materiales" class="material_combo">
        	<option value="A99">-SELECCIONE-</option>
            <?php
			$sql = "SELECT * FROM materiales";
			$rsql = $SCA->consultar($sql);
			while($vsql = mysql_fetch_assoc($rsql)){
				?>
                <option value="<?php echo $vsql["IdMaterial"];?>"><?php echo $vsql["Descripcion"]; ?></option>
                <?php
				}
			?>
        </select>
        </td>
        <td><input type="text" name="parcial" class="valido" onKeyUp="this.value=formateando(this.value); " value="0"></td>
        <td><input type="text" name="cota" class="valido" onKeyUp="this.value=formateando(this.value); " value="0"></td>
        <td><img src="../../Imagenes/guardar_big.gif" class="guardar"></td>
    </thead>
</table>
</form>
<br />
<div id="administracion">
<div id="tabla">
<?php
$materiales = "select distinct IdMaterial from topografias order by IdMaterial";
$rmateriales  = $SCA->consultar($materiales);
while($vmateriales = $SCA->fetch($rmateriales)){
	?>
    <div class="material" Material="<?php echo $vmateriales['IdMaterial']?>" ><?php echo $SCA->regresaDatos2('materiales','Descripcion','IdMaterial', $vmateriales['IdMaterial']) ?></div>
    <?php
	$bloques = "select distinct IdBloque from topografias where IdMaterial = '".$vmateriales['IdMaterial']."' order by IdBloque";
	$rbloques = $SCA->consultar($bloques);
	while($vbloques = $SCA->fetch($rbloques)){
		?>
        <div  style="display:none;" class="bloque" id="bloque<?php echo $vmateriales['IdMaterial']; ?>" Bloque="<?php echo $vbloques['IdBloque'];?>" Material="<?php echo $vmateriales['IdMaterial']; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $SCA->regresaDatos2('bloques','Descripcion','IdBloque', $vbloques['IdBloque']) ?>
        <div id="tablita<?php echo $vmateriales['IdMaterial']; ?><?php echo $vbloques['IdBloque'];?>" style="display:none; margin-left:100px;">
        <table class="reporte" width="700px;" align="center">
        	<tr>
            	<td align="center" background="../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Fecha</td>
            	<td align="center" background="../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Parcial</td>
            	<td align="center" background="../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Acumulado</td>
            	<td align="center" background="../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Cota</td>
            	<td align="center" background="../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Registra</td>
                <td align="center" background="../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">&nbsp;</td>
            </tr>
            <?php
		$topografias = "select *,DATE_FORMAT(topografias.Fecha,'%d-%m-%Y') as fecha from topografias where IdMaterial = '".$vmateriales['IdMaterial']."' and IdBloque = '".$vbloques['IdBloque']."' order by YEAR(Fecha),MONTH(Fecha),DAY(Fecha)";
		$rtopografias = $SCA->consultar($topografias);
		while($vtopografias = $SCA->fetch($rtopografias)){
			?>
            
            <tr>
            	<td align="center"><?php echo $vtopografias['fecha']; ?></td>
                <td align="right"><?php echo number_format($vtopografias['Parcial'],2);?></td>
                <td align="right">
                <?php
				$qacumulado = "SELECT sum(Parcial) as Acumulado FROM topografias WHERE IdBloque='".$vbloques['IdBloque']."' AND IdMaterial='".$vmateriales['IdMaterial']."' AND Fecha<'".$vtopografias['Fecha']."'";
				//echo $qacumulado;
				$racumulado = $SCA->consultar($qacumulado);
				$vacumulado = $SCA->fetch($racumulado);
				$vacumulado['Acumulado'];
				$acumulado = $vacumulado['Acumulado']+$vtopografias['Parcial'];
				echo number_format($acumulado,2);
				?>
                </td>
                <td align="right"><?php echo number_format($vtopografias['Cota'],2); ?></td>
                <td align="center"><img src="../../Imgs/16-Consultar.gif" title="<?php echo $SCA->regresaDatos2('usuarios','Descripcion','IdUsuario', $vtopografias['Registra']) ?> [<?php echo $vtopografias['Timestamp']; ?>]" ></td>
                <td align="center">
                    	<img src="../../Imgs/editar.gif" class="editar" IdTopografia="<?php echo $vtopografias["IdTopografia"];?>">
                        <img src="../../Imgs/eliminar.gif" class="eliminar" IdTopografia="<?php echo $vtopografias["IdTopografia"];?>">
                </td>
            </tr>
            <?php
			}
			?>
        </table>
        </div>
        </div>
        <?php
		}
	}
?>
</div>
</div>
<div id="dialog"></div>
<div id="mensajes"></div>
