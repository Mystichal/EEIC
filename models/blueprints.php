<?php
	namespace models;

	use app\helpers;

	class blueprints {
		private $root_path = ROOT_PATH . DS . 'data' . DS . '05,blueprints';

		public function getData() {
			$helpers = new helpers;
			$paths = $helpers->readdirScandir($this->root_path, 'json');
			$data = [];

			foreach ($paths as $path) {
				$json = json_decode(file_get_contents($path, 'data.json'), true);
				$data[substr(explode('/', $path)[3], 3)] = $json;
			}

			return $data;
		}

		public function getTypes() {
			$helpers = new helpers;
			$types = $helpers->readdir($this->root_path);

			foreach ($types as $key => $value) {
				$types[$key] = substr($value, 3);
			}

			return $types;
		}

		public function getSubTypes() {
			$helpers = new helpers;
			$subtypes = $helpers->readdirsub($this->root_path);
			$filterd = [];

			foreach ($subtypes as $cat => $subtype) {
				foreach ($subtype as $value) {
					$filterd[substr($cat, 3)][] = substr($value, 3);
				}
			}

			return $filterd;
		}

		public function getNames() {
			$helpers = new helpers;
			$data = $helpers->readdirsubsub($this->root_path);
			$filterd = [];

			foreach ($data as $type => $subtype) {
				foreach ($subtype as $key => $names) {
					foreach ($names as $keys => $name) {
						$filterd[substr($type, 3)][substr($key, 3)][$keys] = substr($name, 3);
					}
				}
			}

			return $filterd;
		}
	}