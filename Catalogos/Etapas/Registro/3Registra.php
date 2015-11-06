<?php
	session_start();
	$IdProyecto=$_SESSION['Proyecto'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../Clases/Styles/catalogos.css" rel="stylesheet" type="text/css" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">
<table align="center" width="600" border="0">
  <tr>
    <td class="EncabezadoPagina"><img src="../../../Imgs/16-Etapas.gif" width="16" height="16" />SCA.- Registro de Etapas </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    </tr>
</table>

<?php 	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
function obtennivel($argp)
{
$link=SCA::getConexion();
if($argp=='')
{	
	
	$nivels="select substr(Nivel,1,3) as Nivel from etapasproyectos where length(Nivel)=4 order by Nivel desc limit 1";
	$res=$link->consultar($nivels);
	$n=mysql_fetch_array($res);
	$ultimonivel=$n[Nivel];
	
	
	$nvo=$ultimonivel+1;
	$longitudnvo=sizeof($nvo);
	
	$ceros=3-$longitudnvo;
	$ce='';
	
	for($i=1;$i<=$ceros;$i++)
	{
		$ce=$ce.'0';
	
	}
	$nvo=$ce.$nvo.'.';
	
	return $nvo;
}
$link->cerrar();
}
$descripcion=$_REQUEST[descripcion]; 
$padre=$_REQUEST[padre];
$link=SCA::getConexion();
$sqla="Lock Tables etapasproyectos Write;";
$link->consultar($sqla);
$nivel=obtennivel($padre);

$sql="insert into etapasproyectos(Nivel,Descripcion,IdProyecto) values ('$nivel','$descripcion',".$_SESSION[Proyecto].");";
$link->consultar($sql);
$exito=$link->affected();
$sqlc="Unlock tables;";
$link->consultar($sqlc);
$link->cerrar();
if($exito==1)
{
?>
<table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">LA ETAPA HA SIDO REGISTRADA EXITOSAMENTE </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="242" border="0" align="center">
  <tr>
    <th class="EncabezadoTabla" scope="col">ETAPA</th>
  </tr>
  <tr>
    <td height="22" class="Item1"><?php echo $descripcion; ?></td>
  </tr>
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
    <form action="1Inicio.php" method="post" name="frm" id="frm">
      <td width="116"><div align="right">
        <input name="Submit2" type="submit" class="boton" value="Registrar Otras Etapas">
      </div></td>
    </form>
  </tr>
</table>
<?php } else { ?><table width="600" border="0" align="center">
  <tr>
    <td class="Subtitulo">HUBO UN ERROR AL REGISTRAR LA ETAPA, INTENTELO NUEVAMENTE </td>
  </tr>
  
</table>

<?php } ?>
</body>
</html>
