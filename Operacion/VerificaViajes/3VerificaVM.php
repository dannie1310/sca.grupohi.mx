<?php
	session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
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

		
		//Recibimos las Variables de los Viajes Validos
		$b=0;
		for($a=0;$a<$TotalV;$a++)
		{
			//echo "<br>Viaje ".$a." : ".$_POST['Viaje'.$a];
			
			if($_POST['Viaje'.$a]<>"")
			{
				$origen[$b]=$_POST['Origen'.$a];
				$tiro[$b]=$_POST['Tiro'.$a];
				$Viajes[$b][1]=$_POST['Viaje'.$a]; //Id del Viaje
				$Viajes[$b][2]=$_POST['Tiempo'.$a]; //Tiempo Viaje
				$Viajes[$b][3]=$_POST['Ruta'.$a]; //Id de Ruta
				$Viajes[$b][4]=$_POST['Distancia'.$a]; //Distancia en KM
				$Viajes[$b][5]=$_POST['Importe'.$a]; //Importe del Viaje
				
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



				
				$b=$b+1;
			}
		}
		
		//Recibimos las Variables de los Viajes Rechazados (No Validos por Cronometria o no Aceptados)
		$c=0;
		for($a=0;$a<$TotalV;$a++)
		{
			if($_POST['ViajeRechazado'.$a]<>"")
			{
				$origen[$b]=$_POST['Origen'.$a];
				$tiro[$b]=$_POST['Tiro'.$a];
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
		$TotalRechazadosAProcesar=count($ViajesRechazados);
		
		//echo "<br><br>Total: ".$TotalV;
		//echo "<br>Total a Procesar: ".$TotalAProcesar;
		//echo "<br>Total a Rechazar: ".$TotalRechazadosAProcesar."<br>";

		$e=0;
		for($a=0;$a<$TotalAProcesar;$a++)
		{
			//Insertamos los Datos de los Viajes Validos en la tabla

			$Hoy=date("Y-m-d");
			$Hora=date("H:i:s",time());
			$Creo=$_SESSION['Descripcion']."*".$Hoy."*".$Hora;

			//Nos Traemos Los Datos Complemtentarios de Viaje Neto
			$Link=SCA::getConexion();
			$SQL="SELECT IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro, FechaLlegada, HoraLlegada, IdMaterial FROM viajesnetos WHERE IdViajeNeto=".$Viajes[$a][1].";";
			//echo '<br><br>'.$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();

			while($Row=mysql_fetch_array($Result))
			{
				$Viajes[$a][6]=$Row["IdCamion"];
				$Viajes[$a][7]=$Row["IdOrigen"];
				$Viajes[$a][8]=$Row["FechaSalida"];
				$Viajes[$a][9]=$Row["HoraSalida"];
				$Viajes[$a][10]=$Row["IdTiro"];
				$Viajes[$a][11]=$Row["FechaLlegada"];
				$Viajes[$a][12]=$Row["HoraLlegada"];
				$Viajes[$a][13]=$Row["IdMaterial"];
				
				
			}
$FactorAbundamiento=regresa_factor($Viajes[$a][13]);
//if($FactorAbundamiento==0)
//$FactorAbundamiento='';
			$Link2=SCA::getConexion();
			
			$SQL="insert into viajes(HorasEfectivas,IdMaquinaria,IdViajeNeto,FechaCarga,HoraCarga,IdProyecto,Creo,TiempoViaje,IdRuta,Distancia,VolumenPrimerKM,VolumenKMSubsecuentes,VolumenKMAdicionales,Volumen,ImportePrimerKM,ImporteKMSubsecuentes,ImporteKMAdicionales,Importe,IdCamion,CubicacionCamion,IdOrigen,FechaSalida,HoraSalida,IdTiro,FechaLlegada,HoraLlegada,IdMaterial,Estatus,FactorAbundamiento) values(".$Viajes[$a][28].",".$Viajes[$a][27].",".$Viajes[$a][1].",'".$Hoy."','".$Hora."',".$_SESSION['Proyecto'].",'".$Creo."',".$Viajes[$a][2].",".$Viajes[$a][3].",".$Viajes[$a][4].",'".$Viajes[$a][17]."','".$Viajes[$a][18]."','".$Viajes[$a][19]."',".$Viajes[$a][20].",".$Viajes[$a][14].",".$Viajes[$a][15].",".$Viajes[$a][16].",'".$Viajes[$a][5]."',".$Viajes[$a][6].",".$Viajes[$a][21].",".$Viajes[$a][7].",'".$Viajes[$a][8]."','".$Viajes[$a][9]."',".$Viajes[$a][10].",'".$Viajes[$a][11]."','".$Viajes[$a][12]."',".$Viajes[$a][13].",20,".$FactorAbundamiento.");";
		//	echo "<br>".$SQL;
			$Result=$Link2->consultar($SQL);
			
			
			###############################################
			
			$Insertado=0;
			
				$Insertado=$Link2->affected();	
				//echo '<br>Insert: '.$Insertado;
				if($Insertado>0)
				$TotalInsertados=$TotalInsertados+$Insertado;
				$Link2->cerrar();
				
				//Actualizamos el estado de los Insertados
				if($Insertado==1)
				{
					//Actualizamos el Estatus de los Viajes Netos Procesados
					$Link=SCA::getConexion();
					$SQL="update viajesnetos set Estatus=21 where IdViajeNeto=".$Viajes[$a][1].";";
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
			
			###############################################
			
			
			
		}
		$e=0;
		//Registramos los Viajes Rechazados
		for($a=0;$a<$TotalRechazadosAProcesar;$a++)
		{
			//Insertamos los Datos de los Viajes Validos en la tabla

			$Hoy=date("Y-m-d");
			$Hora=date("H:i:s",time());
			$Creo=$_SESSION['Descripcion']."*".$Hoy."*".$Hora;

			//Nos Traemos Los Datos Complemtentarios de Viaje Neto
			$Link=SCA::getConexion();
			$SQL="SELECT IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro, FechaLlegada, HoraLlegada, IdMaterial FROM viajesnetos WHERE IdViajeNeto=".$ViajesRechazados[$a][1].";";
			$Result=$Link->consultar($SQL);
			$Link->cerrar();

			while($Row=mysql_fetch_array($Result))
			{
				$ViajesRechazados[$a][6]=$Row["IdCamion"];
				$ViajesRechazados[$a][7]=$Row["IdOrigen"];
				$ViajesRechazados[$a][8]=$Row["FechaSalida"];
				$ViajesRechazados[$a][9]=$Row["HoraSalida"];
				$ViajesRechazados[$a][10]=$Row["IdTiro"];
				$ViajesRechazados[$a][11]=$Row["FechaLlegada"];
				$ViajesRechazados[$a][12]=$Row["HoraLlegada"];
				$ViajesRechazados[$a][13]=$Row["IdMaterial"];
				
				
			}
$FactorAbundamiento=regresa_factor($ViajesRechazados[$a][13]);
			$Link=SCA::getConexion();
			$SQL="insert into viajesrechazados(HorasEfectivas,IdMaquinaria,FactorAbundamiento,IdViajeNeto,FechaRechazo,HoraRechazo,IdProyecto,Creo,TiempoViaje,IdRuta,Distancia,VolumenPrimerKM,VolumenKMSubsecuentes,VolumenKMAdicionales,Volumen,ImportePrimerKM,ImporteKMSubsecuentes,ImporteKMAdicionales,Importe,IdCamion,CubicacionCamion,IdOrigen,FechaSalida,HoraSalida,IdTiro,FechaLlegada,HoraLlegada,IdMaterial,Estatus) values(".$ViajesRechazados[$a][28].",".$ViajesRechazados[$a][27].",".$FactorAbundamiento.",".$ViajesRechazados[$a][1].",'".$Hoy."','".$Hora."',".$_SESSION['Proyecto'].",'".$Creo."',".$ViajesRechazados[$a][2].",'".$ViajesRechazados[$a][3]."','".$ViajesRechazados[$a][4]."',".$ViajesRechazados[$a][17].",".$ViajesRechazados[$a][18].",".$ViajesRechazados[$a][19].",".$ViajesRechazados[$a][20].",'".$ViajesRechazados[$a][14]."','".$ViajesRechazados[$a][15]."','".$ViajesRechazados[$a][16]."','".$ViajesRechazados[$a][5]."',".$ViajesRechazados[$a][6].",".$ViajesRechazados[$a][21].",".$ViajesRechazados[$a][7].",'".$ViajesRechazados[$a][8]."','".$ViajesRechazados[$a][9]."',".$ViajesRechazados[$a][10].",'".$ViajesRechazados[$a][11]."','".$ViajesRechazados[$a][12]."',".$ViajesRechazados[$a][13].",20);";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			
			###############################################################
			$Insertado=$Link->affected();
				if($Insertado>0)
				$TotalRechazados=$TotalRechazados+$Insertado;
				$Link->cerrar();
				//echo $Insertado;
				//Actualizamos el Estatus de los Viajes Netos Procesados
				if($Insertado==1)
				{
					$Link=SCA::getConexion();
					$SQL="update viajesnetos set Estatus=22 where IdViajeNeto=".$ViajesRechazados[$a][1].";";
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

			###############################################################

			
		}
		
								
				
		if($TotalInsertados>1)
			echo "Usted Ha Registrado ".$TotalInsertados." Viajes Completos en el Sistema . . . <br><br>";
		if($TotalInsertados==1)
			echo "Usted Ha Registrado ".$TotalInsertados." Viaje Completo en el Sistema . . . <br><br>";
				
		if($TotalInsertados>=1)
				{
				//Mostramos el Contenido de los Viajes Cargados en el Sistema
				echo'<table border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
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
				
				for($a=0;$a<$TotalAProcesar;$a++)
				{
					$Link=SCA::getConexion();
					$SQL="SELECT origenes.Descripcion AS Origen,tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material,viajes.TiempoViaje,concat(rutas.Clave,'-',rutas.IdRuta) AS Ruta,viajes.Distancia,viajes.Importe FROM viajes,materiales,origenes,tiros,camiones,rutas WHERE materiales.IdMaterial = viajes.IdMaterial AND origenes.IdOrigen = viajes.IdOrigen AND tiros.IdTiro = viajes.IdTiro AND camiones.IdCamion = viajes.IdCamion AND viajes.IdRuta = rutas.IdRuta AND viajes.IdViajeNeto = ".$Viajes[$a][1]." AND viajes.IdTiro=".$Viajes[$a][10]." AND viajes.IdOrigen=".$Viajes[$a][7]." ORDER BY viajes.FechaLlegada,viajes.HoraLlegada";
					//echo "<br>".$SQL;
					$Result=$Link->consultar($SQL);
					$Link->cerrar();
					
					while($Row=mysql_fetch_array($Result))
					{
						echo'<tr>
								<td class="Item1">&nbsp;'.$a.'&nbsp;</td>
								<td class="Item1">&nbsp;'.$Row["Origen"].'&nbsp;</td>
								<td class="Item1">&nbsp;'.$Row["Tiro"].'&nbsp;</td>
								<td class="Item1">&nbsp;'.$Row["Economico"].'&nbsp;</td>
								<td class="Item1">&nbsp;'.$Row["Material"].'&nbsp;</td>
								<td align="right" class="Item1">&nbsp;'.$Row["TiempoViaje"].' Minutos&nbsp;</td>
								<td align="right" class="Item1">&nbsp;'.$Row["Ruta"].'&nbsp;</td>
								<td align="right" class="Item1">&nbsp;'.$Row["Distancia"].' Km&nbsp;</td>
								<td align="right" class="Item1">&nbsp;'.$Row["Importe"].'&nbsp;</td>
							  </tr>';
					}
				}	
				
				echo"</table>";		
		}
		
		
		
		if($TotalAProcesarError>1)
		echo "<br>Hubo un error al Procesar ".$TotalAProcesarError." Viajes  en el Sistema, verifique que exista una ruta Activa para estos Viajes y que el Material tenga registrado el Factor de Abundamiento. . . <br><br>";
		else
		
		if($TotalAProcesarError==1)
		echo "<br>Hubo un error al Procesar el Viaje  en el Sistema, verifique que exista una ruta Activa para este Viaje y que el Material tenga registrado el Factor de Abundamiento . . . <br><br>";
			
		
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
		
		for($a=0;$a<$TotalAProcesarError;$a++)
		{
			$Link=SCA::getConexion();
			$SQL="SELECT origenes.Descripcion AS Origen,tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material FROM viajesnetos,materiales,origenes,tiros, camiones WHERE materiales.IdMaterial = viajesnetos.IdMaterial AND origenes.IdOrigen = viajesnetos.IdOrigen AND tiros.IdTiro = viajesnetos.IdTiro AND camiones.IdCamion = viajesnetos.IdCamion  AND viajesnetos.IdViajeNeto = ".$viajeProcesarError[$a][1]." AND viajesnetos.IdTiro=".$viajeProcesarError[$a][10]." AND viajesnetos.IdOrigen=".$viajeProcesarError[$a][7]." ORDER BY viajesnetos.FechaLlegada,viajesnetos.HoraLlegada";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();
			
			while($Row=mysql_fetch_array($Result))
			{
				echo'<tr>
						<td class="Item1">&nbsp;'.$a.'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Origen"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Tiro"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Economico"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Material"].'&nbsp;</td>

					  </tr>';
			}
		}	
		
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

		for($a=0;$a<$TotalRechazados;$a++)
		{
			$Link=SCA::getConexion();
			$SQL="SELECT origenes.Descripcion AS Origen,tiros.Descripcion AS Tiro,camiones.Economico,materiales.Descripcion as Material,viajesrechazados.TiempoViaje,concat(rutas.Clave,'-',rutas.IdRuta) AS Ruta,viajesrechazados.Distancia,viajesrechazados.Importe FROM viajesrechazados,materiales,origenes,tiros,camiones,rutas WHERE materiales.IdMaterial = viajesrechazados.IdMaterial AND origenes.IdOrigen = viajesrechazados.IdOrigen AND tiros.IdTiro = viajesrechazados.IdTiro AND camiones.IdCamion = viajesrechazados.IdCamion AND viajesrechazados.IdRuta = rutas.IdRuta AND viajesrechazados.IdViajeNeto = ".$ViajesRechazados[$a][1]." AND viajesrechazados.IdTiro=".$ViajesRechazados[$a][10]." AND viajesrechazados.IdOrigen=".$ViajesRechazados[$a][7]." ORDER BY viajesrechazados.FechaLlegada,viajesrechazados.HoraLlegada;";
			//echo "<br>".$SQL;
			$Result=$Link->consultar($SQL);
			$Link->cerrar();

			while($Row=mysql_fetch_array($Result))
			{
				echo'<tr class="Item1">
						<td>&nbsp;'.$a.'&nbsp;</td>
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
						<td class="Item1">&nbsp;'.$a.'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Origen"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Tiro"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Economico"].'&nbsp;</td>
						<td class="Item1">&nbsp;'.$Row["Material"].'&nbsp;</td>

					  </tr>';
			}
		}	
		
		echo"</table>";	
		
		}	
		
		//echo "Usted Ha Rechazado ".$TotalRechazados." Viajes Manuales en el Sistema . . . <br><br>";
?>
</body>
</html>
