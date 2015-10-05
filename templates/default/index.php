<!doctype html>
<html lang="en" data-framework="angularjs">
	<head>
		<meta charset="utf-8">
		<title><?=TITLE ?></title>
    <link rel="stylesheet" href="<?=url() ?>vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?=url() ?>lib/angular-flash/angular-flash.min.css" />
	<meta name="fragment" content="!">
    <style>body{font-family:"Helvetica Neue", Helvetica, Arial, sans-serif;;font-weight:300;}h1,h2{font-weight:300;}</style>
	</head>
	<body ng-app="ShinixCMS">
    <nav class="navbar navbar-inverse">
      <a class="navbar-brand" href="#!/"><?=TITLE ?></a>
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
    </nav>
    <div class="container">
        <div flash-message="5000" ></div>
		    <div ng-view="">Chargement</div>
    </div>
		<script src="<?=url() ?>vendor/components/angular.js/angular.min.js"></script>
		<script src="<?=url() ?>vendor/components/angular.js/angular-route.js"></script>
		<script src="<?=url() ?>vendor/moment/moment/min/moment.min.js"></script>
		<script src="<?=url() ?>vendor/components/angular.js/angular-animate.js"></script>
		<script src="<?=url() ?>vendor/moment/moment/locale/<?=LANGUAGE ?>.js"></script>
		<script src="<?=url() ?>/lib/angular-moment/angular-moment.min.js"></script>
		<script src="<?=url() ?>/lib/angular-flash/angular-flash.min.js"></script>
		<script src="<?=url() ?>/lib/ngStorage/ngStorage.min.js"></script>
		<script src="<?=url() ?>/lib/angular-load/angular-load.min.js"></script>
		<script src="<?=url() ?>/lib/ng-flow/ng-flow-standalone.min.js"></script>
		<script src="<?=url() ?>/lib/angular-validation-match/angular-validation-match.min.js"></script>
		<script src="<?=url() ?>/app.js"></script>
		<script src="<?=url() ?>/controllers/BlogCtrl.js"></script>
		<script src="<?=url() ?>/controllers/UsersCtrl.js"></script>
		<script src="<?=url() ?>/controllers/PagesCtrl.js"></script>
		<script>
			angular.module('ShinixCMS')
				.constant("CMSCONFIG", {
					"url": "<?=url() ?>",
					"language": "<?=LANGUAGE ?>"
				});	
		</script>
	</body>
</html>
