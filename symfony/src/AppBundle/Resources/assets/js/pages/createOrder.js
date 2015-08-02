var myApp = angular.module('orderApp', []);
myApp.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol('{').endSymbol('}')
});

myApp.controller('OrderController', ['$scope', function ($scope, $sce) {
    $scope.depth = 3;
    $scope.map = myApp.map;
    $scope.transport = 'own';
    $scope.price = function () {
        var width = $scope.width;
        var height = $scope.height;
        var depth = $scope.depth;
        var priceCm = $scope.priceCm;

        if (width > 0 && height > 0 && depth > 0 && priceCm > 0) {
            return width * height * depth * priceCm;
        }
    }

    $scope.totalPrice = function () {
        var total = 0;
        for (var name in $scope.input) {
            total += $scope.map[name].unitPrice * $scope.input[name];
        }
        return total;
    }

    $scope.axb = function (a, b) {
        if (a == null || a == 0) {
            return "<span class='unitPrice'>(cena " + b + " PLN)</i>";
        }
        return a + " × " + b + " PLN = " + a * b + " PLN";
    }
}]);