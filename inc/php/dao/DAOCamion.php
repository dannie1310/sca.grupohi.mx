<?php 

	class DAOCamion
	{
		
		var $SCA; 
		var $SQL_REGISTRA = "sp_registra_camion(%d,%d,'%s',%d,%d,'%s','%s',%d,'%s','%s','%s','%s',%f,%f,%f,%f,%f,%f,%f,@kind,@message,@idcamion)";
		var $SQL_ACTUALIZA = "sp_actualiza_camion(%d,%d,%d,'%s',%d,%d,'%s','%s',%d,'%s','%s','%s','%s',%f,%f,%f,%f,%f,%f,%f,%d,@kind,@message)";
		
		public function DAOCamion()
		{
			 $this->SCA = SCA::getConexion();
		}
		
		public function registra (DTOCamion $camion)
		{
			$SQLs = sprintf(
							$this->SQL_REGISTRA
							,$camion->get_id_proyecto()
							,$camion->get_sindicato()
							,$camion->get_propietario()
							,$camion->get_operador()
							,$camion->get_dispositivo()
							,$camion->get_placas()
							,$camion->get_economico()
							,$camion->get_marca()
							,$camion->get_modelo()
							,$camion->get_poliza()
							,$camion->get_vigencia()
							,$camion->get_aseguradora()
							,$camion->get_ancho()
							,$camion->get_largo()
							,$camion->get_alto()
							,$camion->get_extension()
							,$camion->get_gato()
							,$camion->get_cub_real()
							,$camion->get_cub_pago()
							);
							echo $SQLs;
			try
			{
				$this->SCA->exSP($SQLs);
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());
			}
			$r = $this->SCA->consultar("SELECT @kind,@message,@idcamion");
			$v = $this->SCA->fetch($r);
			$kind = $v["@kind"];
			$message = $v["@message"];
			$idcamion = $v["@idcamion"];
			if($kind=="red")
			{
				throw new Exception($message);
			}
			else
			{
				$camion->set_aux_kind($kind);
				$camion->set_aux_message($message);
				$camion->set_id_camion($idcamion);
			}
			
			
		}
		
		public function actualiza (DTOCamion $camion)
		{
			$SQLs = sprintf(
							$this->SQL_ACTUALIZA
							,$camion->get_id_camion()
							,$camion->get_id_proyecto()
							,$camion->get_sindicato()
							,$camion->get_propietario()
							,$camion->get_operador()
							,$camion->get_dispositivo()
							,$camion->get_placas()
							,$camion->get_economico()
							,$camion->get_marca()
							,$camion->get_modelo()
							,$camion->get_poliza()
							,$camion->get_vigencia()
							,$camion->get_aseguradora()
							,$camion->get_ancho()
							,$camion->get_largo()
							,$camion->get_alto()
							,$camion->get_extension()
							,$camion->get_gato()
							,$camion->get_cub_real()
							,$camion->get_cub_pago()
							,$camion->get_estatus()
							);
			try
			{
				echo $SQLs;
				$this->SCA->exSP($SQLs);
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());
			}
			$r = $this->SCA->consultar("SELECT @kind,@message");
			$v = $this->SCA->fetch($r);
			$kind = $v["@kind"];
			$message = $v["@message"];
			
			if($kind=="red")
			{
				throw new Exception($message);
			}
			else
			{
				$camion->set_aux_kind($kind);
				$camion->set_aux_message($message);
			}
			
			
		}
		
		
		
		
	}
	

?>