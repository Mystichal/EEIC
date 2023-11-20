<?php
	namespace app;

	class helpers {
		function dd($data) {
			var_dump($data);
			exit;
		}

		function view($name, $data = []) {
			extract($data);

			if (file_exists(__DIR__ . "/../views/$name.php")) {
				require_once __DIR__ . "/../views/$name.php";
			} else {
				echo "<h1 style='color: red; text-align: center'>View [$name] Not found</h1>";
				exit;
			}
		}

		function abort() {
			http_response_code($code = 404);

			if (file_exists(__DIR__ . "/../views/error/$code.php")) {
				$this->view("error/$code");
			} else {
				echo "Error $code";
			}

			exit;
		}

		function public_dir($file) {
			if (strpos($file, '/') === 0) {
				$file = substr($file, 1);
			}

			return 'http://localhost/public/' . $file;
		}

		function readdirScandir($dir, $extension) {
			$files = [];
			$root = @scandir($dir, SCANDIR_SORT_NONE);

			foreach ($root as $entry) {
				if ($entry === '.' || $entry === '..') {
					continue;
				}

				$fullpath = $dir.'/'.$entry;
				if (is_file($fullpath)) {
					if (0 === strcasecmp($extension, pathinfo($fullpath, PATHINFO_EXTENSION))) {
						$files[] = $fullpath;
					}
					continue;
				}

				foreach($this->readdirScandir($fullpath, $extension) as $entry) {
					if(0 === strcasecmp($extension, pathinfo($entry, PATHINFO_EXTENSION))) {
						$files[] = $entry;
					}
				}
			}

			return $files;
		}

		function readdir($dir) {
			$files = [];
			$root = @scandir($dir, SCANDIR_SORT_NONE);

			foreach ($root as $entry) {
				if ($entry === '.' || $entry === '..') {
					continue;
				}

				$fullpath = $dir . '/' . $entry;
				if (is_file($fullpath)) {
					continue;
				}

				$files[] = $entry;
			}

			return $files;
		}

		function readdirsub($dir) {
			$files = [];
			$root = @scandir($dir, SCANDIR_SORT_NONE);

			foreach ($root as $entry) {
				if ($entry === '.' || $entry === '..') {
					continue;
				}

				$fullpath = $dir . '/' . $entry;
				if (is_file($fullpath)) {
					continue;
				}

				foreach ($this->readdir($fullpath) as $subentry) {
					$files[$entry][] = $subentry;
				}
			}

			return $files;
		}

		function readdirsubsub($dir) {
			$files = [];
			$root = @scandir($dir, SCANDIR_SORT_NONE);

			foreach ($root as $entry) {
				if ($entry === '.' || $entry === '..') {
					continue;
				}

				$subtypes = $dir . '/' . $entry;
				if (is_file($subtypes)) {
					continue;
				}

				foreach ($this->readdir($subtypes) as $subentry) {
					$names = $dir . '/' . $entry . '/' . $subentry;
					foreach ($this->readdir($names) as $name) {
						$files[$entry][$subentry][] = $name;
					}
				}
			}

			return $files;
		}
	}