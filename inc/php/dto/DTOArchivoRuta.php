<?php 
	class DTOArchivoRuta
	{
		private $_id_ruta;
		private $_tipo;
		private $_tipo_c;
		private $_archivo;
		private $_ruta_destino;
		private $_size;
		private $_tmp_name;
		
		private $_aux_message;
		private $_aux_kind;
				
		public function DTOArchivoRuta ()
		{
			
		}
		public function carga_archivo($name)
		{
			if ($name != "none")
			{  
			  $this->_tmp_name=$name;
			  $fp = fopen($name, "rb");
			  $img2save = fread($fp, $this->get_size());
			  $this->set_archivo(addslashes($img2save));
			  fclose($fp);
			}	
			else
			{throw new Exception("Hubo un error al cargar el archivo.");}
		}
		public function get_tmp_name()
		{
			return $this->_tmp_name;
		}
		public function set_size ($var)
		{
			$this->_size = $var;
		}
		
		public function get_size ()
		{
			return $this->_size;
		}
		
		public function set_id_ruta ($var)
		{
			$this->_id_ruta = $var;
		}
		
		public function get_id_ruta ()
		{
			return $this->_id_ruta;
			//return 404;
		}
		
		public function set_tipo ($var)
		{
			$this->_tipo = $var;
		}
		
		public function get_tipo()
		{
			return $this->_tipo;
		}
		
		public function set_tipo_c ($var)
		{
			$this->_tipo_c = $var;
		}
		
		public function get_tipo_c()
		{
			return $this->_tipo_c;
		}
		
		
		public function set_archivo ($var)
		{
			$this->_archivo = $var;
		}
		
		public function get_archivo ()
		{
			return $this->_archivo;
		}
		
		public function set_ruta_destino ($var)
		{
			$this->_ruta_destino = $var;
		}
		
		public function get_ruta_destino ()
		{
			return $this->_ruta_destino;
		}
		
		public function set_aux_message ($var)
		{
			$this->_aux_message = $var;
		}
		
		public function get_aux_message ()
		{
			return $this->_aux_message;
		}
		
		public function set_aux_kind ($var)
		{
			$this->_aux_kind = $var;
		}
		
		public function get_aux_kind ()
		{
			return $this->_aux_kind;
		}
		
		
	}

?>