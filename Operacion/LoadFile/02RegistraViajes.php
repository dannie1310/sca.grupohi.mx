<?php
	session_start();
	
	$creo = $_SESSION['Descripcion']."*".date("Y-m-d")."*".date("H:i:s",time());
																	
  include("../../Clases/Conexiones/Conexion.php");
	include("../../Clases/Funciones/FuncionesArmaViajes.php");
	include("../../inc/php/conexiones/SCA.php");
	$SCA = SCA::getConexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>SCA</title>

<style type="text/css">
<!--
body {
	font-family: Calibri, Trebuchet MS;
	font-size: 62.5%;
	color: #006699;
	margin-left: 0px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}

table.tabla{ font-size:1.2em; border-collapse:collapse; width:550px; margin:0 auto}
table.tabla td{ padding:5px;}
caption, span.clase{ color:#666;}
caption.filter, span.clase{ min-height:16px;  margin:0 0 20px 0; padding: 0 20px; font: normal normal bold 1em normal Verdana, Geneva, sans-serif; background:  white url(../../Imagenes/info.gif)   no-repeat 0 0 ; text-align:left}
span.clase{ background: white url(../../Imagenes/archivo.gif)  no-repeat 0 0 ; font-size:1.2em; font-weight:normal;}
tr.total td,tr.total th, tr td.diferencia{  border:1px solid #666; font-weight:bold; background-color:#EEE}
img.boton{ cursor:pointer; vertical-align:text-bottom;}
tr.total td.diferencia{ background-color:#CCC}
table.tabla thead th, table.tabla tbody th{ background-color:#CCC; color:#666; border:1px solid #666;}
tbody td{ text-align:right; color:#666 ; border:1px solid #666; }
tbody tr th { width:100px;}
-->
</style>
</head>

<body>
<?php

  //Obtenemos los datos del archivo a procesar 
  	$nombre_archivo				=	$_FILES["archivo"]["name"];									//Obtenemos el Nombre del Archivo
	$nombre_temp_archivo		=	$_FILES["archivo"]["tmp_name"];							//Obtenemos el Nombre Temporal del Archivo
	$tipo_archivo				=	$_FILES["archivo"]["type"];									//Obtenemos el Tipo de Archivo
	$tamano_archivo				=	($_FILES["archivo"]["size"]/1024);					//Obtenemos el Tamaño del Archivo
	$datos_archivo				=	explode(".",$nombre_archivo);								//Obtenemos la Extension
	$extension_archivo			=	count($datos_archivo)-1;										//Guardamos la Extensión del Archivo en una Variable
	$ruta						= 	"../../SourcesFiles/";
	$timestamp					=	date('d-m-Y_H-i-s');
	$nuevo_nombre_archivo		= 	$timestamp."_".$nombre_archivo;
	
  if($datos_archivo[$extension_archivo]=="TMD")
	{
		
		if(!copy($_FILES["archivo"]["tmp_name"],$ruta.$nuevo_nombre_archivo))
		{
		  echo "<br><span class='clase'>No fue posible registrar el archivo en el sistema . . .</span><br>";
			exit();
		}
		else
		{
			
			$abrir_archivo 								= 	fopen($ruta.$nuevo_nombre_archivo,'r');
			$contenido_archivo 						= 	fread($abrir_archivo, filesize($ruta.$nuevo_nombre_archivo));
			$contenido_archivo_explotado	=		explode("\n", $contenido_archivo);
			$total_lineas_archivo					=		count($contenido_archivo_explotado);
			echo "<span class='clase'>El Archivo [<strong>".$nombre_archivo."</strong>] con [<strong>".$total_lineas_archivo."</strong>] líneas ha sido procesado con éxito...</span><br /><br />";
			
			
			
			//Obtenemos la Huella en MD5 del Archivo a Subir
				$huelladigitalarchivotemporal = md5_file($_FILES["archivo"]["tmp_name"]);
			
			//Insertamos los datos del Archivo a procesar
			$sql_datos_archivo = "INSERT INTO archivoscargados (FechaCarga, HoraCarga, IdProyecto, NombreOriginal, NombreArchivo, Tamano, HuellaDigital, CargadoPor) values('".date("Y-m-d")."', '".date("H:i:s",time())."', 1, '".$nombre_archivo."', '".$nuevo_nombre_archivo."', ".$tamano_archivo.", '".$huelladigitalarchivotemporal."', '".$creo."');";
			//echo $sql_datos_archivo;
			$result_datos_archivo = $SCA->consultar($sql_datos_archivo);	
			
			
			$id_ultimo_archivo =  $SCA->retId();
			$contador_registros = 0;
			
			for($a=0; $a<$total_lineas_archivo; $a++)
			{
				if(substr(trim($contenido_archivo_explotado[$a]), 0,  1) != "T")
				{
				  $registros[$contador_registros] = trim($contenido_archivo_explotado[$a]);
					$contador_registros = $contador_registros + 1;
				}	
			}
			
			//Clasificamos los Viajes con Origen
			/*
			  Estructura del arreglo de Viajes Con Origen
			  [1]	=>	Fecha Llegada
				[2]	=>	Hora Llegada
				[3]	=>	Camion
				[4]	=>	Origen
				[5]	=>	Fecha Salida
				[6]	=>	Hora Salida
				[7]	=>	Material
				[8]	=>	Destino
			*/
			
			$contador_vco = 0;
			
			for($a=0; $a<$contador_registros; $a++)
			{
				
				if((substr($registros[$a], 0, 1)  == "H") AND (substr($registros[$a], 17, 2) == "34"))
				{
					$vco[1][$contador_vco] = substr($registros[$a], 2, 4)."-".substr($registros[$a], 6, 2)."-".substr($registros[$a], 8, 2);						//Fecha Llegada
					$vco[2][$contador_vco] = substr($registros[$a], 10, 2).":".substr($registros[$a], 12, 2).":".substr($registros[$a], 14 	, 2);						//Hora Llegada
					$vco[3][$contador_vco] = trim(substr($registros[$a], 20, 12));		//Camion
					
					if((substr($registros[$a+1], 0, 1)  == "H") AND (substr($registros[$a+1], 17, 2) == "01"))
					{
					  $vco[4][$contador_vco] = trim(substr($registros[$a+1], 20, 12));		//Origen
						$vco[5][$contador_vco] = substr($registros[$a+1], 2, 4)."-".substr($registros[$a+1], 6, 2)."-".substr($registros[$a+1], 8, 2);		//Fecha Salida
						$vco[6][$contador_vco] = substr($registros[$a+1], 10, 2).":".substr($registros[$a+1], 12, 2).":".substr($registros[$a+1], 14 	, 2);		//Hora Salida
					}
					
					if((substr($registros[$a + 2], 0, 1)  != "H") AND (substr($registros[$a+2], 15, 2) == "31"))
					{
					  $vco[7][$contador_vco] = trim(substr($registros[$a + 2], 18, 12));		//Material
					}
					
					if((substr($registros[0], 0, 1)  == "H") AND (substr($registros[0], 17, 2) == "00"))
					{
					  $vco[8][$contador_vco] = trim(substr($registros[0], 20, 12));		//Destino
					}					
					$contador_vco = $contador_vco + 1;
				}
			}
			
			/*
			  Clasificación de los Viajes Sin Origen
				
				Estructura del arreglo de Viajes Sin Origen
			  [1]	=>	Fecha Llegada
				[2]	=>	Hora Llegada
				[3]	=>	Camion
				[4]	=>	Origen
				[5]	=>	Fecha Salida
				[6]	=>	Hora Salida
				[7]	=>	Material
				[8]	=>	Destino
			*/
			
			$contador_vso = 0;
			
			for($a=0; $a<$contador_registros; $a++)
			{
			  if((substr($registros[$a], 0, 1)  != "H") AND (substr($registros[$a], 15, 2) == "34"))
				{
				  $vso[1][$contador_vso] = substr($registros[$a], 0, 4)."-".substr($registros[$a], 4, 2)."-".substr($registros[$a], 6, 2);						//Fecha Llegada
					$vso[2][$contador_vso] = substr($registros[$a], 8, 2).":".substr($registros[$a], 10, 2).":".substr($registros[$a], 12, 2);						//Hora Llegada
					$vso[3][$contador_vso] = trim(substr($registros[$a], 18, 12));		//Camion
					
					if((substr($registros[$a + 1], 0, 1)  != "H") AND (substr($registros[$a+1], 15, 2) == "31"))
					{
						$vso[7][$contador_vso] = trim(substr($registros[$a + 1], 18, 12));		//Material
					}
					
					if((substr($registros[0], 0, 1)  == "H") AND (substr($registros[0], 17, 2) == "00"))
					{
						$vso[8][$contador_vso] = trim(substr($registros[0], 20, 12));		//Destino
					}
          $contador_vso = $contador_vso + 1;
				}
			}
			
			//Ingresamos los Viajes Con Origen
			$contador_vco_ingresados = 0;
			$contador_vco_ya_ingresados = 0;
			$contador_vco_validos = 0;
			$contador_vco_invalidos = 0;
			for($a=0; $a<$contador_vco; $a++)
			{
				$idcamion			= RegresaIdCamion($vco[3][$a]);			
				$idorigen			= RegresaIdOrigen($vco[4][$a]);
				$fechasalida		= $vco[5][$a];
				$horasalida			= $vco[6][$a];
				$idtiro				= RegresaIdTiro($vco[8][$a]);
				$fechallegada		= $vco[1][$a];
				$horallegada		= $vco[2][$a];
				$idmaterial			= RegresaIdMaterial($vco[7][$a]);
				
				if($idcamion>0&&$idorigen>0&&$idtiro>0&&$idmaterial>0)
				$contador_vco_validos++;
				else
				$contador_vco_invalidos++;
				
				if($idcamion>0&&$idorigen>0&&$idtiro>0&&$idmaterial>0)
				{
					 $sql_consulta = "select IdViajeNeto from viajesnetos where IdCamion=".$idcamion." AND IdOrigen=".$idorigen." AND FechaSalida='".$fechasalida."' AND HoraSalida='".$horasalida."' AND IdTiro=".$idtiro." AND FechaLlegada='".$fechallegada."' AND HoraLlegada='".$horallegada."' AND IdMaterial=".$idmaterial.";";
					$result_consulta = $SCA->consultar($sql_consulta);
					$existe = $SCA->affected();
					
					if($existe < 1)
					{
					  $sql_inserta = "Insert into viajesnetos(IdArchivoCargado, FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro, FechaLlegada, HoraLlegada, IdMaterial, creo, Estatus) values(".$id_ultimo_archivo.", '".date("Y-m-d")."', '".date("H:i:s",time())."', 1,".$idcamion.", ".$idorigen.", '".$fechasalida."', '".$horasalida."', ".$idtiro.", '".$fechallegada."', '".$horallegada."', ".$idmaterial.", '$creo',  0);";
						$result_inserta = $SCA->consultar($sql_inserta);
						
						if($SCA->affected() > 0)
						{
						  $contador_vco_ingresados = $contador_vco_ingresados + $SCA->affected();
						}
						else
						{
							echo "error <br />".$sql_inserta;	
						}
					}
					else
					{
						$contador_vco_ya_ingresados++;	
					}
				}
			}
			
			//Ingresamos los Viajes Sin Origen
			
			$contador_vso_ingresados = 0;
			$contador_vso_ya_ingresados=0;
			$contador_vso_validos = 0;
			$contador_vso_invalidos = 0;
			for($a=0; $a<$contador_vso; $a++)
			{
				$idcamion				= RegresaIdCamion($vso[3][$a]);
				$idtiro					= RegresaIdTiro($vso[8][$a]);
				$fechallegada		= $vso[1][$a];
				$horallegada		= $vso[2][$a];
				$idmaterial			= RegresaIdMaterial($vso[7][$a]);
				
				if($idcamion>0&&$idtiro>0&&$idmaterial>0)
				$contador_vso_validos++;
				else
				$contador_vso_invalidos++;
				if($idcamion>0&&$idtiro>0&&$idmaterial>0)
				{
				
					 $sql_consulta = "select IdViajeNeto from viajesnetos where IdCamion=".$idcamion." AND IdTiro=".$idtiro." AND FechaLlegada='".$fechallegada."' AND HoraLlegada='".$horallegada."' AND IdMaterial=".$idmaterial.";";
					$result_consulta = $SCA->consultar($sql_consulta);
					$existe = $SCA->affected();
						
					if($existe < 1)
					{
						 $sql_inserta = "Insert into viajesnetos(IdArchivoCargado, FechaCarga, HoraCarga, IdProyecto, IdCamion, IdTiro, FechaLlegada, HoraLlegada, IdMaterial, Estatus, creo) values(".$id_ultimo_archivo.", '".date("Y-m-d")."', '".Date("H:i:s",time())."', 1,".$idcamion.", ".$idtiro.", '".$fechallegada."', '".$horallegada."', ".$idmaterial.", 10, '$creo');";
						$result_inserta = $SCA->consultar($sql_inserta);
						
						if($SCA->affected() > 0)
						{
						  $contador_vso_ingresados = $contador_vso_ingresados + $SCA->affected();
						}
						else
						{
							echo "error 2<br />".$sql_inserta;	
						}
					}
					else
					{
						$contador_vso_ya_ingresados++;
					}
				}
			}
			
			
		}
	 $sql_inserta_detalle = "insert into archivoscargados_detalle_viajes values(".$id_ultimo_archivo.",1,1,".$contador_vco."),(".$id_ultimo_archivo.",1,2,".$contador_vco_invalidos."),(".$id_ultimo_archivo.",1,3,".$contador_vco_validos."),(".$id_ultimo_archivo.",1,4,".$contador_vco_ya_ingresados."),(".$id_ultimo_archivo.",1,5,".$contador_vco_ingresados."),(".$id_ultimo_archivo.",2,1,".$contador_vso."),(".$id_ultimo_archivo.",2,2,".$contador_vso_invalidos."),(".$id_ultimo_archivo.",2,3,".$contador_vso_validos."),(".$id_ultimo_archivo.",2,4,".$contador_vso_ya_ingresados."),(".$id_ultimo_archivo.",2,5,".$contador_vso_ingresados.")";
		$SCA->consultar($sql_inserta_detalle);

		echo '
<table class="tabla">
<caption class="filter">Detalle de Viajes Procesados</caption>
<thead>
  <tr>
    <td>&nbsp;</td>
	<th>Viajes Detectados</th>
	<th>Viajes Inválidos</th>
	<th>Viajes Válidos</th>
	<th>Viajes Registrados Previamente</th>
    <th>Viajes Registrados Actualmente</th>
	<th>Diferencia</th>
  </tr>
</thead>
<tbody>
  <tr>
    <th>Viajes con Origen</th>
	<td>'.$contador_vco.'</td>
	<td>'.$contador_vco_invalidos.'</td>
	<td>'.$contador_vco_validos.'</td>
	<td>'.$contador_vco_ya_ingresados.'</td>
    <td>'.$contador_vco_ingresados.'</td>
	<td class="diferencia">'.abs($contador_vco_validos-($contador_vco_ingresados+$contador_vco_ya_ingresados)).'</td>
  </tr>
  <tr>
    <th>Viajes sin Origen</th>
	<td>'.$contador_vso.'</td>
	<td>'.$contador_vso_invalidos.'</td>
	<td>'.$contador_vso_validos.'</td>
	<td>'.$contador_vso_ya_ingresados.'</td>
    <td>'.$contador_vso_ingresados.'</td>
	<td class="diferencia">'.abs($contador_vso_validos-($contador_vso_ya_ingresados+$contador_vso_ingresados)).'</td>
  </tr>
  <tr class="total">
    <th>Total</th>
	<td>'.($contador_vso+$contador_vco).'</td>
	<td>'.($contador_vso_invalidos + $contador_vco_invalidos).'</td>
	<td>'.($contador_vso_validos + $contador_vco_validos).'</td>
	<td>'.($contador_vso_ya_ingresados + $contador_vco_ya_ingresados).'</td>
    <td>'.($contador_vso_ingresados + $contador_vco_ingresados).'</td>
	<td class="diferencia">'.(abs($contador_vco_validos-($contador_vco_ya_ingresados+$contador_vco_ingresados)) + abs($contador_vso_validos-($contador_vso_ya_ingresados+$contador_vso_ingresados))).'</td>
  </tr>
  </tbody>
</table>';			
	}
	else
	{
		echo'
				 <form name="frm" method="post" action="Inicio.php">
			 		<table width="560" align="center" border="1" cellspacing="0" cellpadding="0" bordercolor="#FFFFFF">
			 			<tr>
							<td align="center" width="130" rowspan="6"><img src="../../Imgs/stop.gif" width="128" height="128" /></td>
							<td width="430">&nbsp;</td>
						</tr>
						<tr>
							<td align="center" class="Estilo1">No Se Puede Cargar el Archivo</td>
		        		</tr>
						<tr>
							<td align="center" class="Estilo2">&quot; '.$_FILES['archivo']['name'].' &quot;</td>
						</tr>
						<tr>
							<td align="center" class="Estilo1">Debido a que no es Un Archivo Valido Para el Sistema </td>
						</tr>
						<tr>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td align="center"><input type="submit" name="Submit" value="Volver a Intentar" /></td>
						</tr>
					</table>
				</form>';
	}
?>



</body>
</html>
