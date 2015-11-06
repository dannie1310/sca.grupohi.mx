<?php
session_start();

require_once("../../../inc/php/conexiones/SCA.php");
include("../../../Clases/Funciones/Catalogos/Genericas.php");

function __autoload( $nombreClase ){
    if(file_exists( 'class/'.$nombreClase . '.php' ))
    		include( 'class/'.$nombreClase . '.php' );
    else{
        echo 'No encontrada clase: ' . $nombreClase;
        exit();
    }
}
 
$clase = new $_REQUEST['class'](); //Imprime: Incluida clase: MiClase <-- He sido instanciada
$clase->$_REQUEST['function']();
?>