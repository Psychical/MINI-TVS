<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include('../../config/db_connect.php');

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

if($_POST['submit'])
{
	foreach ($_POST as $key => $value) {
		$_POST[$key] = addslashes($_POST[$key]);
	}
	
	$priv = $_POST['priv'];
	$price = $_POST['price'];
	$time = $_POST['time'];
	
	if(empty($priv)) { echo "Neįrašėte prefix!<br />"; }
	else if(empty($price)) { echo "Neįrašėte privilegijų kainos!<br />"; }
	else if(empty($time)) { echo "Neįrašėte privilegijų laiko!<br />"; }
	else
	{
		$result = $mysqli->query("SELECT * FROM `unban_makro_types` WHERE `priv_type` = '".$priv."' AND `price` = '".$price."'");
		if($result->num_rows)
		{
			die("<font color='red'>Toks makro mokėjimas jau egzistuoja!</font><br />");
		}
		else if(!$result->num_rows)
		{
			$mysqli->query("INSERT INTO `unban_makro_types` VALUES ('', '$priv', '$price', '$time')");
			
			die("<font color='green'>Žinutės tipas sėkmingai pridėtas!</font><br />");
		}
	}
}
?>