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
    #FUNCIÓN PARA DESCARGA DE CATÁLOGOS PARA LA APLICACIÓN DE VIAJES
    function getData($usr, $pass) {       
        
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db ->consultar($sql);
        
        if ($row = $this->_db ->fetch($result)) {
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database, p.empresa, p.tiene_logo, p.logo  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 "
                    . "And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
            $result_s = $this->_db ->consultar($sql_s);
            
            if ($row_s = $this->_db ->fetch($result_s)) {
                $_SESSION["databasesca"]=$row_s[base_datos];

                //CAMIONES
                $this->_database_sca = SCA::getConexion();
				
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
                $sql_origenes="
                                            (SELECT 
                                                origen_x_usuario.idorigen as idorigen, 
                                                    origenes.Descripcion as descripcion,
                                                    1 as estado     
                                            FROM origen_x_usuario origen_x_usuario
                                            INNER JOIN origenes origenes
                                            ON (origen_x_usuario.idorigen = origenes.IdOrigen)
                                             join 
                                            rutas on(rutas.IdOrigen = origenes.IdOrigen)
                                            WHERE (origen_x_usuario.idusuario_intranet = ".$row[IdUsuario]."))
                                            UNION(
                                            SELECT DISTINCT
                                            origenes.idOrigen as idorigen, 
                                            Descripcion as descripcion,
                                                    2 as estado
                                            FROM origenes join 
                                            rutas on(rutas.IdOrigen = origenes.IdOrigen) where origenes.idOrigen not in(

SELECT 
                                                origen_x_usuario.idorigen 
                                            FROM origen_x_usuario origen_x_usuario
                                            INNER JOIN origenes origenes
                                            ON (origen_x_usuario.idorigen = origenes.IdOrigen)
                                            WHERE (origen_x_usuario.idusuario_intranet = ".$row[IdUsuario].")
)
                                            )
                                              ";
                $result_origenes=$this->_database_sca->consultar($sql_origenes);
                
                if(mysql_num_rows($result_origenes)>0){
                    while($row_origenes=$this->_database_sca->fetch($result_origenes)) 
                        $array_origenes[]=array(
                            "idorigen"=>$row_origenes[idorigen],
                            "descripcion"=>utf8_encode($row_origenes[descripcion]),
                            "estado"=>$row_origenes[estado]
                            );
                }else{
                     $array_origenes[]=array(
                            "idorigen"=>0,
                            "descripcion"=>utf8_encode("- Seleccione -"),
                            "estado"=>1
                            );


                }

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
                
                
                //TAGS
                $sql_tags="SELECT uid, idcamion, idproyecto_global as idproyecto FROM tags WHERE estado=1;";
                $result_tags=$this->_database_sca->consultar($sql_tags);
                
                while($row_tags=$this->_database_sca->fetch($result_tags))
                    $array_tags[]=array(
                        "uid"=>$row_tags[uid],
                        "idcamion"=>$row_tags[idcamion],
                        "idproyecto"=>$row_tags[idproyecto]);   
                
                //TIPOS IMAGENES
                $sql_tipos_imagenes="SELECT id, descripcion  FROM cat_tipos_imagenes where estado = 1";
                $result_tipos_imagenes=$this->_database_sca->consultar($sql_tipos_imagenes);
                while($row_tipos_imagenes=$this->_database_sca->fetch($result_tipos_imagenes)) 
                        $array_tipos_imagenes[]=array(
                            "id"=>$row_tipos_imagenes[id],
                            "descripcion"=>utf8_encode($row_tipos_imagenes[descripcion]),
                            );

                            
                            
                $arraydata=array(
                     "IdUsuario"=>$row[IdUsuario],
                     "Nombre"=>utf8_encode($row[nombre]),
                     "IdProyecto"=>$row_s[id_proyecto],
                     "base_datos"=>$row_s[base_datos], 
                     "empresa"=>$row_s[empresa], 
                     "tiene_logo"=>$row_s[tiene_logo], 
                     "logo"=>$row_s[logo], 
                     "descripcion_database"=>utf8_encode($row_s[descripcion_database]),
                     "Camiones"=>$array_camiones,
                     "Tiros"=>$array_tiros,
                     "Origenes"=>$array_origenes,
                     "Rutas"=>$array_rutas,
                     "Materiales"=>$array_materiales,
                     "TiposImagenes"=>$array_tipos_imagenes,
                     "Tags"=>$array_tags
                 );


                 //print_r($arraydata);                 
                 echo json_encode($arraydata);                                                                                                                                                           
            } else {

                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningun proyecto.\"}";
            }
        } else {

            echo "{\"error\":\"ERROR AL INICIAR SESION.\"}"; 
        }

    }
    #FUNCIÓN PARA DESCARGA DE CATÁLOGOS PARA LA APLICACIÓN DE CONFIGURACIÓN DE TAGS
    function  ConfDATA($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        //echo $sql;

        $result = $this->_db ->consultar($sql);
        $row = $this->_db ->fetch($result);
        
//echo 'roesssss'.count($row)."ssssss";
        
        if (count($row) == 4) {
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";

            $result_s = $this->_db ->consultar($sql_s);


            
            if ($row_s = $this->_db ->fetch($result_s)) {
               
               $_SESSION["databasesca"]=$row_s[base_datos];
               $this->_database_sca = SCA::getConexion();
                
                //CAMIONES
                $sql_camiones="SELECT idcamion, Placas, M.descripcion as marca, Modelo, Ancho, largo, Alto, economico, (select count(*)
from viajesnetos where idcamion = C.idcamion) as numero_viajes FROM camiones C
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
                            "economico"=>utf8_encode($row_camiones[economico]),
                            "numero_viajes"=>$row_camiones["numero_viajes"],
                        );
                        
                //TAGS
                $sql_tags="SELECT uid, idcamion, idproyecto FROM tags WHERE estado=1;";
                $result_tags=$this->_database_sca->consultar($sql_tags);
                
                while($row_tags=$this->_database_sca->fetch($result_tags))
                    $array_tags[]=array(
                        "uid"=>$row_tags[uid],
                        "idcamion"=>$row_tags[idcamion],
                        "idproyecto"=>$row_tags[idproyecto]);   
                
                //TAGS DISPONIBLES CONFIGURAR 
                
                $sql_tags="SELECT  id, uid, idcamion FROM tags_disponibles_configurar";
                $result_tags=$this->_database_sca->consultar($sql_tags);
                
                while($row_tags=$this->_database_sca->fetch($result_tags))
                    $array_tags_disponibles_configurar[]=array(
                        "uid"=>$row_tags[uid],
                        "idcamion"=>$row_tags[idcamion],
                        "id"=>$row_tags[id]);
                                    
                        
                $arraydata=array(
                     "IdUsuario"=>$row[IdUsuario],
                     "Nombre"=>utf8_encode($row[nombre]),
                     "IdProyecto"=>$row_s[id_proyecto],
                     "base_datos"=>$row_s[base_datos], 
                     "descripcion_database"=>utf8_encode($row_s[descripcion_database]),
                     "Camiones"=>$array_camiones,
                     "tags"=>$array_tags,
                     "tags_disponibles_configurar"=>$array_tags_disponibles_configurar
                 );

                 
                                
                 echo json_encode($arraydata);  
            }else {

                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningun proyecto. \"}";
            } 
        }else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontraron los datos que especifica.\"}";
        }
    }
    #FUNCIÓN PARA DESCARGA DE CATÁLOGOS PARA LA APLICACIÓN DE REGISTRO DE TAGS
    function  paraRegistro($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        //echo $sql;

        $result = $this->_db ->consultar($sql);
        $row = $this->_db ->fetch($result);

        
        if ($this->_db->affected()>0) {
            
            $sql_valido = "select if( vigencia > NOW() OR vigencia is null, 1,0) AS valido from sca_configuracion.permisos_alta_tag where idusuario = ".$row["IdUsuario"].";";
            $result_valido = $this->_db ->consultar($sql_valido);
            $row_valido = $this->_db ->fetch($result_valido);
            if($row_valido["valido"] == 1){
                
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";

            $result_s = $this->_db ->consultar($sql_s);


            
            if ($row_s = $this->_db ->fetch($result_s)) {
               
               $_SESSION["databasesca"]=$row_s[base_datos];
               $this->_database_sca = SCA::getConexion();
                
                
                
                //PROYECTOS
                
                $sql_tags="SELECT  id_proyecto, descripcion FROM sca_configuracion.proyectos where status = 1";
                $result_tags=$this->_database_sca->consultar($sql_tags);
                
                while($row_tags=$this->_database_sca->fetch($result_tags))
                    $array_proyectos[]=array(
                        "id_proyecto"=>$row_tags[id_proyecto],
                        "descripcion"=>utf8_encode($row_tags[descripcion]),
                        );
                                    
                        
                $arraydata=array(
                     "IdUsuario"=>$row[IdUsuario],
                     "Nombre"=>utf8_encode($row[nombre]),
                     "proyectos"=>$array_proyectos
                 );

                 
                                
                 echo json_encode($arraydata);  
            }else {

                echo "{\"error\":\"Error al obtener los datos de configuración. \"}";
            } 
            }else{
                echo "{\"error\":\"No tiene los privilegios para dar de alta tags en los proyectos.\"}";
            }
        }else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontraron los datos que especifica.\"}";
        }
    }
    #FUNCIÓN PARA REGISTRAR LA CONFIGURACIÓN DE TAGS REALIZADA DESDE LA APLICACIÓN DE CONFIGURACIÓN DE TAGS
    function capturaConfiguracion($usr,$pass){
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db ->consultar($sql);
        if ($row = $this->_db ->fetch($result)) {
            $cadenajsonx=json_encode($_REQUEST);
            $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
            if(isset($_REQUEST['tag_camion'])){
                $json_datos_confuguracion = $_REQUEST['tag_camion'];
                $datos_confuguracion = json_decode(utf8_encode($json_datos_confuguracion), TRUE);
                $a_registrar = count($datos_confuguracion);
                if($a_registrar > 0){
                $registros = 0;
                foreach ($datos_confuguracion as $key => $value) {
                    $y="UPDATE  ".$_REQUEST['bd'].".tags SET estado = 0 where idcamion = ".$value['idcamion'].";";
                    //echo $x;
                    $this->_db->consultar($y);
                    $x="INSERT INTO 
                            ".$_REQUEST['bd'].".tags (uid, idcamion, idproyecto, idproyecto_global, fecha_asignacion, asigno) 
                        VALUES('".$value['uid']."',".$value['idcamion'].",1, ".$value['idproyecto_global'].",NOW(),'".$usr."');";
                    
                    $this->_db->consultar($x);
                    $registros++;
                }
                if ($registros == $a_registrar)
                    echo "{\"msj\":\"Datos sincronizados correctamente. ".$registros." - ".$a_registrar."\"}";
                else
                    echo "{\"error\":\"No se sincronizaron los todos los registros.\"}";
                }
                }else{
                    echo "{\"error\":\"No ha mandado ningún registro para sincronizar.\"}";
                }
            }
            
        ELSE{
            
            echo "{\"error\":\"Datos de inicio de sesión no validos.\"}";
        }
        
        //RETURN $registros;
    }
    #Función utilizada para registrar los datos enviados por la aplicación de registro de tags (App Registro)
    function capturaAltas($usr,$pass){
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db ->consultar($sql);
        if ($row = $this->_db ->fetch($result)) {
            
            $sql_valido = "select if( vigencia > NOW() OR vigencia is null, 1,0) AS valido from sca_configuracion.permisos_alta_tag where idusuario = ".$row["IdUsuario"].";";
            $result_valido = $this->_db ->consultar($sql_valido);
            $row_valido = $this->_db ->fetch($result_valido);
            if($row_valido["valido"] == 1){
            
            $cadenajsonx=json_encode($_REQUEST);
            $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
            if(isset($_REQUEST['tags_nuevos'])){
                $json_datos_altas = $_REQUEST['tags_nuevos'];
                $datos_altas = json_decode(utf8_encode($json_datos_altas), TRUE);
                $a_registrar = count($datos_altas);
                if($a_registrar > 0){
                $registros = 0;
                foreach ($datos_altas as $key => $value) {
                    
                    $x="INSERT INTO 
                            sca_configuracion.tags (uid, id_proyecto, estado, registro, fecha_registro) 
                        VALUES('".$value['uid']."',".$value['id_proyecto'].",1, '".$usr."',NOW());";
                    
                    $this->_db->consultar($x);
                    if($this->_db->affected()>=0)
                    $registros = $registros+$this->_db->affected();
                    $error = $error + $this->_db->mensaje;
                }
                if ($registros == $a_registrar)
                    echo "{\"msj\":\"UIDs registrados correctamente. Registrados: ".$registros." A registrar: ".$a_registrar."\"}";
                else
                    echo "{\"error\":\"No se registraron todos los uids. Registrados:".$registros." A registrar:".$a_registrar."  .\"}";
                }
                }else{
                    echo "{\"error\":\"No ha mandado ningún registro para sincronizar.\"}";
                }
                }else{
                    echo "{\"error\":\"No tiene privilegios vigentes para dar de alta tags.\"}";
                }
                
                
                
                
                
            }
            
        ELSE{
            
            echo "{\"error\":\"Datos de inicio de sesión no validos.\"}";
        }
        
        //RETURN $registros;
    }
