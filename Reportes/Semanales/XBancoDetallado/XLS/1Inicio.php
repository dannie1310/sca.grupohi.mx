<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
</head>
<script src="../../../../Clases/Js/NoClick.js"></script>

<body>
<?php
	include ("../../../../inc/php/conexiones/SCA.php");
?>
<form name="frm" method="post" action="2Muestra.php" >
<table  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="Titulo">SCA.- Reporte Detallado de Movimiento de Tierra por Origen</td>
  </tr>
  <tr>
    <td class="Subtitulo">&nbsp;</td>
  </tr>
  <tr>
    <td class="Subtitulo">&nbsp;</td>
  </tr>
</table>
<table border="1" align="center" bordercolor="#FFFFFF">
  <tr align="center">
    <td bordercolor="#FFFFFF" class="Subtitulo">Seleccione la Semana a Consultar</td>
  </tr>
  <tr>
    <td bordercolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bordercolor="#FFFFFF">
	<?php 

	?>
		<select name="Semana">
		<?php
			
			$Link=SCA::getConexion();
			$SQL="SELECT DISTINCT concat(year(viajes.FechaSalida),weekofyear(viajes.FechaSalida)) AS AnioSemana,  concat(year(viajes.FechaSalida),'.- Semana ',weekofyear(viajes.FechaSalida)) AS Descripcion FROM viajes WHERE viajes.IdProyecto = ".$_SESSION["Proyecto"]." ORDER BY Descripcion DESC";
			$Result=$Link->consultar($SQL);
			//$Link->cerrar();
			
			echo"<option value='A99'>- SELECCIONE -</option>";
			
			while($Row=mysql_fetch_array($Result))
			{
				echo"<option value='".$Row["AnioSemana"]."'>".$Row["Descripcion"]."</option>";
			}	
		?>
    	</select>
    </td>
  </tr>
  <tr>
    <td bordercolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" bordercolor="#FFFFFF"><input name="Submit" type="submit" class="boton" value="Consultar" /></td>
  </tr>
</table>
</form>
</body>
</html>
