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
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Etapas.gif" width="16" height="16" />SCA.- Edici&oacute;n de Etapas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$descripcion=strtoupper($_REQUEST[descripcion]);
	$corto=strtoupper($_REQUEST[corto]);
	$estatus=$_REQUEST[estatus];
	$etapa=$_REQUEST[etapa];
	$link=SCA::getConexion();
	
	$equal="Select * from etapasproyectos where Descripcion='".$descripcion."' and IdEtapaProyecto!=".$etapa."  ";
	echo $equal;
	$link->consultar($equal);
	$eq=$link->affected();
	//echo $eq;
if($eq>0)
{
?>


<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">YA EXISTE UNA ETAPA CON ESA DESCRIPCIÓN </td>
  </tr>
</table>

 <table width="333" border="0" align="center">
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="78" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
  <td colspan="3" align="center"><?php echo $descripcion; ?></td>
    <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td width="21">&nbsp;</td>
      <td width="133">&nbsp;</td>
      <td width="83">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
<table width="333" align="center">

<tr>
      <td width="140">&nbsp;</td>
      <td width="140">&nbsp;</td>
      <td width="116">&nbsp;</td>
      <td width="98" align="right">&nbsp;</td>
      <td width="181" align="right"><input name="Submit22" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
  </tr>
</table>
<?php } else {

$partesdes=explode(" ",$descripcion);
$partescor=explode(" ",$corto);
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
				$like=$like."descripcion like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."descripcion like '%$partesdes[$i]%'";
			}
	}
}



 $lik="SELECT *, case Estatus when 0 then 'INACTIVO'
when 1 then 'ACTIVO'
end Estate FROM etapasproyectos where IdEtapaProyecto!=".$etapa." and (".$like.");";

//echo $lik;
$result=$link->consultar($lik);
$li=$link->affected();

if($li>0)
{

?>

			<table width="845" align="center" border="0">
              <tr>
                <td class="Subtitulo">VERIFIQUE QUE LA ETAPA QUE DESEA REGISTRAR NO HAYA SIDO REGISTRADA CON ANTERIORIDAD </td>
              </tr>
            </table>
			<table width="333" border="0" align="center">
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
              <tr>
                <td width="237" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
                <td width="86"  class="EncabezadoTabla">ESTATUS</td>
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
                <td align="center"><?php echo $row[Descripcion];?></td>
                <td align="center"><?php echo $row[Estate]; ?></td>
              </tr>
			    <?php $pr++;}?>
              <tr>
                <td colspan="4">&nbsp;</td>
              </tr>
</table>
			<table width="845" align="center" border="0">
			  <tr>
				<td class="Subtitulo">SI LA ETAPA QUE DESEA REGISTRAR NO COINCIDE CON ALGUNA DE LAS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
			  </tr>
			</table>
			
			 <table width="333" border="0" align="center">
			   <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
				<td colspan="3" class="EncabezadoTabla">ESTATUS</td>
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
			  <td colspan="2" align="center"><?php echo $descripcion; ?></td>
				<td colspan="3"  align="center"><?php echo $Estatus; ?></td>
			   </tr>
				<tr>
				  <td width="29">&nbsp;</td>
				  <td width="182">&nbsp;</td>
				  <td width="86">&nbsp;</td>
				  <td width="18" colspan="2">&nbsp;</td>
				</tr>
</table>
			<table width="333" align="center">
			
			<tr>
				  <td width="111">&nbsp;</td>
				  <td width="111">&nbsp;</td>
				  <td width="93">&nbsp;</td>
				  <td width="119" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
				 <form action="4Modifica.php" method="post" name="frm">
				  <td width="142" align="right">
					  <input type="hidden" name="etapa" value="<?php echo $etapa; ?>" />
					  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
					  <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
					   <input type="hidden" name="corto" value="<?php echo $corto; ?>" />
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
							
							 <table width="333" border="0" align="center">
							   <tr>
								<td colspan="5">&nbsp;</td>
							  </tr>
							  <tr>
								<td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
								<td colspan="3" class="EncabezadoTabla">ESTATUS</td>
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
							  <td colspan="2" align="center"><?php echo $descripcion; ?></td>
								<td colspan="3"  align="center"><?php echo $Estatus; ?></td>
							   </tr>
								<tr>
								  <td width="24">&nbsp;</td>
								  <td width="196">&nbsp;</td>
								  <td width="86">&nbsp;</td>
								  <td width="9" colspan="2">&nbsp;</td>
								</tr>
</table>
							<table width="333" align="center">
							
							<tr>
								  <td width="111">&nbsp;</td>
								  <td width="111">&nbsp;</td>
								  <td width="93">&nbsp;</td>
								  <td width="118" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
								 <form action="4Modifica.php" method="post" name="frm">
								  <td width="143" align="right">
                                  	 <input type="hidden" name="etapa" value="<?php echo $etapa; ?>" />
									  <input type="hidden" name="material" value="<?php echo $material; ?>" />
									  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
								      <input type="hidden" name="corto" value="<?php echo $corto; ?>" />
									  <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
									  <input name="Submit" type="submit" class="boton" value="Modificar">
								  </td>
									
								 </form>
							  </tr>
							
</table>
			<?php }?>
<?php }?>
</body>
</html>
