<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">

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
$idmaquinaria=$_REQUEST["idmaquinaria"];
$link=SCA::getConexion();
$sql="select fn_actualiza_maquinaria(".$idmaquinaria.",'$arrendador' , '$tipo', '$relacion', '$marca' ,'$modelo', '$serie', '$economico', '$marca_motor', '$modelo_motor', '$serie_motor', '".fechasql($f_llegada)."', '".fechasql($f_salida)."', '$estatus')";
//echo $sql;
$r=$link->consultar($sql);
$v=mysql_fetch_array($r);


$link->cerrar();
?>
<table width="500" border="0" align="center">
  <tr>
    <td align="center" class="Subtitulo">LA MODIFICACI&Oacute;N HA SIDO REALIZADA</td>
  </tr>
</table>
