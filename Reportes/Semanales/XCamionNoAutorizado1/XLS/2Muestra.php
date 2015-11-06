<?php
	session_start();
	if(isset($_REQUEST["v"]) && ($_REQUEST["v"]==1)){
	header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition:  filename=Viajes Manuales Pendientes de Autorizar '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {font-size: 1px; color: #FFFFFF}
.Estilo4 {font-size: 1px; color: #cccccc; }
.celda_head{
	background-color:#7ac142; color:#FFF; font-weight:bold;
	}
.celda{
	background-color:#555; color:#fff; font-weight:bold; padding:5px; text-align:center;
	}
.gray{
	background-color:#eee;
	}
.par{
	background-color:#eee;
	}

-->
</style>
</head>


<body>
<?php 
$IdProyecto=$_SESSION['Proyecto'];
$inicial=$_REQUEST["inicial"];
$final=$_REQUEST["final"];
$camion=$_REQUEST["camion"];
$tipo_consulta=$_REQUEST["tipo_consulta"];
//$sindicato=$_REQUEST["sindicato"];
//echo $tipo_consulta.'-'.$sindicato;
$sindicatos='';
for($i=0;$i<sizeof($sindicato);$i++)
{
	$sindicatos=$sindicatos.$sindicato[$i].',';
}
$sindicatos=substr($sindicatos,0,strlen($sindicatos)-1);
/*if($tipo_consulta=="sindicato")
{
	$estatus=$_REQUEST["estatus"];
	if($estatus!=3)
	{
		
		if($estatus==1)
		{
			$texto="TODOS LOS CAMIONES ACTIVOS";
		}
		else
		if($estatus==0)
		{
			$texto="TODOS LOS CAMIONES INACTIVOS";
		}
		
		$consulta="c.IdSindicato in (".$sindicatos.") and c.Estatus=".$estatus." and";
	}
	else
	{
		$texto="TODOS LOS CAMIONES";
		$consulta="c.IdSindicato in (".$sindicatos.") and ";
	}
}*/

if($tipo_consulta=="camion")
{
	if($camion=="T")
	{
		$estatus=$_REQUEST["estatus"];
		if($estatus!=3)
		{
			
			if($estatus==1)
			{
				$texto="TODOS LOS CAMIONES ACTIVOS";
			}
			else
			if($estatus==0)
			{
				$texto="TODOS LOS CAMIONES INACTIVOS";
			}
			
			$consulta="c.Estatus=".$estatus." and";
		}
		else
		{
			$texto="TODOS LOS CAMIONES";
			$consulta="";
		}
	}
	else
		$consulta="c.IdCamion=".$camion." and";
}
//echo $consulta;

	include("../../../../inc/php/conexiones/SCA.php");
	include("../../../../Clases/Funciones/Catalogos/Genericas.php");
if($tipo_consulta=='camion')
{
if($camion=="T") {

/*$sql="SELECT DISTINCT p.Descripcion as Obra, Propietario from  viajes v, proyectos p, camiones as c, sindicatos s WHERE ".$consulta." v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  c.idSindicato=s.IdSindicato";*/
$sql = "select * from viajesnetos where estatus=29 and fechallegada between '".fechasql($inicial)."' and '".fechasql($final)."';";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
	$query = "select IdCamion,count(IdViajeNeto) as NumViajes,(count(IdViajeNeto)*CubicacionParaPago) as volumen,IdOrigen,IdTiro,IdMaterial,CubicacionParaPago
from viajesnetos v
left join camiones c using(IdCamion)
where fechallegada between '".fechasql($inicial)."' and '".fechasql($final)."'
and v.estatus=29
group by v.IdCamion,IdOrigen,IdTiro,IdMaterial";
$result = $link->consultar($query);
$top_viajes=0;
$top_volumen=0;
while($record = mysql_fetch_array($result)){
	
	$top_viajes=$top_viajes+$record["NumViajes"];
	$top_volumen=$top_volumen+$record["volumen"];
	
	
		$Top_CantPrimerKm = $link->regresaDatos("rutas","PrimerKm","where IdTiro=".$record["IdTiro"]." and IdOrigen=".$record["IdOrigen"]." and Estatus=1");
		$Top_CantKmSubs = $link->regresaDatos("rutas","KmSubsecuentes","where IdTiro=".$record["IdTiro"]." and IdOrigen=".$record["IdOrigen"]." and Estatus=1");
		$Top_CantKmAdic = $link->regresaDatos("rutas","KmAdicionales","where IdTiro=".$record["IdTiro"]." and IdOrigen=".$record["IdOrigen"]." and Estatus=1");
		
		$Top_TarPrimerKm = $link->regresaDatos("tarifas","PrimerKM","where IdMaterial=".$record["IdMaterial"]." and Estatus=1");
		$Top_TarKmSubs = $link->regresaDatos("tarifas","KMSubsecuente","where IdMaterial=".$record["IdMaterial"]." and Estatus=1");
		$Top_TarKmAdic = $link->regresaDatos("tarifas","KmAdicional","where IdMaterial=".$record["IdMaterial"]." and Estatus=1");
		
		$Top_ImpPrimerKM = $record["CubicacionParaPago"]*$Top_TarPrimerKm*$Top_CantPrimerKm*$record["NumViajes"];
		$Top_ImpKmSubs = $record["CubicacionParaPago"]*$Top_TarKmSubs*$Top_CantKmSubs*$record["NumViajes"];
		$Top_ImpKmAdic = $record["CubicacionParaPago"]*$Top_TarKmAdic*$Top_CantKmAdic*$record["NumViajes"];
		
		$Top_Importe= $Top_ImpPrimerKM+$Top_ImpKmSubs+$Top_ImpKmAdic;
		$Top_SubtotalImporte=$Top_SubtotalImporte+$Top_Importe;
		
		
	}
?>
<table>
		<tr>
        	<td colspan="2" style="height:80px;"><img src="http://gln.com.mx:82/test/Imgs/sca_login.jpg" width="106" height="67"></td>
            <td colspan="3">&nbsp;</td>
            <td valign="top" colspan="4"><strong>VIAJES MANUALES PENDIENTES DE AUTORIZAR</strong></td>
        </tr>
        <tr>
        	<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Fecha Consulta:</td>
            <td colspan="2" class="gray"><?php echo date("d-m-Y");?></td>
        </tr>
        <tr>
        	<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Camion</td>
            <td colspan="2" class="gray"><?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
		<tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Proyecto:</td>
            <td class="gray" colspan="6"><?php echo $link->regresaDatos2("proyectos","descripcion","IdProyecto",$IdProyecto); ?></td>
        </tr>
        <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Periodo:</td>
            <td class="gray" colspan="6"><?php echo $inicial.' al '.$final?></td>
        </tr>
         <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Viajes Totales:</td>
            <td class="gray" colspan="6"><?php echo number_format($top_viajes);?></td>
        </tr>
        <tr>
            <td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Volumen Total</td>
            <td colspan="6" class="gray"><?php echo number_format($top_volumen,2); ?></td>
        </tr>
        <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Importe Total:</td>
            <td colspan="6" class="gray"><?php echo number_format($Top_SubtotalImporte,2); ?></td>
        </tr>
</table>
<table border="0" align="center" >
 
  <!--<tr>
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS POR </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $texto; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  <td colspan="2"><div><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $link->regresaDatos2("proyectos","descripcion","IdProyecto",$IdProyecto); ?></font></td>
  </tr>
 
  <tr>
    <td colspan="2" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">CAMI&Oacute;N:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?>
    </font></td>
  </tr>-->
    <?php if($camion!="T"){?>
	<tr>
    <td colspan="2" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PLACAS:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Placas]; ?></font></td>
    </tr>

  
  <?php }?>
      <tr>
      <td colspan="2" ><table border="0" align="center" style="border-collapse:collapse;">
        <tr>
          <td colspan="5">&nbsp;</td>
          <td width="32">&nbsp;</td>
          <td width="60">&nbsp;</td>
          <td width="54">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="44">&nbsp;</td>
          <td width="52" colspan="2">&nbsp;</td>
          <td width="41">&nbsp;</td>
          <td width="54">&nbsp;</td>
        </tr>
        <tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DISTANCIA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VOLUMEN (m<sup>3 </sup>)</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE ($)</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">OBSERVACIONES</font></div></td>
       </tr>
        <?php
/*$llena="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p WHERE ".$consulta." c.IdCamion=v.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." order by Economico;";*/
$llena="select distinct IdCamion from viajesnetos where estatus=29 and fechallegada between '".fechasql($inicial)."' and '".fechasql($final)."'";
//echo $llena;
  $r=$link->consultar($llena);
 $TotalImporte=0;
 $TotalVolumen=0;
 $TotalViajes=0;
  while($d=mysql_fetch_array($r))
   {
   
   
   
      		 $rows="
	SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha,  
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco,
		 o.IdOrigen,
		 t.IdTiro, 
		 t.Descripcion as Tiro, 
		 m.IdMaterial,
		 m.Descripcion as Material, 
		 1 as NumViajes, 
		 c.CubicacionParaPago,
		 (1*(c.CubicacionParaPago)) as Volumen,
		 v.observaciones
	FROM  
	viajesnetos v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."
 v.Estatus=29 and
 c.IdCamion=".$d["IdCamion"]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial
 Order by Fecha";
//echo $rows;
$ro=$link->consultar($rows);
$x=1;
$SubtotalImporte=0;
	while($fil=mysql_fetch_array($ro))
	{
		$CantPrimerKm = $link->regresaDatos("rutas","PrimerKm","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"]." and Estatus=1");
		$CantKmSubs = $link->regresaDatos("rutas","KmSubsecuentes","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"]." and Estatus=1");
		$CantKmAdic = $link->regresaDatos("rutas","KmAdicionales","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"]." and Estatus=1");
		
		$TarPrimerKm = $link->regresaDatos("tarifas","PrimerKM","where IdMaterial=".$fil["IdMaterial"]." and Estatus=1");
		$TarKmSubs = $link->regresaDatos("tarifas","KMSubsecuente","where IdMaterial=".$fil["IdMaterial"]." and Estatus=1");
		$TarKmAdic = $link->regresaDatos("tarifas","KmAdicional","where IdMaterial=".$fil["IdMaterial"]." and Estatus=1");
		
		$ImpPrimerKM = $fil["CubicacionParaPago"]*$TarPrimerKm*$CantPrimerKm*$fil["NumViajes"];
		$ImpKmSubs = $fil["CubicacionParaPago"]*$TarKmSubs*$CantKmSubs*$fil["NumViajes"];
		$ImpKmAdic = $fil["CubicacionParaPago"]*$TarKmAdic*$CantKmAdic*$fil["NumViajes"];
		
		$Importe= $ImpPrimerKM+$ImpKmSubs+$ImpKmAdic;
		$SubtotalImporte=$SubtotalImporte+$Importe;
?>
        <tr>
          <td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">
            <?php if($x==1)echo $fil["Economico"]; ?>
          </font></div></td>
          <td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil["Fecha"]); ?></font></div></td>
          <td><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["CubicacionParaPago"]; ?> m<sup>3 </sup></font></div></td>
          <td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["NumViajes"]; ?></font></div></td>
          <td colspan="2"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Material"]; ?></font></div></td>
          <td colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Banco"]; ?></font></div></td>
          <td colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Tiro"]; ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $link->regresaDatos("rutas","TotalKM","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"].""); ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil["Volumen"],2); ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($Importe,2); ?></font></div></td>
			<td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["observaciones"]; ?></font></div></td>
       </tr>
        <?php
   $x++;
   }
   $TotalImporte=$TotalImporte+$SubtotalImporte;
   $suma="
	SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha,  
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViajeNeto) as NumViajes, 
		 c.CubicacionParaPago,
		 (count(v.IdViajeNeto)*(c.CubicacionParaPago)) as Volumen
	FROM  
	viajesnetos v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."
 v.Estatus=29 and
 c.IdCamion=".$d["IdCamion"]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial 
 group by v.IdCamion
 Order by Fecha";
 //echo $suma;
 $rsuma=$link->consultar($suma);
