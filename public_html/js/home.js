var app = angular.module('home', ["angularUtils.directives.dirPagination"]);


app.controller('home', function ($interval, $scope, $http) {
    $scope.currentPage = 1;
    $scope.pageSize = 10;  

    $scope.dato = {};
    $scope.datos = [];

    var interval;
    
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

    // starts the interval
    $scope.start = function () {
        // stops any running interval to avoid two intervals running at the same time
        $scope.stop();
        // store the interval promise
        interval = $interval(updateLectura, 3000);
        $('.update-bitacora').removeClass('btn-success').addClass('btn-danger');
    };

    // stops the interval
    $scope.stop = function () {
        $scope.detenido = $interval.cancel(interval);
        //console.log($scope.detenido);
        $('.update-bitacora').removeClass('btn-danger').addClass('btn-success');
    };

    // start interval
    $scope.start();

    function updateLectura() {
        console.log("update works!");
        // let yourDate = new Date();
        // const off = yourDate.getTimezoneOffset();
        // yourDate = new Date(yourDate.getTime() - (off * 60 * 1000));

        // //console.log("function works");

        // var fecha_desde = $('#fecha_in').val();
        // var fecha_hoy = yourDate.toISOString().split('T')[0];
        // console.log(fecha_desde);
        // console.log(fecha_hoy);

        // if (Date.parse(fecha_desde) == Date.parse(fecha_hoy)) {


        // } else {

        //     $scope.stop();
        // }


        $http({
            url: 'api/get-datos',
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },

        }).then(
            function successCallback(response) {
                $scope.datos = response.data.datos;
            },
            function errorCallback(response) {
                console.log(response);
                // swal(
                //     bitacora.titulo,
                //     response.data.message,
                //     tiposDeMensaje.error
                // );
            }
        );
    }
    
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
