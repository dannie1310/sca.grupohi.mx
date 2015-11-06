<?php
session_start();
require_once("../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();

$sql = "SELECT
	   bloques.IdBloque,
	   bloques.Descripcion as Bloque,
	   materiales.IdMaterial,
       materiales.Descripcion as Material,
       topografias.IdTopografia,
	   topografias.Fecha as Date,
       DATE_FORMAT(topografias.Fecha,'%d-%m-%Y') as Fecha,
       topografias.Parcial,
       topografias.Cota,
       usuarios.Descripcion as Usuario
  FROM    (   (   scatest.materiales materiales
               INNER JOIN
                  scatest.topografias topografias
               ON (materiales.IdMaterial = topografias.IdMaterial))
           INNER JOIN
              scatest.bloques bloques
           ON (bloques.IdBloque = topografias.IdBloque))
       INNER JOIN
          scatest.usuarios usuarios
       ON (usuarios.IdUsuario = topografias.Registra)
	   ORDER BY Date,IdBloque,IdMaterial";
//echo $sql;
$rsql = $SCA->consultar($sql);
?>
<link href="../../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<link href="../../../css/advertencias.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../inc/js/jquery-1.4.4.js"></script>
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
														$("div#tabla_formulario").html(data);
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
																											  //alert(datos);
																											  if((data.kind)=="green"){
																												  //alert("Se registra");
																												  $.getJSON("jq/guarda_modificacion.php",datos,function(data){
													   	ADV.setAdv(data);
													   	if((data.kind)=="green"){
														$("#dialog").dialog('close');
														$.post("jq/form.php",function(data){
														$("div#tabla_formulario").html(data);
															   })
													   }
													   });
																												  }else{
																													  alert("Ya existe una topografia para el bloque y ese material y fecha");
																													  }
																											  });
														
														}
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
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<!--<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Administracion de Topografias</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>-->
<br />
<div style="margin-left:50px;">
<div  style="font-size:4em; color: #069; vertical-align:middle;"><img src="../../../Imagenes/Edit_48x48.gif"/>Topografia</div><br />
<?php
$sql_menu = "select nm.Id_NivelMenu,nm.Ruta,nm.Icono,nm.Descripcion from niveles_menu as nm left join niveles_usuario as nu ON nu.Id_NivelMenu = nm.Id_NivelMenu where nu.IdUsuario = '".$_SESSION["IdUsuarioAc"]."' AND nu.Id_NivelMenu in (98,99)";
$rsql_menu = $SCA->consultar($sql_menu);
while($vsql_menu = $SCA->fetch($rsql_menu)){
	?>
    <span class="boton" style="margin-left:5px; font-size:12px;  color: #069; font-weight:bold;" id="<?php echo $vsql_menu["Descripcion"]; ?>" <?php if($vsql_menu["Id_NivelMenu"]!=99){?>onclick="window.location.href='../<?php echo $vsql_menu["Ruta"];?>';" <?php }?>><img src="../../../<?php echo $vsql_menu["Icono"];?>" />&nbsp;<?php echo $vsql_menu["Descripcion"]; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
	}
?>
</div>
<br />
<span class="boton" style="margin-left:450px; font-size:12px;  color: #069; font-weight:bold;">Administraci&oacute;n</span><br /><br />
<div id="tabla_formulario">
<table class="reporte" align="center" style="width:800px;">
	<thead>
    	<tr>
        	<th>#</th>
            <th>Fecha</th>
            <th>Bloque</th>
            <th>Material</th>
            <th>Parcial (m3)</th>
            <th>Acumulado (m3)</th>
            <th>Cota (m3)</th>
            <th>Registro</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		$i=1;
			while($vsql = $SCA->fetch($rsql)){
				?>
                <tr>
                	<td><?php echo $i; ?></td>
                    <td align="center"><?php echo $vsql['Fecha']; ?></td>
                    <td><?php echo $vsql['Bloque'];?></td>
                    <td><?php echo $vsql['Material'];?></td>
                    <td align="right"><?php echo number_format($vsql['Parcial'],2);?></td>
                    <td align="right">
                    	<?php
						$qacumulado = "SELECT sum(Parcial) as Acumulado FROM topografias WHERE IdBloque='".$vsql['IdBloque']."' AND IdMaterial='".$vsql['IdMaterial']."' AND Fecha<'".$vsql['Date']."'";
						//echo $acumulado;
						$rqacumulado = $SCA->consultar($qacumulado);
						$vqacumulado = $SCA->fetch($rqacumulado);
						$vqacumulado['Acumulado'];
						$acumulado = $vqacumulado['Acumulado']+$vsql['Parcial'];
						echo number_format($acumulado,2);
						?>
                    </td>
                    <td align="right"><?php echo number_format($vsql['Cota'],2);?></td>
                    <td align="center"><img src="../../../Imgs/16-Consultar.gif" title="<?php echo $vsql['Usuario'];?>" ></td>
                    <td align="center">
                    	<img src="../../../Imgs/editar.gif" class="editar" IdTopografia="<?php echo $vsql["IdTopografia"];?>">
                        <img src="../../../Imgs/eliminar.gif" class="eliminar" IdTopografia="<?php echo $vsql["IdTopografia"];?>">
                    </td>
                </tr>
                <?php
				$i++;
				}
		?>
    </tbody>
</table>
</div>
<div id="dialog"></div>
<div id="mensajes"></div>

