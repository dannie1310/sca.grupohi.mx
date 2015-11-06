<?php

	//Funcion que se conecta a una tabla y nos trae el contenido por id y descripcion filtrado por proyecto
		function RegresaOpcionesDeCatalogo($CampoClave,$CampoDescripcion,$CampoProyecto,$IdProyecto,$Tabla)
		{
			$link=SCA::getConexion();
			$sql="Select $CampoClave as Clave, $CampoDescripcion as Descripcion from $Tabla where $CampoProyecto=$IdProyecto order by $CampoDescripcion Asc;";
			//echo $sql;
			$result=$link->consultar($sql);
			//$link->cerrar();
			
			while($row=mysql_fetch_array($result))
			{
				echo'<option value="'.$row["Clave"].'">'.$row["Descripcion"].'</option>';
			}
		}
		function RegresaOpcionesDeCatalogo2($CampoClave,$CampoDescripcion,$CampoProyecto,$IdProyecto,$Tabla,$Equal)
		{
			$link=SCA::getConexion();
			$sql="Select $CampoClave as Clave, $CampoDescripcion as Descripcion from $Tabla where $CampoProyecto=$IdProyecto order by $CampoDescripcion Asc;";
			$result=$link->consultar($sql);
			//$link->cerrar();
			
			while($row=mysql_fetch_array($result))
			{?>
				<option <?php if($row["Clave"]==$Equal) echo "selected"; ?> value="<?php echo $row["Clave"];?>"><?php echo $row[Descripcion]; ?></option>
			<?php }
		}
		
	//Función que regresa la Descripcion de una Clave de un Catálogo
		function RegresaDescripcionClave($CampoDescripcion, $CampoClave, $ValorClave, $CampoProyecto, $IdProyecto, $Tabla)
		{
			$link=SCA::getConexion();
			$sql="Select $CampoDescripcion as Descripcion from $Tabla where $CampoClave=$ValorClave and $CampoProyecto=$IdProyecto;";
			$result=$link->consultar($sql);
			//$link->cerrar();
			
			while($row=mysql_fetch_array($result))
			{
				$Descripcion=$row["Descripcion"];
			}
			
			echo $Descripcion;
		}
		
		function RegresaDescripcionClave2($CampoDescripcion, $CampoClave, $ValorClave, $CampoProyecto, $IdProyecto, $Tabla,$r)
		{
			$link=SCA::getConexion();
			$sql="Select $CampoDescripcion as Descripcion from $Tabla where $CampoClave=$ValorClave and $CampoProyecto=$IdProyecto;";
			$result=$link->consultar($sql);
			//$link->cerrar();
			
			while($row=mysql_fetch_array($result))
			{
				$Descripcion=$row["Descripcion"];
			}
				if($r=='e')
				{
					echo $Descripcion;
				}
				else
				if($r=='r')
				{
					return $Descripcion;
				}
		}
		
	//Función para convertir el formato de una fecha en español a ingles
		function FechaEnIngles($FechaEspanol)
		{
			$dia=substr($FechaEspanol,0,2); 
			$mes=substr($FechaEspanol,3,2);
			$anio=substr($FechaEspanol,6,4);
			
			$FechaIngles=$anio."-".$mes."-".$dia;
			
			return $FechaIngles;
		}
		
	//Función para convertir el formato de una fecha en ingles a español
		function FechaEnEspanol($FechaIngles)
		{
			$dia=substr($FechaIngles,8,2); 
			$mes=substr($FechaIngles,5,2);
			$anio=substr($FechaIngles,0,4);
			
			$FechaEspanol=$dia."-".$mes."-".$anio;
			
			return $FechaEspanol;
		}	

?>