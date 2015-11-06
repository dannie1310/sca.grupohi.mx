// JavaScript Document

function valida(form,msg)
{
	invalidos=0;
	for(i=0;i<document.getElementById(form).length;i++)	
	{
		if(document.getElementById(form)[i].style.display!='none'&&document.getElementById(form)[i].type!="button"&&document.getElementById(form)[i].type!="submit"&&document.getElementById(form)[i].type!="reset"&&document.getElementById(form)[i].type!="hidden")
		{
			if((document.getElementById(form)[i].value==''||document.getElementById(form)[i].value=='A99'))
			{
				invalidos++;
				document.getElementById(form)[i].style.background="#FCC";
			}
			else
			{
				if(document.getElementById(form)[i].type=='text'||document.getElementById(form)[i].type=='textarea')
				{
					var longitud_valor=document.getElementById(form)[i].value.length;
					var apariciones_blancos=0;
					for(opp=0;opp<longitud_valor;opp++)
					{
						if(document.getElementById(form)[i].value.substring(opp,opp+1)==' ')
						{
							apariciones_blancos++;
						}
					}
					if(apariciones_blancos==longitud_valor)
					{
						document.getElementById(form)[i].style.background="#FCC";
						invalidos++;

					}
					else
					{
						document.getElementById(form)[i].style.background="#CFC";
					}
				}
				else
				{
					document.getElementById(form)[i].style.background="#CFC";
				}
			}
		}
	}
	if(invalidos>0)
	return false;
	else
	{
	if(confirm(msg))
	return true;
	else
	return false
	}
}


