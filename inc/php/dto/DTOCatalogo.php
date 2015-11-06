<?php 
	class DTOCatalogo
	{
		private $_id;
		private $_id_proyecto;
		private $_id_frente;
		private $_descripcion;
		private $_estatus;
		private $_procedimiento;
		
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
		
		
		public function set_procedimiento ($procedimiento)
		{
			$this->_procedimiento = $procedimiento;
		}
		
		public function get_procedimiento ()
		{
			return $this->_procedimiento;
		}
		
		public function set_id ($id)
		{
			$this->_id = $id;
		}
		
		public function get_id ()
		{
			return $this->_id;
		}
		
		public function set_id_proyecto ($proyecto)
		{
			$this->_id_proyecto = $proyecto;
		}
		
		public function get_id_proyecto ()
		{
			return $this->_id_proyecto;
		}
		
		public function set_id_frente ($frente)
		{
			$this->_id_frente = $frente;
		}
		
		public function get_id_frente ()
		{
			return $this->_id_frente;
		}
		
		public function set_descripcion ($descripcion)
		{
			$this->_descripcion = $descripcion;
		}
		
		public function get_descripcion ()
		{
			return $this->_descripcion;
		}
		public function set_estatus ($estatus)
		{
			$this->_estatus = $estatus;
		}
		
		public function get_estatus()
		{
			return $this->_estatus;
		}
		

	}

?>