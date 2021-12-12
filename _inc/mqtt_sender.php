<?php
$dataset = $_GET['thermo'];
// print_r($dataset);
$jdataset=json_decode($dataset,true);
$jdataset["last_mod"] = date("d-m-Y H:i");
// print_r($jdataset);
$dataset = json_encode($jdataset);
print_r($dataset);

if (!empty($dataset)) {
	$client = new Mosquitto\Client('PostListenerClient');
	$client->connect('meuro.dev', 1883);
	$client->publish('brtt6/thermo',$dataset, 1, 1);
	$client->disconnect();
}
?>
