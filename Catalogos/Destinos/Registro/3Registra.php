<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
</head>
<?php
include("../../../inc/php/conexiones/SCA.php");
	
	
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];

	
	$registro=date("Y-m-d");
$hora=date("H:i:s");
	$link=SCA::getConexion();
$descripcion=$_REQUEST[descripcion];
$tipo=$_REQUEST[tipo];
$sql="INSERT INTO tiros(HoraAlta,FechaAlta,IdProyecto,Descripcion) values ('$hora','$registro',$IdProyecto,'$descripcion') ";
//echo $sql;
$link->consultar($sql);

$ex=$link->affected();
if($ex==1)
{

$sql="select Clave,
	IdTiro,
	Descripcion,
	case Estatus
	when 0 then 'INACTIVO'
	when 1 then 'ACTIVO'
	end Estate from tiros where IdProyecto=$IdProyecto and IdProyecto=$IdProyecto and FechaAlta='$registro'  and descripcion='$descripcion' order by IdTiro desc";

$result=$link->consultar($sql);
$row=mysql_fetch_array($result);


 ?>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="612" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" />&nbsp;SCA.- Registro de Destinos </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">EL TIRO HA SIDO REGISTRADO EXITOSAMENTE </td>
  </tr>
</table>

<table width="464" border="0" align="center">
   <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="93" class="EncabezadoTabla">CLAVE</td>
    <td width="287" class="EncabezadoTabla">DESCRIPCI&Oacute;N</td>
    <td width="70" class="EncabezadoTabla">ESTATUS</td>
  </tr>
   <tr>
     <td width="93" class="Item1">
     <div align="center"><?php echo $row[Clave].$row[IdTiro];   ?></div></td>
    <td width="287" class="Item1"><?php echo $row[Descripcion]; ?></td>
    <td class="Item1">
     <div align="center"><?php echo $row[Estate]; ?></div></td>
   </tr>
</table>
  <form action="Inicio.php" method="post">
<table width="603" border="0" align="center">
  <tr>
    <td width="858">&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">
      <input name="Submit" type="submit" class="boton" value="Registrar Otro Tiro">
    </div></td>
  </tr>
</table>
</form>
<?php } else {?>
<table width="845" border="0" align="center">
  <tr>
    <td class="Subtitulo">POR EL MOMENTO EL TIRO NO PUDO SER REGISTRADO, INTENTELO NUEVAMENTE </td>
  </tr>
</table>
<?php }?>
</body>
</html>
