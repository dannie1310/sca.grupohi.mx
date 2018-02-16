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
        $this->_db_igh = SCA_IGH::getConexion();
    }
    #FUNCI�N PARA DESCARGA DE CAT�LOGOS PARA LA APLICACI�N DE VIAJES
    function getData($usr, $pass) {       
        $arraydata=array();
        $pass = md5($pass);
        $imei = $_REQUEST["IMEI"];
        
        #VERIFICAR QUE USUARIO EXISTA
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db_igh ->consultar($sql);
        
        if ($row = $this->_db_igh ->fetch($result)) {
            #OBTENER PROYECTOS
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database, p.empresa, p.tiene_logo, p.logo  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 "
                    . "And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
            $result_s = $this->_db ->consultar($sql_s);
            
            if ($row_s = $this->_db ->fetch($result_s)) {
                #VERIFICAR QUE TIENE ROL DE CHECADOR
                $_SESSION["databasesca"] = $row_s[base_datos];
                $sql_perfil = "SELECT role_user.user_id, cd.id_origen, cd.id_tiro, cd.id_perfil,tipo
                FROM sca_configuracion.role_user role_user left join
                " . $row_s[base_datos] . ".configuracion_diaria as cd on (role_user.user_id = cd.id_usuario)
               WHERE     (role_user.user_id = " . $row[IdUsuario] . ")
                     AND (role_user.role_id = 7)
                     AND (role_user.id_proyecto = " . $row_s[id_proyecto] . ")";
                $result_perfil = $this->_db->consultar($sql_perfil);

                if ($row_perfil = $this->_db->fetch($result_perfil)) {

                    #VERIFICAR QUE TENGA EL TELEFONO ASIGNADO A OBRA#
                    $sql_tel = "SELECT * 
                    FROM
                    " . $row_s[base_datos] . ".telefonos where imei = '" . $imei . "' and estatus = 1";
                    //  echo $sql_tel;
                    $result_tel = $this->_db->consultar($sql_tel);
                    if ($row_tel = $this->_db->fetch($result_tel) || $imei == "") {

                        #VERIFICAR QUE TENGA EL TELEFONO ASIGNADO A USUARIO#
                        $sql_tel_usuario = "SELECT * 
                    FROM
                    " . $row_s[base_datos] . ".telefonos where imei = '" . $imei . "' and estatus = 1 and id_checador = '" . $row[IdUsuario] . "'";
                        //  echo $sql_tel;
                        $result_tel_usuario = $this->_db->consultar($sql_tel_usuario);
                        if ($row_tel_USS = $this->_db->fetch($result_tel_usuario) || $imei == "") {
                            #
                            ######
                            //IMPRESORAS

                            $sql_impresoras = "SELECT imei,  mac, impresoras.id as identidificador_impresora
FROM " . $row_s[base_datos] . ".telefonos as telefonos left join " . $row_s[base_datos] . ".impresoras as impresoras on(impresoras.id = telefonos.id_impresora)
where telefonos.imei = '" . $imei . "'";

                            $result_imp = $this->_db->consultar($sql_impresoras);
                            while ($row_imp = $this->_db->fetch($result_imp)) {
                                $array_impresoras[] = array(
                                    "id" => $row_imp[identidificador_impresora],
                                    "IMEI" => $row_imp[imei],
                                    "MAC" => $row_imp[mac],
                                );
                            }

                            //CHECADORES

                            $sql_che = "SELECT
      
                        users.IdUsuario,
                        users.Descripcion
                   FROM igh.users users
                        INNER JOIN sca_configuracion.role_user role_user
                           ON (users.IdUsuario = role_user.user_id)
                  WHERE (role_user.role_id = 7) AND (role_user.id_proyecto = " . $row_s[id_proyecto] . " )";

                            $result_che = $this->_db->consultar($sql_che);
                            while ($row_che = $this->_db->fetch($result_che)) {
                                $array_checadores[] = array(
                                    "id" => $row_che[IdUsuario],
                                    "descripcion" => $row_che[Descripcion],
                                );
                            }

                            //CONFIGURACION
                            $sql_c = "select validacion_placas
                from sca_configuracion.configuracion
                where idproyecto = " . $row_s["id_proyecto"] . "";
                            $result_c = $this->_db->consultar($sql_c);
                            $row_c = $this->_db->fetch($result_c);

                            $array_configuracion = array("ValidacionPlacas" => ($row_c["validacion_placas"] == 1) ? $row_c["validacion_placas"] : "0");


                            //CAMIONES
                            $this->_database_sca = SCA::getConexion();

                            /*$sql_camiones = "SELECT idcamion, Placas,PlacasCaja, M.descripcion as marca, Modelo, Ancho, largo, Alto, Economico, CubicacionParaPago, IdEmpresa, IdSindicato, C.Estatus FROM camiones C
                                LEFT JOIN marcas  M ON M.IdMarca=C.IdMarca;";*/

                            $sql_camiones = "SELECT idcamion, Placas,PlacasCaja, M.descripcion as marca, Modelo, Ancho, largo, Alto, Economico, CubicacionParaPago, IdEmpresa, IdSindicato, C.Estatus FROM camiones C
                                            LEFT JOIN marcas  M ON M.IdMarca=C.IdMarca WHERE C.Estatus=1";
                            $result_camiones = $this->_database_sca->consultar($sql_camiones);
                            while ($row_camiones = $this->_database_sca->fetch($result_camiones))
                                $array_camiones[] = array(
                                    "idcamion" => $row_camiones[idcamion],
                                    "placas" => $row_camiones[Placas],
                                    "placas_caja" => $row_camiones[PlacasCaja],
                                    "marca" => utf8_encode($row_camiones[marca]),
                                    "modelo" => utf8_encode($row_camiones[Modelo]),
                                    "ancho" => utf8_encode($row_camiones[Ancho]),
                                    "largo" => utf8_encode($row_camiones[largo]),
                                    "alto" => utf8_encode($row_camiones[Alto]),
                                    "economico" => utf8_encode($row_camiones[Economico]),
                                    "capacidad" => utf8_encode($row_camiones[CubicacionParaPago]),
                                    "id_empresa" => utf8_encode($row_camiones[IdEmpresa]),
                                    "id_sindicato" => utf8_encode($row_camiones[IdSindicato]),
                                    "estatus" => utf8_encode($row_camiones[Estatus])
                                );


                            //TIROS
                            $sql_tiros = "Select idtiro, descripcion, IdEsquema as idesquema from tiros where estatus=1;";
                            $result_tiros = $this->_database_sca->consultar($sql_tiros);
                            while ($row_tiros = $this->_database_sca->fetch($result_tiros))
                                $array_tiros[] = array(
                                    "idtiro" => $row_tiros[idtiro],
                                    "idesquema" => $row_tiros[idesquema],
                                    "descripcion" => utf8_encode($row_tiros[descripcion])
                                );


                            //ORIGENES
                            /*$sql_origenes="
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
                                                          ";*/
                            $sql_origenes = "SELECT idOrigen as idorigen, Descripcion as descripcion, 2 as estado FROM origenes where estatus = 1";
                            $result_origenes = $this->_database_sca->consultar($sql_origenes);

                            if (mysql_num_rows($result_origenes) > 0) {
                                while ($row_origenes = $this->_database_sca->fetch($result_origenes))
                                    $array_origenes[] = array(
                                        "idorigen" => $row_origenes[idorigen],
                                        "descripcion" => utf8_encode($row_origenes[descripcion]),
                                        "estado" => $row_origenes[estado]
                                    );
                            } else {
                                $array_origenes[] = array(
                                    "idorigen" => 0,
                                    "descripcion" => utf8_encode("- Seleccione -"),
                                    "estado" => 1
                                );


                            }

                            //RUTAS
                            $sql_rutas = "SELECT clave, idruta, idorigen, idtiro, totalkm  FROM rutas";
                            $result_rutas = $this->_database_sca->consultar($sql_rutas);
                            while ($row_rutas = $this->_database_sca->fetch($result_rutas))
                                $array_rutas[] = array(
                                    "idruta" => $row_rutas[idruta],
                                    "clave" => utf8_encode($row_rutas[clave]),
                                    "idorigen" => $row_rutas[idorigen],
                                    "idtiro" => $row_rutas[idtiro],
                                    "totalkm" => $row_rutas[totalkm],
                                );


                            //MATERIALES
                            $sql_materiales = "SELECT idmaterial, descripcion FROM materiales where Estatus=1;";
                            $result_materiales = $this->_database_sca->consultar($sql_materiales);

                            while ($row_materiales = $this->_database_sca->fetch($result_materiales))
                                $array_materiales[] = array(
                                    "idmaterial" => $row_materiales[idmaterial],
                                    "descripcion" => utf8_encode($row_materiales[descripcion])
                                );


                            //TAGS
                            //$sql_tags="SELECT uid, idcamion, idproyecto_global as idproyecto FROM tags WHERE estado=1;";

                            //$sql_tags = "SELECT t.uid, t.idcamion, t.idproyecto_global as idproyecto FROM tags as t WHERE t.estado=1;";

                            $sql_tags= "SELECT t.uid, t.idcamion, t.idproyecto_global as idproyecto, c.Economico, c.Estatus FROM tags as t 
                                        JOIN camiones c on t.idcamion = c.IdCamion
                                        WHERE t.estado=1;";

                            $result_tags = $this->_database_sca->consultar($sql_tags);

                            while ($row_tags = $this->_database_sca->fetch($result_tags))
                                $array_tags[] = array(
                                    "uid" => $row_tags[uid],
                                    "idcamion" => $row_tags[idcamion],
                                    "idproyecto" => $row_tags[idproyecto],
                                    "Economico" => $row_tags[Economico],
                                    "Estatus" => $row_tags[Estatus]);

                            //TIPOS IMAGENES
                            $sql_tipos_imagenes = "SELECT id, descripcion  FROM cat_tipos_imagenes where estado = 1";
                            $result_tipos_imagenes = $this->_database_sca->consultar($sql_tipos_imagenes);
                            while ($row_tipos_imagenes = $this->_database_sca->fetch($result_tipos_imagenes))
                                $array_tipos_imagenes[] = array(
                                    "id" => $row_tipos_imagenes[id],
                                    "descripcion" => utf8_encode($row_tipos_imagenes[descripcion]),
                                );

                            //MOTIVOS DEDUCTIVA
                            $sql_d = "SELECT id, motivo FROM deductivas_motivos where estatus=1;";
                            $result_d = $this->_database_sca->consultar($sql_d);

                            while ($row_d = $this->_database_sca->fetch($result_d))
                                $array_d[] = array(
                                    "id" => $row_d[id],
                                    "motivo" => utf8_encode($row_d[motivo])
                                );


                            $arraydata = array(
                                "IdUsuario" => $row[IdUsuario],
                                "Nombre" => utf8_encode($row[nombre]),
                                "IdProyecto" => $row_s[id_proyecto],
                                "base_datos" => $row_s[base_datos],
                                "empresa" => $row_s[empresa],
                                "tiene_logo" => $row_s[tiene_logo],
                                "IdOrigen" => $row_perfil[id_origen],
                                "IdTiro" => $row_perfil[id_tiro],
                                "IdPerfil" => $row_perfil[id_perfil],
                                "logo" => $row_s[logo],
                                "descripcion_database" => utf8_encode($row_s[descripcion_database]),
                                "Camiones" => $array_camiones,
                                "Tiros" => $array_tiros,
                                "Origenes" => $array_origenes,
                                "Rutas" => $array_rutas,
                                "Materiales" => $array_materiales,
                                "TiposImagenes" => $array_tipos_imagenes,
                                "Tags" => $array_tags,
                                "MotivosDeductiva" => $array_d,
                                "Configuracion" => $array_configuracion,
                                "Checadores" => $array_checadores,
                                "Celulares" => $array_impresoras,
                            );


                            //print_r($arraydata);
                            echo json_encode($arraydata);

                        } else {
                            echo "{\"error\":\"El usuario no tiene asignado esté teléfono. Favor de Solicitarlo.\"}";
                        }
                    } else {
                        echo utf8_encode("{\"error\":\"El teléfono no tiene autorización para operar.\"}");
                    }
                    ####
                } else {
                    echo "{\"error\":\"El usuario no tiene perfil de CHECADOR favor de solicitarlo.\"}";
                }
            }
            else {

                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningun proyecto.\"}";
            }
        } else {

            echo "{\"error\":\"ERROR AL INICIAR SESION.\"}"; 
        }

    }
    #FUNCI�N PARA LOGUEO Y DESCARGA DE CAT�LOGOS PARA LA APLICACI�N DE CONFIGURACI�N DE TAGS
    function  ConfDATA($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";

        $result = $this->_db_igh ->consultar($sql);
        $row = $this->_db_igh ->fetch($result);
        
        if (count($row) == 4) {
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";

            $result_s = $this->_db ->consultar($sql_s);
            
            if ($row_s = $this->_db ->fetch($result_s)) {
               
               $_SESSION["databasesca"]=$row_s[base_datos];
               $this->_database_sca = SCA::getConexion();
               $sql_perfil = "SELECT role_user.user_id
                FROM sca_configuracion.role_user role_user
               WHERE     (role_user.user_id = ".$row[IdUsuario].")
                     AND (role_user.role_id = 10)
                     AND (role_user.id_proyecto = ".$row_s[id_proyecto].")";
                $result_perfil = $this->_db ->consultar($sql_perfil);
                
                if($row_perfil = $this->_db ->fetch($result_perfil)){
               
               ########################
                
                //CAMIONES
                $sql_camiones="SELECT idcamion, Placas, M.descripcion as marca, Modelo, Ancho, largo, Alto, economico, 0 as numero_viajes FROM camiones C
                                LEFT JOIN marcas  M ON M.IdMarca=C.IdMarca where C.Estatus=1;";
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
                 ##############################
                }else{
                    echo "{\"error\":\"El usuario no tiene el perfil para asignar tags \"}";
                }
            }else {

                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningun proyecto. \"}";
            } 
        }else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontraron los datos que especifica.\"}";
        }
    }
    #FUNCI�N PARA LOGUEO Y DESCARGA DE CAT�LOGOS PARA LA APLICACI�N DE REGRISTOR DE CAMIONES
    function  paraRegistroCamiones($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        //echo $sql;

        $result = $this->_db_igh ->consultar($sql);
        $row = $this->_db_igh ->fetch($result);

        
        if ($this->_db_igh->affected()>0) {
            
//            $sql_valido = "select if( vigencia > NOW() OR vigencia is null, 1,0) AS valido from sca_configuracion.permisos_alta_tag where idusuario = ".$row["IdUsuario"].";";
//            $result_valido = $this->_db ->consultar($sql_valido);
//            $row_valido = $this->_db ->fetch($result_valido);
//            if($row_valido["valido"] == 1){
                
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";

            $result_s = $this->_db ->consultar($sql_s);


            
            if ($row_s = $this->_db ->fetch($result_s)) {
               
               $_SESSION["databasesca"]=$row_s[base_datos];
               ####################
                $sql_perfil = "SELECT role_user.user_id
                FROM sca_configuracion.role_user role_user
               WHERE     (role_user.user_id = ".$row[IdUsuario].")
                     AND (role_user.role_id = 19)
                     AND (role_user.id_proyecto = ".$row_s[id_proyecto].")";
                $result_perfil = $this->_db ->consultar($sql_perfil);
                if($row_perfil = $this->_db ->fetch($result_perfil)){
               ######################
               
               $this->_database_sca = SCA::getConexion();
                
                //SINDICATOS
               
               $sql = "SELECT sindicatos.Descripcion as sindicato, sindicatos.IdSindicato as id from sindicatos where Estatus = 1;
 ";
               $result=$this->_database_sca->consultar($sql);
                
                while($row_sindicato=$this->_database_sca->fetch($result)){
                    $array_sindicatos[]=array(
                        "id"=>utf8_encode($row_sindicato[id]),
                        "sindicato"=>utf8_encode($row_sindicato[sindicato]),
                        );
                }
                
                //EMPRESAS
               
               $sqlE = "SELECT empresas.razonSocial as empresa, empresas.IdEmpresa as id from empresas where Estatus = 1;
 ";
               $resultE=$this->_database_sca->consultar($sqlE);
                
                while($row_empresa=$this->_database_sca->fetch($resultE)){
                    $array_empresas[]=array(
                        "id"=>utf8_encode($row_empresa[id]),
                        "empresa"=>utf8_encode($row_empresa[empresa]),
                        );
                }
                
                //CAMIONES
                
                $sql_tags="SELECT 
                    camiones.IdSindicato,
                    camiones.IdEmpresa,
                    sindicatos.Descripcion AS sindicato,
       empresas.razonSocial AS empresa,
       camiones.Propietario AS propietario,
       camiones.Economico AS economico,
       camiones.Placas AS placas_camion,
       camiones.PlacasCaja AS placas_caja,
       marcas.Descripcion AS marca,
       camiones.Modelo AS modelo,
       camiones.Ancho AS ancho,
       camiones.Largo AS largo,
       camiones.Alto AS alto,
       camiones.EspacioDeGato AS espacio_gato,
       camiones.AlturaExtension AS altura_extension,
       camiones.Disminucion AS disminucion,
       camiones.CubicacionReal AS cubicacion_real,
       camiones.CubicacionParaPago AS cubicacion_para_pago,
       operadores.Nombre AS operador,
       operadores.NoLicencia AS numero_licencia,
       operadores.VigenciaLicencia AS vigencia_licencia,
       camiones.IdCamion AS id_camion,
       camiones.Estatus as estatus
  FROM (((camiones camiones
          LEFT OUTER JOIN sindicatos sindicatos
             ON (camiones.IdSindicato = sindicatos.IdSindicato))
         LEFT OUTER JOIN marcas marcas
            ON (camiones.IdMarca = marcas.IdMarca))
        LEFT OUTER JOIN empresas empresas
           ON (camiones.IdEmpresa = empresas.IdEmpresa))
       LEFT OUTER JOIN operadores operadores
          ON (camiones.IdOperador = operadores.IdOperador) ";
                $result_tags=$this->_database_sca->consultar($sql_tags);
                
                while($row_tags=$this->_database_sca->fetch($result_tags))
                    $array_camiones[]=array(
                        "id_camion"=>utf8_encode($row_tags[id_camion]),
                        "id_sindicato"=>utf8_encode($row_tags[IdSindicato]),
                        "id_empresa"=>utf8_encode($row_tags[IdEmpresa]),
                        "sindicato"=>utf8_encode($row_tags[sindicato]),
                        "empresa"=>utf8_encode($row_tags[empresa]),
                        "propietario"=>utf8_encode($row_tags[propietario]),
                        "operador"=>utf8_encode($row_tags[operador]),
                        "numero_licencia"=>utf8_encode($row_tags[numero_licencia]),
                        "vigencia_licencia"=>utf8_encode($row_tags[vigencia_licencia]),
                        "economico"=>utf8_encode($row_tags[economico]),
                        "placas_camion"=>utf8_encode($row_tags[placas_camion]),
                        "placas_caja"=>utf8_encode($row_tags[placas_caja]),
                        "marca"=>utf8_encode($row_tags[marca]),
                        "modelo"=>utf8_encode($row_tags[modelo]),
                        "ancho"=>utf8_encode($row_tags[ancho]),
                        "largo"=>utf8_encode($row_tags[largo]),
                        "alto"=>utf8_encode($row_tags[alto]),
                        "espacio_gato"=>utf8_encode($row_tags[espacio_gato]),
                        "altura_extension"=>utf8_encode($row_tags[altura_extension]),
                        "disminucion"=>utf8_encode($row_tags[disminucion]),
                        "cubicacion_real"=>utf8_encode($row_tags[cubicacion_real]),
                        "cubicacion_para_pago"=>utf8_encode($row_tags[cubicacion_para_pago]),
                        "estatus"=>utf8_encode($row_tags[estatus]),
                        );
                
                $sql_tipos_imagenes="select 'f' as id, 'Frente' as descripcion
                union 
                select 'd','Derecha'
                union 
                select 'i','Izquierda'
                union 
                select 'a','Atras'";
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
                    "descripcion_database"=>utf8_encode($row_s[descripcion_database]),
                    "camiones"=>$array_camiones,
                    "sindicatos"=>$array_sindicatos,
                    "empresas"=>$array_empresas,
                    'tipos_imagen'=>$array_tipos_imagenes,
                 );

                 
                                
                 echo json_encode($arraydata); 
            }else{
                echo utf8_encode("{\"error\":\"El usuario no tiene el perfil para utilizar el cat�logo de camiones \"}");
            }
            }else {

                echo "{\"error\":\"Error al obtener los datos. \"}";
            } 
//            }else{
//                echo "{\"error\":\"No tiene los privilegios para dar de alta tags en los proyectos.\"}";
//            }
        }else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontraron los datos que especifica.\"}";
        }
    }
    #FUNCI�N PARA LOGUEO Y DESCARGA DE CAT�LOGOS PARA LA APLICACI�N DE REGISTRO DE TAGS
    function  paraRegistro($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        //echo $sql;

        $result = $this->_db_igh ->consultar($sql);
        $row = $this->_db_igh ->fetch($result);

        
        if ($this->_db_igh->affected()>0) {
            
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

                echo "{\"error\":\"Error al obtener los datos de configuraci�n. \"}";
            } 
            }else{
                echo "{\"error\":\"No tiene los privilegios para dar de alta tags en los proyectos.\"}";
            }
        }else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontraron los datos que especifica.\"}";
        }
    }
    #FUNCI�N PARA REGISTRAR LA CONFIGURACI�N DE TAGS REALIZADA DESDE LA APLICACI�N DE CONFIGURACI�N DE TAGS
    function capturaConfiguracion($usr,$pass){
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db_igh ->consultar($sql);
        if ($row = $this->_db_igh ->fetch($result)) {
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
                    echo "{\"error\":\"No ha mandado ning�n registro para sincronizar.\"}";
                }
            }
            
        ELSE{
            
            echo "{\"error\":\"Datos de inicio de sesi�n no validos.\"}";
        }
        
        //RETURN $registros;
    }
    #Funci�n utilizada para registrar los datos enviados por la aplicaci�n de registro de tags (App Registro)
    function capturaAltas($usr,$pass){
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db_igh ->consultar($sql);
        if ($row = $this->_db_igh ->fetch($result)) {
            
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
                $previos = 0;
                foreach ($datos_altas as $key => $value) {
                    
                    
                     $x_v = "select count(*) as existe from sca_configuracion.tags 
                        where uid = '".$value['uid']."';";

                    $result_valida = $this->_db ->consultar($x_v);
                    $row_valida = $this->_db ->fetch($result_valida);
                    if($row_valida["existe"] == 1){
                        $previos = $previos + 1;
                    }else{
                    
                    
                        $x="INSERT INTO 
                                sca_configuracion.tags (uid, id_proyecto, estado, registro, fecha_registro) 
                            VALUES('".$value['uid']."',".$value['id_proyecto'].",1, '".$usr."',NOW());";

                        $this->_db->consultar($x);
                        if($this->_db->affected()>=0){
                            $registros = $registros+$this->_db->affected();
                        }
                    }
                }
                if (($registros + $previos) == $a_registrar)
                    echo "{\"msj\":\"UIDs registrados correctamente. Registrados: ".$registros." Registrados Previamente: ".$previos." A registrar: ".$a_registrar."\"}";
                else
                    echo "{\"error\":\"No se registraron todos los uids. Registrados:".$registros." A registrar:".$a_registrar."  .\"}";
                }
                }else{
                    echo "{\"error\":\"No ha mandado ning�n registro para sincronizar.\"}";
                }
                }else{
                    echo "{\"error\":\"No tiene privilegios vigentes para dar de alta tags.\"}";
                }
                
                
                
                
                
            }
            
        ELSE{
            
            echo "{\"error\":\"Datos de inicio de sesi�n no validos.\"}";
        }
        
        //RETURN $registros;
    }
