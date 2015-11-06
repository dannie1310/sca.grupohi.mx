function ConciliacionesController($scope, $http, $location) {
    $scope.conciliaciones = [];

    $http.get('server/loader.php?class=consultas&function=getSindicatos').success(function(data) {
        $scope.sindicatos = data;
    });
    $http.get('server/loader.php?class=conciliacion&function=getConciliaciones').success(function(data) {
        if (data.nodata)
            console.log(data.nodata);
        else
            $scope.conciliaciones = data;
        console.log($scope.conciliaciones);
    });
    $scope.bysindicato = function(viajecode) {
        //console.log($scope.selectedItem, "que pasa");
        if (typeof $scope.selectedItem == 'undefined')
            return true;
        return viajecode.idsindicato == $scope.selectedItem;
    }
    $http.get('server/loader.php?class=consultas&function=getPermisos').success(function(data) {
        $scope.permisos = data;
        //console.log($scope.permisos, data)
    });


    $scope.aprobarConciliacion = function(valor, code) {
        $http.post('server/loader.php?class=conciliacion&function=setAprobarConciliacion', {conciliacion: valor}).success(function(data) {
            console.log($scope.conciliaciones);
            var temp;
            if (data.id > 0) {
                console.log('Actualizado correctamente');
                for (var index in $scope.conciliaciones) {
                    if ($scope.conciliaciones[index].code == code) {
                        $scope.conciliaciones[index].estado = 2;
                    }
                }
            }
            console.log(data)
        });

    }
    $scope.desaprobarConciliacion = function(valor, code) {
        $http.post('server/loader.php?class=conciliacion&function=setDesaprobarConciliacion', {conciliacion: valor}).success(function(data) {
            console.log($scope.conciliaciones);
            var temp;
            if (data.id > 0) {
                console.log('Actualizado correctamente');
                for (var index in $scope.conciliaciones) {
                    if ($scope.conciliaciones[index].code == code) {
                        $scope.conciliaciones[index].estado = 1;
                    }
                }
            }
            console.log(data)
        });

    }
    $scope.modificarConciliacion = function(valor) {
        $location.path('/modificar-conciliacion/' + valor);
    }
    $scope.eliminarConciliacion = function(valor) {
        var r = confirm("Esta seguro de eliminar la conciliación!");
        if (r != true)
            return false
        $http.post('server/loader.php?class=conciliacion&function=setEliminarConciliacion', {conciliacion: valor}).success(function(data) {
            console.log($scope.conciliaciones);
            $http.get('server/loader.php?class=conciliacion&function=getConciliaciones').success(function(data) {
                if (data.nodata){
                     $scope.conciliaciones = [];
                    console.log(data.nodata);
                }
                else
                    $scope.conciliaciones = data;
                console.log($scope.conciliaciones);
            });
        });

        console.log(valor, "eliminar");
    }
    $scope.detallesConciliacion = function(valor) {
        $location.path('/conciliacion/' + valor);
    }
    $scope.AgregarViajesConciliacion = function(valor) {
        $location.path('/agregar-viajes/' + valor);
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
