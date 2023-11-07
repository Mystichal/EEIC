<?php
	require_once 'init/autoload.php';

	use app\core;
	use app\router;

	$core = new core();
	$router = new router();

	$router->get('/', 'index@index');
	$router->get('/home', 'home@index');

	$core->run($router);