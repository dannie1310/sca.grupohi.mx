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

    function getData($usr, $pass) {       
        
		$arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db_igh ->consultar($sql);
        
		if ($row = $this->_db_igh ->fetch($result)) {
            $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
            $result_s = $this->_db ->consultar($sql_s);
            
			if ($row_s = $this->_db ->fetch($result_s)) {
                $_SESSION["databasesca"]=$row_s[base_datos];
                
            
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
                //$sql_origenes="SELECT idorigen, descripcion FROM origenes where Estatus=1;";
				
				$sql_origenes="
											(SELECT 
												origen_x_usuario.idorigen as idorigen, 
							    					origenes.Descripcion as descripcion,
													1 as estado		
							  				FROM origen_x_usuario origen_x_usuario
							      			INNER JOIN origenes origenes
							          		ON (origen_x_usuario.idorigen = origenes.IdOrigen)
							 				WHERE (origen_x_usuario.idusuario_intranet = ".$row[IdUsuario]."))
											UNION(
											SELECT DISTINCT
											idOrigen as idorigen, 
											Descripcion as descripcion,
                                                    2 as estado
							  				FROM origenes
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
                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningun proyecto. \"}";


            }
        } else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontraron los datos que especifica.\"}";


        }

    }

    function  ConfDATA($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
        $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass';";
		
		$result = $this->_db_igh ->consultar($sql);
		
        if ($row = $this->_db_igh ->fetch($result)) {



              $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
			
			$result_s = $this->_db ->consultar($sql_s);
			
            if ($row_s = $this->_db ->fetch($result_s)) {






               $_SESSION["databasesca"]=$row_s[base_datos];
                $this->_database_sca = SCA::getConexion();
                //echo $_SESSION["databasesca"];










                 $sql_camiones="SELECT idcamion, Placas, M.descripcion as marca, Modelo, Ancho, largo, Alto, economico FROM camiones C
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
                            "economico"=>utf8_encode($row_camiones[economico])
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
                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ningon proyecto. \"}";


            } 
        }else {
           echo "{\"error\":\"Error en iniciar sesion. No se encontro los datos que especifica.\"}";
        }
    }


    function  ConfDATAv2($usr, $pass){
        $arraydata=array();
        $pass = md5($pass);
         $sql = "SELECT IdUsuario, Descripcion as nombre FROM igh.users where Usuario='$usr' and Clave='$pass' ;";
        $result = $this->_db_igh ->consultar($sql);
        if ($row = $this->_db_igh ->fetch($result)) {
              $sql_s="Select p.id_proyecto, p.base_datos, p.descripcion as descripcion_database  from proyectos p
                    inner join usuarios_proyectos up on p.id_proyecto=up.id_proyecto where id_Usuario_intranet=$row[IdUsuario]  and p.status=1 And p.id_proyecto!=5555 order by p.id_Proyecto desc limit 1;";
            $result_s = $this->_db ->consultar($sql_s);
            if ($row_s = $this->_db ->fetch($result_s)) {
               $_SESSION["databasesca"]=$row_s[base_datos];
                $this->_database_sca = SCA::getConexion();
                //echo $_SESSION["databasesca"];
                 /*$sql_camiones="SELECT idcamion, Placas, M.descripcion as marca, Modelo, Ancho, largo, Alto, economico FROM camiones C
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
                            "economico"=>utf8_encode($row_camiones[economico])
                        );*/











                //SINDICATOS
                $sql_sindicatos="Select IdSindicato, Descripcion, NombreCorto from sindicatos where estatus=1";
                $result_sindicatos=$this->_database_sca->consultar($sql_sindicatos);
                while($row_sindicatos=$this->_database_sca->fetch($result_sindicatos)) 
                        $array_sindicatos[]=array(
                            "IdSindicato"=>$row_sindicatos[IdSindicato],
                            "Descripcion"=>$row_sindicatos[Descripcion],
                            "NombreCorto"=>utf8_encode($row_sindicatos[NombreCorto])
                        );
                //OPERADORES
                $sql_operadores="Select IdOperador, Nombre, Direccion, NoLicencia, VigenciaLicencia from operadores where estatus=1";
                $result_operadores=$this->_database_sca->consultar($sql_operadores);
                while($row_operadores=$this->_database_sca->fetch($result_operadores)) 
                        $array_operadores[]=array(
                            "IdOperador"=>$row_operadores[IdOperador],
                            "Nombre"=>$row_operadores[Descripcion],
                            "Direccion"=>utf8_encode($row_operadores[NombreCorto]),
                            "NoLicencia"=>utf8_encode($row_operadores[NoLicencia]),
                            "VigenciaLicencia"=>utf8_encode($row_operadores[VigenciaLicencia])
                        );
                 //MARCAS
                $sql_marcas="Select IdMarca, Descripcion from marcas where Estatus=1";
                $result_marcas=$this->_database_sca->consultar($sql_marcas);
                while($row_marcas=$this->_database_sca->fetch($result_marcas)) 
                        $array_marcas[]=array(
                            "IdMarca"=>$row_marcas[IdMarca],
                            "Descripcion"=>$row_marcas[Descripcion],
                        );
                 //CAMIONES
                $sql_camiones="select IdCamion,
                                    IdProyecto,
                                    IdSindicato,
                                    Propietario,
                                    IdOperador,
                                    IdBoton,
                                    Placas,
                                    Economico,
                                    IdMarca,
                                    Modelo,
                                    PolizaSeguro,
                                    VigenciaPolizaSeguro,
                                    Aseguradora,
                                    Ancho,
                                    Largo,
                                    Alto,
                                    AlturaExtension,
                                    EspacioDeGato,
                                    CubicacionReal,
                                    CubicacionParaPago,
                                    FechaAlta,
                                    HoraAlta,
                                    Estatus FROM camiones where estatus=1";
                $result_camiones=$this->_database_sca->consultar($sql_camiones);
                while($row_camiones=$this->_database_sca->fetch($result_camiones)) 
                        $array_camiones[]=array(
                            "IdCamion"=> $row_camiones[IdCamion],
                            "IdProyecto"=> $row_camiones[IdProyecto]   ,
                            "IdSindicato"=> $row_camiones[IdSindicato]   ,
                            "Propietario"=> $row_camiones[Propietario]   ,
                            "IdOperador"=> $row_camiones[IdOperador]   ,
                            "IdBoton"=> $row_camiones[IdBoton]   ,
                            "Placas"=> $row_camiones[Placas]   ,
                            "Economico"=> $row_camiones[Economico]   ,
                            "IdMarca"=> $row_camiones[IdMarca]   ,
                            "Modelo"=> $row_camiones[Modelo]   ,
                            "PolizaSeguro"=> $row_camiones[PolizaSeguro],
                            "VigenciaPolizaSeguro"=> $row_camiones[VigenciaPolizaSeguro],
                            "Aseguradora"=> $row_camiones[Aseguradora]   ,
                            "Ancho"=> $row_camiones[Ancho]   ,
                            "Largo"=> $row_camiones[Largo]   ,
                            "Alto"=> $row_camiones[Alto],
                            "AlturaExtension"=> $row_camiones[AlturaExtension]   ,
                            "EspacioDeGato"=> $row_camiones[EspacioDeGato ]   ,
                            "CubicacionReal"=> $row_camiones[CubicacionReal]   ,
                            "CubicacionParaPago  "=> $row_camiones[CubicacionParaPago]   ,
                            "FechaAlta"=> $row_camiones[FechaAlta]   ,
                            "HoraAlta"=> $row_camiones[HoraAlta],
                            "Estatus"=> $row_camiones[Estatus]   

                        );



                $arraydata=array(
                     "IdUsuario"=>$row[IdUsuario],
                     "Nombre"=>utf8_encode($row[nombre]),
                     "IdProyecto"=>$row_s[id_proyecto],
                     "base_datos"=>$row_s[base_datos], 
                     "descripcion_database"=>utf8_encode($row_s[descripcion_database]),
                     "camiones"=>$array_camiones,
                     "sindicatos"=>$array_sindicatos,
                     "operadores"=>$array_operadores,
                     "marcas"=>$array_marcas,
                 );
                 //print_r($arraydata);                 
                 echo json_encode($arraydata);  
            }else {
                echo "{\"error\":\"Error al obtener los datos del proyecto. Probablemente el usuario no tenga asignado ning?n proyecto. \"}";
            } 
        }else {
           echo "{\"error\":\"Error en iniciar sesi?n. No se encontr? los datos que especifica.\"}";
        }
    }

    /*
    function captura() {
        //print_r($_REQUEST);
	//echo "INSERT INTO $_REQUEST[bd].json (json) values(\'$_REQUEST[carddata]\')";
        $cadenajsonx=json_encode($_REQUEST);
        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$cadenajsonx')");

        $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[carddata]')");
        $json = $_REQUEST[carddata];
        $data = json_decode(utf8_encode($json), TRUE);
        $registros = 0;
        /*if (isset($_REQUEST[db])){
             echo "{\"error\":\"Base de datos no encontrado. Error fatal\"}";
            exit();
        }*/
       //$registros=0;
        /*foreach ($data as $key => $value) {

               
                //foreach ($data as $key => $value) {
                    $x="INSERT INTO $_REQUEST[bd].viajesnetos values(null,0,'$value[FechaCarga]', '$value[HoraCarga]', 1, $value[IdCamion], $value[IdOrigen], '$value[FechaSalida]','$value[HoraSalida]',
                $value[IdTiro], '$value[FechaLlegada]', '$value[HoraLlegada]', $value[IdMaterial], '$value[Observaciones]','$value[Creo]',0, '$value[Code]')";
                    //mysql_query("INSERT INTO scatest.temp_json values (null,\"\ $x \"");
                  $this->_db->consultar($x);// mysql_query($x);
                   
                   
                    $registros++;
                //}
            
           /* $this->_db->prepare("INSERT INTO
			scatest.viajesnetos
			VALUES (
                                ':IdViajeNeto',
                                ':IdArchivoCargado',
                                ':FechaCarga',
                                ':HoraCarga',
                                ':IdProyecto',
                                ':IdCamion',
                                ':IdOrigen',
                                ':FechaSalida',
                                ':HoraSalida',
                                ':IdTiro',
                                ':FechaLlegada',
                                ':HoraLlegada',
                                ':IdMaterial',
                                ':Observaciones',
                                ':Creo',
                                ':Estatus')"
                )->execute(
		array(
                                ':IdViajeNeto'=>null,
                                ':IdArchivoCargado'=>0,
                                ':FechaCarga'=>$value[FechaCarga],
                                ':HoraCarga'=>$value[HoraCarga],
                                ':IdProyecto'=>$value[IdProyecto],
                                ':IdCamion'=>$value[IdCamion],
                                ':IdOrigen'=>$value[IdOrigen],
                                ':FechaSalida'=>$value[FechaSalida],
                                ':HoraSalida'=>$value[HoraSalida],
                                ':IdTiro'=>$value[IdTiro],
                                ':FechaLlegada'=>$value[FechaLlegada],
                                ':HoraLlegada'=>$value[HoraLlegada],
                                ':IdMaterial'=>$value[IdMaterial],
                                ':Observaciones'=>$value[Observaciones],
                                ':Creo'=>$value[Creo],
                                ':Estatus'=>$value[Estatus]
                    ));*/
       /* }
        if ($registros > 0)
            echo "{\"msj\":\"Datos sincronizados correctamente--\"}";
        else
            echo "{\"error\":\"Se ha producido un error en el Servidor, favor de rep?rtalo con los administradores\"}";
    }
    */

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
           $x="INSERT INTO 
                    $_REQUEST[bd].viajesnetos(IdArchivoCargado, FechaCarga, HoraCarga, IdProyecto, IdCamion, IdOrigen, FechaSalida, HoraSalida, IdTiro,
                            FechaLlegada, HoraLlegada, IdMaterial, Observaciones,Creo,Estatus,Code,uidTAG) 
                VALUES(
                       0,
                       '$value[FechaCarga]', 
                       '$value[HoraCarga]', 
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
                       '$value[uidTAG]');";


            $this->_db->consultar($x);
            $registros++;
          }
        }

        if (isset($_REQUEST[coordenadas])){
          $this->_db->consultar("INSERT INTO $_REQUEST[bd].json (json) values('$_REQUEST[coordenadas]')"); //coordenadas
          $json_coordenada = $_REQUEST[coordenadas];
          $data_coordenada = json_decode(utf8_encode($json_coordenada), TRUE);
          $registros = 0;

          if (isset($_REQUEST['idusuario']))
            $usuario_creo=$_REQUEST['idusuario'];
            else
            $usuario_creo=0; 
          
          foreach ($data_coordenada as $key => $value) {
              $x="INSERT INTO $_REQUEST[bd].eventos_gps 
                  (idevento, IMEI, longitude,latitude,fechahora, code, idusuario) values
                  ($value[idevento],'$value[IMRI]', '$value[longitude]', '$value[latitude]','$value[fechahora]', '$value[code]',$usuario_creo)";
              $this->_db->consultar($x); 
              $registros++;
          }
        }






        if ($registros > 0)
            echo "{\"msj\":\"Datos sincronizados correctamente--\"}";
        else
            echo "{\"error\":\"Se ha producido un error en el Servidor, favor de rep?rtalo con los administradores\"}";
    }
    /*
     *  $sql_s = "SELECT id_proyecto FROM usuarios_proyectos where id_usuario_intranet=$this->IdUsuario and id_proyecto!=5555 order by id_Proyecto desc limit 1;";
            $result_s = $sca_config->consultar($sql_s);
            if ($row_s = $sca_config->fetch($result_s)) {
                $this->IdProyecto = $row_s[id_proyecto];
                $sql_sub = "SELECT base_datos FROM proyectos where id_proyecto=$this->IdProyecto";
                $result_sub = $sca_config->consultar($sql_sub);
                if ($row_sub = $sca_config->fetch($result_sub)) {
                    $_SESSION["databasesca"]=$row_sub[base_datos];
                    $this->_database_sca = SCA::getConexion();
                    
                    
                } else {
                    echo "{\"error\":\"Error al obtener de la base de datos\"}";
                }
            } else {
                echo "{\"error\":\"Error al obtener los datos del proyecto\"}";
            }
     * 
     */

    /* function setIdProyecto(){

      }
      function setIdUsuario(){

      }
      function setIdNombre(){

      } */


}

?>
