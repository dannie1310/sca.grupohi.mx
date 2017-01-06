<?php
	session_start();
	
	include("../../../inc/php/conexiones/SCA.php");
	include("../../../Clases/Funciones/FuncionesViajesManuales.php");
	require "../../../Clases/Mail/class.phpmailer.php";
	
	function resta_minutos($FechaOrigen, $HoraOrigen, $MinASumar){
		
		$FechaOrigen = explode("-",$FechaOrigen);
		$Dia = $FechaOrigen[2];
		$Mes = $FechaOrigen[1];
		$Ano = $FechaOrigen[0];
		
		$HoraOrigen = explode(":",$HoraOrigen);
		$Horas = $HoraOrigen[0];
		$Minutos = $HoraOrigen[1];
		$Segundos = "00";
		
		// Sumo los minutos
		$Minutos = ((int)$Minutos) - ((int)$MinASumar);
		
		// Asigno la fecha modificada a una nueva variable
		$Hora = date("Y-m-d H:i:s",mktime($Horas,$Minutos,$Segundos,$Mes,$Dia,$Ano));
		
		return $Hora;
	}


	//Obtenemos el Total de los Viajes a Procesar
		$NumVM=$_POST["NumVM"];
		//echo $NumVM;
		//echo "Total Camiones: ".$NumVM."<br>";
		$link=SCA::getConexion(); 
	//Obtenemos los Datos de cada uno de los Viajes y los Guardamos en un Arreglo	
		for($a=1;$a<=$NumVM;$a++)
		{
			//echo $NVMS[$a]=$_POST["NVMS".$a];
			$Fechas[$a]=$_POST["Fechas".$a];
			$Horas[$a]=$_POST["Horas".$a];
			$Origenes[$a]=$_POST["Origenes".$a];
			$Destinos[$a]=$_POST["Destinos".$a];
			$Materiales[$a]=$_POST["Materiales".$a];
			$Economicos[$a]=$_POST["Economicos".$a];
			$Observaciones[$a]=$_POST["Observacion".$a];
			//$Horav[$a]=($_POST["Turno".$a]=='M')?"08:00:00":"20:00:00";
			$Horav[$a]="00:00:00";
			$sql_tiempo = "select r.IdRuta,c.TiempoMinimo from rutas r left join cronometrias c ON r.IdRuta = c.IdRuta
				where r.IdOrigen=".$Origenes[$a]." and IdTiro=".$Destinos[$a]."";
			$result_tiempo = mysql_query($sql_tiempo);
			$row_tiempo = mysql_fetch_array($result_tiempo);
			$tiempo_minimo = $row_tiempo["TiempoMinimo"];
			$hora_dif = explode(" ",resta_minutos($Fechas[$a],$Horas[$a],$tiempo_minimo));
			$FechaV[$a]=$hora_dif[0];
			$HoraV[$a]=$hora_dif[1];

			$query_camiones = '
							SELECT IdSindicato, IdEmpresa 
							FROM camiones
							WHERE IdCamion=' .$_POST["Economicos".$a];
			$sql_camiones = mysql_query($query_camiones);
			$camiones = mysql_fetch_array($sql_camiones);
			$sindicato[$a] = $camiones['IdSindicato'];
			$empresa[$a] = $camiones['IdEmpresa'];
			if (empty($empresa[$a])){
                         $empresa[$a] = "NULL";
                        }
			
			// Primero Definimos nuestras Variables

//function sumarMinutosFecha($FechaStr, $MinASumar) {

/*$FechaStr = str_replace("-", " ", $FechaStr);
$FechaStr = str_replace(":", " ", $FechaStr);

$FechaOrigen = explode(" ", $FechaStr);*/


//return $FechaNueva;
//




		}
		
		//Validamos el Numero de Camiones a Procesar
			//$TotalViajesCargados
			
			for($a=1;$a<=$NumVM;$a++)
			{
				//echo "<br>Tanda ".$a;
				
				//for($b=1;$b<=$NVMS[$a];$b++)
				//{
					//echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Econ&oacute;mico ".$Economicos[$a];
					
					$Hoy=date("Y-m-d");
					$Hora=date("H:i:s",time());
					$Creo=$_SESSION[Descripcion]."*".$Hoy."*".$Hora;
					
					
    							
					 $insert="INSERT INTO viajesnetos(
													FechaCarga, 
													HoraCarga, 
													IdProyecto, 
													IdCamion, 
													IdOrigen, 
													FechaSalida, 
													HoraSalida, 
													IdTiro, 
													FechaLlegada, 
													HoraLlegada, 
													IdMaterial, 
													Observaciones, 
													Creo, 
													Estatus,
													IdSindicato, 
													IdEmpresa )";
					 $values=" VALUES(
									'".$Hoy."', 
									'".$Hora."', 
									".$_SESSION[Proyecto].", 
									".$Economicos[$a].", 
									".$Origenes[$a].", 
									'".$FechaV[$a]."', 
									'".$HoraV[$a]."', 
									".$Destinos[$a].", 
									'".$Fechas[$a]."', 
									'".$Horas[$a]."', 
									".$Materiales[$a].", 
									'".$Observaciones[$a]."', 
									'".$Creo."', 
									29,
									'".$sindicato[$a]."',
									".$empresa[$a]."
									);";
					$sql=$insert.$values;
					//echo "zaasdasdasdasdasdsql=".$sql;
					$result=$link->consultar($sql);
					$TotalViajesCargados=$TotalViajesCargados+$link->affected();
					//echo $TotalViajesCargados;
					//$link->cerrar();
				//}
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
<table width="840" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
  <tr>
    <td bordercolor="#FFFFFF" class="EncabezadoPagina">Modulo de Control de Acarreos.- Registro Manual de Viajes</td>
  </tr>
