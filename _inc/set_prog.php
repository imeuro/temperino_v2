<h2>Program mode:</h2>
<time id="manual_time_val"></time>

<div class="modebuttons-container program-mode small">
	<button class="heat-mode" data-program="T3">T3 / MANUAL</button>
	<button class="heat-mode" data-program="T2">T2 / MANUAL</button>
	<button class="heat-mode on" data-program="AUTO">AUTO</button>
</div>


<h2>Manual mode:</h2>
<div class="manual-mode small">
	<button class="manual-adjust manual-adjust-down">-</button>
	<h3 id="manual-mode-value" class="manual-adjust-value">18</h3>
	<button class="manual-adjust manual-adjust-up">+</button>
	<div class="modebuttons-container program-mode small">
		<button id="manual-mode-set" class="heat-mode heat-mode-manual-set" data-program="MANUAL">SET TEMP</button>
	</div>
</div>

<h2>Summer mode:</h2>
<div class="modebuttons-container summer-mode small">
	<button class="heat-mode heat-mode-off" data-program="OFF">OFF</button>
</div>
<script>
jQuery(document).ready(function() {

	// read current status and set it on UI:
	jQuery.getJSON('https://nas.imeuro.io/temperino_v2/data/readings.json', function(readings) {
    //console.log(readings.program);
		jQuery('button[data-program]').removeClass('on');
		jQuery('button[data-program="'+readings.program.mode+'"]').addClass('on');
		jQuery('#manual-mode-value').text(readings.program.temp);
		jQuery('#manual_time_val').text(readings.program.timestamp);
  });

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
		  method: "GET",
		  url: "https://nas.imeuro.io/temperino_v2/data/savedata.php",
		  data: { program: { mode: whatprog, temp: whattemp } }
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
