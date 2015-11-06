// JavaScript Document

$('.text,.texto,textarea').live("keypress",function(){	withoutSpaces(event,'decOK'); withoutCR(event,'decOK'); });
$('.text,.texto,textarea, .monetario').live("dblclick",function(){ read=$(this).attr("readonly"); if(!read)	$(this).attr("value","") });
$('.monetario').live("keypress",function(){	onlyDigits(event,'decOK');  });

$("div#mensajes div#mnsj").live("click",function(){$(this).fadeOut("slow");});
function oculta_botones()
{
	$("div.sboton").css("display","none");
}
function muestra_botones()
{
	$("div.sboton").css("display","block");
}
function presenta_mensaje(del)
{
	del_i=3000;
	if(del==undefined||del==0||del==''){del = del_i;}
	$("div#mensajes div#mnsj.np").fadeIn("slow").delay(del).fadeOut("slow");
	$("div#mensajes div#mnsj.p").fadeIn("slow");
}
function llena_mensaje(mensaje)
{
	$("div#mensajes div#mnsj.np").detach();
	$("div#mensajes div#mnsj.p").detach();
	$("div#mensajes").append(mensaje);
}



//onKeyPress="withoutSpaces(event,'decOK')"

var isIE = document.all?true:false;
var isNS = document.layers?true:false;



function onlyDigits(e,decReq) {
var key = (isIE) ? window.event.keyCode : e.which;
var obj = (isIE) ? event.srcElement : e.target;
var isNum = (key > 47 && key < 58) ? true:false;
var dotOK = (key==46 && decReq=='decOK' && (obj.value.indexOf(".")<0 || obj.value.length==0)) ? true:false;
window.event.keyCode = (!isNum && !dotOK && isIE) ? 0:key;
e.which = (!isNum && !dotOK && isNS) ? 0:key;
return (isNum || dotOK);
}

function onlyDigitsPunto(e,decReq) {
var key = (isIE) ? window.event.keyCode : e.which;
var obj = (isIE) ? event.srcElement : e.target;
var isNum = (key > 47 && key < 58) ? true:false;

window.event.keyCode = (!isNum && isIE) ? 0:key;
e.which = (!isNum && isNS) ? 0:key;
return (isNum);
}

function withoutSpaces(e,decReq) {
	var key = (isIE) ? window.event.keyCode : e.which;

	var obj = (isIE) ? event.srcElement : e.target;
	var isNum = (key!=32&&key!=34&&key!=39&&key!=47&&key!=60&&key!=62&&key!=92&&key!=13) ? true:false;
	var dotOK = (key==32 && decReq=='decOK' && (obj.value.length>0)) ? true:false;
	window.event.keyCode = (!isNum && !dotOK && isIE) ? 0:key;
	e.which = (!isNum && !dotOK && isNS) ? 0:key;
	return (isNum || dotOK);
}
function withoutCR(e,decReq) {
	var key = (isIE) ? window.event.keyCode : e.which;
	var obj = (isIE) ? event.srcElement : e.target;
	var isNum = (key!=32&&key!=34&&key!=39&&key!=47&&key!=60&&key!=62) ? true:false;
	var dotOK = (key==32 && decReq=='decOK' && (obj.value.length>0)) ? true:false;
	window.event.keyCode = (!isNum && !dotOK && isIE) ? 0:key;
	e.which = (!isNum && !dotOK && isNS) ? 0:key;
	return (isNum || dotOK);
}

function quitacomas(valor)
{ 
	var i=0;
	dato="";
	if(valor=='')
	valor="0.00";
	valor=valor.toString();
	resultado2=valor.split(".");
	resultado1=resultado2[0].split(",");
	for(i=0;i<resultado1.length;i++)
	{
		dato+=resultado1[i];
		
	}
if(resultado2[1])
	{
		dato+="."+resultado2[1];
	}
	return parseFloat(dato);
}

/*ESTA FUNCIÓN RECIBE UN PARAMETRO NUMERICO AL CUAL APLICARA LA FUNCION QUITACOMAS Y POSTERIORMENTE LE DARA FORMATO CON COMAS Y DEVOLVERA DICHO VALOR: onKeyUp="this.value=formateando(this.value)"*/
function formateando(value)
					{  value=value.toString();
						fin1= value;
						
						if(fin1=="")
						{ 
							
							campo="0";
							return campo;
						}
						else 
						if(fin1==".")
						{
							
							campo="0."; return campo;
						}
						
						else
						{
							
							var index=fin1.indexOf(".");	
							
							if(index==-1)
							{	
							
							
								fin=quitacomas(fin1);
								
								resultado1 = parseFloat(fin).toString();
								
								var cadena="";
								cont=1
								for(m=resultado1.length-1; m>=0; m--)
								{
									cadena = resultado1.charAt(m) + cadena
									cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
									cont== 3 ? cont = 1 :cont++
								}
								
									campo= cadena; 
									return campo;
								
							}
							
							else
							{
							
								fin=quitacomas(fin1);								
								resultado1 = parseFloat(fin).toFixed(10).toString();
								resultados = resultado1.split(".");
								var cadena="";
								cont=1
								for(m=resultados[0].length-1; m>=0; m--)
								{	
									cadena = resultados[0].charAt(m) + cadena
									cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
									cont== 3 ? cont = 1 :cont++
								}
								if(resultados[1])
								{ 
									
									campo=cadena+"."+resultado2[1];
									return campo;
								}
							
							
							}
						}
					}

function redondear(a,dec)
{
					var cantidad = parseFloat(a);
						var decimales = parseFloat(dec);
						if(decimales==0)
						{ 
							resultado = parseFloat(cantidad).toString();
							resultado = resultado.split(".");
							resultadoenteros=parseInt(resultado[0]);
							decim="0"+"."+resultado[1];
							resultadodecimales=parseFloat(decim);
							if(resultadodecimales>0.50)
							{ 
								resultadoenteros=resultadoenteros+1;
							}
							
							cifra=resultadoenteros;
							return cifra;
						}
						else
						{
							
						
						decimales = (!decimales ? 2 : decimales);
						
						a=Math.floor(cantidad*100);
						
						b2=(cantidad*100)-a;
						//alert(b);
						c=b2*10;
						d=Math.round(c);
						if(d>=5){
						
						fin= Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
						resultado = parseFloat(fin).toFixed(decimales).toString();
						resultado = resultado.split(".");
						var cadena = ""; cont = 1
						for(m=resultado[0].length-1; m>=0; m--){
							cadena = resultado[0].charAt(m) + cadena
							cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
							cont== 3 ? cont = 1 :cont++
						}
						cifra= cadena + "." + resultado[1]; 
						
						}else{
						fin= Math.floor(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
						resultado = parseFloat(fin).toFixed(decimales).toString();
						resultado = resultado.split(".");
						var cadena = ""; cont = 1
						for(m=resultado[0].length-1; m>=0; m--){
							cadena = resultado[0].charAt(m) + cadena
							cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
							cont== 3 ? cont = 1 :cont++
						}
						cifra= cadena + "." + resultado[1]; 
						
						}
						return cifra;
						}
						
					
}
