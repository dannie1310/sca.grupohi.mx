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
	
	$sql = "SELECT distinct(centroscosto.IdCentroCosto),concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),centroscosto.Descripcion) as Costo, centroscosto.Cuenta
  FROM    centroscosto centroscosto
       LEFT OUTER JOIN
          costos costos
       ON (centroscosto.IdCentroCosto = costos.IdCentroCosto and $comp centroscosto.IdProyecto=".$_SESSION[Proyecto].") ORDER BY centroscosto.Nivel
	  ";
	
	//echo $sql;
	$r=$link->consultar($sql);
	$filas_costos=$link->affected();
	$cadena_costo='';
	while($v2=mysql_fetch_array($r))
	{
		$id_centro_costo[]=$v2[IdCentroCosto];	
		$descripcion_cc[]=$v2[Costo];	
		$cuenta_cc[]=$v2[Cuenta];
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
else{
	if($t_cc==1){?>
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
    <td rowspan="4" align="center" valign="middle" bordercolor="#000000" bgcolor="#CCCCCC" style="width:150px;border-right-width:1px;" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold;">CENTRO DE COSTO</font></td>
    <td rowspan="4" align="center" valign="middle" bordercolor="#000000" bgcolor="#CCCCCC" style="width:150px;border-right-width:1px;" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold;">CUENTA</font></td>
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
    <td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $cuenta_cc[$o]; ?></font></td>
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
    <td align="right" style="border-top-width:1px;border-right-width:1px" bgcolor="#CCCCCC" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">&nbsp;</font></td>
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
	
<?php
		}else{
			?>
            <table border="1" cellspacing="0" >
<tr>
    <td width="151" colspan="22"  style="border-color:#FFF"><div align="right"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo 'FECHA DE CONSULTA '.date("d-m-Y")."/".date("H:i:s",time()); ?></font></div></td>
  </tr>
  <tr>
    <td colspan="22" style="border-color:#FFF"><font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">CONCENTRADO DE ACARREOS CON CENTRO DE COSTO ASIGNADOS  DEL <?PHP echo $inicial; ?> AL <?PHP echo $final; ?></font></td>
  </tr>

  <tr>
    <td colspan="22" style="border-color:#FFF"><div align="left"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">PROYECTO :</font><font color="#666666" face="Trebuchet MS" style="font-size:12px;">&nbsp;<?php echo utf8_encode($_SESSION[DescripcionProyecto]); ?></font></div></td>
  </tr>
  <tr>
    <td rowspan="4" align="center" valign="middle" bordercolor="#000000" bgcolor="#CCCCCC" style="width:150px;border-right-width:1px;" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold;">CENTRO DE COSTO</font></td>
    <td rowspan="4" align="center" valign="middle" bordercolor="#000000" bgcolor="#CCCCCC" style="width:150px;border-right-width:1px;" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold;">CUENTA</font></td>
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
		//$SQL2 = "select * from centroscosto where IdCentroCosto in (select IdCentroCosto from costos) group by IdPadre";
		$SQL2 = "SELECT distinct(centroscosto.IdPadre)
  FROM    centroscosto centroscosto
       INNER JOIN
          costos costos
       ON (centroscosto.IdCentroCosto = costos.IdCentroCosto AND $comp centroscosto.IdProyecto=".$_SESSION[Proyecto].") ORDER BY centroscosto.IdCentroCosto";
//echo $SQL2;
		$RSQL2 = $link->consultar($SQL2);
		while($VSQL2 = $link->fetch($RSQL2)){
			//NIVEL1********************************************************************************************************************************
			$SQL3 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto = '".$VSQL2["IdPadre"]."' ORDER BY IdCentroCosto";

           	$RSQL3 = $link->consultar($SQL3);
			while($VSQL3 = $link->fetch($RSQL3)){
				?>
                	<tr>
                    	<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL3["Costo"]; ?></font></td>
                        <td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL3["Cuenta"]; ?></font></td>
                        <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL3["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL3["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL3["IdCentroCosto"]." ;";
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
                <?php
				//NIVEL2********************************************************************************************************************************
				$SQL4 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto in (select distinct(IdCentroCosto) from costos) AND IdPadre = '".$VSQL3["IdCentroCosto"]."' ORDER BY IdCentroCosto";				
$RSQL4 = $link->consultar($SQL4);
				while($VSQL4 = $link->fetch($RSQL4)){
					?>
                	<tr>
                    	<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL4["Costo"];?></font></td>
                        <td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL4["Cuenta"]; ?></font></td>
                        <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL4["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL4["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL4["IdCentroCosto"]." ;";
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
                	<?php
					//NIVEL3********************************************************************************************************************************
					$SQL5 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto in (select distinct(IdCentroCosto) from costos) AND IdPadre = '".$VSQL4["IdCentroCosto"]."' ORDER BY IdCentroCosto";
					$RSQL5 = $link->consultar($SQL5);
					while($VSQL5 = $link->fetch($RSQL5)){
						?>
                        <tr>
                            <td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL5["Costo"];?></font></td>
                            <td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL5["Cuenta"]; ?></font></td>
                            <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL5["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL5["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL5["IdCentroCosto"]." ;";
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
                        <?php
						//NIVEL4********************************************************************************************************************************
						$SQL6 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto in (select disctinct(IdCentroCosto) from costos) AND IdPadre = '".$VSQL5["IdCentroCosto"]."' ORDER BY IdCentroCosto";
						$RSQL6 = $link->consultar($SQL6);
						while($VSQL6 = $link->fetch($RSQL6)){
							?>
							<tr>
								<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL6["Costo"];?></font></td>
								<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL6["Cuenta"]; ?></font></td>
                                <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL6["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL6["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL6["IdCentroCosto"]." ;";
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
                            <?php
							//NIVEL5********************************************************************************************************************************
							$SQL7 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto in (select distinct(IdCentroCosto) from costos) AND IdPadre = '".$VSQL6["IdCentroCosto"]."' ORDER BY IdCentroCosto";
							$RSQL7 = $link->consultar($SQL7);
							while($VSQL7 = $link->fetch($RSQL7)){
								?>
								<tr>
									<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL7["Costo"];?></font></td>
									<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL7["Cuenta"]; ?></font></td>
                                    <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL7["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL7["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL7["IdCentroCosto"]." ;";
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
                                <?php
								//NIVEL6********************************************************************************************************************************
								$SQL8 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto in (select distinct(IdCentroCosto) from costos) AND IdPadre = '".$VSQL7["IdCentroCosto"]."' ORDER BY IdCentroCosto";
								$RSQL8 = $link->consultar($SQL8);
								while($VSQL8 = $link->fetch($RSQL8)){
									?>
									<tr>
										<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL8["Costo"];?></font></td>
										<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL8["Cuenta"]; ?></font></td>
                                        <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL8["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL8["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL8["IdCentroCosto"]." ;";
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
                                    <?php
									//NIVEL7********************************************************************************************************************************
									$SQL9 = "select distinct(IdCentroCosto),Cuenta,concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(Nivel)/4),Descripcion) as Costo from centroscosto where IdCentroCosto in (select disctinct(IdCentroCosto) from costos) AND IdPadre = '".$VSQL8["IdCentroCosto"]."' ORDER BY IdCentroCosto";
									$RSQL9 = $link->consultar($SQL9);
									while($VSQL9 = $link->fetch($RSQL9)){
										?>
										<tr>
											<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL9["Costo"];?></font></td>
											<td align="left" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold "><?php echo $VSQL9["Cuenta"]; ?></font></td>
                                            <?php
	$sql2="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje between '".fechasql($inicial)."' and '".fechasql($final)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL9["IdCentroCosto"]." ;";
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
	$sql_apc="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.FechaViaje < '".fechasql($inicial)."' and c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL9["IdCentroCosto"]." ;";
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
	$sql_af="select sum(VolumenPrimerKM) as VPK, sum(VolumenKMSub) as VKS, sum(VolumenKMAdc) as VKA, sum(VolumenTotal) as VT, sum(VolumenPrimerKM_Ab) as VPK_A, sum(VolumenKMSub_Ab) as VKS_A, sum(VolumenKMAdc_Ab) as VKA_A, sum(VolumenTotal_Ab) as VT_A, sum(ImportePrimerKM) as IPK, sum(ImporteKMSub) as IKS, sum(ImporteKMAdc) as IKA, sum(ImporteTotal) as IT  from costos as c where c.IdProyecto=".$_SESSION[Proyecto]." and c.IdCentroCosto=".$VSQL9["IdCentroCosto"]." ;";
	//echo $sql_apc;
	$r_af=$link->consultar($sql_af);
	$v_af=mysql_fetch_array($r_af);
	?> 
    
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VPK_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-right-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;"><?php echo number_format($v_af[VKS_A],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IPK],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF"  ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IKS],2,'.','') ?></font></td>
    <td align="center" bordercolor="#000000" bgcolor="#666666"  ><font color="#ffffff" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IT],2,'.','') ?></font></td>
										</tr>
                        				<?php
										}
									}
								}
							}
						}
					}
				}
			}
		
	?>
<tr>
    <td align="right" style="border-top-width:1px;border-right-width:1px" bgcolor="#CCCCCC" ><font color="#000000" face="Calibri" style="font-size:12px; font-weight:bold ">&nbsp;</font></td>
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
    <td align="center" bordercolor="#000000" bgcolor="#FFFFFF" style="border-top-width:1px" ><font color="#000000" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IKS],2,'.','') ?></font></td> 
    <td align="center" bordercolor="#000000" bgcolor="#666666" style="border-top-width:1px" ><font color="#ffffff" face="Calibri" style="font-size:12px;">$&nbsp;<?php echo number_format($v_af[IT],2,'.','') ?></font></td>
  </tr>    
</table>
            <?php
			}
	}
?>

<!--********************************************************************************NUEVA TABLA SOLO ASIGNADOS********************************************************************-->


</body>
</html>