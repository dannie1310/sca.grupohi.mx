<?php 
	session_start();
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/FuncionesValidaViajes.php");

$aprobados=$_REQUEST[caprobados];
$rechazados=$_REQUEST[crechazados];


			
		$linkde=SCA::getConexion();
		$sde="select vn.IdCamion,vn.IdTiro, vn.FechaLlegada as Fecha, c.Economico as Camion, t.descripcion as Destino, vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m, camiones as c, tiros as t where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.IdViajeNeto in(".$aprobados.") and c.IdCamion=vn.IdCamion and t.IdTiro=vn.IdTiro;";
		//echo $sde;
		$rde=$linkde->consultar($sde);
		$no_viajes=$linkde->affected();
		//$linkde->cerrar();
		
		$linkder=SCA::getConexion();
		$sder="select vn.IdCamion,vn.IdTiro, vn.FechaLlegada as Fecha, c.Economico as Camion, t.descripcion as Destino, vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m, camiones as c, tiros as t  where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.IdViajeNeto in(".$rechazados.") and c.IdCamion=vn.IdCamion and t.IdTiro=vn.IdTiro;";
		//echo $sd;
		$rder=$linkder->consultar($sder);
		$no_viajesr=$linkder->affected();
		//$linkder->cerrar();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />

<title>Untitled Document</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #339933}
-->
</style>
</head>

