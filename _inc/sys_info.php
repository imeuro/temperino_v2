<h2>System Info</h2>

<?php
$current_time = exec("date +'%d %b %Y - %T %Z'");
$cpu_temperature = round(exec("cat /sys/class/thermal/thermal_zone0/temp ") / 1000, 1);
$host = exec('hostname -f');

//Uptime
	$uptime_array = explode(" ", exec("cat /proc/uptime"));
	$seconds = round($uptime_array[0], 0);
	$minutes = $seconds / 60;
	$hours = $minutes / 60;
	$days = floor($hours / 24);
	$hours = sprintf('%02d', floor($hours - ($days * 24)));
	$minutes = sprintf('%02d', floor($minutes - ($days * 24 * 60) - ($hours * 60)));
	if ($days == 0):
		$uptime = $hours . ":" .  $minutes . " (hh:mm)";
	elseif($days == 1):
		$uptime = $days . " day, " .  $hours . ":" .  $minutes . " (hh:mm)";
	else:
		$uptime = $days . " days, " .  $hours . ":" .  $minutes . " (hh:mm)";
	endif;

// Load averages
$loadavg = file("/proc/loadavg");
if (is_array($loadavg)) {
	$loadaverages = strtok($loadavg[0], " ");
	for ($i = 0; $i < 2; $i++) {
		$retval = strtok(" ");
		if ($retval === FALSE) break; else $loadaverages .= " " . $retval;
	}
}
?>

<ul class="sys_info_table">
	<li>Current Time:</li> 		<li><?php echo $current_time; ?></li>
	<li>Hostname:</li> 				<li><?php echo $host; ?></li>
	<li>UpTime:</li> 					<li><?php echo $uptime; ?></li>
	<li>CPU Temp:</li> 				<li><?php echo $cpu_temperature.'&deg;C'; ?></li>
	<li>Load averages:</li> 	<li><?php echo $loadaverages; ?></li>
	<li><br /><br /></li> 		<li><br /><br /></li>
	<li>Reboot system:</li> 	<li><button>REBOOT</button></li>
</ul>

<div id="reboot_confirm" class="modal hidden">
	<p>You sure?</p>
	<button id="reboot_ok">Yes</button>
	<button id="reboot_ko">No</button>
</div>
