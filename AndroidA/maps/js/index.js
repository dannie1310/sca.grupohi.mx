    var img={
     			'1'	: '<i class="icon-autentificacion"></i>',
     			'2'	: '<i class="icon-origen"></i>',
     			'3'	: '<i class="icon-tiro"></i>',
     			'4'	: '<i class="icon-sincronizacion2"></i>'     			
     		};
    var cat_eventos=[
    					{'descripcion':'Autentificaci&oacute;n', 'id':1},
    					{'descripcion':'Origen', 'id':2},
    					{'descripcion':'Tiro', 'id':3},
    					{'descripcion':'Sincronizaci&oacute;n', 'id':4},
     				];
    var date=new Date();
        date.setDate(date.getDate()-1);
    var fecha=date.toISOString().slice(0,10);
        $('#fechainicial, #fechafinal').val('2016-11-07');


    
    var cat_IMEI;/*=[
    			{'IMEI':'123456','checador':'PEDRO DE LA CRUZ', 'idusuario':1},
    			{'IMEI':'654321','checador':'ALFONSO HERNANDEZ', 'idusuario':2},
    		];*/

 	 var locations; /*= [
					     ['Title A', 3.180967,101.715546, 1,1,'123456'],
					     ['Title B', 3.200848,101.616669, 2,2,'123456'],
					     ['Title C', 3.147372,101.597443, 3,3,'123456'],
					     ['Title D', 3.19125,101.710052, 4,4,'123456'],
					     ['Title A', 3.180967,110.715546, 1,1,'654321'],
					     ['Title B', 3.200848,110.616669, 2,2,'654321'],
					     ['Title C', 3.147372,110.597443, 3,3,'654321'],
					     ['Title D', 3.19125,110.710052, 4,4,'654321']
					];*/
    var default_gps=null;
    var dibujar_catalogos=function(){
        var cadena_html_eventos='';
        for (var key in cat_eventos)
                cadena_html_eventos+='<div><input type="checkbox" class="cat_evento" value='+cat_eventos[key]['id']+' checked/>'+img[(parseInt(key)+1)]+' '+cat_eventos[key]['descripcion']+'</div>';
        $('.listevento').html(cadena_html_eventos);

        var cadena_html_IMEI='';
        for (var key in cat_IMEI){
            var color_IMEI_list=parseInt(key)+1;
            cadena_html_IMEI+='<div class="color'+color_IMEI_list+'"><p class="test"><input type="checkbox"  class="cat_IMEI" value='+cat_IMEI[key]['IMEI']+' idusuario="'+cat_IMEI[key]['idusuario']+'" checked/>'+cat_IMEI[key]['checador']+' ['+cat_IMEI[key]['IMEI']+']</p></div>';
        }
        
        $('.listIMEI').html(cadena_html_IMEI);
        
        $(".cat_evento").change(function() {
            filtrar();
        });

        $(".cat_IMEI").change(function() {
           filtrar();
        });

    }

    var descargar_por_fecha = function(){
        var fechaI= $('#fechainicial').val();
        var fechaF= $('#fechafinal').val();
    
        $.post("../../androidA.php", 
            {'db':'prod_sca_pista_aeropuerto_2','metodo':'getCoordenadas', 'fechainicial':fechaI, 'fechafinal':fechaF}, 
            function(data){                
                locations = data.coordenadas;
                console.log(locations);
                if (!locations) {
                    alert('No hay eventos en estas fechas');
                    $('#mostrarMapa').html('');
                    $('.listIMEI').html('');
                    $('.listIMEI').html('');
                    $('.listevento').html('');
                    return false;
                }
                cat_IMEI = data.IMEI;
                //console.log(locations, locations.length);
                dibujar_catalogos();
                default_gps={
                    'logitude':locations[0][1],
                    'latitude': locations[0][2]
                };
                dibujar_coordenadas(locations); 

        }); 
    }

    $('.buttonsubmit').on('click', function(){
        descargar_por_fecha();
    });
//DIBUJAR COORDENADAS
var dibujar_coordenadas=function( _locations){
    console.log('dibujando');
    var latitude_aux;
    var logitude_aux;
    if(_locations.length==0){
         latitude_aux= default_gps.logitude;
         logitude_aux= default_gps.latitude;
    }else{
         latitude_aux=_locations[0][1];
         logitude_aux=_locations[0][2]
    }

    var map = new google.maps.Map(document.getElementById('mostrarMapa'), {
     zoom: 12,
     center: new google.maps.LatLng(latitude_aux, logitude_aux),
     mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow;
    
    var marker, i, IMEi=0;
    //var color='color';    
    for (i = 0; i < _locations.length; i++) {
        var _color;
        for (var xx in cat_IMEI){ 
            console.log(cat_IMEI[xx]['IMEI'],_locations[i][5] , cat_IMEI[xx]['idusuario'],_locations[i][8]);
               if(cat_IMEI[xx]['IMEI']==_locations[i][5] && cat_IMEI[xx]['idusuario']==_locations[i][8]){
                console.log('si');
                _color=cat_IMEI[xx]['color'];
                break;
               }
        }
        console.log("Color=",_color);
        marker = new MarkerWithLabel({
             position: new google.maps.LatLng(_locations[i][1], _locations[i][2]),
             draggable:false,
             raiseOnDrag:false,
             map: map,
             icon:' ',
             labelContent:img[_locations[i][3]],
             labelAnchor:  new google.maps.Point(22,50),
             labelClass:_color
        });
        marker.setMap(map);

        google.maps.event.addListener(marker, 'click', (function(marker, i) {
             return function() {
                 infowindow.setContent(_locations[i][0]);
                 infowindow.open(map, marker);
             }
        })(marker, i));
    }
}
//FILTROS
var filtrar=function(){
    console.log('filtrando');
    var _aux=[], _aux_IMEI=[], _locations=[];
    $(".cat_evento").each(function( index ) { 
        if($(this).is(':checked')){
            var val=$(this).val();
            _aux.push({'descripcion':cat_eventos[val], 'id':val});
        }
    });
    $(".cat_IMEI").each(function( index ) { 
        if($(this).is(':checked')){
            var val=$(this).val();
            _aux_IMEI.push({'descripcion':cat_eventos[val], 'id':val, 'idusuario':$(this).attr('idusuario')});
        }
    });
    console.log(_aux_IMEI);
    for (var key in locations) 
        for(var key_aux in _aux)
            for(var key_imei in _aux_IMEI){                
                if(locations[key][3]==parseInt(_aux[key_aux].id) && locations[key][5]==_aux_IMEI[key_imei].id && locations[key][8]==_aux_IMEI[key_imei].idusuario){                    
                    _locations.push(locations[key]);
                }
            }

    dibujar_coordenadas(_locations);
}


$(document).ready(function(){
    //dibujar_coordenadas(locations);
    //dibujar_catalogos();
    descargar_por_fecha();
            $("#fechainicial").datepicker({
        onClose: function (selectedDate) {
        $("#fechafinal").datepicker("option", "minDate", selectedDate);
        }
        });
        $("#fechafinal").datepicker({
        onClose: function (selectedDate) {
        $("#fechainicial").datepicker("option", "maxDate", selectedDate);
        }
        });
        $('#fechainicial, #fechafinal').attr('readonly', true);
});



