<?php 
	class DTOClasificacion
	{
		private $_id_padre;
		private $_segmento;
		private $_operacion;
		private $_tipo_operacion;
		private $_sqls;
		
		public function DTOClasificacion()
		{
		
		}
			
		public function DTOClasificacion3 ($id_padre, $segmento, $operacion)
		{
			$this->_id_padre = $id_padre;
			$this->_segmento = $segmento;
			$this->_operacion = $operacion;
		}
		
		public function set_tipo_operacion ($tipo_operacion)
		{
			$this->_tipo_operacion = $tipo_operacion;
		}
		
		public function get_tipo_operacion ()
		{
			return $this->_tipo_operacion;
		}
		
		public function set_id_padre ($id_padre)
		{
			$this->_id_padre = $id_padre;
		}
		
		public function get_id_padre ()
		{
			return $this->_id_padre;
		}
		
		public function set_segmento ($segmento)
		{
			$this->_segmento = $segmento;
		}
		
		public function get_segmento ()
		{
			return $this->_segmento;
		}
		
		public function set_operacion ($operacion)
		{
			$this->_operacion = $operacion;
		}
		
		public function get_operacion ()
		{
			return $this->_operacion;
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