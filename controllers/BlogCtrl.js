
angular.module('ShinixCMS')

/**
*	BLOG ROUTING
**/
.config(['$routeProvider',
function($routeProvider) {
	$routeProvider.
		when('/blog', {
			templateUrl: 'views/blog/blog.html',
			controller: 'BlogCtrl'
		}).
		when('/blog/:page', {
			templateUrl: 'views/blog/blog.html',
			controller: 'BlogCtrl'
		}).
		when('/blog/:slug/:id', {
			templateUrl: 'views/blog/blog_one.html',
			controller: 'BlogOneCtrl'
		}).
		when('/admin/blog', {
			templateUrl: 'views/blog/admin_list.html',
			controller: 'AdminBlogCtrl',
			resolve:{
				"check":function($location,Flash,$sessionStorage,api){
					if($sessionStorage.users){
						api.post('api/users/check_session/2',$sessionStorage.users).then(function() {
						}, function errorCallback() {
							$location.path('/blog');
							Flash.create('error', "Accès refusé",'alert-danger');
						});
					} else{
						$location.path('/blog');
						Flash.create('error', "Accès refusé",'alert-danger');
					}
				}
			}
		}).
		when('/admin/blog/new', {
			templateUrl: 'views/empty.html',
			controller: 'AdminBlogNewCtrl',
			resolve:{
				"check":function($location,Flash,$sessionStorage,api){
					if($sessionStorage.users){
						api.post('api/users/check_session/2',$sessionStorage.users).then(function() {
						}, function errorCallback() {
							$location.path('/blog');
							Flash.create('error', "Accès refusé",'alert-danger');
						});
					} else{
						$location.path('/blog');
						Flash.create('error', "Accès refusé",'alert-danger');
					}
				}
			}
		}).
		when('/admin/blog/edit/:id', {
			templateUrl: 'views/blog/admin_edit.html',
			controller: 'AdminBlogEditCtrl',
			resolve:{
				"check":function($location,Flash,$sessionStorage,api){
					if($sessionStorage.users){
						api.post('api/users/check_session/2',$sessionStorage.users).then(function() {
						}, function errorCallback() {
							$location.path('/blog');
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

/**
*	BLOG CONTROLLERS
**/

.controller('BlogCtrl', function BlogCtrl($scope,api,$routeParams) {
	if($routeParams.page){
		$scope.cpage = $routeParams.page;
	} else {
		$scope.cpage = 1;
	}
	var img_size = "800x200";
	$scope.pagination = [];
	api.getAll('api/blog/'+img_size+'/'+$scope.cpage).then(function(r) {
		$scope.blog_item = r.data.data;
		$scope.total_item = r.data.total_item;
		$scope.total_page = r.data.total_page;
		for (var i=1; i<$scope.total_page+1; i++) {
		  $scope.pagination[i] = i;
		}
	}, function(r) { });
})
.controller('BlogOneCtrl', function BlogOneCtrl($scope,api,$routeParams) {
		api.getAll('api/blog/article/'+$routeParams.slug+'/'+$routeParams.id).then(function(response) {
				$scope.itm = response.data;
		}, function errorCallback(response) {});
})
.controller('AdminBlogCtrl', function AdminBlogCtrl($scope,api) {
		api.getAll('api/blog/admin').then(function(response) {
				$scope.item = response.data;
		}, function errorCallback(response) {});
})
.controller('AdminBlogNewCtrl', function AdminBlogNewCtrl($scope,api,$window) {
	api.getAll('api/blog/admin/new').then(function(r) {
			$window.location.href = '#!/admin/blog/edit/'+r.data.id;
	});
})
.controller('AdminBlogEditCtrl', function AdminBlogEditCtrl($scope,$http,api,$routeParams,$window,Flash,angularLoad,FileUploader,CMSCONFIG) {
	//UPLOAD Image
	$scope.uploader = new FileUploader();
	$scope.uploader.url = 'api/blog/upload/'+$routeParams.id;
	$scope.uploader.onAfterAddingFile = function() {
		$scope.uploader.uploadAll();
	};
	$scope.uploader.onSuccessItem = function(item, response) {
		//ON RECHARGE LES IMGS
		api.getAll('api/blog/img/'+$routeParams.id).then(function(response) {
			$scope.image = response.data;
		});
	};
	//load script
	angularLoad.loadScript(CMSCONFIG.url+'lib/simplemde-markdown-editor/simplemde.min.js').then(function() {
		// Script loaded succesfully.
		// We can now start using the functions from someplugin.js
		var simplemde = new SimpleMDE({
			element: document.getElementById("inputcontent"),
			autofocus: true,
			lineWrapping: true,
			autosave: {
				enabled: true,
				unique_id: 'blog_'+$routeParams.id,
				delay: 1000,
			},
			initialValue: $routeParams.content,
			parsingConfig: {
				allowAtxHeaderWithoutSpace: true,
				strikethrough: false,
				underscoresBreakWords: true,
			},
			renderingConfig: {
				singleLineBreaks: false,
				codeSyntaxHighlighting: true,
			},
			tabSize: 4,
			spellChecker:false, //il est que en anglais...
			toolbar: [
				"bold",
				"italic",
				"strikethrough",
				"|",
				"heading-1",
				"heading-2",
				"heading-3",
				"|",
				"code",
				"quote",
				"|",
				"unordered-list",
				"ordered-list",
				"|",
				"link",
				"image",
				"horizontal-rule",
				"|",
				"preview",
				"side-by-side",
				"fullscreen",
				"|",
				"guide"
			]
		});
		angularLoad.loadCSS(CMSCONFIG.url+'lib/simplemde-markdown-editor/simplemde.min.css').then(function() {});
		angularLoad.loadScript(CMSCONFIG.url+'lib/highlight.js/highlight.min.js').then(function() {
			angularLoad.loadCSS(CMSCONFIG.url+'lib/highlight.js/github.min.css').then(function() {});
		});

		//Save data (uniquement si l'éditeur markdown a chargé)
		$scope.SubmitForm = function(){
			$scope.blog.content= simplemde.value(); //on fout le contenu du Markdown editor
			api.post('api/blog/admin/edit/'+$routeParams.id,$scope.blog).then(function(response) {
				var message = '<strong>Succès !</strong> Article mis à jour avec succès';
				Flash.create('success', message);
				$window.location.href = '#!/admin/blog';
			}, function errorCallback(response) {});
		};
	});

		$scope.blog = [];
		api.getAll('api/blog/admin/edit/'+$routeParams.id).then(function(response) {
			$scope.blog = response.data;
		}, function errorCallback(response) {
			$window.location.href = '#!/admin/blog';
			var message = '<strong>Erreur !</strong> Article introuvable';
			Flash.create('error', message,'alert-danger');
		});
		api.getAll('api/blog/img/'+$routeParams.id).then(function(response) {
			$scope.image = response.data;
		});
});
