function conciliacionController($scope, $http, $location, dataApp, $routeParams) {
    $scope.id = $routeParams.conciliacionId;
    console.log($scope.id);
    $scope.conciliacion=[];
    $scope.obj=[];
    $scope.importetotal=0;
    $http.get('server/loader.php?class=conciliacion&function=getConciliacion&conciliacion='+$scope.id).success(function(data) {
        
        $scope.conciliacion=data;
        $scope.obj=$scope.conciliacion[0];
        for(var x in $scope.conciliacion){
           console.log($scope.conciliacion[x].importetotal);
           var numero=parseFloat($scope.importetotal);           
           var res=numero+parseFloat($scope.conciliacion[x].importetotal);
           $scope.importetotal=res.toFixed(2);
        }
        console.log( data);
    
    });
    
    
}
