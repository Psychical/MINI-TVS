<?php
require_once('mokejimai_webtopay.php');
require_once('geoiploc.php');

include('../config/db_connect.php');
include('../admin/ajax/rcon_hl_net.php');

$get = removeQuotes($_POST);

try
{
	$response = WebToPay::validateAndParseData($get, $projectid, $sign_pass);
	$kns = ($response['amount']);
	
	$sms = strlen($response['key']);
	$sms_ip = substr($response['sms'], $sms+1);
	
	$sms = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `key` = '".$response['key']."' AND `price` = '".$kns."' AND `message_type` != 'unban'");
	$sms_price = $sms->fetch_object();
	
	if($kns == $sms_price->price)
	{
		$result = $mysqli_amx->query("SELECT * FROM `".$prefix."_amxadmins` WHERE `username` = '".$sms_ip."' LIMIT 1");
		
		if($result->num_rows)
		{
			$assoc = $result->fetch_object();
			
			$rst = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `name` = '".$sms_price->message_type."' LIMIT 1");
			$rst_v = $rst->fetch_object();
			
			if($rst->num_rows)
			{
				if($assoc->access == $rst_v->priv)
				{
					$time = strtotime($assoc->timeleft)+(24*60*60*$sms_price->priv_time);
					$timeleft = date("Y-m-d", $time);
			
					$mysqli_amx->query("UPDATE `".$prefix."_amxadmins` SET `timeleft` = '".$timeleft."', `nr` = '".$response['from']."' WHERE `username` = '".$sms_ip."' ");
				}
				else
				{
					$time = (24*60*60*$sms_price->priv_time);
					$timeleft = date("Y-m-d", $time);
			
					$mysqli_amx->query("UPDATE `".$prefix."_amxadmins` SET `access` = '".$rst_v->priv."' `timeleft` = '".$timeleft."', `regtime` = '".$kada."', `nr` = '".$response['from']."' WHERE `username` = '".$sms_ip."' ");
				}
				
				if(getCountryFromIP($sms_ip, "code") != "LT")
					echo "OK Your privilegies has been extended.";
				else
					echo "OK Jusu privilegijos buvo sekmingai pratestos.";
			}
			else
			{
				if(getCountryFromIP($sms_ip, "code") != "LT")
					echo "OK Somethings wrong. Can not update.";
				else
					echo "OK Kazkas ne taip. Negali atnaujinti.";
			}
	}
	else
	{
			$rst = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `name` = '".$sms_price->message_type."' LIMIT 1");
		
			if($rst->num_rows)
			{
				$rst_v = $rst->fetch_object();
				
				$timeleft = date("Y-m-d", strtotime("+".$sms_price->priv_time." days"));
				$mysqli_amx->query("INSERT INTO ".$prefix."_amxadmins (`username`, `access`, `flags`, `nickname`, `regtime`, `timeleft`, `nupirko`, `nr`) VALUES ('".$sms_ip."', '".$rst_v->priv."', 'de', '".$sms_ip."', '$kada', '$timeleft', '1', '".$response['from']."') ");
				
				if(getCountryFromIP($sms_ip, "code") != "LT")
					echo "OK Your privilegies has been activated.";
				else
					echo "OK Jusu privilegijos buvo sekmingai aktyvuotas.";
			}
			else
			{
				if(getCountryFromIP($sms_ip, "code") != "LT")
					echo "OK Somethings wrong. Can not instert.";
				else
					echo "OK Kazkas ne taip. Negali irasyti.";
			}
		}
		reload_admins($mysqli_amx);
	}
	else
	{
		if(getCountryFromIP($sms_ip, "code") == "LT")
			echo "OK Kazkas ne taip. 3";
		else
			echo "OK Somethings wrong. 3";
	}
}

catch (Exception $e) {
    echo get_class($e).': '.$e->getMessage();
}

function removeQuotes($post)
{
    if (get_magic_quotes_gpc())
	{
		foreach ($post as &$var)
		{
			if (is_array($var))
			{
				$var = removeQuotes($var);
			}
			else
			{
				$var = stripslashes($var);
			}
		}
    }
    return $post;
}
?>