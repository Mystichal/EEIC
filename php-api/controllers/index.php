<?php
	namespace controllers;

	use app\helpers;

	class index extends \app\base {
		protected $model = 'index';

		public function index() {
			$helpers = new helpers();
			$helpers->view('index/index');
		}
	}