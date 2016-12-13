<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<body>
<table align="center" width="845" border="0">
  <tr>
    <td width="600" class="EncabezadoPagina"><img src="../../../Imgs/16-empresas.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Empresas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$razonSocial=strtoupper($_REQUEST[razonSocial]);
	$RFC=strtoupper($_REQUEST[RFC]);
	$estatus=$_REQUEST[estatus];
	$empresa=$_REQUEST[empresa];
	$link=SCA::getConexion();
	
	$equal="Select * from empresas where (razonSocial='".$razonSocial."' or RFC='".$RFC."') and Idempresa!=".$empresa."";
	//echo $equal;
	$link->consultar($equal);
	$eq=$link->affected();
	//echo $eq;
if($eq>0)
{
?>


<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">YA EXISTE UNA EMPRESA CON ESA RAZ&Oacute;N SOCIAL Y/O RFC</td>
  </tr>
</table>

 <table width="600" border="0" align="center">
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="35" class="EncabezadoTabla">#</td>
    <td class="EncabezadoTabla">Raz&oacute;n Social</td>
    <td class="EncabezadoTabla">RFC</td>
    <td width="79" colspan="2" class="EncabezadoTabla">ESTATUS</td>
   </tr>
 
  <?php
 

	//echo $sql;
  
  
  if($estatus==0)
  $Estatus="INACTIVO";
  else 
  if($estatus==1)
  $Estatus="ACTIVO";
   ?>
    <tr class="Item1">
  <td width="35" align="center"><?php echo $empresa;   ?></td>
    <td><?php echo $razonSocial; ?></td>
    <td><?php echo $RFC; ?></td>
    <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="282">&nbsp;</td>
      <td width="186">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
<table width="600" align="center">

<tr>
      <td width="140">&nbsp;</td>
      <td width="140">&nbsp;</td>
      <td width="116">&nbsp;</td>
      <td width="98" align="right">&nbsp;</td>
      <td width="181" align="right"><input name="Submit22" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
  </tr>
</table>
<?php } else {

$partesdes=explode(" ",$razonSocial);
$partescor=explode(" ",$RFC);
$how=sizeof($partesdes);
$howc=sizeof($partescor);
//echo $how;
$like="";
for($i=0;$i<$how;$i++)
{	
	if($partesdes[$i]!=" ")
	{
	
		if($i<($how-1))
			{
				$like=$like."razonSocial like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."razonSocial like '%$partesdes[$i]%' or";
			}
	}
}

for($i=0;$i<$howc;$i++)
{	
	if($partescor[$i]!="")
	{
	
		if($i<($howc-1))
			{
				$like=$like." RFC like '%$partescor[$i]%' or ";
			}
		else
			{
				$like=$like." RFC like '%$partescor[$i]%'";
			}
	}
}


 $lik="SELECT *, case Estatus when 0 then 'INACTIVO'
when 1 then 'ACTIVO'
end Estate FROM empresas where Idempresa!=$empresa and (".$like.");";

//echo $lik;
$result=$link->consultar($lik);
$li=$link->affected();

if($li>0)
{

?>

			<table width="845" align="center" border="0">
              <tr>
                <td class="Subtitulo">VERIFIQUE QUE LA EMPRESA QUE DESEA REGISTRAR NO HAYA SIDO REGISTRADO CON ANTERIORIDAD </td>
              </tr>
            </table>
			<table width="600" border="0" align="center">
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td width="38" class="EncabezadoTabla">#</td>
                <td class="EncabezadoTabla">Raz&oacute;n Social</td>
                <td class="EncabezadoTabla">RFC</td>
                <td width="73" colspan="2" class="EncabezadoTabla">ESTATUS</td>
              </tr>
              <?php
			 
			
				//echo $sql;
			  
			  
			  if($estatus==0)
			  $Estatus="INACTIVO";
			  else 
			  if($estatus==1)
			  $Estatus="ACTIVO";
			   ?>
			   <?php $pr=1; 
			   while($row=mysql_fetch_array($result)){?>
              <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
                <td width="38" align="center"><?php echo $row[Idempresa];?></td>
                <td><?php echo $row[razonSocial];?></td>
                <td><?php echo $row[RFC];?></td>
                <td colspan="2" align="center"><?php echo $row[Estate]; ?></td>
              </tr>
			    <?php $pr++;}?>
              <tr>
                <td>&nbsp;</td>
                <td width="282">&nbsp;</td>
                <td width="189">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
</table>
			<table width="845" align="center" border="0">
			  <tr>
				<td class="Subtitulo">SI LA EMPRESA QUE DESEA REGISTRAR NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
			  </tr>
			</table>
			
			 <table width="600" border="0" align="center">
			   <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="38" class="EncabezadoTabla">#</td>
				<td class="EncabezadoTabla">Raz&oacute;n Social</td>
				<td class="EncabezadoTabla">RFC</td>
				<td width="73" colspan="2" class="EncabezadoTabla">ESTATUS</td>
			   </tr>
			 
			  <?php
			 
			
				//echo $sql;
			  
			  
			  if($estatus==0)
			  $Estatus="INACTIVO";
			  else 
			  if($estatus==1)
			  $Estatus="ACTIVO";
			   ?>
				<tr class="Item1">
			  <td width="41" align="center"><?php echo $empresa; ?></td>
				<td><?php echo $razonSocial; ?></td>
				<td><?php echo $RFC; ?></td>
				<td colspan="2" align="center"><?php echo $Estatus; ?></td>
			   </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="282">&nbsp;</td>
				  <td width="186">&nbsp;</td>
				  <td colspan="2">&nbsp;</td>
				</tr>
</table>
			<table width="600" align="center">
			
			<tr>
				  <td width="111">&nbsp;</td>
				  <td width="111">&nbsp;</td>
				  <td width="93">&nbsp;</td>
				  <td width="119" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
				 <form action="4Modifica.php" method="post" name="frm">
				  <td width="142" align="right">
					  <input type="hidden" name="empresa" value="<?php echo $empresa; ?>" />
					  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
					  <input type="hidden" name="razonSocial" value="<?php echo $razonSocial; ?>" />
					   <input type="hidden" name="RFC" value="<?php echo $RFC; ?>" />
					  <input name="Submit" type="submit" class="boton" value="Modificar">
				  </td>
					
				 </form>
			  </tr>
			
</table>
			<?php } else {?>
						
							<table width="845" align="center" border="0">
							  <tr>
								<td class="Subtitulo">VERIFIQUE SI SON CORRECTOS LOS DATOS A REGISTRAR </td>
							  </tr>
							</table>
							
							 <table width="600" border="0" align="center">
							   <tr>
								<td colspan="5">&nbsp;</td>
							  </tr>
							  <tr>
								<td width="38" class="EncabezadoTabla">#</td>
								<td class="EncabezadoTabla">Raz&oacute;n Social</td>
								<td class="EncabezadoTabla">RFC</td>
								<td width="73" colspan="2" class="EncabezadoTabla">ESTATUS</td>
							   </tr>
							 
							  <?php
							 
							
								//echo $sql;
							  
							  
							  if($estatus==0)
							  $Estatus="INACTIVO";
							  else 
							  if($estatus==1)
							  $Estatus="ACTIVO";
							   ?>
								<tr class="Item1">
							  <td width="32" align="center"><?php echo $empresa;   ?></td>
								<td><?php echo $razonSocial; ?></td>
								<td><?php echo $RFC; ?></td>
								<td colspan="2" align="center"><?php echo $Estatus; ?></td>
							   </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td width="282">&nbsp;</td>
								  <td width="195">&nbsp;</td>
								  <td colspan="2">&nbsp;</td>
								</tr>
</table>
							<table width="600" align="center">
							
							<tr>
								  <td width="111">&nbsp;</td>
								  <td width="111">&nbsp;</td>
								  <td width="93">&nbsp;</td>
								  <td width="118" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
								 <form action="4Modifica.php" method="post" name="frm">
								  <td width="143" align="right">
									  <input type="hidden" name="empresa" value="<?php echo $empresa; ?>" />
									  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
								      <input type="hidden" name="RFC" value="<?php echo $RFC; ?>" />
									  <input type="hidden" name="razonSocial" value="<?php echo $razonSocial; ?>" />
									  <input name="Submit" type="submit" class="boton" value="Modificar">
								  </td>
									
								 </form>
							  </tr>
							
</table>
			<?php }?>
<?php }?>
</body>
</html>