#Función utilizada para registrar los datos enviados por la aplicación (App Viajes)
    function captura() {

        $version = $_REQUEST[Version];
        $cadenajsonx = json_encode($_REQUEST);
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");

        if (isset($_REQUEST[carddata])) {
            $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[carddata]')"); //coordenadas
            $json_viajes = $_REQUEST[carddata];
            $data_viajes = json_decode(utf8_encode($json_viajes), TRUE);
            $registros_viajes = 0;
            $afv = 0;
            $af_imagen = 0 ;
            $error = "";
            $previos = 0;
            $viajes_a_registrar = count($data_viajes);
            $cantidad_imagenes = 0;
            $arreglo_id_viaje_code = array();
            if ($viajes_a_registrar > 0) {
                foreach ($data_viajes as $key => $value) {
                    
                    #validar que viaje no exista
                    
                    $x_v = "select count(*) as existe from $_REQUEST[bd].viajesnetos  
                        where IdCamion = $value[IdCamion] and FechaSalida = '$value[FechaSalida]' "
                            . "and HoraSalida='$value[HoraSalida]' and FechaLlegada='$value[FechaLlegada]' "
                            . "and HoraLlegada='$value[HoraLlegada]' and Code = '$value[Code]';";

                    $result_valida = $this->_db ->consultar($x_v);
                    $row_valida = $this->_db ->fetch($result_valida);
                    if($row_valida["existe"] == 1){
                    //if(0==1){
                        $previos = $previos + 1;
                    }
                    else{                    
                        #insertar viaje
                        $x = "INSERT INTO 
                        $_REQUEST[bd].viajesnetos 
                    VALUES(null,
                           0,
                           NOW(), 
                           NOW(), 
                           1, 
                           $value[IdCamion], 
                           $value[IdOrigen], 
                           '$value[FechaSalida]',
                           '$value[HoraSalida]',
                           $value[IdTiro], 
                           '$value[FechaLlegada]', 
                           '$value[HoraLlegada]', 
                           $value[IdMaterial], 
                           '$value[Observaciones]',
                           '$value[Creo]',
                           0, 
                           '$value[Code]', 
                           '$value[uidTAG]',
                                               '$value[Imagen]', '$value[IMEI]', '$version', '$value[CodeImagen]');";

                        $this->_db->consultar($x);
                        $x_error="";
                        if ($this->_db->affected() > 0) {
                            $afv = $afv + $this->_db->affected();
                            $id_viaje_neto = $this->_db->retId();
                            $arreglo_id_viaje_code[$value[Code]] = $id_viaje_neto;
//                            #INSERTAR IMAGEN
//                            
//                            if(count($value["Imagenes"])>0){
//                                foreach ($value["Imagenes"] as $key_i => $value_i) {
//                                    $x_imagen = "insert into $_REQUEST[bd].viajes_netos_imagenes(idviaje_neto,idtipo_imagen,imagen) values($id_viaje_neto,".$value_i[idtipo_imagen].",'".str_replace('\\','',$value_i[imagen])."')";
//                                    $this->_db->consultar($x_imagen);
//                                    if ($this->_db->affected() > 0) {
//                                        $af_imagen = $af_imagen + $this->_db->affected();
//                                    }else{
//                                        $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x_imagen)."','$value[Creo]' )";
//                                        $this->_db->consultar($x_error);
//                                        if ($this->_db->affected() > 0) {
//                                            /*$afv = $afv + $this->_db->affected();*/
//                                        }
//                                    }
//                                    $cantidad_imagenes++;
//                                }
//                            }
                            
                        }else{
                            $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x)."','$value[Creo]' )";
                            $this->_db->consultar($x_error);
                            if ($this->_db->affected() > 0) {
                                $afv = $afv + $this->_db->affected();
                            }
                        }
                        $error = $error + $this->_db->mensaje;
                        $registros_viajes++;
                    }
                }
            }
            
            if (isset($_REQUEST[coordenadas])) {
                $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[coordenadas]')"); //coordenadas
                $json_coordenada = $_REQUEST[coordenadas];
                $data_coordenada = json_decode(utf8_encode($json_coordenada), TRUE);
                $registros_coordenadas = 0;

                if (isset($_REQUEST['idusuario']))
                    $usuario_creo = $_REQUEST['idusuario'];
                else
                    $usuario_creo = 0;

                foreach ($data_coordenada as $key => $value) {
                    $x = "INSERT INTO $_REQUEST[bd].eventos_gps 
                  (idevento, IMEI, longitude,latitude,fechahora, code, idusuario) values
                  ($value[idevento],'$value[IMEI]', '$value[longitud]', '$value[latitud]','$value[fecha_hora]', '$value[code]',$usuario_creo)";
                    $this->_db->consultar($x);
                    $registros_coordenadas++;
                }
            }
            
            #INSERTAR IMAGEN
            $json_imagenes = $_REQUEST[Imagenes];
            $imagenes = json_decode(utf8_encode($json_imagenes), TRUE); 
            $cantidad_imagenes_a_registrar = count($imagenes);
            $cantidad_imagenes_sin_viaje_neto = 0;
            $imagenes_registradas = array();
            $imagenes_no_registradas = array();
//            $x_errori = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $imagenes)."','$value[Creo]' )";
//                            $this->_db->consultar($x_errori);
            if($cantidad_imagenes_a_registrar>0){
                foreach ($imagenes as $key_i => $value_i) {
                    $id_viaje_neto_i = $arreglo_id_viaje_code[$value_i["code"]];
                    if($id_viaje_neto_i > 0){
                        $x_imagen = "insert into $_REQUEST[bd].viajes_netos_imagenes(idviaje_neto,idtipo_imagen,imagen) values($id_viaje_neto_i,".$value_i[idtipo_imagen].",'".str_replace('\\','',$value_i[imagen])."')";
                        $this->_db->consultar($x_imagen);
                        if ($this->_db->affected() > 0) {
                            $af_imagen = $af_imagen + $this->_db->affected();
                            $imagenes_registradas[] = $value_i["idImagen"];
                        }else{
                            $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x_imagen)."','$value[Creo]' )";
                            $this->_db->consultar($x_error);
                            if ($this->_db->affected() > 0) {
                                /*$afv = $afv + $this->_db->affected();*/
                            }
                        }
                        $cantidad_imagenes++;
                    }else{
                        $cantidad_imagenes_sin_viaje_neto++;
                    }
                }
            }
            
            $json_imagenes_registradas = json_encode($imagenes_registradas);

            //preg_replace("[\n|\r|\n\r]", ' ', $x_v)

            if (($afv + $previos) == $viajes_a_registrar){
                echo "{\"msj\":\"Viajes sincronizados correctamente. Registrados: " . $afv . " Registrados Previamente: ".$previos." A registrar: " . $viajes_a_registrar . "  \"}";
            }
            else{
                echo "{\"error\":\"No se registraron todos los viajes. Registrados: " . $afv . " Registrados Previamente: ".$previos." A registrar: " . $viajes_a_registrar . " \"}";
            }
        }else {
            echo "{\"error\":\"No hay ningún viaje a registrar: " . $viajes_a_registrar . " \"}";
        }

    }

    function cargaImagenesViajes(){
        
        //$version = $_REQUEST[Version];
        $cadenajsonx = json_encode($_REQUEST);
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
        $usr = $_REQUEST["usr"];
        $json_imagenes = $_REQUEST[Imagenes];
        $imagenes = json_decode(utf8_encode($json_imagenes), TRUE); 
        $cantidad_imagenes_a_registrar = count($imagenes);
        $cantidad_imagenes_sin_viaje_neto = 0;
        $cantidad_imagenes = 0;
        $imagenes_registradas = array();
        $imagenes_no_registradas = array();
        $imagenes_no_registradas_sv = array();
        if($cantidad_imagenes_a_registrar>0){
            $i = 0;
            $ir = 0;
            $inr = 0;
            foreach ($imagenes as $key_i => $value_i) {
                
                
                $sql_vn = "SELECT IdViajeNeto FROM $_REQUEST[bd].viajesnetos where CodeImagen='".$value_i[CodeImagen]."' ;";
                
                $result_vn = $this->_db ->consultar($sql_vn);
                if ($row_vn = $this->_db ->fetch($result_vn)){
                    $id_viaje_neto_i = $row_vn["IdViajeNeto"];
                }else{
                    $id_viaje_neto_i = 0;
                }
                $x_errori = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $sql_vn)."','eli' )";
                            $this->_db->consultar($x_errori);
                if($id_viaje_neto_i > 0){
                    $x_imagen = "insert into $_REQUEST[bd].viajes_netos_imagenes(idviaje_neto,idtipo_imagen,imagen) values($id_viaje_neto_i,".$value_i[idtipo_imagen].",'".str_replace('\\','',$value_i[imagen])."')";
                    $this->_db->consultar($x_imagen);
                    if ($this->_db->affected() > 0) {
                        $cantidad_imagenes = $cantidad_imagenes + $this->_db->affected();
                        $imagenes_registradas[$ir] = $value_i["idImagen"];
                        $ir++;
                    }else{
                        $imagenes_no_registradas[$inr] = $value_i["idImagen"];
                        $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x_imagen)."','$usr' )";
                        $this->_db->consultar($x_error);
                        if ($this->_db->affected() > 0) {
                            /*$afv = $afv + $this->_db->affected();*/
                        }
                        $inr++;
                    }
                    //$cantidad_imagenes++;
                }else{
                    
                    $imagenes_no_registradas_sv[$cantidad_imagenes_sin_viaje_neto] = $value_i["idImagen"];
                    $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x_imagen)."','$usr' )";
                    $this->_db->consultar($x_error);
                    $cantidad_imagenes_sin_viaje_neto++;
                }
                $i++;
            }
            $json_imagenes_registradas = json_encode($imagenes_registradas);
            $json_imagenes_no_registradas = json_encode($imagenes_no_registradas);
            $json_imagenes_no_registradas_sv = json_encode($imagenes_no_registradas_sv);
            echo "{\"msj\":\"Imagenes Sincronizadas.  Imagenes a Registrar: ".
                    $cantidad_imagenes_a_registrar." Imagenes Registradas: ".
                    $cantidad_imagenes." Imagenes Sin Viaje: ".
                    $cantidad_imagenes_sin_viaje_neto." Imagenes con Error: ".($inr)." \" , "
                    . "\"imagenes_registradas\":".$json_imagenes_registradas.", "
                    . "\"imagenes_no_registradas_sv\":".$json_imagenes_no_registradas_sv.", "
                    . "\"imagenes_no_registradas\":".$json_imagenes_no_registradas."}";
        }
    }
}

?>
