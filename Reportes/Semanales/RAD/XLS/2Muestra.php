<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}
?>
<?php

	session_start();
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Reporte de Avance (RAD) '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	$inicial=$_REQUEST["inicial"];
	$final=$_REQUEST["final"];
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Trebuchet MS;
	font-size: 10px;
	color: #000000;
}
-->
</style>

<style type="text/css">
<!--
.Estilo1 {color: #FF0000}
.Estilo2 {font-size: 1px; color: #FFFFFF}
.Estilo4 {font-size: 1px; color: #cccccc; }
body,td,th {
	font-family: Trebuchet MS;
	font-size: 12px;
}
.style2 {color: #FFFFFF}
.style6 {font-size: 1px}
.style8 {color: #FFFFFF; font-size: 2px; }
-->
</style>
</head>

<body>
<?php
	include ("../../../../inc/php/conexiones/SCA.php");
	include ("../../../../Clases/Funciones/Rangos.php");
	
	

$sql="SELECT DISTINCT c.IdCosto as IdCosto from  costos as c WHERE c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." ";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
$fechas=rango($inicial,$final,1);
$fechas2=rango($inicial,$final,2);
?>
<table align="center" bordercolor="#FFFFFF">
  <tr>
    <td colspan="4"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">REPORTE DE AVANCE (RAD) DEL <?PHP echo $inicial; ?> AL <?PHP echo $final; ?></font></td>
  </tr>
  <tr>
    <td colspan="4"  align="center"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $_SESSION[DescripcionProyecto]; ?></font></div></td>
  </tr>
  <tr>
    <td colspan="4"  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"  align="center"><table  align="center" border="0">
      <tr>
        <td colspan="4">&nbsp;</td>
        <?php $i=0;while(each($fechas)) {?>
        <td colspan="2" align="center" <?PHP $a=$i%2; if($a==0) {?>bgcolor="969696" <?php } else {?>bgcolor="C0C0C0"<?php }?>><?php echo $fechas[$i]; ?></td>
        <?php $i++;}?>
        <td >&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#000000"><span class="style2">ACUMULADO</span></td>
        <td bgcolor="#000000" align="center" colspan="2" ><span class="style2">ACUMULADO</span></td>
        <td bgcolor="#000000" align="center" colspan="2"><span class="style2">ACUMULADO</span></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <?php $j=0; while($j<$i) {?>
        <td colspan="2" align="center" <?PHP $a=$j%2; if($a==0) {?>bgcolor="969696" <?php } else {?>bgcolor="C0C0C0"<?php }?> >&nbsp;VOLUMEN&nbsp;</td>
        <?php $j++;}?>
        <td >&nbsp;</td>
        <td colspan="2" align="center" bgcolor="#000000"><span class="style2">PERIODO</span></td>
        <td bgcolor="#000000" align="center" colspan="2" ><span class="style2">ANTERIOR</span></td>
        <td colspan="2" bgcolor="#000000" align="center"><span class="style2"> A LA FECHA</span></td>
      </tr>
      <tr>
        <td colspan="4" bgcolor="808080">ETAPA DEL PROYECTO</td>
        <?php $k=0;while($k<$i) {?>
        <td align="center" <?PHP $a=$k%2; if($a==0) {?>bgcolor="808080" <?php } else {?>bgcolor="969696"<?php }?>>BRUTO&nbsp;</td>
        <td align="center" <?PHP $a=$k%2; if($a==0) {?>bgcolor="808080" <?php } else {?>bgcolor="969696"<?php }?>>COMPACTADO</td>
        <?php $k++;}?>
        <td >&nbsp;</td>
        <td bgcolor="#000000"><span class="style2">BRUTO</span></td>
        <td bgcolor="#000000"><span class="style2">COMPACTADO</span></td>
        <td bgcolor="#000000"><span class="style2">BRUTO</span></td>
        <td bgcolor="#000000"><span class="style2">COMPACTADO</span></td>
        <td bgcolor="#000000"><span class="style2">BRUTO </span></td>
        <td align="right" bgcolor="#000000"><span class="style2">COMPACTADO</span></td>
      </tr>
      <?php $filas="select distinct (c.IdEtapaProyecto) as IdEtapa, ep.Descripcion as Etapa from costos as c, etapasproyectos as ep where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdEtapaProyecto=ep.IdEtapaProyecto and c.IdProyecto=".$_SESSION[Proyecto].""; 
  $qf=$link->consultar($filas);
  while($vf=mysql_fetch_array($qf)) {?>
      <tr>
        <td colspan="4" bgcolor="c0c0c0"><?php echo utf8_encode($vf[Etapa]); ?></td>
        <?php $l=0;while($l<$i) {?>
        <td bgcolor="c0c0c0" align="right"><?php 
		#SE CALCULA EL IMPORTE DE VOLUMEN BRUTO POR ETAPA DE PROYECTO Y FECHA
		 $sumaretapa="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje='".fechasql($fechas[$l])."' ";
		 
		 //echo $sumaretapa;
		 		$qsumaetapa=$link->consultar($sumaretapa);
						 $vsumaetapa=mysql_fetch_array($qsumaetapa);
						 
                         if($vsumaetapa[vt]!='')
						 echo number_format($vsumaetapa[vt],2,".",",");
						 else
						 echo "0.00";
	
	?>        </td>
        <td bgcolor="c0c0c0" align="right"><?php  
						 if($vsumaetapa[vtab]!='')
						 echo number_format($vsumaetapa[vtab],2,".",",");
						 else
						 echo "0.00";?></td>
        <?php $l++;}?>
        <td >&nbsp;</td>
        <td align="right" bgcolor="c0c0c0"><?PHP 
	#SE OBTIENE LA SUMA DE LO ACUMULADO A LA SEMANA POR ETAPA DEL PROYECTO
	$sumaretapasemana="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' ";
		 		$qsumaetapasemana=$link->consultar($sumaretapasemana);
						 $vsumaetapasemana=mysql_fetch_array($qsumaetapasemana);
						 
                         if($vsumaetapasemana[vt]!='')
						 echo number_format($vsumaetapasemana[vt],2,".",",");
						 else
						 echo "0.00";
	
	?></td>
        <td align="right" bgcolor="c0c0c0"><?php  if($vsumaetapasemana[vtab]!='')
						 echo number_format($vsumaetapasemana[vtab],2,".",",");
						 else
						 echo "0.00";?></td>
        <td align="right" bgcolor="c0c0c0"><?php 
			#SE OBTIENE LA SUMA DE LO ACUMULADO ANTERIOR
	$sumaretapaanterior="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM) as vtab from costos as c where c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje<'".fechasql($inicial)."'";
	//echo $sumaretapaanterior;
	
		 		$qsumaetapaanterior=$link->consultar($sumaretapaanterior);
						 $vsumaetapaanterior=mysql_fetch_array($qsumaetapaanterior);
						 
                         if($vsumaetapaanterior[vt]!='')
						 echo number_format($vsumaetapaanterior[vt],2,".",",");
						 else
						 echo "0.00";
		?></td>
        <td align="right" bgcolor="c0c0c0"><?php  if($vsumaetapaanterior[vtab]!='')
						 echo number_format($vsumaetapaanterior[vtab],2,".",",");
						 else
						 echo "0.00";?></td>
        <td bgcolor="c0c0c0" align="right"><?PHP 
	#SE OBTIENE LA SUMA DE LO ACUMULADO A LA FECHA POR ETAPA DEL PROYECTO
	$sumaretapaacumulado="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]."; ";
	
	//echo $sumaretapaacumulado;
		 		$qsumaetapaacumulado=$link->consultar($sumaretapaacumulado);
						 $vsumaetapaacumulado=mysql_fetch_array($qsumaetapaacumulado);
						 
                         if($vsumaetapaacumulado[vt]!='')
						 echo number_format($vsumaetapaacumulado[vt],2,".",",");
						 else
						 echo "0.00";
	
	?>        </td>
        <td align="right" bgcolor="c0c0c0"><?php if($vsumaetapaacumulado[vtab]!='')
						 echo number_format($vsumaetapaacumulado[vtab],2,".",",");
						 else
						 echo "0.00";?></td>
      </tr>
      <?php # INICIA LA OBTENCIÓN  DE TIPOS ORIGEN
			$tipoo="select distinct c.IdTipoOrigen as IdTipo, tor.Descripcion as Tipo from costos as c, tiposorigenes as tor where c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdTipoOrigen=tor.IdTipoOrigen and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' ;";
			 //echo $tipoo;
			 $ctipos=$link->consultar($tipoo);
			 while($ftipos=mysql_fetch_array($ctipos))
			 {
			 ?>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3" >-<?php echo $ftipos[Tipo]; ?></td>
        <?php $l=0;while($l<$i) {?>
        <td align="right">&nbsp;
            <?php 
						 #SE REALIZA EL CÁLCULO DEL VOLUMEN BRUTO POR ETAPA DE PROYECTO Y TIPO DE ORIGEN
						 $sumar="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdTipoOrigen=".$ftipos[IdTipo]." and c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje='".fechasql($fechas[$l])."' ";
						 //echo $sumar;
						 $qsuma=$link->consultar($sumar);
						 $vsuma=mysql_fetch_array($qsuma);
						 
                         if($vsuma[vt]!='')
						 echo number_format($vsuma[vt],2,".",",");
						 else
						 echo "0.00";
                         ?>        </td>
        <td align="right"><?php  if($vsuma[vtab]!='')
						 echo number_format($vsuma[vtab],2,".",",");
						 else
						 echo "0.00";?></td>
        <?php $l++;}?>
        <td >&nbsp;</td>
        <td align="right"><?PHP 
	#SE OBTIENE LA SUMA DE LO ACUMULADO A LA SEMANA POR ETAPA DEL PROYECTO Y TIPO DE ORIGEN
	$sumaretapasemanatipo="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdTipoOrigen=".$ftipos[IdTipo]." and c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' ";
		 $qsumaetapasemanatipo=$link->consultar($sumaretapasemanatipo);
		 $vsumaetapasemanatipo=mysql_fetch_array($qsumaetapasemanatipo);
						 
         if($vsumaetapasemanatipo[vt]!='')
		 echo number_format($vsumaetapasemanatipo[vt],2,".",",");
		 else
		 echo "0.00";
	
	?></td>
        <td align="right"><?php if($vsumaetapasemanatipo[vtab]!='')
		 echo number_format($vsumaetapasemanatipo[vtab],2,".",",");
		 else
		 echo "0.00";?></td>
        <td align="right"><?PHP 
	#SE OBTIENE LA SUMA DE LO ACUMULADO A LA SEMANA POR ETAPA DEL PROYECTO Y TIPO DE ORIGEN
	$sumaretapaanteriortipo="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdTipoOrigen=".$ftipos[IdTipo]." and c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje<'".fechasql($inicial)."' ";
		 $qsumaetapaanteriortipo=$link->consultar($sumaretapaanteriortipo);
		 $vsumaetapaanteriortipo=mysql_fetch_array($qsumaetapaanteriortipo);
						 
         if($vsumaetapaanteriortipo[vt]!='')
		 echo number_format($vsumaetapaanteriortipo[vt],2,".",",");
		 else
		 echo "0.00";
	
	?></td>
        <td align="right"><?php  if($vsumaetapaanteriortipo[vtab]!='')
		 echo number_format($vsumaetapaanteriortipo[vtab],2,".",",");
		 else
		 echo "0.00";?></td>
        <td align="right"><?PHP 
	#SE OBTIENE LA SUMA DE LO ACUMULADO A LA FECHA POR ETAPA DEL PROYECTO Y TIPO DE ORIGEN
	$sumaretapaacumuladotipo="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdTipoOrigen=".$ftipos[IdTipo]." and c.IdEtapaProyecto=".$vf[IdEtapa]." and c.IdProyecto=".$_SESSION[Proyecto]."  ";
		 $qsumaetapaacumuladotipo=$link->consultar($sumaretapaacumuladotipo);
		 $vsumaetapaacumuladotipo=mysql_fetch_array($qsumaetapaacumuladotipo);
						 
         if($vsumaetapaacumuladotipo[vt]!='')
		 echo number_format($vsumaetapaacumuladotipo[vt],2,".",",");
		 else
		 echo "0.00";
	
	?></td>
        <td align="right"><?php          if($vsumaetapaacumuladotipo[vtab]!='')
		 echo number_format($vsumaetapaacumuladotipo[vtab],2,".",",");
		 else
		 echo "0.00";?></td>
      </tr>
      <?php # TERMINA LA OBTENCIÓN DE LOS TIPOS ORIGEN?>
      <?php } }?>
      <tr>
        <td colspan="<?php $r=5+($i*2); echo $r; ?>"><span class="style8">-GLN-</span></td>
        <td colspan="6" bgcolor="#000000"><span class="style6">- GLN -</span></td>
        </tr>
      <tr>
      <td colspan="<?php $r=5+($i*2); echo $r; ?>">&nbsp;</td>
     
      <td align="right" ><?PHP 
	#SE OBTIENE LA SUMA TOTAL DE LO ACUMULADO A LA SEMANA POR ETAPA DEL PROYECTO Y TIPO DE ORIGEN
	$sumaretapasemanatipo="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' ";
		 $qsumaetapasemanatipo=$link->consultar($sumaretapasemanatipo);
		 $vsumaetapasemanatipo=mysql_fetch_array($qsumaetapasemanatipo);
						 
         if($vsumaetapasemanatipo[vt]!='')
		 echo number_format($vsumaetapasemanatipo[vt],2,".",",");
		 else
		 echo "0.00";
	
	?></td>
      <td align="right"><?php  if($vsumaetapasemanatipo[vtab]!='')
		 echo number_format($vsumaetapasemanatipo[vtab],2,".",",");
		 else
		 echo "0.00";?></td>
      <td align="right"><?PHP 
	#SE OBTIENE LA SUMA TOTAL DE LO ACUMULADO ANTERIOR POR ETAPA DEL PROYECTO Y TIPO DE ORIGEN
	$sumaretapaantestipo="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.FechaViaje<'".fechasql($inicial)."' ";
		 $qsumaetapaantestipo=$link->consultar($sumaretapaantestipo);
		 $vsumaetapaantestipo=mysql_fetch_array($qsumaetapaantestipo);
						 
         if($vsumaetapaantestipo[vt]!='')
		 echo number_format($vsumaetapaantestipo[vt],2,".",",");
		 else
		 echo "0.00";
	
	?></td>
      <td align="right"><?php  if($vsumaetapaantestipo[vtab]!='')
		 echo number_format($vsumaetapaantestipo[vtab],2,".",",");
		 else
		 echo "0.00";?></td>
      <td align="right"><?PHP 
	#SE OBTIENE LA SUMA TOTAL DE LO ACUMULADO A LA FECHA POR ETAPA DEL PROYECTO
	$sumaretapaacumulado="select sum(VolumenPrimerKM) as vt, sum(VolumenPrimerKM_Ab) as vtab from costos as c where  c.IdProyecto=".$_SESSION[Proyecto]."; ";
		 		$qsumaetapaacumulado=$link->consultar($sumaretapaacumulado);
						 $vsumaetapaacumulado=mysql_fetch_array($qsumaetapaacumulado);
						 
                         if($vsumaetapaacumulado[vt]!='')
						 echo number_format($vsumaetapaacumulado[vt],2,".",",");
						 else
						 echo "0.00";
	
	?></td>
      <td align="right"><?php                         
	                     if($vsumaetapaacumulado[vtab]!='')
						 echo number_format($vsumaetapaacumulado[vtab],2,".",",");
						 else
						 echo "0.00";?></td>
      </tr>
    </table></td>
  </tr>
</table>
<?php 

} else {?>
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
