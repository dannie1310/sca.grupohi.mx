<?php 

function nftcb($path)
{
	$xp=explode("/",$path);
	$salidas=sizeof($xp)-3;
	$salidasp="";
	for($m=0;$m<$salidas;$m++)
	{$salidasp.='../';}
	echo '<link href="../'.$salidasp.'Clases/Js/NiftyCube/niftyCorners.css" rel="stylesheet" type="text/css">';
	echo '<script type="text/javascript" src="../'.$salidasp.'Clases/Js/NiftyCube/niftycube.js"></script>';
	echo '<script type="text/javascript" src="../'.$salidasp.'Clases/Js/NoClick.js"></script>';
	echo '<script type="text/javascript" src="../'.$salidasp.'inc/js/jquery-1.4.4.js"></script>';

	echo '<script type="text/javascript">window.onload=function(){Nifty("div#layout","big top");carga_load("../'.$salidasp.'Imagenes/loading.gif","Cargando...")}</script>';
}

?>