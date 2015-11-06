<?php

	function regresa_precio_cotizado($id_requisicion, $id_empresa, $id_material)
	{
		$sql_com_mat_pre="SELECT
			[cotizaciones].[precio_unitario],
			([cotizaciones].[cantidad]* [cotizaciones].[precio_unitario]) as importe
		FROM
			[dbo].[transacciones] [transacciones] 
				INNER JOIN [dbo].[cotizaciones] [cotizaciones] 
				ON [transacciones].[id_transaccion] = [cotizaciones].[id_transaccion] 
		WHERE
			([transacciones].[id_antecedente] =".$id_requisicion.") AND
			([transacciones].[id_empresa] =".$id_empresa.") AND
			([cotizaciones].[id_material] =".$id_material.");";
		
		$result_com_mat_pre=mssql_query($sql_com_mat_pre);
		
		$datos_proveedor=array();
		
		while($row_com_mat_pre=mssql_fetch_array($result_com_mat_pre))
		{
			$datos_proveedor[0]=$row_com_mat_pre["precio_unitario"];
			$datos_proveedor[1]=$row_com_mat_pre["importe"];
		}
		
		return $datos_proveedor;
	}
	
	
	//Esta funcion regresa el precio promedio de un material presupuestado, 
	//es necesario parsar como parametro el id del material y nos regresa 
	//el precio promedio
	
	function regresa_pup_presupuesto($id_obra, $id_material)
	{
		$sql_cmc_pup="select ((sum(precio_unitario))/count(precio_unitario)) as precio_unitario_prom from conceptos where id_obra=".$id_obra." and id_material=".$id_material.";";
		
		$result_cmc_pup=mssql_query($sql_cmc_pup);
		
		while($row_cmc_pup=mssql_fetch_array($result_cmc_pup))
		{
			$pup=$row_cmc_pup["precio_unitario_prom"];	
		}
		
		return $pup;
	}
	
	//Esta funcion regresa la cantidad presupuestada de un material 
	//es necesario parsar como parametro el id del material y nos regresa 
	//la cantidad presupuestada
	
	function regresa_cant_presupuesto($id_obra, $id_material)
	{
		$sql_cmc_pup="select sum(cantidad_presupuestada) as cantidad from conceptos where id_obra=".$id_obra." and id_material=".$id_material.";";
		
		$result_cmc_pup=mssql_query($sql_cmc_pup);
		
		while($row_cmc_pup=mssql_fetch_array($result_cmc_pup))
		{
			$pup=$row_cmc_pup["cantidad"];	
		}
		
		return $pup;
	}
	
	//
	function regresa_material_comprado($id_obra, $id_material)
	{
		$sql_cmc_pup="select 
	(sum(importe)/sum(cantidad))  as pu,
	 sum(cantidad) as cantidad
from items where id_transaccion IN (select id_transaccion from transacciones where id_obra=".$id_obra." and tipo_transaccion=33)
and id_material=".$id_material.";";
		
		$result_cmc_pup=mssql_query($sql_cmc_pup);
		
		while($row_cmc_pup=mssql_fetch_array($result_cmc_pup))
		{
			$pup[0]=$row_cmc_pup["pu"];
			$pup[1]=$row_cmc_pup["cantidad"];
		}
		
		return $pup;
	}

?>