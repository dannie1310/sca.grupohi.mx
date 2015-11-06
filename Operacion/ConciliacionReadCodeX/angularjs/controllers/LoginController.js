function LoginController($scope, $http, $location,$route) {
    $('form.fondogris').hide();
    if (typeof (sessionStorage.getItem("key")) != 'undefined' && sessionStorage.getItem("key") != null){
        $location.path('/obras');
    }


    $scope.form = {};
    $scope.form.user = "";
    $scope.form.password = "";

    $scope.form.submitTheForm = function(item, event) {
        /*sessionStorage.setItem("key",$scope.form.user);
         sessionStorage.setItem("user",$scope.form.user);
         sessionStorage.setItem("password",$scope.form.password);*/
        /*$http.post('server/',{user:$scope.form.user,pass:$scope.form.password}).success(function (data){
         $scope.datos=data;
         // console.log(data);
         console.log($scope.form, "hola nnn");
         });*/
        var dataObject = {
            user: $scope.form.user
            , password: $scope.form.password
        };
        $http({
            url: 'server/loader.php?class=consultas&function=getAutentication'
            , method: 'POST'
            , data: JSON.stringify({'class':'consultas', 'function':'getAutentication', 'user': $scope.form.user, 'pass': $scope.form.password})
            , headers: {'Content-Type': 'application/json'}
        }).success(function(data, status, headers, config) {
            console.log('idusuario', data.user.IdUsuario);
            if (typeof (data.user.IdUsuario) === 'undefined') {
                console.log('Login incorrecto');
            } else {
                console.log('Login correcto');
                sessionStorage.setItem("key",  data.user.IdUsuario);
                sessionStorage.setItem("user",  data.user.Descripcion);
                location.reload();
                //$location.path('/obras');
            }
            console.log(data);

        }).error(function(data, status, headers, config) {
            console.log('Error el el API');

        });

    }
    /*$scope.login = function() {
     console.log($scope);
     // Authenticate the user - send a restful post request to the server
     // and if the user is authenticated successfully, a token is returned
     /* $http.post('http://localhost/login', $scope.user)
     .success(function(response) {
     // Set a sessionStorage item we're calling "token"
     sessionStorage.setItem("token", response.token);
     // Redirect to wherever you want to
     $location.path('/obras');  
     //window.location = 'index.html';
     });*/
    //};
}