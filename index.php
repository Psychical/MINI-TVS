<?php session_start();
include 'config/db_connect.php';

if($_GET['lang']):
	$_SESSION["lang"] = $_GET['lang'];
	header("Location: ./");
endif;

if(file_exists('lang/'.addslashes($_SESSION["lang"]).'.php')):
	include 'lang/'.addslashes($_SESSION["lang"]).'.php';
else:
	$_SESSION["lang"] = $main_lang;
	include 'lang/'.$main_lang.'.php';
endif;

$sLang = $_SESSION["lang"] ? $_SESSION["lang"] : $main_lang;

$f_page = 1;
$sPage = $_GET['p'];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/styles.css" media="screen" />

	<title><?php echo $web_title; ?></title>
</head>
<body style="margin-top: 15px;">
	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><b>NAVIGACIJA</b></div>
					<div class="panel-body">
						<?php $menu_select = $mysqli->query("SELECT * FROM `unban_links` WHERE (`lang` = '".$sLang."' OR `lang` = '*') AND `show` = '1' ORDER BY `sort_place` ASC");  ?>
						<ul class="nav nav-pills nav-stacked" style="text-transform: uppercase;">
							<?php if(addslashes($_SESSION["unban_loged"])): ?>
								<li role="presentation" class="active"><a href="./admin">Administravimas</a></li>
							<?php endif; ?>
							
							<?php while($msl = $menu_select->fetch_object()): ?>
								<li role="presentation"><a href="<?php echo $msl->url; ?>"><?php echo $msl->name; ?></a></li>
							<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<?php if($fl->num_rows): ?>
				<div class="panel panel-default countrys">
					<?php echo $unban['18']; while($row = $fl->fetch_object()): ?>
					<a href="./?lang=<?php echo $row->prefix; ?>">
						<img src='img/flags/<?php echo $row->prefix; ?>.gif' border='0'>
					</a>
					<?php endwhile; ?>
				</div>
				<?php endif; ?>
				<div class="panel panel-default content <?php if($fl->num_rows) : ?> margin <?php endif; ?>">
					<?php 
						switch($sPage[0])
						{
							case 's': include('includes/oserv.php'); break;
							case 'l': include('includes/olist.php'); break;
							case 'b': include('includes/oback.php'); break;
							case 'o': include('includes/order.php'); break;
							default: include('includes/main.php'); break;
						}
					?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default footers text-center">
					<small>2011 - <?php echo date("Y"); ?> &copy; <a href="http://www.amxmodx.lt/viewtopic.php?f=34&t=1035" target="_blank">Mini TVS</a></small>
				</div>
			</div>
		</div>
	</div>
</html>
<?php
$mysqli->close();
$mysqli_amx->close();
?>