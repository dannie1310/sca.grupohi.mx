<?php 
	session_start();
	include("../../../Clases/Conexiones/Conexion.php");
	include("../../../Clases/Funciones/Catalogos/Genericas.php");
	include("../../../Clases/Funciones/FuncionesValidaViajes.php");
	require "../../../Clases/Mail/class.phpmailer.php";

$aprobados=$_REQUEST[caprobados];
$rechazados=$_REQUEST[crechazados];

 $sumador_viajes_r=sizeof(explode(",",$rechazados));
 $sumador_viajes_a=sizeof(explode(",",$aprobados));

			
		$linkde=conectar();
		$update_aprobados="update viajesnetos set Estatus=20 where IdViajeNeto in(".$aprobados.");";
		//echo $update_aprobados;
		$q=mysql_query($update_aprobados,$linkde);
		$modif_aprobados=mysql_affected_rows($linkde);
		
		$sde="select vn.FechaLlegada as Fecha, c.Economico as Camion, t.descripcion as Destino, vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m, camiones as c, tiros as t where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.IdViajeNeto in(".$aprobados.") and c.IdCamion=vn.IdCamion and t.IdTiro=vn.IdTiro;";
		
		$sde="select count(vn.IdViajeNeto) as nv, vn.FechaLlegada as Fecha, c.Economico as Camion, t.descripcion as Destino, vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m, camiones as c, tiros as t where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.IdViajeNeto in(".$aprobados.") and c.IdCamion=vn.IdCamion and t.IdTiro=vn.IdTiro and vn.Estatus=20 group by Fecha,Camion,Destino,Origen,Material;";

		
		//echo $sde;
		$rde=mysql_query($sde,$linkde);
		$no_viajes=mysql_affected_rows($linkde);
		mysql_close($linkde);
		
		$linkder=conectar();
		$update_rechazados="update viajesnetos set Estatus=22 where IdViajeNeto in(".$rechazados.");";
		$q=mysql_query($update_rechazados,$linkder);
		$modif_rechazados=mysql_affected_rows($linkder);
		$sder="select vn.FechaLlegada as Fecha, c.Economico as Camion, t.descripcion as Destino, vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m, camiones as c, tiros as t  where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.IdViajeNeto in(".$rechazados.") and c.IdCamion=vn.IdCamion and t.IdTiro=vn.IdTiro;";

$sder="select count(vn.IdViajeNeto) as nv, vn.FechaLlegada as Fecha, c.Economico as Camion, t.descripcion as Destino, vn.IdViajeNeto as Id, o.Descripcion as Origen, m.descripcion as Material, vn.IdTiro, vn.IdOrigen from viajesnetos as vn, origenes as o, materiales as m, camiones as c, tiros as t  where vn.IdOrigen=o.IdOrigen and vn.Idmaterial=m.Idmaterial and vn.IdViajeNeto in(".$rechazados.") and c.IdCamion=vn.IdCamion and t.IdTiro=vn.IdTiro and vn.Estatus=22 group by Fecha,Camion,Destino,Origen,Material;";

		//echo $sder;
		$rder=mysql_query($sder,$linkder);
		$no_viajesr=mysql_affected_rows($linkder);
		mysql_close($linkder);
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
    <td colspan="6" align="center" class="Subtitulo">LOS SIGUIENTES VIAJES HAN SIDO <span class="style2">APROBADOS</span></td>
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
        <td colspan="2" align="center">&nbsp;</td>
        <td align="center"><img src="../../../Imgs/calendarp.gif" width="15" height="16" /></td>
        <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16"></td>
        <td width="53" align="center"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16"></td>
        </tr>
      <tr>
        <td width="19" class="EncabezadoTabla">&nbsp;</td>
        <td width="20" class="EncabezadoTabla">#</td>
        <td width="60" class="EncabezadoTabla">Fecha</td>
        <td width="70" class="EncabezadoTabla">Cami&oacute;n</td>
        <td width="89" class="EncabezadoTabla">Origen</td>
        <td width="121" class="EncabezadoTabla">Destino</td>
        <td width="136" class="EncabezadoTabla">Material</td>
        <td class="EncabezadoTabla">Ruta</td>
        </tr>
      <?php $i=1; 	$contador=0;  
	  $contenido_aprobados='';
 while($vde=mysql_fetch_array($rde)){
				  if(RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro])!='')
				  $ruta=RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro]);
				  else
				  $ruta='N/R';?>
      <tr>
        <td class="Item1"><?php echo $i; ?>&nbsp;</td>
        <td class="Item1"><?php echo $vde[nv]; ?></td>
        <td class="Item1"><?php echo fecha($vde[Fecha]); ?></td>
        <td class="Item1"><?php echo $vde[Camion]; ?></td>
        <td class="Item1"><?php echo $vde[Origen]; ?>&nbsp;</td>
        <td class="Item1"><?php echo $vde[Destino]; ?></td>
        <td class="Item1"><?php echo $vde[Material]; ?></td>
        <td class="Item1"><?php echo $ruta; ?>&nbsp;</td>
        </tr>
        
        
      <?php
	  $contenido_aprobados=$contenido_aprobados.' <tr>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$i.'</td>
		<td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[nv].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.fecha($vde[Fecha]).'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Camion].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Origen].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Destino].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Material].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$ruta.'</td>
        </tr>';
	  
	   $i++; $contador++;}?>
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
    <td colspan="6" align="center" class="Subtitulo">LOS SIGUIENTES VIAJES HAN SIDO <span class="style1">RECHAZADOS</span></td>
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
        <td colspan="2" align="center">&nbsp;</td>
        <td align="center"><img src="../../../Imgs/calendarp.gif" width="15" height="16" /></td>
        <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16"></td>
        <td align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16"></td>
        <td width="53" align="center"><img src="../../../Imgs/16-Ruta.gif" width="16" height="16"></td>
        </tr>
      <tr>
        <td width="19" class="EncabezadoTabla">&nbsp;</td>
        <td width="20" class="EncabezadoTabla">#</td>
        <td width="60" class="EncabezadoTabla">Fecha</td>
        <td width="70" class="EncabezadoTabla">Cami&oacute;n</td>
        <td width="89" class="EncabezadoTabla">Origen</td>
        <td width="121" class="EncabezadoTabla">Destino</td>
        <td width="136" class="EncabezadoTabla">Material</td>
        <td class="EncabezadoTabla">Ruta</td>
      </tr>
      <?php $i=1; 	$contador=0; $contenido_rechazados='';  
 while($vde=mysql_fetch_array($rder)){
				  if(RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro])!='')
				  $ruta=RegresaRutaViaje($_SESSION['Proyecto'],$vde[IdOrigen],$vde[IdTiro]);
				  else
				  $ruta='N/R';?>
      <tr>
        <td class="Item1"><?php echo $i; ?>&nbsp;</td>
        <td class="Item1"><?php echo $vde[nv]; ?></td>
        <td class="Item1"><?php echo fecha($vde[Fecha]); ?></td>
        <td class="Item1"><?php echo $vde[Camion]; ?></td>
        <td class="Item1"><?php echo $vde[Origen]; ?>&nbsp;</td>
        <td class="Item1"><?php echo $vde[Destino]; ?></td>
        <td class="Item1"><?php echo $vde[Material]; ?></td>
        <td class="Item1"><?php echo $ruta; ?>&nbsp;</td>
      </tr>
      <?php 
	  	  $contenido_rechazados=$contenido_rechazados.' <tr>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$i.'</td>
		<td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[nv].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.fecha($vde[Fecha]).'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Camion].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Origen].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Destino].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$vde[Material].'</td>
        <td bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.$ruta.'</td>
        </tr>';
	  
	 $i++; $contador++;}?>
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
  
 if($sumador_viajes_a>1){ $texto_aprobados="de ".$sumador_viajes_a." viajes manuales";} else{$texto_aprobados="del siguiente viaje manual";}
 if($sumador_viajes_r>1){ $texto_rechazados="de ".$sumador_viajes_r." viajes manuales";} else{$texto_rechazados="del siguiente viaje manual";}

  
