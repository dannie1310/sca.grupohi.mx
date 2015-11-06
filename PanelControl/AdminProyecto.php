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
<script src="js/jquery.validate.js" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){
$('input[type="text"]').addClass("idleField");
$('input[type="text"]').focus(function() {
          $(this).removeClass("idleField").addClass("focusField");
          if (this.value == this.defaultValue){ 
           this.value = '';
    }
    if(this.value != this.defaultValue){
        this.select();
       }
      });
      $('input[type="text"]').blur(function() {
       $(this).removeClass("focusField").addClass("idleField");
          if ($.trim(this.value) == ''){
            this.value = (this.defaultValue ? this.defaultValue : '');
    }
      });
         $('#forproyecto_alta').validate({
      rules: {
           'nombre': 'required',
           'nombre_corto': 'required',
           'database':  'required'
       },
       messages: {
           'nombre': 'Debe ingresar el nombre',
           'nombre_corto': 'Debe ingresar el nombre corto',
           'database':'Debe ingresar la database'
       },
       debug: true,
       submitHandler: function(){
           var datos  = $('#forproyecto_alta').serialize();
          // alert('El formulario ha sido validado correctamente!');*/
            $.post('alta_proyecto.php',datos,function(data){                
                $.post('en_listar_proyectos_all.php',function(data){
                    $("#list_proy").html(data);
                })
            })
       }
       }); 
    });
</script>
<style type="text/css">
   /* *{
     margin:0;
     padding:0;
     font:bold 12px "Lucida Grande", Arial, sans-serif;
    }
    body {
     padding: 10px;
    }
    h1{
     font-size:14px;
    }*/
    #status{
     width:50%;
     padding:10px;
     height:42px;
     outline:none;
    }
    .focusField{
     border:solid 2px #73A6FF;
     background:#EFF5FF;
     color:#000;
    }
    .idleField{
     background:#EEE;
     color: #6F6F6F;
  border: solid 2px #DFDFDF;
    }  
    label.error{
font-size: 11px;
margin-left: 20px;
background: #fbfcda url('../Imgs/16-Deleted.gif') no-repeat left;
border:1px solid #dbdbd3;
width:209px;
margin-top:4px;
padding-left:20px;
}
/*.error:before{ /* Este es un truco para crear una flechita */
    /*content: '';
    border-top: 8px solid transparent;
    border-bottom: 8px solid transparent;
    border-right: 8px solid #BC1010;
    border-left: 8px solid transparent;
    left: -16px;
    position: absolute;
    top: 5px;
}*/
</style>
<center><font color="" size="4cm">- Administraci&oacute;n de Proyectos -</font></center>
<br>
<div id="alta_proyectos" style="text-align: center">
       <form id="forproyecto_alta" action="alta_proyecto.php" method="post"> 
           <table style="width: 90%;" align="center">
               <tr>
                   <td style="width: 30%"><span  name="nombre" title="Escribe el nombre del proyecto">Escribe el nombre del proyecto</span></td>
                    <td style="width: 25%"><span  type="text" value=""  name="nombre_corto" title="Escribe el nombre corto">Escribe el nombre corto </span></td>
                     <td style="width: 23%"><span  type="text" value=""  name="database" title="Escribe su database"> Escribe su database</span></td>
                      <td style="width: 12%"></td>
               </tr>
               <tr>
                   <td style="width: 30%"><input style="width: 100%" type="text" value=""  name="nombre" title="Escribe el nombre del proyecto"></td>
                   <td style="width: 25%"><input style="width: 100%" type="text" value=""  name="nombre_corto" title="Escribe el nombre corto"></td>
                   <td style="width: 23%"><input style="width: 100%" type="text" value=""  name="database" title="Escribe su database"></td>
                   <td style="width: 12%"><input style="width: 100%" type="submit" value="Agregar proyecto" > </td>
               </tr>
           </table>
          
       <div id="ajax_loader"><img id="loader_gif" src="../Imgs/loader.gif" style=" display:none;"/></div>
    </form>
    <div id="dialog_res" style="display: none">
    </div>
  </div>
<div id="proyectos" style="width: 100%; ">
        <ul><li>
                <font style="font-weight: bold;size: 16px">Lista Proyectos</font> <img src='../Imagenes/activo.gif'> Activo <img src='../Imagenes/inactivo.gif'> Inactivo
            </li>
        </ul>
    <div id="list_proy">
        <?php echo $admin_users->en_listar_proyectos_all(); ?>
    </div>
</div>

