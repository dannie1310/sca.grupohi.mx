<?php
	session_start();
	header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition:  filename=Viajes Sin Origen Por Camion '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
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
$sindicato=$_REQUEST["sindicato"];
//echo $tipo_consulta.'-'.$sindicato;
$sindicatos='';
for($i=0;$i<sizeof($sindicato);$i++)
{
	$sindicatos=$sindicatos.$sindicato[$i].',';
}
$sindicatos=substr($sindicatos,0,strlen($sindicatos)-1);
if($tipo_consulta=="sindicato")
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
}

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

$sql="SELECT DISTINCT p.Descripcion as Obra, Propietario from  viajes v, proyectos p, camiones as c, sindicatos s WHERE ".$consulta." v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  c.idSindicato=s.IdSindicato";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
?>
<table width="1500" border="0" align="center" >
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">VIAJES SIN ORIGEN POR </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $texto; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Obra]; ?></font></td>
  </tr>
 
  <tr>
    <td colspan="2" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">CAMI&Oacute;N:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?>
    </font></td>
  </tr>
    <?php if($camion!="T"){?>
	<tr>
    <td colspan="2" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PLACAS:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Placas]; ?></font></td>
    </tr>
    <tr>
    <td colspan="2" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">&nbsp;</td>
  </tr>


  
  <?php }?>
    <tr>
    <!-- Tabla de Viajes Con Origen Todos los Camiones-->
      	<td colspan="2" >
      	
      	</td>
    </tr>
    <tr>
    <!-- Tabla de Viajes Sin Origen Todos los Camiones-->
    	<td colspan="2">
        <table width="1500" border="0" align="center" >
        <tr>
          <td colspan="19" style="color:#FFF; background-color:#000; font-weight:600;">VIAJES SIN ORIGEN</td>
          <!--<td width="32">&nbsp;</td>
          <td width="60">&nbsp;</td>
          <td width="54">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="44">&nbsp;</td>
          <td width="52" colspan="2">&nbsp;</td>
          <td width="41">&nbsp;</td>
          <td width="46" colspan="2">&nbsp;</td>
          <td width="47">&nbsp;</td>
          <td width="61" colspan="2">&nbsp;</td>
          <td width="54">&nbsp;</td>-->
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="3" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VOLUMEN&nbsp;(m<sup>3</sup>)</font></div></td>
          <td colspan="3" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">P.U. ($)</font></div></td>
          <td colspan="3" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE ($)</font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">DIST.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM ADC.</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS. </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM ADC. </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font> </div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM ADC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> ($)</font></div></td>
        </tr>
        <?php
  $llena="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p WHERE ".$consulta." c.IdCamion=v.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.Estatus in (11,10) order by Economico;";
//echo $llena;
  $r=$link->consultar($llena);
  while($d=mysql_fetch_array($r))
   {
   
   
   
      		 $rows="
	SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.ImporteKMAdicionales) as ImpAdc,
			sum(v.Importe) as Importe,
			
			v.TPrimerKM as 'PU1Km', 
      v.TKMSubsecuente as 'PUSub', 
      v.TKMAdicional as 'PUAdc'
		 
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."

 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.Estatus in (11,10) 
 group by Fecha, Cubicacion,Material,Banco,Tiro,TipoTarifa,IdTarifa
 Order by Fecha";
