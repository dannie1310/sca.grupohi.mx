<?php
	session_start();

if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

	if(isset($_REQUEST["v"]) && ($_REQUEST["v"]==1)){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Acarreos Ejecutados por Origen '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	}
  include("../../../../inc/php/conexiones/SCA.php");
  include("../../../../Clases/Funciones/Catalogos/Genericas.php");
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
	
$sql="
    SELECT DISTINCT p.Descripcion AS Obra, 
      Propietario 
    FROM  viajes AS v
      LEFT JOIN proyectos AS p ON v.IdProyecto = p.IdProyecto
      LEFT JOIN camiones AS c ON v.IdCamion = c.IdCamion
    WHERE v.IdCamion=c.IdCamion 
      AND v.FechaLlegada between '".fechasql($inicial)."' AND '".fechasql($final)."' 
      AND p.IdProyecto=".$IdProyecto;
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
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td width="112">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">REPORTE DE ACARREOS EJECUTADOS POR ORIGEN EN EL PER&Iacute;ODO DEL <?PHP echo $inicial; ?> AL <?PHP echo $final; ?></font></td>
  </tr>
  
  <tr>
    <td colspan="3"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $v[Obra]; ?></font></td>
  </tr>
  
  
  <tr>
    <td colspan="3"><table width="1500" border="0" align="center" >
      <tr>
        <td width="157">&nbsp;</td>
        <td width="276">&nbsp;</td>
        <td width="150">&nbsp;</td>
        <td width="74">&nbsp;</td>
        <td width="79">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="102">&nbsp;</td>
        <td width="102">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold">VOLUMEN</font></div></td>
        <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">P.U.</font></div></td>
        <td colspan="2" bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE</font></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr bgcolor="#0A8FC7">
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">ORIGEN</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DESTINO</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">MATERIAL</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">VIAJES</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">DISTANCIA</font></div></td>
        <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM&nbsp;(m<sup>3</sup>)</font></div></td>
        <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.&nbsp;(m<sup>3</sup>)</font></div></td>
        <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM&nbsp;($)</font></div></td>
        <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.&nbsp;($)</font></div></td>
        <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1ER. KM&nbsp;($) </font></div></td>
        <td bgcolor="c0c0c0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">KM SUBS.</font><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">&nbsp;($)</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">IMPORTE&nbsp;($)</font></div></td>
      </tr>
      <?php
	 
  $llena="
    SELECT DISTINCT IdOrigen  
    FROM viajes AS v
      LEFT JOIN proyectos AS p ON v.IdProyecto = p.IdProyecto
    WHERE v.FechaLlegada between '".fechasql($inicial)."' AND '".fechasql($final)."' 
      AND p.IdProyecto=".$IdProyecto.";";
  $r=$link->consultar($llena);
  
   
  
  while($d=mysql_fetch_array($r))
   { $subtotales[0]=0;
   $sumtot=0;
$volp=0;
$volsub=0;
$impp=0;
$impsub=0;

$imp=0; 
   
    ##########
		$mat="
      SELECT DISTINCT v.IdMaterial 
      FROM viajes AS v
        LEFT JOIN proyectos AS p ON v.IdProyecto = p.IdProyecto
      WHERE v.FechaLlegada between '".fechasql($inicial)."' AND '".fechasql($final)."' 
        AND p.IdProyecto=".$IdProyecto." 
        AND v.IdOrigen=".$d[IdOrigen].";";
		$ma=$link->consultar($mat);
		while($dmat=mysql_fetch_array($ma))
   		{
   
   
   #########
   
   
$rows="
  SELECT count(v.IdViaje) AS Viajes,
    t.Descripcion AS Tiro, 
    o.Descripcion AS Banco, 
    m.Descripcion AS Material, 
    v.Distancia AS Distancia, 
    sum(v.VolumenPrimerKM) AS Vol1KM, 
    sum(v.VolumenKMSubsecuentes) AS VolSub, 
    sum(v.VolumenKMAdicionales) AS VolAdic, 
    sum(v.ImportePrimerKM) AS Imp1Km, 
    sum(v.ImporteKMSubsecuentes) AS ImpSub, 
    sum(v.Importe) AS Importe, 
    v.TPrimerKM as 'PU1Km', 
      v.TKMSubsecuente as 'PUSub', 
      v.TKMAdicional as 'PUAdic'
	FROM viajes AS v, tiros AS t, origenes AS o, materiales AS m 
  WHERE t.IdTiro=v.IdTiro 
    AND o.IdOrigen=v.IdOrigen 
    AND v.FechaLlegada between '".fechasql($inicial)."' AND '".fechasql($final)."' 
    AND v.IdProyecto=".$IdProyecto." 
    AND v.IdOrigen=".$d[IdOrigen]." 
    AND m.IdMaterial=v.IdMaterial 
    AND m.IdMaterial=".$dmat[IdMaterial]." 
  GROUP BY Tiro,TipoTarifa,IdTarifa";
		//echo $rows;
$ro=$link->consultar($rows);
$x=1;
 $sumtont=0;
 

 
	while($fil=mysql_fetch_array($ro))
	{
	 

?>
      <tr>
        <td width="157"><div align="left"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;">
          <?php if($x==1) echo $fil[Banco]; ?>
        </font></div></td>
        <td width="276"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Tiro]; ?></font></td>
        <td width="150"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Material]; ?></font></div></td>
        <td width="74"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Viajes]; ?></font></div></td>
        <td width="79"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Distancia]; ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Vol1KM]; ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[VolSub]; ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PU1Km]; ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[PUSub]; ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[Imp1Km],2,".",","); ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[ImpSub],2,".",","); ?></font></div></td>
        <td width="102"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[Imp1Km]+$fil[ImpSub],2,".",","); ?></font></div></td>
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
			v.Distancia as Distancia,
			sum(v.VolumenPrimerKM) as Vol1KM,
			sum(v.VolumenKMSubsecuentes) as VolSub,
			sum(v.VolumenKMAdicionales) as VolAdic,
			sum(v.ImportePrimerKM) as Imp1Km,
			sum(v.ImporteKMSubsecuentes) as ImpSub,
			sum(v.Importe) as Importe
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
			v.IdOrigen=".$d[IdOrigen]." and
			m.IdMaterial=v.IdMaterial and
			m.IdMaterial=".$dmat[IdMaterial]."
			Group By Banco) AS Registros";
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
        <td><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php $subtotales[0]=$subtotales[0]+$sumv[sumaviajes]; echo $sumv[sumaviajes]; ?></font></div></td>
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
}# Material

