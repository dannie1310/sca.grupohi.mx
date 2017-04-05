<?php
    class adminusers extends proyectos{
         public function __construct(){ 
              parent::__construct();
          }
    function llena_combo_users() {
        $sql = "Select IdUsuario, Descripcion from igh.users where IdUsuario not in (SELECT id_usuario_Intranet FROM sca_configuracion.usuarios_proyectos group by id_usuario_Intranet) And estatus=2 order by Descripcion;";
        $combo_use_alta = '';
        $result = $this->getsca_config_igh()->consultar($sql);
        while ($row = $this->getsca_config_igh()->fetch($result))
            $combo_use_alta.="<option value=$row[IdUsuario]>$row[Descripcion]</option>";
        return $combo_use_alta;
    }
      function llena_combo_users_registrados() {
        $sql = "Select IdUsuario, Descripcion from igh.users where IdUsuario  in (SELECT id_usuario_Intranet FROM sca_configuracion.usuarios_proyectos group by id_usuario_Intranet) order by Descripcion;";
        $combo_use_alta = '';
        $result = $this->getsca_config_igh()->consultar($sql);
        while ($row = $this->getsca_config_igh()->fetch($result))
            $combo_use_alta.="<option value=$row[IdUsuario]>$row[Descripcion]</option>";
        return $combo_use_alta;
    }

    function altausuario($array) {
        if ($array[usuarioalta] != 'null') {
            if ($array) {
                $a_insert = '';
                foreach ($array as $key => $value) 
                    if ($key != 'usuarioalta' && $value)
                        $a_insert.="(0,$value, $array[usuarioalta]),";                
                if ($a_insert)
                     $a_insert = substr($a_insert, 0, -1) . ';';
                else {
                    echo "<font color=red>Favor de selecionar un proyecto para el usuario</font>";
                    exit();
                }
            } else 
                $resp= "Error datos vacios, favor de verificar";
             $sql = "insert into sca_configuracion.usuarios_proyectos values $a_insert";
          if ($this->getsca_config()->consultar($sql)) 
                $resp= "Usuario fue dado de alta satisfactoriamente";
             else 
                $resp= "Error al dar de alta el usuario, intente nuevamente";           
        } else 
            $resp= "Error porfavor seleciona un usuario valido";
        return $resp ;   
    }
    function all_users_intranet($evento,$entotipo, $proyecto){ 
         //$sql = "Select Idusuario, (Select Descripcion from intranet.users iu where iu.IdUsuario=c.IdUsuario) as Descripcion  from intranet.correos c where  estatus=1  order by Descripcion;";
          $sql = "Select Idusuario, Descripcion from igh.users c
where estatus=2 And c.IdUsuario not in (SELECT sca.IdUsuario FROM sca_configuracion.notificaciones  sca where IdEvento=$evento and IdNotificacionTipo in (1,2,3) and IdProyecto=$proyecto)
order by Descripcion";
        $combo_use_alta = '';
        $result = $this->getsca_config_igh()->consultar($sql);
        while ($row = $this->getsca_config_igh()->fetch($result))
            $combo_use_alta.="<option value=$row[IdUsuario]>$row[Descripcion]</option>";
        return $combo_use_alta;
    }

     
}
?>