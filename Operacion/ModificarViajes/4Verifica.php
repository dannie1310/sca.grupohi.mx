<?php   session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }?>
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
    <td class="Subtitulo" >VERIFIQUE QUE LA INFORMACI&Oacute;N A MODIFICAR SEA CORRECTA. </td>
  </tr>
</table>
<form name="frm" action="5Actualiza.php" method="post">
<?php if($tipo==0)
{ ?>
<table  width="700" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" class="EncabezadoTabla">No.</td>
    <td width="15%" class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Destino</td>
    <td width="15%" class="EncabezadoTabla">Camión</td>
    <td  class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  $totalselect=0;
  for($i=0;$i<$total;$i++)
	{
	
  ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresaf(viajesnetos,FechaLlegada,IdViajeNeto,$_REQUEST[viaje."$i"]); ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(origenes,Descripcion,IdOrigen,regresah(origenes,$i,r)); regresah(origenes,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(tiros,Descripcion,IdTiro,regresah(tiros,$i,r)); regresah(tiros,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(camiones,Economico,IdCamion,regresah(camiones,$i,r)); regresah(camiones,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(materiales,Descripcion,IdMaterial,regresah(materiales,$i,r)); regresah(materiales,$i,sh)?>
      <label>
      <input type="hidden" name="viaje<?php echo $i; ?>" value='<?php echo $_REQUEST[viaje."$i"]; ?>' id="hiddenField8" />
      </label></td></tr>
  <?php $totalselect++; $co++;
  }?>
  <tr>
    <td colspan="6" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input name="button" type="button" onclick="document.regresa.submit()" class="boton" id="button" value="Regresar" />
      <input type="hidden" name="total" id="hiddenField4" value="<?php echo $total; ?>" /></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input name="input3"  class="boton"type="submit" value="Modificar" /></td>
  </tr>
</table>
<?php } else ?>

<?php if($tipo==10)
{ ?>
<table  width="700" align="center">
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" class="EncabezadoTabla">No.</td>
    <td width="15%" class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Destino</td>
    <td width="15%" class="EncabezadoTabla">Camión</td>
    <td class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  for($i=0;$i<$total;$i++)
	{ 
  ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresaf(viajesnetos,FechaLlegada,IdViajeNeto,$_REQUEST[viaje."$i"]); ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(tiros,Descripcion,IdTiro,regresah(tiros,$i,r)); regresah(tiros,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(camiones,Economico,IdCamion,regresah(camiones,$i,r)); regresah(camiones,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(materiales,Descripcion,IdMaterial,regresah(materiales,$i,r)); regresah(materiales,$i,sh)?>
      <label>
      <input type="hidden" name="viaje<?php echo $i; ?>" value='<?php echo $_REQUEST[viaje."$i"]; ?>' id="hiddenField7" />
      </label></td>
  </tr>
  <?php $co++;
  }?>
  <tr>
    <td colspan="5" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><input name="button3" type="button" onclick="document.regresa.submit()" class="boton" id="button3" value="Regresar" />
      <input type="hidden" name="total" id="hiddenField3" value="<?php echo $total; ?>" /></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input name="input"  class="boton"type="submit" value="Modificar" /></td>
  </tr>
</table>
<?php } else ?>

<?php if($tipo==20)
{ ?>
<table  width="750" align="center">
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr>
    <td width="6%" class="EncabezadoTabla">No.</td>
    <td width="20%" class="EncabezadoTabla">Fecha</td>
    <td  class="EncabezadoTabla">Origen</td>
    <td  class="EncabezadoTabla">Destino</td>
    <td width="15%" class="EncabezadoTabla">Camión</td>
    <td  class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  $co=1;
  for($i=0;$i<$total;$i++)
	{
 ?>
  <tr >
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><label>
      <?php regresah(fecha,$i,e) ?>
    </label>     </td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(origenes,Descripcion,IdOrigen,regresah(origenes,$i,r)); regresah(origenes,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(tiros,Descripcion,IdTiro,regresah(tiros,$i,r)); regresah(tiros,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(camiones,Economico,IdCamion,regresah(camiones,$i,r)); regresah(camiones,$i,sh) ?></td>
    <td align="center" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php regresa(materiales,Descripcion,IdMaterial,regresah(materiales,$i,r)); regresah(materiales,$i,sh)?>
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
    <td colspan="2" align="left"><input name="button4" type="button" onclick="document.regresa.submit()" class="boton" id="button4" value="Regresar" />
      <input type="hidden" name="total" id="hiddenField2" value="<?php echo $total; ?>" /></td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right"><input name="input2"  class="boton"type="submit" value="Modificar" /></td>
  </tr>
</table>
<?php } ?>
<input type="hidden" name="tipo" value="<?php echo $tipo; ?>" id="hiddenField" />
<input type="hidden" name="ori" value="<?php echo $ori;?>" id="hiddenField" />
</form>
<table width="700" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><form action="3Edita.php" method="post" name="regresa" id="regresa">
      <input type="hidden" name="total" id="hiddenField5" value="<?php echo $total; ?>" />
      <input type="hidden" name="tipo" value="<?php echo $tipo; ?>" id="hiddenField" />
      <input type="hidden" name="ori" value="<?php echo $ori;?>" id="hiddenField" />
      <input type="hidden" name="flag" value="1" id="hiddenField" />
      <?php for($i=0;$i<$total;$i++)
	{
 
 regresah(fecha,$i,sh);
 regresah(origenes,$i,sh);
 regresah(tiros,$i,sh);
 regresah(camiones,$i,sh);
 regresah(materiales,$i,sh);
 regresah(viaje,$i,sh);
  
  }?>
    </form></td>
  </tr>
  <tr> </tr>
</table>
</body>
</html>
