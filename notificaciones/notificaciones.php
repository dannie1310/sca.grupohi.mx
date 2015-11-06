<?php 
require("class.phpmailer.php");
require("config.php");

class notificaciones {

    public $mail;
    

    function _construct($host=HOST,$Username=MAIL_USER,$Password=MAIL_PASS,$from_name=MAIL_NAME, $char=MAIL_CHAR) {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->Host =$host;
        $this->mail->Username = $Username;
        $this->mail->Password = $Password;
        $this->mail->SMTPAuth = true;
        $this->mail->CharSet = MAIL_CHAR;
        $this->mail->From = $from_name;        
        $this->mail->IsHTML(true);        
    }

    function envia_system($para,$asunto, $msj,$imagen=null, $archivo=null) {
        $this->mail->FromName = $para;
        $this->mail->Subject = $asunto;
        $this->mail->AltBody = $msj;
        if($imagen)
            foreach ($imagen as $value)
              $this->mail->AddEmbeddedImage($value, $value); 
        
        if($archivo)
            foreach ($archivo as $value)
              $this->mail->AddAttachment($value, $value);
    }

}
 /*
 
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = "mail.flumo.com";
    $mail->Username = "usuario";
    $mail->Password = "password";
    $mail->SMTPAuth = true;
    $mail->CharSet = "UTF-8";
    $mail->From = "info@flumo.com";
    $mail->FromName = "Flumo.com";
    $mail->IsHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->AltBody = $_POST['header']."\n\n".$_POST['body'];
    $mail->AddEmbeddedImage('logo.gif','my-logo');
    $mail->AddEmbeddedImage('bg.gif','my-bg');
    /* Destinatarios */
  /*  $mail->AddAddress('info@flumo.com','Lista de correo de Flumo.com');
    if($_POST['database'] == 1){
        $usuarios = $db->get_results("SELECT * FROM usuarios");
        foreach($usuarios as $usuario){
            $mail->AddBCC($usuario->email,$usuario->name);
        }
    }
    if($_POST['destinatarios']){
        $to = explode(",",$_POST['destinatarios']);
        foreach($to as $tos){
            $mail->AddBCC($tos);
        }
    }
    /* Plantilla */
   /* $template = file_get_contents('templates/flumo.tpl','r');
    $display = str_replace("%%header%%",$_POST['header'],$template);
    $display = str_replace("%%body%%",$_POST['body'],$display);
    /* Imagenes */
    /*$display = str_replace("logo.gif","cid:my-logo",$display);
    $display = str_replace("bg.gif","cid:my-bg",$display);
    $mail->Body = $display;
    /* Envio del mensaje */
    /*if(!$mail->Send()) {
        echo "El mensaje no pudo ser enviado.";
        echo "Error: " . $mail->ErrorInfo;
    } else {
        echo "El mensaje ha sido enviado.";
    }*/


?>