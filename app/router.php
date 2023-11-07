<?php
	namespace app;

	use Exception;
	use app\helpers;

	class router {
		 protected $routes = [];

		 public function get($uri, $controller) {
		 	$this->routes[$uri] = $controller;
		 }

		 public function resolve() {
		 	$helpers = new helpers;
		 	$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		 	if (array_key_exists($uri, $this->routes)) {
		 		$this->callAction(...explode('@', $this->routes[$uri]));
		 	} else {
		 		$helpers->abort();
		 	}
		 }

		 protected function callAction($controller, $action) {
		 	$controller = "controllers\\{$controller}";
		 	$controller = new $controller();

		 	if (!method_exists($controller, $action)) {
		 		throw new Exception("{$controller} does not respond to the {$action} action.");
		 	}

		 	$controller->$action();
		 }
	}