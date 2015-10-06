<?php
  header('Content-Type: text/html; charset=utf-8');
	
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  $realpath = realpath(dirname(__FILE__).'/..');
  /**
  * INITIALISATION COMPOSER
  **/
  require("$realpath/vendor/autoload.php");
  use \Michelf\Markdown;
  use Intervention\Image\ImageManager;

  require("$realpath/vendor/ircmaxell/password-compat/lib/password.php");
  require("$realpath/api/config.php");
  require("$realpath/api/functions.php");
  /**
  * INITIALISATION CONFIGURATION
  **/
	$ImageManager = new ImageManager(array('driver' => 'gd'));
	$parser = new Markdown;
	$encryptionKey = '6zp4y5vnUQI6dCASh46Fsasf09jl5Dmqa4NDcM1W421=';
	$macKey = 'RJikK3QnUmqgQPXBwCSOs12hdOjks2s9321knfcQOTU=';
	$crypt = new \PHPEncryptData\Simple($encryptionKey, $macKey);
	$app = new \Slim\Slim();
	$app->response->headers->set('Content-Type', 'application/json');
  
  /**
  *	LOAD DES CONFIGURATIONS
  **/
  $app->get('/', function(){	  
	try {
		$pdo = getConnection();
		$selectStatement = $pdo->select()->from('an_settings');
		$stmt = $selectStatement->execute()->fetchAll(PDO::FETCH_CLASS);
		foreach($stmt as $v){
			define($v->name,$v->value);
		}
	} catch( PDOException $e ) {
        if(strstr($e->getMessage(), 'SQLSTATE[')) { 
            preg_match('/SQLSTATE\[(\w+)\] \[(\w+)\] (.*)/', $e->getMessage(), $matches); 
            $code = ($matches[1] == 'HT000' ? $matches[2] : $matches[1]); 
            $message = $matches[3]; 
        } 		
		echo '<h2>Problème avec la base de donnée.</h2>';
		echo "<p><strong>ERREUR: [$code]</strong> ".utf8_encode($message);
		die();
	}
  });
  
  /**
  *	LOAD DES PAGES
  **/
  foreach (glob("pages/*.php") as $filename){
    include $filename;
  }
  $app->run();
?>
