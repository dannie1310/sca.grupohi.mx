<?php 
	require_once ($_SERVER['DOCUMENT_ROOT']."gln/Funciones_Clases/PHP/DTO/DTOUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."gln/Funciones_Clases/PHP/Intranet.php");
	require_once($_SERVER['DOCUMENT_ROOT']."gln/Funciones_Clases/PHP/Controlrec.php");
	
	class DAOUsuario
	{
		var $SQL_INSERT = "CALL itr_sp_registra_usuario( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', @id_usuario, @usuario)";
		var $controlrec; 
		var $intranet; 
		
		public function DAOUsuario()
		{
			 $this->controlrec = Controlrec::getConexion();
			 $this->intranet = Intranet::getConexion();
		}
		
		public function create (DTOUsuario $usuario)
		{
			if($usuario->get_id_usuario()!="")
			{ 
				throw new Exception('El empleado ya ha sido registrado');
			}
			else
			{
				$this->SQL_INSERT = sprintf($this->SQL_INSERT,  md5($usuario->get_clave()),$usuario->get_genero(),$usuario->get_titulo(),$usuario->get_nombre(),$usuario->get_a_paterno(),$usuario->get_a_materno(),$usuario->get_id_empresa(),$usuario->get_id_ubicacion(),$usuario->get_id_departamento(),$usuario->get_usuarioCADECO(),$usuario->get_id_centro_costo(), $usuario->get_estatus(), $usuario->get_registra());
				
				$r = $this->intranet->consultar($this->SQL_INSERT);
				$v = $this->intranet->fetch($this->intranet->consultar("SELECT @id_usuario, @usuario"));
				
				$usuario->set_usuario($v["@usuario"]);
				$usuario->set_id_usuario($v["@id_usuario"]);
			}
			
			//return $v["@id_usuario"];
			
		}
		
	}
	

?>