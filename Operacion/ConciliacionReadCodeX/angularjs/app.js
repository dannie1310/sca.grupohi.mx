var App = angular.module('app', ['ngStorage', 'ui.keypress']);

//definimos las rutas de la 'app'
App.config(['$routeProvider', function($routes) {
        $routes.
                /*when('/login', {
                 templateUrl: 'angularjs/views/login.html',
                 controller: LoginController
                 }).*/
                when('/captura', {
                    templateUrl: 'angularjs/views/CapturaCode.html',
                    controller: capturaController
                }).
                //mediante dos puntos (:) definimos un parámetro
                when('/conciliacion/:conciliacionId', {
                    templateUrl: 'angularjs/views/Conciliacion.html',
                    controller: conciliacionController
                }).
                when('/modificar-conciliacion/:conciliacionId', {
                    templateUrl: 'angularjs/views/ModificarConciliacion.html',
                    controller: ModificarConciliacionController
                }).
                when('/agregar-viajes/:conciliacionId', {
                    templateUrl: 'angularjs/views/AgregarViajes.html',
                    controller: AddViajesConciliacionController
                }).
                when('/conciliaciones', {
                    templateUrl: 'angularjs/views/Conciliaciones.html',
                    controller: ConciliacionesController
                }).
                //cualquier ruta no definida  
                otherwise({
                    redirectTo: '/captura'});

    }]);


App.factory("dataApp", function() {
    return {
        data: {}
    }
});

App.directive('ngEnter', function() {
    return function(scope, element, attrs) {
        element.bind("keydown keypress", function(event) {
            //console.log(event.which);
            if (event.which === 13) {
                scope.$apply(function() {
                    scope.$eval(attrs.ngEnter);
                });
                event.preventDefault();
            }
        });
    };
});

$.fn.bgColorFade = function(userOptions) {
    // starting color, ending color, duration in ms
    var options = $.extend({
        start: "#fff79f",
        end: "#fff",
        time: 2000
    }, userOptions || {});
    $(this).css({
        backgroundColor: options.start
    }).animate({
        backgroundColor: options.end
    }, options.time);
    return this;
};
function IsValidDate(myDate) {
    var filter = /^([012]?\d|3[01])-([Jj][Aa][Nn]|[Ff][Ee][bB]|[Mm][Aa][Rr]|[Aa][Pp][Rr]|[Mm][Aa][Yy]|[Jj][Uu][Nn]|[Jj][u]l|[aA][Uu][gG]|[Ss][eE][pP]|[oO][Cc]|[Nn][oO][Vv]|[Dd][Ee][Cc])-(19|20)\d\d$/
    return filter.test(myDate);
}

/*App.filter('isStatus', function() {
 return function(input, status) {
 var out = [];
 for (var i = 0; i < input.length; i++){
 if(input[i].status == status)
 out.push(input[i]);
 }      
 return out;
 };
 });*/
