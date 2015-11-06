<?php 
	class DTOUsuario
	{
		private $_id_usuario;
		private $_usuario;
		private $_clave;
		private $_genero;
		private $_titulo;
		private $_nombre;
		private $_a_paterno;
		private $_a_materno;		
		private $_id_empresa;
		private $_id_departamento;
		private $_id_ubicacion;
		private $_id_centro_costo = "0";
		private $_estatus;
		private $_registra;
		private $_usuarioCADECO;
		
		
		private $_mail=array();
		private $_exension=array();
		
		public function _call($f, $p)
		{
			if (method_exists($this, $f.sizeof($p))) return call_user_func_array(array($this, $f.sizeof($p)), $p);
                throw new Exception('Intenta llamar un método desconocido '.get_class($this).'::'.$f);
		}
		
		public function DTOUsuario0 ()
		{
			
		}
		
		public function DTOUsuario10 ($id_usuario, $usuario, $clave, $genero, $titulo, $nombre, $id_empresa, $id_departamento, $id_centro_costo, $estatus)
		{
			$this->_id_usuario = $id_usuario;
			$this->_usuario = $usuario;
			$this->_clave = $clave;
			$this->_genero = $genero;
			$this->_titulo = $titulo;
			$this->_nombre = $nombre;
			$this->_id_empresa = $id_empresa;
			$this->_id_departamento = $id_departamento;
			$this->_id_centro_costo = $id_centro_costo;
			$this->_estatus = $estatus;
			$this->_registra = $registra;
		}
		
		public function set_usuarioCADECO ($usuarioCADECO)
		{
			$this->_usuarioCADECO = $usuarioCADECO;
		}
		
		public function get_usuarioCADECO ()
		{
			return $this->_usuarioCADECO;
		}
		
		public function set_id_usuario ($id_usuario)
		{
			$this->_id_usuario = $id_usuario;
		}
		
		public function get_id_usuario ()
		{
			return $this->_id_usuario;
		}
		
		public function set_usuario ($usuario)
		{
			$this->_usuario = $usuario;
		}
		
		public function get_usuario ()
		{
			return $this->_usuario;
		}
		
		public function set_clave ()
		{
			$numcar = 5;
			$password = "";
			
			$arr = explode(" ",strtolower($this->_nombre));
			for($i=0;$i<sizeof($arr);$i++)
			{
				$password.=substr($arr[$i],0,1);
			}
			$arr = explode(" ",strtolower($this->_a_paterno));
			for($i=0;$i<sizeof($arr);$i++)
			{
				$password.=substr($arr[$i],0,1);
			}
			$arr = explode(" ",strtolower($this->_a_materno));
			for($i=0;$i<sizeof($arr);$i++)
			{
				$password.=substr($arr[$i],0,1);
			}
			
			$password .= "_";
          	$caracteres = "0123456789bcdfghjkmnpqrstvwxyz#$%&"; 
          	$i = 0;
          	while ($i < $numcar) 
			{
				$char = substr($caracteres, mt_rand(0, strlen($caracteres)-1), 1);
				if(!strstr($password,$char)) 
				{
					$password .= $char;
					$i++;
				}
			}
			$this->_clave = $password;
		}
		
		public function get_clave ()
		{
			return $this->_clave;
		}
		
		public function set_genero ($genero)
		{
			$this->_genero = $genero;
		}
		
		public function get_genero ()
		{
			return $this->_genero;
		}
		
		public function set_titulo ($titulo)
		{
			$this->_titulo = $titulo;
		}
		
		public function get_titulo ()
		{
			return $this->_titulo;
		}
		
		public function set_nombre ($nombre)
		{
			$this->_nombre = $nombre;
		}
		
		public function get_nombre ()
		{
			return $this->_nombre;
		}
		
		public function set_a_paterno ($a_paterno)
		{
			$this->_a_paterno = $a_paterno;
		}
		
		public function get_a_paterno ()
		{
			return $this->_a_paterno;
		}
		
		public function set_a_materno ($a_materno)
		{
			$this->_a_materno = $a_materno;
		}
		
		public function get_a_materno ()
		{
			return $this->_a_materno;
		}
		
		public function set_id_empresa ($id_empresa)
		{
			$this->_id_empresa = $id_empresa;
		}
		
		public function get_id_empresa ()
		{
			return $this->_id_empresa;
		}
		
		public function set_id_departamento ($id_departamento)
		{
			$this->_id_departamento = $id_departamento;
		}
		
		public function get_id_departamento ()
		{
			return $this->_id_departamento;
		}
		
		public function set_id_ubicacion ($id_ubicacion)
		{
			$this->_id_ubicacion = $id_ubicacion;
		}
		
		public function get_id_ubicacion ()
		{
			return $this->_id_ubicacion;
		}
		
		public function set_id_centro_costo ($id_centro_costo)
		{
			$this->_id_centro_costo = $id_centro_costo;
		}
		
		public function get_id_centro_costo ()
		{
			return $this->_id_centro_costo;
		}
		
		public function set_estatus ($estatus)
		{
			$this->_estatus = $estatus;
		}
		
		public function get_estatus ()
		{
			return $this->_estatus;
		}
		
		public function set_registra ($registra)
		{
			$this->_registra = $registra;
		}
		
		public function get_registra ()
		{
			return $this->_registra;
		}
		
		public function set_mail ($mail)
		{
			$this->_mail[] = $mail;
		}
		
		public function get_mail ($indice)
		{
			return $this->_mail[$indice];
		}
		public function get_size_mail()
		{
			return sizeof($this->_mail);
		}
		public function set_extension ($extension)
		{
			$this->_extension[] = $extension;
		}
		
		public function get_extension ($indice)
		{
			return $this->_extension[$indice];
		}
	}

?>