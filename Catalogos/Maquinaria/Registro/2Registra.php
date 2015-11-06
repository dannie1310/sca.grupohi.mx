<?php
session_start();
if(!isset($_SESSION[IdUsuario]))
{
?>
<script>
//window.parent.location.reload();
</script>
<?php 
}
?>
<?php

include("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");

$arrendador=$_REQUEST["maquinaria_arrendadores"];
$tipo=$_REQUEST["maquinaria_tipos"];
$relacion=$_REQUEST["maquinaria_relacion"];
$marca=$_REQUEST["marca"];
$modelo=$_REQUEST["modelo"];
$serie=$_REQUEST["serie"];
$marca_motor=$_REQUEST["marca_motor"];
$modelo_motor=$_REQUEST["modelo_motor"];
$serie_motor=$_REQUEST["serie_motor"];
$economico=$_REQUEST["economico"];
$estatus=$_REQUEST["maquinaria_estatus"];
$f_llegada=$_REQUEST["f_llegada"];
$f_salida=$_REQUEST["f_salida"];
$link=SCA::getConexion();
$sql="select fn_registra_maquinaria('$arrendador' , '$tipo', '$relacion', '$marca' ,'$modelo', '$serie', '$economico', '$marca_motor', '$modelo_motor', '$serie_motor', '".fechasql($f_llegada)."', '".fechasql($f_salida)."', '$estatus', '".$_SESSION[IdUsuario]."') as IdMaquinaria";
//echo $sql;
$r=$link->consultar($sql);
$v=mysql_fetch_array($r);


$link->cerrar();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="../../../Clases/Js/NoClick.js"></script>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php if($v["IdMaquinaria"]!=''){?>
<table width="600" border="0">
  <tr>
    <td class="Subtitulo Green">EL EQUIPO HA SIDO REGISTRADO EXITOSAMENTE</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input name="button" type="submit" class="Casillas_small" id="button" value="Registrar Otros Equipos" onClick="location.href='1IngresaDatos.php'"></td>
  </tr>
</table>
<?php } else {?>
<table width="600" border="0">
  <tr>
    <td class="Subtitulo Red">HUBO UN ERROR AL REGISTRAR EL EQUIPO</td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input name="button2" type="submit" class="Casillas_small" id="button2" value="Intentar Nuevamente" onClick="location.href='1IngresaDatos.php'"></td>
  </tr>
</table>
<?php }?>
</body>
</html>