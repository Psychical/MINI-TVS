<?php if(MAIN_ADMIN): ?>

<?php
if(isset($_GET['del'])):
	$mysqli->query("DELETE FROM `unban_sms_config` WHERE `id` = '".((int)$_GET['del'])."'");
	header("Location: ./?action=keys");
endif;

if(isset($_POST['submit'])):
	foreach ($_POST as $key => $value) {
		$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
	}
	
	$prefix = $_POST['prefix'];
	$key = $_POST['key'];
	$number = $_POST['number'];
	$price = $_POST['price'];
	$sms_type = $_POST['sms_type'];
	$price_type = strtoupper($_POST['price_type']);
	$message_type = strtolower($_POST['message_type']);
	$priv_time = $_POST['priv_time'];
	$privs = $_POST['priv'] ? $_POST['priv'] : "unban";
	
	if(empty($prefix)):
		$error = "Neįrašėte prefix!<br />"; 
	elseif(empty($key)):
		$error = "Neįrašėte raktazodzio!<br />"; 
	elseif(empty($price)):
		$error = "Neįrašėte kainos!<br />"; 
	elseif(empty($number)):
		$error = "Neįrašėte sms numerio!<br />"; 
	elseif(empty($sms_type) && $sms_type != '0'):
		$error = "Neįrašėte sms sistemos tipo!<br />"; 
	elseif(empty($price_type)):
		$error = "Neįrašėte valiutos!<br />"; 
	elseif(empty($message_type)):
		$error = "Neįrašėte žinutės tipas!<br />"; 
	elseif(empty($priv_time) && $message_type != "unban"):
		$error = "Neįrašėte privilegiju trukmės!<br />"; 
	elseif(empty($privs) && $message_type != "unban"):
		$error = "Neįrašėte privilegijų!<br />"; 
	else:
		$result = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `key` = '$key' AND `lang` = '$prefix' AND `message_type` = '$message_type'");
		if($result->num_rows):
			$error = "<font color='red'>Šis raktažodis jau egzistuoja!</font><br />";
		elseif(!$result->num_rows):
			$mysqli->query("INSERT INTO `unban_sms_config` VALUES ('', '$prefix', '$key', '$number', '$price', '$sms_type', '$price_type', '$message_type', '$priv_time', '$privs')");
			
			if($message_type != "unban"):
				$tikr = $mysqli->query("SELECT * FROM `unban_links` WHERE `lang` = '".$prefix."' AND `url` LIKE '%".$message_type."'");
				
				if(!$tikr->num_rows):
					$mysqli->query("INSERT INTO `unban_links` (`url`, `name`, `show`, `lang`, `sort_place`) VALUES ('./index.php?p=o".$message_type."', '".strtoupper($message_type)." pirkimas', '1', '$prefix', '9')");
				endif;
			endif;
			
			header("Location: ./?action=keys");
		endif;
	endif;
endif; ?>

	<?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>
	<div class="row">
		<div class="col-md-4">
			<form method="POST">
				<div class="form-group">
					<label>ŠALIS</label>
					<select class="form-control" name="prefix">
						<?php while($rfl = $fl->fetch_object()): ?>
							<option value="<?php echo $rfl->prefix; ?>"><?php echo strtoupper($rfl->prefix); ?></option>
						<?php endwhile ?>
					</select>
				</div>
				
				<div class="form-group">
					<label>RAKTAŽODIS</label>
					<input type="text" class="form-control" name="key" value="">
				</div>
				
				<div class="form-group">
					<label>SMS NUMERIS</label>
					<input type="text" class="form-control" name="number" value="">
				</div>
				
				<div class="form-group">
					<label>SMS KAINA <small>(centais)</small></label>
					<input type="text" class="form-control" name="price" value="">
				</div>
				
				<div class="form-group">
					<label>SMS SISTEMA</label>
					<select class="form-control" name="sms_type">
						<option value="0"<?php echo !$sistema ? " selected" : ""; ?>>PaySera</option>
						<option value="1"<?php echo $sistema ? " selected" : ""; ?>>VPSNet</option>
					</select>
				</div>
				
				<div class="form-group">
					<label>KAINOS PREFIKSAS</label>
					<input type="text" class="form-control" name="price_type" value="EUR">
				</div>
				
				<div class="form-group">
					<label>PASLAUGOS TIPAS</label>
					<select class="form-control" name="message_type">
						<option value="unban">UNBAN</option>
						<?php while($rmp = $mp->fetch_object()):
								if($rmp->type != "unban"): ?>
									<option value="<?php echo $rmp->type; ?>"><?php echo strtoupper($rmp->type); ?></option>
								<?php endif;
							endwhile; ?>
					</select>
				</div>
				
				<div id='unban_no1'>
					<div class="form-group">
						<label>PRIVILEGIJOS</label>
						<select class="form-control" name="priv">
							<?php while($rpriv = $priv->fetch_object()):
									if($rpriv->priv != "unban"): ?>
										<option value="<?php echo $rpriv->priv; ?>"><?php echo strtoupper($rpriv->name); ?> (<?php echo $rpriv->priv; ?>)</option>
									<?php endif;
								endwhile; ?>
						</select>
					</div>
				</div>
				
				<div id='unban_no2'>
					<div class="form-group">
						<label>PRIVILEGIJŲ TRUKMĖ <small>(dienomis)</small></label>
						<input type="text" class="form-control" name="priv_time" value="">
					</div>
				</div>
				
				<div class="form-group">
					<input type="submit" name="submit" value="PRIDĖTI" class="btn btn-success" style="width: 100%;">
				</div>
			</form>
		</div>
		<div class="col-md-8">
			<table class="table table-condenser">
				<thead>
					<th>KALBA</th>
					<th>RAKTAŽODIS</th>
					<th>NUMERIS</th>
					<th>KAINA</th>
					<th>TIPAS</th>
					<th>VALIUTA</th>
					<th>ŽINUTĖS TIPAS</th>
					<th></th>
				</thead>

				<?php
				$sms_c = $mysqli->query("SELECT * FROM `unban_sms_config`"); $i = 1;
				while($row = $sms_c->fetch_object()):
					$sms_type = $row->sms_type ? "VPSNet" : "PaySera"; ?>
					<tr>
						<td><?php echo strtoupper($row->lang); ?> <img src='../img/flags/<?php echo $row->lang; ?>.gif' border='0'></td>
						<td><?php echo $row->key; ?></td>
						<td><?php echo $row->number; ?></td>
						<td><?php echo $row->price; ?></td>
						<td><?php echo $sms_type; ?></td>
						<td><?php echo $row->price_type; ?></td>
						<td><?php echo strtoupper($row->message_type); ?></td>
						<td><a href="./?action=keys&del=<?php echo $row->id; ?>"><img src='../img/x.png' border='0' class='deleteitem'></a></td>
					</tr>
				<?php endwhile ?>
			</table>
		</div>
	</div>
<?php endif; ?>