<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<body>
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Destinos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$descripcion=strtoupper($_REQUEST[descripcion]);
	$tipo=$_REQUEST[TiposOrigenes];
	$estatus=$_REQUEST[estatus];
	$tiro=$_REQUEST[tiro];
	$link=SCA::getConexion();
	
	if($estatus!=0)
{
	$equal="Select * from tiros where Descripcion='".$descripcion."' and IdTiro!=".$tiro."";
	//echo $equal;
	$link->consultar($equal);
	$eq=$link->affected();
	//echo $eq;
if($eq>0)
{
?>


<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">YA EXISTE UN TIRO CON ESA DESCRIPCIÓN, POR FAVOR MODIFIQUELA </td>
  </tr>
</table>

 <table width="420" border="0" align="center">
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="71" class="EncabezadoTabla">CLAVE </td>
    <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
  <td width="71" align="center">T<?php echo $tiro;   ?></td>
    <td colspan="2"><?php echo $descripcion; ?></td>
    <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="225">&nbsp;</td>
      <td width="285">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
<table width="420" align="center">

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
$how=sizeof($partesdes);
//echo $how;
$like="";
for($i=0;$i<$how;$i++)
{	
	if($partesdes[$i]!=" ")
	{
	
		if($i<($how-1))
			{
				$like=$like."Descripcion like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."Descripcion like '%$partesdes[$i]%'";
			}
	}
}
$lik="select *, case Estatus when 0 then 'INACTIVO'
when 1 then 'ACTIVO'
end Estate from tiros where IdTiro!=$tiro and (".$like.")";
//echo $lik;
$result=$link->consultar($lik);
$li=$link->affected();

if($li>0)
{

?>

			<table width="845" align="center" border="0">
              <tr>
                <td class="Subtitulo">VERIFIQUE QUE EL TIRO QUE DESEA MODIFICAR NO HAYA SIDO REGISTRADO CON ANTERIORIDAD </td>
              </tr>
            </table>
			<table width="420" border="0" align="center">
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td width="71" class="EncabezadoTabla">CLAVE </td>
                <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
                <td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
                <td width="71" align="center"><?php echo $row[Clave].$row[IdTiro];?></td>
                <td colspan="2"><?php echo $row[Descripcion];?></td>
                <td colspan="2" align="center"><?php echo $row[Estate]; ?></td>
              </tr>
			    <?php $pr++;}?>
              <tr>
                <td>&nbsp;</td>
                <td width="225">&nbsp;</td>
                <td width="285">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table>
			<table width="845" align="center" border="0">
			  <tr>
				<td class="Subtitulo">SI EL TIRO QUE DESEA MODIFICAR NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
			  </tr>
			</table>
			
			 <table width="420" border="0" align="center">
			   <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="71" class="EncabezadoTabla">CLAVE </td>
				<td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
				<td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
			  <td width="71" align="center">T<?php echo $tiro;   ?></td>
				<td colspan="2"><?php echo $descripcion; ?></td>
				<td colspan="2" align="center"><?php echo $Estatus; ?></td>
			   </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="225">&nbsp;</td>
				  <td width="285">&nbsp;</td>
				  <td colspan="2">&nbsp;</td>
				</tr>
			</table>
			<table width="420" align="center">
			
			<tr>
				  <td width="140">&nbsp;</td>
				  <td width="140">&nbsp;</td>
				  <td width="116">&nbsp;</td>
				  <td width="98" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
				 <form action="4Modifica.php" method="post" name="frm">
				  <td width="181" align="right">
					  <input type="hidden" name="tiro" value="<?php echo $tiro; ?>" />
					  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
					  <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
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
							
							 <table width="420" border="0" align="center">
							   <tr>
								<td colspan="5">&nbsp;</td>
							  </tr>
							  <tr>
								<td width="71" class="EncabezadoTabla">CLAVE </td>
								<td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
								<td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
							  <td width="71" align="center">T<?php echo $tiro;   ?></td>
								<td colspan="2"><?php echo $descripcion; ?></td>
								<td colspan="2" align="center"><?php echo $Estatus; ?></td>
							   </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td width="225">&nbsp;</td>
								  <td width="285">&nbsp;</td>
								  <td colspan="2">&nbsp;</td>
								</tr>
							</table>
							<table width="420" align="center">
							
							<tr>
								  <td width="140">&nbsp;</td>
								  <td width="140">&nbsp;</td>
								  <td width="116">&nbsp;</td>
								  <td width="98" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
								 <form action="4Modifica.php" method="post" name="frm">
								  <td width="181" align="right">
									  <input type="hidden" name="tiro" value="<?php echo $tiro; ?>" />
									  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
								
									  <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
									  <input name="Submit" type="submit" class="boton" value="Modificar">
								  </td>
									
								 </form>
							  </tr>
							
							</table>
			<?php }?>
<?php }
} #hijos

