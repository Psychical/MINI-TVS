<?php
require_once('../config/db_connect.php');
require_once('WebToPay.php');

try 
{
    $response = WebToPay::checkResponse($_POST, array('projectid' => $paysera_projectid, 'sign_password' => $paysera_sign));

	$ip = $response['orderid'];
	
	if($response['amount'] == $paysera_makro_price)
	{
		$tm = $mysqli_amx->query("SELECT * FROM `".$amxbans_prefix."_bans` WHERE `player_ip` = '$ip'");
		$tk = $tm->num_rows;
		
		if($tk)
		{
			$mysqli_amx->query("UPDATE `".$amxbans_prefix."_bans` SET `expired` = '-1' WHERE `player_ip` = '$ip'");
			echo 'OK Aciu';
		}
		else
			echo 'ERROR Zaidejas nerastas.';
	}
}
catch (Exception $e) {
    echo get_class($e).': '.$e->getMessage();
}

?>
