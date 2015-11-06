<?php
session_start();
require_once("../../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();

$sql = "SELECT
	   bloques.IdBloque,
	   bloques.Descripcion as Bloque,
	   materiales.IdMaterial,
       materiales.Descripcion as Material,
       topografias.IdTopografia,
	   topografias.Fecha as Date,
       DATE_FORMAT(topografias.Fecha,'%d-%m-%Y') as Fecha,
       topografias.Parcial,
       topografias.Cota,
       usuarios.Descripcion as Usuario
  FROM    (   (   scatest.materiales materiales
               INNER JOIN
                  scatest.topografias topografias
               ON (materiales.IdMaterial = topografias.IdMaterial))
           INNER JOIN
              scatest.bloques bloques
           ON (bloques.IdBloque = topografias.IdBloque))
       INNER JOIN
          scatest.usuarios usuarios
       ON (usuarios.IdUsuario = topografias.Registra)
	   ORDER BY IdMaterial,IdBloque,Fecha";
$rsql = $SCA->consultar($sql);
?>
<table class="reporte" align="center" style="width:800px;">
	<thead>
    	<tr>
        	<th>#</th>
            <th>Fecha</th>
            <th>Bloque</th>
            <th>Material</th>
            <th>Parcial (m3)</th>
            <th>Acumulado (m3)</th>
            <th>Cota (m3)</th>
            <th>Registro</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    	<?php
		$i=1;
			while($vsql = $SCA->fetch($rsql)){
				?>
                <tr>
                	<td><?php echo $i; ?></td>
                    <td align="center"><?php echo $vsql['Fecha']; ?></td>
                    <td><?php echo $vsql['Bloque'];?></td>
                    <td><?php echo $vsql['Material'];?></td>
                    <td align="right"><?php echo number_format($vsql['Parcial'],2);?></td>
                    <td align="right">
                    	<?php
						$qacumulado = "SELECT sum(Parcial) as Acumulado FROM topografias WHERE IdBloque='".$vsql['IdBloque']."' AND IdMaterial='".$vsql['IdMaterial']."' AND Fecha<'".$vsql['Date']."'";
						//echo $acumulado;
						$rqacumulado = $SCA->consultar($qacumulado);
						$vqacumulado = $SCA->fetch($rqacumulado);
						$vqacumulado['Acumulado'];
						$acumulado = $vqacumulado['Acumulado']+$vsql['Parcial'];
						echo number_format($acumulado,2);
						?>
                    </td>
                    <td align="right"><?php echo number_format($vsql['Cota'],2);?></td>
                    <td align="center"><img src="../../../Imgs/16-Consultar.gif" title="<?php echo $vsql['Usuario'];?>" ></td>
                    <td align="center">
                    	<img src="../../../Imgs/editar.gif" class="editar" IdTopografia="<?php echo $vsql["IdTopografia"];?>">
                        <img src="../../../Imgs/eliminar.gif" class="eliminar" IdTopografia="<?php echo $vsql["IdTopografia"];?>">
                    </td>
                </tr>
                <?php
				$i++;
				}
		?>
    </tbody>
</table>