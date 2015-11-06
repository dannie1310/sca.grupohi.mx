<?php 
	session_start();
	include("../../inc/php/conexiones/SCA.php");
	include("../../Clases/Funciones/Catalogos/Genericas.php");

	$IdProyecto=$_SESSION['Proyecto'];
	$fecha=$_REQUEST[fecha];
	$tiro=$_REQUEST[tiro];
	$tipo=$_REQUEST[tipoa];
	$importe=$_REQUEST[importe];
	$numero=$_REQUEST[numero];
	$totalviajes=$_REQUEST[totalviajes];
	$flag=$_REQUEST[flag];
	$origen=$_REQUEST[origen];
	$torigen=$_REQUEST[torigen];
	$material=$_REQUEST[material];
	//echo $origen;
	//echo "n=$numero, imp=$importe, tiro=$tiro,fecha=$fecha,tipo=$tipo";
	$link=SCA::getConexion();
	$sql="Select format(sum(ImportePrimerKM),2) as Importe, sum(ImportePrimerKM) as Importesc,  count(IdViaje) as Viajes from viajes where IdMaterial=".$material." and IdTiro=".$tiro." and IdOrigen=".$origen." and FechaLlegada='".$fecha."'";
	$r=$link->consultar($sql);
	$v=mysql_fetch_array($link->consultar($sql));
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>..::GLN.-Sistema de Control de Acarreos::..</title>
<link href="../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.Estilo1 {color: #0A8FC7;
font-size:1px}
-->
</style>
</head>
<script type="text/javascript" src="../../Clases/Js/NoClick.js"></script>
<script src="../../Clases/Js/Genericas.js"></script>
<script src="../../Clases/Js/Cajas.js"></script>
<script>
function validaxviajes(totalf,viajes)
	{
		 for (i=0;i<document.frm.elements.length;i++) 
		 {
		 	if(document.frm.elements[i].type!="text"&&document.frm.elements[i].value=='A99')
			{
				alert("INDIQUE LOS DATOS PARA EL "+document.frm.elements[i].id);
				document.frm.elements[i].focus();
				return false;
			}
			else
		 	if(document.frm.elements[i].type=="text"&&document.frm.elements[i].name!="suma"&&(document.frm.elements[i].value==''||parseInt(document.frm.elements[i].value)==0))
			{
				alert("INDIQUE EL NUMERO DE VIAJES PARA EL REGISTRO");
				document.frm.elements[i].focus();
				return false;
			}
			
		 }
		 if(viajes>document.frm.suma.value)
			{
				alert("NO HA DISTRIBUIDO EL TOTAL DE VIAJES ENTRE LOS CENTROS DE COSTO");
				return false;
			}
			else
			return true;
	
	}
	
	function validaximportes(totalf,viajes)
	{
		 for (i=0;i<document.frm.elements.length;i++) 
		 {
		 	if(document.frm.elements[i].type!="text"&&document.frm.elements[i].value=='A99')
			{
				alert("INDIQUE LOS DATOS PARA EL "+document.frm.elements[i].id);
				document.frm.elements[i].focus();
				return false;
			}
			else
		 	if(document.frm.elements[i].type=="text"&&document.frm.elements[i].name!="suma"&&(document.frm.elements[i].value==''||parseFloat(document.frm.elements[i].value)==0))
			{
				alert("INDIQUE EL IMPORTE PARA EL REGISTRO");
				document.frm.elements[i].focus();
				return false;
			}
			
		 }
		 if(viajes>quitacomas(document.frm.suma.value))
			{
				alert("NO HA DISTRIBUIDO EL TOTAL DEL IMPORTE ENTRE LOS CENTROS DE COSTO");
				return false;
			}
			else
			return true;
	
	}
	
	function sumarviajes(total)
	{	
		a=0.00;
		 for (i=0;i<document.frm.elements.length;i++) 
		 {
			if(document.frm.elements[i].type=="text"&&document.frm.elements[i].name!="suma"&&document.frm.elements[i].value!='') 
				{   
					a = a + parseFloat(quitacomas(document.frm.elements[i].value));
					if(a>total)
					{
						alert ("HA SOBREPASADO EL NÚMERO DE VIAJES");
						document.frm.elements[i].value='';
						sumarviajes(total);
					}
				}
			
			resultado = parseFloat(a).toFixed(2).toString();
			resultado = resultado.split(".");
			var cadena = ""; cont = 1
			for(m=resultado[0].length-1; m>=0; m--)
				{
					cadena = resultado[0].charAt(m) + cadena
					cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
					cont== 3 ? cont = 1 :cont++
				}
		
			document.frm.suma.value=cadena + " ";
		}

	return false;
}
	
	function sumarimportes(total)
{	a=0.00;
		 for (i=0;i<document.frm.elements.length;i++) 
		 {
			if(document.frm.elements[i].type=="text"&&document.frm.elements[i].name!="suma"&&document.frm.elements[i].value!='') 
				{   
					a = a + parseFloat(quitacomas(document.frm.elements[i].value));
					if(a>total)
					{
						alert ("HA SOBREPASADO EL IMPORTE");
						document.frm.elements[i].value='';
						sumarviajes(total);
					}
				}
			
			resultado = parseFloat(a).toFixed(2).toString();
			resultado = resultado.split(".");
			var cadena = ""; cont = 1
			for(m=resultado[0].length-1; m>=0; m--)
				{
					cadena = resultado[0].charAt(m) + cadena
					cont%3 == 0 && m >0 ? cadena = "," + cadena : cadena = cadena
					cont== 3 ? cont = 1 :cont++
				}
		
			document.frm.suma.value=cadena + "." + resultado[1]+" ";
		}

	return false;
}
	

