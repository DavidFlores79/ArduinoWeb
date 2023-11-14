
var app = angular.module('categories', []);


app.controller('categories', function ($scope, $http) {
    $scope.item = {};
    $scope.createForm = {
        enabled: true,
    };
    $scope.editForm = [];
    $scope.data = [];
    $scope.codes = [];

    $http({
        url: 'categories/get-data',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            $scope.data = response.data.data;
            console.log($scope.data);
        },
        function errorCallback(response) {
            mostrarSwal(response);
        }
    );

    $scope.create = function () {
        console.log($scope.createForm);
        $http({
            url: 'categories/create',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#agregarModal').modal('show');
            },
            function errorCallback(response) {
                console.log(response);
                mostrarSwal(response);
            }
        );
    }

    $scope.store = function () {

        $http({
            url: 'categories',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: $scope.createForm
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.data = [...$scope.data, response.data.item];
                $('#createForm').trigger('reset');
                $('#agregarModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                mostrarSwal(response);
            }
        );
    }

    $scope.edit = function (item) {
        console.log('cat: ', item);
        $scope.editForm = item;
        $scope.editForm.enabled = ($scope.editForm.enabled) ? true:false;

        $http({
            url: 'categories/edit',
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#editarModal').modal('show');
            },
            function errorCallback(response) {
                console.log(response);
                mostrarSwal(response);
            }
        );
    }

    $scope.update = function () {
        console.log('Editado', $scope.editForm);

        $http({
            url: `categories`,
            method: 'PUT',
            data: $scope.editForm,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log('response: ', response);
                $scope.item = response.data.item;
                $scope.data = $scope.data.map(item => (item.id == response.data.item.id) ? item = response.data.item : item);
                $('#editarModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                mostrarSwal(response);
            }
        );
    }

    $scope.confirmarEliminar = function (item) {
        $scope.item = item;
        $('#nombre-item').html(item.nombre);
        $('#eliminarModal').modal('show');
    }

    $scope.delete = function () {
        console.log('item: ', $scope.item);

        $http({
            url: `categories/${$scope.item.id}`,
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.data = $scope.data.filter(item => item.id !== $scope.item.id);
                $('#eliminarModal').modal('hide');
                swal(
                    'Mensaje del Sistema',
                    response.data.message,
                    response.data.status
                );
            },
            function errorCallback(response) {
                console.log(response);
                mostrarSwal(response);
            }
        );

    }

    $scope.toggleEnabledCreate = () => {
        $scope.createForm.enabled = !$scope.createForm.enabled;
    }

    $scope.toggleEnabledEdit = () => {
        $scope.editForm.enabled = !$scope.editForm.enabled;
    }

    $('#editarUsuarioModal').on('hidden.bs.modal', function () {
        console.log('haz algo');
    });



});