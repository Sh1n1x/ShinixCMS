<!doctype html>
<html lang="en" data-framework="angularjs">
	<head>
		<meta charset="utf-8">
		<title><?=TITLE ?></title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?=url() ?>lib/angular-flash/angular-flash.min.css" />
    <link rel="stylesheet" href="<?=url() ?>templates/default/css/style.css" />
	<meta name="fragment" content="!">
	</head>
	<body ng-app="ShinixCMS">	
	<div id="header">
		<h1><?=TITLE ?></h1>
	</div>
	<nav class="navbar navbar-inverse topbar">
		<div class="container">
		  <ul class="nav nav-pills">
			<li class="nav-item active">
			  <a class="nav-link" href="#!/blog">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#!/about">About</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#!/users/register">Inscription</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#!/users/login">Connexion</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" href="#!/admin/blog">Admin blog</a>
			</li>
		  </ul>
		</div>
	</nav>
	<div class="container"><div flash-message="5000" ></div></div>
	<div ng-view="">Chargement</div>
	<div class="container">
		<hr />
		<?=TITLE ?> copyright 2015
    </div>
		<script src="<?=url() ?>vendor/components/angular.js/angular.min.js"></script>
		<script src="<?=url() ?>vendor/components/angular.js/angular-route.js"></script>
		<script src="<?=url() ?>vendor/moment/moment/min/moment.min.js"></script>
		<script src="<?=url() ?>vendor/components/angular.js/angular-animate.js"></script>
		<script src="<?=url() ?>vendor/moment/moment/locale/<?=LANGUAGE ?>.js"></script>
		<script src="<?=url() ?>/lib/uibootstrap/ui-bootstrap-0.14.1.min.js"></script>
		<script src="<?=url() ?>/lib/uibootstrap/ui-bootstrap-tpls-0.14.1.min.js"></script>
		<script src="<?=url() ?>/lib/angular-moment/angular-moment.min.js"></script>
		<script src="<?=url() ?>/lib/angular-flash/angular-flash.min.js"></script>
		<script src="<?=url() ?>/lib/ngStorage/ngStorage.min.js"></script>
		<script src="<?=url() ?>/lib/angular-load/angular-load.min.js"></script>
		<script src="<?=url() ?>/lib/ng-flow/ng-flow-standalone.min.js"></script>
		<script src="<?=url() ?>/lib/angular-validation-match/angular-validation-match.min.js"></script>
		<script src="<?=url() ?>/app.js"></script>
		<script src="<?=url() ?>/controllers/BlogCtrl.js"></script>
		<script src="<?=url() ?>/controllers/UsersCtrl.js"></script>
		
		<script>
			angular.module('ShinixCMS')
				.constant("CMSCONFIG", {
					"url": "<?=url() ?>",
					"language": "<?=LANGUAGE ?>"
				});	
		</script>
	</body>
</html>
