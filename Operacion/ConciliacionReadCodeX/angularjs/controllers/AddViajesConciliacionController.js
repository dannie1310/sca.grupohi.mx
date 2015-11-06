function AddViajesConciliacionController($scope, $http, $location,$route,$routeParams) {
    function animar() {
        $(".mensajes").show(200).bgColorFade({
            time: 800
        }).delay(2000).hide(200);
    }
    $scope.error = '';
        $scope.idconciliacion = $routeParams.conciliacionId;
        $http.post('server/loader.php?class=conciliacion&function=getAddConciliacion&conciliacion='+$scope.idconciliacion)
            .success(function(data) {
                $scope.folio=data[0].folio;
                $scope.fcinicial=data[0].fcinicial;
                $scope.fcfinal=data[0].fcfinal;
                $scope.sindicato=data[0].sindicato;
                $scope.idsindicato=data[0].idsindicato;
                $scope.viajestemp=data;            
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
     $scope.buscarCode = function() {
        animar();
        if (typeof $scope.code == 'undefined') {
            $scope.error = "Error código no especificado";
            return false;
        }
        $http.get('server/loader.php?class=consultas&function=getConsultaviajesaconsiliar&code='
                + $scope.code
                + '&fechainicial=' + $scope.fcinicial
                + "&fechafinal=" + $scope.fcfinal
                + "&sindicato=" + $scope.idsindicato
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

    $scope.actualizarConciliacion = function() {
         var observacion=$('#observaciones').val();
        var r = confirm("Esta seguro de dar de actualizar la conciliaion!");
        if (r != true)
            return false
        
        animar();

        var aconciliar = [];
        for (var obj in $scope.viajestemp) {
            if ($scope.viajestemp[obj].status == 1)
                aconciliar.push($scope.viajestemp[obj]);
        }

        $http.post('server/loader.php?class=conciliacion&function=actualizarConciliacion', {'observacion': observacion,  'data': aconciliar}
        ).success(function(data, status, headers, config) {            
            if(data.error){
                $scope.error = data.error;  
                return false;
            }
            if(data.conciliacion){
              $scope.error = "Se ha dado de actualizado la conciliación folio #"+data.conciliacion;
               $location.path('conciliacion/'+data.conciliacion);
            }
           console.log(data);
        }).error(function(data, status) {
            consol.log(data)
        });


    }

}