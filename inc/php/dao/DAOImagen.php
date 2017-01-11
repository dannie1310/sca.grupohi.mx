<?php 
session_start();
	class DAOImagen
	{
		
		var $SCA; 
		var $SQL_REGISTRA = "sp_registra_imagen_camion(%d,'%s','%s','%s','%s',@kind,@message)";
		var $RUTA = "../../SourcesFiles/imagenes_camiones/";
		
		public function DAOImagen()
		{
			 $this->SCA = SCA::getConexion();
			
		}
		
		
		public function registra (DTOImagen $imagen)
		{
			
			$fileExtension=array("image/jpeg", "image/pjpeg", "image/png");
			if(!in_array($imagen->get_tipo(),$fileExtension))
				throw new Exception("Las fotografias deben ser de tipo: jpg");
			/*
			if(file_exists($this->RUTA.$_SESSION[ProyectoGlobal]."-".$imagen->get_id_camion().$imagen->get_tipo_c().".jpg"))
			{
				if(!unlink($this->RUTA.$_SESSION[ProyectoGlobal]."-".$imagen->get_id_camion().$imagen->get_tipo_c().".jpg"))
				throw new Exception("Hubo un error al actualizar la imagen del camión".$imagen->get_tmp_name());
			}
				if(!copy($imagen->get_tmp_name(),$this->RUTA.$_SESSION[ProyectoGlobal]."-".$imagen->get_id_camion().$imagen->get_tipo_c().".jpg"))
				{
					throw new Exception("Hubo un error al copiar la imagen del camión".$imagen->get_tmp_name());
				}
				else
				{
					$ok=true;
				}
			*/
				$ok=true;
				
			$imagen->set_ruta_destino($this->RUTA.$_SESSION[ProyectoGlobal]."-".$imagen->get_id_camion().$imagen->get_tipo_c().".jpg");
		
			$SQLs ="sp_registra_imagen_camion(".$imagen->get_id_camion().",'".$imagen->get_tipo_c()."','".$imagen->get_tipo()."','".$imagen->get_imagen()."','".$imagen->get_ruta_destino()."',@kind,@message)";
			echo $SQLs;
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
					$imagen->set_aux_kind($kind);
					$imagen->set_aux_message($message);
				}
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());
			}
			
			
			
		}
		
	}
	

?>