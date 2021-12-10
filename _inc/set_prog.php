<h2>Program mode:</h2>
<?php
$mqtt_temp = [];
$client = new Mosquitto\Client();
$client->onDisconnect('disconnect');
$client->onMessage('message');
$client->connect("meuro.dev", 1883, 5);
$client->subscribe('brtt6/thermo', 1);

for ($i = 0; $i < 5; $i++) {
    $client->loop();
}

$client->unsubscribe('brtt6/thermo');

for ($i = 0; $i < 5; $i++) {
    $client->loop();
}

function message($message) {
    //printf("Got a message on topic %s with payload:\n%s\n", $message->topic, $message->payload);
    $mqtt_thermo = json_decode($message->payload, true);
?>
<time id="manual_time_val"><?php echo $mqtt_thermo['last_mod'] ?></time>

<div class="modebuttons-container program-mode small">
	<button class="heat-mode <?php echo $mqtt_thermo['set_prog'] == 'T2' ? 'on' : ''; ?>" data-program="T2">T2 (20°C)</button>
	<button class="heat-mode <?php echo $mqtt_thermo['set_prog'] == 'T1' ? 'on' : ''; ?>" data-program="T1">T1 (17°C)</button>
	<button class="heat-mode <?php echo $mqtt_thermo['set_prog'] == 'AUTO' ? 'on' : ''; ?>" data-program="AUTO">AUTO</button>
</div>


<h2>Manual mode:</h2>
<div class="manual-mode small">
	<button class="manual-adjust manual-adjust-down">-</button>
	<h3 id="manual-mode-value" class="manual-adjust-value"><?php echo $mqtt_thermo['set_temp'] ?></h3>
	<button class="manual-adjust manual-adjust-up">+</button>
	<div class="modebuttons-container program-mode small">
		<button id="manual-mode-set" class="heat-mode heat-mode-manual-set <?php echo $mqtt_thermo['set_prog'] == 'MAN' ? 'on' : ''; ?>" data-program="MANUAL">SET TEMP</button>
	</div>
</div>

<!--h2>Summer mode:</h2>
<div class="modebuttons-container summer-mode small">
	<button class="heat-mode heat-mode-off" data-program="OFF">OFF</button>
</div-->
<script>
jQuery(document).ready(function() {

	jQuery('.heat-mode').on( "click", function() {
		var whatprog = jQuery(this).attr("data-program");
		var whattemp = 8;
		if (whatprog == 'MANUAL') {
			whattemp = jQuery('#manual-mode-value').text();
		} else if (whatprog == 'T3') {
			whattemp = 20.5;
		} else if (whatprog == 'T2') {
			whattemp = 17.5;
		}

		jQuery.ajax({
		  // method: "POST",
		  method: 'GET',
		  url: './_inc/mqtt_sender.php?thermo={ "set_prog": "'+whatprog+'", "set_temp": '+whattemp+' }'
		}).done(function( msg ) {
			printNotice('Program '+whatprog+' set.');
		}).fail(function( msg ) {
		  printNotice('ERROR: Could not set requested program!');
		});

		jQuery('button.heat-mode').each(function(){
			jQuery(this).removeClass('on');
		});

		setTimeout(function(){
			jQuery("button.heat-mode[data-program='"+whatprog+"']").addClass('on');
		},250);


	});

	var targetTemp = jQuery('.manual-adjust-value');

	jQuery('.manual-adjust-down').on( "click", function() {
		targetTemp.removeClass('moveup').addClass('movedown');
		setTimeout(function(){
			var newtemp = parseFloat(targetTemp.text())-0.5;
			console.log(newtemp);
			targetTemp.text(newtemp);
		},250);
		setTimeout(function(){
			targetTemp.removeClass('movedown');
		},750);
	});
	jQuery('.manual-adjust-up').on( "click", function() {
		targetTemp.removeClass('movedown').addClass('moveup');
		setTimeout(function(){
			var newtemp = parseFloat(targetTemp.text())+0.5;
			console.log(newtemp);
			targetTemp.text(newtemp);
		},250);
		setTimeout(function(){
			targetTemp.removeClass('moveup');
		},750);
	});



	var printNotice = function(msgtxt) {
		jQuery('#notice').text(msgtxt).removeClass('hidden').delay(3000).queue(function(){
			$('#notice').addClass('hidden').dequeue();
		});
	}


});
</script>
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
