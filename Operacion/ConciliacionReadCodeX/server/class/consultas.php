<?php

class consultas {

    var $db;

    function __construct() {
        $this->db = SCA::getConexion();
    }

    function getSindicatos() {
        $sql = "SELECT * FROM sindicatos WHERE Estatus=1 ORDER BY Descripcion ";
        $rsql = $this->db->consultar($sql);
        $array = '';
        while ($row = $this->db->fetch($rsql))
            $array[] = array('id' => $row['IdSindicato'], 'descripcion' => $row['Descripcion']);
        echo json_encode($array);
    }

    function getAutentication() {
        $form = file_get_contents("php://input");
        $form = json_decode($form);
        $user = $form->user;
        $pass = $form->pass;
        $sql = "SELECT IdUsuario, Descripcion, Usuario FROM igh.users WHERE Usuario='$user' AND Clave=md5('$pass') LIMIT 1";
        $rsql = $this->db->consultar($sql);
        $array = '';
        while ($row = $this->db->fetch($rsql))
            $array[] = array('IdUsuario' => $row['IdUsuario']
                , 'descripcion' => $row['Descripcion']
                , 'usuario' => $row['Usuario']);
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($array);
    }

    function getPermisos() {
        $sql = "Select id_nivelmenu as id, Descripcion from sca_configuracion.usuarios_proyectos_modulos upd
                inner join sca_configuracion.niveles_menu nm on upd.id_modulo=nm.id_nivelmenu
                where id_usuario=$_SESSION[IdUsuarioAc] AND IdPadre=110 group by id_modulo;";
        $rsql = $this->db->consultar($sql);
        $array = '';
        while ($row = $this->db->fetch($rsql))
            $array[] = array('id' => $row['id'], 'descripcion' => $row['Descripcion']);
        echo json_encode($array);
    }

    function getConsultaviajesaconsiliar() {
        //validar parametros        
        if (!isset($_REQUEST['fechainicial'])) {
            echo json_encode(array("error"=>"Error no se específico la fecha inicial"));            
            return false;
        }  else {
            $date = DateTime::createFromFormat('Y-m-d', $_REQUEST['fechainicial']);
            if (!$date) {
                 echo json_encode(array("error"=> "Error fecha inicial no valida "));
                 return false;
            }    
        }
        if (!isset($_REQUEST['fechafinal'])) {
            echo json_encode(array("error"=> "Error no se específicola fecha final"));
            return false;
        }else {
            $date = DateTime::createFromFormat('Y-m-d', $_REQUEST['fechafinal']);
            if (!$date) {
                 echo json_encode(array("error"=> "Error fecha final no valida "));
                 return false;
            }    
        }
        if (!isset($_REQUEST['code'])) {
            echo json_encode(array("error"=> "Error no se específicola el código"));
            return false;
        }
         if (!isset($_REQUEST['sindicato'])) {
            echo json_encode(array("error"=> "Error no se específicola el sindicato"));
            return false;
        }
         $sql = "select 
                v.idviaje
                , v.fechallegada
                , cubicacionCamion
                , o.descripcion as origen
                , Horasalida
                , horallegada
                , t.descripcion as tiro
                , importe
                , economico
                , 1 as turno
                , 1 as DIST
                , 1 as viajes                
                , VolumenPrimerKM + VolumenKMSubsecuentes + VolumenKMAdicionales as volumentotal
                , ImportePrimerKM + ImporteKMSubsecuentes + ImporteKMAdicionales as importetotal
                , m.descripcion as material
                , v.code AS code
		,s.idsindicato
                  from conciliacion_detalle cd
                right join conciliacion c  on c.idconciliacion=cd.idconciliacion
                right join viajes v USING (idviaje)
                right join camiones cm  on cm.idcamion=v.idcamion 
                right join origenes o  on o.idorigen=v.idorigen 
                right join tiros t  on t.idtiro=v.idtiro 
                right join materiales m  on m.idmaterial=v.idmaterial 
		right join sindicatos s  on s.idsindicato=cm.idsindicato
		where idconciliacion_detalle is null AND v.fechallegada between '$_REQUEST[fechainicial]' AND '$_REQUEST[fechafinal]' AND v.code='$_REQUEST[code]' and s.idsindicato=$_REQUEST[sindicato]
                 
                ";
        $rsql = $this->db->consultar($sql);
        $array = array();
        while ($row = $this->db->fetch($rsql))
            $array = array(
                'idviaje' => $row[idviaje]
                , 'economico' => $row[economico]
                , 'fechallegada' => $row[fechallegada]
                , 'cubicacionCamion' => $row[cubicacionCamion]
                , 'origen' => $row[origen]
                , 'Horasalida' => $row[Horasalida]
                , 'horallegada' => $row[horallegada]
                , 'tiro' => $row[tiro]
                , 'turno' => $row[turno]
                , 'DIST' => $row[DIST]
                , 'viajes' => $row[viajes]
                , 'material' => $row[material]
                , 'code' => $row[code]
                , 'importe' => $row[importe]
                , 'volumentotal' => $row[volumentotal]
                , 'importetotal' => $row[importetotal]
                ,'idsindicato' => $row[idsindicato]
                , 'status' => 0
                , 'seleccionado' => true
            );
        echo json_encode($array);
    }

}

?>