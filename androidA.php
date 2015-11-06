<?php
ini_set("display_errors", "on");
include("inc/php/conexiones/SCA_config.php");
include("inc/php/conexiones/SCA.php");
include "AndroidA/clases/Usuario.php"; 
//print_r($_REQUEST);
//echo json_encode($_REQUEST);
//$array[]=array("usr"=>$_REQUEST[usr],"pass"=>$_REQUEST[pass]);
//$array[]=array("usr"=>$_REQUEST[usr],"pass"=>$_REQUEST[pass]);


//print_r(json_encode($array));

//print_r(json_encode(array("hola",2,3)));
$Usuarios=new Usuario();
if (isset($_REQUEST[metodo])){
   // if (is_callable(array($form, $_REQUEST[metodo]))){
        $Usuarios->$_REQUEST['metodo']($_REQUEST['usr'],$_REQUEST['pass']);   
    //}  else {
           // $Usuarios->getData($_REQUEST[usr],$_REQUEST[pass]);    
    //}
    
}else
$Usuarios->getData($_REQUEST[usr],$_REQUEST[pass]);
?>
