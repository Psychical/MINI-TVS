<?php
session_start();
include('../config/db_connect.php');

$error = "";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		
		<title>Administracijos panelė</title>
		
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
		<script src="admin.js"></script>
		
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" media="screen" />
	</head>
	<body>
<?php
if($web_admin_name == "admin" && $web_admin_pass == "admin") {
	$error = "Nepakeistas $web_admin_pass parametras db_connect.php faile.";
}

if($_SESSION['unban_loged'] && ($_SESSION['unban_loged_ids'] == md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]))):
	define("MAIN_ADMIN", "TRUE");

	include('inc/navbar.nav.php');
	include('inc/default.inc.php');
else:
	if(isset($_POST['submit'])):
		if((empty($_POST['name']) || empty($_POST['pass']))):
			$error = 'Neįrašėte prisijungimo vardo arba slaptažodžio.';
		elseif($web_admin_name != $_POST['name'] || $web_admin_pass != $_POST['pass']):
			$error = 'Netinkamas prisijungimo vardo arba slaptažodžio.';
		elseif($web_admin_name == $_POST['name'] && $web_admin_pass == $_POST['pass']):
			$_SESSION['unban_loged'] = 1;
			$_SESSION['unban_loged_ids'] = md5($web_admin_name.$web_admin_pass.$_SERVER['HTTP_REMOTE']);
			
			$mysqli->query("INSERT INTO `unban_log_login` (`date`, `ip`, `name`) VALUES ('".date("Y-m-d H:i:s")."', '".$_SERVER['REMOTE_ADDR']."', '".$web_admin_name."')");
			header("Location: ./");
		endif;
	endif;
?>
<div class="container" style="margin-top: 30px;">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Prisijungimas</b></div>
				<div class="panel-body">
					<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
						<div class="form-group">
							<div class="input-group">
							 <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
								<input type="text" class="form-control" name="name" placeholder="Vartotojo vardas" />
							</div>
						</div>
						<div class="form-group">
							<div class="input-group">
							 <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
								<input type="password" class="form-control" name="pass" placeholder="Slaptazodis" />
							</div>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" name="submit" value="PRISIJUNGTI" style="width: 100%;" />
						</div>
					</form>
					<?php if($error): ?>
						<div class="alert alert-danger"><?php echo $error; ?></div>
					<?php endif; ?>
				</div>
				<div class="panel-footer"><small>2011-<?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small></div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
<?php endif; ?>
</body>
</html>
<?php
$mysqli->close();
?>