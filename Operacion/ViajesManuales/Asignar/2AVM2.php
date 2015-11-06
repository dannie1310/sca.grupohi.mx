<?php
	session_start();
	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/FuncionesViajesManuales.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	
	$MsgError="&nbsp;Falta!!!&nbsp;";
	$NumVM=$_POST["NumVM"];
	$flag=$_REQUEST[flag];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<script src="../../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="/SCA/Clases/Js/Cajas.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../../Clases/Calendario/calendar-setup.js"></script>
<script src="../../../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../../../inc/js/jquery-1.4.4.js" type="text/javascript"></script>
<link href="../../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<link href="../../../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />

<script>
	$(document).ready(function() {
		
        $("select.origen").change(function(){
			a = $(this).attr("casilla");
			id = $(this).val();
			datos = "id="+id+"&a="+a;
			$.post("tiros.php",datos,function(data){
				$("td#td_destino"+a).html(data);
				});
			});
			
			
		$(".enviar").click(function(){
			a=0;
			$('input.requerido').each(function() {
				if($(this).val()==""){
					a=a+1;
					}
				}); 
				
			$('select.requerido').each(function() {
				if($(this).val()=="A99"){
					a=a+1;
					}
				});
				
			$("input.time").each(function() {
                if($(this).val().match(/^([01][0-9]|2[0-3]):[0-5][0-9]$/)){
					a=a+0;
					}else{
						a=a+1;
						}
				
				if(a==0){
					$("form").submit();
				}else{
						alert("Llenar campos");
					}
			});
		
    });
</script>
<script type="text/javascript">

function llena_hijos2(campo,numero,f2,f1)
{

		var a1= parseInt(String(f1.substring(f1.lastIndexOf("-")+1,f1.length)),10);
		var resto=new String(f1.substring(0,f1.lastIndexOf("-")));
		var m1= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var d1= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var a2= parseInt(String(f2.substring(f2.lastIndexOf("-")+1,f2.length)),10);
		var resto=new String(f2.substring(0,f2.lastIndexOf("-")));
		var m2= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var d2= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);	

		if(a2>a1){
			//alert('Es menor que la fecha actual');
			var regresa=f1;
			}
		if(a2<a1){
				alert('La Fecha es mayor al dia de Hoy, Favor de verificar');
				var regresa=f2;
				}
		if(a2==a1){
				//alert('Año igual');
				if(m2>m1){
					//alert('Mes menor al actual');
					var regresa=f1;
					}
				if(m2<m1){
					alert('La Fecha es mayor al dia de Hoy, Favor de verificar');
					var regresa=f2;
					}
				if(m2==m1){
					//alert('Mes igual al actual');
					if(d2>d1){
						//alert('Dia menor al actual');
						var regresa=f1;
						}
					if(d2<d1){
						alert('La Fecha es mayor al dia de Hoy, Favor de verificar');
						var regresa=f2;
						}
					if(d2==d1){
						//alert('Dia igual al actual');
						var regresa=f1;
						}
					}
					
				}
		//alert(regresa);
		
		for(i=1;i<=numero;i++)
	{
		
		campo_e=campo+i;
		document.getElementById(campo_e).value=regresa;
		}
		return regresa;
}

</script>
<script type="text/javascript">
function llena_hijos(campo,numero,valor)
{
//alert(campo+numero+valor);
	for(i=1;i<=numero;i++)
	{
		campo_e=campo+i;
		document.getElementById(campo_e).value=valor;
	
	}
}
</script>
<script type="text/javascript">
function validafecha(fecha1,fecha2) 
	{	
		//fecha1 es de inicio//fecha2 es hoy; 
		//alert('validafecha("'+fecha1+'"'+fecha2+'")');
		var ano1= parseInt(String(fecha1.substring(fecha1.lastIndexOf("-")+1,fecha1.length)),10);
		var resto=new String(fecha1.substring(0,fecha1.lastIndexOf("-")));
		var mes1= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia1= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);
		
		var ano2= parseInt(String(fecha2.substring(fecha2.lastIndexOf("-")+1,fecha2.length)),10);
		var resto=new String(fecha2.substring(0,fecha2.lastIndexOf("-")));
		var mes2= parseInt((resto.substring(resto.lastIndexOf("-")+1,resto.length)),10);
		var dia2= parseInt(String(resto.substring(0,resto.lastIndexOf("-"))),10);	

		if(ano2>ano1){
			//alert('Es menor que la fecha actual');
			var regresa=fecha1;
			}
		if(ano2<ano1){
				alert('Fecha no valida');
				var regresa=fecha2;
				}
		if(ano2==ano1){
				//alert('Año igual');
				if(mes2>mes1){
					//alert('Mes menor al actual');
					var regresa=fecha1;
					}
				if(mes2<mes1){
					alert('Fecha no valida');
					var regresa=fecha2;
					}
				if(mes2==mes1){
					//alert('Mes igual al actual');
					if(dia2>dia1){
						//alert('Dia menor al actual');
						var regresa=fecha1;
						}
					if(dia2<dia1){
						alert('Fecha no valida');
						var regresa=fecha2;
						}
					if(dia2==dia1){
						//alert('Dia igual al actual');
						var regresa=fecha1;
						}
					}
				}
			
		
		return regresa;
		}
