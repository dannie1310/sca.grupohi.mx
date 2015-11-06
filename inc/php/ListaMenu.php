<?php
class ListaMenu{
	
	var $arregloSalida = array();
	var $arreglo =array();
	var $nodoInicial =array();
	
	static $_instance;
	
function ListaMenu($padre=0)
{
	$intranet = TAC::getConexion(); 
	
	$SQLs = "select 
				idmenu_nodo
				, descripcion_corta
				, descripcion
				, nivel
				, hijos
				, idmenu_nodo_padre as padre
				, antecesor
			from 
				tac_menu_nodo_vw where idmenu_nodo_padre >= ".$padre." order by nivel_largo
			";
	$ResultSet = $intranet->consultar($SQLs);
	while($varChar = $intranet->fetch($ResultSet))
	{
		$this->arregloSalida["idmenu_nodo"][]=$varChar["idmenu_nodo"];
		$this->arregloSalida["descripcion"][]=$varChar["descripcion"];
		$this->arregloSalida["descripcion_corta"][]=$varChar["descripcion_corta"];
		$this->arregloSalida["nivel"][]=$varChar["nivel"];
		$this->arregloSalida["padre"][]=$varChar["padre"];
		$this->arregloSalida["hijos"][]=$varChar["hijos"];
		$this->arregloSalida["antecesor"][]=$varChar["antecesor"];
	}	
}
function obtieneSucesor()
{
	
}
function ordenaLista($padre = 0)
{
	/*&& $this->arreglo["antecesor"][$i]==$antecesor*/
	$antecesor = '';
	for($i=0;$i<sizeof($this->arreglo["idmenu_nodo"]); $i++)
	{
		if($this->arreglo["padre"][$i]==$padre )
        {
			$this->arregloSalida["idmenu_nodo"][]=$this->arreglo["idmenu_nodo"][$i];
			$this->arregloSalida["descripcion"][]=$this->arreglo["descripcion"][$i];
			$this->arregloSalida["descripcion_corta"][]=$this->arreglo["descripcion_corta"][$i];
			$this->arregloSalida["nivel"][]=$this->arreglo["nivel"][$i];
			$this->arregloSalida["padre"][]=$this->arreglo["padre"][$i];
			$this->arregloSalida["hijos"][]=$this->arreglo["hijos"][$i];
			$antecesor = $this->arreglo["idmenu_nodo"][$i];
			if($this->arreglo["hijos"][$i]==1)
			{
				$this->ordenaLista($this->arreglo["idmenu_nodo"][$i]);
			}
		}
	}
}
	public function getArregloSalida()
	{
		return $this->arregloSalida;
	}
	public static function getStaticArregloSalida()
	{
		if (!(self::$_instance instanceof self))
			{          
		 		self::$_instance=new ListaMenu();
			}
		 	return self::$_instance->arregloSalida;    
	}
}
?>