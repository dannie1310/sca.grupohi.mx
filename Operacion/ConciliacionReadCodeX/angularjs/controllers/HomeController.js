function permisosController($scope, $http, $location, dataApp) {
     $http.get('server/loader.php?class=consultas&function=getPermisos').success(function(data) {
        $scope.permisos= data;  
        console.log($scope.permisos, data)
    });
}