?>
      
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#969696"><div align="right"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">SUBTOTAL POR ORIGEN: </font></div></td>
        <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php $total[0]=$total[0]+$sumtot; echo $sumtot; ?></font></div></td>
        <td bgcolor="#969696">&nbsp;</td>
        <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  $total[1]=$total[1]+$volp; echo number_format($volp,2,".",","); ?>
        </font></div></td>
        <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php  $total[2]=$total[2]+$volsub; echo number_format($volsub,2,".",","); ?>
        </font></div></td>
        <td bgcolor="#969696">&nbsp;</td>
        <td bgcolor="#969696">&nbsp;</td>
        <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php $total[3]=$total[3]+$impp; echo number_format($impp,2,".",","); ?></font></div></td>
        <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php $total[4]=$total[4]+$impsub; echo number_format($impsub,2,".",","); ?></font></div></td>
        <td bgcolor="#969696"><div align="right"> <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php $total[5]=$total[5]+$imp;  echo number_format($imp,2,".",","); ?></font></div></td>
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
    }?>
	<tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td bgcolor="#000000"><div align="right"><font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">TOTAL: </font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo $total[0];//$sumtot; ?></font></div></td>
        <td bgcolor="#000000">&nbsp;</td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($total[1],2,".",","); ?></font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($total[2],2,".",","); ?></font></div></td>
        <td bgcolor="#000000">&nbsp;</td>
        <td bgcolor="#000000">&nbsp;</td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($total[3],2,".",","); ?></font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($total[4],2,".",","); ?></font></div></td>
        <td bgcolor="#000000"><div align="right"> <font color="#FFFFFF" face="Trebuchet MS" style="font-size:10px; font-weight:bold"><?php echo number_format($total[5],2,".",","); ?></font></div></td>
      </tr>
    </table></td>
  </tr>
  
</table>
  

<?php } else {?>
<table width="600" align="center" >
  <tr>
    <td class="Titulo">NO EXISTEN ACARREOS REGISTRADOS EN EL PER&Iacute;ODO: </td>
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
