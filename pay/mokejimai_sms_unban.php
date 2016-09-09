<?php
require_once('mokejimai_webtopay.php');
include "../config/db_connect.php";
 
$get = removeQuotes($_POST);

try
{
	$response = WebToPay::validateAndParseData($get, $paysera_projectid, $paysera_sign);

	$kns = ($response['amount']);
	
	$sms = strlen($response['key']);
	$sms_pId = substr($response['sms'], $sms+1);
	
	$sms = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `key` = '".$response['key']."' AND `price` = '$kns' AND `message_type` = 'unban'");
	
	if($sms->num_rows)
	{
		$sms_price = $sms->fetch_object();
		
		if($kns == $sms_price->price)
		{
			$result = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_bans` WHERE `bid` = '".$sms_pId."' LIMIT 1");
			$row = $result->num_rows;

			if(empty($sms_pId))
			{
				echo $ok."Jus neivedete ID!";
				exit();
			}
			else if($row)
			{
				$mysqli_amx->query("UPDATE `".$amxbans_prefix."_bans` SET `expired` = '1' WHERE `bid` = '".$sms_pId."'");
				echo $ok.$unbanned;
			} 
			else 
			{
				echo $ok.$no_ban_exist;
			}
		}
	}
	else
		echo "OK Kazkas ne taip!";
}
catch (Exception $e) {
    echo get_class($e).': '.$e->getMessage();
}

function removeQuotes($post) {
    if (get_magic_quotes_gpc()) {
        foreach ($post as &$var) {
            if (is_array($var)) {
                $var = removeQuotes($var);
            } else {
                $var = stripslashes($var);
            }
        }
    }
    return $post;
}
?>