
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- jQuery library (served from Google) -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="../../Estilos/js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="../../Estilos/js/jquery.bxslider.css" rel="stylesheet" />
<?php 
session_start();

include("../../Clases/Funciones/Configuracion.php");
include("../../inc/php/conexiones/SCA.php");

$idviajeneto = $_GET['idviajeneto'];

$conexion = SCA::getConexion(); 

$SQLs = "SELECT vn.imagen as imagen, vn.estado as estado, cat.descripcion as descripcion 
                                        FROM viajes_netos_imagenes vn
                                        INNER JOIN cat_tipos_imagenes cat on cat.id = vn.idtipo_imagen
                                        where idviaje_neto = ".$idviajeneto."";

$fotos=$conexion->consultar($SQLs);
	echo "<ul class='bxslider'>";
	$count =1;
while($row=$conexion->fetch($fotos)){ 
	$Base64Img =$row['imagen'];
	//echo $row['imagen'];
	list(, $Base64Img) = explode(';', $Base64Img);
	list(, $Base64Img) = explode(',', $Base64Img);
	$Base64Img = base64_decode($Base64Img);
	file_put_contents('foto'.$count.'.png', $Base64Img);
	echo "<li><img src='foto".$count.".png' alt='foto' width=50% height=50% title='" . $row['descripcion']."'' /></li>";
	$count++;

}
echo "</ul>";

?>
<script type="text/javascript">
	$('.bxslider').bxSlider({
	 	mode: 'fade',
  		captions: true
	});
</script>
</html>

