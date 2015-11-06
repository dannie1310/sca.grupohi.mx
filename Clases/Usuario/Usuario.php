<?php
class Usuario {

 var $idUsuario;
 var $nombre;
 var $nombreEntrada;
 var $password;
 var $idTipoUsuario;
 var $estatus;
 	
	function Usuario()
	{ /*
		$this->nombre=$n;
		$this->nombreEntrada=$ne;
		$this->password=$p;
		$this->idTipoUsuario=$itu;
		
		 $link=SCA::getConexion();
		  $sql="insert into usuario (Nombre,Nombre_Entrada,Password,Id_TipoUsuario) values('".$this->nombre."','".$this->nombreEntrada."','".$this->password."',".$this->idTipoUsuario.")";
		  //echo $sql;
		  $r=$link->consultar($sql);
		  if($r==FALSE)
		  echo "HUBO UN ERROR AL REGISTRAR EL USUARIO, INTENTELO NUEVAMENTE";
		*/
		//registraUsuario($this->nombre,$this->nombreEntrada,$this->password,$this->idTipoUsuario);
	
	}


	
	
	function validaIngreso($usuario,$password)
	{
	  $link=SCA::getConexion();
	  $sql="select * from usuario where clave='".$password."' and usuario='".$usuario."'; ";
	  $r=$link->consultar($sql);
	  $v=$link->fetch($r);
	  //$link->cerrar();
	  if($r==FALSE)
	  {
	    return FALSE;
	  }
	  else
	  {
	  	$rutas=$this->obtieneRutasV($v[Id_TipoUsuario]);
	 	 session_start(); 
		$_SESSION['usuario'] = $v[Nombre];
		$_SESSION['id'] = $v[Id_Usuario];
		$_SESSION['tipo'] = $v[Id_TipoUsuario];
		$_SESSION['rutas'] = $rutas;
	  
	    return $v[Id_Usuario] ;
	   }
	} 

	function creaMenu($idUsuario,$IdProyecto){
	            /* $panelcontrol='';
	            if($IdProyecto==5555){ // SI ES PANEL DE CONTROL NO MOSTRAR LAS OPCIONES DE ADMINISTRADOR SIEMPRE Y CUANDO TENGA PERMISOS 
	               $panelcontrol = " And nu.id_modulo in (106,107,108,109) ";
				}else{
				   $panelcontrol = " And nu.id_modulo not in (106,107,108,109) ";
				}*/
                 //$sql="SELECT nm.Id_NivelMenu,nm.IdPadre,nm.Nivel,nm.Hijos,nm.Descripcion,nm.Title,nm.DescripcionTabla,nm.Icono,nm.Ruta,nu.Id_NivelMenu,nm.Estatus,nu.IdUsuario FROM niveles_menu AS nm LEFT JOIN niveles_usuario AS nu ON nm.Id_NivelMenu= nu.Id_NivelMenu WHERE nu.IdUsuario = ".$idUsuario." AND nm.Estatus=1 ORDER BY nm.nivel_largo ";
                   $sql="SELECT nm.Id_NivelMenu,nm.IdPadre,nm.Nivel,nm.Hijos,nm.Descripcion,
nm.Title,nm.DescripcionTabla,nm.Icono,nm.Ruta,nu.id_modulo,nm.Estatus,nu.id_usuario
FROM niveles_menu AS nm LEFT JOIN usuarios_proyectos_modulos AS nu
ON nm.Id_NivelMenu= nu.id_modulo WHERE nu.id_usuario =$idUsuario and nu.id_proyecto=$IdProyecto  AND nm.Estatus=1  ORDER BY nm.nivel_largo ";
		 $link=SCA_config::getConexion(); 
		 $r=$link->consultar($sql);
		 $af=$link->affected();
//echo $af;
		 //$link->cerrar();
		 $campos="";
		 $cuenta=1;
		 $i=0;
	  	 while($v=$link->fetch($r))
		 {		 	if($af==$cuenta)
				$campos=$campos.$v[DescripcionTabla];
			else
		 		$campos=$campos.$v[DescripcionTabla].',';
				
			
			$menu["IdNivel"][$i]=$v[Id_NivelMenu];
			$menu["Descripcion"][$i]=$v[Descripcion];
			$menu["Campos"][$i]=$v[DescripcionTabla];
			$menu["IdPadre"][$i]=$v[IdPadre];
			$menu["Nivel"][$i]=$v[Nivel];
			$menu["Ruta"][$i]=$v[Ruta];
			$menu["Hijos"][$i]=$v[Hijos];
			$menu["Icono"][$i]=$v[Icono];
			$menu["Title"][$i]=$v[Title];
			$cuenta++;
			$i++;
		 }
                 return $menu;
	     //print_r($menu);
		 //$link=SCA::getConexion();
	     /*$sql="select ".$campos." from permisosv2 ";
//echo $sql;
		 $r=$link->consultar($sql);
		 $af=$link->affected($sql);
		 $link->cerrar();
		 while($v=$link->fetch($r))
		 	{
				$m=0;
				for($x=0;$x<sizeof($menu["Campos"]);$x++)
				{ 
					
					if(($v[$menu["Campos"][$x]]==1)||($v[$menu["Campos"][$x]]==0))
					{
						$menuv["IdNivel"][$m]=$menu["IdNivel"][$x];
						$menuv["Descripcion"][$m]=$menu["Descripcion"][$x];
						$menuv["Campos"][$m]=$menu["Campos"][$x];
						$menuv["IdPadre"][$m]=$menu["IdPadre"][$x];
						$menuv["Nivel"][$m]=$menu["Nivel"][$x];
						$menuv["Ruta"][$m]=$menu["Ruta"][$x];
						$menuv["Hijos"][$m]=$menu["Hijos"][$x];
						$menuv["Title"][$m]=$menu["Title"][$x];
						$menuv["Icono"][$m]=$menu["Icono"][$x];
						$m++;
					}
				}
			}
			for($x=0;$x<sizeof($menuv["Campos"]);$x++)
				{
					//echo $menuv["Descripcion"][$x];
				}
                                //print_r($menuv);*/
			//return $menuv;
	
	}
	function obtieneRutasV($idTipoUsuario)
	{
		 $link=SCA::getConexion();
	     $sql="select * from niveles_menu; ";
		 $r=$link->consultar($sql);
		 $af=$link->affected();
		 $link->cerrar();
		 $campos="";
		 $cuenta=1;
		 $i=0;
	  	 while($v=$link->fetch($r))
		 {
		 	if($af==$cuenta)
				$campos=$campos.$v[DescripcionTabla];
			else
		 		$campos=$campos.$v[DescripcionTabla].',';
				
			$menu["Campos"][$i]=$v[DescripcionTabla];
			$menu["Ruta"][$i]=$v[Ruta];
		
			$cuenta++;
			$i++;
		 }
	     
		 $link=SCA::getConexion();
	     $sql="select ".$campos." from permisos where Id_TipoUsuario=".$idTipoUsuario." ; ";
		
		 $r=$link->consultar($sql);
		 $af=$link->affected();
		 $link->cerrar();
		 while($v=$link->fetch($r))
		 	{
				$m=0;
				for($x=0;$x<sizeof($menu["Campos"]);$x++)
				{
					if($v[$menu["Campos"][$x]]=='Y')
					{
						
						$menuv["Ruta"][$m]=$menu["Ruta"][$x];
						
						$m++;
					}
				}
			}
			for($x=0;$x<sizeof($menuv["Campos"]);$x++)
				{
					echo $menuv["Ruta"][$x];
				}
			return $menuv;
	
	}
	


}
?>
