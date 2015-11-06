// JavaScript Document

function usuario(){
	var variables='u='+(document.getElementById('combo').value);
	myajax(variables,'3Consulta.php','permisos');
	}
function enviaCamion(i,t,f){
	var variables='i='+i;
	variables += '&t='+t;
	variables += '&f='+f;
	myajax(variables,'4Aprueba.php','detalle');
	}
function aprueba_cancela(IdViajeNeto,i,t,f){
	var variables='IdViajeNeto='+IdViajeNeto;
	variables += '&i='+i;
	variables += '&t='+t;
	variables += '&f='+f;
	myajax(variables,'5Cambia.php','detalle');
	}