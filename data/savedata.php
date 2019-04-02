<?php
// gets data from sensors outside, inside or buttons,
// modifies accordingly readings.json

$read_inside = "";
$read_outside = "";
$prog = "";

if ( isset($_GET['program']) ) { $prog = $_GET['program']; }
if ( isset($_GET['temp_out']) ) { $read_outside['temp_out'] = $_GET['temp_out']; }
// if ( isset($_GET['humi_out']) ) { $read_outside['humi_out'] = $_GET['humi_out']; }
if ( isset($_GET['baro_out']) ) { $read_outside['baro_out'] = $_GET['baro_out']; }
if ( isset($_GET['temp_in']) ) { $read_inside['temp_in'] = $_GET['temp_in']; }
if ( isset($_GET['humi_in']) ) { $read_inside['humi_in'] = $_GET['humi_in']; }

// var_dump($prog);
// var_dump($read_outside);
// var_dump($read_inside);

if ($read_outside || $read_inside || $prog) {

	// read json
	$jsonString = file_get_contents('/var/www/html/temperino_v2/data/readings.json');
	$data = json_decode($jsonString, true);
	// echo '-------------';
	// var_dump($data);
	// echo '-------------';
	if ($read_outside) {
		$data['outside']['temp'] = round($read_outside['temp_out'],1);
		// $data['outside']['humi'] = round($read_outside['humi_out'],1);
		$data['outside']['press'] = round($read_outside['baro_out'],1);
		$data['outside']['timestamp'] =  date('d M y - H:i');
	}
	if ($read_inside) {
		$data['inside']['temp'] = round($read_inside['temp_in'],1);
		$data['inside']['humi'] = round($read_inside['humi_in'],1);
		$data['inside']['timestamp'] =  date('d M y - H:i');
	}
	if ($prog) {
		if ($prog['temp'] != "-") {
			$data['program']['mode'] = $prog['mode'];
			$data['program']['temp'] = $prog['temp'];
		} else {
			$data['program']['mode'] = $prog['mode'];
		}
		$data['program']['timestamp'] =  date('d M y - H:i');
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
