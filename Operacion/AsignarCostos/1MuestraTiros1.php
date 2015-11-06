<?php 
	session_start();
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Catalogos/Genericas.php");
	$tiro=$_REQUEST[tiro];
	$fecha=$_REQUEST[fecha];
	$IdProyecto=$_SESSION['Proyecto'];
 ?>
<html>
<head>
<META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<script language="javascript" type="text/javascript" src="../../Clases/Js/Genericas.js"></script>
<!--<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>-->
<link href="../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../css/advertencias.css" rel="stylesheet" type="text/css" />
<script src="../../inc/js/jquery-1.4.4.js"></script>
<script src="../../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
$(function(){
		   		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$('#dialog').dialog({
					modal: true,
					autoOpen: false,
					width: 650,
					buttons: 
					{
							"Cerrar": function() { 
							$(this).dialog("close"); 
						} 
					}
				});

  });

	$("input.asignar").live("click",function(){
											 //alert('hola');
											 numero = $(this).attr("numero");
											 //alert(numero);
											 datos=$("form#frm"+numero).serialize();
											 //alert(datos);
											 $.post("3SolicitaCentros.php",datos,function(data){
																$("div#dialog").html(data);
																$("#dialog").dialog('open');
																
																														  
																});
											 });
	
	$("input.confirma_asignacion").live("click",function(){
														 var datos=$("form#frm_valida").serialize();
														 //alert(datos);
														 valido=true;
														 $("select").each(function(index){
															if($(this).attr("value")=="A99")
															valido=false;
															});
														 if(!valido)
													{
														alert("Ingrese los campos que son obligatorios.");
													}
													else
													{ 
														
														$.post("4Valida.php",datos,function(data){
																$("div#dialog").html(data);
																});
													}
														 });
	$("input.regresar").live("click",function(){
											  $.post("3SolicitaCentros.php",datos,function(data){
																$("div#dialog").html(data);
																
																
																														  
																});
											  });
</script>

