app.controller('AppController', ['$scope', '$mdBottomSheet', '$mdSidenav', '$mdDialog', 'trans', 'MenuService', function ($scope, $mdBottomSheet, $mdSidenav, $mdDialog, trans, MenuService) {
    $scope.get = trans.get;
    $scope.toggleSidenav = function (menuId) {
        $mdSidenav(menuId).toggle();
    };
    $scope.menu = MenuService.menu;
}]);

app.controller('LeftCtrl', function ($scope, $timeout, $mdSidenav, $log) {
    $scope.close = function () {
        $mdSidenav('left').close()
            .then(function () {
                $log.debug("close LEFT is done");
            });
    };
});

app.controller('MenuCtrl', function($scope, $mdDialog) {
    $scope.navigateTo = function(to, event) {
        $mdDialog.show(
            $mdDialog.alert()
                .title('Navigating')
                .content('Imagine being taken to ' + to)
                .ariaLabel('Navigation demo')
                .ok('Neat!')
                .targetEvent(event)
        );
    };
});