<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include('../../config/db_connect.php');

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

if($_POST['submit'])
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
	
	if(empty($lang)) { echo "Nepasirinkote šalies!<br />"; }
	else if(empty($url)) { echo "Neįrašėte URL!<br />"; }
	else if(empty($name)) { echo "Neįrašėte pavadinimo!<br />"; }
	else if(empty($lang)) { echo "Neįrašėte šalies!<br />"; }
	else
	{
		$mysqli->query("SET NAMES 'utf8'");
		$mysqli->query("INSERT INTO `unban_links` VALUES ('', '$url', '$name', '$show', '$lang', '$sort_place', '$show_number')");
		echo "<font color='green'>Nuoroda sėkmingai pridėta!</font><br />";
		die();
	}
}
?>