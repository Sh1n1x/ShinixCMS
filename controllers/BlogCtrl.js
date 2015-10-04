
angular.module('ShinixCMS')
.config(['$routeProvider',
function($routeProvider) {
	$routeProvider.
		when('/blog', {
			templateUrl: 'views/blog/blog.html',
			controller: 'BlogCtrl'
		}).
		when('/blog/:slug/:id', {
			templateUrl: 'views/blog/blog_one.html',
			controller: 'BlogOneCtrl'
		}).
		when('/admin/blog', {
			templateUrl: 'views/blog/admin_list.html',
			controller: 'AdminBlogCtrl'
		}).
		when('/admin/blog/new', {
			templateUrl: 'views/empty.html',
			controller: 'AdminBlogNewCtrl'
		}).
		when('/admin/blog/edit/:id', {
			templateUrl: 'views/blog/admin_edit.html',
			controller: 'AdminBlogEditCtrl'
		});
}])
.controller('BlogCtrl', function BlogCtrl($scope,$http) {
	$http({
		method: 'GET',
		url: '/api/blog'
	}).then(function successCallback(response) {
			$scope.blog_item = response.data;
	}, function errorCallback(response) {});
})
.controller('BlogOneCtrl', function BlogOneCtrl($scope,$http,$routeParams) {
		$http({
			method: 'GET',
			url: '/api/blog/article/'+$routeParams.slug+'/'+$routeParams.id
		}).then(function successCallback(response) {
				$scope.itm = response.data;
		}, function errorCallback(response) {});
})
.controller('AdminBlogCtrl', function AdminBlogCtrl($scope,$http) {
		$http({
			method: 'GET',
			url: '/api/blog/admin'
		}).then(function successCallback(response) {
				$scope.item = response.data;
		}, function errorCallback(response) {});
})
.controller('AdminBlogNewCtrl', function AdminBlogNewCtrl($scope,$http,$window) {
	$http({
		method: 'POST',
		url: '/api//blog/admin/new'
	}).then(function successCallback(r) {
			$window.location.href = '#/admin/blog/edit/'+r.data.id;
	});
})
.controller('AdminBlogEditCtrl', function AdminBlogEditCtrl($scope,$http,$routeParams,$window,Flash,angularLoad,FileUploader) {
	//UPLOAD Image
  $scope.uploader = new FileUploader();
	$scope.uploader.url = '/api/blog/upload/'+$routeParams.id;
	$scope.uploader.onAfterAddingFile = function() {
		$scope.uploader.uploadAll();
	};
	$scope.uploader.onSuccessItem = function(item, response) {
		//ON RECHARGE LES IMGS
		$http({
			method: 'GET',
			url: '/api/blog/img/'+$routeParams.id
		}).then(function successCallback(response) {
				$scope.image = response.data;
		});
	};
	//load script
	angularLoad.loadScript('../../lib/simplemde-markdown-editor/simplemde.min.js').then(function() {
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
			angularLoad.loadCSS('../../lib/simplemde-markdown-editor/simplemde.min.css').then(function() {});
			angularLoad.loadScript('../../lib/highlight.js/highlight.min.js').then(function() {
				angularLoad.loadCSS('../../lib/highlight.js/github.min.css').then(function() {});
			});

			//Save data (uniquement si l'éditeur markdown a chargé)
			$scope.SubmitForm = function(){
				$scope.blog.content= simplemde.value(); //on fout le contenu du Markdown editor
				$http({
					method: 'POST',
					url: '/api/blog/admin/edit/'+$routeParams.id,
					data:$scope.blog
				}).then(function successCallback(response) {
		        var message = '<strong>Succès !</strong> Article mis à jour avec succès';
		        Flash.create('success', message);
						$window.location.href = '#/admin/blog';
				}, function errorCallback(response) {});
			};
	});

		$scope.blog = [];
		$http({
			method: 'GET',
			url: '/api/blog/admin/edit/'+$routeParams.id
		}).then(function successCallback(response) {
				$scope.blog = response.data;
		}, function errorCallback(response) {
					$window.location.href = '#/admin/blog';
					var message = '<strong>Erreur !</strong> Article introuvable';
					Flash.create('error', message,'alert-danger');
		});
		$http({
			method: 'GET',
			url: '/api/blog/img/'+$routeParams.id
		}).then(function successCallback(response) {
				$scope.image = response.data;
		});
});
