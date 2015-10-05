<?php
	if(!file_exists('vendor/')){
		echo "<h2>Oops, vous devez installer la plateform avec Composer.</h2>";
		die();
	}
  require "api/index.php";
  header('content-type:text/html');
  require "templates/".TEMPLATE."/index.php";
?>
