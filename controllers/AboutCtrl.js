
angular.module('ShinixCMS')
	.controller('AboutCtrl', function AboutCtrl($scope,$http) {
		$http({
			method: 'GET',
			url: '/api/index.php/blog'
		}).then(function successCallback(response) {
				$scope.blog_item = response.data;
		}, function errorCallback(response) {});
	});
