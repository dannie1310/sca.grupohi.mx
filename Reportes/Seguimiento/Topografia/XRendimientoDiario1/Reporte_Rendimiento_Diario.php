<?php
session_start();

if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Topografia_Rendimiento_Diario_'.date("d-m-Y").'_'.date("H.i.s").'.xls;"');
include("../../../../inc/php/conexiones/SCA.php");
include("../../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();

$inicial = formato_fecha_ingles($_REQUEST['inicial']);
$final = formato_fecha_ingles($_REQUEST['final']);
	
?>
<table width="400">
<tr><td colspan="10">&nbsp;</td></tr>
<tr style="color:#000; font-weight:bold; font-size:16px;">
	<td colspan="3"><img src="http://192.168.101.7:82/test/Imgs/Logos/fcc.png"></td>
    <td colspan="7">PROYECTO PRESA DE ALMACENAMIENTO "ZAPOTILLO" <br> Rendimiento Diario de Colocaci&oacute;n</td>
</tr>
<tr><td colspan="10">&nbsp;</td></tr>
<tr><td colspan="10" align="right"><i>Rango de consulta:<?php echo $_REQUEST['inicial'];?> a <?php echo $_REQUEST['final'];?></i></td></tr>
<tr><td colspan="10" align="right"><i>Fecha:<?php echo date("d-m-Y");?></i></td></tr>
<?php
$sql = "select distinct IdBloque from topografias where Fecha>='".$inicial."' and Fecha<='".$final."' order by IdBloque";
$rsql = $SCA->consultar($sql);
while($vsql = $SCA->fetch($rsql)){
	?>
    <tr style="background-color:#333; color:#FFF; font-weight:bold;"><td colspan="10"><?php echo $SCA->regresaDatos2('bloques','Descripcion','IdBloque', $vsql['IdBloque']) ?></td></tr>
    	<?php
		$sql1 = "select distinct IdMaterial from topografias where Fecha>='".$inicial."' and Fecha<='".$final."' AND IdBloque='".$vsql['IdBloque']."' order by IdMaterial";
		$rsql1 = $SCA->consultar($sql1);
		while($vsql1 = $SCA->fetch($rsql1)){
			?>
            <tr style="background-color:#999; color:#FFF; font-weight:bold;"><td>&nbsp;</td><td colspan="9"><?php echo $SCA->regresaDatos2('materiales','Descripcion','IdMaterial', $vsql1['IdMaterial']) ?></td></tr>
            <?php
			$sql2 = "select * from topografias where Fecha>='".$inicial."' and Fecha<='".$final."' AND IdBloque='".$vsql['IdBloque']."' AND IdMaterial='".$vsql1['IdMaterial']."' ORDER BY Fecha";
			$rsql2 = $SCA->consultar($sql2);
				?>
                <tr style="color:#000; font-weight:bold; background-color:#EEE;">
                	<td colspan="2">&nbsp;</td>
                    <td colspan="2" align="center">Fecha</td>
                    <td colspan="2" align="right">Parcial(m<sup>3</sup>)</td>
                    <td colspan="2" align="right">Acumulado(m<sup>3</sup>)</td>
                    <td colspan="2" align="right">Cota(m<sup>3</sup>)</td>
                </tr>
                <?php
			while($vsql2 = $SCA->fetch($rsql2)){
				?>
                <tr style="color:#000; font-weight:bold; background-color:#EEE;">
                	<td colspan="2">&nbsp;</td>
                    <td colspan="2" align="center"><?php echo $vsql2['Fecha']; ?></td>
                    <td colspan="2" align="right"><?php echo number_format($vsql2['Parcial'],2); ?></td>
                    <td colspan="2" align="right">
                    <?php
						$qacumulado = "SELECT sum(Parcial) as Acumulado FROM topografias WHERE IdBloque='".$vsql['IdBloque']."' AND IdMaterial='".$vsql1['IdMaterial']."' AND Fecha<'".$vsql2['Fecha']."'";
						$rqacumulado = $SCA->consultar($qacumulado);
						$vqacumulado = $SCA->fetch($rqacumulado);
						$vqacumulado['Acumulado'];
						$acumulado = $vqacumulado['Acumulado']+$vsql2['Parcial'];
						echo number_format($acumulado,2);
					?>
                    </td>
                    <td colspan="2" align="right"><?php echo number_format($vsql2['Cota'],2); ?></td>
                </tr>
                <?php
				}
			}
	}
	?>
</table>

