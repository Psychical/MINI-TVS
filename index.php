<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
		
		$s = addslashes($_COOKIE["lang"]) ? addslashes($_COOKIE["lang"]) : $main_lang;
		
		$f_page = 1;
		$p = $_GET['p'];
	?>
	<title><?php echo $web_title; ?></title>
</head>
<body style="margin-top: 15px;">
	<div class="row">
		<div class="col-md-0 col-lg-3"></div>
		<div class="col-md-4 col-lg-2">
			<div class="panel panel-default">
				<div class="panel-heading">
				<b>Navigacija</b>
				</div>
				<div class="panel-body">
					<?php $menu_select = $mysqli->query("SELECT * FROM `unban_links` WHERE (`lang` = '".$s."' OR `lang` = '*') AND `show` = '1' ORDER BY `sort_place` ASC"); ?>
					<ul class="nav nav-pills nav-stacked" style="text-transform: uppercase;">
						<?php if(addslashes($_COOKIE["unban_loged"])): ?>
							<li role="presentation" class="active"><a href="admin/admin.php">Administravimas</a></li>
							<hr />
						<?php endif; ?>
						
						<?php while($msl = $menu_select->fetch_object()): ?>
							<li role="presentation"><a href="<?php echo $msl->url; ?>"><?php echo $msl->name; ?></a></li>
						<?php endwhile; ?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8 col-lg-4">
			<?php if($fl->num_rows > 1) : ?>
			<div class="panel panel-default countrys">
				<?php echo $unban['18']; while($row = $fl->fetch_object()): ?>
				<a href="#" onclick='window.location.reload(true); setCookie("lang", "<?php echo $row->prefix; ?>")'>
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
		<div class="col-md-0 col-lg-3"></div>
	</div>
	<div class="row">
		<div class="col-md-0 col-lg-3"></div>
		<div class="col-md-12 col-lg-6">
			<div class="panel panel-default footers text-center">
				<small>2011 - <?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small>
			</div>
		</div>
		<div class="col-md-0 col-lg-3"></div>
	</div>
	
</html>
<?php
$mysqli->close();
$mysqli_amx->close();
?>