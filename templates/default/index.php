<!doctype html>
<html lang="en" data-framework="angularjs">
	<head>
		<meta charset="utf-8">
		<title><?=TITLE ?></title>
    <link rel="stylesheet" href="../../vendor/twbs/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../lib/angular-flash/angular-flash.min.css" />
    <style>body{font-family:"Helvetica Neue";font-weight:300;}h1,h2{font-weight:300;}</style>
	</head>
	<body ng-app="ShinixCMS">
    <nav class="navbar navbar-inverse">
      <a class="navbar-brand" href="#"><?=TITLE ?></a>
      <ul class="nav nav-pills">
        <li class="nav-item active">
          <a class="nav-link" href="#/home">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#/about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#/users/register">Inscription</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#/users/login">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#/admin/blog">Admin blog</a>
        </li>
      </ul>
    </nav>
    <div class="container">
        <div flash-message="5000" ></div>
		    <div ng-view="">Chargement</div>
    </div>
		<script src="vendor/components/angular.js/angular.min.js"></script>
		<script src="vendor/components/angular.js/angular-route.js"></script>
		<script src="vendor/components/angular.js/angular-animate.js"></script>
		<script src="../../lib/angular-flash/angular-flash.min.js"></script>
		<script src="../../lib/ngStorage/ngStorage.min.js"></script>
		<script src="../../lib/angular-load/angular-load.min.js"></script>
		<script src="../../lib/ng-flow/ng-flow-standalone.min.js"></script>
		<script src="../../lib/angular-validation-match/angular-validation-match.min.js"></script>
		<script src="app.js"></script>
		<script src="controllers/BlogCtrl.js"></script>
		<script src="controllers/UsersCtrl.js"></script>
		<script src="controllers/AboutCtrl.js"></script>
	</body>
</html>
