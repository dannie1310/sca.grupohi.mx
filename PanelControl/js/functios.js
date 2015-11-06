    $(document).ready(function(){
          // definimos las opciones del plugin AJAX FORM
            var opciones= {
                               beforeSubmit: mostrarLoader, //funcion que se ejecuta antes de enviar el form
                               success: mostrarRespuesta //funcion que se ejecuta una vez enviado el formulario
            };
             //asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            $('#formalta').ajaxForm(opciones) ; 
 
             //lugar donde defino las funciones que utilizo dentro de "opciones"
             function mostrarLoader(){
                          $('#loader_gif').fadeIn("slow"); //muestro el loader de ajax
             };
             function mostrarRespuesta (responseText){
                           //alert("Mensaje enviado: "+responseText);  //responseText es lo que devuelve la página contacto.php. Si en contacto.php hacemos echo "Hola" , la variable responseText = "Hola" . Aca hago un alert con el valor de response text
                          $("#loader_gif").fadeOut("slow"); // Hago desaparecer el loader de ajax
                          //$("#ajax_loader").append("<br>Mensaje: "+responseText); // Aca utilizo la función append de JQuery para añadir el responseText  dentro del div "ajax_loader"
                         $('#dialog_res').html("<br>Mensaje: "+responseText);
                         $('#dialog_res').dialog(
                         {modal:true,dialogClass: 'no-close'},{                         
                                buttons: {
                                    Ok: function() {
                                       location.reload();
                                        $(this).dialog('close');
                                    // Need to open external site in new tab/window here
                                    }
                                }
                         });
             };
   //$("#tabs").tabs();
          /*var alta_proyecto= {
                               beforeSubmit: mostrarLoader, //funcion que se ejecuta antes de enviar el form
                               success: mostrar_r_alta_proy //funcion que se ejecuta una vez enviado el formulario
            };
             //asignamos el plugin ajaxForm al formulario myForm y le pasamos las opciones
            $('#forproyecto_alta').ajaxForm(alta_proyecto) ; 
            function mostrarLoader(){
                          $('#loader_gif').fadeIn("slow"); //muestro el loader de ajax
 
             };
             function mostrar_r_alta_proy (responseText){
                           //alert("Mensaje enviado: "+responseText);  //responseText es lo que devuelve la página contacto.php. Si en contacto.php hacemos echo "Hola" , la variable responseText = "Hola" . Aca hago un alert con el valor de response text
                          $("#loader_gif").fadeOut("slow"); // Hago desaparecer el loader de ajax
                          //$("#ajax_loader").append("<br>Mensaje: "+responseText); // Aca utilizo la función append de JQuery para añadir el responseText  dentro del div "ajax_loader"
                         $('#dialog_res').html("<br>Mensaje: "+responseText);
                         $('#dialog_res').dialog(
                         {modal:true,dialogClass: 'no-close'},{                         
                                buttons: {
                                    Ok: function() {
                                       //location.reload();
                                        $(this).dialog('close');
                                        refress_list_proyecto();
                                    // Need to open external site in new tab/window here
                                    }
                                },
                                close: function() {
                                 refress_list_proyecto();
                             }
                         });
             };*/
             

   
   
    });
    
    function  valida_even(){
        if($('#nproyecto :selected').val()!='null')
            if($('#nevento :selected').val()!='null'){
                      $('#tab_A, #tab_CC, #tab_BCC').html('Cargando <img src="../Imgs/loader.gif"> ...');
                           $.post("consultaEventos.php",{
                                    proyecto:$('#nproyecto :selected').val(),
                                    evento:$('#nevento :selected').val(),
                                    tipo:1
                                }, 
                                function (data){                            
                                $("#tab_A").html(data);
                            });
                            $.post("consultaEventos.php",{
                                    proyecto:$('#nproyecto :selected').val(),
                                    evento:$('#nevento :selected').val(),
                                    tipo:2
                                }, 
                                function (data){                            
                                $("#tab_CC").html(data);
                            });
                            $.post("consultaEventos.php",{
                                    proyecto:$('#nproyecto :selected').val(),
                                    evento:$('#nevento :selected').val(),
                                    tipo:3
                                }, 
                                function (data){                            
                                $("#tab_BCC").html(data);
                            });
                      consultar_tipo(panel_tipo(),panel_seleted());
                    
            }else{
                $('<p>').text('Selecione un Evento').appendTo('#tab_A, #tab_CC, #tab_BCC').asError();
                $('#Usuario_add').html('<option value="null">Error....<option>');
            }
       else{
            $('<p>').text('Selecione un Proyecto').appendTo('#tab_A, #tab_CC, #tab_BCC').asError();
            $('#Usuario_add').html('<option value="null">Error....<option>'); 
       }
 // });
    }
     
