// JavaScript Document
// JavaScript Document
function nuevoAjax(){
	var xmlhttp=false;	 try {
	 xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e) {	 try {
	 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	 } catch (E) {	 xmlhttp = false;	 }
	 }	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp = new XMLHttpRequest();
	}
return xmlhttp;
}

function myajax(variables,archivo,contenedor){
	var ajax=nuevoAjax(); //se crea el ajax
	ajax.open('POST', archivo, true);
	ajax.onreadystatechange=function()
	{
		if(ajax.readyState==1){
			document.getElementById(contenedor).innerHTML = '<center><img src="../../../Imagenes/loading.gif" title="cargando" align="middle"/></center>';    //se establece como se mostrara el resultado
		}
		if(ajax.readyState==4)
		{
			document.getElementById(contenedor).innerHTML=ajax.responseText;  //se establece como se mostrara el resultado
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;");
	ajax.send(variables); //se envian los valores a traves de la variable usuario
}


function elemento(e,id){
	var variables='e='+e;
	variables += '&id='+id;
	myajax(variables,'4Modifica.php','permisos');
}
//Funcion agregada el 22 de Septiembre de 2011 para la consulta de usuarios en el modulo de asignacion de permisos
function usuario(){
	var variables='u='+(document.getElementById('combo').value);
	myajax(variables,'3Consulta.php','permisos');
	}
function busca(fecha,ruta){
	var variables='fecha='+(document.getElementById('fecha').value);
	variables += '&ruta='+(document.getElementById('ruta').value);
	myajax(variables,'04Result.php','resultados');
	}