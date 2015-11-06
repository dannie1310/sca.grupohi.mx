/*
	Script para Abrir una Ventana Nueva
	By Aguayo, 2007
*/
  
  function ventana(theURL,winName,features) 
  { 
   	var date=new Date();
   	var seconds=date.getSeconds();
   	window.open(theURL,winName,features);
  }