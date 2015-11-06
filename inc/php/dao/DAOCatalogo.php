<?php 

	class DAOCatalogo
	{
		
		var $tac; 
		private $_campo_actualizar;
		
		public function DAOCatalogo()
		{
			 $this->tac = TAC::getConexion();
		}
		public function set_campo_actualizar($var)
		{
			$this->_campo_actualizar = $var;
		}
		
		public function get_campo_actualizar()
		{
			return $this->_campo_actualizar;
		}
		
		public function create (DTOCatalogo $catalogo)
		{		
				if(!$stmt=mssql_init($catalogo->get_procedimiento(), $this->tac->enlace))
				throw new Exception("Hubo un error al inicializar el procedimiento");
				if(!mssql_bind($stmt, "@Id", $id, SQLINT2, TRUE))
				throw new Exception("Hubo un error al inicializar variable 1");
				if(!mssql_bind($stmt, "@KindMessage", $kind, SQLVARCHAR, TRUE))
				throw new Exception("Hubo un error al inicializar variable 2");
				if(!mssql_bind($stmt, "@Message", $message, SQLVARCHAR, TRUE))
				throw new Exception("Hubo un error al inicializar variable 3"); 				
				if(!mssql_bind($stmt, "@Descripcion",  $catalogo->get_descripcion(),  SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 4"); 
				
				if(is_numeric($catalogo->get_id_proyecto()))
				{
					if(!mssql_bind($stmt, "@IdProyecto",  $catalogo->get_id_proyecto(), SQLINT1, FALSE))
					throw new Exception("Hubo un error al inicializar variable 5");
				}
				
				if(is_numeric($catalogo->get_id_frente()))
				{
					if(!mssql_bind($stmt, "@IdFrente",  $catalogo->get_id_frente(), SQLINT1, FALSE))
					throw new Exception("Hubo un error al inicializar variable 5");
				}
				
				
				if(!mssql_execute($stmt))
					throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
				
				if($kind=="red")
				{
					throw new Exception($message);
				}
				else
				{
					$catalogo->set_aux_kind($kind);
					$catalogo->set_aux_message($message);
				}
		}
		public function update(DTOCatalogo $catalogo)
		{
			switch($this->get_campo_actualizar())
			{
				case 0: $valor_actualizar = $catalogo->get_id_proyecto(); break;
				case 1: $valor_actualizar = $catalogo->get_descripcion(); break;
				case 2: $valor_actualizar = $catalogo->get_estatus(); break;
			}
			
			try
			{
				$stmt=mssql_init($catalogo->get_procedimiento(), $this->tac->enlace);
				mssql_bind($stmt, "@Id", $catalogo->get_id(),SQLINT2, FALSE); 
				mssql_bind($stmt, "@CampoActualizar",  $this->get_campo_actualizar(),  SQLINT2, FALSE); 
				mssql_bind($stmt, "@ValorActualizar",  $valor_actualizar,  SQLVARCHAR, FALSE); 
				mssql_bind($stmt, "@KindMessage", $kind,SQLVARCHAR, TRUE);
				mssql_bind($stmt, "@Message", $message,SQLVARCHAR, TRUE); 
				$result = mssql_execute($stmt);
				if($kind=="red")
				{
					throw new Exception($message);
				}
				else
				{
					$catalogo->set_aux_kind($kind);
					$catalogo->set_aux_message($message);
				}
			}
			catch(Exception $e)
			{
				throw new Exception($e->getMessage());
			}
		}
		
	}
	

?>