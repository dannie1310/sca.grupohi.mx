<?
session_start();
require_once("../../inc/php/conexiones/SCA.php");
?>


<!DOCTYPE html>
<html>
<head>
	<title>Modulo de Deducciones</title>
</head>


<script type="text/javascript" src="../../inc/js/jquery-1.4.4.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../Clases/js/CP.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>

<style type="text/css">
	table {
  		border: #1B98CC 1px solid;
	}

	#titulo{
  		 background: #1B98CC;
	}
	#title{
		color:#f5f6f7;
	}
</style>
<body>
<br>

<div  style="margin-left:50px;">
	<div  style="font-size:4em; color: #069; vertical-align:middle;"><img src="../../Imagenes/aprobacion.gif"/>Deducciones</div><br/>
</div>

<br>

<div align="center">
	<table>
		<thead>
			<tr>
				<td colspan="3" id="titulo">
					<div style="font-size:1.5em"  id="title" align="center">Ingresar parametros de Busqueda</div>
				</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<div style="font-size:1em">Fecha Inicial:</div>
				</td>
				<td>
					<input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php echo date("d-m-Y"); ?>"  />
				</td>
				<td>
					<img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" />
				</td>
			</tr>
			<tr>
				<td>
					<div style="font-size:1em">Fecha Final:</div>
				</td>
				<td>
					<input name="final"   type="text" id="FechaFinal" size="9" maxlength="10" class="text" value="<?php echo date("d-m-Y"); ?>"  />
				</td>
				<td>
					<img src="../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" />
				</td>
			</tr>
			<tr>
				<td>
					<div style="font-size:1em">Estatus:</div>
				</td>
				<td>
					<select name="estatus" id="estatus">
						<option value=-4>Seleccione...</option>
						<option value=0>Pendientes</option>
						<option value=1>Aprobados</option>
						<option value=2>Aplicados</option>
						<option value=3>Aplicados al viaje</option>
						<option value=-1>Cancelados</option>
						<option value=-2>No aplicados</option>
					</select>
				</td>
				<td></td>
			</tr>
		</tbody>	
	</table>
</div>
<div id="ListaDeduccion">
</div>
<div id="mensages">
</div>
</body>
</html>

<script type="text/javascript">
	$(document).ready(function(){

		$('#estatus').change(function(){
			fechaini = $('#FechaInicial').val();
			fechafin = $('#FechaFinal').val();
			estatus = $('#estatus').val();
			if(estatus > -4){
				if(!estatus){estatus = -3}
				$.post("consultas.php",{accion: "VerLista",fechaini,fechafin,estatus},function(data){
					$("#ListaDeduccion").html(data);
				});	
			}
			else{
				$("#ListaDeduccion").html('');
			}
		});
		$('#estatus').val(-3).change();
		$('#estatus').val(-4);
	});

	$('#ListaDeduccion').on('click',"#aprobar",function(){
		idDeduccion = $(this).parents('tr').attr('idDeduccion');
		$.post("consultas.php",{accion: "Aprobar",idDeduccion},function(data){
			$("#mensages").html(data);
		});
		$(this).parents('tr').hide();
	});

	$('#ListaDeduccion').on('click',"#cancelar",function(){
		idDeduccion = $(this).parents('tr').attr('idDeduccion');
		$.post("consultas.php",{accion: "Cancelar",idDeduccion},function(data){
			$("#mensages").html(data);
		});
		$(this).parents('tr').hide();
	});

</script>


<script type="text/javascript">
	function catcalc(cal){
	}
	Calendar.setup({
		inputField     :    "FechaInicial",			
		button		   :	"boton",
		ifFormat       :    "%d-%m-%Y",       
		showsTime      :    false,
		timeFormat     :    "24"
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
		timeFormat     :    "24"
	});
</script>
