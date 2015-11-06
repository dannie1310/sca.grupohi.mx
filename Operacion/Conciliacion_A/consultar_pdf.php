<?php
session_start();
require_once("../../Clases/dompdf/dompdf_config.inc.php");
require_once("../../inc/php/conexiones/SCA.php");
function fecha($cambio)
	{ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[2];
		$mes=$partes[1];
		$a�o=$partes[0];
		$Fecha=$dia."-".$mes."-".$a�o;
		return ($Fecha);
	}
	$SCA=SCA::getConexion();
//include("../../Clases/Funciones/Catalogos/Genericas.php");
$query_rutas = "SELECT r.IdRuta as IdRuta,
							concat(r.Clave,'-', CAST(r.idruta AS CHAR(10)), '   ', CAST(TotalKM AS CHAR(10)),' km ',' [',o.Descripcion,' - ', t.Descripcion, ']') as Descripcion
						from rutas r
						left join conciliacion_rutas cr on r.idruta=cr.idruta
						inner join origenes o using (IdOrigen)
						inner join tiros t using (IdTiro)

						where cr.idconciliacion=".$_REQUEST['id']." order by IdRuta";
$result_rutas=$SCA->consultar($query_rutas);
while($row = mysql_fetch_array($result_rutas)){
	$array[$row['IdRuta']]=$row['Descripcion'];
}
ksort($array);
//print_r($array);



$IdProyecto=$_SESSION['Proyecto'];
$query = "SELECT * FROM conciliacion WHERE idconciliacion=".$_REQUEST['id']."";
$result=$SCA->consultar($query);
$row_result =mysql_fetch_array($result);

if(isset($array)) $rutas=implode(', ', $array);
else $rutas="";
$html='<style>
table{
	border-collapse:collapse;
	font-size:8px;
	}
</style>
<table style="width:100%">
	<tr>
        	<td colspan="2" style="height:80px;"><img src="http://sca.grupohi.mx/Imgs/sca_login.jpg" width="106" height="67"></td>
            <td align="center">&nbsp;</td>
            <td valign="top" colspan="4" align="center"><strong>REPORTE DE CONCILIACION</strong></td>
        </tr>
	<tr>
        	<td style="color:#fff;background-color:#7ac142;"><strong>PROYECTO:<strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>'.$SCA->regresaDatos2("Proyectos","Descripcion","IdProyecto",$IdProyecto).'</strong></td>
			<td colspan="4">&nbsp;</td>
			<td colspan="2" style="color:#fff;background-color:#7ac142;"><strong>FECHA DE CONSULTA:<strong></td>
            <td colspan="2" style="background-color:#eee;">'.date("d-m-Y").'</td>
    </tr>
    <tr>
        	<td style="color:#fff;background-color:#7ac142;"><strong>FOLIO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>'.$row_result["idconciliacion"].'</strong></td>

    </tr>
    <tr>
        	<td style="color:#fff;background-color:#7ac142;"><strong>SINDICATO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>'.$SCA->regresaDatos2("Sindicatos","Descripcion","IdSindicato",$row_result["idsindicato"]).'</strong></td>
    </tr>
    <tr>
            <td style="color:#fff;background-color:#7ac142;"><strong>PERIODO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>'.fecha($row_result["fecha_inicial"]).' al '.fecha($row_result["fecha_final"]).'</strong></td>
    </tr>
    <tr>
    <td style="color:#fff;background-color:#7ac142;vertical-align: top;"><strong>RUTAS:</strong></td>
	<td colspan="11" style="background-color:#eee;"><strong>'.$rutas.'</strong></td>
    	
    </tr>
	<tr>
		<td>&nbsp;</td>
	</tr>';
$html.='<tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold ">ORIGEN</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold ">DESTINO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">DIST.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold ">VOLUMEN (m<sup>3 </sup>)</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px; font-weight:bold ">IMPORTE</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> ($)</font></div></td>
        </tr>';
       


	$query_camion = "SELECT DISTINCT(IdCamion) FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=".$_REQUEST['id']."";
$result_camion=$SCA->consultar($query_camion);
while($row = mysql_fetch_array($result_camion)){
	$rows="
	SELECT 
		 count(v.IdViaje) as NumViajes,
		 	v.FechaLlegada,
			v.IdMaterial,
			v.IdOrigen,
			v.IdTiro,
			v.CubicacionCamion, 
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.ImporteKMAdicionales) as ImpAdc,
			sum(v.Importe) as Importe FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje)
	WHERE c.idconciliacion=".$_REQUEST['id']." and v.IdCamion=".$row["IdCamion"]." GROUP BY v.FechaLlegada, v.CubicacionCamion,v.IdMaterial,v.IdOrigen,v.IdTiro";
