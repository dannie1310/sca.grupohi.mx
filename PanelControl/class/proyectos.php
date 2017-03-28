<?php 
class proyectos {

    private $sca_config;

    function __construct() {
        $this->sca_config = SCA_config::getConexion();
        $this->sca_config = SCA_IGH::getConexion();
    }
    public function getsca_config(){
            return $this->sca_config;
    }
    public function getsca_config_igh(){
            return $this->sca_config;
    }
    function en_listar_proyectos() {
        $sql_ = "Select id_proyecto, Descripcion from sca_configuracion.proyectos  where status=1    order by  find_in_set(Descripcion,'Panel de Control'), Descripcion asc";
        $lis_proy = '<ul>';
        $result_ = $this->getsca_config()->consultar($sql_);
        while ($row_p =$this->getsca_config()->fetch($result_)) {
            $lis_proy.="<li><img name='ph$row_p[id_proyecto]' class='inactivo' value='$row_p[id_proyecto]' src='../Imagenes/inactivo.gif' onclick='activar_desactivar_proyecto(this)'> ";
            $lis_proy.="<div style='display:inline; padding-left:20px;'>$row_p[Descripcion] </div><input type='hidden' value='' name='p$row_p[id_proyecto]' id='ph$row_p[id_proyecto]'></li>";
        }
        $lis_proy.= '</ul>';
        return $lis_proy;
    }
     function en_listar_proyectos_all() {
        $sql_ = "Select status, id_proyecto, Descripcion from sca_configuracion.proyectos where  id_proyecto!=5555  order by  find_in_set(Descripcion,'Panel de Control'), Descripcion asc";
        $lis_proy = '<ul>';
        $result_ = $this->getsca_config()->consultar($sql_);
        while ($row_p =$this->getsca_config()->fetch($result_)) {
            if($row_p[status]){
               $lis_proy.="<li><img name='ph$row_p[id_proyecto]' class='inactivo' value='$row_p[id_proyecto]' src='../Imagenes/activo.gif' onclick='activar_desactivar_proyecto(this)'> ";
               $lis_proy.="<div style='display:inline; padding-left:20px;'>$row_p[Descripcion] </div><input type='hidden' value='$row_p[id_proyecto]' name='p$row_p[id_proyecto]' id='ph$row_p[id_proyecto]'></li>";
            }else{
            $lis_proy.="<li><img name='ph$row_p[id_proyecto]' class='inactivo' value='$row_p[id_proyecto]' src='../Imagenes/inactivo.gif' onclick='activar_desactivar_proyecto(this)'> ";
            $lis_proy.="<div style='display:inline; padding-left:20px;'>$row_p[Descripcion] </div><input type='hidden' value='' name='p$row_p[id_proyecto]' id='ph$row_p[id_proyecto]'></li>";
            }
        }
        $lis_proy.= '</ul>';
        return $lis_proy;
    }
    function en_listar_proy_combo() {
        $sql_ = "Select id_proyecto, Descripcion from sca_configuracion.proyectos order by  find_in_set(Descripcion,'Panel de Control'), Descripcion asc";
        $lis_proy = '';
        $result_ = $this->getsca_config()->consultar($sql_);
        while ($row_p =$this->getsca_config()->fetch($result_)) {
            $lis_proy.="<option value='$row_p[id_proyecto]'>$row_p[Descripcion]</option>";
        }
        //$lis_proy.= '</select>';
        return $lis_proy;
    }
    function proyecto_permiso($user){
        $sql_ = "SELECT id_proyecto,
(Select Descripcion from proyectos p where p.id_proyecto=up.id_proyecto) as Descripcion,
 id_usuario_intranet as id_usuario FROM usuarios_proyectos up  where id_usuario_intranet=$user
 union
Select id_proyecto, Descripcion, null as id_usuario from proyectos
where Id_proyecto not in (Select id_proyecto FROM usuarios_proyectos up  where id_usuario_intranet=$user) 
 order by  find_in_set(Descripcion,'Panel de Control'), Descripcion asc;";
        $lis_proy = '<ul>';
        $result_ = $this->getsca_config()->consultar($sql_);
        while ($row_p =$this->getsca_config()->fetch($result_)) {
            if($row_p[id_usuario]){
                $lis_proy.="<li><img name='ph$row_p[id_proyecto]' class='inactivo' value='$row_p[id_proyecto]' title='$row_p[id_proyecto]' src='../Imagenes/activo.gif' onclick='validar_activado_proyec(this); activar_proyecto(this);'>
                            <img id='im_m$row_p[id_proyecto]' WIDTH=16 HEIGHT=16 value='$row_p[id_proyecto]' src='../Imagenes/add.gif' onclick='proyecto_menu(this,\"$row_p[Descripcion]\",$row_p[id_proyecto])'>";
            $lis_proy.="<div style='display:inline; padding-left:20px;'>$row_p[Descripcion] </div><input type='hidden' value='$row_p[id_proyecto]' name='p$row_p[id_proyecto]' id='ph$row_p[id_proyecto]'></li>";
               }
                else{
                $lis_proy.="<li><img name='ph$row_p[id_proyecto]' class='inactivo' value='$row_p[id_proyecto]' title='$row_p[id_proyecto]' src='../Imagenes/inactivo.gif' onclick='validar_activado_proyec(this);activar_proyecto(this);'>
                    <img id='im_m$row_p[id_proyecto]' WIDTH=16 HEIGHT=16 value='$row_p[id_proyecto]' src='../Imagenes/add.gif' style='display:none' onclick='proyecto_menu(this,\"$row_p[Descripcion]\",$row_p[id_proyecto])'>";
              $lis_proy.="<div style='display:inline; padding-left:20px;'>$row_p[Descripcion] </div><input type='hidden' value='' name='p$row_p[id_proyecto]' id='ph$row_p[id_proyecto]'></li>";
              }
            
        }
        $lis_proy.= '</ul>';
        return $lis_proy;
    }
    function alta_proyecto($name,$name_corto,$database){
         $sql = "insert into proyectos (id_proyecto , base_datos,descripcion, descripcion_corta) values
             ((Select max(id_proyecto)+1 from proyectos where id_proyecto!=5555),'$database','$name','$name_corto');";
         if($this->getsca_config()->consultar($sql)){
             echo "El proyecto fue guardado";
         }else{
              echo "<font color=red>Error al guardar el proyecto</font>";
         }
    }
    function activar_desactivar_proyecto($id_proyecto,$status){
        $sql = "Update sca_configuracion.proyectos  set status=$status where id_proyecto=$id_proyecto;";
         if($this->getsca_config()->consultar($sql)){
             echo "El proyecto fue guardado";
         }else{
              echo "<font color=red>Error al guardar el proyecto</font>";
         }
    }

}




?>