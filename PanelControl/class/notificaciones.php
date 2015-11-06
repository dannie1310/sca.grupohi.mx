<?php
 class notificaciones extends proyectos {
          public function __construct() {
        parent::__construct();
    }
    
     function notif_eventos(){
        $eventos='';
        $sql="SELECT IdEvento, Descripcion, Corto FROM notificaciones_eventos;";
        $result = $this->getsca_config()->consultar($sql);
        while ($row = $this->getsca_config()->fetch($result)){
          $eventos.="<option value='$row[IdEvento]'>$row[Descripcion]</option>";
        }
        return $eventos;
    }
    function consulta_notif($evento,$entotipo, $proyecto){        
        $sql="SELECT IdEvento, IdNotificacionTipo, IdUsuario, IdProyecto, (Select Descripcion from igh.users iu where iu.Idusuario=sca.Idusuario) as Nombre FROM sca_configuracion.notificaciones sca  where IdEvento=$evento and IdNotificacionTipo=$entotipo and IdProyecto=$proyecto order By Nombre";
        $result = $this->getsca_config()->consultar($sql);
        $usuarios="<table >";
        while ($row = $this->getsca_config()->fetch($result)){
          $usuarios.="<tr><td><img src='../Imgs/kill_user.jpeg' onclick=' eliminar_notif_user($row[IdUsuario])'> <td><td value='$row[IdUsuario]'>$row[Nombre]</td></tr>";
        }
         $usuarios.="</table>";
        return $usuarios;
    }
    
    
    function insertar_user_notificacion($idusuario, $evento,$entotipo, $proyecto){
         echo $sql="insert into sca_configuracion.notificaciones values($evento, $entotipo,$idusuario,$proyecto)";
         $this->getsca_config()->consultar($sql);
    }
    function eliminar_user_notif($user, $evento,$entotipo, $proyecto){
        echo $sql = "Delete from sca_configuracion.notificaciones where IdEvento=$evento and IdNotificacionTipo= $entotipo and IdProyecto=$proyecto And IdUsuario=$user";
        $this->getsca_config()->consultar($sql);
    }
 }

?>