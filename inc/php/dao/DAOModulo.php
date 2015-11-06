<?php 
	
	
	class DAOModulo
	{
		
		var $SQL_ELIMINA = "CALL sp_elimina_modulo('%s',@resultado)";
		var $SQL_SUBE_POSICION = "CALL sp_sube_posicion_modulo('%s',@resultado)";
		var $SQL_BAJA_POSICION = "CALL sp_baja_posicion_modulo('%s',@resultado)";
		var $tac; 
		var $intranet; 
		
		
		public function DAOModulo()
		{
			 $this->tac = TAC::getConexion();
		}
		
		public function create (DTOModulo $modulo)
		{
			if($modulo->get_descripcion()==''||$modulo->get_descripcion_corta()=='')
			throw new Exception("Los campos: <strong>Descripción, Descripción Corta</strong> son obligatorios");
			if($modulo->get_pagina()==''&&$modulo->get_accion()=='')
			throw new Exception("Debe ingresar una página ó acción del módulo");
			if(!$stmt=mssql_init("tac_reg_mod", $this->tac->enlace))
			throw new Exception("Hubo un error al inicializar el procedimiento de registro de modulo");
			if(!mssql_bind($stmt, "@IdModulo", $id,  SQLINT2, TRUE))
			throw new Exception("Hubo un error al inicializar variable @IdModulo"); 
			if(!mssql_bind($stmt, "@Descripcion", $modulo->get_descripcion(), SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Descripcion");
			if(!mssql_bind($stmt, "@DescripcionCorta", $modulo->get_descripcion_corta(), SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @DescripcionCorta");
			if(!mssql_bind($stmt, "@Accion", $modulo->get_accion(), SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Accion");
 			if(!mssql_bind($stmt, "@Pagina", $modulo->get_pagina(),  SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Pagina"); 
			if(!mssql_bind($stmt, "@Clase", $modulo->get_clase(),  SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Nivel"); 
			if(!mssql_bind($stmt, "@Padre", $modulo->get_id_padre(),  SQLINT2, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Padre"); 
			
			mssql_bind($stmt, "@KindMessage", $kind , SQLVARCHAR, TRUE);
			mssql_bind($stmt, "@Message", $message , SQLVARCHAR, TRUE);
				
				
			if(!mssql_execute($stmt))
				throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
			$modulo->set_id_modulo($id);
			if($kind=="red")
			{
				throw new Exception($message);
			}
			else
			{
				$modulo->set_aux_kind($kind);
				$modulo->set_aux_message($message);
			}
		}
		
		public function update (DTOModulo $modulo)
		{
			if($modulo->get_descripcion()==''||$modulo->get_descripcion_corta()=='')
			throw new Exception("Los campos: <strong>Descripción, Descripción Corta</strong> son obligatorios");
			if($modulo->get_pagina()==''&&$modulo->get_accion()=='')
			throw new Exception("Debe ingresar una página ó acción del módulo");
			if(!$stmt=mssql_init("tac_mod_mod", $this->tac->enlace))
			throw new Exception("Hubo un error al inicializar el procedimiento de registro de modulo");
			if(!mssql_bind($stmt, "@IdModulo", $modulo->get_id_modulo(),  SQLINT2, FALSE))
			throw new Exception("Hubo un error al inicializar variable @IdModulo"); 
			if(!mssql_bind($stmt, "@Descripcion", $modulo->get_descripcion(), SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Descripcion");
			if(!mssql_bind($stmt, "@DescripcionCorta", $modulo->get_descripcion_corta(), SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @DescripcionCorta");
			if(!mssql_bind($stmt, "@Accion", $modulo->get_accion(), SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Accion");
 			if(!mssql_bind($stmt, "@Pagina", $modulo->get_pagina(),  SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Pagina"); 
			if(!mssql_bind($stmt, "@Clase", $modulo->get_clase(),  SQLVARCHAR, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Nivel"); 
			if(!mssql_bind($stmt, "@Padre", $modulo->get_id_padre(),  SQLINT2, FALSE))
			throw new Exception("Hubo un error al inicializar variable @Padre"); 
			
			mssql_bind($stmt, "@KindMessage", $kind , SQLVARCHAR, TRUE);
			mssql_bind($stmt, "@Message", $message , SQLVARCHAR, TRUE);
				
				
			if(!mssql_execute($stmt))
				throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
			$modulo->set_id_modulo($id);
			if($kind=="red")
			{
				throw new Exception($message);
			}
			else
			{
				$modulo->set_aux_kind($kind);
				$modulo->set_aux_message($message);
			}
		}
		
		public function delete (DTOModulo $modulo)
		{
					$SQLs = "EXEC tac_del_mod ".$modulo->get_id_modulo()."";
			$r = $this->tac->consultar($SQLs);	
		}
		
		public function sube_posicion (DTOModulo $modulo)
		{
			$SQLs = "EXEC tac_sub_mod ".$modulo->get_id_modulo()."";
			$r = $this->tac->consultar($SQLs);	
		}
		
		public function baja_posicion (DTOModulo $modulo)
		{
			$SQLs = "EXEC tac_baj_mod ".$modulo->get_id_modulo()."";
			$r = $this->tac->consultar($SQLs);				
		}
		
		
	}
	

?>