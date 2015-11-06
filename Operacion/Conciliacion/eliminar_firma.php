<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");

$idconciliacion=$_REQUEST['idconcliacion'];
$_proyecto_global=$_SESSION['ProyectoGlobal'];
$namefile=$_proyecto_global."-".$idconciliacion.".pdf";
$date=date("YmdHis");
$namefile_del=$_proyecto_global."-".$idconciliacion."_".$date.".pdf";
$idusuario=$_SESSION["IdUsuarioAc"];

$link=SCA::getConexion();
echo $sql="UPDATE conciliacion_firmas SET status=0 and fechahora=NOW() WHERE idconciliacion=$idconciliacion ";
$link->consultar($sql);
echo $sql="UPDATE conciliacion SET FirmadoPDF=0 WHERE idconciliacion=$idconciliacion ";
$link->consultar($sql);

//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
    //print_r($_FILES);
 
    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir("firma_concliliacion/")) 
        mkdir("firma_concliliacion/", 0777);

    if(copy("firma_concliliacion/$namefile", "eliminado_firma_concliliacion/$namefile_del")){
      echo " Se ha copiado el archivo";
      unlink("firma_concliliacion/$namefile");
    }

}else{
    throw new Exception("Error Processing Request", 1);   
}
?>