<?php 

	class DAOEmpleado
	{
		
		var $tac; 
		
		public function DAOEmpleado()
		{
			 $this->tac = TAC::getConexion();
		}
		
		public function create (DTOEmpleado $empleado)
		{		
				if($empleado->get_nss()!='00000000000' && strlen($empleado->get_nss())>0 && !is_numeric($empleado->get_nss()))
				throw new Exception("El NSS debe tener formato numérico");
				if($empleado->get_nss()!='vacio' && strlen($empleado->get_nss())>0 && strlen($empleado->get_nss())!=11 )
				throw new Exception("El NSS debe tener una longitud de <strong>11 digitos</strong>");
				if($empleado->get_nombre()==''||$empleado->get_apaterno()==''||$empleado->get_amaterno()=='')
				throw new Exception("El  <strong>nombre, apellido paterno y apellido materno</strong> son campos obligatorios");
				if(!$stmt=mssql_init("tac_reg_emp", $this->tac->enlace))
				throw new Exception("Hubo un error al inicializar el procedimiento de registro de empleado");
				if(!mssql_bind($stmt, "@IdEmpleado", $id, SQLINT2, TRUE))
				throw new Exception("Hubo un error al inicializar variable 1");
				if(!mssql_bind($stmt, "@Nombre", $empleado->get_nombre(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 2");
				if(!mssql_bind($stmt, "@ApellidoP", $empleado->get_apaterno(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 3");
				if(!mssql_bind($stmt, "@ApellidoM", $empleado->get_amaterno(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 4");
				if(!mssql_bind($stmt, "@NSS", $empleado->get_nss(),  SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 5"); 
				mssql_bind($stmt, "@KindMessage", $kind , SQLVARCHAR, TRUE);
				mssql_bind($stmt, "@Message", $message , SQLVARCHAR, TRUE);
				
				
				if(!mssql_execute($stmt))
					throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
				$empleado->set_id_empleado($id);
				if($kind=="red")
				{
					throw new Exception($message);
				}
				else
				{
					$empleado->set_aux_kind($kind);
					$empleado->set_aux_message($message);
				}
		}
		public function asigna_proyecto (DTOEmpleado $empleado)
		{		
			//if($empleado->get_id_empleado()>0&&$empleado->get_proyecto()>0&&$empleado->get_categoria()>0&&$empleado->get_no_empleado()>0&&$empleado->get_proyecto()!='A99')
			if($empleado->get_proyecto()=='A99'||$empleado->get_frente()=='A99'||$empleado->get_categoria()=='A99'||!$empleado->get_no_empleado()>0)
			throw new Exception("Hacen falta por ingresar datos de la sección -Información de Proyecto-");
			if($empleado->get_no_empleado()!='vacio' && strlen($empleado->get_no_empleado())>0 && !is_numeric($empleado->get_no_empleado()))
				throw new Exception("El Número de Empleado debe tener formato numérico: ####");
				if(strlen($empleado->get_no_empleado())>4 )
				throw new Exception("El Número de Empleado debe tener una longitud máxima de <strong>4 digitos</strong>");
				if(!$stmt=mssql_init("tac_reg_exp", $this->tac->enlace))
				throw new Exception("Hubo un error al inicializar el procedimiento de registro de empleado");
				if(!mssql_bind($stmt, "@IdEmpleado", $empleado->get_id_empleado(), SQLINT2, FALSE))
				throw new Exception("Hubo un error al inicializar variable 1");
				if(!mssql_bind($stmt, "@IdProyecto", $empleado->get_proyecto(), SQLINT2, FALSE))
				throw new Exception("Hubo un error al inicializar variable 2");
				if(!mssql_bind($stmt, "@IdFrente", $empleado->get_frente(), SQLINT2, FALSE))
				throw new Exception("Hubo un error al inicializar el frente");
				if(!mssql_bind($stmt, "@IdCategoria", $empleado->get_categoria(), SQLINT2, FALSE))
				throw new Exception("Hubo un error al inicializar variable 3");
				if(!mssql_bind($stmt, "@NoEmpleado", $empleado->get_no_empleado(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 4");
				mssql_bind($stmt, "@KindMessage", $kind , SQLVARCHAR, TRUE);
				mssql_bind($stmt, "@Message", $message , SQLVARCHAR, TRUE);
				
				
				if(!mssql_execute($stmt))
					throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
				$empleado->set_id_empleado($id);
				if($kind=="red")
				{
					throw new Exception($message);
				}
				else
				{
					$empleado->set_aux_kind($kind);
					$empleado->set_aux_message($message);
				}
			
		}
		public function update(DTOEmpleado $empleado)
		{
			if(!$empleado->get_id_empleado()>0)
			throw new Exception("El identificador del empleado no es valido : ".$empleado->get_id_empleado());
			if($empleado->get_nss()!='vacio' && strlen($empleado->get_nss())>0 && !is_numeric($empleado->get_nss()))
				throw new Exception("El NSS debe tener formato numérico:".$empleado->get_nss());
				if($empleado->get_nss()!='vacio' && strlen($empleado->get_nss())>0 && strlen($empleado->get_nss())!=11 )
				throw new Exception("El NSS debe tener una longitud de <strong>11 digitos</strong>");
				if($empleado->get_nombre()==''||$empleado->get_apaterno()==''||$empleado->get_amaterno()=='')
				throw new Exception("El  <strong>nombre, apellido paterno y apellido materno</strong> son campos obligatorios");
			if(!$stmt=mssql_init("tac_mod_emp", $this->tac->enlace))
				throw new Exception("Hubo un error al inicializar el procedimiento");
				if(!mssql_bind($stmt, "@IdEmpleado", $empleado->get_id_empleado(), SQLINT2, FALSE))
				throw new Exception("Hubo un error al inicializar variable 1");
				if(!mssql_bind($stmt, "@Nombre", $empleado->get_nombre(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 2");
				if(!mssql_bind($stmt, "@ApellidoP", $empleado->get_apaterno(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 3");
				if(!mssql_bind($stmt, "@ApellidoM", $empleado->get_amaterno(), SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 4");
				if(!mssql_bind($stmt, "@NSS", $empleado->get_nss(),  SQLVARCHAR, FALSE))
				throw new Exception("Hubo un error al inicializar variable 5"); 
				mssql_bind($stmt, "@KindMessage", $kind , SQLVARCHAR, TRUE);
				mssql_bind($stmt, "@Message", $message , SQLVARCHAR, TRUE);
				
				
				if(!mssql_execute($stmt))
					throw new Exception("Hubo un error al ejecutar el procedimiento: ".mssql_get_last_message());
				
				if($kind=="red")
				{
					throw new Exception($message);
				}
				else
				{
					$empleado->set_aux_kind($kind);
					$empleado->set_aux_message($message);
				}
		}
		
	}
	

?>