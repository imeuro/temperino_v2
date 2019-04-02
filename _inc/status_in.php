<h2>Status: inside</h2>
<time id="in_time_val"></time>

<div class="gauge-container temp-gauge">
	<canvas width="270" height="250" id="in_TEMPERATURE" class="gauge"></canvas>
	<span id="in_temp_val" data-type="Temperature" data-scale="°C">26</span>
</div>

<div class="gauge-container small humi-gauge">
	<canvas width=135 height=130 id="in_HUMIDITY" class="gauge"></canvas>
	<span id="in_humi_val" data-type="Humidity" data-scale="%">76</span>
</div>

<div class="otherdata-container small">
	<button id="program_mode" class="heat-status on">AUTO</button>
</div>

<script>
jQuery(document).ready(function() {

	// read current status and set it on UI:
	jQuery.getJSON('http://192.168.1.110/pizero-weather/logs/home_readings.json', function(readings) {
		readings.inside.temp = Math.round( readings.inside.temp * 10) / 10
		jQuery('#in_time_val').text(readings.inside.time);
		jQuery('#in_temp_val').text(readings.inside.temp);
		jQuery('#in_humi_val').text(readings.inside.humi);
		//jQuery('#program_mode').text(readings.program.mode);
	});


	jQuery('.heat-status').on( "click", function() {
		document.location.href = '#slide3';
	});
});
</script>
