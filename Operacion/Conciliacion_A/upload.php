<?php
session_start();
require_once("../../inc/php/conexiones/SCA.php");
include("../../Clases/Funciones/Catalogos/Genericas.php");

$idconciliacion=$_REQUEST['idconcliacion'];
$fechainicio=$_REQUEST['fechainicio'];
$fechafin=$_REQUEST['fechafin'];
$date=date("YmdHis");
$namefile=$idconciliacion.".pdf";
$namefile_del=$idconciliacion."_".$date.".pdf";
$idusuario=$_SESSION["IdUsuarioAc"];



$sql="SELECT idconciliacion FROM conciliacion_firmas  where idconciliacion=$idconciliacion and status=1 limit 1";
//echo $sql;
$link=SCA::getConexion();

$row=$link->consultar($sql);
$hay=$link->affected();
if($hay>0){
    $sql="UPDATE conciliacion_firmas SET status=0 and fechahora=NOW() WHERE idconciliacion=$idconciliacion ";
    $link->consultar($sql);
}
   $sql="INSERT INTO conciliacion_firmas 
   (nombre_file, rutadir,status, idconciliacion, idusuario, fechahora) values(
    '$namefile', 'firma_concliliacion',1, $idconciliacion,$idusuario, NOW()) "; 
   $link->consultar($sql);
   $sql="UPDATE conciliacion SET FirmadoPDF=1 WHERE idconciliacion=$idconciliacion ";
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

    if($hay>0){
        if(copy("firma_concliliacion/$namefile", "eliminado_firma_concliliacion/$namefile_del")){
             echo " Se ha copiado el archivo";
        }
        else
          if(rename("firma_concliliacion/$namefile", "eliminado_firma_concliliacion/$namefile")){
            echo " Se ha renombrado el archivo";
          }else  echo "no se puede copiar ni renombrar";

    }else
    echo "No es mayor que 0";
        
         
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"firma_concliliacion/".$namefile))
    {
       sleep(3);//retrasamos la petición 3 segundos
       //echo $file;//devolvemos el nombre del archivo para pintar la imagen
    }else
      echo "El archivo esta vació";
   
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>