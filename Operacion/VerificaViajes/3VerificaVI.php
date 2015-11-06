	<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>

</head>

<body onkeydown="backspace();">
<?php

	//Incluimos los Archivos a Usar
		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");
		include("../../Clases/Funciones/FactorAbundamiento.php");


		$TotalV=$_POST["TotalV"];
		$padre=$_POST["selectpadre"];
		$OrigenP=$_POST[$padre];
		//echo 'dsad: '.$TotalV;
		$b=0;
		for($a=0;$a<$TotalV;$a++)
		{
			//echo "<br>Viaje ".$a." : ".$_POST['Viaje'.$a];
			
			if($_POST['Viaje'.$a]<>""&&$_POST['Origen'.$a]!="A99")
			{ //echo $b.'<br>';
				$origen[$b]=$_POST['Origen'.$a];
				$tiro[$b]=$_POST['Tiro'.$a];
				$Viajes[$b][1]=$_POST['Viaje'.$a]; //Id del Viaje
				$Viajes[$b][2]=$_POST['Tiempo'.$a]; //Tiempo Viaje
				$Viajes[$b][3]=$_POST['Ruta'.$a]; //Id de Ruta
				$Viajes[$b][4]=$_POST['Distancia'.$a]; //Distancia en KM
				$Viajes[$b][5]=$_POST['Importe'.$a]; //Importe del Viaje
				//echo 'Viajes3: '.$Viajes[$b][3];
				$Viajes[$b][14]=$_POST['ImportePrimerKM'.$a]; //Importe del Primer Km
				$Viajes[$b][15]=$_POST['ImporteKMSub'.$a]; //Importe de los Km's Subsecuentes
				$Viajes[$b][16]=$_POST['ImporteKMAdc'.$a]; //Importe de los Km's Adicionales
				
				$Viajes[$b][17]=$_POST['VolumenPrimerKM'.$a]; //Volumen del Primer KM
				$Viajes[$b][18]=$_POST['VolumenKMSub'.$a]; //Volumen Km's Subsecuentes
				$Viajes[$b][19]=$_POST['VolumenKMAdc'.$a]; //Volumen Km's Adicionales
				$Viajes[$b][20]=$_POST['Volumen'.$a]; //Volumen Total
				
				$Viajes[$b][21]=$_POST['Cubicacion'.$a]; //Cubicacion del Camion
				$Viajes[$b][27]=$_POST['maquinaria'.$a]; 
				$Viajes[$b][28]=$_POST['hef'.$a];
				if($Viajes[$b][27]=='A99')
					$Viajes[$b][27]=0;
				if($Viajes[$b][28]=='')
					$Viajes[$b][28]=0;


				//echo $origen[$b].'<br>';
				//echo $Viajes[$b][1];
				$b=$b+1;
			}
		}
		
		//Recibimos las Variables de los Viajes Rechazados (No Validos por Cronometria o no Aceptados)
		$c=0;
		for($a=0;$a<$TotalV;$a++)
		{
		
			//echo "<br>ViajeRechazado ".$a." : ".$_POST['ViajeRechazado'.$a];
			if($_POST['ViajeRechazado'.$a]<>""&&$_POST['Origen'.$a]!="A99")
			{
				$origenr[$c]=$_POST['Origen'.$a];
				$tiro[$c]=$_POST['Tiro'.$a];
				$ViajesRechazados[$c][1]=$_POST['ViajeRechazado'.$a]; //Id del Viaje
				$ViajesRechazados[$c][2]=$_POST['Tiempo'.$a]; //Tiempo Viaje
				
				$ViajesRechazados[$c][3]=$_POST['Ruta'.$a]; //Id de Ruta
				$ViajesRechazados[$c][4]=$_POST['Distancia'.$a]; //Distancia en KM
				$ViajesRechazados[$c][5]=$_POST['Importe'.$a]; //Importe del Viaje
				
				$ViajesRechazados[$c][14]=$_POST['ImportePrimerKM'.$a]; //Importe del Primer Km
				$ViajesRechazados[$c][15]=$_POST['ImporteKMSub'.$a]; //Importe de los Km's Subsecuentes
				$ViajesRechazados[$c][16]=$_POST['ImporteKMAdc'.$a]; //Importe de los Km's Adicionales
				
				$ViajesRechazados[$c][17]=$_POST['VolumenPrimerKM'.$a]; //Volumen del Primer KM
				$ViajesRechazados[$c][18]=$_POST['VolumenKMSub'.$a]; //Volumen Km's Subsecuentes
				$ViajesRechazados[$c][19]=$_POST['VolumenKMAdc'.$a]; //Volumen Km's Adicionales
				$ViajesRechazados[$c][20]=$_POST['Volumen'.$a]; //Volumen Total
				
				$ViajesRechazados[$c][21]=$_POST['Cubicacion'.$a]; //Cubicacion del Camion
				$ViajesRechazados[$c][27]=$_POST['maquinaria'.$a]; 
				$ViajesRechazados[$c][28]=$_POST['hef'.$a]; 

				if($ViajesRechazados[$c][27]=='A99')
					$ViajesRechazados[$c][27]=0;
				if($ViajesRechazados[$c][28]=='')
					$ViajesRechazados[$c][28]=0;



				
				$c=$c+1;
			}
		}
		
		

		$TotalAProcesar=count($Viajes);
		$TotalARechazar=count($ViajesRechazados);
		//echo "<br>TotalAProcesar: $TotalAProcesar<br>";
	//echo "TotalARechazar: $TotalARechazar<br>";


		//Procesamos los Viajes Marcados como Validos
		$e=0;
			for($a=0;$a<$TotalAProcesar;$a++)
			{
				//Insertamos los Datos de los Viajes Validos en la tabla

				$Hoy=date("Y-m-d");
				$Hora=date("H:i:s",time());
				$Creo=$_SESSION['Descripcion']."*".$Hoy."*".$Hora;

				//Nos Traemos Los Datos Complemtentarios de Viaje Neto
				$Link=SCA::getConexion();
				$SQL="SELECT viajesnetos.IdCamion,viajesnetos.IdTiro,viajesnetos.FechaLlegada,viajesnetos.HoraLlegada,viajesnetos.IdMaterial,camiones.CubicacionParaPago FROM viajesnetos,camiones WHERE camiones.IdCamion = viajesnetos.IdCamion AND(viajesnetos.IdViajeNeto = ".$Viajes[$a][1].");";
				//echo "<br><br>".$SQL;
				$Result=$Link->consultar($SQL);
				$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$Viajes[$a][3]=$Row["IdCamion"];
					$Viajes[$a][4]=$Row["IdTiro"];
					$Viajes[$a][5]=$Row["FechaLlegada"];
					$Viajes[$a][6]=$Row["HoraLlegada"];
					$Viajes[$a][7]=$Row["IdMaterial"];
					$Viajes[$a][8]=RegresaRutaViaje($_SESSION['Proyecto'],$origen[$a],$tiro[$a]);	
echo 'Origen: '.$origen[$a];//Id de la Ruta del Viaje
echo 'Tiro: '.$tiro[$a];//Id de la Ruta del Viaje
echo 'Proyecto'.$_SESSION['Proyecto'];
	
					echo 'Ruta: '.$Viajes[$a][8];//Id de la Ruta del Viaje
					$Viajes[$a][9]=RegresaDistanciaRuta($Viajes[$a][8]);
					//$Viajes[$a][10]=RegresaImporteViajeSinOrigen($Viajes[$a][8],$Viajes[$a][7]);
					$Viajes[$a][11]=$Row["CubicacionParaPago"];
					$Viajes[$a][12]=$Viajes[$a][11] * $Viajes[$a][10];

					//Importes
						$Viajes[$a][13]=RegresaImportePrimerKMViaje($Viajes[$a][7]);
						$Viajes[$a][14]=RegresaImporteKMSubViaje($Viajes[$a][7]);
						$Viajes[$a][15]=RegresaImporteKMAdcViaje($Viajes[$a][7]);

					//Volúmenes
						$Viajes[$a][16]=RegresaDistanciaDePrimeKM($Viajes[$a][8]);
						$Viajes[$a][17]=RegresaDistanciaDeKMSub($Viajes[$a][8]);
						$Viajes[$a][18]=RegresaDistanciaDeKMAdc($Viajes[$a][8]);

						$Viajes[$a][19]=$Viajes[$a][16] * $Viajes[$a][11];	//Volumen del Primer KM
						$Viajes[$a][20]=$Viajes[$a][17] * $Viajes[$a][11];	//Volumen de los Km's Subsecuentes
						$Viajes[$a][21]=$Viajes[$a][18] * $Viajes[$a][11];	//Volumen de los Km's Adicionales
						$Viajes[$a][22]=$Viajes[$a][19] + $Viajes[$a][20] + $Viajes[$a][21]; //Volumen Total de la Ruta

						$Viajes[$a][23]=$Viajes[$a][19] * $Viajes[$a][13];
						$Viajes[$a][24]=$Viajes[$a][20] * $Viajes[$a][14];
						$Viajes[$a][25]=$Viajes[$a][21] * $Viajes[$a][15];
						$Viajes[$a][26]=$Viajes[$a][23] + $Viajes[$a][24] + $Viajes[$a][25];
				}
                $FactorAbundamiento=regresa_factor($Viajes[$a][7]);
				$Link=SCA::getConexion();
				$SQL="insert into viajes(HorasEfectivas,IdMaquinaria,FactorAbundamiento,IdViajeNeto,FechaCarga,HoraCarga,IdProyecto,IdCamion,CubicacionCamion,IdOrigen,FechaSalida,IdTiro,FechaLlegada,HoraLlegada,IdMaterial,Creo,IdRuta,Distancia,VolumenPrimerKM,VolumenKMSubsecuentes,VolumenKMAdicionales,Volumen,ImportePrimerKM,ImporteKMSubsecuentes,ImporteKMAdicionales,Importe,Estatus)
				values(".$Viajes[$a][28].",".$Viajes[$a][27].",".$FactorAbundamiento.",".$Viajes[$a][1].",'".$Hoy."','".$Hora."',".$_SESSION['Proyecto'].",".$Viajes[$a][3].",".$Viajes[$a][11].",".$origen[$a].",'".$Viajes[$a][5]."',".$Viajes[$a][4].",'".$Viajes[$a][5]."','".$Viajes[$a][6]."',".$Viajes[$a][7].",'".$Creo."',".$Viajes[$a][8].",".$Viajes[$a][9].",".$Viajes[$a][19].",".$Viajes[$a][20].",".$Viajes[$a][21].",".$Viajes[$a][22].",'".$Viajes[$a][23]."','".$Viajes[$a][24]."','".$Viajes[$a][25]."','".$Viajes[$a][26]."',10);";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				$Insertado=0;
				$Insertado=$Link->affected();	
				if($Insertado>0)
				$TotalInsertados=$TotalInsertados+$Insertado;
				$Link->cerrar();
				
				//Actualizamos el estado de los Insertados
				if($Insertado==1)
				{
					//Actualizamos el Estatus de los Viajes Netos Procesados
					$Link=SCA::getConexion();
					$SQL="update viajesnetos set Estatus=11 where IdViajeNeto=".$Viajes[$a][1].";";
					//echo "<br>".$SQL;
					$Result=$Link->consultar($SQL);
					$Link->cerrar();
				}
				
				else
				{
					//$viajeProcesarError[$e]=$Viajes[$a][1];
					$viajeProcesarError[$e][1]=$Viajes[$a][1];
					$viajeProcesarError[$e][7]=$Viajes[$a][7];
					$viajeProcesarError[$e][10]=$Viajes[$a][10];
					$TotalAProcesarError++;
					$e++;
				}
				
				
			}
		$e=0;

		//Procesamos los Viajes Marcados como NO Validos
			for($a=0;$a<$TotalARechazar;$a++)
			{
				//Insertamos los Datos de los Viajes Validos en la tabla

				$Hoy=date("Y-m-d");
				$Hora=date("H:i:s",time());
				$Creo=$_SESSION['Descripcion']."*".$Hoy."*".$Hora;

				//Nos Traemos Los Datos Complemtentarios de Viaje Neto
				$Link=SCA::getConexion();
				$SQL="SELECT viajesnetos.IdCamion,viajesnetos.IdTiro,viajesnetos.FechaLlegada,viajesnetos.HoraLlegada,viajesnetos.IdMaterial,camiones.CubicacionParaPago FROM viajesnetos,camiones WHERE camiones.IdCamion = viajesnetos.IdCamion AND(viajesnetos.IdViajeNeto = ".$ViajesRechazados[$a][1].");";
				//echo "<br><br>".$SQL;
				$Result=$Link->consultar($SQL);
				$Link->cerrar();

				while($Row=mysql_fetch_array($Result))
				{
					$ViajesRechazados[$a][3]=$Row["IdCamion"];
					$ViajesRechazados[$a][4]=$Row["IdTiro"];
					$ViajesRechazados[$a][5]=$Row["FechaLlegada"];
					$ViajesRechazados[$a][6]=$Row["HoraLlegada"];
					$ViajesRechazados[$a][7]=$Row["IdMaterial"];	//Id del Material
					
					//echo "<br>Id De Material: ".$ViajesRechazados[$a][7];
					
					$ViajesRechazados[$a][8]=RegresaRutaViaje($_SESSION['Proyecto'],$origen[$a],$tiro[$a]);		//Id de la Ruta del Viaje
					$ViajesRechazados[$a][9]=RegresaDistanciaRuta($ViajesRechazados[$a][8]);
					$ViajesRechazados[$a][10]=RegresaImporteViajeSinOrigen($ViajesRechazados[$a][8],$ViajesRechazados[$a][7]);
					$ViajesRechazados[$a][11]=$Row["CubicacionParaPago"];
					$ViajesRechazados[$a][12]=$ViajesRechazados[$a][11] * $ViajesRechazados[$a][10];

					//Importes de los materiales por Tipo de Material
						$ViajesRechazados[$a][13]=RegresaImportePrimerKMViaje($ViajesRechazados[$a][7]);
						$ViajesRechazados[$a][14]=RegresaImporteKMSubViaje($ViajesRechazados[$a][7]);
						$ViajesRechazados[$a][15]=RegresaImporteKMAdcViaje($ViajesRechazados[$a][7]);
						
						//echo "<br>Importe del material por KM: ".$ViajesRechazados[$a][13];
						//echo "<br>Importe del material por KM: ".$ViajesRechazados[$a][14];
						//echo "<br>Importe del material por KM: ".$ViajesRechazados[$a][15];
						

					//Distancias por Kilometro de cada Ruta
						$ViajesRechazados[$a][16]=RegresaDistanciaDePrimeKM($ViajesRechazados[$a][8]);
						$ViajesRechazados[$a][17]=RegresaDistanciaDeKMSub($ViajesRechazados[$a][8]);
						$ViajesRechazados[$a][18]=RegresaDistanciaDeKMAdc($ViajesRechazados[$a][8]);
						
						//echo "<br>Distancia por kilometro: ".$ViajesRechazados[$a][16];
						//echo "<br>Distancia por kilometro: ".$ViajesRechazados[$a][17];
						//echo "<br>Distancia por kilometro: ".$ViajesRechazados[$a][18];

						
						//Volumenes por Kilometro
						$ViajesRechazados[$a][19]=$ViajesRechazados[$a][16] * $ViajesRechazados[$a][11];	//Volumen del Primer KM
						$ViajesRechazados[$a][20]=$ViajesRechazados[$a][17] * $ViajesRechazados[$a][11];	//Volumen de los Km's Subsecuentes
						$ViajesRechazados[$a][21]=$ViajesRechazados[$a][18] * $ViajesRechazados[$a][11];	//Volumen de los Km's Adicionales
						$ViajesRechazados[$a][22]=$ViajesRechazados[$a][19] + $ViajesRechazados[$a][20] + $ViajesRechazados[$a][21]; //Volumen Total de la Ruta
						

						$ViajesRechazados[$a][27]=$ViajesRechazados[$a][19] * $ViajesRechazados[$a][13];	//Importe del primer KM
						$ViajesRechazados[$a][28]=$ViajesRechazados[$a][20] * $ViajesRechazados[$a][14];	//Importe de los KM Subsecuentes
						$ViajesRechazados[$a][29]=$ViajesRechazados[$a][21] * $ViajesRechazados[$a][15];	//Importe de los Km adicionales
						$ViajesRechazados[$a][30]=$ViajesRechazados[$a][27] + $ViajesRechazados[$a][28] + $ViajesRechazados[$a][29];	//Importe Total del Viaje
						
						//echo "<br>Importe por Kilometro: ".$ViajesRechazados[$a][27];
						//echo "<br>Importe por Kilometro: ".$ViajesRechazados[$a][28];
						//echo "<br>Importe por Kilometro: ".$ViajesRechazados[$a][29];
				}
                $FactorAbundamiento=regresa_factor($ViajesRechazados[$a][7]);
				$Link=SCA::getConexion();
				$SQL="insert into viajesrechazados(HorasEfectivas,IdMaquinaria,FactorAbundamiento,IdViajeNeto,FechaRechazo,HoraRechazo,IdProyecto,IdCamion,CubicacionCamion,IdOrigen,FechaSalida,IdTiro,FechaLlegada,HoraLlegada,IdMaterial,Creo,IdRuta,Distancia,VolumenPrimerKM,VolumenKMSubsecuentes,VolumenKMAdicionales,Volumen,ImportePrimerKM,ImporteKMSubsecuentes,ImporteKMAdicionales,Importe,Estatus)
				values(".$ViajesRechazados[$a][28].",".$ViajesRechazados[$a][27].",".$FactorAbundamiento.",".$ViajesRechazados[$a][1].",'".$Hoy."','".$Hora."',".$_SESSION['Proyecto'].",".$ViajesRechazados[$a][3].",".$ViajesRechazados[$a][11].",".$origenr[$a].",'".$ViajesRechazados[$a][5]."',".$ViajesRechazados[$a][4].",'".$ViajesRechazados[$a][5]."','".$ViajesRechazados[$a][6]."',".$ViajesRechazados[$a][7].",'".$Creo."','".$ViajesRechazados[$a][8]."','".$ViajesRechazados[$a][9]."',".$ViajesRechazados[$a][19].",".$ViajesRechazados[$a][20].",".$ViajesRechazados[$a][21].",".$ViajesRechazados[$a][22].",'".$ViajesRechazados[$a][27]."','".$ViajesRechazados[$a][28]."','".$ViajesRechazados[$a][29]."','".$ViajesRechazados[$a][30]."',10);";
				//echo "<br>".$SQL;
				$Result=$Link->consultar($SQL);
				$Insertado=$Link->affected();
				if($Insertado>0)
				$TotalRechazados=$TotalRechazados+$Insertado;
				$Link->cerrar();
				//echo $Insertado;
				//Actualizamos el Estatus de los Viajes Netos Procesados
				if($Insertado==1)
				{
					$Link=SCA::getConexion();
					$SQL="update viajesnetos set Estatus=12 where IdViajeNeto=".$ViajesRechazados[$a][1].";";
					//echo "<br>".$SQL;
					$Result=$Link->consultar($SQL);
					$Link->cerrar();
				}
				
				else
					{
						//$viajeRechazarError[$e]=$ViajesRechazados[$a][1];
						$viajeRechazarError[$e][1]=$ViajesRechazados[$a][1];
						$viajeRechazarError[$e][7]=$ViajesRechazados[$a][7];
						$viajeRechazarError[$e][10]=$ViajesRechazados[$a][10];
						$TotalRechazadosAProcesarError++;
						$e++;
					}
				
			}

