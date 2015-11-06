<?php
	session_start();
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Acarreos Ejecutados por Origen Semanal (Detallado) '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Trebuchet MS;
	font-size: 9px;
	color: #0099CC;
}
-->
</style>

<style type="text/css">
<!--
.Estilo4 {font-size: 1px; color: #cccccc; }
-->
</style>
</head>

<body>

<?php
	include ("../../../../inc/php/conexiones/SCA.php");
	include ("../../../../Clases/Funciones/Rangos.php");
	$link=SCA::getConexion();
	


	function regresac($cambio,$select)
{
	$partes=explode("-", $cambio); 
	$dia=$partes[2];
	$mes=$partes[1];
	$año=$partes[0];
	if ($select==1)
	return ($dia);
	else
	if($select==2)
	return ($mes);
	else
	if($select==3)
	return ($año);
	
}
	$rowspan='';
	$totalT='';
	$sumasT1='';
	$sumasT2='';
	$sumasT3='';
	$sumasT4='';
	$sumasT5='';
	$sumasT6='';
	$Anio=substr($_POST["Semana"],0,4);
	$Semana=substr($_POST["Semana"],4,2);
	$banco="Select distinct viajes.IdOrigen as IdOrigen, origenes.Descripcion as Origen from viajes, origenes where viajes.IdProyecto = ".$_SESSION["Proyecto"]." AND year(viajes.FechaSalida) = ".$Anio." and weekofyear(viajes.FechaSalida) = ".$Semana." and viajes.IdOrigen=origenes.IdOrigen order by Origen";
	
	$r=$link->consultar($banco);
?>

	<table  border="0" align="left">
			  <tr>
			    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="6"></td>
                <td colspan="6"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
      </tr>
			  <tr>
		    <td colspan="47"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">REPORTE DE ACARREOS EJECUTADOS EN LA SEMANA: </font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $Semana; ?> </font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">DEL A&Ntilde;O:</font> <font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $Anio; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">&nbsp; </font></td>
      </tr>
		  <tr>
		    <td colspan="47"><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:12px;">POR ORIGEN, DESTINO Y MATERIAL</font></td>
      </tr>
		  <tr>
		    <td colspan="47"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:12px;">PROYECTO : </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:12px;"><?PHP echo $_SESSION["DescripcionProyecto"];  ?></font></td>
      </tr>
		  <tr>
		    <td colspan="47">&nbsp;</td>
      </tr>
		<?php
		while($v=mysql_fetch_array($r))
		{$totalesT='';
		 $sumasST1='';
		 $sumasST2='';
		 $sumasST3='';
		 $sumasST4='';
		 $sumasST5='';
		 $sumasST6='';
		 ?>
		  
		  <tr>
		    <td colspan="47">&nbsp;</td>
      </tr>
		  <tr>
			<td colspan="47"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $v[Origen]; ?></font></td>
		  </tr>
				  <?PHP
				  $tiro="select distinct v.IdTiro as IdTiro, t.Descripcion as Tiro from viajes as v, tiros as t where v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdOrigen=".$v[IdOrigen]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and v.IdTiro=t.IdTiro order by Tiro";
				  //echo $tiro;
				  $rt=$link->consultar($tiro);
				   $ros=0;
				   
				  while($vt=mysql_fetch_array($rt))
					 {?>
				  <tr>
					<td >&nbsp;</td>
					<td colspan="46"><font color="#000000"; style="font-size:10px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $vt[Tiro]; ?></font></td>
				  </tr>
				  
				  <?php 
				   $material="select distinct v.IdMaterial as IdMaterial, m.Descripcion as Material from viajes as v, materiales as m where v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and v.IdMaterial=m.IdMaterial order by Material desc";
				  //echo $tiro;
				  $rm=$link->consultar($material);
				 
				  
				  while($vm=mysql_fetch_array($rm))
					 {
					
				  
				  ?>
					   
					   <tr>
						<td >&nbsp;</td>
						<td >&nbsp;</td>
					    <td colspan="45"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $vm[Material]; ?></font></td>
				      </tr>
					  
				 	  <?php
					  
					  //Obtenemos el Rango de Fechas que Compone la Semana a Consultar
								$dias="SELECT DISTINCT viajes.FechaSalida, weekday(viajes.FechaSalida) AS Dia FROM viajes WHERE viajes.IdProyecto = ".$_SESSION["Proyecto"]." AND weekofyear(viajes.FechaSalida) = ".$Semana." AND year(viajes.FechaSalida) = ".$Anio." ORDER BY viajes.FechaSalida;";
								//echo "<br><br>".$SQL;
								$Result=$link->consultar($dias);
								
							
								$Contador=0;
								while($Row=mysql_fetch_array($Result))
								{
									$DiasTrabajados[$Contador][1]=$Row["FechaSalida"];	//Fecha Completa
									$DiasTrabajados[$Contador][2]=$Row["Dia"];	//Dia de la Semana 0=Lunes
									$Contador=$Contador+1;
								}
								//Completamos a que sean 7 Dias por semana
								$el=0;
									for($a=0;$a<7;$a++)
									{
										for($b=0;$b<count($DiasTrabajados);$b++)
										{
											if($a==$DiasTrabajados[$b][2])
											{ 
											
													$DiasDeLaSemana[$a]=$DiasTrabajados[$b][1]; 
													if($el==0)
													{
														$mes=regresac($DiasDeLaSemana[$a],2);
														$dia=regresac($DiasDeLaSemana[$a],1);
														$anio=regresac($DiasDeLaSemana[$a],3);
														$diaAño=date(z,mktime(0,0,0,$mes,$dia,$anio));	
														$segundos=date(U,mktime(0,0,0,$mes,$dia,$anio));
														$segundosIni=$segundos-($a*86400);
														$segundosFin=$segundos+(518400-($a*86400));
														$inicio=$diaAño-$a;
														$fins=$diaAño+(6-$a);
		
														$ini=date("d-m-Y",$segundosIni);
														$fin=date("d-m-Y",$segundosFin);
														$rango=rango($ini,$fin,1);
													}
													$el++;
											
											
											}
											else
											{ $DiasDeLaSemana[$a]=" - - - -"; }
										}
									}
									
												  
													  
													   ?>
			 	     <tr>
						<td >&nbsp;</td>
						<td >&nbsp;</td>
					    <td >&nbsp;</td>
                        <td >&nbsp;</td>
 	                    <td >&nbsp;</td>
 	                    <td colspan="5" align="center" bgcolor="969696"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[0]; ?></font></td>
 	                    <td colspan="5" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[1]; ?></font></td>
 	                    <td colspan="5" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[2]; ?></font></td>
 	                    <td colspan="5" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[3]; ?></font></td>
 	                    <td colspan="5" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[4]; ?></font></td>
 	                    <td colspan="5" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:11px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[5]; ?></font></td>
 	                    <td colspan="5" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:10px;font-family:'Trebuchet MS';font-weight:bold"><?php echo $rango[6]; ?></font></td>
 	                    <td  rowspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td>
 	                    <td colspan="6" align="center" bgcolor="333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">TOTALES</font></td>
      </tr>
	                 
       <tr>
				 	     <td>&nbsp;</td>
				 	     <td>&nbsp;</td>
				 	     <td>&nbsp;</td>
				 	     <td>&nbsp;</td>
				 	     <td>&nbsp;</td>
				 	     <td align="center" bgcolor="C0C0C0">&nbsp;</td>
				 	     <td colspan="2" align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>
				 	     <td align="center" bgcolor="#969696">&nbsp;</td>
						 <td colspan="2" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>
 	     <td align="center" bgcolor="#C0C0C0">&nbsp;</td>
						 <td colspan="2" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>
 	     <td align="center" bgcolor="#969696">&nbsp;</td>
				 	     <td colspan="2" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>
 	     <td align="center" bgcolor="#C0C0C0">&nbsp;</td>
				 	    <td colspan="2" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>		 	  
		 <td align="center" bgcolor="#969696">&nbsp;</td>
				 	     <td colspan="2" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>
 	     <td align="center" bgcolor="#C0C0C0">&nbsp;</td>
<td colspan="2" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font></td>
				 	     <td colspan="2" align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">IMPORTE&nbsp;($)</font></td>
         <td  align="center" bgcolor="808080">&nbsp;</td>
                         <td colspan="2" align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">VOLUMEN&nbsp;(m<sup>3</sup>)</font><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold"></font></td>
                         <td colspan="3" align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">IMPORTE &nbsp;($)</font><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold"></font></td>
      </tr>
	   
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center" bgcolor="969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">CAMI&Oacute;N</font></td>
        <td align="center" bgcolor="969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">CAPACIDAD</font></td>
        <td align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td align="center" bgcolor="C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUB. </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUBS. </font></td>
        <td align="center" bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td  bgcolor="#969696"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUBS. </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">VIAJES</font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUBS. </font></td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">PRIMER KM</font> </td>
        <td align="center" bgcolor="#C0C0C0"><font color="#000000"; style="font-size:9px;font-family:'Trebuchet MS';font-weight:bold">KM SUBS. </font></td>
        <td align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">VIAJES</font></td>
        <td align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">PRIMER KM </font></td>
        <td align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">KM SUBS.</font> </td>
        <td align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">PRIMER KM</font></td>
        <td align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">KM SUBS. </font></td>
        <td align="center" bgcolor="808080"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#FFFFFF">TOTAL</font></td>
      </tr>
	  
	  
						  <?php 
						  #Es el total de Viajes
						  $camiones="select  distinct v.IdCamion as IdCamion, sum(Importe) as TotalImporte, sum(ImporteKMSubsecuentes) as TotalImpS, sum(ImportePrimerKM) as TotalImp1, sum(VolumenPrimerKM) as TotalVol1, sum(VolumenKMSubsecuentes) as TotalVolS, count(v.IdViaje) as viajes, c.CubicacionParaPago as Capacidad, c.Economico as Camion from camiones as c, viajes as v where v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By IdCamion order by Camion";
						  
						  $rc=$link->consultar($camiones);
						  $sumas1='';
						  $sumas2='';
						  $sumas3='';
						  $sumas4='';
						  $sumas5='';
						  $sumas6='';
						  $totales='';
						  //$sumaviajes1[1]=0
						  	$rosi=0;
							 $rowspan[$ros]=4;
						  while($vc=mysql_fetch_array($rc)) {
						  
						  
						  $rowspan[$ros]=$rowspan[$ros]+1;
						  //echo 'ros'.$ros.'-'.$rowspan[$ros];
						   ?>
								   <tr>
									 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									 <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php echo $vc[Camion]; ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php echo $vc[Capacidad]; ?> m<sup>3</sup></font></td>
									 <?php 
									 #A CONTINUACION, POR CADA DÍA DE LA SEMANA SE HARA UNA CONSULTA PARA OBTENER SUS DATOS
									 $datosdia1="select sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu, count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[0])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia1=$link->consultar($datosdia1);
									 $vdia1=mysql_fetch_array($rdia1);
									 $sumas1[0]=$sumas1[0]+$vdia1[viajexdia];
									 $sumas1[1]=$sumas1[1]+$vdia1[vp];
									 $sumas1[2]=$sumas1[2]+$vdia1[vs];
									 $sumas1[3]=$sumas1[3]+$vdia1[ip];
									 $sumas1[4]=$sumas1[4]+$vdia1[isu];
									 
									
									 ?>
									 
									 
									 
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia1[viajexdia]=='')echo "0"; else echo $vdia1[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia1[vp]=='') echo "0"; else echo number_format($vdia1[vp],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia1[vs]=='') echo "0"; else echo number_format($vdia1[vs],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia1[ip]=='') echo "0"; else echo number_format($vdia1[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia1[isu]=='') echo "0"; else echo number_format($vdia1[isu],2,".",",");  ?></font></td>
									 
									 
									 
									 
							        <?php 
									 $datosdia2="select sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu, count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[1])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia2=$link->consultar($datosdia2);
									 $vdia2=mysql_fetch_array($rdia2);
									 $sumas2[0]=$sumas2[0]+$vdia2[viajexdia];
									 $sumas2[1]=$sumas2[1]+$vdia2[vp];
									 $sumas2[2]=$sumas2[2]+$vdia2[vs];
									 $sumas2[3]=$sumas2[3]+$vdia2[ip];
									 $sumas2[4]=$sumas2[4]+$vdia2[isu];
									 ?>
									 
									 
									 
									  <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia2[viajexdia]=='')echo "0"; else echo $vdia2[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia2[vp]=='') echo "0"; else echo number_format($vdia2[vp],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia2[vs]=='') echo "0"; else echo number_format($vdia2[vs],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia2[ip]=='') echo "0"; else echo number_format($vdia2[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia2[isu]=='') echo "0"; else echo number_format($vdia2[isu],2,".",",");  ?></font></td>
									
									 
									 
									 
									 <?php 
									 $datosdia3="select sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu, count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[2])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia3=$link->consultar($datosdia3);
									 $vdia3=mysql_fetch_array($rdia3);
									 
									 $sumas3[0]=$sumas3[0]+$vdia3[viajexdia];
									 $sumas3[1]=$sumas3[1]+$vdia3[vp];
									 $sumas3[2]=$sumas3[2]+$vdia3[vs];
									 $sumas3[3]=$sumas3[3]+$vdia3[ip];
									 $sumas3[4]=$sumas3[4]+$vdia3[isu];
									 
									 ?>
									 
									 
									 
									  <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia3[viajexdia]=='')echo "0"; else echo $vdia3[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia3[vp]=='') echo "0"; else echo number_format($vdia3[vp],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia3[vs]=='') echo "0"; else echo number_format($vdia3[vs],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia3[ip]=='') echo "0"; else echo number_format($vdia3[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia3[isu]=='') echo "0"; else echo number_format($vdia3[isu],2,".",",");  ?></font></td>
									
									
									
									
								    <?php 
									 $datosdia4="select sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu,  count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[3])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia4=$link->consultar($datosdia4);
									 $vdia4=mysql_fetch_array($rdia4);
									 $sumas4[0]=$sumas4[0]+$vdia4[viajexdia];
									 $sumas4[1]=$sumas4[1]+$vdia4[vp];
									 $sumas4[2]=$sumas4[2]+$vdia4[vs];
									 $sumas4[3]=$sumas4[3]+$vdia4[ip];
									 $sumas4[4]=$sumas4[4]+$vdia4[isu];
									 
									 
									 ?>
									 
									 
									 
									
									  <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia4[viajexdia]=='')echo "0"; else echo $vdia4[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia4[vp]=='') echo "0"; else echo number_format($vdia4[vp],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia4[vs]=='') echo "0"; else echo number_format($vdia4[vs],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia4[ip]=='') echo "0"; else echo number_format($vdia4[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia4[isu]=='') echo "0"; else echo number_format($vdia4[isu],2,".",",");  ?></font></td>
									
									
									
									
									
									 
								     <?php 
									 $datosdia5="select  sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu,  count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[4])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia5=$link->consultar($datosdia5);
									 $vdia5=mysql_fetch_array($rdia5);
									 
									 $sumas5[0]=$sumas5[0]+$vdia5[viajexdia];
									 $sumas5[1]=$sumas5[1]+$vdia5[vp];
									 $sumas5[2]=$sumas5[2]+$vdia5[vs];
									 $sumas5[3]=$sumas5[3]+$vdia5[ip];
									 $sumas5[4]=$sumas5[4]+$vdia5[isu];
									 
									 
									 ?>
									 
									 
									 
									
				<td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia5[viajexdia]=='')echo "0"; else echo $vdia5[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia5[vp]=='') echo "0"; else echo number_format($vdia5[vp],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia5[vs]=='') echo "0"; else echo number_format($vdia5[vs],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia5[ip]=='') echo "0"; else echo number_format($vdia5[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia5[isu]=='') echo "0"; else echo number_format($vdia5[isu],2,".",",");  ?></font></td>
									
									
									
									
									
									  <?php 
									 $datosdia6="select  sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu,  count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[5])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia6=$link->consultar($datosdia6);
									 $vdia6=mysql_fetch_array($rdia6);
									 $sumas6[0]=$sumas6[0]+$vdia6[viajexdia];
									 $sumas6[1]=$sumas6[1]+$vdia6[vp];
									 $sumas6[2]=$sumas6[2]+$vdia6[vs];
									 $sumas6[3]=$sumas6[3]+$vdia6[ip];
									 $sumas6[4]=$sumas6[4]+$vdia6[isu];
									 
									 ?>
									 
									 
									 
									
									  <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia6[viajexdia]=='')echo "0"; else echo $vdia6[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia6[vp]=='') echo "0"; else echo number_format($vdia6[vp],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia6[vs]=='') echo "0"; else echo number_format($vdia6[vs],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia6[ip]=='') echo "0"; else echo number_format($vdia6[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia6[isu]=='') echo "0"; else echo number_format($vdia6[isu],2,".",",");  ?></font></td>
									
									
								     <?php 
									 $datosdia7="select sum(VolumenPrimerKM) as vp, sum(VolumenKMSubsecuentes) as vs, sum(ImportePrimerKM) as ip, sum(ImporteKMSubsecuentes) as isu,  count(v.IdViaje) as viajexdia from camiones as c, viajes as v where v.FechaSalida='".fechasql($rango[6])."' and v.IdCamion=".$vc[IdCamion]." and v.IdProyecto = ".$_SESSION["Proyecto"]." AND v.IdMaterial=".$vm[IdMaterial]." AND v.IdOrigen=".$v[IdOrigen]." and v.IdTiro=".$vt[IdTiro]." and year(v.FechaSalida) = ".$Anio." and weekofyear(v.FechaSalida) = ".$Semana." and c.IdCamion=v.IdCamion Group By v.IdCamion";
									 $rdia7=$link->consultar($datosdia7);
									 $vdia7=mysql_fetch_array($rdia7);
									 $sumas7[0]=$sumas7[0]+$vdia7[viajexdia];
									 $sumas7[1]=$sumas7[1]+$vdia7[vp];
									 $sumas7[2]=$sumas7[2]+$vdia7[vs];
									 $sumas7[3]=$sumas7[3]+$vdia7[ip];
									 $sumas7[4]=$sumas7[4]+$vdia7[isu];
									 
									 
									 ?>
									 
									 
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia7[viajexdia]=='')echo "0"; else echo $vdia7[viajexdia];  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia7[vp]=='') echo "0"; else echo number_format($vdia7[vp],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia7[vs]=='') echo "0"; else echo number_format($vdia7[vs],2,".",",");  ?>
									 </font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia7[ip]=='') echo "0"; else echo number_format($vdia7[ip],2,".",",");  ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-size:8px" color="#000000"><?php if($vdia7[isu]=='') echo "0"; else echo number_format($vdia7[isu],2,".",",");  ?></font></td> 
									
									 <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
									 <?php ?>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#000000"><?php $totales[0]=$totales[0]+$vc[viajes]; echo $vc[viajes]; ?></font></td>
								     <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#000000"><?php $totales[1]=$totales[1]+$vc[TotalVol1]; echo number_format($vc[TotalVol1] ,2,".",","); ?>
								     </font></td>
								     <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#000000"><?php $totales[2]=$totales[2]+$vc[TotalVolS]; echo number_format($vc[TotalVolS],2,".",","); ?>
								     </font></td>
						             <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#000000"><?php $totales[3]=$totales[3]+$vc[TotalImp1]; echo number_format($vc[TotalImp1],2,".",","); ?></font></td>
						             <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#000000"><?php $totales[4]=$totales[4]+$vc[TotalImpS]; echo number_format($vc[TotalImpS],2,".",","); ?></font></td>
							         <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:9px"color="#000000"><?php $nuevo=$vc[TotalImp1]+$vc[TotalImpS]; $totales[5]=$totales[5]+$nuevo;
									 /*$totales[5]=$totales[5]+$vc[TotalImporte];*/ echo number_format($nuevo,2,".",","); ?></font></td>
      </tr>
													  <?php  $rosi++; }#tERMINA filas Inicia Sumas?>
													  
													  								   <tr>
													  								     <td colspan="5" class="Estilo4">- GLN - </td>
													  								     <td colspan="42" align="center" bgcolor="#000000" class="Estilo4">- GLN - </td>
      </tr>
													  								   <tr>
									 <td>&nbsp;</td>
									 <td>&nbsp;</td>
									 <td>&nbsp;</td>
									 <td align="center">&nbsp;</td>
									 <td align="center">&nbsp;</td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST1[0]=$sumasST1[0]+$sumas1[0]; echo number_format($sumas1[0],0,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST1[1]=$sumasST1[1]+$sumas1[1]; echo number_format($sumas1[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST1[2]=$sumasST1[2]+$sumas1[2]; echo number_format($sumas1[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST1[3]=$sumasST1[3]+$sumas1[3]; echo number_format($sumas1[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST1[4]=$sumasST1[4]+$sumas1[4]; echo number_format($sumas1[4],2,".",","); ?></font></td>
									 
									 
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST2[0]=$sumasST2[0]+$sumas2[0]; echo number_format($sumas2[0],0,".",","); ?></font></td>
									 <td align="center" ><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST2[1]=$sumasST2[1]+$sumas2[1]; echo number_format($sumas2[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST2[2]=$sumasST2[2]+$sumas2[2]; echo number_format($sumas2[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST2[3]=$sumasST2[3]+$sumas2[3]; echo number_format($sumas2[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST2[4]=$sumasST2[4]+$sumas2[4]; echo number_format($sumas2[4],2,".",","); ?></font></td>
									 


									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST3[0]=$sumasST3[0]+$sumas3[0]; echo number_format($sumas3[0],0,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST3[1]=$sumasST3[1]+$sumas3[1]; echo number_format($sumas3[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST3[2]=$sumasST3[2]+$sumas3[2]; echo number_format($sumas3[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST3[3]=$sumasST3[3]+$sumas3[3]; echo number_format($sumas3[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST3[4]=$sumasST3[4]+$sumas3[4]; echo number_format($sumas3[4],2,".",","); ?></font></td>



 									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST4[0]=$sumasST4[0]+$sumas4[0]; echo number_format($sumas4[0],0,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST4[1]=$sumasST4[1]+$sumas4[1]; echo number_format($sumas4[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST4[2]=$sumasST4[2]+$sumas4[2]; echo number_format($sumas4[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST4[3]=$sumasST4[3]+$sumas4[3]; echo number_format($sumas4[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST4[4]=$sumasST4[4]+$sumas4[4]; echo number_format($sumas4[4],2,".",","); ?></font></td>

									 
									  <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST5[0]=$sumasST5[0]+$sumas5[0]; echo number_format($sumas5[0],0,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST5[1]=$sumasST5[1]+$sumas5[1];   echo number_format($sumas5[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST5[2]=$sumasST5[2]+$sumas5[2];  echo number_format($sumas5[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST5[3]=$sumasST5[3]+$sumas5[3];  echo number_format($sumas5[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST5[4]=$sumasST5[4]+$sumas5[4];  echo number_format($sumas5[4],2,".",","); ?></font></td>
									 
									
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST6[0]=$sumasST6[0]+$sumas6[0]; echo number_format($sumas6[0],0,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasST6[1]=$sumasST6[1]+$sumas6[1]; echo number_format($sumas6[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasST6[2]=$sumasST6[2]+$sumas6[2]; echo number_format($sumas6[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasST6[3]=$sumasST6[3]+$sumas6[3]; echo number_format($sumas6[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasST6[4]=$sumasST6[4]+$sumas6[4]; echo number_format($sumas6[4],2,".",","); ?></font></td>
									 
									
									
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST7[0]=$sumasST7[0]+$sumas7[0]; echo number_format($sumas7[0],0,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST7[1]=$sumasST7[1]+$sumas7[1];  echo number_format($sumas7[1],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST7[2]=$sumasST7[2]+$sumas7[2]; echo number_format($sumas7[2],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST7[3]=$sumasST7[3]+$sumas7[3]; echo number_format($sumas7[3],2,".",","); ?></font></td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasST7[4]=$sumasST7[4]+$sumas7[4]; echo number_format($sumas7[4],2,".",","); ?></font></td>
									
									
									
									 <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
									 <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $totalesT[0]=$totalesT[0]+$totales[0]; echo number_format($totales[0],0,".",","); ?></font></td>
								     <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $totalesT[1]=$totalesT[1]+$totales[1]; echo number_format($totales[1],2,".",","); ?></font></td>
								     <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $totalesT[2]=$totalesT[2]+$totales[2]; echo number_format($totales[2],2,".",","); ?></font></td>
						             <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $totalesT[3]=$totalesT[3]+$totales[3]; echo number_format($totales[3],2,".",","); ?></font></td>
						             <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $totalesT[4]=$totalesT[4]+$totales[4]; echo number_format($totales[4],2,".",","); ?></font></td>
							         <td align="center"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $totalesT[5]=$totalesT[5]+$totales[5]; echo number_format($totales[5],2,".",","); ?></font></td>
							      </tr>
								  <tr>
							        <td colspan="47">&nbsp;</td>
      </tr>
				  <?php $ros++;}?>		  
				  
				   <?PHP 
				   }
				   ?>
				   												  								   <tr>
									 <td>&nbsp;</td>
									 <td>&nbsp;</td>
									 <td>&nbsp;</td>
									 <td colspan="2" align="center" bgcolor="#969696"><div align="right"><font style="font-family:'Trebuchet MS'; text-align:right; font-weight:bold; font-size:10px"color="#000000">SUBTOTAL ORIGEN: </font></div></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT1[0]=$sumasT1[0]+$sumasST1[0]; echo number_format($sumasST1[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT1[1]=$sumasT1[1]+$sumasST1[1];echo number_format($sumasST1[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT1[2]=$sumasT1[2]+$sumasST1[2];echo number_format($sumasST1[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT1[3]=$sumasT1[3]+$sumasST1[3];echo number_format($sumasST1[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT1[4]=$sumasT1[4]+$sumasST1[4];echo number_format($sumasST1[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT2[0]=$sumasT2[0]+$sumasST2[0]; echo number_format($sumasST2[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0" ><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT2[1]=$sumasT2[1]+$sumasST2[1]; echo number_format($sumasST2[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT2[2]=$sumasT2[2]+$sumasST2[2]; echo number_format($sumasST2[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT2[3]=$sumasT2[3]+$sumasST2[3]; echo number_format($sumasST2[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT2[4]=$sumasT2[4]+$sumasST2[4]; echo number_format($sumasST2[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT3[0]=$sumasT3[0]+$sumasST3[0];  echo number_format($sumasST3[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasT3[1]=$sumasT3[1]+$sumasST3[1];  echo number_format($sumasST3[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasT3[2]=$sumasT3[2]+$sumasST3[2]; echo number_format($sumasST3[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasT3[3]=$sumasT3[3]+$sumasST3[3]; echo number_format($sumasST3[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php  $sumasT3[4]=$sumasT3[4]+$sumasST3[4]; echo number_format($sumasST3[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT4[0]=$sumasT4[0]+$sumasST4[0]; echo number_format($sumasST4[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT4[1]=$sumasT4[1]+$sumasST4[1]; echo number_format($sumasST4[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT4[2]=$sumasT4[2]+$sumasST4[2]; echo number_format($sumasST4[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT4[3]=$sumasT4[3]+$sumasST4[3]; echo number_format($sumasST4[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT4[4]=$sumasT4[4]+$sumasST4[4]; echo number_format($sumasST4[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT5[0]=$sumasT5[0]+$sumasST5[0]; echo number_format($sumasST5[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT5[1]=$sumasT5[1]+$sumasST5[1]; echo number_format($sumasST5[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT5[2]=$sumasT5[2]+$sumasST5[2]; echo number_format($sumasST5[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT5[3]=$sumasT5[3]+$sumasST5[3]; echo number_format($sumasST5[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT5[4]=$sumasT5[4]+$sumasST5[4]; echo number_format($sumasST5[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT6[0]=$sumasT6[0]+$sumasST6[0]; echo number_format($sumasST6[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT6[1]=$sumasT6[1]+$sumasST6[1]; echo number_format($sumasST6[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT6[2]=$sumasT6[2]+$sumasST6[2]; echo number_format($sumasST6[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT6[3]=$sumasT6[3]+$sumasST6[3]; echo number_format($sumasST6[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#C0C0C0"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT6[4]=$sumasT6[4]+$sumasST6[4]; echo number_format($sumasST6[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT7[0]=$sumasT7[0]+$sumasST7[0]; echo number_format($sumasST7[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT7[1]=$sumasT7[1]+$sumasST7[1]; echo number_format($sumasST7[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT7[2]=$sumasT7[2]+$sumasST7[2]; echo number_format($sumasST7[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT7[3]=$sumasT7[3]+$sumasST7[3]; echo number_format($sumasST7[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#969696"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#000000"><?php $sumasT7[4]=$sumasT7[4]+$sumasST7[4]; echo number_format($sumasST7[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
									 <td align="center" bgcolor="#333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php $totalT[0]=$totalT[0]+$totalesT[0]; echo number_format($totalesT[0],0,".",","); ?></font></td>
								     <td align="center" bgcolor="#333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php $totalT[1]=$totalT[1]+$totalesT[1]; echo number_format($totalesT[1],2,".",","); ?></font></td>
								     <td align="center" bgcolor="#333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php $totalT[2]=$totalT[2]+$totalesT[2]; echo number_format($totalesT[2],2,".",","); ?></font></td>
						             <td align="center" bgcolor="#333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php $totalT[3]=$totalT[3]+$totalesT[3]; echo number_format($totalesT[3],2,".",","); ?></font></td>
						             <td align="center" bgcolor="#333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php $totalT[4]=$totalT[4]+$totalesT[4]; echo number_format($totalesT[4],2,".",","); ?></font></td>
							         <td align="center" bgcolor="#333333"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php $totalT[5]=$totalT[5]+$totalesT[5]; echo number_format($totalesT[5],2,".",","); ?></font></td>
							      </tr>
								                                                                   <tr>
								                                                                     <td colspan="47">&nbsp;</td>
      </tr>
								                                                                   <tr>
								                                                                     <td colspan="47">&nbsp;</td>
      </tr>
								                                                                   
                                  <tr>
							        <td colspan="47">&nbsp;</td>
      </tr>
		<?php 
		}
		?>
						   												  								   <tr>
									 <td>&nbsp;</td>
									 <td>&nbsp;</td>
									 <td>&nbsp;</td>
									 <td colspan="2" align="center" bgcolor="#000000"><div align="right"><font style="font-family:'Trebuchet MS'; text-align:right; font-weight:bold; font-size:10px"color="#ffffff">TOTAL:</font></div></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT1[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT1[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT1[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT1[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT1[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT2[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000" ><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT2[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT2[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT2[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT2[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT3[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT3[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT3[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT3[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT3[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT4[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT4[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT4[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT4[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT4[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT5[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT5[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT5[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT5[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT5[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT6[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT6[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT6[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT6[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumas6[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT7[0],0,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT7[1],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT7[2],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT7[3],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($sumasT7[4],2,".",","); ?></font></td>
									 <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
									 <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($totalT[0],0,".",","); ?></font></td>
								     <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($totalT[1],2,".",","); ?></font></td>
								     <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($totalT[2],2,".",","); ?></font></td>
						             <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($totalT[3],2,".",","); ?></font></td>
						             <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($totalT[4],2,".",","); ?></font></td>
							         <td align="center" bgcolor="#000000"><font style="font-family:'Trebuchet MS'; font-weight:bold; font-size:10px"color="#ffffff"><?php echo number_format($totalT[5],2,".",","); ?></font></td>
							      </tr>
								  <tr>
							        <td colspan="47">&nbsp;</td>
      </tr>
</table>
</body>
</html>
