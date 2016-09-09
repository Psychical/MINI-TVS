<?php
include "../config/db_connect.php";
include('../admin/ajax/rcon_hl_net.php');

if(checkTransaction($_GET['vps_transaction'], $_GET['vps_orderid'], $_GET['vps_status'], $_GET['vps_country'], $_GET['vps_sum'], $vpsnet_systems_pass))
{
	$kns = ($_GET['vps_sum']);
	$nr = ($_GET['vps_smsfrom']);
	$key = explode(" ", $_GET['vps_sms']);
	
	$sms_ip = $key[count($key)-1];
	unset($key[count($key)-1]);
	
	$sms_keyword = implode(" ", $key);
	
	$sms = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE (`key` LIKE '%".$sms_keyword."') AND `price` = '".$kns."' AND `message_type` != 'unban'");
	$sms_price = $sms->fetch_object();
	
	if(!strlen($sms_ip))
	{
		echo "error Per trumpas IP adresas!"; //zinutes IP turi buti ilgesnis nei 3 simboliai
	}
	else if($kns == $sms_price->price)
	{
		$result = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_amxadmins` WHERE `username` = '".$sms_ip."' LIMIT 1");
		
		if($result->num_rows)
		{
			$assoc = $result->fetch_object();
			$timeleft = $assoc->timeleft;
			
			$rst = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `name` = '".$sms_price->message_type."' LIMIT 1");
			$rst_v = $rst->fetch_object();
			
			if($rst->num_rows)
			{
				if($assoc->access == $rst_v->priv)
				{
					$timeleft = $assoc->expired + ($sms_price->priv_time * 24 * 60 * 60);
				
					$mysqli_amx->query("UPDATE `".$amxbans_prefix."_amxadmins` SET `expired` = '".$timeleft."', `created` = '".time()."', `nr` = '".$nr."' WHERE `username` = '".$sms_ip."'");
				}
				else
				{
					$timeleft = time() + ($sms_price->priv_time * 24 * 60 * 60);
				
					$mysqli_amx->query("UPDATE `".$amxbans_prefix."_amxadmins` SET `access` = '".$rst_v->priv."', `expired` = '".$timeleft."', `created` = '".time()."', `nr` = '".$nr."' WHERE `username` = '".$sms_ip."'");
				}
				
				echo "OK";
			}
			else
			{
				echo "error Privilegijos nerastos!"; //nerastos privilegijos, kurias norima uþdëti
			}
		}
		else
		{
			$rst = $mysqli->query("SELECT * FROM `unban_order_prvilegies` WHERE `name` = '".$sms_price->message_type."' LIMIT 1");
		
			if($rst->num_rows)
			{
				$rst_v = $rst->fetch_object();
				
				$timeleft = time() + ($sms_price->priv_time * 24 * 60 * 60);
				$mysqli_amx->query("INSERT INTO ".$amxbans_prefix."_amxadmins (`username`, `access`, `flags`, `nickname`, `ashow`, `created`, `expired`, `nr`, `days`, `steamid`) VALUES ('".$sms_ip."', '".$rst_v->priv."', 'de', '".$sms_ip."', '0', '".time()."', '".$timeleft."', '".$response['from']."', '".$sms_price->priv_time."', '".$sms_ip."') ");
				$lastid = $mysqli_amx->insert_id;

				if($mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_admins_servers`"))
				{
					while($row = $servers_lst->fetch_object())
					{						
						$local_ips = gethostbyname($row->ip).":".$row->port;
						$result = $mysqli_amx->query("SELECT * FROM `amx_serverinfo` WHERE `address` = '".$local_ips."' LIMIT 1");
						
						if($result->num_rows)
						{
							$ftch = $result->fetch_object();
							
							$mysqli_amx->query("INSERT INTO `".$amxbans_prefix."_admins_servers` (`admin_id`, `server_id`, `use_static_bantime`) VALUES ('".$lastid."', '".$ftch->id."', 'no')");
						}
					}
				}
				
				echo "OK";
			}
			else
			{
				echo "error Nerasots privilegijos!"; //nerastos privilegiju tipas
			}
		}
		//reload_admins($mysqli_amx);
	}
}
else {
	echo "error Kreiptasi ne is VPSNET!"; // Á failà kreiptasi ne ið vpsnet.lt serverio
}

function checkTransaction( $transaction, $orderid, $status, $country, $sum, $v_k_p)
{
	$t = md5("{$v_k_p}|{".$_SERVER['REMOTE_ADDR']."}|{$orderid}|{$status}|{$country}|{$sum}");
	if($transaction == $t)
	{
		return true;
	}
	return false;
}
?>