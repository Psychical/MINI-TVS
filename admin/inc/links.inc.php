<?php if(MAIN_ADMIN): ?>

	<?php
	if(isset($_GET['del'])):
		$mysqli->query("DELETE FROM `unban_links` WHERE `id` = '".((int)$_GET['del'])."'");
		header("Location: ./?action=links");
	endif;

	if(isset($_POST['submit']))
	{
		foreach ($_POST as $key => $value) {
			$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
		}
		
		$url = $_POST['url'];
		$name = $_POST['name'];
		$show = $_POST['show'];
		$lang = $_POST['lang'];
		$sort_place = $_POST['sort_place'];
		$show_number = $_POST['show_number'];
		
		if(empty($lang)) { $error = "Nepasirinkote kalbos!<br />"; }
		else if(empty($name)) { $error = "Neįrašėte pavadinimo!<br />"; }
		else if(empty($url)) { $error = "Neįrašėte URL!<br />"; }
		else
		{
			$mysqli->query("INSERT INTO `unban_links` VALUES ('', '".$url."', '".$name."', '".$show."', '".$lang."', '".$sort_place."', '".$show_number."')");
			unset($_POST);
			header("Location: ./?action=links");
		}
	}

	?>
	<?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>
	<div class="row">
		<div class="col-md-5">
			<form method="POST">
				<div class="form-group">
					<label for="exampleInputEmail1">KALBA</label>
					<select class="form-control" name="lang">
						<option value="0">NEPASIRINKTA</option>
							<option value="*" <?php if($_POST['lang'] == "*") echo "selected"; ?>>VISOMS KALBOMS</option>
							<?php while($rfl = $fl->fetch_object()): ?>
								<option value="<?php echo $rfl->prefix; ?>" <?php if($_POST['lang'] == $rfl->prefix) echo "selected"; ?>><?php echo strtoupper($rfl->prefix); ?></option>
							<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">PAVADINIMAS</label>
					<input type="text" class="form-control" name="name" value="<?php echo $_POST['name']; ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">ADRESAS</label>
					<input type="text" class="form-control" name="url" value="<?php echo $_POST['url']; ?>">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">RODYTI SKAIČIŲ</label>
					<select class="form-control" name="show_number">
						<option value="0">Ne</option>
						<option value="1" <?php if($_POST['show_number']) echo "selected"; ?>>Taip</option>
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">RODYTI NUORODĄ</label>
					<select class="form-control" name="show">
						<option value="0">Ne</option>
						<option value="1" <?php if($_POST['show']) echo "selected"; ?>>Taip</option>
					</select>
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">VIETA SĄRAŠE</label>
					<input type="number" class="form-control" name="sort_place" value="0" min=0>
				</div>
				
				<div class="form-group">
					<input type="submit" name="submit" value="PRIDĖTI" class="btn btn-success" style="width: 100%;">
				</div>
			</form>
		</div>
		<div class="col-md-7">
			<small>
				<ul>
					<b>PAPILDOMOS NUORODOS:</b>
					<li><b>./index.php?p=list</b> - Žaidėjų sąrašas
					<li><b>./index.php?p=back</b> - Privilegijų susigrąžinimas
					<li><b>./index.php?p=servers</b> - Serverių sąrašas
				</ul>
			</small>
			<table class="table table-condensed table-striped">
				<thead>
					<th>#</th>
					<th>Kalba</th>
					<th>Pavadinimas</th>
					<th>Adresas</th>
					<th>Statusas</th>
					<th>Vieta</th>
					<th></th>
				</thead>
			
			<?php
				$sms_c = $mysqli->query("SELECT * FROM `unban_links` ORDER BY `lang`, `sort_place`");
				while($row = $sms_c->fetch_object()):
					$status = $row->show ? "Rodomas" : "Nerodomas"; ?>
					<tr>
						<td><?php echo $i++; ?></td>
						<td><?php if(strlen($row->lang) > 1): ?><img src='../img/flags/<?php echo $row->lang; ?>.gif' class="media"> <?php endif; ?> <?php echo $row->lang; ?></td>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->url; ?></td>
						<td><?php echo $status; ?></td>
						<td><?php echo $row->sort_place; ?></td>
						<td><a href="?action=links&del=<?php echo $row->id; ?>"><img src='../img/x.png' border='0' class='deleteitem'></td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
	</div>
<?php endif; ?>