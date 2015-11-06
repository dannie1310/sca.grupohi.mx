<?php 
$SELF = explode('/',$_SERVER['PHP_SELF']);
define("ROOT",'http://'.$_SERVER["HTTP_HOST"].'/'.$SELF[1].'/');


function borraDirectorio($path)
{
	
	if(!$dir = opendir($path))
	{
		throw new Exception("Error al intentar abrir el directorio : ".$path);
	}
	else
	{
		while ($elemento = readdir($dir))
		{
			if($elemento != "."&&$elemento != "..")
			if(!unlink($path.$elemento))
			throw new Exception("Error al intentar eliminar elemento de directorio : ".$path.$elemento);
		}
		closedir($dir);
		//throw new Exception("Error al intentar cerrar el directorio : ".$dir);
	}

	
}

function creaSelect($arreglo, $nombre="", $selected = "")
{
	$salida= '
	<select name="'.$nombre.'" id="'.$nombre.'" >
		<option value="0">TAC</option>';
	for($ii = 0; $ii<sizeof($arreglo["idmenu_nodo"]); $ii++)	
	{
		$salida.='<option';
		
		$salida.=' value="'.$arreglo["idmenu_nodo"][$ii].'"';
		
		$salida.='title="'.$arreglo["descripcion"][$ii].'"';
		if($selected == $arreglo["idmenu_nodo"][$ii])
		$salida.=' selected ';
		$salida.='>';
		$espacios='';
		for($i=0; $i<$arreglo["nivel"][$ii];$i++)
		$espacios.='&nbsp;&nbsp;';
		$salida.=$espacios.$arreglo["descripcion_corta"][$ii].'</option>';	
	}
	$salida.='</select>';
	
	return $salida;
}

function creaLista($arreglo)
{
	$salida= '
	<ul class="lista">';
	for($ii = 0; $ii<sizeof($arreglo["idmenu_nodo"]); $ii++)	
	{
		$salida.='<li value="'.$arreglo["idmenu_nodo"][$ii].'" title="'.$arreglo["descripcion"][$ii].'"><div id="contenedor">';
		$espacios='';
		for($i=0; $i<$arreglo["nivel"][$ii];$i++)
		$espacios.='&nbsp;&nbsp;';
		$salida.='<div id="etiquetas">'.$espacios.$arreglo["descripcion_corta"][$ii]."</div>";
		$salida.='<div id="botones"><div class="sboton up" title="Subir una Posici�n" onclick="xajax_sube_posicion_nodo('.$arreglo["idmenu_nodo"][$ii].')"></div><div class="sboton down" title="Bajar una Posici�n" onclick="xajax_baja_posicion_nodo('.$arreglo["idmenu_nodo"][$ii].')"></div><div class="sboton editar" title="Editar Informaci�n del M�dulo" onclick="return GB_showCenter(\'Editar Informaci&oacute;n de M�dulos\', \'http://192.168.103.154:90/TAC_Beta/administracion/modulos/editar.php?idmodulo='.$arreglo["idmenu_nodo"][$ii].'\', 400, 510)"></div><div class="sboton eliminar" title="Eliminar M�dulo" onclick="xajax_elimina_nodo('.$arreglo["idmenu_nodo"][$ii].')"></div></div></div></li>';	
	}
	$salida.='</ul>';
	
	return $salida;
}
function creaListaUsuarios($arreglo)
{
	$salida= '
	<ul class="lista">';
	for($ii = 0; $ii<sizeof($arreglo["idmenu_nodo"]); $ii++)	
	{
		$salida.='<li value="'.$arreglo["idmenu_nodo"][$ii].'" title="'.$arreglo["descripcion"][$ii].'"><div id="contenedor">';
		$espacios='';
		for($i=0; $i<$arreglo["nivel"][$ii];$i++)
		$espacios.='&nbsp;&nbsp;';
		$salida.='<div id="etiquetas">'.$espacios.$arreglo["descripcion_corta"][$ii]."</div>";
		$salida.='</div></li>';	
	}
	$salida.='</ul>';
	
	return $salida;
}

function regresa_mensaje($tipo,$mensaje,$permanencia = "np",$display = "none")
{
	$mensaje = '<div id="mnsj" class="'.$tipo.' '.$permanencia.'"  style="display:'.$display.'" >'.$mensaje.'</div>';
	return $mensaje;
}
function inc_delay($delay)
{
	$delay+=3000;
	return $delay;
}

function fecha($cambio)
	{ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[2];
		$mes=$partes[1];
		$a�o=$partes[0];
		$Fecha=$dia."-".$mes."-".$a�o;
		return ($Fecha);
	}


	function fechasql($cambio)
	{ //echo $cambio;
		$partes=explode("-", $cambio);
		$dia=$partes[0];
		$mes=$partes[1];
		$a�o=$partes[2];
		$Fechasql=$a�o."-".$mes."-".$dia;
		return ($Fechasql);
	}
?>