//echo $rows;
$ro=$link->consultar($rows);
$x=1;
	while($fil=mysql_fetch_array($ro))
	{
?>
        <tr>
          <td width="48"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">
            <?php if($x==1)echo $fil[Economico]; ?>
          </font></div></td>
          <td width="69"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil[Fecha]); ?></font></div></td>
          <td width="39"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td width="39"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Cubicacion]; ?> m<sup>3 </sup></font></div></td>
          <td width="43"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[NumViajes]; ?></font></div></td>
          <td width="32"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Distancia]; ?></font></div></td>
          <td width="60"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Material]; ?></font></div></td>
          <td width="54"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Banco]; ?></font></div></td>
          <td width="50"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Tiro]; ?></font></div></td>
          <td width="44"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Vol1KM]; ?></font></div></td>
          <td width="24"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[VolSub]; ?></font></div></td>
          <td width="26"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[VolAdic]; ?></font></div></td>
          <td width="41"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PU1Km]; ?></font></div></td>
          <td width="21"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PUSub]; ?></font></div></td>
          <td width="23"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PUAdc]; ?></font></div></td>
          <td width="47"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Imp1Km]; ?></font></div></td>
          <td width="29"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[ImpSub]; ?></font></div></td>
          <td width="30"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[ImpAdc]; ?></font></div></td>
          <td width="54"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo  number_format($fil[Imp1Km]+$fil[ImpSub]+$fil[ImpAdc],2,".",",");?></font></div></td>
        </tr>
        <?php
   $x++;
   }
    $sum2="SELECT SUM(VolAdic) as sumaadicionales, SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(ImpAdc) as sumaadc, SUM(Importe) as sumatotal 
FROM (SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.ImporteKMAdicionales) as ImpAdc,
			sum(v.Importe) as Importe,
		 sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."

 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.Estatus in (11,10) 
 group by Material,Banco,Tiro) 
  AS Registros";
//echo $sum;
$suma2=$link->consultar($sum2);
$sumv2=mysql_fetch_array($suma2);
$sumtot2=$sumtot2+$sumv2["sumaviajes"];
$volp2=$volp2+$sumv2["sumavolumen"];
$volsub2=$volsub2+$sumv2["sumasubsecuentes"];
$voladc2=$voladc2+$sumv2["sumaadicionales"];
$impp2=$impp2+$sumv2["sumaimporte"];
$impsub2=$impsub2+$sumv2["sumasub"];
$impadc2=$impadc2+$sumv2["sumaadc"];

$imp2=$imp2+($sumv2["sumaimporte"]+$sumv2["sumasub"]+$sumv2["sumaadc"]); 
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL CAMI&Oacute;N:</font></div></td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaviajes]; ?></font></div></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumavolumen]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumasubsecuentes]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $sumv[sumaadicionales]; ?></font></div></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaimporte]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumasub]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaadc]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv2[sumaimporte]+$sumv2[sumasub]+$sumv2[sumaadc],2,".",","); ?>
          </font></div></td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <?php

    }?>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#000000"><div align="center"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TOTAL:</font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumtot2; ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volp2,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volsub2,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($voladc2,2,".",","); ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td colspan="2" bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impp2,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impsub2,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impadc2,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($imp2,2,".",","); ?></font></div></td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
      </table>
        </td>
    </tr>
    <tr>
    <!-- Tabla de Viajes Manuales Todos los Camiones-->
    	<td colspan="2">
        
        </td>
    </tr>
    <tr>
    	<td colspan="2">
    <!-- Totales -->
        
        </td>
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
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></td>
   </tr>

  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>

  <?php }?> 
  <?php } ##caso uno
  else { 
 
$sql="SELECT DISTINCT p.Descripcion as Obra, Propietario,Placas,Economico from  viajes v, proyectos p, 
camiones as c, sindicatos s WHERE ".$consulta." v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  c.idSindicato=s.IdSindicato and v.idCamion=c.idCamion";

//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
?>
<table width="1500" border="0" align="center" >
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">VIAJES SIN ORIGEN POR EL CAMI&Oacute;N </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">
      <?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?>
    </font> <font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Obra]; ?></font></td>
  </tr>
  <tr>
    <td colspan="4"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROPIETARIO:</font> &nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Propietario]; ?></font></td>
  </tr>
  <tr>
    <td colspan="4" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">CAMI&Oacute;N:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?>
    </font></td>
  </tr>
    <?php if($camion!="T"){?>

    
  <tr>
    <td colspan="4" ><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PLACAS:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Placas]; ?></font></td>
  </tr>
  <?php }?>
  <!-- Tabla de Viajes con Origen por Camion-->
  <tr>
    <td colspan="4" >
    
    </td>
  </tr>
  <!-- Tabla de Viajes Sin Origen por Camion-->
  <tr>
  	<td colspan="4">
    <table width="1500" border="0" align="center" >
        <tr>
          <td colspan="5">&nbsp;</td>
          <td width="58">&nbsp;</td>
          <td width="97">&nbsp;</td>
          <td width="107">&nbsp;</td>
          <td width="90">&nbsp;</td>
          <td width="79">&nbsp;</td>
          <td width="93">&nbsp;</td>
          <td width="74">&nbsp;</td>
          <td width="83">&nbsp;</td>
          <td width="74">&nbsp;</td>
          <td width="97">&nbsp;</td>
          <td width="126">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="16" style="color:#FFF; background-color:#000; font-weight:600;">VIAJES SIN ORIGEN</td>
        </tr>
        <tr>
        	<td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VOLUMEN&nbsp;(m<sup>3</sup>)</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "></font></div></td>
          <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">P.U.&nbsp;($)</font></div></td>
          <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">IMPORTE&nbsp;($)</font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">DIST.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">ORIGEN</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">DESTINO</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">1ER. KM</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">KM SUBS.</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">1ER. KM </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">KM SUBS. </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">1ER. KM </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">KM SUBS.</font> </div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">IMPORTE</font></div></td>
        </tr>
        <?php
  $llena="
  	SELECT 
		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
		 sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
 c.IdCamion=".$camion." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and
 v.Estatus in (10,11)
 group by Fecha,Cubicacion,v.IdCamion,Material,Banco,Tiro
 Order by Fecha
  ";
