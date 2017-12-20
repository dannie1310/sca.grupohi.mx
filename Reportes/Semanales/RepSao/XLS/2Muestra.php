<?php
	session_start();
	if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}
	header('Content-Disposition:  filename=Reporte Captura SAO '.date("d-m-Y").'_'.date("H.i.s",time()).'cvs;');
header("Content-type: application/vnd.ms-excel");
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
body,td,th {
	font-family: Trebuchet MS;
	font-size: 12px;
}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style4 {color: #000000; font-weight: bold; }
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
$sql="SELECT DISTINCT c.IdCosto as IdCosto from  costos as c WHERE c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$IdProyecto." ";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
?>
<table align="center" bordercolor="#FFFFFF">

  <tr>
    <td colspan="13"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="13">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="13"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">CONTROL DE VOLUMENES DE ACARREOS PARA CAPTURA AL SAO EN EL PER&Iacute;ODO DEL <?PHP echo $inicial; ?> AL <?PHP echo $final; ?></font></td>
  </tr>
  
  <tr>
    <td colspan="13"  align="center"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo $_SESSION[DescripcionProyecto]; ?></font></div></td>
  </tr>
  <tr>
    <td colspan="13"  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="13"  align="center">&nbsp;</td>
  </tr>
</table>

<table bordercolor="#FFFFFF" align="center" >
  


  <tr>
    <td  align="center" bgcolor="#333333"><span class="style1">TRAMO</span></td>
    <?PHP 
	#SE OBTIENEN TODOS LOS MATERIALES INVOLUCRADOS EN LOS DISTINTOS TIPOS DE ORIGEN
	$materialesreal="";
	$rm=$link->consultar($materialesreal);
  $cellm=$link->affected();
  
  $materiales="select distinct c.IdTipoOrigen as IdTipo, tor.Descripcion as tipo from costos as c, tiposorigenes as tor where c.IdTipoOrigen=tor.IdTipoOrigen and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."'";
//  echo $materiales;
  $r=$link->consultar($materiales);
  $cell=$link->affected();
  $t=0;
  while($v=mysql_fetch_array($r))
  {$idtipo[$t]=$v[IdTipo];
  $matp="select distinct(v.IdMaterial)  as IdMaterial, m.Descripcion as material from costos as c, materiales as m, viajes as v, partidascostos as pc where c.IdCosto=pc.IdCosto and pc.IdViaje=v.IdViaje and v.IdMaterial=m.IdMaterial and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdTipoOrigen=".$idtipo[$t]."";
			
			
	 	
		$rmp=$link->consultar($matp);
		$nomat=$link->affected();
   ?>
    <td colspan="<?php $row=4+($nomat*3); echo $row; ?>" align="center" bgcolor="808080"><?php echo $v[tipo]; ?></td>
  <?php $t++;} ?>
  </tr>
    <tr>
    <td rowspan="2"  align="center" bgcolor="#333333">&nbsp;</td>
     <?php
	$i=0;
	 while($i<$cell){
	 		
			#POR CADA TIPO DE ORIGEN SE OBTIENE EL MATERIAL ASOCIADO
			$mat="select distinct(v.IdMaterial)  as IdMaterial, m.Descripcion as material from costos as c, materiales as m, viajes as v, partidascostos as pc where c.IdCosto=pc.IdCosto and pc.IdViaje=v.IdViaje and v.IdMaterial=m.IdMaterial and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdTipoOrigen=".$idtipo[$i]."";
			
			//echo $mat;
			# INICIA WHILE DE MATERIALES
	 	
		$rm=$link->consultar($mat);
		$cellmat[$i]=$link->affected();
		
  $ma=0;
  while($vm=mysql_fetch_array($rm))
  {
  $idmaterial[$i][$ma]=$vm[IdMaterial];
  
	  ?>
    
    	
        <td colspan="3" align="center" bgcolor="#C0C0C0"><?php echo $vm[material]; ?></td>
        <?php $ma++;
		} # TERMINA WHILE DE MATERIALES?>
        <td rowspan="2" align="center" valign="bottom" bgcolor="808080">1er. KM&nbsp;(m<sup>3</sup>)</td>
      <td rowspan="2" align="center" valign="bottom" bgcolor="808080">KM Subs.&nbsp;(m<sup>3</sup>)</td>
      <td rowspan="2" align="center" valign="bottom" bgcolor="808080">KM Adc. (m<sup>3</sup>)</td>
      <td rowspan="2" align="center" valign="bottom" bgcolor="808080">Total&nbsp;(m<sup>3</sup>)</td>
    <?php $i++;}
	
	?>
  </tr>
    <tr>
    <?PHP 
	$k=0;
	while($k<$cell)
	{
			$iq=0; 
			while($iq<$cellmat[$k]){ ?>
			  <td align="center" bgcolor="#C0C0C0">1er. KM&nbsp;(m<sup>3</sup>)</td>
	  <td align="center" bgcolor="#C0C0C0">KM Subs.&nbsp;(m<sup>3</sup>)</td>
	  <td align="center" bgcolor="#C0C0C0">KM Adc. (m<sup>3</sup>)</td>
	  <?php $iq++;}
	$k++;}?>
    </tr>
  <?php $s="select distinct (cc.Descripcion), c.IdCentroCosto from costos as c, centroscosto as cc where  c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$IdProyecto." and c.IdCentroCosto=cc.IdCentroCosto order by  cc.nivel  ";
  
  $filas=$link->consultar($s);
  while($vfila=mysql_fetch_array($filas))
  {
   ?>
  <tr>
    <td><?php echo $vfila[Descripcion]; ?></td>
            <?php
            $i=0;
             while($i<$cell){ ?>
              <?php
            $iq=0; 
                    while($iq<$cellmat[$i]){ 
                    # SE OBTIENEN LAS SUMATORIAS DE LOS IMPORTES CLASIFICADOS POR MATERIAL Y TIPO  DE ORIGEN
                    $suma="select  sum(vpk) as vpk, sum(vks) as vks from (select distinct(c.IdCentroCosto), c.VolumenPrimerKM as vpk, c.VolumenKMSub as vks from costos as c, materiales as m, viajes as v, partidascostos as pc where c.IdCosto=pc.IdCosto and pc.IdViaje=v.IdViaje and v.IdMaterial=m.IdMaterial and c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdTipoOrigen=".$idtipo[$i]." and v.IdMaterial=".$idmaterial[$i][$iq]." and c.IdCentroCosto=".$vfila[IdCentroCosto].") as Tabla1";
					
					$suma="select sum(v.Volumen) as vt, sum(v.VolumenPrimerKM) as vpk, sum(v.VolumenKMSubsecuentes) as vks, sum(v.VolumenKMAdicionales) as vka from costos as c, viajes as v, partidascostos as pc
where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdTipoOrigen=".$idtipo[$i]." and c.IdCentroCosto=".$vfila[IdCentroCosto]." and v.IdViaje=pc.IdViaje and
pc.IdCosto=c.IdCosto and v.IdMaterial=".$idmaterial[$i][$iq].";";


                 
                    $rsum=$link->consultar($suma);
                    $vsum=mysql_fetch_array($rsum);
                    
                    
                    ?>
                      <td align="right"><?php    $su[0][$i][$iq]=$su[0][$i][$iq]+$vsum[vpk]; echo number_format($vsum[vpk],2,".",","); ?></td>
    <td align="right"><?php $su[1][$i][$iq]=$su[1][$i][$iq]+$vsum[vks]; echo number_format($vsum[vks],2,".",","); ?></td>
    <td align="right"><?php $su[2][$i][$iq]=$su[2][$i][$iq]+$vsum[vka]; echo number_format($vsum[vka],2,".",","); ?></td>
<?php $iq++;}
            ?>
            
             <?php ?>
             <td align="right"><?php 
            //$total='';VolumenPrimerKM, VolumenKMSub,
                $datocell="select sum(VolumenTotal) as vt, sum(VolumenPrimerKM) as vp, sum(VolumenKMSub) as vs, sum(VolumenKMAdc) as vad from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdTipoOrigen=".$idtipo[$i]." and IdCentroCosto=".$vfila[IdCentroCosto]."";
              // echo $datocell.'<br><br>';
                $rt=$link->consultar($datocell);
                $vtip=mysql_fetch_array($rt);
                if($vtip[vp]!='')echo number_format($vtip[vp],2,".",","); else echo "0.00";
                $total[1][$i]=$total[1][$i]+$vtip[vp];
             ?></td>
    <td align="right"><?php 
            //$total='';VolumenPrimerKM, VolumenKMSub,
                if($vtip[vs]!='')echo number_format($vtip[vs],2,".",","); else echo "0.00";
                $total[2][$i]=$total[2][$i]+$vtip[vs];
             ?></td>
    <td align="right"><?php 
            //$total='';VolumenPrimerKM, VolumenKMSub,
                if($vtip[vad]!='')echo number_format($vtip[vad],2,".",","); else echo "0.00";
                $total[4][$i]=$total[4][$i]+$vtip[vad];
             ?></td>
<td align="right"><?php 
            //$total='';VolumenPrimerKM, VolumenKMSub,
                if($vtip[vt]!='')echo number_format($vtip[vt],2,".",","); else echo "0.00";
                $total[3][$i]=$total[3][$i]+$vtip[vt];
             ?>&nbsp;</td>
    <?php $i++;}?>
  </tr>
  <?php }?>
  
  <tr>
    <td bgcolor="#333333" align="right"><span class="style1">TOTAL:</span></td>
    <?php
	$i=0;
	 while($i<$cell){ ?>
      <?php
	$iq=0; 
			while($iq<$cellmat[$i]){ ?>
    <td align="right" bgcolor="c0c0c0"><strong><?php echo number_format($su[0][$i][$iq],2,".",",");?></strong></td>
    <td align="right" bgcolor="c0c0c0"><strong><?php echo number_format($su[1][$i][$iq],2,".",","); ?></strong></td>
    <td align="right" bgcolor="c0c0c0"><strong><?php echo number_format($su[2][$i][$iq],2,".",","); ?></strong></td>
   <?php $iq++;}
	?>
     
    <td align="right" bgcolor="808080"><span class="style4"><?PHP echo number_format($total[1][$i],2,".",","); ?></span></td>
    <td align="right" bgcolor="808080"><span class="style4"><?PHP echo number_format($total[2][$i],2,".",","); ?></span></td>
    <td align="right" bgcolor="808080"><span class="style4"><?PHP echo number_format($total[4][$i],2,".",","); ?></span></td>
    <td align="right" bgcolor="808080"><span class="style4"><?PHP echo number_format($total[3][$i],2,".",","); ?></span></td>
    <?php $i++;}?>
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
