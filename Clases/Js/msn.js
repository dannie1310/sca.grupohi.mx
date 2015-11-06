/*
	Archivo Para Mostrar un Mensaje en la Barra de Estado de una Pagina WEB
	By Aguayo, 2007
*/


//Mensaje Sobre el que se Crea el Efecto
msg = " . . : : Sistema de Control de Acarreos : : . .";

//Temporizador
timeID = 10;
stcnt = 16;

//Declaración del array con la secuencia de mensajes que se visualizarán
wmsg = new Array(33);

//Construccion del array con la secuencia
wmsg[0] = msg;
blnk = "                                                               ";
for (i=1; i<32; i++)
{
        b = blnk.substring(0,i);	//i espacios en blanco
        wmsg[i] = "";
		
        for (j=0; j<msg.length; j++)	//añade i espacios entre cada letra del mensaje
                wmsg[i] = wmsg[i] + msg.charAt(j) + b;
}

//crea el bucle de visualizacion
function wiper()
{
        if (stcnt > -1)			//Cambia el mensaje del array de mensajes
                str = wmsg[stcnt];
        else				//Deja fijo el mensaje final
                str = wmsg[0];
        if (stcnt-- < -40)		//Inicializa la secuencia
                stcnt=31;
				
        status = str;			//Muestra el mensaje en la barra de estado
        clearTimeout(timeID);
        timeID = setTimeout("wiper()",100);
}

//añadida por El Codigo: detiene el efecto
function wiperOff() 
{
	if ( timeID )
		clearTimeout(timeID);
}

wiper();