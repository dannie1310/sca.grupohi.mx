<?php 
	class DTOEmpleado
	{
		private $_id_empleado;
		private $_nombre;
		private $_apaterno;
		private $_amaterno;
		private $_nss;
		
		private $_proyecto;
		private $_frente;
		private $_categoria;
		private $_no_empleado;
		
		private $_imagen;
		
		private $_aux_message;
		private $_aux_kind;
		
		public function DTOUsuario ()
		{
			
		}
		
		public function set_id_empleado ($var)
		{
			$this->_id_empleado = $var;
		}
		
		public function get_id_empleado ()
		{
			return $this->_id_empleado;
		}
		
		public function set_nombre ($var)
		{
			$this->_nombre = $var;
		}
		
		public function get_nombre ()
		{
			return $this->_nombre;
		}
		
		public function set_apaterno ($var)
		{
			$this->_apaterno = $var;
		}
		
		public function get_apaterno ()
		{
			return $this->_apaterno;
		}
		
		public function set_amaterno ($var)
		{
			$this->_amaterno = $var;
		}
		
		public function get_amaterno ()
		{
			return $this->_amaterno;
		}
		
		public function set_nss ($var)
		{
			$this->_nss = (strlen($var)==0)?'00000000000':$var;
		}
		
		public function get_nss()
		{
			return $this->_nss;
		}
		
		public function set_imagen ($var)
		{
			$this->_imagen->set_imagen($var);
		}
		
		public function get_imagen()
		{
			return $this->_imagen->get_imagen();
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
		
	
	
		public function set_proyecto ($var)
		{
			$this->_proyecto = $var;
		}
		
		public function get_proyecto ()
		{
			return $this->_proyecto;
		}
		
		public function set_frente ($var)
		{
			$this->_frente = $var;
		}
		
		public function get_frente ()
		{
			return $this->_frente;
		}
		
		public function set_categoria ($var)
		{
			$this->_categoria = $var;
		}
		
		public function get_categoria ()
		{
			return $this->_categoria;
		}
		
		public function set_no_empleado ($var)
		{
			$this->_no_empleado = str_pad($var, 4, "0", STR_PAD_LEFT);
		}
		
		public function get_no_empleado ()
		{
			return $this->_no_empleado;
		}
	}
?>