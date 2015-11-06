<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<script src="../../Clases/Js/Cajas.js"></script>
<script language="javascript" src="../../Clases/Js/Operacion/ValidarSeleccionViajes.js"></script>
<script>
function validah(idp,hijos)
{
	papa=document.getElementById(idp);
	
	if(papa.value!='A99')
	{
		for(c=1;c<=hijos;c++)
		{
			hijoid=idp+"Origen"+c;
			
			hijo=document.getElementById(hijoid);
			//alert(hijo.name);
			//hijo.disabled=1;
			hijo.value=papa.value;
			
		}
	}
	else
	{
		for(c=1;c<=hijos;c++)
		{
			hijoid=idp+"Origen"+c;
			hijo=document.getElementById(hijoid);
			//hijo.disabled=0;
			hijo.value=papa.value;
			
		}
	}
	

}
function selecciona_cargador(val,id,hijos)
{
	for(c=0;c<hijos;c++)
		{
			hijoid=id+"_"+c;
			hijo=document.getElementById(hijoid);
			//hijo.disabled=0;
			hijo.value=val;
			
		}
}
</script>
</head>

<body onkeydown="backspace();">
<?php
	//Incluimos los Archivos a Usar
		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/Catalogos/Genericas.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");
?>

<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/Logos/Operacion/ValidaViajes.gif" width="24" height="24" align="absbottom" />SCA.- Validaci&oacute;n de Viajes Sin Orígen</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoMenu">Usted Tiene Viajes Pendientes de Validar en las Siguientes Fechas:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> </tr>
</table>

<?php
	//Obtenemos las Fechas de los Viajes Pendientes de Validar
		$Link=SCA::getConexion();
		$SQL="SELECT COUNT(viajesnetos.IdViajeNeto) AS Total, viajesnetos.FechaLlegada as Fecha FROM viajesnetos WHERE viajesnetos.Estatus = 10 AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." GROUP BY viajesnetos.FechaLlegada;";
		//echo $SQL;
		$Result=$Link->consultar($SQL);
		$Link->cerrar();

		//Guardamos las Fechas y los Totale en una Arreglo
		$Contador=0;
		while($Row=mysql_fetch_array($Result))
		 {
			$FechasValidas[$Contador][1]=$Row["Fecha"];
			$FechasValidas[$Contador][2]=$Row["Total"];
			$Contador=$Contador+1;
		 }
		 
		 //Nos Traemos los Tiros Trabajados para Cada una de las Fechas
		 $Contador=0;
  			for($a=0;$a<count($FechasValidas);$a++)
  			{
			 	$Link=SCA::getConexion();
	  			$SQL="SELECT tiros.IdTiro,tiros.Descripcion, COUNT(viajesnetos.IdTiro) AS Total FROM viajesnetos, tiros WHERE viajesnetos.IdTiro = tiros.IdTiro AND viajesnetos.FechaLlegada = '".$FechasValidas[$a][1]."' AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." AND viajesnetos.Estatus = 10 GROUP BY tiros.Descripcion";
	  			//echo "<BR><BR>usa fechas validas".$SQL;
	  			$Result=$Link->consultar($SQL);
	  			$Link->cerrar();

	  			
	  			while ($Row=mysql_fetch_array($Result))
	  			{
	  				//echo "<br>Fechas validas ".$FechasValidas[$a][1];
					$TirosPorFecha[$Contador][1]=$FechasValidas[$a][1];		//Fecha del Tiro
	  				$TirosPorFecha[$Contador][2]=$Row["Descripcion"];		//Descripcion del Tiro
	  				$TirosPorFecha[$Contador][3]=$Row["Total"];				//Total de Viajes Por Tiro
	  				$TirosPorFecha[$Contador][4]=$Row["IdTiro"];			//Id Del Tiro
					//echo "<br>Tiros por fecha: ".$TirosPorFecha[$Contador][1];
	  				$Contador=$Contador+1;
					
	  			}
  			}
			
