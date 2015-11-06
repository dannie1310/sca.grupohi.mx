<?php

/**
 * Sistema de Control de Acarreos
 *
 * 2015 (c) Grupo Hermes Infraestructura
 */
session_start();
include("../../inc/php/conexiones/SCA.php");
$sca=SCA::getConexion();
$IdUsuario = $_REQUEST["IdUsuario"];
?>
<table style="width:600px;" align="center" class="reporte">
    	<thead class="header">
            <tr>
                <th align="left" style="width:20px;">&nbsp;</th>
                <th align="left" style="width:400px;">Origen</th>
                
            </tr>
        </thead>
        <tbody>
        	<?php
			$SQL = "SELECT origenes.Descripcion as Origen,
       GROUP_CONCAT(rutas.IdRuta) AS grupo_rutas,
       origenes.IdOrigen,
       origen_x_usuario.idusuario_intranet,
       concat(vw_usuarios_por_proyecto.nombre,
              ' ',
              vw_usuarios_por_proyecto.apaterno,
              ' ',
              vw_usuarios_por_proyecto.amaterno)
          AS usuario_intranet
  FROM ((prod_sca_trenmt_movil.origenes origenes
         LEFT OUTER JOIN
         prod_sca_trenmt_movil.origen_x_usuario origen_x_usuario
            ON (origenes.IdOrigen = origen_x_usuario.idorigen))
        LEFT OUTER JOIN prod_sca_trenmt_movil.rutas rutas
           ON (rutas.IdOrigen = origenes.IdOrigen))
       LEFT OUTER JOIN
       prod_sca_trenmt_movil.vw_usuarios_por_proyecto vw_usuarios_por_proyecto
          ON (vw_usuarios_por_proyecto.id_usuario_intranet =
                 origen_x_usuario.idusuario_intranet)
GROUP BY origenes.IdOrigen
ORDER BY origenes.Descripcion ASC";
                        $RSQL = $sca->consultar($SQL);
			while($VSQL = $sca->fetch($RSQL)){
                            if($VSQL["grupo_rutas"] == ""){
                                $Estatus = "away16";
                                $Titulo = "Origen sin ruta asignada";
                                $IdEstatus = 0;
                                $Cursor = "not-allowed";
                            }else{
                                if($VSQL["idusuario_intranet"] == ""){
                                    $Estatus = "offline16";
                                    $Titulo = "Origen disponible a ser asignado";
                                    $IdEstatus = 1;
                                    $Cursor = "pointer";
                                }
                                else if($IdUsuario == $VSQL["idusuario_intranet"]){
                                    $Estatus = "online16";
                                    $Titulo = "Origen asignado a usuario";
                                    $IdEstatus = 2;
                                    $Cursor = "pointer";
                                }
                                else if($IdUsuario !== $VSQL["idusuario_intranet"]){
                                    $Estatus = "busy16";
                                    $Titulo = "Origen asignado a " . $VSQL["usuario_intranet"];
                                    $IdEstatus = 3;
                                    $Cursor = "not-allowed";
                                }
                            }
				?>
                <tr>
                    <td align="left">
                        <img src="../../Imgs/<?php echo $Estatus?>.png" style="cursor:<?php echo $Cursor; ?>" title="<?php echo $Titulo;?>" class="cambiar_asignacion" IdUsuario="<?php echo $IdUsuario;?>" IdEstatus="<?php echo $IdEstatus;?>" IdOrigen="<?php echo $VSQL["IdOrigen"]; ?>"/>
                    </td>
                    <td><?php echo utf8_decode($VSQL["Origen"]);?></td>
                </tr>
                <?php
				}
			?>
        </tbody>
    </table>