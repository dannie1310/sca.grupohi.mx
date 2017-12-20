<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

	header("Content-type: application/vnd.ms-excel");
    header('Content-Disposition:  filename=Acareos Ejecutados por Cami�n '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
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
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS POR </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $texto; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
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

  
  <?php }?>
      <tr>
      <td colspan="2" ><table width="1500" border="0" align="center" >
        <tr>
          <td colspan="5">&nbsp;</td>
          <td width="32">&nbsp;</td>
          <td width="60">&nbsp;</td>
          <td width="54">&nbsp;</td>
          <td width="50">&nbsp;</td>
          <td width="44">&nbsp;</td>
          <td width="52" colspan="2">&nbsp;</td>
          <td width="41">&nbsp;</td>
          <td width="46" colspan="2">&nbsp;</td>
          <td width="47">&nbsp;</td>
          <td width="61" colspan="2">&nbsp;</td>
          <td width="54">&nbsp;</td>
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
  $llena="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p WHERE ".$consulta." c.IdCamion=v.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." order by Economico;";
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
		 ta.PrimerKM as 'PU1Km', 
		 ta.KMSubsecuente as 'PUSub', 
		 ta.KMAdicional as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m, tarifas ta
WHERE
".$consulta."
ta.Estatus = 1 and
 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.IdMaterial=ta.IdMaterial
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
    $sum="SELECT SUM(VolAdic) as sumaadicionales, SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(ImpAdc) as sumaadc, SUM(Importe) as sumatotal 
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
		 ta.PrimerKM as 'PU1Km', 
		 ta.KMSubsecuente as 'PUSub', 
		 ta.KMAdicional as 'PU Km Adic'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m, tarifas ta
WHERE
".$consulta."
ta.Estatus = 1 and
 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.IdMaterial=ta.IdMaterial
 group by Material,Banco,Tiro) 
  AS Registros";
//echo $sum;
$suma=$link->consultar($sum);
$sumv=mysql_fetch_array($suma);
$sumtot=$sumtot+$sumv["sumaviajes"];
$volp=$volp+$sumv["sumavolumen"];
$volsub=$volsub+$sumv["sumasubsecuentes"];
$voladc=$voladc+$sumv["sumaadicionales"];
$impp=$impp+$sumv["sumaimporte"];
$impsub=$impsub+$sumv["sumasub"];
$impadc=$impadc+$sumv["sumaadc"];

$imp=$imp+($sumv["sumaimporte"]+$sumv["sumasub"]+$sumv["sumaadc"]); 
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL CAMI&Oacute;N:</font></div></td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaviajes]; ?></font></div></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumavolumen]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasubsecuentes]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $sumv[sumaadicionales]; ?></font></div></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaimporte]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasub]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaadc]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv[sumaimporte]+$sumv[sumasub]+$sumv[sumaadc],2,".",","); ?>
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
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumtot; ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volp,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volsub,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($voladc,2,".",","); ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td colspan="2" bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impp,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impsub,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impadc,2,".",","); ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($imp,2,".",","); ?></font></div></td>
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
    <td colspan="4"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS POR EL CAMI&Oacute;N </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">
      <?php if($camion!="T"){ echo $v[Economico];} else {echo $texto;}?>
    </font> <font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO 834:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Obra]; ?></font></td>
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
  <tr>
      <td colspan="4" ><table width="1500" border="0" align="center" >
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
		 ta.PrimerKM as 'PU1Km', 
		 ta.KMSubsecuente as 'PUSub', 
		 ta.KMAdicional as 'PU Km Adic'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m, tarifas ta
WHERE
 c.IdCamion=".$camion." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.IdMaterial=ta.IdMaterial
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
  
 $sum="SELECT SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(Importe) as sumatotal 
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
		 ta.PrimerKM as 'PU1Km', 
		 ta.KMSubsecuente as 'PUSub', 
		 ta.KMAdicional as 'PU Km Adic'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m, tarifas ta
WHERE
 c.IdCamion=".$camion." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.IdMaterial=ta.IdMaterial
 group by v.IdCamion,Material,Banco,Tiro) 
  AS Registros";
