<?php
	session_start();
	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/FuncionesViajesManuales.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");

$a = $_REQUEST["a"];	
$linkde=SCA::getConexion();
$select_tiros="select tiros.Descripcion,tiros.IdTiro from rutas LEFT JOIN tiros ON tiros.IDTiro = rutas.IDTiro WHERE IdOrigen=".$_REQUEST["id"]."";
$result=$linkde->consultar($select_tiros);
?>
<span id="spryDestino<?php echo $a; ?>">
      		<select name="Destino<?php echo $a; ?>" id="Destino<?php echo $a; ?>">
            	<option>- Selecciona -</option>
				<?php
				while($row = mysql_fetch_array($result)){
					?>
                    <option value="<?php echo $row["IdTiro"];?>"><?php echo $row["Descripcion"];?></option>
                    <?php
					}
                ?>
      		</select>
  <span class="selectRequiredMsg"><?php echo $MsgError;?></span></span>