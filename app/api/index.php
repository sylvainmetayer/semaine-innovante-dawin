<?php

header("Access-Control-Allow-Origin: *");

header("Content-type: application/json; charset=UTF-8;");

function __autoload($className) {
    $className = str_replace('\\', '/', $className);
    require_once 'bin/' . $className . '.php';
}

$configs = include("config.inc.php");
$db = new PDO("mysql:host=" . $configs["db_host"] . "; dbname=" . $configs["db_name"], $configs["db_user"], $configs["db_password"],
    array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => $configs["db_debug"], PDO::ERRMODE_EXCEPTION => $configs["db_debug"]));

if (!empty($_GET['controller']) && !empty($_GET['action'])) {

    $controllers = ['test', 'auth', 'result', 'email'];

    if (in_array($_GET['controller'], $controllers)) {

        $controllerName = 'controller\\' . $_GET['controller'] . '_controller';

        $controller = new $controllerName($_POST, $db);

        if (method_exists($controller, $_GET['action'])) {
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