$fsuma=mysql_fetch_array($rsuma); 
   ?>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td><font color="#000" face="Trebuchet MS" style="font-size:10px;">NOTAS:</font></td>
        <td colspan="14" style="border:solid 1px #000000;"><div>&nbsp;</div></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
   <tr>
    <td>&nbsp;</td>
   	<td colspan="3" style="background-color:#555555;"><div align="center"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">Subotal</font></div></td>
    <td align="right" style="background-color:#555555;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo $fsuma["NumViajes"]?></font></div></td>
    <td colspan="7" style="background-color:#555555;"><div align="center"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"></font></div></td>
    <td align="right" style="background-color:#555555;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fsuma["Volumen"],2);?></font></div></td>
    <td align="right" style="background-color:#555555;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($SubtotalImporte,2);?></font></div></td>
     <td align="right"  colspan="2" style="background-color:#555555;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">&nbsp;</font></div>  
   </tr>
   <?php
   $TotalVolumen=$TotalVolumen+$fsuma["Volumen"];
   $TotalViajes=$TotalViajes+$fsuma["NumViajes"];
    }?>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td colspan="1">&nbsp;</td>
         <td align="right" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">Total</font></div></td>
         <td align="right"  colspan="2" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">&nbsp;</font></div></td>
         <td align="right" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo $TotalViajes;?></font></div></td>
         <td align="right"  colspan="7" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">&nbsp;</font></div></td>
       	 <td align="right" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($TotalVolumen,2);?></font></div></td>
         <td align="right" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($TotalImporte,2);?></font></div></td>
         <td align="right"  colspan="2" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;">&nbsp;</font></div>
    </tr>    
      </table></td>
    </tr>
