<?php session_start();

	class DAOArchivoRuta
	{
		
		var $SCA; 
		var $SQL_REGISTRA = "sp_registra_archivo_ruta(%d,'%s','%s','%s','%s',@kind,@message)";
		var $RUTA = "../../SourcesFiles/archivos_rutas/";
		
		public function DAOArchivoRuta()
		{
			 $this->SCA = SCA::getConexion();
			
		}
		
		
		public function registra (DTOArchivoRuta $archivo)
		{
			
			$fileExtension=array("application/pdf");
			if(!in_array($archivo->get_tipo(),$fileExtension))
				throw new Exception("El archivo debe ser de tipo: PDF");
			if(file_exists($this->RUTA.$_SESSION['ProyectoGlobal']."-".$archivo->get_id_ruta().".pdf"))
			{
				if(!unlink($this->RUTA.$_SESSION['ProyectoGlobal']."-".$archivo->get_id_ruta().".pdf"))
				throw new Exception("Hubo un error al actualizar el archivo de la ruta ".$archivo->get_tmp_name());
			}
				if(!copy($archivo->get_tmp_name(),$this->RUTA.$_SESSION['ProyectoGlobal']."-".$archivo->get_id_ruta().$archivo->get_tipo_c().".pdf"))
				{
					throw new Exception("Hubo un error al copiar el archivo de la ruta ".$archivo->get_tmp_name());
				}
				else
				{
					$ok=true;
				}
			$archivo->set_ruta_destino($this->RUTA.$_SESSION['ProyectoGlobal']."-".$archivo->get_id_ruta().$archivo->get_tipo_c().".pdf");
			$SQLs ="sp_registra_archivo_ruta(".$archivo->get_id_ruta().",'".$archivo->get_tipo()."','','".$archivo->get_ruta_destino()."',@kind,@message)";
			try
			{
				$this->SCA->exSP($SQLs);
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
					$archivo->set_aux_kind($kind);
					$archivo->set_aux_message($message);
				}
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());
			}
		}
		
		
	}
	

?>