#########################//Nos traemos los Camiones por Tiro y para la Fecha Correspondiente
				$Contador=0;
  				for($c=0;$c<count($TirosPorFecha);$c++)
  				{
          			$Link=SCA::getConexion();
					$SQL="SELECT viajesnetos.IdCamion, camiones.Economico, count(camiones.Economico) AS Total FROM viajesnetos, camiones WHERE viajesnetos.IdProyecto=".$_SESSION['Proyecto']." AND viajesnetos.FechaLlegada = '".$TirosPorFecha[$c][1]."' AND viajesnetos.IdTiro = ".$TirosPorFecha[$c][4]." AND viajesnetos.Estatus = 10 AND viajesnetos.IdCamion = camiones.IdCamion GROUP BY camiones.Economico";
					//echo "<br><br>Consulta para Trear los camiones por Fecha y Tiro: ".$SQL;
					$Result=$Link->consultar($SQL);
					$Link->cerrar();
					
					while($Row=mysql_fetch_array($Result))
					{
						$CamionesPorFechaYTiro[$Contador][1]=$TirosPorFecha[$c][1];		//Fecha del Viaje
						$CamionesPorFechaYTiro[$Contador][2]=$TirosPorFecha[$c][4];		//Id Del Tiro del Viaje
						$CamionesPorFechaYTiro[$Contador][3]=$Row["IdCamion"];			//Id Del Camion
						$CamionesPorFechaYTiro[$Contador][4]=$Row["Economico"];			//Economico del Camion
						$CamionesPorFechaYTiro[$Contador][5]=$Row["Total"];				//Total de Viajes por Camión
						
						//echo "<br>Fecha: ".$CamionesPorFechaYTiro[$Contador][1];
						//echo "<br>IdTiro: ".$CamionesPorFechaYTiro[$Contador][2];
						//echo "<br>IdCamion: ".$CamionesPorFechaYTiro[$Contador][3];
						//echo "<br>Economico: ".$CamionesPorFechaYTiro[$Contador][4];
						//echo "<br>Total: ".$CamionesPorFechaYTiro[$Contador][5];
						
						$Contador=$Contador+1;
					}
				}

				//echo "<br>Total de camiones Involucrados: ".count($CamionesPorFechaYTiro);			
			
			################################
			
			
			
			
			//Obtenemos los Datos de los Viajes por Camion, Tiro, y fecha
					$Contador=0;
					for($d=0;$d<count($CamionesPorFechaYTiro);$d++)
					{
						$Link=SCA::getConexion();
				  		$SQL="SELECT camiones.Economico AS Economico, materiales.Descripcion AS Material, materiales.IdMaterial, ROUND((HOUR(TIMEDIFF(viajesnetos.HoraLlegada,viajesnetos.HoraSalida))*60)+(MINUTE(TIMEDIFF(viajesnetos.HoraLlegada,viajesnetos.HoraSalida)))+(SECOND(TIMEDIFF(viajesnetos.HoraLlegada,viajesnetos.HoraSalida))/60),2) AS TiempoViajeMinutos, camiones.IdCamion, viajesnetos.IdViajeNeto,camiones.CubicacionParaPago FROM viajesnetos, camiones, tiros, materiales WHERE camiones.IdCamion = viajesnetos.IdCamion AND tiros.IdTiro = viajesnetos.IdTiro AND viajesnetos.IdMaterial = materiales.IdMaterial  AND viajesnetos.IdProyecto=".$_SESSION['Proyecto']." AND viajesnetos.FechaLlegada = '".$CamionesPorFechaYTiro[$d][1]."' AND viajesnetos.IdTiro=".$CamionesPorFechaYTiro[$d][2]." AND viajesnetos.IdCamion=".$CamionesPorFechaYTiro[$d][3]."  AND viajesnetos.Estatus = 10  ORDER BY camiones.Economico,viajesnetos.FechaLlegada, viajesnetos.HoraLlegada;";
				  		//echo "<br><br>Consulta para obtener Viajes por fecha, Tiro y Camión: ".$SQL;
				  		$Result=$Link->consultar($SQL);
				  		$Link->cerrar();	
							
						while ($Row=mysql_fetch_array($Result))
				  		{
						
							$ViajesPorTiro[$Contador][1]=$CamionesPorFechaYTiro[$d][1];			//Fecha del Viaje
				  			$ViajesPorTiro[$Contador][2]=$CamionesPorFechaYTiro[$d][2];	
		  				$ViajesPorTiro[$Contador][3]=$Row["Economico"];				//Descripcion del Economico del Camion
		  				//$ViajesPorTiro[$Contador][4]=$Row["Origen"];				//Descripcion del Origen del Camion
		  				$ViajesPorTiro[$Contador][5]=$Row["Material"];				//Tipo de Material del Viaje
		  				//$ViajesPorTiro[$Contador][6]=$Row["TiempoViajeMinutos"];	//Tiempo de Viaje
		  				//$ViajesPorTiro[$Contador][7]=$Row["IdOrigen"];				//Id del Origen
		  				$ViajesPorTiro[$Contador][8]=$Row["IdCamion"];				//Id del Camión
		  				//$ViajesPorTiro[$Contador][9]=RegresaRutaViaje($_SESSION['Proyecto'],$ViajesPorTiro[$Contador][7],$ViajesPorTiro[$Contador][2]);		//Id de la Ruta del Viaje
		  				//$ViajesPorTiro[$Contador][10]=RegresaDistanciaRuta($ViajesPorTiro[$Contador][9]);
		  				$ViajesPorTiro[$Contador][11]=$Row["IdMaterial"];			//Id del Material
		  				//$ViajesPorTiro[$Contador][12]=RegresaImporteViaje($ViajesPorTiro[$Contador][9]);		//Importe del Viaje
		  				//$ViajesPorTiro[$Contador][13]=RevisaCronometria($ViajesPorTiro[$Contador][6],$ViajesPorTiro[$Contador][9]);  //Revion de cronometria
		  				$ViajesPorTiro[$Contador][14]=$Row["IdViajeNeto"];	
						$ViajesPorTiro[$Contador][15]=$Row["CubicacionParaPago"];				//Id del Viaje
						
				  			

				  			$Contador=$Contador+1;
				  		}
					}
					
					
					//echo "<br>Total de Viajes Realizados: ".count($ViajesPorTiro);
					
			
			//Nos traemos los Viajes por tiro y para la fecha correspondiente

  				$Contador=0;
		
		//echo '<br>Total de tiros por fecha: '.count($TirosPorFecha);


