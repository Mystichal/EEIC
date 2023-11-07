<?php
	namespace controllers;

	use app\helpers;

	class index extends \app\base {
		protected $model = 'blueprints';

		public function index() {
			$props = [
				'blueprints' => $this->data->getData(),
				'types' => $this->data->getTypes(),
				'sub-types' => $this->data->getSubTypes(),
				'names' => $this->data->getNames()
			];
			

			$helpers = new helpers();
			$helpers->view('index/index', compact('props'));
		}
	}