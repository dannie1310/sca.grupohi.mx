<?
session_start();
require_once("../../inc/php/conexiones/SCA.php");

$viajes = $_POST['viajes'];
$estatus = $_POST['estatus'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Modulo de Conciliaci&oacute;n</title>
</head>

<body>
<br>


<style type="text/css">
	#td1{
		background-color:#e4dcdc;
		text-align: center;
	}

	font{
		font-family:Trebuchet MS;
		font-size:12px;
		font-weight:bold;
		color: #050606;
	}


</style>


	<table align="center" width="90%">
		<tr>
          <!--<td>&nbsp;</td>-->
          <td id='td1'><font>CAMI&Oacute;N</font></td>
          <td id='td1'><font>FECHA LLEGADA</font></td>
          <td id='td1'><font>HORA LLEGADA</font></td>
          <td id='td1'><font>ORIGEN</font></td>
          <td id='td1'><font>SINDICATO</font></td>
          <td id='td1'><font>EMPRESA</font></td>
          <td id='td1'><font>CUBICACI&Oacute;N</font></td>
          <td id='td1'><font>DEDUCTIVA</font></td>
          <td id='td1'><font>NUEVA CUBICACI&Oacute;N</font></td>
          <td id='td1'><font>ESTATUS</font></td>
          <td id='td1'><font>MOTIVO</font></td>
          <td id='td1' class="accion"><font>APROBAR</font></td>
          <td id='td1' class="accion"><font>CANCELAR</font></td>
        </tr>
<?

		foreach ($viajes as $key => $row) {	
			$val = $row['rownum'] %2;
			if($val ==0){
  					echo '<tr idDeduccion="'. $row['idDeduccion'].'" class="Item1" align="center">';
  				}
  				else{
  					echo '<tr idDeduccion="'. $row['idDeduccion'].'" class="Item2" align="center">';
  				}
			
				echo  "<td>" . $row['Economico'] . "</td>";
				echo  "<td>" . $row['FechaLlegada'] . "</td>";
				echo  "<td>" . $row['HoraLlegada'] . "</td>";
				echo  "<td>" . $row['Origen'] . "</td>";
				echo  "<td>" . $row['Sindicato'] . "</td>";
				echo  "<td>" . $row['Empresa'] . "</td>";
				echo  "<td>" . $row['CubicacionParaPago'] . "</td>";
				echo  "<td>" . $row['deductiva'] . "</td>";
				echo  "<td>" . $row['newcubicacion'] . "</td>";
				echo  "<td>" . $row['estatus'] . "</td>";
				echo  "<td>" . $row['motivo'] . "</td>";
			if($row['newcubicacion'] > 0){
				if ($row['estatusnum'] == 0 ) {
					echo  "<td class='accion'> <img src='../../Imgs/Check.gif' id='aprobar'> </td>";
				
					echo  "<td class='accion'> <img src='../../Imgs/Cross.gif' id='cancelar'> </td>";
				}
				else{
					echo  "<td class='accion'> N/A </td>";
					echo  "<td class='accion'> N/A </td>";
				}
			}
			else{
					echo  "<td class='accion'> Error de Cubicaci&oacute;n Nueva</td>";
					echo  "<td class='accion'> <img src='../../Imgs/Cross.gif' id='cancelar'> </td>";
			}
			
			echo "</tr>";	
		}

		//if ($estatus <> 0 ||  $estatus == -3) {
		//	echo "<script> $('#ListaDeduccion .accion').hide();</script>";
		//}
		
?>

	</table>




