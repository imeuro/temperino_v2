<?php
$dataset = json_decode($_GET['thermo']);
print_r($dataset);
if ($dataset) {

	$client = new Mosquitto\Client();
	$client->onConnect('connect');
	$client->onDisconnect('disconnect');
	$client->onPublish('message');
	$client->connect("meuro.dev", 1883, 5);

	while (true) {
		$client->loop();
		$mid = $client->publish('brtt6/test', $dataset, 1, true);
		echo "Sent message ID: {$mid}\n";
		$client->loop();

		sleep(2);
	}

	$client->disconnect();
	unset($client);

	function message($message) {
		printf("Sent a message ID %d \n\n", $message->mid);
	}

	function disconnect() {
		echo "Disconnected cleanly\n";
	}
}
?>
