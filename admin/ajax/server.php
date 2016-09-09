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
	
	$ip = $_POST['ip'];
	$port = $_POST['port'];
	$rcon = $_POST['rcon'];
	
	if(empty($ip)) { echo "<center><font color='red'>Neįrašėte serverio IP adreso!</font></center><br />"; }
	else if(empty($port)) { echo "<center><font color='red'>Neįrašėte port'o!</font></center><br />"; }
	else if(empty($rcon)) { echo "<center><font color='red'>Neįrašėte RCON slaptažodžio!</font></center><br />"; }
	else
	{
		$tikr = $mysqli->query("SELECT * FROM `unban_servers` WHERE `ip` = '$ip' AND `port` = '$port'");
		if($tikr->num_rows) die("<center><font color='red'>Šios privilegijos jau pridėtos!</font></center>");
		
		$mysqli->query("INSERT INTO `unban_servers` VALUES ('', '$ip', '$port', '$rcon')");
		echo "<center><font color='green'>Privilegijos sėkmingai pridėta!</font></center><br />";
		die();
	}
}
?>