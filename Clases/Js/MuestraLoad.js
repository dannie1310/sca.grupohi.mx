// JavaScript Document
document.write('<div id="cargando">Cargando...</div>');
function muestra_cargando(){
  xajax.$('cargando').style.display = 'block';
}
function oculta_cargando(){
  xajax.$('cargando').style.display = "none";
}

function carga_load(imagen,texto)
{
	document.getElementById('cargando').innerHTML='<img src="'+imagen+'" />'+texto;
}

function quita_eliminado(id)
{
	document.getElementById('muestra_solicitud').innerHTML='';
	document.getElementById(id).style.display='none';	
}

xajax.callback.global.onRequest = muestra_cargando;
xajax.callback.global.onComplete = oculta_cargando;

