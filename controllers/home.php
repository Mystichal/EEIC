<?php
	namespace controllers;

	use app\helpers;

	class home extends \app\base {
		protected $model = 'home';

		public function index() {
			$helpers = new helpers();
			$helpers->view('home/index', []);
		}
	}