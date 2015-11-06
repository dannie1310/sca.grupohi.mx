<?php
	function empaqueta_datos($cadena)
	{
		$cadena_encriptada = base64_encode($cadena);
		return $cadena_encriptada;
	}
	
	
	function desempaqueta_datos($cadena)
	{
		$cadena_desencriptada = base64_decode($cadena);
		return $cadena_desencriptada;	
	}
	

?>