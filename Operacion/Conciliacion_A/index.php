<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");
$SCA=SCA::getConexion();
$idusuario = $_SESSION["IdUsuarioAc"];


$query_permisos = "select * from sca_configuracion.usuarios_proyectos_modulos nu 
left join sca_configuracion.niveles_menu nm on nu.id_modulo=nm.Id_NivelMenu  where nm.IdPadre=110 and Id_Usuario=$idusuario and id_proyecto=$_SESSION[ProyectoGlobal]";
$rquery_permisos = $SCA->consultar($query_permisos);
while($vquery_permisos = mysql_fetch_assoc($rquery_permisos)){	
	switch ($vquery_permisos["Descripcion"]) {
    case "Generar":
        $generar=1;
        break;
    case "Aprobar":
        $aprobar=1;
        break;
    case "Desaprobar":
        $desaprobar=1;
        break;
	case "Modificar":
		$modificar=1;
		break;
	case "Eliminar":
		$eliminar=1;
		break;
		}		
}

?>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<link href="../../css/advertencias.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<script type="text/javascript" src="../../inc/js/jquery-1.4.4.js"></script>
<script type="text/javascript" src="../../inc/generales.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../Clases/js/CP.js"></script>
<!--<script src="../../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>-->
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

	
$(".crear").live("click",function(){
	if($("#sindicatos").val()=="A99"){
		alert("Seleccione un sindicato");
		}else{
			if(!$("#rutas").val()){
				alert("Seleccione por lo menos una ruta");
			}
			else{
				if(confirm("Se creara una nueva conciliacion, desea continuar?")) {
				datosG = $("form").serialize();
					//alert(datos);
					$.post("conciliar.php",datosG,function(data){
						$("#tabla").html(data);
						});
				} 
			}
				
		}	 
	});
	
$(".modificar").live("click",function(){
	id= $(this).attr("idconciliacion");
	cadenar= $(this).attr("rutas");
	if (cadenar.length>0)
		rutas=cadenar.split(",");
	else rutas=null;
	sindicatos = $(this).attr("idsindicato");
	inicial = $(this).attr("fecha_inicial");
	final = $(this).attr("fecha_final");
	datosG={'sindicatos':sindicatos
			,'inicial':inicial
			,'final':final
			,'id':id
			,'rutas':rutas
		};
	$.post("conciliar.php",datosG,function(data){
		$("#tabla").html(data);
	});
});
	
/*
Variables globales

*/
var datosG;
function refrescarConcliliando(){
	$.post("conciliar.php",datosG,function(data){
		$("#tabla").html(data);
	});
}



$(".desaprobar").live("click",function(){
	id= $(this).attr("idconciliacion");
	datos = 'id='+id;
	//alert(datos);
	$.post("desaprobar.php",datos,function(data){
					$("#tabla").html(data);
					});
	});
	
$(".aprobar").live("click",function(){
	id= $(this).attr("idconciliacion");
	datos = 'id='+id;
	$.post("aprobar.php",datos,function(data){
					$("#tabla").html(data);
					});
	});
	
	
$(".eliminar").live("click",function(){
	if(confirm("Se eliminara la conciliacion, desea continuar?")) {
	id= $(this).attr("idconciliacion");
	datos = 'id='+id;
	$.post("eliminar.php",datos,function(data){
					$("#tabla").html(data);
					});
	}
	});
	

$(".consultar").live("click",function(){
	id= $(this).attr("idconciliacion");
	datos = 'id='+id;
	$.post("consultar.php",datos,function(data){
					$("#tabla").html(data);
					});
	});
	
$(".consultar_pdf").live("click",function(){
	id= $(this).attr("idconciliacion");
	datos = 'id='+id;
	document.location.href='consultar_pdf.php?'+datos;
	/*$.post("consultar_pdf.php",datos,function(data){
					$("#tabla").html(data);
					});*/
	});
	

$(".checkbox").live("click",function(){
	idviaje=$(this).attr("id");
	idconciliacion = $(this).attr("conciliacion");
	//alert(id);
	datos='idconciliacion='+idconciliacion+'&idviaje='+idviaje;
	//alert(datos);
												   $.getJSON("update.php",datos,function(data){
													   if((data.kind)=="green"){
															$("#"+idviaje).addClass("ingresado");
															refrescarConcliliando();
													   }else{
														   	$("#"+idviaje).removeClass("ingresado");
														}

													});
													
	});
