var myApp = angular.module('orderApp', []);
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

myApp.controller('OrderController', ['$scope', 'common', function ($scope, common) {
    $scope.depth = 3;
    $scope.map = common.map;
    $scope.transport = 'own';
    $scope.price = function () {
        var width = $scope.width;
        var height = $scope.height;
        var depth = $scope.depth;
        var priceCm = $scope.priceCm;

        if (width > 0 && height > 0 && depth > 0 && priceCm > 0) {
            return width * height * depth * priceCm;
        }
    };

    $scope.childrenScope = {};

    $scope.totalPrice = function () {
        var total = 0;
        var childrenScope = $scope.childrenScope;
        for (var name in childrenScope) {
            var childScope = childrenScope[name];
            if (childScope.value != null) {
                total += childScope.config.unitPrice * childScope.value;
            }
        }
        if ($scope.transport == 'provided') {
            total += (childrenScope.liczbaDoroslych.value + childrenScope.liczbaDzieci.value) * $scope.map.organizacja.unitPrice;
        }
        return total;
    };

    $scope.common = common;
}]);

myApp.controller('ConstraintController', ['$scope', 'common', function (that, common) {
    that.init = function (name) {
        that.value = null;
        that.price = common.map[name].unitPrice;
        that.childrenScope[name] = that;
        that.remaining = function () {
            return common.map[name].remaining - that.value;
        };
        that.config = common.map[name];
    }
}]);