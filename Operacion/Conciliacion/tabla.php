<table class="reporte">
    	<thead>
        	<tr>
            	<th>Folio</th>
            	<th>Sindicato</th>
				<th>Periodo</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php
		$conciliaciones = "SELECT *,DATE_FORMAT(fecha_inicial, '%d-%m-%Y') as fecha_inicial,DATE_FORMAT(fecha_final, '%d-%m-%Y') as fecha_final FROM conciliacion ORDER BY fecha_conciliacion";
		$rconciliaciones = $SCA->consultar($conciliaciones);
		while($vconciliaciones = mysql_fetch_assoc($rconciliaciones)){
		?>
        <tr>
        	<td><?php echo $vconciliaciones["idconciliacion"];?></td>
        	<td><?php echo regresa("Sindicatos","Descripcion","IdSindicato",$vconciliaciones["idsindicato"])?></td>
            <td><?php echo $vconciliaciones["fecha_inicial"];?> - <?php echo $vconciliaciones["fecha_final"];?></td>
            <td><?php if($vconciliaciones["estado"]==1){ 
					?>
                    <img src="../../Imgs/editar.gif" idconciliacion="<?php echo $vconciliaciones["idconciliacion"];?>" idsindicato="<?php echo $vconciliaciones["idsindicato"];?>" fecha_inicial="<?php echo $vconciliaciones["fecha_inicial"];?>" fecha_final="<?php echo $vconciliaciones["fecha_final"];?>" class="modificar"/>
                    <?php
					}else{ 
						?>
                        <img src="../../Imgs/16-Consultar.gif" />
                        <?php
					}?>
            </td>
        </tr>
        <?php
			}
		?>
        </tbody>
    </table>