else
if($estatus==0)
{
		$hijosq="Select *, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate from rutas where IdTiro=".$tiro." and IdProyecto=".$IdProyecto." and Estatus=1";
			$resulth=$link->consultar($hijosq);
			$hijos=$link->affected();
			//echo $hijos;
		if($hijos>0)
			{
			?>
				<table width="845" align="center" border="0">
                  <tr>
                    <td class="Subtitulo">EL TIRO QUE DESEA DESACTIVAR, TIENE LAS SIGUIENTES RUTAS ASOCIADAS </td>
                  </tr>
                </table>
				<table width="600" border="0" align="center">
                  <tr>
                    <td colspan="5">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="71" class="EncabezadoTabla">ID RUTA </td>
                    <td class="EncabezadoTabla">ORIGEN</td>
                    <td class="EncabezadoTabla">DESTINO</td>
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
			   while($row=mysql_fetch_array($resulth)){?>
                  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
                    <td width="71" align="center"><?php echo $row[Clave].$row[IdRuta];?></td>
                    <td><?php echo regresa(origenes,Descripcion,IdOrigen,$row[IdOrigen]);?></td>
                    <td><?php echo regresa(tiros,Descripcion,IdTiro,$row[IdTiro]);?></td>
                    <td colspan="2" align="center"><?php echo $row[Estate]; ?></td>
                  </tr>
                  <?php $pr++;}?>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="219">&nbsp;</td>
                    <td width="219">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                </table>
                <table width="845" align="center" border="0">
                  <tr>
                    <td class="Subtitulo">SI CONTINUA, LAS RUTAS Y CRONOMETRIAS ASOCIADAS SE DESACTIVARAN TAMBI&Eacute;N</td>
                  </tr>
                </table>
                <table width="420" border="0" align="center">
                  <tr>
                    <td colspan="5">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="71" class="EncabezadoTabla">CLAVE </td>
                    <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
                    <td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
                    <td width="71" align="center">T<?php echo $tiro;   ?></td>
                    <td colspan="2"><?php echo $descripcion; ?></td>
                    <td colspan="2" align="center"><?php echo $Estatus; ?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="225">&nbsp;</td>
                    <td width="285">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
                </table>
                <table width="420" align="center">
                  <tr>
                    <td width="140">&nbsp;</td>
                    <td width="140">&nbsp;</td>
                    <td width="116">&nbsp;</td>
                    <td width="98" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
                    <form action="4Modifica.php" method="post" name="frm" id="frm">
                      <td width="181" align="right"><input type="hidden" name="tiro" value="<?php echo $tiro; ?>" />
                          <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
                          <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
						  <input type="hidden" name="caso" value="1" />
                          <input name="Submit" type="submit" class="boton" value="Modificar" />
                      </td>
                    </form>
                  </tr>
                </table>
<?php
			}
		else
		if($hijos==0)
			{
				$equal="Select * from tiros where Descripcion='".$descripcion."' and IdTiro!=".$tiro."";
	//echo $equal;
	$link->consultar($equal);
	$eq=$link->affected();
	//echo $eq;
if($eq>0)
{
?>


<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">YA EXISTE UN TIRO CON ESA DESCRIPCIÓN, POR FAVOR MODIFIQUELA </td>
  </tr>
</table>

 <table width="420" border="0" align="center">
   <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="71" class="EncabezadoTabla">CLAVE </td>
    <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
  <td width="71" align="center">T<?php echo $tiro;   ?></td>
    <td colspan="2"><?php echo $descripcion; ?></td>
    <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="225">&nbsp;</td>
      <td width="285">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
</table>
<table width="420" align="center">

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
$how=sizeof($partesdes);
//echo $how;
$like="";
for($i=0;$i<$how;$i++)
{	
	if($partesdes[$i]!=" ")
	{
	
		if($i<($how-1))
			{
				$like=$like."Descripcion like '%$partesdes[$i]%' or ";
			}
		else
			{
				$like=$like."Descripcion like '%$partesdes[$i]%'";
			}
	}
}
$lik="select *, case Estatus when 0 then 'INACTIVO'
when 1 then 'ACTIVO'
end Estate from tiros where IdTiro!=$tiro and (".$like.")";
//echo $lik;
$result=$link->consultar($lik);
$li=$link->affected();

if($li>0)
{

?>

			<table width="845" align="center" border="0">
              <tr>
                <td class="Subtitulo">VERIFIQUE QUE EL TIRO QUE DESEA MODIFICAR NO HAYA SIDO REGISTRADO CON ANTERIORIDAD </td>
              </tr>
            </table>
			<table width="420" border="0" align="center">
              <tr>
                <td colspan="5">&nbsp;</td>
              </tr>
              <tr>
                <td width="71" class="EncabezadoTabla">CLAVE </td>
                <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
                <td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
                <td width="71" align="center"><?php echo $row[Clave].$row[IdTiro];?></td>
                <td colspan="2"><?php echo $row[Descripcion];?></td>
                <td colspan="2" align="center"><?php echo $row[Estate]; ?></td>
              </tr>
			    <?php $pr++;}?>
              <tr>
                <td>&nbsp;</td>
                <td width="225">&nbsp;</td>
                <td width="285">&nbsp;</td>
                <td colspan="2">&nbsp;</td>
              </tr>
            </table>
			<table width="845" align="center" border="0">
			  <tr>
				<td class="Subtitulo">SI EL TIRO QUE DESEA MODIFICAR NO COINCIDE CON ALGUNO DE LOS ANTERIORES, VERIFIQUE QUE LA INFORMACI&Oacute;N A REGISTRAR SEA CORRECTA </td>
			  </tr>
			</table>
			
			 <table width="420" border="0" align="center">
			   <tr>
				<td colspan="5">&nbsp;</td>
			  </tr>
			  <tr>
				<td width="71" class="EncabezadoTabla">CLAVE </td>
				<td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
				<td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
			  <td width="71" align="center">T<?php echo $tiro;   ?></td>
				<td colspan="2"><?php echo $descripcion; ?></td>
				<td colspan="2" align="center"><?php echo $Estatus; ?></td>
			   </tr>
				<tr>
				  <td>&nbsp;</td>
				  <td width="225">&nbsp;</td>
				  <td width="285">&nbsp;</td>
				  <td colspan="2">&nbsp;</td>
				</tr>
			</table>
			<table width="420" align="center">
			
			<tr>
				  <td width="140">&nbsp;</td>
				  <td width="140">&nbsp;</td>
				  <td width="116">&nbsp;</td>
				  <td width="98" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
				 <form action="4Modifica.php" method="post" name="frm">
				  <td width="181" align="right">
					  <input type="hidden" name="tiro" value="<?php echo $tiro; ?>" />
					  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
					  <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
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
							
							 <table width="420" border="0" align="center">
							   <tr>
								<td colspan="5">&nbsp;</td>
							  </tr>
							  <tr>
								<td width="71" class="EncabezadoTabla">CLAVE </td>
								<td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
								<td width="65" colspan="2" class="EncabezadoTabla">ESTATUS</td>
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
							  <td width="71" align="center">T<?php echo $tiro;   ?></td>
								<td colspan="2"><?php echo $descripcion; ?></td>
								<td colspan="2" align="center"><?php echo $Estatus; ?></td>
							   </tr>
								<tr>
								  <td>&nbsp;</td>
								  <td width="225">&nbsp;</td>
								  <td width="285">&nbsp;</td>
								  <td colspan="2">&nbsp;</td>
								</tr>
							</table>
							<table width="420" align="center">
							
							<tr>
								  <td width="140">&nbsp;</td>
								  <td width="140">&nbsp;</td>
								  <td width="116">&nbsp;</td>
								  <td width="98" align="right"><input name="Submit2" type="button" class="boton" onclick="history.go(-1)" value="Regresar" /></td>
								 <form action="4Modifica.php" method="post" name="frm">
								  <td width="181" align="right">
									  <input type="hidden" name="tiro" value="<?php echo $tiro; ?>" />
									  <input type="hidden" name="estatus" value="<?php echo $estatus; ?>" />
								
									  <input type="hidden" name="descripcion" value="<?php echo $descripcion; ?>" />
									  <input name="Submit" type="submit" class="boton" value="Modificar">
								  </td>
									
								 </form>
							  </tr>
							
							</table>
			<?php }?>
<?php } ?>
			<?php
			}
 }?>
</body>
</html>