if($TotalInsertados>1)
		echo "Usted Ha Registrado ".$TotalInsertados." Viajes Completos en el Sistema . . . <br><br>";
if($TotalInsertados==1)
		echo "Usted Ha Registrado ".$TotalInsertados." Viaje Completo en el Sistema . . . <br><br>";
				
		if($TotalInsertados>=1)
		
		{		
		//Mostramos el Contenido de los Viajes Cargados en el Sistema
		echo'<table border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
			  <tr class="Concepto">
				<td align="left" colspan="9">&nbsp;Se han Registrado '.$TotalInsertados.' Viajes Sin Origen en el Sistema . . . </td>
			  </tr>
		      <tr>
				<td align="left" colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" colspan="9">&nbsp;</td>
			  </tr>
			  <tr align="center">
				<td>&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Ruta.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Distancia.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" />&nbsp;</td>
			  </tr>
			  <tr align="center">
				<td class="EncabezadoTabla">&nbsp;#&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Origen&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Destino&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Cami&oacute;n&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Material&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Tiempo&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Ruta&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Distancia&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Importe&nbsp;</td>
			  </tr>';
		$aa=1;
		for($a=0;$a<$TotalAProcesar;$a++)
		{
			$Link=SCA::getConexion();
			$SQL="SELECT origenes.Descripcion AS Origen,tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material,viajes.TiempoViaje,concat(rutas.Clave,'-',rutas.IdRuta) AS Ruta,viajes.Distancia,viajes.Importe FROM viajes,materiales,origenes,tiros,camiones,rutas WHERE materiales.IdMaterial = viajes.IdMaterial AND origenes.IdOrigen = viajes.IdOrigen AND tiros.IdTiro = viajes.IdTiro AND camiones.IdCamion = viajes.IdCamion AND viajes.IdRuta = rutas.IdRuta AND viajes.IdViajeNeto = ".$Viajes[$a][1]." AND viajes.IdTiro=".$Viajes[$a][4]." AND viajes.IdOrigen=".$Viajes[$a][7]." ORDER BY viajes.FechaLlegada,viajes.HoraLlegada;";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();

			while($Row=mysql_fetch_array($Result))
			{
				echo'<tr class="Item1">
						<td>&nbsp;'.$aa.'&nbsp;</td>
						<td>&nbsp;'.$Row["Origen"].'&nbsp;</td>
						<td>&nbsp;'.$Row["Tiro"].'&nbsp;</td>
						<td>&nbsp;'.$Row["Economico"].'&nbsp;</td>
						<td>&nbsp;'.$Row["Material"].'&nbsp;</td>
						<td align="center">&nbsp;<img src="../../Imgs/16-Question.gif" width="16" height="16" />&nbsp;</td>
						<td align="right">&nbsp;'.$Row["Ruta"].'&nbsp;</td>
						<td align="right">&nbsp;'.$Row["Distancia"].' Km&nbsp;</td>
						<td align="right">&nbsp;'.$Row["Importe"].'&nbsp;</td>
					  </tr>';

					  $TotalVI=$TotalVI+$Row["Importe"];
			}
		$aa++;
		}

		$TotalVIF=number_format($TotalVI,2,'.',',');

		echo'<tr class="Item2">
				<td align="right" colspan="8">Total:&nbsp;</td>
				<td align="right">'.$TotalVIF.'&nbsp;</td>
			</tr>';

		echo"</table>";
		}
		
		
		if($TotalAProcesarError>1)
		echo "<br>Hubo un error al Procesar ".$TotalAProcesarError." Viajes  en el Sistema, verifique que exista una ruta Activa para estos Viajes . . . <br><br>";
		else
		
		if($TotalAProcesarError==1)
		echo "<br>Hubo un error al Procesar el Viaje  en el Sistema, verifique que exista una ruta Activa para este Viaje . . . <br><br>";
			
		
		if($TotalAProcesarError>=1)
		
		{		
		//Mostramos el Contenido de los Viajes Cargados en el Sistema
		echo'<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
			  <tr align="center">
				<td>&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;</td>

			  </tr>
			  <tr align="center">
				<td class="EncabezadoTabla">&nbsp;#&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Origen&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Destino&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Cami&oacute;n&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Material&nbsp;</td>

			  </tr>';
		$aa=1;
		for($a=0;$a<$TotalAProcesarError;$a++)
		{
			$Link=SCA::getConexion();
			$SQL="SELECT  tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material FROM viajesnetos,materiales,tiros, camiones WHERE materiales.IdMaterial = viajesnetos.IdMaterial  AND tiros.IdTiro = viajesnetos.IdTiro AND camiones.IdCamion = viajesnetos.IdCamion  AND viajesnetos.IdViajeNeto = ".$viajeProcesarError[$a][1]." AND viajesnetos.IdTiro=".$viajeProcesarError[$a][4]." AND viajesnetos.IdOrigen=".$viajeProcesarError[$a][7]." ORDER BY viajesnetos.FechaLlegada,viajesnetos.HoraLlegada";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();
			
			while($Row=mysql_fetch_array($Result))
			{
				echo'<tr>
						<td class="Item1">&nbsp;'.$aa.'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Origen"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Tiro"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Economico"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Material"].'&nbsp;</td>

					  </tr>';
			}
		$aa++;}	
		
		echo"</table>";	
		
		}	
		
		
		if($TotalRechazados>1)
		echo "Usted Ha Rechazado ".$TotalRechazados." Viajes Completos en el Sistema . . . <br><br>";
			
		if($TotalRechazados==1)
		echo "Usted Ha Rechazado ".$TotalRechazados." Viaje Completo en el Sistema . . . <br><br>";
			
		if($TotalRechazados>=1)
		
		{		
		//Mostramos el Contenido de los Viajes Cargados en el Sistema
		echo'<table border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
			  <tr class="Concepto">
				<td align="left" colspan="9">&nbsp;Se han Registrado '.$TotalInsertados.' Viajes Sin Origen en el Sistema . . . </td>
			  </tr>
		      <tr>
				<td align="left" colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
				<td align="left" colspan="9">&nbsp;</td>
			  </tr>
			  <tr align="center">
				<td>&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Clock.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Ruta.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Distancia.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" />&nbsp;</td>
			  </tr>
			  <tr align="center">
				<td class="EncabezadoTabla">&nbsp;#&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Origen&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Destino&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Cami&oacute;n&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Material&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Tiempo&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Ruta&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Distancia&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Importe&nbsp;</td>
			  </tr>';
		$aa=1;
		for($a=0;$a<$TotalARechazar;$a++)
		{
			$Link=SCA::getConexion();
			$SQL="SELECT origenes.Descripcion AS Origen,tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material,viajesrechazados.TiempoViaje,concat(rutas.Clave,'-',rutas.IdRuta) AS Ruta,viajesrechazados.Distancia,viajesrechazados.Importe FROM viajesrechazados,materiales,origenes,tiros,camiones,rutas WHERE materiales.IdMaterial = viajesrechazados.IdMaterial AND origenes.IdOrigen = viajesrechazados.IdOrigen AND tiros.IdTiro = viajesrechazados.IdTiro AND camiones.IdCamion = viajesrechazados.IdCamion AND viajesrechazados.IdRuta = rutas.IdRuta AND viajesrechazados.IdViajeNeto = ".$ViajesRechazados[$a][1]." AND viajesrechazados.IdTiro=".$ViajesRechazados[$a][10]." AND viajesrechazados.IdOrigen=".$ViajesRechazados[$a][7]." ORDER BY viajesrechazados.FechaLlegada,viajesrechazados.HoraLlegada;";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();

			while($Row=mysql_fetch_array($Result))
			{
				echo'<tr class="Item1">
						<td>&nbsp;'.$aa.'&nbsp;</td>
						<td>&nbsp;'.$Row["Origen"].'&nbsp;</td>
						<td>&nbsp;'.$Row["Tiro"].'&nbsp;</td>
						<td>&nbsp;'.$Row["Economico"].'&nbsp;</td>
						<td>&nbsp;'.$Row["Material"].'&nbsp;</td>
						<td align="center">&nbsp;<img src="../../Imgs/16-Question.gif" width="16" height="16" />&nbsp;</td>
						<td align="right">&nbsp;'.$Row["Ruta"].'&nbsp;</td>
						<td align="right">&nbsp;'.$Row["Distancia"].' Km&nbsp;</td>
						<td align="right">&nbsp;'.$Row["Importe"].'&nbsp;</td>
					  </tr>';

					  $TotalVI=$TotalVI+$Row["Importe"];
			}
			
			$aa++;
		}

		$TotalVIF=number_format($TotalVI,2,'.',',');

		echo'<tr class="Item2">
				<td align="right" colspan="8">Total:&nbsp;</td>
				<td align="right">'.$TotalVIF.'&nbsp;</td>
			</tr>';

		echo"</table>";
		}
		
		if($TotalRechazadosAProcesarError>1)
		echo "<br>Hubo un error al Rechazar ".$TotalRechazadosAProcesarError." Viajes  en el Sistema, verifique que exista una ruta Activa para estos Viajes . . . <br><br>";
		else
		if($TotalRechazadosAProcesarError==1)
		echo "<br>Hubo un error al Rechazar el Viaje  en el Sistema, verifique que exista una ruta Activa para este Viaje . . . <br><br>";
			
		
		if($TotalRechazadosAProcesarError>=1)
		
		{		
		//Mostramos el Contenido de los Viajes Cargados en el Sistema
		echo'<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
			  <tr align="center">
				<td>&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Bus.gif" width="16" height="16" />&nbsp;</td>
				<td>&nbsp;<img src="../../Imgs/16-Materiales.gif" width="16" height="16" />&nbsp;</td>

			  </tr>
			  <tr align="center">
				<td class="EncabezadoTabla">&nbsp;#&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Origen&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Destino&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Cami&oacute;n&nbsp;</td>
				<td class="EncabezadoTabla">&nbsp;Material&nbsp;</td>

			  </tr>';
		$aa=1;
		for($a=0;$a<$TotalRechazadosAProcesarError;$a++)
		{
			$Link=SCA::getConexion();
			$SQL="SELECT origenes.Descripcion AS Origen,tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material FROM viajesnetos,materiales,origenes,tiros, camiones WHERE materiales.IdMaterial = viajesnetos.IdMaterial AND origenes.IdOrigen = viajesnetos.IdOrigen AND tiros.IdTiro = viajesnetos.IdTiro AND camiones.IdCamion = viajesnetos.IdCamion  AND viajesnetos.IdViajeNeto = ".$viajeRechazarError[$a]." ORDER BY viajesnetos.FechaLlegada,viajesnetos.HoraLlegada";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();
			
			while($Row=mysql_fetch_array($Result))
			{
				echo'<tr>
						<td class="Item1">&nbsp;'.$aa.'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Origen"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Tiro"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Economico"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Material"].'&nbsp;</td>

					  </tr>';
			}
		$aa++;}	
		
		echo"</table>";	
		
		}	
		
?>
</body>
</html>
