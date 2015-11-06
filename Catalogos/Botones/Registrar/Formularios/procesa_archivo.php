<?php 
session_start();
	include("../../../../inc/php/conexiones/SCA.php");
$l = SCA::getConexion();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="../../../../Estilos/Principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php 

$NombreArchivo=$_FILES["archivo_botones"]["name"];					//Obtenemos el Nombre del Archivo
$NombreTmpArchivo=$_FILES["archivo_botones"]["tmp_name"];			//Obtenemos el Nombre Temporal del Archivo
$TipoArchivo=$_FILES["archivo_botones"]["type"];					//Obtenemos el Tipo de Archivo
$TamanoArchivo=($_FILES["archivo_botones"]["size"]/1024);			//Obtenemos el Tamaño del Archivo
$DatosArchivo=explode(".",$_FILES["archivo_botones"]["name"]);		//Obtenemos la Extension
$Extension=count($DatosArchivo)-1;		

if($DatosArchivo[$Extension]=="TMD")
{
	$Fecha=date("d-m-Y");
	$Ruta="../../../../SourcesFiles/Botones/";
	$NuevoNombreArchivo=$Fecha.".TMD";
	$HuellaDigitalArchivoTemporal=md5_file($_FILES["archivo_botones"]["tmp_name"]);
	


	if(file_exists($Ruta.$NombreArchivo))
	{?>
		
		
<table  class="Mensaje_Error" border="0" align="center" style="width:auto;margin-left:0%;margin-right:0%">
		    <tr>
		      <td>Ya existe un archivo registrado con el nombre <br />
		        <?php echo $NombreArchivo; ?></td>
	        </tr>
	      </table>

<?php }
	else
	{
		if(copy($_FILES["archivo_botones"]["tmp_name"],$Ruta.$NombreArchivo))
		{
			//Abrimos el Archivo que se Acaba de Subir
								$AbrirArchivo = fopen($Ruta.$NombreArchivo,'r');

								//Guardamos Su Contenido en una Variable
								$ContenidoArchivo = fread($AbrirArchivo, filesize($Ruta.$NombreArchivo));

								//Explotamos el Archivo
								$ContenidoArchivoExplotado=explode("\n", $ContenidoArchivo);
								$TotalLineasArchivo=count($ContenidoArchivoExplotado);
								$primera_linea=$ContenidoArchivoExplotado[0];
								$ultima_linea=$ContenidoArchivoExplotado[sizeof($ContenidoArchivoExplotado)-2];
								$primera_linea=explode(" ",$primera_linea);
								$p_len=count($primera_linea);
								if($p_len==4&&ereg("^T{1}[0-9]{1,}",trim($primera_linea[3]))&&trim($ultima_linea)=="T 000")
								{
										$registrados=0; $no_registrados=0;
										for($o=1;$o<sizeof($ContenidoArchivoExplotado)-2;$o++)
										{
											$filas[$o]=explode(" ",$ContenidoArchivoExplotado[$o]);
											$identificador[$o]=trim($filas[$o][2]);
											
											if($filas[$o][1]==34)
											{
												$tipo[$o]=2;	
											}
											else
											if($filas[$o][1]==31)
											{
												$tipo[$o]=1;	
											}
											else
											{
												$tipo[$o]="";	
											}
											
$l = SCA::getConexion();
											$r=$l->consultar("call sca_registra_boton(".$_SESSION["Proyecto"].",'".$identificador[$o]."',".$tipo[$o].",@Respuesta)");
											$v=$l->fetch($r);
											
											$r2=$l->consultar("select @Respuesta");
											$v2=$l->fetch($r2);
											
											if($v2["@Respuesta"]!='')
											{
												$mensaje=$v2["@Respuesta"];
												$mensaje=explode("-",$mensaje);
												if($mensaje[0]=='ko')
												$no_registrados++;
												if($mensaje[0]=='ok')
												$registrados++;
												$respuesta[$o]='<img src="../../../../Imagenes/'.$mensaje[0].'.gif" width="16" height="16" align="absbottom" /> '.utf8_decode($mensaje[1]);
											}
											else
											{
												$respuesta[$o]="<img src='../../../../Imagenes/ko.gif' width='16' height='16' align='absbottom' /> Hubo un error durante el registro del bot�n: ".$identificador[$o];	
												$no_registrados++;
											}
										}?>
										<table style="width:auto" border="1" summary="Checa"  class="formulario">
<caption class="encabezado" style="text-align:left">
<img src="../../../../Imagenes/resultado.gif" width="16" height="16"  />&nbsp;Resultado del registro</caption>
<thead>
<tr>
<th class="detalle"><br /> <img src="../../../../Imagenes/archivo.gif" width="16" height="16" align="absbottom" /><strong><?php echo $NombreArchivo; ?></strong> <br />
<img src="../../../../Imagenes/ok.gif" width="16" height="16"  align="absbottom"  /> Botones Registrados: <?php echo $registrados ?> <img src="../../../../Imagenes/ko.gif" width="16" height="16"  align="absbottom" /> Botones No Registrados: <?php echo $no_registrados; ?><hr /></th>
</tr>
</thead>
<tbody>
<?php
for($p=1;$p<=sizeof($respuesta);$p++)
{?>
	  <tr class="detalle">
    <td>&nbsp;<?php echo $respuesta[$p]; ?></td>
  </tr>
<?php }?></tbody></table>
							<?php	}
								else
								{
									if (!unlink($Ruta.$NombreArchivo)){ 
echo 'no se pudo borrar el archivo :'.$Ruta.$NombreArchivo; 
} 

if (!rename($Ruta.$NombreArchivo,$Ruta.$NombreArchivo.date("Ymdhis"))){ 
//echo 'no se pudo renombrar el archivo :'.$Ruta.$NombreArchivo; 
} 

									?>
			<table  class="Mensaje_Error" border="0" align="center" style="width:auto;margin-left:0%;margin-right:0%">
		    <tr>
		      <td>El archivo <?php echo $NombreArchivo; ?> tiene un error interno.
		       </td>
	        </tr>
            
	      </table>
							<?php 	}
		}
	}
}
?>




</body>
</html>