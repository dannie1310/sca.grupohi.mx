<?php 
	session_start();
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Catalogos/Genericas.php");

	$IdProyecto=$_SESSION['Proyecto'];
	$Descripcion=$_SESSION['Descripcion'];
	$fecha=$_REQUEST[fecha];
	$tiro=$_REQUEST[tiro];
	$tipo=$_REQUEST[tipo];
	$importe=$_REQUEST[importe];
	$numero=$_REQUEST[numero];
	$totalviajes=$_REQUEST[totalviajes];
	$suma=$_REQUEST[suma];
	$origen=$_REQUEST[origen];
	$torigen=$_REQUEST[torigen];
	$material=$_REQUEST[material];
	//echo "n=$numero, imp=$importe, tiro=$tiro,fecha=$fecha,tipo=$tipo";
	$link=SCA::getConexion();
	$sql="
	Select 
		format(sum(Importe),2) as Importe, 
		sum(Importe) as Importesc,  
		count(IdViaje) as Viajes,
		sum(VolumenPrimerKM) as VolumenPrimerKM,
		sum(VolumenKMSubsecuentes) as VolumenKMSub,
		sum(VolumenKMAdicionales) as VolumenKMAdc,
		sum(Volumen) as Volumen,
		sum(ImportePrimerKM) as ImportePrimerKM,
		sum(ImporteKMSubsecuentes) as ImporteKMSub,
		sum(ImporteKMAdicionales) as ImporteKMAdc,
		if(FactorAbundamiento!=0.00,sum(VolumenPrimerKM/FactorAbundamiento),0.00) as VolumenPrimerKM_Ab,
		if(FactorAbundamiento!=0.00,sum(VolumenKMSubsecuentes/FactorAbundamiento),0.00) as VolumenKMSub_Ab,
		if(FactorAbundamiento!=0.00,sum(VolumenKMAdicionales/FactorAbundamiento),0.00) as VolumenKMAdc_Ab,
		if(FactorAbundamiento!=0.00,sum(Volumen/FactorAbundamiento),0.00)  as Volumen_Ab
		 
	from 
		viajes 
	where 
	IdMaterial=".$material." and IdTiro=".$tiro." and IdOrigen=".$origen." and FechaLlegada='".$fecha."'  and Estatus in(0,10,20)
		";
		//echo $sql;
		
	$r=$link->consultar($sql);
	$v=mysql_fetch_array($link->consultar($sql));
	#########EN ESTA PARTE SE INSERTAN LOS DATOS DEL CENTRO DE COSTO
	$sqla="Lock Tables viajes,costos,partidascosto Write;";
	$link->consultar($sqla);
	$fechains=date("Y-m-d");
	$hora=date("H:i:s");
	for($i=0;$i<$numero;$i++)
		{
			$centro[1][$i]=$_REQUEST[centroscosto.$i];
			$centro[2][$i]=$_REQUEST[etapasproyectos.$i];
			//echo $centro[1][$i];
			//echo $centro[2][$i];

			
			$inserta="insert into costos(IdDestino,FechaViaje,IdTipoOrigen,IdProyecto,IdCentroCosto,IdEtapaProyecto,TotalViajes,VolumenPrimerKM,VolumenKMSub,VolumenKMAdc,VolumenTotal,ImportePrimerKM,ImporteKMSub,ImporteKMAdc,ImporteTotal,FechaAsigno,HoraAsigno,Creo,VolumenPrimerKM_Ab,VolumenKMSub_Ab,VolumenKMAdc_Ab,VolumenTotal_Ab)
			                       values(".$tiro.",'".$fecha."',".$torigen.",".$IdProyecto.",".$centro[1][$i].",".$centro[2][$i].",".$v[Viajes].",".$v[VolumenPrimerKM].",".$v[VolumenKMSub].",".$v[VolumenKMAdc].",".$v[Volumen].",".$v[ImportePrimerKM].",".$v[ImporteKMSub].",".$v[ImporteKMAdc].",".$v[Importesc].",'".$fechains."','".$hora."','".$Descripcion."',".$v[VolumenPrimerKM_Ab].",".$v[VolumenKMSub_Ab].",".$v[VolumenKMAdc_Ab].",".$v[Volumen_Ab].")";
		//echo $inserta;
			$link->consultar($inserta);
			$exito=$link->affected();
if($exito>0)
{
######## APARTADO PARA ACTUALIZAR LOS VIAJES E INSERTAR LAS PARTIDAS DE LOS COSTOS########

#SE OBTIENE EL IDCOSTO DEL COSTO QUE SE ACABA DE INSERTAR

/*$cost="select IdCosto from costos where IdCentroCosto=".$centro[1][$i]." and IdEtapaProyecto=".$centro[2][$i]." and IdDestino=".$tiro." and FechaViaje='".$fecha."' and IdProyecto=".$IdProyecto." and FechaAsigno='".$fechains."' and Creo='".$Descripcion."' order by IdCosto desc limit 1";
//echo $cost;
$quer=$link->consultar($cost);
$rcos=mysql_fetch_array($quer);
$idcosto=$rcos[IdCosto];*/
$idcosto=$link->retId();
#SE ACTUALIZA EL ESTATUS DE LOS VIAJES Y SE INSERTA LA PARTIDA
$sqlviajes="
	Select 
		IdViaje as Viaje,
		Estatus as Estatus		 
	from 
		viajes 
	where 
		IdMaterial=".$material." and IdTiro=".$tiro." and IdOrigen=".$origen." and FechaLlegada='".$fecha."'  and Estatus in(0,10,20)";
		
		
$rviajes=$link->consultar($sqlviajes);
//echo $sqlviajes;
$j=0;
while($vviajes=mysql_fetch_array($rviajes))
{
	//echo 'viajes: '.$vviajes[Viaje].'<br>';
	//echo 'estatus: '.$vviajes[Estatus].'<br>';
	switch($vviajes[Estatus])
	{
		case 0: $estatus=1;
		break;
		case 10: $estatus=11;
		break;
		case 20: $estatus=21;
		break;
		
	
	}
	//echo '$es '.$estatus;
	$j++;
	$sqlv="Update viajes set Estatus=".$estatus." where IdViaje=".$vviajes[Viaje].";";
	$link->consultar($sqlv);
	$inspartida="Insert into partidascostos(IdCosto, IdViaje, IdProyecto) values(".$idcosto.",".$vviajes[Viaje].",".$IdProyecto.")";
	$link->consultar($inspartida);
	//echo $sqlv;
	
}

		
		}

	
	//$link->consultar($inserta);

#####
}
			
	$sqlc="Unlock tables;";
