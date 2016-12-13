<?php 
class DTOCamion
{
	private $_id_camion;
	private $_id_proyecto;
	private $_sindicato;
	private $_empresa;
	private $_propietario;
	private $_operador;
	private $_economico;
	private $_placas;
    private $_placasCaja;
    private $_marca;
	private $_modelo;
	private $_aseguradora;
	private $_poliza;
	private $_vigencia;
	private $_ancho;
	private $_largo;
	private $_alto;
	private $_extension;
	private $_gato;
	private $_disminucion;
	private $_cub_real;
	private $_cub_pago;
	private $_dispositivo;
	private $_estatus; 
	
	private $_aux_message;
	private $_aux_kind;
	
	public function get_id_proyecto()
	{
		return $this->_id_proyecto;
	}
	public function set_id_proyecto($val)
	{
		$this->_id_proyecto = $val;
	}
	public function get_estatus()
	{
		return $this->_estatus;
	}
	public function set_estatus($val)
	{
		$this->_estatus = $val;
	}
	
	public function get_id_camion()
	{
		return $this->_id_camion;
	}
	public function set_id_camion($val)
	{
		$this->_id_camion = $val;
	}
	public function get_sindicato()
	{
		return $this->_sindicato;
	}
	public function set_sindicato($val)
	{
		$this->_sindicato = $val;
	}
	public function get_empresa()
	{
		return $this->_empresa;
	}
	public function set_empresa($val)
	{
		$this->_empresa = $val;
	}
	public function get_propietario()
	{
		return $this->_propietario;
	}
	public function set_propietario($val)
	{
		$this->_propietario = $val;
	}
	public function get_operador()
	{
		return $this->_operador;
	}
	public function set_operador($val)
	{
		$this->_operador = $val;
	}
	public function get_economico()
	{
		return $this->_economico;
	}
	public function set_economico($val)
	{
		$this->_economico = $val;
	}
        
        
        
	public function get_placas()
	{
		return $this->_placas;
	}
	public function set_placas($val)
	{
		$this->_placas = $val;
	}
        
        
        
        public function get_placasCaja()
	{
		return $this->_placasCaja;
	}
	public function set_placasCaja($val)
	{
		$this->_placasCaja = $val;
	}
        
        
	public function get_marca()
	{
		return $this->_marca;
	}
	public function set_marca($val)
	{
		$this->_marca = $val;
	}
	public function get_modelo()
	{
		return $this->_modelo;
	}
	public function set_modelo($val)
	{
		$this->_modelo = $val;
	}
	public function get_aseguradora()
	{
		return $this->_aseguradora;
	}
	public function set_aseguradora($val)
	{
		$this->_aseguradora = $val;
	}
	public function get_poliza()
	{
		return $this->_poliza;
	}
	public function set_poliza($val)
	{
		$this->_poliza = $val;
	}
	public function get_vigencia()
	{
		
		return $this->_vigencia;
	}
	public function set_vigencia($val)
	{
		$this->_vigencia = fechasql($val);
	}
	public function get_alto()
	{
		return $this->_alto;
	}
	public function set_alto($val)
	{
		$this->_alto = $val;
	}
	public function get_largo()
	{
		return $this->_largo;
	}
	public function set_largo($val)
	{
		$this->_largo = $val;
	}
	public function get_ancho()
	{
		return $this->_ancho;
	}
	public function set_ancho($val)
	{
		$this->_ancho = $val;
	}
	
	public function get_gato()
	{
		return $this->_gato;
	}
	public function set_gato($val)
	{
		$this->_gato = $val;
	}

	public function get_disminucion()
	{
		return $this->_disminucion;
	}
	public function set_disminucion($val)
	{
		$this->_disminucion = $val;
	}
	
	public function get_extension()
	{
		return $this->_extension;
	}
	public function set_extension($val)
	{
		$this->_extension = $val;
	}
	
	public function get_cub_real()
	{
		return $this->_cub_real;
	}
	
	public function set_cub_real($val)
	{
		$this->_cub_real = $val;
	}
	public function get_cub_pago()
	{
		return $this->_cub_pago;
	}
	public function set_cub_pago($val)
	{
		$this->_cub_pago = $val;
	}
		public function get_dispositivo()
	{
		return $this->_dispositivo;
	}
	public function set_dispositivo($val)
	{
		if($val == "A99") {
			$val= "'NULL'";
		}
		$this->_dispositivo = $val;
	}
	
	
	public function set_aux_message ($var)
	{
		$this->_aux_message = $var;
	}
		
	public function get_aux_message ()
	{
		return $this->_aux_message;
	}
		
	public function set_aux_kind ($var)
	{
		$this->_aux_kind = $var;
	}
		
	public function get_aux_kind ()
	{
		return $this->_aux_kind;
	}
	
}
?>
