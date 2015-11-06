<?php
session_start();
include("inc/php/conexiones/SCA.php");
include("Clases/Funcion_Menu.php");
include("Clases/Usuario/Usuario.php");


$Usuario = $_POST["usr"];
$Clave = $_POST["pwd"];
if (!isset($_SESSION["IdUsuarioAc"])){
    //Revisamos los Datos del Usuario
    $link = SCA::getConexion();
    $sql = "Select * from usuarios where Usuario='" . $Usuario . "' and Estatus=1;";
    //echo $sql;
    $result = $link->consultar($sql);
    //$link->cerrar();

    while ($row = $link->fetch($result)) {

        $UsuarioBD = $row["Usuario"];
        $ClaveBD = $row["Clave"];
        $IdUsuario = $row["IdUsuario"];
        $Descripcion = $row["Descripcion"];
    }

    if ($Usuario == $UsuarioBD) {
        if (MD5($Clave) == $ClaveBD) {
            $_SESSION["IdUsuarioAc"] = $IdUsuario;
            $_SESSION['Descripcion'] = $Descripcion;

            //Obtenemos el Id del proyecto al que pertenece
            //$link=SCA::getConexion();
            $sql = "SELECT usuariosxproyecto.IdProyecto FROM usuarios, usuariosxproyecto WHERE usuarios.IdUsuario =" . $_SESSION["IdUsuarioAc"] . "  AND usuarios.Estatus = 1 AND usuariosxproyecto.IdUsuario = usuarios.IdUsuario";
            $result = $link->consultar($sql);
            //$link->cerrar();

            while ($row =  $link->fetch($result)) {
                $_SESSION['Proyecto'] = $row["IdProyecto"];
            }


            $sql = "Select NombreCorto, Descripcion from proyectos where IdProyecto=" . $_SESSION["Proyecto"] . ";";

            $result = $link->consultar($sql);


            while ($row =  $link->fetch($result)) {
                $_SESSION['NombreCortoProyecto'] = $row["NombreCorto"];
                $_SESSION['DescripcionProyecto'] = $row["Descripcion"];
            }
        } else {
            //session_destroy();
            echo"<script lenguage=javascript type=text/javascript>
						window.location.replace('Login.php');
					 </script>;";
        }
    } else {
       // session_destroy();
        //header("Location:http://localhost/SAC/Login.php");
        echo"<script lenguage=javascript type=text/javascript>
						window.location.replace('Login.php');
					 </script>;";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            <title>Control de Acarreos.- GHI</title>
            <LINK rel="stylesheet" href="Clases/Skin/ThemePanel/theme.css" type="text/css">
                <script type="text/javascript" src="Clases/Skin/jscookmenu.js"></script>
                <script type="text/javascript" src="Clases/Skin/ThemePanel/theme.js"></script>
                <script type="text/javascript" src="Clases/Js/msn.js"></script>
                <script type="text/javascript" src="Clases/Js/NoClick.js"></script>
                <link href="Clases/Styles/PaginaGeneral.css" rel="stylesheet" type="text/css">
                <script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
                <script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
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
                        </style></head>

                        <body >
<?php
$usuario = new Usuario();
//echo $_SESSION["IdUsuarioAc"];
$varMenu = $usuario->creaMenu($_SESSION["IdUsuarioAc"]);
$de_niveles = obtiene_niveles($varMenu);
$no_niveles = sizeof($de_niveles);
?>
                            <div id="layout">
                                <table width="1000px" border="0" align="left" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td background="Imgs/banner.jpg" style="width:1000px; height:60px;"><br />
                                            <br />
                                    </tr>
                                    <tr bgcolor="#000;">
                                        <td  class="Bienvenida"><div id="bienvenida"><?php echo "BIENVENIDO: " . $_SESSION['Descripcion'] . ", PROYECTO: " . $_SESSION['DescripcionProyecto']; ?></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><div id="version">V 23042012</div></td>
                                    </tr>
                                    <tr>
                                        <td><?php obtienehijos(0, $varMenu, $_SESSION["IdUsuarioAc"]); ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td valign="top" style="padding:0px"><iframe name="content" src="Portada.php" scrolling="auto" width="1000px" height="700px" frameborder="0" style="padding:0px;margin:0px"></iframe></td>
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
