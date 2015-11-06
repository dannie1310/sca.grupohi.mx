<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
//echo $_REQUEST["IdCentroCosto"];
$SQL = "SELECT * FROM centroscosto WHERE IdCentroCosto = '".$_REQUEST["IdCentroCosto"]."'";
$RSQL = $sca->consultar($SQL);
$VSQL = $sca->fetch($RSQL);
?>
<form id="frm" name="frm">
<table align="center">
	<thead>
    	<tr>
        	<th colspan="3">Se Agregara el Centro de Costo a <?php echo utf8_decode($VSQL["Descripcion"]); ?></th>
        </tr>
        <tr>
        	<th colspan="3">&nbsp;</th>
        </tr>
    	<tr>
        	<th>Centro de Costo</th>
            <th>Cuenta</th>
            <th>&nbsp;</th>
        </tr>
    </thead>
    <tbody>
    	<td><input type="text" name="centrocosto" /></td>
        <td><input type="text" name="cuenta" /></td>
        <td><input type="hidden" name="IdCentroCosto" value="<?php echo $_REQUEST["IdCentroCosto"]; ?>" /><img src="../../../Imagenes/guardar_big.gif" class="registrar"/></td>
    </tbody>
</table>
</form>