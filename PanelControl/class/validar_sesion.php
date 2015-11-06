<?php
session_start();
  class validar_usuario{

    function __construct() {
        if (!empty($_SESSION['IdUsuario'])) 
          $this->sesion_user=$_SESSION['IdUsuario'];
        else {
             echo "<b><Font color=red>Ha caducado la sesión, favor de regresarse a la intranet gracias.</Font></b>";
          exit();    
        }
    }
    
  }
?>