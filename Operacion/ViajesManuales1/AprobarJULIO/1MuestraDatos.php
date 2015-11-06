<?php 
	session_start();
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/FuncionesValidaViajes.php");

	$re=explode(',',$_REQUEST[crechazados]);
	$ap=explode(',',$_REQUEST[caprobados]);
	$fe=explode(',',$_REQUEST[fdef]);
	$de=explode(',',$_REQUEST[ddef]);
	$ce=explode(',',$_REQUEST[cdef]);
	//echo $_REQUEST[ddef];
	$link=SCA::getConexion(); 
	$select="select distinct FechaLlegada from viajesnetos where Estatus=29 and IdProyecto=".$_SESSION[Proyecto].";";
	$r=$link->consultar($select);
	$num=$link->affected();
	//$link->cerrar();
	$cfecha=0;

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../../Clases/Js/Operacion/ValidarSeleccionViajes.js"></script>
<script language="javascript" src="../../../Clases/Js/Genericas.js"></script>
<script language="javascript" src="ajax.js"></script>


<script type="text/javascript">
var aprobados=new Array();
var rechazados=new Array();

function envia_formulario(f)
{
	for(x=0;x<aprobados.length;x++)
	{
		aprobados.pop();
	}
	for(x=0;x<rechazados.length;x++)
	{
		rechazados.pop();
	}
	for (i=0;i<document.getElementById(f).elements.length;i++)
	{
		if(document.getElementById(f).elements[i].type=="checkbox"&&document.getElementById(f).elements[i].id.split("_").length>1)
		{
			//alert(document.getElementById(f).elements[i].id);
			if(document.getElementById(f).elements[i].id.indexOf("fa")!=-1&&document.getElementById(f).elements[i].checked==true)
			{
				//alert(document.getElementById(f).elements[i].id+" aprobado");
				aprobados.push(document.getElementById(f).elements[i].value);
			}
			else
			if(document.getElementById(f).elements[i].id.indexOf("fr")!=-1&&document.getElementById(f).elements[i].checked==true)
			{
				//alert(document.getElementById(f).elements[i].id+" rechazado");
				rechazados.push(document.getElementById(f).elements[i].value);
			}
			
		}

	}
document.getElementById("crechazados").value=rechazados;
document.getElementById("caprobados").value=aprobados;
if(rechazados.length==0&&aprobados.length==0)
alert("DEBE APROBAR O  RECHAZAR POR LO MENOS UN VIAJE");
else
document.getElementById(f).submit();
}
function rechaza_hijos(padre,padreo,ch,no)
{
	if(ch==true)
	{
		for(i=0;i<no;i++)
		{
			
			document.getElementById(padre+'_'+i).checked=true;
			document.getElementById(padreo+'_'+i).checked=false;
	
		}
	}
	else
	{
		for(i=0;i<no;i++)
		{
			
			document.getElementById(padre+'_'+i).checked=false;
			//document.getElementById(padreo+'_'+i).checked=false;
	
		}

	}
}
function acepta_hijos(padre,padreo,ch,no)
{
//alert(padre+padreo+ch+no);
	if(ch==true)
	{
		for(i=0;i<no;i++)
		{
			
			document.getElementById(padre+'_'+i).checked=true;
			document.getElementById(padreo+'_'+i).checked=false;
	
		}
	}
	else
	{
		for(i=0;i<no;i++)
		{
			
			document.getElementById(padre+'_'+i).checked=false;
			//document.getElementById(padreo+'_'+i).checked=false;
	
		}

	}
}
</script>
<script type="text/javascript" src="../../../inc/js/ajax.js"></script>
<style>
#detalle{
	width:550px;
	height:auto;
	/*border:#999 solid 1px;*/
	display:inline-block;
	}
#lista{
	margin-left:20px;}
