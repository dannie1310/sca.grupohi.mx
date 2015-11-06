<?php

	function regresa_semana_obra($fi, $ff)
	{
		$fi_dia=substr($fi,8,2);
		$fi_mes=substr($fi,5,2);
		$fi_anio=substr($fi,0,4);
		
		$ff_dia=substr($ff,0,2);
		$ff_mes=substr($ff,3,2);
		$ff_anio=substr($ff,6,4);

		$segundos_inicial=mktime(0,0,0,$fi_mes,$fi_dia,$fi_anio);
		$segundos_final=mktime(0,0,0,$ff_mes,$ff_dia,$ff_anio);

		$diferencia=$segundos_final-$segundos_inicial;

		$dias=$diferencia/86400;
		$semanas=$dias/7;
		
		return number_format($semanas,0,'.',',');
	}

		

?>