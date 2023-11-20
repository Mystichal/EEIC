<?php
	namespace app;

	class core {
		public function run($router) {
			$router->resolve();
		}
	}