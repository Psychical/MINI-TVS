<?php 
if(!isset($_COOKIE["unban_loged"]))
	die("Eik iš čia...");

include('../../config/db_connect.php');

if((md5($web_admin_name.$web_admin_pass.$_SERVER["HTTP_REMOTE"]) != addslashes($_COOKIE["unban_loged_ids"])))
	die("Eik iš čia...");

if($_POST['submit'])
{
	foreach ($_POST as $key => $value)
	{
		$_POST[$key] = $mysqli->real_escape_string($_POST[$key]);
		
		$result = $mysqli->query("SELECT * FROM `unban_config` WHERE `id` = '".$key."'");
		if($result->num_rows)
		{
			$mysqli->query("UPDATE `unban_config` SET `value` = '".$value."' WHERE `id` = '".$key."'");
		}
	}
	
	echo "<font color='green'>Nustatymai sėkmingai atnaujinti.</font>";
}
?>