$suma=$link->consultar($sum);
$sumv=mysql_fetch_array($suma);
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TOTAL:</font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaviajes]; ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumavolumen]; ?></font></div></td>
          <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasubsecuentes]; ?></font></div></td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000">&nbsp;</td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaimporte]; ?></font></div></td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasub]; ?></font></div></td>
          <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv[sumaimporte]+$sumv[sumasub],2,".",","); ?>
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
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS POR </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $texto; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> EN EL PER&Iacute;ODO DEL</font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO 834:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v[Obra]; ?></font></td>
  </tr>
 <?php 
 for($jj=0;$jj<sizeof($sindicato);$jj++)
 {
	 $suma_sindicato='';
 ?>
      <tr>
      <td colspan="2" >
      
      
      
      <table width="1500" border="0" align="center" >
        <tr>
          <td colspan="11"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">SINDICATO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php regresa(sindicatos, NombreCorto, IdSindicato, $sindicato[$jj]);  ?></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
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
  $llena="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p WHERE ".$consulta." c.IdCamion=v.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and c.IdSindicato=".$sindicato[$jj]." order by Economico;";
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
		 ta.PrimerKM as 'PU1Km', 
		 ta.KMSubsecuente as 'PUSub', 
		 ta.KMAdicional as 'PU Km Adic'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m, tarifas ta
WHERE
".$consulta."
 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.IdMaterial=ta.IdMaterial
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
    $sum="SELECT SUM(NumViajes) as sumaviajes, SUM(Vol1KM) as sumavolumen,SUM(VolSub) as sumasubsecuentes, SUM(Imp1Km) as sumaimporte, SUM(ImpSub) as sumasub, SUM(Importe) as sumatotal 
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
		 ta.PrimerKM as 'PU1Km', 
		 ta.KMSubsecuente as 'PUSub', 
		 ta.KMAdicional as 'PU Km Adic'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m, tarifas ta
WHERE
".$consulta."
 c.IdCamion=".$d[IdCamion]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial and 
 v.IdMaterial=ta.IdMaterial
 group by Material,Banco,Tiro) 
  AS Registros";
//echo $sum;
$suma=$link->consultar($sum);
$sumv=mysql_fetch_array($suma);
$sumtot=$sumtot+$sumv["sumaviajes"];
$volp=$volp+$sumv["sumavolumen"];
$volsub=$volsub+$sumv["sumasubsecuentes"];
$impp=$impp+$sumv["sumaimporte"];
$impsub=$impsub+$sumv["sumasub"];

$imp=$imp+($sumv["sumaimporte"]+$sumv["sumasub"]); 
?>
        <tr>
          <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL CAMI&Oacute;N:</font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaviajes]; $suma_sindicato["viajes"]=$suma_sindicato["viajes"]+$sumv[sumaviajes];?></font></div></td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumavolumen]; $suma_sindicato["volumen"]=$suma_sindicato["volumen"]+$sumv[sumavolumen];?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasubsecuentes]; $suma_sindicato["volumen_sub"]=$suma_sindicato["volumen_sub"]+$sumv[sumasubsecuentes];?></font></div></td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaimporte]; $suma_sindicato["importe"]=$suma_sindicato["importe"]+$sumv[sumaimporte]; ?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasub]; $suma_sindicato["importe_sub"]=$suma_sindicato["importe_sub"]+$sumv[sumasub]; ?></font></div></td>
          <td bgcolor="#CCCCCC"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv[sumaimporte]+$sumv[sumasub],2,".",","); $suma_sindicato["importe_tot"]=$suma_sindicato["importe_tot"]+$sumv[sumaimporte]+$sumv[sumasub]; ?>
          </font></div></td>
        </tr>
        
        <?php

    }?>
    <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">SUBTOTAL SINDICATO:</font></div></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $suma_sindicato["viajes"]; ?></font></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696" align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato["volumen"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato["volumen_sub"],2,".",""); ?></font></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato["importe"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato["importe_sub"],2,".",""); ?></font></td>
          <td align="right" bgcolor="#969696"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($suma_sindicato["importe_tot"],2,".",""); ?></font></td>
        </tr>
       
        
      </table>
      </td>
    </tr>
    <?php }?>
    <TR><TD colspan="2"><table width="100%">
     <tr>
          <td width="4%">&nbsp;</td>
          <td width="4%">&nbsp;</td>
          <td width="10%">&nbsp;</td>
          <td width="12%" align="right" bgcolor="#000000"><div align="right"><font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold">TOTAL:</font></div></td>
          <td width="6%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumtot; ?></font></div></td>
          <td width="3%" bgcolor="#000000">&nbsp;</td>
          <td width="4%" bgcolor="#000000">&nbsp;</td>
          <td width="4%" bgcolor="#000000">&nbsp;</td>
          <td width="4%" bgcolor="#000000">&nbsp;</td>
          <td width="8%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volp,2,".",","); ?></font></div></td>
          <td width="11%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volsub,2,".",","); ?></font></div></td>
          <td width="5%" bgcolor="#000000">&nbsp;</td>
          <td width="5%" bgcolor="#000000">&nbsp;</td>
          <td width="6%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impp,2,".",","); ?></font></div></td>
          <td width="7%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impsub,2,".",","); ?></font></div></td>
          <td width="7%" bgcolor="#000000"><div align="right"> <font color="#ffffff" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($imp,2,".",","); ?></font></div></td>
        </tr>
    </table></TD></TR>
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
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?></span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></font></td>
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