$encabezado_general='
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
';
$encabezado_aprobados=' 

<h5 style="font-family:Calibri">Se le notifica que '.$_SESSION['Descripcion'].' ha <i>aprobado</i> el registro '.$texto_aprobados.'.</h5> 
	<table>
	 <tr>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri">&nbsp;</td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>No.<br>Viajes</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Fecha</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Econ&oacute;mico</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Origen</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Destino</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Material</strong></td>
	<td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Ruta</strong></td>
  </tr>
	'; 
	$cierre_aprobados="</table>";
	
	$encabezado_rechazados=' 

<h5 style="font-family:Calibri">Se le notifica que '.$_SESSION['Descripcion'].' ha <i>rechazado</i> el registro '.$texto_rechazados.'.</h5> 
	<table>
	<tr>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri">&nbsp;</td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>No.<br>Viajes</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Fecha</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Econ&oacute;mico</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Origen</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Destino</strong></td>
    <td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Material</strong></td>
	<td bgcolor="#DADADA" align="center"  style="font-size:11px;font-family:Calibri"><strong>Ruta</strong></td>
  </tr>
	';  
	
	$cierre_rechazados="</table>";
  
  
 $cierre_general='
<h6 style="font-family:Calibri">Atte. SCA '.$_SESSION['NombreCortoProyecto'].'</h6>
</body> 
</html> 
';
 if($aprobados!='')
 $contenido=$encabezado_aprobados.$contenido_aprobados.$cierre_aprobados;
 if($rechazados!='')
 $contenido=$contenido.$encabezado_rechazados.$contenido_rechazados.$cierre_rechazados;
 
 $cuerpo=$encabezado_general.$contenido.$cierre_general;
  $asunto = "SCA ".$_SESSION['NombreCortoProyecto'].".-".utf8_decode(Autorización) ." y Rechazo del Registro de Viajes Manuales  "."(".date("d-m-Y H:i:s").")"; 
/*$destinatario = "webmaster@grupolanacional.com.mx"; 

//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=utf-8\r\n"; 
//direcci&oacute;n del remitente 
$headers .= "From: WebMaster <webmaster@grupolanacional.com.mx>\r\n"; 
//direcci&oacute;n de respuesta, si queremos que sea distinta que la del remitente 
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
	//echo "El mensaje no ha podido ser enviado";
	//echo "Error: ".$mail2->ErrorInfo;
	exit;
}
//echo "El mensaje ha sido enviado correctamente";
  ?>
  <tr>
    <td><label></label></td>
    <td colspan="4">&nbsp;</td>
    <td>
    <form name="frm" method="post" action="1MuestraDatos.php">
   
    <input name="button" type="submit" class="boton" id="button" value="Revisar Otros Viajes">
    </form>
    </td>
  </tr>
</table>
</body>
</html>
