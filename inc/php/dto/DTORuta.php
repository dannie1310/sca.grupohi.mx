<?php 
	class DTORuta
	{
		private $_id_ruta;
		private $_id_proyecto;
		private $_tipo_ruta;
		private $_id_origen;
		private $_id_tiro;
		private $_pkm;
		private $_kms;
		private $_kma;
		private $_total;
		private $_tminimo;
		private $_ttolerancia;
		private $_registra;
		
		private $_aux_message;
		private $_aux_kind;
		
		public function DTORuta()
		{
		
		}
		
		public function set_registra ($var)
		{
			$this->_registra = $var;
		}
		
		public function get_registra()
		{
			return $this->_registra;
		}
		
		public function set_tipo_ruta ($var)
		{
			$this->_tipo_ruta = $var;
		}
		
		public function get_tipo_ruta()
		{
			return $this->_tipo_ruta;
		}
		
		public function set_ttolerancia ($var)
		{
			$this->_ttolerancia = $var;
		}
		
		public function get_ttolerancia()
		{
			return $this->_ttolerancia;
		}
		
		public function set_tminimo ($var)
		{
			$this->_tminimo = $var;
		}
		
		public function get_tminimo()
		{
			return $this->_tminimo;
		}
		
		public function set_total ($var)
		{
			$this->_total = $var;
		}
		
		public function get_total()
		{
			return $this->_total;
		}
		
		public function set_kma ($var)
		{
			$this->_kma = $var;
		}
		
		public function get_kma()
		{
			return $this->_kma;
		}
		
		public function set_kms ($var)
		{
			$this->_kms = $var;
		}
		
		public function get_kms()
		{
			return $this->_kms;
		}
		
		
		public function set_pkm ($var)
		{
			$this->_pkm = $var;
		}
		
		public function get_pkm()
		{
			return $this->_pkm;
		}
		
		public function set_id_tiro ($var)
		{
			$this->_id_tiro = $var;
		}
		
		public function get_id_tiro()
		{
			return $this->_id_tiro;
		}
		
		public function set_id_origen ($var)
		{
			$this->_id_origen = $var;
		}
		
		public function get_id_origen()
		{
			return $this->_id_origen;
		}
		
		
		public function set_id_ruta ($var)
		{
			$this->_id_ruta = $var;
		}
		
		public function get_id_ruta()
		{
			return $this->_id_ruta;
		}

		public function set_id_proyecto ($id_proyecto)
		{
			$this->_id_proyecto = $id_proyecto;
		}
		
		public function get_id_proyecto ()
		{
			return $this->_id_proyecto;
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