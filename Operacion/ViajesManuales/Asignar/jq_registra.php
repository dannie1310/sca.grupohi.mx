<?php 
session_start();
include("../../../inc/php/conexiones/SCA.php");
require_once("../../../inc/generales.php");
$sca=SCA::getConexion();

//$i = sizeof($_REQUEST["fecha"]);
$frm["fecha"]=$_REQUEST["fecha"];
$frm["noviajes"]=$_REQUEST["noviajes"];
$frm["camion"]=$_REQUEST["camion"];
$frm["cubicacion"]=$_REQUEST["cubicacion"];
$frm["origen"]=$_REQUEST["origen"];
$frm["tiro"]=$_REQUEST["tiro"];
$frm["ruta"]=$_REQUEST["ruta"];
$frm["material"]=$_REQUEST["material"];
$frm["primerkm"]=$_REQUEST["primerkm"];
$frm["kmsubsecuentes"]=$_REQUEST["kmsubsecuentes"];
$frm["kmadicionales"]=$_REQUEST["kmadicionales"];
//$frm["turno".$x]=$_REQUEST["turno"];
$frm["observaciones"]=$_REQUEST["observaciones"];

		$i = sizeof($frm["fecha"]);
		//echo "i:".$i."noviajee:".$frm["noviajes"][0];
$c="aqui: ";
$filas = "";
		for($x=0;$x<$i;$x++)
		{
			
			for($xx=0;$xx<$frm["noviajes"][$x];$xx++)
			{
				$SQLs="call registra_viajes_netos_viajes(".$_SESSION["Proyecto"].",'".fechasql($frm["fecha"][$x])."',".$frm["camion"][$x].",".$frm["cubicacion"][$x].",".$frm["origen"][$x].",".$frm["tiro"][$x].",".$frm["ruta"][$x].",".$frm["material"][$x].",".$frm["primerkm"][$x].",".$frm["kmsubsecuentes"][$x].",".$frm["kmadicionales"][$x].",'".$_REQUEST["turno".$x]."','".$frm["observaciones"][$x]."',".$_SESSION["IdUsuarioAc"].",@OK);";
				$c.=$SQLs."<br />";
				$r=$sca->consultar($SQLs);
				$r2=$sca->consultar("select @OK");
				$v=$sca->fetch($r2);
				$registrados+=$v["@OK"];
				$class=($v["@OK"]==1)?"green":"red";
				$resultado=($v["@OK"]==1)?"Registrado":"NO Registrado";
				
	$filas.='<tr class="'.$class.'">
    <td>1
	</td>
    <td>'.$frm["fecha"][$x].'</td>
    <td>'.$sca->regresaDatos2("camiones","Economico","IdCamion",$frm["camion"][$x]).'</td>
    <td>'.$frm["cubicacion"][$x].'</td>
    <td>'.$sca->regresaDatos2("origenes","Descripcion","IdOrigen","Descripcion",$frm["origen"][$x]).'</td>
	<td>'.$sca->regresaDatos2("tiros","Descripcion","IdTiro",$frm["tiro"][$x]).'</td>
  
    <td>R-'.$frm["ruta"][$x].'</td>
    <td>'.$sca->regresaDatos2("materiales","Descripcion","IdMaterial",$frm["material"][$x]).'</td>
    <td>'.$frm["primerkm"][$x].'</td>
    <td>'.$frm["kmsubsecuentes"][$x].'</td>
    <td>'.$frm["kmadicionales"][$x].'</td>
    <td>'.$_REQUEST["turno".$x].'</td>
	<td>'.$frm["observaciones"][$x].'</td>
	<td>'.$resultado.'</td>
	</tr>';
	
				
				
			}
		}
		//echo $c;
		if($registrados>0)
		{
			
			echo "Se han registrado: ".$registrados." viajes";	
		}
		else
		if($registrados>0)
		{
			echo "Hubo un error en el registro de los viajes, verifique que el material tenga factor de abundamiento registrado y que su sesión en la intranet no haya expirado.";	
		}
		
		
		

?>
<table class="resultados">
<thead>
  <tr>
    <th rowspan="2">#</th>
    <th rowspan="2" style="width:116px">Fecha</th>
    <th rowspan="2">Cami&oacute;n</th>
    <th rowspan="2">Cubicaci&oacute;n</th>
       <th rowspan="2">Origen</th>
    <th rowspan="2">Tiro</th>
    <th rowspan="2">Ruta</th>
    <th rowspan="2">Material</th>
    <th colspan="3">Tarifas</th>
    <th rowspan="2">Turno</th>
	 <th rowspan="2">Observaciones</th>
     <th rowspan="2">Estatus</th>
  </tr>
  <tr>
    <th>1er Km</th>
    <th>Km Subs.</th>
    <th>Km Adc.</th>
  </tr>
  </thead>
  <tbody>
<?php echo $filas;?>
    

    </tbody>
    </table>