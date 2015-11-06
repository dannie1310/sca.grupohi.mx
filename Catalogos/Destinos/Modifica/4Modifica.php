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
	$caso=$_REQUEST[caso];
	$descripcion=$_REQUEST[descripcion];
	$estatus=$_REQUEST[estatus];
	$tiro=$_REQUEST[tiro];
	$link=SCA::getConexion();
	
	if($caso==1)
	{
		$hijosq="Select * from rutas where IdTiro=".$tiro." and IdProyecto=".$IdProyecto." and Estatus=1";
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
		
		$sql="update tiros set  Descripcion='".$descripcion."', Estatus=".$estatus." where IdProyecto=".$IdProyecto." and IdTiro=".$tiro."; ";
	
	//echo $sql;
	
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL TIRO FUE MODIFICADO EXITOSAMENTE </td>
  </tr>
</table>

 <table width="420" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="80" class="EncabezadoTabla">CLAVE </td>
    <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="81" class="EncabezadoTabla">ESTATUS</td>
   </tr>
  
  <?php
 

	//echo $sql;
  
  
  if($estatus==0)
  $Estatus="INACTIVO";
  else 
  if($estatus==1)
  $Estatus="ACTIVO";
   ?>
    <tr>
  <td width="80" class="Item1" align="center">T<?php echo $tiro;?></td>
    <td colspan="2" class="Item1"><?php echo $descripcion; ?></td>
    <td class="Item1" align="center">
	
     <?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="225">&nbsp;</td>
      <td width="351">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
 <?PHP
   
   $hijosq="Select *, case Estatus when 0 then 'INACTIVO' when 1 then 'ACTIVO' end Estate from rutas where IdRuta in (".$rutasbajas.")";
   $resulth=$link->consultar($hijosq);
   
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
    <td class="Subtitulo">EL TIRO NO PUDO SER MODIFCADO, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } 
	}
	else	
	if($caso=='')
	{
	
	$sql="update tiros set  Descripcion='".$descripcion."', Estatus=".$estatus." where IdProyecto=".$IdProyecto." and IdTiro=".$tiro."; ";
	
	//echo $sql;
	
	$link->consultar($sql);
	$afe=$link->affected();
	
	if($afe>=0)
	{
?>
<table width="845" align="center" border="0">
  <tr>
    <td class="Subtitulo">EL TIRO FUE MODIFICADO EXITOSAMENTE </td>
  </tr>
</table>

 <table width="420" border="0" align="center">
   <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="80" class="EncabezadoTabla">CLAVE </td>
    <td colspan="2" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="81" class="EncabezadoTabla">ESTATUS</td>
   </tr>
 
  <?php
 

	//echo $sql;
  
  
  if($estatus==0)
  $Estatus="INACTIVO";
  else 
  if($estatus==1)
  $Estatus="ACTIVO";
   ?>
    <tr>
  <td width="80" class="Item1" align="center">T<?php echo $tiro;?></td>
    <td colspan="2" class="Item1"><?php echo $descripcion; ?></td>
    <td class="Item1" align="center">
	
     <?php echo $Estatus; ?></td>
   </tr>
    <tr>
      <td>&nbsp;</td>
      <td width="225">&nbsp;</td>
      <td width="351">&nbsp;</td>
      <td>&nbsp;</td>
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
    <td class="Subtitulo">EL TIRO NO PUDO SER MODIFCADO, INTENTELO NUEVAMENTE</td>
  </tr>
</table>
<?php } 
} ?>
</body>
</html>
