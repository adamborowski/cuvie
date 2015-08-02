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

myApp.controller('OrderController', ['$scope', 'common', '$http', '$timeout', function ($scope, common, $http, $timeout) {
    $scope.status = "creation";
    $scope.map = common.map;
    $scope.transport = 'own';
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
    $scope.submit = function () {
        var data = {
            firstName: $scope.firstName,
            lastNameName: $scope.lastName,
            email: $scope.email,
            details: {},
            transport: $scope.transport
        };
        for (var name in $scope.childrenScope) {
            if ($scope.childrenScope[name].value != null) {
                data.details[name] = $scope.childrenScope[name].value
            }

        }
        $scope.status = "pending";
        $http.post(myApp.formSubmitUrl, data).
            then(function (response) {
                // this callback will be called asynchronously
                // when the response is available
                $timeout(function () {
                    $scope.status = "finish";
                }, 1000);
            }, function (response) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                //alert('error')
                $scope.status = "creation";
            });
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