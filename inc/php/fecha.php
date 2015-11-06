<?php 
class fecha
{
	private $_fecha;
	private $_dia;
	private $_mes;
	private $_anio;
	private $_hora;
	private $_minuto;
	private $_segundo;
	
	
	private $_arr_dias = array('L','M','M','J','V','S','D');
	
	function fecha($fecha)
	{
		$ex_f = explode(' ',$fecha);
		if(sizeof($ex_f)>1)
		{
			$ex_fi = explode('-',$ex_f[0]);
			$ex_hi = explode(':',$ex_f[2]);
			$this->_dia = $ex_fi[0];
			$this->_mes = $ex_fi[1];
			$this->_anio = $ex_fi[2];
			
			$this->_hora = $ex_hi[0];
			$this->_minuto = $ex_hi[1];
			$this->_segundo = $ex_hi[2];	
		}
		elseif(sizeof($ex_f)==1)
		{
			$ex_fi = explode('-',$fecha);
			$this->_dia = $ex_fi[0];
			$this->_mes = $ex_fi[1];
			$this->_anio = $ex_fi[2];
		}
	}
	public function segundos()
	{
		return mktime($this->_hora,$this->_minuto,$this->_segundo,$this->_mes,$this->_dia,$this->_anio);
	}
	function dia_semana($f="txt")
	{
		$numerico = date('N',mktime($this->_hora,$this->_minuto,$this->_segundo,$this->_mes,$this->_dia,$this->_anio));
		if($f=='num')
		$salida = $numerico ;	
		else
		if($f=='txt')
		$salida =$this->_arr_dias[$numerico-1];
		return $salida;
	}
	function dia()
	{
		return $this->_dia;
	}
	
	function regresa_fecha()
	{
		return $this->_dia.'-'.$this->_mes.'-'.$this->_anio;
	}
	
	public static function rango(fecha $fi, fecha $ff)
	{
		define(SEG_DIA ,"86400",true);
		$diferencia = $fi->segundos()-$ff->segundos();
		if($diferencia>0)
		{
			$fi_aux = $ff;	
			$ff_aux = $fi;
			
			$fi = $fi_aux;
			$ff = $ff_aux;
			
		}
		$diferencia = $fi->segundos()-$ff->segundos();
		$dias = abs($diferencia)/SEG_DIA;
		$arma=array();
		for($i=0;$i<=$dias;$i++)
		{
			$arma[]=date('d-m-Y',$fi->segundos()+($i*SEG_DIA));
		}
		
		return $arma;
	}
}
?>