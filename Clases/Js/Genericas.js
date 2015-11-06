// JavaScript Document
function backspace()
{

	if(window.event && window.event.keyCode==8)
	{
		//alert('Alerta presionaste Back');
		window.event.keyCode = 0;
		return false;
	}
}

function cambiarDisplay(id) {
  if (!document.getElementById) return false;
  fila = document.getElementById(id);
  if (fila.style.display != "none") {
    fila.style.display = "none"; //ocultar fila 

  } else {
    fila.style.display = ""; //mostrar fila 
  }
}

function cambiarDisplay(id) {
  if (!document.getElementById) return false;
  fila = document.getElementById(id);
  if (fila.style.display != "none") {
    fila.style.display = "none"; //ocultar fila 

  } else {
    fila.style.display = ""; //mostrar fila 
  }
}