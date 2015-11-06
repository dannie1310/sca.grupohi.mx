// JavaScript Document

no_docto=1;
function agrega_ruta(itabla,ibody,ifila)
{
	 no_docto++;
	 tr=document.getElementById(ifila);
	 tabla=document.getElementById(itabla);
	 b=document.getElementById(ibody);
	 

	 tr_clonada=tr.cloneNode(true);
	 tr_clonada.style.display='block';

	 tr_clonada.cells[6].id="cell_tk"+no_docto;
	 existentes=document.getElementsByName('origen').length;
	  b.appendChild(tr_clonada);

	document.getElementsByName('origen')[existentes].id="origen"+no_docto;
	document.getElementsByName('tiro')[existentes].id="tiro"+no_docto;
	document.getElementsByName('tipo_ruta')[existentes].id="tipo_ruta"+no_docto;
	document.getElementsByName('pk')[existentes].id="pk"+no_docto;
	document.getElementsByName('ks')[existentes].id="ks"+no_docto;
	document.getElementsByName('ka')[existentes].id="ka"+no_docto;
	document.getElementsByName('tk')[existentes].id="tk"+no_docto;
	document.getElementsByName('tm')[existentes].id="tm"+no_docto;
	document.getElementsByName('tol')[existentes].id="tol"+no_docto;
	document.getElementsByName('guardar')[existentes].id="guardar"+no_docto;
	document.getElementById('ks'+no_docto).onkeyup=function(){agrega(no_docto);};
	document.getElementById('ka'+no_docto).onkeyup=function(){agrega(no_docto);};

	document.getElementById('tk'+no_docto).value=1;
	document.getElementById('ks'+no_docto).onclick=function(){this.value='';agrega(no_docto);}
	document.getElementById('ka'+no_docto).onclick=function(){this.value='';agrega(no_docto);}
	document.getElementById('guardar'+no_docto).onclick=function(){valida_registra_tarifa_material(no_docto)};
}
function valida_registra_tarifa_material(i)
{
	invalidos=0;
	
	var_origen=0;
	var_tiro=0;
	var_tipo_ruta=0;
	var_pk=1;
	var_ks=document.getElementById('ks'+i).value;
	var_ka=document.getElementById('ka'+i).value;
	var_tk=document.getElementById('tk'+i).value;
	var_tol=document.getElementById('tol'+i).value;
	var_tm=document.getElementById('tm'+i).value;
	if(document.getElementById('origen'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('origen'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('origen'+i).style.background="#CFC";
		var_origen=document.getElementById('origen'+i).value;
	}
	if(document.getElementById('tiro'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('tiro'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('tiro'+i).style.background="#CFC";
		var_tiro=document.getElementById('tiro'+i).value;
	}
	if(document.getElementById('tipo_ruta'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('tipo_ruta'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('tipo_ruta'+i).style.background="#CFC";
		var_tipo_ruta=document.getElementById('tipo_ruta'+i).value;
	}
	
	
	/*if(parseFloat(document.getElementById('ks'+i).value)==0||document.getElementById('ks'+i).value=='')
	{
		invalidos++;
		document.getElementById('ks'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('ks'+i).style.background="#CFC";
		var_ks=document.getElementById('ks'+i).value;
	}*/
	if(invalidos>0) return false;
	else
	{
		if(confirm('\u00BFEst\u00e1 seguro de registrar la ruta?'))
		{
			//alert(var_ks);
			xajax_registra_ruta(var_origen,var_tiro,var_tipo_ruta,var_pk,var_ks, var_ka, var_tk, var_tm, var_tol);	
		}
	}
	
}
function prepara_cambios_ruta(i)
{
	invalidos=0;
	try
	{
		var_ka=document.getElementById('ka'+i).value;
		var_tm=document.getElementById('tm'+i).value;
		var_tol=document.getElementById('tol'+i).value;

		
	}catch(e){
		
		}
	var_id_ruta=document.getElementById('id_ruta'+i).value;
	var_pide_cronometria=document.getElementById('pide_cronometria'+i).value;
	
	if(document.getElementById('tr'+i).value=='A99')
	{
		invalidos++;
		document.getElementById('tr'+i).style.background="#FCC";
	}
	else
	{
		
		document.getElementById('tr'+i).style.background="#CFC";
		var_tipo_ruta=document.getElementById('tr'+i).value;
	}
	
	try
	{
		if(parseFloat(document.getElementById('ks'+i).value)==0||document.getElementById('ks'+i).value=='')
		{
			invalidos++;
			document.getElementById('ks'+i).style.background="#FCC";
		}
		else
		{
			
			document.getElementById('ks'+i).style.background="#CFC";
			var_ks=document.getElementById('ks'+i).value;
		}
	}catch(e){}
	if(var_pide_cronometria==1)
	{
		if(parseFloat(document.getElementById('tol'+i).value)==0||document.getElementById('tol'+i).value=='')
		{
			invalidos++;
			document.getElementById('tol'+i).style.background="#FCC";
		}
		else
		{
			
			document.getElementById('tol'+i).style.background="#CFC";
			var_tol=document.getElementById('tol'+i).value;
		}
		if(parseFloat(document.getElementById('tm'+i).value)==0||document.getElementById('tm'+i).value=='')
		{
			invalidos++;
			document.getElementById('tm'+i).style.background="#FCC";
		}
		else
		{
			
			document.getElementById('tm'+i).style.background="#CFC";
			var_tm=document.getElementById('tm'+i).value;
		}
	}
	if(invalidos>0) return false;
	else
	{
		if(confirm('&iquest;Est&aacute; seguro de registrar los cambios en la ruta ?'))
		{
			xajax_registra_cambio_ruta(var_id_ruta,var_tipo_ruta,var_ks,var_ka,var_tm,var_tol);	
		}
	}
}
function agrega(i)
{	

  a=0.00;
	vpk=parseFloat((document.getElementById('pk'+i).value=='')?"0.00":document.getElementById('pk'+i).value);
	vks=parseFloat((document.getElementById('ks'+i).value=='')?"0.00":document.getElementById('ks'+i).value);
	vka=parseFloat((document.getElementById('ka'+i).value=='')?"0.00":document.getElementById('ka'+i).value);
	
	/*(document.getElementById('pk'+i).value=='')?document.getElementById('pk'+i).value="0":document.getElementById('pk'+i).value=document.getElementById('pk'+i).value;
	(document.getElementById('ks'+i).value=='')?document.getElementById('ks'+i).value="0":document.getElementById('ks'+i).value=document.getElementById('ks'+i).value;
	(document.getElementById('ka'+i).value=='')?document.getElementById('ka'+i).value="0":document.getElementById('ka'+i).value=document.getElementById('ka'+i).value;*/

	document.getElementById('tk'+i).value=vpk+vks+vka;
	document.getElementById('cell_tk'+i).innerHTML=vpk+vks+vka+" Km";
	//a=pk+ks+ka;
	
	return false;
}
function quita_fila(i)
{
	document.getElementById('fila_'+i).style.display='none';
}
function reestablece_fila(i)
{
	document.getElementById('fila_'+i).className='detalle';
}
function valida_elimina(i,ruta,ruta_descr)
{
	document.getElementById('fila_'+i).className='detalle_seleccionado_rojo';
	if(confirm('\u00BFEst\u00e1  seguro de eliminar la ruta: '+ruta_descr+'?'))
	{
		xajax_elimina_ruta(i,ruta)
	}
	else
	{
		document.getElementById('fila_'+i).className='detalle';	
	}
		
}