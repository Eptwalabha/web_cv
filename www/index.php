<?php
session_start();

require_once ("./core/define.php");
require_once ("./core/model.php");
require_once ("./core/controller.php");
require_once ("./core/connection.php");
require_once ("./core/datachecker.php");

$controller_name = "accueil";

$debug_sql = false;

$connection = connection::getConnection()->setParameters(DB_DNS, DB_NAME, DB_LOGIN, DB_PSW, $debug_sql);

$param = explode("/", $_GET["param"]);

if (file_exists(ROOT."controllers/".$param[0].".php")) {
	
	$controller_name = $controller = $param[0];
	
	$action = isset($param[1]) ? $param[1] : "main";
	
} else {
	
	$controller = "accueil";
	
	$action = "main";

}

require ("./controllers/$controller.php");

$controller = new $controller($connection);

if (method_exists($controller, $action)) {

	if (isset($param[2])) {
		
		$controller->$action($param[2]);
	
	} else {
		
		$controller->$action();
	
	}

} else {

	ob_start();
	
	require (ROOT."views/commun/404.php");

	$layout_content = ob_get_clean();

	require (ROOT."views/layouts/basic.php");

}