</script>
<body>

<table width="840" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td class="EncabezadoPagina"><img src="../../Imgs/16-Signo-Peso.gif" width="16" height="16" /> SCA.- Asignaci&oacute;n de Costos</td>
  </tr>
   <tr>
    <td  /> &nbsp;</td>
  </tr>
</table>
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

<table width="500" border="0" align="center">
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
    <td width="231" class="EncabezadoTabla">CENTRO DE COSTO</td>
    <td width="195" class="EncabezadoTabla">ETAPA DE PROYECTO</td>
    <td width="160" class="EncabezadoTabla">NO. VIAJES </td>
  </tr>
 
  <?PHP

   $pr=1;
   $i=0;
   while($i<$numero) {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td align="center">
	<select id="<?php echo "CENTRO DE COSTO"; ?>" name="<?php echo "centroscosto".$i; ?>">
		 <option value="A99">- SELECCIONE -</option>
			  <?PHP
			  $ls=SCA::getConexion();
			  $sql="SELECT IdCentroCosto,  length(Nivel) as niv,concat(repeat('&nbsp;&nbsp;&nbsp;',(length(Nivel)/4)),'=> ',Descripcion)as Descripcion FROM centroscosto WHERE IdProyecto= ".$IdProyecto." ORDER BY Nivel;";
			  //echo $sql;
			  $result=$ls->consultar($sql);
			 // $ls->cerrar();
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			   <option  <?php if($flag==1){if($row[IdCentroCosto]==$_REQUEST[centroscosto."$i"]) echo "selected";} ?>   value="<?php if($row[niv]!=4)echo $row[IdCentroCosto]; else echo "A99"; ?>"><?php echo $row[Descripcion]; ?></option>
			   <?php
			   }
			   ?>
		  </select>

	
	</td>
    <td align="center"><?php comboConsecutivo(etapasproyectos,Descripcion,IdEtapaProyecto,$i,"ETAPA PROYECTO",$_REQUEST[etapasproyectos."$i"]); ?></td>
    <td align="center"><input <?php if($numero==1) echo "readonly='true' value='$totalviajes'"; ?> name="numero<?php echo $i; ?>" onKeyUp="sumarviajes(<?php echo $totalviajes; ?>)" type="text" class="text" onKeyPress="onlyDigitsPunto(event,'decOK')" style="text-align:right "  size="10" maxlength="10" value="<?php if($flag==1)echo $_REQUEST[numero."$i"]; ?>" ></td>
  </tr>
  <?PHP $i++; $pr++; }?>
   <tr bgcolor="#0A8FC7" >
     <td colspan="3" align="center" class="Estilo1"><span >- GLN - </span></td>
    </tr>
   <tr >
     <td align="center" class="textoG"><input type="hidden" value="<?php echo $origen; ?>" name="origen" id="hiddenField2">
      <input type="hidden" value="<?php echo $torigen; ?>" name="torigen" id="hiddenField">
	   <input type="hidden" value="<?php echo $material; ?>" name="material" id="hiddenField">
	  </td>
     <td align="center" class="textoG"></td>
     <td align="center" class="textoG"><input name="suma" <?php if($numero==1) echo "value='$totalviajes'"; ?> type="text" readonly="true" class="text" style="border:none;text-align:right " size="10" maxlength="10" value="<?php if($flag==1)echo $_REQUEST[suma]; ?>"></td>
   </tr>
   <tr >
     <td colspan="3" align="center">&nbsp;</td>
   </tr>
   </form>
   <tr >
   
    <td align="right">&nbsp;     
	 </td>
   
	  <form name="regresa" action="1MuestraTiros.php" method="post">
      <input type="hidden" value="<?php echo $origen; ?>" name="origen" id="hiddenField2">
	  <input name="tiro" type="hidden" value="<?php echo $tiro; ?>">
	  <input name="fecha" type="hidden" value="<?php echo $fecha; ?>">
	   	  <input name="tipo" type="hidden" value="<?php echo $tipo; ?>">
      <input name="numero" type="hidden" value="<?php echo $numero; ?>">


    <td align="right"><input name="Submit" type="submit" class="boton" value="Regresar"></td>
	  </form>
    <td align="right"><input name="Submit" type="button" class="boton" value="Registrar" onClick="if(validaxviajes(<?php echo $numero; ?>,<?php echo $totalviajes; ?>))document.frm.submit()"></td>
   </tr>
