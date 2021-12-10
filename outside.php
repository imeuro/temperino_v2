<?php

$o_temp = $_GET['o_temp'];
$o_baro = $_GET['o_baro'];

$o_file = '/var/www/html/pizero-weather/logs/o_data.json';
$o_data = file_get_contents($o_file);

if ($o_data) :

	// log to file
	if ($o_data && $o_temp && $o_baro) :
		$o_data = "{temp: $o_temp, baro: $o_baro}";
		file_put_contents($o_file, $o_data);
	endif;

endif;

// debug
var_dump($o_data);
?>
