var app = angular.module("logs", ["angularUtils.directives.dirPagination"]);

app.controller("logs", function ($interval, $scope, $http, $window) {
    activarLoading();
    $scope.currentPage = 1;
    $scope.pageSize = 10;
    $scope.logs = [];
    $scope.current_date = new Date();
    $scope.fechain = $scope.current_date;
    $scope.update = true;

    // FECHA HOY
    const thisDay = new Date(
        new Date().getTime() - new Date().getTimezoneOffset() * 60 * 1000
    )
        .toISOString()
        .split("T")[0];


    $http({
        url: "logs/get-data",
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
        },
    }).then(
        function successCallback(response) {
            //console.log("salio bien: ", response);
            $scope.logs = response.data.logs;
            desactivarLoading();
        },
        function errorCallback(response) {
            // console.log("hubo error: ", response);
            desactivarLoading();
            swal(log.titulo, response.data.message, tiposDeMensaje.error);
        }
    );

    // start interval
    //$scope.start();
    $scope.searchLogs = function () {

        if ($("#fecha_in").val() > thisDay) {
            return swal(
                logs.titulo,
                'La fecha de búsqueda no puede ser mayor a la de hoy',
                tiposDeMensaje.advertencia
            );
        }

        activarLoading();
        let yourDate = new Date();
        const off = yourDate.getTimezoneOffset();
        yourDate = new Date(yourDate.getTime() - off * 60 * 1000);

        var fecha_desde = $("#fecha_in").val();
        var fecha_hoy = yourDate.toISOString().split("T")[0];

        if (Date.parse(fecha_desde) == Date.parse(fecha_hoy)) {
            $scope.update_log(fecha_desde);
        } else {
            $scope.update_log(fecha_desde);
        }
    };


    $scope.update_log = (log_date) => {
        activarLoading();
        $http({
            url: "logs",
            method: "PUT",
            data: {
                log_date: log_date,
            },
            headers: {
                "Content-Type": "application/json",
            },
        }).then(
            function successCallback(response) {
                desactivarLoading();
                console.log(response);
                if (response.data.code == 200) {
                    $scope.logs = response.data.logs;
                } else {
                    swal(logs.titulo, response.data.message, response.data.status);
                }
            },
            function errorCallback(response) {
                // console.log(response);
                desactivarLoading();
                mostrarSwal(response);
            }
        );
    }

    $scope.logDetails = function (log) {
        console.log({ log });
        $scope.log = log;
        $("#log-modalLabel").html(log.descripcion);
        $("#log_trace").html(log.trace);
        if (log.documento != "S/D") {
            $("#log_documento").html(
                `Documento: <span class='font-weight-bold'>${log.documento}</span>`
            );
        } else {
            $("#log_documento").html("");
        }
        $("#log-modal").modal("show");
    };

    $scope.modulos = function (id) {
        $("#modulo-" + id).trigger("submit");
    };
});
