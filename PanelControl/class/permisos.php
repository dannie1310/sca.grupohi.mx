<?php
class permisos extends proyectos {
    public function __construct() {
        parent::__construct();
    }
    function consultar_menu($user,$proyecto){
	           $panelcontrol='';
	            if($proyecto==5555){ // SI ES PANEL DE CONTROL NO MOSTRAR LAS OPCIONES DE ADMINISTRADOR SIEMPRE Y CUANDO TENGA PERMISOS 
	               //$panelcontrol = " And nv.Id_NivelMenu in (106,107,108,109) ";
				    $panelcontrol = " And nv.Id_NivelMenu in (501,502,503,504) ";
				}else{
				   $panelcontrol = " And nv.Id_NivelMenu not in (501,502,503,504) ";
				}
	
         $sql="SELECT
concat(repeat('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',length(nivel_largo)/4),nv.Title) as Concepto,
nv.Id_NivelMenu AS NivelMenu,
nv.Nivel AS Nivel,
nv.Title,
nv.nivel_largo AS nivel_largo,
uxp.id_modulo,
uxp.id_usuario
 FROM niveles_menu nv
LEFT JOIN usuarios_proyectos_modulos uxp
ON (nv.Id_NivelMenu = uxp.id_modulo)
AND (uxp.id_usuario = $user) AND (uxp.id_proyecto= $proyecto) 
WHERE Estatus=1 $panelcontrol ORDER BY nivel_largo ;";
       $lista_menu='<form id="forpermisos"  > 
            <input type="hidden" name="users" value="'.$user.'">
            <input type="hidden" name="proyecto" value="'.$proyecto.'">
           <table>';
       $result = $this->getsca_config()->consultar($sql);
       while ($row = $this->getsca_config()->fetch($result))
           if($row[id_usuario])
              $lista_menu.=" <tr bgcolor='#F4F4F4'>
                    <td>
                    	<img src='../Imagenes/online16.png' name='$row[NivelMenu]' onclick='activar_proy_menu(this)'/>
                    </td>
                   <td>
                    <span  class='permisos' >$row[Concepto]</span>
                    <input type='hidden' name='ap$row[NivelMenu]' Id='ap$row[NivelMenu]' value='$row[NivelMenu]'>
                    </td>
                    </tr>";
           else
                     $lista_menu.=" <tr bgcolor='#F4F4F4'>
                    <td>
                    	<img src='../Imagenes/busy16.png' name='$row[NivelMenu]' onclick='activar_proy_menu(this)'/>
                    </td>
                   <td>
                    <span  class='permisos' >$row[Concepto]</span>
                    <input type='hidden' name='ap$row[NivelMenu]'  Id='ap$row[NivelMenu]' value=''>
                    </td>
                    </tr>";
        $lista_menu.="</table></form>";
        return $lista_menu;
    }
    function alta_permiso_proyec_user($array){
        //print_r($array);
        if ($array[users] != 'null' && $array[users] && $array[proyecto]) {		    
            if ($array) {
                $a_insert = '';
                foreach ($array as $key => $value){ 
				    if($key=='proyecto' OR $key=='users')
					  continue;
                    if ($key != 'usuarioalta' && $value)
                        $a_insert.="($array[users],$array[proyecto],$value),";                
				}
                if ($a_insert)
                    $a_insert = substr($a_insert, 0, -1) . ';';
                else {
                    echo "<font color=red>Favor de selecionar un proyecto para el usuario</font>";
                    exit();
                }
            } else 
                $resp= "Error datos vacios, favor de verificar";
            
            
            $this->getsca_config()->consultar("delete from usuarios_proyectos where id_proyecto=$array[proyecto] and Id_Usuario_intranet=$array[users]"); 
            //echo  "insert into usuarios_proyectos values (0,$array[proyecto],$array[users])";          
            $this->getsca_config()->consultar("insert into usuarios_proyectos values (0,$array[proyecto],$array[users])");
            $this->getsca_config()->consultar("delete from  usuarios_proyectos_modulos where id_proyecto=$array[proyecto] and id_usuario=$array[users]");
		   
		   /*echo  "delete from usuarios_proyectos where id_proyecto=$array[proyecto] and Id_Usuario_intranet=$array[users]";
		   echo '----';
		   echo  "insert into usuarios_proyectos values (0,$array[proyecto],$array[users])";
		   echo '----';
		   echo "delete from  usuarios_proyectos_modulos where id_proyecto=$array[proyecto] and id_usuario=$array[users]";
		   echo '----';*/
              $sql = "insert into usuarios_proyectos_modulos values $a_insert";   
			//exit();
            if ($this->getsca_config()->consultar($sql)){
                $resp= "Los permisos fueron dado de alta satisfactoriamente";               
            }
             else 
                $resp= "Error al dar de alta los permisos, intente nuevamente";            
        } else 
            $resp= "Error porfavor seleciona un usuario valido";
        return $resp ;
    }
    function alta_permiso_proyecto($id_proyecto, $id_usuario){
      echo "delete from usuarios_proyectos where id_proyecto=$id_proyecto and Id_Usuario_intranet=$id_usuario";
            $this->getsca_config()->consultar("delete from usuarios_proyectos where id_proyecto=$id_proyecto and Id_Usuario_intranet=$id_usuario"); 
            //echo  "insert into usuarios_proyectos values (0,$array[proyecto],$array[users])";          
            //$this->getsca_config()->consultar("insert into usuarios_proyectos values (0,$id_proyecto,$id_usuario)");

        return "Se quito el proyecto" ;
    }
   
}

?>