//echo $llena;
  $r=$link->consultar($llena);
  
   
   
   
   
   		
	while($fil=mysql_fetch_array($r))
	{
?>
        <tr>
          <td width="98"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Economico]; ?></font></div></td>
          <td width="116"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil[Fecha]); ?></font></div></td>
          <td width="88"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td width="77"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Cubicacion]; ?> m<sup>3 </sup></font></div></td>
          <td width="77"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[NumViajes]; ?></font></div></td>
          <td width="58"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Distancia]; ?></font></div></td>
          <td width="97"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Material]; ?></font></div></td>
          <td width="107"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Banco]; ?></font></div></td>
          <td width="90"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Tiro]; ?></font></div></td>
          <td width="79"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Vol1KM]; ?></font></div></td>
          <td width="93"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[VolSub]; ?></font></div></td>
          <td width="74"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PU1Km]; ?></font></div></td>
          <td width="83"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PUSub]; ?></font></div></td>
          <td width="74"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Imp1Km]; ?></font></div></td>
          <td width="97"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[ImpSub]; ?></font></div></td>
          <td width="126"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo  number_format($fil[Imp1Km]+$fil[ImpSub],2,".",",");?></font></div></td>
        </tr>
        <?php

    }?>
        <?php
  
 $sum2="SELECT SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(Importe) as sumatotal 
FROM (SELECT 
		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 c.CubicacionParaPago as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
		 sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
 c.IdCamion=".$camion." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and
 v.Estatus in (10,11)
 group by v.IdCamion,Material,Banco,Tiro) 
  AS Registros";
$suma2=$link->consultar($sum2);
$sumv2=mysql_fetch_array($suma2);
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TOTAL:</font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaviajes]; ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumavolumen]; ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumasubsecuentes]; ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaimporte]; ?></font></div></td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumasub]; ?></font></div></td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv2[sumaimporte]+$sumv2[sumasub],2,".",","); ?>
          </font></div></td>
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
      </table>
    </td>
  </tr>
  <!-- Tabla de Viajes Manuales por Camion-->
  <tr>
  	<td colspan="4">
    
    </td>
  </tr>
  <!-- Totales -->
  <tr>
  	<td colspan="4">
    
    </td>
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
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></td>
   </tr>

  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>
  
  
 
