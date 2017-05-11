<?php
	session_start();
        if($_SESSION["databasesca"] == 'prod_sca_pista_aeropuerto_2'){
            exit();
        }
	
	//Incluimos los Archivos a Usar
		include("../../inc/php/conexiones/SCA.php");
		include("../../Clases/Funciones/Catalogos/Genericas.php");
		include("../../Clases/Funciones/FuncionesValidaViajes.php");
		include("../../Clases/Funciones/FuncionesModificaViajes.php");
		#LA VARIABLE SIGUIENTE ES LA ENCARGADA DE CONTROLAR  QUE VIAJES SON LOS QUE SE DESPLEGARÁN, 0 ->COMPLETOS; 10->SIN ORIGEN; 20->MANUALES
		$tipo=$_REQUEST[tipo];
		$fechaini=$_REQUEST['inicial'];
		$fechafin=$_REQUEST['final'];
		if($_REQUEST[flag]==1)
		{
			$ori=explode("-",$_REQUEST[ori]);
			
		
		}
		
		//include("../../Clases/Loading/CP.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<script language="javascript" src="../../Clases/Js/Operacion/ValidarSeleccionViajes.js"></script>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<script src="../../Clases/Js/Operacion/ValidaViajeRechazado.js"></script>
<script>
function cambiaFondo(id,it,ch)
{
	
	n="n"+id;
	c="c"+id;
	m="m"+id;
	o="o"+id;
	p="p"+id;
	

	on=document.getElementById(n);
	oc=document.getElementById(c);
	om=document.getElementById(m);
	
	op=document.getElementById(p);
	oo=document.getElementById(o);
	
	if(!ch)
	{
				if(it==0)
					{
						on.style.background="#E7F3F7";
						on.style.color="#0A8FC7";
						
						oc.style.background="#E7F3F7";
						oc.style.color="#0A8FC7";
						
						om.style.background="#E7F3F7";
						om.style.color="#0A8FC7";
						
						
						
						op.style.background="#E7F3F7";
						op.style.color="#0A8FC7";
						oo.style.background="#E7F3F7";
						oo.style.color="#0A8FC7";
						
					}
				else
					{
			
								on.style.background="#C6E2F1";
								on.style.color="#0A8FC7";
								
								oc.style.background="#C6E2F1";
								oc.style.color="#0A8FC7";
								
								om.style.background="#C6E2F1";
								om.style.color="#0A8FC7";
								
								
								
								op.style.background="#C6E2F1";
								op.style.color="#0A8FC7";
								oo.style.background="#C6E2F1";
								oo.style.color="#0A8FC7";
					
					}
		}
		else
		if(ch) 
		{
							if(it==0)
						{
							on.style.background="#E0F8E1";
							on.style.color="#2CD53A";
							
							oc.style.background="#E0F8E1";
							oc.style.color="#2CD53A";
							
							om.style.background="#E0F8E1";
							om.style.color="#2CD53A";
							
							
							
							op.style.background="#E0F8E1";
							op.style.color="#2CD53A";
							oo.style.background="#E0F8E1";
							oo.style.color="#2CD53A";
							
						}
					else
						{

									on.style.background="#B2F0B3";
									on.style.color="#177818";
									
									oc.style.background="#B2F0B3";
									oc.style.color="#177818";
									
									om.style.background="#B2F0B3";
									om.style.color="#177818";
									
									
									
									op.style.background="#B2F0B3";
									op.style.color="#177818";
									oo.style.background="#B2F0B3";
									oo.style.color="#177818";
						
						}
		
		}
		
		//on.style.display="none";

}
</script>
<title>Untitled Document</title>
</head>

