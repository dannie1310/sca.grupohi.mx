<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");
$SCA=SCA::getConexion();

$IdProyecto=$_SESSION['Proyecto'];
$inicial = $_REQUEST['inicial'];
$final = $_REQUEST['final'];
$sindicato = $_REQUEST['sindicatos'];

$sql="SELECT DISTINCT s.Descripcion as Sindicato, p.Descripcion as Obra from  viajes v, proyectos p, camiones as c, sindicatos s WHERE  v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  s.idSindicato='".$sindicato."'";
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
    <td colspan="2"  align="center"><div align="left"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">ACARREOS EJECUTADOS EN EL PER&Iacute;ODO DEL <font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> <?PHP echo $inicial; ?></font><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px;"><?php echo $v["Obra"]; ?></font></td>
  </tr>
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
		
		
		
		
		
		
		
		
		
		$llena="SELECT DISTINCT v.IdCamion, c.Economico  from viajes as v, camiones as c, proyectos as p, sindicatos as s WHERE c.IdCamion=v.IdCamion and c.IdSindicato = s.IdSindicato and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and s.IdSindicato='".$sindicato."' order by Economico;";
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

 s.IdSindicato='".$sindicato."' and 	
 c.IdCamion=".$d["IdCamion"]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial 
 group by Fecha, Cubicacion,Material,Banco,Tiro,TipoTarifa,IdTarifa
 Order by Fecha";
//echo $rows;
$ro=$link->consultar($rows);
$x=1;
	while($fil=mysql_fetch_array($ro))
	{
?>
        <!--<tr>
          <td width="48"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;">
            <?php if($x==1)echo $fil["Economico"]; ?>
          </font></div></td>
          <td width="69"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo fecha($fil["Fecha"]); ?></font></div></td>
          <td width="39"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo "1"; ?></font></div></td>
          <td width="39"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Cubicacion"]; ?> m<sup>3 </sup></font></div></td>
          <td width="43"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["NumViajes"]; ?></font></div></td>
          <td width="32"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Distancia"]; ?></font></div></td>
          <td width="60"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Material"]; ?></font></div></td>
          <td width="54"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Banco"]; ?></font></div></td>
          <td width="50"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Tiro"]; ?></font></div></td>
          <td width="44"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Vol1KM"]; ?></font></div></td>
          <td width="24"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["VolSub"]; ?></font></div></td>
          <td width="26"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["VolAdic"]; ?></font></div></td>
          <td width="41"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["PU1Km"]; ?></font></div></td>
          <td width="21"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["PUSub"]; ?></font></div></td>
          <td width="23"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["PUAdc"]; ?></font></div></td>
          <td width="47"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["Imp1Km"]; ?></font></div></td>
          <td width="29"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["ImpSub"]; ?></font></div></td>
          <td width="30"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil["ImpAdc"]; ?></font></div></td>
          <td width="54"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo  number_format($fil["Imp1Km"]+$fil["ImpSub"]+$fil["ImpAdc"],2,".",",");?></font></div></td>
        </tr>-->
        <?php
   
   
   $detalle = "select * from viajes where IdCamion=".$d["IdCamion"]." and FechaLlegada='".$fil["Fecha"]."' and IdProyecto=".$IdProyecto." ";
		//echo $detalle;
		$rdetalle=$link->consultar($detalle);
		$y=1;
  		while($ddetalle=mysql_fetch_array($rdetalle))
   		{
			?>
            <tr>
            	<td><?php if($y==1)echo $fil["Economico"]; ?></td>
                <td><?php echo $fil["Fecha"];?></td>
                <td>1</td>
                <td><?php echo $fil["Cubicacion"]; ?></td>
                <td><?php echo $ddetalle["IdViaje"]?></td>
            </tr>
            <?php
			$y++;
			}
   
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
		 sum(v.ImportePrimerKM)/sum(v.VolumenPrimerKM) as 'PU1Km', 
		 if(sum(v.VolumenKMSubsecuentes)>0,sum(v.ImporteKMSubsecuentes)/sum(v.VolumenKMSubsecuentes),0) as 'PUSub', 
		 if(sum(v.VolumenKMAdicionales)>0,sum(v.ImporteKMAdicionales)/sum(v.VolumenKMAdicionales),0) as 'PUAdc'
	FROM  
	viajes v, proyectos p, sindicatos s, camiones c, origenes o, tiros t, materiales m
WHERE

 s.IdSindicato='".$sindicato."' and
 c.IdCamion=".$d["IdCamion"]." and 
 v.FechaLlegada between '".fechasql($inicial)."' and 
 '".fechasql($final)."' and 
 p.IdProyecto=".$IdProyecto." and 
 v.IdProyecto = p.IdProyecto and 
 v.idCamion=c.idCamion and c.idSindicato=s.IdSindicato and 
 v.IdOrigen=o.IdOrigen and v.IdTiro=t.IdTiro and v.IdMaterial=m.IdMaterial 
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
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["sumaviajes"]; ?></font></div></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["sumavolumen"]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["sumasubsecuentes"]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $sumv["sumaadicionales"]; ?></font></div></td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696">&nbsp;</td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["sumaimporte"]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["sumasub"]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv["sumaadc"]; ?></font></div></td>
          <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  echo number_format($sumv["sumaimporte"]+$sumv["sumasub"]+$sumv["sumaadc"],2,".",","); ?>
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
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></td>
   </tr>

  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>
<?php }?>


