<?php

	//Funciones para el paso de la Validación de los Viajes Cargados al Sistema


		//Función que regresa el Formato de una Fecha en US(YYYY-MM-DD)  a MX (DD-MM-YYYY)
			function FechaMX($FechaUS)
			{
				$Anio=substr($FechaUS,0,4);
				$Mes=substr($FechaUS,5,2);
				$Dia=substr($FechaUS,8,2);
				
				$FechaMX=$Dia."-".$Mes."-".$Anio;
				
				return $FechaMX;		
			}
		
		//Función que nos regresa el Total de Viajes Completos Pendietes de validar
			function RegresaTotalViajesCompletosCargados($IdProyecto)
			{
				$Link=SCA::getConexion();
				$SQL="select count(IdViajeNeto) as Total from viajesnetos where Estatus=0 and IdProyecto=".$IdProyecto.";";
				//echo $SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();


				while ($Row=mysql_fetch_array($Result))
				{
					$Total=$Row["Total"];
				}


				return $Total;
			}


		//Función que nos regresa el Total de Viajes sin Origen Pendietes de validar
			function RegresaTotalViajesIncompletosCargados($IdProyecto)
			{
				$Link=SCA::getConexion();
				$SQL="select count(IdViajeNeto) as Total from viajesnetos where Estatus=10 and IdProyecto=".$IdProyecto.";";
				//echo $SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();


				while ($Row=mysql_fetch_array($Result))
				{
					$Total=$Row["Total"];
				}


				return $Total;
			}
			
		//Función que nos regresa el Total de Viajes Completos Pendietes de validar
			function RegresaTotalViajesManualesCargados($IdProyecto)
			{
				$Link=SCA::getConexion();
				$SQL="select count(IdViajeNeto) as Total from viajesnetos where Estatus=20 and IdProyecto=".$IdProyecto.";";
				//echo $SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();


				while ($Row=mysql_fetch_array($Result))
				{
					$Total=$Row["Total"];
				}


				return $Total;
			}	

			
		//Función que nos regresa la Ruta Activa del Viaje
			function RegresaRutaViaje($Proyecto,$Origen,$Tiro)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT IdRuta as Ruta FROM rutas WHERE rutas.IdProyecto = ".$_SESSION['Proyecto']." AND rutas.IdOrigen = ".$Origen." AND rutas.IdTiro = ".$Tiro." AND rutas.Estatus = 1;";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Ruta = $Row["Ruta"];
				}

				return $Ruta;
			}

			
		//Función que Regresa la Distancia de una Ruta Activa
			function RegresaDistanciaRuta($IdRuta)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT rutas.TotalKM as Distancia FROM rutas WHERE rutas.IdRuta = ".$IdRuta.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Ruta = $Row["Distancia"];
				}

				return $Ruta;
			}
		
		
		//Función que Regresa el Importe del Viaje
			function RegresaImporteViaje($Ruta)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT ((rutas.PrimerKm*tarifas.PrimerKM)+(rutas.KmSubsecuentes*tarifas.KMSubsecuente)+(rutas.KmAdicionales*tarifas.KMAdicional)) AS Importe FROM rutas, viajesnetos, tarifas WHERE rutas.IdTiro = viajesnetos.IdTiro AND rutas.IdOrigen = viajesnetos.IdOrigen AND viajesnetos.IdMaterial = tarifas.IdMaterial AND
  rutas.IdRuta = ".$Ruta.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Importe = $Row["Importe"];
				}

				return $Importe;
			}
			
		//Función que Regresa el Importe del Primer KM del Viaje
			function RegresaImportePrimerKMViaje($IdMaterial)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT tarifas.PrimerKM as Importe FROM tarifas WHERE tarifas.IdMaterial = ".$IdMaterial.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Importe = $Row["Importe"];
				}

				return $Importe;
			}

		//Función que Regresa el Importe de los KM's Adicionales del Viaje
			function RegresaImporteKMSubViaje($IdMaterial)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT tarifas.KMSubsecuente as Importe FROM tarifas WHERE tarifas.IdMaterial = ".$IdMaterial.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Importe = $Row["Importe"];
				}

				return $Importe;
			}

			//Función que Regresa el Importe de los KM's Adicionales del Viaje
			function RegresaImporteKMAdcViaje($IdMaterial)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT tarifas.KMAdicional as Importe FROM tarifas WHERE tarifas.IdMaterial = ".$IdMaterial.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Importe = $Row["Importe"];
				}

				return $Importe;
			}				
			
			

		//Función que Regresa el Importe del Viaje
			function RegresaImporteViajeSinOrigen($IdRuta, $IdMaterial)
			{				
				//Obtenemos las distancias de la Ruta
					$Link=SCA::getConexion();
					$SQL="SELECT rutas.PrimerKm, rutas.KmSubsecuentes, rutas.KmAdicionales FROM rutas WHERE rutas.IdRuta = ".$IdRuta.";";
					//echo "<br><br><br>".$SQL;
					$Result=$Link->consultar($SQL);
					//$Link->cerrar();
					
					while($row=mysql_fetch_array($Result))
					{
						$DistPrimer=$row["PrimerKm"]; $DistSubsecuentes=$row["KmSubsecuentes"]; $DistAdicionales=$row["KmAdicionales"];
					}
					
				//Obtenemos las tarifas para cada tipo de Kilimetro
					$Link=SCA::getConexion();
					$SQL="SELECT tarifas.PrimerKM,tarifas.KMSubsecuente,tarifas.KMAdicional FROM tarifas WHERE tarifas.IdMaterial = ".$IdMaterial.";";
					//echo "<br><br><br>".$SQL;
					$Result=$Link->consultar($SQL);
					//$Link->cerrar();
					
					while($row=mysql_fetch_array($Result))
					{
						$CostPrimer=$row["PrimerKM"]; $CostSubsecuentes=$row["KMSubsecuente"]; $CostAdicionales=$row["KMAdicional"];
					}
					
				//Obtenemos los productos de las Distancias y de los Costos	
					//echo "<br>DistPrimer: ".$DistPrimer;
					//echo "<br>DistSubsecuentes: ".$DistSubsecuentes;
					//echo "<br>DistAdicionales: ".$DistAdicionales;
					//echo "<br>CostPrimer: ".$CostPrimer;
					//echo "<br>CostSubsecuentes: ".$CostSubsecuentes;
					//echo "<br>CostAdicionales: ".$CostAdicionales;
				
					$ImpPrimerKm=($DistPrimer * $CostPrimer);
					$ImpKmSubsecuentes=($DistSubsecuentes * $CostSubsecuentes);
					$ImpKmAdicionales=($DistAdicionales * $CostAdicionales);
					
					//echo "<br>ImpPrimerKm: ".$ImpPrimerKm;
					//echo "<br>ImpKmSubsecuentes: ".$ImpKmSubsecuentes;
					//echo "<br>ImpKmAdicionales: ".$ImpKmAdicionales;
				
				//Obtenemos el Total del Viaje
				
					$Total=(($ImpPrimerKm + $ImpKmSubsecuentes) + $ImpKmAdicionales);
				
				return $Total;
			}
			
		//Función que regresa la Distancia del Primer KM de la Ruta
			function RegresaDistanciaDePrimeKM($IdRuta)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT rutas.PrimerKm as Distancia FROM rutas WHERE rutas.IdRuta = ".$IdRuta.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Distancia = $Row["Distancia"];
				}

				return $Distancia;
			}
			
		//Función que regresa la Distancia de los KM's Subsecuentes de la Ruta
			function RegresaDistanciaDeKMSub($IdRuta)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT rutas.KmSubsecuentes as Distancia FROM rutas WHERE rutas.IdRuta = ".$IdRuta.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Distancia = $Row["Distancia"];
				}

				return $Distancia;
			}
			
		//Función que regresa la Distancia de los KM's Subsecuentes de la Ruta
			function RegresaDistanciaDeKMAdc($IdRuta)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT rutas.KmAdicionales as Distancia FROM rutas WHERE rutas.IdRuta = ".$IdRuta.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Distancia = $Row["Distancia"];
				}

				return $Distancia;
			}
			
			

		 //Función para revisar el tiempo del Viaje
		 	function RevisaCronometria($TiempoViaje,$IdRuta)
		 	{
		 		$Link=SCA::getConexion();
				$SQL="SELECT cronometrias.IdRuta AS IdRuta, round(cronometrias.TiempoMinimo,2) AS TiempoMinimo, round(cronometrias.Tolerancia,2) AS Tolerancia, round(((".$TiempoViaje.")-cronometrias.TiempoMinimo),2) AS Tiempo, round((".$TiempoViaje.")-(round(cronometrias.TiempoMinimo,2)-round(cronometrias.Tolerancia,2)),2) AS TiempoTolerancia FROM cronometrias WHERE cronometrias.IdRuta = ".$IdRuta.";";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$TiempoMinimo=$Row["TiempoMinimo"];//7
					$Tolerancia=$Row["Tolerancia"];//2
					$Tiempo=$Row["Tiempo"];//11-7=3   5-7=-2
					$TiempoTolerancia=$Row["TiempoTolerancia"];//11-(7-3) = 11-7+2 = 6      5-(7-3) = 5-7+2 =  0
				//	echo '<br>t:'.$TiempoTolerancia;
				}

				if($Tiempo<0)
				{
					if($TiempoTolerancia<0)
					{
						$Cronometria=0;
					}
					else
					{
						$Cronometria=1;
					}
				}
				else
				{
					$Cronometria=1;
				}

				return $Cronometria;
		 	}

			
		 //Funcion que nos despliega los origenes disponibles
		 function SeleccionaOrigen($IdProyecto, $NombreComponente, $EstiloComponente,$NumeroHijos,$Tiro)
		 	{
		 		$Link=SCA::getConexion();
				$SQL="SELECT origenes.IdOrigen, concat(origenes.Clave,'-',origenes.IdOrigen) AS Clave, origenes.Descripcion FROM origenes WHERE origenes.IdProyecto = ".$IdProyecto." AND origenes.Estatus = 1 AND IdOrigen in(select IdOrigen from rutas where IdTiro=".$Tiro.") ORDER BY origenes.Descripcion;";
				//echo "<br>$Tiro,".$SQL;
				$Result=$Link->consultar($SQL);
				$ex=$Link->affected();
				//$Link->cerrar();
				if($ex>0)
				{
				echo'<select id="'.$NombreComponente.'" name="'.$NombreComponente.'" class="'.$EstiloComponente.'" onChange="validah(this.id,'.$NumeroHijos.')">';
				echo'<option value="A99">- SELECCIONE -</option>';

				while ($Row=mysql_fetch_array($Result))
				{
					echo'<option value="'.$Row["IdOrigen"].'">'.$Row["Descripcion"].' ('.$Row["Clave"].')</option>';
				}
				echo'</Select>';
				}
				else
				{echo "<font color='FF0000'>NO EXISTE UNA RUTA PARA EL  TIRO: ";  echo "<strong>";regresa(tiros,Descripcion,IdTiro,$Tiro); echo "</strong></font>";}
		 	}
		 	
			function SeleccionaOrigenH($IdProyecto, $IdComponente, $NombreComponente, $EstiloComponente,$Tiro)
		 	{
		 		$Link=SCA::getConexion();
				$SQL="SELECT origenes.IdOrigen, concat(origenes.Clave,'-',origenes.IdOrigen) AS Clave, origenes.Descripcion FROM origenes WHERE origenes.IdProyecto = ".$IdProyecto." AND origenes.Estatus = 1 AND IdOrigen in(select IdOrigen from rutas where IdTiro=".$Tiro.")  ORDER BY origenes.Descripcion;";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				$ex=$Link->affected();
				//$Link->cerrar();
				
				if($ex>0)
				{
				echo'<select id="'.$IdComponente.'" name="'.$NombreComponente.'" class="'.$EstiloComponente.'" >';
				echo'<option value="A99">- SELECCIONE -</option>';

				while ($Row=mysql_fetch_array($Result))
				{
					echo'<option value="'.$Row["IdOrigen"].'">'.$Row["Descripcion"].' ('.$Row["Clave"].')</option>';
				}
				echo'</Select>';
				}
				
				else
				{echo "<div align='center'><font color='FF0000'>NO EXISTE UNA RUTA PARA EL  TIRO:<br> ";  echo "<strong>";regresa(tiros,Descripcion,IdTiro,$Tiro); echo "</strong></font></div>";}
		 	}

		
			
		//Funcion que Regresa el Número de Viajes que Hizo un Camion en Cierto Dia y en cierto Tiro
			function RegresaTotalViajesXDiaXTiro($IdProyecto,$Dia,$IdTiro,$IdCamion)
			{
				$Link=SCA::getConexion();
				$SQL="SELECT count(viajes.IdViaje) AS Total FROM viajes WHERE viajes.IdProyecto = ".$IdProyecto." AND viajes.FechaSalida = '".$Dia."' AND viajes.IdTiro = ".$IdTiro." AND viajes.IdCamion = ".$IdCamion.";";
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Total=$Row["Total"];
				}

				return $Total;
			}

			
		 //Funcion que regresa la Suma del Importe de los Viajes Realizados por X Camion en X Dia en X Tiro
		 	function RegresaImporteSumaViajesXTiroXFecha($IdProyecto,$Semana,$IdTiro,$IdCamion)
		 	{
		 		$Link=SCA::getConexion();
				$SQL="SELECT viajes.IdCamion, sum(viajes.Importe) AS Total FROM viajes WHERE viajes.IdProyecto = ".$_SESSION["Proyecto"]." AND weekofyear(viajes.FechaSalida) = ".$Semana." AND viajes.IdTiro = ".$IdTiro." AND viajes.IdCamion = ".$IdCamion." GROUP BY viajes.IdCamion;";
				$Result=$Link->consultar($SQL);
				//$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Total=$Row["Total"];
				}

				return $Total;
		 	}

?>