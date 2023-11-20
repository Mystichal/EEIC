<?php
	namespace controllers;

	use app\helpers;

	class blueprints extends \app\base {
		protected $model = 'blueprints';

		public function index() {
			$props = [
				'blueprints' => $this->data->getData()
			];

			$helpers = new helpers();
			$helpers->view('blueprints/index', compact('props'));
		}
	}