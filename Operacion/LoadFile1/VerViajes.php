<?php
	session_start();

	include("../../Clases/Loading/CP.php");
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
<script type="text/javascript" src="../../Clases/js/CP.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
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

<body onLoad="HD()">
<?php
CP("../../Imgs");
?>
<table width="845" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="../../Imgs/Encabezados/Operacion/CargarArchivo.png" width="845" height="30" /></td>
  </tr>
</table>
<?php

	$NombreArchivo=$_FILES["archivo"]["name"];
	$NombreTmpArchivo=$_FILES["archivo"]["tmp_name"];
	$TipoArchivo=$_FILES["archivo"]["type"];
	$TamanoArchivo=$_FILES["archivo"]["size"];
	$extension=explode(".",$_FILES["archivo"]["name"]);
	$num=count($extension)-1;

	if($extension[$num]=="TMD")
	{
		//echo "<br><br>Archivo Valido !!!";
		$Fecha=date("d-m-Y");
		$Ruta="../../SourcesFiles/";
		$NuevoNombreArchivo=$Fecha.".TMD";

		//Comprobamos si existe con un rango de 50 nombres

		echo "<br>".$NuevoNombreArchivo;
		$out=0;
		if(file_exists($Ruta.$NuevoNombreArchivo))
		{
			$out=1;
		}

		for($a=1;$a<51;$a++)
		{
			echo "<br>".$a;
			$NuevoNombreArchivo=$Fecha." ".$a.".TMD";
			echo "<br>".$NuevoNombreArchivo;
			if(file_exists($Ruta.$NuevoNombreArchivo))
			{
				$out=$out+$a;
			}
		}

		if($out>0)
		{
			$NuevoNombreArchivo=$NuevoNombreArchivo.' '.$out;
		}
		else
		{
			$NuevoNombreArchivo=$Fecha.".TMD";
		}


		if(!copy($_FILES["archivo"]["tmp_name"],$Ruta.$NuevoNombreArchivo))
		{
			echo "<br>Error al intentar cargar el archivo<br>";
		}
		else
		{
			echo "<br>O.K. Master<br><br>";
			$Huella=md5_file($Ruta.$NuevoNombreArchivo);

			echo "<br>Su Hash es: ".$Huella."<br><br>";
			$linkF=SCA::getConexion();
			$sqlF="insert into archivoscargados(FechaCarga,HoraCarga,IdProyecto,NombreArchivo,HuellaDigital,CargadoPor) values('".date("Y-m-d")."','".$hora=date("H:i:s",time())."',1,'".$NuevoNombreArchivo."','".$Huella."','".$_SESSION['Descripcion']."');";
			echo $sqlF;
			$resultF=mysql_fetch_array($sqlF, $linkF);
			$linkF->cerrar();



			//Abrimos el Archivo que se Acaba de Subir
				$fp = fopen($Ruta.$NuevoNombreArchivo,'r');

			//Guardamos Su Contenido en una Variable
				$texto = fread($fp, filesize($Ruta.$NuevoNombreArchivo));

			//Mostramos su Contenido
				//echo "<li>Texto Original:<br>".$texto;

			//Explotamos el Archivo
				$textoexplotado=explode("\n", $texto);
				$totallineas=count($textoexplotado);

			//echo "<br><br><br><li>(LINEAS: ".$totallineas.") Texto explotado por BR:<br>";


			/*MOSTRAMOS SOLO LAS CABECERAS DEL ARCHIVO*/
				//echo "<br><br><br><li>MOSTRAMOS SOLO LAS CABECERAS DE DATOS VALIDOS Y UTILES DEL ARCHIVO POR LINEA:";

				$TotalLineasValidas=0;
				for($a=0;$a<$totallineas;$a++)
				{
					//echo "<br>".$textoexplotado[$a];
					$Hoy=date("Ymd");

					//Validamos que sean Cabeceras
					if(substr(trim($textoexplotado[$a]),0,1)=='H')
					{

						// Quitamos los Destinos Repetidos
						if(substr(trim($textoexplotado[$a]),17,2)=='00')
						{
							//Quitamos los Repetidos despues de que se registro el primero
							$LineaActual=substr(trim($textoexplotado[$a]),20,2);
							$LineaAnterior=substr(trim($lineasvalidas[$TotalLineasValidas-1]),20,2);

							if($LineaActual<>$LineaAnterior)
							{
								$lineasvalidas[$TotalLineasValidas]=$textoexplotado[$a];
								//echo "<br>".$TotalLineasValidas.".- ".$lineasvalidas[$TotalLineasValidas];
								$TotalLineasValidas=$TotalLineasValidas+1;

							}
						}
						// Quitamos los Camiones Repetidos
						else if(substr(trim($textoexplotado[$a]),17,2)=='34')
						{
							//Quitamos los Repetidos despues de que se registro el primero
							$LineaActual=substr(trim($textoexplotado[$a]),20,11);
							$LineaAnterior=substr(trim($lineasvalidas[$TotalLineasValidas-1]),15,2);

							if($LineaActual<>$LineaAnterior)
							{
								$lineasvalidas[$TotalLineasValidas]=$textoexplotado[$a];
								//echo "<br>".$TotalLineasValidas.".- ".$lineasvalidas[$TotalLineasValidas];
								$TotalLineasValidas=$TotalLineasValidas+1;
							}
						}
						else if(substr(trim($textoexplotado[$a]),17,2)=='01')										// Quitamos los origenes Repetidos
						{
							//Quitamos los Repetidos despues de que se registro el primero
							$LineaActual=substr(trim($textoexplotado[$a]),20,2);
							$LineaAnterior=substr(trim($lineasvalidas[$TotalLineasValidas-1]),20,2);

							if($LineaActual<>$LineaAnterior)
							{
								$lineasvalidas[$TotalLineasValidas]=$textoexplotado[$a];
								//echo "<br>".$TotalLineasValidas.".- ".$lineasvalidas[$TotalLineasValidas];
								$TotalLineasValidas=$TotalLineasValidas+1;
							}
						}

					}
					//Validamos que sean Tipos de Materiales
					else if	(substr(trim($textoexplotado[$a]),15,2)=='31')
					{
						//Quitamos los Repetidos despues de que se registro el primero
						$LineaActual=substr(trim($textoexplotado[$a]),15,2);
						$LineaAnterior=substr(trim($lineasvalidas[$TotalLineasValidas-1]),15,2);

						if($LineaActual<>$LineaAnterior)
						{
							$lineasvalidas[$TotalLineasValidas]=$textoexplotado[$a];
							//echo "<br>".$TotalLineasValidas.".- ".$lineasvalidas[$TotalLineasValidas];
							$TotalLineasValidas=$TotalLineasValidas+1;
						}
					}
				}

				########################################################################
				#      COMENZAMOS A ARMAR LOS VIAJES A PERTIR DEL ARCHIVO              #
				########################################################################

				//Armamos los Arreglos para Formar los Viajes
					$b=0; $c=0; $d=0; $e=0; $f=0; $g=0;

					$IdProyecto=$_SESSION['Proyecto'];
					$DescProyecto=RegresaDescripcionProyecto($IdProyecto);

					for($a=0;$a<$TotalLineasValidas;$a++)
					{
						//Tratamos las Lineas que son Cabeceras(Empiezan con H)
						if(substr(trim($lineasvalidas[$a]),0,1)=='H')
						{
							if(substr(trim($lineasvalidas[$a]),17,2)=='00')
							{
								$b=$b+1;
								$Tiros[$b]=substr(trim($lineasvalidas[$a]),20,12);
								//$FTiros[$b]=substr(trim($lineasvalidas[$a]),2,4)."-".substr(trim($lineasvalidas[$a]),6,2)."-".substr(trim($lineasvalidas[$a]),8,2);
								//$HTiros[$b]=substr(trim($lineasvalidas[$a]),10,2).":".substr(trim($lineasvalidas[$a]),12,2).":".substr(trim($lineasvalidas[$a]),14,2);
								//echo "<br><br><br>Tiros: ".$b.".-  ".$Tiros[$b];


							}
							else if(substr(trim($lineasvalidas[$a]),17,2)=='34')
						    {
								$c=$c+1;
								$Camiones[$c][$c]=$Tiros[$b];
								$Camiones[$c][$c+1]=substr(trim($lineasvalidas[$a]),20,12);

								//Datos del Camión, Fecha y Hora de Llegadas
								$Viajes[$c][2]=substr(trim($lineasvalidas[$a]),20,12);
								$Viajes[$c][7]=substr(trim($lineasvalidas[$a]),2,4)."-".substr(trim($lineasvalidas[$a]),6,2)."-".substr(trim($lineasvalidas[$a]),8,2);
								$Viajes[$c][8]=substr(trim($lineasvalidas[$a]),10,2).":".substr(trim($lineasvalidas[$a]),12,2).":".substr(trim($lineasvalidas[$a]),14,2);

								$Viajes[$c][12]=RegresaIdCamion($Viajes[$c][2]);
								$Viajes[$c][16]=RegresaDescripcionCamion($Viajes[$c][2]);

								//Datos del Tiro
								$Viajes[$c][6]=$Tiros[$b];

								$Viajes[$c][14]=RegresaIdTiro($Viajes[$c][6]);
								$Viajes[$c][18]=RegresaDescripcionTiro($Viajes[$c][6]);

							}
							else if(substr(trim($lineasvalidas[$a]),17,2)=='01')
						    {
								$d=$d+1;
								$Bancos[$d][$d]=$Supervisores[$b];
								$Bancos[$d][$d+1]=substr(trim($lineasvalidas[$a]),20,12);

								$Viajes[$c][3]=substr(trim($lineasvalidas[$a]),20,12);
								$Viajes[$c][4]=substr(trim($lineasvalidas[$a]),2,4)."-".substr(trim($lineasvalidas[$a]),6,2)."-".substr(trim($lineasvalidas[$a]),8,2);
								$Viajes[$c][5]=substr(trim($lineasvalidas[$a]),10,2).":".substr(trim($lineasvalidas[$a]),12,2).":".substr(trim($lineasvalidas[$a]),14,2);

								$Viajes[$c][13]=RegresaIdOrigen($Viajes[$c][3]);
								$Viajes[$c][17]=RegresaDescripcionOrigen($Viajes[$c][3]);

								$Viajes[$c][1]=$IdProyecto;
								$Viajes[$c][20]=$DescProyecto;
							}
						}
						//Tratamos las Lineas Validas que no son Cabeceras (No Empiezan con H)
						else
						{
							if(substr(trim($lineasvalidas[$a]),15,2)=='31')
						    {
								$e=$e+1;
								$Materiales[$e][$e]=$Supervisores[$b];
								$Materiales[$e][$e+1]=substr(trim($lineasvalidas[$a]),20,12);
								$Viajes[$c][9]=substr(trim($lineasvalidas[$a]),18,12);
								$Viajes[$c][15]=RegresaIdMaterial(substr(trim($lineasvalidas[$a]),18,12));
								$Viajes[$c][19]=RegresaDescripcionMaterial($Viajes[$c][15]);
							}
						}

						$Viajes[$c][11]=$_SESSION['Descripcion']."*".date("Y-m-d")."*".date("H:i:s",time());
					}

					echo "<br><br><br>Total de Tiros: ".count($Tiros);
					echo "<br>Total de Camiones: ".count($Camiones);
					echo "<br>Total de Bancos: ".count($Bancos);
					echo "<br>Total de Materiales: ".count($Materiales);

						echo '<table border="1" cellspacing="0" cellpadding="0">
						  <tr>
						    <td class="LFEncabezado">Id<br />Proyecto</td>
						    <td class="LFEncabezado">Descripción<br />Proyecto</td>
						    <td class="LFEncabezado">Camion</td>
						    <td class="LFEncabezado">Id<br />Camion</td>
						    <td class="LFEncabezado">Eco<br />Camion</td>
						    <td class="LFEncabezado">Origen</td>
						    <td class="LFEncabezado">Id<br />Origen</td>
						    <td class="LFEncabezado">Descripción<br />Origen</td>
						    <td class="LFEncabezado">Fecha<br />Salida</td>
						    <td class="LFEncabezado">Hora<br />Salida</td>
						    <td class="LFEncabezado">Tiro</td>
						    <td class="LFEncabezado">Id<br />Tiro</td>
						    <td class="LFEncabezado">Descripción<br />Tiro</td>
						    <td class="LFEncabezado">Fecha<br />Llegada</td>
						    <td class="LFEncabezado">Hora<br />Llegada</td>
						    <td class="LFEncabezado">Tipo<br />Material </td>
						    <td class="LFEncabezado">Id<br />Material </td>
						    <td class="LFEncabezado">Descripcion<br />Material </td>
						    <td class="LFEncabezado">???</td>
						    <td class="LFEncabezado">Creo</td>
						  </tr>';



					//Armamos el Arreglo con los Datos de los Viajes
					$RegistrosInsertados=0;

					for($z=1;$z<count($Viajes);$z++)
					{

						//Insertamos los Viajes Netos en la Tabla

						$FechaCarga=date("Y-m-d");
						$HoraCarga=date("H:i:s",time());

						$TIdProyecto=$Viajes[$z][1];
						$TIdCamion=$Viajes[$z][12];
						$TIdOrigen=$Viajes[$z][13];
						$TFechaSalida=$Viajes[$z][4];
						$THoraSalida=$Viajes[$z][5];
						$TIdTiro=$Viajes[$z][14];
						$TFechaLlegada=$Viajes[$z][7];
						$THoraLlegada=$Viajes[$z][8];
						$TIdMaterial=$Viajes[$z][15];
						$TCreo=$Viajes[$z][11];

						//Revisamos que no haya un Viaje Igual

							$Hay=0;
							$linkrev=SCA::getConexion();
							$sqlrev="Select * from Viajes brutos where IdProyecto=$TIdProyecto and IdCamion=$TIdCamion and IdOrigen=$TIdOrigen' and FechaSalida='$TFechaSalida' and HoraSalida='$THoraSalida' and IdTiro=$TIdTiro and FechaLlegada='$TFechaLlegada' and HoraLlegada='$THoraLlegada' and IdMaterial=$TIdMaterial;";
							$resultrev=mysql_query($linkrev, $sqlrev);
							$Hay=mysql_num_rows($resultrev);
							$linkrev->cerrar();

							if($Hay==0)
							{
								$link=SCA::getConexion();
								$insert="INSERT INTO viajesnetos(FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro, FechaLlegada, HoraLlegada, IdMaterial, Creo)";
								$values=" VALUES('$FechaCarga','$HoraCarga',$TIdProyecto,$TIdCamion,$TIdOrigen,'$TFechaSalida','$THoraSalida',$TIdTiro,'$TFechaLlegada','$THoraLlegada',$TIdMaterial,'$TCreo');";
								$sql=$insert.$values;
								//echo "<br />".$sql;
								$result=$link->consultar($sql);
								$RegistrosInsertados=$RegistrosInsertados+$link->affected();
								$link->cerrar();
							}


						echo '  </tr>
								  <tr>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][1].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][20].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][2].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][12].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][16].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][3].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][13].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][17].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][4].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][5].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][6].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][14].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][18].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][7].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][8].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][9].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][15].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][19].'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$z.'&nbsp;</td>
								    <td class="LFItem2">&nbsp;'.$Viajes[$z][11].'&nbsp;</td>
								  </tr>';

					}

					echo "<br><br>Total de Registros Insertados".$RegistrosInsertados;



					  echo'</table>';



		}
	}
	else
	{
		echo'
			 <form name="frm" method="post" action="Inicio.php">
			 <table width="560" border="0" align="center" cellpadding="0" cellspacing="0">
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
<table border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class="LFEncabezado">Proyecto</td>
    <td class="LFEncabezado">Camion</td>
    <td class="LFEncabezado">Banco</td>
    <td class="LFEncabezado">Fecha<br />Salida</td>
    <td class="LFEncabezado">Hora<br />Salida</td>
    <td class="LFEncabezado">Tiro</td>
    <td class="LFEncabezado">Fecha<br />Llegada</td>
    <td class="LFEncabezado">Hora<br />Llegada</td>
    <td class="LFEncabezado">Tipo<br />Material </td>
    <td class="LFEncabezado">???</td>
    <td class="LFEncabezado">Creo</td>
  </tr>
  <tr>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
    <td class="LFItem2">&nbsp;</td>
  </tr>
  <tr>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
    <td class="LFItem1">&nbsp;</td>
  </tr>
</table>
</body>
</html>