</table>
  
<?php } else {?>
<table width="600" align="center" >
  <tr>
    <td class="Titulo">NO EXISTEN ACARREOS EJECUTADOS POR </td>
  </tr>
   <tr>
     <td class="Titulo"><span class="Estilo1"><?PHP echo $texto; ?></span></td>
   </tr>
   <tr>
     <td class="Titulo"> EN EL PERIODO</td>
   </tr>
   <tr>
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></font></td>
   </tr>

  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>

  <?php }?> 
  <?php } ##caso uno
  else { 
 
/*$sql="SELECT DISTINCT p.Descripcion as Obra, Propietario,Placas,Economico from  viajes v, proyectos p, 
camiones as c, sindicatos s WHERE ".$consulta." v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  c.idSindicato=s.IdSindicato and v.idCamion=c.idCamion";*/
$sql = "select * from viajesnetos where IdCamion=".$camion." and estatus=29 and fechallegada between '".fechasql($inicial)."' and '".fechasql($final)."';";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
$query = "select IdCamion,count(IdViajeNeto) as NumViajes,(count(IdViajeNeto)*CubicacionParaPago) as volumen,IdOrigen,IdTiro,IdMaterial,CubicacionParaPago
from viajesnetos v
left join camiones c using(IdCamion)
where fechallegada between '".fechasql($inicial)."' and '".fechasql($final)."'
and v.estatus=29
and IdCamion=".$camion."
group by v.IdCamion,IdOrigen,IdTiro,IdMaterial";
$result = $link->consultar($query);
$top_viajes=0;
$top_volumen=0;
while($record = mysql_fetch_array($result)){
	
	$top_viajes=$top_viajes+$record["NumViajes"];
	$top_volumen=$top_volumen+$record["volumen"];
	
	
		$Top_CantPrimerKm = $link->regresaDatos("rutas","PrimerKm","where IdTiro=".$record["IdTiro"]." and IdOrigen=".$record["IdOrigen"]." and Estatus=1");
		$Top_CantKmSubs = $link->regresaDatos("rutas","KmSubsecuentes","where IdTiro=".$record["IdTiro"]." and IdOrigen=".$record["IdOrigen"]." and Estatus=1");
		$Top_CantKmAdic = $link->regresaDatos("rutas","KmAdicionales","where IdTiro=".$record["IdTiro"]." and IdOrigen=".$record["IdOrigen"]." and Estatus=1");
		
		$Top_TarPrimerKm = $link->regresaDatos("tarifas","PrimerKM","where IdMaterial=".$record["IdMaterial"]." and Estatus=1");
		$Top_TarKmSubs = $link->regresaDatos("tarifas","KMSubsecuente","where IdMaterial=".$record["IdMaterial"]." and Estatus=1");
		$Top_TarKmAdic = $link->regresaDatos("tarifas","KmAdicional","where IdMaterial=".$record["IdMaterial"]." and Estatus=1");
		
		$Top_ImpPrimerKM = $record["CubicacionParaPago"]*$Top_TarPrimerKm*$Top_CantPrimerKm*$record["NumViajes"];
		$Top_ImpKmSubs = $record["CubicacionParaPago"]*$Top_TarKmSubs*$Top_CantKmSubs*$record["NumViajes"];
		$Top_ImpKmAdic = $record["CubicacionParaPago"]*$Top_TarKmAdic*$Top_CantKmAdic*$record["NumViajes"];
		
		$Top_Importe= $Top_ImpPrimerKM+$Top_ImpKmSubs+$Top_ImpKmAdic;
		$Top_SubtotalImporte=$Top_SubtotalImporte+$Top_Importe;
		
		
	}
?>
<table>
		<tr>
        	<td colspan="2" style="height:80px;"><img src="http://gln.com.mx:82/test/Imgs/sca_login.jpg" width="106" height="67"></td>
            <td colspan="3">&nbsp;</td>
            <td valign="top" colspan="4"><strong>VIAJES MANUALES PENDIENTES DE AUTORIZAR</strong></td>
        </tr>
		<tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Proyecto:</td>
            <td class="gray" colspan="6"><?php echo $link->regresaDatos2("proyectos","descripcion","IdProyecto",$IdProyecto); ?></td>
            <td colspan="4"></td>
            <td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Fecha Consulta:</td>
            <td colspan="2" class="gray"><?php echo date("d-m-Y");?></td>
        </tr>
        <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Periodo:</td>
            <td class="gray" colspan="6"><?php echo $inicial.' al '.$final?></td>
            <td colspan="4"></td>
            <td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Camion</td>
            <td colspan="2" class="gray">Economico <?php echo $link->regresaDatos2("camiones","Economico","IdCamion",$camion); ?></td>
        </tr>
        <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Propietario:</td>
            <td class="gray" colspan="6"><?php echo $link->regresaDatos2("camiones","Propietario","IdCamion",$camion); ?></td>
            <td colspan="4"></td>
            <td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Placas</td>
            <td colspan="2" class="gray"><?php echo $link->regresaDatos2("camiones","Placas","IdCamion",$camion); ?></td>
        </tr>
         <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Viajes Totales:</td>
            <td class="gray" colspan="6"><?php echo number_format($top_viajes);?></td>
        </tr>
        <tr>
            <td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Volumen Total</td>
            <td colspan="6" class="gray"><?php echo number_format($top_volumen,2); ?></td>
        </tr>
        <tr>
			<td class="celda_head" align="right"; style="color:#FFF; padding:5px;" colspan="2">Importe Total:</td>
            <td colspan="6" class="gray"><?php echo number_format($Top_SubtotalImporte,2); ?></td>
        </tr>
</table>
<table border="0" align="center" >
  <!--<tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS POR EL CAMI&Oacute;N </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">
      <?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?>
    </font> <font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $link->regresaDatos2("proyectos","descripcion","IdProyecto",$IdProyecto); ?></font></td>
  </tr>
  <tr>
    <td colspan="4"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROPIETARIO:</font> &nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $link->regresaDatos2("camiones","Propietario","IdCamion",$camion); ?></font></td>
  </tr>
  <tr>
    <td colspan="4" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">CAMI&Oacute;N:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php if($camion!="T"){ echo $link->regresaDatos2("camiones","Economico","IdCamion",$camion);} else {echo $texto;}?>
    </font></td>
  </tr>
    <?php if($camion!="T"){?>

    
  <tr>
    <td colspan="4" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PLACAS:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $link->regresaDatos2("camiones","Placas","IdCamion",$camion); ?></font></td>
  </tr>-->
  <?php }?>
  <tr>
      <td colspan="4" ><table border="0" align="center" style="border-collapse:collapse;">
        <tr>
          <td colspan="5">&nbsp;</td>
          <td width="58">&nbsp;</td>
          <td width="97">&nbsp;</td>
          <td width="107">&nbsp;</td>
          <td width="90">&nbsp;</td>
          <td width="79">&nbsp;</td>
          <td width="93">&nbsp;</td>
          <td width="74">&nbsp;</td>
        </tr>
        <tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DISTANCIA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VOLUMEN (m<sup>3 </sup>)</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE ($)</font></div></td>
          <td bgcolor="969696" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">OBSERVACIONES</font></div></td>
          </tr>
        <?php
  $llena="
  	SELECT 
		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha,  
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario,
		 o.IdOrigen as IdOrigen,
		 t.IdTiro as IdTiro,
		 m.IdMaterial as IdMaterial, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 1 as NumViajes, 
		 c.CubicacionParaPago,
		 (1*(c.CubicacionParaPago)) as Volumen,
		 v.observaciones
	FROM  
	viajesnetos v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
 v.Estatus=29 and 
 c.IdCamion=".$camion." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial 
 Order by Fecha
  ";
//echo $llena;
  $r=$link->consultar($llena);
  $SubtotalImporte=0;
	while($fil=mysql_fetch_array($r))
		{
		$CantPrimerKm = $link->regresaDatos("rutas","PrimerKm","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"]." and Estatus=1");
		$CantKmSubs = $link->regresaDatos("rutas","KmSubsecuentes","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"]." and Estatus=1");
		$CantKmAdic = $link->regresaDatos("rutas","KmAdicionales","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"]." and Estatus=1");
		
		$TarPrimerKm = $link->regresaDatos("tarifas","PrimerKM","where IdMaterial=".$fil["IdMaterial"]." and Estatus=1");
		$TarKmSubs = $link->regresaDatos("tarifas","KMSubsecuente","where IdMaterial=".$fil["IdMaterial"]." and Estatus=1");
		$TarKmAdic = $link->regresaDatos("tarifas","KmAdicional","where IdMaterial=".$fil["IdMaterial"]." and Estatus=1");
		
		$ImpPrimerKM = $fil["CubicacionParaPago"]*$TarPrimerKm*$CantPrimerKm*$fil["NumViajes"];
		$ImpKmSubs = $fil["CubicacionParaPago"]*$TarKmSubs*$CantKmSubs*$fil["NumViajes"];
		$ImpKmAdic = $fil["CubicacionParaPago"]*$TarKmAdic*$CantKmAdic*$fil["NumViajes"];
		
		$Importe= $ImpPrimerKM+$ImpKmSubs+$ImpKmAdic;
		$SubtotalImporte=$SubtotalImporte+$Importe;
		