</table>
<table width="544" border="0" align="center" cellpadding="0" cellspacing="0">
  
  <tr>
    
    <td>&nbsp;</td>
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
<table width="840" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" align="center">
  <!--<tr>
    <td colspan="2">&nbsp;</td>
    <td align="center"><img src="../../../Imgs/calendarp.gif" width="19" height="21" /></td>
    <td align="center"><img src="../../../Imgs/16-Bus.gif" width="16" height="16" /></td>
    <td align="center"><img src="../../../Imgs/16-Origenes.gif" width="16" height="16" /></td>
    <td align="center"><img src="../../../Imgs/16-Destinos.gif" width="16" height="16" /></td>
    <td colspan="2" align="center"><img src="../../../Imgs/16-Materiales.gif" width="16" height="16" /></td>
  </tr>-->
  <tr>
    <td class="EncabezadoTabla">&nbsp;</td>
    <!--<td class="EncabezadoTabla" >#</td>-->
    <td class="EncabezadoTabla">Fecha</td>
    <td class="EncabezadoTabla">Hora</td>
    <td class="EncabezadoTabla">Econ&oacute;mico</td>
    <td class="EncabezadoTabla">Origen</td>
    <td class="EncabezadoTabla">Destino</td>
    <td  class="EncabezadoTabla">Material</td>
    <!--<td  class="EncabezadoTabla">Turno</td>-->
  </tr>
  <?php
  	for($a=1;$a<=$NumVM;$a++)
	{
  ?>
  <tr class="Item1">
    <td>&nbsp;<?php echo $a; ?>&nbsp;</td>
    <!--<td>&nbsp;<?php echo $NVMS[$a]; ?></td>-->
    <td>&nbsp;<?php echo $FechaEspanol=FechaEnEspanol($Fechas[$a]);?>&nbsp;</td>
    <td>&nbsp;<?php echo $Horas[$a];?>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Economico, IdCamion, $Economicos[$a], IdProyecto, $_SESSION["Proyecto"], camiones,e); ?>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Descripcion, IdOrigen, $Origenes[$a], IdProyecto, $_SESSION["Proyecto"], origenes,e); ?></td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Descripcion, IdTiro, $Destinos[$a], IdProyecto, $_SESSION["Proyecto"], tiros,e); ?>&nbsp;</td>
    <td>&nbsp;<?php RegresaDescripcionClave2(Descripcion, IdMaterial, $Materiales[$a], IdProyecto, $_SESSION["Proyecto"], materiales,e); ?>&nbsp;</td>
    <!--<td>&nbsp;<?php echo $_POST["Turno".$a]; ?></td>-->
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right" class="Item2">Observaciones:</td>
    <td colspan="4" class="Item1"><?php echo $Observaciones[$a]; ?></td>
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
    <!--<td  bgcolor="#F4F4F4" align="center"  style="font-size:11px;font-family:Calibri">'.$NVMS[$a].'</td>-->
	<td  bgcolor="#F4F4F4" align="center"  style="font-size:11px;font-family:Calibri">'.$FechaEspanol=FechaEnEspanol($Fechas[$a]).'</td>
    <td  bgcolor="#F4F4F4"  style="font-size:11px;font-family:Calibri">'.RegresaDescripcionClave2(Economico, IdCamion, $Economicos[$a], IdProyecto, $_SESSION["Proyecto"], camiones,r).'</td>
	<td  bgcolor="#F4F4F4" align="center"  style="font-size:11px;font-family:Calibri">'.$Horas[$a].'</td>
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
	<td  align="center" colspan="2"><h3 style="font-family:Calibri">MODULO DE CONTROL DE ACARREOS</h3></td>
	
