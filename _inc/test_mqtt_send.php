<?php
require __DIR__ . '/vendor/autoload.php'; 
$server   = 'meuro.dev';
$port     = 1883;
$clientId = 'test-publisher';

$mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
$mqtt->connect();
$mqtt->publish('brtt6/test', 'Hello Worldsss!', 1);
$mqtt->disconnect();

?>
