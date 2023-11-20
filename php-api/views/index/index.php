<?php
	$response = [
		'valid endpoints' => [
			'/blueprints' => 'too get all blueprints',
			'/blueprint/$blueprintName' => 'to get a specific blueprint'
		]
	];

	echo json_encode($response, JSON_UNESCAPED_SLASHES);