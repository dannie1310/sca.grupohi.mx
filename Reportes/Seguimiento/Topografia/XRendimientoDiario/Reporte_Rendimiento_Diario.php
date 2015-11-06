<?php
session_start();
header("Content-type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="Topografia_Rendimiento_Diario_'.date("d-m-Y").'_'.date("H.i.s").'.xls"');
include("../../../../inc/php/conexiones/SCA.php");
include("../../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();

$inicial = formato_fecha_ingles($_REQUEST['inicial']);
$final = formato_fecha_ingles($_REQUEST['final']);
?>
<table width="400">
<tr style="color:#000; font-weight:bold; font-size:16px;">
	<td colspan="2"><img src="http://sca.grupohi.mx/Imgs/sca_login.jpg"></td>
    <td colspan="6" align="center">PROYECTO "<?php echo $SCA->regresaDatos2('proyectos','Descripcion','Estatus', 1)?>" <br> Rendimiento Diario de Colocaci&oacute;n <br /><font style="font-size:9px; font-weight:normal;">(<?php echo date("d-m-Y").'_'.date("H.i.s");?>)</font></td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>


<tr>
	<td align="right" style="font-weight:bold; background-color:#F00; color:#FFF;" colspan="2">
		<i>Fecha de Corte:</i></td><td><?php echo $_REQUEST['final'];?></td></tr>
<!--<tr><td align="right" style="font-weight:bold; background-color:#03F; color:#FFF; " colspan="2"><i>Fecha de Inicio Real:</td></tr>
<tr><td align="right" style="font-weight:bold; background-color:#03F; color:#FFF; " colspan="2"><i>Fecha de Termino Segun Proy Actual:</td></tr>
<tr><td align="right" style="font-weight:bold; background-color:#F00; color:#FFF; " colspan="2"><i>Fecha de Corte:</i></td><td><?php echo $_REQUEST['final'];?></td></tr>-->
<tr><td>&nbsp;</td></tr>
</table>
<table>
	<tr>
    	<td style="background-color:#333; color:#FFF; font-weight:bold;" align="center">Fecha</td>
        <td style="background-color:#333; color:#FFF; font-weight:bold;" align="center">Bloque</td>
        <?php
		$qmateriales = "select distinct IdMaterial from topografias where Fecha<='".$final."' order by IdMaterial";
		$rmateriales = $SCA->consultar($qmateriales);
		while($vmateriales = $SCA->fetch($rmateriales)){
			?>
            <td colspan="3" align="center" style="font-weight:bold; background-color:#03F; color:#FFF; border-left:#FFF solid 1px;"><?php echo $SCA->regresaDatos2('materiales','Descripcion','IdMaterial', $vmateriales['IdMaterial']) ?></td>
            <?php
			}
		?>
    </tr>
    <tr>
    	<td style="background-color:#333; color:#FFF; font-weight:bold;">&nbsp;</td>
        <td style="background-color:#333; color:#FFF; font-weight:bold;">&nbsp;</td>
        <?php
		$qmateriales = "select distinct IdMaterial from topografias where Fecha<='".$final."' order by IdMaterial";
		$rmateriales = $SCA->consultar($qmateriales);
		while($vmateriales = $SCA->fetch($rmateriales)){
			?>
            <td style="font-weight:bold; background-color:#03F; color:#FFF; border-left:#FFF solid 1px;">Parcial(m<sup>3</sup>)</td>
            <td style="font-weight:bold; background-color:#03F; color:#FFF; ">Acumulado(m<sup>3</sup>)</td>
            <td style="font-weight:bold; background-color:#03F; color:#FFF; ">Cota(m<sup>3</sup>)</td>
            <?php
			}
		?>
    </tr>
        <?php
		$qfecha = "select distinct Fecha,IdBloque from topografias where Fecha<='".$final."' order by Fecha, IdBloque";
		$rfecha = $SCA->consultar($qfecha);
		while($vfecha = $SCA->fetch($rfecha)){
			?>
            <tr style="border-bottom:#999 dotted 1px;">
            	<td><?php echo $vfecha['Fecha'];?></td>
                <td><?php echo $SCA->regresaDatos2('bloques','Descripcion','IdBloque', $vfecha['IdBloque']) ?></td>
                <?php
		$qmateriales = "select distinct IdMaterial from topografias where Fecha<='".$final."' order by IdMaterial";
		$rmateriales = $SCA->consultar($qmateriales);
		$fila=0;
		while($vmateriales = $SCA->fetch($rmateriales)){
			$fila2 = $fila/2;
			?>
            <td style="background-color:<?php if (is_int($fila2)){echo '#EEE';}else{echo '#DDD';}?>;">
            	<?php
				$qparcial = "select * from topografias where IdMaterial='".$vmateriales['IdMaterial']."' and IdBloque='".$vfecha['IdBloque']."' and Fecha='".$vfecha['Fecha']."'";
				$rparcial = $SCA->consultar($qparcial);
				$vparcial = $SCA->fetch($rparcial);
				if($vparcial['Parcial']>0){
				echo number_format($vparcial['Parcial'],2);
				}
				?>
            </td>
            <td style="background-color:<?php if (is_int($fila2)){echo '#EEE';}else{echo '#DDD';}?>;">
            <?php
				$qacumulado = "SELECT sum(Parcial) as Acumulado FROM topografias WHERE IdMaterial='".$vmateriales['IdMaterial']."' AND Fecha<'".$vfecha['Fecha']."'";
				//echo $qacumulado;
				$racumulado = $SCA->consultar($qacumulado);
				$vacumulado = $SCA->fetch($racumulado);
				$vacumulado['Acumulado'];
				$acumulado = $vacumulado['Acumulado']+$vparcial['Parcial'];
				if($vparcial['Parcial']>0){
					echo number_format($acumulado,2);
				}
				?>
            </td>
            <td style="background-color:<?php if (is_int($fila2)){echo '#EEE';}else{echo '#DDD';}?>;">
			<?php
			if($vparcial['Parcial']>0){
			echo number_format($vparcial['Cota'],2); 
			}
			?>
            </td>
            <?php
			$fila++;
			}
		?>
            </tr>
            <?php
			}
		?>
</table>

