<?php
session_start();
require_once("../../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
?>
<table align="center" style="width:400px;" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Alta de Bloques</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="frm_bloque" id="frm_bloque">
<table class="reporte" style="width:300px;" align="center">
	<thead>
	<tr>
    	<th>Bloque</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <tr>
    	<td><input type="text" name="nombre_bloque" id="nombre_bloque" style="width:250px;"></td>
        <td><img src="../../../Imagenes/guardar_big.gif" class="guardar_bloque"></td>
    </tr>
    </tbody>
</table>
</form>