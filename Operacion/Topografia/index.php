<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
$SCA=SCA::getConexion();
?>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<br />
<div style="margin-left:50px;">
<div  style="font-size:4em; color: #069; vertical-align:middle;"><img src="../../Imagenes/Edit_48x48.gif"/>Topografia</div><br />
<?php
$sql = "select nm.Id_NivelMenu,nm.Ruta,nm.Icono,nm.Descripcion from niveles_menu as nm left join niveles_usuario as nu ON nu.Id_NivelMenu = nm.Id_NivelMenu where nu.IdUsuario = '".$_SESSION["IdUsuarioAc"]."' AND nu.Id_NivelMenu in (98,99)";
$rsql = $SCA->consultar($sql);
while($vsql = $SCA->fetch($rsql)){
	?>
    <span class="boton" style="margin-left:5px; font-size:12px; color: #069; font-weight:bold;"  id="<?php echo $vsql["Descripcion"]; ?>" onclick="window.location.href='<?php echo $vsql["Ruta"];?>';"><img src="../../<?php echo $vsql["Icono"];?>" />&nbsp;<?php echo $vsql["Descripcion"]; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
	}
?>
</div>