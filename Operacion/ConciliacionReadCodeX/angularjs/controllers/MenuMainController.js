/**
* ObrasListController
* Controlador del listado de Obras
*/
function MenuMainController($scope, $route) {
    $scope.nombreusuario="";
   if(typeof(sessionStorage.getItem("key")) != 'undefined' || sessionStorage.getItem("key")!=null){
        $scope.nombreusuario=sessionStorage.getItem('user');
   }   
   $scope.cerrarsesion=function (){
     sessionStorage.clear();
     location.reload();
  }
    /*
        $location.path('/login');
  $http.get('data/obras.json').success(function(data) {
	$scope.obras = data;
  });
$scope.go=function (nombreobra, idobra){
      dataApp.data.nombreobra=nombreobra;
      dataApp.data.idobra=idobra;
      // console.log("regresa");
      console.log(dataApp.data);
     // $location.path('/login/'+idobra);
  }
  
 
  //defines una variable
  $scope. = "variable definida desde el controlador";
  
  //selecciona el desplegable y ordena automaticamente, variable definida en la vista con ng-model
  $scope.orderField = "name";
  $scope.orderReverse = "true";*/
     
     
    
}