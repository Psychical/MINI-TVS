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
	
	$prefix = $_POST['prefix'];
	$key = $_POST['key'];
	$number = $_POST['number'];
	$price = $_POST['price'];
	$sms_type = $_POST['sms_type'];
	$price_type = strtoupper($_POST['price_type']);
	$message_type = strtolower($_POST['message_type']);
	$priv_time = $_POST['priv_time'];
	$priv = $_POST['priv'] ? $_POST['priv'] : "unban";
	
	if(empty($prefix)) { echo "Neįrašėte prefix!<br />"; }
	else if(empty($key)) { echo "Neįrašėte raktazodzio!<br />"; }
	else if(empty($price)) { echo "Neįrašėte kainos!<br />"; }
	else if(empty($number)) { echo "Neįrašėte sms numerio!<br />"; }
	else if(empty($sms_type) && $sms_type != '0') { echo "Neįrašėte sms sistemos tipo!<br />"; }
	else if(empty($price_type)) { echo "Neįrašėte valiutos!<br />"; }
	else if(empty($message_type)) { echo "Neįrašėte žinutės tipas!<br />"; }
	else if(empty($priv_time) && $message_type != "unban") { echo "Neįrašėte privilegiju trukmės!<br />"; }
	else if(empty($priv) && $message_type != "unban") { echo "Neįrašėte privilegijų!<br />"; }
	else
	{
		$result = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `key` = '$key' AND `lang` = '$prefix' AND `message_type` = '$message_type'");
		if($result->num_rows)
		{
			echo "<font color='red'>Šis raktažodis jau egzistuoja!</font><br />";
			die();
		}
		else if(!$result->num_rows)
		{		
			$mysqli->query("INSERT INTO `unban_sms_config` VALUES ('', '$prefix', '$key', '$number', '$price', '$sms_type', '$price_type', '$message_type', '$priv_time', '$priv')");
			
			if($message_type != "unban")
			{
				$tikr = $mysqli->query("SELECT * FROM `unban_links` WHERE `lang` = '".$prefix."' AND `url` LIKE '%".$message_type."'");
				
				if(!$tikr->num_rows) {
					$mysqli->query("INSERT INTO `unban_links` (`url`, `name`, `show`, `lang`, `sort_place`) VALUES ('./index.php?p=o".$message_type."', '".strtoupper($message_type)." pirkimas', '1', '$prefix', '9')");
				}
			}
			
			echo "<font color='green'>Raktažodis sėkmingai pridėtas!</font><br />";
			die();
		}
	}
}
?>