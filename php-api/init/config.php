<?php
if(!isset($_SESSION)) {
	session_start();
}

defined('SITE_URL')
	|| define('SITE_URL', 'http://' . $_SERVER['SERVER_NAME']);

defined('DS')
	|| define('DS', DIRECTORY_SEPARATOR);

defined('ROOT_PATH')
	|| define('ROOT_PATH', realpath(dirname(__FILE__) . DS . '..' . DS));

defined('APP_DIR')
	|| define('APP_DIR', 'app');

defined('INIT_DIR')
	|| define('INIT_DIR', 'init');

set_include_path(implode(PATH_SEPARATOR, array(
	realpath(ROOT_PATH . DS . APP_DIR),
	realpath(ROOT_PATH . DS . INIT_DIR),
	get_include_path()
)));