var myApp = angular.module('resourceApp', []);
myApp.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{').endSymbol('}')
});

myApp.factory('common', function () {
    return {
        axb: function (a, b) {
            if (a == null || a == 0) {
                return "<span class='unitPrice'>(cena " + b + " PLN)</i>";
            }
            return a + " × " + b + " PLN = " + a * b + " PLN";
        },
        apbxc: function (a, b, c) {
            a = a || 0;
            b = b || 0;
            if (a + b == 0) {
                return "<span class='unitPrice'>(cena " + c + " PLN)</i>";
            }
            return "(" + a + " + " + b + ") × " + c + " PLN = " + (a + b) * c + " PLN";
        },
        map: myApp.map
    }
})
;

myApp.controller('ResourceController', ['$scope', 'common', '$http', '$timeout', function ($scope, common, $http, $timeout) {
    $scope.status = "creation";
    $scope.error = false;
    $scope.submit = function () {
        var data = $scope.entity;
        if (myApp.resource) {
            data.id = myApp.resource.id;
        }
        $scope.status = "pending";
        $scope.error = false;
        $http.post(myApp.formSubmitUrl, data).
            then(function (response) {
                $scope.status = "creation";
                window.location.href = myApp.backUrl;
            }, function (response) {
                $scope.status = "creation";
                $scope.error = true;
            });
    };
    if (myApp.resource) {
        $scope.entity = myApp.resource;
    }
    $scope.common = common;
}]);