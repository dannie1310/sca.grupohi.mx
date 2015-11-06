<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");
$SCA=SCA::getConexion();
$IdProyecto=$_SESSION['Proyecto'];
$query = "SELECT * FROM conciliacion WHERE idconciliacion=".$_REQUEST['id']."";
$result=$SCA->consultar($query);
$row_result =mysql_fetch_array($result);
?>
<style>
table{border-collapse:collapse;}
</style>
<table width="90%;" style="margin-left:50px;">
	<tr>
        	<td style="color:#333;"><strong>PROYECTO: <?php echo regresa("Proyectos","Descripcion","IdProyecto",$IdProyecto)?></strong></td>
            <td><input type="button" value="Regresar a Conciliaciones" class="boton" onclick='javascript:location.href="index.php"'/></td>
    </tr>
    <tr>
        	<td style="color:#333;"><strong>FOLIO: <?php echo $row_result["idconciliacion"];?></strong></td>

    </tr>
    <tr>
        	<td style="color:#333;"><strong>SINDICATO: <?php echo regresa("Sindicatos","Descripcion","IdSindicato",$row_result["idsindicato"])?></strong></td>
    </tr>
    <tr>
            <td style="color:#333;"><strong>PERIODO: <?php echo fecha($row_result["fecha_inicial"]);?> al <?php echo fecha($row_result["fecha_final"]);?></strong></td>
    </tr>
</table>
<br>
<table border="0" align="center" width="90%">
        
        
        <tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">DIST.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VOLUMEN (m<sup>3 </sup>)</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> ($)</font></div></td>
        </tr>
        <?php
$query_detalle = "SELECT * FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=".$_REQUEST['id']."";
//echo $query_detalle;
$result_detalle=$SCA->consultar($query_detalle);
while($row = mysql_fetch_array($result_detalle)){
		?>
                <!--<tr style="background-color:#80FF80; color:#000000; font-size:8px;" id="<?php echo $row["IdViaje"]?>" conciliacion="<?php echo $id; ?>" class="<?php echo $class;?>">
            			<td><?php echo regresa("Camiones","Economico","IdCamion",$row["IdCamion"])?></td>
                		<td><?php echo $row["FechaLlegada"];?></td>
                        <td><?php echo $row["HoraLlegada"];?></td>
                        <td><?php echo $row["HoraSalida"];?></td>
                        <td>1</td>
                        <td><?php echo $row["CubicacionCamion"]?></td>
                        <td>1</td>
                        <td><?php echo $row["Distancia"]?></td>
                        <td><?php echo regresa("Materiales","Descripcion","IdMaterial",$row["IdMaterial"]);?></td>
                        <td><?php echo regresa("Origenes","Descripcion","IdOrigen",$row["IdOrigen"])?></td>
                        <td><?php echo regresa("Tiros","Descripcion","IdTiro",$row["IdTiro"])?></td>
                        <td align="right"><?php echo  number_format($row["VolumenPrimerKM"]+$row["VolumenKMSubsecuentes"]+$row["VolumenKMAdicionales"],2,".",",");?></td>
                        <td align="right"><?php echo  number_format($row["ImportePrimerKM"]+$row["ImporteKMSubsecuentes"]+$row["ImporteKMAdicionales"],2,".",",");?></td>
            		</tr>-->
<?php
	}
?>

<?php
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
		?>
		<tr><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">
            <?php if($x==1)echo regresa("Camiones","Economico","IdCamion",$row["IdCamion"]); ?>
          </font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil["FechaLlegada"]); ?></font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo regresa("Materiales","Descripcion","IdMaterial",$fil["IdMaterial"])?></font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo regresa("Origenes","Descripcion","IdOrigen",$fil["IdOrigen"])?></font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo regresa("Tiros","Descripcion","IdTiro",$fil["IdTiro"])?></font></div></td><td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["CubicacionCamion"]; ?> m<sup>3 </sup></font></div></td><td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["NumViajes"]; ?></font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Distancia"]; ?></font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil["Vol1KM"]+$fil["VolSub"]+$fil["VolAdic"],2,".",","); ?></font></div></td><td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo  number_format($fil["Importe"],2,".",",");?></font></div></td></tr>
        <?php
   $x++;
	}
	
	$query_subtotales = "SELECT count(v.IdViaje) as NumViajes, v.FechaLlegada, v.IdMaterial, v.IdOrigen, v.IdTiro, v.CubicacionCamion, v.Distancia as Distancia, sum(v.VolumenPrimerKM) as Vol1KM, sum(v.VolumenKMSubsecuentes) as VolSub, sum(v.VolumenKMAdicionales) as VolAdic, sum(v.ImportePrimerKM) as Imp1Km, sum(v.ImporteKMSubsecuentes) as ImpSub, sum(v.ImporteKMAdicionales) as ImpAdc, sum(v.Importe) as Importe FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=".$_REQUEST['id']." and v.IdCamion=".$row["IdCamion"]." GROUP BY v.IdCamion";
	//echo $query_subtotales;
	$result_subtotales=$SCA->consultar($query_subtotales);
	$row_subtotales = mysql_fetch_array($result_subtotales);
	?>
    <tr style="color:#333; font-size:10px;" >
    	<td>&nbsp;</td>
    	<td style="background-color:#DDD;"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">SUBTOTAL CAMION</font></td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;"align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $row_subtotales["NumViajes"]?></font></td>
        <td style="background-color:#DDD;">&nbsp;</td>
        <td style="background-color:#DDD;" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($row_subtotales["Vol1KM"]+$row_subtotales["VolSub"]+$row_subtotales["VolAdic"],2,".",","); ?></font></td>
        <td style="background-color:#DDD;" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($row_subtotales["Importe"],2,".",","); ?></font></td>
    </tr>
    <?php
}
$query_totales ="SELECT count(v.IdViaje) as NumViajes, v.FechaLlegada, v.IdMaterial, v.IdOrigen, v.IdTiro, v.CubicacionCamion, v.Distancia as Distancia, sum(v.VolumenPrimerKM) as Vol1KM, sum(v.VolumenKMSubsecuentes) as VolSub, sum(v.VolumenKMAdicionales) as VolAdic, sum(v.ImportePrimerKM) as Imp1Km, sum(v.ImporteKMSubsecuentes) as ImpSub, sum(v.ImporteKMAdicionales) as ImpAdc, sum(v.Importe) as Importe FROM conciliacion_detalle c LEFT JOIN viajes v USING (IdViaje) WHERE c.idconciliacion=".$_REQUEST['id']." GROUP BY c.idconciliacion";
$result_totales=$SCA->consultar($query_totales);
$row_totales = mysql_fetch_array($result_totales);
?>
	<tr style="background-color:#000;">
    	<td><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">TOTAL</font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo $row_totales["NumViajes"]?></font></td>
        <td>&nbsp;</td>
        <td align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($row_totales["Vol1KM"]+$row_totales["VolSub"]+$row_totales["VolAdic"],2,".",","); ?></font></td>
        <td align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($row_totales["Importe"],2,".",","); ?></font></td>
    </tr>



		</table>
