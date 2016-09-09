<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");
	
include('../../config/db_connect.php');
include "rcon_hl_net.php";

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

$id = $mysqli->real_escape_string($_POST['id']);
$ip = $mysqli->real_escape_string($_POST['ip']);
$port = $mysqli->real_escape_string($_POST['port']);
$rcon = $mysqli->real_escape_string($_POST['rcon']);

if(empty($ip)) die("<font color='red'>Neįrašytas IP adresas!<br /><br /></font>");
else if(empty($port)) die("<font color='red'>Neįrašytas PORT'as!<br /><br /></font>");
else if(empty($rcon)) die("<font color='red'>Neįrašytas RCON slaptažodis!<br /><br /></font>");
	
$result = $mysqli->query("SELECT * FROM `unban_servers` WHERE `id` = '".$id."'");

if($result->num_rows)
{
	$mysqli->query("UPDATE `unban_servers` SET `ip` = '$ip', `port` = '$port' WHERE `id` = '".$id."'");
	
	if($rcon != "(paslėptas)")
		$mysqli->query("UPDATE `unban_servers` SET `rcon` = '$rcon' WHERE `id` = '".$id."'");
	
	echo "<font color='green'>Šis serveris atnaujintas<br /><br /></font>";
}
?>