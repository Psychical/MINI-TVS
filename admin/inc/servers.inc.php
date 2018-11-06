<?php if(MAIN_ADMIN): ?>

<?php
include "rcon_hl_net.php";

if(isset($_GET['del'])):
	$mysqli->query("DELETE FROM `unban_servers` WHERE `id` = '".((int)$_GET['del'])."'");
	header("Location: ./?action=servers");
endif;

if(isset($_POST['submit']) || isset($_POST['submit_x'])):
	foreach($_POST as $key => $value):
		$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
	endforeach;
	
	$ip = $_POST['ip'];
	$port = $_POST['port'];
	$rcon = $_POST['rcon'];
	
	if(empty($ip)):
		$error = "Neįrašėte serverio IP adreso!";
	elseif(empty($port)):
		$error = "Neįrašėte port'o!";
	//elseif(empty($rcon)):
		//$error = "Neįrašėte RCON slaptažodžio!";
	else:
		if(isset($_POST['id'])):
			$mysqli->query("UPDATE `unban_servers` SET `ip` = '".$ip."', `port` = '".$port."' WHERE `id` = '".$_POST['id']."'");
	
			if(!empty($rcon)):
				$mysqli->query("UPDATE `unban_servers` SET `rcon` = '".$rcon."' WHERE `id` = '".$_POST['id']."'");
			endif;
			
			header("Location: ./?action=servers");
		else:
			$tikr = $mysqli->query("SELECT * FROM `unban_servers` WHERE `ip` = '".$ip."' AND `port` = '".$port."'");
			
			if($tikr->num_rows):
				$error = "Toks serveris jau egzistuoja!";
			else:
				$mysqli->query("INSERT INTO `unban_servers` VALUES ('', '".$ip."', '".$port."', '".$rcon."')");
			
				header("Location: ./?action=servers");
			endif;
		endif;
	endif;
endif;
?>

	<?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>
	<div class="row">
		<div class="col-md-4">
			<form method="POST">
				<div class="form-group">
					<label>IP ADRESAS</label>
					<input type="text" class="form-control" name="ip" value="">
				</div>
				<div class="form-group">
					<label>PORTAS</label>
					<input type="text" class="form-control" name="port" value="">
				</div>
				
				<div class="form-group">
					<label>RCON</label>
					<input type="text" class="form-control" name="rcon" value="">
				</div>
				<input type="submit" name="submit" value="Pridėti" class="btn btn-success" style="width: 100%;">
			</form>
		</div>
		<div class="col-md-8">
			<table class="table servers-list">
			<thead>
				<th>#</th>
				<th>SERVERIO IP</th>
				<th>SERVERIO PORTAS</th>
				<th>RCON SLAPTAŽODIS</th>
				<th></th>
				<th></th>
			</thead>

			<?php
			$server_list = $mysqli->query("SELECT * FROM `unban_servers`");
			
			while($row = $server_list->fetch_object()):
			?>
				<tr>
					<td style="vertical-align: middle;">
						<?php echo $i++; ?>
					</td>
					<form method="POST">
						<td>
							<input type="hidden" name="id" value="<?php echo $row->id; ?>">
							<input type="text" class="form-control" name="ip" value="<?php echo $row->ip; ?>">
						</td>
						<td>
							<input type="text" class="form-control" name="port" value="<?php echo $row->port; ?>">
						</td>
						<td>
							<input type="text" class="form-control" name="rcon" placeholder="(paslėptas)">
						</td>
						<td style="vertical-align: middle;">
							<input type="image" src="../img/v.png" title="ATNAUJINTI" name="submit" />
							<a href="./?action=servers&del=<?php echo $row->id; ?>">
								<img src="../img/x.png" border="0" title="IŠTRINTI" class="delete">
							</a>
						</td>
					</form> 
				</tr>
			<?php endwhile ?>
			
			</table>
		</div>
	</div>
		

	
<?php endif; ?>