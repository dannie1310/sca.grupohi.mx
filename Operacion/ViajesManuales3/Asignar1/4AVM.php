<?php
	session_start();
	
	include("../../../Clases/Conexiones/Conexion.php");
	include("../../../Clases/Funciones/FuncionesViajesManuales.php");
	require "../../../Clases/Mail/class.phpmailer.php";
	
	//Obtenemos el Total de los Viajes a Procesar
		$NumVM=$_POST["NumVM"];
		
		//echo "Total Camiones: ".$NumVM."<br>";
		
	//Obtenemos los Datos de cada uno de los Viajes y los Guardamos en un Arreglo	
		for($a=1;$a<=$NumVM;$a++)
		{
			$NVMS[$a]=$_POST["NVMS".$a];
			$Fechas[$a]=$_POST["Fechas".$a];
			$Origenes[$a]=$_POST["Origenes".$a];
			$Destinos[$a]=$_POST["Destinos".$a];
			$Materiales[$a]=$_POST["Materiales".$a];
			$Economicos[$a]=$_POST["Economicos".$a];
			$Observaciones[$a]=$_POST["Observacion".$a];
		}
		
		//Validamos el Numero de Camiones a Procesar
			//$TotalViajesCargados
			
			for($a=1;$a<=$NumVM;$a++)
			{
				//echo "<br>Tanda ".$a;
				
				for($b=1;$b<=$NVMS[$a];$b++)
				{
					//echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Econ&oacute;mico ".$Economicos[$a];
					
					$Hoy=date("Y-m-d");
					$Hora=date("H:i:s",time());
					$Creo=$_SESSION[Descripcion]."*".$Hoy."*".$Hora;
					
					$link=Conectar(); 
    				
					$insert="INSERT INTO viajesnetos(FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro, FechaLlegada, HoraLlegada, IdMaterial, Observaciones, Creo, Estatus)";
					$values=" VALUES('".$Hoy."', '".$Hora."', ".$_SESSION[Proyecto].", ".$Economicos[$a].", ".$Origenes[$a].", '".$Fechas[$a]."', '00:00:00', ".$Destinos[$a].", '".$Fechas[$a]."', '00:00:00', ".$Materiales[$a].", '".$Observaciones[$a]."', '".$Creo."', 29);";
					$sql=$insert.$values;
					//echo "<br>".$sql;
					$result=mysql_query($sql, $link);
					$TotalViajesCargados=$TotalViajesCargados+mysql_affected_rows($link);
					//echo $TotalViajesCargados;
					mysql_close($link);
				}
			}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>. . : : GLN.- Sistema de Control de Acarreos : : . .</title>
<link href="../../../Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<table width="840" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td bordercolor="#FFFFFF" class="EncabezadoPagina"><img src="../../../Imgs/16-tool-a.gif" alt="" width="16" height="16" /> SCA.- Registro Manual de Viajes</td>
  </tr>
</table>
<table width="544" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    <td width="143" rowspan="5"><img src="../../../Imgs/ProcessOK.gif" width="128" height="128" /></td>
    <td width="401"  >&nbsp;</td>
  </tr>
  <tr>
    <td class="TituloDeAdvertencia">&nbsp;</td>
  </tr>
  <tr>
    <td class="TituloDeAdvertencia">&nbsp;</td>
  </tr>
  <tr>
    <td class="TituloDeAdvertencia">Los Siguientes Viajes Manuales</td>
  </tr>
  <tr>
    <td class="TituloDeAdvertencia">Se Registraron Correctamente ! ! !</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="840" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td colspan="2">&nbsp;</td>
    <td align="center"><img src="../../../Imgs/calendarp.gif" width="19" height="21" /></td>
    <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" /></td>
    <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" /></td>
    <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
    <td align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" /></td>
  </tr>
  <tr>
    <td class="EncabezadoTabla">&nbsp;</td>
    <td class="EncabezadoTabla" >#</td>
    <td class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Econ&oacute;mico</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Destino</td>
    <td  class="EncabezadoTabla">Material</td>
  </tr>
  <?php
  	for($a=1;$a<=$NumVM;$a++)
	{
  ?>
  <tr class="Item1">
    <td>&nbsp;<?php echo $a; ?>&nbsp;</td>
    <td>&nbsp;<?php echo $NVMS[$a]; ?></td>
    <td>&nbsp;<?php echo $FechaEspanol=FechaEnEspanol($Fechas[$a]);?>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Economico, IdCamion, $Economicos[$a], IdProyecto, $_SESSION["Proyecto"], camiones,e); ?>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Descripcion, IdOrigen, $Origenes[$a], IdProyecto, $_SESSION["Proyecto"], origenes,e); ?></td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Descripcion, IdTiro, $Destinos[$a], IdProyecto, $_SESSION["Proyecto"], tiros,e); ?>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Descripcion, IdMaterial, $Materiales[$a], IdProyecto, $_SESSION["Proyecto"], materiales,e); ?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="Item2">Observaciones:</td>
    <td colspan="3" class="Item1"><?php echo $Observaciones[$a]; ?></td>
  </tr>
  <?php
  	}
	$sumador_viajest=0;
	$cuerpod='';
	for($a=1;$a<=$NumVM;$a++)
	{
		$sumador_viajest=$sumador_viajest+$NVMS[$a];
	  $cuerpod=$cuerpod.'
  <tr class="Item1">
    <td bgcolor="#F4F4F4" align="center"  style="font-size:11px;font-family:Calibri">'.$a.'</td>
    <td  bgcolor="#F4F4F4" align="center"  style="font-size:11px;font-family:Calibri">'.$NVMS[$a].'</td>
    <td  bgcolor="#F4F4F4" align="center"  style="font-size:11px;font-family:Calibri">'.$FechaEspanol=FechaEnEspanol($Fechas[$a]).'</td>
    <td  bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.RegresaDescripcionClave2(Economico, IdCamion, $Economicos[$a], IdProyecto, $_SESSION["Proyecto"], camiones,r).'</td>
    <td  bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.RegresaDescripcionClave2(Descripcion, IdOrigen, $Origenes[$a], IdProyecto, $_SESSION["Proyecto"], origenes,r).'</td>
    <td  bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.RegresaDescripcionClave2(Descripcion, IdTiro, $Destinos[$a], IdProyecto, $_SESSION["Proyecto"], tiros,r).'</td>
    <td  bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.RegresaDescripcionClave2(Descripcion, IdMaterial, $Materiales[$a], IdProyecto, $_SESSION["Proyecto"], materiales,r).'</td>
	<td  bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$Observaciones[$a].'</td>
  </tr>
  ';

  	}
	
	
