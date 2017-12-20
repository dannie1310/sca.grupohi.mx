<?php
session_start();

if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

require_once("../../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();

?>
<link rel="stylesheet" type="text/css" media="all" href="../../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../../../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="../../../../inc/js/jquery-ui-1.8.16.custom/development-bundle/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../../../../css/advertencias.css" rel="stylesheet" type="text/css" />
<link href="../../../../css/botones.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../../../inc/js/jquery-1.4.4.js"></script>
<script src="../../../../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>
<script>
$(function() {
		$( "#idatepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
		$( "#fdatepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
		
	});

$("input.valida").live("click",function(){
										
										});
</script>
<style>
.reporte{border:#ccc solid 1px; color:#333;}
table.reporte thead th, table.reporte tfoot td{ background-image:url(../../../../Imgs/bg_black.png); background-color:#CCC; color:#FFF; font-weight:bold;}
table.reporte.cuenta_bancaria thead th, table.reporte.cuenta_bancaria tfoot td{ background-image:url(../../../../Imgs/bg_gris.png); background-color:#CCC; color:#000; font-weight:bold;}
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
table.reporte tr:hover,table.cuenta_bancaria tr:hover, tr.ingresos:hover, tr.egresos:hover{ background: url(../../../../Imgs/bg_5.png);}
tr.ingresos:hover, tr.egresos:hover{ cursor:pointer;}
</style>
<link href="../../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="Titulo">SCA.- TOPOGRAFIA POR RENDIMIENTO DIARIO</td>
  </tr>
</table>
<br />
<form name="frm" action="Reporte_Rendimiento_Diario.php" method="post">
<table width="500" align="center" class="reporte">
	<thead>
    <tr>
    	<th>Fecha Inicial</th>
        <th>Fecha Final</th>
        <th>&nbsp;</th>
        <!--<th>Bloque</th>
        <th>Reporte</th>-->
    </tr>
    </thead>
    <tbody>
    <tr>
    	<td><input style="width:100px;" name="inicial" type="text" id="FechaInicial" readonly  value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $fini2; ?>" onChange='this.value=ValidaFechaIni(this.value,"<?php echo date("d-m-Y"); ?>",document.frm.FechaFinal.value);'/><img src="../../../../Imgs/calendarp.gif" width="19" height="21" id="boton" style="cursor:hand" /></td>
        <td><input style="width:100px;" name="final" type="text" id="FechaFinal"  readonly value="<?php if ($seg!=1)echo date("d-m-Y"); else if($seg=1)echo $ffin2; ?>"  onChange='this.value=ValidaFechaVen(document.frm.FechaInicial.value,"<?php echo date("d-m-Y"); ?>",this.value);'/><img src="../../../../Imgs/calendarp.gif" width="19" height="21" id="boton2" style="cursor:hand" /></td>
        <!--<td align="center"><?php //echo $SCA->regresaSelectBasicoRet("bloques","IdBloque","Descripcion","Estatus = 1","asc",1)?></td>
        <td align="center"><?php //echo $SCA->regresaSelectBasicoRet("materiales","IdMaterial","Descripcion","Estatus = 1","asc",1)?></td>-->
    <td colspan="5" rowspan="2"><div align="center">
      <input name="Submit" type="submit" class="Boton" value="Consultar Reporte">
      </div></td>
  </tr>
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