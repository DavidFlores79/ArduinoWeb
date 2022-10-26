var app = angular.module("home", ["angularUtils.directives.dirPagination"]);

app.controller("home", function ($interval, $scope, $http) {
  $scope.currentPage = 1;
  $scope.pageSize = 10;

  $scope.dato = {};
  $scope.datos = [];
  $scope.registros = [];
  $scope.tempData = {};

  $scope.datosGrafica = [];
  $scope.temperatura = [];
  $scope.y = [];
  $scope.humedad = [];
  $scope.min = 20;
  $scope.max = 50;

  var interval;

  $http({
    url: "api/get-datos",
    method: "GET",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
  }).then(
    function successCallback(response) {
      console.log("index", response);
      $scope.datos = [...response.data.datos];
      $scope.graficar($scope.datos[0]);
    },
    function errorCallback(response) {
      console.log(response);
      if (response.status === 422) {
        let mensaje = "";
        for (let i in response.data.errors) {
          mensaje += response.data.errors[i] + "\n";
        }
        swal("Mensaje del Sistema", mensaje, "error");
      } else {
        swal(
          "Mensaje del Sistema",
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
    $(".update-bitacora").removeClass("btn-success").addClass("btn-danger");
  };

  // stops the interval
  $scope.stop = function () {
    $scope.detenido = $interval.cancel(interval);
    //console.log($scope.detenido);
    $(".update-bitacora").removeClass("btn-danger").addClass("btn-success");
  };

  // start interval
  $scope.start();

  function updateLectura() {
    console.log("update works!");
    $http({
      url: "api/get-datos",
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    }).then(
      function successCallback(response) {
        $scope.datos = [...response.data.datos];
        $scope.graficar($scope.datos[0]);

        $scope.mostrarGraficaLineas();
      },
      function errorCallback(response) {
        console.log(response);
        swal(
          "Mensaje del Sistema",
          response.data.message,
          tiposDeMensaje.error
        );
      }
    );
  }

  // Graficas

  let dataTemp = {};
  let dataHum = {};

  $('#sensoresModal').on('shown.bs.modal', function () {
    console.log('hola mundo!');
    $scope.mostrarGraficaLineas();
  })

  $scope.graficar = function (dato) {
    if (dato.temperatura) {
      chart = ".ct-chart1";
      dataTemp.labels = ["Temperatura"];
      dataTemp.series = [dato.temperatura];
      if (dataTemp.series.length > 0) $scope.mostrarGrafica(chart, dataTemp);
    }

    if (dato.humedad) {
      chart = ".ct-chart2";
      dataHum.labels = ["Humedad"];
      dataHum.series = [dato.humedad];
      if (dataTemp.series.length > 0) $scope.mostrarGrafica(chart, dataHum);
    }
  };

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
        var centigrades = data.labels[idx].includes("Temp") ? " ºC" : " %";
        return data.labels[idx] + " " + data.series[idx] + " " + centigrades;
      },
    });
  };

  $scope.mostrarGraficaLineas = function () {

    $scope.temperaturaDHT11 = [];
    $scope.temperaturaDHT22 = [];
    $scope.y = [];
    $scope.humedad = [];

    $scope.datos.map((registro) => {
      
      currentTime = new Date(registro.created_at);


      if (currentTime.getHours() != $scope.y.at(-1)) {

        if((registro.sensor.includes('DHT11'))){
          $scope.temperaturaDHT11.push(registro.temperatura);
          $scope.temperaturaDHT22.push(0.1);
        } else if (registro.sensor.includes('DHT22')) {
          $scope.temperaturaDHT22.push(registro.temperatura);
          $scope.temperaturaDHT11.push(0.1);
        }
        $scope.y.push(currentTime.getHours());

        // (registro.sensor.includes('DHT11')) ? $scope.temperaturaDHT11.push(registro.temperatura) : $scope.temperaturaDHT22.push('');
        // (registro.sensor.includes('DHT22')) ? $scope.temperaturaDHT22.push(registro.temperatura) : $scope.temperaturaDHT11.push('');
        // // $scope.humedad.push(registro.humedad);
        // $scope.y.push(currentTime.getHours());
      }

    });

    if ($scope.y.length > 0) {

      $scope.min = (Math.min(...$scope.temperaturaDHT11) + Math.min(...$scope.temperaturaDHT22)) /2;
      $scope.max = (Math.max(...$scope.temperaturaDHT11) + Math.max(...$scope.temperaturaDHT22)) /2;
      console.log('min temp', $scope.min);
      console.log('max temp', $scope.max);
      console.log('DHT11', $scope.temperaturaDHT11);
      console.log('DHT22', $scope.temperaturaDHT22);

      new Chartist.Line(
        ".ct-chart",
        {
          labels: $scope.y.reverse(),
          series: [$scope.temperaturaDHT11.reverse(), $scope.temperaturaDHT22.reverse()], //, $scope.humedad.reverse()],
        },
        {
          high: $scope.max,
          low: $scope.min,
          fullWidth: true,
          lineSmooth: Chartist.Interpolation.cardinal({
            fillHoles: true,
          }),
          // As this is axis specific we need to tell Chartist to use whole numbers only on the concerned axis
          axisY: {
            onlyInteger: false,
            offset: 20,
          },
        }
      );
    }

  };
  // Graficas
});

app.filter("activoInactivo", function () {
  return function (input) {
    return input ? "Activo" : "Inactivo";
  };
});
app.filter("siNo", function () {
  return function (input) {
    return input ? "Si" : "No";
  };
});
app.filter("temperatura", function () {
  return function (value) {
    return value + " °C";
  };
});
app.filter("humedad", function () {
  return function (value) {
    return value + " %";
  };
});
