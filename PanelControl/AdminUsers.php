<?php
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/adminusers.php");

new validar_usuario();
$admin_users=new adminusers();
?>
<!--<link href="../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css"rel="stylesheet" type="text/css"/>-->
<link href="js/jquery_ui_1.8.0._Smoothness/css/smoothness/jquery-ui-1.8.23.custom.css"rel="stylesheet" type="text/css"/>
<link href="css/disenio.css"rel="stylesheet" type="text/css"/>
<script src="../inc/js/jquery-1.4.4.js" type="text/javascript"></script>
<script src="../inc/js/jquery.form.js" type="text/javascript"></script>
<script src="../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script src="js/functios.js" type="text/javascript"></script>
<center><font color="" size="4cm">- Administraci&oacute;n de Usuarios -</font></center>
<div id="alta_usuario" style="width: 100%; ">
    <form id="formalta" action="alta_usuario.php" method="post"> 
        <ul><li>
                <select id="usuarioalta" name="usuarioalta" class="mainselection" onchange="validar_listo()">
                    <option value='null'>- Selecione usuario -</option>
                    <?php echo $admin_users->llena_combo_users()?>
                </select>
            </li>
        </ul>
        <?php if ($admin_users->llena_combo_users()) echo $admin_users->en_listar_proyectos(); else echo "<font color=red>No hay Usuario que agregar</font>"; ?>
        <center> <input class="button btn_file_add" id="submit" type="submit" value="Agregar usuario" disabled/></center>
        <div id="ajax_loader"><img id="loader_gif" src="../Imgs/loader.gif" style=" display:none;"/></div>
    </form>
    <div id="dialog_res" style="display: none">
</div>
</div>