</tr>
<tr>
	<td style="font-size:16px;font-family:Calibri" ><strong>Proyecto: </strong>'.$_SESSION['NombreCortoProyecto'].'</td>
</tr>
</table>
<h5  style="font-family:Calibri">Se le notifica que '.$_SESSION['Descripcion'].' ha registrado '.($a-1).' viajes manuales para autorizar.</h5> 
	<table>
	 <tr>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">&nbsp;</td>
    <!--<td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">No.<br>Viajes</td>-->
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Fecha</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Econ&oacute;mico</td>
	<td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Hora</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Origen</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Destino</td>
    <td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Material</td>
	<td bgcolor="#DADADA" align="center" style="font-size:11px;font-family:Calibri">Observaciones</td>
  </tr>
	';
	
$cuerpo2='</table>
<h6  style="font-family:Calibri">Mensaje enviado automaticamente desde el Modulo de Control de Acarreos</h6>
</body> 
</html> 
';
$cuerpo=$cuerpo1.$cuerpod.$cuerpo2;
$asunto = "Registro de Viajes Manuales"; 
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
$mail2->Host = "172.20.74.2";
$mail2->SMTPAuth = true;

$mail2->Username = "controlderecursos";
$mail2->Password = "&ScR2507-11$";
#####################################################################

$link=SCA::getConexion(); 
/*$select="select * from destinatarios_correo where Estatus=1";
//echo $select;
$r=$link->consultar($select);
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
	
}*/
$select="SELECT 
		users.correo as Direccion
		, notificaciones_eventos.Descripcion as Evento
        , notificaciones_tipo.Comando as Tipo
        , users.Descripcion as Nombre
        , notificaciones.IdProyecto as Proyecto 
FROM 
	( 
		(
			(
				sca_configuracion.notificaciones_tipo notificaciones_tipo 
			JOIN sca_configuracion.notificaciones notificaciones ON (notificaciones_tipo.IdNotificacionTipo = notificaciones.IdNotificacionTipo)
			) 
		JOIN sca_configuracion.notificaciones_eventos notificaciones_eventos ON (notificaciones_eventos.IdEvento = notificaciones.IdEvento)
        ) 
    JOIN igh.users users ON (users.IdUsuario = notificaciones.IdUsuario)
    )
 WHERE (notificaciones.IdProyecto = $_SESSION[ProyectoGlobal]) and (notificaciones_eventos.idevento=2)";
//echo $select;
$r=$link->consultar($select);
while ($v = $link->fetch($r)) {
    $mail2->From = 'modulodeacarreos@grupohi.mx';
    $mail2->FromName = 'SCA ' . $_SESSION['NombreCortoProyecto'];

    if ($v[Tipo] == 'AddAddress') {
        $mail2->AddAddress($v[Direccion]);
    }
    if ($v[Tipo] == 'AddCC') {
        $mail2->AddCC($v[Direccion]);
    }
    if ($v[Tipo] == 'AddBCC') {
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
echo "El mensaje ha sido enviado correctamente";
	
  ?>
  <tr>
    <td colspan="8" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="8" align="center" class="Subtitulo style1">Recuerde que para que usted pueda validar los Viajes que acaba de Registrar, primero deben pasar por el proceso de Autorizaci&oacute;n. </td>
  </tr>
  <?php }?>
</table>

</body>
</html>
