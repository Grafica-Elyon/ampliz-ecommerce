<?php
session_start();
require_once(ABSPATH . 'wp-content/plugins/misterprint-ecommerce/vendor/facebook/autoload.php');


$FBObject = new \Facebook\Facebook([
	'app_id' =>  config('env', 'APP_FACEBOOK_ID'), 
	'app_secret' =>  config('env', 'APP_FACEBOOK_SECRET'),
	'default_graph_version' =>  config('env', 'APP_FACEBOOK_VERSION') 
]);

 $handler = $FBObject -> getRedirectLoginHelper();
 var_dump($handler);
?>


