<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<?php
include("../../../inc/php/conexiones/SCA.php");
	$IdUsuario=1;
	$Descripcion="Omar Aguayo Mendoza";
	$IdProyecto=1;
	$registro=date("Y-m-d");
$hora=date("H:i:s");
	
	$link=SCA::getConexion();
$descripcion=$_REQUEST[descripcion];
$tipo=$_REQUEST[tipo];
$sql="INSERT INTO origenes(FechaAlta,HoraAlta,IdProyecto,IdTipoOrigen,Descripcion) values ('$registro','$hora',$IdProyecto,$tipo,'$descripcion') ";
//echo $sql;
$link->consultar($sql);
$ex=$link->affected();
if($ex==1)
{
$sql="select Clave,
	IdOrigen,
	Descripcion,
	case Estatus
	when 0 then 'INACTIVO'
	when 1 then 'ACTIVO'
	end Estate from origenes where IdProyecto=$IdProyecto and IdProyecto=$IdProyecto and IdTipoOrigen=$tipo and FechaAlta='$registro' and descripcion='$descripcion' order by IdOrigen desc";

$result=$link->consultar($sql);
$row=mysql_fetch_array($result);


 ?>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="845" border="0">
  <tr>
    <td width="845" class="EncabezadoPagina"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" />&nbsp;SCA.- Registro de Origenes </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">EL ORIGEN HA SIDO REGISTRADO EXITOSAMENTE </td>
  </tr>
</table>

<table width="492" border="0" align="center">
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="53" class="EncabezadoTabla">CLAVE</td>
    <td width="355" class="EncabezadoTabla">DESCRIPCION</td>
    <td width="70" class="EncabezadoTabla">ESTATUS</td>
  </tr>
   <tr class="Item1">
     <td width="53">
     <div align="center"><?php echo $row[Clave].$row[IdOrigen];   ?></div></td>
    <td width="355"><?php echo $row[Descripcion]; ?></td>
    <td>
     <div align="center"><?php echo $row[Estate]; ?></div></td>
   </tr>
</table>
  <form action="1Inicio.php" method="post">
<table width="845" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">
      <input name="Submit" type="submit" class="boton" value="Registrar Otro Origen">
    </div></td>
  </tr>
</table>
</form>
<?php } else {?>
<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">POR EL MOMENTO EL ORIGEN NO PUDO SER REGISTRADO, INTENTELO NUEVAMENTE </td>
  </tr>
</table>
<?php }?>
</body>
</html>
