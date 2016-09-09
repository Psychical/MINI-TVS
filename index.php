<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen" />
	<script src="cookies.js"></script>
	<?php
		include 'config/db_connect.php';
		
		if(file_exists('lang/'.addslashes($_COOKIE["lang"]).'.php'))
			include 'lang/'.addslashes($_COOKIE["lang"]).'.php';
		else
		{
			echo "<script> $.cookie('lang', ".$main_lang.", { expires: false, path: '/' }); </script>";
			include 'lang/'.$main_lang.'.php';
		}
		
		$f_page = 1;
		$p = $_GET['p'];
	?>
	<title><?php echo $web_title; ?></title>
</head>
<body>
	<div class="main">
		<div class="left">
			<div class="panel panel-default">
				<div class="panel-heading">
				<b>Navigacija</b>
				</div>
				<div class="panel-body">
					<?php if(addslashes($_COOKIE["unban_loged"])) : ?>
					<a href="admin/admin.php" style="color: red;">Administravimas</a>
					<hr />
					<?php endif;
					$s = addslashes($_COOKIE["lang"]) ? addslashes($_COOKIE["lang"]) : $main_lang;
					$menu_select = $mysqli->query("SELECT * FROM `unban_links` WHERE `lang` = '".$s."' ORDER BY `sort_place` ASC");
					while($msl = $menu_select->fetch_object()) {
						if($msl->show) {
							echo $i.'. <a href="'.$msl->url.'">'.$msl->name.'</a><br />';
							$i++;
						}
					}
					?>	
				</div>
			</div>
		</div>
		<div class="right">
			<?php if($fl->num_rows > 1) : ?>
			<div class="panel panel-default countrys">
				<?php echo $unban['18']; while($row = $fl->fetch_object()): ?>
				<a href='./index.php' onclick='setCookie("lang", "<?php echo $row->prefix; ?>")'>
					<img src='img/flags/<?php echo $row->prefix; ?>.gif' border='0'>
				</a>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>
			<div class="panel panel-default content <?php if($fl->num_rows > 1) : ?> margin <?php endif; ?>">
				<?php 
					switch($p[0])
					{
						case 'l': include('includes/olist.php'); break;
						case 'o': include('includes/order.php'); break;
						default: include('includes/main.php'); break;
					}
				?>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div class="panel panel-default footers text-center">
			<small>2011-<?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small>
		</div>
	</div>
</html>
<?php
$mysqli->close();
$mysqli_amx->close();
?>