$cuerpo1='
<html> 
<head> 
   <title>Registro de Viajes</title> 
</head> 
<body> 
<table>
<tr>
	<td  align="center" colspan="2"><h3 style="font-family:Calibri">SISTEMA DE CONTROL DE ACARREOS (S.C.A.)</h3></td>
	
</tr>
<tr>
	<td style="font-size:16px;font-family:Calibri" ><strong>Proyecto: </strong>'.$_SESSION['NombreCortoProyecto'].'</td>
</tr>
</table>
<h5  style="font-family:Calibri">Se le notifica que '.$_SESSION['Descripcion'].' ha registrado '.$sumador_viajest.' viajes manuales para autorizar.</h5> 
	<table>
	 <tr>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">&nbsp;</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">No.<br>Viajes</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Fecha</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Econ&oacute;mico</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Origen</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Destino</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Material</td>
	<td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Observaciones</td>
  </tr>
	';
	
$cuerpo2='</table>
<h6  style="font-family:Calibri">Atte. SCA '.$_SESSION['NombreCortoProyecto'].'</h6>
</body> 
</html> 
';
$cuerpo=$cuerpo1.$cuerpod.$cuerpo2;
$asunto = "SCA ".$_SESSION['NombreCortoProyecto'].".-Registro de Viajes Manuales  "."(".date("d-m-Y H:i:s").")"; 
/*$destinatario = "webmaster@grupolanacional.com.mx"; 


//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=utf-8\r\n"; 

//dirección del remitente 
$headers .= "From: WebMaster <webmaster@grupolanacional.com.mx>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: WebMaster <webmaster@grupolanacional.com.mx>\r\n"; 

//ruta del mensaje desde origen a destino 
//$headers .= "Return-path: holahola@desarrolloweb.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc:  WebMaster <webmaster@grupolanacional.com.mx>\r\n"; 

//direcciones que recibirán copia oculta 
$headers .= "Bcc: luis.tenorio@grupolanacional.com.mx, luisten@gln.com.mx, elizabeth.martinez@grupolanacional.com.mx, elimar@gln.com.mx, elizabeth011685@hotmail.com, omar.aguayo@grupolanacional.com.mx, omaragua@gln.com.mx\r\n"; 

//mail($destinatario,$asunto,$cuerpo,$headers);
*/

$mail2 = new PHPMailer();
$mail2->IsSMTP();
$mail2->Host = "mail.grupolanacional.com.mx";
$mail2->SMTPAuth = true;

$mail2->Username = "webmaster@grupolanacional.com.mx";
$mail2->Password = "wm654321";
#####################################################################

$link=Conectar(); 
$select="select * from destinatarios_correo where Estatus=1";
//echo $select;
$r=mysql_query($select,$link);
while($v=mysql_fetch_array($r))
{
	if($v[Tipo]=='FROM')
	{
		$mail2->From = $v[Direccion];
		$mail2->FromName = $v[Nombre];
	}
	if($v[Tipo]=='TO')
	{
		$mail2->AddAddress($v[Direccion]);
	}
	if($v[Tipo]=='CC')
	{
		$mail2->AddCC($v[Direccion]);
	}
	if($v[Tipo]=='BCC')
	{
		$mail2->AddBCC($v[Direccion]);
	}
	
}







$mail2->WordWrap = 50;
$mail2->IsHTML(true);
$mail2->Subject = $asunto;
$mail2->Body = $cuerpo;
//$mail2->AltBody = "Correo de prueba usando mailer";
if(!$mail2->Send())
{
	echo "El mensaje no ha podido ser enviado";
	echo "Error: ".$mail2->ErrorInfo;
	exit;
}
else
{
//echo "El mensaje ha sido enviado correctamente";
	
  ?>
  <tr>
    <td colspan="7" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7" align="center" class="Subtitulo style1">Recuerde que para que usted pueda validar los Viajes que acaba de Registrar, primero deben pasar por el proceso de Autorizaci&oacute;n. </td>
  </tr>
  <?php }?>
</table>

</body>
</html>
