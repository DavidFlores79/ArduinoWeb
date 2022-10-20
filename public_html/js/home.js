var app = angular.module('home', []);


app.controller('home', function ($scope, $http) {


    $scope.dato = {};
    $scope.datos = [];
    
    $http({
        url: 'api/get-datos',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log('index', response);
            $scope.datos = response.data.datos;
        },
        function errorCallback(response) {
            console.log(response);
            if (response.status === 422) {
                let mensaje = '';
                for (let i in response.data.errors) {
                    mensaje += response.data.errors[i] + '\n';
                }
                swal('Mensaje del Sistema', mensaje, 'error');
            } else {
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            }
        }
    );

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
app.filter('temperatura', function() {
    return function(value) {
        return value + ' °C';
    }
});
app.filter('humedad', function() {
    return function(value) {
        return value + ' %';
    }
});
