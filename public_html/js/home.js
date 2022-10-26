var app = angular.module("home", ["angularUtils.directives.dirPagination"]);

app.controller("home", function ($interval, $scope, $http) {
  $scope.currentPage = 1;
  $scope.pageSize = 10;

  $scope.sensor = '';
  $scope.datos = [];
  $scope.y = [];
  for (var i = 0; i <= 23; i++) $scope.y.push(i);
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
      $scope.graficar( $scope.datos.find(e => true) ); //graficar primer dato 
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
        $scope.graficar( $scope.datos.find(e => true) );
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

  $scope.dataTemp = {};
  $scope.dataHum = {};

  $('#sensoresModal').on('shown.bs.modal', function () {
    $scope.mostrarGraficaLineas();
  })

  $scope.graficar = function (dato) {
    $scope.sensor = dato.sensor;
    if (dato.temperatura) {
      chart = ".ct-chart1";
      $scope.dataTemp.labels = ["Temperatura"];
      $scope.dataTemp.series = [dato.temperatura];
      if ($scope.dataTemp.series.length > 0) $scope.mostrarGrafica(chart, $scope.dataTemp);
    }

    if (dato.humedad) {
      chart = ".ct-chart2";
      $scope.dataHum.labels = ["Humedad"];
      $scope.dataHum.series = [dato.humedad];
      if ($scope.dataHum.series.length > 0) $scope.mostrarGrafica(chart, $scope.dataHum);
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
    $scope.temperaturas = [];

    $scope.datos.map((registro) => {

      $scope.temperaturas.push(registro.temperatura);

      currentTime = new Date(registro.created_at);
      if (currentTime.getHours() != $scope.y.at(-1)) {
        if(registro.sensor.includes('DHT11')) $scope.temperaturaDHT11[currentTime.getHours()] = registro.temperatura;
        if(registro.sensor.includes('DHT22')) $scope.temperaturaDHT22[currentTime.getHours()] = registro.temperatura;
      }

    });

    if ($scope.temperaturaDHT11.length > 0 || $scope.temperaturaDHT11.length > 0) {

      if(Math.min(...$scope.temperaturas)) $scope.min = Math.min(...$scope.temperaturas);
      if(Math.max(...$scope.temperaturas)) $scope.max = Math.max(...$scope.temperaturas);
      // console.log('min temp', $scope.min);
      // console.log('max temp', $scope.max);
      // console.log('dht11', $scope.temperaturaDHT11);
      // console.log('dht22', $scope.temperaturaDHT22);
      // console.log('eje y', $scope.y);

      new Chartist.Line(
        ".ct-chart",
        {
          labels: $scope.y,
          series: [$scope.temperaturaDHT11, $scope.temperaturaDHT22], //, $scope.humedad.reverse()],
        },
        {
          high: $scope.max,
          low: $scope.min,
          fullWidth: true,
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
