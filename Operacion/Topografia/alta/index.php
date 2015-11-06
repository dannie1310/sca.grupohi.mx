<?php
session_start();
require_once("../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
?>
<link href="../../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../../css/advertencias.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../inc/generales.js"></script>
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
																															$("input.valido").attr("value","0");
																															$("select").attr("value","A99");
																															}
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
																					   $("div#bloque").html(data); 
															   })
													   }
													   });
											
											});
	
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

$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
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
<!--<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Alta de Topografias</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>-->
<br />
<div style="margin-left:50px;">
<div  style="font-size:4em; color: #069; vertical-align:middle;"><img src="../../../Imagenes/Edit_48x48.gif"/>Topografia</div><br />
<?php
$sql = "select nm.Id_NivelMenu,nm.Ruta,nm.Icono,nm.Descripcion from niveles_menu as nm left join niveles_usuario as nu ON nu.Id_NivelMenu = nm.Id_NivelMenu where nu.IdUsuario = '".$_SESSION["IdUsuarioAc"]."' AND nu.Id_NivelMenu in (98,99)";
$rsql = $SCA->consultar($sql);
while($vsql = $SCA->fetch($rsql)){
	?>
    <span class="boton" style="margin-left:5px; font-size:12px;  color: #069; font-weight:bold;" id="<?php echo $vsql["Descripcion"]; ?>" <?php if($vsql["Id_NivelMenu"]!=98){?> onclick="window.location.href='../<?php echo $vsql["Ruta"];?>';" <?php }?>><img src="../../../<?php echo $vsql["Icono"];?>" />&nbsp;<?php echo $vsql["Descripcion"]; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
	}
?>
</div>
<br />
<span class="boton" style="margin-left:500px; font-size:12px;  color: #069; font-weight:bold;">Alta</span><br /><br />
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
    	<!--<td>
        <input name="fecha" type="text" class="CasillasParaFechas" id="fecha" size="10" maxlength="10" value="<?php echo date("d-m-Y"); ?>" onChange='this.value=validafecha(this.value,"<?php echo date("d-m-Y"); ?>");'/>&nbsp;<img src="../../../Imgs/calendarp.gif" id="IFecha" width="19" height="21" align="absbottom" style="cursor:hand" />
        </td>-->
	 <td>
		<div class="demo">
        <input id="datepicker" name="fecha" type="text" value="<?php echo date('d-m-Y'); ?>" style="width:100px;" readonly>
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
        <td><?php echo $SCA->regresaSelectBasicoRet("materiales","IdMaterial","Descripcion","Estatus = 1","asc",1)?></td>
        <td><input type="text" name="parcial" class="valido" onKeyUp="this.value=formateando(this.value); " value="0"></td>
        <td><input type="text" name="cota" class="valido" onKeyUp="this.value=formateando(this.value); " value="0"></td>
        <td><img src="../../../Imagenes/guardar_big.gif" class="guardar"></td>
    </thead>
</table>
</form>
<div id="dialog"></div>
<div id="mensajes"></div>
<!--
<script type="text/javascript">
function catcalc(cal) 
	{
	}
		Calendar.setup({
		inputField     :    "fecha",			
		button		   :	"IFecha",
		ifFormat       :    "%d-%m-%Y",       
		showsTime      :    false,
		timeFormat     :    "24",
		onUpdate       :    catcalc
			});
</script>
-->