?>
        <tr>
          <td width="98"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Economico"]; ?></font></div></td>
          <td width="116"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil["Fecha"]); ?></font></div></td>
          <td width="88"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td width="77"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["CubicacionParaPago"]; ?> m<sup>3 </sup></font></div></td>
          <td width="77"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["NumViajes"]; ?></font></div></td>
          <td width="97" colspan="2"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Material"]; ?></font></div></td>
          <td width="107" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Banco"]; ?></font></div></td>
          <td width="90" colspan="2"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Tiro"]; ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $link->regresaDatos("rutas","TotalKM","where IdTiro=".$fil["IdTiro"]." and IdOrigen=".$fil["IdOrigen"].""); ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil["Volumen"],2); ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($Importe,2); ?></font></div></td>
          <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["observaciones"]; ?></font></div></td>
        </tr>
        <?php

    }?>
        <?php
  
 $sum="SELECT 
		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha,  
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViajeNeto) as NumViajes, 
		 c.CubicacionParaPago,
		 (count(v.IdViajeNeto)*(c.CubicacionParaPago)) as Volumen
	FROM  
	viajesnetos v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
 v.Estatus=29 and 
 c.IdCamion=".$camion." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial 
 group by v.IdCamion
 Order by Fecha";
$suma=$link->consultar($sum);
$sumv=mysql_fetch_array($suma);
?>
		<tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td><font color="#000" face="Trebuchet MS" style="font-size:10px;">NOTAS:</font></td>
        <td colspan="14" style="border:solid 1px #000000;"><div>&nbsp;</div></td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
        <tr>
          <td><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td bgcolor="222222"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">Total</font></td>
          <td bgcolor="222222" colspan="2"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">&nbsp;</font></td>
          <td bgcolor="222222" align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["NumViajes"]?></font></td>
          <td colspan="7" bgcolor="222222"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">&nbsp;</font></td>
          <td bgcolor="222222" align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($sumv["Volumen"],2);?></font></td>
          <td align="right" style="background-color:#222222;"><div><font color="#ffffff" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($SubtotalImporte,2); ?></font></div></td>
           <td colspan="2" style="background-color:#222222;"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">&nbsp;</font></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
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
        </tr>
      </table></td>
  </tr>
</table>
  
<?php } else {?>
<table width="600" align="center" >
  <tr>
    <td class="Titulo">NO EXISTEN ACARREOS EJECUTADOS POR EL CAMI&Oacute;N </td>
  </tr>
   <tr>
     <td class="Titulo"> <span class="Estilo1">
       <?php echo regresa(camiones, Economico, IdCamion, $camion); ?></span>
     </td>
   </tr>
   <tr>
     <td class="Titulo">EN EL PERIODO </td>
   </tr>
   <tr>
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></font></td>
   </tr>

  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>
  
  
 
<?php } }

} #end tipoconsulta
?>
</body>
</html>
