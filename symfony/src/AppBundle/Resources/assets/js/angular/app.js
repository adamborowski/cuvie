var app = angular.module('WhiteVeil', ['ngMaterial', 'ngMdIcons']);
app.config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol(':{').endSymbol('}:')
});