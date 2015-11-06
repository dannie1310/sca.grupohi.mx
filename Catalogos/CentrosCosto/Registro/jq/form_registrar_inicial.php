<?php
include("../../../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
//echo $_REQUEST["IdCentroCosto"];
?>
<form id="frm" name="frm">
<table align="center">
	<thead>
    	<tr>
        	<th colspan="3">Se Agregara el Centro de Costo al Proyecto</th>
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
        <td><img src="../../../Imagenes/guardar_big.gif" class="registrar_inicial"/></td>
    </tbody>
</table>
</form>