<?php if(MAIN_ADMIN): ?>
<?php
	$id = (int) $_GET['id'];

	if(isset($_GET['del'])):
		$mysqli->query("DELETE FROM `unban_messages_types` WHERE `id` = '".((int)$_GET['del'])."'");
		header("Location: ./?action=message_types");
	endif;
	
	if(isset($_POST['submit'])):
		foreach($_POST as $key => $value):
			$_POST[$key] = addslashes($_POST[$key]);
		endforeach;
		
		$id = (int) addslashes($_POST['id']);
		$prefix = $_POST['prefix'];
		$type = $_POST['type'];
		$page_content = $_POST['page_content'];
		
		if(empty($prefix)):
			$error = "Neįrašėte prefix!<br />";
		elseif(empty($type)):
			$error = "Neįrašėte žinutės tipo!<br />";
		elseif(empty($page_content)):
			$error = "Neįrašėte puslapio turinio!<br />";
		else:
			$result = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `id` = '".$id."'");
			
			if($result->num_rows):
				$page_content = str_replace(array("\\n", "\n"), array("<br />", "<br />"), $page_content);
				
				$mysqli->query("UPDATE `unban_messages_types` SET `lang` = '".$prefix."', `type` = '".$type."', `page_content` = '".$page_content."' WHERE `id` = '".$id."'");
				header("Location: ./?action=message_types");
			else:
				$page_content = str_replace(array("\\n", "\n"), array("<br />", "<br />"), $page_content);
				
				$mysqli->query("INSERT INTO `unban_messages_types` (`type`, `page_content`, `lang`) VALUES ('".$type."', '".$page_content."', '".$prefix."')");
				header("Location: ./?action=message_types");
			endif;
		endif;
	endif;
	
	
	if($id):
		$result_type = $mysqli->query("SELECT * FROM `unban_messages_types` WHERE `id` = '".$id."'");
		
		$typeFtc = $result_type->fetch_object();
		
		$type = $typeFtc->type ? $typeFtc->type : "";
		$page_content = $typeFtc->page_content ? $typeFtc->page_content : "";
		$lang = $typeFtc->lang ? $typeFtc->lang : "";
		
		$page_content = str_replace("<br />", "\n", $page_content);
	endif;
	
	function select($f, $s) { if($f == $s) return "selected"; return ""; }
	?>
	<script src='bbeditor/jquery.bbcode.js' type='text/javascript'></script>
	<script type="text/javascript"> $(document).ready(function(){ $("#page_content").bbcode(); }); </script>
	
	<?php if($error): ?><div class="alert alert-danger"><?php echo $error; ?></div> <?php endif; ?>
	<div class="row">
		<div class="col-md-6">	
			<table class="table">
				<thead>
					<th>#</th>
					<th>ŠALIS</th>
					<th>PRIVILEGIJOS</th>
					<th></th>
				</thead>

				<?php
				$sms_c = $mysqli->query("SELECT * FROM `unban_messages_types`"); $i = 1;
				while($row = $sms_c->fetch_object()): ?>
				
					<tr class="<?php echo ($id == $row->id) ? "info" : ""; ?>">
						<td><?php echo $i++; ?></td>
						<td><?php echo strtoupper($row->lang); ?> <img src='../img/flags/<?php echo $row->lang; ?>.gif' border='0'></td>
						<td><?php echo $row->type; ?></td>
						<td>
							<a href='./?action=message_types&id=<?php echo $row->id; ?>'>
								<img src='../img/admin/icons/edit.png' border='0'>
							</a>
							<a href="./?action=message_types&del=<?php echo $row->id; ?>">
								<img src='../img/x.png'>
							</a>
						</td>
					</tr>
				<?php endwhile; ?>
			</table>
		</div>
		<div class="col-md-6">
			<form method="POST">
				<div class="form-group">
					<label>ŠALIS</label>
					<select class="form-control" name="prefix">
						<?php while($rfl = $fl->fetch_object()): ?>
							<option value="<?php echo $rfl->prefix; ?>" <?php echo select($rfl->prefix, $lang); ?>><?php echo strtoupper($rfl->prefix); ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label>PRIVILEGIJOS</label>
					<select class="form-control" name="type">
						<option value="unban" <?php echo select("unban", $type); ?>>UNBAN</option>
					
						<?php $sms_c = $mysqli->query("SELECT * FROM `unban_order_prvilegies`"); ?>
						<?php while($rfl = $sms_c->fetch_object()): ?>
							<option value="<?php echo $rfl->name; ?>" <?php echo select($rfl->name, $type); ?>><?php echo strtoupper($rfl->name); ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				
				<div class="form-group">
					<label>Pauslaugos tipas</label>
					<textarea id="page_content" name="page_content" class="form-control" style="min-height: 200px;"><?php echo $page_content; ?></textarea>
				</div>
				
				<font color='red'>PVZ.:</font> <font size='1'>Siuskite zinute su tekstu %key% %ip% numeriu %nr%. Kaina %time%d/%price% %price_type%<br /> Kai nusiusite SMS zinute iskart po atsakymo VIP bus automatiskai aktivuotas!</font>
				
				
				<div class="form-group">
					<?php if($id): ?>
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" class="btn btn-warning" value="ATNAUJINTI">
					<?php else: ?>
						<input type="submit" name="submit" class="btn btn-success" value="PRIDĖTI">
					<?php endif; ?>
				</div>
			</form>


		</div>
		
	</div>
	
<?php endif; ?>