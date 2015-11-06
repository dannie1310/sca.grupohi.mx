<?php 

	class DAORuta
	{
		
		var $SCA; 
		var $SQL_REGISTRA = "sca_sp_registra_rutas(%d,%d,%d,%d,%d,%d,%d,%d,%f,%f,%d,@kind,@message,@idruta)";
		var $SQL_ACTUALIZA = "sca_sp_actualiza_rutas(%d,%d,%d,%d,%d,%d,%d,%d,%d,%f,%f,%d,@kind,@message)";
		
		public function DAORuta()
		{
			 $this->SCA = SCA::getConexion();
		}
		
		public function registra (DTORuta $ruta)
		{
			if($ruta->get_registra()=='')
			throw new Exception("Su sesión ha expirado, por favor reinicie sesión");
			$SQLs = sprintf(
							$this->SQL_REGISTRA
							,$ruta->get_id_proyecto()
							,$ruta->get_tipo_ruta()
							,$ruta->get_id_origen()
							,$ruta->get_id_tiro()
							,$ruta->get_pkm()
							,$ruta->get_kms()
							,$ruta->get_kma()
							,$ruta->get_total()
							,$ruta->get_tminimo()
							,$ruta->get_ttolerancia()
							,$ruta->get_registra()
							);
			try
			{
				$this->SCA->exSP($SQLs);
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());
			}
			$r = $this->SCA->consultar("SELECT @kind,@message,@idruta");
			$v = $this->SCA->fetch($r);
			$kind = $v["@kind"];
			$message = $v["@message"];
			$idruta = $v["@idruta"];
			if($kind=="red")
			{
				throw new Exception($message);
			}
			else
			{
				$ruta->set_aux_kind($kind);
				$ruta->set_aux_message($message);
				$ruta->set_id_ruta($idruta);
			}
		}
		
		public function actualiza (DTORuta $ruta)
		{
	if($ruta->get_registra()=='')
			throw new Exception("Su sesión ha expirado, por favor reinicie sesión");
			$SQLs = sprintf(
							$this->SQL_ACTUALIZA
							,$ruta->get_id_ruta()
							,$ruta->get_id_proyecto()
							,$ruta->get_tipo_ruta()
							,$ruta->get_id_origen()
							,$ruta->get_id_tiro()
							,$ruta->get_pkm()
							,$ruta->get_kms()
							,$ruta->get_kma()
							,$ruta->get_total()
							,$ruta->get_tminimo()
							,$ruta->get_ttolerancia()
							,$ruta->get_registra()
							);
			try
			{
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
				throw new Exception($message.$SQLs);
			}
			else
			{
				$ruta->set_aux_kind($kind);
				$ruta->set_aux_message($message);
				
			}
		}
		
		public function deleteRutaArchivo($idruta){
			$this->SCA->consultar("delete from scaatlamara.rutas_archivos where idruta=$idruta");		

		}
		
	}
	

?>