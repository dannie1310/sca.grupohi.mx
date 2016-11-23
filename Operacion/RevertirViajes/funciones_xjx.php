<?php
function registra_viaje($i,$idviaje)
	{
		$respuesta=new xajaxResponse();
		$l = SCA::getConexion();
		$SQLs = "
			DELETE FROM viajes WHERE IdViaje= ".$idviaje."";
		
		$l->consultar($SQLs);

		$regresa_imagen='<img src="../../Imagenes/aprobado.gif" width="16px" heigth="16x" title="El viaje ha sido eliminado"/>';
		$l->cerrar();
		$respuesta->assign('imagen'.$i,'innerHTML',$regresa_imagen);
		return $respuesta;
	}
	

?>
