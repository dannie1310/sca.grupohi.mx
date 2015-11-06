<?php
	session_start();
	header("Content-type: application/vnd.ms-excel");
	header('Content-Disposition:  filename=Relación de Rutas al Día '.date("d-m-Y").'_'.date("H.i.s",time()).'.cvs;');
	$IdProyecto=$_SESSION['Proyecto'];
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
 <script src="../../../../Clases/Js/NoClick.js">
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
</head>

<body>
<table width="1024" border="1" align="center">
  <tr>
    <td colspan="13"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:16px;text-align:center">RELACI&Oacute;N DE RUTAS Y CRONOMETRIAS REGISTRADAS </font></div>      <div align="center"></div></td>
  </tr>
  <tr>
    <td colspan="13">&nbsp;</td>
    
  </tr>
  <tr>
    <td colspan="8"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:15px;text-align:center">RUTA</font></div></td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td width="142">&nbsp;</td>
    <td colspan="3"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">DISTANCIA</font></div></td>
    <td colspan="2"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:15px;text-align:center">CRONOMETR&Iacute;A ACTIVA </font></div></td>
     <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">FECHA DE </font></div></td>

    <td>&nbsp;</td>
    <td width="142">&nbsp;</td>
    <td width="142"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">1ER</font> </div></td>
    <td width="53"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">KM'S </font></div></td>
    <td width="36"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">KM'S </font></div></td>
    <td width="45">&nbsp;</td>
    
    <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">TIEMPO</font></div></td>
    <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">TIEMPO DE </font></div></td>
    <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">FECHA DE </font></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>

    <td width="44" ><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">RUTA</font></div></td>
    <td width="65" ><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">ALTA</font></div></td>

    <td width="142" ><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">ORIGEN</font></div></td>
    <td width="142"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">TIRO</font></div></td>
    <td width="142"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">KM </font></div></td>
    <td><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">SUBSEC.</font></div></td>
    <td width="36"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">ADIC.</font></div></td>
    <td width="45"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">TOTAL</font></div></td>
    <td width="49"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">M&Iacute;NIMO</font></div></td>
    <td width="84"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">TOLERANCIA</font></div></td>
    <td width="65"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">REGISTRO</font></div></td>
        <td width="58"><div align="center"><font face="Trebuchet MS" style="font-weight:bold; font-size:14px;text-align:center">ESTATUS</font></div></td>

  </tr>
  <?php
  include("../../../../inc/php/conexiones/SCA.php");
include("../../../../Clases/Funciones/Catalogos/Genericas.php");
  $link=SCA::getConexion();
  $sql="
  select 
  	* 
 from 
 	rutas as r 
	where
	r.IdProyecto=$IdProyecto
	
		
 	order by r.IdRuta";
	 $sql = "SELECT concat(r.Clave,r.IdRuta) as ruta,r.*, o.Descripcion as origen, t.Descripcion as tiro, tr.Descripcion as tipo_ruta, if(c.TiempoMinimo is null,'- - - ',c.TiempoMinimo) as minimo,
if(c.Tolerancia is null,'- - - ',c.Tolerancia) as tolerancia,
if(c.FechaAlta is null,'- - - ',Concat(date_format(c.FechaAlta,'%d-%m-%Y'),' / ',c.HoraAlta)) as fecha_hora from cronometrias as c right join rutas as r on(c.IdRuta=r.IdRuta and c.Estatus=1) join origenes as o on(r.IdOrigen=o.IdOrigen) join tiros as t on(t.IdTiro=r.IdTiro) left join tipo_ruta as tr on(tr.IdTipoRuta=r.IdTipoRuta)
left join rutas_archivos as ar on(ar.IdRuta=r.IdRuta)
where  r.IdProyecto = $IdProyecto order by IdRuta";


  $r=$link->consultar($sql);
  
  while($v=mysql_fetch_array($r))
  {
   if($v[Estatus]==0)
   $Estatus="INACTIVO";
   else
    if($v[Estatus]==1)
   $Estatus="ACTIVO";
  ?>
  <tr>
    <td><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?php echo $v[ruta]; ?></font></div></td>
    <td><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?php echo $v[fecha_hora]; ?></font></div></td>

    <td><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?php echo $v[origen]; ?></font></div></td>
    <td><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?php echo $v[tiro]; ?></font></div></td>
    <td><div align="right"><font face="Trebuchet MS" style="font-size:12px"><?php echo $v[PrimerKm]; ?></font></div></td>
    <td><div align="right"><font face="Trebuchet MS" style="font-size:12px"><?php echo  $v[KmSubsecuentes];?></font></div></td>
    <td><div align="right"><font face="Trebuchet MS" style="font-size:12px"><?php echo  $v[KmAdicionales]; ?></font></div></td>
    <td><div align="right"><font face="Trebuchet MS" style="font-size:12px"><?php echo  $v[TotalKM]; ?></font></div></td>
   
   
    
  <td><div align="right"><font face="Trebuchet MS" style="font-size:12px">
    <?php  regresa(cronometrias,TiempoMinimo,IdRuta,$v[IdRuta]); ?>
  </font></div></td>
  <td><div align="right"><font face="Trebuchet MS" style="font-size:12px">
    <?php  regresa(cronometrias,Tolerancia,IdRuta,$v[IdRuta]); ?>
  </font></div></td>
  <td><div align="center"><font face="Trebuchet MS" style="font-size:12px">
    <?php  regresaf(cronometrias,FechaAlta,IdRuta,$v[IdRuta]); ?>
    </font>  </div></td>
 
   <td><div align="center"><font face="Trebuchet MS" style="font-size:12px"><?php echo  $Estatus; ?></font></div></td>
  </tr>
  <?PHP }?>
</table>
</body>
</html>
