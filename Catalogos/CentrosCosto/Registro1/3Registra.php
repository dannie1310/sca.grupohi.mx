<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="800" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-CentrosCosto.gif" width="16" height="16" />&nbsp;SCA.- Registro de Centros de Costo</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<?php 	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/Catalogos/CentrosCosto.php");


$descripcion=$_REQUEST[descripcion]; 
$padre=$_REQUEST[padre];
$link=SCA::getConexion();
$ances=ancestros($padre);



$nivel=obtennivel($padre);
//$link=SCA::getConexion();
$sql="insert into centroscosto(Nivel,Descripcion,IdProyecto) values ('$nivel','$descripcion',".$_SESSION[Proyecto].");";
//echo $sql;
$link->consultar($sql);
$exito=$link->affected();


$link->cerrar();
if($exito==1)
{
?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">EL CENTRO DE COSTO HA SIDO REGISTRADO EXITOSAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center">
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
				  </table>
<table width="427" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="107">&nbsp;</td>
    <td width="175">&nbsp;</td>
    <td width="174">&nbsp;</td>
    <form action="1Muestra.php" method="post" name="frm" id="frm">
      <td width="116"><div align="right">
        <input name="Submit2" type="submit" class="boton" value="Registrar Otros Centros de Costo">
      </div></td>
    </form>
  </tr>
</table>
<?php } else { ?><table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">HUBO UN ERROR AL REGISTRAR EL CENTRO DE COSTO, INTENTELO NUEVAMENTE </td>
  </tr>
  
</table>

<?php } ?>

</body>
</html>
