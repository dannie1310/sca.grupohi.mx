<?php 
	include("../../inc/php/conexiones/SCA.php");
	//include("../../Clases/Funciones/Catalogos/Genericas.php");
	require_once("../../inc/php/xajax/xajax_core/xajax.inc.php");
	$xajax = new xajax(); 
	$xajax->setCharEncoding('ISO-8859-1');
	$xajax->configure('decodeUTF8Input',true);
	$SCA = SCA::getConexion();
	function devuelve_numero($idArchivo,$tipoViaje,$tipoViajeDetalle)
	{
		$SCA = $GLOBALS["SCA"];	
		$SQLs = "SELECT Cantidad FROM archivoscargados_detalle_viajes where IdArchivoCargado=".$idArchivo." and IdTipoViaje=".$tipoViaje." and IdTipoViajeDetalle = ".$tipoViajeDetalle."";
		$r = $SCA->consultar($SQLs);
		$v = $SCA->fetch($r);
		return $v["Cantidad"];
	}
	function enlista_archivos($fi,$ff)
	{
		$rpt=new xajaxResponse();
		$SCA = $GLOBALS["SCA"];	
		$fi=fechasql($fi);
		$ff = fechasql($ff);
		$SQLs = "SELECT IdArchivoCargado, date_format(FechaCarga,'%d-%m-%Y') as Fecha, HoraCarga as Hora,NombreOriginal,CargadoPor FROM archivoscargados  where FechaCarga between '".$fi."' and '".$ff."'  order by FechaCarga,HoraCarga";
$r=$SCA->consultar($SQLs);
		$salida.='
		
<table class="tabla">
  <tr>
    <th scope="col" class="fecha">Fecha</th>
    <th scope="col" class="fecha">Hora</th>
    <th scope="col">Archivo</th>
   
  </tr>';
  
  while($v=$SCA->fetch($r))
{
  
  $salida.='<tr class="accion" archivo="'.$v["IdArchivoCargado"].'">
    <td class="fecha">'.$v["Fecha"].'</td>
    <td class="fecha">'.$v["Hora"].'</td>
    <td>'.$v["NombreOriginal"].'</td>

  </tr>';
}
$salida.='
</table>
		';	
		$rpt->assign("lista_archivos","innerHTML",$salida);
		return $rpt;
	}
	function muestra_detalle($archivo)
	{
		$rpt=new xajaxResponse();
		//$rpt->alert($archivo."s");
		$SCA = $GLOBALS["SCA"];
		$salida='<span class="clase">Archivo [<strong>'.$SCA->regresaDatos2("archivoscargados","NombreOriginal","IdArchivoCargado",$archivo).'</strong>] </span>
<table class="tabla" style="margin-top:15px">
<caption class="filter">Detalle de Viajes Procesados</caption>
<thead>
  <tr>
    <td>&nbsp;</td>
	<th>Viajes Detectados</th>
	<th>Viajes Inválidos</th>
	<th>Viajes Válidos</th>
	<th>Viajes Registrados Previamente</th>
    <th>Viajes Registrados con Archivo</th>
	<th>Diferencia</th>
  </tr>
</thead>
<tbody>
  <tr>
    <th>Viajes con Origen</th>
	<td>'.devuelve_numero($archivo,1,1).'</td>
	<td>'.devuelve_numero($archivo,1,2).'</td>
	<td>'.devuelve_numero($archivo,1,3).'</td>
	<td>'.devuelve_numero($archivo,1,4).'</td>
    <td>'.devuelve_numero($archivo,1,5).'</td>
	<td class="diferencia">'.abs(devuelve_numero($archivo,1,3)-(devuelve_numero($archivo,1,4)+devuelve_numero($archivo,1,5))).'</td>
  </tr>
  <tr>
    <th>Viajes sin Origen</th>
	<td>'.devuelve_numero($archivo,2,1).'</td>
	<td>'.devuelve_numero($archivo,2,2).'</td>
	<td>'.devuelve_numero($archivo,2,3).'</td>
	<td>'.devuelve_numero($archivo,2,4).'</td>
    <td>'.devuelve_numero($archivo,2,5).'</td>
	<td class="diferencia">'.abs(devuelve_numero($archivo,2,3)-(devuelve_numero($archivo,2,4)+devuelve_numero($archivo,2,5))).'</td>
  </tr>
  <tr class="total">
    <th>Total</th>
	<td>'.(devuelve_numero($archivo,1,1)+devuelve_numero($archivo,2,1)).'</td>
	<td>'.(devuelve_numero($archivo,1,2)+devuelve_numero($archivo,2,2)).'</td>
	<td>'.(devuelve_numero($archivo,1,3)+devuelve_numero($archivo,2,3)).'</td>
	<td>'.(devuelve_numero($archivo,1,4)+devuelve_numero($archivo,2,4)).'</td>
    <td>'.(devuelve_numero($archivo,1,5)+devuelve_numero($archivo,2,5)).'</td>
	<td class="diferencia">'.(abs(devuelve_numero($archivo,1,3)-(devuelve_numero($archivo,1,4)+devuelve_numero($archivo,1,5)))+ abs(devuelve_numero($archivo,2,3)-(devuelve_numero($archivo,2,4)+devuelve_numero($archivo,2,5)))).'</td>
  </tr>
  </tbody>
</table>';
		$rpt->assign("detalle_archivo","innerHTML",$salida);
		return $rpt;
	}
	function fechasql($cambio)
	{ 
		$partes=explode("-", $cambio);
		$dia=$partes[0];
		$mes=$partes[1];
		$año=$partes[2];
		$Fechasql=$año."-".$mes."-".$dia;
		return ($Fechasql);
	}
	$xajax->register(XAJAX_FUNCTION,"muestra_detalle");
		$xajax->register(XAJAX_FUNCTION,"enlista_archivos");

	$xajax->processRequest();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SCA.- Consulta de Tiempos entre Viajes</title>