<body onkeydown="backspace();">
<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/Logos/Gral/24-tag-manager.png" alt="" width="24" height="24" align="absbottom" />SCA.- Modificaci&oacute;n de Viajes <?php title($tipo)?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="EncabezadoMenu">Usted Tiene Viajes Disponibles a Modificar  en las Siguientes Fechas:</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> </tr>
</table>
<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <?php 
  		$Link=SCA::getConexion();
  		$SQL="SELECT  FechaLlegada as Fecha,COUNT(IdViajeNeto) AS Total FROM viajesnetos
			 WHERE Estatus = ".$tipo." AND IdProyecto = ".$_SESSION['Proyecto']." 
			 and FechaLlegada BETWEEN '".fechasql($fechaini)."' AND '".fechasql($fechafin)."' 
			 GROUP BY FechaLlegada;";
		//echo "<br><br>".$SQL;
		$Result=$Link->consultar($SQL);
		//$Link->cerrar();
		$a=0;
		while($vfechas=mysql_fetch_array($Result))
		{
   ?>
  
  <tr>
    <td width="26" align="left"><img style="cursor:hand;<?php if(($ori[0]!=''||$_REQUEST[flag]!='')&&($ori[0]==$a||$_REQUEST[flag]!=1)) {?> display:none <?php  }?>"  src="../../Imgs/16-square-red-add.gif" id="masfechas<?php echo $a; ?>" onclick="cambiarDisplay('fechas<?php echo $a; ?>');cambiarDisplay('menosfechas<?php echo $a; ?>');cambiarDisplay('masfechas<?php echo $a; ?>')" width="16" height="16" onmouseover="this.src='../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../Imgs/16-square-red-add.gif'"/>
     <img style="cursor:hand;<?php if(($ori[0]==''&&$_REQUEST[flag]=='')||($ori[0]!=$a&&$_REQUEST[flag]==1)) {?> display:none <?php  }?>"  id="menosfechas<?php echo $a; ?>" src="../../Imgs/16-square-red-remove.gif" width="16" height="16" onclick="cambiarDisplay('fechas<?php echo $a; ?>');cambiarDisplay('masfechas<?php echo $a; ?>');cambiarDisplay('menosfechas<?php echo $a; ?>')" onmouseover="this.src='../../Imgs/16-square-blue-remove.gif'" onmouseout="this.src='../../Imgs/16-square-red-remove.gif'" /> </td>
    <td width="25" align="left"><img src="/SCA/Imgs/calendarp.gif" alt="" width="15" height="16" /></td>
    <td colspan="2" align="left">&nbsp;<?php echo fecha($vfechas[Fecha])." ==> ".$vfechas[Total]; ?> Viajes</td>
  </tr>
  <tr>
							  <td>&nbsp;</td>
							  <td>&nbsp;</td>
							  <td width="775">&nbsp;</td>
    <td width="19">&nbsp;</td>
  </tr>
  <tr  id="fechas<?php echo $a; ?>" <?php if(($ori[0]==''&&$_REQUEST[flag]=='')||($ori[0]!=$a&&$_REQUEST[flag]==1)) {?> style="display:none" <?php  }?>>
  <td colspan="3"><?php //echo 'ori: '.$ori[0].' a: '.$a.' f: '.$_REQUEST[flag]; ?>
  <table cellspacing="0" cellpadding="0">
  <?php 
								 $Link=SCA::getConexion();
								$SQL="SELECT  viajesnetos.IdTiro, tiros.Descripcion as Tiro, COUNT(viajesnetos.IdViajeNeto) AS Total FROM viajesnetos, tiros WHERE viajesnetos.Estatus = ".$tipo." AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." AND viajesnetos.IdTiro=tiros.IdTiro AND viajesnetos.FechaLlegada='".$vfechas[Fecha]."' GROUP BY viajesnetos.IdTiro";
								//echo "<br><br>".$SQL;
								$Resultt=$Link->consultar($SQL);
								//$Link->cerrar();
								$b=0;
								while($vtiros=mysql_fetch_array($Resultt))
								{
						 ?>
							<form action="3Edita.php" method="post" name="frm">
 <?php if($b>0){?><tr><td>&nbsp;</td></tr><?php  }?>
 
 							<tr>
                                                  <td width="11">&nbsp;</td>
                                                  <td width="26">  <img onmouseover="this.src='../../Imgs/16-square-blue-remove.gif'" onmouseout="this.src='../../Imgs/16-square-red-remove.gif'"  style="cursor:hand; <?php if(($ori[1]==''&&$_REQUEST[flag]=='')||($ori[1]!=$b||$ori[0]!=$a&&$_REQUEST[flag]==1)) {?>display:none <?php  }?>" id="-f<?php echo $a;  ?>t<?php echo $b;?>" src="../../Imgs/16-square-red-remove.gif" width="16" height="16" onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;?>')" />
        
        <img onmouseover="this.src='../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../Imgs/16-square-red-add.gif'" style="cursor:hand; <?php if(($ori[1]!=''||$_REQUEST[flag]!='')&&($ori[1]==$b&&$ori[0]==$a||$_REQUEST[flag]!=1)) {?>display:none <?php  }?>" id="+f<?php echo $a;  ?>t<?php echo $b;?>" src="../../Imgs/16-square-red-add.gif" width="16" height="16" onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;?>')" /></td>
                              <td width="28"><img src="../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
                                                  <td width="374">&nbsp;<?php echo $vtiros[Tiro]." ==> ".$vtiros[Total]; ?> Viajes</td>
                                                  <td width="375" align="right">&nbsp;</td>
		</tr>
                                                <tr id="f<?php echo $a;  ?>t<?php echo $b;?>"<?php if(($ori[1]==''&&$_REQUEST[flag]=='')||($ori[1]!=$b||$ori[0]!=$a&&$_REQUEST[flag]==1)) {?> style="display:none" <?php  }?>>
                                                  <td colspan="5">
                                                          <table cellpadding="0" cellspacing="0" width="100%">
                                                          <?php 
																	$Link=SCA::getConexion();
																	$SQL="SELECT  viajesnetos.IdCamion, camiones.Economico as Eco, COUNT(viajesnetos.IdViajeNeto) AS Total FROM viajesnetos, camiones WHERE viajesnetos.Estatus = ".$tipo." AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." AND viajesnetos.IdCamion=camiones.IdCamion AND viajesnetos.FechaLlegada='".$vfechas[Fecha]."'  and viajesnetos.IdTiro=".$vtiros[IdTiro]." GROUP BY viajesnetos.IdCamion";
																	//echo "<br><br>".$SQL;
																	$l=0;
																	$Resultc=$Link->consultar($SQL);
																	//$Link->cerrar();
																	$c=0;
																	while($vcamiones=mysql_fetch_array($Resultc))
																	{?>
                                                              <tr>
                                                                <td colspan="5">&nbsp;</td>
                                                              </tr>
                                                              <tr>
                                                                <td width="1%">&nbsp;</td>
                                                                <td width="3%">&nbsp;</td>
                                                                <td width="4%"> <img onmouseover="this.src='../../Imgs/16-square-blue-add.gif'" onmouseout="this.src='../../Imgs/16-square-red-add.gif'" style="cursor:hand" id="+f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>" src="../../Imgs/16-square-red-add.gif" onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>')" width="16" height="16" /><img onmouseover="this.src='../../Imgs/16-square-blue-remove.gif'" onmouseout="this.src='../../Imgs/16-square-red-remove.gif'" id="-f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>" src="../../Imgs/16-square-red-remove.gif" style="display:none;cursor:hand"  onclick="cambiarDisplay('f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('+f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>');cambiarDisplay('-f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>')" width="16" height="16" /></td>
                                                                <td width="3%"><img  src="../../Imgs/16-Bus.gif" width="16" height="16" /></td>
                                                                <td width="89%"><?php echo $vcamiones[Eco]." ==> ".$vcamiones[Total]; ?></td>
                                                            </tr>
                                                              <tr id="f<?php echo $a;  ?>t<?php echo $b;  ?>c<?php echo $c; ?>" style="display:none">
                                                                  <td colspan="5">
                                                                          <table  align="left" >
                                                                          

                                                                          <tr>
                                                                            <td colspan="10">&nbsp;</td>
                                                                            </tr>
                                                                          <tr>
                                                                                    <td width="5">&nbsp;</td>
                                                                                    <td width="5">&nbsp;</td>
                                                                                    <td width="5">&nbsp;</td>
                                                                                    <td width="5">&nbsp;</td>
                                                                                    <td width="5">&nbsp;</td>
                                                                                    <td width="10" class="EncabezadoTabla">No.</td>
                                                                                    <td width="10" class="EncabezadoTabla">Cubic</td>
                                                                                    <td width="20" class="EncabezadoTabla" align="center">Material</td>
                                                                                    <?php  if($tipo!=10){?><td width="20" class="EncabezadoTabla">Origen</td><?php  }?>
                                                                                    <td width="5" class="EncabezadoTabla">&nbsp;</td>
                                                                          </tr>
                                                                          <?php
                                                                          $Link=SCA::getConexion();
																	$SQL="SELECT viajesnetos.IdViajeNeto as IdViaje, camiones.cubicacionParaPago as cubicacion, materiales.Descripcion as material,  viajesnetos.IdOrigen as origen FROM viajesnetos, camiones, tiros, materiales WHERE viajesnetos.Estatus = ".$tipo." AND viajesnetos.IdProyecto = ".$_SESSION['Proyecto']." AND viajesnetos.IdCamion=camiones.IdCamion AND viajesnetos.IdTiro=tiros.IdTiro AND  materiales.IdMaterial=viajesnetos.IdMaterial AND viajesnetos.FechaLlegada='".$vfechas[Fecha]."'  and viajesnetos.IdTiro=".$vtiros[IdTiro]."  AND viajesnetos.IdCamion=".$vcamiones[IdCamion]."";
																	//echo "<br><br>".$SQL;
																	$Resultv=$Link->consultar($SQL);
																	//$Link->cerrar();
																	$d=0;
																	$co=1;
																	while($vviajes=mysql_fetch_array($Resultv))
																	{
																		  
																		  ?>
                                                                                  
                                                                            <tr >
                                                                              <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td>&nbsp;</td>
                                                                                        <td align="center"     id="n<?php echo $vviajes[IdViaje]; ?>" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo $co;?>  </td>
                                                                              <td align="right"  id="c<?php echo $vviajes[IdViaje]; ?>"class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php echo $vviajes[cubicacion]; ?>&nbsp;m<sup>3</sup></td>
                                                                              <td align="center" id="m<?php echo $vviajes[IdViaje]; ?>" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php echo $vviajes[material]; ?></td>
                                                                             <?php  if($tipo!=10){?>  <td align="center" id="o<?php echo $vviajes[IdViaje]; ?>" class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><?php  echo regresa(origenes,Descripcion,IdOrigen,$vviajes[origen]);?></td>
                                                                             <?php  }?>
                                                                              <td align="center"  id="p<?php echo $vviajes[IdViaje]; ?>"class="<?php  $p=$co%2; if($p==0) echo "Item1"; else echo "Item2";?>"><label>
                                                                                <input type="checkbox" onclick="cambiaFondo('<?php echo $vviajes[IdViaje]; ?>','<?php echo $p; ?>',this.checked)" style="cursor:hand" name="viaje<?php echo $l; ?>" id="checkbox"  value="<?php echo $vviajes[IdViaje]; ?>" />
                                                                              </label></td>
                                                                            </tr>
                                                                           <?php $l++; $co++;  $d++;}?>
                                                                          </table>                                                                </td>
                                                              </tr>
                                                                <?php $c++; }?>
                                                                 <tr>
                                                                   <td colspan="9" align="right">&nbsp;</td>
                                                                 </tr>
                                                                 <tr>
                                                           		   <td colspan="9" align="left"><input type="hidden" name="tipo" value="<?php echo $tipo ?>" id="hiddenField" />
                                                                        <input type="hidden" name="ori" value="<?php echo $a;  ?>-<?php echo $b;  ?>" id="hiddenField" />
                                                                 		<input name="total" type="hidden" id="total" value="<?php echo $vtiros[Total] ?>" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name=""  class="boton"type="submit" value="Modificar" /></td>
  																</tr>
                                                          </table>                                                  </td>
                                                </tr>
                                                </form>
  <?php $b++;}?>
  <tr><td>&nbsp;</td></tr>
  </table>  </td>
  </tr>

  
  <?php $a++; }?>
  <tr>
  <tr>
    <td colspan="4" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="left"><label> </label></td>
  </tr>
</table>
<form action="1EligeViajes.php" method="post" name="regresa" id="regresa">
<table width="845" border="0" cellpadding="0" cellspacing="0" align="center" bordercolor="#FFFFFF">
  <tr >
    <td width="560" align="right" class="FondoCasillas">
      
      <input name="button2" type="submit" class="boton" id="button2" value="Regresar" />    </td>
    <td width="285" align="right">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
