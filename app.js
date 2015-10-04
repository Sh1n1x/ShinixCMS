angular.module('ShinixCMS', ['ngRoute','flash','ngAnimate','angularLoad','angularFileUpload','validation.match','ngStorage'])
  .config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/about', {
        templateUrl: 'views/about.html',
        controller: 'AboutCtrl'
      }).
      otherwise({
        redirectTo: '/blog'
      });
  }])
  .filter('to_trusted', ['$sce', function($sce){
        return function(text) {
            return $sce.trustAsHtml(text);
        };
  }])
  .factory('$localstorage', ['$window', function($window) {
    return {
      set: function(key, value) {
        $window.localStorage[key] = value;
      },
      get: function(key, defaultValue) {
        return $window.localStorage[key] || defaultValue;
      },
      setObject: function(key, value) {
        $window.localStorage[key] = JSON.stringify(value);
      },
      getObject: function(key) {
        return JSON.parse($window.localStorage[key] || '{}');
      },
      remove: function(key) {
        $window.localStorage.removeItem(key);
      },
      clearAll: function(key) {
        $window.localStorage.clear();
      }
    }
  }]);
