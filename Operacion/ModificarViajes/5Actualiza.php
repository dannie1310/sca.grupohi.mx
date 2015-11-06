<?php   session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
</head>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>

<body onkeydown="backspace();">
<?php 

	
	//Incluimos los Archivos a Usar
		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/Catalogos/Genericas.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");
		include("../../Clases/Funciones/FuncionesModificaViajes.php");
		
		$total=$_REQUEST[total];
		//echo '$t: '.$total;
		$tipo=$_REQUEST[tipo];
		$ori=$_REQUEST[ori];
		

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
<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">LOS DATOS DEL VIAJE HAN SIDO MODIFICADOS EXITOSAMENTE</td>
  </tr>
</table>
<table  width="700" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" class="EncabezadoTabla">No.</td>
    <td width="20%" class="EncabezadoTabla">Fecha</td>
    <?php if($tipo!=10) { ?><td  class="EncabezadoTabla">Origen</td> <?php } ?>
    <td  class="EncabezadoTabla">Destino</td>
    <td width="15%" class="EncabezadoTabla">Camión</td>
    <td  class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  for($i=0;$i<$total;$i++)
	{ 
		if($tipo==0||$tipo==10)
		{
			$campos=array(0=>"IdTiro",1=>"IdCamion",2=>"IdMaterial");
			$datos=array(0=>regresah(tiros,$i,r),1=>regresah(camiones,$i,r),2=>regresah(materiales,$i,r));
		}
		else
		{
			$campos=array(0=>"FechaLlegada",1=>"IdCamion",2=>"IdOrigen",3=>"IdTiro",4=>"IdMaterial");
			$datos=array(0=>fecha(regresah(fecha,$i,r)),1=>regresah(camiones,$i,r),2=>regresah(origenes,$i,r),3=>regresah(tiros,$i,r),4=>regresah(materiales,$i,r));
		}
		
	actualizavarios(viajesnetos,IdViajeNeto,$_REQUEST[viaje."$i"],$campos,$datos)
 ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><label>
      <?php  regresaf(viajesnetos,FechaLlegada,IdViajeNeto,$_REQUEST[viaje."$i"]); ?>
    </label>
     </td>
    <?php if($tipo!=10) { ?> <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(origenes,Descripcion,IdOrigen,regresav(viajesnetos,IdOrigen,IdViajeNeto,$_REQUEST[viaje."$i"])); ?></td><?php } ?>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(tiros,Descripcion,IdTiro,regresav(viajesnetos,IdTiro,IdViajeNeto,$_REQUEST[viaje."$i"]));  ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(camiones,Economico,IdCamion,regresav(viajesnetos,IdCamion,IdViajeNeto,$_REQUEST[viaje."$i"])); ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(materiales,Descripcion,IdMaterial,regresav(viajesnetos,IdMaterial,IdViajeNeto,$_REQUEST[viaje."$i"])); ?>
    <label>
    <input type="hidden" name="viaje<?php echo $i; ?>" value='<?php echo $_REQUEST[viaje."$i"]; ?>' id="hiddenField6" />
    </label></td>
  </tr>
  <?php $co++;
  }?>
  <tr>
    <td colspan="6" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="right"><input type="hidden" name="total" id="hiddenField2" value="<?php echo $total; ?>" /></td>
  </tr>
</table>

<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><form action="1EligeViajes.php" method="post" name="regresa" id="regresa">
      <input name="button2" type="submit" class="boton" id="button2" value="Modificar Otros Viajes" />
    </form></td>
  </tr>
  <tr> </tr>
</table>
</body>
</html>
