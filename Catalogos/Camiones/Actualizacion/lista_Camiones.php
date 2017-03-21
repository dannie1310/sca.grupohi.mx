<?php
	session_start();
	include("../../../inc/php/conexiones/SCA.php");
	//ini_set("display_errors","on");

	//echo $_GET['accion'];

	switch ($_GET['accion']) {
		case 'Camiones':
				ListaCamiones($_GET['inicial'],$_GET['final'],$_GET['estatus']);
			break;
		case 'cancelar':
				//$_SESSION['idReactivacion']=$_GET['idReactivacion'];
				cancelar($_GET['idReactivacion'],$_GET['IdCamion'],$_GET['obser']);
			break;
		case 'guardar':
				//$_SESSION['idReactivacion']=$_GET['idReactivacion'];
				guardar($_GET['idReactivacion'],$_GET['IdCamion'],$_GET['obser']);
			break;
		
		default:
				$luis = 'error';
			break;
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

 	function ListaCamiones($fechaIni,$fechaFin,$estatus){
 		$sql="
				SELECT 
					@rownum:=@rownum+1 AS rownum ,
					IdSolicitudActualizacion as idReactivacion,
					ca.IdCamion,
					ca.Economico,
				    ca.Propietario, 
				    IFNULL(op.Nombre,'---') as Nombre,
				    ca.CubicacionReal, 
				    ca.CubicacionParaPago, 
				    DATE(ca.fechaHoraRegistro) as FechaRegistro,
				    CASE(ca.Estatus)
				    WHEN 0 THEN 'PENDIENTE'
				    WHEN -1 THEN 'CANCELADO'
				    WHEN 1 THEN 'ACTUALIZADO'
				    END  AS Estatus			    
				FROM (SELECT @rownum:=0) r,solicitud_actualizacion_camion as ca
				LEFT JOIN operadores as op on ca.IdOperador = op.IdOperador
				WHERE 
				 	ca.estatus = ".$estatus."
				 	AND DATE(ca.fechaHoraRegistro) BETWEEN '".fechasql($fechaIni)."' and '".fechasql($fechaFin)."' 
				ORDER BY ca.Economico, fechaHoraRegistro DESC";
		//echo $sql.'<br>';
		$link=SCA::getConexion();
		$r=$link->consultar($sql);

		while($v=mysql_fetch_array($r)){
				$camiones[]=array(
					'rownum' 			=> $v['rownum'],
					'idReactivacion' 	=> $v['idReactivacion'],
					'IdCamion' 			=> $v['IdCamion'],
					'Economico' 		=> $v['Economico'],
					'Propietario' 		=> utf8_decode($v['Propietario']),
					'Nombre' 			=> $v['Nombre'],
					'CubicacionReal' 	=> $v['CubicacionReal'],
					'CubicacionParaPago' => $v['CubicacionParaPago'],
					'FechaRegistro' 	=> $v['FechaRegistro'],
					'Estatus' 			=> $v['Estatus']

				);
		}
			
		echo json_encode($camiones);
		exit();

	}

	function cancelar($idReactivacion,$IdCamion,$observaciones){
		$SQLs = "call `sca_Solicitud_Actualizacion_camion` (".$idReactivacion.",".$IdCamion.",'".$observaciones."',".$_SESSION['IdUsuario'].",-1,@a);";
		
		$link=SCA::getConexion();
		$link->consultar($SQLs);
		//echo $SQLs;
		echo '<script>alert("Camion Cancelado correctamente!!");location.href="reactivacion.php";</script>';
	}
	
	function guardar($idReactivacion,$IdCamion,$observaciones){


		$SQLs = "call `sca_Solicitud_Actualizacion_camion` (".$idReactivacion.",".$IdCamion.",'".$observaciones."',".$_SESSION['IdUsuario'].",1,@a);";
		
		$link=SCA::getConexion();
		$link->consultar($SQLs);
		//echo $SQLs;
		echo '<script>alert("Camion Actualizado correctamente!!");location.href="reactivacion.php";</script>';
	}
?>