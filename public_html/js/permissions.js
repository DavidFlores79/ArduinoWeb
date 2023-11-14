
var app = angular.module('permissions', []);


app.controller('permissions', function ($scope, $http) {
    $scope.item = {};
    $scope.createForm = [];
    $scope.editForm = [];
    $scope.data = [];
    $scope.codes = [];
    $scope.createForm = {};
    
    $http({
        url: 'permissions/get-data',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            $scope.data = response.data.data;
            $scope.codes = response.data.codes;
            console.log($scope.data);
        },
        function errorCallback(response) {
            mostrarSwal(response);
        }
    );

    $scope.create = function () {

        $http({
            url: 'permissions/create',
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $('#createForm').trigger('reset');
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
            url: 'permissions',
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

    $scope.edit = function (profile) {
        console.log('cat: ', profile);
        $scope.editForm = profile;
        
        $http({
            url: 'permissions/edit',
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
            url: `permissions`,
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
                $scope.data = $scope.data.map(profile => (profile.id == response.data.item.id) ? profile = response.data.item : profile);
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

    $scope.confirmarEliminar = function (profile) {
        $scope.item = profile;
        $('#nombre-profile').html(profile.nombre);
        $('#eliminarModal').modal('show');
    }

    $scope.delete = function () {
        console.log('profile: ', $scope.item);

        $http({
            url: `permissions/${$scope.item.id}`,
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.data = $scope.data.filter(profile => profile.id !== $scope.item.id);
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

    $('#editarUsuarioModal').on('hidden.bs.modal', function () {
        console.log('haz algo');
    });
    


});