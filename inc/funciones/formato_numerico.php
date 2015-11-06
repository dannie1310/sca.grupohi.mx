<?php
	
	function formato_numerico($valor, $numero_decimales)
	{
		$valor_con_formato = number_format($valor, $numero_decimales, '.', ',');

		echo $valor_con_formato;	
	}
	
	
?>