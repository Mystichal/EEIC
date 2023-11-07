<?php $title = 'Home' ?>
<?php require_once __DIR__ . '/../general/header.php'; ?>

<h1>Home</h1>

<? 
	$csvFile = fopen(__DIR__ . '/../../bigData.csv', 'r');
	if ($csvFile === false) {
		die('Error opening file');
	}

	$header = fgetcsv($csvFile);
	$headerPass = false;

	while (($data = fgetcsv($csvFile)) !== false) {
		// Mapping for the PI requirements
		$piRequirementsMapping = [
			12 => 'lustering alloy',
			13 => 'sheen compound',
			14 => 'gleaming alloy',
			15 => 'condensed alloy',
			16 => 'precious alloy',
			17 => 'motley compound',
			18 => 'fiber composite',
			19 => 'lucent compound',
			20 => 'opulent compound',
			21 => 'glossy compound',
			22 => 'crystal compound',
			23 => 'dark compound',
			29 => 'reactive gas',
			30 => 'noble gas',
			24 => 'base metals',
			25 => 'heavy mentals',
			27 => 'noble metals',
			26 => 'reactive metals',
			28 => 'toxic metals',
			31 => 'industrial fibers',
			32 => 'super tensile plastics',
			33 => 'polyaramids',
			34 => 'coolant',
			35 => 'condensates',
			36 => 'construction blocks',
			37 => 'nanites',
			38 => 'silicate glass',
			39 => 'smartfab units',
			40 => 'precious metals',
			41 => 'non-cs crystals',
		];

		// Mapping for the ore requirements
		$oreRequirementsMapping = [
			4 => 'tritanium',
			5 => 'pyrite',
			6 => 'mexallon',
			7 => 'isogen',
			8 => 'noxium',
			9 => 'zydrine',
			10 => 'megacyte',
			11 => 'morphite',
			42=> 'compressed tritanium',
		];

		// Creating the main JSON structure
		$jsonData = [
			'name' => $data[1] . ' Blueprint',
			'volume' => 0.01,
			'products' => $data[1],
			'tech level' => $data[3],
			'manufacturing time' =>  gmdate("H:i:s", intval(preg_replace('/[^\d.]/', '', $data[51]))),
			'manufacturing cost' => intval(preg_replace('/[^\d.]/', '', $data[50])),
			'material efficiency' => 150,
			'time efficiency' => 100,
			'pi requirements' => [],
			'ore requirements' => [],
			'obtainable' => [],
			'description' => '',
		];

		// Populate PI requirements
		foreach ($piRequirementsMapping as $index => $piName) {
			$value = $data[$index];
			if (is_string($value)) {
				$value = str_replace(',', '', $value);
			}
			$jsonData['pi requirements'][$piName] = ceil(((int) $value / 100) * 150);
		}

		// Populate ore requirements
		foreach ($oreRequirementsMapping as $index => $oreName) {
			$value = $data[$index];
			if (is_string($value)) {
				$value = str_replace(',', '', $value);
			}
			$jsonData['ore requirements'][$oreName] = ceil(((int) $value / 100) * 150);
		}

		if ($headerPass) {
			$jsonDataArray[] = $jsonData;

			// Convert the array to JSON
			$finalJson = json_encode($jsonData, JSON_PRETTY_PRINT);

			// Output the JSON
			echo '<pre>';
			echo $finalJson;
			echo '</pre>';
		}
		

		$headerPass = true;
	}

	// Close the CSV file
	fclose($csvFile);
?>

<?php require_once __DIR__ . '/../general/footer.php'; ?>