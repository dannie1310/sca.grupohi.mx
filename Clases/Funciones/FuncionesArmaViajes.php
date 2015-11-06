<?php


	#Conjunto de Funciones que nos
	#Regresan los Ids de los Datos a Partir de
	#los datos Obtenidos por el Archivo

		//Función que nos regresa el Id del Material Asociado a partir del Dato Colectado
			function RegresaIdMaterial($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT materiales.IdMaterial AS Descripcion FROM materiales, materialesxboton, botones WHERE materialesxboton.IdMaterial = materiales.IdMaterial AND materialesxboton.IdBoton = botones.IdBoton AND botones.Identificador = '$Variable'";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa el Id del Banco de Material Asociado a partir del dato Colectado
			function RegresaIdOrigen($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT IdOrigen as Descripcion FROM origenes WHERE concat(Clave,IdOrigen) = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa el Id del Banco de Material Asociado a partir del dato Colectado
			function RegresaIdTiro($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT IdTiro AS Descripcion FROM tiros WHERE concat(Clave,IdTiro) = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa el Id del Camión Asociado a partir del dato Colectado
			function RegresaIdCamion($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT camiones.IdCamion as Descripcion FROM camiones, botones WHERE botones.IdBoton = camiones.IdBoton AND botones.Identificador = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}




	#Conjunto de Funciones que nos
	#Devuelven las Descripciones
	#de los Datos Colectedos
	#por el archivo

		//Funcion que nos Regresa la Descripcion del Material
			function RegresaDescripcionMaterial($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT materiales.Descripcion FROM materiales WHERE materiales.IdMaterial = $Variable";
				//echo $sql;
				$result=$link->consultar($sql);
			//	$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa la Descripcion del Banco de Materiales Asociado a partir del dato Colectado
			function RegresaDescripcionOrigen($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT Descripcion as Descripcion FROM origenes  WHERE concat(Clave,IdOrigen) = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa la Descripcion del Destino Asociado a partir del dato Colectado
			function RegresaDescripcionTiro($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT tiros.Descripcion AS Descripcion FROM tiros WHERE concat(Clave,IdTiro) = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa la Descripcion del Destino Asociado a partir del dato Colectado
			function RegresaDescripcionCamion($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT camiones.Economico as Descripcion FROM camiones, botones WHERE botones.IdBoton = camiones.IdBoton AND botones.Identificador = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}

		//Función que nos regresa la Descripcion del Destino Asociado a partir del dato Colectado
			function RegresaDescripcionProyecto($Variable)
			{
				$link=SCA::getConexion();
				$sql="SELECT proyectos.NombreCorto as Descripcion FROM proyectos WHERE proyectos.IdProyecto = '$Variable';";
				//echo $sql;
				$result=$link->consultar($sql);
				//$link->cerrar();

				while($row=mysql_fetch_array($result))
				{
					$Descripcion=$row["Descripcion"];
				}

				return $Descripcion;
			}


?>
