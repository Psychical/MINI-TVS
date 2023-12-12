<?php
include "../config/db_connect.php";


if(checkTransaction($_GET['vps_transaction'], $_GET['vps_orderid'], $_GET['vps_status'], $_GET['vps_country'], $_GET['vps_sum'], $vpsnet_systems_pass))
{	
	$kns = ($_GET['vps_sum']);
	$key = explode(" ", $_GET['vps_sms']);

	$sms_pId = $key[count($key)-1];
	unset($key[count($key)-1]);
	
	$sms_keyword = implode(" ", $key);
	
	$sms = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE (`key` LIKE '%".$sms_keyword."') AND `price` = '".$kns."'");
	$sms_price = $sms->fetch_object();
	
	if($kns == $sms_price->price)
	{	
		$result = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_bans` WHERE `bid` = '".$sms_pId."' LIMIT 1");
		$row = $result->num_rows;

		if(empty($sms_pId))
		{
			echo "error"; // Neávestas ID
			exit();
		}
		else if($row)
		{
			$mysqli_amx->query("UPDATE `".$amxbans_prefix."_bans` SET `expired` = '1' WHERE `bid` = '".$sms_pId."'");
			print "OK";
		} 
		else 
		{
			array($result);
			echo "error"; // Nëra tokio id sistemoje
		}
	}
}
else
	echo "error"; // Á failà kreiptasi ne ið vpsnet.lt serverio

function getKey($smsPrice, $keyword)
{
	$sReturn = "";
	
	switch($smsPrice)
	{
		case 29: { $sReturn = "VPSNET1 ".$keyword; break; }
		case 58: { $sReturn = "VPSNET2 ".$keyword; break; }
		case 87: { $sReturn = "VPSNET3 ".$keyword; break; }
		case 116: { $sReturn = "VPSNET4 ".$keyword; break; }
		case 145: { $sReturn = "VPSNET5 ".$keyword; break; }
		case 174: { $sReturn = "VPSNET6 ".$keyword; break; }
		case 203: { $sReturn = "VPSNET7 ".$keyword; break; }
		case 232: { $sReturn = "VPSNET8 ".$keyword; break; }
		case 261: { $sReturn = "VPSNET9 ".$keyword; break; }
		case 290: { $sReturn = "VPSNET10 ".$keyword; break; }
		case 319: { $sReturn = "VPSNET11 ".$keyword; break; }
		case 348: { $sReturn = "VPSNET12 ".$keyword; break; }
		case 377: { $sReturn = "VPSNET13 ".$keyword; break; }
		case 405: { $sReturn = "VPSNET14 ".$keyword; break; }
		case 434: { $sReturn = "VPSNET15 ".$keyword; break; }
		case 579: { $sReturn = "VPSNET20 ".$keyword; break; }
		case 724: { $sReturn = "VPSNET25 ".$keyword; break; }
		case 869: { $sReturn = "VPSNET35 ".$keyword; break; }
	}
	return $sReturn;
}

function checkTransaction( $transaction, $orderid, $status, $country, $sum, $v_k_p)
{
	$t = hash("sha256", "{$v_k_p}|{".$_SERVER['REMOTE_ADDR']."}|{$orderid}|{$status}|{$country}|{$sum}", false);
	if($transaction == $t) return true;
	return false;
}
?>
