<?php 
require_once("conexiones/SCA.php");
//$link=SCA::getConexion();
class Xml
{
	 
	private $_ruta;
	private $_tabla;
	private $_nodoP;
	private $_nodoH;
	private $_tags_campos = array();
	private $_conexion;
	private $_proyecto;
	
	function Xml ($tabla,$proyecto)
	{
		$this->_proyecto = $proyecto;
		$this->_conexion = SCA::getConexion();
		try
		{
			$this->set_tabla($tabla);
		}
		catch(Exception $e){echo $e->getMessage();}
		
		
	}
	function genera()
	{
		
	}
	private function set_tabla($tabla) 
	{
		switch ($tabla)
		{
			case "tac_empleados_vw"	: 
				$this->set_ruta("empleados"); 
				$this->_nodoP="Empleados";
				$this->_nodoH="Empleado";
				$this->tags_campos = array(
										   "IdProyecto"=>"idproyecto"
										   ,"Proyecto"=>"proyecto"
										   ,"IdEmpleado"=>"idempleado"
										   ,"Nombre"=>"nombre"
										   ,"ApellidoP"=>"apaterno"
										   ,"ApellidoM"=>"amaterno"
										   ,"Categoria"=>"categoria"
										   ,"IdCategoria"=>"idcategoria"
										   ,"NSS"=>"nss"
										   ,"NumEmpleado"=>"noempleado"
										   );
				$this->_tabla = $tabla;
			break;
			
			case "tac_jefes_frente_vw"	: 
				$this->set_ruta("jefes_frente"); 
				$this->_nodoP="Empleados";
				$this->_nodoH="Empleado";
				$this->tags_campos = array(
										   "IdProyecto"=>"idproyecto"
										   ,"Proyecto"=>"proyecto"
										   ,"IdEmpleado"=>"idempleado"
										   ,"Nombre"=>"nombre"
										   ,"ApellidoP"=>"apaterno"
										   ,"ApellidoM"=>"amaterno"
										   ,"Categoria"=>"categoria"
										   ,"IdCategoria"=>"idcategoria"
										   ,"NSS"=>"nss"
										   ,"NumEmpleado"=>"noempleado"
										   );
				$this->_tabla = $tabla;
			break;
			
			case "tac_lugares_vw":
			$this->set_ruta("frentes");
				$this->_nodoP="Frentes";
				$this->_nodoH="Frente";
				$this->tags_campos = array(
										   "Id"=>"idlugar"
										   ,"Nombre"=>"lugar"
										   );
				$this->_tabla = $tabla;
			break;
			case "tac_frentes"	: 
				$this->set_ruta("frentes");
				$this->_nodoP="Frentes";
				$this->_nodoH="Frente";
				$this->tags_campos = array(
										   "Id"=>"idfrente"
										   ,"Nombre"=>"frente"
										   );
				$this->_tabla = $tabla;
			break;
			default: throw new Exception('Tabla no válida : <strong>'.$tabla.'</strong>');break;
		}
		
	}
	private function set_ruta($ruta)
	{
		$this->_ruta = $ruta;
	}
	function genera_xml()
	{
		$escribir = false;
		if(is_dir("../src/P".$this->_proyecto))
		{
			
		}
		else
		{
			if(!mkdir("../src/P".$this->_proyecto))
			{
				throw new Exception('No fue posible crear el directorio del proyecto');
			}
		}
		if(file_exists("../src/P".$this->_proyecto.'/'.$this->_ruta.".xml"))
		{
			if(!unlink("../src/P".$this->_proyecto.'/'.$this->_ruta.".xml"))
			{
				throw new Exception('No fue posible inicializar el directorio');
			}
			else
			{
				$escribir = true;	
			}
		}
		else
		{
			$escribir = true;
		}
		if ($escribir)
		{
		$SQLs = "select * from ".$this->_tabla." where idproyecto = ".$this->_proyecto;
		if(!$rs = $this->_conexion->consultar($SQLs))
		{
			throw new Exception('No fue posible realizar la consulta');
		}
		 else
		 {
			  if(!$fp=fopen("../src/P".$this->_proyecto.'/'.$this->_ruta.".xml","w+"))
			  {
				throw new Exception('No se ha podido crear el archivo : <strong>P'.$this->_proyecto.'/'.$this->_ruta.".xml</strong>");
			  }
			  else
			  {
				  
					/*Escribo la cabecera del xml
					Véase que \r (retorno de carro) en octal es 015 y \n (nueva linea) en octal es 012*/
				
					
					fwrite($fp,"<?xml version=\"1.0\"  encoding=\"UTF-8\" ?>\012");
					fwrite($fp,"<".$this->_nodoP.">\012");
					
					if($this->_conexion->affected($rs)==0)
					{
						throw new Exception('Tabla sin registros en el sistema : <strong>'.$this->_nodoP.'</strong>');
					}
					else
					{
						while($row = $this->_conexion->fetch($rs))
						{
							/*estructura del nodo*/
							fwrite($fp,"  <".$this->_nodoH.">\012");
							foreach($this->tags_campos as $a=>$x)
							{
								fwrite($fp,"    <".$a.">".utf8_encode($row[$x])."</".$a.">\012");
							}
							fwrite($fp,"  </".$this->_nodoH.">\012");
						}
					}
					fwrite($fp,"</".$this->_nodoP.">");
					
					if(!fclose($fp)) 
					{
						throw new Exception('No se ha podido cerrar el archivo : '.$this->_ruta.".xml");
					}
				}
			}
		}
	}
	
	
}




?>