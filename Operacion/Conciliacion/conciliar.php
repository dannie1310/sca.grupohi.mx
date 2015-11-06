<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");
$link=SCA::getConexion();

$IdProyecto=$_SESSION['Proyecto'];
$inicial = $_REQUEST['inicial'];
$final = $_REQUEST['final'];
$sindicato = $_REQUEST['sindicatos'];
$observaciones = $_REQUEST['observaciones'];
$idruta= $_REQUEST['rutas'];
if ($_REQUEST['rutas']) 
	$sqlrruta=" and v.idruta in (".implode(",", $idruta).")";
else $sqlrruta="";
	

$sql = "Select IdViaje from viajes v
			left join camiones c using (IdCamion)
			left join sindicatos s USING (IdSindicato)
			left join conciliacion_detalle cd USING (idviaje) 
			left join conciliacion conc ON cd.idconciliacion=conc.idconciliacion 
			left join conciliacion_rutas cr ON cr.idconciliacion=conc.idconciliacion 
			where v.Fechallegada between '".fechasql($inicial)."' and '".fechasql($final)."' and 
			s.IdSindicato=$sindicato $sqlrruta";

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0){
	if(isset($_REQUEST['id'])){
		$id = $_REQUEST['id'];
	}else{
	 	$select_conciliacion = "SELECT * FROM conciliacion c 
									left join conciliacion_rutas cr using (IdConciliacion) 
									WHERE idsindicato=".$sindicato." 
										and fecha_inicial='".fechasql($inicial)."' and fecha_final='".fechasql($final)."'
										and cr.IdRuta in(".implode(",", $idruta).")";
	 	
		$result_conciliacion=$link->consultar($select_conciliacion);
		$n = mysql_num_rows($result_conciliacion);
		if($n==0){
			 $insert = "INSERT INTO conciliacion (
									idsindicato,
									fecha_conciliacion,
									fecha_inicial,
									fecha_final,
									estado,
									observaciones
								) VALUES (
								".$sindicato.",
								'".date('Y-m-d')."',
								'".fechasql($inicial)."',
								'".fechasql($final)."',
								1,
								'".$observaciones."')";
							//echo $insert;
			$result_insert=$link->consultar($insert);
			$id = mysql_insert_id();
			if($id)
				foreach ($idruta as $key => $value) {
					$sqlrutas = "INSERT INTO conciliacion_rutas (idconciliacion, idruta) VALUES ($id, $value)";
					$link->consultar($sqlrutas);
				}
		}else{
			$row_conciliacion = mysql_fetch_array($result_conciliacion);
			$id = $row_conciliacion["idconciliacion"];
		}
	}

?>

<table border="0" align="center" width="90%">

  <!--<tr>
    <td colspan="2"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS EN EL PER&Iacute;ODO DEL <font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>-->

  <tr>
    <td colspan="5"><font color="#000000" face="Trebuchet MS" style="font-size:12px;">PROYECTO: <strong><?php echo regresa("Proyectos","Descripcion","IdProyecto",$IdProyecto)?></strong></font></td>
    <td colspan="5">&nbsp;</td>
	<td><input type="button" value="Regresar a Conciliaciones" class="boton" onclick='javascript:location.href="index.php"'/></td>
  </tr>
  <tr>
  	<td colspan="5"><font color="#000000" face="Trebuchet MS" style="font-size:12px;">FOLIO:<strong><?php echo $id; ?></strong></font></td>
  </tr>
  <tr>
  	<td colspan="5"><font color="#000000" face="Trebuchet MS" style="font-size:12px;">SINDICATO:<strong><?php echo regresa("Sindicatos","Descripcion","IdSindicato",$sindicato)?></strong></font></td>
  </tr>
  <tr>
  <td colspan="5"><font color="#000000" face="Trebuchet MS" style="font-size:12px;">PERIODO:<strong><?php echo $inicial;?> al <?php echo $final;?></strong></font></td>
  </tr>
  <tr>
  	<td colspan="5">&nbsp;</td>
    <td colspan="5">&nbsp;</td>
	<td>
			<label ><font color="#000000" face="Trebuchet MS" style="font-size:12px;">C&Oacute;DIGO DE TICKET</font></label>
			<input type="text" id="codevalue" value="" >
			<input type="button" id="buttoncode" value="Buscar" >
			<label id="msjticket"></label>
	</td>

  	
  </tr>
  <!--<tr>
  	<td>&nbsp;</td>
  </tr>-->
