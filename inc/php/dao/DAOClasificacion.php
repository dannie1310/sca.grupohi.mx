<?php 
	
	
	class DAOClasificacion
	{
		var $SQL_INSERT = "CALL sp_tab_registra_clasificacion('%s', '%s', '%s', '%s', @resultado)";
		var $SQL_OMITE = "CALL sp_tab_omite_clasificacion('%s', '%s', '%s', @resultado)";
		var $controlrec; 
		var $intranet; 
		
		
		public function DAOClasificacion()
		{
			 $this->controlrec = Controlrec::getConexion();
		}
		
		public function create (DTOClasificacion $modulo)
		{
			$this->SQL_INSERT = sprintf($this->SQL_INSERT
											, $modulo->get_id_padre()
											, $modulo->get_segmento()
											, $modulo->get_operacion()
											, $modulo->get_tipo_operacion()
											);
			$modulo->set_SQLs($this->SQL_INSERT);
				
			$r = $this->controlrec->consultar($this->SQL_INSERT);
			//$v = $this->controlrec->fetch($this->intranet->consultar("SELECT @resultado"));

		}
		
		public function omite (DTOClasificacion $modulo)
		{
			$this->SQL_OMITE = sprintf($this->SQL_OMITE
											, $modulo->get_segmento()
											, $modulo->get_operacion()
											, $modulo->get_tipo_operacion()
											);
			$modulo->set_SQLs($this->SQL_OMITE);
				
			$r = $this->controlrec->consultar($this->SQL_OMITE);
			//$v = $this->controlrec->fetch($this->intranet->consultar("SELECT @resultado"));

		}
	}
	

?>