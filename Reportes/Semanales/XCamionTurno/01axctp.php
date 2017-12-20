<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SCA.- Consulta de Tiempos entre Viajes</title>
<link href="../../../inc/JSCal/css/steel/steel.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/JSCal/css/jscal2.css" rel="stylesheet" type="text/css" />
<link href="../../../inc/JSCal/css/border-radius.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../inc/JSCal/js/jscal2.js"></script>
<script type="text/javascript" src="../../../inc/JSCal/js/lang/es.js"></script>
<link href="../../../Clases/Styles/RepSeg.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form name="main" action="02axctp.php?v=1" method="post">
  <table align="center">
  <tr>
    	<td class="titulo">SCA.- Reporte de Acarreos Ejecutados por Cami&oacute;n y Turno</td>
    </tr>
    <tr>
      <td class="titulo">(Por Periodo de Tiempo)</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="subtitulo">Selecci&oacute;n el d&iacute;a a Consultar</td>
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
      <td>
        <input name="fi" type="hidden" id="fi" tabindex="1" value="<?php echo date("d-m-Y"); ?>" size="10" maxlength="10"/>
        <input name="ff" type="hidden" id="ff" tabindex="2" value="<?php echo date("d-m-Y"); ?>" size="10" maxlength="10" /></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">
		<input type="submit" name="reset" id="reset" value="Consultar" />
		<input name="vista_previa" type="button" class="Boton vista_previa" value="Vista Previa">
      </td>
    </tr>
    </table>
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
</form>
<script type="text/javascript" src="../../../inc/js/jquery-1.4.4.js"></script>
<script>
$(document).ready(function() {
	  $(".vista_previa").click(function(){
		  //$("form").submit();
		  fechainicial = $("#fi").val();
		  fechafinal = $("#ff").val();
		  document.location.href='02axctp.php?v=0&inicial='+fechainicial+'&final='+fechafinal;
		  });
	});
</script>

</body>
</html>