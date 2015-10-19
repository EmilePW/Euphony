'use strict';

angular.module('nouvel', ['ngRoute']);

angular.module('nouvel').config(['$routeProvider', function($routeProvider) {
	$routeProvider

	.when('/', {
		templateUrl: 'views/landing.html',
		controller: 'landingCtrl'
	})

	// Writing page
	.when('/write', {
		templateUrl: 'views/write.html',
		controller: 'writeCtrl'
	})

	.otherwise({
		redirectTo: '/'
	});
}]);