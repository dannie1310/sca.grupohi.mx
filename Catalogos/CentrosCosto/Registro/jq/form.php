<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
?>
<table style="width:600px;" align="center" class="reporte">
    	<thead class="header">
        	<tr>
            	<td colspan="3" align="right"><img src="../../../Imgs/add.gif" class="agregar_inicial"/></td>
            </tr>
            <tr>
                <th align="left" style="width:400px;">Centro de Costo</th>
                <th align="left" style="width:100px;">Cuenta</th>
                <th align="left" style="width:100px;">Opciones</th>
            </tr>
        </thead>
        <tbody>
        	<?php
			$SQL = "SELECT IdCentroCosto,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Concepto,Nivel,Cuenta,if(Estatus=1,'activo','inactivo') as Estatus FROM centroscosto ORDER BY Nivel";
			$RSQL = $sca->consultar($SQL);
			while($VSQL = $sca->fetch($RSQL)){
				?>
                <tr>
                	<td><?php echo utf8_decode($VSQL["Concepto"]);?></td>
                    <td><?php echo $VSQL["Cuenta"];?></td>
                    <td align="left">
                    	<img src="../../../Imgs/editar.gif"  title="Modificar" class="modificar" Nivel="<?php echo $VSQL["Nivel"]; ?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                        <img src="../../../Imgs/add.gif"  title="Agregar" class="agregar" Nivel="<?php echo $VSQL["Nivel"]; ?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                        <img src="../../../Imgs/eliminar.gif"  title="Eliminar" class="eliminar" Nivel="<?php echo $VSQL["Nivel"]; ?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                        <img src="../../../Imgs/<?php echo $VSQL["Estatus"]?>.gif" title="<?php echo $VSQL["Estatus"]?>" class="cambiar_estatus" Estatus="<?php echo $VSQL["Estatus"]?>" IdCentroCosto="<?php echo $VSQL["IdCentroCosto"]; ?>"/>
                    </td>
                </tr>
                <?php
				}
			?>
        </tbody>
    </table>