</table>

<?php } else if($tipo==2){ ?>
<table width="500" border="0" align="center">
<form action="4Valida.php" method="post" name="frm">
<input type="hidden" value="<?php echo $origen; ?>" name="origen" id="hiddenField2">
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
    <td width="192" class="EncabezadoTabla">CENTRO DE COSTO</td>
    <td width="164" class="EncabezadoTabla">ETAPA DE PROYECTO</td>
    <td width="130" class="EncabezadoTabla">IMPORTE</td>
  </tr>
 
  <?PHP
   $pr=1;
   $i=0;
   while($i<$numero) {?>
  <tr class="<?php $a=$pr%2; if($a==0){ ?> Item2 <?php } else {?> Item1 <?php } ?>">
    <td align="center"><select id="<?php echo "CENTRO DE COSTO"; ?>" name="<?php echo "centroscosto".$i; ?>">
      <option value="A99">- SELECCIONE -</option>
      <?PHP
			  $ls=SCA::getConexion();
			  $sql="select * from centroscosto where IdProyecto=".$IdProyecto." and Estatus=1 order by Nivel asc";
			 // echo $sql;
			  $result=$ls->consultar($sql);
			 // $ls->cerrar();
			  $x=0;
			  while($row=mysql_fetch_array($result))
			  {
			   ?>
			 
      <option <?php if($flag==1){if($row[IdCentroCosto]==$_REQUEST[centroscosto."$i"]) echo "selected";} ?>   value="<?php echo $row[IdCentroCosto]; ?>"><?php echo $row[Descripcion]; ?></option>
      <?php
			   $x++;}
			   ?>
    </select></td>
    <td align="center"><?php comboConsecutivo(etapasproyectos,Descripcion,IdEtapaProyecto,$i,"ETAPA PROYECTO",$_REQUEST[etapasproyectos."$i"]); ?></td>
    <td align="center"><input <?php if($numero==1) echo "readonly='true' value='".number_format($importe,2,".",",")."'"; ?> name="numero<?php echo $i; ?>" onKeyUp="this.value=formateando(this.value);sumarimportes(<?php echo $importe; ?>)" type="text" class="text" onKeyPress="onlyDigits(event,'decOK')" style="text-align:right "  size="10" maxlength="10" value="<?php if($flag==1)echo $_REQUEST[numero."$i"]; ?>" ></td>
  </tr>
  <?PHP $i++; $pr++; }?>
   <tr bgcolor="#0A8FC7" >
     <td colspan="3" align="center" class="Estilo1"><span >- GLN - </span></td>
    </tr>
   <tr >
     <td align="center" class="textoG"><input type="hidden" value="<?php echo $origen; ?>" name="origen" id="hiddenField">
      <input type="hidden" value="<?php echo $torigen; ?>" name="torigen" id="hiddenField">
	   <input type="hidden" value="<?php echo $material; ?>" name="material" id="hiddenField">
	  </td>
     <td align="center" class="textoG"></td>
     <td align="center" class="textoG"><input name="suma" type="text" <?php if($numero==1) echo "value='".number_format($importe,2,".",",")."'"; ?> readonly="true" class="text" style="border:none;text-align:right " size="10" maxlength="10" value="<?php if($flag==1)echo $_REQUEST[suma]; ?>"></td>
   </tr>
   <tr >
     <td colspan="3" align="center">&nbsp;</td>
   </tr>
   </form>
   <tr >
   
    <td align="right">&nbsp;	 </td>
   
	  <form name="regresa" action="2SolicitaTipo.php" method="post">
	  <input name="tiro" type="hidden" value="<?php echo $tiro; ?>">
	  <input name="fecha" type="hidden" value="<?php echo $fecha; ?>">
 	  <input name="tipo" type="hidden" value="<?php echo $tipo; ?>">
      <input name="numero" type="hidden" value="<?php echo $numero; ?>">
	 

    <td align="right"><input name="Submit" type="submit" class="boton" value="Regresar"></td>
	  </form>
    <td align="right"><input name="Submit" type="button" class="boton" value="Registrar" onClick="if(validaximportes(<?php echo $numero; ?>,<?php echo $importe; ?>))document.frm.submit()"></td>
   </tr>
</table>


<?php }?>
</body>
</html>
