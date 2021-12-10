<?php
require __DIR__ . '/vendor/autoload.php';
$server   = "meuro.dev";
$port     = 1883;
$clientId = 'temperino';

$mqtt = new \PhpMqtt\Client\MqttClient($server, $port, $clientId);
$connectionSettings = (new \PhpMqtt\Client\ConnectionSettings)
    ->setConnectTimeout(10)
    ->setSocketTimeout(10)
    ->setUseTls(false)
    ->setKeepAliveInterval(10);
$mqtt->connect($connectionSettings, true);
$mqtt->subscribe('brtt6/temp', function ($topic, $message) {
    echo sprintf("Received message on topic [%s]: %s\n", $topic, $message);
},1);
$mqtt->loop();
$mqtt->interrupt();
$mqtt->disconnect();