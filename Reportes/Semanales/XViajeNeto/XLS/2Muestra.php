<?php
	session_start();
	if(isset($_REQUEST["v"]) && ($_REQUEST["v"]==1)){
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Acarreos Ejecutados por Material '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
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
-->
</style>
</head>


<body>
<?php 

$IdProyecto=$_SESSION['Proyecto'];
$inicial=$_REQUEST["inicial"];
$final=$_REQUEST["final"];
?>

<?php 

	include("../../../../inc/php/conexiones/SCA.php");
	include("../../../../Clases/Funciones/Catalogos/Genericas.php");
$sql="SELECT DISTINCT p.Descripcion as Obra, Propietario from  viajesNetos v, proyectos p, camiones as c, sindicatos s WHERE v.IdCamion=c.IdCamion and v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."' and p.IdProyecto=".$IdProyecto." and v.IdProyecto = p.IdProyecto and  c.idSindicato=s.IdSindicato";
$link=SCA::getConexion();

$row=$link->consultar($sql);
$v=mysql_fetch_array($row);
$hay=$link->affected();
if($hay>0)
{
?>
<table width="1300" border="0" align="center" >
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
    <td colspan="2"  align="center">
      <div align="left">
        <font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;">VIAJES NETOS DEL PER�ODO (</font>
        <font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $inicial; ?></font>
        <font color="#000000" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"> AL </font><font color="#666666" style="font-family:'Trebuchet MS'; font-weight:bold;font-size:14px;"><?PHP echo $final; ?>)</font></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">OBRA:</font>&nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px; "><?php echo $v[Obra]; ?></font></td>
  </tr>

  <tr>
    <td colspan="2"><font color="#000000" face="Trebuchet MS" style="font-size:12px; ">FECHA:</font> &nbsp;<font color="#666666" face="Trebuchet MS" style="font-size:12px; "><?php echo date("d-m-Y"); ?></font></td>
  </tr>
    <tr>
    <td colspan="2"><table width="1300" border="0" align="center" >
      <tr>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
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
        <td colspan="3" bgcolor="969696">
          <div align="center">
            <font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Tarifa</font></font>
          </div>
        </td>
        
      </tr>
      <tr bgcolor="#0A8FC7">
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">#</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Cubicaci&oacute;n m<sup>3</sup></font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Cami&oacute;n</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Sindicato</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Fecha Llegada</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Hora Llegada</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Or�gen</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Destino</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Material</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Tiempo</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Ruta</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Distancia (Km)</font></div></td>        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">1er Km </font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Km Sub. </font></div></td>
        <td bgcolor="C0C0C0"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Km Adc.</font></div></td>
        <td bgcolor="969696"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px; font-weight:bold ">Importe</font> </div></td>
        
      </tr>
      <?php
 
   
		$rows="
		SELECT
      DATE_FORMAT(v.FechaLlegada, '%d-%m-%Y') AS Fecha,
      t.IdTiro,
      t.Descripcion AS Tiro,
      c.IdCamion AS IdCamion,
      c.Economico AS Camion,
      v.IdViajeNeto as IdViaje,
      v.Estatus,
      v.HoraLlegada as Hora,
      v.code,
      if(fa.FactorAbundamiento is null,0.00,fa.FactorAbundamiento) as FactorAbundamiento,
      c.CubicacionParaPago as cubicacion,
      o.Descripcion as origen,
      o.IdOrigen as idorigen,
      m.Descripcion as material,
      m.IdMaterial as idmaterial,
      sin.Descripcion as Sindicato,
      TIMEDIFF(
              (CONCAT(FechaLlegada,' ',HoraLlegada)),
              (CONCAT(FechaSalida,' ',HoraSalida))
              ) as tiempo_mostrar,
      ROUND((HOUR(TIMEDIFF(v.HoraLlegada,v.HoraSalida))*60)+(MINUTE(TIMEDIFF(v.HoraLlegada,v.HoraSalida)))+(SECOND(TIMEDIFF(v.HoraLlegada,v.HoraSalida))/60),2) AS tiempo,
      concat('R-',r.IdRuta) as ruta,
      r.TotalKM as distancia,
      r.IdRuta as idruta,
      tm.IdTarifa as tarifa_material,
      tm.PrimerKM as tarifa_material_pk,
      tm.KMSubsecuente as tarifa_material_ks,
      tm.KMAdicional as tarifa_material_ka,
      tr.IdTarifaTipoRuta as tarifa_ruta,
      if(r.TotalKM>=30,4.40,if(tr.PrimerKM is null,'- - -',tr.PrimerKM))  as tarifa_ruta_pk,
      if(r.TotalKM>=30,2.10,if(tr.KMSubsecuente is null,'- - -',tr.KMSubsecuente))  as tarifa_ruta_ks,
      if(r.TotalKM>=30,0.00,if(tr.KMAdicional is null,'- - -',tr.KMAdicional))  as tarifa_ruta_ka,
      cn.IdCronometria,
      cn.TiempoMinimo,
      cn.Tolerancia,
      if(cn.TiempoMinimo-cn.Tolerancia is null,0.0,cn.TiempoMinimo-cn.Tolerancia) as cronometria,
      if(r.TotalKM>=30,4.40*c.CubicacionParaPago,tr.PrimerKM*1*c.CubicacionParaPago) as ImportePK_R,
      if(r.TotalKM>=30,2.10*r.KmSubsecuentes*c.CubicacionParaPago,tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago) as ImporteKS_R,
      if(r.TotalKM>=30,0.00*r.KmAdicionales*c.CubicacionParaPago,tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago) as ImporteKA_R,
      if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) as ImporteTotal_Rs,
      if(if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago))) is null, '- - -',if(r.TotalKM>=30,((4.40*c.CubicacionParaPago)+(2.10*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)),((tr.PrimerKM*1*c.CubicacionParaPago)+(tr.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tr.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)))) as ImporteTotal_R,
      tm.PrimerKM*1*c.CubicacionParaPago as ImportePK_M,
      tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago as ImporteKS_M,
      tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago as ImporteKA_M,
      ((tm.PrimerKM*1*c.CubicacionParaPago)+(tm.KMSubsecuente*r.KmSubsecuentes*c.CubicacionParaPago)+(tm.KMAdicional*r.KmAdicionales*c.CubicacionParaPago)) as ImporteTotal_M
      FROM
        viajesnetos AS v
      JOIN tiros AS t USING (IdTiro)
      JOIN camiones AS c USING (IdCamion)
      left join origenes as o using(IdOrigen) 
      join materiales as m using(IdMaterial) 
      left join tarifas as tm on(tm.IdMaterial=m.IdMaterial AND tm.Estatus=1) 
      left join factorabundamiento as fa on (m.IdMaterial=fa.IdMaterial and fa.Estatus=1) 
      left join rutas as r on(v.IdOrigen=r.IdOrigen AND v.IdTiro=r.IdTiro AND r.Estatus=1) 
      left join tarifas_tipo_ruta as  tr on(tr.IdTipoRuta=r.IdTipoRuta AND tr.Estatus=1) 
      left join cronometrias as cn on (cn.IdRuta=r.IdRuta AND cn.Estatus=1)
      left join sindicatos as sin on sin.IdSindicato = c.IdSindicato
      WHERE
          v.Estatus in(0,10,20,30)
      AND v.IdProyecto = ".$IdProyecto."
      AND v.FechaLlegada between '".fechasql($inicial)."' and '".fechasql($final)."'
      group by idviaje
      ORDER BY FechaLlegada
