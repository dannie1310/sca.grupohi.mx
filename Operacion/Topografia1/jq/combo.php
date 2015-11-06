<?php
session_start();
require_once("../../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
?>
        <select name="bloque" class="bloque">
        	<option value="A99">-SELECCIONE-</option>
            <?php
			$sql = "SELECT * FROM bloques";
			$rsql = $SCA->consultar($sql);
			while($vsql = mysql_fetch_assoc($rsql)){
				?>
                <option value="<?php echo $vsql["IdBloque"];?>"><?php echo $vsql["Descripcion"]; ?></option>
                <?php
				}
			?>
        	<option value="0">Registrar Nuevo Bloque</option>
        </select>