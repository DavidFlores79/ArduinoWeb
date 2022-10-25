var app = angular.module('home', ["angularUtils.directives.dirPagination"]);


app.controller('home', function ($interval, $scope, $http) {
    $scope.currentPage = 1;
    $scope.pageSize = 10;

    $scope.dato = {};
    $scope.datos = [];
    $scope.tempData = {};
    $scope.series = [];
    $scope.data = [];

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

            let series = [
                {
                    name: 'series-1',
                    data: []
                },
            ];

            console.log('scope data series', series);

            $scope.datos.forEach(registro => {
                series[0].data.push({ x: registro.created_at, y: registro.temperatura });
            });


            $scope.series = {
                series: series
            }, {
                axisX: {
                    type: Chartist.FixedScaleAxis,
                    divisor: 5,
                    labelInterpolationFnc: function (value) {
                        console.log(value);
                        return moment(value).format('MMM D');
                    }
                }
            };
            //var chart = new Chartist.Line('.ct-chart', $scope.series);

            var chart = new Chartist.Line('.ct-chart', {
                series: [
                  {
                    name: 'series-1',
                    data: [
                      {x: new Date(143134652600), y: 53},
                      {x: new Date(143234652600), y: 40},
                      {x: new Date(143340052600), y: 45},
                      {x: new Date(143366652600), y: 40},
                      {x: new Date(143410652600), y: 20},
                      {x: new Date(143508652600), y: 32},
                      {x: new Date(143569652600), y: 18},
                      {x: new Date(143579652600), y: 11}
                    ]
                  },
                ]
              }, {
                axisX: {
                  type: Chartist.FixedScaleAxis,
                  divisor: 5,
                  labelInterpolationFnc: function(value) {
                    return moment(value).format('hh:mm');
                  }
                }
              });
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
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    tiposDeMensaje.error
                );
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
