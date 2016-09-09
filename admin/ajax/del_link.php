<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include('../../config/db_connect.php');

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

$id = $mysqli->real_escape_string($_POST['id']);
	
$result = $mysqli->query("SELECT * FROM `unban_links` WHERE `id` = '".$id."'");

if($result->num_rows)
	$mysqli->query("DELETE FROM `unban_links` WHERE `id` = '".$id."'");
?>