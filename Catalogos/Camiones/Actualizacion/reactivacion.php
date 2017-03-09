<?php ini_set("display_errors","on");
	session_start();
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link rel="stylesheet" type="text/css" media="all" href="../../../Clases/Calendario/calendar-blue2.css" title="win2k-cold-1" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../../Clases/Js/Reportes/ValidaRangosFechas.js"></script>
<script type="text/javascript" src="../../../Clases/js/CP.js"></script>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>

<body>
<table width="530" border="0" align="center" >
  <tr>
    <td width="21" rowspan="6">&nbsp;</td>
    <td colspan="5" class="Subtitulo">Seleccione los Filtros Deseados:</td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td width="51">&nbsp;</td>
    <td width="160" class="Concepto"> &nbsp;Fecha Inicial:</td>
    <td width="160">
      <span class="FondoSeriesUno">
        <input name="inicial"   type="text" id="FechaInicial" size="9" maxlength="10" class="text" value="<?php echo date("d-m-Y"); ?>"  />
        <img src="../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton" style="cursor:hand" />
      </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="Concepto">&nbsp;Fecha Final: </td>
    <td>
      <span class="FondoSeriesUno">
        <input name="final"  type="text" id="FechaFinal" size="9" maxlength="9" class="text" value="<?php echo date("d-m-Y"); ?>"/>
        <img src="../../../Imgs/calendarp.gif" width="19" height="21" align="baseline" id="boton2" style="cursor:hand" />
      </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
      <td class="Concepto">
        Seleccionar estatus
      </td>
      <td>
        <span class="FondoSeriesUno buscar">
          <select name="estatus" id="estatus">
            <option value=0>Pendientes</option>
            <option value=1>Actualizados</option>
            <option value=-1>Cancelados</option>
          </select>
        </span>
      </td>
    </tr>
</table>
<br>
<div id='ListaCamiones' align="center"></div>

<script type="text/javascript" src="../../../inc/js/jquery-1.4.4.js"></script>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
	$(document).ready(function() {
		
	 	$(".buscar").click(function(){
			fechainicial = $("#FechaInicial").val();
			fechafinal = $("#FechaFinal").val();
      		estatus =  $("#estatus").val();
      		datos='accion=Camiones'+'&inicial='+fechainicial+'&final='+fechafinal+'&estatus='+estatus;
      		
      		var respuesta =$.getJSON('lista_Camiones.php',datos,function(json){
      			//console.log(json);
      			tabla ='<table width="90%" border="0" align="center">';
	      		tabla = tabla +'<tr>';
  	    		tabla = tabla +'<td width="98" class="EncabezadoTabla" >ECONOMICO</td>';
  	    		tabla = tabla +'<td width="246" class="EncabezadoTabla">PROPIETARIO</td>';
  	    		tabla = tabla +'<td width="196" class="EncabezadoTabla">OPERADOR</td>';
  	    		tabla = tabla +'<td width="99" class="EncabezadoTabla">REAL</td>';
  	    		tabla = tabla +'<td width="99" class="EncabezadoTabla">PARA PAGO</td>';
  	    		tabla = tabla +'<td width="140" class="EncabezadoTabla">FECHA REGISTRO</td>';
  	    		tabla = tabla +'<td width="81" class="EncabezadoTabla">ESTATUS</td>';
	  			  tabla = tabla +'</tr>';
      			$.each(json,function(x,y){
      				//console.log(y.IdCamion);
      				val = y.rownum%2;
      				if(val ==0){
      					tabla = tabla +'<tr class="Item2" align="center">';
      				}
      				else{
      					tabla = tabla +'<tr class="Item1" align="center">';
      				}
      				tabla = tabla +'<td valign="bottom"  value="3" style="cursor:pointer;" class="camion" idReactivacion="'+y.idReactivacion+'">'+y.Economico+'</td>';
      				tabla = tabla +'<td valign="bottom">'+y.Propietario+'</td>';
      				tabla = tabla +'<td valign="bottom">'+y.Nombre+'</td>';
      				tabla = tabla +'<td valign="bottom">'+y.CubicacionReal+'</td>';
      				tabla = tabla +'<td valign="bottom">'+y.CubicacionParaPago+'</td>';
      				tabla = tabla +'<td valign="bottom">'+y.FechaRegistro+'</td>';
      				tabla = tabla +'<td valign="bottom">'+y.Estatus+'</td>';
      				tabla = tabla +'</tr>';
      			});
      			tabla = tabla +'</table>';
      			$('#ListaCamiones').html(tabla);
      		
      		});
      		
		});
		$(".buscar").click();
	});

	$('#ListaCamiones').on('click','td',function(){
		if($(this).attr('idReactivacion')){
			idReactivacion = $(this).attr('idReactivacion')
			document.location.href='camionReactivacion.php?v=0&idReactivacion='+idReactivacion;
		}
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
</body>
</html>
