<?php
//include("../../../Clases/Conexiones/Conexion.php");
include("../../../inc/php/conexiones/SCA.php");

session_start();

if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="../../../inc/js/ajax.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<link href="../../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<!--<link href="../../../Clases/Styles/RepSeg.css" rel="stylesheet" type="text/css" />-->
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function validafecha(fecha1,fecha2) 
	{	
		//fecha1 es de inicio//fecha2 es hoy; 
		//alert('validafecha("'+fecha1+'"'+fecha2+'")');
		var ano1= parseInt(String(fecha1.substring(fecha1.lastIndexOf("-")+1,fecha1.length)),10);
		var resto=new String(fecha1.substring(0,fecha1.lastIndexOf("-")));
		var mes1= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia1= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var ano2= parseInt(String(fecha2.substring(fecha2.lastIndexOf("-")+1,fecha2.length)),10);
		var resto=new String(fecha2.substring(0,fecha2.lastIndexOf("-")));
		var mes2= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia2= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);	

		if(ano2>ano1){
			//alert('Es menor que la fecha actual');
			var regresa=fecha1;
			}
		if(ano2<ano1){
				alert('Fecha no valida');
				var regresa=fecha2;
				}
		if(ano2==ano1){
				//alert('A�o igual');
				if(mes2>mes1){
					//alert('Mes menor al actual');
					var regresa=fecha1;
					}
				if(mes2<mes1){
					alert('Fecha no valida');
					var regresa=fecha2;
					}
				if(mes2==mes1){
					//alert('Mes igual al actual');
					if(dia2>dia1){
						//alert('Dia menor al actual');
						var regresa=fecha1;
						}
					if(dia2<dia1){
						alert('Fecha no valida');
						var regresa=fecha2;
						}
					if(dia2==dia1){
						//alert('Dia igual al actual');
						var regresa=fecha1;
						}
					}
				}
			
		
		return regresa;
		}
</script>
</head>

<body>
<div id="buscador">
	<table align="center">
    	<tr>
    <td colspan="3"><span class="EncabezadoPagina">Consulta de Lapsos entre Viajes por Destino</span></td>
  </tr>
  <tr>
    <td colspan="3" class="EncabezadoMenu" align="center">(Sistema de Control de Acarreos)</td>
  </tr>
  <tr>	
  	<td colspan="3">&nbsp;
    	
    </td>
  </tr>
    	<tr>
        	<td class="EncabezadoTabla">Selecciona el dia
            </td>
            <td align="center" class="EncabezadoTabla">Selecciona la Ruta
            </td>
            <td>&nbsp;
            	
            </td>
        </tr>
    	<tr>
        <td>
	<input name="fecha" type="text" class="CasillasParaFechas" id="fecha" size="10" maxlength="10" value="<?php echo date("d-m-Y"); ?>" onChange='this.value=validafecha(this.value,"<?php echo date("d-m-Y"); ?>");'/>&nbsp;<img src="../../../Imgs/calendarp.gif" id="IFecha" width="19" height="21" align="absbottom" style="cursor:hand" />
     		</td>
        
            <td align="center">
        	<?php
echo"
<select name='ruta' id='ruta' size=1 >";
	$link=SCA::getConexion();
    $qruta = "SELECT ru.IdRuta,ru.Clave AS Clave,ru.Estatus,o.IdOrigen,o.Descripcion As Origen,t.idTiro,t.Descripcion AS Destino FROM rutas AS ru LEFT JOIN origenes AS o ON ru.IdOrigen = o.IdOrigen LEFT JOIN tiros AS t ON ru.IdTiro = t.IdTiro"; 
	$result=$link->consultar($qruta);
    echo "<option value=0 >Seleccione una Ruta...</option>";
        while($row = mysql_fetch_array($result))
            {
             echo"<option value=$row[IdRuta]>$row[Clave]$row[IdRuta]-$row[Origen]<--------->$row[Destino]</option>";
            }
        echo"</select>";
?>
      
        </td>
        	<td>
            	<input type="button" onclick="busca('fecha','ruta')" value="Buscar" />
            </td>
        </tr>
    </table>
</div>
<div id="resultados">
</div>
</body>
</html>
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