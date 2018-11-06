<?php if(MAIN_ADMIN): ?>
	<div class="row">
		<div class="col-md-6"></div>
		<div class="col-md-6">
			<table class="table table-condensed">
				<thead><th colspan="3" class="text-center">PASKUTINIAI 5 PRISIJUNGIMAI</th></thead>
				<thead>
					<th class="text-center" style="width: 25%;">DATA</th>
					<th class="text-center" style="width: 25%;">IP ADRESAS</th>
					<th class="text-center" style="width: 25%;">VARTOTOJAS</th>
				</thead>
				<tbody>
					<?php $sms_c = $mysqli->query("SELECT * FROM `unban_log_login` ORDER BY `date` DESC LIMIT 5");
					while($row = $sms_c->fetch_object()): ?>
					<tr>
						<td class="text-center"><?php echo $row->date; ?></td>
						<td class="text-center"><?php echo $row->ip; ?></td>
						<td class="text-center"><?php echo $row->name; ?></td>
					</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endif; ?>