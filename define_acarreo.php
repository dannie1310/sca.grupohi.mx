<?php
session_start();
include("inc/php/conexiones/SCA_config.php");
include("inc/php/conexiones/SCA.php");
include("Clases/Funcion_Menu.php");
include("Clases/Usuario/Usuario.php");

 

//if(!empty($_POST[proyecto]) && !empty($_POST[idusuario]))
if(!empty($_SESSION['IdUsuario'])) {       
        $sca_config = SCA_config::getConexion();  
       $sql = "SELECT usuarios_proyectos.id_usuario,
       usuarios_proyectos.id_proyecto,
       proyectos.base_datos,
       proyectos.base_datos,
       usuarios_proyectos.id_usuario_intranet,
       proyectos.descripcion,
       proyectos.descripcion_corta,
       proyectos.tiene_logo,
       proyectos.logo
  FROM    sca_configuracion.proyectos proyectos
       RIGHT OUTER JOIN
          sca_configuracion.usuarios_proyectos usuarios_proyectos
       ON (proyectos.id_proyecto = usuarios_proyectos.id_proyecto)
 WHERE     (proyectos.base_datos = '$_POST[proyecto]')
       AND (usuarios_proyectos.id_usuario_intranet = $_SESSION[IdUsuario]);";	
    $result = $sca_config->consultar($sql);
   while ($row = $sca_config->fetch($result)){
        $_SESSION['ProyectoGlobal'] = $row["id_proyecto"];
		$_SESSION['Proyecto'] = 1;
        $_SESSION['NombreCortoProyecto'] = $row["descripcion_corta"];
        $_SESSION['DescripcionProyecto'] = $row["Descripcion"];
	    $_SESSION["IdUsuarioAc"] =$_SESSION[IdUsuario];//$row["id_usuario"];
        $_SESSION["databasesca"] =$_POST[proyecto];
        $_SESSION["tiene_logo"]= $row["tiene_logo"];
        $_SESSION["logo"]= $row["logo"];
        
         $usuario = new Usuario();
        $varMenu = $usuario->creaMenu($_SESSION['IdUsuario'],$row["id_proyecto"]); 

        $de_niveles = obtiene_niveles($varMenu);    
	
         $no_niveles = sizeof($de_niveles);  

        obtienehijos(0, $varMenu, $_SESSION['IdUsuario']);
          
        //header("location:sca.php"); 
        //header('Location: http://www.example.com/');
    }
 }else{
    echo  "<b><Font color=red>Ha caducado la sesión, favor de regresarse a la intranet gracias.</Font></b>";
   exit();
}
?>