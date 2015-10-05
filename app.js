angular.module('ShinixCMS', ['ngRoute','flash','ngAnimate','angularLoad','angularFileUpload','validation.match','ngStorage','angularMoment'])
  .config(['$routeProvider','$locationProvider',
  function($routeProvider,$locationProvider) {
	$locationProvider.html5Mode(false);
    $locationProvider.hashPrefix("!");
    $routeProvider.
		when('/', {
			templateUrl: 'views/blog/blog.html',
			controller: 'BlogCtrl'
		}).
		when('/404', {
			templateUrl: 'views/404.html',
			controller: 'Four04Ctrl'
		}).
		otherwise({
			redirectTo: '/404'
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
  }])
.value('PARSE_CREDENTIALS',{
    APP_ID: 'xhTpJiNedJ7mmDj3LTTBUePqSVegcJHzEbh70Y0Q',
    REST_API_KEY:'XCfQDPODgNB1HqmaCQgKLPWGxQ0lCUxqffzzURJY'
})
.factory('api',['$http','PARSE_CREDENTIALS','CMSCONFIG',function($http,PARSE_CREDENTIALS,CMSCONFIG){
    return {     
    	getAll:function(link){
            return $http.get(CMSCONFIG.url+link,{
                headers:{
                    'X-Parse-Application-Id': PARSE_CREDENTIALS.APP_ID,
                    'X-Parse-REST-API-Key':PARSE_CREDENTIALS.REST_API_KEY,
                }
            });
        },
        get:function(id){
            return $http.get(CMSCONFIG.url+id,{
                headers:{
                    'X-Parse-Application-Id': PARSE_CREDENTIALS.APP_ID,
                    'X-Parse-REST-API-Key':PARSE_CREDENTIALS.REST_API_KEY,
                }
            });
        },
        post:function(link,data){
            return $http.post(CMSCONFIG.url+link,data,{
                headers:{
                    'X-Parse-Application-Id': PARSE_CREDENTIALS.APP_ID,
                    'X-Parse-REST-API-Key':PARSE_CREDENTIALS.REST_API_KEY,
                    'Content-Type':'application/json'
                }
            });
        },
        edit:function(id,data){
            return $http.put(CMSCONFIG.url+id,data,{
                headers:{
                    'X-Parse-Application-Id': PARSE_CREDENTIALS.APP_ID,
                    'X-Parse-REST-API-Key':PARSE_CREDENTIALS.REST_API_KEY,
                    'Content-Type':'application/json'
                }
            });
        },
        delete:function(id){
            return $http.delete(CMSCONFIG.url+id,{
                headers:{
                    'X-Parse-Application-Id': PARSE_CREDENTIALS.APP_ID,
                    'X-Parse-REST-API-Key':PARSE_CREDENTIALS.REST_API_KEY,
                    'Content-Type':'application/json'
                }
            });
        }
    }
}])
.run(function(amMoment,CMSCONFIG) {
    amMoment.changeLocale(CMSCONFIG.language);
})
.controller('Four04Ctrl', function() {
});