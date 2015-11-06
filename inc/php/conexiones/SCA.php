<?php 
session_start();
require_once("MySQL.php");

	class SCA extends MySQL
	{
		var $enlace;
		var $qryCache=array();
		static $_instance; 
		

		public static function getConexion()
		{
			if (!(self::$_instance instanceof self))
			{          
		 		self::$_instance=new SCA();
				self::$_instance->setConexion(); 
				self::$_instance->enlace=mysql_connect(self::$_instance->servidor,self::$_instance->usuario,self::$_instance->password);
				self::$_instance->setBase(self::$_instance->base_datos);
			}
		 	return self::$_instance;    
			
		}
		public function SCA()
		{
			try
			{
				$this->setConexion(); 
				parent::MySQL($this->servidor,$this->usuario,$this->password,$this->base_datos);
				$this->enlace=mysql_connect($this->servidor,$this->usuario,$this->password);
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
			//$conf = new Conf("SCA"); 
			$conf = new Conf($_SESSION["databasesca"]);  
			$this->servidor=$conf->getHostDB();       
			$this->base_datos=$conf->getDB();       
			$this->usuario=$conf->getUserDB();       
			$this->password=$conf->getPassDB(); 
		}
	}
?>