function activar_proyecto(obj){
    if($('#'+$(obj).attr("name")).val()){
        $(obj).attr("src", "../Imagenes/inactivo.gif");
        $('#'+$(obj).attr("name")).val('');
        var x=$('#usuario_permiso option:selected').val()
		console.log('inactivo desativando', obj, $(obj).attr("value"), x);
        $.post( "alta_proyecto_user.php",{'idproyecto':$(obj).attr("value"), 'idusuario':x}, function( data ) {
          //$( ".result" ).html( data );
          console.log(data);
        });

	
        }
        else{
          $(obj).attr("src", "../Imagenes/activo.gif");
           $('#'+$(obj).attr("name")).val($(obj).attr("value")); 
		console.log('activo')
        }
}
function activar_desactivar_proyecto(obj){
    if($('#'+$(obj).attr("name")).val()){
        $(obj).attr("src", "../Imagenes/offline16.png");
        $('#'+$(obj).attr("name")).val('');
        $.post("activar_desactivar_proyecto.php",{
             id_proyect:$(obj).attr('value'),
             status:false
         }, 
         function (data){  
		console.log('inactivo')                         
   //// no result
      });
        }
        else{
          $(obj).attr("src", "../Imagenes/activo.gif");
          $('#'+$(obj).attr("name")).val($(obj).attr("value")); 
          $.post("activar_desactivar_proyecto.php",{
             id_proyect:$(obj).attr('value'),
             status:true
         }, 
         function (data){ 
	console.log('activo')                                
   //// no result
      });
   }
}
        
function validar_listo(){
    //alert($('#usuarioalta :selected').val());
    
     if($('#usuarioalta :selected').val()!='null')
         $('#formalta #submit').attr('disabled',false);
     else{
         $('#dialog_res').html("<br>Mensaje: Seleciona una usuario");
                         $('#dialog_res').dialog({modal:true});
        $('#formalta #submit').attr('disabled',true); 
     }
            
 }
   function opcion_selecionada(obj,panel){
             $('#panelusers a').css("background","");
            $(obj).css("background","#006699 repeat-x center bottom");
            $(obj).css("background","#006699 repeat-x center bottom");
            $('#alta_usuario, #baja_usuario').hide();
            $('#'+panel).show();

        };
        
function mis_proyectos(){            
    if($('#usuario_permiso :selected').val()!='null')
       $.post("proy_user_permitidos.php",{
             users:$('#usuario_permiso :selected').val()
         }, 
         function (data){                            
           $("#lista_proyectos").html(data);
      });
    else{
        $('#dialog_res').html("<br>Mensaje: Seleciona una usuario");
        $('#dialog_res').dialog({
            modal:true
        });
        $('#formalta #submit').attr('disabled',true); 
    }
            
}
 function validar_activado_proyec(obj){
     if($('#'+$(obj).attr("name")).val()){
         $('#im_m'+$('#'+$(obj).attr("name")).val()).hide();
     }else{
         $('#im_m'+$(obj).attr("value")).show();
     }
 } 
 
 function proyecto_menu(obj,title,idproyecto){     
        $.post("llistar_opciones_menu.php",{
            users:$('#usuario_permiso :selected').val(),
            proyec:idproyecto
        }, 
        function (data){                            
            $("#dialog_menus").html(data);
            $('#dialog_menus').dialog(
                {
                modal:true, 
                width:400,
                heigth:100,
                closeOnEscape: false
                },
                {
                    buttons: {                     
                     Cancelar: function() {
                       mis_proyectos(); 
                       $(this).dialog('close');
                     },
                     Aplicar: function() {
                      $(this).dialog('close');
                      $.ajax({type:'POST', url: 'permisos_del_proyecto_user.php', data:$('#forpermisos').serialize(), success: function(response) {
                          $('#dialog_res').html("<br>Mensaje: "+response);                          
                          $('#dialog_res').dialog(
                         {modal:true,dialogClass: 'no-close'},{                         
                                buttons: {
                                    Ok: function() {                                       
                                      // location.reload();
                                        $(this).dialog('close');   // Need to open external site in new tab/window here
                                    }
                                }
                           }
                         );
                        }});
                       mis_proyectos();  
                     }
                    },
                     close: function() {
                        mis_proyectos();
                     }
                }
            );
            $("span.ui-dialog-title").text('Permisos->'+title);
        });
   }
 function activar_proy_menu(obj){
    if($('#ap'+$(obj).attr("name")).val()){
        $(obj).attr("src", "../Imagenes/offline16.png");
        $('#ap'+$(obj).attr("name")).val('');
        }
        else{
          $(obj).attr("src", "../Imagenes/activo.gif");
           $('#ap'+$(obj).attr("name")).val($(obj).attr('name')); 
        }
}
jQuery.fn.asError = function() {
    return this.each(function() {
        $(this).replaceWith(function(i, html) {
            var newHtml = "<div class='ui-state-error ui-corner-all' style='padding: 0 .7em;'>";
            newHtml += "<p><span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'>";
            newHtml += "</span>";
            newHtml += html;
            newHtml += "</p></div>";
            return newHtml;
        });
    });
};
 
