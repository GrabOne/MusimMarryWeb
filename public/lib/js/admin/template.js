var GraboneAdmin = angular.module('GraboneAdmin', ['angular-spinkit','ui.tinymce'], function($interpolateProvider){
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
})
GraboneAdmin.controller('GraboneAdminNavbarCtrl',function($scope){
	$scope.LOGIN = LOGIN;
})


