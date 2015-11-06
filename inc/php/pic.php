<?php 
require_once("conexiones/TAC.php");
class Pic
{
	private $_ruta = "../src/P%s/TI/";
	private $_proyecto;
	private $_conexion;
	
	function Pic($var)
	{
		$this->set_proyecto($var);
		$this->_conexion = TAC::getConexion();
		$this->_ruta = sprintf($this->_ruta,$var);
	}
	function set_ruta($var)
	{
		$this->_ruta = $var;
	}
	function get_ruta()
	{
		return $this->_ruta;
	}
	
	function set_proyecto($var)
	{
		$this->_proyecto = $var;
	}
	function get_proyecto()
	{
		return $this->_proyecto;
	}
	
	function genera_imagenes()
	{
		if(is_dir($this->_ruta))
		{
			try{ 
				borraDirectorio($this->_ruta); 
			}
			catch(Exception $e){throw new Exception('No fue posible inicializar el directorio de imagenes : <strong>'.$e->getMessage().'</strong>');}
			if(!rmdir($this->_ruta))
				throw new Exception('No fue posible reiniciar el directorio de imagenes');
		}
		if(!is_dir($this->_ruta))
		if(!mkdir($this->_ruta))
		throw new Exception('No fue posible generar el directorio de imagenes');
		
		$SQLs = "	select noempleado,imagen, tipo from [TAC].[dbo].[tac_imagenes] as i 
					join [TAC].[dbo].[tac_exp] as e on(i.idempleado = e.idempleado) 
						where idproyecto =".$this->_proyecto." union all
SELECT descripcion as noempleado,imagen,tipo 
  FROM [TAC].[dbo].[tac_img_aux]";
	
		try{ $r = $this->_conexion->consultar($SQLs); }catch(Exception $u){throw new Exception("Hubo un error en la consulta de imagenes ");	}
		if(!$this->_conexion->affected($r)>4)
		throw new Exception('Alert..No hay fotografias asignadas a los empleados del proyecto seleccionado');
					
		$fileExtension=array("image/jpeg"=>".OED", "image/pjpeg"=>".OED", "image/gif"=>".OED");
			try
			{
				while($v = $this->_conexion->fetch($r))
				{
					try
					{ 
							file_put_contents($this->_ruta.$v["noempleado"].$fileExtension[$v["tipo"]],stripslashes(base64_decode($v["imagen"])), FILE_APPEND);
					}
					catch(Exception $e)
					{
						throw new Exception("Hubo un error en la generación de archivos de imagenes");
					}
				}
			}
			catch(Exception $e){throw new Exception("Hubo un error en el recorrido de imagenes.");}
		
	}
	
}
?>