var app = angular.module('home', ["angularUtils.directives.dirPagination"]);


app.controller('home', function ($interval, $scope, $http) {
    $scope.currentPage = 1;
    $scope.pageSize = 10;

    $scope.dato = {};
    $scope.datos = [];
    $scope.tempData = {};

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
            $scope.graficar($scope.datos[0]);
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
        $http({
            url: 'api/get-datos',
            method: "GET",
            headers: {
                "Content-Type": "application/json",
            },

        }).then(
            function successCallback(response) {
                $scope.datos = response.data.datos;
                $scope.graficar($scope.datos[0]);
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

    // Graficas 

    let dataTemp = {};
    let dataHum = {};

    $scope.graficar = function (dato) {
        if (dato.temperatura) {
            chart = '.ct-chart1';
            dataTemp.labels = ['Temperatura'];
            dataTemp.series = [dato.temperatura];
            $scope.mostrarGrafica(chart, dataTemp);
        }

        if (dato.humedad) {
            chart = '.ct-chart2';
            dataHum.labels = ['Humedad'];
            dataHum.series = [dato.humedad];
            $scope.mostrarGrafica(chart, dataHum);
        }

    }

    $scope.mostrarGrafica = function (chart, data) {
        let myChart = new Chartist.Pie(chart, data, {
            donut: true,
            donutWidth: 20,
            donutSolid: true,
            startAngle: 270,
            total: 200,
            showLabel: true,
            width: 300,
            height: 200,
            labelInterpolationFnc: function (value, idx) {
                var centigrades = (data.labels[idx] == 'Temperatura') ? ' ºC' : ' %';
                return data.labels[idx] + ' ' + data.series[idx] + ' ' + centigrades;
            }
        });
        // Set chart color
        // chartTemp.on('draw', function (data) {
        //     data.element._node.setAttribute('style', 'fill: green');
        // });
        // chartHum.on('draw', function (data) {
        //     data.element._node.setAttribute('style', 'fill: orange');
        // });
    }
    // Graficas 


});

app.filter('activoInactivo', function () {
    return function (input) {
        return input ? 'Activo' : 'Inactivo';
    }
});
app.filter('siNo', function () {
    return function (input) {
        return input ? 'Si' : 'No';
    }
});
app.filter('temperatura', function () {
    return function (value) {
        return value + ' °C';
    }
});
app.filter('humedad', function () {
    return function (value) {
        return value + ' %';
    }
});