<link href="../../inc/JSCal/css/steel/steel.css" rel="stylesheet" type="text/css" />
<link href="../../inc/JSCal/css/jscal2.css" rel="stylesheet" type="text/css" />
<link href="../../inc/JSCal/css/border-radius.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../inc/JSCal/js/jscal2.js"></script>
<script type="text/javascript" src="../../inc/JSCal/js/lang/es.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>


<script> 
$(document).ready(function(){
  $('tr.accion').live("click",function(){
									   		 //alert($(this).attr("archivo"));
											 xajax_muestra_detalle($(this).attr("archivo"));
									   });
});

</script>
 
<link href="../../Clases/Styles/RepSeg.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	font-family: Calibri, Trebuchet MS;
	font-size: 62.5%;
	color: #006699;
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}

table.tabla { font-size:1.2em; border-collapse:collapse; width:490px; margin:0 auto}

table.tabla td{ padding:2px;}
table.tabla caption, span.clase{ color:#666;}
table.tabla caption.filter, span.clase{ min-height:16px;  margin:0 0 20px 0; padding: 0 20px; font: normal normal bold 1em normal Verdana, Geneva, sans-serif; background:  white url(../../Imagenes/info.gif)   no-repeat 0 0 ; text-align:left}
span.clase{ background: white url(../../Imagenes/archivo.gif)  no-repeat 0 0 ; font-size:1.2em; font-weight:normal; margin-bottom:15px;}
table.tabla tr.total td,tr.total th, tr td.diferencia{  border:1px solid #666; font-weight:bold; background-color:#EEE}
img.boton{ cursor:pointer; vertical-align:text-bottom;}
table.tabla tr.total td.diferencia{ background-color:#CCC}
table.tabla thead th, table.tabla tbody th{ background-color:#CCC; color:#666; border:1px solid #666;}
table.tabla tbody td{ color:#666 ; border:1px solid #666; }
table.tabla thead tr th.fecha , table.tabla tbody tr td.fecha{ width:70px; text-align:center}
div#lista_archivos,
div#detalle_archivo{ width:50%; display:inline; float:left}
div#lista_archivos{ overflow:scroll; height:300px}
table.tabla tbody tr.accion:hover { background-color:#FFC; cursor:pointer }

-->
</style>
<?php
   $xajax->printJavascript("../../inc/php/xajax/");
 ?>
</head>

<body>
<form name="main" action="../Semanales/XCamionTurnoPeriodo/02axctp.php" method="post">
  <table align="center" style="margin-bottom:15px">
  <tr>
    	<td class="titulo" >SCA.- Reporte de Archivos Cargados en el Sistema</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="subtitulo">Seleccion el Periodo a Consultar</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
  	<tr>
      <td>
        <div id="cont"></div>
        <div id="info" style="text-align: center; margin-top: 1em;">Seleccione la Fecha Inicial</div>
      </td>
    </tr>
    <tr>
      <td >
        <input name="fi" type="hidden" id="fi" tabindex="1" value="<?php echo date("d-m-Y"); ?>" size="10" maxlength="10"/>
        <input name="ff" type="hidden" id="ff" tabindex="2" value="<?php echo date("d-m-Y"); ?>" size="10" maxlength="10" /></td>
    </tr>
    <tr>
      <td align="center"><input type="button" name="reset" id="reset" value="Consultar" onclick="xajax_enlista_archivos(xajax.$('fi').value,xajax.$('ff').value)" />
      </td>
    </tr>
    </table>

</form>
<div id="lista_archivos">

</div><div id="detalle_archivo">

</div>
    <script type="text/javascript">
	//<![CDATA[
 
      var SELECTED_RANGE = null;
      function getSelectionHandler() 
	  {
        var startDate = null;
        var ignoreEvent = false;
        return function(cal) 
		{
			var selectionObject = cal.selection;
 
            // avoid recursion, since selectRange triggers onSelect
            if (ignoreEvent)
				return;
 
            var selectedDate = selectionObject.get();
            if (startDate == null) 
			{
				startDate = selectedDate;
                SELECTED_RANGE = null;
                document.getElementById("info").innerHTML = "Seleccione la Fecha Final";
 
                // comment out the following two lines and the ones marked (*) in the else branch
                // if you wish to allow selection of an older date (will still select range)
                cal.args.min = Calendar.intToDate(selectedDate);
                cal.refresh();
            } 
			else 
			{
                ignoreEvent = true;
                selectionObject.selectRange(startDate, selectedDate);
                ignoreEvent = false;
                SELECTED_RANGE = selectionObject.sel[0];
 
                //alert(SELECTED_RANGE.toSource());
                //
                // here SELECTED_RANGE contains two integer numbers: start date and end date.
                // you can get JS Date objects from them using Calendar.intToDate(number)
 
                startDate = null;
				
				fechas_arr=selectionObject.print("%d-%m-%Y");
				
				farr=fechas_arr.toString();
				
				fechas_sp=farr.split(" -> ");
				document.getElementById('fi').value=fechas_sp[0];
				document.getElementById('ff').value=fechas_sp[1];

        
		document.getElementById("info").innerHTML = "El Rango de Fechas es del <br />"+selectionObject.print("%d-%m-%Y")+"<br /><br />Para seleccionar una nueva Fecha Inical, solo haga clic en ella.";
 
                // (*)
                cal.args.min = null;
                cal.refresh();
            }
        };
     };
 
      Calendar.setup({
              cont          : "cont",
              fdow          : 1,
              selectionType : Calendar.SEL_SINGLE,
              onSelect      : getSelectionHandler()
      });
 
    //]]>
	</script>
</body>

</html>