<?php } }

} #end tipoconsulta
else
if($tipo_consulta=='sindicato')
{
	
	$sql="SELECT DISTINCT p.Descripcion as Obra, Propietario from  viajes v, proyectos p, camiones as c, sindicatos s WHERE ".$consulta." v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  c.idSindicato=s.IdSindicato";
//echo $sql;
	$link=SCA::getConexion();
	
	$row=$link->consultar($sql);
	$v=mysql_fetch_array($row);
	$hay=$link->affected();
	if($hay>0)
	{?>


<table width="1500" border="0" align="center" >
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">VIAJES SIN ORIGEN POR </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $texto; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Obra]; ?></font></td>
  </tr>
 <?php 
 for($jj=0;$jj<sizeof($sindicato);$jj++)
 {
	 $suma_sindicato='';
 ?>
 	<!--Tabla de Viajes Con Origen Por Sindicato-->
	<tr>
      <td colspan="2" >
      	
      </td>
    </tr>
    <!--Tabla de Viajes Sin Origen Por Sindicato-->
    <tr>
    	<td colspan="2">
        <table width="1500" border="0" align="center" >
        <tr>
          <td colspan="11"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">SINDICATO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php regresa(sindicatos, NombreCorto, IdSindicato, $sindicato[$jj]);  ?></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td colspan="16" style="color:#FFF; background-color:#000; font-weight:600;">VIAJES SIN ORIGEN</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td width="32">&nbsp;</td>
          <td width="60">&nbsp;</td>
          <td width="54">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="44">&nbsp;</td>
          <td width="52">&nbsp;</td>
          <td width="41">&nbsp;</td>
          <td width="46">&nbsp;</td>
          <td width="47">&nbsp;</td>
          <td width="61">&nbsp;</td>
          <td width="54">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5">&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VOLUMEN&nbsp;(m<sup>3</sup>)</font></div></td>
          <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">P.U. ($)</font></div></td>
          <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE ($)</font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr bgcolor="#0A8FC7">
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CAMI&Oacute;N</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">FECHA</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TURNO</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">CUBIC.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VIAJES</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">DIST.</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">MATERIAL</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS. </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM </font></div></td>
          <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font> </div></td>
          <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> ($)</font></div></td>
        </tr>
        <?php
		$link=SCA::getConexion();
  $llena="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p WHERE ".$consulta." c.IdCamion=v.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and c.IdSindicato=".$sindicato[$jj]." and v.Estatus in (10,11) order by Economico;";
//echo $llena;
  $r=$link->consultar($llena);
  while($d=mysql_fetch_array($r))
   {
   
   
   
   
   		 $rows="
	SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
		 sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."
 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.Estatus in (10,11) 
 group by Fecha, Cubicacion,Material,Banco,Tiro
 Order by Fecha";
//echo $rows;
$ro=$link->consultar($rows);
$x=1;
	while($fil=mysql_fetch_array($ro))
	{
?>
        <tr>
          <td width="48"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">
            <?php if($x==1)echo $fil[Economico]; ?>
          </font></div></td>
          <td width="69"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil[Fecha]); ?></font></div></td>
          <td width="39"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td width="39"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Cubicacion]; ?> m<sup>3 </sup></font></div></td>
          <td width="43"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[NumViajes]; ?></font></div></td>
          <td width="32"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Distancia]; ?></font></div></td>
          <td width="60"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Material]; ?></font></div></td>
          <td width="54"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Banco]; ?></font></div></td>
          <td width="50"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Tiro]; ?></font></div></td>
          <td width="44"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Vol1KM]; ?></font></div></td>
          <td width="52"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[VolSub]; ?></font></div></td>
          <td width="41"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PU1Km]; ?></font></div></td>
          <td width="46"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PUSub]; ?></font></div></td>
          <td width="47"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Imp1Km]; ?></font></div></td>
          <td width="61"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[ImpSub]; ?></font></div></td>
          <td width="54"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo  number_format($fil[Imp1Km]+$fil[ImpSub],2,".",",");?></font></div></td>
        </tr>
        <?php
   $x++;
   }
    $sum2="SELECT SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(Importe) as sumatotal 
FROM (SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
		sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."
 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and
 v.Estatus in (10,11)
 group by Material,Banco,Tiro) 
  AS Registros";
//echo $sum;
$suma2=$link->consultar($sum2);
$sumv2=mysql_fetch_array($suma2);
$sumtot2=$sumtot2+$sumv2["sumaviajes"];
$volp2=$volp2+$sumv2["sumavolumen"];
$volsub2=$volsub2+$sumv2["sumasubsecuentes"];
$impp2=$impp2+$sumv2["sumaimporte"];
$impsub2=$impsub2+$sumv2["sumasub"];

