<?php
	session_start();
	if(isset($_REQUEST["v"]) && ($_REQUEST["v"]==1)){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Acarreos Ejecutados por Destino '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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
?>
<!--<table width="845" border="0" align="center" >
  <tr>
    <td width="124">&nbsp;</td>
    <td width="407">&nbsp;</td>
    <td width="28"><span class="Estilo2"><img src="../../../../Imgs/calendarp.gif" width="19" height="21"></span></td>
   <form name="frm" action="1Fechas.php" method="post">
   <input name="seg" type="hidden" value="1">
   <input name="inicial" type="hidden" value="<?php //echo $inicial; ?>">
   <input name="final" type="hidden" value="<?php //echo $final; ?>">
   <td width="125" style="cursor:hand " onClick="document.frm.submit()">Cambiar Rango de Fechas</td>
   </form> 
  </tr>
</table>
-->
<?php 

	include("../../../../inc/php/conexiones/SCA.php");
	include("../../../../Clases/Funciones/Catalogos/Genericas.php");
$sql="
    SELECT 
      DISTINCT p.Descripcion as Obra, 
      Propietario 
    FROM  viajes v, 
          proyectos p, 
          camiones as c
    WHERE v.IdCamion=c.IdCamion 
      and v.FechaLlegada between '".fechasql($inicial)."' AND '".fechasql($final)."' 
      AND p.IdProyecto=".$IdProyecto." 
      AND v.IdProyecto = p.IdProyecto;";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
?>
<table width="1500" border="0" align="left" >
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
    <td colspan="4"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">REPORTE DE ACARREOS EJECUTADOS POR DESTINO EN EL PER&Iacute;ODO DEL <?PHP echo $inicial; ?> AL <?PHP echo $final; ?></font></td>
  </tr>
  <tr>
    <td colspan="4"  align="center"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $v[Obra]; ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td width="715" colspan="3">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4"><table width="1500" border="0" align="center" >
      <tr>
        <td width="186">&nbsp;</td>
        <td width="141">&nbsp;</td>
        <td width="94">&nbsp;</td>
        <td width="81">&nbsp;</td>
        <td width="125">&nbsp;</td>
        <td width="114">&nbsp;</td>
        <td width="120">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="123">&nbsp;</td>
        <td width="97">&nbsp;</td>
        <td width="139">&nbsp;</td>
        <td width="128">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;font-weight:bold">VOLUMEN</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> (</font><font color="#000000" face="Trebuchet MS" style="font-size:10px;"> m<sup>3</sup></font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">)</font></div></td>
        <td colspan="2" bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">P.U.</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> (</font><font color="#000000" face="Trebuchet MS" style="font-size:10px;">$</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">)</font></div></td>
        <td colspan="2" bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> (</font><font color="#000000" face="Trebuchet MS" style="font-size:10px;">$</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">)</font></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#0A8FC7">
        <td bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
        <td bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
        <td bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">MATERIAL</font></div></td>
        <td bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VIAJES</font></div></td>
        <td bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DISTANCIA</font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM</font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM </font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS. </font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM </font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font> </div></td>
        <td bgcolor="#969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold "> (</font><font color="#000000" face="Trebuchet MS" style="font-size:10px;">$</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">)</font></div></td>
      </tr>
      <?php
  $llena="SELECT DISTINCT IdTiro  from viajes as v, proyectos as p WHERE v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto.";";
  $r=$link->consultar($llena);
  //echo $llena;
  while($d=mysql_fetch_array($r))
   {  
   
   ##########
		$mat="SELECT DISTINCT v.IdMaterial 
		from viajes as v,  proyectos as p
		WHERE v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdTiro=".$d[IdTiro]." and p.IdProyecto=".$IdProyecto.";";
		//echo $mat;
		$ma=$link->consultar($mat);
		while($dmat=mysql_fetch_array($ma))
   		{
   
   
   #########
   
		$rows="
		Select 
		    count(v.IdViaje) as Viajes,
			t.Descripcion as Tiro, 
			o.Descripcion as Banco,
			m.Descripcion as Material,
			v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
			
			fn_devuelve_tarifa(TipoTarifa,IdTarifa,'p_km') as 'PU1Km', 
		fn_devuelve_tarifa(TipoTarifa,IdTarifa,'s_km') as 'PUSub', 
		fn_devuelve_tarifa(TipoTarifa,IdTarifa,'a_km') as 'PUAdic'
			
		from 
			viajes as v, 
			tiros as t, 
			origenes as o,
			materiales as m
		where 
			t.IdTiro=v.IdTiro and
			o.IdOrigen=v.IdOrigen and
			v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and 
			v.IdProyecto=".$IdProyecto." and 
			v.IdTiro=".$d[IdTiro]." and
			m.IdMaterial=v.IdMaterial and
			m.IdMaterial=".$dmat[IdMaterial]."
			Group By Banco,TipoTarifa,IdTarifa";//echo $rows;
		$ro=$link->consultar($rows);
		$x=1;
		
		while($fil=mysql_fetch_array($ro))
			{
			?>
      <tr>
        <td width="186"><div align="left"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;">
          <?php if($x==1)echo $fil[Tiro]; ?>
        </font></div></td>
        <td width="141"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Banco]; ?></font></td>
        <td width="94"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Material]; ?></font></div></td>
        <td width="81"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Viajes]; ?></font></div></td>
        <td width="125"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Distancia]; ?></font></div></td>
        <td width="114"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Vol1KM]; ?></font></div></td>
        <td width="120"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[VolSub]; ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PU1Km]; ?></font></div></td>
        <td width="123"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PUSub]; ?></font></div></td>
        <td width="97"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[Imp1Km],2,".",","); ?></font></div></td>
        <td width="139"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[ImpSub],2,".",","); ?></font></div></td>
        <td width="128"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[Imp1Km]+$fil[ImpSub],2,".",","); ?></font></div></td>
      </tr>
      <?php
			   $x++;
			  }
	$sum="SELECT 
			SUM(Viajes) as sumaviajes, 
			SUM(Vol1KM) as sumavolumen,
			SUM(VolSub) as sumasubsecuentes, 
			SUM(Imp1Km) as sumaimporte, 
			SUM(ImpSub) as sumasub, 
			SUM(Importe) as sumatotal 
		FROM(Select 
		    count(v.IdViaje) as Viajes,
			t.Descripcion as Tiro, 
			o.Descripcion as Banco,
			m.Descripcion as Material,
			sum(v.Distancia) as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe,
			tr.PrimerKM as PU1Km,
			tr.KMSubsecuente as PUSub,
			tr.KMAdicional as PUAdic
		from 
			viajes as v, 
			tiros as t, 
			origenes as o,
			materiales as m,
			tarifas as tr
		where 
			tr.Estatus = 1 and
			tr.IdMaterial=".$dmat[IdMaterial]." and
			t.IdTiro=v.IdTiro and
			o.IdOrigen=v.IdOrigen and
			v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and 
			v.IdProyecto=".$IdProyecto." and 
			v.IdTiro=".$d[IdTiro]." and
			m.IdMaterial=v.IdMaterial and
			m.IdMaterial=".$dmat[IdMaterial]."
			Group By Banco) AS Registros";
			//echo $sum;

	$suma=$link->consultar($sum);
	$sumv=mysql_fetch_array($suma);
	$suma=$link->consultar($sum);
