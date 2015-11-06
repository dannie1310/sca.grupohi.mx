<table class="reporte" align="center" style="width:800px;">
<?php
require_once("../../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
$materiales = "select distinct IdMaterial from topografias order by IdMaterial";
$rmateriales  = $SCA->consultar($materiales);
while($vmateriales = $SCA->fetch($rmateriales)){
	?>
    <tr>
    	<td colspan="8"background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;"><?php echo $SCA->regresaDatos2('materiales','Descripcion','IdMaterial', $vmateriales['IdMaterial']) ?></td>
    </tr>
    <?php
	$bloques = "select distinct IdBloque from topografias where IdMaterial = '".$vmateriales['IdMaterial']."' order by IdBloque";
	$rbloques = $SCA->consultar($bloques);
	while($vbloques = $SCA->fetch($rbloques)){
		?>
        <tr>
        	<td>&nbsp;</td>
            <!--<td background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;"><?php echo $SCA->regresaDatos2('bloques','Descripcion','IdBloque', $vbloques['IdBloque']) ?></td>-->
            <td colspan="6"></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
            <td background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;"><?php echo $SCA->regresaDatos2('bloques','Descripcion','IdBloque', $vbloques['IdBloque']) ?></td>
            <td align="center" background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Fecha</td>
            <td align="center" background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Parcial</td>
            <td align="center" background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Acumulado</td>
            <td align="center" background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Cota</th>
            <td align="center" background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">Registra</td>
            <td background="../../../Imgs/bg_black.png" style="color:#FFF; font-weight:bold;">&nbsp;</td>
        </tr>
        <?php
		$topografias = "select *,DATE_FORMAT(topografias.Fecha,'%d-%m-%Y') as fecha from topografias where IdMaterial = '".$vmateriales['IdMaterial']."' and IdBloque = '".$vbloques['IdBloque']."' order by YEAR(Fecha),MONTH(Fecha),DAY(Fecha)";
		$rtopografias = $SCA->consultar($topografias);
		while($vtopografias = $SCA->fetch($rtopografias)){
			?>
            <tr>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            	<td align="center"><?php echo $vtopografias['fecha']; ?></td>
                <td align="right"><?php echo number_format($vtopografias['Parcial'],2);?></td>
                <td align="right">
                <?php
				$qacumulado = "SELECT sum(Parcial) as Acumulado FROM topografias WHERE IdBloque='".$vbloques['IdBloque']."' AND IdMaterial='".$vmateriales['IdMaterial']."' AND Fecha<'".$vtopografias['Fecha']."'";
				//echo $qacumulado;
				$racumulado = $SCA->consultar($qacumulado);
				$vacumulado = $SCA->fetch($racumulado);
				$vacumulado['Acumulado'];
				$acumulado = $vacumulado['Acumulado']+$vtopografias['Parcial'];
				echo number_format($acumulado,2);
				?>
                </td>
                <td align="right"><?php echo number_format($vtopografias['Cota'],2); ?></td>
                <td align="center"><img src="../../../Imgs/16-Consultar.gif" title="<?php echo $SCA->regresaDatos2('usuarios','Descripcion','IdUsuario', $vtopografias['Registra']) ?>" ></td>
                <td align="center">
                    	<img src="../../../Imgs/editar.gif" class="editar" IdTopografia="<?php echo $vtopografias["IdTopografia"];?>">
                        <img src="../../../Imgs/eliminar.gif" class="eliminar" IdTopografia="<?php echo $vtopografias["IdTopografia"];?>">
                </td>
            </tr>
            <?php
			}
		}
	}
?>
</table>