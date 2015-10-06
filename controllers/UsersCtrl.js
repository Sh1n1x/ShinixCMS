angular.module('ShinixCMS')
.config(['$routeProvider',
function($routeProvider) {
	$routeProvider.
  		when('/users/register', {
  			templateUrl: 'views/users/register.html',
  			controller: 'UsersRegisterCtrl'
  		}).
  		when('/users/login', {
  			templateUrl: 'views/users/login.html',
  			controller: 'UsersLoginCtrl'
  		}).
  		when('/users/logout', {
  			templateUrl: 'views/empty.html',
  			controller: 'UsersLogoutCtrl'
  		}).
  		when('/users/index', {
  			templateUrl: 'views/users/index.html',
  			controller: 'UsersCtrl',
			resolve:{
				"check":function($location,Flash,$sessionStorage,api){
					if($sessionStorage.users){
						api.post('api/users/check_session/2',$sessionStorage.users).then(function() {
						}, function errorCallback() {
							$location.path('/users/logout');
							Flash.create('error', "accès refusé",'alert-danger');
						});
					} else{
						$location.path('/blog');
						Flash.create('error', "accès refusé",'alert-danger');
					}
				}
			}
  		});
}])
.controller('UsersCtrl', function UsersCtrl($scope,$http,$sessionStorage,$window,Flash) {
    //ok
    console.log('hi ho');
})
.controller('UsersRegisterCtrl', function UsersRegisterCtrl($scope,api,Flash,$window) {
	$scope.SubmitForm = function(isValid){
	$scope.submitted = true;
		if (isValid) {
			api.post('api/users/register',$scope.user).then(function(r) {
				var message = '<strong>Succès !</strong>';
				Flash.create('success', message);
				$window.location.href = '#!/users/login';
			}, function errorCallback(r) {
				var message = '<strong>Erreur !</strong> Il y a des erreurs';
				Flash.create('error', message,'alert-danger');
			});
		}
	};
})
.controller('UsersLogoutCtrl', function UsersLogoutCtrl($scope,$http,Flash,$sessionStorage,$window) {
  var message = '<strong>Succès !</strong> déconenxion réussie !';
  Flash.create('success', message);
  delete $sessionStorage.users;
  $window.location.href = '#!/blog';
})
.controller('UsersLoginCtrl', function UsersLoginCtrl($scope,api,Flash,$sessionStorage,$window) {
  if($sessionStorage.users){
      var message = '<strong>Info !</strong> Vous êtes déjà connecté';
      Flash.create('info', message);
    $window.location.href = '#!/users/index';
  }
  $scope.SubmitForm = function(isValid){
    $scope.submitted = true;
    if (isValid) {
		api.post('api/users/login',$scope.user).then(function(r) {
			var message = '<strong>Succès !</strong>';
			Flash.create('success', message);
			$sessionStorage.users = r.data;
			$window.location.href = '#!/users/index';
  		}, function errorCallback(r) {
			var message = '<strong>Erreur !</strong> Le nom d\'utilisateur ou le mot de passe est incorrect.';
			Flash.create('error', message,'alert-danger');
      });
    }
  };
});
