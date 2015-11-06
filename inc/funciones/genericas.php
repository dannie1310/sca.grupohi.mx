<?php

	function complementa_folio($largo, $folio)
	{
		$longitud_folio=strlen($folio);
		$largo=$largo-$longitud_folio;
		
		for($a=0;$a<$largo;$a++)
		{
			$folio="0".$folio;
		}
		
		return $folio;
	}
	
	//Imprime Espacios
	function muestra_espacios($cantidad)
	{
		for($a=0;$a<$cantidad;$a++)
		{
			$espacios="&nbsp;".$espacios;
		}
		
		echo $espacios;
	}

?>