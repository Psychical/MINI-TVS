<?php if(MAIN_ADMIN): ?>

	<?php
	if(isset($_GET['del'])):
		$mysqli->query("DELETE FROM `unban_order_prvilegies` WHERE `id` = '".((int)$_GET['del'])."'");
		header("Location: ./?action=priv_types");
	endif;

	if(isset($_POST['submit'])):
		foreach ($_POST as $key => $value):
			$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
		endforeach;
		
		$name = $_POST['name'];
		$priv = $_POST['priv'];
		
		if(empty($name)):
			$error = "Neįrašėte pavadinimo!";
		elseif(empty($priv)):
			$error = "Neįrašėte privilegijų!";
		else:
			$tikr = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `priv` = '".$priv."'");
			
			if($tikr->num_rows):
				$error = "<font color='red'>Šios privilegijos jau pridėtos!</font>";
			else:
				$mysqli->query("INSERT INTO `unban_order_prvilegies` (`priv`, `name`) VALUES ('".$priv."', '".$name."')");
			endif;
		endif;
	endif;
	?>
	
	<?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>
	<div class="row">
		<div class="col-md-4">
			<form method="POST">
				<div class="form-group">
					<label for="exampleInputEmail1">PRIVILEGIJŲ PAVADINIMAS (PVZ.: vip, admin)</label>
					<input type="text" class="form-control" name="name" value="">
				</div>
				
				<div class="form-group">
					<label for="exampleInputEmail1">PRIVILEGIJŲ FLAGAI (PVZ.: bt, bit)</label>
					<input type="text" class="form-control" name="priv" value="">
				</div>
				
				<div class="form-group">				
					<input type="submit" name="submit" class="btn btn-success" value="PRIDĖTI" style="width: 100%;">
				</div>
			</form>
		</div>
		<div class="col-md-8">	
			<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>PRIVILEGIJŲ PAVADINIMAS</th>
				<th>PRIVILEGIJOS</th>
				<th></th>
			</thead>

		<?php $sms_c = $mysqli->query("SELECT * FROM `unban_order_prvilegies`"); $i = 1;
			while($row = $sms_c->fetch_object()): ?>
				<tr>
					<td><?php echo $i++; ?></td>
					<td><?php echo $row->name; ?></td>
					<td><?php echo $row->priv; ?></td>
					<td>
						<a href="./?action=priv_types&del=<?php echo $row->id; ?>">
							<img src="../img/x.png">
						</a>
					</td>
				</tr>
			<?php endwhile; ?> 
			</table>
		</div>
	</div>
<?php endif; ?>