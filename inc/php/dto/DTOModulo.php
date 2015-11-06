<?php 
	class DTOModulo
	{
		private $_id_padre;
		private $_id_modulo;
		private $_descripcion;
		private $_descripcion_corta;
		private $_accion;
		private $_sucesor;
		private $_antecesor;
		private $_pagina;
		private $_nivel;
		private $_hijos;
		private $_sqls;
		private $_clase;
		
		private $_aux_message;
		private $_aux_kind;
		
		public function DTOModulo()
		{
		
		}
		
		public function set_clase ($var)
		{
			$this->_clase = $var;
		}
		
		public function get_clase()
		{
			return $this->_clase;
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
		public function set_id_padre ($id_padre)
		{
			$this->_id_padre = $id_padre;
		}
		
		public function get_id_padre ()
		{
			return $this->_id_padre;
		}
		
		public function set_id_modulo ($id_modulo)
		{
			$this->_id_modulo = $id_modulo;
		}
		
		public function get_id_modulo ()
		{
			return $this->_id_modulo;
		}
		
		public function set_descripcion ($descripcion)
		{
			$this->_descripcion = $descripcion;
		}
		
		public function get_descripcion ()
		{
			return $this->_descripcion;
		}
		
		public function set_descripcion_corta ($descripcion_corta)
		{
			$this->_descripcion_corta = $descripcion_corta;
		}
		
		public function get_descripcion_corta ()
		{
			return $this->_descripcion_corta;
		}
		
		public function set_accion ($accion)
		{
			$this->_accion = $accion;
		}
		
		public function get_accion ()
		{
			return $this->_accion;
		}
		
		public function set_sucesor($sucesor)
		{
			$this->_sucesor = $sucesor;
		}
		
		public function get_sucesor()
		{
			return $this->_sucesor;
		}
		
		public function set_antecesor($antecesor)
		{
			$this->_antecesor = $antecesor;
		}
		
		public function get_antecesor()
		{
			return $this->_antecesor;
		}
		
		public function set_pagina ($var)
		{
			$this->_pagina = ($var=='')?'#':$var;
		}
		
		public function get_pagina ()
		{
			return $this->_pagina;
		}
		
		public function set_nivel ($nivel)
		{
			$this->_nivel = $nivel;
		}
		
		public function get_nivel ()
		{
			return $this->_nivel;
		}
		
		public function set_hijos ($hijos)
		{
			$this->_hijos = $hijos;
		}
		
		public function get_hijos ()
		{
			return $this->_hijos;
		}
		
		public function set_SQLs ($sqls)
		{
			$this->_sqls = $sqls;
		}
		
		public function get_SQLs ()
		{
			return $this->_sqls;
		}
	}

?>