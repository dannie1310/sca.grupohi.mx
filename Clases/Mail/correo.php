<?php
require "class.phpmailer.php";
$mail2 = new PHPMailer();
$mail2->IsSMTP();
$mail2->Host = "mail.grupolanacional.com.mx";
$mail2->SMTPAuth = true;
$mail2->Username = "webmaster@grupolanacional.com.mx";
$mail2->Password = "wm654321";
$mail2->From = "webmaster@grupolanacional.com.mx";
$mail2->FromName = "webmaster";
$mail2->AddAddress("omar.aguayo@grupolanacional.com.mx");
$mail2->WordWrap = 50;
$mail2->IsHTML(true);
$mail2->Subject = "Correo con mailer";
$mail2->Body = "<b>Correo de prueba usando mailer</b>";
$mail2->AltBody = "Correo de prueba usando mailer";
if(!$mail2->Send())
{
	echo "El mensaje no ha podido ser enviado";
	echo "Error: ".$mail2->ErrorInfo;
	exit;
}
echo "El mensaje ha sido enviado correctamente";
?>
