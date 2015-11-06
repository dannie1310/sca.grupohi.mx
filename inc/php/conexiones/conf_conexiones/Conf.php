<?php 

class Conf{    
	private $_domain;    
	private $_userdb;    
	private $_passdb;    
	private $_hostdb;    
	private $_db;     
	static $_instance;     
	public function Conf($bd)
	{      
		require 'config.php';       
		$this->_domain=$domain[$bd];       
		$this->_userdb=$user[$bd];       
		$this->_passdb=$password[$bd];       
		$this->_hostdb=$host[$bd];       
		$this->_db=$db[$bd];    
	}     
	private function __clone(){ }   
	
	public static function getInstance($bd)
	{       
		if (!(self::$_instance instanceof self))
		{          
			self::$_instance=new self($bd);       
		}       
		return self::$_instance;    
	}    
	
	public function setUserDB($var)
	{       
		$this->_userdb = $var;       
	} 
	
	public function getUserDB()
	{       
		$var=$this->_userdb;       
		return $var;    
	}
	
	public function setHostDB($var)
	{       
		$this->_hostdb = $var;       
	}
	
	public function getHostDB()
	{       
		$var=$this->_hostdb;       
		return $var;    
	}  
	
	public function setPassDB($var)
	{       
		$this->_passdb = $var;       
	}
	
	public function getPassDB()
	{       
		$var=$this->_passdb;       
		return $var;    
	}  
	
	public function setDB($var)
	{       
		$this->_db = $var;       
	}
	
	public function getDB()
	{       
		$var=$this->_db;       
		return $var;    
	}  
}


?>