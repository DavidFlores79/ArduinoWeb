
var app = angular.module('profiles', []);


app.controller('profiles', function ($scope, $http) {
    $scope.item = {};
    $scope.createForm = [];
    $scope.editForm = [];
    $scope.data = [];
    $scope.codes = [];
    $scope.modules = [];
    $scope.permissions = [];
    $scope.permissions_selected = [];
    
    $http({
        url: 'profiles/get-data',
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
            $scope.modules = response.data.modules;
            $scope.permissions = response.data.permissions;
            console.log($scope.data);
        },
        function errorCallback(response) {
            mostrarSwal(response);
        }
    );

    $scope.create = function () {

        $http({
            url: 'profiles/create',
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
            url: 'profiles',
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
            url: 'profiles/edit',
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
            url: `profiles`,
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
            url: `profiles/${$scope.item.id}`,
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

    $scope.showRole = (item) => {
        $scope.item = item;

        // asignar valores a los selectpicker de cada modulo
        $scope.permissions_selected = item.permissionIds;
        console.log('Permission Selected', $scope.permissions_selected);

        setTimeout(() => {
            $('.selectpicker').selectpicker('refresh');
        }, 50);

        $('#roleModal').modal('show');
    }

    $scope.saveRole = () => {

        $http({
            url: `roles`,
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            data: {
                profile_id: $scope.item.id,
                module_permissions: $scope.permissions_selected,
            }
        }).then(
            function successCallback(response) {
                console.log(response);
                $scope.data = $scope.data.map(profile => (profile.id == response.data.item.id) ? profile = response.data.item : profile);
                $('#roleModal').modal('hide');
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