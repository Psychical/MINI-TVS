<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include('../../config/db_connect.php');

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

if($_POST['submit'])
{
	$prefix = $mysqli->real_escape_string($_POST['prefix']);
	
	if(empty($prefix) || $prefix == "Šalies ISO kodas") { echo "Neįrašėte prefix!<br />"; }
	else
	{
		$result = $mysqli->query("SELECT * FROM `unban_flags` WHERE `prefix` = '$prefix'");
		if($result->num_rows)
		{
			echo "<font color='red'>Šis prefix'as jau pridėtas!</font><br />";
			die();
		}
		else if(!$result->num_rows)
		{		
			$mysqli->query("INSERT INTO `unban_flags`(prefix) VALUES ('$prefix')");
			echo "<font color='green'>Serveris sėkmingai pridėtas!</font><br />";
			die();
		}
	}
}
?>