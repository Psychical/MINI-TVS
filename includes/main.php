<?php if(!$f_page) die();
	
	echo $unban['1']." <b>$bans1</b><br>".$unban['2']." <b>$unbans1</b><br>".$unban['3']." <b>$ip</b><br>";

	switch($banned1)
	{
		case 0:
		{
			echo $unban['4']." <b><span style='color: green;'>".$unban['6']."</span></b><br><br>";
			break;
		}
		default:
		{	
			echo $unban['4']." <b><span style='color: red;'>".$unban['5']."</span></b><br><br>";
			
			$sms = $mysqli->query("SELECT * FROM `unban_sms_config` WHERE `lang` = '".$sLang."' AND `message_type` = 'unban'");

			if($sms->num_rows)
			{
				$sms_f = $sms->fetch_object();
				$banned_ft = $banned->fetch_object();
				
				switch($sms_f->sms_type)
				{
					case 0: { printf($unban['unban_mokejimai'], $sms_f->key, $banned_ft->bid, $sms_f->number, ($sms_f->price/100), $sms_f->price_type); break; }
					case 1: { printf($unban['unban_vpsnet'], $sms_f->key, $banned_ft->bid, $sms_f->number, ($sms_f->price/100), $sms_f->price_type); break; }
				}
			}
			else
			{
				echo "No SMS services from your country!";
			}
				
			if($makro_type): ?>
				<hr />
				<?php include('./makro_pay/unban.php'); 
			endif;
		}
	}
?>