<?php
session_start();

require_once("../../../../Clases/dompdf/dompdf_config.inc.php");
require_once("../../../../inc/php/conexiones/SCA.php");

$SCA = SCA::getConexion();
$query = "select 
                v.idviaje
                , v.fechallegada
                , cubicacionCamion
                , o.descripcion as origen
                , Horasalida
                , horallegada
                , t.descripcion as tiro
                , importe
                , economico
                , 1 as turno
                , 1 as DIST
                , 1 as viajes                
                , VolumenPrimerKM + VolumenKMSubsecuentes + VolumenKMAdicionales as volumentotal
                , ImportePrimerKM + ImporteKMSubsecuentes + ImporteKMAdicionales as importetotal
                , m.descripcion as material
                , v.code AS code
				,s.idsindicato
				, c.idconciliacion
				, c.fecha_conciliacion
				, c.fecha_inicial
				, c.fecha_final
				, c.estado
				, c.observaciones
				,s.descripcion as sindicato
                  from conciliacion_detalle cd
                right join conciliacion c  on c.idconciliacion=cd.idconciliacion
                right join viajes v USING (idviaje)
                right join camiones cm  on cm.idcamion=v.idcamion 
                right join origenes o  on o.idorigen=v.idorigen 
                right join tiros t  on t.idtiro=v.idtiro 
                right join materiales m  on m.idmaterial=v.idmaterial 
				right join sindicatos s  on s.idsindicato=cm.idsindicato
				where idconciliacion_detalle is not null AND c.idconciliacion=$_REQUEST[id]";
$result = $SCA->consultar($query);
$row_result = '';
while ($row = $SCA->fetch($result))
    $row_result[] = $row;


function fecha($cambio) { //echo $cambio;
    $partes = explode("-", $cambio);
    $dia = $partes[2];
    $mes = $partes[1];
    $anio = $partes[0];
    $Fecha = $dia . "-" . $mes . "-" . $anio;
    return ($Fecha);
}

$html = '<style>
table{
	border-collapse:collapse;
	font-size:8px;
	}
</style>
<table style="width:100%">
	<tr>
        	<td colspan="2" style="height:80px;"><img src="http://sca.grupohi.mx/Operacion/ConciliacionReadCode/img/sca_login.jpg" width="106" height="67"></td>
            <td align="center">&nbsp;</td>
            <td valign="top" colspan="4" align="center"><strong>REPORTE DE CONCILIACION</strong></td>
        </tr>
	<tr>
        	<td style="color:#fff;background-color:#7ac142;"><strong>PROYECTO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>' . $_SESSION[NombreCortoProyecto] . '</strong></td>
			<td colspan="4">&nbsp;</td>
			<td colspan="2" style="color:#fff;background-color:#7ac142;"><strong>FECHA DE CONSULTA:</strong></td>
            <td colspan="2" style="background-color:#eee;">' . date("d-m-Y") . '</td>
    </tr>
    <tr>
        	<td style="color:#fff;background-color:#7ac142;"><strong>FOLIO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>' . $row_result[0]["idconciliacion"] . '</strong></td>

    </tr>
    <tr>
        	<td style="color:#fff;background-color:#7ac142;"><strong>SINDICATO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>' . $row_result[0]["sindicato"] . '</strong></td>
    </tr>
    <tr>
            <td style="color:#fff;background-color:#7ac142;"><strong>PERIODO:</strong></td>
			<td colspan="3" style="background-color:#eee;"><strong>' . fecha($row_result[0]["fecha_inicial"]) . ' al ' . fecha($row_result[0]["fecha_final"]) . '</strong></td>
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


foreach ($row_result as $key => $value) {
    $html.="<tr>";
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[economico]
            . '</font>'
            . '</div></td>';
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[fechallegada]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[material]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[origen]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[tiro]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[turno]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[cubicacionCamion]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . 1
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[DIST]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[volumentotal]
            . '</font>'
            . '</div></td>';
    
    $html.='<td>'
            . '<div align="center">'
            . '<font color="#000000" face="Trebuchet MS" style="font-size:8px;">'
            . $value[importetotal]
            . '</font>'
            . '</div></td>';
    
    $html.="</tr>";
}
$query_subtotales="SELECT  
                count(v.IdViaje) as NumViajes
                ,v.Distancia as DistanciaSS
		, sum(v.VolumenPrimerKM) as Vol1KM
		, sum(v.VolumenKMSubsecuentes) as VolSub
		, sum(v.VolumenKMAdicionales) as VolAdic
		, sum(v.ImportePrimerKM) as Imp1Km
		, sum(v.ImporteKMSubsecuentes) as ImpSub
		, sum(v.ImporteKMAdicionales) as ImpAdc
		, sum(v.Importe) as Importe 
FROM conciliacion_detalle c 
LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=$_REQUEST[id]";
$result_subtotales=$SCA->consultar($query_subtotales);
$row_subtotales = '';
while ($row = $SCA->fetch($result_subtotales))
    $row_subtotales = $row;

$html .='<tr style="color:#333; font-size:10px;" >
  <td>&nbsp;</td>
  <td style="background-color:#DDD;"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">TOTAL </font></td>
  <td style="background-color:#DDD;">&nbsp;</td>
  <td style="background-color:#DDD;">&nbsp;</td>
  <td style="background-color:#DDD;">&nbsp;</td>
  <td style="background-color:#DDD;">&nbsp;</td>
  <td style="background-color:#DDD;">&nbsp;</td>
  <td style="background-color:#DDD;" align="right">
  <font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.$row_subtotales["NumViajes"].'</font></td>
  <td style="background-color:#DDD;">&nbsp;</td>
  <td style="background-color:#DDD;" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.number_format($row_subtotales["Vol1KM"]+$row_subtotales["VolSub"]+$row_subtotales["VolAdic"],2,".",",").'</font></td>
  <td style="background-color:#DDD;" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:8px;">'.number_format($row_subtotales["Importe"],2,".",",").'</font></td>
  </tr>';

 $html .='</table>';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("ReporteConciliacion.pdf");
?>