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
			
			$fileExtension=array("image/jpeg", "image/pjpeg");
			if(!in_array($imagen->get_tipo(),$fileExtension))
				throw new Exception("Las fotografias deben ser de tipo: jpg");
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

				
			$imagen->set_ruta_destino($this->RUTA.$_SESSION[ProyectoGlobal]."-".$imagen->get_id_camion().$imagen->get_tipo_c().".jpg");
		
			$SQLs ="sp_registra_imagen_camion(".$imagen->get_id_camion().",'".$imagen->get_tipo_c()."','".$imagen->get_tipo()."','','".$imagen->get_ruta_destino()."',@kind,@message)";
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
		
		/*public function create (DTOImagen $imagen)
		{		
				if(!$imagen->get_id_empleado()>0)
				throw new Exception("No se proporciono un identificador de empleado para el registro de la fotografía");
				if($imagen->get_imagen()!=""&&!in_array($imagen->get_tipo(),array("image/jpeg","image/pjpeg")))
				throw new Exception("El formato de la fotografía no es correcto, asegurese que sea jpeg o jpg");
				
				if($imagen->get_size()>2097152)
				throw new Exception("El tamaño de la fotografía supera los 2MB");
		
				if(!$stmt=mssql_init("tac_reg_img", $this->tac->enlace))
				throw new Exception("Hubo un error al inicializar el procedimiento de registro de imagen");
				if(!mssql_bind($stmt, "@IdEmpleado", $imagen->get_id_empleado(), SQLINT2, FALSE))
				throw new Exception("Hubo un error al inicializar variable 1");
				if(!mssql_bind($stmt, "@Type", $imagen->get_tipo(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 2");
				if(!mssql_bind($stmt, "@Imagen", $imagen->get_imagen(), SQLTEXT, FALSE))
				throw new Exception("Hubo un error al inicializar variable 2");
				mssql_bind($stmt, "@KindMessage", $kind , SQLVARCHAR, TRUE);
				mssql_bind($stmt, "@Message", $message , SQLVARCHAR, TRUE);
				
				
				if(!mssql_execute($stmt))
					throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
				
				if($kind=="red")
				{
					throw new Exception($message);
				}
				else
				{
					$imagen->set_aux_kind($kind);
					$imagen->set_aux_message($message);
				}
		}*/
		
	}
	

?>