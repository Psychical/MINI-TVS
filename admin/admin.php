<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<?php include('../config/db_connect.php'); $conn_f = false; $error = ""; ?>
		<title>Administracijos panelė</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
		<script src="jquery.form.js"></script>
		<script src="../jquery.cookie.js"></script>
		<script src="admin.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="./default.css" media="screen" />
	</head>
	<body>
<?php
if($web_admin_name == "admin" && $web_admin_pass == "admin")
{
	$error = "Nepakeistas $web_admin_pass parametras db_connect.php faile.";
}

if(($_POST['submit'] || isset($_COOKIE["unban_loged"])) && !$error)
{
	if((empty($_POST['name']) || empty($_POST['pass'])) && !isset($_COOKIE["unban_loged"]))
	{
		$error = 'Neįrašėte prisijungimo vardo arba slaptažodžio.';
	}	
	else if(($web_admin_name != $_POST['name'] || $web_admin_pass != $_POST['pass']) && !isset($_COOKIE["unban_loged"]))
	{
		$error = 'Netinkamas vartotojo vardas arba slaptažodis.';
	}
	else if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])) && isset($_COOKIE["unban_loged"]))
	{
		?> <script>
			$(function(){ 
				$.cookie('unban_loged', null, { expires: false, path: '/' });
				$.cookie('unban_loged_ids', null, { expires: false, path: '/' });
			});
			</script>
		<?php
		echo '<meta http-equiv="refresh" content="0;url=admin.php">';
	}
	else if($web_admin_name == $_POST['name'] && $web_admin_pass == $_POST['pass'] && !isset($_COOKIE["unban_loged"]) && !isset($_COOKIE["unban_loged_ids"]))
	{
		?> <script>
			$(function(){ 
				$.cookie('unban_loged', '1', { expires: false, path: '/' });
				$.cookie('unban_loged_ids', '<?php echo md5($web_admin_name.$web_admin_pass.$_SERVER['HTTP_REMOTE']); ?>', { expires: false, path: '/' });
			});
			</script>
		<?php
		$mysqli->query("INSERT INTO `unban_log_login` (`date`, `ip`, `name`) VALUES ('".date("Y-m-d H:i:s")."', '".$_SERVER['REMOTE_ADDR']."', '".$web_admin_name."')");
		
		echo '<meta http-equiv="refresh" content="0;url=admin.php">';
	}
	else 
	{
		include('inc/default.inc.php');
		$conn_f = true;
	}
}

if(!$conn_f)
{?>
	<div class="panel panel-default" style="width: 400px; margin: 0 auto; margin-top: 10px; text-align: center;">
		<div class="panel-heading"><b>Prisijungimas</b></div>
		<div class="panel-body">
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
				<input type="text" class="form-control" name="name" placeholder="Vartotojo vardas" /><br />
				<input type="password" class="form-control" name="pass" placeholder="Slaptazodis" /><br />
				<input type="submit" class="btn btn-default" name="submit" value="Prisijungti" />
			</form>
			<?php if($error): ?>
				<br>
				<div class="alert alert-danger"><?php echo $error; ?></div>
			<?php endif; ?>
		</div>
		<div class="panel-footer"><small>2011-<?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small></div>
	</div>
<?php } ?>
</body>
</html>
<?php
$mysqli->close();
?>