";			
			

		$ro=$link->consultar($rows);
		$p=0;
		while($fil=mysql_fetch_array($ro))
			{
        $p++;
			?>
      <tr>
        <td width="1"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $p; ?>       </font></div></td>
        <td width="5"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[cubicacion]; ?></font></div></td>
        <td width="30"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Camion]; ?></font></div></td>
        <td width="30"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Sindicato]; ?></font></div></td>
        <td width="50"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Fecha]; ?></font></div></td>
        <td width="50"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Hora]; ?></font></div></td>
        <td width="40"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[origen]; ?></font></div></td>
        <td width="40"><div align="center"> <font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[Tiro]; ?></font></div></td>
        <td width="70"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[material]; ?></font></div></td>
        <td width="50"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[tiempo_mostrar]; ?></font></div></td>
        <td width="20"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[ruta]; ?></font></div></td>
        <td width="20"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo $fil[distancia]; ?></font></div></td>
        <td width="30"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[tarifa_material_pk],2,".",",");; ?></font></div></td>
        <td width="30"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[tarifa_material_ks],2,".",",");; ?></font></div></td>
        <td width="30"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[tarifa_material_ka],2,".",","); ?></font></div></td>
        <td width="50"><div align="center"><font color="#000000" face="Trebuchet MS" style="font-size:10px;"><?php echo number_format($fil[ImporteTotal_M],2,".",","); ?></font></div></td>
      </tr>

      <?php
			  }
      ?>
      
  

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
