<?php
$client = new Mosquitto\Client('temperino_temp');
$client->onConnect(function($code, $message) use ($client) {
    $client->subscribe('brtt6/temp', 1);
});

$client->onMessage(function($message) {
    /* Display the message's topic and payload */
    echo $message->topic, "\n", $message->payload, "\n\n";
    $mqtt_temp = json_decode($message->payload, true);
?>
    <div class="gauge-container temp-gauge">
        <canvas width="270" height="250" id="in_TEMPERATURE" class="gauge"></canvas>
        <span id="in_temp_val" data-type="Temperature" data-scale="°C"><?php echo $mqtt_temp['cur_temp'] ?></span>
    </div>

    <div class="gauge-container small humi-gauge">
        <canvas width=135 height=130 id="in_HUMIDITY" class="gauge"></canvas>
        <span id="in_humi_val" data-type="Humidity" data-scale="%"><?php echo $mqtt_temp['cur_humi'] ?></span>
    </div>
<?php
    $client->exitLoop();
    die();
});
/* Connect, supplying the host and port. */
$client->connect('meuro.dev', 1883);
/* Enter the event loop */
$client->loopForever();
?>

