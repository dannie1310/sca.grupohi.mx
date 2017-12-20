<?php
session_start();
if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
    exit();
}

	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="Concentrado_de_Estimaciones_'.date("d-m-Y").'_'.date("H.i.s").'.xls;"');
	include("../../../../inc/php/conexiones/SCA.php");
	include("../../../../Clases/Funciones/Catalogos/Genericas.php");
	
	$IdProyecto=$_SESSION['Proyecto'];
	$inicial=$_REQUEST["inicial"];
	$final=$_REQUEST["final"];

	$t_cc=$_REQUEST["t_cc"];
	if($t_cc==1)
		$comp="";
	else
		$comp="FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and";
	
	$link=SCA::getConexion();
	$sql="select distinct(FechaViaje) as Fecha from costos where IdProyecto=".$_SESSION[Proyecto]." order by Fecha;";
	$r=$link->consultar($sql);
	$columnas_fecha=$link->affected();
	
	$sql="select distinct(c.IdCentroCosto) as IdCentroCosto, cc.Descripcion as Costo from costos as c, centroscosto as cc where $comp c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=cc.IdCentroCosto order by Costo;";
	
	//echo $sql;
	$r=$link->consultar($sql);
	$filas_costos=$link->affected();
	$cadena_costo='';
	while($v2=mysql_fetch_array($r))
	{
		$id_centro_costo[]=$v2[IdCentroCosto];	
		$descripcion_cc[]=$v2[Costo];	
		$cadena_costo=$cadena_costo.$v2[IdCentroCosto].',';
	}
	if(strlen($cadena_costo)>1)
	$cadena_costo=substr($cadena_costo,0,strlen($cadena_costo)-1);
//echo $cadena_costo;
	//$link->cerrar();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>

<body>
<?php if($columnas_fecha==0)
{?>
<table width="400" border="0">
  <tr>
    <td  align="center">NO HAY COSTOS ASIGNADOS PARA EL RANGO DE FECHAS DEL <?php echo $inicial; ?> AL  <?php echo $final; ?></td>
  </tr>
</table>
<?php }
else{?>
<table border="1" cellspacing="0" >
  
  <tr>
    <td width="151" colspan="22"  style="border-color:#FFF"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="22" style="border-color:#FFF"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">CONCENTRADO DE ACARREOS POR CENTRO DE COSTO DEL <?PHP echo $inicial; ?> AL <?PHP echo $final; ?></font></td>
  </tr>

  <tr>
    <td colspan="22" style="border-color:#FFF"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo utf8_encode($_SESSION[DescripcionProyecto]); ?></font></div></td>
  </tr>
  <tr>
    <td rowspan="4" align="center" valign="middle" bordercolor="#000000" bgcolor="#CCCCCC" style="width:120px;border-right-width:1px;" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold;">CENTRO DE COSTO</font></td>
    <td colspan="7" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-bottom-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">DEL <?php echo $inicial; ?> AL <?php echo $final; ?></font></td>
    <td colspan="7" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-bottom-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">TOTAL ACUMULADO ANTES DEL PERIODO CONSULTADO</font></td>
    <td colspan="7" align="center"  bordercolor="#000000" bgcolor="#666666" style="border-bottom-width:1px;" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">TOTAL ACUMULADO A LA FECHA</font></td>
  </tr>
  <tr>
    <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">VOLÚMENES</font></td>
    <td colspan="3" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"  style="border-right-width:1px"><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">IMPORTE</font></td>
    <td colspan="4" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">VOLÚMENES</font></td>
    <td colspan="3" rowspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">IMPORTE</font></td>
    <td colspan="4" align="center"  bordercolor="#000000" bgcolor="#666666" style="border-right-width:1px"><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">VOLÚMENES</font></td>
    <td colspan="3" rowspan="2" align="center"  bordercolor="#000000" bgcolor="#666666" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">IMPORTE</font></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"  ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">SUELTO</font></td>
    <td colspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">COMPACTO</font></td>
    <td colspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC"  ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">SUELTO</font></td>
    <td colspan="2" align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">COMPACTO</font></td>
    <td colspan="2" align="center"  bordercolor="#000000" bgcolor="#666666" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">SUELTO</font></td>
    <td colspan="2" align="center"  bordercolor="#000000" bgcolor="#666666" style="border-right-width:1px"><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">COMPACTO</font></td>
  </tr>
  <tr>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px;border-right-width:1px"><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">TOTAL</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="width:95px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">TOTAL</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px;border-right-width:1px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">1er. KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">m<sup>3</sup> KM</font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="width:95px" ><font color="#ffffff" face="Calibri" style="font-size:12px; font-weight:bold ">TOTAL</font></td>
  </tr>
  <?php 
 for($o=0;$o<sizeof($id_centro_costo);$o++)
	{
		$link=SCA::getConexion();
  ?>
  <tr>
    <td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $descripcion_cc[$o]; ?></font></td>
    <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$id_centro_costo[$o]." ;";
	//echo $sql2;
	$r2=$link->consultar($sql2);
	$v2=mysql_fetch_array($r2);
	
	?>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VPK],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VKS],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VPK_A],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VKS_A],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v2[IPK],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v2[IKS],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v2[IT],2,'.',''); ?></font></td>
    
    <?php 
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$id_centro_costo[$o]." ;";
	//echo $sql_apc;
	$r_apc=$link->consultar($sql_apc);
	$v_apc=mysql_fetch_array($r_apc);
	?>
    
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VPK_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VKS_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_apc[IPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_apc[IKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-right-width:1px"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_apc[IT],2,'.','') ?></font></td>
        <?php 
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$id_centro_costo[$o]." ;";
	//echo $sql_apc;
	$r_af=$link->consultar($sql_af);
	$v_af=mysql_fetch_array($r_af);
	?>
    
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VPK_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VKS_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666"  ><font color="#ffffff" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IT],2,'.','') ?></font></td>
  </tr>
  <?php } ?>
  <tr>
    <td align="right" style="border-top-width:1px;border-right-width:1px" bgcolor="#CCCCCC" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">TOTALES:</font></td>
   <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." ;";
	$r2=$link->consultar($sql2);
	$v2=mysql_fetch_array($r2);
	
	?>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VPK],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VKS],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VPK_A],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v2[VKS_A],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v2[IPK],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v2[IKS],2,'.',''); ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-top-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v2[IT],2,'.',''); ?></font></td>
    
    <?php 
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto in(".$cadena_costo.") ;";
	//echo $sql_apc;
	$r_apc=$link->consultar($sql_apc);
	$v_apc=mysql_fetch_array($r_apc);
	?>
    
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  style="border-top-width:1px"><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VPK_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_apc[VKS_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_apc[IPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_apc[IKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#CCCCCC" style="border-top-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_apc[IT],2,'.','') ?></font></td>
        <?php 
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto in(".$cadena_costo.");";
	//echo $sql_apc;
	$r_af=$link->consultar($sql_af);
	$v_af=mysql_fetch_array($r_af);
	?>
    
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VPK_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px;border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VKS_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="border-top-width:1px" ><font color="#ffffff" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IT],2,'.','') ?></font></td>
  </tr>
</table>
	
<?php }
?>
</body>
</html>