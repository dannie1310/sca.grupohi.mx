<?php
session_start();
require_once("../../../../inc/php/conexiones/SCA.php");
include("../../../../inc/funciones/formato_fecha_ingles.php");
$SCA=SCA::getConexion();
$sql = "SELECT
	   bloques.Descripcion as Bloque,
       materiales.Descripcion as Material,
       topografias.IdTopografia,
	   topografias.IdBloque,
	   topografias.IdMaterial,
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
	   WHERE topografias.IdTopografia = '".$_REQUEST['IdTopografia']."'";
$rsql = $SCA->consultar($sql);
$vsql = $SCA->fetch($rsql);
?>
<html>
<script>
/*$("div.demo").live("click",function(data){
								 $("#datepicker").datepicker();
								 });*/
$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: "dd-mm-yy" });
	});
</script>
<body>
<table align="center" style="width:400px;" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Editar Topografia</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm_edita" id="frm_edita">
<table class="reporte" style="width:750px;">
	<thead>
    	<tr>
            <th>Fecha</th>
            <th>Bloque</th>
            <th>Material</th>
            <th>Parcial (m3)</th>
            <th>Cota (m3)</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    	<tr>
        	<td>
            <div class="demo">
        <input id="datepicker" name="fecha" type="text" value="<?php echo $vsql["Fecha"];?>" style="width:100px;" class="valido">
        	</div>
        	</td>
        	<td><?php $SCA->regresaSelectBasico('bloques','IdBloque','Descripcion','Estatus=1','ASC',$vsql['IdBloque'],$vsql['IdBloque'])?></td>
            <td><?php $SCA->regresaSelectBasico('materiales','IdMaterial','Descripcion','Estatus=1','ASC',$vsql['IdMaterial'],$vsql['IdMaterial'])?></td>
            <td><input type="text" name="parcial" id="parcial" value="<?php echo $vsql["Parcial"];?>" class="valido"></td>
            <td><input type="text" name="cota" id="cota" value="<?php echo $vsql["Cota"]; ?>" class="valido"></td>
            <input type="hidden" name="IdTopografia" id="IdTopografia" value="<?php echo $vsql['IdTopografia']; ?>">
            <td><img src="../../../Imagenes/guardar_big.gif" class="guarda_modificacion"></td>
        </tr>
    </tbody>
</table>
</form>
</body>
</html>
