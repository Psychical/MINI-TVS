<?php 
$mysqli = new mysqli("localhost", "root", "password", "amxbans");

$mysqli->query("DELETE FROM `amx_amxadmins` WHERE `expired` < '".time()."' AND `days` != '0'");
$mysqli->query("DELETE FROM `amx_admins_servers` WHERE `admin_id` NOT IN (SELECT a.id FROM `amx_amxadmins` a)");
?>