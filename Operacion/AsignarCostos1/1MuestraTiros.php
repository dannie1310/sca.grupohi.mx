<?php 
	session_start();
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Catalogos/Genericas.php");
	$tiro=$_REQUEST[tiro];
	$fecha=$_REQUEST[fecha];
	$IdProyecto=$_SESSION['Proyecto'];
 ?>
<html>
<head>
<META HTTP-EQUIV="Expires" CONTENT="0"> 
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<script language="javascript" type="text/javascript" src="../../Clases/Js/Genericas.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">

</head>

<body>
<table width="840" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" /> SCA.- Asignaci&oacute;n de Costos</td>
  </tr>
   <tr>
    <td  /> &nbsp;</td>
  </tr>
</table>
<?php
	$sql="Select distinct FechaLlegada from viajes where Estatus in(0,10,20)  order by FechaLlegada desc ";
	$link=SCA::getConexion();
	$row=$link->consultar($sql);
 ?>
<table width="700" border="0" align="center">
<?php 
	$i=0;
	while($v=mysql_fetch_array($row))
		{ 
?>
			  <tr style="cursor:hand " onClick="cambiarDisplay('F<?php echo $i; ?>');cambiarDisplay('ms<?php echo $i; ?>');cambiarDisplay('mn<?php echo $i; ?>')">
				
			    <td width="600" class="Concepto" align="left">
				<img src="../../Imgs/16-mPlus.gif" id="ms<?php echo $i; ?>"  <?php if($fecha==$v[FechaLlegada]){ ?>style="display:none "<?php } ?>  align="absmiddle" width="16" height="16" /onmouseover="this.src='../../Imgs/16-moPlus.gif'" onMouseOut="this.src='../../Imgs/16-mPlus.gif'" /><img src="../../Imgs/16-mPlusm.gif" id="mn<?php echo $i; ?>" <?php if($fecha!=$v[FechaLlegada]){ ?>style="display:none "<?php } ?> align="absmiddle" width="16" height="16" /onmouseover="this.src='../../Imgs/16-moPlusm.gif'" onMouseOut="this.src='../../Imgs/16-mPlusm.gif'" />&nbsp;&nbsp;<?php echo fecha($v[FechaLlegada]); ?></td>
			  </tr>
			  <tr bgcolor="#D5EAFF" <?php if($fecha!=$v[FechaLlegada]){ ?>style="display:none "<?php } ?> id="F<?php echo $i; ?>">
				<td >
					<table width="690">
						<?php 
						
						$origenes="
						select distinct(IdTipoOrigen) as IdTipoOrigen, TipoOrigen  from (select tor.IdTipoOrigen as IdTipoOrigen, v.IdOrigen as IdOrigen, 
tor.Descripcion as TipoOrigen from viajes as v, tiposorigenes as tor, origenes as o, tiros as t
 where tor.IdTipoOrigen=o.IdTipoOrigen and v.IdOrigen=o.IdOrigen and v.FechaLlegada='".$v[FechaLlegada]."' and
 v.IdTiro=t.IdTiro and v.Estatus in(0,10,20)) as Tabla group by IdTipoOrigen
						";
						//echo $origenes;
						$ro=$link->consultar($origenes);
						while($vo=mysql_fetch_array($ro))
						{ #new?>
                        
                        <tr class="Item2">
								<td colspan="7">&nbsp;<?php echo $vo[TipoOrigen]; ?></td>
			            </tr>
                        <?php 
						
						#MATERIALES
						$material="select distinct(IdMaterial) as IdMaterial, Material  from (select tor.IdTipoOrigen as IdTipoOrigen, v.IdOrigen as IdOrigen, tor.Descripcion as TipoOrigen,  v.idmaterial as idmaterial, mat.Descripcion as Material
from materiales as mat, viajes as v, tiposorigenes as tor, origenes as o, tiros as t where mat.IdMaterial=v.IdMaterial and 
tor.IdTipoOrigen=o.IdTipoOrigen and v.IdOrigen=o.IdOrigen and v.FechaLlegada='".$v[FechaLlegada]."' and v.IdTiro=t.IdTiro and 
v.Estatus in(0,10,20) and tor.IdTipoOrigen=".$vo[IdTipoOrigen].") as Tabla 
						";
						//echo $material;
						$rm=$link->consultar($material);
						while($vmat=mysql_fetch_array($rm))
						{
						?>
                        <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
                          <td>&nbsp;</td>
                          <td colspan="6" align="left" class="textoG" ><?php echo $vmat[Material]; ?></td>
                        </tr>
                        <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
							  <td>&nbsp;</td>
							  <td align="center">&nbsp;</td>
							  <td align="center">DESTINO</td>
							  <td align="center">NO. VIAJES</td>
							  <td align="center">VOLUMEN</td>
							  <td align="center">IMPORTE</td>
							  <td>&nbsp;</td>
						  </tr>
                        
                        <?php
						
						$tiros="Select v.IdTiro as IdTiro, v.IdOrigen as IdOrigenh, t.Descripcion as Tiro, format(sum(VolumenPrimerKM),2) as Volumen, format(sum(ImportePrimerKM),2) as Importe, sum(ImportePrimerKM) as Importesc, count(IdViaje) as Viajes from origenes as o, tiros as t, viajes as v where o.IdOrigen=v.IdOrigen and o.IdTipoOrigen='".$vo[IdTipoOrigen]."' and v.FechaLlegada='".$v[FechaLlegada]."' and v.IdMaterial=".$vmat[IdMaterial]." and v.IdTiro=t.IdTiro and v.Estatus in(0,10,20) Group By v.IdTiro";
						//echo $tiros;
						$rt=$link->consultar($tiros);
						$pr=1;
						while($vt=mysql_fetch_array($rt))
							{ 
							
								
						?>	
                        
                        
                        <form name="frm" action="3SolicitaCentros.php" method="post">
							<tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
								<td width="28">&nbsp;</td>
					          <td width="22">&nbsp;</td>
						         <td width="241"><?php echo $vt[Tiro]; ?>
                                   <input type="hidden" value="<?php echo $v[FechaLlegada];?>" name="fecha">
                                   <input type="hidden" value="1" name="tipoa">
                                   <input type="hidden" value="<?php echo $vt[IdTiro];?>" name="tiro">
                                   <input type="hidden" value="<?php echo $vt[IdOrigenh];?>" name="origen">
								   <input type="hidden" value="<?php echo $vmat[IdMaterial];?>" name="material">
                                   <input name="numero" type="hidden" value="1">
                                   <input type="hidden" value="<?php echo $vt[Viajes]; ?>" name="totalviajes">
                                   <input type="hidden" value="<?php echo $vt[Importesc]; ?>" name="importe">
                                   <input name="torigen" type="hidden" value="<?php echo $vo[IdTipoOrigen]; ?>"></td>
						         <td width="94" align="right"> <?php echo $vt[Viajes]; ?></td>
								<td width="89" align="right"><?php echo $vt[Volumen]; ?> m<sup>3</sup></td>
						        <td width="91" align="right">$ <?php echo $vt[Importe]; ?></td>
						        <td width="93"><input name="Submit" type="submit" class="boton" value="Asignar"></td>
							</tr>
							</form>
                            
                            
                            
						<?php $pr++;}
						}#new
						
						}#MATERIALES?>
				  </table>
				</td>
			  </tr>
<?php $i++;}?>
</table>
</body>
</html>
