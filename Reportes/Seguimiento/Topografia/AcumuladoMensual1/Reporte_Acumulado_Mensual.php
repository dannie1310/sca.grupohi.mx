<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Topografia_Acumulado_Mensual_'.date("d-m-Y").'_'.date("H.i.s").'.xls;"');
include("../../../../inc/php/conexiones/SCA.php");
include("../../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();

$inicial = formato_fecha_ingles($_REQUEST['inicial']);
$final = formato_fecha_ingles($_REQUEST['final']);
	
//echo $inicial;
$mes_inicio = explode("-", $inicial);
$mes_inicio[1];

$fecha_fin = explode("-", $final);
$anio_fin = $fecha_fin[0];
$mes_fin = $fecha_fin[1];
$tope = $anio_fin.'-'.$mes_fin;
//echo $tope;
?>
<table width="400">
<tr><td colspan="10">&nbsp;</td></tr>
<tr style="color:#000; font-weight:bold; font-size:16px;">
	<td colspan="3"><img src="http://192.168.101.7:82/test/Imgs/Logos/fcc.png"></td>
    <td colspan="7">PROYECTO PRESA DE ALMACENAMIENTO "ZAPOTILLO" <br> Rendimiento Acumulado Mensual de Colocaci&oacute;n</td>
</tr>
<tr><td colspan="10">&nbsp;</td></tr>
<tr><td colspan="10" align="right" style="font-weight:bold;"><i>Fecha de Corte:<?php echo $_REQUEST['final'];?></i></td></tr>
<tr><td colspan="10" align="right"><i>Fecha:<?php echo date("d-m-Y");?></i></td></tr>
</table>
<table width="400">
<tr style="background-color:#333; color:#FFF; font-weight:bold;">
	<td>Conceptos</td>
<?php
$sql = "select distinct MONTH(Fecha) as Mes,YEAR(Fecha) as Anio, concat(MONTHNAME(Fecha),' ',YEAR(Fecha)) as Fecha from topografias WHERE Fecha<='".$final."' order by YEAR(Fecha);";
$rsql = $SCA->consultar($sql);
while($vsql = $SCA->fetch($rsql)){
	?>
    <td><?php echo $vsql["Fecha"]; ?></td>
    <?php
	}
?>
	<td style="background-color:#06F; color:#FFF; font-weight:bold;">Volumen Total Acumulado(m<sup>3</sup>)</td>
</tr>
<?php
	$sql1 = "select distinct IdMaterial from topografias where Fecha<='".$final."'";
	$rsql1 = $SCA->consultar($sql1);
	while($vsql1 = $SCA->fetch($rsql1)){
		?>
        <tr>
        	<td style="background-color:#333; color:#FFF; font-weight:bold;"><?php echo $SCA->regresaDatos2('materiales','Descripcion','IdMaterial', $vsql1['IdMaterial']) ?></td>
           <?php
			$sql = "select distinct MONTH(Fecha) as Mes,YEAR(Fecha) as Anio, concat(MONTHNAME(Fecha),' ',YEAR(Fecha)) as Fecha from topografias WHERE Fecha<='".$final."' order by YEAR(Fecha);";
			$rsql = $SCA->consultar($sql);
			while($vsql = $SCA->fetch($rsql)){
			?>
    		<td>
			<?php 
			$sql2 = "select sum(Parcial) as Suma,MONTH(Fecha),YEAR(Fecha),IdMaterial from topografias where MONTH(Fecha)='".$vsql['Mes']."' AND YEAR(Fecha)='".$vsql['Anio']."' AND IdMaterial='".$vsql1['IdMaterial']."'  and Fecha<='".$final."' GROUP BY YEAR(Fecha),MONTH(Fecha)";
			$rsql2 = $SCA->consultar($sql2);
			$vsql2 = $SCA->fetch($rsql2);
			echo $vsql2['Suma'];
			//echo $sql2;
			?>
            </td>
    		<?php
			}
		?>
        	<td style="background-color:#fff; color:#000; font-weight:bold;">
			<?php //echo $SCA->regresaDatos2('topografias','sum(Parcial)','IdMaterial', $vsql1['IdMaterial']);
			$sql5 = "select sum(Parcial) as SumaMaterial from topografias where IdMaterial='".$vsql1['IdMaterial']."' and Fecha<='".$final."'";
			$rsql5 = $SCA->consultar($sql5);
			$vsql5 = $SCA->fetch($rsql5);
			echo $vsql5['SumaMaterial']
			//echo $sql5;
			?>
            </td>
        </tr>
        <?php
		}
?>
<tr>
	<td style="background-color:#06F; color:#FFF; font-weight:bold;">Totales(m<sup>3</sup>)</td>
    <?php
	$sql3 = "select sum(Parcial) as SumaMensual,MONTH(Fecha),YEAR(Fecha),IdMaterial from topografias where Fecha<='".$final."' group by YEAR(Fecha),MONTH(Fecha)";
	$rsql3 = $SCA->consultar($sql3);
	while($vsql3 = $SCA->fetch($rsql3)){
		?>
        <td style="background-color:#fff; color:#000; font-weight:bold;"><?php echo $vsql3['SumaMensual']; ?></td>
        <?php
		}
	?>
    <td style="background-color:#F00; color:#fff; font-weight:bold;">
    <?php
	$sql4 = "select sum(Parcial) as Total from topografias where Fecha<='".$final."'";
	$rsql4 = $SCA->consultar($sql4);
	$vsql4 = $SCA->fetch($rsql4);
	echo $vsql4['Total'];
	?>
    </td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr style="background-color:#06F; color:#FFF; font-weight:bold;">
	<td>Dias Efectivos</td>
    <?php
	$sql6 = "select count(IdTopografia) as dias,YEAR(Fecha),MONTH(Fecha) from topografias  where Fecha<='".$final."' group by YEAR(Fecha),MONTH(Fecha);";
	$rsql6 = $SCA->consultar($sql6);
	while($vsql6 = $SCA->fetch($rsql6)){
		?>
        <td align="right"><?php echo $vsql6['dias'].' d';?></td>
        <?php
		}
	?>
    <td align="right">
    	<?php
		$sql6 = "select count(IdTopografia) as TotalDias from topografias  where Fecha<='".$final."';";
		$rsql6 = $SCA->consultar($sql6);
		$vsql6 = $SCA->fetch($rsql6);
		echo $vsql6['TotalDias'].' d';
		?>
    </td>
</tr>
</table>