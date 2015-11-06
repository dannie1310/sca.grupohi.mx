<?php 
	session_start();
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Catalogos/Genericas.php");

	$IdProyecto=$_SESSION['Proyecto'];
	$fecha=$_REQUEST[fecha];
	$tiro=$_REQUEST[tiro];
	$tipo=$_REQUEST[tipo];
	
	$numero=$_REQUEST[numero];
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 

	$link=SCA::getConexion();
	$sql="Select format(sum(Importe),2) as Importe, sum(Importe) as Importesc,  count(IdViaje) as Viajes from viajes where IdTiro=".$tiro." and FechaLlegada='".$fecha."'";
	$r=$link->consultar($sql);
	$v=mysql_fetch_array($link->consultar($sql));
?>
<table width="500" border="0" align="center" >
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="71" class="EncabezadoTabla">FECHA</td>
    <td width="264" class="EncabezadoTabla">TIRO</td>
    <td width="82" class="EncabezadoTabla">NO. VIAJES </td>
    <td width="65" class="EncabezadoTabla">IMPORTE</td>
  </tr>
  <tr class="Item1">
    <td><?php echo fecha($fecha); ?></td>
    <td><?php echo regresa(Tiros,Descripcion,IdTiro,$tiro); ?></td>
    <td align="right"><?php echo $v[Viajes]; ?></td>
    <td align="right">$ <?php echo $v[Importe]; ?></td>
  </tr>
 
</table>
<table width="400" border="0" align="center" >
<form name="frm" action="3SolicitaCentros.php" method="post">

  <tr>
    <td colspan="4" class="Subtitulo">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="Subtitulo">INDIQUE EL TIPO DE ASIGNACI&Oacute;N</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr >
    <td width="159" class="Concepto">No. Centros Costo:</td>
    <td width="133">
	<select name="numero" onChange="if(this.value==1)this.form.submit();else if(this.value=='A99')document.frme.envia.disabled=1; else if(this.value!='A99')document.frme.envia.disabled=0;">
	   <option value="A99">- SELECCIONE -</option>
	<?php for($i=1;$i<=20;$i++) { ?>
      <option <?php if($numero==$i) echo "selected" ?> value="<?PHP echo $i; ?>"><?PHP  echo $i; ?></option>
	<?php }?>
    </select>
	</td>
    <td width="15" align="right">&nbsp;</td>
    <td width="75" align="right">&nbsp;</td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
 
  <tr >
    <td rowspan="2" class="ConceptoTop">Tipo de Asignaci&oacute;n:</td>
    <td class="Item1"><input name="tipoa" type="radio" value="1" <?php if($tipo==1||$tipo=='') echo "checked" ?> >
    POR VIAJES</td>
    <td colspan="2" align="right">
	  <input type="hidden" value="<?php echo $v[Viajes]; ?>" name="totalviajes">
	  <input type="hidden" value="<?php echo $v[Importesc]; ?>" name="importe">
	  <input type="hidden" value="<?php echo $tiro; ?>" name="tiro">
      <input type="hidden" value="<?php echo $fecha; ?>" name="fecha"></td>
    </tr>
  
   <tr >
    <td class="Item1"><input name="tipoa" type="radio" <?php if($tipo==2) echo "checked" ?> value="2"> 
     POR IMPORTE</td>
    <td colspan="2" align="right">&nbsp;</td>
    </tr>
   <tr >
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td align="right">&nbsp;</td>
     <td align="right">&nbsp;</td>
   </tr>
   </form>
   <tr >
    <td>&nbsp;</td>
    <td>
	<form name="regresa" action="1MuestraTiros.php" method="post">
		<input name="Submit" type="submit" class="boton" value="Regresar">	 
	 	<input type="hidden" value="<?php echo $tiro; ?>" name="tiro">
     	<input type="hidden" value="<?php echo $fecha; ?>" name="fecha">
	 </form>
	  </td>
    <td colspan="2" align="right"><form name="frme"><input name="envia" <?php if($numero>0) echo ""; else echo "disabled"; ?> type="button" onClick="document.frm.submit()" class="boton" value="Continuar"></form></td>
    </tr>
</table>

</body>
</html>
