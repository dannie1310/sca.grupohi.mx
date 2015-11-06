
function capturaController($scope, $http, $location, dataApp) {
    function animar() {
        $(".mensajes").show(200).bgColorFade({
            time: 800
        }).delay(2000).hide(200);
    }
    $scope.error = '';
    $scope.viajestemp = [];
    $http.get('server/loader.php?class=consultas&function=getSindicatos').success(function(data) {
        $scope.sindicatos = data;

    });
    $scope.addConciliacion = function(code, estatus) {
        for (var index in $scope.viajestemp) {
            if ($scope.viajestemp[index].code == code) {
                $scope.viajestemp[index].status = estatus;
            }
        }
    }
    $scope.addSelectedAll = function() {
        for (var index in $scope.viajestemp) {
            if ($scope.viajestemp[index].seleccionado == true) {
                $scope.viajestemp[index].status = 1;
            }
            $scope.viajestemp[index].seleccionado = true;
        }
    };
    $scope.deleteSelectedAll = function() {
        for (var index in $scope.viajestemp) {
            if ($scope.viajestemp[index].seleccionado == true) {
                $scope.viajestemp[index].status = 0;
            }
            $scope.viajestemp[index].seleccionado = true;
        }
    };
    $scope.byStatusId = function(viajecode) {
        return viajecode.status == 0;
    }
    $scope.byStatusId2 = function(viajecode) {
        return viajecode.status == 1;
    }
    $scope.bysindicato = function(viajecode) {
        return viajecode.idsindicato == $scope.selectedItem;
    }
    $scope.bydateiniciofin = function(viajecode) {
        var date = $("#fechainiacial").datepicker('getDate');
        var iniciofechaint = $.datepicker.formatDate('yymmdd', date);
        date = $("#fechafinal").datepicker('getDate');
        var finfechaint = $.datepicker.formatDate('yymmdd', date);
        date = $("#fechafinal").datepicker('getDate');
        var datetempx = $.datepicker.parseDate('yy-mm-dd', viajecode.fechallegada);
        var viajefechaint = $.datepicker.formatDate('yymmdd', datetempx);

        if (viajefechaint >= iniciofechaint && viajefechaint <= finfechaint)
            return true;
        else
            return false;
    }
    $scope.buscarCode = function() {
        animar();
        if ($("#fechainiacial").val() == "") {
            $scope.error = "Fecha inicial formato inválida  dd-MM-yyyy";
            return false;
        }
        if ($("#fechafinal").val() == "") {
            $scope.error = "Fecha final formato inválida  dd-MM-yyyy";
            return false;
        }
        if (typeof $scope.selectedItem == 'undefined') {
            $scope.error = "Selecione un sindicato";
            return false;
        }
        if (typeof $scope.code == 'undefined') {
            $scope.error = "Error código no especificado";
            return false;
        }
        var date = $("#fechainiacial").datepicker('getDate');
        var fechainicial = $.datepicker.formatDate('yy-mm-dd', date);
        var iniciofechaint = $.datepicker.formatDate('yymmdd', date);

        date = $("#fechafinal").datepicker('getDate');
        var finfechaint = $.datepicker.formatDate('yymmdd', date);
        var fechafinal = $.datepicker.formatDate('yy-mm-dd', date);

        if (0 > finfechaint - iniciofechaint) {
            $scope.error = "Error la fecha final debe ser mayor que la fecha inicial";
            return false;
        }
        $http.get('server/loader.php?class=consultas&function=getConsultaviajesaconsiliar&code='
                + $scope.code
                + '&fechainicial=' + fechainicial
                + "&fechafinal=" + fechafinal
                + "&sindicato=" + $scope.selectedItem
                ).success(function(data) {
            if (data.error) {
                $scope.error = data.error;
                return false;
            }
            if (data.idviaje) {
                var existeya = 0;
                for (var aux in $scope.viajestemp) {
                    if ($scope.viajestemp[aux].code == data.code) {
                        existeya = 1;
                        $scope.error = "Ya existe el código " + $scope.code + " en la lista";
                    }
                }
                if (existeya == 0) {
                    $scope.viajestemp.push(data);
                    $scope.error = "Se a agregado un nuevo viaje con código " + $scope.code;
                }
                $scope.code = "";

            } else {
                $scope.error = "El código " + $scope.code + " no se ecuentra ";

            }
        }).error(function(data, status, headers, config) {
            if (status == '500') {
                $scope.error = "No hay conexión con el servidor.";
            }
            if (status == '404') {
                $scope.error = "Error ruta del servidor no encontrada server/loader.php?class=consultas&function=getConsultaviajesaconsiliar&code=" + $scope.code;
            } else
                $scope.error = "Error inesperado es posible que no haya conexión en la red, intente más tarde";

        });
    }
    $scope.generarConciliacion = function() {
         var observacion=$('#observaciones').val();
        var r = confirm("Esta seguro de dar de alta la conciliacion!");
        if (r != true)
            return false
        
        animar();
        var date = $("#fechainiacial").datepicker('getDate');
        var iniciofechaint = $.datepicker.formatDate('yymmdd', date);
        var iniciofecha = $.datepicker.formatDate('yy-mm-dd', date);
        date = $("#fechafinal").datepicker('getDate');
        var finfechaint = $.datepicker.formatDate('yymmdd', date);
        var finfecha = $.datepicker.formatDate('yy-mm-dd', date);
        date = $("#fechafinal").datepicker('getDate');

        var datetempx, viajefechaint;

        var aconciliar = [];
        for (var obj in $scope.viajestemp) {
            datetempx = $.datepicker.parseDate('yy-mm-dd', $scope.viajestemp[obj].fechallegada);
            viajefechaint = $.datepicker.formatDate('yymmdd', datetempx);

            if (viajefechaint >= iniciofechaint && viajefechaint <= finfechaint)
                if ($scope.selectedItem == $scope.viajestemp[obj].idsindicato)
                    if ($scope.viajestemp[obj].status == 1)
                        aconciliar.push($scope.viajestemp[obj]);
        }
        
       
        
        $http.post('server/loader.php?class=conciliacion&function=setConciliacion', {'fechainicio': iniciofecha, 'fechafin': finfecha, 'observacion': observacion,  'data': aconciliar}
        ).success(function(data, status, headers, config) {            
            if(data.error){
                $scope.error = data.error;  
                return false;
            }
            if(data.conciliacion){
              $scope.error = "Se ha dado de alta la conciliación folio #"+data.conciliacion;
               $location.path('conciliacion/'+data.conciliacion);
            }
           console.log(data);
        }).error(function(data, status) {
            consol.log(data)
        });


    }


    $(".fecha").datepicker(
            {dateFormat: 'dd-M-yy'}
    );


    $(".fecha").blur(function() {
        var date1 = $(this).val();
        if (date1 != "") {
            var validate = IsValidDate(date1);
            if (!validate) {
                $scope.error = "Fecha inicial formato invalida  dd-MM-yyyy";
                $(this).val("");
                animar();
            }
        }
    });
}

