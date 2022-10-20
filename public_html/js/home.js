var app = angular.module('home', []);


app.controller('home', function ($scope, $http) {

});

app.filter('activoInactivo', function() {
    return function(input) {
        return input ? 'Activo' : 'Inactivo';
    }
});
app.filter('siNo', function() {
    return function(input) {
        return input ? 'Si' : 'No';
    }
});