</table>
<table border="0" align="center" >
        <tr bgcolor="#0A8FC7">
          <!--<td>&nbsp;</td>-->
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">MATERIAL</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">ORIGEN</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">DESTINO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">HORA SALIDA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">HORA LLEGADA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">VIAJES</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">DIST.</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">VOLUMEN TOTAL</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">IMPORTE TOTAL</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold;">TICKET</font></div></td>
          
        </tr>
		<?php
		  $sql = "select * from viajes v
		 left join
		    conciliacion_detalle cd on (cd.idviaje=v.idviaje and idconciliacion=$id)
		left join camiones c using (IdCamion)
		left join sindicatos s using (IdSindicato)
		where FechaLlegada BETWEEN '".fechasql($inicial)."' and '".fechasql($final)."' and v.IdProyecto=".$IdProyecto." 
		and s.IdSindicato=$sindicato $sqlrruta ORDER BY idconciliacion desc, FechaLlegada, HoraLlegada"; 
		// "ORDER BY c.Economico,v.FechaLlegada,v.HoraLlegada";
		//limitar busqueda and IdViaje NOT IN (SELECT IdViaje FROM conciliacion_detalle)
		//echo $sql;
		/*$sql = "SELECT DISTINCT(v.IdCamion), c.Economico 
		FROM viajes v 
		LEFT JOIN camiones c ON c.IdCamion = v.IdCamion 
		LEFT JOIN sindicatos s ON s.IdSindicato = c.IdSindicato 
		WHERE s.IdSindicato=".$sindicato." 
		AND v.FechaLlegada BETWEEN '".fechasql($inicial)."' and '".fechasql($final)."'
		AND v.IdProyecto = ".$IdProyecto."
		ORDER BY c.Economico";
		//echo $sql;*/
		$result=$link->consultar($sql);
  		while($row=mysql_fetch_array($result)){
			$sql2 ="select * from conciliacion_detalle where IdViaje=".$row["IdViaje"]." and idconciliacion=$id ";
			$result2=$link->consultar($sql2);
			$n= mysql_num_rows($result2);
			if($n==1){
				$class="checkbox ingresado";
				}else{
					$class="checkbox";
					}
  			//$row2=mysql_fetch_array($result2);
			/*$sql2 = "SELECT DISTINCT(FechaLlegada), c.Economico 
				FROM viajes v 
				LEFT JOIN camiones c ON c.IdCamion = v.IdCamion 
				LEFT JOIN sindicatos s ON s.IdSindicato = c.IdSindicato 
				WHERE s.IdSindicato=".$sindicato." 
				AND v.FechaLlegada BETWEEN '".fechasql($inicial)."' and '".fechasql($final)."'
				AND v.IdProyecto = ".$IdProyecto."
				AND v.IdCamion=".$row["IdCamion"]."
				ORDER BY c.Economico, FechaLlegada";
			$result2=$link->consultar($sql2);
  			while($row2=mysql_fetch_array($result2)){
					$sql3 = "select *,fn_devuelve_tarifa(TipoTarifa,IdTarifa,'p_km') as 'PU1Km', 
			fn_devuelve_tarifa(TipoTarifa,IdTarifa,'s_km') as 'PUSub', 
			fn_devuelve_tarifa(TipoTarifa,IdTarifa,'a_km') as 'PUAdc' from viajes 
					where IdCamion=".$row["IdCamion"]." 
					and FechaLlegada='".$row2["FechaLlegada"]."' 
					and IdProyecto=".$IdProyecto."";
					$result3=$link->consultar($sql3);
  					while($row3=mysql_fetch_array($result3)){*/
					?>
                <tr idcode="<?php echo strtoupper($row['code'])?>" style="color:#000000; font-size:8px;" id="<?php echo $row["IdViaje"];?>" conciliacion="<?php echo $id;?>" class="<?php echo $class;?>">
                    <td><?php echo regresa("Camiones","Economico","IdCamion",$row["IdCamion"]);?></td>
                    <td><?php echo $row["FechaLlegada"];?></td>
                    <td><?php echo regresa("Materiales","Descripcion","IdMaterial",$row["IdMaterial"]);?></td>
                    <td><?php echo regresa("Origenes","Descripcion","IdOrigen",$row["IdOrigen"]);?></td>
                    <td><?php echo regresa("Tiros","Descripcion","IdTiro",$row["IdTiro"]);?></td><td>
                        <?php echo $row["HoraSalida"];?></td>
                    <td><?php echo $row["HoraLlegada"];?></td>
                    <td>1</td>
                    <td><?php echo $row["CubicacionCamion"];?></td>
                    <td>1</td>
                    <td><?php echo $row["Distancia"];?></td>
                    <td align="right"><?php echo  number_format($row["VolumenPrimerKM"]+$row["VolumenKMSubsecuentes"]+$row["VolumenKMAdicionales"],2,".",",");?></td>
                    <td align="right"><?php echo  number_format($row["ImportePrimerKM"]+$row["ImporteKMSubsecuentes"]+$row["ImporteKMAdicionales"],2,".",",");?></td>
                     <td><?php echo strtoupper($row["code"]);?></td>
                </tr>
                	<?php
					/*}

				}*/

			}
  
		?>
		</table>
<?php }else{
	?>
	<table width="600" align="center" style="color:#333;">
    	<tr><td class="Titulo">NO EXISTEN VIAJES PENDIENTES DE CONCILIAR</td></tr>
   		<tr><td class="Titulo"> EN EL PERIODO</td></tr>
   		<tr><td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></td>
   </tr>
		<tr><td class="Titulo"><input type="button" value="Aceptar" class="boton" onclick='javascript:location.href="index.php"'/></td></tr>
	</table>
<?php
	}
?>
<script type="text/javascript">
$(document).ready(function(){
	$('#codevalue').focus();
	
});

</script>
