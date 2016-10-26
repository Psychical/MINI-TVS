<?php
include('../../config/db_connect.php');
require_once('WebToPay.php');

try
{
    $response = WebToPay::checkResponse($_POST, array('projectid' => $paysera_projectid, 'sign_password' => $paysera_sign,));

    $clientIp = $response['orderid'];
    $orderPrice = $response['amount'];
    $clientPrivileges = $response['privileges'];
    $clientPassword = $response['password'];
	
	$result = $mysqli->query("SELECT * FROM `unban_makro_types` WHERE `priv_type` = '".$clientPrivileges."' AND `price` = '".$orderPrice."'");
	
	if($result->num_rows)
	{
		$result2 = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_amxadmins` WHERE `username` = '".$clientIp."'");
		$ftc = $result->fetch_object();
		
		$flags = (filter_var($clientIp, FILTER_VALIDATE_IP) ? "de" : (preg_match("/^STEAM_0:[01]:[0-9]{6,10}$/", $clientIp) ? "ce" : "a"));
		$expired = strtotime("+".$ftc->lenght." day");
		
		if($result2->num_rows)
		{
			$mysqli_amx->query("UPDATE `".$amxbans_prefix."_amxadmins` SET `access` = '".get_acces_makro($mysqli, $clientPrivileges)."', `created` = '".time()."', `expired` = '".$expired."', `days` = '".$ftc->lenght."' WHERE `username` = '".$clientIp."'");
			
			echo 'OK Privilegijos pratestos.';
		}
		else
		{
			$mysqli_amx->query("INSERT INTO ".$amxbans_prefix."_amxadmins (`username`, `password`, `access`, `flags`, `nickname`, `ashow`, `created`, `expired`, `days`, `steamid`) VALUES ('".$clientIp."', '".$clientPassword."', '".get_acces_makro($mysqli, $clientPrivileges)."', '".$flags."', '".$clientIp."', '0', '".time()."', '".$expired."', '".$ftc->lenght."', '".$clientIp."') ");
			$lastid = $mysqli_amx->insert_id;
			
			echo 'OK Privilegijos uzsakytos.';
			
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
			
		}
	}
	else
	    echo 'OK Klaida.';
}
catch (Exception $e) {
    echo get_class($e).':'.$e->getMessage();
} ?>
