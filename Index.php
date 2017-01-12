<?php
    session_start();

    include("inc/php/conexiones/SCA_config.php");

    if(!empty($_SESSION['IdUsuario'])) {
        $sca_config = SCA_config::getConexion();  
    
        $sql = "SELECT proyectos.id_proyecto as idp, proyectos.base_datos as base,
          proyectos.descripcion as descripcion,
          usuarios_proyectos.id_usuario_intranet
     FROM    sca_configuracion.proyectos proyectos
          RIGHT OUTER JOIN
             sca_configuracion.usuarios_proyectos usuarios_proyectos
          ON (proyectos.id_proyecto = usuarios_proyectos.id_proyecto)
    WHERE (usuarios_proyectos.id_usuario_intranet = ".$_SESSION[IdUsuario]." and proyectos.status=1 ) order by  find_in_set(Descripcion,'Panel de Control') asc;";
    
        $combo_sca='';
        $result = $sca_config->consultar($sql);
    
        while ($row = $sca_config->fetch($result)) 
            $combo_sca.="<option value=$row[base]>$row[descripcion]</option>";
   
        if($combo_sca=='') 
            $_SESSION['combosca']=$combo_sca='<b><font color=red>NO tienes ningun SCA asignado</font></b>';
        else 
            $combo_sca="<select id='proyecto' onchange='define_acarreo()'><option value='null'>- Selecione una Obra -</option>$combo_sca</select>";
    }else{
        header('Location: Login.php');
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title>M&oacute;dulo de Acarreos | GHI</title>
            <link rel="stylesheet" href="Clases/Skin/ThemePanel/theme.css" type="text/css">
            <link rel="stylesheet" href="Clases/Styles/PaginaGeneral.css" type="text/css">
            <script type="text/javascript" src="Clases/Skin/jscookmenu.js"></script>
            <script type="text/javascript" src="Clases/Skin/ThemePanel/theme.js"></script>
            <script type="text/javascript" src="Clases/Js/msn.js"></script>
            <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
            <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
            <script src="inc/js/jquery-1.4.4.js" type="text/javascript"></script>
            <script type="text/javascript" src="http://file-js.grupohi.mx/prod_acarreos.js"></script>
            <script type="text/javascript">
                function define_acarreo(){	
                    $.post("define_acarreo.php",{
                        proyecto:$("#proyecto option:selected").val(),
                        idusuario:<?php echo $_SESSION[IdUsuario]; ?>
                    }, 
                function (data){                            
                    $("#menu_sca").html(data);
                    var MenuBar1 = new Spry.Widget.MenuBar("SCAMenu", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
                    $("#portada_sca").html('<iframe name="content" src="Portada.php" scrolling="auto" width="1000px" height="700px" frameborder="0" style="padding:0px;margin:0px"></iframe>');
                });                                    
                }
            </script>
            <style type="text/css">
                        <!--
                        .style1 {
                            font-size: 36px;
                            font-weight: bold;
                            color: #FFFFFF;
                            font-style: italic;
                        }
                        -->
                </style>

                    <link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css">
                        <style type="text/css">
                            <!--
                            body{background: url(css/imagenes/backg1000.gif) repeat-y scroll center center #D4D4D4;}
                            table{ border-collapse:collapse}
                            -->
                        </style>
    </head>
    
    <body>
        <div id="layout">
            <table width="1000px" border="0" align="left" cellpadding="0" cellspacing="0">
                <tr>
                    <td background="Imagenes/menu/BannerAcarreos.jpg" style="width:1000px; height:60px;">
                        <br /><br />
                    </td>    
                </tr>
                <tr bgcolor="#000;">
                    <td  class="Bienvenida">
                        <div id="bienvenida">
                            <?php 
                                echo "BIENVENIDO: " . $_SESSION['Descripcion'] . ", PROYECTO: " . $combo_sca; 
                            ?>
                        </div>
                    </td>
                </tr>
                                    <tr>
                                        <td>
                                            <div id="version">
                                                <a href="Logout.php">
                                                <button>Cerrar Sesi&oacute;n</button>                                                    
                                                </a>
                                                2017.3.0.1
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >
                                            <div id="menu_sca"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td id="portada_sca" valign="top" style="padding:0px">
                                            <iframe name="content" src="Portada.php" scrolling="auto" width="1000px" height="1700px" frameborder="0" style="padding:0px;margin:0px"></iframe>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <script type="text/javascript">
                                <!--
                                var MenuBar1 = new Spry.Widget.MenuBar("SCAMenu", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
                                //-->
                            </script>
                        </body>
                        </html>
