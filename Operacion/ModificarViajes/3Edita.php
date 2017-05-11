<?php   session_start(); 
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
</head>
<script type="text/javascript" src="../../Clases/Calendario/calendar.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-es.js"></script>
<script type="text/javascript" src="../../Clases/Calendario/calendar-setup.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<link href="../../Clases/Calendario/calendar-blue2.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>

<body onkeydown="backspace();">
<?php 
	//Incluimos los Archivos a Usar
		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/Catalogos/Genericas.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");
		include("../../Clases/Funciones/FuncionesModificaViajes.php");
		
		$total=$_REQUEST[total];
		$tipo=$_REQUEST[tipo];
		$ori=$_REQUEST[ori];
		$flag=$_REQUEST[flag];
		//echo "t: ".$total;
		
?>
<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/Logos/Gral/24-tag-manager.png" alt="" width="24" height="24" align="absbottom" />SCA.- Modificaci&oacute;n de Viajes <?php title($tipo)?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> </tr>
</table>
<form name="frm" action="4Verifica.php" method="post">
<?php if($tipo==0)
{ ?>
<table  width="700" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="4%" class="EncabezadoTabla">No.</td>
    <td width="12%" class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Destino</td>
    <td width="10%" class="EncabezadoTabla">Cami&oacute;n</td>
    <td  class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  $totalselect=0;
  for($i=0;$i<$total;$i++)
	{
	if($_REQUEST[viaje."$i"]!="")
	{
  ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresaf(viajesnetos,FechaLlegada,IdViajeNeto,$_REQUEST[viaje."$i"]); ?></td>

    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>">
    <?php
      if($flag!=1)
        //regresa(origenes,Descripcion,IdOrigen,regresav(viajesnetos,IdOrigen,IdViajeNeto,$_REQUEST[viaje."$i"]));
        $parametro=regresav(viajesnetos,IdOrigen,IdViajeNeto,$_REQUEST[viaje."$i"]);
      else
        $parametro=$_REQUEST[origenes."$i"];
        comboSelectedN(origenes,Descripcion,IdOrigen,$parametro,$totalselect);
      ?>
    </td>

    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>">
    <?php   	
	     if($flag!=1)
        $parametro=regresav(viajesnetos,IdTiro,IdViajeNeto,$_REQUEST[viaje."$i"]);
	     else
	         $parametro=$_REQUEST[tiros."$i"];
	       comboSelectedN(tiros,Descripcion,IdTiro,$parametro,$totalselect);
      ?>  
    </td>

    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>">
    <?php   
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdCamion,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[camiones."$i"];
	
	comboSelectedN(camiones,Economico,IdCamion,$parametro,$totalselect);?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php 
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdMaterial,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[materiales."$i"];
	  comboSelectedN(materiales,Descripcion,IdMaterial,$parametro,$totalselect);?>      <label>
      <input type="hidden" name="viaje<?php echo $totalselect; ?>" value='<?php echo $_REQUEST[viaje."$i"]; ?>' id="hiddenField5" />
    </label></td>
  </tr>
  <?php $totalselect++; $co++;}
  }?>
  <tr>
    <td colspan="6" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input type="hidden" name="total" id="hiddenField4" value="<?php echo $totalselect; ?>" />
     <input name="button2" type="button" onclick="document.regresa.submit()" class="boton" id="button2" value="Regresar" /></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input name="input3"  class="boton"type="submit" value="Modificar" /></td>
  </tr>
</table>
<?php } else ?>

<?php if($tipo==10)
{ ?>
<table  width="600" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" class="EncabezadoTabla">No.</td>
    <td width="15%" class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Destino</td>
    <td width="10%" class="EncabezadoTabla">Cami&oacute;n</td>
    <td class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  $totalselect=0;
  for($i=0;$i<$total;$i++)
	{
	if($_REQUEST[viaje."$i"]!="")
	{
  ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresaf(viajesnetos,FechaLlegada,IdViajeNeto,$_REQUEST[viaje."$i"]); ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php   
	
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdTiro,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[tiros."$i"];
	comboSelectedN(tiros,Descripcion,IdTiro,$parametro,$totalselect);
	?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php   
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdCamion,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[camiones."$i"];
	
	comboSelectedN(camiones,Economico,IdCamion,$parametro,$totalselect);?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php 
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdMaterial,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[materiales."$i"];
	  comboSelectedN(materiales,Descripcion,IdMaterial,$parametro,$totalselect);?>
      <input type="hidden" name="viaje<?php echo $totalselect; ?>" value='<?php echo $_REQUEST[viaje."$i"]; ?>' id="hiddenField5" /></td>
  </tr>
  <?php $totalselect++; $co++;}
  }?>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input type="hidden" name="total" id="hiddenField3" value="<?php echo $totalselect; ?>" />
     <input name="button2" type="button" onclick="document.regresa.submit()" class="boton" id="button2" value="Regresar" /></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input name="input"  class="boton"type="submit" value="Modificar" /></td>
  </tr>
</table>
<?php } else ?>

