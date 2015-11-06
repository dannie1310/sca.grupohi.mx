<?php 
function regresa_factor($IdMaterial)
{
	$link=SCA::getConexion();
	$sql="select * from factorabundamiento where IdMaterial=".$IdMaterial." order by IdFactorAbundamiento desc limit 1";
	$result=$link->consultar($sql);
	$afe=$link->affected();
	$v=mysql_fetch_array($result);
	if($afe>0)
	{
		$fab=$v["FactorAbundamiento"];	
	}
	else
	{
		
		$fab=0.00;
	}
	//$link->cerrar();
	return $fab;
}
function registra_factor($IdMaterial,$Factor,$Registra)
{
	$link=SCA::getConexion();
$sql="update factorabundamiento set Estatus=0 where IdMaterial=".$IdMaterial.";";
	$link->consultar($sql);
	$sql="Insert into factorabundamiento (IdMaterial,FactorAbundamiento,Registra,FechaAlta,HoraAlta) values(".$IdMaterial.",".$Factor.",'".$Registra."','".date("Y-m-d")."','".date("H:i:s")."')";
	//echo $sql;
	$result=$link->consultar($sql);
	//$link->cerrar();
}
?>