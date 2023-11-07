<?php
	return [
		[
			'url' => '/',
			'name' => 'index',
			'controller' => \controllers\index::class,
			'method' => 'index'
		],
		[
			'url' => '/home',
			'name' => 'home',
			'controller' => \controllers\home::class,
			'method' => 'index'
		],
	];