//echo $rows;
$ro=$SCA->consultar($rows);
$x=1;
	while($fil=mysql_fetch_array($ro))
	{
		$html .='<tr>';
		if($x==1) {
			$html .='<td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$SCA->regresaDatos2("Camiones","Economico","IdCamion",$row["IdCamion"]).'</font>';
			}else{
				$html .='<td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;"></font>';
				}
		
		$html .='</div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.fecha($fil["FechaLlegada"]).'</font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$SCA->regresaDatos2("Materiales","Descripcion","IdMaterial",$fil["IdMaterial"]).'</font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$SCA->regresaDatos2("Origenes","Descripcion","IdOrigen",$fil["IdOrigen"]).'</font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$SCA->regresaDatos2("Tiros","Descripcion","IdTiro",$fil["IdTiro"]).'</font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">1</font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$fil["CubicacionCamion"].' m<sup>3 </sup></font></div></td><td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$fil["NumViajes"].'</font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$fil["Distancia"].'</font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.number_format($fil["Vol1KM"]+$fil["VolSub"]+$fil["VolAdic"],2,".",",").'</font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.number_format($fil["Importe"],2,".",",").'</font></div></td></tr>';
    
   $x++;
	}
	
	$query_subtotales = "SELECT count(v.IdViaje) as NumViajes, v.FechaLlegada, v.IdMaterial, v.IdOrigen, v.IdTiro, v.CubicacionCamion, v.Distancia as Distancia, sum(v.VolumenPrimerKM) as Vol1KM, sum(v.VolumenKMSubsecuentes) as VolSub, sum(v.VolumenKMAdicionales) as VolAdic, sum(v.ImportePrimerKM) as Imp1Km, sum(v.ImporteKMSubsecuentes) as ImpSub, sum(v.ImporteKMAdicionales) as ImpAdc, sum(v.Importe) as Importe FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=".$_REQUEST['id']." and v.IdCamion=".$row["IdCamion"]." GROUP BY v.IdCamion";
	//echo $query_subtotales;
	$result_subtotales=$SCA->consultar($query_subtotales);
	$row_subtotales = mysql_fetch_array($result_subtotales);
    $html .='<tr style="color:#333; font-size:10px;" >
    	<td>&nbsp;</td>
		<td style="background-color:#DDD;"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">SUBTOTAL CAMION</font></td>
		<td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;"align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$row_subtotales["NumViajes"].'</font></td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.number_format($row_subtotales["Vol1KM"]+$row_subtotales["VolSub"]+$row_subtotales["VolAdic"],2,".",",").'</font></td>
        <td style="background-color:#DDD;" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.number_format($row_subtotales["Importe"],2,".",",").'</font></td>
    </tr>';

}
$query_totales ="SELECT count(v.IdViaje) as NumViajes, v.FechaLlegada, v.IdMaterial, v.IdOrigen, v.IdTiro, v.CubicacionCamion, v.Distancia as Distancia, sum(v.VolumenPrimerKM) as Vol1KM, sum(v.VolumenKMSubsecuentes) as VolSub, sum(v.VolumenKMAdicionales) as VolAdic, sum(v.ImportePrimerKM) as Imp1Km, sum(v.ImporteKMSubsecuentes) as ImpSub, sum(v.ImporteKMAdicionales) as ImpAdc, sum(v.Importe) as Importe FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=".$_REQUEST['id']." GROUP BY c.idconciliacion";
$result_totales=$SCA->consultar($query_totales);
$row_totales = mysql_fetch_array($result_totales);

	$html .='<tr style="background-color:#000;">
    	<td><font color="#ffffff" face="Trebuchet MS" style="font-size:8px;">TOTAL</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:8px;">'.$row_totales["NumViajes"].'</font></td>
        <td>&nbsp;</td>
        <td align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:8px;">'.number_format($row_totales["Vol1KM"]+$row_totales["VolSub"]+$row_totales["VolAdic"],2,".",",").'</font></td>
        <td align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:8px;">'.number_format($row_totales["Importe"],2,".",",").'</font></td>
    </tr>
	</table>';
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '-1');
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("Reporte de Conciliacion.pdf");