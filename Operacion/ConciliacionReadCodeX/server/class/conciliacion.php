<?php

class conciliacion {

    var $db;

    function __construct() {
        $this->db = SCA::getConexion();
    }

    function setConciliacion() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliaciones = $request->data;

        $fechainicio = $request->fechainicio;
        $fechafin = $request->fechafin;
        $observacion = $request->observacion;
        $sindicato = $conciliaciones[0]->idsindicato;
        $cadenasql = array();
        $fecha = date("Y-m-d");
        //print_r($conciliaciones);

        $sql = "INSERT INTO  conciliacion (fecha_conciliacion, idsindicato, fecha_inicial, fecha_final,estado, observaciones)
            values('$fecha', $sindicato, '$fechainicio','$fechafin', 1, '$observacion' )";
        $this->db->consultar($sql);
        if ($this->db->retId() > 0) {
            $idconciliacion = $this->db->retId();
            $sql = "insert into conciliacion_detalle (idconciliacion, idviaje, estado) values";

            foreach ($conciliaciones as $value)
                $cadenasql[] = "("
                        . "$idconciliacion"
                        . ", $value->idviaje"
                        . ", 1)";
            $sqlex = implode(',', $cadenasql);
            $sql = $sql . $sqlex;
            $result = $this->db->consultar($sql);
            if (!$result) {
                $this->db->consultar("delete from conciliacion where idconciliacion=$idconciliacion");
                echo json_encode(array("error" => "Error al insertar los datos"));
            } else
                echo json_encode(array("conciliacion" => $idconciliacion));
        } else
            echo json_encode(array("error" => "error al dar de alta la consiliacion"));
    }

    function getConciliacion() {
        $conciliacion = $_REQUEST[conciliacion];
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
		, c.idconciliacion
		, c.fecha_conciliacion
		, c.fecha_inicial
		, c.fecha_final
		, c.estado
		,  if(c.observaciones='', 'sin comentarios',c.observaciones  ) as observaciones
                ,s.descripcion as sindicato
                  from conciliacion_detalle cd
                right join conciliacion c  on c.idconciliacion=cd.idconciliacion
                right join viajes v USING (idviaje)
                right join camiones cm  on cm.idcamion=v.idcamion 
                right join origenes o  on o.idorigen=v.idorigen 
                right join tiros t  on t.idtiro=v.idtiro 
                right join materiales m  on m.idmaterial=v.idmaterial 
		right join sindicatos s  on s.idsindicato=cm.idsindicato
		where idconciliacion_detalle is not null AND c.idconciliacion=$conciliacion";
        $rsql = $this->db->consultar($sql);
        $array = array();
        while ($row = $this->db->fetch($rsql))
            $array[] = $row;
        echo json_encode($array);
    }

    function getConciliaciones() {
        $sql = "select 
                count(v.idviaje)  viajes
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
                , VolumenPrimerKM + VolumenKMSubsecuentes + VolumenKMAdicionales as volumentotal
                , sum(ImportePrimerKM + ImporteKMSubsecuentes + ImporteKMAdicionales) as importetotal
                , m.descripcion as material
                , v.code AS code
		,s.idsindicato
		, c.idconciliacion
		, c.fecha_conciliacion
		, c.fecha_inicial
		, c.fecha_final
		, c.estado
		, if(c.observaciones='', 'Sin observación', c.observaciones) as observaciones
                ,s.descripcion as sindicato
                  from conciliacion_detalle cd
                right join conciliacion c  on c.idconciliacion=cd.idconciliacion
                right join viajes v USING (idviaje)
                right join camiones cm  on cm.idcamion=v.idcamion 
                right join origenes o  on o.idorigen=v.idorigen 
                right join tiros t  on t.idtiro=v.idtiro 
                right join materiales m  on m.idmaterial=v.idmaterial 
		right join sindicatos s  on s.idsindicato=cm.idsindicato
		where idconciliacion_detalle is not null group by c.idconciliacion";
        $rsql = $this->db->consultar($sql);
        $array = array();
        while ($row = $this->db->fetch($rsql))
            $array[] = $row;

        if (count($array) > 0)
            echo json_encode($array);
        else
            echo json_encode(array("nodata" => "No hay conciliaciones"));
    }

    function setAprobarConciliacion() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliacion = $request->conciliacion;
        $sql = "update  conciliacion set estado=2 where idconciliacion=$conciliacion";
        $result = $this->db->consultar($sql);
        if ($result === TRUE) {
            $sql = "insert into conciliacion_historico (idusuario, idconciliacion, operacion) values( $_SESSION[IdUsuarioAc], $conciliacion, 'aprobado');";
            $this->db->consultar($sql);
            echo json_encode(array("id" => $this->db->retId()));
        } else {
            echo json_encode(array("error" => "Error al actuaizar"));
        }
    }

    function setDesaprobarConciliacion() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliacion = $request->conciliacion;
        $sql = "update  conciliacion set estado=1 where idconciliacion=$conciliacion";
        $result = $this->db->consultar($sql);
        if ($result === TRUE) {
            $sql = "insert into conciliacion_historico (idusuario, idconciliacion, operacion) values( $_SESSION[IdUsuarioAc], $conciliacion, 'Desaprobar');";
            $this->db->consultar($sql);
            echo json_encode(array("id" => $this->db->retId()));
        } else {
            echo json_encode(array("error" => "Error al actuaizar"));
        }
    }

    function setEliminarViaje() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliacion = $request->conciliacion;
        $viaje = $request->viaje;
        $sql = "delete from conciliacion_detalle where idconciliacion =$conciliacion and idviaje=$viaje";
        $result = $this->db->consultar($sql);
        if ($result === TRUE) {
            $sql = "insert into conciliacion_historico (idusuario, idconciliacion, operacion) values( $_SESSION[IdUsuarioAc], $conciliacion, 'Elimino viaje=$viaje');";
            $this->db->consultar($sql);
            echo json_encode(array("msj" => "Eliminado correctamente"));
        } else {
            echo json_encode(array("error" => "Error al al eliminar el registro"));
        }
    }
    function setModificarObservacion(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliacion = $request->conciliacion;
        $observacion = $request->observacion;
        $sql = "update  conciliacion set observaciones='$observacion' where idconciliacion=$conciliacion";
        $result = $this->db->consultar($sql);
        if ($result === TRUE) {
             $sql = "insert into conciliacion_historico (idusuario, idconciliacion, operacion) values( $_SESSION[IdUsuarioAc], $conciliacion, 'actualizo obser=$observacion');";
            $this->db->consultar($sql);
            echo json_encode(array("msj" => "Se actualizo correctamente"));
        } else {
            echo json_encode(array("error" => "Error al al actualizar la observación"));
        }
    }
    function setEliminarConciliacion(){
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliacion = $request->conciliacion;
        $sql = "delete from conciliacion_detalle where idconciliacion =$conciliacion";
        $result = $this->db->consultar($sql);
        if ($result === TRUE) {
            $sql = "insert into conciliacion_historico (idusuario, idconciliacion, operacion) values( $_SESSION[IdUsuarioAc], $conciliacion, 'elimino conciliacion');";
            $this->db->consultar($sql);
            echo json_encode(array("msj" => "Eliminado correctamente"));
            
        } else {
            echo json_encode(array("error" => "Error al al eliminar el registro"));
        }
    }

    function getAddConciliacion(){
        $conciliacion = $_REQUEST['conciliacion'];
        $sql = "select c.idconciliacion as folio, c.fecha_inicial as fcinicial, c.fecha_final as fcfinal,s.descripcion as sindicato,
                v.idviaje
                , 1 as status
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
        , c.idconciliacion
        , c.fecha_conciliacion
        , c.fecha_inicial
        , c.fecha_final
        , c.estado
        ,  if(c.observaciones='', 'sin comentarios',c.observaciones  ) as observaciones
                ,s.descripcion as sindicato
                  from conciliacion_detalle cd
                right join conciliacion c  on c.idconciliacion=cd.idconciliacion
                right join viajes v USING (idviaje)
                right join camiones cm  on cm.idcamion=v.idcamion 
                right join origenes o  on o.idorigen=v.idorigen 
                right join tiros t  on t.idtiro=v.idtiro 
                right join materiales m  on m.idmaterial=v.idmaterial 
        right join sindicatos s  on s.idsindicato=cm.idsindicato
        where idconciliacion_detalle is not null AND c.idconciliacion=$conciliacion";
        $rsql = $this->db->consultar($sql);
        $array = array();
        while ($row = $this->db->fetch($rsql))
            $array[] = $row;
        echo json_encode($array);

    }
    function actualizarConciliacion() {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        $conciliaciones = $request->data;

        $observacion = $request->observacion;
        $sindicato = $conciliaciones[0]->idsindicato;
        $idconciliacion = $conciliaciones[0]->idconciliacion;
        $cadenasql = array();
        //Update Observaciones
        $this->db->consultar("update conciliacion set observaciones='$observacion' where idconciliacion=$idconciliacion");
        $this->db->consultar("delete from conciliacion_detalle where idconciliacion=$idconciliacion");
        $sql = "insert into conciliacion_detalle (idconciliacion, idviaje, estado) values";
            foreach ($conciliaciones as $value)
                $cadenasql[] = "("
                        . "$idconciliacion"
                        . ", $value->idviaje"
                        . ", 1)";
             $sqlex = implode(',', $cadenasql);
            echo $sql = $sql . $sqlex;
            $result = $this->db->consultar($sql);
            if (!$result) {
                echo json_encode(array("error" => "Error al insertar los datos"));
            } else
                echo json_encode(array("conciliacion" => $idconciliacion));

    }

}

?>