$link->consultar($sqlc);
//$link->cerrar();
		
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
<?php if($_SESSION[IdUsuario!=2]) {?>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<?php }?>
<style type="text/css">
<!--
.Estilo1 {color: #0A8FC7;
font-size:1px}
-->
</style>
</head>
<script language="javascript" src="../../Clases/Js/Genericas.js"></script>
<body onkeydown="backspace();">

<table width="840" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" /> SCA.- Asignaci&oacute;n de Costos</td>
  </tr>
   <tr>
    <td  /> &nbsp;</td>
  </tr>
</table>
<?php if($exito>0) {?>
<table width="500" border="0" align="center" >
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td width="71" class="EncabezadoTabla">FECHA</td>
    <td width="264" class="EncabezadoTabla">TIRO</td>
    <td width="82" class="EncabezadoTabla">NO. VIAJES </td>
    <td width="65" class="EncabezadoTabla">IMPORTE</td>
  </tr>
  <tr class="Item1">
    <td><?php echo fecha($fecha); ?></td>
    <td><?php echo regresa(tiros,Descripcion,IdTiro,$tiro); ?></td>
    <td align="right"><?php echo $v[Viajes]; ?></td>
    <td align="right">$ <?php echo $v[Importe]; ?></td>
  </tr>
</table>

<?php if($tipo==1){ ?>

<table width="600" border="0" align="center">
<form action="4Valida.php" method="post" name="frm">
 <input type="hidden" value="<?php echo $totalviajes; ?>" name="totalviajes">
 <input type="hidden" value="<?php echo $importe; ?>" name="importe">
 <input type="hidden" value="<?php echo $tiro; ?>" name="tiro">
 <input type="hidden" value="<?php echo $fecha; ?>" name="fecha">
 <input type="hidden" value="<?php echo $tipo; ?>" name="tipo">
 <input type="hidden" value="<?php echo $numero; ?>" name="numero">
  <tr >
    <td colspan="3" class="Subtitulo">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="3" class="Subtitulo">LOS COSTOS HAN SIDO APLICADOS</td>
    </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr >
    <td  class="EncabezadoTabla">CENTRO DE COSTO</td>
    <td  class="EncabezadoTabla">ETAPA DE PROYECTO</td>
    <td  class="EncabezadoTabla">NO. VIAJES </td>
  </tr>
 
  <?PHP
   $pr=1;
   $i=0;
   while($i<$numero) {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td align="center"><?php echo regresa(centroscosto,Descripcion,IdCentroCosto,$_REQUEST[centroscosto."$i"]); ?>

	
	</td>
    <td align="center"><?php  echo regresa(etapasproyectos,Descripcion,IdEtapaProyecto,$_REQUEST[etapasproyectos."$i"]); ?></td>
    <td align="center"><?php echo $_REQUEST[numero."$i"]; ?></td>
  </tr>
  <?PHP $i++; $pr++; }?>
   <tr bgcolor="#0A8FC7" >
     <td colspan="3" align="center" class="Estilo1"><span >- GLN - </span></td>
    </tr>
   <tr >
     <td align="center" class="textoG">&nbsp;</td>
     <td align="center" class="textoG"></td>
     <td align="center" class="textoG"><?php echo $suma; ?></td>
   </tr>
   <tr >
     <td colspan="3" align="center">&nbsp;</td>
   </tr>
  </form>
   <tr >
   
    <td align="right">&nbsp;     
	 </td>

    <td align="right">&nbsp;</td>
	
	  <form name="frm" action="1MuestraTiros.php" method="post">
	  
    <td align="right"><input name="Submit" type="submit" class="boton" value="Aplicar Otros Costos" ></td>
	</form>
   </tr>
</table>

<?php } else if($tipo==2){ ?>
<table width="600" border="0" align="center">
<form action="4Valida.php" method="post" name="frm">
 <input type="hidden" value="<?php echo $totalviajes; ?>" name="totalviajes">
 <input type="hidden" value="<?php echo $importe; ?>" name="importe">
 <input type="hidden" value="<?php echo $tiro; ?>" name="tiro">
 <input type="hidden" value="<?php echo $fecha; ?>" name="fecha">
 <input type="hidden" value="<?php echo $tipo; ?>" name="tipo">
 <input type="hidden" value="<?php echo $numero; ?>" name="numero">
  <tr >
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr >
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr >
    <td  class="EncabezadoTabla">CENTRO DE COSTO</td>
    <td  class="EncabezadoTabla">ETAPA DE PROYECTO</td>
    <td  class="EncabezadoTabla">IMPORTE</td>
  </tr>
 
  <?PHP
   $pr=1;
   $i=0;
   while($i<$numero) {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td align="center"><?php echo regresa(centroscosto,Descripcion,IdCentroCosto,$_REQUEST[centroscosto."$i"]); ?></td>
    <td align="center"><?php  echo regresa(etapasproyectos,Descripcion,IdEtapaProyecto,$_REQUEST[etapasproyectos."$i"]); ?></td>
    <td align="right">$ <?php echo $_REQUEST[numero."$i"]; ?></td>
  </tr>
  <?PHP $i++; $pr++; }?>
   <tr bgcolor="#0A8FC7" >
     <td colspan="3" align="center" class="Estilo1"><span >- GLN - </span></td>
    </tr>
   <tr >
     <td align="center" class="textoG">&nbsp;</td>
     <td align="center" class="textoG"></td>
     <td align="right" class="textoG">$ <?php echo $suma; ?></td>
   </tr>
   <tr >
     <td colspan="3" align="center">&nbsp;</td>
   </tr>
  </form>
   <tr >
   
    <td align="right">&nbsp;     
	 </td>
 

    <td align="right">&nbsp;</td>
	
	   <form name="frm" action="1MuestraTiros.php" method="post">
    <td align="right"><input name="Submit" type="submit" class="boton" value="Aplicar Otros Costos" ></td>
	</form>
   </tr>
</table>


<?php }?>


<?php } else {?>


<table width="500" border="0" align="center" >
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr >
    <td class="Subtitulo">LA APLICACI&Oacute;N DE COSTO NO PUDO SER REALIZADA </td>
  </tr>
</table>
<?php }?>
</body>
</html>
