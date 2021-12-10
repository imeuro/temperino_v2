<?php
// gets data from sensors outside, inside or buttons,
// modifies accordingly readings.json

if ($_GET['program']) {
	$prog = $_GET['program'];
	$prog = strtoupper(str_replace(' ', '', $prog));
}

var_dump($prog);

if ($prog) {

	// read json
	$jsonString = file_get_contents('/var/www/html/temperino_v2/data/readings.json');
	$data = json_decode($jsonString, true);
	// echo '-------------';
	// var_dump($data);
	// echo '-------------';
	if ($prog) {

                if ($prog == "SPENTO" || $prog == "AUTO") {
			$data['program']['mode'] = "AUTO";
			$data['program']['temp'] = 8;
		} else if ($prog == "ACCESO") {
			$data['program']['mode'] = "T2";
			$data['program']['temp'] = 17.5;
		} else if (strpos($prog, "GRADI") !== false) {
                	$data['program']['mode'] = "MANUAL";
                        $data['program']['temp'] = str_replace('GRADI', '', $prog);
                }

		$data['program']['timestamp'] =  date('H:i');
 	}

	// write new data to json
	$newJsonString = json_encode($data);

	var_dump($newJsonString);

	file_put_contents('/var/www/html/temperino_v2/data/readings.json', $newJsonString);

} else {
	// nothing to write!
	echo 'no data.';
}
?>