<body>
<table width="600" border="0" align="center">
<?php if($aprobados!=''){?>
  <tr>
    <td colspan="6" align="center" class="Subtitulo">VERIFIQUE SI REALMENTE DESEA <span class="style2">APROBAR</span> QUE SE REGISTREN EN EL SISTEMA <BR>LOS SIGUIENTES VIAJES</td>
  </tr>
  <tr>
    <td width="76">&nbsp;</td>
    <td width="181">&nbsp;</td>
    <td width="33">&nbsp;</td>
    <td width="33">&nbsp;</td>
    <td width="186">&nbsp;</td>
    <td width="79">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="600" border="0" align="center">
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../../../Imgs/calendarp.gif" width="15" height="16" /></td>
        <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16"></td>
        <td width="53" align="center"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16"></td>
        </tr>
      <tr>
        <td width="41" class="EncabezadoTabla">&nbsp;</td>
        <td width="60" class="EncabezadoTabla">Fecha</td>
        <td width="70" class="EncabezadoTabla">Cami&oacute;n</td>
        <td width="89" class="EncabezadoTabla">Origen</td>
        <td width="121" class="EncabezadoTabla">Destino</td>
        <td width="136" class="EncabezadoTabla">Material</td>
        <td class="EncabezadoTabla">Ruta</td>
        </tr>
      <?php $i=1; 	$contador=0;
 while($vde=mysql_fetch_array($rde)){
				  if(RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro])!='')
				  $ruta=RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro]);
				  else
				  $ruta='N/R';
				  if(($no_viajes-1)==$contador)
				  {				 
				 	 $f=$f.$vde[Fecha];
					 $d=$d.$vde[IdTiro];
					 $c=$c.$vde[IdCamion];
				  }
				  else
				  {
  				 	 $f=$f.$vde[Fecha].',';
					 $d=$d.$vde[IdTiro].',';
					 $c=$c.$vde[IdCamion].',';
				  }
				  ?>
      <tr>
        <td class="Item1"><?php echo $i; ?>&nbsp;</td>
        <td class="Item1"><?php echo fecha($vde[Fecha]); ?></td>
        <td class="Item1"><?php echo $vde[Camion]; ?></td>
        <td class="Item1"><?php echo $vde[Origen]; ?>&nbsp;</td>
        <td class="Item1"><?php echo $vde[Destino]; ?></td>
        <td class="Item1"><?php echo $vde[Material]; ?></td>
        <td class="Item1"><?php echo $ruta; ?>&nbsp;</td>
        </tr>
      <?php $i++; $contador++;}?>
    </table></td>
  </tr>
  <?php }?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if($rechazados!=''){?>
  <tr>
    <td colspan="6" align="center" class="Subtitulo">VERIFIQUE SI REALMENTE DESEA <span class="style1">RECHAZAR</span> QUE SE REGISTREN EN EL SISTEMA <BR>LOS SIGUIENTES VIAJES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6"><table width="600" border="0" align="center">
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../../../Imgs/calendarp.gif" width="15" height="16" /></td>
        <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16"></td>
        <td width="53" align="center"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16"></td>
        </tr>
      <tr>
        <td width="41" class="EncabezadoTabla">&nbsp;</td>
        <td width="60" class="EncabezadoTabla">Fecha</td>
        <td width="70" class="EncabezadoTabla">Cami&oacute;n</td>
        <td width="89" class="EncabezadoTabla">Origen</td>
        <td width="121" class="EncabezadoTabla">Destino</td>
        <td width="136" class="EncabezadoTabla">Material</td>
        <td class="EncabezadoTabla">Ruta</td>
      </tr>
      <?php $i=1; 	$contador=0;
 while($vde=mysql_fetch_array($rder)){
				  if(RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro])!='')
				  $ruta=RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro]);
				  else
				  $ruta='N/R';
				 if(($no_viajesr-1)==$contador)
				  {				 
				 	 $fr=$fr.$vde[Fecha];
					 $dr=$dr.$vde[IdTiro];
					 $cr=$cr.$vde[IdCamion];
				  }
				  else
				  {
  				 	 $fr=$fr.$vde[Fecha].',';
					 $dr=$dr.$vde[IdTiro].',';
					 $cr=$cr.$vde[IdCamion].',';
				  }
				  //echo $fr;
				  
				  ?>
      <tr>
        <td class="Item1"><?php echo $i; ?>&nbsp;</td>
        <td class="Item1"><?php echo fecha($vde[Fecha]); ?></td>
        <td class="Item1"><?php echo $vde[Camion]; ?></td>
        <td class="Item1"><?php echo $vde[Origen]; ?>&nbsp;</td>
        <td class="Item1"><?php echo $vde[Destino]; ?></td>
        <td class="Item1"><?php echo $vde[Material]; ?></td>
        <td class="Item1"><?php echo $ruta; ?>&nbsp;</td>
      </tr>
      <?php $i++; $contador++;}?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }
  if($aprobados!=''&&$rechazados!='')
  {
  	$fdef=$f.','.$fr;
	$ddef=$d.','.$dr;
	$cdef=$c.','.$cr;
  }
  else
   if($aprobados!='')
  {
  	$fdef=$f;
	$ddef=$d;
	$cdef=$c;
  }
  else
   if($rechazados!='')
  {
  	$fdef=$fr;
	$ddef=$dr;
	$cdef=$cr;
  }
  ?>
  <tr>
    <td><label>
    <form name="regresa" action="1MuestraDatos.php" method="post">
          <input type="hidden" name="caprobados" id="caprobados" value="<?php echo $aprobados ?>">
      <input type="hidden" name="crechazados" id="crechazados" value="<?php echo $rechazados ?>">
       <input type="hidden" name="fdef" id="fdef" value="<?php echo $fdef; ?>">
       <input type="hidden" name="ddef" id="ddef" value="<?php echo $ddef; ?>">
       <input type="hidden" name="cdef" id="cdef" value="<?php echo $cdef; ?>">


      <input name="button2" type="submit" class="boton" id="button2" value="Regresar">
      </form>
    </label></td>
    <td colspan="4">&nbsp;</td>
    <td  align="right">
    <form name="frm" method="post" action="3Registra.php">
    <span class="texto">
      <input type="hidden" name="caprobados" id="caprobados" value="<?php echo $aprobados ?>">
      <input type="hidden" name="crechazados" id="crechazados" value="<?php echo $rechazados ?>">
    </span>
    <input name="button" type="submit" class="boton" id="button" value="Continuar">
    </form>
    </td>
  </tr>
</table>
</body>
</html>
