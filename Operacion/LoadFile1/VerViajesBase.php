<?php
	session_start();

	//include("../../Clases/Loading/CP.php");
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/FuncionesArmaViajes.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/LoadingPage.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Styles/LoadFile.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>

<style type="text/css">
<!--
.Estilo1 {
	font-size: 16px;
	font-weight: bold;
	color: #FF0000;
	font-style: italic;
}
.Estilo2 {
	font-size: 16px;
	font-weight: bold;
	font-style: italic;
	color: #006699;
}
-->
</style>
</head>

<body onkeydown="backspace();">
<?php

	//Obtenemos los datos del Archivo a Procesar

		$NombreArchivo=$_FILES["archivo"]["name"];					//Obtenemos el Nombre del Archivo
		$NombreTmpArchivo=$_FILES["archivo"]["tmp_name"];			//Obtenemos el Nombre Temporal del Archivo
		$TipoArchivo=$_FILES["archivo"]["type"];					//Obtenemos el Tipo de Archivo
		$TamanoArchivo=($_FILES["archivo"]["size"]/1024);			//Obtenemos el Tamaño del Archivo
		$DatosArchivo=explode(".",$_FILES["archivo"]["name"]);		//Obtenemos la Extension
		$Extension=count($DatosArchivo)-1;							//Guardamos la Extensión del Archivo en una Variable

	//Verificamos que la extension del Archivo sea Valida, si es Valida continuamos
	//si no es valida rechazamos la operación

		if($DatosArchivo[$Extension]="TMD")
		{
			//Copiamos el Archivo a Nuestra Ruta para Trabajar con el

				$Fecha=date("d-m-Y");
				$Ruta="../../SourcesFiles/";
				$NuevoNombreArchivo=$Fecha.".TMD";

			//Obtenemos la Huella en MD5 del Archivo a Subir
				$HuellaDigitalArchivoTemporal=md5_file($_FILES["archivo"]["tmp_name"]);

			//Vefificamos que no haya Ningun Archivo Ya registrado con esa Huella y con ese Nombre;
				$Link=SCA::getConexion();
				$SQL="Select * from archivoscargados where NombreOriginal='".$NombreArchivo."' and HuellaDigital='".$HuellaDigitalArchivoTemporal."';";
				$Result=$Link->consultar($SQL);
				$ExisteArchivo=mysql_num_rows($Result);
				

				//Si no hay lo procesamos
				if($ExisteArchivo<1)
				{
					echo "<br>Urra, no hay Archivo Previo Cargado";

					if(file_exists($Ruta.$NuevoNombreArchivo))
					{
						$out=1;
					}

					for($a=1;$a<51;$a++)
					{
						$NuevoNombreArchivo=$Fecha."_".$a.".TMD";
						if(file_exists($Ruta.$NuevoNombreArchivo))
						{
							$out=$out+$a;
						}
					}

					if($out>0)
					{
						$NuevoNombreArchivo=$Fecha."_".$out.".TMD";
					}
					else
					{
						$NuevoNombreArchivo=$Fecha.".TMD";
					}
					 
					if(!copy($_FILES["archivo"]["tmp_name"],$Ruta.$NombreArchivo))
					{
						//echo "<br>Ya Existe Un Archivo cargado en el Sistema con ese Nombre . . .<br>";
						exit();
					}
					else
					{
						echo "<br>El Archivo <strong>$NombreArchivo</strong> se Subio Correctamente....<br><br>";
						//Una ves que lo Hayamos Subido Guardamos los Datos del Mismo

							$HuellaDigitalArchivo=md5_file($Ruta.$NombreArchivo);		//Obtenemos su huella Digital en MD5

							//echo "<br>MD5 del Archivo en nuestra localidad ".$HuellaDigitalArchivo;

							
							$SQLF="insert into archivoscargados(FechaCarga,HoraCarga,IdProyecto,NombreOriginal,NombreArchivo,Tamaño,HuellaDigital,CargadoPor) values('".date("Y-m-d")."','".$hora=date("H:i:s",time())."',".$_SESSION['Proyecto'].",'".$NombreArchivo."','".$NombreArchivo."',".$TamanoArchivo.",'".$HuellaDigitalArchivo."','".$_SESSION['Descripcion']."');";
							//echo $SQLF;
							$ResultF=$Link->consultar($SQLF);
							$TotalArchivosCargados=$Link->affected();
							

							//Verificamos que el Archivo se ha cargado, ya que si no se carga
							//Tendremos que eliminar el Archivo Copiado

							if ($TotalArchivosCargados>0)
							{
							//Seguimios Trabajando con el Archivo

								//Abrimos el Archivo que se Acaba de Subir
								$AbrirArchivo = fopen($Ruta.$NombreArchivo,'r');

								//Guardamos Su Contenido en una Variable
								$ContenidoArchivo = fread($AbrirArchivo, filesize($Ruta.$NombreArchivo));

								//Explotamos el Archivo
								$ContenidoArchivoExplotado=explode("\n", $ContenidoArchivo);
								$TotalLineasArchivo=count($ContenidoArchivoExplotado);

								//echo "<br><br><br><li>Total de Lineas del Archivo: ".$TotalLineasArchivo;

							//Comezamos a Trabajar las Validaciones con el Archivo

								$TotalLineasValidas=0;
								for($a=0;$a<$TotalLineasArchivo;$a++)
								{

									//Validamos que sean Cabeceras
									if(substr(trim($ContenidoArchivoExplotado[$a]),0,1)=='H')
									{

										// Quitamos los Destinos Repetidos
										if(substr(trim($ContenidoArchivoExplotado[$a]),17,2)=='00')
										{
											//Quitamos los Repetidos despues de que se registro el primero
											$LineaActual=substr(trim($ContenidoArchivoExplotado[$a]),20,2);
											$LineaAnterior=substr(trim($LineasValidas[$TotalLineasValidas-1]),20,2);

											if($LineaActual<>$LineaAnterior)
											{
												$LineasValidas[$TotalLineasValidas]=$ContenidoArchivoExplotado[$a];
												//echo "<br>Linea Valida: ".$LineasValidas[$TotalLineasValidas];
												$TotalLineasValidas=$TotalLineasValidas+1;
											}
										}
										// Quitamos los Camiones Repetidos
										else if(substr(trim($ContenidoArchivoExplotado[$a]),17,2)=='34')
										{
											//Quitamos los Repetidos despues de que se registro el primero
											$LineaActual=substr(trim($ContenidoArchivoExplotado[$a]),20,11);
											$LineaAnterior=substr(trim($LineasValidas[$TotalLineasValidas-1]),15,2);

											if($LineaActual<>$LineaAnterior)
											{
												$LineasValidas[$TotalLineasValidas]=$ContenidoArchivoExplotado[$a];
												//echo "<br>Linea Valida: ".$LineasValidas[$TotalLineasValidas];
												$TotalLineasValidas=$TotalLineasValidas+1;
											}
										}
										else if(substr(trim($ContenidoArchivoExplotado[$a]),17,2)=='01')	// Quitamos los origenes Repetidos
										{
											//Quitamos los Repetidos despues de que se registro el primero
											$LineaActual=substr(trim($ContenidoArchivoExplotado[$a]),20,2);
											$LineaAnterior=substr(trim($LineasValidas[$TotalLineasValidas-1]),20,2);

											if($LineaActual<>$LineaAnterior)
											{
												$LineasValidas[$TotalLineasValidas]=$ContenidoArchivoExplotado[$a];
												//echo "<br>Linea Valida: ".$LineasValidas[$TotalLineasValidas];
												$TotalLineasValidas=$TotalLineasValidas+1;
											}
										}
									}
									//Validación Extra de los Camiones que no traen destino
									else if	(substr(trim($ContenidoArchivoExplotado[$a]),15,2)=='34')
									{
										//Quitamos los Repetidos despues de que se registro el primero
										$LineaActual=substr(trim($ContenidoArchivoExplotado[$a]),15,2);
										$LineaAnterior=substr(trim($LineasValidas[$TotalLineasValidas-1]),15,2);

										if($LineaActual<>$LineaAnterior)
										{
											$LineasValidas[$TotalLineasValidas]=$ContenidoArchivoExplotado[$a];
											//echo "<br>Linea Valida: ".$LineasValidas[$TotalLineasValidas];
											$TotalLineasValidas=$TotalLineasValidas+1;
										}
									}
									//Validamos que sean Tipos de Materiales
									else if	(substr(trim($ContenidoArchivoExplotado[$a]),15,2)=='31')
									{
										//Quitamos los Repetidos despues de que se registro el primero
										$LineaActual=substr(trim($ContenidoArchivoExplotado[$a]),15,2);
										$LineaAnterior=substr(trim($LineasValidas[$TotalLineasValidas-1]),15,2);

										if($LineaActual<>$LineaAnterior)
										{
											$LineasValidas[$TotalLineasValidas]=$ContenidoArchivoExplotado[$a];
											//echo "<br>Linea Valida: ".$LineasValidas[$TotalLineasValidas];
											$TotalLineasValidas=$TotalLineasValidas+1;
										}
									}
								}

								//Mostramos el Total de las Lineas validas
									//echo "<br><br><li>Total de Lineas Validas: ".$TotalLineasValidas;


								//////////////////////////////////////////////////////
								//													//
								//	 COMENZAMOS A ARMAR EL AREGLO DE LOS VIAJES		//
								//													//
								//////////////////////////////////////////////////////


								//Inicializamos los contadortes vara cada arreglo
									$ct=0;	$cc=0;	$co=0;	$cm=0; $vt=0;

								//Inicializamos el Arreglo de los Viajes
									$ViajesNetos[$vt][6]="NULL";	//Dato Touch del Tiro
									$ViajesNetos[$vt][2]="NULL";	//Dato Touch Camion
									$ViajesNetos[$vt][3]="NULL";	//Dato Touch Origen
									$ViajesNetos[$vt][4]="0000-00-00";	//Dato Touch Fecha Origen
									$ViajesNetos[$vt][5]="00:00:00";	//Dato Touch Hora Origen
									$ViajesNetos[$vt][9]="NULL";	//Dato Touch Tipo de Material
									$ViajesNetos[$vt][13]=0;	//Dato Touch Tipo de Material

								for($x=0;$x<=$TotalLineasValidas;$x++)
								{
									//Obtenemos los Datos del Tiro
										if((substr(trim($LineasValidas[$x]),0,1)=='H') and (substr(trim($LineasValidas[$x]),17,2)=='00'))
										{
											$VTmpTiro[$ct]=substr(trim($LineasValidas[$x]),20,16);
											$ct=$ct+1;
										}

										$ViajesNetos[$vt][6]=$VTmpTiro[$ct-1];
										$ViajesNetos[$vt][14]=RegresaIdTiro($VTmpTiro[$ct-1]);
										$ViajesNetos[$vt][18]=RegresaDescripcionTiro($VTmpTiro[$ct-1]);

									//Obtenemos los Datos del Camion de
										if((substr(trim($LineasValidas[$x]),0,1)=='H') and (substr(trim($LineasValidas[$x]),17,2)=='34'))
										{
											$VTmpCamion[$cc]=substr(trim($LineasValidas[$x]),20,12);
											$ViajesNetos[$vt][2]=$VTmpCamion[$cc];
											$ViajesNetos[$vt][7]=substr(trim($LineasValidas[$x]),2,4)."-".substr(trim($LineasValidas[$x]),6,2)."-".substr(trim($LineasValidas[$x]),8,2);
											$ViajesNetos[$vt][8]=substr(trim($LineasValidas[$x]),10,2).":".substr(trim($LineasValidas[$x]),12,2).":".substr(trim($LineasValidas[$x]),14,2);
											$ViajesNetos[$vt][12]=RegresaIdCamion($ViajesNetos[$vt][2]);
	                                        $ViajesNetos[$vt][16]=RegresaDescripcionCamion($ViajesNetos[$vt][2]);
											$cc=$cc+1;
										}
									//Obtenemos los datos del Origen
										if((substr(trim($LineasValidas[$x]),0,1)=='H') and (substr(trim($LineasValidas[$x]),17,2)=='01'))
										{
											$VTmpOrigen[$co]=substr(trim($LineasValidas[$x]),20,16);
											$ViajesNetos[$vt][3]=$VTmpOrigen[$co];
											$ViajesNetos[$vt][4]=substr(trim($LineasValidas[$x]),2,4)."-".substr(trim($LineasValidas[$x]),6,2)."-".substr(trim($LineasValidas[$x]),8,2);
											$ViajesNetos[$vt][5]=substr(trim($LineasValidas[$x]),10,2).":".substr(trim($LineasValidas[$x]),12,2).":".substr(trim($LineasValidas[$x]),14,2);
											$ViajesNetos[$vt][13]=RegresaIdOrigen($VTmpOrigen[$co]);
											$ViajesNetos[$vt][17]=RegresaDescripcionOrigen($VTmpOrigen[$co]);
											$co=$co+1;
										}
									
									//Obtenemos los Datos de un Camion que no tenga Origen
										if((substr(trim($LineasValidas[$x]),0,1)<>'H') and (substr(trim($LineasValidas[$x]),15,2)=='34'))
										{
											$VTmpCamion[$cc]=substr(trim($LineasValidas[$x]),18,12);
											$ViajesNetos[$vt][2]=$VTmpCamion[$cc];
											$ViajesNetos[$vt][7]=substr(trim($LineasValidas[$x]),0,4)."-".substr(trim($LineasValidas[$x]),4,2)."-".substr(trim($LineasValidas[$x]),6,2);
											$ViajesNetos[$vt][8]=substr(trim($LineasValidas[$x]),8,2).":".substr(trim($LineasValidas[$x]),10,2).":".substr(trim($LineasValidas[$x]),12,2);
											$ViajesNetos[$vt][12]=RegresaIdCamion($ViajesNetos[$vt][2]);
	                                        $ViajesNetos[$vt][16]=RegresaDescripcionCamion($ViajesNetos[$vt][2]);
											$cc=$cc+1;
										}
										
									//Obtenemos los datos de los Tipos de Materiales
										if((substr(trim($LineasValidas[$x]),0,1)<>'H') and (substr(trim($LineasValidas[$x]),15,2)=='31'))
										{
											$VTmpMaterial[$cm]=substr(trim($LineasValidas[$x]),18,12);
											$ViajesNetos[$vt][9]=$VTmpMaterial[$cm];
											$ViajesNetos[$vt][15]=RegresaIdMaterial($VTmpMaterial[$cm]);
											$ViajesNetos[$vt][19]=RegresaDescripcionMaterial($ViajesNetos[$vt][15]);
											$cm=$cm+1;
											$vt=$vt+1;

											$ViajesNetos[$vt][2]="NULL";
											$ViajesNetos[$vt][3]="NULL";
											$ViajesNetos[$vt][4]="0000-00-00";
											$ViajesNetos[$vt][5]="00:00:00";
											$ViajesNetos[$vt][9]="NULL";
											$ViajesNetos[$vt][13]=0;
											$ViajesNetos[$vt][17]="NULL";

										}	
								}
								
								//Mostramos el Total de Viajes netos
								$ERD=count($ViajesNetos);
								$ERDF=($ERD-1);
								//echo "<br><br>Viajes Netos: ".$ERD;
								//echo "<br><br>Viajes Netos(sin 1): ".$ERDF;
								

                                //Insertamos los Registros Validos en la Tabla

                                $ViajesNetosCargados=0;
								
                                for ($a=0;$a<count($ViajesNetos);$a++)
                                {
                                	//echo "<br>".$a."Camiones Involucrados: ".$ViajesNetos[$a][12];
									
									$Hoy=date("Y-m-d");
	                                $Hora=Date("H:i:s",time());
	                                $Creo=$_SESSION['Descripcion']."*".$Hoy."*".$Hora;

	                                //Vefrificamos si existe el registro antes de cargarlo
	                                $HayRegistro=0;
									//$LinkRR=SCA::getConexion();
									$SQLRR="SELECT * FROM viajesnetos where IdProyecto=".$_SESSION['Proyecto']."  and IdCamion=".$ViajesNetos[$a][12]." and IdOrigen=".$ViajesNetos[$a][13]." and FechaSalida='".$ViajesNetos[$a][4]."' and HoraSalida='".$ViajesNetos[$a][5]."' and IdTiro=".$ViajesNetos[$a][14]." and FechaLlegada='".$ViajesNetos[$a][7]."' and HoraLlegada='".$ViajesNetos[$a][8]."' and IdMaterial=".$ViajesNetos[$a][15].";";
									//echo "<br>".$SQLRR;
									$ResultRR=$Link->consultar($SQLRR);
									$HayRegistro=mysql_num_rows($ResultRR);
									//echo "<br>Hay Registro: ".$HayRegistro;
									

									//Si no hay Registro previo lo ingresamos, si lo hay no lo hacemos
									if($HayRegistro<1)
									{
	                                	//Revisamos Si Hay Origen o no
	                                	if ($ViajesNetos[$a][13]==0)
	                                	{ $Estatus=10; }
	                                	else
	                                	{ $Estatus=0; }


										
	                            		$SQL="INSERT INTO viajesnetos(FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro, FechaLlegada, HoraLlegada, IdMaterial, Creo, Estatus)
	    VALUES('".$Hoy."', '".$Hora."', ".$_SESSION['Proyecto'].", ".$ViajesNetos[$a][12].", ".$ViajesNetos[$a][13].", '".$ViajesNetos[$a][4]."', '".$ViajesNetos[$a][5]."', ".$ViajesNetos[$a][14].", '".$ViajesNetos[$a][7]."', '".$ViajesNetos[$a][8]."', ".$ViajesNetos[$a][15].", '".$Creo."', ".$Estatus.");";
	                            		//echo "<br>".$SQL;
	                            		$Result=$Link->consultar($SQL);
										$TT=$Link->affected();
	                            		$ViajesNetosCargados=$ViajesNetosCargados+$TT;
	                            		
									}
                                }
								
                                //echo "<br><li>Solo se ha Registrado ".$ViajesNetosCargados." Viajes de un Total de ".count($ViajesNetos)." Viajes, Debido a que son los Unicos que no se habian registrado en el Sistema<br><br>";

								echo'<table width="200" align="center" border="1" cellspacing="0" cellpadding="0" bordercolor="#FFFFFF">
									  <tr>
										<td align="center">El Archivo </td>
									  </tr>
									  <tr>
										<td align="center">'.$NombreArchivo.'</td>
									  </tr>
									  <tr>
										<td align="center">Se ha Cargado Exitosamente al Sistema </td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
									  </tr>
									  <tr>
										<td align="center">Se han Registrado</td>
									  </tr>
									  <tr>
										<td align="center">'.($ViajesNetosCargados+1).' Viajes Validos Para el Sistema </td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
									  </tr>
									</table>';


							}
							else
							{
								//Eliminamos el Archivo Copiado
								unlink($Ruta.$NuevoNombreArchivo);
							}


					}
				}
				//Si lo Hay No lo Procesamos
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
									<td align="center" class="Estilo1">Debido a que el Archivo ya fue Cargado Previamente</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="center"><input type="submit" name="Submit" value="Volver a Intentar" /></td>
								</tr>
							</table>
						</form>';
					exit();
				}
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
			exit();
		}

?>
</body>
</html>