</script>

</head>

<body>
<table width="840" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  
  <tr>
    <td class="EncabezadoPagina">Modulo de Control de Acarreos.- Registro Manual de Viajes</td>
  </tr>
</table>
<form name="frm" method="post" action="3AVM.php">
<table width="859" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
  <!--<tr align="center">
    <td width="40">&nbsp;</td>
    <td width="30">&nbsp;</td>
    <td colspan="6" align="center" class="EncabezadoGlobal">CASILLAS PARA EL LLENADO DE LOS VIAJES</td>
    </tr>
    <tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="108" class="Item2"><img src="../../../Imgs/calendarp.gif" width="19" height="21" /></td>
    <td width="120" class="Item2"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" /></td>
    <td width="174" class="Item2"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" /></td>
    <td width="174" class="Item2"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
    <td width="97" colspan="2" class="Item2"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" /></td>
    </tr>-->
  <!--<tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="Casillas"><label>
      <input name="FechaGeneral" type="text" class="CasillasParaFechas" id="FechaGeneral" size="10" maxlength="10" 
       
      onChange="this.value=llena_hijos2('Fecha','<?php echo $NumVM; ?>','<?php echo date("d-m-Y"); ?>',this.value);"/>
      <img src="../../../Imgs/calendarp.gif" width="19" height="21" id="BFechaGeneral" style="cursor:hand" /></label></td>
    <td class="Casillas"><select name="EconomicoGeneral" id="EconomicoGeneral" onchange="llena_hijos('Economico','<?php echo $NumVM; ?>',document.getElementById('EconomicoGeneral').value)">
      <option>- Selecciona -</option>
      <?php
					if($flag==1)
						RegresaOpcionesDeCatalogo2(IdCamion,Economico,IdProyecto,$_SESSION["Proyecto"],camiones,$_REQUEST["Economicos".$a]);
					else
                        RegresaOpcionesDeCatalogo(IdCamion,Economico,IdProyecto,$_SESSION["Proyecto"],camiones);
                    ?>
    </select></td>
    <td class="Casillas"><select name="OrigenGeneral" id="OrigenGeneral" onchange="llena_hijos('Origen','<?php echo $NumVM; ?>',document.getElementById('OrigenGeneral').value)">
      <option>- Selecciona -</option>
      <?php
			if($flag==1)
				RegresaOpcionesDeCatalogo2(IdOrigen,Descripcion,IdProyecto,$_SESSION["Proyecto"],origenes,$_REQUEST["Origenes".$a]);
			else
                RegresaOpcionesDeCatalogo(IdOrigen,Descripcion,IdProyecto,$_SESSION["Proyecto"],origenes);
            ?>
    </select></td>
    <td class="Casillas"><select name="DestinoGeneral" id="DestinoGeneral" onchange="llena_hijos('Destino','<?php echo $NumVM; ?>',document.getElementById('DestinoGeneral').value)">
      <option>- Selecciona -</option>
      <?php
				if($flag==1)
					RegresaOpcionesDeCatalogo2(IdTiro,Descripcion,IdProyecto,$_SESSION["Proyecto"],tiros,$_REQUEST["Destinos".$a]);
				else
                    RegresaOpcionesDeCatalogo(IdTiro,Descripcion,IdProyecto,$_SESSION["Proyecto"],tiros);
                ?>
    </select></td>
    <td colspan="2" class="Casillas"><select name="MaterialGeneral" id="MaterialGeneral" onchange="llena_hijos('Material','<?php echo $NumVM; ?>',document.getElementById('MaterialGeneral').value)">
      <option>- Selecciona -</option>
      <?php
					if($flag==1)
						RegresaOpcionesDeCatalogo2(IdMaterial,Descripcion,IdProyecto,$_SESSION["Proyecto"],materiales,$_REQUEST["Materiales".$a]);
					else
                        RegresaOpcionesDeCatalogo(IdMaterial,Descripcion,IdProyecto,$_SESSION["Proyecto"],materiales);
                    ?>
    </select></td>
  </tr>-->
  <tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <!--<tr align="center">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img src="../../../Imgs/calendarp.gif" width="19" height="21" /></td>
    <td><img src="../../../Imgs/16-Bus.gif" width="16" height="16" /></td>
    <td><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" /></td>
    <td><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
    <td colspan="2"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" /></td>
    </tr>-->
    
  <tr>
    <td class="EncabezadoTabla">&nbsp;</td>
    <!--<td class="EncabezadoTabla">#</td>-->
    <td class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Hora</td>
    <td class="EncabezadoTabla">Econ&oacute;mico</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Destino</td>
    <td class="EncabezadoTabla">Material</td>
    <!--<td class="EncabezadoTabla">Turno</td>-->
    </tr>
  
  <?php
  	for($a=1;$a<=$NumVM;$a++)
	{
  ?>
  <tr class="FondoCasillas">
    <td valign="top">&nbsp;<?php echo $a; ?>&nbsp;</td>
    <!--<td align="center" valign="top">
    	<span id="spryNVM<?php echo $a; ?>">
      		<input value="1" class="CasillasParaFechas" align="right" name="NVM<?php echo $a; ?>" type="hidden" id="NVM<?php echo $a; ?>"/>
        <span class="textfieldRequiredMsg"><?php echo $MsgError;?></span></span>    </td>-->
    <td align="center" valign="top">&nbsp;<input name="Fecha<?php echo $a; ?>" type="text" class="CasillasParaFechas" id="Fecha<?php echo $a; ?>" size="10" maxlength="10" <?php if($flag==1) {?>value="<?php echo fecha($_REQUEST["Fechas".$a]); ?>"<?php } else {?>value="<?php echo date("d-m-Y"); ?>" <?php }?> onChange='this.value=validafecha(this.value,"<?php echo date("d-m-Y"); ?>");'/>&nbsp;<img src="../../../Imgs/calendarp.gif" id="IFecha<?php echo $a; ?>" width="19" height="21" align="absbottom" style="cursor:hand" />    </td>
    <td><input size="5" maxlength="5" type="text" class="requerido time" name="Hora<?php echo $a; ?>" id="Hora<?php echo $a; ?>" <?php if($flag==1) {?>value="<?php echo $_REQUEST["Horas".$a]; ?>"<?php } else {?>value="<?php echo date('H:i');?>" <?php }?>></td>
    <td align="center">
    	<span id="spryEconomico<?php echo $a; ?>">
      		<select name="Economico<?php echo $a; ?>" id="Economico<?php echo $a; ?>" class="requerido">
            	<option value="A99">- Selecciona -</option>
                    <?php
					if($flag==1)
						RegresaOpcionesDeCatalogo2(IdCamion,Economico,IdProyecto,$_SESSION["Proyecto"],camiones,$_REQUEST["Economicos".$a]);
					else
                        RegresaOpcionesDeCatalogo(IdCamion,Economico,IdProyecto,$_SESSION["Proyecto"],camiones);
                    ?>
      		</select>
      	<span class="selectRequiredMsg"><?php echo $MsgError;?></span></span>    </td>
    <td align="center">
        <span id="spryOrigen<?php echo $a; ?>">
          <select name="Origen<?php echo $a; ?>" id="Origen<?php echo $a; ?>" casilla="<?php echo $a; ?>" class="origen requerido">
            <option value="A99">- Selecciona -</option>
            <?php
			if($flag==1)
				RegresaOpcionesDeCatalogo2(IdOrigen,Descripcion,IdProyecto,$_SESSION["Proyecto"],origenes,$_REQUEST["Origenes".$a]);
			else
                RegresaOpcionesDeCatalogo(IdOrigen,Descripcion,IdProyecto,$_SESSION["Proyecto"],origenes);
            ?>
          </select>
        <span class="selectRequiredMsg"><?php echo $MsgError;?></span></span>    </td>
    <td align="center" id="td_destino<?php echo $a; ?>">
    	<span id="spryDestino<?php echo $a; ?>">
      		<select name="Destino<?php echo $a; ?>" id="Destino<?php echo $a; ?>" class="requerido">
            	<option value="A99">- Selecciona -</option>
				<?php
				if($flag==1)
					RegresaOpcionesDeCatalogo2(IdTiro,Descripcion,IdProyecto,$_SESSION["Proyecto"],tiros,$_REQUEST["Destinos".$a]);
				else
                    RegresaOpcionesDeCatalogo(IdTiro,Descripcion,IdProyecto,$_SESSION["Proyecto"],tiros);
                ?>
      		</select>
      	<span class="selectRequiredMsg"><?php echo $MsgError;?></span></span>    </td>
    <td align="center">
        <span id="spryMaterial<?php echo $a; ?>">
          <select name="Material<?php echo $a; ?>" id="Material<?php echo $a; ?>" class="requerido">
            <option value="A99">- Selecciona -</option>
                    <?php
					if($flag==1)
						RegresaOpcionesDeCatalogo2(IdMaterial,Descripcion,IdProyecto,$_SESSION["Proyecto"],materiales,$_REQUEST["Materiales".$a]);
					else
                        RegresaOpcionesDeCatalogo(IdMaterial,Descripcion,IdProyecto,$_SESSION["Proyecto"],materiales);
                    ?>
          </select>
          <span class="selectRequiredMsg"><?php echo $MsgError;?></span></span>    </td>
    <!--<td align="center"><input name="Turno<?php echo $a; ?>" type="radio" value="M" <?php if($_REQUEST["Turno".$a]=='M'||$_REQUEST["Turno".$a]==''){?>checked="checked"<?php } ?>  />M<input name="Turno<?php echo $a; ?>" type="radio" value="V" <?php if($_REQUEST["Turno".$a]=='V'){?>checked="checked"<?php } ?> />V</td>-->
  </tr>
  <tr class="FondoCasillas">
    <td colspan="2" valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td class="Item2" align="right">Observaciones:</td>
    <td colspan="4">
    	<span id="spryObservacion<?php echo $a; ?>">
      		<input onKeyPress="withoutSpaces(event,'decOK')" <?php if($flag==1) {?>value="<?php echo $_REQUEST["Observacion".$a]; ?>"<?php }?> name="Observacion<?php echo $a; ?>" type="text" id="Observacion<?php echo $a; ?>" class="CasillasParaObservaciones" size="85" maxlength="85" />
   	  <span class="textfieldRequiredMsg"><?php echo $MsgError;?></span></span>    </td>
  </tr>
  <?php
  	}
  ?>
  <tr>
    <td colspan="8" align="right">
      <input type="hidden" name="NumVM" id="NumVM" value="<?php echo $NumVM; ?>"/>
      <input name="reset" type="reset" class="boton" id="reset" value="Limpiar Casillas" />
      <input name="Registrar" type="button" class="boton enviar" id="Registrar" value="Registrar" />    </td>
    </tr>
