<?php if(MAIN_ADMIN): ?>
<?php if(isset($_POST['submit'])):
	foreach ($_POST as $key => $value):
		$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
		
		$result = $mysqli->query("SELECT * FROM `unban_config` WHERE `id` = '".$key."'");
		if($result->num_rows):
			$mysqli->query("UPDATE `unban_config` SET `value` = '".$value."' WHERE `id` = '".$key."'");
		endif;
	endforeach; ?>
	<div class="alert alert-success">Nustatymai sėkmingai atnaujinti!</div>
	<?php header("Location: ./?action=settings"); ?>
<?php endif; ?>

<form method="POST">
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>SMS TIPAS</label>
				<select class="form-control" name="sms_type">
					<option value="0">PaySera</option>
					<option value="1" <?php if($sms_type) echo "selected" ?>>VPSNet</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>NUMATYTOJI KALBA</label>
				<select class="form-control" name="main_lang">
					<?php
					while($rfl = $fl->fetch_object())
					{
						if($rfl->prefix == $main_lang) { $selected = "selected"; } else { $selected = ""; }
					
						if(file_exists('../lang/'.$rfl->prefix.'.php')) {
							echo '<option value="'.$rfl->prefix.'" '.$selected.'>'.strtoupper($rfl->prefix).'</option>'; }
					}
					?>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>Makro sistema</label>
				<select class="form-control" name="makro_type">
					<option value="0">Išjungta</option>
					<option value="1" <?php if($makro_type == 1) echo "selected" ?>>PaySera</option>
					<option value="2" <?php if($makro_type == 2) echo "selected" ?>>VPSNet</option>
				</select>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>SMS SISTEMA</label>
				<select class="form-control" name="sms_status">
					<option value="0">Išjungta</option>
					<option value="1" <?php if($sms_status) echo "selected" ?>>Įjungta</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>SVETAINĖS PAVADINIMAS</label>
				<input type="text" class="form-control" name="web_title" value="<?php echo $web_title; ?>">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>AMXBANS PRIEDĖLIS</label>
				<input type="text" class="form-control" name="amxbans_prefix" value="<?php echo $amxbans_prefix; ?>">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>SISTEMOS VIETA</label>
				<input type="text" class="form-control" name="home_dir" value="<?php echo $home_dir; ?>">
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-3">
		<div class="form-group">
			<label>PROJEKTO ID</label>
			<input type="number" class="form-control" name="paysera_projectid" value="<?php echo $paysera_projectid; ?>">
		</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>PROJEKTO SIGN SLAPTAŽODIS</label>
				<input type="text" class="form-control" name="paysera_sign" value="<?php echo $paysera_sign; ?>">
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label>MAKRO UNBAN KAINA (CENTAIS)</label>
				<input type="text" class="form-control" name="paysera_makro_price" value="<?php echo $paysera_makro_price; ?>">
			</div>
		</div>
		<div class="col-md-3"></div>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-3">
			<div class="form-group">
				<label>VPSNET MOKĖJIMŲ SLAPTAŽODIS</label>
				<input type="text" class="form-control" name="vpsnet_systems_pass" value="<?php echo $vpsnet_systems_pass; ?>">
			</div></div>
		<div class="col-md-3"></div>
		<div class="col-md-3"></div>
		<div class="col-md-3"></div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="submit" class="btn btn-warning" name="submit" value="Atnaujinti" style="width: 100%;">
			</div>
		</div>
	</div>
</form>

<?php endif; ?>