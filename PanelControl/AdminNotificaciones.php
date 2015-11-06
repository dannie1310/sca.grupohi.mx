<?php
include("../inc/php/conexiones/SCA_config.php");
include("class/validar_sesion.php");
include ("class/proyectos.php");
include("class/adminusers.php");
include("class/permisos.php");
include("class/notificaciones.php");


new validar_usuario();
$admin_users=new adminusers();
$admin_permisos=new permisos();
$notificaciones=new notificaciones();


?>
<link href="css/disenio.css"rel="stylesheet" type="text/css"/>
<link href="js/jquery_ui_1.8.0._Smoothness/css/smoothness/jquery-ui-1.8.23.custom.css"rel="stylesheet" type="text/css"/>
<script src="../inc/js/jquery-1.4.4.js" type="text/javascript"></script>
<script src="../inc/js/jquery.form.js" type="text/javascript"></script>
<script src="js/jquery_ui_1.8.0._Smoothness/js/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
<script src="js/functios.js" type="text/javascript"></script>
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
  <body>
      <center><font color="" size="4cm">- Administraci&oacute;n de Notificaciones-</font></center>
      <fieldset style="background-color: #747474">
          <legend  > <Select id="nproyecto" class="mainselection" onchange="valida_even()"> <option value="null"> -Selecione un Proyecto- </option> <?php echo  $admin_permisos->en_listar_proy_combo();?> </Select> <!--<Select> <option>Proyecto</option></Select>--></legend>
          <fieldset style="background-color: 999999">
              <legend align="center" > <Select id="nevento" class="mainselection" onchange="valida_even()"> <option value="null"> -Selecione un Evento- </option>  <?php echo $notificaciones->notif_eventos() ?></Select></legend>
                  <div id="tabs" style="font-size:62.5%;">
                      <ul>
                          <li><a href="#tab_A" onclick="if($('#nproyecto').val()!='null' && $('#nevento').val()!='null' )consultar_tipo(1,'#tab_A');else {$('#Usuario_add').html('<option value=null>Error..<option>');$('#tab_A, #tab_CC, #tab_BCC').html('Error...');}"><span>Para(A)</span></a></li>
                          <li><a href="#tab_CC" onclick="if($('#nproyecto').val()!='null' && $('#nevento').val()!='null' )consultar_tipo(2,'#tab_CC');else {$('#Usuario_add').html('<option value=null>Error..<option>');$('#tab_A, #tab_CC, #tab_BCC').html('Error...');}"><span>Con Copia(CC)</span></a></li>
                          <li><a href="#tab_BCC" onclick="if($('#nproyecto').val()!='null' && $('#nevento').val()!='null' )consultar_tipo(3,'#tab_BCC');else {$('#Usuario_add').html('<option value=null>Error..<option>');$('#tab_A, #tab_CC, #tab_BCC').html('Error...');}"><span>Con Copia Oculta(BCC)</span></a></li>
                      </ul>
                      <div id="tab_A">
                          <p>Selecione un proyecto</p>
                              
                      </div>
                      <div id="tab_CC">
                          <p>Selecione un proyecto</p>
                      </div>
                      <div id="tab_BCC">
                          <p>Selecione un proyecto</p>
                      </div>
                   <div>
                       <Select id="Usuario_add"class="mainselection"> <option value="null"> -Selecione un Usuario a agregar- </option>  <?php echo $admin_users->all_users_intranet(); ?></Select>
                       <input type="button" value="Agregar" onclick="inserta_user_notificaciones()"/>
                  </div>
                  </div>
          </fieldset>
      </fieldset>   

  </body>
  