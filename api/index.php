<?php
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

  $ImageManager = new ImageManager(array('driver' => 'imagick'));
  $parser = new Markdown;
  $app = new \Slim\Slim();
  $app->response->headers->set('Content-Type', 'application/json');

  foreach (glob("pages/*.php") as $filename){
    include $filename;
  }
  $app->get('/', function(){
    $pdo = getConnection();
    $selectStatement = $pdo->select()->from('an_settings');
    $stmt = $selectStatement->execute()->fetchAll(PDO::FETCH_CLASS);
    foreach($stmt as $v){
      define($v->name,$v->value);
    }
  });
  $app->run();
?>
