<?php
if(isset($_COOKIE["unban_loged"]))
{
	?>
	<h3><u>NUSTATYMŲ VALDYMAS</u></h3>
	<form action='ajax/settings.php' method='POST' id="form3">
		<table class="table settings-list">
			<tr>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">SMS Tipas</label>
						<select class="form-control" name="sms_type">
							<option value="0">PaySera</option>
							<option value="1" <?php if($sms_type) echo "selected" ?>>VPSNet</option>
						</select>
					</div>
				</td>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">Pagrindinė sistemos kalba</label>
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
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">Makro sistema</label>
						<select class="form-control" name="makro_type">
							<option value="0">Išjungta</option>
							<option value="1" <?php if($makro_type == 1) echo "selected" ?>>PaySera</option>
							<option value="2" <?php if($makro_type == 2) echo "selected" ?>>VPSNet</option>
						</select>
					</div>
				</td>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">SMS sistema</label>
						<select class="form-control" name="sms_status">
							<option value="0">Išjungta</option>
							<option value="1" <?php if($sms_status) echo "selected" ?>>Įjungta</option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">Svetainės pavadinimas (rodomas viršuje)</label>
						<input type="text" class="form-control" name="web_title" value="<?php echo $web_title; ?>">
					</div>
				</td>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">AMXBans pridelis</label>
						<input type="text" class="form-control" name="amxbans_prefix" value="<?php echo $amxbans_prefix; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">Sistemos vieta</label>
						<input type="text" class="form-control" name="home_dir" value="<?php echo $home_dir; ?>">
					</div>
				</td>
				<td>
					
				</td>
			</tr>
		</table>
		<hr />
		<?php /*Mokėjimai.lt nustatymai--start*/ ?>
		<table class="table settings-list" width="100%" id="mokejimailt">
			<tr>
				<td style="border: 0;">
					<h3 style="margin-top: -20px;"><u>PaySera NUSTATYMAI</u></h3>
				</td>
				<td style="border: 0;">
				
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">Projekto ID</label>
						<input type="text" class="form-control" name="paysera_projectid" value="<?php echo $paysera_projectid; ?>">
					</div>
				</td>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">Projekto SIGN slaptažodis</label>
						<input type="text" class="form-control" name="paysera_sign" value="<?php echo $paysera_sign; ?>">
					</div>
				</td>
			</tr>
			<tr>
				<td>	
					<div class="form-group">
						<label for="exampleInputEmail1">Makro mokėjimo kaina (centais)</label>
						<input type="text" class="form-control" name="paysera_makro_price" value="<?php echo $paysera_makro_price; ?>">
					</div>
				</td>
				<td width="50%">	
		
				</td>
			</tr>
		</table>
		<?php /*Mokėjimai.lt nustatymai--end*/ ?>
		<?php /*Vpsnet.lt nustatymai--start*/ ?>
		<table class="table settings-list" width="100%" id="vpsnet">
			<tr>
				<td style="border: 0;">
					<h3 style="margin-top: -20px;"><u>VPSNET.LT NUSTATYMAI</u></h3>
				</td>
				<td style="border: 0;">
				
				</td>
			</tr>
			<tr>
				<td>
					<div class="form-group">
						<label for="exampleInputEmail1">SMS ir MIKRO mokėjimų slaptažodis</label>
						<input type="text" class="form-control" name="vpsnet_systems_pass" value="<?php echo $vpsnet_systems_pass; ?>">
					</div>
				</td>
				<td>
				</td>
			</tr>
		</table>
		<?php /*Vpsnet.lt nustatymai--end*/ ?>
		<table width='100%' align="center">
			<tr>
				<td colspan="2" align="center">
					<div class="form-group">
						<input type="submit" class="form-control" name="submit" value="Atnaujinti">
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<div id="target3" class="text-center"></div>
				</td>
			</tr>
		</table>							
	</form>
<?php } ?>