<!--<link href="../../css/new.css" rel="stylesheet" type="text/css" />-->
</head>
<style>
.reporte{border:#ccc solid 1px; color:#333;}
table.reporte thead th, table.reporte tfoot td{ background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#FFF; font-weight:bold;}
table.reporte.cuenta_bancaria thead th, table.reporte.cuenta_bancaria tfoot td{ background-image:url(../../Imgs/bg_black.png); background-color:#CCC; color:#000; font-weight:bold;}
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
.boton2
{
	
	cursor:pointer;
	color: #333;
	border-style: solid;
	border:none;
	border-width: 1px;
	font-family: Trebuchet MS;
}
</style>
<body>
<table width="840" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" /> SCA.- Asignaci&oacute;n de Costos</td>
  </tr>
   <tr>
    <td  /> &nbsp;</td>
  </tr>
</table>
<?php
	$sql="Select distinct FechaLlegada from viajes where Estatus in(0,10,20)  order by FechaLlegada desc ";
	$link=SCA::getConexion();
	$row=$link->consultar($sql);
 ?>
<table width="700" border="0" align="center" class="reporte" bgcolor="#FFFFFF";>
<?php 
	$i=0;
	while($v=mysql_fetch_array($row))
		{ 
?>
			<thead>
			  <tr style="cursor:hand " onClick="cambiarDisplay('F<?php echo $i; ?>');cambiarDisplay('ms<?php echo $i; ?>');cambiarDisplay('mn<?php echo $i; ?>')">
				<td style="width:16px;"><img src="../../Imgs/add.gif" id="ms<?php echo $i; ?>"  <?php if($fecha==$v[FechaLlegada]){ ?>style="display:none "<?php } ?>  align="absmiddle" width="16" height="16" /onmouseover="this.src='../../Imgs/add.gif'" onMouseOut="this.src='../../Imgs/add.gif'" /><img src="../../Imgs/eliminar.gif" id="mn<?php echo $i; ?>" <?php if($fecha!=$v[FechaLlegada]){ ?>style="display:none "<?php } ?> align="absmiddle" width="16" height="16" /onmouseover="this.src='../../Imgs/eliminar.gif'" onMouseOut="this.src='../../Imgs/eliminar.gif'" /></td>
			    <th width="600"  align="left">
				<?php echo fecha($v[FechaLlegada]); ?></th>
                
			  </tr>
              </thead>
			  <tr  <?php if($fecha!=$v[FechaLlegada]){ ?>style="display:none "<?php } ?> id="F<?php echo $i; ?>">
				<td colspan="2">
					<table width="690" class="reporte">
						<?php 
						
						$origenes="
						select distinct(IdTipoOrigen) as IdTipoOrigen, TipoOrigen  from (select tor.IdTipoOrigen as IdTipoOrigen, v.IdOrigen as IdOrigen, 
tor.Descripcion as TipoOrigen from viajes as v, tiposorigenes as tor, origenes as o, tiros as t
 where tor.IdTipoOrigen=o.IdTipoOrigen and v.IdOrigen=o.IdOrigen and v.FechaLlegada='".$v[FechaLlegada]."' and
 v.IdTiro=t.IdTiro and v.Estatus in(0,10,20)) as Tabla group by IdTipoOrigen
						";
						//echo $origenes;
						$ro=$link->consultar($origenes);
						while($vo=mysql_fetch_array($ro))
						{ #new?>
                        
                        <tr>
                        		<td>&nbsp;</td>
                                
								<td colspan="5" align="left">&nbsp;<?php echo $vo[TipoOrigen]; ?></td>
			            </tr>
                        
                        <?php 
						
						#MATERIALES
						$material="select distinct(IdMaterial) as IdMaterial, Material  from (select tor.IdTipoOrigen as IdTipoOrigen, v.IdOrigen as IdOrigen, tor.Descripcion as TipoOrigen,  v.idmaterial as idmaterial, mat.Descripcion as Material
from materiales as mat, viajes as v, tiposorigenes as tor, origenes as o, tiros as t where mat.IdMaterial=v.IdMaterial and 
tor.IdTipoOrigen=o.IdTipoOrigen and v.IdOrigen=o.IdOrigen and v.FechaLlegada='".$v[FechaLlegada]."' and v.IdTiro=t.IdTiro and 
v.Estatus in(0,10,20) and tor.IdTipoOrigen=".$vo[IdTipoOrigen].") as Tabla 
						";
						//echo $material;
						$rm=$link->consultar($material);
						$j=0;
						while($vmat=mysql_fetch_array($rm))
						{
						?>
                        
                        <tr>
                          <td>&nbsp;</td>
                          <td>&nbsp;</td>
                          <td colspan="6" align="left" ><?php echo $vmat[Material]; ?></td>
                        </tr>
                        
                        <tr>
							  <td>&nbsp;</td>
							  <td align="center">&nbsp;</td>
							  <th align="center" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">DESTINO</th>
							  <th align="center" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">NO. VIAJES</th>
							  <th align="center" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">VOLUMEN</th>
							  <th align="center" style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">IMPORTE</th>
							  <th style="background-image:url(../../Imgs/bg_black.png); color:#FFF;">&nbsp;</th>
						  </tr>
                        </thead>
                        <?php
						
						$tiros="Select v.IdTiro as IdTiro, v.IdOrigen as IdOrigenh, t.Descripcion as Tiro, format(sum(VolumenPrimerKM),2) as Volumen, format(sum(ImportePrimerKM),2) as Importe, sum(ImportePrimerKM) as Importesc, count(IdViaje) as Viajes from origenes as o, tiros as t, viajes as v where o.IdOrigen=v.IdOrigen and o.IdTipoOrigen='".$vo[IdTipoOrigen]."' and v.FechaLlegada='".$v[FechaLlegada]."' and v.IdMaterial=".$vmat[IdMaterial]." and v.IdTiro=t.IdTiro and v.Estatus in(0,10,20) Group By v.IdTiro";
						//echo $tiros;
						$rt=$link->consultar($tiros);
						$pr=1;
						
						while($vt=mysql_fetch_array($rt))
							{ 
							
								
						?>	
                        
                        
                        <form name="frm" action="3SolicitaCentros.php" method="post" id="frm<?php echo $j; ?>">
							<tr >
								<td width="28">&nbsp;</td>
					          <td width="22">&nbsp;</td>
						         <td width="241"><?php echo $vt[Tiro]; ?>
                                   <input type="hidden" value="<?php echo $v[FechaLlegada];?>" name="fecha">
                                   <input type="hidden" value="1" name="tipoa">
                                   <input type="hidden" value="<?php echo $vt[IdTiro];?>" name="tiro">
                                   <input type="hidden" value="<?php echo $vt[IdOrigenh];?>" name="origen">
								   <input type="hidden" value="<?php echo $vmat[IdMaterial];?>" name="material">
                                   <input name="numero" type="hidden" value="1">
                                   <input type="hidden" value="<?php echo $vt[Viajes]; ?>" name="totalviajes">
                                   <input type="hidden" value="<?php echo $vt[Importesc]; ?>" name="importe">
                                   <input name="torigen" type="hidden" value="<?php echo $vo[IdTipoOrigen]; ?>"></td>
						         <td width="94" align="right"> <?php echo $vt[Viajes]; ?></td>
								<td width="89" align="right"><?php echo $vt[Volumen]; ?> m<sup>3</sup></td>
						        <td width="91" align="right">$ <?php echo $vt[Importe]; ?></td>
						        <td width="93"><input name="Submit" type="button" class="boton2 asignar" value="OPCIONES" numero="<?php echo $j ?>"></td>
							</tr>
							</form>
                            
                            
                            
						<?php  $pr++;}$j++;
						}#new
						
						}#MATERIALES?>
				  </table>
				</td>
			  </tr>
<?php $i++;}?>
</table>
<div id="dialog"></div>
<div id="mensajes"></div>
</body>
</html>
