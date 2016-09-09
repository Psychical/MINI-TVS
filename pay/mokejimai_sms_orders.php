<?php
require_once('mokejimai_webtopay.php');
require_once('geoiploc.php');

include('../config/db_connect.php');
include('../admin/ajax/rcon_hl_net.php');

$get = removeQuotes($_POST);

try
{
	$response = WebToPay::validateAndParseData($get, $paysera_projectid, $paysera_sign);
	$kns = ($response['amount']);
       
	$sms = strlen($response['key']);
	$sms_ip = substr($response['sms'], $sms+1);
	
	$sms = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `key` = '".$response['key']."' AND `price` = '".$kns."' AND `message_type` != 'unban'");
	$sms_price = $sms->fetch_object();

	if(strlen($sms_ip) < 3)
	{
		echo "OK Zinuteje irasytas IP adresas per trumpas!"; //zinutes IP turi buti ilgesnis nei 3 simboliai
	}
	else if($kns == $sms_price->price)
	{
		$result = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_amxadmins` WHERE `username` = '".$sms_ip."' LIMIT 1");
		
		if($result->num_rows)
		{
			$assoc = $result->fetch_object();
			
			$rst = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `name` = '".$sms_price->message_type."' LIMIT 1");
			$rst_v = $rst->fetch_object();
			
			if($rst->num_rows)
			{
				if($assoc->access == $rst_v->priv)
				{
					$timeleft = $assoc->expired + ($sms_price->priv_time * 24 * 60 * 60);
				
					$mysqli_amx->query("UPDATE `".$amxbans_prefix."_amxadmins` SET `expired` = '".$timeleft."', `created` = '".time()."', `nr` = '".$response['from']."' WHERE `username` = '".$sms_ip."'");
				
					if(getCountryFromIP($sms_ip, "code") != "LT")
						echo "OK Your privilegies has been extended.";
					else
						echo "OK Jusu privilegijos buvo sekmingai pratestos.";
				}
				else
				{
					$timeleft = time() + ($sms_price->priv_time * 24 * 60 * 60);
				
					$mysqli_amx->query("UPDATE `".$amxbans_prefix."_amxadmins` SET `access` = '".$rst_v->priv."', `expired` = '".$timeleft."', `created` = '".time()."', `nr` = '".$response['from']."' WHERE `username` = '".$sms_ip."'");
				
					if(getCountryFromIP($sms_ip, "code") != "LT")
						echo "OK Your privilegies has been activated.";
					else
						echo "OK Jusu privilegijos buvo sekmingai aktyvuotas.";
				}
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
				
				$timeleft = time() + ($sms_price->priv_time * 24 * 60 * 60);
				
				if(filter_var($sms_ip, FILTER_VALIDATE_IP))
				{
					$mysqli_amx->query("INSERT INTO ".$amxbans_prefix."_amxadmins (`username`, `access`, `flags`, `nickname`, `ashow`, `created`, `expired`, `nr`, `days`, `steamid`) VALUES ('".$sms_ip."', '".$rst_v->priv."', 'de', '".$sms_ip."', '0', '".time()."', '".$timeleft."', '".$response['from']."', '".$sms_price->priv_time."', '".$sms_ip."') ");
				}
				else
				{
					$password_set = randomPassword(6);
					$mysqli_amx->query("INSERT INTO ".$amxbans_prefix."_amxadmins (`username`, `password`, `access`, `flags`, `nickname`, `ashow`, `created`, `expired`, `nr`, `days`, `steamid`) VALUES ('".$sms_ip."', '".$password_set."', '".$rst_v->priv."', 'a', '".$sms_ip."', '0', '".time()."', '".$timeleft."', '".$response['from']."', '".$sms_price->priv_time."', '".$sms_ip."') ");
				}
				
				if($mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_admins_servers`"))
				{
					sleep(1);
					
					while($row = $servers_lst->fetch_object())
					{						
						$local_ips = gethostbyname($row->ip).":".$row->port;
						
						$result2 = $mysqli_amx->query("SELECT * FROM `amx_serverinfo` WHERE `address` = '".$local_ips."' LIMIT 1");
						
						if($result2->num_rows)
						{
							$result = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_amxadmins` WHERE `username` = '".$sms_ip."' LIMIT 1");
							$ft = $result->fetch_object();
							$ft2 = $result2->fetch_object();
							
							$mysqli_amx->query("INSERT INTO `".$amxbans_prefix."_admins_servers` (`admin_id`, `server_id`, `use_static_bantime`) VALUES ('".$ft->id."', '".$ft2->id."', 'no')");
						}
					}
				}
				
				if(filter_var($sms_ip, FILTER_VALIDATE_IP)) {
					echo "OK Jusu privilegijos ant IP (".$sms_ip.") buvo sekmingai aktyvuotos.";
				}
				else {
					echo "OK Jusu privilegijos ant NICK (".$sms_ip.") buvo sekmingai aktyvuotos. Jusu prisijungimo slaptazodis: ".$password_set;
				}
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