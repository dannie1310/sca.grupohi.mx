<?php 
session_start();
header("Content-type: image/jpeg");
$reserva=fread(fopen("../../SourcesFiles/imagenes_camiones/empty.jpg","rb"),filesize("../../SourcesFiles/imagenes_camiones/empty.jpg"));

if(file_exists("../../SourcesFiles/imagenes_camiones/".$_SESSION[ProyectoGlobal]."-".$_REQUEST["im"].".jpg"))
{ 
	$imagen=fread(fopen("../../SourcesFiles/imagenes_camiones/".$_SESSION[ProyectoGlobal]."-".$_REQUEST["im"].".jpg","rb"),filesize("../../SourcesFiles/imagenes_camiones/".$_SESSION[ProyectoGlobal]."-".$_REQUEST["im"].".jpg"));
	print ($imagen);
}
else{
print($reserva);
//	echo "no esta";
}

?>