app.controller('PersonsController', ['$scope', 'common', '$http', '$timeout', function ($scope, common, $http, $timeout) {
    $scope.loading = true;
    $scope.error = false;
    $http.get(Routing.generate('cget_persons'))
        .then(function (res) {
            $scope.persons = res.data;
            $scope.loading = false;
        });
}]);