</table>
</form>


<!--<script type="text/javascript">
<!--
<?php
	for($a=1;$a<=$NumVM;$a++)
	{
		echo 'var spryOrigen'.$a.' = new Spry.Widget.ValidationSelect("spryOrigen'.$a.'");';
		echo 'var spryDestino'.$a.' = new Spry.Widget.ValidationSelect("spryDestino'.$a.'");';
		echo 'var spryMaterial'.$a.' = new Spry.Widget.ValidationSelect("spryMaterial'.$a.'");';
		echo 'var spryEconomico'.$a.' = new Spry.Widget.ValidationSelect("spryEconomico'.$a.'");';
		echo 'var spryObservacion'.$a.' = new Spry.Widget.ValidationTextField("spryObservacion'.$a.'");';
		echo 'var spryNVM'.$a.' = new Spry.Widget.ValidationTextField("spryNVM'.$a.'");';
	}	
?>


function catcalc(cal) 
	{
	}
		Calendar.setup({
		inputField     :    "FechaGeneral",			
		button		   :	"BFechaGeneral",
		ifFormat       :    "%d-%m-%Y",       
		showsTime      :    false,
		timeFormat     :    "24",
		onUpdate       :    catcalc
			});
</script>-->

</script>
<?php
	for($a=1;$a<=$NumVM;$a++)
	{
?>
<script type="text/javascript">
function catcalc(cal) 
	{
	}
		Calendar.setup({
		inputField     :    "Fecha<?php echo $a; ?>",			
		button		   :	"IFecha<?php echo $a; ?>",
		ifFormat       :    "%d-%m-%Y",       
		showsTime      :    false,
		timeFormat     :    "24",
		onUpdate       :    catcalc
			});
</script>
<?php
	}
?>
</body>
</html>
