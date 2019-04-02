<h2>Status: outside</h2>
<time id="out_time_val"></time>

<div class="gauge-container temp-gauge">
	<canvas width="270" height="225" id="out_TEMPERATURE" class="gauge"></canvas>
	<span id="out_temp_val" data-type="Temperature" data-scale="°C">33</span>
</div>

<!--div class="gauge-container small humi-gauge">
	<canvas width=135 height=130 id="out_HUMIDITY" class="gauge"></canvas>
	<span id="out_humi_val" data-type="Humidity" data-scale="%">84</span>
</div-->
<div class="gauge-container small pressure-gauge">
	<canvas width="200" height="150" id="out_PRESSURE" class="gauge"></canvas>
	<span id="out_press_val" data-type="Pressure" data-scale="mbar">1016</span>
</div>

<script>
	jQuery(document).ready(function() {
	// read current status and set it on UI:
	jQuery.getJSON('http://192.168.1.110/pizero-weather/logs/home_readings.json', function(readings) {
		readings.outside.temp = Math.round( readings.outside.temp * 10) / 10
		jQuery('#out_time_val').text(readings.outside.time);
		jQuery('#out_temp_val').text(readings.outside.temp);
		//jQuery('#out_humi_val').text(readings.outside.humi);
		jQuery('#out_press_val').text(readings.outside.press);
	});
});
</script>
