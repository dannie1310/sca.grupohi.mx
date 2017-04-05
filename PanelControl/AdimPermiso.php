<?php
include("../inc/php/conexiones/SCA_IGH.php");
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/adminusers.php");
include("class/permisos.php");


new validar_usuario();
$admin_users=new adminusers();
$admin_permisos=new permisos();


?>
<!--<link href="../inc/js/jquery-ui-1.8.16.custom/css/ui-lightness/jquery-ui-1.8.16.custom.css"rel="stylesheet" type="text/css"/>-->
<link href="js/jquery_ui_1.8.0._Smoothness/css/smoothness/jquery-ui-1.8.23.custom.css"rel="stylesheet" type="text/css"/>
<link href="css/disenio.css"rel="stylesheet" type="text/css"/>
<script src="../inc/js/jquery-1.4.4.js" type="text/javascript"></script>
<script src="../inc/js/jquery.form.js" type="text/javascript"></script>
<script src="../inc/js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script src="js/functios.js" type="text/javascript"></script>
<style>
.permisos{
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#333;
	padding:0px;
	}
</style>
<center><font color="" size="4cm">- Administraci&oacute;n de Permisos -</font></center>

        <div id="usuario_per" style="width: 100%; ">
        <ul><li>
                <select id="usuario_permiso" name="usuarioalta" class="mainselection" onchange="mis_proyectos()">
                    <option value='null'>- Selecione usuario -</option>
                    <?php echo $admin_users->llena_combo_users_registrados()?>
                </select>
            </li>
        </ul>
    <div id="lista_proyectos">
        
    </div>
        <?php //echo $admin_users->proyecto_permiso();?>
<!--        <center> <input class="button btn_file_add" id="submit" type="submit" value="Agregar usuario" disabled/></center>-->
        <div id="ajax_loader"><img id="loader_gif" src="../Imgs/loader.gif" style=" display:none;"/></div>
        <div id="dialog_res" style="display: none"></div>        
     </div>

<div id="dialog_menus" style="display: none">
    
</div>

  





