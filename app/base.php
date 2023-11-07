<?php
	namespace app;

	use Exception;

	class base {
		protected $data;
		protected $model;

		public function __construct() {
			if (isset($this->model)) {
				$model = 'models\\' . $this->model;
			} else {
				$controller = explode('\\', static::class);
				print_r(static::class);
				$model = 'models\\' . end($controller);
			}

			if (file_exists(str_replace('\\', DS, $model) . ".php")) {
				$this->data = new $model();
			} else {
				throw new Exception('There is a problem with loading the models');
			}
		}
	}