</style>
<body>
<?php if($num>0){ 

?>

<!--<form name="frm" id="frm" method="post" action="2Valida.php">-->
<div id="lista">
<table width="300" border="0" align="left" >
<?php 
	while($v=mysql_fetch_array($r))
	{
		
		$sd="select distinct vn.IdTiro, t.Descripcion as Destino from viajesnetos as vn, tiros as t where vn.FechaLlegada='".$v[FechaLlegada]."' and vn.IdTiro=t.IdTiro and vn.Estatus=29;";
		
		//echo $sd;

		$rd=$link->consultar($sd);
		
		//$linkd->cerrar();
		
		 $nofecha=true; for($mm=0;$mm<=sizeof($fe);$mm++){ if($fe[$mm]==$v[FechaLlegada]){$nofecha=false; break;}}
		?>
     
     <tr>
        <td width="24"><img style="cursor:hand;<?php  if($nofecha!=true){ ?> display:none <?php }?>" src="../../../Imgs/16-square-red-add.gif" id="masf<?php echo $cfecha; ?>" onClick="cambiarDisplay('masf<?php echo $cfecha; ?>');cambiarDisplay('menosf<?php echo $cfecha; ?>');cambiarDisplay('tabla<?php echo $cfecha; ?>')" width="16" height="16" onMouseOver="this.src='../../../Imgs/16-square-blue-add.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-add.gif'"/>
        
        <img style="cursor:hand;<?php  if($nofecha==true){ ?> display:none <?php }?>" src="../../../Imgs/16-square-red-remove.gif" id="menosf<?php echo $cfecha; ?>" onClick="cambiarDisplay('masf<?php echo $cfecha; ?>');cambiarDisplay('menosf<?php echo $cfecha; ?>');cambiarDisplay('tabla<?php echo $cfecha; ?>')" width="16" height="16" onMouseOver="this.src='../../../Imgs/16-square-blue-remove.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-remove.gif'"/></td>
        <td width="23"><img src="../../../Imgs/calendarp.gif" width="15" height="16" />
        </td>
     	<?php 
		$count = "select distinct count(vn.IdTiro) as total,vn.IdTiro from viajesnetos as vn, tiros as t where vn.FechaLlegada='".$v[FechaLlegada]."' and vn.IdTiro=t.IdTiro and vn.Estatus=29 group by vn.IdTiro;";
		
		$rcount=$link->consultar($count);
		while($rw = mysql_fetch_assoc($rcount)){
			$total= $rw['total'];
			}
		?>
        <td width="250" colspan="2" class="texto"><?php  echo fecha($v[FechaLlegada]).' = >'.$total.' Viajes';  
 ?>&nbsp;</td>
  </tr>
      <tr id="tabla<?php echo $cfecha;  ?>"  <?php  if($nofecha==true){ ?> style="display:none" <?php }?>>
        <td>&nbsp;</td>
        <td colspan="3"><table width="250" border="0">
        <?php 
		$cdestino=0;

		while($vd=mysql_fetch_array($rd)){
		
		$sc="select distinct vn.IdCamion, c.Economico as Camion from viajesnetos as vn, camiones as c where vn.FechaLlegada='".$v[FechaLlegada]."' and  vn.IdTiro=".$vd[IdTiro]." and vn.IdCamion=c.IdCamion and vn.Estatus=29;";
		
		$rc=$link->consultar($sc);
		//echo $sc;
		//$linkc->cerrar();
		 $notiro=true; for($mm=0;$mm<=sizeof($de);$mm++){  if($de[$mm]==$vd[IdTiro]){$notiro=false; break;}}
		?>
          <tr>
            <td width="24">
<img style="cursor:hand;<?php  if($notiro!=true){ ?> display:none <?php }?>" src="../../../Imgs/16-square-red-add.gif" id="masf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>" onClick="cambiarDisplay('masf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>');cambiarDisplay('menosf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>');cambiarDisplay('tabla<?php echo $cfecha; ?>t<?php echo $cdestino; ?>')" width="16" height="16" onMouseOver="this.src='../../../Imgs/16-square-blue-add.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-add.gif'"/>
        
        <img style="cursor:hand;<?php  if($notiro==true){ ?> display:none <?php }?>" src="../../../Imgs/16-square-red-remove.gif" id="menosf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>" onClick="cambiarDisplay('masf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>');cambiarDisplay('menosf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>');cambiarDisplay('tabla<?php echo $cfecha; ?>t<?php echo $cdestino; ?>')" width="16" height="16" onMouseOver="this.src='../../../Imgs/16-square-blue-remove.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-remove.gif'"/>
            
            </td>
            <td width="24"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16"></td>
            <td width="238" class="texto"><?php echo $vd[Destino];   ?></td>
          </tr>
          <tr id="tabla<?php echo $cfecha;  ?>t<?php echo $cdestino;  ?>" 
          <?php	  if($notiro==true){ ?> style="display:none" <?php }?>
          >
            <td>&nbsp;</td>
            <td colspan="2"><table width="200" border="0">
            <?php 
				$ccamion=0;

			while($vc=mysql_fetch_array($rc)){
			
		
		$sde="select vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.FechaLlegada='".$v[FechaLlegada]."' and  vn.IdTiro=".$vd[IdTiro]." and vn.IdCamion=".$vc[IdCamion]." and vn.Estatus=29;";
		//echo $sd;
		$rde=$link->consultar($sde);
		$no_viajes=$link->affected();
		//$linkde->cerrar();
		
		 $nocamion=true; for($mm=0;$mm<=sizeof($ce);$mm++){  if($ce[$mm]==$vc[IdCamion]){$nocamion=false; break;}}
			 ?>
              <tr>
                <td rowspan="2">
                <!--<img style="cursor:hand;<?php  if($nocamion!=true){ ?> display:none <?php }?>" src="../../../Imgs/16-square-red-add.gif" id="masf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>" onClick="cambiarDisplay('masf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>');cambiarDisplay('menosf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>');cambiarDisplay('tabla<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>')" width="16" height="16" onMouseOver="this.src='../../../Imgs/16-square-blue-add.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-add.gif'"/>
        
        <img style="cursor:hand;<?php  if($nocamion==true){ ?> display:none <?php }?>" src="../../../Imgs/16-square-red-remove.gif" id="menosf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>" onClick="cambiarDisplay('masf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>');cambiarDisplay('menosf<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>');cambiarDisplay('tabla<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>')" width="16" height="16" onMouseOver="this.src='../../../Imgs/16-square-blue-remove.gif'" onMouseOut="this.src='../../../Imgs/16-square-red-remove.gif'"/>-->
                </td>
                <?php 
		$countv = "select count(vn.IdCamion) as TV,vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.FechaLlegada='".$v[FechaLlegada]."' and  vn.IdTiro=".$vd[IdTiro]." and vn.IdCamion=".$vc[IdCamion]." and vn.Estatus=29 group by vn.IdCamion;";
		
		$rcountv=$link->consultar($countv);
		while($rwv = mysql_fetch_assoc($rcountv)){
			$tv= $rwv['TV'];
			}
		?>
                <td  style="cursor:pointer;" onClick="enviaCamion(<?php echo $vc[IdCamion]?>,<?php echo $vd[IdTiro]?>,'<?php echo $v[FechaLlegada]?>')"><img src="../../../Imgs/16-Bus.gif" width="16" height="16">&nbsp;&nbsp;&nbsp;<span class="texto"><?php echo $vc[Camion].' = >'.$tv.' Viajes' ?></span></td>
                <!--<td align="center"><img src="../../../Imgs/Check.gif" width="16" height="16"></td>
                <td align="center"><img src="../../../Imgs/Cross.gif" width="16" height="16"></td>-->
              </tr>
              <tr>
                <!--<td width="28"><input type="checkbox" name="fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>" id="fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>" onClick="cambia1(this.id,'fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>');acepta_hijos(this.id,'fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>',this.checked,'<?php echo $no_viajes ?>');"></td>
                <td width="32"><input type="checkbox"  name="fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>" id="fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>" onClick="cambia2('fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>',this.id);rechaza_hijos(this.id,'fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>',this.checked,'<?php echo $no_viajes ?>');"></td>-->
              </tr>
              <tr id="tabla<?php echo $cfecha; ?>t<?php echo $cdestino; ?>c<?php echo $ccamion; ?>" 
               <?php if($nocamion==true){ ?> style="display:none" <?php }?>
              
              >
                <td width="24">&nbsp;</td>
                <td colspan="4"><!--<table width="700" border="0">
                  <tr>
                    <td align="center">&nbsp;</td>
                    <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16"></td>
                    <td align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16"></td>
                    <td align="center"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16"></td>
                    <td align="center">&nbsp;</td>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="25" class="EncabezadoTabla">&nbsp;</td>
                    <td width="200" class="EncabezadoTabla">Origen</td>
                    <td width="200" class="EncabezadoTabla">Material</td>
                    <td width="95" class="EncabezadoTabla">Ruta</td>
                    <td width="55" align="center" class="EncabezadoTabla"><img src="../../../Imgs/Check.gif" width="16" height="16"></td>
                    <td width="10" align="center" class="EncabezadoTabla"><img src="../../../Imgs/Cross.gif" width="16" height="16"></td>
                  </tr>
                  <?php $i=1; 	$contador=0;
 while($vde=mysql_fetch_array($rde)){
				  if(RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro])!='')
				  $ruta=RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro]);
				  else
				  $ruta='N/R';
				  
				  $chaprobado=false; for($mm=0;$mm<=sizeof($ap);$mm++){  if($ap[$mm]==$vde[Id]){$chaprobado=true; break;}}
				  $chrechazado=false; for($mm=0;$mm<=sizeof($re);$mm++){  if($re[$mm]==$vde[Id]){$chrechazado=true; break;}}

				  
				  ?>
                  <tr>
                    <td class="Item1"><?php echo $i; ?>&nbsp;</td>
                    <td class="Item1"><?php echo $vde[Origen]; ?>&nbsp;</td>
                    <td class="Item1"><?php echo $vde[Material]; ?></td>
                    <td class="Item1"><?php echo $ruta; ?>&nbsp;</td>
                    <td class="Item1"><input type="checkbox" style="cursor:hand" name="fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>" id="fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>" onClick="cambia1('fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>','fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>')" value="<?php echo $vde[Id]?>" <?php if($chaprobado==true) echo "checked";?>></td>
                    <td class="Item1"><input type="checkbox" style="cursor:hand" name="fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>" id="fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>" onClick="cambia2('fa<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>','fr<?php echo $cfecha ?>d<?php echo $cdestino ?>c<?php echo $ccamion ?>_<?php echo $contador ?>')" value="<?php echo $vde[Id]?>" <?php if($chrechazado==true) echo "checked";?>></td>
                  </tr>
                  <?php $i++; $contador++;}?>
                </table>--></td>
              </tr>
              <?php $ccamion++; }?>
            </table></td>
          </tr>
          <?php $cdestino++;}?>
        </table></td>
      </tr>
      
		
	<?php $cfecha++;}
?>
<tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td colspan="2" align="left" class="texto">
       
       <!--<input type="hidden" name="caprobados" id="caprobados">
         <input type="hidden" name="crechazados" id="crechazados">
       <input name="button" type="button" class="boton" id="button" onClick="envia_formulario(this.form.id)" value="Continuar">-->
       
       </td>
  </tr>
    </table>
</div>
<div id="detalle">

</div>
    <!--</form>-->

    <?php } else { ?>
    
    <table width="600" border="0" align="center">
  <tr>
    <td width="68"><img src="../../../Imgs/stop.gif" width="60" height="60"></td>
    <td width="522" colspan="5" class="TituloDeAdvertencia">NO HAY VIAJES MANUALES PARA APROBAR</td>
    </tr>
</table>

        <?php } ?>
</body>
</html>
