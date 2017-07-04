<?php

header("Access-Control-Allow-Origin: *");    
header('Content-Type: application/json');

function __autoload($className) {

		$className =  str_replace('\\', '/', $className);
		require_once 'bin/'.$className . '.php'; 
     } 


if(!empty($_GET['controller']) && !empty($_GET['action'])) {
	
	$controllers = ['test','auth','sign_up'];

	if(in_array($_GET['controller'], $controllers)) {

		$controllerName = 'controller\\'.$_GET['controller'].'_controller';

		$controller = new $controllerName($_POST);

		if(method_exists($controller,$_GET['action'])) {
			$datas = $controller->run($_GET['action']);
		} else {
			$datas = $controller->get404();
		}

		
	} else {
		$datas = ["error" => 404, "message" => "no controller"];
	}

	print json_encode($datas);
}

die();


