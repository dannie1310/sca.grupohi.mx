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
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="845" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><p><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;SCA.- Edici&oacute;n de Origenes </p>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../inc/php/conexiones/SCA.php");
	
	$descripcion=$_REQUEST[descripcion];
	$tipo=$_REQUEST[tipo];
	$estatus=$_REQUEST[estatus];
	$origen=$_REQUEST[origen];
	
	$caso=$_REQUEST[caso];
	$link=SCA::getConexion();
	if($caso==1)
	{
		$hijosq="Select * from rutas where IdOrigen=".$origen." and IdProyecto=".$IdProyecto." and Estatus=1";
		$result=$link->consultar($hijosq);
		$rutasbajas='';
		$ab=$link->affected();
		$val=1;
		while($v=mysql_fetch_array($result))
		{//echo $val.'<br>';
		//echo $ab.'<br>';
			$bajarutas="update rutas set Estatus=0 where IdRuta=".$v[IdRuta]."";
			$link->consultar($bajarutas);
			$br=$link->affected();
			if($br==1)
			{
				$bajacro="update cronometrias set Estatus=0 where IdRuta=".$v[IdRuta]."";
				$link->consultar($bajacro);
			}
			if($ab!=$val)
				$rutasbajas=$rutasbajas.$v[IdRuta].',';
			else
				if($ab==$val)
				$rutasbajas=$rutasbajas.$v[IdRuta];
			//echo '$ '.$rutasbajas;
			$val++;
		}
		
		$sql="update origenes set IdTipoOrigen=".$tipo.", Descripcion='".$descripcion."', Estatus=".$estatus." where IdProyecto=".$IdProyecto." and IdOrigen=".$origen."; ";
	
	//echo $sql;
	
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL ORIGEN FUE MODIFICADO EXITOSAMENTE </td>
  </tr>
</table>

 <table width="600" border="0" align="center">
   <tr>
     <td colspan="5">&nbsp;</td>
   </tr>
   <tr>
     <td width="73" class="EncabezadoTabla">CLAVE </td>
     <td class="EncabezadoTabla">TIPO</td>
     <td class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
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
     <td width="73" align="center">B<?php echo $origen;   ?></td>
     <td><?PHP regresa(tiposorigenes,Descripcion,IdTipoOrigen,$tipo); ?></td>
     <td><?php echo $descripcion; ?></td>
     <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td width="147">&nbsp;</td>
     <td width="289">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
   </tr>
 </table>
 <?PHP
   $link2=SCA::getConexion();
   $hijosq2="Select *, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate from rutas where IdRuta in (".$rutasbajas.")";
   $resulth2=$link2->consultar($hijosq2);
   $as=$link2->affected();
   
  
   mysql_close($link2)
    ?>
 <table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">LAS SIGUIENTES RUTAS FUERON DESACTIVADAS </td>
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
			  
			  
			 
			   ?>
                  <?php $pr=1; 
			   while($row2=mysql_fetch_array($resulth2)){?>
                  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
                    <td width="71" align="center"><?php echo $row2[Clave].$row2[IdRuta];?></td>
                    <td><?php echo regresa(origenes,Descripcion,IdOrigen,$row2[IdOrigen]);?></td>
                    <td><?php echo regresa(tiros,Descripcion,IdTiro,$row2[IdTiro]);?></td>
                    <td colspan="2" align="center"><?php echo $row2[Estate]; ?></td>
                  </tr>
                  <?php $pr++;}?>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="219">&nbsp;</td>
                    <td width="219">&nbsp;</td>
                    <td colspan="2">&nbsp;</td>
                  </tr>
</table>
<table width="746" align="ce">
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <form action="1Inicio.php" method="post"> <td width="585" align="right">&nbsp;</td>
    <td width="149" align="right"><input name="Submit" type="submit" class="boton" value="Modificar Otros Tiros" /></td>
</form></tr></table>
<?php } else {?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL ORIGEN NO PUDO SER MODIFCADO, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } 
	}
	else	
	if($caso=='')
	{
	
	$sql="update origenes set IdTipoOrigen=".$tipo.", Descripcion='".$descripcion."', Estatus=".$estatus." where IdProyecto=".$IdProyecto." and IdOrigen=".$origen."; ";
	

	
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL ORIGEN FUE MODIFICADO EXITOSAMENTE </td>
  </tr>
</table>

 <table width="600" border="0" align="center">
   <tr>
     <td colspan="5">&nbsp;</td>
   </tr>
   <tr>
     <td width="73" class="EncabezadoTabla">CLAVE </td>
     <td class="EncabezadoTabla">TIPO</td>
     <td class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
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
     <td width="73" align="center">B<?php echo $origen;   ?></td>
     <td><?PHP regresa(tiposorigenes,Descripcion,IdTipoOrigen,$tipo); ?></td>
     <td><?php echo $descripcion; ?></td>
     <td colspan="2" align="center"><?php echo $Estatus; ?></td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td width="147">&nbsp;</td>
     <td width="289">&nbsp;</td>
     <td colspan="2">&nbsp;</td>
   </tr>
 </table>
 <table width="630" align="ce">
<tr>
  <td colspan="2">&nbsp;</td>
</tr>
<tr>
  <form action="1Inicio.php" method="post"> <td width="467" align="right">&nbsp;</td>
    <td width="151" align="right"><input name="Submit" type="submit" class="boton" value="Modificar Otros Tiros" /></td>
</form></tr></table>
<?php } else {?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL ORIGEN NO PUDO SER MODIFCADO, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } 
} 
$link->cerrar();
?>
</body>
</html>
