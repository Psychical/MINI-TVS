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
	
	$name = $_POST['name'];
	$priv = $_POST['priv'];
	
	if(empty($name)) { echo "Neįrašėte pavadinimo!<br />"; }
	else if(empty($priv)) { echo "Neįrašėte privilegijų!<br />"; }
	else
	{
		$tikr = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `priv` = '$priv'");
		if($tikr->num_rows) die("<font color='red'>^ios privilegijos jau pridėtos!</font>");
		
		$mysqli->query("INSERT INTO `unban_order_prvilegies` VALUES ('', '$priv', '$name')");
		die("<font color='green'>Privilegijos sėkmingai pridėta!</font><br />");
	}
}
?>