$sumv=mysql_fetch_array($suma);
$sumtot=$sumtot+$sumv["sumaviajes"];
$volp=$volp+$sumv["sumavolumen"];
$volsub=$volsub+$sumv["sumasubsecuentes"];
$impp=$impp+$sumv["sumaimporte"];
$impsub=$impsub+$sumv["sumasub"];

$imp=$imp+($sumv["sumaimporte"]+$sumv["sumasub"]); 
			
	
?>
      <tr bgcolor="#0099FF">
        <td colspan="3" bgcolor="#FFFFFF" class="Estilo2">- GLN - </td>
        <td colspan="9" bgcolor="#000000" class="Estilo4">- GLN - </td>
      </tr>
      <tr>
        <td><font color="#0099CC" face="Trebuchet MS" style="font-size:10px; font-weight:bold"></font></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumaviajes]; ?></font></div></td>
        <td>&nbsp;</td>
        <td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumavolumen]; ?></font></div></td>
        <td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumv[sumasubsecuentes]; ?></font></div></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($sumv[sumaimporte],2,".",","); ?></font></div></td>
        <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($sumv[sumasub],2,".",","); ?></font></div></td>
        <td><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($sumv[sumatotal],2,".",","); ?></font></div></td>
      </tr>
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
      </tr>
      <?php
	}#Material
	?>
      <?php
    }?>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">TOTAL:</font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $sumtot; ?></font></div></td>
        <td bgcolor="#000000">&nbsp;</td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volp,2,".",","); ?></font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($volsub,2,".",","); ?></font></div></td>
        <td bgcolor="#000000">&nbsp;</td>
        <td bgcolor="#000000">&nbsp;</td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impp,2,".",","); ?></font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($impsub,2,".",","); ?></font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($imp,2,".",","); ?></font></div></td>
      </tr>
    </table></td>
  </tr>
</table>
  

<?php } else {?>
<table width="600" align="center" >
  <tr>
    <td class="Titulo">NO EXISTEN ACARREOS EJECUTADOS EN EL PERIODO: </td>
  </tr>
   <tr>
    <td class="Titulo">DEL:<span class="Estilo1"> <?PHP echo $inicial; ?> </span>AL: <span class="Estilo1"><?PHP echo $final; ?></span></font></td>
   </tr>

  <tr>
    <td class="Titulo">&nbsp;</td>
  </tr>
</table>

  <?php }?> 
</body>
</html>
