<?php 
require_once("SQL.php");

	class TAC extends SQL
	{
		var $enlace;
		var $qryCache=array();
		static $_instance; 
		

		public static function getConexion()
		{
			if (!(self::$_instance instanceof self))
			{          
		 		self::$_instance=new TAC();
				self::$_instance->setConexion(); 
				self::$_instance->enlace=mssql_connect(self::$_instance->servidor,self::$_instance->usuario,self::$_instance->password);
				self::$_instance->setBase(self::$_instance->base_datos);
			}
		 	return self::$_instance;    
		}
		public function TAC()
		{
			try
			{
				$this->setConexion(); 
				parent::SQL($this->servidor,$this->usuario,$this->password,"TAC");
				$this->enlace=mssql_connect($this->servidor,$this->usuario,$this->password);
				$this->setBase($this->base_datos);
			}
			catch(Exception $e)
			{
				echo "Excepción: ".$e->getMessage();
			}
			
		}
		
		private function setConexion()
		{   
			require_once("conf_conexiones/Conf.php");  
			$conf = new Conf("TAC");  
			$this->servidor=$conf->getHostDB();       
			$this->base_datos=$conf->getDB();       
			$this->usuario=$conf->getUserDB();       
			$this->password=$conf->getPassDB(); 
		}
	}
?>