<?php if($tipo==20)
{ ?>
<table  width="780" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" class="EncabezadoTabla">No.</td>
    <td width="20%" class="EncabezadoTabla">Fecha</td>
    <td  class="EncabezadoTabla">Origen</td>
    <td  class="EncabezadoTabla">Destino</td>
    <td width="15%" class="EncabezadoTabla">Cami&oacute;n</td>
    <td  class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  $totalselect=0;
  for($i=0;$i<$total;$i++)
	{
	if($_REQUEST[viaje."$i"]!="")
	{
  ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><label>
      <input name="fecha<?php echo $i; ?>" type="text" class="CasillasParaFechas" id="fecha<?php echo $i; ?>" value="<?php if ($flag!=1) regresaf(viajesnetos,FechaLlegada,IdViajeNeto,$_REQUEST[viaje."$i"]);  else  echo $_REQUEST[fecha."$i"];?>" size="10" />
    </label>
      <img src="/SCA/Imgs/calendarp.gif" id="bfecha<?php echo $i; ?>" width="15" height="16" style="cursor:hand" /></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php   
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdOrigen,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[origenes."$i"];
	comboSelectedN(origenes,Descripcion,IdOrigen,$parametro,$totalselect);?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php   
	
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdTiro,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[tiros."$i"];
	comboSelectedN(tiros,Descripcion,IdTiro,$parametro,$totalselect);
	?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php   
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdCamion,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[camiones."$i"];
	
	comboSelectedN(camiones,Economico,IdCamion,$parametro,$totalselect);?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php 
	if($flag!=1)
	$parametro=regresav(viajesnetos,IdMaterial,IdViajeNeto,$_REQUEST[viaje."$i"]);
	else
	$parametro=$_REQUEST[materiales."$i"];
	  comboSelectedN(materiales,Descripcion,IdMaterial,$parametro,$totalselect);?>
      <input type="hidden" name="viaje<?php echo $totalselect; ?>" value='<?php echo $_REQUEST[viaje."$i"]; ?>' id="hiddenField5" /></td>
  </tr>
  <?php $totalselect++; $co++;}
  }?>
  <tr>
    <td colspan="6" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input type="hidden" name="total" id="hiddenField2" value="<?php echo $totalselect; ?>" />
     <input name="button2" type="button" onclick="document.regresa.submit()" class="boton" id="button2" value="Regresar" /></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input name="input2"  class="boton"type="submit" value="Modificar" /></td>
  </tr>
</table>

<?php
	for($a=0;$a<$totalselect;$a++)
	{
?>
<script type="text/javascript">
function catcalc(cal) 
	{
	}
		Calendar.setup({
		inputField     :    "fecha<?php echo $a; ?>",			
		button		   :	"bfecha<?php echo $a; ?>",
		ifFormat       :    "%d-%m-%Y",       
		showsTime      :    false,
		timeFormat     :    "24",
		onUpdate       :    catcalc
			});
</script>
<?php
	}
?>

<?php } ?>
<input type="hidden" name="tipo" value="<?php echo $tipo; ?>" id="hiddenField" />
<input type="hidden" name="ori" value="<?php echo $ori;?>" id="hiddenField" />
</form>
<table width="700" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">
        <form action="2MuestraDatos.php" method="post" name="regresa" id="regresa">
          <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" id="hiddenField" />
          <input type="hidden" name="ori" value="<?php echo $ori;?>" id="hiddenField" />
          <input type="hidden" name="flag" value="1" id="hiddenField" />
         
        </form>      </td>
  </tr>
  <tr> </tr>
</table>


</body>
</html>
