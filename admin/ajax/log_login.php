<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include("geoiploc.php");
?>

<table class="table text-center list-ip">
	<tr>
		<th class="text-center" style="width: 25%;">DATA</th>
		<th class="text-center" style="width: 25%;">IP ADRESAS</th>
		<th class="text-center" style="width: 25%;">VARTOTOJAS</th>
		<th class="text-center" style="width: 25%;">ŠALIS</th>
	</tr>

	<?php
	$sms_c = $mysqli->query("SELECT * FROM `unban_log_login` ORDER BY `date` DESC LIMIT 5");
	while($row = $sms_c->fetch_object()): ?>
	<tr>
		<td><?php echo $row->date; ?></td>
		<td><?php echo $row->ip; ?></td>
		<td><?php echo $row->name; ?></td>
		<td><?php echo getCountryFromIP($row->ip, "name"); ?></td>
	</tr>
	<?php endwhile; ?>
</table>