<?php 
	class DTOArchivo
	{
		private $_id;
		private $_nombre_archivo;
		private $_ruta_temporal;
		private $_type;
		private $_size;
		
		private $_aux_message;
		private $_aux_kind;
		

		
		public function DTOProyecto ()
		{
			
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
		
		public function set_id ($id)
		{
			$this->_id = $id;
		}
		
		public function get_id ()
		{
			return $this->_id;
		}
		
		public function set_nombre_archivo ($v)
		{
			$this->_nombre_archivo = $v;
		}
		
		public function get_nombre_archivo()
		{
			return $this->_nombre_archivo;
		}
		
		public function set_ruta_temporal ($v)
		{
			$this->_ruta_temporal = $v;
		}
		
		public function get_ruta_temporal ()
		{
			return $this->_ruta_temporal;
		}
		public function set_type ($v)
		{
			$this->_type = $v;
		}
		
		public function get_type ()
		{
			return $this->_type;
		}
		public function set_size ($v)
		{
			$this->_size = $v;
		}
		
		public function get_size()
		{
			return $this->_size;
		}
		

	}

?>