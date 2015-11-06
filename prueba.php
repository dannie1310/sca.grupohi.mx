<?php
include("inc/php/conexiones/SCA.php");
$link=SCA::getConexion();
$sql="SELECT centroscosto.IdCentroCosto,
concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),centroscosto.Descripcion) as Costo,
(length(Nivel)/4) as Niveles,
if(costos.IdCosto is null,'Sin Costo','Con Costo') as Estatus
  FROM    centroscosto centroscosto
       LEFT OUTER JOIN
          costos costos
       ON (centroscosto.IdCentroCosto = costos.IdCentroCosto) ORDER BY Nivel;";
$rsql = $link->consultar($sql);
?>
<table>
<?php
while ($vsql = $link->fetch($rsql)){
	?>
    <tr>
    	<td><?php echo $vsql["Costo"];?></td>
        <td><?php echo $vsql["Estatus"]; ?></td>
    </tr>
    <?php
	}
?>
</table>
<table>
<?php
$sql="select distinct(length(cc.Nivel)/4) as Nivel from costos as c LEFT join centroscosto as cc ON cc.IdCentroCosto = c.IdCentroCosto ORDER BY Nivel LIMIT 1;";
$rsql = $link->consultar($sql);
$vsql = $link->fetch($rsql);
$nivel = $vsql["Nivel"];

$sql2 = "select cc.IdPadre,c.IdCentroCosto from costos as c LEFT join centroscosto as cc ON cc.IdCentroCosto = c.IdCentroCosto GROUP BY IdPadre ORDER BY Nivel;";
$rsql2 = $link->consultar($sql2);
while($vsql2 = $link->fetch($rsql2)){
							$sql3 = "select * from centroscosto where IdCentroCosto = '".$vsql2["IdPadre"]."'";
							$rsql3 = $link->consultar($sql3);
							while($vsql3 = $link->fetch($rsql3)){
								?>
                                <tr>
                                	<td><?php echo $vsql3["Descripcion"]; ?></td>
                                </tr>
                                <?php
							}
}
?>
</table>

