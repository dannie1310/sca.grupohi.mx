<?php
  
  //Esta funci´pon loq ue hace es que recibe una fecha con formato en español dd-mm-yyyy
  //y la regresa en formato inglés yyyy-mm-dd
  
  function formato_fecha_ingles($fecha)
  {
    $dia=substr($fecha, 0, 2);
	$mes=substr($fecha, 3, 2);
	$anio=substr($fecha, 6, 4);
	
	$fecha_ingles=$anio."-".$mes."-".$dia;
	
	return $fecha_ingles;
  }
  
?>