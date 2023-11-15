
var app = angular.module('modules', ["angularUtils.directives.dirPagination"]);


app.controller('modules', function ($scope, $http, $httpParamSerializerJQLike) {
    activarLoading();
    $scope.item = {};
    $scope.createForm = {
        status: true,
    };
    $scope.editForm = [];
    $scope.data = [];
    $scope.categories = [];

    $http({
        url: 'modules/get-data',
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(
        function successCallback(response) {
            console.log(response);
            desactivarLoading();
            $scope.data = response.data.data;
            $scope.categories = response.data.categories;
            console.log($scope.data);
        },
        function errorCallback(response) {
            console.log(response);
            desactivarLoading();
            mostrarSwal(response);
        }
    );

    $scope.create = function () {
        
        $http({
            url: 'modules/create',
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
        const formStore = $("#createForm").serializeJSON();
        if(formStore.avatar) $scope.createForm.image = formStore.avatar;
        console.log('Create: ', $scope.createForm);

        $http({
            url: 'modules',
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
        $scope.editForm.category_id = `${$scope.editForm.category_id}`;
        $scope.editForm.status = ($scope.editForm.status) ? true:false;
        pondEdit.removeFiles();

        $http({
            url: 'modules/edit',
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
        const formStore = $("#editForm").serializeJSON();
        if(formStore.avatar) $scope.editForm.image = formStore.avatar;
        
        console.log('Editado', $scope.editForm);

        $http({
            url: `modules`,
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
        $('#eliminarModal').modal('show');
    }

    $scope.delete = function () {
        console.log('item: ', $scope.item);

        $http({
            url: `modules/${$scope.item.id}`,
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

    $scope.togglStatusCreate = () => {
        $scope.createForm.status = !$scope.createForm.status;
    }

    $scope.togglStatusEdit = () => {
        $scope.editForm.status = !$scope.editForm.status;
    }

    $scope.deleteImage = () => {
        $scope.editForm.image = '';
        
    }

    $('#editarUsuarioModal').on('hidden.bs.modal', function () {
        console.log('haz algo');
    });



});