jQuery.fn.asHighlight = function() {
    return this.each(function() {
        $(this).replaceWith(function(i, html) {
            var newHtml = "<div class='ui-state-highlight ui-corner-all' style='padding: 0 .7em;'>";
            newHtml += "<p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'>";
            newHtml += "</span>";
            newHtml += html;
            newHtml += "</p></div>";
            return newHtml;
        });
    });
};

function consultar_tipo(tipo,panel){
    $('#Usuario_add').html('Cargando ...');
     $(panel).html('Cargando <img src="../Imgs/loader.gif"> ...');
    $.post("consultaEventos.php",{
        proyecto:$('#nproyecto :selected').val(),
        evento:$('#nevento :selected').val(),
        tipo:tipo
    }, 
    function (data){                            
        $(panel).html(data);
    });
    
    $.post("consulta_usuarios_addEventos.php",{
        proyecto:$('#nproyecto :selected').val(),
        evento:$('#nevento :selected').val(),
        tipo:tipo
    }, 
    function (data){                            
        $('#Usuario_add').html("<option value='null'> - Selecione un Usuario - </option>"+data);
    });
}

function inserta_user_notificaciones(){
    $.post("insert_notificaciones.php",{
        proyecto:$('#nproyecto :selected').val(),
        evento:$('#nevento :selected').val(),
        user:$('#Usuario_add :selected').val(),
        tipo:panel_tipo()
        
    }, 
    function (data){                            
        $(panel).html(data);
        consultar_tipo(panel_tipo(),panel_seleted());
    });
}
function eliminar_notif_user(usuario){
    $.post("eliminar_notif.php",{
        proyecto:$('#nproyecto :selected').val(),
        evento:$('#nevento :selected').val(),
        user:usuario,
        tipo:panel_tipo()
        
    }, 
    function (data){                            
        //$(panel).html(data);
        consultar_tipo(panel_tipo(),panel_seleted());
    });
}

function panel_tipo(){
    tipo=0;
    if($('#tab_A').is(':visible'))
      tipo=1;
    else if($('#tab_CC').is(':visible'))
      tipo=2;
    else
      tipo=3;    
   return tipo;
}
function panel_seleted(){
    panel='';;
    if($('#tab_A').is(':visible'))
     panel='#tab_A';
    else if($('#tab_CC').is(':visible'))
       panel='#tab_CC';
    else
       panel='#tab_BCC';
   return  panel;
}

function refress_list_proyecto(){
     $.post("refress_proy.php",{}, 
    function (data){                            
        $("#list_proy").html(data)
    });
    
}
/*function enlistar_proy_all(){
    
}*/

 /*i><a href="#tab_A" onclick="consultar_tipo(1,'#tab_A')"><span>Para(A)</span></a></li>
                          <li><a href="#tab_CC" onclick="consultar_tipo(2,'#tab_CC')"><span>Con Copia(CC)</span></a></li>
                          <li><a href="#tab_BCC"*/




