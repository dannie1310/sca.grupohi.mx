<?php 
class Usuario
{
	private $_idusuario;
	private $tac;
	private $sec=array();
	
	public function Usuario($idUsuario)
	{
		$this->_idusuario = $idUsuario;
		$this->tac = TAC::getConexion();
		$this->sec[0] = date("Y");
		$this->sec[1] = date("md");
	}
	public function devuelveDirectorio($nivel)
	{
		$SQLs = "select pagina from tac_menu_nodo_vw where nivel_largo = '".$nivel."'";
		$r = $this->tac->consultar($SQLs);
		$v = $this->tac->fetch($r);
		$pexp = explode(".",$v["pagina"]);
		return $pexp[0]."/";
	}
	public function proyectos()
	{
		$SQLs = "
		SELECT 
			idproyecto
      		,idusuario
  		FROM tac_proyecto_x_usuario
		WHERE idusuario = ".$this->_idusuario;
		$proyectos = array();
		$r = $this->tac->consultar($SQLs);

		$i=0;
		while($v = $this->tac->fetch($r))
		{
			$proyectos[$i]=$v["idproyecto"];
			$i++;
		}
		$cad_proy = implode(",",$proyectos);
		return $cad_proy;
	}
	public function devuelveNivel($cadena,$nivel)
	{
		$cadenaret=substr($cadena,0,($nivel+1)*4);
		return $cadenaret;
	}
	public function valida_sec($nodo_hash)
	{
		$hsh1=substr($nodo_hash,0,32);
		$len_tk = strlen($nodo_hash)-64;
		$hsh2=substr($nodo_hash,32+$len_tk,32);
		$idActual = substr($nodo_hash,32,$len_tk);
		if(md5($idActual*$this->sec[0])==$hsh1&&md5($idActual*$this->sec[1])==$hsh2)
		return $idActual;
		else
		exit();
	}
	public function generaToken($nodo)
	{
		return md5($this->sec[0]*$nodo).$nodo.md5($this->sec[1]*$nodo);
	}
	public function devuelveMenu($nivelMenu, $idActual="0")
	{
		$ruta = "";
		if($idActual != md5(date("Ymd")))
		{
			$idActual=$this->valida_sec($idActual);

			$SQLsna = "select nivel,nivel_largo from tac_menu_nodo_vw where idmenu_nodo = ".$idActual;
			$rna = $this->tac->consultar($SQLsna);
			$vna = $this->tac->fetch($rna);
			$nivelActual = $vna["nivel"];
			$nivelLargoActual = $vna["nivel_largo"];
			
			
			if($nivelMenu>$nivelActual)
			{
				$s = $nivelMenu-$nivelActual;
				for($i=0;$i<$s;$i++)
				{
					$ruta.=$this->devuelveDirectorio(substr($nivelLargoActual,0,strlen($nivelLargoActual)-$i*4));
				}
			}
			elseif($nivelMenu==$nivelActual)
			{$ruta = "";}
			elseif($nivelMenu<$nivelActual)
			{ 
				$s = $nivelActual-$nivelMenu;
				for($i=0;$i<$s;$i++)
				{
					$ruta.="../";	
				}
			}
		}
		else
		{
			
			$nivelActual = 1;
			$nivelLargoActual = "000.";
		}
		
		$noancestros = $nivelActual;
		$ancestros = array();
		for($i=0;$i<$noancestros;$i++)
		{
			$ancestros["nivel"][$i]=substr($nivelLargoActual,0,strlen($nivelLargoActual)-$i*4);
			$ancestros["id"][$i]=$this->tac->regresaDatos2("tac_menu_nodo_vw","idmenu_nodo","nivel_largo",$ancestros["nivel"][$i]);
		}
		
		if($idActual == md5(date("Ymd")))
		{
			$idPadre = 0;
		}
		else
		{
			
			$nivelPadre = $this->devuelveNivel($nivelLargoActual,$nivelActual-abs(($nivelMenu-$nivelActual)-1));
			if($nivelPadre == '000.')
			{
				$idPadre = 0;
			}
			else
			{
				$idPadre = $this->tac->regresaDatos2("tac_menu_nodo_vw","idmenu_nodo","nivel_largo", $nivelPadre); 
			}
		}
		
				
		$SQLs = "select * from tac_menu_nodo_vw as m join tac_menu_nodo_x_usuario as mu on mu.idmenu_nodo = m.idmenu_nodo where idmenu_nodo_padre = ".$idPadre." and idusuario = ".$this->_idusuario." order by nivel_largo";	
		$r = $this->tac->consultar($SQLs);
		if($nivelMenu == 3)
		{
			while($v = $this->tac->fetch($r))
			{
				$href = ($v["pagina"]=="#")?"#":$ruta.$v["pagina"].'?tk='.$this->generaToken($v["idmenu_nodo"]);
				$clase = $v["clase"];
			  	$clase.=(in_array($v["idmenu_nodo"],$ancestros["id"]))?" current ":"";
			  	$salida.= '<a href="'.$href.'" class="'.$clase.'" onclick="'.$v["accion"].'">'.$v["descripcion_corta"].'</a>
			  ';
			}
		}
		else
		{
			$salida.= '<ul>';
			while($v = $this->tac->fetch($r))
			{
			  $href = ($v["pagina"]=="#")?"#":$ruta.$v["pagina"].'?tk='.$this->generaToken($v["idmenu_nodo"]);
			  $clase = $v["clase"];
			  $clase.=(in_array($v["idmenu_nodo"],$ancestros["id"]) )?" current ":"";
			  $salida.= '<li class="'.$clase.'"><a href="'.$href.'" onclick="'.$v["accion"].'">'.$v["descripcion_corta"].'</a></li>
			  ';
			}
			$salida.= '</ul>';
		}
		return $salida;
	}
	
}

?>