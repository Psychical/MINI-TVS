<?php
if(isset($_COOKIE["unban_loged"]))
{
	if($version < file_get_contents('http://rez.lt/unban/version.txt'))
		$panel_status = "panel panel-danger";
	else if($version > file_get_contents('http://rez.lt/unban/version.txt'))
		$panel_status = "panel panel-warning";
	else
		$panel_status = "panel panel-success";
?>
<div class="<?php echo $panel_status; ?>" style="width: 800px; margin: 0 auto; margin-top: 10px;">
	<div class="panel-heading">
		<div class="text-left" style="float: left;">
			Jūs prisijungęs kaip: <b><?php echo $web_admin_name; ?></b>
		</div>
		<div class="text-right" style="float: right;">
			<a href="./admin.php" class="navigation">Pagrindinis admin</a> | <a href="../" target="_blank" class="navigation">Peržiūrėti puslapį</a> | <a href="./logout.php" id="logout" class="navigation">Atsijungti</a>
		</div>
		<div style="clear: both;"></div>
	</div>
	<div class="panel-body">
	<?php
		$act = $_GET['action'];
		switch($act)
		{
			case 'flags': { include('inc/flags.inc.php'); break; }
			case 'keys': { include('inc/keys.inc.php'); break; }
			case 'settings': { include('inc/settings.inc.php'); break; }
			case 'links': { include('inc/links.inc.php'); break; }
			case 'message_types': { include('inc/message_types.inc.php'); break; }
			case 'priv_types': { include('inc/priv_types.inc.php'); break; }
			case 'servers': { include('inc/servers.inc.php'); break; }
			case 'makro_types': { include('inc/makro_types.inc.php'); break; }
			default: { include('inc/action.default.inc.php'); break; }
		}					
	?>
	</div>
	<div class="panel-footer">
		<small>2011-<?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small>
	</div>
</div>
<div style="height: 10px;"></div>

<?php } ?>