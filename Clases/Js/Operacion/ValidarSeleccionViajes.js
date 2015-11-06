//Función para Validar la Selección de los Viajes, si se acepta o se rechaza

function cambia1(uno,dos)
{	//alert("das");
	 if (!document.getElementById) return false;
	 
 	 uno=document.getElementById(uno);
  	 dos=document.getElementById(dos);
	 dos.checked=0;
}

function cambia2(uno,dos)
{	//alert("das");
	 if (!document.getElementById) return false;
	 
 	 uno=document.getElementById(uno);
  	 dos=document.getElementById(dos);
	 uno.checked=0;
}