?>



<table width="840" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
   </tr>
  </table>

<table width="845" border="0" align="center" cellpadding="0" cellspacing="0">
  <?php
  	//Mostramos las Fechas Validas
  	for ($a=0;$a<count($FechasValidas);$a++)
  	{
  ?>
  <tr>
    <td width="26">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td><img style="display:none;cursor:hand"  id="menosfechas<?php echo $a; ?>" src="../../Imgs/16-square-red-remove.gif" width="16" height="16" onclick="cambiarDisplay('fechas<?php echo $a; ?>');cambiarDisplay('masfechas<?php echo $a; ?>');cambiarDisplay('menosfechas<?php echo $a; ?>')" onmouseover="this.src='../../Imgs/16-square-blue-remove.gif'" onmouseout="this.src='../../Imgs/16-square-red-remove.gif'" /> <img style="cursor:hand" src="../../Imgs/16-square-red-add.gif" id="masfechas<?php echo $a; ?>" onclick="cambiarDisplay('fechas<?php echo $a; ?>');cambiarDisplay('menosfechas<?php echo $a; ?>');cambiarDisplay('masfechas<?php echo $a; ?>')" width="16" height="16" onmouseover="this.src='../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../Imgs/16-square-red-add.gif'"/> </td>
    <td width="25"><img src="../../Imgs/calendarp.gif" width="15" height="16" /></td>
    <td colspan="3">&nbsp;<?php echo fecha($FechasValidas[$a][1])." ==> ".$FechasValidas[$a][2]; ?> Viajes</td>
  </tr>
  <tr>
  <!-- style="display:none"  -->
    <td colspan="5"><table id="fechas<?php  echo $a;?>" style="display:none"  >
      <?php
	  	//Mostramos los Tiros Trabajados en esa Fechastyle="display:none"
			for($b=0;$b<count($TirosPorFecha);$b++)
			{
				if($FechasValidas[$a][1]==$TirosPorFecha[$b][1])
				{
	  ?>
      <tr>
        <td width="12">&nbsp;</td>
        <td width="26"><img onmouseover="this.src='../../Imgs/16-square-blue-remove.gif'" onmouseout="this.src='../../Imgs/16-square-red-remove.gif'" style="display:none;cursor:hand" id="-f<?php echo $a;  ?>t<?php echo $b;?>" src="../../Imgs/16-square-red-remove.gif" width="16" height="16" onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;?>')" /> <img onmouseover="this.src='../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../Imgs/16-square-red-add.gif'" style="cursor:hand" id="+f<?php echo $a;  ?>t<?php echo $b;?>" src="../../Imgs/16-square-red-add.gif" width="16" height="16" onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;?>')" /> </td>
        <td width="24"><img src="../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
        <td width="763" colspan="2">&nbsp;<?php echo $TirosPorFecha[$b][2]." ==> ".$TirosPorFecha[$b][3]; ?> Viajes</td>
      </tr>
      
     
      <tr>
       <!-- style="display:none"  -->
        <td colspan="5"><table id="f<?php echo $a;  ?>t<?php echo $b;?>" style="display:none" >
          <form action="3VerificaVI.php" method="post" name="frm<?php echo $b; ?>" id="frm<?php echo $b; ?>">
            <?php
					  	//Mostramos los Camiones que Trabajaron Por Tiro y por Fecha
						$NumViaje=0;
					  	for($c=0;$c<count($CamionesPorFechaYTiro);$c++)
						{
							if(($TirosPorFecha[$b][1]==$CamionesPorFechaYTiro[$c][1])and($TirosPorFecha[$b][4]==$CamionesPorFechaYTiro[$c][2]))
							{
								
					  ?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td><img onmouseover="this.src='../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../Imgs/16-square-red-add.gif'" style="cursor:hand" id="+f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>" src="../../Imgs/16-square-red-add.gif" onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>')" width="16" height="16" /> <img onmouseover="this.src='../../Imgs/16-square-blue-remove.gif'" onmouseout="this.src='../../Imgs/16-square-red-remove.gif'" id="-f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>" src="../../Imgs/16-square-red-remove.gif" style="display:none;cursor:hand"  onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>')" width="16" height="16" /> </td>
              <td width="26"><img  src="../../Imgs/16-Bus.gif" width="16" height="16" /></td>
              <td width="741">&nbsp;<?php echo $CamionesPorFechaYTiro[$c][4]." ==> ".$CamionesPorFechaYTiro[$c][5]; ?> Viajes</td>
            </tr>
            <tr id="f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>" style="display:none">
              <td colspan="5"><table>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td ><table  width="731" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
                  <tr>
                             
                              <td colspan="6" class="EncabezadoTabla"><div align="right">Origen de Todos los Viajes:</div></td>
                              <td colspan="1" class="Item1">&nbsp;
                              <?php SeleccionaOrigen($_SESSION['Proyecto'],'Origenp'.$c,"Hola",$CamionesPorFechaYTiro[$c][5],$TirosPorFecha[$b][4]); ?></td>
                               <td colspan="2" class="EncabezadoTabla"><div align="right">Cargador:</div></td>
                               <td class="Item1">&nbsp;
                              <?php  combo_cargador_padre("maquinaria","Economico","IdMaquinaria",$a.'_'.$b.'_'.$c,$CamionesPorFechaYTiro[$c][5]); ?></td>
                            </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td align="center"><img src="../../Imgs/16-Cubicacion.gif" width="16" height="16" /></td>
                      <td align="center"><img src="../../Imgs/16-Materiales.gif" width="16" height="16" /></td>
                       <td width="142" align="center"><img src="../../Imgs/16-Origenes.gif" width="16" height="16" /></td>
                      <td align="center"><img src="../../Imgs/16-Distancia.gif" width="16" height="16" /></td>
                      <td align="center"><img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" /></td>
                      <td align="center">&nbsp;</td>
                      <td align="center">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="EncabezadoTabla">#</td>
                      <td class="EncabezadoTabla">?</td>
                      <td class="EncabezadoTabla"><img src="../../Imgs/Check.gif" width="16" height="16" /></td>
                      <td class="EncabezadoTabla"><img src="../../Imgs/Cross.gif" width="16" height="16" /></td>
                      <td class="EncabezadoTabla">Cubic.</td>
                      <td class="EncabezadoTabla">Material</td>
                      <td align="center" class="EncabezadoTabla">Origen</td>
                      <td class="EncabezadoTabla">Distancia</td>
                      <td class="EncabezadoTabla">Importe</td>
                      <td class="EncabezadoTabla">Cargador</td>
                      <td class="EncabezadoTabla">H. Ef.</td>
                    </tr>
                    <?php
								  	
									//Mostramos Los Viajes Por Camion, Tiro y Fecha
									
									$Contador=1;
									for($d=0;$d<count($ViajesPorTiro);$d++)
									{	
										if(($CamionesPorFechaYTiro[$c][1]==$ViajesPorTiro[$d][1])and($CamionesPorFechaYTiro[$c][2]==$ViajesPorTiro[$d][2])and($CamionesPorFechaYTiro[$c][3]==$ViajesPorTiro[$d][8]))
										{		
										
								  ?>
                    <tr  id="fil<?php echo $ViajesPorTiro[$d][14]; ?>">
                      <td valign="top" class="Item1">&nbsp;<?php echo $Contador; ?>&nbsp;</td>
                      <td class="Item1"><img src="../../Imgs/16-Message-Warn.gif" width="16" height="16" /></td>
                      <td align="center"  class="Item1"><?php
                                		if($ViajesPorTiro[$d][13]==1)
							 			{ echo'<input name="Viaje'.$NumViaje.'" type="checkbox"  value="'.$ViajesPorTiro[$d][14].'" checked="checked" />'; }
							 			else
							 			{ echo'<input name="Viaje'.$NumViaje.'" id="Frm'.$c.'Viaje'.$NumViaje.'" onclick="cambia1(\'Frm'.$c.'Viaje'.$NumViaje.'\',\'Frm'.$c.'ViajeRechazado'.$NumViaje.'\')" type="checkbox" value="'.$ViajesPorTiro[$d][14].'"  checked="checked"/>'; }
									?>                              </td>
                              <td align="center"  class="Item1"><?php
                                		if($ViajesPorTiro[$d][13]==1)
							 			{ echo'<input name="ViajeRechazado'.$NumViaje.'" type="checkbox" value="'.$ViajesPorTiro[$d][14].'"  />'; }
							 			else
							 			{ echo'<input name="ViajeRechazado'.$NumViaje.'" id="Frm'.$c.'ViajeRechazado'.$NumViaje.'" onclick="cambia2(\'Frm'.$c.'Viaje'.$NumViaje.'\',\'Frm'.$c.'ViajeRechazado'.$NumViaje.'\')" type="checkbox" value="'.$ViajesPorTiro[$d][14].'" />'; }
									?>                              </td>
                      <td align="right" valign="top" class="Item1">&nbsp;<?php echo $ViajesPorTiro[$d][15]; ?>&nbsp;m&sup3;&nbsp;&nbsp;&nbsp;</td>
                      <td align="left" valign="top" class="Item1">&nbsp;<?php echo $ViajesPorTiro[$d][5]; ?>&nbsp;&nbsp;&nbsp;</td>
                      <td class="Item1">
                              <?php SeleccionaOrigenH($_SESSION['Proyecto'],'Origenp'.$c.'Origen'.$Contador,'Origen'.$NumViaje,"Hola",$TirosPorFecha[$b][4]); ?></td>
                      <td align="right" valign="top" class="Item1"><img src="../../Imgs/16-Question.gif" alt="" width="16" height="16" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                      <td class="Item1" valign="top" align="right"><img src="../../Imgs/16-Question.gif" alt="" width="16" height="16" />&nbsp;&nbsp;
                                  <input type="hidden" name="Tiempo<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][6]; ?>" />
                                  <input type="hidden" name="Ruta<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][9]; ?>" />
                                  <input type="hidden" name="Distancia<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][10]; ?>" />
                                  <input type="hidden" name="Importe<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$c][16]; ?>" />
                                  <input type="hidden" name="Cubicacion<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][15]; ?>" />
                                  <input type="hidden" name="ImportePrimerKM<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][27]; ?>" />
                                  <input type="hidden" name="ImporteKMSub<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][28]; ?>" />
                                  <input type="hidden" name="ImporteKMAdc<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][29]; ?>" />
                                  <input type="hidden" name="VolumenPrimerKM<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][23]; ?>" />
                                  <input type="hidden" name="VolumenKMSub<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][24]; ?>" />
                                  <input type="hidden" name="VolumenKMAdc<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][25]; ?>" />
                                  <input type="hidden" name="Volumen<?php echo $NumViaje; ?>" value="<?php echo $ViajesPorTiro[$d][26]; ?>" /> 
                                  <input type="hidden" name="Tiro<?php echo $NumViaje; ?>" value="<?php echo $TirosPorFecha[$b][4]; ?>" />                        </td>
                                  <td class="Item1"><?php combo_cargador_hijo("maquinaria","Economico","IdMaquinaria",$a.'-'.$b.'-'.$c,$NumViaje); ?></td>
                                   <td class="Item1"><input name="hef<?php echo $NumViaje; ?>" type="text" class="Casillas_small" size="5" maxlength="7" onkeypress="onlyDigits(event,'decOK')"  /></td>
                    </tr>
                    <?php
								  		
											$Contador=$Contador+1;
											$NumViaje=$NumViaje+1;
										}
										
									}
									
									
								  ?>
                    
                  </table></td>
                </tr>
              </table></td>
            </tr>
            <?php
					  		}
						}
						
					  ?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right">&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td align="right"><input name="TotalV" type="hidden" value="<?php echo $TirosPorFecha[$b][3]; ?>" />
              <input type="hidden" name="selectpadre" value="<?php echo 'Origenp'.$b; ?>" id="hiddenField" />
                      <input name="button2" type="submit" class="boton" id="button2" value="Registrar Viajes" />
                &nbsp;</td>
            </tr>
          </form>
        </table></td>
      </tr>
      <?php
	  			}
			}
	  ?>
    </table></td>
  </tr>
  <?php
   	}
   ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td width="582">&nbsp;</td>
    <td width="111">&nbsp;</td>
    <td width="110">&nbsp;</td>
  </tr>
</table>
</body>
</html>

