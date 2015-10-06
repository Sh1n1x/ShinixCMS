<?php 
	function getConnection() {
		$dbhost="localhost";
		$dbuser="root";
		$dbpass="root";
		$dbname="an_cms";
		$dbport="8889";
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
		);
		$pdo = new \Slim\PDO\Database("mysql:host=$dbhost;port=$dbport;dbname=$dbname", $dbuser, $dbpass,$options);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $pdo;
	}
?>