$(document).ready(function(){
	$(".top-list ul").hide();
	$('#codevalue').focus();
});
$('#codevalue').live('keydown', function (e) {
    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    if (key == 13) $("#buttoncode").trigger( "click" );
    if (key == 9) $("#buttoncode").trigger( "click" );
    //console.log(key);
});   	

$("#buttoncode").live("click", function() {
		$("tr").each(function( index ) {
			if ($( this ).attr('idcode')){
				console.log( index + ": " + $( this ).attr('idcode') );
				if($( this ).attr('idcode')==($('#codevalue').val()).toUpperCase()){
					console.log( "Encontrado "+$( this ).attr('idcode')+": " + $('#codevalue').val() );					
					if (!$( this ).hasClass( "ingresado" )){
						$('#msjticket').text("Encontrado.....");
						$( this ).trigger( "click" );
					}else $('#msjticket').text("Ya existe.....");							  		
			  		$('#codevalue').val('');
			  		return false;	  		
			  	}else{
			  		$('#msjticket').text("No se encontro coincidencia.....");
			  		//console.log( "son diferentes "+$( this ).attr('idcode')+": " + $('#codevalue').val() );
			  	}
		  	}
		});
	});

$(".top-list div").live("click",function(){
			//console.log($(this));

			$(".top-list ul").not($(this).next()).hide();
			$(this).next().toggle();
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
	
	font-weight:bolder;
	/*border:#ccc solid 1px; color:#333;*/
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
.ingresado{
	background-color:#80FF80;
	}
/*.bloque{
	width:700px; 
	color:#333; 
	font-weight:bolder;
	padding:2px;
	}*/
	li{
			list-style: none;
		}
		/*.top-list{
			color:white;
			border: solid 1px black;
			width: 200px;
		}
		.top-list li{
			color:blue;
		}*/
		.top-list div{
			background-color:black;
			background-image:url(../../Imgs/bg_black.png);
			color:#FFF;
			width:800px;
			padding:2px;
			margin-left:50px;

		}
</style>
<br />
<div style="margin-left:50px;">
<div  style="font-size:4em; color: #069; vertical-align:middle;"><img src="../../Imagenes/aprobacion.gif"/>Conciliaci&oacute;n</div><br />
</div>
<br />
<?php if($generar==1){?>
<form name="frm" id="frm">
<table align="center" class="reporte">
	<thead>
    	<tr>
        	<th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Sindicato</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
  <tr>
    <td><input name="inicial" type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php echo date("d-m-Y"); ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/>&nbsp;&nbsp;<img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" /></td>
    <td><span class="FondoSeriesUno">
      <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" value="<?php echo date("d-m-Y");?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/>
    </span><span class="FondoSeriesUno">&nbsp;&nbsp;<img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" /></span></td>
    <td>
    	<select name="sindicatos" class="sindicato_combo" id="sindicatos" >
        	<option value="A99">-SELECCIONE-</option>
            <?php
			$sql = "SELECT * FROM sindicatos ORDER BY Descripcion";
			$rsql = $SCA->consultar($sql);
			while($vsql = mysql_fetch_assoc($rsql)){
				?>
                <option value="<?php echo $vsql["IdSindicato"];?>"><?php echo $vsql["Descripcion"]; ?></option>
                <?php
				}
			?>
        </select>
    </td>
    <td>    	
    	<img src="../../Imagenes/guardar_big.gif" class="crear"/>
    </td>
  </tr>
  <tr >
  	<th colspan="2" style="background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#FFF;">Ruta</th>
  	<th colspan="2" style="background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#FFF;">Observaci&oacute;n</th>
  </tr>
  <tr>
  	<td colspan="2" >
  		<select name="rutas[]" class="sindicato_combo" id="rutas" multiple>
        	<!--<option value="A99">-SELECCIONE-</option>-->
            <?php
			$sql = "SELECT IdRuta,
					concat(r.Clave,'-', if(character_length(CAST(r.idruta AS CHAR(10)))=1,'0',''), CAST(r.idruta AS CHAR(10)), '   ',CAST(Totalkm AS CHAR(10)), ' Km [',o.Descripcion,' - ', t.Descripcion, ']') as Descripcion
					
				    from rutas r
				inner join origenes o using (IdOrigen)
				inner join tiros t using (IdTiro)

				 ORDER BY r.IdRuta;";
			$rsql = $SCA->consultar($sql);
			while($vsql = mysql_fetch_assoc($rsql)){
				?>
                <option value="<?php echo $vsql["IdRuta"];?>"><?php echo $vsql["Descripcion"]; ?></option>
                <?php
				}
			?>
        </select>
  	</td>
  	<td colspan="2">
  		<textarea name="observaciones" id="observaciones" style="width:270px;"></textarea>
    </td>
  </tr>
  <!--<tr>
  	<td colspan="4" style="background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#FFF;">Observaciones</td>
  </tr>
  <tr>
  	<td colspan="4">
  		<textarea name="observaciones" id="observaciones" style="width:500px;"></textarea>
    </td>
  </tr>-->
  </tbody>
</table>
</form>
<script type="text/javascript">
	function catcalc(cal) 
	{
	}
		Calendar.setup({
		inputField     :    "FechaInicial",			
		button		   :	"boton",
		ifFormat       :    "%d-%m-%Y",       
		showsTime      :    false,
		timeFormat     :    "24",
		onUpdate       :    catcalc
			});
</script>
<script type="text/javascript">
	function catcalc(cal) {
			}
			Calendar.setup({

				inputField     :    "FechaFinal",			
				button		   :	"boton2",
				ifFormat       :    "%d-%m-%Y",       
				showsTime      :    false,
				timeFormat     :    "24",
				onUpdate       :    catcalc
			});
</script>
<?php } ?>
<br />
<div id="administracion">

	<div id="tabla">
    <ul>
    <?php
	 $query_sindicato = "SELECT DISTINCT idsindicato FROM conciliacion";
	 $result_sindicato = $SCA->consultar($query_sindicato);
	 while($vsindicato = mysql_fetch_array($result_sindicato)){
		 ?>
         <li class="top-list">
		 <div><?php echo regresa("Sindicatos","Descripcion","IdSindicato",$vsindicato["idsindicato"])?>
		 <?php
								$query_importes_sindicato = "select count(d.idviaje) as viajes,sum(v.importe) as importe, sum(volumen) as volumen from
								conciliacion_detalle d
								left join viajes v using (idviaje)
								left join conciliacion c using (idconciliacion)
								where c.idsindicato=".$vsindicato["idsindicato"]."";
								$result_importes_sindicato = $SCA->consultar($query_importes_sindicato);
	 							while($v_importes_sindicato = mysql_fetch_array($result_importes_sindicato)){
									$importe_sindicato = $v_importes_sindicato["importe"];
									$viajes_sindicato = $v_importes_sindicato["viajes"];
									$volumen_sindicato = $v_importes_sindicato["volumen"];
									}
                            ?> (Viajes:<?php echo $viajes_sindicato;?> Importe:<?php echo number_format($importe_sindicato,2);?> Volumen:<?php echo number_format($volumen_sindicato,2);?>)
		 </div>
         	<ul>
            	<?php
				$query_folio = "SELECT *,DATE_FORMAT(fecha_inicial, '%d-%m-%Y') as fecha_inicial,DATE_FORMAT(fecha_final, '%d-%m-%Y') as fecha_final,observaciones FROM conciliacion WHERE idsindicato=".$vsindicato["idsindicato"]." ORDER BY idconciliacion DESC";
				$result_folio = $SCA->consultar($query_folio);
	 			while($vfolio = mysql_fetch_array($result_folio)){
	 				//$conciliacion_rutas="Select * from conciliacion_rutas where idconciliacion=$vfolio[idconciliacion]";
	 				$conciliacion_rutas="SELECT r.IdRuta as IdRuta,
							concat(r.Clave,'-', CAST(r.idruta AS CHAR(10)), '   ', CAST(TotalKM AS CHAR(10)),' km ',' [',o.Descripcion,' - ', t.Descripcion, ']') as Descripcion
						from rutas r
						left join conciliacion_rutas cr on r.idruta=cr.idruta
						inner join origenes o using (IdOrigen)
						inner join tiros t using (IdTiro)

						where cr.idconciliacion=$vfolio[idconciliacion] order by IdRuta ";
					$rconciliacion_rutas = $SCA->consultar($conciliacion_rutas);
					$array_rutas='';
					$array_rutas_descripcion='';
					$array_rutas_descripcion='';
					while($vconciliacion_rutas = mysql_fetch_assoc($rconciliacion_rutas)){
						$array_rutas[]=$vconciliacion_rutas['IdRuta'];
						$array_rutas_descripcion[$vconciliacion_rutas['IdRuta']]=$vconciliacion_rutas['Descripcion'];
					}
					//print_r($array_rutas_descripcion);
					?>
                    <li>
                    <table class="reporte" width="804px;" style="margin-left:10px; font-weight:600;">
                    	<tr>
                        	<td width="80px;">Folio: <?php echo $vfolio["idconciliacion"];?></td>
                            <td width="210px;">Periodo: <?php echo $vfolio["fecha_inicial"];?> al <?php echo $vfolio["fecha_final"];?></td>
							<td width="80px;">
                            <?php
								$query_importes = "select count(d.idviaje) as viajes,sum(v.importe) as importe, sum(volumen) as volumen from
								conciliacion_detalle d
								left join viajes v using (idviaje
)								left join conciliacion c using (idconciliacion)
								where c.idsindicato=".$vsindicato["idsindicato"]."
								and c.idconciliacion=".$vfolio["idconciliacion"]."";
								$result_importes = $SCA->consultar($query_importes);
	 							while($v_importes = mysql_fetch_array($result_importes)){
									$importe = $v_importes["importe"];
									$volumen = $v_importes["volumen"];
									$viajes = $v_importes["viajes"];
									}
                            ?>
                            Viajes:<?php echo $viajes;?>
                            </td>
                            <td width="120px;">Importe:<?php echo number_format($importe,2);?></td>
							<td width="120px;">Volumen:<?php echo number_format($volumen,2);?></td>
                            <td align="left"><?php if($vfolio["estado"]==1){ 
					?>
					<img src="../../Imagenes/info.gif" title="<?php  
					if($vfolio["observaciones"]!=""){echo $vfolio["observaciones"];}else{echo 'Sin Observaciones';}
					?>"/>
                    <?php
					if($modificar==1){
						
					?>
                    <img src="../../Imgs/editar.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" rutas="<?php if(isset($array_rutas)) echo implode(',', $array_rutas);  ?>" class="modificar" alt="Modificar" title="Modificar"/>
                    <?php } ?>
                    <img src="../../Imgs/16-Consultar.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" class="consultar" alt="Consultar" title="Consultar"/>
                    <img src="../../Imagenes/pdf.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" class="consultar_pdf" alt="Consultar PDF" title="Consultar PDF"/>
                    <?php if($eliminar==1){?>
                    <img src="../../Imagenes/ko.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" class="eliminar" alt="Eliminar" title="Eliminar"/>
                    <?php } if($aprobar==1){?>
                    <img src="../../Imagenes/ok.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" class="aprobar" alt="Aprobar" title="Aprobar"/>
                    <?php
					}
					}else{ 
						?>
                        <img src="../../Imagenes/info.gif" title="<?php  
					if($vfolio["observaciones"]!=""){echo $vfolio["observaciones"];}else{echo 'Sin Observaciones';}
					?>"/>
                        <img src="../../Imgs/16-Consultar.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" class="consultar" alt="Consultar" title="Consultar"/>
                        <img src="../../Imagenes/pdf.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" class="consultar_pdf" alt="Consultar PDF" title="Consultar PDF"/>
                        <?php if($desaprobar==1){?>
                        <img src="../../css/imagenes/alert-16.gif" idconciliacion="<?php echo $vfolio["idconciliacion"];?>" idsindicato="<?php echo $vfolio["idsindicato"];?>" fecha_inicial="<?php echo $vfolio["fecha_inicial"];?>" fecha_final="<?php echo $vfolio["fecha_final"];?>" class="desaprobar" alt="Desaprobar" title="Desaprobar"/>
                        <?php
						}
					}?>
            	</td>
                        </tr>
                        <tr>
                        	<td colspan="6">                        		
                    				Rutas:  <?php ksort($array_rutas_descripcion);  if(isset($array_rutas_descripcion)) echo implode(', ', $array_rutas_descripcion);  ?>                  			
                        	</td>
                        </tr>
                    </table></li>
                    
                    <?php
				}
                ?>
			</ul>
         </li>
         <?php
		 }
	?>
    </ul>
    <table class="reporte" width="60%" style="display:none;">
    	<thead>
        	<tr>
            	<th>Folio</th>
            	<th>Sindicato</th>
				<th>Periodo</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
		$conciliaciones = "SELECT *,DATE_FORMAT(fecha_inicial, '%d-%m-%Y') as fecha_inicial,DATE_FORMAT(fecha_final, '%d-%m-%Y') as fecha_final FROM conciliacion ORDER BY fecha_conciliacion";
		$rconciliaciones = $SCA->consultar($conciliaciones);
		while($vconciliaciones = mysql_fetch_assoc($rconciliaciones)){
			$conciliacion_rutas="Select * from conciliacion_rutas where idconciliacion=$vconciliaciones[idconciliacion]";
			$rconciliacion_rutas = $SCA->consultar($conciliacion_rutas);
			$array_rutas='';
			while($vconciliacion_rutas = mysql_fetch_assoc($rconciliacion_rutas)){
				$array_rutas[]=$vconciliacion_rutas['IdRuta'];
			}

		?>
        <tr>
        	<td><?php echo $vconciliaciones["idconciliacion"];?></td>
        	<td><?php echo regresa("Sindicatos","Descripcion","IdSindicato",$vconciliaciones["idsindicato"])?></td>
            <td><?php echo $vconciliaciones["fecha_inicial"];?> al <?php echo $vconciliaciones["fecha_final"];?></td>
            <td><?php if($vconciliaciones["estado"]==1){ 
					?>
                    <img src="../../Imgs/editar.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" idsindicato="<?php echo $vconciliaciones["idsindicato"];?>" fecha_inicial="<?php echo $vconciliaciones["fecha_inicial"];?>" fecha_final="<?php echo $vconciliaciones["fecha_final"];?>" class="modificar" alt="Modificar" title="Modificar"/>
                    <img src="../../Imgs/16-Consultar.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" idsindicato="<?php echo $vconciliaciones["idsindicato"];?>" fecha_inicial="<?php echo $vconciliaciones["fecha_inicial"];?>" fecha_final="<?php echo $vconciliaciones["fecha_final"];?>" class="consultar" alt="Consultar" title="Consultar"/>
                    <img src="../../Imagenes/ko.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" idsindicato="<?php echo $vconciliaciones["idsindicato"];?>" fecha_inicial="<?php echo $vconciliaciones["fecha_inicial"];?>" fecha_final="<?php echo $vconciliaciones["fecha_final"];?>" class="eliminar" alt="Eliminar" title="Eliminar"/>
                    <img src="../../Imagenes/ok.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" class="aprobar" alt="Aprobar" title="Aprobar"/>
                    <?php
					}else{ 
						?>
                        <img src="../../Imgs/16-Consultar.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" idsindicato="<?php echo $vconciliaciones["idsindicato"];?>" fecha_inicial="<?php echo $vconciliaciones["fecha_inicial"];?>" fecha_final="<?php echo $vconciliaciones["fecha_final"];?>" class="consultar" alt="Consultar" title="Consultar"/>
                        <img src="../../Imagenes/ko.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" idsindicato="<?php echo $vconciliaciones["idsindicato"];?>" fecha_inicial="<?php echo $vconciliaciones["fecha_inicial"];?>" fecha_final="<?php echo $vconciliaciones["fecha_final"];?>" class="Eliminar" alt="Eliminar" title="Eliminar"/>
                        <?php
					}?>
            </td>
        </tr>
        <?php
			}
		?>
        </tbody>
    </table>
    </div>
</div>
<div id="dialog"></div>
<div id="mensajes"></div>


