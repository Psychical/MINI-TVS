<?php if(MAIN_ADMIN): ?>
<?php
if(isset($_GET['del'])):
	$mysqli->query("DELETE FROM `unban_makro_types` WHERE `id` = '".((int)$_GET['del'])."'");
	header("Location: ./?action=makro_types");
endif;

if(isset($_POST['submit'])):
	foreach($_POST as $key => $value):
		$_POST[$key] = addslashes($_POST[$key]);
	endforeach;
	
	$privs = $_POST['priv'];
	$price = $_POST['price'];
	$time = $_POST['time'];
	
	if(empty($privs)):
		$error = "Neįrašėte prefix!<br />";
	elseif(empty($price)):
		$error = "Neįrašėte privilegijų kainos!<br />";
	elseif(empty($time)):
		$error = "Neįrašėte privilegijų laiko!<br />";
	else:
		$result = $mysqli->query("SELECT * FROM `unban_makro_types` WHERE `priv_type` = '".$privs."' AND `price` = '".$price."'");
		
		if($result->num_rows):
			$error = "Toks makro mokėjimas jau egzistuoja!";
		else:
			$mysqli->query("INSERT INTO `unban_makro_types` VALUES ('', '".$privs."', '".$price."', '".$time."')");
			
			header("Location: ./?action=makro_types");
		endif;
	endif;
endif;
?>
	
	<?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>
	<div class="row">
		<div class="col-md-4">	
			<form method="POST">
				<div class="form-group">
					<label for="exampleInputEmail1">PRIVILEGIJOS</label>
					<select class="form-control" name="priv">
						<?php while($rfl = $priv->fetch_object()): ?>
							<option value="<?php echo $rfl->name; ?>"><?php echo strtoupper($rfl->name); ?> (<?php echo $rfl->priv; ?>)</option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label for="exampleInputEmail1">SMS KAINA (centais)</label>
					<input type="number" class="form-control" name="price" value="100">
				</div>
				
				<div class="form-group">
					<label for="exampleInputEmail1">PRIVILEGIJŲ TRUKMĖ (dienomis)</label>
					<input type="number" class="form-control" name="time" value="1" min="1">
				</div>
				
				<div class="form-group">
					<input type="submit" name="submit" class="btn btn-success" value="PRIDĖTI" style="width: 100%;">
				</div>
				
			</form>
		</div>
		<div class="col-md-8">
			<table class="table">
				<thead>
					<th>#</th>
					<th>PRIVILEGIJOS</th>
					<th class="text-center">KAINA</th>
					<th class="text-center">TRUKMĖ</th>
					<th></th>
				</thead>

				<?php while($row = $makro_l->fetch_object()): ?>
					<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo strtoupper($row->priv_type); ?></td>
					<td class="text-center"><?php echo $row->price/100; ?> EUR</td>
					<td class="text-center"><?php echo $row->lenght; ?> d.</td>
					<td>
						<a href="./?action=makro_types&del=<?php echo $row->id; ?>">
							<img src='../img/x.png'>
						</a>
					</td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
	</div>
<?php endif; ?>