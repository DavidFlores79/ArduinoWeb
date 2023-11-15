var app = angular.module('home', ['angularUtils.directives.dirPagination']);

app.controller('home', function ($interval, $scope, $http) {
  $scope.currentPage = 1;
  $scope.pageSize = 10;
  $scope.menu = [];
  activarLoading();

  setTimeout(() => {
    $scope.getMenu();
  }, 250);

  
  $scope.getMenu = () => {
    $http({
      url: 'menu',
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    }).then(
      function successCallback(response) {
        console.log('Catalogs', response);
        desactivarLoading();
        $scope.menu = response.data.menu;
      },
      function errorCallback(response) {
        console.log(response);
        desactivarLoading();
        mostrarSwal(response);
      }
    );
  }

});