$imp2=$imp2+($sumv2["sumaimporte"]+$sumv2["sumasub"]); 
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL CAMI&Oacute;N:</font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaviajes]; $suma_sindicato2["viajes"]=$suma_sindicato2["viajes"]+$sumv2[sumaviajes];?></font></div></td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumavolumen]; $suma_sindicato2["volumen"]=$suma_sindicato2["volumen"]+$sumv2[sumavolumen];?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumasubsecuentes]; $suma_sindicato2["volumen_sub"]=$suma_sindicato2["volumen_sub"]+$sumv2[sumasubsecuentes];?></font></div></td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumaimporte]; $suma_sindicato2["importe"]=$suma_sindicato2["importe"]+$sumv2[sumaimporte]; ?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv2[sumasub]; $suma_sindicato2["importe_sub"]=$suma_sindicato2["importe_sub"]+$sumv2[sumasub]; ?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv2[sumaimporte]+$sumv2[sumasub],2,".",","); $suma_sindicato2["importe_tot"]=$suma_sindicato2["importe_tot"]+$sumv2[sumaimporte]+$sumv2[sumasub]; ?>
          </font></div></td>
        </tr>
        
        <?php

    }?>
    <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL SINDICATO:</font></div></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $suma_sindicato2["viajes"]; ?></font></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato2["volumen"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato2["volumen_sub"],2,".",""); ?></font></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato2["importe"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato2["importe_sub"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato2["importe_tot"],2,".",""); ?></font></td>
        </tr>
       
        
      </table>
        </td>
    </tr>
    <!--Tabla de Viajes Manuales Por Sindicato-->
    <tr>
    	<td>
        
        </td>
    </tr>
    <tr>
    	<td>
        <!--<table width="1500" border="0" align="center" >
        <tr><td>&nbsp;</td></tr>
        
        
        
        <?php
		$link=SCA::getConexion();
  $llena_3="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p WHERE ".$consulta." c.IdCamion=v.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and c.IdSindicato=".$sindicato[$jj]." and v.Estatus in (10,11) order by Economico;";
//echo $llena_3;
  $r_3=$link->consultar($llena_3);
  while($d_3=mysql_fetch_array($r_3))
   {
   
   
   
   
   		 $rows_3="
	SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
		 sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."
 c.IdCamion=".$d_3[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.Estatus in (10,11)
 group by Fecha, Cubicacion,Material,Banco,Tiro
 Order by Fecha";
//echo $rows_3;
$ro_3=$link->consultar($rows_3);
$x=1;
	while($fil_3=mysql_fetch_array($ro_3))
	{
?>
        <tr>
          <td width="48"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">
            <?php if($x==1)echo $fil[Economico]; ?>
          </font></div></td>
          <td width="69"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil_3[Fecha]); ?></font></div></td>
          <td width="39"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td width="39"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Cubicacion]; ?> m<sup>3 </sup></font></div></td>
          <td width="43"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[NumViajes]; ?></font></div></td>
          <td width="32"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Distancia]; ?></font></div></td>
          <td width="60"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Material]; ?></font></div></td>
          <td width="54"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Banco]; ?></font></div></td>
          <td width="50"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Tiro]; ?></font></div></td>
          <td width="44"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Vol1KM]; ?></font></div></td>
          <td width="52"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[VolSub]; ?></font></div></td>
          <td width="41"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[PU1Km]; ?></font></div></td>
          <td width="46"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[PUSub]; ?></font></div></td>
          <td width="47"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[Imp1Km]; ?></font></div></td>
          <td width="61"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil_3[ImpSub]; ?></font></div></td>
          <td width="54"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo  number_format($fil_3[Imp1Km]+$fil_3[ImpSub],2,".",",");?></font></div></td>
        </tr>
        <?php
   $x++;
   }
    $sum3="SELECT SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(Importe) as sumatotal 
