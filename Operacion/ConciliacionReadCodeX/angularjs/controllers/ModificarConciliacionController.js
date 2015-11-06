function ModificarConciliacionController($scope, $http, $location, $routeParams) {
    $scope.id = $routeParams.conciliacionId;
    console.log($scope.id);
    $scope.conciliacion = [];
    $scope.obj = [];
    
    $scope.importetotal = 0;
    $http.get('server/loader.php?class=conciliacion&function=getConciliacion&conciliacion=' + $scope.id).success(function(data) {
        $scope.conciliacion = data;
        $scope.obj = $scope.conciliacion[0];
        $scope.observacion=$scope.conciliacion[0].observaciones;
        for (var x in $scope.conciliacion) {
            console.log($scope.conciliacion[x].importetotal);
            var numero = parseFloat($scope.importetotal);
            var res = numero + parseFloat($scope.conciliacion[x].importetotal);
            $scope.importetotal = res.toFixed(2);
        }
        console.log(data);
    });
    $scope.eliminarViaje = function(conciliacion, viaje) {
        var r = confirm("Esta seguro de eliminar el viaje!");
        if (r != true)
            return false
        $http.post('server/loader.php?class=conciliacion&function=setEliminarViaje', {conciliacion: conciliacion, viaje: viaje}).success(function(data) {
            if (data.error)
                console.log(data)
            else {
                console.log(data)
                $http.get('server/loader.php?class=conciliacion&function=getConciliacion&conciliacion=' + $scope.id).success(function(data) {
                    $scope.conciliacion = data;
                });
            }
        });
        console.log(conciliacion, viaje);
    }
    $scope.guardarObservacion=function (valor){
        $http.post('server/loader.php?class=conciliacion&function=setModificarObservacion', {conciliacion: valor, observacion:$scope.observacion}).success(function(data) {
            if(data.msj){
                alert(data.msj);
            }else
                alert(data.error);
           console.log(data);
        });
        console.log(valor);
        console.log($scope.observacion);
    }

}


