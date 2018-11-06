<?php if(MAIN_ADMIN): ?>

<?php
if(isset($_GET['del'])):
	$mysqli->query("DELETE FROM `unban_flags` WHERE `id` = '".((int)$_GET['del'])."'");
	header("Location: ./?action=flags");
endif;

if(isset($_POST['submit']))
{
	$prefix = $mysqli->real_escape_string($_POST['prefix']);
	
	$result = $mysqli->query("SELECT * FROM `unban_flags` WHERE `prefix` = '".$prefix."'");
	if(!$result->num_rows && !empty($prefix)):
		$mysqli->query("REPLACE INTO `unban_flags`(`prefix`) VALUES ('".$prefix."')");
		header("Location: ./?action=flags");
	endif;
}
?>
	<div class="row">
		<div class="col-md-3">
			<form method="POST">
				<div class="form-group">
					<label>Pridėti šalį [<a href = 'http://lt.wikipedia.org/wiki/S%C4%85ra%C5%A1as:%C5%A0ali%C5%B3_s%C4%85ra%C5%A1as' target='_blank'>ISO Kodai</a>]</label>
					<input class="form-control" type="text" name="prefix" placeholder="Šalies ISO kodas">
				</div>
				<div class="form-group">
					<input type="submit" name="submit" value="Pridėti" class="btn btn-success" style="width: 100%;">
				</div>
			</form>
		</div>
		<div class="col-md-9">
			<div class="row">
				<div class="col-md-12">
					<h4>ESAMOS ŠALYS (Norint ištrinti, spausti ant vėliavėlės)</h4>
				</div>
			</div>
			<div class="row">
				<?php while($row = $fl->fetch_object()): ?>

				<div class="col-md-2">
					<a href="./?action=flags&del=<?php echo $row->id; ?>">
						<img src='../img/flags/<?php echo $row->prefix; ?>.gif' class="media"> - <?php echo strtoupper($row->prefix); ?>
					</a>
				</div>
				<?php if(!(++$i % 6)): ?>
					</div> <div class="row">
				<?php endif; 
				endwhile; ?>
			</div>
		</div>
	</div>
<?php endif; ?>