FROM (SELECT 

		 c.Economico as Economico, 
		 v.FechaLlegada as Fecha, 
		 v.CubicacionCamion as Cubicacion, 
		 p.NombreCorto as Obra, 
		 s.NombreCorto as Propietario, 
		 o.Descripcion as Banco, 
		 t.Descripcion as Tiro, 
		 m.Descripcion as Material, 
		 count(v.IdViaje) as NumViajes, 
		 c.CubicacionParaPago,
		 	v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
		sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE
".$consulta."
 c.IdCamion=".$d_3[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and
 v.Estatus in (10,11)
 group by Material,Banco,Tiro) 
  AS Registros";
//echo $sum3;
$suma3=$link->consultar($sum3);
$sumv3=mysql_fetch_array($suma3);
$sumtot3=$sumtot3+$sumv3["sumaviajes"];
$volp3=$volp3+$sumv3["sumavolumen"];
$volsub3=$volsub3+$sumv3["sumasubsecuentes"];
$impp3=$impp3+$sumv3["sumaimporte"];
$impsub3=$impsub3+$sumv3["sumasub"];

$imp3=$imp3+($sumv3["sumaimporte"]+$sumv3["sumasub"]); 
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL CAMI&Oacute;N:</font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv3[sumaviajes]; $suma_sindicato3["viajes"]=$suma_sindicato3["viajes"]+$sumv3[sumaviajes];?></font></div></td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv3[sumavolumen]; $suma_sindicato3["volumen"]=$suma_sindicato3["volumen"]+$sumv3[sumavolumen];?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv3[sumasubsecuentes]; $suma_sindicato3["volumen_sub"]=$suma_sindicato3["volumen_sub"]+$sumv3[sumasubsecuentes];?></font></div></td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv3[sumaimporte]; $suma_sindicato3["importe"]=$suma_sindicato3["importe"]+$sumv3[sumaimporte]; ?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv3[sumasub]; $suma_sindicato3["importe_sub"]=$suma_sindicato3["importe_sub"]+$sumv3[sumasub]; ?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv3[sumaimporte]+$sumv3[sumasub],2,".",","); $suma_sindicato3["importe_tot"]=$suma_sindicato3["importe_tot"]+$sumv3[sumaimporte]+$sumv3[sumasub]; ?>
          </font></div></td>
        </tr>
        
        <?php

    }?>
    <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL SINDICATO:</font></div></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $suma_sindicato3["viajes"]; ?></font></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato3["volumen"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato3["volumen_sub"],2,".",""); ?></font></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato3["importe"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato3["importe_sub"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato3["importe_tot"],2,".",""); ?></font></td>
        </tr>
       
        
      </table>--></td>
    </tr>
    <?php }?>
    <TR><TD colspan="2"><table width="100%">
     <tr>
          <td width="4%">&nbsp;</td>
          <td width="4%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="12%" align="right" bgcolor="#000000"><div align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TOTAL SINDICATO:</font></div></td>
          <td width="6%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumtot3; ?></font></div></td>
          <td width="3%" bgcolor="#000000">&nbsp;</td>
          <td width="4%" bgcolor="#000000">&nbsp;</td>
          <td width="4%" bgcolor="#000000">&nbsp;</td>
          <td width="4%" bgcolor="#000000">&nbsp;</td>
          <td width="8%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volp3,2,".",","); ?></font></div></td>
          <td width="11%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volsub3,2,".",","); ?></font></div></td>
          <td width="5%" bgcolor="#000000">&nbsp;</td>
          <td width="5%" bgcolor="#000000">&nbsp;</td>
          <td width="6%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impp3,2,".",","); ?></font></div></td>
          <td width="7%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impsub3,2,".",","); ?></font></div></td>
          <td width="7%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($imp3,2,".",","); ?></font></div></td>
        </tr>
    </table></TD></TR>
    <tr>
    	<td colspan="2">
        
        </td>
    </tr>
</table>

   
	<?PHP }
	else
	{?>
<table width="600" align="center" >
  <tr>
    <td class="Titulo">NO EXISTEN ACARREOS EJECUTADOS</td>
  </tr>
  <tr>
    <td class="Titulo">EN EL PERIODO </td>
  </tr>
  <tr>
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?></span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></td>
  </tr>
  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>
		
	<?php }


}

?>
</body>
</html>
