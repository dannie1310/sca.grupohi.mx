<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/Catalogos/CentrosCosto.php");
	session_start();
	$link=SCA::getConexion();
?>
<html>
<head>
<META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<body>
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Registro de Centros de Costo</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
$padrep=$_REQUEST[padre];
$descripcion=strtoupper(trim($_REQUEST[descripcion]));
//echo "padre: $padrep; descripcion: $descripcion<br>";

$ances=ancestros($padrep);
$equal="select * from centroscosto where Descripcion='".$descripcion."' and Nivel like '".$ances[1][0]."%' and IdProyecto=".$_SESSION[Proyecto]."";
//echo $equal;


//echo $equal;
$link->consultar($equal);
$afe=$link->affected();

#INICIA EQUAL
if($afe==0)
{
		$partesdes=explode(" ",$descripcion);
		$how=sizeof($partesdes);
		//echo $how;
		$like="";
		for($i=0;$i<$how;$i++)
		{	
			if($partesdes[$i]!=" "&&$partesdes[$i]!="km"&&$partesdes[$i]!="KM"&&$partesdes[$i]!="+"&&$partesdes[$i]!="AL")
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
			 $lik="SELECT *, case Estatus when 0 then 'INACTIVO'
			when 1 then 'ACTIVO'
			end Estate FROM centroscosto where IdProyecto=".$_SESSION[Proyecto]." and Nivel like'".$ances[1][0]."%' and (".$like.");";
			
			//echo $lik;
			$result=$link->consultar($lik);
			$li=$link->affected();
			//echo 'li: '.$li;
			if($li>0)
			{?>
			<table width="600" border="0" align="center">
				  <tr>
					<td><p class="Subtitulo">VERIFIQUE QUE EL CENTRO DE COSTO QUE DESEA REGISTRAR NO HAYA SIDO REGISTRADO PREVIAMENTE</p>
					</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
				  </tr>
				  <?php $j=0;while($previous=mysql_fetch_array($result)){?>
						  <tr>
							<td>&nbsp;</td>
						  </tr>
						  <?php 
						  $previos[$j]=ancestros($previous[IdCentroCosto]);
						  $sizeprevios[$j]=sizeof($previos[$j][1]);
						 $pr=1;
						 $espacios='&nbsp;&nbsp;&nbsp;';
						 for($i=0;$i<$sizeprevios[$j];$i++)
						  { $espacios=$espacios.'&nbsp;&nbsp;&nbsp;';?>
						  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
							<td><?php echo $previos[$j][3][$i]; ?></td>
						  </tr>
							<?php
							$pr++;}?>
							 
							 <tr>
							   <td >&nbsp;</td>
							 </tr>
					 <?php $j++; }?>
				     <tr>
				       <td >&nbsp;</td>
	          </tr>
				</table>
			<table width="600" border="0" align="center">
				  <tr>
					<td colspan="2"><p class="Subtitulo">SI NO COINCIDE NING&Uacute;N CENTRO DE COSTO ANTERIOR, POR FAVOR VERIFIQUE SI SON CORRECTOS LOS DATOS A REGISTRAR</p>
					</td>
				  </tr>
				  <tr>
					<td colspan="2">&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan="2">&nbsp;</td>
				  </tr>
				  <?php 
					  $sizeancestros=sizeof($ances[1]);
					 $pr=1;
					 $espacios='&nbsp;&nbsp;&nbsp;';
					 for($i=0;$i<$sizeancestros;$i++)
					  { $espacios=$espacios.'&nbsp;&nbsp;&nbsp;';?>
					  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
						<td colspan="2"><?php echo $ances[3][$i]; ?></td>
					  </tr>
						<?php
						$pr++;}?>
						 <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
						<td colspan="2"><?php  echo $espacios.'=> '.$descripcion; ?></td>
					  </tr>
						 <tr>
						   <td >&nbsp;</td>
						   <td  align="right">&nbsp;</td>
						 </tr>
					  <tr>
					  <form method="post" action="1Muestra.php" name="regresa">
						<td width="472"  align="right">	  
						<input type="hidden" name="padre" value="<?php echo $padrep;?>">
						  <input type="hidden" name="descripcion" value="<?php echo $descripcion;?>">
						  <input type="hidden" name="flag" value="1">
						<input name="Submit" type="submit" class="boton" value="Regresar"></td>
					
						</form>
						<form action="3Registra.php" method="post" name="frm">
								<td width="118" align="right">
									<input type="hidden" name="padre" value="<?php echo $padrep;?>">
									<input type="hidden" name="descripcion" value="<?php echo $descripcion;?>">
									<input name="Submit" type="submit" class="boton" value="Registrar">
								</td>
						</form>
					  </tr>
</table>
			<?php
			}
			
			else
			{
		

?>
				<table width="600" border="0" align="center">
				  <tr>
					<td colspan="2"><p class="Subtitulo">VERIFIQUE SI SON CORRECTOS LOS DATOS A REGISTRAR</p>
					</td>
				  </tr>
				  <tr>
					<td colspan="2">&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan="2">&nbsp;</td>
				  </tr>
				  <?php 
				  $sizeancestros=sizeof($ances[1]);
				 $pr=1;
				 $espacios='&nbsp;&nbsp;&nbsp;';
				 for($i=0;$i<$sizeancestros;$i++)
				  { $espacios=$espacios.'&nbsp;&nbsp;&nbsp;';?>
				  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
					<td colspan="2"><?php echo $ances[3][$i]; ?></td>
				  </tr>
					<?php
					$pr++;}?>
					 <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
					<td colspan="2"><?php  echo $espacios.'=> '.$descripcion; ?></td>
				  </tr>
					 <tr>
					   <td >&nbsp;</td>
					   <td  align="right">&nbsp;</td>
					 </tr>
				  <tr>
					
						<form method="post" action="1Muestra.php" name="regresa">
					<td width="480"  align="right">	  <input type="hidden" name="padre" value="<?php echo $padrep;?>">
					  <input type="hidden" name="descripcion" value="<?php echo $descripcion;?>">
					  <input type="hidden" name="flag" value="1">
					<input name="Submit" type="submit" class="boton" value="Regresar"></td>
				
					</form>
											<form action="3Registra.php" method="post" name="frm">
								<td width="110" align="right">
									<input type="hidden" name="padre" value="<?php echo $padrep;?>">
									<input type="hidden" name="descripcion" value="<?php echo $descripcion;?>">
									<input name="Submit" type="submit" class="boton" value="Registrar">
								</td>
						</form>
				  </tr>
				</table>
<?php 
}#TERMINA LI
}#TERMINA EQUAL

 else {?>
<table width="600" border="0" align="center">
  <tr>
    <td colspan="2"><p class="Subtitulo">EL CENTRO DE COSTO QUE DESEA REGISTRAR YA EXISTE</p></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php 
  $sizeancestros=sizeof($ances[1]);
 $pr=1;
 $espacios='&nbsp;&nbsp;&nbsp;';
 for($i=0;$i<$sizeancestros;$i++)
  { $espacios=$espacios.'&nbsp;&nbsp;&nbsp;';?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td colspan="2"><?php echo $ances[3][$i]; ?></td>
  </tr>
  <?php
	$pr++;}?>
  <tr class=" <?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td colspan="2"><?php  echo $espacios.'=> '.$descripcion; ?></td>
  </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    <td width="440">&nbsp;</td>
	<form method="post" action="1Muestra.php" name="regresa">
   	  <td width="150" align="right"><input type="hidden" name="padre" value="<?php echo $padrep;?>">
   	    <input type="hidden" name="descripcion" value="<?php echo $descripcion;?>">
   	    <input type="hidden" name="flag" value="1">
   	  <input name="Submit" type="submit" class="boton" value="Regresar"></td>
	</form>
  </tr>
</table>
<?php }?>
</body>
</html>