#Funci�n utilizada para registrar los datos enviados por la aplicaci�n (App Viajes)
    function captura() {

        $version = $_REQUEST[Version];
        $cadenajsonx = json_encode($_REQUEST);
        $viajes_a_registrar = 0;
        $inicio_registrar = 0;
        $imei = $_REQUEST["IMEI"];
        if($imei == ""){

            $json_viajes = $_REQUEST[carddata];
            $data_viajes = json_decode(utf8_encode($json_viajes), TRUE);
            //$data_viajes = $_REQUEST[carddata];
            if(count($data_viajes)>0 ) {
                foreach ($data_viajes as $key => $value) {
                    $imei = $value[IMEI];
                }
            }else{
                $json_inicio_camion = $_REQUEST["inicioCamion"];
                $inicio_camion = json_decode(utf8_encode($json_inicio_camion), TRUE);
                //$inicio_camion = $_REQUEST["inicioCamion"];
                if(count($inicio_camion)>0 ) {
                    foreach ($inicio_camion as $key => $value) {
                        $imei = $value[IMEI];
                    }
                }
            }
        }

        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
        #VERIFICAR QUE TENGA EL TEL�FONO ASIGNADO

        ######
        $sql_tel = "SELECT *  FROM ".$_REQUEST['bd'].".telefonos where imei = '".$imei."' and estatus = 1";

        $result_tel = $this->_db ->consultar($sql_tel);

        if($row_tel = $this->_db ->fetch($result_tel)){

        if (isset($_REQUEST[carddata]) || isset($_REQUEST[inicioCamion])) {
            $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[carddata]')"); //coordenadas
            $json_viajes = $_REQUEST[carddata];
            $data_viajes = json_decode(utf8_encode($json_viajes), TRUE);
            //$data_viajes = $_REQUEST[carddata];
            $registros_viajes = 0;
            $registros_inicio = 0;
            $afv = 0;
            $afi=0;
            $af_imagen = 0 ;
            $error = "";
            $previos = 0;
            $previos_i = 0;
            $viajes_a_registrar = count($data_viajes);
            $cantidad_imagenes = 0;
            $arreglo_id_viaje_code = array();
            $arreglo_id_inicio = array();
            $idempresa = 'NULL';
            $idsindicato = 'NULL';
            $i_deductiva = 0;
            $deductivas = array();
            $volumen_array = array();
            $json_inicio_camion = $_REQUEST["inicioCamion"];
            $inicio_camion = json_decode(utf8_encode($json_inicio_camion), TRUE);// comentar para pruebas*/
            //$inicio_camion = $_REQUEST["inicioCamion"];
            $inicio_registrar = count($inicio_camion);

            if(count($inicio_camion)>0 ){
                foreach($inicio_camion as $key => $value){
                    #validar si existe el viaje
                    $code = (array_key_exists("Code", $value))?"'".$value["Code"]."'":"NULL";
                    if($code != "NULL"){
                        $x_i = "select count(*) as existe from $_REQUEST[bd].inicio_camion  
                        where IdCamion = $value[idcamion] and fecha_origen = '$value[fecha_origen]' and Code = '$value[Code]';";
                    }else{
                        $x_i = "select count(*) as existe from $_REQUEST[bd].inicio_camion  
                        where IdCamion = $value[idcamion] and fecha_origen = '$value[fecha_origen]';";
                    }

                    $result_v_inicio = $this->_db->consultar($x_i);
                    $row_valida_i = $this->_db->fetch($result_v_inicio);
                    if($row_valida_i["existe"] > 0){
                        //if(0==1){
                        $previos_i = $previos_i + 1;
                    }
                    else {
                        #insertar inicio
                        $folioMina = (array_key_exists("foliomina", $value)) ? "'" . $value["foliomina"] . "'" : "NULL";
                        $folioSeguimiento = (array_key_exists("folioseguimiento", $value)) ? "'" . $value["folioseguimiento"] . "'" : "NULL";
                        $volumen = (array_key_exists("volumen", $value)) ? "'" . $value["volumen"] . "'" : "NULL";
                        $code = (array_key_exists("Code", $value)) ? "'" . $value["Code"] . "'" : "NULL";
                        $tipo = (array_key_exists("tipo_suministro", $value)) ? "'" . $value["tipo_suministro"] . "'" : "NULL";
                        $num = (array_key_exists("numImpresion", $value)) ? "'" . $value["numImpresion"] . "'" : "NULL";
                        $deductiva = (array_key_exists("deductiva", $value))?"'".$value["deductiva"]."'":"NULL";
                        $idmotivo = (array_key_exists("idMotivo", $value)) && $value["idMotivo"] != 0 ?"'".$value["idMotivo"]."'":"NULL";
                        $deductiva_entrada = (array_key_exists("deductiva_entrada", $value)) ?"'".$value["deductiva_entrada"]."'":"NULL";
                        $version = $_REQUEST[Version];

                        $ic = "INSERT INTO $_REQUEST[bd].`inicio_camion`
                        (
                        `idcamion`,
                        `idmaterial`,
                        `idorigen`,
                        `fecha_origen`,
                        `idusuario`,
                        `uidTAG`,
                        `IMEI`,
                        `idperfil`,
                        `folioMina`,
                        `folioSeguimiento`,
                        `volumen`,
                        `code`,
                        `numImpresion`,
                         `tipo`,
                            `estatus`,
                            `Version`,
                            `deductiva`,
                            `idMotivo_deductiva`,
                             `FechaCarga`,
                             `deductiva_entrada`)
                        VALUES
                        (
                        $value[idcamion],
                        $value[idmaterial],
                        $value[idorigen],
                        '$value[fecha_origen]',
                        '$value[idusuario]',
                        '$value[uidTAG]',
                        '$value[IMEI]',
                        $value[idperfil],
                        $folioMina,
                        $folioSeguimiento,
                        $volumen,
                        $code,
                        $num,
                        $tipo,
                            '0',
                            '$version',
                            $deductiva,
                            $idmotivo,
                            NOW(),
                            $deductiva_entrada);";

                        $this->_db->consultar($ic);

                        $ic_error = "";
                        if ($this->_db->affected() > 0) {
                            $afi = $afi + $this->_db->affected();
                            $id_inicio = $this->_db->retId();
                            $arreglo_id_inicio[$value[Code]] = $id_inicio;

                        } else {
                            $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('" . str_replace("'", "\'", $ic) . "','$value[Creo]' )";
                            $this->_db->consultar($x_error);
                            if ($this->_db->affected() > 0) {
                                $afi = $afi + $this->_db->affected();
                            }

                        }
                        $error = $error + $this->_db->mensaje;
                        $registros_inicio++;
                    }
                }
            }
            if ($viajes_a_registrar > 0) {
                
                foreach ($data_viajes as $key => $value) {
                    
                    #validar que viaje no exista
                    
                    $x_v = "select count(*) as existe from $_REQUEST[bd].viajesnetos  
                        where IdCamion = $value[IdCamion] and FechaSalida = '$value[FechaSalida]' "
                            . "and HoraSalida='$value[HoraSalida]' and FechaLlegada='$value[FechaLlegada]' "
                            . "and HoraLlegada='$value[HoraLlegada]' and Code = '$value[Code]';";

                    $result_valida = $this->_db->consultar($x_v);
                    $row_valida = $this->_db->fetch($result_valida);
                    if($row_valida["existe"] > 0){
                    //if(0==1){
                        $previos = $previos + 1;
                    }
                    else{  
                        #obtener sindicato y empresa del camion
                        $cubicacion_camion = 0;
                        $idempresa = $this->_db->regresaDatos2($_REQUEST[bd].".camiones","IdEmpresa","IdCamion",$value[IdCamion]);
                        $idsindicato = $this->_db->regresaDatos2($_REQUEST[bd].".camiones","IdSindicato","IdCamion",$value[IdCamion]);
                        $cubicacion_camion_tel = (array_key_exists("CubicacionCamion", $value))?"'".$value["CubicacionCamion"]."'":"'0'";
                        $cubicacion_camion_cam = $this->_db->regresaDatos2($_REQUEST[bd].".camiones","CubicacionParaPago","IdCamion",$value[IdCamion]);
                        $idperfil = (array_key_exists("IdPerfil", $value))?"'".$value["IdPerfil"]."'":"NULL";
                        $code_random = (array_key_exists("CodeRandom", $value))?"'".$value["CodeRandom"]."'":"'NA'";
                        $creo_primer_toque = (array_key_exists("CreoPrimerToque", $value))?$value["CreoPrimerToque"]:0;
                        $id_origen = ($value["IdOrigen"]==0)?'NULL':$value["IdOrigen"];
                        $folioMina = (array_key_exists("folioMina", $value))?"'".$value["folioMina"]."'":"NULL";
                        $folioSeguimiento = (array_key_exists("folioSeguimiento", $value))?"'".$value["folioSeguimiento"]."'":"NULL";
                        $num = (array_key_exists("numImpresion", $value))?"'".$value["numImpresion"]."'":"NULL";
                        $tipoViaje = (array_key_exists("tipoViaje", $value))?"'".$value["tipoViaje"]."'":"NULL";

                        if(!($idempresa>0)){$idempresa = 'NULL';}
                        if(!($idsindicato>0)){$idsindicato = 'NULL';}
                        if(!($cubicacion_camion>0)){$cubicacion_camion = 0;}
                        if(!($creo_primer_toque>0)){$creo_primer_toque = 'NULL';}
                        if($cubicacion_camion_tel == "'0'"){
                            $cubicacion_camion = $cubicacion_camion_cam;
                        }else{
                            $cubicacion_camion = $cubicacion_camion_tel;
                        }
                        #insertar viaje
                        $x = "INSERT INTO 
                        $_REQUEST[bd].viajesnetos(IdArchivoCargado, FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro,
                            FechaLlegada, HoraLlegada, IdMaterial, Observaciones,Creo,Estatus,Code,uidTAG,Imagen01,imei,Version,CodeImagen,IdEmpresa,IdSindicato,CodeRandom,
                            CreoPrimerToque, CubicacionCamion, IdPerfil, folioMina, folioSeguimiento, numImpresion, tipoViaje)
                    VALUES(
                           0,
                           NOW(), 
                           NOW(), 
                           1, 
                           $value[IdCamion], 
                           $id_origen, 
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
                           '$value[Imagen]',
                           '$value[IMEI]', 
                           '$version', 
                           '$value[CodeImagen]',
                           $idempresa,
                           $idsindicato,
                           $code_random,
                           $creo_primer_toque,
                           $cubicacion_camion,
                           $idperfil,
                           $folioMina, 
                           $folioSeguimiento, 
                           $num,
                           $tipoViaje);";

                        $this->_db->consultar($x);
                        $x_error="";
                        if ($this->_db->affected() > 0) {
                            $afv = $afv + $this->_db->affected();
                            $id_viaje_neto = $this->_db->retId();
                            $arreglo_id_viaje_code[$value[Code]] = $id_viaje_neto;
                            $sumaDeductiva = 0;
                            $idmotivo = 0;
                            #GENERA DEDUCTIVAS
                            if($value["deductiva_entrada"]!= 0 || $value["deductiva_origen"]!=0 || $value["Deductiva"]!=0){
                                if(array_key_exists("Deductiva", $value) && $value["Deductiva"]!=0){
                                        $deductivas[$id_viaje_neto]["Deductiva"] = $value["Deductiva"];
                                        $deductivas[$id_viaje_neto]["IdMotivoDeductiva"] = $value["IdMotivoDeductiva"];
                                        $sumaDeductiva = $sumaDeductiva + $value["Deductiva"];
                                        if($value["IdMotivoDeductiva"]!= 0) {
                                            $idmotivo = $value["IdMotivoDeductiva"];
                                        }
                                }else{
                                    $deductivas[$id_viaje_neto]["Deductiva"] = '0';
                                    $deductivas[$id_viaje_neto]["IdMotivoDeductiva"] = '0';
                                }
                                if(array_key_exists("deductiva_origen", $value) && $value["deductiva_origen"]!=0 ){
                                        $deductivas[$id_viaje_neto]["deductiva_origen"] = $value["deductiva_origen"];
                                        $deductivas[$id_viaje_neto]["idmotivo_origen"] = $value["idmotivo_origen"];
                                        $sumaDeductiva = $sumaDeductiva + $value["deductiva_origen"];
                                        if($value["idmotivo_origen"] != 0) {
                                            $idmotivo = $value["idmotivo_origen"];
                                        }
                                }else{
                                    $deductivas[$id_viaje_neto]["deductiva_origen"] = '0';
                                    $deductivas[$id_viaje_neto]["idmotivo_origen"] = '0';
                                }
                                if(array_key_exists("deductiva_entrada", $value) && $value["deductiva_entrada"]!= 0){
                                        $deductivas[$id_viaje_neto]["deductiva_entrada"] = $value["deductiva_entrada"];
                                        $deductivas[$id_viaje_neto]["idmotivo_entrada"] = $value["idmotivo_entrada"];
                                        $sumaDeductiva = $sumaDeductiva + $value["deductiva_entrada"];
                                        if($value["idmotivo_entrada"] != 0) {
                                            $idmotivo = $value["idmotivo_entrada"];
                                        }
                                }else{
                                    $deductivas[$id_viaje_neto]["deductiva_entrada"] = '0';
                                    $deductivas[$id_viaje_neto]["idmotivo_entrada"] = '0';
                                }
                                $deductivas[$id_viaje_neto]["suma"] = $sumaDeductiva;
                                $deductivas[$id_viaje_neto]["motivo_suma"] = $idmotivo;
                            }
                            if($value["volumen_origen"]!=0 || $value["volumen_entrada"]!=0 || $value["volumen"]!=0) {
                                if (array_key_exists("volumen_origen", $value) && $value["volumen_origen"] != 0) {
                                    $volumen_array[$id_viaje_neto]["v_o"] = $value["volumen_origen"];
                                }else{
                                    $volumen_array[$id_viaje_neto]["v_o"] = '0';
                                }
                                if (array_key_exists("volumen_entrada", $value) && $value["volumen_entrada"] != 0) {
                                    $volumen_array[$id_viaje_neto]["v_e"] = $value["volumen_entrada"];
                                }else{
                                    $volumen_array[$id_viaje_neto]["v_e"] = '0';
                                }
                                if (array_key_exists("volumen", $value) && $value["volumen"] != 0) {
                                    $volumen_array[$id_viaje_neto]["v"] = $value["volumen"];
                                }else{
                                    $volumen_array[$id_viaje_neto]["v"] = '0';
                                }
                            }

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
                //$data_coordenada = $_REQUEST[coordenadas];
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
            #PROCESA DEDUCTIVAS
             foreach ($deductivas as $key_d => $value_d) {
                 $xd = "INSERT INTO $_REQUEST[bd].deductivas_viajes_netos 
                  (id_viaje_neto, id_motivo, deductiva, id_registro, deductiva_origen, idmotivo_origen,
                   deductiva_entrada, idmotivo_entrada, idmotivo_salida, deductiva_salida) values
                  ($key_d, ".$value_d["motivo_suma"].",".$value_d["suma"].", '$value[Creo]',
                   ".$value_d["deductiva_origen"].", ".$value_d["idmotivo_origen"].",
                  ".$value_d["deductiva_entrada"].",".$value_d["idmotivo_entrada"].",
                  ".$value_d["IdMotivoDeductiva"].",".$value_d["Deductiva"].")";
                    $this->_db->consultar($xd);
                if ($this->_db->affected() > 0) {
                            
                }else{
                    $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $xd)."','$value[Creo]' )";
                    $this->_db->consultar($x_error);
                    
                }
             }

            #PROCESA VOLUMEN
            foreach ($volumen_array as $key_v => $value_v) {
                $xd = "INSERT INTO $_REQUEST[bd].volumen_detalle (id_viaje_neto, volumen_origen, volumen_entrada, volumen, idregistro) values ($key_v, ".$value_v["v_o"].",".$value_v["v_e"].", ".$value_v["v"].", '$value[Creo]')";
                $this->_db->consultar($xd);
                if ($this->_db->affected() > 0) {

                }else{
                    $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $xd)."','$value[Creo]' )";
                    $this->_db->consultar($x_error);

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

                if (($afv + $previos) == $viajes_a_registrar || ($afi + $previos_i) == $inicio_registrar){
                    if($viajes_a_registrar == 0){
                        echo "{\"msj\":\"Suministro sincronizados correctamente. Registrados: " . $afi . " Registrados Previamente: ".$previos_i." A registrar: " . $inicio_registrar . " \"}";
                    }elseif ($inicio_registrar == 0){
                        echo "{\"msj\":\"Viajes sincronizados correctamente. Registrados: " . $afv . " Registrados Previamente: ".$previos." A registrar: " . $viajes_a_registrar . ".\"}";
                    }else{
                        echo "{\"msj\":\"Viajes sincronizados correctamente: Registrados: " . $afv . " Registrados Previamente: ".$previos." A registrar: " . $viajes_a_registrar . ". Los Suministro sincronizados correctamente: Registrados: " . $afi . " Registrados Previamente: ".$previos_i." A registrar: " . $inicio_registrar . " \"}";
                    }
                }
                else{
                    echo "{\"error\":\"No se registraron todos los viajes. Registrados: " . $afv . " Registrados Previamente: ".$previos." A registrar: " . $viajes_a_registrar . " No se registraron todos los suministros. Registrados: " . $afi . " Registrados Previamente: ".$previos_i." A registrar: " . $inicio_registrar . " \"}";
                }

            }else {
                echo "{\"error\":\"No hay ning�n viaje a registrar: " . $viajes_a_registrar . " \"}";
            }
        }else {
            echo "{\"error\":\"El teléfono no tiene autorización para operar imei: " . $imei . " \"}";
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
//                $x_errori = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $sql_vn)."','eli' )";
//                            $this->_db->consultar($x_errori);
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
    #Funci�n utilizada para registrar los datos enviados por la aplicaci�n de actualizaci�n de camiones
    function capturaActualizacionCamiones($usr,$pass){
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db_igh ->consultar($sql);
        if ($row = $this->_db_igh ->fetch($result)) {
            
            ##################
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";

            $result_s = $this->_db ->consultar($sql_s);


            
            if ($row_s = $this->_db ->fetch($result_s)) {
            ####################
                $sql_perfil = "SELECT role_user.user_id
                FROM sca_configuracion.role_user role_user
               WHERE     (role_user.user_id = ".$row[IdUsuario].")
                     AND (role_user.role_id = 19)
                     AND (role_user.id_proyecto = ".$row_s[id_proyecto].")";
                $result_perfil = $this->_db ->consultar($sql_perfil);
                
                if($row_perfil = $this->_db ->fetch($result_perfil)){
               
               
               
               
               ######################
            //if($this->accesoValidoActualizacionCamiones($row["IdUsuario"], $_REQUEST[id_proyecto])){
                $cadenajsonx=json_encode($_REQUEST);
                $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
                if(isset($_REQUEST['camiones_editados']) || isset($_REQUEST['solicitud_activacion'])){
                    $json_datos_actualizacion = $_REQUEST['camiones_editados'];
                    $datos_actualizacion = json_decode(utf8_encode($json_datos_actualizacion), TRUE);
                    $a_registrar = count($datos_actualizacion);
                    if($a_registrar > 0){
                        $actualizados = 0;
                        $previos = 0;
                        $error = 0;
                        foreach ($datos_actualizacion as $key => $value) {
                            $datos_preparados = $this->preparaDatos($_REQUEST[bd],$value);

                            /*$a="UPDATE $_REQUEST[bd].camiones "
                                . "SET "
                                . "IdSindicato = ".$datos_preparados["id_sindicato"].", "
                                . "IdEmpresa = ".$datos_preparados["id_empresa"].", "
                                . "Propietario ='".$datos_preparados["propietario"]."', "
                                . "IdOperador = ".$datos_preparados["id_operador"].", "
                                . "Placas ='".$datos_preparados["placas_camion"]."', "
                                . "PlacasCaja='".$datos_preparados["placas_caja"]."', "
                                . "IdMarca=".$datos_preparados["id_marca"].", "
                                . "Modelo='".$datos_preparados["modelo"]."', "
                                . "Ancho=".$datos_preparados["ancho"].", "
                                . "Largo=".$datos_preparados["largo"].", "
                                . "Alto=".$datos_preparados["alto"].", "
                                . "AlturaExtension=".$datos_preparados["gato"].", "
                                . "EspacioDeGato=".$datos_preparados["extension"].", "
                                . "Disminucion=".$datos_preparados["disminucion"].", "
                                . "CubicacionReal=".$datos_preparados["cu_real"].", "
                                . "CubicacionParaPago=".$datos_preparados["cu_pago"]." "
                                . "WHERE IdCamion=".$datos_preparados["id_camion"]."";*/
                            
                            $x="INSERT INTO $_REQUEST[bd].solicitud_actualizacion_camion(IdCamion
                                ,IdSindicato
                                ,IdEmpresa
                                ,Propietario
                                ,IdOperador
                                ,Placas
                                ,PlacasCaja
                                ,IdMarca
                                ,Modelo
                                ,Ancho
                                ,Largo
                                ,Alto
                                ,Gato
                                ,Extension
                                ,Disminucion
                                ,CubicacionReal
                                ,CubicacionParaPago
                                ,Economico
                                ,IMEI
                                ,Registro
                                ,Version
                                ) values("
                                . "".$datos_preparados["id_camion"].", "
                                . "".$datos_preparados["id_sindicato"].", "
                                . "".$datos_preparados["id_empresa"].", "
                                . "'".$datos_preparados["propietario"]."', "
                                . "".$datos_preparados["id_operador"].", "
                                . "'".$datos_preparados["placas_camion"]."', "
                                . "'".$datos_preparados["placas_caja"]."', "
                                . "".$datos_preparados["id_marca"].", "
                                . "'".$datos_preparados["modelo"]."', "
                                . "".$datos_preparados["ancho"].", "
                                . "".$datos_preparados["largo"].", "
                                . "".$datos_preparados["alto"].", "
                                . "".$datos_preparados["gato"].", "
                                . "".$datos_preparados["extension"].", "
                                . "".$datos_preparados["disminucion"].", "
                                . "".$datos_preparados["cu_real"].", "
                                . "".$datos_preparados["cu_pago"].", "
                                . "'".$datos_preparados["economico"]."', "    
                                . "'".$_REQUEST["IMEI"]."', "
                                . "'".$_REQUEST["usr"]."', "
                                . "'".$_REQUEST["Version"]."' "        
                                . ")";
                            //echo $x;
                            $this->_db->consultar($x);
                            if($this->_db->affected()>=0){
                                $actualizados = $actualizados+$this->_db->affected();
                            }else{
                                $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x)."','".$row["IdUsuario"]."' )";
                                $this->_db->consultar($x_error);
                                if ($this->_db->affected() > 0) {
                                    $error = $error + $this->_db->affected();
                                }
                            }
                            
                        }
                        #AQUI VAN LOS MENSAJES QUE QUITE
                    }
                    ###############################
                    $json_solicitudes_activacion = $_REQUEST['solicitud_activacion'];
                    $datos_solicitudes_activacion = json_decode(utf8_encode($json_solicitudes_activacion), TRUE);
                    $a_solicitar_activacion = count($datos_solicitudes_activacion);
                    if($a_solicitar_activacion > 0){
                        $solicitudes_registradas = 0;
                        $solicitudes_registradas_previamente = 0;
                        $error_solicitudes = 0;
                        foreach ($datos_solicitudes_activacion as $key => $value) {
                            $datos_preparados = $this->preparaDatos($_REQUEST[bd],$value);

                            $x="INSERT INTO $_REQUEST[bd].solicitud_reactivacion_camion(IdCamion
                                ,IdSindicato
                                ,IdEmpresa
                                ,Propietario
                                ,IdOperador
                                ,Placas
                                ,PlacasCaja
                                ,IdMarca
                                ,Modelo
                                ,Ancho
                                ,Largo
                                ,Alto
                                ,Gato
                                ,Extension
                                ,Disminucion
                                ,CubicacionReal
                                ,CubicacionParaPago
                                ,Economico
                                ,IMEI
                                ,Registro
                                ,Version
                                ) values("
                                . "".$datos_preparados["id_camion"].", "
                                . "".$datos_preparados["id_sindicato"].", "
                                . "".$datos_preparados["id_empresa"].", "
                                . "'".$datos_preparados["propietario"]."', "
                                . "".$datos_preparados["id_operador"].", "
                                . "'".$datos_preparados["placas_camion"]."', "
                                . "'".$datos_preparados["placas_caja"]."', "
                                . "".$datos_preparados["id_marca"].", "
                                . "'".$datos_preparados["modelo"]."', "
                                . "".$datos_preparados["ancho"].", "
                                . "".$datos_preparados["largo"].", "
                                . "".$datos_preparados["alto"].", "
                                . "".$datos_preparados["gato"].", "
                                . "".$datos_preparados["extension"].", "
                                . "".$datos_preparados["disminucion"].", "
                                . "".$datos_preparados["cu_real"].", "
                                . "".$datos_preparados["cu_pago"].", "
                                . "'".$datos_preparados["economico"]."', "    
                                . "'".$_REQUEST["IMEI"]."', "
                                . "'".$_REQUEST["usr"]."', "
                                . "'".$_REQUEST["Version"]."' "        
                                . ")";
                            $this->_db->consultar($x);
                            if($this->_db->affected()>=0){
                                $solicitudes_registradas = $solicitudes_registradas+$this->_db->affected();
                            }else{
                                $x_error = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $x)."','".$row["IdUsuario"]."' )";
                                $this->_db->consultar($x_error);
                                if ($this->_db->affected() > 0) {
                                    $error_solicitudes = $error_solicitudes + $this->_db->affected();
                                }
                            }
                            
                        }
                        
                    }
                    ###############################
                    if (($actualizados+$error) == $a_registrar && ($solicitudes_registradas+$error_solicitudes)== $a_solicitar_activacion)
                            echo "{\"msj\":\"Actualizacion de Camiones y Registro de Solicitudes correcto." . " \"}";
                        else if(($actualizados+$error) == $a_registrar && ($solicitudes_registradas+$error_solicitudes)!= $a_solicitar_activacion)
                            echo "{\"error_solicitudes\":\"No se registraron todas las solicitudes. $solicitudes_registradas _ $error_solicitudes _ $a_solicitar_activacion \"}";
                        else if(($actualizados+$error) != $a_registrar && ($solicitudes_registradas+$error_solicitudes)== $a_solicitar_activacion)
                            echo "{\"error_actualizaciones\":\"No se actualizaron todos los camiones. $actualizados _ $error _ $a_registrar \"}";
                        else if(($actualizados+$error) != $a_registrar && ($solicitudes_registradas+$error_solicitudes)!= $a_solicitar_activacion)
                            echo "{\"error_ambos\":\"Actualizacion de Camiones y Registro de Solicitudes Incorrecto.\"}";
                    
                }else{
                    echo utf8_encode("{\"error\":\"No ha mandado ning�n registro para sincronizar.\"}");
                    }
            }else{
                echo utf8_encode("{\"error\":\"No tiene privilegios para actualizar el cat�logo de camiones.\"}");
            }
            } else {

                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningun proyecto.\"}";
            }
        }
        ELSE{
            echo utf8_encode("{\"error\":\"Datos de inicio de sesi�n no validos.\"}");
        }
    }
    
    function cargaImagenesCamiones(){
        
        //$version = $_REQUEST[Version];
        $cadenajsonx = json_encode($_REQUEST);
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
        $usr = $_REQUEST["usr"];
        $json_imagenes = $_REQUEST[Imagenes];
        $imagenes = json_decode(utf8_encode($json_imagenes), TRUE); 
        $cantidad_imagenes_a_registrar = count($imagenes);
        $cantidad_imagenes = 0;
        $bd = $_REQUEST["bd"];
        if($cantidad_imagenes_a_registrar>0){
            $i = 0;
            $ir = 0;
            $inr = 0;
            foreach ($imagenes as $key_i => $value_i) {
                
                
                
//                $x_errori = "insert into $_REQUEST[bd].cosultas_erroneas(consulta,registro) values('".str_replace("'", "\'", $sql_vn)."','eli' )";
//                            $this->_db->consultar($x_errori);
                
                    $id_tipo_imagen = ($value_i[idtipo_imagen]=="a")?"t":$value_i[idtipo_imagen];
                    if(array_key_exists("estatus", $value_i)){
                        if($value_i["estatus"]==1){
                            $id_solicitud_actualizacion = $this->_db->regresaDatos("$bd.solicitud_actualizacion_camion","IdSolicitudActualizacion", "WHERE IdCamion = ".$value_i[idcamion]." order by IdSolicitudActualizacion desc LIMIT 1");
                            $x_imagen = "insert into $_REQUEST[bd].solicitud_actualizacion_camion_imagenes(IdSolicitudActualizacion,IdCamion,TipoC,Imagen,Tipo) values(".$id_solicitud_actualizacion.",".$value_i[idcamion].",'".$id_tipo_imagen."','".str_replace('\\','',$value_i[imagen])."','0')";

                        }else{
                            $id_solicitud_reactivacion = $this->_db->regresaDatos("$bd.solicitud_reactivacion_camion","IdSolicitudReactivacion", "WHERE IdCamion = ".$value_i[idcamion]." order by IdSolicitudReactivacion desc LIMIT 1");
                            $x_imagen = "insert into $_REQUEST[bd].solicitud_reactivacion_camion_imagenes(IdSolicitudReactivacion,IdCamion,TipoC,Imagen,Tipo) values(".$id_solicitud_reactivacion.",".$value_i[idcamion].",'".$id_tipo_imagen."','".str_replace('\\','',$value_i[imagen])."','0')";
                        }
                    }else{
                        $id_solicitud_actualizacion = $this->_db->regresaDatos("$bd.solicitud_actualizacion_camion","IdSolicitudActualizacion", "WHERE IdCamion = ".$value_i[idcamion]." order by IdSolicitudActualizacion desc LIMIT 1");
                        $x_imagen = "insert into $_REQUEST[bd].solicitud_actualizacion_camion_imagenes(IdSolicitudActualizacion,IdCamion,TipoC,Imagen,Tipo) values(".$id_solicitud_actualizacion.",".$value_i[idcamion].",'".$id_tipo_imagen."','".str_replace('\\','',$value_i[imagen])."','0')";

                    }
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
               
                $i++;
            }
            $json_imagenes_registradas = json_encode($imagenes_registradas);
            $json_imagenes_no_registradas = json_encode($imagenes_no_registradas);
            $json_imagenes_no_registradas_sv = json_encode($imagenes_no_registradas_sv);
            echo "{\"msj\":\"Imagenes Sincronizadas.  Imagenes a Registrar: ".
                    $cantidad_imagenes_a_registrar." Imagenes Registradas: ".
                    $cantidad_imagenes_sin_viaje_neto." Imagenes con Error: ".($inr)." \" , "
                    . "\"imagenes_registradas\":".$json_imagenes_registradas.", "
                    . "\"imagenes_no_registradas\":".$json_imagenes_no_registradas."}";
        }
    }
    private function preparaDatos($bd, array $datos){
        
        $datos_salida = array();
        $id_sindicato = $this->regresaIdSindicato($bd,$datos["sindicato"]);
        $id_empresa = $this->regresaIdEmpresa($bd,$datos["empresa"]);
        $id_operador = $this->regresaIdOperador($bd,$datos["operador"],$datos["licencia"], $datos["vigencia"]);
        $id_marca = $this->regresaIdMarca($bd,$datos["marca"]);
        
        $datos_salida["id_sindicato"] = $id_sindicato;
        $datos_salida["id_empresa"] = $id_empresa;
        $datos_salida["id_operador"] = $id_operador;
        $datos_salida["id_marca"] = $id_marca;
        $datos_salida["propietario"] = $this->eliminaCaracteresEspeciales(utf8_decode(utf8_decode($datos["propietario"])));
        $datos_salida["placas_camion"] = $this->eliminaCaracteresEspeciales($datos["placas_camion"]);
        $datos_salida["placas_caja"] = $this->eliminaCaracteresEspeciales($datos["placas_caja"]);
        $datos_salida["modelo"] = $this->eliminaCaracteresEspeciales($datos["modelo"]);
        $datos_salida["ancho"] = $this->eliminaCaracteresEspecialesN($datos["ancho"]);
        $datos_salida["largo"] = $this->eliminaCaracteresEspecialesN($datos["largo"]);
        $datos_salida["alto"] = $this->eliminaCaracteresEspecialesN($datos["alto"]);
        $datos_salida["gato"] = $this->eliminaCaracteresEspecialesN($datos["gato"]);
        $datos_salida["extension"] = $this->eliminaCaracteresEspecialesN($datos["extension"]);
        $datos_salida["disminucion"] = $this->eliminaCaracteresEspecialesN($datos["disminucion"]);
        $datos_salida["cu_real"] = $this->eliminaCaracteresEspecialesN($datos["cu_real"]);
        $datos_salida["cu_pago"] = $this->eliminaCaracteresEspecialesN($datos["cu_pago"]);
        $datos_salida["id_camion"] = $datos["id_camion"];
        $datos_salida["economico"] = $datos["economico"];
        
        return $datos_salida;
    }
    private function accesoValidoActualizacionCamiones($id_usuario, $id_proyecto){
        $sql_valido = "SELECT count(*) as valido FROM sca_configuracion.usuarios_proyectos_modulos where id_modulo = 36 and id_usuario = ".$id_usuario." and id_proyecto =  ".$id_proyecto.";";
        $result_valido = $this->_db->consultar($sql_valido);
        $row_valido = $this->_db ->fetch($result_valido);
        if($row_valido["valido"] >0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    private function regresaIdSindicato($bd,$sindicato){
        $id_sindicato = "NULL";
        if($sindicato == "" || $sindicato == "0"){
            return "NULL";
        }
        $id_sindicato = $this->_db->regresaDatos3("$bd.sindicatos","IdSindicato", "Descripcion", utf8_decode($sindicato));
        if($id_sindicato>0){
            return $id_sindicato;
        }else{
            $insert = "INSERT INTO $bd.sindicatos(Descripcion, NombreCorto) values('".$this->eliminaCaracteresEspeciales(utf8_decode(utf8_decode(substr($sindicato, 0, 50))))."', '".$this->eliminaCaracteresEspeciales(utf8_decode(utf8_decode(substr($sindicato, 0, 20))))."');";
            $result = $this->_db->consultar($insert);
            $id_sindicato = $this->_db->last_id;
            return $id_sindicato;
        }
    }
    private function regresaIdEmpresa($bd,$empresa){
        $id_empresa = "NULL";
        if($empresa == "" || $empresa == "0"){
            return "NULL";
        }
        $id_empresa = $this->_db->regresaDatos3("$bd.empresas","IdEmpresa", "razonSocial", utf8_decode($empresa));
        if($id_empresa>0){
            return $id_empresa;
        }else{
            $insert = "INSERT INTO $bd.empresas(razonSocial) values('".$this->eliminaCaracteresEspeciales(utf8_decode(utf8_decode($empresa)))."');";
            $result = $this->_db->consultar($insert);
            $id_empresa = $this->_db->last_id;
            return $id_empresa;
        }
    }
    private function regresaIdOperador($bd,$operador, $licencia, $vigencia_licencia){
        $id_operador = "NULL";
        if($operador == ""){
            return "NULL";
        }
        $id_operador = $this->_db->regresaDatos3("$bd.operadores","IdOperador", "Nombre", utf8_decode($operador));
        if($id_operador>0){
            return $id_operador;
        }else{
            $insert = "INSERT INTO $bd.operadores(Nombre, NoLicencia, VigenciaLicencia, FechaAlta )"
                    . " values('".$this->eliminaCaracteresEspeciales(utf8_decode(utf8_decode($operador)))."',"
                    . "'".$this->eliminaCaracteresEspeciales($licencia)."',"
                    . "'$vigencia_licencia',NOW());";
            $result = $this->_db->consultar($insert);
            $id_operador = $this->_db->last_id;
            return $id_operador;
        }
    }
    private function regresaIdMarca($bd,$marca){
        $id_marca = "NULL";
        if($marca == ""){
            return "NULL";
        }
        $id_marca = $this->_db->regresaDatos3("$bd.marcas","IdMarca", "Descripcion", utf8_decode($marca));
        if($id_marca>0){
            return $id_marca;
        }else{
            $insert = "INSERT INTO $bd.marcas(Descripcion) values('".$this->eliminaCaracteresEspeciales(utf8_decode(utf8_decode($marca)))."');";
            $result = $this->_db->consultar($insert);
            $id_marca = $this->_db->last_id;
            return $id_marca;
        }
    }



    function ActualizarAcceso() {

        $cadenajsonx = json_encode($_REQUEST);
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].cambio_contrasena (usr,Idusuario,Version,IMEI) VALUES('".$_REQUEST[usr]."',".$_REQUEST[idusuario].",'".$_REQUEST[Version]."','".$_REQUEST[IMEI]."')");


        $this->_db_igh->consultar("UPDATE igh.usuario SET clave= md5('".$_REQUEST[NuevaClave]."') where idusuario = ".$_REQUEST[idusuario]);
        echo utf8_encode("{\"msj\":\"Contrase�a Guardada Correctamente!!\"}");



    }





    function eliminaCaracteresEspeciales($entrada){
        $string = str_replace(        
             array("\\", "�", "�", "-", "~",
                 "#", "@", "|", "!", "\"",
                 "�", "$", "%", "&", "/",
                 "(", ")", "?", "'", "�",
                 "�", "[", "^", "`", "]",
                 "+", "}", "{", "�", "�",
                 ">", "<", ";", ",", ":",
                 ),
             '',        
             $entrada    
             );
        return $string;
    }
    
    function eliminaCaracteresEspecialesN($entrada){
        $string = str_replace(        
             array("\\", "�", "�", "-", "~",
                 "#", "@", "|", "!", "\"",
                  "$", "%", "&", "/",
                 "(", ")", "?", "'", "�",
                 "�", "[", "^", "`", "]",
                 "+", "}", "{", "�", "�",
                 ">", "<", ";", ",", ":"),
             '',        
             $entrada    
             );
        return $string;
    }
}

?>
