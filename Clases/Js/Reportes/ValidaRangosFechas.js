// JavaScript Document

function ValidaFechaIni(fecha1,fecha2,fechadocto) 
	{	//fecha2 es hoy; 
		//fecha1 es de inicio
		//fechadocto es vencimiento
		//alert('validafecha("'+fecha1+'"'+fecha2+'"'+fechadocto+'")');
		var ano1= parseInt(String(fecha1.substring(fecha1.lastIndexOf("-")+1,fecha1.length)),10);
		var resto=new String(fecha1.substring(0,fecha1.lastIndexOf("-")));
		var mes1= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia1= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var ano2= parseInt(String(fechadocto.substring(fechadocto.lastIndexOf("-")+1,fechadocto.length)),10);
		var resto=new String(fechadocto.substring(0,fechadocto.lastIndexOf("-")));
		var mes2= parseInt(String(resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia2= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var ano3= parseInt(String(fecha2.substring(fecha2.lastIndexOf("-")+1,fecha2.length)),10);
		var resto=new String(fecha2.substring(0,fecha2.lastIndexOf("-")));
		var mes3= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia3= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);		
		
		///////verifica si es mayor a venci
		
			if(ano2>ano1)
			oko=1;
		else
		{
			if(ano2==ano1)
				{
					if(mes2>mes1)
					{
						oko=1;
					}
					else
					{
						if(mes2==mes1)
						{
							if(dia2>dia1)
								oko=1;
							else
							{
								if(dia2==dia1)
									oko=1;
								else
									oko=0;
							}
						}
						else
							oko=0;				
					}
				}
			else
				oko=0;
		}
		
		if(!oko)
		{
			alert('ERROR: La Fecha Inicial no Puede ser Mayor a la Fecha Final');
			var regresa=fechadocto;
		}
		else
			var regresa=fecha1;
		
		return regresa;
		
		
		///////////////////////////	verifica si es menor a la de inicio
		
		if(ano2>ano1)
			ok=1;
		else
		{
			if(ano2==ano1)
				{
					if(mes2>mes1)
					{
						ok=1;
					}
					else
					{
						if(mes2==mes1)
						{
							if(dia2>dia1)
								ok=1;
							else
							{
								if(dia2==dia1)
									ok=1;
								else
									ok=0;
							}
						}
						else
							ok=0;				
					}
				}
			else
				ok=0;
		}
		
		

		if(!ok)
		{
			alert('ERROR: La Fecha Final no Puede ser Menor a la Fecha Inicial');
			var regresa=fecha1;
		}
		else
			var regresa=fechadocto;
		
		return regresa;
	}
	
	
	
	
			function ValidaFechaVen(fecha1,fecha2,fechadocto) 
	{	//fecha2 es hoy; 
		//fecha1 es de inicio
		//fechadocto es vencimiento
		//alert('validafecha("'+fecha1+'"'+fecha2+'"'+fechadocto+'")');
		var ano1= parseInt(String(fecha1.substring(fecha1.lastIndexOf("-")+1,fecha1.length)),10);
		var resto=new String(fecha1.substring(0,fecha1.lastIndexOf("-")));
		var mes1= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia1= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var ano2= parseInt(String(fechadocto.substring(fechadocto.lastIndexOf("-")+1,fechadocto.length)),10);
		var resto=new String(fechadocto.substring(0,fechadocto.lastIndexOf("-")));
		var mes2= parseInt(String(resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia2= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var ano3= parseInt(String(fecha2.substring(fecha2.lastIndexOf("-")+1,fecha2.length)),10);
		var resto=new String(fecha2.substring(0,fecha2.lastIndexOf("-")));
		var mes3= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia3= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);		
		
		
		
		
		///////verifica si es mayor a hoy
		
			if(ano3>ano2)
			oko=1;
		else
		{
			if(ano3==ano2)
				{
					if(mes3>mes2)
					{
						oko=1;
					}
					else
					{
						if(mes3==mes2)
						{
							if(dia3>dia2)
								oko=1;
							else
							{
								if(dia3==dia2)
									oko=1;
								else
									oko=0;
							}
						}
						else
							oko=0;				
					}
				}
			else
				oko=0;
		}
		
				///////////////////////////	verifica si es menor a la de inicio
		
		if(ano2>ano1)
			ok=1;
		else
		{
			if(ano2==ano1)
				{
					if(mes2>mes1)
					{
						ok=1;
					}
					else
					{
						if(mes2==mes1)
						{
							if(dia2>dia1)
								ok=1;
							else
							{
								if(dia2==dia1)
									{ok=1;}
								else
									ok=0;
							}
						}
						else
							ok=0;				
					}
				}
			else
				ok=0;
		}
		
		

		if(!ok)
		{
			alert('ERROR: La Fecha Final no Puede ser Menor a la Fecha Inicial');
			var regresa=fecha1;
		}
		else
		if(!oko)
		{
			alert('ERROR: La Fecha Final no Puede ser Mayor a la Fecha Actual');
			var regresa=fecha2;
		}
		else
			var regresa=fechadocto;
		
	//	return regresa;
		
		
		
		
		
		
		return regresa;
		
		
		///////////////////////////	verifica si es menor a la de inicio
		
		if(ano2>ano1)
			ok=1;
		else
		{
			if(ano2==ano1)
				{
					if(mes2>mes1)
					{
						ok=1;
					}
					else
					{
						if(mes2==mes1)
						{
							if(dia2>dia1)
								ok=1;
							else
							{
								if(dia2==dia1)
									{ok=1;}
								else
									ok=0;
							}
						}
						else
							ok=0;				
					}
				}
			else
				ok=0;
		}
		
		

		if(!ok)
		{
			alert('ERROR: La Fecha Final no Puede ser Menor a la Fecha Inicial');
			var regresa=fecha1;
		}
		else
			var regresa=fechadocto;
		
		return regresa;
	}