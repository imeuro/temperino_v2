<h2>Status: inside</h2>
<?php
$mqtt_temp = [];
$client = new Mosquitto\Client();
$client->onDisconnect('disconnect');
$client->onMessage('message');
$client->connect("meuro.dev", 1883, 5);
$client->subscribe('brtt6/temp', 1);

for ($i = 0; $i < 5; $i++) {
    $client->loop();
}

$client->unsubscribe('brtt6/temp');

for ($i = 0; $i < 5; $i++) {
    $client->loop();
}

function message($message) {
    //printf("Got a message on topic %s with payload:\n%s\n", $message->topic, $message->payload);
    $mqtt_temp = json_decode($message->payload, true);
?>
    <time id="in_time_val"><?php echo $mqtt_temp['temp_last_mod'] ?></time>
    <div class="gauge-container temp-gauge">
        <canvas width="270" height="250" id="in_TEMPERATURE" class="gauge"></canvas>
        <span id="in_temp_val" data-type="Temperature" data-scale="°C"><?php echo $mqtt_temp['cur_temp'] ?></span>
    </div>

    <div class="gauge-container small humi-gauge">
        <canvas width=135 height=130 id="in_HUMIDITY" class="gauge"></canvas>
        <span id="in_humi_val" data-type="Humidity" data-scale="%"><?php echo $mqtt_temp['cur_humi'] ?></span>
    </div>
<?php
}

function disconnect() {
    //echo "Disconnected cleanly\n";
    print_r($mqtt_temp);
}

function logger() {
    var_dump(func_get_args());
}
?>