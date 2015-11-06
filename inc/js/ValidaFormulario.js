// JavaScript Document
function inicializa_color_frm(form)
{
	
	for(i=0;i<document.getElementById(form).length;i++)	
	{
		if(document.getElementById(form)[i].style.background=="#FCC"||document.getElementById(form)[i].style.background=="#CFC"||document.getElementById(form)[i].style.background=="#fcc"||document.getElementById(form)[i].style.background=="#cfc")
		{
			document.getElementById(form)[i].style.background="#e8f9ff";
		}
	}
}
	
function valida_actividad(form,msg)
{
	invalidos=0;
	for(i=0;i<document.getElementById(form).length;i++)	
	{
if(document.getElementById(form)[i].style.display!='none'&&document.getElementById(form)[i].type!="button"&&document.getElementById(form)[i].type!="radio"&&document.getElementById(form)[i].type!="checkbox"&&document.getElementById(form)[i].type!="submit"&&document.getElementById(form)[i].type!="reset"&&document.getElementById(form)[i].type!="hidden"&&document.getElementById(form)[i].id!="actividad_pre"&&document.getElementById(form)[i].id!="responsable1"&&document.getElementById(form)[i].id!="involucrado1"&&document.getElementById(form)[i].id!="fo1"&&document.getElementById(form)[i].id!="observaciones1"&&document.getElementById(form)[i].id!="fp1"&&document.getElementById(form)[i].id!="planb1"&&document.getElementById(form)[i].id!="responsable_asignado"&&document.getElementById(form)[i].id!="responsable"&&document.getElementById(form)[i].id!="involucrado_asignado"&&document.getElementById(form)[i].id!="involucrado"&&document.getElementById(form)[i].id!="observaciones"&&document.getElementById(form)[i].id!="planb")		{
			if(document.getElementById(form)[i].id=="correos")
			{
				try{
				if(document.getElementById("por_correo").checked==true&&document.getElementById(form)[i].value=='')
				{
					invalidos++;
					document.getElementById(form)[i].style.background="#FCC";
				}
				else
				{
					document.getElementById(form)[i].style.background="#e8f9ff";
				}
				}
				catch(e)
				{
					
				}
			}
			else
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
	}
	if(invalidos>0)
	return false;
	else
	{
		if(msg!='')
		{
			if(confirm(msg))
				return true;
			else
				return false
		}
		else
			return true;
	}
}	

function valida(form,msg)
{
	invalidos=0;
	for(i=0;i<document.getElementById(form).length;i++)	
	{
		if(document.getElementById(form)[i].style.display!='none'&&document.getElementById(form)[i].type!="button"&&document.getElementById(form)[i].type!="radio"&&document.getElementById(form)[i].type!="checkbox"&&document.getElementById(form)[i].type!="submit"&&document.getElementById(form)[i].type!="reset"&&document.getElementById(form)[i].type!="hidden"&&document.getElementById(form)[i].id!="enlace"&&document.getElementById(form)[i].id!="estados"&&document.getElementById(form)[i].id!="tag_nuevo"&&document.getElementById(form)[i].id!="idGrupo"&&document.getElementById(form)[i].id!="correos"&&document.getElementById(form)[i].id!="correos_asignados"&&document.getElementById(form)[i].id!="destinatarios_disponibles")
		{
			if(document.getElementById(form)[i].id=="correos")
			{
				try{
				if(document.getElementById("por_correo").checked==true&&document.getElementById(form)[i].value=='')
				{
					invalidos++;
					document.getElementById(form)[i].style.background="#FCC";
				}
				else
				{
					document.getElementById(form)[i].style.background="#e8f9ff";
				}
				}
				catch(e)
				{
					
				}
			}
			else
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
	}
	if(invalidos>0)
	return false;
	else
	{
		if(msg!='')
		{
			if(confirm(msg))
				return true;
			else
				return false
		}
		else
			return true;
	}
}
