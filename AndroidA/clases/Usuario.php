<?php
session_start();
class Usuario {
    var $_db;
    var $IdProyecto;
    var $IdUsuario;
    var $Nombre;
    var $_database_sca;

    function __construct() {
        $this->_db = SCA_config::getConexion();
    }

    function getData($usr, $pass) {       
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db ->consultar($sql);
        if ($row = $this->_db ->fetch($result)) {
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
            $result_s = $this->_db ->consultar($sql_s);
            if ($row_s = $this->_db ->fetch($result_s)) {
                $_SESSION["databasesca"]=$row_s[base_datos];
                //echo 'Base de datos:(('.$_SESSION["databasesca"].'))';
                
                //CAMIONES
                $this->_database_sca = SCA::getConexion();
                /*$sql_camiones="SELECT idcamion, idboton, concat(Economico, '-', Placas, '-', Propietario) as descripcion  FROM scatest.camiones where Estatus=1";
                $result_camiones=$this->_database_sca->consultar($sql_camiones);
                while($row_camiones=$this->_database_sca->fetch($result_camiones)) 
                        $array_camiones[]=array(
                            "idcamion"=>$row_camiones[idcamion],
                            "idboton"=>$row_camiones[idboton],
                            "descripcion"=>utf8_encode($row_camiones[descripcion])
                        );*/
                 $sql_camiones="SELECT idcamion, Placas, M.descripcion as marca, Modelo, Ancho, largo, Alto, Economico, CubicacionParaPago FROM camiones C
                                INNER JOIN marcas  M ON M.IdMarca=C.IdMarca where C.Estatus=1;";
                $result_camiones=$this->_database_sca->consultar($sql_camiones);
                while($row_camiones=$this->_database_sca->fetch($result_camiones)) 
                        $array_camiones[]=array(
                            "idcamion"=>$row_camiones[idcamion],
                            "placas"=>$row_camiones[Placas],
                            "marca"=>utf8_encode($row_camiones[marca]),
                            "modelo"=>utf8_encode($row_camiones[Modelo]),
                            "ancho"=>utf8_encode($row_camiones[Ancho]),
                            "largo"=>utf8_encode($row_camiones[largo]),
                            "alto"=>utf8_encode($row_camiones[Alto]),
                            "economico"=>utf8_encode($row_camiones[Economico]),
                            "capacidad"=>utf8_encode($row_camiones[CubicacionParaPago])
                        );
                //TIROS
                $sql_tiros="Select idtiro, descripcion from tiros where estatus=1;";
                $result_tiros=$this->_database_sca->consultar($sql_tiros);
                while($row_tiros=$this->_database_sca->fetch($result_tiros)) 
                        $array_tiros[]=array(
                            "idtiro"=>$row_tiros[idtiro],
                            "descripcion"=>utf8_encode($row_tiros[descripcion])
                            );
                 //ORIGENES
                $sql_origenes="SELECT idorigen, descripcion FROM origenes where Estatus=1;";
                $result_origenes=$this->_database_sca->consultar($sql_origenes);
                while($row_origenes=$this->_database_sca->fetch($result_origenes)) 
                        $array_origenes[]=array(
                            "idorigen"=>$row_origenes[idorigen],
                            "descripcion"=>utf8_encode($row_origenes[descripcion])
                            );

                //RUTAS
                $sql_rutas="SELECT clave, idruta, idorigen, idtiro, totalkm  FROM rutas";
                $result_rutas=$this->_database_sca->consultar($sql_rutas);
                while($row_rutas=$this->_database_sca->fetch($result_rutas)) 
                        $array_rutas[]=array(
                            "idruta"=>$row_rutas[idruta],
                            "clave"=>utf8_encode($row_rutas[clave]),
                            "idorigen"=>$row_rutas[idorigen],
                            "idtiro"=>$row_rutas[idtiro],
                            "totalkm"=>$row_rutas[totalkm ],                            
                            );


                 //MATERIALES
                $sql_materiales="SELECT idmaterial, descripcion FROM materiales where Estatus=1;";
                $result_materiales=$this->_database_sca->consultar($sql_materiales);
                while($row_materiales=$this->_database_sca->fetch($result_materiales)) 
                        $array_materiales[]=array(
                            "idmaterial"=>$row_materiales[idmaterial],
                            "descripcion"=>utf8_encode($row_materiales[descripcion])
                            );
                $arraydata=array(
                     "IdUsuario"=>$row[IdUsuario],
                     "Nombre"=>utf8_encode($row[nombre]),
                     "IdProyecto"=>$row_s[id_proyecto],
                     "base_datos"=>$row_s[base_datos], 
                     "descripcion_database"=>utf8_encode($row_s[descripcion_database]),
                     "Camiones"=>$array_camiones,
                     "Tiros"=>$array_tiros,
                     "Origenes"=>$array_origenes,
                     "Rutas"=>$array_rutas,
                     "Materiales"=>$array_materiales
                 );
                 //print_r($arraydata);                 
                 echo json_encode($arraydata);                                                                                                                                                           
            } else {
                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningún proyecto. \"}";
            }
        } else {
           echo "{\"error\":\"Error en iniciar sesión. No se encontró los datos que especifica.\"}";
        }

    }
    function  ConfDATA($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
         $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db ->consultar($sql);
        if ($row = $this->_db ->fetch($result)) {
              $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
            $result_s = $this->_db ->consultar($sql_s);
            if ($row_s = $this->_db ->fetch($result_s)) {
               $_SESSION["databasesca"]=$row_s[base_datos];
                $this->_database_sca = SCA::getConexion();
                //echo $_SESSION["databasesca"];
                 $sql_camiones="SELECT idcamion, Placas, M.descripcion as marca, Modelo, Ancho, largo, Alto FROM camiones C
                                INNER JOIN marcas  M ON M.IdMarca=C.IdMarca where C.Estatus=1;";
                $result_camiones=$this->_database_sca->consultar($sql_camiones);
                
                while($row_camiones=$this->_database_sca->fetch($result_camiones)) 
                        $array_camiones[]=array(
                            "idcamion"=>$row_camiones[idcamion],
                            "placas"=>$row_camiones[Placas],
                            "marca"=>utf8_encode($row_camiones[marca]),
                            "modelo"=>utf8_encode($row_camiones[Modelo]),
                            "ancho"=>utf8_encode($row_camiones[Ancho]),
                            "largo"=>utf8_encode($row_camiones[largo]),
                            "alto"=>utf8_encode($row_camiones[Alto])
                        );
                $arraydata=array(
                     "IdUsuario"=>$row[IdUsuario],
                     "Nombre"=>utf8_encode($row[nombre]),
                     "IdProyecto"=>$row_s[id_proyecto],
                     "base_datos"=>$row_s[base_datos], 
                     "descripcion_database"=>utf8_encode($row_s[descripcion_database]),
                     "Camiones"=>$array_camiones,
                 );
                 //print_r($arraydata);                 
                 echo json_encode($arraydata);  
            }else {
                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningún proyecto. \"}";
            } 
        }else {
           echo "{\"error\":\"Error en iniciar sesión. No se encontró los datos que especifica.\"}";
        }
    }
    function captura() {
        //print_r($_REQUEST);
	//echo "INSERT INTO $_REQUEST[bd].json (json) values(\'$_REQUEST[carddata]\')";
        $cadenajsonx=json_encode($_REQUEST);
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");

        if (isset($_REQUEST[carddata])){
          $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[carddata]')"); //coordenadas
          $json_viajes = $_REQUEST[carddata];
          $data_viajes = json_decode(utf8_encode($json_viajes), TRUE);
          $registros = 0;
          foreach ($data_viajes as $key => $value) {
            $x="INSERT INTO $_REQUEST[bd].viajesnetos(IdArchivoCargado, FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro,
                            FechaLlegada, HoraLlegada, IdMaterial, Observaciones,Creo,Estatus,Code)"
                    . " values(0,'$value[FechaCarga]', '$value[HoraCarga]', 1, $value[IdCamion], $value[IdOrigen], '$value[FechaSalida]','$value[HoraSalida]',
                $value[IdTiro], '$value[FechaLlegada]', '$value[HoraLlegada]', $value[IdMaterial], '$value[Observaciones]','$value[Creo]',0, '$value[Code]')";
            $this->_db->consultar($x);
            $registros++;
          }
        }

        if (isset($_REQUEST[coordenadas])){
          $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[coordenadas]')"); //coordenadas
          $json_coordenada = $_REQUEST[coordenadas];
          $data_coordenada = json_decode(utf8_encode($json_coordenada), TRUE);
          $registros = 0;
          foreach ($data_coordenada as $key => $value) {
              $x="INSERT INTO $_REQUEST[bd].eventos_gps 
                  (idevento, IMEI, longitude,latitude,fechahora, code ) values
                  ($value[idevento],'$value[IMRI]', '$value[longitude]', '$value[latitude]','$value[fechahora]', '$value[code]')";
              $this->_db->consultar($x); 
              $registros++;
          }
        }
        if ($registros > 0)
            echo "{\"msj\":\"Datos sincronizados correctamente--\"}";
        else
            echo "{\"error\":\"Se ha producido un error en el Servidor, favor de repórtalo con los administradores\"}";
    }
    function getCoordenadas(){
      //print_r($_REQUEST);
      //getCoordenadas
      $fechainicial=$_REQUEST['fechainicial'];
      $fechafinal=$_REQUEST['fechafinal'];
      $_SESSION["databasesca"]=$_REQUEST['db'];
      $this->_database_sca = SCA::getConexion();
      $sql_coordenadas="SELECT 
                          Descripcion
                          , CASE 
                            WHEN longitude > 0 THEN longitude
                            ELSE latitude
                            END AS longitude
                          , CASE 
                            WHEN longitude <= 0 THEN longitude
                            ELSE latitude
                            END AS latitude
                          , idevento
                          , ideventos_gps
                          , IMEI
                          , STR_TO_DATE(fechahora, '%Y-%m-%d') as fecha
                          , STR_TO_DATE(SUBSTRING(fechahora, 11,6),'%H:%i') as hora
                          , idusuario
                        FROM 
                            eventos_gps e
                        left join cat_eventos_gps vgps on e.idevento=vgps.id_event_gps
                        where date(STR_TO_DATE(fechahora, '%Y-%m-%d')) BETWEEN '$fechainicial' and '$fechafinal'
                         order by IMEI;";
      $result_coordenadas=$this->_database_sca->consultar($sql_coordenadas);
      while($row_coordenadas=$this->_database_sca->fetch($result_coordenadas)) 
        $array_coordenadas[]=array(
                               utf8_encode($row_coordenadas['Descripcion']." [".$row_coordenadas['hora'])."]",
                               $row_coordenadas['longitude'],
                               $row_coordenadas['latitude'],                               
                               $row_coordenadas['idevento'],
                               $row_coordenadas['ideventos_gps'],
                               $row_coordenadas['IMEI'],
                               $row_coordenadas['fecha'],
                               $row_coordenadas['hora'],
                               $row_coordenadas['idusuario']
                             );

      //getIMEI 
       $sql_IMEI="select 
          IMEI, concat(nombre,' ', apaterno ) as nombre, e.idusuario as idusuario from eventos_gps e
          left join igh.usuario u on e.idusuario=u.idusuario
           where date(STR_TO_DATE(fechahora, '%Y-%m-%d')) BETWEEN '$fechainicial' and '$fechafinal'
           group by IMEI, e.idusuario order by IMEI;";
                $result_IMEI=$this->_database_sca->consultar($sql_IMEI);
      $cont_color=1;
      while($row_IMEI=$this->_database_sca->fetch($result_IMEI)){
        $array_IMEI[]=array(
                             "IMEI"=>$row_IMEI['IMEI'],
                             "checador"=> utf8_encode($row_IMEI['nombre']),
                             "idusuario"=>$row_IMEI['idusuario'],
                             "color"=>"color".$cont_color
                             );
        $cont_color+=1;
      }


      
        $arraydata=array(         "coordenadas"=>$array_coordenadas,
                                  "IMEI"=>$array_IMEI
                         );
                               //print_r($arraydata);                 
        header('Content-Type: application/json');
        echo json_encode($arraydata);    
    }
                                
}

?>
