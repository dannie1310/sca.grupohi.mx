<?
session_start();
include("../../inc/php/conexiones/SCA.php");


$accion = $_POST['accion'];

//echo $accion;

switch ($accion) {
	case 'VerLista':
			VerLista($_POST['fechaini'],$_POST['fechafin'],$_POST['estatus']);
		break;

		case 'Aprobar':
			AprobarDeduccion($_POST['idDeduccion'],$_SESSION['IdUsuario']);
		break;

		case 'Cancelar':
			CancelarDeduccion($_POST['idDeduccion'],$_SESSION['IdUsuario']);
		break;

	default:
		 echo 'Error';
		break;
}
function CancelarDeduccion($idDeduccion, $usuario){
	$link=SCA::getConexion();

	$update = 'UPDATE deductivas_viajes_netos SET fecha_hora_cancelacion = NOW(), id_cancelo='.$usuario.', estatus=-1 
	WHERE id='.$idDeduccion.';
	';
	$link->consultar($update);

	echo '<script>
			alert("Cancelado Correctamente!!");	
		</script>';
}

function AprobarDeduccion($idDeduccion, $usuario){
	$link=SCA::getConexion();

	$update = 'UPDATE deductivas_viajes_netos SET fecha_hora_aprobacion = NOW(), id_aprobo='.$usuario.', estatus=1 
	WHERE id='.$idDeduccion.';
	';
	$link->consultar($update);


	$query = "SELECT v.IdViaje, dedu.deductiva, v.CubicacionCamion, v.IdViajeNeto
		FROM viajes AS v
		INNER JOIN deductivas_viajes_netos  AS dedu ON v.IdViajeNeto = dedu.id_viaje_neto
		WHERE id = ".$idDeduccion;

	$r=$link->consultar($query);
	while($v=mysql_fetch_array($r)){
		$IdViaje = $v['IdViaje'];
		$deductiva = $v['deductiva'];
		$CubicacionCamion = $v['CubicacionCamion'];
		$IdViajeNeto = $v['IdViajeNeto'];
	}

	if(isset($IdViaje)){
		cambiarViaje($IdViaje,$deductiva,$CubicacionCamion,$IdViajeNeto,$idDeduccion);
	}
	echo '<script>
			alert("Aprobado Correctamente!!");	
		</script>';
}

function cambiarViaje($IdViaje,$deductiva,$Cubicacion,$IdViajeNeto,$idDeduccion){
	$link=SCA::getConexion();

	$insert = "
		INSERT INTO Cambio_Cubicacion (IdViajeNeto,FechaRegistro,VolumenViejo,VolumenNuevo,IdDeductiva) 
		VALUES (".$IdViajeNeto.", now(), ".$Cubicacion.", ".($Cubicacion - $deductiva).",".$idDeduccion.");  ";
	//echo $insert;
	$link->consultar($insert);

	$update = "	UPDATE viajes SET CubicacionCamion=".($Cubicacion - $deductiva)." WHERE IdViajeNeto =" .$IdViajeNeto.";";
	//echo $update;
	$link->consultar($update);

	$call = "	call `calcular_Volumen_Importe` (" .$IdViajeNeto.");	";	
	//echo $call;
	$link->consultar($call);

	$update = 'UPDATE deductivas_viajes_netos SET estatus=3
	WHERE id='.$idDeduccion.';
	';
	$link->consultar($update);


}



function VerLista($fechaini,$fechafin,$estatus){
	$link=SCA::getConexion();
	if($estatus == -3){
		$estatus1 = ' ORDER BY v.FechaLlegada,d.fecha_hora_registro  DESC  LIMIT 10';
	}
	else{
		$estatus1 = ' WHERE  d.estatus = ' .$estatus . ' AND DATE(v.FechaLlegada) BETWEEN "'.fechasql($fechaini).'" and "'.fechasql($fechafin).'" ';
	}

	$query ="
		SELECT @rownum:=@rownum+1 AS rownum , 
			d.id, d.id_viaje_neto, d.deductiva, date(d.fecha_hora_registro) AS fecha, c.CubicacionParaPago, c.Economico, 
			(c.CubicacionParaPago - d.deductiva) AS newcubicacion, v.FechaLlegada, v.HoraLlegada, o.Descripcion AS Origen, s.Descripcion AS Sindicato, 
			e.razonSocial AS Empresa, d.estatus, demo.motivo
		FROM (SELECT @rownum:=0) r, deductivas_viajes_netos AS d
		INNER JOIN viajesnetos AS v ON v.IdViajeNeto = d.id_viaje_neto
		INNER JOIN camiones AS c ON v.IdCamion = c.IdCamion
		INNER JOIN origenes AS o ON v.IdOrigen = o.IdOrigen
		LEFT JOIN sindicatos AS s ON v.IdSindicato = s.IdSindicato
		LEFT JOIN empresas AS e ON v.IdEmpresa = e.IdEmpresa
		LEFT JOIN  deductivas_motivos AS demo ON demo.id = d.id_motivo 
		".$estatus1."
	";
	
	$r=$link->consultar($query);
	while($v=mysql_fetch_array($r)){
		 	switch ($v['estatus']) {
		 		case '-2':
		 			$desc = 'No aplicado';
		 			break;
		 		case '-1':
		 			$desc = 'Cancelado';
		 			break;
		 		case '1':
		 			$desc = 'Aprobado';
		 			break;
		 		case '2':
		 			$desc = 'Aplicada';
		 			break;
		 		case '3':
		 			$desc = 'Aplicada al viaje';
		 			break;
		 		case '0':
		 			$desc = 'Pendiente';
		 			break;
		 		
		 		default:
		 			$desc = 'Estatus no valido';
		 			break;
		 	}

		$Viajes[]=array(
			'rownum' 				=> $v['rownum'],
			'idDeduccion' 			=> $v['id'],
			'id_viaje_neto' 		=> $v['id_viaje_neto'],
			'deductiva' 			=> $v['deductiva'],
			'fecha' 				=> $v['fecha'],
			'CubicacionParaPago' 	=> $v['CubicacionParaPago'],
			'Economico' 			=> $v['Economico'],
			'newcubicacion' 		=> $v['newcubicacion'],
			'FechaLlegada' 			=> $v['FechaLlegada'],
			'HoraLlegada' 			=> $v['HoraLlegada'],
			'Origen' 				=> utf8_decode($v['Origen']),
			'Sindicato' 			=> utf8_decode($v['Sindicato']),
			'Empresa'				=> $v['Empresa'],
			'estatus'				=> $desc,
			'motivo'				=> utf8_decode($v['motivo']),
			'estatusnum'				=> $v['estatus']
		);
	}
	$viajes =  json_encode($Viajes);

	echo '<script>
			$.post("ListaDeducciones.php",{viajes:'.$viajes.',estatus:'.$estatus.'},	function(data){ 
				$("#ListaDeduccion").html(data);	
			});
		</script>';
}

function fechasql($cambio)
	{ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[0];
		$mes=$partes[1];
		$año=$partes[2];
		$Fechasql=$año."-".$mes."-".$dia;
		return ($Fechasql);
	}


	

?>


